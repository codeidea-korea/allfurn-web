<script>
    var hasNotDefinedUserType = {{ Auth::user()['is_undefined_type'] }} === 1;
    function gotoLink(url) {
        if(hasNotDefinedUserType) {
//            alert('회원 구분을 선택해주세요.');
//            location.href = '/mypage/company-account';
//            return;
        }
        location.href = url;
    }
    function callBackDefindedUserType(fn) {
        if(hasNotDefinedUserType) {
//            alert('회원 구분을 선택해주세요.');
//            location.href = '/mypage/company-account';
//            return;
        }
        fn();
    }
    const gradeNames = [
        { "grade": 'S', "name": '일반' },
        { "grade": 'N', "name": '기타가구 관련업종' },
        { "grade": 'R', "name": '판매/매장' },
        { "grade": 'W', "name": '제조/도매' },
    ];
    // 특정 권한을 강제하는 화면 이동 처리
    function requiredUserGrade(grades) {
        const userGrade = '{{Auth::user()-> type}}';
        if(grades.indexOf(userGrade) < 0) {
            const tmpMsg = grades.map(g => gradeNames.filter(n => n.grade === g)[0].name).join(', ')
            // alert('해당 화면은 ' + tmpMsg + ' 회원만 이용 가능합니다.');
            modalOpen('#pop_info_1-modal');

            // 권한별 오픈 로직 제거되고 라디오로 선택되게 되면서 해당 로직은 간단하게 병합됨
            /*
            if(grades.indexOf('R') > -1) {
                $('#pop_info_1-open-modal').off().on('click', convertCompany.openPopupByRetail);
            } else if(grades.indexOf('W') > -1) {
                $('#pop_info_1-open-modal').off().on('click', convertCompany.openPopupByWholesaler);
            }
            */
            $('#pop_info_1-open-modal').off().on('click', convertCompany.openPopupByGrageUpRequest);
            if(userGrade === 'S'){
//                localStorage.setItem('loadRequiredUserGrade', '["' + grades.join('","') + '"]');
//                location.href = '/mypage/normal-account';
            }
        }
    }
</script>
<header class="{{ $only_quick=='yes'?'hidden':'' }}">
    <div class="header_top {{ ($header_depth=='mypage' || $header_depth=='prodlist') ? 'hidden' : '' }}">
        <div class="inner">
            <h1 class="logo"><a class="flex items-center gap-1" href="/"><img src="/img/logo.svg" alt=""></a></h1>
            <button class="search_btn" onclick="getSearchModal();"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Search"></use></svg> 검색어를 입력하세요</button>
            <ul class="right_link flex items-center">
                <li><a class="alarm_btn" href="/alarm"><span style="display: none;">1</span><svg><use xlink:href="/img/icon-defs.svg#Alarm"></use></svg></a></li>
            </ul>
        </div>
    </div>
    <div class="header_top sub_header {{ $header_depth=='mypage' ? '' :'hidden' }}">
        <div class="inner">
            <a href="javascript:window.history.back();"><svg class="w-6 h-6 rotate-180"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></a>
            <h3 class="title">{{ $top_title}}</h3>
            <ul class="right_link flex items-center">
                <li><a href="javascript:;" onclick="modalOpen('#search-modal')"><svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#Search_black"></use></svg></a></li>
                <li><a class="alarm_btn" href="/alarm"><span style="display: none;">1</span><svg><use xlink:href="/img/icon-defs.svg#Alarm"></use></svg></a></li>
            </ul>
        </div>
    </div>
    <div class="header_top sub_header {{ $header_depth =='prodlist' ? '' : 'hidden' }}">
        <div class="inner">
            <div class="flex items-center">
                <a href="javascript:window.history.back();"><svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#left_arrow"></use></svg></a>
                <h3 class="title">{{ $top_title }}</h3>
            </div>
            <ul class="right_link flex items-center">
                <li><a href="javascript:;" onclick="modalOpen('#search-modal')"><svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#Search_black"></use></svg></a></li>
                <li><a class="alarm_btn" href="/alarm"><span style="display: none;">1</span><svg><use xlink:href="/img/icon-defs.svg#Alarm"></use></svg></a></li>
            </ul>
        </div>
    </div>
    <div class="header_banner {{ $header_banner }} {{ ($header_depth=='category'|| $header_depth=='prodlist') ? 'hidden' : '' }}">
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
<div class="header_category {{ ($header_depth=='like' || $header_depth=='mypage' || $header_depth=='category' || $header_depth=='prodlist') ? 'hidden' : '' }} {{ $only_quick == 'yes' ? 'hidden':'' }}">
    <div class="relative">
        <ul class="gnb flex items-center">
            {{-- <li><button class="flex items-center category_btn"><svg><use xlink:href="/img/icon-defs.svg#Hamicon"></use></svg>카테고리</button></li> --}}
            <li class="{{ $header_depth=='home' ? 'active':'' }}"><a href="/">홈</a></li>
            <li class="{{ $header_depth=='new_arrival' ? 'active':'' }}"><a href="/product/new">신상품</a></li>
            <li class="{{ $header_depth=='wholesaler' ? 'active':'' }}"><a href="/wholesaler">도매업체</a></li>
            <li class="{{ $header_depth=='thismonth' ? 'active':'' }}"><a href="/product/thisMonth"><span>이벤트를 모아보는</span>이달의딜</a></li>
            <li class="{{ $header_depth=='news' ? 'active':'' }}"><a href="/magazine">뉴스정보</a></li>
            <li class="{{ $header_depth=='community' ? 'active':'' }}"><a href="/community">커뮤니티</a></li>
        </ul>
    </div>
