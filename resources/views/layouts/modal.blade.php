<!-- 모달 들어가는곳 : S -->      

<div class="modal" id="agree01-modal">
	<div class="modal_bg" onclick="modalClose('#agree01-modal')"></div>
	<div class="modal_inner">
		<button class="close_btn" onclick="modalClose('#agree01-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
		<div class="modal_body agree_modal_body">
            <h3>이용 약관</h3>
            <div style="margin-top:20px;">
			    <iframe src="https://api.all-furn.com/res/agreement/agreement.html"></iframe>
            </div>
		</div>
	</div>
</div>

<div class="modal" id="agree02-modal">
	<div class="modal_bg" onclick="modalClose('#agree02-modal')"></div>
	<div class="modal_inner">
		<button class="close_btn" onclick="modalClose('#agree02-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
		<div class="modal_body agree_modal_body">
			<h3>개인정보 활용 동의</h3>
			<div style="margin-top:20px;">
				<iframe src="https://api.all-furn.com/res/agreement/agreement.html"></iframe>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="agree03-modal">
	<div class="modal_bg" onclick="modalClose('#agree03-modal')"></div>
	<div class="modal_inner">
		<button class="close_btn" onclick="modalClose('#agree03-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
		<div class="modal_body agree_modal_body">
			<iframe src="https://api.all-furn.com/res/agreement/marketing.html"></iframe>
		</div>
	</div>
</div>

<div class="modal" id="agree04-modal">
	<div class="modal_bg" onclick="modalClose('#agree04-modal')"></div>
	<div class="modal_inner">
		<button class="close_btn" onclick="modalClose('#agree04-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
		<div class="modal_body agree_modal_body">
			<h3>광고성 이용 동의</h3>
			<div class="scroll_box">
				
			</div>
		</div>
	</div>
</div>


