@extends('layouts.app')

@section('content')
@include('layouts.header')


<div class="modal" id="main-event">
    <div class="modal_bg" onclick="modalClose('#main-event')"></div>
    <div class="modal_inner">
        <button class="close_btn" onclick="modalClose('#main-event')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body intro_popup">
            <div class="popup_slide">
                <ul class="swiper-wrapper">
                    @foreach($data['popup'] as $item)
                        <?php
                        $link = '';
                        switch ($item->web_link_type) {
                            case 0: //Url
                                $link = $item->web_link;
                                break;
                            case 1: //상품
                                $link = '/product/detail/'.$item->web_link;
                                break;
                            case 2: //업체
                                $link = '/wholesaler/detail/'.$item->web_link;
                                break;
                            case 3: //커뮤니티
                                $link = '/community/detail/'.$item->web_link;
                                break;
                            case 4: //커뮤니티
                                $link = '/help/notice/'.$item->web_link;
                                break;
                            case 5: //커뮤니티
                                $link = $item->web_link;
                                break;
                            case 6: // 이용가이드
                                $link = '/help/guide?gk='.$item->web_link;
                                break;
                            default: //공지사항
                                $link = '/help/notice/'.$item->web_link;
                                break;
                        }
                        ?>
                        <li class="swiper-slide"><a href="{{$link}}"><img src="{{$item->imgUrl}}" alt=""></a></li>
                    @endforeach
                </ul>
                <div class="pager"></div>
            </div>
            <div class="btn_bot">
                <button class="btn btn-line3 noTodaybtn" onclick="popupClose()">오늘하루 그만보기</button>
                <button class="btn btn-primary" onclick="modalClose('#main-event')">닫기</button>
            </div>
        </div>
    </div>
</div>

