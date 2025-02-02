@extends('layouts.app')

@section('content')

<style>
.error{
    display: flex;
}
.hidden{
    display: none!important;
}
</style> 
<div class="join_header sticky top-0 h-16 bg-white flex items-center">
    <div class="inner">
        <a class="inline-flex" href="/"><img class="logo" src="./img/logo.svg" alt=""></a>
    </div>
</div>

<div id="content">
    <section class="join_common">
        <div class="join_inner">
            <div class="title">
                <h3>간편회원가입</h3>
                <!-- <div class="info">
                    <div class="flex items-center gap-1">
                        <img class="w-4" src="./img/member/info_icon.svg" alt="">
                        <p>회원 가입 후 관리자 승인 여부에 따라 서비스 이용이 가능합니다.</p>
                    </div>
                </div> -->
            </div>

            <div class="form_tab_content">
                <!-- 제조/도매일때 -->
                <div class="form_box ">
                    <h4>회원 정보를 입력해주세요.</h4>
                    <!-- <div class="info_box flex items-center gap-1 mt-2.5 mb-8">
                        <img class="w-4" src="./img/member/info_icon.svg" alt="">
                        가입 승인 이후 대표 계정에 소속된 직원 계정을 생성하실 수 있습니다.
                    </div> -->
                    <div class="mb-8 hidden " id="sns">
                        <dl class="flex">
                            <dt class="necessary">SNS 연결</dt>
                            <dd class="flex gap-1">
                                <div class="flex-1">
                                    <input type="text" class="input-form w-full" placeholder="SNS 연결" id="provider" readonly>
                                    <label for="" class="error hidden">존재하지않는 SNS 로그인 방식입니다.</label>
                                </div>
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-8">
                        <dl class="flex">
                            <dt class="necessary">이름</dt>
                            <dd>
                                <input type="text" class="input-form w-full" placeholder="이름을 입력해주세요." id="name">
                                <label for="name" class="error"></label>
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-8">
                        <dl class="flex">
                            <dt class="necessary">휴대폰번호</dt>
                            <dd class="flex gap-1">
                                <div class="flex-1">
                                    <input type="text" class="input-form w-full" placeholder="휴대폰번호" id="phone_number"  oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^(\d{0,3})(\d{0,4})(\d{0,4})$/g, '$1-$2-$3').replace(/\-{1,2}$/g, '');">
                                    <label for="phone_number" class="error"></label>
                                </div>
                                <button class="btn btn-black-line" onclick="duplicateCheck('phone_number')" >중복체크</button>
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-8">
                        <dl class="flex">
                            <dt class="necessary">이메일</dt>
                            <dd class="flex gap-1">
                                <div class="flex-1">
                                    <input type="email" class="input-form w-full " placeholder="이메일을 입력해주세요." id="email">
                                    <label for="email" class="error"></label>
                                </div>
                                <button class="btn btn-black-line" onclick="duplicateCheck('email')">중복체크</button>
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-8">
                        <dl class="flex">
                            <dt class="necessary">명함 또는 사업자 등록증</dt>
                            <dd>
                                <div class="file-form vertical">
                                    <input type="file" id="certificate" onchange="fileUpload(this)" accept="image/*">
                                    <label for="certificate" class="error hidden">명함 또는 사업자 등록증을 첨부해주세요.</label>
                                    <div class="text">
                                        <img class="mx-auto" src="./img/member/img_icon.svg" alt="" >
                                        <p class="mt-1">이미지 추가</p>
                                    </div>
                                </div>

                                <div class="info_box mt-2.5">
                                    ・권장 형식: jpg, jpeg, png
                                </div>
                            </dd>
                        </dl>
                    </div>

                </div>

            </div>
            <div class="form_bottom">
                {{-- <div class="form_box">
                    <div class="agree_wrap mb-8">
                        <h3>올펀 약관에 동의해주세요.</h3>
                        <div class="agree_box">
                            <div class="agree_item all">
                                <p><input type="checkbox" class="check-form" name="all_check" id="all"><label for="all">필수 약관 전체 동의</label></p>
                            </div>
                            <div class="agree_item">
                                <p><input type="checkbox" class="check-form" id="agree_1"><label for="agree_1">서비스 이용 약관 동의 (필수)</label></p>
                                <button onclick="modalOpen('#agree01-modal')">상세보기</button>
                            </div>
                            <div class="agree_item">
                                <p><input type="checkbox" class="check-form" id="agree_2"><label for="agree_2">개인정보 활용 동의 (필수)</label></p>
                                <button onclick="modalOpen('#agree02-modal')">상세보기</button>
                            </div>
                            <div class="agree_item">
                                <p><input type="checkbox" class="check-form" id="agree_3"><label for="agree_3">마케팅 정보 활용 동의 (선택)</label></p>
                                <button onclick="modalOpen('#agree03-modal')">상세보기</button>
                            </div>
                            <div class="agree_item">
                                <p><input type="checkbox" class="check-form" id="agree_4"><label for="agree_4">광고성 이용 동의 (선택)</label></p>
                                <button onclick="modalOpen('#agree04-modal')">상세보기</button>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="btn_box">
                    <button class="btn w-[300px] btn-primary" onclick="signup()">가입 완료</button>
                </div>
            </div>

        </div>
    </section>


    <div class="modal" id="agree01-modal">
        <div class="modal_bg" onclick="modalClose('#agree01-modal')"></div>
        <div class="modal_inner">
            <button class="close_btn" onclick="modalClose('#agree01-modal')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <h3>서비스 이용 약관</h3>
                <iframe src="https://api.all-furn.com/res/agreement/agreement.html"></iframe>
            </div>
        </div>
    </div>

    <div class="modal" id="agree02-modal">
        <div class="modal_bg" onclick="modalClose('#agree02-modal')"></div>
        <div class="modal_inner">
            <button class="close_btn" onclick="modalClose('#agree02-modal')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <h3>개인정보 활용 동의</h3>
                <iframe src="https://api.all-furn.com/res/agreement/privacy.html"></iframe>
            </div>
        </div>
    </div>

    <div class="modal" id="agree03-modal">
        <div class="modal_bg" onclick="modalClose('#agree03-modal')"></div>
        <div class="modal_inner">
            <button class="close_btn" onclick="modalClose('#agree03-modal')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <h3>개인정보 활용 동의</h3>
                <iframe src="https://api.all-furn.com/res/agreement/marketing.html"></iframe>
            </div>
        </div>
    </div>

    <div class="modal" id="agree04-modal">
        <div class="modal_bg" onclick="modalClose('#agree04-modal')"></div>
        <div class="modal_inner">
            <button class="close_btn" onclick="modalClose('#agree04-modal')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <h3>광고성 이용 동의</h3>
                <iframe src=""></iframe>
            </div>
        </div>
    </div>
</div>
<script>

let duplicate_check = {
    email : false,
    phone_number : false
}

document.addEventListener('DOMContentLoaded', function() {
    // sessionStorage에서 데이터 가져오기
    const socialUserData = sessionStorage.getItem('socialUserData');
    
    if (socialUserData) {
        const userData = JSON.parse(socialUserData);
        console.log(userData)
        $("#sns").removeClass('hidden')

        // 폼에 데이터 자동 입력
        if (document.getElementById('name')) {
            document.getElementById('name').value = userData.name || '';
        }
        if (document.getElementById('email')) {
            setReadonly('email',normalizeNaverEmail(userData.email)) || '';
        }
        if (document.getElementById('phone_number')) {
           setReadonly('phone_number' , userData.phone_number.replace(/[^0-9]/g, '').replace(/^(\d{0,3})(\d{0,4})(\d{0,4})$/g, '$1-$2-$3').replace(/\-{1,2}$/g, '')) || '';
        }
        if (document.getElementById('provider')) {
            document.getElementById('provider').value = snsNaming(userData.provider) || '' ;
        }

        sessionStorage.removeItem('socialUserData');
    }
});
 
function setReadonly(key,value) {
   
    if(value){
        
        $(`#${key}`).val(value);
        $(`#${key}`).attr('readonly', true);
    }
  
}



$("input[type=email]").blur(function(){
  var email = $(this).val();
  if( email == '' || email == 'undefined') return;
  if(! email_check(email) ) {
  	$(this).val('');
    $(this).focus();
    return false;
  }
});

function snsNaming(provider) {
    let snsName = '';
    switch (provider) {
        case 'naver':
            snsName = '네이버';
            break;
        case 'kakao':
            snsName = '카카오';
            break;
        case 'google':
            snsName = '구글';
            break;
        case 'apple':
            snsName = '애플';
            break;
        default:
            snsName = '';
            break;
    }
    return snsName;
}


// 사용중 이메일, 사용중 휴대전화번호 체크
function duplicateCheck(type ) {
    
    let param = $(`#${type}`).val();

    if(type === 'email' && !email_check(param)){
        $(`#${type}`).addClass('input-error');
        $('label[for="email"]').removeClass('hidden');
        $('label[for="email"]').text('이메일 형식이 올바르지 않습니다.');
        return false;

    }

    if(type === 'phone_number' && !phone_check(param)){
        $(`#${type}`).addClass('input-error');
        $('label[for="phone_number"]').removeClass('hidden');
        $('label[for="phone_number"]').text('휴대폰번호 형식이 올바르지 않습니다.');
        return false;

    }else{
        param = param.replace(/-/g, '');
    }

    $(`#${type}`).removeClass('input-error');
    $(`label[for="${type}"]`).addClass('hidden');
    $(`label[for="${type}"]`).text('');
     let ment ; 
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: `/member/duplicate/${type}`,
            data: {
                'check_param': param
            },
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                if (result == 0) {
                    
                    $(`#${type}`).removeClass('input-error');
                    $(`label[for="${type}"]`).addClass('hidden');
                    $(`label[for="${type}"]`).text('');
                    $(`#${type}`).closest('dd').find('button').attr('disabled', true);

                    if(type === 'email'){
                        ment = '사용 가능한 이메일 입니다.'
                        duplicate_check.email = true;
                    }else if(type === 'phone_number'){
                        ment = '사용 가능한 휴대전화번호 입니다.'
                        duplicate_check.phone_number = true;
                    }


                } else {
                    if(type === 'email'){
                        ment = '이미 사용중인 이메일 입니다.\n다시 확인해주세요.'
                    }else if(type === 'phone_number'){
                        ment = '이미 사용중인 휴대전화번호 입니다.\n다시 확인해주세요.'
                    }
                    $(`#${type}`).addClass('input-error');
                    $(`label[for="${type}"]`).removeClass('hidden');
                    $(`label[for="${type}"]`).text(ment);
                    $(`#${type}`).focus();
                }
                $(`#${type}_dupcheck_ment`).text(ment);
                modalOpen(`#modal-${type}--duplicated`);
            }
        });
 
            
}


