@extends('layouts.app_m')

@section('content')
@include('layouts.header_m')

<div id="content">
    <section class="message_con01">
        <div class="chatting_box">
            <div class="top_info">
                <div class="top_search">
                    <a href="javascript:;" class="prev_btn">
                        <svg><use xlink:href="./img/icon-defs.svg#left_arrow"></use></svg>
                    </a>
                    <div class="input_form">
                        <svg><use xlink:href="./img/icon-defs.svg#Search"></use></svg>
                        <input type="text" placeholder="대화 내용을 검색해주세요.">
                    </div>
                </div>
                <div class="title">
                    <a href="./message_list.php">
                        <svg><use xlink:href="./img/icon-defs.svg#left_arrow"></use></svg>
                    </a>
                    <h5>갑부가구산업</h5>
                    <span>알림 꺼짐</span>
                    <button class="company_info_btn"><img src="./img/icon/filter_arrow.svg" alt=""></button>
                </div>
                <div class="right_link">
                    <button class="right_search_btn"><svg><use xlink:href="./img/icon-defs.svg#Search_black"></use></svg></button>
                    <div class="more_btn">
                        <button><svg><use xlink:href="./img/icon-defs.svg#more_dot"></use></svg></button>
                        <div style="z-index:99">
                            <a href="javascript:;" onclick="modalOpen('#alarm_on_modal')">알림켜기</a>
                            <a href="javascript:;" onclick="modalOpen('#declaration_modal')">신고하기</a>
                        </div>
                    </div>
                </div>
                <div class="company_info">
                    <div class="add">경기 포천시 가산면 정금로 476번길 134-34 갑부가구산업</div>
                    <p>010-0000-0000</p>
                    <a href="./company_detail.php">업체 자세히 보기 <img src="./img/icon/filter_arrow.svg" alt=""></a>
                </div>
            </div>
            <div class="chatting_list">
                <div class="flex justify-center mt-2">
                    <button class="border rounded-full bg-white px-2 h-[32px] flex items-center gap-1">
                        더보기
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-up"><path d="m18 15-6-6-6 6"/></svg>
                    </button>
                </div>
                <div class="date"><span>2023년 11월 15일 수요일</span></div>
                <div class="chatting right">
                    <div class="chat_box">상품 문의드립니다.</div>
                    <div class="timestamp">18:38</div>
                </div>
                <div class="chatting left">
                    <div class="chat_box">안녕하세요</div>
                    <div class="timestamp">18:38</div>
                </div>
                <!-- 상품 견적문의 시 -->
                <div class="chatting left">
                    <div class="chat_box">
                        <a href="javascript:;">
                            <p class="font-bold">상품 문의드립니다.</p>
                            <div class="flex gap-3 items-center mt-2">
                                <img src="https://allfurn-prod-s3-bucket.s3.ap-northeast-2.amazonaws.com/product/9b300aa0f630288b205aa22c79f4b93af6c3a481c0fe6453a80bcd4779961110.jpg" alt="" class="border rounded-md object-cover w-[48px] h-[48px] shrink-0">
                                <!-- 이미지 없을 때 -->
                                <!-- <div class="rounded-md w-[48px] h-[48px] bg-stone-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image-off text-stone-400"><line x1="2" x2="22" y1="2" y2="22"/><path d="M10.41 10.41a2 2 0 1 1-2.83-2.83"/><line x1="13.5" x2="6" y1="13.5" y2="21"/><line x1="18" x2="21" y1="12" y2="15"/><path d="M3.59 3.59A1.99 1.99 0 0 0 3 5v14a2 2 0 0 0 2 2h14c.55 0 1.052-.22 1.41-.59"/><path d="M21 15V5a2 2 0 0 0-2-2H9"/></svg>
                                </div> -->
                                <div class="font-medium min-w-[100px]">
                                    <p class="truncate">이태리매트리스_엔트리플러스 (SS)</p>
                                    <span class="text-sm text-stone-400">수량마다 상이</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="timestamp">18:38</div>
                </div>
                <!-- 이미지만 업로드 -->
                <div class="chatting left">
                    <img src="https://allfurn-prod-s3-bucket.s3.ap-northeast-2.amazonaws.com/product/9b300aa0f630288b205aa22c79f4b93af6c3a481c0fe6453a80bcd4779961110.jpg" alt="" class="border rounded-md object-cover w-[250px]">
                    <div class="timestamp">18:38</div>
                </div>
                <!-- pdf 파일 -->
                <div class="chatting left">
                    <div class="chat_box">       
                        <div class="flex gap-3 items-center">
                            <div class="rounded-md w-[48px] h-[48px] bg-stone-100 flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text text-stone-400"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                            </div>
                            <div class="font-medium min-w-[100px]">
                                <span class="text-sm text-stone-400">PDF</span>
                                <p class="truncate">이태리매트리스_엔트리플러스 (SS).pdf</p>
                            </div>
                        </div>        
                    </div>
                    <div class="timestamp">18:38</div>
                </div>
                <!-- zip 파일 -->
                <div class="chatting left">
                    <div class="chat_box">       
                        <div class="flex gap-3 items-center">
                            <div class="rounded-md w-[48px] h-[48px] bg-stone-100 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-folder-archive text-stone-400"><circle cx="15" cy="19" r="2"/><path d="M20.9 19.8A2 2 0 0 0 22 18V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2h5.1"/><path d="M15 11v-1"/><path d="M15 17v-2"/></svg>
                            </div>
                            <div class="font-medium min-w-[100px]">
                                <span class="text-sm text-stone-400">ZIP</span>
                                <p class="truncate">이태리매트리스_엔트리플러스 (SS).zip</p>
                            </div>
                        </div>        
                    </div>
                    <div class="timestamp">18:38</div>
                </div>
                <div class="chatting right">
                    <div class="chat_box">               
                        <div class="font-medium min-w-[100px]">
                            <p class="truncate">주문번호 : 63F8792E0BC0D176</p>
                            <div class="mt-2">
                                <p class="text-sm font-basic">거래가 확정되었습니다.</p>
                                <p class="text-sm font-basic">상품이 준비중이니 기다려주세요!</p>
                            </div>
                            <a href="./my_ws_sales_status_detail.php" class="block w-full mt-2 py-3 border rounded-md text-primary text-center hover:bg-stone-50">주문 현황 보러가기</a>
                        </div>
                    </div>
                    <div class="timestamp">18:38</div>
                </div>
            </div>
            <div class="message_form">
                <div class="file_box shrink-0">
                    <input type="file" id="img_file">
                    <label for="img_file">
                        <img class="mx-auto" src="./img/member/img_icon.svg" alt="">
                    </label>
                </div>
                <input type="text" class="input-form" placeholder="메시지를 입력해주세요.">
                <button class="btn btn-primary shrink-0">전송</button>
            </div>
        </div>
    </section>

</div>

@endsection

@include('m.message.modal')
