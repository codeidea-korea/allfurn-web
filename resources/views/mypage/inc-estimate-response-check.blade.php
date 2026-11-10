
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
            <div class="relative" data-estimate-received-prices>
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
                                <div><b>{{ number_format(array_sum(array_map(function ($item) { return \App\Support\EstimatePricing::forEstimate($item)['total']; }, $lists))) }}</b></div>
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
                                    <div class="name"><p>총 상품<span id="selected_count">0</span>건</p></div>
                                    <div><b id="selected_total_price">0</b><b>원</b></div>
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
                                    
                                    @php
                                        $pricing = \App\Support\EstimatePricing::forEstimate($row);
                                        $totalPriceForCalc = $pricing['total'];
                                    @endphp
                                    

                                <div class="prod_info">
                                    <div class="img_box">
                                        <input type="hidden" name="idx" value="{{ $row->estimate_idx }}">
                                        <input type="checkbox" id="check_{{ $row->estimate_idx }}"  class="item_selector hidden" data-code="{{ $row->estimate_code }}" 
                                        data-price="{{$totalPriceForCalc}}" onclick="updateEstimateInfo(this)" checked>
                                        <label for="check_{{ $row->estimate_idx }}" class="add_btn">추가</label>
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
<script>
function updateEstimateInfo(obj) {
    const roots = obj ? $(obj).closest('[data-estimate-received-prices]') : $('[data-estimate-received-prices]');
    roots.each(function () {
        let count = 0;
        let total = 0;
        $(this).find('.item_selector').each(function () {
            $(this).next('label').text(this.checked ? '취소' : '추가');
            if (this.checked) {
                count++;
                total += Number($(this).attr('data-price')) || 0;
            }
        });
        $(this).find('#selected_count').text(count);
        $(this).find('#selected_total_price').text(total.toLocaleString());
    });
}
$(function () {
    $('[data-estimate-received-prices] .item_selector').off('.estimatePrice').on('change.estimatePrice', function () { updateEstimateInfo(this); });
    updateEstimateInfo(null);
});
</script>
