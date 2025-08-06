@extends('layouts.app_m')

@php

$header_depth = 'login';
$only_quick = 'yes';
$top_title = '';
$header_banner = '';

@endphp

@section('content')


@if (  !empty(Auth::user()) && !empty(Auth::user()['account']) )
<script>
if('{{ $replaceUrl ?? "" }}' != '') {
    location.href = '{{ $replaceUrl ?? "" }}';
} else {
    setTimeout(() => {
        $('#content').show();
    }, 100);
}
</script>
@else

<script type="text/javascript">
    // 인앱 로그인인지 여부
    
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

    try{
        if(isMobile.any() && !window.AppWebview && '{{ $replaceUrl ?? "" }}' != '') {
            setTimeout(() => {
                location.href = '/?isweb=Y&replaceUrl={{ $replaceUrl ?? "" }}';
            }, 300);
        }
    } catch (e){
        console.log(e)
    }
    
    const accessToken = localStorage.getItem('accessToken');
    if(accessToken && accessToken.length > 1) {
        const callTime = new Date().getTime();
        $.ajax({
    //        headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
            url: '/tokenpass-signin',
            data: {
                'accessToken': accessToken
            },
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                if (result.success) {
                    if(location.pathname.indexOf('/signin') > -1) {
                        if('{{ $replaceUrl ?? "" }}' != '') {
                            location.href = '{{ $replaceUrl ?? "" }}';
                        }
                    } else {
                        localStorage.clear();
                        location.reload();
                    }
                } else {
                    localStorage.clear();
                    location.href = '/signin';
                }
            }
        });
    }
    </script>

@endif

<div id="content" style="display:none;">
    <section class="login_common flex items-center justify-center">
        <div class="login_inner">
            <img class="logo" src="./img/logo.svg" alt="">

            <div class="tab_layout type03 mb-5">
                <ul>
                    <li class="active"><a href="javascript:;">아이디로 로그인</a></li>
                    <li><a href="javascript:;">전화번호로 로그인</a></li>
                </ul>
            </div>

            <div class="tab_content">
                <!-- 아이디로 로그인 -->
                <div class="active">
                <div style="
                    color: var(--main_color) !important;
                    text-align: center;
                    padding-top: 0.5rem;
                ">
                    아이디를 잊으셨다면 전화번호로 로그인하세요!
                </div>
                    <form id="idlogin" method="POST" action="/check-user">
                    @csrf
                    <input type="hidden" name="after_url" value='{{ $replaceUrl ?? "" }}'>
                    <label for="LGI-01_loginId">아이디</label>
                    <input type="text" id="LGI-01_loginId" name="account" class="login_input input-form w-full" required autocomplete="email" autofocus placeholder="아이디를 입력해주세요.">
                    <label for="LGI-01_loginPassWord">비밀번호</label>
                    <input type="password" id="LGI-01_loginPassWord" name="secret" class="login_input input-form w-full" required autocomplete="current-password" placeholder="비밀번호를 입력해주세요.">
                    <ul class="info_box">
                        <li>서비스 이용 및 회원가입 문의는 '서비스 이용문의(cs@all-furn.com)' 또는 031-813-5588로 문의 해주세요.</li>
                    </ul>

