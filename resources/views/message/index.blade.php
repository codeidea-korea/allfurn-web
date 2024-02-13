@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
<div id="container" class="container" style="min-height: 100%;">
    <div class="message">
        <div class="inner">
            <div class="message__container">
                <div class="message__aside">
                    <div class="content">
                        <div class="content__head">
                            <h2 class="content__title">올톡</h2>
                            <div class="content__head-button">
                                <a role="button" class="head-button list-insearch-toggle" aria-checked="{{ count($keywords) < 1 ? 'false' : 'true' }}"><div class="ico__search ico__search--gray"><span class="a11y">검색</span></div></a>
                            </div>
                            <div class="list-insearch" aria-hidden="{{ count($keywords) < 1 ? 'true' : 'false' }}">
                                <a role="button" class="head-button list-insearch-close"><div class="ico__arrow--big_left24"><span class="a11y">뒤로 가기</span></div></a>
                                <div class="textfield {{ request()->get('keyword') ? 'textfield--active' : ''}}">
                                    <div class="textfield__icon ico__search"><span class="a11y">검색</span></div>
                                    <input type="text" class="textfield__search" name="keyword" id="keyword" value="{{ request()->get('keyword') }}" placeholder="업체명 및 대화 내용을 검색해주세요." />
                                    <button type="button" class="textfield__icon--delete ico__sdelete">
                                        <span class="a11y">삭제하기</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="aside" style="overflow-y: scroll">
                            
                            @if(count($keywords) < 1)
                                <!-- 검색 기록 없음 -->
                                <div id="recent_keyword" class="list-insearch-history list-insearch-history--empty">
                                    <div class="row">
                                        <div class="title">최근 검색어</div>
                                    </div>
                                    <div class="empty">최근 검색한 내역이 없습니다.</div>
                                </div>
                                <!--// 검색 기록 없음 -->
                            @else
                                <div id="recent_keyword" class="list-insearch-history" style="position: unset; display:none">
                                    <div class="row">
                                        <div class="title">최근 검색어</div>
                                        <div class="head-button"><a role="button" class="head-button" onclick="deleteAllKeyword()">전체 삭제</a></div>
                                    </div>
                                    @foreach($keywords as $keyword)
                                    <div class="row">
                                        <div onclick="searchKeyword('{{ $keyword->keyword }}')" style="cursor:pointer;">{{ $keyword->keyword }}</div>
                                        <a role="button" href="javascript:void(0)" onclick="deleteKeyword(this)" data-idx="{{ $keyword->idx }}">
                                            <div class="ico__delete10"><span class="a11y">삭제하기</span></div>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            @endif
                            
                            <ul class="aside-list" style="margin-bottom: 100px; overflow-y: hidden;">
                                @if(auth()->user()->type === 'N')
                                <li class="notice-box">
                                    <ul>
                                        <li><div class="ico__info"><span class="a11y">정보 아이콘</span></div>
                                            일반 회원은 메세지 전송이 불가합니다. 마이 올펀 > 계정 관리에서 정회원 승격 요청을 진행해주세요.
                                        </li>
                                    </ul>
                                </li>
                                @endif
                                @foreach($rooms as $room)
                                <li class="aside-list__item" data-room-idx="{{ $room->idx }}" onclick="visibleRoom({{ $room->idx }})">
                                    <figure class="profile"><img src="{{ $room->profile_image }}"></figure>
                                    <div class="aside-list__content">
                                        <div class="list__info">
                                            <div class="title">{{ $room->name }}</div>
                                            <div class="timestamp">
                                                <div class="row">
                                                    @if(strpos($room->last_message_time,":") !== false)
                                                        <span>{{ explode(':', $room->last_message_time)[0] }}</span><span>:</span><span>{{ explode(':', $room->last_message_time)[1] }}</span>
                                                    @else
                                                        <span>{{ $room->last_message_time }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list__badge">
                                            <div class="preview">{{ $room->last_message_content }}</div>
                                            <div class="new {{ $room->unread_count < 1 ? 'hidden' : '' }}" data-room-idx="{{ $room->idx }}">{{ $room->unread_count }}</div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="message__section">
                    <div class="content content--empty">
                        <div class="ico__dialogue"><span class="a11y">대화 아이콘</span></div>
                        <div class="empty">대화 목록에서 업체를 선택하여 메세지를 확인하세요.</div>
                    </div>
                </div>
            </div>
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
                document.querySelector('.message__section').outerHTML = html;
                document.querySelector('.chat-box:last-child').focus();
            }).catch(error => {
            })
            
        }


        {{-- 알림 켜기/끄기 모달 띄우기 --}}
        const toggleAlarmModal = (company_type, company_idx) => {
            document.getElementById('confirmTogglePushBtn').dataset.companyType = company_type;
            document.getElementById('confirmTogglePushBtn').dataset.companyIdx = company_idx;
            if (document.querySelector('.alarm').textContent == '알림 켜짐') {
                document.getElementById('push-text').textContent = '해제 하시겠습니까?';
            } else {
                document.getElementById('push-text').textContent = '받으시겠습니까?';
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
                        document.querySelector('.alarm').classList.remove('alarm--off');
                        document.querySelector('.alarm').classList.add('alarm--on');
                        document.querySelector('.alarm').textContent = '알림 켜짐';
                        document.getElementById('alarmBtn').textContent = '알림끄기';
                    } else {
                        document.querySelector('.alarm').classList.remove('alarm--on');
                        document.querySelector('.alarm').classList.add('alarm--off');
                        document.querySelector('.alarm').textContent = '알림 꺼짐';
                        document.getElementById('alarmBtn').textContent = '알림켜기';
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
            const imageFiles = document.getElementById('image').files;
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
                    visibleRoom(roomIdx);
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
