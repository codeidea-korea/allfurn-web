<header>
    <div class="header_top">
        <div class="inner">
            <h1 class="logo"><a class="flex items-center gap-1" href="/"><img src="/img/logo.svg" alt="">가구 B2B플랫폼</a></h1>

            <div class="product_search relative">
                <div class="search_btn">
                    <svg class="w-11 h-11 ml-2"><use xlink:href="/img/icon-defs.svg#Search"></use></svg> <input name="kw" id="sKeyword" class="bg-transparent w-full h-full search_active" value="" placeholder="상품및 도매 업체를 검색해주세요" autocomplete="one-time-code">
                </div>
                <div class="absolute w-full p-4 bg-white rounded-md z-999 shadow-md search_list hidden">
                    <div class="text-sm flex justify-between py-3">
                        <span class="font-bold">최근 검색어</span>
                        <button class="text-gray-400" onclick="deleteSearchKeyword('all')">전체 삭제</button>
                    </div>
                    <ul class="flex flex-col gap-4 keywordList">
                        <!-- 최근 검색어 //-->
                    </ul>
                    <hr class="mt-4">
                    <div class="text-sm flex justify-between mt-2 py-3">
                        <span class="font-bold">인기 카테고리</span>
                        <span class="text-gray-400">{{date('m.d H:i')}}기준</span>
                    </div>
                    <ul class="flex flex-col gap-4 cateogry_list">
                        <!-- 인기 카테고리 //-->
                    </ul>
                    <hr class="mt-4">
                    <div class="text-sm flex mt-2 py-3 gap-1">
                        <span class="font-bold">추천 키워드</span>
                        <span class="text-gray-400 font-bold">AD</span>
                    </div>
                    <div class="text-sm text-gray-400 hashtag-list">
                        추천 키워드가 없습니다.
                    </div>
                    <div class="mt-4 swiper search_swhiper " id="headerNavBanner">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide rounded-md overflow-hidden">
                                <img src="/img/search_img_d.png" class="w-full h-[110px]" alt="">
                            </div>
                            <div class="swiper-slide rounded-md overflow-hidden">
                                <img src="/img/search_img_d.png" class="w-full h-[110px]" alt="">
                            </div>
                            <div class="swiper-slide rounded-md overflow-hidden">
                                <img src="/img/search_img_d.png" class="w-full h-[110px]" alt="">
                            </div>
                        </div>
                        <div class="search-button-next">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right text-white"><path d="m9 18 6-6-6-6"/></svg>
                        </div>
                        <div class="search-button-prev">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left text-white"><path d="m15 18-6-6 6-6"/></svg>
                        </div>
                        <div class="count_pagination"></div>
                    </div>
                </div>
            </div>


            {{-- <button class="search_btn" onclick="modalOpen('#search-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Search"></use></svg> 상품및 도매 업체를 검색해주세요</button> --}}
            <ul class="right_link flex items-center">
                <li><a href="/message">올톡<!--<span class="talk_num">0</span></a>--></li>
                @if(Auth::user()['type'] == 'W')
                    <li><a href="/mypage/deal">마이올펀</a></li>
                @elseif(Auth::user()['type'] == 'R')
                    <li><a href="/mypage/purchase">마이올펀</a></li>
                @elseif(Auth::user()['type'] == 'S')
                    <li><a href="/mypage/purchase">마이올펀</a></li>
                @else
                    <li><a href="/mypage/purchase">마이올펀</a></li>
                @endif
                <li><a href="/like/product">좋아요</a></li>
                <li><a class="alarm_btn" href="/alarm"><span hidden></span><svg><use xlink:href="/img/icon-defs.svg#Alarm"></use></svg></a></li>
            </ul>
        </div>
    </div>
    <div class="header_banner">
        <div class="inner">
            <div class="header_banner_slide">
                <ul class="swiper-wrapper">
                    <li class="swiper-slide">
                        <a href="javascript:;" class="flex items-center">
                            <svg><use xlink:href="/img/icon-defs.svg#Notice"></use></svg>
                            <svg><use xlink:href="/img/icon-defs.svg#Notice_arrow"></use></svg>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
<div class="header_category">
    <div class="inner relative">
        <ul class="gnb flex items-center">
            <li><button class="flex items-center category_btn"><svg><use xlink:href="/img/icon-defs.svg#Hamicon"></use></svg>카테고리</button></li>
            <li class="{{ Request::segment(1) == '' ? 'active' : '' }}"><a href="/">홈</a></li>
            <li class="{{ (Request::segment(1) == 'product' && Request::segment(2) == 'new') ? 'active' : '' }}"><a href="/product/new">신상품</a></li>
            <li class="{{ Request::segment(1) == 'wholesaler' ? 'active' : '' }}"><a href="/wholesaler">도매업체</a></li>
            <li class="{{ Request::segment(2) == 'thisMonth' ? 'active' : '' }}"><a href="/product/thisMonth"><span>이벤트를 모아보는</span>이달의딜</a></li>
            <li class="{{ Request::segment(1) == 'magazine' ? 'active' : '' }}"><a href="/magazine">뉴스정보</a></li>
            <li class="{{ Request::segment(1) == 'community' ? 'active' : '' }}"><a href="/community">커뮤니티</a></li>
        </ul>
        <div class="category_list"></div>
    </div>
