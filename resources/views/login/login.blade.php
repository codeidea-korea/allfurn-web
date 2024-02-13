@extends('layouts.master')

@section('content')
    <div id="container" class="container" style="min-height:calc(100vh - 287px)">
        <div class="member">
            <div class="inner__center" style="min-height:calc(100vh - 287px)">
                <div class="login">
                    <h1 class="head__logo head__logo--large"><span class="a11y">All FURN</span></h1>
                    <form method="POST" action="/check-user">
                        @csrf
                        <div class="login__inner">
                            <label class="textfield__inputlabel" for="LGI-01_loginId">아이디</label>
                            <input type="text" id="LGI-01_loginId" name="account" class="textfield__input textfield__input--gray @error('account') is-invalid @enderror" value="{{request()->input('account')}}" required autocomplete="email" autofocus
                                   placeholder="아이디를 입력해주세요." />
                            {{--                            @error('email')--}}
                            {{--                            <span class="invalid-feedback" role="alert">--}}
                            {{--                                <strong>{{ $message }}</strong>--}}
                            {{--                            </span>--}}
                            {{--                            @enderror--}}

                            <label class="textfield__inputlabel" for="LGI-01_loginPassWord">비밀번호</label>
                            <input type="password" id="LGI-01_loginPassWord" name="secret" class="textfield__input textfield__input--gray @error('not_match') is-invalid has-error @enderror" required autocomplete="current-password"
                                   placeholder="비밀번호를 입력해주세요." />
                            {{--                            @error('password')--}}
                            {{--                            <span class="invalid-feedback" role="alert">--}}
                            {{--                                <strong>{{ $message }}</strong>--}}
                            {{--                            </span>--}}
                            {{--                            @enderror--}}
                        </div>

                        <div class="login__notice-box">
                            <ul>
                                <li>서비스 이용 및 회원가입 문의는 '서비스 이용문의(cs@all-furn.com)' 또는 031-813-5588로 문의 해주세요.</li>
                            </ul>
                        </div>
                        <div class="button-wrap">
                            <button type="submit" id="LGI-01_loginBtn" class="button button--solid" disabled>로그인하기</button>
                            <button type="button" onclick="location.href='{{ route('signUp') }}'" class="button button--blank-gray">올펀 가입하기</button>
                        </div>
                        <ul class="link-button-wrap">
                            @if (Route::has('passwordRequest'))
                                <li><a href="{{ route('passwordRequest') }}" role="button" class="link-button">비밀번호 재설정</a></li>
                            @endif
                            <li><a href="mailto:cs@all-furn.com " role="button" class="link-button">서비스 이용 문의</a></li>
                        </ul>
                    </form>

                    <!-- 아이디, 패스워드 불일치 -->
                    <div id="alert-modal01" class="alert-modal" @error('not_match') style="display: block;" @enderror>
                        <div class="alert-modal__container">
                            <div class="alert-modal__top">
                                <p>
                                    아이디 패스워드가 일치하지 않습니다.<br>
                                    다시 확인해주세요.
                                </p>
                            </div>
                            <div class="alert-modal__bottom">
                                <button type="button" class="button button--solid" onclick="closeModalWithNum(1)">
                                    확인
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 미승인 -->
                    <div id="alert-modal02" class="alert-modal" @error('not_approve') style="display: block;" @enderror>
                        <div class="alert-modal__container">
                            <div class="alert-modal__top">
                                <p>
                                    가입 승인 후 로그인해주세요.<br>
                                    가입 승인 결과는 문자로 전송됩니다.
                                </p>
                            </div>
                            <div class="alert-modal__bottom">
                                <button type="button" class="button button--solid" onclick="closeModalWithNum(2)">
                                    확인
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 관리자에서 생성한 계정 최초 진입 -->
                    <div id="alert-modal03" class="alert-modal" @error('need_terms') style="display: block;" @enderror>
                        <div class="alert-modal__container">
                            <div class="alert-modal__top">
                                <p>
                                    약관 동의 화면으로 이동합니다.
                                </p>
                                <p class="text--gray">
                                    관리자가 계정을 생성한 경우,<br>
                                    최초 로그인 시 약관 동의가 필요합니다.
                                </p>
                            </div>
                            <div class="alert-modal__bottom">
                                <button type="button" class="button button--solid" onclick="closeModalWithNum(3)">
                                    확인
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 관리자에서 생성한 계정 최초 진입 -->
                    <div id="alert-modal04" class="alert-modal" @error('error_custom') style="display: block;" @enderror>
                        <div class="alert-modal__container">
                            <div class="alert-modal__top">
                                <p>
                                    잠시후 다시 이용해주세요.
                                </p>
                                <p class="text--gray">
                                    @error('error_custom')
                                    {{ $message }}
                                    @enderror
                                </p>
                            </div>
                            <div class="alert-modal__bottom">
                                <button type="button" class="button button--solid" onclick="closeModalWithNum(4)">
                                    확인
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="alert-modal05" class="alert-modal" @error('success') style="display: block;" @enderror>
                        <div class="alert-modal__container">
                            <div class="alert-modal__top">
                                <p>
                                    로그인 완료
                                </p>
                            </div>
                            <div class="alert-modal__bottom">
                                <button type="button" class="button button--solid" onclick="closeModalWithNum(5)">
                                    확인
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 미승인 -->
                    <div id="alert-modal06" class="alert-modal" @error('withdrawal') style="display: block;" @enderror>
                        <div class="alert-modal__container">
                            <div class="alert-modal__top">
                                <p>
                                    탈퇴 처리된 계정입니다.<br>
                                    재가입은 탈퇴일 기점으로 1개월 이후 신규 가입이 가능합니다.
                                </p>
                            </div>
                            <div class="alert-modal__bottom">
                                <button type="button" class="button button--solid" onclick="closeModalWithNum(6)">
                                    확인
                                </button>
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
        $( document ).ready( function() {
            $( 'input' ).keyup( function() {
                var id = $( '#LGI-01_loginId' ).val();
                var pw = $( '#LGI-01_loginPassWord' ).val();

                if (id != "" && pw != "") {
                    $('#LGI-01_loginBtn').removeAttr("disabled");
                } else {
                    $('#LGI-01_loginBtn').attr("disabled", true);
                }
            } );
        } );

        function closeModalWithNum(i) {
            closeModal('#alert-modal0'+i);

            switch (i)
            {
                case 1: //계정 or 비번 오류
                case 6: // 탈퇴 계정
                    $(".has-error").first().focus();
                    break;
                case 2: // 승인대기중 홈이동
                    window.location.href = '/';
                    break;
                case 3: // 약관페이지 이동
                    window.location.href = '/terms?idx=@error('need_terms'){{$message}}@enderror';
                    break;
                case 4:
                case 5:// 기타오류 홈이동
                    window.location.href = '/';
                    break;
            }
        }
    </script>
@stop
