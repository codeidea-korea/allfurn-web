<div class="modal" id="ai_image_generator_modal">
    <div class="modal_bg" onclick="modalClose('#ai_image_generator_modal')"></div>
    
    <div class="modal_inner" style="width: 1600px; max-width: 98vw; height: 90vh; padding: 0; border-radius: 12px; display: flex; flex-direction: column; overflow: hidden; background-color: #fff;">
        
        {{-- 헤더 --}}
        <div class="flex items-center justify-between px-6 py-4 border-b bg-white shrink-0">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7"/><line x1="16" x2="22" y1="5" y2="5"/><line x1="19" x2="19" y1="2" y2="8"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-stone-900">AI 스튜디오</h3>
                    <p class="text-xs text-stone-400">배경 제거 및 생성 도구</p>
                </div>
            </div>
            <button class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-stone-100 transition-colors" onclick="modalClose('#ai_image_generator_modal')">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-stone-500"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>

        <div class="flex flex-1 overflow-hidden h-full">
            
            <div class="flex-1 bg-stone-100 relative flex flex-col">
                <div class="h-12 border-b bg-white flex items-center justify-between px-4 shrink-0">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-stone-500">미리보기</span>
                        <span id="ai_remain_count_display" class="text-xs text-primary font-medium bg-primary/10 px-2 py-0.5 rounded-full hidden"></span>
                    </div>
                </div>

                <div class="flex-1 flex items-center justify-center p-8 overflow-auto">
                    <div class="relative shadow-xl rounded-lg overflow-hidden bg-white" style="min-width: 500px; min-height: 500px; max-width: 100%; max-height: 100%;">
                        
                        <div class="absolute inset-0 bg-white"></div>

                        {{-- 메인 미리보기 이미지 ID: ai_modal_preview_image --}}
                        <img id="ai_modal_preview_image" src="" class="relative z-10 w-full h-full object-contain mx-auto" style="max-height: 70vh;">
                        
                        {{-- 플레이스홀더 (로딩/안내 문구) --}}
                        <div id="ai_modal_placeholder_text" class="absolute inset-0 flex flex-col items-center justify-center z-20 bg-white/80">
                            <svg class="w-12 h-12 text-stone-300 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            <p class="text-stone-400">이미지를 불러오는 중입니다...</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-[320px] border-l bg-white flex flex-col h-full shrink-0 z-10">
                <div class="p-5 flex-1 overflow-y-auto">
                    
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-stone-700 mb-2">선택된 이미지</label>
                        <div class="w-full aspect-square bg-stone-50 border rounded-lg overflow-hidden flex items-center justify-center relative group">
                            {{-- 사이드바 썸네일 이미지 ID: ai_modal_thumbnail --}}
                            <img id="ai_modal_thumbnail" src="" class="w-full h-full object-contain">
                        </div>
                    </div>

                    <hr class="border-stone-100 my-6">

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-stone-700 mb-3">스타일</label>
                        
                        <div class="flex flex-col gap-3">
                           
                            <button type="button" id="btn_remove_bg" class="w-full py-3 bg-white border border-stone-200 rounded-lg text-stone-600 font-medium hover:border-primary hover:text-primary hover:bg-primary/5 transition-all flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3l18 18"/><path d="M15 4.5l-4 4"/><path d="M14 20l-4-4"/><path d="M8 20l4-4"/><circle cx="18" cy="6" r="3"/><circle cx="6" cy="18" r="3"/></svg>
                                배경제거
                            </button>

                            {{-- 1. 북유럽 스타일 (배경 이미지형) --}}
                            <button type="button" 
                                    class="btn-style-select relative w-full h-24 rounded-xl overflow-hidden group text-left transition-all hover:scale-[1.02] shadow-sm"
                                    data-style="북유럽"
                                    data-prompt="Nordic style, natural wood tones, bright and airy, beige and white palette, cozy textures, functional design, warm atmosphere, Empty room, unoccupied space, solely focused on the furniture ">

                                {{-- [1층] 배경 이미지 --}}
                                <img src="{{ asset('img/ai_button/nordic.jpg') }}" 
                                    class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-out" 
                                    alt="북유럽 스타일 배경">

                                {{-- [2층] 어두운 오버레이 (그라데이션) --}}
                                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent group-hover:from-black/90 transition-colors duration-300"></div>


                                {{-- [3층] 텍스트 내용 (흰색) --}}
                                <div class="relative z-10 h-full flex flex-col justify-center px-5">
                                    <span class="text-white font-bold text-lg drop-shadow-md">북유럽 스타일</span>
                                    <span class="text-stone-200 text-xs font-medium mt-1 drop-shadow-sm">따뜻한 원목과 아늑한 감성</span>
                                </div>

                                {{-- 1. 체크 표시 래퍼 --}}
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 z-20 opacity-0 scale-50 group-[.border-red-500]:opacity-100 group-[.border-red-500]:scale-100 transition-all duration-300 ease-back-out">
                                    <div class="bg-red-500 text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg shadow-red-500/30 border-2 border-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                    </div>
                                </div>

                                {{-- 2. 테두리 래퍼 --}}
                                <div class="absolute inset-0 rounded-xl pointer-events-none transition-all duration-300 border-2 border-transparent group-[.border-red-500]:border-red-500 group-[.border-red-500]:ring-4 group-[.border-red-500]:ring-red-500/30 group-[.border-red-500]:ring-inset"></div>
                            </button>

                            {{-- 2. 모던 스타일--}}
                            <button type="button" 
                                    class="btn-style-select relative w-full h-24 rounded-xl overflow-hidden group text-left transition-all hover:scale-[1.02] shadow-sm"
                                    data-style="모던"
                                    data-prompt="Modern interior design, sleek lines, geometric shapes, neutral colors, polished surfaces, contemporary look, clean aesthetic, Empty room, unoccupied space, solely focused on the furniture">

                                    <img src="{{ asset('img/ai_button/modern.jpg') }}" 
                                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-out" 
                                        alt=" 스타일 배경">

                                    <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent group-hover:from-black/90 transition-colors duration-300"></div>

                                    <div class="relative z-10 h-full flex flex-col justify-center px-5">
                                        <span class="text-white font-bold text-lg drop-shadow-md">모던 스타일</span>
                                        <span class="text-stone-200 text-xs font-medium mt-1 drop-shadow-sm">세련된 라인과 도시적 감성</span>
                                    </div>


                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 z-20 opacity-0 scale-50 group-[.border-red-500]:opacity-100 group-[.border-red-500]:scale-100 transition-all duration-300 ease-back-out">
                                        <div class="bg-red-500 text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg shadow-red-500/30 border-2 border-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                        </div>
                                    </div>

                                    <div class="absolute inset-0 rounded-xl pointer-events-none transition-all duration-300 border-2 border-transparent group-[.border-red-500]:border-red-500 group-[.border-red-500]:ring-4 group-[.border-red-500]:ring-red-500/30 group-[.border-red-500]:ring-inset"></div>
                            </button>

                            {{-- 3. 미니멀리즘 스타일--}}
                            <button type="button" 
                                    class="btn-style-select relative w-full h-24 rounded-xl overflow-hidden group text-left transition-all hover:scale-[1.02] shadow-sm"
                                    data-style="미니멀리즘"
                                    data-prompt="Minimalist style, decluttered space, simple forms, monochromatic color scheme, less is more, calm atmosphere, Empty room, unoccupied space, solely focused on the furniture">

                                    <img src="{{ asset('img/ai_button/minimalism.jpg') }}" 
                                            class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-out" 
                                            alt=" 스타일 배경">

                                    <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent group-hover:from-black/90 transition-colors duration-300"></div>

                                    <div class="relative z-10 h-full flex flex-col justify-center px-5">
                                        <span class="text-white font-bold text-lg drop-shadow-md">미니멀리즘 스타일</span>
                                        <span class="text-stone-200 text-xs font-medium mt-1 drop-shadow-sm">심플하고 정돈된 미니멀 라이프</span>
                                    </div>

                                   <div class="absolute right-4 top-1/2 -translate-y-1/2 z-20 opacity-0 scale-50 group-[.border-red-500]:opacity-100 group-[.border-red-500]:scale-100 transition-all duration-300 ease-back-out">
                                        <div class="bg-red-500 text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg shadow-red-500/30 border-2 border-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                        </div>
                                    </div>

                                    <div class="absolute inset-0 rounded-xl pointer-events-none transition-all duration-300 border-2 border-transparent group-[.border-red-500]:border-red-500 group-[.border-red-500]:ring-4 group-[.border-red-500]:ring-red-500/30 group-[.border-red-500]:ring-inset"></div>
                            </button>

                            {{-- 4. 고딕 스타일--}}
                            <button type="button" 
                                    class="btn-style-select relative w-full h-24 rounded-xl overflow-hidden group text-left transition-all hover:scale-[1.02] shadow-sm"
                                    data-style="고딕"
                                    data-prompt="Gothic interior style, dramatic atmosphere, dark rich colors, ornate details, pointed arches, velvet textures, mysterious and grand, Empty room, unoccupied space, solely focused on the furniture">

                                    <img src="{{ asset('img/ai_button/gothic.jpg') }}" 
                                            class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-out" 
                                            alt=" 스타일 배경">

                                    <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent group-hover:from-black/90 transition-colors duration-300"></div>

                                    <div class="relative z-10 h-full flex flex-col justify-center px-5">
                                        <span class="text-white font-bold text-lg drop-shadow-md">고딕 스타일</span>
                                        <span class="text-stone-200 text-xs font-medium mt-1 drop-shadow-sm">중후한 무게감과 고풍스러운 미학</span>
                                    </div>

                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 z-20 opacity-0 scale-50 group-[.border-red-500]:opacity-100 group-[.border-red-500]:scale-100 transition-all duration-300 ease-back-out">
                                        <div class="bg-red-500 text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg shadow-red-500/30 border-2 border-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                        </div>
                                    </div>

                                    <div class="absolute inset-0 rounded-xl pointer-events-none transition-all duration-300 border-2 border-transparent group-[.border-red-500]:border-red-500 group-[.border-red-500]:ring-4 group-[.border-red-500]:ring-red-500/30 group-[.border-red-500]:ring-inset"></div>
                            </button>

                            {{-- 5. 인더스트리얼 스타일--}}
                            <button type="button" 
                                    class="btn-style-select relative w-full h-24 rounded-xl overflow-hidden group text-left transition-all hover:scale-[1.02] shadow-sm"
                                    data-style="인더스트리얼"
                                    data-prompt="Industrial loft style, exposed brick walls, concrete floors, metal accents, raw materials, high ceilings, urban vintage vibe, Empty room, unoccupied space, solely focused on the furniture">

                                    <img src="{{ asset('img/ai_button/industrial.jpg') }}" 
                                            class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-out" 
                                            alt=" 스타일 배경">

                                    <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent group-hover:from-black/90 transition-colors duration-300"></div>

                                    <div class="relative z-10 h-full flex flex-col justify-center px-5">
                                        <span class="text-white font-bold text-lg drop-shadow-md">인더스트리얼 스타일</span>
                                        <span class="text-stone-200 text-xs font-medium mt-1 drop-shadow-sm">투박함 속에 숨겨진 세련된 멋</span>
                                    </div>

                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 z-20 opacity-0 scale-50 group-[.border-red-500]:opacity-100 group-[.border-red-500]:scale-100 transition-all duration-300 ease-back-out">
                                        <div class="bg-red-500 text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg shadow-red-500/30 border-2 border-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                        </div>
                                    </div>

                                    <div class="absolute inset-0 rounded-xl pointer-events-none transition-all duration-300 border-2 border-transparent group-[.border-red-500]:border-red-500 group-[.border-red-500]:ring-4 group-[.border-red-500]:ring-red-500/30 group-[.border-red-500]:ring-inset"></div>
                            </button>

                            {{-- 6. 재팬디 스타일--}}
                            <button type="button" 
                                    class="btn-style-select relative w-full h-24 rounded-xl overflow-hidden group text-left transition-all hover:scale-[1.02] shadow-sm"
                                    data-style="재팬디"
                                    data-prompt="Japandi interior style, fusion of Japanese minimalism and Scandinavian functionalism, zen atmosphere, neutral beige palette, natural wood and bamboo textures, soft diffused lighting, clean lines, peaceful and organic vibe, Empty room, unoccupied space, solely focused on the furniture">

                                    <img src="{{ asset('img/ai_button/Japandi2.jpg') }}" 
                                            class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-out" 
                                            alt=" 스타일 배경">

                                    <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent group-hover:from-black/90 transition-colors duration-300"></div>

                                    <div class="relative z-10 h-full flex flex-col justify-center px-5">
                                        <span class="text-white font-bold text-lg drop-shadow-md">재팬디 스타일</span>
                                        <span class="text-stone-200 text-xs font-medium mt-1 drop-shadow-sm">차분하고 정적인 무드의 감성 인테리어</span>
                                    </div>

                                     <div class="absolute right-4 top-1/2 -translate-y-1/2 z-20 opacity-0 scale-50 group-[.border-red-500]:opacity-100 group-[.border-red-500]:scale-100 transition-all duration-300 ease-back-out">
                                        <div class="bg-red-500 text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg shadow-red-500/30 border-2 border-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                        </div>
                                    </div>

                                    <div class="absolute inset-0 rounded-xl pointer-events-none transition-all duration-300 border-2 border-transparent group-[.border-red-500]:border-red-500 group-[.border-red-500]:ring-4 group-[.border-red-500]:ring-red-500/30 group-[.border-red-500]:ring-inset"></div>
                            </button>

                            <input type="hidden" id="ai_input_prompt">

                            
                        </div>
                    </div>

                </div>
                
                <div class="p-4 border-t bg-stone-50 space-y-3"> 
    
                    <button type="button" id="btn_ai_generate" class="w-full py-3 bg-stone-800 text-white rounded-lg font-bold hover:bg-stone-700 transition-all flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7"/><line x1="16" x2="22" y1="5" y2="5"/><line x1="19" x2="19" y1="2" y2="8"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                        이미지 생성하기
                    </button>

                    <div class="flex gap-3 w-full">
               
                        <button type="button" onclick="modalClose('#ai_image_generator_modal')" class="flex-1 h-[48px] text-base border border-stone-300 text-stone-600 bg-white hover:bg-stone-50 rounded-lg font-medium transition-colors">
                            취소
                        </button>
                        <button type="button" id="btn_ai_confirm" class="flex-1 btn btn-primary h-[48px] text-base rounded-lg flex items-center justify-center">
                            완료 및 저장
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <div id="ai_full_loading_overlay" class="absolute inset-0 z-50 bg-white/90 flex flex-col items-center justify-center hidden">
            {{-- 스피너 아이콘 --}}
            <div class="w-12 h-12 border-4 border-stone-200 border-t-stone-800 rounded-full animate-spin mb-4"></div>
            
            {{-- 안내 문구 --}}
            <h4 class="text-xl font-bold text-stone-800 mb-1">AI 이미지 생성 중...</h4>
            <p class="text-stone-500 text-sm">잠시만 기다려주세요. (약 10~20초 소요)</p>
        </div>
    </div>
