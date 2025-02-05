@extends('layouts.app_m')
@php
    $only_quick = '';
    $header_depth = 'new_arrival';
    $top_title = '';
    $header_banner = '';
@endphp
@section('content')

    <div id="content">
        <div class="prod_detail_top">
            <div class="img_box">
                <a href="javascript:window.history.back()" class="back"><svg><use xlink:href="/img/icon-defs.svg#Notice_arrow"></use></svg></a>
                <div class="count_pager dark_type"><b>1</b> / 12</div>
                <div class="big_thumb">
                    <ul class="swiper-wrapper">
                        @foreach($data['detail']->attachment as $key=>$item)
                        <li class="swiper-slide"><img src="{{$item['imgUrl']}}" alt="{{$data['detail']->name}}"></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="inner">
                <div class="txt_box">
                    <div class="name">
                        @if( ( $data['detail']->is_new_product == 1 && $data['detail']->diff <= 30 ) || $data['detail']->isAd > 0 )
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
                    </div>
                    <div class="info">
                        <p class="product_price" data-total_price={{$data['detail']->price}}>
                            @if( $data['detail']->is_price_open == 1 )
                                {{number_format($data['detail']->price)}}
                            @else
                                {{$data['detail']->price_text}}
                            @endif
                        </p>
                        <!-- 0325추가 -->
                        <div class="">
                            @if( $data['detail']['product_code'] != '' )
                            <div class="flex items-center">
                                <span class="!text-sm text-stone-500 w-16 shrink-0 font-medium">상품 코드</span>
                                <span class="!text-sm w-full">
                                    {{$data['detail']['product_code']}}
                                </span>
                            </div>
                            @endif
                            <div class="flex items-center !mt-2">
                                <span class="!text-sm text-stone-500 w-16 shrink-0 font-medium">배송 방법</span>
                                <span class="!text-sm w-full">{{$data['detail']['delivery_info']}}</span>
                            </div>
                        </div>

                        @if(isset($data['detail']->product_option) && $data['detail']->product_option != '[]')
                            <input type="hidden" name="product_option_exist" value="1" readOnly />
                            <?php $arr = json_decode($data['detail']->product_option); $required = false; ?>
                            @foreach($arr as $item)
                                <div class="dropdown relative my_filterbox mt-3 @if($item->required == 1)required <?php $required = true; ?> @endif">
                                    <a href="javascript:;" class="filter_border filter_dropdown2 w-full h-full flex justify-between items-center">
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
                                    <div class="filter_dropdown2_wrap w-full" style="display: none;">
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
                                {{-- <div class="option_result mt-3 mb-3">
                                    <div class="option_top">
                                        <div>Round - 오디오랙 / 화이트 / 2단 200mm</div>
                                        <button><svg><use xlink:href="./img/icon-defs.svg#x"></use></svg></button>
                                    </div>
                                    <div class="option_count">
                                        <div>
                                            <button><svg><use xlink:href="./img/icon-defs.svg#minus"></use></svg></button>
                                            <input type="text" value="1">
                                            <button><svg><use xlink:href="./img/icon-defs.svg#plus"></use></svg></button>
                                        </div>
                                        <b><span>558,000</span>원</b>
                                    </div>
                                </div> --}}
                            </div>
                        @else
                            <input type="hidden" name="product_option_exist" value="0" readOnly />
                        @endif 

                        {{-- <?php $product_opt = json_decode( $data['detail']['product_option'] ); ?>
                        @if( !empty( $product_opt ) )
                        <div class="pb-8">
                            <table class="my_table w-full text-left">
                                <tbody>
                                @foreach( $product_opt AS $key => $opt )
                                    <?php
                                        $optList = array();
                                        foreach( $opt->optionValue AS $val ) {
                                            $optList[] = $val->propertyName;
                                        }
                                    ?>
                                    <tr>
                                        <th>{{$opt->optionName}}</th>
                                        <td>{{implode( ',', $optList )}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif --}}
                        {{--
                        <div class="dropdown_wrap mt-4">
                            <button class="dropdown_btn">옵션</button>
                            <div class="dropdown_list">
                                <div class="dropdown_item">옵션1</div>
                            </div>
                        </div>
                        --}}
                        <hr>
                        <div class="company_info">
                            <a href="/wholesaler/detail/{{$data['detail']->company_idx}}" class="txt-gray">    
                                <b>{{$data['detail']->companyName}}</b>
                                <span>업체 모든 제품 보러가기 <svg><use xlink:href="/img/icon-defs.svg?08#more_icon_red"></use></svg></span>
                            </a>
                        </div>
                        <div class="link_box">
                            <button class="btn btn-line4 nohover zzim_btn prd_{{ $data['detail']->idx }} {{ ($data['detail']->isInterest == 1) ? 'active' : '' }}" pidx="{{ $data['detail']->idx }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg>좋아요</button>
                            <button class="btn btn-line4 nohover" onclick="copyUrl()"><svg><use xlink:href="/img/icon-defs.svg#share"></use></svg>공유하기</button>
                        </div>
                    </div>
                    <div class="btn_box">
                        <button class="btn btn-line3" onclick="openEstimateModal({{ $data['detail'] -> idx }})"><svg class="w-5 h-5"><use xlink:href="/img/m/icon-defs.svg#estimate_black"></use></svg>견적서 받기</button>
                        <button class="btn btn-primary" onClick="openPhoneDialog('tel:{{$data['detail']->companyPhoneNumber}}')"><svg class="w-5 h-5"><use xlink:href="/img/m/icon-defs.svg#phone_white"></use></svg>전화 걸기</button>
                    </div>
                    <div class="quick_btn_box" onClick="sendMessage()">
                        <button>채팅<br/>문의</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="prod_detail">
            <div class="inner">
                <!-- 0325추가 -->
                @if( !empty( $data['detail']['propertyArray'] ) )
                <div class="pb-8">
                    <table class="my_table w-full text-left">
                        <tbody>
                        @foreach( $data['detail']['propertyArray'] AS $key => $val )
                        <tr>
                            <th>{{$key}}</th>
                            <td>{{$val}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if( trim( $data['detail']['notice_info'] ) )
                    <div class="flex items-start gap-3 p-3 border mt-[-1px]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-volume-2 text-stone-400 shrink-0"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/></svg>
                        <p>{{$data['detail']['notice_info']}}</p>
                    </div>
                    @endif
                </div>
                @endif
                <!-- 0325추가 -->
                <?php echo str_replace('\"', '', str_replace('width: 300px;', 'width: fit-content;',html_entity_decode($data['detail']->product_detail))); ?>
                {{--
                <img src="/img/prod_detail.png" alt="">
                --}}
            </div>
            <!-- 0325추가 -->
            <div class="pt-4">
                <div class="accordion">
                    <div class="bg-stone-100 py-1"></div>
                    <div class="accordion-item">
                        <button class="accordion-header py-4 w-full text-left" type="button">
                            <div class="flex justify-between px-4">
                                <span class="font-medium">결제 안내</span>
                                <div class="accordion_arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down"><path d="m6 9 6 6 6-6"/></svg>
                                </div>
                            </div>
                        </button>
                        <div class="accordion-body hidden p-4 border-t bg-white" style="display: none;">
                            @if( $data['detail']['is_pay_notice'] == 1 )
                                {!! str_replace(["\\\\r\\\\n", "\\r\\n"], '<br>', $data["detail"]["pay_notice"]) !!}
                            @else
                                올톡을 이용하여 문의해주세요
                            @endif
                        </div>
                    </div>
                    <div class="bg-stone-100 py-1"></div>
                    <div class="accordion-item">
                        <button class="accordion-header py-4 w-full text-left" type="button">
                            <div class="flex justify-between px-4">
                                <span class="font-medium">배송 안내</span>
                                <div class="accordion_arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down"><path d="m6 9 6 6 6-6"/></svg>
                                </div>
                            </div>
                        </button>
                        <div class="accordion-body hidden p-4 border-t bg-white" style="display: none;">
                            @if( $data['detail']['is_delivery_notice'] == 1 )
                                {!! str_replace(["\\\\r\\\\n", "\\r\\n"], '<br>', $data["detail"]["delivery_notice"]) !!}
                            @else
                                올톡을 이용하여 문의해주세요
                            @endif
                        </div>
                    </div>
                    <div class="bg-stone-100 py-1"></div>
                    <div class="accordion-item">
                        <button class="accordion-header py-4 w-full text-left" type="button">
                            <div class="flex justify-between px-4">
                                <span class="font-medium">교환/반품/취소 안내</span>
                                <div class="accordion_arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down"><path d="m6 9 6 6 6-6"/></svg>
                                </div>
                            </div>
                        </button>
                        <div class="accordion-body hidden p-4 border-t bg-white" style="display: none;">
                            @if( $data['detail']['is_return_notice'] == 1 )
                                {!! str_replace(["\\\\r\\\\n", "\\r\\n"], '<br>', $data["detail"]["return_notice"]) !!}
                            @else
                                올톡을 이용하여 문의해주세요
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- 0325추가 -->
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
                                    <div class="prod_option opt_result_area ori">
                                    </div>
                                @else
                                <div class="prod_option">
                                    <div class="name">단가</div>
                                    <div class="_requestEstimateTotalPrice">
                                    @if( $data['detail']->is_price_open == 0 || $data['detail']->price_text == '수량마다 상이' || $data['detail']->price_text == '업체 문의' ? 1 : 0 )
                                        {{ $data['detail']->price_text }}
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
                                    <span>'{{ $data['detail']->companyName }}' 업체의 다른 {{ number_format( $data['prdCount'] - 1 ) }}개 상품 추가 선택 가능 합니다.</span>
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


                        <!-- 추가문의사항 -->
                        <dl class="add_textarea mt-7">
                            <dt>추가 문의사항</dt>
                            <dd><textarea name="request_memo" id="request_memo" placeholder="추가 요청사항 입력하세요(200자)"></textarea></dd>
                        </dl>

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
                <button class="close_btn" onclick="modalClose('#request_confirm-modal')"><img src="./pc/img/icon/x_icon.svg" alt=""></button>
            </div>

            <div class="modal_body">
                <div class="relative">
                    <div class="info"><span class="reqCount">1</span>건의 상품을 '{{ $data['detail']->companyName }}'업체에게 견적을 보낼 수 있습니다.</div>
                    <div class="p-7">
                        <!-- 견적 기본정보 -->
                        <div class="fold_area txt_info active">
                            <div class="target title" onclick="foldToggle(this)">
                                <p>견적 기본정보</p>
                                <img class="arrow" src="./pc/img/icon/arrow-icon.svg" alt="">
                            </div>
                            <div>
                                <div class="txt_desc">
                                    <div class="name">총 상품수</div>
                                    <div><b><span class="reqCount">1</span>건</b></div>
                                </div>
                            </div>
                        </div>

                        <!-- 추가문의사항 -->
                        <dl class="add_textarea mb-7">
                            <dt>추가 문의사항</dt>
                            <dd class="txt reqMemo">견적서 수량은 추가 될 수 있습니다. 수량 추가 시 견적관련 전화 문의 드립니다.</dd>
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
                                                    <button><img src="./pc/img/icon/x_icon2.svg" alt=""></button>
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
                                                    <button><img src="./pc/img/icon/x_icon2.svg" alt=""></button>
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
                                                    <button><img src="./pc/img/icon/x_icon2.svg" alt=""></button>
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
<script>
    var isProc = false;
    var optionTmp = [];
    var modal_page = 0;
    var modal_total = {{ $data['prdCount'] - 1 }};
    let prodData = new FormData();

    // thismonth_con01
    const detail_thumb = new Swiper(".prod_detail_top .big_thumb", {
        slidesPerView: 1,
        spaceBetween: 0,
        pagination: {
            el: ".prod_detail_top .count_pager",
            type: "fraction",
        },
    });

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

    $(window).on('scroll load',function(e){
        let detailTop = $('.prod_detail').offset().top;
        let winH = $(window).height();

        if(e.currentTarget.scrollY > (detailTop - (winH/2))){
            $('.prod_detail .info_quick').addClass('active')
        }else{
            $('.prod_detail .info_quick').removeClass('active')
        }
    })

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
                'message'   : '상품 문의드립니다.'
            },
            type            : 'POST',
            dataType        : 'json',
            success        : function(result) {
                if (result.result == 'success') {
                    location.href = "/message/room?room_idx=" + result.roomIdx;
                } else {

                }
            }
        });
    }
    function openPhoneDialog(phoneno){
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
                location.href=phoneno;

                isProc = false;
            }
        });
    }
    
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

    $(".filter_dropdown2").click(function(event){
        $(this).toggleClass('active');
        $(".filter_dropdown2_wrap").toggle();
        $(".filter_dropdown2 svg").toggleClass("active");
        event.stopPropagation(); // 이벤트 전파 방지
    });

    $(".filter_dropdown2_wrap ul li a").click(function(){
        var selectedText = $(this).text();
        $(".filter_dropdown2 p").text(selectedText);
        $(".filter_dropdown2_wrap").hide();
        $(".filter_dropdown2").removeClass('active');
        $(".filter_dropdown2 svg").removeClass("active");
    });

    // 드롭다운 영역 밖 클릭 이벤트
    $(document).click(function(event){
        var $target = $(event.target);
        // 클릭된 요소가 드롭다운 메뉴나 그 자식 요소가 아닐 경우
        if(!$target.closest('.filter_dropdown2').length && $('.filter_dropdown2').hasClass('active')) {
            $('.filter_dropdown2_wrap').hide();
            $('.filter_dropdown2').removeClass('active');
            $(".filter_dropdown2 svg").removeClass("active");
        }
    });

    $(document).on('click', '.dropdown li', function () {
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
                alert('상위 필수 옵션 선택 후 해당 옵션을 선택해주세요.'); return false;
            }

            optionTmp.push({
                'name': $(this).parents('.dropdown').find('.dropdown__title').data('placeholder'),
                'option_name': $(this).data('option_name'),
                'option_price': $(this).data('price'),
            })

            if (requiredCnt > optionTmp.length) {
                return;
            } else {
                $('.selection__result').map(function () {
                    eqCnt = 0;
                    for(i=0; i<optionTmp.length; i++) {
                        //console.log('selected_option_name', $(this).find('.selection__text').text())
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

                        htmlText += '<p class="selection__text" data-name="' + item['name'] + '" data-option_name="' + item['option_name'] + '" data-price="' + item['option_price'] + '">' + item['option_name'] + '</p><button class="ico_opt_remove" data-opt_idx="'+opt_idx+'"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button>';
                    })
                } else {
                    $('._requestEstimateOption').text($(this).data('option_name'));

                    htmlText += '<p class="selection__text" data-name="' + $(this).parents('.dropdown').find('.dropdown__title').data('placeholder') + '" data-option_name="' + $(this).data('option_name') + '" data-price="' + $(this).data('price') + '">' + $(this).data('option_name') + '</p><button class="ico_opt_remove" data-opt_idx="'+opt_idx+'"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button>';
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
            var resultPrice = instancePrice;
            $(this).find('.selection__text').map(function () {
                resultPrice += parseInt($(this).data('price'));
            })
            resultPrice = resultPrice * $(this).parents('.option_result').find('#qty_input').val();
            total_qty += parseInt($(this).parents('.option_result').find('#qty_input').val());
            $(this).find('.selection__price span').text(resultPrice.toLocaleString());
            price += resultPrice;
        });
        
        if (price > 0) {
            $('.product_price').text(price.toLocaleString()+'원');
            $('.product_price').data('total_price', price);
        }else if (price == 0){
            var total = parseInt('{{str_replace(',', '', $data['detail']->price)}}') * total_qty;
            $('.product_price').text(total.toLocaleString()+'원');
            $('.product_price').data('total_price', total);
        }
    }


    $(function(){
        initEventListener();
    });
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
                $('._requestEstimateTotalPrice').text("{{ $data['detail']->price_text }}");
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
                $('._requestEstimateTotalPrice').text("{{ $data['detail']->price_text }}");
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
                        $(this).closest('.prod_option').next('.prod_option').find('.sub_tot_price').text(tot_price.toLocaleString() + '원');
                        $(this).parent().parent().parent().parent().parent().find('.prod_option').find('.sub_tot_price').text(tot_price.toLocaleString() + '원');
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
                @endif

                prodData.append('p_idx[0]', {{ $data['detail']->idx }});
                prodData.append('p_cnt[0]', $('#requestEstimateProductCount').val());

                var i = 1;
                $('#orderProductList input[type="checkbox"]').each(function(index, element) {
                    if( $(this).is(':checked') ) {
                        prodData.append("p_idx[" + i + "]", $(element).val());
                        prodData.append("p_cnt[" + i + "]", $(element).parent().parent().find('input[type=text]').val());

                        var options = $(element).parent().parent().find('.option_item');
                        for (let idx = 0; idx < options.length; idx++) {
                            const option = options[idx];
                            if(!option.checkVisibility()) {
                                return;
                            }
                            prodData.append("product_option_key[" + i + "]", $(option).data('option_key'));
                            prodData.append("product_option_value[" + i + "]",  $(option).data('option_title') + ',' + $(option).data('option_name'));
                        }

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
                        $('#request_confirm-modal .reqMemo').text( prodData.get('p_memo') );
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
            .on('keyup', '#qty_input', function () {
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