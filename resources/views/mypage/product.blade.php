<div class="w-full">
    <div class="flex justify-between">
        <h3 class="text-xl font-bold">상품 등록 관리</h3>
    </div>

    <div class="flex items-center mt-5 my_like_tab_wrap gap-4 border-b border-slate-200">
        <button class="my_like_tab py-2 text-gray-400 {{ request() -> get('type') !== 'temp' ? 'active' : '' }}" data-target="section01" onClick="location.href='/mypage/product?order=DESC'">
            <span>등록({{ $register_count }})</span>
        </button>
        <button class="my_like_tab py-2 flex items-center text-gray-400 {{ request() -> get('type') === 'temp' ? 'active' : '' }}" data-target="section02" onClick="location.href='/mypage/product?type=temp&order=DESC'">
            <span>임시등록({{ $temp_register_count }})</span>
        </button>
    </div>

    <div class="mt-4">
        <div class="sub_filter w-full">
            <div class="filter_box w-full justify-between">
                <div class="flex gap-2">
                    @if(request() -> get('type') !== 'temp')
                    <button class="section02_del {{ request() -> get('state') ? 'on' : '' }}" onClick="modalOpen('#product_status_modal')">{{ request() -> get('state') ? config('constants.PRODUCT_STATUS')[request() -> get('state')] : '상품 상태' }}</button>
                    @endif
                    <button class="{{ !empty($checked_categories) ? 'on' : '' }}" onClick="modalOpen('#filter_category-modal')">
                        카테고리
                        @if(!empty($checked_categories))
                        <b>{{ count($checked_categories) }}</b>
                        @endif
                    </button>
                    <button class="order_filter">최근 등록순</button>
                </div>
                <div class="setting_input w-[300px] h-[48px] flex items-center justify-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search text-gray-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <input type="text" name="keyword" id="keyword" class="w-full" value="{{ request() -> get('keyword') }}" placeholder="검색어를 입력해주세요." />
                </div>
            </div>
        </div>
        @if(!empty($checked_categories))
        <div class="sub_filter_result">
            <div class="filter_on_box">
                <div class="category">
                    @foreach($checked_categories as $category)
                    <span>
                        {{ $category }}
                        <button data-category="{{ $category }}" onClick="removeCheckedCategoryBtn(this);">
                            <svg><use xlink:href="/img/icon-defs.svg#x"></use></svg>
                        </button>
                    </span>
                    @endforeach
                </div>
            </div>
            <button class="refresh_btn" onClick="refreshCheckedCategories();">초기화<svg><use xlink:href="/img/icon-defs.svg#refresh"></use></svg></button>
        </div>
        @endif
    </div>

    <div id="section01" class="my_like_tab_section pt-5" style="display: block;">
        @if(request() -> get('type') !== 'temp')
            @if (count($represents) < 1 && count($list) < 1 && request() -> get('keyword'))
            <div class="flex items-center pb-8 justify-between border-b-2 border-stone-900 mb-8">
                <h3 class="font-medium">추천 상품</h3>
            </div>
            <ul>
                <li class="no_prod txt-gray">
                    '{{ request() -> get('keyword') }}' 검색 결과에 해당하는 추천 상품이 없습니다.
                </li>
            </ul>
            @else
            <div>
                @if (count($represents) < 1)
                <div class="flex items-center pb-8 justify-between border-b-2 border-stone-900 mb-8">
                    <h3 class="font-medium">추천 상품 <span class="text-sm text-gray-400"></span></h3>
                </div>
                    @if (request() -> get('keyword'))
                    <ul>
                        <li class="no_prod txt-gray">
                            '{{ request() -> get('keyword') }}' 검색 결과에 해당하는 추천 상품이 없습니다.
                        </li>
                    </ul>
                    @else
                    <ul>
                        <li class="no_prod txt-gray">
                            추천 상품을 선택해주세요.
                        </li>
                    </ul>
                    @endif
                @else
                <div class="flex items-center pb-8 justify-between border-b-2 border-stone-900 mb-8">
                    <h3 class="font-medium">추천 상품 <span class="text-sm text-gray-400">(최대 5개)</span></h3>
                </div>
                <ul>
                    @foreach($represents as $represent)
                    <li class="pb-10">
                        <div class="flex items-center gap-8">
                            <div class="w-[216px] h-[216px] rounded-md overflow-hidden shrink-0 relative">
                                <button class="state_preview" onclick="modalProductPreview({{ $represent->idx }}, false)">
                                    <img src="{{ $represent -> product_image }}" alt="item03" />
                                </button>
                            </div>
                            <div class="flex flex-col w-full">
                                <div class="flex items-center justify-between pb-4 mb-4 border-b">
                                    <span class="text-sm px-2 py-0.5 rounded-sm bg-primary text-white font-medium">{{ config('constants.PRODUCT_STATUS')[$represent -> state] }}</span>
                                    <button type="button" class="recommend-btn" data-represent-id="{{ $represent -> idx }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="change_btn lucide lucide-star text-stone-400 active"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                    </button>
                                </div>
                                <div class="flex items-start">
                                    <div class="w-full">
                                        <div class="flex items-center gap-1 text-stone-500">
                                            <span>{{ $represent -> parent_category }}</span>
                                            <span>></span>
                                            <span>{{ $represent -> child_category }}</span>
                                        </div>
                                        <div class="text-lg">{{ $represent -> name }}</div>
                                    </div>
                                    <div class="flex items-center gap-2 shrink-0 text-stone-500">
                                        <a href="/product/modify/{{ $represent -> idx }}{{ Request::getQueryString() ? '?'.Request::getQueryString() : '' }}">수정</a>
                                        <span>|</span>
                                        <button type="button" onClick="deleteProductModal({{ $represent -> idx }})">삭제</button>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between py-2.5 bg-stone-100 rounded-md mt-16">
                                    <div class="w-full text-center text-sm font-medium">관심 {{ $represent -> interest_product_count }}</div>
                                    <div class="w-full text-center text-sm font-medium">문의 {{ $represent -> inquiry_count }}</div>
                                    <div class="w-full text-center text-sm font-medium">진입 {{ $represent -> access_count }}</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
            @endif
        @endif

        <div class="mt-9">
            <div class="flex items-center pb-8 justify-between border-b-2 border-stone-900 mb-8">
                <h3 class="font-medium">전체</h3>
            </div>
            @if ($count < 1)
                @if (request() -> get('keyword'))
                <ul>
                    <li class="no_prod txt-gray">
                        '{{ request() -> get('keyword') }}' 검색 결과에 해당하는 상품이 없습니다.
                    </li>
                </ul>
                @else
                <ul>
                    <li class="no_prod txt-gray">
                        상품을 등록해주세요.
                    </li>
                    <li class="no_prod txt-gray" style="text-align:right;">
                        <button type="button" class="text-m px-3 py-2 rounded bg-primary text-white font-medium" onClick="location.href='/product/registration'"><b>상품 등록하기</b></button>
                    </li>
                </ul>
                @endif
            @else
                <ul>
                    @if (request() -> get('keyword'))
                    <li class="no_prod txt-gray">
                    '{{ request() -> get('keyword') }}' 검색 결과 총 {{ $count }} 개의 상품
                    </li>
                    <br />
                    @endif
                    @foreach($list as $row)
                    <li class="pb-10">
                        <div class="flex items-center gap-8">
                            <div class="w-[216px] h-[216px] rounded-md overflow-hidden shrink-0 relative">
                                @if (request()->get('type') == 'temp')
                                    <button class="state_preview" onclick="modalProductPreview({{ $row->idx }}, true)">
                                @else 
                                    <button class="state_preview" onclick="modalProductPreview({{ $row->idx }}, false)">
                                @endif 
                                    <img src="{{ $row -> product_image }}" alt="item03" />
                                </button>
                            </div>
                            <div class="flex flex-col w-full">
                                <div class="flex items-center justify-between pb-4 mb-4 border-b">
                                    <span class="text-sm px-2 py-0.5 rounded-sm bg-stone-200 text-stone-500 font-medium">{{ config('constants.PRODUCT_STATUS')[$row -> state] }}</span>
                                    <button type="button" class="recommend-btn" data-represent-id="{{ $row -> idx }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="change_btn lucide lucide-star text-stone-400"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                    </button>
                                </div>
                                <div class="flex items-start">
                                    <div class="w-full">
                                        <div class="flex items-center gap-1 text-stone-500">
                                            <span>{{ $row -> parent_category }}</span>
                                            <span>></span>
                                            <span>{{ $row -> child_category }}</span>
                                        </div>
                                        <div class="text-lg">{{ $row -> name }}</div>
                                    </div>
                                    <div class="flex items-center gap-2 shrink-0 text-stone-500">
                                        <button onClick="changeStatsModal({{ $row -> idx }}, '{{ $row -> state }}');">상태 변경</button>
                                        <span>|</span>
                                        @if (request()->get('type') == 'temp')
                                            <a href="/product/registration?temp={{ $row -> idx }}">수정</a>
                                        @else 
                                            <a href="/product/modify/{{ $row -> idx }}{{ Request::getQueryString() ? '?'.Request::getQueryString() : '' }}">수정</a>
                                        @endif 
                                        <span>|</span>
                                        <button type="button" onClick="deleteProductModal({{ $row -> idx }})">삭제</button>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between py-2.5 bg-stone-100 rounded-md mt-16">
                                    <div class="w-full text-center text-sm font-medium">관심 {{ $row -> interest_product_count }}</div>
                                    <div class="w-full text-center text-sm font-medium">문의 {{ $row -> inquiry_count }}</div>
                                    <div class="w-full text-center text-sm font-medium">진입 {{ $row -> access_count }}</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                <div class="pagenation flex items-center justify-center py-12">
                    @if($pagination['prev'] > 0)
                    <button type="button" id="prev-paginate" class="prev" onClick="moveToList({{$pagination['prev']}});">
                        <svg width="7" height="12" viewBox="0 0 7 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 1L1 6L6 11" stroke="#DBDBDB" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>시
                    @endif
                    @foreach($pagination['pages'] as $paginate)
                        @if ($paginate == $offset)
                            <a href="javascript: void(0);" class="active" onClick="moveToList({{$paginate}});">{{$paginate}}</a>
                        @else
                            <a href="javascript: void(0);" onClick="moveToList({{$paginate}});">{{$paginate}}</a>
                        @endif
                    @endforeach
                    @if($pagination['next'] > 0)
                    <button type="button" id="next-paginate" class="next" onClick="moveToList({{$pagination['next']}});">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 12L10 7L5 2" stroke="#828282" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<!-- 상품 상태 -->
