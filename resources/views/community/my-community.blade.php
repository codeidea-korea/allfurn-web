@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
<div id="container" class="container community" style="min-height: calc(100vh - 409px)">
    <div class="inner">
        <div class="contents">
            <div class="blank"></div>
            <div class="info">
                <p class="info__title">내 활동</p>
                <div class="post-list">
                    <ul>
                        <li class="{{ $pageType === 'articles' ? 'post-list__item--active' : '' }}">
                            <a href="/community/my/articles">작성 글</a>
                        </li>
                        <li class="{{ $pageType === 'comments' ? 'post-list__item--active' : '' }}">
                            <a href="/community/my/comments">작성 댓글</a>
                        </li>
                        <li class="{{ $pageType === 'likes' ? 'post-list__item--active' : '' }}">
                            <a href="/community/my/likes">좋아요</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="community-content">
                <p class="community-content__linked">커뮤니티 > 내 활동 > {{ $pageName }}</p>
                <div class="dropdown" style="width: 250px; margin-top: 24px;">
                    <p class="dropdown__title">{{ request()->get('board_name') ?: '전체' }}</p>
                    <div class="dropdown__wrap">
                        <a href="/community/my/{{$pageType}}" class="dropdown__item">
                            <span>전체</span>
                        </a>
                        @foreach($boards as $board)
                        <a href="/community/my/{{$pageType}}?board_name={{$board->name}}" class="dropdown__item">
                            <span>{{$board->name}}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
                @includeWhen(in_array($pageType, ['articles', 'likes']), 'community.my-articles')
                @includeWhen($pageType === 'comments', 'community.my-comments')
            </div>
        </div>
    </div>
</div>
@endsection
