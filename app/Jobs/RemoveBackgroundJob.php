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
use Illuminate\Support\Str;
use App\Jobs\GenerateBackgroundJob; // 2단계 Job 연결

class RemoveBackgroundJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sourceFilePath; // 원본 이미지 경로
    protected $taskId;         // 작업 ID (파일명용)
    protected $prompt;         // (선택) 2단계로 넘겨줄 배경 프롬프트

    public function __construct($sourceFilePath, $taskId, $prompt = null)
    {
        $this->sourceFilePath = $sourceFilePath;
        $this->taskId = $taskId;
        $this->prompt = $prompt;
    }

    public function handle()
    {
        Log::info("[1단계] 누끼 따기 시작: " . $this->taskId);

        // 1. 원본 파일 읽기
        // 주의: Controller에서 'public/temp_originals'로 저장했으므로 경로를 맞춰줍니다.
        if (!Storage::exists($this->sourceFilePath)) {
            Log::error("원본 파일 없음: " . $this->sourceFilePath);
            return;
        }
        $imageContent = Storage::get($this->sourceFilePath);
        $apiKey = env('PHOTOROOM_API_KEY');

        // 2. 포토룸 API 호출 (v1/segment - 배경 제거)
        $response = Http::withHeaders(['x-api-key' => $apiKey])
            ->attach('image_file', $imageContent, 'original.jpg')
            ->post('https://sdk.photoroom.com/v1/segment');

        if ($response->failed()) {
            Log::error("===== [1단계] 누끼 따기 실패 =====");
            Log::error("상태 코드: " . $response->status());
            Log::error("에러 본문: " . $response->body());
            return; // 여기서 작업을 강제 종료합니다.
        }

        // 3. 결과 저장 (투명 배경 PNG)
        $resultContent = $response->body();
        $pngFilename = 'processed_images/' . $this->taskId . '_transparent.png';
        Storage::disk('public')->put($pngFilename, $resultContent);

        Log::info("[1단계] 누끼 완료: " . $pngFilename);

        // 프롬프트가 들어왔는지, 아니면 비어있는지 눈으로 확인합니다.
        Log::info("🧐 프롬프트 값 검문: " . json_encode($this->prompt));
        // [▲▲▲ 여기까지 ▲▲▲]

        // 4. (중요) 프롬프트가 있다면 -> 2단계(배경 합성) Job 실행!
        if ($this->prompt) {
            Log::info("[2단계] 배경 합성 Job으로 토스 -> 프롬프트: " . $this->prompt);
            GenerateBackgroundJob::dispatch($pngFilename, $this->prompt, $this->taskId);
        }

    }
}