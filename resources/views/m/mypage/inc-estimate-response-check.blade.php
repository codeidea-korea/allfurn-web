
<!-- 받은 견적서
<div class="modal" id="receive_estimate-modal">
	<div class="modal_bg" onclick="modalClose('#receive_estimate-modal')"></div>
	<div class="modal_inner new-modal">
        <div class="modal_header">
            <h3>받은 견적서</h3>
            <button class="close_btn" onclick="modalClose('#receive_estimate-modal')"><img src="/img/icon/x_icon.svg" alt=""></button>
        </div>
		<div class="modal_body">
  -->
            <div class="relative">
                <div class="info">'{{ $lists[0]->request_company_name }}'업체의 '{{ $lists[0]->response_company_name }}' {{ count( $lists ) }}건 상품 견적서 입니다.</div>
                <div class="p-3">
                    <!-- 견적 기본정보 -->
                    <div class="fold_area txt_info active">
                        <div class="target title" onclick="foldToggle(this)">
                            <p>공급업체 기본정보</p>
                            <div class="flex items-center gap-2">
                                <span>(주문번호 : {{ $lists[0]->estimate_group_code }})</span>
                                <img class="arrow" src="/img/icon/arrow-icon.svg" alt="">
                            </div>
                        </div>
                        <div>
                            <div class="flex flex-col gap-2 mt-2">
                                <div class="img_box"><img src="{{ $lists[0]->business_license}}" alt=""></div>
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
                                    <div class="txt_desc">
                                        <div class="name">배송</div>
                                        <div>{{ $lists[0]->delivery_info }} ({{ number_format( $lists[0]->product_delivery_price ) }})</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="fold_area txt_info active">
                        <div class="target title" onclick="foldToggle(this)">
                            <p>자동 견적가</p>
                            <img class="arrow" src="/img/icon/arrow-icon.svg" alt="">
                        </div>
                        <div>
                            <div class="txt_desc">
                                <div class="name">가격 표기 상품 {{ count( $lists ) }}건</div>
                                <div><b>{{ number_format( $lists[0]->estimate_total_price ) }}</b></div>
                            </div>
                        </div>
                    </div>

                    <!-- 기타 답변내용 -->
                    <dl class="add_textarea mb-7">
                        <dt>기타 답변내용</dt>
                        <dd>{{ $lists[0]->response_memo }}</dd>
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
                    
                    <div class="p-3">
                        <!-- 접기/펼치기 -->
                        <div class="fold_area active">
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
                                        <input type="checkbox" id="check_7" class="hidden" >
                                        <!-- <label for="check_7" class="add_btn">추가</label> -->
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
                                                                <p class="option_name">{{$item2->optionName}}</p>
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
                                                <div>{{ $row->product_total_price }}</div>
                                            </div>
                                        @endif
                                        <div class="prod_option">
                                            <div class="name estimate">견적가</div>
                                            <div class="name estimate">{{ $row->product_each_price }}</div>
                                        </div>
                                        <div class="prod_option">
                                            <div class="name note">비고</div>
                                            <div>{{ $row->product_memo }}</div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                @endforeach
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            
<!-- 
		</div>

        <div class="modal_footer">
            <button type="button" onclick="modalClose('#receive_estimate-modal')">닫기</button>
        </div>
	</div>
</div>


  -->
