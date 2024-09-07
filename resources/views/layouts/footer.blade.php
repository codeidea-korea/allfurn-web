@if(isset(Auth::user()['type']) && in_array(Auth::user()['type'], ['W']))
    @if(request()->is(['product/detail/*', 'product/registration', 'magazine/*/detail/*', 
                        'magazine/detail/*','community','community/*', 'message/*', 'help/*',
                        'signin', 'signup','findid', 'findpw'
                    ]))
        {{-- 아무것도 표시 안함 --}}
    @else
        <div id="prod_regist_btn" class="">
            <a href="/product/registration">상품<br>등록</a>
        </div>
    @endif
    
    @if(request()->is(['', '/', 'mypage/*', 'wholesaler/detail/'.Auth::user()['company_idx'] ]))
                    
        <div style="z-index:50; position:fixed; right:40px; bottom:115px; display:flex; align-items:center; justify-content:center; width:68px; height:68px; border-radius:50%; background-color:#000; color:#fff; text-align:center; line-height:1.15;">
            <a href="javascript:shareCatalog();">카달로그<br>보내기</a>
        </div>

<script src="https://t1.kakaocdn.net/kakao_js_sdk/2.7.2/kakao.min.js" integrity="sha384-TiCUE00h649CAMonG018J2ujOgDKW/kVWlChEuu4jK2vxfAAD0eZxzCKakxg55G4" crossorigin="anonymous"></script>
<script> Kakao.init('2b966eb2c764be29d46d709f6d100afb'); </script>
        <script>
            function shareCatalog() {
                Kakao.Share.sendDefault({
                    objectType: 'feed',
                    content: {
                        title: '[{{Auth::user()['name']}}] 카다로그가 도착했습니다.',
                        description: '제품 정보와 업체 정보를 모두 확인 해보세요!',
                        imageUrl:"{{ env('APP_URL') }}"+'/img/logo_kakao_catalog.png',
                        link: {
                        mobileWebUrl: "{{ env('APP_URL') }}"+'/catalog/{{Auth::user()['company_idx']}}',
                        webUrl: "{{ env('APP_URL') }}"+'/catalog/{{Auth::user()['company_idx']}}',
                        },
                    },
                    buttons: [
                        {
                            title: '카다로그 보기',
                            link: {
                                mobileWebUrl: "{{ env('APP_URL') }}"+"/catalog/{{Auth::user()['company_idx']}}",
                                webUrl: "{{ env('APP_URL') }}"+"/catalog/{{Auth::user()['company_idx']}}",
                            },
                        },
                    ],
                });
            }
        </script>
    @endif
@endif
    
    @if(request()->is(['wholesaler/detail/*' ]))
        <div style="z-index:51; position:fixed; right:40px; bottom:115px; display:flex; align-items:center; justify-content:center; width:68px; height:68px; border-radius:50%; background-color:#000; color:#fff; text-align:center; line-height:1.15;">
            <a href="javascript:shareCatalog();">카달로그<br>받기</a>
        </div>

<script src="https://t1.kakaocdn.net/kakao_js_sdk/2.7.2/kakao.min.js" integrity="sha384-TiCUE00h649CAMonG018J2ujOgDKW/kVWlChEuu4jK2vxfAAD0eZxzCKakxg55G4" crossorigin="anonymous"></script>
<script> Kakao.init('2b966eb2c764be29d46d709f6d100afb'); </script>
        <script>
            function shareCatalog() {
                Kakao.Share.sendDefault({
                    objectType: 'feed',
                    content: {
                        title: '[{{$data['info']->company_name}}] 카다로그가 도착했습니다.',
                        description: '제품 정보와 업체 정보를 모두 확인 해보세요!',
                        imageUrl:"{{ env('APP_URL') }}"+'/img/logo_kakao_catalog.png',
                        link: {
                        mobileWebUrl: "{{ env('APP_URL') }}"+'/catalog/{{$data['info']->idx}}',
                        webUrl: "{{ env('APP_URL') }}"+'/catalog/{{$data['info']->idx}}',
                        },
                    },
                    buttons: [
                        {
                            title: '카다로그 보기',
                            link: {
                                mobileWebUrl: "{{ env('APP_URL') }}"+"/catalog/{{$data['info']->idx}}",
                                webUrl: "{{ env('APP_URL') }}"+"/catalog/{{$data['info']->idx}}",
                            },
                        },
                    ],
                });
            }
        </script>
@endif

<footer>
    <div class="inner">
        @if(Auth::check())
            <ul class="fnb flex">
                <li><a href="/help">고객센터</a></li>
                <li><a href="/help/faq">자주 묻는 질문</a></li>
                <li><a href="/help/notice">공지사항</a></li>
                <li><a href="/help/inquiry">1:1 문의</a></li>
                <li><a href="/help/guide">이용 가이드</a></li>
            </ul>
        @endif 
        <div class="info">
            <img src="/img/logo_gray.svg" alt="">
            <div>
                사업자등록번호 : 182-81-02804 | 대표 : 송도현<br/>
                주소 : 경기도 고양시 일산동구 산두로213번길 18 (정발산동)<br/>
                E-mail : cs@all-furn.com | Tel : 031-813-5588
            </div>
        </div>
        <ul class="bottom_link flex">
            <li><a href="/home/welcome">서비스소개</a></li>
            <li><a onclick="modalOpen('#agree01-modal')">이용약관</a></li>
            <li><a onclick="modalOpen('#agree02-modal')"><b>개인정보 처리 방침</b></a></li>
        </ul>
    </div>
</footer>

<!-- ** 페이지 로딩 ** -->
<div id="loadingContainer" style="display:none;">
    <svg width="50" viewBox="0 0 120 30" xmlns="http://www.w3.org/2000/svg" fill="rgb(255, 255, 255)" class="w-10 h-10">
        <circle cx="15" cy="15" r="15">
            <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate>
            <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate>
        </circle>
        <circle cx="60" cy="15" r="9" fill-opacity="0.3">
            <animate attributeName="r" from="9" to="9" begin="0s" dur="0.8s" values="9;15;9" calcMode="linear" repeatCount="indefinite"></animate>
            <animate attributeName="fill-opacity" from="0.5" to="0.5" begin="0s" dur="0.8s" values=".5;1;.5" calcMode="linear" repeatCount="indefinite"></animate>
        </circle>
        <circle cx="105" cy="15" r="15">
            <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate>
            <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate>
        </circle>
    </svg>
</div>
<!-- ** 페이지 로딩 끝 ** -->
