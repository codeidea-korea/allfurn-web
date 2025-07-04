
<!-- 오른쪽 컨텐츠 -->
<div class="w-full">
    <h3 class="text-xl font-bold">계정관리</h3>

    <div class="my_tab mt-3 flex w-full text-center">
        <button class="flex-1 py-2 border-b-2 border-slate-300">회원정보</button>
        <button class="flex-1 py-2 border-b-2 border-primary">회사정보</button>
    </div>

    
    <div class="tab_content">
        <!-- 회원정보 -->
        <div>
            <div class="flex flex-col items-center justify-center gap-5 px-28 py-10 border-b border-stone-600">
                <div class="flex gap-4 w-full">
                    <div class="essential w-[190px] shrink-0 mt-2">회원명</div>
                    <div class="font-medium w-full flex items-center gap-2">
                        <input type="text" class="setting_input h-[48px] w-full font-normal" placeholder="" id="user_name" value="{{ $user -> name }}">
                    </div>
                </div>
                <!--
                <div class="flex gap-4 w-full">
                    <div class="essential w-[190px] shrink-0 mt-2">회원구분</div>
                    <div class="font-medium w-full flex items-center gap-2">
                        <input type="text" class="setting_input h-[48px] w-full font-normal" placeholder="">
                    </div>
                </div>
                -->
                <div class="flex gap-4 w-full">
                    <div class="essential w-[190px] shrink-0 mt-2">이메일(아이디)</div>
                    <div class="font-medium w-full flex items-center gap-2">
                        <input type="text" class="setting_input h-[48px] w-full font-normal" placeholder="" id="user_email" value="{{ $user -> account }}" disabled>
                    </div>
                </div>
                <div class="flex gap-4 w-full">
                    <div class="essential w-[190px] shrink-0 mt-2">휴대폰번호</div>
                    <div class="font-medium w-full flex items-center gap-2">
                        <input type="text" class="setting_input h-[48px] w-full font-normal" placeholder="" id="user_phone" value="{{ $user -> phone_number }}">
                    </div>
                </div>
                <div class="flex gap-4 w-full">
                    <div class="essential w-[190px] shrink-0 mt-2">명함</div>
                    <div class="font-medium w-full flex flex-col flex-center gap-2">
                        <div class="file-form horizontal">
                            <input type="file" id="card" onchange="fileUpload(this)">
                            <label for="card" class="error">명함 이미지를 첨부해주세요.</label>
                            <img class="mx-auto" src="{{ $user -> image }}" onerror="this.src='/img/member/img_icon.svg';" alt="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <button class="btn btn-primary-line mt-5 px-5" type="button" onclick="updateUserInfo()">변경저장</button>
            </div>

        </div>

        <!-- 회사정보 -->
        <div class="active">
            <div class="flex flex-col items-center justify-center gap-5 px-28 py-10 border-b border-stone-600 _company_section">
                <div class="flex gap-4 w-full">
                    <div class="essential w-[190px] shrink-0 mt-2">서비스구분</div>
                    <div class="flex gap-5 py-2">
                        <p>
                            @if ($user -> type === 'S')
                            일반
                            @elseif ($user -> type === 'N')
                            기타 가구 관련업종
                            @elseif ($user -> type === 'R')
                            매장/판매
                            @elseif ($user -> type === 'W')
                            제조/도매
                            @endif
                            <input type="hidden" id="member_type_1" name="member_type" value="{{ $user -> type }}">
                        </p>
                    </div>
                </div>    
                <div class="flex gap-4 w-full">
                    <div class="essential w-[190px] shrink-0 mt-2">사업자번호</div>
                    <div class="font-medium w-full flex items-center gap-2">
                        <input type="text" class="setting_input h-[48px] w-full font-normal  business_code" placeholder="사업자등록번호" 
                            value="{{ $company -> business_license_number }}">
                    </div>
                </div>
                <div class="flex gap-4 w-full">
                    <div class="essential w-[190px] shrink-0 mt-2">업체명</div>
                    <div class="font-medium w-full flex items-center gap-2">
                        <input type="text" class="setting_input h-[48px] w-full font-normal  owner_name" placeholder="업체명"
                            value="{{ $company -> company_name }}">
                    </div>
                </div>
                <div class="flex gap-4 w-full">
                    <div class="essential w-[190px] shrink-0 mt-2">대표자명</div>
                    <div class="font-medium w-full flex items-center gap-2">
                        <input type="text" class="setting_input h-[48px] w-full font-normal  company_name" placeholder="대표자명"
                            value="{{ $company -> owner_name }}">
                    </div>
                </div>
                <div class="flex gap-4 w-full">
                    <div class="essential w-[190px] shrink-0 mt-2">사업자 주소</div>
                    <div class="font-medium w-full flex items-center gap-2">
                        <input type="text" class="setting_input h-[48px] w-full font-normal  business_address" placeholder="회사주소"
                            value="{{ $company -> business_address }}">
                    </div>
                </div>
                <div class="flex gap-4 w-full">
                    <div class="essential w-[190px] shrink-0 mt-2">사업자 상세주소</div>
                    <div class="font-medium w-full flex items-center gap-2">
                        <input type="text" class="setting_input h-[48px] w-full font-normal  business_address_detail" placeholder="주소"
                            value="{{ $company -> business_address_detail }}">
                    </div>
                </div>
                <div class="flex gap-4 w-full">
                    <div class="essential w-[190px] shrink-0 mt-2">사업자등록증</div>
                    <div class="font-medium w-full flex flex-col flex-center gap-2">
                        <div class="file-form vertical">
                            <input type="file" id="business" onchange="fileUpload(this)">
                            <label for="business" class="error">사업자등록증 이미지를 첨부해주세요.</label>
                            <img src="{{ $company -> license_image }}" onerror="this.src='/img/member/img_icon.svg';" alt="">
                        </div>
                    </div>
                </div>

            </div>

            

            <div class="flex items-center justify-end">
                <button class="btn btn-primary-line mt-5 px-5" type="button" onclick="updateUserInfo()">변경저장</button>
            </div>
        </div>

    </div>
