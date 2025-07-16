@extends('layouts.app_m')

@php

$header_depth = 'login';
$only_quick = 'yes';
$top_title = '';
$header_banner = '';

@endphp

@section('content')

<style>
    .error{
        display: flex;
    } 
    .hidden{
        display: none!important;
    }
    </style> 

<div class="join_header sticky top-0 bg-white flex items-center">
    <div class="inner">
        <h3>회원가입</h3>
        <a class="close_btn" href="/signin"><svg><use xlink:href="./img/icon-defs.svg#x"></use></svg></a>
    </div>
</div>

<div id="content">
    <section class="join_common" style="padding-top:0; ">

        <div class="join_social grid gap-4 text-center mb-5">
            <!-- <button class="py-2 fs16 font-medium border-b border-primary hidden">간편 회원가입</button>
            <button class="py-2 fs16 font-medium hidden">일반 회원가입</button> -->
        </div>

        <div class="join_inner">

            <div class="form_tab_content">
                <div class="form_box">
                    <div class="mb-2 font-medium text-lg">간편회원가입</div>
                    <a href="javascript:;" id="naver" class="btn !h-14 mb-2 text-white" style="background-color:#6dc66e; color:#0f0d0d;">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.5608 10.7042L6.14667 0H0V20H6.43833V9.29667L13.8533 20H20V0H13.5608V10.7042Z" fill="#0F0D0D"/>
                        </svg>    
                        네이버로 회원가입
                    </a>
                    <a href="javascript:;" id="kakao" class="btn !h-14 mb-2 text-white" style="background-color:#FAC813; color:#0f0d0d;">
                        <svg width="28" height="25" viewBox="0 0 28 25" fill="none" class="mr-1" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 0.75C21.25 0.75 27.1262 5.33 27.1262 10.9813C27.1262 16.6313 21.25 21.2113 14.0012 21.2113C13.2795 21.21 12.5585 21.1641 11.8425 21.0738L6.33247 24.6775C5.70622 25.0088 5.48497 24.9725 5.74247 24.1613L6.85747 19.5638C3.25747 17.7388 0.876221 14.5763 0.876221 10.9813C0.876221 5.33125 6.75122 0.75 14.0012 0.75M21.3862 10.825L23.2237 9.045C23.3297 8.93489 23.3889 8.78792 23.3887 8.63506C23.3885 8.48219 23.329 8.33537 23.2227 8.22551C23.1164 8.11565 22.9717 8.05134 22.8189 8.04611C22.6661 8.04089 22.5173 8.09516 22.4037 8.1975L19.9937 10.53V8.6025C19.9937 8.44602 19.9316 8.29595 19.8209 8.18531C19.7103 8.07466 19.5602 8.0125 19.4037 8.0125C19.2472 8.0125 19.0972 8.07466 18.9865 8.18531C18.8759 8.29595 18.8137 8.44602 18.8137 8.6025V11.7987C18.7929 11.8901 18.7929 11.9849 18.8137 12.0763V13.875C18.8137 14.0315 18.8759 14.1815 18.9865 14.2922C19.0972 14.4028 19.2472 14.465 19.4037 14.465C19.5602 14.465 19.7103 14.4028 19.8209 14.2922C19.9316 14.1815 19.9937 14.0315 19.9937 13.875V12.1713L20.5275 11.655L22.3125 14.1962C22.357 14.2597 22.4137 14.3137 22.4791 14.3553C22.5446 14.3969 22.6176 14.4251 22.694 14.4385C22.7703 14.4518 22.8486 14.45 22.9243 14.4331C22.9999 14.4162 23.0715 14.3846 23.135 14.34C23.1984 14.2954 23.2525 14.2388 23.294 14.1734C23.3356 14.1079 23.3638 14.0349 23.3772 13.9585C23.3905 13.8821 23.3887 13.8039 23.3718 13.7282C23.3549 13.6525 23.3233 13.5809 23.2787 13.5175L21.3862 10.825ZM17.6887 13.23H15.8637V8.62125C15.8567 8.46963 15.7916 8.32654 15.6818 8.22172C15.5721 8.11689 15.4261 8.0584 15.2743 8.0584C15.1226 8.0584 14.9766 8.11689 14.8669 8.22172C14.7571 8.32654 14.692 8.46963 14.685 8.62125V13.82C14.685 14.145 14.9475 14.41 15.2737 14.41H17.6887C17.8452 14.41 17.9953 14.3478 18.1059 14.2372C18.2166 14.1265 18.2787 13.9765 18.2787 13.82C18.2787 13.6635 18.2166 13.5135 18.1059 13.4028C17.9953 13.2922 17.8452 13.23 17.6887 13.23ZM10.3675 11.8662L11.2375 9.73125L12.035 11.865L10.3675 11.8662ZM13.5212 12.475L13.5237 12.455C13.5233 12.3064 13.4666 12.1635 13.365 12.055L12.0575 8.555C12.0027 8.38821 11.8983 8.24212 11.7582 8.13624C11.6182 8.03037 11.4491 7.96976 11.2737 7.9625C11.0972 7.96242 10.9247 8.01574 10.7791 8.11546C10.6334 8.21519 10.5213 8.35664 10.4575 8.52125L8.37997 13.615C8.32079 13.7599 8.32159 13.9223 8.38219 14.0666C8.44279 14.2109 8.55822 14.3252 8.7031 14.3844C8.84797 14.4436 9.01042 14.4428 9.1547 14.3822C9.29899 14.3216 9.41329 14.2061 9.47247 14.0613L9.88747 13.045H12.475L12.8475 14.045C12.8729 14.1197 12.913 14.1886 12.9656 14.2476C13.0181 14.3065 13.0819 14.3543 13.1532 14.3882C13.2245 14.422 13.3019 14.4412 13.3808 14.4446C13.4597 14.4479 13.5385 14.4355 13.6124 14.4078C13.6864 14.3802 13.754 14.3381 13.8114 14.2838C13.8688 14.2296 13.9147 14.1644 13.9464 14.0921C13.9781 14.0198 13.995 13.9418 13.996 13.8629C13.9971 13.784 13.9823 13.7056 13.9525 13.6325L13.5212 12.475ZM9.36747 8.6275C9.3678 8.55003 9.35281 8.47327 9.32335 8.40162C9.2939 8.32997 9.25056 8.26485 9.19584 8.21001C9.14112 8.15518 9.0761 8.11171 9.00451 8.0821C8.93292 8.05249 8.85619 8.03733 8.77872 8.0375H4.72247C4.56599 8.0375 4.41592 8.09966 4.30528 8.21031C4.19463 8.32095 4.13247 8.47102 4.13247 8.6275C4.13247 8.78398 4.19463 8.93405 4.30528 9.04469C4.41592 9.15534 4.56599 9.2175 4.72247 9.2175H6.17247V13.8875C6.17247 14.044 6.23463 14.194 6.34528 14.3047C6.45592 14.4153 6.60599 14.4775 6.76247 14.4775C6.91895 14.4775 7.06902 14.4153 7.17966 14.3047C7.29031 14.194 7.35247 14.044 7.35247 13.8875V9.2175H8.77747C8.85504 9.21783 8.93191 9.2028 9.00364 9.17326C9.07538 9.14373 9.14055 9.10028 9.1954 9.04543C9.25025 8.99058 9.2937 8.9254 9.32323 8.85367C9.35277 8.78194 9.3678 8.70507 9.36747 8.6275Z" fill="#0F0D0D"/>
                        </svg>
                        카카오로 회원가입
                    </a>
                    <div class="mt-5 mb-2 font-medium text-lg">일반회원가입</div>
                    <a href="javascript:openNormalLogin();" class="btn !h-14 btn-primary">회원가입</a>
                </div>
                <div class="form_box hidden">
                                <input type="hidden" value="" id="provider">
                    <div class="mb-3">
                        <dl>
                            <dt>이름</dt>
                            <dd>
                                <input type="text" class="input-form w-full" maxlength="30" placeholder="이름을 입력해주세요." id="name" onfocusout="isInOnlyAlphabetAndKorean(this)">
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-3">
                        <dl>
                            <dt>휴대폰번호</dt>
                            <dd>
                                <input type="text" class="input-form w-full" placeholder="휴대폰번호를 입력해주세요." id="phone_number" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^(\d{0,3})(\d{0,4})(\d{0,4})$/g, '$1-$2-$3').replace(/\-{1,2}$/g, '');">
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-3">
                        <dl>
                            <dt>아이디</dt>
                            <dd>
                                <input type="text" class="input-form w-full" placeholder="아이디를 입력해주세요." id="email">

                            </dd>
                        </dl>
                    </div>
                    <div class="mb-3">
                        <dl>
                            <dt>비밀번호</dt>
                            <dd>
                                <input type="password" class="input-form w-full" placeholder="비밀번호를 입력해주세요."  id="password">
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-3">
                        <dl>
                            <dt>비밀번호 확인</dt>
                            <dd>
                                <input type="password" class="input-form w-full" placeholder="비밀번호 확인을 입력해주세요."  id="password_chk">
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-3">
                        <dl>
                            <dt>명함 첨부</dt>
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
                                    <span>・jpg, png만 지원 합니다.</span>
                                    <br>
                                    <span style="font-size: bold; color: #ff0000;">・명함과 관련 없는 이미지를 첨부하신 경우, 회원가입이 승인되지 않습니다</span>
                                </div>
                            </dd>
                        </dl>
                    </div>

                    <div class="btn_box">
                        <button class="btn w-[300px] btn-primary" onclick="signup()">가입 완료</button>
                    </div>
                </div>
            </div>

        </div>
    </section>




