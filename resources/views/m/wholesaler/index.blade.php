@extends('layouts.app_m')
@php
    $only_quick = '';
    $header_depth = 'wholesaler';
    $top_title = '';
    $header_banner = '';
@endphp
@section('content')
@include('layouts.header_m')
<div id="content">
    @if( count( $data['popularbrand_ad'] ) > 0 )
    <section class="sub_section sub_section_top wholesaler_con01">
        <div class="relative popular_prod">
            <div class="slide_box overflow-hidden">
                <div class="swiper-wrapper">
                    @foreach($data['popularbrand_ad'] as $key => $brand)
                    <ul class="swiper-slide">
                        <li class="popular_banner">
                            <img src="{{$brand->imgUrl}}" class="h-[320px]" alt="{{ $brand->companyName }}">
                            <div class="txt_box">
                                <p>
                                    <b>{{ $brand->subtext1 }}</b><br/>{{ $brand->subtext2 }}
                                </p>
                                <a href="/wholesaler/detail/{{ $brand->company_idx }}"><b>{{ $brand->companyName }} </b> 홈페이지 가기</a>
                            </div>
                        </li>
                        @foreach($brand->product_info as $key => $info)
                        <li class="prod_item">
                            <div class="img_box">
                                <a href="/product/detail/{{ $info['mdp_gidx'] }}"><img src="{{ $info['mdp_gimg'] }}" alt=""></a>
                                <button class="zzim_btn prd_{{ $info['mdp_gidx'] }} {{ ($brand->product_interest[$info['mdp_gidx']] == 1) ? 'active' : '' }}" pidx="{{ $info['mdp_gidx'] }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
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
                        @foreach($data['popularbrand_ad'] as $key => $brand)
                        <li class="swiper-slide"><button>{{$brand->companyName}}</button></li>
                        @endforeach
                    </ul>
                </div>
                <button class="arrow next"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
            </div>
            <div class="right_box">
                <div class="count_pager"><b>1</b> / 12</div>
                <!-- a href="javascript:;">모아보기</a //-->
            </div>
        </div>
    </section>
    @endif

    @if( count( $bannerList ) > 0 )
        <section class="sub_section nopadding">
            <div class="line_common_banner">
                <ul class="swiper-wrapper">
                    @foreach( $bannerList AS $key => $banner)
                        <?php
                            $link = '';
                            switch ($banner->web_link_type) {
                                case 0: //Url
                                    $link = $banner->web_link;
                                    break;
                                case 1: //상품
                                    $link = $banner->web_link;
                                    break;
                                case 2: //업체
                                    $link = $banner->web_link;
                                    break;
                                case 3: //커뮤니티
                                    $link = $banner->web_link;
                                    break;
                                default: //공지사항
                                    $link = '/help/notice/';
                                    break;
                            }
                        ?>
                        @if( $banner->banner_type == 'img' )
                            <li class="swiper-slide" style="background-image:url({{$banner->appBigImgUrl}}) ">
                                <a href="{{$link}}"></a>
                            </li>
                        @else
                            <li class="swiper-slide" style="color:{{$banner->font_color}};">
                                <a href="{{$link}}">
                                    <div class="txt_box">
                                        <p>{{$banner->subtext1}} <br/>{{$banner->subtext2}}</p>
                                        <span>{{$banner->content}}</span>
                                    </div>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <div class="count_pager"><b>1</b> / 12</div>
            </div>
        </section>
    @endif

    @if((count($companyList) > 0) )
    <section class="sub_section wholesaler_con03">
        <div class="inner">
            <div class="main_tit mb-5 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>이달의 도매</h3>
                </div>

            </div>
        </div>
        <div class="relative">
            <div class="slide_box overflow-hidden">
                <ul class="swiper-wrapper obtain_list type02">
                    @foreach ($companyList as $wholesaler)
                    <li class="swiper-slide">
                        <div class="txt_box">
                            <div class="flex items-center justify-between">
                                <a href="/wholesaler/detail/{{ $wholesaler->company_idx }}">
                                    <img src="/img/icon/crown.png" alt="">
                                    {{ $wholesaler->company_name }}
                                    <svg><use xlink:href="/img/icon-defs.svg#more_icon"></use></svg>
                                </a>
                                <button class="zzim_btn {{ $wholesaler->isCompanyInterest == 1 ? 'active' : '' }}" data-company-idx='{{$wholesaler->company_idx}}' onclick="toggleCompanyLike({{$wholesaler->company_idx}})"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            @php
                                $companyCategoryList = explode(',', $wholesaler->categoryList);
                            @endphp
                            @if( count( $companyCategoryList ) > 0 )
                            <div class="flex items-center justify-between">
                                <div class="tag">
                                    @foreach ( $companyCategoryList as $category )
                                        @if($loop->index == 3) @break @endif
                                        <span>{{ $category }}</span>
                                    @endforeach
                                </div>
                                <i>{{ $wholesaler->location }}</i>
                            </div>
                            @endif
                        </div>
                        <div class="prod_box">
                            @foreach ($wholesaler->productList as $product)
                            <div class="img_box">
                                <a href="/product/detail/{{ $product->productIdx }}"><img src="{{ $product->imgUrl }}" alt=""></a>
                                <button class="zzim_btn prd_{{ $product->productIdx }} {{ $product->isInterest == 1 ? 'active' : '' }}" pidx="{{ $product->productIdx }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            @endforeach
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="flex justify-center mt-4">
            <div class="count_pager"><b>1</b> / 12</div>
        </div>
    </section>
    @endif
    @if( count( $companyProduct ) > 0 )
    <section class="sub_section">
        <div class="inner">
            <div class="main_tit mb-5 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>도매 업체 순위</h3>
                </div>
            </div>
            <div class="ranking_box">
                <ul>
                @foreach( $companyProduct AS $key => $company )
                    @if( $key != 0 && $key%5 == 0 )
                </ul><ul{{( $key > 9 ) ? ' hidden' : ''}}>
                    @endif
                    <li><a href="/wholesaler/detail/{{ $company->company_idx }}">
                            <i>{{$key+1}}</i>
                            <p>{{$company->company_name}}</p>
                            <div class="tag">
                                @foreach( explode( ',', $company->categoryList ) AS $cate )
                                    @if($loop->index == 2) @break @endif
                                    <span>{{$cate}}</span>
                                @endforeach
                            </div>
                        </a>
                    </li>
                @endforeach
                </ul>
            </div>
            <div class="mt-2 text-right txt-gray fs10">{{date('Y년 m월 d일')}} 기준</div>
            @if( count( $companyProduct ) > 10 )
                <div class="mt-8 text-center ">
                    <a href="javascript:;" class="btn btn-line4">더보기 <img src="/img/icon/filter_arrow.svg" alt=""></a>
                </div>
            @endif
        </div>
    </section>
    @endif

    <section class="sub_section wholesalerListSection">
        <div class="inner">
            <div class="main_tit mb-5 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>도매 업체</h3>
                </div>
            </div>
            <div class="sub_filter">
                <div class="filter_box">
                    <button class="" onclick="modalOpen('#filter_category-modal')">카테고리 <b class="txt-primary"></b></button>
                    <button class="" onclick="modalOpen('#filter_location-modal')">소재지 <b class="txt-primary"></b></button>
                    <button class="" onclick="modalOpen('#filter_align-modal')">최신 상품 등록순</button>
                    <button class="refresh_btn">초기화 <svg><use xlink:href="/img/icon-defs.svg#refresh"></use></svg></button>
                </div>
                <div class="total">전체 0개</div>
            </div>
        </div>

        <ul class="obtain_list type02"></ul>
    </section>