<div id="product_status_modal" class="modal">
    <div class="modal_bg" onClick="modalClose('#product_status_modal')"></div>
    <div class="modal_inner modal-md">
        <button class="close_btn" onClick="modalClose('#product_status_modal');"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body filter_body">
            <h4>상품 상태</h4>
            <ul class="filter_list radio_area">
                <li>
                    <div class="flex gap-3 items-center ml-1">
                        <input type="radio" name="state[]" id="product_state01" class="checkbox__checked" value="W" {{ in_array('W', $checked_state) ? 'checked' : '' }} />
                        <label for="product_state01">승인 대기</label>
                    </div>
                </li>
                <li>
                    <div class="flex gap-3 items-center ml-1">
                        <input type="radio" name="state[]" id="product_state02" class="checkbox__checked" value="S" {{ in_array('S', $checked_state) ? 'checked' : '' }} />
                        <label for="product_state02">판매중</label>
                    </div>
                </li>
                <li>
                    <div class="flex gap-3 items-center ml-1">
                        <input type="radio" name="state[]" id="product_state03" class="checkbox__checked" value="O" {{ in_array('O', $checked_state) ? 'checked' : '' }} />
                        <label for="product_state03">품절</label>
                    </div>
                </li>
                <li>
                    <div class="flex gap-3 items-center ml-1">
                        <input type="radio" name="state[]" id="product_state04" class="checkbox__checked" value="H" {{ in_array('H', $checked_state) ? 'checked' : '' }} />
                        <label for="product_state04">숨김</label>
                    </div>
                </li>
                <li>
                    <div class="flex gap-3 items-center ml-1">
                        <input type="radio" name="state[]" id="product_state05" class="checkbox__checked" value="C" {{ in_array('C', $checked_state) ? 'checked' : '' }} />
                        <label for="product_state05">판매 중지</label>
                    </div>
                </li>
                <li>
                    <div class="flex gap-3 items-center ml-1">
                        <input type="radio" name="state[]" id="product_state06" class="checkbox__checked" value="R" {{ in_array('R', $checked_state) ? 'checked' : '' }} />
                        <label for="product_state06">반려</label>
                    </div>
                </li>
            </ul>
            <div class="btn_bot" style="width: 100%;">
                <button class="btn btn-primary" style="width: 100%;" onClick="getList('state');">선택완료</button>
            </div>
        </div>
    </div>
