@extends('layouts.app_m')
@section('content')
<div id="content" class="product_reg" data-loadtype="">
    <div class="detail_mo_top write_type center_type">
        <div class="inner">
            <h3>
                @if(Route::current()->getName() == 'product.create')
                    상품 등록
                @elseif(Route::current()->getName() == 'product.modify')
                    상품 수정
                @endif
            </h3>
            <a class="back_img" href="/"><svg><use xlink:href="/img/m/icon-defs.svg#x"></use></svg></a>
        </div>
    </div>

    <div class="prod_regist prod_regist_box com_setting ">
        <div class="step1 active">
            <div class="top_info flex itmes-center justify-between">
                <h6>상품 기본 정보</h6>
                <p class="txt-gray"><span class="txt-primary">*</span>는 필수 입력 항목입니다.</p>
            </div>
            <div class="divided"></div>
            <div class="inner">
                <dl class="mb-3">
                    <dt class="necessary">상품명</dt>
                    <dd>
                        <input type="text" id="form-list01" name="name" @if(@isset($data->name)) value="{{$data->name}}" @endif class="input-form w-full" placeholder="상품명을 입력해주세요.">
                    </dd>
                </dl>
                <dl class="mb-3">
                    <dt class="necessary">상품 이미지</dt>
                    <dd>
                        <div class="flex flex-wrap items-start gap-3 desc__product-img-wrap">
                            <div class="border border-dashed w-[150px] h-[194px] rounded-md relative flex items-center justify-center product-img__gallery">
                                <input type="file" class="file_input" id="form-list02" name="file" multiple="multiple" required placeholder="이미지 추가">
                                <div>
                                    <div class="file_text flex flex-col items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image text-stone-400"><rect width="20" height="20" x="3" y="3" rx="2" ry="2"></rect><circle cx="9" cy="9" r="2"></circle><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path></svg>
                                        <span class="text-stone-400">이미지 추가</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="info">
                            <div class="">
                                <p class="text-primary">· 첫번째 이미지가 대표 이미지로 노출됩니다.</p>
                                <p>· 이미지는 8개까지 등록 가능합니다.</p>
                                <p>· AI 배경 생성 버튼으로 AI 이미지 생성이 가능합니다.</p>
                                <p>· AI 수정 이미지 사용 책임은 제품 등록자에게 있습니다.</p>
                            </div>
                        </div>
                    </dd>
                </dl>
            </div>
            <div class="divided"></div>
            <div class="inner">
                <dl class="mb-3">
                    <dt class="necessary">카테고리</dt>
                    <dd>
                        <button class="btn btn-line4 nohover flex items-center justify-between !w-full px-3 font-normal" onclick="modalOpen('#prod_category-modal')">
                            카테고리 선택
                            <svg class="w-6 h-6 stroke-stone-400 -rotate-90"><use xlink:href="/img/m/icon-defs.svg#drop_b_arrow"></use></svg>
                        </button>

                        <div class="mt-3">
                            <div class="txt-primary">선택된 카테고리</div>
                            <div id="categoryIdx">-</div>
                        </div>
                    </dd>
                </dl>
                <dl class="propertyList mb-3 hidden">
                    <dt class="necessary">상품 속성</dt>
                    <dd>
                        <button class="btn btn-line4 nohover flex items-center justify-between !w-full px-3 font-normal" onclick="modalOpen('#prod_property-modal')">
                            속성 선택
                            <svg class="w-6 h-6 stroke-stone-400 -rotate-90"><use xlink:href="/img/m/icon-defs.svg#drop_b_arrow"></use></svg>
                        </button>
                        <div class="checkedProperties mb-5"></div>
                        <div class="info">
                            <div class="flex items-start gap-1">
                                <img class="w-3 mt-1 shrink-0" src="/img/member/info_icon.svg" alt="">
                                <p>상품 속성은 기입하지 않으셔도 됩니다. <span class="txt-primary">속성 추가가 필요한 경우, 1:1 문의를 통해 올펀에 요청해 주세요.</span></p>
                            </div>
                        </div>
                    </dd>
                </dl>
            </div>
            <div class="bot_btn">
                <button class="btn btn-primary w-full" onclick="goStep('step2', 'n')">다음 (1/4)</button>
            </div>
        </div>

        <div class="step2">
            <div class="top_info flex itmes-center justify-between">
                <h6>상품 기본 정보</h6>
            </div>
            <div class="inner">
                <dl class="mb-3 mt-3">
                    <dt class="necessary">상품 가격</dt>
                    <dd>
                        <input type="number" id="product-price" name="price" oninput="this.value = this.value.replace(/[^0-9.]/g, '');" value="0" class="input-form w-full" placeholder="숫자만 입력해주세요.">
                    </dd>
                </dl>
                <dl class="mb-3">
                    <dt class="necessary">가격 노출</dt>
                    <dd>
                        <div class="flex gap-2 btn_select">
                            <button class="is_price_open w-1/2 active" data-val="1">노출</button>
                            <button class="is_price_open w-1/2" data-val="0">미노출</button>
                        </div>
                        <input type="hidden" class="price_text" name="price_text" value="업체 문의">
                        <!--
                        <div class="btn_select_cont mt-2">
                            <div class='div_ptxt1'></div>
                            <div class='div_ptxt0'>
                                <div class="dropdown_wrap">
                                    <button class="dropdown_btn price_text">가격 안내 문구 선택</button>
                                    <div class="dropdown_list">
                                        <div class="dropdown_item">수량마다 상이</div>
                                        <div class="dropdown_item">업체 문의</div>
                                    </div>
                                </div>
                                <div class="info">
                                    <div class="flex items-center gap-1">
                                        <img class="w-4" src="/img/member/info_icon.svg" alt="">
                                        <p> 가격 대신 선택한 문구가 노출됩니다.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        -->
                    </dd>
                </dl>
            </div>
            <input type="hidden" class="is_new_product" value="1">

            <div class="bot_btn">
                <button class="btn btn-primary-line w-1/3" onclick="goStep('step1', 'p')">이전</button>
                <button class="btn btn-primary w-2/3" onclick="goStep('step3', 'n')">다음 (2/4)</button>
            </div>
        </div>

        <input type="hidden" name="product_code">
        <input type="hidden" name="notice_info" id="form-list09">

        <div class="step3">
            <div class="top_info flex itmes-center justify-between">
                <h6>상품 기본 정보</h6>
            </div>

            <div class="prod_detail_write">
                <div class="top_info">
                    <h6>상품 상세 내용</h6>
                    {{-- <button onclick="modalOpen('#writing_guide_modal')">상세 내용 작성 가이드</button> --}}
                </div>
                <textarea class="prod_detail_area" placeholder="내용을 입력해주세요."></textarea>
            </div>

            <div class="bot_btn">
                <button class="btn btn-primary-line w-1/3" onclick="goStep('step2', 'p')">이전</button>
                <button class="btn btn-primary w-2/3" onclick="goStep('step4', 'n')">다음 (3/4)</button>
            </div>
        </div>

        <div class="step4">
            <div class="top_info flex itmes-center justify-between">
                <h6>상품 주문 옵션</h6>
            </div>
            <div class="inner">
                <div class="info">
                    <div class="flex items-start gap-1">
                        <img class="w-4 mt-0.5" src="/img/member/info_icon.svg" alt="">
                        <p><span class="text-primary">주문 시 필수로 받아야 하는 옵션은 ‘필수 옵션’을 설정해주세요.</span> 필수 옵션의 경우, 주문 시 상위 옵션을 선택해야 하위 옵션 선택이 가능합니다. 상위 개념의 옵션을 옵션 1로 설정해주세요.</p>
                    </div>
                    <div class="flex items-start gap-1 mt-3">
                        <img class="w-4 mt-1" src="/img/member/info_icon.svg" alt="">
                        <p><span class="text-primary">등록한 상품 외 추가로 금액 산정이 필요한 구성품인 경우, 옵션값 하단에 반드시 가격을 입력해주세요.</span></p>
                    </div>
                    <div class="flex items-center gap-1 mt-3">
                        <img class="w-4" src="/img/member/info_icon.svg" alt="">
                        <p>주문 옵션은 최대 6개까지 추가 가능합니다.</p>
                    </div>
                </div>
            </div>
            <div class="divided"></div>
            <div class="inner">
                <div class="flex items-center justify-end mb-2 option_list_btn">
                    <button onclick="sortOption();">옵션 순서 변경</button>
                </div>
                <div id="optsArea" class="option_item mb-2"></div>
                <button class="flex items-center justify-center gap-1 w-full h-11 text-white bg-stone-600 rounded" onClick="addOrderOption(_tmp+1);">
                    <svg class="w-5 h-5 stroke-stone-400"><use xlink:href="/img/m/icon-defs.svg#plus_white"></use></svg>
                    주문 옵션 추가
                </button>
            </div>

                <input type="hidden" name="pay_notice" id="pay_notice"></textarea>
                <input type="hidden" name="delivery_notice" id="delivery_notice"></textarea>
                <input type="hidden" name="return_notice" id="return_notice"></textarea>
                <input type="hidden" id="order_title">
                <input type="hidden" name="order_content" id="order_content"></textarea>

            <input type="hidden" class="order-info01" value="2">
            <input type="hidden" class="order-info02" value="2">
            <input type="hidden" class="order-info03" value="2">
            <input type="hidden" class="order-info04" value="2">

            <div class="bot_btn">
                @if(Route::current()->getName() == 'product.create')
                    <button class="btn btn-primary-line w-1/4" onclick="goStep('step3', 'p')">이전</button>
                    <button class="btn btn-primary-line w-1/4" id="previewBtn" onclick="preview();">미리보기</button>
                    <button class="btn btn-primary-line w-1/4" onclick="saveProduct(1);">임시등록</button>
                    <button class="btn btn-primary w-1/4" onclick="saveProduct(0);">등록신청</button>
                @elseif(Route::current()->getName() == 'product.modify')
                    <button class="btn btn-primary-line w-1/4" onclick="goStep('step3', 'p')">이전</button>
                    <button class="btn btn-primary-line w-1/4" id="previewBtn" onclick="preview();">미리보기</button>
                    <button class="btn btn-primary w-1/4" style="margin-left:90px;" id="modifyBtn" onclick="saveProduct(2)" data-idx={{$productIdx}}>수정완료</button>
                @endif 
            </div>
        </div>
    </div>



    {{-- ############# 모달 모음 시작 --}}
    @include('m.product.product-reg-modal')
    @include('m.product.modal-ai-generator')
    {{-- ############# 모달 모음 끝 --}}

</div>






<link href="/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/froala_editor.pkgd.min.js"></script>
<script type="text/javascript">
const productIdx = "{{ $productIdx }}";
var storedFiles = [];
var stored100Files = [];
var stored400Files = [];
var stored600Files = [];
var stored1000Files = [];
var storedAiFiles = [];
var subCategoryIdx = null;
var storedAiSourceFiles = []; 
var deleteImage = [];
var proc = false;
var authList = ['KS 인증', 'ISO 인증', 'KC 인증', '친환경 인증', '외코텍스(OEKO-TEX) 인증', '독일 LGA 인증', 'GOTS(오가닉) 인증', '라돈테스트 인증', '전자파 인증', '전기용품안전 인증'];
var oIdx = 0;
var _tmp = 0;

var currentAiFile = null;
var targetAiBtn = null;
var targetImgPreviewId = "";
var targetHiddenInputId = "";
var originalFilesBackup = {};
var userAiCount = {{ Auth::user()->ai_count ?? 0 }}; // 초기값 설정
var tempAiFilesToDelete = [];

var aiGeneratedStore = {};
var selectedAiGeneratedUrl = null;
var selectedAiGeneratedStyleKey = null;

function getAiStyleKey($btn) {
    if ($btn.data('action') === 'remove_bg') {
        return 'remove_bg';
    }

    return $btn.data('style') || '';
}

function renderAiGeneratedShelf($styleBtn) {
    var styleKey = getAiStyleKey($styleBtn);
    var bucket = aiGeneratedStore[styleKey] || [];
    var $shelf = $('#ai_generated_shelf');
    var $list = $('#ai_generated_shelf_list');

    $list.empty();
    $('#ai_generated_shelf_count').text(bucket.length + '/3');

    if (bucket.length === 0) {
        $shelf.addClass('hidden');
        return;
    }

    bucket.forEach(function(item, index) {
        var isActive = selectedAiGeneratedUrl === item.url;

        var $thumb = $('<button>', {
            type: 'button',
            class: 'ai-generated-thumb relative h-16 rounded-md overflow-hidden border bg-white shadow-sm transition-all ' + (isActive ? 'border-red-500 ring-2 ring-red-500' : 'border-stone-200'),
            'data-url': item.url,
            'data-style-key': styleKey
        });

        $('<img>', {
            src: item.url,
            alt: '생성 이미지 ' + (index + 1),
            class: 'w-full h-full object-cover'
        }).appendTo($thumb);

        $('<span>', {
            class: 'absolute left-1 top-1 rounded bg-black/60 px-1.5 py-0.5 text-[10px] font-bold text-white',
            text: index + 1
        }).appendTo($thumb);

        $list.append($thumb);
    });

    $shelf.removeClass('hidden');
}

function storeAiGeneratedImage($styleBtn, imageUrl) {
    var styleKey = getAiStyleKey($styleBtn);

    if (!styleKey || !imageUrl) {
        return;
    }

    var bucket = aiGeneratedStore[styleKey] || [];

    bucket = bucket.filter(function(item) {
        return item.url !== imageUrl;
    });

    bucket.unshift({
        url: imageUrl,
        createdAt: Date.now()
    });

    aiGeneratedStore[styleKey] = bucket.slice(0, 3);

    selectedAiGeneratedUrl = imageUrl;
    selectedAiGeneratedStyleKey = styleKey;

    $styleBtn.attr('data-generated-url', imageUrl);
    renderAiGeneratedShelf($styleBtn);
}


function updateAiCountUI(count) {
    if (count !== undefined && count !== null) {
        userAiCount = count; // 전역 변수 동기화
        $('#ai_remain_count_display')
            .text('남은 횟수: ' + count + '회 남았습니다. 매일 자정 초기화됩니다.')
            .removeClass('hidden');
    }
}

function openAiModal(btnElement, fileName, previewId, hiddenInputId) {
    targetAiBtn = btnElement; // 클릭된 버튼 엘리먼트 저장
    targetImgPreviewId = previewId || "#rep_img_preview";
    targetHiddenInputId = hiddenInputId || "#rep_img_path";
    
    console.log("선택된 파일명:", fileName);

    // AI 전송용 파일을 우선 사용하고, 기존 AI 적용 이미지 등 예외 상황에서는 등록용 파일로 보완합니다.
    var selectedFile = storedAiSourceFiles.find(function(f) {
        return f && f.name === fileName;
    });

    if (!selectedFile) {
        alert("AI 처리용 원본 이미지가 아직 준비 중입니다. 잠시 후 다시 시도해주세요.");
        return;
    }

    if (!selectedFile) {
        alert("이미지 파일을 찾을 수 없습니다. 다시 시도해주세요.");
        return;
    }
    
    // 현재 작업할 파일을 전역 변수에 저장
    currentAiFile = selectedFile;

    // AI 남은 횟수 조회
    $.ajax({
        url: "{{ route('product.ai.get_remain_count') }}",
        type: 'GET',
        success: function(res) {
            if (res.success) {
                $('#ai_remain_count_display').text('남은 횟수: ' + res.remain_count + '회 남았습니다. 매일 자정 초기화됩니다.').removeClass('hidden');
            } else {
                $('#ai_remain_count_display').addClass('hidden');
            }
        },
        error: function() {
            console.log('남은 횟수를 불러오는 데 실패했습니다.');
        }
    });

    // FileReader로 이미지 URL 읽어서 모달에 표시
    /*var reader = new FileReader();
    reader.onload = function(e) {
        $('#ai_modal_preview_image').attr('src', e.target.result).attr('data-base-src', e.target.result).removeClass('hidden'); 
        $('#ai_modal_thumbnail').attr('src', e.target.result);
        $('#ai_modal_placeholder_text').addClass('hidden');
        $('#ai_modal_result_image').addClass('hidden'); // 결과 이미지는 초기화

        $('.btn-style-select').removeClass('border-red-500 text-red-500 bg-red-500/5 ring-1 ring-red-500');
        $('#ai_input_prompt').val('');

        $('.generated-badge').remove(); 
        $('.btn-style-select').removeAttr('data-generated-url');
    }
    reader.readAsDataURL(selectedFile);*/

    var validImageSrc = $(targetImgPreviewId).attr('data-original-src') || $(targetImgPreviewId).attr('src');

    $('#ai_original_image_section').removeClass('hidden');
    $('#ai_preview_image_section').addClass('hidden');

    // 가져온 정상 데이터를 모달창에 꽂아줍니다.
    $('#ai_modal_preview_image').attr('src', validImageSrc).attr('data-base-src', validImageSrc).removeClass('hidden'); 
    $('#ai_style_preview_badge').addClass('hidden');
    $('#ai_modal_thumbnail').attr('src', validImageSrc);
    $('#ai_modal_placeholder_text').addClass('hidden');
    $('#ai_modal_result_image').addClass('hidden');

    $('.btn-style-select').removeClass('border-red-500 text-red-500 bg-red-500/5 ring-1 ring-red-500');
    $('#ai_input_prompt').val('');
    $('.generated-badge').remove(); 
    $('.btn-style-select').removeAttr('data-generated-url');
    $('#btn_remove_bg').removeAttr('data-generated-url').find('.generated-badge').remove();

    aiGeneratedStore = {};
    selectedAiGeneratedUrl = null;
    selectedAiGeneratedStyleKey = null;
    $('#ai_generated_shelf').addClass('hidden');
    $('#ai_generated_shelf_list').empty();
    $('#ai_generated_shelf_count').text('0/3');
    
    modalOpen('#ai_image_generator_modal');
}

// 2. [기능 독립] 배경 제거 버튼 클릭 이벤트
// $(document).on('click', '#btn_remove_bg', function(e) {
//     e.preventDefault();
//     if (userAiCount <= 0) {
//             alert("오늘 사용 가능한 AI 생성 횟수를 모두 소진하셨습니다.\n매일 자정에 횟수가 초기화됩니다.");
//             return false; // 여기서 함수 종료
//         }
//     if (!currentAiFile) return alert('작업할 이미지가 없습니다.');

//     var $btn = $(this);
//     var originalHtml = $btn.html();

//     $('#ai_full_loading_overlay h4').text('AI 배경 제거 중...');
//     $('#ai_full_loading_overlay p').text('배경을 깔끔하게 지우고 있습니다.');
//     $('#ai_full_loading_overlay').removeClass('hidden');

//     $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> 작업중...');

//     var fileToSend = currentAiFile; // 기본적으로는 기존 파일 사용

//     var formData = new FormData();
//     formData.append('image', fileToSend); // 깡통 파일 대신 정상 파일 전송

//     $.ajax({
//         url: "{{ route('product.ai.remove_bg') }}",
//         type: 'POST',
//         global: false,
//         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
//         data: formData,
//         contentType: false, processData: false,
//         beforeSend: function() {
//             $('#loadingContainer').hide(); 
//             $('#loadingContainer').css('display', 'none'); 
//         },
//         success: function(res) {
//             if (res.success) {
//                 $('#ai_modal_preview_image').attr('src', res.data.removebg_url);

//                 var $removeBgBtn = $('#btn_remove_bg');
//                 $removeBgBtn.attr('data-generated-url', res.data.removebg_url);

//                 if ($removeBgBtn.find('.generated-badge').length === 0) {
//                     $removeBgBtn.append(
//                         '<div class="generated-badge absolute top-1 right-1 bg-stone-800 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-md z-30 shadow-md">생성 완료</div>'
//                     );
//                 }

//                 $('#btn_ai_confirm_m').prop('disabled', false);
//                 updateAiCountUI(res.remain_count);
//                 modalOpen('#ai-generate-success-modal');
//             }
//         },
//         error: function(xhr) { console.error(xhr); alert('서버 통신 오류'); },
//         complete: function() { $('#ai_full_loading_overlay').addClass('hidden'); $btn.prop('disabled', false).html(originalHtml); }
//     });
// });

$(document).on('click', '.btn-style-select', function(e) {
    e.preventDefault();


    $('.btn-style-select').removeClass('border-red-500 text-red-500 bg-red-500/5 ring-1 ring-red-500');
    $(this).addClass('border-red-500 text-red-500 bg-red-500/5 ring-1 ring-red-500');

    var action = $(this).data('action') || 'generate_bg';
    var prompt = $(this).data('prompt') || '';
    var $previewImg = $('#ai_modal_preview_image');

    $('#ai_input_prompt').val(prompt);

    var styleKey = getAiStyleKey($(this));
    var bucket = aiGeneratedStore[styleKey] || [];

    renderAiGeneratedShelf($(this));

    if (bucket.length > 0) {
        selectedAiGeneratedUrl = bucket[0].url;
        selectedAiGeneratedStyleKey = styleKey;

        $('#ai_preview_image_section').removeClass('hidden');

        $previewImg.attr('src', selectedAiGeneratedUrl).css('object-fit', 'contain');
        $(this).attr('data-generated-url', selectedAiGeneratedUrl);

        $('#ai_style_preview_badge').addClass('hidden');
        $('#btn_ai_confirm_m').prop('disabled', false);
        return;
    }

    selectedAiGeneratedUrl = null;
    selectedAiGeneratedStyleKey = null;
    $(this).removeAttr('data-generated-url');

    $('#ai_preview_image_section').addClass('hidden');

    if (action === 'remove_bg') {
        var baseSrc = $previewImg.attr('data-base-src') || $('#ai_modal_thumbnail').attr('src');
        $previewImg.attr('src', baseSrc).css('object-fit', 'contain');
        $('#ai_style_preview_badge').addClass('hidden');
        return;
    }

    $('#ai_style_preview_badge').addClass('hidden');
});

$(document).on('click', '#btn_ai_generate', async function(e) {
    e.preventDefault();

    if (userAiCount <= 0) {
        alert("오늘 사용 가능한 AI 생성 횟수를 모두 소진하셨습니다.\n매일 자정에 횟수가 초기화됩니다.");
        return false;
    }

    if (!currentAiFile) return alert('이미지를 찾을 수 없습니다.');

    var $activeStyleBtn = $('.btn-style-select.border-red-500');

    if ($activeStyleBtn.length === 0) {
        return alert('먼저 원하는 스타일 버튼을 선택해주세요.');
    }

    var action = $activeStyleBtn.data('action') || 'generate_bg';

    if (action === 'remove_bg') {
        requestRemoveBgOnly($(this), $activeStyleBtn);
        return;
    }

    var prompt = $('#ai_input_prompt').val();
    if (!prompt) return alert('먼저 원하는 스타일 버튼을 선택해주세요.');

    var $btn = $(this);
    var originalText = $btn.html();
    
    $('.btn-style-select, #btn_remove_bg').prop('disabled', true); 
    
    $('#ai_full_loading_overlay h4').text('1단계: 배경 제거 중...');
    $('#ai_full_loading_overlay p').text('이미지 생성을 위해 배경을 지우고 있습니다.');
    $('#ai_full_loading_overlay').removeClass('hidden');



    var formData = new FormData();
    formData.append('image', currentAiFile, currentAiFile.name || 'ai_source_image.jpg');
    formData.append('normalize_for_ai', '1'); // 모바일만 서버 정사각형 보정
    $.ajax({
        url: "{{ route('product.ai.remove_bg') }}",
        type: 'POST',
        global: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: formData,
        contentType: false, processData: false,
        beforeSend: function() {
            $('#loadingContainer').hide(); 
            $('#loadingContainer').css('display', 'none'); 
        },
        success: function(res1) {
            if (res1.success) {
                if (res1.remain_count !== undefined) {
                        userAiCount = res1.remain_count;
                    }
                var tempPath = res1.data.temp_path;

                if (tempPath) {
                    tempAiFilesToDelete.push(tempPath);
                }


                $('#ai_style_preview_badge').addClass('hidden');

                $('#ai_full_loading_overlay h4').text('2단계: AI 이미지 생성 중...');
                $('#ai_full_loading_overlay p').text('선택한 스타일로 공간을 꾸미고 있습니다. (약 10~20초)');
                $btn.html('<span class="spinner-border spinner-border-sm"></span> 이미지 생성 중...');
                
                requestGenerateBg(tempPath, prompt, $btn, originalText, $activeStyleBtn);
            } else {
                alert('배경 제거 실패: ' + res1.message);
                resetButtons($btn, originalText);
            }
        },
        error: function(xhr) {
            console.error(xhr);
            alert('배경 제거 중 오류가 발생했습니다.');
            resetButtons($btn, originalText);
        }
    });
});

// 배경 합성 함수
function requestGenerateBg(tempPath, prompt, $btn, originalText, $activeStyleBtn) {
    $('#ai_full_loading_overlay').removeClass('hidden');

    $.ajax({
        url: "{{ route('product.ai.generate_bg') }}",
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { temp_path: tempPath, prompt: prompt },
        dataType: 'json',
        success: function(res2) {
            if (res2.success) {
                $('#ai_preview_image_section').removeClass('hidden');
                $('#ai_modal_preview_image')
                    .attr('src', res2.data.final_url)
                    .css('object-fit', 'contain');

                $('#ai_style_preview_badge').addClass('hidden');
                updateAiCountUI(res2.remain_count);

                if (res2.data.final_path) {
                    tempAiFilesToDelete.push(res2.data.final_path);
                }

                if ($activeStyleBtn && $activeStyleBtn.length > 0) {
                    storeAiGeneratedImage($activeStyleBtn, res2.data.final_url);
                    if ($activeStyleBtn.find('.generated-badge').length === 0) {
                        var badgeHtml = '<div class="generated-badge absolute top-1 right-1 bg-stone-800 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-md z-30 shadow-md">✨ 생성 완료</div>';
                        $activeStyleBtn.append(badgeHtml);
                    }
                }

                $('#btn_ai_confirm_m').prop('disabled', false);
                modalOpen('#ai-generate-success-modal');
            } else {
                alert('이미지 생성 실패: ' + res2.message);
            }
        },
        error: function(xhr) {
            console.error(xhr);
            var msg = '이미지 생성 중 오류가 발생했습니다.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                msg += "\n[상세 내용]: " + xhr.responseJSON.message;
            } else if (xhr.responseText) {
                msg += "\n[상세 내용]: " + xhr.responseText.substring(0, 100) + "..."; 
            }
            alert(msg);
            resetButtons($btn, originalText);
        },
        complete: function() {
            $('#ai_full_loading_overlay').addClass('hidden');
            resetButtons($btn, originalText);
        }
    });
}

$(document).on('click', '.ai-generated-thumb', function(e) {
    e.preventDefault();

    selectedAiGeneratedUrl = $(this).attr('data-url');
    selectedAiGeneratedStyleKey = $(this).attr('data-style-key');

    $('#ai_preview_image_section').removeClass('hidden');

    $('#ai_modal_preview_image')
        .attr('src', selectedAiGeneratedUrl)
        .css('object-fit', 'contain');

    $('#ai_style_preview_badge').addClass('hidden');

    $('.ai-generated-thumb')
        .removeClass('border-red-500 ring-2 ring-red-500')
        .addClass('border-stone-200');

    $(this)
        .removeClass('border-stone-200')
        .addClass('border-red-500 ring-2 ring-red-500');

    $('.btn-style-select.border-red-500').attr('data-generated-url', selectedAiGeneratedUrl);
    $('#btn_ai_confirm_m').prop('disabled', false);
});

// 버튼 상태 초기화
function resetButtons($btn, originalText) {
    $('.btn-style-select, #btn_remove_bg').prop('disabled', false);
    $btn.prop('disabled', false).html(originalText);
}

function requestRemoveBgOnly($btn, $activeStyleBtn) {
    if (userAiCount <= 0) {
        alert("오늘 사용 가능한 AI 생성 횟수를 모두 소진하셨습니다.\n매일 자정에 횟수가 초기화됩니다.");
        return false;
    }

    if (!currentAiFile) {
        alert('작업할 이미지가 없습니다.');
        return false;
    }

    var originalText = $btn.html();

    $('#ai_full_loading_overlay h4').text('AI 배경 제거 중...');
    $('#ai_full_loading_overlay p').text('배경을 깔끔하게 지우고 있습니다.');
    $('#ai_full_loading_overlay').removeClass('hidden');

    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> 배경 제거 중...');
    $('.btn-style-select, #btn_remove_bg').prop('disabled', true);

    var formData = new FormData();
    formData.append('image', currentAiFile, currentAiFile.name || 'ai_source_image.jpg');
    formData.append('normalize_for_ai', '1'); // 모바일만 서버 정사각형 보정

    $.ajax({
        url: "{{ route('product.ai.remove_bg') }}",
        type: 'POST',
        global: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function() {
            $('#loadingContainer').hide();
            $('#loadingContainer').css('display', 'none');
        },
        success: function(res) {
            if (res.success) {
                $('#ai_preview_image_section').removeClass('hidden');
                $('#ai_modal_preview_image').attr('src', res.data.removebg_url).css('object-fit', 'contain');
                $('#ai_style_preview_badge').addClass('hidden');

                storeAiGeneratedImage($activeStyleBtn, res.data.removebg_url);

                if ($activeStyleBtn.find('.generated-badge').length === 0) {
                    $activeStyleBtn.append(
                        '<div class="generated-badge absolute top-1 right-1 bg-stone-800 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-md z-30 shadow-md">생성 완료</div>'
                    );
                }

                $('#btn_ai_confirm_m').prop('disabled', false);
                updateAiCountUI(res.remain_count);
                modalOpen('#ai-generate-success-modal');
            } else {
                alert('실패: ' + (res.message || '배경 제거에 실패했습니다.'));
            }
        },
        error: function(xhr) {
            console.error(xhr);
            alert('서버 통신 오류');
        },
        complete: function() {
            $('#ai_full_loading_overlay').addClass('hidden');
            resetButtons($btn, originalText);
        }
    });
}

$(document).on('click', '#btn_ai_confirm_m', function() {

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
    var $wrapper = $(targetAiBtn).closest('.product-img__add');
    var originalIdx = $wrapper.attr('data-idx');

    if (originalIdx) {
        $wrapper.attr('data-backup-idx', originalIdx);
        $wrapper.removeAttr('data-idx');
        $wrapper.removeData('idx'); 
        
        if (!deleteImage.includes(originalIdx)) {
            deleteImage.push(originalIdx);
        }
    }

    if(targetAiBtn && $('#ai_modal_preview_image').attr('src') !== "") {
        // 모바일 UI 클래스 대응 (text-xs, h-[32px] 유지)
        $(targetAiBtn)
            .removeClass('border-primary text-primary bg-white')
            .addClass('border-stone-500 text-stone-600 bg-stone-100')
            .html('<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 12"/><path d="M3 3v9h9"/></svg> 원본 복구')
            .attr('onclick', 'restoreOriginal(this, "' + targetImgPreviewId + '", "' + targetHiddenInputId + '", "' + currentAiFile.name + '")');
    }
});

    var restoreParams = {};

    function removeFileByName(arr, fileName) {
        for (var i = arr.length - 1; i >= 0; i--) {
            if (arr[i] && arr[i].name === fileName) {
                arr.splice(i, 1);
            }
        }
    }

    function restoreFileToArray(arr, originalFile, aiFileName) {
        if (!originalFile) return;

        var aiIdx = arr.findIndex(function(f) {
            return f && f.name === aiFileName;
        });

        if (aiIdx !== -1) {
            arr[aiIdx] = originalFile;
            return;
        }

        var originalIdx = arr.findIndex(function(f) {
            return f && f.name === originalFile.name;
        });

        if (originalIdx !== -1) {
            arr[originalIdx] = originalFile;
            return;
        }

        arr.push(originalFile);
    }

    // 2. 기존 restoreOriginal 함수 수정 (파라미터 저장 후 모달만 띄우기)
    function restoreOriginal(btn, previewId, hiddenInputId, fileName) {
        // 실제 복구 로직을 실행하기 위해 파라미터들을 임시 저장
        restoreParams = {
            btn: btn,
            previewId: previewId,
            hiddenInputId: hiddenInputId,
            fileName: fileName
        };

        // 커스텀 모달 열기
        modalOpen('#ai-restoration');
    }

    $(document).on('click', '#confirm-restoration', function() {
    // 임시 저장해둔 파라미터 꺼내기
        var btn = restoreParams.btn;
        var previewId = restoreParams.previewId;
        var hiddenInputId = restoreParams.hiddenInputId;
        var fileName = restoreParams.fileName;

        // 모달창 닫기
        modalClose('#ai-restoration');

        // --- 여기서부터 기존의 복구 로직 실행 ---
        var $img = $(previewId);
        var originSrc = $img.attr('data-original-src'); 

        if (originSrc) {
            $img.attr('src', originSrc);
        }
        
        var $wrapper = $(btn).closest('.product-img__add');
        var backupIdx = $wrapper.attr('data-backup-idx');

        if (backupIdx) {
            $wrapper.attr('data-idx', backupIdx);
            $wrapper.data('idx', backupIdx);
            $wrapper.removeAttr('data-backup-idx');
            
            deleteImage = deleteImage.filter(function(item) {
                return item != backupIdx;
            });
        }

        $wrapper.attr('file', fileName);

        var originalData = originalFilesBackup[fileName];

        if (originalData) {
            var aiFileName = "ai_" + fileName;

            restoreFileToArray(storedFiles, originalData.main, aiFileName);
            restoreFileToArray(stored100Files, originalData.f100, aiFileName);
            restoreFileToArray(stored400Files, originalData.f400, aiFileName);
            restoreFileToArray(stored600Files, originalData.f600, aiFileName);
            restoreFileToArray(stored1000Files, originalData.f1000, aiFileName);

            removeFileByName(storedAiFiles, aiFileName);
        }

        // AI 결과값 hidden input 초기화
        $(hiddenInputId).val('');

        // ★ 모바일 UI 클래스 대응 (PC버전과 클래스가 다르므로 주의)
        $(btn)
            .removeClass('border-stone-500 text-stone-600 bg-stone-100')
            .addClass('border-primary text-primary bg-white')
            .html('<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7"/><line x1="16" x2="22" y1="5" y2="5"/><line x1="19" x2="19" y1="2" y2="8"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg> AI 배경생성')
            .attr('onclick', 'openAiModal(this, "' + fileName + '", "' + previewId + '", "' + hiddenInputId + '")');
    });

    // 결제방식
    const paymentShow = (item)=>{
        $(`.${item}`).removeClass('hidden')
    }

    const paymentHide  = (item)=>{
        $(`.${item}`).addClass('hidden')
    }

function base64ToFile(dataurl, filename) {
    var arr = dataurl.split(','),
        mime = arr[0].match(/:(.*?);/)[1],
        bstr = atob(arr[1]), 
        n = bstr.length, 
        u8arr = new Uint8Array(n);
        
    while(n--) {
        u8arr[n] = bstr.charCodeAt(n);
    }
    
    return new File([u8arr], filename, {type: mime});
}

function getThumbFile(_IMG, maxWidth, width, height){
    var canvas = document.createElement("canvas");
    if(width < maxWidth) {
//        return _IMG;
    }
    canvas.width = maxWidth; // (maxWidth);
    canvas.height = maxWidth; // ((maxWidth / (width*1.0))*height);

    const baseWidth = canvas.width;

    const cropInfo = {
        isFit: Math.floor(_IMG.width) == Math.floor(_IMG.height),
        isLowerWidth: _IMG.width < _IMG.height,
        cropPosition: {
            x: 0, y: 0
        }
    };
    console.log(cropInfo)

    if(cropInfo.isFit) {
        canvas.getContext("2d").drawImage(_IMG, 0, 0, baseWidth, baseWidth);
    } else {
        cropInfo.wrate = baseWidth / _IMG.width;
        cropInfo.hrate = baseWidth / _IMG.height;
        cropInfo.cropPosition.x = cropInfo.isLowerWidth ? 0 : Math.floor((_IMG.width * cropInfo.wrate) - (_IMG.height * cropInfo.hrate)) * -1 / 2;
        cropInfo.cropPosition.y = cropInfo.isLowerWidth ? Math.floor((_IMG.height * cropInfo.hrate) - (_IMG.width * cropInfo.wrate)) * -1 / 2 : 0;

        canvas.getContext("2d").drawImage(_IMG, 0, 0, (cropInfo.isLowerWidth ? _IMG.width : _IMG.height), cropInfo.isLowerWidth ? _IMG.width : _IMG.height, cropInfo.cropPosition.x, cropInfo.cropPosition.y, baseWidth, baseWidth);

        cropInfo.rate = cropInfo.isLowerWidth ? cropInfo.hrate : cropInfo.wrate;
        canvas.getContext("2d").scale(cropInfo.rate, cropInfo.rate);
    }

    var dataURL = canvas.toDataURL("image/webp");
    var byteString = atob(dataURL.split(',')[1]);
    var mimeString = dataURL.split(',')[0].split(':')[1].split(';')[0];
    var ab = new ArrayBuffer(byteString.length);
    var ia = new Uint8Array(ab);
    for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
    }
    var tmpThumbFile = new Blob([ab], {type: mimeString});

    return tmpThumbFile;
}

function getThumbFileAi(_IMG, maxWidth, width, height) {
    var scanCanvas = document.createElement("canvas");
    var scanCtx = scanCanvas.getContext("2d");

    scanCanvas.width = width;
    scanCanvas.height = height;
    scanCtx.drawImage(_IMG, 0, 0, width, height);

    var imageData = scanCtx.getImageData(0, 0, width, height);
    var data = imageData.data;

    function getPixel(x, y) {
        var i = (y * width + x) * 4;
        return [data[i], data[i + 1], data[i + 2]];
    }

    function colorDistance(a, b) {
        return Math.abs(a[0] - b[0]) + Math.abs(a[1] - b[1]) + Math.abs(a[2] - b[2]);
    }

    function isSolidRow(y) {
        var sample = getPixel(Math.floor(width / 2), y);
        var similarCount = 0;

        for (var x = 0; x < width; x += 4) {
            var p = getPixel(x, y);
            if (colorDistance(sample, p) < 35) {
                similarCount++;
            }
        }

        return similarCount / Math.ceil(width / 4) > 0.96;
    }

    var cropTop = 0;
    var cropBottom = height - 1;

    while (cropTop < height && isSolidRow(cropTop)) {
        cropTop++;
    }

    while (cropBottom > cropTop && isSolidRow(cropBottom)) {
        cropBottom--;
    }

    var cropLeft = 0;
    var cropW = width;
    var cropH = cropBottom - cropTop + 1;

    if (cropH < height * 0.5) {
        cropTop = 0;
        cropH = height;
    }

    var canvas = document.createElement("canvas");
    var ctx = canvas.getContext("2d");

    canvas.width = maxWidth;
    canvas.height = maxWidth;

    ctx.clearRect(0, 0, maxWidth, maxWidth);

    var scale = Math.min(maxWidth / cropW, maxWidth / cropH);
    var targetW = Math.round(cropW * scale);
    var targetH = Math.round(cropH * scale);
    var targetX = Math.round((maxWidth - targetW) / 2);
    var targetY = Math.round((maxWidth - targetH) / 2);

    ctx.drawImage(
        _IMG,
        cropLeft,
        cropTop,
        cropW,
        cropH,
        targetX,
        targetY,
        targetW,
        targetH
    );

    var dataURL = canvas.toDataURL("image/png");
    var byteString = atob(dataURL.split(',')[1]);
    var mimeString = dataURL.split(',')[0].split(':')[1].split(';')[0];
    var ab = new ArrayBuffer(byteString.length);
    var ia = new Uint8Array(ab);

    for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
    }

    return new Blob([ab], { type: mimeString });
}

$(document).on('change', '#form-list02', function() {
    var files = this.files;
    var i = 0;

    for (i = 0; i < files.length; i++) {
        var readImg = new FileReader();
        var file = files[i];

        if (file.type.match('image.*')){
            readImg.onload = (function(file) {
                return function(e) {
                    let imgCnt = $('.product-img__add').length + 1;

                    if (imgCnt == 9) {
                        alert('파일은 8개 까지 등록 가능합니다.');
                        return;
                    }

                    removeFileByName(storedAiSourceFiles, file.name);
                    storedAiSourceFiles.push(file);

                    var image = new Image;
                    image.onload = function() {
                        var resizedFile = getThumbFile(image, 500, this.width, this.height);
                        resizedFile.name = file.name;
                        storedFiles.push(resizedFile);

                        var aiResizedFile = getThumbFileAi(image, 1000, this.width, this.height);
                        aiResizedFile.name = file.name;
                        storedAiFiles.push(aiResizedFile);
                    };
                    image.src = e.target.result;

                    var image100 = new Image;
                    image100.width = 100;
                    image100.height = 100;
                    image100.onload = function() {
                        const i100 = getThumbFile(image100, 100, this.width, this.height);
                        i100.name = file.name;
                        stored100Files.push(i100);
                    };
                    image100.src = e.target.result;

                    var image400 = new Image;
                    image400.width = 400;
                    image400.height = 400;
                    image400.onload = function() {
                        const i400 = getThumbFile(image400, 400, this.width, this.height);
                        i400.name = file.name;
                        stored400Files.push(i400);
                    };
                    image400.src = e.target.result;

                    var image600 = new Image;
                    //image600.width = 600;
                    //image600.height = 600;
                    image600.onload = function() {
                        const i600 = getThumbFile(image600, 600, this.width, this.height);
                        i600.name = file.name;
                        stored600Files.push(i600);
                    };
                    image600.src = e.target.result;

                    var image1000 = new Image;
                    image1000.width = 1000;
                    image1000.height = 1000;
                    image1000.onload = function() {
                        const i1000 = getThumbFile(image1000, 1000, this.width, this.height);
                        i1000.name = file.name;
                        stored1000Files.push(i1000);
                    };
                    image1000.src = e.target.result;

                    // [추가] 고유 ID 생성 (이미지 태그와 히든값을 매칭하기 위함)
                    var uniqueId = 'prv_' + new Date().getTime() + '_' + Math.floor(Math.random() * 1000);
                    var uniqueHiddenId = 'path_' + new Date().getTime() + '_' + Math.floor(Math.random() * 1000);

                   
                    $('.desc__product-img-wrap').append(
                        '<div class="w-[150px] h-auto pb-3 rounded-md relative flex flex-col items-center justify-start product-img__add" file="' + file.name + '">' +
                        '   <div class="relative w-[150px] h-[150px] bg-slate-400 rounded-md">' +
                        '       <img id="' + uniqueId + '" class="w-full h-full object-cover rounded-md" src="' + e.target.result + '" data-original-src="' + e.target.result + '" alt="상품이미지">' +
                        '       <div class="absolute top-2.5 right-2.5">' +
                        '           <button class="ico__delete--circle !w-[28px] !h-[28px] bg-stone-600/50 !rounded-full">' +
                        '               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-white mx-auto w-4 h-4"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>' +
                        '           </button>' +
                        '       </div>' +
                        '   </div>' +
                        '   <button type="button" class="mt-2 w-full h-[32px] flex items-center justify-center gap-1 border border-primary text-primary text-xs rounded bg-white" ' +
                        '           onclick="openAiModal(this, \'' + file.name + '\', \'#' + uniqueId + '\', \'#' + uniqueHiddenId + '\')">' +
                        '       AI 배경생성' +
                        '   </button>' +
                        '   <input type="hidden" id="' + uniqueHiddenId + '" name="ai_generated_paths[' + file.name + ']">' +
                        '</div>'
                    );

                    // 첫번째 이미지를 대표이미지로 표시
                    if (imgCnt == 1) {
                        $('.product-img__add').append(
                            '<div class="absolute top-2.5 left-2.5">' +
                            '   <p class="py-1 px-2 bg-stone-600/50 text-white text-center rounded-full text-sm">대표이미지</p>' +
                            '</div>'
                        );
                    }

                    if (imgCnt == 8) {
                        $('.desc__product-img-wrap > div').first().hide();
                    }
                };
            })(file);
            readImg.readAsDataURL(file);

        } else {
//            alert('the file '+ file.name + ' is not an image<br/>');
            alert('이미지가 아닙니다. 파일형식을 확인해주세요.');
        }

        if(files.length === (i+1)){
            setTimeout(function(){
                img_add_order();
            }, 1000);
        }
    }
    $(this).val('');
})
.on('click','.ico__delete--circle',function(e){
    e.preventDefault();

    var $wrapper = $(this).closest('.product-img__add');
    var fileName = $wrapper.attr('file'); 

    // 기존 서버 이미지 삭제 처리용
    var originalIdx = $wrapper.attr('data-idx');
    if (originalIdx && originalIdx !== "undefined") {
        if (!deleteImage.includes(originalIdx)) {
            deleteImage.push(originalIdx);
        }
    }
    
    // 화면에서 요소 지우기
    $wrapper.remove();
    $(this).parent().parent().remove('');

    var idxMain = storedFiles.findIndex(function(f) { return f && f.name === fileName;});
    if (idxMain > -1) storedFiles.splice(idxMain, 1);

    var idx100 = stored100Files.findIndex(function(f) { return f && f.name === fileName; });
    if (idx100 > -1) stored100Files.splice(idx100, 1);

    var idx400 = stored400Files.findIndex(function(f) { return f && f.name === fileName; });
    if (idx400 > -1) stored400Files.splice(idx400, 1);

    var idx600 = stored600Files.findIndex(function(f) { return f && f.name === fileName; });
    if (idx600 > -1) stored600Files.splice(idx600, 1);

    var idx1000 = stored1000Files.findIndex(function(f) {return f && f.name === fileName; });
    if (idx1000 > -1) stored1000Files.splice(idx1000, 1);

    var originalAiFileName = fileName.indexOf('ai_') === 0 ? fileName.substring(3) : fileName;
    var appliedAiFileName = fileName.indexOf('ai_') === 0 ? fileName : "ai_" + fileName;
    var idxAi = storedAiFiles.findIndex(function(f) {
        return f && (f.name === originalAiFileName || f.name === appliedAiFileName);
    });
    if (idxAi > -1) storedAiFiles.splice(idxAi, 1);

    removeFileByName(storedAiSourceFiles, originalAiFileName);
    removeFileByName(storedAiSourceFiles, appliedAiFileName);
    removeFileByName(storedAiSourceFiles, fileName);


    img_reload_order();

    if ($('.product-img__add').length < 8) {
        $('li .product-img__gallery').show();
    }
})

//### 
function img_reload_order() {
    $('.desc__product-img-wrap').find('.add__badge').remove();
    $('li .product-img__add').first().children('.add__img-wrap').prepend('<p class="add__badge">대표이미지</p>');
}

//### 
function img_add_order() {
    $('.desc__product-img-wrap li').each(function(n) {
        $(this).attr('item', n);
    });
}

    // 버튼 온오프
    $(document).on('click', '.btn_select button', function(){
        $(this).addClass('active').siblings().removeClass('active')
        const selectCont = $(this).parent('.btn_select').next('.btn_select_cont')
        if(selectCont){
            let liN = $(this).index()
            selectCont.find('>div').eq(liN).addClass('active').siblings().removeClass('active')
        }
    })

    $('.guide_list a').click(function() {
        // 클릭된 항목의 data-target 값 가져오기
        var targetId = $(this).data('target');

        // 모든 가이드 내용 숨기기
        $('.guide_con').hide();

        // 해당하는 ID를 가진 가이드 내용만 보여주기
        $('#' + targetId).show();
    });

    // 라디오버튼
    // 라디오 버튼의 변경을 감지
    $('input[type="radio"][name="price_exposure3"]').change(function() {
        // 선택된 라디오 버튼이 '직접입력'에 해당하는지 확인
        var isDirectInputSelected = $('#price_exposure08').is(':checked');

        // '직접입력' 선택 시, 입력 필드 표시
        if(isDirectInputSelected) {
            $('.direct_input').show();
        } else {
            // 다른 라디오 버튼 선택 시, 입력 필드 숨김
            $('.direct_input').hide();
        }
    });

//### 카테고리 선택완료
function setCategory(){
    var _this = $('input:radio[name=prod_category]:checked');
    var _idx  = _this.val();
    var _p_idx= _this.data('p_idx');

    // 카테고리 설정
    if( typeof _idx != 'undefined' && _idx != '' ) {
        var _text = _this.closest('ul').prev('button').find('span').text();
        var _sub = $("label[for='" + _this.attr('id') + "'").text();

        $('#categoryIdx').data('category_idx', _idx);
        $('#categoryIdx').text(_text + ' > ' + _sub);

        getProperty(null);
        $('.propertyList').show();
        $('.checkedProperties').html('');

        // $('#property').empty();
        // $('#property').append(infoText);
        // getProperty(null);
    }

    modalClose('#prod_category-modal');
}

//### 속성 가져오기2
function getSubProperty(parentIdx=null, title=null, ord=null) {
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url				: '/product/getCategoryProperty',
        data			: {
            'category_idx' : $('input:radio[name=prod_category]:checked').val(),
            'parent_idx' : parentIdx
        },
        type			: 'POST',
        dataType		: 'json',
        success		: function(result) {
            var _active = "";
            if( ord == 0 ) { _active = 'active'; } else { _active = ''; }
            var subHtmlText = '<div class="sub_property_area ' + _active + ' property_idx_' + parentIdx + '" data-title="' + title + '"><ul class="filter_list !mt-0 !mb-0">';
            result.forEach(function (e, idx) {
                subHtmlText += '<li>' +
                    '<input type="checkbox" class="check-form" id="property-check_' + e.idx + '" data-sub_property="' + e.idx + '" data-sub_name="' + e.property_name + '">' +
                    '<label for="property-check_' + e.idx + '">' + e.property_name + '</label>' +
                    '</li>';
            })
            subHtmlText += '</ul></div>';
            $('#prod_property-modal .prod_property_cont').append(subHtmlText);
        }
    });
}