{{-- <a href="{{ route('signUp') }}" class="btn w-full mt-2.5 btn-line2" style="    border-color: var(--main_color) !important;    color: var(--main_color) !important; margin-bottom: 0.625rem">올펀 가입하기</a> --}}

                    <button type="submit" id="LGI-01_loginBtn" class="btn w-full btn-primary" disabled>로그인하기</button>
                    </form>
                </div>

                <!-- 전화번호로 로그인 -->
                <div>
                    <label for="cellphone">전화번호</label>
                    <div class="flex gap-2 mt-1.5 mb-4">
                        <input type="text" id="cellphone" class="input-form w-full" placeholder="전화번호를 입력해주세요">
                        <button id="btnSendSMS" class="btn btn-primary-line" disabled type="button">인증번호 받기</button>
                    </div>

                    <div id="smscodeDiv" style='display:none;'>
                        <label for="smscode">인증번호</label>
                        <div class="flex gap-2 mt-1.5 mb-4">
                            <div class="certify_box">
                                <input type="text" id="smscode" maxLength="6" class="input-form w-full" placeholder="인증번호 6자리">
                                <span class="time">2:59</span>
                            </div>
                            <button id="btnResendSMS" class="btn btn-line" type="button">재발송</button>
                        </div>
                    </div>

                    <ul class="joined_id _step2" style='display:none;'>
                        <li>
                            <input type="radio" name="joined_id" id="joined_id_1" class="radio-form">
                            <label for="joined_id_1">deee123</label>
                        </li>
                        <li>
                            <input type="radio" name="joined_id" id="joined_id_2" class="radio-form">
                            <label for="joined_id_2">deee123</label>
                        </li>
                    </ul>

                    <ul class="info_box">
                        <li>서비스 이용 및 회원가입 문의는 '서비스 이용문의(cs@all-furn.com)' 또는 031-813-5588로 문의 해주세요.</li>
                    </ul>

                    <button id="btn_smscode_confirm" class="btn w-full btn-primary" onclick="confirmAuthCode()" disabled type="button">인증완료</button>
                    {{-- <a href="{{ route('signUp') }}" class="btn w-full mt-2.5 btn-line2" style="    border-color: var(--main_color) !important;    color: var(--main_color) !important; margin-bottom: 0.625rem">올펀 가입하기</a> --}}

                    <button id="btn_selected_id_login" class="btn w-full btn-primary mt-2.5" style="display:none;" type="button" onclick="signin()">선택한 아이디로 로그인</button>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 mt-3">
                <a id="naver" href="#" class="btn btn-line2 gap-2" style="border:1px solid #6dc66e; color:#6dc66e;">
                    <svg width="15" height="15" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_333_231)"><path d="M13.5608 10.7042L6.14667 0H0V20H6.43833V9.29667L13.8533 20H20V0H13.5608V10.7042Z" fill="#6DC66E"/></g><defs><clipPath id="clip0_333_231"><rect width="20" height="20" fill="white"/></clipPath></defs></svg>
                    네이버 로그인
                </a>
                <a id="google" href="#" class="btn btn-line2 gap-2" style="border:1px solid #aa4c4c; color:#aa4c4c;">
                    <svg width="25" height="25" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.5 15C7.4982 16.7706 8.12287 18.4847 9.26342 19.8389C10.404 21.1932 11.9869 22.1003 13.732 22.3996C15.477 22.699 17.2718 22.3713 18.7984 21.4746C20.3251 20.5779 21.4854 19.1699 22.0738 17.5H15V12.5H27.2563V17.5H27.25C26.0913 23.205 21.0475 27.5 15 27.5C8.09625 27.5 2.5 21.9038 2.5 15C2.5 8.09625 8.09625 2.5 15 2.5C17.0431 2.49855 19.0554 2.99844 20.8604 3.95583C22.6653 4.91323 24.2078 6.29888 25.3525 7.99125L21.255 10.86C20.3655 9.51552 19.0665 8.49342 17.5504 7.94521C16.0344 7.397 14.3821 7.35186 12.8384 7.81648C11.2947 8.2811 9.94184 9.23076 8.98026 10.5247C8.01869 11.8186 7.49962 13.3879 7.5 15Z" fill="#AD2222"/></svg>
                    구글 로그인
                </a>
                <a id="kakao" href="#"  class="btn btn-line2 gap-2" style="border:1px solid #fac813; color:#fac813;">
                    <svg width="25" height="25" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 3.75C22.25 3.75 28.1262 8.33 28.1262 13.9813C28.1262 19.6313 22.25 24.2113 15.0012 24.2113C14.2795 24.21 13.5585 24.1641 12.8425 24.0738L7.33247 27.6775C6.70622 28.0088 6.48497 27.9725 6.74247 27.1613L7.85747 22.5638C4.25747 20.7388 1.87622 17.5763 1.87622 13.9813C1.87622 8.33125 7.75122 3.75 15.0012 3.75M22.3862 13.825L24.2237 12.045C24.3297 11.9349 24.3889 11.7879 24.3887 11.6351C24.3885 11.4822 24.329 11.3354 24.2227 11.2255C24.1164 11.1157 23.9717 11.0513 23.8189 11.0461C23.6661 11.0409 23.5173 11.0952 23.4037 11.1975L20.9937 13.53V11.6025C20.9937 11.446 20.9316 11.296 20.8209 11.1853C20.7103 11.0747 20.5602 11.0125 20.4037 11.0125C20.2472 11.0125 20.0972 11.0747 19.9865 11.1853C19.8759 11.296 19.8137 11.446 19.8137 11.6025V14.7987C19.7929 14.8901 19.7929 14.9849 19.8137 15.0763V16.875C19.8137 17.0315 19.8759 17.1815 19.9865 17.2922C20.0972 17.4028 20.2472 17.465 20.4037 17.465C20.5602 17.465 20.7103 17.4028 20.8209 17.2922C20.9316 17.1815 20.9937 17.0315 20.9937 16.875V15.1713L21.5275 14.655L23.3125 17.1962C23.357 17.2597 23.4137 17.3137 23.4791 17.3553C23.5446 17.3969 23.6176 17.4251 23.694 17.4385C23.7703 17.4518 23.8486 17.45 23.9243 17.4331C23.9999 17.4162 24.0715 17.3846 24.135 17.34C24.1984 17.2954 24.2525 17.2388 24.294 17.1734C24.3356 17.1079 24.3638 17.0349 24.3772 16.9585C24.3905 16.8821 24.3887 16.8039 24.3718 16.7282C24.3549 16.6525 24.3233 16.5809 24.2787 16.5175L22.3862 13.825ZM18.6887 16.23H16.8637V11.6213C16.8567 11.4696 16.7916 11.3265 16.6818 11.2217C16.5721 11.1169 16.4261 11.0584 16.2743 11.0584C16.1226 11.0584 15.9766 11.1169 15.8669 11.2217C15.7571 11.3265 15.692 11.4696 15.685 11.6213V16.82C15.685 17.145 15.9475 17.41 16.2737 17.41H18.6887C18.8452 17.41 18.9953 17.3478 19.1059 17.2372C19.2166 17.1265 19.2787 16.9765 19.2787 16.82C19.2787 16.6635 19.2166 16.5135 19.1059 16.4028C18.9953 16.2922 18.8452 16.23 18.6887 16.23ZM11.3675 14.8662L12.2375 12.7313L13.035 14.865L11.3675 14.8662ZM14.5212 15.475L14.5237 15.455C14.5233 15.3064 14.4666 15.1635 14.365 15.055L13.0575 11.555C13.0027 11.3882 12.8983 11.2421 12.7582 11.1362C12.6182 11.0304 12.4491 10.9698 12.2737 10.9625C12.0972 10.9624 11.9247 11.0157 11.7791 11.1155C11.6334 11.2152 11.5213 11.3566 11.4575 11.5212L9.37997 16.615C9.32079 16.7599 9.32159 16.9223 9.38219 17.0666C9.44279 17.2109 9.55822 17.3252 9.7031 17.3844C9.84797 17.4436 10.0104 17.4428 10.1547 17.3822C10.299 17.3216 10.4133 17.2061 10.4725 17.0613L10.8875 16.045H13.475L13.8475 17.045C13.8729 17.1197 13.913 17.1886 13.9656 17.2476C14.0181 17.3065 14.0819 17.3543 14.1532 17.3882C14.2245 17.422 14.3019 17.4412 14.3808 17.4446C14.4597 17.4479 14.5385 17.4355 14.6124 17.4078C14.6864 17.3802 14.754 17.3381 14.8114 17.2838C14.8688 17.2296 14.9147 17.1644 14.9464 17.0921C14.9781 17.0198 14.995 16.9418 14.996 16.8629C14.9971 16.784 14.9823 16.7056 14.9525 16.6325L14.5212 15.475ZM10.3675 11.6275C10.3678 11.55 10.3528 11.4733 10.3234 11.4016C10.2939 11.33 10.2506 11.2648 10.1958 11.21C10.1411 11.1552 10.0761 11.1117 10.0045 11.0821C9.93292 11.0525 9.85619 11.0373 9.77872 11.0375H5.72247C5.56599 11.0375 5.41592 11.0997 5.30528 11.2103C5.19463 11.321 5.13247 11.471 5.13247 11.6275C5.13247 11.784 5.19463 11.934 5.30528 12.0447C5.41592 12.1553 5.56599 12.2175 5.72247 12.2175H7.17247V16.8875C7.17247 17.044 7.23463 17.194 7.34528 17.3047C7.45592 17.4153 7.60599 17.4775 7.76247 17.4775C7.91895 17.4775 8.06902 17.4153 8.17966 17.3047C8.29031 17.194 8.35247 17.044 8.35247 16.8875V12.2175H9.77747C9.85504 12.2178 9.93191 12.2028 10.0036 12.1733C10.0754 12.1437 10.1405 12.1003 10.1954 12.0454C10.2503 11.9906 10.2937 11.9254 10.3232 11.8537C10.3528 11.7819 10.3678 11.7051 10.3675 11.6275Z" fill="#FAC813"/></svg>
                    카카오 로그인
                </a>
                <a id="apple" class="btn btn-line2 gap-2" style="border:1px solid #2a2a2a; color:#2a2a2a;">
                    <svg width="25" height="25" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21.3125 25.35C20.0875 26.5375 18.75 26.35 17.4625 25.7875C16.1 25.2125 14.85 25.1875 13.4125 25.7875C11.6125 26.5625 10.6625 26.3375 9.58746 25.35C3.48746 19.0625 4.38746 9.4875 11.3125 9.1375C13 9.225 14.175 10.0625 15.1625 10.1375C16.6375 9.8375 18.05 8.975 19.625 9.0875C21.5125 9.2375 22.9375 9.9875 23.875 11.3375C19.975 13.675 20.9 18.8125 24.475 20.25C23.7625 22.125 22.8375 23.9875 21.3 25.3625L21.3125 25.35ZM15.0375 9.0625C14.85 6.275 17.1125 3.975 19.7125 3.75C20.075 6.975 16.7875 9.375 15.0375 9.0625Z" fill="black"/></svg>
                    애플 로그인
                </a>
            </div>

            <a a href="{{ route('signup.new') }}" class="btn w-full mt-6 btn-primary-line gap-2" style="height:auto; padding:8px 0; font-size:16px; ">
                <svg width="20" height="36" viewBox="0 0 42 46" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M27.3333 25.1667C30.096 25.1667 32.7455 26.2641 34.699 28.2176C36.6525 30.1711 37.75 32.8207 37.75 35.5833V37.6667C37.75 38.7717 37.311 39.8315 36.5296 40.6129C35.7482 41.3943 34.6884 41.8333 33.5833 41.8333H4.41667C3.3116 41.8333 2.25179 41.3943 1.47039 40.6129C0.688987 39.8315 0.25 38.7717 0.25 37.6667V35.5833C0.25 32.8207 1.34747 30.1711 3.30097 28.2176C5.25448 26.2641 7.904 25.1667 10.6667 25.1667H27.3333ZM35.6667 12.6667C36.2192 12.6667 36.7491 12.8862 37.1398 13.2769C37.5305 13.6676 37.75 14.1975 37.75 14.75V16.8333H39.8333C40.3859 16.8333 40.9158 17.0528 41.3065 17.4435C41.6972 17.8342 41.9167 18.3641 41.9167 18.9167C41.9167 19.4692 41.6972 19.9991 41.3065 20.3898C40.9158 20.7805 40.3859 21 39.8333 21H37.75V23.0833C37.75 23.6359 37.5305 24.1658 37.1398 24.5565C36.7491 24.9472 36.2192 25.1667 35.6667 25.1667C35.1141 25.1667 34.5842 24.9472 34.1935 24.5565C33.8028 24.1658 33.5833 23.6359 33.5833 23.0833V21H31.5C30.9475 21 30.4176 20.7805 30.0269 20.3898C29.6362 19.9991 29.4167 19.4692 29.4167 18.9167C29.4167 18.3641 29.6362 17.8342 30.0269 17.4435C30.4176 17.0528 30.9475 16.8333 31.5 16.8333H33.5833V14.75C33.5833 14.1975 33.8028 13.6676 34.1935 13.2769C34.5842 12.8862 35.1141 12.6667 35.6667 12.6667ZM19 0.166656C21.7627 0.166656 24.4122 1.26412 26.3657 3.21763C28.3192 5.17113 29.4167 7.82065 29.4167 10.5833C29.4167 13.346 28.3192 15.9955 26.3657 17.949C24.4122 19.9025 21.7627 21 19 21C16.2373 21 13.5878 19.9025 11.6343 17.949C9.6808 15.9955 8.58333 13.346 8.58333 10.5833C8.58333 7.82065 9.6808 5.17113 11.6343 3.21763C13.5878 1.26412 16.2373 0.166656 19 0.166656Z" fill="#FB4760"/></svg>
                회원가입 하기
            </a>
            <div class="link_box flex items-center justify-center">
                <a href="/findid">아이디 찾기</a>
                <a href="/findpw">비밀번호 재설정</a>
                <a href="mailto:cs@all-furn.com">서비스 이용 문의</a>
            </div>
        </div>
    </section>
