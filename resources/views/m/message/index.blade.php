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
        <div class="inner">
            <div class="list_box">
                <div class="title">
                    <h3>올톡</h3>
                    <button class="search_btn"><svg><use xlink:href="/img/icon-defs.svg#Search_black"></use></svg></button>
                </div>
                
                <ul class="message_list _chatting_rooms">
                    @foreach($rooms as $room)
                    <li onclick="visibleRoom({{ $room->idx }})" data-key="{{ $room->idx }}">
                        <a href="javascript:;">
                            <div class="img_box">
                                <img src="{{ $room->profile_image }}" alt="">
                            </div>
                            <div class="txt_box">
                                <h3>
                                    {{ $room->name }}
                                    <span id="chat-{{ $room->idx }}-unreadCount"  class="{{  $room->unread_count <= 0 ? '' : 'num' }}">{{ $room->unread_count == 0 ? '' : $room->unread_count }}</span>
                                </h3>
                                <div class="desc">
				   <span class="_room{{ $room->idx }}LastMent">{{ $room->last_message_content }}</span>
				   <span class="_room{{ $room->idx }}LastDate">
				    @if($room->register_date == date('Y년 n월 j일'))
					{{ $room->register_times }}
				    @else
					{{ $room->register_date }}
				    @endif
				   </span>
				</div>
                            </div>
                        </a>
                    </li>
                    @endforeach
                    <!-- Ajax include -->
                </ul>
{{--
                <div class="search_box">
                    <div class="top_search">
                        <a href="javascript:;" class="search_close">
                            <svg><use xlink:href="/img/icon-defs.svg#left_arrow"></use></svg>
                        </a>
                        <div class="input_form">
                            <svg style="cursor: pointer;" onclick="searchKeyword($('#chatting_keyword').val())"><use xlink:href="/img/icon-defs.svg#Search"></use></svg>
                            <input type="text" placeholder="업체명 및 대화 내용을 검색해주세요." id="chatting_keyword" name="keyword" value="{{ request()->get('keyword') }}" onkeyup="searchKeywordByKeyup()">
                        </div>
                    </div>
                    <div class="search_result">
                        <div class="record_box">
                            <div class="tit">
                                <p>최근 검색어</p>
                                <button onclick="deleteAllKeyword()">전체 삭제</button>
                            </div>
                            @if(is_array($keywords) && !empty($keywords))
                                <div class="record_list">
                                    @foreach($keywords as $keyword)
                                    <p>
                                        <span click="searchKeywordByRecorded('{{ $keyword->keyword }}')"> {{ $keyword->keyword }} </span>
                                        <button data-idx="{{ $keyword->idx }}" onclick="deleteKeyword()"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button>
                                    </p>
                                    @endforeach
                                </div>
                            @else
                                <div class="record_list">
                                    <div class="empty">최근 검색한 내역이 없습니다.</div>
                                </div>
                            @endif
                        </div>

                        <ul class="message_list _chatting_rooms">
                            @foreach($rooms as $room)
                            <li onclick="visibleRoom({{ $room->idx }})" data-key="{{ $room->idx }}">
                                <a href="javascript:visibleRoom({{ $room->idx }})">
                                    <div class="img_box">
                                        <img src="{{ $room->profile_image }}" alt="">
                                    </div>
                                    <div class="txt_box">
                                        <h3>
                                            {{ $room->name }}
                                            <span id="chat-{{ $room->idx }}-unreadCount" class="{{  $room->unread_count <= 0 ? '' : 'num' }}">{{ $room->unread_count <= 0 ? '' : $room->unread_count }}</span>
                                            <span>{{ $room->last_message_time }}</span>
                                        </h3>
                                        <div class="desc">
					    <span class="_room{{ $room->idx }}LastMent">{{ $room->last_message_content }}</span>
					    <span class="_room{{ $room->idx }}LastDate">
						@if($room->register_date == date('Y년 n월 j일'))
						    {{ $room->register_times }}
						@else
						    {{ $room->register_date }}
						@endif
					   </span>
					</div>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                            <!-- Ajax include -->

                            <!-- 검색 결과 없을떄 -->
                            <li class="no_result">
                                검색된 메시지가 없습니다.
                            </li>
                        </ul>
                    </div>
        
                </div> --}}
            </div>
        </div>
    </section>

</div>

