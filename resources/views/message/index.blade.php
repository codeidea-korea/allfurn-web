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
                </div>
                <ul class="message_list">
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
                            <div class="desc">{{ $room->last_message_content }}</div>
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

                <!-- 채팅방 클릭 후 
                <div class="top_info">
                    <div class="top_search">
                        <a href="javascript:;" class="prev_btn">
                            <svg><use xlink:href="/img/icon-defs.svg#left_arrow"></use></svg>
                        </a>
                        <div class="input_form">
                            <svg><use xlink:href="/img/icon-defs.svg#Search"></use></svg>
                            <input type="text" placeholder="대화 내용을 검색해주세요.">
                        </div>
                    </div>
                    <div class="title">
                        <div class="img_box">
                            <img src="/img/profile_img.svg" alt="">
                        </div>
                        <h5>갑부가구산업</h5>
                        <span>알림 꺼짐</span>
                        <button class="company_info_btn"><img src="/img/icon/filter_arrow.svg" alt=""></button>
                    </div>
                    <div class="right_link">
                        <button class="right_search_btn"><svg><use xlink:href="/img/icon-defs.svg#Search_dark"></use></svg></button>
                        <div class="more_btn">
                            <button><svg><use xlink:href="/img/icon-defs.svg#more_dot"></use></svg></button>
                            <div>
                                <a href="javascript:;">알림켜기</a>
                                <a href="javascript:;">신고하기</a>
                            </div>
                        </div>
                    </div>
                    <div class="company_info">
                        <div class="add">경기 포천시 가산면 정금로 476번길 134-34 갑부가구산업</div>
                        <p>010-0000-0000</p>
                        <a href="/company_detail.php">업체 자세히 보기 <img src="/img/icon/filter_arrow.svg" alt=""></a>
                    </div>
                </div>
                <div class="chatting_list">
                    <div class="date"><span>2023년 11월 15일 수요일</span></div>
                    <div class="chatting right">
                        <div class="chat_box">상품 문의드립니다.</div>
                        <div class="timestamp">18:38</div>
                    </div>
                    <div class="chatting left">
                        <div class="chat_box">상품 문의드립니다.</div>
                        <div class="timestamp">18:38</div>
                    </div>
                    <div class="chatting right">
                        <div class="chat_box">               
                            <div class="flex flex-col">
                                <span>[ 견적문의가 도착했습니다 ]</span>             
                                <button class="flex flex-col mt-1">
                                    <p class="bg-primary p-2 rounded-md flex items-center text-white">
                                        바로가기
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                                    </p>
                                </button>
                            </div>
                        </div>
                        <div class="timestamp">18:38</div>
                    </div>
                </div>
                <div class="message_form">
                    <div class="file_box">
                        <input type="file" id="img_file">
                        <label for="img_file">
                            <img class="mx-auto" src="/img/member/img_icon.svg" alt="">
                        </label>
                    </div>
                    <input type="text" class="input-form" placeholder="메시지를 입력해주세요.">
                    <button class="btn btn-primary">전송</button>
                </div>
            -->
            </div>
        </div>
    </section>

</div>

