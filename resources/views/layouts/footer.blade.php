<footer>
    <div class="inner">
        @if(Auth::check())
            <ul class="fnb flex">
                <li><a href="javascsript:;">고객센터</a></li>
                <li><a href="javascsript:;">자주 묻는 질문</a></li>
                <li><a href="javascsript:;">공지사항</a></li>
                <li><a href="javascsript:;">1:1 문의</a></li>
                <li><a href="javascsript:;">이용 가이드</a></li>
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