<script>
    // 채팅방 클릭시
    $('.message_con01 .list_box .message_list li').on('click',function(){
        $(this).addClass('active').siblings().removeClass('active')
    })

    // 우측 검색아이콘 클릭시
    $('.chatting_box .right_search_btn').on('click',function(){
        $('.chatting_box .top_search').addClass('active')
    })
    $('.chatting_box .top_search .prev_btn').on('click',function(){
        $('.chatting_box .top_search').removeClass('active')
    })

    // 업체 주소
    $('.chatting_box .company_info_btn').on('click',function(){
        $(this).toggleClass('active')
        $('.chatting_box .top_info .company_info').toggleClass('active');
    })
</script>

    <!-- pusher -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
    Pusher.logToConsole = false;
    var openedRoomIdx = 0;
            
    const pusher = new Pusher('51b26f4641d16394d3fd', {
        cluster: 'ap3'
    });

    var cchannel = pusher.subscribe('user-cmd-{{ $user_idx }}');
    cchannel.bind('user-cmd-event-{{ $user_idx }}', function(messages) {
//        console.log(JSON.stringify(messages));
        const rooms = document.querySelector('._chatting_rooms > li');
        const newestRoom = $('._chatting_rooms > li[data-key='+messages.roomIdx+']');

        if(newestRoom.length > 0) {
            rooms.insertAdjacentElement('beforebegin', newestRoom[0]);
            const count = Number($('#chat-'+messages.roomIdx+'-unreadCount').text());
	    $('#chat-'+messages.roomIdx+'-unreadCount').text(count + 1);
	     $('#chat-'+messages.roomIdx+'-unreadCount').removeClass('num');

 $('#chat-'+messages.roomIdx+'-unreadCount').addClass('num');
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
                    +'            <span id="chat-'+messages.roomIdx+'-unreadCount" class="num">1</span>'
                    +'            <span>'+messages.title+'</span>'
                    +'        </h3>'
		    +'        <div class="desc">'
                    +'            <span class="_room'+messages.roomIdx+'LastMent">'+ messages.title +'</span>'
                    +'            <span class="_room'+messages.roomIdx+'LastDate">'+ (messages.date == (d.getFullYear() + '년 ' + (d.getMonth()+1) + '월 ' + (d.getDate()) + '일') ? messages.times : messages.date) +'</span>'
		    +'        </div>'
                    +'    </div>'
                    +'</li>';
            $('._chatting_rooms').html(tmpChattingRoom + $('._chatting_rooms').html());
        }
        // 활성화 처리 및 텍스트 변경
	    var d = new Date();
        $($('._chatting_rooms > li')[0]).find('.txt_box > .desc').html('            <span class="_room'+messages.roomIdx+'LastMent">'+ messages.title +'</span>'
                    +'            <span class="_room'+messages.roomIdx+'LastDate">'+ (messages.date == (d.getFullYear() + '년 ' + (d.getMonth()+1) + '월 ' + (d.getDate()) + '일') ? messages.times : messages.date) +'</span>'
		    );
        $($('._chatting_rooms > li')[0]).find('.txt_box > h3 > span:nth-child(2)').text(messages.times);
    });
    </script>

    <script>
        $('._chatting_rooms > .no_result').hide();
        const searchKeywordByKeyup = () => {
//            console.log(this);
            if (window.event.key == 'Enter') { // enter key
//                searchKeyword();
            }
            searchKeyword();
        }
        
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
        const searchKeywordByRecorded = (text) => {
            $('#chatting_keyword').val(text);
            searchKeyword(text);
        }

        {{-- 대화방 이동 --}}
        const visibleRoom = (idx) => {
            cchannel.disconnect();
            cchannel.unbind('user-cmd-event-{{ $user_idx }}');

            window.location.href = location.pathname + '/room?' + new URLSearchParams({ room_idx: idx, chatting_keyword: $('#chatting_keyword').val() });
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
                    const rooms = $($('.message_list')[1]).find('li');
                    var isAnyShow = false;
                    $($('.message_list')[1]).find('li').hide();
                    $('._chatting_rooms > .no_result').hide();
                    
                    for(var inx = 0; inx < json.data.length; inx++) {
                        for(var jnx = 0; jnx < rooms.length; jnx++) {
                            if(rooms[jnx].dataset.key == json.data[inx].idx) {
                                $(rooms[jnx]).show();
                                isAnyShow = true;
                                break;
                            }
                        }
                    }
                    
                    // 하나도 조회되지 않은 경우
                    if(!isAnyShow) $('._chatting_rooms > .no_result').show();
                }
            }).catch(error => {
            })
        }
    </script>

    @include('m.message.modal')
@endsection
