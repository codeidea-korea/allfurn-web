@extends('layouts.app')

@section('content')
@include('layouts.header')

<div id="content">
    <div class="inner">
        <div class="pt-10 pb-6 flex items-center gap-1 text-stone-400">
            <p>고객센터</p>
            <p>></p>
            <p>1:1문의</p>
        </div>
        <div class="flex itesm-center justify-between">
            <h2 class="text-2xl font-bold">1:1 문의</h2>
            <a href="./inquiry_detail.php" class="h-[48px] w-[140px] border rounded-md flex items-center justify-center">1:1 문의</a>
        </div>
        <hr class="mt-5">
        <!-- 최대 10개 출력 -->
        <div class="accordion divide-y divide-gray-200">
            <div class="accordion-item">
                <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-stone-400 w-16 shrink-0">회원정보</span>
                        <span class="text-lg">정회원 승격 요청 진행하는 법 알려주세요</span>
                        <span class="text-primary bg-primaryop py-1 px-2 text-xs ml-auto">답변완료</span>
                    </div>
                </button>
                <div class="accordion-body hidden p-5 bg-stone-50">
                    <p class="w-1/2">
                        정회원 승격 요청하는 방법이 있다고 하는데<br/>
                        어디서 하는지 모르겠어요 알려주세요
                    </p>
                    <div class="bg-stone-200 p-5 mt-5 rounded-md">
                        <p class="text-sm text-stone-400">2023.12.04</p>
                        <div class="mt-2">
                            안녕하세요 고객님<br/>
                            정회원 승격 요청은 마이페이지 > 계정관리 > 정회원 승격 요청 버튼 클릭으로<br/>
                            진행 가능합니다.
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-stone-400 w-16 shrink-0">기타</span>
                        <span class="text-lg">전화번호 변경됐어요</span>
                        <span class="text-stone-400 bg-stone-100 py-1 px-2 text-xs ml-auto">답변대기</span>
                    </div>
                </button>
                <div class="accordion-body hidden p-5 bg-stone-50">
                    <p class="w-1/2">
                        정회원 승격 요청하는 방법이 있다고 하는데<br/>
                        어디서 하는지 모르겠어요 알려주세요
                    </p>
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
        <!-- 1:1 문의 없을 떼 -->
        <div class="flex items-center justify-center h-[300px]">
            <div class="flex flex-col items-center justify-center gap-1 text-stone-500">
                <img class="w-8" src="./img/member/info_icon.svg" alt="">
                <p>등록하신 1:1 문의가 없습니다.</p>
            </div>
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
    });
 </script>

@endsection