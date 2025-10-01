@if(!Str::contains(url()->current(), ['/magazine/daily/detail', '/magazine/furniture/detail', 
                                      '/magazine/detail', '/community/detail', '/community/write',
                                      '/home/category','/product/registration',
                                      '/community/club/article', 'message/room'
                                      ]))
    <footer>
        <div class="inner">
            <ul class="fnb flex">
                <li><a href="/help">고객센터</a></li>
                <li><a href="/help/faq">자주 묻는 질문</a></li>
                <li><a href="/help/notice">공지사항</a></li>
                <li><a href="/help/inquiry">1:1 문의</a></li>
                <li><a href="/help/guide">이용 가이드</a></li>
            </ul>
            <div class="info">
                <img src="/img/logo_gray.svg" alt="">
                <div>
                    사업자등록번호 : 182-81-02804 | 대표 : 송도현<br>
                    주소 : 경기도 고양시 일산서구 송산로 26, 다동(구산동)<br>
                    E-mail : cs@all-furn.com | Tel : 031-813-5588
                </div>
            </div>
            <ul class="bottom_link flex">
                <li><a href="/home/welcome">서비스소개</a></li>
                <li><a href="javascript:;" onclick="modalOpen('#agree01-modal')">이용약관</a></li>
                <li><a href="javascript:;" onclick="modalOpen('#agree02-modal')"><b>개인정보 처리 방침</b></a></li>
            </ul>
        </div>
    </footer>
@endif

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