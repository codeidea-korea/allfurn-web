@extends('layouts.app_m')

@php
    $only_quick = '';
    $header_depth = 'mypage';
    $top_title = '견적 요청서 보내기';
    $header_banner = '';
@endphp

@section('content')
    @include('layouts.header_m')

    <div id="content">
        <!--
        <section class="sub_banner">
            <h3>견적 요청서</h3>
        </section>
        -->
        <section class="sub">
            <div class="flex inner gap-10 ">
                <div class="w-full">
                    <form method="PUT" name="isForm" id="isForm" action="/estimate/insert" enctype="multipart/form-data">
                        <input type="hidden" name="request_company_idx" value="{{ $company -> idx }}" />
                        <input type="hidden" name="request_company_type" value="{{ $user -> type }}" />
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
                            <tbody>
                                <tr>
                                    <th>요 청 일 자</th>
                                    <td id="request_time">{{ $now1 }}</td>
                                    <input type="hidden" name="request_time" value="{{ $now2 }}" />
                                </tr>
                                <tr>
                                    <th>요 청 번 호</th>
                                    <td id="estimate_group_code" class="txt-gray">{{ $code }}</td>
                                    <input type="hidden" name="estimate_group_code" value="{{ $code }}" />
                                </tr>
                                <tr>
                                    <th>업&nbsp;&nbsp;&nbsp;체&nbsp;&nbsp;&nbsp;명</th>
                                    <td id="request_company_name">{{ $company -> company_name }}</td>
                                    <input type="hidden" name="request_company_name" value="{{ $company -> company_name }}" />
                                </tr>
                                <tr>
                                    <th>사업자번호</th>
                                    <td>
                                        <input type="text" name="request_business_license_number" class="input-form w-full" value="{{ $company -> business_license_number }}" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>전 화 번 호</th>
                                    <td>
                                        <input type="text" name="request_phone_number" class="input-form w-full" value="{{ $company -> phone_number }}" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>주요판매처</th>
                                    <td>
                                        <div class="input-form">
                                            <select name="" id="" class=" w-full h-full">
                                                <option value="0">매장 판매</option>
                                            </select>
                                        </div>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <th>주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</th>
                                    <td>
                                        <input type="text" name="request_address1" onClick="callMapApi(this);" class="input-form w-full" value="{{ $company -> business_address }} {{ $company -> business_address_detail }}" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>비&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;고</th>
                                    <td>
                                        <input type="text" name="request_memo" class="input-form w-full" value="" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        * 다수의 견적서 도착 알림톡이 발송될 수 있습니다.
                        <div class="mt-7">
                            <p>사업자 등록증 또는 명함 첨부 (필수)</p>
                            <p class="txt-primary">* 사업자가 아닌 경우 견적서를 요청하실 수 없습니다.</p>
                        </div>
                        <div id="previewBusinessLicense" class="file-form full mt-2">
                            <input type="hidden" name="request_business_license_fidx" value="" />
                            <input type="hidden" name="is_business_license_img" value="0" />
                            <input type="file" name="request_business_license" id="request_business_license" />
                            <div class="text">
                                <img src="/img/member/img_icon.svg" alt="" class="mx-auto" />
                                <p class="mt-1 default-add-image">이미지 추가</p>
                            </div>
                            <div class="absolute top-2.5 right-2.5">
                                <button type="button" id="deleteBusinessLicense" class="file_del w-[28px] h-[28px] bg-stone-600/50 rounded-full hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-white mx-auto w-4 h-4"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                </button>
                            </div>
                        </div>
                        <div class="flex justify-end mt-2">
                            <button type="button" class="btn btn-line flex-1 business_license_modify hidden">기본 사업자등록증으로 등록하기</button>
                        </div>
                        <div class="btn_box mt-7 check_btn">
                            <p class="mb-2">
                                <input type="checkbox" id="all_prod" class="radio-form" />
                                <label for="all_prod">위 입력된 사항을 확인했습니다.</label>
                            </p>
                            <div class="flex gap-5">
                                <a href="javascript: ;" class="btn btn-primary flex-1" onclick="goNext()">확인</a>
                            </div>
                        </div>
                        <ul class="order_prod_list mt-5 hidden">
                            <input type="hidden" name="response_company_idx" value="{{ $product -> company_idx }}" />
                            <input type="hidden" name="response_company_type" value="{{ $product -> company_type }}" />
                            <input type="hidden" name="product_idx" value="{{ $product -> idx }}" />
                            <li>
                                <div class="img_box">
                                    <img src="{{ $attachment[0] -> product_thumbnail }}" alt="" />
                                </div>
                                <div class="right_box">
                                    <h6>{{ $product -> name }}</h6>
                                    <table class="table_layout">
                                        <colgroup>
                                            <col width="160px">
                                            <col width="*">
                                        </colgroup>
                                        <tr>
                                            <th>상품번호</th>
                                            <td>{{ $product -> product_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>상품수량</th>
                                            <td>
                                                <div class="count_box">
                                                    <button type="button" class="minus"><svg><use xlink:href="/img/icon-defs.svg#minus"></use></svg></button>
                                                    <input type="text" name="product_count" value="1" readOnly />
                                                    <button type="button" class="plus"><svg><use xlink:href="/img/icon-defs.svg#plus"></use></svg></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>옵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;션</th>
                                            <td>
                                                @if (!empty(json_decode($product -> product_option)))
                                                <input type="hidden" name="product_option_exist" value="1" readOnly />
                                                    <table class="my_table w-full text-left">
                                                        @foreach (json_decode($product -> product_option) as $key => $val)
                                                            @if ($val -> required === '1')
                                                            <tr>
                                                                <th>
                                                                    {{ $val -> optionName }}
                                                                    <input type="hidden" name="product_option_key[]" value="{{ $val -> optionName }}" readOnly />
                                                                </th>
                                                                <td>
                                                                    <select name="product_option_value[]" class="input-form w-2/3">
                                                                    @foreach ($val -> optionValue as $opVal)
                                                                        <option value="{{ $opVal -> propertyName }},{{ $opVal -> price }}">{{ $opVal -> propertyName }}</option>
                                                                    @endforeach
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            @endif
                                                        @endforeach
                                                    </table>
                                                @else
                                                    없음
                                                    <input type="hidden" name="product_option_exist" value="0" readOnly />
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>견적단가</th>
                                            <td class="txt-gray">
                                            {{ 
                                                ($product -> price > 0) ? 
                                                    number_format($product -> price).'원' 
                                                    : $product -> price_text 
                                            }}
                                            </td>
                                            <input type="hidden" name="product_each_price" value="{{ $product -> price }}" />
                                            <input type="hidden" name="product_each_price_text" value="{{ $product -> price_text }}" />
                                        </tr>
                                        <tr>
                                            <th>배송지역</th>
                                            <td>{{ $attachment[0] -> product_address }}</td>
                                            <input type="hidden" name="product_delivery_info" value="{{ $product -> delivery_info }}" />
                                        </tr>
                                    </table>
                                </div>
                            </li>
                        </ul>
                        <div class="btn_box mt-10 request_estimate_btn hidden">
                            <div class="flex gap-5">
                                <a class="btn btn-primary flex-1" style="cursor: pointer;" onclick="insertRequest()">견적서 요청하기</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>





    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script>
        // 주소 API 호출
        const callMapApi = elem => {
            const ele = elem;
            new daum.Postcode({
                oncomplete  : function(data) {
                    $(ele).val(data.roadAddress);
                }
            }).open();
        }
        var storedFiles = [];

        // '견적서 요청일시, 견적서 요청번호' 생성 및 '견적서 요청 모달' 열기
        function openEstimateModal() {
            fetch('/estimate/makeEstimateCode', {
                method  : 'POST',
                headers : {
                    'X-CSRF-TOKEN'  : '{{csrf_token()}}'
                }
            }).then(response => {
                if (response.ok) {
                    return response.json();
                }

                throw new Error('Sever Error');
            }).then(json => {
                console.log(1)
                console.log(json)
                if (json.success) {
                    $('input[name="request_business_license_fidx"]').val(json.company.business_license_attachment_idx);
                    if (json.company.blImgUrl != null && json.company.blImgUrl != '') { 
                        $('input[name="is_business_license_img"]').val('1'); 
                    } else { 
                        $('input[name="is_business_license_img"]').val('0'); 
                    }
                    document.getElementById('previewBusinessLicense').style.backgroundImage = "url('" + json.company.blImgUrl + "')";
                    document.getElementById('previewBusinessLicense').style.backgroundSize = '100%';
                    document.getElementById('deleteBusinessLicense').classList.remove('hidden');
                    document.querySelectorAll('.default-add-image').forEach(elem => elem.classList.add('hidden'));


                    $('.check_btn').addClass('hidden');
                    $('.request_estimate').removeClass('hidden');
                    $('.order_prod_list').removeClass('hidden');
                    $('.request_estimate_btn').removeClass('hidden');
                } else {
                    alert(json.message);
                    return false;
                }
            }).catch(error => {
                alert('오류가 발생하였습니다. 잠시후에 다시 시도해주세요.');
                return false;
            });
        }

        // (등록된) 사업자등록증 미리보기
        const previewBusinessLicense = evt => {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewBusinessLicense').style.backgroundImage = "url('" + e.target.result + "')";
                document.getElementById('previewBusinessLicense').style.backgroundSize = '100%';
                document.getElementById('deleteBusinessLicense').classList.remove('hidden');
                document.querySelectorAll('.default-add-image').forEach(elem => elem.classList.add('hidden'));
            };

            if (evt.currentTarget.files.length) {
                reader.readAsDataURL(evt.currentTarget.files[0]);
            } else {
                document.getElementById('previewBusinessLicense').removeAttribute('style');
                document.getElementById('deleteBusinessLicense').classList.add('hidden');
                document.querySelectorAll('.default-add-image').forEach(elem => elem.classList.remove('hidden'));
            }
            $('input[name="is_business_license_img"]').val('1');
            $('.business_license_modify').removeClass('hidden');
        }
        document.querySelector('[name="request_business_license"]').addEventListener('change', (e) => { 
            storedFiles = [];
            storedFiles.push(e.currentTarget.files[0]);

            previewBusinessLicense(e);
        });

        // (등록된) 사업자등록증 삭제
        const deleteBusinessLicense = () => {
            const element = document.querySelector('[name=request_business_license]');
            element.value = '';

            const e = new Event('change');
            element.dispatchEvent(e);
            $('input[name="is_business_license_img"]').val('0');
            $('.business_license_modify').addClass('hidden');
        }
        document.getElementById('deleteBusinessLicense').addEventListener('click', deleteBusinessLicense);

        // 기본 사업자등록증으로 지정
        $('.business_license_modify').click(function(){
            if(!$('#request_business_license').val()) {
                alert("사업자등록증을 첨부해주세요!");
                $('#request_business_license').focus();
                return false;
            }

            const fformData = new FormData(document.getElementById('isForm'));
            fformData.append('reg_type', '1');
            fformData.append('files[]', storedFiles[0]);

            fetch('/mypage/business_license_file/update', {
                method  : 'POST',
                headers : {
                    'X-CSRF-TOKEN'  : '{{csrf_token()}}'
                },
                body    : fformData
            }).then(response => {
                return response.json();
            }).then(json => {
                if (json.result == 'success') {
                    alert('기본 사업자등록증으로 등록되었습니다.'); return false;
                } else {
                    alert('일시적인 오류로 처리되지 않았습니다.'); return false;
                }
            });

        });

        const goNext = () => {
            if(!$('input[name="request_business_license_number"]').val()) {
                alert('사업자번호를 입력해주세요!');
                $('input[name="request_business_license_number').focus();
                return false;
            }

            if(!$('input[name="request_phone_number"]').val()) {
                alert('전화번호를 입력해주세요!');
                $('input[name="request_phone_number').focus();
                return false;
            }

            if(!$('input[name="request_address1"]').val()) {
                alert('주소를 입력해주세요!');
                $('input[name="request_address1').focus();
                return false;
            }

            if($('input[name="is_business_license_img"]').val() != '1') {
                alert("사업자등록증을 첨부해주세요!");
                $('#request_business_license').focus();
                return false;
            }

            if(!$('#all_prod').is(':checked')) {
                alert('입력된 사항을 다시한번 확인해주시고 아래의 항목에 체크해주세요.');
                $('#all_prod').focus();
                return false;
            }

            $('.check_btn').addClass('hidden');

            $('.request_estimate').removeClass('hidden');
            $('.order_prod_list').removeClass('hidden');
            $('.request_estimate_btn').removeClass('hidden');
        }

        const insertRequest = () => {
            if(!$('input[name="request_business_license_number"]').val()) {
                alert('사업자번호를 입력해주세요!');
                $('input[name="request_business_license_number').focus();
                return false;
            }

            if(!$('input[name="request_phone_number"]').val()) {
                alert('전화번호를 입력해주세요!');
                $('input[name="request_phone_number').focus();
                return false;
            }

            if(!$('input[name="request_address1"]').val()) {
                alert('주소를 입력해주세요!');
                $('input[name="request_address1').focus();
                return false;
            }

            if($('input[name="is_business_license_img"]').val() != '1') {
                alert("사업자등록증을 첨부해주세요!");
                $('#request_business_license').focus();
                return false;
            }

            const formData = new FormData(document.getElementById('isForm'));
            formData.append('reg_type', '1');
            formData.append('files[]', storedFiles[0]);
            /*
            for (const [key, value] of formData.entries()) {
                console.log(key, value);
            }
            return false;
            */

            fetch('/estimate/insertRequest', {
                method  : 'POST',
                headers : {
                    'X-CSRF-TOKEN'  : '{{csrf_token()}}'
                },
                body    : formData
            }).then(response => {
                return response.json();
            }).then(json => {
                if (json.success) {
                    //openModal('#alert-modal02');
                    alert('견적서 요청이 완료되었습니다.');
                    history.back();
                } else {
                    alert('일시적인 오류로 처리되지 않았습니다.');
                    return false;
                }
            });
        }



        $(function(){
            $('.count_box .minus').off().on('click', function(){
                let num = Number($(this).siblings('input').val());
                if (num !== 1) {
                    $(this).siblings('input').val(`${num - 1}`);
                }
            });

            $('.count_box .plus').off().on('click', function(){
                let num = Number($(this).siblings('input').val());
                $(this).siblings('input').val(`${num + 1}`);
            });

            openEstimateModal();
        });
    </script>
@endsection