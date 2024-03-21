@if(!Str::contains(url()->current(), ['/magazine/daily/detail', '/magazine/furniture/detail', 
                                      '/magazine/detail', '/community/detail', '/community/write']))
    <footer>
        <div class="inner">
            <ul class="fnb flex">
                <li><a href="/help">고객센터</a></li>
                <li><a href="/help/faq">자주 묻는 질문</a></li>
                <li><a href="/help/notice">공지사항</a></li>
                <li><a href="/help/inquiry">1:1 문의</a></li>
                <li><a href="/help/notice">이용 가이드</a></li>
            </ul>
            <div class="info">
                <img src="/img/logo_gray.svg" alt="">
                <div>
                    사업자등록번호 : 182-81-02804 | 대표 : 송도현<br>
                    주소 : 경기도 고양시 일산동구 산두로213번길 18 (정발산동)<br>
                    E-mail : cs@all-furn.com | Tel : 031-813-5588
                </div>
            </div>
            <ul class="bottom_link flex">
                <li><a href="javascript:;">서비스소개</a></li>
                <li><a href="javascript:;" onclick="modalOpen('#footer_agree-modal')">이용약관</a></li>
                <li><a href="javascript:;" onclick="modalOpen('#footer_policy-modal')">개인정보 처리 방침</a></li>
            </ul>
        </div>
    </footer>
@endif