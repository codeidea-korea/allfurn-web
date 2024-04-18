@extends('layouts.app_m')

@php
    $only_quick = '';
    $header_depth = 'mypage';
    $top_title = '견적 요청서 확인하기';
    $header_banner = '';
@endphp

@section('content')
    @include('layouts.header_m')

    <div id="content">
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
                                <th colspan="2">견적서를 요청한 자</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th colspan="2">아래와 같이 견적을 요청합니다.</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr>
                                <th>요 청 일 자</th>
                                <td>{{ $request[0] -> request_time }}</td>
                            </tr>
                            <tr>
                                <th>요 청 번 호</th>
                                <td>{{ $request[0] -> estimate_code }}</td>
                            </tr>
                            <tr>
                                <th>업&nbsp;&nbsp;&nbsp;체&nbsp;&nbsp;&nbsp;명</th>
                                <td>{{ $request[0] -> request_company_name }}</td>
                            </tr>
                            <tr>
                                <th>사업자번호</th>
                                <td>{{ $request[0] -> request_business_license_number }}</td>
                            </tr>
                            <tr>
                                <th>전 화 번 호</th>
                                <td>{{ $request[0] -> request_phone_number }}</td>
                            </tr>
                            <tr>
                                <th>주요판매처</th>
                                <td>매장 판매</td>
                            </tr>
                            <tr>
                                <th>주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</th>
                                <td>{{ $request[0] -> request_address1 }}</td>
                            </tr>
                            <tr>
                                <th>비&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;고</th>
                                <td>{{ $request[0] -> request_memo }}</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="file-form full img_auto mt-10">
                        <img src="{{ $request[0] -> business_license }}" alt="" />
                    </div>

                    <ul class="order_prod_list mt-10">
                        <li>
                            <div class="img_box">
                                <img src="{{ $request[0] -> product_thumbnail }}" alt="" />
                            </div>
                            <div class="right_box">
                                <h6>{{ $request[0] -> product_name }}</h6>
                                <table class="table_layout">
                                    <colgroup>
                                        <col width="35%">
                                        <col width="65%">
                                    </colgroup>
                                    <tr>
                                        <th>상품번호</th>
                                        <td class="txt-gray">{{ $request[0] -> product_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>상품수량</th>
                                        <td class="txt-primary">{{ $request[0] -> product_count }}개</td>
                                    </tr>
                                    <tr>
                                        <th>옵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;션</th>
                                        <td>
                                        @if (!empty(json_decode($request[0] -> product_option_json)))
                                            <table class="my_table w-full text-left">
                                                @foreach (json_decode($request[0] -> product_option_json) as $key => $val)
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
                                        <th>판매가격</th>
                                        <td class="txt-gray">{{ str_replace(',', '', $request[0] -> product_each_price) > 0 ? $request[0] -> product_each_price.'원': $request[0] -> product_each_price_text }}</td>
                                    </tr>
                                    <tr>
                                        <th>배송지역</th>
                                        <td>{{ $request[0] -> product_address }}</td>
                                    </tr>
                                </table>
                            </div>
                        </li>
                    </ul>

                    <div class="btn_box mt-7">
                        <div class="flex gap-5">
                            <a href="javascript: ;" class="btn btn-primary flex-1" onclick="location.href='/mypage/requestEstimate'">닫기</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection