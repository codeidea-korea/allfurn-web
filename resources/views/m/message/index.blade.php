@extends('layouts.app_m')

@section('content')
@include('layouts.header_m')

<div id="content">
    <section class="message_con01">
        <div class="inner">
            <div class="list_box">
                <div class="title">
                    <h3>올톡</h3>
                    <button class="search_btn"><svg><use xlink:href="./img/icon-defs.svg#Search_black"></use></svg></button>
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

                <div class="search_box">
                    <div class="top_search">
                        <a href="javascript:;" class="search_close">
                            <svg><use xlink:href="./img/icon-defs.svg#left_arrow"></use></svg>
                        </a>
                        <div class="input_form">
                            <svg style="cursor: pointer;" onclick="searchKeyword($('#chatting_keyword').val())"><use xlink:href="./img/icon-defs.svg#Search"></use></svg>
                            <input type="text" placeholder="업체명 및 대화 내용을 검색해주세요." id="chatting_keyword" name="keyword" value="{{ request()->get('keyword') }}">
                        </div>
                    </div>
                    <div class="search_result">
                        <div class="record_box">
                            <div class="tit">
                                <p>최근 검색어</p>
                                <button>전체 삭제</button>
                            </div>
                            <div class="record_list">
                                <p>
                                    문
                                    <button><svg><use xlink:href="./img/icon-defs.svg#x"></use></svg></button>
                                </p>
                                <p>
                                    최근검색어
                                    <button><svg><use xlink:href="./img/icon-defs.svg#x"></use></svg></button>
                                </p>
                                <p>
                                    최근검색어2
                                    <button><svg><use xlink:href="./img/icon-defs.svg#x"></use></svg></button>
                                </p>
                                <p>
                                    최근검색어3
                                    <button><svg><use xlink:href="./img/icon-defs.svg#x"></use></svg></button>
                                </p>
                                <p>
                                    최근검색어4
                                    <button><svg><use xlink:href="./img/icon-defs.svg#x"></use></svg></button>
                                </p>
                                <p>
                                    최근검색어5
                                    <button><svg><use xlink:href="./img/icon-defs.svg#x"></use></svg></button>
                                </p>
                            </div>
                        </div>

                        <ul class="message_list">
                            <li>    
                                <a href="./message.php">
                                    <div class="img_box">
                                        <img src="./img/profile_img.svg" alt="">
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
                            <li>
                                <a href="./message.php">
                                    <div class="img_box">
                                        <img src="./img/profile_img.svg" alt="">
                                    </div>
                                    <div class="txt_box">
                                        <h3>
                                            아테네가구
                                            <span>02월 06일</span>
                                        </h3>
                                        <div class="desc">문의내용을 입력해주세요.</div>
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
   $('.search_btn').on('click',function(){
        $('.search_box').addClass('active')
   })
   $('.search_close').on('click',function(){
        $('.search_box').removeClass('active')
   })

</script>

@endsection

@include('m.message.modal')