</div>

<script>
// 상단 공지 슬라이드
var header_banner = new Swiper(".header_banner_slide", {
    direction: "vertical",
    spaceBetween: 30,
    speed:700,
    autoplay: {
        delay: 2000,
        disableOnInteraction: true,
    },
});

const getSearchData = () => {
    fetch("/home/getSearchData", {
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        }
    }).then(response => {
        return response.json();
    }).then(json => {
        var keywordPart = "";
        if (json['keywords'].length > 0) {
            for(i=0; i<json['keywords'].length; i++) {
                keywordPart += '' +
                    '<li class="flex items-center justify-between text-sm">' +
                    '   <a href="javascript:;" onClick="clickKeyword(\'' + json['keywords'][i]['keyword'] + '\')" data-idx="' + json['keywords'][i]['keyword'] + '">' + json['keywords'][i]['keyword'] + '</a>' +
                    '   <button class="a11y" onclick="deleteSearchKeyword('+ json['keywords'][i]['idx'] +')">' +
                    '       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-gray-400">' +
                    '           <path d="M18 6 6 18"></path>' +
                    '           <path d="m6 6 12 12"></path></svg>' +
                    '   </button>' +
                    '</li>';
            }
            document.querySelector('.keywordList').innerHTML = keywordPart;
        } else {
            keywordPart += '<li class="flex items-center text-sm">최근 검색한 내역이 없습니다.</div></li>';
            document.querySelector('.keywordList').innerHTML = keywordPart;
        }

        var categoryList = "";
        if (json['category'].length > 0) {
            for(i=0; i<json['category'].length; i++) {
                if (json['category'][i]['parentName'] != null) {
                    categoryList += '' +
                        '<li class="flex items-center text-sm gap-2">' +
                        '   <span class="text-primary font-bold">'+ (i+1) +'</span>' +
                        '   <a href="/product/category?ca=' + json['category'][i]['categoryIdx'] + '&pre=' + json['category'][i]['parentIdx'] + '">' + json['category'][i]['parentName'] + ' > ' + json['category'][i]['categoryName'] + '</a>' +
                        '</li>';
                } else {
                    categoryList += '' +
                        '<li class="flex items-center text-sm gap-2">' +
                        '   <span class="text-primary font-bold">'+ (i+1) +'</span>' +
                        '   <a href="/product/category?ca=' + json['category'][i]['categoryIdx'] + '&pre=' + json['category'][i]['parentIdx'] + '">' + json['category'][i]['categoryName'] + '</a>' +
                        '</li>';
                }
            }

            document.querySelector('.cateogry_list').innerHTML = categoryList;
        }

        var adKeywordPart = "";
        if (json['ad_keyword'].length > 0) {
            for(i=0; i<json['ad_keyword'].length; i++) {
                if ( json["ad_keyword"][i]["web_link"].indexOf('notice') > 0 ) {
                    console.log('json["ad_keyword"][i]["web_link"]', json["ad_keyword"][i]["web_link"]);
                    adKeywordPart += '<div class="hashtag"><a href="/help/notice/">' + json['ad_keyword'][i]['keyword_name'] + '</a></div>';
                } else {
                    adKeywordPart += '<div class="hashtag"><a href="'+json["ad_keyword"][i]["web_link"]+'">' + json['ad_keyword'][i]['keyword_name'] + '</a></div>';
                }
            }
            document.querySelector('.hashtag-list').innerHTML = adKeywordPart;
        } else {
            adKeywordPart += '<div class="row">' +
                '   <div class="row__text search-list--nodata">추천 키워드가 없습니다.</div>' +
                '</div>';
            document.querySelector('.hashtag-list').innerHTML = adKeywordPart;
        }

        var bannerPart = "";
        if (json['banner'].length > 0) {
            for(i=0; i<json['banner'].length; i++) {
                bannerPart += '<div class="swiper-slide rounded-md overflow-hidden">' +
                    '   <a href="';
                switch (json['banner'][i]['web_link_type']) {
                    case 0:
                        bannerPart += json['banner'][i]['web_link'];
                        break;
                    case 1:
                        // bannerPart += '/product/detail/'+json['banner'][i]['web_link'];
                        bannerPart += json['banner'][i]['web_link'];
                        break;
                    case 2:
                        // bannerPart += '/wholesaler/detail/'+json['banner'][i]['web_link'];
                        bannerPart += json['banner'][i]['web_link'];
                        break;
                    case 3:
                        //bannerPart += '/community/detail/'+json['banner'][i]['web_link'];
                        bannerPart += json['banner'][i]['web_link'];
                        break;
                    case 4:
                        bannerPart += '/help/notice/';
                        break;
                }
                bannerPart += '">' +
                    '       <img src="{{preImgUrl()}}' + json['banner'][i]['folder'] + '/' + json['banner'][i]['filename'] + '">' +
                    '   </a>' +
                    '</div>';
            }
            document.querySelector('#headerNavBanner .swiper-wrapper').innerHTML = bannerPart;
        } else {
            bannerPart += '<div class="row">' +
                '   <div class="row__text search-list--nodata">최근 검색한 내역이 없습니다.</div>' +
                '</div>';
            //document.querySelector('.keywordList').innerHTML = bannerPart;
        }
    });
}

