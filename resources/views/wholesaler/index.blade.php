@extends('layouts.app')

@section('content')
@include('layouts.header')
<div id="content">
    <section class="sub_section sub_section_top wholesaler_con01">
        <div class="inner">

            {{-- 상단 인기브랜드 --}}
            @include('wholesaler.inc-popular-brand')
        </div>
    </section>

    @if( count( $bannerList ) > 0 )
    <section class="sub_section nopadding">
        <div class="inner">
            <div class="line_common_banner">
                <ul class="swiper-wrapper">
                    @foreach( $bannerList AS $key => $banner )
                    <li class="swiper-slide" style="background-color:{{$banner->bg_color}}; ">
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
                            <a href="{{$link}}" class="!p-0">
                                <img src="{{$banner->imgUrl}}" alt="">
                            </a>
                        @else
                            <a href="{{$link}}">
                                <div class="txt_box" style="color:{{$banner->font_color}}">
                                    <p>{{$banner->subtext1}} <br/>{{$banner->subtext2}}</p>
                                    <span>{{$banner->content}}</span>
                                </div>
                            </a>
                        @endif
                    </li>
                    @endforeach
                </ul>
                <div class="count_pager"><b>1</b> / 12</div>
                <button class="slide_arrow prev type03"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow_white"></use></svg></button>
                <button class="slide_arrow next type03"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow_white"></use></svg></button>
            </div>
        </div>
    </section>
    @endif

    @if((count($companyList) > 0) )
    <section class="sub_section wholesaler_con03">
        <div class="inner">
            <div class="main_tit mb-8 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>이달의 도매</h3>
                </div>
                <div class="flex items-center gap-7">
                    <div class="count_pager"><b>1</b> / 12</div>
                    <a class="more_btn flex items-center" href="/wholesaler/thismonth">더보기<svg><use xlink:href="/img/icon-defs.svg#more_icon"></use></svg></a>
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
                                    <div class="flex items-center justify-between">
                                        <div class="tag">
                                            @php
                                                $companyCategoryList = explode(',', $wholesaler->categoryList);
                                            @endphp
                                            @foreach ( $companyCategoryList as $category )
                                                @if($loop->index == 3) @break @endif
                                                <span>{{ $category }}</span>
                                            @endforeach
                                        </div>
                                        <i class="shrink-0">{{ $wholesaler->location }}</i>
                                    </div>
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
                <button class="slide_arrow prev"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
                <button class="slide_arrow next"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
            </div>
        </div>
    </section>
    @endif

    @if( count( $companyProduct ) > 0 )
        <section class="sub_section">
            <div class="inner">
                <div class="main_tit mb-8 flex justify-between items-center">
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
                        <li><a href="javascript:;">
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
                @if( count( $companyProduct ) > 10 )
                    <div class="mt-8 text-center ">
                        <a href="javascript:;" class="flex items-center justify-center">더보기 <img src="/img/icon/filter_arrow.svg" alt=""></a>
                    </div>
                @endif
            </div>
        </section>
    @endif

    <section class="sub_section sub_section_bot">
        <div class="inner">
            <div class="main_tit mb-8 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>도매 업체</h3>
                </div>
            </div>
            <div class="sub_filter">
                <div class="filter_box">
                    <button class="" onclick="modalOpen('#filter_category-modal')">카테고리 <b class="txt-primary"></b></button>
                    <button class="" onclick="modalOpen('#filter_location-modal')">소재지 <b class="txt-primary"></b></button>
                    <button onclick="modalOpen('#filter_align-modal')">추천순</button>
                </div>
                <div class="total">전체 0개</div>
            </div>
            <div class="sub_filter_result" hidden>
                <div class="filter_on_box">
                    <div class="category"></div>
                    <div class="location"></div>
                </div>
                <button class="refresh_btn">초기화 <svg><use xlink:href="/img/icon-defs.svg#refresh"></use></svg></button>
            </div>
            <ul class="obtain_list"></ul>
        </div>
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
        navigation: {
            nextEl: ".wholesaler_con01 .slide_arrow.next",
            prevEl: ".wholesaler_con01 .slide_arrow.prev",
        },
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
        slidesPerView: 1,
        spaceBetween: 0,
        navigation: {
            nextEl: ".line_common_banner .slide_arrow.next",
            prevEl: ".line_common_banner .slide_arrow.prev",
        },
        pagination: {
            el: ".line_common_banner .count_pager",
            type: "fraction",
        }
    });

    // wholesaler_con03
    const wholesaler_con03 = new Swiper(".wholesaler_con03 .slide_box", {
        slidesPerView: 2,
        spaceBetween: 20,
        slidesPerGroup: 2,
        navigation: {
            nextEl: ".wholesaler_con03 .slide_arrow.next",
            prevEl: ".wholesaler_con03 .slide_arrow.prev",
        },
        pagination: {
            el: ".wholesaler_con03 .count_pager",
            type: "fraction",
        },
    });

    // zoom_prod_list
    const zoom_prod_list = new Swiper(".zoom_prod_list", {
        slidesPerView: 1,
        spaceBetween: 120,
        navigation: {
            nextEl: ".zoom_view_wrap .slide_arrow.next",
            prevEl: ".zoom_view_wrap .slide_arrow.prev",
        },
        pagination: {
            el: ".zoom_view_wrap .count_pager",
            type: "fraction",
        },
    });
    
    // 도매업체 순위 더보기 클릭
    $('.ranking_box').next('div').find('a').on('click', function() {
        $('.ranking_box > ul').show();
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
        isLoading = true;
        if(needEmpty) currentPage = 0;;

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
                    $(".sub_section_bot .obtain_list").empty();
                }

                $(".sub_section_bot .obtain_list").append(result.html);
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
                toggleFilterBox();
                isLoading = false;
            }
        })
    }

    // 카테고리 및 소팅
    $(document).on('click', '[id^="filter"] .btn-primary', function() {
        loadWholesalerList(true, $(this))
    });

    const filterRemove = (item)=>{
        $(item).parents('span').remove(); //해당 카테고리 삭제
        $("#" + $(item).data('id')).prop('checked', false);//모달 안 체크박스에서 check 해제

        loadWholesalerList(true);
    }

    $(".refresh_btn").on('click', function() {
        $("#filter_category-modal .check-form:checked").prop('checked', false);
        $("#filter_location-modal .check-form:checked").prop('checked', false);
        $("#filter_align-modal .radio-form").eq(0).prop('checked', true);
        
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

        let html = "";
        $("#filter_category-modal .check-form:checked").each(function(){
            html += "<span>" + $('label[for="' + $(this).attr('id') + '"]').text() +
                "   <button data-id='"+ $(this).attr('id') +"' onclick=\"filterRemove(this)\"><svg><use xlink:href=\"/img/icon-defs.svg#x\"></use></svg></button>" +
                "</span>";
        });
        $(".filter_on_box .category").empty().append(html);

        let totalOfSelectedCategories = $("#filter_category-modal .check-form:checked").length;
        if(totalOfSelectedCategories === 0) {
            $(".sub_filter .filter_box button").eq(0).html("카테고리");
            $(".sub_filter .filter_box button").eq(0).removeClass('on');
        } else {
            $(".sub_filter .filter_box button").eq(0).html("카테고리 <b class='txt-primary'>" + totalOfSelectedCategories + "</b>");
            $(".sub_filter .filter_box button").eq(0).addClass('on');

            $(".sub_section_bot ul.obtain_list .sub_filter_result").show();
        }
    }

    function displaySelectedLocation() {
        let html = "";

        $("#filter_location-modal .check-form:checked").each(function() {
            html += '<span>'+ $(this).data('location') +
                '   <button data-id="'+ $(this).attr('id') +'" onclick="filterRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button>' +
                '</span>';                    "</span>";
        });
        $(".filter_on_box .location").empty().append(html);

        let totalOfSelectedLocations = $("#filter_location-modal .check-form:checked").length;
        if(totalOfSelectedLocations === 0) {
            $(".sub_filter .filter_box button").eq(1).html("소재지");
            $(".sub_filter .filter_box button").eq(1).removeClass('on');

        } else {
            $(".sub_filter .filter_box button").eq(1).html("소재지 <b class='txt-primary'>" + totalOfSelectedLocations + "</b>");
            $(".sub_filter .filter_box button").eq(1).addClass('on');
        }
    }

    function toggleFilterBox() {
        if($(".modal .check-form:checked").length === 0){
            $(".sub_filter_result").hide();
        } else {
            $(".sub_filter_result").css('display', 'flex');
        }
    }

    function displaySelectedOrders() {
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
