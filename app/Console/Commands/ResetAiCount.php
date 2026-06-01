<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetAiCount extends Command
{
    // 1. 터미널이나 스케줄러에서 실행할 명령어 이름
    protected $signature = 'reset:aicount';

    // 2. 명령어에 대한 설명
    protected $description = '매일 자정에 모든 유저의 ai_count를 5로 리필합니다.';

    public function __construct()
    {
        parent::__construct();
    }

    // 3. 실제 실행될 로직
    public function handle()
    {
        // af_user 테이블의 모든 데이터의 ai_count를 5로 업데이트
        DB::table('AF_user')->update(['ai_count' => 3]);
        
        $this->info('모든 유저의 ai_count가 5로 초기화되었습니다.');
    }
}