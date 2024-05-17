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
                    <form method="PUT" name="udForm" id="udForm" action="/estimate/update" enctype="multipart/form-data">
                        <input type="hidden" name="estimate_idx" id="estimate_idx" value="{{ $request[0] -> estimate_idx }}" />
                        <input type="hidden" name="estimate_code" id="estimate_code" value="{{ $request[0] -> estimate_code }}" />
                        <input type="hidden" name="response_company_type" id="response_company_type" value="{{ $user -> type }}" />
                        <table class="table_layout input_type1">
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
                        <div class="file-form full img_auto mt-10 input_type1">
                            <img src="{{ $request[0] -> business_license }}" alt="" />
                        </div>

                        <table class="table_layout input_type2 hidden">
                            <colgroup>
                                <col width="35%">
                                <col width="65%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th colspan="2">견적서를 요청한 자</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>업&nbsp;&nbsp;&nbsp;체&nbsp;&nbsp;&nbsp;명</th>
                                    <td><b>{{ $request[0] -> request_company_name }}</b></td>
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
                                    <th>주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</th>
                                    <td>{{ $request[0] -> request_address1 }}</td>
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
                                    <td class="response_estimate_res_time"></td>
                                    <input type="hidden" name="response_estimate_res_time" value="" />
                                </tr>
                                <tr>
                                    <th>견 적 번 호</th>
                                    <td class="response_estimate_res_code"></td>
                                </tr>
                                <tr>
                                    <th>업&nbsp;&nbsp;&nbsp;체&nbsp;&nbsp;&nbsp;명</th>
                                    <td class="response_estimate_res_company_name"></td>
                                    <input type="hidden" name="response_estimate_res_company_name" id="response_res_estimate_company_name" class="input-form w-full" value="" />
                                </tr>
                                <tr>
                                    <th>사업자번호</th>
                                    <td><input type="text" name="response_estimate_res_business_license_number" id="response_res_business_license_number" class="input-form w-full" value="" /></td>
                                </tr>
                                <tr>
                                    <th>전 화 번 호</th>
                                    <td><input type="text" name="response_estimate_res_phone_number" id="response_estimate_res_phone_number" class="input-form w-full" value="" /></td>
                                </tr>
                                <tr>
                                    <th>유 효 기 한</th>
                                    <td>
                                        견적일로부터 
                                        <select name="expiration_date" id="expiration_date" class="input-form ml-3">
                                            @for ($i = 15; $i >= 1; $i--)
                                                <option value="{{ $i }}">{{ $i }}일</option>
                                            @endfor
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</th>
                                    <td colspan="3"><input type="text" name="response_estimate_res_address1" id="response_estimate_res_address1" class="input-form w-full" value="" /></td>
                                </tr>
                                <tr>
                                    <th>계 좌 번 호</th>
                                    <td>
                                        <span class="response_account hidden"></span>
                                        <select name="response_estimate_account1" id="response_estimate_response_account1" class="input-form w-full">
                                            <option value="KEB하나은행">KEB하나은행</option>
                                            <option value="SC제일은행">SC제일은행</option>
                                            <option value="국민은행">국민은행</option>
                                            <option value="신한은행">신한은행</option>
                                            <option value="외환은행">외환은행</option>
                                            <option value="우리은행">우리은행</option>
                                            <option value="한국시티은행">한국시티은행</option>
                                            <option value="기업은행">기업은행</option>
                                            <option value="농협">농협</option>
                                            <option value="수협">수협</option>
                                        </select>
                                        <input type="text" name="response_estimate_response_account2" id="response_estimate_response_account2" class="input-form w-full mt-1" value="" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>비&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;고</th>
                                    <td><input type="text" name="response_estimate_res_memo" id="response_estimate_res_memo" class="input-form w-full" value="" /></td>
                                </tr>
                            </tbody>
                        </table>

                        <ul class="order_prod_list mt-10 input_type1">
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
                                            <th>견적단가</th>
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
                        <ul class="order_prod_list mt-3 input_type2 hidden">
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
                                        <tbody>
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
                                                <th>견적단가</th>
                                                <td><input type="text" name="response_estimate_product_each_price" id="response_estimate_product_each_price" class="input-form w-full txt-primary" value="{{ $request[0] -> product_each_price }}" /></td>
                                            </tr>
                                            <tr>
                                                <th>견적금액</th>
                                                <td class="response_estimate_product_total_price">{{ str_replace(',', '', $request[0] -> product_total_price) > 0 ? $request[0] -> product_total_price.'원': $request[0] -> product_each_price_text }}</td>
                                                <input type="hidden" name="response_estimate_product_total_price" id="response_estimate_product_total_price" value="" />
                                            </tr>
                                            <tr>
                                                <th>배송지역</th>
                                                <td>{{ $request[0] -> product_address }}</td>
                                            </tr>
                                            <tr>
                                                <th>배송방법</th>
                                                <td>
                                                    <select name="response_estimate_product_delivery_info" id="response_estimate_product_delivery_info" class="input-form w-full">
                                                        <option value="업체 협의 (착불)">착불</option>
                                                        <option value="매장 배송 (무료)">무료</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>배송비</th>
                                                <td><input type="text" name="response_estimate_product_delivery_price" id="response_estimate_product_delivery_price" class="input-form txt-primary w-full" value="0" /></td>
                                            </tr>
                                            <tr>
                                                <th>비고</th>
                                                <td><input type="text" name="response_estimate_product_memo" id="response_estimate_product_memo" class="input-form w-full" value="" /></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </li>
                        </ul>

                        <div class="order_price_total mt-10 input_type2 hidden">
                            <h5>총 견적금액</h5>
                            <div class="price">
                                <p>
                                    <span class="txt-gray fs14">
                                        견적금액 (<span class="response_estimate_product_count"></span>)
                                    </span>
                                    <b class="response_estimate_product_total_price"></b>
                                </p>
                                <p>
                                    <span class="txt-gray fs14">
                                        옵션금액
                                    </span>
                                    <b class="response_estimate_product_option_price"></b>
                                    <input type="hidden" name="response_estimate_product_option_price" id="response_estimate_product_option_price" value="" />
                                </p>
                                <p>
                                    <span class="txt-gray fs14">배송비</span>
                                    <b class="response_estimate_product_delivery_price"></b>
                                </p>
                            </div>
                            <div class="total">
                                <p>총 견적금액</p>
                                <b class="response_estimate_estimate_total_price"></b>
                                <input type="hidden" name="response_estimate_estimate_total_price" id="response_estimate_estimate_total_price" value="" />
                            </div>
                        </div>

                        <div class="btn_box mt-7 input_type1">
                            <div class="flex gap-5">
                                <a href="javascript: ;" class="btn btn-primary flex-1 response_estimate_detail">견적서 작성하기</a>
                            </div>
                        </div>
                        <div class="btn_box mt-10 input_type2 hidden">
                            <div class="flex gap-5">
                                <a class="btn btn-primary flex-1" style="cursor: pointer;" onclick="updateResponse()">견적서 보내기</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>





    <script src="/js/jquery-1.12.4.js?{{ date('Ymdhis') }}"></script>
    <script>
        var estimate_idx = $('#estimate_idx').val();
        var estimate_code = $('#estimate_code').val();
        var response_company_type = $('#response_company_type').val();

        var product_option_price = 0;

        const updateResponse = () => {
            if(!$('input[name="response_estimate_res_phone_number"]').val()) {
                alert('전화번호를 입력해주세요!');
                $('input[name="response_estimate_res_phone_number').focus();

                return false;
            }

            if(!$('input[name="response_estimate_res_address1"]').val()) {
                alert('주소를 입력해주세요!');
                $('input[name="response_estimate_res_address1').focus();

                return false;
            }

            if(!$('input[name="response_estimate_response_account2"]').val()) {
                alert('계좌번호를 입력해주세요!');
                $('input[name="response_estimate_response_account2').focus();

                return false;
            }

            if(!$('input[name="response_estimate_product_each_price"]').val()) {
                alert('견적단가를 입력해주세요!');
                $('input[name="response_estimate_product_each_price').focus();

                return false;
            }

            if(!$('#response_estimate_product_delivery_price').val()) {
                alert("배송비를 입력해주세요!");
                $('#product_delivery_price').focus();

                return false;
            }

            const formData = new FormData(document.getElementById('udForm'));
            formData.append('estimate_idx', estimate_idx);
            
            for (const [key, value] of formData.entries()) {
                console.log(key, value);
            }
            //return false;
            

            fetch('/estimate/updateResponse', {
                method  : 'POST',
                headers : {
                    'X-CSRF-TOKEN'  : '{{csrf_token()}}'
                },
                body    : formData
            }).then(response => {
                return response.json();
            }).then(json => {
                if (json.success) {
                    alert('견적서 보내기가 완료되었습니다.');

                    location.href = '/mypage/responseEstimate';
                } else {
                    alert('일시적인 오류로 처리되지 않았습니다.');
                    return false;
                }
            });
        }



        $(document).ready(function(){
            // 견적서 작성하기
            $('.response_estimate_detail').click(function(){
                fetch('/mypage/responseEstimateDetail', {
                    method  : 'POST',
                    headers : {
                        'Content-Type'  : 'application/json',
                        'X-CSRF-TOKEN'  : '{{csrf_token()}}'
                    },
                    body    : JSON.stringify({
                        estimate_code           : estimate_code,
                        response_company_type   : response_company_type
                    })
                }).then(response => {
                    return response.json();
                }).then(json => {
                    if (json.result === 'success') {
                        console.log(json.data);

                        $('.title').text('견적서 작성하기');

                        $('.response_estimate_req_company_name').text((json.data[0].response_req_company_name));
                        $('.response_estimate_req_business_license_number').text((json.data[0].response_req_business_license_number));
                        $('.response_estimate_req_phone_number').text((json.data[0].response_req_phone_number));
                        $('.response_estimate_req_address1').text((json.data[0].response_req_address1));

                        $('.response_estimate_res_time').text(json.data[0].response_res_time ? json.data[0].response_res_time : json.data[0].now1);
                        $('input[name="response_estimate_res_time"]').val(json.data[0].now2);
                        $('.response_estimate_res_code').text(json.data[0].estimate_code);
                        $('.response_estimate_res_company_name').text(json.data[0].response_res_company_name);
                        $('input[name="response_estimate_res_company_name"]').val(json.data[0].response_res_company_name);
                        $('input[name="response_estimate_res_business_license_number"]').val(json.data[0].response_res_business_license_number);
                        $('#response_estimate_res_phone_number').val(json.data[0].response_res_phone_number);
                        $('#response_estimate_res_address1').val(json.data[0].response_res_address1);

                        $('.response_estimate_product_thumbnail').attr('src', json.data[0].product_thumbnail);
                        $('.response_estimate_product_name').text(json.data[0].name);
                        $('.response_estimate_product_number').text(json.data[0].product_number);
                        $('.response_estimate_product_count').text(json.data[0].product_count + '개');

                        product_option_price = 0;
                        if(json.data[0].product_option_json) {
                            $('.response_estimate_product_option').html('');
                            $('.response_estimate_product_option').append(`<table class="my_table w-full text-left response_estimate_product_option_table">`);

                            product_option_json = JSON.parse(json.data[0].product_option_json);
                            for(var key in product_option_json) {
                                $('.response_estimate_product_option_table').append(
                                `<tr>
                                    <th>` + product_option_json[key]['optionName'] + `</th>
                                    <td>` + Object.keys(product_option_json[key]['optionValue'])[0] + `</td>
                                </tr>`);

                                product_option_price += parseInt(Object.values(product_option_json[key]['optionValue'])[0]);
                            }

                            $('.response_estimate_product_option').append(`</table>`);

                            product_option_price = parseInt(product_option_price) * parseInt(json.data[0].product_count);
                        }

                        $('#response_estimate_product_each_price').val(json.data[0].product_each_price);
                        $('.response_estimate_product_total_price').text(json.data[0].product_total_price + '원');
                        $('#response_estimate_product_total_price').val(json.data[0].product_total_price.replace(/[^0-9]/g, ''));
                        $('.response_estimate_product_address').text(json.data[0].product_address);
                        $('.response_estimate_product_delivery_price').text(json.data[0].product_delivery_price ? json.data[0].product_delivery_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원' : '0원');
                        $('#response_estimate_product_delivery_price').val(json.data[0].product_delivery_price ? json.data[0].product_delivery_price : '0');
                        $('#response_estimate_product_memo').val(json.data[0].product_memo);

                        $('.response_estimate_product_option_price').text(product_option_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');
                        $('#response_estimate_product_option_price').val(product_option_price);

                        $('.response_estimate_estimate_total_price').text(json.data[0].estimate_total_price ? (parseInt(json.data[0].estimate_total_price) + parseInt(product_option_price)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원' : (parseInt(json.data[0].product_total_price.replace(/[^0-9]/g, '')) + parseInt(product_option_price)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');
                        $('#response_estimate_estimate_total_price').val(json.data[0].estimate_total_price ? parseInt(json.data[0].estimate_total_price) + parseInt(product_total_price) : parseInt(json.data[0].product_total_price.replace(/[^0-9]/g, '')) + parseInt(product_option_price));

                        $('.input_type1').addClass('hidden');
                        $('.input_type2').removeClass('hidden');

                        $('html, body').animate({ scrollTop: '0' }, 1000);
                    } else {
                        alert(json.message);
                    }
                });
            });

            $(document).on('keyup', '#response_estimate_product_each_price', function(e){
                //if(!$(this).val()) $(this).val(0);
                $(this).val($(this).val().replace(/[^0-9]/g, ''));

                if(Number($(this).val() > 0)) {
                    $('.response_estimate_product_total_price').text((parseInt($(this).val()) * parseInt($('.response_estimate_product_count').last().text())).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');
                    $('#response_estimate_product_total_price').val(parseInt($(this).val()) * parseInt($('.response_estimate_product_count').last().text()));

                    $('.response_estimate_estimate_total_price').text((parseInt($(this).val()) * parseInt($('.response_estimate_product_count').last().text()) + parseInt($('#response_estimate_product_delivery_price').val()) + parseInt(product_option_price)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');
                    $('#response_estimate_estimate_total_price').val((parseInt($(this).val()) * parseInt($('.response_estimate_product_count').last().text()) + parseInt($('#response_estimate_product_delivery_price').val())) + parseInt(product_option_price));
                }
            });

            $(document).on('keyup', '#response_estimate_product_delivery_price', function(e){
                //if(!$(this).val()) $(this).val(0);
                $(this).val($(this).val().replace(/[^0-9]/g, ''));

                if(Number($(this).val() > 0)) {
                    $('.response_estimate_product_delivery_price').text((parseInt($(this).val())).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');

                    $('.response_estimate_estimate_total_price').text((parseInt($(this).val()) + parseInt($('#response_estimate_product_total_price').val())  + parseInt(product_option_price)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');
                    $('#response_estimate_estimate_total_price').val((parseInt($(this).val()) + parseInt($('#response_estimate_product_total_price').val())) + parseInt(product_option_price));
                }
            });
        });
    </script>
@endsection