@extends('layouts.app')

@section('content')

<div class="join_header sticky top-0 h-16 bg-white flex items-center">
    <div class="inner">
        <a class="inline-flex" href="/"><img class="logo" src="/img/logo.svg" alt=""></a>
    </div>
</div>

<div id="content">
    <section class="join_common">
        <form id="frm">
            <div class="join_inner">
                <div class="title">
                    <h3>비밀번호 재설정</h3>
                    <div class="info">
                        <div class="flex items-center gap-1">
                            <img class="w-4" src="/img/member/info_icon.svg" alt="">
                            <p>대표 계정의 비밀번호만 재설정 가능합니다. 직원 계정의 비밀번호 재설정은 대표 계정 로그인 후, 마이페이지에서 재설정하실 수 있습니다.</p>
                        </div>
                    </div>
                </div>
                <div class="form_box">
                    <h4>회원 인증을 해주세요</h4>
                    <div class="mb-8">
                        <dl class="flex">
                            <dt class="necessary"><label for="userid">아이디</label></dt>
                            <dd class="flex gap-1">
                                <input type="text" id="userid" class="input-form w-full" required autofocus placeholder="아이디를 입력해주세요.">
                                <button type="button" class="btn btn-black-line" id="btnSendSMS" disabled>인증번호 전송</button>
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-8 _step1">
                        <dl class="flex">
                            <dt><label for="num">인증번호</label></dt>
                            <dd class="flex gap-1 login_common" style="min-height:0;">
                                <div class="flex-1 certify_box">
                                    <input type="text" id="smscode" maxlength="6" class="input-form w-full" disabled>
                                    <span class="time">2:59</span>
                                </div>
                                <button type="button" id="btnResendSMS" class="btn btn-line" type="button" disabled>재발송</button>
                                <button type="button" id="btn_smscode_confirm" class="btn btn-black-line" disabled onclick="confirmAuthCode()">인증하기</button>
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-8 _step2">
                        <dl class="flex">
                            <dt class="necessary"><label for="w_userpw">새 비밀번호</label></dt>
                            <dd>
                                <input type="password" id="w_userpw" name="w_userpw" class="input-form w-full" required autocomplete="current-password" placeholder="비밀번호를 입력해주세요.">
                                <!-- 입력안했을때 input에 input-error 클래스추가 -->
                                <!--<label for="w_userpw" class="error">비밀번호확인을 입력해주세요</label>-->
                                <div class="info_box mt-2.5">
                                    •영문 및 숫자 혼합하여 8자리 이상 입력해주세요.
                                </div>
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-8 _step2">
                        <dl class="flex">
                            <dt class="necessary"><label for="r_userpw">새 비밀번호 확인</label></dt>
                            <dd>
                                <input type="password" id="r_userpw" name="r_userpw" class="input-form w-full" required autocomplete="current-password" placeholder="비밀번호를 다시 입력해주세요.">
                                <!-- 입력안했을때 input에 input-error 클래스추가 -->
                                <!--<label for="r_userpw" class="error">비밀번호확인을 입력해주세요</label>-->
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="btn_box _step2">
                    <button class="btn w-[300px] btn-primary" type="button" onclick="updatePassword()">완료</button>
                </div>


            </div>
        </form>
    </section>
</div>

<script src="/js/jquery-1.12.4.js?20240329113305"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.0/jquery.validate.min.js" ></script>
<script>

$( document ).ready( function() {
    $('._step1').hide();
    $('._step2').hide();

    $("#userid").on("keyup", function () {
        if ($(this).val().length >= 1) {
            $("#btnSendSMS").prop("disabled", false);
        } else {
            $("#btnSendSMS").prop("disabled", true);
        }
    });

    $("#smscode").on("keyup", function () {
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
        if ($(this).val().length >= 6) {
            $("#btn_smscode_confirm").prop("disabled", false);
        } else {
            $("#btn_smscode_confirm").prop("disabled", true);
        }
    });

    $("#btn_smscode_confirm").on("click", function () {
        if ($('.time').text() == '0:00'){
            modalOpen('#smscode_time_over');
        }
    });

    $("#btnSendSMS, #btnResendSMS").on("click", function () {
        var data = new Object() ;
        data.userid = $('#userid').val();
        data.type = 'S';

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
                    $('._step1').show();
                    $('._step2').hide();
                    $('#smscode').val('');
                    $('.time').text('2:59');
                    $('#cellphone').prop("disabled", true);
                    $('#btnSendSMS').prop("disabled", true);
                    $('#smscode').prop("disabled", false);
                    $('#userid').prop("disabled", true);
                    
                    startTimer();
                } else {
                    alert(result.message);
                }
            }
        });
    });



    
    $('#frm').validate({
        rules: {
            w_userpw: {required:true, eng_number:true, minlength:8 },
            r_userpw: {required:true, minlength:8, equalTo:"#w_userpw"}
        },
        messages: {
            w_userpw: {
                required: "비밀번호는 입력해주세요",
                eng_number: "비밀번호는 영문 및 숫자 혼합하여 8자리 이상 입력해주세요",
                minlength: "비밀번호는 영문 및 숫자 혼합하여 8자리 이상 입력해주세요",
            },
            r_userpw: {
                required: "비밀번호확인을 입력해주세요",
                minlength: "비밀번호와 일치하지 않습니다",
                equalTo: "비밀번호와 일치하지 않습니다",
            }
        }
    });

});

$.validator.addMethod('eng_number', function( value ) {
    return /[a-z]/.test(value) && /[0-9]/.test(value)
});
function updatePassword(){
    var data = new Object() ;
    data.userid = $('#userid').val();
    data.userpw = $('#w_userpw').val();
    data.new_userpw = $('#new_userpw').val();
    data.smscode = $('#smscode').val();

    if(!$('#frm').valid()){
        return;
    }

    $.ajax({
        url				: '/signup/update-password',
        contentType     : "application/x-www-form-urlencoded; charset=UTF-8",
        data			: data,
        type			: 'POST',
        dataType		: 'json',
        xhrFields: {
            withCredentials: false
        },
        success : function(result) {
            if (result.success) {
                alert('비밀번호 변경에 성공하였습니다.');
                window.location.replace('/signin');
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
        data.userid = $('#userid').val().replace(/-/g, '');
        data.type = "S" ;
        data.code = $('#smscode').val();
        $('#smscode').prop("disabled", true);

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
                    time = 1;
                    $('._step1').hide();
                    $('._step2').show();
                    isAuthCodeCheckAfter = true;
                    $('#userid').prop("disabled", true);
                    $('#cellphone').prop("disabled", true);
                    $('#btnSendSMS').prop("disabled", true);
                    $('#btnResendSMS').prop("disabled", true);
                    $("#btn_smscode_confirm").hide();
                } else {
                    isAuthCodeCheckAfter = true;
                    $('#btnResendSMS').prop("disabled", false);
                    $('#smscode').prop("disabled", false);
                    alert('인증번호가 맞지 않습니다.');
                }
            }
        });
    }
}
var isAuthCodeCheckAfter = false;
function startTimer() {
    var time = 179; 
    var timerInterval = setInterval(function () {
        var minutes = Math.floor(time / 60);
        var seconds = time % 60;
        $(".time").text(minutes + ":" + (seconds < 10 ? "0" : "") + seconds);
        time--;
        if (time < 0 || isAuthCodeCheckAfter) {
    $('#btnResendSMS').prop("disabled", false);
            clearInterval(timerInterval);
        }
    }, 1000);
}

</script>


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
