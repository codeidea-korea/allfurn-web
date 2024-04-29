<!-- 상품등록 > 카테고리 선택 -->
<div class="modal" id="prod_category-modal">
    <div class="modal_bg" onclick="modalClose('#prod_category-modal')"></div>
    <div class="modal_inner modal-md">
        <button class="close_btn" onclick="modalClose('#prod_category-modal')"><svg class="w-11 h-11"><use xlink:href="/img/m/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body prod_cate_body">
            <h4>카테고리 선택</h4>
            <ul class="prod_category">
                @if( isset($categoryList) != '' )
                @foreach( $categoryList as $c => $category )
                <li>
                    <button cidx="{{$category->idx}}" onclick="prodCate(this)"><span>{{$category->name}}</span><svg class="w-6 h-6 stroke-stone-400 "><use xlink:href="/img/m/icon-defs.svg#drop_b_arrow"></use></svg></button>
                    <ul class='prod_category_list'>
                        @if( !empty( $category->property ) )
                        @foreach( $category->property AS $p => $property )
                        <li>
                            <input type="radio" data-p_idx="{{$category->idx}}" class="check-form2" value="{{$property['idx']}}" name="prod_category" id="prod_category_{{$c}}_{{$p}}">
                            <label for="prod_category_{{$c}}_{{$p}}">{{$property['name']}}</label>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </li>
                @endforeach
                @endif
            </ul>
            <div class="btn_bot">
                <button class="btn btn-primary w-full" onclick="setCategory();">선택 완료</button>
            </div>
        </div>
    </div>
</div>
<!-- 상품등록 > 속성 -->
<div class="modal" id="prod_property-modal">
    <div class="modal_bg" onclick="modalClose('#prod_property-modal')"></div>
    <div class="modal_inner modal-md">
        <button class="close_btn" onclick="modalClose('#prod_property-modal')"><svg class="w-11 h-11"><use xlink:href="/img/m/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body h_fix btnok filter_body prod_property_body">
            <h4>속성</h4>
            <ul class="prod_property_tab"></ul>
            <div class="prod_property_cont">
            </div>
            <div class="btn_bot">
                <button class="btn btn-line3 refresh_btn" onclick="refreshHandle(this)"><svg><use xlink:href="/img/m/icon-defs.svg#refresh"></use></svg>초기화</button>
                <button class="btn btn-primary confirm_prod_property">선택 완료</button>
            </div>
        </div>
    </div>
</div>

<!-- 상품등록 > 배송방법 -->
<div class="modal" id="prod_shipping-modal">
    <div class="modal_bg" onclick="modalClose('#prod_shipping-modal')"></div>
    <div class="modal_inner modal-md">
        <button class="close_btn" onclick="modalClose('#prod_shipping-modal')"><svg class="w-11 h-11"><use xlink:href="/img/m/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body h_fix2 p-5 flex flex-col">
            <h4 class="modal_tit shrink-0">배송 방법 추가</h4>
            <div class="my-5 flex-grow">
                <div class="dropdown_wrap">
                    <button class="dropdown_btn">직접입력</button>
                    <div class="dropdown_list">
                        <div class="dropdown_item" onclick="shippingShow('shipping_form',0)">직접입력</div>
                        <div class="dropdown_item" onclick="shippingShow('shipping_form',1)">소비자 직배 가능</div>
                        <div class="dropdown_item" onclick="shippingShow('shipping_form',1)">매장 배송</div>
                    </div>
                </div>
                <div class="shipping_form hidden">
                    <div class="shipping_cont mt-2">
                        <div class="shipping_write">
                            <input type="text" class="input-form w-full" placeholder="배송 방법을 입력해주세요.">
                        </div>
                        <div class="hidden"></div>
                    </div>
                    <div class="prod_regist mt-2">
                        <dl class="mb-3">
                            <dt class="necessary">위 배송 방법의 가격을 선택해주세요.</dt>
                            <dd>
                                <div class="flex gap-2 btn_select">
                                    <button class="w-1/2 active">무료</button>
                                    <button class="w-1/2">착불</button>
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="shrink-0">
                <button class="btn btn-primary w-full">추가하기</button>
            </div>
        </div>
    </div>
</div>

<!-- 상품등록 > 인증정보 -->
<div class="modal" id="prod_certifi-modal">
    <div class="modal_bg" onclick="modalClose('#prod_certifi-modal')"></div>
    <div class="modal_inner modal-md">
        <button class="close_btn" onclick="modalClose('#prod_certifi-modal')"><svg class="w-11 h-11"><use xlink:href="/img/m/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body filter_body">
            <h4>인증 정보</h4>
            <ul class="filter_list">
                <li>
                    <input type="checkbox" class="check-form" id="certified_01" data-auth="KS 인증">
                    <label for="certified_01">KS 인증</label>
                </li>
                <li>
                    <input type="checkbox" class="check-form" id="certified_02" data-auth="ISO 인증">
                    <label for="certified_02">ISO 인증</label>
                </li>
                <li>
                    <input type="checkbox" class="check-form" id="certified_03" data-auth="KC 인증">
                    <label for="certified_03">KC 인증</label>
                </li>
                <li>
                    <input type="checkbox" class="check-form" id="certified_04" data-auth="친환경 인증">
                    <label for="certified_04">친환경 인증</label>
                </li>
                <li>
                    <input type="checkbox" class="check-form" id="certified_05" data-auth="외코텍스(OEKO-TEX) 인증">
                    <label for="certified_05">외코텍스(OEKO-TEX) 인증</label>
                </li>
                <li>
                    <input type="checkbox" class="check-form" id="certified_06" data-auth="독일 LGA 인증">
                    <label for="certified_06">독일 LGA 인증</label>
                </li>
                <li>
                    <input type="checkbox" class="check-form" id="certified_07" data-auth="GOTS(오가닉) 인증">
                    <label for="certified_07">GOTS(오가닉) 인증</label>
                </li>
                <li>
                    <input type="checkbox" class="check-form" id="certified_08" data-auth="라돈테스트 인증">
                    <label for="certified_08">라돈테스트 인증</label>
                </li>
                <li>
                    <input type="checkbox" class="check-form" id="certified_09" data-auth="전자파 인증">
                    <label for="certified_09">전자파 인증</label>
                </li>
                <li>
                    <input type="checkbox" class="check-form" id="certified_10" data-auth="전기용품안전 인증">
                    <label for="certified_10">전기용품안전 인증</label>
                </li>
                <li>
                    <input type="checkbox" class="check-form" id="certified_11" data-auth="기타 인증">
                    <label for="certified_11">기타 인증</label>
                    <input class="setting_input h-[48px] w-full" type="text" id="auth_info_text" maxlength="20" placeholder="(필수) 기타 인증을 입력해주세요." required style="display: none;">
                </li>
            </ul>
            <div class="btn_bot">
                <button class="btn btn-primary !w-full" onclick="modalClose('#prod_certifi-modal')">선택 완료</button>
            </div>
        </div>
    </div>
