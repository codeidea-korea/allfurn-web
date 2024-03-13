@extends('layouts.app')

@section('content')
@include('layouts.header')

<div id="content">
    <section class="sub_section sub_section_top thismonth_con01">
        <div class="inner">
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
                    <li class="swiper-slide">
                        <a href="javascript:;">
                            <div class="txt_box">
                                <p>[가구,가구인] <br/>가구인의 인터뷰 시리즈를 확인해보세요!</p>
                                <span>매달 5일과 15일에 게시됩니다.</span>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="count_pager" style="width:auto"><b>1</b> / 12</div>
                <button class="slide_arrow prev type03"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow_white"></use></svg></button>
                <button class="slide_arrow next type03"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow_white"></use></svg></button>
            </div>
        </div>
    </section>

    <section class="sub_section sub_section_top news_con02">
        <div class="inner">
            <dl class="news_wrap">
                <dt>
                    <div class="title">
                        <h4>일일 가구 뉴스</h4>
                        <p>매일 올라오는 가구관련 주요 <br/>뉴스를 모아 보여드립니다.</p>
                        <div class="search_box">
                            <input type="text" class="input-form" placeholder="검색해 주세요">
                            <button><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#news_search"></use></svg></button>
                        </div>
                    </div>
                </dt>
                <dd>
                    <ul class="news_list">
                        @foreach($articles as $item)
                            <li><a href="/magazine/daily/detail/{{ $item->idx }}">
                                <div class="tit">{{ $item->title }}</div>
                                <div class="desc">{!! Illuminate\Support\Str::limit(strip_tags($item->content), $limit = 140, $end = '...') !!}</div>
                                <span>{{ Carbon\Carbon::parse($item->register_time)->format('Y.m.d') }}</span>
                            </a></li>
                        @endforeach
                    </ul>
                    <a href="/magazine/daily" class="more_btn">더보기</a>
                </dd>
            </dl>
        </div>
    </section>

    <section class="sub_section news_con03">
        <div class="inner">
            <div class="main_tit mb-2 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>가구 소식</h3>
                </div>
                <div class="flex items-center gap-7">
                    <a class="more_btn flex items-center" href="/magazine/furniture">더보기<svg><use xlink:href="/img/icon-defs.svg#more_icon"></use></svg></a>
                </div>
            </div>
            <div class="sub_desc mb-8">국내외 가구 박람회 소식과 가구 트랜드를 보여드립니다.</div>
            <ul class="furniture_news">
                @foreach ( $furnitureNewsList as $item )
                    <li>
                        {{-- TODO: 가구 소식 리스트 생성 후 이미지 URL 변경 --}}
                        <div class="img_box"><a href="/magazine/furniture/detail/{{ $item->idx }}"><img src="/img/furniture_thumb.png"  alt=""></a></div>
                        <div class="txt_box">
                            <a href="/magazine/furniture/detail/{{ $item->idx }}">
                                <div class="tit">{{ $item->title }}</div>
                                <div class="desc">{!! Illuminate\Support\Str::limit(strip_tags($item->content), $limit = 40, $end = '...') !!}</div>
                                <span>{{ Carbon\Carbon::parse($item->register_time)->format('Y.m.d') }}</span>
                            </a>
                        </div>
                    </li>
                @endforeach 
            </ul>
        </div>
    </section>

    <section class="sub_section sub_section_bot news_con04">
        <div class="inner">
            <div class="main_tit mb-5 flex justify-between items-center">
                <div class="">
                    <h3>매거진</h3>
                    <p class="mt-1">국내외 가구 박람회 소식과 가구 트랜드를 보여드립니다.</p>
                </div>
                <div class="sub_filter">
                    <div class="filter_box">
                        <button onclick="modalOpen('#filter_align-modal')">최신 등록 순</button>
                    </div>
                </div>
            </div>
            <ul class="magazine_list">
                <li>
                    <div class="txt_box">
                        <a href="javascript:;">
                            <div class="top">
                                <span>가구,가구인</span>
                                <b>2023.10.05</b>
                            </div>
                            <div class="tit">설치 물류의 선도기업 (주)바로스설치 물류의 선도기업 (주)바로스설치 물류의 선도기업 (주)바로스</div>
                        </a>
                    </div>
                    <div class="img_box"><a href="javascript:;"><img src="/img/magazine_thumb.png" alt=""></a></div>
                </li>
                <li>
                    <div class="txt_box">
                        <a href="javascript:;">
                            <div class="top">
                                <span>가구,가구인</span>
                                <b>2023.10.05</b>
                            </div>
                            <div class="tit">설치 물류의 선도기업 (주)바로스</div>
                        </a>
                    </div>
                    <div class="img_box"><a href="javascript:;"><img src="/img/magazine_thumb.png" alt=""></a></div>
                </li>
                <li>
                    <div class="txt_box">
                        <a href="javascript:;">
                            <div class="top">
                                <span>가구,가구인</span>
                                <b>2023.10.05</b>
                            </div>
                            <div class="tit">설치 물류의 선도기업 (주)바로스설치 물류의 선도기업 (주)바로스설치 물류의 선도기업 (주)바로스</div>
                        </a>
                    </div>
                    <div class="img_box"><a href="javascript:;"><img src="/img/magazine_thumb.png" alt=""></a></div>
                </li>
                <li>
                    <div class="txt_box">
                        <a href="javascript:;">
                            <div class="top">
                                <span>가구,가구인</span>
                                <b>2023.10.05</b>
                            </div>
                            <div class="tit">설치 물류의 선도기업 (주)바로스</div>
                        </a>
                    </div>
                    <div class="img_box"><a href="javascript:;"><img src="/img/magazine_thumb.png" alt=""></a></div>
                </li>
                <li>
                    <div class="txt_box">
                        <a href="javascript:;">
                            <div class="top">
                                <span>가구,가구인</span>
                                <b>2023.10.05</b>
                            </div>
                            <div class="tit">설치 물류의 선도기업 (주)바로스설치 물류의 선도기업 (주)바로스설치 물류의 선도기업 (주)바로스</div>
                        </a>
                    </div>
                    <div class="img_box"><a href="javascript:;"><img src="/img/magazine_thumb.png" alt=""></a></div>
                </li>
                <li>
                    <div class="txt_box">
                        <a href="javascript:;">
                            <div class="top">
                                <span>가구,가구인</span>
                                <b>2023.10.05</b>
                            </div>
                            <div class="tit">설치 물류의 선도기업 (주)바로스</div>
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
        navigation: {
            nextEl: ".line_common_banner .slide_arrow.next",
            prevEl: ".line_common_banner .slide_arrow.prev",
        },
        pagination: {
            el: ".line_common_banner .count_pager",
            type: "fraction",
        }
    });



    $('.search_box input').keydown(function (event) {
        if (event.which === 13 && validateKeyword($(this).val())) { 
            window.location.href = "/magazine/daily?keyword=" +  $(this).val();
        }
    });

    $(".search_box button").on('click', function() {

        if(validateKeyword($(".search_box input").val())) {
            window.location.href = "/magazine/daily?keyword=" +  $(".search_box input").val();
        }
    });

    function validateKeyword(data) {
        return (/^[가-힣a-zA-Z0-9\s]*$/).test(data);
    }

   
</script>
@endsection