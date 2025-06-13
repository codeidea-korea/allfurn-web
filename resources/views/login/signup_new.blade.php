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
                <h3>회원가입</h3>
                <div class="info">
                    <div class="flex items-center gap-1">
                        <img class="w-4" src="./img/member/info_icon.svg" alt="">
                        <p>회원 가입 후 관리자 승인 여부에 따라 서비스 이용이 가능합니다.</p>
                    </div>
                </div>
            </div>

            <div class="join_social grid grid-cols-2 gap-10 text-center">
				<button class="py-5" style="font-size:22px">간편(SNS) 회원가입</button>
				<button class="py-5 border-b border-primary" style="font-size:22px">일반 회원가입</button>
			</div>

            <div class="form_tab_content">
                <div class="form_box">
                    <div class="mb-4">
                        <dl class="flex">
                            <dt class="necessary">SNS 연결</dt>
                            <dd>
                                <input type="text" class="input-form w-full" value="" readonly id="provider" autocomplete="false">
                              
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-4">
                        <dl class="flex">
                            <dt class="necessary">이름</dt>
                            <dd>
                                <input type="text" class="input-form w-full" value="" id="name" maxlength="30" autocomplete="false" onfocusout="isInOnlyAlphabetAndKorean(this)">
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-4">
                        <dl class="flex">
                            <dt class="necessary">휴대폰번호</dt>
                            <dd>
                                <input type="text" maxlength="13"  class="input-form w-full" value=""  id="phone_number" autocomplete="false" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^(\d{0,3})(\d{0,4})(\d{0,4})$/g, '$1-$2-$3').replace(/\-{1,2}$/g, '');">
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-4">
                        <dl class="flex">
                            <dt class="necessary">이메일(아이디)</dt>
                            <dd>
                                <input type="text" class="input-form w-full" value="" readonly id="email" autocomplete="false">
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-4">
                        <dl class="flex">
                            <dt class="necessary">명함 첨부</dt>
                            <dd>
                                <div class="file-form horizontal">
                                    <input type="file" onchange="fileUpload(this)" id="file" name="file" accept="image/*">
                                    <!-- <label for="" class="error">명함 이미지를 첨부해주세요.</label> -->
                                    <div class="text">
                                        <img class="mx-auto" src="./img/member/img_icon.svg" alt="">
                                        <p class="mt-1">명함 이미지 추가</p>
                                    </div>
                                </div>
                                <div class="info_box mt-2.5">
                                    ・jpg, png만 지원 합니다.
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="form_box hidden">
                    <div class="mb-4">
                        <dl class="flex">
                            <dt>이름</dt>
                            <dd>
                                <input type="text" class="input-form w-full" placeholder="이름을 입력해주세요." id="normal_name" maxlength="30" onfocusout="isInOnlyAlphabetAndKorean(this)">
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-4">
                        <dl class="flex">
                            <dt>휴대폰번호</dt>
                            <dd>
                                <input type="text" maxlength="13" class="input-form w-full" placeholder="휴대폰번호를 입력해주세요." id="normal_phone_number" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^(\d{0,3})(\d{0,4})(\d{0,4})$/g, '$1-$2-$3').replace(/\-{1,2}$/g, '');">
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-4">
                        <dl class="flex">
                            <dt>아이디</dt>
                            <dd>
                                <input type="text" class="input-form w-full" placeholder="아이디을 입력해주세요." id="normal_email">
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-4">
                        <dl class="flex">
                            <dt>비밀번호</dt>
                            <dd>
                                <input type="password" class="input-form w-full" placeholder="비밀번호를 입력해주세요." id="normal_password">
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-4">
                        <dl class="flex">
                            <dt>비밀번호 확인</dt>
                            <dd>
                                <input type="password" class="input-form w-full" placeholder="비밀번호 확인을 입력해주세요." id="normal_password_chk">
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-4">
                        <dl class="flex">
                            <dt>명함 첨부</dt>
                            <dd>
                                <div class="file-form horizontal">
                                    <input type="file" onchange="fileUpload(this)" id="normal_file" name="normal_file" accept="image/*">
                                    <!-- <label for="" class="error">명함 이미지를 첨부해주세요.</label> -->
                                    <div class="text">
                                        <img class="mx-auto" src="./img/member/img_icon.svg" alt="">
                                        <p class="mt-1">명함 이미지 추가</p>
                                    </div>
                                </div>
                                <div class="info_box mt-2.5">
                                    ・jpg, png만 지원 합니다.
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="btn_box">
                <button class="btn w-[300px] btn-primary" onclick="signup()">가입 완료</button>
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

