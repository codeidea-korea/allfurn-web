@extends('layouts.app_m')

@php
    $only_quick = '';
    $header_depth = 'mypage';
    $top_title = '계정 관리';
    $header_banner = '';
@endphp
@php
    $tPoint = 0;
    if( !empty( $point ) ) {
        foreach( $point AS $p ) {
            if( $p->type == 'A' )
                $tPoint = $tPoint + $p->score;
            else
                $tPoint = $tPoint - $p->score;
        }
    }
@endphp

@section('content')
    @include('layouts.header_m')

    <div id="content">
        <div class="com_setting">
            
            <div class="com_setting mt-5">
                <div class="px-4">
                    <p class="font-bold">대표</p>
                    <div class="info">
                        <div class="flex items-center justify-center gap-1">
                            <img class="w-4" src="/img/member/info_icon.svg" alt="">
                            <p class="text-xs">대표 계정 정보는 고객센터에 문의하여 변경 요청해주세요.</p>
                        </div>
                    </div>
                </div>
            
                <div class="px-4 border-t-2 border-t-stone-600 flex flex-col items-center justify-center border-b py-5 gap-2">
                    <div class="flex flex-col gap-2 w-full">
                        <div class="essential w-[190px] shrink-0 mt-2">회원구분</div>
                        <div class="font-medium w-full flex items-center flex-wrap gap-x-5 gap-y-1">
                            <p>
                                <input type="radio" class="radio-form" id="member_type_1" name="member_type" value="0" onchange="memberChange(this, 'S')" 
                                {{ $user -> type === 'S' ? 'checked' : '' }}>
                                <label for="member_type_1">일반</label>
                            </p>
                            <p>
                                <input type="radio" class="radio-form" id="member_type_2" name="member_type" value="1" onchange="memberChange(this, 'R')" 
                                {{ $user -> type === 'R' ? 'checked' : '' }}>
                                <label for="member_type_2">매장/판매</label>
                            </p>
                            <p>
                                <input type="radio" class="radio-form" id="member_type_3" name="member_type" value="1" onchange="memberChange(this, 'W')" 
                                {{ $user -> type === 'W' ? 'checked' : '' }}>
                                <label for="member_type_3">제조/도매</label>
                            </p>
                            <p>
                                <input type="radio" class="radio-form" id="member_type_4" name="member_type" value="1" onchange="memberChange(this, 'N')" 
                                {{ $user -> type === 'N' ? 'checked' : '' }}>
                                <label for="member_type_4">기타가구 관련업종</label>
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                        <div class="essential w-[190px] shrink-0 mt-2">이메일 (아이디)</div>
                        <div class="font-medium w-full flex items-center gap-2">
                            <input type="text" class="setting_input h-[40px] w-full font-normal" id="user_email" value="{{ $user -> account }}" disabled>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                        <div class="essential w-[190px] shrink-0 mt-2">가입자명</div>
                        <div class="font-medium w-full flex items-center gap-2">
                            <input type="text" class="setting_input h-[40px] w-full font-normal" id="user_name" value="{{ $user -> name }}" disabled>
                        </div>
                    </div>
                    <!--
                    <div class="flex flex-col gap-2 w-full">
                        <div class="essential w-[190px] shrink-0 mt-2">직위</div>
                        <div class="font-medium w-full flex items-center gap-2">
                            <input type="text" class="setting_input h-[40px] w-full font-normal" value="{{ $user -> account }}">
                        </div>
                    </div>
