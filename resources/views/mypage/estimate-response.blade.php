<div class="w-full">
    <div class="flex">
        <a href="/mypage/estimateInfo" class="text-xl text-primary font-bold grow border-b-2 border-primary pb-5 text-center">견적서 관리</a>
        <a href="/mypage/responseEstimateMulti" class="text-stone-400 text-xl font-bold grow text-center">견적서 보내기</a>
    </div>           
    <hr>
    <a href="/mypage/responseEstimate" class="flex items-center gpa-3 mt-8">
        <p class="font-bold">요청받은 견적서 현황</p>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
    </a>
    <div class="st_box w-full flex items-center gap-2.5 px-5 mt-3">
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
                        <a href="javascript: void(0);" class="flex items-center" data-type="estimateCode">견적번호</a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="flex items-center" data-type="productName">상품명</a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="flex items-center" data-type="companyName">구매 업체</a> 
                    </li>
                </ul>
            </div>
        </div>
        <div class="filter_border flex items-center w-full">
            <svg class="w-6 h-6" class="filter_arrow"><use xlink:href="/img/icon-defs.svg#Search"></use></svg>
            <input type="search" name="keyword" id="keyword" class="ml-3 w-full" value="{{ request() -> get('keyword') }}" placeholder="검색어를 입력해주세요." />
        </div>
        <div class="flex filter_calendar filter_border w-[270px] h-full items-center justify-between shrink-0">
            <input type="text" name="responseDate" id="responseDate" class="cursor_default w-full h-full" value="{{ request() -> get('responseDate') }}" placeholder="전체 기간" readOnly />
            <svg class="w-5 h-5 cursor-pointer" onClick="openCalendar();"><use xlink:href="/img/icon-defs.svg#Calendar"></use></svg>
        </div>
    </div>

    @if ($response['count'] >= 1)
    <div>
        전체 <span>{{ $response['count'] }}개</span>
    </div>
    @endif

    <div class="mt-4">
        @if ($response['count'] < 1)
        <ul>
            <li class="no_prod txt-gray">
                데이터가 존재하지 않습니다. 다시 조회해주세요.
            </li>
        </ul>
        @else
        <table class="my_table table-auto w-full">
            <thead>
                <th>No</th>
                <th>견적번호</th>
                <th>견적일자<br />(요청일자)</th>
                <th>견적 상태</th>
                <th>견적 상품</th>
                <th>구매 업체</th>
                <th>관리</th>
            </thead>
            <tbody class="text-center">
                @foreach($response['list'] as $list)
                <tr>
                    <td>{{ $response['count'] - $loop -> index - (($offset - 1) * $limit) }}</td>
                    <td>{{ $list -> estimate_code }}</td>
                    <td>{{ $list -> response_time ? $list -> response_time : '('.$list -> request_time.')' }}</td>
                    <td>{{ config('constants.ESTIMATE.STATUS.RES')[$list -> estimate_state] }}</td>
                    <td><a href="/product/detail/{{ $list -> product_idx }}" class="text-sky-500 underline" onclick="">{{ $list -> name }}</a>{{ $list -> cnt > 1 ? '외 '.$list -> cnt.'개' : ''}}</td>
                    <td>{{ $list -> request_company_name }}</td>
                    <td>
                        @if ($list -> estimate_state == 'N')
                        <button class="btn outline_primary btn-h-auto request_estimate_detail" data-idx="{{ $list -> estimate_idx }}" data-code="{{ $list -> estimate_code }}" data-response_company_type="{{ $response['response_company_type'] }}">견적 요청서 확인</button>
                        @elseif ($list -> estimate_state == 'R' || $list -> estimate_state == 'H')
                        <button class="btn outline_primary btn-h-auto check_estimate_detail" data-code="{{ $list -> estimate_code }}" data-response_company_type="{{ $response['response_company_type'] }}">견적서 확인</button>
                        @elseif ($list -> estimate_state == 'O' || $list -> estimate_state == 'F')
                        <button class="btn outline_primary btn-h-auto check_order_detail" data-code="{{ $list -> estimate_code }}" data-state="{{ $list -> estimate_state }}">주문서 확인</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagenation flex items-center justify-center py-12">
            @if (($response['pagination'])['prev'] > 0)
            <button type="button" class="prev" onclick="moveToEstimatePage({{ ($response['pagination'])['prev'] }})">
                <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 1L1 6L6 11" stroke="#DBDBDB" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            @endif
            @foreach (($response['pagination'])['pages'] as $paginate)
                @if ($paginate == $response['offset'])
                <a href="javascript: void(0)" class="active" onclick="moveToEstimatePage({{ $paginate }})">{{ $paginate }}</a>
                @else
                <a href="javascript: void(0)" onclick="moveToEstimatePage({{ $paginate }})">{{ $paginate }}</a>
                @endif
            @endforeach
            @if (($response['pagination'])['next'] > 0)
            <button type="button" class="next" onclick="moveToEstimatePage({{ ($response['pagination'])['next'] }})">
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
                        <th colspan="4">아래 상품의 견적을 요청합니다.</th>
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
                        <td class="request_estimate_req_phone_number"></td>
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
                    <a href="javascript: ;" class="btn btn-primary flex-1 response_estimate_detail">견적서 작성하기</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 견적서 작성하기 -->