<div id="content">
    <div class="main_visual">
        <div class="inner">
            <div class="slide_box bg_gradient">
                <ul class="swiper-wrapper">
                    @foreach($data['banner_top'] as $item)
                        <?php
                        $link = '';
                        switch ($item->web_link_type) {
                            case 0: //Url
                                $link = $item->web_link;
                                break;
                                
                            case 1: //상품
                                if ( strpos($item->web_link, 'product/detail') !== false ) {
                                    $link = $item->web_link;
                                } else {
                                    $link = '/product/detail/'.$item->web_link;
                                }
                                break;
                                
                            case 2: //업체
                                if ( strpos($item->web_link, 'wholesaler/detail') !== false ) {
                                    $link = $item->web_link;
                                } else {
                                    $link = '/wholesaler/detail/'.$item->web_link;    
                                } 
                                break;
                            case 3: //커뮤니티
                                if ( strpos($item->web_link, 'community/detail') !== false ) {
                                    $link = $item->web_link;
                                } else {
                                    $link = '/community/detail/'.$item->web_link;
                                } 
                                break;
                            case 4:
                                $link = '/help/notice/';
                                break;
                            default: //공지사항
                                $link = $item->web_link;
                                break;
                        }
                        ?>
                        @if($item->banner_type == 'img')
                            <li class="swiper-slide">
                                <a href="javascript:linkToPage('{{$link}}');">
                                    <span class="brand">{{ $item->company_name }}</span>
                                    @if(isset($item->folder) && isset($item->filename))
                                        <img src="{{preImgUrl().$item->folder."/".$item->filename}}" alt="">
                                    @else 
                                        <img src="/img/main_visual.png" alt="">
                                    @endif
                                </a>
                            </li>
                        @else
                            <li class="swiper-slide" style="height:660px;background-color:{{$item->bg_color}};">
                                <a href="javascript:linkToPage('{{$link}}');">
                                    <span class="brand">{{ $item->company_name }}</span>
                                    <p style="color:{{ $item->font_color }};"><b>{{ $item->subtext1 }}</b><br/>{{ $item->subtext2 }}</p>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <div class="bottom_box">
                    <p>{{ isset($data['banner_top'][0]) ? $data['banner_top'][0]->company_name : '' }}</p>
                    <div class="flex items-center ">
                        <div class="count_pager"><b>1</b> / {{ count($data['banner_top']) }}</div>
                        {{-- <a href="javascript:;">모아보기</a> --}}
                    </div>
                </div>
                <button class="slide_arrow prev type02"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow_white"></use></svg></button>
                <button class="slide_arrow next type02"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow_white"></use></svg></button>
            </div>
        </div>
    </div>

    <div class="main_mid_banner">
        <div class="inner">
            <div class="slide_box overflow-hidden">
                <ul class="swiper-wrapper">
                    <li class="swiper-slide">
                         <a href="/product/best-new">
                            <img src="/img/main/best_icon.png" alt="">
                            <span>BEST 신상품</span>
                         </a>
                    </li>
                    <li class="swiper-slide">
                         <a href="javascript:modalOpen('#search-modal')">
                            <img src="/img/main/search_icon.png" alt="">
                            <span>쉬운 상품 찾기</span>
                         </a>
                    </li>
                    <li class="swiper-slide">
                         <a href="/product/thisMonth">
                            <img src="/img/main/event_icon.png" alt="">
                            <span>할인/이벤트 상품</span>
                         </a>
                    </li>
                    <li class="swiper-slide">
                         <a href="/magazine/daily">
                            <img src="/img/main/news_icon.png" alt="">
                            <span>일일 가구 뉴스</span>
                         </a>
                    </li>
                    <li class="swiper-slide">
                         <a href="/community?board_name=상품문의">
                            <img src="/img/main/message_icon.png" alt="">
                            <span>상품 문의</span>
                         </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="category_banner">
        <div class="inner">
            <div class="slide_box overflow-hidden">
                <ul class="swiper-wrapper">
                    {{-- <li class="swiper-slide active">
                        <a href="javascript:;">
                            <i><b>ALL</b></i>
                            <span>전체</span>
                        </a>
                    </li> --}}
                    @foreach($data['categoryAlist'] as $item)
                        <li class="swiper-slide">
                            <a href="/product/category?pre={{ $item->idx }}">
                                <i><img src="{{ $item->imgUrl }}"></i>
                                @if($item->idx == 4)
                                    <span>서랍장/옷장</span>
                                @elseif ($item->idx == 6)
                                    <span>화장대/거울</span>
                                @else
                                    <span>{{$item->name}}</span>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    {{-- 베스트 신상품 --}}
    @php $bestNewProducts = $data['productAd']; @endphp
    @include('home.inc-best-new-product')

    {{-- 신규 등록 상품 --}}
    @include('home.inc-new-product')

    {{-- MD가 추천하는 테마별 상품 --}}
    @include('home.inc-md-product')

    {{-- 인기 브랜드 --}}
    @include('home.inc-popular-brand')

    {{-- 할인 상품 --}}
    @include('home.inc-plan-discount')

    {{-- 동영상 광고 --}}
    @include('home.inc-video')
    
    <section class="main_section main_board">
        <div class="inner">
            <div class="board_wrap">
                <div>
                    <div class="main_tit mb-8 flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <h3>매거진</h3>
                        </div>
                        <div class="flex items-center gap-7">
                            <a class="more_btn flex items-center" href="/magazine">더보기<svg><use xlink:href="./img/icon-defs.svg#more_icon"></use></svg></a>
                        </div>
                    </div>
                    <ul class="main_board_list2">
                        @foreach($data['magazine'] as $item)
                        <li>
                            <div class="img_box"><a href="/magazine/detail/{{ $item->idx }}"><img src="{{ $item->image_url }}" alt=""></a></div>
                            <div class="txt_box">
                                <a href="/magazine/detail/{{ $item->idx }}">
                                    <b>[{{ $item->category_list }}] {{$item->title}}</b>
                                    <span>{{ Carbon\Carbon::parse($item->register_time)->format('Y.m.d') }}</span>
                                </a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <div class="main_tit mb-8 flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <h3>커뮤니티</h3>
                        </div>
                        <div class="flex items-center gap-7"><a class="more_btn flex items-center" href="/community">더보기<svg><use xlink:href="./img/icon-defs.svg#more_icon"></use></svg></a>
                        </div>
                    </div>
                    <ul class="main_board_list">
                        @foreach($data['community'] as $item)
                            <li>
                                <div class="title">
                                    <a href="/community/detail/{{$item->idx}}">
                                        <span>{{$item->name}}</span>
                                        <p>{{$item->title}}</p>
                                    </a>
                                </div>
                                <span>{{ Carbon\Carbon::parse($item->register_time)->format('y.m.d') }}</span>
                            </li>
                        @endforeach
                    </ul>


                    <div class="main_tit mb-6 mt-10 flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <h3>가구 모임</h3>
                        </div>
                        <div class="flex items-center gap-7">
                            <a class="more_btn flex items-center" href="/community/club">더보기<svg><use xlink:href="./img/icon-defs.svg#more_icon"></use></svg></a>
                        </div>
                    </div>
                    <ul class="main_board_list">
                        @foreach ($data['club'] as $item )
                            <li>
                                <div class="title">
                                    <a href="/community/club/article/{{$item->article_idx}}">
                                        <span>{{$item->name}}</span>
                                        <p>{{$item->title}}</p>
                                    </a>
                                </div>
                                <span>{{ Carbon\Carbon::parse($item->register_time)->format('y.m.d') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- 올펀 패밀리 광고 --}}
    @if(count($data['family_ad']) > 0)
        @include('home.inc-allfurn-family')  
    @endif
