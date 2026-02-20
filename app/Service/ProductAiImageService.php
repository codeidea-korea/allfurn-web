<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Exception;

class ProductAiImageService
{
    private $stabilityApiKey;
    private $googleApiKey;
    private $client;

    // 생성자: API 키를 로드하고 HTTP 클라이언트(Guzzle)를 초기화합니다.
    public function __construct()
    {
        $this->stabilityApiKey = env('STABILITY_API_KEY');
        $this->googleApiKey = env('GOOGLE_API_KEY');
        $this->client = new Client();
    }

    /**
     * [Flow 1] Stability AI를 사용하여 배경 제거 (직접 호출)
     */
    public function removeBackground($imageFile)
    {
        $apiKey = $this->stabilityApiKey;

        if (!$apiKey) {
            throw new Exception("Stability AI API 키가 설정되지 않았습니다.");
        }

        try {
            // 1. API 요청
            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Accept'        => 'image/*'
            ])->attach(
                'image', 
                file_get_contents($imageFile->getRealPath()), 
                $imageFile->getClientOriginalName()
            )->post('https://api.stability.ai/v2beta/stable-image/edit/remove-background', [
                'output_format' => 'png'
            ]);

            if ($response->successful()) {
                $imageContent = $response->body();
                
                // [수정 포인트 1] 파일명 생성
                $timestamp = time();
                $rand = mt_rand(1000, 9999);
                $fileName = "nobg_{$timestamp}_{$rand}.png";
                
                // [수정 포인트 2] 경로에서 'public/' 제거 (ai-lab 폴더에 바로 저장)
                $path = "ai-lab/{$fileName}"; 
                
                // [수정 포인트 3] 'public' 디스크를 명시적으로 사용
                // 실제 저장 위치: storage/app/public/ai-lab/파일명.png
                Storage::disk('public')->put($path, $imageContent);

                // [수정 포인트 4] URL 생성
                // 생성된 URL: /storage/ai-lab/파일명.png (public 중복 없음)
                return [
                    'url' => '/storage/' . $path,
                    'file_path' => $path 
                ];
            } else {
                $errorBody = $response->json();
                Log::error('Stability RemoveBG Error: ' . json_encode($errorBody));
                throw new Exception("배경 제거 실패: " . ($errorBody['errors'][0]['message'] ?? 'API 호출 오류'));
            }

        } catch (Exception $e) {
            Log::error("ProductAiImageService (RemoveBG) Exception: " . $e->getMessage());
            throw $e;
        }
    }
    /**
     * [Flow 2] Google Gemini를 사용하여 배경 합성 (직접 호출)
     */
    public function generateBackground($nobgPath, $prompt)
    {
        try {
            // [수정 1] 'public' 디스크 명시
            // 1단계에서 저장한 경로(ai-lab/...)를 public 디스크에서 찾아야 함
            if (!Storage::disk('public')->exists($nobgPath)) {
                throw new Exception("1단계 처리된 파일({$nobgPath})을 찾을 수 없습니다.");
            }
            

            // [디버깅 1] 파일 크기 로그 (너무 크거나 작으면 의심)
            $fileSize = Storage::disk('public')->size($nobgPath);
            Log::info("Step 2 Start. Input File Path: {$nobgPath}");
            Log::info("Step 2 Input File Size: " . number_format($fileSize) . " bytes");

            // [디버깅 2] ★핵심★ 입력 파일을 '눈으로 확인 가능한 위치'에 복사
            // 브라우저에서 http://도메인/storage/debug_check.png 로 접속하면 
            // Gemini가 받은 이미지가 '투명 배경'인지 '원본'인지 바로 볼 수 있습니다.
            //Storage::disk('public')->copy($nobgPath, 'debug_check.png');
            //Log::info("Debug Check: Copied input file to 'storage/app/public/debug_check.png' for manual inspection.");

            // [디버깅 3] 프롬프트 확인
            Log::info("Gemini Prompt: " . $prompt);



            // 2. 이미지 데이터 읽기 (public 디스크에서)
            $imageContent = Storage::disk('public')->get($nobgPath);
            $base64Data = base64_encode($imageContent);
            $mimeType = 'image/png'; 

            // 3. Gemini용 프롬프트 구성
            /*$finalPrompt = "This image has a transparent background. " .
                           "Place the foreground furniture into a [{$prompt}]. " .
                           "Ensure realistic lighting, shadows, and reflections on the furniture. " .
                           "Do not change the shape of the furniture.";*/

            $finalPrompt = "You are an expert product photographer. " .
               "Do NOT redraw, alter, or distort the foreground furniture. " .
               "Keep the foreground object EXACTLY as provided in the input image, preserving its original texture, shape, color, and details. " .
               "Only generate a background environment of [{$prompt}] behind the object. " .
               "The object must remain unchanged." .
               "Output only the image. No text description.";

            // 4. Gemini API 호출
            $resultImageData = $this->callGeminiApi($base64Data, $mimeType, $finalPrompt);

            // 5. 최종 결과 저장
            $timestamp = time();
            $rand = mt_rand(1000, 9999);
            $fileName = "final_{$timestamp}_{$rand}.png";
            
            // [수정 2] 저장 경로 설정 (ai-lab 폴더에 바로 저장)
            $savedPath = "ai-lab/{$fileName}";

            // [수정 3] public 디스크에 저장
            Storage::disk('public')->put($savedPath, base64_decode($resultImageData));

            // [수정 4] URL 반환 (도메인 문제 방지를 위한 상대 경로 사용)
            return '/storage/' . $savedPath;

        } catch (Exception $e) {
            Log::error("ProductAiImageService (GenerateBG) Error: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * [Private] Gemini API 호출 로직 (직접 구현)
     */
    private function callGeminiApi($base64Data, $mimeType, $prompt)
    {
        $modelName = 'gemini-2.5-flash-image'; // 또는 'gemini-1.5-flash' 등 사용 가능한 모델명
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$modelName}:generateContent?key={$this->googleApiKey}";

        $response = $this->client->post($url, [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'contents' => [[
                    'parts' => [
                        ['text' => $prompt],
                        ['inlineData' => [
                            'mimeType' => $mimeType,
                            'data'     => $base64Data
                        ]]
                    ]
                ]],
                'generationConfig' => [
                    'temperature' => 0.0,
                    //'maxOutputTokens' => 4096, // 필요 시 주석 해제
                    //'responseMimeType' => 'image/png' // 이미지 생성을 명시 (일부 모델 지원)
                ]
            ],
            'http_errors' => false
        ]);

        $contents = $response->getBody()->getContents();
        $result = json_decode($contents, true);
        $statusCode = $response->getStatusCode();

        // 에러 처리
        if ($statusCode >= 400) {
            $msg = $result['error']['message'] ?? 'Unknown API Error';
            throw new Exception("Google API Error ({$statusCode}): {$msg}");
        }

        // 데이터 추출 (inlineData 구조 확인)
        if (isset($result['candidates'][0]['content']['parts'][0]['inlineData']['data'])) {
            return $result['candidates'][0]['content']['parts'][0]['inlineData']['data'];
        }

        // 텍스트로 에러 메시지가 왔는지 확인
        $textResponse = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;
        if ($textResponse) {
            throw new Exception("이미지가 생성되지 않았습니다 (텍스트 응답): {$textResponse}");
        }

        throw new Exception("Google API 응답에서 이미지 데이터를 찾을 수 없습니다.");
    }
}