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
    <link rel="stylesheet" href="/css/m/font.css?{{ date('Ymdhis') }}">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css?{{ date('Ymdhis') }}"> --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/anypicker/dist/anypicker-all.min.css?{{ date('Ymdhis') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="/css/m/swiper-bundle.min.css?{{ date('Ymdhis') }}">
    <link rel="stylesheet" href="/css/m/anypicker-all.min.css?{{ date('Ymdhis') }}">
    <link rel="stylesheet" href="/css/m/common.css?{{ date('Ymdhis') }}">
    <link rel="stylesheet" href="/css/m/style.css?{{ date('Ymdhis') }}">
    <link rel="stylesheet" href="/css/m/rubin.css?{{ date('Ymdhis') }}">
    <link rel="stylesheet" href="/css/m/anypicker.css?{{ date('Ymdhis') }}">
    <link rel="stylesheet" href="/css/m/anypicker-ios.css?{{ date('Ymdhis') }}">
    {{-- <link rel="stylesheet" href="/css/output.css?{{ date('Ymdhis') }}"> --}}

    <script src="/js/jquery-1.12.4.js?{{ date('Ymdhis') }}"></script>
    <script src="/js/pci.js?{{ date('Ymdhis') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js?{{ date('Ymdhis') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js?{{ date('Ymdhis') }}"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js?{{ date('Ymdhis') }}"></script> --}}
    <script src="/js/m/swiper-bundle.min.js?{{ date('Ymdhis') }}"></script>

    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="/js/m/anypicker.js?{{ date('Ymdhis') }}"></script>
    <script src="/js/m/anypicker-i18n-ko.js?{{ date('Ymdhis') }}"></script>

    <script src="/js/m/common.js?{{ date('Ymdhis') }}"></script>
    <style>/* ! tailwindcss v3.4.1 | MIT License | https://tailwindcss.com */*,::after,::before{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}::after,::before{--tw-content:''}:host,html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;tab-size:4;font-family:ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";font-feature-settings:normal;font-variation-settings:normal;-webkit-tap-highlight-color:transparent}body{margin:0;line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,pre,samp{font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;font-feature-settings:normal;font-variation-settings:normal;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}button,input,optgroup,select,textarea{font-family:inherit;font-feature-settings:inherit;font-variation-settings:inherit;font-size:100%;font-weight:inherit;line-height:inherit;color:inherit;margin:0;padding:0}button,select{text-transform:none}[type=button],[type=reset],[type=submit],button{-webkit-appearance:button;background-color:transparent;background-image:none}:-moz-focusring{outline:auto}:-moz-ui-invalid{box-shadow:none}progress{vertical-align:baseline}::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}summary{display:list-item}blockquote,dd,dl,figure,h1,h2,h3,h4,h5,h6,hr,p,pre{margin:0}fieldset{margin:0;padding:0}legend{padding:0}menu,ol,ul{list-style:none;margin:0;padding:0}dialog{padding:0}textarea{resize:vertical}input::placeholder,textarea::placeholder{opacity:1;color:#9ca3af}[role=button],button{cursor:pointer}:disabled{cursor:default}audio,canvas,embed,iframe,img,object,svg,video{display:block;vertical-align:middle}img,video{max-width:100%;height:auto}[hidden]{display:none}*, ::before, ::after{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-gradient-from-position: ;--tw-gradient-via-position: ;--tw-gradient-to-position: ;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }::backdrop{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-gradient-from-position: ;--tw-gradient-via-position: ;--tw-gradient-to-position: ;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }.relative{position:relative}.my-5{margin-top:1.25rem;margin-bottom:1.25rem}.mt-2{margin-top:0.5rem}.mt-4{margin-top:1rem}.mb-10{margin-bottom:2.5rem}.mb-5{margin-bottom:1.25rem}.\!mb-0{margin-bottom:0px !important}.\!mt-0{margin-top:0px !important}.mb-3{margin-bottom:0.75rem}.ml-3{margin-left:0.75rem}.mt-1{margin-top:0.25rem}.mt-10{margin-top:2.5rem}.mt-3{margin-top:0.75rem}.mt-5{margin-top:1.25rem}.mt-8{margin-top:2rem}.inline-block{display:inline-block}.flex{display:flex}.hidden{display:none}.h-11{height:2.75rem}.h-6{height:1.5rem}.h-\[110px\]{height:110px}.h-5{height:1.25rem}.h-\[18px\]{height:18px}.h-\[20px\]{height:20px}.h-\[240px\]{height:240px}.h-\[28px\]{height:28px}.h-\[300px\]{height:300px}.h-\[48px\]{height:48px}.w-11{width:2.75rem}.w-6{width:1.5rem}.w-full{width:100%}.w-5{width:1.25rem}.\!w-full{width:100% !important}.w-1\/2{width:50%}.w-1\/4{width:25%}.w-4{width:1rem}.w-\[130px\]{width:130px}.w-\[18px\]{width:18px}.w-\[20px\]{width:20px}.w-\[80px\]{width:80px}.w-\[full\]{width:full}.shrink-0{flex-shrink:0}.flex-grow{flex-grow:1}.rotate-180{--tw-rotate:180deg;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}.flex-col{flex-direction:column}.items-start{align-items:flex-start}.items-center{align-items:center}.justify-center{justify-content:center}.justify-between{justify-content:space-between}.gap-1{gap:0.25rem}.gap-2{gap:0.5rem}.gap-4{gap:1rem}.gap-3{gap:0.75rem}.overflow-hidden{overflow:hidden}.overflow-y-auto{overflow-y:auto}.overflow-y-scroll{overflow-y:scroll}.rounded-md{border-radius:0.375rem}.rounded-full{border-radius:9999px}.rounded-sm{border-radius:0.125rem}.border{border-width:1px}.border-b{border-bottom-width:1px}.bg-white{--tw-bg-opacity:1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.bg-stone-100{--tw-bg-opacity:1;background-color:rgb(245 245 244 / var(--tw-bg-opacity))}.bg-stone-400{--tw-bg-opacity:1;background-color:rgb(168 162 158 / var(--tw-bg-opacity))}.bg-stone-800{--tw-bg-opacity:1;background-color:rgb(41 37 36 / var(--tw-bg-opacity))}.stroke-stone-400{stroke:#a8a29e}.p-4{padding:1rem}.p-5{padding:1.25rem}.px-4{padding-left:1rem;padding-right:1rem}.py-3{padding-top:0.75rem;padding-bottom:0.75rem}.px-16{padding-left:4rem;padding-right:4rem}.px-3{padding-left:0.75rem;padding-right:0.75rem}.px-5{padding-left:1.25rem;padding-right:1.25rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.py-1{padding-top:0.25rem;padding-bottom:0.25rem}.py-2{padding-top:0.5rem;padding-bottom:0.5rem}.text-left{text-align:left}.text-center{text-align:center}.text-sm{font-size:0.875rem;line-height:1.25rem}.text-lg{font-size:1.125rem;line-height:1.75rem}.text-xl{font-size:1.25rem;line-height:1.75rem}.text-xs{font-size:0.75rem;line-height:1rem}.font-bold{font-weight:700}.font-medium{font-weight:500}.text-gray-400{--tw-text-opacity:1;color:rgb(156 163 175 / var(--tw-text-opacity))}.text-white{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.text-stone-400{--tw-text-opacity:1;color:rgb(168 162 158 / var(--tw-text-opacity))}</style><captcha-widgets></captcha-widgets></head>

