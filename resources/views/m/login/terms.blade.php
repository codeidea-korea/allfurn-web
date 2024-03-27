@extends('layouts.master')

@section('header')
    @include('layouts.header.signup-header')
@stop

@section('content')
    <div id="container" class="container" style="min-height:calc(100vh - 367px)">
        <div class="member">
            <div class="inner__large" style="min-height:calc(100vh - 367px)">
                <div class="agreement">
                    <h2 class="agreement__heading">약관 동의</h2>
                    <div class="notice-box">
                        <ul>
                            <li><div class="ico__info"><span class="a11y">정보 아이콘</span></div>관리자가 생성한 계정으로 최초 로그인한 경우 약관에 동의가 필요합니다.</li>
                        </ul>
                    </div>
                    <div class="content">
                        <form method="POST" action="{{ route('saveTerms') }}">
                            @csrf
                            <div class="content__item">
                                <div class="form__check-box">
                                    <div class="form__title">올펀 약관에 동의해주세요.</div>
                                    <input type="hidden" name="idx" value="{{$_GET['idx']}}">
                                    <div class="check-box">
                                        <div class="check-box__list check-box__list--checkall">
                                            <div class="check-box__label check-box__label--checkall">
                                                <label for="LGI-02-1-agreement__00" class="category__check">
                                                    <input class="checkbox__input checkbox__input--checkall"
                                                           id="LGI-02-1-agreement__00"
                                                           type="checkbox"
                                                    >
                                                    <span>필수 약관 전체 동의</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="check-box__list">
                                            <div class="check-box__label">
                                                <label for="LGI-02-1-agreement__01" class="category__check">
                                                    <input class="checkbox__input checkbox__input--necessary"
                                                           id="LGI-02-1-agreement__01"
                                                           name="agreementServicePolicy"
                                                           type="checkbox"
                                                    >
                                                    <span>서비스 이용 약관 동의 (필수)</span>
                                                </label>
                                            </div>
                                            <button class="button check-box__button" type="button" onclick="openModal('#reg-agrmnt_service')">상세 보기</button>
                                        </div>
                                        <div class="check-box__list">
                                            <div class="check-box__label">
                                                <label for="LGI-02-1-agreement__02" class="category__check">
                                                    <input class="checkbox__input checkbox__input--necessary"
                                                           id="LGI-02-1-agreement__02"
                                                           name="agreementPrivacy"
                                                           type="checkbox"
                                                    >
                                                    <span>개인정보 활용 동의 (필수)</span>
                                                </label>
                                            </div>
                                            <button class="button check-box__button" type="button" onclick="openModal('#reg-agrmnt_privacy-info')">상세 보기</button>
                                        </div>
                                        <div class="check-box__list">
                                            <div class="check-box__label">
                                                <label for="LGI-02-1-agreement__03" class="category__check">
                                                    <input class="checkbox__input"
                                                           id="LGI-02-1-agreement__03"
                                                           name="agreementMarketing"
                                                           type="checkbox"
                                                    >
                                                    <span>마케팅 정보 활용 동의 (선택)</span>
                                                </label>
                                            </div>
                                            <button class="button check-box__button" type="button" onclick="openModal('#reg-agrmnt_marketing-info')">상세 보기</button>
                                        </div>
                                        <div class="check-box__list">
                                            <div class="check-box__label">
                                                <label for="LGI-02-1-agreement__04" class="category__check">
                                                    <input class="checkbox__input"
                                                           id="LGI-02-1-agreement__04"
                                                           name="agreementAd"
                                                           type="checkbox"
                                                    >
                                                    <span>광고성 이용 동의 (선택)</span>
                                                </label>
                                            </div>
                                            <button class="button check-box__button" type="button" onclick="openModal('#reg-agrmnt_promo')">상세 보기</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="button-wrap">
                                    <button type="submit" id="LGI-02-1-register__form-submit" class="button button--solid" onclick="save()" disabled>가입 완료</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

            <!-- 가입완료 팝업 -->
            <div id="LGI-06-modal1" class="modal">
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
                                    <a href="/" class="modal__button" >
                                        <span>확인</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div id="reg-agrmnt_service" class="modal">
            <div class="modal__container">
                <div class="modal__content">
                    <div class="modal-box__container" style="width: 566px">
                        <div class="modal-box__content">
                            <div class="header">
                                <p>서비스 이용 약관</p>
                            </div>
                            <div class="content">
                                <div style="height: 523px; background-color: #D9D9D9;">
                                    서비스 이용 약관 <br>약관 내용
                                </div>
                            </div>
                            <div class="footer" style="height: 42px"></div>
                            <div class="modal-close" onclick="closeModal('#reg-agrmnt_service')">
                                <button type="button" class="modal__close-button"><span class="a11y">닫기</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="reg-agrmnt_privacy-info" class="modal">
            <div class="modal__container">
                <div class="modal__content">
                    <div class="modal-box__container" style="width: 566px">
                        <div class="modal-box__content">
                            <div class="header">
                                <p>개인정보 활용 동의</p>
                            </div>
                            <div class="content">
                                <div style="height: 523px; background-color: #D9D9D9;">
                                    개인정보 활용 동의 <br>약관 내용
                                </div>
                            </div>
                            <div class="footer" style="height: 42px"></div>
                            <div class="modal-close" onclick="closeModal('#reg-agrmnt_privacy-info')">
                                <button type="button" class="modal__close-button"><span class="a11y">닫기</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="reg-agrmnt_marketing-info" class="modal">
            <div class="modal__container">
                <div class="modal__content">
                    <div class="modal-box__container" style="width: 566px">
                        <div class="modal-box__content">
                            <div class="header">
                                <p>마케팅 정보 활용 동의</p>
                            </div>
                            <div class="content">
                                <div style="height: 523px; background-color: #D9D9D9;">
                                    마케팅 정보 활용 동의 <br>약관 내용
                                </div>
                            </div>
                            <div class="footer" style="height: 42px"></div>
                            <div class="modal-close" onclick="closeModal('#reg-agrmnt_marketing-info')">
                                <button type="button" class="modal__close-button"><span class="a11y">닫기</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="reg-agrmnt_promo" class="modal">
            <div class="modal__container">
                <div class="modal__content">
                    <div class="modal-box__container" style="width: 566px">
                        <div class="modal-box__content">
                            <div class="header">
                                <p>광고성 이용 동의</p>
                            </div>
                            <div class="content">
                                <div style="height: 523px; background-color: #D9D9D9;">
                                    광고성 이용 동의 <br>약관 내용
                                </div>
                            </div>
                            <div class="footer" style="height: 42px"></div>
                            <div class="modal-close" onclick="closeModal('#reg-agrmnt_promo')">
                                <button type="button" class="modal__close-button"><span class="a11y">닫기</span></button>
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
        $(document).ready(function() {
            //set initial state.
            $('.checkbox__input').prop("checked", false);

            $('.checkbox__input').not('.checkbox__input--checkall').change(function() {
                $(this).val($(this).is(':checked'));

                if (!$(this).is(':checked')) {
                    $('#LGI-02-1-agreement__00').prop("checked", $(this).is(':checked'));

                } else {
                    let obj = $('.checkbox__input').not('.checkbox__input--checkall');
                    let checked = 0;
                    for (i = 0; i < obj.length; i++) {
                        if (obj[i].checked === true) {
                            checked += 1;
                        }
                    }

                    if (checked == 4) {
                        $('#LGI-02-1-agreement__00').prop("checked", $(this).is(':checked'));
                    }
                }
                    checkBtnState();
            });

            $('#LGI-02-1-agreement__00').click(function() {
                $('.checkbox__input').prop("checked", $(this).is(':checked'));
                $('.checkbox__input').val($(this).is(':checked'));

                checkBtnState();
            });
        });

        function checkBtnState() {
            if ($('#LGI-02-1-agreement__01').is(':checked') && $('#LGI-02-1-agreement__02').is(':checked')) {
                $('#LGI-02-1-register__form-submit').removeAttr("disabled");
            } else {
                $('#LGI-02-1-register__form-submit').attr("disabled", true);
            }
        }
    </script>
@stop
