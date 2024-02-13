@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
<div id="container" class="container">
    <div class="inner__full">
        <div id="kvswiper" class="eventkeyvisual swiper-container">
            <div class="swiper-wrapper">
                @foreach($banners as $banner)
                <div class="swiper-slide">
                    <a href="{{ strpos($banner->web_link, 'help/notice') !== false ? '/help/notice/' : $banner->web_link }}">
                        <p class="event__banner" style="background-image:url({{ $banner->image_url }})"></p>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="swiper-util">
                <div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <!-- <div class="swiper-button-wrap"> -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            <!-- </div> -->
        </div>
    </div>

    <div class="inner">
        <div class="content">
            <ul class="magazine__wrap" style="margin-bottom: -40px;">
                @foreach($list as $row)
                <li class="magazine__list">
                    <a href="/magazine/detail/{{ $row->idx }}" title="{{ $row->title }}">
                        <div class="magazine__img">
                            <img src="{{ $row->image_url }}" alt="{{ $row->title }}">
                        </div>
                        <div class="magazine__text">
                            <h3>{{ $row->title }}</h3>
                            @if ($row->start_date && $row->start_date !== '0000-00-00' && $row->end_date && $row->end_date !== '0000-00-00')
                                <p>{{ $row->start_date }} - {{ $row->end_date }}</p>
                            @endif
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>

            <div class="pagenation pagination--center">
                @if($pagination['prev'] > 0)
                <button type="button" class="prev" onclick="moveToList({{$pagination['prev']}})">
                    <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 1L1 6L6 11" stroke="#DBDBDB" stroke-width="1.7" stroke-linecap="round"
                              stroke-linejoin="round" />
                    </svg>
                </button>
                @endif
                <div class="numbering">
                    @foreach($pagination['pages'] as $paginate)
                        @if ($paginate == $offset)
                            <a href="javascript:void(0)" onclick="moveToList({{$paginate}})" class="numbering--active">{{$paginate}}</a>
                        @else
                            <a href="javascript:void(0)" onclick="moveToList({{$paginate}})">{{$paginate}}</a>
                        @endif
                    @endforeach
                </div>
                @if($pagination['next'] > 0)
                <button type="button" class="next" onclick="moveToList({{$pagination['next']}})">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12L10 7L5 2" stroke="#828282" stroke-width="1.7" stroke-linecap="round"
                              stroke-linejoin="round" />
                    </svg>
                </button>
                @endif
            </div>
        </div>
    </div>
</div>

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
    
    
    
    function moveToList(page) {
        
        location.replace(location.pathname + "?" + new URLSearchParams({offset:page}));
        
    }
    
</script>



@endsection