</div>

<!-- 상품 상세 내용 가이드 모달-->
<div class="modal" id="writing_guide_modal">
    <div class="modal_bg" onclick="modalClose('#writing_guide_modal')"></div>
    <div class="modal_inner inner_full">
        <button class="close_btn" onclick="modalClose('#writing_guide_modal')"><svg><use xlink:href="/img/m/icon-defs.svg#x"></use></svg></button>
        <div class="modal_body fix_full">
            <div class="p-5">
                <p class="text-lg font-bold text-left">이용 가이드</p>
                <div class="mt-5 writing_guide_body">
                    <div class="relative">
                        <a href="javascript:;" class="h-[48px] px-3 border rounded-md inline-block filter_border filter_dropdown w-[full] flex justify-between items-center mt-3">
                            <p>이용가이드</p>
                            <svg class="w-6 h-6 filter_arrow"><use xlink:href="/img/m/icon-defs.svg#drop_b_arrow"></use></svg>
                        </a>
                        <div class="filter_dropdown_wrap guide_list w-full h-[300px] overflow-y-scroll bg-white" style="display: none;">
                            <ul>
                                <li>
                                    <a href="javascript:;" class="flex items-center" data-target="guide01">상품 주문하기</a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="flex items-center" data-target="guide02">장바구니</a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="flex items-center" data-target="guide03">관심 상품 폴더 관리</a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="flex items-center" data-target="guide04">상품 찾기</a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="flex items-center" data-target="guide05">상품 문의</a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="flex items-center" data-target="guide06">업체 찾기</a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="flex items-center" data-target="guide07">업체 문의</a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="flex items-center" data-target="guide08">상품 등록</a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="flex items-center" data-target="guide09">상품 관리</a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="flex items-center" data-target="guide10">업체 관리</a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="flex items-center" data-target="guide11">커뮤니티 활동</a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="flex items-center" data-target="guide12">거래 관리</a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="flex items-center" data-target="guide13">주문 관리</a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="flex items-center" data-target="guide14">내정보 수정</a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="flex items-center" data-target="guide15">직원 계정 추가</a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="flex items-center" data-target="guide16">정회원 승격 요청</a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="flex items-center" data-target="guide17">올펀 문의하기</a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="flex items-center" data-target="guide18">기타 회원 권한</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div id="guide01" class="guide_con mt-5 px-5 text-sm font-medium overflow-y-auto">
                        <div class="flex items-center jutstify-between gap-3">
                            <span class="line_guide"></span>
                            <p class="text-primary text-xl font-bold shrink-0">상품 주문하기</p>
                            <span class="line_guide"></span>
                        </div>
                        <ul class="guide_list mt-5">
                            <li class="ml-3">상품 상세 화면에서 상품을 바로 주문하거나 장바구니 에서 여러 업체의 상품을 한 번에 주문하실 수 있습니다.</li>
                        </ul>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance01-1.png">
                        </div>
                        <div class="flex gap-2 px-16 text-xs">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">1</p>
                            <p><span class="text-primary">[주문하기]</span> 버튼을 누르시면 하단에서 옵션 선택 영역이 노출됩니다.</p>
                        </div>
                    </div>
                    <div id="guide02" class="guide_con mt-5 px-5 text-sm font-medium overflow-y-auto hidden">
                        <div class="flex items-center jutstify-between gap-3">
                            <span class="line_guide"></span>
                            <p class="text-primary text-xl font-bold shrink-0">장바구니</p>
                            <span class="line_guide"></span>
                        </div>
                        <ul class="guide_list mt-5">
                            <li class="ml-3">
                                홈, 상품 상세, 업체 상세, 카테고리, 마이올펀 화면 우측 상단에 있는
                                장바구니 아이콘을 누르면 장바구니 화면으로 이동합니다.
                            </li>
                        </ul>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance02-1.png">
                        </div>
                        <div class="flex gap-2  px-16 text-xs">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">1</p>
                            <p><span class="text-primary">[업체 보러가기]</span>를 통해 장바구니에 담은 상품의 판매 업체
                                상세 화면을 확인하실 수 있습니다.</p>
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">2</p>
                            <p>상품별로 옵션 및 수량 변경과 바로 주문, 삭제가 가능합니다</p>
                        </div>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance02-2.png">
                        </div>
                        <div class="flex gap-2 px-16 text-xs">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">3</p>
                            <p>선택된 상품의 총주문 금액과 개수를 확인하고 하단의 <span class="text-primary">[상품 주문하기]</span>버튼으로 주문을 진행해주세요.</p>
                        </div>
                    </div>
                    <div id="guide03" class="guide_con mt-5 px-5 text-sm font-medium overflow-y-auto hidden">
                        <div class="flex items-center jutstify-between gap-3">
                            <span class="line_guide"></span>
                            <p class="text-primary text-xl font-bold shrink-0">관심 상품 폴더 관리</p>
                            <span class="line_guide"></span>
                        </div>
                        <ul class="guide_list mt-5">
                            <li class="ml-3">
                                상품 리스트나 상품 상세 화면에서 북마크 아이콘을
                                누르면 나의 관심 상품으로 설정됩니다.
                            </li>
                            <li class="ml-3 mt-3">
                                관심 상품 리스트는 하단 내비게이션 바의 [마이올펀] >
                                관심 상품 메뉴에서 확인하실 수 있습니다.
                            </li>
                        </ul>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance03-1.png">
                        </div>
                        <div class="flex gap-2 px-16 text-xs">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">1</p>
                            <p>우측 상단 <span class="text-primary">[폴더 관리]</span>버튼을 누르면 폴더를 추가하거나 폴더명을 변경하실 수 있습니다.</p>
                        </div>
                        <div class="flex gap-2 px-16 mt-3 text-xs">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">2</p>
                            <div>
                                <p>화면 중간 <span class="text-primary">[편집]</span>버튼을 누르면 각 상품에 체크박스가 표시되며 상품을 원하는 폴더로 이동시키거나 삭제시킬 수 있습니다.</p>

                                <div class="flex gap-2 text-xs mt-2">
                                    <p class="flex items-cetner justify-center w-[18px] h-[18px] bg-stone-400 text-white text-sm shrink-0">A</p>
                                    <p>이동시키고 싶은 상품을 체크 선택해주세요.</p>
                                </div>
                                <div class="flex gap-2 mt-2 text-xs">
                                    <p class="flex items-cetner justify-center w-[18px] h-[18px] bg-stone-400 text-white text-sm shrink-0">B</p>
                                    <p> <span class="text-primary">[폴더이동]</span> 버튼을 누르면 하단에서 노출되는 폴더 리스트에서 이동시킬 폴더를 선택합니다.</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance03-2.png">
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">3</p>
                            <p>폴더 편집이 끝난 뒤 <span class="text-primary">[완료]</span>버튼을 누르면 편집 상태가 종료됩니다.</p>
                        </div>
                    </div>
                    <div id="guide04" class="guide_con mt-5 px-5 text-sm font-medium overflow-y-auto hidden">
                        <div class="flex items-center jutstify-between gap-3">
                            <span class="line_guide"></span>
                            <p class="text-primary text-xl font-bold shrink-0">상품 찾기</p>
                            <span class="line_guide"></span>
                        </div>
                        <ul class="guide_list mt-5">
                            <li class="ml-3">
                                하단 내비게이션 바의 [홈]이나 [카테고리]에서 상품을
                                찾아보실 수 있습니다.
                            </li>
                        </ul>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance04-1.png">
                        </div>
                        <div class="text-center">
                            <button class="px-6 h-[28px] border border-primary rounded-full text-sm text-primary">검색</button>
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">1</p>
                            <p>상단 검색 바에서 검색할 상품명이나 상품의 속성을 입력해주세요.</p>
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">2</p>
                            <p>띄어쓰기나 영문, 숫자가 포함된 검색어는 동일하게 입력해야 검색 결과에 반영됩니다.</p>
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">3</p>
                            <p>검색 후 검색 결과에 해당되는 상품은 좌측 상품 탭에서 확인하실 수 있습니다.</p>
                        </div>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance04-2.png">
                        </div>
                        <div class="text-center">
                            <button class="px-6 h-[28px] border border-primary rounded-full text-sm text-primary">카테고리</button>
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">1</p>
                            <p>찾고자 하는 상품의 카테고리를 선택해주세요.</p>
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">2</p>
                            <p>대분류 카테고리에 포함된 중분류 카테고리를 선택해주시면 세분화된 상품 결과를 확인하실 수 있습니다.</p>
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">3</p>
                            <p>중분류 선택 시 노출되는 속성 필터로 더욱 세분화된 상품 결과를 확인해보세요.</p>
                        </div>
                    </div>
                    <div id="guide05" class="guide_con mt-5 px-5 text-sm font-medium overflow-y-auto hidden">
                        <div class="flex items-center jutstify-between gap-3">
                            <span class="line_guide"></span>
                            <p class="text-primary text-xl font-bold shrink-0">상품 문의</p>
                            <span class="line_guide"></span>
                        </div>
                        <ul class="guide_list mt-5">
                            <li class="ml-3">
                                상품 상세 화면에서 [전화], [문의] 버튼으로 상품에
                                관해 문의하실 수 있습니다.
                            </li>
                        </ul>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance05-1.png">
                        </div>v>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">1</p>
                            <p><span class="text-primary">[전화]</span>버튼을 누르시면 판매 업체의 대표 번호로 전화가 연결됩니다.</p>
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">2</p>
                            <p><span class="text-primary">[문의]</span>버튼을 누르시면 판매 업체와 1:1 메세지 화면으로 이동합니다.</p>
                        </div>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance05-2.png">
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">3</p>
                            <p>메세지 입력창 위 노출되는 상품명으로 문의할 상품이 맞는지 확인해주세요.</p>
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">4</p>
                            <p>자동 입력된 메세지를 바로 전송하거나 수정하여 상품을 문의하실 수 있습니다.</p>
                        </div>
                    </div>
                    <div id="guide06" class="guide_con mt-5 px-5 text-sm font-medium overflow-y-auto hidden">
                        <div class="flex items-center jutstify-between gap-3">
                            <span class="line_guide"></span>
                            <p class="text-primary text-xl font-bold shrink-0">업체 찾기</p>
                            <span class="line_guide"></span>
                        </div>
                        <ul class="guide_list mt-5">
                            <li class="ml-3">
                                하단 내비게이션 바의 [홈]에서 업체를 검색해보실 수 있습니다.
                            </li>
                        </ul>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance06-1.png">
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">1</p>
                            <p><span class="text-primary">상단 검색 바에서 검색할 업체명이나 업체 대표자명을 입력해주세요.</p>
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">2</p>
                            <p><span class="text-primary">띄어쓰기나 영문, 숫자가 포함된 검색어는 동일하게 입력해야 검색 결과에 반영됩니다.</p>
                        </div>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance06-2.png">
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">3</p>
                            <p>검색 후 검색 결과에 해당되는 업체는 우측 업체탭에서 확인하실 수 있습니다.</p>
                        </div>
                    </div>
                    <div id="guide07" class="guide_con mt-5 px-5 text-sm font-medium overflow-y-auto hidden">
                        <div class="flex items-center jutstify-between gap-3">
                            <span class="line_guide"></span>
                            <p class="text-primary text-xl font-bold shrink-0">업체 문의</p>
                            <span class="line_guide"></span>
                        </div>
                        <ul class="guide_list mt-5">
                            <li class="ml-3">
                                하단 내비게이션 바의 [홈]에서 업체를 검색해보실 수 있습니다.
                            </li>
                        </ul>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance07-1.png">
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">1</p>
                            <p><span class="text-primary">[전화]</span>버튼을 누르시면 업체의 대표 번호로 전화가 연결됩니다.</p>
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">2</p>
                            <p><span class="text-primary">[문의]</span>버튼을 누르시면 업체와 1:1 메세지 화면으로 이동합니다.</p>
                        </div>
                    </div>
                    <div id="guide08" class="guide_con mt-5 px-5 text-sm font-medium overflow-y-auto hidden">
                        <div class="flex items-center jutstify-between gap-3">
                            <span class="line_guide"></span>
                            <p class="text-primary text-xl font-bold shrink-0">상품 등록</p>
                            <span class="line_guide"></span>
                        </div>
                        <ul class="guide_list mt-5">
                            <li class="ml-3">
                                하단 내비게이션 바 [홈]에서 도매 정회원에게만
                                노출되는 우측 하단 [+] 플로팅 버튼을 눌러 상품을
                                등록해주세요.
                            </li>
                            <li class="ml-3 mt-3">
                                상품을 5개 이상 등록해야 도매 업체 리스트에 업체가 노출됩니다
                            </li>
                            <li class="ml-3 mt-3">
                                모바일앱에서는 상품명과 카테고리만 입력하시면 임시
                                저장됩니다. 등록 중인 상품은 하단 내비게이션 바의
                                [마이올펀] > 상품 관리 > 임시 등록 탭에서 확인하실
                                수 있습니다.
                            </li>
                            <li class="ml-3 mt-3">
                                모바일앱에서는 상품의 임시 등록만 가능하며 상품
                                등록 신청은 데스크탑 웹에서만 가능합니다.
                            </li>
                        </ul>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance08-1.png">
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">1</p>
                            <p><span class="text-primary">[+]</span>버튼을 누르시면 상품 등록 화면이 노출됩니다.</p>
                        </div>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance08-2.png">
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">2</p>
                            <p><span class="text-primary">[이전]</span>버튼은 이전 화면으로 이동, <span class="text-primary">[다음]</span>버튼은 다음 단계 화면으로 이동합니다. [다음] 버튼에는 현재 등록 중인 단계가 표기됩니다.</p>
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">3</p>
                            <p><span class="text-primary">[미리 보기]</span>버튼으로 등록한 상품 정보가 어떻게 보이는지 확인하실 수 있습니다.</p>
                        </div>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance08-3.png">
                        </div>
                        <div class="text-center">
                            <button class="px-6 h-[28px] border border-primary rounded-full text-sm text-primary">상품 기본 정보</button>
                        </div>
                        <ul class="guide_list">
                            <li class="ml-3 text-xs mt-3">
                                등록하는 상품의 상품명, 이미지, 카테고리, 가격, 가격 노출 여부,
                                결제 방식, 상품 코드, 배송 방법, 추가 공지, 인증 정보,
                                상세 내용을 입력합니다.
                            </li>
                            <li class="ml-3 text-xs mt-3">
                                상품의 성격에 맞는 카테고리 대분류와 중분류를 선택해주세요.
                            </li>
                            <li class="ml-3 text-xs mt-3">
                                상품 속성은 등록하는 상품의 사양에 맞는 항목을 모두 선택해주세요.
                            </li>
                            <li class="ml-3 text-xs mt-3">
                                입력한 상품 가격의 노출 여부를 선택해주시고 미 노출인 경우, 가격 대신 노출할 안내 문구를 선택해주시면 됩니다.
                            </li>
                            <li class="ml-3 text-xs mt-3">
                                결제 방식은 상품별 1개의 방식만 선택하거나 직접 입력하실 수 있습니다.
                            </li>
                            <li class="ml-3 text-xs mt-3">
                                상품 코드를 입력하시면 상품 분별을 위해 자체적으로 사용하고 있는 코드로 서비스 내에서도 상품 관리에 활용하실 수 있습니다.
                            </li>
                            <li class="ml-3 text-xs mt-3">
                                배송 방법은 상품별 총 6개까지 추가 가능합니다.
                                <ul>
                                    <li class="ml-3 text-stone-400 mt-3">
                                        <span>[배송 방법 추가]</span>버튼을 누르고 노출되는 화면에서 배송 방법을 선택해주세요.
                                    </li>
                                    <li class="ml-3 text-stone-400 mt-3">
                                        배송 방법 선택 혹은 직접 입력 후, 해당 배송의 가격을 무료/착불 중에 선택해주세요.
                                    </li>
                                    <li class="ml-3 text-stone-400 mt-3">
                                        <span>[추가하기]</span>버튼을 누르면 배송 방법이 추가됩니다.
                                    </li>
                                </ul>
                            </li>
                            <li class="ml-3 text-xs mt-3">
                                상품 등록 시 입력한 항목 외에도 추가로 공지하고 싶은 사항이 있다면 ‘상품 추가 공지’ 항목에 자유롭게 입력해주시면 됩니다.
                            </li>
                            <li class="ml-3 text-xs mt-3">
                                <span class="text-primary">[인증 정보 선택]</span>버튼을 누르고 등록 상품에 해당되는 인증 정보를 모두 선택해주세요.
                            </li>
                        </ul>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance08-4.png">
                        </div>
                        <div class="text-center">
                            <button class="px-6 h-[28px] border border-primary rounded-full text-sm text-primary">상품 상세 내용</button>
                        </div>
                        <ul class="guide_list">
                            <li class="ml-3 text-xs mt-3">
                                상품 상세 화면에서 상품 정보로 보여지는 영역으로, 자유롭게 입력하실 수 있습니다.
                            </li>
                            <li class="ml-3 text-xs mt-3">
                                서체 편집, 텍스트 맞춤, 링크 삽입, 이미지 첨부가 가능합니다. 데스크탑 웹에서는 더 상세한 기능을 사용하실 수 있습니다.
                            </li>
                            <li class="ml-3 text-xs mt-3">
                                상품이 돋보일 수 있는 설명과 이미지로 구성해주시면 됩니다.
                            </li>
                        </ul>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance08-5.png">
                        </div>
                        <div class="text-center">
                            <button class="px-6 h-[28px] border border-primary rounded-full text-sm text-primary">상품 주문 옵션</button>
                        </div>
                        <ul class="guide_list">
                            <li class="ml-3 text-xs mt-3">
                                옵션값의 가격은 주문 시 고객이 상품의 해당 옵션을 선택하는 경우, 상품 가격에 옵션값 가격만큼 추가됩니다.
                            </li>
                            <li class="ml-3 text-xs mt-3">
                                옵션값의 가격을 입력하지 않은 경우, 해당 옵션값의 가격은 0원으로 설정됩니다.
                            </li>
                        </ul>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">1</p>
                            <p><span class="text-primary">[주문 옵션 추가]</span>버튼을 눌러 옵션을 추가합니다.</p>
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">2</p>
                            <p>필수 옵션 여부를 설정하고 옵션 명과 옵션값을 입력합니다.</p>
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">3</p>
                            <p><span class="text-primary">[옵션값 추가]</span>버튼으로 옵션값을 추가합니다.</p>
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">4</p>
                            <div>
                                <p>추가한 옵션이 2개 이상인 경우, <span class="text-primary">[옵션 순서 변경]</span>버튼이 활성화되며 옵션의 순서를 변경하실 수 있습니다.</p>

                                <div class="flex gap-2 text-xs mt-2">
                                    <p class="flex items-cetner justify-center w-[18px] h-[18px] bg-stone-400 text-white text-sm shrink-0">A</p>
                                    <p>좌측의 순서 변경 아이콘을 드래그하여 순서를 변경해주세요.</p>
                                </div>
                                <div class="flex gap-2 mt-2 text-xs">
                                    <p class="flex items-cetner justify-center w-[18px] h-[18px] bg-stone-400 text-white text-sm shrink-0">B</p>
                                    <p><span class="text-primary">[변경 완료]</span>버튼을 눌러야 변경된 순서가 반영됩니다.</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance08-6.png">
                        </div>
                        <div class="text-center">
                            <button class="px-6 h-[28px] border border-primary rounded-full text-sm text-primary">상품 주문 정보</button>
                        </div>
                        <ul class="guide_list">
                            <li class="ml-3 text-xs mt-3">
                                <span class="text-primary">[설정]</span>버튼을 누르고 등록 상품의 결제, 배송, 교환/반품/취소 관련한 정보를 입력해주세요.
                            </li>
                            <li class="ml-3 text-xs mt-3">
                                추가로 주문 관련하여 입력할 정보가 있다면 ‘주문 정보 직접 입력’ 항목의 <span class="text-primary">[설정]</span>버튼을 누르고 항목 제목과 내용을 직접 입력해주세요.
                            </li>
                        </ul>
                    </div>
                    <div id="guide09" class="guide_con mt-5 px-5 text-sm font-medium overflow-y-auto hidden">
                        <div class="flex items-center jutstify-between gap-3">
                            <span class="line_guide"></span>
                            <p class="text-primary text-xl font-bold shrink-0">상품 관리</p>
                            <span class="line_guide"></span>
                        </div>
                        <ul class="guide_list mt-5">
                            <li class="ml-3">
                                상품 상세 화면에서 <span class="text-primary">[전화], [문의]</span>버튼으로 상품에 관해 문의하실 수 있습니다.
                            </li>
                            <li class="ml-3 mt-3">
                                상품 관리 화면에는 등록 신청이 완료된 상품은 등록 탭에서, 임시 등록된 상품은 임시 등록 탭에서 확인하실 수 있습니다.
                            </li>
                            <li class="ml-3 mt-3">
                                ‘승인 대기’와 ‘반려’, 관리자에 의한 ‘판매 중지’ 상태에는 상품의 상태 변경이 불가합니다.
                            </li>
                            <li class="ml-3 mt-3">
                                ‘승인 대기’와 관리자에 의한 ‘판매 중지’ 상태에는 상품의 수정이 불가합니다.
                            </li>
                            <li class="ml-3 mt-3">
                                거래 중인 상품의 경우, 상태 변경과 정보 수정을 주의해주세요.
                            </li>
                        </ul>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance09-1.png">
                        </div>
                        <div class="text-center">
                            <button class="px-6 h-[28px] border border-primary rounded-full text-sm text-primary">상품 기본 정보</button>
                        </div>
                        <ul class="guide_list">
                            <li class="ml-3 text-xs mt-3">
                                설정하신 추천 상품은 업체 상세 화면과 판매 상품 상세의 하단에 노출됩니다.
                            </li>
                            <li class="ml-3 text-xs mt-3">
                                ‘판매 중’ 상태의 상품 우측에 있는 별 아이콘을 누르시면 추천 상품으로 설정되거나 해지됩니다.
                            </li>
                            <li class="ml-3 text-xs mt-3">
                                추천 상품으로 설정되어있는 상품은 상태 변경이 불가합니다.
                            </li>
                        </ul>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance09-2.png">
                        </div>
                        <div class="text-center">
                            <button class="px-6 h-[28px] border border-primary rounded-full text-sm text-primary">상품 상태 변경 및 수정</button>
                        </div>
                        <ul class="guide_list">
                            <li class="ml-3 text-xs mt-3">
                                <span class="text-primary">[상태 변경]</span>버튼을 누르면 노출되는 리스트에서 변경시킬 상태를 선택해주세요.
                            </li>
                            <li class="ml-3 text-xs mt-3">
                                등록 탭에 있는 <span class="text-primary">[수정]</span>버튼을 누르면 상품 수정 화면으로 이동되며, 임시 등록 탭의 <span class="text-primary">[수정]</span>버튼을 누르면 상품 등록 중인 화면으로 이동됩니다.
                            </li>
                            <li class="ml-3 text-xs mt-3">
                                상품명을 누르시면 노출되는 미리보기 화면에서 하단의 <span class="text-primary">[상품 삭제]</span>버튼으로 상품을 삭제하실 수 있습니다.
                            </li>
                        </ul>
                    </div>
                    <div id="guide10" class="guide_con mt-5 px-5 text-sm font-medium overflow-y-auto hidden">
                        <div class="flex items-center jutstify-between gap-3">
                            <span class="line_guide"></span>
                            <p class="text-primary text-xl font-bold shrink-0">업체 관리</p>
                            <span class="line_guide"></span>
                        </div>
                        <ul class="guide_list mt-5">
                            <li class="ml-3">
                                하단 내비게이션 바의 [마이올펀] > 업체 관리 메뉴에서 업체 상세 정보를 관리하실 수 있습니다.
                            </li>
                            <li class="ml-3 mt-3">
                                도매 정회원의 경우, 최초 로그인 시 업체 관리 화면으로 이동됩니다.
                            </li>
                            <li class="ml-3 mt-3">
                                업체 소개나 정보를 입력하시고 상품을 5개 이상 등록 해야 도매 업체 리스트에 업체가 노출됩니다.
                            </li>
                            <li class="ml-3 mt-3">
                                업체 정보는 입력하신 항목만 업체 상세 화면에 노출됩니다.
                            </li>
                        </ul>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance10-1.png">
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">1</p>
                            <p>업체명 좌측에 있는 카메라 아이콘을 눌러업체 로고 이미지를 업로드해주세요.</p>
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">2</p>
                            <p><span class="text-primary">[문의]</span>버튼을 누르시면 업체와 1:1 메세지 화면으로 이동합니다.</p>
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">2</p>
                            <p>생성된 메세지 화면에서 자유롭게 문의해주세요.</p>
                        </div>
                    </div>
                    <div id="guide11" class="guide_con mt-5 px-5 text-sm font-medium overflow-y-auto hidden">
                        <div class="flex items-center jutstify-between gap-3">
                            <span class="line_guide"></span>
                            <p class="text-primary text-xl font-bold shrink-0">커뮤니티 활동</p>
                            <span class="line_guide"></span>
                        </div>
                        <ul class="guide_list mt-5">
                            <li class="ml-3">
                                우측 상단의 사람 아이콘을 눌러 커뮤니티 내 나의 활동 사항을 확인하실 수 있습니다.
                            </li>
                            <li class="ml-3 mt-3">
                                우측 하단 펜 모양의 플로팅 버튼을 눌러 게시글을 작성해주세요.
                            </li>
                            <li class="ml-3 mt-3">
                                비즈니스 게시판을 구독하시면 새 게시글 알림을 받아 보실 수 있습니다. [구독하기] 버튼을 통해 구독을 설정/해지하실 수 있습니다.
                            </li>
                        </ul>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance11-1.png">
                        </div>
                        <div class="text-center">
                            <button class="px-6 h-[28px] border border-primary rounded-full text-sm text-primary">내 활동</button>
                        </div>
                        <ul class="guide_list">
                            <li class="ml-3 text-xs mt-3">
                                작성한 게시글, 댓글 및 답글, 좋아요한 게시글을 확인하실 수 있습니다.
                            </li>
                            <li class="ml-3 text-xs mt-3">
                                내가 작성한 게시글, 댓글 및 답글만 삭제하실 수 있습니다.
                            </li>
                            <li class="ml-3 text-xs mt-3">
                                관리자에 의해 작성한 게시글이 숨김 처리될 수 있습니다. 관리자 문의는 마이올펀 > 고객센터 > 1:1 문의를 이용해주세요.
                            </li>
                        </ul>
                    </div>
                    <div id="guide12" class="guide_con mt-5 px-5 text-sm font-medium overflow-y-auto hidden">
                        <div class="flex items-center jutstify-between gap-3">
                            <span class="line_guide"></span>
                            <p class="text-primary text-xl font-bold shrink-0">거래 관리</p>
                            <span class="line_guide"></span>
                        </div>
                        <ul class="guide_list mt-5">
                            <li class="ml-3">
                                하단 내비게이션 바의 [마이올펀] > 거래 현황 메뉴에서 상품별, 업체별 탭으로 거래 현황을 확인하실 수 있습니다.
                            </li>
                            <li class="ml-3 mt-3">
                                거래 상태에 따라 변경되는 버튼을 클릭하여 거래를 관리해주세요.
                            </li>
                            <li class="ml-3 mt-3">
                                거래 취소는 거래 확정 전에만 가능하며, 상품별 혹은 전체 거래 취소가 가능합니다.
                            </li>
                        </ul>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance12-1.png">
                        </div>
                        <div>
                            <div class="flex gap-3">
                                <span class="bg-primary w-[80px] text-xs text-white py-1 rounded-md shrink-0 flex justify-center items-center">신규 주문</span>
                                <p class="text-xs">주문이 새로 들어온 상태로, 주문을 진행하려면 [거래 확정] 버튼을 누르고 상품을 준비해주세요.</p>
                            </div>
                            <div class="flex gap-3 mt-3">
                                <span class="bg-primary w-[80px] text-xs text-white py-1 rounded-md shrink-0 flex justify-center items-center">상품 준비 중</span>
                                <p class="text-xs">거래 확정 이후, 발송하기 전 단계입니다. 준비가 완료되었다면 [배차 신청] 버튼으로 배차를 신청하거나 [발송] 버튼을 누르고 상품을 발송해주세요.</p>
                            </div>
                            <div class="flex gap-3 mt-3">
                                <span class="bg-primary w-[80px] text-xs text-white py-1 rounded-md shrink-0 flex justify-center items-center">발송 중</span>
                                <p class="text-xs">발송 이후, 거래 완료 전 단계입니다. 발송이 완료되었다면 [발송 완료] 버튼을 눌러주세요. 구매자에게 구매 확정 요청이 전달됩니다.</p>
                            </div>
                        </div>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance12-2.png">
                        </div>
                        <div>
                            <div class="flex gap-3">
                                <span class="bg-primaryop text-primary w-[80px] text-xs  py-1 rounded-md shrink-0 flex justify-center items-center">구매 확정 대기</span>
                                <p class="text-xs">발송 완료 이후, 구매 확정 대기 상태입니다. 구매자가 구매 확정을 진행해야 거래가 완료됩니다.</p>
                            </div>
                            <div class="flex gap-3 mt-3">
                                <span class="bg-stone-800 text-white  w-[80px] text-xs  py-1 rounded-md shrink-0 flex justify-center items-center">거래 완료</span>
                                <p class="text-xs">발송 완료 이후, 구매 확정 대기 상태입니다. 구매자가 구매 확정을 진행해야 거래가 완료됩니다.</p>
                            </div>
                            <div class="flex gap-3 mt-3">
                                <span class="bg-stone-100 text-stone-400 w-[80px] text-xs  py-1 rounded-md shrink-0 flex justify-center items-center">거래 취소</span>
                                <p class="text-xs">거래 확정 전, 전체 거래가 취소된 경우 ‘거래 취소’로 상태가 표기됩니다.</p>
                            </div>
                        </div>
                    </div>
                    <div id="guide13" class="guide_con mt-5 px-5 text-sm font-medium overflow-y-auto hidden">
                        <div class="flex items-center jutstify-between gap-3">
                            <span class="line_guide"></span>
                            <p class="text-primary text-xl font-bold shrink-0">거래 관리</p>
                            <span class="line_guide"></span>
                        </div>
                        <ul class="guide_list mt-5">
                            <li class="ml-3">
                                하단 내비게이션 바의 [마이올펀] > 주문 현황 메뉴에서 주문 현황을 확인하실 수 있습니다.
                            </li>
                            <li class="ml-3 mt-3">
                                판매자의 거래 관리에 따라 주문 상태가 변경됩니다.
                            </li>
                            <li class="ml-3 mt-3">
                                주문 취소는 거래 확정 전까지만 가능하며, 상품별 혹은 전체 주문 취소가 가능합니다.
                            </li>
                        </ul>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance13-1.png">
                        </div>
                        <div>
                            <div class="flex gap-3">
                                <span class="bg-primaryop text-primary w-[80px] text-xs  py-1 rounded-md shrink-0 flex justify-center items-center">구매 확정 대기</span>
                                <p class="text-xs">발송이 완료되었다면 <span class="text-primary">[구매 확정]</span>버튼을 눌러주세요. 거래가 완료됩니다.</p>
                            </div>
                            <div class="flex gap-3 mt-3">
                                <span class="bg-stone-100 text-stone-400 w-[80px] text-xs  py-1 rounded-md shrink-0 flex justify-center items-center">주문 취소</span>
                                <p class="text-xs">거래 확정 전, 전체 거래가 취소된 경우‘거래 취소’로 상태가 표기됩니다.</p>
                            </div>
                        </div>
                    </div>
                    <div id="guide14" class="guide_con mt-5 px-5 text-sm font-medium overflow-y-auto hidden">
                        <div class="flex items-center jutstify-between gap-3">
                            <span class="line_guide"></span>
                            <p class="text-primary text-xl font-bold shrink-0">내 정보 수정</p>
                            <span class="line_guide"></span>
                        </div>
                        <ul class="guide_list mt-5">
                            <li class="ml-3">
                                하단 내비게이션 바의 [마이올펀] > 계정 관리 메뉴에서 내 정보를 수정하실 수 있습니다.
                            </li>
                            <li class="ml-3 mt-3">
                                사업자 등록 번호, 업체명, 대표자명은 고객센터 문의를 통해 변경 요청해주세요.
                            </li>
                            <li class="ml-3 mt-3">
                                휴대폰 번호와 사업자 주소는 직접 수정이 가능합니다.
                            </li>
                        </ul>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance14-1.png">
                        </div>
                    </div>
                    <div id="guide15" class="guide_con mt-5 px-5 text-sm font-medium overflow-y-auto hidden">
                        <div class="flex items-center jutstify-between gap-3">
                            <span class="line_guide"></span>
                            <p class="text-primary text-xl font-bold shrink-0">직원 계정 추가</p>
                            <span class="line_guide"></span>
                        </div>
                        <ul class="guide_list mt-5">
                            <li class="ml-3">
                                하단 내비게이션 바의 [마이올펀] > 계정 관리 메뉴에서 직원 계정을 추가하실 수 있습니다.
                            </li>
                        </ul>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance15-1.png">
                        </div>
                        <div class="flex gap-2 px-16 text-xs">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">1</p>
                            <p>하단의 <span class="text-primary">[계정 추가]</span>버튼을 눌러주세요.</p>
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">2</p>
                            <p>이름, 휴대폰 번호, 아이디, 비밀번호를 입력하고 <span class="text-primary">[완료]</span>버튼을 눌러주세요.</p>
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">3</p>
                            <p>최대 5명까지 추가 가능하며, 생성한 직원 계정의 아이디와 비밀번호는 직접 공유해주시면 됩니다.</p>
                        </div>
                    </div>
                    <div id="guide16" class="guide_con mt-5 px-5 text-sm font-medium overflow-y-auto hidden">
                        <div class="flex items-center jutstify-between gap-3">
                            <span class="line_guide"></span>
                            <p class="text-primary text-xl font-bold shrink-0">정회원 승격 요청</p>
                            <span class="line_guide"></span>
                        </div>
                        <ul class="guide_list mt-5">
                            <li class="ml-3">
                                하단 내비게이션 바의 [마이올펀] > 계정 관리 메뉴에서 정회원 승격을 요청하실 수 있습니다.
                            </li>
                        </ul>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance16-1.png">
                        </div>
                        <div class="flex gap-2 px-16 text-xs">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">1</p>
                            <p>하단의 <span class="text-primary">[정회원 승격 요청]</span>버튼을 눌러주세요.</p>
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">2</p>
                            <p>활동하고자 하는 정회원 구분을 선택해주세요.</p>
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">3</p>
                            <p>정회원 승격에 필요한 회원 정보를 입력해주세요.</p>
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">4</p>
                            <p>정회원 승격 요청 완료 후, 승인 문자를 확인하고 동일한 이메일로 로그인해주시면 됩니다.</p>
                        </div>
                    </div>
                    <div id="guide17" class="guide_con mt-5 px-5 text-sm font-medium overflow-y-auto hidden">
                        <div class="flex items-center jutstify-between gap-3">
                            <span class="line_guide"></span>
                            <p class="text-primary text-xl font-bold shrink-0">올펀 문의하기</p>
                            <span class="line_guide"></span>
                        </div>
                        <ul class="guide_list mt-5">
                            <li class="ml-3">
                                하단 내비게이션 바의 [마이올펀] > 계정 관리 메뉴에서 정회원 승격을 요청하실 수 있습니다.
                            </li>
                        </ul>
                        <div>
                            <img src="https://all-furn.com/images/guidance/guidance17-1.png">
                        </div>
                        <div class="flex gap-2 px-16 text-xs">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">1</p>
                            <p>고객센터 <span class="text-primary">[1:1 문의하기]</span>버튼을 눌러주세요.</p>
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">2</p>
                            <p>문의 유형을 선택해주시고 문의할 내용을 입력해주세요.</p>
                        </div>
                        <div class="flex gap-2 px-16 text-xs mt-3">
                            <p class="flex items-cetner justify-center w-[20px] h-[20px] bg-stone-800 rounded-full text-white text-sm shrink-0">3</p>
                            <p>하단 <span class="text-primary">[문의하기]</span>버튼을 눌러 문의를 완료해주세요.</p>
                        </div>
                    </div>
                    <div id="guide18" class="guide_con mt-5 px-5 text-sm font-medium overflow-y-auto hidden">
                        <div class="flex items-center jutstify-between gap-3">
                            <span class="line_guide"></span>
                            <p class="text-primary text-xl font-bold shrink-0">기타 회원 권한</p>
                            <span class="line_guide"></span>
                        </div>
                        <ul class="guide_list mt-5">
                            <li class="ml-3">
                                해당 이용 가이드는 정회원 도매 기준으로 작성된 것으로, 정회원 소매 및 일반 회원의 기능과 다르거나 권한이 없을 수 있습니다.
                            </li>
                            <li class="ml-3 mt-3">
                                상품 등록 및 관리, 거래 기능은 도매 회원만 사용 가능합니다.
                            </li>
                            <li class="ml-3 mt-3">
                                일반 회원의 경우, 사업자 미등록으로 도소매 플랫폼 특성상 주문이나 문의 관련 기능에 제약이 있습니다. 정상적인 올펀 서비스 이용을 원하시면 하단 내비게이션 바의 [마이올펀] > 계정 관리에서 정회원 승격 요청을 진행해주세요.
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="flex justify-center mt-8">
                    <button class="btn btn-primary w-full" onclick="modalClose('#writing_guide_modal')">확인</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 옵션 순서 변경 모달-->
