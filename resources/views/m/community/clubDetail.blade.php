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

    <section class="sub_section_top">
        <div class="inner">
            <div class="main_tit mb-5 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>가구인들의 모임</h3>
                </div>
            </div>
        </div>

        <div class="group_detail">
            <div class="left_info">
                <div class="name">
                    <h5>{{ $club->name }}</h5>
                    <p class="txt-gray">{{ $club->summary }}</p>
                </div>
                <div class="img_box">
                    <img src="{{ $club->imgUrl }}" alt="">
                </div>
                <button class="btn btn-gray thin w-full mt-4 btnClubRegister" data-cidx="{{ $club->idx }}">회원가입</button>

                <div class="member_list">
                    <div class="top">
                        <div class="member">
                            <svg class="w-4 h-4"><use xlink:href="/img/icon-defs.svg#member"></use></svg>
                            회원수 : {{ $club->member_count+1 }}
                        </div>
                        <button class="member_btn">전체 회원 <span>닫기</span><svg class="w-5 h-5"><use xlink:href="/img/icon-defs.svg#member_arrow"></use></svg></button>
                    </div>
                    <ul class="member_list_box">
                        <li class="head"><a {{ (in_array($club->manager_type, array('W','R'))) ? 'href=/wholesaler/detail/'.$club->manager_idx : '' }}>
                            <p>
                                <span class="head">
                                    @if($club->manager_type == 'W')
                                        제조/도매
                                    @elseif($club->manager_type == 'R')
                                        판매/매장
                                    @else
                                        일반
                                    @endif
                                </span>
                                <img src="/img/icon/crown2.png" alt="">
                                {{ $club->manager_name }}
                            </p>
                            @if ($club->manager_idx == Auth::user()['company_idx'])
                                <div class="right_link">
                                    {{-- <svg class="w-6 h-6"><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg> --}}
                                </div>
                            @endif 
                        </a></li>
                        @foreach ( $club->member as $member )
                            <li><a {{ (in_array($member->user_ctype, array('W','R'))) ? 'href=/wholesaler/detail/'.$member->user_cidx : '' }}>
                                <p>
                                    <span class="{{ $member->is_manager ? 'head' : '' }}">
                                        @if($member->user_ctype == 'W')
                                            제조/도매
                                        @elseif($member->user_ctype == 'R')
                                            판매/매장
                                        @else
                                            일반
                                        @endif
                                    </span>
                                    {{ $member->user_cname }}
                                </p>
                                @if ($club->manager_idx == Auth::user()['company_idx'])
                                    <div class="right_link">
                                        {{-- <svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg> --}}
                                        <button class="btnClubForceWithdrawal" data-midx="{{ $member->idx }}">탈퇴</button>
                                    </div>
                                @elseif ($member->user_cidx == Auth::user()['company_idx'])
                                    <div class="right_link">
                                        {{-- <svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg> --}}
                                        <button class="btnClubWithdrawal" data-midx="{{ $member->idx }}">탈퇴</button>
                                    </div>
                                @endif 
                            </a></li>
                        @endforeach 
                    </ul>
                </div>
            </div>

            @if(count($club->article)> 0)
                <div class="inner">
                    <div class="right_box">
                        <div class="community_list">
                            <ul>
                                @foreach ($club->article as $article)
                                    <li>
                                        <div class="txt_box">
                                            <div class="top">
                                                <a href="/community/club/article/{{$article->idx}}">
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
                                                    <span>{{ $article->hit }}</span>
                                                    <svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#zzim"></use></svg>
                                                    <span>{{ $article->like_count }}</span>
                                                    <svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#commu_comment"></use></svg>
                                                    <span>{{ $article->comment_count }}</span>
                                                </div>
                                                <div class="date">{{ $article->diff_time }}</div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @else 
                <div class="inner">
                    <div>
                        게시글이 없습니다.
                    </div>
                </div>
            @endif 
            <div class="inner" style="margin-top: 20px">
                <div class="community_write_btn">
                    <a href="/community/club/{{$club->idx}}/write" class="btn btn-round btn-primary px-4"><svg class="w-5 h-5 mr-1"><use xlink:href="/img/icon-defs.svg#write_add"></use></svg>글쓰기</a>
                </div>
            </div>
        </div>
    </section>

    @if(isset($message))
        <div class="modal" id="inform-modal">
            <div class="modal_bg" onclick="modalClose('#inform-modal')"></div>
            <div class="modal_inner">
                <button class="close_btn" onclick="modalClose('#inform-modal')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
                <div class="modal_body agree_modal_body">
                    <p class="text-center py-4"><b>{!! $message !!}</b></p>
                    <div class="flex gap-2 justify-center">
                        <button class="btn btn-primary w-1/2 mt-5" onclick="modalClose('#inform-modal')">확인</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    @if(isset($message))
        modalOpen('#inform-modal');
    @endif

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

    $(document).on('click', '.btnClubRegister', function(){
        var clubIdx = $(this).data('cidx');
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url				: '/community/club/register',
            data			: {
                'club_idx' : clubIdx
            },
            type			: 'POST',
            dataType		: 'json',
            success		: function(result) {
                if (result.status == 2){
                    alert('가입된 회원입니다.'); return false;
                }else if (result.status == 3){
                    alert('탈퇴한 회원입니다.'); return false;
                }else if (result.status == 1){
                    alert('정상적으로 가입되었습니다.'); location.reload();
                }
            }
        });
    })

    $(document).on('click', '.btnClubWithdrawal, .btnClubForceWithdrawal', function(){
        var confirm_msg;
        if (this.className == "btnClubWithdrawal"){
            confirm_msg = "클럽을 탈퇴하시겠습니까?";
        }else if (this.className == "btnClubForceWithdrawal"){
            confirm_msg = "선택하신 회원을 탈퇴시키시겠습니까?";
        }
        if (confirm(confirm_msg)){
            console.log(1)
            var memberIdx = $(this).data('midx');
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url				: '/community/club/withdrawal',
                data			: {
                    'member_idx' : memberIdx, 
                    'club_idx' : {{ $club->idx }}
                },
                type			: 'POST',
                dataType		: 'json',
                success		: function(result) {
                    console.log(result.status)
                    if (result.status){
                        alert('정상적으로 탈퇴되었습니다.'); location.reload();
                    }
                }
            });
        }else{
            return false;
        }
    })
</script>
@endsection