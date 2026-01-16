<div class="relative">
    <div class="info">'{{ $lists[0]->request_company_name }}'업체의 {{ count( $lists ) }}건 상품 견적 요청서 입니다.</div>
    <div class="p-3">
        <!-- 견적 기본정보 -->
        <div class="fold_area active txt_info">
            <div class="target title" onclick="foldToggle(this)">
                <p>구매업체 기본정보 <span>(주문번호 : {{ $lists[0]->estimate_group_code }})</span></p>
                <img class="arrow" src="/img/icon/arrow-icon.svg" alt="">
            </div>
            <div>
                <div class="flex flex-col gap-2 mt-2">
                    <div class="img_box"><img src="{{ $lists[0]->business_license}}" alt=""></div>
                    <div class="flex-1">
                        <div class="txt_desc">
                            <div class="name">업체명</div>
                            <div>{{ $lists[0]->request_company_name }}</div>
                        </div>
                        <div class="txt_desc">
                            <div class="name">사업자번호</div>
                            <div>{{ $lists[0]->request_business_license_number }}</div>
                        </div>
                        <div class="txt_desc">
                            <div class="name">전화번호</div>
                            <div>{{ $lists[0]->request_phone_number }}</div>
                        </div>
                        <div class="txt_desc">
                            <div class="name">주요판매처</div>
                            <div>매장판매</div>
                        </div>
                        <div class="txt_desc">
                            <div class="name">주소</div>
                            <div>{{ $lists[0]->request_address1.' '.$lists[0]->request_address2 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="fold_area txt_info">
            <div class="target title" onclick="foldToggle(this)">
                <p>견적 기본정보</p>
                <img class="arrow" src="/img/icon/arrow-icon.svg" alt="">
            </div>
            
            @php
            $sample_total_price = 0;
            $count_open_price = 0;
            $count_close_price = 0;
            $grand_total_price = 0; // [수정] 전체 합계를 담을 별도 변수 선언

            foreach( $lists AS $key => $row ){
                if( $row->is_price_open == 0 || $row->price_text == '수량마다 상이' || $row->price_text == '업체 문의' ? 1 : 0 ){
                    $count_close_price = $count_close_price + 1;
                } else {
                    $count_open_price = $count_open_price + 1;
                }
                
                if(isset($row->product_option_json) && $row->product_option_json != '[]') {
                    $arr = json_decode($row->product_option_json); $required = false; $_each_price = 0;
                    foreach($arr as $item2)   {                                              
                        foreach($item2->optionValue as $sub) {
                            if(! property_exists($sub, 'price')) {
                                continue;
                            }
                            $_each_price += (intval($sub->price) * (property_exists($sub, 'count') && $sub->count == null ? $sub->count : 1)); 
                        }
                    }
                    if( $row->is_price_open == 0 || $row->price_text == '수량마다 상이' || $row->price_text == '업체 문의' ? 1 : 0 ){
                        $lists[0]->is_price_open = 0;
                        $lists[0]->price_text = $row->price_text;
                    }

                    else{
                        // [수정] 별도 변수에 합산
                        $grand_total_price += $row->price + $_each_price;
                    }
                    
                } else {
                    if( $row->is_price_open == 0 || $row->price_text == '수량마다 상이' || $row->price_text == '업체 문의' ? 1 : 0 ) {
                        $lists[0]->is_price_open = 0;
                        $lists[0]->price_text = $row->price_text;
                    }
                    
                    else {
                     // [수정] 별도 변수에 합산
                        $grand_total_price += $row->product_count * (!is_numeric($row->price) ? 0 : $row->price);
                    }
                    
                }
            }
            @endphp
            <div>
                <div class="txt_desc">
                    <div class="name">가격 표기 {{ $count_open_price }}건</div>
                    <div>견적가 <b>{{ number_format($grand_total_price)  }}</b></div>
                </div>
                <div class="txt_desc">
                    <div class="name">업체문의 상품 {{ $count_close_price }}건</div>
                    <div>업체문의</div>
                </div>
            </div>
        </div>

        <!-- 업체 문의내용 -->
        <dl class="add_textarea mb-7">
            <dt>업체 문의내용</dt>
            <dd><textarea name="" id="" placeholder="견적서 수량은 추가 될 수 있습니다. 수량 추가 시 견적관련 전화 문의 드립니다.">{{ $lists[0]->request_memo }}</textarea></dd>
        </dl>

    </div>
    <div class="relative">
        <div class="info">
            <div class="txt_info">
                <div class="title"><p>납품 예산견적 정보</p></div>
                <div>
                    <div class="txt_desc">
                        <div class="name">총 상품 {{ count( $lists ) }}건</div>
                         <div><b id="final_total_display">0</b>원</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-3">
            <!-- 접기/펼치기 -->
            <div class="fold_area active mt-7">
                <div class="target">
                    <button class="title" onclick="foldToggle(this)">
                        <span>상품 {{ count( $lists ) }}건 리스트 보기</span>
                        <img class="arrow" src="/img/icon/arrow-icon.svg" alt="">
                    </button>
                </div>
                <div class="py-7">
                    @foreach( $lists AS $key => $row )
                    @php
                        // 1. 견적가 (입력받은 값 혹은 설정된 값)
                        $cleanEstimatePrice = isset($row->price) ? (int)preg_replace('/[^0-9]/', '', $row->price) : 0;

                        //$is_inquiry = ($row->is_price_open == 0 || $row->price_text == '수량마다 상이' || $row->price_text == '업체 문의');

                        // 2. 단가 (기존 상품 총액 혹은 단가)
                        //$cleanUnitPrice = isset($row->product_total_price) ? (int)preg_replace('/[^0-9]/', '', $row->product_total_price) : 0;
                        $cleanUnitPrice = (!isset($row->product_total_price) || $row->is_price_open == 0 || $row->price_text == '수량마다 상이' || $row->price_text == '업체 문의') ? 0 : (int)preg_replace('/[^0-9]/', '', $row->product_total_price);
                        //$cleanUnitPrice = $is_inquiry ? 0 : (isset($row->product_total_price) ? (int)preg_replace('/[^0-9]/', '', $row->product_total_price) : 0);

                        // 3. 옵션 가격 계산
                        $optionPriceSum = 0;
                        $hasOption = false;

                        if(isset($row->product_option_json) && $row->product_option_json != '[]') {
                            $tempOptions = json_decode($row->product_option_json);
                            
                            if (!empty($tempOptions) && (is_array($tempOptions) || is_object($tempOptions))) {
                                $hasOption = true; 
                                foreach($tempOptions as $tempItem) {
                                    if (!isset($tempItem->optionValue)) continue;
                                    foreach($tempItem->optionValue as $tempSub) {
                                        if(!property_exists($tempSub, 'price')) continue;
                                        
                                        // 가격 추출
                                        $optPrice = isset($tempSub->each_price) ? (int)preg_replace('/[^0-9]/', '', $tempSub->each_price) : 0;
                                    
                                        
                                        // 옵션 총액 = 가격 * 수량
                                        $optionPriceSum += $optPrice;
                                    }
                                }
                            }
                        }

                        // 4. 최종 계산 (이 부분을 정책에 맞게 수정하세요)
                        if ($hasOption) {
                            // [케이스 A] 옵션 있음: (견적가 + 옵션총액)
                            // ※ 만약 견적가가 '상품기본가' 역할을 한다면 더하는 게 맞습니다.
                            $totalPriceForCalc = $optionPriceSum;
                        } else {
                            // [케이스 B] 옵션 없음: 
                            // 의도하신 대로 두 값을 더하는 로직을 유지했습니다. (정책 확인 필요)
                            $totalPriceForCalc = $cleanUnitPrice;
                        }
                    @endphp
                    <div class="prod_info">
                    <input type="hidden" class="calc_base_price" value="{{ $totalPriceForCalc }}">    
                    <div class="img_box">
                            <input type="hidden" name="idx" value="{{ $row->estimate_idx }}">
                            <!--input type="checkbox" id="check_7" class="hidden" checked disabled>
                            <label for="check_7" class="add_btn">대표</label //-->
                            <img src="{{ $row->product_thumbnail }}" alt="">
                        </div>
                        <div class="info_box">
                            <div class="order_num noline">개별주문번호 : {{ $row->estimate_code }}</div>
                            <div class="prod_name">{{ $row->name }}</div>

                            @if(isset($row->product_option_json) && $row->product_option_json != '[]')
                                <?php $arr = json_decode($row->product_option_json); $required = false; $_each_price = 0; ?>
                                <div class="noline">
                                    @foreach($arr as $item2)                                                
                                        @foreach($item2->optionValue as $sub)
                                            @php
                                            if(! property_exists($sub, 'price')) {
                                                continue;
                                            }
                                            @endphp
                                            <div class="option_item">
                                                <div class="">
                                                    <p class="option_name">{{$sub->propertyName}}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <div>{{ ($sub->count) . '' }}개</div>
                                                    <? $_each_price += $sub->each_price; ?>
                                                    <div class="price"><?php echo number_format($sub->each_price, 0); ?></div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endforeach
                                </div>
                                <div class="prod_option">
                                    <div class="name">가격</div>
                                    <div class="total_price">
                                        @if( $row->is_price_open == 0 || $row->price_text == '수량마다 상이' || $row->price_text == '업체 문의' ? 1 : 0 )
                                            {{ $row->price_text }}
                                        @else
                                            {{$row->is_price_open ? number_format($row->price + $_each_price, 0).'원': $row->price_text}}
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="prod_option">
                                    <div class="name">수량</div>
                                    <div>{{ $row->product_count }}개</div>
                                </div>
                                <div class="prod_option">
                                    <div class="name">단가</div>
                                    <div>{{ ($row->is_price_open == 0 || $row->price_text == '수량마다 상이' || $row->price_text == '업체 문의') ? '업체 문의' : number_format($row->product_total_price).'원' }}</div>
                                </div>
                            @endif

                            <div class="prod_option">
                                <div class="name estimate">견적가</div>
                                <div><input type="text" name="product_each_price" maxLength="10" class="input-form required calc_input_price" value="0"></div>
                            </div>
                            <div class="prod_option">
                                <div class="name note">비고</div>
                                <div><input type="text" name="product_memo" class="input-form" value="{{ $row->product_memo }}"></div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    @endforeach
                </div>
            </div>

            <div class="txt_info mt-10">
                <div class="title"><p>결제 및 배송 정보</p></div>
                <div>
                    @php
                    if(!empty($lists[0]->response_account) && strpos($lists[0]->response_account, ' ')) {
                        $response_account = explode(' ', $lists[0]->response_account);
                    } else {
                        $response_account = array();
                        array_push($response_account, '은행선택');
                        array_push($response_account, '');
                    }
                    @endphp
                    <div class="txt_desc flex-col !items-start gap-1">
                        <div class="name">계좌번호</div>
                        <div class="flex items-center gap-3">
                            <div class="dropdown_wrap">
                                <button id="bank_type" class="dropdown_btn whitespace-nowrap !pr-6" onClick="dropBtn(this);"><p>{{$response_account[0]}}</p></button>
                                <div class="dropdown_list">
                                    <div class="dropdown_item" onClick="dropItem(this);" data-val="KEB하나은행">KEB하나은행</div>
                                    <div class="dropdown_item" onClick="dropItem(this);" data-val="SC제일은행">SC제일은행</div>
                                    <div class="dropdown_item" onClick="dropItem(this);" data-val="국민은행">국민은행</div>
                                    <div class="dropdown_item" onClick="dropItem(this);" data-val="신한은행">신한은행</div>
                                    <div class="dropdown_item" onClick="dropItem(this);" data-val="외환은행">외환은행</div>
                                    <div class="dropdown_item" onClick="dropItem(this);" data-val="우리은행">우리은행</div>
                                    <div class="dropdown_item" onClick="dropItem(this);" data-val="한국시티은행">한국시티은행</div>
                                    <div class="dropdown_item" onClick="dropItem(this);" data-val="기업은행">기업은행</div>
                                    <div class="dropdown_item" onClick="dropItem(this);" data-val="농협">농협</div>
                                    <div class="dropdown_item" onClick="dropItem(this);" data-val="수협">수협</div>
                                </div>
                            </div>
                            <input type="text" id="account_number" class="input-form" value="{{$response_account[1]}}">
                        </div>
                    </div>
                    <div class="txt_desc flex-col !items-start gap-1">
                        <div class="name">배송비</div>
                        <div class="flex items-center gap-3">
                            <div class="dropdown_wrap">
                                <button id="delivery_type" class="dropdown_btn" onClick="dropBtn(this);"><p>착불</p></button>
                                <div class="dropdown_list">
                                    <div class="dropdown_item" onClick="dropItem(this);">무료</div>
                                    <div class="dropdown_item" onClick="dropItem(this);">착불</div>
                                </div>
                            </div>
                            <input type="text" id="delivery_price" class="input-form">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 기타 답변내용 -->
            <dl class="add_textarea mb-7">
                <dt>기타 답변내용</dt>
                <dd><textarea name="response_memo" id="response_memo" placeholder="요청자님에게 그 외 내용을 입력 하세요">{{ $lists[0]->response_memo }}</textarea></dd>
            </dl>
        </div>

    </div>
</div>

<script>
$(document).ready(function() {
    updateTotalPrice(); // 페이지 로드 시 1회 실행

    // (선택사항) 만약 사용자가 입력창(견적가) 숫자를 바꾸면 실시간으로 합계도 바꾸고 싶다면 아래 주석 해제
    
    $('.calc_input_price').on('keyup change', function() {
        updateTotalPrice();
    });
    
});

function updateTotalPrice() {
    let grandTotal = 0;

    // 리스트의 각 항목(prod_info)을 순회
    $('.prod_info').each(function() {
        // 1. 숨겨둔 product_total_price 값 가져오기 (없으면 0)
        let basePrice = parseInt($(this).find('.calc_base_price').val()) || 0;
        
        // 2. 입력창(견적가) 값 가져오기 (콤마 제거 후 정수 변환, 없으면 0)
        let inputVal = $(this).find('.calc_input_price').val();
        let inputPrice = parseInt(inputVal.replace(/,/g, '')) || 0;

        // 3. 두 값을 더해서 전체 합계에 누적
        grandTotal += (basePrice + inputPrice);
    });

    // 4. 위쪽(id="final_total_display")에 천단위 콤마 찍어서 출력
    $('#final_total_display').text(grandTotal.toLocaleString());
}
</script>