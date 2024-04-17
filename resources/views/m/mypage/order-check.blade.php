@extends('layouts.app_m')

@php
    $only_quick = '';
    $header_depth = 'mypage';
    $top_title = '주문서 확인하기';
    $header_banner = '';

    $product_total_count = 0;
    $product_total_price = 0;
    foreach ($response as $res) {
        $product_total_count += $res -> product_count;
        $product_total_price += $res -> product_total_price;
    }
@endphp

@section('content')
    @include('layouts.header_m')

    <div id="content">
        <!--
        <section class="sub_banner type02">
            <h3>주문서 확인하기</h3>
        </section>
        -->
        <section class="sub">
            <div class="flex inner gap-10 ">
                <div class="w-full">
                    <table class="table_layout">
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
                                <td>{{ $response[0] -> response_company_name }}</td>
                            </tr>
                            <tr>
                                <th>사업자번호</th>
                                <td>{{ $response[0] -> response_business_license_number }}</td>
                            </tr>
                            <tr>
                                <th>전 화 번 호</th>
                                <td>{{ $response[0] -> response_phone_number }}</td>
                            </tr>
                            <tr>
                                <th>주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</th>
                                <td>{{ $response[0] -> response_address1 }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table_layout mt-5">
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
                                <td>{{ $response[0] -> register_time }}</td>
                            </tr>
                            <tr>
                                <th>주 문 번 호</th>
                                <td>{{ $response[0] -> order_code }}</td>
                            </tr>
                            <tr>
                                <th>업&nbsp;&nbsp;&nbsp;체&nbsp;&nbsp;&nbsp;명</th>
                                <td><b>{{ $response[0] -> request_company_name }}</b></td>
                            </tr>
                            <tr>
                                <th>사업자번호</th>
                                <td>{{ $response[0] -> request_business_license_number }}</td>
                            </tr>
                            <tr>
                                <th>업체연락처</th>
                                <td>{{ $response[0] -> request_phone_number }}</td>
                            </tr>
                            <tr>
                                <th>주문자성명</th>
                                <td>{{ $response[0] -> name }}</td>
                            </tr>
                            <tr>
                                <th>주문자연락처</th>
                                <td>{{ $response[0] -> phone_number }}</td>
                            </tr>
                            <tr>
                                <th>주문자주소</th>
                                <td>{{ $response[0] -> address1 }}</td>
                            </tr>
                            <tr>
                                <th>비&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;고</th>
                                <td>{{ $response[0] -> memo }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <ul class="order_prod_list mt-10">
                        @foreach ($response as $res)
                        <li>
                            <div class="img_box">
                                <img src="{{ $res -> product_thumbnail }}" alt="" />
                            </div>
                            <div class="right_box">
                                <h6>{{ $res -> product_name }}</h6>
                                <table class="table_layout">
                                    <colgroup>
                                        <col width="35%">
                                        <col width="65%">
                                    </colgroup>
                                    <tbody>
                                        <tr>
                                            <th>상품번호</th>
                                            <td class="txt-gray">{{ $res -> product_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>상품수량</th>
                                            <td class="txt-primary">{{ $res -> product_count }}개</td>
                                        </tr>
                                        <tr>
                                            <th>옵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;션</th>
                                            <td>없음</td>
                                        </tr>
                                        <tr>
                                            <th>견적단가</th>
                                            <td class="txt-primary">{{ number_format($res -> product_each_price) }}원</td>
                                        </tr>
                                        <tr>
                                            <th>견적금액</th>
                                            <td><b>{{ number_format($res -> product_total_price) }}원</b></td>
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
                                            <td class="txt-primary">{{ number_format($res -> product_delivery_price) }}원</td>
                                        </tr>
                                        <tr>
                                            <th>비고</th>
                                            <td>{{ $res -> product_memo }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </li>
                        @endforeach
                    </ul>

                    <div class="order_price_total mt-10">
                        <h5>총 주문금액</h5>
                        <div class="price">
                            <p>
                                <span class="txt-gray fs14">주문금액 ({{ $product_total_count }}개)</span>
                                <b>{{ number_format($product_total_price) }}원</b>
                            </p>
                            <p>
                                <span class="txt-gray fs14">배송비</span>
                                <b>{{ number_format($response[0] -> product_delivery_price) }}원</b>
                            </p>
                        </div>
                        <div class="total">
                            <p>총 주문금액</p>
                            <b>{{ number_format($response[0] -> estimate_total_price) }}원</b>
                        </div>
                    </div>

                    <div class="btn_box mt-10">
                        <div class="flex gap-5">
                            <a href="javascript: ;" class="btn btn-primary flex-1" onclick="history.back();">닫기</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
