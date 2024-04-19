<div class="w-full">
    <div class="flex">
        <a href="/mypage/estimateInfo" class="text-xl text-primary font-bold grow border-b-2 border-primary pb-5 text-center">견적서 관리</a>
        <a href="/mypage/responseEstimateMulti" class="text-stone-400 text-xl font-bold grow text-center">견적서 보내기</a>
    </div>           
    <hr>
    <a href="/mypage/requestEstimate" class="flex items-center gpa-3 mt-8">
        <p class="font-bold">요청한 견적서 현황</p>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
    </a>
    <div class="st_box w-full flex items-center gap-2.5 px-5 mt-3">
        <a href="/mypage/requestEstimate?status=N" class="flex gap-5 justify-center items-center flex-1">
            <p class="text-sm">요청한 견적</p>
            <p class="text-sm font-bold">{{ $info[0] -> count_req_n }}</p>
        </a>
        <p class="line h-full"></p>
        <a href="/mypage/requestEstimate?status=R" class="flex gap-5 justify-center items-center flex-1">
            <p class="text-sm">받은 견적</p>
            <p class="text-sm font-bold main_color">{{ $info[0] -> count_req_r }}</p>
        </a>
        <p class="line h-full"></p>
        <a href="/mypage/requestEstimate?status=O" class="flex gap-5 justify-center items-center flex-1">
            <p class="text-sm">주문서 수</p>
            <p class="text-sm main_color font-bold">{{ $info[0] -> count_req_o }}</p>
        </a>
        <p class="line h-full"></p>
        <a href="/mypage/requestEstimate?status=F" class="flex gap-5 justify-center items-center flex-1">
            <p class="text-sm">확인/완료</p>
            <p class="text-sm font-bold">{{ $info[0] -> count_req_f }}</p>
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
                        <a href="javascript: void(0);" class="flex items-center" data-type="estimateCode">요청번호</a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="flex items-center" data-type="productName">상품명</a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="flex items-center" data-type="companyName">판매 업체</a> 
                    </li>
                </ul>
            </div>
        </div>
        <div class="filter_border flex items-center w-full">
            <svg class="w-6 h-6" class="filter_arrow"><use xlink:href="/img/icon-defs.svg#Search"></use></svg>
            <input type="search" name="keyword" id="keyword" class="ml-3 w-full" value="{{ request() -> get('keyword') }}" placeholder="검색어를 입력해주세요." />
        </div>
        <div class="flex filter_calendar filter_border w-[270px] h-full items-center justify-between shrink-0">
            <input type="text" name="requestDate" id="requestDate" class="cursor_default w-full h-full" value="{{ request() -> get('requestDate') }}" placeholder="전체 기간" readOnly />
            <svg class="w-5 h-5 cursor-pointer" onClick="openCalendar();"><use xlink:href="/img/icon-defs.svg#Calendar"></use></svg>
        </div>
    </div>

    @if ($request['count'] >= 1)
    <div>
        전체 <span>{{ $request['count'] }}개</span>
    </div>
    @endif

    <div class="mt-4">
        @if ($request['count'] < 1)
        <ul>
            <li class="no_prod txt-gray">
                데이터가 존재하지 않습니다. 다시 조회해주세요.
            </li>
        </ul>
        @else
        <table class="my_table table-auto w-full">
            <thead>
                <th>No</th>
                <th>요청번호</th>
                <th>요청일자<br />(견적일자)</th>
                <th>견적 상태</th>
                <th>요청 상품</th>
                <th>판매 업체</th>
                <th>관리</th>
            </thead>
            <tbody class="text-center">
                @foreach($request['list'] as $list)
                <tr>
                    <td>{{ $request['count'] - $loop -> index - (($offset - 1) * $limit) }}</td>
                    <td>{{ $list -> estimate_code }}</td>
                    <td>{{ $list -> request_time ? $list -> request_time : '('.$list -> response_time.')' }}</td>
                    <td>{{ config('constants.ESTIMATE.STATUS.REQ')[$list -> estimate_state] }}</td>
                    <td><a href="/product/detail/{{ $list -> product_idx }}" class="text-sky-500 underline" onclick="">{{ $list -> name }}</a>{{ $list -> cnt > 1 ? ' 외 '.$list -> cnt.'개' : ''}}</td>
                    <td>{{ $list -> company_type == 'W' ? $list -> response_w_company_name : $list -> response_r_company_name }}</td>
                    <td>
                        @if ($list -> estimate_state == 'N')
                        <button class="btn outline_primary request_estimate_detail" data-idx="{{ $list -> estimate_idx }}">견적 요청서 확인</button>
                        @elseif ($list -> estimate_state == 'R' || $list -> estimate_state == 'H')
                        <button class="btn outline_primary response_estimate_detail" data-code="{{ $list -> estimate_code }}" data-response_company_type="{{ $list -> company_type }}">견적서 확인</button>
                        @elseif ($list -> estimate_state == 'O' || $list -> estimate_state == 'F')
                        <button class="btn outline_primary check_order_detail" data-code="{{ $list -> estimate_code }}">주문서 확인</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagenation flex items-center justify-center py-12">
            @if (($request['pagination'])['prev'] > 0)
            <button type="button" class="prev" onclick="moveToEstimatePage({{ ($request['pagination'])['prev'] }})">
                <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 1L1 6L6 11" stroke="#DBDBDB" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            @endif
            @foreach (($request['pagination'])['pages'] as $paginate)
                @if ($paginate == $request['offset'])
                <a href="javascript: void(0)" class="active" onclick="moveToEstimatePage({{ $paginate }})">{{ $paginate }}</a>
                @else
                <a href="javascript: void(0)" onclick="moveToEstimatePage({{ $paginate }})">{{ $paginate }}</a>
                @endif
            @endforeach
            @if (($request['pagination'])['next'] > 0)
            <button type="button" class="next" onclick="moveToEstimatePage({{ ($request['pagination'])['next'] }})">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12L10 7L5 2" stroke="#828282" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            @endif
        </div>
        @endif
    </div>
</div>