// 이미지 변경
const fileUpload = (input) => {
    if (input.files && input.files[0]) {

        if($(".text").next("img").length > 0){
            $(".text").next("img").remove();
        }
        var reader = new FileReader();
        let img = input.nextElementSibling.querySelector('img')
        if(!img){
            img = document.createElement('img')
        }
        input.nextElementSibling.nextElementSibling.classList.add('hidden')

        reader.onload = function(e) {
            img.src = e.target.result 
            input.parentNode.append(img)
        };
        reader.readAsDataURL(input.files[0]);
    }
}




function normalizeNaverEmail(email) {
    return email.replace('jr.naver.com', 'naver.com');
}


function email_check( email ) {    
    var regex=/([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

    console.log(regex.test(email) , email)
    return (email != '' && email != 'undefined' && regex.test(email)); 
}

function phone_check( phone ) {    
    var regex = /^\d{3}-\d{3,4}-\d{4}$/;
    return (phone != '' && phone != 'undefined' && regex.test(phone)); 
}

// 탭변경
// $('.join_type button').on('click', function() {
//     $('.form_bottom').removeClass('hidden')

//     let inN = $(this).data('num')
//     $('.join_type button').removeClass('on')
//     $(this).addClass('on');
//     $('.form_tab_content > .form_box').eq(inN).removeClass('hidden').siblings().addClass('hidden')
// })

function signup(){
    
    if(validate()){
        let formData = new FormData();
        
        // 데이터 추가
        formData.append('name', $('#name').val());
        formData.append('email', $('#email').val());
        formData.append('phone_number', $('#phone_number').val());
        formData.append('provider', $('#provider').val());

        formData.append('agreementServicePolicy',  0);
        formData.append('agreementPrivacy', 0);
        formData.append('agreementMarketing', 0);
        formData.append('agreementAd',  0);
            
        // 파일 추가
        let fileInput = $('input[type=file]')[0];
        if(fileInput.files[0]) {
            formData.append('file', fileInput.files[0]);
        }

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "/member/createUserNew",
            type: 'POST',
            data:formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                if (result.success) {
                location.replace('/signup/success');
                isProc = false;
                
            } else {
                switch (result.code) {
                    case 1001:
                        openModal('#modal-email--duplicated');
                        isProc = false;
                        break;
                    default:
                        alert(result.message);
                        isProc = false;
                        break;
                }
            }
            },
            error: function(error) {
                console.error('Error:', error);
                console.log('Error:', error);
            }
        }); 
    }

}

