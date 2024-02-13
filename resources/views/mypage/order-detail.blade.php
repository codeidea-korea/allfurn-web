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
                <p class="my-detail__breadcrumbs">{{ $detailTitle }} 현황 > {{ $detailTitle }} 상세</p>
                <p class="my-detail__title">{{ $detailTitle }} 상세</p>
                <div class="my-detail__wrap">
                    <div>
                        <div class="badge">
                            <span class="badge--solid-red">{{ config('constants.ORDER.STATUS.' . $type)[$orders[0]->order_state] }}</span>
                        </div>
                        @if($type === 'P')
                        <p class="company-name">{{ $loginCompanyName }}</p>
                        @endif
                        <div class="date">
                            <p>주문번호 {{ $orders[0]->order_group_code }}</p>
                            <p>주문일자 {{ $orders[0]->reg_time }}</p>
                        </div>

                    </div>
                    <div class="buttons buttons--modify">
                        @if(in_array('N', $orderStatus))
                        <button type="button" onclick="location.href='/mypage/order/cancel?orderGroupCode={{ $orderGroupCode }}&type={{ $type }}&state=C'" class="button button--blank-gray cancle cancle--modify">전체 거래 취소</button>
                            @if($type === 'S')
                            <button type="button" onclick="changeStatus('{{ $orderGroupCode }}', 'R', '{{ $type }}')" class="button button--solid complete">거래 확정</button>
                            @endif
                        @elseif(in_array('R', $orderStatus) && $type === 'S')
                        <button type="button" onclick="changeStatus('{{ $orderGroupCode }}', 'D', '{{ $type }}')" class="button button--blank-gray">발송</button>
                        <button type="button" onclick="window.location.href='/community/write-dispatch/{{$orderGroupCode}}'" class="button button--solid complete">배차 신청</button>
                        @elseif(in_array('D', $orderStatus) && $type === 'S')
                        <button type="button" onclick="changeStatus('{{ $orderGroupCode }}', 'W', '{{ $type }}')" class="button button--solid complete">발송 완료</button>
                        @else
                        @endif
                    </div>
                </div>
            </div>
            <div class="my-detail__content">
                <div class="my-detail__order">
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
                                        <span> {{ $order->p_pay_notice }}</span>
                                    </p>
                                </div>
                                <div>
                                    <p class="description__title">주문 금액</p>
                                    <p class="description__text">
                                        <span>{{ $order->price_text ?: number_format($order->price) . '원' }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="state">
                                @if($order->order_state === 'N') {{-- 신규 주문 --}}
                                    <button type="button" onclick="location.href='/mypage/order/cancel?orderCode={{ $order->order_code }}&type={{ $type }}&state=C'" class="cancle cancle--modify">{{ $detailTitle }} 취소</button>
                                @elseif($order->order_state === 'C')
                                    {{ $detailTitle }} 취소 완료
                                @elseif($order->order_state === 'W' && $type === 'P')
                                    <button type="button" onclick="changeStatus('{{ $order->order_code }}', 'F', '{{ $type }}')" class="cancle cancle--modify">구매 확정</button>
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="my-detail__request">
                        <p>{{ $orders[0]->memo }}</p>
                    </div>
                </div>
                <div class="my-detail__order-info order">
                    <div class="order-info">
                        <div class="order__head">
                            <p class="order__main-title">주문자 정보</p>
                        </div>
                        <div class="order-info__content">
                            <div class="order-info__item">
                                <p class="order-info__title">
                                    업체명
                                </p>
                                <p class="order-info__text">
                                    <span>{{ $buyer->w_company_name ?: $buyer->r_company_name }}</span>
                                </p>
                            </div>
                            <div class="order-info__item">
                                <p class="order-info__title">
                                    휴대폰 번호
                                </p>
                                <p class="order-info__text">
                                    <span>{{ preg_replace("/([0-9]{3})([0-9]{3,4})([0-9]{4})$/","\\1-\\2-\\3" ,str_replace('-','',$buyer->user_phone_number)) }}</span>
                                </p>
                            </div>
                            <div class="order-info__item">
                                <p class="order-info__title">
                                    이메일
                                </p>
                                <p class="order-info__text">
                                    <span>{{ $buyer->account }}</span>
                                </p>
                            </div>
                            <div class="order-info__item">
                                <p class="order-info__title">
                                    수령인
                                </p>
                                <p class="order-info__text">
                                    <span>{{ $buyer->name }}</span>
                                </p>
                            </div>
                            <div class="order-info__item">
                                <p class="order-info__title">
                                    수령인 연락처
                                </p>
                                <p class="order-info__text">
                                    <span>{{ preg_replace("/([0-9]{3})([0-9]{3,4})([0-9]{4})$/","\\1-\\2-\\3" ,str_replace('-','',$buyer->phone_number)) }}</span>
                                </p>
                            </div>
                            <div class="order-info__item">
                                <p class="order-info__title">
                                    배송지
                                </p>
                                <p class="order-info__text">
                                    <span>({{ $buyer->zipcode }}) {{ $buyer->address1 }} {{ $buyer->address2 }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="order-info__footer">
                            <p>총 주문 금액</p>
                            <p>
                                {{ number_format($buyer->total_price) }}원 <span>{{ $buyer->price_text ? '(협의 포함)' : '' }}</span>
                            </p>
                        </div>
                    </div>

                </div>
                @if (count($cancel) > 0)
                <div class="my-detail__order-cancle order">
                    <div class="order__head">
                        <p class="order__main-title">취소 정보</p>
                    </div>
                    <div class="my-detail__order">
                        <div class="my-detail__list">
                            @foreach($cancel as $c)
                            <div class="my-detail__item">
                                <div class="info">
                                    <div>
                                        <span class="image" style="background-image: url('{{ $c->product_image }}')"></span>
                                        <div class="info__wrap">
                                            <p class="title">{{ $c->product_name }}</p>
                                            <p class="type">
                                                @foreach(json_decode($c->option_json, true) as $option)
                                                    {{ $option['name'] }}: {{ $option['value'] }} {{ !$loop->last ? '/' : '' }}
                                                @endforeach</p>
                                            <p class="price">{{ $c->price_text ?: number_format($c->product_price) . '원' }}</p>
                                            <p class="count">{{ $c->count }}개</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="description">
                                    <div>
                                        <p class="description__title">취소 사유</p>
                                        <p class="description__text">
                                            <span>{{ $c->cancel_reason }} </span>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="description__title">취소 일자</p>
                                        <p class="description__text">
                                            <span>{{ $c->cancel_date }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
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
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>

    </script>
@endpush
