@extends('layouts.master')

@section('header')
    @include('layouts.header.signup-header')
@stop

@section('content')
    <div id="container" class="container" style="min-height:calc(100vh - 367px)">
        <div class="member">
            <div class="inner__large" style="min-height:calc(100vh - 367px)">
                <div class="resetting">
                    <h2 class="resetting__heading">비밀번호 재설정</h2>
                    <div class="notice-box">
                        <ul>
                            <li><div class="ico__info"><span class="a11y">정보 아이콘</span></div>대표 계정의 비밀번호만 재설정 가능합니다. 직원 계정의 비밀번호 재설정은 대표 계정 로그인 후, 마이페이지에서 재설정하실 수 있습니다.</li>
                        </ul>
                    </div>
                    <div class="content">
                        <div class="content__item">
                            <div class="content__title">회원 인증을 해주세요.</div>
                            <div class="form">
                                <form id="frm">
                                    <div class="form__list">
                                        <div class="form__label">
                                            <label class="label label--necessary" for="resetting_email">아이디</label>
                                        </div>
                                        <div class="input-guid" style="position: relative;">
                                            <input class="input input--necessary input-guid__input"
                                                   id="resetting_email"
                                                   name="resetting_email"
                                                   type="text"
                                                   required
                                                   placeholder="아이디를 입력해주세요."
                                                   style="margin-right: 6px;">
                                            <button class="button input-guid__button auth_code" onclick="checkBeforeAuthCode()" type="button" disabled style="position: absolute; top: 0; right: 0;">인증번호 전송</button>
                                            <!-- <button class="button input-guid__button" type="button">인증번호 재전송</button> -->
                                            <div class="form__notification send_authcode" style="display: none;"><div class="ico__form-check"><span class="a11y">확인 아이콘</span></div>인증번호가 전송되었습니다. 휴대폰을 확인해주세요.</div>
                                        </div>
                                    </div>
                                    <div class="form__list">
                                        <div class="form__label">
                                            <label class="label" for="accreditation">인증번호</label>
                                        </div>
                                        <div class="input-guid">
                                            <input class="input input-guid__input"
                                                   id="accreditation"
                                                   type="text"
                                                   disabled=""
                                                   placeholder=""
                                                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                            >
                                            <button class="button input-guid__button" id="accreditation_btn" disabled type="button" onclick="confirmAuthCode()">인증하기</button>
                                            <div class="form__notification pw_check_success" style="display: none;" data-confirm=false ><div class="ico__form-check"><span class="a11y">확인 아이콘</span></div>인증되었습니다.</div>
                                            <div class="form__notification pw_check_success error" style="display: none;">인증번호가일치하지않습니다.다시확인해주세요.</div>
                                        </div>
                                    </div>
                                    <div class="form__list">
                                        <div class="form__label">
                                            <label class="label label--necessary" for="resetting_newpw">새 비밀번호</label>
                                        </div>
                                        <div class="textfield">
                                            <input class="input input--necessary textfield__input textfield__input--gray"
                                                   id="resetting_newpw"
                                                   name="resetting_newpw"
                                                   type="password"
                                                   required
                                                   minlength="8"
                                                   placeholder="비밀번호를 입력해주세요."
                                            >
                                            <div class="form__notice-box">
                                                <ul>
                                                    <li>영문 및 숫자 혼합하여 8자리 이상 입력해주세요.</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form__list">
                                        <div class="form__label">
                                            <label class="label label--necessary" for="resetting_newpwcheck">새 비밀번호 확인</label>
                                        </div>
                                        <div class="textfield">
                                            <input class="input input--necessary textfield__input textfield__input--gray"
                                                   id="resetting_newpwcheck"
                                                   name="resetting_newpwcheck"
                                                   type="password"
                                                   required
                                                   minlength="8"
                                                   placeholder="비밀번호를 다시 입력해주세요." >
                                        </div>
                                    </div>
                                    <div class="button-wrap">
                                        <a href="#"
                                           class="button form__submit-button"
                                           onclick="resetPw()" >
                                            완료
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- 재설정 완료 팝업 -->
            <div id="LGI-05-modal1" class="modal">
                <div class="modal__container">
                    <div class="modal__content">
                        <div class="modal-box__container">
                            <div class="modal-box__content">
                                <div class="modal__desc">
                                    <p class="modal__text">
                                        비밀번호가 재설정 되었습니다.
                                        <br>로그인 해주세요.
                                    </p>
                                </div>
                                <div class="modal__buttons">
                                    <a href="{{route('signin.social')}}" class="modal__button"><span>확인</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- 인증번호 오류 안내 팝업 -->
            <div id="LGI-05-modal2" class="modal">
                <div class="modal__container">
                    <div class="modal__content">
                        <div class="modal-box__container">
                            <div class="modal-box__content">
                                <div class="modal__desc">
                                    <p class="modal__text">
                                        인증 번호 전송 횟수 5회가 초과했습니다. <br>
                                        내일 다시 시도해주세요.
                                    </p>
                                </div>
                                <div class="modal__buttons">
                                    <button type="button" onclick="closeModal('#LGI-05-modal2')" class="modal__button"><span>확인</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- 필수항목 체크 팝업 -->
            <div id="LGI-05-modal3" class="modal">
                <div class="modal__container">
                    <div class="modal__content">
                        <div class="modal-box__container">
                            <div class="modal-box__content">
                                <div class="modal__desc">
                                    <p class="modal__text">
                                        필수 항목이 입력되지 않았습니다.
                                        <br>다시 확인해주세요.
                                    </p>
                                </div>
                                <div class="modal__buttons">
                                    <a href="#" onclick="closeModal('#LGI-05-modal3');return false;" class="modal__button"><span>확인</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- 이메일 오류 팝업 -->
            <div id="LGI-05-modal4" class="modal">
                <div class="modal__container">
                    <div class="modal__content">
                        <div class="modal-box__container">
                            <div class="modal-box__content">
                                <div class="modal__desc">
                                    <p class="modal__text">
                                        일치하는 이메일이 없습니다.
                                        <br>다시 확인해주세요.
                                    </p>
                                </div>
                                <div class="modal__buttons">
                                    <a href="#" onclick="closeModal('#LGI-05-modal4');return false;" class="modal__button"><span>확인</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

        </div>
    </div>
