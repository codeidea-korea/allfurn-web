@extends('layouts.app')

@section('content')
@include('layouts.header')

<div id="content">
    @include('community.community-tab')
    @include('community.community-banner')
    
    <section class="sub_section community_con01">
        <div class="inner">

            <div class="tab_layout type02">
                <ul>
                    <li class="{{ !isset($board_name) || empty($board_name) ? 'active' : ''}}">
                        <a href="javascript:;" onclick="getBoardList('전체')">전체</a>
                    </li>
                    @foreach ($boards as $board)
                        <li class="{{ isset($board_name) && $board->name == $board_name ? 'active' : '' }}">
                            <a href="javascript:;" onclick="getBoardList('{{$board->name}}')">{{$board->name}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="title mb-6">
                <div class="search_box">
                    <input type="text" class="input-form" placeholder="글 제목이나 작성자를 검색해주세요" value={{ isset($keyword) ? $keyword : ''}}>
                    <button><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#news_search"></use></svg></button>
                    <div class="absolute w-full p-4 bg-white rounded-md z-999 shadow-md search_list hidden">
                        <div class="text-sm flex justify-between py-3">
                            <span class="font-bold">최근 검색어</span>
                            <button class="text-gray-400">전체 삭제</button>
                        </div>
                        <div class='search-list_wrap'>
                            <ul class="flex flex-col gap-4">
                                @foreach($searches as $search)
                                    <li class="flex items-center justify-between text-sm" data-search-id="{{$search->idx}}">
                                        <a href="javascript:;" onclick="doSearch('{{$search->keyword}}')">{{$search->keyword}}</a>
                                        <button onclick="deleteSearchList({{$search->idx}})">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-gray-400"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
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
                                    <div class="img_box"><a href="/community/detail/{{$article->idx}}">
                                        @if($article->content)
                                            @php
                                                $tmp = '';
                                                $pos = strpos($article->content, '<img src=', 0);
                                                
                                                if ( $pos !== false ) {
                                                    
                                                    $pos_from = strpos($article->content, 'https', $pos);
                                                    $pos_to = strpos($article->content, '>', $pos_from);
                                                    $sub = substr($article->content, $pos_from, $pos_to);
                                                    $image_end = strpos($sub, '.jpg');
                                                    
                                                    if ($image_end) {
                                                        $tmp = substr($sub, 0, $image_end + 4);
                                                    } else {
                                                        $image_end = strpos($sub, '.png');
                                                        $tmp = substr($sub, 0, $image_end + 4);
                                                    }
                                                    
                                                }
                                            @endphp
                                            <img src="{{ $tmp ? $tmp : '' }}" alt="">
                                        @endif
                                    </a></div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="pagenation flex items-center justify-center py-12">
                @if($pagination['prev'] > 0)
                    <a href="javascript:;" onclick="getArticlesForPage({{$pagination['prev']}})">
                        <
                    </a>
                @endif
                @foreach($pagination['pages'] as $paginate)
                        <a href="javascript:;" class="{{$paginate == $offset ? 'active' : ''}}" onclick="getArticlesForPage({{$paginate}})">
                            {{$paginate}}
                        </a>
                @endforeach
                @if($pagination['next'] > 0)
                    <a href="javascript:;" onclick="getArticlesForPage({{$pagination['next']}})">
                        >
                    </a>
                @endif
            </div>
            <div class="community_write_btn">
                <a href="/community/write" class="btn btn-round btn-primary px-4"><svg class="w-5 h-5 mr-1"><use xlink:href="/img/icon-defs.svg#write_add"></use></svg>글쓰기</a>
            </div>
        </div>
        
    </section>

</div>


<script>

    // // 탭 컨트롤
    // $('.tab_layout li').on('click',function(){
    //     let liN = $(this).index();
    //     $(this).addClass('active').siblings().removeClass('active');
    //     $('.tab_content > div').eq(liN).addClass('active').siblings().removeClass('active');
    // })

    $(document).on('click', function(e) {
        // .search_active 클릭 시 .search_list 보이기
        if ($(e.target).closest('.search_box').length) {
            $('.search_list').show();
        }
        // .search_list 외의 영역 클릭 시 숨기기
        else if (!$(e.target).closest('.search_box').length) {
            $('.search_list').hide();
        }
    });

    $(document).on('keyup', '.search_box .input-form', function(evt) {
        if (evt.key === 'Enter') {
            doSearch(evt.currentTarget.value);
        }
    });

    //검색어
    function doSearch(keyword) {
        location.replace("/community?" + new URLSearchParams({keyword: keyword}));
    }

    //검색어 삭제
    function deleteSearchList(idx) {
        if(idx !== undefined) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                url: "/community/search-keyword/" + idx,
                type: 'DELETE',
                success: function (result) {
                    if(result.result === 'success') {
                        refreshSearchKeyword(idx);
                    }
                },
            })
        }
    }

    function refreshSearchKeyword(idx) {
        $('[data-search-id="' +idx + '"]').remove();
    }

    // 카테고리 이동
    function getBoardList(boardName) {
        location.replace("/community?" + new URLSearchParams({board_name: boardName}));
    }

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