</div>


<script>

// 팝업
const popup = new Swiper('.modal .intro_popup .popup_slide',{
    loop: true,
    speed:700,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".modal .intro_popup .pager",
        type: "bullets",
    },
})
// 팝업 > 오늘하루 그만보기
$('.modal .noTodaybtn').click(function(){
    modalClose('#popup01')

    const today = new Date().toLocaleDateString();
    // 세션 스토리지에 오늘 날짜 저장
    sessionStorage.setItem('hideForToday', today);
})

$(document).ready(function () {
    const today = new Date().toLocaleDateString();
    const hideForToday = sessionStorage.getItem('hideForToday');

    if (hideForToday === today) {
        // 이미 오늘 하루 동안 보지 않기를 선택한 경우, 페이지의 어떤 부분을 숨기거나 처리할 수 있습니다.
        $("#popup01").removeClass("show");
    } else {
        $("#popup01").addClass("show");
    }
});

// main_visual 
const main_visual = new Swiper(".main_visual .slide_box", {
    effect: "creative",
    loop: true,
    slidesPerView: 1,
    speed : 1500,
    autoHeight:true,
    navigation: {
        nextEl: ".main_visual .slide_arrow.next",
        prevEl: ".main_visual .slide_arrow.prev",
    },
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".main_visual .count_pager",
        type: "fraction",
    },
    on: {
        slideChangeTransitionEnd: function () {
            let brand = $('.main_visual .swiper-slide.swiper-slide-active .brand').text(); 
            $('.main_visual .bottom_box p').text(brand)
        },
    },
    creativeEffect: {
        prev: {
          shadow: true,
          translate: ["-20%", 0, -1],
        },
        next: {
          translate: ["100%", 0, 0],
        },
    },
});
$('.main_visual .slide_box').hover(function(){
    main_visual.autoplay.stop();
}, function(){
    main_visual.autoplay.start();
});


// main_mid_banner
const main_mid_banner = new Swiper(".main_mid_banner .slide_box", {
    slidesPerView: 5,
    spaceBetween: 12,
});

// category_banner
const category_banner = new Swiper(".category_banner .slide_box", {
    slidesPerView: 11.3,
    spaceBetween: 11,
});

