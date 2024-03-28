<header>
    <div class="header_top">
        <div class="inner">
            <h1 class="logo"><a class="flex items-center gap-1" href="/"><img src="/img/logo.svg" alt="">가구 B2B플랫폼</a></h1>

            <div class="product_search relative">
                <form name="search_form" id="search_form" action="/home/searchResult" method="GET">
                <div class="search_btn">
                    <svg class="w-11 h-11 ml-2"><use xlink:href="./img/icon-defs.svg#Search"></use></svg> <input name="sKeyword" class="bg-transparent w-full h-full search_active" placeholder="상품및 도매 업체를 검색해주세요">
                </div>
                </form>
                <div class="absolute w-full p-4 bg-white rounded-md z-999 shadow-md search_list hidden">
                    <div class="text-sm flex justify-between py-3">
                        <span class="font-bold">최근 검색어</span>
                        <button class="text-gray-400">전체 삭제</button>
                    </div>
                    <ul class="flex flex-col gap-4">
                        <li class="flex items-center justify-between text-sm">
                            <a href="javascript:;">식탁</a>
                            <button>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-gray-400"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                            </button>
                        </li>
                        <li class="flex items-center justify-between text-sm">
                            <a href="javascript:;">테이블</a>
                            <button>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-gray-400"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                            </button>
                        </li>
                        <li class="flex items-center justify-between text-sm">
                            <a href="javascript:;">이벤트</a>
                            <button>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-gray-400"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                            </button>
                        </li>
                        <li class="flex items-center justify-between text-sm">
                            <a href="javascript:;">키즈가구</a>
                            <button>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-gray-400"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                            </button>
                        </li>
                    </ul>
                    <hr class="mt-4">
                    <div class="text-sm flex justify-between mt-2 py-3">
                        <span class="font-bold">인기 카테고리</span>
                        <span class="text-gray-400">12.01 02:28기준</span>
                    </div>
                    <ul class="flex flex-col gap-4">
                        <li class="flex items-center text-sm gap-2">
                            <span class="text-primary font-bold">1</span>
                            <a href="javascript:;">침대/매트리스 > 폼매트리스</a>
                        </li>
                        <li class="flex items-center text-sm gap-2">
                            <span class="text-primary font-bold">2</span>
                            <a href="javascript:;">소파/거실 > 1인용 소파</a>
                        </li>
                        <li class="flex items-center text-sm gap-2">
                            <span class="text-primary font-bold">3</span>
                            <a href="javascript:;">기타 카테고리</a>
                        </li>
                    </ul>
                    <hr class="mt-4">
                    <div class="text-sm flex mt-2 py-3 gap-1">
                        <span class="font-bold">추천 키워드</span>
                        <span class="text-gray-400 font-bold">AD</span>
                    </div>
                    <div class="text-sm text-gray-400">
                        추천 키워드가 없습니다.
                    </div>
                    <div class="mt-4 swiper search_swhiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide rounded-md overflow-hidden">
                                <img src="/img/search_img_d.png" class="w-full h-[110px]" alt="">
                            </div>
                            <div class="swiper-slide rounded-md overflow-hidden">
                                <img src="/img/search_img_d.png" class="w-full h-[110px]" alt="">
                            </div>
                            <div class="swiper-slide rounded-md overflow-hidden">
                                <img src="/img/search_img_d.png" class="w-full h-[110px]" alt="">
                            </div>
                        </div>
                        <div class="search-button-next">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right text-white"><path d="m9 18 6-6-6-6"/></svg>
                        </div>
                        <div class="search-button-prev">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left text-white"><path d="m15 18-6-6 6-6"/></svg>
                        </div>
                        <div class="count_pagination"></div>
                    </div>
                </div>
            </div>


            <!-- button class="search_btn" onclick="modalOpen('#search-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Search"></use></svg> 상품및 도매 업체를 검색해주세요</button //-->
            <ul class="right_link flex items-center">
                <li><a href="/message">올톡</a></li>
                <li><a href="/mypage/deal">마이올펀</a></li>
                <li><a href="/like/product">좋아요</a></li>
                <li><a class="alarm_btn" href="/alarm"><span hidden></span><svg><use xlink:href="/img/icon-defs.svg#Alarm"></use></svg></a></li>
            </ul>
        </div>
    </div>
    <div class="header_banner">
        <div class="inner">
            <a href="javascript:;" class="flex items-center">
                <svg><use xlink:href="/img/icon-defs.svg#Notice"></use></svg>
                내 집에서 호텔 침대를 만나보세요
                <svg><use xlink:href="/img/icon-defs.svg#Notice_arrow"></use></svg>
            </a>
        </div>
    </div>
