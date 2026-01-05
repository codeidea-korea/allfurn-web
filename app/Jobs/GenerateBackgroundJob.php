<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class GenerateBackgroundJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $transparentImagePath; // 1단계에서 만든 투명 이미지 경로
    protected $prompt;               // 사용자가 입력한 배경 설명
    protected $taskId;               // 작업 ID

    /**
     * 1단계 Job에서 넘겨준 데이터를 받습니다.
     */
    public function __construct($transparentImagePath, $prompt, $taskId)
    {
        $this->transparentImagePath = $transparentImagePath;
        $this->prompt = $prompt;
        $this->taskId = $taskId;
    }

    /**
     * 포토룸 v2/edit API를 호출하여 배경을 합성합니다.
     */
    public function handle()
    {
        Log::info("[2단계] 배경 합성 시작 Task ID: " . $this->taskId);

        // 1. 투명 이미지 파일 확인
        if (!Storage::disk('public')->exists($this->transparentImagePath)) {
            Log::error("[2단계] 투명 이미지를 찾을 수 없음: " . $this->transparentImagePath);
            return;
        }

        $imageContent = Storage::disk('public')->get($this->transparentImagePath);
        $apiKey = env('PHOTOROOM_API_KEY');

        // 2. 포토룸 API 호출 (v2/edit)
        // 주의: 누끼는 'v1/segment'였지만, 합성은 'v2/edit'을 사용합니다.
        $response = Http::withHeaders(['x-api-key' => $apiKey])
            ->attach('imageFile', $imageContent, 'transparent.png')
            ->post('https://image-api.photoroom.com/v2/edit', [
                'background.prompt' => $this->prompt, // 핵심: 여기에 프롬프트가 들어갑니다
                // 'outputSize' => '1024x1024' // 필요시 사이즈 지정 가능
            ]);

        // 3. 에러 체크
        if ($response->failed()) {
            Log::error("===== [2단계] 배경 합성 실패 =====");
            Log::error("상태 코드: " . $response->status());
            Log::error("에러 본문: " . $response->body());
            return; 
        }

        // 4. 결과 저장 (최종 합성은 주로 JPG 사용)
        $resultContent = $response->body();
        // 파일명 규칙: final_images/ID_final.jpg
        $finalFileName = 'final_images/' . $this->taskId . '_final.jpg';

        Storage::disk('public')->put($finalFileName, $resultContent);

        Log::info("[2단계] 배경 합성 성공! 파일 저장됨: " . $finalFileName);
        Log::info("================ 작업 완전 종료 ================");
    }
}