@extends('layouts.app_m')
@php
    $only_quick = '';
    $header_depth = 'mypage';
    $top_title = '알림센터';
    $header_banner = '';
@endphp
@section('content')
@include('layouts.header_m')

<div id="content">
    <div class="sticky top-0 z-10">
        <div class="flex items-center bg-white justify-center items-center border-b">
        <a href="/alarm" class="my_tab w-full text-center py-2.5 {{ !$type ? 'active' : '' }}">전체</a>
            <a href="/alarm/order" class="my_tab w-full text-center py-2.5 {{ $type === 'order' ? 'active' : '' }}">주문</a>
            <a href="/alarm/active" class="my_tab w-full text-center py-2.5 {{ $type === 'active' ? 'active' : '' }}">활동</a>
            <a href="/alarm/news" class="my_tab  w-full text-center py-2.5 {{ $type === 'news' ? 'active' : '' }}">소식</a>
        </div>
    </div>

    @if ($count < 1)
        <div class="flex items-center justify-center bg-stone-50" style="height: calc(100vh - 490px);">
            <p class="text-stone-400">도착한 알림이 없습니다.</p>
        </div>
    @else
        <div class="bg-stone-100">
            <div class="">
                <ul class="flex flex-col">
                    @foreach($list as $row)
                        <li class="bg-white shadow-sm">
                            <a href="{{ $row->type != 'order' && $row->type != 'active' ? $row->web_url : '#' }}">
                                <div class="px-4 py-2 rounded-t-sm border-b">
                                    <div class="flex items-center">
                                        <span class="bg-primaryop p-1 text-xs text-primary rounded-sm font-medium">
                                            @if($row->type === 'order')
                                                주문
                                            @elseif($row->type === 'active')
                                                활동
                                            @elseif(in_array($row->type, ['event','normal','notice','ad']))
                                                소식
                                            @endif
                                        </span>
                                        <span class="ml-auto text-stone-400">{{ $row->send_date }}</span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <p class="font-bold text-base">{{ $row->title }}</p>
                                    <p class="mt-1">{!! $row->content !!}</p>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="pagenation flex items-center justify-center py-6">
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
<script>
    const moveToList = page => {
        location.replace(location.pathname + "?" + new URLSearchParams({offset:page}));
    }
</script> 
@endsection