let signupType = 'normal';
let userData = null;
let sns = null;

var userType = 'S';

document.addEventListener('DOMContentLoaded', function() {
    // sessionStorage에서 데이터 가져오기
    const socialUserData = sessionStorage.getItem('socialUserData');
   
    if (socialUserData) {
        signupType = 'social';
        userData = JSON.parse(socialUserData);
     
        $("#sns").removeClass('hidden') 

        // 폼에 데이터 자동 입력
        if (document.getElementById('name')) {
            document.getElementById('name').value = userData.name || '';
        }
        if (document.getElementById('email')) {
            setReadonly('email',normalizeNaverEmail(userData.email)) || '';
        }
        if (document.getElementById('phone_number')) {
            
            $(`#phone_number`).val(userData.phone_number.replace(/[^0-9]/g, '').replace(/^(\d{0,3})(\d{0,4})(\d{0,4})$/g, '$1-$2-$3').replace(/\-{1,2}$/g, '') || '');
//           setReadonly('phone_number' , userData.phone_number.replace(/[^0-9]/g, '').replace(/^(\d{0,3})(\d{0,4})(\d{0,4})$/g, '$1-$2-$3').replace(/\-{1,2}$/g, '')) || '';
        }
        if (document.getElementById('provider')) {
            document.getElementById('provider').value = snsNaming(userData.provider) || '' ;
            sns = userData.provider;
        }

        // sessionStorage.removeItem('socialUserData'); 
    }else{
        signupType = 'normal';
        // $(".join_social").children().eq(1).trigger('click');
    }
	
	if (!socialUserData) {
		
		// 일반 회원가입 탭 활성화
		$(".join_social").children().eq(1).addClass('border-b border-primary').siblings().removeClass('border-b border-primary');
		$('.form_tab_content > div').eq(1).removeClass('hidden').siblings().addClass('hidden');
		signupType = 'normal';
		
		// 소셜 데이터가 있으면 소셜 탭으로 전환
		const socialUserData = sessionStorage.getItem('socialUserData');
		if (socialUserData) {
			// 소셜 로그인 처리 코드...
			$(".join_social").children().eq(0).addClass('border-b border-primary').siblings().removeClass('border-b border-primary');
			$('.form_tab_content > div').eq(0).removeClass('hidden').siblings().addClass('hidden');
			signupType = 'social';
		}
	}else{
		// 소셜 로그인 처리 코드...
			$(".join_social").children().eq(0).addClass('border-b border-primary').siblings().removeClass('border-b border-primary');
			$('.form_tab_content > div').eq(0).removeClass('hidden').siblings().addClass('hidden');
			signupType = 'social';
	}
});
 
function setReadonly(key,value) {
   
    if(value){
        
        $(`#${key}`).val(value);
        $(`#${key}`).attr('readonly', true);
    }
  
}


function snsNaming(provider) {
    let snsName = '';
    switch (provider) {
        case 'naver':
            snsName = '네이버 연동';
            break;
        case 'kakao':
            snsName = '카카오 연동';
            break;
        case 'google':
            snsName = '구글 연동';
            break;
        case 'apple':
            snsName = '애플 연동';
            break;
        default:
            snsName = '';
            break;
    }
    return snsName;
}


// 사용중 이메일, 사용중 휴대전화번호 체크
function duplicateCheck(type ,param) {

    $('#modal-validation').find('.modal_body').find('button').off().on('click', function(){//
        modalClose('#modal-validation');
    });

    let result = '';

    /*
    if(type === 'email' && !email_check(param)){
        return '이메일 형식이 올바르지 않습니다.';
    }
        */

    if(type === 'phone_number' && !phone_check(param)){

      
        return '휴대폰번호 형식이 올바르지 않습니다.';

    }else{
        param = param.replace(/-/g, '');
    }

     $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: `/member/duplicate/${type}`,
            data: {
                'check_param': param
            },
            type: 'POST',
            dataType: 'json',
            async:false,
            success: function(data) {

                data === 0 ? result = '' : result = '이미 사용중인 ' + (type === 'email' ? '이메일' : '휴대전화번호') + ' 입니다.';
      
            },error:function(){
                
            }
        });
    return result
}




