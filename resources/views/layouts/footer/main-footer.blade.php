<footer class="footer">
    <div class="inner">
        <div class="foo__cont">
            <div class="foo__wrap">
                <div>
                    <p class="foo__logo"><span class="a11y">All FURN</span></p>
                    <div class="foo__info">
                        <p>
                            사업자등록번호 : 182-81-02804<span class="bar"></span>대표 :
                            송도현
                        </p>
                        <p>
                            Tel : 031-813-5588<span class="bar"></span>E-mail :
                            <a href="mailto:cs@all-furn.com ">cs@all-furn.com </a>
                        </p>
                        <p>주소 : 경기도 고양시 일산서구 송산로 26, 다동(구산동)</p>
                    </div>
                </div>

                {{-- @if(Auth::check())
                    <div class="foo__customer">
                        <p>고객센터</p>
                        <a href="/help/faq">자주 묻는 질문</a>
                        <a href="/help/notice">공지사항</a>
                        <a href="/help/inquiry">1:1 문의</a>
                        <a href="/help/notice">이용 가이드</a>
                    </div>
                @endif --}}
{{--                <div class="foo__language">--}}
{{--                    <div class="foo__language__wrap">--}}
{{--                        <p>한국어</p>--}}
{{--                        <i class="ico__arrow--down20"><span class="a11y">아래 화살표</span></i>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
        <div class="foo__util">
            <a href="/home/welcome">서비스 소개</a><span class="bar"></span>
            <span onclick="openModal('#reg-agrmnt_service')" style="cursor: pointer;">이용 약관</span><span class="bar"></span>
            <span onclick="openModal('#reg-agrmnt_privacy-info')" style="cursor: pointer;">개인정보 처리 방침</span>
        </div>

        <div id="reg-agrmnt_service" class="modal">
            <div class="modal__container">
                <div class="modal__content">
                    <div class="modal-box__container" style="width: 566px">
                        <div class="modal-box__content">
                            <div class="header">
                                <p>서비스 이용 약관</p>
                            </div>
                            <div class="content" style="height: 380px; overflow-y:hidden">
                                <iframe src="https://api.all-furn.com/res/agreement/agreement.html" style="width: 100%; height: 100%; padding-top: 10px; padding-bottom: 10px; background-color: #f0f0f0;">
                                </iframe>
                            </div>
                            <div class="footer" style="height: 42px"></div>
                            <div class="modal-close">
                                <button type="button" onclick="closeModal('#reg-agrmnt_service')" class="modal__close-button"><span class="a11y">닫기</span></button>
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
                            <div class="content" style="height: 380px; overflow-y:hidden">
                                <iframe src="https://api.all-furn.com/res/agreement/agreement.html" style="width: 100%; height: 100%; padding-top: 10px; padding-bottom: 10px; background-color: #f0f0f0;">
                                </iframe>
                            </div>
                            <div class="footer" style="height: 42px"></div>
                            <div class="modal-close">
                                <button type="button" onclick="closeModal('#reg-agrmnt_privacy-info')" class="modal__close-button"><span class="a11y">닫기</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="floating_div">
    </div>
    
    <script>
        function floating() {
            var url = $(location).attr('href');
            var htmlText = '';


            @if(Auth::check())
            
                if(url.match('/community') && !url.match('/community/detail') && !url.match('/community/write')) {
                    htmlText = '<a href="/community/write" title="작성하기" class="add-button" style="display: block;">' +
                        '<i class="btn__floating--pencil"></i>' +
                        '</a>';
                } else if (url.match('community') || url.match('/help/inquiry') || url.match('/help/faq') || url.match('/help/notice') || '{{Auth::user()->type}}' == 'N' || ('{{Auth::user()->type}}' == 'W' && ((url.match('/product/registration') || url.match('/product/modify')))) || ('{{Auth::user()->type}}' == 'R' && !url.match('/product/detail') && !url.match('/wholesaler/detail'))) {
                    htmlText = '';
                } else if('{{Auth::user()->type}}' != 'N' && (url.match('/product/detail') || url.match('/wholesaler/detail'))) {
                    htmlText = '<a onclick="sendMessage()" title="문의하기" class="add-button" style="display: block;">' +
                        '<i class="btn__floating--chat"></i>' +
                        '</a>';
                } else {
                    
                    if ( '{{Auth::user()->type}}' != 'N' && '{{Auth::user()->type}}' != 'S' ) {

                        htmlText = '<a href="{{ route('product.create') }}" title="상품등록" class="add-button" style="display: block;">' +
                            '<i class="btn__floating"></i>' +
                            '</a>';

                    }
                    
                }
                
            @endif

            $('#floating_div').html(htmlText);
        }

        //문의하기
        function sendMessage() {
            idx='';
            type=''
            if ($(location).attr('href').includes('/product/detail')) {
                idx = $(location).attr('pathname').split('/')[3];
                type = 'product';
            } else if ($(location).attr('href').includes('/wholesaler/detail/')) {
                idx = $(location).attr('pathname').split('/')[3];
                type = 'wholesaler';
            }

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url                : '/message/send',
                data            : {
                    'idx'       : idx,
                    'type'      : type,
                    'message'   : '상품 문의드립니다.'
                },
                type            : 'POST',
                dataType        : 'json',
                success        : function(result) {
                    if (result.result == 'success') {
                        location.replace('/message?roomIdx='+result.roomIdx+'&idx='+idx+'&type='+type+'&message=상품 문의드립니다');
                    } else {

                    }
                }
            });
        }

        //즐겨찾기
        function addInterestByList(idx) {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url             : '/product/interest/'+idx,
                enctype         : 'multipart/form-data',
                processData     : false,
                contentType     : false,
                data			: {},
                type			: 'POST',
                success: function (result) {
                    if (result.success) {
                        if (result.interest == 0) {
                            $('.ico__bookmark24--on[data-product_idx="' + idx + '"].active').addClass('ico__bookmark24--off').removeClass('ico__bookmark24--on');
                        } else {
                            $('.ico__bookmark24--off[data-product_idx="' + idx + '"]').addClass('ico__bookmark24--on').removeClass('ico__bookmark24--off');
                        }
                    } else {
                    }
                }
            });
        }

        $(document).ready(function(){
            floating()
        });

        function openModal(name) {
            document.querySelector(name).style.display = 'block';
            document.querySelector('body').style.overflow = 'hidden';
        }

        function closeModal(name) {
            if (name === '*') {
                const openModals = document.querySelectorAll('.modal');
                openModals.forEach(modal => {
                    closeModal('#' + modal.id);
                });
            } else {
                document.querySelector(name).style.display = 'none';
                document.querySelector('body').style.overflow = '';
            }
        }
    </script>
</footer>
