@extends('layouts.app_m')

@php
    $only_quick = '';
    $header_depth = 'mypage';
    $top_title = '견적서 확인하기';
    $header_banner = '';

    $product_option_price = 0;
    foreach($response as $res) {
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
                                        </tr>
                                        <tr>
                                            <th>상품수량</th>
                                            <td class="txt-primary">
                                                <span class="product_count">{{ $res -> product_count }}</span>개
                                                <input type="hidden" name="product_count[]" value="{{ $res -> product_count }}" readOnly />
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>옵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;션</th>
                                            <td>
                                            @if (!empty(json_decode($res -> product_option_json)))
                                                <table class="my_table w-full text-left">
                                                    @foreach (json_decode($res -> product_option_json) as $key => $val)
                                                        <tr>
                                                            <th>{{ $val -> optionName }}</th>
                                                            <td>{{ key($val -> optionValue) }}</td>
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
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>비고</th>
                                            <td>
                                                <span class="product_memo">{{ $res -> product_memo }}</span>
                                            </td>
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
                                </p>
                                <p>
                                    <span class="txt-gray fs14">
                                        옵션금액
                                    </span>
                                    <b class="response_estimate_product_option_price">{{ number_format($product_option_price) }}원</b>
                                </p>
                                <p>
                                    <span class="txt-gray fs14">배송비</span>
                                    <b class="response_estimate_product_delivery_price">{{ number_format($response[0] -> product_delivery_price) }}원</b>
                                </p>
                            </div>
                            <div class="total">
                                <p>총 견적금액</p>
                                <b class="response_estimate_estimate_total_price">{{ number_format($response[0] -> estimate_total_price) }}원</b>
                            </div>
                        </div>

                        <div class="btn_box mt-7">
                            <div class="flex gap-5">
                                <a href="javascript: ;" class="btn btn-primary flex-1" onclick="history.back();">닫기</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </div>





    <script src="/js/jquery-1.12.4.js?{{ date('Ymdhis') }}"></script>
    <script>
        var response_estimate_product_total_count = 0;
        var response_estimate_product_total_price = 0;

        $(document).ready(function(){
            for(var i = 0; i < $('input[name="product_count[]"]').length; i++) {
                response_estimate_product_total_count += Number($('input[name="product_count[]"]').eq(i).val());
                response_estimate_product_total_price += Number($('input[name="product_total_price[]"]').eq(i).val());
            }

            $('.response_estimate_product_total_count').text(response_estimate_product_total_count + '개');
            $('.response_estimate_product_total_price').text(response_estimate_product_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');
        });
    </script>
@endsection