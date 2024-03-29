@extends('layouts.app')

@section('content')


<div id="content">
    <section class="login_common flex items-center">
        <div class="login_inner">
            <div class="title">
                <h3>아이디 찾기</h3>
            </div>

            <label for="phone">전화번호</label>
            <div class="flex gap-2 mt-1.5 mb-4">
                <input type="text" id="cellphone" class="input-form w-full" placeholder="전화번호를 입력해주세요">
                <button id="btnSendSMS" class="btn btn-primary-line" disabled >인증번호 받기</button>
            </div>

            <div id="smscodeDiv" style='display:none;'>
                <label for="smscode">인증번호</label>
                <div class="flex gap-2 mt-1.5 mb-4">
                    <div class="certify_box">
                        <input type="text" id="smscode" class="input-form w-full" placeholder="인증번호 6자리">
                        <span class="time">03:00</span>
                    </div>
                    <button id="btnResendSMS" class="btn btn-line">재발송</button>
                </div>
            </div>

            <div class="title _step2" style='display:none;'>
                <h3>가입된 아이디</h3>
                <p>비밀번호를 분실하셨다면 아이디 선택 후 비밀번호 재설정을 클릭해주세요</p>
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

            <button id="btn_smscode_confirm" class="btn w-full btn-primary" disabled onclick="confirmAuthCode()">인증완료</button>
            <div class="btn_box flex gap-2 mt-2.5">
                <a href="javascript:;" onclick="gotoFindpw()" class="btn w-full btn-line2">비밀번호 재설정</a>
                <a href="/signin" class="btn w-full btn-primary">로그인 하러가기</a>
            </div>
           
            <a href="/signup" class="btn w-full mt-2.5 btn-line2">올펀 가입하기</a>

            <div class="link_box flex items-center justify-center">
                <a href="/findid.php">아이디 찾기</a>
                <a href="/findpw.php">비밀번호 재설정</a>
                <a href="javascript:;">서비스 이용 문의</a>
            </div>
        </div>
    </section>
</div>

<script>
    $('._step2').hide();
    $('.tab_layout li').on('click',function(){
        let liN = $(this).index();
        $(this).addClass('active').siblings().removeClass('active')
        $('.tab_content > div').eq(liN).addClass('active').siblings().removeClass('active')
    })

    
$( document ).ready( function() {

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
                const joined_id = $('input[name=joined_id]').val();
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
                        
                        let tmpHtml = '';
                        for(var idx=0; idx<result.users.length; idx++) {
                            
                            tmpHtml += '<li>'
                                    +'    <input type="radio" name="joined_id" id="joined_id_'+idx+'" class="radio-form">'
                                    +'    <label for="joined_id_'+idx+'">'+result.users[idx].account+'</label>'
                                    +'</li>';
                        }
                        $('.joined_id').html(tmpHtml);
                    } else {
                        time = 1;
                        alert(result.message);
                    }
                }
            });
        }
    }
function startTimer() {
    var time = 179; 
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
</script>
