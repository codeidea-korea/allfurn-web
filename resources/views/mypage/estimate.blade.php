<div class="w-full">
    <div class="flex">
        <a href="/mypage/estimate" class="text-xl text-primary font-bold grow border-b-2 border-primary pb-5 text-center">견적서 관리</a>
        <a href="/mypage/responseEstimateMulti" class="text-stone-400 text-xl font-bold grow text-center">견적서 보내기</a>
    </div>           
    <hr>
    <a href="/mypage/responseEstimate" class="flex items-center gpa-3 mt-8">
        <p class="font-bold">요청받은 견적서 현황</p>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
    </a>
    <div class="st_box w-full flex items-center gap-2.5 px-5 mt-3">
        <a href="/mypage/responseEstimate?status=N" class="flex gap-5 justify-center items-center flex-1">
            <p class="text-sm">요청받은 견적</p>
            <p class="text-sm main_color font-bold">{{ $info[0] -> count_res_n }}</p>
        </a>
        <p class="line h-full"></p>
        <a href="/mypage/responseEstimate?status=R" class="flex gap-5 justify-center items-center flex-1">
            <p class="text-sm">보낸 견적</p>
            <p class="text-sm font-bold">{{ $info[0] -> count_res_r }}</p>
        </a>
        <p class="line h-full"></p>
        <a href="/mypage/responseEstimate?status=O" class="flex gap-5 justify-center items-center flex-1">
            <p class="text-sm">주문서 수</p>
            <p class="text-sm main_color font-bold">{{ $info[0] -> count_res_o }}</p>
        </a>
        <p class="line h-full"></p>
        <a href="/mypage/responseEstimate?status=F" class="flex gap-5 justify-center items-center flex-1">
            <p class="text-sm">확인/완료</p>
            <p class="text-sm font-bold">{{ $info[0] -> count_res_f }}</p>
        </a>
    </div>
    <a href="/mypage/requestEstimate" class="flex items-center gpa-3 mt-10">
        <p class="font-bold">요청한 견적서 현황</p>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
    </a>
    <div class="st_box w-full flex items-center gap-2.5 px-5 mt-3">
        <a href="/mypage/requestEstimate?status=N" class="flex gap-5 justify-center items-center flex-1">
            <p class="text-sm">요청한 견적</p>
            <p class="text-sm font-bold">{{ $info[0] -> count_req_n }}</p>
        </a>
        <p class="line h-full"></p>
        <a href="/mypage/requestEstimate?status=R" class="flex gap-5 justify-center items-center flex-1">
            <p class="text-sm">받은 견적</p>
            <p class="text-sm font-bold main_color">{{ $info[0] -> count_req_r }}</p>
        </a>
        <p class="line h-full"></p>
        <a href="/mypage/requestEstimate?status=O" class="flex gap-5 justify-center items-center flex-1">
            <p class="text-sm">주문서 수</p>
            <p class="text-sm main_color font-bold">{{ $info[0] -> count_req_o }}</p>
        </a>
        <p class="line h-full"></p>
        <a href="/mypage/requestEstimate?status=F" class="flex gap-5 justify-center items-center flex-1">
            <p class="text-sm">확인/완료</p>
            <p class="text-sm font-bold">{{ $info[0] -> count_req_f }}</p>
        </a>
    </div>
</div>





<script src="/js/jquery-1.12.4.js?{{ date('Ymdhis') }}"></script>
<script type="text/javascript"></script>