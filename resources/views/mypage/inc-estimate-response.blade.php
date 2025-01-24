<div class="relative">
    <div class="info">'{{ $lists[0]->request_company_name }}'업체의 {{ count( $lists ) }}건 상품 견적 요청서 입니다.</div>
    <div class="p-7">
        <!-- 견적 기본정보 -->
        <div class="fold_area txt_info">
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

        <div class="fold_area txt_info active">
            <div class="target title" onclick="foldToggle(this)">
                <p>견적 기본정보</p>
                <img class="arrow" src="/img/icon/arrow-icon.svg" alt="">
            </div>
            @php
            $sample_total_price = 0;
            $count_open_price = 0;
            $count_close_price = 0;

            for($idx = 0; $idx < count($lists); $idx++) {
                if($lists[$idx]->product_each_price > 0) {
                    $count_open_price = $count_open_price + 1;
                    $sample_total_price = $sample_total_price + (((int)$lists[$idx]->product_total_price) * ((int)$lists[$idx]->product_count));
                } else {
                    $count_close_price = $count_close_price + 1;
                }
            }
            @endphp
            <div>
                <div class="txt_desc">
                    <div class="name">가격 표기 {{ $count_open_price }}건</div>
                    <div>견적가 <b>{{ number_format( $lists[0]->estimate_total_price ) }}</b></div>
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
                        <div><b>{{ number_format( $lists[0]->estimate_total_price ) }}</b></div>
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
                            
                            @if(isset($row->product_option) && $row->product_option != '[]')
                                <?php $arr = json_decode($row->product_option); $required = false; ?>
                                <div class="noline">
                                    @foreach($arr as $item2)
                                    <div class="option_item">
                                        <div class="">
                                            <p class="option_name">{{$item2->optionName}}</p>
                                        </div>
                                        <div class="mt-2">
                                            <div>{{ $row->product_count }}개</div>
                                            <div class="price">50,000</div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="prod_option">
                                    <div class="name">가격</div>
                                    <div class="total_price">{{ $row->product_total_price }}</div>
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
                                <div><input type="text" name="product_each_price" class="input-form required" value="{{ $row->product_each_price }}"></div>
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
                    <div class="txt_desc">
                        <div class="name">계좌번호</div>
                        <div class="flex items-center gap-3">
                            <div class="dropdown_wrap">
                                <button id="bank_type" class="dropdown_btn" onClick="dropBtn(this);"><p>은행선택</p></button>
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
                            <input type="text" id="account_number" class="input-form">
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