<!-- 검색모달 -->
{{--
<div class="modal" id="search-modal">
    <div class="modal_bg" onclick="modalClose('#search-modal')"></div>
    <div class="modal_inner modal-md search_wrap">
        <button class="close_btn" onclick="modalClose('#search-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>

        <div class="search_intro">
            <div class="title">
                <p>어떤상품이 보고 싶은지 알려주세요!</p>
            </div>
            <ul class="search_btn_list">
                <li data-next="search_popular"><button><b>인기 상품</b> 모아보기</button></li>
                <li data-next="search_new" ><button><b>신상품</b> 모아보기</button></li>
                <li data-next="search_sale"><button><b>할인/행사 상품</b> 모아보기</button></li>
                <li data-next="search_company"><button><b>인기 도매 업체 상품</b> 모아보기</button></li>
                <li data-next="search_popcategory"><button><b>인기 카테고리</b>로 상품 찾기</button></li>
                <li data-next="search_category"><button><b>카테고리</b>로 자세히 상품 찾기</button></li>
            </ul>
            <button class="btn btn-primary w-full next_btn">다음</button>
        </div>

        <!-- 인기상품 -->
        <div class="search_popular hidden">
            <div class="title">
                <p><span>인기상품</span> 중에서 <br/>어떤 품목을 보여드릴까요?</p>
            </div>
            <ul class="search_btn_list type02">
                <li class="all_btn"><button>인기 상품 모아보기</button></li>
                <li><button>전체</button></li>
                <li><button>소파 / 거실 가구</button></li>
                <li><button>식탁 / 주방  가구</button></li>
                <li><button>옷장 / 드레스룸</button></li>
                <li><button>책상 / 서재 가구</button></li>
                <li><button>유아동 가구</button></li>
                <li><button>맞춤 가구</button></li>
                <li><button>사무 / 업소용 가구</button></li>
            </ul>
            <button class="btn btn-primary w-full ">확인</button>
        </div>

        <!-- 신상품 -->
        <div class="search_new hidden">
            <div class="title">
                <p><span>신상품</span> 중에서 <br/>어떤 품목을 보여드릴까요?</p>
            </div>
            <ul class="search_btn_list type02">
                <li class="all_btn"><button>신상품 모아보기</button></li>
                <li><button>전체</button></li>
                <li><button>소파 / 거실 가구</button></li>
                <li><button>식탁 / 주방  가구</button></li>
                <li><button>옷장 / 드레스룸</button></li>
                <li><button>책상 / 서재 가구</button></li>
                <li><button>유아동 가구</button></li>
                <li><button>맞춤 가구</button></li>
                <li><button>사무 / 업소용 가구</button></li>
            </ul>
            <button class="btn btn-primary w-full ">확인</button>
        </div>

        <!-- 할인/행사 상품 -->
        <div class="search_sale hidden">
            <div class="title">
                <p><span>할인/행사 상품</span> 중에서 <br/>어떤 품목을 보여드릴까요?</p>
            </div>
            <ul class="search_btn_list type02">
                <li class="all_btn"><button>할인/행사 상품 모아보기</button></li>
                <li><button>전체</button></li>
                <li><button>소파 / 거실 가구</button></li>
                <li><button>식탁 / 주방  가구</button></li>
                <li><button>옷장 / 드레스룸</button></li>
                <li><button>책상 / 서재 가구</button></li>
                <li><button>유아동 가구</button></li>
                <li><button>맞춤 가구</button></li>
                <li><button>사무 / 업소용 가구</button></li>
            </ul>
            <button class="btn btn-primary w-full ">확인</button>
        </div>

        <!-- 인기 도매업체 -->
        <div class="search_company hidden">
            <div class="title_type">
                <p>인기 도매 업체</p>
                <span>2023년 9월 30일 기준</span>
            </div>
            <ul class="search_list">
                <li><a href="javascript:;">
                    <i>1</i>
                    <p>에이스 침대</p>
                    <div class="tag">
                        <span>침대</span>
                        <span>매트리스</span>
                    </div>
                </a></li>
                <li><a href="javascript:;">
                    <i>2</i>
                    <p>까마시아</p>
                    <div class="tag">
                        <span>침대</span>
                        <span>매트리스</span>
                    </div>
                </a></li>
                <li><a href="javascript:;">
                    <i>3</i>
                    <p>올펀 가구</p>
                    <div class="tag">
                        <span>침대</span>
                        <span>매트리스</span>
                    </div>
                </a></li>
                <li><a href="javascript:;">
                    <i>4</i>
                    <p>아스테리아</p>
                    <div class="tag">
                        <span>침대</span>
                        <span>매트리스</span>
                    </div>
                </a></li>
                <li><a href="javascript:;">
                    <i>5</i>
                    <p>템퍼 침대</p>
                    <div class="tag">
                        <span>침대</span>
                        <span>매트리스</span>
                    </div>
                </a></li>
                <li><a href="javascript:;">
                    <i>6</i>
                    <p>템퍼 침대</p>
                    <div class="tag">
                        <span>침대</span>
                        <span>매트리스</span>
                    </div>
                </a></li>
                <li><a href="javascript:;">
                    <i>7</i>
                    <p>템퍼 침대</p>
                    <div class="tag">
                        <span>침대</span>
                        <span>매트리스</span>
                    </div>
                </a></li>
                <li><a href="javascript:;">
                    <i>8</i>
                    <p>템퍼 침대</p>
                    <div class="tag">
                        <span>침대</span>
                        <span>매트리스</span>
                    </div>
                </a></li>
                <li><a href="javascript:;">
                    <i>9</i>
                    <p>템퍼 침대</p>
                    <div class="tag">
                        <span>침대</span>
                        <span>매트리스</span>
                    </div>
                </a></li>
                <li><a href="javascript:;">
                    <i>10</i>
                    <p>템퍼 침대</p>
                    <div class="tag">
                        <span>침대</span>
                        <span>매트리스</span>
                    </div>
                </a></li>

            </ul>
        </div>

         <!-- 인기 카테고리 -->
         <div class="search_popcategory hidden">
            <div class="title_type">
                <p>인기 카테고리</p>
                <span>2023년 9월 30일 기준</span>
            </div>
            <ul class="search_list">
                <li><a href="javascript:;">
                    <i>1</i>
                    <p><b>침대/매트리스 ></b> 폼매트리스</p>
                </a></li>
                <li><a href="javascript:;">
                    <i>2</i>
                    <p><b>소파/거실 ></b> 1인용 소파</p>
                </a></li>
                <li><a href="javascript:;">
                    <i>3</i>
                    <p><b>식탁/의자 ></b> 세라믹 식탁</p>
                </a></li>
                <li><a href="javascript:;">
                    <i>4</i>
                    <p><b>침대/매트리스 ></b> 스프링매트리스</p>
                </a></li>
                <li><a href="javascript:;">
                    <i>5</i>
                    <p><b>침대/매트리스 ></b> 스프링매트리스</p>
                </a></li>
            </ul>
        </div>

        <!-- 카테고리 -->
        <div class="search_category hidden">
            <div class="title">
                <p><span>카테고리</span> 중에서 <br/>어떤 품목을 보여드릴까요?</p>
            </div>
            <ul class="search_btn_list type02">
                <li class="all_btn"><button>카테고리</button></li>
                <li><button>전체</button></li>
                <li><button>소파 / 거실</button></li>
                <li><button>식탁 / 의자</button></li>
                <li><button>수납 / 서랍장 / 옷장</button></li>
                <li><button>서재 / 공부방</button></li>
                <li><button>화장대 / 거울 / 콘솔</button></li>
                <li><button>키즈 / 주니어</button></li>
                <li><button>진열장 / 장식장</button></li>
                <li><button>안락의자 / 기능성의자</button></li>
                <li><button>테이블/의자</button></li>
                <li><button>사무용가구</button></li>
                <li><button>조달가구</button></li>
                <li><button>업소용가구</button></li>
                <li><button>아웃도어가구</button></li>
                <li><button>아웃도어가구</button></li>
                <li><button>기타 카테고리</button></li>
            </ul>
            <button class="btn btn-primary w-full ">확인</button>
        </div>
    </div>
</div>
--}}
<!-- 동영상모달 -->
<div class="modal" id="video-modal">
	<div class="modal_bg" onclick="modalClose('#video-modal')"></div>
	<div class="modal_inner modal-auto video_wrap">
		<button class="close_btn" onclick="modalClose('#video-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
		<div class="modal_body">
		<iframe width="1244" height="700" src="https://www.youtube.com/embed/IJT51et7owQ" title="2 시간 지브리 음악 🌍 치유, 공부, 일, 수면을위한 편안한 배경 음악 지브리 스튜디오" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
		</div>
	</div>
