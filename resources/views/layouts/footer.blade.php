@if(Auth::check())
    @if(request()->is(['product/detail/*', 'product/registration', 'magazine/*/detail/*', 
                            'magazine/detail/*','community','community/*', 'message/*', 'help/*',
                            'signin', 'signup','findid', 'findpw'
                        ]))
            {{-- 아무것도 표시 안함 --}}
    @else
        <div id="prod_regist_btn" class="">
            <a href="{{ Auth::user()['type'] === 'W' ? "javascript:gotoLink('/product/registration');" : "javascript:requiredUserGrade(['W']);" }}">상품<br>등록</a>
        </div>
    @endif
    @if(request()->is(['', '/', 'mypage', 'mypage/deal', 'wholesaler/detail/'.Auth::user()['company_idx'] ]))
        <div style="z-index:50; position:fixed; right:40px; bottom:115px; display:flex; align-items:center; justify-content:center; width:68px; height:68px; border-radius:50%; background-color:#000; color:#fff; text-align:center; line-height:1.15;">
            <a href="{{ Auth::user()['type'] === 'W' ? "javascript:shareCatalog(".Auth::user()['company_idx'].",4);" : "javascript:requiredUserGrade(['W']);" }}">카탈로그<br>보내기</a>
        </div>
        @if(isset(Auth::user()['type']) && in_array(Auth::user()['type'], ['W']))
            @include('layouts.includes.send-catalog')
        @endif
    @endif
@endif
    
@if(request()->is(['wholesaler/detail/*' ]))
    <div style="z-index:51; position:fixed; right:40px; bottom:115px; display:flex; align-items:center; justify-content:center; width:68px; height:68px; border-radius:50%; background-color:#000; color:#fff; text-align:center; line-height:1.15;">
        <a href="javascript:shareCatalog({{$data['info']->idx}},6);">카탈로그<br>받기</a>
    </div>
    @include('layouts.includes.send-catalog')
@endif

<footer>
    <div class="inner">
        @if(Auth::check())
            <ul class="fnb flex">
                <li><a href="/help">고객센터</a></li>
                <li><a href="/help/faq">자주 묻는 질문</a></li>
                <li><a href="/help/notice">공지사항</a></li>
                <li><a href="/help/inquiry">1:1 문의</a></li>
                <li><a href="/help/guide">이용 가이드</a></li>
            </ul>
        @endif 
        <div class="info">
            <img src="/img/logo_gray.svg" alt="">
            <div>
                사업자등록번호 : 182-81-02804 | 대표 : 송도현<br/>
                주소 : 경기도 고양시 일산서구 송산로 26, 다동(구산동)<br/>
                E-mail : cs@all-furn.com | Tel : 031-813-5588
            </div>
        </div>
        <ul class="bottom_link flex">
            <li><a href="/home/welcome">서비스소개</a></li>
            <li><a onclick="modalOpen('#agree01-modal')">이용약관</a></li>
            <li><a onclick="modalOpen('#agree02-modal')"><b>개인정보 처리 방침</b></a></li>
        </ul>
    </div>
</footer>

<!-- ** 페이지 로딩 ** -->
<div id="loadingContainer" style="display:none;">
    <svg width="50" viewBox="0 0 120 30" xmlns="http://www.w3.org/2000/svg" fill="rgb(255, 255, 255)" class="w-10 h-10">
        <circle cx="15" cy="15" r="15">
            <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate>
            <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate>
        </circle>
        <circle cx="60" cy="15" r="9" fill-opacity="0.3">
            <animate attributeName="r" from="9" to="9" begin="0s" dur="0.8s" values="9;15;9" calcMode="linear" repeatCount="indefinite"></animate>
            <animate attributeName="fill-opacity" from="0.5" to="0.5" begin="0s" dur="0.8s" values=".5;1;.5" calcMode="linear" repeatCount="indefinite"></animate>
        </circle>
        <circle cx="105" cy="15" r="15">
            <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate>
            <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate>
        </circle>
    </svg>
</div>
<!-- ** 페이지 로딩 끝 ** -->
