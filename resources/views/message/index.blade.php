@extends('layouts.app')

@section('content')
@include('layouts.header')

<style>
.talk_search_arrow button{
  color:#DBDBDB;
}
.talk_search_arrow button.active{
  color:#46433F;
}
.cursorthis{
  color:rgb(28 25 23 / var(--tw-bg-opacity)) !important;
  background-color:rgb(200 202 23 / var(--tw-bg-opacity)) !important;
}
</style>
<div id="content">
    <section class="sub_section message_con01">
        <div class="inner">
            <div class="list_box">
                <div class="top_search">
                    <a href="javascript:;">
                        <svg><use xlink:href="/img/icon-defs.svg#left_arrow"></use></svg>
                    </a>
                    <div class="input_form">
                        <svg style="cursor: pointer;" onclick="searchKeyword()"><use xlink:href="/img/icon-defs.svg#Search"></use></svg>
                        <input type="text" placeholder="업체명 및 대화 내용을 검색해주세요." id="chatting_keyword" name="keyword" value="{{ request()->get('keyword') }}" onkeyup="searchKeywordByKeyup()">
                    </div>
                    <!--
                    <div class="flex items-center gap-2 ml-3 talk_search_arrow">
                        <button class="active"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-up"><path d="m18 15-6-6-6 6"/></svg></button>
                        <button ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down"><path d="m6 9 6 6 6-6"/></svg></button>
                    </div>
