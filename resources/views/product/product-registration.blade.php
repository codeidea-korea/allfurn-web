@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
    <div id="container" class="container registration--position">
        <div class="inner">
            <div class="content">
                <div class="registration__container">
                    <div class="registration__title">
                        <h2>
                            @if(Route::current()->getName() == 'product.create')
                                상품 등록
                            @elseif(Route::current()->getName() == 'product.modify')
                                상품 수정
                            @endif
                        </h2>
                        <p class="required--sample">는 필수 입력 항목입니다.</p>
                    </div>
                    <!-- 상품 기본 정보 -->
                    <div class="registration__title-sub">
                        <h3>상품 기본 정보</h3>
                        @if(sizeof($productList)>0)
                            <button type="button" class="button button--blank-gray" onclick="getProductList(1)">
                                기본 정보 불러오기
                            </button>
                        @endif
                    </div>
                    <div class="registration__form">
                        <ul>
                            <!-- 상품명 -->
                            <li class="form__list-wrap">
                                <label for="form-list01" class="list__title required">상품명</label>
                                <div class="list__desc">
                                    <input type="text" class="input textfield__input textfield__input--gray" id="form-list01" name="name" maxlength="50"
                                           @if(@isset($data->name))
                                               value="{{$data->name}}"
                                           @endif
                                           placeholder="상품명을 입력해주세요." required/>
                                </div>
                            </li>
                            <!-- 상품 이미지 -->
                            <li class="form__list-wrap">
                                <label for="form-list02" class="list__title required">상품 이미지</label>
                                <div class="list__desc">
                                    <ul class="desc__product-img-wrap">
                                        <li class="product-img__gallery">
                                            <input class="input file-input" id="form-list02" name="file" type="file" multiple="multiple" required placeholder="이미지 추가">
                                            <div class="desc__input-placeholder">
                                                <i class="ico__gallery--gray"><span class="a11y">갤러리</span></i>
                                                <p>이미지 추가</p>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="desc__notice">
                                        <p>· 권장 크기: 550 x 550 / 권장 형식: jpg, jpeg, png</p>
                                        <p><span class="red">· 첫번째 이미지가 대표 이미지로 노출됩니다.</span></p>
                                        <p>· 이미지는 8개까지 등록 가능합니다.</p>
                                    </div>
                                </div>
                            </li>
                            <!-- 카테고리 -->
                            <li class="form__list-wrap">
                                <span class="list__title required">카테고리</span>
                                <div class="list__desc">
                                    <div class="desc__container">
                                        <ul class="desc__category" id="category-step1">
                                            @foreach($categoryList as $category)
                                                <li class="category__list-item step1" name="category" data-category_idx="{{$category->idx}}" data-code="{{$category->code}}">
                                                    <img class="category__ico" src="{{$category->imgUrl}}" style="width: 10%;">
                                                    <span>{{$category->name}}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <p class="list-item--selected">선택한 카테고리 : <span id="categoryIdx" data-category_idx></span></p>
                                </div>
                            </li>

                            <!-- 상품 속성 -->
                            <li class="form__list-wrap">
                                <span class="list__title">상품 속성</span>
                                <div class="list__desc property">
                                    <div class="list">
                            @if(isset($propertyList))
                                @foreach($propertyList as $item)
                                    <li data-sub_idx="{{$item->idx}}">
                                        <span>{{$item->name}}</span>
                                        <i class="ico__delete16"><span class="a11y">삭제</span></i>
                                    </li>
                        @endforeach
                        @endif
                    </div>
                    <div class="desc__notice">
                        <p>· 상품에 맞는 속성이 없는 경우, 추가 공지 영역에 기입해주세요. 혹은 <span class="red">속성 추가가 필요한 경우, 1:1 문의를 통해 올펀에 요청해주세요.</span></p>
                    </div>
                </div>
                </li>

                <!-- 상품 가격 -->
                <li class="form__list-wrap">
                    <span class="list__title required">상품 가격</span>
                    <div class="list__desc">
                        <ul class="desc__select-group">
                            <li class="desc__select-group--item">
                                <div class="textfield__input--won">
                                    <label class="item__text item__text--type02" for="product-price">
                                        <span class="required">상품 가격</span>
                                    </label>
                                    <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '');"  id="product-price" name="price" class="input textfield__input textfield__input--gray"
                                           value=0 placeholder="숫자만 입력해주세요." style="text-align: right;" required>
                                    <p>원</p>
                                </div>
                                <span style="color:red; margin-left:10px">가격은 부가세 포함 도매가격으로 기재해주세요.</span>
                            </li>
                            <li class="desc__select-group--item" style="display: block;">
                                <div style="display: flex; align-items: center;">
                                    <p class="item__text item__text--type02">
                                        <span class="required">가격 노출</span>
                                    </p>
                                    <div class="radio__box--type01">
                                        <div>
                                            <input type="radio" id="price01" name="price_open" {{isset($data->is_price_open) ? ($data->is_price_open == 1 ? 'checked' : '') : 'checked'}} value=1>
                                            <label for="price01" class="label--exposure"><span>노출</span></label>
                                        </div>
                                        <div>
                                            <input type="radio" id="price02" name="price_open" {{isset($data->is_price_open) ? ($data->is_price_open == 0 ? 'checked' : '') : ''}} value=0>
                                            <label for="price02" class="label--unexposed"><span>미노출</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="select-group__dropdown price_open">
                                    <div class="dropdown">
                                        <p class="dropdown__title">가격 안내 문구 선택</p>
                                        <ul class="dropdown__wrap">
                                            <li class="dropdown__item">수량마다 상이</li>
                                            <li class="dropdown__item">업체 문의</li>
                                        </ul>
                                    </div>
                                    <div class="desc__notice" style="display: flex; align-items: center;">
                                        <i class="ico__info" style="margin-right: 6px;"><span class="a11y">공지</span></i>
                                        <p>가격 대신 선택한 문구가 노출됩니다.</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                
                
                <!-- 상품 가격 -->
                <li class="form__list-wrap">
                    <span class="list__title">신상품 설정</span>
                    <div class="list__desc">
                        <div class="radio__box--type01">
                            <div>
                                <input type="radio" id="is_new_product_01" name="is_new_product" 
                                    {{ isset($data) ? ($data->is_new_product == 1 ? 'checked' : '') : 'checked'}} value=1>
                                <label for="is_new_product_01" class="label--exposure"><span>설정</span></label>
                            </div>
                            <div>
                                <input type="radio" id="is_new_product_02" name="is_new_product" 
                                    {{ isset($data) ? ($data->is_new_product == 0 ? 'checked' : '') : ''}} value=0>
                                <label for="is_new_product_02" class="label--unexposed"><span>미설정</span></label>
                            </div>
                        </div>
                    </div>
                </li>

                <!-- 결제 방식 -->
                <li class="form__list-wrap">
                    <span class="list__title required">결제 방식</span>
                    <div class="list__desc">
                        <div class="radio__box--type01">
                            <div>
                                <input type="radio" id="payment01" name="payment" {{ isSet($data) ? ( $data->pay_type == '1' ? 'checked' : '' ) : '' }} value=1>
                                <label for="payment01" class="label--payment01"><span>업체 협의</span></label>
                            </div>
                            <div>
                                <input type="radio" id="payment02" name="payment" {{ isSet($data) ? ( $data->pay_type == '2' ? 'checked' : '' ) : '' }} value=2>
                                <label for="payment02" class="label--payment02"><span>계좌이체</span></label>
                            </div>
                            <div>
                                <input type="radio" id="payment03" name="payment" {{ isSet($data) ? ( $data->pay_type == '3' ? 'checked' : '' ) : '' }} value=3>
                                <label for="payment03" class="label--payment03" style="width: 160px;"><span>세금계산서 발행</span></label>
                            </div>
                            <div>
                                <input type="radio" id="payment04" name="payment" {{ isSet($data) ? ( $data->pay_type == '4' ? 'checked' : '' ) : '' }} value=4>
                                <label for="payment04" class="label--payment04"><span>직접 입력</span></label>
                            </div>
                        </div>
                        <div class="payment__input-wrap" style='{{ isSet($data) ? ( $data->pay_type == '4' ? 'display: block' : '' ) : '' }}'>
                            <input class="input textfield__input textfield__input--gray" id="form-list01" name="payment_text" type="text" 
                                maxlength="10" required placeholder="결제 방식을 입력해주세요" value="{{  isSet($data) ? $data->pay_type_text : '' }}">
                        </div>
                    </div>
                </li>

                <!-- 상품 코드 -->
                <li class="form__list-wrap">
                    <label for="form-list07" class="list__title">상품 코드</label>
                    <div class="list__desc">
                        <input class="input textfield__input textfield__input--gray" id="form-list07" name="product_code" type="text"
                               placeholder="상품 코드를 입력해주세요." maxlength="10" value="{{isset($product_number) ? $product_number : ''}}">
                    </div>
                </li>

                <!-- 배송 방법 -->
                <li class="form__list-wrap">
                    <span class="list__title required">배송 방법</span>
                    <div class="list__desc">
                        <div class="desc__shipping-wrap">
                            <button type="button" class="button button--blank-gray" onclick="openDeliveryModal()">
                                <i class="ico__add--circle"><span class="a11y">추가</span></i>
                                <span>배송 방법 추가</span>
                            </button>
                            <!-- active 로 동작 -->
                            <div class="shipping-wrap__add">
                                <p class="add__title">추가된 배송 방법</p>
                                <ul>
                                    @if(isset($delivery_info))
                                        @foreach($delivery_info as $item)
                                            <li>
                                                <span class="add__name">{{$item}}</span>
                                                <i class="ico__delete16"><span class="a11y">삭제</span></i>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
                
                
                <!-- 상품 추가 공지 -->
                <li class="form__list-wrap">
                    <label for="form-list09" class="list__title">상품 추가 공지</label>
                    <div class="list__desc">
                        <div class="textarea-wrap">
                            <textarea id="form-list09" name="notice_info" placeholder="상품 추가 공지사항을 입력해주세요."></textarea>
                        </div>
                    </div>
                </li>
                
                
                <!-- 인증 정보 -->
                <li class="form__list-wrap">
                    <span class="list__title">인증 정보</span>
                    <div class="list__desc">
                        <div class="desc__auth-wrap">
                            <button type="button" class="button button--solid-gray" onclick="openAuthInfo()">
                                인증 정보 선택
                            </button>

                            <!-- active 동작 -->
                            <div class="auth-wrap__selected">
                                <p class="red">선택된 인증 정보</p>
                                <p id="auth_info" name="auth_info">KC 인증, 친환경 인증, 직접 입력된 기타 인증명 노출</p>
                            </div>
                        </div>
                    </div>
                </li>
                
                
                <!-- 상품 상세 내용 -->
                <li class="form__list-wrap">
                    <span class="list__title required">상품 상세 내용</span>
                    <div class="list__desc">
                        <div class="desc__guide-wrap">
                            <button type="button" class="button button--blank-gray" onclick="openModal('#guide-modal')">
                                상세 내용 작성 가이드
                            </button>
                            <div class="editor">
                                <div class="guide__smart-editor" name="product_detail">
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                
                </ul>

                <!-- 속성 선택 팝업 -->
                <div id="property-modal" class="default-modal default-modal--category">
                    <div class="default-modal__container">
                        <div class="default-modal__header">
                            <h2>색상 선택</h2>
                            <button type="button" class="ico__close28" onclick="closeModal('#property-modal')">
                                <span class="a11y">닫기</span>
                            </button>
                        </div>
                        <div class="default-modal__content">
                            <ul class="content__list"></ul>
                        </div>
                        <div class="default-modal__footer">
                            <button type="button" class="button button--blank-gray reset">
                                <i class="ico__refresh"><span class="a11y">초기화</span></i>
                                <p>초기화</p>
                            </button>
                            <button type="button" class="button button--solid">선택 완료</button>
                        </div>
                    </div>
                </div>

                <!-- 배송 방법 추가 팝업 -->
                <div id="delivery-modal" class="default-modal default-modal--shipping">
                    <div class="default-modal__container">
                        <div class="default-modal__header">
                            <h2>배송 방법 추가</h2>
                            <button type="button" class="ico__close28" onclick="resetDeliveryModal()">
                                <span class="a11y">닫기</span>
                            </button>
                        </div>
                        <div class="default-modal__content">
                            <h3 class="required">배송 방법</h3>
                            <div class="shipping__wrap">
                                <div class="dropdown step1">
                                    <p class="dropdown__title">배송 방법 선택</p>
                                    <ul class="dropdown__wrap">
                                        <li class="dropdown__item">직접 입력</li>
                                        <li class="dropdown__item">소비자 직배 가능</li>
                                        <li class="dropdown__item">매장 배송</li>
                                    </ul>
                                </div>

                                <div class="wrap-item wrap-item--01">
                                    <input class="input textfield__input textfield__input--gray center" id="delivery_text" type="text" required placeholder="배송 방법을 입력해주세요." maxlength="20">
                                </div>

                                <div class="wrap-item wrap-item--02">
                                    <h3>위 배송 방법의 가격을 선택해주세요</h3>
                                    <div class="dropdown step2">
                                        <p class="dropdown__title">배송 가격을 선택해주세요</p>
                                        <ul class="dropdown__wrap">
                                            <li class="dropdown__item">무료</li>
                                            <li class="dropdown__item">착불</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="default-modal__footer">
                            <button type="button" class="button button--solid addButton" disabled>추가하기</button>
                        </div>
                    </div>
                </div>

                <!-- 인증 정보 팝업 -->
                <div id="default-modal07" class="default-modal default-modal--category">
                    <div class="default-modal__container">
                        <div class="default-modal__header">
                            <h2>인증 정보</h2>
                            <button type="button" class="ico__close28" onclick="closeModal('#default-modal07')">
                                <span class="a11y">닫기</span>
                            </button>
                        </div>
                        <div class="default-modal__content">
                            <ul class="content__list">
                                <li>
                                    <label for="category-check07-01">
                                        <input type="checkbox" id="category-check07-01" class="checkbox__checked" data-auth="KS 인증">
                                        <span>KS 인증</span>
                                    </label>
                                </li>
                                <li>
                                    <label for="category-check07-02">
                                        <input type="checkbox" id="category-check07-02" class="checkbox__checked" data-auth="ISO 인증">
                                        <span>ISO 인증</span>
                                    </label>
                                </li>
                                <li>
                                    <label for="category-check07-03">
                                        <input type="checkbox" id="category-check07-03" class="checkbox__checked" data-auth="KC 인증">
                                        <span>KC 인증</span>
                                    </label>
                                </li>
                                <li>
                                    <label for="category-check07-04">
                                        <input type="checkbox" id="category-check07-04" class="checkbox__checked" data-auth="친환경 인증">
                                        <span>친환경 인증</span>
                                    </label>
                                </li>
                                <li>
                                    <label for="category-check07-05">
                                        <input type="checkbox" id="category-check07-05" class="checkbox__checked" data-auth="외코텍스(OEKO-TEX) 인증">
                                        <span>외코텍스(OEKO-TEX) 인증</span>
                                    </label>
                                </li>
                                <li>
                                    <label for="category-check07-06">
                                        <input type="checkbox" id="category-check07-06" class="checkbox__checked" data-auth="독일 LGA 인증">
                                        <span>독일 LGA 인증</span>
                                    </label>
                                </li>
                                <li>
                                    <label for="category-check07-07">
                                        <input type="checkbox" id="category-check07-07" class="checkbox__checked" data-auth="GOTS(오가닉) 인증">
                                        <span>GOTS(오가닉) 인증</span>
                                    </label>
                                </li>
                                <li>
                                    <label for="category-check07-08">
                                        <input type="checkbox" id="category-check07-08" class="checkbox__checked" data-auth="라돈테스트 인증">
                                        <span>라돈테스트 인증</span>
                                    </label>
                                </li>
                                <li>
                                    <label for="category-check07-09">
                                        <input type="checkbox" id="category-check07-09" class="checkbox__checked" data-auth="전자파 인증">
                                        <span>전자파 인증</span>
                                    </label>
                                </li>
                                <li>
                                    <label for="category-check07-10">
                                        <input type="checkbox" id="category-check07-10" class="checkbox__checked" data-auth="전기용품안전 인증">
                                        <span>전기용품안전 인증</span>
                                    </label>
                                </li>
                                <li class="modal__border-bottom">
                                    <label for="category-check07-11" class="modal__auth-input-wrap">
                                        <input type="checkbox" id="category-check07-11" class="checkbox__checked" data-auth="기타 인증">
                                        <span>기타 인증</span>
                                    </label>

                                    <input class="input textfield__input textfield__input--gray modal__auth-input" type="text" id="auth_info_text" maxlength="20"
                                           placeholder="(필수) 기타 인증을 입력해주세요." required style="display: none;">
                                </li>
                            </ul>
                        </div>
                        <div class="default-modal__footer" style="justify-content: center;">
                            <button type="button" class="button button--solid">선택 완료</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 상품 주문 옵션 -->
            <div class="registration__title-sub registration__title-sub--notice">
                <div class="title__wrap">
                    <h3>상품 주문 옵션</h3>
                    <div class="title__button-group">
                        <button type="button" class="button button--blank-gray" onclick="addOrderOption()">주문 옵션 추가</button>
                        <button type="button" class="button button--blank-gray" onclick="sortOption()">옵션 순서 변경</button>
                    </div>

                    <!-- 옵션 순서 변경 팝업 -->
                    <div id="default-modal09" class="default-modal default-modal--category">
                        <div class="default-modal__container">
                            <div class="default-modal__header">
                                <h2>옵션 순서 변경</h2>
                                <button type="button" class="ico__close28" onclick="closeModal('#default-modal09')">
                                    <span class="a11y">닫기</span>
                                </button>
                            </div>
                            <div class="default-modal__content">
                                <div class="content__notice">
                                    <i class="ico__info"><span class="a11y">공지</span></i>
                                    <p>
                                        필수 옵션의 경우, 주문 시 상위 옵션을 선택해야 하위 옵션 선택이 가능합니다. 상위 개념의 옵션을 앞 순서로 설정해주세요.
                                    </p>
                                </div>
                                <ul class="content__list" id="sortable">
                                    <li>
                                        <i class="ico__burger24"><span class="a11y">이동</span></i>
                                        <p>(필수): 사이즈</p>
                                    </li>
                                    <li>
                                        <i class="ico__burger24"><span class="a11y">이동</span></i>
                                        <p>(선택): 추가 구성</p>
                                    </li>
                                    <li>
                                        <i class="ico__burger24"><span class="a11y">이동</span></i>
                                        <p>(선택): 추가 구성</p>
                                    </li>
                                    <li>
                                        <i class="ico__burger24"><span class="a11y">이동</span></i>
                                        <p>(선택): 추가 구성</p>
                                    </li>
                                    <li>
                                        <i class="ico__burger24"><span class="a11y">이동</span></i>
                                        <p>(선택): 추가 구성</p>
                                    </li>
                                    <li>
                                        <i class="ico__burger24"><span class="a11y">이동</span></i>
                                        <p>(선택): 추가 구성</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="default-modal__footer">
                                <button type="button" class="button button--solid">변경 완료</button>
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="title__notice-wrap">
                    <li>
                        <i class="ico__info"><span class="a11y">공지</span></i>
                        <p>
                            <span class="red"> 주문 시 필수로 받아야 하는 옵션은 ‘필수 옵션’을 설정해주세요.</span>
                            필수 옵션의 경우, 주문 시 상위 옵션을 선택해야 하위 옵션 선택이 가능합니다. 상위 개념의 옵션을 옵션 1로 설정해주세요.
                        </p>
                    </li>
                    <li>
                        <i class="ico__info"><span class="a11y">공지</span></i>
                        <p class="red">등록한 상품 외 추가로 금액 산정이 필요한 구성품인 경우, 옵션값 하단에 반드시 가격을 입력해주세요.</p>
                    </li>
                    <li>
                        <i class="ico__info"><span class="a11y">공지</span></i>
                        <p>주문 옵션은 최대 6개까지 추가 가능합니다.</p>
                    </li>
                </ul>
            </div>

            <div class="registration__form registration__form--type02">
                <ul id="order_options">
                    @if(isset($data->product_option) && $data->product_option != "[]")
                        <li class="form__list-wrap">
                            <div class="list__title">
                                옵션 1
                                <span onclick="checkRemoveOption(1)">삭제</span>
                            </div>
                            <div class="list__desc">
                                <ul class="desc__select-group">
                                    <li class="desc__select-group--item" style="display: block;">
                                        <div style="display: flex; align-items: center;">
                                            <p class="item__text item__text--type02">
                                                <span class="required">필수 옵션</span>
                                            </p>
                                            <div class="radio__box--type01">
                                                <div>
                                                    <input type="radio" id="required-option01-1" name="option-required_01" value=1 checked>
                                                    <label for="required-option01-1"><span>설정</span></label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="required-option01-2" name="option-required_01" value=0 >
                                                    <label for="required-option01-2"><span>설정 안함</span></label>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="desc__select-group--item product__info--option">
                                        <div class="item__input-wrap">
                                            <label class="item__text item__text--type02" for="option-name_01">
                                                <span class="required">옵션명</span>
                                            </label>
                                            <input type="text" class="input textfield__input textfield__input--gray" id="option-name_01" name="option-name_01" value="" placeholder="예시) 색상" maxlength="10" required>
                                        </div>
                                        <ul class="option_value_wrap">
                                            <li class="item__input-wrap">
                                                <label class="item__text item__text--type02" for="option-property_01-1">
                                                    <span class="required">옵션값</span>
                                                </label>
                                                <input type="text" class="input textfield__input textfield__input--gray" id="option-property_01-1" name="option-property_name"  value="" placeholder="예시) 화이트" required >
                                                <div class="textfield__input--won">
                                                    <input type="number" class="input textfield__input textfield__input--gray" name="option-price" value="0" placeholder="예시) 100000" required>
                                                    <p>원</p>
                                                </div>
                                                <div class="input__add-btn">
                                                    <i class="ico__add28--circle"><span class="a11y">추가</span></i>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>

            <!-- 상품 기본 정보 -->
            <div class="registration__title-sub registration__title-sub--order">
                <h3>상품 주문 정보</h3>
                @if(sizeof($productList)>0)
                    <button type="button" class="button button--blank-gray" onclick="getProductList(2)">
                        주문 정보 불러오기
                    </button>
                @endif

                <!-- 주문 정보 팝업 -->
                <div id="default-modal10" class="default-modal">
                    <div class="default-modal__container">
                        <div class="default-modal__header">
                            <h2>정보 불러오기</h2>
                            <button type="button" class="ico__close28" onclick="closeModal('#default-modal10')">
                                <span class="a11y">닫기</span>
                            </button>
                        </div>
                        <div class="default-modal__content">
                            <table>
                                <thead>
                                <tr>
                                    <th>선택</th>
                                    <th>No</th>
                                    <th>카테고리</th>
                                    <th>상품명</th>
                                    <th>상품 상태</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(sizeof($productList)>0)
                                    @foreach($productList as $item)
                                        <tr>
                                            <td>
                                                <label>
                                                    <input type="radio" name="order-info" class="checkbox__checked checked--single" data-product_idx={{$item->idx}}>
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td>{{$item->idx}}</td>
                                            <td>{{$item->category}}</td>
                                            <td>{{$item->name}}</td>
                                            <td>{{__('product.'.$item->state)}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="default-modal__footer">
                            <button type="button" class="button button--solid" onclick="loadProduct()" data-type=1>선택 완료</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="registration__form">
                <ul>
                    <li class="form__list-wrap">
                        <span class="list__title">결제 안내</span>
                        <div class="list__desc">
                            <div class="radio__box--type01">
                                <div>
                                    <input type="radio" id="order-info01-01" name="order-info01" value=1>
                                    <label for="order-info01-01" class="label--payment01"><span>설정</span></label>
                                </div>
                                <div>
                                    <input type="radio" id="order-info01-02" name="order-info01" value=0 checked>
                                    <label for="order-info01-02" class="label--payment02"><span>설정 안함</span></label>
                                </div>
                            </div>

                            <div class="textarea-wrap margin-top16 is_pay" style="display: none;">
                                <textarea id="pay_notice" placeholder="안내 상세 내용 입력"></textarea>
                            </div>
                        </div>
                    </li>

                    <li class="form__list-wrap">
                        <span class="list__title">배송 안내</span>
                        <div class="list__desc">
                            <div class="radio__box--type01">
                                <div>
                                    <input type="radio" id="order-info02-01" name="order-info02" value=1>
                                    <label for="order-info02-01" class="label--payment01"><span>설정</span></label>
                                </div>
                                <div>
                                    <input type="radio" id="order-info02-02" name="order-info02" value=0 checked>
                                    <label for="order-info02-02" class="label--payment02"><span>설정 안함</span></label>
                                </div>
                            </div>

                            <div class="textarea-wrap margin-top16 is_delivery" style="display: none;">
                                <textarea id="delivery_notice" placeholder="안내 상세 내용 입력"></textarea>
                            </div>
                        </div>
                    </li>

                    <li class="form__list-wrap">
                        <span class="list__title">교환/반품/취소 안내</span>
                        <div class="list__desc">
                            <div class="radio__box--type01">
                                <div>
                                    <input type="radio" id="order-info03-01" name="order-info03" value=1>
                                    <label for="order-info03-01" class="label--payment01"><span>설정</span></label>
                                </div>
                                <div>
                                    <input type="radio" id="order-info03-02" name="order-info03" value=0 checked>
                                    <label for="order-info03-02" class="label--payment02"><span>설정 안함</span></label>
                                </div>
                            </div>

                            <div class="textarea-wrap margin-top16 is_return" style="display: none;">
                                <textarea id="return_notice" placeholder="안내 상세 내용 입력"></textarea>
                            </div>
                        </div>
                    </li>

                    <li class="form__list-wrap">
                        <span class="list__title">주문 정보 직접 입력</span>
                        <div class="list__desc">
                            <div class="radio__box--type01">
                                <div>
                                    <input type="radio" id="order-info04-01" name="order-info04" value=1>
                                    <label for="order-info04-01" class="label--payment01"><span>설정</span></label>
                                </div>
                                <div>
                                    <input type="radio" id="order-info04-02" name="order-info04" value=0 checked>
                                    <label for="order-info04-02" class="label--payment02"><span>설정 안함</span></label>
                                </div>
                            </div>
                            <div class="is_order" style="display: none;">
                                <input class="input textfield__input textfield__input--gray" id="order_title" type="text" placeholder="항목 제목"
                                       style="margin: 16px 0 10px;">

                                <div class="textarea-wrap">
                                    <textarea id="order_content" placeholder="항목 상세 내용 입력"></textarea>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- 상품 등록 취소 팝업 -->
        <div id="alert-modal01" class="alert-modal">
            <div class="alert-modal__container">
                <div class="alert-modal__top">
                    <p>
                        상품 등록을 취소하시겠습니까?<br>
                        입력한 내용은 임시 등록됩니다.
                    </p>
                </div>
                <div class="alert-modal__bottom">
                    <div class="button-group">
                        <button type="button" class="button button--solid-gray" onclick="closeModal('#alert-modal01')">
                            취소
                        </button>
                        <button type="button" class="button button--solid" onclick="saveProduct(1)">
                            확인
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 이미지 삭제 팝업 -->
        <div id="alert-modal02" class="alert-modal">
            <div class="alert-modal__container">
                <div class="alert-modal__top">
                    <p>
                        해당 이미지를 삭제하시겠습니까?
                    </p>
                </div>
                <div class="alert-modal__bottom">
                    <div class="button-group">
                        <button type="button" class="button button--solid-gray" onclick="closeModal('#alert-modal02')">
                            취소
                        </button>
                        <button type="button" class="button button--solid">
                            확인
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 임시 등록 팝업 -->
        <div id="alert-modal03" class="alert-modal">
            <div class="alert-modal__container">
                <div class="alert-modal__top">
                    <p>
                        임시 등록되었습니다.
                    </p>
                </div>
                <div class="alert-modal__bottom">
                    <button type="button" class="button button--solid" onclick="history.back(-1);">
                        확인
                    </button>
                </div>
            </div>
        </div>

        <!-- 필수 입력 팝업 -->
        <div id="alert-modal04" class="alert-modal">
            <div class="alert-modal__container">
                <div class="alert-modal__top">
                    <p>
                        필수 항목을 입력해주세요.<br>
                        미입력 시, 입력한 내용이 저장되지 않습니다.
                    </p>
                </div>
                <div class="alert-modal__bottom">
                    <div class="button-group max-width">
                        <button type="button" class="button button--solid-gray" onclick="closeModal('#alert-modal04')">
                            상품 등록 취소
                        </button>
                        <button type="button" class="button button--solid">
                            확인
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 입력된 내용 삭제 알림 팝업 -->
        <div id="alert-modal05" class="alert-modal">
            <div class="alert-modal__container">
                <div class="alert-modal__top">
                    <p>
                        선택값 변경 시 입력한 내용은 삭제됩니다.<br>
                        변경하시겠습니까?
                    </p>
                </div>
                <div class="alert-modal__bottom">
                    <div class="button-group">
                        <button type="button" class="button button--solid-gray" onclick="closeModal('#alert-modal05')">
                            상품 등록 취소
                        </button>
                        <button type="button" class="button button--solid">
                            확인
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 등록 신청 팝업 -->
        <div id="alert-modal06" class="alert-modal">
            <div class="alert-modal__container">
                <div class="alert-modal__top">
                    <p>
                        상품 등록 신청이 완료되었습니다.<br>
                        등록 승인 결과는 푸시 알림으로 발송됩니다.
                    </p>
                </div>
                <div class="alert-modal__bottom">
                    <button type="button" class="button button--solid" onclick="history.back(-1);">
                        확인
                    </button>
                </div>
            </div>
        </div>

        <!-- 옵션 삭제 팝업 -->
        <div id="alert-modal07" class="alert-modal">
            <div class="alert-modal__container">
                <div class="alert-modal__top">
                    <p>
                        옵션 삭제 시 입력한 내용은 삭제됩니다.<br>
                        삭제하시겠습니까?
                    </p>
                </div>
                <div class="alert-modal__bottom">
                    <div class="button-group">
                        <button type="button" class="button button--solid-gray" onclick="closeModal('#alert-modal07')">
                            취소
                        </button>
                        <button type="button" class="button button--solid" data-option_idx>
                            확인
                        </button>
                    </div>
                </div>
            </div>
        </div>

       <!-- 이미지 갯수 제한 팝업 -->
        <div id="alert-modal08" class="alert-modal">
            <div class="alert-modal__container">
                <div class="alert-modal__top">
                    <p>
                        이미지는 8개까지 등록 가능합니다.
                    </p>
                </div>
                <div class="alert-modal__bottom">
                    <button type="button" class="button button--solid" onclick="closeModal('#alert-modal08')">
                        확인
                    </button>
                </div>
            </div>
        </div>

        <!-- 상품 수정 취소 팝업 -->
        <div id="alert-modal09" class="alert-modal">
            <div class="alert-modal__container">
                <div class="alert-modal__top">
                    <p>
                        상품 수정을 취소하시겠습니까?<br>
                        입력한 내용은 저장되지 않습니다.
                    </p>
                </div>
                <div class="alert-modal__bottom">
                    <div class="button-group">
                        <button type="button" class="button button--solid" onclick="history.back();">
                            확인
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 옵션 갯수 제한 팝업 -->
        <div id="alert-modal10" class="alert-modal">
            <div class="alert-modal__container">
                <div class="alert-modal__top">
                    <p>
                        주문 옵션은 최대 6개까지 추가 가능합니다.
                    </p>
                </div>
                <div class="alert-modal__bottom">
                    <button type="button" class="button button--solid" onclick="closeModal('#alert-modal10')">
                        확인
                    </button>
                </div>
            </div>
        </div>

        <!-- 배송 정보 제한 팝업 -->
        <div id="alert-modal11" class="alert-modal">
            <div class="alert-modal__container">
                <div class="alert-modal__top">
                    <p>
                        배송 방법 추가는 최대 6개까지 추가 가능합니다.
                    </p>
                </div>
                <div class="alert-modal__bottom">
                    <button type="button" class="button button--solid" onclick="closeModal('#alert-modal11')">
                        확인
                    </button>
                </div>
            </div>
        </div>

        <!-- 수정 완료 팝업 -->
        <div id="alert-modal12" class="alert-modal">
            <div class="alert-modal__container">
                <div class="alert-modal__top">
                    <p>
                        상품 수정이 완료되었습니다.
                    </p>
                </div>
                <div class="alert-modal__bottom">
                    <button type="button" class="button button--solid" onclick="history.back()">
                        확인
                    </button>
                </div>
            </div>
        </div>

    </div>
    </div>

    <div class="registration__footer-block">&nbsp;</div>
    
    <div class="registration__footer" style="z-index: 100;">
        @if(Route::current()->getName() == 'product.create')
            <!-- 상품 등록 -->
            <div class="footer__btn-wrap">
                <div>
                    <button type="button" class="button button--blank-white" onclick="openModal('#alert-modal01')">등록 취소</button>
                </div>
                <div style="display: inline-flex;">
                    <button type="button" class="button button--solid-gray" onclick="preview()" id="previewBtn">미리 보기</button>
                    <button type="button" class="button button--solid-gray" onclick="saveProduct(1)">임시 등록</button>
                    <button type="button" class="button button--solid" onclick="saveProduct(0)">등록 신청</button>
                </div>
            </div>
        @elseif(Route::current()->getName() == 'product.modify')
            <!-- 상품 수정 -->
            <div class="footer__btn-wrap">
                <div>
                    <button type="button" class="button button--blank-gray" onclick="openModal('#alert-modal09')">수정 취소</button>
                </div>
                <div style="display: inline-flex;">
                    <button type="button" class="button button--solid-gray" onclick="preview()" id="previewBtn">미리 보기</button>
                    <button type="button" class="button button--solid" id="modifyBtn" onclick="saveProduct(2)" data-idx={{$productIdx}}>수정 완료</button>
                </div>
            </div>
        @endif

        <!-- 미리보기 팝업 -->
        <div id="default-modal-preview02" class="default-modal default-modal--preview preview--none">
            <div class="default-modal__container">
                <div class="default-modal__header">
                    <h2>미리 보기</h2>
                    <button type="button" class="ico__close28" onclick="closeModal('#default-modal-preview02')">
                        <span class="a11y">닫기</span>
                    </button>
                </div>
                <div class="default-modal__content">
                    <div class="content" style="height: 500px;">
                        <div class="product-detail">
                            <div class="product-detail__left-wrap">
                                <div class="left-wrap__arrow">
                                    <button type="button" onclick="changeImg(0)">
                                            <span class="ico_back">
                                                <span class="a11y">이전으로</span>
                                            </span>
                                    </button>
                                    <button type="button" onclick="changeImg(1)">
                                            <span class="ico_next">
                                                <span class="a11y">다음으로</span>
                                            </span>
                                    </button>
                                </div>
                                <div class="left-wrap__img">
                                    <img>
                                </div>
                                <ul class="left-wrap__img--small">
                                    <li class="selected">
                                        <button type="button">
                                            <img>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div class="product-detail__right-wrap">
                                <a class="right-wrap__company">
                                    <p class="name"></p>
                                </a>
                                <div class="right-wrap__title">
                                    <div class="title-wrap">
                                        <h2></h2>
                                        <p class="price" data-price="0">
                                            업체 문의
                                        </p>
                                    </div>
                                    <ul>
                                        <li class="product-share">
                                            <a>
                                                <i class="ico__share28"><span class="a11y">공유</span></i>
                                                <p>공유</p>
                                            </a>
                                        </li>
                                        <li class="product-bookmark">
                                            <i class="bookmark"><span class="a11y">북마크</span></i>
                                            <p>관심 상품</p>
                                        </li>
                                    </ul>
                                </div>

                                <div class="right-wrap__code">
                                    <dl style="margin-bottom: 12px">
                                        <dt>상품 코드</dt>
                                        <dd class="preview_product_code"></dd>
                                    </dl>
                                    <dl>
                                        <dt>배송 방법</dt>
                                        <dd class="previce_delivery">업체 협의 (착불)</dd>
                                    </dl>
                                </div>
                                <div class="right-wrap__selection" id="options">
                                    <div class="box">
                                        <div class="box__icon">
                                            <i class="ico__info"><span class="a11y">정보</span></i>
                                        </div>
                                        <p class="box__text">원하는 옵션이 없거나 커스텀 주문을 희망하시면 필수 옵션 선택 후 [바로 주문] 버튼을 클릭하여
                                            주문 요청사항에 작성해주세요.</p>
                                    </div>
                                </div>

                                <div class="right-wrap__code">
                                    <dl style="margin-bottom: 12px">
                                        <dt>판매자 상품번호</dt>
                                        <dd class="sales_product_num"></dd>
                                    </dl>
                                    <dl>
                                        <dt>상품 승인 일자</dt>
                                        <dd class="access_date"></dd>
                                    </dl>
                                </div>

                            </div>
                        </div>

                        <div class="product-detail__table">
                            <dl class="item01">
                                <dt>색상</dt>
                                <dd>블랙, 화이트, 아이보리, 그레이</dd>
                                <dt>소재</dt>
                                <dd>패브릭</dd>
                            </dl>
                            <dl class="item01">
                                <dt>소재</dt>
                                <dd>천연 가죽, 패브릭</dd>
                                <dt>인증 정보</dt>
                                <dd></dd>
                            </dl>
                            <dl class="item02">
                                <dt class="ico__notice24"><span class="a11y">공지</span></dt>
                                <dd></dd>
                            </dl>
                        </div>

                        <div class="product-detail__img-area"></div>

                        <div class="product__text--wrap">
                            <h2 class="product__title">상품 주문 정보</h2>
                        </div>
                        <ul class="product-detail__order-info">
                            <li class="order-info_1" style="display: none;">
                                <div class="order-info__title">
                                    <p>결제 안내</p>
                                    <i class="ico__arrow"><span class="a11y">아래 화살표</span></i>
                                </div>
                                <div class="order-info__desc"></div>
                            </li>
                            <li class="order-info_2" style="display: none;">
                                <div class="order-info__title">
                                    <p>배송 안내</p>
                                    <i class="ico__arrow"><span class="a11y">아래 화살표</span></i>
                                </div>
                                <div class="order-info__desc"></div>
                            </li>
                            <li class="order-info_3" style="display: none;">
                                <div class="order-info__title">
                                    <p>교환/반품/취소 안내</p>
                                    <i class="ico__arrow"><span class="a11y">아래 화살표</span></i>
                                </div>
                                <div class="order-info__desc"></div>
                            </li>
                            <li class="order-info_4" style="display: none;">
                                <div class="order-info__title">
                                    <p></p>
                                    <i class="ico__arrow"><span class="a11y">아래 화살표</span></i>
                                </div>
                                <div class="order-info__desc"></div>
                            </li>
                        </ul>

                    </div>

                </div>
                <div class="default-modal__footer"></div>
            </div>
        </div>
    </div>
    </div>

    <div id="guide-modal" class="default-modal">
        <div class="default-modal__container">
            <div class="default-modal__header">
                <h2>이용 가이드</h2>
                <button type="button" class="ico__close28" onclick="closeModal('#guide-modal')">
                    <span class="a11y">닫기</span>
                </button>
            </div>
            <div class="guide-modal__content">
                <div id="allfurn-guide">
                    <div class="textfield">
                        <div class="dropdown text--gray">
                            <p class="dropdown__title">이용가이드</p>
                            <div class="dropdown__wrap">
                                <a class="dropdown__item" data-name="guide-01">
                                    <span>상품 주문하기</span>
                                </a>
                                <a class="dropdown__item" data-name="guide-02">
                                    <span>장바구니</span>
                                </a>
                                <a class="dropdown__item" data-name="guide-03">
                                    <span>관심 상품 폴더 관리</span>
                                </a>
                                <a class="dropdown__item" data-name="guide-04">
                                    <span>상품 찾기</span>
                                </a>
                                <a class="dropdown__item" data-name="guide-05">
                                    <span>상품 문의</span>
                                </a>
                                <a class="dropdown__item" data-name="guide-06">
                                    <span>업체 찾기</span>
                                </a>
                                <a class="dropdown__item" data-name="guide-07">
                                    <span>업체 문의</span>
                                </a>
                                <a class="dropdown__item" data-name="guide-08">
                                    <span>상품 등록</span>
                                </a>
                                <a class="dropdown__item" data-name="guide-09">
                                    <span>상품 관리</span>
                                </a>
                                <a class="dropdown__item" data-name="guide-10">
                                    <span>업체 관리</span>
                                </a>
                                <a class="dropdown__item" data-name="guide-11">
                                    <span>커뮤니티 활동</span>
                                </a>
                                <a class="dropdown__item" data-name="guide-12">
                                    <span>거래 관리</span>
                                </a>
                                <a class="dropdown__item" data-name="guide-13">
                                    <span>주문 관리</span>
                                </a>
                                <a class="dropdown__item" data-name="guide-14">
                                    <span>내 정보 수정</span>
                                </a>
                                <a class="dropdown__item" data-name="guide-15">
                                    <span>직원 계정 추가</span>
                                </a>
                                <a class="dropdown__item" data-name="guide-16">
                                    <span>정회원 승격 요청</span>
                                </a>
                                <a class="dropdown__item" data-name="guide-17">
                                    <span>올펀 문의하기</span>
                                </a>
                                <a class="dropdown__item" data-name="guide-18">
                                    <span>기타 회원 권한</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <section>
                        <div>
                            <h2><p>상품 주문하기</p></h2>
                            <div class="guidance" data-name="guide-01" aria-hidden="false">
                                <ul class="desc">
                                    <li>상품 상세 화면에서 상품을 바로 주문하거나 장바구니<br>에서 여러 업체의 상품을 한 번에 주문하실 수 있습니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance01-1.png" /></div>
                                        <div class="text"><span>1</span><b>[주문하기]</b> 버튼을 누르시면 하단에서 <br>옵션 선택 영역이 노출됩니다.</div>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance01-2.png" /></div>
                                        <div class="text"><span>2</span>상품마다 상이한 필수/선택 옵션을 선택합니다.</div>
                                        <div class="text"><span>3</span>선택한 옵션과 주문 금액을 확인하고 <br><b>[바로 주문]</b> 버튼을 눌러주세요.</div>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance01-3.png" /></div>
                                        <div class="text"><span>4</span>주문자 정보, 배송지 정보, 주문 정보를 확인하신 후 <br>하단의 <b>[주문 완료]</b> 버튼을 눌러주세요.</div>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance01-4.png" /></div>
                                        <div class="text"><span>5</span><b>[주문 현황 보기]</b>로 주문 현황을 바로 확인하거나 <br><b>[쇼핑 계속하기]</b>로 다른 상품을 구경하실 수 있습니다.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-02" aria-hidden="true">
                                <ul class="desc">
                                    <li>홈, 상품 상세, 업체 상세, 카테고리, 마이올펀 화면 <br>우측 상단에 있는 장바구니 아이콘을 누르면 장바구니 <br>화면으로 이동합니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance02-1.png" /></div>
                                        <div class="text"><span>1</span><b>[업체 보러가기]</b>를 통해 장바구니에 담은 상품의 판매 업체 <br>상세 화면을 확인하실 수 있습니다.</div>
                                        <div class="text"><span>2</span>상품별로 옵션 및 수량 변경과 바로 주문, 삭제가 가능합니다.</div>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance02-2.png" /></div>
                                        <div class="text"><span>3</span>선택된 상품의 총주문 금액과 개수를 확인하고 <br>하단의 <b>[상품 주문하기]</b> 버튼으로 주문을 진행해주세요.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-03" aria-hidden="true">
                                <ul class="desc">
                                    <li>상품 리스트나 상품 상세 화면에서 북마크 아이콘을 <br>누르면 나의 관심 상품으로 설정됩니다.</li>
                                    <li>관심 상품 리스트는 하단 내비게이션 바의 [마이올펀] > <br>관심 상품 메뉴에서 확인하실 수 있습니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance03-1.png" /></div>
                                        <div class="text"><span>1</span>우측 상단 <b>[폴더 관리]</b> 버튼을 누르면 폴더를 추가하거나 폴더명을 변경하실 수 있습니다.</div>
                                        <div class="text"><span>2</span>화면 중간 <b>[편집]</b> 버튼을 누르면 각 상품에 체크박스가 표시되며 상품을 원하는 폴더로 이동시키거나 삭제시킬 수 있습니다.</div>
                                        <ul class="text">
                                            <li class="text"><span>A</span>이동시키고 싶은 상품을 체크 선택해주세요.</li>
                                            <li class="text"><span>B</span><b>[폴더 이동]</b> 버튼을 누르면 하단에서 노출되는 폴더 리스트에서 이동시킬 폴더를 선택합니다.</li>
                                        </ul>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance03-2.png" /></div>
                                        <div class="text"><span>3</span>폴더 편집이 끝난 뒤 <b>[완료]</b> 버튼을 누르면 <br>편집 상태가 종료됩니다.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-04" aria-hidden="true">
                                <ul class="desc">
                                    <li>하단 내비게이션 바의 [홈]이나 [카테고리]에서 상품을 <br>찾아보실 수 있습니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance04-1.png" /></div>
                                        <div class="tag">검색</div>
                                        <div class="text"><span>1</span>상단 검색 바에서 검색할 상품명이나 상품의 속성을 <br>입력해주세요.</div>
                                        <div class="text"><span>2</span>띄어쓰기나 영문, 숫자가 포함된 검색어는 동일하게 입력해야 <br>검색 결과에 반영됩니다.</div>
                                        <div class="text"><span>3</span>검색 후 검색 결과에 해당되는 상품은 좌측 상품 탭에서 <br>확인하실 수 있습니다.</div>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance04-2.png" /></div>
                                        <div class="tag">카테고리</div>
                                        <div class="text"><span>1</span>찾고자 하는 상품의 카테고리를 선택해주세요.</div>
                                        <div class="text"><span>2</span>대분류 카테고리에 포함된 중분류 카테고리를 <br>선택해주시면 세분화된 상품 결과를 확인하실 수 있습니다.</div>
                                        <div class="text"><span>3</span>중분류 선택 시 노출되는 속성 필터로 더욱 세분화된 상품 <br>결과를 확인해보세요.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-05" aria-hidden="true">
                                <ul class="desc">
                                    <li>상품 상세 화면에서 [전화], [문의] 버튼으로 상품에 <br>관해 문의하실 수 있습니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance05-1.png" /></div>
                                        <div class="text"><span>1</span><b>[전화]</b> 버튼을 누르시면 판매 업체의 대표 번호로 <br>전화가 연결됩니다.</div>
                                        <div class="text"><span>2</span><b>[문의]</b> 버튼을 누르시면 판매 업체와 1:1 메세지 <br>화면으로 이동합니다.</div>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance05-2.png" /></div>
                                        <div class="text"><span>3</span>메세지 입력창 위 노출되는 상품명으로 문의할 <br>상품이 맞는지 확인해주세요.</div>
                                        <div class="text"><span>4</span>자동 입력된 메세지를 바로 전송하거나 수정하여 <br>상품을 문의하실 수 있습니다.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-06" aria-hidden="true">
                                <ul class="desc">
                                    <li>하단 내비게이션 바의 [홈]에서 업체를 검색해보실 수 <br>있습니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance06-1.png" /></div>
                                        <div class="text"><span>1</span>상단 검색 바에서 검색할 업체명이나 업체 <br>대표자명을 입력해주세요.</div>
                                        <div class="text"><span>2</span>띄어쓰기나 영문, 숫자가 포함된 검색어는 <br>동일하게 입력해야 검색 결과에 반영됩니다.</div>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance06-2.png" /></div>
                                        <div class="text"><span>3</span>검색 후 검색 결과에 해당되는 업체는 우측 <br>업체탭에서 확인하실 수 있습니다.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-07" aria-hidden="true">
                                <ul class="desc">
                                    <li>하단 내비게이션 바의 [홈]에서 업체를 검색해보실 수 있습니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance07-1.png" /></div>
                                        <div class="text"><span>1</span><b>[전화]</b> 버튼을 누르시면 업체의 대표 번호로 <br>전화가 연결됩니다.</div>
                                        <div class="text"><span>2</span><b>[문의]</b> 버튼을 누르시면 업체와 1:1 메세지 <br>화면으로 이동합니다.</div>
                                        <div class="text"><span>3</span>생성된 메세지 화면에서 자유롭게 문의해주세요.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-08" aria-hidden="true">
                                <ul class="desc">
                                    <li>하단 내비게이션 바 [홈]에서 도매 정회원에게만 <br>노출되는 우측 하단 [+] 플로팅 버튼을 눌러 상품을 <br>등록해주세요.</li>
                                    <li>상품을 5개 이상 등록해야 도매 업체 리스트에 업체가 <br>노출됩니다.</li>
                                    <li>모바일앱에서는 상품명과 카테고리만 입력하시면 임시 <br>저장됩니다. 등록 중인 상품은 하단 내비게이션 바의 <br>[마이올펀] > 상품 관리 > 임시 등록 탭에서 확인하실 <br>수 있습니다.</li>
                                    <li>모바일앱에서는 상품의 임시 등록만 가능하며 상품 <br>등록 신청은 데스크탑 웹에서만 가능합니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance08-1.png" /></div>
                                        <div class="text"><span>1</span><b>[+]</b> 버튼을 누르시면 상품 등록 화면이 노출됩니다.</div>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance08-2.png" /></div>
                                        <div class="text"><span>2</span><b>[이전]</b> 버튼은 이전 화면으로 이동, [다음] 버튼은 다음 단계 <br>화면으로 이동합니다. <b>[다음]</b> 버튼에는 현재 등록 중인 단계가 <br>표기됩니다.</div>
                                        <div class="text"><span>3</span><b>[미리 보기]</b> 버튼으로 등록한 상품 정보가 어떻게 보이는지 <br>확인하실 수 있습니다.</div>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance08-3.png" /></div>
                                        <div class="tag">상품 기본 정보</div>
                                        <ul class="desc">
                                            <li>등록하는 상품의 상품명, 이미지, 카테고리, 가격, 가격 노출 여부, <br>결제 방식, 상품 코드, 배송 방법, 추가 공지, 인증 정보, <br>상세 내용을 입력합니다.</li>
                                            <li>상품의 성격에 맞는 카테고리 대분류와 중분류를 선택해주세요.</li>
                                            <li>상품 속성은 등록하는 상품의 사양에 맞는 항목을 모두<br>선택해주세요.</li>
                                            <li>입력한 상품 가격의 노출 여부를 선택해주시고 미 노출인 경우, <br>가격 대신 노출할 안내 문구를 선택해주시면 됩니다.</li>
                                            <li>결제 방식은 상품별 1개의 방식만 선택하거나 직접 입력하실 수<br>있습니다.</li>
                                            <li>상품 코드를 입력하시면 상품 분별을 위해 자체적으로<br>사용하고 있는 코드로 서비스 내에서도 상품 관리에<br>활용하실 수 있습니다.</li>
                                            <li>배송 방법은 상품별 총 6개까지 추가 가능합니다.</li>
                                            <li class="sub"><b>[배송 방법 추가]</b> 버튼을 누르고 노출되는 화면에서 <br>배송 방법을 선택해주세요.</li>
                                            <li class="sub">배송 방법 선택 혹은 직접 입력 후, 해당 배송의 가격을 <br>무료/착불 중에 선택해주세요.</li>
                                            <li class="sub"><b>[추가하기]</b> 버튼을 누르면 배송 방법이 추가됩니다.</li>
                                            <li>상품 등록 시 입력한 항목 외에도 추가로 공지하고 싶은 사항이 <br>있다면 ‘상품 추가 공지’ 항목에 자유롭게 입력해주시면 됩니다.</li>
                                            <li><b>[인증 정보 선택]</b> 버튼을 누르고 등록 상품에 해당되는 <br>인증 정보를 모두 선택해주세요.</li>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance08-4.png" /></div>
                                        <div class="tag">상품 상세 내용</div>
                                        <ul class="desc">
                                            <li>상품 상세 화면에서 상품 정보로 보여지는 영역으로, <br>자유롭게 입력하실 수 있습니다.</li>
                                            <li>서체 편집, 텍스트 맞춤, 링크 삽입, 이미지 첨부가 가능합니다. <br>데스크탑 웹에서는 더 상세한 기능을 사용하실 수 있습니다.</li>
                                            <li>상품이 돋보일 수 있는 설명과 이미지로 구성해주시면 됩니다.</li>
                                        </ul>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance08-5.png" /></div>
                                        <div class="tag">상품 주문 옵션</div>
                                        <ul class="desc">
                                            <li>옵션값의 가격은 주문 시 고객이 상품의 해당 옵션을 선택하는 <br>경우, 상품 가격에 옵션값 가격만큼 추가됩니다.</li>
                                            <li>옵션값의 가격을 입력하지 않은 경우, 해당 옵션값의 가격은 <br>0원으로 설정됩니다.</li>
                                        </ul>
                                        <div class="text"><span>1</span><b>[주문 옵션 추가]</b> 버튼을 눌러 옵션을 추가합니다.</div>
                                        <div class="text"><span>2</span>필수 옵션 여부를 설정하고 옵션 명과 옵션값을 입력합니다.</div>
                                        <div class="text"><span>3</span><b>[옵션값 추가]</b> 버튼으로 옵션값을 추가합니다.</div>
                                        <div class="text"><span>4</span>추가한 옵션이 2개 이상인 경우, <b>[옵션 순서 변경]</b> 버튼이 활성화되며 옵션의 순서를 변경하실 수 있습니다.</div>
                                        <ul class="text">
                                            <li class="text"><span>A</span>좌측의 순서 변경 아이콘을 드래그하여 순서를 변경해주세요.</li>
                                            <li class="text"><span>B</span><b>[변경 완료]</b> 버튼을 눌러야 변경된 순서가 반영됩니다.</li>
                                        </ul>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance08-6.png" /></div>
                                        <div class="tag">상품 주문 정보</div>
                                        <ul class="desc">
                                            <li><b>[설정]</b> 버튼을 누르고 등록 상품의 결제, 배송, 교환/반품/취소<br>관련한 정보를 입력해주세요.</li>
                                            <li>추가로 주문 관련하여 입력할 정보가 있다면 <br>‘주문 정보 직접 입력’ 항목의 <b>[설정]</b> 버튼을 누르고 항목 제목과 <br>내용을 직접 입력해주세요.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-09" aria-hidden="true">
                                <ul class="desc">
                                    <li>상품 상세 화면에서 <b>[전화], [문의]</b> 버튼으로 상품에 <br>관해 문의하실 수 있습니다.</li>
                                    <li>상품 관리 화면에는 등록 신청이 완료된 상품은 등록 <br>탭에서, 임시 등록된 상품은 임시 등록 탭에서 <br>확인하실 수 있습니다.</li>
                                    <li>‘승인 대기’와 ‘반려’, 관리자에 의한 ‘판매 중지’ <br>상태에는 상품의 상태 변경이 불가합니다.</li>
                                    <li>‘승인 대기’와 관리자에 의한 ‘판매 중지’ 상태에는 <br>상품의 수정이 불가합니다.</li>
                                    <li>거래 중인 상품의 경우, 상태 변경과 정보 수정을 <br>주의해주세요.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance09-1.png" /></div>
                                        <div class="tag">추천 상품 설정</div>
                                        <ul class="desc">
                                            <li>설정하신 추천 상품은 업체 상세 화면과 판매 상품 상세의 <br>하단에 노출됩니다.</li>
                                            <li>‘판매 중’ 상태의 상품 우측에 있는 별 아이콘을 누르시면 추천 <br>상품으로 설정되거나 해지됩니다.</li>
                                            <li>추천 상품으로 설정되어있는 상품은 상태 변경이 불가합니다.</li>
                                        </ul>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance09-2.png" /></div>
                                        <div class="tag">상품 상태 변경 및 수정</div>
                                        <ul class="desc">
                                            <li><b>[상태 변경]</b> 버튼을 누르면 노출되는 리스트에서 변경시킬 <br>상태를 선택해주세요. </li>
                                            <li>등록 탭에 있는 <b>[수정]</b> 버튼을 누르면 상품 수정 화면으로 <br>이동되며, 임시 등록 탭의 <b>[수정]</b> 버튼을 누르면 상품 등록 중인 <br>화면으로 이동됩니다.</li>
                                            <li>상품명을 누르시면 노출되는 미리보기 화면에서 하단의 <br><b>[상품 삭제]</b> 버튼으로 상품을 삭제하실 수 있습니다.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-10" aria-hidden="true">
                                <ul class="desc">
                                    <li>하단 내비게이션 바의 [마이올펀] > 업체 관리 메뉴에서 <br>업체 상세 정보를 관리하실 수 있습니다.</li>
                                    <li>도매 정회원의 경우, 최초 로그인 시 업체 관리 화면으로 <br>이동됩니다.</li>
                                    <li>업체 소개나 정보를 입력하시고 상품을 5개 이상 등록<br>해야 도매 업체 리스트에 업체가 노출됩니다.</li>
                                    <li>업체 정보는 입력하신 항목만 업체 상세 화면에 <br>노출됩니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance10-1.png" /></div>
                                        <div class="text"><span>1</span>업체명 좌측에 있는 <i class="ico__camera"></i> 카메라 아이콘을 눌러 <br>업체 로고 이미지를 업로드해주세요.</div>
                                        <div class="text"><span>2</span><b>[문의]</b> 버튼을 누르시면 업체와 1:1 메세지 <br>화면으로 이동합니다.</div>
                                        <div class="text"><span>3</span>생성된 메세지 화면에서 자유롭게 문의해주세요.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-11" aria-hidden="true">
                                <ul class="desc">
                                    <li>우측 상단의 사람 아이콘을 눌러 커뮤니티 내 나의 활동 <br>사항을 확인하실 수 있습니다.</li>
                                    <li>우측 하단 펜 모양의 플로팅 버튼을 눌러 게시글을 <br>작성해주세요.</li>
                                    <li>비즈니스 게시판을 구독하시면 새 게시글 알림을 받아<br>보실 수 있습니다. [구독하기] 버튼을 통해 구독을 <br>설정/해지하실 수 있습니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance11-1.png" /></div>
                                        <div class="tag">내 활동</div>
                                        <ul class="desc">
                                            <li>작성한 게시글, 댓글 및 답글, 좋아요한 게시글을<br>확인하실 수 있습니다.</li>
                                            <li>내가 작성한 게시글, 댓글 및 답글만 삭제하실 수 있습니다.</li>
                                            <li>관리자에 의해 작성한 게시글이 숨김 처리될 수 있습니다. <br>관리자 문의는 마이올펀 > 고객센터 > 1:1 문의를 <br>이용해주세요.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-12" aria-hidden="true">
                                <ul class="desc">
                                    <li>하단 내비게이션 바의 [마이올펀] > 거래 현황 <br>메뉴에서 상품별, 업체별 탭으로 거래 현황을 <br>확인하실 수 있습니다.</li>
                                    <li>거래 상태에 따라 변경되는 버튼을 클릭하여 거래를 <br>관리해주세요.</li>
                                    <li>거래 취소는 거래 확정 전에만 가능하며, 상품별 혹은 <br>전체 거래 취소가 가능합니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance12-1.png" /></div>
                                        <div class="row">
                                            <p><strong class="status status--solid">신규 주문</strong></p>
                                            <div class="text">주문이 새로 들어온 상태로, 주문을 진행하려면 <br>[거래 확정] 버튼을 누르고 상품을 준비해주세요.</div>
                                        </div>
                                        <div class="row">
                                            <p><strong class="status status--solid">상품 준비 중</strong></p>
                                            <div class="text">거래 확정 이후, 발송하기 전 단계입니다. <br>준비가 완료되었다면 [배차 신청] 버튼으로 <br>배차를 신청하거나 [발송] 버튼을 누르고 <br>상품을 발송해주세요.</div>
                                        </div>
                                        <div class="row">
                                            <p><strong class="status status--solid">발송 중</strong></p>
                                            <div class="text">발송 이후, 거래 완료 전 단계입니다. 발송이 <br>완료되었다면 [발송 완료] 버튼을 눌러주세요. <br>구매자에게 구매 확정 요청이 전달됩니다.</div>
                                        </div>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance12-2.png" /></div>
                                        <div class="row">
                                            <p><strong class="status status--trans">구매 확정 대기</strong></p>
                                            <div class="text">발송 완료 이후, 구매 확정 대기 상태입니다. <br>구매자가 구매 확정을 진행해야 거래가 완료됩니다.</div>
                                        </div>
                                        <div class="row">
                                            <p><strong class="status status--black">거래 완료</strong></p>
                                            <div class="text">구매자가 구매 확정을 진행하여 거래가 <br>완료된  상태입니다.</div>
                                        </div>
                                        <div class="row">
                                            <p><strong class="status status--gray">거래 취소</strong></p>
                                            <div class="text">거래 확정 전, 전체 거래가 취소된 경우 <br>‘거래 취소’로 상태가 표기됩니다.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-13" aria-hidden="true">
                                <ul class="desc">
                                    <li>하단 내비게이션 바의 [마이올펀] > 주문 현황 메뉴에서 <br>주문 현황을 확인하실 수 있습니다.</li>
                                    <li>판매자의 거래 관리에 따라 주문 상태가 변경됩니다.</li>
                                    <li>주문 취소는 거래 확정 전까지만 가능하며, 상품별 혹은 <br>전체 주문 취소가 가능합니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance13-1.png" /></div>
                                        <div class="row">
                                            <p><strong class="status status--trans">구매 확정 대기</strong></p>
                                            <div class="text">발송이 완료되었다면 <b>[구매 확정]</b> 버튼을 <br>눌러주세요. 거래가 완료됩니다.</div>
                                        </div>
                                        <div class="row">
                                            <p><strong class="status status--gray">주문 취소</strong></p>
                                            <div class="text">거래 확정 전, 전체 거래가 취소된 경우 <br>‘거래 취소’로 상태가 표기됩니다.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-14" aria-hidden="true">
                                <ul class="desc">
                                    <li>하단 내비게이션 바의 [마이올펀] > 계정 관리 메뉴에서 <br>내 정보를 수정하실 수 있습니다.</li>
                                    <li>사업자 등록 번호, 업체명, 대표자명은 고객센터 문의를 <br>통해 변경 요청해주세요.</li>
                                    <li>휴대폰 번호와 사업자 주소는 직접 수정이 가능합니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance14-1.png" /></div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-15" aria-hidden="true">
                                <ul class="desc">
                                    <li>하단 내비게이션 바의 [마이올펀] > 계정 관리 메뉴에서 <br>직원 계정을 추가하실 수 있습니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance15-1.png" /></div>
                                        <div class="text"><span>1</span>하단의 <b>[계정 추가]</b> 버튼을 눌러주세요.</div>
                                        <div class="text"><span>2</span>이름, 휴대폰 번호, 아이디, 비밀번호를 입력하고 <br><b>[완료]</b> 버튼을 눌러주세요.</div>
                                        <div class="text"><span>3</span>최대 5명까지 추가 가능하며, 생성한 직원 계정의 <br>아이디와 비밀번호는 직접 공유해주시면 됩니다.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-16" aria-hidden="true">
                                <ul class="desc">
                                    <li>하단 내비게이션 바의 [마이올펀] > 계정 관리 메뉴에서 <br>정회원 승격을 요청하실 수 있습니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance16-1.png" /></div>
                                        <div class="text"><span>1</span>하단의 <b>[정회원 승격 요청]</b> 버튼을 눌러주세요. </div>
                                        <div class="text"><span>2</span>활동하고자 하는 정회원 구분을 선택해주세요.</div>
                                        <div class="text"><span>3</span>정회원 승격에 필요한 회원 정보를 입력해주세요. </div>
                                        <div class="text"><span>4</span>정회원 승격 요청 완료 후, 승인 문자를 확인하고 <br>동일한 이메일로 로그인해주시면 됩니다.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-17" aria-hidden="true">
                                <ul class="desc">
                                    <li>하단 내비게이션 바의 [마이올펀] > 계정 관리 메뉴에서 <br>정회원 승격을 요청하실 수 있습니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance17-1.png" /></div>
                                        <div class="text"><span>1</span>고객센터 <b>[1:1 문의하기]</b> 버튼을 눌러주세요.</div>
                                        <div class="text"><span>2</span>문의 유형을 선택해주시고 문의할 내용을 입력해주세요.</div>
                                        <div class="text"><span>3</span>하단 <b>[문의하기]</b> 버튼을 눌러 문의를 완료해주세요.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-18" aria-hidden="true">
                                <ul class="desc">
                                    <li>해당 이용 가이드는 정회원 도매 기준으로 작성된 <br>것으로, 정회원 소매 및 일반 회원의 기능과 다르거나 <br>권한이 없을 수 있습니다.</li>
                                    <li>상품 등록 및 관리, 거래 기능은 도매 회원만 사용 <br>가능합니다.</li>
                                    <li>일반 회원의 경우, 사업자 미등록으로 도소매 플랫폼 <br>특성상 주문이나 문의 관련 기능에 제약이 있습니다. <br>정상적인 올펀 서비스 이용을 원하시면 하단 <br>내비게이션 바의 [마이올펀] > 계정 관리에서 정회원 승격 <br>요청을 진행해주세요.</li>
                                </ul>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="default-modal__footer"></div>
        </div>
    </div>
@endsection

@section('script')
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>

    <script>
        var storedFiles = [];
        var subCategoryIdx = null;
        var deleteImage = [];
        var proc = false;
        var authList = ['KS 인증', 'ISO 인증', 'KC 인증', '친환경 인증', '외코텍스(OEKO-TEX) 인증', '독일 LGA 인증', 'GOTS(오가닉) 인증', '라돈테스트 인증', '전자파 인증', '전기용품안전 인증'];
        editer = null;

        function init_editor() {
            editer = new FroalaEditor('.guide__smart-editor', {
                key: "wFE7nG5E4I4D3A11A6eMRPYf1h1REb1BGQOQIc2CDBREJImA11C8D6B5B1G4D3F2F3C8==",
                requestHeaders: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                // fullPage: true,
                height:300,
                useClasses: false,

                imageUploadParam: 'file',
                imageUploadURL: '/product/image',
                imageUploadParams: {folder: 'product'},
                imageUploadMethod: 'POST',
                imageMaxSize: 20 * 1024 * 1024,
                imageAllowedTypes: ['jpeg', 'jpg', 'png', 'gif'],

                events: {
                    'image.inserted': function ($img, response) {
                        var obj = $.parseJSON(response);
                        $img.data('idx', obj.idx);
                    },
                    'image.removed': function ($img) {
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            method: "DELETE",
                            url: "/product/image",
                            data: {
                                src: $img.attr('src'),
                                idx: $img.data('idx')
                            }
                        })
                    },
                }
            });
        }

        function img_reload_order() {
            $('.desc__product-img-wrap').find('.add__badge').remove();
            $('li .product-img__add').first().children('.add__img-wrap').prepend('<p class="add__badge">대표이미지</p>');
        }

        function img_add_order() {
                $('.desc__product-img-wrap li').each(function(n) {
                    $(this).attr('item', n);
                });
            }

        $(function() {
                $('.desc__product-img-wrap').sortable({
                    cursor: 'move',
                    placeholder: 'highlight',
                    start: function (event, ui) {
                        ui.item.toggleClass('highlight');
                    },
                    stop: function (event, ui) {
                        ui.item.toggleClass('highlight');
                    },
                    update: function () {
                        img_reload_order();
                    }
                });
                $('.desc__product-img-wrap').disableSelection();
            });

        // Delete Image from Queue
        $('body').on('click','.ico__delete--circle',function(e){
            e.preventDefault();
            var file = $(this).parent().parent().attr('file');
            var idx = $(this).parent().parent().index();

            $(this).parent().parent().remove('');
            for(var i = 0; i < storedFiles.length; i++) {
                if(storedFiles[i].name == file) {
                    storedFiles.splice(i, 1);
                    break;
                }
            }

            img_reload_order();

            if ($('.product-img__add').length < 8) {
                $('li .product-img__gallery').show();
            }
        });

        $('body').on('change', '#form-list02', function() {
            var files = this.files;
            var i = 0;

            for (i = 0; i < files.length; i++) {
                var readImg = new FileReader();
                var file = files[i];

                if (file.type.match('image.*')){
                    storedFiles.push(file);
                    readImg.onload = (function(file) {
                        return function(e) {
                            let imgCnt = $('.product-img__add').length + 1;

                            if (imgCnt == 9) {
                                openModal('#alert-modal08');
                                return;
                            }

                            $('.desc__product-img-wrap').append(
                                '<li class="product-img__add" file="' + file.name +  '">' +
                                '<div class="add__img-wrap">' +
                                '<img src="' + e.target.result + '" alt="상품이미지0' + imgCnt + '">' +
                                '<button type="button" class="ico__delete--circle">' +
                                '<span class="a11y">삭제</span>' +
                                '</button>' +
                                '</div>' +
                                '</li>'
                            );

                            if (imgCnt == 1) {
                                $('.add__img-wrap').prepend('<p class="add__badge">대표이미지</p>');
                            }

                            if (imgCnt == 8) {
                                $('li .product-img__gallery').hide();
                            }
                        };
                    })(file);
                    readImg.readAsDataURL(file);

                } else {
                    alert('the file '+ file.name + ' is not an image<br/>');
                }

                if(files.length === (i+1)){
                    setTimeout(function(){
                        img_add_order();
                    }, 1000);
                }
            }
        });

        $('body').on('click', '#category-step1 li, #category-step2 li', function (e) {
            if ($(this).is('.step1')) {
                $('#category-step2').remove();
                $('.list-item--selected.active span').text('');
                $('#category-step1 li, .list-item--selected').removeClass('active');
                $('.list__desc.property .list').html('');

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url				: '/product/getCategoryList/' + $(this).data('category_idx'),
                    data			: {},
                    type			: 'POST',
                    dataType		: 'json',
                    success		: function(result) {
                        let htmlText = '<ul class="desc__category desc__category--sub" id="category-step2">';
                        result.forEach(function (e, idx) {
                            htmlText += '<li class="category__list-item step2" data-category_idx="'+e.idx+'" data-code="'+e.code+'">' +
                                '<span>' + e.name + '</span>' +
                                '</li>'
                        })
                        htmlText += '</ul>';

                        $('#category-step1').parent().append(htmlText);
                        if (subCategoryIdx != null) {
                            $('#category-step2 .category__list-item.step2[data-category_idx='+subCategoryIdx+']').click();
                            subCategoryIdx = null;
                        }
                    }
                });
            } else {
                $('#category-step2 li').removeClass('active');
                $('.list-item--selected').addClass('active');
                $('.list-item--selected.active span').text($('#category-step1 li.active span').text()+' > '+$(this).text());
                $('.list-item--selected.active span').data('category_idx', $(this).data('category_idx'));

                getProperty(null);
            };

            $(this).addClass('active');
        });

        function getProductList(type) {
            $('#default-modal10 .default-modal__footer button').data('type', type);
            $('#default-modal10 .checkbox__checked.checked--single:checked').prop('checked', false);
            openModal('#default-modal10');
        }

        function loadProduct() {
            let loadType = $('#default-modal10 .default-modal__footer button').data('type');
            let tempIdx = getUrlVars()["temp"];
            var url = '/product/getProductData/';

            if (loadType == 0 && tempIdx != null) {
                url += tempIdx +'?type=temp';
            } else {
                url += $('#default-modal10 input[name="order-info"]:checked').data('product_idx');
            }

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url				: url,
                data			: {},
                type			: 'POST',
                dataType		: 'json',
                success		: function(result) {
                    result = result['data']['detail'];
                    if (loadType == 0 || loadType == 1) {
                        $('#form-list01').val(result['name']);
                        subCategoryIdx = result['category_idx'];
                        $('.category__list-item.step1[data-category_idx=' + result['category_parent_idx'] + ']').click();

                        setTimeout(function () {
                            var parentIdx = 0;

                            result['propertyList'].map(function (item) {
                                console.log(item['parent_idx'], + '|' + parentIdx);
                                if (parentIdx == '' || item['parent_idx'] != parentIdx) {
                                    parentIdx = item['parent_idx'];
                                    $('.list__desc.property ul.select-group__result[data-property_idx="' + item['parent_idx'] + '"]').html('');
                                }

                                $('.list__desc.property ul.select-group__result[data-property_idx="' + item['parent_idx'] + '"]').append(
                                    '<li data-sub_idx="' + item.idx + '">' +
                                    '<span class="property_name">' + item['property_name'] + '</span>' +
                                    '<i class="ico__delete16"><span class="a11y">삭제</span></i>' +
                                    '</li>'
                                )
                            });
                        }, 500);


                        if (result['attachment'] != null) {
                            imageAddBtn = $('li.product-img__gallery').clone();
                            $('.desc__product-img-wrap').html(imageAddBtn);
                            attIdx = result['attachment_idx'].split(',');

                            result['attachment'].map(function (item, i) {
                                if (item != null) {
                                    $('.desc__product-img-wrap').append(
                                        '<li class="product-img__add" file="" data-idx="' + attIdx[i] + '" >' +
                                        '<div class="add__img-wrap">' +
                                        '<img src="' + item['imgUrl'] + '" alt="상품이미지0' + (i + 1) + '">' +
                                        '<button type="button" class="ico__delete--circle">' +
                                        '<span class="a11y">삭제</span>' +
                                        '</button>' +
                                        '</div>' +
                                        '</li>'
                                    );
                                }
                            })
                            $('.desc__product-img-wrap').find('.add__badge').remove();
                            $('li .product-img__add').first().children('.add__img-wrap').prepend('<p class="add__badge">대표이미지</p>');

                            $('.desc__product-img-wrap li.product-img__add:first .add__img-wrap').prepend('<p class="add__badge">대표이미지</p>');
                            if (result['attachment'].length == 8) {
                                $('li .product-img__gallery').hide();
                            }
                        }

                        $('#product-price').val(result['price']);

                        var delivery = '';
                        result['delivery_info'].split(',').forEach(str => {
                            delivery += '<li><span class="add__name">' + $.trim(str) + '</span><i class="ico__delete16"><span class="a11y">삭제</span></i></li>';
                        })
                        $('.shipping-wrap__add ul').html(delivery);

                        $('.shipping-wrap__add').addClass('active');
                        $('#form-list09').val(result['notice_info']);
                        $('#auth_info').text(result['auth_info']);
                        $('.auth-wrap__selected').addClass('active');

                        result['auth_info'].split(', ').forEach(str => {
                            if (authList.indexOf(str) == -1) {
                                $('#default-modal07 .content__list input[data-auth="기타 인증"]').attr('checked', true);
                                $('#auth_info_text').val(str);
                                $('#auth_info_text').css('display', 'block');
                            } else {
                                $('#default-modal07 .content__list input[data-auth="' + str + '"]').attr('checked', true);
                            }
                        });

                        editer.html.set(result['product_detail']);

                        var obj = $.parseJSON(result['product_option']);
                        obj.forEach(function (item, i) {
                            if (i > 0) {
                                addOrderOption();
                            }
                            $('input[name="option-required_0' + (i + 1) + '"][value=' + item.required + ']').prop('checked', true);
                            $('input#option-name_0' + (i + 1)).val(item.optionName);

                            item.optionValue.forEach(function (value, y) {
                                if (y > 0) {
                                    $('input#option-property_0' + (i + 1) + '-' + (y)).parent().find('.input__add-btn').click();
                                }
                                $('input#option-property_0' + (i + 1) + '-' + (y + 1)).val(value.propertyName);
                                $('input#option-property_0' + (i + 1) + '-' + (y + 1)).parent().find('input[name="option-price"]').val(value.price);
                            })
                        });

                        $('#form-list07').val(result['product_code']);

                        
                        console.log('is_price_open', result['is_price_open']);

                        if (result['is_price_open'] == 1) {
                            $('#price01').attr('checked', true);
                            $('#price02').attr('checked', false);
                            $('.select-group__dropdown.price_open').css('display', 'none');
                        } else {
                            $('#price01').attr('checked', false);
                            $('#price02').attr('checked', true);
                            $('.select-group__dropdown.price_open').css('display', 'block');
                            if (result['price_text'] != null) {
                                $('.price_open .dropdown__title').text(result['price_text'])
                            }
                        }
                        

                        if (result['pay_type'] != 4) {
                            $('payment__input-wrap').css('display', 'none');
                        } else {
                            $('payment__input-wrap').css('display', 'block');
                        }
                    }

                    if (loadType == 0 || loadType == 2) {
                        if (result['is_pay_notice'] == 0) {
                            $('.textarea-wrap.margin-top16.is_pay').hide();
                        } else {
                            $('#pay_notice').val(result['pay_notice']);
                            $('.textarea-wrap.margin-top16.is_pay').show();
                        }

                        if (result['is_delivery_notice'] == 0) {
                            $('.textarea-wrap.margin-top16.is_delivery').hide();
                        } else {
                            $('#delivery_notice').val(result['delivery_notice']);
                            $('.textarea-wrap.margin-top16.is_delivery').show();
                        }

                        if (result['is_return_notice'] == 0) {
                            $('.textarea-wrap.margin-top16.is_return').hide();
                        } else {
                            $('#return_notice').val(result['return_notice']);
                            $('.textarea-wrap.margin-top16.is_return').show();
                        }

                        if (result['is_order_notice'] == 0) {
                            $('#order_title').parent().css('display', 'none');
                        } else {
                            $('#order_title').val(result['order_title']);
                            $('#order_content').val(result['order_content']);
                            $('#order_title').parent().css('display', 'block');
                        }

                        $('input[name="order-info01"][value=' + result['is_pay_notice'] + '],' +
                            'input[name="order-info02"][value=' + result['is_delivery_notice'] + '],' +
                            'input[name="order-info03"][value=' + result['is_return_notice'] + '],' +
                            'input[name="order-info04"][value=' + result['is_order_notice'] + ']').prop('checked', true);

                        $('.sales_product_num').text(result['product_number']);
                        if (result['access_date'] != null && result['access_date'] != '') {
                            $('.access_date').text(result['access_date'].split(' ')[0].replace(/-/g, '.'));
                        }
                    }

                    closeModal('#default-modal10');
                }
            });
        }

        // 속성 가져오기
        function getProperty(parentIdx, title) {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url				: '/product/getCategoryProperty',
                data			: {
                    'category_idx' : $('.list-item--selected.active span').data('category_idx'),
                    'parent_idx' : parentIdx
                },
                type			: 'POST',
                dataType		: 'json',
                success		: function(result) {
                    if (parentIdx == null) {
                        var htmlText = '<ul class="desc__select-group">';

                        result.forEach(function (e, idx) {
                            htmlText += '<li class="desc__select-group--item" data-property_idx=' + e.idx + '>' +
                                '<span class="item__text">' + e.name + '</span>' +
                                '<button type="button" class="button" onclick="getProperty(' + e.idx + ', \'' + e.name + '\')">' + e.name + ' 선택</button>' +
                                '<ul class="select-group__result" data-property_idx=' + e.idx + '>' +
                                '</ul>' +
                                '</li>'
                        })
                        htmlText += '</ul>';
                        $('.list__desc.property .list').html(htmlText);
                    } else {
                        var htmlText = "";
                        result.forEach(function (e, idx) {
                            htmlText += '<li>' +
                                '<label for="property-check_' + e.idx + '">' +
                                '<input type="checkbox" id="property-check_' + e.idx + '" data-sub_property="' + e.idx + '" data-sub_name="' + e.property_name + '" class="checkbox__checked">' + //checked
                                '<span>' + e.property_name + '</span>' +
                                '</label>' +
                                '</li>'
                        })
                        $('#property-modal').data('property_idx', parentIdx);
                        $('#property-modal .default-modal__header h2').text(title);
                        $('#property-modal ul.content__list').html(htmlText);

                        $('#property-modal').data('property_idx', parentIdx);

                        $('ul.select-group__result[data-property_idx="' + parentIdx + '"] li').each(function (i, el) {
                            $('#property-modal #property-check_'+$(el).data('sub_idx')).attr('checked', true);
                        })

                        openModal('#property-modal');
                    }
                }
            });
        }

        $('#property-modal button').click(function () {
            if ($(this).has('.button--solid')) {
                var htmlText = "";
                $('#property-modal .checkbox__checked:checked').map(function (n, i) {
                    htmlText += '<li data-sub_idx="' + $(this).data('sub_property') + '">' +
                        '<span class="property_name">' + $(this).data('sub_name') + '</span>' +
                        '<i class="ico__delete16"><span class="a11y">삭제</span></i>' +
                        '</li>'
                })
                $('ul[data-property_idx="' + $('#property-modal').data('property_idx') + '"]').html(htmlText);

                closeModal('#property-modal');
            }
        })

        $('body').on('click', '.reset', function () {
            $('#property-modal .checkbox__checked:checked').map(function (n, i) {
                $(this).prop('checked', false);
            })

            $('.desc__select-group--item[data-property_idx="' + $('#property-modal').data('property_idx') + '"]').find('ul.select-group__result').html('');
        })

        $('[name="price_open"]').on('change', function () {
            if ($(this).val() == 0) {
                $('.select-group__dropdown').css('display', 'block');
            } else {
                $('.select-group__dropdown').css('display', 'none');
            }
        })

        // 배송 삭제
        $('.form__list-wrap').on('click', '.ico__delete16', function () {
            $(this).parent().remove();

            if ($(this).parents().has('.shipping-wrap__add.active') && $('.shipping-wrap__add.active li').length < 1) {
                $('.shipping-wrap__add.active').removeClass('active');
            }
        })

        $('input[name="payment"]').on('click', function () {
            if ($(this).val() == 4) {
                $('.payment__input-wrap').css('display', 'block');
            } else {
                $('.payment__input-wrap input').val('');
                $('.payment__input-wrap').css('display', 'none');
            }
        })

        function openDeliveryModal() {
            $('#delivery-modal .dropdown__item.active').removeClass('active');
            $('#delivery-modal .addButton').prop('disabled', true);

            if ($('.shipping-wrap__add ul li').length > 5 ) {
                openModal('#alert-modal11');
                return;
            } else {
                openModal('#delivery-modal');
            }
        }

        $('#delivery-modal li').on('click', function () {
            if ($(this).parents().is('.step1')) {
                $(this).parent().find('.active').removeClass('active');
                if ($(this).index() != 0) {
                    $('#delivery-modal .wrap-item--01').removeClass('active');
                    $('#delivery_text').val('');
                    $('#delivery-modal .wrap-item--02').addClass('active');
                } else {
                    $('#delivery-modal .wrap-item--01').addClass('active');
                    $('#delivery-modal .wrap-item--02').removeClass('active');
                }
            }
            $(this).addClass('active');

            if($('.dropdown.step1 li.active').length == 1 && $('.dropdown.step2 li.active').length == 1) {
                if ($('.dropdown.step1 li.active').index() == 0 && $('#delivery_text').val() == '') {
                    $('#delivery-modal .addButton').prop('disabled', true);
                } else {
                    $('#delivery-modal .addButton').prop('disabled', false);
                }

            } else {
                $('#delivery-modal .addButton').prop('disabled', true);
            }
        })

        $('#delivery-modal  #delivery_text').on('keyup', function () {
            if($(this).val() != '' && $('#delivery-modal .dropdown.step2 .dropdown__item.active').length > 0) {
                $('#delivery-modal .addButton').prop('disabled', false);
            } else {
                $('#delivery-modal .addButton').prop('disabled', true);
            }
        })

        $('#delivery-modal .addButton').on('click', function () {
            var title = $('#delivery-modal .step1 .dropdown__title').text();
            if (title == '직접 입력') {
                title = $('#delivery_text').val();
            }

            let htmlText = '<li>' +
                '<span class="add__name">'+ title + ' (' + $('#delivery-modal .wrap-item--02 .dropdown__title').text() +')</span>' +
                '<i class="ico__delete16"><span class="a11y">삭제</span></i>' +
                '</li>';

            $('.shipping-wrap__add ul').append(htmlText)
            $('.shipping-wrap__add').addClass('active');

            //초기화
            $('#delivery-modal .dropdown.step1 .dropdown__title').text('배송 방법 선택');
            $('#delivery-modal #delivery_text').val('');
            $('#delivery-modal .wrap-item.wrap-item--01.active').removeClass('active');

            $('#delivery-modal .dropdown.step2 .dropdown__title').text('배송 가격을 선택해주세요');
            $('#delivery-modal .wrap-item.wrap-item--02.active').removeClass('active');

            closeModal('#delivery-modal');

            $(this).prop('disabled', true);
        })

        function openAuthInfo() {
            $('#default-modal07 .content__list li input').map(function () {
                $(this).prop('checked', false);
            })
            $('#default-modal07 .modal__auth-input').val('');

            if ($('.auth-wrap__selected').is('.active')) {
                var list = $('#auth_info').text().split(', ');

                $('#auth_info').text().split(', ').map(function(el) {
                    if (authList.includes(el)) {
                        $('#default-modal07 .content__list li input').map(function () {
                            if ($(this).data('auth') == el) {
                                $(this).prop('checked', true);
                            }
                        })
                    } else {
                        $('#default-modal07 .content__list li input[data-auth="기타 인증"]').prop('checked', true);
                        $('#default-modal07 .modal__auth-input').val(el);
                    }
                })
            }
            openModal('#default-modal07');
        }

        $('#default-modal07 [type="checkbox"]').on('change', function () {
            let isShow = $(this).is(':checked');
            if ($(this).parents().find('li').has(':last')) {
                if (!isShow) {
                    $('#auth_info_text').val('');
                }
                $('#auth_info_text').css('display', isShow ? 'block' : 'none');
            }

            var cnt = 0;
            $('#default-modal07 [type="checkbox"]').each(function (i, el) {
                if ($(el).is(':checked')) { cnt++; }
            });

            // if (cnt > 0) {
            //     $('#default-modal07 .button--solid').removeAttr('disabled');
            // } else {
            //     $('#default-modal07 .button--solid').attr('disabled', true);
            // }
        })

        $('#default-modal07 .button--solid').click(function () {
            if ($('#default-modal07 [type="checkbox"]:checked').length > 0 ) {
                let text = "";
                $('#default-modal07 [type="checkbox"]:checked').each(function (i, el) {
                    if ($(el).is('[data-auth="기타 인증"]')) {
                        if ($('#auth_info_text').val() != '') {
                            text += $('#auth_info_text').val();
                        } else {
                            $(el).prop('checked', false);
                        }
                    } else {
                        text += $(el).parent().find('span').text()
                    }
                    text += ", "
                });
                $('#auth_info').text(text.slice(0, -2));
                $('.auth-wrap__selected').addClass('active');
            } else {
                $('#auth_info').text('');
                $('.auth-wrap__selected.active').removeClass('active');
            }

            closeModal('#default-modal07');
        })

        $('#allfurn-guide .dropdown__item').on('click', function() {
            $('#allfurn-guide h2 p').text($(this).find('span').text());
            $('#allfurn-guide [aria-hidden="false"]').attr('aria-hidden', 'true');
            $('#allfurn-guide [data-name="' + $(this).data('name') + '"]').attr('aria-hidden', 'false');
        })

        // 옵션 추가
        function addOrderOption() {
            let idx = $('#order_options li.form__list-wrap').length +1;
            if (idx > 6) {
                openModal('#alert-modal10');
            } else {
                var titleHtml = '<li class="form__list-wrap">' +
                    '   <div class="list__title">' +
                    '       옵션 ' + idx + ' <span onclick="checkRemoveOption(' + idx + ')">삭제</span>' +
                    '   </div>' +
                    '   <div class="list__desc">' +
                    '       <ul class="desc__select-group">' +
                    '           <li class="desc__select-group--item" style="display: block;">' +
                    '               <div style="display: flex; align-items: center;">' +
                    '                   <p class="item__text item__text--type02">' +
                    '                       <span class="required">필수 옵션</span>' +
                    '                   </p>' +
                    '                   <div class="radio__box--type01">' +
                    '                       <div>' +
                    '                           <input type="radio" id="required-option0' + idx + '-1" name="option-required_0' + idx + '" value=1 checked>' +
                    '                           <label for="required-option0' + idx + '-1"><span>설정</span></label>' +
                    '                       </div>' +
                    '                       <div>' +
                    '                           <input type="radio" id="required-option0' + idx + '-2" name="option-required_0' + idx + '" value=0>' +
                    '                           <label for="required-option0' + idx + '-2"><span>설정 안함</span></label>' +
                    '                       </div>' +
                    '                   </div>' +
                    '               </div>' +
                    '           </li>' +
                    '           <li class="desc__select-group--item product__info--option">' +
                    '               <div class="item__input-wrap">' +
                    '                   <label class="item__text item__text--type02" for="option-name_0' + idx + '">' +
                    '                       <span class="required">옵션명</span>' +
                    '                   </label>' +
                    '                   <input type="text" class="input textfield__input textfield__input--gray" id="option-name_0' + idx + '" name="option-name_0' + idx + '" value="" placeholder="예시) 색상" maxlength="10" required>' +
                    '               </div>' +
                    '               <ul class="option_value_wrap">' +
                    '                   <li class="item__input-wrap">' +
                    '                       <label class="item__text item__text--type02" for="option-property_0' + idx + '-1">' +
                    '                           <span class="required">옵션값</span>' +
                    '                       </label>' +
                    '                       <input type="text" class="input textfield__input textfield__input--gray" id="option-property_0' + idx + '-1" name="option-property_name" value="" placeholder="예시) 화이트" required>' +
                    '                       <div class="textfield__input--won">' +
                    '                           <input class="input textfield__input textfield__input--gray" type="text" name="option-price" value="0" oninput="this.value = this.value.replace(/[^0-9.]/g, \'\');" placeholder원="예시) 100000" required>' +
                    '                           <p>환</p>' +
                    '                       </div>' +
                    '                       <div class="input__add-btn">' +
                    '                           <i class="ico__add28--circle"><span class="a11y">추가</span></i>' +
                    '                       </div>' +
                    '                   </li>' +
                    '               </ul>' +
                    '           </li>' +
                    '       </ul>' +
                    '   </div>' +
                    '</li>'

                $('#order_options').append(titleHtml);
            }
        }

        // 옵션값 추가
        $('body').on('click', '.input__add-btn', function () {
            if ($(this).is('.input__del-btn')) {
                var valueWrap = $(this).parents('.option_value_wrap');
                var isLast = $(this).parents('.item__input-wrap').is(':last-child')

                $(this).parents('.item__input-wrap').remove();

                if (isLast) {
                    valueWrap.find('.item__input-wrap:last').append(valueWrap.find('.input__add-btn:last').clone());
                    valueWrap.find('.input__add-btn:last').removeClass('input__del-btn');
                    valueWrap.find('.input__add-btn:last').html('<i class="ico__add28--circle"><span class="a11y">추가</span></i>');
                }

                if (valueWrap.find('.input__add-btn').length == 2) {
                    valueWrap.find('.input__add-btn.input__del-btn').remove();
                }

            } else {
                
                if ($(this).parents('.item__input-wrap').index() != 0) {
                    $(this).parents('.item__input-wrap').find('.input__add-btn.input__del-btn').remove();
                }
                
                $(this).addClass('input__del-btn');
                $(this).html('<i class="ico__delete24"><span class="a11y">삭제</span></i>');

                var clone = $(this).parents('.item__input-wrap').clone();
                clone.find('input[name="option-property_name"]').val('');
                clone.find('input[name="option-price"]').val('0');
                clone.append(clone.find('.input__add-btn').clone());
                clone.find('.input__add-btn:last').removeClass('input__del-btn');
                clone.find('.input__add-btn:last').html('<i class="ico__add28--circle"><span class="a11y">추가</span></i>');

                $(this).parents('ul.option_value_wrap').append(clone);
                
            }
        })

        function checkRemoveOption(optionIdx) {
            $('#alert-modal07 button.button--solid').data('option_idx', optionIdx);
            openModal('#alert-modal07');
        }

        function sortOption() {
            sortList = '';
            $('#order_options .form__list-wrap').map(function () {
                sortList += '<li class="ui-sortable-handle" style=""  data-idx=' + $(this).index() + '>' +
                    '<i class="ico__burger24"><span class="a11y">이동</span></i>' +
                    '<p>(';
                if ($(this).find('input[type="radio"]:checked').val() == 1) {
                    sortList += '필수';
                } else {
                    sortList += '선택';
                }
                    sortList += '): ' + $(this).find('.item__input-wrap input[type="text"]').val() + '</p>' +
                    '</li>';
            })

            $('#sortable').html(sortList)

            openModal('#default-modal09');
        }

        $('#default-modal09 .button--solid').click(function () {
            list = [];
            $('.ui-sortable-handle').map(function () {
                list.push($('#order_options li.form__list-wrap').eq($(this).data('idx')).clone());
            })

            $('#order_options').html('');
            for(i = 0; i<list.length; i++) {
                if (list[i].length > 0) {
                    $('#order_options').append(list[i]);
                }
            }

            closeModal('#default-modal09');
        });

        $('#alert-modal07 button.button--solid').on('click', function () {
            $('#order_options > li:nth-child(' + $(this).data('option_idx') + ')').remove();

            if ($('#order_options li').length > 0 ) {
                var idx = 1;
                $('#order_options li.form__list-wrap').each(function (i, el) {
                    var titleHtml = '<div class="list__title">' +
                        '옵션 ' + idx +
                        '<span onclick="checkRemoveOption(' + idx + ')">삭제</span>' +
                        '</div>'

                    $(el).find('.list__title').html(titleHtml);
                    $(el).find('.form__list-wrap').data('option_idx', idx);
                    $(el).find('.radio__box--type01 input[type="radio"]').first().attr({id: 'required-option0' + idx + '-1', name:'option0' + idx});
                    $(el).find('.radio__box--type01 label').first().attr('for', 'required-option0' + idx + '-1')
                    $(el).find('.radio__box--type01 input[type="radio"]').last().attr({id: 'required-option0' + idx + '-2', name:'option0' + idx});
                    $(el).find('.radio__box--type01 label').last().attr('for', 'required-option0' + idx + '-2')
                    $(el).find('.product__info--option .item__input-wrap:first label').attr('for', 'option-name0' + idx);
                    $(el).find('.product__info--option .item__input-wrap:first input').attr({id: 'option-name0' + idx, placeholder: '예시) 색상'});
                    $(el).find('.product__info--option .item__input-wrap:last label').attr('for', 'option-value0' + idx);
                    $(el).find('.product__info--option .item__input-wrap:last input').attr({id: 'option-value0' + idx, placeholder: '예시) 화이트'});

                    idx++;
                })
            }

            closeModal('#alert-modal07');
        })

        $('[name="order-info01"]').on('change', function () {
            if($(this).val() == 1) {
                $('#pay_notice').parent().css('display', 'block');
            } else {
                $('#pay_notice').val('');
                $('#pay_notice').parent().css('display', 'none');
            }
        })
        $('[name="order-info02"]').on('change', function () {
            if($(this).val() == 1) {
                $('#delivery_notice').parent().css('display', 'block');
            } else {
                $('#delivery_notice').val('');
                $('#delivery_notice').parent().css('display', 'none');
            }
        })
        $('[name="order-info03"]').on('change', function () {
            if($(this).val() == 1) {
                $('#return_notice').parent().css('display', 'block');
            } else {
                $('#return_notice').val('');
                $('#return_notice').parent().css('display', 'none');
            }
        })
        $('[name="order-info04"]').on('change', function () {
            if($(this).val() == 1) {
                $('#order_title').parent().css('display', 'block');
            } else {
                $('#order_title, #order_content').val('');
                $('#order_title').parent().css('display', 'none');
            }
        })


        function saveProduct(regType) {
            
            closeModal('#alert-modal09');

            if($('#form-list01').val() == '') {
                alert('상품명을 입력해주세요.');
                $('#form-list01').focus();
                return;
            } else if (storedFiles.length == 0 && $('.product-img__add').length == 0) {
                alert('상품 이미지를 등록해주세요.');
                $('#form-list02').focus();
                return;
            } else if ($('.list-item--selected.active').length == 0) {
                alert('상품 카테고리를 등록해주세요.');
                $('.category__list-item.step1').focus();
                return;
            } else if ($('#product-price').val() == '') {
                alert('가격을 등록해주세요.');
                $('#product-price').focus();
                return;
            } else if ($('[name="payment"]:checked').length == 0) {
                alert('결제방식을 선택해주세요.');
                $('#payment').focus();
                return;
            } else if ($('.shipping-wrap__add.active').length == 0) {
                alert('배송방법을 선택해주세요.');
                $('.shipping-wrap__add').focus();
                return;
            } else if (editer.html.get() == '<!DOCTYPE html><html><head><title></title></head><body></body></html>') {
                alert('상품 상세 내용을 입력해주세요.');
                editer.events.focus();
                return;
            }

            // if (proc) {
            //     alert('등록중입니다.');
            //     return;
            // }
            // proc = true;

            var form = new FormData();
            form.append("reg_type", regType);

            form.append("name", $('#form-list01[name="name"]').val());

            for (var i = storedFiles.length - 1; i >= 0; i--) {
                form.append('files[]', storedFiles[i]);
            }

            var property = '';
            $('.list__desc.property .select-group__result li').map(function () {
                property += $(this).data('sub_idx') + ",";
            })
            form.append("category_idx", $('.list-item--selected.active span').data('category_idx'));
            form.append("property", property.slice(0, -1));
            form.append('price', $('#product-price').val());
            form.append('is_price_open',$('input[name="price_open"]:checked').val());
            form.append('is_new_product', $('input[name="is_new_product"]:checked').val());
            form.append('price_text', $('.select-group__dropdown.price_open .dropdown__title').text());
            form.append('pay_type',$('input[name="payment"]:checked').val());

            if ($('input[name="payment"]').val() == 4) {
                form.append('pay_type_text', $('input[name="payment_text"]').val());
            }

            form.append('product_code',$('input[name="product_code"]').val());
            var shipping = "";
            $('.shipping-wrap__add span.add__name').each(function (i, el) {
                shipping += $(el).text() + ", ";
            })
            form.append('delivery_info', shipping.slice(0, -2));
            form.append('notice_info',$('#form-list09').val());
            form.append('auth_info',$('#auth_info').text());
            form.append('product_detail', editer.html.get());
            form.append('is_pay_notice', $('input[name="order-info01"]:checked').val());
            form.append('pay_notice', $('#pay_notice').val());
            form.append('is_delivery_notice', $('input[name="order-info02"]:checked').val());
            form.append('delivery_notice', $('#delivery_notice').val());
            form.append('is_return_notice', $('input[name="order-info03"]:checked').val());
            form.append('return_notice', $('#return_notice').val());
            form.append('is_order_notice', $('input[name="order-info04"]:checked').val());
            form.append('order_title', $('#order_title').val());
            form.append('order_content', $('#order_content').val());

            @if(Route::current()->getName() == 'product.modify')
                form.append('productIdx', $('#modifyBtn').data('idx'));

                if (deleteImage.length > 0) {
                    form.append('removeImage', deleteImage);
                }
            @endif

            attachmentList = '';

            $('.product-img__add').map(function () {
                if($(this).data('idx') != undefined) {
                    attachmentList += $(this).data('idx') + ',';
                }
            })

            if (attachmentList != '') {
                form.append('attachmentIdx', attachmentList.slice(0, -1));
            }

            var data = new Array();
            $('#order_options li.form__list-wrap').each(function (i, el) {
                var option = new Object();
                option.required = $(el).find('input[name="option-required_0' + (i+1) + '"]:checked').val();
                option.optionName = $('#option-name_0' + (i+1)).val();

                var valueArray = new Array();
                $(el).find('ul.option_value_wrap li.item__input-wrap').each(function (y, eli) {
                    var value = new Object();
                    value.propertyName = $(eli).find('input[name="option-property_name"]').val();
                    value.price = $(eli).find('input[name="option-price"]').val();

                    valueArray.push(value);
                })
                option.optionValue = valueArray;
                data.push(option);
            })
            form.append('product_option', JSON.stringify(data));


            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url             : '/product/saveProduct',
                enctype         : 'multipart/form-data',
                processData     : false,
                contentType     : false,
                data			: form,
                type			: 'POST',
                success: function (result) {
                    proc = false;
                    if (result.success) {
                        switch (regType) {
                            case 1: //임시저장
                                openModal('#alert-modal03');
                                break;
                            case 2: //수정
                                openModal('#alert-modal12');
                                break;
                            default: //상품등록
                                openModal('#alert-modal06');
                                break;
                        }
                    }
                }
            });
        }
        
        
        
        function preview() {
            $('#default-modal-preview02 .left-wrap__img img').attr('src', $('.product-img__add:first img').attr('src'));
            smallImg = '';
            $('.product-img__add').map(function () {
                smallImg += '<li class="thumnail">' +
                    '<button type="button">' +
                    '<img src="' + $(this).find('img').attr('src') + '" alt="' + $(this).find('img').attr('alt') + '">' +
                    '</button>' +
                    '</li>'
            })
            $('.left-wrap__img--small').html(smallImg);
            $('li.thumnail:first-child').addClass('selected');

            $('.right-wrap__company .name').text($('#categoryIdx').text());
            $('.title-wrap h2').text($('#form-list01').val());
            if ($('input[name="price_open"]:checked').val() == 0) {
                $('#default-modal-preview02 .product-detail .right-wrap__title p.price').text($('.select-group__dropdown.price_open .dropdown__title').text());
            } else {
                $('#default-modal-preview02 .product-detail .right-wrap__title p.price').text($('#product-price').val().replace(/\B(?=(\d{3})+(?!\d))/g, ',')+'원');
            }
            if ($('input[name="product_code"]').val() != '') {
                $('#default-modal-preview02 dd.preview_product_code').text($('input[name="product_code"]').val());
            } else {
                $('.preview_product_code').parent().hide();
            }

            var htmlText = "";
            var requiredCnt = 0;
            $('#order_options li.form__list-wrap').each(function (i, el) {
                required = $(el).find('input[name="option-required_0' + (i+1) + '"]:checked').val();

                htmlText += '<div class="dropdown" style="width: 576px">' +
                    '<p class="dropdown__title">' +
                    $('#option-name_0' + (i+1)).val() +' 선택' +
                    '('
                if(required == 1) {
                    requiredCnt ++;
                    htmlText += '필수';
                } else {
                    htmlText += '선택';
                }
                htmlText += ')' +
                    '</p>' +
                    '<ul class="dropdown__wrap">' ;
                $(el).find('ul.option_value_wrap li.item__input-wrap').each(function (y, eli) {
                    price = $(eli).find('input[name="option-price"]').val().replace(/\,/g, '').replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');

                    htmlText += '<li class="dropdown__item">' +
                        '<p class="name">' + $(eli).find('input[name="option-property_name"]').val() + '</p>' +
                        '<p class="price">' + (price != '0' ? price +'원' : '') + '</p>' +
                        '</li>';
                });
                htmlText += '</ul>' +
                    '</div>';
            })

            if (requiredCnt == 0) {
                $('.right-wrap__selection').css('display', 'none');
            } else {
                $('.right-wrap__selection').html(htmlText);
            }

            htmlText = '';
            i = 1;
            $('.desc__select-group--item').map(function () {
                if ($(this).find('.select-group__result li').length > 0) {
                    if (i%2 == 1) {
                        htmlText += '<dl class="item01">';
                    }
                    htmlText += '<dt>' + $(this).find('button').text() + '</dt>';
                    str = '';
                    $(this).find('.select-group__result li').map(function (i, k) {
                        str += (i != 0 ? ', ' : '') + $(this).find('span.property_name').text();
                    })
                    htmlText += '<dd>' + str + '</dd>';

                    if(i%2 == 0) {
                        htmlText += '</dl>';
                    }
                    i ++;
                }
            });

            if (i%2 == 0) {
                htmlText += '<dt></dt><dd></dd></dl>';
            }

            htmlText += '<dl class="item02">' +
                '<dt class="ico__notice24"><span class="a11y">공지</span></dt>' +
                '<dd>' + $('#form-list09').val() + '</dd>' +
                '</dl>';

            $('.product-detail__table').html(htmlText);

            var shipping = "";
            $('.shipping-wrap__add span.add__name').each(function (i, el) {
                shipping += $(el).text() + ", ";
            })
            $('#default-modal-preview02 dd.previce_delivery').text(shipping.slice(0, -2));
            $('#default-modal-preview02 .previce_title').text($('#form-list01').val());
            if (!editer || typeof editer === 'undefined') {
                init_editor();
            } else {
                $('#default-modal-preview02 .product-detail__img-area').html(editer.html.get());
            }

            if ($('input[name="order-info01"]:checked').val() == 1) {
                $('#default-modal-preview02 .order-info_1 .order-info__desc').text($('#pay_notice').val());
                $('#default-modal-preview02 .order-info_1').css('display', 'block');
            } else {
                $('#default-modal-preview02 .order-info_1').css('display', 'none');
            }
            if ($('input[name="order-info02"]:checked').val() == 1) {
                $('#default-modal-preview02 .order-info_2 .order-info__desc').text($('#delivery_notice').val());
                $('#default-modal-preview02 .order-info_2').css('display', 'block');
            } else {
                $('#default-modal-preview02 .order-info_2').css('display', 'none');
            }
            if ($('input[name="order-info03"]:checked').val() == 1) {
                $('#default-modal-preview02 .order-info_3 .order-info__desc').text($('#return_notice').val());
                $('#default-modal-preview02 .order-info_3').css('display', 'block');
            } else {
                $('#default-modal-preview02 .order-info_3').css('display', 'none');
            }
            if ($('input[name="order-info04"]:checked').val() == 1) {
                $('#default-modal-preview02 .order-info_4 .order-info__title p').text($('#order_title').val());
                $('#default-modal-preview02 .order-info_4 .order-info__desc').text($('#order_content').val());
                $('#default-modal-preview02 .order-info_4').css('display', 'block');
            } else {
                $('#default-modal-preview02 .order-info_4').css('display', 'none');
            }
            openModal('#default-modal-preview02');
        }

        $('body').on('click', 'li.thumnail', function () {
            $('li.thumnail').map(function (el) {
                $(this).removeClass('selected');
            })
            $(this).addClass('selected');
            $('.product-detail__left-wrap .left-wrap__img img').attr('src', ($(this).find('img').attr('src')));
        });

        function changeImg(type) {
            if (type == 0) {
                if ($('li.thumnail.selected').is(':first-child')) {
                    $('li.thumnail:last-child').click();
                } else {
                    $('li.thumnail').eq($('li.thumnail.selected').index() - 1).click();
                }
            } else {
                if ($('li.thumnail.selected').is(':last-child')) {
                    $('li.thumnail:first-child').click();
                } else {
                    $('li.thumnail').eq($('li.thumnail.selected').index() + 1).click();
                }
            }
        }

        $('#delivery-modal .dropdown__title').on('click', function () {
            if ($(this).parent().is('.step1')) {
                $('#delivery-modal .dropdown.step2.dropdown--active').removeClass('dropdown--active');
            } else {
                $('#delivery-modal .dropdown.step1.dropdown--active').removeClass('dropdown--active');
            }
        });

        function resetDeliveryModal() {
            $('#delivery-modal .dropdown.step1 .dropdown__title').text('배송 방법 선택');
            $('#delivery-modal #delivery_text').val('');
            $('#delivery-modal .wrap-item.wrap-item--01.active').removeClass('active');

            $('#delivery-modal .dropdown.step2 .dropdown__title').text('배송 가격을 선택해주세요');
            $('#delivery-modal .wrap-item.wrap-item--02.active').removeClass('active');

            closeModal('#delivery-modal');
        }

        // $('body').on('click', '.dropdown', function () {
        //     if($(this).is('.dropdown--active')) {
        //         $(this).removeClass('dropdown--active');
        //     } else {
        //         $(this).addClass('dropdown--active');
        //     }
        // })
        function getUrlVars()
        {
            var vars = [], hash;
            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
            for(var i = 0; i < hashes.length; i++)
            {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            return vars;
        }

        $(document).ready(function(){
            init_editor();

            if ($(location).attr('href').includes('modify')) {
                var idx = $(location).attr('href').split('/modify/')[1];

                $('#default-modal10 input[name="order-info"][data-product_idx="' + idx + '"]').prop('checked', true);
                $('#default-modal10 .default-modal__footer button').data('type', 0);

                loadProduct();
            } else if ($(location).attr('href').includes('temp')) {
                $('#default-modal10 .default-modal__footer button').data('type', 0);

                loadProduct();
            }

            $('#sortable').sortable({
                revert:true,
            });
        });
    </script>
@endsection
