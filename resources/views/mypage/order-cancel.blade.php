@extends('layouts.app')

@section('content')
@include('layouts.header')

<div id="content">
    <div class="inner">
        <!-- title -->
        <div>
            <div class="pt-10 pb-6 flex items-center gap-1 text-stone-400">
                <p>{{ $detailTitle1 }}현황</p>
                <p>&gt;</p>
                <p>{{ $detailTitle2 }} 상세</p>
                <p>&gt;</p>
                <p>{{ $detailTitle2 }} 취소</p>
            </div>
            <div class="flex itesm-center justify-between">
                <h2 class="text-2xl font-bold">{{ $detailTitle2 }} 취소</h2>
            </div>
        </div>

        <div class="mt-5">
            <div class="flex">
                <div>
                    <div class="flex items-center gap-3 mt-3">
                        <p>주문번호 {{ isset($orderGroupCode) ? $orderGroupCode : $orderCode }}</p>
                        <span>|</span>
                        <p class="text-stone-400">주문일자 {{ $orders[0]->reg_time }}</p>
                    </div>
                </div>
                <!-- 판매현황  -->
            </div>

            @foreach($orders as $order)
                <div class="flex mt-3">
                    <div class="p-4 border-l border-t border-b rounded-tl flex w-1/2 items-center">
                        <img class="object-cover w-24 h-24 rounded-md" src="{{ $order->product_image }}" alt="">
                        <div class="ml-3">
                            <p class="font-medium">{{ $order -> product_name }}</p>
                            <div class="flex items-center gap-2">
                                <p class="font-medium">{{ $order -> price_text ?: number_format($order -> product_each_price).'원' }}</p>
                                <span>|</span>
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
                                <span>|</span>
                                <p class="text-stone-400">{{ $order->count }}개</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 border-l border-t border-r border-b flex flex-col justify-center gap-3 w-1/2">
                        <div class="flex">
                            <p class="text-stone-400">배송 방법</p>
                            <p class="ml-4">{{ $order -> p_delivery_info }}</p>
                        </div>
                        <div class="flex">
                            <p class="text-stone-400">결제 방식</p>
                            <p class="ml-4">{{ $order -> p_pay_notice }}</p>
                        </div>
                        <div class="flex">
                            <p class="text-stone-400">주문 금액</p>
                            <p class="ml-4">{{ $order -> price_text ?: number_format(($order -> product_price) + ($order -> product_option_price)).'원' }}</p>
                        </div>
                        @if($type == 'S')
                            <div class="flex">
                                <p class="text-stone-400">업체명</p>
                                <p class="ml-4">{{ $order->name }}</p>
                            </div>
                        @endif
                    </div>
                </div>
                @if($orders[0]->memo)
                    <div class="border-r border-b border-l rounded-b p-4 text-stone-400 text-sm">
                        <!-- 추가 요청사항 들어가는 곳 -->
                        {{ $orders[0]->memo }}
                    </div>
                @endif
            @endforeach
        </div>

        <div class="mt-[72px] mb-10">
            <div class="com_setting mt-5">
                <p class="font-bold text-lg">취소 사유</p>
                <div class="mt-5 border-t-2 border-t-stone-600 flex flex-col items-center justify-center py-10 gap-6">
                    <textarea class="textarea-form" style="height:200px;" id="cancelReason" placeholder="취소 사유를 입력해주세요." onkeyup="checkFormSubmitButtonAble()"></textarea>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3">
                <button class="btn w-36 btn-primary-line" onclick="history.back();">취소</button>
                <button class="btn w-36 btn-primary" id="write_article_form_complete" onclick="modalOpen('#modal-request-cancel')" disabled>완료</button>
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