</div>

<!-- 필터 : 카테고리 -->
<div class="modal" id="filter_category-modal">
    <div class="modal_bg" onclick="modalClose('#filter_category-modal')"></div>
    <div class="modal_inner modal-md">
        <button class="close_btn" onclick="modalClose('#filter_category-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body filter_body">
            <h4>카테고리 선택</h4>
            <ul class="filter_list">
                @if(isset($data) && isset($data['category']) && is_array($data['category']))
                    @foreach($data['category'] as $category)
                        <li>
                            <input type="checkbox" class="check-form" id="{{$category->idx}}">
                            <label for="{{$category->idx}}">{{$category->name}}</label>
                        </li>
                    @endforeach
                @elseif(isset($categoryList) != '')
                    @foreach ($categoryList as $category)
                        <li>
                            <input type="checkbox" class="check-form" id="{{$category->idx}}">
                            <label for="{{$category->idx}}">{{$category->name}}</label>
                        </li>
                    @endforeach
                @endif
            </ul>
            <div class="btn_bot">
                <button class="btn btn-line3 refresh_btn" onclick="refreshHandle(this)"><svg><use xlink:href="/img/icon-defs.svg#refresh"></use></svg>초기화</button>
                <button class="btn btn-primary">상품 찾아보기</button>
            </div>
        </div>
    </div>
</div>

<!-- 필터 : 소재지 -->
<div class="modal" id="filter_location-modal">
    <div class="modal_bg" onclick="modalClose('#filter_location-modal')"></div>
    <div class="modal_inner modal-md">
        <button class="close_btn" onclick="modalClose('#filter_location-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body filter_body">
            <h4>소재지 선택</h4>
            <ul class="filter_list">
                @foreach(config('constants.REGIONS.KR') as $key => $location)
                    <li>
                        <input type="checkbox" class="check-form" id="category__check-2-{{$key + 1}}" data-location="{{$location}}" >
                        <label for="category__check-2-{{$key + 1}}">{{$location}}</label>
                    </li>
                @endforeach
            </ul>
            <div class="btn_bot">
                <button class="btn btn-line3 refresh_btn" onclick="refreshHandle(this)"><svg><use xlink:href="/img/icon-defs.svg#refresh"></use></svg>초기화</button>
                <button class="btn btn-primary">업체 찾아보기</button>
            </div>
        </div>
    </div>
</div>

<!-- 필터 : 정렬선택 -->
<div class="modal" id="filter_align-modal">
    <div class="modal_bg" onclick="modalClose('#filter_align-modal')"></div>
    <div class="modal_inner modal-md">
        <button class="close_btn" onclick="modalClose('#filter_align-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body filter_body">
            <h4>정렬 선택</h4>
            <ul class="filter_list">
                <li>
                    <input type="radio" class="radio-form" name="filter_cate" id="filter_register_time" value="register_time" checked>
                    <label for="filter_register_time">최신 상품 등록순</label>
                </li>
                <li>
                    <input type="radio" class="radio-form" name="filter_cate" id="filter_interest_count" value="recommendation" >
                    <label for="filter_interest_count">추천순</label>
                </li>
                <li>
                    <input type="radio" class="radio-form" name="filter_cate" id="filter_access_count" value="companyAccessCount">
                    <label for="filter_access_count">검색 많은 순</label>
                </li>
                <li>
                    <input type="radio" class="radio-form" name="filter_cate" id="filter_order_count" value="orderCnt">
                    <label for="filter_order_count">거래 많은 순</label>
                </li>
                <li>
                    <input type="radio" class="radio-form" name="filter_cate" id="filter_product_count" value="productCnt">
                    <label for="filter_product_count">상품 많은 순</label>
                </li>
                <li>
                    <input type="radio" class="radio-form" name="filter_cate" id="filter_product_name" value="word">
                    <label for="filter_product_name">가나다 순</label>
                </li>
            </ul>
            <div class="btn_bot">
                <button class="btn btn-primary full">선택 완료</button>
            </div>
        </div>
    </div>
