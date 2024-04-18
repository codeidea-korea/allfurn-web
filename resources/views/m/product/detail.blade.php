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
                        <p>
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
                        <?php $product_opt = json_decode( $data['detail']['product_option'] ); ?>
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
                        @endif
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
                                <span>업체 보러가기 <svg><use xlink:href="/img/icon-defs.svg#more_icon"></use></svg></span>
                            </a>
                        </div>
                        <div class="link_box">
                            <button class="btn btn-line4 nohover zzim_btn prd_{{ $data['detail']->idx }} {{ ($data['detail']->isInterest == 1) ? 'active' : '' }}" pidx="{{ $data['detail']->idx }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg>좋아요</button>
                            <button class="btn btn-line4 nohover" onclick="copyUrl()"><svg><use xlink:href="/img/icon-defs.svg#share"></use></svg>공유하기</button>
                        </div>
                    </div>
                    <div class="btn_box">
                        <button class="btn btn-line3" onclick="location.href='/mypage/sendRequestEstimate/{{ $data['detail'] -> idx }}'"><svg class="w-5 h-5"><use xlink:href="/img/m/icon-defs.svg#estimate_black"></use></svg>견적서 받기</button>
                        <button class="btn btn-primary" onClick="location.href='tel:{{$data['detail']->companyPhoneNumber}}';"><svg class="w-5 h-5"><use xlink:href="/img/m/icon-defs.svg#phone_white"></use></svg>전화 걸기</button>
                    </div>
                    <div class="quick_btn_box" onClick="location.href='/message';">
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

<script src="/js/jquery-1.12.4.js?{{ date('Ymdhis') }}"></script>
<script>
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
</script>
@endsection