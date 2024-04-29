@extends('layouts.app_m')
@php
$header_depth = 'mypage';
$top_title = $detailTitle2 .'취소';
$only_quick = '';
$header_banner = '';
@endphp
@section('content')
@include('layouts.header_m')
<div id="content">
    <div class="bg-stone-100">
        <div class="p-4 rounded-t-sm border-b bg-white">
            <div class="flex items-center">
                <span class="ml-2">{{ isset($orderGroupCode) ? $orderGroupCode : $orderCode }}</span>
                <span class="ml-auto text-stone-400">{{ $orders[0]->reg_time }}</span>
            </div>
            {{-- <hr class="mt-3">
            <p class="font-bold text-base mt-3">이태리매트리스_엔트리22 (K)</p> --}}
        </div>
        @foreach($orders as $order)
            <div class="p-3">
                <div class="bg-white px-3 pt-3">
                    <p class="font-bold">{{ $order -> product_name }}</p>
                </div>
                <ul class="p-3 bg-white flex flex-col gap-2">
                    <li>
                        <div class="flex items-center">
                            <p class="w-[100px] shrink-0 text-stone-400">옵션</p>
                            <p>
                                @if (!empty(json_decode($order -> product_option_json)))
                                <span>
                                    @foreach (json_decode($order -> product_option_json) as $key => $val)
                                        {{ $val -> optionName }}
                                        {{ key($val -> optionValue).'('.number_format($val -> optionValue -> {key($val -> optionValue)}).'원)' }}
                                        <br />
                                    @endforeach
                                </span>
                                @else
                                옵션 없음
                                @endif
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <p class="w-[100px] shrink-0 text-stone-400">수량</p>
                            <p>{{ $order->count }}개</p>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <p class="w-[100px] shrink-0 text-stone-400">가격</p>
                            <p>{{ $order -> price_text ?: number_format($order -> product_each_price).'원' }}</p>
                        </div>
                    </li>
                </ul>
                <hr class="">
                <ul class="p-3  bg-white flex flex-col gap-2">
                    <li>
                        <div class="flex items-center">
                            <p class="w-[100px] shrink-0 text-stone-400">배송 방법</p>
                            <p>{{ $order -> p_delivery_info }}</p>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <p class="w-[100px] shrink-0 text-stone-400">결제 방식</p>
                            <p>{{ $order -> p_pay_notice }}</p>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <p class="w-[100px] shrink-0 text-stone-400">주문 금액</p>
                            <p>{{ $order -> price_text ?: number_format(($order -> product_price) + ($order -> product_option_price)).'원' }}</p>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                        <div class="flex items-center">
                            <p class="w-[100px] shrink-0 text-stone-400">업체명</p>
                            <p>{{ $order->name }}</p>
                        </div>
                    </li>
                </ul>
            </div>
        @endforeach
        <div class="pb-3 bg-white">
            <div class="px-3 pt-3">
                <p class="font-bold">취소 사유</p>
            </div>
            <div class="p-3">
                <textarea class="textarea-form" style="height:200px;" id="cancelReason" placeholder="취소 사유를 입력해주세요." onkeyup="checkFormSubmitButtonAble()"></textarea>
            </div>
            <div class="flex items-center justify-center gap-3 px-3">
                <button class="btn w-36 btn-primary-line" onclick="history.back();">취소</button>
                <button class="btn w-36 btn-primary" id="write_article_form_complete" onclick="modalOpen('#modal-request-cancel')" disabled>완료</button>
            </div>
        </div>
    </div>

    {{-----------------------------------------------------------------------}}
        {{-- 거래 취소 전 요청 modal --}}
        <div class="modal" id="modal-request-cancel">
            <div class="modal_bg" onclick="modalClose('modal-request-cancel')"></div>
            <div class="modal_inner modal-sm">
                <button class="close_btn" onclick="modalClose('#modal-request-cancel')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
                <div class="modal_body agree_modal_body">
                    <p class="text-center py-4"><b>거래를 취소하시겠습니까?<br>취소 건은 다시 복구할 수 없습니다.</b></p>
                    <div class="flex gap-2 justify-center">
                        <button class="btn w-full btn-primary-line mt-5" onclick="modalClose('#modal-request-cancel')">취소</button>
                        <button class="btn w-full btn-primary mt-5" onclick="changeStatus('{{ isset($orderGroupCode) ? $orderGroupCode : $orderCode }}','C', '{{ $type }}');" id="cancelOrder">확인</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- 거래 취소 완료 modal --}}
        <div class="modal" id="modal-cancel">
            <div class="modal_bg" onclick="modalClose('#modal-cancel')"></div>
            <div class="modal_inner modal-sm">
                <button class="close_btn" onclick="modalClose('#modal-cancel')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
                <div class="modal_body agree_modal_body">
                    <p class="text-center py-4"><b>거래가 취소되었습니다.</b></p>
                    <div class="flex gap-2 justify-center">
                        <button class="btn btn-primary w-1/2 mt-5" onclick="location.replace('/mypage/order/detail?orderGroupCode={{ $orders[0]->order_group_code }}&type={{ $type }}');">확인</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // 폼 완료 버튼 활성화/비활성화 처리
    const checkFormSubmitButtonAble = () => {
        if (document.getElementById('cancelReason').value) {
            document.getElementById('write_article_form_complete').removeAttribute('disabled');
        } else {
            document.getElementById('write_article_form_complete').setAttribute('disabled', 'disabled');
        }
    }

    const changeStatus = (orderNum, status, type) => {
        let params = {orderNum, status, type};
        if (status === 'C') {
            params['cancelReason'] = document.getElementById('cancelReason').value;
        }
        fetch('/mypage/order/status', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(params)
        }).then(result => {
            return result.json()
        }).then(json => {
            if (json.result === 'success') {
                switch(status) {
                    case 'R':
                        modalOpen('#modal-deal');
                        break;
                    case 'D':
                        modalOpen('#modal-send-start');
                        break;
                    case 'W':
                        modalOpen('#modal-send-complete');
                        break;
                    case 'C':
                        modalClose('#modal-request-cancel');
                        modalOpen('#modal-cancel');
                        break;
                    case 'F':
                        location.replace(location.href);
                        break;
                }
            } else {
                alert("오류가 발생했습니다. 관리자에게 문의바랍니다.");
                window.history.back();
            }
        });
    }
</script>
@endsection