//### 속성 가져오기1
function getProperty(parentIdx=null, title=null) {
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url				: '/product/getCategoryProperty',
        data			: {
            'category_idx' : $('input:radio[name=prod_category]:checked').val(),
            'parent_idx' : parentIdx
        },
        type			: 'POST',
        dataType		: 'json',
        success		: function(result) {
            var _active = "";
            var htmlText = '';
            $('#prod_property-modal .prod_property_cont').html('');
            result.forEach(function (e, idx) {
                if( idx == 0 ) { _active = 'active'; } else { _active = ''; }
                htmlText += '<li class="' + _active + '" data-property_idx=' + e.idx+ '><button>' + e.name + '</button></li>';
                getSubProperty(e.idx, e.name, idx);
            });
            $('#prod_property-modal .prod_property_tab').html(htmlText);
        }
    });
}

//### 상품등록 > 속성 모달
$(document).on('click', '#prod_property-modal .prod_property_tab li', function() {
    let liN = $(this).data('property_idx'); //')$(this).index();
    $(this).addClass('active').siblings().removeClass('active')
    $('.prod_property_cont > div.property_idx_'+liN).addClass('active').siblings().removeClass('active')
})

//### 속성 선택완료
$(document).on('click', '.confirm_prod_property', function() {
    if ($(this).has('.btn-primary')) {
        var htmlText = "";
        var tmpHtmlText = "";
        $('#prod_property-modal .sub_property_area').each(function(o){
            if ($('#prod_property-modal .sub_property_area:eq('+o+') .check-form:checked').length > 0){
                htmlText += '<div><div class="mt-5 font-medium">'+$(this).data('title')+'</div><div class="flex flex-wrap items-center gap-3 mt-2">';
                $('#prod_property-modal .sub_property_area:eq('+o+') .check-form:checked').map(function (n, i) {
                    htmlText += '<div class="flex items-center bg-stone-100 px-3 py-1 rounded-full gap-1" data-sub_idx="' + $(this).data('sub_property') + '">' +
                    '   <span class="text-stone-500 property_name">' + $(this).data('sub_name') + '</span>' +
                    '   <button class="ico_delete"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-stone-400"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg></button>' +
                    '</div>';
                })
                htmlText += '</div></div>';
            }
        });
        $('.checkedProperties').html(htmlText);
        modalClose('#prod_property-modal');
    }
})

