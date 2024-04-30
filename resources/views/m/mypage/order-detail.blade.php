@extends('layouts.app_m')

@php
    $only_quick = '';
    $header_depth = 'mypage';
    $top_title = $detailTitle2.' 상세';
    $header_banner = '';
@endphp

@section('content')
@include('layouts.header_m')

<div id="content">
    <div class="bg-stone-100">
        <div class="p-4 rounded-t-sm border-b bg-white">
            <div class="flex items-center">
                <span class="bg-primaryop p-1 text-xs text-primary rounded-sm font-medium">{{ config('constants.ORDER.STATUS.'.$type)[$orders[0] -> order_state] }}</span>
                <span class="ml-2">{{ $orders[0] -> order_group_code }}</span>
                <span class="ml-auto text-stone-400">{{ $orders[0] -> reg_time }}</span>
            </div>
            <hr class="mt-3">
            <p class="font-bold text-base mt-3">{{ $orders[0] -> product_name }}</p>
            @if (request() -> type === 'S' && $orders[0] -> order_state != 'C')
                {{-- <div class="border rounded-md px-2 h-[40px] mt-3"> --}}
                    <select name="order_state" id="" class="border rounded-md mt-3 w-full h-[40px] order_state" data-order-num="{{ $orders[0] -> order_code }}">
                        <option value="N" {{ $orders[0] -> order_state == 'N' ? 'selected' : '' }}>신규 주문</option>
                        <option value="R" {{ $orders[0] -> order_state == 'R' ? 'selected' : '' }}>상품 준비중</option>
                        <option value="D" {{ $orders[0] -> order_state == 'D' ? 'selected' : '' }}>발송 중</option>
                        <option value="W" {{ $orders[0] -> order_state == 'W' ? 'selected' : '' }}>구매 확정 대기</option>
                        <option value="F" {{ $orders[0] -> order_state == 'F' ? 'selected' : '' }}>거래 완료</option>
                        <!--<option value="C" {{ $orders[0] -> order_state == 'C' ? 'selected' : '' }} disabled>거래 취소(선택 불가)</option>-->
                    </select>
                {{-- </div> --}}
                <br/>
            @endif
            @if ($orders[0] -> order_state == 'N' )
                <br/>
                <div class="h-[40px] border rounded-md px-2">
                    <button type="button" class="w-full h-full cancle cancle--modify" onclick="location.href='/mypage/order/cancel?orderCode={{ $orders[0] -> order_code }}&type={{ $type }}&state=C'">거래 취소</button>
                    <!--<button type="button" class="w-[120px] h-[44px] border rounded-md cancle cancle--modify" onclick="location.href='/mypage/order/cancel?orderCode={{ $orders[0] -> order_code }}&type={{ $type }}&state=C'">거래 취소</button>-->
                </div>
            @elseif($orders[0] -> order_state == 'C')
                거래취소 완료
            @elseif ($orders[0] -> order_state == 'W' && $type == 'P' )
                <br/>
                <div class="h-[40px] border rounded-md px-2">
                    <button type="button" class="w-full h-full cancle cancle--modify" onclick="changeStatus('{{ isset($orders[0] -> order_group_code) ? $orders[0] -> order_group_code : $orders[0] -> order_code }}','F', '{{ $type }}');">구매 확정</button>
                </div>
            @endif
        </div>

        @foreach ($orders as $index => $order)
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
                                    @foreach (json_decode($order -> product_option_json) as $key => $val)
                                        {{ $val -> optionName }}
                                        {{ key($val -> optionValue).'('.number_format($val -> optionValue -> {key($val -> optionValue)}).'원)' }}
                                        <br />
                                    @endforeach
                                @else
                                없음
                                @endif
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <p class="w-[100px] shrink-0 text-stone-400">수량</p>
                            <p>{{ $order -> product_count }}개</p>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <p class="w-[100px] shrink-0 text-stone-400">금액</p>
                            <p>{{ $order -> product_each_price > 0 ? number_format($order -> product_each_price).'원' : $order -> price_text }}</p>
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
                            <p class="w-[100px] shrink-0 text-stone-400">결제 방법</p>
                            <p>{{ $order -> p_pay_notice }}</p>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <p class="w-[100px] shrink-0 text-stone-400">주문 금액</p>
                            <p>{{ $order -> price_text ?: number_format(($order -> product_price) + ($order -> product_option_price)).'원' }}</p>
                        </div>
                    </li>
                </ul>
            </div>
        @endforeach
            <div class="pb-3">
            <div class="bg-white px-3 pt-3">
                <p class="font-bold">주문자 정보</p>
            </div>
            <ul class="p-3 bg-white flex flex-col gap-2">
                <li>
                    <div class="flex items-center">
                        <p class="w-[100px] shrink-0 text-stone-400">업체명</p>
                        <p>{{ $buyer -> w_company_name ?: $buyer -> r_company_name }}</p>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <p class="w-[100px] shrink-0 text-stone-400">휴대폰번호</p>
                        <p>{{ preg_replace("/([0-9]{3})([0-9]{3,4})([0-9]{4})$/", "\\1-\\2-\\3", str_replace('-', '', $buyer -> user_phone_number)) }}</p>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <p class="w-[100px] shrink-0 text-stone-400">수령인</p>
                        <p>{{ $buyer -> name }}</p>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <p class="w-[100px] shrink-0 text-stone-400">수령인 연락처</p>
                        <p>{{ preg_replace("/([0-9]{3})([0-9]{3,4})([0-9]{4})$/", "\\1-\\2-\\3", str_replace('-', '', $buyer -> phone_number)) }}</p>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <p class="w-[100px] shrink-0 text-stone-400">배송지</p>
                        <p>({{ $buyer -> zipcode }}) {{ $buyer -> address1 }} {{ $buyer -> address2 }}</p>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <p class="w-[100px] shrink-0 text-stone-400">배송비</p>
                        <p>{{ number_format($orders[0] -> product_delivery_price) }}원</p>
                    </div>
                </li>
            </ul>
        </div>
        <div>
            <div class="bg-white px-3 py-4 flex justify-between">
                <p class="font-bold">총 주문 금액</p>
                <div class="text-right">
                    <p class="text-primary font-bold text-base">{{ number_format($order -> price).'원' }}</p>
                    <p class="text-stone-400">(협의 포함)</p>
                </div>
            </div>
        </div>
    </div>
</div>





<script src="/js/jquery-1.12.4.js?{{ date('Ymdhis') }}"></script>
<script>
    $(document).ready(function(){
        $('.order_state').change(function(){
            if(confirm('상태값을 변경하시겠습니까?')) {
                fetch('/mypage/order/status', {
                    method  : 'PUT',
                    headers : {
                        'Content-Type'  : 'application/json',
                        'X-CSRF-TOKEN'  : '{{csrf_token()}}'
                    },
                    body    : JSON.stringify({
                        type        : 'S',
                        orderNum    : $(this).data('order-num'),
                        status      : $(this).val()
                    })
                }).then(response => {
                    return response.json();
                }).then(json => {
                    if (json.result === 'success') {
                        alert('상태값이 변경되었습니다.')
                        location.reload();
                    } else {
                        alert(json.message);
                    }
                });
            }
        });
    });

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