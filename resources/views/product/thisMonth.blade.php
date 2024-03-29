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
                            <a class="more_btn flex items-center" href="javascript:;">더보기<svg><use xlink:href="/img/icon-defs.svg#more_icon"></use></svg></a>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="slide_box overflow-hidden">
                            <ul class="swiper-wrapper">
                                @foreach( $plandiscount AS $key => $product )
                                    <li class="swiper-slide prod_item type02">
                                        <div class="img_box">
                                            <a href="/product/detail/{{$product->idx}}">
                                                <img src="{{$product->imgUrl}}" alt="">
                                                <span><b>{{$product->subtext1}}</b><br/>{{$product->subtext2}}</span>
                                            </a>
                                            <button class="zzim_btn  prd_{{$product->idx}} {{ ($product->isInterest == 1) ? 'active' : '' }}" pidx="{{$product->idx}}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                        </div>
                                        <div class="txt_box">
                                            <a href="./prod_detail.php">
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
                                <li class="swiper-slide" style="background-color:#475872; ">
                                    <a href="javascript:;">
                                        <div class="txt_box">
                                            <p>{{$mid->subtext1}}<br/>{{$mid->subtext2}}</p>
                                            <span>{{$mid->content}}</span>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="count_pager"><b>1</b> / 12</div>
                        <button class="slide_arrow prev type03"><svg><use xlink:href="/icon-defs.svg#slide_arrow_white"></use></svg></button>
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
                                            <a href="./prod_detail.php">
                                                <span>{{$best->companyName}}</span>
                                                <p>{{$best->name}}
                                                    <b>{{number_format( $best->price )}}원</b>
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

        @include('product.inc-best_company')

        <!-- 확대보기 -->
        @if( count( $productBest ) >  0 )
        <div class="modal" id="zoom_view-modal">
            <div class="modal_bg" onclick="modalClose('#zoom_view-modal')"></div>
            <div class="modal_inner modal-lg zoom_view_wrap">
                <div class="count_pager dark_type"><b>1</b> / 12</div>
                <button class="close_btn" onclick="modalClose('#zoom_view-modal')"><svg class="w-11 h-11"><use xlink:href="./pc/img/icon-defs.svg#Close"></use></svg></button>
                <div class="modal_body">
                    <div class="slide_box zoom_prod_list">
                        <ul class="swiper-wrapper">
                            @foreach( $productBest AS $key => $best )
                            <li class="swiper-slide">
                                <div class="img_box">
                                    <img src="{{$best->imgUrl}}" alt="">
                                    <button class="zzim_btn prd_{{$best->idx}} {{ ($best->isInterest == 1) ? 'active' : '' }}" pIdx="{{$best->idx}}"><svg><use xlink:href="./pc/img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <div>
                                        <h5>{{$best->companyName}}</h5>
                                        <p>{{$best->name}}</p>
                                        <b>{{number_format( $best->price )}}원</b>
                                    </div>
                                    <a href="/product/detail/{{$best->idx}}">제품상세보기</a>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <button class="slide_arrow prev type03"><svg><use xlink:href="./pc/img/icon-defs.svg#slide_arrow_white"></use></svg></button>
                    <button class="slide_arrow next type03"><svg><use xlink:href="./pc/img/icon-defs.svg#slide_arrow_white"></use></svg></button>
                </div>
            </div>
        </div>
        @endif
    </div>

    <script>
        let isLoading = false;
        let isLastPage = false;
        let currentPage = 1;

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

        function refresAllhHandle()
        {
            console.log('asfasefas');
            $('#filter_category-modal .filter_list').find('input').each(function(){
                $(this).prop("checked",false);
            });

            $('#filter_location-modal .filter_list').find('input').each(function(){
                $(this).prop("checked",false);
            });
        }

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

                    displayNewWholesaler(result.query, $(".sub_section_bot ul.obtain_list"), false);

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

            let html = "";
            productArr.forEach(function(product, index) {
                html += '' +
                    '<li>' +
                    '   <div class="txt_box">' +
                    '       <div>' +
                    '           <a href="/wholesaler/detail/' + product.idx + '">' +
                    '               <img src="/img/icon/crown.png" alt="">' +
                    '               ' + product.company_name +
                    '               <svg><use xlink:href="/img/icon-defs.svg#more_icon"></use></svg>' +
                    '           </a>' +
                    '           <i>' + product.location + '</i>' +
                    '               <div class="tag"> ';

                product.categoryList.split(',').forEach(function(cate) {
                html += '<span>' + cate + '</span>';
                });

                html +=
                    '               </div>' +
                    '           </div>' +
                    '       <button class="zzim_btn"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg> 좋아요</button>' +
                    '   </div>' +
                    '   <div class="prod_box">';

                product.productList.forEach(function(img) {
                    html += '<div class="img_box">' +
                        '       <a href="javascript:;"><img src="' + img.imgUrl + '" alt=""></a>' +
                        '       <button class="zzim_btn"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>' +
                        '   </div>';
                });

                html +=
                    '   </div>' +
                    '</li>';
            });

            target.append(html);
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
                .text($("label[for='" + $("#filter_align-modal .radio-form:checked").attr('id') + "']").text());
        }

        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() + 20 >= $(document).height() && !isLoading && !isLastPage) {
                loadNewProductList();
            }
        });
    </script>
@endsection