function validate(){
    let name = $('#name').val();
    let email = $('#email').val();
    let phone_number = $('#phone_number').val();
    let provider = $('#provider').val();
    let file = $('input[type=file]')[0].files[0];
    

    if( name == '' || name == 'undefined'){
        $('#name').addClass('input-error');
        $('label[for="name"]').removeClass('hidden');
        $('label[for="name"]').text('이름을 입력해주세요.');
        $('#name').focus();
        return false;
    }else{
        $('#name').removeClass('input-error');
        $('label[for="name"]').addClass('hidden');
        $('label[for="name"]').text('');
    }

    if( email == '' || email == 'undefined'){
        $('#email').addClass('input-error');
        $('label[for="email"]').removeClass('hidden');
        $('label[for="email"]').text('이메일을 입력해주세요.');
        $('#email').focus();
        return false;
    }else{
        $('#email').removeClass('input-error');
        $('label[for="email"]').addClass('hidden');
        $('label[for="email"]').text('');
    }

    if( phone_number == '' || phone_number == 'undefined'){
        $('#phone_number').addClass('input-error');
        $('label[for="phone_number"]').removeClass('hidden');
        $('label[for="phone_number"]').text('휴대폰번호를 입력해주세요.');
        $('#phone_number').focus();
        return false;
    }else{
        $('#phone_number').removeClass('input-error');
        $('label[for="phone_number"]').addClass('hidden');
        $('label[for="phone_number"]').text('');
    }

    if( !duplicate_check.phone_number ){
        $('#phone_number').addClass('input-error');
        $('label[for="phone_number"]').removeClass('hidden');
        $('label[for="phone_number"]').text('휴대전화번호 중복체크를 해주세요.');
        $('#phone_number').focus();
        return false;
    }else{  
        $('#phone_number').removeClass('input-error');
        $('label[for="phone_number"]').addClass('hidden');
        $('label[for="phone_number"]').text('');
    }

    if( !duplicate_check.email ){
        $('#email').addClass('input-error');
        $('label[for="email"]').removeClass('hidden');
        $('label[for="email"]').text('이메일 중복체크를 해주세요.');
        $('#email').focus();
        return false;
    }else{
        $('#email').removeClass('input-error');
        $('label[for="email"]').addClass('hidden');
        $('label[for="email"]').text('');
    }

    if( !file ){
        $('input[type=file]').addClass('input-error');
        $('label[for="certificate"]').removeClass('hidden');
        $('label[for="certificate"]').text('명함 또는 사업자 등록증을 첨부해주세요.');
        $('input[type=file]').focus();
        return false;   
    }else{
        $('input[type=file]').removeClass('input-error');
        $('label[for="certificate"]').addClass('hidden');
        $('label[for="certificate"]').text('');
    }

  

    return true;
}
</script>