</div>


<div class="quick_menu">
    <ul class="menu">
        <li class="{{$header_depth=='category'?'active':'' }}"><a href="/home/category"><svg><use xlink:href="/img/m/icon-defs.svg#quick_category"></use></svg><span>카테고리</span></a></li>
        <li class="{{$header_depth=='like'?'active':'' }}"><a href="/like/product"><svg><use xlink:href="/img/m/icon-defs.svg#quick_like"></use></svg><span>좋아요</span></a></li>
        <li class="{{($header_depth!=='like'&&$header_depth!=='talk'&&$header_depth!=='mypage'&&$header_depth!=='category') ?'active':'' }}"><a href="/"><svg><use xlink:href="/img/m/icon-defs.svg#quick_home"></use></svg><span>홈</span></a></li>
        <!-- 안읽은 메세지 수 숫자로 표기 -->
        <li class="{{$header_depth=='talk'?'active':'' }}"><a href="javascript:gotoLink('/message');"><svg><use xlink:href="/img/m/icon-defs.svg#quick_talk"></use></svg><span>올톡</span>@if (unCheckedAllTalkCount() > 0) <b class="_totChatMessageCount">{{ unCheckedAllTalkCount() }}</b> @endif</a></li>
        <!-- 확인하지 않은 내용 있을 때 붉은점 noread 클래스 추가 -->
        <li class="{{$header_depth=='mypage'?'active':'' }} {{ unCheckedMyAllFurn() ? 'noread' : '' }}"><a href="javascript:gotoLink('/mypage');"><svg><use xlink:href="/img/m/icon-defs.svg#quick_my"></use></svg><span>마이올펀</span></a></li>
    </ul>
</div>

<div class="right_quick_box">
    <div id="prod_regist_btn" class="{{($header_depth=='mypage' || $header_depth=='community' || $header_depth=='talk'|| $header_depth=='thismonth' )?'hidden':'' }}">
        <a href="{{ Auth::user()['type'] === 'W' ? "javascript:gotoLink('/product/registration');" : "javascript:requiredUserGrade(['W']);" }}">상품<br/>등록</a>
    </div>
    @if(request()->is(['', '/', 'mypage', 'mypage/deal', 'wholesaler/detail/'.Auth::user()['company_idx'] ]))
        <div class="right_quick_btn" style="background-color:#000; color:#fff; ">
            <a href="{{ Auth::user()['type'] === 'W' ? "javascript:shareCatalog(".Auth::user()['company_idx'].",4);" : "javascript:requiredUserGrade(['W']);" }}">카탈로그<br>보내기</a>
        </div>
        @if(isset(Auth::user()['type']) && in_array(Auth::user()['type'], ['W']))
            @include('layouts.includes.send-catalog')
        @endif
    @endif
    
@if(request()->is(['wholesaler/detail/*' ]))
    <div class="right_quick_btn" style=" background-color:#000; color:#fff; ">
        <a href="javascript:shareCatalog({{$data['info']->idx}},6);">카탈로그<br>받기</a>
    </div>
    @include('layouts.includes.send-catalog')
@endif

@if(Route::currentRouteName() != '')
    <div id="move_back_btn" class="{{($header_depth=='mypage' || $header_depth=='community' || $header_depth=='talk'|| $header_depth=='thismonth' )?'hidden':'' }}">
        <a href="javascript:history.back()"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg></a>
    </div>
@endif
</div>

