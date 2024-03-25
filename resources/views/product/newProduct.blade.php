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
                                        <b>{{ number_format($banner->price, 0) }}원</b>
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
    @php $product = $list @endphp
    @include('product.new-product-ext')
</div>

<script>
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
    });

    const filterRemove = (item)=>{
        //해당 버튼 삭제
        $(item).parents('span').remove();

        //모달 안 체크박스에서 check 해제
        $("#" + $(item).data('id')).prop('checked', false);

        //데이터 불러오기
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/product/newAddedProduct',
            type : 'GET',
            data : {
                'categories' : getIndexesOfSelectedCategory().join(','),
                'locations' : getIndexesOfSelectedLocation().join(','),
                'orderedElement' : $('input[name="filter_cate_3"]:checked').attr('id'),
            },
            success: function (result) {

                displayNewProducts(result['data'], $(".sub_section_bot .prod_list"), true);
                displayNewProductsOnModal(result['data'], zoom_view_modal_new, true);
                $(".total").text('전체 ' + result['total'].toLocaleString('ko-KR') + '개');
                
                isLastPage = currentPage === result.last_page;
            },
            complete : function () {
                displaySelectedCategories();
                displaySelectedLocation();
                toggleFilterBox();
                displaySelectedOrders();
                currentPage = 1;
            }
        });
    }

    $(window).scroll(function() {
        if ($(window).scrollTop() + $(window).height() + 20 >= $(document).height() && !isLoading && !isLastPage) {
            loadNewProductList();
        }
    });

    let isLoading = false;
    let isLastPage = false;
    let currentPage = 1;
    function loadNewProductList() {
        isLoading = true;

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/product/newAddedProduct',
            method: 'GET',
            data: { 
                'page': ++currentPage,
                'categories' : getIndexesOfSelectedCategory().join(','),
                'locations' : getIndexesOfSelectedLocation().join(','),
                'orderedElement' : $('input[name="filter_cate_3"]:checked').attr('id'),
            }, 
            success: function(result) {

                displayNewProducts(result['data'], $(".sub_section_bot .prod_list"), false);
                displayNewProductsOnModal(result['data'], zoom_view_modal_new, false);        
                
                isLastPage = currentPage === result.last_page;
            }, 
            complete : function () {
                isLoading = false;
            }
        })
    }

    // 신규 등록 상품 카테고리
    $(document).on('click', '[id^="filter"] .btn-primary', function() { 
        let $this = $(this);

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/product/newAddedProduct',
            type : 'GET',
            data : {
                'categories' : getIndexesOfSelectedCategory().join(','),
                'locations' : getIndexesOfSelectedLocation().join(','),
                'orderedElement' : $('input[name="filter_cate_3"]:checked').attr('id'),
            },
            beforeSend : function() {
                $this.prop("disabled", true);
            },
            success: function (result) {
                
                displayNewProducts(result['data'], $(".sub_section_bot .prod_list"), true);
                displayNewProductsOnModal(result['data'], zoom_view_modal_new, true);
                $(".total").text('전체 ' + result['total'].toLocaleString('ko-KR') + '개');
                
                isLastPage = currentPage === result.last_page;
                
            }, 
            complete : function () {
                $this.prop("disabled", false);
                displaySelectedCategories();
                displaySelectedLocation();
                toggleFilterBox();
                displaySelectedOrders();
                modalClose('#' + $this.parents('[id^="filter"]').attr('id'));
                currentPage = 1;
            }
        });
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

    function displayNewProducts(productArr, target, needsEmptying) {
        if(needsEmptying) {
            target.empty();
        }

        productArr.forEach(function(product, index) {
            target.append(  '<li class="prod_item">'+
                            '   <div class="img_box">'+
                            '       <a href="/product/detail/'+ product['idx'] + '"><img src="' + product['imgUrl'] + '" alt=""></a>'+
                            '       <button class="zzim_btn prd_' + product['idx'] + (product['isInterest'] === 1 ? ' active': '') + '" pidx="' + product['idx'] + '"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>'+
                            '   </div>'+
                            '   <div class="txt_box">'+
                            '       <a href="/product/detail/' + product['idx'] + '">'+
                            '           <span>' + product['companyName'] +'</span>'+
                            '           <p>' + product['name']+'</p>'+
                            '           <b>' + product['price'].toLocaleString('ko-KR') + '원</b>'+
                            '       </a>'+
                            '   </div>'+
                            '</li>'
            );
        });
    };

    function displayNewProductsOnModal(productArr, target, needsEmptying) {
        if(needsEmptying) {
            target.removeAllSlides();
        }

        productArr.forEach(function(product, index) {
            target.appendSlide( '<li class="swiper-slide">' +
                                '   <div class="img_box">' +
                                '       <img src="'+ product['imgUrl'] +'" alt="">' +
                                '       <button class="zzim_btn prd_' + product['idx'] + (product['isInterest'] === 1 ? ' active': '') + '" pidx="' + product['idx'] + '"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>' +
                                '   </div>' +
                                '   <div class="txt_box">' +
                                '       <div>' +
                                '           <h5>' + product['companyName'] +'</h5>' +
                                '           <p>' + product['name']+'</p>' +
                                '           <b>' + product['price'].toLocaleString('ko-KR') + '원</b>' +
                                '       </div>' +
                                '       <a href="/product/detail/' + product['idx'] + '">제품상세보기</a>' +
                                '   </div>' +
                                '</li>'
            );
        });
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
            .text($("label[for='" + $("#filter_align-modal .radio-form:checked").attr('id') + "']").text());
    }

    //초기화
    $(".refresh_btn").on('click', function() {
        $("#filter_category-modal .check-form:checked").prop('checked', false);
        $("#filter_location-modal .check-form:checked").prop('checked', false);
        $("#filter_align-modal .radio-form").eq(0).prop('checked', true);
        displaySelectedCategories();
        displaySelectedLocation();
        displaySelectedOrders();
        toggleFilterBox();

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/product/newAddedProduct',
            type : 'GET',
            data : {
                'categories' : getIndexesOfSelectedCategory().join(','),
                'locations' : getIndexesOfSelectedLocation().join(','),
                'orderedElement' : $('input[name="filter_cate_3"]:checked').attr('id'),
            },
            success: function (result) {

                displayNewProducts(result['data'], $(".sub_section_bot .prod_list"), true);
                displayNewProductsOnModal(result['data'], zoom_view_modal_new, true);
                $(".total").text('전체 ' + result['total'].toLocaleString('ko-KR') + '개');
                
                isLastPage = currentPage === result.last_page;
                
            }, 
            complete : function () {
                currentPage = 1;
            }
        });
    });
</script>
@endsection