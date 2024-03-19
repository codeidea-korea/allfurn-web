@extends('layouts.app')

@section('content')
@include('layouts.header')

<div id="content">
    <!-- 하단 -->
    <div class="flex inner gap-10 mb-[100px] mt-[44px]">
        <!-- 왼쪽 메뉴 -->
        @include("alarm.sidebar")

        <!-- 오른쪽 컨텐츠 -->
        <div class="w-full">
            <!-- 리스트 기본 10개 출력 -->
            <div class="border-t border-b divide-y divide-gray-200 mt-[47px] flex flex-col">
                @if ($count < 1)
                    <div class="flex items-center justify-center h-[300px]">
                        <div class="flex flex-col items-center justify-center gap-1 text-stone-500">
                            <img class="w-8" src="/img/member/info_icon.svg" alt="">
                            <p>도착한 알림이 없습니다</p>
                        </div>
                    </div>
                @else
                    @foreach($list as $row)
                        <a href="{{ $row->type != 'order' && $row->type != 'active' ? $row->web_url : '#' }}" class="py-5 px-8 hover:bg-rose-50" disabled>
                            <p>{{ $row->title }}</p>
                            <p class="mt-2">{!! $row->content !!}</p>
                            <p class="text-stone-400 mt-1 text-sm">{{ $row->send_date }}</p>
                        </a>
                        @if ($row->log_image)
                            {{-- 이미지 있는지 확인하기 => 있으면 css 요청해야함 --}}
                        @endif
                    @endforeach
                    <div class="pagenation flex items-center justify-center py-12">
                        @if($pagination['prev'] > 0)
                            <a href="javascriot:;" onclick="moveToList({{$pagination['prev']}})">
                                <
                            </a>
                        @endif
                        @foreach ($pagination['pages'] as $paginate)
                            @if ($paginate == $offset)
                                <a href="javascript:;" class="active" onclick="moveToList({{$paginate}})">{{$paginate}}</a>
                            @else
                            <a href="javascript:;" class="" onclick="moveToList({{$paginate}})">{{$paginate}}</a>
                            @endif

                        @endforeach
                        @if($pagination['next'] > 0)
                            <a href="javascriot:;" onclick="moveToList({{$pagination['next']}})">
                                >
                            </a>
                        @endif
                    </div>
                @endif
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