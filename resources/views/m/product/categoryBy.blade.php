@extends('layouts.app_m')
@php
    $only_quick = '';
    $header_depth = 'prodlist';
    $top_title = $data['category'][0]->parentName;
    $header_banner = '';
@endphp
@section('content')
@include('layouts.header_m')
    <div id="content">
        <section class="sub">
            <div class="inner">
                <div class="sub_category">
                    <ul>
                        <li class="@if($data['selCa'] == null) active @endif"><a href="/product/category?pre={{$data['category'][0]->parent_idx}}">전체</a></li>
                        @foreach($data['category'] as $item)
                        <li class="@if($data['selCa'] == $item->idx) active @endif"><a href="/product/category?ca={{$item->idx}}&pre={{$item->parent_idx}}">{{$item->name}}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="sub_filter">
                    <div class="filter_box">
                        <button onclick="modalOpen('#filter_align-modal')">최신 상품 등록순</button>
                        <button onclick="modalOpen('#option-modal')">속성</button>
                    </div>
                    <div class="total">전체 {{number_format( $data['list']->total())}}개</div>
                </div>
                {{--
                <div class="sub_filter">
                    <div class="filter_box">
                        <button class="refresh_btn">초기화 <svg><use xlink:href="/img/icon-defs.svg#refresh"></use></svg></button>
                        <button onclick="modalOpen('#filter_align-modal')">최신 상품 등록순</button>
                        <button class="on" onclick="modalOpen('#option-modal')">속성 <b class="txt-primary">2</b></button>
                    </div>
                    <div class="total">전체 428개</div>
                </div>
                --}}
                <div class="sub_filter_result">
                    <div class="filter_on_box">
                        <div class="category">
                            <span>소파/거실 <button onclick="filterRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button></span>
                            <span>식탁/의자 <button onclick="filterRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button></span>
                            <span>수납/서랍장/옷장 <button onclick="filterRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button></span>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <ul class="prod_list">
                        @if($data['list']->total() >0)
                        @foreach( $data['list'] AS $item )
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
                                            {{number_format( $item->price )}}
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
            isLoading = true;

            var categories = '';
            var parents = '';
            var orderedElement = '';
            urlSearch = new URLSearchParams(location.search);
            if (urlSearch.get('ca') != null) {
                categories = urlSearch.get('ca');
            }
            if (urlSearch.get('pre') != null) {
                parents = urlSearch.get('pre');
            }

            if( $('input[name="filter_cate_2"]').is(':checked') == true ) {
                orderedElement = $('input[name="filter_cate_2"]:checked').attr('id')
            }

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '/product/getJsonListByCategory',
                method: 'GET',
                data: {
                    'page': ++currentPage,
                    'categories' : categories,
                    'parents' : parents,
                    'orderedElement' : orderedElement,
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

                html += '' +
                    '<li class="prod_item">' +
                    '   <div class="img_box">' +
                    '       <a href="/product/detail/' + product.idx + '"><img src="' + product.imgUrl + '" alt="' + product.name + '"></a>' +
                    '           <button class="zzim_btn prd_' + product.idx + '" pidx="' + product.idx + '"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>' +
                    '   </div>' +
                    '   <div class="txt_box">' +
                    '       <a href="/product/detail/{{$item->idx}}">' +
                    '           <span>' + product.companyName + '</span>' +
                    '           <p>' + product.name + '</p>' +
                    '           <b>';
                if (product.is_price_open == 1) {
                    html += product.price.toLocaleString('ko-KR') + '원';
                } else {
                    html += product.price_text;
                }
                html += '' +
                    '           </b>' +
                    '       </a>' +
                    '   </div>' +
                    '</li>';
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