-->
                    <div class="flex flex-col gap-2 w-full">
                        <div class="essential w-[190px] shrink-0 mt-2">휴대폰번호</div>
                        <div class="font-medium w-full flex items-center gap-2">
                            <input type="text" class="setting_input h-[40px] w-full font-normal" id="user_phone" value="{{ $user -> phone_number }}">
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                        <div class="essential w-[190px] shrink-0 mt-2">명함</div>
                        <div class="font-medium w-full flex flex-col gap-2">
                            <div class="flex gap-1">
                                <input type="file" class="input-form input-file w-full h-[40px]" id="card" onchange="fileUpload(this)">
                                <label for="card" class="flex items-center justify-center border border-stone-500 rounded-md h-[40px] w-[120px] shrink-0 hover:bg-stone-100">파일찾기</label>
                            </div>
                            <div class="file-form horizontal">
                                <img src="{{ $user -> image }}" onerror="this.src='/img/logo.svg';" alt="">
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <!-- 임직원 -->
            <div class="com_set mt-5 _company_section">
                <p class="font-bold px-4 pb-4">소속기업정보</p>

                <div class="px-4 border-t-2 border-t-stone-600 flex flex-col items-center justify-center border-b py-5 gap-2">
                    <div class="flex flex-col gap-2 w-full">
                        <div class="essential w-[190px] shrink-0 mt-2">사업자등록번호</div>
                        <div class="font-medium w-full flex items-center gap-2">
                            <input type="text" class="setting_input h-[40px] w-full font-normal  business_code" placeholder="사업자등록번호"
                                value="@php if($user->type == 'S'){ echo $company -> business_license_number; } @endphp">
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                        <div class="essential w-[190px] shrink-0 mt-2">대표자명</div>
                        <div class="font-medium w-full flex items-center gap-2">
                            <input type="text" class="setting_input h-[40px] w-full font-normal  owner_name" placeholder="대표자명"
                                value="@php if($user->type == 'S'){ echo $company -> owner_name; } @endphp">
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                        <div class="essential w-[190px] shrink-0 mt-2">업체명</div>
                        <div class="font-medium w-full flex items-center gap-2">
                            <input type="text" class="setting_input h-[40px] w-full font-normal  company_name" placeholder="업체명"
                                value="@php if($user->type == 'S'){ echo $company -> company_name; } @endphp">
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                        <div class="essential w-[190px] shrink-0 mt-2">회사주소</div>
                        <div class="font-medium w-full flex items-center gap-2">
                            <input type="text" class="setting_input h-[40px] w-full font-normal  business_address" placeholder="회사주소"
                                value="@php if($user->type == 'S'){ echo $company -> business_address; } @endphp">
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                        <div class="essential w-[190px] shrink-0 mt-2">회사상세세주소</div>
                        <div class="font-medium w-full flex items-center gap-2">
                            <input type="text" class="setting_input h-[40px] w-full font-normal  business_address_detail" placeholder="주소"
                                value="@php if($user->type == 'S'){ echo $company -> business_address_detail; } @endphp">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 매장/판매 제조/도매 기타가구관련업종 -->
            <div class="com_set2 hidden mt-5 _company_section">
                <p class="font-bold px-4 pb-4">기업정보</p>

                <div class="px-4 border-t-2 border-t-stone-600 flex flex-col items-center justify-center border-b py-5 gap-2">
                    <div class="flex flex-col gap-2 w-full">
                        <div class="essential w-[190px] shrink-0 mt-2">사업자등록번호</div>
                        <div class="font-medium w-full flex items-center gap-2">
                            <input type="text" class="setting_input h-[40px] w-full font-normal  business_code" placeholder="사업자등록번호"
                                value="@php if($user->type != 'S'){ echo $company -> business_license_number; } @endphp">
                            <button type="button" onclick="checkCompanyNumber(0);" class="flex items-center justify-center border border-stone-500 rounded-md h-[40px] w-[120px] shrink-0 hover:bg-stone-100">중복체크</button>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                        <div class="essential w-[190px] shrink-0 mt-2">업체명</div>
                        <div class="font-medium w-full flex items-center gap-2">
                            <input type="text" class="setting_input h-[40px] w-full font-normal  company_name" placeholder="업체명"
                                value="@php if($user->type != 'S'){ echo $company -> company_name; } @endphp">
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                        <div class="essential w-[190px] shrink-0 mt-2">대표자명</div>
                        <div class="font-medium w-full flex items-center gap-2">
                            <input type="text" class="setting_input h-[40px] w-full font-normal  owner_name" placeholder="대표자명"
                                value="@php if($user->type != 'S'){ echo $company -> owner_name; } @endphp">
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                        <div class="essential w-[190px] shrink-0 mt-2">회사주소</div>
                        <div class="font-medium w-full flex items-center gap-2">
                            <input type="text" class="setting_input h-[40px] w-full font-normal  business_address" placeholder="주소"
                                value="@php if($user->type != 'S'){ echo $company -> business_address . ' ' . $company -> business_address_detail; } @endphp">
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                        <div class="essential w-[190px] shrink-0 mt-2">회사상세세주소</div>
                        <div class="font-medium w-full flex items-center gap-2">
                            <input type="text" class="setting_input h-[40px] w-full font-normal  business_address_detail" placeholder="주소"
                                value="@php if($user->type != 'S'){ echo $company -> business_address_detail; } @endphp">
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                        <div class="essential w-[190px] shrink-0 mt-2">사업자등록증</div>
                        <div class="font-medium w-full flex flex-col gap-2">
                            <div class="flex gap-1">
                                <input type="file" class="input-form input-file w-full h-[40px]" id="business" onchange="fileUpload(this)">
                                <label for="business" class="flex items-center justify-center border border-stone-500 rounded-md h-[40px] w-[120px] shrink-0 hover:bg-stone-100">파일찾기</label>
                            </div>
                            <div class="file-form vertical">
                                <img src="{{ $company -> license_image }}" onerror="this.src='/img/logo.svg';" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-end gap-2 p-3">
            <button class="btn btn-primary-line mt-5 px-5" id="completeAddressBtn" onClick="updateUserInfo();">변경저장</button>
        </div>
    </div>

    <!-- 휴대폰번호 수정 -->
    <div class="modal" id="edit_phone_number">
        <div class="modal_bg" onClick="modalClose('#edit_phone_number');"></div>
        <div class="modal_inner modal-md">
            <div class="modal_body filter_body">
                <h4>휴대폰번호 수정</h4>
                <div class="py-3">
                    <p>휴대폰번호<span class="text-primary">*</span></p>
                    <div class="mt-1">
                        <div class="flex items-center gap-2">
                            <div class="setting_input h-[48px]">
                                <select name="" id="" class="w-full h-full">
                                    <option value="">대한민국(+82)</option>
                                </select>
                            </div>
                            <div class="setting_input h-[48px] grow">
                                <input type="text" name="phone_number" id="phone_number" class="w-full h-full" value="{{ $company -> phone_number }}" placeholder="- 없이 숫자만 입력해주세요." oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')" />
                            </div>
                        </div>
                        
                    </div>
                
                </div>
                <div class="btn_bot">
                    <button class="btn btn-primary !w-full" onclick="updatePhoneNumber()">완료</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 사업자주소 수정 -->
    <div id="edit_business_number" class="modal">
        <div class="modal_bg" onClick="modalClose('#edit_business_number');"></div>
        <div class="modal_inner modal-md">
            <div class="modal_body filter_body">
                <h4>사업자주소 수정</h4>
                <div class="com_setting py-3">
                    <div class="flex flex-col w-full">
                        <div class="flex justify-between">
                            <div class="flex gap-6">
                                <div class="flex items-center gap-1 domestic_radio"><input type="radio" name="is_domestic" id="domestic" value="1" onClick="changeDomesticType(this);" {{ $company -> is_domestic == '1'? 'checked' : '' }} /> <label for="domestic">국내</label></div>
                                <div class="flex items-center gap-1 overseas_radio"><input type="radio" name="is_domestic" id="overseas" value="0" onClick="changeDomesticType(this);" {{ $company -> is_domestic == '0'? 'checked' : '' }} />  <label for="overseas">해외</label></div>
                            </div>
                            <button class="h-[48px] w-[98px] border border-stone-500 rounded-md shrink-0 delete_address hover:bg-stone-100" style="display: none;">삭제</button>
                        </div>
                        <div class="domestic_section mt-2 location--type01 {{ $company -> is_domestic == '1'? '' : 'hidden' }}"> 
                            <div class="flex items-center gap-2">
                                <input type="text" name="default_address" id="default_address" class="setting_input h-[48px] w-full bg-stone-50" value="{{ $company -> business_address }}" placeholder="사업자 주소를 입력해주세요." onClick="callMapApi();" readOnly />
                                <button class="h-[48px] w-[98px] border border-stone-500 rounded-md shrink-0" onClick="callMapApi();">주소 검색</button>
                            </div>
                        </div>
                        <div class="overseas_section mt-2 relative location--type02 {{ $company -> is_domestic == '0'? '' : 'hidden' }}">
                            <input type="hidden" name="domestic_type" id="domestic_type" value="" />
                            <div class="my_filterbox h-[48px]">
                                <a href="javascript:;" class="filter_border filter_dropdown w-full h-[48px] flex justify-between items-center" style="border-radius: 3px;">
                                    <p class="dropdown__title">지역</p>
                                    <svg class="w-6 h-6 filter_arrow"><use xlink:href="/img/icon-defs.svg#drop_b_arrow"></use></svg>
                                </a>
                                <div class="filter_dropdown_wrap bg-white w-full h-[150px] overflow-y-scroll">
                                    <ul>
                                        @foreach(config('constants.GLOBAL_DOMESTIC') as $domestic)
                                        <li>
                                            <a href="javascript: void(0);" class="flex items-center" data-domestic-type="{{ $loop -> index + 1 }}" onClick="setDomesticType(this);">{{ $domestic }}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="domestic_section mt-2" style="display: block;">
                            <input type="text" name="detail_address" id="detail_address" class="setting_input h-[48px] w-full mt-2" value="{{ $company -> business_address_detail }}" placeholder="상세 주소를 입력해주세요." />
                        </div>
                    </div>
                </div>
                <div class="btn_bot">
                    <button type="button" id="completeAddressBtn" class="btn btn-primary !w-full" onClick="updateAddressProc();">완료</button>
                </div>
            </div>
        </div>
    </div>

    <script src="/js/jquery-1.12.4.js?{{ date('Ymdhis') }}"></script>
    <script defer src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script>
        