@endsection

@section('script')
    <script defer src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js?autoload=false"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" ></script>
    <script defer src="/js/validate/messages_ko.min.js" ></script>

    <script>
        let base = '[aria-hidden="false"] ';

        $(document).ready(function() {
            $('body').on('keyup', '#resetting_email', function () {
                if ($(this).val() != '') {
                    $('button.auth_code').attr('disabled', false);

                    return;
                }

                $('button.auth_code').attr('disabled', true);
            })

            $.validator.addMethod('eng_number', function( value ) {
                return /[a-z]/.test(value) && /[0-9]/.test(value)
            });

            $('#frm').validate({
                rules: {
                    resetting_email: {required:true},
                    resetting_newpw: {required:true, eng_number:true, minlength:8},
                    resetting_newpwcheck: {required:true, equalTo: "#resetting_newpw"},
                },
                messages: {
                    resetting_email: {
                        required: "아이디를 입력해주세요",
                    },
                    resetting_newpw: {
                        required: "비밀번호를 입력해주세요",
                        eng_number: "비밀번호는 영문 및 숫자 혼합하여 8자리 이상 입력해주세요",
                        minlength: "비밀번호는 영문 및 숫자 혼합하여 8자리 이상 입력해주세요"
                    },
                    resetting_newpwcheck: {
                        required: "비밀번호확인을 입력해주세요",
                        minlength: "비밀번호와 일치하지 않습니다",
                        equalTo: "비밀번호와 일치하지 않습니다",
                    },
                },
                submitHandler: function () {
                    if ($('.form__notification.pw_check_success').data('confirm')) {
                        var form = new FormData();
                        form.append('account', $('#resetting_email').val());
                        form.append('repw', $('#resetting_newpw').val());
                        form.append('code', $('#accreditation').val());

                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url				: '/passwordRequest',
                            enctype         : 'multipart/form-data',
                            processData     : false,
                            contentType     : false,
                            data			: form,
                            type			: 'POST',
                            success		: function(result) {
                                
                                console.log('result', result);
                                
                                if (result.success) {
                                    openModal('#LGI-05-modal1')
                                } else {
                                }
                            }
                        });
                    } else {

                    }
                }
            });
        });


        // 인증번호 5회 초과 체크용
        function checkAuthCodeCnt() {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url				: '/authCodeCount',
                data			: {
                    'account'  : $('#resetting_email').val()
                },
                type			: 'POST',
                dataType		: 'json',
                success		: function(result) {
                    if (result.success) {
                        authCode();
                    } else {
                        openModal('#LGI-05-modal2');
                    }
                }
            });
        }
        
        
        // 사용중 이메일 체크
        function checkBeforeAuthCode() {
            
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url	: '/member/checkUsingEmail',
                data : {
                    'email': $('#resetting_email').val()
                },
                type: 'POST',
                dataType: 'json',
                success: function(result) {
                    if (result == 0) {
                        openModal('#LGI-05-modal4');
                    } else {
                        checkAuthCodeCnt();
                    }
                }
                
            });
            
        }
        
        
        

        // 인증번호 발송
        function authCode() {
            var data = new Object() ;
            data.target = $('#resetting_email').val();
            data.type = "S" ;

            $.ajax({
                url				: '/signup/sendAuthCode',
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                data			: data,
                type			: 'POST',
                dataType		: 'json',
                xhrFields: {
                    withCredentials: false
                },
                success		: function(result) {
                    if (result.success) {
                        $('.form__notification.send_authcode').css('display', 'block');
                        $('.auth_code').text('인증번호 재전송');
                        $('#accreditation, #accreditation_btn').attr('disabled', false);
                    } else {
                        alert(result.message);
                    }
                }
            });
        }

        // 인증번호 확인
        function confirmAuthCode() {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url				: '/signup/confirmAuthCode',
                data			: {
                    'type'    : 'E',
                    'target'  : $('#resetting_email').val(),
                    'code'    : $('#accreditation').val()
                },
                type			: 'POST',
                dataType		: 'json',
                success		: function(result) {
                    if (result.success) {
                        $('.form__notification.pw_check_success').css('display', 'block');
                        $('.form__notification.pw_check_success').data('confirm', true);
                        $('#resetting_email, button.auth_code, #accreditation, #accreditation_btn').attr('disabled', true);
                        $('.form__notification.pw_check_success.error').css('display', 'none');


                    } else {
                        $('.form__notification.pw_check_success').css('display', 'none');
                        $('.form__notification.pw_check_success.error').css('display', 'block');
                    }
                }
            });
        }

        // 비번 변경
        function resetPw() {
            $('#frm').submit();

            if ($('#resetting_email, #resetting_newpw, #resetting_newpwcheck').val() == '') {
                openModal('#LGI-05-modal3');
            }
        }

        function closeModalWithFocus(name)
        {
            closeModal(name);
            $(base + ' #useremail').focus();
        }
    </script>
@endsection


