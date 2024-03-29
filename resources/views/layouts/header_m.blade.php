
<header class="{{ $only_quick=='yes'?'hidden':'' }}">
    <div class="header_top {{ ($header_depth=='mypage' || $header_depth=='prodlist') ? 'hidden' : '' }}">
        <div class="inner">
            <h1 class="logo"><a class="flex items-center gap-1" href="/"><img src="/img/logo.svg" alt=""></a></h1>
            <button class="search_btn" onclick="modalOpen('#search_modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Search"></use></svg> 검색어를 입력하세요</button>
            <ul class="right_link flex items-center">
                <li><a class="alarm_btn" href="/alarm"><span hidden>1</span><svg><use xlink:href="/img/icon-defs.svg#Alarm"></use></svg></a></li>
            </ul>
        </div>
    </div>
    <div class="header_top sub_header {{ $header_depth=='mypage' ? '' :'hidden' }}">
        <div class="inner">
            <a href="javascript:window.history.back();"><svg class="w-6 h-6 rotate-180"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></a>
            <h3 class="title">{{ $top_title}}</h3>
            <ul class="right_link flex items-center">
                <li><a href="javascript:;" onclick="modalOpen('#search-modal')"><svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#Search_black"></use></svg></a></li>
                <li><a class="alarm_btn" href="/alarm"><span hidden>1</span><svg><use xlink:href="/img/icon-defs.svg#Alarm"></use></svg></a></li>
            </ul>
        </div>
    </div>
    <div class="header_top sub_header {{ $header_depth =='prodlist' ? '' : 'hidden' }}">
        <div class="inner">
            <div class="flex items-center">
                <a href="javascript:window.history.back();"><svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#left_arrow"></use></svg></a>
                <h3 class="title">{{ $top_title }}</h3>
            </div>
            <ul class="right_link flex items-center">
                <li><a href="javascript:;" onclick="modalOpen('#search-modal')"><svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#Search_black"></use></svg></a></li>
                <li><a class="alarm_btn" href="/alarm"><span hidden>1</span><svg><use xlink:href="/img/icon-defs.svg#Alarm"></use></svg></a></li>
            </ul>
        </div>
    </div>
    <div class="header_banner {{ $header_banner }} {{ ($header_depth=='category'|| $header_depth=='prodlist') ? 'hidden' : '' }}">
        <div class="inner">
            <a href="javascript:;" class="flex items-center">
                <svg><use xlink:href="/img/icon-defs.svg#Notice"></use></svg>
                내 집에서 호텔 침대를 만나보세요
                <svg><use xlink:href="/img/icon-defs.svg#Notice_arrow"></use></svg>
            </a>
        </div>
    </div>
</header>
<div class="header_category {{ ($header_depth=='like' || $header_depth=='mypage' || $header_depth=='category' || $header_depth=='prodlist') ? 'hidden' : '' }} {{ $only_quick == 'yes' ? 'hidden':'' }}">
    <div class="relative">
        <ul class="gnb flex items-center">
            {{-- <li><button class="flex items-center category_btn"><svg><use xlink:href="/img/icon-defs.svg#Hamicon"></use></svg>카테고리</button></li> --}}
            <li class="{{ $header_depth=='home' ? 'active':'' }}"><a href="/">홈</a></li>
            <li class="{{ $header_depth=='new_arrival' ? 'active':'' }}"><a href="/product/new">신상품</a></li>
            <li class="{{ $header_depth=='wholesaler' ? 'active':'' }}"><a href="/wholesaler">도매업체</a></li>
            <li class="{{ $header_depth=='thismonth' ? 'active':'' }}"><a href="/product/thisMonth"><span>이벤트를 모아보는</span>이달의딜</a></li>
            <li class="{{ $header_depth=='news' ? 'active':'' }}"><a href="/magazine">뉴스정보</a></li>
            <li class="{{ $header_depth=='community' ? 'active':'' }}"><a href="/community">커뮤니티</a></li>
        </ul>


    </div>
</div>


<div class="quick_menu">
    <ul class="menu">
        <li class="{{$header_depth=='category'?'active':'' }}"><a href="/category.php"><svg><use xlink:href="/img/m/icon-defs.svg#quick_category"></use></svg><span>카테고리</span></a></li>
        <li class="{{$header_depth=='like'?'active':'' }}"><a href="/like/product"><svg><use xlink:href="/img/m/icon-defs.svg#quick_like"></use></svg><span>좋아요</span></a></li>
        <li class="{{($header_depth!=='like'&&$header_depth!=='talk'&&$header_depth!=='mypage'&&$header_depth!=='category') ?'active':'' }}"><a href="/"><svg><use xlink:href="/img/m/icon-defs.svg#quick_home"></use></svg><span>홈</span></a></li>
        <li class="{{$header_depth=='talk'?'active':'' }}"><a href="/message"><svg><use xlink:href="/img/m/icon-defs.svg#quick_talk"></use></svg><span>올톡</span></a></li>
        <li class="{{$header_depth=='mypage'?'active':'' }}"><a href="/mypage/deal"><svg><use xlink:href="/img/m/icon-defs.svg#quick_my"></use></svg><span>마이올펀</span></a></li>
    </ul>
</div>

<div id="prod_regist_btn" class="{{($header_depth=='mypage' || $header_depth=='community' || $header_depth=='talk' )?'hidden':'' }}">
    <a href="./prod_registration.php">상품<br/>등록</a>
</div>

<!-- 검색 -->
<div class="modal" id="search_modal">
    <div class="modal_bg" onclick="modalClose('#search_modal')"></div>
    <div class="modal_inner inner_full">

        <div class="modal_title">
            <button class="x_btn" onclick="modalClose('#search_modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#x"></use></svg></button>
            <h3>검색</h3>
        </div>
        <div class="px-4">
            <div class="w-full bg-white search_list">
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
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        checkAlert();
    });

    var search_swhiper = new Swiper(".search_swhiper", {
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".search-button-next",
            prevEl: ".search-button-prev",
        },
        pagination: {
            el: ".count_pagination",
            type: "fraction",
        },
    });

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