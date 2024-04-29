@extends('layouts.app')

@section('content')
@include('layouts.header')

<div id="content">
    <div class="inner">
        <div>
            <div class="pt-10 pb-6 flex items-center gap-1 text-stone-400">
                <p>{{ $detailTitle1 }} 현황</p>
                <p>&gt;</p>
                <p>{{ $detailTitle2 }} 상세</p>
            </div>
            <div class="flex itesm-center justify-between">
                <h2 class="text-2xl font-bold">{{ $detailTitle2 }} 상세</h2>
            </div>
        </div>

        <div class="mt-5">
            <div class="flex">
                <div>
                    <span class="text-white bg-primary rounded-sm text-sm p-1">{{ config('constants.ORDER.STATUS.'.$type)[$orders[0] -> order_state] }}</span>
                    <div class="flex items-center gap-3 mt-3">
                        <p>주문번호 {{ $orders[0] -> order_group_code }}</p>
                        <span>|</span>
                        <p class="text-stone-400">주문일자 {{ $orders[0] -> reg_time }}</p>
                    </div>
                </div>
                <!-- "구매 현황" 에서는 삭제-->
                @if (request() -> type === 'S' && $orders[0] -> order_state != 'C')
                    <div class="h-[40px] border rounded-md px-2 ml-auto">
                        <select name="order_state" class="w-full h-full order_state" data-order-num="{{ $orders[0] -> order_code }}">
                            <option value="N" {{ $orders[0] -> order_state == 'N' ? 'selected' : '' }}>신규 주문</option>
                            <option value="R" {{ $orders[0] -> order_state == 'R' ? 'selected' : '' }}>상품 준비중</option>
                            <option value="D" {{ $orders[0] -> order_state == 'D' ? 'selected' : '' }}>발송 중</option>
                            <option value="W" {{ $orders[0] -> order_state == 'W' ? 'selected' : '' }}>구매 확정 대기</option>
                            <option value="F" {{ $orders[0] -> order_state == 'F' ? 'selected' : '' }}>거래 완료</option>
                            <!--<option value="C" {{ $orders[0] -> order_state == 'C' ? 'selected' : '' }} disabled>거래 취소(선택 불가)</option>-->
                        </select>
                    </div>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                @endif
            </div>
        
            @foreach ($orders as $index => $order)
            <div class="flex mt-3">
                <div class="p-4 border-l border-t border-b rounded-tl flex w-[632px]">
                    <img src="{{ $order -> product_image }}" class="object-cover w-24 h-24 rounded-md" alt="" />
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
                            <p class="text-stone-400">{{ $order -> product_count }}개</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 border-l border-t border-b flex flex-col justify-center gap-3 w-[362px]">
                    <div class="flex">
                        <p class="text-stone-400">배송 방법</p>
                        <p class="ml-4">{{ $order -> p_delivery_info }}</p>
                    </div>
                    <div class="flex">
                        <p class="text-stone-400">결제 방법</p>
                        <p class="ml-4">{{ $order -> p_pay_notice }}</p>
                    </div>
                    <div class="flex">
                        <p class="text-stone-400">주문 금액</p>
                        <p class="ml-4">{{ $order -> price_text ?: number_format(($order -> product_price) + ($order -> product_option_price)).'원' }}</p>
                    </div>
                </div>
                <div class="p-4 border rounded-tr flex flex-col items-center justify-center grow">
                    @if ($orders[0] -> order_state == 'N' )
                        <div class="h-[40px] border rounded-md px-2">
                            <button type="button" id="cancel_order_btn" class="w-full h-full cancle cancle--modify">{{ $detailTitle2 }} 취소</button>
                            <!--<button type="button" class="w-[120px] h-[44px] border rounded-md cancle cancle--modify" onclick="location.href='/mypage/order/cancel?orderCode={{ $orders[0] -> order_code }}&type={{ $type }}&state=C'">거래 취소</button>-->
                        </div>
                    @elseif($orders[0] -> order_state == 'C')
                        거래취소 완료
                    @elseif ($orders[0] -> order_state == 'W' && $type == 'P' )
                    <div class="h-[40px] border rounded-md px-2">
                            <button type="button" class="w-full h-full cancle cancle--modify" onclick="changeStatus('{{ isset($orders[0] -> order_group_code) ? $orders[0] -> order_group_code : $orders[0] -> order_code }}','F', '{{ $type }}');">구매 확정</button>
                        </div>
                    @endif
                </div>
            </div>
            @if($order -> memo)
                <div class="border-r border-b border-l rounded-b p-4">
                    {{ $order -> memo }}
                </div>
            @endif
            @endforeach
        </div>

        <div class="mt-[72px] mb-10">
            <div class="com_setting mt-5">
                <p class="font-bold text-lg">주문자 정보</p>
                <div class="mt-5 border-t-2 border-t-stone-600 flex flex-col items-center justify-center border-b py-10 gap-6">
                    <div class="flex gap-4 w-full">
                        <div class="w-[140px] shrink-0 text-stone-400 font-medium">업체명</div>
                        <div>{{ $buyer -> w_company_name ?: $buyer -> r_company_name }}</div>
                    </div>
                    <div class="flex gap-4 w-full">
                        <div class="w-[140px] shrink-0 text-stone-400 font-medium">휴대폰번호</div>
                        <div>{{ preg_replace("/([0-9]{3})([0-9]{3,4})([0-9]{4})$/", "\\1-\\2-\\3", str_replace('-', '', $buyer -> user_phone_number)) }}</div>
                    </div>
                    <div class="flex gap-4 w-full">
                        <div class="w-[140px] shrink-0 text-stone-400 font-medium">이메일</div>
                        <div>{{ $buyer -> account }}</div>
                    </div>
                    <div class="flex gap-4 w-full">
                        <div class="w-[140px] shrink-0 text-stone-400 font-medium">수령인</div>
                        <div>{{ $buyer -> name }}</div>
                    </div>
                    <div class="flex gap-4 w-full">
                        <div class="w-[140px] shrink-0 text-stone-400 font-medium">수령인 연락처</div>
                        <div>{{ preg_replace("/([0-9]{3})([0-9]{3,4})([0-9]{4})$/", "\\1-\\2-\\3", str_replace('-', '', $buyer -> phone_number)) }}</div>
                    </div>
                    <div class="flex gap-4 w-full">
                        <div class="w-[140px] shrink-0 text-stone-400 font-medium">배송지</div>
                        <div>({{ $buyer -> zipcode }}) {{ $buyer -> address1 }} {{ $buyer -> address2 }}</div>
                    </div>
                    <div class="flex gap-4 w-full">
                        <div class="w-[140px] shrink-0 text-stone-400 font-medium">배송비</div>
                        <div>{{ number_format($orders[0] -> product_delivery_price) }}원</div>
                    </div>
                </div>
                <hr>
                <div class="py-5 flex gap-4">
                    <div class="w-[140px] shrink-0 font-bold text-xl">총 주문금액</div>
                    <div class="text-lg">{{ number_format($buyer -> total_price) }}원 <span class="text-stone-400">{{ $buyer -> price_text ? '(협의 포함)' : '' }}</span></div>
                </div>
            </div>
        </div>
    </div>
</div>





<script src="/js/jquery-1.12.4.js?{{ date('Ymdhis') }}"></script>
<script>
    $(document).ready(function(){
        $('.order_state').change(function(){
            if(confirm('거래 상태를 변경하시겠습니까?')) {
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
                        console.log(json.code);
                        alert(json.message);
                        location.reload();
                    }
                });
            }
        });
    });

    $("#cancel_order_btn").click(function () {

        const parameterData = {
            orderGroupCode : '{{  $orders[0] -> order_group_code }}',
            orderCode : '{{  $orders[0] -> order_group_code }}',
            type : '{{  $type }}',
            state : 'C',
        };

        window.location.href = "/mypage/order/cancel?" + new URLSearchParams(parameterData);

    })

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