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
    <link rel="stylesheet" href="/css/font.css?{{ date('Ymdhis') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="/css/common.css?{{ date('Ymdhis') }}">
    <link rel="stylesheet" href="/css/style.css?{{ date('Ymdhis') }}">
    <link rel="stylesheet" href="/css/rubin.css?{{ date('Ymdhis') }}">
    <!-- flatpickr(datepicker) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />

    <script src="/js/jquery-1.12.4.js?{{ date('Ymdhis') }}"></script>
    <script src="/js/pci.js?{{ date('Ymdhis') }}"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script src="/js/common.js?{{ date('Ymdhis') }}"></script>
    <!-- flatpickr(datepicker) -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ko.js"></script>
    
</head>
<body>
    @yield('content')
    @include('layouts.modal')
    @include('layouts.footer')
</body>
</html>
