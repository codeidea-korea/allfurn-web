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
                        <div class="flex flex-wrap items-center gap-3 desc__product-img-wrap">
                            <div class="border border-dashed w-[150px] h-[150px] rounded-md relative flex items-center justify-center product-img__gallery">
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
var subCategoryIdx = null;
var deleteImage = [];
var proc = false;
var authList = ['KS 인증', 'ISO 인증', 'KC 인증', '친환경 인증', '외코텍스(OEKO-TEX) 인증', '독일 LGA 인증', 'GOTS(오가닉) 인증', '라돈테스트 인증', '전자파 인증', '전기용품안전 인증'];
var oIdx = 0;
var _tmp = 0;

    // 결제방식
    const paymentShow = (item)=>{
        $(`.${item}`).removeClass('hidden')
    }

    const paymentHide  = (item)=>{
        $(`.${item}`).addClass('hidden')
    }

    function getThumbFile(_IMG, maxWidth, width, height){
    var canvas = document.createElement("canvas");
    if(width < maxWidth) {
//        return _IMG;
    }
    canvas.width = width; // (maxWidth);
    canvas.height = height; // ((maxWidth / (width*1.0))*height);
    canvas.getContext("2d").drawImage(_IMG, 0, 0, width, height);

    var dataURL = canvas.toDataURL("image/png");
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
                    var image = new Image;
                    image.onload = function() {
                        file = getThumbFile(image, 500, this.width, this.height);
                        storedFiles.push(file);
                    };
                    image.src = e.target.result;

                    var image100 = new Image;
                    image100.width = 100;
                    image100.height = 100;
                    image100.onload = function() {
                        const i100 = getThumbFile(image100, 100, this.width, this.height);
                        stored100Files.push(i100);
                    };
                    image100.src = e.target.result;

                    var image400 = new Image;
                    image400.width = 400;
                    image400.height = 400;
                    image400.onload = function() {
                        const i400 = getThumbFile(image400, 400, this.width, this.height);
                        stored400Files.push(i400);
                    };
                    image400.src = e.target.result;

                    var image600 = new Image;
                    image600.width = 600;
                    image600.height = 600;
                    image600.onload = function() {
                        const i600 = getThumbFile(image600, 600, this.width, this.height);
                        stored600Files.push(i600);
                    };
                    image600.src = e.target.result;

                    $('.desc__product-img-wrap').append(
                        '<div class="w-[150px] h-[150px] rounded-md relative flex items-center justify-center bg-slate-400 product-img__add" file="' + file.name +  '">' +
                        '   <img class="w-[150px] h-[150px] object-cover rounded-md" src="' + e.target.result + '" alt="상품이미지0' + imgCnt + '">' +
                        '   <div class="absolute top-2.5 right-2.5">' +
                        '       <button class="ico__delete--circle !w-[28px] !h-[28px] bg-stone-600/50 !rounded-full">' +
                        '           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-white mx-auto w-4 h-4"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>' +
                        '       </button>' +
                        '   </div>' +
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
})
.on('click','.ico__delete--circle',function(e){
    e.preventDefault();
    var file = $(this).parent().parent().attr('file');
    var idx = $(this).parent().parent().index();

    $(this).parent().parent().remove('');
    for(var i = 0; i < storedFiles.length; i++) {
        if(storedFiles[i].name == file) {
            stored100Files.splice(i, 1);
            stored400Files.splice(i, 1);
            stored600Files.splice(i, 1);
            storedFiles.splice(i, 1);
            break;
        }
    }

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
            if (storedFiles.length == 0 && $('.product-img__add').length == 0) {
                alert('상품 이미지를 등록해주세요.');
                $('#form-list02').focus();
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
    $('#loadingContainer').show();
    console.log(regType);
    var form = new FormData();
    form.append("reg_type", regType);
    form.append("name", $('#form-list01').val());
    for (var i = 0; i < storedFiles.length; i++) {
        form.append('files[]', storedFiles[i]);
    }
    /*
    for (var i = 0; i < stored100Files.length; i++) {
        form.append('files100[]', stored100Files[i]);
    }
    for (var i = 0; i < stored400Files.length; i++) {
        form.append('files400[]', stored400Files[i]);
    }
    for (var i = 0; i < stored600Files.length; i++) {
        form.append('files600[]', stored600Files[i]);
    }*/

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
    form.append('price_text', $('.price_text').text());
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
        form.append('pay_type_text', $('input[name="payment_text"]').val());
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
    $('.product-img__add').map(function () {
        if($(this).data('idx') != undefined) {
            attachmentList += $(this).data('idx') + ',';
        }
    })
    if (attachmentList != '') {
        form.append('attachmentIdx', attachmentList.slice(0, -1));
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
                            var html = `
                                <div class="w-[150px] h-[150px] rounded-md relative flex items-center justify-center bg-slate-100 product-img__add" data-idx="${attIdx[i]}" >
                                    <img class="w-[150px] h-[150px] object-cover rounded-md" src="${item['imgUrl']}" alt="상품이미지0${(i+1)}">
                                    <div class="absolute top-2.5 right-2.5">
                                        <button class="ico__delete--circle w-[28px] h-[28px] bg-stone-600/50 rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-white mx-auto w-4 h-4"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                                        </button>
                                    </div>`;
                                    if (i == 0){
                                        html += '<div class="absolute top-2.5 left-2.5 add__badge"><p class="py-1 px-2 bg-stone-600/50 text-white text-center rounded-full text-sm">대표이미지</p></div>';
                                    }
                            html += '</div>';
                            $('.desc__product-img-wrap').append(html);
                        }
                    })
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
