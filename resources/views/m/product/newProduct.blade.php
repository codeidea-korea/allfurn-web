@extends('layouts.app_m')
@php
    $only_quick = '';
    $header_depth = 'new_arrival';
    $top_title = '';
    $header_banner = '';
@endphp
@section('content')
@include('layouts.header_m')

<div id="content">
    <section class="sub_section new_arrival_con01 overflow-hidden">
        <div class="inner">
            <div class="relative">
                <div class="slide_box">
                    <ul class="swiper-wrapper">
                        @if(isset($banners))
                            @foreach($banners as $banner)
                                <li class="swiper-slide prod_item type03">
                                    <div class="img_box">
                                        <a href="/product/detail/{{ $banner->idx }}"><img src="{{ $banner->imgUrl }}" alt=""></a>
                                        <button class="zzim_btn prd_{{ $banner->idx }} {{ ($banner->isInterest == 1) ? 'active' : '' }}" pidx="{{ $banner->idx }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                    </div>
                                    <div class="txt_box">
                                        <a href="/product/detail/{{ $banner->idx }}">
                                            <strong>{{ $banner->content }}</strong>
                                            <span>{{ $banner->companyName }}</span>
                                            <p>{{ $banner->name }}</p>
                                            <b>{{$banner->is_price_open ? number_format($banner->price, 0).'원': $banner->price_text}}</b>
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            {{-- <a href="javascript:;" class="btn btn-line4 mt-4">더보기</a> --}}
        </div>
    </section>
    {{-- BEST 신상품 --}}
    @include('m.product.inc-best-new-product')
    {{-- BEST 신상품 : 확대보기 --}}
    @include('m.product.best-new-product-ext')

    {{-- 신규 상품 등록 업체 --}}
    @include('m.product.inc-new-product-company')

    {{-- 신규 등록 상품 --}}
    @include('m.product.inc-new-product')
    {{-- 신규 등록 상품 : 확대보기 --}}
    @include('m.product.new-product-ext')

</div>
<script>
    /**** swiper 관련 script ****/

    // new_arrival_con01 
    const new_arrival_con01 = new Swiper(".new_arrival_con01 .slide_box", {
        slidesPerView: 1.2,
        spaceBetween: 17,
    });

    // best_prod 
    const best_prod = new Swiper(".best_prod .slide_box", {
        slidesPerView: 'auto',
        spaceBetween: 8,
        grid: {
            rows: 2,
        }
    });

    // new_arrival_con03 
    const new_arrival_con03 = new Swiper(".new_arrival_con03 .slide_box", {
        slidesPerView: 'auto',
        spaceBetween: 8,
        speed:8000,
        loop:true,
        autoplay: {
            delay: 0,
            stopOnLastSlide: false,
            disableOnInteraction: true,
        },
        observer:true, observeParents:true,
    });

    // BEST 신상품 - 확대보기
    const zoom_prod_list = new Swiper("#zoom_view-modal .slide_box", {
        slidesPerView: 1,
        spaceBetween: 30,
        navigation: {
            nextEl: "#zoom_view-modal .arrow.next",
            prevEl: "#zoom_view-modal .arrow.prev",
        },
        pagination: {
            el: "#zoom_view-modal.count_pager",
            type: "fraction",
        },
    });

    // 신규 등록 상품 - 확대보기
    const zoom_view_modal_new = new Swiper("#zoom_view-modal-new .slide_box", {
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
                if (this.isEnd && !isLoading && !isLastPage) {
                    loadNewProductList();
                }
            },
        },
    });

    /* ----------------------------- */
    $(document).ready(function(){
        setTimeout(() => {
            loadNewProductList();
            $("#filter_location-modal .btn-primary").text('상품 찾아보기');
        }, 50);
    })

    window.addEventListener('scroll', function() {
        if ((window.pageYOffset || document.documentElement.scrollTop) + window.innerHeight + 300 >= document.documentElement.scrollHeight && !isLoading && !isLastPage) {
            loadNewProductList();
        }
    });

    let isLoading = false;
    let isLastPage = false;
    let currentPage = 0;
    let firstLoad = true;
    let preCpage = '';
    function loadNewProductList(needEmpty, target) {
        if(isLoading) return;
        if(!needEmpty && isLastPage) return;
        
        isLoading = true;

        if(needEmpty) currentPage = 0;

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/product/newAddedProduct',
            method: 'GET',
            data: { 
                'page': ++currentPage,
                'categories' : getIndexesOfSelectedCategory().join(','),
                'locations' : getIndexesOfSelectedLocation().join(','),
                'orderedElement' : $("#filter_align-modal03 .radio-form:checked").val(), 
                'prevCpage' : preCpage,
            },
            beforeSend : function() {
                if(target) {
                    target.prop("disabled", true);
                }
            },
            success: function(result) {
                
                if(needEmpty) {
                    $(".prod_list").empty();
                    zoom_view_modal_new.removeAllSlides();
                    zoom_view_modal_new.slideTo(0);
                }
                
                $(".prod_list").append(result.data.html);
                zoom_view_modal_new.appendSlide(result.data.modalHtml);

                $(".total").text('전체 ' + result.total.toLocaleString('ko-KR') + '개');

                if(target) {
                    target.prop("disabled", false);
                    modalClose('#' + target.parents('[id^="filter"]').attr('id'));
                }     
                
                isLastPage = currentPage === result.last_page;
            }, 
            complete : function () {
                displaySelectedCategories();
                displaySelectedLocation();
                displaySelectedOrders();
                isLoading = false;
                if(firstLoad && new URLSearchParams(window.location.search).get("scroll")=="true") {
                    window.scrollTo(0, 1430);
                    firstLoad = false;
                }
            }
        })
    }

    // 필터링으로 신규등록 상품 조회
    $(document).on('click', '[id^="filter"] .btn-primary', function() { 
        loadNewProductList(true, $(this));
    });

    //초기화
    $(".refresh_btn").on('click', function() {
        $("#filter_category-modal .check-form:checked").prop('checked', false);
        $("#filter_location-modal .check-form:checked").prop('checked', false);
        $("#filter_align-modal03 .radio-form").eq(0).prop('checked', true);
        
        loadNewProductList(true);
    });

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
        if($("#filter_align-modal03 .radio-form:checked").val() != "register_time") {
            $(".sub_filter .filter_box button").eq(2).addClass('on')         
        } else {
            $(".sub_filter .filter_box button").eq(2).removeClass('on')
        }

        $(".sub_filter .filter_box button").eq(2)
        .text($("#filter_align-modal03 .radio-form:checked").siblings('label').text());
    }
</script>
@endsection