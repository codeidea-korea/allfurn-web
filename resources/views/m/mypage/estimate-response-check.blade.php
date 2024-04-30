@extends('layouts.app_m')

@php
    $only_quick = '';
    $header_depth = 'mypage';
    $top_title = '견적서 확인하기';
    $header_banner = '';

    $product_option_price = 0;
    foreach ($response as $res) {
        $product_option_price += $res -> product_option_price;
    }
@endphp

@section('content')
    @include('layouts.header_m')

    <div id="content">
        <form method="PUT" name="isForm" id="isForm" action="/estimate/insertOrder">
            <section class="sub">
                <div class="flex inner gap-10 ">
                    <div class="w-full">
                        <table class="table_layout input_type1">
                            <colgroup>
                                <col width="35%">
                                <col width="65%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th colspan="2">견적서를 요청한 자</th>
                                    <input type="hidden" name="response_estimate_req_user_idx" id="response_estimate_req_user_idx" value="{{ $user -> idx }}" />
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>업&nbsp;&nbsp;&nbsp;체&nbsp;&nbsp;&nbsp;명</th>
                                    <td><b class="response_estimate_req_company_name"></b>{{ $response[0] -> request_company_name }}</td>
                                </tr>
                                <tr>
                                    <th>사업자번호</th>
                                    <td class="response_estimate_req_business_license_number" colspan="2">{{ $response[0] -> request_business_license_number }}</td>
                                </tr>
                                <tr>
                                    <th>전 화 번 호</th>
                                    <td class="response_estimate_req_phone_number">{{ $response[0] -> request_phone_number }}</td>
                                </tr>
                                <tr>
                                    <th>주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</th>
                                    <td class="response_estimate_req_address1" colspan="2">{{ $response[0] -> request_address1 }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table_layout mt-5 input_type1">
                            <colgroup>
                                <col width="35%">
                                <col width="65%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th colspan="2">견적서를 보내는 자</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="2">아래와 같이 견적서를 보냅니다.</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <tr>
                                    <th>견 적 일 자</th>
                                    <td class="response_estimate_res_time">{{ $response[0] -> response_res_time }}</td>
                                </tr>
                                <tr>
                                    <th>견 적 번 호</th>
                                    <td class="response_estimate_res_code">{{ $response[0] -> estimate_code }}</td>
                                </tr>
                                <tr>
                                    <th>업&nbsp;&nbsp;&nbsp;체&nbsp;&nbsp;&nbsp;명</th>
                                    <td class="response_estimate_res_company_name">{{ $response[0] -> response_company_name }}</td>
                                </tr>
                                <tr>
                                    <th>사업자번호</th>
                                    <td class="response_estimate_res_business_license_number">{{ $response[0] -> response_business_license_number }}</td>
                                </tr>
                                <tr>
                                    <th>전 화 번 호</th>
                                    <td class="response_estimate_res_phone_number">{{ $response[0] -> response_phone_number }}</td>
                                </tr>
                                <tr>
                                    <th>유 효 기 한</th>
                                    <td>견적일로부터 15일</td>
                                </tr>
                                <tr>
                                    <th>주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</th>
                                    <td class="response_estimate_res_address1" colspan="3">{{ $response[0] -> response_address1 }}</td>
                                </tr>
                                <tr>
                                    <th>계 좌 번 호</th>
                                    <td class="response_estimate_response_account" colspan="3">{{ $response[0] -> response_account }}</td>
                                </tr>
                                <tr>
                                    <th>비&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;고</th>
                                    <td class="response_estimate_res_memo" colspan="3">{{ $response[0] -> response_memo }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table_layout mt-5 input_type2 hidden">
                            <colgroup>
                                <col width="35%">
                                <col width="65%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th colspan="2">공급자</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>업&nbsp;&nbsp;&nbsp;체&nbsp;&nbsp;&nbsp;명</th>
                                    <td class="response_estimate_res_company_name">{{ $response[0] -> response_company_name }}</td>
                                </tr>
                                <tr>
                                    <th>사업자번호</th>
                                    <td class="response_estimate_res_business_license_number">{{ $response[0] -> response_business_license_number }}</td>
                                </tr>
                                <tr>
                                    <th>전 화 번 호</th>
                                    <td class="response_estimate_res_phone_number">{{ $response[0] -> response_phone_number }}</td>
                                </tr>
                                <tr>
                                    <th>주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</th>
                                    <td class="response_estimate_res_address1" colspan="3">{{ $response[0] -> response_address1 }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table_layout input_type2 hidden">
                            <colgroup>
                                <col width="35%">
                                <col width="65%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th colspan="2">주문자</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="2">아래와 같이 주문합니다.</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <tr>
                                    <th>주 문 일 자</th>
                                    <td class="register_time"></td>
                                    <input type="hidden" name="register_time" id="register_time" value="" />
                                </tr>
                                <tr>
                                    <th>주 문 번 호</th>
                                    <td class="txt-gray order_code">{{ $response[0] -> estimate_code }}</td>
                                    <td class="order_group_code hidden">{{ $response[0] -> estimate_group_code }}</td>
                                </tr>
                                <tr>
                                    <th>업&nbsp;&nbsp;&nbsp;체&nbsp;&nbsp;&nbsp;명</th>
                                    <td><b class="response_estimate_req_company_name">{{ $response[0] -> request_company_name }}</b></td>
                                </tr>
                                <tr>
                                    <th>사업자번호</th>
                                    <td class="response_estimate_req_business_license_number" colspan="2">{{ $response[0] -> request_business_license_number }}</td>
                                </tr>
                                <tr>
                                    <th>업체연락처</th>
                                    <td class="response_estimate_req_phone_number">{{ $response[0] -> request_phone_number }}</td>
                                </tr>
                                <tr>
                                    <th>주문자성명</th>
                                    <td><input type="text" name="name" id="name" class="input-form w-full" value="" /></td>
                                </tr>
                                <tr>
                                    <th>주문자연락처</th>
                                    <td><input type="text" name="phone_number" id="phone_number" class="input-form w-full" value="" /></td>
                                </tr>
                                <tr>
                                    <th>주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</th>
                                    <td><input type="text" name="address1" id="address1" class="input-form w-full" value="{{ $response[0] -> request_address1 }}" /></td>
                                </tr>
                                <tr>
                                    <th>비&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;고</th>
                                    <td><input type="text" name="memo" id="memo" class="input-form w-full" value="" /></td>
                                </tr>
                            </tbody>
                        </table>

                        <ul class="order_prod_list mt-3 request_order_prod_list">
                            @foreach($response as $res)
                            <li>
                                <div class="img_box">
                                    <img src="{{ $res -> product_thumbnail }}" alt="" class="mt-5 product_thumbnail" />
                                    <input type="hidden" name="estimate_idx[]" value="{{ $res -> estimate_idx }}" />
                                </div>
                                <div class="right_box">
                                    <h6 class="product_name">{{ $res -> name }}</h6>
                                    <table class="table_layout">
                                        <colgroup>
                                            <col width="35%">
                                            <col width="65%">
                                        </colgroup>
                                        <tbody><tr>
                                            <th>상품번호</th>
                                            <td class="txt-gray">{{ $res -> product_number }}</td>
                                            <input type="hidden" name="product_idx[]" value="{{ $res -> product_idx }}" />
                                        </tr>
                                        <tr>
                                            <th>상품수량</th>
                                            <td class="txt-primary">
                                                <span class="product_count"></span>
                                                <div class="count_box">
                                                    <button type="button" class="minus_btn"><svg><use xlink:href="/img/icon-defs.svg#minus"></use></svg></button>
                                                    <input type="text" name="product_count[]" value="{{ $res -> product_count }}" readOnly />
                                                    <button type="button" class="plus_btn"><svg><use xlink:href="/img/icon-defs.svg#plus"></use></svg></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>옵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;션</th>
                                            <td>
                                            @php
                                                $product_option_json = json_decode($res -> product_option_json);
                                            @endphp
                                            @if (!empty(json_decode($res -> product_option)))
                                                <table class="my_table w-full text-left">
                                                    @foreach (json_decode($res -> product_option) as $key => $val)
                                                        <tr>
                                                            <th>
                                                                {{ $val -> optionName }}
                                                                <input type="hidden" name="product_option_key_{{ $res -> product_idx }}[]" value="{{ $val -> optionName }}" readOnly />
                                                            </th>
                                                            <td>
                                                                <select name="product_option_value_{{ $res -> product_idx }}[]" class="input-form w-2/3 option">
                                                                @foreach ($val -> optionValue as $opKey => $opVal)
                                                                    @php
                                                                        $selected = $opVal -> propertyName === key($product_option_json[$key] -> optionValue) ? 'selected' : '';
                                                                    @endphp
                                                                    <option value="{{ $opVal -> propertyName }},{{ $opVal -> price }}" {{ $selected }}>{{ $opVal -> propertyName }}</option>
                                                                @endforeach
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            @else
                                                없음
                                            @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>견적단가</th>
                                            <td class="txt-primary">
                                                {{ number_format($res -> product_each_price) }}원
                                                <input type="hidden" name="product_each_price[]" value="{{ $res -> product_each_price }}" readOnly />
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>견적금액</th>
                                            <td>
                                                <b class="product_total_price">{{ $res -> product_total_price }}원</b>
                                                <input type="hidden" name="product_total_price[]" value="{{ str_replace(',', '', $res -> product_total_price) }}" readOnly />
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>배송지역</th>
                                            <td>{{ $res -> product_address }}</td>
                                        </tr>
                                        <tr>
                                            <th>배송방법</th>
                                            <td>{{ $res -> product_delivery_info }}</td>
                                        </tr>
                                        <tr>
                                            <th>배송비</th>
                                            <td class="txt-primary">
                                                {{ number_format($res -> product_delivery_price) }}원
                                                <input type="hidden" name="product_delivery_price[]" value="{{ str_replace(',', '', $res -> product_delivery_price) }}" readOnly />
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>비고</th>
                                            <td>{{ $res -> product_memo }}</td>
                                        </tr>
                                    </tbody></table>
                                </div>
                            </li>
                            @endforeach
                        </ul>

                        <div class="order_price_total mt-10">
                            <h5>총 견적금액</h5>
                            <div class="price">
                                <p>
                                    <span class="txt-gray fs14">
                                        견적금액 (<span class="response_estimate_product_total_count"></span>)
                                    </span>
                                    <b class="response_estimate_product_total_price"></b>
                                    <input type="hidden" name="response_estimate_product_total_price" value="" />
                                </p>
                                <p>
                                    <span class="txt-gray fs14">
                                        옵션금액
                                    </span>
                                    <b class="response_estimate_product_option_price">{{ number_format($product_option_price) }}원</b>
                                    <input type="hidden" name="response_estimate_product_option_price" id="response_estimate_product_option_price" value="{{ $product_option_price }}" />
                                </p>
                                <p>
                                    <span class="txt-gray fs14">배송비</span>
                                    <b class="response_estimate_product_delivery_price"></b>
                                </p>
                            </div>
                            <div class="total">
                                <p>총 견적금액</p>
                                <b class="response_estimate_estimate_total_price"></b>
                                <input type="hidden" name="response_estimate_estimate_total_price" value="{{ $response[0] -> estimate_total_price }}" />
                            </div>
                        </div>

                        <div class="btn_box mt-7 input_type1">
                            <div class="flex gap-2">
                                <a id="holdEstimate" class="btn btn-line w-1/3" style="cursor: pointer;">보류하기</a>
                                <a id="request_order_detail" class="btn btn-primary flex-1" style="cursor: pointer;">주문서 작성하기</a>
                            </div>
                        </div>
                        <div class="btn_box mt-7 input_type2 hidden">
                            <div class="flex gap-5">
                                <a href="javascript: ;" id="insert_order" class="btn btn-primary flex-1">주문서 보내기</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </div>

    <div id="response_order-modal" class="modal">
        <div class="modal_bg" onclick="modalClose('#response_order-modal')"></div>
        <div class="modal_inner modal-md">
            <div class="p-3 com_setting modal_body">
                <div class="w-12 h-12 rounded-full flex items-center justify-center  mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-basket text-white"><path d="m15 11-1 9"/><path d="m19 11-4-7"/><path d="M2 11h20"/><path d="m3.5 11 1.6 7.4a2 2 0 0 0 2 1.6h9.8a2 2 0 0 0 2-1.6l1.7-7.4"/><path d="M4.5 15.5h15"/><path d="m5 11 4-7"/><path d="m9 11 1 9"/></svg>
                </div>
                <h2 class="text-2xl font-medium text-center mt-2">주문이 완료되었습니다.</h2>
                <div class="mt-10">
                    <h3 class="text-xl font-medium">주문 정보</h3>
                </div>
                <hr class="border border-1 border-gray-500 mt-4">
                <div class="flex flex-col justify-center gap-4 mt-4">
                    <div class="flex">
                        <p class="text-stone-400 w-[100px]">수령인</p>
                        <p class="ml-4 name"></p>
                    </div>
                    <div class="flex">
                        <p class="text-stone-400 w-[100px]">연락처</p>
                        <p class="ml-4 phone_number"></p>
                    </div>
                    <div class="flex">
                        <p class="text-stone-400 w-[100px]">주 소</p>
                        <p class="ml-4 address1"></p>
                    </div>
                    <div class="flex">
                        <p class="text-stone-400 w-[100px]">총 주문금액</p>
                        <p class="ml-4 total_price"></p>
                    </div>
                    <div class="info">
                        <div class="flex items-center gap-1">
                            <img src="/img/member/info_icon.svg" alt="" class="w-4" />
                            <p>수령인의 연락처나 주소가 변경되었을 경우, 업체측에 직접 알려주세요.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-10">
                    <h3 class="text-xl font-medium">주문 상품</h3>
                    <hr class="border border-1 border-gray-500 mt-4">
                </div>
                <div class="border rounded-sm mt-4">
                    <div class="p-4 flex justify-between items-center border-b bg-stone-100">
                        No.<span class="order_code">{{ $response[0] -> estimate_code }}</span>
                        <a class="flex items-center gap-1 text-stone-400 response_order_detail">
                            <span>상세보기</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                        </a>
                    </div>
                    <div class="response_order_prod_list"></div>
                </div>
                <div class="flex items-center justify-center gap-3 mt-5">
                    <a href="/" class="btn w-1/2 btn-primary-line">쇼핑 계속하기</a>
                    <a href="/mypage/purchase" class="btn w-1/2 btn-primary">주문 현황 보러가기</a>
                </div>
            </div>
        </div>
    </div>





    <script src="/js/jquery-1.12.4.js?{{ date('Ymdhis') }}"></script>
    <script>
        var product_count = 0;
        var response_estimate_product_total_count = 0;

        var response_estimate_product_total_price = 0;
        var response_estimate_product_option_price = 0;
        var response_estimate_product_delivery_price = 0;
        var response_estimate_estimate_total_price = 0;

        $(document).ready(function(){
            response_estimate_product_delivery_price = $('input[name="product_delivery_price[]"]').eq(0).val();
            response_estimate_product_option_price = $('#response_estimate_product_option_price').val();

            for(var i = 0; i < $('input[name="product_count[]"]').length; i++) {
                response_estimate_product_total_count += Number($('input[name="product_count[]"]').eq(i).val());
                response_estimate_product_total_price += Number($('input[name="product_total_price[]"]').eq(i).val());
            }

            response_estimate_estimate_total_price = 
                Number(response_estimate_product_total_price) + Number(response_estimate_product_option_price) + Number(response_estimate_product_delivery_price);

            $('.response_estimate_product_total_count').text(response_estimate_product_total_count + '개');
            $('.response_estimate_product_total_price').text(response_estimate_product_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');
            $('input[name="response_estimate_product_total_price"]').val(response_estimate_product_total_price);
            $('.response_estimate_product_delivery_price').text(response_estimate_product_delivery_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');
            $('.response_estimate_estimate_total_price').text(response_estimate_estimate_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');
            $('input[name="response_estimate_estimate_total_price"]').val(response_estimate_estimate_total_price);



            $('#holdEstimate').on('click', function(){
                if(confirm('이 견적을 보류하시겠습니까?')) {
                    fetch('/estimate/holdEstimate', {
                        method  : 'PUT',
                        headers : {
                            'Content-Type'  : 'application/json',
                            'X-CSRF-TOKEN'  : '{{csrf_token()}}'
                        },
                        body    : JSON.stringify({
                            estimate_code    : estimate_code
                        })
                    }).then(response => {
                        return response.json();
                    }).then(json => {
                        if (json.result === 'success') {
                            alert('보류되었습니다.')
                            location.reload();
                        } else {
                            alert(json.message);
                        }
                    });
                }
            });

            // 주문서 작성하기
            $('#request_order_detail').on('click', function(){
                $('.title').text('주문서 작성하기');

                //$('.request_order_prod_list').html('');
                for(var i = 0; i < $('input[name="product_count[]"]').length; i++) {
                    $('.count_box').eq(i).addClass('hidden');
                    $('.product_count').eq(i).text($('input[name="product_count[]"]').eq(i).val().toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '개');
                    $('.product_count').eq(i).removeClass('hidden');

                    $('select').attr('onFocus', 'this.initialSelect = this.selectedIndex;');
                    $('select').attr('onChange', 'this.selectedIndex = this.initialSelect;');

                    $('input[name="product_memo[]"]').eq(i).addClass('hidden');
                    $('.product_memo').eq(i).text($('input[name="product_memo[]"]').eq(i).val());
                    $('.product_memo').eq(i).removeClass('hidden');
                }

                fetch('/mypage/requestOrderDetail', {
                    method  : 'POST',
                    headers : {
                        'Content-Type'  : 'application/json',
                        'X-CSRF-TOKEN'  : '{{csrf_token()}}'
                    }
                }).then(response => {
                    return response.json();
                }).then(json => {
                    if (json.result === 'success') {
                        console.log(json);

                        $('.register_time').text(json.data.now1);
                        $('#register_time').val(json.data.now2);

                        $('#name').val(json.data.user.name);
                        $('#phone_number').val(json.data.user.phone_number);

                        $('.input_type1').addClass('hidden');
                        $('.input_type2').removeClass('hidden');

                        $('html, body').animate({ scrollTop: '0' }, 1000);
                    } else {
                        alert(json.message);
                    }
                });
            });

            $('#insert_order').on('click', function(){
                if(confirm('이대로 주문하시겠습니까?')) {
                    const formData = new FormData(document.getElementById('isForm'));
                    /*
                    for (const [key, value] of formData.entries()) {
                        console.log(key, value);
                    }
                    return false;
                    */

                    fetch('/estimate/insertOrder', {
                        method  : 'POST',
                        headers : {
                            'X-CSRF-TOKEN'  : '{{csrf_token()}}'
                        },
                        body    : formData
                    }).then(response => {
                        return response.json();
                    }).then(json => {
                        if (json.success) {
                            $('.name').text($('#name').val());
                            $('.phone_number').text($('#phone_number').val());
                            $('.address1').text($('#address1').val());
                            $('.total_price').text(response_estimate_estimate_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');

                            $('.response_order_detail:not(button)').attr('href', '/mypage/order/detail?orderGroupCode=' + $('.order_group_code').first().text() + '&type=P');

                            $('.response_order_prod_list').html('');
                            for(var i = 0; i < $('input[name="product_count[]"]').length; i++) {
                                $('.response_order_prod_list').append(
                                    `<div class="p-4 flex items-center">
                                        <img src="` + $('.product_thumbnail').eq(i).attr('src') + `" alt="" class="object-cover w-20 h-20 rounded-md" />
                                        <div class="ml-3">
                                            <p class="font-medium">` + $('.response_estimate_res_company_name').eq(0).text() + `</p>
                                            <p class="text-stone-400">` + $('.product_name').eq(i).text() + `</p>
                                        </div>
                                    </div>`
                                );
                            }

                            modalOpen('#response_order-modal');
                        } else {
                            alert('일시적인 오류로 처리되지 않았습니다.');
                            return false;
                        }
                    });
                }
            });

            $(document).on('change', '.option', function(){
                response_estimate_product_option_price = 0;
                $('.option').each(function(){
                    console.log($(this).closest('li').find('input[name="product_count[]"]').val());
                    response_estimate_product_option_price += Number($(this).val().split(',')[1]) * Number($(this).closest('li').find('input[name="product_count[]"]').val());
                });

                $('.response_estimate_product_option_price').text(response_estimate_product_option_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');
                $('input[name="response_estimate_product_option_price"]').val(response_estimate_product_option_price);

                response_estimate_estimate_total_price = Number(response_estimate_product_total_price) + Number(response_estimate_product_option_price) + Number(response_estimate_product_delivery_price);
                $('.response_estimate_estimate_total_price').text(response_estimate_estimate_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');
                $('input[name="response_estimate_estimate_total_price"]').val(response_estimate_estimate_total_price);
            });

            $(document).on('click', '.minus_btn', function(index){
                let num = Number($(this).siblings('input').val());

                if (num > 1) {
                    product_count = num - 1;
                    $(this).siblings('input').val(product_count);

                    var i = $('.minus_btn').index(this);

                    let product_each_price = $('input[name="product_each_price[]"]').eq(i).val();
                    let product_total_price = product_each_price * product_count;

                    $('.product_total_price').eq(i).text(product_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');
                    $('input[name="product_total_price[]"]').eq(i).val(product_total_price);

                    response_estimate_product_total_count = 0;
                    $('input[name="product_count[]"]').each(function(){
                        response_estimate_product_total_count += Number($(this).val());
                    });
                    $('.response_estimate_product_total_count').text(response_estimate_product_total_count + '개');

                    response_estimate_product_total_price = 0;
                    $('input[name="product_total_price[]"]').each(function(){
                        response_estimate_product_total_price += Number($(this).val());
                    });
                    $('.response_estimate_product_total_price').text(response_estimate_product_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');
                    $('input[name="response_estimate_product_total_price"]').val(response_estimate_product_total_price);

                    response_estimate_product_option_price = 0;
                    $('.option').each(function(){
                        console.log($(this).closest('li').find('input[name="product_count[]"]').val());
                        response_estimate_product_option_price += Number($(this).val().split(',')[1]) * Number($(this).closest('li').find('input[name="product_count[]"]').val());
                    });
                    $('.response_estimate_product_option_price').text(response_estimate_product_option_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');
                    $('input[name="response_estimate_product_option_price"]').val(response_estimate_product_option_price);

                    response_estimate_estimate_total_price = Number(response_estimate_product_total_price) + Number(response_estimate_product_option_price) + Number(response_estimate_product_delivery_price);
                    $('.response_estimate_estimate_total_price').text(response_estimate_estimate_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');
                    $('input[name="response_estimate_estimate_total_price"]').val(response_estimate_estimate_total_price);
                }
            });

            $(document).on('click', '.plus_btn', function(){
                let num = Number($(this).siblings('input').val());
                product_count = num + 1;
                $(this).siblings('input').val(product_count);

                var i = $('.plus_btn').index(this);

                let product_each_price = $('input[name="product_each_price[]"]').eq(i).val();
                let product_total_price = product_each_price * product_count;

                $('.product_total_price').eq(i).text(product_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');
                $('input[name="product_total_price[]"]').eq(i).val(product_total_price);

                response_estimate_product_total_count = 0;
                $('input[name="product_count[]"]').each(function(){
                    response_estimate_product_total_count += Number($(this).val());
                });
                $('.response_estimate_product_total_count').text(response_estimate_product_total_count + '개');

                response_estimate_product_total_price = 0;
                $('input[name="product_total_price[]"]').each(function(){
                    response_estimate_product_total_price += Number($(this).val());
                });
                $('.response_estimate_product_total_price').text(response_estimate_product_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');
                $('input[name="response_estimate_product_total_price"]').val(response_estimate_product_total_price);

                response_estimate_product_option_price = 0;
                $('.option').each(function(){
                    console.log($(this).closest('li').find('input[name="product_count[]"]').val());
                    response_estimate_product_option_price += Number($(this).val().split(',')[1]) * Number($(this).closest('li').find('input[name="product_count[]"]').val());
                });
                $('.response_estimate_product_option_price').text(response_estimate_product_option_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');
                $('input[name="response_estimate_product_option_price"]').val(response_estimate_product_option_price);

                response_estimate_estimate_total_price = Number(response_estimate_product_total_price) + Number(response_estimate_product_option_price) + Number(response_estimate_product_delivery_price);
                $('.response_estimate_estimate_total_price').text(response_estimate_estimate_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');
                $('input[name="response_estimate_estimate_total_price"]').val(response_estimate_estimate_total_price);
            });
        });
    </script>
@endsection