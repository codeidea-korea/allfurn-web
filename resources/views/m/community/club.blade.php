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
    
    <section class="sub_section">
        <div class="inner">
            <div class="main_tit mb-5 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>가구인들의 모임</h3>
                </div>
            </div>
            <ul class="group_list">
                @if(count($clubList)>0)
                    @foreach ( $clubList as $club) 
                        <li>
                            <div class="name">
                                <h5>{{ $club->name }}</h5>
                                <p>{{ $club->summary }}</p>
                                <div class="member">
                                    <svg class="w-4 h-4"><use xlink:href="/img/icon-defs.svg#member"></use></svg>
                                    회원수 : {{ number_format($club->member_count+1,0) }}
                                </div>
                            </div>
                            <div class="left_box">
                                <div class="img_box">
                                    <img src="{{ $club->imgUrl }}" alt="">
                                </div>
                                <button class="btn btn-gray thin w-full mt-4 btnClubRegister" data-cidx="{{ $club->idx }}">회원가입</button>
                            </div>
                            <div class="right_box">
                                <ul class="list">
                                    @foreach($club->article as $article)
                                        <li><a href="/community/club/article/{{ $article->idx }}">
                                            <b>{{ $article->title }}</b>
                                            <span>{{ Carbon\Carbon::parse($article->register_time)->format('Y.m.d') }}</span>
                                        </a></li>
                                    @endforeach 
                                </ul>
                                <a href="/community/club/detail/{{$club->idx}}" class="more_btn btn btn-line4">더보기</a>
                            </div>
                        </li>
                    @endforeach 
                @endif
            </ul>

        </div>
    </section>
</div>

<script>
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
</script>

@endsection