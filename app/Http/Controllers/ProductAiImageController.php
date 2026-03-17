<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\ProductAiImageService; // Stability와 Google을 통합 관리하는 서비스
use Illuminate\Support\Facades\Log;

class ProductAiImageController extends Controller
{
    private $productAiService;

    // 생성자 주입: 통합 서비스 연결
    public function __construct(ProductAiImageService $productAiService)
    {
        $this->productAiService = $productAiService;
    }

    public function index()
    {
        // resources/views/product/ai/index.blade.php 파일을 바라봅니다.
        return view('product.ai.index');
    }

    /**
     * [Step 1] 배경 제거 (Stability AI)
     * - 모달 창에서 이미지를 업로드하면 호출됩니다.
     * - 응답값: 화면 표시용 URL(preview_url) + 다음 단계 전달용 경로(temp_path)
     */
    public function removeBackground(Request $request)
    {
        // 1. 유효성 검사
        $request->validate([
            'image' => 'required|image|max:10240', // 최대 10MB
        ]);

        $user = \Illuminate\Support\Facades\Auth::user();

        if (!$user || $user->ai_count <= 0) {
            return response()->json([
                'success' => false,
                'message' => '오늘 사용 가능한 AI 생성 횟수를 모두 소진하였습니다.'
            ], 403);
        }

        try {
            // 2. 이미지 파일 받기
            $imageFile = $request->file('image');

            // 3. 서비스 호출 (배경 제거 로직 실행)
            // 성공 시 결과 이미지 URL을 반환받음
            $result = $this->productAiService->removeBackground($imageFile);

            // 3. 정상 처리되었을 때만 차감
            $user->ai_count -= 1;
            $user->save();

            return response()->json([
                'success' => true,
                'data' => [
                    'removebg_url' => $result['url'],       // 프론트엔드 이미지 태그 src용
                    'temp_path' => $result['file_path'] // (선택) 다음 단계 요청 시 서버로 다시 보낼 경로
                ],
                'remain_count' => $user ? $user->ai_count : 0
            ]);

        } catch (\Exception $e) {
            Log::error("배경 제거 오류: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => '처리 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * [Step 2] 배경 합성 (Google Gemini)
     * - 1단계에서 만든 '누끼 이미지 경로'와 '프롬프트'를 받아 호출됩니다.
     * - 응답값: 최종 합성된 이미지 URL
     */
    public function generateBackground(Request $request)
    {
        $request->validate([
            'temp_path' => 'required|string',      // 1단계 결과 파일 경로
            'prompt'    => 'required|string|max:1000', // 사용자 입력 프롬프트
        ]);

        $user = \Illuminate\Support\Facades\Auth::user();

        try {
            $tempPath = $request->input('temp_path');
            $prompt   = $request->input('prompt');

            // 서비스 호출: Gemini를 통해 배경 합성 수행
            // 반환값 예시: 'http://.../final_image.png'
            $finalUrl = $this->productAiService->generateBackground($tempPath, $prompt);

            return response()->json([
                'success' => true,
                'message' => '이미지 생성 완료',
                'data'    => [
                    'final_url' => $finalUrl
                ],
                'remain_count' => $user ? $user->ai_count : 0
            ]);

        } catch (\Exception $e) {
            Log::error("Step2 GenerateBG Error: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function testDecrement(\Illuminate\Http\Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        // 1. 남은 횟수 확인
        if ($user->ai_count <= 0) {
            return response()->json([
                'success' => false,
                'message' => '테스트 이미지 생성 횟수(5회)를 모두 소진하였습니다.'
            ], 403);
        }

        // 2. 횟수 차감 및 DB 저장
        $user->ai_count -= 1;
        $user->save();

        // 3. 성공 신호와 남은 횟수 프론트엔드로 반환
        return response()->json([
            'success' => true,
            'remain_count' => $user->ai_count
        ]);
    }

    public function getRemainCount(\Illuminate\Http\Request $request)
    {
        // 1. 현재 로그인한 사용자 정보 가져오기
        $user = \Illuminate\Support\Facades\Auth::user();

        // (예외 처리) 로그인 상태가 아닐 경우
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => '로그인이 필요합니다.',
                'remain_count' => 0
            ], 401);
        }

        // 2. 사용자의 현재 남은 횟수(ai_count)만 그대로 반환
        return response()->json([
            'success' => true,
            'remain_count' => $user->ai_count
        ]);
    }
}