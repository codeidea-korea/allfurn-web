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
                                                <input type="text" name="qty_input" value="1" maxlength="3">
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
                                    <span>업체 모든 제품 보러가기 <svg><use xlink:href="/img/icon-defs.svg?08#more_icon_red"></use></svg></span>
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
                        <button class="btn btn-primary-line phone" onclick="openPhoneDialog()"><svg class="w-5 h-5"><use xlink:href="/img/icon-defs.svg#phone"></use></svg>전화번호 확인하기</button>
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
    <!-- new 견적서 -->
    <div class="modal" id="request_estimate-modal">
        <input type="hidden" name="request_company_idx" value="{{ $data['company'] -> idx }}" />
        <input type="hidden" name="request_company_type" value="{{ $data['user'] -> type }}" />
        <div class="modal_bg" onclick="modalClose('#request_estimate-modal')"></div>
        <div class="modal_inner new-modal">
            <div class="modal_header">
                <h3>견적 요청서</h3>
                <button type="button" class="close_btn" onclick="modalClose('#request_estimate-modal')"><img src="/img/icon/x_icon.svg" alt=""></button>
            </div>

            <div class="modal_body">
                <div class="relative">
                    <div class="info"><span class="reqCount">1</span>건의 상품을 '{{ $data['detail']->companyName }}' 업체에게 견적을 보낼 수 있습니다.</div>
                    <div class="p-7">
                        <!-- 상품정보 -->
                        <div class="prod_info">
                            <div class="img_box"><img src="{{ isset($data['detail'] -> attachment[0]) ? ($data['detail'] -> attachment[0]) -> imgUrl : '' }}" alt=""></div>
                            <div class="info_box">
                                <div class="prod_name">{{ $data['detail'] -> name }}</div>
                                <div class="prod_option">
                                    <div class="name">수량</div>
                                    <div>
                                        <div class="count_box2">
                                            <button type="button" class="minus"><svg><use xlink:href="/img/icon-defs.svg#minus"></use></svg></button>
                                            <input type="text" id="requestEstimateProductCount" name="product_count" value="1">
                                            <button type="button" class="plus"><svg><use xlink:href="/img/icon-defs.svg#plus"></use></svg></button>
                                        </div>
                                    </div>
                                </div>
                                @if(isset($data['detail']->product_option) && $data['detail']->product_option != '[]')
                                    <?php $arr = json_decode($data['detail']->product_option); $required = false; ?>
                                    @foreach($arr as $item)
                                        <div class="dropdown my_filterbox relative mt-3 @if($item->required == 1)required <?php $required = true; ?> @endif">
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
                                    </div>
                                    <p class="product_price" data-total_price="1000">0원</p>
                                @else
                                <div class="prod_option">
                                    <div class="name">단가</div>
                                    <div class="_requestEstimateTotalPrice">
                                    @if( $data['detail']->is_price_open == 0 || $data['detail']->price_text == '수량마다 상이' || $data['detail']->price_text == '업체 문의' ? 1 : 0 )
                                        업체 문의
                                    @else
                                        {{$data['detail']->is_price_open ? number_format($data['detail']->price, 0).'원': $data['detail']->price_text}}
                                    @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- 접기/펼치기 -->
                        <div class="fold_area mt-7">
                            @if( $data['prdCount'] - 1 > 0 )
                            <div class="target">
                                <button type="button" class="title" onclick="foldToggle(this)">
                                    <b>'{{ $data['detail']->companyName }}' 업체의 다른 {{ number_format( $data['prdCount'] - 1 ) }}개 상품 추가 선택 가능 합니다.</b>
                                    <img class="arrow" src="/img/icon/arrow-icon.svg" alt="">
                                </button>
                            </div>
                            @endif
                            <div class="py-7" id="orderProductList">
                                <div>
                                {{--
                                <div class="prod_info">
                                    <div class="img_box">
                                        <button type="button" class="add_btn" onclick="prodAdd(this)">추가</button>
                                        <img src="/img/prod_thumb3.png" alt="">
                                    </div>
                                    <div class="info_box">
                                        <div class="prod_name">엔젤A</div>
                                        <div class="prod_option">
                                            <div class="name">수량</div>
                                            <div>
                                                <div class="count_box2">
                                                    <button type="button" class="minus" onclick="changeValue(this,'minus')"><svg><use xlink:href="/img/icon-defs.svg#minus"></use></svg></button>
                                                    <input type="text" value="1">
                                                    <button type="button" class="plus" onclick="changeValue(this,'plus')"><svg><use xlink:href="/img/icon-defs.svg#plus"></use></svg></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prod_option">
                                            <div class="name">가격</div>
                                            <div>50,000</div>
                                        </div>
                                        <div class="prod_option">
                                            <div class="name">가격</div>
                                            <div>업체문의</div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="prod_info">
                                    <div class="img_box">
                                        <button type="button" class="add_btn cancel" onclick="prodAdd(this)">취소</button>
                                        <img src="/img/prod_thumb3.png" alt="">
                                    </div>
                                    <div class="info_box">
                                        <div class="prod_name">엔젤A</div>
                                        <div class="prod_option">
                                            <div class="name">수량</div>
                                            <div>
                                                <div class="count_box2">
                                                    <button type="button" class="minus" onclick="changeValue(this,'minus')"><svg><use xlink:href="/img/icon-defs.svg#minus"></use></svg></button>
                                                    <input type="text" value="1">
                                                    <button type="button" class="plus" onclick="changeValue(this,'plus')"><svg><use xlink:href="/img/icon-defs.svg#plus"></use></svg></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prod_option">
                                            <div class="name">가격</div>
                                            <div>50,000</div>
                                        </div>
                                        <div class="prod_option">
                                            <div class="name">가격</div>
                                            <div>업체문의</div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="prod_info">
                                    <div class="img_box">
                                        <button type="button" class="add_btn cancel" onclick="prodAdd(this)">취소</button>
                                        <img src="/img/prod_thumb3.png" alt="">
                                    </div>
                                    <div class="info_box">
                                        <div class="prod_name">엔젤A</div>
                                        <div class="dropdown_wrap noline">
                                            <button type="button" class="dropdown_btn"><p>옵션(사이즈 및 컬러) 선택</p></button>
                                            <div class="dropdown_list">
                                                <div class="dropdown_item">옵션명 표기1</div>
                                                <div class="dropdown_item">옵션명 표기2</div>
                                                <div class="dropdown_item">옵션명 표기3</div>
                                            </div>
                                        </div>

                                        <div class="noline">
                                            <div class="option_item">
                                                <div class="">
                                                    <p class="option_name">옵션명 표기1</p>
                                                    <button type="button"><img src="/img/icon/x_icon2.svg" alt=""></button>
                                                </div>
                                                <div class="mt-2">
                                                    <div class="count_box2">
                                                        <button type="button" class="minus" onclick="changeValue(this,'minus')"><svg><use xlink:href="/img/icon-defs.svg#minus"></use></svg></button>
                                                        <input type="text" value="1">
                                                        <button type="button" class="plus" onclick="changeValue(this,'plus')"><svg><use xlink:href="/img/icon-defs.svg#plus"></use></svg></button>
                                                    </div>
                                                    <div class="price">50,000</div>
                                                </div>
                                            </div>
                                            <div class="option_item">
                                                <div class="">
                                                    <p class="option_name">옵션명 표기1</p>
                                                    <button type="button"><img src="/img/icon/x_icon2.svg" alt=""></button>
                                                </div>
                                                <div class="mt-2">
                                                    <div class="count_box2">
                                                        <button type="button" class="minus" onclick="changeValue(this,'minus')"><svg><use xlink:href="/img/icon-defs.svg#minus"></use></svg></button>
                                                        <input type="text" value="1">
                                                        <button type="button" class="plus" onclick="changeValue(this,'plus')"><svg><use xlink:href="/img/icon-defs.svg#plus"></use></svg></button>
                                                    </div>
                                                    <div class="price">50,000</div>
                                                </div>
                                            </div>
                                            <div class="option_item">
                                                <div class="">
                                                    <p class="option_name">옵션명 표기1</p>
                                                    <button type="button"><img src="/img/icon/x_icon2.svg" alt=""></button>
                                                </div>
                                                <div class="mt-2">
                                                    <div class="count_box2">
                                                        <button type="button" class="minus" onclick="changeValue(this,'minus')"><svg><use xlink:href="/img/icon-defs.svg#minus"></use></svg></button>
                                                        <input type="text" value="1">
                                                        <button type="button" class="plus" onclick="changeValue(this,'plus')"><svg><use xlink:href="/img/icon-defs.svg#plus"></use></svg></button>
                                                    </div>
                                                    <div class="price">50,000</div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="prod_option">
                                            <div class="name">가격</div>
                                            <div class="total_price">150,000</div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                --}}
                                </div>
                                <div class="text-center orderProductList_addlist">
                                    <button type="button" class="more_prod">상품 더보기</button>
                                </div>

                            </div>
                        </div>


                        <!-- 추가문의사항
                        <dl class="add_textarea mt-7">
                            <dt>추가 문의사항</dt>
                            <dd><textarea name="request_memo" id="request_memo" placeholder="추가 요청사항 입력하세요(200자)"></textarea></dd>
                        </dl> -->

                    </div>
                </div>
            </div>

            <div class="modal_footer">
                <button type="button"><span class="reqCount">1</span>건 견적서 요청하기(1단계) <img src="/img/icon/arrow-right.svg" alt=""></button>
            </div>
        </div>
    </div>


    <!-- 견적요청서 확인 -->
    <div class="modal" id="request_confirm-modal">
        <div class="modal_bg" onclick="modalClose('#request_confirm-modal')"></div>
        <div class="modal_inner new-modal">
            <div class="modal_header">
                <h3>견적 요청서 확인</h3>
                <button class="close_btn" onclick="modalClose('#request_confirm-modal')"><img src="./img/icon/x_icon.svg" alt=""></button>
            </div>

            <div class="modal_body">
                <div class="relative">
                    <div class="info"><span class="reqCount">1</span>건의 상품을 '{{ $data['detail']->companyName }}'업체에게 견적을 보낼 수 있습니다.</div>
                    <div class="p-7">
                        <!-- 견적 기본정보 -->
                        <div class="fold_area txt_info active">
                            <div class="target title" onclick="foldToggle(this)">
                                <p>견적 기본정보</p>
                                <img class="arrow" src="./img/icon/arrow-icon.svg" alt="">
                            </div>
                            <div>
                                <div class="txt_desc">
                                    <div class="name">총 상품수</div>
                                    <div><b><span class="reqCount">1</span>건</b></div>
                                </div>
                            </div>
                        </div>

                        <!-- 추가문의사항
                        <dl class="add_textarea mb-7">
                            <dt>추가 문의사항</dt>
                            <dd class="txt reqMemo">견적서 수량은 추가 될 수 있습니다. 수량 추가 시 견적관련 전화 문의 드립니다.</dd>
                        </dl>
                         -->
                        <dl class="add_textarea mt-7">
                            <dt>추가 문의사항</dt>
                            <dd class="txt reqMemo"><textarea name="request_memo" id="request_memo" placeholder="추가 요청사항 입력하세요(200자)"></textarea></dd>
                        </dl>

                        <div class="fold_area txt_info">
                            <div class="target title" onclick="foldToggle(this)">
                                <p>업체 기본정보</p>
                                <img class="arrow" src="/img/icon/arrow-icon.svg" alt="">
                            </div>
                            <div>
                                <div class="txt_desc">
                                    <div class="name">업체명</div>
                                    <div>{{ $data['detail']->companyName }}업체</div>
                                </div>
                                <div class="txt_desc">
                                    <div class="name">전화번호</div>
                                    <div>{{ $data['detail']->companyPhoneNumber }}</div>
                                </div>
                            </div>
                        </div>



                        <!-- 접기/펼치기 -->
                        <div class="fold_area mt-7">
                            <div class="target">
                                <button class="title" onclick="foldToggle(this)">
                                    <span>상품 <span class="reqCount">1</span>건 리스트 보기</span>
                                    <img class="arrow" src="/img/icon/arrow-icon.svg" alt="">
                                </button>
                            </div>
                            <div class="py-7" id="orderProductList2">
                                <!-- div class="prod_info">
                                    <div class="img_box">
                                        <input type="checkbox" id="check_4" class="hidden" checked disabled>
                                        <label for="check_4" class="add_btn">대표</label>
                                        <img src="./pc/img/prod_thumb3.png" alt="">
                                    </div>
                                    <div class="info_box">
                                        <div class="prod_name">엔젤A</div>
                                        <div class="prod_option">
                                            <div class="name">수량</div>
                                            <div>
                                                <div class="count_box2">
                                                    <button class="minus" onclick="changeValue(this,'minus')"><svg><use xlink:href="./pc/img/icon-defs.svg#minus"></use></svg></button>
                                                    <input type="text" value="1">
                                                    <button class="plus" onclick="changeValue(this,'plus')"><svg><use xlink:href="./pc/img/icon-defs.svg#plus"></use></svg></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prod_option">
                                            <div class="name">가격</div>
                                            <div>50,000</div>
                                        </div>
                                        <div class="prod_option">
                                            <div class="name">가격</div>
                                            <div>업체문의</div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="prod_info">
                                    <div class="img_box">
                                        <input type="checkbox" id="check_5" class="hidden" checked>
                                        <label for="check_5" class="add_btn" onclick="prodAdd(this)">취소</label>
                                        <img src="./pc/img/prod_thumb3.png" alt="">
                                    </div>
                                    <div class="info_box">
                                        <div class="prod_name">엔젤A</div>
                                        <div class="prod_option">
                                            <div class="name">수량</div>
                                            <div>
                                                <div class="count_box2">
                                                    <button class="minus" onclick="changeValue(this,'minus')"><svg><use xlink:href="./pc/img/icon-defs.svg#minus"></use></svg></button>
                                                    <input type="text" value="1">
                                                    <button class="plus" onclick="changeValue(this,'plus')"><svg><use xlink:href="./pc/img/icon-defs.svg#plus"></use></svg></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prod_option">
                                            <div class="name">가격</div>
                                            <div>50,000</div>
                                        </div>
                                        <div class="prod_option">
                                            <div class="name">가격</div>
                                            <div>업체문의</div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="prod_info">
                                    <div class="img_box">
                                        <input type="checkbox" id="check_6" class="hidden" checked>
                                        <label for="check_6" class="add_btn" onclick="prodAdd(this)">취소</label>
                                        <img src="./pc/img/prod_thumb3.png" alt="">
                                    </div>
                                    <div class="info_box">
                                        <div class="prod_name">엔젤A</div>
                                        <div class="dropdown_wrap noline">
                                            <button class="dropdown_btn"><p>옵션(사이즈 및 컬러) 선택</p></button>
                                            <div class="dropdown_list">
                                                <div class="dropdown_item">옵션명 표기1</div>
                                                <div class="dropdown_item">옵션명 표기2</div>
                                                <div class="dropdown_item">옵션명 표기3</div>
                                            </div>
                                        </div>

                                        <div class="noline">
                                            <div class="option_item">
                                                <div class="">
                                                    <p class="option_name">옵션명 표기1</p>
                                                    <button><img src="./img/icon/x_icon2.svg" alt=""></button>
                                                </div>
                                                <div class="mt-2">
                                                    <div class="count_box2">
                                                        <button class="minus" onclick="changeValue(this,'minus')"><svg><use xlink:href="./pc/img/icon-defs.svg#minus"></use></svg></button>
                                                        <input type="text" value="1">
                                                        <button class="plus" onclick="changeValue(this,'plus')"><svg><use xlink:href="./pc/img/icon-defs.svg#plus"></use></svg></button>
                                                    </div>
                                                    <div class="price">50,000</div>
                                                </div>
                                            </div>
                                            <div class="option_item">
                                                <div class="">
                                                    <p class="option_name">옵션명 표기1</p>
                                                    <button><img src="./img/icon/x_icon2.svg" alt=""></button>
                                                </div>
                                                <div class="mt-2">
                                                    <div class="count_box2">
                                                        <button class="minus" onclick="changeValue(this,'minus')"><svg><use xlink:href="./pc/img/icon-defs.svg#minus"></use></svg></button>
                                                        <input type="text" value="1">
                                                        <button class="plus" onclick="changeValue(this,'plus')"><svg><use xlink:href="./pc/img/icon-defs.svg#plus"></use></svg></button>
                                                    </div>
                                                    <div class="price">50,000</div>
                                                </div>
                                            </div>
                                            <div class="option_item">
                                                <div class="">
                                                    <p class="option_name">옵션명 표기1</p>
                                                    <button><img src="./img/icon/x_icon2.svg" alt=""></button>
                                                </div>
                                                <div class="mt-2">
                                                    <div class="count_box2">
                                                        <button class="minus" onclick="changeValue(this,'minus')"><svg><use xlink:href="./pc/img/icon-defs.svg#minus"></use></svg></button>
                                                        <input type="text" value="1">
                                                        <button class="plus" onclick="changeValue(this,'plus')"><svg><use xlink:href="./pc/img/icon-defs.svg#plus"></use></svg></button>
                                                    </div>
                                                    <div class="price">50,000</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prod_option">
                                            <div class="name">가격</div>
                                            <div class="total_price">150,000</div>
                                        </div>
                                    </div>
                                </div //-->
                                <hr>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal_footer">
                <button type="button"><span class="reqCount">1</span>건 견적 요청하기(완료) <img src="/img/icon/arrow-right.svg" alt=""></button>
            </div>
        </div>
    </div>





    <script src="/js/jquery-1.12.4.js?{{ date('Ymdhis') }}"></script>
    <script defer src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script type="text/javascript">
        var modal_page = 0;
        var modal_total = {{ $data['prdCount'] - 1 }};

        let prodData = new FormData();

        // 주소 API 호출
        const callMapApi = elem => {
            const ele = elem;
            new daum.Postcode({
                oncomplete  : function(data) {
                    $(ele).val(data.roadAddress);
                }
            }).open();
        }
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
            var requiredCnt = $('.dropdown.required').length / 2;
            var idx = $(this).parents('.dropdown').index();
            var same = false;

            if (!$(this).parents('.dropdown').is('.required')) {
                if (requiredCnt > 0 && $('.selection__result.required').length < 1) {
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
                var htmlText = '<div class="option_item option_result mt-3 mb-3"><div class="option_top selection__result' + (required ? ' required' : ' add') + '">';
                if (required) {
                    optionTmp.map(function (item) {
                        $('._requestEstimateOption').text(item['option_name']);

                        htmlText += '<p class="selection__text" data-name="' + item['name'] + '" data-option_name="' + item['option_name'] + '" data-price="' + item['option_price'] + '">' + item['option_name'] + '</p><button class="ico_opt_remove" data-opt_idx="'+opt_idx+'"><svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#x"></use></svg></button>';
                    })
                } else {
                    $('._requestEstimateOption').text($(this).data('option_name'));

                    htmlText += '<p class="selection__text" data-name="' + $(this).parents('.dropdown').find('.dropdown__title').data('placeholder') + '" data-option_name="' + $(this).data('option_name') + '" data-price="' + $(this).data('price') + '">' + $(this).data('option_name') + '</p><button class="ico_opt_remove" data-opt_idx="'+opt_idx+'"><svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#x"></use></svg></button>';
                }
                htmlText += '</div>' +
                    '<div class="option_count">' +
                    '<div class="count_box2">' +
                    '<button class="btn_minus"><svg><use xlink:href="/img/icon-defs.svg#minus"></use></svg></button>' +
                    '<input type="text" id="requestEstimateProductCount" style="width: 40px;" name="qty_input" value="1" maxlength="3" data-opt_idx="'+opt_idx+'">' +
                    '<button class="btn_plus"><svg><use xlink:href="/img/icon-defs.svg#plus"></use></svg></button>' +
                    '</div>' +
                    '<p class="price">';
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
            var instancePrice = {{$data['detail']->price}}; // 단위가
            var total_qty = 0;
            $('.ori .selection__result').map(function () {
                var resultPrice = 0;
                $(this).find('.selection__text').map(function () {
                    resultPrice += parseInt($(this).data('price'));
                })
                resultPrice = resultPrice * $(this).parents('.option_result').find('input[name=qty_input]').val();
                total_qty += parseInt($(this).parents('.option_result').find('input[name=qty_input]').val());
                $(this).find('.selection__price span').text(resultPrice.toLocaleString());
                price += resultPrice;
            });
            price = price / 2;
            price = price + instancePrice;
            $('._requestEstimateCount').text(total_qty + '개');
            if (price > 0) {
                $('.product_price').text(price.toLocaleString()+'원');
                $('.product_price').data('total_price', price);
            }else if (price == 0){
                var total = parseInt('{{str_replace(',', '', $data['detail']->price)}}') * total_qty;
                $('.product_price').text(total.toLocaleString()+'원');
                $('.product_price').data('total_price', total);
            }
            if({{ $data['detail']->is_price_open == 0 || $data['detail']->price_text == '수량마다 상이' || $data['detail']->price_text == '업체 문의' ? 1 : 0 }}) {
                $('._requestEstimateTotalPrice').text("{{ $data['detail']->price_text }}");
                $('._requestEstimateTotalPrice2').text("{{ $data['detail']->price_text }}");
            } else {
                $('._requestEstimateTotalPrice').text($('.product_price').text());
                $('._requestEstimateTotalPrice2').text(price.toLocaleString()+'원');
            }
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
            type='';
            
        @if($data['detail']->company_idx == Auth::user()['company_idx'])
        alert('본인 업체에 문의하기는 할 수 없습니다.');
        return;
        @endif
        
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
        function openPhoneDialog(){
            if (isProc) {
                return;
            }
            isProc = true;

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url             : '/event/saveUserAction?company_idx={{$data['detail']->company_idx}}&company_type=W&product_idx={{ $data['detail'] -> idx }}&request_type=1',
                enctype         : 'multipart/form-data',
                processData     : false,
                contentType     : false,
                type			: 'GET',
                success: function (result) {
                    modalOpen('#company_phone-modal');

                    isProc = false;
                }
            });
        }





        var storedFiles = [];

        // '견적서 요청일시, 견적서 요청번호' 생성 및 '견적서 요청 모달' 열기
        function openEstimateModal(idx) {
            if('{{Auth::user()-> type}}' === 'S') {
                requiredUserGrade(['R','W','N']);
                return;
            }
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
                console.log( json );
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

                    /*
                    document.getElementById('previewBusinessLicense').style.backgroundImage = "url('" + json.company.blImgUrl + "')";
                    document.getElementById('previewBusinessLicense').style.backgroundSize = 'contain';
                    document.getElementById('previewBusinessLicense').style.backgroundPosition = 'center';
                    document.getElementById('previewBusinessLicense').style.backgroundRepeat = 'no-repeat';
                    document.getElementById('deleteBusinessLicense').classList.remove('hidden');
                    */
                    document.querySelectorAll('.default-add-image').forEach(elem => elem.classList.add('hidden'));

                    modal_page = 0;
                    getWholesalerProductList( {{ $data['detail']->company_idx }} );

                    $('#request_estimate-modal').find('#request_memo').val('');
                    prodData = new FormData();
                    $('#request_estimate-modal .fold_area').removeClass('active');
                    $('.reqCount').text(1);
                    modalOpen('#request_estimate-modal');

                    $('.check_btn').addClass('hidden');
                    $('.request_estimate').removeClass('hidden');
                    $('.order_prod_list').removeClass('hidden');
                    $('.request_estimate_btn').removeClass('hidden');
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
        /*
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
            */
        //        document.getElementById('deleteBusinessLicense').addEventListener('click', deleteBusinessLicense);

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
                    let optionQty = $(this).find('input[name=qty_input]').val();
                    if (e2 > 0) optArr += ',';
                    optArr += `"${optionName}":"${optionPrice}/${optionQty}"`;
                });
                optArr += `}}`;
            });
            optArr += ']';
            formData.append('product_option_json', optArr);
            //console.log(optArr);

            formData.append('product_total_price', $('.product_price').data('total_price'));

            $('#loadingContainer').show();

            fetch('/estimate/insertRequest', {
                method  : 'POST',
                headers : {
                    'X-CSRF-TOKEN'  : '{{csrf_token()}}'
                },
                body    : formData
            }).then(response => {
                return response.json();
            }).then(json => {
                $('#loadingContainer').hide();

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
            initEventListener();
        });


        let isLoading = false;
        let isLastPage = false;
        let currentPage = 0;
        let firstLoad = true;
        function loadProductList(needEmpty) {
            if(isLoading) return;
            if(!needEmpty && isLastPage) return;
            isLoading = true;
            if(needEmpty) currentPage = 0;
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '/wholesaler/wholesalerAddProduct2',
                method: 'GET',
                data: {
                    'page': ++currentPage,
                    'categories' : '',
                    'orderedElement' : 'register_time',
                    'company_idx'   : '{{$data['detail'] -> company_idx}}'
                },
                beforeSend : function() {
                },
                success: function(result) {
                    console.log(result);
                    if(needEmpty) {
                        $("#request_estimate-modal").find(".prod_list").empty();
                    }
                    $("#request_estimate-modal").find(".prod_list").append(result.data.html);
                    //                $(".total").text('전체 ' + result.total.toLocaleString('ko-KR') + '개');
                    isLastPage = currentPage === result.last_page;
                    if(isLastPage) {
                        $('#btnMoreProduct').hide();
                    }
                    if($('#new_esti_1').is(":checked")) {
                        $('.prod_item > .custom_input2 > input').prop('checked', true);
                    }
                },
                complete : function () {
                    isLoading = false;
                }
            })
        }
        $('#new_estimate2-modal .company_info h5').on('click',function(){
            $('.company_info').toggleClass('active')
        })
        loadProductList(true);
        $('input[name=request_address1]').change(function(){
            $('._requestEstimateAddress').text(this.value);
        });
        $('._requestEstimateCount').text($('#requestEstimateProductCount').val() + '개');

        const price = {{ $data['detail']->is_price_open ? $data['detail']->price : 0 }};
        var optionPrice = 0;
        if({{ $data['detail']->is_price_open == 0 || $data['detail']->price_text == '수량마다 상이' || $data['detail']->price_text == '업체 문의' ? 1 : 0 }}) {
            $('._requestEstimateTotalPrice').text("업체 문의");
            $('._requestEstimateTotalPrice2').text("업체 문의");
        } else {
            const count = Number($('#requestEstimateProductCount').val()+'');
            $('._requestEstimateTotalPrice').text((count * (price + optionPrice)).toLocaleString('en-US') + '원');
            $('._requestEstimateTotalPrice2').text((price + optionPrice).toLocaleString('en-US'));
        }
        $('input[name=product_option_exist]').text('없음');
        function requestEstimateAllCheck(){
            if($('#new_esti_1').is(":checked")) {
                $('.prod_item > .custom_input2 > input').prop('checked', true);
            } else {
                $('.prod_item > .custom_input2 > input').prop('checked', false);
            }
        }
        $('._requestEstimateTotalPrice').text($('.product_price').text());
        $('._requestEstimateTotalPrice2').text($('.product_price').text());


        function getWholesalerProductList( company_idx )
        {
            if( company_idx == '' ) {
                return false;
            }

            modal_page = modal_page + 1;

            $.ajax({
                url: '/wholesaler/wholesalerProduct',
                type: 'GET',
                data: {
                    'idx'   : {{ $data['detail']->idx }},
                    'page'  : modal_page,
                    'limit' : 5,
                    'company_idx' : company_idx
                },
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                },
                success: function (res) {
                    console.log( res );

                    if( modal_page == 1 ) {
                        $('#orderProductList > div').first().empty().append(res.html);
                    } else {
                        $('#orderProductList > div').first().append(res.html);
                    }

                    if( modal_page * 5 < modal_total ) {
                        $('.orderProductList_addlist').show();
                    } else {
                        $('.orderProductList_addlist').hide();
                    }
                    initEventListener();
                }, error: function (e) {

                }
            });
        }

        const prodAdd = (item)=>{
            var cnt = parseInt( $('.reqCount').first().text() );
            if(!$(item).prev('input').prop('checked')){
                $(item).text('취소');
                $('.reqCount').text( cnt + 1 );
            }else{
                $(item).text('추가');
                $('.reqCount').text( cnt - 1 );
            }
        }

        $('.count_box2 .minus').off().on('click', function(){
                let num = Number($(this).siblings('input').val());
                if(isNaN(num)) {
                    num = 1;
                }
                if (num !== 1) {
                    $(this).siblings('input').val(`${num - 1}`);
                }
                const count = Number($('#requestEstimateProductCount').val()+'');
                $('._requestEstimateCount').text(count + '개');
                if({{ $data['detail']->is_price_open == 0 || $data['detail']->price_text == '수량마다 상이' || $data['detail']->price_text == '업체 문의' ? 1 : 0 }}) {
                    $('._requestEstimateTotalPrice').text("업체 문의");
                } else {
                    $('._requestEstimateTotalPrice').text((count * (price + optionPrice)).toLocaleString('en-US') + '원');
                }
            });

            $('.count_box2 .plus').off().on('click', function(){
                let num = Number($(this).siblings('input').val());
                if(isNaN(num)) {
                    num = 1;
                }
                $(this).siblings('input').val(`${num + 1}`);
                const count = Number($('#requestEstimateProductCount').val()+'');
                $('._requestEstimateCount').text(count + '개');
                if({{ $data['detail']->is_price_open == 0 || $data['detail']->price_text == '수량마다 상이' || $data['detail']->price_text == '업체 문의' ? 1 : 0 }}) {
                    $('._requestEstimateTotalPrice').text("업체 문의");
                } else {
                    $('._requestEstimateTotalPrice').text((count * (price + optionPrice)).toLocaleString('en-US') + '원');
                }
            });
        function initEventListener(){

            $(document).off()
                .on('click', '#orderProductList .plus', function(e) {
                    e.preventDefault();
                    var price = $(this).data('price');
                    var cnt = parseInt( $(this).prev('input').val() ) + 1;

                    console.log( cnt );

                    var tot_price = 0;
                    if( cnt > 0 ) {
                        $(this).prev('input').val( cnt );
                    
                        const options = $(this).parent().parent().parent().parent().find('.option_item');
                        tot_price = $(options[0]).data('itemPrice');
                        for (let index = 0; index < options.length; index++) {
                            const option = options[index];
                            var eachPrice = $(option).data('price');
                            var eachCount = $(option).find('input').val();

                            tot_price += eachPrice * eachCount;
                        }

                        if( price > 0 ) {
                            $(this).parent().parent().parent().parent().parent().find('.prod_option').find('.sub_tot_price').text(tot_price.toLocaleString() + '원');
                            $(this).closest('.prod_option').next('.prod_option').find('.sub_tot_price').text(tot_price.toLocaleString() + '원');
                        }
                    }
                })
                .on('click', '#orderProductList .minus', function(e) {
                    e.preventDefault();
                    var price = $(this).data('price');
                    var cnt = parseInt( $(this).next('input').val() ) - 1;
                    if(cnt < 1) {
                        return;
                    }

                    console.log( cnt );

                    var tot_price = 0;
                    if( cnt > 0 ) {
                        $(this).next('input').val( cnt );
                    
                        const options = $(this).parent().parent().parent().parent().find('.option_item');
                        tot_price = $(options[0]).data('itemPrice');
                        for (let index = 0; index < options.length; index++) {
                            const option = options[index];
                            var eachPrice = $(option).data('price');
                            var eachCount = $(option).find('input').val();

                            tot_price += eachPrice * eachCount;
                        }

                        if( price > 0 ) {
                            $(this).closest('.prod_option').next('.prod_option').find('.sub_tot_price').text(tot_price.toLocaleString() + '원');
                            $(this).parent().parent().parent().parent().parent().find('.prod_option').find('.sub_tot_price').text(tot_price.toLocaleString() + '원');
                        }
                    }
                })
                .on('input', '#request_memo', function() {
                    let inputText = $(this).val();

                    // 입력된 텍스트가 200자를 초과하면 200자까지만 남기고 나머지를 잘라냄
                    if (inputText.length > 200) {
                        $(this).val(inputText.substring(0, 200));
                    }
                })
                .on('click', '.orderProductList_addlist', function() {
                    getWholesalerProductList( {{ $data['detail']->company_idx }} );
                })
                .on('click', '#request_estimate-modal .modal_footer button', function(e) {
                    e.preventDefault();
                
                    @if(isset($data['detail']->product_option) && $data['detail']->product_option != '[]')
                    if($('.opt_result_area')[1].innerText == '') {
                        alert('본 상품의 필수 옵션을 선택해주세요.');
                        return;
                    }
                    const productOption = [];
                    // option
                    $($('.opt_result_area')[0]).find('.option_item').each((idx, ele) => {
                        productOption.push({
                            optionName: $(ele).find('.selection__text').data('name'),
                            optionValue: [{
                                propertyName: $(ele).find('.selection__text').data('option_name'),
                                idx: Number($(ele).find('.ico_opt_remove').data('opt_idx')),
                                count: Number($(ele).find('.count_box2 > input').val()),
                                price: $(ele).find('.selection__text').data('price')
                            }],
                            // 현재 의미가 없음
                            required: "0"
                        });
                    });
                    prodData.append("p_product_option[" + 0 + "]",  JSON.stringify(productOption));
                    @endif

                    prodData.append('p_idx[0]', {{ $data['detail']->idx }});
                    prodData.append('p_cnt[0]', $('#requestEstimateProductCount').val());

                    var i = 1;
                    var isNotChooseOption = false;
                    $('#orderProductList input[type="checkbox"]').each(function(index, element) {
                        const sproductOption = [];
                        if( $(this).is(':checked') ) {
                            const soptions = $(element).parent().parent().find('.info_box > .noline .option_item');
                            for (let jdx = 0; jdx < soptions.length; jdx++) {
                                const soption = soptions[jdx];
                                sproductOption.push({
                                    optionName: $(soption).data('option_title'),
                                    optionValue: [{
                                        propertyName: $(soption).data('option_name'),
                                        idx: Number($(soption).data('option_key').split('_')[0]),
                                        count: Number($(soption).find('.mt-2 > .count_box2 > input').val()),
                                        price: $(soption).data('price')
                                    }],
                                    // 현재 의미가 없음
                                    required: "0"
                                });
                            }
                            if(sproductOption.length > 0) {
                                prodData.append("p_product_option[" + i + "]",  JSON.stringify(sproductOption));
                            }

                            prodData.append("p_idx[" + i + "]", $(element).val() );
                            prodData.append("p_cnt[" + i + "]", $(element).parent().parent().find('input[type=text]').val());

                            i++;
                        }
                    });
                    if(isNotChooseOption) {
                        alert('추가 상품의 필수 옵션을 선택해주세요.');
                        return;
                    }

                    prodData.append('company_idx', $('input[name=request_company_idx]').val());
                    prodData.append('company_type', $('input[name=request_company_type]').val());
                    prodData.append('p_memo', $('#request_memo').val());

                    // prodData 값 확인
                    for (const [key, value] of prodData.entries()) {
                        console.log(key, value);
                    }

                    $.ajax({
                        url: '/wholesaler/wholesalerProduct2',
                        type: 'post',
                        processData: false,
                        contentType: false,
                        data: prodData,
                        success: function (res) {
                            modalClose('#request_estimate-modal');

                            $('#orderProductList2').empty().append(res.html);

                            const idx = 'p_idx';
                            const valCount = prodData.getAll(idx);
                            $('#orderProductList2 .reqCount').text( valCount.length );
                            $('#request_confirm-modal .reqMemo > textarea').val( prodData.get('p_memo') );
                            modalOpen('#request_confirm-modal');
                        }, error: function (e) {

                        }
                    });
                })
                .on('click', '#request_confirm-modal .modal_footer button', function(e) {
                    e.preventDefault();

                    // prodData 값 확인
                    for (const [key, value] of prodData.entries()) {
                        console.log(key, value);
                    }
                    prodData.set('p_memo', $('#request_memo').val());

                    $.ajax({
                        url: '/estimate/insertRequest',
                        type: 'post',
                        processData: false,
                        contentType: false,
                        data: prodData,
                        success: function (res) {
                            console.log( res );
                            $('#loadingContainer').hide();
                            
                            alert('견적서 요청이 완료되었습니다.');
                            location.reload();
                        }, error: function (e) {

                        }
                    });
                })
                .on('click', '.ico_opt_remove', function () {
                    var oidx = $(this).data('opt_idx');
                    $('button[data-opt_idx="'+oidx+'"]').parents('.option_result').remove();
                    //$(this).parents('.option_result').remove();
                    reCal();
                })
                // 수량 변경
                .on('click', '.option_count .btn_minus', function (e) {
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
                })
                // 수량 변경
                .on('click', '.option_count .btn_plus', function (e) {
                    e.preventDefault();
                    var oidx = $(this).parents('.option_count').find("input[name='qty_input']").data('opt_idx');
                    var stat = $(this).parents('.option_count').find("input[name='qty_input']").val();
                    var num = parseInt(stat, 10);
                    num++;
                    $("input[data-opt_idx='"+oidx+"']").val(num);
                    //$(this).parents('.option_count').find("input[name='qty_input']").val(num);
                    reCal();
                })
                .on('keyup', 'input[name=qty_input]', function () {
                    reCal();
                })
                // 옵션 삭제
                .on('click', '.ico_opt_remove', function () {
                    var oidx = $(this).data('opt_idx');
                    $('button[data-opt_idx="'+oidx+'"]').parents('.option_result').remove();
                    //$(this).parents('.option_result').remove();
                    reCal();
                })
            ;
        }
        function openOption(idx, key) {
            $('._productOption_'+idx+'_'+key).toggle();
        }
        function chooseOption(option){
            if(!option) {
                return;
            }

            const priceText = isNaN(Number(option.itemPrice)) ? option.itemPrice : Number(option.price).toLocaleString();

            const tmpHtml = '<div class="option_item" data-option_key="'+option.index+'_'+option.key+'" data-option_title="'+option.name
                                +'" data-option_name="'+option.propertyName+'" data-price="'+option.price+'" data-item-price="'+option.itemPrice+'">'
                            +'    <div class="">'
                            +'        <p class="option_name">'+option.propertyName+'</p>'
                            +'        <button onclick="$(this).parent().parent().remove();"><img src="/img/icon/x_icon2.svg" alt=""></button>'
                            +'    </div>'
                            +'    <div class="mt-2">'
                            +'        <div class="count_box2">'
                            +'            <button class="minus" data-price="'+option.price+'"><svg><use xlink:href="/img/icon-defs.svg#minus"></use></svg></button>'
                            +'            <input type="text" id="product_count_sub_'+option.index+'" name="product_count_sub['+option.index+']" value="1">'
                            +'            <button class="plus" data-price="'+option.price+'"><svg><use xlink:href="/img/icon-defs.svg#plus"></use></svg></button>'
                            +'        </div>'
                            +'        <div class="price">'+priceText+'</div>'
                            +'    </div>'
                            +'</div>';

            $('._productChooseOptions_'+option.index).append(tmpHtml);

            initEventListener();
        }
    </script>
@endsection
