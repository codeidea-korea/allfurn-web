@extends('layouts.app_m')

@php

$header_depth = 'login';
$only_quick = 'yes';
$top_title = '';
$header_banner = '';

@endphp

@section('content')

<div class="join_header sticky top-0 bg-white flex items-center">
    <div class="inner">
        <a class="back_img" href="/login.php"><svg><use xlink:href="/img/icon-defs.svg#left_arrow"></use></svg></a>
        <h3>비밀번호 재설정</h3>
    </div>
</div>

<div id="content">
    <section class="join_common">
        <div class="join_inner">
            <div class="form_box">
                <h4>회원 인증을 해주세요</h4>
                <div class="title">
                    <div class="info">
                        <div class="flex items-start gap-1">
                            <img class="w-4 mt-0.5" src="/img/member/info_icon.svg" alt="">
                            <p>대표 계정의 비밀번호만 재설정 가능합니다. 직원 계정의 비밀번호 재설정은 대표 계정 로그인 후, 마이페이지에서 재설정하실 수 있습니다.</p>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <dl>
                        <dt class="necessary"><label for="userid">아이디</label></dt>
                        <dd class="flex gap-1">
                            <input type="text" id="userid" class="input-form w-full" required autocomplete="email" autofocus placeholder="아이디를 입력해주세요.">
                            <button class="btn btn-black-line" id="btnSendSMS" disabled>인증번호 전송</button>
                        </dd>
                    </dl>
                </div>
                <!--
                <div class="mb-3">
                    <dl>
                        <dt class="necessary"><label for="id">아이디</label></dt>
                        <dd class="flex  gap-1">
                            <div class="flex-1">
                                <input type="text" id="id" class="input-form w-full input-error" placeholder="아이디를 입력해주세요.">
                                <label for="" class="error">아이디를 입력해주세요</label>
                            </div>
                            <button class="btn btn-black-line" disabled>인증번호 전송</button>
                        </dd>
                    </dl>
                </div>
-->
                <div class="mb-3 _step1">
                    <dl>
                        <dt><label for="num">인증번호</label></dt>
                        <dd class="flex gap-1">
                            <div class="flex-1">
                                <input type="text" id="smscode" class="input-form w-full" disabled>
                                <span class="time">2:59</span>
                            </div>
                            <button id="btnResendSMS" class="btn btn-line" type="button" disabled>재발송</button>
                            <button id="btn_smscode_confirm" class="btn btn-black-line" disabled onclick="confirmAuthCode()">인증하기</button>
                        </dd>
                    </dl>
                </div>

                <div class="mb-3 _step2">
                    <dl>
                        <dt class="necessary"><label for="w_userpw">새 비밀번호</label></dt>
                        <dd>
                            <input type="text" id="w_userpw" class="input-form w-full" required autocomplete="current-password" placeholder="비밀번호를 입력해주세요.">
                            <!-- 입력안했을때 input에 input-error 클래스추가 -->
                            <!--<label for="w_userpw" class="error">비밀번호확인을 입력해주세요</label>-->
                            <div class="info_box mt-2.5">
                                •영문 및 숫자 혼합하여 8자리 이상 입력해주세요.
                            </div>
                        </dd>
                    </dl>
                </div>
                <div class="mb-3 _step2">
                    <dl>
                        <dt class="necessary"><label for="r_userpw">새 비밀번호 확인</label></dt>
                        <dd>
                            <input type="text" id="r_userpw" class="input-form w-full" required autocomplete="current-password" placeholder="비밀번호를 다시 입력해주세요.">
                            <!-- 입력안했을때 input에 input-error 클래스추가 -->
                            <!--<label for="r_userpw" class="error">비밀번호확인을 입력해주세요</label>-->
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="btn_box _step2">
                <button class="btn btn-primary" onclick="updatePassword()">완료</button>
            </div>



        </div>
    </section>
</div>

<script>
    $('._step1').hide();
    $('._step2').hide();

    $( document ).ready( function() {
    
        $("#btnSendSMS, #btnResendSMS").on("click", function () {
            var data = new Object() ;
            data.userid = $('#userid').val();

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
                        
                        startTimer();
                    } else {
                        alert(result.message);
                    }
                }
            });
        });



        
        $('#frm').validate({
            rules: {
                userpw: {required:true, eng_number:true, minlength:8},
                w_userpwcheck: {required:true, minlength:8, equalTo:"#w_userpw"},
                r_userpwcheck: {required:true, minlength:8, equalTo:"#r_userpw"},
                userpwcheck: {required:true, minlength:8, equalTo:base +" #userpw"},
            },
            messages: {
                userpw: {
                    required: "비밀번호는 입력해주세요",
                    eng_number: "비밀번호는 영문 및 숫자 혼합하여 8자리 이상 입력해주세요",
                    minlength: "비밀번호는 영문 및 숫자 혼합하여 8자리 이상 입력해주세요",
                },
                userpwcheck: {
                    required: "비밀번호확인을 입력해주세요",
                    minlength: "비밀번호와 일치하지 않습니다",
                    equalTo: "비밀번호와 일치하지 않습니다",
                },
                w_userpwcheck: {
                    required: "비밀번호확인을 입력해주세요",
                    minlength: "비밀번호와 일치하지 않습니다",
                    equalTo: "비밀번호와 일치하지 않습니다",
                },
                r_userpwcheck: {
                    required: "비밀번호확인을 입력해주세요",
                    minlength: "비밀번호와 일치하지 않습니다",
                    equalTo: "비밀번호와 일치하지 않습니다",
                }
            }
        });
    });

    function updatePassword(){
            var data = new Object() ;
            data.userid = $('#userid').val();
            data.userpw = $('#w_userpw').val();
            data.new_userpw = $('#new_userpw').val();
            data.smscode = $('#smscode').val();

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
