@extends('layouts.app_m')

@php
    $only_quick = '';
    $header_depth = 'mypage';
    $top_title = '견적서 관리';
    $header_banner = '';
@endphp

@section('content')
    @include('layouts.header_m')

    <div id="content">
        <div class="flex">
            <a href="/mypage/estimate" class="flex items-center justify-center py-3 text-sm text-primary font-bold grow border-b-2 border-primary text-center">견적서 관리</a>
            <a href="/mypage/responseEstimateMulti" class="flex items-center justify-center py-3 text-stone-400 text-sm font-bold grow border-b border-stone-200 text-center">견적서 보내기</a>
        </div>           
        <div class="inner mb-10">
            <a href="/mypage/responseEstimate" class="flex items-center gpa-3 mt-8">
                <p class="font-bold">요청받은 견적서 현황</p>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
            </a>
            <div class="st_box w-full grid grid-cols-2 gap-2.5 px-5 mt-3 py-2 !h-auto">
                <a href="/mypage/responseEstimate?status=N" class="flex gap-5 justify-center items-center flex-1">
                    <p class="text-sm">요청받은 견적</p>
                    <p class="text-sm main_color font-bold">{{ $info[0] -> count_res_n }}</p>
                </a>
                <a href="/mypage/responseEstimate?status=R" class="flex gap-5 justify-center items-center flex-1">
                    <p class="text-sm">보낸 견적</p>
                    <p class="text-sm font-bold">{{ $info[0] -> count_res_r }}</p>
                </a>
                <a href="/mypage/responseEstimate?status=O" class="flex gap-5 justify-center items-center flex-1">
                    <p class="text-sm">주문서 수</p>
                    <p class="text-sm main_color font-bold">{{ $info[0] -> count_res_o }}</p>
                </a>
                <a href="/mypage/responseEstimate?status=F" class="flex gap-5 justify-center items-center flex-1">
                    <p class="text-sm">확인/완료</p>
                    <p class="text-sm font-bold">{{ $info[0] -> count_res_f }}</p>
                </a>
            </div>
            <a href="/mypage/requestEstimate" class="flex items-center gpa-3 mt-10">
                <p class="font-bold">요청한 견적서 현황</p>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
            </a>
            <div class="st_box w-full grid grid-cols-2 gap-2.5 px-5 mt-3 py-2 !h-auto">
                <a href="/mypage/requestEstimate?status=N" class="flex gap-5 justify-center items-center flex-1">
                    <p class="text-sm">요청한 견적</p>
                    <p class="text-sm font-bold">{{ $info[0] -> count_req_n }}</p>
                </a>
                <a href="/mypage/requestEstimate?status=R" class="flex gap-5 justify-center items-center flex-1">
                    <p class="text-sm">받은 견적</p>
                    <p class="text-sm font-bold main_color">{{ $info[0] -> count_req_r }}</p>
                </a>
                <a href="/mypage/requestEstimate?status=O" class="flex gap-5 justify-center items-center flex-1">
                    <p class="text-sm">주문서 수</p>
                    <p class="text-sm main_color font-bold">{{ $info[0] -> count_req_o }}</p>
                </a>
                <a href="/mypage/requestEstimate?status=F" class="flex gap-5 justify-center items-center flex-1">
                    <p class="text-sm">확인/완료</p>
                    <p class="text-sm font-bold">{{ $info[0] -> count_req_f }}</p>
                </a>
            </div>
        </div>
    </div>
@endsection