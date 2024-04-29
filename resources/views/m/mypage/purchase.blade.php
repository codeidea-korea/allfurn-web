@extends('layouts.app_m')

@php
    $only_quick = '';
    $header_depth = 'mypage';
    $top_title = '구매 현황';
    $header_banner = '';
@endphp

@section('content')
    @include('layouts.header_m')

    <div id="content">
        <div class="sticky top-0 z-10">
            <div class="p-4 bg-white flex items-center gap-2 shadow-sm">
                <button class="flex items-center justify-between gap-1 h-[32px] border border-stone-300 rounded-sm px-2" onclick="modalOpen('#order_state_modal')">
                    <span>{{ request() -> status ? config('constants.ORDER.STATUS.P')[ request() -> status] : '거래 상태' }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-4 h-4"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <button class="flex items-center justify-between gap-1 h-[32px] border border-stone-300 rounded-sm px-2" onclick="modalOpen('#order_date_modal')">
                    <span>{{ request() -> orderDate ? request() -> orderDate : '전체 기간' }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-4 h-4"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <button class="flex items-center justify-between gap-1 h-[32px] border border-stone-300 rounded-sm px-2" onclick="keywordModalOpen()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search w-4 h-4"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <span>{{ request() -> keyword ? request() -> keyword : '검색' }}</span>
                </button>
            </div>
        </div>
    
        @if (count($orders) < 1)
        <div class="flex items-center justify-center bg-stone-50" style="height: calc(100vh - 490px);">
            <p class="text-stone-400">데이터가 존재하지 않습니다. 다시 조회해주세요.</p>
        </div>
        @else
        <div class="bg-stone-100">
            <div class="py-3">
                <ul class="flex flex-col gap-3">
                    @foreach($orders as $order)
                    <li class="bg-white shadow-sm">
                        <a href="/mypage/order/detail?orderGroupCode={{ $order -> order_group_code }}&type=P">
                            <div class="p-4 rounded-t-sm border-b">
                                <div class="flex items-center">
                                    <span class="bg-primaryop p-1 text-xs text-primary rounded-sm font-medium">{{ config('constants.ORDER.STATUS.P')[$order -> order_state] }}</span>
                                    <span class="ml-2">{{ $order -> order_code }}</span>
                                    <span class="ml-auto text-stone-400">{{ $order -> register_time }}</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-4">
                                <div>
                                    <p class="font-bold text-base">{{ $order -> product_name }}</p>
                                    <p class="mt-1 text-stone-500">{{ $order -> company_name }}</p>
                                </div>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="pagenation flex items-center justify-center py-6">
            @if($pagination['prev'] > 0)
            <button type="button" class="prev" onClick="moveToOrderPage({{ $pagination['prev'] }})">
                <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 1L1 6L6 11" stroke="#DBDBDB" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            @endif
            @foreach($pagination['pages'] as $paginate)
                @if ($paginate == $offset)
                <a href="javascript: void(0);" class="active" onClick="moveToOrderPage({{ $paginate }})">{{ $paginate }}</a>
                @else
                <a href="javascript: void(0);" onClick="moveToOrderPage({{ $paginate }})">{{ $paginate }}</a>
                @endif
            @endforeach
            @if($pagination['next'] > 0)
            <button type="button" class="next" onClick="moveToOrderPage({{ $pagination['next'] }})">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12L10 7L5 2" stroke="#828282" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            @endif
        </div>
        @endif
    </div>

    <!-- 거래 상태 -->
    <div id="order_state_modal" class="modal">
        <div class="modal_bg" onclick="modalClose('#order_state_modal')"></div>
        <div class="modal_inner modal-md">
            <div class="modal_body filter_body">
                <h4>거래 상태</h4>
                <div class="text-sm py-3">
                    <div class="check_radio flex flex-col justify-center divide-y divide-stone-100">
                        <div class="text-stone-400 py-2">
                            <input type="radio" name="order_state" id="order_state01" value="" {{ request() -> status == '' ? 'checked' : '' }} />
                            <label for="order_state01" class="flex items-center gap-1 text-sm">
                                전체
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-4 h-4"><path d="M20 6 9 17l-5-5"/></svg>
                            </label>
                        </div>
                        <div class="text-stone-400 py-2">
                            <input type="radio" name="order_state" id="order_state02" value="N" {{ request() -> status == 'N' ? 'checked' : '' }} />
                            <label for="order_state02" class="flex items-center gap-1 text-sm">
                                신규 주문
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-4 h-4"><path d="M20 6 9 17l-5-5"/></svg>
                            </label>
                        </div>
                        <div class="text-stone-400 py-2">
                            <input type="radio" name="order_state" id="order_state03" value="R" {{ request() -> status == 'R' ? 'checked' : '' }} />
                            <label for="order_state03" class="flex items-center gap-1 text-sm">
                                상품 준비중
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-4 h-4"><path d="M20 6 9 17l-5-5"/></svg>
                            </label>
                        </div>
                        <div class="text-stone-400 py-2">
                            <input type="radio" name="order_state" id="order_state04" value="D" {{ request() -> status == 'D' ? 'checked' : '' }} />
                            <label for="order_state04" class="flex items-center gap-1 text-sm">
                                발송 중
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-4 h-4"><path d="M20 6 9 17l-5-5"/></svg>
                            </label>
                        </div>
                        <div class="text-stone-400 py-2">
                            <input type="radio" name="order_state" id="order_state05" value="W" {{ request() -> status == 'W' ? 'checked' : '' }} />
                            <label for="order_state05" class="flex items-center gap-1 text-sm">
                                구매 확정 대기
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-4 h-4"><path d="M20 6 9 17l-5-5"/></svg>
                            </label>
                        </div>
                        <div class="text-stone-400 py-2">
                            <input type="radio" name="order_state" id="order_state06" value="F" {{ request() -> status == 'F' ? 'checked' : '' }} />
                            <label for="order_state06" class="flex items-center gap-1 text-sm">
                                거래 완료
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-4 h-4"><path d="M20 6 9 17l-5-5"/></svg>
                            </label>
                        </div>
                        <div class="text-stone-400 py-2">
                            <input type="radio" name="order_state" id="order_state07" value="C" {{ request() -> status == 'C' ? 'checked' : '' }} />
                            <label for="order_state07" class="flex items-center gap-1 text-sm">
                                거래 취소
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-4 h-4"><path d="M20 6 9 17l-5-5"/></svg>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center">
                    <button class="bg-primary text-white h-[42px] rounded-sm w-full font-medium" onclick="searchOrderState()">확인</button>
                </div>
            </div>
        </div>
    </div>


    <!-- 전체 기간 -->
    <div id="order_date_modal" class="modal">
        <div class="modal_bg" onclick="modalClose('#order_date_modal')"></div>
        <div class="modal_inner modal-md">
            <div class="modal_body filter_body">
                <h4>전체 기간</h4>
                <div class="py-3">
                    <div class="flex items-center gap-2">
                        <div class="flex items-center justify-between h-[42px] border rounded-sm px-2 w-full">
                            <input type="text" name="orderStartDate" id="orderStartDate" value="{{ request() -> get('orderDate') ? explode('~', request() -> get('orderDate'))[0] : '' }}" class="w-full" onclick="openCalendar()" readonly />
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar w-4 h-4 text-stone-400"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
                        </div>
                        -
                        <div class="flex items-center justify-between h-[42px] border rounded-sm px-2 w-full">
                            <input type="text" name="orderEndDate" id="orderEndDate" value="{{ request() -> get('orderDate') ? explode('~', request() -> get('orderDate'))[1] : '' }}" class="w-full" onclick="openCalendar()" readonly />
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar w-4 h-4 text-stone-400"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center">
                    <button class="bg-primary text-white h-[42px] rounded-sm w-full font-medium" onclick="searchOrderDate()">확인</button>
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
                    <div class="setting_input h-[42px]  w-full flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search w-5 h-5 text-stone-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        <input type="search" name="keyword" id="keyword" class="w-full h-full font-normalflex items-center" value="{{ request() -> get('keyword') }}" placeholder="검색어를 입력해주세요." />
                    </div>
                </div>
                <div class="flex justify-center">
                    <button class="bg-primary text-white h-[42px] rounded-sm w-full font-medium" onclick="searchKeyword()">검색</button>
                </div>
            </div>
        </div>
    </div>





    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ko.js"></script>
    <script src="/js/jquery-1.12.4.js?{{ date('Ymdhis') }}"></script>
    <script>
        let params = {
            
        };

        const searchOrderState = () => {
            /*
            if(!$('[name="order_state"]:checked').val()) {
                alert('거래 상태를 선택해주세요.')
                return false;
            }
            */

            params = { 
                status              : $('[name="order_state"]:checked').val() ? $('[name="order_state"]:checked').val() : '',
                orderDate           : '{{ request() -> orderDate }}' ? '{{ request() -> orderDate }}' : '',
                keyword             : '{{ request() -> keyword }}' ? '{{ request() -> keyword }}' : '',
            };

            searchOrder(params);
        }

        document.addEventListener('DOMContentLoaded', function(){
            var datepicker = flatpickr('#orderStartDate', {
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
            var datepicker = flatpickr('#orderEndDate', {
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

        const searchOrderDate = () => {
            /*
            if(!$('#orderStartDate').val()) {
                alert('기간 시작일을 선택해주세요.')
                return false;
            }

            if(!$('#orderEndDate').val()) {
                alert('기간 종료일을 선택해주세요.')
                return false;
            }
            */

            params = { 
                status              : '{{ request() -> status }}' ? '{{ request() -> status }}' : '',
                orderDate           : 
                    ($('#orderStartDate').val() && $('#orderEndDate').val()) ? 
                        $('#orderStartDate').val() + '~' + $('#orderEndDate').val() : '',
                keyword             : '{{ request() -> keyword }}' ? '{{ request() -> keyword }}' : '',
            };

            searchOrder(params);
        }

        const keywordModalOpen = () => {
            modalOpen('#keyword_modal');
            setTimeout(function(){ $('#keyword').focus(); }, 50);
        }

        const searchKeyword = () => {
            params = {
                status          : '{{ request() -> status }}' ? '{{ request() -> status }}' : '',
                orderDate       : '{{ request() -> orderDate }}' ? '{{ request() -> orderDate }}' : '',
                keyword         : $('#keyword').val()
            }

            searchOrder(params);
        }

        document.getElementById('keyword').addEventListener('keyup', e => {
            params = {
                status          : '{{ request() -> status }}' ? '{{ request() -> status }}' : '',
                orderDate       : '{{ request() -> orderDate }}' ? '{{ request() -> orderDate }}' : '',
                keyword         : e.currentTarget.value
            }
            
            if (e.key === 'Enter') {
                searchOrder(params);
            }
        });

        const searchOrder = params => {
            const bodies = params;
            const urlSearch = new URLSearchParams(location.search);

            if (urlSearch.get('status') && typeof bodies.status === 'undefined') {
                bodies.status = urlSearch.get('status');
            } else if (bodies.status === '') {
                delete bodies['status'];
            }

            if (urlSearch.get('orderDate') && typeof bodies.orderDate === 'undefined') {
                bodies.orderDate = urlSearch.get('orderDate');
            } else if (bodies.orderDate === '') {
                delete bodies['orderDate'];
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

            location.href = '/mypage/purchase?' + new URLSearchParams(bodies);
        }

        const moveToOrderPage = page => {
            const urlSearch = new URLSearchParams(location.search);
            let bodies = { offset: page };

            if (urlSearch.get('status'))        bodies.status = urlSearch.get('status');
            if (urlSearch.get('orderDate'))     bodies.orderDate = urlSearch.get('orderDate');
            if (urlSearch.get('keyword'))       bodies.keyword = urlSearch.get('keyword');

            location.replace('/mypage/purchase?' + new URLSearchParams(bodies));
        }



        $(document).ready(function(){

        });
    </script>
@endsection