// best_prod 
const best_prod = new Swiper(".best_prod .slide_box", {
    slidesPerView: 4,
    spaceBetween: 20,
    slidesPerGroup: 4,
    grid: {
        rows: 2,
    },
    navigation: {
        nextEl: ".best_prod .slide_arrow.next",
        prevEl: ".best_prod .slide_arrow.prev",
    },
    pagination: {
        el: ".best_prod .count_pager",
        type: "fraction",
    },
});

// best_prod_modal
const zoom_view_modal = new Swiper("#zoom_view-modal .slide_box", {
    slidesPerView: 1,
    spaceBetween: 120,
    grid: {
        rows: 1,
    },
    navigation: {
        nextEl: "#zoom_view-modal .slide_arrow.next",
        prevEl: "#zoom_view-modal .slide_arrow.prev",
    },
    pagination: {
        el: "#zoom_view-modal .count_pager",
        type: "fraction",
    },
});

// new_prod 
const new_prod = new Swiper(".new_prod .slide_box", {
    slidesPerView: 4,
    spaceBetween: 20,
    slidesPerGroup: 4,
    grid: {
        rows: 2,
    },
    navigation: {
        nextEl: ".new_prod .slide_arrow.next",
        prevEl: ".new_prod .slide_arrow.prev",
    },
    pagination: {
        el: ".new_prod .count_pager",
        type: "fraction",
    },
});

// new_prod_modal
const new_prod_modal = new Swiper("#zoom_view-modal-new .slide_box", {
    slidesPerView: 1,
    spaceBetween: 120,
    slidesPerGroup: 1,
    grid: {
        rows: 1,
    },
    navigation: {
        nextEl: "#zoom_view-modal-new .slide_arrow.next",
        prevEl: "#zoom_view-modal-new .slide_arrow.prev",
    },
    pagination: {
        el: "#zoom_view-modal-new .count_pager",
        type: "fraction",
    },
    on: {
        slideChange: function () {
            if (this.isEnd) {
                $("#zoom_view-modal-new .slide_arrow.more_btn").show();
            } else {
                $("#zoom_view-modal-new .slide_arrow.more_btn").hide();
            }
        },
    },
});

// 테마별상품 탭
$('.theme_prod .tab_layout li').on('click',function(){
    let liN = $(this).index();
    $(this).addClass('active').siblings().removeClass('active');
    $('.theme_prod .tab_content').each(function(){
        $(this).find('>div').eq(liN).addClass('active').siblings().removeClass('active');
    })
})

// theme_prod 
const theme_prod_01 = new Swiper(".theme_prod .tab_01 .slide_box", {
    slidesPerView: 3,
    spaceBetween: 20,
    slidesPerGroup: 3,
    navigation: {
        nextEl: ".theme_prod .tab_01 .slide_arrow.next",
        prevEl: ".theme_prod .tab_01 .slide_arrow.prev",
    },
    pagination: {
        el: ".theme_prod .tab_01.count_pager",
        type: "fraction",
    },
});

const theme_prod_02 = new Swiper(".theme_prod .tab_02 .slide_box", {
    slidesPerView: 3,
    spaceBetween: 20,
    slidesPerGroup: 3,
    navigation: {
        nextEl: ".theme_prod .tab_02 .slide_arrow.next",
        prevEl: ".theme_prod .tab_02 .slide_arrow.prev",
    },
    pagination: {
        el: ".theme_prod .tab_02.count_pager",
        type: "fraction",
    },
});

const theme_prod_03 = new Swiper(".theme_prod .tab_03 .slide_box", {
    slidesPerView: 3,
    spaceBetween: 20,
    slidesPerGroup: 3,
    navigation: {
        nextEl: ".theme_prod .tab_03 .slide_arrow.next",
        prevEl: ".theme_prod .tab_03 .slide_arrow.prev",
    },
    pagination: {
        el: ".theme_prod .tab_03.count_pager",
        type: "fraction",
    },
});

