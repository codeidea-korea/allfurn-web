@extends('layouts.app')

@section('content')

<div class="join_header sticky top-0 h-16 bg-white flex items-center">
    <div class="inner">
        <a class="inline-flex" href="/"><img class="logo" src="/img/logo.svg" alt=""></a>
    </div>
</div>

<div id="content">
    <section class="join_common flex items-center">
        <div class="join_inner">
            <div class="title">
                <h3>아이디 찾기</h3>
            </div>

            <div class="form_box">
                <div class="mb-8">
                    <dl class="flex">
                        <dt class="necessary"><label for="cellphone">전화번호</label></dt>
                        <dd class="flex gap-1">
                            <input type="text" id="cellphone" class="input-form w-full" value="01015357894" maxLength="13" placeholder="전화번호를 입력해주세요">
                            <button id="btnSendSMS" class="btn btn-primary-line" disabled>인증번호 받기</button>
                        </dd>
                    </dl>
                </div>
                <div class="mb-8" id="smscodeDiv" style='display:none;'>
                    <dl class="flex">
                        <dt class="necessary"><label for="smscode">인증번호</label></dt>
                        <dd class="flex gap-1">
                            <div class="certify_box">
                                <input type="text" id="smscode" class="input-form w-full" maxlength="6" placeholder="인증번호 6자리">
                                <span class="time">03:00</span>
                            </div>
                            <button id="btnResendSMS" class="btn btn-line">재발송</button>
                        </dd>
                    </dl>
                    <button id="btn_smscode_confirm" class="btn w-full btn-primary" disabled onclick="confirmAuthCode()">인증완료</button>
                </div>
                <h4 class="_step2" style='display:none;'>가입된 아이디</h4>
                <div class="info_box _step2" style='display:none;'>
                    비밀번호를 분실하셨다면 아이디 선택 후 비밀번호 재설정을 클릭해주세요
                </div>

                <ul class="joined_id mt-2 _step2" style='display:none;'>
                    <li>
                        <input type="radio" name="joined_id" id="joined_id_1" class="radio-form">
                        <label for="joined_id_1">deee123</label>
                    </li>
                    <li>
                        <input type="radio" name="joined_id" id="joined_id_2" class="radio-form">
                        <label for="joined_id_2">deee123</label>
                    </li>
                </ul>

                <div class="info_box mb-4">
                    서비스 이용 및 회원가입 문의는 '서비스 이용문의(cs@all-furn.com)' 또는 031-813-5588로 문의 해주세요.
                </div>
            </div>


            <button class="btn w-full btn-primary" disabled>인증완료</button>
            <div class="btn_box flex gap-2 mt-2.5">
                <a href="/findpw" class="btn w-full btn-line2">비밀번호 재설정</a>
                <a href="/signin" class="btn w-full btn-primary">로그인 하러가기</a>
            </div>
           
        </div>
    </section>
</div>

<script src="/js/jquery-1.12.4.js?20240329113305"></script>
<script>

$( document ).ready( function() {

    $('._step2').hide();
    $('.tab_layout li').on('click',function(){
        let liN = $(this).index();
        $(this).addClass('active').siblings().removeClass('active')
        $('.tab_content > div').eq(liN).addClass('active').siblings().removeClass('active')
    })
    $("#cellphone").on("keyup", function () {
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
        if ($(this).val().length >= 10) {
            $("#btnSendSMS").prop("disabled", false);
        } else {
            $("#btnSendSMS").prop("disabled", true);
            $('._step2').hide();
        }
    });

    $("#btnSendSMS, #btnResendSMS").on("click", function () {
        var data = new Object() ;
        data.target = $('#cellphone').val().replace(/-/g, '');
        data.type = "S" ;
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
                    $('._step2').hide();
                    $('#smscode').val('');
                    $('.time').text('2:59');
                    $('#cellphone').prop("disabled", true);
                    $('#btnSendSMS').prop("disabled", true);
                    $('#smscode').prop("disabled", false);
                    
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

    $("#smscode").on("input", function () {
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
        if ($(this).val().length >= 6) {
            $("#btn_smscode_confirm").prop("disabled", false);
        } else {
            $("#btn_smscode_confirm").prop("disabled", true);
            $('._step2').hide();
        }
    });

    $("#btn_smscode_confirm").on("click", function () {
        if ($('.time').text() == '0:00'){
            modalOpen('#smscode_time_over');
        }
    });
});

function gotoFindpw() {
    const joined_id = $('input[name=joined_id]:checked').val();
    window.location.href = '/findpw?id=' + (joined_id ? joined_id : '');
}
function confirmAuthCode() {
    if ($('.time').text() == '0:00'){
        modalOpen('#smscode_time_over');
    } else {
        var data = new Object() ;
        data.target = $('#cellphone').val().replace(/-/g, '');
        data.type = "S" ;
        data.code = $('#smscode').val();
        $('.joined_id').html('');
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
                    $('._step2').show();
                    isAuthCodeCheckAfter = true;
                    $('#cellphone').prop("disabled", true);
                    $('#btnSendSMS').prop("disabled", true);
                    $('#btnResendSMS').prop("disabled", true);
                    $("#btn_smscode_confirm").hide();
                    
                    let tmpHtml = '';

                    for(var idx=0; idx<result.users.length; idx++) {
                        
                        tmpHtml += '<li>'
                                +'    <input type="radio" name="joined_id" id="joined_id_'+idx+'" class="radio-form">'
                                +'    <label for="joined_id_'+idx+'">'+result.users[idx].account+'</label>'
                                +'</li>';
                    }
                    $('.joined_id').html(tmpHtml);
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
            clearInterval(timerInterval);
        }
    }, 1000);
}
</script>

@endsection