//### 선택한 상품속성 값 삭제
$(document).on('click', '.ico_delete', function() {
    var this_sub_idx = $(this).parent().data('sub_idx');
    var this_property_length = $(this).parent().parent().children('div').length;
    if (this_property_length == 1){
        $(this).parent().parent().parent().remove();
    }else{
        $(this).parent().remove();
    }
    $('#prod_property-modal #property-check_'+this_sub_idx).attr('checked', false);
});

//### 상품속성 초기화 
function resetProperty(item){
    $(item).parent().siblings('.prod_property_cont').find('input').each(function(){
        $(this).prop("checked",false);
    });
}

//### 배송방법 추가
$('#prod_shipping-modal .btn-primary').on('click', function (e) {
    e.stopPropagation();
    var title = $('#prod_shipping-modal .dropdown_btn').text();
    if (title == '직접입력') {
        title = $('#prod_shipping-modal .shipping_write > input').val();
    }

    let htmlText = '' +
        '<div class="shipping_method px-4 py-2 mb-2 bg-stone-100 inline-flex items-center gap-1 text-sm rounded-full"><span class="add__name">' + title + ' ('+ $('#prod_shipping-modal .btn_select button.active').text() + ')</span>' +
        '   <button class="ico_delivery"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-stone-500"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button>' +
        '</div>';
    $('.shipping-wrap__add .shipping_method_list').append(htmlText);
    $('.shipping-wrap__add').removeClass('hidden');

    // 배송방법 추가 모달 초기화
    $('#prod_shipping-modal .dropdown.step1 p').text('가격 안내 문구 선택');
    $('#prod_shipping-modal .direct_input_2 > input').val('');
    $('#prod_shipping-modal .dropdown.step2 p').text('배송 가격을 선택해주세요');

    modalClose('#prod_shipping-modal');
})

