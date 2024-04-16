@extends('layouts.app')

@section('content')
@include('layouts.header')

<div id="content">
    @include('community.community-tab')
    @include('community.community-banner')
    
    <section class="sub_section">
        <div class="inner">
            <div class="main_tit mb-8 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>가구인들의 모임</h3>
                </div>
            </div>

            <ul class="group_list">
                @if(count($clubList)>0)
                    @foreach ( $clubList as $club) 
                        <li>
                            <div class="left_box">
                                <div class="img_box">
                                    <img src="{{ $club->imgUrl }}" alt="">
                                </div>
                                <button class="btn btn-gray thin w-full mt-4">회원가입</button>
                            </div>
                            <div class="right_box">
                                <div class="name">
                                    <h5>{{ $club->name }}</h5>
                                    <p>{{ $club->summary }}</p>
                                    <div class="member">
                                        <svg class="w-4 h-4"><use xlink:href="/img/icon-defs.svg#member"></use></svg>
                                        회원수 : {{ $club->member_count }}
                                    </div>
                                </div>
                                <ul class="list">
                                    <li><a href="javascript:;">
                                        <b>9월 25일 서원힐스 정모</b>
                                        <span>2023.09.06</span>
                                    </a></li>
                                    <li><a href="javascript:;">
                                        <b>9월 25일 서원힐스 정모</b>
                                        <span>2023.09.06</span>
                                    </a></li>
                                    <li><a href="javascript:;">
                                        <b>9월 25일 서원힐스 정모</b>
                                        <span>2023.09.06</span>
                                    </a></li>
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


</script>

@endsection