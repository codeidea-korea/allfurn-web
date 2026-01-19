<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // 이미지 저장 (S3 또는 로컬)
use Illuminate\Support\Facades\Http;    // 외부 API 통신 (Photoroom API 호출용)
use Illuminate\Support\Facades\Log;     // 에러 로그 기록 (API 실패 시 확인용)
use Illuminate\Support\Str;             // 파일명 난수 생성 (UUID 등)
//use App\Jobs\GenerateAiImageJob;        // [중요] 백그라운드 처리를 위한 Job 클래스
use App\Jobs\RemoveBackgroundJob; // [변경]
use Exception;

class AiAllFurnController extends Controller
{

    public function index(){
        return view('aiallfurn.aiallfurn');
    }

    public function generate(Request $request){

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);
        
        try {
            // 2. 파일 저장
            $file = $request->file('image');
            
            // 파일명 중복 방지를 위해 UUID(난수) 사용
            $taskId = (string) Str::uuid(); 
            $extension = $file->getClientOriginalExtension();
            $filename = $taskId . '.' . $extension;

            // 'storage/app/public/temp_originals' 경로에 원본 저장
            // (나중에 Job에서 이 파일을 꺼내서 API로 보냅니다)
            $path = $file->storeAs('public/temp_originals', $filename);

            // 3. 비동기 작업(Job) 실행
            // 방금 만든 Job 클래스에 '저장된 경로'와 '작업 ID'를 전달합니다.
            // dispatch() 함수는 이 작업을 '큐(대기열)'에 등록하고 즉시 다음 줄로 넘어갑니다.
            $prompt = $request->input('prompt');
            RemoveBackgroundJob::dispatch($path, $taskId, $prompt);

            // 4. 결과 페이지(대기 화면)로 리다이렉트
            // 작업 ID($taskId)를 가지고 상태 확인 페이지로 이동합니다.
            return redirect()->route('ai_allfurn.status', ['taskId' => $taskId]);

        } catch (Exception $e) {
            // 에러 발생 시 로그 기록
            Log::error("AI Image Upload Error: " . $e->getMessage());

            // 이전 페이지로 돌아가서 에러 메시지 표시
            return back()->with('error', '이미지 업로드 중 문제가 발생했습니다. 다시 시도해주세요.');
        }
    }

    public function checkStatus($taskId)
    {
        // 1. 확인해볼 파일 경로 두 가지 (누끼 PNG, 합성 JPG)
        $nuggiFile = 'processed_images/' . $taskId . '_transparent.png'; // 1단계 결과
        $finalFile = 'final_images/' . $taskId . '_final.jpg';           // 2단계 결과

        // [추가된 로직] 2단계(최종 합성) 파일이 있는지 먼저 검사! (우선순위 1등)
        if (Storage::disk('public')->exists($finalFile)) {
            $url = Storage::url($finalFile);

            return "
                <div style='text-align:center; padding:50px;'>
                    <h1 style='color:green;'>🎉 배경 합성 완료!</h1>
                    <img src='$url' style='max-width:600px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.2);'>
                    <br><br>
                    <a href='/ai-allfurn' style='padding:10px 20px; background:#333; color:white; text-decoration:none; border-radius:5px;'>다시 하기</a>
                </div>
            ";
        }

        // 2. 파일이 존재하는지 확인 (기존 로직 - 1단계 누끼)
        if (Storage::disk('public')->exists($nuggiFile)) {
            $url = Storage::url($nuggiFile);
            
            // [중요] 누끼는 있는데 최종본이 아직 없다면? -> "진행 중"으로 간주하고 새로고침 계속!
            return "
                <meta http-equiv='refresh' content='3'> <div style='text-align:center; padding:50px;'>
                    <h1>🎨 1단계(누끼) 완료! 배경 합성 중...</h1>
                    <p>잠시만 기다려주세요. (3초마다 자동 확인)</p>
                    <img src='$url' style='max-width:400px; border:2px dashed #ccc; opacity:0.7;'>
                </div>
            ";
        }

        // [대기] 아무 파일도 없으면 (기존 로직 유지)
        return "
            <meta http-equiv='refresh' content='3'>
            <div style='text-align:center; padding:50px;'>
                <h1>⏳ AI가 열심히 작업 중입니다...</h1>
                <p>잠시만 기다려주세요. (3초마다 자동 확인)</p>
                <p>Task ID: $taskId</p>
            </div>
        ";
    }
}