</div>
<iframe id="productPreviewModal" src="about:blank" width="0" height="0"></iframe>

<!-- 카테고리 -->
<div id="filter_category-modal" class="modal">
    <div class="modal_bg" onClick="modalClose('#filter_category-modal');"></div>
    <div class="modal_inner modal-md">
        <button class="close_btn" onClick="modalClose('#filter_category-modal');"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body filter_body">
            <h4>카테고리 선택</h4>
            <ul class="filter_list">
                @foreach($categories as $category)
                <li>
                    <input type="checkbox" id="category-check{{ $category -> idx }}" class="check-form" name="category_check[]" value="{{ $category -> name }}" class="checkbox__checked" {{ in_array($category -> name, $checked_categories) ? 'checked' : '' }} />
                    <label for="category-check{{ $category -> idx }}">{{ $category -> name }}</label>
                </li>
                @endforeach
            </ul>
            <div class="btn_bot">
                <button class="btn btn-line3 refresh_btn" onClick="refreshHandle(this);"><svg><use xlink:href="/img/icon-defs.svg#refresh"></use></svg>초기화</button>
                <button class="btn btn-primary" onClick="getList('categories');">상품 찾아보기</button>
            </div>
        </div>
    </div>
</div>

<!-- 미리보기 -->
<div id="state_preview_modal" class="modal">
    <div class="modal_bg" onClick="modalClose('#state_preview_modal')"></div>
    <div class="modal_inner modal-md" style="width: 1340px;">
        <div class="modal_body filter_body" style="max-height: inherit;">
            <div class="py-2">
                <p class="text-lg font-bold text-left">미리보기</p>
            </div>
            <div class="overflow-y-scroll h-[600px]">
                <div class="prod_detail_top">
                    <div class="inner">
                        <div class="img_box">
                            <div class="left_thumb">
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
                                    <button class="btn btn-line4 nohover zzim_btn"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg>좋아요</button>
                                    <button class="btn btn-line4 nohover"><svg><use xlink:href="/img/icon-defs.svg#share"></use></svg>공유하기</button>
                                    <button class="btn btn-line4 nohover inquiry"><svg><use xlink:href="/img/icon-defs.svg#inquiry"></use></svg>문의 하기</button>
                                </div>
                            </div>
                            <div class="btn_box">
                                <button class="btn btn-primary-line phone" onclick="modalOpen('#company_phone-modal')"><svg class="w-5 h-5"><use xlink:href="/img/icon-defs.svg#phone"></use></svg>전화번호 확인하기</button>
                                <button class="btn btn-primary"><svg class="w-5 h-5"><use xlink:href="/img/icon-defs.svg#estimate"></use></svg>견적서 받기</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-10 flex justify-center">
                    <img src="https://allfurn-dev.s3.ap-northeast-2.amazonaws.com/user/94ea02e8fa3632d09bcdd99c39c5cf3d41f2fd7d2d58366731548efbd9202d48.jpg" alt="">
                </div>
            </div>
            
            <div class="flex justify-center">
                <button class="btn btn-primary w-1/4 mt-8" onclick="modalClose('#state_preview_modal')">확인</button>
            </div> 
        </div>
    </div>