<div class="modal" id="change_order_modal">
    <div class="modal_bg" onclick="modalClose('#change_order_modal')"></div>
    <div class="modal_inner modal-md" style="width:480px;">
        <div class="modal_body filter_body">
            <div class="py-2">
                <p class="text-lg font-bold text-left">옵션 순서 변경</p>
                <div class="mt-5 com_setting">
                    <div class="info">
                        <div class="flex items-start gap-2">
                            <img class="w-4 mt-1" src="/img/member/info_icon.svg" alt="">
                            <p>필수 옵션의 경우, 주문 시 상위 옵션을 선택해야 하위 옵션 선택이 가능합니다. 상위 개념의 옵션을 앞 순서로 설정해주세요.</p>
                        </div>
                    </div>
                    <div class="h-[240px] overflow-y-auto ">
                        <ul id="sortable">
                            <li class="ui-state-default">
                                <div class="flex items-center gap-3 border-b py-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list"><line x1="8" x2="21" y1="6" y2="6"/><line x1="8" x2="21" y1="12" y2="12"/><line x1="8" x2="21" y1="18" y2="18"/><line x1="3" x2="3.01" y1="6" y2="6"/><line x1="3" x2="3.01" y1="12" y2="12"/><line x1="3" x2="3.01" y1="18" y2="18"/></svg>
                                    <p>(필수): </p>
                                    <p></p>
                                </div>
                            </li>
                            <li class="ui-state-default">
                                <div class="flex items-center gap-3 border-b py-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list"><line x1="8" x2="21" y1="6" y2="6"/><line x1="8" x2="21" y1="12" y2="12"/><line x1="8" x2="21" y1="18" y2="18"/><line x1="3" x2="3.01" y1="6" y2="6"/><line x1="3" x2="3.01" y1="12" y2="12"/><line x1="3" x2="3.01" y1="18" y2="18"/></svg>
                                    <p>(필수): </p>
                                    <p></p>
                                </div>
                            </li>
                            <li class="ui-state-default">
                                <div class="flex items-center gap-3 border-b py-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list"><line x1="8" x2="21" y1="6" y2="6"/><line x1="8" x2="21" y1="12" y2="12"/><line x1="8" x2="21" y1="18" y2="18"/><line x1="3" x2="3.01" y1="6" y2="6"/><line x1="3" x2="3.01" y1="12" y2="12"/><line x1="3" x2="3.01" y1="18" y2="18"/></svg>
                                    <p>(필수): </p>
                                    <p></p>
                                </div>
                            </li>
                            <li class="ui-state-default">
                                <div class="flex items-center gap-3 border-b py-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list"><line x1="8" x2="21" y1="6" y2="6"/><line x1="8" x2="21" y1="12" y2="12"/><line x1="8" x2="21" y1="18" y2="18"/><line x1="3" x2="3.01" y1="6" y2="6"/><line x1="3" x2="3.01" y1="12" y2="12"/><line x1="3" x2="3.01" y1="18" y2="18"/></svg>
                                    <p>(필수): </p>
                                    <p></p>
                                </div>
                            </li>
                            <li class="ui-state-default">
                                <div class="flex items-center gap-3 border-b py-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list"><line x1="8" x2="21" y1="6" y2="6"/><line x1="8" x2="21" y1="12" y2="12"/><line x1="8" x2="21" y1="18" y2="18"/><line x1="3" x2="3.01" y1="6" y2="6"/><line x1="3" x2="3.01" y1="12" y2="12"/><line x1="3" x2="3.01" y1="18" y2="18"/></svg>
                                    <p>(필수): </p>
                                    <p></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="flex justify-center mt-8">
                    <button class="btn btn-primary w-full" onclick="modalClose('#change_order_modal')">변경 완료</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 마이페이지 상품 미리보기 모달 -->
