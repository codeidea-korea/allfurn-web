@extends('layouts.app_m')

@php

$header_depth = 'talk';
$only_quick = 'yes';
$top_title = '';
$header_banner = '';

@endphp

@section('content')
@include('layouts.header_m')

<div id="content">
    <section class="message_con01">
        <div class="chatting_box">
            <div class="top_info">
                <div class="top_search">
                    <a href="javascript:;" class="prev_btn">
                        <svg><use xlink:href="/img/icon-defs.svg#left_arrow"></use></svg>
                    </a>
                    <div class="input_form">
                        <svg onclick="searchKeywordInRoom()"><use xlink:href="/img/icon-defs.svg#Search"></use></svg>
                        <input type="text" placeholder="대화 내용을 검색해주세요." id="chatting_keyword_inroom" name="keyword" value="{{ request()->get('keyword') }}" onkeyup="searchKeywordInRoom()">
                    </div>
                    <div class="flex items-center gap-2 ml-3 talk_search_arrow">
                        <button id="btnPrevSearchInroom" onclick="prevBoldSearchKeywordInRoom()"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-up"><path d="m18 15-6-6-6 6"/></svg></button>
                        <button id="btnNextSearchInroom" onclick="nextBoldSearchKeywordInRoom()"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down"><path d="m6 9 6 6 6-6"/></svg></button>
                    </div>
                </div>
                <div class="title">
                    <a href="/message">
                        <svg><use xlink:href="/img/icon-defs.svg#left_arrow"></use></svg>
                    </a>
                    <h5>{{ $company->company_name }}</h5>
                    @if($company->is_alarm === 'Y')
                        <span class="notification_status_txt" data-company-idx="{{ $company->idx }}">알림 켜짐</span>
                    @else
                        <span class="notification_status_txt" data-company-idx="{{ $company->idx }}">알림 꺼짐</span>
                    @endif
                    <button class="company_info_btn"><img src="/img/icon/filter_arrow.svg" alt=""></button>
                </div>
                <div class="right_link">
                    <button class="right_search_btn"><svg><use xlink:href="/img/icon-defs.svg#Search_black"></use></svg></button>
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
                    @endif
                    @if($company->company_type === 'W')
                    <p>{{ $company->phone_number }}</p>
                    <a href="/wholesaler/detail/{{ $company->idx }}">업체 자세히 보기 <img src="/img/icon/filter_arrow.svg" alt=""></a>
                    @elseif($company->idx == 1)
                    <div class="add">경기도 고양시 일산동구 산두로213번길 18 (정발산동)</div>
                    <p>031-813-5588</p>
                    @else

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
                <div class="file_box shrink-0">
                    <input type="file" id="img_file" onchange="submitImgMessage()">
                    <label for="img_file">
                        <img class="mx-auto" src="/img/member/img_icon.svg" alt="">
                    </label>
                </div>
                <input type="text" class="input-form" id="chat_message" placeholder="메시지를 입력해주세요." onkeyup="keyupMessage()">
                <button type="button" class="btn btn-primary shrink-0" id="submitBtn" data-room-idx="{{ $room_idx }}" onClick="clickMessage()">전송</button>
            </div>
        </div>
    </section>

