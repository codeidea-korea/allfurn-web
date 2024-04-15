@extends('layouts.app_m')
@php
    $only_quick = '';
    $header_depth = 'product';
    $top_title = '';
    $header_banner = '';
@endphp
@section('content')
@include('layouts.header_m')
    <div id="content">

        @if( count( $dealbrand ) > 0 )
        <section class="sub_section sub_section_top thismonth_con01">
            <div class="relative popular_prod type02">
                <div class="slide_box overflow-hidden">
                    <div class="swiper-wrapper">
                        @foreach( $dealbrand AS $key => $deal )
                        <ul class="swiper-slide">
                            <li class="popular_banner">
                                <img src="{{$deal->imgUrl}}" class="h-[320px]" alt="{{$deal->company_name}}">
                                <div class="txt_box">
                                    <p>
                                        <b>{{$deal->subtext1}}</b><br/>{{$deal->subtext2}}
                                    </p>
                                    <a href="/wholesaler/detail/{{$deal->company_idx}}"><b>{{$deal->company_name}} </b> 홈페이지 가기</a>
                                </div>
                            </li>
                            @php $product = json_decode( $deal->product_info );@endphp
                            @foreach( $product AS $p => $item )
                            <li class="prod_item">
                                <div class="img_box">
                                    <a href="/product/detail/{{$item->mdp_gidx}}"><img src="{{$item->mdp_gimg}}" alt=""></a>
                                    <button class="zzim_btn prd_{{$item->mdp_gidx}} {{ ($deal->isInterest[$item->mdp_gidx] == 1) ? 'active' : '' }}" pidx="{{$item->mdp_gidx}}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="bottom_box">
                <div class="bot_slide ">
                    <button class="arrow prev"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
                    <div class="pager_box overflow-hidden">
                        <ul class="swiper-wrapper">
                            @foreach( $dealbrand AS $key => $deal )
                                @php if( $key > 8 ) continue; @endphp
                            <li class="swiper-slide"><button>{{$deal->company_name}}</button></li>
                            @endforeach
                        </ul>
                    </div>
                    <button class="arrow next"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
                </div>
                <div class="right_box">
                    <div class="count_pager"><b>1</b> / 12</div>
                    <a href="/product/thisMonthDetail">모아보기</a>
                </div>
            </div>
        </section>
        @endif

        @if( count( $plandiscount ) > 0 )
        <section class="sub_section thismonth_con02 overflow-hidden">
            <div class="inner">
                <div class="main_tit mb-5 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <h3>Best 기획전</h3>
                    </div>
                </div>
                <div class="relative">
                    <div class="slide_box">
                        <ul class="swiper-wrapper">
                            @foreach( $plandiscount AS $key => $product )
                            <li class="swiper-slide prod_item type02">
                                <div class="img_box">
                                    <a href="/product/detail/{{$product->product_idx}}">
                                        <img src="{{$product->imgUrl}}" alt="">
                                        <span><b>{{$product->subtext1}}</b><br/>{{$product->subtext2}}</span>
                                    </a>
                                    <button class="zzim_btn prd_{{$product->product_idx}} {{ ($product->isInterest == 1) ? 'active' : '' }}" pidx="{{$product->product_idx}}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="/product/detail/{{$product->product_idx}}">
                                        <strong>{{$product->content}}</strong>
                                        <span>{{$product->company_name}}</span>
                                    </a>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!-- a class="btn btn-line4 mt-8" href="javascript:;">더보기</a //-->
            </div>
        </section>
        @endif

        @if( count( $dealmiddle ) > 0 )
        <section class="sub_section nopadding">
            <div class="line_common_banner">
                <ul class="swiper-wrapper">
                    @foreach( $dealmiddle AS $k => $mid )
                        <li class="swiper-slide" style="{{ $mid->banner_type == 'img' ? 'background-image:url(' . $mid->imgUrl . ');background-size:100%;' : 'background-color:' . $mid->font_color . ';' }}">
                            @php
                                $link = '';
                                switch ($mid->web_link_type) {
                                    case 0: //Url
                                        $link = $mid->web_link;
                                        break;
                                    case 1: //상품
                                        $link = $mid->web_link;
                                        break;
                                    case 2: //업체
                                        $link = $mid->web_link;
                                        break;
                                    case 3: //커뮤니티
                                        $link = $mid->web_link;
                                        break;
                                    default: //공지사항
                                        $link = '/help/notice/';
                                        break;
                                }
                            @endphp
                            @if( $mid->banner_type == 'img' )
                                <a href="{{$link}}"></a>
                            @else
                                <a href="{{$link}}">
                                    <div class="txt_box">
                                        <p>{{$mid->subtext1}}<br/>{{$mid->subtext2}}</p>
                                        <span>{{$mid->content}}</span>
                                    </div>
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
                <div class="count_pager"><b>1</b> / 12</div>
            </div>
        </section>
        @endif

        @if( count( $productBest ) > 0 )
        <section class="sub_section thismonth_con04 overflow-hidden">
            <div class="inner">
                <div class="main_tit mb-5 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <h3>{{date('n')}}월 BEST 상품</h3>
                    </div>
                    <div class="flex items-center gap-7">
                        <button class="zoom_btn flex items-center gap-1" onclick="modalOpen('#zoom_view-modal')"><svg><use xlink:href="/img/icon-defs.svg#zoom"></use></svg>확대보기</button>
                    </div>
                </div>
                <!-- div class="tab_layout mb-6">
                    <ul class="swiper-wrapper">
                        <li class="swiper-slide active"><a href="javascript:;">1인 가구 모음</a></li>
                        <li class="swiper-slide"><a href="javascript:;">호텔형 침대 모음</a></li>
                        <li class="swiper-slide"><a href="javascript:;">펫 하우스</a></li>
                        <li class="swiper-slide"><a href="javascript:;">옷장/수납장</a></li>
                    </ul>
                </div //-->
                <div class="tab_content">
                    <div class="relative active">
                        <div class="slide_box prod_slide-2">
                            <ul class="swiper-wrapper">
                                @foreach( $productBest AS $key => $best )
                                <li class="swiper-slide prod_item">
                                    <div class="img_box">
                                        <a href="/product/detail/{{$best->idx}}"><img src="{{$best->imgUrl}}" alt="{{$best->name}}"></a>
                                        <button class="zzim_btn prd_{{$best->idx}} {{ ($best->isInterest == 1) ? 'active' : '' }}" pidx="{{$best->idx}}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                    </div>
                                    <div class="txt_box">
                                        <a href="/product/detail/{{$best->idx}}">
                                            <span>{{$best->companyName}}</span>
                                            <p>{{$best->name}}</p>
                                            <b>{{$best->is_price_open ? number_format($best->price, 0).'원': $best->price_text}}</b>
                                        </a>
                                    </div>
                                </li>
                                @endforeach

                            </ul>
                        </div>
                        <!-- a href="./prod_list_best.php" class="btn btn-line4 mt-4">더보기</a //-->
                    </div>
                </div>
            </div>
        </section>
        @endif

        @if( count( $companyProduct ) > 0 )
        <section class="sub_section sub_section_bot overflow-hidden">
            <div class="inner">
                <div class="main_tit mb-5 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <h3>9월 BEST 도매 업체</h3>
                    </div>
                </div>
                <div class="sub_filter">
                    <div class="filter_box">
                        <button class="" onclick="modalOpen('#filter_category-modal')">카테고리 <b class="txt-primary"></b></button>
                        <button class="" onclick="modalOpen('#filter_location-modal')">소재지 <b class="txt-primary"></b></button>
                        <button class="" onclick="modalOpen('#filter_align-modal03')">최신순 <b class="txt-primary"></b></button>
                    </div>
                </div>
            </div>

            <ul class="obtain_list type02"></ul>
        </section>
        @endif
    </div>

    <script>
        // thismonth_con01 - pager
        const thismonth_con01_pager = new Swiper(".thismonth_con01 .pager_box", {
            slidesPerView: 'auto',
            spaceBetween: 10,
            navigation: {
                nextEl: ".thismonth_con01 .bottom_box .arrow.next",
                prevEl: ".thismonth_con01 .bottom_box .arrow.prev",
            },
        });

        // thismonth_con01
        const thismonth_con01 = new Swiper(".thismonth_con01 .slide_box", {
            slidesPerView: 1,
            spaceBetween: 0,
            pagination: {
                el: ".thismonth_con01 .count_pager",
                type: "fraction",
            },
            thumbs: {
                swiper: thismonth_con01_pager,
            },
        });

        // thismonth_con02
        const thismonth_con02 = new Swiper(".thismonth_con02 .slide_box", {
            slidesPerView: 1.1,
            spaceBetween: 12,
            pagination: {
                el: ".thismonth_con02 .count_pager",
                type: "fraction",
            },
        });


        // line_common_banner
        const line_common_banner = new Swiper(".line_common_banner", {
            slidesPerView: 1,
            spaceBetween: 0,
            pagination: {
                el: ".line_common_banner .count_pager",
                type: "fraction",
            }
        });

        // 테마별상품 탭
        $('.thismonth_con04 .tab_layout li').on('click',function(){
            let liN = $(this).index();
            $(this).addClass('active').siblings().removeClass('active');
            $('.thismonth_con04 .tab_content').each(function(){
                $(this).find('>div').eq(liN).addClass('active').siblings().removeClass('active');
            })
        })

        const thismonth_prod_tab = new Swiper(".thismonth_con04 .tab_layout", {
            slidesPerView: 'auto',
            spaceBetween: 8,
        });


        // thismonth_con04
        const thismonth_con04 = new Swiper(".thismonth_con04 .slide_box", {
            slidesPerView: 'auto',
            spaceBetween: 8,
            grid: {
                rows: 2,
            },
            pagination: {
                el: ".thismonth_con04 .count_pager",
                type: "fraction",
            },
        });

        /* ----------------------------- */
        $(document).ready(function(){
            setTimeout(() => {
                loadWholesalerList();
            }, 50);
        });

        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() + 20 >= $(document).height() && !isLoading && !isLastPage) {
                loadWholesalerList();
            }
        });

        // 필터링으로 조회
        $(document).on('click', '[id^="filter"] .btn-primary', function() { 
            loadWholesalerList(true, $(this));
        });

        //초기화
        $(".refresh_btn").on('click', function() {
            $("#filter_category-modal .check-form:checked").prop('checked', false);
            $("#filter_location-modal .check-form:checked").prop('checked', false);
            $("#filter_align-modal03 .radio-form").eq(0).prop('checked', true);
            
            loadWholesalerList(true);
        });

        let isLoading = false;
        let isLastPage = false;
        let currentPage = 0;
        function loadWholesalerList(needEmpty, target) {
            isLoading = true;

            if(needEmpty) currentPage = 0;

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '/product/getJsonThisBestWholesaler',
                method: 'GET',
                data: {
                    'page': ++currentPage,
                    'categories' : getIndexesOfSelectedCategory().join(','),
                    'locations' : getIndexesOfSelectedLocation().join(','),
                    'orderedElement' : $("#filter_align-modal03 .radio-form:checked").val()
                },
                beforeSend : function() {
                    if(target) {
                        target.prop("disabled", true);
                    }
                },
                success: function(result) {

                    if(needEmpty) {
                        $(".sub_section_bot ul.obtain_list").empty();
                    }

                    $(".sub_section_bot ul.obtain_list").append(result.html);

                    $(".total").text('전체 ' + result.list.total.toLocaleString('ko-KR') + '개');

                    if(target) {
                        target.prop("disabled", false);
                        modalClose('#' + target.parents('[id^="filter"]').attr('id'));
                    }     
                    
                    isLastPage = currentPage === result.list.last_page;
                },
                complete : function () {
                    displaySelectedCategories();
                    displaySelectedLocation();
                    displaySelectedOrders();
                    isLoading = false;
                }
            })
        }

        function getIndexesOfSelectedCategory() {
            let categories = [];
            $("#filter_category-modal .check-form:checked").each(function(){
                categories.push($(this).attr('id'));
            });

            return categories;
        }

        function getIndexesOfSelectedLocation() {
            let locations = [];
            $("#filter_location-modal .check-form:checked").each(function(){
                locations.push($(this).data('location'));
            });

            return locations;
        }

        function displaySelectedCategories() {
            let totalOfSelectedCategories = $("#filter_category-modal .check-form:checked").length;
            if(totalOfSelectedCategories === 0) {
                $(".sub_filter .filter_box button").eq(0).find('.txt-primary').text("");
                $(".sub_filter .filter_box button").eq(0).removeClass('on');
            } else {
                $(".sub_filter .filter_box button").eq(0).find('.txt-primary').text(totalOfSelectedCategories);
                $(".sub_filter .filter_box button").eq(0).addClass('on');
            }
        }

        function displaySelectedLocation() {
            let totalOfSelectedLocations = $("#filter_location-modal .check-form:checked").length;
            if(totalOfSelectedLocations === 0) {
                $(".sub_filter .filter_box button").eq(1).find('.txt-primary').text("");
                $(".sub_filter .filter_box button").eq(1).removeClass('on');
                
            } else {
                $(".sub_filter .filter_box button").eq(1).find('.txt-primary').text(totalOfSelectedLocations);
                $(".sub_filter .filter_box button").eq(1).addClass('on');
            }
        }

        function displaySelectedOrders() {
            $(".sub_filter .filter_box button").eq(2)
            .text($("#filter_align-modal03 .radio-form:checked").siblings('label').text());
        }

        function toggleCompanyLike(idx) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url : '/wholesaler/like/' + idx,
                method: 'POST',
                success : function(result) {
                    if (result.success) {
                        if (result.like === 0) {
                            $('.zzim_btn[data-company-idx='+idx+']').removeClass('active');
                        } else {
                            $('.zzim_btn[data-company-idx='+idx+']').addClass('active');
                        }
                    }
                }
            })
        }
    </script>
@endsection