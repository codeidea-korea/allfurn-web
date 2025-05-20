@extends('layouts.app')

@section('content')
@include('layouts.header')
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
<script src="https://t1.kakaocdn.net/kakao_js_sdk/2.7.1/kakao.min.js" integrity="sha384-kDljxUXHaJ9xAb2AzRd59KxjrFjzHa5TAoFQ6GbYTCAG0bjM55XohjjDT7tDDC01" crossorigin="anonymous"></script>
<script> Kakao.init('2b966eb2c764be29d46d709f6d100afb'); </script>

<div id="content">
    <div class="my_top_area inner flex items-center justify-between">
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
        <div class="flex items-center gap-5">
            <div class="status_zone flex gap-3.5 items-center">
                <div class="flex items-center flex-col gap-1">
                    <div>좋아요 수</div>
                    <div class="font-bold text-2xl">{{ $user -> like_count }}</div>
                </div>
                <p class="line"></p>
                <div class="flex items-center flex-col gap-1">
                    <div>문의 수</div>
                    <div class="font-bold text-2xl">{{ $user -> inquiry_count }}</div>
                </div>
                <p class="line"></p>
                <div class="flex items-center flex-col gap-1">
                    <div>방문 수</div>
                    <div class="font-bold text-2xl">{{ $user -> access_count }}</div>
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
            <div class="my_point_area flex items-center justify-between">
                <p>올펀 포인트</p>
                <div>
                    <span class="text-2xl main_color font-bold">{{number_format( $tPoint )}}</span>
                    <span class="font-bold">P</span>
                </div>
                <a class="fs14 flex items-center txt-gray mt-2" href="javascript:;" onclick="modalOpen('#points_details')">포인트 내역 <svg class="w-4 h-4 opacity-60"><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></a>
            </div>
        </div>
    </div>
    <div class="flex inner gap-10 mb-[100px]">
        <div>
            <h3 class="text-xl font-bold">마이올펀</h3>
            <ul class="my_menu_list mt-5">
                    @if(auth() -> user() -> type === 'W')
                    <li class="{{ $pageType === 'deal' ? 'active' : '' }}">
                        <a href="javascript:gotoLink('/mypage/deal');" class="flex p-4 justify-between">
                            <p>요청받은 견적서 현황</p>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-6 h-6"><path d="m9 18 6-6-6-6"/></svg>
                        </a>
                    </li>
                    @endif
                <li class="{{ $pageType === 'purchase' ? 'active' : ''}}">
                    <a href="javascript:gotoLink('/mypage/purchase');" class="flex p-4 justify-between border_b">
                        <p>요청한 견적서 현황</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-6 h-6"><path d="m9 18 6-6-6-6"/></svg>
                    </a>
                </li>
                <li class="{{ $pageType === 'interest' ? 'active' : ''}}">
                    <a href="javascript:gotoLink('/mypage/interest');" class="flex p-4 justify-between">
                        <p>좋아요 상품</p>
                        <div class="flex items-center">
                            <p class="text-sm">{{ $likeProductCount }}개</p>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-6 h-6"><path d="m9 18 6-6-6-6"/></svg>
                        </div>
                    </a>
                </li>
                <li class="{{ $pageType === 'like' ? 'active' : ''}}">
                    <a href="javascript:gotoLink('/mypage/like');" class="flex p-4 justify-between">
                        <p>좋아요 업체</p>
                        <div class="flex items-center">
                            <p class="text-sm">{{ $likeCompanyCount }}개</p>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-6 h-6"><path d="m9 18 6-6-6-6"/></svg>
                        </div>
                    </a>
                </li>
                <li class="{{ $pageType === 'recent' ? 'active' : ''}}">
                    <a href="javascript:gotoLink('/mypage/recent');" class="flex p-4 justify-between">
                        <p>최근 본 상품</p>
                        <div class="flex items-center">
                            <p class="text-sm">{{ $recentlyViewedProductCount }}개</p>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-6 h-6"><path d="m9 18 6-6-6-6"/></svg>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:gotoLink('/message');" class="flex p-4 justify-between border_b">
                        <p>문의 내역</p>
                        <div class="flex items-center">
                            <p class="text-sm main_color">{{ $inquiryCount }}건</p>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-6 h-6"><path d="m9 18 6-6-6-6"/></svg>
                        </div>
                    </a>
                </li>
                @if($user -> type === 'W')
                <li class="{{ $pageType === 'company' ? 'active' : ''}}">
                    <a href="javascript:gotoLink('/mypage/company');" class="flex p-4 justify-between">
                        <p>홈페이지 관리</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-6 h-6"><path d="m9 18 6-6-6-6"/></svg>
                    </a>
                </li>
                @endif
                <li class="{{ $pageType === 'product' ? 'active' : ''}}">
                    <a href="{{ $user -> type === 'W' ? "javascript:gotoLink('/mypage/product?order=DESC');" : "javascript:requiredUserGrade(['W']);" }}" class="flex p-4 justify-between">
                        <p>상품 등록 관리</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-6 h-6"><path d="m9 18 6-6-6-6"/></svg>
                    </a>
                </li>
                <li class="{{ $pageType === 'estimate' ? 'active' : ''}}">
                    <a href="{{ $user -> type === 'W' || $user -> type === 'R' || $user -> type === 'N' ? "javascript:gotoLink('/mypage/estimateInfo');" : "javascript:requiredUserGrade(['R','W','N']);" }}" class="flex p-4 justify-between">
                        <p>견적서 관리 /<br/> <span class="main_color">견적서 보내기</span></p>
                        
                        <div class="flex items-center">
                            @if(countUnCheckedMyAllFurn() > 0)
                            <p class="text-sm main_color">{{ countUnCheckedMyAllFurn() }}건</p>
                            @endif
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-6 h-6"><path d="m9 18 6-6-6-6"></path></svg>
                        </div>
                    </a>
                </li>
                @if($user -> parent_idx === 0)
                <li class="{{ in_array($pageType,['withdrawal', 'account', 'company-account', 'normal-account']) ? 'active' : ''}}">
                    <a href="/mypage/account" class="flex p-4 justify-between border_b">
                        <p>계정 관리</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-6 h-6"><path d="m9 18 6-6-6-6"/></svg>
                    </a>
                </li>
                @endif
                <li>
                    <a href="/help" class="flex p-4 justify-between">
                        <p>고객센터</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-6 h-6"><path d="m9 18 6-6-6-6"/></svg>
                    </a>
                </li>
                <li>
                    <a href="javascript: ;" class="flex p-4 justify-between" onclick="location.href='/signout';">
                        <p>로그아웃</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-6 h-6"><path d="m9 18 6-6-6-6"/></svg>
                    </a>
                </li>
            </ul>
            <a onclick="shareMessage()" class="my_small_b w-full flex p-4 bg_main justify-between items-center mt-5">
                <div>
                    <p class="text-white">함께 올펀을 사용해보세요!</p>
                    <p class="text-sm">올펀 알려주기</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-6 h-6"><path d="m9 18 6-6-6-6"/></svg>
            </a>
        </div>

        {{--- Include Body ---}}
        @include('mypage.'.$pageType)

        {{-- 거래 확정 완료 Modal --}}
        <div id="modal-deal" class="modal">
            <div class="modal__container" style="width: 350px;">
                <div class="modal__content">
                    <div class="modal-box__container">
                        <div class="modal-box__content">
                            <div class="modal__desc">
                                <p class="modal__text">
                                    거래가 확정되었습니다.<br />
                                    상품이 준비되면 발송 버튼을 눌러주세요.
                                </p>
                            </div>
                            <div class="modal__util">
                                <button type="button" class="modal__button" onClick="location.reload();"><span>확인</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- 거래 취소 Modal --}}
        <div id="modal-cancel" class="modal">
            <div class="modal__container" style="width: 350px;">
                <div class="modal__content">
                    <div class="modal-box__container">
                        <div class="modal-box__content">
                            <div class="modal__desc">
                                <p class="modal__text">
                                    거래가 취소되었습니다.
                                </p>
                            </div>
                            <div class="modal__util">
                                <button type="button" class="modal__button" onClick="location.reload();"><span>확인</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- 상품 발송 시작 Modal --}}
        <div id="modal-send-start" class="modal">
            <div class="modal__container" style="width: 350px;">
                <div class="modal__content">
                    <div class="modal-box__container">
                        <div class="modal-box__content">
                            <div class="modal__desc">
                                <p class="modal__text">
                                    상품 발송을 시작합니다.<br />
                                    배송이 완료되면 발송 완료 버튼을 눌러주세요.
                                </p>
                            </div>
                            <div class="modal__util">
                                <button type="button" class="modal__button" onClick="location.reload();"><span>확인</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- 상품 발송 완료 Modal --}}
        <div id="modal-send-complete" class="modal">
            <div class="modal__container" style="width: 350px;">
                <div class="modal__content">
                    <div class="modal-box__container">
                        <div class="modal-box__content">
                            <div class="modal__desc">
                                <p class="modal__text">
                                    발송 완료 처리되었습니다.<br />
                                    구매자가 구매 확정을 누르면 거래 상태가<br />
                                    완료 처리됩니다.
                                </p>
                            </div>
                            <div class="modal__util">
                                <button type="button" class="modal__button" onClick="location.reload();"><span>확인</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- 로그아웃 Modal --}}
        <div id="modal-logout" class="modal">
            <div class="modal__container" style="width: 350px;">
                <div class="modal__content">
                    <div class="modal-box__container">
                        <div class="modal-box__content">
                            <div class="modal__desc">
                                <p class="modal__text">
                                    로그아웃을 하시겠습니까?
                                </p>
                            </div>
                            <div class="modal__util">
                                <button type="button" class="modal__button modal__button--gray" onClick="closeModal('#modal-logout');"><span>취소</span></button>
                                <button type="button" class="modal__button" onClick="location.href='/signout/'"><span>확인</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- 주문 취소 > 거래 확정 불가 Modal --}}
        <div id="modal-deal-error" class="modal">
            <div class="modal__container" style="width: 350px;">
                <div class="modal__content">
                    <div class="modal-box__container">
                        <div class="modal-box__content">
                            <div class="modal__desc">
                                <p class="modal__text">
                                    해당 주문이 취소 처리되어<br />
                                    거래 확정이 불가합니다.
                                </p>
                            </div>
                            <div class="modal__util">
                                <button type="button" class="modal__button" onClick="closeModal('#modal-deal-error');"><span>확인</span></button>
                            </div>
                        </div>
                    </div>
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
@endsection
