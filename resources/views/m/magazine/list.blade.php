@extends('layouts.app_m')
@php
    $only_quick = '';
    $header_depth = 'news';
    $top_title = '';
    $header_banner = '';
@endphp
@section('content')
@include('layouts.header_m')

<div id="content">
    <section class="sub_section sub_section_top thismonth_con01">
        <div class="line_common_banner">
            <ul class="swiper-wrapper">
                @foreach($banners as $banner)
                    @if($banner->banner_type === 'img')
                        <li class="swiper-slide" style="background-image:url({{ $banner->appBigImgUrl }})"
                            onclick="location.href='{{ strpos($banner->web_link, 'help/notice') !== false ? '/help/notice/' : $banner->web_link }}'"></li>
                    @else
                        <li class="swiper-slide" style="background-color:{{$banner->bg_color}};">
                            <a href="{{ strpos($banner->web_link, 'help/notice') !== false ? '/help/notice/' : $banner->web_link }}">
                                <div class="txt_box type02" style="color:{{ $banner->font_color }};">
                                    <p>{{ $banner->subtext1 }}<br/>{{ $banner->subtext2 }}</p>
                                    <span>{{ $banner->content }}</span>
                                </div>
                            </a>
                        </li>
                    @endif
                @endforeach
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
                @foreach($articles as $item)
                    <li><a href="{{ $item->content_type == 1 ? '/magazine/daily/detail/'.$item->idx : $item->blank_link  }}">
                        @if (now()->diffInHours($item->register_time) < 24)
                            <span class="new">NEW</span>
                        @endif
                        <div class="tit">{{ $item->title }}</div>
                        <div class="desc">{!! Illuminate\Support\Str::limit(html_entity_decode(strip_tags($item->content)), $limit = 140, $end = '...') !!}</div>
                        <span>{{ Carbon\Carbon::parse($item->register_time)->format('Y.m.d') }}</span>
                    </a></li>
                @endforeach
            </ul>
            <a href="/magazine/daily" class="btn btn-line4 mt-7">더보기</a>
            
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
                @foreach ( $furnitureNewsList as $item )
                <li>
                    <div class="img_box">
                        <a href="/magazine/furniture/detail/{{ $item->idx }}">
                            @if($item->content)
                                    @php
                                        $tmp = '';
                                        $pos = strpos($item->content, '<img src=', 0);
                                        
                                        if ( $pos !== false ) {
                                            
                                            $pos_from = strpos($item->content, 'https', $pos);
                                            $pos_to = strpos($item->content, '>', $pos_from);
                                            $sub = substr($item->content, $pos_from, $pos_to);
                                            $image_end = strpos($sub, '.jpg');
                                            
                                            if ($image_end) {
                                                $tmp = substr($sub, 0, $image_end + 4);
                                            } else {
                                                $image_end = strpos($sub, '.png');
                                                $tmp = substr($sub, 0, $image_end + 4);
                                            }
                                            
                                        }
                                    @endphp
                                    <img src="{{ $tmp ? $tmp : '' }}" alt="">
                                @endif
                        </a>
                    </div>
                    <div class="txt_box">
                        <a href="/magazine/furniture/detail/{{ $item->idx }}">
                            <div class="tit">{{ $item->title }}</div>
                            <div class="desc">{!! Illuminate\Support\Str::limit(html_entity_decode(strip_tags($item->content)), $limit = 40, $end = '...') !!}</div>
                            <span>{{ Carbon\Carbon::parse($item->register_time)->format('Y.m.d') }}</span>
                        </a>
                    </div>
                </li>
                @endforeach
            </ul>
            <a href="/magazine/furniture" class="btn btn-line4 mt-7">더보기</a>
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
                    <button onclick="modalOpen('#magazine_filter_align-modal')">전체</button>
                </div>
            </div>
            <ul class="magazine_list">
                {{-- @foreach ($list as $row)
                    <li>
                        <div class="txt_box">
                            <a href="/magazine/detail/{{$row->idx}}">
                                <div class="tit">{{$row->title}}</div>
                                <b>{{ Carbon\Carbon::parse($row->register_time)->format('Y.m.d') }}</b>
                            </a>
                        </div>
                        <div class="img_box"><a href="/magazine/detail/{{$row->idx}}"><img src="{{$row->image_url}}" alt=""></a></div>
                    </li>
                @endforeach --}}
            </ul>
        </div>
    </section>
    <div class="modal" id="magazine_filter_align-modal">
        <div class="modal_bg" onclick="modalClose('#magazine_filter_align-modal')"></div>
        <div class="modal_inner modal-md">
            <button class="close_btn" onclick="modalClose('#magazine_filter_align-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body filter_body">
                <h4>정렬 선택</h4>
                <ul class="filter_list">
                    <li>
                        <input type="radio" class="radio-form" name="mfa" id="all" value="all" checked>
                        <label for="all">전체</label>
                    </li>
                    @foreach ( $magazineCategoryList as $category)
                        <li>
                            <input type="radio" class="radio-form" name="mfa" id="{{ $category->idx }}" value="{{ $category->category_name }}">
                            <label for="{{ $category->idx }}">{{ $category->category_name }}</label>
                        </li>
                    @endforeach
                </ul>
                <div class="btn_bot">
                    <button class="btn btn-primary full btnMagazineAlign">선택 완료</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
   

    // line_common_banner 
    const line_common_banner = new Swiper(".line_common_banner", {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 0,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".line_common_banner .count_pager",
            type: "fraction",
        }
    });

    $('.search_box input').keydown(function (event) {
        if(event.key === "Enter") {
            window.location.href = "/magazine/daily?keyword=" +  $(this).val();
        }
    });

    $(".search_box button").on('click', function() {
        window.location.href = "/magazine/daily?keyword=" +  $(".search_box input").val();
    });

    /* ----------------------------- */
    $(document).ready(function(){
        setTimeout(() => {
            loadMagazineList();
        }, 50);
    })

    // 매거진 스크롤 로딩
    window.addEventListener('scroll', function() {
        if ((window.pageYOffset || document.documentElement.scrollTop) + window.innerHeight + 20 >= document.documentElement.scrollHeight && !isLoading && !isLastPage ) {
            loadMagazineList();
        }
    });

    $(document).on('click', '#magazine_filter_align-modal .btn-primary', function() { 
        loadMagazineList(true, $(this));
    });

    let isLoading = false;
    let isLastPage = false;
    let currentPage = 0;
    function loadMagazineList(needEmpty, target) {
        if(isLoading) return;
        if(!needEmpty && isLastPage) return;

        isLoading = true;
        if(needEmpty) currentPage = 0;

        $.ajax({
            url: '/magazine/list',
            method: 'GET',
            data: { 
                'offset': ++currentPage,
                'category': $("#magazine_filter_align-modal .radio-form:checked").val(),
            },
            beforeSend : function() {
                if(target) {
                    target.prop("disabled", true);
                }
            },
            success: function(result) {
                displayMagazineList(result.list, needEmpty);

                if(target) {
                    target.prop("disabled", false);
                    modalClose('#' + target.parents('[id^="magazine_filter"]').attr('id'));
                }

                isLastPage = currentPage === result.last_page;
            },
            complete : function () {
                displaySelectedCategories();
                isLoading = false;
            }
        })
    }

    function displayMagazineList(data, needEmpty) {
        if(needEmpty) $(".magazine_list").empty();
        
        data.forEach(function(magazine) {
            $(".magazine_list").append(
            '<li>'+
            '   <div class="txt_box">'+
            '       <a href="/magazine/detail/' + magazine.idx + '">'+
            '           <span>[' + magazine.category_list + ']</span>'+
            '           <div class="tit">' + magazine.title + '</div>'+
            '           <b>' + formatDate(magazine.register_time) + '</b>'+
            '       </a>'+
            '   </div>'+
            '   <div class="img_box"><a href="/magazine/detail/' + magazine.idx +'"><img src="' + magazine.image_url + '" alt=""></a></div>'+
            '</li>'
            );
        })
    }

    function displaySelectedCategories() {
        if($("#magazine_filter_align-modal .radio-form:checked").val() != 'all') {
            $(".sub_filter .filter_box button").text($("#magazine_filter_align-modal .radio-form:checked").val());
        }
    }

    function formatDate(date) {
        const dateObject = new Date(date);

        const year = dateObject.getFullYear().toString().substr(-2);
        const month = ("0" + (dateObject.getMonth() + 1)).slice(-2);
        const day = ("0" + dateObject.getDate()).slice(-2);

        return year + "." + month + "." + day;
    }

   
</script>
@endsection