</div>

<script>

var isMobile = {
    Android: function () {
        return navigator.userAgent.match(/Chrome/) == null ? false : true;
    },
    iOS: function () {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i) == null ? false : true;
    },
    any: function () {
        return (isMobile.Android() || isMobile.iOS());
    }
};

let duplicate_check = {
    email : false,
    phone_number : false
}

let signupType = 'normal';
let userData = null;
let sns = null;

document.getElementById('file').addEventListener('change', function (event) {
    alert('파일 선택됨:', event.target.files);
});


var userType = 'S';


document.addEventListener('DOMContentLoaded', function() {
    // sessionStorage에서 데이터 가져오기
    const socialUserData = sessionStorage.getItem('socialUserData');
    
	// naver 간편 로그인
	$("#naver").on('click', function (e) {
	     e.preventDefault();
	     openNaverLogin();
	});
	//google 간편 로그인
	$("#google").on('click', function (e) {
	     e.preventDefault();
	     openGoogleLogin();
	});
	
	//kakao 간편 로그인
	$("#kakao").on('click', function (e) {
	     e.preventDefault();
	     openKakaoLogin();
	});
	
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    
    // socialUserData 파라미터 가져오기
    const encodedData = urlParams.get('socialUserData');
    if(encodedData){
        
        try {
            // base64 디코딩 후 JSON 파싱
            const decodedString = atob(encodedData);
            let userData = JSON.parse(decodedString);
            
            signupType = 'social';
        
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
//                setReadonly('phone_number' , userData.phone_number.replace(/[^0-9]/g, '').replace(/^(\d{0,3})(\d{0,4})(\d{0,4})$/g, '$1-$2-$3').replace(/\-{1,2}$/g, '')) || '';
            }
            if (document.getElementById('provider')) {
                document.getElementById('provider').value = snsNaming(userData.provider) || '' ;
                sns = userData.provider;
            }
	    openNormalLogin();
           
        } catch (error) {
            signupType = 'normal';
            // $(".join_social").children().eq(1).trigger('click');
        }
    }else{
    
    
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
            }
            if (document.getElementById('provider')) {
                document.getElementById('provider').value = snsNaming(userData.provider) || '' ;
                sns = userData.provider;
            }
	        openNormalLogin()

            // sessionStorage.removeItem('socialUserData'); 
        }else{
            signupType = 'normal';
            $(".join_social").children().eq(0).removeClass('hidden');
            $(".join_social").children().eq(1).addClass('hidden');
            // $(".join_social").children().eq(1).trigger('click');
        }
    }
});
 function openNormalLogin(){
    // 일반 회원가입 탭 활성화
            $(".join_social").children().eq(0).addClass('hidden');
            $(".join_social").children().eq(1).removeClass('hidden');
	$(".join_social").children().eq(1).addClass('border-b border-primary').siblings().removeClass('border-b border-primary');
	$('.form_tab_content > div').eq(1).removeClass('hidden').siblings().addClass('hidden');
	signupType = 'normal';
 }
 
