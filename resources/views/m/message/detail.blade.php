@extends('layouts.app_m')

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
                        <svg><use xlink:href="/img/icon-defs.svg#Search"></use></svg>
                        <input type="text" placeholder="대화 내용을 검색해주세요.">
                    </div>
                </div>
                <div class="title">
                    <a href="/m/message/">
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
                        <div style="z-index:99">\
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
                    @else
                    <div class="add">경기도 고양시 일산동구 산두로213번길 18 (정발산동)</div>
                    <p>031-813-5588</p>
                    @endif
                    <a href="/m/wholesaler/detail/{{ $company->idx }}">업체 자세히 보기 <img src="/img/icon/filter_arrow.svg" alt=""></a>
                </div>
            </div>
            <div class="chatting_list" style="overflow-y: scroll;">

                @if($chattingCount > 30)
                <div class="flex justify-center mt-2" id="btnGetChatMore">
                    <button class="border rounded-full bg-white px-2 h-[32px] flex items-center gap-1" onclick="getChatting({{ $room_idx }})">
                        더보기
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-up"><path d="m18 15-6-6-6 6"/></svg>
                    </button>
                </div>
                @endif
                {!! $chattingHtml !!}



                @php
                    /*
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
                            <a href="/my_ws_sales_status_detail.php" class="block w-full mt-2 py-3 border rounded-md text-primary text-center hover:bg-stone-50">주문 현황 보러가기</a>
                        </div>
                    </div>
                    <div class="timestamp">18:38</div>
                </div>
                */ 
                endphp
            </div>
            <div class="message_form">
                <div class="file_box shrink-0">
                    <input type="file" id="img_file">
                    <label for="img_file">
                        <img class="mx-auto" src="/img/member/img_icon.svg" alt="">
                    </label>
                </div>
                <input type="text" class="input-form" id="chat_message" placeholder="메시지를 입력해주세요." onkeyup="keyupMessage()">
                <button class="btn btn-primary shrink-0" id="submitBtn" data-room-idx="{{ $room_idx }}" onClick="clickMessage()">전송</button>
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

        visibleRoom({{ $room_idx }});
    </script>

@endsection

@include('m.message.modal')
