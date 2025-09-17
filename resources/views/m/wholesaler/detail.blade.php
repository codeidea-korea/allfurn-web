@extends('layouts.app_m')
@php
    $only_quick = '';
    $header_depth = 'wholesaler';
    $top_title = '';
    $header_banner = '';
@endphp
@section('content')
@include('layouts.header_m')
<div id="content">
    <div class="company_detail_top">
        <div class="banner" style="background-image:url('@if($data['info']->imgUrl2 != null) {{$data['info']->imgUrl2}} @else /img/company_banner.png @endif')">
            <div class="profile_img">
            <span>{{$data['info']->company_name}}</span>
                <img src="@if($data['info']->imgUrl != null) {{$data['info']->imgUrl}} @else /img/profile_img.svg @endif" alt="">
            </div>
        </div>
        <div class="link_box">
            <button class="addLike {{ ($data['info']->isLike == 1) ? 'active' : '' }}" onClick="addLike({{$data['info']->idx}});" onclick="companyLike(this)"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
            <button onClick="copyUrl();"><svg><use xlink:href="/img/icon-defs.svg#share"></use></svg></button>
        </div>
        <div class="inner">
            <div class="info">
                <div class="left_box">
                    <h3>{{$data['info']->company_name}}</h3>
                    <div class="tag">
                        <p>{{$data['info']->place}}</p>
                        @foreach($data['category'] as $item)
                            <span>{{$item->name}}</span>
                        @endforeach
                    </div>
                </div>
                <div class="right_box">
                    <div class="link_box">
                        <p>
                            좋아요 수
                            <b>{{$data['info']->likeCnt()}}</b>
                        </p>
                        <p>
                            문의 수
                            <b>{{$data['info']->inquiryCnt}}</b>
                        </p>
                        <p>
                            방문 수
                            <b>{{$data['info']->visitCnt}}</b>
                        </p>
                    </div>
                    <div class="btn_box">
                        <button class="btn btn-primary-line phone" onClick="sendMessage()"><svg class="w-5 h-5"><use xlink:href="/img/icon-defs.svg#inquiry"></use></svg>문의하기</button>
                        <button class="btn btn-primary" onClick="openPhoneDialog('tel:{{$data['info']->phone_number}}')"><svg class="w-5 h-5"><use xlink:href="/img/m/icon-defs.svg#phone_white"></use></svg>전화하기</button>
                    </div>
                </div>
            </div>
            @if ($data['info']->notice_title != "" && $data['info']->notice_content)
                <div class="notice_box">
                    <dl class="active">
                        @if ($data['info']->notice_title != "")
                            <dt>
                                <p>
                                    <svg><use xlink:href="/img/icon-defs.svg#Notice_primary"></use></svg>
                                    {{ $data['info']->notice_title }}
                                </p>
                                <svg><use xlink:href="/img/icon-defs.svg#Notice_arrow_black"></use></svg>
                            </dt>
                        @endif 
                        @if ($data['info']->notice_content != "")
                            <dd>
                                {!! nl2br(e($data['info']->notice_content)) !!}
                            </dd>
                        @endif 
                    </dl>
                </div>
            @endif 
        </div>
    </div>

    <div class="company_detail">
        <div class="community_tab">
            <ul>
                <li class="active"><a href="javascript:;">판매 상품</a></li>
                <li><a href="javascript:;">업체 정보</a></li>
            </ul>
        </div>
        <div class="tab_content">
            <!-- 판매상품 -->
            <div class="active">
                @if(count($data['event']) > 0)
                    <div class="box">
                        <div class="inner">
                            <div class="main_tit mb-5">
                                <h3>올펀가구 이벤트 상품</h3>
                            </div>
                            <div class="relative">
                                {{-- <ul class="prod_list grid1 mb-10">
                                    <li class="prod_item type02">
                                        <div class="img_box">
                                            <a href="./prod_detail.php">
                                                <img src="/img/sale_thumb.png" alt="">
                                                <span><b>호텔같은 내 침실로!</b><br>#20조 한정 할인 특가 #호텔형 침대</span>
                                            </a>
                                            <button class="zzim_btn"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                        </div>
                                        <div class="txt_box">
                                            <a href="./prod_detail.php">
                                                <strong>내 침실을 휴향지 호텔 처럼!  20조 한정 할인 특가를 진행합니다.</strong>
                                                <span>올펀가구</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul> --}}
                                <ul class="prod_list">
                                    @foreach( $data['event'] AS $event )
                                        <li class="prod_item">
                                            <div class="img_box">
                                                <a href="/product/detail/{{$event->idx}}"><img loading="lazy" decoding="async" src="{{$event->imgUrl}}" alt=""></a>
                                                <button class="zzim_btn prd_{{ $event->idx }} {{ ($event->isInterest == 1) ? 'active' : '' }}" pidx="{{ $event->idx }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                            </div>
                                            <div class="txt_box">
                                                <a href="/product/detail/{{$event->idx}}">
                                                    <span>{{$event->company_name}}</span>
                                                    <p>{{$event->name}}</p>
                                                    <b>{{$event->is_price_open ? number_format($event->price, 0).'원': $event->price_text}}</b>
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                @if($data['recommend']->count() > 0)
                    <div class="box overflow-hidden">
                        <div class="inner">
                            <div class="main_tit mb-10">
                                <h3>{{$data['info']->company_name}} 추천 상품</h3>
                            </div>
                            <div class="relative recommand_prod">
                                <div class="slide_box prod_slide">
                                    <ul class="swiper-wrapper">
                                        @foreach($data['recommend'] as $item)
                                            <li class="swiper-slide prod_item">
                                                <div class="img_box">
                                                    <a href="/product/detail/{{$item->idx}}"><img loading="lazy" decoding="async" src="{{$item->imgUrl}}" alt=""></a>
                                                    <button class="zzim_btn prd_{{ $item->idx }} {{ ($item->isInterest == 1) ? 'active' : '' }}" pidx="{{ $item->idx }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                                </div>
                                                <div class="txt_box">
                                                    <a href="/product/detail/{{$item->idx}}">
                                                        <span>{{$item->company_name}}</span>
                                                        <p>{{$item->name}}</p>
                                                        <b>{{$item->is_price_open ? number_format($item->price, 0).'원': $item->price_text}}</b>
                                                    </a>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="box">
                    <div class="inner">
                        <div class="sub_filter">
                            <div class="filter_box">
                                <button onclick="modalOpen('#filter_category-modal')">카테고리 <b class='txt-primary'></b></button>
                                <button onclick="modalOpen('#filter_align-modal03')">최신순</button>
                            </div>
                            <div class="total">전체 0개</div>
                        </div>
                        <div class="relative">
                            <ul class="prod_list"></ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 업체정보 -->
            <div class="detail">
                <div class="inner">
                    <div class="info">
                        <table>
                            <colgroup>
                                <col width="100px">
                                <col width="*">
                            </colgroup>
                            <tr>
                                @if($data['info']->owner_name)
                                    <th>대표자</th>
                                    <td>{{$data['info']->owner_name}}</td>
                                @endif
                            </tr>
                            <tr>
                                @if($data['info']->phone_number)
                                    <th>대표전화</th>
                                    <td>@php echo preg_replace('/^(\d{2,3})(\d{3,4})(\d{4})$/', '$1-$2-$3', $data['info']->phone_number); @endphp</td>
                                @endif
                            </tr>
                            <tr>
                                @if ($data['info']->work_day)
                                <th>근무일</th>
                                <td>{{$data['info']->work_day}}</td>
                            @endif
                            </tr>
                            <tr>
                                @if ($data['info']->how_order)
                                    <th>발주방법</th>
                                    <td>{{$data['info']->how_order}}</td>
                                @endif
                            </tr>
                            <tr>
                                @if ($data['info']->manager)
                                    <th>담당자</th>
                                    <td>{{$data['info']->manager}}</td>
                                @endif
                            </tr>
                            <tr>
                                @if ($data['info']->manager_number)
                                    <th>담당자연락처</th>
                                    <td>{{$data['info']->manager_number}}</td>
                                @endif
                            </tr>
                            <tr>
                                @if ($data['info']->business_address)
                                    <th>주소</th>
                                    <td colspan="3">{{$data['info']->business_address .' '.$data['info']->business_address_detail}}</td>    
                                @endif
                            </tr>
                            <tr>
                                @if ($data['info']->website)
                                    <th>웹사이트</th>
                                    <td colspan="3"><a @if(strpos($data['info']->website, 'http') !== false) href="{{$data['info']->website}}" target="_blank" @endif>{{$data['info']->website}}</a></td>    
                                @endif
                            </tr>
                        </table>
                    </div>
                    <?php echo str_replace('\"', '', html_entity_decode($data['info']->introduce)); ?>
                </div>
            </div>

        </div>
    </div>
    <!-- 업체 전화번호 모달 -->
    {{-- <div class="modal" id="company_phone-modal">
        <div class="modal_bg" onclick="modalClose('#company_phone-modal')"></div>
        <div class="modal_inner modal-md">
            <button class="close_btn" onclick="modalClose('#company_phone-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body company_phone_modal">
                <h4><b>업체</b> 전화번호</h4>
                <table>
                    <tr>
                        <th>업체명</th>
                        <td>{{$data['info']->company_name}}</td>
                    </tr>
                    <tr>
                        <th>전화번호</th>
                        <td><b>{{$data['info']->phone_number}}</b></td>
                    </tr>
                </table>
                <button class="btn btn-primary w-full" onclick="modalClose('#company_phone-modal')">확인</button>
            </div>
        </div>
    </div> --}}
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


