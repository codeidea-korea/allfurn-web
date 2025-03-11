@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
    <div id="container" class="container">
        <div class="inner__full">
            <div id="mainkvSwipe" class="eventkeyvisual swiper-container">
                <div class="swiper-wrapper">
                    @foreach($data['banner_top'] as $item)
                            <?php
                            $link = '';
                            
                            switch ($item->web_link_type) {
                                case 0: //Url
                                    $link = $item->web_link;
                                    break;
                                    
                                case 1: //상품
                                    if ( strpos($item->web_link, 'product/detail') !== false ) {
                                        $link = $item->web_link;
                                    } else {
                                        $link = '/product/detail/'.$item->web_link;
                                    }
                                    break;
                                    
                                case 2: //업체
                                    if ( strpos($item->web_link, 'wholesaler/detail') !== false ) {
                                        $link = $item->web_link;
                                    } else {
                                        $link = '/wholesaler/detail/'.$item->web_link;    
                                    } 
                                    break;
                                case 3: //커뮤니티
                                    if ( strpos($item->web_link, 'community/detail') !== false ) {
                                        $link = $item->web_link;
                                    } else {
                                        $link = '/community/detail/'.$item->web_link;
                                    } 
                                    break;
                                    /*
                                case 4:
                                    $link = '/help/notice/';
                                    break;
                                    */
                                default: //공지사항
                                    // if ( strpos($item->web_link, 'help/notice') !== false ) {
                                    //     $link = $item->web_link;
                                    // } else {
                                    //     $link = '/help/notice/'.$item->web_link;
                                    // }
                                    $link = $item->web_link;
                                    break;
                                    
                            }
                            ?>
                        <div class="swiper-slide">
                            <a href="{{$link}}">
                                <p class="event__banner" style="background-image:url(
                                @if(isset($item->attachment->folder) && isset($item->attachment->filename))
                                    {{preImgUrl().$item->attachment->folder."/".$item->attachment->filename}}
                                @endif
                                )"></p>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-util">
                    <div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>

                <!-- <div class="swiper-button-wrap">
                </div> -->
                
            </div>
        </div>

        <div class="inner">
            <div class="content">
                <!-- 상품 -->
                <h2 class="content__title content__title--top">지금 주목받는 새 상품</h2>
                <ul class="content__container product">
                    @foreach($data['new_product'] as $key=>$item)
                        <li class="card" style="position: relative; @if($key > 7) display: none; @endif">
                            <div id="productSwipe0{{$key}}" class="product_swiper swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <a href="/product/detail/{{$item->idx}}" title="{{$item->name}} 바로가기">
                                            <div class="item">
                                                <img src="{{$item->imgUrl}}" alt="상품0{{$key}}">
                                                <p class="badge">{{$item->companyName}}</p>
                                            </div>
                                            <p class="card__title">
                                                @if($item->state == 'O')
                                                    (품절)
                                                @endif
                                                {{$item->name}}
                                            </p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @if($item->state == 'O')
                                <a class="dim" style="position:absolute;width:100%;height:100%;top:0;left:0;background-color: #ffffff80" href="/product/detail/{{$item->idx}}"></a>
                            @endif
                        </li>
                    @endforeach
                </ul>

                <!-- 커뮤니티 -->
                <div class="content__title--community">
                    <h2 class="content__title">올펀 커뮤니티</h2>
                    <div class="view-all">
                        <a href="/community" title="전체보기">전체보기</a>
                        <i class="ico__arrow--right14">
                            <span class="a11y">오른쪽 화살표</span>
                        </i>
                    </div>
                </div>
                <ul class="content__container--community">
                    <li class="card">
                        <h3>커뮤니티 인기글</h3>
                        <ul class="item">
                           @foreach($data['community'] as $item)
                                <li class="list">
                                    <p class="badge">{{$item->name}}</p>
                                    <a href="community/detail/{{$item->idx}}" class="description">{{$item->title}}</a>
                                    <p class="count"></p>
                                </li>
                           @endforeach
                        </ul>
                    </li>
                    <li class="card">
                        <h3>비지니스 최신글</h3>
                        <ul class="item">
                            @foreach($data['business'] as $item)
                                <li class="list">
                                    <p class="badge">{{$item->name}}</p>
                                    <a href="community/detail/{{$item->idx}}" class="description">{{$item->title}}</a>
                                    <p class="count"></p>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
                @if(sizeof($data['banner_bottom']) > 0)
                    <div id="eventkvSwipe" class="eventkeyvisual swiper-container eventkeyvisual--inner"
                         style="margin-bottom: 0 !important;">
                        <div class="swiper-wrapper">
                            @foreach($data['banner_bottom'] as $item)
                                <div class="swiper-slide">
                                    <?php
                                        $link = '';
                                        switch ($item->web_link_type) {
                                            case 0: //Url
                                                $link = $item->web_link;
                                                break;
                                            case 1: //상품
                                                // $link = '/product/detail/'.$item->web_link;
                                                $link = $item->web_link;
                                                break;
                                            case 2: //업체
                                                // $link = '/wholesaler/detail/'.$item->web_link;
                                                $link = $item->web_link;
                                                break;
                                            case 3: //커뮤니티
                                                // $link = '/community/detail/'.$item->web_link;
                                                $link = $item->web_link;
                                                break;
                                            default: //공지사항
//                                                $link = '/help/notice/';
                                                $link = $item->web_link;
                                                break;
                                        }
                                    ?>
                                    <a href="{{$link}}">
                                        <p class="event__banner" style="background-image:url({{preImgUrl().$item->attachment->folder."/".$item->attachment->filename}})"></p>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-util">
                            <div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                @endif
            </div>
        </div>

        @if ($_SERVER['REMOTE_ADDR'] == '118.37.1.137')
            <div id="main-event" class="modal">
                <div class="modal__container" style="width: 600px;">
                    <div class="modal__content">
                        <button type="button" onclick="closeModal('#main-event');" class="close-button ico_circle_delete">
                            <span class="a11y">닫기</span>
                        </button>
                        <div class="modal-box__container">
                            <div class="modal-box__content">
                                <div class="modal__desc">
                                    <div class="modal-box__swiper">
                                        <div id="modalkvSwipe" class="modalkeyvisual swiper-container">
                                            <div class="swiper-wrapper">
                                                @foreach($data['popup'] as $item)
                                                    <div class="swiper-slide">
                                                        <?php
                                                            $link = '';
                                                            switch ($item->web_link_type) {
                                                                case 0: //Url
                                                                    $link = $item->web_link;
                                                                    break;
                                                                case 1: //상품
                                                                    $link = '/product/detail/'.$item->web_link;
                                                                    break;
                                                                case 2: //업체
                                                                    $link = '/wholesaler/detail/'.$item->web_link;
                                                                    break;
                                                                case 3: //커뮤니티
                                                                    $link = '/community/detail/'.$item->web_link;
                                                                    break;
                                                                default: //공지사항
//                                                                    $link = '/help/notice/'.$item->web_link;
                                                                    $link = $item->web_link;
                                                                    break;
                                                            }
                                                        ?>
                                                        <a href="{{$link}}">
                                                            <p class="event__banner"
                                                            style="background-image:url({{$item->imgUrl}})" data-web_link="{{$item->web_link}}"></p>
                                                        </a>
                                                    </div>
                                                @endforeach
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
                                <div class="modal__util">
                                    <a onclick="popupClose()" class="modal__hide-button"><span>오늘 하루 보지않기</span></a>
                                    <a onclick="popupUrl()" class="modal__detail-button" style="cursor: pointer;"><span>자세히 보기</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif 
    </div>