<!-- new 견적서 -->
<div class="modal" id="response_estimate-modal">
    <div class="modal_bg" onclick="modalClose('#response_estimate-modal')"></div>
    <div class="modal_inner modal-xl">
        <button class="close_btn" onclick="modalClose('#response_estimate-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body new_estimate_body">
            <h3 class="py-5 text-xl font-semibold text-black text-center">견적 요청서</h3>
            <h4 class="py-3 text-xl font-semibold text-white text-center">견 적 서</h4>
            <div class="py-5 px-3">
                <div class="img_box">
                    <img class="mx-auto" src="/img/prod_thumb3.png" alt="">
                </div>

                <div class="py-3">
                    <p class="text-base font-semibold text-center">이태리매트리스_엔트리플러스 (SS) /이태리  최고급 침대 및 이태리 장인이 직접 수제공한 작품</p>
                    <table class="mt-5 table_layout">
                        <colgroup>
                            <col width="160px">
                            <col width="*">
                        </colgroup>
                        <tbody>
                            <tr>
                                <th>상품수량</th>
                                <td>
                                    <div class="count_box">
                                        <button class="minus"><svg><use xlink:href="./img/icon-defs.svg#minus"></use></svg></button>
                                        <input type="text" value="1개">
                                        <button class="plus"><svg><use xlink:href="./img/icon-defs.svg#plus"></use></svg></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>옵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;션</th>
                                <td>없음</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 px-10">
                    <div class="custom_input2 text-right">
                        <input type="checkbox" id="new_esti_1" />
                        <label for="new_esti_1"> 전체상품 견적받기</label>
                    </div>
                    <div class="pt-5">
                        <ul class="all_prod prod_list grid2 mb-5">
                            <!-- ajax -->
                            <li class="prod_item">
                                <div class="img_box custom_input2">
                                    <input type="checkbox" id="new_esti_2" />
                                    <label for="new_esti_2">
                                        <img src="/img/prod_thumb.png" alt="">
                                    </label>
                                </div>
                                <div class="txt_box">
                                    <a href="/prod_detail.php">
                                        <span>올펀가구</span>
                                        <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                        <b>수량마다 상이</b>
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <a href="javascript:;" class="btn btn-gray flex-1" onclick="moreProd(this)">더 보기</a>
                    </div>
                </div>

                <div class="mt-10 px-10 add_inquiry">
                    <h3>추가 문의 사항</h3>
                    <textarea name="" id="" class="" placeholder="견적 요청드립니다. (200자)"></textarea>
                </div>

                <div class="btn_box mt-10 px-10">
                    <div class="flex gap-5">
                        <a href="javascript:;" class="btn btn-primary flex-1" onclick="modalClose('#response_estimate-modal'); modalOpen('#new_estimate2-modal');">다음 (1/2)</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- new 견적서 - 2 -->