</div>


<div class="modal" id="login_confirm-modal">
    <div class="modal_bg" onclick="modalClose('#login_confirm-modal')"></div>
    <div class="modal_inner">
        <button class="close_btn" onclick="modalClose('#login_confirm-modal')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body agree_modal_body">
            <p class="text-center py-4"><b>필수 항목이 선택되지 않았습니다.<br/> 다시 확인해주세요</b></p>
            <div class="flex gap-2 justify-center">
                <button class="btn btn-primary w-1/2 mt-5" onclick="modalClose('#login_confirm-modal')">확인</button>
            </div>
            <div class="flex gap-2 justify-center">
                <button class="btn w-full btn-primary-line mt-5" onclick="modalClose('#login_confirm-modal')">취소</button>
                <button class="btn w-full btn-primary mt-5" onclick="modalClose('#login_confirm-modal')">확인</button>
            </div>
        </div>
    </div>
</div>

<script>
$('.tab_layout li').on('click',function(){
    let liN = $(this).index();
    $(this).addClass('active').siblings().removeClass('active')
    $('.tab_content > div').eq(liN).addClass('active').siblings().removeClass('active')
})

$( document ).ready( function() {
    $('input').keyup( function() {
        var id = $( '#LGI-01_loginId' ).val();
        var pw = $( '#LGI-01_loginPassWord' ).val();

        if (id != "" && pw != "") {
            $('#LGI-01_loginBtn').removeAttr("disabled");
        } else {
            $('#LGI-01_loginBtn').attr("disabled", true);
        }
    });

    $("#cellphone").on("keyup", function () {
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
        if ($(this).val().length >= 10) {
            $("#btnSendSMS").prop("disabled", false);
        } else {
            $("#btnSendSMS").prop("disabled", true);
        }
    });

    $("#btnSendSMS, #btnResendSMS").on("click", function () {
        var data = new Object() ;
        data.target = $('#cellphone').val().replace(/-/g, '');
        data.type = "A" ;
        $.ajax({
            url				: '/signup/sendAuthCode',
            contentType     : "application/x-www-form-urlencoded; charset=UTF-8",
            data			: data,
            type			: 'POST',
            dataType		: 'json',
            xhrFields: {
                withCredentials: false
            },
            success : function(result) {
                if (result.success) {
                    $('#smscodeDiv').show();
                    $('#smscode').val('');
                    $('.time').text('2:59');
                    
                    // $(base + ' .form__list.' + type + '_auth').css('display','flex');
                    // $(base + ' .input-guid__input.'+type+', [aria-hidden="false"] .input-guid__button.'+type).removeAttr('disabled');
                    // $(base + ' .form__notification.'+type+'_auth').css('display','none');
                    // $(base + ' .get_code-'+type).text('인증번호 재전송');

                    startTimer();
                } else {
                    alert(result.message);
                }
            }
        });
    });

    $("#smscode").on("keyup", function () {
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
        if ($(this).val().length >= 6) {
            $("#btn_smscode_confirm").prop("disabled", false);
        } else {
            $("#btn_smscode_confirm").prop("disabled", true);
        }
    });
    $("#smscode").on("input", function () {
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
        if ($(this).val().length >= 6) {
            $("#btn_smscode_confirm").prop("disabled", false);
        } else {
            $("#btn_smscode_confirm").prop("disabled", true);
        }
    });

});