@endsection

@section('script')
    <script>
        function shuffleArray(array) {
            array.sort(() => Math.random() - 0.5);
        }
        let arr = [0, 1, 2, 3, 4, 5, 6, 7];
        var flipCnt = 0;

        var mainswipe = new Swiper('#mainkvSwipe', {
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            loop: true,
            slidesPerView: 1,
            spaceBetween: 0,
            paginationClickable: true,
            keyboard: true,
            speed: 400,
            pagination: {
                el: '#mainkvSwipe .swiper-pagination',
                type: 'fraction',
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
        
        $('#mainkvSwipe .swiper-button-wrap').hover(function(){
            mainswipe.autoplay.stop();
        }, function(){
            mainswipe.autoplay.start();
        });

        var eventswiper = new Swiper('#eventkvSwipe', {
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            loop: true,
            slidesPerView: 1,
            spaceBetween: 0,
            paginationClickable: true,
            keyboard: true,
            speed: 400,
            pagination: {
                el: '#eventkvSwipe .swiper-pagination',
                type: 'fraction',
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
        $('#eventkvSwipe .swiper-slide').hover(function(){
            eventswiper.autoplay.stop();
        }, function(){
            eventswiper.autoplay.start();
        });

        var modalswiper = new Swiper('#modalkvSwipe', {
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            loop: true,
            slidesPerView: 1,
            spaceBetween: 0,
            paginationClickable: true,
            keyboard: true,
            speed: 500,
            pagination: {
                el: '#modalkvSwipe .swiper-pagination',
                type: 'fraction',
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
        $('#modalkvSwipe .swiper-slide').hover(function(){
            modalswiper.autoplay.stop();
        }, function(){
            modalswiper.autoplay.start();
        });

        // 쿠키 가져오기
        var getCookie = function (cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for(var i=0; i<ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1);
                if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
            }
            return "";
        }

        // 24시간 기준 쿠키 설정하기
        var setCookie = function (cname, cvalue) {
            var todayDate = new Date();
            todayDate.setHours(23, 59, 59, 999);
            var expires = "expires=" + todayDate.toString(); // UTC기준의 시간에 exdays인자로 받은 값에 의해서 cookie가 설정 됩니다.
            document.cookie = cname + "=" + cvalue + "; " + expires;
        }

        var popupClose = function(){
            setCookie("mainEventPopupClose","Y");
            closeModal('#main-event');
        }

        function getNewProduct() {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '/home/getNewProduct',
                data: {},
                type: 'POST',
                dataType: 'json',
                success: function (result) {
                    result.list.forEach(function (item, i) {
                        if (i < 8) {
                            $('#productSwipe0'+ (i+8)).html(
                                '<div class="swiper-wrapper">' +
                                '<div class="swiper-slide">' +
                                '<a href="/product/detail/'+item['idx']+'" title="'+item['name']+' 바로가기">' +
                                '<div class="item">' +
                                '<img src="'+item['imgUrl']+'" alt="상품0'+ i +'">' +
                                '<p class="badge">'+item['companyName']+'</p>' +
                                '</div>' +
                                '<p class="card__title">'+item['name']+'</p>' +
                                '</a>' +
                                '</div>' +
                                '</div>'
                            );
                        }
                    })
                    productSwiper = initFlip(arr[flipCnt]);
                    // $('#container .content__container.product').html(htmlText);

                    // productSwiper.destroy();
                    // productSwiper = initFlip(arr[flipCnt]);

                }
            });
        }

        function popupUrl() {
            location.replace($('#modalkvSwipe .swiper-slide-active a').prop('href'));
        }

        $(document).ready(function(){
            var cookiedata = document.cookie;
            if(cookiedata.indexOf("mainEventPopupClose=Y")<0){
                modalOpen("#main-event");
            }

            // setTimeout(function() {
            //     getNewProduct()
            // }, 9000);
            shuffleArray(arr);
        });

        var productSwiper = initFlip(arr[flipCnt]);

        function initFlip(i) {
            return new Swiper('#productSwipe0' + i, {
                effect: "fade",
                grabCursor: true,
                loop: true,
                slidesPerView: 1,
                spaceBetween: 0,
                paginationClickable: true,
                keyboard: true,
                speed: 3000,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                on: {
                    transitionStart: () => {
                        var htmlText = $('#productSwipe0'+(flipCnt+8)).html();
                        $('#productSwipe0'+arr[flipCnt]).html(htmlText);

                        setTimeout(function() {
                            productSwiper.destroy();
                            resetFlip();
                        }, 3000);
                    },
                }
            });
        }

        function resetFlip() {
            flipCnt ++;
            if (flipCnt == 8) {
                shuffleArray(arr);
                flipCnt = 0;

                getNewProduct();
            } else {
                productSwiper = initFlip(arr[flipCnt]);
            }
        }
    </script>
@endsection
