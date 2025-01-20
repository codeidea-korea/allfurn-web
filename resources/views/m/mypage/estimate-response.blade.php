@extends('layouts.app_m')

@php
    $only_quick = '';
    $header_depth = 'mypage';
    $top_title = '견적서 관리';
    $header_banner = '';
@endphp

@section('content')
    @include('layouts.header_m')

    <div id="content">
    <div class="flex">
            <a href="/mypage/estimateInfo" class="flex items-center justify-center py-3 text-sm text-primary font-bold grow border-b-2 border-primary text-center">견적서 관리</a>
            <a href="/mypage/responseEstimateMulti" class="flex items-center justify-center py-3 text-stone-400 text-sm font-bold grow border-b border-stone-200 text-center">견적서 보내기</a>
        </div>
        
        <div class="inner">
            <a href="/mypage/responseEstimate" class="flex items-center gap-3 mt-4">
                <p class="font-bold">요청받은 견적서 현황</p>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
            </a>
            <div class="st_box w-full grid grid-cols-2 gap-2.5 px-5 mt-3 py-2 !h-auto">
                <a href="/mypage/responseEstimate?status=N" class="flex gap-5 justify-center items-center flex-1">
                    <p class="text-sm">요청받은 견적</p>
                    <p class="text-sm main_color font-bold">{{ $info[0] -> count_res_n }}</p>
                </a>
                <a href="/mypage/responseEstimate?statun=R" class="flex gap-5 justify-center items-center flex-1">
                    <p class="text-sm">보낸 견적</p>
                    <p class="text-sm font-bold">{{ $info[0] -> count_res_r }}</p>
                </a>
                <a href="/mypage/responseEstimate?statun=O" class="flex gap-5 justify-center items-center flex-1">
                    <p class="text-sm">주문서 수</p>
                    <p class="text-sm main_color font-bold">{{ $info[0] -> count_res_o }}</p>
                </a>
                <a href="/mypage/responseEstimate?statun=F" class="flex gap-5 justify-center items-center flex-1">
                    <p class="text-sm">확인/완료</p>
                    <p class="text-sm font-bold">{{ $info[0] -> count_res_f }}</p>
                </a>
            </div>
        </div>

        <div class="mt-3 pt-3 bg-stone-100"></div>

        <div class="p-4 bg-white flex items-center gap-2 shadow-sm">
            <button class="flex items-center justify-between gap-1 h-[32px] border border-stone-300 rounded-sm px-2" onclick="modalOpen('#estimate_date_modal')">
                <span>{{ request() -> estimateDate ? request() -> estimateDate : '전체 기간' }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-4 h-4"><path d="m6 9 6 6 6-6"/></svg>
            </button>
            <button class="flex items-center justify-between gap-1 h-[32px] border border-stone-300 rounded-sm px-2" onclick="modalOpen('#keyword_type_modal')">
                <span>{{ $keywordTypeText }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-4 h-4"><path d="m6 9 6 6 6-6"/></svg>
            </button>
            <button class="flex items-center justify-between gap-1 h-[32px] border border-stone-300 rounded-sm px-2" onclick="keywordModalOpen()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search w-4 h-4"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <span>{{ request() -> keyword ? request() -> keyword : '검색' }}</span>
            </button>
        </div>

        @if ($response['count'] >= 1)
        <div class="inner py-3">
            전체 <span>{{ $response['count'] }}개</span>
        </div>
        @endif
        
        <!-- 리스트 최대 10개 -->
        <div class="bg-stone-100">
            <div class="py-3">
                <ul class="flex flex-col gap-3">
                @if ($response['count'] < 1)
                    <li class="no_prod txt-gray">
                        데이터가 존재하지 않습니다. 다시 조회해주세요.
                    </li>
                @else
                    @foreach($response['list'] as $list)
                    <li class="bg-white shadow-sm">
                        <div class="p-4 rounded-t-sm border-b">
                            <div class="flex items-center">
                                <span class="bg-primaryop p-1 text-xs text-primary rounded-sm font-medium">{{ config('constants.ESTIMATE.STATUS.RES')[$list -> estimate_state] }}</span>
                                <span class="ml-2">{{ $list -> estimate_code }}</span>
                                <span class="ml-auto text-stone-400">{{ $list -> request_time ? $list -> request_time : '('.$list -> response_time.')' }}</span>
                            </div>
                        </div>
                        <div class="p-4">
                            <p class="font-bold text-base">{{ $list -> name }}</a>{{ $list -> cnt > 1 ? ' 외 '.$list -> cnt.'개' : ''}}</p>
                            <p class="mt-1 text-stone-500">{{ $list -> request_company_name }}</p>
                        </div>
                        <div class="px-4 pb-4 rounded-b-sm flex justify-between gap-2">
                            @if ($list -> estimate_state == 'N')
                            <a href="javascript:void(0);" class="flex items-center justify-center h-[42px] text-primary border border-primary font-medium w-full rounded-sm request_estimate_detail"
                                data-idx="{{ $list -> estimate_idx }}" data-group_code="{{ $list -> estimate_group_code }}" data-code="{{ $list -> estimate_code }}" data-response_company_type="{{ $list -> company_type }}">견적 요청서 확인</a>
                            @elseif ($list -> estimate_state == 'R' || $list -> estimate_state == 'H')
                            <a href="javascript:void(0);" class="flex items-center justify-center h-[42px] text-primary border border-primary font-medium w-full rounded-sm check_estimate_detail"
                                data-idx="{{ $list -> estimate_idx }}" data-group_code="{{ $list -> estimate_group_code }}" data-code="{{ $list -> estimate_code }}" data-response_company_type="{{ $list -> company_type }}">견적서 확인</a>
                            @elseif ($list -> estimate_state == 'O' || $list -> estimate_state == 'F')
                            <a href="javascript:void(0);" class="flex items-center justify-center h-[42px] text-primary border border-primary font-medium w-full rounded-sm check_order_detail"
                                data-idx="{{ $list -> estimate_idx }}" data-group_code="{{ $list -> estimate_group_code }}" data-code="{{ $list -> estimate_code }}" data-response_company_type="{{ $list -> company_type }}">주문서 확인</a>
                            @endif
                        </div>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
        {{-- 
        <div class="pagenation flex items-center justify-center py-6">
            <a href="javascript:;" class="active">1</a>
            <a href="javascriot:;">2</a>
            <a href="javascriot:;">3</a>
            <a href="javascriot:;">4</a>
            <a href="javascriot:;">5</a>
        </div>
        --}}
    </div>

    <!-- 검색 유형 -->
    <div id="keyword_type_modal" class="modal">
        <div class="modal_bg" onclick="modalClose('#keyword_type_modal')"></div>
        <div class="modal_inner modal-md">
            <div class="modal_body filter_body">
                <h4>검색 유형</h4>
                <div class="text-sm py-3">
                    <div class="check_radio flex flex-col justify-center divide-y divide-stone-100">
                        <div class="text-stone-400 py-2">
                            <input type="radio" name="keyword_type" id="keyword_type01" data-type="" />
                            <label for="keyword_type01" class="flex items-center gap-1 text-sm">
                                전체
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-4 h-4"><path d="M20 6 9 17l-5-5"/></svg>
                            </label>
                        </div>
                        <div class="text-stone-400 py-2">
                            <input type="radio" name="keyword_type" id="keyword_type02" data-type="estimateCode" />
                            <label for="keyword_type02" class="flex items-center gap-1 text-sm">
                                요청번호
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-4 h-4"><path d="M20 6 9 17l-5-5"/></svg>
                            </label>
                        </div>
                        <div class="text-stone-400 py-2">
                            <input type="radio" name="keyword_type" id="keyword_type03" data-type="productName" />
                            <label for="keyword_type03" class="flex items-center gap-1 text-sm">
                                상품명
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-4 h-4"><path d="M20 6 9 17l-5-5"/></svg>
                            </label>
                        </div>
                        <div class="text-stone-400 py-2">
                            <input type="radio" name="keyword_type" id="keyword_type04" data-type="companyName" />
                            <label for="keyword_type04" class="flex items-center gap-1 text-sm">
                                판매 업체
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-4 h-4"><path d="M20 6 9 17l-5-5"/></svg>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center">
                    <button class="bg-primary text-white h-[42px] rounded-sm w-full font-medium" onclick="searchEstimateKeywordType()">확인</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 전체 기간 -->
    <div id="estimate_date_modal" class="modal">
        <div class="modal_bg" onclick="modalClose('#estimate_date_modal')"></div>
        <div class="modal_inner modal-md">
            <div class="modal_body filter_body">
                <h4>검색 기간</h4>
                <div class="py-3">
                    <div class="flex items-center gap-2">
                        <div class="flex items-center justify-between h-[42px] border rounded-sm px-2 w-full">
                            <input type="text" name="estimateStartDate" id="estimateStartDate" value="{{ request() -> get('estimateDate') ? explode('~', request() -> get('estimateDate'))[0] : '' }}" class="w-full" onclick="openCalendar()" readonly />
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar w-4 h-4 text-stone-400"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
                        </div>
                        -
                        <div class="flex items-center justify-between h-[42px] border rounded-sm px-2 w-full">
                            <input type="text" name="estimateEndDate" id="estimateEndDate" value="{{ request() -> get('estimateDate') ? explode('~', request() -> get('estimateDate'))[1] : '' }}" class="w-full" onclick="openCalendar()" readonly />
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar w-4 h-4 text-stone-400"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center">
                    <button class="bg-primary text-white h-[42px] rounded-sm w-full font-medium" onclick="searchEstimateDate()">확인</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 검색 -->
    <div id="keyword_modal" class="modal">
        <div class="modal_bg" onclick="modalClose('#keyword_modal')"></div>
        <div class="modal_inner modal-md">
            <div class="modal_body filter_body">
                <h4>검색</h4>
                <div class="flex items-center py-3">
                    <div class="setting_input h-[42px]  w-full flex items-center gap-3" onclick="modalOpen('#keyword_modal')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search w-5 h-5 text-stone-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        <input type="text" id="keyword" class="w-full h-full font-normalflex items-center" value="{{ request() -> get('keyword') }}" placeholder="검색어를 입력해주세요." />
                    </div>
                </div>
                <div class="flex justify-center">
                    <button class="bg-primary text-white h-[42px] rounded-sm w-full font-medium" onclick="searchKeyword()">검색</button>
                </div>
            </div>
        </div>
    </div>



<!-- 견적요청서 확인 및 작성 -->
<div class="modal" id="request_confirm_write-modal">
    <div class="modal_bg" onclick="modalClose('#request_confirm_write-modal')"></div>
    <div class="modal_inner new-modal">
        <div class="modal_header">
            <h3>견적 요청서 확인 및 작성</h3>
            <button class="close_btn" onclick="modalClose('#request_confirm_write-modal')"><img src="./pc/img/icon/x_icon.svg" alt=""></button>
        </div>

        <div class="modal_body">
            <!-- // -->
        </div>

        <div class="modal_footer">
            <button class="close_btn" onclick="modalClose('#request_confirm_write-modal')">견적보류 닫기</button>
            <button type="button" onClick="updateResponse();">견적서 완료하기 <img src="/img/icon/arrow-right.svg" alt=""></button>
        </div>
    </div>
</div>

<!-- 견적서 확인하기 -->
<div class="modal" id="check_estimate-modal">
	<div class="modal_bg" onclick="modalClose('#check_estimate-modal')"></div>
	<div class="modal_inner new-modal">
        <div class="modal_header">
            <h3>보낸 견적서</h3>
            <button class="close_btn" onclick="modalClose('#check_estimate-modal')"><img src="/pc/img/icon/x_icon.svg" alt=""></button>
        </div>
		<div class="modal_body">
            
		</div>

        <div class="modal_footer">
            <button type="button" onclick="modalClose('#check_estimate-modal')">닫기</button>
        </div>
    </div>
</div>

<!-- 주문서 확인하기 -->
<div class="modal" id="check_order-modal">
    <div class="modal_bg" onclick="modalClose('#check_order-modal')"></div>
    <div class="modal_inner new-modal">
        <div class="modal_header">
            <h3>주문서</h3>
            <button class="close_btn" onclick="modalClose('#check_order-modal')"><img src="/pc/img/icon/x_icon.svg" alt=""></button>
        </div>

        <div class="modal_body">
            
        </div>

        <div class="modal_footer">
            <button class="close_btn" type="button" onclick="holdOrder()">주문 보류</button>
            <button type="button" type="button" onclick="saveOrder()"><span class="prodCnt">00</span>건 주문 확인 <img src="./pc/img/icon/arrow-right.svg" alt=""></button>
        </div>
    </div>
</div>



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ko.js"></script>
    <script src="/js/jquery-1.12.4.js?{{ date('Ymdhis') }}"></script>
    <script>
        var estimate_idx = 0;
        var estimate_code = "";
        var response_company_type = "";

        let params = {
            
        };

        const searchEstimateKeywordType = () => {
            params = { 
                keywordType             : $('[name="keyword_type"]:checked').data('type') ? $('[name="keyword_type"]:checked').data('type') : '',
                estimateDate            : '{{ request() -> estimateDate }}' ? '{{ request() -> estimateDate }}' : '',
                keyword                 : '{{ request() -> keyword }}' ? '{{ request() -> keyword }}' : '',
            };

            searchEstimate(params);
        }

        document.addEventListener('DOMContentLoaded', function(){
            var datepicker = flatpickr('#estimateStartDate', {
                clickOpens      : false,   //input 클릭으로는 달력이 열리지 않음
                dateFormat      : 'Y-m-d', //기본 날짜 형식
                locale          : 'ko',    //한국어
                onChange        : function(selectedDates, dateStr, instance) {
                    // 커스텀 포맷으로 날짜 표시 (예:   2024-01-01~2024-01-02)
                    var formattedDate = selectedDates[0].toJSON().slice(0, 10);
                    instance.input.value = formattedDate;   //input에 커스텀 형식 적용
                }
            });

            // 아이콘 클릭 > 달력 열기
            window.openCalendar = function(){
                datepicker.open();
            };
        });

        document.addEventListener('DOMContentLoaded', function(){
            var datepicker = flatpickr('#estimateEndDate', {
                clickOpens      : false,   //input 클릭으로는 달력이 열리지 않음
                dateFormat      : 'Y-m-d', //기본 날짜 형식
                locale          : 'ko',    //한국어
                onChange        : function(selectedDates, dateStr, instance) {
                    // 커스텀 포맷으로 날짜 표시 (예:   2024-01-01~2024-01-02)
                    var formattedDate = selectedDates[0].toJSON().slice(0, 10);
                    instance.input.value = formattedDate;   //input에 커스텀 형식 적용
                }
            });

            // 아이콘 클릭 > 달력 열기
            window.openCalendar = function(){
                datepicker.open();
            };
        });

        const searchEstimateDate = () => {
            /*
            if(!$('#estimateStartDate').val()) {
                alert('기간 시작일을 선택해주세요.')
                return false;
            }

            if(!$('#estimateEndDate').val()) {
                alert('기간 종료일을 선택해주세요.')
                return false;
            }
            */

            params = { 
                keywordTypeText         : '{{ request() -> keywordType }}' ? '{{ request() -> keywordType }}' : '',
                estimateDate            : 
                    ($('#estimateStartDate').val() && $('#estimateEndDate').val()) ? 
                        $('#estimateStartDate').val() + '~' + $('#estimateEndDate').val() : '',
                keyword                 : '{{ request() -> keyword }}' ? '{{ request() -> keyword }}' : '',
            };

            searchEstimate(params);
        }

        const keywordModalOpen = () => {
            modalOpen('#keyword_modal');
            setTimeout(function(){ $('#keyword').focus(); }, 50);
        }

        const searchKeyword = () => {
            params = {
                keywordTypeText : '{{ request() -> keywordType }}' ? '{{ request() -> keywordType }}' : '',
                estimateDate    : '{{ request() -> estimateDate }}' ? '{{ request() -> estimateDate }}' : '',
                keyword   : $('#keyword').val()
            }

            searchEstimate(params);
        }

        document.getElementById('keyword').addEventListener('keyup', e => {
            params = {
                keywordType         : '{{ request() -> keywordType }}' ? '{{ request() -> keywordType }}' : '',
                estimateDate        : '{{ request() -> estimateDate }}' ? '{{ request() -> estimateDate }}' : '',
                keyword             : e.currentTarget.value
            }
            
            if (e.key === 'Enter') {
                searchEstimate(params);
            }
        });

        const searchEstimate = params => {
            const bodies = params;
            const urlSearch = new URLSearchParams(location.search);

            if (urlSearch.get('keywordType') && typeof bodies.keywordType === 'undefined') {
                bodies.keywordType = urlSearch.get('keywordType');
            } else if (bodies.keywordType === '') {
                delete bodies['keywordType'];
            }

            if (urlSearch.get('estimateDate') && typeof bodies.estimateDate === 'undefined') {
                bodies.estimateDate = urlSearch.get('estimateDate');
            } else if (bodies.estimateDate === '') {
                delete bodies['estimateDate'];
            }

            if (urlSearch.get('keyword') && typeof bodies.keyword === 'undefined') {
                bodies.keyword = urlSearch.get('keyword');
            } else if (bodies.keyword === '') {
                delete bodies['keyword'];
            }

            if (urlSearch.get('offset') && typeof bodies.offset === 'undefined') {
                bodies.offset = urlSearch.get('offset');
            } else if (bodies.offset === '') {
                delete bodies['offset'];
            }

            location.href = '/mypage/requestEstimate?' + new URLSearchParams(bodies);
        }

        const moveToEstimatePage = page => {
            const urlSearch = new URLSearchParams(location.search);
            let bodies = { offset: page };

            if (urlSearch.get('keywordType'))        bodies.keywordType = urlSearch.get('keywordType');
            if (urlSearch.get('estimateDate'))     bodies.estimateDate = urlSearch.get('estimateDate');
            if (urlSearch.get('keyword'))       bodies.keyword = urlSearch.get('keyword');

            location.replace('/mypage/requestEstimate?' + new URLSearchParams(bodies));
        }


    function getToday(afterDay){
        var date = new Date();
        date.setTime(new Date().getTime() + 1000*60*60*24* afterDay);
        var year = date.getFullYear();
        var month = ("0" + (1 + date.getMonth())).slice(-2);
        var day = ("0" + date.getDate() + afterDay).slice(-2);

        return year + "-" + month + "-" + day;
    }
    const updateResponse = () => {

        let products = [];

        sum_price = 0;
        $('.fold_area .prod_info').each(function (index) {
        	product_price = 0;
            products.push({
                estimate_idx: estimate_idx,
                estimate_code: estimate_code,
                estimate_group_code: estimate_group_code,
                response_company_type: response_company_type,
                //
                product_idx: estimate_data.product_idx,
                product_count: estimate_data.product_count,
                name: estimate_data.name,
                product_total_price: estimate_data.price,
                response_estimate_estimate_total_price: 0,
                memo: estimate_data.request_memo,

                address1: estimate_data.request_address1,
                phone_number: estimate_data.request_phone_number,
                register_time: estimate_data.request_time,
                response_estimate_req_user_idx: estimate_data.request_company_idx,
 
                response_estimate_res_company_name: '{{ $user -> company_name }}',
                response_estimate_res_business_license_number: '{{ $user -> business_license_number }}',
                response_estimate_res_phone_number: '{{ $user -> phone_number }}',
                response_estimate_res_address1: estimate_data.product_address || '',
                response_estimate_account1: "",
                response_estimate_response_account2: "",
                response_estimate_res_memo: "", 
                response_estimate_res_time: getToday(0),
                expiration_date: getToday(15),
                response_estimate_product_each_price: estimate_data.product_each_price || 0,
                response_estimate_product_delivery_info: estimate_data.product_delivery_info || '',
                response_estimate_product_option_price: estimate_data.product_option_price || 0,
                response_estimate_product_delivery_price: estimate_data.product_delivery_price || 0,
                response_estimate_product_total_price: 0,
                product_memo:estimate_data.product_memo || '',
                response_estimate_product_memo: estimate_data.product_memo || '',
            });


            $(this).find('input').each(function (idx, item) {
                let i_name = $(item).attr('name'); // name 속성 가져오기
                let i_val = '';
                if(i_name == 'price'){
					i_val = parseInt($(item).val()); // 값 가져오기	
					if(isNaN(i_val)){
						product_price = 0;
						i_val = 0;
					}else{
						product_price = i_val;
					}
                    products[index][i_name] = i_val;
                }else{
                	i_val = $(item).val(); // 값 가져오기	
                    products[index][i_name] = i_val;
                }
            });
            
            products[index]['product_delivery_info_temp'] = $('#delivery_type').text();
            
            var delivery_price = 0;
            if($('#delivery_type').text() == '착불'){
            	delivery_price = $('#delivery_price').val()
            	if(delivery_price == ''){
            		delivery_price = 0;
            	}
            }else{
            	delivery_price = 0
            }
            products[index]['product_delivery_price_temp'] = delivery_price;
            
            if($('#bank_type').text() != '은행선택'){
                products[index]['response_estimate_account1'] = $('#bank_type').text();
                products[index]['response_estimate_response_account2'] = $('#account_number').val();
            }else {
                products[index]['response_estimate_account1'] = "";
                products[index]['response_estimate_response_account2'] = "";
            }
            products[index]['request_memo'] = $('#etc_memo').val();
            products[index]['response_memo'] = $('#response_memo').val();
            products[index]['response_estimate_res_memo'] = $('#response_memo').val();
            
            sum_price += product_price;
        });
        
        $('.fold_area .prod_info').each(function (index) {
            products[index]['response_estimate_estimate_total_price'] = sum_price;
            products[index]['response_estimate_product_total_price'] = sum_price;
        });
        
        $.ajax({
            url: '/estimate/updateResponse',
            type: 'post',
			processData	: false,
			contentType: 'application/json',
            data: JSON.stringify(products),
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            success: function (res) {
                if (res.success) {
                    $('#loadingContainer').hide();
                    alert('견적서 보내기가 완료되었습니다.');
                    location.reload(); 
                } else {
                    $('#loadingContainer').hide();
                    alert('일시적인 오류로 처리되지 않았습니다.');
                    return false;
                }
            }, error: function (xhr, status, error) {
                console.error("오류 발생: ", status, error);
                alert("문제가 발생했습니다. 다시 시도해 주세요.");
            }
        });
        
        /*$('#loadingContainer').show();
        fetch('/estimatedev/updateResponse', {
            method  : 'POST',
            headers : {
                'X-CSRF-TOKEN'  : '{{csrf_token()}}'
            },
            body    : formData
        }).then(response => {
            return response.json();
        }).then(json => {
            
        });*/
    }

        $(document).ready(function(){

            $('.request_estimate_detail').click(function (){
                estimate_idx = $(this).data('idx');
                estimate_code = $(this).data('code');
                estimate_group_code = $(this).data('group_code');
                response_company_type = $(this).data('response_company_type');

                $.ajax({
                    url: '/mypage/requestEstimateDevDetail',
                    type: 'post',
                    data: {
                        'group_code'   : estimate_group_code
                    },
                    dataType: 'JSON',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                    },
                    success: function (res) {
                        if( res.result === 'success' ) {
                            console.log( res );
                            estimate_data = res.data;
                            $('#request_confirm_write-modal .modal_body').empty().append(res.html);
                            $('.prodCnt').text( res.data.length );
                            modalOpen('#request_confirm_write-modal');
                        } else {
                            alert(res.message);
                        }
                    }, error: function (e) {

                    }
                });
            });

            // 견적서 확인하기
            $('.check_estimate_detail').click(function(){
                estimate_idx = $(this).data('idx');
                estimate_code = $(this).data('code');
                estimate_group_code = $(this).data('group_code');
                response_company_type = $(this).data('response_company_type');

                $.ajax({
                    url: '/mypage/responseEstimateDevDetail',
                    type: 'post',
                    data: {
                        'group_code'   : estimate_group_code
                    },
                    dataType: 'JSON',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                    },
                    success: function (res) {
                        if( res.result === 'success' ) {
                            console.log( res );
                            estimate_data = res.data;
                            $('#check_estimate-modal .modal_body').empty().append(res.html);
                            $('.prodCnt').text( res.data.length );
                            modalOpen('#check_estimate-modal');
                        } else {
                            alert(res.message);
                        }
                    }, error: function (e) {

                    }
                });
            });

            $('.check_order_detail').click(function(){
                estimate_idx = $(this).data('idx');
                estimate_code = $(this).data('code');
                estimate_group_code = $(this).data('group_code');

                $.ajax({
                    url: '/mypage/estimate/order/detail',
                    type: 'post',
                    data: {
                        'group_code'   : estimate_group_code
                    },
                    dataType: 'JSON',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                    },
                    success: function (res) {
                        if( res.result === 'success' ) {
                            console.log( res );
                            estimate_data = res.data.lists;
                            $('#check_order-modal .modal_body').empty().append(res.html);
                            $('.prodCnt').text( res.data.lists.length );
                            modalOpen('#check_order-modal');
                        } else {
                            alert(res.message);
                        }
                    }, error: function (e) {

                    }
                });
            });
        });
        function holdOrder (){
            modalClose('#check_order-modal');
            $.ajax({
                url: '/estimate/order/hold',
                type: 'post',
                data: {
                    'estimate_group_code'   : estimate_group_code
                },
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                },
                success: function (res) {
                    if( res.result === 'success' ) {
                        console.log( res );
                        alert('보류 되었습니다.');
                        location.reload();
                    } else {
                        alert(res.message);
                    }
                }, error: function (e) {

                }
            });
        }
        function saveOrder (){
            $.ajax({
                url: '/estimate/order/save',
                type: 'post',
                data: {
                    'estimate_group_code'   : estimate_group_code
                },
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                },
                success: function (res) {
                    if( res.result === 'success' ) {
                        console.log( res );
                        alert('저장 되었습니다.');
                        location.reload();
                    } else {
                        alert(res.message);
                    }
                }, error: function (e) {

                }
            });
        }
        const dropBtn = (item)=>{ $(item).toggleClass('active'); $(item).parent().toggleClass('active') };
        const dropItem = (item)=>{
            $(item).parents('.dropdown_wrap').find('.dropdown_btn').text($(item).text());
            $(item).parents('.dropdown_wrap').find('.dropdown_btn').removeClass('active');
            $(item).parents('.dropdown_wrap').removeClass('active');
        };
    </script>
@endsection