<div class="modal" id="new_estimate2-modal">
    <div class="modal_bg" onclick="modalClose('#new_estimate2-modal')"></div>
    <div class="modal_inner modal-xl">
        <button class="close_btn" onclick="modalClose('#new_estimate2-modal')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body new_estimate_body">
            <h3 class="py-5 text-xl font-semibold text-black text-center">견적 요청서</h3>
            <h4 class="py-3 text-xl font-semibold text-white text-center">견 적 서</h4>

            <div class="company_info">
                <h5>업체 정보 확인 <svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#drop_b_arrow"></use></svg></h5>
                <div class="company_cont p-3">
                    <table class="table_layout mt-5">
                        <colgroup>
                            <col width="160px">
                            <col width="*">
                        </colgroup>
                        <thead>
                            <tr>
                                <th colspan="2">수신자</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>수 신 업 체</th>
                                <td><b class="request_estimate_req_company_name">(주)미네르바 가구</b></td>
                            </tr>
                            <tr>
                                <th>전 화 번 호</th>
                                <td class="request_estimate_req_phone_number">010-1234-5678</td>
                            </tr>
                            <tr>
                                <th>사업자번호</th>
                                <td class="request_estimate_req_business_license_number">123-81-12354</td>
                            </tr>
                            <tr>
                                <th>주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</th>
                                <td class="request_estimate_req_address1">경기도 고양시 일산동구 산두로 213번길 18(정발산동) 1층</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table_layout mt-5">
                        <colgroup>
                            <col width="160px">
                            <col width="*">
                        </colgroup>
                        <thead>
                            <tr>
                                <th colspan="2">공급자</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>견 적 날 짜</th>
                                <td class="response_estimate_res_time">
                                </td>
                                <input type="hidden" name="response_estimate_res_time" value="" />
                            </tr>
                            <tr>
                                <th>견 적 번 호</th>
                                <td class="response_estimate_res_code"></td>
                            </tr>
                            <tr>
                                <th>업&nbsp;&nbsp;&nbsp;체&nbsp;&nbsp;&nbsp;명</th>
                                <td class="response_estimate_res_company_name"></td>
                            </tr>
                            <tr>
                                <th>사업자번호</th>
                                <td><input type="text" name="response_estimate_res_business_license_number" id="response_res_business_license_number" value=""></td>
                            </tr>
                            <tr>
                                <th>전 화 번 호</th>
                                <td><input type="text" name="response_estimate_res_phone_number" id="response_estimate_res_phone_number" class="input-form" value="" /></td>
                            </tr>
                            <tr>
                                <th>유 효 기 한</th>
                                <td>
                                    견적일로 부터
                                    <select name="expiration_date" id="expiration_date" class="input-form ml-3">
                                        @for ($i = 15; $i >= 1; $i--)
                                            <option value="{{ $i }}">{{ $i }}일</option>
                                        @endfor
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>배 송 방 법</th>
                                <td>
                                    <select name="response_estimate_product_delivery_info" id="response_estimate_product_delivery_info" class="input-form w-2/3">
                                        <option value="업체 협의 (착불)">착불</option>
                                        <option value="매장 배송 (무료)">무료</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>배 송 비 용</th>
                                <td>
                                    <b class="txt-primary">
                                        <input type="text" name="response_estimate_product_delivery_price" id="response_estimate_product_delivery_price" class="input-form txt-primary w-2/3" value="" />
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <th>주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</th>
                                <td class="add_inquiry">
                                    <textarea name="response_estimate_res_address1" id="response_estimate_res_address1"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>계 좌 번 호</th>
                                <td>
                                    <span class="response_account hidden"></span>
                                    <select name="response_estimate_account1" id="response_estimate_response_account1" class="input-form">
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
                                    <input type="text" name="response_estimate_response_account2" id="response_estimate_response_account2" class="input-form" value="" />
                                </td>
                            </tr>
                            <tr>
                                <th>비&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;고</th>
                                <td class="add_inquiry">
                                    <textarea name="response_estimate_res_memo" id="response_estimate_res_memo"></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="py-10 text-center">
                <p>아래와 같이 견적합니다.</p>
            </div>

            <div class="py-5 px-3">

                <div class="info_box p-4">
                    <div class="img_box">
                        <img class="mx-auto" src="/img/prod_thumb3.png" alt="">
                    </div>

                    <div class="py-3">
                        <p class="text-base font-semibold text-center">이태리매트리스_엔트리플러스 (SS) /이태리  최고급 침대 및 이태리 장인이 직접 수제공한 작품</p>
                        <table class="mt-5 table_layout">
                            <colgroup>
                                <col width="160px">
                                <col width="*">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th>상품번호</th>
                                    <td class="txt-gray response_estimate_product_number">A23A24224VEOPMR</td>
                                </tr>
                                <tr>
                                    <th>상품수량</th>
                                    <td class="txt-danger response_estimate_product_count">5개</td>
                                </tr>
                                <tr>
                                    <th>옵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;션</th>
                                    <td class="response_estimate_product_option">그레이</td>
                                </tr>
                                <tr>
                                    <th>견적단가</th>
                                    <td><input type="text" class="txt-danger" name="response_estimate_product_each_price" id="response_estimate_product_each_price"> 원</td>
                                </tr>
                                <tr>
                                    <th>견적금액</th>
                                    <td>
                                        <span class="response_estimate_product_total_price"></span>원
                                        <input type="hidden" name="response_estimate_product_total_price" id="response_estimate_product_total_price" value="" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>배송지역</th>
                                    <td class="response_estimate_product_address">경기도 일산</td>
                                </tr>
                                <tr>
                                    <th>배송방법</th>
                                    <td>
                                        <select name="response_estimate_product_delivery_info" id="response_estimate_product_delivery_info" class="input-form w-2/3">
                                            <option value="업체 협의 (착불)">착불</option>
                                            <option value="매장 배송 (무료)">무료</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>배송비용</th>
                                    <td>
                                        <input type="text" class="txt-danger" name="response_estimate_product_delivery_price" id="response_estimate_product_delivery_price">
                                    </td>
                                </tr>
                                <tr>
                                    <th>비고</th>
                                    <td class="add_inquiry"><textarea name="response_estimate_product_memo" id="response_estimate_product_memo"></textarea></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="order_price_total mt-10">
                            <h5>총 견적 금액</h5>
                            <div class="price">
                                <p class="!w-full">
                                    <span class="fs14 response_estimate_product_count">이태리매트리스 1개</span>
                                    <b><span class="response_estimate_product_total_price"></span>원</b>
                                    <input type="hidden" name="response_estimate_product_option_price" id="response_estimate_product_option_price" value="" />
                                </p>
                                <p class="!w-full">
                                    <span class="fs14">배송비</span>
                                    <b><span class="response_estimate_product_delivery_price"></span>원</b>
                                </p>
                            </div>
                            <div class="total">
                                <p>총 견적 금액</p>
                                <b><span class="response_estimate_estimate_total_price"></span>원</b>
                                <input type="hidden" name="response_estimate_estimate_total_price" id="response_estimate_estimate_total_price" value="" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="btn_box mt-10 px-10">
                    <div class="flex gap-5">
                        <a class="btn btn-primary flex-1" style="cursor: pointer;" onclick="updateResponse()">견적서 보내기</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 견적서 확인하기 -->