<!-- 견적 요청서 확인하기 -->
<div id="request_estimate-modal" class="modal">
    <div class="modal_bg" onclick="modalClose('#request_estimate-modal')"></div>
    <div class="modal_inner modal-xl">
        <button class="close_btn" onclick="modalClose('#request_estimate-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body agree_modal_body">
            <h3 class="text-xl font-bold">견적 요청서 확인하기</h3>
            <table class="table_layout mt-5">
                <colgroup>
                    <col width="120px">
                    <col width="330px">
                    <col width="120px">
                    <col width="330px">
                </colgroup>
                <thead>
                    <tr>
                        <th colspan="4">견적서를 요청한 자</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="4">아래와 같이 견적서를 보냅니다.</th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <th>요 청 일 자</th>
                        <td class="request_estimate_req_time"></td>
                        <th>요 청 번 호</th>
                        <td class="request_estimate_req_code"></td>
                    </tr>
                    <tr>
                        <th>업&nbsp;&nbsp;&nbsp;체&nbsp;&nbsp;&nbsp;명</th>
                        <td class="request_estimate_req_company_name"></td>
                        <th>사업자번호</th>
                        <td class="request_estimate_req_business_license_number"></td>
                    </tr>
                    <tr>
                        <th>전 화 번 호</th>
                        <td class="request_estimate_phone_number"></td>
                        <th>주요판매처</th>
                        <td>매장 판매</td>
                    </tr>
                    <tr>
                        <th>주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</th>
                        <td class="request_estimate_req_address1" colspan="3"></td>
                    </tr>
                    <tr>
                        <th>비&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;고</th>
                        <td class="request_estimate_req_memo" colspan="3"></td>
                    </tr>
                </tbody>
            </table>
            
            <div class="file-form full img_auto mt-10">
                <img src="" alt="" class="request_estimate_req_business_license_thumbnail" />
            </div>

            <ul class="order_prod_list mt-3">
                <li>
                    <div class="img_box">
                        <img src="/img/prod_thumb3.png" alt="" class="request_estimate_product_thumbnail" />
                    </div>
                    <div class="right_box">
                        <h6 class="request_estimate_product_name"></h6>
                        <table class="table_layout">
                            <colgroup>
                                <col width="160px">
                                <col width="*">
                            </colgroup>
                            <tr>
                                <th>상품번호</th>
                                <td class="txt-gray request_estimate_product_number"></td>
                            </tr>
                            <tr>
                                <th>상품수량</th>
                                <td><span class="request_estimate_product_count"></span>개</td>
                            </tr>
                            <tr>
                                <th>옵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;션</th>
                                <td class="request_estimate_product_option">없음</td>
                            </tr>
                            <tr>
                                <th>견적단가</th>
                                <td class="txt-gray"><span class="request_estimate_product_each_price"></span></td>
                            </tr>
                            <tr>
                                <th>배송지역</th>
                                <td class="request_estimate_product_address"></td>
                            </tr>
                        </table>
                    </div>
                </li>
            </ul>

            <div class="btn_box mt-10">
                <div class="flex gap-5">
                    <a href="javascript: ;" class="btn btn-primary flex-1" onclick="modalClose('#request_estimate-modal')">닫기</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 견적서 확인하기 (보류 / 주문서 작성) -->
