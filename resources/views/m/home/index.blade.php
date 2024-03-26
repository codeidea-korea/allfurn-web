@extends('layouts.app_m')
@php
    $only_quick = '';
    $header_depth = 'home';
    $top_title = '';
    $header_banner = '';
@endphp
@section('content')
@include('layouts.header_m')

<div id="content">
    <div class="main_visual">
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
                    @if(isset($item->folder) && isset($item->filename))
                        <li class="swiper-slide" style="background-image:url('{{preImgUrl().$item->folder."/".$item->filename}}')">
                    @else 
                        <li class="swiper-slide" style="background-image:url('/img/main_visual.png')">
                    @endif
                        <a href="{{$link}}">
                            <span class="brand">{{ $item->company_name }}</span>
                            <p><b>{{ $item->subtext1 }}</b><br/>{{ $item->subtext2 }}</p>
                        </a>
                    </li>
                @endforeach
                <li class="swiper-slide" style="background-image:url('./img/main_visual.png')">
                    <a href="javascript:;">
                        <span class="brand">올펀가구2</span>
                        <p><b>올펀 프리미엄 가구</b><br/>모던 스타일의 트랜디한 소파</p>
                    </a>
                </li>
                <li class="swiper-slide" style="background-image:url('./img/main_visual.png')">
                    <a href="javascript:;">
                        <span class="brand">올펀가구2</span>
                        <p><b>올펀 프리미엄 가구</b><br/>모던 스타일의 트랜디한 소파</p>
                    </a>
                </li>
            </ul>
            <div class="bottom_box">
                <p>올펀가구</p>
                <div class="flex items-center ">
                    <div class="count_pager"><b>1</b> / 12</div>
                    <a href="javascript:;">모아보기</a>
                </div>
            </div>
        </div>
    </div>

    <div class="main_mid_banner overflow-hidden">
        <div class="inner">
            <div class="slide_box">
                <ul class="swiper-wrapper">
                    <li class="swiper-slide">
                         <a href="javascript:;">
                            <img src="./img/main/best_icon.png" alt="">
                            <span>BEST<br/>신상품</span>
                         </a>
                    </li>
                    <li class="swiper-slide">
                         <a href="javascript:;">
                            <img src="./img/main/search_icon.png" alt="">
                            <span>쉬운<br/> 상품 찾기</span>
                         </a>
                    </li>
                    <li class="swiper-slide">
                         <a href="javascript:;">
                            <img src="./img/main/event_icon.png" alt="">
                            <span>할인/이벤트<br/> 상품</span>
                         </a>
                    </li>
                    <li class="swiper-slide">
                         <a href="javascript:;">
                            <img src="./img/main/news_icon.png" alt="">
                            <span>일일 <br/>가구 뉴스</span>
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

    <div class="category_banner overflow-hidden">
        <div class="inner">
            <div class="slide_box ">
                <ul class="swiper-wrapper">
                    <li class="swiper-slide active">
                        <a href="javascript:;">
                            <i><b>ALL</b></i>
                            <span>전체</span>
                        </a>
                    </li>
                    <li class="swiper-slide">
                        <a href="javascript:;">
                            <i><svg><use xlink:href="./img/icon-defs.svg#category_bed"></use></svg></i>
                            <span>침대/매트리스</span>
                        </a>
                    </li>
                    <li class="swiper-slide">
                        <a href="javascript:;">
                            <i><svg><use xlink:href="./img/icon-defs.svg#category_sofa"></use></svg></i>
                            <span>소파/거실</span>
                        </a>
                    </li>
                    <li class="swiper-slide">
                        <a href="javascript:;">
                            <i><svg><use xlink:href="./img/icon-defs.svg#category_table"></use></svg></i>
                            <span>식탁/의자</span>
                        </a>
                    </li>
                    <li class="swiper-slide">
                        <a href="javascript:;">
                            <i><svg><use xlink:href="./img/icon-defs.svg#category_closet"></use></svg></i>
                            <span>옷장</span>
                        </a>
                    </li>
                    <li class="swiper-slide">
                        <a href="javascript:;">
                            <i><svg><use xlink:href="./img/icon-defs.svg#category_study"></use></svg></i>
                            <span>서재/공부방</span>
                        </a>
                    </li>
                    <li class="swiper-slide">
                        <a href="javascript:;">
                            <i><svg><use xlink:href="./img/icon-defs.svg#category_dressing"></use></svg></i>
                            <span>화장대/콘솔</span>
                        </a>
                    </li>
                    <li class="swiper-slide">
                        <a href="javascript:;">
                            <i><svg><use xlink:href="./img/icon-defs.svg#category_kids"></use></svg></i>
                            <span>키즈/주니어</span>
                        </a>
                    </li>
                    <li class="swiper-slide">
                        <a href="javascript:;">
                            <i><svg><use xlink:href="./img/icon-defs.svg#category_display"></use></svg></i>
                            <span>진열장/장식장</span>
                        </a>
                    </li>
                    <li class="swiper-slide">
                        <a href="javascript:;">
                            <i><svg><use xlink:href="./img/icon-defs.svg#category_office"></use></svg></i>
                            <span>사무용가구</span>
                        </a>
                    </li>
                    <li class="swiper-slide">
                        <a href="javascript:;">
                            <i><img src="./img/main/obtain_icon.png" alt=""></i>
                            <span>조달가구</span>
                        </a>
                    </li>
                    <li class="swiper-slide">
                        <a href="javascript:;">
                            <i><svg><use xlink:href="./img/icon-defs.svg#category_business"></use></svg></i>
                            <span>업소용가구</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <section class="main_section best_prod overflow-hidden">
        <div class="inner">
            <div class="main_tit mb-5 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>BEST 신상품</h3>
                </div>
                <div class="flex items-center gap-7">
                    <button class="zoom_btn flex items-center gap-1" onclick="modalOpen('#zoom_view-modal')"><svg><use xlink:href="./img/icon-defs.svg#zoom"></use></svg>확대보기</button>
                </div>
            </div>
            <div class="relative">
                <div class="slide_box prod_slide-2">
                    <ul class="swiper-wrapper">
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <a href="./prod_list_best.php" class="btn btn-line4 mt-4">더보기</a>
        </div>
    </section>

    <section class="main_section new_prod overflow-hidden">
        <div class="inner">
            <div class="main_tit mb-5 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>신규 등록 상품</h3>
                </div>
                <div class="flex items-center gap-7">
                    <button class="zoom_btn flex items-center gap-1" onclick="modalOpen('#zoom_view-modal')"><svg><use xlink:href="./img/icon-defs.svg#zoom"></use></svg>확대보기</button>
                </div>
            </div>
            <div class="relative">
                <div class="slide_box prod_slide-2">
                    <ul class="swiper-wrapper">
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
                
            </div>
            <a href="./prod_list_new.php" class="btn btn-line4 mt-4">더보기</a>
        </div>
    </section>

    <section class="main_section theme_prod overflow-hidden">
        <div class="inner">
            <div class="main_tit mb-5 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>MD가 추천하는 테마별 상품</h3>
                </div>
            </div>
            <div class="tab_layout">
                <ul class="swiper-wrapper">
                    <li class="swiper-slide active"><a href="javascript:;">1인 가구 모음</a></li>
                    <li class="swiper-slide"><a href="javascript:;">호텔형 침대 모음</a></li>
                    <li class="swiper-slide"><a href="javascript:;">펫 하우스</a></li>
                    <li class="swiper-slide"><a href="javascript:;">옷장/수납장</a></li>
                </ul>
            </div>
        </div>
        <div class="inner overflow-hidden">
            <div class="tab_content">
                <!-- 1인가구 모음 -->
                <div class="tab_01 relative active">
                    <div class="title">
                        <div class="bg" style="background-color:#D6B498; "></div>
                        <h4>내 침실을 휴향지 호텔 처럼!</h4>
                        <p>1인 가구 모음</p>
                    </div>
                    <div class="slide_box">
                        <ul class="swiper-wrapper">
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- 호텔형 침대 모음 -->
                <div class="tab_02 relative">
                    <div class="title">
                        <div class="bg" style="background-color:#D6B498; "></div>
                        <h4>내 침실을 휴향지 호텔 처럼!</h4>
                        <p>호텔형 침대 모음</p>
                    </div>
                    <div class="slide_box">
                        <ul class="swiper-wrapper">
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- 펫 하우스 -->
                <div class="tab_03 relative">
                    <div class="title">
                        <div class="bg" style="background-color:#D6B498; "></div>
                        <h4>내 침실을 휴향지 호텔 처럼!</h4>
                        <p>펫 하우스</p>
                    </div>
                    <div class="slide_box">
                        <ul class="swiper-wrapper">
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- 옷장/수납장 -->
                <div class="tab_04 relative">
                    <div class="title">
                        <div class="bg" style="background-color:#D6B498; "></div>
                        <h4>내 침실을 휴향지 호텔 처럼!</h4>
                        <p>옷장/수납장</p>
                    </div>
                    <div class="slide_box">
                        <ul class="swiper-wrapper">
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>

                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>112,500원</b>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="main_section popular_prod">
        <div class="inner">
            <div class="main_tit mb-5 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>인기 브랜드</h3>
                </div>
            </div>
        </div>
        <div class="relative">
            <div class="slide_box overflow-hidden">
                <div class="swiper-wrapper">
                    <ul class="swiper-slide">
                        <li class="popular_banner">
                            <div class="txt_box">
                                <p>
                                    <b>친환경 아이들을 위한 가구</b><br/>
                                    모던 스타일의 트랜디한 소파
                                </p>
                                <a href="javascript:;"><b>꿈꾸는나무 </b> 홈페이지 가기</a>
                            </div>
                        </li>
                        <li class="prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb2.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                        </li>
                        <li class="prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb2.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                        </li>
                        <li class="prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb2.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                        </li>
                        <li class="prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb2.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                        </li>
                    </ul>
                    <ul class="swiper-slide">
                        <li class="popular_banner">
                            <div class="txt_box">
                                <p>
                                    <b>친환경 아이들을 위한 가구</b><br/>
                                    모던 스타일의 트랜디한 소파
                                </p>
                                <a href="javascript:;"><b>꿈꾸는나무 </b> 홈페이지 가기</a>
                            </div>
                        </li>
                        <li class="prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb2.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                        </li>
                        <li class="prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb2.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                        </li>
                        <li class="prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb2.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                        </li>
                        <li class="prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb2.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="inner">
            <div class="flex items-center justify-center mt-4">
                <div class="count_pager"><b>1</b> / 12</div>
            </div>
            <a href="./prod_list_popular.php" class="btn btn-line4 mt-4">더보기</a>
        </div>
    </section>

    <section class="main_section sale_prod overflow-hidden">
        <div class="inner">
            <div class="main_tit mb-5 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>할인 상품이 필요하신가요?</h3>
                </div>
            </div>
            <div class="relative">
                <div class="slide_box ">
                    <ul class="swiper-wrapper">
                        <li class="swiper-slide prod_item type02">
                            <div class="img_box">
                                <a href="./prod_detail.php">
                                    <img src="./img/sale_thumb.png" alt="">
                                    <span><b>분위기 있는 친환경 수납장</b><br/>#한정 할인 특가 #분위기있는</span>
                                </a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <strong>내 침실을 휴향지 호텔 처럼!  20조 한정 할인 특가를 진행합니다.</strong>
                                    <span>올펀가구</span>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item type02">
                            <div class="img_box">
                                <a href="./prod_detail.php">
                                    <img src="./img/sale_thumb.png" alt="">
                                    <span><b>분위기 있는 친환경 수납장</b><br/>#한정 할인 특가 #분위기있는</span>
                                </a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <strong>내 침실을 휴향지 호텔 처럼!  20조 한정 할인 특가를 진행합니다.</strong>
                                    <span>올펀가구</span>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item type02">
                            <div class="img_box">
                                <a href="./prod_detail.php">
                                    <img src="./img/sale_thumb.png" alt="">
                                    <span><b>분위기 있는 친환경 수납장</b><br/>#한정 할인 특가 #분위기있는</span>
                                </a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <strong>내 침실을 휴향지 호텔 처럼!  20조 한정 할인 특가를 진행합니다.</strong>
                                    <span>올펀가구</span>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item type02">
                            <div class="img_box">
                                <a href="./prod_detail.php">
                                    <img src="./img/sale_thumb.png" alt="">
                                    <span><b>분위기 있는 친환경 수납장</b><br/>#한정 할인 특가 #분위기있는</span>
                                </a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <strong>내 침실을 휴향지 호텔 처럼!  20조 한정 할인 특가를 진행합니다.</strong>
                                    <span>올펀가구</span>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item type02">
                            <div class="img_box">
                                <a href="./prod_detail.php">
                                    <img src="./img/sale_thumb.png" alt="">
                                    <span><b>분위기 있는 친환경 수납장</b><br/>#한정 할인 특가 #분위기있는</span>
                                </a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <strong>내 침실을 휴향지 호텔 처럼!  20조 한정 할인 특가를 진행합니다.</strong>
                                    <span>올펀가구</span>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item type02">
                            <div class="img_box">
                                <a href="./prod_detail.php">
                                    <img src="./img/sale_thumb.png" alt="">
                                    <span><b>분위기 있는 친환경 수납장</b><br/>#한정 할인 특가 #분위기있는</span>
                                </a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <strong>내 침실을 휴향지 호텔 처럼!  20조 한정 할인 특가를 진행합니다.</strong>
                                    <span>올펀가구</span>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item type02">
                            <div class="img_box">
                                <a href="./prod_detail.php">
                                    <img src="./img/sale_thumb.png" alt="">
                                    <span><b>분위기 있는 친환경 수납장</b><br/>#한정 할인 특가 #분위기있는</span>
                                </a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <strong>내 침실을 휴향지 호텔 처럼!  20조 한정 할인 특가를 진행합니다.</strong>
                                    <span>올펀가구</span>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item type02">
                            <div class="img_box">
                                <a href="./prod_detail.php">
                                    <img src="./img/sale_thumb.png" alt="">
                                    <span><b>분위기 있는 친환경 수납장</b><br/>#한정 할인 특가 #분위기있는</span>
                                </a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <strong>내 침실을 휴향지 호텔 처럼!  20조 한정 할인 특가를 진행합니다.</strong>
                                    <span>올펀가구</span>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item type02">
                            <div class="img_box">
                                <a href="./prod_detail.php">
                                    <img src="./img/sale_thumb.png" alt="">
                                    <span><b>분위기 있는 친환경 수납장</b><br/>#한정 할인 특가 #분위기있는</span>
                                </a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <strong>내 침실을 휴향지 호텔 처럼!  20조 한정 할인 특가를 진행합니다.</strong>
                                    <span>올펀가구</span>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item type02">
                            <div class="img_box">
                                <a href="./prod_detail.php">
                                    <img src="./img/sale_thumb.png" alt="">
                                    <span><b>분위기 있는 친환경 수납장</b><br/>#한정 할인 특가 #분위기있는</span>
                                </a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <strong>내 침실을 휴향지 호텔 처럼!  20조 한정 할인 특가를 진행합니다.</strong>
                                    <span>올펀가구</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <a href="./prod_list_best2.php" class="btn btn-line4 mt-7">더보기</a>
        </div>
    </section>

    <section class="main_section video_prod">
        <div class="inner">
            <div class="main_tit mb-8 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>동영상으로 도매 업체/상품 알아보기</h3>
                </div>
            </div>
        </div>
        <div class="video_box overflow-hidden">
            <div class="slide_box">
                <ul class="swiper-wrapper">
                    <li class="swiper-slide">
                        <div class="txt_box">
                            <h4>올펀 프리미엄 가구<br/><span>모던 스타일의 트랜디한 소파</span></h4>
                        </div>
                        <video controls src="./img/ex_video.mp4"></video>
                        <!-- <a href="javascript:;" onclick="modalOpen('#video-modal')"><img src="./img/video_thumb.png" alt=""></a> -->
                    </li>
                    <li class="swiper-slide">
                        <div class="txt_box">
                            <h4>올펀 프리미엄 가구<br/><span>모던 스타일의 트랜디한 소파</span></h4>
                        </div>
                        <video controls src="./img/ex_video.mp4"></video>
                        <!-- <a href="javascript:;" onclick="modalOpen('#video-modal')"><img src="./img/video_thumb.png" alt=""></a> -->
                    </li>
                    <li class="swiper-slide">
                        <div class="txt_box">
                            <h4>올펀 프리미엄 가구<br/><span>모던 스타일의 트랜디한 소파</span></h4>
                        </div>
                        <video controls src="./img/ex_video.mp4"></video>
                        <!-- <a href="javascript:;" onclick="modalOpen('#video-modal')"><img src="./img/video_thumb.png" alt=""></a> -->
                    </li>
                </ul>
            </div>
            <div class="count_pager"><b>1</b> / 12</div>
        </div>
    </section>

    <section class="main_section main_board">
        <div class="inner">
            <div class="board_wrap">
                <div>
                    <div class="main_tit mb-8 flex justify-center items-center">
                        <h3>매거진</h3>
                    </div>
                    <ul class="main_board_list2">
                        <li>
                            <div class="img_box"><a href="javascript:;"><img src="./img/magazin_thumb.png" alt=""></a></div>
                            <div class="txt_box">
                                <a href="javascript:;">
                                    <b>[가구,가구인] 서울경인가구공동협동조합 이사장 이정우 대표</b>
                                    <span>2023.10.05</span>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="img_box"><a href="javascript:;"><img src="./img/magazin_thumb.png" alt=""></a></div>
                            <div class="txt_box">
                                <a href="javascript:;">
                                    <b>[가구,가구인] 서울경인가구공동협동조합 이사장 이정우 대표</b>
                                    <span>2023.10.05</span>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="img_box"><a href="javascript:;"><img src="./img/magazin_thumb.png" alt=""></a></div>
                            <div class="txt_box">
                                <a href="javascript:;">
                                    <b>[가구,가구인] 서울경인가구공동협동조합 이사장 이정우 대표</b>
                                    <span>2023.10.05</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div>
                    <div class="main_tit mb-5 mt-14 flex justify-center items-center">
                        <h3>커뮤니티</h3>
                    </div>
                    <ul class="main_board_list">
                        <li>
                            <div class="title">
                                <a href="javascript:;">
                                    <span>상품문의</span>
                                    <p>이 제품을 찾고있습니다.</p>
                                </a>
                            </div>
                            <span>23.10.04</span>
                        </li>
                        <li>
                            <div class="title">
                                <a href="javascript:;">
                                    <span>홍보</span>
                                    <p>20개조 한정으로 소파 할인 행사</p>
                                </a>
                            </div>
                            <span>23.10.04</span>
                        </li>
                        <li>
                            <div class="title">
                                <a href="javascript:;">
                                    <span>상품문의</span>
                                    <p>집 인테리어에 어울릴까요?</p>
                                </a>
                            </div>
                            <span>23.10.04</span>
                        </li>
                        <li>
                            <div class="title">
                                <a href="javascript:;">
                                    <span>홍보</span>
                                    <p>친환경 침대 특별 할인 행사 진행</p>
                                </a>
                            </div>
                            <span>23.10.04</span>
                        </li>
                    </ul>

                    <div class="main_tit mb-5 mt-14 flex justify-center items-center">
                        <h3>가구 모임</h3>
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
            <ul class="grid grid-cols-2">
                <li>
                    <div class="img_box"><img src="./img/main/family_logo_1.png" alt=""></div>
                    <p>조달가구</p>
                </li>
                <li>
                    <div class="img_box"><img src="./img/main/family_logo_2.png" alt=""></div>
                    <p>3D사진관</p>
                </li>
                <li>
                    <div class="img_box"><img src="./img/main/family_logo_3.png" alt=""></div>
                    <p>대한가구협동조합</p>
                </li>
                <li>
                    <div class="img_box"><img src="./img/main/family_logo_4.png" alt=""></div>
                    <p>코펀 KOFURN</p>
                </li>
            </ul>
        </div>
    </section>

    <!-- 동영상 모달 -->
    <div class="modal" id="video-modal">
        <div class="modal_bg" onclick="modalClose('#video-modal')"></div>
        <div class="modal_inner video_wrap">
            <button class="close_btn" onclick="modalClose('#video-modal')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body">
                <div class="video_box">
                    <iframe  src="https://www.youtube.com/embed/IJT51et7owQ" title="2 시간 지브리 음악 🌍 치유, 공부, 일, 수면을위한 편안한 배경 음악 지브리 스튜디오" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>

    
