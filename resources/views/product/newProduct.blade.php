@extends('layouts.app')

@section('content')
@include('layouts.header')

<div id="content">
    <section class="sub_section sub_section_top new_arrival_con01">
        <div class="inner">
            <div class="relative">
                <div class="slide_box overflow-hidden">
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
                <button class="slide_arrow prev"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
                <button class="slide_arrow next"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
                <div class="count_pager"><b>1</b> / 12</div>
            </div>
        </div>
    </section>
    {{-- BEST 신상품 --}}
    @include('product.inc-best-new-product')
    @include('product.best-new-product-ext')

    {{-- 신규 상품 등록 업체 --}}
    @include('product.inc-new-product-company')

    {{-- 신규 등록 상품 --}}
    @include('product.inc-new-product')
    @include('product.new-product-ext')
</div>

<script>
    /**** swiper 관련 script ****/

    // new_arrival_con01 
    const new_arrival_con01 = new Swiper(".new_arrival_con01 .slide_box", {
        slidesPerView: 3,
        spaceBetween: 20,
        slidesPerGroup: 3,
        navigation: {
            nextEl: ".new_arrival_con01 .slide_arrow.next",
            prevEl: ".new_arrival_con01 .slide_arrow.prev",
        },
        pagination: {
            el: ".new_arrival_con01 .count_pager",
            type: "fraction",
        },
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

    // new_arrival_con03 
    const new_arrival_con03 = new Swiper(".new_arrival_con03 .slide_box", {
        slidesPerView: 4.5,
        spaceBetween: 20,
        navigation: {
            nextEl: ".new_arrival_con03 .slide_arrow.next",
            prevEl: ".new_arrival_con03 .slide_arrow.prev",
        },
        speed:8000,
        loop:true,
        autoplay: {
            delay: 0,
            stopOnLastSlide: false,
            disableOnInteraction: true,
        },
        observer:true, observeParents:true,
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
                if (this.isEnd && !isLastPage) {
                    $("#zoom_view-modal-new .slide_arrow.more_btn").show();
                } else {
                    $("#zoom_view-modal-new .slide_arrow.more_btn").hide();
                }
            },
        },
    });

    /* ----------------------------- */
    $(document).ready(function(){
        setTimeout(() => {
            loadNewProductList();
        }, 50);
    })

    window.addEventListener('scroll', function() {
        if ((window.pageYOffset || document.documentElement.scrollTop) + window.innerHeight + 20 >= document.documentElement.scrollHeight && !isLoading && !isLastPage) {
            loadNewProductList();
        }
    });

    let isLoading = false;
    let isLastPage = false;
    let currentPage = 0;
    let firstLoad = true;
    function loadNewProductList(needEmpty, target) {
        if(isLoading) return;
        if(!needEmpty && isLastPage) return;

        $("#zoom_view-modal-new .slide_arrow.more_btn").hide();
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
                toggleFilterBox();
                isLoading = false;
                if(firstLoad && new URLSearchParams(window.location.search).get("scroll")=="true") {
                    window.scrollTo(0, 2100);
                    firstLoad = false;
                }
            }
        })
    }

    // 신규 등록 상품 - 카테고리 선택
    $(document).on('click', '[id^="filter"] .btn-primary', function() { 
        loadNewProductList(true, $(this));
    });

    // 신규 등록 상품 - 카테고리 삭제
    const filterRemove = (item)=>{
        $(item).parents('span').remove(); //해당 카테고리 삭제
        $("#" + $(item).data('id')).prop('checked', false);//모달 안 체크박스에서 check 해제

        loadNewProductList(true);
    }

    const orderRemove = (item)=> {
        $(item).parents('span').remove(); //해당 카테고리 삭제
        $("#filter_align-modal03 .radio-form").eq(0).prop('checked', true);

        loadNewProductList(true);
    }

     // 초기화
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
        
        let html = "";  
        $("#filter_category-modal .check-form:checked").each(function(){
            html += "<span>" + $('label[for="' + $(this).attr('id') + '"]').text() + 
                    "   <button data-id='"+ $(this).attr('id') +"' onclick=\"filterRemove(this)\"><svg><use xlink:href=\"/img/icon-defs.svg#x\"></use></svg></button>" +
                    "</span>";
        });
        $(".filter_on_box .category").empty().append(html);

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
        let html = "";

        $("#filter_location-modal .check-form:checked").each(function() {
            html += '<span>'+ $(this).data('location') + 
                    '   <button data-id="'+ $(this).attr('id') +'" onclick="filterRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button>' +
                    '</span>';
        });
        $(".filter_on_box .location").empty().append(html);

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
            $(".filter_on_box .order").empty().append(
                '<span>'+ $("#filter_align-modal03 .radio-form:checked").siblings('label').text() + 
                '   <button data-id="'+ $(this).attr('id') +'" onclick="orderRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button>' +
                '</span>'
            );   
            $(".sub_filter .filter_box button").eq(2).addClass('on')         
        } else {
            $(".sub_filter .filter_box button").eq(2).removeClass('on')
        }
        
        $(".sub_filter .filter_box button").eq(2)
            .text($("#filter_align-modal03 .radio-form:checked").siblings('label').text());
    }

    function toggleFilterBox() {
        if($(".modal .check-form:checked").length === 0 && $("#filter_align-modal03 .radio-form:checked").val() == "register_time"){
            $(".sub_filter_result").hide();
        } else {
            $(".sub_filter_result").css('display', 'flex');
        }
    }
</script>
@endsection