<div class="top_info">
    <div class="top_search">
        <a href="javascript:;" class="prev_btn">
            <svg><use xlink:href="/img/icon-defs.svg#left_arrow"></use></svg>
        </a>
        <div class="input_form">
            <svg style="cursor: pointer;" onclick="searchKeywordInRoom()"><use xlink:href="/img/icon-defs.svg#Search"></use></svg>
            <input type="text" id="chatting_keyword_inroom" name="keyword" value="{{ request()->get('keyword') }}" onkeyup="searchKeywordInRoom()" placeholder="대화 내용을 검색해주세요.">
        </div>
        <div class="flex items-center gap-2 ml-3 talk_search_arrow">
            <button id="btnPrevSearchInroom" onclick="prevBoldSearchKeywordInRoom()"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-up"><path d="m18 15-6-6-6 6"/></svg></button>
            <button id="btnNextSearchInroom" onclick="nextBoldSearchKeywordInRoom()"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down"><path d="m6 9 6 6 6-6"/></svg></button>
        </div>
    </div>
    <div class="title">
        <div class="img_box">
            <img src="{{ $company->profile_image }}" alt="">
        </div>
        <h5>{{ $company->company_name }}</h5>
        @if($company->is_alarm === 'Y')
            <span class="notification_status_txt" data-company-idx="{{ $company->idx }}">알림 켜짐</span>
        @else
            <span class="notification_status_txt" data-company-idx="{{ $company->idx }}">알림 꺼짐</span>
        @endif
        <button class="company_info_btn"><img src="/img/icon/filter_arrow.svg" alt=""></button>
    </div>
    <div class="right_link">
        <button class="right_search_btn"><svg><use xlink:href="/img/icon-defs.svg#Search_dark"></use></svg></button>
        <div class="more_btn">
            <button><svg><use xlink:href="/img/icon-defs.svg#more_dot"></use></svg></button>
            <div style="z-index:99">
                @if($company->is_alarm === 'Y')
                    <a class="notification_status_btn" data-company-idx="{{ $company->idx }}" href="javascript:toggleAlarmModal('{{ $company->company_type }}', {{ $company->idx }});">알림끄기</a>
                @else
                    <a class="notification_status_btn" data-company-idx="{{ $company->idx }}" href="javascript:toggleAlarmModal('{{ $company->company_type }}', {{ $company->idx }});">알림켜기</a>
                @endif
                <a href="javascript:reportModal({{ $company->idx }}, '{{ $company->company_type }}');">신고하기</a>
            </div>
        </div>
    </div>
    <div class="company_info">
        @if($company->company_type === 'W' || $company->company_type === 'R')
        <div class="add">{{ $company->business_address }} {{ $company->business_address_detail }}</div>
        <p>{{ $company->phone_number }}</p>
        <a href="/wholesaler/detail/{{ $company->idx }}">업체 자세히 보기 <img src="/img/icon/filter_arrow.svg" alt=""></a>
        @else
        <div class="add">경기도 고양시 일산동구 산두로213번길 18 (정발산동)</div>
        <p>031-813-5588</p>
        @endif
    </div>
</div>
<div class="chatting_list" style="overflow-y: scroll;">
    @if($chattingCount > 30)
    <div class="flex justify-center mt-2" id="btnGetChatMore" data-key="{{ $room_idx }}">
        <button class="border rounded-full bg-white px-2 h-[32px] flex items-center gap-1" onclick="getChatting({{ $room_idx }})">
            더보기
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-up"><path d="m18 15-6-6-6 6"/></svg>
        </button>
    </div>
    @endif
    {!! $chattingHtml !!}
</div>
<div class="message_form">
    <div class="file_box">
        <input type="file" id="img_file" onchange="submitImgMessage()">
        <label for="img_file">
            <img class="mx-auto" src="/img/member/img_icon.svg" alt="">
        </label>
    </div>
    <input type="text" class="input-form" id="chat_message" placeholder="메시지를 입력해주세요." onkeyup="keyupMessage()">
    <button class="btn btn-primary" id="submitBtn" data-room-idx="{{ $room_idx }}" onClick="clickMessage()">전송</button>
</div>
