@extends('layouts.app_m')

@php

if(strpos($_SERVER['REQUEST_URI'], 'mypage/interest')) {
    $header_depth = '';
    $top_title = '';
    $only_quick = 'yes';
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

@if(in_array($pageType, ['interest', 'like']))
    @include('m.mypage.'.$pageType)
@else
<script>
        function callLogin(){

            var jsonStr = '{ "type" : "login", "accessToken" : "{{xtoken}}"}'; // 'X-CSRF-TOKEN': '{{csrf_token()}}'

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
        callLogin();
    </script>



<div id="content">
    <div class="my_top_area">
        @if($user -> type === 'W')
        <div class="profile flex gap-4 items-center">
            <img src="/img/mypage/ws_profile.png" alt="" />
            <a href="javascript: ;">
                <div class="flex items-center">
                    <p class="profile_id">{{ $user -> company_name }}</p>
                    @if($user -> parent_idx !== 0)
                    <p class="user-name-text">{{ $user -> name }}</p>
                    @endif
                    <svg class="w-8 h-8"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg>
                </div>
            </a>
        </div>
        @endif
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
        
        <div class="state_box">
            <a href="./my_ws_sales_status01.php" class="tit flex items-center">
                <p>판매 현황</p>
                <svg class="w-6 h-6"><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg>
            </a>
            <ul>
                <li><a href="javascsript:;">견적 요청 <b class="txt-primary">17</b></a></li>
                <li><a href="javascsript:;">견적 요청 <b>8</b></a></li>
                <li><a href="javascsript:;">주문서 수 <b class="txt-primary">6</b></a></li>
                <li><a href="javascsript:;">주문 확인 <b>51</b></a></li>
            </ul>

            <a href="./my_ws_purchase_status.php" class="tit flex items-center">
                <p>구매 현황</p>
                <svg class="w-6 h-6"><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg>
            </a>
            <ul>
                <li><a href="javascsript:;">견적 요청 <b>21</b></a></li>
                <li><a href="javascsript:;">받은 견적서 <b class="txt-primary">8</b></a></li>
                <li><a href="javascsript:;">주문서 수 <b class="txt-primary">7</b></a></li>
                <li><a href="javascsript:;">주문 완료 <b>51</b></a></li>
            </ul>
        </div>

        <div class="my_point_area flex items-center justify-between">
            <p>올펀 포인트</p>
            <div>
                <span class="text-base main_color font-bold">350,000</span>
                <span class="font-bold">P</span>
            </div>
            <a class="fs14 flex items-center txt-gray fs12 mt-3" href="javascript:;"  onclick="modalOpen('#points_details')">포인트 내역 <svg class="w-4 h-4 opacity-60"><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></a>
        </div>
            
    </div>



    <ul class="my_menu_list mt-5">
        <li class="bottom_type">
        </li>
        <li>
            <a href="/mypage/interest" class="flex p-4 justify-between">
                <p>좋아요 상품</p>
                <div class="flex items-center">
                    <p class="text-sm">52개</p>
                    <svg class="w-6 h-6"><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg>
                </div>
            </a>
        </li>
        <li>
            <a href="./my_ws_like_company.php" class="flex p-4 justify-between">
                <p>좋아요 업체</p>
                <div class="flex items-center">
                    <p class="text-sm">27개</p>
                    <svg class="w-6 h-6"><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg>
                </div>
            </a>
        </li>
        <li>
            <a href="./my_ws_recent_products.php" class="flex p-4 justify-between">
                <p>최근 본 상품</p>
                <div class="flex items-center">
                    <p class="text-sm">124개</p>
                    <svg class="w-6 h-6"><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg>
                </div>
            </a>
        </li>
        <li>
            <a href="./inquiry.php" class="flex p-4 justify-between bottom_type">
                <p>문의 내역</p>
                <div class="flex items-center">
                    <p class="text-sm main_color">5건</p>
                    <svg class="w-6 h-6"><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg>
                </div>
            </a>
        </li>
        <li class="bottom_type together">
            <a href="javascript:;" >
                <b>함께 올펀을 사용해보세요!</b>
                <span class="flex items-center">
                    올펀 알려주기
                    <svg class="w-5 h-5"><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg>
                </span>
            </a>
        </li>
        <li>
            <a href="./my_ws_homepage_mng.php" class="flex p-4 justify-between">
                <p>홈페이지 관리</p>
                <svg class="w-6 h-6"><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg>
            </a>
        </li>
        <li>
            <a href="./my_ws_product_regist_mng.php" class="flex p-4 justify-between">
                <p>상품 등록 관리</p>
                <svg class="w-6 h-6"><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg>
            </a>
        </li>
        <li>
            <a href="./my_ws_estimate01.php" class="flex p-4 justify-between">
                <p>견적서 관리 / <span class="main_color">견적서 보내기</span></p>
                <svg class="w-6 h-6"><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg>
            </a>
        </li>
        <li class="">
            <a href="javascript:;" class="flex p-4 justify-between">
                <p>사업자등록증 등록</p>
                <svg class="w-6 h-6"><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg>
            </a>
        </li>
        <li>
            <a href="./my_ws_account_mng.php" class="flex p-4 justify-between bottom_type">
                <p>계정관리</p>
                <svg class="w-6 h-6"><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg>
            </a>
        </li>
        <li>
            <a href="./customer_center.php" class="flex p-4 justify-between">
                <p>고객센터</p>
                <svg class="w-6 h-6"><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg>
            </a>
        </li>
        <li>
            <a href="javascript: ;" class="flex p-4 justify-between" onclick="location.href='/signout';">
                <p>로그아웃</p>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-6 h-6"><path d="m9 18 6-6-6-6"/></svg>
            </a>
        </li>
        <li>
            <a href="./setting.php" class="flex p-4 justify-between">
                <p>설정</p>
                <svg class="w-6 h-6"><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg>
            </a>
        </li>
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
                            <tr>
                                <td>적립</td>
                                <td>포인트 적립</td>
                                <td class="text-blue-500 font-medium">+10,000</td>
                            </tr>
                            <tr>
                                <td>감소</td>
                                <td>포인트 사용</td>
                                <td class="text-primary font-medium">-5,000</td>
                            </tr>
                        </tbody>
                   </table>
                   
                   <div class="bg-stone-800 px-3 py-2 font-bold text-white flex items-center justify-between rounded-sm mt-3">
                        <p>총 포인트</p>
                        <p class="text-lg">5,000</p>
                   </div>
                </div>
                <div class="flex justify-center mt-4">
                    <button class="btn btn-primary w-full" onclick="modalClose('#points_details')">확인</button>
                </div> 
            </div>
        </div>
    </div>
</div>




    <script>
        function openModal(name) {
            $(`${name}`).css('display', 'block');
            $('body').css('overflow', 'hidden');
        }
    </script>
@endif
@endsection
