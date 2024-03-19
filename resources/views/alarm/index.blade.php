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
                <a href="javascript:;" class="py-5 px-8 hover:bg-rose-50">
                    <p>제품을 확인해보세요!</p>
                    <p class="mt-2">CMDE0017/라이트그레이</p>
                    <p class="text-stone-400 mt-1 text-sm">어제</p>
                </a>
                <a href="javascript:;" class="py-5 px-8 hover:bg-rose-50">
                    <p>구매 확정 대기 안내</p>
                    <p class="mt-2">[이태리매트리스_엔트리22 (K)] 주문 건이 구매 확정 대기 상태로 변경되었습니다.</p>
                    <p class="text-stone-400 mt-1 text-sm">02월 22일</p>
                </a>
                <a href="javascript:;" class="py-5 px-8 hover:bg-rose-50">
                    <p>구매 확정 대기 안내</p>
                    <p class="mt-2">[이태리매트리스_엔트리22 (K)] 주문 건이 구매 확정 대기 상태로 변경되었습니다.</p>
                    <p class="text-stone-400 mt-1 text-sm">02월 22일</p>
                </a>
            </div>
            <div class="pagenation flex items-center justify-center py-12">
                <a href="javascript:;" class="active">1</a>
                <a href="javascriot:;">2</a>
                <a href="javascriot:;">3</a>
                <a href="javascriot:;">4</a>
                <a href="javascriot:;">5</a>
            </div>
        </div>
    </div>
</div>
@endsection