//### 선택한 배송방법 값 삭제
$(document).on('click', '.ico_delivery', function() {
    $(this).parent().remove();
    if ($('.shipping_method').length < 1) {
        $('.shipping-wrap__add').addClass('hidden');
    }
});

//### 인증정보 체크박스 선택시 (마지막 기타인증 선택 관련)
$('#prod_certifi-modal [type="checkbox"]').on('change', function () {
    let isShow = $(this).is(':checked');
    if ($(this).parents().find('li').has(':last')) {
        if (!isShow) {
            $('#auth_info_text').val('');
        }
        $('#auth_info_text').css('display', isShow ? 'block' : 'none');
    }
    var cnt = 0;
    $('#prod_certifi-modal [type="checkbox"]').each(function (i, el) {
        if ($(el).is(':checked')) { cnt++; }
    });
})

//### 인증정보 선택완료
$('#prod_certifi-modal .btn-primary').click(function () {
    if ($('#prod_certifi-modal [type="checkbox"]:checked').length > 0 ) {
        let text = "";
        $('#prod_certifi-modal [type="checkbox"]:checked').each(function (i, el) {
            if ($(el).is('[data-auth="기타 인증"]')) {
                if ($('#auth_info_text').val() != '') {
                    text += $('#auth_info_text').val();
                } else {
                    $(el).prop('checked', false);
                }
            } else {
                text += $(el).parent().find('label').text();
            }
            text += ", "
        });
        $('.wrap__selected .mt-1').text(text.slice(0, -2));
        $('.wrap__selected').addClass('active');
        $('.wrap__selected').show();
    } else {
        $('.wrap__selected .mt-1').text('');
        $('.wrap__selected.active').removeClass('active');
        $('.wrap__selected').hide();
    }

    modalClose('#prod_certifi-modal');
})

