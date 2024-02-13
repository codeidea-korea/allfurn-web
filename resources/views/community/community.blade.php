@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
<div id="container" class="container community">
    <div class="inner">
        <div class="contents">
            @if(isset($banners) && count($banners) > 0)
            <div id="kvswiper" class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($banners as $banner)
                    <div class="swiper-slide">
                        <a href="{{ strpos($banner->web_link, 'help/notice') !== false ? '/help/notice/' : $banner->web_link }}">
                            <p class="event__banner" style="background-image:url({{ preImgUrl() }}{{$banner->attachment->folder}}/{{$banner->attachment->filename}})"></p>
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
            @else
                <div class="blank"></div>
            @endif
            <div class="info">
                <div class="textfield">
                    <i class="textfield__icon ico__search"><span class="a11y">검색</span></i>

                    <input type="text" class="textfield__search textfield__search--modify" id="community_search_keyword" name="community_search_keyword" placeholder="글 제목이나 작성자를 검색해주세요." style="width: 100%;">
                    <button type="button" class="textfield__icon--delete ico__sdelete"><span class="a11y">삭제하기</span></button>
                </div>
                
                <div class="search-list">
                    <div class="search-list__head">
                        <p class="search-list__title">
                            최근 검색어
                        </p>
                        <a href="javascript:void(0)" onclick="deleteSearchList('all')" class="search-list__action">전체 삭제</a>
                    </div>
                    <div class="search-list__wrap">
                        @include('community.search-list')
                    </div>
                </div>
                <div class="post-list">
                    <ul>
                        <li class="{{ !isset($board_name) || empty($board_name) ? 'post-list__item--active' : ''}}">
                            <a href="javascript:void(0)" onclick="getBoardList('전체')">전체</a>
                        </li>
                        @foreach($boards as $board)
                            <li class="{{ isset($board_name) && $board->name == $board_name ? 'post-list__item--active' : '' }}">
                                <a href="javascript:void(0)" onclick="getBoardList('{{$board->name}}')">{{$board->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <a href="/community/my/articles" class="profile"><i class="ico__profile"></i><span>내 활동</span></a>
            </div>
            @includeWhen(Route::current()->getName() == 'community.detail', 'community.detail')
            @includeWhen(Route::current()->getName() == 'community.index', 'community.community-content')
        </div>
    </div>
</div>
@if (request()->route()->getName() == 'community.index' && count($popup) > 0)
<div id="main-event" class="modal">
    <div class="modal__container" style="width: 600px;">
        <div class="modal__content">
            <button type="button" onclick="closeModal('#main-event');" class="close-button ico_circle_delete">
                <span class="a11y">닫기</span>
            </button>
            <div class="modal-box__container">
                <div class="modal-box__content">
                    <div class="modal__desc">
                        <div class="modal-box__swiper">
                            <div id="modalkvSwipe" class="modalkeyvisual swiper-container">
                                <div class="swiper-wrapper">
                                    @foreach($popup as $item)
                                        <div class="swiper-slide">
                                            <a href="{{$item->web_type_link}}">
                                                <p class="event__banner" style="background-image:url({{$item->imgUrl}})"></p>
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
                        </div>
                    </div>
                    <div class="modal__util">
                        <a onclick="todayClose()" class="modal__hide-button"><span>오늘 하루 보지않기</span></a>
                        <a onclick="viewPopup()" class="modal__detail-button"><span>자세히 보기</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

    <script>
        const swiper = new Swiper('#kvswiper', {
            autoplay: {
            delay: 3000,
            disableOnInteraction: false,
            },
            loop: true,
            slidesPerView: 1,
            spaceBetween: 0,
            paginationClickable: false,
            keyboard: false,
            pagination: {
                el: '#kvswiper .swiper-pagination',
                type: 'fraction',
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
        $('#kvswiper').hover(function(){
            swiper.autoplay.stop();
        }, function(){
            swiper.autoplay.start();
        });

        
        function getBoardList(boardName) {
            location.replace("/community?" + new URLSearchParams({board_name: boardName}));
        }
        

        @if (request()->route()->getName() == 'community.index' && count($popup) > 0)
        const todayClose = () => {
            setCookie("communityPopup","Y");
            closeModal('#main-event');
        }

        // 24시간 기준 쿠키 설정하기
        const setCookie = function (cname, cvalue) {
            var todayDate = new Date();
            todayDate.setHours(23, 59, 59, 999);
            var expires = "expires=" + todayDate.toString(); // UTC기준의 시간에 exdays인자로 받은 값에 의해서 cookie가 설정 됩니다.
            document.cookie = cname + "=" + cvalue + "; " + expires;
        }

        const viewPopup = () => {
            location.href = $('#modalkvSwipe .swiper-slide-active a').attr('href');
        }

        $(document).ready(function(){
            const cookiedata = document.cookie;
            if(cookiedata.indexOf("communityPopup=Y")<0){
                openModal("#main-event");
            }
        });

        const modalswiper = new Swiper('#modalkvSwipe', {
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            loop: true,
            slidesPerView: 1,
            spaceBetween: 0,
            paginationClickable: true,
            keyboard: true,
            speed: 500,
            pagination: {
                el: '#modalkvSwipe .swiper-pagination',
                type: 'fraction',
            },
            navigation: {
                nextEl: '#modalkvSwipe .swiper-button-next',
                prevEl: '#modalkvSwipe .swiper-button-prev',
            },
        });
        $('#modalkvSwipe .swiper-slide').hover(function(){
            modalswiper.autoplay.stop();
        }, function(){
            modalswiper.autoplay.start();
        });
        @endif

    </script>



@endsection

@push('scripts')
    
@endpush