function normalizeNaverEmail(email) {
    if(email == '' || email == 'undefined' || email  == null){
        $("#email").prop('readonly', false);    
       return '';
    }
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



function signup(){
    if(signupType === 'social'){

        if(validate()){
	    $('#loadingContainer').show();
		
            let formData = new FormData();
		
            // 데이터 추가
            formData.append('user_type', userType);
            formData.append('name', $('#name').val());
            formData.append('email', $('#email').val());
            formData.append('phone_number', $('#phone_number').val().replace(/-/g, ''));
            formData.append('provider', $('#provider').val());

            formData.append('agreementServicePolicy',  0);
            formData.append('agreementPrivacy', 0);
            formData.append('agreementMarketing', 0);
            formData.append('agreementAd',  0);
                
            // 파일 추가
            let fileInput = $('#file')[0];
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
                    if (response.success) {
                    
                        alert("가입 요청되었습니다.");
    
						// 리다이렉트 정보가 있으면 이동 (서버에서 전달한 경우)
						if (response.redirect) {
							window.location.href = response.redirect;
							return; // 이후 코드 실행 방지
						}

						// 아래 Ajax 호출 대신 직접 이동
						window.location.href = "/signup/login/pending";
		

                    
                } else {
		    $('#loadingContainer').hide();
                    switch (result.code) {
                        case 1001:
                            openModal('#modal-validation');
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
			$('#loadingContainer').hide();
                    console.error('Error:', error);
                    console.log('Error:', error);
                }
            }); 
        }
    }else{
        normalSignUp();
    }
}

function normalSignUp(){
    
    if(validate('normal_')){
	$('#loadingContainer').show();

        let formData = new FormData();
            
            // 데이터 추가
            formData.append('user_type', userType);
            formData.append('name', $('#normal_name').val());
            formData.append('email', $('#normal_email').val());
            formData.append('phone_number', $('#normal_phone_number').val().replace(/-/g, ''));
            formData.append('password', $('#normal_password').val());
	    
            formData.append('agreementServicePolicy',  0);
            formData.append('agreementPrivacy', 0);
            formData.append('agreementMarketing', 0);
            formData.append('agreementAd',  0);
                
            // 파일 추가
            let fileInput = $('#normal_file')[0];
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
                    if (response.success) {
                    
                        alert("가입 요청되었습니다.");
    
						// 리다이렉트 정보가 있으면 이동 (서버에서 전달한 경우)
						if (response.redirect) {
							window.location.href = response.redirect;
							return; // 이후 코드 실행 방지
						}

						// 아래 Ajax 호출 대신 직접 이동
						window.location.href = "/signup/login/pending";
		
                
                    
                } else {
		    $('#loadingContainer').hide();
                    switch (result.code) {
                        case 1001:
                            openModal('#modal-validation');
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
		    $('#loadingContainer').hide();
                    console.error('Error:', error);
                    console.log('Error:', error);
                }
            }); 

    }
}