<div class="modal" id="state_preview_modal">
    <div class="modal_bg" onclick="modalClose('#state_preview_modal')"></div>
    <div class="modal_inner inner_full">
        <button class="close_btn" onclick="modalClose('#state_preview_modal')"><svg><use xlink:href="/img/m/icon-defs.svg#x"></use></svg></button>
        <div class="modal_body fix_full state_preview_body">
            <div class="p-4">
                <p class="text-lg font-bold text-center">미리보기</p>
            </div>
            <div class="overflow-y-scroll" style="height:calc(100vh - 116px); padding-bottom:70px; ">
                <div class="prod_detail_top">
                    <div class="inner">
                        <div class="img_box">
                            <div class="big_thumb">
                                <ul class="swiper-wrapper">
                                    <li class="swiper-slide"><img src="/img/zoom_thumb.png" alt=""></li>
                                    <li class="swiper-slide"><img src="/img/prod_thumb4.png" alt=""></li>
                                    <li class="swiper-slide"><img src="/img/prod_thumb5.png" alt=""></li>
                                    <li class="swiper-slide"><img src="/img/prod_thumb.png" alt=""></li>
                                    <li class="swiper-slide"><img src="/img/prod_thumb2.png" alt=""></li>
                                    <li class="swiper-slide"><img src="/img/prod_thumb3.png" alt=""></li>
                                    <li class="swiper-slide"><img src="/img/sale_thumb.png" alt=""></li>
                                    <li class="swiper-slide"><img src="/img/video_thumb.png" alt=""></li>
                                    <li class="swiper-slide"><img src="/img/prod_thumb2.png" alt=""></li>
                                </ul>
                            </div>
                        </div>
                        <div class="txt_box">
                            <div class="name">
                                <div class="tag">
                                    <span class="new">NEW</span>
                                    <span class="event">이벤트</span>
                                </div>
                                <h4>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</h4>
                            </div>
                            <div class="info">
                                <p>업체 문의</p>
                                <hr>
                                <div>
                                    <dl class="flex">
                                        <dt class="text-stone-400 w-[130px]">상품 코드</dt>
                                        <dd>FORMA</dd>
                                    </dl>
                                </div>
                                <div class="mt-3">
                                    <dl class="flex">
                                        <dt class="text-stone-400 w-[130px]">판매자 상품번호</dt>
                                        <dd>A01A17MIZPWR</dd>
                                    </dl>
                                </div>
                                <div class="mt-3">
                                    <dl class="flex">
                                        <dt class="text-stone-400 w-[130px]">상품 승인 일자</dt>
                                        <dd>2022.12.05</dd>
                                    </dl>
                                </div>
                                <div class="link_box">
                                    <button class="btn btn-line4 nohover zzim_btn"><svg><use xlink:href="/img/m/icon-defs.svg#zzim"></use></svg>좋아요</button>
                                    <button class="btn btn-line4 nohover"><svg><use xlink:href="/img/m/icon-defs.svg#share"></use></svg>공유하기</button>
                                    {{-- <button class="btn btn-line4 nohover inquiry"><svg><use xlink:href="/img/m/icon-defs.svg#inquiry"></use></svg>문의 하기</button> --}}
                                </div>
                            </div>
                            <div class="btn_box">
                                <button class="btn btn-primary-line phone" onclick="modalOpen('#company_phone-modal')"><svg class="w-5 h-5"><use xlink:href="/img/m/icon-defs.svg#phone"></use></svg>전화번호 확인</button>
                                <button class="btn btn-primary"><svg class="w-5 h-5"><use xlink:href="/img/m/icon-defs.svg#estimate"></use></svg>견적서 받기</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-10 flex justify-center product-detail__img-area">
                    <img src="https://allfurn-dev.s3.ap-northeast-2.amazonaws.com/user/94ea02e8fa3632d09bcdd99c39c5cf3d41f2fd7d2d58366731548efbd9202d48.jpg" alt="">
                </div>
            </div>
            <div class="flex justify-center py-2">
                <button class="btn btn-primary w-1/4" onclick="modalClose('#state_preview_modal')">확인</button>
            </div>
        </div>
    </div>
