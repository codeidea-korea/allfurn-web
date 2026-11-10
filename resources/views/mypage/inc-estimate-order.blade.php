
<!-- 주문서  -->
<!-- 
<div class="modal" id="order_form-modal">
	<div class="modal_bg" onclick="modalClose('#order_form-modal')"></div>
	<div class="modal_inner new-modal">
        <div class="modal_header">
            <h3>주문서</h3>
            <button class="close_btn" onclick="modalClose('#order_form-modal')"><img src="/img/icon/x_icon.svg" alt=""></button>
        </div>

		<div class="modal_body">
              -->
            <div class="relative">
                <div class="info">
                    <div class="fold_area txt_info active">
                        <div class="target title" onclick="foldToggle(this)">
                            <p>결제정보</p>
                            <img class="arrow" src="/img/icon/arrow-icon.svg" alt="">
                        </div>
                        <div>
                        <?php 
                            $grand_total = 0; 
                            $is_any_price_hide = false;
                            $checked_count = 0;
                        ?>
                        @foreach( $lists AS $key => $row )
                                @php
                                    if (($row->estimate_check ?? '') !== 'Y') continue;
                                    $checked_count++;
                                    $pricing = \App\Support\EstimatePricing::forEstimate($row);
                                    $grand_total += $pricing['total'];
                                    $is_any_price_hide = $is_any_price_hide || $pricing['inquiry'];
                                @endphp
                        @endforeach
                            <div class="txt_desc">
                                <div class="name">결제금액</div>
                                <div>{{ $is_any_price_hide ? '업체 문의' : number_format($grand_total, 0) }}</div>
                            </div>
                            <div class="txt_desc">
                                <div class="name">배송비</div>
                                <div>{{ number_format($lists[0]->product_delivery_price, 0) }}</div>
                            </div>
                            <!--
                            <div class="txt_desc">
                                <div class="name">입금금액</div>
                                <div><b>5,500,100,000</b></div>
                            </div>
-->
                            <div class="txt_desc">
                                <div class="name">은행정보</div>
                                <div><b>{{ $lists[0]->response_account }}</b></div>
                            </div>
                            <!--
                            <div class="txt_desc">
                                <div class="name">입금자명</div>
                                <div>공급업체명표기</div>
                            </div>
                            -->
                        </div>
                    </div>
                </div>
                <div class="p-7">
                    <!-- 견적 기본정보 -->
                    <div class="fold_area txt_info active">
                        <div class="target title" onclick="foldToggle(this)">
                            <p>주문업체 기본정보</p>
                            <div class="flex items-center gap-2">
                                <span>(주문번호 : {{ $lists[0]->estimate_group_code }})</span>
                                <img class="arrow" src="/img/icon/arrow-icon.svg" alt="">
                            </div>
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
                            <p>수급업체 기본정보</p>
                            <img class="arrow" src="/img/icon/arrow-icon.svg" alt="">
                        </div>
                        <div>
                            <div class="flex gap-2 mt-2">
                                <div class="img_box"><img src="{{ $lists[0]->order_business_license}}" alt=""></div>
                                <div class="flex-1">
                                    <div class="txt_desc">
                                        <div class="name">업체명</div>
                                        <div>{{ $lists[0]->response_company_name }}</div>
                                    </div>
                                    <div class="txt_desc">
                                        <div class="name">사업자번호</div>
                                        <div>{{ $lists[0]->response_business_license_number }}</div>
                                    </div>
                                    <div class="txt_desc">
                                        <div class="name">전화번호</div>
                                        <div>{{ $lists[0]->response_phone_number }}</div>
                                    </div>
                                    <div class="txt_desc">
                                        <div class="name">주요판매처</div>
                                        <div>매장판매</div>
                                    </div>
                                    <div class="txt_desc">
                                        <div class="name">주소</div>
                                        <div>{{ $lists[0]->response_address1.' '.$lists[0]->response_address2 }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 접기/펼치기 -->
                    <div class="fold_area active">
                        <div class="target">
                            <button class="title" onclick="foldToggle(this)">
                                <span>주문 상품 {{ $checked_count }}건 리스트 보기</span>
                                <img class="arrow" src="/img/icon/arrow-icon.svg" alt="">
                            </button>
                        </div>
                        <div class="py-7">
                            @foreach( $lists AS $key => $row )
                            @if(isset($row->estimate_check) && $row->estimate_check == 'Y')
                            @php($pricing = \App\Support\EstimatePricing::forEstimate($row))
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
                                    
                                    @include('mypage.estimate-product-price', ['row' => $row])
                                    <div class="prod_option">
                                        <div class="name estimate">견적가</div>
                                        <div class="name estimate">{{ number_format($pricing['adjustment']) }}원</div>
                                    </div>
                                    <div class="prod_option">
                                        <div class="name note">비고</div>
                                        <div>{{ $row->product_memo }}</div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            @endif
                            @endforeach
                        </div>
                    </div>
 
                </div>
            </div>
            <!-- 
		</div>

        <div class="modal_footer">
            <button type="button" onclick="modalClose('#order_form-modal')">닫기</button>
        </div>
	</div>
</div>

-->
