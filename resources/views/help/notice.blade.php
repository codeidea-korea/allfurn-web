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
                <a href="./customer_center.php" class="font-medium py-4 text-stone-400">자주 묻는 질문</a>
                <a href="./notice.php" class="border-b-2 border-primary text-primary font-bold py-4">공지사항</a>
            </div>
        </div>
        <!-- 최대 10개 출력 -->
        <div class="accordion divide-y divide-gray-200">
            <div class="accordion-item">
                <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                    <div class="flex flex-col gap-2">
                        <span class="text-lg">올펀에 대해 알아보고, 쉽게 사용하세요!</span>
                        <span class="text-sm text-stone-400">2023.12.04</span>
                    </div>
                </button>
                <div class="accordion-body hidden p-5 bg-stone-50">
                    <div class="flex items-center justify-center">
                        <img src="https://allfurn-prod-s3-bucket.s3.ap-northeast-2.amazonaws.com/user/e473924cb326b41a16e74093baaf08b1be72d9914182d9071f9a198ac7d9f1d6.jpg" alt="">
                    </div>                    
                </div>
            </div>
            <div class="accordion-item">
                <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                    <div class="flex flex-col gap-2">
                        <span class="text-lg">올펀 모바일 어플리케이션 오픈 공지</span>
                        <span class="text-sm text-stone-400">2023.01.31</span>
                    </div>
                </button>
                <div class="accordion-body hidden p-5 bg-stone-50">
                안녕하세요 !
                전 세계 가구 도소매 거래 온라인 B2B 플랫폼, 올펀입니다.
                드디어 저희 올펀에서 어플리케이션(안드로이드, iOS)을 출시했습니다.<br/><br/>
                
                □ 다운로드 방법<br/>
                -. 안드로이드 : 플레이 스토어에서 "올펀" 검색 후 설치<br/>
                -. iOS(아이폰) : 앱스토어에서 "올펀" 검색 후 설치<br/><br/>

                어플리케이션을 휴대폰에 다운로드 받아두시면 새로 등록되는 신상품과 일일/주간 가구뉴스<br/>
                그리고 주간건축/월간입주 정보까지 푸시 알림으로 빠르게 받아보실 수 있습니다.<br/>
                많은 이용 부탁드립니다. 감사합니다.               
                </div>
            </div>
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
 
 </script>

@endsection