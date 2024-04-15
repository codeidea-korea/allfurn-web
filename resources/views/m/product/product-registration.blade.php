@extends('layouts.app_m')
@section('content')
<div id="content">
    <div class="detail_mo_top write_type center_type">
        <div class="inner">
            <h3>상품 등록</h3>
            <a class="back_img" href="./index.php"><svg><use xlink:href="./img/icon-defs.svg#x"></use></svg></a>
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
                        <input type="text" class="input-form w-full" placeholder="상품명을 입력해주세요.">
                    </dd>
                </dl>
                <dl class="mb-3">
                    <dt>상품 이미지</dt>
                    <dd>
                        <div class="flex flex-wrap items-center gap-3">
                            <div class="border border-dashed w-[150px] h-[150px] rounded-md relative flex items-center justify-center">
                                <input type="file" class="file_input">
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
                            <svg class="w-6 h-6 stroke-stone-400 -rotate-90"><use xlink:href="./img/icon-defs.svg#drop_b_arrow"></use></svg>
                        </button>

                        <div class="mt-3">
                            <div class="txt-primary">선택된 카테고리</div>
                            <div>서재/공부방 > 의자</div>
                        </div>
                    </dd>
                </dl>
                <dl class="mb-3">
                    <dt class="necessary">상품 속성</dt>
                    <dd>
                        <button class="btn btn-line4 nohover flex items-center justify-between !w-full px-3 font-normal" onclick="modalOpen('#prod_property-modal')">
                            속성 선택
                            <svg class="w-6 h-6 stroke-stone-400 -rotate-90"><use xlink:href="./img/icon-defs.svg#drop_b_arrow"></use></svg>
                        </button>

                        <div class="info">
                            <div class="flex items-start gap-1">
                                <img class="w-3 mt-1 shrink-0" src="./img/member/info_icon.svg" alt="">
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
                                        <img class="w-4" src="./img/member/info_icon.svg" alt="">
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
                            <svg class="w-6 h-6 stroke-stone-400"><use xlink:href="./img/icon-defs.svg#plus_white"></use></svg>
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
                        <img class="w-4 mt-0.5" src="./img/member/info_icon.svg" alt="">
                        <p><span class="text-primary">주문 시 필수로 받아야 하는 옵션은 ‘필수 옵션’을 설정해주세요.</span> 필수 옵션의 경우, 주문 시 상위 옵션을 선택해야 하위 옵션 선택이 가능합니다. 상위 개념의 옵션을 옵션 1로 설정해주세요.</p>
                    </div>
                    <div class="flex items-start gap-1 mt-3">
                        <img class="w-4 mt-1" src="./img/member/info_icon.svg" alt="">
                        <p><span class="text-primary">등록한 상품 외 추가로 금액 산정이 필요한 구성품인 경우, 옵션값 하단에 반드시 가격을 입력해주세요.</span></p>
                    </div>
                    <div class="flex items-center gap-1 mt-3">
                        <img class="w-4" src="./img/member/info_icon.svg" alt="">
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
                            <svg class="w-5 h-5 stroke-stone-400"><use xlink:href="./img/icon-defs.svg#plus"></use></svg>
                            옵션값 추가
                        </button>
                    </div>
                </div>
                <button class="flex items-center justify-center gap-1 w-full h-11 text-white bg-stone-600 rounded">
                    <svg class="w-5 h-5 stroke-stone-400"><use xlink:href="./img/icon-defs.svg#plus_white"></use></svg>
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


</div>





<script>
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


    $(document).ready(function() {

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
    });

    $(document).ready(function() {
        // 'delivery_del' 버튼 클릭 이벤트 핸들러
        $(document).on('click', '.delivery_del', function() {
            // 클릭된 요소의 가장 가까운 .shipping_method 부모를 삭제
            $(this).closest('.shipping_method').remove();

            // .shipping_method 요소의 존재 여부를 확인하여 .plus_del 요소의 표시 상태 결정
            updatePlusDelVisibility();
        });

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

        // 페이지 로드 시 .plus_del 요소의 초기 표시 상태 결정
        updatePlusDelVisibility();
    });
</script>

@endsection