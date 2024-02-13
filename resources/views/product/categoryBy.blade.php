@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
    <div id="container" class="container category">
        <div class="inner">
            <p class="inner__type">
                {{$data['category'][0]->parentName}}
            </p>
            <div class="inner__category">
                <div class="sub-category">
                    <p class="sub-category__item @if($data['selCa'] == null) sub-category__item--active @endif "><a href="/product/category?pre={{$data['category'][0]->parent_idx}}">전체</a></p>
                    @foreach($data['category'] as $item)
                        <p class="sub-category__item @if($data['selCa'] == $item->idx) sub-category__item--active @endif "><a href="/product/category?ca={{$item->idx}}&pre={{$item->parent_idx}}">{{$item->name}}</a></p>
                    @endforeach
                </div>
            </div>
            <div class="category-filter category-filter--active">
                <a href="#" class="category-filter__title">속성</a>
                <div class="category-filter__wrap">
                    <?php
                        $propertyList = [];
                        foreach($data['property'] as $item) {
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

                        <div class="category-filter__item category-filter__item--active">
                            <div class="category-filter__sub-title">{{$prop->name}}
                                <!-- <a href="#" class="category-filter__arrow"></a> -->
                            </div>
                            <div class="category-filter__box">
                                <div>
                                    @foreach($data['property'] as $item)
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
            <div class="contents">
                <div class="product">
                    <div class="product__text--wrap">
                        <p class="product__count">전체 {{$data['list']->total()}}개</p>
                        <a href="#" class="product__filter filter--order" onclick="openModal('#default-modal')">
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

                @if($data['list']->total() >0)
                    <ul class="product-list">
                        @foreach($data['list'] as $item)
                            <li class="product-list__card" style="position: relative;">
                                <div class="card__bookmark">
                                    <i class=" @if($item->isInterest > 0)ico__bookmark24--on @else ico__bookmark24--off @endif" onclick="addInterestByList('{{$item->idx}}')" data-product_idx="{{$item->idx}}"><span class="a11y">스크랩 off</span></i>
                                </div>
                                <a href="/product/detail/{{$item->idx}}" title="{{$item->name}} 상세 화면으로 이동">
                                    <div class="card__img--wrap">
                                        <img class="card__img" src="{{$item->imgUrl}}" alt="{{$item->name}}" style="height:100%">
                                        @if ($item->isAd == '1')
                                            <div class="card__badge">AD</div>
                                        @endif
                                    </div>
                                    <div class="card__text--wrap">
                                        <p class="card__brand">{{$item->companyName}}</p>
                                        <p class="product_list_card_name">
                                            @if($item->state == 'O')
                                                (품절)
                                            @endif
                                            {{$item->name}}
                                        </p>
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
                @else
                    <div class="no-data">
                        <p>
                            <i class="ico__search-circle"></i>
                            ‘카테고리 상품 검색 결과가 없습니다.
                        </p>
                        <a href="{{route('product.new')}}">올펀 상품 보러가기</a>
                    </div>
                @endif

                <div class="pagenation pagination--center mt0">
                    {{ $data['list']->withQueryString()->links() }}
                </div>
            </div>
        </div>

        <!-- 신상품순 팝업 -->
        <div id="default-modal" class="default-modal default-modal--radio">
            <div class="default-modal__container">
                <div class="default-modal__header">
                    <h2>정렬 선택</h2>
                    <button type="button" class="ico__close28" onclick="closeModal('#default-modal')">
                        <span class="a11y">닫기</span>
                    </button>
                </div>
                <div class="default-modal__content">
                    <ul class="content__list">
                        <li>
                            <label>
                                <input type="radio" name="order" class="checkbox__checked" data-sort="new" @if(!isset($_GET['so'])) checked @elseif($_GET['so'] == 'new') checked @endif>
                                <span>신상품순</span>
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="radio" name="order" class="checkbox__checked"data-sort="search" @if(isset($_GET['so']) && $_GET['so'] == 'search') checked @endif>
                                <span>검색 많은 순</span>
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="radio" name="order" class="checkbox__checked" data-sort="order" @if(isset($_GET['so']) && $_GET['so'] == 'order') checked @endif>
                                <span>주문 많은 순</span>
                            </label>
                        </li>
                    </ul>
                </div>
                <div class="default-modal__footer">
                    <button type="button" class="button button--solid sort_btn">선택 완료</button>
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

        $('body').on('click', '.prop_btn, .category-filter__footer button, .sort_btn, #property_reset', function () {
            if ($(this).is('.category-filter__footer button')) {
                idx = $(this).data('idx');
                $(this).remove();

                $('.prop_btn[data-property_idx="' + idx + '"]').parent().removeClass('select-button');
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

            url = '/product/category?';
            urlSearch = new URLSearchParams(location.search);
            if (urlSearch.get('ca') != null) {
                url += 'ca='+urlSearch.get('ca');
            }
            if (urlSearch.get('pre') != null) {
                url += '&pre='+urlSearch.get('pre');
            }
            url += '&so='+$('input[name="order"]:checked').data('sort')

            location.replace(url+'&prop='+prop.slice(0, -1));
        })

        $('body').on('click', '.dim', function () {
            location.replace('/product/detail/'+$(this).data('product_idx'));
        })
    </script>
@endsection
