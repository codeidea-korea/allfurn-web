@extends('layouts.app')

@section('content')
@include('layouts.header')

<div id="content">
    <div class="inner">
        <div class="mt-10">
            <h2 class="text-2xl font-bold">고객센터</h2>
        </div>
        <div class="border rounded-md p-5 flex items-center justify-between mt-4">
            <div>
                <div class="text-stone-500">궁금한 내용이 있으신가요?</div>
                <div class="font-bold text-3xl mt-2">031-813-5588</div>
                <div class="mt-2"><span class="text-stone-500">운영시간</span> | 평일 09:00 - 18:00</div>
            </div>
            <div class="flex flex-col gap-2">
                <button class="h-[48px] w-[140px] border rounded-md" onclick="modalOpen('#writing_guide_modal')">올펀 이용 가이드</button>
                <a href="./inquiry.php" class="h-[48px] w-[140px] border rounded-md flex items-center justify-center">1:1 문의</a>
            </div>
        </div>
        <div class="border-b">
            <div class="flex gap-5">
                <a href="/help/faq" class="font-medium py-4 text-stone-400">자주 묻는 질문</a>
                <a href="" class="border-b-2 border-primary text-primary font-bold py-4">공지사항</a>
            </div>
        </div>
        <!-- 최대 10개 출력 -->
        <div class="accordion divide-y divide-gray-200">
            @foreach($list as $row)
                <div class="accordion-item">
                    <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                        <div class="flex flex-col gap-2">
                            <span class="text-lg">{{ $row->title }}</span>
                            <span class="text-sm text-stone-400">{{ date('Y.m.d', strtotime($row->register_time)) }}</span>
                        </div>
                    </button>
                    <div class="accordion-body hidden p-5 bg-stone-50">
                            {!! $row->content !!} 
                    </div>
                </div>
            @endforeach
        </div>
        <div class="pagenation flex items-center justify-center py-12">
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

<script>
    $(document).ready(function() {
 
        $(".accordion-header").click(function() {
            // 클릭된 항목의 바디를 토글합니다.
            var $body = $(this).next(".accordion-body");
            $body.slideToggle(200);

            // 선택적: 클릭된 헤더와 같은 아코디언 그룹 내의 다른 모든 바디를 닫습니다.
            $(this).closest('.accordion').find(".accordion-body").not($body).slideUp(200);
        });
    
        // 드롭다운 토글
        $(".filter_dropdown").click(function(event) {
            var $thisDropdown = $(this).next(".filter_dropdown_wrap");
            $(this).toggleClass('active');
            $thisDropdown.toggle();
            $(this).find("svg").toggleClass("active");
            event.stopPropagation(); // 이벤트 전파 방지
        });
 
        // 드롭다운 항목 선택 이벤트
        $(".filter_dropdown_wrap ul li a").click(function(event) {
            var selectedText = $(this).text();
            var $dropdown = $(this).closest('.filter_dropdown_wrap').prev(".filter_dropdown");
            $dropdown.find("p").text(selectedText);
            $(this).closest(".filter_dropdown_wrap").hide();
            $dropdown.removeClass('active');
            $dropdown.find("svg").removeClass("active");
            
            var targetClass = $(this).data('target');
            if (targetClass) {
                // 모든 targetClass 요소를 숨기고, 현재 targetClass만 표시
                $('[data-target]').each(function() {
                    var currentTarget = $(this).data('target');
                    if (currentTarget !== targetClass) {
                        $('.' + currentTarget).hide();
                    }
                });
                $('.' + targetClass).show(); // 현재 클릭한 targetClass 요소만 표시
            } else {
                // 현재 클릭이 data-target을 가지고 있지 않다면, 모든 targetClass 요소를 숨김
                $('[data-target]').each(function() {
                    var currentTarget = $(this).data('target');
                    $('.' + currentTarget).hide();
                });
            }

            event.stopPropagation(); // 이벤트 전파 방지
        });
 
        // 드롭다운 영역 밖 클릭 시 드롭다운 닫기
        $(document).click(function(event) {
            if (!$(event.target).closest('.filter_dropdown, .filter_dropdown_wrap').length) {
                $('.filter_dropdown_wrap').hide();
                $('.filter_dropdown').removeClass('active');
                $('.filter_dropdown svg').removeClass("active");
            }
        });

        $('.guide_list a').click(function() {
            // 클릭된 항목의 data-target 값 가져오기
            var targetId = $(this).data('target');

            // 모든 가이드 내용 숨기기
            $('.guide_con').hide();

            // 해당하는 ID를 가진 가이드 내용만 보여주기
            $('#' + targetId).show();
        });
    });

    // 공지사항 페이지 이동
    function moveToList(page) {
        let bodies = {offset:page};
        const urlSearch = new URLSearchParams(location.search);
        if (urlSearch.get('category_idx')) bodies.category_idx = urlSearch.get('category_idx');
        location.replace(location.pathname + "?" + new URLSearchParams(bodies));
    }
 
 </script>

@endsection