</div>

<!-- 필터 : 정렬선택02 -->
<div class="modal" id="filter_align-modal02">
    <div class="modal_bg" onclick="modalClose('#filter_align-modal02')"></div>
    <div class="modal_inner modal-md">
        <button class="close_btn" onclick="modalClose('#filter_align-modal02')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body filter_body">
            <h4>정렬 선택</h4>
            <ul class="filter_list">
                <li>
                    <input type="radio" class="radio-form" name="filter_cate_2" id="filter_reg_time" value="reg_time" checked>
                    <label for="filter_reg_time">최신 상품 등록순</label>
                </li>
                <li>
                    <input type="radio" class="radio-form" name="filter_cate_2" id="filter_search" value="search">
                    <label for="filter_search">검색 많은 순</label>
                </li>
                <li>
                    <input type="radio" class="radio-form" name="filter_cate_2" id="filter_order" value="order">
                    <label for="filter_order">주문 많은 순</label>
                </li>
            </ul>
            <div class="btn_bot">
                <button class="btn btn-primary full">선택 완료</button>
            </div>
        </div>
    </div>
</div>

<!-- 필터 : 정렬선택 -->
<div class="modal" id="filter_align-modal03">
    <div class="modal_bg" onclick="modalClose('#filter_align-modal03')"></div>
    <div class="modal_inner modal-md">
        <button class="close_btn" onclick="modalClose('#filter_align-modal03')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body filter_body">
            <h4>정렬 선택</h4>
            <ul class="filter_list">
                <li>
                    <input type="radio" class="radio-form" name="filter_cate_3" id="filter03_register_time" value="register_time" checked>
                    <label for="filter03_register_time">최신순</label>
                </li><li>
                    <input type="radio" class="radio-form" name="filter_cate_3" id="filter03_access_count" value="access_count">
                    <label for="filter03_access_count">조회순</label>
                </li><li>
                    <input type="radio" class="radio-form" name="filter_cate_3" id="filter03_popularity" value="popularity">
                    <label for="filter03_popularity">인기순</label>
                </li><li>
                    <input type="radio" class="radio-form" name="filter_cate_3" id="filter03_custom_orders" value="custom_orders" @if( isset( $data ) && isset( $data['use_custom_orders'] ) && $data['use_custom_orders'][0]->used == 1) checked @endif>
                    <label for="filter03_custom_orders">업체 추천순</label>
                </li>
            </ul>
            <div class="btn_bot">
                <button class="btn btn-primary full">선택 완료</button>
            </div>
        </div>
    </div>
</div>

