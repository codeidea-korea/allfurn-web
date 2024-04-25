@extends('layouts.app_m')
@php
    $only_quick = '';
    $header_depth = 'prodlist';
    $top_title = $_GET['kw'];
    $header_banner = '';
@endphp
@section('content')
    @include('layouts.header_m')
    <div id="content">
        <section class="sub !pt-0">
            <div class="sub_category !pb-0 !mb-0">
                <ul>
                    <li class="active w-full"><a class="inline-block w-full py-3 text-center" href="javascript:void(0);">상품</a></li>
                    <li class="w-full"><a class="inline-block w-full py-3 text-center" href="/wholesaler/search?kw={{$_GET['kw']}}">업체</a></li>
                </ul>
            </div>
            <div class="bg-stone-100 px-[18px] py-3">
                <p class="text-stone-400"><span>"{{$_GET['kw']}}"</span> 검색 결과 총 {{number_format($productList['list']->total())}}개의 상품</p>
            </div>
            <div class="sub_filter px-[18px] mt-3">
                <div class="filter_box !flex-nowrap whitespace-nowrap overflow-x-auto">
                    <button onclick="modalOpen('#filter_align-modal02')">최신 상품 등록순</button>
                    <button onclick="modalOpen('#search_category_modal')" class="shirink-0 h-[48px] px-3 border rounded-sm inline-block w-[100px] flex justify-between items-center">
                        <p>카테고리</p>
                        <svg class="w-6 h-6 filter_arrow"><use xlink:href="/img/icon-defs.svg#drop_b_arrow"></use></svg>
                    </button>
                    {{--
                    <button onclick="modalOpen('#prod_property-modal')" class="shirink-0 h-[48px] px-3 border rounded-sm inline-block w-[80px] flex justify-between items-center">
                        <p>속성</p>
                        <svg class="w-6 h-6 filter_arrow"><use xlink:href="/img/icon-defs.svg#drop_b_arrow"></use></svg>
                    </button>
                    --}}
                </div>
            </div>
            {{--
            <div class="sub_filter px-[18px] mt-3">
                <div class="filter_box !flex-nowrap whitespace-nowrap overflow-x-auto">
                    <button class="refresh_btn">초기화 <svg><use xlink:href="/img/icon-defs.svg#refresh"></use></svg></button>
                    <button onclick="modalOpen('#filter_align-modal02')">최신 상품 등록순</button>
                    <button class="on" onclick="modalOpen('#search_category_modal')" class="shirink-0 h-[48px] px-3 border rounded-sm inline-block w-[100px] flex justify-between items-center">
                        <p>카테고리</p>
                        <svg class="w-6 h-6 filter_arrow"><use xlink:href="/img/icon-defs.svg#drop_b_arrow"></use></svg>
                    </button>
                    <button onclick="modalOpen('#prod_property-modal')" class="shirink-0 h-[48px] px-3 border rounded-sm inline-block w-[80px] flex justify-between items-center">
                        <p>속성</p>
                        <svg class="w-6 h-6 filter_arrow"><use xlink:href="/img/icon-defs.svg#drop_b_arrow"></use></svg>
                    </button>
                </div>
            </div>
            --}}
            <div class="inner mt-3">
                <div class="relative">
                    <ul class="prod_list">
                        @if($productList['list']->total() > 0)
                        @foreach($productList['list'] as $item)
                        <li class="prod_item">
                            <div class="img_box">
                                <a href="/product/detail/{{$item->idx}}"><img src="{{$item->imgUrl}}" alt="{{$item->name}}"></a>
                                <button class="zzim_btn prd_{{$item->idx}} {{ ($item->isInterest == 1) ? 'active' : '' }}" pidx="{{$item->idx}}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="/product/detail/{{$item->idx}}">
                                    <span>{{$item->companyName}}</span>
                                    <p>{{$item->name}}</p>
                                    <b>
                                        @if( $item->is_price_open == 1 )
                                            {{number_format( $item->price )}}원
                                        @else
                                            {{$item->price_text}}
                                        @endif
                                    </b>
                                </a>
                            </div>
                        </li>
                        @endforeach
                        @else
                        <li class="no_prod txt-gray">
                            <i><svg><use xlink:href="/img/icon-defs.svg#Search"></use></svg></i>
                            카테고리 상품 결과가 없습니다.
                            <a href="javascript:;">올펀 상품 보러가기</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </section>
    </div>

    <!-- 옵션 선택 -->
    <div class="modal" id="option-modal">
        <div class="modal_bg" onclick="modalClose('#option-modal')"></div>
        <div class="modal_inner modal-md">
            <button class="close_btn" onclick="modalClose('#option-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body filter_body">
                <h4>속성</h4>
                <div class="sub_category type02 mt-3">
                    <ul>
                        <li class="active"><a href="javascript:;">사이즈</a></li>
                        <li><a href="javascript:;">프레임형태</a></li>
                        <li><a href="javascript:;">소재</a></li>
                        <li><a href="javascript:;">헤드형태</a></li>
                        <li><a href="javascript:;">색상</a></li>
                        <li><a href="javascript:;">깔판형태</a></li>
                        <li><a href="javascript:;">원산지</a></li>
                    </ul>
                </div>
                <div class="category_tab">
                    <div class="active">
                        <ul class="filter_list">
                            <li>
                                <input type="checkbox" class="check-form" id="option_1_1">
                                <label for="option_1_1">싱글</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="option_1_2">
                                <label for="option_1_2">슈퍼싱글</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="option_1_3">
                                <label for="option_1_3">더블</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="option_1_4">
                                <label for="option_1_4">퀸</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="option_1_5">
                                <label for="option_1_5">킹</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="option_1_6">
                                <label for="option_1_6">라지킹</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="option_1_7">
                                <label for="option_1_7">기타</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="option_1_8">
                                <label for="option_1_8">패밀리</label>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <ul class="filter_list">
                            <li>
                                <input type="checkbox" class="check-form" id="option_2_1">
                                <label for="option_2_1">하단오픈형</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="option_2_2">
                                <label for="option_2_2">하단밀폐형</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="option_2_3">
                                <label for="option_2_3">하단서랍형</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="option_2_4">
                                <label for="option_2_4">기타</label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="btn_bot">
                    <button class="btn btn-line3 refresh_btn" onclick="optionRefresh(this)"><svg><use xlink:href="/img/icon-defs.svg#refresh"></use></svg>초기화</button>
                    <button class="btn btn-primary full">선택 완료</button>
                </div>
            </div>
        </div>
    </div>


    <!-- 필터 : 정렬선택2 -->
    <div class="modal" id="search_category_modal">
        <div class="modal_bg" onclick="modalClose('#search_category_modal')"></div>
        <div class="modal_inner modal-md">
            <button class="close_btn" onclick="modalClose('#search_category_modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body filter_body">
                <h4>카테고리</h4>
                <section class="category_con01 !pb-[0px]">
                    <div class="category_list py-4 overflow-y-scroll h-[572px]">
                        <ul>
                            <li>
                                <a href="javascript:;">
                                    <i><svg><use xlink:href="/img/icon-defs.svg#category_bed"></use></svg></i>
                                    <span>침대/매트리스</span>
                                </a>
                                <ul class="depth2">
                                    <li><a href="javascript:;">침대프레임</a></li>
                                    <li><a href="javascript:;">스프링매트리스</a></li>
                                    <li><a href="javascript:;">폼매트리스</a></li>
                                    <li><a href="javascript:;">기능성매트리스</a></li>
                                    <li><a href="javascript:;">협탁</a></li>
                                    <li><a href="javascript:;">돌침대/흙침대</a></li>
                                    <li><a href="javascript:;">기타기능성침대</a></li>
                                    <li><a href="javascript:;">라텍스매트리스</a></li>
                                    <li><a href="javascript:;">토퍼</a></li>
                                    <li><a href="javascript:;">베개/커버</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i><svg><use xlink:href="/img/icon-defs.svg#category_sofa"></use></svg></i>
                                    <span>소파/거실</span>
                                </a>
                                <ul class="depth2">
                                    <li><a href="javascript:;">가죽소파</a></li>
                                    <li><a href="javascript:;">인조가죽소파</a></li>
                                    <li><a href="javascript:;">일반패브릭소파</a></li>
                                    <li><a href="javascript:;">기능성패브릭소파</a></li>
                                    <li><a href="javascript:;">리클라이너 소파</a></li>
                                    <li><a href="javascript:;">1인용 소파</a></li>
                                    <li><a href="javascript:;">1인용 리클라이너</a></li>
                                    <li><a href="javascript:;">소파베드</a></li>
                                    <li><a href="javascript:;">좌식소파</a></li>
                                    <li><a href="javascript:;">소파테이블</a></li>
                                    <li><a href="javascript:;">거실장</a></li>
                                    <li><a href="javascript:;">TV스탠드</a></li>
                                    <li><a href="javascript:;">돌소파/흙소파</a></li>
                                    <li><a href="javascript:;">기타</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i><svg><use xlink:href="/img/icon-defs.svg#category_table"></use></svg></i>
                                    <span>식탁/의자</span>
                                </a>
                                <ul class="depth2">
                                    <li><a href="javascript:;">우드 식탁</a></li>
                                    <li><a href="javascript:;">세라믹 식탁</a></li>
                                    <li><a href="javascript:;">대리석 식탁</a></li>
                                    <li><a href="javascript:;">기타소재 식탁</a></li>
                                    <li><a href="javascript:;">식탁의자</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i><svg><use xlink:href="/img/icon-defs.svg#category_closet"></use></svg></i>
                                    <span>옷장</span>
                                </a>
                                <ul class="depth2">
                                    <li><a href="javascript:;">장롱</a></li>
                                    <li><a href="javascript:;">붙박이장</a></li>
                                    <li><a href="javascript:;">드레스룸</a></li>
                                    <li><a href="javascript:;">캐비닛</a></li>
                                    <li><a href="javascript:;">서랍장</a></li>
                                    <li><a href="javascript:;">수납장</a></li>
                                    <li><a href="javascript:;">행거</a></li>
                                    <li><a href="javascript:;">주방수납장</a></li>
                                    <li><a href="javascript:;">진열장</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i><svg><use xlink:href="/img/icon-defs.svg#category_study"></use></svg></i>
                                    <span>서재/공부방</span>
                                </a>
                                <ul class="depth2">
                                    <li><a href="javascript:;">책상</a></li>
                                    <li><a href="javascript:;">의자</a></li>
                                    <li><a href="javascript:;">책장/책꽂이</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i><svg><use xlink:href="/img/icon-defs.svg#category_dressing"></use></svg></i>
                                    <span>화장대/콘솔</span>
                                </a>
                                <ul class="depth2">
                                    <li><a href="javascript:;">화장대</a></li>
                                    <li><a href="javascript:;">콘솔</a></li>
                                    <li><a href="javascript:;">전신거울</a></li>
                                    <li><a href="javascript:;">벽거울</a></li>
                                    <li><a href="javascript:;">탁상거울</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i><svg><use xlink:href="/img/icon-defs.svg#category_kids"></use></svg></i>
                                    <span>키즈/주니어</span>
                                </a>
                                <ul class="depth2">
                                    <li><a href="javascript:;">일반침대프레임</a></li>
                                    <li><a href="javascript:;">2층침대프레임</a></li>
                                    <li><a href="javascript:;">책상</a></li>
                                    <li><a href="javascript:;">의자</a></li>
                                    <li><a href="javascript:;">키즈소파</a></li>
                                    <li><a href="javascript:;">옷장</a></li>
                                    <li><a href="javascript:;">서랍/수납장</a></li>
                                    <li><a href="javascript:;">층간소음방지매트</a></li>
                                    <li><a href="javascript:;">놀이가구</a></li>
                                    <li><a href="javascript:;">안전문</a></li>
                                    <li><a href="javascript:;">책장/책꽂이</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i><svg><use xlink:href="/img/icon-defs.svg#category_display"></use></svg></i>
                                    <span>진열장/장식장</span>
                                </a>
                                <ul class="depth2">
                                    <li><a href="javascript:;">진열장/장식장</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i><svg><use xlink:href="/img/icon-defs.svg#category_office"></use></svg></i>
                                    <span>사무용가구</span>
                                </a>
                                <ul class="depth2">
                                    <li><a href="javascript:;">책상</a></li>
                                    <li><a href="javascript:;">의자</a></li>
                                    <li><a href="javascript:;">파티션/패널</a></li>
                                    <li><a href="javascript:;">책장/수납</a></li>
                                    <li><a href="javascript:;">소파</a></li>
                                    <li><a href="javascript:;">테이블</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i><img src="/img/main/obtain_icon.png" alt=""></i>
                                    <span>조달가구</span>
                                </a>
                                <ul class="depth2">
                                    <li><a href="javascript:;">사무용가구</a></li>
                                    <li><a href="javascript:;">중역용가구</a></li>
                                    <li><a href="javascript:;">교육용가구</a></li>
                                    <li><a href="javascript:;">사무용의자</a></li>
                                    <li><a href="javascript:;">사무용소파</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i><svg><use xlink:href="/img/icon-defs.svg#category_business"></use></svg></i>
                                    <span>업소용가구</span>
                                </a>
                                <ul class="depth2">
                                    <li><a href="javascript:;">테이블</a></li>
                                    <li><a href="javascript:;">의자</a></li>
                                    <li><a href="javascript:;">주문가구</a></li>
                                    <li><a href="javascript:;">기타</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </section>
                <div class="btn_bot">
                    <button class="btn btn-primary full">선택 완료</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let isLoading = false;
        let isLastPage = false;
        let currentPage = 1;

        // 카테고리 클릭시
        $('.sub_category li').on('click',function(){
            $(this).addClass('active').siblings().removeClass('active')
        })

        $('.sub_category.type02 li').on('click',function(){
            let liN = $(this).index();
            $(this).addClass('active').siblings().removeClass('active')
            $('.category_tab > div').eq(liN).addClass('active').siblings().removeClass('active')
        })

        const optionRefresh = (item)=>{
            $(item).parents('.filter_body').find('input').each(function(){
                $(this).prop("checked",false);
            });
        }
        function loadNewProductList() {
            if(isLoading) return;
            if(isLastPage) return;

            isLoading = true;

            var orderedElement = '';
            if( $('input[name="filter_cate_2"]').is(':checked') == true ) {
                orderedElement = $('input[name="filter_cate_2"]:checked').attr('id')
            }

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '/product/getJsonListBySearch',
                method: 'GET',
                data: {
                    'page': ++currentPage,
                    'kw' : "{{$_GET['kw']}}",
                    'so' : orderedElement,
                },
                success: function(result) {
                    displayNewWholesaler(result.query, $(".relative ul.prod_list"), false);

                    isLastPage = currentPage === result.last_page;
                },
                complete : function () {
                    isLoading = false;
                }
            })
        }


        function displayNewWholesaler(productArr, target, needsEmptying) {
            if(needsEmptying) {
                target.empty();
            }

            let html = "";
            productArr.data.forEach(function(product, index) {
                console.log(product);
                html += '' +
                    '<li class="prod_item">' +
                    '   <div class="img_box">' +
                    '       <a href="/product/detail/' + product.idx + '"><img src="' + product.imgUrl + '" alt=""></a>' +
                    '       <button class="zzim_btn prd_' + product.idx + '" pidx="' + product.idx + '"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>' +
                    '   </div>' +
                    '   <div class="txt_box">' +
                    '       <a href="./prod_detail.php">' +
                    '           <span>' + product.companyName + '</span>' +
                    '           <p>' + product.name + '</p>' +
                    '           <b>';
                if (product.is_price_open == 1) {
                    html += product.price.toLocaleString('ko-KR') + '원';
                } else {
                    html += product.price_text;
                }
                html += '' +
                    '</b>' +
                    '       </a>' +
                    '   </div>' +
                    '</li>'
            });

            target.append(html);
        }

        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() + 20 >= $(document).height() && !isLoading && !isLastPage) {
                loadNewProductList();
            }
        });
    </script>
@endsection