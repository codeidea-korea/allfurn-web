<div class="relative">
    <div class="info">'{{ $lists[0]->request_company_name }}'업체의 {{ count( $lists ) }}건 상품 견적 요청서 입니다.</div>
    <div class="p-7">
        <!-- 견적 기본정보 -->
        <div class="fold_area active txt_info">
            <div class="target title" onclick="foldToggle(this)">
                <p>구매업체 기본정보 <span>(주문번호 : {{ $lists[0]->estimate_group_code }})</span></p>
                <img class="arrow" src="/img/icon/arrow-icon.svg" alt="">
            </div>
            <div>
                <div class="flex gap-2 mt-2">
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

        <div class="fold_area active txt_info">
            <div class="target title" onclick="foldToggle(this)">
                <p>견적 기본정보</p>
                <img class="arrow" src="/img/icon/arrow-icon.svg" alt="">
            </div>
            @php
            $sample_total_price = 0;
            $count_open_price = 0;
            $count_close_price = 0;
            
            // [수정] 옵션 가격의 합계만 따로 관리하기 위한 변수
            $total_option_price = 0;
            
            // [수정] 전체 견적가 합계를 정확히 다시 계산하기 위해 0으로 초기화
            $lists[0]->product_total_price = 0;

            foreach( $lists AS $key => $row ){
                // 공개/비공개 카운트 (기존 로직 유지)
                if( $row->is_price_open == 0 || $row->price_text == '수량마다 상이' || $row->price_text == '업체 문의' ? 1 : 0 ){
                    $count_close_price = $count_close_price + 1;
                } else {
                    $count_open_price = $count_open_price + 1;
                }
                
                $_each_price = 0; // 현재 상품의 옵션 합계

                if(isset($row->product_option_json) && $row->product_option_json != '[]') {
                    $arr = json_decode($row->product_option_json);
                    foreach($arr as $item2) {                                      
                        foreach($item2->optionValue as $sub) {
                            if(! property_exists($sub, 'price')) {
                                continue;
                            }
                            // [수정] 하단 뷰와 동일하게 each_price를 사용하여 합산 (가격 비공개 여부와 상관없이 계산)
                            if (property_exists($sub, 'each_price')) {
                                $_each_price += $sub->each_price;
                            } else {
                                // each_price가 없는 경우 기존 방식 예비 사용
                                $_each_price += (intval($sub->price) * (property_exists($sub, 'count') && $sub->count == null ? $sub->count : 1));
                            }
                        }
                    }
                } 

                // [수정] 전체 견적가 합계 계산 (공개 여부 상관없이 무조건 합산)
                // 하단 JS는 input 값($row->price) + 옵션가($_each_price)를 더하므로, PHP도 동일하게 계산
                $current_product_price = is_numeric($row->price) ? $row->price : 0;
                $lists[0]->product_total_price += ($current_product_price + $_each_price);

                // [수정] 옵션 총액 누적 (공개 여부 상관없이 무조건 합산)
                $total_option_price += $_each_price;
            }
            @endphp
            <div>
                <div class="txt_desc">
                    <div class="name">가격 표기 {{ $count_open_price }}건</div>
                    <div>견적가 <b>{{  number_format($lists[0]->product_total_price)  }}</b></div>
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
                        <div>
                            <!-- [수정] data-base-price에 전체 총합이 아닌 '옵션 총합($total_option_price)'을 할당 -->
                            <!-- 페이지 로딩 시 JS가 이 값 + input 값들을 합산하여 텍스트를 갱신함 -->
                            <b id='total_price_display' data-base-price="{{ $total_option_price }}">
                            {{ number_format($lists[0]->product_total_price) }}
                            </b>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-7">
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
                    <div class="prod_info">
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
                                                    <!-- [수정] optionName -> propertyName 변경 -->
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
                                            업체 문의
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
                                    <div>{{ $row->product_total_price }}</div>
                                </div>
                            @endif

                            <div class="prod_option">
                                <div class="name estimate">견적가</div>
                                <div><input type="text" name="product_each_price" maxLength="10" class="input-form required price-input" value="{{ $row->price }}"></div>
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
                    <div class="txt_desc">
                        <div class="name">계좌번호</div>
                        <div class="flex items-center gap-3">
                            <div class="dropdown_wrap">
                                <button id="bank_type" class="dropdown_btn" onClick="dropBtn(this);"><p>{{$response_account[0]}}</p></button>
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
                    <div class="txt_desc">
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
    // [수정] 총 견적가 계산 함수
    function updateTotalEstimatePrice() {
        // PHP에서 계산한 '순수 옵션 총합'
        let basePrice = Number($('#total_price_display').attr('data-base-price')) || 0;
        let addedPrice = 0;

        // 현재 입력된 모든 상품의 견적가(단가) 합산
        $('input[name="product_each_price"]').each(function() {
            let val = Number($(this).val().replace(/[^0-9]/g, "")) || 0; 
            addedPrice += val;
        });

        // 최종 합계 = 옵션 총합 + 상품 견적가 총합
        let finalTotal = basePrice + addedPrice;
        $('#total_price_display').text(finalTotal.toLocaleString());
    }

    $(document).on('input', '[name="product_each_price"]', function() {
        updateTotalEstimatePrice();
    });

    // [수정] 페이지 로드 시 즉시 계산하여 초기화
    $(function() {
        updateTotalEstimatePrice();
    });
</script>