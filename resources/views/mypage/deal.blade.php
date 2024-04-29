<div class="w-full">
    <h3 class="text-xl font-bold">판매 현황</h3>

    <div class="st_box w-full flex items-center gap-2.5 px-5 mt-5">
        <a href="/mypage/responseEstimate?status=N" class="flex gap-5 justify-center items-center flex-1">
            <p class="text-sm">요청받은 견적</p>
            <p class="text-sm main_color font-bold">{{ $info[0] -> count_res_n }}</p>
        </a>
        <p class="line h-full"></p>
        <a href="/mypage/responseEstimate?status=R" class="flex gap-5 justify-center items-center flex-1">
            <p class="text-sm">보낸 견적</p>
            <p class="text-sm font-bold">{{ $info[0] -> count_res_r }}</p>
        </a>
        <p class="line h-full"></p>
        <a href="/mypage/responseEstimate?status=O" class="flex gap-5 justify-center items-center flex-1">
            <p class="text-sm">주문서 수</p>
            <p class="text-sm main_color font-bold">{{ $info[0] -> count_res_o }}</p>
        </a>
        <p class="line h-full"></p>
        <a href="/mypage/responseEstimate?status=F" class="flex gap-5 justify-center items-center flex-1">
            <p class="text-sm">확인/완료</p>
            <p class="text-sm font-bold">{{ $info[0] -> count_res_f }}</p>
        </a>
    </div>

    <div class="my_filterbox flex w-full gap-2.5 mt-5 mb-7">
        <div>
            <a id="selectedKeywordType" class="filter_border filter_dropdown w-[170px] h-full flex justify-between items-center" data-keyword-type="{{ request() -> get('keywordType') }}">
                <p>{{ $keywordTypeText }}</p>
                <svg class="w-6 h-6 filter_arrow"><use xlink:href="/img/icon-defs.svg#drop_b_arrow"></use></svg>
            </a>
            <div class="filter_dropdown_wrap w-[170px]">
                <ul>
                    <li>
                        <a href="javascript: void(0);" class="flex items-center" data-type="">전체</a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="flex items-center" data-type="orderNum">주문번호</a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="flex items-center" data-type="productName">상품명</a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="flex items-center" data-type="purchaser">구매 업체</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="filter_border flex items-center w-full">
            <svg class="w-6 h-6" class="filter_arrow"><use xlink:href="/img/icon-defs.svg#Search"></use></svg>
            <input type="search" name="keyword" id="keyword" class="ml-3 w-full" value="{{ request() -> get('keyword') }}" placeholder="검색어를 입력해주세요." />
        </div>
        <div class="flex filter_calendar filter_border w-[270px] h-full items-center justify-between shrink-0">
            <input type="text" name="orderDate" id="orderDate" class="cursor_default w-full h-full" value="{{ request() -> get('orderDate') }}" placeholder="전체 기간" readOnly />
            <svg class="w-5 h-5 cursor-pointer" onClick="openCalendar();"><use xlink:href="/img/icon-defs.svg#Calendar"></use></svg>
        </div>
    </div>

    @if (count($orders) >= 1)
    <div>
        전체 <span>{{ $orderListCount }}개</span>
    </div>
    @endif

    <div class="mt-4">
        @if (count($orders) < 1)
        <ul>
            <li class="no_prod txt-gray">
                데이터가 존재하지 않습니다. 다시 조회해주세요.
            </li>
        </ul>
        @else
        <table class="my_table table-auto w-full">
            <thead>
                <th>No</th>
                <th>주문번호</th>
                <th>주문일자</th>
                <th>거래 상태</th>
                <th>주문 상품</th>
                <th>구매 업체</th>
                <th>관리</th>
            </thead>
            <tbody class="text-center">
                @foreach($orders as $order)
                <tr>
                    <td>{{ $orderListCount - $loop -> index - (($offset - 1) * $limit) }}</td>
                    <td class="orderNum">{{ $order -> order_code }}</td>
                    <td>{{ $order -> register_time }}</td>
                    <td>{{ config('constants.ORDER.STATUS.S')[$order -> order_state] }}</td>
                    <td class="text-sky-500 underline">
                        <a href="/mypage/order/detail?orderGroupCode={{ $order -> order_group_code }}&type=S">
                            <span>{{ $order -> product_name }}</span>
                        </a>
                    </td>
                    <td>
                        <span class="target">{{ $order -> company_name }}</span>
                    </td>
                    <td>
                        <!-- 기존에 개발되어있던 영역인데, 나중에 다시 쓸 수도 있다고 해서 일단은 주석처리만 해둠-->
                        <!--
                        <div class="button-popup">
                            @if($order -> order_state === 'N')
                            <button type="button" class="btn outline_primary" onClick="changeStatus('{{$order -> order_group_code}}', 'R', 'S');">거래 확정</button>
                            <a class="btn outline_primary mt-3 inlin-block" onClick="window.location.href='/mypage/order/cancel?orderGroupCode={{ $order -> order_group_code }}&type=S&state=C'">거래 취소</a>
                            @elseif($order -> order_state === 'R')
                            <button type="button" class="btn outline_primary" onClick="changeStatus('{{$order -> order_group_code}}', 'D', 'S');">발송</button>
                            <a class="btn outline_primary mt-3 inlin-block" onClick="window.location.href='/community/write-dispatch/{{$order -> order_group_code}}'">배차 신청</a>
                            @elseif($order -> order_state === 'D')
                            <button type="button" class="btn outline_primary" onClick="changeStatus('{{$order -> order_group_code}}', 'W', 'S');">발송 완료</button>
                            @else
                            -
                            @endif
                        </div>
                        -->
                        @if($order -> order_state !== 'C')
                        <select name="order_state" class="order_state">
                            <option value="N" {{ $order -> order_state == 'N' ? 'selected' : '' }}>신규 주문</option>
                            <option value="R" {{ $order -> order_state == 'R' ? 'selected' : '' }}>상품 준비중</option>
                            <option value="D" {{ $order -> order_state == 'D' ? 'selected' : '' }}>발송 중</option>
                            <option value="W" {{ $order -> order_state == 'W' ? 'selected' : '' }}>구매 확정 대기</option>
                            <option value="F" {{ $order -> order_state == 'F' ? 'selected' : '' }}>거래 완료</option>
                        </select>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagenation flex items-center justify-center py-12">
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
</div>





