@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
    <div id="container" class="container category">
        <div class="inner">
            <p class="inner__type">
                ‘<span>{{$_GET['kw']}}</span>' 검색 결과
            </p>
            <div class="inner__category">
                <div class="sub-category sub-category--type-2">
                    <p class="sub-category__item sub-category__item--active"><a>상품</a></p>
                    <p class="sub-category__item"><a href="/wholesaler/search?kw={{$_GET['kw']}}">업체</a></p>
                </div>
            </div>
            <div class="category-menu category-menu--modify">
                <div>
                    <p class="category-menu__title">
                        <a>
                            @if(isset($_GET['pre']) && $_GET['pre'] != null)
                                @foreach($productList['category1'] as $item)
                                    @if($item->idx == $_GET['pre'])
                                        {{$item->name}}
                                    @endif
                                @endforeach
                                @if(isset($_GET['ca']) && $_GET['ca'] != null)
                                    @foreach($productList['category2'] as $item)
                                        @if($item->idx == $_GET['ca'])
                                            > {{$item->name}}
                                        @endif
                                    @endforeach
                                @endif
                            @else
                                카테고리
                            @endif
                        </a>
                    </p>
                    <div class="category-menu__wrap">
                        <div class="category-menu__main">
                            @foreach($productList['category1'] as $item)
                                <div class="category-menu__item">
                                    <a href="#" class="category-menu__link" data-category_idx={{$item->idx}} >
                                        <img class="category__ico" src="{{$item->imgUrl}}"/>
                                        {{$item->name}}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="category-refresh">
                    <a onclick="resetCategory()" class="category-filter__refresh">
                        <i class="ico__refresh--gray"></i>
                        <span>초기화</span>
                    </a>
                </div>
            </div>

            @if(isset($productList['property']))
                <div class="category-filter category-filter--active">
                    <a href="#" class="category-filter__title">속성</a>
                    <div class="category-filter__wrap">
                            <?php
                            $propertyList = [];
                            foreach($productList['property'] as $item) {
                                if ($item['name'] != null) {
                                    $item['list'] = [];
                                    array_push($propertyList, $item);
                                }
                            }
                            $selectedFilterList = [];
                            ?>
                        @foreach($propertyList as $key=>$prop)
                                <?php $arr = array(); ?>
                            @if(isset($_GET['prop']))
                                    <?php $arr = explode('|', $_GET['prop']); ?>
                            @endif

                            <div class="category-filter__item">
                                <div class="category-filter__sub-title">{{$prop->name}}
                                    <a href="#" class="category-filter__arrow"></a>
                                </div>
                                <div class="category-filter__box">
                                    <div>
                                        @foreach($productList['property'] as $item)
                                            @if($prop->idx == $item->parent_idx)
                                                <p @if(in_array($item->idx, $arr)) class="select-button" {{array_push($selectedFilterList, ['idx'=>$item->idx, 'name'=>$item->property_name])}}@endif>
                                                    <button type="button" class="prop_btn" data-property_idx="{{$item->idx}}">{{$item->property_name}}</button>
                                                </p>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="category-filter__footer @if(count($selectedFilterList) > 0) active @endif ">
                        <div class="category-filter__util">
                            <div class="category-filter__data">
                                @if(count($selectedFilterList) > 0)
                                    @foreach($selectedFilterList as $item)
                                        <button type='button' data-idx="{{$item['idx']}}"><span>{{$item['name']}}</span></button>
                                    @endforeach
                                @endif
                            </div>
                            <a class="category-filter__refresh" id="property_reset">
                                초기화
                                <i class="ico__refresh"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if($productList['list']->total() > 0)
                <div class="contents">
                    <div class="product">
                        <div class="product__text--wrap">
                            <p class="product__count">‘{{$_GET['kw']}}' 검색 결과 총 <?php echo number_format($productList['list']->total()); ?>개의 상품</p>
                            <a href="#" class="product__filter" onclick="openModal('#modal-type--basic')">
                                <i class="ico__filter"><span class="a11y">필터 아이콘</span></i>
                                <span>
                                    @if(isset($_GET['so']))
                                        @switch($_GET['so'])
                                            @case('search')
                                                검색 많은 순
                                                @break
                                            @case('order')
                                                주문 많은 순
                                                @break
                                            @default
                                                신상품순
                                                @break
                                        @endswitch
                                    @else
                                        신상품순
                                    @endif
                                </span>
                            </a>
                        </div>
                    </div>

                    <ul class="product-list">
                        @foreach($productList['list'] as $item)
                            <li class="product-list__card" style="position: relative;">
                                <div class="card__bookmark">
                                    <i class="@if($item->isInterest == 1)ico__bookmark24--on @else ico__bookmark24--off @endif" onclick="addInterestByList('{{$item->idx}}')" data-product_idx="{{$item->idx}}"><span class="a11y">스크랩 off</span></i>
                                </div>
                                <a href="/product/detail/{{$item->idx}}" title="{{$item->name}} 상세 화면으로 이동">
                                    <div class="card__img--wrap">
                                        <img class="card__img" src="{{$item->imgUrl}}" alt="{{$item->name}}" style="height:100%">
                                        @if($item->isAd == 1)
                                            <div class="card__badge">AD</div>
                                        @endif
                                    </div>
                                    <div class="card__text--wrap">
                                        <p class="card__brand">{{$item->companyName}}</p>
                                        <p class="card__name">@if($item->state == 'O')(품절) @endif{{$item->name}}</p>
                                        <p class="card__price">
                                            @if($item->is_price_open != 0)
                                                <?php echo number_format($item->price, 0); ?> 원
                                            @else
                                                {{$item->price_text}}
                                            @endif
                                        </p>
                                    </div>
                                </a>
                                @if($item->state == 'O')
                                    <a class="dim" style="position:absolute;width:100%;height:100%;top:0;left:0;background-color: #ffffff80" href="/product/detail/{{$item->idx}}"></a>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    <div class="pagenation pagination--center mt0">
                        {{ $productList['list']->withQueryString()->links() }}
                    </div>
                </div>
            @else
                <!--data 없을때-->
                <div class="no-data">
                  <p>
                    <i class="ico__search-circle"></i>
                    ‘{{$_GET['kw']}}’ 에 대한 상품 검색 결과가 없습니다.
                  </p>
                  <a href="{{route('product.new')}}">올펀 상품 보러가기</a>
                </div>
            @endif
        </div>
        <div id="modal-type--basic" class="modal">
            <div class="modal__container">
                <div class="modal__content">
                    <div class="modal-box__container" style="width: 480px">
                        <div class="modal-box__content">
                            <div class="header">
                                <p>정렬 선택</p>
                            </div>
                            <div class="content">
                                <div class="radio">
                                    <label class="radio__item">
                                        <input type="radio" name="filter" data-sort="new" @if(!isset($_GET['so'])) checked @elseif($_GET['so'] == 'new') checked @endif>
                                        <span>신상품순</span>
                                    </label>
                                    <label class="radio__item">
                                        <input type="radio" name="filter" data-sort="search" @if(isset($_GET['so']) && $_GET['so'] == 'search') checked @endif>
                                        <span>검색 많은 순</span>
                                    </label>
                                    <label class="radio__item">
                                        <input type="radio" name="filter" data-sort="order" @if(isset($_GET['so']) && $_GET['so'] == 'order') checked @endif>
                                        <span>주문 많은 순</span>
                                    </label>
                                </div>
                            </div>
                            <div class="footer" style="height: 42px">
                                <button type="button" class="sort_btn">선택 완료</p>
                            </div>
                            <div class="modal-close">
                                <button type="button" class="modal__close-button" onclick="closeModal('#modal-type--basic')"><span class="a11y">close</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var swiper = new Swiper('#eventkvSwipe', {
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            loop: true,
            slidesPerView: 1,
            spaceBetween: 0,
            paginationClickable: true,
            keyboard: true,
            speed: 400,
            pagination: {
                el: '#eventkvSwipe .swiper-pagination',
                type: 'fraction',
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
        $('#eventkvSwipe').hover(function(){
            swiper.autoplay.stop();
        }, function(){
            swiper.autoplay.start();
        });

        $('.category-menu').on('click', function () {
            if ($(this).is('.category-menu--active')) {
                $(this).removeClass('category-menu--active');
            } else {
                $(this).addClass('category-menu--active');
            }
        })

        $('body').on('mouseover', '.category-menu__link', function () {
            $('.category-menu__item.selected').removeClass('selected');

            $(this).parent().addClass('selected');
            bodyCategoryList($(this).data('category_idx'));
        })
        $('body').on('mouseleave', '.category-menu__wrap', function () {
            $('.category-menu.category-menu--active').removeClass('category-menu--active');
        })

        function bodyCategoryList(category_idx) {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '/product/getCategoryList/' + category_idx,
                data: {},
                type: 'POST',
                dataType: 'json',
                success: function (result) {
                    $('.category-menu__sub').remove();
                    var htmlText = '<div class="category-menu__sub active" style="background:white;max-height: 400px;">' +
                        '<p class="category-menu__sub-item">' +
                        '<a href="/product/search?kw={{$_GET['kw']}}&pre=' + category_idx + '" >전체</a>' +
                        '</p>';
                    result.forEach(function (e) {
                    htmlText += '<p class="category-menu__sub-item">' +
                        '<a href="/product/search?kw={{$_GET['kw']}}&ca=' + e.idx + '&pre=' + category_idx + '" >' + e.name + '</a>' +
                        '</p>';
                    })
                    htmlText += '</div>';
                    $('.category-menu__wrap').css('width', '500px');
                    $('.category-menu__item.selected').append(htmlText);
                }
            });
        }

        function resetCategory() {
            urlSearch = new URLSearchParams(location.search);
            url = '/product/search?kw='+urlSearch.get('kw');

            location.replace(url);
        }

        function selectCategory() {
            var query = "?ca=";
            $('.content__list.category li input:checked').map(function() {
                query += $(this).data('category_code') + "|";
            })

            closeModal('#default-modal');
            location.replace('/product/new'+query.slice(0, -1));
        }

        $('body').on('click', '.prop_btn, .category-filter__footer button, .sort_btn, #property_reset', function () {
            closeModal('#modal-type--basic');

            if ($(this).is('.category-filter__footer')) {
                text = $(this).find('span').text();
                $(this).remove();

                $('.select-button').map(function () {
                    if ($(this).text() == text) {
                        $(this).parent().removeClass('select-button');
                    }
                })
            } else if ('#property_reset'){
                $('.category-filter__footer .category-filter__data').html('');
                $('.select-button').map(function () {
                    $(this).removeClass('.select-button');
                })
            } else if (!'.sort_btn'){
                $(this).parent().addClass('select-button');
            }

            var prop = '';

            $('.select-button').map(function () {
                prop += $(this).find('button').data('property_idx').toString() + "|";
            })

            url = '/product/search?';
            urlSearch = new URLSearchParams(location.search);
            if (urlSearch.get('ca') != null) {
                url += 'ca='+urlSearch.get('ca');
            }
            if (urlSearch.get('pre') != null) {
                url += '&pre='+urlSearch.get('pre');
            }
            if (urlSearch.get('kw') != null) {
                url += '&kw='+urlSearch.get('kw');
            }
            url += '&so='+$('input[name="filter"]:checked').data('sort')

            location.replace(url+'&prop='+prop.slice(0, -1));
        })
    </script>
@endsection
