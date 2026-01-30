<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI 가구 이미지 생성 (Stability AI)</title>
    <style>
        body { font-family: 'Noto Sans KR', sans-serif; padding: 40px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: #fff; padding: 40px; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        h1 { text-align: center; color: #111; margin-bottom: 10px; }
        p.subtitle { text-align: center; color: #666; margin-bottom: 40px; font-size: 14px; }
        
        .form-group { margin-bottom: 35px; }
        label { display: block; font-weight: bold; margin-bottom: 15px; color: #333; font-size: 16px; }
        
        /* 파일 업로드 스타일 */
        input[type="file"] { display: none; }
        .preview-container {
            width: 100%;
            min-height: 250px;
            border: 2px dashed #ddd;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fafafa;
            overflow: hidden;
            position: relative;
            cursor: pointer;
            transition: border-color 0.3s, background-color 0.3s;
        }
        .preview-container:hover {
            border-color: #4F46E5;
            background-color: #f0f7ff;
        }
        .preview-container img {
            max-width: 100%;
            max-height: 500px;
            display: none;
            object-fit: contain;
        }
        .preview-placeholder {
            text-align: center;
            color: #aaa;
        }
        .preview-placeholder span {
            display: block;
            font-size: 40px;
            margin-bottom: 10px;
        }

        /* 공통 그리드 스타일 (가로 스크롤) */
        .scroll-grid {
            display: flex;             
            overflow-x: auto;          
            gap: 12px;
            padding-bottom: 15px;
            scrollbar-width: thin;     
            -webkit-overflow-scrolling: touch; 
            cursor: grab; 
            user-select: none;
        }
        .scroll-grid.active { cursor: grabbing; }
        
        .scroll-grid::-webkit-scrollbar { height: 8px; }
        .scroll-grid::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
        .scroll-grid::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }
        .scroll-grid::-webkit-scrollbar-thumb:hover { background: #aaa; }

        /* 카드 스타일 */
        .option-card {
            flex: 0 0 auto;            
            width: 150px;              
            background: #fff;
            border: 2px solid #eee;
            border-radius: 10px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 90px;
            pointer-events: auto; 
        }
        .option-card > * { pointer-events: none; } /* 내부 요소 드래그 방지 */

        .option-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border-color: #c7c7c7;
        }
        .option-card.active {
            border-color: #4F46E5;
            background-color: #eff6ff;
            color: #4F46E5;
        }
        .option-card.active::after {
            content: '✔';
            position: absolute;
            top: 8px;
            right: 8px;
            font-size: 14px;
            font-weight: bold;
            color: #4F46E5;
        }
        
        .option-name { font-weight: bold; font-size: 15px; margin-bottom: 5px; display: block; }
        .option-desc { font-size: 12px; color: #888; line-height: 1.3; word-break: keep-all; }
        .option-card.active .option-desc { color: #6366f1; }

        /* 제출 버튼 */
        button[type="submit"] { 
            width: 100%; padding: 18px; 
            background: #4F46E5; color: white; 
            border: none; border-radius: 10px; 
            font-size: 18px; cursor: pointer; font-weight: bold; 
            transition: background 0.3s;
            margin-top: 20px;
        }
        button[type="submit"]:hover { background: #4338CA; }
        button:disabled { background: #a5a5a5; cursor: not-allowed; }

        .loading { display: none; text-align: center; margin-top: 30px; color: #666; }
        .loading-spinner {
            border: 4px solid #f3f3f3; border-top: 4px solid #4F46E5;
            border-radius: 50%; width: 50px; height: 50px;
            animation: spin 1s linear infinite; margin: 0 auto 15px;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        
        .alert { padding: 15px; background: #fee2e2; color: #b91c1c; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🛋️ AI 가구 배경 합성</h1>
        <p class="subtitle">가구 사진을 올리고 스타일, 장소, 시간대를 선택하세요.</p>

        @if(session('error'))
            <div class="alert">⚠️ {{ session('error') }}</div>
        @endif

        <form action="{{ route('ai.stability.generate') }}" method="POST" enctype="multipart/form-data" id="aiForm">
            @csrf
            
            <div class="form-group">
                <label>1. 가구 사진 업로드</label>
                <div class="preview-container" id="previewContainer" onclick="document.getElementById('image').click();">
                    <div class="preview-placeholder">
                        <span>📷</span>
                        여기를 클릭하여 사진을 선택하세요<br>
                        <small style="color:#ccc; font-weight:normal;">(JPG, PNG, WEBP / Max 10MB)</small>
                    </div>
                    <img id="imagePreview" src="#" alt="미리보기">
                </div>
                <input type="file" name="image" id="image" required accept="image/*" onchange="readURL(this);">
            </div>

            <div class="form-group">
                <label>2. 배경 스타일 선택 <small style="font-weight:normal; color:#888;">(드래그하여 선택)</small></label>
                <div class="scroll-grid" id="styleGrid"></div>
            </div>

            <div class="form-group">
                <label>3. 장소 선택 <small style="font-weight:normal; color:#888;">(드래그하여 선택)</small></label>
                <div class="scroll-grid" id="locationGrid"></div>
            </div>

            <div class="form-group">
                <label>4. 시간대 선택 <small style="font-weight:normal; color:#888;">(빛의 느낌을 선택하세요)</small></label>
                <div class="scroll-grid" id="timeGrid"></div>
            </div>

            <input type="hidden" id="selectedStylePrompt">
            <input type="hidden" id="selectedLocationPrompt">
            <input type="hidden" id="selectedTimePrompt"> <input type="hidden" name="prompt" id="finalPrompt">

            <button type="submit" id="submitBtn">✨ 이미지 생성하기</button>
        </form>

        <div class="loading" id="loadingArea">
            <div class="loading-spinner"></div>
            <h3 id="loadingText">AI가 공간을 디자인하고 있습니다...</h3>
            <p>배경 제거 및 합성 작업은 약 10~20초 정도 소요됩니다.<br>잠시만 기다려주세요.</p>
        </div>
    </div>

    <script>
        // ============================
        // 1. 데이터 정의
        // ============================
        const styles = [
            { name: '북유럽', desc: '따뜻하고 실용적인 원목 감성', prompt: 'Scandinavian style, natural wood tones, bright and airy, beige and white palette, cozy textures, functional design' },
            { name: '모던', desc: '군더더기 없는 세련된 도시적 느낌', prompt: 'Modern interior design, sleek lines, geometric shapes, neutral colors, polished surfaces, contemporary look, clean aesthetic' },
            { name: '미니멀리즘', desc: '여백의 미를 살린 단순함', prompt: 'Minimalist style, decluttered space, simple forms, monochromatic color scheme, less is more, pure white space, calm atmosphere' },
            { name: '고딕', desc: '중후하고 웅장한 무게감', prompt: 'Gothic interior style, dramatic atmosphere, dark rich colors, ornate details, pointed arches, velvet textures, mysterious and grand' },
            { name: '클래식', desc: '화려한 샹들리에와 앤티크함', prompt: 'European classic style, elegant ornamentation, decorative moldings, crystal chandeliers, antique atmosphere, luxury and grandeur' },
            { name: '인더스트리얼', desc: '빈티지한 공장/카페 스타일', prompt: 'Industrial loft style, exposed brick walls, concrete floors, metal accents, raw materials, high ceilings, urban vintage vibe' },
            { name: '미드 센추리', desc: '50~60년대 레트로 감성', prompt: 'Mid-century modern style, retro 1950s vibe, teak wood furniture, organic curves, tapered legs, vintage color accents' },
            { name: '젠 (Japandi)', desc: '편안한 동양적 미니멀리즘', prompt: 'Japandi style, blend of Japanese and Scandinavian, low furniture, natural materials, peaceful and balanced' },
            { name: '보헤미안', desc: '자유로운 예술 감성과 식물', prompt: 'Bohemian style, eclectic patterns, rattan furniture, many plants, artistic and free-spirited' }
        ];

        const locations = [
            { name: '거실', desc: '소파와 TV가 있는 공간', prompt: 'Living room' },
            { name: '침실', desc: '아늑한 휴식 공간', prompt: 'Bedroom' },
            { name: '주방', desc: '현대적인 조리 공간', prompt: 'Kitchen' },
            { name: '다이닝룸', desc: '식탁이 있는 식사 공간', prompt: 'Dining room' },
            { name: '서재', desc: '차분한 업무 공간', prompt: 'Home office' },
            { name: '드레스룸', desc: '세련된 옷장 공간', prompt: 'Walk-in closet' },
            { name: '카페 라운지', desc: '감성적인 상업 공간', prompt: 'Cafe lounge' },
            { name: '아이방', desc: '밝고 명랑한 놀이방', prompt: 'Children\'s room' },
            { name: '테라스', desc: '채광 좋은 야외 데크', prompt: 'Terrace' },
            { name: '원룸', desc: '1인 가구 스튜디오', prompt: 'Studio apartment' }
        ];

        const times = [
            { name: '아침', desc: '상쾌하고 부드러운 햇살', prompt: 'Morning sunlight, soft daylight, fresh atmosphere, sunrise glow' },
            { name: '점심', desc: '밝고 쨍한 자연광', prompt: 'Bright noon, strong daylight, sunny, clear lighting' },
            { name: '저녁', desc: '따뜻한 노을 감성 (골든아워)', prompt: 'Golden hour, sunset light, warm ambient, orange glow' },
            { name: '밤', desc: '차분하고 고급스러운 조명', prompt: 'Night time, dark atmosphere, artificial indoor lighting, moody' },
            { name: '새벽', desc: '푸르고 고요한 분위기', prompt: 'Early morning, blue hour, dim cool lighting, serene atmosphere' }
        ];

        // ============================
        // 2. 버튼 생성 함수
        // ============================
        function renderButtons(data, containerId, hiddenInputId) {
            const container = document.getElementById(containerId);
            const hiddenInput = document.getElementById(hiddenInputId);

            data.forEach(item => {
                const btn = document.createElement('div');
                btn.className = 'option-card';
                btn.innerHTML = `
                    <span class="option-name">${item.name}</span>
                    <span class="option-desc">${item.desc}</span>
                `;

                btn.onclick = function() {
                    // 드래그 중이면 클릭 무시
                    if (container.classList.contains('is-dragging')) return;

                    // 활성화 처리
                    container.querySelectorAll('.option-card').forEach(c => c.classList.remove('active'));
                    this.classList.add('active');

                    // 값 저장
                    hiddenInput.value = item.prompt;
                    console.log(`Selected [${containerId}]:`, item.prompt);
                };

                container.appendChild(btn);
            });
        }

        // 렌더링 실행
        renderButtons(styles, 'styleGrid', 'selectedStylePrompt');
        renderButtons(locations, 'locationGrid', 'selectedLocationPrompt');
        renderButtons(times, 'timeGrid', 'selectedTimePrompt'); // 시간대 추가


        // ============================
        // 3. 드래그 스크롤 기능
        // ============================
        function enableDragScroll(elementId) {
            const slider = document.getElementById(elementId);
            let isDown = false;
            let startX;
            let scrollLeft;

            slider.addEventListener('mousedown', (e) => {
                isDown = true;
                slider.classList.add('active');
                slider.classList.remove('is-dragging'); // 초기화
                startX = e.pageX - slider.offsetLeft;
                scrollLeft = slider.scrollLeft;
            });

            slider.addEventListener('mouseleave', () => {
                isDown = false;
                slider.classList.remove('active');
            });

            slider.addEventListener('mouseup', () => {
                isDown = false;
                slider.classList.remove('active');
                setTimeout(() => { slider.classList.remove('is-dragging'); }, 0);
            });

            slider.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - slider.offsetLeft;
                const walk = (x - startX) * 2;
                slider.scrollLeft = scrollLeft - walk;

                if (Math.abs(walk) > 5) {
                    slider.classList.add('is-dragging');
                }
            });
        }

        // 드래그 적용
        enableDragScroll('styleGrid');
        enableDragScroll('locationGrid');
        enableDragScroll('timeGrid'); // 시간대 추가


        // ============================
        // 4. 유틸리티
        // ============================
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var img = document.getElementById('imagePreview');
                    var placeholder = document.querySelector('.preview-placeholder');
                    img.src = e.target.result;
                    img.style.display = 'block'; 
                    placeholder.style.display = 'none';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }


        // ============================
        // 5. 폼 제출 (3단 결합)
        // ============================
        document.getElementById('aiForm').onsubmit = function(e) {
            const img = document.getElementById('image').value;
            const stylePrompt = document.getElementById('selectedStylePrompt').value;
            const locationPrompt = document.getElementById('selectedLocationPrompt').value;
            const timePrompt = document.getElementById('selectedTimePrompt').value;

            if (!img) {
                alert('가구 사진을 업로드해주세요!');
                e.preventDefault();
                return false;
            }

            if (!stylePrompt) {
                alert('배경 스타일을 선택해주세요!');
                e.preventDefault();
                document.getElementById('styleGrid').scrollIntoView({ behavior: 'smooth', block: 'center' });
                return false;
            }

            if (!locationPrompt) {
                alert('장소를 선택해주세요!');
                e.preventDefault();
                document.getElementById('locationGrid').scrollIntoView({ behavior: 'smooth', block: 'center' });
                return false;
            }

            if (!timePrompt) {
                alert('시간대를 선택해주세요!');
                e.preventDefault();
                document.getElementById('timeGrid').scrollIntoView({ behavior: 'smooth', block: 'center' });
                return false;
            }

            // [중요] 3가지 프롬프트를 합쳐서 최종 전송
            // 예: "Modern style..., Living room, Morning sunlight..."
            const finalPrompt = `${stylePrompt}, ${locationPrompt}, ${timePrompt}`;
            document.getElementById('finalPrompt').value = finalPrompt;

            // 로딩 화면 표시
            document.getElementById('loadingArea').style.display = 'block';
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerText = '생성 중입니다...';
        };
    </script>
</body>
</html>