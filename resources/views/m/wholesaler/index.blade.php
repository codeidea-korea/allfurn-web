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
                            <img src="{{$brand->appBigImgUrl}}" alt="{{ $brand->companyName }}">
                            <div class="txt_box">
                                    <p>
                                        <b>{{$brand->subtext1 == '' ? ' ' : $brand->subtext1}}</b><br/>{{$brand->subtext2 == '' ? ' ' : $brand->subtext2}}
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
                <a href="/wholesaler/gather">모아보기</a>
            </div>
        </div>
    </section>
    @endif

    @if( count( $bannerList ) > 0 )
        <section class="sub_section nopadding">
            <div class="line_common_banner slide_box overflow-hidden">
                <div class="swiper-wrapper">
                    @foreach( $bannerList AS $key => $banner)
                    <ul class="swiper-slide">
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
                            <li style="background-image:url({{$banner->appBigImgUrl}}) " onclick="location.href='{{$link}}'">
                                <a href="{{$link}}"></a>
                            </li>
                        @else
                            <li style="color:{{$banner->font_color}};" onclick="location.href='{{$link}}'">
                                <a href="{{$link}}">
                                    <div class="txt_box">
                                        <p>{{$banner->subtext1}} <br/>{{$banner->subtext2}}</p>
                                        <span>{{$banner->content}}</span>
                                    </div>
                                </a>
                            </li>
                        @endif
                        </ul>
                    @endforeach
                </div>
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
                                    @if($wholesaler->rank <= 20)
                                        <img src="/img/icon/crown.png" alt="">
                                    @endif
                                    {{ $wholesaler->company_name }}
                                    <svg><use xlink:href="/img/icon-defs.svg#more_icon"></use></svg>
                                </a>
                                <button class="zzim_btn {{ $wholesaler->isCompanyInterest == 1 ? 'active' : '' }}" data-company-idx='{{$wholesaler->company_idx}}' onclick="toggleCompanyLike({{$wholesaler->company_idx}})"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            @if( count( $wholesaler->categoryList ) > 0 )
                            <div class="flex items-center justify-between">
                                <div class="tag">
                                    @foreach ( $wholesaler->categoryList as $category )
                                        @if($loop->index == 3) @break @endif
                                        <span>{{ $category->name }}</span>
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
                                @foreach( $company->categoryList AS $cate )
                                    @if($loop->index == 1) @break @endif
                                    <span>{{$cate->name}}</span>
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

    <section class="sub_section wholesalerListSection" id="wholesalerList">
        <div class="inner">
            <div class="main_tit mb-5 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>도매 업체</h3>
                </div>
            </div>
            <div class="category_banner pb-3">
                <div class="slide_box overflow-hidden">
                    <ul class="swiper-wrapper">
                        @if(isset($categoryList) != '')
                            @foreach($categoryList as $category)
                                <li class="swiper-slide" >
                                    <a href="javascript:selectCategory({{$category->idx}});">
                                        <i><img src="{{$category->imgUrl}}"></i>
                                        <span>{{$category->name}}</span>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="sub_filter">
                <div class="filter_box">
<!--                    <button class="" onclick="modalOpen('#filter_category-modal')">카테고리 <b class="txt-primary"></b></button>-->
                    <button class="" onclick="modalOpen('#filter_location-modal')">소재지 <b class="txt-primary"></b></button>
                    <button class="" onclick="modalOpen('#filter_align-modal')">최신 상품 등록순</button>
                    <button class="refresh_btn">초기화 <svg><use xlink:href="/img/icon-defs.svg#refresh"></use></svg></button>
                </div>
                <div class="total">전체 0개</div>
            </div>
            <div class="sub_filter_result" hidden>
                <div class="filter_on_box">
                    <div class="category">
                        <!-- <span>침대/매트리스   <button data-id="1" onclick="filterRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button></span> -->
                    </div>
                    <div class="location"></div>
                    <div class="order"></div>
                </div>
                <button class="refresh_btn">초기화 <svg><use xlink:href="/img/icon-defs.svg#refresh"></use></svg></button>
            </div>
        </div>

        <ul class="obtain_list type02"></ul>
    </section>