//### 옵션 추가
function addOrderOption(tmp) {
    // 옵션 최대 6개
    oIdx = parseInt( oIdx + 1 );
    _tmp = parseInt( tmp );
    if (oIdx > 6) {
        oIdx = parseInt( oIdx - 1 );
        openModal('#alert-modal10');
    } else {
        var titleHtml = '<div class="optNum' + parseInt( _tmp -1 ) + ' form__list-wrap" data-opt_num="'+ parseInt( _tmp -1 ) +'">' +
            '   <div class="option_tit"><p>옵션 ' + oIdx + '</p><button onclick="checkRemoveOption(' + parseInt( _tmp -1 ) + ');">삭제</button></div>' +
            '   <div class="option_value_wrap">' + 
            '       <div class="option_box">' + 
            '           <dl class="mb-3">' + 
            '               <dt class="necessary">필수 옵션</dt>' + 
            '               <dd><div class="flex gap-2 btn_select">' +
            '                   <button class="option-required_0'+ parseInt( oIdx ) +' w-1/2" data-val="1">설정</button>' +
            '                   <button class="option-required_0'+ parseInt( oIdx ) +' w-1/2 active" data-val="0">설정 안함</button>' +
            '               </div></dd>' + 
            '           </dl>' +
            '           <dl class="mb-3">' +
            '               <dt class="necessary">옵션명</dt>' +
            '               <dd><input type="text" id="option-name_0' + parseInt( oIdx ) + '" name="option-name_0' + parseInt( oIdx ) + '" class="input-form w-full cls-opt-nm" placeholder="예시) 색상"></dd>' +
            '           </dl>' +
            '       </div>';

        for (let inx = 0; inx < _tmp; inx++) {
            const element = '       <div class="option_box item__input-wrap">' + 
                            '           <dl class="mb-3">' + 
                            '               <dt class="necessary">옵션값</dt>' + 
                            '               <dd><input type="text" id="option-property_0'+ parseInt( oIdx ) +'-' + (inx + 1) + '" name="option-property_name" class="input-form w-full" placeholder="예시) 화이트"></dd>' + 
                            '               <dd><input type="text" name="option-price" value="0" oninput="this.value=this.value.replace(/[^0-9.]/g, \'\');" class="input-form w-full mt-2" placeholder="예시) 100,000원"></dd>' + 
                            '           </dl>' + 
                            '           <button class="flex items-center justify-center gap-1 w-full h-11 rounded option_add input__add-btn"><svg class="w-5 h-5 stroke-stone-400"><use xlink:href="/img/m/icon-defs.svg#plus"></use></svg>옵션값 추가</button>' + 
                            '       </div>';
            titleHtml += element;
        }
        titleHtml += '   </div>' +'</div>';

        $('#optsArea').append(titleHtml);
    }
}