function signin() {
    const joined_id = $('input[name=joined_id]:checked').val();

    if(joined_id == '') {
        return;
    }

    var data = new Object() ;
    data.phonenumber = $('#cellphone').val().replace(/-/g, '');
    data.joinedid = joined_id;
    data.code = 'SE';
    const after_url = $('input[name=after_url]').val();

    $.ajax({
        url				: '/signup/signinAuthCode',
        contentType     : "application/x-www-form-urlencoded; charset=UTF-8",
        data			: data,
        type			: 'POST',
        dataType		: 'json',
        xhrFields: {
            withCredentials: false
        },
        success : function(result) {
            if (result.success) {
                if(after_url == '') {
                    window.location.href = '/';
                }else {
                    window.location.href = decodeURI(after_url);
                }
            } else {
                alert(result.message);
            }
        }
    });
}

function confirmAuthCode() {
        if ($('.time').text() == '0:00'){
            modalOpen('#smscode_time_over');
        } else {
            var data = new Object() ;
            data.target = $('#cellphone').val().replace(/-/g, '');
            data.type = "A" ;
        $('.joined_id').html('');
            data.code = $('#smscode').val();

            $.ajax({
                url				: '/signup/confirmAuthCode',
                contentType     : "application/x-www-form-urlencoded; charset=UTF-8",
                data			: data,
                type			: 'POST',
                dataType		: 'json',
                xhrFields: {
                    withCredentials: false
                },
                success : function(result) {
                    if (result.success) {
                    
                        if(result.users.length > 0) {
                            location.replace('/signin/choose-ids?cellphone='+data.target);
                        } else {
                            alert('먼저 가입하여 주세요.');
                        }
                    } else {
                        time = 1;
                        alert(result.message);
                    }
                }
            });
        }
    }