</div>


<script>
     $(window).on('load',function(){
        if(window.location.search == "?list"){
            let winT = $('#wholesalerList').offset().top;
            $('body,html').animate({scrollTop:winT},300)
        }
    });

    // category_banner
    const category_banner = new Swiper(".category_banner .slide_box", {
        slidesPerView: 'auto',
        //spaceBetween: 17,
    });

    $('.category_banner li').on('click',function(){
        $(this).addClass('on').siblings().removeClass('on')
    })

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
    if($(".wholesaler_con01 .count_pager").length > 0) {
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
    }

    // line_common_banner
    const line_common_banner = new Swiper(".line_common_banner", {
        loop: true,
        autoplay: {
            delay: 2000,
            disableOnInteraction: false
        },
        speed: 2000,
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
//            loadWholesalerList();
        }, 10);
    })

    window.addEventListener('scroll', function() {
        if ((window.pageYOffset || document.documentElement.scrollTop) + window.innerHeight + 300 >= document.documentElement.scrollHeight && !isLoading && !isLastPage) {
            loadWholesalerList();
        }
    });

    function saveDetail(idx, otherLink){
        sessionStorage.setItem('af6-top', $(document).scrollTop());
        sessionStorage.setItem('af6-currentPage', currentPage);
        sessionStorage.setItem('af6-href', location.href);
        sessionStorage.setItem('af6-backupItem', $($(".obtain_list")[1]).html());

        if(otherLink) {
            location.href=otherLink;
        } else {
            location.href='/wholesaler/detail/' + idx;
        }
    }
    window.onpageshow = function(ev) {
        if(sessionStorage.getItem("af6-backupItem") && location.href == sessionStorage.getItem("af6-href")){
            $($(".obtain_list")[1]).html(sessionStorage.getItem("af6-backupItem"));
            $(document).scrollTop(sessionStorage.getItem("af6-top"));
            currentPage = sessionStorage.getItem("af6-currentPage");
        } else {
            
            setTimeout(() => {
                loadWholesalerList();
            }, 50);
        }
        sessionStorage.removeItem('af6-backupItem');
        sessionStorage.removeItem('af6-top');
        sessionStorage.removeItem('af6-currentPage');
        sessionStorage.removeItem('af6-refurl');
    }

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

    function selectCategory(categoryIdx) {
        var anyChoosed = false;
        $("#filter_category-modal .check-form").each(function(){
            if(Number(this.id) === categoryIdx) {
                $(this).prop('checked', !$(this).is(':checked'));
                if($(this).is(':checked')) {
                    anyChoosed = true;
                }
            }
        });
        if(anyChoosed) {
            $(".sub_filter_result").css('display', 'flex');
        } else {
            $(".sub_filter_result").hide();
        }
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
//            $(".sub_filter .filter_box button").eq(0).find('.txt-primary').text("");
//            $(".sub_filter .filter_box button").eq(0).removeClass('on');
        } else {
//            $(".sub_filter .filter_box button").eq(0).find('.txt-primary').text(totalOfSelectedCategories);
//            $(".sub_filter .filter_box button").eq(0).addClass('on');

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
            $(".sub_filter .filter_box button").eq(1).find('.txt-primary').text("");
            $(".sub_filter .filter_box button").eq(1).removeClass('on');

        } else {
            $(".sub_filter .filter_box button").eq(1).find('.txt-primary').text(totalOfSelectedLocations);
            $(".sub_filter .filter_box button").eq(1).addClass('on');
        }
    }

    function displaySelectedOrders() {
        if($("#filter_align-modal .radio-form:checked").val() != "register_time") {
            $(".filter_on_box .order").empty().append(
                '<span>'+ $("#filter_align-modal .radio-form:checked").siblings('label').text() + 
                '   <button data-id="'+ $(this).attr('id') +'" onclick="orderRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button>' +
                '</span>'
            );   
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
