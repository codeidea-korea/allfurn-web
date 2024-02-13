@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
<div id="container" class="container my-page my-detail" style="min-height: 100%;">
    <div class="inner">
        <div class="contents">
            <div class="blank"></div>
            <div class="my-detail__head">
                <p class="my-detail__breadcrumbs">거래 현황 > 거래 상세 > 거래 취소</p>
                <p class="my-detail__title">거래 취소</p>
                <div class="date" style="margin-top: 0;">
                    <p>주문번호 {{ isset($orderGroupCode) ? $orderGroupCode : $orderCode }}</p>
                    <p>주문일자 {{ $orders[0]->reg_time }}</p>
                </div>
            </div>
            <div class="my-detail__content">
                <div class="my-detail__order my-detail__order-cancle order">
                    <div class="my-detail__list">
                        @foreach($orders as $order)
                        <div class="my-detail__item">
                            <div class="info">
                                <div>
                                    <span class="image" style="background-image: url('{{ $order->product_image }}')"></span>
                                    <div class="info__wrap">
                                        <p class="title">{{ $order->product_name }}</p>
                                        <p class="type">
                                            @foreach(json_decode($order->option_json, true) as $option)
                                                {{ $option['name'] }}: {{ $option['value'] }} {{ !$loop->last ? '/' : '' }}
                                            @endforeach
                                        </p>
                                        <p class="price">{{ $order->price_text ?: number_format($order->product_price) . '원' }}</p>
                                        <p class="count">{{ $order->count }}개</p>
                                    </div>
                                </div>
                            </div>
                            <div class="description">
                                <div>
                                    <p class="description__title">배송 방법</p>
                                    <p class="description__text">
                                        <span> {{ $order->p_delivery_info }}</span>
                                    </p>
                                </div>
                                <div>
                                    <p class="description__title">결제 방식</p>
                                    <p class="description__text">
                                        <span>{{ $order->p_pay_notice }}</span>
                                    </p>
                                </div>
                                <div>
                                    <p class="description__title">주문 금액</p>
                                    <p class="description__text">
                                        <span>{{ $order->price_text ?: number_format($order->price) . '원' }}</span>
                                    </p>
                                </div>
                                <div>
                                    <p class="description__title">업체명</p>
                                    <p class="description__text">
                                        <span>{{ $order->company_name }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="my-detail__request">
                        <p>{{ $orders[0]->memo }}</p>
                    </div>
                </div>
                <div class="my-detail__cancle order">
                    <div class="order__head">
                        <p class="order__main-title">취소 사유</p>
                    </div>
                    <textarea placeholder="취소 사유를 입력해주세요." name="cancelReason" id="cancelReason" maxlength="100" onkeyup="checkFormSubmitButtonAble()"></textarea>
                </div>
            </div>
            <div class="my-detail__footer">
                <div class="util util--modify">
                    <div class="">
                        <button type="button" onclick="openModal('#modal-alt-03')" class="button button--blank-gray cancle" >취소</button>
                        <button type="button" id="write_article_form_complete" onclick="openModal('#modal-request-cancel')" class="button button--solid complete" disabled='disabled'>완료</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-alt-03" class="modal">
            <div class="modal__container" style="width: 350px;">
                <div class="modal__content">
                    <div class="modal-box__container">
                        <div class="modal-box__content">
                            <div class="modal__desc">
                                <p class="modal__text">
                                    작성 중인 내용이 있습니다.<br>
                                    진행을 취소하시겠습니까?
                                </p>
                            </div>
                            <div class="modal__util">
                                <button type="button" onclick="closeModal('#modal-alt-03');" class="modal__button modal__button--gray"><span>취소</span></button>
                                <button type="button" onclick="location.replace('/mypage/order/detail?orderGroupCode={{ $orders[0]->order_group_code }}&type={{ $type }}')" class="modal__button"><span>확인</span></button>
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
                                <button type="button" onclick="location.replace('/mypage/order/detail?orderGroupCode={{ $orders[0]->order_group_code }}&type={{ $type }}');" class="modal__button"><span>확인</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- 거래 취소 전 요청 modal --}}
        <div id="modal-request-cancel" class="modal">
            <div class="modal__container" style="width: 350px;">
                <div class="modal__content">
                    <div class="modal-box__container">
                        <div class="modal-box__content">
                            <div class="modal__desc">
                                <p class="modal__text">
                                    거래를 취소하시겠습니까?<br>
                                    취소 건은 다시 복구할 수 없습니다.
                                </p>
                            </div>
                            <div class="modal__util">
                                <button type="button" onclick="closeModal('#modal-request-cancel');" id="cancelOrderCancel" class="modal__button modal__button--gray"><span>취소</span></button>
                                <button type="button" onclick="changeStatus('{{ isset($orderGroupCode) ? $orderGroupCode : $orderCode }}','C', '{{ $type }}');" id="cancelOrder" class="modal__button"><span>확인</span></button>
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
@endsection
@push('scripts')
    <script>
        // 폼 완료 버튼 활성화/비활성화 처리
        const checkFormSubmitButtonAble = () => {
            if (document.getElementById('cancelReason').value) {
                document.getElementById('write_article_form_complete').closest('div').classList.add('active');
                document.getElementById('write_article_form_complete').removeAttribute('disabled');
            } else {
                document.getElementById('write_article_form_complete').closest('div').classList.remove('active');
                document.getElementById('write_article_form_complete').setAttribute('disabled', 'disabled');
            }
        }
    </script>
@endpush
