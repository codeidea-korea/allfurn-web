@extends('layouts.master')

@section('content')
    <div id="container" class="container" style="min-height:calc(100vh - 367px)">
        <div class="member">
            <div class="inner__center" style="min-height:calc(100vh - 367px)">
                <div class="register-complete">
                    <div class="register-complete__heading">올펀 회원 가입 신청이 완료되었습니다.</div>
                    <div class="register-complete__notice">
                        <div class="ico__email"><div class="a11y">이메일 아이콘</div></div>
                        <p>가입 승인 결과는 <strong>영업일 기준 1일 내 문자로 전송</strong>됩니다.
                            <br>가입 시 입력한 이메일로 로그인해주세요.
                        </p>
                    </div>
                    <div class="register-info">
                        <p class="register-info__title">올펀 서비스 이용 절차</p>
                        <div class="register-info__desc">회원가입 <span>→</span> 가입 승인 <span>→</span> 로그인 <span>→</span> 올펀 서비스 이용</div>
                    </div>
                    <div class="button-wrap">
                        <input type="button"
                               class="button form__submit-button"
                               value="All FURN 홈으로 가기"
                               onclick="location.href='/'" >
                    </div>

                </div>
            </div>
        </div>

        <!-- 가입완료 팝업 -->
        <div id="LGI-04-modal1" class="modal">
            <div class="modal__container">
                <div class="modal__content">
                    <div class="modal-box__container">
                        <div class="modal-box__content">
                            <div class="modal__desc">
                                <p class="modal__text">
                                    가입이 완료되었습니다.<br>
                                    홈으로 이동합니다.
                                </p>
                            </div>
                            <div class="modal__buttons">
                                <a onclick="closeModal('#LGI-04-modal1')" class="modal__button" >
                                    <span>확인</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    @include('layouts.footer.main-footer')
@stop

@section('script')
    <script>
        $(document).ready(function () {
            actvTabList('register-type', 99)
        });

        $(".radio-tab .chkbox__checked").on("click", function () {
            if ($('.chkbox__checked01').is(":checked") === true ) {
                $('.location--type01').css("display", "block");
                $('.location--type02').css("display", "none");
                $
            }
            if ($('.chkbox__checked02').is(":checked") === true) {
                $('.location--type02').css("display", "block");
                $('.location--type01').css("display", "none");
            }
        });
    </script>
@stop