<form method="PUT" name="isForm" id="isForm" action="/estimate/insertOrder">
    <div id="response_estimate-modal" class="modal">
        <div class="modal_bg" onclick="modalClose('#response_estimate-modal')"></div>
        <div class="modal_inner modal-xl">
            <button type="button" class="close_btn" onclick="modalClose('#response_estimate-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <h3 class="text-xl font-bold">견적서 확인하기</h3>
                <table class="table_layout mt-5">
                    <colgroup>
                        <col width="120px">
                        <col width="330px">
                        <col width="120px">
                        <col width="330px">
                    </colgroup>
                    <thead>
                        <tr>
                            <th colspan="4">견적서를 요청한 자</th>
                            <input type="hidden" name="response_estimate_req_user_idx" id="response_estimate_req_user_idx" value="" />
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>업&nbsp;&nbsp;&nbsp;체&nbsp;&nbsp;&nbsp;명</th>
                            <td><b class="response_estimate_req_company_name"></b></td>
                            <th>사업자번호</th>
                            <td class="response_estimate_req_business_license_number" colspan="3"></td>
                        </tr>
                        <tr>
                            <th>전 화 번 호</th>
                            <td class="response_estimate_req_phone_number"></td>
                        </tr>
                        <tr>
                            <th>주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</th>
                            <td class="response_estimate_req_address1" colspan="3"></td>
                        </tr>
                    </tbody>
                </table>

                <table class="table_layout mt-5">
                    <colgroup>
                        <col width="120px">
                        <col width="330px">
                        <col width="120px">
                        <col width="330px">
                    </colgroup>
                    <thead>
                        <tr>
                            <th colspan="4">견적서를 보내는 자</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="4">아래와 같이 견적서를 보냅니다.</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <th>견 적 일 자</th>
                            <td class="response_estimate_res_time"></td>
                            <th>견 적 번 호</th>
                            <td class="response_estimate_res_code"></td>
                        </tr>
                        <tr>
                            <th>업&nbsp;&nbsp;&nbsp;체&nbsp;&nbsp;&nbsp;명</th>
                            <td class="response_estimate_res_company_name"></td>
                            <th>사업자번호</th>
                            <td class="response_estimate_res_business_license_number"></td>
                        </tr>
                        <tr>
                            <th>전 화 번 호</th>
                            <td class="response_estimate_res_phone_number"></td>
                            <th>유 효 기 한</th>
                            <td>견적일로부터 15일</td>
                        </tr>
                        <tr>
                            <th>주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</th>
                            <td class="response_estimate_res_address1" colspan="3"></td>
                        </tr>
                        <tr>
                            <th>계 좌 번 호</th>
                            <td class="response_estimate_response_account" colspan="3"></td>
                        </tr>
                        <tr>
                            <th>비&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;고</th>
                            <td class="response_estimate_res_memo" colspan="3"></td>
                        </tr>
                    </tbody>
                </table>

                <ul class="order_prod_list mt-3 response_estimate_prod_list">
                    <!--
                    <li>
                        <div class="img_box">
                            <label for="prod_10"></label>
                            <img src="/img/prod_thumb3.png" alt="" class="mt-5 product_thumbnail" />
                        </div>
                        <div class="right_box">
                            <h6 class="product_name"></h6>
                            <table class="table_layout">
                                <colgroup>
                                    <col width="160px">
                                    <col width="*">
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <th>상품번호</th>
                                        <td class="txt-gray product_number"></td>
                                    </tr>
                                    <tr>
                                        <th>상품수량</th>
                                        <td class="txt-primary">
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
                                            <select name="" id="" class="input-form w-2/3">
                                                <option value="0">그레이</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>견적단가</th>
                                        <td class="product_each_price"></td>
                                        <input type="hidden" name="product_each_price" id="product_each_price" value="" />
                                    </tr>
                                    <tr>
                                        <th>견적금액</th>
                                        <td><b class="product_total_price"></b></td>
                                        <input type="hidden" name="product_total_price" id="product_total_price" value="" />
                                    </tr>
                                    <tr>
                                        <th>배송지역</th>
                                        <td class="product_address"></td>
                                    </tr>
                                    <tr>
                                        <th>배송방법</th>
                                        <td class="product_delivery_info"></td>
                                    </tr>
                                    <tr>
                                        <th>배송비</th>
                                        <td class="txt-primary product_delivery_price"></td>
                                        <input type="hidden" name="product_delivery_price" id="product_delivery_price" value="" />
                                    </tr>
                                    <tr>
                                        <th>비고</th>
                                        <td><input type="text" name="product_memo" id="product_memo" class="input-form w-full" value="" /></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </li>
                    -->
                </ul>

                <div class="order_price_total mt-10">
                    <h5>총 견적금액</h5>
                    <div class="price">
                        <p>
                            <span class="txt-gray fs14">
                                견적금액 (<span class="response_estimate_product_total_count"></span>)
                            </span>
                            <b class="response_estimate_product_total_price"></b>원
                            <input type="hidden" name="response_estimate_product_total_price" value="" />
                        </p>
                        <p>
                            <span class="txt-gray fs14">
                                옵션금액
                            </span>
                            <b class="response_estimate_product_option_price"></b>원
                            <input type="hidden" name="response_estimate_product_option_price" id="response_estimate_product_option_price" value="" />
                        </p>
                        <p>
                            <span class="txt-gray fs14">배송비</span>
                            <b class="response_estimate_product_delivery_price"></b>원
                        </p>
                    </div>
                    <div class="total">
                        <p>총 견적금액</p>
                        <b class="response_estimate_estimate_total_price"></b>원
                        <input type="hidden" name="response_estimate_estimate_total_price" value="" />
                    </div>
                </div>

                <div class="btn_box mt-10 state_R hidden">
                    <div class="flex gap-5">
                        <a id="holdEstimate" class="btn btn-line w-[330px]" style="cursor: pointer;">보류하기</a>
                        <a id="request_order_detail" class="btn btn-primary flex-1" style="cursor: pointer;">주문서 작성하기</a>
                    </div>
                </div>
                <div class="btn_box mt-10 state_H hidden">
                    <div class="flex gap-5">
                        <a href="javascript: ;" class="btn btn-primary flex-1" onclick="modalClose('#response_estimate-modal')">닫기</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 주문서 작성하기 -->
    <div id="request_order-modal" class="modal">
        <div class="modal_bg" onclick="modalClose('#request_order-modal')"></div>
        <div class="modal_inner modal-xl">
            <button type="button" class="close_btn" onclick="modalClose('#request_order-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <h3 class="text-xl font-bold">주문서 작성하기</h3>

                <table class="table_layout mt-5">
                    <colgroup>
                        <col width="120px">
                        <col width="330px">
                        <col width="120px">
                        <col width="330px">
                    </colgroup>
                    <thead>
                        <tr>
                            <th colspan="4">공급자</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>업&nbsp;&nbsp;&nbsp;체&nbsp;&nbsp;&nbsp;명</th>
                            <td class="response_estimate_res_company_name"></td>
                            <th>사업자번호</th>
                            <td class="response_estimate_res_business_license_number"></td>
                        </tr>
                        <tr>
                            <th>전 화 번 호</th>
                            <td class="response_estimate_res_phone_number" colspan="3"></td>
                        </tr>
                        <tr>
                            <th>주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</th>
                            <td class="response_estimate_res_address1" colspan="3"></td>
                        </tr>
                    </tbody>
                </table>

                <table class="table_layout mt-5">
                    <colgroup>
                        <col width="120px">
                        <col width="330px">
                        <col width="120px">
                        <col width="330px">
                    </colgroup>
                    <thead>
                        <tr>
                            <th colspan="4">주문자</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="4">아래와 같이 주문합니다.</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <th>주 문 일 자</th>
                            <td class="register_time"></td>
                            <input type="hidden" name="register_time" id="register_time" value="" />
                            <th>주 문 번 호</th>
                            <td class="order_code"></td>
                            <td class="order_group_code hidden"></td>
                        </tr>
                        <tr>
                            <th>업&nbsp;&nbsp;&nbsp;체&nbsp;&nbsp;&nbsp;명</th>
                            <td><b class="response_estimate_req_company_name"></b></td>
                            <th>사업자번호</th>
                            <td class="response_estimate_req_business_license_number"></td>
                        </tr>
                        <tr>
                            <th>업체연락처</th>
                            <td class="response_estimate_req_phone_number"></td>
                            <th>주문자성명</th>
                            <td><input type="text" name="name" id="name" class="input-form" value="" /></td>
                        </tr>
                        <tr>
                            <th>주문자연락처</th>
                            <td colspan="3"><input type="text" name="phone_number" id="phone_number" class="input-form" value="" /></td>
                        </tr>
                        <tr>
                            <th>주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</th>
                            <td colspan="3"><input type="text" name="address1" id="address1" class="input-form w-full" value="" /></td>
                        </tr>
                        <tr>
                            <th>비&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;고</th>
                            <td colspan="3"><input type="text" name="memo" id="memo" class="input-form w-full" value="" /></td>
                        </tr>
                    </tbody>
                </table>

                <ul class="order_prod_list mt-3 request_order_prod_list">
                    <li>
                        <div class="img_box">
                            <img src="/img/prod_thumb3.png" alt="" class="mt-5 product_thumbnail" />
                        </div>
                        <div class="right_box">
                            <h6 class="product_name"></h6>
                            <table class="table_layout">
                                <colgroup>
                                    <col width="160px">
                                    <col width="*">
                                </colgroup>
                                <tbody><tr>
                                    <th>상품번호</th>
                                    <td class="txt-gray product_number"></td>
                                </tr>
                                <tr>
                                    <th>상품수량</th>
                                    <td class="txt-primary product_count"></td>
                                </tr>
                                <tr>
                                    <th>옵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;션</th>
                                    <td class="product_option"></td>
                                </tr>
                                <tr>
                                    <th>견적단가</th>
                                    <td class="product_each_price"></td>
                                </tr>
                                <tr>
                                    <th>견적금액</th>
                                    <td><b class="product_total_price"></b></td>
                                </tr>
                                <tr>
                                    <th>배송지역</th>
                                    <td class="product_address"></td>
                                </tr>
                                <tr>
                                    <th>배송방법</th>
                                    <td class="product_delivery_info"></td>
                                </tr>
                                <tr>
                                    <th>배송비</th>
                                    <td class="txt-primary product_delivery_price"></td>
                                </tr>
                                <tr>
                                    <th>비고</th>
                                    <td class="product_memo"></td>
                                </tr>
                            </tbody></table>
                        </div>
                    </li>
                </ul>

                <div class="order_price_total mt-10">
                    <h5>총 견적금액</h5>
                    <div class="price">
                        <p>
                            <span class="txt-gray fs14">
                                견적금액 (<span class="request_order_product_total_count"></span>)
                            </span>
                            <b class="request_order_product_total_price"></b>원
                        </p>
                        <p>
                            <span class="txt-gray fs14">
                                옵션금액
                            </span>
                            <b class="request_order_product_option_price"></b>원
                            <input type="hidden" name="request_order_product_option_price" id="request_order_product_option_price" value="" />
                        </p>
                        <p>
                            <span class="txt-gray fs14">배송비</span>
                            <b class="request_order_product_delivery_price"></b>원
                        </p>
                    </div>
                    <div class="total">
                        <p>총 견적금액</p>
                        <b class="request_order_estimate_total_price"></b>원
                    </div>
                </div>

                <div class="btn_box mt-10">
                    <div class="flex gap-5">
                        <a id="insert_order" class="btn btn-primary flex-1 " style="cursor: pointer;">주문서 보내기</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- 주문 완료 -->
