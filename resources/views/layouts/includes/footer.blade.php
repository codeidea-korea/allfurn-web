<footer class="footer">
    <div class="inner">
        <div class="foo__cont">
            <div class="foo__wrap">
                <div>
                    <p class="foo__logo"><span class="a11y">All FURN</span></p>
                    <div class="foo__info">
                        <p>
                            사업자등록번호 : 128-19-60759<span class="bar"></span>대표 :
                            박복숙
                        </p>
                        <p>
                            Tel : 031-813-5588<span class="bar"></span>E-mail :
                            <a href="mailto:gaguoutlet11@naver.com">gaguoutlet11@naver.com</a>
                        </p>
                        <p>주소 : 경기도 고양시 일산서구 송산로 23 (구산동 1477-3)</p>
                    </div>
                </div>

                <div class="foo__customer">
                    <p>고객센터</p>
                    <a href="#">자주 묻는 질문</a>
                    <a href="#">공지사항</a>
                    <a href="#">1:1 문의</a>
                    <a href="#">이용 가이드</a>
                </div>

                <div class="foo__language">
                    <div class="foo__language__wrap">
                        <p>한국어</p>
                        <i class="ico__arrow--down20"><span class="a11y">아래 화살표</span></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="foo__util">
            <a href="#">서비스 소개</a><span class="bar"></span>
            <a href="#">이용 약관</a><span class="bar"></span>
            <a href="#">개인정보 처리 방침</a>
        </div>
    </div>

    @if(strpos($_SERVER['REQUEST_URI'], '/community') === 0)
        <a href="/community/write" title="게시글등록" class="add-button add-board">
            <i class="btn__floating add-board"></i>
        </a>
    @else
        <a href="/home/GGTW-WEB-PRA-01.html" title="상품등록" class="add-button">
            <i class="btn__floating"></i>
        </a>
    @endif
    <!-- <a href="#" title="문의하기" class="add-button">
      <i class="btn__floating--chat"></i>
    </a> -->
</footer>
