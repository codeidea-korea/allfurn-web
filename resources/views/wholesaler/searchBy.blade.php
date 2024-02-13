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
                    <p class="sub-category__item"><a href="/product/search?kw={{$_GET['kw']}}">상품</a></p>
                    <p class="sub-category__item sub-category__item--active"><a>업체</a></p>
                </div>
            </div>

            @if($data['list']->total() > 0)
                <div class="contents">
                    <div class="category-type">
                        <div class="category-type__item">
                            <a href="#" class="category-type__item-1 @if(isset($_GET['ca']) && $_GET['ca'] != '') category-btn--active @endif" onclick="openModal('#modal-category')">
                                카테고리
                                <span class="category__count">
                                    @if(isset($_GET['ca']) && $_GET['ca'] != '')
                                            <?php echo sizeof(explode('|', $_GET['ca'])); ?>
                                    @endif
                                </span>
                                <i class="ico__arrow--down14"></i>
                            </a>
                            <a href="#" class="category-type__item-2 @if(isset($_GET['lo']) && $_GET['lo'] != '') category-btn--active @endif"  onclick="openModal('#modal-category-2')">
                                소재지
                                <span class="category__count">
                                    @if(isset($_GET['lo']) && $_GET['lo'] != '')
                                            <?php echo sizeof(explode('|', $_GET['lo'])); ?>
                                    @endif
                                </span>
                                <i class="ico__arrow--down14"></i>
                            </a>
                        </div>
                    </div>
                    <div class="category-data category-data--modify">
                        <div class="category-data__wrap">
                            <div class="category-data__wrap--first"></div>
                            <div class="category-data__wrap--second"></div>
                        </div>
                        <a href="#" class="category-filter__refresh">
                            <span>초기화</span>
                            <i class="ico__refresh"></i>
                        </a>
                    </div>

                    <div class="product">
                        <div class="product__text--wrap">
                            <p class="product__count">‘{{$_GET['kw']}}' 검색 결과 총 {{number_format($data['list']->total())}}개의 상품</p>
                            <a href="#" class="product__filter filter--order" onclick="openModal('#default-modal')">
                                <i class="ico__filter"><span class="a11y">필터 아이콘</span></i>
                                <span>추천순</span>
                            </a>
                        </div>
                    </div>
                    <div class="category-product" style="margin-bottom: 100px;">
                        @foreach($data['list'] as $item)
                            <div class="category-product__item">
                                <div class="category-product__head">
                                    <div class="category-product__info">
                                        <div class="category-product__infomation">
                                            <a href="/wholesaler/detail/{{$item->companyIdx}}" class="category-product__wrap">
                                                <p style="background-image:url('@if($item->imgUrl != null) {{$item->imgUrl}} @else /images/sub/thumbnail@2x.png @endif')" class="category-product__logo">
                                                    <span class="a11y">로고</span>
                                                </p>
                                                <div class="category-product__description">
                                                    <p class="category-product__title">
                                                        <span class="category-product__title-inner">{{$item->companyName}}</span>
                                                        @if($item->isNew == 1)
                                                            <span class="category-product__date">NEW</span>
                                                        @endif
                                                    </p>
                                                    <p class="category-product__position">{{$item->location}}</p>
                                                    <span class="category-product__type">{{$item->categoryName}}</span>
                                                </div>
                                            </a>
                                            <a href="#" class="category-product__heart @if($item->isLike > 0) active @endif" data-company_idx={{$item->companyIdx}} onclick="addLike({{$item->companyIdx}})">
                                                <i class="@if($item->isLike > 0) ico__heart @else ico__unheart @endif"></i>
                                                <span @if($item->isLike > 0) style="color: rgb(251, 71, 96);" @endif>좋아요</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="category-product__content">
                                    @foreach($item->imgList as $img)
                                        <a href="/product/detail/{{$img->idx}}">
                                            <span class="category-product__img" style="background-image:url('{{$img->imgUrl}}')"></span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="pagenation pagination--center mt0">
                        {{ $data['list']->withQueryString()->links() }}
                    </div>
                </div>
            @else
            <!--data 없을때-->
                <div class="no-data">
                  <p>
                    <i class="ico__search-circle"></i>
                    ‘{{$_GET['kw']}}’ 에 대한 업체 검색 결과가 없습니다.
                  </p>
                  <a href="{{route('wholesaler.index')}}">올펀 업체 보러가기</a>
                </div>
            @endif
        </div>
        <!-- 추천순 팝업 -->
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
                                <input type="radio" name="order" class="checkbox__checked" data-sort="new" @if(isset($_GET['so']) && $_GET['so'] == "new") checked @elseif(!isset($G_GET['so'])) checked @endif>
                                <span>추천순</span>
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="radio" name="order" class="checkbox__checked" data-sort="newreg" @if(isset($_GET['so']) && $_GET['so'] == "newreg") checked @endif>
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
                    <button type="button" class="button button--solid"  onclick="selectCategory()" >선택 완료</button>
                </div>
            </div>
        </div>

        <!-- 카테고리 선택 팝업 -->
        <div id="modal-category" class="modal modal-category modal-category--modify">
            <div class="modal__container">
                <div class="modal__content">
                    <div class="modal-box__container" style="width: 480px;">
                        <div class="modal-box__content">
                            <div class="header">
                                <p>카테고리 선택</p>
                            </div>
                            <div class="content">
                                @foreach($categoryList as $key=>$item)
                                    <label for="category__check-{{$key}}" class="category__check">
                                        <input type="checkbox" id="category__check-{{$key}}" data-category_code="{{$item->code}}"  @if(isset($_GET['ca']) && strpos($_GET['ca'], $item->code) !== false) checked @endif >
                                        <span>{{$item->name}}</span>
                                    </label>
                                @endforeach
                            </div>
                            <div class="footer">
                                <div class="modal__buttons modal__buttons--half">
                                    <button type="button" onclick="" class="modal__button modal__buttons--refresh">
                                        <i class="ico__refresh"></i>
                                        초기화
                                    </button>
                                    <button type="button" onclick="selectCategory()" class="modal__button modal__buttons--search">업체 찾아보기</button>
                                </div>
                            </div>
                            <div class="modal-close">
                                <button type="button" class="modal__close-button" onclick="closeModal('.modal-category')"><span class="a11y">close</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 소재지 선택 팝업 -->
        <div id="modal-category-2" class="modal modal-category-2 modal-category--modify">
            <div class="modal__container">
                <div class="modal__content">
                    <div class="modal-box__container" style="width: 480px;">
                        <div class="modal-box__content">
                            <div class="header">
                                <p>소재지 선택</p>
                            </div>
                            <div class="content" style="overflow: auto;">
                                @foreach(config('constants.REGIONS.KR') as $key=>$location)
                                    <label for="category__check-2-{{$key + 1}}" class="category__check">
                                        <input type="checkbox" id="category__check-2-{{$key + 1}}" data-location="{{$location}}" @if(strpos($query['location'], $location) !== false) checked @endif >
                                        <span>{{$location}}</span>
                                    </label>
                                @endforeach
                            </div>
                            <div class="footer">
                                <div class="modal__buttons modal__buttons--half">
                                    <button type="button" onclick="" class="modal__button modal__buttons--refresh">
                                        <i class="ico__refresh"></i>
                                        초기화
                                    </button>
                                    <button type="button" onclick="selectCategory()" class="modal__button modal__buttons--search">업체 찾아보기</button>
                                </div>
                            </div>
                            <div class="modal-close">
                                <button type="button" class="modal__close-button" onclick="closeModal('.modal-category-2')"><span class="a11y">close</span></button>
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
        var isProc = false;

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

        $('.change_target').on('click', function () {
            if (!$(this).parent().is('.sub-category__item--active')) {
                location.replace('/'+$(this).data('target')+'/search'+$(location).attr('search'));
            }
        });

        // category > checked reset
        function reset(set) {
            var $id = $(set).parents('.default-modal--category');
            $($id).find('input[type=checkbox]').prop("checked", false);
        }

        function selectCategory() {
            var category = "";
            var location = "";
            var sort = $('#default-modal .content__list .input[name="order"]:checked').data('sort');

            $('#modal-category .content input:checked').map(function() {
                category += $(this).data('category_code') + "|";
            })
            $('#modal-category-2 .content input:checked').map(function() {
                location += $(this).data('location') + "|";
            })

            if (category != '') {
                category = "&ca="+category.slice(0, -1);
            }
            if (location != '') {
                location = "&lo="+location.slice(0, -1);
            }

            window.location.href = '/wholesaler/search?kw={{$_GET['kw']}}'+category+location;
        }

        $('body').on('click', '.prop_btn, .category-filter__footer button, .sort_btn', function () {
            if ($(this).is('.category-filter__footer')) {
                text = $(this).find('span').text();
                $(this).remove();

                $('.select-button').map(function () {
                    if ($(this).text() == text) {
                        $(this).parent().removeClass('select-button');
                    }
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
            if (urlSearch.get('so') != null) {
                url += '&so='+$('input[name="order"]:checked').data('sort')
            }

            location.replace(url+'&prop='+prop.slice(0, -1));
        })

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


        $('body').on('click', '.category-list__item', function () {
            if ($(this).find('a').is('[data-category_type="category"]')) {
                $('#default-modal01 .content__list input:checked[data-category_code="'+$(this).find('a').data('category_code')+'"]').prop('checked', false);
            } else {
                $('#default-modal02 .content__list.location input:checked[data-location="'+$(this).find('a').data('location')+'"]').prop('checked', false);
            }

            selectCategory();
        })
    </script>
@endsection