</header>
<div class="header_category">
    <div class="inner relative">
        <ul class="gnb flex items-center">
            <li><button class="flex items-center category_btn"><svg><use xlink:href="/img/icon-defs.svg#Hamicon"></use></svg>카테고리</button></li>
            <li class="{{ Request::segment(1) == '' ? 'active' : '' }}"><a href="/">홈</a></li>
            <li class="{{ (Request::segment(1) == 'product' && Request::segment(2) == 'new') ? 'active' : '' }}"><a href="/product/new">신상품</a></li>
            <li class="{{ Request::segment(1) == 'wholesaler' ? 'active' : '' }}"><a href="/wholesaler">도매업체</a></li>
            <li class="{{ Request::segment(2) == 'thisMonth' ? 'active' : '' }}"><a href="/product/thisMonth"><span>이벤트를 모아보는</span>이달의딜</a></li>
            <li class="{{ Request::segment(1) == 'magazine' ? 'active' : '' }}"><a href="/magazine">뉴스정보</a></li>
            <li class="{{ Request::segment(1) == 'community' ? 'active' : '' }}"><a href="/community">커뮤니티</a></li>
        </ul>

        <div class="category_list"></div>
    </div>
</div>

<script>

    $(document).ready(function(f){
        getCategoryList();
        checkAlert();
        //getCategoryBanners();

        if( f.keyCode == 1 ) {
            if( $('#sKeyword').val() != '' ) {
                $('form#search_form').submit();
            }
        }
    });

    $(document).on('click', function(e) {
        // .search_active 클릭 시 .search_list 보이기
        if ($(e.target).closest('.search_active').length) {
            $('.search_list').show();
        }
        // .search_list 외의 영역 클릭 시 숨기기
        else if (!$(e.target).closest('.search_list').length) {
            $('.search_list').hide();
        }
    });

    function getCategoryList() {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url				: '/product/getCategoryListV2',
            data			: {},
            type			: 'POST',
            dataType		: 'json',
            success		: function(result) {
                let htmlText = '<ul>';
                result.forEach(function (e, idx) {
                    htmlText += '<li>';
                    htmlText += '<a href="javascript:;">';
                    htmlText += '<i><img src="'+ e.imgUrl + '"></i>';
                    htmlText += '<span>' + e.name + '</span>';
                    htmlText += '</a>';
                    htmlText += '<ul class="depth2">';
                    e.depth2.forEach(function (e2, idx2) {
                        htmlText += '<li><a href="/product/category?ca=' + e2.idx + '&pre='+e2.parent_idx+'">' + e2.name + '</a></li>';
                    })
                    htmlText += '</ul>';
                    htmlText += '</li>';
                })
                htmlText += '</ul>';
                $('.category_list').html(htmlText);
            }
        });
    }

    function goCategoryList(category) {
        location.href = "/product/category?pre=" + category;
    } 

    function checkAlert() {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method : 'POST',
            url : '/checkAlert',
            success : function(result) {
                if(result.success === true && result.alarm > 0) {
                    $(".alarm_btn span").text(result.alarm);
                    $(".alarm_btn span").show(result.alarm);
                } else {
                    $(".alarm_btn span").hide();
                }
            },
            error : function() {
                $(".alarm_btn span").hide();
            }
        })
    }
    
</script>