//### 옵션 삭제
function checkRemoveOption( optionIdx ) {
    $('#optsArea div.optNum' + optionIdx).remove();
    var num = 0;
    $('#optsArea > div').each(function() {
        num = parseInt( num + 1 );
        $(this).find('.option_tit p').text('옵션 ' + num);
    });
    oIdx = parseInt( oIdx - 1 );
}

//### 옵션값 추가
$('body').on('click', '.input__add-btn', function () {
    if ($(this).is('.input__del-btn')) { // 옵션값 삭제
        var valueWrap = $(this).parents('.option_value_wrap');
        var isLast = $(this).parents('.item__input-wrap').is(':last-child')
        $(this).parents('.item__input-wrap').remove();
        if (isLast) {
            valueWrap.find('.item__input-wrap:last').append(valueWrap.find('.input__add-btn:last').clone());
            valueWrap.find('.input__add-btn:last').removeClass('input__del-btn');
            valueWrap.find('.input__add-btn:last').html('' +
                '<svg class="w-5 h-5 stroke-stone-400"><use xlink:href="/img/m/icon-defs.svg#plus"></use></svg>옵션값 추가'
            );
        }
        if (valueWrap.find('.input__add-btn').length == 2) {
            valueWrap.find('.input__add-btn.input__del-btn').remove();
        }
    } else { // 옵션값 추가
        if ($(this).parents('.item__input-wrap').index() != 0) {
            $(this).parents('.item__input-wrap').find('.input__add-btn.input__del-btn').remove();
        }
        $(this).addClass('input__del-btn');
        $(this).html('<i class="ico__delete24"><span class="a11y">삭제</span></i>');
        var clone = $(this).parents('.item__input-wrap').clone();
        clone.find('input[name="option-property_name"]').val('');
        clone.find('input[name="option-price"]').val('0');
        clone.find('input[name="option-property_name"]').attr('id','option-property_01-'+$(this).parents('.item__input-wrap').index());
        clone.append(clone.find('.input__add-btn').clone());
        clone.find('.input__add-btn:last').removeClass('input__del-btn');
        clone.find('.input__add-btn:last').html('' +
            '<svg class="w-5 h-5 stroke-stone-400"><use xlink:href="/img/m/icon-defs.svg#plus"></use></svg>옵션값 추가'
        );
        $(this).parents('.option_value_wrap').append(clone);
    }
});

//### 옵션순서 변경 모달
function sortOption() {
    sortList = '';
    $('#optsArea .form__list-wrap').map(function() {
        sortList += '<li class="ui-state-default ui-sortable-handle" data-idx=' + $(this).index() + '>' +
            '   <div class="flex items-center gap-3 border-b py-3">' +
            '       <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list">' +
            '           <line x1="8" x2="21" y1="6" y2="6"></line>' +
            '           <line x1="8" x2="21" y1="12" y2="12"></line>' +
            '           <line x1="8" x2="21" y1="18" y2="18"></line>' +
            '           <line x1="3" x2="3.01" y1="6" y2="6"></line>' +
            '           <line x1="3" x2="3.01" y1="12" y2="12"></line>' +
            '           <line x1="3" x2="3.01" y1="18" y2="18"></line>' +
            '       </svg>' +
            '       <p>(필수): ' + $(this).find('.cls-opt-nm').val() + '</p>' +
            '       <p></p>' +
            '   </div>' +
            '</li>'
    });
    $('#sortable').html(sortList)
    modalOpen('#change_order_modal');
}

//### 옵션 순서 변경
$('#change_order_modal .btn-primary').click(function () {
    list = [];
    $('.ui-sortable-handle').map(function () {
        list.push($('#optsArea > div').eq($(this).data('idx')).clone());
    })

    $('#optsArea').empty();
    for(i = 0; i<list.length; i++) {
        if (list[i].length > 0) {
            $('#optsArea').append(list[i]);
        }
    }

    modalClose('#change_order_modal');
});

//### 에디터 초기화
function init_editor() {
    editer = new FroalaEditor('.prod_detail_area', {
        key: "wFE7nG5E4I4D3A11A6eMRPYf1h1REb1BGQOQIc2CDBREJImA11C8D6B5B1G4D3F2F3C8==",
        requestHeaders: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        // fullPage: true,
        height:300,
        useClasses: false,

        imageUploadParam: 'file',
        imageUploadURL: '/product/image',
        imageUploadParams: {folder: 'product'},
        imageUploadMethod: 'POST',
        imageMaxSize: 20 * 1024 * 1024,
        imageAllowedTypes: ['jpeg', 'jpg', 'png', 'gif'],

        events: {
            'image.inserted': function ($img, response) {
                var obj = $.parseJSON(response);
                $img.data('idx', obj.idx);
            },
            'image.removed': function ($img) {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    method: "DELETE",
                    url: "/product/image",
                    data: {
                        src: $img.attr('src'),
                        idx: $img.data('idx')
                    }
                })
            },
        }
    });
}
//에디터
const editor = new FroalaEditor('.prod_detail_area', {
    key: 'wFE7nG5E4I4D3A11A6eMRPYf1h1REb1BGQOQIc2CDBREJImA11C8D6B5B1G4D3F2F3C8==',
    height:300,
    requestHeaders: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    imageUploadParam: 'images',
    imageUploadURL: '/community/image',
    imageUploadMethod: 'POST',
    imageMaxSize: 5 * 1024 * 1024,
    imageAllowedTypes: ['jpeg', 'jpg', 'png'],
    events: {
        'image.uploaded': response => {
            const img_url = response;
            editor.image.insert(img_url, false, null, editor.image.get(), response);
            return false;
        },
        'image.removed': img => {
            const imageUrl = img[0].src;
        }
    }
});

//### step 이동 및 값 체크
const goStep = (item, pn)=>{
    if (pn == "n"){
        if (item == "step2"){
            if($('#form-list01').val() == '') {
                alert('상품명을 입력해주세요.');
                $('#form-list01').focus();
                return false;
            } 
            if ($('.product-img__add').length === 0) {
                alert('상품 이미지를 등록해주세요.');
                return false;
            }
            if ($('#categoryIdx').text() == "-"){
                alert('상품 카테고리를 등록해주세요.');
                return false;
            }
        }else if (item == "step3"){
            if ($('#product-price').val() == '') {
                alert('가격을 등록해주세요.');
                $('#product-price').focus();
                return;
            }
        }else if (item == "step4"){
            /*
            if ($('.shipping_method').length < 1) {
                alert('배송방법을 선택해주세요.');
                $('.shipping-wrap__add').focus();
                return;
            }
            */
        }else if (item == "step5"){
            if (editer.html.get() == '') {
                alert('상품 상세 내용을 입력해주세요.');
                editer.events.focus();
                return;
            }
        }
    }
    $(`.prod_regist_box .${item}`).addClass('active').siblings().removeClass('active')
}

