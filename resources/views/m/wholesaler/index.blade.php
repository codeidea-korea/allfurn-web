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
                                <button class="zzim_btn prd_{{ $info['mdp_gidx'] }} {{ ($brand->product_interest[$info['mdp_gidx']] == 1) ? 'active' : '' }}" pidx="{{ $info['mdp_gidx'] }}"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
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
                <button class="arrow prev"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
                <div class="pager_box overflow-hidden">
                    <ul class="swiper-wrapper">
                        @foreach($data['popularbrand_ad'] as $key => $brand)
                        <li class="swiper-slide"><button>{{$brand->companyName}}</button></li>
                        @endforeach
                    </ul>
                </div>
                <button class="arrow next"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
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
                <li class="swiper-slide" style="background-color:#475872; ">
                <?php
                    $link = '';
                    switch ($banner->web_link_type) {
                        case 0: //Url
                            $link = $banner->web_link;
                            break;
                        case 1: //상품
                            $link = '/product/detail/'.$banner->web_link;
                            break;
                        case 2: //업체
                            $link = '/wholesaler/detail/'.$banner->web_link;
                            break;
                        case 3: //커뮤니티
                            $link = $banner->web_link;
                            break;
                        default: //공지사항
                            $link = '/help/notice/';
                            break;
                    }
                ?>
                    <a href="{{$link}}">
                    @if( $banner->banner_type == 'img' )
                        <img src="{{$banner->imgUrl}}" alt="">
                    @else
                        <div class="txt_box" style="color:{{$banner->font_color}}">
                            <p>{{$banner->subtext1}} <br/>{{$banner->subtext2}}</p>
                            <span>{{$banner->content}}</span>
                        </div>
                    @endif
                    </a>
                </li>
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
                                <button class="zzim_btn {{ $wholesaler->isCompanyInterest == 1 ? 'active' : '' }}" data-company-idx='{{$wholesaler->company_idx}}' onclick="toggleCompanyLike({{$wholesaler->company_idx}})"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            @php
                                $companyCategoryList = explode(',', $wholesaler->categoryList);
                            @endphp
                            @if( count( $companyCategoryList ) > 0 )
                            <div class="flex items-center justify-between">
                                <div class="tag">
                                    @foreach ( $companyCategoryList as $category )
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
                    <li><a href="javascript:;">
                            <i>{{$key+1}}</i>
                            <p>{{$company->company_name}}</p>
                            <div class="tag">
                                @foreach( explode( ',', $company->categoryList ) AS $cate )
                                    <span>{{$cate}}</span>
                                @endforeach
                            </div>
                        </a>
                    </li>
                @endforeach
                </ul>
            </div>
            <div class="mt-2 text-right txt-gray fs10">{{date('Y년 m월 d일')}} 기준</div>
            <div class="mt-8 text-center ">
                <a href="javascript:;" class="btn btn-line4">더보기 <img src="./img/icon/filter_arrow.svg" alt=""></a>
            </div>
        </div>
    </section>
    @endif

    @if( count( $companyProduct ) > 0 )
    <section class="sub_section">
        <div class="inner">
            <div class="main_tit mb-5 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>도매 업체</h3>
                </div>
            </div>
            <div class="sub_filter">
                <div class="filter_box">
                    <button onclick="modalOpen('#filter_category-modal')">카테고리</button>
                    <button onclick="modalOpen('#filter_location-modal')">소재지</button>
                    <button onclick="modalOpen('#filter_align-modal')">최신 상품 등록순</button>
                </div>
                <div class="total">전체 {{number_format( count( $companyProduct ) )}}개</div>
            </div>
        </div>

        <ul class="obtain_list type02">
            @foreach( $companyProduct as $key => $product )
            @php if( $key > 2 ) continue;@endphp
            <li>
                <div class="txt_box">
                    <div class="flex items-center justify-between">
                        <a href="/wholesaler/detail/{{$product->company_idx}}">
                            <img src="/img/icon/crown.png" alt="">
                            {{$product->company_name}}
                            <svg><use xlink:href="./img/icon-defs.svg#more_icon"></use></svg>
                        </a>
                        <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="tag">
                            @foreach( explode( ',', $product->categoryList ) AS $cate )
                                <span>{{$cate}}</span>
                            @endforeach
                        </div>
                        <i>{{$product->location}}</i>
                    </div>
                </div>
                @if( !empty( $product->productList ) )
                <div class="prod_box">
                    @foreach( $product->productList AS $key => $url )
                    @php if( $key > 2 ) continue; @endphp
                    <div class="img_box">
                        <a href="/product/detail/{{$url->productIdx}}"><img src="{{$url->imgUrl}}" alt=""></a>
                        <button class="zzim_btn prd_{{ $url->productIdx }} {{ $url->isInterest == 1 ? 'active' : '' }}" pidx="{{ $url->productIdx }}"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                    </div>
                    @endforeach
                </div>
                @endif
            </li>
            @endforeach
        </ul>
    </section>
    @endif