var company_type = '{{ auth() -> user()['type'] }}';
// 회원구분 change
const memberChange = (item, type, silent)=>{
    if('{{ auth() -> user()['type'] }}' != 'S' && !silent) {
        alert('일반 회원이 아닌 경우, 회원 구분 변경 시 관리자 문의 부탁드립니다.');
        return false;
    }
    if($(item).prop('checked')){
        if($(item).val() == "1"){
            $('.com_set').addClass('hidden')
            $('.com_set2').removeClass('hidden')
        }else{
            $('.com_set').removeClass('hidden')
            $('.com_set2').addClass('hidden')
        }
    }
    company_type = type;
}
if(company_type == 'S') {
    memberChange($('#member_type_1')[0], 'S', 1);
} else {
    if(company_type == 'R') {
        memberChange($('#member_type_2')[0], 'R', 1);
    } else if(company_type == 'W') {
        memberChange($('#member_type_3')[0], 'W', 1);
    } else if(company_type == 'N') {
        memberChange($('#member_type_4')[0], 'N', 1);
    }
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
// 이미지 변경
const fileUpload = (input) => {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        let img = input.parentNode.parentNode.querySelector('.file-form').querySelector('img');
        if(!img){
            img = document.createElement('img')
        }

        reader.onload = function(e) {
            img.src = e.target.result
            input.parentNode.parentNode.querySelector('.file-form').append(img)
            var image = new Image;
            image.onload = function() {
                if(input.id === 'business') {
                    storedCompanyFile = getThumbFile(image, 500, this.width, this.height);
                } else {
                    storedFile = getThumbFile(image, 500, this.width, this.height);
                }
            };
            image.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

        
        $(document).ready(function(){
            $('.dropdown__title').text('{{ $company -> business_address }}');

            $(document).on('click', '.filter_dropdown', function(e){
                $(this).toggleClass('active');
                $(this).closest('.my_filterbox').find('.filter_dropdown_wrap').toggle();
                $(this).find('svg').toggleClass('active');

                e.stopPropagation();
            });

            $(document).on('click', '.filter_dropdown_wrap ul li a', function(){
                var selectedText = $(this).text();
                $(this).closest('.my_filterbox').find('.filter_dropdown p').text(selectedText);

                $(this).closest('.location--type02').find('[name*=domestic_type]').val($(this).data('domestic-type'));

                $('#default_address').val(selectedText);

                $('.filter_dropdown_wrap').hide();
                $('.filter_dropdown').removeClass('active');
                $('.filter_dropdown svg').removeClass('active');
            });

            $(document).click(function(e){
                var $target = $(e.target);

                if(!$target.closest('.filter_dropdown').length && $('.filter_dropdown').hasClass('active')) {
                    $('.filter_dropdown_wrap').hide();
                    $('.filter_dropdown').removeClass('active');
                    $('.filter_dropdown svg').removeClass('active');
                }
            });
        });

    const checkCompanyNumber = (isOpenOkVal) => {
        const targetCompanySection = $('._company_section:visible');
        const businessCode = targetCompanySection.find('.business_code').val();
        const originBusinessCode = '{{ $company -> business_license_number }}';

        if(originBusinessCode == businessCode) {
            if(!isOpenOkVal) {
                alert('사업자 번호가 변경되지 않았으므로 검증할 필요가 없습니다.');
            }
            return true;
        }
        
        if(businessCode.replaceAll('-','').length != 10){
            alert('잘못된 사업자 등록번호입니다.');
            return false;
        }
        let dupplicated = true;
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/member/checkUsingBusinessNumber',
            data: {
                'business_number': businessCode.replaceAll('-','')
            },
            type: 'POST',
            dataType: 'json',
            async: false,
            success: function(result) {
                if (result == 0) {
                    if(!isOpenOkVal) {
                        alert('사용가능한 사업자번호 입니다.');
                    }
                    dupplicated = false;
                } else {
                    if(!isOpenOkVal) {
                        alert('중복된 사업자 등록번호입니다.');
                    }
                }
            }
        });
        return !dupplicated;
    };

    var storedFile = null;
    var storedCompanyFile = null;
    const updateUserInfo = () => {
        $('#loadingContainer').show();

        if(company_type != '{{ auth() -> user()['type'] }}' && '{{ auth() -> user()['type'] }}' != 'S') {
            alert('일반 회원이 아닌 경우, 회원 구분 변경 시 관리자 문의 부탁드립니다.');
            $('#loadingContainer').hide();
            return false;
        }
        if(company_type != 'S' && !checkCompanyNumber(1)) {
            $('#loadingContainer').hide();
            return;
        }

        var form = new FormData();
        form.append("company_type", company_type);
        form.append("user_email", $('#user_email').val());
        form.append("user_name", $('#user_name').val());
        form.append("user_phone", $('#user_phone').val());

        if(storedFile) {
            form.append("user_file", storedFile);
        }
        const targetCompanySection = $('._company_section:visible');        
        form.append("email", $('#user_email').val());
        form.append("business_code", targetCompanySection.find('.business_code').val());
        form.append("company_name", targetCompanySection.find('.company_name').val());
        form.append("owner_name", targetCompanySection.find('.owner_name').val());
        form.append("business_address", targetCompanySection.find('.business_address').val());
        form.append("business_address_detail", targetCompanySection.find('.business_address_detail').val());

        if(storedCompanyFile) {
            form.append("company_file", storedCompanyFile);
        }

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url             : '/member/update',
            enctype         : 'multipart/form-data',
            processData     : false,
            contentType     : false,
            data			: form,
            type			: 'POST',
            async: false,
            success: function (result) {
                $('#loadingContainer').hide();
                if(company_type != '{{ auth() -> user()['type'] }}') {
                    alert('회원 구분이 변경되어 로그아웃 처리 됩니다. 다시 로그인하여 주세요.');
                    location.href = '/signout';
                } else {
                    alert('정보를 수정하였습니다.');
                    location.reload();
                }
            }, error: function (e) {
                $('#loadingContainer').hide();
            }
        });
    }
    </script>
@endsection