</div>

<div id="status_change_modal" class="modal">
    <div class="modal_bg" onClick="modalClose('#status_change_modal');"></div>
    <div class="modal_inner modal-md" style="width: 500px;">
        <div class="modal_body filter_body">
            <div class="py-2">
                <p class="text-lg font-bold text-left">상품 상태 변경</p>
                <div class="flex flex-wrap state_change_radio gap-3 pt-8">
                    <div class="item">
                        <input type="radio" name="product-status" id="state01" value="S" />
                        <label for="state01" class="block px-3 py-2 rounded-md text-base font-meduim text-center">판매중</label>
                    </div>
                    <div class="item">
                        <input type="radio" name="product-status" id="state02" value="O" />
                        <label for="state02" class="block px-3 py-2 rounded-md text-base font-meduim text-center">품절</label>
                    </div>
                    <div class="item">
                        <input type="radio" name="product-status" id="state03" value="H" />
                        <label for="state03" class="block px-3 py-2 rounded-md text-base font-meduim text-center">숨김</label>
                    </div>
                    <div class="item">
                        <input type="radio" name="product-status" id="state04" value="C" />
                        <label for="state04" class="block px-3 py-2 rounded-md text-base font-meduim text-center">판매 중지</label>
                    </div>
                </div>
                <div class="flex justify-center">
                    <button id="confirmChangeStatueBtn" class="btn btn-primary w-full mt-8" data-idx="" onClick="changeState();">완료</button>
                </div> 
            </div>
        </div>
    </div>
