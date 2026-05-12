{{-- 모바일용 AI 스튜디오 모달 --}}
<div class="modal" id="ai_image_generator_modal">
    <div class="modal_bg" onclick="modalClose('#ai_image_generator_modal')"></div>
    
    <div class="modal_inner" style="width: 100%; max-width: 100vw; height: 100vh; padding: 0; border-radius: 0; display: flex; flex-direction: column; overflow: hidden; background-color: #fff;">
        
        {{-- 헤더 (모바일 상단 고정) --}}
        <div class="flex items-center justify-between px-4 py-3 border-b bg-white shrink-0">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-primary/10 rounded-md flex items-center justify-center text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7"/><line x1="16" x2="22" y1="5" y2="5"/><line x1="19" x2="19" y1="2" y2="8"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-stone-900 ">AI 스튜디오</h3>
                </div>
            </div>
            <button class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-stone-100 transition-colors" onclick="modalClose('#ai_image_generator_modal')">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-stone-500"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>

        {{-- 스크롤 가능한 본문 영역 (PC의 좌우 분할을 상하로 변경) --}}
        <div class="flex-1 overflow-y-auto bg-stone-50">

            {{--원본 이미지 영역 --}}
            <div class="relative bg-white border-b flex flex-col">
                <div class="h-10 border-b bg-stone-50 flex items-center justify-between px-3">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-stone-500">원본 이미지</span>
                    </div>
                </div>

                <div class="relative w-full aspect-square max-h-[40vh] bg-stone-100 flex items-center justify-center p-2">
                    <div class="absolute inset-0 bg-white"></div>
                    <img id="ai_modal_thumbnail" src="" class="relative z-10 w-full h-full object-contain mx-auto">
                </div>
            </div>
                        
            {{--미리보기 영역 --}}
            <div class="relative bg-white border-b flex flex-col">
                <div class="h-10 border-b bg-stone-50 flex items-center justify-between px-3">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-stone-500">미리보기</span>
                        <span id="ai_remain_count_display" class="text-[10px] text-primary font-medium bg-primary/10 px-2 py-0.5 rounded-full hidden"></span>
                    </div>
                </div>

                {{-- 모바일 환경을 고려해 높이를 제한 (aspect-square 혹은 최대 높이 지정) --}}
                <div class="relative w-full aspect-square max-h-[40vh] bg-stone-100 flex items-center justify-center p-2">
                    <div class="absolute inset-0 bg-white"></div>
                    <img id="ai_modal_preview_image" src="" class="relative z-10 w-full h-full object-contain mx-auto">

                    <div id="ai_style_preview_badge"
                        class="absolute left-4 top-4 z-30 hidden rounded-lg bg-black/75 px-4 py-2 text-sm font-bold text-white shadow">
                        스타일 미리보기
                    </div>
                    
                    {{-- 플레이스홀더 --}}
                    <div id="ai_modal_placeholder_text" class="absolute inset-0 flex flex-col items-center justify-center z-20 bg-white/80">
                        <svg class="w-10 h-10 text-stone-300 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        <p class="text-stone-400 text-xs">이미지를 불러오는 중...</p>
                    </div>
                </div>
            </div>

            {{-- [하단] 스타일 선택 영역 --}}
            <div class="p-4 bg-white">

                <label class="block text-sm font-bold text-stone-700 mb-3">배경 스타일</label>
                
                {{-- PC의 세로 나열을 2열 그리드로 변경 --}}
                <div class="grid grid-cols-2 gap-2 mb-4">
                    
                    {{-- 배경제거 버튼 (전체 너비 차지) --}}
                    <button type="button"
                        id="btn_remove_bg"
                        class="btn-style-select group relative col-span-2 py-2.5 pr-10 bg-white border-2 border-red-300 rounded-lg text-stone-900 text-sm font-bold hover:bg-red-50 hover:border-red-500 hover:text-stone-900 shadow-sm transition-all flex items-center justify-center gap-2"
                        data-style="배경제거"
                        data-action="remove_bg"
                        data-prompt="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3l18 18"/><path d="M15 4.5l-4 4"/><path d="M14 20l-4-4"/><path d="M8 20l4-4"/><circle cx="18" cy="6" r="3"/><circle cx="6" cy="18" r="3"/></svg>
                        <span>배경제거</span>

                        <div class="absolute right-2 top-1/2 -translate-y-1/2 z-20 opacity-0 scale-50 group-[.border-red-500]:opacity-100 group-[.border-red-500]:scale-100 transition-all duration-300 ease-back-out">
                            <div class="bg-red-500 text-white w-7 h-7 rounded-full flex items-center justify-center shadow-lg shadow-red-500/30 border-2 border-white">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="14"
                                    height="14"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="3"
                                    stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                            </div>
                        </div>

                        <div class="absolute inset-0 rounded-lg pointer-events-none transition-all duration-300 border-2 border-transparent group-[.border-red-500]:border-red-500 group-[.border-red-500]:ring-2 group-[.border-red-500]:ring-red-500/20 group-[.border-red-500]:ring-inset"></div>
                    </button>

                    {{-- 1. 북유럽 --}}
                    <button type="button" class="btn-style-select relative w-full h-20 rounded-lg overflow-hidden group text-left shadow-sm" data-style="북유럽" data-prompt="Nordic style, natural wood tones, bright and airy, beige and white palette, cozy textures, functional design, warm atmosphere, Empty room, unoccupied space, solely focused on the furniture">
                        <img src="{{ asset('img/ai_button/nordic.jpg') }}" class="absolute inset-0 w-full h-full object-cover" alt="북유럽">
                        <div class="absolute inset-0 bg-black/50 group-[.border-primary]:bg-black/70"></div>
                        <div class="relative z-10 h-full flex flex-col justify-center px-3">
                            <span class="text-white font-bold text-sm">북유럽</span>
                        </div>
                        <div class="absolute right-2 top-1/2 -translate-y-1/2 z-20 opacity-0 scale-50 group-[.border-red-500]:opacity-100 group-[.border-red-500]:scale-100 transition-all duration-300 ease-back-out">
                                <div class="bg-red-500 text-white w-8 h-8 rounded-full flex items-center justify-center shadow-lg shadow-red-500/30 border-2 border-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                </div>
                            </div>
                        <div class="absolute inset-0 rounded-lg pointer-events-none transition-all duration-300 border-2 border-transparent group-[.border-red-500]:border-red-500 group-[.border-red-500]:ring-2 group-[.border-red-500]:ring-red-500/30 group-[.border-red-500]:ring-inset"></div>                    
                    </button>

                    {{-- 2. 모던 --}}
                    <button type="button" class="btn-style-select relative w-full h-20 rounded-lg overflow-hidden group text-left shadow-sm" data-style="모던" data-prompt="Modern interior design, sleek lines, geometric shapes, neutral colors, polished surfaces, contemporary look, clean aesthetic, Empty room, unoccupied space, solely focused on the furniture">
                        <img src="{{ asset('img/ai_button/modern.jpg') }}" class="absolute inset-0 w-full h-full object-cover" alt="모던">
                        <div class="absolute inset-0 bg-black/50 group-[.border-primary]:bg-black/70"></div>
                        <div class="relative z-10 h-full flex flex-col justify-center px-3">
                            <span class="text-white font-bold text-sm">모던</span>
                        </div>
                        <div class="absolute right-2 top-1/2 -translate-y-1/2 z-20 opacity-0 scale-50 group-[.border-red-500]:opacity-100 group-[.border-red-500]:scale-100 transition-all duration-300 ease-back-out">
                                <div class="bg-red-500 text-white w-8 h-8 rounded-full flex items-center justify-center shadow-lg shadow-red-500/30 border-2 border-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                </div>
                            </div>
                        <div class="absolute inset-0 rounded-lg pointer-events-none transition-all duration-300 border-2 border-transparent group-[.border-red-500]:border-red-500 group-[.border-red-500]:ring-2 group-[.border-red-500]:ring-red-500/30 group-[.border-red-500]:ring-inset"></div>                                        
                    </button>

                    {{-- 3. 미니멀리즘 --}}
                    <button type="button" class="btn-style-select relative w-full h-20 rounded-lg overflow-hidden group text-left shadow-sm" data-style="미니멀리즘" data-prompt="Minimalist interior style, calm and refined atmosphere, clean uncluttered space, simple architectural lines, neutral white and soft gray palette, subtle warm beige accents, natural daylight, premium showroom mood, spacious modern room, carefully balanced composition, realistic floor and wall materials, tasteful minimal styling, quiet luxury interior, solely focused on the selected furniture, remove unrelated partial objects at the image borders, replace background clutter with clean floor or wall, no people, no showroom clutter, no random objects, no extra furniture, no text, no logos">
                        <img src="{{ asset('img/ai_button/minimalism.jpg') }}" class="absolute inset-0 w-full h-full object-cover" alt="미니멀리즘">
                        <div class="absolute inset-0 bg-black/50 group-[.border-primary]:bg-black/70"></div>
                        <div class="relative z-10 h-full flex flex-col justify-center px-3">
                            <span class="text-white font-bold text-sm">미니멀리즘</span>
                        </div>
                        <div class="absolute right-2 top-1/2 -translate-y-1/2 z-20 opacity-0 scale-50 group-[.border-red-500]:opacity-100 group-[.border-red-500]:scale-100 transition-all duration-300 ease-back-out">
                                <div class="bg-red-500 text-white w-8 h-8 rounded-full flex items-center justify-center shadow-lg shadow-red-500/30 border-2 border-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                </div>
                            </div>
                        <div class="absolute inset-0 rounded-lg pointer-events-none transition-all duration-300 border-2 border-transparent group-[.border-red-500]:border-red-500 group-[.border-red-500]:ring-2 group-[.border-red-500]:ring-red-500/30 group-[.border-red-500]:ring-inset"></div>                                        
                    </button>

                    {{-- 4. 고딕 --}}
                    <button type="button" class="btn-style-select relative w-full h-20 rounded-lg overflow-hidden group text-left shadow-sm" data-style="고딕" data-prompt="Modern Gothic interior style, elegant dark-toned premium showroom, deep charcoal and warm wood palette, subtle Gothic arches, refined ornate details, realistic floor and wall materials, soft directional lighting, balanced composition, luxurious but clean furniture showroom atmosphere, harmonize the background with the selected furniture, solely focused on the selected furniture, no people, no showroom clutter, no random objects, no extra furniture, no text, no logos">
                        <img src="{{ asset('img/ai_button/gothic.jpg') }}" class="absolute inset-0 w-full h-full object-cover" alt="고딕">
                        <div class="absolute inset-0 bg-black/50 group-[.border-primary]:bg-black/70"></div>
                        <div class="relative z-10 h-full flex flex-col justify-center px-3">
                            <span class="text-white font-bold text-sm">고딕</span>
                        </div>
                        <div class="absolute right-2 top-1/2 -translate-y-1/2 z-20 opacity-0 scale-50 group-[.border-red-500]:opacity-100 group-[.border-red-500]:scale-100 transition-all duration-300 ease-back-out">
                                <div class="bg-red-500 text-white w-8 h-8 rounded-full flex items-center justify-center shadow-lg shadow-red-500/30 border-2 border-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                </div>
                            </div>
                        <div class="absolute inset-0 rounded-lg pointer-events-none transition-all duration-300 border-2 border-transparent group-[.border-red-500]:border-red-500 group-[.border-red-500]:ring-2 group-[.border-red-500]:ring-red-500/30 group-[.border-red-500]:ring-inset"></div>                                        
                    </button>

                    {{-- 5. 인더스트리얼 --}}
                    <button type="button" class="btn-style-select relative w-full h-20 rounded-lg overflow-hidden group text-left shadow-sm" data-style="인더스트리얼" data-prompt="Industrial loft style, exposed brick walls, concrete floors, metal accents, raw materials, high ceilings, urban vintage vibe, Empty room, unoccupied space, solely focused on the furniture">
                        <img src="{{ asset('img/ai_button/industrial.jpg') }}" class="absolute inset-0 w-full h-full object-cover" alt="인더스트리얼">
                        <div class="absolute inset-0 bg-black/50 group-[.border-primary]:bg-black/70"></div>
                        <div class="relative z-10 h-full flex flex-col justify-center px-3">
                            <span class="text-white font-bold text-sm">인더스트리얼</span>
                        </div>
                        <div class="absolute right-2 top-1/2 -translate-y-1/2 z-20 opacity-0 scale-50 group-[.border-red-500]:opacity-100 group-[.border-red-500]:scale-100 transition-all duration-300 ease-back-out">
                                <div class="bg-red-500 text-white w-8 h-8 rounded-full flex items-center justify-center shadow-lg shadow-red-500/30 border-2 border-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                </div>
                            </div>
                        <div class="absolute inset-0 rounded-lg pointer-events-none transition-all duration-300 border-2 border-transparent group-[.border-red-500]:border-red-500 group-[.border-red-500]:ring-2 group-[.border-red-500]:ring-red-500/30 group-[.border-red-500]:ring-inset"></div>                                        
                    </button>
                    
                    {{-- 6. 재팬디 --}}
                    <button type="button" class="btn-style-select relative w-full h-20 rounded-lg overflow-hidden group text-left shadow-sm" data-style="재팬디" data-prompt="Japandi interior style, refined modern room, Japanese minimalism and Scandinavian functionalism, natural wood and bamboo details, warm neutral palette, clean architectural lines, calm premium showroom atmosphere, realistic interior photography, clear natural daylight, balanced contrast, crisp material textures, realistic floor and wall materials, solely focused on the selected furniture, no people, no showroom clutter, no random objects, no text, no logos"
