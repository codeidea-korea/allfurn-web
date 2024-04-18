@extends('layouts.app_m')
@php
    $only_quick = '';
    $header_depth = 'community';
    $top_title = '';
    $header_banner = '';
@endphp
@section('content')
@include('layouts.header_m')

<div id="content">
    @include('m.community.community-tab')
    @include('m.community.community-banner')
    
    <section class="sub_section community_con01">
        <div class="inner">

            <div class="tab_layout type02">
                <ul>
                    <li class="{{ !isset($board_name) || empty($board_name) ? 'active' : ''}}">
                        <a href="javascript:(0);" onclick="getBoardList('전체')">전체</a>
                    </li>
                    @foreach ($boards as $board)
                        <li class="{{ isset($board_name) && $board->name == $board_name ? 'active' : '' }}">
                            <a href="javascript:(0);" onclick="getBoardList('{{$board->name}}')">{{$board->name}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="title mb-6">
                <div class="search_box">
                    <input type="text" class="input-form" placeholder="글 제목이나 작성자를 검색해주세요" value={{ isset($keyword) ? $keyword : ''}}>
                    <button><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#news_search"></use></svg></button>
                </div>
            </div>

            <div class="tab_content">
                <div class="subscribe_box" style="display: block;">
                    @if(isset($is_subscribed))
                        <button type="button" id="subscribe_button" class="{{ $is_subscribed ? 'active' : '' }}" onclick="toggleSubscribeBoard('{{$board_name}}')"><i></i><span>{{ $is_subscribed ? '구독중' : '구독하기' }}</span></button>
                    @endif
                </div>
                <!-- 전체 -->
                <div class="active">
                    <div class="community_list">
                        <ul>
                            @foreach ($articles as $article)
                                <li>
                                    <div class="txt_box">
                                        <div class="top">
                                            <a href="/community/detail/{{$article->idx}}">
                                                <div class="category">
                                                    <span>{{$article->board_name}}</span>
                                                    <b>{{ $article->is_admin ? '관리자' : $article->writer }}</b>
                                                </div>
                                                <div class="title">{{$article->title}}</div>
                                            </a>
                                        </div>
                                        <div class="bot">
                                            <div class="info">
                                                <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                                <span>{{$article->view_count}}</span>
                                                <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#zzim"></use></svg>
                                                <span>{{$article->like_count}}</span>
                                                <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                                <span>{{$article->reply_count}}</span>
                                            </div>
                                            <div class="date">{{$article->diff_time}}</div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="pagenation flex items-center justify-center py-12">
                @if($pagination['prev'] > 0)
                    <a href="javascript:(0);" onclick="getArticlesForPage({{$pagination['prev']}})">
                        <
                    </a>
                @endif
                @foreach($pagination['pages'] as $paginate)
                        <a href="javascript:(0);" class="{{$paginate == $offset ? 'active' : ''}}" onclick="getArticlesForPage({{$paginate}})">
                            {{$paginate}}
                        </a>
                @endforeach
                @if($pagination['next'] > 0)
                    <a href="javascript:(0);" onclick="getArticlesForPage({{$pagination['next']}})">
                        >
                    </a>
                @endif
            </div>

            <div class="write_btn">
                <a href="/community/write" class="btn btn-round btn-primary px-3"><svg><use xlink:href="/img/m/icon-defs.svg#write_pencil"></use></svg></a>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).on('keyup', '.search_box .input-form', function(evt) {
        if (evt.key === 'Enter') {
            doSearch(evt.currentTarget.value);
        }
    });

    $(document).on('click', '.search_box button', function(e) {
        doSearch(e.currentTarget.previousElementSibling.value)
    });

    //검색
    function doSearch(keyword) {
        location.replace("/community?" + new URLSearchParams({keyword: keyword}));
    }

    // 카테고리 이동
    function getBoardList(boardName) {
        location.replace("/community?" + new URLSearchParams({board_name: boardName}));
    }

    //페이지 이동
    function getArticlesForPage(page) {
        let bodies = {offset:page};
        const urlSearch = new URLSearchParams(location.search);
        if (urlSearch.get('keyword')) bodies.keyword = urlSearch.get('keyword');
        if (urlSearch.get('board_name')) bodies.board_name = urlSearch.get('board_name');
        location.replace("/community?" + new URLSearchParams(bodies));
    }

    //구독하기
    function toggleSubscribeBoard(boardName) {
        fetch('/community/subscribe/board', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: JSON.stringify({
                    boardName: boardName
                })
            }).then(response => {
                return response.json();
            }).then(json => {
                if (json.result === 'success') {
                    switch(json.code) {
                        case 'DEL_SUBSCRIBE':
                            document.querySelector('#subscribe_button span').textContent = '구독하기';
                            document.getElementById('subscribe_button').classList.remove('active');
                            break;
                        case 'REG_SUBSCRIBE':
                            document.querySelector('#subscribe_button span').textContent = '구독중';
                            document.getElementById('subscribe_button').classList.add('active');
                            break;
                    }
                } else {
                    alert(json.message);
                }
            })
    }
</script>
@endsection