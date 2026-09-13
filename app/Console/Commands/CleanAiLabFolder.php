<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CleanAiLabFolder extends Command
{
    /**
     * @var string
     */
    protected $signature = 'ai:clean-temp {--hours=3 : 삭제할 기준 시간 (기본 3시간)}';

    /**

     * @var string
     */
    protected $description = 'ai-lab 폴더 내의 오래된 임시 AI 이미지 파일을 삭제합니다.';

    /**

     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function handle()
    {
      
        $hours = $this->option('hours');
        $seconds = $hours * 3600;
        $now = time();
        $deletedCount = 0;

        $this->info("ai-lab 폴더 청소를 시작합니다... (기준: {$hours}시간 이전 파일)");

        try {
           
            $files = Storage::disk('public')->files('ai-lab');

            foreach ($files as $file) {
                
                $lastModified = Storage::disk('public')->lastModified($file);

                
                if (($now - $lastModified) > $seconds) {
                    // 조건에 맞으면 삭제합니다.
                    Storage::disk('public')->delete($file);
                    $deletedCount++;
                }
            }
            
            $message = "[AI 청소 스케줄러] ai-lab 폴더 청소 완료. 총 {$deletedCount}개의 임시 파일을 삭제했습니다.";
            $this->info($message);
            Log::info($message);

        } catch (\Exception $e) {
            
            $this->error("ai-lab 폴더 청소 중 오류 발생: " . $e->getMessage());
            Log::error("[AI 청소 스케줄러 오류] " . $e->getMessage());
        }
    }
}