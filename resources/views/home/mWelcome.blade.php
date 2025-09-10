<!DOCTYPE html>
<html lang="ko_KR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta property="og:locale" content="ko_KR" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="" />
    <meta property="og:keywords" content="" />
    <meta property="og:description" content="" />
    <meta property="og:url" content="#" />
    <meta property="og:image" content="">
    <meta property="og:site_name" content="" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="" />
    <meta name="twitter:title" content="" />
    <title>All FURN  | Home</title>

    <link rel="stylesheet" href="/ver.1/css/ui.css?22122804">
</head>

<style>
    .splash {
        overflow-y: hidden !important;
        -webkit-overflow-scrolling: unset;
        height: 100vh;

        &::after {
            content: ' ';
            background: url('/splash.png') no-repeat;
            background-image: url('/splash.png') no-repeat;
            background-size: cover;
            display: block;
            width: 100vw;
            height: 100vh;
            position: fixed;
            top: 0px;
            z-index: 10000;
        }
    }
</style>

<body class="allfurn-introduction splash">

    @if(isset($isweb) && $isweb == 'Y')
    <div id="wrap" class="mo-wrap">
        <header id="header" class="header headertype__mo">
            <div class="inner">
                <h1 class="head__logo head__logo--large"><span class="a11y">All FURN</span></h1>
            </div>
        </header>
        <div id="container" class="container">
            <div class="inner__full">
                <div class="intro intro__top">
                    <div class="inner">
                        <div class="image"></div>
                        <div class="intro__content">
                            <strong class="intro__content-top">세상의 모든 가구 생산공급자 및 판매자, <br>가구관련 종사업종의 모든 분들의 정보가
                                있는</strong>
                            <h2>올펀(All-Furn)을 만나보세요</h2>
                            <div class="button-wrap">
{{--                                <button type="button" class="button" style="border:1px solid #dedede" onclick="location.href='/signin'">모바일로 로그인</button> --}}
                                <button type="button" onclick="download()" class="button  button--solid" style="margin-top:10px;">올펀 앱 다운로드 
                                    {{-- <i class="ico__arrow--right18"></i> --}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="intro intro01">
                    <div class="inner">
                        <div class="image"><img alt="인트로 이미지" src="/ver.1/images/home/allfurn_intro001.jpg" fetchpriority="hight" /></div>
                        <div class="intro__content">
                            <h2>
                                지금 <b>주목받는 가구 신상품</b>과
                                <b>업계 소식</b>을 올펀에서 확인해보세요.
                            </h2>
                            <div class="desc">현재 가구시장에 나오는 <b>최신 제품정보 / 판매 트렌드</b>를 눈에 확인할 수 있습니다</div>
                            <div class="desc">매월 업데이트되는 가구들의 정보와 이야기들을 지금 만나보세요~!</div>
                        </div>
                    </div>
                </div>
                <div class="intro intro02">
                    <div class="inner">
                        <div class="image"><img alt="인트로 이미지" src="/ver.1/images/home/allfurn_intro002.jpg" /></div>
                        <div class="intro__content">
                            <h2>
                                생산 / 도매사장님만의 <b>[제품과 회사]를 소개</b>해보세요~! 매출은 UP! 거래처정보도 UP!
                            </h2>
                            <div class="desc">약간의 시간을 투자하시면, 생산 / 도매 사장님의 <b>미니홈페이지</b>가 만들어집니다.</div>
                            <div class="desc">매월 업데이트되는 가구들의 정보와 이야기들을 지금 만나보세요~!</div>
                        </div>
                    </div>
                </div>
                <div class="intro intro03">
                    <div class="inner">
                        <div class="image"><img alt="인트로 이미지" src="/ver.1/images/home/allfurn_intro003.jpg" /></div>
                        <div class="intro__content">
                            <h2>
                                소매사장님 매장에 맞는
                                <b>트렌디한 제품정보</b>가 가득가득!
                            </h2>
                            <div class="desc">국내&amp;해외 가구 제품 정보들을 한눈에 확인이 가능하십니다~!</div>
                            <div class="desc">원하시는 타이밍에 제품기획전까지 고민할 수 있는 <br>최적의 비즈니스 파트너 [올펀]에서 제품 검색 및 소통을 시작해보세요
                            </div>
                        </div>
                    </div>
                </div>
                <div class="intro intro04">
                    <div class="inner">
                        <div class="image"><img alt="인트로 이미지" src="/ver.1/images/home/allfurn_intro004.jpg" /></div>
                        <div class="intro__content">
                            <h2>
                                가구인들의 일상부터 비즈니스 이야기까지
                                커뮤니티에서 공유해보세요.
                            </h2>
                            <div class="desc">가구인만의 언어가 있는 것을 너무나 잘 알고 있습니다.</div>
                            <div class="desc">제품 그리고 배송, A/S 등 가구인 그리고 가구관련 종사를 하고 있는 모든 분이 직접 주인이 되셔서, 이야기 게시판을
                                만들고 소통 해보세요~!</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer footer__mo">
            <div class="foo__cont">
                <div class="foo__wrap">
                    <div>
                        <p class="foo__logo"><span class="a11y">All FURN</span></p>
                        <div class="foo__info">
                            <p>
                                사업자등록번호 : 182-81-02804<span class="bar"></span>대표 : 송도현
                            </p>
                            <p>주소 : 경기도 고양시 일산동구 산두로213번길 18(정발산동)</p>
                            <p>
                                Tel : 031-813-5588<span class="bar"></span>E-mail :
                                <a href="mailto:gaguoutlet11@naver.com">gaguoutlet11@naver.com</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="foo__util">
                <a href="#">서비스 소개</a><span class="bar"></span>
                <a href="#">이용 약관</a><span class="bar"></span>
                <a href="#">개인정보 처리 방침</a>
            </div>
        </footer>
        
        <script type="text/javascript">
            // 인앱 로그인인지 여부
            
            var isMobile = {
                Android: function () {
                    return navigator.userAgent.match(/Chrome/) == null ? false : true;
                },
                iOS: function () {
                    return navigator.userAgent.match(/iPhone|iPad|iPod/i) == null ? false : true;
                },
                any: function () {
                    return (isMobile.Android() || isMobile.iOS());
                }
            };

            try{
                if(isMobile.any() && !window.AppWebview && '{{ $replaceUrl ?? "" }}' != '') {

                    if(isMobile.Android()) {
                        
                        const intentUrl = 'Intent://deeplink?path='+ 
                                                decodeURI('{{ $replaceUrl ?? "" }}')
                                                +'#Intent;scheme=allfurn;action=android.intent.action.VIEW;category=android.intent.category.BROWSABLE;package=com.appknot.allfurn;end;';

                        const win = window.open(intentUrl, "_blank");
                        setTimeout(() => {
                            win.close();
                        }, 5000);

                    } else if(isMobile.iOS()) {
                        const intentUrl = 'allfurn://' + decodeURI(('{{ $replaceUrl ?? "" }}'.replace('https://www.all-furn-web/', '')
                            .replace('https://all-furn-web/', '')
                            .replace('https://allfurn-web.codeidea.io/', '')));

                        const win = window.open(intentUrl, "_blank");
                        setTimeout(() => {
                            win.close();
                        }, 5000);
                    }
                }
            } catch (e){
                console.log(e)
            }
        </script>
    @endif

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
    function download() {

    if(checkMobile() == 'ios') {
        location.href="https://apps.apple.com/us/app/%EC%98%AC%ED%8E%80-%EA%B8%80%EB%A1%9C%EB%B2%8C-%EA%B0%80%EA%B5%AC-%EB%8F%84-%EC%86%8C%EB%A7%A4-no-1-%ED%94%8C%EB%9E%AB%ED%8F%BC/id1658683212";
    } else {
        location.href="https://play.google.com/store/apps/details?id=com.appknot.allfurn";
    }

    }
    
    const isInApp = window.AppWebview || (window.webkit && window.webkit.messageHandlers && window.webkit.messageHandlers.AppWebview);
    if(isInApp) {
        
        const accessToken = localStorage.getItem('accessToken');
        if(accessToken && accessToken.length > 1) {
            const callTime = new Date().getTime();
            
            fetch('/tokenpass-signin', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    'accessToken': accessToken
                })
            }).then(result => {
                return result.json();
            }).then(result => {
                const pendingTime = new Date().getTime() - callTime;

                if (result.success) {                    
                    if(pendingTime > 1100) {
                        location.href = '/';
//                        $('.splash').removeClass('splash');
                    } else {
                        setTimeout(() => {
                        location.href = '/';
//                            $('.splash').removeClass('splash');
                        }, (1100 - pendingTime));
                    }
                } else {
                    if(pendingTime > 1400) {
                        location.href = '/signin';
                        document.querySelector('.splash').classList.remove('splash');
                    } else {
                        setTimeout(() => {
                            location.href = '/signin';
                            document.querySelector('.splash').classList.remove('splash');
                        }, (1400 - pendingTime));
                    }
//                    alert(result.msg);
                }
            })
        } else {
            setTimeout(() => {
                document.querySelector('.splash').classList.remove('splash');
                location.href = '/signin';
            }, 1400);
        }
    } else {
        // 인앱이 아님.
        document.querySelector('.allfurn-introduction').classList.remove('splash');
        @if(!isset($isweb) || $isweb != 'Y')
        location.replace('/?isweb=Y');
        @endif
    }
    </script>
</body>
</html>