<script>
    var isProc = false;
    // 상단공지사항
    $('.notice_box dt').on('click',function(){
        $(this).parents('dl').toggleClass('active').siblings().removeClass('active')
    })

    // 판매상품 / 업체 정보 탭
    $('.community_tab li').on('click',function(){
        let liN = $(this).index();

        $(this).addClass('active').siblings().removeClass('active')
        $('.tab_content > div').eq(liN).addClass('active').siblings().removeClass('active')
    })

    // recommand_prod
    const recommand_prod = new Swiper(".recommand_prod .slide_box", {
        slidesPerView: 'auto',
        spaceBetween: 8,

    });

    // 업체 좋아요
    function addLike(idx) {
        if (isProc) {
            return;
        }
        isProc = true;

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url             : '/wholesaler/like/'+idx,
            enctype         : 'multipart/form-data',
            processData     : false,
            contentType     : false,
            data			: {},
            type			: 'POST',
            success: function (result) {
                if (result.success) {
                    if (result.like == 0) {
                        $('.addLike.active').removeClass('active');
                    } else {
                        $('.addLike').addClass('active');
                    }
                } else {
                    alert(reslult.message);
                }

                isProc = false;
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
            url             : '/event/saveUserAction?company_idx={{$data['info']->idx}}&company_type=W&product_idx=&request_type=1',
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
        
        @if($data['info']->idx == Auth::user()['company_idx'])
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

    /* --- 전체 상품 비동기 조회 --- */
    $(document).ready(function(){
        setTimeout(() => {
//            loadProductList();
        }, 50);
    })
    function saveDetail(idx, otherLink){
        sessionStorage.setItem('af5-top', $(document).scrollTop());
        sessionStorage.setItem('af5-currentPage', currentPage);
        sessionStorage.setItem('af5-href', location.href);
        sessionStorage.setItem('af5-backupItem', $($(".prod_list")[0]).html());

        if(otherLink) {
            location.href=otherLink;
        } else {
            location.href='/product/detail/' + idx;
        }
    }
    window.onpageshow = function(ev) {
        if(sessionStorage.getItem("af5-backupItem") && location.href == sessionStorage.getItem("af5-href")){
            $($(".prod_list")[0]).html(sessionStorage.getItem("af5-backupItem"));
            $(document).scrollTop(sessionStorage.getItem("af5-top"));
            currentPage = sessionStorage.getItem("af5-currentPage");
        } else {

            setTimeout(() => {
                loadProductList();
            }, 50);
        }
        sessionStorage.removeItem('af5-backupItem');
        sessionStorage.removeItem('af5-top');
        sessionStorage.removeItem('af5-currentPage');
        sessionStorage.removeItem('af5-refurl');
    }

    window.addEventListener('scroll', function() {
        if ((window.pageYOffset || document.documentElement.scrollTop) + window.innerHeight + 20 >= document.documentElement.scrollHeight && !isLoading && !isLastPage) {
            loadProductList();
        }
    });

    $(document).on('click', '[id^="filter"] .btn-primary', function() { 
        loadProductList(true, $(this));
    });

    // 카테고리 삭제
    const filterRemove = (item)=>{
        $(item).parents('span').remove(); //해당 카테고리 삭제
        $("#" + $(item).data('id')).prop('checked', false);//모달 안 체크박스에서 check 해제

        loadProductList(true);
    }

    let isLoading = false;
    let isLastPage = false;
    let currentPage = 0;
    let firstLoad = true;
    function loadProductList(needEmpty, target) {
        if(isLoading) return;
        if(!needEmpty && isLastPage) return;

        isLoading = true;
        if(needEmpty) currentPage = 0;

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/wholesaler/wholesalerAddProduct',
            method: 'GET',
            data: { 
                'page': ++currentPage,
                'categories' : getIndexesOfSelectedCategory().join(','),
                'orderedElement' : $("#filter_align-modal03 .radio-form:checked").val(),
                'company_idx'   : '{{$data['info']->idx}}'
            }, 
            beforeSend : function() {
                if(target) {
                    target.prop("disabled", true);
                }
            },
            success: function(result) {
                console.log(result);
                if(needEmpty) {
                    $(".box").last().find(".prod_list").empty();
                }
                
                $(".box").last().find(".prod_list").append(result.data.html);

                $(".total").text('전체 ' + result.total.toLocaleString('ko-KR') + '개');

                if(target) {
                    target.prop("disabled", false);
                    modalClose('#' + target.parents('[id^="filter"]').attr('id'));
                }

                isLastPage = currentPage === result.last_page;
            }, 
            complete : function () {
                displaySelectedCategories();
                displaySelectedOrders();
                isLoading = false;
            }
        })
    }

    function getIndexesOfSelectedCategory() {
        let categories = [];
        $("#filter_category-modal .check-form:checked").each(function(){
            categories.push($(this).attr('id'));
        });

        return categories;
    }

    function displaySelectedCategories() {
        let totalOfSelectedCategories = $("#filter_category-modal .check-form:checked").length;
        if(totalOfSelectedCategories === 0) {
            $(".sub_filter .filter_box button").eq(0).find('.txt-primary').text("");
            $(".sub_filter .filter_box button").eq(0).removeClass('on');
        } else {
            $(".sub_filter .filter_box button").eq(0).find('.txt-primary').text(totalOfSelectedCategories);
            $(".sub_filter .filter_box button").eq(0).addClass('on');
        }
    } 

    function displaySelectedOrders() {
        $(".sub_filter .filter_box button").eq(1)
            .text($("#filter_align-modal03 .radio-form:checked").siblings('label').text());
    }

    $(document).ready(function(){
        $(document).on('click', '.my_menu_list a', function(){
            $('#loadingContainer').show();
        });
        $(window).on('load', function(){
            $('#loadingContainer').hide();
        });
    });
</script>
@endsection