@extends('layouts.app')

@section('content')
@include('layouts.header')

<div id="content">
    <section class="sub_section nopadding community_tab mb-10">
        <div class="inner">
            <ul>
                <li><a href="/community">커뮤니티 게시판</a></li>
                <li class="active"><a href="javascript:;">가구인 모임</a></li>
            </ul>
        </div>
    </section>

    <section class="sub_section nopadding">
        <div class="inner">
            <div class="line_common_banner">
                <ul class="swiper-wrapper">
                    <li class="swiper-slide" style="background-color:#475872; ">
                        <a href="javascript:;">
                            <div class="txt_box">
                                <p>[가구,가구인] <br/>가구인의 인터뷰 시리즈를 확인해보세요!</p>
                                <span>매달 5일과 15일에 게시됩니다.</span>
                            </div>
                        </a>
                    </li>
                    <li class="swiper-slide" style="background-color:#6D5C64; ">
                        <a href="javascript:;">
                            <div class="txt_box">
                                <p>[가구,가구인] <br/>가구인의 인터뷰 시리즈를 확인해보세요!</p>
                                <span>매달 5일과 15일에 게시됩니다.</span>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="count_pager"><b>1</b> / 12</div>
                <button class="slide_arrow prev type03"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow_white"></use></svg></button>
                <button class="slide_arrow next type03"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow_white"></use></svg></button>
            </div>
        </div>
    </section>
    
    <section class="sub_section">
        <div class="inner">
            <div class="main_tit mb-8 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>가구인들의 모임</h3>
                </div>
            </div>

            <ul class="group_list">
                <li>
                    <div class="left_box">
                        <div class="img_box">
                            <img src="/img/group_img.png" alt="">
                        </div>
                        <button class="btn btn-gray thin w-full mt-4">회원가입</button>
                    </div>
                    <div class="right_box">
                        <div class="name">
                            <h5>골프모임</h5>
                            <p>골프를 치며 가구 사업 이야기를 나누는 모임</p>
                            <div class="member">
                                <svg class="w-4 h-4"><use xlink:href="/img/icon-defs.svg#member"></use></svg>
                                회원수 : 18
                            </div>
                        </div>
                        <ul class="list">
                            <li><a href="javascript:;">
                                <b>9월 25일 서원힐스 정모</b>
                                <span>2023.09.06</span>
                            </a></li>
                            <li><a href="javascript:;">
                                <b>9월 25일 서원힐스 정모</b>
                                <span>2023.09.06</span>
                            </a></li>
                            <li><a href="javascript:;">
                                <b>9월 25일 서원힐스 정모</b>
                                <span>2023.09.06</span>
                            </a></li>
                        </ul>
                        <a href="./group_detail.php" class="more_btn btn btn-line4">더보기</a>
                    </div>
                </li>
                <li>
                    <div class="left_box">
                        <div class="img_box">
                            <img src="/img/group_img.png" alt="">
                        </div>
                        <button class="btn btn-gray thin w-full mt-4">회원가입</button>
                    </div>
                    <div class="right_box">
                        <div class="name">
                            <h5>골프모임</h5>
                            <p>골프를 치며 가구 사업 이야기를 나누는 모임</p>
                            <div class="member">
                                <svg class="w-4 h-4"><use xlink:href="/img/icon-defs.svg#member"></use></svg>
                                회원수 : 18
                            </div>
                        </div>
                        <ul class="list">
                            <li><a href="javascript:;">
                                <b>9월 25일 서원힐스 정모</b>
                                <span>2023.09.06</span>
                            </a></li>
                            <li><a href="javascript:;">
                                <b>9월 25일 서원힐스 정모</b>
                                <span>2023.09.06</span>
                            </a></li>
                            <li><a href="javascript:;">
                                <b>9월 25일 서원힐스 정모</b>
                                <span>2023.09.06</span>
                            </a></li>
                        </ul>
                        <a href="./group_detail.php" class="more_btn btn btn-line4">더보기</a>
                    </div>
                </li>
                <li>
                    <div class="left_box">
                        <div class="img_box">
                            <img src="/img/group_img.png" alt="">
                        </div>
                        <button class="btn btn-gray thin w-full mt-4">회원가입</button>
                    </div>
                    <div class="right_box">
                        <div class="name">
                            <h5>골프모임</h5>
                            <p>골프를 치며 가구 사업 이야기를 나누는 모임</p>
                            <div class="member">
                                <svg class="w-4 h-4"><use xlink:href="/img/icon-defs.svg#member"></use></svg>
                                회원수 : 18
                            </div>
                        </div>
                        <ul class="list">
                            <li><a href="javascript:;">
                                <b>9월 25일 서원힐스 정모</b>
                                <span>2023.09.06</span>
                            </a></li>
                            <li><a href="javascript:;">
                                <b>9월 25일 서원힐스 정모</b>
                                <span>2023.09.06</span>
                            </a></li>
                            <li><a href="javascript:;">
                                <b>9월 25일 서원힐스 정모</b>
                                <span>2023.09.06</span>
                            </a></li>
                        </ul>
                        <a href="./group_detail.php" class="more_btn btn btn-line4">더보기</a>
                    </div>
                </li>
            </ul>

        </div>
    </section>
</div>

<script>
    // line_common_banner 
    const line_common_banner = new Swiper(".line_common_banner", {
        slidesPerView: 1,
        spaceBetween: 0,
        navigation: {
            nextEl: ".line_common_banner .slide_arrow.next",
            prevEl: ".line_common_banner .slide_arrow.prev",
        },
        pagination: {
            el: ".line_common_banner .count_pager",
            type: "fraction",
        }
    });

</script>

@endsection