</div>

<div id="alert-modal01" class="modal">
    <div class="alert-modal__container">
        <div class="alert-modal__top">
            <p>
                해당 상태값으로 변경하시면, 서비스에서 상품이<br />
                미노출 처리됩니다. 그래도 변경하시겠습니까?
            </p>
        </div>
        <div class="alert-modal__bottom">
            <div class="button-group">
                <button type="button" class="button button--solid-gray" onClick="closeModal('#alert-modal01');">
                    취소
                </button>
                <button type="button" class="button button--solid" onClick="changeState();">
                    확인
                </button>
            </div>
        </div>
    </div>
</div>

<div id="alert-modal02" class="modal">
    <div class="modal_bg" onClick="modalClose('#alert-modal02');"></div>
    <div class="modal_inner modal-md">
        <div class="modal_body filter_body !p-0">
            <div class="p-8">
                <div class="text-center text-base">
                    현재 거래중인 상품은<br />
                    <span id="changeStateText"></span> 하실 수 없습니다.
                </div>
            </div>
            <div class="flex text-base border-t">
                <button type="button" class="w-full text-primary py-3" onClick="modalClose('#alert-modal02');">확인</button>
            </div>
        </div>
    </div>
</div>

<!-- 상품 삭제 -->
<div id="delete_product_modal" class="modal">
    <div class="modal_bg" onClick="modalClose('#delete_product_modal')"></div>
    <div class="modal_inner modal-md">
        <div class="modal_body filter_body !p-0">
            <div class="p-8">
                <div class="text-center text-base">
                    해당 상품을 삭제하시겠습니까?<br />
                    삭제하신 상품은 복구하실 수 없습니다.
                </div>
            </div>
            <div class="flex text-base border-t">
                <button type="button" class="w-full border-r py-3" onClick="modalClose('#delete_product_modal')">취소</button>
                <button type="button" id="confirmDeleteProductBtn" class="w-full text-primary py-3" data-idx="" onClick="deleteProduct();">확인</button>
            </div>
        </div>
    </div>
</div>





