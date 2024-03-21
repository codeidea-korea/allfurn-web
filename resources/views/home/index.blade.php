@extends('layouts.app')

@section('content')
@include('layouts.header')

<div id="content">
    <div class="main_visual">
        <div class="inner">
            <div class="slide_box">
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
                    <li class="swiper-slide">
                        <a href="{{$link}}">
                            <span class="brand">{{ $item->company_name }}</span>
                            <p><b>{{ $item->subtext1 }}</b><br/>{{ $item->subtext2 }}</p>
                            @if(isset($item->folder) && isset($item->filename))
                                <img src="{{preImgUrl().$item->folder."/".$item->filename}}" alt="">
                            @else 
                                <img src="/img/main_visual.png" alt="">
                            @endif
                        </a>
                    </li>
                    @endforeach
                </ul>
                <div class="bottom_box">
                    <p>{{ $data['banner_top'][0]->company_name }}</p>
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
                         <a href="javascript:;">
                            <img src="./img/main/best_icon.png" alt="">
                            <span>BEST신상품</span>
                         </a>
                    </li>
                    <li class="swiper-slide">
                         <a href="javascript:;">
                            <img src="./img/main/search_icon.png" alt="">
                            <span>쉬운 상품 찾기</span>
                         </a>
                    </li>
                    <li class="swiper-slide">
                         <a href="javascript:;">
                            <img src="./img/main/event_icon.png" alt="">
                            <span>할인/이벤트 상품</span>
                         </a>
                    </li>
                    <li class="swiper-slide">
                         <a href="javascript:;">
                            <img src="./img/main/news_icon.png" alt="">
                            <span>일일 가구 뉴스</span>
                         </a>
                    </li>
                    <li class="swiper-slide">
                         <a href="javascript:;">
                            <img src="./img/main/message_icon.png" alt="">
                            <span>상품 문의</span>
                         </a>
                    </li>
                    <li class="swiper-slide">
                         <a href="javascript:;">
                            <img src="./img/main/message_icon.png" alt="">
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
                    <li class="swiper-slide active">
                        <a href="javascript:;">
                            <i><b>ALL</b></i>
                            <span>전체</span>
                        </a>
                    </li>
                    @foreach($data['categoryAlist'] as $item)
                        <li class="swiper-slide">
                            <a href="/product/category?pre={{ $item->idx }}">
                                <i><img src="{{ $item->imgUrl }}"></i>
                                <span>{{ $item->name }}</span>
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

    

    <section class="main_section video_prod">
        <div class="inner">
            <div class="main_tit mb-8 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>동영상으로 도매 업체/상품 알아보기</h3>
                </div>
            </div>
            <div class="video_box">
                <div class="txt_box">
                    <h4>올펀 프리미엄 가구<br/><span>모던 스타일의 트랜디한 소파</span></h4>
                </div>
                <div class="slide_box overflow-hidden">
                    <ul class="swiper-wrapper">
                        <li class="swiper-slide">
                            <a href="javascript:;" onclick="modalOpen('#video-modal')"><img src="./img/video_thumb.png" alt=""></a>
                        </li>
                        <li class="swiper-slide">
                            <a href="javascript:;" onclick="modalOpen('#video-modal')"><img src="./img/video_thumb.png" alt=""></a>
                        </li>
                        <li class="swiper-slide">
                            <a href="javascript:;" onclick="modalOpen('#video-modal')"><img src="./img/video_thumb.png" alt=""></a>
                        </li>
                    </ul>
                </div>
                <div class="count_pager"><b>1</b> / 12</div>
                <button class="slide_arrow type02 prev"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow_white"></use></svg></button>
                <button class="slide_arrow type02 next"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow_white"></use></svg></button>
            </div>
        </div>
    </section>

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
                                    <b>{{$item->title}}</b>
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
                            <a class="more_btn flex items-center" href="javascript:;">더보기<svg><use xlink:href="./img/icon-defs.svg#more_icon"></use></svg></a>
                        </div>
                    </div>
                    <ul class="main_board_list">
                        <li>
                            <div class="title">
                                <a href="javascript:;">
                                    <span>골프모임</span>
                                    <p>12월 정모 일자 알려드립니다.</p>
                                </a>
                            </div>
                            <span>23.10.04</span>
                        </li>
                        <li>
                            <div class="title">
                                <a href="javascript:;">
                                    <span>소파 업체 모임</span>
                                    <p>패브릭 소파 판매현황이 어떤가요?</p>
                                </a>
                            </div>
                            <span>23.10.04</span>
                        </li>
                        <li>
                            <div class="title">
                                <a href="javascript:;">
                                    <span>매출 증진 모임</span>
                                    <p>이번달 매출액입니다.</p>
                                </a>
                            </div>
                            <span>23.10.04</span>
                        </li>
                    </ul>
                </div>
            </div>
            
        </div>
    </section>

    <section class="main_section main_family">
        <div class="inner">
            <div class="main_tit mb-2 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>올펀 패밀리</h3>
                </div>
            </div>
            <ul class="grid grid-cols-4">
                <li>
                    <div class="img_box"><img style="width:131px" src="./img/main/family_logo_1.png" alt=""></div>
                    <p>조달가구</p>
                </li>
                <li>
                    <div class="img_box"><img style="width:153px" src="./img/main/family_logo_2.png" alt=""></div>
                    <p>3D사진관</p>
                </li>
                <li>
                    <div class="img_box"><img style="width:148px" src="./img/main/family_logo_3.png" alt=""></div>
                    <p>대한가구협동조합</p>
                </li>
                <li>
                    <div class="img_box"><img style="width:159px" src="./img/main/family_logo_4.png" alt=""></div>
                    <p>코펀 KOFURN</p>
                </li>
            </ul>
        </div>
    </section>

    <!-- 동영상 모달 -->
    <div class="modal" id="video-modal">
        <div class="modal_bg" onclick="modalClose('#video-modal')"></div>
        <div class="modal_inner modal-auto video_wrap">
            <button class="close_btn" onclick="modalClose('#video-modal')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body">
            <iframe width="1244" height="700" src="https://www.youtube.com/embed/IJT51et7owQ" title="2 시간 지브리 음악 🌍 치유, 공부, 일, 수면을위한 편안한 배경 음악 지브리 스튜디오" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    
</div>


<script>
// main_visual 
const main_visual = new Swiper(".main_visual .slide_box", {
    slidesPerView: 1,
    navigation: {
        nextEl: ".main_visual .slide_arrow.next",
        prevEl: ".main_visual .slide_arrow.prev",
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
});


// main_mid_banner
const main_mid_banner = new Swiper(".main_mid_banner .slide_box", {
    slidesPerView: 5,
    spaceBetween: 12,
});

// category_banner
const category_banner = new Swiper(".category_banner .slide_box", {
    slidesPerView: 12,
    spaceBetween: 12,
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
const popular_prod = new Swiper(".popular_prod .slide_box", {
    slidesPerView: 1,
    spaceBetween: 0,
    navigation: {
        nextEl: ".popular_prod .slide_arrow.next",
        prevEl: ".popular_prod .slide_arrow.prev",
    },
    pagination: {
        el: ".popular_prod .count_pager",
        type: "fraction",
    },
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


</script>




@endsection
