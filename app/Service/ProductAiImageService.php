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
    // public function removeBackground($imageFile)
    // {
    //     $apiKey = $this->stabilityApiKey;

    //     if (!$apiKey) {
    //         throw new Exception("Stability AI API 키가 설정되지 않았습니다.");
    //     }

    //     try {
    //         // 1. API 요청
    //         $response = Http::withoutVerifying()->withHeaders([
    //             'Authorization' => 'Bearer ' . $apiKey,
    //             'Accept'        => 'image/*'
    //         ])->attach(
    //             'image', 
    //             file_get_contents($imageFile->getRealPath()), 
    //             $imageFile->getClientOriginalName()
    //         )->post('https://api.stability.ai/v2beta/stable-image/edit/remove-background', [
    //             'output_format' => 'png'
    //         ]);

    //         if ($response->successful()) {
    //             $imageContent = $response->body();
                
    //             // [수정 포인트 1] 파일명 생성
    //             $timestamp = time();
    //             $rand = mt_rand(1000, 9999);
    //             $fileName = "nobg_{$timestamp}_{$rand}.png";
                
    //             // [수정 포인트 2] 경로에서 'public/' 제거 (ai-lab 폴더에 바로 저장)
    //             $path = "ai-lab/{$fileName}"; 
                
    //             // [수정 포인트 3] 'public' 디스크를 명시적으로 사용
    //             // 실제 저장 위치: storage/app/public/ai-lab/파일명.png
    //             Storage::disk('public')->put($path, $imageContent);

    //             // [수정 포인트 4] URL 생성
    //             // 생성된 URL: /storage/ai-lab/파일명.png (public 중복 없음)
    //             return [
    //                 'url' => '/storage/' . $path,
    //                 'file_path' => $path 
    //             ];
    //         } else {
    //             $status = $response->status();
    //             $rawBody = $response->body();
    //             $errorBody = $response->json();

    //             // 2. 로그에 아주 상세하게 기록합니다. (식별하기 쉽게 구분선 추가)
    //             Log::error("======= Stability API 호출 실패 =======");
    //             Log::error("HTTP 상태 코드: " . $status);
    //             Log::error("원본 응답 내용: " . $rawBody);
    //             Log::error("디코딩된 에러: " . json_encode($errorBody, JSON_UNESCAPED_UNICODE));
    //             Log::error("======================================");

    //             // 3. 예외 메시지에 상태 코드를 포함하여 프론트에서도 대략적인 원인을 알 수 있게 합니다.
    //             $serverMessage = $errorBody['errors'][0]['message'] ?? ($errorBody['message'] ?? '상세 메시지 없음');
                
    //             throw new Exception("Stability API 오류({$status}): " . $serverMessage);
    //         }

    //     } catch (Exception $e) {
    //         Log::error("ProductAiImageService (RemoveBG) Exception: " . $e->getMessage());
    //         throw $e;
    //     }
    // }
    public function removeBackground($imageFile)
    {
        $apiKey = env('PHOTOROOM_API_KEY');

        try {
            // Photoroom API 호출
            $response = Http::withHeaders([
                'x-api-key' => $apiKey,
            ])->attach(
                'image_file', // Photoroom은 파라미터명이 image_file입니다.
                file_get_contents($imageFile->getRealPath()),
                $imageFile->getClientOriginalName()
            )->post('https://sdk.photoroom.com/v1/segment', [
                // 가구 누끼의 핵심: 배경은 지우되, 바닥 그림자는 자연스럽게 남깁니다.
                'background.color' => 'transparent',
                'format' => 'png',
                'scaling' => 'fill', // 가구가 잘리지 않게 꽉 채웁니다.
            ]);

            if ($response->successful()) {
                $imageContent = $response->body();
                $fileName = "photoroom_" . time() . "_" . mt_rand(1000, 9999) . ".png";
                $path = "ai-lab/{$fileName}";

                Storage::disk('public')->put($path, $imageContent);

                return [
                    'url' => '/storage/' . $path,
                    'file_path' => $path
                ];
            } else {
                throw new \Exception("Photoroom API Error: " . $response->status());
            }
        } catch (\Exception $e) {
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

            Log::info("Gemini Prompt: " . $prompt);

            // 2. 이미지 데이터 읽기 (public 디스크에서)
            $imageContent = Storage::disk('public')->get($nobgPath);
            $base64Data = base64_encode($imageContent);
            $mimeType = 'image/png'; 


            $finalPrompt = "You are an expert product photographer. " .
                "Identify the selected product as the largest main furniture item near the center of the input image. " .
                "Treat ONLY this selected main furniture item as the foreground product. " .
                "Do NOT redraw, alter, rotate, or distort the selected product furniture. " .
                "Keep the original camera angle, perspective, product position, and product scale exactly the same. " .
                "Preserve only the selected product furniture's original texture, shape, color, material, edges, and details. " .
                "Ignore and remove any black letterbox bars, empty margins, transparent bands, or blurred border areas from the input image. " .
                "Fill the entire image frame edge-to-edge with a sharp realistic interior background. " .
                "Do not create blurred top or bottom bands, vignette edges, haze, or soft border extensions. " .
                "Do NOT preserve unrelated objects around the edges of the original photo. " .
                "Remove and replace side tables, papers, chairs, plants, wall posters, showroom clutter, partial furniture, and any objects cut off by the image border unless they are the selected product itself. " .
                "Only generate a background environment of [{$prompt}] around and behind the selected product furniture. " .
                "The selected product furniture must remain unchanged. " .
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

        $parts = $result['candidates'][0]['content']['parts'] ?? [];
        $textResponse = '';

        foreach ($parts as $part) {
            // 순서에 상관없이 이미지 데이터(inlineData)가 발견되면 즉시 반환
            if (isset($part['inlineData']['data'])) {
                return $part['inlineData']['data'];
            }
            // 텍스트가 있다면 (백틱이나 부연설명 등) 모아둡니다.
            if (isset($part['text'])) {
                $textResponse .= $part['text'];
            }
        }

        // 3. 이미지를 못 찾았는데 텍스트 응답이라도 있는 경우 (거절 사유 등)
        if ($textResponse) {
            throw new Exception("이미지가 생성되지 않았습니다 (텍스트 응답): {$textResponse}");
        }


        throw new Exception("Google API 응답에서 이미지 데이터를 찾을 수 없습니다.");
    }
}