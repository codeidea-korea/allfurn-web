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
                @if(isset($data) && isset($data['category']) != '' && is_object($data['category']))
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


@if(auth()->check())
    <div class="modal" id="pop_info_1-modal">
        <div class="modal_bg" onclick="modalClose('#pop_info_1-modal')"></div>
        <div class="modal_inner modal-md">
            <button class="close_btn" onclick="modalClose('#pop_info_1-modal')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <p class="text-center py-4"><b>해당 기능은 회원 등업이 필요합니다.<br/> 이용을 원하실 경우, 업체 정보를 입력해 주시기 바랍니다.</b></p>
                <div class="flex gap-2 justify-center">
                    <button class="btn w-full btn-primary-line mt-5" onclick="modalClose('#pop_info_1-modal')">취소</button>
                    <button class="btn w-full btn-primary mt-5" id="pop_info_1-open-modal">확인</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="pop_info_2-modal">
        <div class="modal_bg" onclick="modalClose('#pop_info_2-modal')"></div>
        <div class="modal_inner modal-md">
            <button class="close_btn" onclick="modalClose('#pop_info_2-modal')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <p class="text-center py-4"><b>회원 등업 신청이 완료되었습니다.<br/> 관리자의 승인 후 해당 기능을 이용하실 수 있습니다.</b></p>
                <div class="flex gap-2 justify-center">
                    <button class="btn w-full btn-primary-line mt-5" onclick="modalClose('#pop_info_2-modal')">취소</button>
                    <button class="btn w-full btn-primary mt-5" onclick="modalClose('#pop_info_2-modal')">확인</button>
                </div>
            </div>
        </div>
    </div>


    @if(isset($isMobile)) 
    <div class="modal" id="pop_info_4-modal">
        <div class="modal_bg" onclick="modalClose('#pop_info_4-modal')"></div>
        <div class="modal_inner modal-md">
            <button class="close_btn" onclick="modalClose('#pop_info_4-modal')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body  _convert_company_section">
                <div class="form_box p-5">
                    <input type="hidden" id="pop_info_4-member_type" value="0">
                    <input type="hidden" id="pop_info_4-user_email" value="{{ auth()->user() -> account }}">
                    <input type="hidden" id="pop_info_4-user_name" value="{{ auth()->user() -> name }}">
                    <input type="hidden" id="pop_info_4-user_phone" value="{{ auth()->user() -> phone_number }}">

                    <div class="mb-3">
                        <dl>
                            <dt class="necessary">사업자 등록 번호</dt>
                            <dd class="flex gap-1">
                                <div class="flex-1">
                                    <input type="text" class="input-form w-full  business_code" onkeyup="$(this).parent().find('label').hide();" placeholder="사업자 등록 번호를 입력해주세요.">
                                    <label for="" class="error _focus_business_code" style="display: none;">사업자번호를 정확히 입력해주세요</label>
                                </div>
                                <button class="btn btn-black-line" type="button" onclick="convertCompany.checkCompanyNumber(0);">중복체크</button>
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-3">
                        <dl>
                            <dt class="necessary">업체명</dt>
                            <dd>
                                <input type="text" class="input-form w-full  company_name" onkeyup="$(this).parent().find('label').hide();" placeholder="업체명을 입력해주세요.">
                                <label for="" class="error _focus_company_name" style="display: none;">업체명을 정확히 입력해주세요</label>
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-3">
                        <dl>
                            <dt class="necessary">대표자명</dt>
                            <dd>
                                <input type="text" class="input-form w-full  owner_name" onkeyup="$(this).parent().find('label').hide();" placeholder="대표자를 입력해주세요.">
                                <label for="" class="error _focus_owner_name" style="display: none;">대표자명을 정확히 입력해주세요</label>
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-3">
                        <dl>
                            <dt class="necessary">회사주소</dt>
                            <dd>
                            
                                <div class="add_tab">
                                    <!-- 국내 -->
                                    <div class="flex gap-1">
                                        <input type="text" class="input-form w-full  business_address" onclick="convertCompany.execPostCode()" placeholder="주소를 검색해주세요">
                                        <button class="btn btn-black-line">주소 검색</button>
                                    </div>
                                    <!-- 해외 -->
                                    <div class="dropdown_wrap hidden">
                                        <button class="dropdown_btn">지역</button>
                                        <div class="dropdown_list">
                                            <div class="dropdown_item">아시아</div>
                                            <div class="dropdown_item">아프리카</div>
                                            <div class="dropdown_item">북아메리카</div>
                                            <div class="dropdown_item">남아메리카</div>
                                            <div class="dropdown_item">유럽</div>
                                            <div class="dropdown_item">오세아니아</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 w-full">
                                    <input type="text" class="input-form w-full  business_address_detail" placeholder="상세주소를 검색해주세요">
                                </div>
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-3">
                        <dl>
                            <dt class="necessary  __label_profile_business_attachement">사업자등록증</dt>
                            <dd>
                                <div class="file-form horizontal">
                                    <input type="file" id="pop_info_4-business" onchange="convertCompany.fileUpload(this)">
                                    <label for="pop_info_4-business" class="error  __error_profile_business_attachement">사업자등록증을 첨부해주세요.</label>
                                    <div class="text">
                                        <img class="mx-auto" src="./img/member/img_icon.svg" alt="">
                                        <p class="mt-1">이미지 추가</p>
                                    </div>
                                </div>
                                <div class="info_box mt-2.5">
                                    ・권장 형식: jpg, jpeg, png
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>    

                <div class="flex gap-2 justify-center p-5">
                    <button class="btn w-full btn-primary" type="button" onClick="convertCompany.updateUserInfo();">승인요청</button>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="modal" id="pop_info_4-modal">
        <div class="modal_bg" onclick="modalClose('#pop_info_4-modal')"></div>
        <div class="modal_inner modal-xl">
            <button class="close_btn" onclick="modalClose('#pop_info_4-modal')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body  _convert_company_section">
                <div class="form_box p-10">
                    <input type="hidden" id="pop_info_4-member_type" value="0">
                    <input type="hidden" id="pop_info_4-user_email" value="{{ auth()->user() -> account }}">
                    <input type="hidden" id="pop_info_4-user_name" value="{{ auth()->user() -> name }}">
                    <input type="hidden" id="pop_info_4-user_phone" value="{{ auth()->user() -> phone_number }}">

                    <div class="mb-8">
                        <dl class="flex">
                            <dt class="necessary">사업자 등록 번호</dt>
                            <dd class="flex gap-1">
                                <div class="flex-1">
                                    <input type="text" class="input-form w-full  business_code" onkeyup="$(this).parent().find('label').hide();" placeholder="사업자 등록 번호를 입력해주세요.">
                                    <label for="" class="error _focus_business_code" style="display: none;">사업자번호를 정확히 입력해주세요</label>
                                </div>
                                <button class="btn btn-black-line" type="button" onclick="convertCompany.checkCompanyNumber(0);">중복체크</button>
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-8">
                        <dl class="flex">
                            <dt class="necessary">업체명</dt>
                            <dd>
                                <input type="text" class="input-form w-full  company_name" onkeyup="$(this).parent().find('label').hide();" placeholder="업체명을 입력해주세요.">
                                <label for="" class="error _focus_company_name" style="display: none;">업체명을 정확히 입력해주세요</label>
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-8">
                        <dl class="flex">
                            <dt class="necessary">대표자명</dt>
                            <dd>
                                <input type="text" class="input-form w-full  owner_name" onkeyup="$(this).parent().find('label').hide();" placeholder="대표자를 입력해주세요.">
                                <label for="" class="error _focus_owner_name" style="display: none;">대표자명을 정확히 입력해주세요</label>
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-8">
                        <dl class="flex">
                            <dt class="necessary">회사 주소</dt>
                            <dd>
                                <div class="add_tab">
                                    <!-- 국내 -->
                                    <div class="flex gap-1">
                                        <input type="text" class="input-form w-full  business_address" onclick="convertCompany.execPostCode()" placeholder="주소를 검색해주세요">
                                        <button class="btn btn-black-line">주소 검색</button>
                                    </div>
                                    <!-- 해외 -->
                                    <div class="dropdown_wrap hidden">
                                        <button class="dropdown_btn">지역</button>
                                        <div class="dropdown_list">
                                            <div class="dropdown_item">아시아</div>
                                            <div class="dropdown_item">아프리카</div>
                                            <div class="dropdown_item">북아메리카</div>
                                            <div class="dropdown_item">남아메리카</div>
                                            <div class="dropdown_item">유럽</div>
                                            <div class="dropdown_item">오세아니아</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 w-full">
                                    <input type="text" class="input-form w-full  business_address_detail" placeholder="상세주소를 검색해주세요">
                                </div>
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-8">
                        <dl class="flex">
                            <dt class="necessary  __label_profile_business_attachement">사업자등록증</dt>
                            <dd>
                                <div class="file-form horizontal">
                                    <input type="file" id="pop_info_4-business" onchange="convertCompany.fileUpload(this)">
                                    <label for="pop_info_4-business" class="error  __error_profile_business_attachement">사업자등록증을 첨부해주세요.</label>
                                    <div class="text">
                                        <img class="mx-auto" src="./img/member/img_icon.svg" alt="">
                                        <p class="mt-1">이미지 추가</p>
                                    </div>
                                </div>
                                <div class="info_box mt-2.5">
                                    ・권장 형식: jpg, jpeg, png
                                </div>
                            </dd>
                        </dl>
                    </div>

                </div>
                <div class="flex gap-2 justify-center pb-10">
                    <button class="btn w-1/3 btn-primary" type="button" onClick="convertCompany.updateUserInfo();">승인요청</button>
                </div>
            </div>
        </div>
    </div>
    @endif


    <script src="/js/jquery-1.12.4.js?{{ date('Ymdhis') }}"></script>
    <script defer src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script>

    var _convert_company_type = '{{ auth() -> user()['type'] }}';

    const convertCompany = {
        getThumbFile(_IMG, maxWidth, width, height) {
            var canvas = document.createElement("canvas");
            if(width < maxWidth) {
        //        return _IMG;
            }
            canvas.width = width; // (maxWidth);
            canvas.height = height; // ((maxWidth / (width*1.0))*height);
            canvas.getContext("2d").drawImage(_IMG, 0, 0, width, height);

            var dataURL = canvas.toDataURL("image/png");
            var byteString = atob(dataURL.split(',')[1]);
            var mimeString = dataURL.split(',')[0].split(':')[1].split(';')[0];
            var ab = new ArrayBuffer(byteString.length);
            var ia = new Uint8Array(ab);
            for (var i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }
            var tmpThumbFile = new Blob([ab], {type: mimeString});

            return tmpThumbFile;
        },
        fileUpload(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                let img = input.parentNode.parentNode.querySelector('.file-form').querySelector('img');
                if(!img){
                    img = document.createElement('img')
                }

                reader.onload = function(e) {
                    img.src = e.target.result
                    input.parentNode.parentNode.querySelector('.file-form').append(img)
                    var image = new Image;
                    image.onload = function() {
                        if(input.id === 'pop_info_4-business') {
                            $('.__error_profile_business_attachement').hide();
                            convertCompany.storedCompanyFile = convertCompany.getThumbFile(image, 500, this.width, this.height);
                        } else {
                            convertCompany.storedFile = convertCompany.getThumbFile(image, 500, this.width, this.height);
                        }
                    };
                    image.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        },
        checkCompanyNumber(isOpenOkVal) {
            const targetCompanySection = $('._convert_company_section:visible');
            const businessCode = targetCompanySection.find('.business_code').val();
            
            if(businessCode.replaceAll('-','').length != 10){
                alert('잘못된 사업자 등록번호입니다.');
                return false;
            }
            let dupplicated = true;
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '/member/checkUsingBusinessNumber',
                data: {
                    'business_number': businessCode.replaceAll('-','')
                },
                type: 'POST',
                dataType: 'json',
                async: false,
                success: function(result) {
                    if (result == 0) {
                        if(!isOpenOkVal) {
                            alert('사용가능한 사업자번호 입니다.');
                        }
                        dupplicated = false;
                    } else {
                        if(!isOpenOkVal) {
                            alert('중복된 사업자 등록번호입니다.');
                        }
                    }
                }
            });
            return !dupplicated;
        },
        verifyForm(){
            const targetCompanySection = $('._convert_company_section:visible');
            const businessCode = targetCompanySection.find('.business_code').val();
            const companyName = targetCompanySection.find('.company_name').val();
            const ownerName = targetCompanySection.find('.owner_name').val();

            if(!businessCode || businessCode.trim() == '') {
                targetCompanySection.find('._focus_business_code').show();
                return false;
            }
            if(!companyName || companyName.trim() == '') {
                targetCompanySection.find('._focus_company_name').show();
                return false;
            }
            if(!ownerName || ownerName.trim() == '') {
                targetCompanySection.find('._focus_owner_name').show();
                return false;
            }
            return true;
        },
        updateUserInfo() {
            modalClose('#pop_info_4-modal');

            $('#loadingContainer').show();

            if(_convert_company_type != 'S' && !convertCompany.checkCompanyNumber(1) && !convertCompany.verifyForm()) {
                $('#loadingContainer').hide();
                return;
            }

            var form = new FormData();
                    
            form.append("company_type", _convert_company_type);
            form.append("user_email", $('#pop_info_4-user_email').val());
            form.append("user_name", $('#pop_info_4-user_name').val());
            form.append("user_phone", $('#pop_info_4-user_phone').val());

            if(convertCompany.storedFile) {
                form.append("user_file", convertCompany.storedFile);
            }
            const targetCompanySection = $('._convert_company_section:visible');        
            form.append("email", $('#pop_info_4-user_email').val());
            form.append("business_code", targetCompanySection.find('.business_code').val());
            form.append("company_name", targetCompanySection.find('.company_name').val());
            form.append("owner_name", targetCompanySection.find('.owner_name').val());
            form.append("business_address", targetCompanySection.find('.business_address').val());
            form.append("business_address_detail", targetCompanySection.find('.business_address_detail').val());

            if(convertCompany.storedCompanyFile) {
                form.append("company_file", convertCompany.storedCompanyFile);
            }

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url             : '/member/update',
                enctype         : 'multipart/form-data',
                processData     : false,
                contentType     : false,
                data			: form,
                type			: 'POST',
                async: false,
                success: function (result) {
                    $('#loadingContainer').hide();
                    modalOpen('#pop_info_2-modal');
                }, error: function (e) {
                    $('#loadingContainer').hide();
                }
            });
        },
        execPostCode(t) {
            daum.postcode.load(function() {
                new daum.Postcode({
                    oncomplete: function(data) {
                        var addr = '';

                        if (data.userSelectedType === 'R') {
                            addr = data.roadAddress;
                        } else {
                            addr = data.jibunAddress;
                        }
                        const targetCompanySection = $('._convert_company_section:visible');
                        targetCompanySection.find('.business_address').val(addr);
                        targetCompanySection.find('.business_address_detail').focus();
                    }
                }).open();
            });
        },
        openPopupByWholesaler(){
            const userGrade = '{{Auth::user()-> type}}';
            if(['W'].indexOf(userGrade) > -1) {
                // 이미 권한이 충분합니다.
                return false;
            }
            $('.__label_profile_business_attachement').text('사업자등록증');
            $('.__error_profile_business_attachement').text('사업자등록증을 첨부해주세요.');
            _convert_company_type = 'W';
            
            modalClose('#pop_info_1-modal');
            modalOpen('#pop_info_4-modal');
        },
        openPopupByRetail(){
            const userGrade = '{{Auth::user()-> type}}';
            if(['R'].indexOf(userGrade) > -1) {
                // 이미 권한이 충분합니다.
                return false;
            }
            $('.__label_profile_business_attachement').text('명함 또는 사업자등록증');
            $('.__error_profile_business_attachement').text('명함 또는 사업자등록증을 첨부해주세요.');
            _convert_company_type = 'R';
            
            modalClose('#pop_info_1-modal');
            modalOpen('#pop_info_4-modal');
        },
    };
    </script>
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