<div id="check_estimate-modal" class="modal">
    <div class="modal_bg" onclick="modalClose('#check_estimate-modal')"></div>
    <div class="modal_inner modal-xl">
        <button class="close_btn" onclick="modalClose('#check_estimate-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
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
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>업 체 명</th>
                        <td><b class="check_estimate_req_company_name"></b></td>
                        <th>사업자번호</th>
                        <td class="check_estimate_req_business_license_number"></td>
                    </tr>
                    <tr>
                        <th>전 화 번 호</th>
                        <td class="check_estimate_req_phone_number" colspan="3"></td>
                    </tr>
                    <tr>
                        <th>주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</th>
                        <td class="check_estimate_req_address1" colspan="3"></td>
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
                        <td class="check_estimate_res_time"></td>
                        <th>견 적 번 호</th>
                        <td class="check_estimate_res_code"></td>
                    </tr>
                    <tr>
                        <th>업&nbsp;&nbsp;&nbsp;체&nbsp;&nbsp;&nbsp;명</th>
                        <td class="check_estimate_res_company_name"></td>
                        <th>사업자번호</th>
                        <td class="check_estimate_res_business_license_number"></td>
                    </tr>
                    <tr>
                        <th>전 화 번 호</th>
                        <td class="check_estimate_res_phone_number"></td>
                        <th>유 효 기 한</th>
                        <td>견적일로부터 15일</td>
                    </tr>
                    <tr>
                        <th>주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</th>
                        <td class="check_estimate_res_address1" colspan="3"></td>
                    </tr>
                    <tr>
                        <th>계 좌 번 호</th>
                        <td class="check_estimate_res_account" colspan="3"></td>
                    </tr>
                    <tr>
                        <th>비&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;고</th>
                        <td class="check_estimate_res_memo" colspan="3"></td>
                    </tr>
                </tbody>
            </table>

            <ul class="order_prod_list mt-3 check_estimate_prod_list">
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
                                <td class="txt-primary"><b class="product_count"></b>개</td>
                            </tr>
                            <tr>
                                <th>옵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;션</th>
                                <td>없음</td>
                            </tr>
                            <tr>
                                <th>견적단가</th>
                                <td><input type="text" name="product_each_price" id="product_each_price" class="input-form w-2/3 txt-primary" value="" /></td>
                            </tr>
                            <tr>
                                <th>견적금액</th>
                                <td>
                                    <b class="product_total_price"></b>원
                                    <input type="hidden" name="product_total_price" id="product_total_price" value="" />
                                </td>
                            </tr>
                            <tr>
                                <th>배송지역</th>
                                <td class="product_address"></td>
                            </tr>
                            <tr>
                                <th>배송방법</th>
                                <td>
                                    <select name="product_delivery_info" id="product_delivery_info" class="input-form w-2/3">
                                        <option value="업체 협의 (착불)">착불</option>
                                        <option value="매장 배송 (무료)">무료</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>배송비</th>
                                <td><input type="text" name="product_delivery_price" id="product_delivery_price" class="input-form txt-primary w-2/3" value="" /></td>
                            </tr>
                            <tr>
                                <th>비고</th>
                                <td><input type="text" name="product_memo" id="product_memo" class="input-form w-full" value="" /></td>
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
                            견적금액 (<span class="check_estimate_product_count"></span>)
                        </span>
                        <b class="check_estimate_product_total_price"></b>원
                    </p>
                    <p>
                        <span class="txt-gray fs14">
                            옵션금액
                        </span>
                        <b class="check_estimate_product_option_price"></b>원
                    </p>
                    <p>
                        <span class="txt-gray fs14">배송비</span>
                        <b class="check_estimate_product_delivery_price"></b>원
                    </p>
                </div>
                <div class="total">
                    <p>총 견적금액</p>
                    <b class="check_estimate_estimate_total_price"></b>원
                </div>
            </div>

            <div class="btn_box mt-10">
                <div class="flex gap-5">
                    <a class="btn btn-primary flex-1" style="cursor: pointer;" onclick="location.reload()">주문서 확인</a>
                </div>
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
                        <th>주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</th>
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
                                <td>없음</td>
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
                                <th>배송비용</th>
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
                        <b><span class="check_order_product_total_price"></span>원</b>
                    </p>
                    <p>
                        <span class="txt-gray fs14">
                            옵션금액
                        </span>
                        <b><span class="check_order_product_option_price"></span>원</b>
                    </p>
                    <p>
                        <span class="txt-gray fs14">배송비</span>
                        <b><span class="check_order_product_delivery_price"></span>원</b>
                    </p>
                </div>
                <div class="total">
                    <p>총 주문금액</p>
                    <b><span class="check_order_estimate_total_price"></span>원</b>
                </div>
            </div>

            <div class="btn_box mt-10">
                <div class="flex gap-5">
                    <a class="btn btn-primary flex-1" style="cursor: pointer;" onclick="location.reload()">주문서 확인</a>
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

    var product_option_price = 0;

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

        if (urlSearch.get('responseDate') && typeof bodies.responseDate === 'undefined') {
            bodies.responseDate = urlSearch.get('responseDate');
        } else if (bodies.responseDate === '') {
            delete bodies['responseDate'];
        }

        if (urlSearch.get('status') && typeof bodies.status === 'undefined') {
            bodies.status = urlSearch.get('status');
        } else if (bodies.status === '') {
            delete bodies['status'];
        }

        location.href = '/mypage/responseEstimate?' + new URLSearchParams(bodies);
    }

    const moveToEstimatePage = page => {
        const urlSearch = new URLSearchParams(location.search);
        let bodies = { offset: page };

        if (urlSearch.get('keywordType'))   bodies.keyword = urlSearch.get('keywordType');
        if (urlSearch.get('keyword'))       bodies.keyword = urlSearch.get('keyword');
        if (urlSearch.get('responseDate'))  bodies.responseDate = urlSearch.get('responseDate');
        if (urlSearch.get('status'))        bodies.status = urlSearch.get('status');

        location.replace('/mypage/responseEstimate?' + new URLSearchParams(bodies));
    }

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
        
        $('#loadingContainer').show();
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
                $('#loadingContainer').hide();
                alert('견적서 보내기가 완료되었습니다.');
                location.reload();
            } else {
                $('#loadingContainer').hide();
                alert('일시적인 오류로 처리되지 않았습니다.');
                return false;
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function(){
        var datepicker = flatpickr('#responseDate', {
            clickOpens      : false,   //input 클릭으로는 달력이 열리지 않음
            mode            : 'range', //날짜 범위 product_each_price_text선택 모드
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
        $('#responseDate').val('{{ request() -> get("responseDate") }}');

        // 아이콘 클릭 > 달력 열기
        window.openCalendar = function(){
            datepicker.open();
        };
    });

    document.getElementById('keyword').addEventListener('keyup', e => {
        const params = {
            keywordType     : (document.getElementById('selectedKeywordType').dataset.keywordType ?? ''),
            keyword         : e.currentTarget.value,
            responseDate     : document.getElementById('responseDate').value
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
        $('.request_estimate_detail').click(function(){
            estimate_idx = $(this).data('idx');
            estimate_code = $(this).data('code');
            response_company_type = $(this).data('response_company_type');

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
                if(json.result === 'success') {
                    console.log(json.data[0]);

                    $('.request_estimate_req_time').text(json.data[0].request_time);
                    $('.request_estimate_req_code').text(json.data[0].estimate_code);
                    $('.request_estimate_req_company_name').text(json.data[0].request_company_name);
                    $('.request_estimate_req_business_license_number').text(json.data[0].request_business_license_number);
                    $('.request_estimate_req_phone_number').text(json.data[0].request_phone_number);
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
                        console.log(product_option_json)
                        for(var key in product_option_json) {
                            $('.request_estimate_product_option_table').append(
                            `<tr>
                                <th>` + product_option_json[key]['optionName'] + `</th>
                                <td>` + Object.keys(product_option_json[key]['optionValue'])[0] + `</td>
                            </tr>`);
                        }

                        $('.request_estimate_product_option').append(`</table>`);
                    }
                    $('.request_estimate_product_each_price').text((parseInt(json.data[0].product_each_price) > 0) ? json.data[0].product_each_price + '원' : json.data[0].product_each_price_text);
                    $('.request_estimate_product_address').text(json.data[0].product_address);

                    modalOpen('#request_estimate-modal');
                } else {
                    alert(json.message);
                }
            });
        });

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
                if(json.result === 'success') {
                    console.log(json.data);
                    modalClose('#request_estimate-modal');

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
                    $('.response_estimate_product_total_price').text(json.data[0].product_total_price);
                    $('#response_estimate_product_total_price').val(json.data[0].product_total_price.replace(/[^0-9]/g, ''));
                    $('.response_estimate_product_address').text(json.data[0].product_address);
                    $('.response_estimate_product_delivery_price').text(json.data[0].product_delivery_price ? json.data[0].product_delivery_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') : '0');
                    $('#response_estimate_product_delivery_price').val(json.data[0].product_delivery_price ? json.data[0].product_delivery_price : '0');
                    $('#response_estimate_product_memo').val(json.data[0].product_memo);

                    $('.response_estimate_product_option_price').text(product_option_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
                    $('#response_estimate_product_option_price').val(product_option_price);

                    $('.response_estimate_estimate_total_price').text(json.data[0].estimate_total_price ? (parseInt(json.data[0].estimate_total_price) + parseInt(product_option_price)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') : (parseInt(json.data[0].product_total_price.replace(/[^0-9]/g, '')) + parseInt(product_option_price)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
                    $('#response_estimate_estimate_total_price').val(json.data[0].estimate_total_price ? parseInt(json.data[0].estimate_total_price) + parseInt(product_total_price) : parseInt(json.data[0].product_total_price.replace(/[^0-9]/g, '')) + parseInt(product_option_price));

                    modalOpen('#response_estimate-modal');
                } else {
                    alert(json.message);
                }
            });
        });

        // 견적서 확인하기
        $('.check_estimate_detail').click(function(){
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
                if(json.result === 'success') {
                    console.log(json.data);
                    modalClose('#request_estimate-modal');

                    $('.check_estimate_req_company_name').text((json.data[0].response_req_company_name));
                    $('.check_estimate_req_business_license_number').text((json.data[0].response_req_business_license_number));
                    $('.check_estimate_req_phone_number').text((json.data[0].response_req_phone_number));
                    $('.check_estimate_req_address1').text((json.data[0].response_req_address1));

                    $('.check_estimate_res_time').text(json.data[0].response_res_time ? json.data[0].response_res_time : json.data[0].now1);
                    $('.check_estimate_res_code').text(json.data[0].estimate_code);
                    $('.check_estimate_res_company_name').text(json.data[0].response_res_company_name);
                    $('.check_estimate_res_business_license_number').text(json.data[0].response_res_business_license_number);
                    $('.check_estimate_res_phone_number').text(json.data[0].response_res_phone_number);
                    $('.check_estimate_res_address1').text(json.data[0].response_res_address1);
                    $('.check_estimate_res_account').text((json.data[0].response_res_account));
                    $('.check_estimate_res_memo').text(json.data[0].response_res_memo ? json.data[0].response_res_memo : '');

                    var check_estimate_product_count = 0;
                    var check_estimate_product_total_price = 0;
                    product_option_price = 0;

                    $('.check_estimate_prod_list').html('');
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

                        var product_memo = json.data[i].product_memo ? json.data[i].product_memo : '';

                        $('.check_estimate_prod_list').append(
                            `<li>
                                <div class="img_box">
                                    <img src="` + json.data[i].product_thumbnail + `" alt="" class="product_thumbnail" />
                                </div>
                                <div class="right_box">
                                    <h6 class="product_name">` + json.data[i].name + `</h6>
                                    <table class="table_layout">
                                        <colgroup>
                                            <col width="160px">
                                            <col width="*">
                                        </colgroup>
                                        <tbody><tr>
                                            <th>상품번호</th>
                                            <td class="txt-gray product_number">` + json.data[i].product_number + `</td>
                                        </tr>
                                        <tr>
                                            <th>상품수량</th>
                                            <td class="txt-primary"><b class="product_count">` + json.data[i].product_count + `개</b></td>
                                        </tr>
                                        <tr>
                                            <th>옵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;션</th>
                                            <td>`
                                                + product_option_html +
                                            `</td>
                                        </tr>
                                        <tr>
                                            <th>견적단가</th>
                                            <td>` + json.data[i].product_each_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + `원</td>
                                        </tr>
                                        <tr>
                                            <th>견적금액</th>
                                            <td>
                                                <b class="product_total_price">` + json.data[i].product_total_price + `원</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>배송지역</th>
                                            <td class="product_address">` + json.data[i].product_address + `</td>
                                        </tr>
                                        <tr>
                                            <th>배송방법</th>
                                            <td>` + json.data[i].product_delivery_info.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + `</td>
                                        </tr>
                                        <tr>
                                            <th>배송비</th>
                                            <td>` + json.data[i].product_delivery_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + `원</td>
                                        </tr>
                                        <tr>
                                            <th>비고</th>
                                            <td>` + product_memo + `</td>
                                        </tr>
                                    </tbody></table>
                                </div>
                            </li>`
                        );

                        check_estimate_product_count += json.data[i].product_count;
                        check_estimate_product_total_price += parseInt(json.data[i].product_total_price.replace(/,/g, ''));
                        product_option_price += json.data[i].product_option_price;
                    }

                    $('.check_estimate_product_count').text(check_estimate_product_count + '개');
                    $('.check_estimate_product_total_price').text(check_estimate_product_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
                    $('.check_estimate_product_option_price').text(product_option_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');
                    $('.check_estimate_product_delivery_price').text(json.data[0].product_delivery_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
                    $('.check_estimate_estimate_total_price').text(json.data[0].estimate_total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));

                    modalOpen('#check_estimate-modal');
                } else {
                    alert(json.message);
                }
            });
        });

        $('.check_order_detail:button').click(function(){
            fetch('/estimate/checkOrder', {
                method  : 'PUT',
                headers : {
                    'Content-Type'  : 'application/json',
                    'X-CSRF-TOKEN'  : '{{csrf_token()}}'
                },
                body    : JSON.stringify({
                    estimate_code       : $(this).data('code'),
                    estimate_state      : $(this).data('state')
                })
            }).then(response => {
                return response.json();
            }).then(json => {
                if (json.result === 'success') {
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

                            var response_estimate_product_total_price = 0;
                            var response_estimate_product_option_price = 0;

                            $('.check_order_prod_list').html('');
                            for(var i = 0; i < json.data.length; i++) {
                                let product_memo = json.data[i].product_memo ? json.data[i].product_memo : '';

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
                                                    <td>없음</td>
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

                                response_estimate_product_total_price += parseInt(json.data[i].product_total_price);
                                response_estimate_product_option_price += parseInt(json.data[i].product_option_price);
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
                } else {
                    alert(json.message);
                }
            });
        });

        $(document).on('keyup', '#response_estimate_product_each_price', function(e){
            if(!$(this).val()) $(this).val(0);
            $(this).val($(this).val().replace(/[^0-9]/g, ''));

            $('.response_estimate_product_total_price').text((parseInt($(this).val()) * parseInt($('.response_estimate_product_count').last().text())).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
            $('#response_estimate_product_total_price').val(parseInt($(this).val()) * parseInt($('.response_estimate_product_count').last().text()));

            $('.response_estimate_estimate_total_price').text((parseInt($(this).val()) * parseInt($('.response_estimate_product_count').last().text()) + parseInt($('#response_estimate_product_delivery_price').val()) + parseInt(product_option_price)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
            $('#response_estimate_estimate_total_price').val((parseInt($(this).val()) * parseInt($('.response_estimate_product_count').last().text()) + parseInt($('#response_estimate_product_delivery_price').val())) + parseInt(product_option_price));
        });

        $(document).on('keyup', '#response_estimate_product_delivery_price', function(e){
            if(!$(this).val()) $(this).val(0);
            $(this).val($(this).val().replace(/[^0-9]/g, ''));

            $('.response_estimate_product_delivery_price').text((parseInt($(this).val())).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));

            $('.response_estimate_estimate_total_price').text((parseInt($(this).val()) + parseInt($('#response_estimate_product_total_price').val())  + parseInt(product_option_price)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
            $('#response_estimate_estimate_total_price').val((parseInt($(this).val()) + parseInt($('#response_estimate_product_total_price').val())) + parseInt(product_option_price));
        });
    });
</script>