<?php setlocale (LC_MONETARY, 'ko_KR.UTF-8'); ?>
<header id="header" class="header ">
    <div class="head__fixed">
        <div class="inner">
            <div class="head__flex">
                <h1 class="head__logo"><a href="/"><span class="a11y">All FURN</span></a></h1>

                <div class="textfield @if(isset($_GET['kw'])) textfield--active @endif">
                    <i class="textfield__icon ico__search"><span class="a11y">검색</span></i>
                    <input
                            type="text"
                            class="textfield__search"
                            id="search_keyword"
                            placeholder="상품 및 도매 업체를 검색해주세요"
                            value="@if(isset($_GET['kw'])){{$_GET['kw']}}@endif"
                    />
                    <button type="button" class="textfield__icon--delete ico__sdelete" id="search_keyword_delete">
                        <span class="a11y">삭제하기</span>
                    </button>
                </div>
                <button type="button" class="globalsearch-close">취소</button>
            </div>

            <div class="head__util">
                <div class="util__link">
                    <a href="/message">올톡</a>
                    <a href="/mypage">마이올펀</a>
                    <a href="/help">고객센터</a>
                    <a href="/alarm">
                        <i class="ico__alram"><span class="a11y">알람</span></i>
                        <span class="badge" name="alarm" style="display:none;">1</span>
                    </a>

                    <a href="/cart">
                        <i class="ico__basket"><span class="a11y">장바구니</span></i>
                        <span class="badge" name="cart" style="display:none;">1</span>
                    </a>
                    
                </div>
            </div>
        </div>
        <div class="head__gnb">
            <div class="inner">
                <ul class="gnb__menu">
                    <li><a href="#" class="category-select">카테고리</a></li>
                    <li><a href="{{ route('product.new')}}">신상품</a></li>
                    <li><a href="/wholesaler">도매 업체</a></li>
                    <li><a href="/product/thisMonth">이 달의 도매</a></li>
                    <li><a href="/magazine">매거진</a></li>
                    <li><a href="/community">커뮤니티</a></li>
                </ul>

                <div class="gnb__category" style="max-height: 700px; display: none; overflow-y: scroll; ">
                    <div class="category-list-wrap">
                        <ul class="category-wrap step1"></ul>
                    </div>

                    <div class="category-banner-wrap" style="display:block">
                        <div id="eventkvSwipeHeader" class="eventkeyvisual swiper-container category-banner">
                            <div id="category_banners" class="swiper-wrapper">
                            </div>
                            <div class="swiper-util">
                                <div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            </div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    
    
    var banner = new Swiper('#eventkvSwipeHeader', {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 0,
        paginationClickable: true,
        keyboard: true,
        speed: 400,
        pagination: {
            el: '#eventkvSwipeHeader .swiper-pagination',
            type: 'fraction',
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
    
    // $('#eventkvSwipeHeader .swiper-button-wrap').hover(function(){
    //     banner.autoplay.stop();
    // }, function(){
    //     banner.autoplay.start();
    // });
    
    
    

    $('body').on('mouseenter', '.category-wrap.step1 a', function () {
        getCategoryList($(this).parent().data('category_idx'));
    })

    function getCategoryList(category_idx = 0) {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url				: '/product/getCategoryList/'+category_idx,
            data			: {},
            type			: 'POST',
            dataType		: 'json',
            success		: function(result) {
                if (category_idx != 0) {
                    let htmlText = '<ul class="category-wrap--active" style="display: block;">';
                    result.forEach(function (e, idx) {
                        htmlText += '<li class="category__list-item" >' +
                            '<a href="/product/category?ca=' + e.idx + '&pre='+e.parent_idx+'">' +
                            '<span>' + e.name + '</span>' +
                            '</a>' +
                            '</li>'
                    })
                    htmlText += '</ul>';
                    $('.category-wrap--active').remove();
                    $('.head__gnb .category-list-wrap').append(htmlText);

                } else {
                    
                    let htmlText = '';
                    result.forEach(function (e, idx) {
                        htmlText += '<li onClick="goCategoryList(' + e.idx + ')" data-category_idx=' + e.idx + ' style="cursor:pointer">' +
                            '<a class="category-list' + idx + '">' +
                            '<img class="category__ico" src="'+ e.imgUrl + '">' +
                            '<span>' + e.name + '</span>' +
                            '</a>' +
                            '</li>'
                    })

                    $('.category-wrap.step1').html(htmlText);
                }
            }
        });
    }
    
    
    function getCategoryBanners() {
        
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url				: '/product/getCategoryBanners/',
            data			: {},
            type			: 'GET',
            dataType		: 'json',
            success		: function(result) {
                
                if (result.success == true) {
                    
                    var banners = "";
                    
                    result.data.map(function(banner) {
                        
                        var link = banner.web_link;
                        
                        // console.log('link', link);
                        
                        banners += "<div class='swiper-slide'>";
                        banners += `    <a href='${link}'>`;
                        banners += `        <p class='event__banner' style='background-image:url("https://allfurn-prod-s3-bucket.sgp1.vultrobjects.com/banner_ad/${banner.filename}")'></p>`;
                        banners += '    </a>';
                        banners += '</div>';
                    
                    })
                    
                    $('#category_banners').html(banners);
                    
                }

            }
        });
    }
    
    
    function goCategoryList(category) {
        
        location.href = "/product/category?pre=" + category;
        
    } 
    
    
    $(document).ready(function(){
        getCategoryList();
        getCategoryBanners();
    });
    
</script>

