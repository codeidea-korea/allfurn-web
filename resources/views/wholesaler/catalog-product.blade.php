<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ALL FURN</title>
    <link rel="stylesheet" href="/css/font.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" /> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> -->
    <link rel="stylesheet" href="/css/flatpickr.min.css">
    <link rel="stylesheet" href="/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="/css/common.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/rubin.css">

    <script src="/js/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script> -->
    <script src="/js/swiper-bundle.min.js"></script>
    <script src="/js/common.js"></script>

    <script src="/js/flatpickr.js"></script>
    <script src="/js/flatpickr_ko.js"></script>

    <!-- <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ko.js"></script> -->
</head>

<body>

<link rel="stylesheet" href="{{ env('APP_URL') }}/css/catalog.css">

<div id="catalog">
    <div class="bot_quick">
        <button type="button" class="tab_btn active" onclick="history.back();">판매상품</button>
        <button type="button" class="tab_btn" onclick="localStorage.setItem('p', 1);history.back();">업체소개</button>
        <button type="button" onClick="shareMessage();"><svg><use xlink:href="{{ env('APP_URL') }}/img/icon-defs.svg#share"></use></svg>공유하기</button>
    </div>


    <!-- <div class="catalog_txt">금주의 <span>추</span><span>천</span>상품<br/> 빠르게 받아 보세요!</div> -->

    <button type="button" class="back_btn">
        <svg viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>    
        뒤로가기
    </button>

    <div class="logo">
        <div>
            <span>Catalog</span>
            <p>{{$data['info']->company_name}}</p>
        </div>
    </div>
    
    <div class="catalog_content">
        <div class="company_img">
            <img src="@if($data['info']->imgUrl != null) {{$data['info']->imgUrl}} @else /img/profile_img.svg @endif" class="w-[130px] h-[130px] object-cover rounded-full border-2 border-white" alt="">
        </div>

        <div class="tab_content">

            <!-- 상품 상세 -->
            <div id="product_detail" style="display:block;">
            <?php echo $data['detail']; ?>
            </div>
        </div>

        <div class="company_detail">
            <div class="detail">
                <div class="top_info">
                    <div class="tit">
                        <img src="{{ env('APP_URL') }}/img/logo.svg" alt="">
                        <p>가구 도매 플랫폼</p>
                    </div>
                    <div class="txt">
                        <p>매일 새로운 가구를 올펀에서 무료로 만나보세요!</p>
                        <a href="{{ env('APP_URL') }}/wholesaler/detail/{{$data['info']->idx}}" class="btn btn-primary">더 많은 가구 정보 보러가기</a>
                    </div>
                </div>
                <div class="info">
                    <table>
                        <colgroup>
                            <col width="100px">
                            <col width="*">
                        </colgroup>
                        <tbody>
                            @if($data['info']->owner_name)
                                <tr>
                                    <th>대표자</th>
                                    <td>{{$data['info']->owner_name}}</td>
                                </tr>
                            @endif
                            @if($data['info']->phone_number)
                                <tr>
                                    <th>대표전화</th>
                                    <td>@php echo preg_replace('/^(\d{2,3})(\d{3,4})(\d{4})$/', '$1-$2-$3', $data['info']->phone_number); @endphp</td>
                                </tr>
                            @endif
                            @if ($data['info']->work_day)
                                <tr>
                                    <th>근무일</th>
                                    <td>{{$data['info']->work_day}}</td>
                                </tr>
                            @endif
                            @if ($data['info']->how_order)
                                <tr>
                                    <th>발주방법</th>
                                    <td>{{$data['info']->how_order}}</td>
                                </tr>
                            @endif
                            @if ($data['info']->manager)
                                <tr>
                                    <th>담당자</th>
                                    <td>{{$data['info']->manager}}</td>
                                </tr>
                            @endif
                            @if ($data['info']->manager_number)
                                <tr>
                                    <th>담당자연락처</th>
                                    <td>{{$data['info']->manager_number}}</td>
                                </tr>
                            @endif
                            @if ($data['info']->website)
                                <tr>
                                <th>웹사이트</th>
                                <td><a @if(strpos($data['info']->website, 'http') !== false) href="{{$data['info']->website}}" target="_blank" @endif>{{$data['info']->website}}</a></td>    
                            </tr>
                            @endif
                            @if ($data['info']->business_address)
                                <tr>
                                    <th>주소</th>
                                    <td>{{$data['info']->business_address .' '.$data['info']->business_address_detail}}</td>    
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://t1.kakaocdn.net/kakao_js_sdk/2.7.2/kakao.min.js" integrity="sha384-TiCUE00h649CAMonG018J2ujOgDKW/kVWlChEuu4jK2vxfAAD0eZxzCKakxg55G4" crossorigin="anonymous"></script>
<script> Kakao.init('2b966eb2c764be29d46d709f6d100afb'); </script>

<script>
    function shareMessage() {
        Kakao.Share.sendDefault({
            objectType: 'feed',
            content: {
                title: '[{{$data['info']->company_name}}] 카다로그가 도착했습니다.',
                description: '제품 정보와 업체 정보를 모두 확인 해보세요!',
                imageUrl:'https://all-furn.com/img/logo_kakao_catalog.png',
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
    $('.back_btn').off().on('click', function(){
        localStorage.setItem('allfurn-catalog-list', null);
        history.back();
    });
</script>

</body>
</html>
