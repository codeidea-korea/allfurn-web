@extends('layouts.app')

@section('content')
@include('layouts.header')

<div id="content">
    @include('community.community-tab')
    
    <section class="sub_section sub_section_top">
        <div class="inner">
            <div class="main_tit mb-8 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>가구인들의 모임</h3>
                </div>
            </div>

            <div class="group_detail">
                <div class="left_info">
                    <div class="img_box">
                        <img src="/img/group_img.png" alt="">
                    </div>
                    <div class="name">
                        <h5>{{ $club->name }}</h5>
                        <p>{{ $club->summary }}</p>
                    </div>
                    <button class="btn btn-gray thin w-full mt-4">회원가입</button>

                    <div class="member_list">
                        <div class="top">
                            <div class="member">
                                <svg class="w-4 h-4"><use xlink:href="{{ $club->imgUrl }}"></use></svg>
                                회원수 : {{ $club->member_count + 1 }}
                            </div>
                            <button class="member_btn">전체 회원 <span>닫기</span><svg class="w-5 h-5"><use xlink:href="/img/icon-defs.svg#member_arrow"></use></svg></button>
                        </div>
                        <ul class="member_list_box">
                            <li class="head"><a {{ $club->haveHomepage ? 'href=/wholesaler/detail/'.$club->manager_idx : '' }}>
                                <p>
                                    <span class="head">
                                        @if($club->manager_type == 'W')
                                            제도/도매
                                        @elseif($club->manager_type == 'R')
                                            판매/매장
                                        @else
                                            일반
                                        @endif
                                    </span>
                                        <img src="/img/icon/crown2.png" alt="">
                                    {{ $club->manager_name }}
                                </p>
                                <div class="right_link">
                                    <svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg>
                                </div>
                            </a></li>
                            @foreach ( $club->member as $member )
                                <li class="head"><a {{ $member->haveHomepage ? 'href=/wholesaler/detail/'.$member->user_cidx : '' }}>
                                    <p>
                                        <span class="{{ $member->is_manager ? 'head' : '' }}">
                                            @if($member->user_ctype == 'W')
                                                제도/도매
                                            @elseif($member->user_ctype == 'R')
                                                판매/매장
                                            @else
                                                일반
                                            @endif
                                        </span>
                                        @if ($member->is_manager)
                                            <img src="/img/icon/crown2.png" alt="">
                                        @endif
                                        {{ $member->user_cname }}
                                    </p>
                                    @if ($member->haveHomepage)
                                        <div class="right_link">
                                            <svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg>
                                        </div>
                                    @endif
                                </a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="right_box">
                    <div class="community_list">
                        <ul>
                            @foreach ($club->article as $article)
                                <li>
                                    <div class="txt_box">
                                        <div class="top">
                                            <a href="/community/club/article/detail/{{$article->idx}}">
                                                <div class="category">
                                                    @if( $article->is_notice )
                                                        <span class="notice">공지</span>
                                                    @endif
                                                    <b>{{ $article->user_cname }}</b>
                                                </div>
                                                <div class="title">{{ $article->title }}</div>
                                            </a>
                                        </div>
                                        <div class="bot">
                                            <div class="info">
                                                <svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#commu_view"></use></svg>
                                                <span>{{ $article->view_count }}</span>
                                                <svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#zzim"></use></svg>
                                                <span>{{ $article->like_count }}</span>
                                                <svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#commu_comment"></use></svg>
                                                <span>{{ $article->comment_count }}</span>
                                            </div>
                                            <div class="date">{{ $article->diff_time }}</div>
                                        </div>
                                    </div>
                                    @if($article->imgUrl)
                                        <div class="img_box">
                                            <a href="javascript:;">
                                                <img src="{{ $article->imgUrl }}" alt="">
                                            </a>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </section>

   
</div>
<script>
    $('.member_list .member_btn').on('click',function(){
        let text = $(this).find('span').text();
        $(this).toggleClass('off')
        if(text == "닫기"){
            $(this).find('span').text("열기");
        }else{
            $(this).find('span').text("닫기");
        }
        $('.member_list .member_list_box').slideToggle();
    })
</script>
@endsection