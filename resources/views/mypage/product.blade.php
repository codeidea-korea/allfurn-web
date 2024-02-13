<div class="my__section">
    <div class="content">
        <div class="section">
            <div class="section__head" style="margin-bottom: 0;">
                <h3 class="section__title">상품 관리</h3>
            </div>
            <div class="section__content">
                <div class="tab tab--type02">
                    <ul class="tab__list">
                        <li>
                            <button class="tab__item" {{ request()->get('type') ? '' : 'aria-selected=true' }} onclick="location.href='/mypage/product/'">
                                등록({{ $register_count }})
                            </button>
                        </li>
                        <li>
                            <button class="tab__item" {{ request()->get('type') === 'temp' ? 'aria-selected=true' : '' }} onclick="location.href='/mypage/product?type=temp'">
                                임시 등록({{ $temp_register_count }})
                            </button>
                        </li>
                    </ul>

                    <div>
                        <div class="set__filter-area">
                            <div class="category-btn-group">
                                @if(request()->get('type') !== 'temp')
                                <div class="category-btn category-btn--01 {{ request()->get('state') ? 'category-btn--active' : '' }}" onclick="openModal('#default-modal01')">
                                    <p class="category-btn__text">{{ request()->get('state') ? config('constants.PRODUCT_STATUS')[request()->get('state')] : '상품상태' }}</p>
                                    <i class="ico__arrow--down14{{ request()->get('state') ? '-red' : '' }}"><span class="a11y">아래 화살표</span></i>
                                </div>
                                @endif
                                <div class="category-btn category-btn--02 {{ !empty($checked_categories) ? 'category-btn--active' : '' }}" onclick="openModal('#default-modal02')">
                                    <p class="category-btn__text">카테고리
                                        @if(!empty($checked_categories))
                                        <span class="category-btn__count">{{ count($checked_categories) }}</span>
                                        @endif
                                    </p>
                                    <i class="ico__arrow--down14{{ !empty($checked_categories) ? '-red' : '' }}"><span class="a11y">아래 화살표</span></i>
                                </div>
                                <div class="category-btn registration-order-btn">
                                    <i class="ico__filter"><span class="a11y">필터</span></i>
                                    <p class="category-btn__text">최근 등록순</p>
                                </div>
                            </div>

                            <div class="textfield" style="width: 400px;">
                                <i class="textfield__icon ico__search"><span class="a11y">검색</span></i>
                                <input type="text" class="textfield__search" name="keyword" id="keyword" value="{{ request()->get('keyword') }}" placeholder="검색어를 입력해주세요." style="width: 400px;">
                                <button type="button" class="textfield__icon--delete ico__sdelete">
                                    <span class="a11y">삭제하기</span>
                                </button>
                            </div>
                        </div>

                        <!-- 카테고리 선택 결과 -->
                        @if(!empty($checked_categories))
                        <div class="category-list category-list--product">
                            <div>
                                <ul class="category-list__wrap">
                                    @foreach($checked_categories as $category)
                                    <li class="category-list__item">
                                        <p class="category-list__name">{{ $category }}</p>
                                        <a href="javascript:void(0);" onclick="removeCheckedCategoryBtn(this)" data-category="{{ $category }}" class="ico__delete16"><span class="a11y">삭제</span></a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="category-list__refresh">
                                <a href="javascript:void(0)" onclick="refreshCheckedCategories()">
                                    <p class="category-list__refresh__text">초기화</p>
                                    <i class="ico__refresh"><span class="a11y">초기화</span></i>
                                </a>
                            </div>
                        </div>
                        @endif

                        <!-- 상품 상태 팝업 -->
                        <div id="default-modal01" class="default-modal default-modal--radio">
                            <div class="default-modal__container">
                                <div class="default-modal__header">
                                    <h2>상품 상태</h2>
                                    <button type="button" class="ico__close28" onclick="closeModal('#default-modal01')">
                                        <span class="a11y">닫기</span>
                                    </button>
                                </div>
                                <div class="default-modal__content">
                                    <ul class="content__list">
                                        <li>
                                            <label>
                                                <input type="radio" name="state[]" {{ in_array('W', $checked_states) ? 'checked' : '' }} class="checkbox__checked" value="W">
                                                <span>승인 대기</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="radio" name="state[]" {{ in_array('S', $checked_states) ? 'checked' : '' }} class="checkbox__checked" value="S">
                                                <span>판매중</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="radio" name="state[]" {{ in_array('O', $checked_states) ? 'checked' : '' }} class="checkbox__checked" value="O">
                                                <span>품절</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="radio" name="state[]" {{ in_array('H', $checked_states) ? 'checked' : '' }} class="checkbox__checked" value="H">
                                                <span>숨김</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="radio" name="state[]" {{ in_array('C', $checked_states) ? 'checked' : '' }} class="checkbox__checked" value="C">
                                                <span>판매 중지</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="radio" name="state[]" {{ in_array('R', $checked_states) ? 'checked' : '' }} class="checkbox__checked" value="R">
                                                <span>반려</span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="default-modal__footer">
                                    <button type="button" onclick="getList('state')" class="button button--solid">선택 완료</button>
                                </div>
                            </div>
                        </div>

                        <!-- 카테고리 팝업 -->
                        <div id="default-modal02" class="default-modal default-modal--category">
                            <div class="default-modal__container">
                                <div class="default-modal__header">
                                    <h2>카테고리 선택</h2>
                                    <button type="button" class="ico__close28" onclick="closeModal('#default-modal02')">
                                        <span class="a11y">닫기</span>
                                    </button>
                                </div>
                                <div class="default-modal__content">
                                    <ul class="content__list">
                                        @foreach($categories as $category)
                                        <li>
                                            <label for="category-check{{ $category->idx }}">
                                                <input type="checkbox" id="category-check{{ $category->idx }}" name="category_check[]" value="{{ $category->name }}" class="checkbox__checked" {{ in_array($category->name, $checked_categories) ? 'checked' : '' }}>
                                                <span>{{ $category->name }}</span>
                                            </label>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="default-modal__footer">
                                    <button type="button" class="button button--blank-gray">
                                        <i class="ico__refresh"><span class="a11y">초기화</span></i>
                                        <p>초기화</p>
                                    </button>
                                    <button type="button" onclick="getList('categories')" class="button button--solid">상품 찾아보기</button>
                                </div>
                            </div>
                        </div>

                        <!-- 미리 보기 팝업 -->
                        <div id="default-modal-preview01" class="default-modal default-modal--preview">
                            <div class="default-modal__container">
                                <div class="default-modal__header">
                                    <h2>미리 보기</h2>
                                    <button type="button" class="ico__close28"
                                            onclick="closeModal('#default-modal-preview01')">
                                        <span class="a11y">닫기</span>
                                    </button>
                                </div>
                                <div class="default-modal__content">
                                </div>
                                <div class="default-modal__footer"></div>
                            </div>
                        </div>

                        <!-- 미리 보기 팝업(상품정보 없음) -->
                        <div id="default-modal-preview02" class="default-modal default-modal--preview preview--none"></div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-content__panel">
                            @if(request()->get('type') !== 'temp')
                            <div class="tab01">
                                @if (count($represents) < 1 && count($list) < 1 && request()->get('keyword'))
                                    <div class="fixed-wrap search-result--none">
                                        <i class="ico__search-circle"><span class="a11y">검색</span></i>
                                        <p>'{{ request()->get('keyword') }}' 검색 결과에 해당하는 상품이 없습니다.</p>
                                    </div>
                                @else
                                <h3 class="mt24">추천 상품<span>(최대 5개)</span></h3>
                                    @if (count($represents) < 1)
                                        @if (request()->get('keyword'))
                                            <div class="fixed-wrap search-result--none">
                                                <i class="ico__search-circle"><span class="a11y">검색</span></i>
                                                <p>'{{ request()->get('keyword') }}' 검색 결과에 해당하는 상품이 없습니다.</p>
                                            </div>
                                        @else
                                            <div class="list-none">
                                                <p>추천 상품을 선택해주세요</p>
                                            </div>
                                        @endif
                                    @else
                                        <ul class="card-wrap">
                                            @foreach($represents as $represent)
                                                <li class="card__list-item">
                                                    <div class="list__btn" onclick="modalProductPreview({{ $represent->idx }}, false)">
                                                        <div class="list__img">
                                                            <img src="{{ $represent->product_image }}" alt="item03">
                                                        </div>
                                                        <div class="list__desc">
                                                            <div class="desc__head">
                                                                <div class="badge badge--type01">{{ config('constants.PRODUCT_STATUS')[$represent->state] }}</div>
                                                                <button type="button" class="recommend-btn active" data-represent-id="{{ $represent->idx }}">
                                                                    <span class="a11y">추천 상품</span>
                                                                </button>
                                                            </div>
                                                            <div class="desc__body">
                                                                <div>
                                                                    <ul class="breadcrumbs-wrap">
                                                                        <li>{{ $represent->parent_category }}</li>
                                                                        <li>{{ $represent->child_category }}</li>
                                                                    </ul>
                                                                    <p>{{ $represent->name }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="desc__footer">
                                                                <ul>
                                                                    <li>관심<span>{{ $represent->interest_product_count }}</span></li>
                                                                    <li>문의<span>{{ $represent->inquiry_count }}</span></li>
                                                                    <li>진입<span>{{ $represent->access_count }}</span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <ul class="edit-delete-wrap">
                                                        <li>
                                                            <button type="button" onclick="location.href='/product/modify/{{ $represent->idx }}'">
                                                                수정
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button type="button" onclick="deleteProductModal({{ $represent->idx }})">
                                                                삭제
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif


                                    <h3>전체</h3>
                                    @if ($count < 1)
                                        @if (request()->get('keyword'))
                                            <div class="fixed-wrap search-result--none">
                                                <i class="ico__search-circle"><span class="a11y">검색</span></i>
                                                <p>'{{ request()->get('keyword') }}' 검색 결과에 해당하는 상품이 없습니다.</p>
                                            </div>
                                        @else
                                            <div class="fixed-wrap">
                                                <p>상품을 등록해주세요</p>
                                                <button type="button" onclick="location.href='/product/registration'">상품 등록하기</button>
                                            </div>
                                        @endif
                                    @else
                                        @if (request()->get('keyword'))
                                        <!-- 검색 결과 -->
                                        <div class="search-result">
                                            <h4>'{{ request()->get('keyword') }}' 검색 결과 총 {{ $count }} 개의 상품</h4>
                                        </div>
                                        @endif
                                        <ul class="card-wrap">
                                            @foreach($list as $row)
                                                <li class="card__list-item">
                                                    <div class="list__btn" onclick="modalProductPreview({{ $row->idx }}, false)">
                                                        <div class="list__img">
                                                            <img src="{{ $row->product_image }}" alt="item03">
                                                        </div>
                                                        <div class="list__desc">
                                                            <div class="desc__head">
                                                                <div class="badge badge--type03">{{ config('constants.PRODUCT_STATUS')[$row->state] }}</div>
                                                                <button type="button" class="recommend-btn" data-represent-id="{{ $row->idx }}">
                                                                    <span class="a11y">추천 상품</span>
                                                                </button>
                                                            </div>
                                                            <div class="desc__body">
                                                                <div>
                                                                    <ul class="breadcrumbs-wrap">
                                                                        <li>{{ $row->parent_category }}</li>
                                                                        <li>{{ $row->child_category }}</li>
                                                                    </ul>
                                                                    <p>{{ $row->name }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="desc__footer">
                                                                <ul>
                                                                    <li>관심<span>{{ $row->interest_product_count }}</span></li>
                                                                    <li>문의<span>{{ $row->inquiry_count }}</span></li>
                                                                    <li>진입<span>{{ $row->access_count }}</span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <ul class="edit-delete-wrap">
                                                        <li><button type="button" onclick="changeStatsModal({{ $row->idx }}, '{{ $row->state }}')">상태 변경</button>
                                                        </li>
                                                        <li><button type="button" onclick="location.href='/product/modify/{{ $row->idx }}'">수정</button></li>
                                                        <li><button type="button" onclick="deleteProductModal({{ $row->idx }})">삭제</button></li>
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>

                                        <div class="pagenation pagination--center">
                                            @if($pagination['prev'] > 0)
                                            <button type="button" class="prev" id="prev-paginate" onclick="moveToList({{$pagination['prev']}})">
                                                <svg width="7" height="12" viewBox="0 0 7 12" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6 1L1 6L6 11" stroke="#DBDBDB" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </button>시
                                            @endif
                                            <div class="numbering">
                                                @foreach($pagination['pages'] as $paginate)
                                                    @if ($paginate == $offset)
                                                        <a href="javascript:void(0)" onclick="moveToList({{$paginate}})" class="numbering--active">{{$paginate}}</a>
                                                    @else
                                                        <a href="javascript:void(0)" onclick="moveToList({{$paginate}})">{{$paginate}}</a>
                                                    @endif
                                                @endforeach
                                            </div>
                                            @if($pagination['next'] > 0)
                                            <button type="button" class="next" id="next-paginate" onclick="moveToList({{$pagination['next']}})">
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5 12L10 7L5 2" stroke="#828282" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </button>
                                            @endif
                                        </div>
                                    @endif
                                @endif

                                <!-- 상품 상태 변경 팝업 -->
                                <div id="default-modal-status" class="default-modal default-modal--radio-box">
                                    <div class="default-modal__container">
                                        <div class="default-modal__header">
                                            <h2>상품 상태 변경</h2>
                                            <button type="button" class="ico__close28"
                                                    onclick="closeModal('#default-modal-status')">
                                                <span class="a11y">닫기</span>
                                            </button>
                                        </div>
                                        <div class="default-modal__content">
                                            <ul class="content__list">
                                                <li>
                                                    <label>
                                                        <input type="radio" name="product-status" class="radio__checked" value="S">
                                                        <span>판매 중</span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label>
                                                        <input type="radio" name="product-status" class="radio__checked" value="O">
                                                        <span>품절</span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label>
                                                        <input type="radio" name="product-status" class="radio__checked" value="H">
                                                        <span>숨김</span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label>
                                                        <input type="radio" name="product-status" class="radio__checked" value="C">
                                                        <span>판매 중지</span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="default-modal__footer">
                                            <button type="button" class="button button--solid" id="confirmChangeStatueBtn" data-idx="" onclick="changeState()">완료</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- 상태값 변경 미게시 안내 팝업 -->
                                <div id="alert-modal01" class="alert-modal">
                                    <div class="alert-modal__container">
                                        <div class="alert-modal__top">
                                            <p>
                                                해당 상태값으로 변경 시, 서비스에서 상품이<br>
                                                미노출 처리됩니다. 변경하시겠습니까?
                                            </p>
                                        </div>
                                        <div class="alert-modal__bottom">
                                            <div class="button-group">
                                                <button type="button" class="button button--solid-gray" onclick="closeModal('#alert-modal01')">
                                                    취소
                                                </button>
                                                <button type="button" class="button button--solid" onclick="changeState()">
                                                    확인
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 상태값 변경 불가 팝업 -->
                                <div id="alert-modal02" class="alert-modal">
                                    <div class="alert-modal__container">
                                        <div class="alert-modal__top">
                                            <p>
                                                현재 거래 중인 상품은<br>
                                                <span id="changeStateText"></span> 처리하실 수 없습니다.
                                            </p>
                                        </div>
                                        <div class="alert-modal__bottom">
                                            <button type="button" class="button button--solid" onclick="closeModal('#alert-modal02')">
                                                확인
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="tab02">
                                @if($count < 1)
                                    @if (request()->get('keyword'))
                                        <div class="fixed-wrap search-result--none">
                                            <i class="ico__search-circle"><span class="a11y">검색</span></i>
                                            <p>'{{ request()->get('keyword') }}' 검색 결과에 해당하는 상품이 없습니다.</p>
                                        </div>
                                    @else
                                        <div class="fixed-wrap">
                                            <p>상품을 등록해주세요</p>
                                            <button type="button" onclick="location.href='/product/registration'">상품 등록하기</button>
                                        </div>
                                    @endif
                                @else
                                    <ul class="card-wrap">
                                        @foreach($list as $row)
                                        <li class="card__list-item">
                                            <div class="list__btn" onclick="modalProductPreview({{ $row->idx }}, true)">
                                                <div class="list__top">
                                                    <p>최근 수정 {{ $row->update_time }}</p>
                                                </div>
                                                <div class="list__bottom">
                                                    <ul class="breadcrumbs-wrap">
                                                        <li>{{ $row->parent_category }}</li>
                                                        <li>{{ $row->child_category }}</li>
                                                    </ul>
                                                    <p>{{ $row->name }}</p>
                                                </div>
                                            </div>
                                            <ul class="edit-delete-wrap">
                                                <li>
                                                    <button type="button"onclick="location.href='/product/registration?temp={{ $row->idx }}'">
                                                        수정
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" onclick="deleteProductModal({{ $row->idx }})">
                                                        삭제
                                                    </button>
                                                </li>
                                            </ul>
                                        </li>
                                        @endforeach
                                    </ul>

                                    <div class="pagenation pagination--center">
                                        @if($pagination['prev'] > 0)
                                        <button type="button" class="prev" id="prev-paginate" onclick="moveToList({{$pagination['prev']}})">
                                            <svg width="7" height="12" viewBox="0 0 7 12" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6 1L1 6L6 11" stroke="#DBDBDB" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                        @endif
                                        <div class="numbering">
                                            @foreach($pagination['pages'] as $paginate)
                                                @if ($paginate == $offset)
                                                    <a href="javascript:void(0)" onclick="moveToList({{$paginate}})" class="numbering--active">{{$paginate}}</a>
                                                @else
                                                    <a href="javascript:void(0)" onclick="moveToList({{$paginate}})">{{$paginate}}</a>
                                                @endif
                                            @endforeach
                                        </div>
                                        @if($pagination['next'] > 0)
                                        <button type="button" class="next" id="next-paginate" onclick="moveToList({{$pagination['next']}})">
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5 12L10 7L5 2" stroke="#828282" stroke-width="1.7" stroke-linecap="round"
                                                      stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- 삭제 팝업 -->
                    <div id="alert-modal03" class="alert-modal">
                        <div class="alert-modal__container">
                            <div class="alert-modal__top">
                                <p>
                                    해당 상품을 삭제하시겠습니까?<br>
                                    삭제한 상품은 복구할 수 없습니다.
                                </p>
                            </div>
                            <div class="alert-modal__bottom">
                                <div class="button-group">
                                    <button type="button" class="button button--solid-gray"
                                            onclick="closeModal('#alert-modal03')">
                                        취소
                                    </button>
                                    <button type="button" class="button button--solid" data-idx="" id="confirmDeleteProductBtn" onclick="deleteProduct()">
                                        확인
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<iframe id="productPreviewModal" src="about:blank" width="0" height="0"></iframe>

    <script>
        const getParams = () => {
            const params = {};
            const urlSearch = new URLSearchParams(location.search);
            urlSearch.get('categories') ? params.categories = urlSearch.get('categories') : '';
            urlSearch.get('keyword') ? params.keyword = urlSearch.get('keyword') : '';
            urlSearch.get('state') ? params.state = urlSearch.get('state') : '';
            urlSearch.get('type') ? params.type = urlSearch.get('type') : '';

            return params;
        }

        const getList = paramsType => {
            const params = getParams();
            delete params[paramsType];

            switch(paramsType) {
                case 'categories':
                    let categories = [];
                    const checkedCategories = document.querySelectorAll('[name*=category_check]:checked');
                    for(const category of checkedCategories) categories.push(category.value);
                    if (categories) params['categories'] = categories;
                    break;
                case 'state':
                    let states = [];
                    const checkedState = document.querySelectorAll('[name*=state]:checked');
                    for(const state of checkedState) states.push(state.value);
                    if (states) params['state'] = states;
                    break;
            }

            location.href='/mypage/product?' + new URLSearchParams(params);
        }

        const removeCheckedCategoryBtn = elem => {
            const params = getParams();
            const categories = params['categories'].split(',');
            categories.splice(categories.indexOf(elem.dataset.category), 1);
            params['categories'] = categories;
            location.href='/mypage/product?' + new URLSearchParams(params);
        }

        const refreshCheckedCategories = () => {
            const params = getParams();
            delete params['categories'];
            location.href='/mypage/product?'+ new URLSearchParams(params);
        }

        const moveToList = page => {
            const params = getParams();
            params['offset'] = page;
            location.href='/mypage/product?'+ new URLSearchParams(params);
        }

        const changeStatsModal = (idx, state) => {
            if (state === 'W') {
                document.getElementById('changeStateText').textContent = '상태 변경';
                openModal('#alert-modal02');
                return false;
            }
            document.querySelectorAll('[name=product-status]').forEach(elem => {
                elem.checked = false;
            })
            document.getElementById('confirmChangeStatueBtn').dataset.idx = idx;
            openModal('#default-modal-status');
        }

        const getProductStateText = state => {
            let statusText = "";
            switch(state) {
                case 'W':
                    statusText = "승인대기";
                    break;
                case 'R':
                    statusText = "반려";
                    break;
                case 'O':
                    statusText = "품절";
                    break;
                case 'S':
                    statusText = "판매중";
                    break;
                case 'H':
                    statusText = "숨김";
                    break;
                case 'C':
                    statusText = "판매중지"
                    break;
            }
            return statusText;
        }

        const changeState = () => {
            const idx = document.getElementById('confirmChangeStatueBtn').dataset.idx;
            const state = document.querySelector('[name=product-status]:checked').value;
            const statusText = getProductStateText(state);
            fetch('/mypage/product/state/', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: JSON.stringify({
                    idx: idx,
                    state: state
                })
            }).then(response => {
                return response.json();
            }).then(json => {
                if (json.result === 'success') {
                    if (json.code === 'SUCCESS_STATE_CHANGE') {
                        location.reload();
                    } else if (json.code.indexOf('FAIL_STATE_') === 0) {
                        document.getElementById('changeStateText').textContent = "'" + statusText + "'";
                        openModal('#alert-modal02');
                    }
                } else {
                    alert(json.message);
                }
            })
        }

        const deleteProductModal = idx => {
            document.getElementById('confirmDeleteProductBtn').dataset.idx = idx;
            openModal('#alert-modal03');
        }

        const deleteProduct = () => {
            const idx = document.getElementById('confirmDeleteProductBtn').dataset.idx;
            fetch('/mypage/product/' + idx, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            }).then(response => {
                location.reload();
            })
        }

        document.getElementById('keyword').addEventListener('keyup', e => {
            if (e.key === 'Enter') { // enter key
                const params = getParams();
                params['keyword'] = e.currentTarget.value;
                location.href='/mypage/product?' + new URLSearchParams(params);
            }
        })

        const modalProductPreview = (idx, temp) => {
            if (temp === true) {
                document.getElementById('productPreviewModal').src = '/product/registration?temp=' + idx;
            } else {
                document.getElementById('productPreviewModal').src = '/product/modify/' + idx;
            }
            $('#productPreviewModal').on( 'load', function() {
                setTimeout(function() {
                    document.getElementById('productPreviewModal').contentWindow.document.getElementById('previewBtn').click();
                    document.querySelector('#default-modal-preview02').innerHTML =
                        document.querySelector('#productPreviewModal').contentWindow.document.getElementById('default-modal-preview02').innerHTML;
                    openModal('#default-modal-preview02');
                }, 1000)
            });
        }

        document.querySelectorAll('.recommend-btn').forEach(elem => {
            elem.addEventListener('click', e => {
                e.stopPropagation();
                e.preventDefault();

                const idx = elem.dataset.representId;
                fetch('/mypage/represent/product/' + idx, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
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
            })
        })

        $(document).on('click', 'li.thumnail', function () {
            $('li.thumnail').map(function (el) {
                $(this).removeClass('selected');
            })
            $(this).addClass('selected');
            $('.product-detail__left-wrap .left-wrap__img img').attr('src', ($(this).find('img').attr('src')));
        });

        $(document).on('click', '.order-info__title', function() {
            $('.order-info__title').removeClass('active');
            $(this).addClass('active');
        });

    </script>