</head>
<body>

@if (  !empty(Auth::user()) && !empty(Auth::user()['account']) )

@else

<script type="text/javascript">
    // 인앱 로그인인지 여부
    function checkMobile(){
        var varUA = navigator.userAgent.toLowerCase(); //userAgent 값 얻기
        if ( varUA.indexOf('android') > -1) {
            return "android";
        } else if ( varUA.indexOf("iphone") > -1||varUA.indexOf("ipad") > -1||varUA.indexOf("ipod") > -1 ) {
            //IOS
            return "ios";
        } else {
            return "other";
        }
    }
    
    const isInApp = window.AppWebview || (window.webkit && window.webkit.messageHandlers && window.webkit.messageHandlers.AppWebview);
    
    const accessToken = localStorage.getItem('accessToken');
    if(accessToken && accessToken.length > 1) {
        const callTime = new Date().getTime();
        $.ajax({
    //        headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
            url: '/tokenpass-signin',
            data: {
                'accessToken': accessToken
            },
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                if (result.success) {
                    if(location.pathname.indexOf('/signin') > -1) {
                        location.href = '/';
                    } else {
                        location.reload();
                    }
                } else {
                    localStorage.clear();
                    location.href = '/signin';
                }
            }
        });
    } else {
        localStorage.clear();
        location.href = '/signin';
    }
    </script>

@endif

@yield('content')
@include('layouts.modal')
@include('layouts.footer_m')
</body>
</html>