<!-- 검색모달 -->
{{--
<div class="modal" id="search-modal">
    <div class="modal_bg" onclick="modalClose('#search-modal')"></div>
    <div class="modal_inner modal-md search_wrap">
        <button class="close_btn" onclick="modalClose('#search-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
        
        <div class="search_intro">
            <div class="title">
                <p>어떤상품이 보고 싶은지 알려주세요!</p>
            </div>
            <ul class="search_btn_list">
                <li data-next="search_popular"><button><b>인기 상품</b> 모아보기</button></li>
                <li data-next="search_new"><button><b>신상품</b> 모아보기</button></li>
                <li data-next="search_sale"><button><b>할인/행사 상품</b> 모아보기</button></li>
                <li data-next="search_company"><button><b>인기 도매 업체 상품</b> 모아보기</button></li>
                <li data-next="search_popcategory"><button><b>인기 카테고리</b>로 상품 찾기</button></li>
                <li data-next="search_category"><button><b>카테고리</b>로 자세히 상품 찾기</button></li>
            </ul>
            <button class="btn btn-primary w-full next_btn">다음</button>
        </div>

        <!-- 인기상품 -->
        <div class="search_popular hidden">
            <div class="title">
                <p><span>인기상품</span> 중에서 <br/>어떤 품목을 보여드릴까요?</p>
            </div>
            <ul class="search_btn_list type02">
                <li class="all_btn"><button>인기 상품 모아보기</button></li>
                <li><button>전체</button></li>
                <li><button>소파 / 거실 가구</button></li>
                <li><button>식탁 / 주방  가구</button></li>
                <li><button>옷장 / 드레스룸</button></li>
                <li><button>책상 / 서재 가구</button></li>
                <li><button>유아동 가구</button></li>
                <li><button>맞춤 가구</button></li>
                <li><button>사무 / 업소용 가구</button></li>
            </ul>
            <button class="btn btn-primary w-full ">확인</button>
        </div>

        <!-- 신상품 -->
        <div class="search_new hidden">
            <div class="title">
                <p><span>신상품</span> 중에서 <br/>어떤 품목을 보여드릴까요?</p>
            </div>
            <ul class="search_btn_list type02">
                <li class="all_btn"><button>신상품 모아보기</button></li>
                <li><button>전체</button></li>
                <li><button>소파 / 거실 가구</button></li>
                <li><button>식탁 / 주방  가구</button></li>
                <li><button>옷장 / 드레스룸</button></li>
                <li><button>책상 / 서재 가구</button></li>
                <li><button>유아동 가구</button></li>
                <li><button>맞춤 가구</button></li>
                <li><button>사무 / 업소용 가구</button></li>
            </ul>
            <button class="btn btn-primary w-full ">확인</button>
        </div>

        <!-- 할인/행사 상품 -->
        <div class="search_sale hidden">
            <div class="title">
                <p><span>할인/행사 상품</span> 중에서 <br/>어떤 품목을 보여드릴까요?</p>
            </div>
            <ul class="search_btn_list type02">
                <li class="all_btn"><button>할인/행사 상품 모아보기</button></li>
                <li><button>전체</button></li>
                <li><button>소파 / 거실 가구</button></li>
                <li><button>식탁 / 주방  가구</button></li>
                <li><button>옷장 / 드레스룸</button></li>
                <li><button>책상 / 서재 가구</button></li>
                <li><button>유아동 가구</button></li>
                <li><button>맞춤 가구</button></li>
                <li><button>사무 / 업소용 가구</button></li>
            </ul>
            <button class="btn btn-primary w-full ">확인</button>
        </div>

        <!-- 인기 도매업체 -->
        <div class="search_company hidden">
            <div class="title_type"> 
                <p>인기 도매 업체</p>
                <span>2023년 9월 30일 기준</span>
            </div>
            <ul class="search_list">
                <li><a href="javascript:;">
                    <i>1</i>
                    <p>에이스 침대</p>
                    <div class="tag">
                        <span>침대</span>
                        <span>매트리스</span>
                    </div>
                </a></li>
                <li><a href="javascript:;">
                    <i>2</i>
                    <p>까마시아</p>
                    <div class="tag">
                        <span>침대</span>
                        <span>매트리스</span>
                    </div>
                </a></li>
                <li><a href="javascript:;">
                    <i>3</i>
                    <p>올펀 가구</p>
                    <div class="tag">
                        <span>침대</span>
                        <span>매트리스</span>
                    </div>
                </a></li>
                <li><a href="javascript:;">
                    <i>4</i>
                    <p>아스테리아</p>
                    <div class="tag">
                        <span>침대</span>
                        <span>매트리스</span>
                    </div>
                </a></li>
                <li><a href="javascript:;">
                    <i>5</i>
                    <p>템퍼 침대</p>
                    <div class="tag">
                        <span>침대</span>
                        <span>매트리스</span>
                    </div>
                </a></li>
                <li><a href="javascript:;">
                    <i>6</i>
                    <p>템퍼 침대</p>
                    <div class="tag">
                        <span>침대</span>
                        <span>매트리스</span>
                    </div>
                </a></li>
                <li><a href="javascript:;">
                    <i>7</i>
                    <p>템퍼 침대</p>
                    <div class="tag">
                        <span>침대</span>
                        <span>매트리스</span>
                    </div>
                </a></li>
                <li><a href="javascript:;">
                    <i>8</i>
                    <p>템퍼 침대</p>
                    <div class="tag">
                        <span>침대</span>
                        <span>매트리스</span>
                    </div>
                </a></li>
                <li><a href="javascript:;">
                    <i>9</i>
                    <p>템퍼 침대</p>
                    <div class="tag">
                        <span>침대</span>
                        <span>매트리스</span>
                    </div>
                </a></li>
                <li><a href="javascript:;">
                    <i>10</i>
                    <p>템퍼 침대</p>
                    <div class="tag">
                        <span>침대</span>
                        <span>매트리스</span>
                    </div>
                </a></li>
                
            </ul>
        </div>

         <!-- 인기 카테고리 -->
         <div class="search_popcategory hidden">
            <div class="title_type"> 
                <p>인기 카테고리</p>
                <span>2023년 9월 30일 기준</span>
            </div>
            <ul class="search_list">
                <li><a href="javascript:;">
                    <i>1</i>
                    <p><b>침대/매트리스 ></b> 폼매트리스</p>
                </a></li>
                <li><a href="javascript:;">
                    <i>2</i>
                    <p><b>소파/거실 ></b> 1인용 소파</p>
                </a></li>
                <li><a href="javascript:;">
                    <i>3</i>
                    <p><b>식탁/의자 ></b> 세라믹 식탁</p>
                </a></li>
                <li><a href="javascript:;">
                    <i>4</i>
                    <p><b>침대/매트리스 ></b> 스프링매트리스</p>
                </a></li>
                <li><a href="javascript:;">
                    <i>5</i>
                    <p><b>침대/매트리스 ></b> 스프링매트리스</p>
                </a></li>
            </ul>
        </div>

        <!-- 카테고리 -->
        <div class="search_category hidden">
            <div class="title">
                <p><span>카테고리</span> 중에서 <br/>어떤 품목을 보여드릴까요?</p>
            </div>
            <ul class="search_btn_list type02">
                <li class="all_btn"><button>카테고리</button></li>
                <li><button>전체</button></li>
                <li><button>소파 / 거실</button></li>
                <li><button>식탁 / 의자</button></li>
                <li><button>수납 / 서랍장 / 옷장</button></li>
                <li><button>서재 / 공부방</button></li>
                <li><button>화장대 / 거울 / 콘솔</button></li>
                <li><button>키즈 / 주니어</button></li>
                <li><button>진열장 / 장식장</button></li>
                <li><button>안락의자 / 기능성의자</button></li>
                <li><button>테이블/의자</button></li>
                <li><button>사무용가구</button></li>
                <li><button>조달가구</button></li>
                <li><button>업소용가구</button></li>
                <li><button>아웃도어가구</button></li>
                <li><button>아웃도어가구</button></li>
                <li><button>기타 카테고리</button></li>
            </ul>
            <button class="btn btn-primary w-full ">확인</button>
        </div>
    </div>
</div>
--}}