$(document).ready(function(f){
    getCategoryList();
    checkAlert();
    //getCategoryBanners();
    getSpeakerLoud();
});

// 키워드 삭제
const deleteSearchKeyword = keywordIdx => {
    fetch("/home/search/" + keywordIdx, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        }
    }).then(response => {
        return response.json();
    }).then(json => {
        if (json.success == true) {
            getSearchData();
        }
    });
}

$('body').on('click', '#search_keyword_delete', function () {
    $('#search_keyword').val('');
    $(this).removeClass('ico__sdelete');
    $('#search_keyword').click();
    $('#search_keyword').focus();
})

// 검색
if ($('#sKeyword').length) {
    document.getElementById('sKeyword').addEventListener('keyup', evt => {
        if( evt.keyCode === 13 ) {
            clickKeyword(evt.currentTarget.value);
        }
    })
}

$(document).on('click', '.search_btn svg', function() {
    console.log($(".search_btn input").val().length);
    if($(".search_btn input").val().length) {
        clickKeyword($(".search_btn input").val());
    }
})

function clickKeyword(keyword) {
    fetch("/home/search/" + keyword, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        }
    }).then(response => {
        return response.json();
    }).then(json => {
        if (json.success == true) {
            location.href = '/product/search?kw=' + keyword;
        }
    });
}

// 최상단 검색창 클릭시 최근, 추천 검색어 노출
$(document).on('click', function(e) {
    // .search_active 클릭 시 .search_list 보이기
    if ($(e.target).closest('.search_active').length) {
        getSearchData();
        $('.search_list').show();
        console.log('show')
    }
    // .search_list 외의 영역 클릭 시 숨기기
    else if (!$(e.target).closest('.search_list').length) {
        $('.search_list').hide();
        console.log('hide')
    }
});

function getCategoryList() {
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url				: '/product/getCategoryListV2',
        data			: {},
        type			: 'POST',
        dataType		: 'json',
        success		: function(result) {
            let htmlText = '<ul>';
            result.forEach(function (e, idx) {
                htmlText += '<li>';
                htmlText += '<a href="/product/category?pre='+e.idx+'">';
                htmlText += '<i><img src="'+ e.imgUrl + '"></i>';
                htmlText += '<span>' + e.name + '</span>';
                htmlText += '</a>';
                htmlText += '<ul class="depth2">';
                e.depth2.forEach(function (e2, idx2) {
                    htmlText += '<li><a href="/product/category?ca=' + e2.idx + '&pre='+e2.parent_idx+'">' + e2.name + '</a></li>';
                })
                htmlText += '</ul>';
                htmlText += '</li>';
            })
            htmlText += '</ul>';
            $('.category_list').html(htmlText);
        }
    });
}

function goCategoryList(category) {
    location.href = "/product/category?pre=" + category;
}

function checkAlert() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method : 'POST',
        url : '/checkAlert',
        success : function(result) {
            if(result.success === true && result.alarm > 0) {
                $(".alarm_btn span").text(result.alarm);
                $(".alarm_btn span").show(result.alarm);
            } else {
                $(".alarm_btn span").hide();
            }
        },
        error : function() {
            $(".alarm_btn span").hide();
        }
    })
}

var search_swhiper = new Swiper(".search_swhiper", {
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
    navigation: {
        nextEl: ".search-button-next",
        prevEl: ".search-button-prev",
    },
    pagination: {
        el: ".count_pagination",
        type: "fraction",
    },
});

function getSpeakerLoud() {
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url				: '/home/getSpeakerLoud',
        data			: {},
        type			: 'POST',
        dataType		: 'json',
        success		: function(result) {
            let htmlText = ''; 
            result.speaker.forEach(function (e, idx) {
                let speaker_link;
                if (e.web_link == "4"){
                    speaker_link = '/help/notice/';
                }else{
                    speaker_link = e.web_link;
                }
                htmlText += `<li class="swiper-slide"><a href="${speaker_link}" class="flex items-center"><svg><use xlink:href="/img/icon-defs.svg#Notice"></use></svg>${e.speaker_text}<svg><use xlink:href="/img/icon-defs.svg#Notice_arrow"></use></svg></a></li>`;
            })
            $('.header_banner_slide .swiper-wrapper').html(htmlText);
            header_banner.update();
        }
    });
}
</script>