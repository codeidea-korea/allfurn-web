@extends('layouts.app_m')
@php
    $only_quick = '';
    $header_depth = 'mypage';
    $top_title = '고객센터';
    $header_banner = '';
@endphp
@section('content')
@include('layouts.header_m')

<div id="content" class="bg-stone-100">
    <div class="p-4 bg-white shadow-sm">
        <div class="flex flex-col justify-center items-center bg-stone-700 p-4 rounded-sm mt-3">
            <div>
                <div class="flex items-center text-white">
                    <span class="w-[80px]">전화번호</span>
                    <span>031-813-5588</span>
                </div>
                <div class="flex items-center text-white">
                    <span class="w-[80px]">운영시간</span>
                    <span>평일 09:00 - 18:00</span>
                </div>
            </div>
        </div>
        <div class="flex mt-4 gap-2">
            {{-- <button class="rounded-sm border h-[42px] text-center w-full" onclick="modalOpen('#writing_guide_modal')">올펀 이용 가이드</button> --}}
            <button class="rounded-sm border h-[42px] text-center w-full" onclick="location.href='/help/inquiry'">1:1문의</button>
        </div>
    </div>
    <div class="mt-4 bg-white">
        <div class="border-b">
            <div class="flex gap-5">
                <a href="/help/guide" class="font-medium py-3 text-stone-400 w-full text-center">이용 가이드</a>
                <a href="/help/notice" class="font-medium py-3 text-stone-400 w-full text-center">공지사항</a>
                <a href="/help/faq" class="border-b-2 border-primary py-3 text-primary font-bold w-full text-center">자주 묻는 질문</a>
            </div>
        </div>
        <div class="tab_faq flex overflow-x-scroll">
            <button class="h-[36px] {{ $category_idx ? '' : 'active' }} " onclick="location.href='/help/faq'">전체</button>
            @foreach ($categories as $category)
            <button class="h-[36px] {{ $category_idx == $category->idx ? 'active' : '' }} " onclick="location.href='/help/faq?category_idx={{ $category->idx }}'">{{ $category->name }}</button>
            @endforeach
        </div>

          <!-- 아코디언 리스트 최대 10개씩 출력 -->
        <div id="faq_sec01" class="faq_content">
            <div class="accordion divide-y divide-gray-200">
                @foreach ( $list as $row )
                    <div class="accordion-item">
                        <button class="accordion-header py-3 px-5 w-full text-left" type="button">
                            <div class="flex items-center gap-2">
                                <span>Q</span>
                                <span class="">{{ $row->title }}</span>
                            </div>
                        </button>
                        <div class="accordion-body hidden p-5 bg-stone-50">
                            <p class="text-sm text-primary">A</p>
                            <p class="">
                                {!! $row->content !!}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pagenation flex items-center justify-center py-6">
                @if($pagination['prev'] > 0)
                <a href="javascript:;" class="" onclick="moveToList({{$pagination['prev']}})">
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
                    <a href="javascript:;" class="" onclick="moveToList({{$pagination['next']}})">
                        >
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- 올펀 이용 가이드 모달 --}}
    @include('m.help.index-ext')
</div>

<script>
    $(".accordion-header").click(function() {
        // 클릭된 항목의 바디를 토글합니다.
        var $body = $(this).next(".accordion-body");
        $body.slideToggle(200);

        // 선택적: 클릭된 헤더와 같은 아코디언 그룹 내의 다른 모든 바디를 닫습니다.
        $(this).closest('.accordion').find(".accordion-body").not($body).slideUp(200);
    });


    $('.guide_list a').click(function() {
        // 클릭된 항목의 data-target 값 가져오기
        var targetId = $(this).data('target');

        // 모든 가이드 내용 숨기기
        $('.guide_con').hide();

        // 해당하는 ID를 가진 가이드 내용만 보여주기
        $('#' + targetId).show();
    });


    // faq 페이지 이동
    function moveToList(page) {
        let bodies = {offset:page};
        const urlSearch = new URLSearchParams(location.search);
        if (urlSearch.get('category_idx')) bodies.category_idx = urlSearch.get('category_idx');
        location.replace(location.pathname + "?" + new URLSearchParams(bodies));
    }
</script>
@endsection