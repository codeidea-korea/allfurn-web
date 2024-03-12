<!-- 모달 들어가는곳 : S -->      

<div class="modal" id="agree01-modal">
	<div class="modal_bg" onclick="modalClose('#agree01-modal')"></div>
	<div class="modal_inner">
		<button class="close_btn" onclick="modalClose('#agree01-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
		<div class="modal_body agree_modal_body">
			<h3>서비스 이용 약관</h3>
			<div class="scroll_box">
				제1장 총칙<br/><br/>
				제1조 (목적)<br/>
				이 약관은 주식회사 올펀(이하 "회사"라 함)이 운영하는 올펀(https://all-furn.com, 모바일 웹/앱; 이하 "올펀"이라 함)에서 
				제공하는 전자상거래 관련 서비스(이하 "서비스"라 함)를 이용함에 있어 상품 또는 용역을 거래하는 자 간의 권리, 의무 등 기타 필요사항, 
				원과 회사간의 권리, 의무, 책임사항 및 회원의 서비스 이용절차 등에 관한 사항을 규정함을 목적으로 합니다.<br/>
				이 약관은 PC통신, 스마트폰(안드로이드폰, 아이폰 등)앱, 제휴 은행 사이트 등을 이용하는 전자상거래에 대해서도 그 성질에 반하지 않는 한 준용됩니다.
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
			<div class="scroll_box">
				<b>올펀 개인정보 처리방침</b><br/><br/>

				주식회사 올펀(이하 “회사”)은 회사가 운영하는 인터넷 사이트(https://all-furn.com, 이하 올펀)를 이용하는
				이용자님들의 개인정보를 매우 중요하게 생각하며 아래와 같은 개인정보 처리방침을 가지고 있습니다.<br/>
				이 개인정보 처리방침은 개인정보와 관련한 법령 또는 지침의 변경이 있는 경우 갱신되고, 올펀 정책의 변화에 따라 달라질 수 있으니 이용자께서는 올펀 사이트를 방문시 수시로 확인하여 주시기 바랍니다.<br/>
				올펀의 개인정보 처리방침은 다음과 같은 내용을 담고 있습니다.
			</div>
		</div>
	</div>
</div>

<div class="modal" id="agree03-modal">
	<div class="modal_bg" onclick="modalClose('#agree03-modal')"></div>
	<div class="modal_inner">
		<button class="close_btn" onclick="modalClose('#agree03-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
		<div class="modal_body agree_modal_body">
			<h3>개인정보 활용 동의</h3>
			<div class="scroll_box">
				<b>마케팅 정보 활용 동의</b><br/><br/>

				마케팅 정보 수신 여부 및 마케팅을 위한 개인정보 수집이용을 거부하실 수 있으며, 거부 시에도 올펀 서비스를 이용하실 수 있으나, 동의를 거부한 경우 각종 소식 및 이벤트 참여에 제한이 있을 수 있습니다.
			</div>
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
                @if(isset($categoryList) != '')
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
                <li>
                    <input type="checkbox" class="check-form" id="filter_cate_2_01">
                    <label for="filter_cate_2_01">서울</label>
                </li>
                <li>
                    <input type="checkbox" class="check-form" id="filter_cate_2_02">
                    <label for="filter_cate_2_02">부산</label>
                </li>
                <li>
                    <input type="checkbox" class="check-form" id="filter_cate_2_03">
                    <label for="filter_cate_2_03">대구</label>
                </li>
                <li>
                    <input type="checkbox" class="check-form" id="filter_cate_2_04">
                    <label for="filter_cate_2_04">인천</label>
                </li>
                <li>
                    <input type="checkbox" class="check-form" id="filter_cate_2_05">
                    <label for="filter_cate_2_05">광주</label>
                </li>
                <li>
                    <input type="checkbox" class="check-form" id="filter_cate_2_06">
                    <label for="filter_cate_2_06">대전</label>
                </li>
                <li>
                    <input type="checkbox" class="check-form" id="filter_cate_2_07">
                    <label for="filter_cate_2_07">울산</label>
                </li>
                <li>
                    <input type="checkbox" class="check-form" id="filter_cate_2_08">
                    <label for="filter_cate_2_08">세종</label>
                </li>
                <li>
                    <input type="checkbox" class="check-form" id="filter_cate_2_09">
                    <label for="filter_cate_2_09">경기</label>
                </li>
                <li>
                    <input type="checkbox" class="check-form" id="filter_cate_2_10">
                    <label for="filter_cate_2_10">강원</label>
                </li>
                <li>
                    <input type="checkbox" class="check-form" id="filter_cate_2_11">
                    <label for="filter_cate_2_11">충청</label>
                </li>
                <li>
                    <input type="checkbox" class="check-form" id="filter_cate_2_12">
                    <label for="filter_cate_2_12">전라</label>
                </li>
                <li>
                    <input type="checkbox" class="check-form" id="filter_cate_2_13">
                    <label for="filter_cate_2_13">경상</label>
                </li>
                <li>
                    <input type="checkbox" class="check-form" id="filter_cate_2_14">
                    <label for="filter_cate_2_14">제주</label>
                </li>
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
                    <input type="radio" class="radio-form" name="filter_cate_3" id="filter_register_time" checked>
                    <label for="filter_register_time">최신순</label>
                </li><li>
                    <input type="radio" class="radio-form" name="filter_cate_3" id="filter_access_count">
                    <label for="filter_access_count">조회순</label>
                </li><li>
                    <input type="radio" class="radio-form" name="filter_cate_3" id="filter_popularity">
                    <label for="filter_popularity">인기순</label>
                </li>
            </ul>
            <div class="btn_bot">
                <button class="btn btn-primary full">선택 완료</button>
            </div>
        </div>
    </div>
</div>






<!-- 검색모달 -->
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


