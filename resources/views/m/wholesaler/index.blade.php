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
            <div class="category_banner">
                <div class="inner">
                    <div class="slide_box overflow-hidden">
                        <ul class="swiper-wrapper">
                            <li class="swiper-slide" >
                                <a href="javascript:selectCategory(1);">
                                    <i><img src="https://allfurn-prod-s3-bucket.sgp1.vultrobjects.com/product/65eb364492edcb02df94fb038753c10868ecf25416b2963ce8bf92c626b7eed2.png"></i>
                                    <span>침대/매트리스</span>
                                </a>
                            </li>
                            <li class="swiper-slide" >
                                <a href="javascript:selectCategory(2);">
                                    <i><img src="https://allfurn-prod-s3-bucket.sgp1.vultrobjects.com/product/9177229a5b701fd8a27c5227e217e969aef03e4ac1e838bc0f0dbeaf890a658d.png"></i>
                                    <span>소파/거실</span>
                                </a>
                            </li>
                            <li class="swiper-slide" >
                                <a href="javascript:selectCategory(3);">
                                    <i><img src="https://allfurn-prod-s3-bucket.sgp1.vultrobjects.com/product/829b9d9b454a99a976a8a18d4498586967649378efb80392916cd079062f33eb.png"></i>
                                    <span>식탁/의자</span>
                                </a>
                            </li>
                            <li class="swiper-slide" >
                                <a href="javascript:selectCategory(4);">
                                    <i><img src="https://allfurn-prod-s3-bucket.sgp1.vultrobjects.com/product/5900a96c73bfbd507e6c6276e2b69242cfa463e0f1b9eaf298194231d7d469d2.png"></i>
                                    <span>서랍장/옷장</span>
                                </a>
                            </li>
                            <li class="swiper-slide" >
                                <a href="javascript:selectCategory(5);">
                                    <i><img src="https://allfurn-prod-s3-bucket.sgp1.vultrobjects.com/product/7b0a1e320be055bac8c26a8a48d90a77e182344054842a321d979b72576033a9.png"></i>
                                    <span>서재/공부방</span>
                                </a>
                            </li>
                            <li class="swiper-slide" >
                                <a href="javascript:selectCategory(6);">
                                    <i><img src="https://allfurn-prod-s3-bucket.sgp1.vultrobjects.com/product/56a4064e6c04bf8425c066000729439a1507c8003dc785f8ccd96837bbf0bad7.png"></i>
                                    <span>화장대/거울</span>
                                </a>
                            </li>
                            <li class="swiper-slide" >
                                <a href="javascript:selectCategory(7);">
                                    <i><img src="https://allfurn-prod-s3-bucket.sgp1.vultrobjects.com/product/12a41e2421f9c2dfa78fdaf09a0b49b8bdc4be3b79107c4d31155d910004a277.png"></i>
                                    <span>키즈/주니어</span>
                                </a>
                            </li>
                            <li class="swiper-slide" >
                                <a href="javascript:selectCategory(8);">
                                    <i><img src="https://allfurn-prod-s3-bucket.sgp1.vultrobjects.com/product/04596ce9bac70876a7727a80a7afb0e86ced673b87858dc69b37cf70411898d3.png"></i>
                                    <span>진열장/장식장</span>
                                </a>
                            </li>
                            <li class="swiper-slide" >
                                <a href="javascript:selectCategory(9);">
                                    <i><img src="https://allfurn-prod-s3-bucket.sgp1.vultrobjects.com/product/602aa2cc488c5d8d70aa5bf43b366ea1ad6d4d434d46afed6ce35dd1a58bdb5f.png"></i>
                                    <span>의자</span>
                                </a>
                            </li>
                            <li class="swiper-slide" >
                                <a href="javascript:selectCategory(10);">
                                    <i><img src="https://allfurn-prod-s3-bucket.sgp1.vultrobjects.com/product/b3f728a02f5e35f6ea8fd6354c81bb9fbd1523d7b5eee50e5044a5b125247957.png"></i>
                                    <span>테이블</span>
                                </a>
                            </li>
                            <li class="swiper-slide" >
                                <a href="javascript:selectCategory(14);">
                                    <i><img src="https://allfurn-prod-s3-bucket.sgp1.vultrobjects.com/product/7d4e93baa251aa36f901b4a7141c8ae12973cf80c1152782d43edadb6dbd8a3a.png"></i>
                                    <span>사무용가구</span>
                                </a>
                            </li>
                            <li class="swiper-slide" >
                                <a href="javascript:selectCategory(233);">
                                    <i><img src="https://allfurn-prod-s3-bucket.sgp1.vultrobjects.com/category/321d01555dfa7fdda84e01a64f39443c56e6be61d2935182a435889f9a3a9336.png"></i>
                                    <span>조달가구</span>
                                </a>
                            </li>
                        </ul>
                    </div>
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
        let categories = []; // 모바일은 서브 필터가 없어 저장되면 안됨
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
        $("#filter_category-modal .check-form:checked").each(function(){
            locations.push($(this).data('location'));
        });

        return locations;
    }

    function displaySelectedCategories() {
        let totalOfSelectedCategories = $("#filter_category-modal .check-form:checked").length;
        if(totalOfSelectedCategories === 0) {
//            $(".sub_filter .filter_box button").eq(0).find('.txt-primary').text("");
//            $(".sub_filter .filter_box button").eq(0).removeClass('on');
        } else {
//            $(".sub_filter .filter_box button").eq(0).find('.txt-primary').text(totalOfSelectedCategories);
//            $(".sub_filter .filter_box button").eq(0).addClass('on');

            $(".wholesalerListSection ul.obtain_list .sub_filter_result").show();
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
