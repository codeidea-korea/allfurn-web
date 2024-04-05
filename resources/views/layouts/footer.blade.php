@if(request()->is(['product/detail/*', 'product/registration', 'magazine/*/detail/*', 'magazine/detail/*' ,'community/*', 'message/*', 'help/*']))
    {{-- 아무것도 표시 안함 --}}
@else
    <div id="prod_regist_btn" class="">
        @if(Request::segment(1) == 'community') 
            <a href="/community/write"><svg class="h-8 w-8" style="stroke: #fff;"><use xlink:href="/img/m/icon-defs.svg#write_pencil"></use></svg></a>
        @else
            <a href="/product/registration">상품<br>등록</a>
        @endif
    </div>
@endif

<footer>
    <div class="inner">
        @if(Auth::check())
            <ul class="fnb flex">
                <li><a href="/help">고객센터</a></li>
                <li><a href="/help/faq">자주 묻는 질문</a></li>
                <li><a href="/help/notice">공지사항</a></li>
                <li><a href="/help/inquiry">1:1 문의</a></li>
                <li><a href="/help/notice">이용 가이드</a></li>
            </ul>
        @endif 
        <div class="info">
            <img src="/img/logo_gray.svg" alt="">
            <div>
                사업자등록번호 : 182-81-02804 | 대표 : 송도현<br/>
                주소 : 경기도 고양시 일산동구 산두로213번길 18 (정발산동)<br/>
                E-mail : cs@all-furn.com | Tel : 031-813-5588
            </div>
        </div>
        <ul class="bottom_link flex">
            <li><a href="javascript:;">서비스소개</a></li>
            <li><a href="javascript:;">이용약관</a></li>
            <li><a href="javascript:;">개인정보 처리 방침</a></li>
        </ul>
    </div>
</footer>