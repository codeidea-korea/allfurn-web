@extends('layouts.app_m')

@php

if(strpos($_SERVER['REQUEST_URI'], 'mypage/interest')) {
    $header_depth = 'mypage';
    $top_title = '';
    $only_quick = 'yes';
    $header_banner = 'hidden';
} else if(strpos($_SERVER['REQUEST_URI'], 'mypage/like')) {
    $header_depth = 'mypage';
    $top_title = '좋아요 업체';
    $only_quick = '';
    $header_banner = 'hidden';
} else {
    $header_depth = 'mypage';
    $top_title = '마이올펀';
    $only_quick = 'yes';
    $header_banner = '';
}

@endphp

@section('content')
@include('layouts.header_m')

@php
    $tPoint = 0;
    if( !empty( $point ) ) {
        foreach( $point AS $p ) {
            if( $p->type == 'A' )
                $tPoint = $tPoint + $p->score;
            else
                $tPoint = $tPoint - $p->score;
        }
    }
@endphp

    @if(in_array($pageType, [
        'deal', 'deal-company', 'purchase',
        'interest', 'like',
        'company', 'company-edit',
        'product',
        'account', 'company-account',
        'estimate', 'estimate-response-multi',
        'estimate-request', 'estimate-request-check', 'estimate-request-send',
        'estimate-response', 'estimate-check', 'estimate-response-check', 'estimate-response-send',
        'order-check',
        'recent'
    ]))
        @include('m.mypage.'.$pageType)
    @else
        <script>
            function callLogin() {
                var jsonStr = '{ "type" : "login", "accessToken" : "{{$xtoken}}"}'; // 'X-CSRF-TOKEN': '{{csrf_token()}}'

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
                    localStorage.setItem('accessToken', "{{$xtoken}}");
                    if(isMobile.any()) {
                        if(isMobile.Android()) {
                        // AppWebview 라는 모듈은 android 웹뷰에서 설정하게 됩니다.
                        window.AppWebview.postMessage(jsonStr);
                        } else if (isMobile.iOS()) {
                        window.webkit.messageHandlers.AppWebview.postMessage(jsonStr);
                        }
                    }
                } catch (e){
                console.log(e)
                }
	    }

            function signout(){
                localStorage.removeItem('accessToken');
                location.href='/signout';
            }

            callLogin();
        </script>





        <div id="content">
            <div class="my_top_area">
                @if($user -> type === 'W')
                <div class="profile flex gap-4 items-center">
                    <img src="/img/mypage/ws_profile.png" alt="" />
                    {{-- <a href="javascript: ;"> --}}
                        <div class="flex items-center">
                            <p class="profile_id">{{ $user -> company_name }}</p>
                            @if($user -> parent_idx !== 0)
                            <p class="user-name-text">{{ $user -> name }}</p>
                            @endif
                            {{-- <svg class="w-8 h-8"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg> --}}
                        </div>
                    {{-- </a> --}}
                </div>
                <div class="status_zone flex gap-3.5 items-center">
                    <div class="flex items-center flex-col ">
                        <div>좋아요 수</div>
                        <div class="font-bold text-base">{{ $user -> like_count }}</div>
                    </div>
                    <p class="line"></p>
                    <div class="flex items-center flex-col gap-1">
                        <div>문의 수</div>
                        <div class="font-bold text-base">{{ $user -> inquiry_count }}</div>
                    </div>
                    <p class="line"></p>
                    <div class="flex items-center flex-col gap-1">
                        <div>방문 수</div>
                        <div class="font-bold text-base">{{ $user -> access_count }}</div>
                    </div>
                </div>
                @elseif($user -> type === 'R')
                <div class="profile flex gap-4 items-center">
                    <img src="/img/mypage/s_profile.png" alt="" />
                    {{-- <a href="javascript: ;"> --}}
                        <div class="flex items-center">
                            <p class="profile_id">{{ $user -> company_name ?? $user -> name }}</p>
                            {{-- <svg class="w-8 h-8"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg> --}}
                        </div>
                    {{-- </a> --}}
                </div>
                @elseif($user -> type === 'N')
                <div class="profile flex gap-4 items-center">
                    <img src="/img/mypage/n_profile.png" alt="" />
                    {{-- <a href="javascript: ;"> --}}
                        <div class="flex items-center">
                            <p class="profile_id">{{ $user -> company_name == null || $user -> company_name == '' ? $user -> name : $user -> company_name }}</p>
                            {{-- <svg class="w-8 h-8"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg> --}}
                        </div>
                    {{-- </a> --}}
                </div>
                @else
                <div class="profile flex gap-4 items-center">
                    <img src="/img/mypage/r_profile.png" alt="" />
                    {{-- <a href="javascript: ;"> --}}
                        <div class="flex items-center">
                            <p class="profile_id">{{ $user -> name }}</p>
                            {{-- <svg class="w-8 h-8"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg> --}}
                        </div>
                    {{-- </a> --}}
                </div>
                @endif
                <div class="state_box">
                    @if(Auth::user()['type'] == 'W')
                        <a href="javascript:gotoLink('/mypage/deal');" class="tit flex items-center">
                            <p>요청받은 견적서 현황</p>
                            <svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg>
                        </a>
                        <ul>
                            <li><a href="javascript:gotoLink('/mypage/responseEstimate?status=N');">요청받은 견적<b class="txt-primary">{{ $info[0] -> count_res_n }}</b></a></li>
                            <li><a href="javascript:gotoLink('/mypage/responseEstimate?status=R');">보낸 견적 <b>{{ $info[0] -> count_res_r }}</b></a></li>
                            <li><a href="javascript:gotoLink('/mypage/responseEstimate?status=O');">주문서 수<b class="txt-primary">{{ $info[0] -> count_res_o }}</b></a></li>
                            <li><a href="javascript:gotoLink('/mypage/responseEstimate?status=F');">확인/완료<b>{{ $info[0] -> count_res_f }}</b></a></li>
                        </ul>
                    @endif
                    <a href="javascript:gotoLink('/mypage/purchase');" class="tit flex items-center">
                        <p>요청한 견적서 현황</p>
                        <svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg>
                    </a>
                    <ul>
                        <li><a href="javascript:gotoLink('/mypage/requestEstimate?status=N');">요청한 견적<b>{{ $info[0] -> count_req_n }}</b></a></li>
                        <li><a href="javascript:gotoLink('/mypage/requestEstimate?status=R);">받은 견적<b class="txt-primary">{{ $info[0] -> count_req_r }}</b></a></li>
                        <li><a href="javascript:gotoLink('/mypage/requestEstimate?status=O');">주문서 수<b class="txt-primary">{{ $info[0] -> count_req_o }}</b></a></li>
                        <li><a href="javascript:gotoLink('/mypage/requestEstimate?status=F');">확인/완료<b>{{ $info[0] -> count_req_f }}</b></a></li>
                    </ul>
                </div>
                <div class="my_point_area flex items-center justify-between">
                    <p>올펀 포인트</p>
                    <div>
                        <span class="text-base main_color font-bold">{{number_format( $tPoint )}}</span>
                        <span class="font-bold">P</span>
                    </div>
                    <a class="fs14 flex items-center txt-gray fs12 mt-3" href="javascript: ;"  onclick="callBackDefindedUserType(() => {modalOpen('#points_details')});">포인트 내역 <svg class="w-4 h-4 opacity-60"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></a>
                </div>
            </div>
            <ul class="my_menu_list mt-5">
                <li class="bottom_type">
                </li>
                <li>
                    <a href="javascript:gotoLink('/mypage/interest');" class="flex p-4 justify-between">
                        <p>좋아요 상품</p>
                        <div class="flex items-center">
                            <p class="text-sm">{{ $likeProductCount }}개</p>
                            <svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:gotoLink('/mypage/like');" class="flex p-4 justify-between">
                        <p>좋아요 업체</p>
                        <div class="flex items-center">
                            <p class="text-sm">{{ $likeCompanyCount }}개</p>
                            <svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:gotoLink('/mypage/recent');" class="flex p-4 justify-between">
                        <p>최근 본 상품</p>
                        <div class="flex items-center">
                            <p class="text-sm">{{ $recentlyViewedProductCount }}개</p>
                            <svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:gotoLink('/message');" class="flex p-4 justify-between bottom_type">
                        <p>문의 내역</p>
                        <div class="flex items-center">
                            <p class="text-sm main_color">{{ $inquiryCount }}건</p>
                            <svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg>
                        </div>
                    </a>
                </li>
                <li class="bottom_type together">
                    <a id="kakaotalk-sharing-btn" href="javascript:callBackDefindedUserType(() => {shareMessage();});">
                        <b>함께 올펀을 사용해보세요!</b>
                        <span class="flex items-center">
                            올펀 알려주기
                            <svg class="w-5 h-5"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg>
                        </span>
                    </a>
                </li>
                @if($user -> type === 'W')
                <li>
                    <a href="javascript:gotoLink('/mypage/company');" class="flex p-4 justify-between">
                        <p>홈페이지 관리</p>
                        <svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg>
                    </a>
                </li>
                <li>
                    <a href="javascript:gotoLink('/mypage/product?order=DESC');" class="flex p-4 justify-between">
                        <p>상품 등록 관리</p>
                        <svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg>
                    </a>
                </li>
                @endif
                <li>
                    <a href="javascript:gotoLink('/mypage/estimateInfo');" class="flex p-4 justify-between">
                        <p>견적서 관리 / <br/><span class="main_color">견적서 보내기</span></p>
                        <div class="flex items-center">
                            <!-- 신규알람 건수 추가 -->
                            @if(countUnCheckedMyAllFurn() > 0)
                            <p class="text-sm main_color">{{ countUnCheckedMyAllFurn() }}건</p>
                            @endif
                            <svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg>
                        </div>
                    </a>
                </li>
                {{--<!--
                <li class="">
                    <a href="javascript: ;" class="flex p-4 justify-between">
                        <p>사업자등록증 등록</p>
                        <svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg>
                    </a>
                </li>
                -->--}}
                <li>
                    <a href="/mypage/account" class="flex p-4 justify-between bottom_type">
                        <p>계정 관리</p>
                        <svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg>
                    </a>
                </li>
                <li>
                    <a href="/help" class="flex p-4 justify-between">
                        <p>고객센터</p>
                        <svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg>
                    </a>
                </li>
                <li>
                    <a href="javascript: ;" class="flex p-4 justify-between" onclick="signout()">
                        <p>로그아웃</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-6 h-6"><path d="m9 18 6-6-6-6"/></svg>
                    </a>
                </li>
                {{-- <li>
                    <a href="#" class="flex p-4 justify-between">
                        <p>설정</p>
                        <svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg>
                    </a>
                </li> --}}
            </ul>
        </div>

        <!-- 포인트 내역 추가 모달-->
        <div class="modal" id="points_details">
            <div class="modal_bg" onclick="modalClose('#points_details')"></div>
            <div class="modal_inner modal-md" style="width:480px;">
                <div class="modal_body filter_body">
                    <div class="py-2">
                        <p class="text-lg font-bold text-left">포인트 내역</p>
                        <div class="py-5">
                        <table class="my_table table-auto w-full">
                                <thead>
                                    <tr>
                                        <th>형태</th>
                                        <th>내용</th>
                                        <th>포인트</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                @foreach( $point AS $p )
                                    @if( $p->type == 'A' )
                                        <tr>
                                            <td>적립</td>
                                            <td>{{$p->reason}}</td>
                                            <td class="text-blue-500 font-medium">+{{number_format( $p->score )}}</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td>감소</td>
                                            <td>{{$p->reason}}</td>
                                            <td class="text-primary font-medium">-{{number_format( $p->score )}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                        </table>
                        
                        <div class="bg-stone-800 px-3 py-2 font-bold text-white flex items-center justify-between rounded-sm mt-3">
                                <p>총 포인트</p>
                                <p class="text-lg">{{number_format( $tPoint )}}</p>
                        </div>
                        </div>
                        <div class="flex justify-center mt-4">
                            <button class="btn btn-primary w-full" onclick="modalClose('#points_details')">확인</button>
                        </div> 
                    </div>
                </div>
            </div>
        </div>

        <script src="/js/jquery-1.12.4.js?{{ date('Ymdhis') }}"></script>
        <script>
            function openModal(name) {
                $(`${name}`).css('display', 'block');
                $('body').css('overflow', 'hidden');
            }
        </script>

        <script src="https://t1.kakaocdn.net/kakao_js_sdk/2.7.1/kakao.min.js" integrity="sha384-kDljxUXHaJ9xAb2AzRd59KxjrFjzHa5TAoFQ6GbYTCAG0bjM55XohjjDT7tDDC01" crossorigin="anonymous"></script>
        <script>
        Kakao.init('2b966eb2c764be29d46d709f6d100afb'); 
        function shareMessage() {
            Kakao.Share.sendDefault({
                objectType: 'feed',
                content: {
                    title: '우리 올펀으로 편하게 거래해요!\n가구 사업자용 B2B 플랫폼',
                    description: '상품 등록으로, 매장 거래처 확보하세요!',
                    imageUrl:'{{ env("APP_URL") }}/img/logo.png',
                    link: {
                    mobileWebUrl: 'https://developers.kakao.com',
                    webUrl: 'https://developers.kakao.com',
                    },
                },
                buttons: [
                    {
                        title: '올펀에서 보기',
                        link: {
                            mobileWebUrl: "{{ env('APP_URL') }}",
                            webUrl: "{{ env('APP_URL') }}",
                        },
                    },
                ],
            });
        }
        </script>
    @endif
@endsection
