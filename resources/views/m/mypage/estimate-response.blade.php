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
                            <a href="/mypage/sendResponseEstimate/{{ $list -> estimate_idx }}" class="flex items-center justify-center h-[42px] text-primary border border-primary font-medium w-full rounded-sm request_estimate_detail">견적 요청서 확인</a>
                            @elseif ($list -> estimate_state == 'R' || $list -> estimate_state == 'H')
                            <a href="/mypage/checkResponseEstimate/{{ $list -> estimate_idx }}" class="flex items-center justify-center h-[42px] text-primary border border-primary font-medium w-full rounded-sm check_estimate_detail">견적서 확인</a>
                            @elseif ($list -> estimate_state == 'O' || $list -> estimate_state == 'F')
                            <a href="/mypage/checkOrder/{{ $list -> estimate_code }}" class="flex items-center justify-center h-[42px] text-primary border border-primary font-medium w-full rounded-sm check_order_detail">주문서 확인</a>
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





    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ko.js"></script>
    <script src="/js/jquery-1.12.4.js?{{ date('Ymdhis') }}"></script>
    <script>
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



        $(document).ready(function(){

        });
    </script>
@endsection