</div>

    <!-- pusher -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
    Pusher.logToConsole = true;
    var opened_room_idx = {{ $room_idx }};

    const pusher = new Pusher('51b26f4641d16394d3fd', {
        cluster: 'ap3'
    });
    var cchannel = pusher.subscribe('user-cmd-{{ $user_idx }}');
    cchannel.bind('user-cmd-event-{{ $user_idx }}', function(messages) {
        console.log(JSON.stringify(messages));
        if(messages.message == 'read') {
            // 읽음 처리
            $('.chatting_list > .chatting.right > ._alert').remove();
        }
    });
    var channel = pusher.subscribe('chat-{{ $room_idx }}');
    channel.bind('chat-event-{{ $room_idx }}', function(messages) {
        console.log(JSON.stringify(messages));

        var tm = $($('.chatting_list > .date')[$('.chatting_list > .date').length - 1]).find('span').text();
        const lastCommunicatedDate = tm.substring(0, tm.indexOf('요일') - 2);

        if($('.chatting_list > .date > span').filter(tm => tm.innerText == messages.date+' '+messages.dateOfWeek+'요일').length > 0) {
            const dateTag = '<div class="date"><span>'+messages.date+' '+messages.dateOfWeek+'요일</span></div>';
            $('.chatting_list').html($('.chatting_list').html() + dateTag);
        }
        //$('.chatting_list').html($('.chatting_list').html() + messages.contentHtml);

        //$('.chatting_list').scrollTop($('.chatting_list')[0].scrollHeight);
        //$('._room{{ $room_idx }}LastMent').text(messages.title);

        if('{{$chatting_keyword}}' != '' && '{{$chatting_keyword}}' != 'undefined') {
            $('#chatting_keyword_inroom').val('{{$chatting_keyword}}');
            boldSearchKeywordInRoom();
        }
         if(messages.companyIdx != {{ $companyIdx }}) {
            messages.contentHtml = messages.contentHtml.replace('chatting right', 'chatting left');
            $('.chatting_list > .chatting.right > ._alert').remove();

            // 내가 보낸 것이 아닌데 보고 있는 경우 읽음 처리를 한다.
            fetch('/message/read?room_idx=' + messages.roomIdx, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            }).then(response => {
                return response.json();
            }).then(json => {
                if (json.result === 'success') {
                    $('.chatting_list > .chatting.left > ._alert').remove();
                }
            });
         }
         $('.chatting_list').html($('.chatting_list').html() + messages.contentHtml);

        $('.chatting_list').scrollTop($('.chatting_list')[0].scrollHeight);
        $('._room{{ $room_idx }}LastMent').text(messages.title);
            //
        $('.chatting_list').scrollTop($('.chatting_list')[0].scrollHeight)
    });