<div id="msg_alarm" class="modal">
    <div class="modal__container">
        <div class="modal__content">
            <div class="modal-box__container">
                <div class="modal-box__content">
                    <div class="modal__desc">
                        <p class="modal__text">
                            해당 업체의 메세지 알림을 <span id="push-text">해제 하시겠습니까?</span>
                        </p>
                    </div>
                    <div class="modal__buttons">
                        <a onclick="closeModal('#msg_alarm')" role="button" class="modal__button modal__button--gray"><span>취소</span></a>
                        <a onclick="toggleAlarmPush()" role="button" id="confirmTogglePushBtn" class="modal__button"><span>확인</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="msg_report-submit" class="modal">
    <div class="modal__container">
        <div class="modal__content">
            <div class="modal-box__container">
                <div class="modal-box__content">
                    <div class="modal__desc">
                        <p class="modal__text">
                            해당 업체 신고가 완료되었습니다.
                        </p>
                    </div>
                    <div class="modal__buttons">
                        <input type="button" onclick="closeModal('#msg_report-submit')" class="modal__button" value="확인" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="msg_report" class="modal modal-conversation">
    <div class="modal__container">
        <div class="modal__content">
            <div class="modal-box__container" style="width:480px;">
                <div class="modal-box__content">
                    <div class="header">
                        <p>업체 신고</p>
                    </div>
                    <div class="content">
                        <div class="content__inner">
                            <p class="modal-box__heading">해당 업체를 신고하시겠습니까?</p>
                            <div class="textfield">
                                <textarea rows="10" class="textarea textfield__input" name="content" id="content" placeholder="신고 사유를 입력해주세요." onkeyup="writeReportContent()"></textarea>
                                <div class="textarea__count"><span class="textarea__count-meta" id="contentCount">0</span><i>/</i><span>100</span></div>
                            </div>
                            <div class="modal-box__bottom">
                                <input type="button" class="button" id="confirmReportBtn" disabled data-company-idx="" data-company-type="" onclick="report(this)" value="완료" />
                            </div>
                        </div>
                    </div>
                    <div class="footer"></div>
                    <div class="modal-close" onclick="closeModal('#msg_report')">
                        <button type="button" class="modal__close-button"><span class="a11y">닫기</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="msg_imgviewer" class="modal">
    <div class="modal__container">
        <div class="modal__content">
            <div class="modal-box__container">
                <div class="modal-box__content">
                    <div class="header"></div>
                    <div class="content">
                        <!-- 가로로 긴 이미지 -->
                        <!-- <div class="content__inner" style="background-image: url(/images/temp/msg_imgviewer_1.png);"></div> -->
                        <!--// 가로로 긴 이미지 -->
                        <!-- 세로로 긴 이미지 -->
                        <div class="content__inner" id="image_content" style="background-image: url(/images/temp/msg_imgviewer_2.png);"></div>
                        <!--// 세로로 긴 이미지 -->
                    </div>
                    <div class="footer"></div>
                    <div class="modal-close" onclick="closeModal('#msg_imgviewer')">
                        <button type="button" class="modal__close-button"><div class="ico__delete14"><span class="a11y">닫기</span></div></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- pusher -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
    Pusher.logToConsole = true;
    </script>

    <script>
        $(document).ready(function(){
            const searchParams = new URLSearchParams(location.search);
            if (searchParams.get('roomIdx') != null) {
                visibleRoom(searchParams.get('roomIdx'));
            };
        });
        
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

        {{-- 대화방 내용 가져오기 --}}
        const visibleRoom = idx => {
            
            let params = {room_idx: idx}
            
            @if($product_idx)
                params['product_idx'] = '{{ $product_idx }}';
            @endif
                
            if (document.getElementById('chatting_keyword')) {
                params['keyword'] = document.getElementById('chatting_keyword').value;
            }
            
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
            
            const pusher = new Pusher('51b26f4641d16394d3fd', {
            cluster: 'ap3'
            });

            var channel = pusher.subscribe('chat-' + roomIdx);
            channel.bind('chat-event-' + roomIdx, function(data) {
                console.log(JSON.stringify(data));

                const messages = JSON.parse(data);
                
                var tm = $($('.chatting_list > .date')[$('.chatting_list > .date').length - 1]).find('span').text(); 
                const lastCommunicatedDate = tm.substring(0, tm.indexOf('요일') - 2);

                if(messages.date != lastCommunicatedDate) {
                    lastCommunicatedDate = messages.date;
                    const dateTag = '<div class="date"><span>'+lastCommunicatedDate+' '+messages.dateOfWeek+'요일</span></div>';
                    $('.chatting_list').html($('.chatting_list').html() + dateTag);
                }
                $('.chatting_list').html($('.chatting_list').html() + messages.contentHtml);
            });
        };


        {{-- 알림 켜기/끄기 모달 띄우기 --}}
        const toggleAlarmModal = (company_type, company_idx) => {
            document.getElementById('confirmTogglePushBtn').dataset.companyType = company_type;
            document.getElementById('confirmTogglePushBtn').dataset.companyIdx = company_idx;
            if (document.querySelector('.notification_status_txt').innerText == '알림 켜짐') {
                document.getElementById('push-text').innerText = '해제 하시겠습니까?';
            } else {
                document.getElementById('push-text').innerText = '받으시겠습니까?';
            }
            openModal('#msg_alarm');
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
//                        document.querySelector('.alarm').classList.remove('alarm--off');
//                        document.querySelector('.alarm').classList.add('alarm--on');
                        document.querySelector('.notification_status_txt[data-company-idx='+company_idx+']').textContent = '알림 켜짐';
                        document.getElementById('notification_status_btn[data-company-idx='+company_idx+']').textContent = '알림끄기';
                    } else {
//                        document.querySelector('.alarm').classList.remove('alarm--on');
//                        document.querySelector('.alarm').classList.add('alarm--off');
                        document.querySelector('.notification_status_txt[data-company-idx='+company_idx+']').textContent = '알림 꺼짐';
                        document.getElementById('notification_status_btn[data-company-idx='+company_idx+']').textContent = '알림켜기';
                    }
                    document.querySelector('.usermenu-toggle').click();
                    closeModal('#msg_alarm');
                }
            })
        }

        {{-- 이미지 팝업 띄우기 --}}
        const openImageModal = imageUrl => {
            document.getElementById('image_content').setAttribute('style', 'background-image: url('+imageUrl+');')
            openModal('#msg_imgviewer');
        }

        {{-- 이미지 버튼 클릭 시 --}}
        const selectImage = () => {
            document.getElementById('image').click();
        }

        {{-- 미리보기 이미지 삭제 --}}
        const deletePreviewImage = () => {
            document.getElementById('image').value = "";
            document.getElementById('preview').removeAttribute('style');
            document.querySelector('.section__bottom').classList.remove('section__bottom--photo', 'section__bottom--photo-text');
            document.getElementById('previewWrap').classList.remove('textfield--photo');
            document.querySelector('[name=chat_message]').classList.remove('message-input--photo', 'message-input--photo-text');
            document.getElementById('selectedImagePreview').classList.add('hidden');
            if (document.getElementById('chat_message').value.length < 1) {
                document.getElementById('submitBtn').setAttribute('disabled', 'true');
            }
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

        {{-- 대화방 리스트 카운트 업데이트 --}}
        const reloadRoomsCount = () => {
            let room_idxes = [];
            const entries = document.querySelectorAll('.aside-list__item').entries();
            for(const entry of entries) {
                room_idxes.push(entry[1].dataset.roomIdx);
            }
            fetch('/message/rooms/count?' + new URLSearchParams({room_idxes: room_idxes}), {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            }).then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Sever Error');
            }).then(json => {
                if (json.result === 'success') {
                    for(const room of json.list) {
                        document.querySelector('.aside-list__item[data-room-idx="'+room.room_idx+'"] .new').classList.remove('hidden');
                        document.querySelector('.aside-list__item[data-room-idx="'+room.room_idx+'"] .new').textContent = room.unread_count;
                    }
                }
            }).catch(error => {
            })
        }

        {{-- 상품 삭제 --}}
        const deleteRoomProduct = elem => {
            location.href='/message';
        }

        {{-- 대화방 키워드 검색하기 --}}
        const searchKeywordRoom = idx => {
            visibleRoom(idx);
        }

        const reportModal = (company_idx, company_type) => {
            const btn = document.getElementById('confirmReportBtn');
            btn.dataset.companyIdx= company_idx;
            btn.dataset.companyType = company_type;
            openModal('#msg_report');
        }

        const writeReportContent = () => {
            if (document.getElementById('content').value) {
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
                    content: document.getElementById('content').value,
                })
            }).then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Sever Error');
            }).then(json => {
                if (json.result === 'success') {
                    alert('신고되었습니다.');
                    closeModal('#msg_report');
                }
            }).catch(error => {
            })
        }

        $(document).on('keypress keyup', '#content', function(e) {
            if ($(this).val().length <= 100) {
                $('#contentCount').text($(this).val().length);
                return true;
            } else {
                return false;
            }
        });

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
        
        

        {{-- 대화방 리스트 카운트 업데이트 --}}
        setInterval(() => reloadRoomsCount(), 10000);

        @if ($product_idx && $room_idx)
            visibleRoom({{ $room_idx }});
        @endif

        const sendMessageHelpCenter = room_idx => {
            fetch('/message/send/message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: JSON.stringify({
                    'company_idx': 1,
                    'company_type': 'A',
                    'templateType' : 'CS',
                    'templateDetailType': 'CS'
                })
            }).then(response => {
                if (response.ok) {
                    return response.json()
                }
                throw new Error('Sever Error');
            }).then(json => {
                if (json.result === 'success') {
                    visibleRoom(room_idx)
                } else {
                    alert(json.message);
                }
            }).catch(error => {
            })
        }
    </script>



@endsection
