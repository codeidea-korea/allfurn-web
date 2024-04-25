<div id="globalsearch" class="globalsearch">
    <div class="globalsearch__inner">
        <div class="globalsearch__section globalsearch__section--history">
            <!-- 검색 기록 -->
            <div class="globalsearch-history" aria-hidden="false">
                <div class="row">
                    <div class="title">최근 검색어</div>
                    <div class="head-button"><a role="button" href="javascript:void(0)" onclick="deleteSearchKeyword('all')" class="head-button">전체 삭제</a></div>
                </div>
                <div class="keywordList"></div>
            </div>
            <!--// 검색 기록 -->
            <!-- 검색 기록 없음 -->
            <div class="globalsearch-history globalsearch-history--empty" aria-hidden="true" style="display: none;">
                <div class="row">
                    <div class="title">최근 검색어</div>
                </div>
                <div class="empty">최근 검색한 내역이 없습니다.</div>
            </div>
            <!--// 검색 기록 없음 -->
        </div>
        <div class="globalsearch__section globalsearch__section--best">
            <!-- 인기 집계 -->
            <div class="globalsearch-best" aria-hidden="false">
                <div class="row">
                    <div class="title">
                        인기 카테고리
                        <div class="title-meta"><span><?php echo date("m.d"); ?></span> <span><?php echo date('H:i'); ?></span><span>기준</span></div>
                    </div>
                </div>
                <div class="cateogry_list"></div>

            </div>
            <!--// 인기 집계 -->
            <!-- 인기 집계 없음 -->
            <div class="globalsearch-best globalsearch-best--empty" aria-hidden="true" style="display: none;">
                <div class="row">
                    <div class="title">
                        인기 카테고리
                        <div class="title-meta"><span>05.02</span><span>12:00</span><span>기준</span></div>
                    </div>
                </div>
                <div class="empty">집계된 인기 카테고리가 없습니다.</div>
            </div>
            <!--// 인기 집계 없음 -->
        </div>
        <div class="globalsearch__section globalsearch__section--recommend">
            <div class="globalsearch-recommend">
                <div class="row">
                    <div class="title">
                        추천 키워드
                        <div class="title-meta"><span>AD</span></div>
                    </div>
                </div>
                <div class="row">
                    <div class="hashtag-list">

                    </div>
                </div>
            </div>
        </div>
        
        <div class="globalsearch__banner">
            <div id="headerNavBanner" class="swiper-container">
                <div class="swiper-util">
                    <div class="swiper-pagination">
                        <div class="swiper-pagination-current"></div> / <div class="swiper-pagination-total"></div>
                    </div>
                    <div class="carousel-nav-next ico__carousel-right"></div>
                    <div class="carousel-nav-prev ico__carousel-left"></div>
                </div>
                <div class="swiper-wrapper">
                </div>
            </div>
        </div>
    </div>
</div>

<div id="globalsearch-modal" class="globalsearch-modal"></div>

<script>
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
                    keywordPart += '<div class="row">' +
                        ' <div class="row__text" onClick="clickKeyword(\'' + json['keywords'][i]['keyword'] + '\')" data-idx="' + json['keywords'][i]['keyword'] + '" style="cursor:pointer;">'+json['keywords'][i]['keyword']+'</div>' +
                        ' <a role="button" href="javascript:void(0)" onclick="deleteSearchKeyword(' + json['keywords'][i]['idx'] + ')">' +
                        '     <div class="ico__delete10"><span class="a11y">삭제하기</span></div>' +
                        ' </a>' +
                        '</div>';
                }
                document.querySelector('.keywordList').innerHTML = keywordPart;
            } else {
                keywordPart += '<div class="row">' +
                    '   <div class="row__text search-list--nodata">최근 검색한 내역이 없습니다.</div>' +
                    '</div>';
                document.querySelector('.keywordList').innerHTML = keywordPart;
            }

            var categoryList = "";
            if (json['category'].length > 0) {
                for(i=0; i<json['category'].length; i++) {
                    categoryList += '<div class="row">' +
                        '<div class="numbering">' + (i+1) + '</div> ';

                    if(json['category'][i]['parentName'] != null) {
                        categoryList += '<a href="/product/category?ca=' + json['category'][i]['categoryIdx'] + '&pre='+json['category'][i]['parentIdx']+'" >' +
                            '<ul class="breadcrumbs-wrap">' +
                            '<li>' + json['category'][i]['parentName'] + '</li>' +
                            '<li>' + json['category'][i]['categoryName'] + '</li>';
                    } else {
                        categoryList += '<a href="/product/category?pre='+json['category'][i]['categoryIdx']+'" >' +
                            '<ul class="breadcrumbs-wrap">' +
                            '<li>' + json['category'][i]['categoryName'] + '</li>';
                    }
                    categoryList +='</ul>' +
                        '</a>' +
                        '</div>';
                }

                //document.querySelector('.cateogry_list').innerHTML = categoryList;
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
                    bannerPart += '<div class="swiper-slide">' +
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
                        '       <p class="event__banner" style="background-image:url({{preImgUrl()}}' + json['banner'][i]['folder'] + '/' + json['banner'][i]['filename'] + ')"></p>' +
                        '   </a>' +
                        '</div>';
                }
                document.querySelector('#headerNavBanner .swiper-wrapper').innerHTML = bannerPart;
            } else {
                bannerPart += '<div class="row">' +
                    '   <div class="row__text search-list--nodata">최근 검색한 내역이 없습니다.</div>' +
                    '</div>';
                document.querySelector('.keywordList').innerHTML = bannerPart;
            }
        });
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

    // 검색 리스트
    if ($('#search_keyword').length) {
        document.getElementById('search_keyword').addEventListener('click', evt => {
            getSearchData();
        })
    }
    

    $('body').on('click', '#search_keyword_delete', function () {
        $('#search_keyword').val('');
        $(this).removeClass('ico__sdelete');
        $('#search_keyword').click();
        $('#search_keyword').focus();
    })

    // 검색
    if ($('#search_keyword').length) {
        document.getElementById('search_keyword').addEventListener('change', evt => {
            clickKeyword(evt.currentTarget.value);
        })
    }

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
                location.replace('/product/searchBar?kw=' + keyword);
            }
        });
    }
</script>