<div id="response_order-modal" class="modal">
    <div class="modal_bg" onclick="modalClose('#response_order-modal')"></div>
    <div class="modal_inner modal-md">
        <div class="p-10 com_setting">
            <div class="w-12 h-12 rounded-full flex items-center justify-center  mx-auto">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-basket text-white"><path d="m15 11-1 9"/><path d="m19 11-4-7"/><path d="M2 11h20"/><path d="m3.5 11 1.6 7.4a2 2 0 0 0 2 1.6h9.8a2 2 0 0 0 2-1.6l1.7-7.4"/><path d="M4.5 15.5h15"/><path d="m5 11 4-7"/><path d="m9 11 1 9"/></svg>
            </div>
            <h2 class="text-2xl font-medium text-center mt-2">주문이 완료되었습니다.</h2>
            <div class="mt-10">
                <h3 class="text-xl font-medium">주문 정보</h3>
            </div>
            <hr class="border border-1 border-gray-500 mt-4">
            <div class="flex flex-col justify-center gap-4 mt-4">
                <div class="flex">
                    <p class="text-stone-400 w-[160px]">수령인</p>
                    <p class="ml-4 name"></p>
                </div>
                <div class="flex">
                    <p class="text-stone-400 w-[160px]">연락처</p>
                    <p class="ml-4 phone_number"></p>
                </div>
                <div class="flex">
                    <p class="text-stone-400 w-[160px]">주 소</p>
                    <p class="ml-4 address1"></p>
                </div>
                <div class="flex">
                    <p class="text-stone-400 w-[160px]">총 주문금액</p>
                    <p class="ml-4 total_price"></p>
                </div>
                <div class="info">
                    <div class="flex items-center gap-1">
                        <img src="/img/member/info_icon.svg" alt="" class="w-4" />
                        <p>수령인의 연락처나 주소가 변경되었을 경우, 업체측에 직접 알려주세요.</p>
                    </div>
                </div>
            </div>

            <div class="mt-10">
                <h3 class="text-xl font-medium">주문 상품</h3>
                <hr class="border border-1 border-gray-500 mt-4">
            </div>
            <div class="border rounded-sm mt-4">
                <div class="p-4 flex justify-between items-center border-b bg-stone-100">
                    No.<span class="order_code"></span>
                    <a class="flex items-center gap-1 text-stone-400 response_order_detail">
                        <span>상세보기</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                    </a>
                </div>
                <div class="response_order_prod_list"></div>
            </div>
            <div class="flex items-center justify-center gap-3 mt-5">
                <a href="/" class="btn w-1/3 btn-primary-line">쇼핑 계속하기</a>
                <a href="/mypage/purchase" class="btn w-1/3 btn-primary">주문 현황 보러가기</a>
            </div>
        </div>
    </div>
</div>

<!-- 주문서 확인하기 -->
<div id="check_order-modal" class="modal">
    <div class="modal_bg" onclick="modalClose('#check_order-modal')"></div>
    <div class="modal_inner modal-xl">
        <button class="close_btn" onclick="modalClose('#check_order-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body agree_modal_body">
            <h3 class="text-xl font-bold">주문서 확인하기</h3>

            <table class="table_layout mt-5">
                <colgroup>
                    <col width="120px">
                    <col width="330px">
                    <col width="120px">
                    <col width="330px">
                </colgroup>
                <thead>
                    <tr>
                        <th colspan="4">공급자</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>업&nbsp;&nbsp;&nbsp;체&nbsp;&nbsp;&nbsp;명</th>
                        <td class="check_order_res_company_name"></td>
                        <th>사업자번호</th>
                        <td class="check_order_res_business_license_number"></td>
                    </tr>
                    <tr>
                        <th>전 화 번 호</th>
                        <td class="check_order_res_phone_number" colspan="3"></td>
                    </tr>
                    <tr>
                        <th>주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</th>
                        <td class="check_order_res_address1" colspan="3"></td>
                    </tr>
                </tbody>
            </table>

            <table class="table_layout mt-5">
                <colgroup>
                    <col width="120px">
                    <col width="330px">
                    <col width="120px">
                    <col width="330px">
                </colgroup>
                <thead>
                    <tr>
                        <th colspan="4">주문자</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="4">아래와 같이 주문합니다.</th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <th>주 문 일 자</th>
                        <td class="check_order_req_register_time"></td>
                        <th>주 문 번 호</th>
                        <td class="check_order_req_code"></td>
                    </tr>
                    <tr>
                        <th>업&nbsp;&nbsp;&nbsp;체&nbsp;&nbsp;&nbsp;명</th>
                        <td><b class="check_order_req_company_name"></b></td>
                        <th>사업자번호</th>
                        <td class="check_order_req_business_license_number"></td>
                    </tr>
                    <tr>
                        <th>업체연락처</th>
                        <td class="check_order_req_phone_number"></td>
                        <th>주문자성명</th>
                        <td class="name"></td>
                    </tr>
                    <tr>
                        <th>주문자연락처</th>
                        <td class="phone_number" colspan="3"></td>
                    </tr>
                    <tr>
                        <th>주문자주소</th>
                        <td class="address1" colspan="3"></td>
                    </tr>
                    <tr>
                        <th>비&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;고</th>
                        <td class="memo" colspan="3"></td>
                    </tr>
                </tbody>
            </table>

            <ul class="order_prod_list mt-3 check_order_prod_list">
                <li>
                    <div class="img_box">
                        <img src="/img/prod_thumb3.png" alt="" class="product_thumbnail" />
                    </div>
                    <div class="right_box">
                        <h6 class="product_name"></h6>
                        <table class="table_layout">
                            <colgroup>
                                <col width="160px">
                                <col width="*">
                            </colgroup>
                            <tbody><tr>
                                <th>상품번호</th>
                                <td class="txt-gray product_number"></td>
                            </tr>
                            <tr>
                                <th>상품수량</th>
                                <td class="txt-primary product_count"></td>
                            </tr>
                            <tr>
                                <th>옵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;션</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>견적단가</th>
                                <td class="product_each_price"></td>
                            </tr>
                            <tr>
                                <th>견적금액</th>
                                <td class="txt-primary"><b class="product_total_price"></b></td>
                            </tr>
                            <tr>
                                <th>배송지역</th>
                                <td class="response_address1"></td>
                            </tr>
                            <tr>
                                <th>배송방법</th>
                                <td>착불</td>
                            </tr>
                            <tr>
                                <th>배송비</th>
                                <td class="txt-primary product_delivery_price"></td>
                            </tr>
                            <tr>
                                <th>비고</th>
                                <td class="product_memo"></td>
                            </tr>
                        </tbody></table>
                    </div>
                </li>
            </ul>

            <div class="order_price_total mt-10">
                <h5>총 주문금액</h5>
                <div class="price">
                    <p>
                        <span class="txt-gray fs14">
                            견적금액 (<span class="check_order_product_total_count"></span>)
                        </span>
                        <b class="check_order_product_total_price"></b>원
                    </p>
                    <p>
                        <span class="txt-gray fs14">
                            옵션금액
                        </span>
                        <b class="check_order_product_option_price"></b>원
                    </p>
                    <p>
                        <span class="txt-gray fs14">배송비</span>
                        <b class="check_order_product_delivery_price"></b>원
                    </p>
                </div>
                <div class="total">
                    <p>총 주문금액</p>
                    <b class="check_order_estimate_total_price"></b>원
                </div>
            </div>

            <div class="btn_box mt-10">
                <div class="flex gap-5">
                    <a class="btn btn-primary flex-1" style="cursor: pointer;" onclick="modalClose('#check_order-modal')">닫기</a>
                </div>
            </div>
        </div>
    </div>