</div>

{{-- 상품 임시 등록 팝업 --}}
<div class="modal" id="product_temp_save_modal">
    <div class="modal_bg" onclick="modalClose('#product_temp_save_modal')"></div>
    <div class="modal_inner modal-sm">
        <button class="close_btn" onclick="modalClose('#product_temp_save_modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body agree_modal_body">
            <p class="text-center py-4"><b>임시 등록되었습니다.</b></p>
            <div class="flex gap-2 justify-center">
                <button class="btn btn-primary w-1/2 mt-5" onclick="location.href='/mypage/product?order=DESC';">확인</button>
            </div>
        </div>
    </div>
</div>

{{-- 상품 등록 신청 팝업 --}}
<div class="modal" id="product_save_modal">
    <div class="modal_bg" onclick="modalClose('#product_save_modal')"></div>
    <div class="modal_inner modal-sm">
        <button class="close_btn" onclick="modalClose('#product_save_modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body agree_modal_body">
            <p class="text-center py-4"><b>상품 등록 신청이 완료되었습니다.<br />등록 승인 결과는 푸시 알림으로 발송됩니다.</b></p>
            <div class="flex gap-2 justify-center">
                <button class="btn btn-primary w-1/2 mt-5" onclick="location.href='/mypage/product?order=DESC';">확인</button>
            </div>
        </div>
    </div>
</div>

{{-- 상품 수정 완료 팝업 --}}
<div class="modal" id="product_update_modal">
    <div class="modal_bg" onclick="modalClose('#product_update_modal')"></div>
    <div class="modal_inner modal-sm">
        <button class="close_btn" onclick="modalClose('#product_update_modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body agree_modal_body">
            <p class="text-center py-4"><b>상품 수정이 완료되었습니다.</b></p>
            <div class="flex gap-2 justify-center">
                <button class="btn btn-primary w-1/2 mt-5" onclick="location.href='/mypage/product?order=DESC';">확인</button>
            </div>
        </div>
    </div>
</div>