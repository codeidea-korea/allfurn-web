@extends('layouts.app')

@section('content')
    @include('layouts.header')
    <div id="content" class="product_reg" data-loadtype="">
        <div class="inner">
            <div class="flex gap-4 py-10">
                <h2 class="text-2xl font-bold">
                    @if(Route::current()->getName() == 'product.create')
                        상품 등록
                    @elseif(Route::current()->getName() == 'product.modify')
                        상품 수정
                    @endif
                </h2>
                <p class="required_sample flex flex-row-reverse items-center"> 는 필수 입력 항목입니다.</p>
            </div>

            <!-- 기본정보 시작 -->
            <div class="com_setting stting_wrap">
                <div class="flex items-center pb-5 mb-5 justify-between border-b-2 border-stone-900 ">
                    <h3 class="font-medium text-lg">상품 기본 정보</h3>
                    {{-- @if(sizeof($productList)>0)
                        <button class="h-[48px] w-[160px] rounded-md border border-stone-700 hover:bg-stone-100" onclick="getProductList(1);">
                            기본 정보 불러오기
                        </button>
                    @endif
                    button class="h-[48px] w-[160px] rounded-md border border-stone-700 hover:bg-stone-100" onclick="modalOpen('#retrieve_information_modal')">기본 정보 불러오기</button>--}}
                </div>
                <div class="mb-5 pb-5 border-b">
                    <dl class="flex">
                        <dt class="essential w-[190px] shrink-0 mt-2">상품명</dt>
                        <dd class="font-medium w-full">
                            <input type="text" id="form-list01" name="name" maxlength="50" @if(@isset($data->name)) value="{{$data->name}}" @endif class="setting_input h-[48px] w-full" placeholder="상품명을 입력해주세요." required>
                        </dd>
                    </dl>
                </div>
                <div class="mb-5 pb-5 border-b">
                    <dl class="flex">
                        <dt class="w-[190px] shrink-0 mt-2">상품 이미지</dt>
                        <dd class="font-medium w-full">
                            <div class="flex flex-wrap items-center gap-3 desc__product-img-wrap ui-sortable">
                                <div class="border border-dashed w-[200px] h-[200px] rounded-md relative flex items-center justify-center product-img__gallery">
                                    <input type="file" class="file_input" id="form-list02" name="file" multiple="multiple" required placeholder="이미지 추가">
                                    <div>
                                        <div class="file_text flex flex-col items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image text-stone-400"><rect width="20" height="20" x="3" y="3" rx="2" ry="2"></rect><circle cx="9" cy="9" r="2"></circle><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path></svg>
                                            <span class="text-stone-400">이미지 추가</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="info">
                                <div class="">
                                    <p>· 권장 크기: 550 x 550 / 권장 형식: jpg, jpeg, png</p>
                                    <p class="text-primary">· 첫번째 이미지가 대표 이미지로 노출됩니다.</p>
                                    <p>· 이미지는 8개까지 등록 가능합니다.</p>
                                </div>
                            </div>
                        </dd>
                    </dl>
                </div>
                <div class="mb-5 pb-5 border-b">
                    <dl class="flex">
                        <dt class="essential w-[190px] shrink-0 mt-2">카테고리</dt>
                        <dd class="w-full">
                            <div class="setting_category">
                                <div class="category_list border rounded-md">
                                    {{-- 카테고리 목록이 출력될 영역 --}}
                                </div>
                            </div>
                            <div class="text-primary mt-3">
                                선택한 카테고리 : <span id="categoryIdx">-</span>
                            </div>
                        </dd>
                    </dl>
                </div>
                <div class="mb-5 pb-5 border-b">
                    <dl class="flex">
                        <dt class="w-[190px] shrink-0 mt-2">상품 속성</dt>
                        <dd id="property" class="font-medium w-full">
                            {{-- 상품속성들이 출력될 영역 --}}
                            <div id="property_info">
                                <div class="info">
                                    <div class="">
                                        <p>· 상품에 맞는 속성이 없는 경우, 추가 공지 영역에 기입해주세요. 혹은 <span class="text-priamry">속성 추가가 필요한 경우, 1:1 문의를 통해 올펀에 요청해주세요.</span></p>
                                    </div>
                                </div>
                            </div>
                        </dd>
                    </dl>
                </div>
                <div class="mb-5 pb-5 border-b">
                    <dl class="flex">
                        <dt class="essential w-[190px] shrink-0 mt-2">상품 가격</dt>
                        <dd class="font-medium w-full">
                            <div class="flex items-center gap-3 border-b pb-5">
                                <p class="essential w-[120px] shrink-0">상품 가격</p>
                                <div class="setting_input w-[300px] h-[48px] relative overflow-hidden">
                                    <input type="text" id="product-price" name="price" oninput="this.value = this.value.replace(/[^0-9.]/g, '');" value="0" class="text-right w-full h-full pr-10" placeholder="숫자만 입력해주세요." required>
                                    <p class="flex flex-wrap items-center justify-center absolute w-[48px] h-[48px] top-0 right-0 bg-stone-100 text-center text-stone-500">
                                        원
                                    </p>
                                </div>
                            </div>
                            <div class="border-b py-5">
                                <div class="flex items-center gap-3 ">
                                    <p class="essential w-[120px] shrink-0">가격 노출</p>
                                    <div class="radio_btn flex items-center">
                                        <div>
                                            <input type="radio" name="price_exposure" id="price_exposure01" value="1" {{isset($data->is_price_open) ? ($data->is_price_open == 1 ? 'checked' : '') : 'checked'}}>
                                            <label for="price_exposure01" class="w-[140px] h-[48px] flex items-center justify-center">노출</label>
                                        </div>
                                        <div style="margin-left:-1px;">
                                            <input type="radio" name="price_exposure" id="price_exposure02" value="0" {{isset($data->is_price_open) ? ($data->is_price_open == 0 ? 'checked' : '') : ''}}>
                                            <label for="price_exposure02" class="w-[140px] h-[48px] flex items-center justify-center">미노출</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- 미노출일 때 출력 -->
                                <div class="select-group__dropdown">
                                    <div class="mt-5">
                                        <a href="javascript:;" class="h-[48px] px-3 border rounded-sm inline-block filter_border filter_dropdown w-[410px] flex justify-between items-center">
                                            <p class="dropdown__title">가격 안내 문구 선택</p>
                                            <svg class="w-6 h-6 filter_arrow"><use xlink:href="/img/icon-defs.svg#drop_b_arrow"></use></svg>
                                        </a>
                                        <div class="filter_dropdown_wrap w-[410px]" style="display: none;">
                                            <ul>
                                                <li>
                                                    <a href="javascript:;" class="flex items-center">수량마다 상이</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" class="flex items-center">업체 문의</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="mt-5 w-[410px]">
                                        <div class="info">
                                            <div class="flex items-center gap-1">
                                                <img class="w-4" src="/img/member/info_icon.svg" alt="">
                                                <p> 가격 대신 선택한 문구가 노출됩니다.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </dd>
                    </dl>
                </div>

                <div class="mb-5 pb-5 border-b">
                    <dl class="flex">
                        <dt class="w-[190px] shrink-0 mt-2">신상품 설정</dt>
                        <dd class="font-medium w-full">
                            <div class="radio_btn flex items-center">
                                <div>
                                    <input type="radio" name="is_new_product" id="is_new_product_01" {{ isset($data) ? ($data->is_new_product == 1 ? 'checked' : '') : 'checked'}} value="1">
                                    <label for="is_new_product_01" class="w-[140px] h-[48px] flex items-center justify-center">설정</label>
                                </div>
                                <div style="margin-left:-1px;">
                                    <input type="radio" name="is_new_product" id="is_new_product_02" {{ isset($data) ? ($data->is_new_product == 0 ? 'checked' : '') : ''}} value="0">
                                    <label for="is_new_product_02" class="w-[140px] h-[48px] flex items-center justify-center">미설정</label>
                                </div>
                            </div>
                        </dd>
                    </dl>
                </div>

                <div class="mb-5 pb-5 border-b">
                    <dl class="flex">
                        <dt class="essential w-[190px] shrink-0 mt-2">결제 방식</dt>
                        <dd class="font-medium w-full">
                            <div class="radio_btn flex items-center">
                                <div>
                                    <input type="radio" name="payment" id="payment01" {{ isset($data) ? ( $data->pay_type == '1' ? 'checked' : '' ) : '' }} value="1">
                                    <label for="payment01" class="w-[140px] h-[48px] flex items-center justify-center">업체 협의</label>
                                </div>
                                <div style="margin-left:-1px;">
                                    <input type="radio" name="payment" id="payment02" {{ isset($data) ? ( $data->pay_type == '2' ? 'checked' : '' ) : '' }} value="2">
                                    <label for="payment02" class="w-[140px] h-[48px] flex items-center justify-center">계좌이체</label>
                                </div>
                                <div style="margin-left:-1px;">
                                    <input type="radio" name="payment" id="payment03" {{ isset($data) ? ( $data->pay_type == '3' ? 'checked' : '' ) : '' }} value="3">
                                    <label for="payment03" class="w-[140px] h-[48px] flex items-center justify-center">세금계산서 발행</label>
                                </div>
                                <div style="margin-left:-1px;">
                                    <input type="radio" name="payment" id="payment04" {{ isset($data) ? ( $data->pay_type == '4' ? 'checked' : '' ) : '' }} value="4">
                                    <label for="payment04" class="w-[140px] h-[48px] flex items-center justify-center">직접입력</label>
                                </div>
                            </div>
                            <div class="payment__input-wrap direct_input mt-5 {{ isset($data) ? ( $data->pay_type == '4' ? '' : 'hidden' ) : 'hidden' }}">
                                <input type="text" name="payment_text" id="payment_text" class="setting_input h-[48px] w-full" placeholder="결제 방식을 입력해주세요." value="{{  isset($data) ? $data->pay_type_text : '' }}">
                            </div>
                        </dd>
                    </dl>
                </div>

                <div class="mb-5 pb-5 border-b">
                    <dl class="flex">
                        <dt class="w-[190px] shrink-0 mt-2">상품 코드</dt>
                        <dd class="font-medium w-full">
                            <input type="text" name="product_code" maxlength="10" class="setting_input h-[48px] w-full" placeholder="상품 코드를 입력해주세요." value="{{isset($product_number) ? $product_number : ''}}">
                        </dd>
                    </dl>
                </div>

                <div class="mb-5 pb-5 border-b">
                    <dl class="flex">
                        <dt class="essential w-[190px] shrink-0 mt-2">배송 방법</dt>
                        <dd class="font-medium w-full">
                            <button class="border w-[240px] flex items-center justify-center gap-2 h-[48px] rounded-md hover:bg-stone-100" onclick="openDeliveryModal();">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus text-stone-400"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>
                                배송 방법 추가
                            </button>
                            <div class="mt-3 shipping-wrap__add hidden">
                                <span class="plus_del text-primary text-sm">추가된 배송 방법</span>
                                <div class="flex items-center gap-3 mt-3 shipping_method_list"></div>
                            </div>
                        </dd>
                    </dl>
                </div>

                <div class="mb-5 pb-5 border-b">
                    <dl class="flex">
                        <dt class="w-[190px] shrink-0 mt-2">상품 추가 공지</dt>
                        <dd class="font-medium w-full">
                            <div class="setting_input h-[100px] py-3">
                                <textarea name="notice_info" id="form-list09" class="w-full h-full" placeholder="상품 추가 공지사항을 입력해주세요."></textarea>
                            </div>
                        </dd>
                    </dl>
                </div>

                <div class="mb-5 pb-5 border-b">
                    <dl class="flex">
                        <dt class="w-[190px] shrink-0 mt-2">인증 정보</dt>
                        <dd class="font-medium w-full">
                            <button class="h-[48px] w-[240px] rounded-md bg-stone-700 text-white hover:bg-stone-600" onclick="modalOpen('#certification_information_modal');">인증 정보 선택</button>
                            <div class="mt-3 wrap__selected auth-wrap__selected hidden">
                                <span class="plus_del text-primary text-sm">선택된 인증 정보</span>
                                <div class="mt-1" id="auth_info">
                                    {{-- 인증정보 텍스트 영역 --}}
                                </div>

                            </div>
                        </dd>
                    </dl>
                </div>

                <div class="mb-5 pb-5">
                    <dl class="flex">
                        <dt class="essential w-[190px] shrink-0 mt-2">상품 상세 내용</dt>
                        <dd class="font-medium w-full">
                            {{-- <button class="h-[48px] w-[240px] rounded-md border border-stone-700 hover:bg-stone-100" onclick="modalOpen('#writing_guide_modal')">상세 내용 작성 가이드</button> --}}
                            <div class="h-[100px]">{{-- <div class="h-[100px] py-3 mt-5"> --}}
                                <textarea class="textarea-form"></textarea>
                            </div>
                        </dd>
                    </dl>
                </div>

                <div class="border-b-2 border-stone-900 mt-10 pb-5">
                    <div class="flex items-center justify-between">
                        <h3 class="font-medium text-lg">상품 주문 옵션</h3>
                        <div class="flex items-center gap-2 font-medium">
                            <button class="h-[48px] w-[160px] rounded-md border border-stone-700 hover:bg-stone-100" onClick="addOrderOption();">주문 옵션 추가</button>
                            <button class="h-[48px] w-[160px] rounded-md border border-stone-700 hover:bg-stone-100" onclick="sortOption();">옵션 순서 변경</button>
                        </div>
                    </div>
                    <div class="info">
                        <div class="flex items-center gap-1">
                            <img class="w-4" src="/img/member/info_icon.svg" alt="">
                            <p><span class="text-primary">주문 시 필수로 받아야 하는 옵션은 ‘필수 옵션’을 설정해주세요.</span> 필수 옵션의 경우, 주문 시 상위 옵션을 선택해야 하위 옵션 선택이 가능합니다. 상위 개념의 옵션을 옵션 1로 설정해주세요.</p>
                        </div>
                        <div class="flex items-center gap-1 mt-3">
                            <img class="w-4" src="/img/member/info_icon.svg" alt="">
                            <p><span class="text-primary">등록한 상품 외 추가로 금액 산정이 필요한 구성품인 경우, 옵션값 하단에 반드시 가격을 입력해주세요.</span></p>
                        </div>
                        <div class="flex items-center gap-1 mt-3">
                            <img class="w-4" src="/img/member/info_icon.svg" alt="">
                            <p>주문 옵션은 최대 6개까지 추가 가능합니다.</p>
                        </div>
                    </div>
                </div>

                <div id="optsArea">
                </div>

                <div class="border-b-2 border-stone-900 mt-10 pb-5 mb-5">
                    <div class="flex items-center justify-between">
                        <h3 class="font-medium text-lg">상품 주문 정보</h3>
                        <div class="flex items-center gap-2 font-medium hidden">
                            {{-- 주문정보 불러오기 일단 보류 --}}
                            {{-- <button class="h-[48px] w-[160px] rounded-md border border-stone-700 hover:bg-stone-100" onclick="modalOpen('#certification_information_modal')">주문 정보 불러오기</button> --}}
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 border-b pb-5 mb-5">
                    <p class="w-[190px] shrink-0 mt-3">결제 안내</p>
                    <div class="w-full">
                        <div class="radio_btn flex items-center">
                            <div>
                                <input type="radio" name="order-info01" id="price_exposure20" value="1">
                                <label for="price_exposure20" class="w-[140px] h-[48px] flex items-center justify-center">설정</label>
                            </div>
                            <div style="margin-left:-1px;">
                                <input type="radio" name="order-info01" id="price_exposure21" value="0" checked>
                                <label for="price_exposure21" class="w-[140px] h-[48px] flex items-center justify-center">설정안함</label>
                            </div>
                        </div>
                        <!-- hidden -->
                        <div class="guide_area guide_pay_notice mt-3 hidden">
                            <div class=" setting_input h-[100px] py-3  w-full">
                                <textarea name="pay_notice" id="pay_notice" class="w-full h-full" placeholder="안내 상세 내용 입력"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 border-b pb-5 mb-5">
                    <p class="w-[190px] shrink-0 mt-3">배송 안내</p>
                    <div class="w-full">
                        <div class="radio_btn flex items-center">
                            <div>
                                <input type="radio" name="order-info02" id="price_exposure23" value="1">
                                <label for="price_exposure23" class="w-[140px] h-[48px] flex items-center justify-center">설정</label>
                            </div>
                            <div style="margin-left:-1px;">
                                <input type="radio" name="order-info02" id="price_exposure24" value="2" checked>
                                <label for="price_exposure24" class="w-[140px] h-[48px] flex items-center justify-center">설정안함</label>
                            </div>
                        </div>
                        <div class="guide_area guide_delivery_notice mt-3 hidden">
                            <div class=" setting_input h-[100px] py-3  w-full">
                                <textarea name="delivery_notice" id="delivery_notice" class="w-full h-full" placeholder="안내 상세 내용 입력"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 border-b pb-5 mb-5">
                    <p class="w-[190px] shrink-0 mt-3">교환/반품/취소 안내</p>
                    <div class="w-full">
                        <div class="radio_btn flex items-center">
                            <div>
                                <input type="radio" name="order-info03" id="price_exposure25" value="1">
                                <label for="price_exposure25" class="w-[140px] h-[48px] flex items-center justify-center">설정</label>
                            </div>
                            <div style="margin-left:-1px;">
                                <input type="radio" name="order-info03" id="price_exposure26" value="2" checked>
                                <label for="price_exposure26" class="w-[140px] h-[48px] flex items-center justify-center">설정안함</label>
                            </div>
                        </div>
                        <div class="guide_area guide_return_notice mt-3 hidden">
                            <div class=" setting_input h-[100px] py-3  w-full">
                                <textarea name="return_notice" id="return_notice" class="w-full h-full" placeholder="안내 상세 내용 입력"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 border-b pb-5 mb-5">
                    <p class="w-[190px] shrink-0 mt-3">주문 정보 직접 입력</p>
                    <div class="w-full">
                        <div class="radio_btn flex items-center">
                            <div>
                                <input type="radio" name="order-info04" id="price_exposure27" value="1">
                                <label for="price_exposure27" class="w-[140px] h-[48px] flex items-center justify-center">설정</label>
                            </div>
                            <div style="margin-left:-1px;">
                                <input type="radio" name="order-info04" id="price_exposure28" value="2" checked>
                                <label for="price_exposure28" class="w-[140px] h-[48px] flex items-center justify-center">설정안함</label>
                            </div>
                        </div>
                        <div class="guide_area guide_order_notice mt-3 hidden">
                            <div class="font-medium w-full">
                                <input type="text" class="setting_input h-[48px] w-full" id="order_title" placeholder="항목 상세">
                            </div>
                            <div class=" setting_input h-[100px] py-3 mt-3 w-full ">
                                <textarea name="order_content" id="order_content" class="w-full h-full" placeholder="항목 상세 내용"></textarea>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- ############# 모달 모음 시작 --}}
        @include('product.product-reg-modal')
        {{-- ############# 모달 모음 끝 --}}
    </div>

    

    {{-- ############# 완료, 임시, 미리보기 버튼 시작 --}}
    <div class="fixed bottom-0 border-t border-stone-200 bg-stone-100 w-full z-10">
        @if(Route::current()->getName() == 'product.create')
            <div class="w-[1200px] mx-auto py-6 flex items-center justify-between">
                <a href="javascript:;" class="flex w-[120px] justify-center items-center h-[48px] bg-white border font-medium hover:bg-stone-100" onClick="modalOpen('#alert-registration_cancel');">등록취소</a>
                <div class="flex items-center">
                    <button class="font-medium bg-stone-600 text-white w-[120px] h-[48px] border border-stone-900 -mr-px" id="previewBtn" onclick="preview();">미리보기</button>
                    <button class="font-medium bg-stone-600 text-white w-[120px] h-[48px] border border-stone-900" onclick="saveProduct(1);">임시등록</button>
                    <button class="font-medium bg-primary text-white w-[120px] h-[48px] border border-priamry" onclick="saveProduct(0);">등록신청</button>
                </div>
            </div>
        @elseif(Route::current()->getName() == 'product.modify')
            <div class="w-[1200px] mx-auto py-6 flex items-center justify-between">
                <a href="javascript:;" class="flex w-[120px] justify-center items-center h-[48px] bg-white border font-medium hover:bg-stone-100" onClick="modalOpen('#alert-registration_cancel');">수정취소</a>
                <div class="flex items-center">
                    <button class="font-medium bg-stone-600 text-white w-[120px] h-[48px] border border-stone-900 -mr-px" id="previewBtn" onclick="preview();">미리보기</button>
                    <button class="font-medium bg-primary text-white w-[120px] h-[48px] border border-priamry" id="modifyBtn" onclick="saveProduct(2)" data-idx={{$productIdx}}>수정완료</button>
                </div>
            </div>
        @endif 
    </div>
    {{-- ############# 완료, 임시, 미리보기 버튼 종료 --}}













    <link href="/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/js/froala_editor.pkgd.min.js"></script>
    <script>
    const productIdx = "{{ $productIdx }}"
        var storedFiles = [];
        var stored100Files = [];
        var stored400Files = [];
        var stored600Files = [];
        
        var subCategoryIdx = null;
        var deleteImage = [];
        var proc = false;
        var authList = ['KS 인증', 'ISO 인증', 'KC 인증', '친환경 인증', '외코텍스(OEKO-TEX) 인증', '독일 LGA 인증', 'GOTS(오가닉) 인증', '라돈테스트 인증', '전자파 인증', '전기용품안전 인증'];
        var oIdx = 0;
        var _tmp = 0;
        editer = null;

        $(document)
            .on('click', '.setting_category .category_list li > a', function(e) {
                // var allLinks = $('.setting_category .category_list li > a');
                // var otherLinks = allLinks.not(this);
                // otherLinks.parent('li').css('background-color','');
                // otherLinks.parent('li').css('color','');
                // console.log(e)
                //$('.setting_category .category_list li > a').parent('li').css('background-color','');
                //$('.setting_category .category_list li > a').css('color','');
                // $(this).parent('li').css('background-color','#FFF5F6')
                // $(this).css('color','var(--main_color)')
                // $(this).next('img').css('filter','grayscale(0)')

                e.preventDefault(); // a 태그의 기본 동작 방지

                // 클릭된 a 태그의 바로 다음 형제 요소(ul.depth2) 선택
                var $nextDepth2 = $(this).next('.depth2');

                let expUrl = /^http[s]?:\/\/([\S]{3,})/i;
                var url = $(this).prop('href');

                // 이미 보이는 .depth2가 있다면 숨김 처리
                if($nextDepth2.is(':visible')) {
                    $nextDepth2.hide();
                } else {
                    if( expUrl.test(url) ) {
                        $.ajax({
                            type : "GET",
                            url : url + '&jn=1',
                            data : {},
                            dataType : 'JSON',
                            success : function(result){
                                $('.w-full .text-primary').addClass('active');
                                $('.w-full .text-primary span').data('category_idx', result.cate_idx);
                                $('.w-full .text-primary span').text( result.name );

                                var infoText = '';
                                infoText += '<div id="property_info">' +
                                    '   <div class="info">' +
                                    '       <div class="">' +
                                    '           <p>· 상품에 맞는 속성이 없는 경우, 추가 공지 영역에 기입해주세요. 혹은 <span class="text-priamry">속성 추가가 필요한 경우, 1:1 문의를 통해 올펀에 요청해주세요.</span></p>'
                                '       </div>' +
                                '   </div>' +
                                '</div>';

                                $('#property').empty();
                                $('#property').append(infoText);
                                getProperty(null);
                            }
                        });
                    }

                    // 모든 .depth2 요소를 숨김
                    $('.depth2').hide();
                    // 클릭된 a 태그의 바로 다음 .depth2만 표시
                    // $nextDepth2.next('a').each(function(){
                    //     $(this).css('color','#000')
                    //     $(this).next('img').css('filter','grayscale(1)')
                    //     console.log(1)
                    // })
                    
                    //$nextDepth2.next('a').css('color','var(--main_color)')
                    $nextDepth2.show();
                }
            })
            .on('change', '#form-list02', function() {
                console.log('form-list02 changed')
                var files = this.files;
                var i = 0;

                for (i = 0; i < files.length; i++) {
                    var readImg = new FileReader();
                    var file = files[i];
                    console.log('t1 : '+i)
                    if (file.type.match('image.*')){
                        readImg.onload = (function(file) {
                            return function(e) {
                                console.log('t2 : ' + $('.product-img__add').length)
                                let imgCnt = $('.product-img__add').length + 1;

                                if (imgCnt == 9) {
                                    openModal('#alert-modal08');
                                    return;
                                }
                                var image = new Image;
                                image.onload = function() {
                                    file = getThumbFile(image, 500, this.width, this.height);
                                    storedFiles.push(file);
                                };
                                image.src = e.target.result;

                                var image100 = new Image;
                                image100.width = 100;
                                image100.height = 100;
                                image100.onload = function() {
                                    const i100 = getThumbFile(image100, 100, this.width, this.height);
                                    stored100Files.push(i100);
                                };
                                image100.src = e.target.result;

                                var image400 = new Image;
                                image400.width = 400;
                                image400.height = 400;
                                image400.onload = function() {
                                    const i400 = getThumbFile(image400, 400, this.width, this.height);
                                    stored400Files.push(i400);
                                };
                                image400.src = e.target.result;

                                var image600 = new Image;
                                image600.width = 600;
                                image600.height = 600;
                                image600.onload = function() {
                                    const i600 = getThumbFile(image600, 600, this.width, this.height);
                                    stored600Files.push(i600);
                                };
                                image600.src = e.target.result;


                                $('.desc__product-img-wrap').append(
                                    '<div class="w-[200px] h-[200px] rounded-md relative flex items-center justify-center bg-slate-100 product-img__add" file="' + file.name +  '">' +
                                    '   <img class="w-[200px] h-[200px] object-cover rounded-md" src="' + e.target.result + '" alt="상품이미지0' + imgCnt + '">' +
                                    '   <div class="absolute top-2.5 right-2.5">' +
                                    '       <button class="ico__delete--circle w-[28px] h-[28px] bg-stone-600/50 rounded-full">' +
                                    '           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-white mx-auto w-4 h-4"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>' +
                                    '       </button>' +
                                    '   </div>' +
                                    '</div>'
                                );

                                if (imgCnt == 1) {
                                    $('.product-img__add').append(
                                        '   <div class="absolute top-2.5 left-2.5">' +
                                        '       <p class="py-1 px-2 bg-stone-600/50 text-white text-center rounded-full text-sm">대표이미지</p>' +
                                        '   </div>'
                                    );
                                }

                                if (imgCnt == 8) {
                                    $('.desc__product-img-wrap > div').first().hide();
                                }
                            };
                        })(file);
                        readImg.readAsDataURL(file);

                    } else {
//                        alert('the file '+ file.name + ' is not an image<br/>');
                        alert('이미지가 아닙니다. 파일형식을 확인해주세요.');
                    }

                    if(files.length === (i+1)){
                        setTimeout(function(){
                            img_add_order();
                        }, 1000);
                    }
                }
            })
            .on('click','.ico__delete--circle',function(e){
                e.preventDefault();
                var file = $(this).parent().parent().attr('file');
                var idx = $(this).parent().parent().index();

                $(this).parent().parent().remove('');
                for(var i = 0; i < storedFiles.length; i++) {
                    if(storedFiles[i].name == file) {
                        stored100Files.splice(i, 1);
                        stored400Files.splice(i, 1);
                        stored600Files.splice(i, 1);
                        storedFiles.splice(i, 1);
                        break;
                    }
                }

                img_reload_order();

                if ($('.product-img__add').length < 8) {
                    $('li .product-img__gallery').show();
                }
            })
            .on('click', '.reset', function () {
                $('#property-modal .checkbox__checked:checked').map(function (n, i) {
                    $(this).prop('checked', false);
                })

                $('.desc__select-group--item[data-property_idx="' + $('#property-modal').data('property_idx') + '"]').find('ul.select-group__result').html('');
            })
            .on('change', '[name="price_exposure"]', function() {
                if ($(this).val() == 0) {
                    $('.select-group__dropdown').css('display', 'block');
                } else {
                    $('.select-group__dropdown').css('display', 'none');
                }
            })
        ;

        $('#sortable').sortable();
        $('#sortable').disableSelection();

        
    //### 
    function img_reload_order() {
        $('.desc__product-img-wrap').find('.add__badge').remove();
        $('li .product-img__add').first().children('.add__img-wrap').prepend('<p class="add__badge">대표이미지</p>');
    }
    
    //### 
    function img_add_order() {
        $('.desc__product-img-wrap li').each(function(n) {
            $(this).attr('item', n);
        });
    }

    //### 속성 가져오기
    function getProperty(parentIdx=null, title=null) {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url				: '/product/getCategoryProperty',
            data			: {
                'category_idx' : $('.w-full .text-primary.active span').data('category_idx'),
                'parent_idx' : parentIdx
            },
            type			: 'POST',
            dataType		: 'json',
            success		: function(result) {
                pb_cls = ' pb-5';
                if (parentIdx == null) {
                    var htmlText = '';
                    result.forEach(function (e, idx) {
                        if( idx > 0 ) {
                            pb_cls = ' py-5';
                        }
                        htmlText += '<div class="flex items-center gap-3 border-b' + pb_cls + '">' +
                            '   <p class="text-stone-400 w-[130px] shrink-0">' + e.name + '</p>' +
                                '<div class="flex items-center gap-3">' +
                            '       <button class="h-[48px] w-[120px] border rounded-md hover:bg-stone-50 text-sm shrink-0" onclick="getProperty(' + e.idx + ', \'' + e.name + '\')">' + e.name + ' 선택</button>' +
                            '       <div class="flex flex-wrap items-center gap-3 select-group__result" data-property_idx=' + e.idx+ '>' +
                            '       </div>' +
                            '   </div>' +
                            '</div>';
                    });
                    $('#property #property_info').before(htmlText);
                } else {
                    var subHtmlText = '';
                    result.forEach(function (e, idx) {
                        subHtmlText += '<li>' +
                            '<input type="checkbox" class="check-form" id="property-check_' + e.idx + '" data-sub_property="' + e.idx + '" data-sub_name="' + e.property_name + '">' +
                            '<label for="property-check_' + e.idx + '">' + e.property_name + '</label>' +
                            '</li>';
                    })
                    $('#product_attributes_modal').data('property_idx', parentIdx);
                    $('#product_attributes_modal .filter_body p').text(title);
                    $('#product_attributes_modal .filter_list').html(subHtmlText);
                    $('div.select-group__result[data-property_idx="' + parentIdx + '"] div').each(function (i, el) {
                        $('#product_attributes_modal #property-check_'+$(el).data('sub_idx')).attr('checked', true);
                    })
                    modalOpen('#product_attributes_modal');
                }
            }
        });
    }

    //### 속성 선택하기
    $('#product_attributes_modal button').click(function () {
        if ($(this).has('.btn-primary')) {
            var htmlText = "";
            $('#product_attributes_modal .check-form:checked').map(function (n, i) {
                htmlText += '<div class="flex items-center bg-stone-100 px-3 py-1 rounded-full gap-1" data-sub_idx="' + $(this).data('sub_property') + '">' +
                '   <span class="text-stone-500 property_name">' + $(this).data('sub_name') + '</span>' +
                '   <button class="ico_delete"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-stone-400"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg></button>' +
                '</div>';
            })
            $('#property .select-group__result[data-property_idx="' + $('#product_attributes_modal').data('property_idx') + '"]').html(htmlText);
            modalClose('#product_attributes_modal');
        }
    })

    //### 모달에서 선택한 값 삭제 (상품속성, 배송방법) ico_delete
    $(document).on('click', '.ico_delete', function() {
        $(this).parent().remove();
        if ($('.shipping_method').length < 1) {
            $('.shipping-wrap__add').addClass('hidden');
        }
    });

    //### 배송방법 추가 모달 - 배송방법은 최대 5개까지만 등록가능
    function openDeliveryModal() {
        if( $('.shipping-wrap__add div').length > 5 ) {
            modalOpen('#shipping_error_modal');
        } else {
            $('#shipping_method_modal .btn-primary').prop('disabled', true);
            modalOpen('#shipping_method_modal');
        }
    }

    //### 배송 방법 추가
    $('#shipping_method_modal .btn-primary').on('click', function (e) {
        e.stopPropagation();
        var title = $('#shipping_method_modal .dropdown.step1 p').text();
        if (title == '직접 입력') {
            title = $('#shipping_method_modal .direct_input_2 > input').val();
        }

        let htmlText = '' +
            '<div class="shipping_method px-4 py-2 bg-stone-100 flex items-center gap-1 text-sm rounded-full"><span class="add__name">' + title + ' ('+ $('#shipping_method_modal .dropdown.step2 p').text() + ')</span>' +
            '   <button class="ico_delete">' +
            '       <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-stone-500">' +
            '           <path d="M18 6 6 18"></path>' +
            '           <path d="m6 6 12 12"></path>' +
            '       </svg>' +
            '   </button>' +
            '</div>';
        $('.shipping-wrap__add .shipping_method_list').append(htmlText);
        $('.shipping-wrap__add').removeClass('hidden');

        // 배송방법 추가 모달 초기화
        $('#shipping_method_modal .dropdown.step1 p').text('가격 안내 문구 선택');
        $('#shipping_method_modal .direct_input_2 > input').val('');
        $('#shipping_method_modal .dropdown.step2 p').text('배송 가격을 선택해주세요');

        modalClose('#shipping_method_modal');
    })

    //### 인증정보 체크박스 선택시 (마지막 기타인증 선택 관련)
    $('#certification_information_modal [type="checkbox"]').on('change', function () {
        let isShow = $(this).is(':checked');
        if ($(this).parents().find('li').has(':last')) {
            if (!isShow) {
                $('#auth_info_text').val('');
            }
            $('#auth_info_text').css('display', isShow ? 'block' : 'none');
        }
        var cnt = 0;
        $('#certification_information_modal [type="checkbox"]').each(function (i, el) {
            if ($(el).is(':checked')) { cnt++; }
        });
    })

    //### 인증정보 선택완료
    $('#certification_information_modal .btn-primary').click(function () {
        if ($('#certification_information_modal [type="checkbox"]:checked').length > 0 ) {
            let text = "";
            $('#certification_information_modal [type="checkbox"]:checked').each(function (i, el) {
                if ($(el).is('[data-auth="기타 인증"]')) {
                    if ($('#auth_info_text').val() != '') {
                        text += $('#auth_info_text').val();
                    } else {
                        $(el).prop('checked', false);
                    }
                } else {
                    text += $(el).parent().find('label').text();
                }
                text += ", "
            });
            $('.wrap__selected .mt-1').text(text.slice(0, -2));
            $('.wrap__selected').addClass('active');
            $('.wrap__selected').show();
        } else {
            $('.wrap__selected .mt-1').text('');
            $('.wrap__selected.active').removeClass('active');
            $('.wrap__selected').hide();
        }

        modalClose('#certification_information_modal');
    })

    //### 에디터 초기화
    function init_editor() {
        editer = new FroalaEditor('.textarea-form', {
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

    //### 옵션 추가
    function addOrderOption() {
        // 옵션 최대 6개
        oIdx = parseInt( oIdx + 1 );
        _tmp = parseInt( _tmp + 1 );
        if (oIdx > 6) {
            oIdx = parseInt( oIdx - 1 );
            openModal('#alert-modal10');
        } else {
            var titleHtml = '<div class="flex gap-3 border-t py-5 optNum' + parseInt( _tmp -1 ) + ' form__list-wrap" data-opt_num="'+ parseInt( _tmp -1 ) +'">' +
                '   <div class="w-[190px] shrink-0 mt-2">' +
                '       <p>옵션 ' + oIdx + '</p>' +
                '       <button class="text-stone-400 underline mt-2" onclick="checkRemoveOption(' + parseInt( _tmp -1 ) + ');">삭제</button>' +
                '   </div>' +
                '   <div class="w-full option_value_wrap">' +
                '       <div class="radio_btn flex items-center border-b pb-5">' +
                '           <p class="essential w-[130px] shrink-0">필수옵션</p>' +
                '           <div>' +
                '               <input type="radio" name="option-required_0'+ parseInt( oIdx ) +'" id="repuired-option0'+ parseInt( oIdx ) +'-1" value="1" checked="">' +
                '               <label for="repuired-option0'+ parseInt( oIdx ) +'-1" class="w-[140px] h-[48px] flex items-center justify-center">설정</label>' +
                '           </div>' +
                '           <div style="margin-left:-1px;">' +
                '               <input type="radio" name="option-required_0'+ parseInt( oIdx ) +'" id="repuired-option0'+ parseInt( oIdx ) +'-2" value="0">' +
                '               <label for="repuired-option0'+ parseInt( oIdx ) +'-2" class="w-[140px] h-[48px] flex items-center justify-center">설정안함</label>' +
                '           </div>' +
                '       </div>' +
                '       <div class="flex items-center mt-3 ">' +
                '           <p class="essential w-[130px] shrink-0">옵션명</p>' +
                '           <input type="text" class="setting_input h-[48px] w-[340px]" id="option-name_0' + parseInt( oIdx ) + '" name="option-name_0' + parseInt( oIdx ) + '" placeholder="예시)색상">' +
                '       </div>' +
                '       <div class="flex items-center mt-3 item__input-wrap">' +
                '           <p class="essential w-[130px] shrink-0">옵션값</p>' +
                '           <input type="text" class="setting_input h-[48px] w-[340px]" id="option-property_0'+ parseInt( oIdx ) +'-1" name="option-property_name" placeholder="예시)색상">' +
                '           <div class="setting_input w-[223px] h-[48px] relative overflow-hidden ml-2">' +
                '               <input type="text" class="text-right w-full h-full pr-10" name="option-price" value="0" oninput="this.value=this.value.replace(/[^0-9.]/g, \'\');">' +
                '               <p class="flex flex-wrap items-center justify-center absolute w-[48px] h-[48px] top-0 right-0 bg-stone-100 text-center text-stone-500">원</p>' +
                '           </div>' +
                '           <button class="flex flex-wrap items-center justify-center w-[48px] h-[48px] top-0 right-0 bg-stone-100 text-center text-stone-500 rounded-md border ml-2 input__add-btn">' +
                '              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus text-stone-800"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>' +
                '           </button>' +
                '       </div>' +
                '   </div>' +
                '</div>'

            $('#optsArea').append(titleHtml);
        }
    }

        

        // 라디오 버튼의 변경을 감지
        $('input[type="radio"][name="payment"]').change(function() {
            // 선택된 라디오 버튼이 '직접입력'에 해당하는지 확인
            var isDirectInputSelected = $('#payment04').is(':checked');

            // '직접입력' 선택 시, 입력 필드 표시
            if(isDirectInputSelected) {
                $('.direct_input').show();
            } else {
                // 다른 라디오 버튼 선택 시, 입력 필드 숨김
                $('.direct_input').hide();
            }
        });

        



        $('#shipping_method_modal .direct_input_2 > input').on('keyup', function() {
            if( $(this).val() != '' && $('#shipping_method_modal .dropdown.step2 p').text() != '배송가격을 선택해주세요' ) {
                $('#shipping_method_modal .btn-primary').prop('disabled', false);
            } else {
                $('#shipping_method_modal .btn-primary').prop('disabled', true);
            }
        });

        

        

        // 상품 미리보기
        function preview() {
            //$('#state_preview_modal .left-wrap__img img').attr('src', $('.product-img__add:first img').attr('src'));
            setImg = '';
            $('.product-img__add').map(function () {
                setImg += '<li class="swiper-slide">' +
                    '<img src="' + $(this).find('img').attr('src') + '" alt="' + $(this).find('img').attr('alt') + '">' +
                    '</li>';
            })
            $('.left_thumb').html(setImg);
            $('.big_thumb > ul').html(setImg);
            // 썸네일 첫번째 이미지 선택
            //$('.left_thumb li:first-child').addClass('selected');

            // 상품명 상단에 카테고리 노출
            //$('.prod_detail_top .name .tag').text($('#categoryIdx').text());
            $('.prod_detail_top .name h4').text($('#form-list01').val());

            // 상품가격
            if ($('input[name="price_exposure"]:checked').val() == 0) {
                $('.prod_detail_top .info p').text($('.select-group__dropdown p:first-child').text());
            } else {
                $('.prod_detail_top .info p').text($('#product-price').val().replace(/\B(?=(\d{3})+(?!\d))/g, ',')+'원');
            }

            // 상품코드 노출
            if ($('input[name="product_code"]').val() != '') {
                $('.prod_detail_top dd.preview_product_code').text($('input[name="product_code"]').val());
            } else {
                $('.preview_product_code').parent().hide();
            }

            // 상품 상세 내용
            if (!editer || typeof editer === 'undefined') {
                init_editor();
            } else {
                $('#state_preview_modal .product-detail__img-area').html(editer.html.get());
            }

            if (requiredCnt == 0) {
                $('.right-wrap__selection').css('display', 'none');
            } else {
                $('.right-wrap__selection').html(htmlText);
            }

            var htmlText = "";
            var requiredCnt = 0;
            $('#optsArea > div.flex').each(function (i, el) {
                required = $(el).find('input[name="option-required_0' + (i+1) + '"]:checked').val();

                /*htmlText += '<div class="dropdown" style="width: 576px">' +
                    '<p class="dropdown__title">' +
                    $('#option-name_0' + (i+1)).val() +' 선택' +
                    '('*/
                if(required == 1) {
                    requiredCnt ++;
                    //htmlText += '필수';
                } else {
                    //htmlText += '선택';
                }
                /*htmlText += ')' +
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
                    '</div>';*/
            })

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

            // 미리보기 창 오픈
            modalOpen('#state_preview_modal');
        }

        const detail_thumb_list = new Swiper(".prod_detail_top .left_thumb", {
            slidesPerView: 'auto',
            direction: "vertical",
            spaceBetween: 8,
        });

        // thismonth_con01
        const detail_thumb = new Swiper(".prod_detail_top .big_thumb", {
            slidesPerView: 1,
            spaceBetween: 0,
            thumbs: {
                swiper: detail_thumb_list,
            },
        });


        // 옵션값 추가
        $('body').on('click', '.input__add-btn', function () {
            if ($(this).is('.input__del-btn')) { // 옵션값 삭제
                var valueWrap = $(this).parents('.option_value_wrap');
                var isLast = $(this).parents('.item__input-wrap').is(':last-child')

                $(this).parents('.item__input-wrap').remove();

                if (isLast) {
                    valueWrap.find('.item__input-wrap:last').append(valueWrap.find('.input__add-btn:last').clone());
                    valueWrap.find('.input__add-btn:last').removeClass('input__del-btn');
                    valueWrap.find('.input__add-btn:last').html('' +
                        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus text-stone-800">' +
                        '   <path d="M5 12h14"></path>' +
                        '   <path d="M12 5v14"></path>' +
                        '</svg>'
                    );
                }

                if (valueWrap.find('.input__add-btn').length == 2) {
                    valueWrap.find('.input__add-btn.input__del-btn').remove();
                }
            } else { // 옵션값 추가
                if ($(this).parents('.item__input-wrap').index() != 0) {
                    $(this).parents('.item__input-wrap').find('.input__add-btn.input__del-btn').remove();
                }

                $(this).addClass('input__del-btn');
                $(this).html('<i class="ico__delete24"><span class="a11y">삭제</span></i>');

                var clone = $(this).parents('.item__input-wrap').clone();
                clone.find('input[name="option-property_name"]').val('');
                clone.find('input[name="option-price"]').val('0');
                clone.find('input[name="option-property_name"]').attr('id','option-property_01-'+$(this).parents('.item__input-wrap').index());
                clone.append(clone.find('.input__add-btn').clone());
                clone.find('.input__add-btn:last').removeClass('input__del-btn');
                clone.find('.input__add-btn:last').html('' +
                    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus text-stone-800">' +
                    '   <path d="M5 12h14"></path>' +
                    '   <path d="M12 5v14"></path>' +
                    '</svg>'
                );

                $(this).parents('.option_value_wrap').append(clone);
            }
        });

        function checkRemoveOption(optionIdx) {
            $('#alert-modal07 button.button--solid').data('option_idx', optionIdx);
            ;openModal('#alert-modal07');
        }

        // 옵션 삭제 모달
        function checkRemoveOption( optionIdx ) {
            $('#del_con_modal button.btn-primary').data('option_idx', optionIdx);
            modalOpen('#del_con_modal');
        }

        // 옵션 삭제
        $('#del_con_modal button.btn-primary').on('click', function () {

            var optionIdx = $(this).data('option_idx');

            $('#optsArea div.optNum' + optionIdx).remove();

            var num = 0;
            $('#optsArea > div').each(function() {
                num = parseInt( num + 1 );
                $(this).find('.shrink-0 p').text('옵션 ' + num);
            });

            oIdx = parseInt( oIdx - 1 );
            modalClose('#del_con_modal');
        });

        // 옵션순서 변경 모달
        function sortOption() {
            sortList = '';
            $('#optsArea > div.flex').map(function() {
                sortList += '<li class="ui-state-default ui-sortable-handle" data-idx=' + $(this).index() + '>' +
                    '   <div class="flex items-center gap-3 border-b py-3">' +
                    '       <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list">' +
                    '           <line x1="8" x2="21" y1="6" y2="6"></line>' +
                    '           <line x1="8" x2="21" y1="12" y2="12"></line>' +
                    '           <line x1="8" x2="21" y1="18" y2="18"></line>' +
                    '           <line x1="3" x2="3.01" y1="6" y2="6"></line>' +
                    '           <line x1="3" x2="3.01" y1="12" y2="12"></line>' +
                    '           <line x1="3" x2="3.01" y1="18" y2="18"></line>' +
                    '       </svg>' +
                    '       <p>(필수): ' + $(this).find('.items-center input[type="text"]').val() + '</p>' +
                    '       <p></p>' +
                    '   </div>' +
                    '</li>'
            });
            $('#sortable').html(sortList)
            modalOpen('#change_order_modal');
        }

        // 옵션 순서 변경
        $('#change_order_modal .btn-primary').click(function () {
            list = [];
            $('.ui-sortable-handle').map(function () {
                list.push($('#optsArea > div').eq($(this).data('idx')).clone());
            })

            $('#optsArea').empty();
            for(i = 0; i<list.length; i++) {
                if (list[i].length > 0) {
                    $('#optsArea').append(list[i]);
                }
            }

            modalClose('#change_order_modal');
        });

        //에디터
        const editor = new FroalaEditor('.textarea-form', {
            key: 'wFE7nG5E4I4D3A11A6eMRPYf1h1REb1BGQOQIc2CDBREJImA11C8D6B5B1G4D3F2F3C8==',
            height:300,
            requestHeaders: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            imageUploadParam: 'images',
            imageUploadURL: '/community/image',
            imageUploadMethod: 'POST',
            imageMaxSize: 5 * 1024 * 1024,
            imageAllowedTypes: ['jpeg', 'jpg', 'png'],
            events: {
                'image.uploaded': response => {
                    const img_url = response;
                    editor.image.insert(img_url, false, null, editor.image.get(), response);
                    return false;
                },
                'image.removed': img => {
                    const imageUrl = img[0].src;
                }
            }
        });

        // 상품 주문 정보 탭 설정
        $('[name="order-info01"], [name="order-info02"], [name="order-info03"], [name="order-info04"]').on('change', function () {
            var _target = $(this).closest('.radio_btn').next('.guide_area');
            if($(this).val() == 1) {
                if( _target.find('#order_title').length > 0 ) {
                    _target.find('#order_title').prop('disablec', false);
                }
                _target.find('textarea').prop('disabled', false);
                _target.show();
            } else {
                if( _target.find('#order_title').length > 0 ) {
                    _target.find('#order_title').val('');
                    _target.find('#order_title').prop('disablec', true);
                }
                _target.find('textarea').val('');
                _target.find('textarea').prop('disabled', true);
                _target.hide();
            }
        });

        // 드롭다운 토글
        $(".filter_dropdown").click(function(event) {
            var $thisDropdown = $(this).next(".filter_dropdown_wrap");
            $(this).toggleClass('active');
            $thisDropdown.toggle();
            $(this).find("svg").toggleClass("active");
            event.stopPropagation(); // 이벤트 전파 방지
        });

        // 드롭다운 항목 선택 이벤트
        $(".filter_dropdown_wrap ul li a").click(function(event) {
            var selectedText = $(this).text();
            var $dropdown = $(this).closest('.filter_dropdown_wrap').prev(".filter_dropdown");
            $dropdown.find("p").text(selectedText);
            $(this).closest(".filter_dropdown_wrap").hide();
            $dropdown.removeClass('active');
            $dropdown.find("svg").removeClass("active");

            // '직접 입력' 선택 시 direct_input_2 표시
            if ($(this).data('target') === "direct_input_2") {
                $('.direct_input_2').show();
            }
            // '소비자 직배 가능' 또는 '매장 배송' 선택 시 direct_input_2 숨김
            else if ($(this).hasClass('direct_input_2_hidden')) {
                $('.direct_input_2').hide();
            }
            // '무료' 또는 '착불' 선택 시 direct_input_2의 상태 변경 없음

            // 배송방법추가일경우
            if( $('#shipping_method_modal .dropdown.step1 p').text() == '직접 입력' ) {
                if( $('#shipping_method_modal .direct_input_2 > input').val() != '' && $('#shipping_method_modal .dropdown.step2 p').text() != '배송가격을 선택해주세요' ) {
                    $('#shipping_method_modal .btn-primary').prop('disabled', false);
                } else {
                    $('#shipping_method_modal .btn-primary').prop('disabled', true);
                }
            } else {
                if( $('#shipping_method_modal .dropdown.step2 p').text() != '배송가격을 선택해주세요' ) {
                    $('#shipping_method_modal .btn-primary').prop('disabled', false);
                } else {
                    $('#shipping_method_modal .btn-primary').prop('disabled', true);
                }
            }

            event.stopPropagation(); // 이벤트 전파 방지
        });

        // 드롭다운 영역 밖 클릭 시 드롭다운 닫기
        $(document).click(function(event) {
            if (!$(event.target).closest('.filter_dropdown, .filter_dropdown_wrap').length) {
                $('.filter_dropdown_wrap').hide();
                $('.filter_dropdown').removeClass('active');
                $('.filter_dropdown svg').removeClass("active");
            }
        });

        function saveProduct(regType) {

            //closeModal('#alert-modal09');

            if($('#form-list01').val() == '') {
                alert('상품명을 입력해주세요.');
                $('#form-list01').focus();
                return;
            } else if (storedFiles.length == 0 && $('.product-img__add').length == 0) {
                alert('상품 이미지를 등록해주세요.');
                $('#form-list02').focus();
                return;
            } else if ($('.w-full .text-primary.active').length == 0) {
                alert('상품 카테고리를 등록해주세요.');
                $('.category__list-item.step1').focus();
                return;
            } else if ($('#product-price').val() == '') {
                alert('가격을 등록해주세요.');
                $('#product-price').focus();
                return;
            } else if ($('[name="payment"]:checked').length == 0) {
                alert('결제방식을 선택해주세요.');
                $('#payment01').focus();
                return;
            } else if ($('.shipping_method').length < 1) {
                alert('배송방법을 선택해주세요.');
                $('.shipping-wrap__add').focus();
                return;
            } else if (editer.html.get() == '') {
                alert('상품 상세 내용을 입력해주세요.');
                editer.events.focus();
                return;
            }
            $('#loadingContainer').show();

            // if (proc) {
            //     alert('등록중입니다.');
            //     return;
            // }
            // proc = true;

            var form = new FormData();
            form.append("reg_type", regType);

            form.append("name", $('#form-list01').val());

            for (var i = 0; i < storedFiles.length; i++) {
                form.append('files[]', storedFiles[i]);
            }
            for (var i = 0; i < stored100Files.length; i++) {
                form.append('files100[]', stored100Files[i]);
            }
            for (var i = 0; i < stored400Files.length; i++) {
                form.append('files400[]', stored400Files[i]);
            }
            for (var i = 0; i < stored600Files.length; i++) {
                form.append('files600[]', stored600Files[i]);
            }

            var property = '';
            $('#property .select-group__result div').map(function () {
                property += $(this).data('sub_idx') + ",";
            })
            form.append("category_idx", $('.w-full .text-primary span').data('category_idx'));
            form.append("property", property.slice(0, -1));
            form.append('price', $('#product-price').val());
            form.append('is_price_open',$('input[name="price_exposure"]:checked').val());
            form.append('is_new_product', $('input[name="is_new_product"]:checked').val());
            form.append('price_text', $('.select-group__dropdown .dropdown__title').text());
            form.append('pay_type',$('input[name="payment"]:checked').val());

            if ($('input[name="payment"]:checked').val() == 4) {
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
            $('#optsArea .form__list-wrap').each(function (i, el) {
                var option = new Object();
                option.required = $(el).find('input[name="option-required_0' + (i+1) + '"]:checked').val();
                option.optionName = $('#option-name_0' + (i+1)).val();

                var valueArray = new Array();
                $(el).find('.item__input-wrap').each(function (y, eli) {
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
                    $('#loadingContainer').hide();
                    if (result.success) {
                        switch (regType) {
                            case 1: // 임시저장
                                modalOpen('#product_temp_save_modal');
                                break;
                            case 2: // 수정
                                modalOpen('#product_update_modal');
                                break;
                            default: // 상품등록
                                modalOpen('#product_save_modal');
                                break;
                        }
                    }
                }, error: function (e) {
                    $('#loadingContainer').hide();
                }
            });
        }

    




    // 저장된 상품 데이터가 있을 경우에만(수정화면) > 주문정보 가져오기 > 등록된 상품 목록 가져오기 
    function loadProduct() {
        let loadType = $('.product_reg').data('loadtype'); // loadType = 0:modify, 1:기본정보 불러오기, 2:주문정보 불러오기
        let tempIdx = getUrlVars()["temp"];
        let url = `/product/getProductData/${productIdx}`;
        if (loadType == 0 && tempIdx != null) url += '?type=temp';

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url				: url,
            data			: {},
            type			: 'POST',
            dataType		: 'json',
            success		: function(result) {
                console.log(result);
                result = result['data']['detail'];
                if (loadType == 0 || loadType == 1) {
                    $('#form-list01').val(result['name']); // 상품명
                    subCategoryIdx = result['category_idx']; // 카테고리 idx

                    // 저장된(선택된) 카테고리 값 관련
                    $('.w-full .text-primary').addClass('active');
                    $('.w-full .text-primary span').data('category_idx', result['category_idx']);
                    $('.w-full .text-primary span').text( result['category'] );

                    // $('.setting_category .category_list li a').each(function () {
                    //     var url = $(this).prop('href');
                    //     var s_url = url.split('pre=');
                    //     var param1 = "?pre="+result['category_parent_idx'];
                    //     if (url.indexOf(param1) > -1 && s_url[1] == result['category_parent_idx']){
                    //         console.log(3)
                    //         $(this).parent('li').css('background-color','#FFF5F6')
                    //         $(this).css('color','var(--main_color)')
                    //         $(this).next('img').css('filter','grayscale(0)')
                    //         $(this).next('.depth2').show();
                    //         var nextDepth = $(this).next('.depth2').find('a');
                    //         nextDepth.each(function(){
                    //             var url2 = $(this).prop('href');
                    //             var s_url2 = url2.split('&');
                    //             var s_url3 = s_url2[0].split('ca=');
                    //             if (s_url3[1] == result['category_idx']) {
                    //                 $(this).parent('li').css('background-color','#FFF5F6')
                    //                 $(this).css('color','var(--main_color)')
                    //             }
                    //         });
                    //     }
                    // })

                    // 첨부파일 이미지 출력
                    if (result['attachment'] != null) {
                        imageAddBtn = $('.product-img__gallery').clone();
                        $('.desc__product-img-wrap').html(imageAddBtn);
                        attIdx = result['attachment_idx'].split(',');
                        result['attachment'].map(function (item, i) {
                            if (item != null) {
                                var html = `
                                    <div class="w-[200px] h-[200px] rounded-md relative flex items-center justify-center bg-slate-100 product-img__add" data-idx="${attIdx[i]}" >
                                        <img class="w-[200px] h-[200px] object-cover rounded-md" src="${item['imgUrl']}" alt="상품이미지0${(i+1)}">
                                        <div class="absolute top-2.5 right-2.5">
                                            <button class="ico__delete--circle w-[28px] h-[28px] bg-stone-600/50 rounded-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-white mx-auto w-4 h-4"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                                            </button>
                                        </div>`;
                                        if (i == 0){
                                            html += '<div class="absolute top-2.5 left-2.5 add__badge"><p class="py-1 px-2 bg-stone-600/50 text-white text-center rounded-full text-sm">대표이미지</p></div>';
                                        }
                                html += '</div>';
                                $('.desc__product-img-wrap').append(html);
                            }
                        })
                        if (result['attachment'].length == 8) {
                            $('.product-img__gallery').hide();
                        }
                    }

                    // 저장된(선택된) 속성값 관련
                    getProperty(null);
                    
                    // 카테고리 선택에 따른 상품 속성 값들..
                    setTimeout(function () {
                        var parentIdx = 0;
                        result['propertyList'].map(function (item) {
                            if (parentIdx == '' || item['parent_idx'] != parentIdx) {
                                parentIdx = item['parent_idx'];
                                $('div.select-group__result[data-property_idx="' + item['parent_idx'] + '"]').html('');
                            }

                            $('div.select-group__result[data-property_idx="' + item['parent_idx'] + '"]').append(
                                '<div class="flex items-center bg-stone-100 px-3 py-1 rounded-full gap-1" data-sub_idx="' + item.idx + '">' +
                                '   <span class="text-stone-500 property_name">' + item['property_name'] + '</span>' +
                                '   <button class="ico_delete"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-stone-400"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg></button>' +
                                '</div>'
                            )
                        });
                    }, 500);

                    // 상품 가격
                    $('#product-price').val(result['price']); 
                    if (result['is_price_open'] == 1) {
                        $('#price_exposure01').attr('checked', true);
                        $('#price_exposure02').attr('checked', false);
                        $('.select-group__dropdown').css('display', 'none');
                    } else {
                        $('#price_exposure01').attr('checked', false);
                        $('#price_exposure02').attr('checked', true);
                        $('.select-group__dropdown').css('display', 'block');
                        if (result['price_text'] != null) {
                            $('.select-group__dropdown .dropdown__title').text(result['price_text'])
                        }
                    }

                    // 결제 방식
                    if (result['pay_type'] != 4) {
                        $('payment__input-wrap').css('display', 'none');
                    } else {
                        $('payment__input-wrap').css('display', 'block');
                    }

                    // 상품 코드
                    $('input[name="product_code"]').val(result['product_code']);

                    // 배송 방법
                    var delivery = '';
                    result['delivery_info'].split(',').forEach(str => {
                        delivery += '' + 
                            '<div class="shipping_method px-4 py-2 bg-stone-100 flex items-center gap-1 text-sm rounded-full"><span class="add__name">' + $.trim(str) + ' </span>' +
                            '   <button class="ico_delete">' +
                            '       <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-stone-500">' +
                            '           <path d="M18 6 6 18"></path>' +
                            '           <path d="m6 6 12 12"></path>' +
                            '       </svg>' +
                            '   </button>' +
                            '</div>';
                    })
                    $('.shipping-wrap__add .shipping_method_list').append(delivery);
                    $('.shipping-wrap__add').removeClass('hidden');

                    // 상품 추가 공지
                    $('#form-list09').val(result['notice_info']);

                    // 인증 정보
                    $('#auth_info').text(result['auth_info']);
                    $('.auth-wrap__selected').removeClass('hidden');
                    if(result['auth_info']) {
                        result['auth_info'].split(', ').forEach(str => {
                            if (authList.indexOf(str) == -1) {
                                $('#certification_information_modal .filter_list input[data-auth="기타 인증"]').attr('checked', true);
                                $('#auth_info_text').val(str);
                                $('#auth_info_text').css('display', 'block');
                            } else {
                                $('#certification_information_modal .filter_list input[data-auth="' + str + '"]').attr('checked', true);
                            }
                        });
                    }

                    // 결제정보
                    $('#payment0' + result['pay_type']).prop('checked', true);
                    // 상세 내용 작성
                    setTimeout(() => {
                        editer.html.set(result['product_detail']);
                    }, 1000);

                    // 주문 옵션 추가
                    var obj = $.parseJSON(result['product_option']);
                    obj.forEach(function (item, i) {
                        addOrderOption();
                        $('input[name="option-required_0' + (i + 1) + '"][value=' + item.required + ']').prop('checked', true);
                        $('input#option-name_0' + (i + 1)).val(item.optionName);
                        // 나중에 직접 html을 만들어서 #optsArea에 innserhtml로 넣어야 할듯. 
                        item.optionValue.forEach(function (value, y) {
                            if (y > 0) {
                                $('input#option-property_0' + (i + 1) + '-' + (y)).parent().find('.input__add-btn').trigger('click');
                                console.log(  $('input#option-property_0' + (i + 1) + '-' + (y)).parent().find('.input__add-btn') )
                            }
                            $('input#option-property_0' + (i + 1) + '-' + (y + 1)).val(value.propertyName);
                            $('input#option-property_0' + (i + 1) + '-' + (y + 1)).parent().find('input[name="option-price"]').val(value.price);
                        })
                    });
                }

                if (loadType == 0 || loadType == 2) {
                    if (result['is_pay_notice'] == 0) {
                        $('.guide_pay_notice').hide();
                    } else {
                        $('#pay_notice').val(result['pay_notice']);
                        $('.guide_pay_notice').show();
                    }

                    if (result['is_delivery_notice'] == 0) {
                        $('.guide_delivery_notice').hide();
                    } else {
                        $('#delivery_notice').val(result['delivery_notice']);
                        $('.guide_delivery_notice').show();
                    }

                    if (result['is_return_notice'] == 0) {
                        $('.guide_return_notice').hide();
                    } else {
                        $('#return_notice').val(result['return_notice']);
                        $('.guide_return_notice').show();
                    }

                    if (result['is_order_notice'] == 0) {
                        $('.guide_order_notice').hide();
                    } else {
                        $('#order_title').val(result['order_title']);
                        $('#order_content').val(result['order_content']);
                        $('.guide_order_notice').show();
                    }

                    $('input[name="order-info01"][value=' + result['is_pay_notice'] + '],' +
                        'input[name="order-info02"][value=' + result['is_delivery_notice'] + '],' +
                        'input[name="order-info03"][value=' + result['is_return_notice'] + '],' +
                        'input[name="order-info04"][value=' + result['is_order_notice'] + ']').prop('checked', true);

                    // 미리보기쪽.. 일단 보류
                    $('.sales_product_num').text(result['product_number']);
                    if (result['access_date'] != null && result['access_date'] != '') {
                        $('.access_date').text(result['access_date'].split(' ')[0].replace(/-/g, '.'));
                    }
                }

                //closeModal('#default-modal10');
                window.product_detail = result['product_detail'];
            }
        });
    }

    function getUrlVars(){
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++){
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }

    $(document).ready(function(){
        init_editor();
        $('.select-group__dropdown').css('display', 'none');

        if ($(location).attr('href').includes('modify')) {
            let idx = "{{ $productIdx }}";
            /** 주문정보 불러오기 일단 보류 */
            //$('#default-modal10 input[name="order-info"][data-product_idx="' + idx + '"]').prop('checked', true);
            //$('#default-modal10 .default-modal__footer button').data('type', 0);

            $('.product_reg').data('loadtype', 0);
            loadProduct();
        } else if ($(location).attr('href').includes('temp')) {
            /** 주문정보 불러오기 일단 보류 */
            //@argument('#default-modal10 .default-modal__footer button').data('type', 0);

            $('.product_reg').data('loadtype', 0);
            loadProduct();
        }

        $('#sortable').sortable({
            revert:true,
        });
    });
    </script>
@endsection
