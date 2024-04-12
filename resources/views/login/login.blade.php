@extends('layouts.app')

@section('content')

<div id="content">
    <section class="login_common flex items-center">
        <div class="login_inner">
            <img class="logo" src="/img/logo.svg" alt="">

            <div class="tab_layout type03 mb-5">
                <ul>
                    <li class="active"><a href="javascript:;">아이디로 로그인</a></li>
                    <li><a href="javascript:;">전화번호로 로그인</a></li>
                </ul>
            </div>

            <div class="tab_content">
                <!-- 아이디로 로그인 -->
                <div class="active">
                    <form id="idlogin" method="POST" action="/check-user">
                    @csrf
                    <label for="LGI-01_loginId">아이디</label>
                    <input type="text" id="LGI-01_loginId" name="account" class="login_input input-form w-full" required autocomplete="email" autofocus placeholder="아이디를 입력해주세요.">
                    <label for="LGI-01_loginPassWord">비밀번호</label>
                    <input type="password" id="LGI-01_loginPassWord" name="secret" class="login_input input-form w-full" required autocomplete="current-password" placeholder="비밀번호를 입력해주세요.">
                    <ul class="info_box">
                        <li>서비스 이용 및 회원가입 문의는 '서비스 이용문의(cs@all-furn.com)' 또는 031-813-5588로 문의 해주세요.</li>
                    </ul>
                    <button type="submit" id="LGI-01_loginBtn" class="btn w-full btn-primary" disabled>로그인하기</button>
                    </form>
                </div>
                <!-- 아이디로 로그인 -->

                <!-- 전화번호로 로그인 -->
                <div class="">
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
                    <button id="btn_selected_id_login" class="btn w-full btn-primary mt-2.5" style="display:none;" type="button" onclick="signin()">선택한 아이디로 로그인</button>
                </div>
                <!-- 전화번호로 로그인 -->
            </div>

            <a href="{{ route('signUp') }}" class="btn w-full mt-2.5 btn-line2">올펀 가입하기</a>

            <div class="link_box flex items-center justify-center">
                <a href="/findid">아이디 찾기</a>
                <a href="/findpw">비밀번호 재설정</a>
                <a href="javascript:;">서비스 이용 문의</a>
            </div>
        </div>
    </section>
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

    $("#btn_smscode_confirm").on("click", function () {
        if ($('.time').text() == '0:00'){
            modalOpen('#smscode_time_over');
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
                window.location.href = '/';
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
                    
                        let tmpHtml = '';

                        for(var idx=0; idx<result.users.length; idx++) {
                            
                            tmpHtml += '<li>'
                                    +'    <input type="radio" name="joined_id" id="joined_id_'+idx+'" value="'+result.users[idx].account+'" class="radio-form">'
                                    +'    <label for="joined_id_'+idx+'">'+result.users[idx].account+'</label>'
                                    +'</li>';
                        }
                        $('.joined_id').html(tmpHtml);
                    $('._step2').show();$('#btn_smscode_confirm').hide();
                        $('#btn_selected_id_login').show();
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
