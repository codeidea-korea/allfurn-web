<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI 생성 결과</title>
    <style>
        body { font-family: 'Noto Sans KR', sans-serif; padding: 40px; background: #f5f5f5; text-align: center; }
        .container { max-width: 1000px; margin: 0 auto; }
        
        h1 { color: #111; margin-bottom: 10px; }
        .prompt-text { background: #e0e7ff; color: #3730a3; padding: 8px 15px; border-radius: 20px; display: inline-block; font-size: 14px; font-weight: bold; margin-bottom: 40px; }

        /* [추가] 에러 박스 스타일 */
        .error-container {
            background: #fff5f5; border: 2px solid #fc8181; border-radius: 10px;
            padding: 40px; color: #c53030; margin-top: 20px; text-align: left;
        }
        .error-title { font-size: 20px; font-weight: bold; margin-bottom: 15px; display: flex; align-items: center; gap: 10px; }
        .error-code { 
            background: #2d3748; color: #fab1a0; padding: 15px; 
            border-radius: 5px; font-family: monospace; font-size: 14px; 
            overflow-x: auto; white-space: pre-wrap; line-height: 1.6;
        }

        /* 기존 스타일 유지 */
        .result-box { display: flex; justify-content: center; gap: 30px; flex-wrap: wrap; }
        .card { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 45%; min-width: 320px; box-sizing: border-box; }
        .img-wrapper { width: 100%; height: 320px; display: flex; align-items: center; justify-content: center; background-color: #f9fafb; border: 1px solid #eee; border-radius: 10px; overflow: hidden; margin-bottom: 20px; }
        .check-pattern { background-image: linear-gradient(45deg, #eee 25%, transparent 25%), linear-gradient(-45deg, #eee 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #eee 75%), linear-gradient(-45deg, transparent 75%, #eee 75%); background-size: 20px 20px; background-position: 0 0, 0 10px, 10px -10px, -10px 0px; }
        img { max-width: 100%; max-height: 100%; object-fit: contain; }
        h3 { margin-top: 0; color: #333; font-size: 18px; margin-bottom: 15px; }
        .btn { display: inline-block; padding: 12px 24px; background: #1f2937; color: white; text-decoration: none; border-radius: 6px; font-size: 14px; transition: background 0.2s; }
        .btn:hover { background: #111; }
        .btn-outline { background: white; border: 2px solid #4F46E5; color: #4F46E5; font-weight: bold; padding: 12px 30px; border-radius: 30px; text-decoration: none; }
        .btn-outline:hover { background: #f5f3ff; }
        .action-area { margin-top: 50px; }
    </style>
</head>
<body>
    <div class="container">
        
        @if(isset($original_prompt))
            <div class="prompt-text">입력한 프롬프트 : {{ $original_prompt }}</div>
        @endif

        {{-- [수정됨] 성공(Success)일 때만 이미지 표시 --}}
        @if(isset($success) && $success === true)
            <h1>✨ 작업이 완료되었습니다!</h1>
            
            <div class="result-box">
                <div class="card">
                    <h3>① 배경 제거 원본 (PNG)</h3>
                    <div class="img-wrapper check-pattern">
                        <img src="{{ $nobg_url }}" alt="누끼 이미지" onerror="this.src=''; this.alt='이미지 로드 실패';">
                    </div>
                    <a href="{{ $nobg_url }}" download class="btn">💾 투명 이미지 다운로드</a>
                </div>

                <div class="card">
                    <h3>② 최종 합성 결과 (WEBP)</h3>
                    <div class="img-wrapper">
                        <img src="{{ $final_url }}" alt="합성 이미지" onerror="this.src=''; this.alt='이미지 로드 실패';">
                    </div>
                    <a href="{{ $final_url }}" download class="btn">💾 합성 이미지 다운로드</a>
                </div>
            </div>

        {{-- [추가됨] 실패(Fail)일 때는 에러 로그 표시 --}}
        @else
            <h1>🚫 작업 중 오류가 발생했습니다</h1>
            
            <div class="error-container">
                <div class="error-title">
                    ⚠️ Error Details
                </div>
                <div class="error-code">
{{ $error ?? '알 수 없는 오류가 발생했습니다.' }}
                </div>
                <p style="margin-top: 15px; font-size: 14px; color: #718096;">
                    * API 키가 정확한지, 혹은 크레딧(비용)이 부족하지 않은지 확인해주세요.<br>
                    * 이미지가 너무 크거나(10MB 이상) 지원하지 않는 형식일 수 있습니다.
                </p>
            </div>
        @endif

        <div class="action-area">
            <a href="{{ route('ai.stability.index') }}" class="btn-outline">
                {{ isset($success) && $success ? '↺ 다른 사진 만들기' : '↺ 다시 시도하기' }}
            </a>
        </div>
    </div>
</body>
</html>