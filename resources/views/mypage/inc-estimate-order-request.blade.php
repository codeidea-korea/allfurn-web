
<!-- 주문서  -->
<div class="modal" id="order_form-modal">
	<div class="modal_bg" onclick="modalClose('#order_form-modal')"></div>
	<div class="modal_inner new-modal">
        <div class="modal_header">
            <h3>주문서</h3>
            <button class="close_btn" onclick="modalClose('#order_form-modal')"><img src="/pc/img/icon/x_icon.svg" alt=""></button>
        </div>

		<div class="modal_body">
            <div class="relative">
                <div class="info">
                    <div class="fold_area txt_info active">
                        <div class="target title" onclick="foldToggle(this)">
                            <p>결제정보</p>
                            <img class="arrow" src="/pc/img/icon/arrow-icon.svg" alt="">
                        </div>
                        <div>
                            <div class="txt_desc">
                                <div class="name">결제금액</div>
                                <div>5,500,000,000</div>
                            </div>
                            <div class="txt_desc">
                                <div class="name">배송비</div>
                                <div>100,000</div>
                            </div>
                            <div class="txt_desc">
                                <div class="name">입금금액</div>
                                <div><b>5,500,100,000</b></div>
                            </div>
                            <div class="txt_desc">
                                <div class="name">은행정보</div>
                                <div><b>1231212312345</b></div>
                            </div>
                            <div class="txt_desc">
                                <div class="name">입금자명</div>
                                <div>공급업체명표기</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-7">
                    <!-- 견적 기본정보 -->
                    <div class="fold_area txt_info active">
                        <div class="target title" onclick="foldToggle(this)">
                            <p>공급업체 기본정보</p>
                            <div class="flex items-center gap-2">
                                <span>(주문번호 : 4NZAP8K1AZO5V2TB)</span>
                                <img class="arrow" src="/pc/img/icon/arrow-icon.svg" alt="">
                            </div>
                        </div>
                        <div>
                            <div class="flex gap-2 mt-2">
                                <div class="img_box"><img src="/pc/img/prod_thumb3.png" alt=""></div>
                                <div class="flex-1">
                                    <div class="txt_desc">
                                        <div class="name">업체명</div>
                                        <div>공급업체명표기</div>
                                    </div>
                                    <div class="txt_desc">
                                        <div class="name">사업자번호</div>
                                        <div>123121234</div>
                                    </div>
                                    <div class="txt_desc">
                                        <div class="name">전화번호</div>
                                        <div>010-1234-5678</div>
                                    </div>
                                    <div class="txt_desc">
                                        <div class="name">주요판매처</div>
                                        <div>매장판매</div>
                                    </div>
                                    <div class="txt_desc">
                                        <div class="name">주소</div>
                                        <div>경기 고양시 일산동구 산두로213번지 18 1층</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="fold_area txt_info active">
                        <div class="target title" onclick="foldToggle(this)">
                            <p>수급업체 기본정보</p>
                            <img class="arrow" src="/pc/img/icon/arrow-icon.svg" alt="">
                        </div>
                        <div>
                            <div class="flex gap-2 mt-2">
                                <div class="img_box"><img src="/pc/img/prod_thumb3.png" alt=""></div>
                                <div class="flex-1">
                                    <div class="txt_desc">
                                        <div class="name">업체명</div>
                                        <div>수급업체명표기</div>
                                    </div>
                                    <div class="txt_desc">
                                        <div class="name">사업자번호</div>
                                        <div>123121234</div>
                                    </div>
                                    <div class="txt_desc">
                                        <div class="name">전화번호</div>
                                        <div>010-1234-5678</div>
                                    </div>
                                    <div class="txt_desc">
                                        <div class="name">주요판매처</div>
                                        <div>매장판매</div>
                                    </div>
                                    <div class="txt_desc">
                                        <div class="name">주소</div>
                                        <div>경기 고양시 일산동구 산두로213번지 18 1층</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 접기/펼치기 -->
                    <div class="fold_area active">
                        <div class="target">
                            <button class="title" onclick="foldToggle(this)">
                                <span>주문 상품 5건 리스트 보기</span>
                                <img class="arrow" src="/pc/img/icon/arrow-icon.svg" alt="">
                            </button>
                        </div>
                        <div class="py-7">
                            <div class="prod_info">
                                <div class="img_box">
                                    <img src="/pc/img/prod_thumb3.png" alt="">
                                </div>
                                <div class="info_box">
                                    <div class="order_num noline">개별주문번호 : 00001</div>
                                    <div class="prod_name">엔젤A</div>
                                    <div class="prod_option">
                                        <div class="name">수량</div>
                                        <div>1개</div>
                                    </div>
                                    <div class="prod_option">
                                        <div class="name">단가</div>
                                        <div>100,000,000</div>
                                    </div>
                                    <div class="prod_option">
                                        <div class="name estimate">견적가</div>
                                        <div>100,000,000</div>
                                    </div>
                                    <div class="prod_option">
                                        <div class="name note">비고</div>
                                        <div class="notxt">내용없음</div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="prod_info">
                                <div class="img_box">
                                    <img src="/pc/img/prod_thumb3.png" alt="">
                                </div>
                                <div class="info_box">
                                <div class="order_num noline">개별주문번호 : 00001</div>
                                    <div class="prod_name">엔젤A</div>
                                    <div class="prod_option">
                                        <div class="name">수량</div>
                                        <div>2개</div>
                                    </div>
                                    <div class="prod_option">
                                        <div class="name">가격</div>
                                        <div>50,000</div>
                                    </div>
                                    <div class="prod_option">
                                        <div class="name">가격</div>
                                        <div>업체문의</div>
                                    </div>
                                    <div class="prod_option">
                                        <div class="name estimate">견적가</div>
                                        <div>180,000,0000</div>
                                    </div>
                                    <div class="prod_option">
                                        <div class="name note">비고</div>
                                        <div>현 재고 수량 부족 하여 빠른 주문 요망</div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="prod_info">
                                <div class="img_box">
                                    <img src="/pc/img/prod_thumb3.png" alt="">
                                </div>
                                <div class="info_box">
                                    <div class="prod_name">엔젤A</div>
                                    <div class="dropdown_wrap noline">
                                        <button class="dropdown_btn"><p>옵션(사이즈 및 컬러) 선택</p></button>
                                        <div class="dropdown_list">
                                            <div class="dropdown_item">옵션명 표기1</div>
                                            <div class="dropdown_item">옵션명 표기2</div>
                                            <div class="dropdown_item">옵션명 표기3</div>
                                        </div>
                                    </div>

                                    <div class="noline">
                                        <div class="option_item">
                                            <div class="">
                                                <p class="option_name">옵션명 표기1</p>
                                                <button><img src="/pc/img/icon/x_icon2.svg" alt=""></button>
                                            </div>
                                            <div class="mt-2">
                                                <div class="count_box2">
                                                    <button class="minus" onclick="changeValue(this,'minus')"><svg><use xlink:href="/pc/img/icon-defs.svg#minus"></use></svg></button>
                                                    <input type="text" value="1">
                                                    <button class="plus" onclick="changeValue(this,'plus')"><svg><use xlink:href="/pc/img/icon-defs.svg#plus"></use></svg></button>
                                                </div>
                                                <div class="price">50,000</div>
                                            </div>
                                        </div>
                                        <div class="option_item">
                                            <div class="">
                                                <p class="option_name">옵션명 표기1</p>
                                                <button><img src="/pc/img/icon/x_icon2.svg" alt=""></button>
                                            </div>
                                            <div class="mt-2">
                                                <div class="count_box2">
                                                    <button class="minus" onclick="changeValue(this,'minus')"><svg><use xlink:href="/pc/img/icon-defs.svg#minus"></use></svg></button>
                                                    <input type="text" value="1">
                                                    <button class="plus" onclick="changeValue(this,'plus')"><svg><use xlink:href="/pc/img/icon-defs.svg#plus"></use></svg></button>
                                                </div>
                                                <div class="price">50,000</div>
                                            </div>
                                        </div>
                                        <div class="option_item">
                                            <div class="">
                                                <p class="option_name">옵션명 표기1</p>
                                                <button><img src="/pc/img/icon/x_icon2.svg" alt=""></button>
                                            </div>
                                            <div class="mt-2">
                                                <div class="count_box2">
                                                    <button class="minus" onclick="changeValue(this,'minus')"><svg><use xlink:href="/pc/img/icon-defs.svg#minus"></use></svg></button>
                                                    <input type="text" value="1">
                                                    <button class="plus" onclick="changeValue(this,'plus')"><svg><use xlink:href="/pc/img/icon-defs.svg#plus"></use></svg></button>
                                                </div>
                                                <div class="price">50,000</div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="prod_option">
                                        <div class="name">가격</div>
                                        <div class="total_price">150,000</div>
                                    </div>
                                    <div class="prod_option">
                                        <div class="name estimate">견적가</div>
                                        <div>100,000,000</div>
                                    </div>
                                    <div class="prod_option">
                                        <div class="name note">비고</div>
                                        <div class="notxt">내용없음</div>
                                    </div>

                                </div>
                            </div>
                            <hr>

                        </div>
                    </div>
 
                </div>
            </div>
		</div>

        <div class="modal_footer">
            <button type="button" onclick="modalClose('#order_form-modal')">닫기</button>
        </div>
	</div>
</div>
