@extends('layouts.app')

@section('content')
@include('layouts.header')
    <div id="content">
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
                    @if(sizeof($productList)>0)
                        <button class="h-[48px] w-[160px] rounded-md border border-stone-700 hover:bg-stone-100" onclick="getProductList(1);">
                            기본 정보 불러오기
                        </button>
                    @endif
                    <!-- button class="h-[48px] w-[160px] rounded-md border border-stone-700 hover:bg-stone-100" onclick="modalOpen('#retrieve_information_modal')">기본 정보 불러오기</button //-->
                </div>
                <div class="mb-5 pb-5 border-b">
                    <dl class="flex">
                        <dt class="essential w-[190px] shrink-0 mt-2">상품명</dt>
                        <dd class="font-medium w-full">
                            <input type="text" id="form-list01" name="name" maxlength="50"
                                @if(@isset($data->name))
                                    value="{{$data->name}}"
                                @endif
                                class="setting_input h-[48px] w-full" placeholder="상품명을 입력해주세요." required>
                        </dd>
                    </dl>
                </div>
                <div class="mb-5 pb-5 border-b">
                    <dl class="flex">
                        <dt class="w-[190px] shrink-0 mt-2">상품 이미지</dt>
                        <dd class="font-medium w-full">
                            <div class="flex flex-wrap items-center gap-3 desc__product-img-wrap ui-sortable">
                                <div class="border border-dashed w-[200px] h-[200px] rounded-md relative flex items-center justify-center">
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

                                {{--
                                <!-- 이미지 추가 버튼 누른 후 이미지들 시작점  -->
                                <div class="w-[200px] h-[200px] rounded-md relative flex items-center justify-center bg-slate-400">
                                    <div class="absolute top-2.5 right-2.5">
                                        <button class="file_del w-[28px] h-[28px] bg-stone-600/50 rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-white mx-auto w-4 h-4"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                                        </button>
                                    </div>
                                    <div class="absolute top-2.5 left-2.5">
                                        <p class="py-1 px-2 bg-stone-600/50 text-white text-center rounded-full text-sm">대표이미지</p>
                                    </div>
                                </div>
                                <div class="w-[200px] h-[200px] rounded-md relative flex items-center justify-center bg-slate-400">
                                    <div class="absolute top-2.5 right-2.5">
                                        <button class="file_del w-[28px] h-[28px] bg-stone-600/50 rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-white mx-auto w-4 h-4"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                                        </button>
                                    </div>
                                </div>
                                --}}
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
                                    <!-- 카테고리 영역 //-->
                                </div>
                            </div>
                            <div class="text-primary mt-3">
                                선택한 카테고리 : <span>-</span>
                            </div>
                        </dd>
                    </dl>
                </div>
                <div class="mb-5 pb-5 border-b">
                    <dl class="flex">
                        <dt class="w-[190px] shrink-0 mt-2">상품 속성</dt>
                        <dd id="property" class="font-medium w-full">
                            <!-- 상품속성 영역 //-->
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
                                            <input type="radio" name="price_exposure" id="price_exposure01" value="1" {{isset($data->is_price_open) && $data->is_price_open == 1 ? 'checked' : ''}}>
                                            <label for="price_exposure01" class="w-[140px] h-[48px] flex items-center justify-center">노출</label>
                                        </div>
                                        <div style="margin-left:-1px;">
                                            <input type="radio" name="price_exposure" id="price_exposure02" value="0" {{!isset($data->is_price_open) || $data->is_price_open == 0 ? 'checked' : ''}}>
                                            <label for="price_exposure02" class="w-[140px] h-[48px] flex items-center justify-center">미노출</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- 미노출일 때 출력 -->
                                <div class="select-group__dropdown">
                                    <div class="mt-5">
                                        <a href="javascript:;" class="h-[48px] px-3 border rounded-sm inline-block filter_border filter_dropdown w-[410px] flex justify-between items-center">
                                            <p>가격 안내 문구 선택</p>
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
                                    <input type="radio" name="price_exposure2" id="price_exposure03" checked="" value="1">
                                    <label for="price_exposure03" class="w-[140px] h-[48px] flex items-center justify-center">설정</label>
                                </div>
                                <div style="margin-left:-1px;">
                                    <input type="radio" name="price_exposure2" id="price_exposure04" value="0">
                                    <label for="price_exposure04" class="w-[140px] h-[48px] flex items-center justify-center">미설정</label>
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
                                    <input type="radio" name="price_exposure3" id="price_exposure05" checked="" value="1">
                                    <label for="price_exposure05" class="w-[140px] h-[48px] flex items-center justify-center">업체 협의</label>
                                </div>
                                <div style="margin-left:-1px;">
                                    <input type="radio" name="price_exposure3" id="price_exposure06" value="2">
                                    <label for="price_exposure06" class="w-[140px] h-[48px] flex items-center justify-center">계좌이체</label>
                                </div>
                                <div style="margin-left:-1px;">
                                    <input type="radio" name="price_exposure3" id="price_exposure07" value="3">
                                    <label for="price_exposure07" class="w-[140px] h-[48px] flex items-center justify-center">세금계산서 발행</label>
                                </div>
                                <div style="margin-left:-1px;">
                                    <input type="radio" name="price_exposure3" id="price_exposure08" value="4">
                                    <label for="price_exposure08" class="w-[140px] h-[48px] flex items-center justify-center">직접입력</label>
                                </div>
                            </div>
                            <div class="direct_input mt-5 hidden">
                                <input type="text" name="payment" id="form-list01" class="setting_input h-[48px] w-full" placeholder="결제 방식을 입력해주세요.">
                            </div>
                        </dd>
                    </dl>
                </div>

                <div class="mb-5 pb-5 border-b">
                    <dl class="flex">
                        <dt class="w-[190px] shrink-0 mt-2">상품 코드</dt>
                        <dd class="font-medium w-full">
                            <input type="text" name="product_code" maxlength="10" value="" class="setting_input h-[48px] w-full" placeholder="상품 코드를 입력해주세요.">
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
                                <div class="flex items-center gap-3 mt-3">
                                    <!-- div class="shipping_method px-4 py-2 bg-stone-100 flex items-center gap-1 text-sm rounded-full">
                                        소비자 직배 가능 (무료)
                                        <button class="delivery_del"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-stone-500"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg></button>
                                    </div>
                                    <div class="shipping_method px-4 py-2 bg-stone-100 flex items-center gap-1 text-sm rounded-full">
                                        소비자 직배 가능 (착불)
                                        <button class="delivery_del"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-stone-500"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg></button>
                                    </div //-->
                                </div>
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
                            <button class="h-[48px] w-[240px] rounded-md bg-stone-700 text-white hover:bg-stone-600" onclick="openAuthInfo();">인증 정보 선택</button>
                            <div class="mt-3 hidden">
                                <span class="plus_del text-primary text-sm">선택된 인증 정보</span>
                                <div class="mt-1">
                                    <span>독일 LGA 인증,</span>
                                    <span>GOTS(오가닉) 인증,</span>
                                    <span>라돈테스트 인증,</span>
                                </div>

                            </div>
                        </dd>
                    </dl>
                </div>

                <div class="mb-5 pb-5">
                    <dl class="flex">
                        <dt class="essential w-[190px] shrink-0 mt-2">상품 상세 내용</dt>
                        <dd class="font-medium w-full">
                            <button class="h-[48px] w-[240px] rounded-md border border-stone-700 hover:bg-stone-100" onclick="modalOpen('#writing_guide_modal')">상세 내용 작성 가이드</button>
                            <div class="h-[100px] py-3 mt-5">
                                <textarea class="textarea-form"></textarea>
                                {{--
                                <div class="guide__smart-editor fr-box fr-basic fr-top" name="product_detail" role="application">
                                    <div class="fr-toolbar fr-desktop fr-top fr-basic fr-sticky-off" data-sticky-offset="true" data-top="0px" data-bottom="auto" style="top: 0px;">
                                        <div class="fr-btn-grp fr-float-left">
                                            <button id="bold-1" type="button" tabindex="-1" role="button" aria-pressed="false" title="Bold (Ctrl+B)" class="fr-command fr-btn" data-cmd="bold">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15.25,11.8h0A3.68,3.68,0,0,0,17,9a3.93,3.93,0,0,0-3.86-4H6.65V19h7a3.74,3.74,0,0,0,3.7-3.78V15.1A3.64,3.64,0,0,0,15.25,11.8ZM8.65,7h4.2a2.09,2.09,0,0,1,2,1.3,2.09,2.09,0,0,1-1.37,2.61,2.23,2.23,0,0,1-.63.09H8.65Zm4.6,10H8.65V13h4.6a2.09,2.09,0,0,1,2,1.3,2.09,2.09,0,0,1-1.37,2.61A2.23,2.23,0,0,1,13.25,17Z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Bold</span>
                                            </button>
                                            <button id="italic-1" type="button" tabindex="-1" role="button" aria-pressed="false" title="Italic (Ctrl+I)" class="fr-command fr-btn" data-cmd="italic">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.76,9h2l-2.2,10h-2Zm1.68-4a1,1,0,1,0,1,1,1,1,0,0,0-1-1Z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Italic</span>
                                            </button>
                                            <button id="underline-1" type="button" tabindex="-1" role="button" aria-pressed="false" title="Underline (Ctrl+U)" class="fr-command fr-btn" data-cmd="underline">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M19,20v2H5V20Zm-3-6.785a4,4,0,0,1-5.74,3.4A3.75,3.75,0,0,1,8,13.085V5.005H6v8.21a6,6,0,0,0,8,5.44,5.851,5.851,0,0,0,4-5.65v-8H16ZM16,5v0h2V5ZM8,5H6v0H8Z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Underline</span>
                                            </button>
                                            <button id="moreText-1" data-group-name="moreText-1" type="button" tabindex="-1" role="button" title="More Text" class="fr-command fr-btn" data-cmd="moreText">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M13.55,19h2l-5-14h-2l-5,14h2l1.4-4h5.1Zm-5.9-6,1.9-5.2,1.9,5.2Zm12.8,4.5a1.5,1.5,0,1,1-1.5-1.5A1.5,1.5,0,0,1,20.45,17.5Zm0-4a1.5,1.5,0,1,1-1.5-1.5A1.5,1.5,0,0,1,20.45,13.5Zm0-4A1.5,1.5,0,1,1,18.95,8,1.5,1.5,0,0,1,20.45,9.5Z"></path>
                                                </svg>
                                                <span class="fr-sr-only">More Text</span>
                                            </button>
                                        </div>
                                        <div class="fr-btn-grp fr-float-left">
                                            <button id="alignLeft-1" type="button" tabindex="-1" role="button" title="Align Left" class="fr-command fr-btn" data-cmd="alignLeft">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M3,18h6v-2H3V18z M3,11v2h12v-2H3z M3,6v2h18V6H3z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Align Left</span>
                                            </button>
                                            <button id="alignCenter-1" type="button" tabindex="-1" role="button" title="Align Center" class="fr-command fr-btn" data-cmd="alignCenter">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9,18h6v-2H9V18z M6,11v2h12v-2H6z M3,6v2h18V6H3z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Align Center</span>
                                            </button>
                                            <button id="formatOLSimple-1" type="button" tabindex="-1" role="button" title="Ordered List" class="fr-command fr-btn" data-cmd="formatOLSimple">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M2.5,16h2v.5h-1v1h1V18h-2v1h3V15h-3Zm1-7h1V5h-2V6h1Zm-1,2H4.3L2.5,13.1V14h3V13H3.7l1.8-2.1V10h-3Zm5-5V8h14V6Zm0,12h14V16H7.5Zm0-5h14V11H7.5Z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Ordered List</span>
                                            </button>
                                            <button id="moreParagraph-1" data-group-name="moreParagraph-1" type="button" tabindex="-1" role="button" title="More Paragraph" class="fr-command fr-btn" data-cmd="moreParagraph">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M7.682,5a4.11,4.11,0,0,0-4.07,3.18,4,4,0,0,0,3.11,4.725h0l.027.005a3.766,3.766,0,0,0,.82.09v6h2V7h2V19h2V7h2V5ZM5.532,9a2,2,0,0,1,2-2v4A2,2,0,0,1,5.532,9Zm14.94,8.491a1.5,1.5,0,1,1-1.5-1.5A1.5,1.5,0,0,1,20.472,17.491Zm0-4a1.5,1.5,0,1,1-1.5-1.5A1.5,1.5,0,0,1,20.472,13.491Zm0-4a1.5,1.5,0,1,1-1.5-1.5A1.5,1.5,0,0,1,20.472,9.491Z"></path>
                                                </svg>
                                                <span class="fr-sr-only">More Paragraph</span>
                                            </button>
                                        </div>
                                        <div class="fr-btn-grp fr-float-left">
                                            <button id="markdown-1" type="button" tabindex="-1" role="button" aria-pressed="false" title="Markdown" class="fr-command fr-btn" data-cmd="markdown">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5.55006 17.75V7.35L8.96006 16.89H10.7101L14.2301 7.37V14.0729C14.3951 14.1551 14.5499 14.265 14.6875 14.4026L14.7001 14.4151V11.64C14.7001 10.8583 15.2127 10.1963 15.9201 9.97171V5H13.6801L10.0401 14.86L6.51006 5H4.00006V17.75H5.55006ZM17.2001 11.64C17.2001 11.2258 16.8643 10.89 16.4501 10.89C16.0359 10.89 15.7001 11.2258 15.7001 11.64V16.8294L13.9804 15.1097C13.6875 14.8168 13.2126 14.8168 12.9197 15.1097C12.6269 15.4026 12.6269 15.8775 12.9197 16.1703L15.9197 19.1703C16.2126 19.4632 16.6875 19.4632 16.9804 19.1703L19.9804 16.1703C20.2733 15.8775 20.2733 15.4026 19.9804 15.1097C19.6875 14.8168 19.2126 14.8168 18.9197 15.1097L17.2001 16.8294V11.64Z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Markdown</span>
                                            </button>
                                            <button id="insertLink-1" type="button" tabindex="-1" role="button" title="Insert Link (Ctrl+K)" class="fr-command fr-btn" data-cmd="insertLink" data-popup="true">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11,17H7A5,5,0,0,1,7,7h4V9H7a3,3,0,0,0,0,6h4ZM17,7H13V9h4a3,3,0,0,1,0,6H13v2h4A5,5,0,0,0,17,7Zm-1,4H8v2h8Z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Insert Link</span>
                                            </button>
                                            <button id="insertFiles-1" type="button" tabindex="-1" role="button" title="Insert Files" class="fr-command fr-btn" data-cmd="insertFiles" data-popup="true">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M 0 5.625 L 20.996094 5.625 L 21 15.75 C 21 16.371094 20.410156 16.875 19.6875 16.875 L 1.3125 16.875 C 0.585938 16.875 0 16.371094 0 15.75 Z M 0 5.625 M 21 4.5 L 0 4.5 L 0 2.25 C 0 1.628906 0.585938 1.125 1.3125 1.125 L 6.921875 1.125 C 7.480469 1.125 8.015625 1.316406 8.40625 1.652344 L 9.800781 2.847656 C 10.195312 3.183594 10.730469 3.375 11.289062 3.375 L 19.6875 3.375 C 20.414062 3.375 21 3.878906 21 4.5 Z M 21 4.5"></path>
                                                </svg>
                                                <span class="fr-sr-only">Insert Files</span>
                                            </button>
                                            <button id="insertImage-1" type="button" tabindex="-1" role="button" title="Insert Image (Ctrl+P)" class="fr-command fr-btn" data-cmd="insertImage" data-popup="true">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M14.2,11l3.8,5H6l3-3.9l2.1,2.7L14,11H14.2z M8.5,11c0.8,0,1.5-0.7,1.5-1.5S9.3,8,8.5,8S7,8.7,7,9.5C7,10.3,7.7,11,8.5,11z   M22,6v12c0,1.1-0.9,2-2,2H4c-1.1,0-2-0.9-2-2V6c0-1.1,0.9-2,2-2h16C21.1,4,22,4.9,22,6z M20,8.8V6H4v12h16V8.8z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Insert Image</span>
                                            </button>
                                            <button id="moreRich-1" data-group-name="moreRich-1" type="button" tabindex="-1" role="button" title="More Rich" class="fr-command fr-btn" data-cmd="moreRich">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M16.5,13h-6v6h-2V13h-6V11h6V5h2v6h6Zm5,4.5A1.5,1.5,0,1,1,20,16,1.5,1.5,0,0,1,21.5,17.5Zm0-4A1.5,1.5,0,1,1,20,12,1.5,1.5,0,0,1,21.5,13.5Zm0-4A1.5,1.5,0,1,1,20,8,1.5,1.5,0,0,1,21.5,9.5Z"></path>
                                                </svg>
                                                <span class="fr-sr-only">More Rich</span>
                                            </button>
                                        </div>
                                        <div class="fr-btn-grp fr-float-right">
                                            <button id="undo-1" type="button" tabindex="-1" role="button" aria-disabled="true" title="Undo (Ctrl+Z)" class="fr-command fr-btn fr-disabled" data-cmd="undo">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10.4,9.4c-1.7,0.3-3.2,0.9-4.6,2L3,8.5v7h7l-2.7-2.7c3.7-2.6,8.8-1.8,11.5,1.9c0.2,0.3,0.4,0.5,0.5,0.8l1.8-0.9  C18.9,10.8,14.7,8.7,10.4,9.4z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Undo</span>
                                            </button>
                                            <button id="redo-1" type="button" tabindex="-1" role="button" aria-disabled="true" title="Redo (Ctrl+Shift+Z)" class="fr-command fr-btn fr-disabled" data-cmd="redo">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M13.6,9.4c1.7,0.3,3.2,0.9,4.6,2L21,8.5v7h-7l2.7-2.7C13,10.1,7.9,11,5.3,14.7c-0.2,0.3-0.4,0.5-0.5,0.8L3,14.6  C5.1,10.8,9.3,8.7,13.6,9.4z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Redo</span>
                                            </button>
                                            <button id="moreMisc-1" data-group-name="moreMisc-1" type="button" tabindex="-1" role="button" title="More Misc" class="fr-command fr-btn" data-cmd="moreMisc">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M13.5,17c0,0.8-0.7,1.5-1.5,1.5s-1.5-0.7-1.5-1.5s0.7-1.5,1.5-1.5S13.5,16.2,13.5,17z M13.5,12c0,0.8-0.7,1.5-1.5,1.5 s-1.5-0.7-1.5-1.5s0.7-1.5,1.5-1.5S13.5,11.2,13.5,12z M13.5,7c0,0.8-0.7,1.5-1.5,1.5S10.5,7.8,10.5,7s0.7-1.5,1.5-1.5 S13.5,6.2,13.5,7z"></path>
                                                </svg>
                                                <span class="fr-sr-only">More Misc</span>
                                            </button>
                                        </div>
                                        <div class="fr-newline"></div>
                                        <div class="fr-more-toolbar position-relative" data-name="moreText-1">
                                            <button id="strikeThrough-1" type="button" tabindex="-1" role="button" aria-pressed="false" title="Strikethrough (Ctrl+S)" class="fr-command fr-btn" data-cmd="strikeThrough">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M3,12.20294H21v1.5H16.63422a3.59782,3.59782,0,0,1,.34942,1.5929,3.252,3.252,0,0,1-1.31427,2.6997A5.55082,5.55082,0,0,1,12.20251,19a6.4421,6.4421,0,0,1-2.62335-.539,4.46335,4.46335,0,0,1-1.89264-1.48816,3.668,3.668,0,0,1-.67016-2.15546V14.704h.28723v-.0011h.34149v.0011H9.02v.11334a2.18275,2.18275,0,0,0,.85413,1.83069,3.69,3.69,0,0,0,2.32836.67926,3.38778,3.38778,0,0,0,2.07666-.5462,1.73346,1.73346,0,0,0,.7013-1.46655,1.69749,1.69749,0,0,0-.647-1.43439,3.00525,3.00525,0,0,0-.27491-.17725H3ZM16.34473,7.05981A4.18163,4.18163,0,0,0,14.6236,5.5462,5.627,5.627,0,0,0,12.11072,5,5.16083,5.16083,0,0,0,8.74719,6.06213,3.36315,3.36315,0,0,0,7.44006,8.76855a3.22923,3.22923,0,0,0,.3216,1.42786h2.59668c-.08338-.05365-.18537-.10577-.25269-.16064a1.60652,1.60652,0,0,1-.65283-1.30036,1.79843,1.79843,0,0,1,.68842-1.5108,3.12971,3.12971,0,0,1,1.96948-.55243,3.04779,3.04779,0,0,1,2.106.6687,2.35066,2.35066,0,0,1,.736,1.83258v.11341h2.00317V9.17346A3.90013,3.90013,0,0,0,16.34473,7.05981Z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Strikethrough</span>
                                            </button>
                                            <button id="subscript-1" type="button" tabindex="-1" role="button" aria-pressed="false" title="Subscript" class="fr-command fr-btn" data-cmd="subscript">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10.4,12l3.6,3.6L12.6,17L9,13.4L5.4,17L4,15.6L7.6,12L4,8.4L5.4,7L9,10.6L12.6,7L14,8.4L10.4,12z M18.31234,19.674  l1.06812-1.1465c0.196-0.20141,0.37093-0.40739,0.5368-0.6088c0.15975-0.19418,0.30419-0.40046,0.432-0.617  c0.11969-0.20017,0.21776-0.41249,0.29255-0.6334c0.07103-0.21492,0.10703-0.43986,0.10662-0.66621  c0.00297-0.28137-0.04904-0.56062-0.1531-0.82206c-0.09855-0.24575-0.25264-0.46534-0.45022-0.6416  c-0.20984-0.18355-0.45523-0.32191-0.72089-0.40646c-0.63808-0.19005-1.3198-0.17443-1.94851,0.04465  c-0.28703,0.10845-0.54746,0.2772-0.76372,0.49487c-0.20881,0.20858-0.37069,0.45932-0.47483,0.73548  c-0.10002,0.26648-0.15276,0.54838-0.15585,0.833l-0.00364,0.237H17.617l0.00638-0.22692  c0.00158-0.12667,0.01966-0.25258,0.05377-0.37458c0.03337-0.10708,0.08655-0.20693,0.15679-0.29437  c0.07105-0.08037,0.15959-0.14335,0.25882-0.1841c0.22459-0.08899,0.47371-0.09417,0.7018-0.01458  c0.0822,0.03608,0.15559,0.08957,0.21509,0.15679c0.06076,0.07174,0.10745,0.15429,0.13761,0.24333  c0.03567,0.10824,0.05412,0.22141,0.05469,0.33538c-0.00111,0.08959-0.0118,0.17881-0.0319,0.26612  c-0.02913,0.10428-0.07076,0.20465-0.124,0.29893c-0.07733,0.13621-0.1654,0.26603-0.26338,0.38823  c-0.13438,0.17465-0.27767,0.34226-0.42929,0.50217l-2.15634,2.35315V21H21v-1.326H18.31234z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Subscript</span>
                                            </button>
                                            <button id="superscript-1" type="button" tabindex="-1" role="button" aria-pressed="false" title="Superscript" class="fr-command fr-btn" data-cmd="superscript">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10.4,12,14,15.6,12.6,17,9,13.4,5.4,17,4,15.6,7.6,12,4,8.4,5.4,7,9,10.6,12.6,7,14,8.4Zm8.91234-3.326,1.06812-1.1465c.196-.20141.37093-.40739.5368-.6088a4.85745,4.85745,0,0,0,.432-.617,3.29,3.29,0,0,0,.29255-.6334,2.11079,2.11079,0,0,0,.10662-.66621,2.16127,2.16127,0,0,0-.1531-.82206,1.7154,1.7154,0,0,0-.45022-.6416,2.03,2.03,0,0,0-.72089-.40646,3.17085,3.17085,0,0,0-1.94851.04465,2.14555,2.14555,0,0,0-.76372.49487,2.07379,2.07379,0,0,0-.47483.73548,2.446,2.446,0,0,0-.15585.833l-.00364.237H18.617L18.62338,5.25a1.45865,1.45865,0,0,1,.05377-.37458.89552.89552,0,0,1,.15679-.29437.70083.70083,0,0,1,.25882-.1841,1.00569,1.00569,0,0,1,.7018-.01458.62014.62014,0,0,1,.21509.15679.74752.74752,0,0,1,.13761.24333,1.08893,1.08893,0,0,1,.05469.33538,1.25556,1.25556,0,0,1-.0319.26612,1.34227,1.34227,0,0,1-.124.29893,2.94367,2.94367,0,0,1-.26338.38823,6.41629,6.41629,0,0,1-.42929.50217L17.19709,8.92642V10H22V8.674Z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Superscript</span>
                                            </button>
                                            <button id="fontFamily-1" type="button" tabindex="-1" role="button" aria-controls="dropdown-menu-fontFamily-1" aria-expanded="false" aria-haspopup="true" title="Font Family" class="fr-command fr-btn fr-dropdown fr-selection" data-cmd="fontFamily"><svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M16,19h2L13,5H11L6,19H8l1.43-4h5.14Zm-5.86-6L12,7.8,13.86,13Z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Font Family</span>
                                            </button>
                                            <div id="dropdown-menu-fontFamily-1" class="fr-dropdown-menu" role="listbox" aria-labelledby="fontFamily-1" aria-hidden="true">
                                                <div class="fr-dropdown-wrapper" role="presentation">
                                                    <div class="fr-dropdown-content" role="presentation">
                                                        <ul class="fr-dropdown-list" role="presentation">
                                                            <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="fontFamily" data-param1="Arial,Helvetica,sans-serif" style="font-family: Arial,Helvetica,sans-serif" title="Arial">Arial</a></li>
                                                            <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="fontFamily" data-param1="Georgia,serif" style="font-family: Georgia,serif" title="Georgia">Georgia</a></li>
                                                            <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="fontFamily" data-param1="Impact,Charcoal,sans-serif" style="font-family: Impact,Charcoal,sans-serif" title="Impact">Impact</a></li>
                                                            <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="fontFamily" data-param1="Tahoma,Geneva,sans-serif" style="font-family: Tahoma,Geneva,sans-serif" title="Tahoma">Tahoma</a></li>
                                                            <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="fontFamily" data-param1="Times New Roman,Times,serif,-webkit-standard" style="font-family: Times New Roman,Times,serif,-webkit-standard" title="Times New Roman">Times New Roman</a></li>
                                                            <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="fontFamily" data-param1="Verdana,Geneva,sans-serif" style="font-family: Verdana,Geneva,sans-serif" title="Verdana">Verdana</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <button id="fontSize-1" type="button" tabindex="-1" role="button" aria-controls="dropdown-menu-fontSize-1" aria-expanded="false" aria-haspopup="true" title="Font Size" class="fr-command fr-btn fr-dropdown fr-selection" data-cmd="fontSize">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M20.75,19h1.5l-3-10h-1.5l-3,10h1.5L17,16.5h3Zm-3.3-4,1.05-3.5L19.55,15Zm-5.7,4h2l-5-14h-2l-5,14h2l1.43-4h5.14ZM5.89,13,7.75,7.8,9.61,13Z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Font Size</span>
                                            </button>
                                            <div id="dropdown-menu-fontSize-1" class="fr-dropdown-menu" role="listbox" aria-labelledby="fontSize-1" aria-hidden="true">
                                                <div class="fr-dropdown-wrapper" role="presentation">
                                                    <div class="fr-dropdown-content" role="presentation">
                                                        <ul class="fr-dropdown-list" role="presentation">
                                                            <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="fontSize" data-param1="8px" title="8">8</a></li>
                                                            <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="fontSize" data-param1="9px" title="9">9</a></li>
                                                            <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="fontSize" data-param1="10px" title="10">10</a></li>
                                                            <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="fontSize" data-param1="11px" title="11">11</a></li>
                                                            <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="fontSize" data-param1="12px" title="12">12</a></li>
                                                            <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="fontSize" data-param1="14px" title="14">14</a></li>
                                                            <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="fontSize" data-param1="18px" title="18">18</a></li>
                                                            <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="fontSize" data-param1="24px" title="24">24</a></li>
                                                            <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="fontSize" data-param1="30px" title="30">30</a></li>
                                                            <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="fontSize" data-param1="36px" title="36">36</a></li>
                                                            <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="fontSize" data-param1="48px" title="48">48</a></li>
                                                            <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="fontSize" data-param1="60px" title="60">60</a></li>
                                                            <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="fontSize" data-param1="72px" title="72">72</a></li>
                                                            <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="fontSize" data-param1="96px" title="96">96</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <button id="textColor-1" type="button" tabindex="-1" role="button" title="Text Color" class="fr-command fr-btn" data-cmd="textColor" data-popup="true">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15.2,13.494s-3.6,3.9-3.6,6.3a3.65,3.65,0,0,0,7.3.1v-.1C18.9,17.394,15.2,13.494,15.2,13.494Zm-1.47-1.357.669-.724L12.1,5h-2l-5,14h2l1.43-4h2.943A24.426,24.426,0,0,1,13.726,12.137ZM11.1,7.8l1.86,5.2H9.244Z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Text Color</span>
                                            </button>
                                            <button id="backgroundColor-1" type="button" tabindex="-1" role="button" title="Background Color" class="fr-command fr-btn" data-cmd="backgroundColor" data-popup="true">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9.91752,12.24082l7.74791-5.39017,1.17942,1.29591-6.094,7.20747L9.91752,12.24082M7.58741,12.652l4.53533,4.98327a.93412.93412,0,0,0,1.39531-.0909L20.96943,8.7314A.90827.90827,0,0,0,20.99075,7.533l-2.513-2.76116a.90827.90827,0,0,0-1.19509-.09132L7.809,11.27135A.93412.93412,0,0,0,7.58741,12.652ZM2.7939,18.52772,8.41126,19.5l1.47913-1.34617-3.02889-3.328Z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Background Color</span>
                                            </button>
                                            <button id="inlineClass-1" type="button" tabindex="-1" role="button" aria-controls="dropdown-menu-inlineClass-1" aria-expanded="false" aria-haspopup="true" title="Inline Class" class="fr-command fr-btn fr-dropdown" data-cmd="inlineClass">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9.9,13.313A1.2,1.2,0,0,1,9.968,13H6.277l1.86-5.2,1.841,5.148A1.291,1.291,0,0,1,11.212,12h.426l-2.5-7h-2l-5,14h2l1.43-4H9.9Zm2.651,6.727a2.884,2.884,0,0,1-.655-2.018v-2.71A1.309,1.309,0,0,1,13.208,14h3.113a3.039,3.039,0,0,1,2,1.092s1.728,1.818,2.964,2.928a1.383,1.383,0,0,1,.318,1.931,1.44,1.44,0,0,1-.19.215l-3.347,3.31a1.309,1.309,0,0,1-1.832.258h0a1.282,1.282,0,0,1-.258-.257l-1.71-1.728Zm2.48-3.96a.773.773,0,1,0,.008,0Z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Inline Class</span>
                                            </button>
                                            <div id="dropdown-menu-inlineClass-1" class="fr-dropdown-menu" role="listbox" aria-labelledby="inlineClass-1" aria-hidden="true">
                                                <div class="fr-dropdown-wrapper" role="presentation">
                                                    <div class="fr-dropdown-content" role="presentation">
                                                        <ul class="fr-dropdown-list" role="presentation">
                                                            <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="inlineClass" data-param1="fr-class-code" title="Code">Code</a></li>
                                                            <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="inlineClass" data-param1="fr-class-highlighted" title="Highlighted">Highlighted</a></li>
                                                            <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="inlineClass" data-param1="fr-class-transparency" title="Transparent">Transparent</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <button id="inlineStyle-1" type="button" tabindex="-1" role="button" aria-controls="dropdown-menu-inlineStyle-1" aria-expanded="false" aria-haspopup="true" title="Inline Style" class="fr-command fr-btn fr-dropdown" data-cmd="inlineStyle">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.88,15h.7l.7-1.7-3-8.3h-2l-5,14h2l1.4-4Zm-4.4-2,1.9-5.2,1.9,5.2ZM15.4,21.545l3.246,1.949-.909-3.637L20.72,17H16.954l-1.429-3.506L13.837,17H10.071l2.857,2.857-.779,3.637Z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Inline Style</span>
                                            </button>
                                            <div id="dropdown-menu-inlineStyle-1" class="fr-dropdown-menu" role="listbox" aria-labelledby="inlineStyle-1" aria-hidden="true">
                                                <div class="fr-dropdown-wrapper" role="presentation">
                                                    <div class="fr-dropdown-content" role="presentation">
                                                        <ul class="fr-dropdown-list" role="presentation">
                                                            <li role="presentation">
                                                                <span style="font-size: 20px; color: red; display:block;" role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="inlineStyle" data-param1="font-size: 20px; color: red;" title="Big Red">Big Red</a></span>
                                                            </li>
                                                            <li role="presentation">
                                                                <span style="font-size: 14px; color: blue; display:block;" role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="inlineStyle" data-param1="font-size: 14px; color: blue;" title="Small Blue">Small Blue</a></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <button id="clearFormatting-1" type="button" tabindex="-1" role="button" title="Clear Formatting" class="fr-command fr-btn" data-cmd="clearFormatting">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.48,10.09l-1.2-1.21L8.8,7.41,6.43,5,5.37,6.1,8.25,9,4.66,19h2l1.43-4h5.14l1.43,4h2l-.89-2.51L18.27,19l1.07-1.06L14.59,13.2ZM8.8,13l.92-2.56L12.27,13Zm.56-7.15L9.66,5h2l1.75,4.9Z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Clear Formatting</span>
                                            </button>
                                        </div>
                                        <div class="fr-more-toolbar position-relative" data-name="moreParagraph-1">
                                            <button id="alignRight-1" type="button" tabindex="-1" role="button" title="Align Right" class="fr-command fr-btn" data-cmd="alignRight">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15,18h6v-2h-6V18z M9,11v2h12v-2H9z M3,6v2h18V6H3z"></path>
                                                </svg><span class="fr-sr-only">Align Right</span>
                                            </button>
                                            <button id="alignJustify-1" type="button" tabindex="-1" role="button" title="Align Justify" class="fr-command fr-btn" data-cmd="alignJustify">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M3,18h18v-2H3V18z M3,11v2h18v-2H3z M3,6v2h18V6H3z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Align Justify</span>
                                            </button>
                                            <div class="fr-btn-wrap">
                                                <button id="formatOL-1" type="button" tabindex="-1" role="button" title="Ordered List" class="fr-command fr-btn" data-cmd="formatOL">
                                                    <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M2.5,16h2v.5h-1v1h1V18h-2v1h3V15h-3Zm1-7h1V5h-2V6h1Zm-1,2H4.3L2.5,13.1V14h3V13H3.7l1.8-2.1V10h-3Zm5-5V8h14V6Zm0,12h14V16H7.5Zm0-5h14V11H7.5Z"></path>
                                                    </svg>
                                                    <span class="fr-sr-only">Ordered List</span>
                                                </button>
                                                <button id="formatOLOptions-1" type="button" tabindex="-1" role="button" aria-controls="dropdown-menu-formatOLOptions-1" aria-expanded="false" aria-haspopup="true" title="Ordered List" class="fr-command fr-btn fr-dropdown fr-options" data-cmd="formatOLOptions"></button>
                                                <div id="dropdown-menu-formatOLOptions-1" class="fr-dropdown-menu" role="listbox" aria-labelledby="formatOLOptions-1" aria-hidden="true">
                                                    <div class="fr-dropdown-wrapper" role="presentation">
                                                        <div class="fr-dropdown-content" role="presentation">
                                                            <ul class="fr-dropdown-list" role="presentation">
                                                                <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="formatOL" data-param1="default" title="Default">Default</a></li>
                                                                <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="formatOL" data-param1="lower-alpha" title="Lower Alpha">Lower Alpha</a></li>
                                                                <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="formatOL" data-param1="lower-greek" title="Lower Greek">Lower Greek</a></li>
                                                                <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="formatOL" data-param1="lower-roman" title="Lower Roman">Lower Roman</a></li>
                                                                <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="formatOL" data-param1="upper-alpha" title="Upper Alpha">Upper Alpha</a></li>
                                                                <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="formatOL" data-param1="upper-roman" title="Upper Roman">Upper Roman</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="fr-btn-wrap">
                                                <button id="formatUL-1" type="button" tabindex="-1" role="button" title="Unordered List" class="fr-command fr-btn" data-cmd="formatUL">
                                                    <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M4,10.5c-0.8,0-1.5,0.7-1.5,1.5s0.7,1.5,1.5,1.5s1.5-0.7,1.5-1.5S4.8,10.5,4,10.5z M4,5.5C3.2,5.5,2.5,6.2,2.5,7  S3.2,8.5,4,8.5S5.5,7.8,5.5,7S4.8,5.5,4,5.5z M4,15.5c-0.8,0-1.5,0.7-1.5,1.5s0.7,1.5,1.5,1.5s1.5-0.7,1.5-1.5S4.8,15.5,4,15.5z   M7.5,6v2h14V6H7.5z M7.5,18h14v-2h-14V18z M7.5,13h14v-2h-14V13z"></path>
                                                    </svg>
                                                    <span class="fr-sr-only">Unordered List</span>
                                                </button>
                                                <button id="formatULOptions-1" type="button" tabindex="-1" role="button" aria-controls="dropdown-menu-formatULOptions-1" aria-expanded="false" aria-haspopup="true" title="Unordered List" class="fr-command fr-btn fr-dropdown fr-options" data-cmd="formatULOptions"></button>
                                                <div id="dropdown-menu-formatULOptions-1" class="fr-dropdown-menu" role="listbox" aria-labelledby="formatULOptions-1" aria-hidden="true">
                                                    <div class="fr-dropdown-wrapper" role="presentation">
                                                        <div class="fr-dropdown-content" role="presentation">
                                                            <ul class="fr-dropdown-list" role="presentation">
                                                                <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="formatUL" data-param1="default" title="Default">Default</a></li>
                                                                <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="formatUL" data-param1="circle" title="Circle">Circle</a></li>
                                                                <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="formatUL" data-param1="disc" title="Disc">Disc</a></li>
                                                                <li role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="formatUL" data-param1="square" title="Square">Square</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button id="paragraphFormat-1" type="button" tabindex="-1" role="button" aria-controls="dropdown-menu-paragraphFormat-1" aria-expanded="false" aria-haspopup="true" title="Paragraph Format" class="fr-command fr-btn fr-dropdown fr-selection" data-cmd="paragraphFormat">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10.15,5A4.11,4.11,0,0,0,6.08,8.18,4,4,0,0,0,10,13v6h2V7h2V19h2V7h2V5ZM8,9a2,2,0,0,1,2-2v4A2,2,0,0,1,8,9Z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Paragraph Format</span>
                                            </button>
                                            <div id="dropdown-menu-paragraphFormat-1" class="fr-dropdown-menu" role="listbox" aria-labelledby="paragraphFormat-1" aria-hidden="true">
                                                <div class="fr-dropdown-wrapper" role="presentation">
                                                    <div class="fr-dropdown-content" role="presentation">
                                                        <ul class="fr-dropdown-list" role="presentation">
                                                            <li role="presentation"><p style="padding: 0 !important; margin: 0 !important; border: 0 !important; background-color: transparent !important; font-size: 15px" role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="paragraphFormat" data-param1="N" title="Normal">Normal</a></p></li>
                                                            <li role="presentation">
                                                                <h1 style="padding: 0 !important; margin: 0 !important; border: 0 !important; background-color: transparent !important; font-weight: bold !important; font-size: 2em !important; " role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="paragraphFormat" data-param1="H1" title="Heading 1">Heading 1</a></h1>
                                                            </li>
                                                            <li role="presentation">
                                                                <h2 style="padding: 0 !important; margin: 0 !important; border: 0 !important; background-color: transparent !important; font-weight: bold !important; font-size: 1.5em !important; " role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="paragraphFormat" data-param1="H2" title="Heading 2">Heading 2</a></h2>
                                                            </li>
                                                            <li role="presentation">
                                                                <h3 style="padding: 0 !important; margin: 0 !important; border: 0 !important; background-color: transparent !important; font-weight: bold !important; font-size: 1.17em !important; " role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="paragraphFormat" data-param1="H3" title="Heading 3">Heading 3</a></h3>
                                                            </li>
                                                            <li role="presentation">
                                                                <h4 style="padding: 0 !important; margin: 0 !important; border: 0 !important; background-color: transparent !important; font-weight: bold !important; font-size: 15px !important;" role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="paragraphFormat" data-param1="H4" title="Heading 4">Heading 4</a></h4>
                                                            </li>
                                                            <li role="presentation">
                                                                <pre style="padding: 0 !important; margin: 0 !important; border: 0 !important; background-color: transparent !important; font-size: 15px" role="presentation"><a class="fr-command" tabindex="-1" role="option" data-cmd="paragraphFormat" data-param1="PRE" title="Code">Code</a></pre>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <button id="paragraphStyle-1" type="button" tabindex="-1" role="button" aria-controls="dropdown-menu-paragraphStyle-1" aria-expanded="false" aria-haspopup="true" title="Paragraph Style" class="fr-command fr-btn fr-dropdown" data-cmd="paragraphStyle">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4,9c0-1.1,0.9-2,2-2v4C4.9,11,4,10.1,4,9z M16.7,20.5l3.2,1.9L19,18.8l3-2.9h-3.7l-1.4-3.5L15.3,16h-3.8l2.9,2.9l-0.9,3.6  L16.7,20.5z M10,17.4V19h1.6L10,17.4z M6.1,5c-1.9,0-3.6,1.3-4,3.2c-0.5,2.1,0.8,4.2,2.9,4.7c0,0,0,0,0,0h0.2C5.5,13,5.8,13,6,13v6  h2V7h2v7h2V7h2V5H6.1z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Paragraph Style</span>
                                            </button>
                                            <div id="dropdown-menu-paragraphStyle-1" class="fr-dropdown-menu" role="listbox" aria-labelledby="paragraphStyle-1" aria-hidden="true">
                                                <div class="fr-dropdown-wrapper" role="presentation">
                                                    <div class="fr-dropdown-content" role="presentation">
                                                        <ul class="fr-dropdown-list" role="presentation">
                                                            <li role="presentation"><a class="fr-command fr-text-gray" tabindex="-1" role="option" data-cmd="paragraphStyle" data-param1="fr-text-gray" title="Gray">Gray</a></li>
                                                            <li role="presentation"><a class="fr-command fr-text-bordered" tabindex="-1" role="option" data-cmd="paragraphStyle" data-param1="fr-text-bordered" title="Bordered">Bordered</a></li>
                                                            <li role="presentation"><a class="fr-command fr-text-spaced" tabindex="-1" role="option" data-cmd="paragraphStyle" data-param1="fr-text-spaced" title="Spaced">Spaced</a></li>
                                                            <li role="presentation"><a class="fr-command fr-text-uppercase" tabindex="-1" role="option" data-cmd="paragraphStyle" data-param1="fr-text-uppercase" title="Uppercase">Uppercase</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <button id="lineHeight-1" type="button" tabindex="-1" role="button" aria-controls="dropdown-menu-lineHeight-1" aria-expanded="false" aria-haspopup="true" title="Line Height" class="fr-command fr-btn fr-dropdown" data-cmd="lineHeight">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6.25,7h2.5L5.25,3.5,1.75,7h2.5V17H1.75l3.5,3.5L8.75,17H6.25Zm4-2V7h12V5Zm0,14h12V17h-12Zm0-6h12V11h-12Z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Line Height</span>
                                            </button>
                                            <div id="dropdown-menu-lineHeight-1" class="fr-dropdown-menu" role="listbox" aria-labelledby="lineHeight-1" aria-hidden="true">
                                                <div class="fr-dropdown-wrapper" role="presentation">
                                                    <div class="fr-dropdown-content" role="presentation">
                                                        <ul class="fr-dropdown-list" role="presentation">
                                                            <li role="presentation"><a class="fr-command Default" tabindex="-1" role="option" data-cmd="lineHeight" data-param1="" title="Default">Default</a></li>
                                                            <li role="presentation"><a class="fr-command Single" tabindex="-1" role="option" data-cmd="lineHeight" data-param1="1" title="Single">Single</a></li>
                                                            <li role="presentation"><a class="fr-command 1.15" tabindex="-1" role="option" data-cmd="lineHeight" data-param1="1.15" title="1.15">1.15</a></li>
                                                            <li role="presentation"><a class="fr-command 1.5" tabindex="-1" role="option" data-cmd="lineHeight" data-param1="1.5" title="1.5">1.5</a></li>
                                                            <li role="presentation"><a class="fr-command Double" tabindex="-1" role="option" data-cmd="lineHeight" data-param1="2" title="Double">Double</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <button id="outdent-1" type="button" tabindex="-1" role="button" title="Decrease Indent (Ctrl+[)" class="fr-command fr-btn" data-cmd="outdent">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M3,12l3,3V9L3,12z M3,19h18v-2H3V19z M3,7h18V5H3V7z M9,11h12V9H9V11z M9,15h12v-2H9V15z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Decrease Indent</span>
                                            </button>
                                            <button id="indent-1" type="button" tabindex="-1" role="button" title="Increase Indent (Ctrl+])" class="fr-command fr-btn" data-cmd="indent">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M3,9v6l3-3L3,9z M3,19h18v-2H3V19z M3,7h18V5H3V7z M9,11h12V9H9V11z M9,15h12v-2H9V15z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Increase Indent</span>
                                            </button>
                                            <button id="quote-1" type="button" tabindex="-1" role="button" aria-controls="dropdown-menu-quote-1" aria-expanded="false" aria-haspopup="true" title="Quote" class="fr-command fr-btn fr-dropdown" data-cmd="quote">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10.31788,5l.93817,1.3226A12.88271,12.88271,0,0,0,8.1653,9.40125a5.54242,5.54242,0,0,0-.998,3.07866v.33733q.36089-.04773.66067-.084a4.75723,4.75723,0,0,1,.56519-.03691,2.87044,2.87044,0,0,1,2.11693.8427,2.8416,2.8416,0,0,1,.8427,2.09274,3.37183,3.37183,0,0,1-.8898,2.453A3.143,3.143,0,0,1,8.10547,19,3.40532,3.40532,0,0,1,5.375,17.7245,4.91156,4.91156,0,0,1,4.30442,14.453,9.3672,9.3672,0,0,1,5.82051,9.32933,14.75716,14.75716,0,0,1,10.31788,5Zm8.39243,0,.9369,1.3226a12.88289,12.88289,0,0,0-3.09075,3.07865,5.54241,5.54241,0,0,0-.998,3.07866v.33733q.33606-.04773.63775-.084a4.91773,4.91773,0,0,1,.58938-.03691,2.8043,2.8043,0,0,1,2.1042.83,2.89952,2.89952,0,0,1,.80578,2.10547,3.42336,3.42336,0,0,1-.86561,2.453A3.06291,3.06291,0,0,1,16.49664,19,3.47924,3.47924,0,0,1,13.742,17.7245,4.846,4.846,0,0,1,12.64721,14.453,9.25867,9.25867,0,0,1,14.17476,9.3898,15.26076,15.26076,0,0,1,18.71031,5Z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Quote</span>
                                            </button>
                                            <div id="dropdown-menu-quote-1" class="fr-dropdown-menu" role="listbox" aria-labelledby="quote-1" aria-hidden="true">
                                                <div class="fr-dropdown-wrapper" role="presentation">
                                                    <div class="fr-dropdown-content" role="presentation">
                                                        <ul class="fr-dropdown-list" role="presentation">
                                                            <li role="presentation"><a class="fr-command fr-active increase" tabindex="-1" role="option" data-cmd="quote" data-param1="increase" title="Increase">Increase<span class="fr-shortcut">Ctrl+'</span></a></li>
                                                            <li role="presentation"><a class="fr-command fr-active decrease" tabindex="-1" role="option" data-cmd="quote" data-param1="decrease" title="Decrease">Decrease<span class="fr-shortcut">Ctrl+Shift+'</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="fr-more-toolbar position-relative" data-name="moreRich-1">
                                            <button id="insertVideo-1" type="button" tabindex="-1" role="button" title="Insert Video" class="fr-command fr-btn" data-cmd="insertVideo" data-popup="true">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15,8v8H5V8H15m2,2.5V7a1,1,0,0,0-1-1H4A1,1,0,0,0,3,7V17a1,1,0,0,0,1,1H16a1,1,0,0,0,1-1V13.5l2.29,2.29A1,1,0,0,0,21,15.08V8.91a1,1,0,0,0-1.71-.71Z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Insert Video</span>
                                            </button>
                                            <button id="insertTable-1" type="button" tabindex="-1" role="button" title="Insert Table" class="fr-command fr-btn" data-cmd="insertTable" data-popup="true">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M20,5H4C2.9,5,2,5.9,2,7v2v1.5v3V15v2c0,1.1,0.9,2,2,2h16c1.1,0,2-0.9,2-2v-2v-1.5v-3V9V7C22,5.9,21.1,5,20,5z M9.5,13.5v-3  h5v3H9.5z M14.5,15v2.5h-5V15H14.5z M9.5,9V6.5h5V9H9.5z M3.5,7c0-0.3,0.2-0.5,0.5-0.5h4V9H3.5V7z M3.5,10.5H8v3H3.5V10.5z M3.5,17  v-2H8v2.5H4C3.7,17.5,3.5,17.3,3.5,17z M20.5,17c0,0.3-0.2,0.5-0.5,0.5h-4V15h4.5V17z M20.5,13.5H16v-3h4.5V13.5z M16,9V6.5h4  c0.3,0,0.5,0.2,0.5,0.5v2H16z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Insert Table</span>
                                            </button>
                                            <button id="emoticons-1" type="button" tabindex="-1" role="button" title="Emoticons" class="fr-command fr-btn" data-cmd="emoticons" data-popup="true">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.991,3A9,9,0,1,0,21,12,8.99557,8.99557,0,0,0,11.991,3ZM12,19a7,7,0,1,1,7-7A6.99808,6.99808,0,0,1,12,19Zm3.105-5.2h1.503a4.94542,4.94542,0,0,1-9.216,0H8.895a3.57808,3.57808,0,0,0,6.21,0ZM7.5,9.75A1.35,1.35,0,1,1,8.85,11.1,1.35,1.35,0,0,1,7.5,9.75Zm6.3,0a1.35,1.35,0,1,1,1.35,1.35A1.35,1.35,0,0,1,13.8,9.75Z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Emoticons</span>
                                            </button>
                                            <button id="specialCharacters-1" type="button" tabindex="-1" role="button" title="Special Characters" class="fr-command fr-btn" data-cmd="specialCharacters" data-popup="true">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15.77493,16.98885a8.21343,8.21343,0,0,0,1.96753-2.57651,7.34824,7.34824,0,0,0,.6034-3.07618A6.09092,6.09092,0,0,0,11.99515,5a6.13347,6.13347,0,0,0-4.585,1.79187,6.417,6.417,0,0,0-1.756,4.69207,6.93955,6.93955,0,0,0,.622,2.97415,8.06587,8.06587,0,0,0,1.949,2.53076H5.41452V19h5.54114v-.04331h-.00147V16.84107a5.82825,5.82825,0,0,1-2.2052-2.2352A6.40513,6.40513,0,0,1,7.97672,11.447,4.68548,4.68548,0,0,1,9.07785,8.19191a3.73232,3.73232,0,0,1,2.9173-1.22462,3.76839,3.76839,0,0,1,2.91241,1.21489,4.482,4.482,0,0,1,1.11572,3.154,6.71141,6.71141,0,0,1-.75384,3.24732,5.83562,5.83562,0,0,1-2.22357,2.25759v2.11562H13.0444V19h5.54108V16.98885Z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Special Characters</span>
                                            </button>
                                            <button id="insertFile-1" type="button" tabindex="-1" role="button" title="Upload File" class="fr-command fr-btn" data-cmd="insertFile" data-popup="true">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M7,3C5.9,3,5,3.9,5,5v14c0,1.1,0.9,2,2,2h10c1.1,0,2-0.9,2-2V7.6L14.4,3H7z M17,19H7V5h6v4h4V19z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Upload File</span>
                                            </button>
                                            <button id="insertHR-1" type="button" tabindex="-1" role="button" title="Insert Horizontal Line" class="fr-command fr-btn" data-cmd="insertHR">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5,12h14 M19,11H5v2h14V11z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Insert Horizontal Line</span>
                                            </button>
                                        </div>
                                        <div class="fr-more-toolbar position-relative" data-name="moreMisc-1">
                                            <button id="fullscreen-1" type="button" tabindex="-1" role="button" aria-pressed="false" title="Fullscreen" class="fr-command fr-btn" data-cmd="fullscreen">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M7,14H5v5h5V17H7ZM5,10H7V7h3V5H5Zm12,7H14v2h5V14H17ZM14,5V7h3v3h2V5Z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Fullscreen</span>
                                            </button>
                                            <button id="print-1" type="button" tabindex="-1" role="button" title="Print" class="fr-command fr-btn" data-cmd="print">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M16.1,17c0-0.6,0.4-1,1-1c0.6,0,1,0.4,1,1s-0.4,1-1,1C16.5,18,16.1,17.6,16.1,17z M22,15v4c0,1.1-0.9,2-2,2H4  c-1.1,0-2-0.9-2-2v-4c0-1.1,0.9-2,2-2h1V5c0-1.1,0.9-2,2-2h7.4L19,7.6V13h1C21.1,13,22,13.9,22,15z M7,13h10V9h-4V5H7V13z M20,15H4  v4h16V15z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Print</span>
                                            </button>
                                            <button id="getPDF-1" type="button" tabindex="-1" role="button" title="Download PDF" class="fr-command fr-btn" data-cmd="getPDF">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M7,3C5.9,3,5,3.9,5,5v14c0,1.1,0.9,2,2,2h10c1.1,0,2-0.9,2-2V7.6L14.4,3H7z M17,19H7V5h6v4h4V19z M16.3,13.5  c-0.2-0.6-1.1-0.8-2.6-0.8c-0.1,0-0.1,0-0.2,0c-0.3-0.3-0.8-0.9-1-1.2c-0.2-0.2-0.3-0.3-0.4-0.6c0.2-0.7,0.2-1,0.3-1.5  c0.1-0.9,0-1.6-0.2-1.8c-0.4-0.2-0.7-0.2-0.9-0.2c-0.1,0-0.3,0.2-0.7,0.7c-0.2,0.7-0.1,1.8,0.6,2.8c-0.2,0.8-0.7,1.6-1,2.4  c-0.8,0.2-1.5,0.7-1.9,1.1c-0.7,0.7-0.9,1.1-0.7,1.6c0,0.3,0.2,0.6,0.7,0.6c0.3-0.1,0.3-0.2,0.7-0.3c0.6-0.3,1.2-1.7,1.7-2.4  c0.8-0.2,1.7-0.3,2-0.3c0.1,0,0.3,0,0.6,0c0.8,0.8,1.2,1.1,1.8,1.2c0.1,0,0.2,0,0.3,0c0.3,0,0.8-0.1,1-0.6  C16.4,14.1,16.4,13.9,16.3,13.5z M8.3,15.7c-0.1,0.1-0.2,0.1-0.2,0.1c0-0.1,0-0.3,0.6-0.8c0.2-0.2,0.6-0.3,0.9-0.7  C9,15,8.6,15.5,8.3,15.7z M11.3,9c0-0.1,0.1-0.2,0.1-0.2S11.6,9,11.5,10c0,0.1,0,0.3-0.1,0.7C11.3,10.1,11,9.5,11.3,9z M10.9,13.1  c0.2-0.6,0.6-1,0.7-1.5c0.1,0.1,0.1,0.1,0.2,0.2c0.1,0.2,0.3,0.7,0.7,0.9C12.2,12.8,11.6,13,10.9,13.1z M15.2,14.1  c-0.1,0-0.1,0-0.2,0c-0.2,0-0.7-0.2-1-0.7c1.1,0,1.6,0.2,1.6,0.6C15.5,14.1,15.4,14.1,15.2,14.1z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Download PDF</span>
                                            </button>
                                            <button id="selectAll-1" type="button" tabindex="-1" role="button" title="Select All" class="fr-command fr-btn" data-cmd="selectAll">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5,7h2V5C5.9,5,5,5.9,5,7z M5,11h2V9H5V11z M9,19h2v-2H9V19z M5,11h2V9H5V11z M15,5h-2v2h2V5z M17,5v2h2C19,5.9,18.1,5,17,5  z M7,19v-2H5C5,18.1,5.9,19,7,19z M5,15h2v-2H5V15z M11,5H9v2h2V5z M13,19h2v-2h-2V19z M17,11h2V9h-2V11z M17,19c1.1,0,2-0.9,2-2h-2  V19z M17,11h2V9h-2V11z M17,15h2v-2h-2V15z M13,19h2v-2h-2V19z M13,7h2V5h-2V7z M9,15h6V9H9V15z M11,11h2v2h-2V11z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Select All</span>
                                            </button>
                                            <button id="html-1" type="button" tabindex="-1" role="button" aria-pressed="false" title="Code View" class="fr-command fr-btn" data-cmd="html">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9.4,16.6,4.8,12,9.4,7.4,8,6,2,12l6,6Zm5.2,0L19.2,12,14.6,7.4,16,6l6,6-6,6Z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Code View</span>
                                            </button>
                                            <button id="help-1" type="button" tabindex="-1" role="button" title="Help (Ctrl+/)" class="fr-command fr-btn" data-cmd="help" data-modal="true">
                                                <svg class="fr-svg" focusable="false" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11,17h2v2h-2V17z M12,5C9.8,5,8,6.8,8,9h2c0-1.1,0.9-2,2-2s2,0.9,2,2c0,2-3,1.7-3,5v1h2v-1c0-2.2,3-2.5,3-5  C16,6.8,14.2,5,12,5z"></path>
                                                </svg>
                                                <span class="fr-sr-only">Help</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="fr-sticky-dummy" style="height: 50px;"></div>
                                    <div class="fr-wrapper show-placeholder" dir="auto" style="height: 300px; overflow: auto;">
                                        <div class="fr-element fr-view fr-element-scroll-visible" dir="auto" contenteditable="true" style="min-height: 300px;" aria-disabled="false" spellcheck="true">
                                            <p style=""><br style=""></p>
                                        </div>
                                        <span class="fr-placeholder" style="font-size: 14px; line-height: 22.4px; margin-top: 0px; padding-top: 20px; padding-left: 20px; margin-left: 0px; padding-right: 20px; margin-right: 0px; text-align: left;">Type something</span>
                                    </div>
                                    <div class="fr-second-toolbar"><a id="fr-logo" href="https://froala.com/wysiwyg-editor" target="_blank" title="Froala WYSIWYG HTML Editor">
                                        <span>Powered by</span>
                                        <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 822.8 355.33">
                                            <defs><style>.fr-logo{fill:#b1b2b7;}</style></defs>
                                            <title>Froala</title>
                                            <path class="fr-logo" d="M123.58,78.65A16.16,16.16,0,0,0,111.13,73H16.6C7.6,73,0,80.78,0,89.94V128.3a16.45,16.45,0,0,0,32.9,0V104.14h78.5A15.63,15.63,0,0,0,126.87,91.2,15.14,15.14,0,0,0,123.58,78.65Z"></path>
                                            <path class="fr-logo" d="M103.54,170a16.05,16.05,0,0,0-11.44-4.85H15.79A15.81,15.81,0,0,0,0,180.93v88.69a16.88,16.88,0,0,0,5,11.92,16,16,0,0,0,11.35,4.7h.17a16.45,16.45,0,0,0,16.41-16.6v-73.4H92.2A15.61,15.61,0,0,0,107.89,181,15.1,15.1,0,0,0,103.54,170Z"></path><path class="fr-logo" d="M233,144.17c-5.29-6.22-16-7.52-24.14-7.52-16.68,0-28.72,7.71-36.5,23.47v-5.67a16.15,16.15,0,1,0-32.3,0v115.5a16.15,16.15,0,1,0,32.3,0v-38.7c0-19.09,3.5-63.5,35.9-63.5a44.73,44.73,0,0,1,5.95.27h.12c12.79,1.2,20.06-2.73,21.6-11.69C236.76,151.48,235.78,147.39,233,144.17Z"></path>
                                            <path class="fr-logo" d="M371.83,157c-13.93-13.11-32.9-20.33-53.43-20.33S279,143.86,265.12,157c-14.67,13.88-22.42,32.82-22.42,54.77,0,21.68,8,41.28,22.4,55.2,13.92,13.41,32.85,20.8,53.3,20.8s39.44-7.38,53.44-20.79c14.55-13.94,22.56-33.54,22.56-55.21S386.39,170.67,371.83,157Zm-9.73,54.77c0,25.84-18.38,44.6-43.7,44.6s-43.7-18.76-43.7-44.6c0-25.15,18.38-43.4,43.7-43.4S362.1,186.59,362.1,211.74Z"></path><path class="fr-logo" d="M552.7,138.14a16.17,16.17,0,0,0-16,16.3v1C526.41,143.85,509,136.64,490,136.64c-19.83,0-38.19,7.24-51.69,20.4C424,171,416.4,190,416.4,212c0,21.61,7.78,41.16,21.9,55,13.56,13.33,31.92,20.67,51.7,20.67,18.83,0,36.29-7.41,46.7-19.37v1.57a16.15,16.15,0,1,0,32.3,0V154.44A16.32,16.32,0,0,0,552.7,138.14Zm-16.3,73.6c0,30.44-22.81,44.3-44,44.3-24.57,0-43.1-19-43.1-44.3s18.13-43.4,43.1-43.4C513.73,168.34,536.4,183.55,536.4,211.74Z"></path>
                                            <path class="fr-logo" d="M623.5,61.94a16.17,16.17,0,0,0-16,16.3v191.7a16.15,16.15,0,1,0,32.3,0V78.24A16.32,16.32,0,0,0,623.5,61.94Z"></path>
                                            <path class="fr-logo" d="M806.5,138.14a16.17,16.17,0,0,0-16,16.3v1c-10.29-11.63-27.74-18.84-46.7-18.84-19.83,0-38.19,7.24-51.69,20.4-14.33,14-21.91,33-21.91,55,0,21.61,7.78,41.16,21.9,55,13.56,13.33,31.92,20.67,51.7,20.67,18.83,0,36.29-7.41,46.7-19.37v1.57a16.15,16.15,0,1,0,32.3,0V154.44A16.32,16.32,0,0,0,806.5,138.14Zm-16.3,73.6c0,30.44-22.81,44.3-44,44.3-24.57,0-43.1-19-43.1-44.3s18.13-43.4,43.1-43.4C767.53,168.34,790.2,183.55,790.2,211.74Z"></path>
                                        </svg></a>
                                        <span class="fr-counter" style="bottom: 0.666667px; margin-right: 1px;">Characters : 0</span>
                                    </div>
                                </div>
                                --}}
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
                    {{--
                    <div class="flex gap-3 border-t py-5">
                        <div class="w-[190px] shrink-0 mt-2">
                            <p>옵션 1</p>
                            <!-- 버튼 클릭 시 옵션 삭제 -->
                            <button class="text-stone-400 underline mt-2" onclick="modalOpen('#del_con_modal')">삭제</button>
                        </div>
                        <div class="w-full">
                            <div class="radio_btn flex items-center border-b pb-5">
                                <p class="essential w-[130px] shrink-0">필수옵션</p>
                                <div>
                                    <input type="radio" name="price_exposure17" id="price_exposure14" checked="">
                                    <label for="price_exposure14" class="w-[140px] h-[48px] flex items-center justify-center">설정</label>
                                </div>
                                <div style="margin-left:-1px;">
                                    <input type="radio" name="price_exposure17" id="price_exposure15">
                                    <label for="price_exposure15" class="w-[140px] h-[48px] flex items-center justify-center">설정안함</label>
                                </div>
                            </div>

                            <div class="flex items-center mt-3 ">
                                <p class="essential w-[130px] shrink-0">옵션명</p>
                                <input type="text" class="setting_input h-[48px] w-[340px]" placeholder="예시)색상">
                            </div>

                            <div class="flex items-center mt-3">
                                <p class="essential w-[130px] shrink-0">옵션값</p>
                                <input type="text" class="setting_input h-[48px] w-[340px]" placeholder="예시)색상">
                                <div class="setting_input w-[223px] h-[48px] relative overflow-hidden ml-2">
                                    <input type="text" class="text-right w-full h-full pr-10">
                                    <p class="flex flex-wrap items-center justify-center absolute w-[48px] h-[48px] top-0 right-0 bg-stone-100 text-center text-stone-500">
                                        환
                                    </p>
                                </div>
                                <button class="flex flex-wrap items-center justify-center w-[48px] h-[48px] top-0 right-0 bg-stone-100 text-center text-stone-500 rounded-md border ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus text-stone-800"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- 옵션 추가 버튼 클릭 시 생성 -->
                    <div class="flex gap-3 border-t py-5">
                        <div class="w-[190px] shrink-0 mt-2">
                            <p>옵션 2</p>
                            <!-- 버튼 클릭 시 옵션 삭제 -->
                            <button class="text-stone-400 underline mt-2" onclick="modalOpen('#del_con_modal')">삭제</button>
                        </div>
                        <div class="w-full">
                            <div class="radio_btn flex items-center border-b pb-5">
                                <p class="essential w-[130px] shrink-0">필수옵션</p>
                                <div>
                                    <input type="radio" name="price_exposure18" id="price_exposure16" checked>
                                    <label for="price_exposure16" class="w-[140px] h-[48px] flex items-center justify-center">설정</label>
                                </div>
                                <div style="margin-left:-1px;">
                                    <input type="radio" name="price_exposure18" id="price_exposure17" >
                                    <label for="price_exposure17" class="w-[140px] h-[48px] flex items-center justify-center">설정안함</label>
                                </div>
                            </div>

                            <div class="flex items-center mt-3 ">
                                <p class="essential w-[130px] shrink-0">옵션명</p>
                                <input type="text" class="setting_input h-[48px] w-[340px]" placeholder="예시)색상">
                            </div>

                            <div class="flex items-center mt-3">
                                <p class="essential w-[130px] shrink-0">옵션값</p>
                                <input type="text" class="setting_input h-[48px] w-[340px]" placeholder="예시)색상">
                                <div class="setting_input w-[223px] h-[48px] relative overflow-hidden ml-2">
                                    <input type="text" class="text-right w-full h-full pr-10">
                                    <p class="flex flex-wrap items-center justify-center absolute w-[48px] h-[48px] top-0 right-0 bg-stone-100 text-center text-stone-500">
                                        환
                                    </p>
                                </div>
                                <button class="flex flex-wrap items-center justify-center w-[48px] h-[48px] top-0 right-0 bg-stone-100 text-center text-stone-500 rounded-md border ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-stone-600"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                </button>
                            </div>
                            <!-- +버튼 누를 시 생성 -->
                            <div class="flex items-center mt-3">
                                <p class="essential w-[130px] shrink-0">옵션값</p>
                                <input type="text" class="setting_input h-[48px] w-[340px]" placeholder="예시)색상">
                                <div class="setting_input w-[223px] h-[48px] relative overflow-hidden ml-2">
                                    <input type="text" class="text-right w-full h-full pr-10">
                                    <p class="flex flex-wrap items-center justify-center absolute w-[48px] h-[48px] top-0 right-0 bg-stone-100 text-center text-stone-500">
                                        환
                                    </p>
                                </div>
                                <button class="flex flex-wrap items-center justify-center w-[48px] h-[48px] top-0 right-0 bg-stone-100 text-center text-stone-500 rounded-md border ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus text-stone-600"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                </button>
                                <button class="flex flex-wrap items-center justify-center w-[48px] h-[48px] top-0 right-0 bg-stone-100 text-center text-stone-500 rounded-md border ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus text-stone-600"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                </button>
                            </div>

                        </div>
                    </div>
                    --}}
                </div>

                <div class="border-b-2 border-stone-900 mt-10 pb-5 mb-5">
                    <div class="flex items-center justify-between">
                        <h3 class="font-medium text-lg">상품 주문 정보</h3>
                        <div class="flex items-center gap-2 font-medium hidden">
                            <button class="h-[48px] w-[160px] rounded-md border border-stone-700 hover:bg-stone-100" onclick="modalOpen('#certification_information_modal')">주문 정보 불러오기</button>
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
                        <div class="guide_area mt-3 hidden">
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
                        <div class="guide_area mt-3 hidden">
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
                        <div class="guide_area mt-3 hidden">
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
                        <div class="guide_area mt-3 hidden">
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



        <!-- 상품등록 상품속성 모달-->
        <div class="modal" id="product_attributes_modal">
            <div class="modal_bg" onclick="modalClose('#product_attributes_modal')"></div>
            <div class="modal_inner modal-md" style="width:500px;">
                <div class="modal_body filter_body">
                    <div class="py-2">
                        <p class="text-lg font-bold text-left">사이즈</p>
                        <ul class="filter_list">
                            <li>
                                <input type="checkbox" class="check-form" id="filter_cate_2_01">
                                <label for="filter_cate_2_01">싱글</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="filter_cate_2_02">
                                <label for="filter_cate_2_02">슈퍼싱글</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="filter_cate_2_03">
                                <label for="filter_cate_2_03">더블</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="filter_cate_2_04">
                                <label for="filter_cate_2_04">퀸</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="filter_cate_2_05">
                                <label for="filter_cate_2_05">킹</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="filter_cate_2_06">
                                <label for="filter_cate_2_06">라지킹</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="filter_cate_2_07">
                                <label for="filter_cate_2_07">패밀리</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="filter_cate_2_08">
                                <label for="filter_cate_2_08">기타</label>
                            </li>
                        </ul>
                        <div class="btn_bot">
                            <button class="btn btn-line3 refresh_btn" onclick="refreshHandle(this)"><svg><use xlink:href="./img/icon-defs.svg#refresh"></use></svg>초기화</button>
                            <button class="btn btn-primary">선택 완료</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 배송방법 추가 모달 -->
        <div class="modal" id="shipping_method_modal">
            <div class="modal_bg" onclick="modalClose('#shipping_method_modal')"></div>
            <div class="modal_inner modal-md" style="width:500px;">
                <div class="modal_body filter_body">
                    <div class="py-2">
                        <p class="text-lg font-bold text-left">배송방법 추가</p>
                        <div class="stting_wrap">
                            <div class="mb-5 pb-5">
                                <dl class="flex flex-col">
                                    <dt class="essential w-[190px] shrink-0 mt-8">배송 방법</dt>

                                    <dd class="font-medium w-full mt-3">
                                        <div>
                                            <a href="javascript:;" class="h-[48px] px-3 border rounded-md inline-block filter_border filter_dropdown w-[full] flex justify-between items-center">
                                                <p>소비자 직배 가능</p>
                                                <svg class="w-6 h-6 filter_arrow"><use xlink:href="./img/icon-defs.svg#drop_b_arrow"></use></svg>
                                            </a>
                                            <div class="filter_dropdown_wrap w-[456px]" style="display: none;">
                                                <ul>
                                                    <li>
                                                        <a href="javascript:;" class="flex items-center" data-target="direct_input_2">직접 입력</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;" class="flex items-center">소비자 직배 가능</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;" class="flex items-center">매장 배송</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="direct_input_2 font-medium w-full mt-3 hidden" style="display: none;">
                                            <input type="text" class="setting_input h-[48px] w-full" placeholder="배송 방법을 입력해 주세요.">
                                        </div>
                                        <p class="mt-5">위 배송 방법의 가격을 선택해주세요</p>
                                        <div>
                                            <a href="javascript:;" class="h-[48px] px-3 border rounded-md inline-block filter_border filter_dropdown w-[full] flex justify-between items-center mt-3">
                                                <p>배송가격을 선택해주세요</p>
                                                <svg class="w-6 h-6 filter_arrow"><use xlink:href="./img/icon-defs.svg#drop_b_arrow"></use></svg>
                                            </a>
                                            <div class="filter_dropdown_wrap w-[456px] " style="display: none;">
                                                <ul>
                                                    <li>
                                                        <a href="javascript:;" class="flex items-center">무료</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;" class="flex items-center">착불</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <button class="btn btn-primary w-full mt-8" onclick="modalClose('#shipping_method_modal')">추가하기</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 인증 정보 선택 모달-->
        <div class="modal" id="certification_information_modal">
            <div class="modal_bg" onclick="modalClose('#certification_information_modal')"></div>
            <div class="modal_inner modal-md" style="width:500px;">
                <div class="modal_body filter_body">
                    <div class="py-2">
                        <p class="text-lg font-bold text-left">인증 정보</p>
                        <ul class="filter_list mt-5">
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
                            </li>
                        </ul>
                        <div class="flex justify-center">
                            <button class="btn btn-primary w-1/2" onclick="modalClose('#certification_information_modal')">선택 완료</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 상품 상세 내용 가이드 모달-->
        <div class="modal" id="writing_guide_modal">
            <div class="modal_bg" onclick="modalClose('#writing_guide_modal')"></div>
            <div class="modal_inner modal-md" style="width:480px;">
                <div class="modal_body filter_body">
                    <div class="py-2">
                        <p class="text-lg font-bold text-left">이용 가이드</p>
                        <div class="mt-5">
                            <div>
                                <a href="javascript:;" class="h-[48px] px-3 border rounded-md inline-block filter_border filter_dropdown w-[full] flex justify-between items-center mt-3">
                                    <p>이용가이드</p>
                                    <svg class="w-6 h-6 filter_arrow"><use xlink:href="./img/icon-defs.svg#drop_b_arrow"></use></svg>
                                </a>
                                <div class="filter_dropdown_wrap guide_list w-[436px] h-[370px] overflow-y-scroll" style="display: none;">
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
                            <div id="guide01" class="guide_con mt-5 px-5 text-sm font-medium h-[450px] overflow-y-auto">
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
                            <div id="guide02" class="guide_con mt-5 px-5 text-sm font-medium h-[450px] overflow-y-auto hidden">
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
                            <div id="guide03" class="guide_con mt-5 px-5 text-sm font-medium h-[450px] overflow-y-auto hidden">
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
                            <div id="guide04" class="guide_con mt-5 px-5 text-sm font-medium h-[450px] overflow-y-auto hidden">
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
                            <div id="guide05" class="guide_con mt-5 px-5 text-sm font-medium h-[450px] overflow-y-auto hidden">
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
                            <div id="guide06" class="guide_con mt-5 px-5 text-sm font-medium h-[450px] overflow-y-auto hidden">
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
                            <div id="guide07" class="guide_con mt-5 px-5 text-sm font-medium h-[450px] overflow-y-auto hidden">
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
                            <div id="guide08" class="guide_con mt-5 px-5 text-sm font-medium h-[450px] overflow-y-auto hidden">
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
                            <div id="guide09" class="guide_con mt-5 px-5 text-sm font-medium h-[450px] overflow-y-auto hidden">
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
                            <div id="guide10" class="guide_con mt-5 px-5 text-sm font-medium h-[450px] overflow-y-auto hidden">
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
                            <div id="guide11" class="guide_con mt-5 px-5 text-sm font-medium h-[450px] overflow-y-auto hidden">
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
                            <div id="guide12" class="guide_con mt-5 px-5 text-sm font-medium h-[450px] overflow-y-auto hidden">
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
                            <div id="guide13" class="guide_con mt-5 px-5 text-sm font-medium h-[450px] overflow-y-auto hidden">
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
                            <div id="guide14" class="guide_con mt-5 px-5 text-sm font-medium h-[450px] overflow-y-auto hidden">
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
                            <div id="guide15" class="guide_con mt-5 px-5 text-sm font-medium h-[450px] overflow-y-auto hidden">
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
                            <div id="guide16" class="guide_con mt-5 px-5 text-sm font-medium h-[450px] overflow-y-auto hidden">
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
                            <div id="guide17" class="guide_con mt-5 px-5 text-sm font-medium h-[450px] overflow-y-auto hidden">
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
                            <div id="guide18" class="guide_con mt-5 px-5 text-sm font-medium h-[450px] overflow-y-auto hidden">
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
        <!-- 삭제확인 -->
        <div class="modal" id="del_con_modal">
            <div class="modal_bg" onclick="modalClose('#del_con_modal')"></div>
            <div class="modal_inner modal-sm">
                <div class="modal_body agree_modal_body">
                    <p class="text-center py-4"><b>옵션 삭제 시 입력한 내용은 삭제됩니다.<br/>삭제하시겠습니까?</b></p>
                    <div class="flex gap-2 justify-center">
                        <button class="btn w-full btn-primary-line mt-5" onclick="modalClose('#del_con_modal')">취소</button>
                        <button class="btn w-full btn-primary mt-5" onclick="modalClose('#del_con_modal')">확인</button>
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
                        <div class="mt-5 h-[450px] overflow-y-auto com_setting">
                            <div class="info">
                                <div class="flex items-start gap-2">
                                    <img class="w-4 mt-1" src="./img/member/info_icon.svg" alt="">
                                    <p>필수 옵션의 경우, 주문 시 상위 옵션을 선택해야 하위 옵션 선택이 가능합니다. 상위 개념의 옵션을 앞 순서로 설정해주세요.</p>
                                </div>
                            </div>

                            <div>
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
        <!-- 삭제확인 -->
        <div class="modal" id="del_con_modal">
            <div class="modal_bg" onclick="modalClose('#del_con_modal')"></div>
            <div class="modal_inner modal-sm">
                <div class="modal_body agree_modal_body">
                    <p class="text-center py-4"><b>옵션 삭제 시 입력한 내용은 삭제됩니다.<br/>삭제하시겠습니까?</b></p>
                    <div class="flex gap-2 justify-center">
                        <button class="btn w-full btn-primary-line mt-5" onclick="modalClose('#del_con_modal');">취소</button>
                        <button class="btn w-full btn-primary mt-5" onclick="saveProduct(1);">확인</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- 마이페이지 상품 미리보기 모달 -->
        <div class="modal" id="state_preview_modal">
            <div class="modal_bg" onclick="modalClose('#state_preview_modal')"></div>
            <div class="modal_inner modal-md" style="width:1340px;">
                <div class="modal_body filter_body" style="max-height:inherit">
                    <div class="py-2">
                        <p class="text-lg font-bold text-left">미리보기</p>
                    </div>
                    <div class="overflow-y-scroll h-[600px]">
                        <div class="prod_detail_top">
                            <div class="inner">
                                <div class="img_box">
                                    <div class="left_thumb">
                                        <ul class="swiper-wrapper">
                                            <li class="swiper-slide"><img src="./img/zoom_thumb.png" alt=""></li>
                                            <li class="swiper-slide"><img src="./img/prod_thumb4.png" alt=""></li>
                                            <li class="swiper-slide"><img src="./img/prod_thumb5.png" alt=""></li>
                                            <li class="swiper-slide"><img src="./img/prod_thumb.png" alt=""></li>
                                            <li class="swiper-slide"><img src="./img/prod_thumb2.png" alt=""></li>
                                            <li class="swiper-slide"><img src="./img/prod_thumb3.png" alt=""></li>
                                            <li class="swiper-slide"><img src="./img/sale_thumb.png" alt=""></li>
                                            <li class="swiper-slide"><img src="./img/video_thumb.png" alt=""></li>
                                            <li class="swiper-slide"><img src="./img/prod_thumb2.png" alt=""></li>
                                        </ul>
                                    </div>
                                    <div class="big_thumb">
                                        <ul class="swiper-wrapper">
                                            <li class="swiper-slide"><img src="./img/zoom_thumb.png" alt=""></li>
                                            <li class="swiper-slide"><img src="./img/prod_thumb4.png" alt=""></li>
                                            <li class="swiper-slide"><img src="./img/prod_thumb5.png" alt=""></li>
                                            <li class="swiper-slide"><img src="./img/prod_thumb.png" alt=""></li>
                                            <li class="swiper-slide"><img src="./img/prod_thumb2.png" alt=""></li>
                                            <li class="swiper-slide"><img src="./img/prod_thumb3.png" alt=""></li>
                                            <li class="swiper-slide"><img src="./img/sale_thumb.png" alt=""></li>
                                            <li class="swiper-slide"><img src="./img/video_thumb.png" alt=""></li
                                            <li class="swiper-slide"><img src="./img/prod_thumb2.png" alt=""></li>
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
                                            <button class="btn btn-line4 nohover zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg>좋아요</button>
                                            <button class="btn btn-line4 nohover"><svg><use xlink:href="./img/icon-defs.svg#share"></use></svg>공유하기</button>
                                            <button class="btn btn-line4 nohover inquiry"><svg><use xlink:href="./img/icon-defs.svg#inquiry"></use></svg>문의 하기</button>
                                        </div>
                                    </div>
                                    <div class="btn_box">
                                        <button class="btn btn-primary-line phone" onclick="modalOpen('#company_phone-modal')"><svg class="w-5 h-5"><use xlink:href="./img/icon-defs.svg#phone"></use></svg>전화번호 확인하기</button>
                                        <button class="btn btn-primary"><svg class="w-5 h-5"><use xlink:href="./img/icon-defs.svg#estimate"></use></svg>견적서 받기</button>
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
        <!-- 등록취소 -->
        <div class="modal" id="alert-registration_cancel">
            <div class="modal_bg" onclick="modalClose('#alert-registration_cancel')"></div>
            <div class="modal_inner modal-sm">
                <div class="modal_body agree_modal_body">
                    <p class="text-center py-4"><b>상품 등록을 취소하시겠습니까?<br/>입력한 내용은 임시 등록됩니다.</b></p>
                    <div class="flex gap-2 justify-center">
                        <button class="btn w-full btn-primary-line mt-5" onclick="modalClose('#alert-registration_cancel')">취소</button>
                        <button class="btn w-full btn-primary mt-5" onclick="modalClose('#alert-registration_cancel')">확인</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="fixed bottom-0 border-t border-stone-200 bg-stone-100 w-full z-10">
    <div class="w-[1200px] mx-auto py-6 flex items-center justify-between">
        <a href="javascript:;" class="flex w-[120px] justify-center items-center h-[48px] bg-white border font-medium hover:bg-stone-100" onClick="modalOpen('#alert-registration_cancel');">등록취소</a>
        <div class="flex items-center">
            <button class="font-medium bg-stone-600 text-white w-[120px] h-[48px] border border-stone-900 -mr-px" onclick="modalOpen('#state_preview_modal');">미리보기</button>
            <button class="font-medium bg-stone-600 text-white w-[120px] h-[48px] border border-stone-900">임시등록</button>
            <button class="font-medium bg-primary text-white w-[120px] h-[48px] border border-priamry" onClick="saveProduct(0);">등록신청</button>
        </div>

    </div>
</div>

    <link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>
    <script>
        var storedFiles = [];
        var subCategoryIdx = null;
        var deleteImage = [];
        var proc = false;
        var authList = ['KS 인증', 'ISO 인증', 'KC 인증', '친환경 인증', '외코텍스(OEKO-TEX) 인증', '독일 LGA 인증', 'GOTS(오가닉) 인증', '라돈테스트 인증', '전자파 인증', '전기용품안전 인증'];
        var oIdx = 0;
        var _tmp = 0;
        editer = null;

        $(document)
            .on('click', '.setting_category .category_list li > a', function(e) {
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
                    $nextDepth2.show();
                }
            })
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
                                    '<div class="w-[200px] h-[200px] rounded-md relative flex items-center justify-center bg-slate-100 product-img__add" file="' + file.name +  '">' +
                                    '   <img class="w-[200px] h-[200px] object-cover rounded-md" src="' + e.target.result + '" alt="상품이미지0' + imgCnt + '">' +
                                    '   <div class="absolute top-2.5 right-2.5">' +
                                    '       <button class="file_del w-[28px] h-[28px] bg-stone-600/50 rounded-full">' +
                                    '           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-white mx-auto w-4 h-4"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>' +
                                    '       </button>' +
                                    '   </div>' +
                                    '</div>'
                                );

                                    /*'<li class="product-img__add" file="' + file.name +  '">' +
                                    '<div class="add__img-wrap">' +
                                    '<img src="' + e.target.result + '" alt="상품이미지0' + imgCnt + '">' +
                                    '<button type="button" class="ico__delete--circle">' +
                                    '<span class="a11y">삭제</span>' +
                                    '</button>' +
                                    '</div>' +
                                    '</li>'*/

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
                        alert('the file '+ file.name + ' is not an image<br/>');
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

        function img_reload_order() {
            $('.desc__product-img-wrap').find('.add__badge').remove();
            $('li .product-img__add').first().children('.add__img-wrap').prepend('<p class="add__badge">대표이미지</p>');
        }

        function img_add_order() {
            $('.desc__product-img-wrap li').each(function(n) {
                $(this).attr('item', n);
            });
        }

        // 속성 가져오기
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
                    pb_cls = 'pb-5';
                    if (parentIdx == null) {
                        var htmlText = '';
                        result.forEach(function (e, idx) {
                            if( idx > 0 ) {
                                pb_cls = 'py-5';
                            }
                            htmlText += '<div class="flex items-center gap-3 border-b ' + pb_cls + '">' +
                                '<p class="text-stone-400 w-[130px]">' + e.name + '</p>' +
                                '<button class="h-[48px] w-[120px] border rounded-md hover:bg-stone-50 text-sm" onclick="getProperty(' + e.idx + ', \'' + e.name + '\')">' + e.name + ' 선택</button>' +
                                '</div>'
                        })
                        $('#property #property_info').before(htmlText);
                    } else {
                        var htmlText = "";
                        var subHtmlText = '';
                        result.forEach(function (e, idx) {
                            console.log( e );
                            if( idx > 0 ) {
                                pb_cls = 'py-5';
                            }
                            htmlText += '<div class="flex items-center gap-3 border-b ' + pb_cls + '">' +
                                '<p class="text-stone-400 w-[130px]">' + e.name + '</p>' +
                                '<button class="h-[48px] w-[120px] border rounded-md hover:bg-stone-50 text-sm" onclick="getProperty(' + e.idx + ', \'' + e.name + '\')">' + e.name + ' 선택</button>' +
                                '</div>'

                            subHtmlText += '<li>' +
                                '<input type="checkbox" class="check-form" id="filter_cate_2_01">' +
                                '<label for="filter_cate_2_01">' + e.property_name + '</label>' +
                                '</li>'
                        })

                        $('#product_attributes_modal').data('property_idx', parentIdx);
                        $('#product_attributes_modal .filter_body p').text(title);
                        $('#product_attributes_modal .filter_list').html(subHtmlText);

                        //$('ul.select-group__result[data-property_idx="' + parentIdx + '"] li').each(function (i, el) {
                            //$('#property-modal #property-check_'+$(el).data('sub_idx')).attr('checked', true);
                        //})

                        modalOpen('#product_attributes_modal');
                    }
                }
            });
        }

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

            var targetClass = $(this).data('target');

            var has = $(this).hasClass('delivery');

            if (targetClass) {
                // 모든 targetClass 요소를 숨기고, 현재 targetClass만 표시
                $('[data-target]').each(function() {
                    var currentTarget = $(this).data('target');
                    if (currentTarget !== targetClass) {
                        $('.' + currentTarget).hide();
                    }
                });
                $('.' + targetClass).show(); // 현재 클릭한 targetClass 요소만 표시
            } else {
                // 현재 클릭이 data-target을 가지고 있지 않다면, 모든 targetClass 요소를 숨김
                $('[data-target]').each(function() {
                    var currentTarget = $(this).data('target');
                    $('.' + currentTarget).hide();
                });
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

        // 배송방법 추가 모달
        function openDeliveryModal() {
            // 배송방법은 최대 5개까지만 등록가능
            if( $('.shipping-wrap__add div').length > 5 ) {

            } else {
                $('#shipping_method_modal .btn-primary').prop('disabled', true);
                modalOpen('#shipping_method_modal');
            }
        }

        // 인증정보 모달
        function openAuthInfo() {
            modalOpen('#certification_information_modal');
        }

        // 옵션 추가
        function addOrderOption() {
            // 옵션 최대 6개
            oIdx = parseInt( oIdx + 1 );
            _tmp = parseInt( _tmp + 1 );
            if (oIdx > 6) {
                oIdx = parseInt( oIdx - 1 );
                openModal('#alert-modal10');
            } else {
                var titleHtml = '<div class="flex gap-3 border-t py-5 optNum' + parseInt( _tmp -1 ) + '" data-opt_num="'+ parseInt( _tmp -1 ) +'">' +
                    '   <div class="w-[190px] shrink-0 mt-2">' +
                    '       <p>옵션 ' + oIdx + '</p>' +
                    '       <button class="text-stone-400 underline mt-2" onclick="checkRemoveOption(' + parseInt( _tmp -1 ) + ');">삭제</button>' +
                    '   </div>' +
                    '   <div class="w-full">' +
                    '       <div class="radio_btn flex items-center border-b pb-5">' +
                    '           <p class="essential w-[130px] shrink-0">필수옵션</p>' +
                    '           <div>' +
                    '               <input type="radio" name="required-option0'+ parseInt( _tmp -1 ) +'" id="price_exposure0'+ parseInt( _tmp -1 ) +'-1" checked="">' +
                    '               <label for="price_exposure0'+ parseInt( _tmp -1 ) +'-1" class="w-[140px] h-[48px] flex items-center justify-center">설정</label>' +
                    '           </div>' +
                    '           <div style="margin-left:-1px;">' +
                    '               <input type="radio" name="required-option0'+ parseInt( _tmp -1 ) +'" id="price_exposure0'+ parseInt( _tmp -1 ) +'-2">' +
                    '               <label for="price_exposure0'+ parseInt( _tmp -1 ) +'-2" class="w-[140px] h-[48px] flex items-center justify-center">설정안함</label>' +
                    '           </div>' +
                    '       </div>' +
                    '       <div class="flex items-center mt-3 ">' +
                    '           <p class="essential w-[130px] shrink-0">옵션명</p>' +
                    '           <input type="text" class="setting_input h-[48px] w-[340px]" name="option-name['+ parseInt( _tmp -1 ) +']" placeholder="예시)색상">' +
                    '       </div>' +
                    '       <div class="flex items-center mt-3">' +
                    '           <p class="essential w-[130px] shrink-0">옵션값</p>' +
                    '           <input type="text" class="setting_input h-[48px] w-[340px]" id="option-property['+ parseInt( _tmp -1 ) +'][]" name="option-property_name" placeholder="예시)색상">' +
                    '           <div class="setting_input w-[223px] h-[48px] relative overflow-hidden ml-2">' +
                    '               <input type="text" class="text-right w-full h-full pr-10" name="option-price['+ parseInt( _tmp -1 ) +'][]" value="0" oninput="this.value=this.value.replace(/[^0-9.]/g, \'\');">' +
                    '               <p class="flex flex-wrap items-center justify-center absolute w-[48px] h-[48px] top-0 right-0 bg-stone-100 text-center text-stone-500">환</p>' +
                    '           </div>' +
                    '           <button class="flex flex-wrap items-center justify-center w-[48px] h-[48px] top-0 right-0 bg-stone-100 text-center text-stone-500 rounded-md border ml-2">' +
                    '              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus text-stone-800"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>' +
                    '           </button>' +
                    '       </div>' +
                    '   </div>' +
                    '</div>'

                $('#optsArea').append(titleHtml);
            }
        }

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
                console.log( parseInt( num ) );
                $(this).find('.shrink-0 p').text('옵션 ' + num);
            });

            oIdx = parseInt( oIdx - 1 );
            console.log( oIdx );
            modalClose('#del_con_modal');
        });

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

        $('[name="order-info01"], [name="order-info02"], [name="order-info03"], [name="order-info04"]').on('change', function () {
            var _target = $(this).closest('.radio_btn').next('.guide_area');
            if($(this).val() == 1) {
                _target.show();
            } else {
                if( _target.find('#order_title').length > 0 ) {
                    _target.find('#order_title').val('');
                }
                _target.find('textarea').val('');
                _target.hide();
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
    </script>
@endsection