function validate(type = ''){

    
    let name = $(`#${type}name`).val();
    let email = $(`#${type}email`).val();
    let phone_number = $(`#${type}phone_number`).val();
    let provider = $(`#${type}provider`).val();
    let file =  $(`#${type}file`)[0].files[0];
    let password = $(`#${type}password`).val();
    let password_ck = $(`#${type}password_chk`).val();
    if(!type){
        if( provider == '' || provider == 'undefined'){
            $('#provider').addClass('input-error');
            $("#validation-ment").html('SNS 연결 정보가 없습니다.<br>다시 확인해주세요.');
            modalOpen('#modal-validation'); 
            $('#provider').focus();
            return false;
        }else{
            $('#provider').removeClass('input-error');
        }
    }

    if( name == '' || name == 'undefined'){
     
        $(`#${type}name`).addClass('input-error');
        $('#validation-ment').html('이름을 입력해주세요.');
        modalOpen('#modal-validation'); 
        $(`#${type}name`).focus();
        return false;
        
    }else{
      $(`#${type}name`).removeClass('input-error');
    }

    if( phone_number == '' || phone_number == 'undefined'){
        $(`#${type}phone_number`).addClass('input-error');
        $('#validation-ment').html('휴대전화번호를 입력해주세요.');
        modalOpen('#modal-validation'); 
        $(`#${type}phone_number`).focus();
        return false;
    }else{
        $(`#${type}phone_number`).removeClass('input-error');

    }

    if( email == '' || email == 'undefined'){
        $(`#${type}email`).addClass('input-error');
        $('#validation-ment').html('아이디를 입력해주세요.');
        modalOpen('#modal-validation'); 
       $(`#${type}email`).focus();
        return false;
    }else{
        $(`#${type}email`).removeClass('input-error');

    }

    if(type === 'normal_'){
        if(password == '' || password == 'undefined'){
            $(`#${type}password`).addClass('input-error');
            $('#validation-ment').html('비밀번호를 입력해주세요.');
            modalOpen('#modal-validation'); 
            $(`#${type}password`).focus();
            return false;
        }else{
            $(`#${type}password`).removeClass('input-error');
        }

        if(password_ck == '' || password_ck == 'undefined'){
            $(`#${type}password_confirm`).addClass('input-error');
            $('#validation-ment').html('비밀번호 확인을 입력해주세요.');
            modalOpen('#modal-validation'); 
            $(`#${type}password_confirm`).focus();
            return false;
        }else{
            $(`#${type}password_confirm`).removeClass('input-error');
        }

        if(password !== password_ck){
            $(`#${type}password`).addClass('input-error');
            $(`#${type}password_confirm`).addClass('input-error');
            $('#validation-ment').html('비밀번호가 일치하지 않습니다.');
            modalOpen('#modal-validation'); 
            $(`#${type}password`).focus();
            return false;
        }else{

            $(`#${type}password`).removeClass('input-error');
            $(`#${type}password_confirm`).removeClass('input-error');
        }
    }
    let emailResult =  duplicateCheck('email',email);


    if( emailResult !=''){
        $(`#${type}email`).addClass('input-error');
        $('#validation-ment').html(emailResult);
        modalOpen('#modal-validation'); 
        $(`#${type}email`).focus();
        return false;
    }
    else{
        $(`#${type}email`).removeClass('input-error');

    }

    if( !file ){
        $(`#${type}file`).addClass('input-error');
        $('#validation-ment').html('명함 이미지를 첨부해주세요.');
        modalOpen('#modal-validation'); 
        $(`#${type}file`).focus();
        return false;   
    }else{
        $(`#${type}file`).removeClass('input-error');
    }

    if(checkedPhoneNumber != phone_number || !isCheckedDuplicatePhoneNumber) {
        let phoneResult = duplicateCheck('phone_number',phone_number);
        checkedPhoneNumber = phone_number; 
        if( phoneResult !='' ){
            $(`#${type}phone_number`).addClass('input-error');
            $(`#validation-ment`).html(phoneResult + '<br>추가로 회원가입을 진행하시겠습니까?');
            modalOpen('#modal-validation'); 
            $(`#${type}phone_number`).focus();
    	    $('#modal-validation').find('.modal_body').find('button').off().on('click', function(){
                modalClose('#modal-validation'); 
                isCheckedDuplicatePhoneNumber = true; 
                signup();
            });
            return false;
        }else{  
            $(`#${type}phone_number`).removeClass('input-error');
        }
    }

    return true;
}
var isCheckedDuplicatePhoneNumber = false;
var checkedPhoneNumber = '';

// 이미지 변경
const fileUpload = (input) => {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            let img = input.parentNode.querySelector('img');
            if(!img){
                img = document.createElement('img')
            }
            input.nextElementSibling.classList.add('!hidden')

            reader.onload = function(e) {
                img.src = e.target.result
                input.parentNode.append(img)
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

// 탭변경
$('.join_social button').on('click',function(){
    let liN = $(this).index();
	
	if(liN === 0) {
        // 아무 동작도 하지 않거나 경고 메시지 표시
        // 예: alert("현재 SNS 회원가입 기능은 사용할 수 없습니다.");
        return false;
    }
	
    $(this).addClass('border-b border-primary').siblings().removeClass('border-b border-primary');
    $('.form_tab_content > div').eq(liN).removeClass('hidden').siblings().addClass('hidden')

    if($(".join_social").children().eq(1).hasClass('border-b border-primary')){
        signupType = 'normal';
    }else{
        signupType = 'social';
    }

    console.log(signupType)
})

    
$("input[type=email]").blur(function(){
  var email = $(this).val();
  if( email == '' || email == 'undefined') return;
  if(! email_check(email) ) {
  	$(this).val('');
    $(this).focus();
    return false;
  }
});

function isInOnlyAlphabetAndKorean(ele) {
    const regx = new RegExp('^[a-zA-Z가-힣]*$');
    if(regx.test(ele.value)){
        return;
    }
    alert('영문자 또는 한글만 입력 가능합니다.');
    ele.value = "";
}

</script>

<div class="modal" id="modal-validation">
    <div class="modal_bg" onclick="modalClose('#modal-validation')"></div>
    <div class="modal_inner modal-sm">
        <button type="button" class="close_btn" onclick="modalClose('#modal-validation')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body agree_modal_body">
            <p class="text-center py-4"><b id='validation-ment'>이미 사용중인 이메일 입니다.<br>다시 확인해주세요.</b></p>
            <div class="flex gap-2 justify-center">
                <button type="button" class="btn btn-primary w-1/2 mt-5" onclick="modalClose('#modal-validation');">확인</button>
            </div>
        </div>
    </div>
</div>



@endsection




