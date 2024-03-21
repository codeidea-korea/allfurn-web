@extends('layouts.app')

@section('content')
@include('layouts.header')

<div id="content">
    <section class="sub_section message_con01">
        <div class="inner">
            <div class="list_box">
                <div class="top_search">
                    <a href="javascript:;">
                        <svg><use xlink:href="/img/icon-defs.svg#left_arrow"></use></svg>
                    </a>
                    <div class="input_form">
                        <svg style="cursor: pointer;" onclick="searchKeyword($('#chatting_keyword').val())"><use xlink:href="/img/icon-defs.svg#Search"></use></svg>
                        <input type="text" placeholder="업체명 및 대화 내용을 검색해주세요." id="chatting_keyword" name="keyword" value="{{ request()->get('keyword') }}">
                    </div>
                    <div class="flex items-center gap-2 ml-3 talk_search_arrow">
                        <button class="active"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-up"><path d="m18 15-6-6-6 6"/></svg></button>
                        <button ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down"><path d="m6 9 6 6 6-6"/></svg></button>
                    </div>
                </div>
                <ul class="message_list _chatting_rooms">
                    <!-- Ajax include -->

                    @foreach($rooms as $room)
                    <li onclick="searchKeywordRoom({{ $room->idx }})">
                        <div class="img_box">
                            <img src="/img/profile_img.svg" alt="">
                        </div>
                        <div class="txt_box">
                            <h3>
                                {{ $room->name }}
                                <span>{{ $room->last_message_time }}</span>
                            </h3>
                            <div class="desc _room{{ $room->idx }}LastMent">{{ $room->last_message_content }}</div>
                        </div>
                    </li>
                    @endforeach
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
    </script>

    <script>
        $(document).ready(function(){
            const searchParams = new URLSearchParams(location.search);
            if (searchParams.get('roomIdx') != null) {
                visibleRoom(searchParams.get('roomIdx'));
            };
        });
        
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

        {{-- 대화방 리스트 검색어 찾기 --}}
        const searchKeyword = keyword => {
            // TODO: 요청사항 있을시 ajax 로 변경해야함 -> UX 가 새로고침이 아님
            location.href='/message?' + new URLSearchParams({keyword:keyword});
        }
        */

        {{-- 대화방 내용 가져오기 --}}
        const visibleRoom = (idx) => {
            
            let params = {room_idx: idx}
            
            @if($product_idx)
                params['product_idx'] = '{{ $product_idx }}';
            @endif
                
            if (document.getElementById('chatting_keyword')) {
                params['keyword'] = document.getElementById('chatting_keyword').value;
            }
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
            
                const pusher = new Pusher('51b26f4641d16394d3fd', {
                cluster: 'ap3'
                });

                const roomIdx = idx;
                var channel = pusher.subscribe('chat-' + roomIdx);
                channel.bind('chat-event-' + roomIdx, function(messages) {
                    console.log(JSON.stringify(messages));

                    var tm = $($('.chatting_list > .date')[$('.chatting_list > .date').length - 1]).find('span').text(); 
                    const lastCommunicatedDate = tm.substring(0, tm.indexOf('요일') - 2);

                    if(messages.date != lastCommunicatedDate) {
                        const dateTag = '<div class="date"><span>'+messages.date+' '+messages.dateOfWeek+'요일</span></div>';
                        $('.chatting_list').html($('.chatting_list').html() + dateTag);
                    }
                    $('.chatting_list').html($('.chatting_list').html() + messages.contentHtml);
                    
                    $('.chatting_list').scrollTop($('.chatting_list')[0].scrollHeight);
                    $('._room'+roomIdx+'LastMent').text(messages.title);
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
                
            if (document.getElementById('chatting_keyword')) {
                params['keyword'] = document.getElementById('chatting_keyword').value;
            }
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
                document.querySelector('.chat-box:last-child').focus();
                
                setTimeout(() => {
                    $('.chatting_list').scrollTop(0);
                }, 100);
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
            const imageFiles = document.getElementById('img_file').files;
            if (imageFiles.length > 0) {
                data.append('message_image', imageFiles[0]);
            }
            if (document.getElementById('product_idx')) {
                data.append('product_idx', document.getElementById('product_idx').value);
            }
            if (!message && imageFiles.length < 1 && !document.getElementById('product_idx')) {
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
        const searchKeywordRoom = idx => {
            visibleRoom(idx);
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


        $(document).on('keyup', '#chatting_keyword', function(evt) {
            
            if (evt.key === 'Enter') { // enter key
                
                const roomIdx = evt.currentTarget.dataset.roomIdx;
                
                searchKeywordRoom(roomIdx);
                
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



@endsection

@include('message.modal')
