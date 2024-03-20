@extends('layouts.app_m')

@section('content')
@include('layouts.header_m')

<div id="content">
    <section class="sub_section sub_section_top thismonth_con01">
        <div class="line_common_banner">
            <ul class="swiper-wrapper">
                <li class="swiper-slide" style="background-image:url('/img/banner_img_01.png')">
                    <a href="javascript:;">
                        <div class="txt_box type02">
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
        </div>
    </section>

    <section class="sub_section sub_section_top news_con02">
        <div class="inner">
            <div class="title">
                <h4>일일 가구 뉴스</h4>
                <p>매일 올라오는 가구관련 주요 뉴스를 모아 보여드립니다.</p>
                <div class="search_box">
                    <input type="text" class="input-form" placeholder="글 제목이나 작성자를 검색해주세요">
                    <button><svg class="w-11 h-11"><use xlink:href="/img/m/icon-defs.svg#news_search"></use></svg></button>
                </div>
            </div>
            <ul class="news_list">
                <li><a href="javascript:;">
                    <div class="tit">소비자 유치 총력…한샘‧현대리바트, AS 경쟁 가속</div>
                    <div class="desc">6일 관련 업계에 따르면, 한샘과 현대리바트 AS 서비스 </div>
                    <span>2023.10.05</span>
                </a></li>
                <li><a href="javascript:;">
                    <div class="tit">소비자 유치 총력…한샘‧현대리바트, AS 경쟁 가속</div>
                    <div class="desc">6일 관련 업계에 따르면, 한샘과 현대리바트 AS 서비스 </div>
                    <span>2023.10.05</span>
                </a></li>
                <li><a href="javascript:;">
                    <div class="tit">소비자 유치 총력…한샘‧현대리바트, AS 경쟁 가속</div>
                    <div class="desc">6일 관련 업계에 따르면, 한샘과 현대리바트 AS 서비스 </div>
                    <span>2023.10.05</span>
                </a></li>
                <li><a href="javascript:;">
                    <div class="tit">소비자 유치 총력…한샘‧현대리바트, AS 경쟁 가속</div>
                    <div class="desc">6일 관련 업계에 따르면, 한샘과 현대리바트 AS 서비스 </div>
                    <span>2023.10.05</span>
                </a></li>
                <li><a href="javascript:;">
                    <div class="tit">소비자 유치 총력…한샘‧현대리바트, AS 경쟁 가속</div>
                    <div class="desc">6일 관련 업계에 따르면, 한샘과 현대리바트 AS 서비스 </div>
                    <span>2023.10.05</span>
                </a></li>
            </ul>
            <a href="/daily_news.php" class="btn btn-line4 mt-7">더보기</a>
            
        </div>
    </section>

    <section class="sub_section news_con03">
        <div class="inner">
            <div class="main_tit mb-2 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>가구 소식</h3>
                </div>
            </div>
            <div class="sub_desc mb-5">국내외 가구 박람회 소식과 가구 트랜드를 보여드립니다.</div>
            <ul class="furniture_news">
                <li>
                    <div class="img_box"><a href="javascrsipt:;"><img src="/img/furniture_thumb.png" alt=""></a></div>
                    <div class="txt_box">
                        <a href="javascript:;">
                            <div class="tit">한국국제가구 및 인테리어 산업대전</div>
                            <div class="desc">올해 가구 사업자에게 주는 혜댁</div>
                            <span>2023.10.05</span>
                        </a>
                    </div>
                </li>
            </ul>
            <a href="./furniture_news.php" class="btn btn-line4 mt-7">더보기</a>
        </div>
    </section>

    <section class="sub_section sub_section_bot news_con04">
        <div class="inner">
            <div class="main_tit mb-5">
                <div class="">
                    <h3>매거진</h3>
                    <p class="mt-1">국내외 가구 박람회 소식과 가구 트랜드를 보여드립니다.</p>
                </div>
            </div>
            <div class="sub_filter">
                <div class="filter_box">
                    <button onclick="modalOpen('#filter_align-modal')">최신 등록 순</button>
                </div>
            </div>
            <ul class="magazine_list">
                <li>
                    <div class="txt_box">
                        <a href="javascript:;">
                            <div class="tit">설치 물류의 선도기업 (주)바로스설치 물류의 선도기업 (주)바로스설치 물류의 선도기업 (주)바로스</div>
                            <b>2023.10.05</b>
                        </a>
                    </div>
                    <div class="img_box"><a href="javascript:;"><img src="/img/magazine_thumb.png" alt=""></a></div>
                </li>
                <li>
                    <div class="txt_box">
                        <a href="javascript:;">
                            <div class="tit">설치 물류의 선도기업 (주)바로스</div>
                            <b>2023.10.05</b>
                        </a>
                    </div>
                    <div class="img_box"><a href="javascript:;"><img src="/img/magazine_thumb.png" alt=""></a></div>
                </li>
                <li>
                    <div class="txt_box">
                    <a href="javascript:;">
                            <div class="tit">설치 물류의 선도기업 (주)바로스</div>
                            <b>2023.10.05</b>
                        </a>
                    </div>
                    <div class="img_box"><a href="javascript:;"><img src="/img/magazine_thumb.png" alt=""></a></div>
                </li>
                <li>
                    <div class="txt_box">
                        <a href="javascript:;">
                            <div class="tit">설치 물류의 선도기업 (주)바로스</div>
                            <b>2023.10.05</b>
                        </a>
                    </div>
                    <div class="img_box"><a href="javascript:;"><img src="/img/magazine_thumb.png" alt=""></a></div>
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
        pagination: {
            el: ".line_common_banner .count_pager",
            type: "fraction",
        }
    });

   
</script>
@endsection