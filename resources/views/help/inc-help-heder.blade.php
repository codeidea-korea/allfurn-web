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
        <a href="/help/faq" class="py-4 {{ $pageType === 'faq' ? 'border-b-2 border-primary text-primary font-bold' : 'font-medium text-stone-400' }}">자주 묻는 질문</a>
        <a href="/help/notice" class="py-4 {{ $pageType === 'notice' ? 'border-b-2 border-primary text-primary font-bold' : 'font-medium text-stone-400' }}">공지사항</a>
    </div>
</div>