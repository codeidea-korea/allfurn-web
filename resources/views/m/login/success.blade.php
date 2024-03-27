@extends('layouts.app')

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

        
    </div>
@endsection