<script src="/js/jquery-1.12.4.js?{{ date('Ymdhis') }}"></script>
<script>
    const searchOrderStatus = status => {
        const params = { status: status };
        searchOrder(params);
    }

    const selectedKeywordType = type => {
        document.getElementById('selectedKeywordType').dataset.keywordType = type;
    }

    const searchOrder = params => {
        const bodies = params;
        const urlSearch = new URLSearchParams(location.search);

        if (urlSearch.get('offset') && typeof bodies.offset === 'undefined') {
            bodies.offset = urlSearch.get('offset');
        } else if (bodies.offset === '') {
            delete bodies['offset'];
        }

        if (urlSearch.get('keywordType') && typeof bodies.keywordType === 'undefined') {
            bodies.keywordType = urlSearch.get('keywordType');
        } else if (bodies.keywordType === '') {
            delete bodies['keywordType'];
        }

        if (urlSearch.get('keyword') && typeof bodies.keyword === 'undefined') {
            bodies.keyword = urlSearch.get('keyword');
        } else if (bodies.keyword === '') {
            delete bodies['keyword'];
        }

        if (urlSearch.get('orderDate') && typeof bodies.orderDate === 'undefined') {
            bodies.orderDate = urlSearch.get('orderDate');
        } else if (bodies.orderDate === '') {
            delete bodies['orderDate'];
        }

        if (urlSearch.get('status') && typeof bodies.status === 'undefined') {
            bodies.status = urlSearch.get('status');
        } else if (bodies.status === '') {
            delete bodies['status'];
        }

        location.href = '/mypage/deal?' + new URLSearchParams(bodies);
    }

    const moveToOrderPage = page => {
        const urlSearch = new URLSearchParams(location.search);
        let bodies = { offset: page };

        if (urlSearch.get('keywordType'))   bodies.keyword = urlSearch.get('keywordType');
        if (urlSearch.get('keyword'))       bodies.keyword = urlSearch.get('keyword');
        if (urlSearch.get('orderDate'))     bodies.orderDate = urlSearch.get('orderDate');
        if (urlSearch.get('status'))        bodies.status = urlSearch.get('status');

        location.replace('/mypage/deal?' + new URLSearchParams(bodies));
    }

    document.addEventListener('DOMContentLoaded', function(){
        var datepicker = flatpickr('#orderDate', {
            clickOpens      : false,   //input 클릭으로는 달력이 열리지 않음
            mode            : 'range', //날짜 범위 선택 모드
            dateFormat      : 'Y-m-d', //기본 날짜 형식
            locale          : 'ko',    //한국어
            onChange        : function(selectedDates, dateStr, instance) {
                // 선택된 날짜가 2개인 경우 (시작 / 종료)
                if (selectedDates.length === 2) {
                    // 커스텀 포맷으로 날짜 표시 (예:   2024-01-01~2024-01-02)
                    var formattedDate = selectedDates[0].toJSON().slice(0, 10) + '~' + selectedDates[1].toJSON().slice(0, 10);
                    instance.input.value = formattedDate;   //input에 커스텀 형식 적용
                }
            }
        });
        $('#orderDate').val('{{ request() -> get("orderDate") }}');

        // 아이콘 클릭 > 달력 열기
        window.openCalendar = function(){
            datepicker.open();
        };
    });

    document.getElementById('keyword').addEventListener('keyup', e => {
        const params = {
            keywordType     : (document.getElementById('selectedKeywordType').dataset.keywordType ?? ''),
            keyword         : e.currentTarget.value,
            orderDate       : document.getElementById('orderDate').value
        }

        if (e.key === 'Enter') {
            searchOrder(params);
        }
    });



    $(document).ready(function(){
        $('.filter_dropdown').click(function(e){
            $(this).toggleClass('active');

            $('.filter_dropdown_wrap').toggle();
            $('.filter_dropdown svg').toggleClass('active');

            e.stopPropagation();
        });

        $('.filter_dropdown_wrap ul li a').click(function(){
            var selectedText = $(this).text();
            $('.filter_dropdown p').text(selectedText);

            selectedKeywordType($(this).data('type'));

            $('.filter_dropdown_wrap').hide();
            $('.filter_dropdown').removeClass('active');
            $('.filter_dropdown svg').removeClass('active');
        });

        $(document).click(function(e){
            var $target = $(e.target);

            if(!$target.closest('.filter_dropdown').length && $('.filter_dropdown').hasClass('active')) {
                $('.filter_dropdown_wrap').hide();

                $('.filter_dropdown').removeClass('active');
                $('.filter_dropdown svg').removeClass('active');
            }
        });

        $('.order_state').change(function(){
            if(confirm('상태값을 변경하시겠습니까?')) {
                fetch('/mypage/order/status', {
                    method  : 'PUT',
                    headers : {
                        'Content-Type'  : 'application/json',
                        'X-CSRF-TOKEN'  : '{{csrf_token()}}'
                    },
                    body    : JSON.stringify({
                        type        : 'S',
                        orderNum    : $(this).closest('tr').find('.orderNum').text(),
                        status      : $(this).val()
                    })
                }).then(response => {
                    return response.json();
                }).then(json => {
                    if (json.result === 'success') {
                        alert('상태값이 변경되었습니다.')
                        location.reload();
                    } else {
                        alert(json.message);
                    }
                });
            }
        });
    });
</script>