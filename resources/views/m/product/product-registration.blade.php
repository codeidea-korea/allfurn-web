@extends('layouts.app_m')
@section('content')
<div id="content">
    <div class="detail_mo_top write_type center_type">
        <div class="inner">
            <h3>
            @if(Route::current()->getName() == 'product.create')
                상품 등록
            @elseif(Route::current()->getName() == 'product.modify')
                상품 수정
            @endif
            </h3>
            <a class="back_img" href="/"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></a>
        </div>
    </div>
    <!-- <div class="flex gap-4 py-10">
        <h2 class="text-2xl font-bold">상품 등록</h2>
        <p class="required_sample flex flex-row-reverse items-center"> 는 필수 입력 항목입니다.</p>
    </div> -->

    <div class="prod_regist prod_regist_box com_setting ">
        <!-- step1 -->
        <div class="step1 active">
            <div class="top_info flex itmes-center justify-between">
                <h6>상품 기본 정보</h6>
                <p class="txt-gray"><span class="txt-primary">*</span>는 필수 입력 항목입니다.</p>
            </div>
            <div class="divided"></div>
            <div class="inner">
                <dl class="mb-3">
                    <dt class="necessary">상품명</dt>
                    <dd>
                        <input type="text" name="name"
                               @if(@isset($data->name))
                                   value="{{$data->name}}"
                               @endif
                               class="input-form w-full" placeholder="상품명을 입력해주세요.">
                    </dd>
                </dl>
                <dl class="mb-3">
                    <dt>상품 이미지</dt>
                    <dd>
                        <div class="flex flex-wrap items-center gap-3 desc__product-img-wrap">
                            <div class="border border-dashed w-[150px] h-[150px] rounded-md relative flex items-center justify-center">
                                <input type="file" class="file_input" id="form-list02" name="file" multiple="multiple" required placeholder="이미지 추가">
                                <div>
                                    <div class="file_text flex flex-col items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image text-stone-400"><rect width="20" height="20" x="3" y="3" rx="2" ry="2"></rect><circle cx="9" cy="9" r="2"></circle><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path></svg>
                                        <span class="text-stone-400">이미지 추가</span>
                                    </div>
                                    <div class="absolute top-2.5 right-2.5">
                                        <button class="file_del w-[28px] h-[28px] bg-stone-600/50 rounded-full hidden">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-white mx-auto w-4 h-4"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                                        </button>
                                    </div>
                                    <div class="absolute top-2.5 left-2.5">
                                        <p class="py-1 px-2 bg-stone-600/50 text-white text-center rounded-full text-sm hidden">대표이미지</p>
                                    </div>
                                </div>
                            </div>

                            <!-- 이미지 추가 버튼 누른 후 이미지들 시작점  -->
                            {{--
                            <div class="w-[150px] h-[150px] rounded-md relative flex items-center justify-center bg-slate-400">
                                <img class="w-[150px] h-[150px] object-cover rounded-md" src="https://allfurn-prod-s3-bucket.s3.ap-northeast-2.amazonaws.com/product/881e2e2847bf5c63366fad4f668d63c2d1ce278b6f91aa9b37ef8567b194d273.jpg" alt="">
                                <div class="absolute top-2.5 right-2.5">
                                    <button class="file_del !w-[28px] !h-[28px] bg-stone-600/50 !rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-white mx-auto w-4 h-4"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                                    </button>
                                </div>
                                <div class="absolute top-2.5 left-2.5">
                                    <p class="py-1 px-2 bg-stone-600/50 text-white text-center rounded-full text-sm">대표이미지</p>
                                </div>
                            </div>
                            <div class="w-[150px] h-[150px] rounded-md relative flex items-center justify-center bg-slate-400">
                                <img class="w-[150px] h-[150px] object-cover rounded-md" src="https://allfurn-prod-s3-bucket.s3.ap-northeast-2.amazonaws.com/product/881e2e2847bf5c63366fad4f668d63c2d1ce278b6f91aa9b37ef8567b194d273.jpg" alt="">
                                <div class="absolute top-2.5 right-2.5">
                                    <button class="file_del !w-[28px] !h-[28px] bg-stone-600/50 !rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-white mx-auto w-4 h-4"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                                    </button>
                                </div>
                            </div>
                            --}}
                        </div>
                        <div class="info">
                            <div class="">
                                <p class="text-primary">· 첫번째 이미지가 대표 이미지로 노출됩니다.</p>
                                <p>· 이미지는 8개까지 등록 가능합니다.</p>
                            </div>
                        </div>
                    </dd>
                </dl>
            </div>
            <div class="divided"></div>
            <div class="inner">
                <dl class="mb-3">
                    <dt class="necessary">카테고리</dt>
                    <dd>
                        <button class="btn btn-line4 nohover flex items-center justify-between !w-full px-3 font-normal" onclick="modalOpen('#prod_category-modal')">
                            카테고리 선택
                            <svg class="w-6 h-6 stroke-stone-400 -rotate-90"><use xlink:href="/img/icon-defs.svg#drop_b_arrow"></use></svg>
                        </button>

                        <div class="mt-3">
                            <div class="txt-primary">선택된 카테고리</div>
                            <div id="categoryIdx">-</div>
                        </div>
                    </dd>
                </dl>
                <dl class="mb-3">
                    <dt class="necessary">상품 속성</dt>
                    <dd>
                        <button class="btn btn-line4 nohover flex items-center justify-between !w-full px-3 font-normal" onclick="modalOpen('#prod_property-modal')">
                            속성 선택
                            <svg class="w-6 h-6 stroke-stone-400 -rotate-90"><use xlink:href="/img/icon-defs.svg#drop_b_arrow"></use></svg>
                        </button>

                        <div class="info">
                            <div class="flex items-start gap-1">
                                <img class="w-3 mt-1 shrink-0" src="/img/member/info_icon.svg" alt="">
                                <p>상품에 맞는 속성이 없는 경우, 추가 공지 영역에 기입해주세요. 혹은 <span class="txt-primary">속성 추가가 필요한 경우, 1:1 문의를 통해 올펀에 요청해주세요.</span></p>
                            </div>
                        </div>
                    </dd>
                </dl>
            </div>

            <div class="bot_btn">
                <button class="btn btn-primary w-full" onclick="goStep('step2')">다음 (1/6)</button>
            </div>
        </div>

        <!-- step2 -->
        <div class="step2">
            <div class="top_info flex itmes-center justify-between">
                <h6>상품 기본 정보</h6>
            </div>
            <div class="inner">
                <dl class="mb-3 mt-3">
                    <dt class="necessary">상품 가격</dt>
                    <dd>
                        <input type="number" class="input-form w-full" placeholder="숫자만 입력해주세요.">
                    </dd>
                </dl>
                <dl class="mb-3">
                    <dt>가격 노출</dt>
                    <dd>
                        <div class="flex gap-2 btn_select">
                            <button class=" w-1/2" >노출</button>
                            <button class="w-1/2" >미노출</button>
                        </div>
                        <div class="btn_select_cont mt-2">
                            <div></div>
                            <div>
                                <div class="dropdown_wrap">
                                    <button class="dropdown_btn">가격 안내 문구 선택</button>
                                    <div class="dropdown_list">
                                        <div class="dropdown_item">수량마다 상이</div>
                                        <div class="dropdown_item">업체 문의</div>
                                    </div>
                                </div>
                                <div class="info">
                                    <div class="flex items-center gap-1">
                                        <img class="w-4" src="/img/member/info_icon.svg" alt="">
                                        <p> 가격 대신 선택한 문구가 노출됩니다.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </dd>
                </dl>
            </div>
            <div class="divided"></div>
            <div class="inner">
                <dl class="mb-3">
                    <dt>결제 방식</dt>
                    <dd>
                        <div class="dropdown_wrap">
                            <button class="dropdown_btn">직접입력</button>
                            <div class="dropdown_list">
                                <div class="dropdown_item" onClick="paymentShow('payment_method')">직접입력</div>
                                <div class="dropdown_item" onClick="paymentHide('payment_method')">계좌이체</div>
                                <div class="dropdown_item" onClick="paymentHide('payment_method')">업체 협의</div>
                                <div class="dropdown_item" onClick="paymentHide('payment_method')">세금 계산서 발행</div>
                            </div>
                        </div>
                        <div class="payment_method mt-2">
                            <input type="text" class="input-form w-full" placeholder="결제 방식을 입력해주세요.">
                        </div>
                    </dd>
                </dl>
            </div>
            <div class="divided"></div>
            <div class="inner">
                <dl class="mb-3">
                    <dt class="necessary">가격 노출</dt>
                    <dd>
                        <div class="flex gap-2 btn_select">
                            <button class=" w-1/2" >설정</button>
                            <button class="w-1/2" >미설정</button>
                        </div>
                    </dd>
                </dl>
            </div>
            <div class="bot_btn">
                <button class="btn btn-primary-line w-1/3" onclick="goStep('step1')">이전</button>
                <button class="btn btn-primary w-2/3" onclick="goStep('step3')">다음 (2/6)</button>
            </div>
        </div>

        <!-- step3 -->
        <div class="step3">
            <div class="top_info flex itmes-center justify-between">
                <h6>상품 기본 정보</h6>
            </div>
            <div class="inner">
                <dl class="mb-3 mt-3">
                    <dt>상품 코드</dt>
                    <dd>
                        <input type="text" class="input-form w-full" placeholder="상품 코드를 입력해주세요.">
                    </dd>
                </dl>
            </div>
            <div class="divided"></div>
            <div class="inner">
                <dl class="mb-3 mt-3">
                    <dt>상품 코드</dt>
                    <dd>
                        <button class="flex items-center justify-center gap-1 w-full h-11 text-white bg-stone-600 rounded" onclick="modalOpen('#prod_shipping-modal')">
                            <svg class="w-6 h-6 stroke-stone-400"><use xlink:href="/img/icon-defs.svg#plus_white"></use></svg>
                            배송 방법 추가
                        </button>
                    </dd>
                </dl>
            </div>
            <div class="divided"></div>
            <div class="inner">
                <dl class="mb-3 mt-3">
                    <dt>상품 추가 공지</dt>
                    <dd>
                        <textarea class="textarea_type" placeholder="상품 추가 공지사항을 입력해주세요."></textarea>
                    </dd>
                </dl>
            </div>
            <div class="divided"></div>
            <div class="inner">
                <dl class="mb-3 mt-3">
                    <dt>인증 정보</dt>
                    <dd>
                        <button class="flex items-center justify-center gap-1 w-full h-11 text-white bg-stone-600 rounded" onclick="modalOpen('#prod_certifi-modal')">
                            인증 정보 선택
                        </button>
                    </dd>
                </dl>
            </div>
            <div class="bot_btn">
                <button class="btn btn-primary-line w-1/3" onclick="goStep('step2')">이전</button>
                <button class="btn btn-primary w-2/3" onclick="goStep('step4')">다음 (3/6)</button>
            </div>
        </div>

        <!-- step4 -->
        <div class="step4">
            <div class="top_info flex itmes-center justify-between">
                <h6>상품 기본 정보</h6>
            </div>

            <div class="prod_detail_write">
                <div class="top_info">
                    <h6>상품 상세 내용</h6>
                    <button onclick="modalOpen('#writing_guide_modal')">상세 내용 작성 가이드</button>
                </div>
                <textarea name="" id="" class="prod_detail_area" placeholder="내용을 입력해주세요."></textarea>
            </div>

            <div class="bot_btn">
                <button class="btn btn-primary-line w-1/3" onclick="goStep('step3')">이전</button>
                <button class="btn btn-primary w-2/3" onclick="goStep('step5')">다음 (4/6)</button>
            </div>
        </div>

        <!-- step5 -->
        <div class="step5">
            <div class="top_info flex itmes-center justify-between">
                <h6>상품 주문 옵션</h6>
            </div>
            <div class="inner">
                <div class="info">
                    <div class="flex items-start gap-1">
                        <img class="w-4 mt-0.5" src="/img/member/info_icon.svg" alt="">
                        <p><span class="text-primary">주문 시 필수로 받아야 하는 옵션은 ‘필수 옵션’을 설정해주세요.</span> 필수 옵션의 경우, 주문 시 상위 옵션을 선택해야 하위 옵션 선택이 가능합니다. 상위 개념의 옵션을 옵션 1로 설정해주세요.</p>
                    </div>
                    <div class="flex items-start gap-1 mt-3">
                        <img class="w-4 mt-1" src="/img/member/info_icon.svg" alt="">
                        <p><span class="text-primary">등록한 상품 외 추가로 금액 산정이 필요한 구성품인 경우, 옵션값 하단에 반드시 가격을 입력해주세요.</span></p>
                    </div>
                    <div class="flex items-center gap-1 mt-3">
                        <img class="w-4" src="/img/member/info_icon.svg" alt="">
                        <p>주문 옵션은 최대 6개까지 추가 가능합니다.</p>
                    </div>
                </div>
            </div>
            <div class="divided"></div>
            <div class="inner">
                <div class="flex items-center justify-end mb-2 option_list_btn">
                    <button onclick="modalOpen('#change_order_modal')">옵션 순서 변경</button>
                </div>
                <div class="option_item mb-2">
                    <div class="option_tit">
                        <p>옵션 1</p>
                        <button>삭제</button>
                    </div>
                    <div class="option_box">
                        <dl class="mb-3">
                            <dt class="necessary">필수 옵션</dt>
                            <dd>
                                <div class="flex gap-2 btn_select">
                                    <button class=" w-1/2" >설정</button>
                                    <button class="w-1/2" >설정 안함</button>
                                </div>
                            </dd>
                        </dl>
                        <dl class="mb-3">
                            <dt class="necessary">옵션명</dt>
                            <dd><input type="text" class="input-form w-full" placeholder="예시) 색상"></dd>
                        </dl>
                    </div>
                    <div class="option_box">
                        <dl class="mb-3">
                            <dt class="necessary">옵션값</dt>
                            <dd><input type="text" class="input-form w-full" placeholder="예시) 화이트"></dd>
                            <dd><input type="text" class="input-form w-full mt-2" placeholder="예시) 100,000원"></dd>
                        </dl>
                    </div>
                    <div class="option_box">
                        <dl class="mb-3">
                            <dt class="necessary">옵션값</dt>
                            <dd><input type="text" class="input-form w-full" placeholder="예시) 화이트"></dd>
                            <dd><input type="text" class="input-form w-full mt-2" placeholder="예시) 100,000원"></dd>
                        </dl>
                    </div>
                    <div class="option_box">
                        <button class="flex items-center justify-center gap-1 w-full h-11 rounded option_add">
                            <svg class="w-5 h-5 stroke-stone-400"><use xlink:href="/img/icon-defs.svg#plus"></use></svg>
                            옵션값 추가
                        </button>
                    </div>
                </div>
                <button class="flex items-center justify-center gap-1 w-full h-11 text-white bg-stone-600 rounded">
                    <svg class="w-5 h-5 stroke-stone-400"><use xlink:href="/img/icon-defs.svg#plus_white"></use></svg>
                    주문 옵션 추가
                </button>
            </div>
            <div class="bot_btn mt-2">
                <button class="btn btn-primary-line w-1/3" onclick="goStep('step4')">이전</button>
                <button class="btn btn-primary w-2/3" onclick="goStep('step6')">다음 (5/6)</button>
            </div>
        </div>

        <!-- step6 -->
        <div class="step6">
            <div class="top_info flex itmes-center justify-between">
                <h6>상품 주문 정보</h6>
            </div>
            <div class="inner">
                <dl class="mb-3 mt-3">
                    <dt>결제 안내</dt>
                    <dd>
                        <div class="flex gap-2 btn_select">
                            <button class=" w-1/2">설정</button>
                            <button class="w-1/2">설정 안함</button>
                        </div>
                        <div class="btn_select_cont mt-2">
                            <div>
                                <textarea name="" id="" class="textarea_type" placeholder="안내 상세 내용 입력"></textarea>
                            </div>
                            <div></div>
                        </div>
                    </dd>
                </dl>
                <dl class="mb-3">
                    <dt>배송 안내</dt>
                    <dd>
                        <div class="flex gap-2 btn_select">
                            <button class=" w-1/2">설정</button>
                            <button class="w-1/2">설정 안함</button>
                        </div>
                        <div class="btn_select_cont mt-2">
                            <div>
                                <textarea name="" id="" class="textarea_type" placeholder="안내 상세 내용 입력"></textarea>
                            </div>
                            <div></div>
                        </div>
                    </dd>
                </dl>
                <dl class="mb-3 mt-3">
                    <dt>교환/반품/취소 안내</dt>
                    <dd>
                        <div class="flex gap-2 btn_select">
                            <button class=" w-1/2">설정</button>
                            <button class="w-1/2">설정 안함</button>
                        </div>
                        <div class="btn_select_cont mt-2">
                            <div>
                                <textarea name="" id="" class="textarea_type" placeholder="안내 상세 내용 입력"></textarea>
                            </div>
                            <div></div>
                        </div>
                    </dd>
                </dl>
                <dl class="mb-3 mt-3">
                    <dt>주문 정보 직접 입력 안내</dt>
                    <dd>
                        <div class="flex gap-2 btn_select">
                            <button class=" w-1/2">설정</button>
                            <button class="w-1/2">설정 안함</button>
                        </div>
                        <div class="btn_select_cont mt-2">
                            <div>
                                <input type="text" class="input-form w-full mb-2" placeholder="항목 제목">
                                <textarea name="" id="" class="textarea_type" placeholder="안내 상세 내용 입력"></textarea>
                            </div>
                            <div></div>
                        </div>
                    </dd>
                </dl>
            </div>
            <div class="bot_btn">
                <button class="btn btn-primary-line w-1/4" onclick="goStep('step5')">이전</button>
                <button class="btn btn-primary-line w-1/4" onclick="modalOpen('#state_preview_modal')">미리보기</button>
                <button class="btn btn-primary-line w-1/4">임시 등록</button>
                <button class="btn btn-primary w-1/4">등록</button>
            </div>
        </div>
    </div>



    <!-- 상품등록 > 카테고리 선택 -->
    <div class="modal" id="prod_category-modal">
        <div class="modal_bg" onclick="modalClose('#prod_category-modal')"></div>
        <div class="modal_inner modal-md">
            <button class="close_btn" onclick="modalClose('#prod_category-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body prod_cate_body">
                <h4>카테고리 선택</h4>
                <ul class="prod_category">
                    @if( isset($categoryList) != '' )
                    @foreach( $categoryList as $c => $category )
                    <li>
                        <button cidx="{{$category->idx}}" onclick="prodCate(this)"><span>{{$category->name}}</span><svg class="w-6 h-6 stroke-stone-400 "><use xlink:href="/img/icon-defs.svg#drop_b_arrow"></use></svg></button>
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
            <button class="close_btn" onclick="modalClose('#prod_property-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body h_fix btnok filter_body prod_property_body">
                <h4>속성</h4>
                <ul class="prod_property_tab">
                    <!-- //-->
                </ul>
                <div class="prod_property_cont">
                    <div class="active">
                        <ul class="filter_list !mt-0 !mb-0">
                            <li>
                                <input type="checkbox" class="check-form" id="registration_prop_01">
                                <label for="registration_prop_01">침대/매트리스</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="registration_prop_02">
                                <label for="registration_prop_02">소파/거실</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="registration_prop_03">
                                <label for="registration_prop_03">식탁/의자</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="registration_prop_04">
                                <label for="registration_prop_04">수납/서랍장/옷장</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="registration_prop_05">
                                <label for="registration_prop_05">서재/공부방</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="registration_prop_06">
                                <label for="registration_prop_06">화장대/거울/콘솔</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="registration_prop_07">
                                <label for="registration_prop_07">키즈/주니어</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="registration_prop_08">
                                <label for="registration_prop_08">진열장/장식장</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="registration_prop_09">
                                <label for="registration_prop_09">의자</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="registration_prop_10">
                                <label for="registration_prop_10">테이블</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="registration_prop_11">
                                <label for="registration_prop_11">사무용가구</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="registration_prop_12">
                                <label for="registration_prop_12">조달가구</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="registration_prop_13">
                                <label for="registration_prop_13">업소용가구</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="registration_prop_14">
                                <label for="registration_prop_14">아웃도어가구</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="registration_prop_15">
                                <label for="registration_prop_15">펫가구</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="registration_prop_16">
                                <label for="registration_prop_16">기타 카테고리</label>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <ul class="filter_list !mt-0 !mb-0">
                            <li>
                                <input type="checkbox" class="check-form" id="registration_prop_17">
                                <label for="registration_prop_17">침대/매트리스</label>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <ul class="filter_list !mt-0 !mb-0">
                            <li>
                                <input type="checkbox" class="check-form" id="registration_prop_18">
                                <label for="registration_prop_18">침대/매트리스</label>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <ul class="filter_list !mt-0 !mb-0">
                            <li>
                                <input type="checkbox" class="check-form" id="registration_prop_19">
                                <label for="registration_prop_19">침대/매트리스</label>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <ul class="filter_list !mt-0 !mb-0">
                            <li>
                                <input type="checkbox" class="check-form" id="registration_prop_20">
                                <label for="registration_prop_20">침대/매트리스</label>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <ul class="filter_list !mt-0 !mb-0">
                            <li>
                                <input type="checkbox" class="check-form" id="registration_prop_21">
                                <label for="registration_prop_21">침대/매트리스</label>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <ul class="filter_list !mt-0 !mb-0">
                            <li>
                                <input type="checkbox" class="check-form" id="registration_prop_22">
                                <label for="registration_prop_22">침대/매트리스</label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="btn_bot">
                    <button class="btn btn-line3 refresh_btn" onclick="refreshHandle(this)"><svg><use xlink:href="/img/icon-defs.svg#refresh"></use></svg>초기화</button>
                    <button class="btn btn-primary">상품 찾아보기</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 상품등록 > 배송방법 -->
    <div class="modal" id="prod_shipping-modal">
        <div class="modal_bg" onclick="modalClose('#prod_shipping-modal')"></div>
        <div class="modal_inner modal-md">
            <button class="close_btn" onclick="modalClose('#prod_shipping-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
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
                                        <button class="w-1/2 ">무료</button>
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
            <button class="close_btn" onclick="modalClose('#prod_certifi-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body filter_body">
                <h4>인증 정보</h4>
                <ul class="filter_list">
                    <li>
                        <input type="checkbox" class="check-form" id="prod_certifi_01">
                        <label for="prod_certifi_01">KS 인증</label>
                    </li>
                    <li>
                        <input type="checkbox" class="check-form" id="prod_certifi_02">
                        <label for="prod_certifi_02">ISO 인증</label>
                    </li>
                    <li>
                        <input type="checkbox" class="check-form" id="prod_certifi_03">
                        <label for="prod_certifi_03">KC 인증</label>
                    </li>
                    <li>
                        <input type="checkbox" class="check-form" id="prod_certifi_04">
                        <label for="prod_certifi_04">친환경 인증</label>
                    </li>
                    <li>
                        <input type="checkbox" class="check-form" id="prod_certifi_05">
                        <label for="prod_certifi_05">외코텍스(OEKO-TEX) 인증</label>
                    </li>
                    <li>
                        <input type="checkbox" class="check-form" id="prod_certifi_06">
                        <label for="prod_certifi_06">독일 LGA인증/GOTS(오가닉) 인증</label>
                    </li>
                    <li>
                        <input type="checkbox" class="check-form" id="prod_certifi_07">
                        <label for="prod_certifi_07">라돈테스트 인증</label>
                    </li>
                    <li>
                        <input type="checkbox" class="check-form" id="prod_certifi_08">
                        <label for="prod_certifi_08">전자파 인증</label>
                    </li>
                    <li>
                        <input type="checkbox" class="check-form" id="prod_certifi_09">
                        <label for="prod_certifi_09">전기용품안전 인증</label>
                    </li>
                    <li>
                        <input type="checkbox" class="check-form" id="prod_certifi_10">
                        <label for="prod_certifi_10">기타 인증</label>
                    </li>
                </ul>
                <div class="btn_bot">
                    <button class="btn btn-primary !w-full">선택 완료</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 상품 상세 내용 가이드 모달-->
    <div class="modal" id="writing_guide_modal">
        <div class="modal_bg" onclick="modalClose('#writing_guide_modal')"></div>
        <div class="modal_inner inner_full">
            <button class="close_btn" onclick="modalClose('#writing_guide_modal')"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button>
            <div class="modal_body fix_full">
                <div class="p-5">
                    <p class="text-lg font-bold text-left">이용 가이드</p>
                    <div class="mt-5 writing_guide_body">
                        <div class="relative">
                            <a href="javascript:;" class="h-[48px] px-3 border rounded-md inline-block filter_border filter_dropdown w-[full] flex justify-between items-center mt-3">
                                <p>이용가이드</p>
                                <svg class="w-6 h-6 filter_arrow"><use xlink:href="/img/icon-defs.svg#drop_b_arrow"></use></svg>
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
            <button class="close_btn" onclick="modalClose('#state_preview_modal')"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button>
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
                                        <li class="swiper-slide"><img src="/img/video_thumb.png" alt=""></li
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
                <div class="flex justify-center py-2">
                    <button class="btn btn-primary w-1/4" onclick="modalClose('#state_preview_modal')">확인</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    var storedFiles = [];
    var subCategoryIdx = null;
    var deleteImage = [];
    var proc = false;
    var authList = ['KS 인증', 'ISO 인증', 'KC 인증', '친환경 인증', '외코텍스(OEKO-TEX) 인증', '독일 LGA 인증', 'GOTS(오가닉) 인증', '라돈테스트 인증', '전자파 인증', '전기용품안전 인증'];
    var oIdx = 0;
    var _tmp = 0;

    // step 이동
    const goStep = (item)=>{
        $(`.prod_regist_box .${item}`).addClass('active').siblings().removeClass('active')
    }

    // 결제방식
    const paymentShow = (item)=>{
        $(`.${item}`).removeClass('hidden')
    }

    const paymentHide  = (item)=>{
        $(`.${item}`).addClass('hidden')
    }

    $(document)
        .on('change', '#form-list02', function() {
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
                                '<div class="w-[150px] h-[150px] rounded-md relative flex items-center justify-center bg-slate-400 product-img__add" file="' + file.name +  '">' +
                                '   <img class="w-[150px] h-[150px] object-cover rounded-md" src="' + e.target.result + '" alt="상품이미지0' + imgCnt + '">' +
                                '   <div class="absolute top-2.5 right-2.5">' +
                                '       <button class="file_del !w-[28px] !h-[28px] bg-stone-600/50 !rounded-full">' +
                                '           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-white mx-auto w-4 h-4"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>' +
                                '       </button>' +
                                '   </div>' +
                                '</div>'
                            );

                            // 첫번째 이미지를 대표이미지로 표시
                            if (imgCnt == 1) {
                                $('.product-img__add').append(
                                    '<div class="absolute top-2.5 left-2.5">' +
                                    '   <p class="py-1 px-2 bg-stone-600/50 text-white text-center rounded-full text-sm">대표이미지</p>' +
                                    '</div>'
                                );
                            }

                            if (imgCnt == 8) {
                                $('.desc__product-img-wrap > div').first().hide();
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
        })

    // 버튼 온오프
    $('.btn_select button').on('click',function(){
        $(this).addClass('active').siblings().removeClass('active')
        const selectCont = $(this).parent('.btn_select').next('.btn_select_cont')
        if(selectCont){
            let liN = $(this).index()
            selectCont.find('>div').eq(liN).addClass('active').siblings().removeClass('active')
        }
    })


    $('.guide_list a').click(function() {
        // 클릭된 항목의 data-target 값 가져오기
        var targetId = $(this).data('target');

        // 모든 가이드 내용 숨기기
        $('.guide_con').hide();

        // 해당하는 ID를 가진 가이드 내용만 보여주기
        $('#' + targetId).show();
    });


    // 라디오버튼
    // 라디오 버튼의 변경을 감지
    $('input[type="radio"][name="price_exposure3"]').change(function() {
        // 선택된 라디오 버튼이 '직접입력'에 해당하는지 확인
        var isDirectInputSelected = $('#price_exposure08').is(':checked');

        // '직접입력' 선택 시, 입력 필드 표시
        if(isDirectInputSelected) {
            $('.direct_input').show();
        } else {
            // 다른 라디오 버튼 선택 시, 입력 필드 숨김
            $('.direct_input').hide();
        }
    });

    // 옵션 순서 변경
    $(function() {
        $("#sortable").sortable();
        // $("#sortable").disableSelection();
    });


    // 'delivery_del' 버튼 클릭 이벤트 핸들러
    $(document).on('click', '.delivery_del', function() {
        // 클릭된 요소의 가장 가까운 .shipping_method 부모를 삭제
        $(this).closest('.shipping_method').remove();

        // .shipping_method 요소의 존재 여부를 확인하여 .plus_del 요소의 표시 상태 결정
        updatePlusDelVisibility();
    });

    function setCategory()
    {
        var _this = $('input:radio[name=prod_category]:checked');
        var _idx  = _this.val();
        var _p_idx= _this.data('p_idx');

        // 카테고리 설정
        if( typeof _idx != 'undefined' && _idx != '' ) {
            var _text = _this.closest('ul').prev('button').find('span').text();
            var _sub = $("label[for='" + _this.attr('id') + "'").text();

            $('#categoryIdx').data('category_idx', _idx);
            $('#categoryIdx').text(_text + ' > ' + _sub);

            getProperty(_idx);
        }

        modalClose('#prod_category-modal');
    }

    // 속성 가져오기
    function getProperty(category_idx) {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url				: '/product/getCategoryProperty',
            data			: {
                'category_idx' : category_idx,
                'parentIdx' : null
            },
            type			: 'POST',
            dataType		: 'json',
            success		: function(result) {
                var htmlText = '';
                var subHtmlText = '';
                var _active = '';
                result.forEach(function (e, idx) {
                    if( idx == 0 ) {
                        _active = 'active';
                    } else {
                        _active = '';
                    }

                    htmlText += '' +
                        '<li class="' + _active + '"><button>' + e.name + '</button></li>';
                });

                $('#prod_property-modal .prod_property_tab').html(htmlText);
            }
        });
    }

    // 속성 선택하기
    $('#product_attributes_modal button').click(function () {
        if ($(this).has('.btn-primary')) {
            var htmlText = "";
            $('#product_attributes_modal .check-form:checked').map(function (n, i) {

                htmlText += '<div class="flex items-center bg-stone-100 px-3 py-1 rounded-full gap-1" data-sub_idx="' + $(this).data('sub_property') + '">' +
                    '   <span class="text-stone-500 property_name">' + $(this).data('sub_name') + '</span>' +
                    '   <button><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-stone-400"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg></button>' +
                    '</div>';
            })
            $('#property .select-group__result[data-property_idx="' + $('#product_attributes_modal').data('property_idx') + '"]').html(htmlText);

            modalClose('#product_attributes_modal');
        }
    })

    // .shipping_method 요소의 존재 여부에 따라 .plus_del 요소의 표시 상태를 업데이트하는 함수
    function updatePlusDelVisibility() {
        if ($('.shipping_method').length === 0) {
            // .shipping_method 요소가 있으면 .plus_del 요소를 표시
            $('.plus_del').hide();
        } else {
            // 하나 이상의 .shipping_method 요소가 없으면 .plus_del 요소를 숨김
            $('.plus_del').show();
        }
    }

    // 상품등록 > 속성 모달
    $('#prod_property-modal .prod_property_tab li').on('click',function()
    {
        console.log('1111');
        let liN = $(this).index();
        $(this).addClass('active').siblings().removeClass('active')
        $('.prod_property_cont > div').eq(liN).addClass('active').siblings().removeClass('active')
    })

    // 페이지 로드 시 .plus_del 요소의 초기 표시 상태 결정
    updatePlusDelVisibility();
</script>
@endsection