</div>

<script>
    let isLoading = false;
    let isLastPage = false;
    let currentPage = 1;

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

    // 카테고리 및 소팅
    $(document)
        .on('click', '[id^="filter"] .btn-primary', function() {
            let $this = $(this);

            var data = {
                'categories' : getIndexesOfSelectedCategory().join(','),
                'locations' : getIndexesOfSelectedLocations().join(','),
                'orderedElement' : $('input[name="filter_cate_3"]:checked').attr('id')
            };

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '/product/getJsonThisBestWholesaler',
                data : data,
                type : 'GET',
                beforeSend : function() {
                    $this.prop("disabled", true);
                },
                success: function (result) {
                    displayNewWholesaler(result.query, $(".sub_section_bot ul.obtain_list"), true);
                    //displayNewProductsOnModal(result['data'], zoom_view_modal_new, true);
                    $(".total").text('전체 ' + result.total_count + '개');
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
        })
    ;

    function loadNewProductList() {
        isLoading = true;

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/product/getJsonThisBestWholesaler',
            method: 'GET',
            data: {
                'page': ++currentPage,
                'categories' : getIndexesOfSelectedCategory().join(','),
                'locations' : getIndexesOfSelectedLocations().join(','),
                'orderedElement' : $('input[name="filter_cate_3"]:checked').attr('id'),
            },
            success: function(result) {

                displayNewWholesaler(result.query, $(".sub_section ul.obtain_list"), false);

                isLastPage = currentPage === result.last_page;
            },
            complete : function () {
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

    function getIndexesOfSelectedLocations() {
        let locations = [];
        $("#filter_location-modal .check-form:checked").each(function(){
            locations.push($(this).data('location'));
        });

        return locations;
    }

    function displayNewWholesaler(productArr, target, needsEmptying) {
        if(needsEmptying) {
            target.empty();
        }

        let html = '';
        productArr.forEach(function(product, index) {

            html += '' +
                '<li>' +
                '   <div class="txt_box">' +
                '       <div class="flex items-center justify-between">' +
                '           <a href="/wholesaler/detail/' + product.idx + '">' +
                '               <img src="/img/icon/crown.png" alt="">' + product.company_name +
                '               <svg><use xlink:href="./img/icon-defs.svg#more_icon"></use></svg>' +
                '           </a>' +
                '           <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>' +
                '       </div>' +
                '       <div class="flex items-center justify-between">' +
                '           <div class="tag">';

            product.categoryList.split(',').forEach(function(cate) {
                html += '<span>' + cate + '</span>';
            });

            html += '' +
                '           </div>' +
                '           <i>' + product.location + '</i>' +
                '       </div>' +
                '   </div>' +
                '   <div class="prod_box">';

            product.productList.forEach(function(img) {
                var interst = '';
                if( img.isInterest == 1 ) {
                    interst = 'active';
                }
            html += '' +
                '       <div class="img_box">' +
                '           <a href="/product/detail/' + img.productIdx + '"><img src="' + img.imgUrl + '" alt=""></a>' +
                '           <button class="zzim_btn prd_' + img.productIdx + ' ' + interst + '" pIdx="' + img.productIdx + '"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>' +
                '       </div>';
            });

            html += '' +
                '   </div>' +
                '</li>';
        });

        target.append(html);
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

    window.addEventListener('scroll', function() {
        if ((window.pageYOffset || document.documentElement.scrollTop) + window.innerHeight + 20 >= document.documentElement.scrollHeight && !isLoading && !isLastPage) {
            loadNewProductList();
        }
    });
</script>
@endsection