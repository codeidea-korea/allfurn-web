@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
    <div id="container" class="container">
        <div class="inner">
            @if(isset($banners))
                <div id="eventkvSwipe" class="eventkeyvisual swiper-container eventkeyvisual--inner"
                     style="margin: 16px 0 24px !important;">
                    <div class="swiper-wrapper">
                        @foreach($banners as $banner)
                            <div class="swiper-slide">
                                <?php
                                    $link = '';
                                    
                                    switch ($banner->web_link_type) {
                                        case 0: //Url
                                            $link = $banner->web_link;
                                            break;
                                            
                                        case 1: //상품
                                            if ( strpos($banner->web_link, 'product/detail') !== false ) {
                                                $link = $banner->web_link;
                                            } else {
                                                $link = '/product/detail/'.$banner->web_link;
                                            }
                                            break;
                                            
                                        case 2: //업체
                                            if ( strpos($banner->web_link, 'wholesaler/detail') !== false ) {
                                                $link = $banner->web_link;
                                            } else {
                                                $link = '/wholesaler/detail/'.$banner->web_link;
                                            }
                                            break;
                                            
                                        case 3: //커뮤니티
                                            if ( strpos($banner->web_link, 'community/detail') !== false ) {
                                                $link = $banner->web_link;
                                            } else {
                                                $link = '/community/detail/'.$banner->web_link;
                                            }
                                            break;
                                            
                                        case 4: 
                                            $link = '/help/notice/';
                                            break;
                                            
                                        default: //공지사항
                                            $link = $banner->web_link;
                                            break;
                                    }
                                ?>
                                <a href="{{$link}}">
                                    <p class="event__banner" style="background-image:url('{{preImgUrl().$banner->attachment['folder']}}/{{$banner->attachment['filename']}}')"></p>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-util">
                        <div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            @endif
            <div class="content product__container">
                <div class="category-btn @if(isset($_GET['ca']) != '') category-btn--active @endif" onclick="openModal('#default-modal')">
                    <p class="category-btn__text">
                        카테고리
                        <span class="category-btn__count">
                            @if(isset($_GET['ca']) != '')
                                <?php $caArr = explode('|', $_GET['ca']); echo sizeof($caArr); ?>
                        @endif
                        </span>
                    </p>
                </div>
                @if(isset($_GET['ca']) != '')
                    <div class="category-list">
                        <ul class="category-list__wrap">
                            @foreach($categoryList as $category)
                                @if(in_array($category->code, $caArr))
                                    <li class="category-list__item" data-category_code="{{$category->code}}">
                                        <p class="category-list__name">{{$category->name}}</p>
                                        <a onclick="removeCategory('{{$category->code}}')" class="ico__delete16"><span class="a11y">삭제</span></a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                        <div class="category-list__refresh">
                            <a href="{{route('product.new')}}">
                                <p class="category-list__refresh__text">초기화</p>
                                <i class="ico__refresh"><span class="a11y">초기화</span></i>
                            </a>
                        </div>
                    </div>
                @endif
                <div class="product__text--wrap">
                    <h2 class="product__title">
                        @if($todayCount > 0 && !isset($_GET['ca']))
                        오늘 업로드된 상품 <span class="text__color--red">{{$todayCount}}</span>개
                        @endif
                    </h2>
                    <p class="product__count">전체 {{$list->total()}}개</p>
                </div>

                <ul class="product-list">
                    @foreach($list->items() as $item)
                        <li class="product-list__card" style="position: relative;">
                            <div class="card__bookmark">
                                <i class="@if($item->isInterest > 0) ico__bookmark24--on @else ico__bookmark24--off @endif" onclick="addInterestByList('{{$item->idx}}')" data-product_idx="{{$item->idx}}"><span class="a11y">북마크</span></i>
                            </div>
                            <a href="/product/detail/{{$item->idx}}" title="{{$item->name}}">
                                <div class="card__img--wrap">
                                    <img class="card__img" src="{{$item->imgUrl}}" alt="{{$item->name}}" style="height:100%">
                                    @if($item->isAd > 0)
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

                <div class="pagenation pagination--center mt0">
                    {{ $list->withQueryString()->links() }}
                </div>
            </div>

            <!-- 팝업 -->
            <div id="default-modal" class="default-modal default-modal--category">
                <div class="default-modal__container">
                    <div class="default-modal__header">
                        <h2>카테고리 선택</h2>
                        <button type="button" class="ico__close28" onclick="closeModal('#default-modal')">
                            <span class="a11y">닫기</span>
                        </button>
                    </div>
                    <div class="default-modal__content">
                        <ul class="content__list category">
                            @foreach($categoryList as $category)
                                <li>
                                    <label for="category-check_{{$category->idx}}">
                                        <input type="checkbox" class="checkbox__checked" id="category-check_{{$category->idx}}" name="category-list" data-category_idx={{$category->idx}} data-category_code={{$category->code}}
                                        @if(isset($_GET['ca']) && in_array($category->code, $caArr)) checked @endif>
                                        <span>{{$category->name}}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="default-modal__footer">
                        <button type="button" onclick="reset(this);" class="button button--blank-gray">
                            <i class="ico__refresh"><span class="a11y">초기화</span></i>
                            <p>초기화</p>
                        </button>
                        <button type="button" class="button button--solid" onclick="selectCategory()">상품 찾아보기</button>
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

        // category > checked reset
        function reset(set) {
            var $id = $(set).parents('.default-modal--category');
            $($id).find('input[type=checkbox]').prop("checked", false);
        }

        function removeCategory(categoryIdx) {
            $('.category-list__item[data-category_code="'+categoryIdx+'"]').remove();
            $('#default-modal .content__list.category li input[data-category_code="'+categoryIdx+'"]:checked').attr('checked', false);

            selectCategory();
        }

        // 선택 카테고리 적용
        function selectCategory() {
            var url = '/product/new'
            var query = "?ca=";

            if ($('.content__list.category li input:checked').length > 0) {
                $('.content__list.category li input:checked').map(function() {
                    query += $(this).data('category_code') + "|";
                })

                url += query.slice(0, -1);
            }
            closeModal('#default-modal');

            location.replace(url);
        }
    </script>
@endsection
