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
    public function removeBackground($imageFile, $normalizeForAi = false)
        {
            $apiKey = env('PHOTOROOM_API_KEY');
            $normalizedPath = null;

            try {
                $sendPath = $imageFile->getRealPath();
                $sendName = $imageFile->getClientOriginalName();

                if ($normalizeForAi) {
                    $normalizedPath = $this->makeSquareContainImageForAi($imageFile);
                    $sendPath = $normalizedPath;
                    $sendName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME) . '_ai.png';
                }

                $response = Http::withHeaders([
                    'x-api-key' => $apiKey,
                ])->attach(
                    'image_file',
                    file_get_contents($sendPath),
                    $sendName
                )->post('https://sdk.photoroom.com/v1/segment', [
                    'background.color' => 'transparent',
                    'format' => 'png',
                    'scaling' => 'fill', 
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
            } finally {
                if ($normalizedPath && is_file($normalizedPath)) {
                    @unlink($normalizedPath);
                }
            }
        }

        private function makeSquareContainImageForAi($imageFile, $maxWidth = 1000)
    {
        $sourceContent = file_get_contents($imageFile->getRealPath());
        $source = imagecreatefromstring($sourceContent);

        if (!$source) {
            throw new \Exception('서버 이미지 정규화 실패: 이미지를 읽을 수 없습니다.');
        }

        $source = $this->fixJpegOrientation($source, $imageFile->getRealPath(), $imageFile->getMimeType());

        $width = imagesx($source);
        $height = imagesy($source);

        $cropTop = 0;
        $cropBottom = $height - 1;

        while ($cropTop < $height && $this->isSolidRow($source, $width, $cropTop)) {
            $cropTop++;
        }

        while ($cropBottom > $cropTop && $this->isSolidRow($source, $width, $cropBottom)) {
            $cropBottom--;
        }

        $cropLeft = 0;
        $cropW = $width;
        $cropH = $cropBottom - $cropTop + 1;

        if ($cropH < $height * 0.5) {
            $cropTop = 0;
            $cropH = $height;
        }

        $canvas = imagecreatetruecolor($maxWidth, $maxWidth);
        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);

        $transparent = imagecolorallocatealpha($canvas, 255, 255, 255, 127);
        imagefilledrectangle($canvas, 0, 0, $maxWidth, $maxWidth, $transparent);

        $scale = min($maxWidth / $cropW, $maxWidth / $cropH);
        $targetW = (int) round($cropW * $scale);
        $targetH = (int) round($cropH * $scale);
        $targetX = (int) round(($maxWidth - $targetW) / 2);
        $targetY = (int) round(($maxWidth - $targetH) / 2);

        imagecopyresampled(
            $canvas,
            $source,
            $targetX,
            $targetY,
            $cropLeft,
            $cropTop,
            $targetW,
            $targetH,
            $cropW,
            $cropH
        );

        $tempPath = tempnam(storage_path('app'), 'ai_norm_');
        imagepng($canvas, $tempPath);

        imagedestroy($source);
        imagedestroy($canvas);

        return $tempPath;
    }

    private function isSolidRow($image, $width, $y)
    {
        $sample = $this->rgbAt($image, (int) floor($width / 2), $y);
        $similarCount = 0;
        $totalCount = 0;

        for ($x = 0; $x < $width; $x += 4) {
            $pixel = $this->rgbAt($image, $x, $y);

            if ($this->colorDistance($sample, $pixel) < 35) {
                $similarCount++;
            }

            $totalCount++;
        }

        return $totalCount > 0 && ($similarCount / $totalCount) > 0.96;
    }

    private function rgbAt($image, $x, $y)
    {
        $rgb = imagecolorat($image, $x, $y);

        return [
            ($rgb >> 16) & 0xFF,
            ($rgb >> 8) & 0xFF,
            $rgb & 0xFF,
        ];
    }

    private function colorDistance($a, $b)
    {
        return abs($a[0] - $b[0]) + abs($a[1] - $b[1]) + abs($a[2] - $b[2]);
    }

    private function fixJpegOrientation($image, $path, $mime)
    {
        if ($mime !== 'image/jpeg' || !function_exists('exif_read_data')) {
            return $image;
        }

        $exif = @exif_read_data($path);

        if (!$exif || empty($exif['Orientation'])) {
            return $image;
        }

        switch ((int) $exif['Orientation']) {
            case 3:
                return imagerotate($image, 180, 0);
            case 6:
                return imagerotate($image, -90, 0);
            case 8:
                return imagerotate($image, 90, 0);
            default:
                return $image;
        }
    }
    /**
     * [Flow 2] Google Gemini를 사용하여 배경 합성 (직접 호출)
     */
    public function generateBackground($nobgPath, $prompt)
    {
        try {

            if (!Storage::disk('public')->exists($nobgPath)) {
                throw new Exception("1단계 처리된 파일({$nobgPath})을 찾을 수 없습니다.");
            }
            
            $fileSize = Storage::disk('public')->size($nobgPath);
            Log::info("Step 2 Start. Input File Path: {$nobgPath}");
            Log::info("Step 2 Input File Size: " . number_format($fileSize) . " bytes");

            Log::info("Gemini Prompt: " . $prompt);


            $imageContent = Storage::disk('public')->get($nobgPath);
            $base64Data = base64_encode($imageContent);
            $mimeType = 'image/png'; 

            $finalPrompt = "You are an expert product photographer. " .
                "Create a sharp realistic square 1:1 product image. " .
                "Identify the selected product as the largest main furniture item near the center of the input image. " .
                "Treat ONLY this selected main furniture item as the foreground product. " .
                "Do NOT redraw, alter, rotate, resize, crop, or distort the selected product furniture. " .
                "Keep the original camera angle, perspective, product position, and product scale exactly the same. " .
                "Keep the entire selected furniture fully visible inside the frame with natural margin around it. " .
                "Preserve only the selected product furniture's original texture, shape, color, material, edges, and details. " .
                "Ignore and remove any black letterbox bars, empty margins, transparent bands, or blurred border areas from the input image. " .
                "Fill the entire image frame edge-to-edge with a sharp realistic interior background. " .
                "Generate a clean, fully detailed background across all four corners and all image edges. " .
                "Do not create blurred corners, smeared colors, color bleeding, vignette edges, haze, soft border extensions, or stretched background artifacts. " .
                "Do not leave transparent areas, empty bands, faded edges, or low-detail corner regions. " .
                "Do NOT preserve unrelated objects around the edges of the original photo. " .
                "Remove and replace side tables, papers, chairs, plants, wall posters, showroom clutter, partial furniture, and any objects cut off by the image border unless they are the selected product itself. " .
                "Only generate a background environment of [{$prompt}] around and behind the selected product furniture. " .
                "The selected product furniture must remain unchanged. " .
                "Output only the image. No text description.";

            $resultImageData = $this->callGeminiApi($base64Data, $mimeType, $finalPrompt);

            $timestamp = time();
            $rand = mt_rand(1000, 9999);
            $fileName = "final_{$timestamp}_{$rand}.png";
            
            $savedPath = "ai-lab/{$fileName}";

            Storage::disk('public')->put($savedPath, base64_decode($resultImageData));

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
        //$modelName = 'gemini-3.1-flash-image-preview';
        $modelName = 'gemini-2.5-flash-image'; 
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
                    //'maxOutputTokens' 
                    //'responseMimeType' 
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

            if (isset($part['inlineData']['data'])) {
                return $part['inlineData']['data'];
            }

            if (isset($part['text'])) {
                $textResponse .= $part['text'];
            }
        }

        // 텍스트로 에러 메시지가 왔는지 확인
        $textResponse = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;
        if ($textResponse) {
            throw new Exception("이미지가 생성되지 않았습니다 (텍스트 응답): {$textResponse}");
        }


        throw new Exception("Google API 응답에서 이미지 데이터를 찾을 수 없습니다.");
    }
}