<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="올펀,가구톡세상,가구 플랫폼,가구,가구 도매,가구 소매,가구 판매,가구 구매"/>
    <meta name="description" content="가구인들을 위한 빠른 홍보. 많은 정보. 쉬운 검색. 세상 모든 가구인을 연결"/>
    <meta property="og:locale" content="ko_KR" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="전세계 가구 도소매거래 B2B플랫폼. 올펀 (All-Furn)" />
    <meta property="og:keywords" content="올펀,가구톡세상,가구 플랫폼,가구,가구 도매,가구 소매,가구 판매,가구 구매" />
    <meta property="og:description" content="가구인들을 위한 빠른 홍보. 많은 정보. 쉬운 검색. 세상 모든 가구인을 연결" />
    <meta property="og:url" content="https://all-furn.com" />
    <meta property="og:image" content="">
    <meta property="og:site_name" content="" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="가구인들을 위한 빠른 홍보. 많은 정보. 쉬운 검색. 세상 모든 가구인을 연결" />
    <meta name="twitter:title" content="전세계 가구 도소매거래 B2B플랫폼. 올펀 (All-Furn)" />
    <meta name=“naver-site-verification” content=“eee38481614b188bcb47ec952b8854688aa4d9de” />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>All FURN  | Home</title>
    
    <script src="/js/jquery-3.6.0.min.js" ></script>
    <script src="/js/jquery-ui-1.13.1.js" ></script>
    <script src="/js/swiper-bundle.min.js"></script>
    
    <link rel="stylesheet" href="/css/ui.css?22122804">
    
</head>

<body class="allfurn-introduction">
    <div class="skipnavigation"><a href="#container">skip to container</a></div>
    <div id="wrap" class="wrap">
        @yield('header')
        @include('layouts.header.search')

        @yield('content')
        @include('layouts.footer.main-footer')

        <div id="modal-page-notfund" class="modal">
            <div class="modal__container" style="width: 350px;">
                <div class="modal__content">
                    <div class="modal-box__container">
                        <div class="modal-box__content">
                            <div class="modal__desc">
                                <p class="modal__text">
                                    존재하지 않는 화면입니다.
                                </p>
                            </div>
                            <div class="modal__util">
                                <button type="button" onclick="closeModal('#modal-page-notfund');" class="modal__button"><span>확인</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/js/plugin.js" type="text/javascript"></script>
        @yield('script')

    </div>
    
    <script>
        
        $(document).ready(function(){
            checkAlert();
        });
        
        const checkAlert = () => {
            fetch("/checkAlert", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            }).then(response => {
                return response.json();
            }).then(json => {
                if (json.success == true) {
                    if (json.alarm > 0) {
                        $('.badge[name="alarm"]').text(json.alarm);
                        $('.badge[name="alarm"]').show();
                    } else {
                        $('.badge[name="alarm"]').hide();
                    }
                    if (json.cart > 0) {
                        $('.badge[name="cart"]').text(json.cart);
                        $('.badge[name="cart"]').show();
                    } else {
                        $('.badge[name="cart"]').hide();
                    }
                } else {
                    $('.badge[name="alarm"], .badge[name="cart"]').hide();
                }
            }).catch(err => {
                $('.badge[name="alarm"], .badge[name="cart"]').hide();
            });
        }
        
    </script>

</body>

</html>