-->
                </div>
                <ul class="message_list _chatting_rooms">
                    @foreach($rooms as $room)
                    <li onclick="visibleRoom({{ $room->idx }})" data-key="{{ $room->idx }}">
                        <div class="img_box">
                            <img src="{{ $room->profile_image }}" class="object-cover w-full h-full" alt="">
                        </div>
                        <div class="txt_box">
                            <h3>
                                {{ $room->name }}
                                <span id="chat-{{ $room->idx }}-unreadCount" class="{{  $room->unread_count == 0 ? '' : 'num' }}">{{ $room->unread_count == 0 ? '' : $room->unread_count }}</span>
                            </h3>
                            <div class="desc">
				<span class="_room{{ $room->idx }}LastMent">{{ $room->last_message_content }}</span>
				<span class="_room{{ $room->idx }}LastDate">
				    @if($room->register_date == date('Y년 n월 j일')
					{{ $room->register_times }}
				    @else
					{{ $room->register_date }}
				    @endif
				</span>
			    </div>
                        </div>
                    </li>
                    @endforeach
                    <!-- Ajax include -->
                </ul>
            </div>
            <div class="chatting_box message__section">
                <!-- 채팅방 클릭 전 -->
                <div class="chatting_intro">
                    <div class="message_box">
                        <i><svg><use xlink:href="/img/icon-defs.svg#message"></use></svg></i>
                        <p>대화 목록에서 업체를 선택하여 메세지를 확인하세요.</p>
                    </div>
                </div>
                <!-- Ajax include -->
            </div>
        </div>
    </section>
</div>

    <!-- pusher -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
    Pusher.logToConsole = false;
    var openedRoomIdx = 0;
            
    var pusher = new Pusher('51b26f4641d16394d3fd', {
        cluster: 'ap3'
    });

    var cchannel = pusher.subscribe('user-cmd-{{ $user_idx }}');
    cchannel.bind('user-cmd-event-{{ $user_idx }}', function(messages) {
        console.log(JSON.stringify(messages));

        if(messages && messages.message == 'msg') {
            const rooms = document.querySelector('._chatting_rooms > li');
            const newestRoom = $('._chatting_rooms > li[data-key='+messages.roomIdx+']');

            if(newestRoom.length > 0) {
                rooms.insertAdjacentElement('beforebegin', newestRoom[0]);
                if(openedRoomIdx != messages.roomIdx) {
                    const count = $('#chat-'+messages.roomIdx+'-unreadCount').text() == "" ? 0 : Number($('#chat-'+messages.roomIdx+'-unreadCount').text());
		    $('#chat-'+messages.roomIdx+'-unreadCount').text(count + 1);
		    $('#chat-'+messages.roomIdx+'-unreadCount').removeClass('num');
		     $('#chat-'+messages.roomIdx+'-unreadCount').addClass('num');
                }
            } else {
		var d = new Date();
                const tmpChattingRoom = 
                        '<li onclick="visibleRoom('+messages.roomIdx+')" data-key="'+messages.roomIdx+'">'
                        +'    <div class="img_box">'
                        +'        <img src="'+messages.dateOfWeek+'" alt="">'
                        +'    </div>'
                        +'    <div class="txt_box">'
                        +'        <h3>'
                        +'            '+messages.roomName
                        + (openedRoomIdx != messages.roomIdx ? ' <span id="chat-'+messages.roomIdx+'-unreadCount" class="num">1</span>' : '')
                        +'            <span>'+messages.title+'</span>'
                        +'        </h3>'
                        +'        <div class="desc">'
                        +'            <span class="_room'+messages.roomIdx+'LastMent">'+ messages.title +'</span>'
                        +'            <span class="_room'+messages.roomIdx+'LastDate">'+ (messages.date == (d.getFullYear() + '년 ' + d.getMonth() + '월 ' + d.getDate() + '일') ? messages.times : messages.date) +'</span>'
			+'        </div>'
                        +'    </div>'
                        +'</li>';
                $('._chatting_rooms').html(tmpChattingRoom + $('._chatting_rooms').html());
            }
            if(openedRoomIdx == messages.roomIdx) {
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
            // 활성화 처리 및 텍스트 변경
            $($('._chatting_rooms > li')[0]).find('.txt_box > .desc').text(messages.title);
        $($('._chatting_rooms > li')[0]).find('.txt_box > h3 > span:nth-child(2)').text(messages.times);
        } else {
            $('.chatting_list > .chatting.right > ._alert').remove();
        }
    });
    </script>

    <script>
        $(document).ready(function(){
            const searchParams = new URLSearchParams(location.search);
            if (searchParams.get('roomIdx') != null) {
                visibleRoom(searchParams.get('roomIdx'));
            };
        });


        const searchKeywordByKeyup = () => {
//            console.log(this);
            if (window.event.key == 'Enter') { // enter key
//                searchKeyword();
            }
            searchKeyword();
        }
        
        /*
        {{-- 검색어 전체 삭제 --}}
        const deleteAllKeyword = () => {
            if(confirm('전체 삭제하시겠습니까?')) {
                fetch('/message/keyword/all', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    }
                }).then(response => {
                    return response.json();
                }).then(json => {
                    if (json.result === 'success') {
                        document.querySelector('.list-insearch-history').classList.add('list-insearch-history--empty');
                        document.querySelector('.list-insearch-history').innerHTML
                            = '<div class="row">' +
                                '<div class="title">최근 검색어</div>' +
                              '</div>' +
                              '<div class="empty">최근 검색한 내역이 없습니다.</div>';
                    }
                })
            }
        }

        {{-- 검색어 삭제 처리 --}}
        const deleteKeyword = elem => {
            const idx = elem.dataset.idx;
            fetch('/message/keyword/' + idx, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            }).then(response => {
                return response.json();
            }).then(json => {
                if (json.result === 'success') {
                    elem.closest('.row').remove();
                } else {
                }
            })
        }

        */

        {{-- 대화방 내용 가져오기 --}}
        const visibleRoom = (idx) => {
            
            let params = {room_idx: idx}
            
            @if($product_idx)
                params['product_idx'] = '{{ $product_idx }}';
            @endif
            
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
                openedRoomIdx = roomIdx;
		$('#chat-'+openedRoomIdx+'-unreadCount').text('');
		 $('#chat-'+openedRoomIdx+'-unreadCount').removeClass('num');
                pusher.disconnect(); // TESTSETSETSE
                pusher = new Pusher('51b26f4641d16394d3fd', {
                    cluster: 'ap3'
                });

                var cchannel = pusher.subscribe('user-cmd-{{ $user_idx }}');
                cchannel.bind('user-cmd-event-{{ $user_idx }}', function(messages) {
                    console.log(JSON.stringify(messages));

                    if(messages && messages.message == 'msg') {
                        const rooms = document.querySelector('._chatting_rooms > li');
                        const newestRoom = $('._chatting_rooms > li[data-key='+messages.roomIdx+']');

                        if(newestRoom.length > 0) {
                            rooms.insertAdjacentElement('beforebegin', newestRoom[0]);
                            if(openedRoomIdx != messages.roomIdx) {
                                const count = $('#chat-'+messages.roomIdx+'-unreadCount').text() == "" ? 0 : Number($('#chat-'+messages.roomIdx+'-unreadCount').text());
				$('#chat-'+messages.roomIdx+'-unreadCount').text(count + 1);
				$('#chat-'+messages.roomIdx+'-unreadCount').removeClass('num');

 $('#chat-'+messages.roomIdx+'-unreadCount').addClass('num');
                            }
                        } else {
			    var d = new Date();
                            const tmpChattingRoom = 
                                    '<li onclick="visibleRoom('+messages.roomIdx+')" data-key="'+messages.roomIdx+'">'
                                    +'    <div class="img_box">'
                                    +'        <img src="'+messages.dateOfWeek+'" alt="">'
                                    +'    </div>'
                                    +'    <div class="txt_box">'
                                    +'        <h3>'
                                    +'            '+messages.roomName
                                    + (openedRoomIdx != messages.roomIdx ? ' <span id="chat-'+messages.roomIdx+'-unreadCount" class="num">1</span>' : '')
                                    +'            <span>'+messages.title+'</span>'
                                    +'        </h3>'
				    +'        <div class="desc">'
		                    +'            <span class="_room'+messages.roomIdx+'LastMent">'+ messages.title +'</span>'
		                    +'            <span class="_room'+messages.roomIdx+'LastDate">'+ (messages.date == (d.getFullYear() + '년 ' + d.getMonth() + '월 ' + d.getDate() + '일') ? messages.times : messages.date) +'</span>'
				    +'        </div>'
                                    +'    </div>'
                                    +'</li>';
                            $('._chatting_rooms').html(tmpChattingRoom + $('._chatting_rooms').html());
                        }
                        if(openedRoomIdx == messages.roomIdx) {
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
                        // 활성화 처리 및 텍스트 변경
                        $($('._chatting_rooms > li')[0]).find('.txt_box > .desc').text(messages.title);
        $($('._chatting_rooms > li')[0]).find('.txt_box > h3 > span:nth-child(2)').text(messages.times);
                    } else {
                        $('.chatting_list > .chatting.right > ._alert').remove();
                    }
                });
                var channel = pusher.subscribe('chat-' + roomIdx);
                channel.bind('chat-event-' + roomIdx, function(messages) {
                    console.log(JSON.stringify(messages));

                    // 활성화 처리 및 텍스트 변경
                    $($('._chatting_rooms > li')[0]).find('li > .txt_box > h3 > span').text(messages.title);

                    var tm = $($('.chatting_list > .date')[$('.chatting_list > .date').length - 1]).find('span').text(); 
                    const lastCommunicatedDate = tm.substring(0, tm.indexOf('요일') - 2);

                    if(messages.date != lastCommunicatedDate) {
                        const dateTag = '<div class="date"><span>'+messages.date+' '+messages.dateOfWeek+'요일</span></div>';
                        $('.chatting_list').html($('.chatting_list').html() + dateTag);
                    }
                    if(messages.companyIdx != {{ $companyIdx }}) {
                        messages.contentHtml = messages.contentHtml.replace('chatting right', 'chatting left');
                    }
                    $('.chatting_list').html($('.chatting_list').html() + messages.contentHtml);
                    
                    $('.chatting_list').scrollTop($('.chatting_list')[0].scrollHeight);
                    $('._room'+roomIdx+'LastMent').text(messages.title);
		    $('._room'+roomIdx+'LastDate').text(messages.times);

                    if($('#chatting_keyword').val() != '') {
                        $('#chatting_keyword_inroom').val($('#chatting_keyword').val());
                        boldSearchKeywordInRoom();
                    }
                });
                setTimeout(() => {
                    document.querySelector('.chatting_list').focus();
                    $('.chatting_list').scrollTop($('.chatting_list')[0].scrollHeight);
                }, 100);
                document.querySelector('.chat-box:last-child').focus();
                
            }).catch(error => {
            })
        }
        var pageNo = 1;
        const getChatting = (idx) => {
            
            let params = {room_idx: idx, pageNo: pageNo}
            
            @if($product_idx)
                params['product_idx'] = '{{ $product_idx }}';
            @endif
                
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
        const loadEvent = (roomIdx) => {
                    
            // 우측 검색아이콘 클릭시
            $('.chatting_box .right_search_btn').off().on('click',function(){
                $('.chatting_box .top_search').addClass('active')
            });
            $('.chatting_box .top_search .prev_btn').off().on('click',function(){
                $('.chatting_box .top_search').removeClass('active')
            });

            // 업체 주소
            $('.chatting_box .company_info_btn').off().on('click',function(){
                $(this).toggleClass('active')
                $('.chatting_box .top_info .company_info').toggleClass('active');
            });
        };


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
            data.append('room_idx', roomIdx);
            data.append('message', '');
            const imageFiles = document.getElementById('img_file').files;
            if (imageFiles.length > 0) {
                data.append('message_image', imageFiles[0]);
            }
            if (document.getElementById('product_idx')) {
                data.append('product_idx', document.getElementById('product_idx').value);
            }
            if (imageFiles.length < 1 && !document.getElementById('product_idx')) {
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

        {{-- 대화방 리스트 검색어 찾기 --}}
        const searchKeyword = () => {
            // 현재 존재하는 내용에서 조회한다. - 소켓으로 받는 데이터도 계속 갱신된다는 가정 chatting_keyword
            const keyword = $('#chatting_keyword').val();
            if(!keyword || keyword == '' || keyword.trim() == '') {
                const rooms = $('.message_list > li');
                for(var jnx = 0; jnx < rooms.length; jnx++) {
                    $(rooms[jnx]).show();
                }
            }
            fetch('/message/rooms?' + new URLSearchParams({ keyword: keyword }), {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
            }).then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Sever Error');
            }).then(json => {
                if (json.result === 'success') {
                    const rooms = $('.message_list > li');
                    $('.message_list > li').hide();
                    
                    for(var inx = 0; inx < json.data.length; inx++) {
                        for(var jnx = 0; jnx < rooms.length; jnx++) {
                            if(rooms[jnx].dataset.key == json.data[inx].idx) {
                                $(rooms[jnx]).show();
                                break;
                            }
                        }
                    }
                }
            }).catch(error => {
            })
        }

        {{-- 대화방 키워드 검색하기 --}}
        const searchKeywordRoom = () => {
        }
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
            if(keyword == '') {
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
        
        // 채팅방 클릭시
        $('.message_con01 .list_box .message_list li').on('click',function(){
            $('.chatting_box .chatting_intro').addClass('hidden')
            $(this).addClass('active').siblings().removeClass('active')
        })

        @if ($product_idx && $room_idx)
            visibleRoom({{ $room_idx }});
        @endif
    </script>



@include('message.modal')

@endsection