<!-- 검색모달 -->
<div class="modal" id="search-modal">
    <div class="modal_bg" onclick="modalClose('#search-modal')"></div>
    <div class="modal_inner modal-md search_wrap">
        <button class="close_btn" onclick="modalClose('#search-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>

        <div class="search_intro">
            <div class="title">
                <p>어떤상품이 보고 싶은지 알려주세요!</p>
            </div>
            <!-- <div class="find_product">
                <div class="flex flex-col gap-2 px-20">
                    <button class="h-[51px] border border-stone-300 rounded-sm w-full"><b>인기상품</b> 모아보기</button>
                    <button class="search_new_step h-[51px] border border-stone-300 rounded-sm w-full"><b>신상품</b> 모아보기</button>
                    <button class="search_sale_step h-[51px] border border-stone-300 rounded-sm w-full"><b>할인/행사 상품</b> 모아보기</button>
                    <button class="search_sale_step h-[51px] border border-stone-300 rounded-sm w-full"><b>인기 도매 업체 상품</b> 모아보기</button>
                    <button class="search_company_step h-[51px] border border-stone-300 rounded-sm w-full"><b>인기 카테고리</b>로 상품 찾기</button>
                    <button class="h-[51px] border border-stone-300 rounded-sm w-full"><b>카테고리</b>로 자세히 상품 찾기</button>
                </div>
            </div> -->
            <ul class="search_btn_list">
                <li data-url="/product/popularList"><button><b>인기상품</b> 모아보기</button></li>
                <li data-url="/product/best-new"><button><b>신상품</b> 모아보기</button></li>
                <li data-url="/product/planDiscountDetail"><button><b>할인/행사 상품</b> 모아보기</button></li>
                <li data-url="/wholesaler/thismonth"><button><b>인기 도매 업체 상품</b> 모아보기</button></li>
                <li data-next="search_popcategory"><button><b>인기 카테고리</b>로 상품 찾기</button></li>
                <li data-next="search_category"><button><b>카테고리</b>로 자세히 상품 찾기</button></li>
            </ul>
            <button class="btn btn-primary w-full next_btn">다음</button>

        </div>

        <!-- 인기상품 -->
        <div class="search_popular sch_cate_info hidden">
            <div class="title">
                <p><span>인기상품</span> 중에서 <br/>어떤 품목을 보여드릴까요?</p>
            </div>
            <ul class="search_btn_list type02">
                <li class="all_btn"><button>인기 상품 모아보기</button></li>
                <li data-pre=""><button>전체</button></li>
                <li data-pre="1"><button>소파 / 거실 가구</button></li>
                <li data-pre="3"><button>식탁 / 주방  가구</button></li>
                <li data-pre="4"><button>옷장 / 드레스룸</button></li>
                <li data-pre="5"><button>책상 / 서재 가구</button></li>
                <li data-pre="7"><button>유아동 가구</button></li>
                <li data-pre=""><button>맞춤 가구</button></li>
                <li data-pre=""><button>사무 / 업소용 가구</button></li>
            </ul>
            <a href="javascript:void(0);" class="btn btn-primary w-full">확인</a>
        </div>

        <!-- 신상품 -->
        <div class="search_new sch_cate_info hidden">
            <div class="title">
                <p><span>신상품</span> 중에서 <br/>어떤 품목을 보여드릴까요?</p>
            </div>
            <ul class="search_btn_list type02">
                <li class="all_btn"><button>신상품 모아보기</button></li>
                <li><button>전체</button></li>
                <li><button>소파 / 거실 가구</button></li>
                <li><button>식탁 / 주방  가구</button></li>
                <li><button>옷장 / 드레스룸</button></li>
                <li><button>책상 / 서재 가구</button></li>
                <li><button>유아동 가구</button></li>
                <li><button>맞춤 가구</button></li>
                <li><button>사무 / 업소용 가구</button></li>
            </ul>
            <button class="btn btn-primary w-full ">확인</button>
        </div>

        <!-- 할인/행사 상품 -->
        <div class="search_sale sch_cate_info hidden">
            <div class="title">
                <p><span>할인/행사 상품</span> 중에서 <br/>어떤 품목을 보여드릴까요?</p>
            </div>
            <ul class="search_btn_list type02">
                <li class="all_btn"><button>할인/행사 상품 모아보기</button></li>
                <li><button>전체</button></li>
                <li><button>소파 / 거실 가구</button></li>
                <li><button>식탁 / 주방 가구</button></li>
                <li><button>옷장 / 드레스룸</button></li>
                <li><button>책상 / 서재 가구</button></li>
                <li><button>유아동 가구</button></li>
                <li><button>맞춤 가구</button></li>
                <li><button>사무 / 업소용 가구</button></li>
            </ul>
            <button class="btn btn-primary w-full ">확인</button>
        </div>

        <!-- 인기 도매업체 -->
        <div class="search_company sch_cate_info hidden">
            <div class="title_type">
                <p>인기 도매 업체</p>
                <span>2023년 9월 30일 기준</span>
            </div>
            <ul class="search_list">
                <li><a href="javascript:;">
                        <i>1</i>
                        <p>에이스 침대</p>
                        <div class="tag">
                            <span>침대</span>
                            <span>매트리스</span>
                        </div>
                    </a></li>
                <li><a href="javascript:;">
                        <i>2</i>
                        <p>까마시아</p>
                        <div class="tag">
                            <span>침대</span>
                            <span>매트리스</span>
                        </div>
                    </a></li>
                <li><a href="javascript:;">
                        <i>3</i>
                        <p>올펀 가구</p>
                        <div class="tag">
                            <span>침대</span>
                            <span>매트리스</span>
                        </div>
                    </a></li>
                <li><a href="javascript:;">
                        <i>4</i>
                        <p>아스테리아</p>
                        <div class="tag">
                            <span>침대</span>
                            <span>매트리스</span>
                        </div>
                    </a></li>
                <li><a href="javascript:;">
                        <i>5</i>
                        <p>템퍼 침대</p>
                        <div class="tag">
                            <span>침대</span>
                            <span>매트리스</span>
                        </div>
                    </a></li>
                <li><a href="javascript:;">
                        <i>6</i>
                        <p>템퍼 침대</p>
                        <div class="tag">
                            <span>침대</span>
                            <span>매트리스</span>
                        </div>
                    </a></li>
                <li><a href="javascript:;">
                        <i>7</i>
                        <p>템퍼 침대</p>
                        <div class="tag">
                            <span>침대</span>
                            <span>매트리스</span>
                        </div>
                    </a></li>
                <li><a href="javascript:;">
                        <i>8</i>
                        <p>템퍼 침대</p>
                        <div class="tag">
                            <span>침대</span>
                            <span>매트리스</span>
                        </div>
                    </a></li>
                <li><a href="javascript:;">
                        <i>9</i>
                        <p>템퍼 침대</p>
                        <div class="tag">
                            <span>침대</span>
                            <span>매트리스</span>
                        </div>
                    </a></li>
                <li><a href="javascript:;">
                        <i>10</i>
                        <p>템퍼 침대</p>
                        <div class="tag">
                            <span>침대</span>
                            <span>매트리스</span>
                        </div>
                    </a></li>

            </ul>
        </div>

        <!-- 인기 카테고리 -->
        <div class="search_popcategory sch_cate_info hidden">
            <div class="title_type">
                <p>인기 카테고리</p>
                <span>{{date('Y년 m월 d일')}} 기준</span>
            </div>
            @if( isset( $schData ) && count( $schData ) > 0 )
                <ul class="search_list_recent">
                    @foreach( $schData as $i => $cate )
                        <li><a href="/product/category?ca={{$cate->categoryIdx}}&pre={{$cate->parentIdx}}">
                            <i>{{ $i+1 }}</i>
                            <p><b>{{ $cate->parentName }}</b> &gt; {{ $cate->categoryName }}<p>
                        </a></li>
                        {{-- <li>
                            @if( $cate->parentName ) 
                                <a href="/home/searchResult?ca={{$cate->categoryIdx}}&pre={{$cate->parentIdx}}"><i>1</i><p><b>{{ $cate->categoryName }}</b><p></a>
                            @else 
                                <a href="/home/searchResult?ca={{$cate->categoryIdx}}&pre={{$cate->parentIdx}}"><i>2</i><p><b>{{ $cate->parentName }}</b>{{ $cate->categoryName }}<p></a>
                            @endif 
                        </li> --}}
                    @endforeach
                </ul>
            @endif
        </div>

        <!-- 카테고리 -->
        <div class="search_category sch_cate_info hidden">
            <div class="title">
                <p><span>카테고리</span> 중에서 <br/>어떤 품목을 보여드릴까요?</p>
            </div>
            @if(isset($categoryList) && count( $categoryList ) > 0 )
            <ul class="search_btn_list type02">
                {{-- <li class="all_btn" data-pre=""><button>카테고리</button></li> --}}
                {{-- <li data-pre=""><button>전체</button></li> --}}
                @foreach( $categoryList AS $category )
                <li data-pre="{{$category->idx}}"><button>{{$category->name}}</button></li>
                @endforeach
            </ul>
            <button class="btn btn-primary w-full ">확인</button>
            @endif
        </div>
    </div>