const theme_prod_04 = new Swiper(".theme_prod .tab_04 .slide_box", {
    slidesPerView: 3,
    spaceBetween: 20,
    slidesPerGroup: 3,
    navigation: {
        nextEl: ".theme_prod .tab_04 .slide_arrow.next",
        prevEl: ".theme_prod .tab_04 .slide_arrow.prev",
    },
    pagination: {
        el: ".theme_prod .tab_04.count_pager",
        type: "fraction",
    },
});

// popular_prod 
const popular_prod_pager = new Swiper(".popular_prod .pager_box", {
    slidesPerView: 'auto',
    spaceBetween: 10,
    navigation: {
        nextEl: ".popular_prod .bottom_box .arrow.next",
        prevEl: ".popular_prod .bottom_box .arrow.prev",
    },
});

const popular_prod = new Swiper(".popular_prod .slide_box", {
    slidesPerView: 1,
    spaceBetween: 0,
    navigation: {
        nextEl: ".popular_prod .slide_arrow.next",
        prevEl: ".popular_prod .slide_arrow.prev",
    },
    pagination: {
        el: ".popular_prod .main_tit .count_pager",
        type: "fraction",
    },
    thumbs: {
            swiper: popular_prod_pager,
        },
        on: {
            init : function(swiper){
                $(".main_popular .bottom_box .right_box .count_pager").html(`<b>${swiper.snapIndex+1}</b> / ${swiper.snapGrid.length}`)
            },
            slideChange : function(swiper){
                $(".main_popular .bottom_box .right_box .count_pager").html(`<b>${swiper.snapIndex+1}</b> / ${swiper.snapGrid.length}`)
            }
        }
});

// sale_prod 
const sale_prod = new Swiper(".sale_prod .slide_box", {
    slidesPerView: 2,
    spaceBetween: 30,
    slidesPerGroup: 2,
    navigation: {
        nextEl: ".sale_prod .slide_arrow.next",
        prevEl: ".sale_prod .slide_arrow.prev",
    },
    pagination: {
        el: ".sale_prod .count_pager",
        type: "fraction",
    },
});

// video_prod 
const video_prod = new Swiper(".video_prod .slide_box", {
    slidesPerView: 1,
    navigation: {
        nextEl: ".video_prod .slide_arrow.next",
        prevEl: ".video_prod .slide_arrow.prev",
    },
    pagination: {
        el: ".video_prod .count_pager",
        type: "fraction",
    },
});

$(document)
    .on('click', '.sch_cate_info .btn-primary', function() {
        var pre = $(this).prev().find('li.active').data('pre');

        if( typeof pre != 'undefined' && pre != '' ) {
            $(location).attr('href', '/product/category?pre=' + pre);
        } else {
            //
        }
    })
;

var modalswiper = new Swiper('#modalkvSwipe', {
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },
    loop: true,
    slidesPerView: 1,
    spaceBetween: 0,
    paginationClickable: true,
    keyboard: true,
    speed: 500,
    pagination: {
        el: '#modalkvSwipe .swiper-pagination',
        type: 'fraction',
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});
$('#modalkvSwipe .swiper-slide').hover(function(){
    modalswiper.autoplay.stop();
}, function(){
    modalswiper.autoplay.start();
});

var getCookie = function (cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
    }
    return "";
}

var setCookie = function (cname, cvalue) {
    var todayDate = new Date();
    todayDate.setHours(23, 59, 59, 999);
    var expires = "expires=" + todayDate.toString(); // UTC기준의 시간에 exdays인자로 받은 값에 의해서 cookie가 설정 됩니다.
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

var popupClose = function(){
    setCookie("mainEventPopupClose","Y");
    modalClose('#main-event');
}

function popupUrl() {
    location.replace($('#modalkvSwipe .swiper-slide-active a').prop('href'));
}

$(document).ready(function(){
    var cookiedata = document.cookie;
    console.log('tt',cookiedata);
    if(cookiedata.indexOf("mainEventPopupClose=Y")<0){
        modalOpen("#main-event");
    }
});
</script>




@endsection
