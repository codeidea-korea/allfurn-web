@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
<div id="container" class="container">
    <div class="my my-page">
        <div class="inner">
            <div class="my__container">
                {{--- 로그인한 회원의 요약 정보 ---}}
                <div class="my__top">
                    @if($user->type === 'W') {{--- 도매 유저인 경우 ---}}
                    
                    <div class="my__profile">
                        <div class="user-type ico__mybadge-wholesaler"><span class="a11y">제조/도매</span></div>
                        <div>
                            <h3 class="user-name">{{ $user->company_name }}</h3>
                            @if($user->parent_idx !== 0)
                            <p class="user-name-text">{{ $user->name }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <ul class="my__count-wrap">
                        <li>
                            <p class="text">좋아요 수</p>
                            <p class="num">{{ $user->like_count }}</p>
                        </li>
                        <li>
                            <p class="text">문의 수</p>
                            <p class="num">{{ $user->inquiry_count }}</p>
                        </li>
                        <li>
                            <p class="text">방문 수</p>
                            <p class="num">{{ $user->access_count }}</p>
                        </li>
                    </ul>
                    @elseif($user->type === 'R') {{--- 소매 유저인 경우 ---}}
                    <div class="my__profile">
                        <div class="user-type ico__mybadge-retail"><span class="a11y">소매</span></div>
                        <div>
                            <h3 class="user-name">{{ $user->company_name }}</h3>
                        </div>
                    </div>
                    @else {{--- 일반 유저인 경우 ---}}
                    <div class="my__profile">
                        <div class="user-type ico__mybadge"><span class="a11y">일반</span></div>
                        <h3 class="user-name">{{ $user->name }}</h3>
                    </div>
                    @endif
                </div>
                {{--- lnb ---}}
                <div class="my__aside">
                    <div class="content">
                        <div class="aside">
                            <h2 class="aside__title">마이 올펀</h2>
                            <div class="post-list">
                                @if(auth()->user()->type !== 'N')
                                    @if(auth()->useR()->type === 'W')
                                    <div class="post-list__item {{ $pageType === 'deal' ? 'post-list__item--active' : '' }}">
                                        <a href="/mypage/deal">거래 현황<i class="badge__new hidden" id="deal-new_badge"></i></a>
                                        <div class="ico__list-link {{ $pageType === 'deal' ? 'ico__list-link--active' : ''}}"></div>
                                    </div>
                                    @endif
                                <div class="post-list__item {{ $pageType === 'purchase' ? 'post-list__item--active' : ''}}">
                                    <a href="/mypage/purchase">주문 현황<i class="badge__new hidden" id="purchase-new_badge"></i></a>
                                    <div class="ico__list-link {{ $pageType === 'purchase' ? 'ico__list-link--active' : ''}}"></div>
                                </div>
                                <div class="post-list__line"></div>
                                @endif
                                <div class="post-list__item {{ $pageType === 'interest' ? 'post-list__item--active' : ''}}">
                                    <a href="/mypage/interest">관심 상품</a>
                                    <div class="ico__list-link {{ $pageType === 'interest' ? 'ico__list-link--active' : ''}}"></div>
                                </div>
                                <div class="post-list__item {{ $pageType === 'like' ? 'post-list__item--active' : ''}}">
                                    <a href="/mypage/like">좋아요</a>
                                    <div class="ico__list-link {{ $pageType === 'like' ? 'ico__list-link--active' : ''}}"></div>
                                </div>
                                <div class="post-list__item {{ $pageType === 'recent' ? 'post-list__item--active' : ''}}">
                                    <a href="/mypage/recent">최근 본 상품</a>
                                    <div class="ico__list-link {{ $pageType === 'recent' ? 'ico__list-link--active' : ''}}"></div>
                                </div>
                                <div class="post-list__line {{ $pageType === 'recent' ? 'post-list__item--active' : ''}}"></div>
                                @if($user->type === 'W')
                                <div class="post-list__item {{ $pageType === 'company' ? 'post-list__item--active' : ''}}">
                                    <a href="/mypage/company ">업체 관리</a>
                                    <div class="ico__list-link {{ $pageType === 'company' ? 'ico__list-link--active' : ''}}"></div>
                                </div>
                                <div class="post-list__item {{ $pageType === 'product' ? 'post-list__item--active' : ''}}">
                                    <a href="/mypage/product">상품 관리</a>
                                    <div class="ico__list-link {{ $pageType === 'product' ? 'ico__list-link--active' : ''}}"></div>
                                </div>
                                @endif
                                @if($user->parent_idx === 0)
                                <div class="post-list__item {{ in_array($pageType,['withdrawal', 'account', 'company-account', 'normal-account']) ? 'post-list__item--active' : ''}}">
                                    <a href="/mypage/account">계정 관리</a>
                                    <div class="ico__list-link {{ in_array($pageType,['withdrawal', 'account', 'company-account', 'normal-account']) ? 'ico__list-link--active' : ''}}"></div>
                                </div>
                                @endif
                            </div>
                            <div class="aside__bottom">
                                <button type="button" class="button" onclick="openModal('#modal-logout')">
                                    <div class="ico__logout"></div>
                                    <span>로그아웃</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                {{--- include body ---}}
                @include('mypage.'.$pageType)
            </div>

            {{-- 거래 확정 완료 modal --}}
            <div id="modal-deal" class="modal">
                <div class="modal__container" style="width: 350px;">
                    <div class="modal__content">
                        <div class="modal-box__container">
                            <div class="modal-box__content">
                                <div class="modal__desc">
                                    <p class="modal__text">
                                        거래가 확정되었습니다.<br>
                                        상품이 준비되면 발송 버튼을 눌러주세요.
                                    </p>
                                </div>
                                <div class="modal__util">
                                    <button type="button" onclick="location.reload();" class="modal__button"><span>확인</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- 거래 취소 modal --}}
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
                                    <button type="button" onclick="location.reload();" class="modal__button"><span>확인</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- 상품 발송 시작 modal --}}
            <div id="modal-send-start" class="modal">
                <div class="modal__container" style="width: 350px;">
                    <div class="modal__content">
                        <div class="modal-box__container">
                            <div class="modal-box__content">
                                <div class="modal__desc">
                                    <p class="modal__text">
                                        상품 발송을 시작합니다.<br>
                                        배송이 완료되면 발송 완료 버튼을 눌러주세요.
                                    </p>
                                </div>
                                <div class="modal__util">
                                    <button type="button" onclick="location.reload();" class="modal__button"><span>확인</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- 상품 발송 완료 modal --}}
            <div id="modal-send-complete" class="modal">
                <div class="modal__container" style="width: 350px;">
                    <div class="modal__content">
                        <div class="modal-box__container">
                            <div class="modal-box__content">
                                <div class="modal__desc">
                                    <p class="modal__text">
                                        발송 완료 처리되었습니다.<br>
                                        구매자가 구매 확정을 누르면 거래 상태가<br>
                                        완료 처리됩니다.
                                    </p>
                                </div>
                                <div class="modal__util">
                                    <button type="button" onclick="location.reload();" class="modal__button"><span>확인</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- 로그아웃 confirm modal --}}
            <div id="modal-logout" class="modal">
                <div class="modal__container" style="width: 350px;">
                    <div class="modal__content">
                        <div class="modal-box__container">
                            <div class="modal-box__content">
                                <div class="modal__desc">
                                    <p class="modal__text">
                                        로그아웃 하시겠습니까?
                                    </p>
                                </div>
                                <div class="modal__util">
                                    <button type="button" onclick="closeModal('#modal-logout');" class="modal__button modal__button--gray"><span>취소</span></button>
                                    <button type="button" onclick="location.href='/signout/'" class="modal__button"><span>확인</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- 주문 취소 거래 확정 불가 modal --}}
            <div id="modal-deal-error" class="modal">
                <div class="modal__container" style="width: 350px;">
                    <div class="modal__content">
                        <div class="modal-box__container">
                            <div class="modal-box__content">
                                <div class="modal__desc">
                                    <p class="modal__text">
                                        해당 주문이 취소 처리되어<br>
                                        거래 확정이 불가합니다.
                                    </p>
                                </div>
                                <div class="modal__util">
                                    <button type="button" onclick="closeModal('#modal-deal-error');" class="modal__button"><span>확인</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            setInterval(checkNewBadge, 10000);
        })
        function checkNewBadge() {
            fetch('/mypage/check/new/badge')
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error('Sever Error');
                }).then(json => {
                if (json.deal === 'Y') {
                    document.getElementById('deal-new_badge').classList.remove('hidden');
                }
                if (json.purchase === 'Y') {
                    document.getElementById('purchase-new_badge').classList.remove('hidden');
                }
            }).catch(error => {

            })
        }
    </script>
@endpush
