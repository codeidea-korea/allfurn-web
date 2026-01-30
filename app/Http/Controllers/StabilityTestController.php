<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\StabilityService; // [중요] 새로 만든 서비스 사용
use Illuminate\Support\Facades\Log;

class StabilityTestController extends Controller
{
    private $stabilityService;

    // [중요] 생성자 주입 (Dependency Injection)
    // 라라벨 서비스 컨테이너가 자동으로 StabilityService 인스턴스를 주입해줍니다.
    public function __construct(StabilityService $stabilityService)
    {
        $this->stabilityService = $stabilityService;
    }

    /**
     * 테스트 페이지 진입
     */
    public function index()
    {
        return view('ai-lab.stability');
    }

    /**
     * 이미지 생성 요청 처리
     */
    public function generate(Request $request)
    {
        // 1. 유효성 검사
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240', // 최대 10MB
            'prompt' => 'required|string|max:1000',
        ]);

        try {
            $image = $request->file('image');
            $prompt = $request->input('prompt');
            
            // 파일명 동기화를 위한 난수 생성 (두 파일의 짝을 맞추기 위함)
            $timestamp = time();
            $rand = mt_rand(1000, 9999);

            // 2. 서비스 호출 (핵심 로직 위임)
            // 컨트롤러는 "어떻게(How)" API를 부르는지 알 필요 없이, "무엇을(What)" 할지만 명령합니다.
            
            // (1) 누끼 따기 요청 -> 결과 이미지 URL 받기
            $nobgUrl = $this->stabilityService->removeBackground($image, $timestamp, $rand);
            
            // (2) 배경 합성 요청 -> 결과 이미지 URL 받기
            $finalUrl = $this->stabilityService->replaceBackground($image, $prompt, $timestamp, $rand);

            // 3. 결과 뷰 반환 (성공)
            return view('ai-lab.result', [
                'success' => true,
                'nobg_url' => $nobgUrl,
                'final_url' => $finalUrl,
                'original_prompt' => $prompt
            ]);

        } catch (\Exception $e) {
            // 4. 에러 처리
            // 로그를 남기고, 사용자에게는 에러 화면을 보여줍니다.
            Log::error("Stability AI Controller Error: " . $e->getMessage());

            // redirect()->back() 대신 결과 뷰에 에러 내용을 담아 보냅니다.
            return view('ai-lab.result', [
                'success' => false,
                'error' => $e->getMessage(),
                'original_prompt' => $request->input('prompt')
            ]);
        }
    }
}