</div>





<script src="/js/jquery-1.12.4.js?{{ date('Ymdhis') }}"></script>
<script>
    var estimate_idx = 0;
    var estimate_code = "";
    var response_company_type = "";

    var product_option = {};
    var product_option_json = {};

    var product_count = 0;
    var response_estimate_product_total_count = 0;

    var response_estimate_product_total_price = 0;
    var response_estimate_product_option_price = 0;
    var response_estimate_product_delivery_price = 0;
    var response_estimate_estimate_total_price = 0;

    const selectedKeywordType = type => {
        document.getElementById('selectedKeywordType').dataset.keywordType = type;
    }

    const searchEstimate = params => {
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

        if (urlSearch.get('requestDate') && typeof bodies.requestDate === 'undefined') {
            bodies.requestDate = urlSearch.get('requestDate');
        } else if (bodies.requestDate === '') {
            delete bodies['requestDate'];
        }

        if (urlSearch.get('status') && typeof bodies.status === 'undefined') {
            bodies.status = urlSearch.get('status');
        } else if (bodies.status === '') {
            delete bodies['status'];
        }

        location.href = '/mypage/requestEstimate?' + new URLSearchParams(bodies);
    }

    const moveToEstimatePage = page => {
        const urlSearch = new URLSearchParams(location.search);
        let bodies = { offset: page };

        if (urlSearch.get('keywordType'))   bodies.keyword = urlSearch.get('keywordType');
        if (urlSearch.get('keyword'))       bodies.keyword = urlSearch.get('keyword');
        if (urlSearch.get('requestDate'))   bodies.requestDate = urlSearch.get('requestDate');
        if (urlSearch.get('status'))        bodies.status = urlSearch.get('status');

        location.replace('/mypage/requestEstimate?' + new URLSearchParams(bodies));
    }

    document.addEventListener('DOMContentLoaded', function(){
        var datepicker = flatpickr('#requestDate', {
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
        $('#requestDate').val('{{ request() -> get("requestDate") }}');

        // 아이콘 클릭 > 달력 열기
        window.openCalendar = function(){
            datepicker.open();
        };
    });

    document.getElementById('keyword').addEventListener('keyup', e => {
        const params = {
            keywordType     : (document.getElementById('selectedKeywordType').dataset.keywordType ?? ''),
            keyword         : e.currentTarget.value,
            requestDate     : document.getElementById('requestDate').value
        }
        
        if (e.key === 'Enter') {
            searchEstimate(params);
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

        // 견적 요청서 확인하기
        $('.request_estimate_detail').click(function(e){
            estimate_idx = $(this).data('idx');

            fetch('/mypage/requestEstimateDetail', {
                method  : 'POST',
                headers : {
                    'Content-Type'  : 'application/json',
                    'X-CSRF-TOKEN'  : '{{csrf_token()}}'
                },
                body    : JSON.stringify({
                    estimate_idx    : estimate_idx
                })
            }).then(response => {
                return response.json();
            }).then(json => {
                if (json.result === 'success') {
                    console.log(json.data[0]);

                    $('.request_estimate_req_time').text(json.data[0].request_time);
                    $('.request_estimate_req_code').text(json.data[0].estimate_code);
                    $('.request_estimate_req_company_name').text(json.data[0].request_company_name);
                    $('.request_estimate_req_business_license_number').text(json.data[0].request_business_license_number);
                    $('.request_estimate_phone_number').text(json.data[0].request_phone_number);

                    $('.request_estimate_req_address1').text(json.data[0].request_address1);
                    $('.request_estimate_req_memo').text(json.data[0].request_memo ? json.data[0].request_memo : '');

                    $('.request_estimate_req_business_license_thumbnail').attr('src', json.data[0].business_license);

                    $('.request_estimate_product_thumbnail').attr('src', json.data[0].product_thumbnail);
                    $('.request_estimate_product_name').text(json.data[0].product_name);
                    $('.request_estimate_product_number').text(json.data[0].product_number);
                    $('.request_estimate_product_count').text(json.data[0].product_count);
                    if(json.data[0].product_option_json) {
                        $('.request_estimate_product_option').html('');
                        $('.request_estimate_product_option').append(`<table class="my_table w-full text-left request_estimate_product_option_table">`);

                        product_option_json = JSON.parse(json.data[0].product_option_json);
                        for(var key in product_option_json) {
                            $('.request_estimate_product_option_table').append(
                            `<tr>
                                <th>` + product_option_json[key]['optionName'] + `</th>
                                <td>` + Object.keys(product_option_json[key]['optionValue'])[0] + `</td>
                            </tr>`);
                        }

                        $('.request_estimate_product_option').append(`</table>`);
                    }
                    $('.request_estimate_product_each_price').text((Number(json.data[0].product_each_price.replace(/[^0-9]/g, '')) > 0) ? json.data[0].product_each_price + '원' : json.data[0].product_each_price_text);
                    $('.request_estimate_product_address').text(json.data[0].product_address);

                    modalOpen('#request_estimate-modal');
                } else {
                    alert(json.message);
                }
            });
        });

        // 견적서 확인하기 (보류 / 주문서 작성)
        $('.response_estimate_detail').click(function(e){
            estimate_code = $(this).data('code');
            response_company_type = $(this).data('response_company_type');

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

                    if (json.data[0].estimate_state == 'R') {
                        $('.state_R').removeClass('hidden');
                        $('.state_H').addClass('hidden');
                    } else {
                        $('.state_R').addClass('hidden');
                        $('.state_H').removeClass('hidden');
                    }

                    $('.order_code').text(json.data[0].estimate_code);
                    $('.order_group_code').text(json.data[0].estimate_group_code);

                    $('#response_estimate_req_user_idx').val(json.user.idx);
                    $('.response_estimate_req_company_name').text(json.data[0].request_company_name);
                    $('.response_estimate_req_business_license_number').text(json.data[0].request_business_license_number);
                    $('.response_estimate_req_phone_number').text(json.data[0].request_phone_number);
                    $('.response_estimate_req_address1').text(json.data[0].request_address1);

                    $('.response_estimate_res_time').text(json.data[0].response_time);
                    $('.response_estimate_res_code').text(json.data[0].estimate_code);
                    $('.response_estimate_res_company_name').text(json.data[0].response_company_name);
                    $('.response_estimate_res_business_license_number').text(json.data[0].response_business_license_number);
                    $('.response_estimate_res_phone_number').text(json.data[0].response_phone_number);
                    $('.response_estimate_res_address1').text(json.data[0].response_address1);
                    $('.response_estimate_response_account').text(json.data[0].response_account);
                    $('.response_estimate_res_memo').text(json.data[0].response_memo ? json.data[0].response_memo : '');

                    response_estimate_product_total_count = 0;
                    response_estimate_product_total_price = 0;
                    response_estimate_product_option_price = 0;

                    $('.response_estimate_prod_list').html('');
                    for(var i = 0; i < json.data.length; i++) {
                        var product_option_html = '없음';
                        if(json.data[i].product_option_json) {
                            product_option_html = 
                                '<table class="my_table w-full text-left response_estimate_product_option_table">';

                                product_option = JSON.parse(json.data[i].product_option);
                                product_option_json = JSON.parse(json.data[i].product_option_json);
                                for(var key in product_option) {
                                    var optionValue = product_option[key].optionValue;

                                    product_option_html +=
                                        `<tr>
                                            <th>`
                                                + product_option[key].optionName +
                                                `<input type="hidden" name="product_option_key_` + json.data[i].product_idx + `[]" value="` + product_option[key].optionName + `" readOnly />
                                            </th>
                                            <td>
                                                <select name="product_option_value_` + json.data[i].product_idx + `[]" class="input-form w-2/3 option">`;
                                                    for(var key2 in optionValue) {
                                                        var selected = 
                                                            (optionValue[key2].propertyName === Object.keys(product_option_json[key]['optionValue'])[0]) ? 'selected' : '';

                                                        product_option_html +=
                                                            `<option value="` + optionValue[key2].propertyName + `,` + optionValue[key2].price + `" ` + selected + `>` + optionValue[key2].propertyName + `</option>`
                                                    };
                                    product_option_html +=
                                                `</select>
                                            </td>
                                        </tr>`;
                                }
                            product_option_html += 
                                '</table>';
                        }

                        let product_memo = json.data[0].product_memo ? json.data[0].product_memo : ''

                        $('.response_estimate_prod_list').append(
                            `<li>
                                <div class="img_box">
                                    <img src="` + json.data[i].product_thumbnail + `" alt="" class="product_thumbnail" />
                                    <input type="hidden" name="estimate_idx[]" value="` + json.data[i].estimate_idx + `" />
                                </div>
                                <div class="right_box">
                                    <h6 class="product_name">` + json.data[i].name + `</h6>
                                    <input type="hidden" name="product_idx[]" value="` + json.data[i].product_idx + `" />
                                    <table class="table_layout">
                                        <colgroup>
                                            <col width="160px">
                                            <col width="*">
                                        </colgroup>
                                        <tbody>
                                        <tr>
                                            <th>상품번호</th>
                                            <td class="txt-gray product_number">` + json.data[i].product_number + `</td>
                                        </tr>
                                        <tr>
                                            <th>상품수량</th>
                                            <td class="txt-primary">
                                                <div class="count_box">
                                                    <button type="button" class="minus"><svg><use xlink:href="/img/icon-defs.svg#minus"></use></svg></button>
                                                    <input type="text" name="product_count[]" value="` + json.data[i].product_count + `" readOnly />
                                                    <button type="button" class="plus"><svg><use xlink:href="/img/icon-defs.svg#plus"></use></svg></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>옵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;션</th>
                                            <td class="product_option_select">`
                                                + product_option_html +
                                            `</td>
                                        </tr>
                                        <tr>
                                            <th>견적단가</th>
                                            <td class="product_each_price">` 
                                                + json.data[i].product_each_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + `원
                                                <input type="hidden" name="product_each_price[]" value="` + json.data[i].product_each_price + `" readOnly />
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>견적금액</th>
                                            <td>
                                                <b class="product_total_price">` + json.data[i].product_total_price + `원</b>
                                                <input type="hidden" name="product_total_price[]" value="` + json.data[i].product_total_price.replace(/[^0-9]/g, '') + `" readOnly />
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>배송지역</th>
                                            <td class="product_address">` + json.data[i].product_address + `</td>
                                        </tr>
                                        <tr>
                                            <th>배송방법</th>
                                            <td class="product_delivery_info">` + json.data[i].product_delivery_info + `</td>
                                        </tr>
                                        <tr>
                                            <th>배송비</th>
                                            <td class="txt-primary product_delivery_price">` + json.data[i].product_delivery_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + `원</td>
                                        </tr>
                                        <tr>
                                            <th>비고</th>
                                            <td><input type="text" name="product_memo[]" value="` + product_memo + `"class="input-form w-full" value="" /></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </li>`
                        );
                        
                        response_estimate_product_total_count += json.data[i].product_count;
                        response_estimate_product_total_price += Number(json.data[i].product_total_price.replace(/,/g, ''));
                        response_estimate_product_option_price += json.data[i].product_option_price;
                    }
                    
                    $('.response_estimate_product_total_count').text(response_estimate_product_total_count + '개');
                    $('.response_estimate_product_total_price').text(response_estimate_product_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));

                    $('.response_estimate_product_option_price').text(response_estimate_product_option_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
                    $('#response_estimate_product_option_price').val(response_estimate_product_option_price);

                    response_estimate_product_delivery_price = json.data[0].product_delivery_price;
                    $('.response_estimate_product_delivery_price').text(response_estimate_product_delivery_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));

                    response_estimate_estimate_total_price = json.data[0].estimate_total_price;
                    $('.response_estimate_estimate_total_price').text(response_estimate_estimate_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
                    $('input[name="response_estimate_estimate_total_price"]').val(response_estimate_estimate_total_price);

                    $('#address1').val(json.data[0].request_address1);
                    $('#memo').val(json.data[0].request_memo);

                    modalOpen('#response_estimate-modal');
                } else {
                    alert(json.message);
                }
            });
        });

        $('#holdEstimate').on('click', function(){
            if(confirm('이 견적을 보류하시겠습니까?')) {
                fetch('/estimate/holdEstimate', {
                    method  : 'PUT',
                    headers : {
                        'Content-Type'  : 'application/json',
                        'X-CSRF-TOKEN'  : '{{csrf_token()}}'
                    },
                    body    : JSON.stringify({
                        estimate_code    : estimate_code
                    })
                }).then(response => {
                    return response.json();
                }).then(json => {
                    if (json.result === 'success') {
                        alert('보류되었습니다.')
                        location.reload();
                    } else {
                        alert(json.message);
                    }
                });
            }
        });

        // 주문서 작성하기
        $('#request_order_detail').on('click', function(){
            modalClose('#response_estimate-modal');

            fetch('/mypage/requestOrderDetail', {
                method  : 'POST',
                headers : {
                    'Content-Type'  : 'application/json',
                    'X-CSRF-TOKEN'  : '{{csrf_token()}}'
                }
            }).then(response => {
                return response.json();
            }).then(json => {
                if (json.result === 'success') {
                    console.log(json);

                    $('.register_time').text(json.data.now1);
                    $('#register_time').val(json.data.now2);

                    $('#name').val(json.data.user.name);
                    $('#phone_number').val(json.data.user.phone_number);

                    $('.request_order_prod_list').html('');
                    for(var i = 0; i < $('input[name="product_count[]"]').length; i++) {
                        var product_option_html = '없음';
                        if($('.product_option_select').eq(i).find('.response_estimate_product_option_table').length) {
                            product_option_html = $('.product_option_select').eq(i).html();
                        }
                        
                        let product_memo = $('input[name="product_memo[]"]').eq(i).val() ? $('input[name="product_memo[]"]').eq(i).val() : ''
                    
                        $('.request_order_prod_list').append(
                            `<li>
                                <div class="img_box">
                                    <img src="` + $('.product_thumbnail').eq(i).attr('src') + `" alt="" />
                                </div>
                                <div class="right_box">
                                    <h6>` + $('.product_name').eq(i).text() + `</h6>
                                    <table class="table_layout">
                                        <colgroup>
                                            <col width="160px">
                                            <col width="*">
                                        </colgroup>
                                        <tbody>
                                        <tr>
                                            <th>상품번호</th>
                                            <td class="txt-gray">` + $('.product_number').eq(i).text() + `</td>
                                        </tr>
                                        <tr>
                                            <th>상품수량</th>
                                            <td class="txt-primary">` + $('input[name="product_count[]"]').eq(i).val() + `개</td>
                                        </tr>
                                        <tr>
                                            <th>옵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;션</th>
                                            <td class="product_option_td">` + product_option_html + `</td>
                                        </tr>
                                        <tr>
                                            <th>견적단가</th>
                                            <td>` + $('.product_each_price').eq(i).text() + `</td>
                                        </tr>
                                        <tr>
                                            <th>견적금액</th>
                                            <td><b>` + $('.product_total_price').eq(i).text() + `</b></td>
                                        </tr>
                                        <tr>
                                            <th>배송지역</th>
                                            <td>` + $('.product_address').eq(i).text() + `</td>
                                        </tr>
                                        <tr>
                                            <th>배송방법</th>
                                            <td>` + $('.product_delivery_info').eq(i).text() + `</td>
                                        </tr>
                                        <tr>
                                            <th>배송비</th>
                                            <td class="txt-primary">` + $('.product_delivery_price').eq(i).text() + `</td>
                                        </tr>
                                        <tr>
                                            <th>비고</th>
                                            <td>` + product_memo + `</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </li>`
                        );
                    }
                    $('.product_option_td').find('select').attr('name', '');
                    $('.product_option_td').find('select').attr('disabled', true);
                    
                    $('.request_order_product_total_count').text(response_estimate_product_total_count + '개');
                    $('.request_order_product_total_price').text(response_estimate_product_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
                    $('.request_order_product_option_price').text(response_estimate_product_option_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
                    $('#request_order_product_option_price').val(response_estimate_product_option_price);
                    $('.request_order_product_delivery_price').text(response_estimate_product_delivery_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
                    $('.request_order_estimate_total_price').text(response_estimate_estimate_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
                    $('input[name="response_estimate_estimate_total_price"]').val(response_estimate_estimate_total_price);

                    modalOpen('#request_order-modal');
                } else {
                    alert(json.message);
                }
            });
        });

        $('#insert_order').on('click', function(){
            if(confirm('이대로 주문하시겠습니까?')) {
                const formData = new FormData(document.getElementById('isForm'));
                /*
                for (const [key, value] of formData.entries()) {
                    console.log(key, value);
                }
                return false;
                */

                fetch('/estimate/insertOrder', {
                    method  : 'POST',
                    headers : {
                        'X-CSRF-TOKEN'  : '{{csrf_token()}}'
                    },
                    body    : formData
                }).then(response => {
                    return response.json();
                }).then(json => {
                    if (json.success) {
                        modalClose('#request_order-modal');

                        $('.name').text($('#name').val());
                        $('.phone_number').text($('#phone_number').val());
                        $('.address1').text($('#address1').val());
                        $('.total_price').text(response_estimate_estimate_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');

                        $('.response_order_detail:not(button)').attr('href', '/mypage/order/detail?orderGroupCode=' + $('.order_group_code').first().text() + '&type=P');

                        $('.response_order_prod_list').html('');
                        for(var i = 0; i < $('input[name="product_count[]"]').length; i++) {
                            $('.response_order_prod_list').append(
                                `<div class="p-4 flex items-center">
                                    <img src="` + $('.product_thumbnail').eq(i).attr('src') + `" alt="" class="object-cover w-20 h-20 rounded-md" />
                                    <div class="ml-3">
                                        <p class="font-medium">` + $('.response_estimate_res_company_name').eq(0).text() + `</p>
                                        <p class="text-stone-400">` + $('.product_name').eq(i).text() + `</p>
                                    </div>
                                </div>`
                            );
                        }

                        modalOpen('#response_order-modal');
                    } else {
                        alert('일시적인 오류로 처리되지 않았습니다.');
                        return false;
                    }
                });
            }
        });

        $('.check_order_detail:button').click(function(){
            fetch('/mypage/responseOrderDetail', {
                method  : 'POST',
                headers : {
                    'Content-Type'  : 'application/json',
                    'X-CSRF-TOKEN'  : '{{csrf_token()}}'
                },
                body    : JSON.stringify({
                    order_code      : $(this).data('code')
                })
            }).then(response => {
                return response.json();
            }).then(json => {
                if (json.result === 'success') {
                    console.log(json.data);

                    $('.check_order_res_company_name').text(json.data[0].response_company_name);
                    $('.check_order_res_business_license_number').text(json.data[0].response_business_license_number);
                    $('.check_order_res_phone_number').text(json.data[0].response_phone_number);
                    $('.check_order_res_address1').text(json.data[0].response_address1);

                    $('.check_order_req_register_time').text(json.data[0].register_time);
                    $('.check_order_req_code').text(json.data[0].order_code);
                    $('.check_order_req_company_name').text(json.data[0].request_company_name);
                    $('.check_order_req_business_license_number').text(json.data[0].request_business_license_number);
                    $('.check_order_req_phone_number').text(json.data[0].request_phone_number);
                    $('.name').text(json.data[0].name);
                    $('.phone_number').text(json.data[0].phone_number);
                    $('.address1').text(json.data[0].address1);
                    $('.memo').text(json.data[0].memo ? json.data[0].memo : '');

                    response_estimate_product_total_price = 0;
                    response_estimate_product_option_price = 0;

                    $('.check_order_prod_list').html('');
                    for(var i = 0; i < json.data.length; i++) {
                        var product_option_html = '없음';
                        if(json.data[i].product_option_json) {
                            product_option_html = 
                                '<table class="my_table w-full text-left response_estimate_product_option_table">';

                                product_option_json = JSON.parse(json.data[i].product_option_json);
                                for(var key in product_option_json) {
                                    product_option_html +=
                                    `<tr>
                                        <th>` + product_option_json[key]['optionName'] + `</th>
                                        <td>` + Object.keys(product_option_json[key]['optionValue'])[0] + `</td>
                                    </tr>`;
                                }

                            product_option_html += 
                                `</table>`;
                        }

                        let product_memo = json.data[i].product_memo ? json.data[i].product_memo : ''

                        $('.check_order_prod_list').append(
                            `<li>
                                <div class="img_box">
                                    <img src="` + json.data[i].product_thumbnail + `" alt="" />
                                </div>
                                <div class="right_box">
                                    <h6>` + json.data[i].product_name + `</h6>
                                    <table class="table_layout">
                                        <colgroup>
                                            <col width="160px">
                                            <col width="*">
                                        </colgroup>
                                        <tbody>
                                        <tr>
                                            <th>상품번호</th>
                                            <td class="txt-gray">` + json.data[i].product_number + `</td>
                                        </tr>
                                        <tr>
                                            <th>상품수량</th>
                                            <td class="txt-primary">` + json.data[i].product_count + `개</td>
                                        </tr>
                                        <tr>
                                            <th>옵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;션</th>
                                            <td>` + product_option_html + `</td>
                                        </tr>
                                        <tr>
                                            <th>견적단가</th>
                                            <td>` + json.data[i].product_each_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + `원</td>
                                        </tr>
                                        <tr>
                                            <th>견적금액</th>
                                            <td><b>` + json.data[i].product_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + `원</b></td>
                                        </tr>
                                        <tr>
                                            <th>배송지역</th>
                                            <td>` + json.data[i].address1 + `</td>
                                        </tr>
                                        <tr>
                                            <th>배송방법</th>
                                            <td>` + json.data[i].product_delivery_info + `</td>
                                        </tr>
                                        <tr>
                                            <th>배송비</th>
                                            <td class="txt-primary">` + json.data[i].product_delivery_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + `원</td>
                                        </tr>
                                        <tr>
                                            <th>비고</th>
                                            <td>` + product_memo + `</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </li>`
                        );

                        response_estimate_product_total_price += Number(json.data[i].product_total_price);
                        response_estimate_product_option_price += Number(json.data[i].product_option_price);
                    }

                    $('.check_order_product_total_count').text(json.data[0].count + '개');
                    $('.check_order_product_total_price').text(response_estimate_product_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
                    $('.check_order_product_option_price').text(response_estimate_product_option_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
                    $('.check_order_product_delivery_price').text(json.data[0].product_delivery_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
                    $('.check_order_estimate_total_price').text(json.data[0].total_price);

                    modalOpen('#check_order-modal');
                } else {
                    alert(json.message);
                }
            });
        });

        $(document).on('change', '.option', function(){
            response_estimate_product_option_price = 0;
            $('.option').each(function(){
                console.log($(this).closest('li').find('input[name="product_count[]"]').val());
                response_estimate_product_option_price += Number($(this).val().split(',')[1]) * Number($(this).closest('li').find('input[name="product_count[]"]').val());
            });

            $('.response_estimate_product_option_price').text(response_estimate_product_option_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
            $('input[name="response_estimate_product_option_price"]').val(response_estimate_product_option_price);

            response_estimate_estimate_total_price = Number(response_estimate_product_total_price) + Number(response_estimate_product_option_price) + Number(response_estimate_product_delivery_price);
            $('.response_estimate_estimate_total_price').text(response_estimate_estimate_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
            $('input[name="response_estimate_estimate_total_price"]').val(response_estimate_estimate_total_price);
        });

        $(document).on('click', '.minus', function(index){
            let num = Number($(this).siblings('input').val());
            if (num > 1) {
                product_count = num - 1;
                $(this).siblings('input').val(product_count);

                var i = $('.minus').index(this);

                let product_each_price = $('input[name="product_each_price[]"]').eq(i).val();
                let product_total_price = product_each_price * product_count;

                $('.product_total_price').eq(i).text(product_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');
                $('input[name="product_total_price[]"]').eq(i).val(product_total_price);

                response_estimate_product_total_count = 0;
                $('input[name="product_count[]"]').each(function(){
                    response_estimate_product_total_count += Number($(this).val());
                });
                $('.response_estimate_product_total_count').text(response_estimate_product_total_count + '개');

                response_estimate_product_total_price = 0;
                $('input[name="product_total_price[]"]').each(function(){
                    response_estimate_product_total_price += Number($(this).val());
                });
                $('.response_estimate_product_total_price').text(response_estimate_product_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
                $('input[name="response_estimate_product_total_price"]').val(response_estimate_product_total_price);

                response_estimate_product_option_price = 0;
                $('.option').each(function(){
                    console.log($(this).closest('li').find('input[name="product_count[]"]').val());
                    response_estimate_product_option_price += Number($(this).val().split(',')[1]) * Number($(this).closest('li').find('input[name="product_count[]"]').val());
                });
                $('.response_estimate_product_option_price').text(response_estimate_product_option_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
                $('input[name="response_estimate_product_option_price"]').val(response_estimate_product_option_price);

                response_estimate_estimate_total_price = Number(response_estimate_product_total_price) + Number(response_estimate_product_option_price) + Number(response_estimate_product_delivery_price);
                $('.response_estimate_estimate_total_price').text(response_estimate_estimate_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
                $('input[name="response_estimate_estimate_total_price"]').val(response_estimate_estimate_total_price);
            }
        });

        $(document).on('click', '.plus', function(){
            let num = Number($(this).siblings('input').val());
            product_count = num + 1;

            $(this).siblings('input').val(product_count);

            var i = $('.plus').index(this);

            let product_each_price = $('input[name="product_each_price[]"]').eq(i).val();
            let product_total_price = product_each_price * product_count;

            $('.product_total_price').eq(i).text(product_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');
            $('input[name="product_total_price[]"]').eq(i).val(product_total_price);

            response_estimate_product_total_count = 0;
            $('input[name="product_count[]"]').each(function(){
                response_estimate_product_total_count += Number($(this).val());
            });
            $('.response_estimate_product_total_count').text(response_estimate_product_total_count + '개');

            response_estimate_product_total_price = 0;
            $('input[name="product_total_price[]"]').each(function(){
                response_estimate_product_total_price += Number($(this).val());
            });
            $('.response_estimate_product_total_price').text(response_estimate_product_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
            $('input[name="response_estimate_product_total_price"]').val(response_estimate_product_total_price);

            response_estimate_product_option_price = 0;
            $('.option').each(function(){
                console.log($(this).closest('li').find('input[name="product_count[]"]').val());
                response_estimate_product_option_price += Number($(this).val().split(',')[1]) * Number($(this).closest('li').find('input[name="product_count[]"]').val());
            });
            $('.response_estimate_product_option_price').text(response_estimate_product_option_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
            $('input[name="response_estimate_product_option_price"]').val(response_estimate_product_option_price);

            response_estimate_estimate_total_price = Number(response_estimate_product_total_price) + Number(response_estimate_product_option_price) + Number(response_estimate_product_delivery_price);
            $('.response_estimate_estimate_total_price').text(response_estimate_estimate_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
            $('input[name="response_estimate_estimate_total_price"]').val(response_estimate_estimate_total_price);
        });
    });
</script>