<div class="modal" id="modal-email--duplicated">
    <div class="modal_bg" onclick="modalClose('#modal-email--duplicated')"></div>
    <div class="modal_inner modal-sm">
        <button type="button" class="close_btn" onclick="modalClose('#modal-email--duplicated')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body agree_modal_body">
            <p class="text-center py-4"><b id='email_dupcheck_ment'>이미 사용중인 이메일 입니다.<br>다시 확인해주세요.</b></p>
            <div class="flex gap-2 justify-center">
                <button type="button" class="btn btn-primary w-1/2 mt-5" onclick="modalClose('#modal-email--duplicated');">확인</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-phone_number--duplicated">
    <div class="modal_bg" onclick="modalClose('#modal-phone_number--duplicated')"></div>
    <div class="modal_inner modal-sm">
        <button type="button" class="close_btn" onclick="modalClose('#modal-phone_number--duplicated')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body agree_modal_body">
            <p class="text-center py-4"><b id='phone_number_dupcheck_ment'>이미 사용중인 휴대전화번호 입니다.<br>다시 확인해주세요.</b></p>
            <div class="flex gap-2 justify-center">
                <button type="button" class="btn btn-primary w-1/2 mt-5" onclick="modalClose('#modal-phone_number--duplicated');">확인</button>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="smscode_time_over">
    <div class="modal_bg" onclick="modalClose('#smscode_time_over')"></div>
    <div class="modal_inner modal-sm">
        <button class="close_btn" onclick="modalClose('#smscode_time_over')" type="button"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body agree_modal_body">
            <p class="text-center py-4"><b>유효시간이 만료되었습니다.<br>인증코드를 재발송해주세요.</b></p>
            <div class="flex gap-2 justify-center">
                <button class="btn btn-primary w-1/2 mt-5" onclick="modalClose('#smscode_time_over')" type="button">확인</button>
            </div>
        </div>
    </div>
</div>


@endsection