</div>


<script>
    // wholesaler_con01 - pager
    const wholesaler_con01_pager = new Swiper(".wholesaler_con01 .pager_box", {
        slidesPerView: 'auto',
        spaceBetween: 10,
        navigation: {
            nextEl: ".wholesaler_con01 .bottom_box .arrow.next",
            prevEl: ".wholesaler_con01 .bottom_box .arrow.prev",
        },
    });

    // wholesaler_con01
    const wholesaler_con01 = new Swiper(".wholesaler_con01 .slide_box", {
        slidesPerView: 1,
        spaceBetween: 0,

        pagination: {
            el: ".wholesaler_con01 .count_pager",
            type: "fraction",
        },
        thumbs: {
            swiper: wholesaler_con01_pager,
        },
    });

    // line_common_banner
    const line_common_banner = new Swiper(".line_common_banner", {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 0,
        pagination: {
            el: ".line_common_banner .count_pager",
            type: "fraction",
        }
    });

    // wholesaler_con03
    const wholesaler_con03 = new Swiper(".wholesaler_con03 .slide_box", {
        slidesPerView: 1,
        spaceBetween: 20,
        pagination: {
            el: ".wholesaler_con03 .count_pager",
            type: "fraction",
        },
    });

    // 도매업체 순위 더보기 클릭
    $('a.btn-line4').on('click', function() {
        console.log('11');
        $('.ranking_box ul').show();
        $(this).hide();
    });

    // ---------- 도매 업체 --------------
    $(document).ready(function(){
        setTimeout(() => {
            loadWholesalerList();
        }, 10);
    })

    window.addEventListener('scroll', function() {
        if ((window.pageYOffset || document.documentElement.scrollTop) + window.innerHeight + 20 >= document.documentElement.scrollHeight && !isLoading && !isLastPage) {
            loadWholesalerList();
        }
    });

    let isLoading = false;
    let isLastPage = false;
    let currentPage = 0;
    function loadWholesalerList(needEmpty, target) {
        if(isLoading) return;
        if(!needEmpty && isLastPage) return;

        isLoading = true;
        if(needEmpty) currentPage = 0;

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/wholesaler/list',
            method: 'GET',
            data: {
                'page': ++currentPage,
                'categories' : getIndexesOfSelectedCategory().join(','),
                'locations' : getIndexesOfSelectedLocations().join(','),
                'orderedElement' : $("#filter_align-modal .radio-form:checked").val(),
            },
            beforeSend : function() {
                if(target) {
                    target.prop("disabled", true);
                }
            },
            success: function(result) {
                console.log(result);
                if(needEmpty) {
                    $(".wholesalerListSection .obtain_list").empty();
                }

                $(".wholesalerListSection .obtain_list").append(result.html);
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

    // 카테고리 및 소팅
    $(document).on('click', '[id^="filter"] .btn-primary', function() {
        loadWholesalerList(true, $(this))
    });

    $(".refresh_btn").on('click', function() {
        $("#filter_category-modal .check-form:checked").prop('checked', false);
        $("#filter_location-modal .check-form:checked").prop('checked', false);
        $("#filter_align-modal .radio-form").eq(1).prop('checked', true);
        
        loadWholesalerList(true);
    });


    function getIndexesOfSelectedCategory() {
        let categories = [];
        $("#filter_category-modal .check-form:checked").each(function(){
            categories.push($(this).attr('id'));
        });

        return categories;
    }

    function getIndexesOfSelectedLocations() {
        let locations = [];
        $("#filter_location-modal .check-form:checked").each(function(){
            locations.push($(this).data('location'));
        });

        return locations;
    }

    function displaySelectedCategories() {
        let totalOfSelectedCategories = $("#filter_category-modal .check-form:checked").length;
        if(totalOfSelectedCategories === 0) {
            $(".sub_filter .filter_box button").eq(0).html("카테고리");
            $(".sub_filter .filter_box button").eq(0).removeClass('on');
        } else {
            $(".sub_filter .filter_box button").eq(0).html("카테고리 <b class='txt-primary'>" + totalOfSelectedCategories + "</b>");
            $(".sub_filter .filter_box button").eq(0).addClass('on');

            $(".wholesalerListSection ul.obtain_list .sub_filter_result").show();
        }
    }

    function displaySelectedLocation() {
        let totalOfSelectedLocations = $("#filter_location-modal .check-form:checked").length;
        if(totalOfSelectedLocations === 0) {
            $(".sub_filter .filter_box button").eq(1).html("소재지");
            $(".sub_filter .filter_box button").eq(1).removeClass('on');

        } else {
            $(".sub_filter .filter_box button").eq(1).html("소재지 <b class='txt-primary'>" + totalOfSelectedLocations + "</b>");
            $(".sub_filter .filter_box button").eq(1).addClass('on');
        }
    }

    function displaySelectedOrders() {
        if($("#filter_align-modal .radio-form:checked").val() != "register_time") {
            $(".sub_filter .filter_box button").eq(2).addClass('on')         
        } else {
            $(".sub_filter .filter_box button").eq(2).removeClass('on')
        }

        $(".sub_filter .filter_box button").eq(2)
        .text($("#filter_align-modal .radio-form:checked").siblings('label').text());
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