function saveProduct(regType) {
    if (storedFiles.length === 0 && $('.product-img__add').length === 0) {
        alert('상품 이미지를 최소 1개 이상 등록해주세요.');
        return false; // 여기서 함수를 종료하여 서버(AJAX)로 요청을 보내지 않음
    }
    $('#loadingContainer').show();
    console.log(regType);
    var form = new FormData();
    form.append("reg_type", regType);
    form.append("name", $('#form-list01').val());
    for (var i = 0; i < stored600Files.length; i++) {
        if (stored600Files[i]) form.append('files[]', stored600Files[i]);
    }
    for (var i = 0; i < stored100Files.length; i++) {
        if (stored100Files[i]) form.append('files100[]', stored100Files[i]);
    }
    for (var i = 0; i < stored400Files.length; i++) {
        if (stored400Files[i]) form.append('files400[]', stored400Files[i]);
    }
    for (var i = 0; i < stored600Files.length; i++) {
        if (stored600Files[i]) form.append('files600[]', stored600Files[i]);
    }
    for (var i = 0; i < stored1000Files.length; i++) {
        if (stored1000Files[i]) form.append('files1000[]', stored1000Files[i]);
    }

    var property = '';
    $('#prod_property-modal .sub_property_area').each(function(o){
        if ($('#prod_property-modal .sub_property_area:eq('+o+') .check-form:checked').length > 0){
            $('#prod_property-modal .sub_property_area:eq('+o+') .check-form:checked').map(function (n, i) {
                property += $(this).data('sub_property') + ",";
            })
        }
    });
    form.append("property", property.slice(0, -1));

    form.append("category_idx", $('#categoryIdx').data('category_idx'));
    form.append('price', $('#product-price').val());
    form.append('is_price_open', $('button.is_price_open.active').data('val'));
    form.append('price_text', $('.price_text').val());
    form.append('is_new_product', $('.is_new_product').val());

    var pay_type = '';
    /*
    if ($('.payment').text() == "직접입력"){
        pay_type = '4';
    }else if ($('.payment').text() == "계좌이체"){
        pay_type = '2';
    }else if ($('.payment').text() == "업체 협의"){
        pay_type = '1';
    }else if ($('.payment').text() == "세금 계산서 발행"){
        pay_type = '3';
    }
    */
    pay_type = '2';
    form.append('pay_type', pay_type);
    if (pay_type == '4') {
        form.append('pay_type_text', '업체 문의');
    }
    form.append('product_code', '');

    var shipping = "";
    $('.shipping-wrap__add span.add__name').each(function (i, el) {
        shipping += $(el).text() + ", ";
    })
    form.append('delivery_info', shipping.slice(0, -2));
    form.append('notice_info',$('#form-list09').val());
    form.append('auth_info',$('#auth_info').text());
    form.append('product_detail', editer.html.get());
    form.append('is_pay_notice', $('.order-info01').val());
    form.append('pay_notice', $('#pay_notice').val());
    form.append('is_delivery_notice', $('.order-info02').val());
    form.append('delivery_notice', $('#delivery_notice').val());
    form.append('is_return_notice', $('.order-info03').val());
    form.append('return_notice', $('#return_notice').val());
    form.append('is_order_notice', $('.order-info04').val());
    form.append('order_title', $('#order_title').val());
    form.append('order_content', $('#order_content').val());

    @if(Route::current()->getName() == 'product.modify')
        form.append('productIdx', $('#modifyBtn').data('idx'));
        if (deleteImage.length > 0) {
            form.append('removeImage', deleteImage);
        }
    @endif

    var attachmentList = '';
    var imageOrder = [];

    $('.product-img__add').each(function () {
        var currentIdx = $(this).attr('data-idx');
        var fileName = $(this).attr('file');
        var aiPath = $(this).find('input[name^="ai_generated_paths"]').val();

        // 1. AI로 재생성된 이미지인 경우
        if (aiPath && aiPath !== "") {
            imageOrder.push('ai:' + fileName);
        } 
        // 2. 기존에 등록되어 있던 이미지인 경우
        else if (currentIdx !== undefined && currentIdx !== false && currentIdx !== "") {
            imageOrder.push('idx:' + currentIdx);
            attachmentList += currentIdx + ','; // 기존 로직 호환용
        } 
        // 3. 새로 올린 일반 이미지인 경우
        else {
            imageOrder.push('new:' + fileName);
        }
    });

    if (attachmentList != '') {
        form.append('attachmentIdx', attachmentList.slice(0, -1));
    }
    if (imageOrder.length > 0) {
        form.append('image_order', imageOrder.join(','));
    }
    
    var data = new Array();
    $('#optsArea .form__list-wrap').each(function (i, el) {
        var option = new Object();
        option.required = $(el).find('button.option-required_0'+(i+1)+'.active').val();
        option.optionName = $('#option-name_0' + (i+1)).val();

        var valueArray = new Array();
        $(el).find('.item__input-wrap').each(function (y, eli) {
            var value = new Object();
            value.propertyName = $(eli).find('input[name="option-property_name"]').val();
            value.price = $(eli).find('input[name="option-price"]').val();
            valueArray.push(value);
        })
        option.optionValue = valueArray;
        data.push(option);
    })
    form.append('product_option', JSON.stringify(data));

    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url             : '/product/saveProduct',
        enctype         : 'multipart/form-data',
        processData     : false,
        contentType     : false,
        data			: form,
        type			: 'POST',
        success: function (result) {
            proc = false;
            $('#loadingContainer').hide();
            if (result.success) {
                switch (regType) {
                    case 1: // 임시저장
                        modalOpen('#product_temp_save_modal');
                        break;
                    case 2: // 수정
                        modalOpen('#product_update_modal');
                        break;
                    default: // 상품등록
                        modalOpen('#product_save_modal');
                        break;
                }
            }
        }, error: function (e) {
            $('#loadingContainer').hide();
        }
    });
}

//## 미리보기
function preview() {
    setImg = '';
    $('.product-img__add').map(function () {
        setImg += '<li class="swiper-slide">' +
            '<img src="' + $(this).find('img').attr('src') + '" alt="' + $(this).find('img').attr('alt') + '">' +
            '</li>';
    })
    $('.big_thumb > ul').html(setImg);

    // 상품명 상단에 카테고리 노출
    $('.prod_detail_top .name h4').text($('#form-list01').val());

    // 상품가격
    if ($('button.is_price_open.active').data('val') == 0) {
        $('.prod_detail_top .info p').text($('.price_text').text());
    } else {
        $('.prod_detail_top .info p').text($('#product-price').val().replace(/\B(?=(\d{3})+(?!\d))/g, ',')+'원');
    }

    // 상품코드 노출
    if ($('input[name="product_code"]').val() != '') {
        $('.prod_detail_top dd.preview_product_code').text($('input[name="product_code"]').val());
    } else {
        $('.preview_product_code').parent().hide();
    }

    // 상품 상세 내용
    if (!editer || typeof editer === 'undefined') {
        init_editor();
    } else {
        $('#state_preview_modal .product-detail__img-area').html(editer.html.get());
    }

    if (requiredCnt == 0) {
        $('.right-wrap__selection').css('display', 'none');
    } else {
        $('.right-wrap__selection').html(htmlText);
    }

    var htmlText = "";
    var requiredCnt = 0;
    $('#optsArea > div.flex').each(function (i, el) {
        required = $(el).find('input[name="option-required_0' + (i+1) + '"]:checked').val();
        if(required == 1) {
            requiredCnt ++;
        }
    })

    htmlText = '';
    i = 1;
    $('.desc__select-group--item').map(function () {
        if ($(this).find('.select-group__result li').length > 0) {
            if (i%2 == 1) {
                htmlText += '<dl class="item01">';
            }
            htmlText += '<dt>' + $(this).find('button').text() + '</dt>';
            str = '';
            $(this).find('.select-group__result li').map(function (i, k) {
                str += (i != 0 ? ', ' : '') + $(this).find('span.property_name').text();
            })
            htmlText += '<dd>' + str + '</dd>';

            if(i%2 == 0) {
                htmlText += '</dl>';
            }
            i ++;
        }
    });

    if (i%2 == 0) {
        htmlText += '<dt></dt><dd></dd></dl>';
    }

    htmlText += '<dl class="item02">' +
        '<dt class="ico__notice24"><span class="a11y">공지</span></dt>' +
        '<dd>' + $('#form-list09').val() + '</dd>' +
        '</dl>';

    $('.product-detail__table').html(htmlText);

    var shipping = "";
    $('.shipping-wrap__add span.add__name').each(function (i, el) {
        shipping += $(el).text() + ", ";
    })
    $('#default-modal-preview02 dd.previce_delivery').text(shipping.slice(0, -2));
    $('#default-modal-preview02 .previce_title').text($('#form-list01').val());

    if ($('input[name="order-info01"]:checked').val() == 1) {
        $('#default-modal-preview02 .order-info_1 .order-info__desc').text($('#pay_notice').val());
        $('#default-modal-preview02 .order-info_1').css('display', 'block');
    } else {
        $('#default-modal-preview02 .order-info_1').css('display', 'none');
    }
    if ($('input[name="order-info02"]:checked').val() == 1) {
        $('#default-modal-preview02 .order-info_2 .order-info__desc').text($('#delivery_notice').val());
        $('#default-modal-preview02 .order-info_2').css('display', 'block');
    } else {
        $('#default-modal-preview02 .order-info_2').css('display', 'none');
    }
    if ($('input[name="order-info03"]:checked').val() == 1) {
        $('#default-modal-preview02 .order-info_3 .order-info__desc').text($('#return_notice').val());
        $('#default-modal-preview02 .order-info_3').css('display', 'block');
    } else {
        $('#default-modal-preview02 .order-info_3').css('display', 'none');
    }
    if ($('input[name="order-info04"]:checked').val() == 1) {
        $('#default-modal-preview02 .order-info_4 .order-info__title p').text($('#order_title').val());
        $('#default-modal-preview02 .order-info_4 .order-info__desc').text($('#order_content').val());
        $('#default-modal-preview02 .order-info_4').css('display', 'block');
    } else {
        $('#default-modal-preview02 .order-info_4').css('display', 'none');
    }

    // 미리보기 창 오픈
    modalOpen('#state_preview_modal');
}
const detail_thumb = new Swiper(".prod_detail_top .big_thumb", {
    slidesPerView: 1,
    spaceBetween: 0,
});

