@extends('layouts.app_m')
@php
    $only_quick = '';
    $header_depth = 'mypage';
    $top_title = '1:1문의';
    $header_banner = '';
@endphp
@section('content')
@include('layouts.header_m')
<div id="content" class="bg-stone-100">
    <div class="inner">

        @if($count < 1)
            <!-- 문의내용 없을 때 -->
            <div class="h-[calc(100dvh-538px)] flex items-center justify-center">
                <div class="flex flex-col items-center gap-3">
                    <div class="flex items-center p-3 bg-stone-200 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-help text-white"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>
                    </div>
                    <p class="text-center">등록하신 1:1문의가 없습니다.</p>
                </div>
            </div>
        @else
            <div class="py-4">
                <ul class="flex flex-col gap-3">
                    @foreach($list as $row)
                        <a href="/help/inquiry/detail/{{ $row->idx }}">
                            <li class="p-4 bg-white rounded-sm shadow-sm">
                                <div class="flex items-center justify-between">
                                    @if ($row->state === 0)
                                        <span class="p-1 bg-stone-100 text-stone-500 rounded-sm text-xs">답변대기</span>
                                    @else
                                        <span class="p-1 bg-primaryop text-primary rounded-sm text-xs">답변완료</span>
                                    @endif
                                    <span class="text-xs text-stone-500">{{ date('Y.m.d', strtotime($row->register_time)) }}</span>
                                </div>
                                <hr class="border-t mt-2">
                                <div class="mt-2">
                                    <div class="flex items-center gap-2">
                                        <p class="font-medium w-[100px] shrink-0">[{{ $row->category->name }}]</p>
                                        <p class="truncate">{{ $row->title }}</p>
                                    </div>
                                </div>
                            </li>
                        </a>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="py-4">
            <a href="/help/inquiry/form" class="flex items-center justify-center mt-2 bg-primary h-[42px] text-white w-full rounded-sm">문의하기</a>
        </div>
    </div>
</div>
@endsection
