<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>올펀 AI 가구 쇼룸</title>
    <style>
        body { font-family: 'Noto Sans KR', sans-serif; background: #f4f6f9; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        .title { text-align: center; margin-bottom: 30px; color: #2c3e50; }
        
        /* 업로드 영역 */
        .upload-area { border: 2px dashed #cbd5e0; padding: 40px; text-align: center; border-radius: 10px; cursor: pointer; transition: 0.3s; background: #fafafa; }
        .upload-area:hover { border-color: #4a90e2; background: #edf2f7; }
        .preview-box img { max-width: 100%; max-height: 300px; margin-top: 20px; border-radius: 8px; display: none; }
        
        /* 프롬프트 영역 */
        .prompt-area { margin-top: 25px; }
        .prompt-label { display: block; font-weight: bold; margin-bottom: 8px; color: #4a5568; }
        .prompt-input { width: 100%; padding: 15px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 16px; resize: vertical; box-sizing: border-box; }
        .prompt-input:focus { outline: none; border-color: #4a90e2; box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1); }
        
        /* 버튼 */
        .btn-generate { 
            display: block; width: 100%; padding: 18px; margin-top: 30px; 
            background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%); 
            color: white; border: none; border-radius: 8px; 
            font-size: 18px; font-weight: bold; cursor: pointer; transition: 0.2s;
        }
        .btn-generate:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(74, 144, 226, 0.3); }
    </style>
</head>
<body>

<div class="container">
    <h2 class="title">✨ AI 가구 쇼룸 생성기</h2>

    <form action="{{ route('ai_allfurn.generate') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="upload-area" onclick="document.getElementById('file-input').click()">
            <div id="upload-text">
                <p style="font-size: 40px; margin: 0;">📸</p>
                <p style="font-size: 18px; margin: 10px 0;">클릭하여 <b>가구 사진</b>을 업로드하세요</p>
                <p style="font-size: 14px; color: #a0aec0;">JPG, PNG (최대 10MB)</p>
            </div>
            <input type="file" name="image" id="file-input" accept="image/*" style="display: none;" required>
            
            <div class="preview-box">
                <img id="preview-img" src="" alt="미리보기">
            </div>
        </div>

        <div class="prompt-area">
            <label class="prompt-label" for="prompt">어떤 공간에 배치할까요? (배경 설명)</label>
            <textarea name="prompt" id="prompt" class="prompt-input" rows="3" 
                      placeholder="예: 햇살이 가득 들어오는 모던한 거실, 대리석 바닥, 화분 옆"></textarea>
            <p style="font-size: 13px; color: #718096; margin-top: 5px;">* 비워두면 배경만 투명하게 지워드립니다 (누끼).</p>
        </div>

        <button type="submit" class="btn-generate">AI 이미지 생성 시작 🚀</button>
    </form>
</div>

<script>
    // 이미지 미리보기 스크립트
    const fileInput = document.getElementById('file-input');
    const previewImg = document.getElementById('preview-img');
    const uploadText = document.getElementById('upload-text');

    fileInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewImg.style.display = 'block';
                uploadText.style.display = 'none'; // 텍스트 숨김
            }
            reader.readAsDataURL(file);
        }
    });
</script>

</body>
</html>