</div>

<!-- 포인트 내역 추가 모달-->
@if( !empty( $point ) )
<div class="modal" id="points_details">
    <div class="modal_bg" onclick="modalClose('#points_details')"></div>
    <div class="modal_inner modal-md" style="width:480px;">
        <div class="modal_body filter_body">
            <div class="py-2">
                <p class="text-lg font-bold text-left">포인트 내역</p>
                <div class="py-5">
                    <table class="my_table table-auto w-full">
                        <thead>
                        <tr>
                            <th>형태</th>
                            <th>내용</th>
                            <th>포인트</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">
                        @foreach( $point AS $p )
                        @if( $p->type == 'A' )
                        <tr>
                            <td>적립</td>
                            <td>{{$p->reason}}</td>
                            <td class="text-blue-500 font-medium">+{{number_format( $p->score )}}</td>
                        </tr>
                        @else
                        <tr>
                            <td>감소</td>
                            <td>{{$p->reason}}</td>
                            <td class="text-primary font-medium">-{{number_format( $p->score )}}</td>
                        </tr>
                        @endif
                        @endforeach
                        </tbody>
                    </table>

                    <div class="bg-stone-800 px-3 py-2 font-bold text-white flex items-center justify-between rounded-sm mt-3">
                        <p>총 포인트</p>
                        <p class="text-lg">{{number_format( $tPoint )}}</p>
                    </div>
                </div>
                <div class="flex justify-center mt-4">
                    <button class="btn btn-primary w-full" onclick="modalClose('#points_details')">확인</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endif



<!-- 모달 들어가는곳 : E -->

{{-- <script>
// zoom_prod_list
const zoom_prod_list = new Swiper(".zoom_prod_list", {
    slidesPerView: 1,
    spaceBetween: 120,
    navigation: {
        nextEl: ".zoom_view_wrap .slide_arrow.next",
        prevEl: ".zoom_view_wrap .slide_arrow.prev",
    },
    pagination: {
        el: ".zoom_view_wrap .count_pager",
        type: "fraction",
    },
});
</script> --}}