//    setTimeout(() => {
//        document.querySelector('.chatting_list').focus();
//        $('.chatting_list').scrollTop($('.chatting_list')[0].scrollHeight);
//    }, 100);
    setInterval(() => {
     fetch('/message/read?room_idx={{$room_idx}}', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            }).then(response => {
                return response.json();
            }).then(json => {
                if (json.result === 'success') {
                    $('.chatting_list > .chatting.left > ._alert').remove();
                }
            });
    }, 800);
        $('.chatting_list').scrollTop($('.chatting_list')[0].scrollHeight)
    </script>

    <script>

        {{-- 대화방 내용 가져오기 --}}
        const visibleRoom = (idx) => {

            let params = {room_idx: idx}

            pageNo = 1;

            fetch('/message/room?' + new URLSearchParams(params)).then(response => {

                if (response.ok) {
                    return response.text();
                }

                throw new Error('Sever Error');

            }).then(html => {
                if (document.querySelector('.new[data-room-idx="'+idx+'"]')) {
                    document.querySelector('.new[data-room-idx="'+idx+'"]').remove();
                }
                document.querySelector('.message__section').innerHTML = html;
                loadEvent(idx);

                const roomIdx = idx;

            }).catch(error => {
            })
        }
        var pageNo = 1;
        const getChatting = (idx) => {

            let params = {room_idx: idx, pageNo: pageNo}

            pageNo = pageNo + 1;

            fetch('/message/chatting?' + new URLSearchParams(params)).then(response => {

                if (response.ok) {
                    return response.json();
                }

                throw new Error('Sever Error');

            }).then(data => {
                if (document.querySelector('.new[data-room-idx="'+idx+'"]')) {
                    document.querySelector('.new[data-room-idx="'+idx+'"]').remove();
                }
                const $btntag = $('#btnGetChatMore')[0].outerHTML;
                $('#btnGetChatMore').remove();
                document.querySelector('.chatting_list').innerHTML = $btntag + data.data.chattingHtml + document.querySelector('.chatting_list').innerHTML;
                if(data.data.chattingCount > (pageNo-1)*30) {
                    $('#btnGetChatMore').show();
                } else {
                    $('#btnGetChatMore').hide();
                }
                loadEvent(idx);
                boldSearchKeywordInRoom();
                document.querySelector('.chat-box:last-child').focus();

            }).catch(error => {
            })
        }
        const loadEvent = () => {

            // 우측 검색아이콘 클릭시
            $('.chatting_box .right_search_btn').off().on('click',function(){
                $('.chatting_box .top_search').addClass('active')
            });
            $('.chatting_box .top_search .prev_btn').off().on('click',function(){
                $('.chatting_box .top_search').removeClass('active')
            });

            // 업체 주소
            $('.company_info_btn').off().on('click',function(){
                $(this).toggleClass('active')
                $('.chatting_box .top_info .company_info').toggleClass('active');
            });
        };
        loadEvent();

        {{-- 알림 켜기/끄기 모달 띄우기 --}}
        const toggleAlarmModal = (company_type, company_idx) => {
            document.getElementById('confirmTogglePushBtn').dataset.companyType = company_type;
            document.getElementById('confirmTogglePushBtn').dataset.companyIdx = company_idx;
            if (document.querySelector('.notification_status_txt').innerText == '알림 켜짐') {
                document.getElementById('push-text').innerText = '해제 하시겠습니까';
            } else {
                document.getElementById('push-text').innerText = '받으시겠습니까';
            }
            modalOpen('#alarm_on_modal');
        }

        {{-- 알림 켜기/끄기 처리 --}}
        const toggleAlarmPush = () => {
            const company_type = document.getElementById('confirmTogglePushBtn').dataset.companyType;
            const company_idx = document.getElementById('confirmTogglePushBtn').dataset.companyIdx;
            fetch('/message/company/push', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: JSON.stringify({company_idx, company_type})
            }).then(response => {
                return response.json();
            }).then(json => {
                if (json.result === 'success') {
                    if (json.code === 'INSERT_SUCCESS') {
                        document.querySelector('.notification_status_txt').innerText = '알림 켜짐';
                        document.querySelector('.notification_status_btn').innerText = '알림끄기';
                    } else {
                        document.querySelector('.notification_status_txt').innerText = '알림 꺼짐';
                        document.querySelector('.notification_status_btn').innerText = '알림켜기';
                    }
                }
                modalClose('#alarm_on_modal');
            })
        }

        {{-- 이미지 팝업 띄우기 --}}
        /*
        const openImageModal = imageUrl => {
            document.getElementById('image_content').setAttribute('style', 'background-image: url('+imageUrl+');')
            openModal('#msg_imgviewer');
        }
        */

        {{-- 이미지 버튼 클릭 시 --}}
        const selectImage = () => {
            document.getElementById('image').click();
        }

        function keyupMessage(e) {
            if (window.event.keyCode === 13) { // enter key
                submitMessage(document.getElementById('submitBtn'));
                document.getElementById('chat_message').value = '';
            }
        }
        function clickMessage(e) {
            submitMessage(document.getElementById('submitBtn'));
            document.getElementById('chat_message').value = '';
        }
        {{-- 메시지 전송 --}}
        const submitImgMessage = () => {
            let elem = document.getElementById('submitBtn');
            if (elem.dataset.processing) {
                return false;
            }
            elem.dataset.processing = "Y";
            const roomIdx = elem.dataset.roomIdx;
            const data = new FormData();
            const imageFiles = document.getElementById('img_file').files;
            data.append('room_idx', roomIdx);

            const fileName = document.getElementById('img_file').value.slice(document.getElementById('img_file').value.lastIndexOf(".") + 1).toLowerCase();
            const isImageFile = fileName == "jpg" || fileName == "png" || fileName == "gif";

//            alert('fileName : ' + fileName);
            if (imageFiles.length > 0) {
                data.append('message_image', imageFiles[0]);
            }
            if (!isImageFile) {
                alert('지원하지 않는 파일입니다.\n 지원되는 확장자 : jpg, png, gif.\n 입력 확장자 : [' + fileName + ']');
                delete elem.dataset.processing;
                return false;
            }

            if (document.getElementById('product_idx')) {
                data.append('product_idx', document.getElementById('product_idx').value);
            }
            if (imageFiles.length < 1 && !document.getElementById('product_idx')) {
                delete elem.dataset.processing;
                return false;

            }
            data.append('message', '');
            fetch('/message/send', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: data,
            }).then(response => {
                delete elem.dataset.processing;
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Sever Error');
            }).then(json => {
                if (json.result === 'success') {
//                    visibleRoom(roomIdx);
                }
            }).catch(error => {
                delete elem.dataset.processing;
            })
        }
        {{-- 메시지 전송 --}}
        const submitMessage = elem => {
            if (elem.dataset.processing) {
                return false;
            }
            elem.dataset.processing = "Y";
            const roomIdx = elem.dataset.roomIdx;
            const data = new FormData();
            const message = document.getElementById('chat_message').value;
            data.append('room_idx', roomIdx);
            if (message) {
                data.append('message', message);
            }
            if (document.getElementById('product_idx')) {
                data.append('product_idx', document.getElementById('product_idx').value);
            }
            if (!message && !document.getElementById('product_idx')) {
                return false;
            }
            fetch('/message/send', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: data,
            }).then(response => {
                delete elem.dataset.processing;
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Sever Error');
            }).then(json => {
                if (json.result === 'success') {
//                    visibleRoom(roomIdx);
                }
            }).catch(error => {
                delete elem.dataset.processing;
            })
        }

        {{-- 대화방 키워드 검색하기 --}}
        var keywordCursorInRoom = -1;
        const prevBoldSearchKeywordInRoom = () => {
            const keyword = $('#chatting_keyword_inroom').val();
            const targets = $('.chatting_list > .chatting > .chat_box:contains("'+keyword+'")');

            if(keywordCursorInRoom >= targets.length - 1) {
                keywordCursorInRoom = targets.length - 1;

                if($('#btnGetChatMore').is(':visible')) {
                    getChatting($('#btnGetChatMore')[0].dataset.key);
                } else {
                    $('#btnPrevSearchInroom').removeClass('active');
                }
                return;
            }

            if(!$('#btnNextSearchInroom').hasClass('active')) {
                $('#btnNextSearchInroom').addClass('active');
            }
            keywordCursorInRoom = keywordCursorInRoom + 1;

            $('.text-white.bg-stone-900').removeClass('cursorthis');
            $('.chatting_list').scrollTop($(targets[targets.length - keywordCursorInRoom - 1])[0].offsetTop
                - $(targets[targets.length - keywordCursorInRoom - 1])[0].offsetHeight - 35);
            $(targets[targets.length - keywordCursorInRoom - 1])[0].outerHTML =
                $(targets[targets.length - keywordCursorInRoom - 1])[0].outerHTML.replaceAll('text-white bg-stone-900', 'text-white bg-stone-900 cursorthis');
        }
        const nextBoldSearchKeywordInRoom = () => {
            const keyword = $('#chatting_keyword_inroom').val();
            const targets = $('.chatting_list > .chatting > .chat_box:contains("'+keyword+'")');
            if(targets.length < 1) {
                return;
            }
            if(keywordCursorInRoom == 0) {
                $('#btnNextSearchInroom').removeClass('active');
                return;
            }
            if(!$('#btnPrevSearchInroom').hasClass('active')) {
                $('#btnPrevSearchInroom').addClass('active');
            }
            keywordCursorInRoom = keywordCursorInRoom - 1;

            $('.text-white.bg-stone-900').removeClass('cursorthis');
            $('.chatting_list').scrollTop($(targets[targets.length - keywordCursorInRoom - 1])[0].offsetTop
                - $(targets[targets.length - keywordCursorInRoom - 1])[0].offsetHeight - 35);
            $(targets[targets.length - keywordCursorInRoom - 1])[0].outerHTML =
                $(targets[targets.length - keywordCursorInRoom - 1])[0].outerHTML.replaceAll('text-white bg-stone-900', 'text-white bg-stone-900 cursorthis');
        }
        const cleanBoldKeyword = (tag) => {
            if(tag.children && tag.children.length > 0) {
                for(var idx = 0; idx < tag.children.length; idx++) {
                    cleanBoldKeyword(tag.children[idx]);
                }
                return;
            }
            if($(tag).hasClass('bg-stone-900')) {
                const txt = $(tag).text();
                tag.outerHTML = txt;
            }
        }
        const searchKeywordInRoom = () => {
            keywordCursorInRoom = 0;
            boldSearchKeywordInRoom();
        }
        const boldSearchKeywordInRoom = () => {
            const ttag = $('.chat_box > .text-white.bg-stone-900');
            for(var idx = 0; idx < ttag.length; idx++) {
                cleanBoldKeyword(ttag[idx]);
            }
            $('#btnPrevSearchInroom').removeClass('active');
            $('#btnNextSearchInroom').removeClass('active');

            // 대화방 안에서 검색입력이 되어 있다면 검색어 강조 표기를 한다.
            const keyword = $('#chatting_keyword_inroom').val();
            if(keyword == '' || keyword == 'undefined') {
                keywordCursorInRoom = 0;
                return;
            }

            const targets = $('.chatting_list > .chatting > .chat_box:contains("'+keyword+'")');
            if(targets.length < 1) {
                $('#btnNextSearchInroom').removeClass('active');
                if(!$('#btnGetChatMore').is(':visible')) {
                    $('#btnPrevSearchInroom').removeClass('active');
                }
            }
            $('.chatting_list').scrollTop($(targets[targets.length - keywordCursorInRoom - 1])[0].offsetTop
                - $(targets[targets.length - keywordCursorInRoom - 1])[0].offsetHeight - 35);
            for(var idx = 0; idx < targets.length; idx++) {
                targets[idx].outerHTML = targets[idx].outerHTML.replaceAll(keyword, '<span class="text-white bg-stone-900">'+keyword+'</span>');
            }
            $('#btnNextSearchInroom').removeClass('active');
            $('#btnPrevSearchInroom').addClass('active');
        }

        const reportModal = (company_idx, company_type) => {
            const btn = document.getElementById('confirmReportBtn');
            btn.dataset.companyIdx= company_idx;
            btn.dataset.companyType = company_type;
            modalOpen('#declaration_modal');
        }

        const writeReportContent = (ele) => {
            if (ele.value) {
                document.getElementById('reportReasonTextCount').innerText = ele.value.length;
                document.getElementById('confirmReportBtn').removeAttribute('disabled');
            } else {
                document.getElementById('confirmReportBtn').setAttribute('disabled', 'disabled');
            }
        }

        const report = elem => {
            fetch('/message/report', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: JSON.stringify({
                    company_idx: elem.dataset.companyIdx,
                    company_type: elem.dataset.companyType,
                    content: document.getElementById('alltalkReportContent').value,
                })
            }).then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Sever Error');
            }).then(json => {
                if (json.result === 'success') {
                    alert('신고되었습니다.');
                    modalClose('#declaration_modal');
                }
            }).catch(error => {
            })
        }

        /*
        {{-- 검색어 영역 엔터 시 검색어 찾기 --}}
        document.getElementById('keyword').addEventListener('keyup', e => {

            if ( $('#keyword').val() === '' ) {
                $('#recent_keyword').show();
            } else {
                $('#recent_keyword').hide();
            }

            if (e.key === 'Enter') { // enter key
                const params = {};
                params['keyword'] = e.currentTarget.value;
                location.href='/message?' + new URLSearchParams(params);
            }
        })
        */


        $(document).on('keyup', '#chat_message', function(e) {
            if (e.key === 'Enter') { // enter key
                submitMessage(document.getElementById('submitBtn'));
                e.currentTarget.value = '';
            }
        })

        /*
        {{-- 이미지 미리보기 --}}
        $(document).on('change', '#image', function(evt) {
             if (evt.currentTarget.files.length > 0) { // 이미지 선택
                 document.getElementById('submitBtn').removeAttribute('disabled');
                 document.querySelector('.section__bottom').classList.add('section__bottom--photo', 'section__bottom--photo-text');
                 document.getElementById('previewWrap').classList.add('textfield--photo');
                 document.querySelector('[name=chat_message]').classList.add('message-input--photo', 'message-input--photo-text');
                 document.getElementById('selectedImagePreview').classList.remove('hidden');

                 const reader = new FileReader();
                 reader.onload = function(e) {
                     document.getElementById('preview').style.backgroundImage = "url('"+e.target.result+"')";
                 };
                 reader.readAsDataURL(evt.currentTarget.files[0]);
             } else { // 이미지 선택 취소
                 document.querySelector('.section__bottom').classList.remove('section__bottom--photo', 'section__bottom--photo-text');
                 document.getElementById('previewWrap').classList.remove('textfield--photo');
                 document.querySelector('[name=chat_message]').classList.remove('message-input--photo', 'message-input--photo-text');
                 document.getElementById('selectedImagePreview').classList.add('hidden');
                 if (document.getElementById('chat_message').value.length < 1 && !document.getElementById('product_idx')) {
                     document.getElementById('submitBtn').setAttribute('disabled', 'true');
                 }
             }
        });
        */

        {{-- 메시지 입력 시 --}}
        $(document).on('keyup', '#chat_message', function(evt) {
            if (evt.currentTarget.value.length > 0) {
                document.getElementById('submitBtn').removeAttribute('disabled');
            } else {
                if (document.getElementById('image').files.length < 1 && !document.getElementById('product_idx')) {
                    document.getElementById('submitBtn').setAttribute('disabled', 'true');
                }
            }
        })
    </script>

@include('m.message.modal')


@endsection