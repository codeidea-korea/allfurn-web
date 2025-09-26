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
    <link rel="stylesheet" href="/css/font.css">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" /> --}}
    <link rel="stylesheet" href="/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="/css/common.css?{{ date('Ymd') }}">
    <link rel="stylesheet" href="/css/style.css?{{ date('Ymd') }}">
    <link rel="stylesheet" href="/css/rubin.css">
    <link rel="stylesheet" href="/css/output.css">
    <!-- flatpickr(datepicker) -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" /> --}}
    <link rel="stylesheet" href="/css/flatpickr.min.css">

    <script src="/js/jquery-1.12.4.js"></script>
    <script src="/js/jquery-ui-1.13.1.js"></script>
    <script defer src="/js/pci.js"></script>
    <script defer src="https://cdn.tailwindcss.com"></script>
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script> --}}
    <script src="/js/swiper-bundle.min.js?{{ date('Ymd') }}"></script>
    <script src="/js/common.js?{{ date('Ymd') }}"></script>
    <!-- flatpickr(datepicker) -->
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/flatpickr"></script> --}}
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ko.js"></script> --}}
    <script defer src="/js/flatpickr_ko.js"></script>
    <script defer src="/js/flatpickr.js"></script>
    

    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
</head>
<body>
    @yield('content')
    @include('layouts.modal')
    @include('layouts.footer')
</body>
</html>
