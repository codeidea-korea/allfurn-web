@extends('layouts.app_m')

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
                    <!-- Ajax include -->
                </ul>

                <div class="search_box">
                    <div class="top_search">
                        <a href="javascript:;" class="search_close">
                            <svg><use xlink:href="/img/icon-defs.svg#left_arrow"></use></svg>
                        </a>
                        <div class="input_form">
                            <svg style="cursor: pointer;" onclick="searchKeyword($('#chatting_keyword').val())"><use xlink:href="/img/icon-defs.svg#Search"></use></svg>
                            <input type="text" placeholder="업체명 및 대화 내용을 검색해주세요." id="chatting_keyword" name="keyword" value="{{ request()->get('keyword') }}">
                        </div>
                    </div>
                    <div class="search_result">
                        <div class="record_box">
                            <div class="tit">
                                <p>최근 검색어</p>
                                <button onclick="deleteAllKeyword()">전체 삭제</button>
                            </div>
                            <div class="record_list">
                                <p onclick="">
                                    문
                                    <button data-idx="1" onclick="deleteKeyword()"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button>
                                </p>
                            </div>
                        </div>

                        <ul class="message_list">
                            <li>    
                                <a href="/message.php">
                                    <div class="img_box">
                                        <img src="/img/profile_img.svg" alt="">
                                    </div>
                                    <div class="txt_box">
                                        <h3>
                                            갑부가구산업
                                            <span>11월 15일</span>
                                        </h3>
                                        <div class="desc">상품 문의드립니다</div>
                                    </div>
                                </a>
                            </li>
                            <!-- 검색 결과 없을떄 -->
                            <li class="no_result">
                                검색된 메시지가 없습니다.
                            </li>
                        </ul>
                    </div>
        
                </div>
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

    {{-- 대화방 키워드 검색하기 --}}
    const searchKeywordRoom = idx => {
        window.location.href = '/m/message/room?room_idx=' + (idx);
    }
</script>

    <!-- pusher -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
    Pusher.logToConsole = false;
            
    const pusher = new Pusher('51b26f4641d16394d3fd', {
        cluster: 'ap3'
    });

    var cchannel = pusher.subscribe('user-cmd-{{ user_idx }}');
    cchannel.bind('user-cmd-event-{{ user_idx }}', function(messages) {
        console.log(JSON.stringify(messages));

        const rooms = $('._chatting_rooms > li');
        const newestRoom = rooms.find(r => r.dataset.key == roomIdx);

        if(newestRoom) {
            rooms.prepend(newestRoom);
        } else {
            const tmpChattingRoom = 
                    '<li onclick="searchKeywordRoom('+messages.roomIdx+')" data-key="'+messages.roomIdx+'">'
                    +'    <div class="img_box">'
                    +'        <img src="/img/profile_img.svg" alt="">'
                    +'    </div>'
                    +'    <div class="txt_box">'
                    +'        <h3>'
                    +'            '+messages.roomName
                    +'            <span>'+messages.title+'</span>'
                    +'        </h3>'
                    +'        <div class="desc _room'+messages.roomIdx+'LastMent">'+messages.title+'</div>'
                    +'    </div>'
                    +'</li>';
            $('._chatting_rooms').html(tmpChattingRoom + $('._chatting_rooms').html());
        }
        // 활성화 처리 및 텍스트 변경
        $($('._chatting_rooms > li')[0]).find('li > .txt_box > h3 > span').text(messages.title);
    });
    </script>

    <script>
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
            location.href='/m/message?' + new URLSearchParams({keyword:keyword});
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
    </script>

@endsection

@include('m.message.modal')