</div>


<script>

    // main_visual 
    const main_visual = new Swiper(".main_visual .slide_box", {
        slidesPerView: 1,
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
        slidesPerView: 'auto',
        spaceBetween: 8,
    });

    // category_banner
    const category_banner = new Swiper(".category_banner .slide_box", {
        slidesPerView: 'auto',
        spaceBetween: 17,
    });

    $('.category_banner li').on('click',function(){
        $(this).addClass('on').siblings().removeClass('on')
    })


    // best_prod 
    const best_prod = new Swiper(".best_prod .slide_box", {
        slidesPerView: 'auto',
        spaceBetween: 8,
        grid: {
            rows: 2,
        },
        pagination: {
            el: ".best_prod .count_pager",
            type: "fraction",
        },
    });

    // new_prod 
    const new_prod = new Swiper(".new_prod .slide_box", {
        slidesPerView: 'auto',
        spaceBetween: 8,
        grid: {
            rows: 2,
        },
        pagination: {
            el: ".new_prod .count_pager",
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

    const theme_prod_tab = new Swiper(".theme_prod .tab_layout", {
        slidesPerView: 'auto',
        spaceBetween: 10,
    });

    // theme_prod 
    const theme_prod_01 = new Swiper(".theme_prod .tab_01 .slide_box", {
        slidesPerView: 1.3,
        spaceBetween: 12,
        slidesPerGroup: 1,
        pagination: {
            el: ".theme_prod .tab_01.count_pager",
            type: "fraction",
        },
    });

    const theme_prod_02 = new Swiper(".theme_prod .tab_02 .slide_box", {
        slidesPerView: 1.3,
        spaceBetween: 12,
        slidesPerGroup: 1,
        pagination: {
            el: ".theme_prod .tab_02.count_pager",
            type: "fraction",
        },
    });

    const theme_prod_03 = new Swiper(".theme_prod .tab_03 .slide_box", {
        slidesPerView: 1.3,
        spaceBetween: 12,
        slidesPerGroup: 1,
        pagination: {
            el: ".theme_prod .tab_03.count_pager",
            type: "fraction",
        },
    });

    const theme_prod_04 = new Swiper(".theme_prod .tab_04 .slide_box", {
        slidesPerView: 1.3,
        spaceBetween: 12,
        slidesPerGroup: 1,
        pagination: {
            el: ".theme_prod .tab_04.count_pager",
            type: "fraction",
        },
    });

    // popular_prod 
    const popular_prod = new Swiper(".popular_prod .slide_box", {
        slidesPerView: 1,
        spaceBetween: 0,
        pagination: {
            el: ".popular_prod .count_pager",
            type: "fraction",
        },
    });

    // sale_prod 
    const sale_prod = new Swiper(".sale_prod .slide_box", {
        slidesPerView: 1.1,
        spaceBetween: 12,
     
    });

    // video_prod 
    const video_prod = new Swiper(".video_prod .slide_box", {
        slidesPerView: 1,
        spaceBetween: 10,
        pagination: {
            el: ".video_prod .count_pager",
            type: "fraction",
        },
    });

</script>




@endsection