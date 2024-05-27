@extends('layouts.app')

@section('content')
@include('layouts.header')
    <div id="content">

        <!-- 상단 인기딜 //-->
        @include('product.inc-top_brand');

        @if( count( $plandiscount ) > 0 )
            <section class="sub_section thismonth_con02">
                <div class="inner">
                    <div class="main_tit mb-8 flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <h3>Best 기획전</h3>
                        </div>
                        <div class="flex items-center gap-7">
                            <div class="count_pager"><b>1</b> / 12</div>
                            <a class="more_btn flex items-center" href="/product/planDiscountDetail">더보기<svg><use xlink:href="/img/icon-defs.svg#more_icon"></use></svg></a>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="slide_box overflow-hidden">
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
                        <button class="slide_arrow prev"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
                        <button class="slide_arrow next"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
                    </div>
                </div>
            </section>
        @endif

        @if( count( $dealmiddle ) > 0 )
            <section class="sub_section nopadding">
                <div class="inner">
                    <div class="line_common_banner">
                        <ul class="swiper-wrapper">
                            @foreach( $dealmiddle AS $k => $mid )
                                <li class="swiper-slide" style="{{ $mid->banner_type == 'img' ? 'background-image:url(' . $mid->mainImgUrl . ');' : 'background-color:' . $mid->font_color . ';' }}">
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
                                        <a href="{{link}}">
                                            <div class="txt_box" style="color:{{$mid->font_color}}">
                                                <p>{{$mid->subtext1}} <br/>{{$mid->subtext2}}</p>
                                                <span>{{$mid->content}}</span>
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

        @if( count( $productBest ) > 0 )
            <section class="sub_section thismonth_con04">
                <div class="inner">
                    <div class="main_tit mb-8 flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <h3>{{date('n')}}월 BEST 상품</h3>
                            <button class="zoom_btn flex items-center gap-1" onClick="modalOpen('#zoom_view-modal');"><svg><use xlink:href="/img/icon-defs.svg#zoom"></use></svg>확대보기</button>
                        </div>
                        <div class="flex items-center gap-7">
                            <div class="count_pager"><b>1</b> / 12</div>
                            <a class="more_btn flex items-center" href="/product/best-new">더보기<svg><use xlink:href="/img/icon-defs.svg#more_icon"></use></svg></a>
                        </div>
                    </div>
                    <div class="relative">
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
                        <button class="slide_arrow prev"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
                        <button class="slide_arrow next"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
                    </div>
                </div>
            </section>
        @endif {{-- $productBest --}}

        <section class="sub_section sub_section_bot">
            <div class="inner">
                <div class="main_tit mb-8 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <h3>{{date('n')}}월 BEST 도매 업체</h3>
                    </div>
                </div>
                <div class="sub_filter">
                    <div class="filter_box">
                        <button class="" onclick="modalOpen('#filter_category-modal')">카테고리 <b class="txt-primary"></b></button>
                        <button class="" onclick="modalOpen('#filter_location-modal')">소재지 <b class="txt-primary"></b></button>
                        <button class="" onclick="modalOpen('#filter_align-modal')">최신 상품 등록순</button>
                    </div>
                    <div class="total">전체 0개</div>
                </div>
                <div class="sub_filter_result hidden">
                    <div class="filter_on_box">
                        <div class="category"></div>
                        <div class="location"> </div>
                        <div class="order"> </div>
                    </div>
                    <button class="refresh_btn">초기화 <svg><use xlink:href="/img/icon-defs.svg#refresh"></use></svg></button>
                </div>
                <ul class="obtain_list"></ul>
            </div>
        </section>

        <!-- 확대보기 -->
        @if( count( $productBest ) >  0 )
        <div class="modal" id="zoom_view-modal">
            <div class="modal_bg" onclick="modalClose('#zoom_view-modal')"></div>
            <div class="modal_inner modal-lg zoom_view_wrap">
                <div class="count_pager dark_type"><b>1</b> / 12</div>
                <button class="close_btn" onclick="modalClose('#zoom_view-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
                <div class="modal_body">
                    <div class="slide_box zoom_prod_list">
                        <ul class="swiper-wrapper">
                            @foreach( $productBest AS $key => $best )
                            <li class="swiper-slide">
                                <div class="img_box">
                                    <img src="{{$best->imgUrl}}" alt="">
                                    <button class="zzim_btn prd_{{$best->idx}} {{ ($best->isInterest == 1) ? 'active' : '' }}" pIdx="{{$best->idx}}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <div>
                                        <h5>{{$best->companyName}}</h5>
                                        <p>{{$best->name}}</p>
                                        <b>{{$best->is_price_open ? number_format($best->price, 0).'원': $best->price_text}}</b>
                                    </div>
                                    <a href="/product/detail/{{$best->idx}}">제품상세보기</a>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <button class="slide_arrow prev type03"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow_white"></use></svg></button>
                    <button class="slide_arrow next type03"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow_white"></use></svg></button>
                </div>
            </div>
        </div>
        @endif
    </div>

    <script>
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
            navigation: {
                nextEl: ".thismonth_con01 .slide_arrow.next",
                prevEl: ".thismonth_con01 .slide_arrow.prev",
            },
            pagination: {
                el: ".thismonth_con01 .count_pager",
                type: "fraction",
            },
            thumbs: {
                swiper: thismonth_con01_pager,
            },
            speed:2000,
            autoplay: {
                delay: 5000,
            },
        });

        // thismonth_con02
        const thismonth_con02 = new Swiper(".thismonth_con02 .slide_box", {
            slidesPerView: 2,
            spaceBetween: 30,
            slidesPerGroup: 2,
            navigation: {
                nextEl: ".thismonth_con02 .slide_arrow.next",
                prevEl: ".thismonth_con02 .slide_arrow.prev",
            },
            pagination: {
                el: ".thismonth_con02 .count_pager",
                type: "fraction",
            },
        });


        // line_common_banner
        const line_common_banner = new Swiper(".line_common_banner", {
            loop: true,
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

        // thismonth_con04
        const thismonth_con04 = new Swiper(".thismonth_con04 .slide_box", {
            slidesPerView: 4,
            spaceBetween: 20,
            slidesPerGroup: 4,
            grid: {
                rows: 2,
            },
            navigation: {
                nextEl: ".thismonth_con04 .slide_arrow.next",
                prevEl: ".thismonth_con04 .slide_arrow.prev",
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
        })

        window.addEventListener('scroll', function() {
            if ((window.pageYOffset || document.documentElement.scrollTop) + window.innerHeight + 300 >= document.documentElement.scrollHeight && !isLoading && !isLastPage) {
                loadWholesalerList();
            }
        });

        // 신규 등록 상품 - 카테고리 선택
        $(document).on('click', '[id^="filter"] .btn-primary', function() { 
            loadWholesalerList(true, $(this));
        });

        // 신규 등록 상품 - 카테고리 삭제
        const filterRemove = (item)=>{
            $(item).parents('span').remove(); //해당 카테고리 삭제
            $("#" + $(item).data('id')).prop('checked', false);//모달 안 체크박스에서 check 해제

            loadWholesalerList(true);
        }

        const orderRemove = (item)=> {
            $(item).parents('span').remove(); //해당 카테고리 삭제
            $("#filter_align-modal .radio-form").eq(0).prop('checked', true);

            loadWholesalerList(true);
        }

        // 초기화
        $(".refresh_btn").on('click', function() {
            $("#filter_category-modal .check-form:checked").prop('checked', false);
            $("#filter_location-modal .check-form:checked").prop('checked', false);
            $("#filter_align-modal .radio-form").eq(0).prop('checked', true);
            
            loadWholesalerList(true);
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
                url: '/product/getJsonThisBestWholesaler',
                method: 'GET',
                data: {
                    'page': ++currentPage,
                    'categories' : getIndexesOfSelectedCategory().join(','),
                    'locations' : getIndexesOfSelectedLocation().join(','),
                    'orderedElement' : $("#filter_align-modal .radio-form:checked").val()
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

                    $(".total").text('전체 ' + result.list.total + '개');

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

        function toggleFilterBox() {
            if($(".modal .check-form:checked").length === 0 && $("#filter_align-modal .radio-form:checked").val() == "register_time"){
                $(".sub_filter_result").hide();
            } else {
                $(".sub_filter_result").css('display', 'flex');
            }
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
