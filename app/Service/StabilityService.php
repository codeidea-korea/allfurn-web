<?php

namespace App\Service;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Exception;

class StabilityService
{
    private $apiKey;
    private $apiBaseUrl = 'https://api.stability.ai/v2beta';
    private $client;

    public function __construct()
    {
        $this->apiKey = env('STABILITY_API_KEY');
        $this->client = new Client(); // Guzzle 클라이언트 초기화
    }

    /**
     * 배경 제거 (Step 1)
     * @return string 저장된 파일의 Storage URL
     */
    public function removeBackground($imageFile, $timestamp, $rand)
    {
        try {
            $response = $this->client->post("{$this->apiBaseUrl}/stable-image/edit/remove-background", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Accept'        => 'image/*'
                ],
                'multipart' => [
                    [
                        'name'     => 'image',
                        'contents' => fopen($imageFile->getPathname(), 'r'),
                        'filename' => $imageFile->getClientOriginalName()
                    ],
                    [
                        'name'     => 'output_format',
                        'contents' => 'png'
                    ]
                ]
            ]);

            if ($response->getStatusCode() !== 200) {
                throw new Exception("Stability API Error (Remove BG): " . $response->getStatusCode());
            }

            // 파일 저장
            $fileName = "nobg_{$timestamp}_{$rand}.png";
            $path = "public/ai-lab/{$fileName}";
            Storage::put($path, $response->getBody()->getContents());

            return Storage::url($path);

        } catch (Exception $e) {
            Log::error("StabilityService Error (Remove): " . $e->getMessage());
            throw $e; // 컨트롤러에서 잡을 수 있게 다시 던짐
        }
    }

    /**
     * 배경 합성 (Step 2) - 비동기(Async) 지원
     */
    public function replaceBackground($imageFile, $prompt, $timestamp, $rand)
    {
        // 1. 작업 요청
        $url = "{$this->apiBaseUrl}/stable-image/edit/replace-background-and-relight";

        $response = $this->client->post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept'        => 'image/*' // 우선 이미지로 요청
            ],
            'multipart' => [
                [
                    'name'     => 'subject_image',
                    'contents' => fopen($imageFile->getPathname(), 'r'),
                    'filename' => $imageFile->getClientOriginalName()
                ],
                [
                    'name'     => 'background_prompt',
                    'contents' => $prompt
                ],
                [
                    'name'     => 'foreground_prompt',
                    'contents' => 'furniture' 
                ],
                [
                    'name'     => 'output_format',
                    'contents' => 'webp'
                ]
            ],
            'http_errors' => false
        ]);

        $statusCode = $response->getStatusCode();
        $contents = $response->getBody()->getContents();

        // 2. 에러 처리 (400 이상)
        if ($statusCode >= 400) {
            $this->throwSafeException($statusCode, $contents);
        }

        // 3. 비동기 접수 확인 (ID 수신 시 폴링 시작)
        // JSON 형식이고 'id' 키가 있는지 확인
        $decoded = json_decode($contents, true);
        if (is_array($decoded) && isset($decoded['id'])) {
            $contents = $this->pollAsyncResult($decoded['id']);
        }

        // 4. 최종 이미지 저장
        // 내용물이 이미지가 아니라 텍스트(JSON 등)라면 에러
        if (substr(trim($contents), 0, 1) === '{') {
             throw new \Exception("최종 결과가 이미지가 아닙니다: " . substr($contents, 0, 100));
        }

        $fileName = "final_{$timestamp}_{$rand}.webp";
        $path = "public/ai-lab/{$fileName}";
        Storage::put($path, $contents);

        return Storage::url($path);
    }

    /**
     * [최종 수정됨] 비동기 작업 결과 조회 (Polling)
     * Header를 'application/json'으로 설정하여 400 에러 해결
     */
/**
     * [최종 수정됨] 비동기 작업 결과 조회 (Polling)
     * JSON 응답 키가 'image'가 아니라 'result'로 오는 경우를 처리합니다.
     */
    private function pollAsyncResult($id)
    {
        $maxRetries = 40; // 최대 80초 대기
        $pollUrl = "{$this->apiBaseUrl}/results/{$id}";

        for ($i = 0; $i < $maxRetries; $i++) {
            sleep(2); // 2초 간격 조회

            $response = $this->client->get($pollUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Accept'        => 'application/json' 
                ],
                'http_errors' => false
            ]);

            $status = $response->getStatusCode();
            $contents = $response->getBody()->getContents();

            // 202: 작업 중 (계속 대기)
            if ($status === 202) {
                continue;
            }

            // 200: 작업 완료 -> 이미지 추출
            if ($status === 200) {
                $decoded = json_decode($contents, true);
                
                // [수정] 'image' 또는 'result' 키 모두 확인
                // 사용자의 로그를 보면 'result'에 데이터가 들어있음
                if (isset($decoded['result'])) {
                    return base64_decode($decoded['result']);
                }
                
                if (isset($decoded['image'])) {
                    return base64_decode($decoded['image']);
                }
                
                // 디버깅을 위해 응답 앞부분 출력
                throw new \Exception("JSON에 이미지 데이터(result/image)가 없습니다. 응답: " . substr($contents, 0, 100));
            }

            // 400 이상: 에러 발생
            if ($status >= 400) {
                $this->throwSafeException($status, $contents);
            }
        }

        throw new \Exception("Time out: 이미지 생성 시간이 초과되었습니다.");
    }

    /**
     * [추가됨] 안전한 예외 발생 도우미 함수
     * TypeError 방지를 위해 JSON 구조를 엄격하게 검사하지 않고, 실패 시 원본을 보여줍니다.
     */
    private function throwSafeException($status, $contents)
    {
        $errorMsg = "API Error ({$status}): ";
        
        $decoded = json_decode($contents, true);
        
        // JSON 파싱 성공하고 'errors' 배열이 있는 경우
        if (is_array($decoded) && isset($decoded['errors']) && is_array($decoded['errors']) && count($decoded['errors']) > 0) {
            $firstError = $decoded['errors'][0];
            if (is_array($firstError) && isset($firstError['message'])) {
                $errorMsg .= $firstError['message'];
            } else {
                $errorMsg .= json_encode($firstError); // 구조가 다르면 통째로 출력
            }
        } 
        // 단순 'message' 키만 있는 경우
        elseif (is_array($decoded) && isset($decoded['message'])) {
            $errorMsg .= $decoded['message'];
        }
        // 그 외 (HTML이나 일반 텍스트)
        else {
            $errorMsg .= substr($contents, 0, 300); // 내용을 그대로 보여줌
        }

        throw new \Exception($errorMsg);
    }
}