@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
    <div id="container" class="container">
        <div class="inner">
            <div class="content">
                @if(sizeof($data['banner_top']) > 0)
                    <div id="eventkvSwipe" class="eventkeyvisual swiper-container eventkeyvisual--inner radius--none">
                        <div class="swiper-wrapper">
                            @foreach($data['banner_top'] as $banner)
                                <div class="swiper-slide">
                                    <?php
                                        $link = '';
                                        switch ($banner->web_link_type) {
                                            case 0: //Url
                                                $link = $banner->web_link;
                                                break;
                                            case 1: //상품
                                                // $link = '/product/detail/'.$banner->web_link;
                                                $link = $banner->web_link;
                                                break;
                                            case 2: //업체
                                                // $link = '/wholesaler/detail/'.$banner->web_link;
                                                $link =$banner->web_link;
                                                break;
                                            case 3: //커뮤니티
                                                // $link = '/community/detail/'.$banner->web_link;
                                                $link = $banner->web_link;
                                                break;
                                            default: //공지사항
                                                // $link = '/help/notice/'.$banner->web_link;
                                                $link = '/help/notice/';
                                                break;
                                        }
                                    ?>
                                    <a href="{{$link}}">
                                        <p class="event__banner" style="background-image:url({{preImgUrl().$banner->attachment->folder."/".$banner->attachment->filename}})"></p>
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
                <div class="category-btn-group" style="margin-top: 40px;">
                    <div class="category-btn category-btn--01 @if($query['category'] != '') category-btn--active @endif" onclick="openModal('#default-modal01')">
                        <p class="category-btn__text">
                            카테고리
                            <span class="category-btn__count">
                                @if($query['category'] != '')
                                    <?php echo sizeof(explode('|', $query['category'])); ?>
                                @endif
                            </span>
                        </p>
                        <i class="ico__arrow--down14"><span class="a11y">아래 화살표</span></i>
                        <i class="ico__arrow--down14-red"><span class="a11y">위 화살표</span></i>
                    </div>
                    <div class="category-btn category-btn--02 @if($query['location'] != '') category-btn--active @endif" onclick="openModal('#default-modal02')">
                        <p class="category-btn__text">
                            소재지
                            <span class="category-btn__count">
                                @if($query['location'] != '')
                                        <?php echo sizeof(explode('|', $query['location'])); ?>
                                @endif
                            </span>
                        </p>
                        <i class="ico__arrow--down14"><span class="a11y">아래 화살표</span></i>
                        <i class="ico__arrow--down14-red"><span class="a11y">위 화살표</span></i>
                    </div>
                    <div class="category-btn category-btn--order" onclick="openModal('#default-modal03')">
                        <p class="category-btn__text">
                            @if(isset($_GET['so']))
                                @switch($_GET['so'])
                                    @case("new")
                                        추천순
                                        @break
                                    @case('newreg')
                                        최근 상품 등록순
                                        @break
                                    @case('search')
                                        검색 많은 순
                                        @break
                                    @case('order')
                                        거래 많은 순
                                        @break
                                    @case('manyprod')
                                        상품 많은 순
                                        @break
                                    @case('word')
                                        가나다 순
                                        @break
                                @endswitch
                            @else
                                최근 상품 등록순
                            @endif
                        </p>
                    </div>
                </div>

                <!-- 카테고리, 소재지 선택시 노출 -->
                @if($query['category'] != '' || $query['location'] != '')
                <div class="category-list category-list--wholesaler">
                    <div>
                        @if($query['category'] != '' )
                            <ul class="category-list__wrap category">
                                @foreach($categoryList as $item)
                                    @if(strpos($query['category'], $item->code) !== false)
                                    <li class="category-list__item">
                                        <p class="category-list__name">{{$item->name}}</p>
                                        <a data-category_code="{{$item->code}}" data-category_type="category" class="ico__delete16"><span class="a11y">삭제</span></a>
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                        @if($query['location'] != '')
                            <ul class="category-list__wrap location">
                                <?php $locationArr = explode('|', $query['location']); ?>
                                @foreach($locationArr as $loc)
                                    <li class="category-list__item">
                                        <p class="category-list__name">{{$loc}}</p>
                                        <a data-location="{{$loc}}" data-category_type="location" class="ico__delete16"><span class="a11y">삭제</span></a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="category-list__refresh">
                        <a href="/wholesaler">
                            <p class="category-list__refresh__text">초기화</p>
                            <i class="ico__refresh"><span class="a11y">초기화</span></i>
                        </a>
                    </div>
                </div>
                @endif

                <div class="wholesaler__company">
                    <p class="company__count">전체 <span>{{$data['list']->total()}}</span>개</p>
                    <ul class="company__list">
                        @foreach($data['list'] as $item)
                            <li class="list__item">
                                <a href="/wholesaler/detail/{{$item->companyIdx}}" title="업체 상세페이지로 이동">
                                    <div class="company__info">
                                        <div class="company__desc">
                                            <div class="company__img">
                                                <img src="@if($item->imgUrl != null) {{$item->imgUrl}} @else /images/sub/thumbnail@2x.png @endif" alt="썸네일">
                                            </div>
                                            <div>
                                                <div class="company__name">
                                                    <p class="name">{{$item->companyName}}</p>
                                                    @if($item->isNew == 1)
                                                        <p class="badge">NEW</p>
                                                    @endif
                                                </div>
                                                <p class="company__location">{{$item->location}}</p>
                                                <ul>
                                                    <li class="company__product">{{$item->categoryName}}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="company__product-list">
                                        @foreach($item->imgList as $img)
                                            <li>
                                                <a href="/product/detail/{{$img->idx}}">
                                                    <img src="{{$img->imgUrl}}" alt="상품01" style="object-fit: cover;width: 275px;height: 275px;">
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </a>

                                <div class="company__right-wrap position--absolute">
                                    <div class="company__like @if($item->isLike > 0) active @endif " data-company_idx={{$item->companyIdx}} onclick="addLike({{$item->companyIdx}})">
                                        <i class="like"><span class="a11y">좋아요</span></i>
                                        <p>좋아요</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <div class="pagenation pagination--center mt0">
                        {{ $data['list']->withQueryString()->links() }}
                    </div>
                </div>
            </div>

            <!-- 카테고리 팝업 -->
            <div id="default-modal01" class="default-modal default-modal--category">
                <div class="default-modal__container">
                    <div class="default-modal__header">
                        <h2>카테고리 선택</h2>
                        <button type="button" class="ico__close28" onclick="closeModal('#default-modal01')">
                            <span class="a11y">닫기</span>
                        </button>
                    </div>
                    <div class="default-modal__content">
                        <ul class="content__list">
                            @foreach($categoryList as $key=>$item)
                                <li>
                                    <label for="category-check{{sprintf('%02d',$key)}}">
                                        <input type="checkbox" id="category-check{{sprintf('%02d',$key)}}" class="checkbox__checked"
                                               data-category_code="{{$item->code}}" @if(strpos($query['category'], $item->code) !== false) checked @endif >
                                        <span>{{$item->name}}</span>
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
                        <button type="button" class="button button--solid" onclick="selectCategory()">업체 찾아보기</button>
                    </div>
                </div>
            </div>

            <!-- 소재지 팝업 -->
            <div id="default-modal02" class="default-modal default-modal--category">
                <div class="default-modal__container">
                    <div class="default-modal__header">
                        <h2>소재지 선택</h2>
                        <button type="button" class="ico__close28" onclick="closeModal('#default-modal02')">
                            <span class="a11y">닫기</span>
                        </button>
                    </div>
                    <div class="default-modal__content">
                        <ul class="content__list">

                            @foreach(config('constants.REGIONS.KR') as $key=>$location)
                                <li>
                                    <label for="location-check0{{$key}}">
                                        <input type="checkbox" id="location-check0{{$key}}" class="checkbox__checked" data-location="{{$location}}" @if(strpos($query['location'], $location) !== false) checked @endif >
                                        <span>{{$location}}</span>
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
                        <button type="button" class="button button--solid" onclick="selectCategory()">업체 찾아보기</button>
                    </div>
                </div>
            </div>

            <!-- 추천순 팝업 -->
            <div id="default-modal03" class="default-modal default-modal--radio">
                <div class="default-modal__container">
                    <div class="default-modal__header">
                        <h2>정렬 선택</h2>
                        <button type="button" class="ico__close28" onclick="closeModal('#default-modal03')">
                            <span class="a11y">닫기</span>
                        </button>
                    </div>
                    <div class="default-modal__content">
                        <ul class="content__list">
                            <li>
                                <label>
                                    <input type="radio" name="order" class="checkbox__checked" data-sort="new" @if(isset($_GET['so']) && $_GET['so'] == "new") checked @endif>
                                    <span>추천순</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="radio" name="order" class="checkbox__checked" data-sort="newreg" @if(isset($_GET['so']) && $_GET['so'] == "newreg") checked @elseif(!isset($G_GET['so'])) checked @endif>
                                    <span>최근 상품 등록순</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="radio" name="order" class="checkbox__checked" data-sort="search" @if(isset($_GET['so']) && $_GET['so'] == "search") checked @endif>
                                    <span>검색 많은 순</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="radio" name="order" class="checkbox__checked" data-sort="order" @if(isset($_GET['so']) && $_GET['so'] == "order") checked @endif>
                                    <span>거래 많은 순</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="radio" name="order" class="checkbox__checked" data-sort="manyprod" @if(isset($_GET['so']) && $_GET['so'] == "manyprod") checked @endif>
                                    <span>상품 많은 순</span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="radio" name="order" class="checkbox__checked" data-sort="word" @if(isset($_GET['so']) && $_GET['so'] == "word") checked @endif>
                                    <span>가나다 순</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="default-modal__footer">
                        <button type="button" class="button button--solid" onclick="selectCategory()">선택 완료</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        isProc = false
        $(document).ready(function(){


        });

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

        // 카테고리 선택 처리
        function selectCategory() {
            closeModal('#default-modal01, #default-modal02');

            var category = "";
            var location = "";

            var sort = "&so="+$('#default-modal03 .content__list input[name="order"]:checked').data('sort');
            $('#default-modal01 .content__list input:checked').map(function() {
                category += $(this).data('category_code') + "|";
            })
            $('#default-modal02 .content__list input:checked').map(function() {
                location += $(this).data('location') + "|";
            })

            if (category != '') {
                category = "ca="+category.slice(0, -1);
            }
            if (location != '') {
                location = "&lo="+location.slice(0, -1);
            }

            window.location.href = '/wholesaler?'+category+location+sort;
        }

        // 좋아요
        function addLike(idx) {
            if (isProc) {
                return;
            }
            isProc = true;

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url             : '/wholesaler/like/'+idx,
                enctype         : 'multipart/form-data',
                processData     : false,
                contentType     : false,
                data			: {},
                type			: 'POST',
                success: function (result) {
                    if (result.success) {
                        if (result.like == 0) {
                            $('.company__like.active[data-company_idx='+idx+']').removeClass('active');
                        } else {
                            $('.company__like[data-company_idx='+idx+']').addClass('active');
                        }
                    } else {
                        alert(reslult.message);
                    }

                    isProc = false;
                }
            });
        }

        // 카테고리 선택
        $('body').on('click', '.category-list__item', function () {
            if ($(this).find('a').is('[data-category_type="category"]')) {
                $('#default-modal01 .content__list input:checked[data-category_code="'+$(this).find('a').data('category_code')+'"]').prop('checked', false);
            } else {
                $('#default-modal02 .content__list input:checked[data-location="'+$(this).find('a').data('location')+'"]').prop('checked', false);
            }
            $(this).remove();

            selectCategory();
        })
    </script>
@endsection