>
                        <img src="{{ asset('img/ai_button/Japandi2.jpg') }}" class="absolute inset-0 w-full h-full object-cover" alt="재팬디">
                        <div class="absolute inset-0 bg-black/50 group-[.border-primary]:bg-black/70"></div>
                        <div class="relative z-10 h-full flex flex-col justify-center px-3">
                            <span class="text-white font-bold text-sm">재팬디</span>
                        </div>
                        <div class="absolute right-2 top-1/2 -translate-y-1/2 z-20 opacity-0 scale-50 group-[.border-red-500]:opacity-100 group-[.border-red-500]:scale-100 transition-all duration-300 ease-back-out">
                                <div class="bg-red-500 text-white w-8 h-8 rounded-full flex items-center justify-center shadow-lg shadow-red-500/30 border-2 border-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                </div>
                            </div>
                        <div class="absolute inset-0 rounded-lg pointer-events-none transition-all duration-300 border-2 border-transparent group-[.border-red-500]:border-red-500 group-[.border-red-500]:ring-2 group-[.border-red-500]:ring-red-500/30 group-[.border-red-500]:ring-inset"></div>                                        
                    </button>

                    <input type="hidden" id="ai_input_prompt">
                </div>
            </div>
        </div>

        {{-- 하단 고정 버튼 영역 --}}
        <div class="p-3 border-t bg-white shrink-0 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] z-20 space-y-2"> 
            <button type="button" id="btn_ai_generate"
                class="w-full py-3 bg-white border-2 border-red-500 text-stone-900 rounded-lg text-sm font-bold hover:bg-red-50 hover:border-red-600 hover:text-stone-900 active:bg-red-100 shadow-sm shadow-red-100 transition-all flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7"/><line x1="16" x2="22" y1="5" y2="5"/><line x1="19" x2="19" y1="2" y2="8"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                이미지 생성하기
            </button>
            <div class="flex gap-2 w-full">
                <button type="button" onclick="modalClose('#ai_image_generator_modal')" class="flex-1 py-3 text-sm border border-stone-300 text-stone-600 bg-white rounded-lg font-medium">
                    취소
                </button>
                <button type="button" id="btn_ai_confirm_m" 
                    class="flex-1 py-3 text-white text-sm rounded-lg font-medium flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed" 
                    style="display: flex !important; background-color: #fb4760 !important; -webkit-appearance: none; appearance: none;"> 완료 및 저장
                </button>
            </div>
        </div>

        {{-- 전체 화면 로딩 오버레이 --}}
        <div id="ai_full_loading_overlay" class="absolute inset-0 z-50 bg-white/95 flex flex-col items-center justify-center hidden">
            <div class="w-10 h-10 border-4 border-stone-200 border-t-stone-800 rounded-full animate-spin mb-3"></div>
            <h4 class="text-lg font-bold text-stone-800 mb-1">AI 이미지 생성 중...</h4>
            <p class="text-stone-500 text-xs">잠시만 기다려주세요 (약 10~20초)</p>
        </div>
    </div>
