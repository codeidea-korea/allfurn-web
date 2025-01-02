
<!-- 받은 견적서  -->
<div class="modal" id="receive_estimate-modal">
	<div class="modal_bg" onclick="modalClose('#receive_estimate-modal')"></div>
	<div class="modal_inner new-modal">
        <div class="modal_header">
            <h3>받은 견적서</h3>
            <button class="close_btn" onclick="modalClose('#receive_estimate-modal')"><img src="./pc/img/icon/x_icon.svg" alt=""></button>
        </div>

		<div class="modal_body">
            <div class="relative">
                <div class="info">구매업체명님의 공급업체명 5건 상품 견적서 입니다.</div>
                <div class="p-7">
                    <!-- 견적 기본정보 -->
                    <div class="fold_area txt_info active">
                        <div class="target title" onclick="foldToggle(this)">
                            <p>공급업체 기본정보</p>
                            <div class="flex items-center gap-2">
                                <span>(주문번호 : 4NZAP8K1AZO5V2TB)</span>
                                <img class="arrow" src="./pc/img/icon/arrow-icon.svg" alt="">
                            </div>
                        </div>
                        <div>
                            <div class="flex gap-2 mt-2">
                                <div class="img_box"><img src="./pc/img/prod_thumb3.png" alt=""></div>
                                <div class="flex-1">
                                    <div class="txt_desc">
                                        <div class="name">업체명</div>
                                        <div>구매업체명표기</div>
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
                                    <div class="txt_desc">
                                        <div class="name">배송</div>
                                        <div>착불(100,000)</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="fold_area txt_info active">
                        <div class="target title" onclick="foldToggle(this)">
                            <p>자동 견적가</p>
                            <img class="arrow" src="./pc/img/icon/arrow-icon.svg" alt="">
                        </div>
                        <div>
                            <div class="txt_desc">
                                <div class="name">가격 표기 상품 5건</div>
                                <div><b>5,000,000,000</b></div>
                            </div>
                        </div>
                    </div>

                    <!-- 기타 답변내용 -->
                    <dl class="add_textarea mb-7">
                        <dt>기타 답변내용</dt>
                        <dd><textarea name="" id="" placeholder="요청자님에게 그 외 내용을 입력 하세요"></textarea></dd>
                    </dl>
 
                </div>
                <div class="relative">
                    <div class="info">
                        <div class="txt_info">
                            <div class="title"><p>납품 예산견적 정보</p></div>
                            <div>
                                <div class="txt_desc">
                                    <div class="name">총 상품 5건</div>
                                    <div><b>5,500,000,000</b></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-7">
                        <!-- 접기/펼치기 -->
                        <div class="fold_area active">
                            <div class="target">
                                <button class="title" onclick="foldToggle(this)">
                                    <span>상품 5건 리스트 보기</span>
                                    <img class="arrow" src="./pc/img/icon/arrow-icon.svg" alt="">
                                </button>
                            </div>
                            <div class="py-7">
                                <div class="prod_info">
                                    <div class="img_box">
                                        <input type="checkbox" id="check_10" class="hidden" checked disabled>
                                        <label for="check_10" class="add_btn">대표</label>
                                        <img src="./pc/img/prod_thumb3.png" alt="">
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
                                        <input type="checkbox" id="check_11" class="hidden" checked>
                                        <label for="check_11" class="add_btn" onclick="prodAdd(this)">취소</label>
                                        <img src="./pc/img/prod_thumb3.png" alt="">
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
                                        <input type="checkbox" id="check_12" class="hidden" checked>
                                        <label for="check_12" class="add_btn" onclick="prodAdd(this)">취소</label>
                                        <img src="./pc/img/prod_thumb3.png" alt="">
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
                                                    <button><img src="./pc/img/icon/x_icon2.svg" alt=""></button>
                                                </div>
                                                <div class="mt-2">
                                                    <div class="count_box2">
                                                        <button class="minus" onclick="changeValue(this,'minus')"><svg><use xlink:href="./pc/img/icon-defs.svg#minus"></use></svg></button>
                                                        <input type="text" value="1">
                                                        <button class="plus" onclick="changeValue(this,'plus')"><svg><use xlink:href="./pc/img/icon-defs.svg#plus"></use></svg></button>
                                                    </div>
                                                    <div class="price">50,000</div>
                                                </div>
                                            </div>
                                            <div class="option_item">
                                                <div class="">
                                                    <p class="option_name">옵션명 표기1</p>
                                                    <button><img src="./pc/img/icon/x_icon2.svg" alt=""></button>
                                                </div>
                                                <div class="mt-2">
                                                    <div class="count_box2">
                                                        <button class="minus" onclick="changeValue(this,'minus')"><svg><use xlink:href="./pc/img/icon-defs.svg#minus"></use></svg></button>
                                                        <input type="text" value="1">
                                                        <button class="plus" onclick="changeValue(this,'plus')"><svg><use xlink:href="./pc/img/icon-defs.svg#plus"></use></svg></button>
                                                    </div>
                                                    <div class="price">50,000</div>
                                                </div>
                                            </div>
                                            <div class="option_item">
                                                <div class="">
                                                    <p class="option_name">옵션명 표기1</p>
                                                    <button><img src="./pc/img/icon/x_icon2.svg" alt=""></button>
                                                </div>
                                                <div class="mt-2">
                                                    <div class="count_box2">
                                                        <button class="minus" onclick="changeValue(this,'minus')"><svg><use xlink:href="./pc/img/icon-defs.svg#minus"></use></svg></button>
                                                        <input type="text" value="1">
                                                        <button class="plus" onclick="changeValue(this,'plus')"><svg><use xlink:href="./pc/img/icon-defs.svg#plus"></use></svg></button>
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
		</div>

        <div class="modal_footer">
            <button type="button" onclick="modalClose('#receive_estimate-modal')">닫기</button>
        </div>
	</div>
</div>
