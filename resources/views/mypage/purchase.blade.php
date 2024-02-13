<div class="my__section">
    <div class="content">
        <div class="section">
            <div class="section__head">
                <h3 class="section__title">주문 현황</h3>
                <div class="section__info">
                    <div class="section__data">
                        <ul>
                            @foreach($purchaseStatus as $key => $value)
                                <li onclick="searchOrderStatus('{{ $key }}')">
                                    <p>
                                        {{ $value }}
                                        <span>{{$orderCount[$key]}}</span>
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="section__field">
                    <div class="dropdown dropdown--type02" style="width: 150px">
                        <p class="dropdown__title" id="selectedKeywordType" data-keyword-type="{{ request()->get('keywordType') }}">{{ $keywordTypeText }}</p>
                        <div class="dropdown__wrap">
                            <a href="javascript:void(0)" class="dropdown__item" onclick="selectedKeywordType('')">
                                <span>전체</span>
                            </a>
                            <a href="javascript:void(0)" class="dropdown__item" onclick="selectedKeywordType('orderNum')">
                                <span>주문번호</span>
                            </a>
                            <a href="javascript:void(0)" class="dropdown__item" onclick="selectedKeywordType('productName')">
                                <span>상품명</span>
                            </a>
                            <a href="javascript:void(0)" class="dropdown__item" onclick="selectedKeywordType('dealer')">
                                <span>업체명</span>
                            </a>
                        </div>
                    </div>
                    <div class="textfield {{ request()->get('keyword') ? 'textfield--active' : '' }}">
                        <i class="textfield__icon ico__search"><span class="a11y">검색</span></i>

                        <input type="text" class="textfield__search" name="keyword" id="keyword" value="{{ request()->get('keyword') }}" placeholder="검색어를 입력해주세요" style="width: 480px;">
                        <button type="button" class="textfield__icon--delete ico__sdelete"><span class="a11y">삭제하기</span></button>
                    </div>
                    <div class="calendar">
                        <input type="text" id="orderDate" name="orderDate" value="{{ request()->get('orderDate') }}" placeholder="전체 기간" readonly/>
                    </div>
                </div>
            </div>
            @if (count($orders) < 1)
                <div class="list">
                    <div class="list__meta-wrap">
                        <p class="list__total">전체 0개</p>
                    </div>
                    <div class="no-data">
                        <i class="ico__warning"></i>
                        <p>결과값이 없습니다. 다시 조회해주세요.</p>
                    </div>
                </div>
            @else
            <div class="list">
                <div class="list__meta-wrap">
                    <p class="list__total">전체 {{ $orderListCount }}개</p>
                </div>
                <table>
                    <thead>
                    <tr>
                        <th style="width: 70px">No</th>
                        <th style="width: 100px">주문번호</th>
                        <th style="width: 100px">주문일자</th>
                        <th style="width: 110px">주문 상태</th>
                        <th style="width: 262px">주문 상품</th>
                        <th style="width: 155px">업체</th>
                        <th style="width: 113px">관리</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $orderListCount - $loop->index - (($offset - 1) * $limit) }}</td>
                            <td>{{ $order->order_code }}</td>
                            <td>{{ $order->register_time }}</td>
                            <td>{{ config('constants.ORDER.STATUS.P')[$order->order_state] }}</td>
                            <td class="link">
                                <a href="/mypage/order/detail?orderGroupCode={{ $order->order_group_code }}&type=P">
                                    <span>
                                        {{ $order->product_name }}
                                    </span>
                                </a>
                            </td>
                            <td>
                                <span class="target">
                                    {{ $order->company_name }}
                                </span>
                            </td>
                            <td>
                                <div class="button-popup">
                                    @if($order->order_state === 'N') {{-- 신구 주문 --}}
                                    <button type="button" onclick="location.href='/mypage/order/cancel?orderGroupCode={{ $order->order_group_code }}&type=P&state=C'">주문 취소</button>
                                    @elseif($order->order_state === 'W') {{-- 구매 확정 대기 --}}
                                    <button type="button" onclick="changeStatus('{{$order->order_group_code}}', 'F', 'P');">구매 확정</button>
                                    @else
                                        -
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="pagenation pagination--center">
                    @if($pagination['prev'] > 0)
                    <button type="button" class="prev" onclick="moveToOrderPage({{ $pagination['prev'] }})">
                        <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 1L1 6L6 11" stroke="#DBDBDB" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    @endif
                    <div class="numbering">
                        @foreach($pagination['pages'] as $paginate)
                            @if ($paginate == $offset)
                                <a href="javascript:void(0)" onclick="moveToOrderPage({{ $paginate }})" class="numbering--active">{{ $paginate }}</a>
                            @else
                                <a href="javascript:void(0)" onclick="moveToOrderPage({{ $paginate }})">{{ $paginate }}</a>
                            @endif
                        @endforeach
                    </div>
                    @if($pagination['next'] > 0)
                    <button type="button" class="next" onclick="moveToOrderPage({{ $pagination['next'] }})">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 12L10 7L5 2" stroke="#828282" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.getElementById('purchase-new_badge').classList.add('hidden');

        const moveToOrderPage = page => {
            let bodies = {offset:page};
            const urlSearch = new URLSearchParams(location.search);
            if (urlSearch.get('keywordType')) bodies.keyword = urlSearch.get('keywordType');
            if (urlSearch.get('keyword')) bodies.board_name = urlSearch.get('keyword');
            if (urlSearch.get('orderDate')) bodies.board_name = urlSearch.get('orderDate');
            location.replace("/mypage/purchase?" + new URLSearchParams(bodies));
        }

        const searchOrderStatus = status => {
            const params = {status: status};
            searchOrder(params);
        }

        const searchOrder = params => {
            const bodies = params;
            const urlSearch = new URLSearchParams(location.search);
            if (urlSearch.get('offset') && typeof bodies.offset === 'undefined') {
                bodies.offset = urlSearch.get('offset');
            } else if (bodies.offset === ''){
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
            location.href = "/mypage/purchase?" + new URLSearchParams(bodies);
        }

        const selectedKeywordType = type => {
            document.getElementById('selectedKeywordType').dataset.keywordType = type;
        }

        document.getElementById('keyword').addEventListener('keyup', e => {
            const params = {
                keywordType: (document.getElementById('selectedKeywordType').dataset.keywordType ?? ''),
                keyword: e.currentTarget.value,
                orderDate: document.getElementById('orderDate').value
            }
            if (e.key === 'Enter') { // enter key
                searchOrder(params);
            }
        })

        const submitFilter = () => {
            {document.getElementById('orderDate').value}
            searchOrder({orderDate : document.getElementById('orderDate').value});
        }

        $(document).on('click', '#calendarAllBtn', function() {
            document.getElementById('orderDate').value = '';
            searchOrder({orderDate : ''});
        })
    </script>
@endpush