</div>


<script>
    var targetImgPreviewId = ""; // 예: '#rep_img_preview' (이미지가 바뀔 태그 ID)
    var targetHiddenInputId = ""; // 예: '#rep_img_path' (서버로 보낼 경로가 담길 input ID)
    var originalFilesBackup = {};
    
    $(document).off('click', '#btn_ai_confirm').on('click', '#btn_ai_confirm', function() {

        var $activeStyleBtn = $('.btn-style-select.border-red-500'); // 현재 선택된 스타일 버튼

        
        if ($activeStyleBtn.length > 0 && $activeStyleBtn.find('.generated-badge').length === 0) {
            alert("아직 AI 이미지가 생성되지 않았습니다.\n하단의 [이미지 생성하기] 버튼을 먼저 눌러주세요.");
            return false; 
        }
    
        var generatedUrl = $('#ai_modal_preview_image').attr('src');
        if (!generatedUrl || generatedUrl === "") {
            alert("생성된 이미지가 없습니다. 먼저 스타일 생성을 진행해주세요.");
            return;
        }

        if (!targetImgPreviewId) {
            alert("적용할 대상을 찾을 수 없습니다.");
            return;
        }

        // 1. 메인 파일의 위치 찾기
        var fileIndex = storedFiles.findIndex(function(f) { return f.name === currentAiFile.name; });
        
        if (fileIndex === -1) {
            alert("원본 이미지를 데이터에서 찾을 수 없어 교체할 수 없습니다.");
            return;
        }

        // ★ 2. 각 리사이징 배열별로 정확한 위치(Index)를 따로 찾습니다.
        var idx100 = stored100Files.findIndex(function(f) { return f.name === currentAiFile.name; });
        var idx400 = stored400Files.findIndex(function(f) { return f.name === currentAiFile.name; });
        var idx600 = stored600Files.findIndex(function(f) { return f.name === currentAiFile.name; });
        var idx1000 = stored1000Files.findIndex(function(f) { return f.name === currentAiFile.name; });

        // (기존 이미지를 돌렸을 경우 등을 대비한 방어 코드: 못 찾으면 기존 fileIndex로 대체)
        if(idx100 === -1) idx100 = fileIndex;
        if(idx400 === -1) idx400 = fileIndex;
        if(idx600 === -1) idx600 = fileIndex;
        if(idx1000 === -1) idx1000 = fileIndex;

        // 백업 생성
        if (!originalFilesBackup[currentAiFile.name]) {
            originalFilesBackup[currentAiFile.name] = {
                main: storedFiles[fileIndex],
                f100: stored100Files[idx100],
                f400: stored400Files[idx400],
                f600: stored600Files[idx600],
                f1000: stored1000Files[idx1000]
            };
        }

        var $btn = $(this);
        var originalBtnText = $btn.html();
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> 이미지 적용 중...');

        // 3. AI 이미지 URL을 읽어서 리사이징 후 정확한 인덱스에 '덮어쓰기'
        fetch(generatedUrl)
            .then(res => res.blob())
            .then(blob => {
                var newFileName = "ai_" + currentAiFile.name;
                var newFile = new File([blob], newFileName, { type: blob.type || "image/jpeg" });

                var resizePromises = [];

                resizePromises.push(new Promise((resolve) => {
                    var image = new Image();
                    image.crossOrigin = "Anonymous";
                    image.onload = function() {
                        var resizedFile = getThumbFile(image, 500, this.width, this.height);
                        resizedFile.name = newFileName;
                        storedFiles[fileIndex] = resizedFile; // 메인은 fileIndex
                        resolve();
                    };
                    image.src = generatedUrl;
                }));

                resizePromises.push(new Promise((resolve) => {
                    var image100 = new Image(); image100.width = 100; image100.height = 100; image100.crossOrigin = "Anonymous";
                    image100.onload = function() { 
                        var i100 = getThumbFile(image100, 100, this.width, this.height); 
                        i100.name = newFileName; 
                        stored100Files[idx100] = i100; // ★ 정확한 위치(idx100)에 덮어쓰기
                        resolve(); 
                    };
                    image100.src = generatedUrl;
                }));

                resizePromises.push(new Promise((resolve) => {
                    var image400 = new Image(); image400.width = 400; image400.height = 400; image400.crossOrigin = "Anonymous";
                    image400.onload = function() { 
                        var i400 = getThumbFile(image400, 400, this.width, this.height); 
                        i400.name = newFileName; 
                        stored400Files[idx400] = i400; // ★ 정확한 위치(idx400)에 덮어쓰기
                        resolve(); 
                    };
                    image400.src = generatedUrl;
                }));

                resizePromises.push(new Promise((resolve) => {
                    var image600 = new Image(); image600.crossOrigin = "Anonymous";
                    image600.onload = function() { 
                        var i600 = getThumbFile(image600, 600, this.width, this.height); 
                        i600.name = newFileName; 
                        stored600Files[idx600] = i600; // ★ 정확한 위치(idx600)에 덮어쓰기
                        resolve(); 
                    };
                    image600.src = generatedUrl;
                }));

                resizePromises.push(new Promise((resolve) => {
                    var image1000 = new Image(); image1000.width = 1000; image1000.height = 1000; image1000.crossOrigin = "Anonymous";
                    image1000.onload = function() { 
                        var i1000 = getThumbFile(image1000, 1000, this.width, this.height); 
                        i1000.name = newFileName; 
                        stored1000Files[idx1000] = i1000; // ★ 정확한 위치(idx1000)에 덮어쓰기
                        resolve(); 
                    };
                    image1000.src = generatedUrl;
                }));

                Promise.all(resizePromises).then(() => {
                    currentAiFile = newFile;

                    if(targetAiBtn) {
                        $(targetAiBtn).closest('.product-img__add').attr('file', newFileName);
                    }
                    if(targetHiddenInputId) {
                        $(targetHiddenInputId).val(generatedUrl);
                    }
                    if ($(targetImgPreviewId).length > 0) {
                        $(targetImgPreviewId).attr('src', generatedUrl);
                    }

                    $btn.prop('disabled', false).html(originalBtnText);
                    modalClose('#ai_image_generator_modal');
                    modalOpen('#ai-apply-success-modal');

                    if (tempAiFilesToDelete.length > 0) {
                        $.ajax({
                            url: '/product/ai/cleanup', 
                            type: 'POST',
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            data: { files: tempAiFilesToDelete },
                            success: function(response) { tempAiFilesToDelete = []; },
                            error: function(err) { console.error('임시 파일 정리 실패:', err); }
                        });
                    }
                });
            })
            .catch(err => {
                console.error(err);
                alert("이미지 데이터를 변환하는 중 오류가 발생했습니다.");
                $btn.prop('disabled', false).html(originalBtnText);
            });
    });
</script>