@extends('layouts.app')

@section('content')
@include('layouts.header')

<div id="content">
    @include('community.community-tab')
    
    <section class="sub_section">
        <div class="inner">
            <div class="main_tit mb-8 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>가구인들의 모임</h3>
                </div>
            </div>

            <div class="group_detail">
                <div class="left_info">
                    <div class="img_box">
                        <img src="./img/group_img.png" alt="">
                    </div>
                    <div class="name">
                        <h5>골프모임</h5>
                        <p>골프를 치며 가구 사업 이야기를 나누는 모임</p>
                    </div>
                    <button class="btn btn-gray thin w-full mt-4">회원가입</button>

                    <div class="member_list">
                        <div class="top">
                            <div class="member">
                                <svg class="w-4 h-4"><use xlink:href="./img/icon-defs.svg#member"></use></svg>
                                회원수 : 18
                            </div>
                            <button class="member_btn">전체 회원 <span>닫기</span><svg class="w-5 h-5"><use xlink:href="./img/icon-defs.svg#member_arrow"></use></svg></button>
                        </div>
                        <ul class="member_list_box">
                            <li class="head"><a href="javascript:;">
                                <p>
                                    <span class="head">제조 도매</span>
                                    <img src="./img/icon/crown2.png" alt="">
                                    올펀가구
                                </p>
                                <div class="right_link">
                                    <svg class="w-6 h-6"><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg>
                                </div>
                            </a></li>
                            <li><a href="javascript:;">
                                <p>
                                    <span>제조 도매</span>
                                    까마시아
                                </p>
                                <div class="right_link">
                                    <svg class="w-6 h-6"><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg>
                                </div>
                            </a></li>
                            <li><a href="javascript:;">
                                <p>
                                    <span>제조 도매</span>
                                    한샘
                                </p>
                                <div class="right_link">
                                    <svg class="w-6 h-6"><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg>
                                    <button>탈퇴</button>
                                </div>
                            </a></li>
                            <li><a href="javascript:;">
                                <p>
                                    <span>제조 도매</span>
                                    아스테리아
                                </p>
                                <div class="right_link">
                                    <svg class="w-6 h-6"><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg>
                                </div>
                            </a></li> 
                            <li><a href="javascript:;">
                                <p>
                                    <span>제조 도매</span>
                                    에넥스
                                </p>
                                <div class="right_link">
                                    <svg class="w-6 h-6"><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg>
                                </div>
                            </a></li> 
                            <li><a href="javascript:;">
                                <p>
                                    <span>제조 도매</span>
                                    우리향
                                </p>
                                <div class="right_link">
                                    <svg class="w-6 h-6"><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg>
                                </div>
                            </a></li> 
                            <li><a href="javascript:;">
                                <p>
                                    <span>제조 도매</span>
                                    무유
                                </p>
                                <div class="right_link">
                                    <svg class="w-6 h-6"><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg>
                                </div>
                            </a></li> 
                            <li><a href="javascript:;">
                                <p>
                                    <span class="sale">판매/매장</span>
                                    허그앤슬립
                                </p>
                            </a></li>
                            <li><a href="javascript:;">
                                <p>
                                    <span class="sale">판매/매장</span>
                                    알뜨레노띠
                                </p>
                            </a></li>
                            <li><a href="javascript:;">
                                <p>
                                    <span class="sale">판매/매장</span>
                                    핀란드가구
                                </p>
                                <div class="right_link">
                                    <button>탈퇴</button>
                                </div>
                            </a></li>
                        </ul>
                    </div>
                </div>
                <div class="right_box">
                    <div class="community_list">
                        <ul>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="javascript:;">
                                            <div class="category">
                                                <span class="notice">공지</span>
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="javascript:;">
                                            <div class="category">
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                                <div class="img_box"><a href="javascript:;"><img src="./img/community_thumb.png" alt=""></a></div>
                            </li>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="javascript:;">
                                            <div class="category">
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="javascript:;">
                                            <div class="category">
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="txt_box">
                                    <div class="top">
                                        <a href="javascript:;">
                                            <div class="category">
                                                <b>티엔엠</b>
                                            </div>
                                            <div class="title">각종 의자 정리합니다. 제품별 소량 있습니다.</div>
                                        </a>
                                    </div>
                                    <div class="bot">
                                        <div class="info">
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_view"></use></svg>
                                            <span>322</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_up"></use></svg>
                                            <span>1005</span>
                                            <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#commu_comment"></use></svg>
                                            <span>30</span>
                                        </div>
                                        <div class="date">2024.05.07</div>
                                    </div>
                                </div>
                                <div class="img_box"><a href="javascript:;"><img src="./img/community_thumb.png" alt=""></a></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </section>

   
</div>
<script>
    $('.member_list .member_btn').on('click',function(){
        let text = $(this).find('span').text();
        $(this).toggleClass('off')
        if(text == "닫기"){
            $(this).find('span').text("열기");
        }else{
            $(this).find('span').text("닫기");
        }
        $('.member_list .member_list_box').slideToggle();
    })
</script>
@endsection