//### 저장된 상품 데이터가 있을 경우에만(수정화면) > 주문정보 가져오기 > 등록된 상품 목록 가져오기 
function loadProduct() {
    let loadType = $('.product_reg').data('loadtype'); // loadType = 0:modify, 1:기본정보 불러오기, 2:주문정보 불러오기
    let tempIdx = getUrlVars()["temp"];
    let url = `/product/getProductData/${productIdx}`;
    if (loadType == 0 && tempIdx != null) url += '?type=temp';

    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url				: url,
        data			: {},
        type			: 'POST',
        dataType		: 'json',
        success		: function(result) {
            console.log(result);
            result = result['data']['detail'];
            if (loadType == 0 || loadType == 1) {
                $('#form-list01').val(result['name']); // 상품명
                subCategoryIdx = result['category_idx']; // 카테고리 idx

                // 첨부파일 이미지 출력
                if (result['attachment'] != null) {
                    imageAddBtn = $('.product-img__gallery').clone();
                    $('.desc__product-img-wrap').html(imageAddBtn);
                    attIdx = result['attachment_idx'].split(',');
                    
                    result['attachment'].map(function (item, i) {
                        if (item != null) {
                            // 고유 ID 및 파일명 생성
                            var uniqueId = 'prv_existing_' + i;
                            var uniqueHiddenId = 'path_existing_' + i;
                            var fileName = item['originName'] || 'existing_file_' + i + '.jpg';

                            var html = `
                                <div class="w-[150px] h-auto pb-3 rounded-md relative flex flex-col items-center justify-start product-img__add" data-idx="${attIdx[i]}" file="${fileName}">
                                    <div class="relative w-[150px] h-[150px] bg-slate-100 rounded-md">
                                        <img id="${uniqueId}" class="w-full h-full object-cover rounded-md" src="${item['imgUrl']}" data-original-src="${item['imgUrl']}" alt="상품이미지0${(i+1)}">
                                        <div class="absolute top-2.5 right-2.5">
                                            <button class="ico__delete--circle !w-[28px] !h-[28px] bg-stone-600/50 !rounded-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-white mx-auto w-4 h-4"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                                            </button>
                                        </div>`;
                            
                            if (i == 0) {
                                html += '<div class="absolute top-2.5 left-2.5 add__badge"><p class="py-1 px-2 bg-stone-600/50 text-white text-center rounded-full text-sm">대표이미지</p></div>';
                            }
                            
                            html += `
                                    </div>
                                    <button type="button" class="mt-2 w-full h-[32px] flex items-center justify-center gap-1 border border-primary text-primary text-xs rounded bg-white" 
                                            onclick="openAiModal(this, '${fileName}', '#${uniqueId}', '#${uniqueHiddenId}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7"/><line x1="16" x2="22" y1="5" y2="5"/><line x1="19" x2="19" y1="2" y2="8"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                        AI 배경생성
                                    </button>
                                    <input type="hidden" id="${uniqueHiddenId}" name="ai_generated_paths[${fileName}]">
                                </div>`;

                            $('.desc__product-img-wrap').append(html);

                            // 기존 이미지를 storedFiles 배열에 넣기 위한 Fetch 로직 (CORS 프록시 라우트 사용)
                            var proxyUrl = "{{ route('product.ai.proxy_image') }}?url=" + encodeURIComponent(item['imgUrl']);

                            fetch(proxyUrl)
                                .then(res => {
                                    if (!res.ok) throw new Error('네트워크 응답 에러 (상태 코드: ' + res.status + ')');
                                    return res.blob();
                                })
                                .then(blob => {
                                    var file = new File([blob], fileName, { type: blob.type || 'image/jpeg' });
                                    storedFiles.push(file);

                                    removeFileByName(storedAiSourceFiles, fileName);
                                    storedAiSourceFiles.push(file);

                                    var objectUrl = URL.createObjectURL(blob);
                                    var image = new Image();
                                    image.onload = function() {
                                        URL.revokeObjectURL(objectUrl);

                                        var aiFile = getThumbFileAi(image, 1000, this.width, this.height);
                                        aiFile.name = fileName;
                                        storedAiFiles.push(aiFile);
                                    };
                                    image.src = objectUrl;
                                })
                                .catch(err => {
                                    console.error('기존 이미지 변환 실패:', err);
                                });
                        }
                    });

                    if (result['attachment'].length == 8) {
                        $('.product-img__gallery').hide();
                    }
                }
                // 저장된(선택된) 카테고리 값 관련
                $('input:radio[name=prod_category]').each(function(){
                    if ($(this).val() == result['category_idx']) {
                        $(this).parents('.prod_category li').addClass('on');
                        $(this).prop('checked', true);
                    }
                });
                $('#categoryIdx').data('category_idx', result['category_idx']);
                $('#categoryIdx').text(result['category']);
                getProperty(null);
                $('.propertyList').show();
                $('.checkedProperties').html('');

                // 카테고리 선택에 따른 상품 속성 값들..
                setTimeout(function () {
                    result['propertyList'].map(function (item) {
                        var propertyHtmlText = "";
                        $('#prod_property-modal .sub_property_area').each(function(o){
                            $('#prod_property-modal .sub_property_area:eq('+o+') .check-form').map(function (n, i) {
                                if ($(this).data('sub_property') == item.idx) { $(this).prop('checked', true); }
                            });
                        });
                        $('#prod_property-modal .sub_property_area').each(function(o){
                            if ($('#prod_property-modal .sub_property_area:eq('+o+') .check-form:checked').length > 0){
                                propertyHtmlText += '<div><div class="mt-5 font-medium">'+$(this).data('title')+'</div><div class="flex flex-wrap items-center gap-3 mt-2">';
                                $('#prod_property-modal .sub_property_area:eq('+o+') .check-form:checked').map(function (n, i) {
                                    propertyHtmlText += '<div class="flex items-center bg-stone-100 px-3 py-1 rounded-full gap-1" data-sub_idx="' + $(this).data('sub_property') + '">' +
                                    '   <span class="text-stone-500 property_name">' + $(this).data('sub_name') + '</span>' +
                                    '   <button class="ico_delete"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-stone-400"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg></button>' +
                                    '</div>';
                                })
                                propertyHtmlText += '</div></div>';
                            }
                        });
                        $('.checkedProperties').html(propertyHtmlText);
                    });
                }, 500);

                // 상품 가격
                $('#product-price').val(result['price']); 
                if (result['is_price_open'] == 1) {
                    $('button.is_price_open[data-val=1]').addClass('active');
                    $('button.is_price_open[data-val=0]').removeClass('active');
                } else {
                    $('button.is_price_open[data-val=1]').removeClass('active');
                    $('button.is_price_open[data-val=0]').addClass('active');
                    $('.div_ptxt0').addClass('active');
                    $('.div_ptxt1').removeClass('active')
                    $('.price_text').text(result['price_text']);
                }

                // 신상품 설정
                $('.is_new_product').val(1);

                // 결제 방식
                $('.payment_method').addClass('hidden');
                if (result['pay_type'] == "1"){
                    $('.payment').text('업체 협의');
                }else if (result['pay_type'] == "2"){
                    $('.payment').text('계좌이체');
                }else if (result['pay_type'] == "3"){
                    $('.payment').text('세금 계산서 발행');
                }else if (result['pay_type'] == "4"){
                    $('.payment').text('직접입력');
                    $('input[name="payment_text"]').val(result['pay_type_text']);
                    $('.payment_method').removeClass('hidden');
                }
                    $('input[name="payment_text"]').text('업체 문의');

                // 상품 코드
                $('input[name="product_code"]').val(result['product_code']);

                // 배송 방법
                var delivery = '';
                if(result && result['delivery_info']) {
                    result['delivery_info'].split(',').forEach(str => {
                        delivery += '' + 
                            '<div class="shipping_method px-4 py-2 mb-2 bg-stone-100 inline-flex items-center gap-1 text-sm rounded-full"><span class="add__name">' + $.trim(str) + '</span>' +
                            '   <button class="ico_delivery"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-stone-500"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button>' +
                            '</div>';
                    })
                    $('.shipping-wrap__add .shipping_method_list').append(delivery);
                    $('.shipping-wrap__add').removeClass('hidden');
                }

                // 상품 추가 공지
                $('#form-list09').val(result['notice_info']);

                // 인증 정보
                $('#auth_info').text(result['auth_info']);
                $('.auth-wrap__selected').removeClass('hidden');
                if(result && result['auth_info']) {
                    if(result['auth_info']) {
                        result['auth_info'].split(', ').forEach(str => {
                            if (authList.indexOf(str) == -1) {
                                $('#prod_certifi-modal .filter_list input[data-auth="기타 인증"]').attr('checked', true);
                                $('#auth_info_text').val(str);
                                $('#auth_info_text').css('display', 'block');
                            } else {
                                $('#prod_certifi-modal .filter_list input[data-auth="' + str + '"]').attr('checked', true);
                            }
                        });
                    }
                }

                // 상세 내용 작성
                editer.html.set(result['product_detail']);

                // 주문 옵션 추가
                var obj = $.parseJSON(result['product_option']);
                console.log(obj);
                obj.forEach(function (item, i) {
                    addOrderOption(item.optionValue.length);
                    //$('button.option-required_0' + (i + 1) + '[data-val=' + item.required + ']').prop('checked', true);
                    $('input#option-name_0' + (i + 1)).val(item.optionName);
                    // 나중에 직접 html을 만들어서 #optsArea에 innserhtml로 넣어야 할듯. 
                    item.optionValue.forEach(function (value, y) {
                        if (y > 0) {
                            //$('input#option-property_0' + (i + 1) + '-' + (y)).parent().find('.input__add-btn').trigger('click');
                            //console.log(  $('input#option-property_0' + (i + 1) + '-' + (y)).parent().find('.input__add-btn') )
                        }
                        $('input#option-property_0' + (i + 1) + '-' + (y + 1)).val(value.propertyName);
                        $('input#option-property_0' + (i + 1) + '-' + (y + 1)).parent().parent().find('dd > input[name="option-price"]').val(value.price);
                    })
                });

            }

            if (loadType == 0 || loadType == 2) {
                if (result['is_pay_notice'] == "1") {
                    $('#pay_notice').val(result['pay_notice']);
                    $('#pay_notice').parent().addClass('active');
                    $('.order-info01').val(1);
                }

                if (result['is_delivery_notice'] == "1") {
                    $('#delivery_notice').val(result['delivery_notice']);
                    $('#delivery_notice').parent().addClass('active');
                    $('.order-info02').val(1);
                }

                if (result['is_return_notice'] == "1") {
                    $('#return_notice').val(result['return_notice']);
                    $('#return_notice').parent().addClass('active');
                    $('.order-info03').val(1);
                } 

                if (result['is_order_notice'] == "1") {
                    $('#order_title').val(result['order_title']);
                    $('#order_content').val(result['order_content']);
                    $('#order_content').parent().addClass('active');
                    $('.order-info04').val(1);
                }

                // 미리보기쪽.. 일단 보류
                $('.sales_product_num').text(result['product_number']);
                if (result['access_date'] != null && result['access_date'] != '') {
                    $('.access_date').text(result['access_date'].split(' ')[0].replace(/-/g, '.'));
                }
            }
            window.product_detail = result['product_detail'];
        }
    });
}

function getUrlVars(){
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++){
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

$(function() {
    init_editor();
    //### 옵션 순서 변경
//    $("#sortable").sortable();
    // $("#sortable").disableSelection();

    if ($(location).attr('href').includes('modify')) {
        let idx = "{{ $productIdx }}";
        /** 주문정보 불러오기 일단 보류 */
        //$('#default-modal10 input[name="order-info"][data-product_idx="' + idx + '"]').prop('checked', true);
        //$('#default-modal10 .default-modal__footer button').data('type', 0);

        $('.product_reg').data('loadtype', 0);
        loadProduct();
    } else if ($(location).attr('href').includes('temp')) {
        /** 주문정보 불러오기 일단 보류 */
        //@argument('#default-modal10 .default-modal__footer button').data('type', 0);

        $('.product_reg').data('loadtype', 0);
        loadProduct();
    }
});
</script>
@endsection
