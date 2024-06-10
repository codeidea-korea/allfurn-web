@extends('layouts.app')

@section('content')
    @include('layouts.header')
    <div id="content">
        <div class="prod_detail_top">
            <div class="inner">
                <div class="img_box">
                    <div class="left_thumb swiper-initialized swiper-vertical swiper-pointer-events swiper-backface-hidden swiper-thumbs">
                        <ul class="swiper-wrapper" id="swiper-wrapper-f6c110c827f43c9bc" aria-live="polite" style="transform: translate3d(0px, 0px, 0px);">
                            @foreach($data['detail']->attachment as $key=>$item)
                                @if($key < 8)

                                    <li class="swiper-slide swiper-slide-visible" role="group" aria-label="3 / 9" style="margin-bottom: 8px;">
                                        <img src="{{$item['imgUrl']}}" alt="{{$data['detail']->name}}">
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                    <div class="big_thumb swiper-initialized swiper-horizontal swiper-pointer-events swiper-backface-hidden">
                        <ul class="swiper-wrapper" id="swiper-wrapper-92df3f73b1030c925" aria-live="polite" style="transform: translate3d(0px, 0px, 0px);">

                            @foreach($data['detail']->attachment as $key=>$item)
                                @if($key < 8)

                                    <li class="swiper-slide" role="group" aria-label="3 / 8" style="width: 528px;">
                                        <img src="{{$item['imgUrl']}}" alt="{{$data['detail']->name}}">
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                </div>
                <div class="txt_box">
                    <div class="name">
                        @if( ( $data['detail']->is_new_product == 1 && $data['detail']->diff <= 30 ) || $data['detail']->isAd > 0)
                            <div class="tag">
                                @if( $data['detail']->is_new_product == 1 && $data['detail']->diff <= 30 )
                                    <span class="new">NEW</span>
                                @endif
                                @if( $data['detail']->isAd > 0 )
                                    <span class="event">이벤트</span>
                                @endif
                            </div>
                        @endif
                        <h4>{{$data['detail']->name}}</h4>
                        <div class="border-t border-b py-4 mt-4">
                            @if($data['detail']->product_code != '')
                                <div class="flex items-center">
                                    <p class="text-stone-500 w-20 shrink-0 font-medium">상품 코드</p>
                                    <p class="w-full">{{ $data['detail']->product_code }}</p>
                                </div>
                            @endif
                            <div class="flex items-center mt-2">
                                <p class="text-stone-500 w-20 shrink-0 font-medium">배송 방법</p>
                                <p class="w-full">{{ $data['detail']->delivery_info }}</p>
                            </div>
                        </div>
                        @if(isset($data['detail']->product_option) && $data['detail']->product_option != '[]')
                            <?php $arr = json_decode($data['detail']->product_option); $required = false; ?>
                            @foreach($arr as $item)
                                <div class="dropdown my_filterbox mt-3 @if($item->required == 1)required <?php $required = true; ?> @endif">
                                    <a href="javascript:;" class="filter_border filter_dropdown w-full h-full flex justify-between items-center">
                                        <p class="dropdown__title" data-placeholder="{{$item->optionName}}">
                                            {{$item->optionName}} 선택
                                            @if($item->required == 1)
                                                (필수)
                                            @else
                                                (선택)
                                            @endif
                                        </p>
                                        <svg class="w-6 h-6 filter_arrow"><use xlink:href="/img/icon-defs.svg#drop_b_arrow"></use></svg>
                                    </a>
                                    <div class="filter_dropdown_wrap w-[560px]" style="display: none;">
                                        <ul>
                                            @foreach($item->optionValue as $sub)
                                                <li class="dropdown__item" data-option_name="{{$sub->propertyName}}" data-price="{{$sub->price}}">
                                                    <a href="javascript:;" class="flex items-center">
                                                        {{$sub->propertyName}}
                                                        @if((int)$sub->price > 0 && $data['detail']->is_price_open == 1)
                                                            <span class="price" data-price={{$sub->price}}><?php echo number_format((int)$sub->price, 0); ?>원</span>
                                                        @endif
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                            <div class="opt_result_area ori">
                                {{-- @if($required)
                                    <div class="option_result mt-3 mb-3">
                                        <div class="option_top selection__result required">
                                            <p class="selection__text" data-price={{$data['detail']->price}}>{{$data['detail']->name}}</p>
                                            <button><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button>
                                        </div>
                                        <div class="option_count">
                                            <div>
                                                <button class="btn_minus"><svg><use xlink:href="/img/icon-defs.svg#minus"></use></svg></button>
                                                <input type="text" id="qty_input" name="qty_input" value="1" maxlength="3">
                                                <button class="btn_plus"><svg><use xlink:href="/img/icon-defs.svg#plus"></use></svg></button>
                                            </div>
                                            <p class="selection__price">
                                                @if($data['detail']->is_price_open == 1)
                                                    <span>0</span>원
                                                @else
                                                    <span>{{$data['detail']->price_text}}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                @endif --}}
                            </div>
                        @endif 
                    </div>
                    <div class="info">
                        <p class="product_price" data-total_price={{$data['detail']->price}}>{{$data['detail']->is_price_open ? number_format($data['detail']->price, 0).'원': $data['detail']->price_text}}</p>
                        <hr>
                        <div class="company_info">
                            @if($data['detail']->company_type == 'W')
                                <a href="/wholesaler/detail/{{$data['detail']->company_idx}}" class="txt-gray">    
                                    <b>{{$data['detail']->companyName}}</b>
                                    <span>업체 보러가기 <svg><use xlink:href="/img/icon-defs.svg#more_icon"></use></svg></span>
                                </a>
                            @else
                                <a class="txt-gray">
                                    <b>{{$data['detail']->companyName}}</b>
                                </a>
                            @endif
                        </div>
                        <div class="link_box">
                            <button class="btn btn-line4 nohover zzim_btn prd_{{$data['detail']->idx}} {{ ($data['detail']->isInterest == 1) ? 'active' : '' }}" pidx="{{$data['detail']->idx}}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg>좋아요</button>
                            <button class="btn btn-line4 nohover" onclick="copyUrl()"><svg><use xlink:href="/img/icon-defs.svg#share"></use></svg>공유하기</button>
                            <button class="btn btn-line4 nohover inquiry" onClick="sendMessage();"><svg><use xlink:href="/img/icon-defs.svg#inquiry"></use></svg>문의 하기</button>
                        </div>
                    </div>
                    <div class="btn_box">
                        <button class="btn btn-primary-line phone" onclick="modalOpen('#company_phone-modal')"><svg class="w-5 h-5"><use xlink:href="/img/icon-defs.svg#phone"></use></svg>전화번호 확인하기</button>
                        <button class="btn btn-primary" onclick="openEstimateModal({{ $data['detail'] -> idx }})"><svg class="w-5 h-5"><use xlink:href="/img/icon-defs.svg#estimate"></use></svg>견적서 받기</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="prod_detail">
            <div class="info_quick">
                @if($data['detail']->company_type == 'W')
                    <a href="/wholesaler/detail/{{$data['detail']->company_idx}}" class="btn btn-line4 nohover com_link txt-gray">업체 보러가기 <svg><use xlink:href="/img/icon-defs.svg#more_icon"></use></svg></a>
                @endif
                <div class="flex gap-2 my-3">
                    <button class="btn btn-line4 nohover zzim_btn prd_{{$data['detail']->idx}} {{ ($data['detail']->isInterest == 1) ? 'active' : '' }}" pidx="{{$data['detail']->idx}}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg>좋아요</button>
                    <button class="btn btn-line4 nohover" onclick="copyUrl()"><svg><use xlink:href="/img/icon-defs.svg#share"></use></svg>공유하기</button>
                </div>
                <button class="btn btn-line4 nohover inquiry" onclick="sendMessage()"><svg><use xlink:href="/img/icon-defs.svg#inquiry"></use></svg>문의하기</button>
                <button class="btn btn-primary estimate" onclick="openEstimateModal({{ $data['detail'] -> idx }})"><svg class="w-5 h-5"><use xlink:href="/img/icon-defs.svg#estimate"></use></svg>견적서 받기</button>
            </div>
            <div class="inner">
                @if( !empty( $data['detail']['propertyArray'] ) )
                <div class="pb-8">
                    <table class="my_table w-full text-left">
                        <tbody>
                        <tr>
                        <?php $tmp = 0; ?>
                        @foreach( $data['detail']['propertyArray'] AS $key => $val )
                        @if( $tmp != 0 && $tmp%2 == 0 )
                        </tr><tr>
                        @endif
                            <th>{{$key}}</th>
                            <td>{{$val}}</td>
                        <?php $tmp++; ?>
                        @endforeach
                        </tr>
                        </tbody>
                    </table>
                    @if( trim( $data['detail']->notice_info ) != '' )
                    <div class="flex items-start gap-3 p-3 border mt-[-1px]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-volume-2 text-stone-400 shrink-0"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M15.54 8.46a5 5 0 0 1 0 7.07"></path><path d="M19.07 4.93a10 10 0 0 1 0 14.14"></path></svg>
                        <p>{{$data['detail']->notice_info}}</p>
                    </div>
                    @endif
                </div>
                @endif
                <?php echo str_replace('\"', '', str_replace('width: 300px;', 'width: fit-content;',html_entity_decode($data['detail']->product_detail))); ?>
                <!-- 0325추가 -->
                {{-- <img src="/img/prod_detail.png" alt=""> --}}
                <!-- 0325추가 -->
                <div class="pt-8">
                    <h3 class="text-xl font-bold">상품 주문 정보</h3>
                    <hr class="mt-4 border-t-2 border-stone-900">
                    <div class="accordion divide-y divide-gray-200">
                        <div class="accordion-item">
                            <button class="accordion-header py-4 w-full text-left" type="button">
                                <div class="flex justify-between px-4">
                                    <span class="text-lg font-medium">결제 안내</span>
                                    <div class="accordion_arrow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down"><path d="m6 9 6 6 6-6"/></svg>
                                    </div>
                                </div>
                            </button>
                            <div class="accordion-body hidden p-6 bg-stone-50" style="display: none;">
                                    @if( $data['detail']['is_pay_notice'] == 1 )
                                    {!! str_replace(["\\\\r\\\\n", "\\r\\n"], '<br>', $data["detail"]["pay_notice"]) !!}
                                    @else
                                        올톡을 이용하여 문의해주세요
                                    @endif 
                            </div>
                        </div>
                        <div class="accordion-item">
                            <button class="accordion-header py-4 w-full text-left" type="button">
                                <div class="flex justify-between px-4">
                                    <span class="text-lg font-medium">배송 안내</span>
                                    <div class="accordion_arrow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down"><path d="m6 9 6 6 6-6"/></svg>
                                    </div>
                                </div>
                            </button>
                            <div class="accordion-body hidden p-6 bg-stone-50" style="display: none;">
                                    {{$data["detail"]["delivery_notice"]}}

                                    @if( $data['detail']['is_delivery_notice'] == 1 )
                                        {!! str_replace(["\\\\r\\\\n", "\\r\\n"], '<br>', $data["detail"]["delivery_notice"]) !!}
                                    @else
                                        올톡을 이용하여 문의해주세요
                                    @endif 
                            </div>
                        </div>
                        <div class="accordion-item">
                            <button class="accordion-header py-4 w-full text-left" type="button">
                                <div class="flex justify-between px-4">
                                    <span class="text-lg font-medium">교환/반품/취소 안내</span>
                                    <div class="accordion_arrow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down"><path d="m6 9 6 6 6-6"/></svg>
                                    </div>
                                </div>
                            </button>
                            <div class="accordion-body hidden p-6 bg-stone-50" style="display: none;">
                                    @if( $data['detail']['is_return_notice'] == 1 )
                                        {!! str_replace(["\\\\r\\\\n", "\\r\\n"], '<br>', $data["detail"]["return_notice"]) !!}
                                    @else
                                        올톡을 이용하여 문의해주세요
                                    @endif   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- 공유 팝업 -->
    <div class="modal" id="alert-modal">
        <div class="modal_bg" onclick="modalClose('#alert-modal')"></div>
        <div class="modal_inner modal-sm">
            <button class="close_btn" onclick="modalClose('#alert-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <p class="text-center py-4"><b>링크가 복사되었습니다.</b></p>
                <div class="flex gap-2 justify-center">
                    <button class="btn btn-primary w-1/2 mt-5" onclick="modalClose('#alert-modal')">확인</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 업체 전화번호 모달 -->
    <div class="modal" id="company_phone-modal">
        <div class="modal_bg" onclick="modalClose('#company_phone-modal')"></div>
        <div class="modal_inner modal-md">
            <button class="close_btn" onclick="modalClose('#company_phone-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body company_phone_modal">
                <h4><b>업체</b> 전화번호</h4>
                <table>
                    <tbody><tr>
                        <th>업체명</th>
                        <td>{{$data['detail']->companyName}}</td>
                    </tr>
                    <tr>
                        <th>전화번호</th>
                        <td><b>@php echo preg_replace('/^(\d{2,3})(\d{3,4})(\d{4})$/', '$1-$2-$3', $data['detail']->companyPhoneNumber); @endphp</b></td>
                    </tr>
                    </tbody></table>
                <button class="btn btn-primary w-full" onclick="modalClose('#company_phone-modal')">확인</button>
            </div>
        </div>
    </div>

    <!-- 견적 요청서 모달 -->
    <div id="request_estimate-modal" class="modal">
        <div class="modal_bg" onclick="modalClose('#request_estimate-modal')"></div>
        <div class="modal_inner modal-xl">
            <button class="close_btn" onclick="modalClose('#request_estimate-modal'); estimateModalReset();"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <h3 class="text-xl font-bold">견적 요청서</h3>
                <br />
                <form method="PUT" name="isForm" id="isForm" >
                    <input type="hidden" name="request_company_idx" value="{{ $data['company'] -> idx }}" />
                    <input type="hidden" name="request_company_type" value="{{ $data['user'] -> type }}" />
                    <table class="table_layout mt-5">
                        <colgroup>
                            <col width="120px">
                            <col width="330px">
                            <col width="120px">
                            <col width="330px">
                        </colgroup>
                        <thead>
                            <tr>
                                <th colspan="4">견적서를 요청한 자</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>요 청 일 자</th>
                                <td id="request_time"></td>
                                <input type="hidden" name="request_time" value="" />
                                <th>요 청 번 호</th>
                                <td id="estimate_group_code" class="txt-gray"></td>
                                <input type="hidden" name="estimate_group_code" value="" />
                            </tr>
                            <tr>
                                <th>업&nbsp;&nbsp;&nbsp;체&nbsp;&nbsp;&nbsp;명</th>
                                <td id="request_company_name">{{ $data['company'] -> company_name }}</td>
                                <input type="hidden" name="request_company_name" value="{{ $data['company'] -> company_name }}" />
                                <th>사업자번호</th>
                                <td><input type="text" name="request_business_license_number" class="input-form" value="" /></td>
                            </tr>
                            <tr>
                                <th>전 화 번 호</th>
                                <td><input type="text" name="request_phone_number" class="input-form" value="" /></td>
                                <th>주요판매처</th>
                                <td>
                                    <div class="input-form">
                                        <select name="" id="" class="w-full h-full">
                                            <option value="0">매장 판매</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</th>
                                <td colspan="3"><input type="text" name="request_address1" class="input-form w-full" value="" /></td>
                            </tr>
                            <tr>
                                <th>비&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;고</th>
                                <td colspan="3"><input type="text" name="request_memo" class="input-form w-full" value="" /></td>
                            </tr>
                        </tbody>
                    </table>
                    * 다수의 견적서 도착 알림톡이 발송될 수 있습니다.
                    <div class="mt-10">
                        <p>사업자등록증 또는 명함 첨부 (필수)</p>
                        <p class="txt-primary">* 사업자가 아닌 경우 견적서를 요청하실 수 없습니다.</p>
                    </div>
                    <div id="previewBusinessLicense" class="file-form full mt-2">
                        <input type="hidden" name="request_business_license_fidx" value="" />
                        <input type="hidden" name="is_business_license_img" value="0" />
                        <input type="file" name="request_business_license" id="request_business_license" class="file_input" />
                        <div class="text">
                            <img src="/img/member/img_icon.svg" alt="" class="mx-auto" />
                            <p class="mt-1 default-add-image">이미지 추가</p>
                        </div>
                        <div class="absolute top-2.5 right-2.5">
                            <button type="button" id="deleteBusinessLicense" class="file_del w-[28px] h-[28px] bg-stone-600/50 rounded-full hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-white mx-auto w-4 h-4"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex justify-end mt-2">
                        <button type="button" class="btn btn-line w-60 business_license_modify hidden">기본 사업자등록증으로 등록하기</button>
                    </div>
                    <div class="flex justify-end mt-2 request_estimate hidden" style="padding: 10px; font-size: 16px; font-weight: 500; color: #fff; background: #8E8E8E; margin-top: 3.00rem;">
                        아래 상품의 견적을 요청합니다.
                    </div>
                    <div class="btn_box mt-10 check_btn">
                        <p class="mb-2">
                            <input type="checkbox" id="all_prod" class="radio-form" />
                            <label for="all_prod">위 입력된 사항을 확인했습니다.</label>
                        </p>
                        <div class="flex gap-5">
                            <a class="btn btn-primary flex-1" style="cursor: pointer;" onclick="goNext()">확인</a>
                        </div>
                    </div>
                    <ul class="order_prod_list hidden">
                        <input type="hidden" name="response_company_idx" value="{{ $data['detail'] -> company_idx }}" />
                        <input type="hidden" name="response_company_type" value="{{ $data['detail'] -> company_type }}" />
                        <input type="hidden" name="product_idx" value="{{ $data['detail'] -> idx }}" />
                        <li>
                            <div class="img_box">
                                <img src="{{ isset($data['detail'] -> attachment[0]) ? ($data['detail'] -> attachment[0]) -> imgUrl : '' }}" alt="" />
                            </div>
                            <div class="right_box">
                                <h6>{{ $data['detail'] -> name }}</h6>
                                <table class="table_layout">
                                    <colgroup>
                                        <col width="160px">
                                        <col width="*">
                                    </colgroup>
                                    <tr>
                                        <th>상품번호</th>
                                        <td>{{ $data['detail'] -> product_number }}</td>
                                    </tr>
                                    @if(isset($data['detail']->product_option) && $data['detail']->product_option != '[]') 
                                        <input type="hidden" name="product_count" value="1" readOnly />
                                    @else
                                        <tr>
                                            <th>상품수량</th>
                                            <td>
                                                <div class="count_box">
                                                    <button type="button" class="minus"><svg><use xlink:href="/img/icon-defs.svg#minus"></use></svg></button>
                                                    <input type="text" name="product_count" value="1" readOnly />
                                                    <button type="button" class="plus"><svg><use xlink:href="/img/icon-defs.svg#plus"></use></svg></button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif 
                                    <tr>
                                        <th>옵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;션</th>
                                        <td>
                                            @if(isset($data['detail']->product_option) && $data['detail']->product_option != '[]')
                                                <input type="hidden" name="product_option_exist" value="1" readOnly />
                                                <?php $arr = json_decode($data['detail']->product_option); $required = false; ?>
                                                @foreach($arr as $item)
                                                    <div class="dropdown for_estimate_each my_filterbox mt-3" style="position: relative;">
                                                        <a href="javascript:;" class="filter_border filter_dropdown w-full h-full flex justify-between items-center">
                                                            <p class="dropdown__title" data-placeholder="{{$item->optionName}}">
                                                                {{$item->optionName}} 선택
                                                                @if($item->required == 1)
                                                                    (필수)
                                                                @else
                                                                    (선택)
                                                                @endif
                                                            </p>
                                                            <svg class="w-6 h-6 filter_arrow"><use xlink:href="/img/icon-defs.svg#drop_b_arrow"></use></svg>
                                                        </a>
                                                        <div class="filter_dropdown_wrap w-full" style="display: none;">
                                                            <ul>
                                                                @foreach($item->optionValue as $sub)
                                                                    <li class="dropdown__item" style="display: inherit;gap:0;padding:0;border:0;border-radius:0;margin-top:0;" data-option_name="{{$sub->propertyName}}" data-price="{{$sub->price}}">
                                                                        <a href="javascript:;" class="flex items-center">
                                                                            {{$sub->propertyName}}
                                                                            @if((int)$sub->price > 0 && $data['detail']->is_price_open == 1)
                                                                                <span class="price" data-price={{$sub->price}}><?php echo number_format((int)$sub->price, 0); ?>원</span>
                                                                            @endif
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div class="prod_detail_top" style="padding:0">
                                                    <div class="txt_box" style="display:inherit;width:100%;min-height:auto;padding-left:0;">
                                                        <div class="opt_result_area for_estimate"></div>
                                                    </div>
                                                </div>
                                            @else
                                                없음
                                                <input type="hidden" name="product_option_exist" value="0" readOnly />
                                            @endif 
                                        
                                            {{-- @if (!empty(json_decode($data['detail']['product_option'])))
                                                <table class="my_table w-full text-left">
                                                    @foreach (json_decode($data['detail']['product_option']) as $key => $val)
                                                        @if ($val -> required === '1')
                                                            <tr>
                                                                <th>
                                                                    {{ $val -> optionName }}
                                                                    <input type="hidden" name="product_option_key[]" value="{{ $val -> optionName }}" readOnly />
                                                                </th>
                                                                <td>
                                                                    <select name="product_option_value[]" class="input-form w-2/3">
                                                                        <option value="">선택</option>
                                                                        @foreach ($val -> optionValue as $opVal)
                                                                            <option value="{{ $opVal -> propertyName }},{{ $opVal -> price }}">{{ $opVal -> propertyName }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </table>
                                            @else
                                                없음
                                            @endif --}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>판매가격</th>
                                        <td class="txt-gray product_price" data-total_price={{$data['detail']->price}}>
                                            {{ 
                                                ($data['detail'] -> price > 0) ? 
                                                    number_format($data['detail'] -> price).'원' 
                                                    : $data['detail'] -> price_text 
                                            }}
                                        </td>
                                        <input type="hidden" name="product_each_price" value="{{ $data['detail'] -> price }}" />
                                        <input type="hidden" name="product_each_price_text" value="{{ $data['detail'] -> price_text }}" />
                                    </tr>
                                    <tr>
                                        <th>배송지역</th>
                                        <td>{{ $data['detail'] -> product_address }}</td>
                                        <input type="hidden" name="product_delivery_info" value="{{ $data['detail'] -> delivery_info }}" />
                                    </tr>
                                </table>
                            </div>
                        </li>
                    </ul>
                    <div class="btn_box mt-10 request_estimate_btn hidden">
                        <div class="flex gap-5">
                            <a class="btn btn-primary flex-1" style="cursor: pointer;" onclick="insertRequest()">견적서 요청하기</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>





    <script src="/js/jquery-1.12.4.js?{{ date('Ymdhis') }}"></script>
    <script type="text/javascript">
        var opt_idx = 0;
        var isProc = false;
        var optionTmp = [];

        $(".accordion-header").click(function() {   
            // 클릭된 항목의 바디를 토글합니다.
            var $body = $(this).next(".accordion-body");
            $body.slideToggle(200);

            // 선택적: 클릭된 헤더와 같은 아코디언 그룹 내의 다른 모든 바디를 닫습니다.
            $(this).closest('.accordion').find(".accordion-body").not($body).slideUp(200);

            // 클릭된 항목의 .accordion_arrow가 이미 'active' 클래스를 가지고 있는지 체크합니다.
            var isActive = $(this).find(".accordion_arrow").hasClass('active');

            // 페이지 내의 모든 .accordion_arrow에서 'active' 클래스를 제거합니다.
            $('.accordion_arrow').removeClass('active');

            // 클릭된 항목의 .accordion_arrow가 이미 'active' 상태가 아니었다면, 'active' 클래스를 추가합니다.
            if (!isActive) {
                $(this).find(".accordion_arrow").addClass('active');
            }
            // 이미 'active' 상태였다면, 위의 로직에 의해 'active' 클래스가 제거됩니다.
        });

        $(".filter_dropdown").click(function(event){
            $(this).toggleClass('active');
            $(".filter_dropdown_wrap").toggle();
            $(".filter_dropdown svg").toggleClass("active");
            //event.stopPropagation(); // 이벤트 전파 방지
        });

        $(".filter_dropdown_wrap ul li a").click(function(){
            var selectedText = $(this).text();
            $(".filter_dropdown p").text(selectedText);
            $(".filter_dropdown_wrap").hide();
            $(".filter_dropdown").removeClass('active');
            $(".filter_dropdown svg").removeClass("active");
        });

        // 드롭다운 영역 밖 클릭 이벤트
        $(document).click(function(event){
            var $target = $(event.target);
            // 클릭된 요소가 드롭다운 메뉴나 그 자식 요소가 아닐 경우
            if(!$target.closest('.filter_dropdown').length && $('.filter_dropdown').hasClass('active')) {
                $('.filter_dropdown_wrap').hide();
                $('.filter_dropdown').removeClass('active');
                $(".filter_dropdown svg").removeClass("active");
            }
        });

        // 옵션 선택
        $('body').on('click', '.dropdown li', function () {
            opt_idx++;
            var required = false;
            var requiredCnt = $('.dropdown.required').length;
            var idx = $(this).parents('.dropdown').index();
            var same = false;

            if (!$(this).parents('.dropdown').is('.required')) {
                if (required > 0 && $('.selection__result.required').length < 1) {
                    $(this).parents('.dropdown').find('.dropdown__title').text($(this).parents('.dropdown').find('.dropdown__title').data('placeholder'));
                    alert('필수 옵션 선택 후 선택해주세요.'); return false;
                }

                var optionName = $(this).data('option_name');

                $('.selection__result').map(function () {
                    if ($(this).find('.selection__text').eq(1).text() == optionName) {
                        same = true;
                        $('.dropdown').map(function () {
                            $(this).find('.dropdown__title').text($(this).find('.dropdown__title').data('placeholder'));
                        })
                        alert('이미 선택한 옵션입니다. 다시 선택해주세요.'); return false;
                    }
                })
            } else {
                required = true;

                if (requiredCnt > 1 && optionTmp.length != idx-1) {
                    //alert('상위 필수 옵션 선택 후 해당 옵션을 선택해주세요.'); return false;
                }

                optionTmp.push({
                    'name': $(this).parents('.dropdown').find('.dropdown__title').data('placeholder'),
                    'option_name': $(this).data('option_name'),
                    'option_price': $(this).data('price'),
                })
                console.log(optionTmp)

                if (requiredCnt > optionTmp.length) {
                    return;
                } else {
                    $('.selection__result').map(function () {
                        eqCnt = 0;
                        for(i=0; i<optionTmp.length; i++) {
                            if ($(this).find('.selection__text').text() == optionTmp[i]['option_name']) {
                                eqCnt ++;

                                if (eqCnt == optionTmp.length) {
                                    same = true;
                                    $('.dropdown').map(function () {
                                        $(this).find('.dropdown__title').text($(this).find('.dropdown__title').data('placeholder'));
                                    })
                                    optionTmp = [];
                                    alert('이미 선택한 옵션입니다. 다시 선택해주세요.'); return false;
                                }
                            }
                        }
                    })
                }
            }

            if (!same) {
                var htmlText = '<div class="option_result mt-3 mb-3"><div class="option_top selection__result' + (required ? ' required' : ' add') + '">';
                if (required) {
                    optionTmp.map(function (item) {
                        htmlText += '<p class="selection__text" data-name="' + item['name'] + '" data-option_name="' + item['option_name'] + '" data-price="' + item['option_price'] + '">' + item['option_name'] + '</p><button class="ico_opt_remove" data-opt_idx="'+opt_idx+'"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button>';
                    })
                } else {
                    htmlText += '<p class="selection__text" data-name="' + $(this).parents('.dropdown').find('.dropdown__title').data('placeholder') + '" data-option_name="' + $(this).data('option_name') + '" data-price="' + $(this).data('price') + '">' + $(this).data('option_name') + '</p><button class="ico_opt_remove" data-opt_idx="'+opt_idx+'"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button>';
                }
                htmlText += '</div>' +
                        '<div class="option_count">' +
                            '<div>' +
                                '<button class="btn_minus"><svg><use xlink:href="/img/icon-defs.svg#minus"></use></svg></button>' +
                                '<input type="text" id="qty_input" name="qty_input" value="1" maxlength="3" data-opt_idx="'+opt_idx+'">' +
                                '<button class="btn_plus"><svg><use xlink:href="/img/icon-defs.svg#plus"></use></svg></button>' +
                            '</div>' +
                            '<p>';
                                @if($data['detail']->is_price_open == 1)
                                    htmlText += '<span>'+$(this).data('price').toLocaleString()+'</span>원';
                                @else
                                    htmlText += '<span>{{$data['detail']->price_text}}</span>';
                                @endif
                htmlText += '</p></div></div>';
                if(required && $('.selection__result.add').length > 0 ) {
                    $('.selection__result.add').first().before(htmlText);
                } else {
                    $('.opt_result_area').append(htmlText);
                }

                $('.dropdown').map(function () {
                    $(this).find('.dropdown__title').text($(this).find('.dropdown__title').data('placeholder'));
                })
                optionTmp = [];

                reCal();
            }
        })

        // 옵션 선택 후 가격 계산
        function reCal() {
            if ( {{$data['detail']->is_price_open}} == 0) {
                return;
            }
            var price = 0;
            var total_qty = 0;
            $('.ori .selection__result').map(function () {
                var resultPrice = 0;
                $(this).find('.selection__text').map(function () {
                    resultPrice += parseInt($(this).data('price'));
                })
                resultPrice = resultPrice * $(this).parents('.option_result').find('#qty_input').val();
                total_qty += parseInt($(this).parents('.option_result').find('#qty_input').val());
                $(this).find('.selection__price span').text(resultPrice.toLocaleString());
                price += resultPrice;
            })
            if (price > 0) {
                $('.product_price').text(price.toLocaleString()+'원');
                $('.product_price').data('total_price', price);
            }else if (price == 0){
                var total = parseInt('{{str_replace(',', '', $data['detail']->price)}}') * total_qty;
                $('.product_price').text(total.toLocaleString()+'원');
                $('.product_price').data('total_price', total);
            }
        }

        // 수량 변경
        $(document).on('click', '.option_count .btn_minus', function (e) {
            e.preventDefault();
            var oidx = $(this).parents('.option_count').find("input[name='qty_input']").data('opt_idx');
            var stat = $(this).parents('.option_count').find("input[name='qty_input']").val();
            var num = parseInt(stat, 10);
            num--;
            if (num <= 0) {
                alert('더이상 줄일수 없습니다.');
                num = 1;
            }
            $("input[data-opt_idx='"+oidx+"']").val(num);
            //$(this).parents('.option_count').find("input[name='qty_input']").val(num);
            reCal();
        });

        // 수량 변경
        $(document).on('click', '.option_count .btn_plus', function (e) {
            e.preventDefault();
            var oidx = $(this).parents('.option_count').find("input[name='qty_input']").data('opt_idx');
            var stat = $(this).parents('.option_count').find("input[name='qty_input']").val();
            var num = parseInt(stat, 10);
            num++;
            $("input[data-opt_idx='"+oidx+"']").val(num);
            //$(this).parents('.option_count').find("input[name='qty_input']").val(num);
            reCal();
        });

        $(document).on('keyup', '#qty_input', function () {
            reCal();
        })

        // 옵션 삭제
        $(document).on('click', '.ico_opt_remove', function () {
            var oidx = $(this).data('opt_idx');
            $('button[data-opt_idx="'+oidx+'"]').parents('.option_result').remove();
            //$(this).parents('.option_result').remove();
            reCal();
        })


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

        $(window).on('scroll load',function(e){
            let detailTop = $('.prod_detail').offset().top;
            let winH = $(window).height();

            if(e.currentTarget.scrollY > (detailTop - (winH/2))){
                $('.prod_detail .info_quick').addClass('active')
            }else{
                $('.prod_detail .info_quick').removeClass('active')
            }
        })
        
        function copyUrl() {
            var dummy   = document.createElement("input");
            var text    = location.href;

            document.body.appendChild(dummy);
            dummy.value = text;
            dummy.select();
            document.execCommand("copy");
            document.body.removeChild(dummy);

            modalOpen('#alert-modal')
        }

        //문의하기
        function sendMessage() {
            idx='';
            type=''
            if ($(location).attr('href').includes('/product/detail')) {
                idx = $(location).attr('pathname').split('/')[3];
                type = 'product';
            } else if ($(location).attr('href').includes('/wholesaler/detail/')) {
                idx = $(location).attr('pathname').split('/')[3];
                type = 'wholesaler';
            }

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url                : '/message/send',
                data            : {
                    'idx'       : idx,
                    'type'      : type,
                    'message'   : '상품 문의드립니다.',
                    'productThumbnailURL' : "{{ $data['detail']->attachment[0]['imgUrl'] }}",
                },
                type            : 'POST',
                dataType        : 'json',
                success        : function(result) {
                    if (result.result == 'success') {
                        location.replace('/message?roomIdx='+result.roomIdx+'&idx='+idx+'&type='+type+'&message=상품 문의드립니다');
                    } else {

                    }
                }
            });
        }




        
        var storedFiles = [];

        // '견적서 요청일시, 견적서 요청번호' 생성 및 '견적서 요청 모달' 열기
        function openEstimateModal(idx) {
            fetch('/estimate/makeEstimateCode', {
                method  : 'POST',
                headers : {
                    'X-CSRF-TOKEN'  : '{{csrf_token()}}'
                },
                body    : {
                    idx             : idx
                }
            }).then(response => {
                if (response.ok) {
                    return response.json();
                }

                throw new Error('Sever Error');
            }).then(json => {
                if (json.success) {
                    $('#request_time').text(json.now1);
                    $('input[name="request_time"]').val(json.now2);
                    $('#estimate_group_code').text(json.group_code);
                    $('input[name="estimate_group_code"]').val(json.group_code);
                    $('input[name="request_business_license_number"]').val(json.company.business_license_number);
                    $('input[name="request_phone_number"]').val(json.company.phone_number);
                    $('input[name="request_address1"]').val((json.company.business_address ? json.company.business_address : '') + ' ' + (json.company.business_address_detail ?  json.company.business_address_detail : ''));
                    $('.product_address').text(json.product_address);

                    $('input[name="request_business_license_fidx"]').val(json.company.business_license_attachment_idx);
                    if (json.company.blImgUrl != null && json.company.blImgUrl != '') { 
                        $('input[name="is_business_license_img"]').val('1'); 
                    } else { 
                        $('input[name="is_business_license_img"]').val('0'); 
                    }
                    document.getElementById('previewBusinessLicense').style.backgroundImage = "url('" + json.company.blImgUrl + "')";
                    document.getElementById('previewBusinessLicense').style.backgroundSize = 'contain';
                    document.getElementById('previewBusinessLicense').style.backgroundPosition = 'center';
                    document.getElementById('previewBusinessLicense').style.backgroundRepeat = 'no-repeat';
                    document.getElementById('deleteBusinessLicense').classList.remove('hidden');
                    document.querySelectorAll('.default-add-image').forEach(elem => elem.classList.add('hidden'));

                    modalOpen('#request_estimate-modal');
                } else {
                    alert(json.message);
                    return false;
                }
            }).catch(error => {
                alert('오류가 발생하였습니다. 잠시후에 다시 시도해주세요.');
                return false;
            });
        }

        // 견적서 모달 닫을때 견적서 리셋
        function estimateModalReset(){
            $('input[name="request_memo"]').val('');
            $('input[name="product_count"]').val('1');
            if ($('.check_btn').hasClass('hidden')) { 
                $('.check_btn').removeClass('hidden'); 
                $('#all_prod').attr('checked', false);
                $('.request_estimate').addClass('hidden');
                $('.order_prod_list').addClass('hidden');
                $('.request_estimate_btn').addClass('hidden');
            }
        }

        // (등록된) 사업자등록증 미리보기
        const previewBusinessLicense = evt => {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewBusinessLicense').style.backgroundImage = "url('" + e.target.result + "')";
                document.getElementById('previewBusinessLicense').style.backgroundSize = 'contain';
                document.getElementById('previewBusinessLicense').style.backgroundPosition = 'center';
                document.getElementById('previewBusinessLicense').style.backgroundRepeat = 'no-repeat';
                document.getElementById('deleteBusinessLicense').classList.remove('hidden');
                document.querySelectorAll('.default-add-image').forEach(elem => elem.classList.add('hidden'));
            };

            if (evt.currentTarget.files.length) {
                reader.readAsDataURL(evt.currentTarget.files[0]);
            } else {
                document.getElementById('previewBusinessLicense').removeAttribute('style');
                document.getElementById('deleteBusinessLicense').classList.add('hidden');
                document.querySelectorAll('.default-add-image').forEach(elem => elem.classList.remove('hidden'));
            }

            $('input[name="is_business_license_img"]').val('1');
            $('.business_license_modify').removeClass('hidden');
        }
        document.querySelector('[name="request_business_license"]').addEventListener('change', (e) => { 
            storedFiles = [];
            storedFiles.push(e.currentTarget.files[0]);

            previewBusinessLicense(e);
        });

        // (등록된) 사업자등록증 삭제
        const deleteBusinessLicense = () => {
            const element = document.querySelector('[name=request_business_license]');
            element.value = '';

            const e = new Event('change');
            element.dispatchEvent(e);

            $('input[name="is_business_license_img"]').val('0');
            $('.business_license_modify').addClass('hidden');
        }
        document.getElementById('deleteBusinessLicense').addEventListener('click', deleteBusinessLicense);

        // 기본 사업자등록증으로 지정
        $('.business_license_modify').click(function(){
            if(!$('#request_business_license').val()) {
                alert("사업자등록증을 첨부해주세요!");
                $('#request_business_license').focus();
                return false;
            }

            const fformData = new FormData(document.getElementById('isForm'));
            fformData.append('reg_type', '1');
            fformData.append('files[]', storedFiles[0]);

            fetch('/mypage/business_license_file/update', {
                method  : 'POST',
                headers : {
                    'X-CSRF-TOKEN'  : '{{csrf_token()}}'
                },
                body    : fformData
            }).then(response => {
                return response.json();
            }).then(json => {
                if (json.result == 'success') {
                    alert('기본 사업자등록증으로 등록되었습니다.'); return false;
                } else {
                    alert('일시적인 오류로 처리되지 않았습니다.'); return false;
                }
            });

        });

        const goNext = () => {
            if(!$('input[name="request_business_license_number"]').val()) {
                alert('사업자번호를 입력해주세요!');
                $('input[name="request_business_license_number').focus();
                return false;
            }

            if(!$('input[name="request_phone_number"]').val()) {
                alert('전화번호를 입력해주세요!');
                $('input[name="request_phone_number').focus();

                return false;
            }

            if(!$('input[name="request_address1"]').val()) {
                alert('주소를 입력해주세요!');
                $('input[name="request_address1').focus();
                return false;
            }

            if($('input[name="is_business_license_img"]').val() != '1') {
                alert("사업자등록증을 첨부해주세요!");
                $('#request_business_license').focus();
                return false;
            }

            if(!$('#all_prod').is(':checked')) {
                alert('입력된 사항을 다시한번 확인해주시고 아래의 항목에 체크해주세요.');
                $('#all_prod').focus();
                return false;
            }

            $('.check_btn').addClass('hidden');

            $('.request_estimate').removeClass('hidden');
            $('.order_prod_list').removeClass('hidden');
            $('.request_estimate_btn').removeClass('hidden');
        }

        const insertRequest = () => {
            if(!$('input[name="request_business_license_number"]').val()) {
                alert('사업자번호를 입력해주세요!');
                $('input[name="request_business_license_number').focus();
                return false;
            }

            if(!$('input[name="request_phone_number"]').val()) {
                alert('전화번호를 입력해주세요!');
                $('input[name="request_phone_number').focus();
                return false;
            }

            if(!$('input[name="request_address1"]').val()) {
                alert('주소를 입력해주세요!');
                $('input[name="request_address1').focus();
                return false;
            }

            if($('input[name="is_business_license_img"]').val() != '1') {
                alert("사업자등록증을 첨부해주세요!");
                $('#request_business_license').focus();
                return false;
            }

            const formData = new FormData(document.getElementById('isForm'));
            formData.append('reg_type', '1');
            formData.append('files[]', storedFiles[0]);

            let optArr = '[';
            $('.for_estimate_each').each(function(e, i){
                let oname = $(this).find('.dropdown__title').data('placeholder');
                if (e > 0) optArr += ',';
                optArr += `{"optionName":"${oname}","optionValue":{`;
                $('.for_estimate .option_result').each(function(e2, i2){
                    let optionName = $(this).find('.selection__text').data('option_name')
                    let optionPrice = $(this).find('.selection__text').data('price')
                    let optionQty = $(this).find('#qty_input').val();
                    if (e2 > 0) optArr += ',';
                    optArr += `"${optionName}":"${optionPrice}/${optionQty}"`;
                });
                optArr += `}}`;
            });
            optArr += ']';
            formData.append('product_option_json', optArr);
            //console.log(optArr);

            formData.append('product_total_price', $('.product_price').data('total_price'));

            fetch('/estimate/insertRequest', {
                method  : 'POST',
                headers : {
                    'X-CSRF-TOKEN'  : '{{csrf_token()}}'
                },
                body    : formData
            }).then(response => {
                return response.json();
            }).then(json => {
                if (json.success) {
                    //openModal('#alert-modal02');
                    alert('견적서 요청이 완료되었습니다.');
                    location.reload();
                } else {
                    alert('일시적인 오류로 처리되지 않았습니다.');
                    return false;
                }
            });
        }

        $(function(){
            $('.count_box .minus').off().on('click', function(){
                let num = Number($(this).siblings('input').val());
                if (num !== 1) {
                    $(this).siblings('input').val(`${num - 1}`);
                }
            });

            $('.count_box .plus').off().on('click', function(){
                let num = Number($(this).siblings('input').val());
                $(this).siblings('input').val(`${num + 1}`);
            });
        });

    </script>
@endsection