</div>

<!-- 사업자등록증 -->
<div id="view_business_modal" class="modal">
    <div class="modal_bg" onClick="modalClose('#view_business_modal')"></div>
    <div class="modal_inner modal-md">
        <div class="modal_body filter_body">
            <h4>사업자등록증</h4>
            <img src="{{ $company -> license_image }}" class="w-full h-full" alt="" />
            <div class="btn_bot">
                <button class="btn btn-primary !w-full" onclick="modalClose('#view_business_modal')">확인</button>
            </div>
        </div>
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
    
// 회원구분 change
var company_type = '{{ auth() -> user()['type'] }}';
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

        
        // 탭버튼
        $('.my_tab button').on('click',function(){
            let num = $(this).index();
            $(this).addClass('border-primary').removeClass('border-slate-300').siblings().removeClass('border-primary').addClass('border-slate-300');
            $('.tab_content > div').eq(num).addClass('active').siblings().removeClass('active')
        })
    });

    const checkCompanyNumber = (isOpenOkVal) => {
        const targetCompanySection = $('._company_section');
        const originBusinessCode = '{{ $company -> business_license_number }}';
        const businessCode = targetCompanySection.find('.business_code').val();

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
        if($('._company_section').length > 0) {
            if(company_type != 'S' && !checkCompanyNumber(1)) {
                $('#loadingContainer').hide();
                return;
            }
        }

        var form = new FormData();
        form.append("company_type", company_type);
        form.append("user_email", $('#user_email').val());
        form.append("user_name", $('#user_name').val());
        form.append("user_phone", $('#user_phone').val());

        if(storedFile) {
            form.append("user_file", storedFile);
        }
        const targetCompanySection = $('._company_section');        
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
                alert('오류가 발생하였습니다.');
            }
        });
    }

    // 특정 권한 저장을 요구하는 화면 출력
    var targetGradeTypes = localStorage.getItem('loadRequiredUserGrade');
    if(targetGradeTypes && targetGradeTypes !== '') {
        targetGradeTypes = JSON.parse(targetGradeTypes);
        loadRequiredUserGrade();
    }
    function loadRequiredUserGrade() {
        const targetGradeType = targetGradeTypes[0];
        if(targetGradeType == 'S') {
            memberChange($('#member_type_1')[0], 'S', 1);
            $('#member_type_1').click();
        } else {
            if(targetGradeType == 'R') {
                memberChange($('#member_type_2')[0], 'R', 1);
                $('#member_type_2').click();
            } else if(targetGradeType == 'W') {
                memberChange($('#member_type_3')[0], 'W', 1);
                $('#member_type_3').click();
            } else if(targetGradeType == 'N') {
                memberChange($('#member_type_4')[0], 'N', 1);
                $('#member_type_4').click();
            }
        }
        const tmpMsg = targetGradeTypes.map(g => gradeNames.filter(n => n.grade === g)[0].name).join(', ')
        alert('특정 화면의 기능 사용을 위해 ' + tmpMsg + ' 회원으로 신청(저장)을 하셔야 합니다. 회원 승급 이후 사용 가능합니다.');
            
        localStorage.removeItem('loadRequiredUserGrade');
    }

</script>
