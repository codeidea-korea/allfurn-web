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

    <section class="main_section new_prod">
        <div class="inner">
            <div class="main_tit mb-8 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>신규 등록 상품</h3>
                    <button class="zoom_btn flex items-center gap-1" onclick="modalOpen('#zoom_view-modal')"><svg><use xlink:href="./img/icon-defs.svg#zoom"></use></svg>확대보기</button>
                </div>
                <div class="flex items-center gap-7">
                    <div class="count_pager"><b>1</b> / 12</div>
                    <a class="more_btn flex items-center" href="./prod_list_new.php">더보기<svg><use xlink:href="./img/icon-defs.svg#more_icon"></use></svg></a>
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
                <button class="slide_arrow prev"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
                <button class="slide_arrow next"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
            </div>
        </div>
    </section>

    <section class="main_section theme_prod">
        <div class="inner">
            <div class="main_tit mb-8 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>MD가 추천하는 테마별 상품</h3>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <div class="tab_layout">
                    <ul>
                        <li class="active"><a href="javascript:;">1인 가구 모음</a></li>
                        <li><a href="javascript:;">호텔형 침대 모음</a></li>
                        <li><a href="javascript:;">펫 하우스</a></li>
                        <li><a href="javascript:;">옷장/수납장</a></li>
                    </ul>
                </div>
                <div class="tab_content">
                    <div class="count_pager tab_01 active"><b>1</b> / 12</div>
                    <div class="count_pager tab_02"><b>2</b> / 12</div>
                    <div class="count_pager tab_03"><b>3</b> / 12</div>
                    <div class="count_pager tab_04"><b>4</b> / 12</div>
                </div>
            </div>
            <div class="tab_content">
                <!-- 1인가구 모음 -->
                <div class="tab_01 relative active">
                    <div class="title">
                        <div class="bg" style="background-color:#D6B498; "></div>
                        <h4>내 침실을 휴향지 호텔 처럼!</h4>
                        <p>1인 가구 모음</p>
                    </div>
                    <button class="slide_arrow prev"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
                    <button class="slide_arrow next"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
                    <div class="slide_box overflow-hidden">
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
                    <button class="slide_arrow prev"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
                    <button class="slide_arrow next"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
                    <div class="slide_box overflow-hidden">
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
                    <button class="slide_arrow prev"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
                    <button class="slide_arrow next"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
                    <div class="slide_box overflow-hidden">
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
                    <button class="slide_arrow prev"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
                    <button class="slide_arrow next"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
                    <div class="slide_box overflow-hidden">
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
            <div class="main_tit mb-8 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>인기 브랜드</h3>
                </div>
                <div class="flex items-center gap-7">
                    <div class="count_pager"><b>1</b> / 12</div>
                    <a class="more_btn flex items-center" href="./prod_list_popular.php">더보기<svg><use xlink:href="./img/icon-defs.svg#more_icon"></use></svg></a>
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
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    </a>
                                </div>
                            </li>
                            <li class="prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb2.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    </a>
                                </div>
                            </li>
                            <li class="prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb2.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    </a>
                                </div>
                            </li>
                            <li class="prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb2.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    </a>
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
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    </a>
                                </div>
                            </li>
                            <li class="prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb2.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    </a>
                                </div>
                            </li>
                            <li class="prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb2.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    </a>
                                </div>
                            </li>
                            <li class="prod_item">
                                <div class="img_box">
                                    <a href="./prod_detail.php"><img src="./img/prod_thumb2.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <button class="slide_arrow prev"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
                <button class="slide_arrow next"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
            </div>
        </div>
    </section>

    <section class="main_section sale_prod">
        <div class="inner">
            <div class="main_tit mb-8 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>할인 상품이 필요하신가요?</h3>
                </div>
                <div class="flex items-center gap-7">
                    <div class="count_pager"><b>1</b> / 12</div>
                    <a class="more_btn flex items-center" href="./prod_list_best2.php">더보기<svg><use xlink:href="./img/icon-defs.svg#more_icon"></use></svg></a>
                </div>
            </div>
            <div class="relative">
                <div class="slide_box overflow-hidden">
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
                <button class="slide_arrow prev"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
                <button class="slide_arrow next"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
            </div>
        </div>
    </section>

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
                            <a class="more_btn flex items-center" href="javascript:;">더보기<svg><use xlink:href="./img/icon-defs.svg#more_icon"></use></svg></a>
                        </div>
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
                    <div class="main_tit mb-8 flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <h3>커뮤니티</h3>
                        </div>
                        <div class="flex items-center gap-7">
                            <a class="more_btn flex items-center" href="javascript:;">더보기<svg><use xlink:href="./img/icon-defs.svg#more_icon"></use></svg></a>
                        </div>
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