var time = 179; 
function startTimer() {
    time = 179; 
    var timerInterval = setInterval(function () {
        var minutes = Math.floor(time / 60);
        var seconds = time % 60;
        $(".time").text(minutes + ":" + (seconds < 10 ? "0" : "") + seconds);
        time--;
        if (time < 0) {
            clearInterval(timerInterval);
        }
    }, 1000);
}

// naver 간편 로그인
$("#naver").on('click', function (e) {
     e.preventDefault();
     openNaverLogin();
});

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

//google 간편 로그인
$("#google").on('click', function (e) {
     e.preventDefault();
     openGoogleLogin();
});

function openGoogleLogin() {
    snsAppLogin('google');
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

//kakao 간편 로그인
$("#kakao").on('click', function (e) {
     e.preventDefault();
     openKakaoLogin();
});
$("#apple").on('click', function (e) {
     e.preventDefault();
     snsAppLogin('apple');
});

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

</script>

@error('not_match')
<div class="modal" id="login_not_match">
    <div class="modal_bg" onclick="modalClose('#login_not_match')"></div>
    <div class="modal_inner modal-sm">
        <button class="close_btn" onclick="modalClose('#login_not_match')" type="button"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body agree_modal_body">
            <p class="text-center py-4"><b>아이디 패스워드가 일치하지 않습니다.<br>다시 확인해주세요.</b></p>
            <div class="flex gap-2 justify-center">
                <button class="btn btn-primary w-1/2 mt-5" onclick="modalClose('#login_not_match')" type="button">확인</button>
            </div>
        </div>
    </div>
</div>
<script>modalOpen('#login_not_match')</script>
@enderror

@error('not_approve')
<div class="modal" id="login_not_approve">
    <div class="modal_bg" onclick="modalClose('#login_not_approve')"></div>
    <div class="modal_inner modal-sm">
        <button class="close_btn" onclick="modalClose('#login_not_approve')" type="button"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body agree_modal_body">
            <p class="text-center py-4"><b>가입 승인 후 로그인해주세요.<br>가입 승인 결과는 문자로 전송됩니다.</b></p>
            <div class="flex gap-2 justify-center">
                <button class="btn btn-primary w-1/2 mt-5" onclick="modalClose('#login_not_approve');location.href='/';" type="button">확인</button>
            </div>
        </div>
    </div>
</div>
<script>modalOpen('#login_not_approve')</script>
@enderror

@error('need_terms')
<div class="modal" id="login_need_terms">
    <div class="modal_bg" onclick="modalClose('#login_need_terms')"></div>
    <div class="modal_inner modal-sm">
        <button class="close_btn" onclick="modalClose('#login_need_terms')" type="button"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body agree_modal_body">
            <p class="text-center py-4"><b>약관 동의 화면으로 이동합니다.<br>
                관리자가 계정을 생성한 경우,<br>
                최초 로그인 시 약관 동의가 필요합니다.</b></p>
            <div class="flex gap-2 justify-center">
                <button class="btn btn-primary w-1/2 mt-5" onclick="modalClose('#login_need_terms');location.href = '/terms?idx=@error('need_terms'){{$message}}@enderror'" type="button">확인</button>
            </div>
        </div>
    </div>
</div>
<script>modalOpen('#login_need_terms')</script>
@enderror

@error('error_custom')
<div class="modal" id="login_error_custom">
    <div class="modal_bg" onclick="modalClose('#login_error_custom')"></div>
    <div class="modal_inner modal-sm">
        <button class="close_btn" onclick="modalClose('#login_error_custom')" type="button"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body agree_modal_body">
            <p class="text-center py-4"><b>잠시후 다시 이용해주세요.<br>{{ $message }}</b></p>
            <div class="flex gap-2 justify-center">
                <button class="btn btn-primary w-1/2 mt-5" onclick="modalClose('#login_error_custom');location.href='/';" type="button">확인</button>
            </div>
        </div>
    </div>
</div>
<script>modalOpen('#login_error_custom')</script>
@enderror

@error('success')
<div class="modal" id="login_success">
    <div class="modal_bg" onclick="modalClose('#login_success')"></div>
    <div class="modal_inner modal-sm">
        <button class="close_btn" onclick="modalClose('#login_success')" type="button"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body agree_modal_body">
            <p class="text-center py-4"><b>로그인 완료</b></p>
            <div class="flex gap-2 justify-center">
                <button class="btn btn-primary w-1/2 mt-5" onclick="modalClose('#login_success');location.href='/';" type="button">확인</button>
            </div>
        </div>
    </div>
</div>
<script>modalOpen('#login_success')</script>
@enderror

@error('withdrawal')
<div class="modal" id="login_withdrawal">
    <div class="modal_bg" onclick="modalClose('#login_withdrawal')"></div>
    <div class="modal_inner modal-sm">
        <button class="close_btn" onclick="modalClose('#login_withdrawal')" type="button"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body agree_modal_body">
            <p class="text-center py-4"><b>탈퇴 처리된 계정입니다.<br>재가입은 탈퇴일 기점으로 1개월 이후 신규 가입이 가능합니다.</b></p>
            <div class="flex gap-2 justify-center">
                <button class="btn btn-primary w-1/2 mt-5" onclick="modalClose('#login_withdrawal')" type="button">확인</button>
            </div>
        </div>
    </div>
</div>
<script>modalOpen('#login_withdrawal')</script>
@enderror

@error('empty-phone')
<div class="modal" id="login_empty_phone">
    <div class="modal_bg" onclick="modalClose('#login_empty_phone')"></div>
    <div class="modal_inner modal-sm">
        <button class="close_btn" onclick="modalClose('#login_empty_phone')" type="button"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body agree_modal_body">
            <p class="text-center py-4"><b>SNS 계정에 전화번호 등록을 해주세요.</b></p>
            <div class="flex gap-2 justify-center">
                <button class="btn btn-primary w-1/2 mt-5" onclick="modalClose('#login_empty_phone')" type="button">확인</button>
            </div>
        </div>
    </div>
</div>
<script>modalOpen('#login_empty_phone')</script>
@enderror

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