</div>

<script>
    var targetImgPreviewId = "";
    var targetHiddenInputId = "";
    var originalFilesBackup = {};

    $(document)
        .off('click.aiConfirmMobile', '#btn_ai_confirm_m')
        .on('click.aiConfirmMobile', '#btn_ai_confirm_m', function() {

        var $activeStyleBtn = $('.btn-style-select.border-red-500');
        var $removeBgBtn = $('#btn_remove_bg');
        var removeBgUrl = $removeBgBtn.attr('data-generated-url');
        var previewUrl = $('#ai_modal_preview_image').attr('src');

        if (removeBgUrl && previewUrl === removeBgUrl) {
            $activeStyleBtn = $removeBgBtn;
        } else if ($activeStyleBtn.length === 0 && removeBgUrl) {
            $activeStyleBtn = $removeBgBtn;
        }

        var generatedStyleUrl = $activeStyleBtn.attr('data-generated-url');
        var isRemoveBgResult = $activeStyleBtn.is('#btn_remove_bg');

        if (
            $activeStyleBtn.length === 0 ||
            !generatedStyleUrl ||
            (!isRemoveBgResult && $activeStyleBtn.find('.generated-badge').length === 0)
        ) {
            modalOpen('#ai-not-generated-modal');
            return false;
        }

        var generatedUrl = generatedStyleUrl;


        if (!generatedUrl || generatedUrl === "") {
            alert("생성된 이미지가 없습니다. 먼저 스타일 생성을 진행해주세요.");
            return;
        }

        if (!currentAiFile) {
            alert("작업할 이미지가 없습니다.");
            return;
        }

        if (!targetImgPreviewId) {
            alert("적용할 대상을 찾을 수 없습니다.");
            return;
        }

        var fileIndex = storedFiles.findIndex(function(f) {
            return f && f.name === currentAiFile.name;
        });

        
        if (fileIndex === -1) {
            alert("원본 이미지를 데이터에서 찾을 수 없어 교체할 수 없습니다.");
            return;
        }

        
        var idx100 = stored100Files.findIndex(function(f) {
            return f && f.name === currentAiFile.name;
        });
        var idx400 = stored400Files.findIndex(function(f) {
            return f && f.name === currentAiFile.name;
        });
        var idx600 = stored600Files.findIndex(function(f) {
            return f && f.name === currentAiFile.name;
        });
        var idx1000 = stored1000Files.findIndex(function(f) {
            return f && f.name === currentAiFile.name;
        });

        if (idx100 === -1) idx100 = stored100Files.length;
        if (idx400 === -1) idx400 = stored400Files.length;
        if (idx600 === -1) idx600 = stored600Files.length;
        if (idx1000 === -1) idx1000 = stored1000Files.length;

      
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
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> 저장 중...');

       
        fetch(generatedUrl)
            .then(res => res.blob())
            .then(blob => {
                var newFileName = "ai_" + currentAiFile.name;
                var newFile = new File([blob], newFileName, { type: blob.type || "image/jpeg" });

                var resizePromises = [];

                // 메인 사이즈
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

                // 100 사이즈
                resizePromises.push(new Promise((resolve) => {
                    var image100 = new Image(); image100.width = 100; image100.height = 100; image100.crossOrigin = "Anonymous";
                    image100.onload = function() { 
                        var i100 = getThumbFile(image100, 100, this.width, this.height); 
                        i100.name = newFileName; 
                        stored100Files[idx100] = i100; 
                        resolve(); 
                    };
                    image100.src = generatedUrl;
                }));

                // 400 사이즈
                resizePromises.push(new Promise((resolve) => {
                    var image400 = new Image(); image400.width = 400; image400.height = 400; image400.crossOrigin = "Anonymous";
                    image400.onload = function() { 
                        var i400 = getThumbFile(image400, 400, this.width, this.height); 
                        i400.name = newFileName; 
                        stored400Files[idx400] = i400; 
                        resolve(); 
                    };
                    image400.src = generatedUrl;
                }));

                // 600 사이즈
                resizePromises.push(new Promise((resolve) => {
                    var image600 = new Image(); image600.crossOrigin = "Anonymous";
                    image600.onload = function() { 
                        var i600 = getThumbFile(image600, 600, this.width, this.height); 
                        i600.name = newFileName; 
                        stored600Files[idx600] = i600; 
                        resolve(); 
                    };
                    image600.src = generatedUrl;
                }));

                // 1000 사이즈
                resizePromises.push(new Promise((resolve) => {
                    var image1000 = new Image(); image1000.width = 1000; image1000.height = 1000; image1000.crossOrigin = "Anonymous";
                    image1000.onload = function() { 
                        var i1000 = getThumbFile(image1000, 1000, this.width, this.height); 
                        i1000.name = newFileName; 
                        stored1000Files[idx1000] = i1000; 
                        resolve(); 
                    };
                    image1000.src = generatedUrl;
                }));

               
                Promise.all(resizePromises).then(() => {
                    currentAiFile = newFile;

                    // [중요] 폼 전송을 위해 DOM 속성 업데이트
                    if(typeof targetAiBtn !== 'undefined' && targetAiBtn) {
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

                    // 서버 임시 파일 정리
                    if (typeof tempAiFilesToDelete !== 'undefined' && tempAiFilesToDelete.length > 0) {
                        $.ajax({
                            url: '/product/ai/cleanup', 
                            type: 'POST',
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            data: { files: tempAiFilesToDelete },
                            success: function(response) {
                                console.log('모바일 서버 임시 파일 정리 완료:', response);
                                tempAiFilesToDelete = []; // 비우기
                            },
                            error: function(err) {
                                console.error('모바일 임시 파일 정리 실패:', err);
                            }
                        });
                    }
                });
            })
            .catch(err => {
                console.error(err);
                alert("오류가 발생했습니다.");
                $btn.prop('disabled', false).html(originalBtnText);
            });
    });
</script>