function setReadonly(key,value) {
   
    if(value){
        
        $(`#${key}`).val(value);
        $(`#${key}`).attr('readonly', true);
    }
  
}

function openNaverLogin() {
    // let naverLoginUrl = `{{ route('social.naver.login') }}`;
    // document.location = naverLoginUrl;
    snsAppLogin('naver');
    /*
    $.ajax({
        url: "{{ route('social.naver.login') }}",
        method: "GET",
        success: function (data) {
             document.location = data.url;
        },
        error: function () {
            alert('Failed to start Naver login process.');
        }
    });
    */
}
function openGoogleLogin() {
    snsAppLogin('google');
}
function openKakaoLogin() {
    snsAppLogin('kakao');
    /*
    $.ajax({
        url: "{{ route('social.kakao.login') }}",
        method: "GET",
        success: function (data) {
               document.location = data.url;
            // popup.window.focus();
        },
        error: function () {
            alert('Failed to start kakao login process.');
        }
    });
    */
}
function snsAppLogin(type) {
    const payload = JSON.stringify({
        type: "sns",
        snsType: type
    });
    
    if(isMobile.any() && !window.AppWebview && !(window.webkit && window.webkit.messageHandlers 
        && window.webkit.messageHandlers.AppWebview)) {
            
        alert('인앱에서만 SNS 로그인이 가능합니다.');
        return;
    }
    if(isMobile.Android()) {
        window.AppWebview.postMessage(payload);
    } else if (isMobile.iOS()) {
        window.webkit.messageHandlers.AppWebview.postMessage(payload);
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
    
    $('#modal-validation-alert').find('.modal_body').find('button').off().on('click', function(){
        modalClose('#modal-validation-alert');
    });
    let result = '';

    // if(type === 'email' && !email_check(param)){
    //     return '이메일 형식이 올바르지 않습니다.';

    // }

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
                    
                        alert("가입되었습니다.");
    
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
    
    if(validate()){

	$('#loadingContainer').show();
        let formData = new FormData();
	    
            // 데이터 추가
            formData.append('user_type', userType);
            formData.append('name', $('#name').val());
            formData.append('email', $('#email').val());
            formData.append('phone_number', $('#phone_number').val().replace(/-/g, ''));
            formData.append('password', $('#password').val());
	    
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
                    
                        alert("가입되었습니다.");
    
    
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
	
    if(signupType != 'normal'){
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
        $('#validation-ment').html('이메일을 입력해주세요.');
        modalOpen('#modal-validation'); 
       $(`#${type}email`).focus();
        return false;
    }else{
        $(`#${type}email`).removeClass('input-error');

    }

    if(type === ''){
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
	/*
    let phoneResult = duplicateCheck('phone_number',phone_number);
    if( phoneResult !='' ){
        $(`#${type}phone_number`).addClass('input-error');
        $(`#validation-ment`).html(phoneResult + '<br>추가로 회원가입을 진행하시겠습니까?');
        modalOpen('#modal-validation'); 
        $(`#${type}phone_number`).focus();
        return false;
    }else{  
        $(`#${type}phone_number`).removeClass('input-error');
    }
	*/
    if(checkedPhoneNumber != phone_number || !isCheckedDuplicatePhoneNumber) {
        let phoneResult = duplicateCheck('phone_number',phone_number);
        checkedPhoneNumber = phone_number; 
        if( phoneResult !='' ){
            $(`#${type}phone_number`).addClass('input-error');
            $(`#validation-ment2`).html(phoneResult + '<br>추가로 회원가입을 진행하시겠습니까?');
            modalOpen('#modal-validation-alert'); 
            $(`#${type}phone_number`).focus();
    	    $($('#modal-validation-alert').find('.modal_body').find('button')[0]).off().on('click', function(){
                modalClose('#modal-validation-alert'); 
                isCheckedDuplicatePhoneNumber = true; 
                signup();
            });
            return false;
        }else{  
            $(`#${type}phone_number`).removeClass('input-error');
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
    
    
    // else if(!email_check(email)){
    //     $(`#${type}email`).addClass('input-error');
    //     $('#validation-ment').html('이메일 형식이 올바르지 않습니다.');
    //     modalOpen('#modal-validation'); 
    //     $(`#${type}email`).focus();
    //     return false;
    // }   
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
	
	
    return true;
}
var isCheckedDuplicatePhoneNumber = false;
var checkedPhoneNumber = '';

     // 탭변경
	/*
     $('.join_social button').on('click',function(){
        let liN = $(this).index();
        $(this).addClass('border-b border-primary').siblings().removeClass('border-b border-primary');

        $('.form_tab_content > div').eq(liN).removeClass('hidden').siblings().addClass('hidden')
        if($(".join_social").children().eq(1).hasClass('border-b border-primary')){
            signupType = 'normal';
        }else{
            signupType = 'social';
        }
    })
    */


// 이미지 변경
const fileUpload = (input) => {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        let img = input.parentNode.querySelector('img');
        if(!img){
            img = document.createElement('img')
        }
        input.nextElementSibling.classList.add('hidden')

        reader.onload = function(e) {
            img.src = e.target.result
            input.parentNode.append(img)
        };
        reader.readAsDataURL(input.files[0]);
    } 
}

$(document).on('change', 'input[type="file"]', function() {
    fileUpload(this);
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
<div class="modal" id="modal-validation-alert">
    <div class="modal_bg" onclick="modalClose('#modal-validation-alert')"></div>
    <div class="modal_inner modal-sm">
        <button type="button" class="close_btn" onclick="modalClose('#modal-validation-alert')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body agree_modal_body">
            <p class="text-center py-4"><b id='validation-ment2'>이미 사용중인 이메일 입니다.<br>다시 확인해주세요.</b></p>
            <div class="flex gap-2 justify-center">
                <button type="button" class="btn btn-primary w-1/2 mt-5" onclick="modalClose('#modal-validation-alert');">확인</button>
                <button type="button" class="btn btn-black-line w-1/2 mt-5" onclick="modalClose('#modal-validation-alert');">취소</button>
            </div>
        </div>
    </div>
</div>

@endsection