<!-- 검색 -->
<div class="modal" id="search_modal">
    <div class="modal_bg" onclick="modalClose('#search_modal')"></div>
    <div class="modal_inner inner_full">

        <div class="modal_title">
            <button class="x_btn" onclick="modalClose('#search_modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#x"></use></svg></button>
            <h3>검색</h3>
        </div>
        <div class="px-4">

            <div class="modal_search w-full bg-white search_list">
                <div class="search_btn">
                    <svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Search"></use></svg>
                    <input type="text" name="kw" id="sKeyword" class="w-full text-base bg-transparent text-stone-800" placeholder="검색어를 입력하세요" autocomplete="one-time-code" value="{{ (array_key_exists('kw', $_GET) ? $_GET['kw'] : '' ) }}">
                </div>
                <div class="text-sm flex justify-between py-3 mt-3">
                    <span class="font-bold">최근 검색어</span>
                    <button class="text-gray-400" onclick="deleteSearchKeyword('all')">전체 삭제</button>
                </div>
                <ul class="flex flex-col gap-4 keywordList">
                   <!-- 최근 검색어 영역 //-->
                </ul>
                <hr class="mt-4">
                <div class="text-sm flex justify-between mt-2 py-3">
                    <span class="font-bold">인기 카테고리</span>
                    <span class="text-gray-400">{{date('m.d H:i')}}기준</span>
                </div>
                <ul class="flex flex-col gap-4 cateogry_list">
                    <!-- 인기 카테고리 영역 //-->
                </ul>
                <hr class="mt-4">
                <div class="text-sm flex mt-2 py-3 gap-1">
                    <span class="font-bold">추천 키워드</span>
                    <span class="text-gray-400 font-bold">AD</span>
                </div>
                <div class="text-sm text-gray-400 hashtag-list">
                    <!-- 키워드 있을 시 -->
                    <div class="flex flex-wrap items-center gap-1">
                        <a href="" class="flex items-center px-2 h-[28px] text-stone-800 border border-stone-400 rounded-full">
                            #모션데스크
                        </a>
                        <a href="" class="flex items-center px-2 h-[28px] text-stone-800 border border-stone-400 rounded-full">
                            #이태리침대
                        </a>
                        <a href="" class="flex items-center px-2 h-[28px] text-stone-800 border border-stone-400 rounded-full">
                            #모션데스크
                        </a>
                    </div>
                    <!-- 키워드 없을 시 -->
                    추천 키워드가 없습니다.
                </div>
                <div class="mt-4 swiper search_swhiper" id="headerNavBanner">
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
    </div>
</div>

<script type="text/javascript">

    // 상단 공지 슬라이드
    var header_banner = new Swiper(".header_banner_slide", {
        direction: "vertical",
        spaceBetween: 30,
        speed:700,
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
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
                        '   <button onclick="deleteSearchKeyword('+ json['keywords'][i]['idx'] +')">' +
                        '       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-gray-400"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>' +
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
                adKeywordPart += '<div class="flex flex-wrap items-center gap-1">';
                for(i=0; i<json['ad_keyword'].length; i++) {
                    adKeywordPart += '<a href="'+json["ad_keyword"][i]["web_link"]+'" class="flex items-center px-2 h-[28px] text-stone-800 border border-stone-400 rounded-full">' + json['ad_keyword'][i]['keyword_name'] + '</a>';
                }
                adKeywordPart += '</div>';
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
//                            bannerPart += '/help/notice/';
                            bannerPart += json['banner'][i]['web_link'];
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

    $(document).ready(function(f) {
        checkAlert();
        getSpeakerLoud();

        if( f.keyCode == 1 ) {
            if( $('#sKeyword').val() != '' ) {
                $('form#search_form').submit();
            }
        }
    });

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

    function getSearchModal()
    {
        getSearchData();
        modalOpen('#search_modal')
    }


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
        document.getElementById('sKeyword').addEventListener('change', evt => {
            clickKeyword(evt.currentTarget.value);
        })
    }

    function clickKeyword(keyword) {
        $('[data-idx='+keyword+']').css('color', '#FB4760');
        $('#loadingContainer').show();
        
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
                    let speaker_link = e.web_link;
                    htmlText += `<li class="swiper-slide"><a href="${speaker_link}" class="flex items-center"><svg><use xlink:href="/img/icon-defs.svg#Notice"></use></svg>${e.speaker_text}<svg><use xlink:href="/img/icon-defs.svg#Notice_arrow"></use></svg></a></li>`;
                })
                $('.header_banner_slide .swiper-wrapper').html(htmlText);
                header_banner.update();
            }
        });
    }
</script>