<script>
    const removeCheckedCategoryBtn = elem => {
        const params = getParams();
        const categories = params['categories'].split(',');

        categories.splice(categories.indexOf(elem.dataset.category), 1);
        params['categories'] = categories;

        location.href = '/mypage/product?' + new URLSearchParams(params);
    }

    const refreshCheckedCategories = () => {
        const params = getParams();
        delete params['categories'];

        location.href = '/mypage/product?' + new URLSearchParams(params);
    }

    const getParams = () => {
        const params = {};
        const urlSearch = new URLSearchParams(location.search);

        urlSearch.get('state') ? params.state = urlSearch.get('state') : '';
        urlSearch.get('categories') ? params.categories = urlSearch.get('categories') : '';
        urlSearch.get('order') ? params.order = urlSearch.get('order') : '';
        urlSearch.get('type') ? params.type = urlSearch.get('type') : '';
        urlSearch.get('keyword') ? params.keyword = urlSearch.get('keyword') : '';

        return params;
    }

    const getList = paramsType => {
        const params = getParams();
        delete params[paramsType];

        const urlSearch = new URLSearchParams(location.search);
        urlSearch.get('order') ? params.order = urlSearch.get('order') : '';

        switch(paramsType) {
            case 'state':
                let stateArr = [];

                const checkedState = document.querySelectorAll('[name*=state]:checked');
                for(const state of checkedState) stateArr.push(state.value);

                if (stateArr) params['state'] = stateArr;
                break;
            case 'categories':
                let cateArr = [];

                const checkedCategories = document.querySelectorAll('[name*=category_check]:checked');
                for(const category of checkedCategories) cateArr.push(category.value);

                if (cateArr) params['categories'] = cateArr;
                break;
            case 'order':
                if (params.order === 'DESC') params['order'] = 'ASC';
                else params['order'] = 'DESC';

                break;
        }

        location.href = '/mypage/product?' + new URLSearchParams(params);
    }

    const moveToList = page => {
        const params = getParams();
        params['offset'] = page;

        location.href = '/mypage/product?' + new URLSearchParams(params);
    }

    document.querySelectorAll('.recommend-btn').forEach(elem => {
        elem.addEventListener('click', e => {
            e.preventDefault();
            e.stopPropagation();

            const idx = elem.dataset.representId;
            fetch('/mypage/represent/product/' + idx, {
                method  : 'PUT',
                headers : {
                    'X-CSRF-TOKEN'  : '{{csrf_token()}}'
                }
            }).then(response => {
                if (response.ok) {
                    return response.json();
                }

                throw new Error('Sever Error');
            }).then(json => {
                if (json.result === 'success') {
                    location.reload();
                } else {
                    alert(json.message);
                }
            }).catch(error => {
                alert('일시적인 오류로 처리되지 않았습니다.');
            })
        });
    });

    const changeStatsModal = (idx, state) => {
        if (state === 'W') {
            document.getElementById('changeStateText').textContent = '상태 변경';
            modalOpen('#alert-modal02');

            return false;
        }

        document.querySelectorAll('[name=product-status]').forEach(elem => {
            if(elem.value == state) {
                elem.checked = true;
                return false;
            }
        });

        document.getElementById('confirmChangeStatueBtn').dataset.idx = idx;
        modalOpen('#status_change_modal');
    }

    const getProductStateText = state => {
        let statusText = '';
        switch(state) {
            case 'W':
                statusText = '승인대기';
                break;
            case 'R':
                statusText = '반려';
                break;
            case 'O':
                statusText = '품절';
                break;
            case 'S':
                statusText = '판매중';
                break;
            case 'H':
                statusText = '숨김';
                break;
            case 'C':
                statusText = '판매중지'
                break;
        }

        return statusText;
    }

    const changeState = () => {
        const idx = document.getElementById('confirmChangeStatueBtn').dataset.idx;
        const state = document.querySelector('[name=product-status]:checked').value;
        const statusText = getProductStateText(state);

        fetch('/mypage/product/state/', {
            method  : 'PUT',
            headers : {
                'Content-Type'  : 'application/json',
                'X-CSRF-TOKEN'  : '{{csrf_token()}}'
            },
            body    : JSON.stringify({
                idx     : idx,
                state   : state
            })
        }).then(response => {
            return response.json();
        }).then(json => {
            if (json.result === 'success') {
                if (json.code === 'SUCCESS_STATE_CHANGE') {
                    location.reload();
                } else if (json.code.indexOf('FAIL_STATE_') === 0) {
                    document.getElementById('changeStateText').textContent = "'" + statusText + "'";
                    modalOpen('#alert-modal02');
                }
            } else {
                alert(json.message);
            }
        });
    }

    const deleteProductModal = idx => {
        document.getElementById('confirmDeleteProductBtn').dataset.idx = idx;
        modalOpen('#delete_product_modal');
    }

    const deleteProduct = () => {
        var proc = "{{request()->get('type')}}"; 
        if (proc == "temp"){
            var fetchUrl = '/mypage/product-temp/';
        }else{
            var fetchUrl = '/mypage/product/';
        }
        const idx = document.getElementById('confirmDeleteProductBtn').dataset.idx;
        fetch(fetchUrl + idx, {
            method  : 'DELETE',
            headers : {
                'X-CSRF-TOKEN'  : '{{csrf_token()}}'
            }
        }).then(response => {
            location.reload();
        })
    }

    document.getElementById('keyword').addEventListener('keyup', e => {
        if (e.key === 'Enter') {
            const params = getParams();
            params['keyword'] = e.currentTarget.value;

            location.href = '/mypage/product?' + new URLSearchParams(params);
        }
    })

    const modalProductPreview = (idx, temp) => {
        $('#loadingContainer').show();
        if (temp === true) {
            document.getElementById('productPreviewModal').src = '/product/registration?temp=' + idx;
        } else {
            document.getElementById('productPreviewModal').src = '/product/modify/' + idx;
        }
        $('#productPreviewModal').on( 'load', function() {
            document.getElementById('productPreviewModal').contentWindow.document.getElementById('previewBtn').click();
            document.querySelector('#state_preview_modal .modal_body').innerHTML =
                document.querySelector('#productPreviewModal').contentWindow.document.getElementById('state_preview_modal').innerHTML;
            $('#loadingContainer').hide();
            modalOpen('#state_preview_modal');
        });
    }


    
    $(document).ready(function(){
        const urlSearch = new URLSearchParams(location.search);
        
        if(urlSearch.get('order') === 'ASC') {
            $('.order_filter').text('등록순');
        } else {
            $('.order_filter').text('최근 등록순');
        }

        $(document).on('click', '.order_filter', function() {
            getList('order');
        });
    });
</script>