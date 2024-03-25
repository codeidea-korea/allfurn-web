<header>
    <div class="header_top">
        <div class="inner">
            <h1 class="logo"><a class="flex items-center gap-1" href="/"><img src="/img/logo.svg" alt="">가구 B2B플랫폼</a></h1>
            <button class="search_btn" onclick="modalOpen('#search-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Search"></use></svg> 상품및 도매 업체를 검색해주세요</button>
            <ul class="right_link flex items-center">
                <li><a href="/message">올톡</a></li>
                <li><a href="/mypage/deal">마이올펀</a></li>
                <li><a href="./like_prod.php">좋아요</a></li>
                <li><a class="alarm_btn" href="/alarm"><span hidden></span><svg><use xlink:href="/img/icon-defs.svg#Alarm"></use></svg></a></li>
            </ul>
        </div>
    </div>
    <div class="header_banner">
        <div class="inner">
            <a href="javascript:;" class="flex items-center">
                <svg><use xlink:href="/img/icon-defs.svg#Notice"></use></svg>
                내 집에서 호텔 침대를 만나보세요
                <svg><use xlink:href="/img/icon-defs.svg#Notice_arrow"></use></svg>
            </a>
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

    $(document).ready(function(){
        getCategoryList();
        checkAlert();
        //getCategoryBanners();
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
                    htmlText += '<a href="javascript:;">';
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
    
</script>