@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
    <div id="container" class="container" style="min-height: 100%;">
        <div class="my">
            <div class="inner">
                <div class="my__container">
                    <div class="my__aside">
                        <div class="content">
                            <div class="aside">
                                <h2 class="aside__title">알림센터</h2>
                                <div class="post-list">
                                    <div class="post-list__item {{ !$type ? 'post-list__item--active' : '' }}"><a href="/alarm">전체</a><div class="ico__list-link {{ !$type ? 'ico__list-link--active' : '' }}"></div></div>
                                    <div class="post-list__item {{ $type === 'order' ? 'post-list__item--active' : '' }}"><a href="/alarm/order">주문</a><div class="ico__list-link {{ $type === 'order' ? 'ico__list-link--active' : '' }}"></div></div>
                                    <div class="post-list__item {{ $type === 'active' ? 'post-list__item--active' : '' }}"><a href="/alarm/active">활동</a><div class="ico__list-link {{ $type === 'active' ? 'ico__list-link--active' : '' }}"></div></div>
                                    <div class="post-list__item {{ $type === 'news' ? 'post-list__item--active' : '' }}"><a href="/alarm/news">소식</a><div class="ico__list-link {{ $type === 'news' ? 'ico__list-link--active' : '' }}"></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="my__section">
                        <div class="content">
                            <div class="section">
                                @if ($count < 1)
                                    <div class="my-content my-content--nodata" style="margin: 38%;">
                                        <span><i class="ico__exclamation"></i></span>
                                        <p>도착한 알림이 없습니다.</p>
                                    </div>
                                @else
                                    <div class="list">
                                        <div class="notificaiton-list">
                                            @foreach($list as $row)
                                            <a href="{{ $row->web_url }}">
                                                <section class="notificaiton-list__item">
                                                <div class="my__info">
                                                    <div class="my__desc">
                                                        <div class="my__text-wrap">
                                                            <div class="my__name">
                                                                <div class="name">{{ $row->title }}</div>
                                                            </div>
                                                            <p>{!! $row->content !!}</p>
                                                            <ul>
                                                                <li class="my__list-meta">{{ $row->send_date }}</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    @if ($row->log_image)
                                                    <div class="my__right-wrap">
                                                        <div class="my__thumnail-container">
                                                            <div class="my__thumnail" style="background-image: url({{ $row->log_image }})"></div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </section>
                                            </a>
                                            @endforeach
                                        </div>
                                        <div class="pagenation">
                                            @if($pagination['prev'] > 0)
                                            <button type="button" class="prev" onclick="moveToList({{$pagination['prev']}})">
                                                <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6 1L1 6L6 11" stroke="#DBDBDB" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
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
                                            <button type="button" class="next" id="next-paginate" onclick="moveToList({{$pagination['next']}})">
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5 12L10 7L5 2" stroke="#828282" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        const moveToList = page => {
            location.replace(location.pathname + "?" + new URLSearchParams({offset:page}));
        }
    </script>    
    
@endsection

