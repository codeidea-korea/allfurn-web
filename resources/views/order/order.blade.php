@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
    <div id="container" class="container">
        <div class="inner">
            <div class="content">
                <h2 class="basket__title">주문하기</h2>

                <div class="basket order-info">
                    <div class="basket__container">
                        <ul class="order-info__list">
                            <li class="order-info__desc">

                                <div class="order-info__title">
                                    <h3>주문자 정보</h3>
                                </div>
                                <dl>
                                    <dt>업체명</dt>
                                    <dd>{{$accountInfo->companyName}}</dd>
                                </dl>
                                <dl>
                                    <dt>휴대폰 번호</dt>
                                    <dd>{{preg_replace("/([0-9]{2,3})([0-9]{3,4})([0-9]{4})$/","\\1-\\2-\\3" ,$accountInfo->phone_number)}}</dd>
                                </dl>
                                <dl>
                                    <dt>이메일</dt>
                                    <dd>{{$accountInfo->companyEmail}}</dd>
                                </dl>
                            </li>
                            <li class="order-info__desc">
                                <div class="order-info__title">
                                    <h3>배송지 정보</h3>
                                    <button class="button button--blank-gray" onclick="getAddressBook()">
                                        배송지 선택
                                    </button>
                                </div>
                                <dl>
                                    <dt>수령인</dt>
                                    <dd class="textfield">
                                        <input type="text" class="textfield__input textfield__input--gray" id="delivery_name" oninput="this.value = this.value.replace(/[^ㄱ-ㅎ가-힣a-zA-Z.]/g, '');">
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>연락처</dt>
                                    <dd class="textfield">
                                        <input type="text" class="textfield__input textfield__input--gray" id="delivery_phone" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^(\d{2,3})(\d{3,4})(\d{4})$/, `$1-$2-$3`);">
                                    </dd>
                                </dl>
                                <dl style="align-items: flex-start">
                                    <dt style="margin-top: 10px">배송지</dt>
                                    <dd class="input_guid">
                                        <input type="text" class="input-guid__input" id="delivery_address" placeholder="주소를 검색해주세요." value="" onclick="execPostCode(0)" data-address_idx=0 readonly>
                                        <button type="button" class="input-guid__button" onclick="execPostCode(0)" style="width: 100px">주소 검색</button>

                                        <div class="textfield">
                                            <input type="text" class="textfield__input textfield__input--gray" id="delivery_address_detail" placeholder="상세 주소를 입력해주세요." disabled>
                                        </div>
                                        <input type="hidden" id="delivery_address_zipcode">
                                    </dd>
                                </dl>
                            </li>
                            <li class="order-info__desc">
                                <div class="order-info__title">
                                    <h3>주문 정보</h3>
                                </div>
                                <?php $orderCnt = 0; $orderPrice = 0; $totalPrice = 0; $inquiry = 0; $totalInquiry = 0; ?>
                                @if(isset($orderList))
                                    @foreach($orderList as $key => $order)
                                        @if($key == 0 || $orderList[$key-1]->company_idx != $order->company_idx)
                                            <div class="order-info__container">
                                                <div class="order-info__header">
                                                    <h4>{{$order->companyName}}</h4>
                                                    <p>{{$order->name}} <span class="order_cnt"></span></p>
                                                </div>
                                                <ul>
                                            @endif
                                                    @if($key == 0 || $orderList[$key-1]->product_idx != $order->product_idx)
                                            <li class="order_item_group">
                                                <div class="order-info__content" data-company_idx={{$order->company_idx}}>
                                                    <div class="order-info__detail">
                                                        <div class="order-info__img">
                                                            <img src="{{$order->imgUrl}}" alt="앙상블 2000 슬라이드장">
                                                        </div>
                                                        <div class="order-info__text">
                                                            <h4>{{$order->name}}</h4>
                                                            <ul>
                                                                @endif
                                                                <li class="order_item" data-order_idx={{$order->idx}}>
                                                                    <div class="sub-wrap">
                                                                        <p>
                                                                            <?php $i = 0; ?>
                                                                            @foreach(json_decode($order->option_json) as $option)
                                                                                @if($i > 0) / @endif {{$option->name}}: {{$option->value}}
                                                                                <?php $i++; ?>
                                                                            @endforeach
                                                                        </p>
                                                                    </div>
                                                                    <div class="price-wrap">
                                                                        <p class="price">
                                                                            @if($order->price > 0)
                                                                                <?php
                                                                                    echo number_format($order->price, 0);
                                                                                    $orderPrice += $order->price;
                                                                                    ?> 원
                                                                            @else
                                                                                업체 문의
                                                                                <?php $inquiry = 1; $totalInquiry = 1; ?>
                                                                            @endif
                                                                        </p>
                                                                        <p class="count">{{$order->count}}개</p>
                                                                    </div>
                                                                </li>

                                                                @if($key == count($orderList)-1 || $orderList[$key+1]->product_idx != $order->product_idx)
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="order-info__detail--request">
                                                        <dl>
                                                            <dt>배송 방법</dt>
                                                            <dd>{{$order->delivery_info}}</dd>
                                                        </dl>
                                                        <dl>
                                                            <dt>결제 방식</dt>
                                                            <dd>{{__($order->pay_info)}}</dd>
                                                        </dl>
                                                        <div class="textfield">
                                                            <input type="text" placeholder="추가 요청 사항을 입력해주세요."
                                                                   class="textfield__input textfield__input--gray memo" value="{{$order->memo}}" maxlength="45">
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            @endif
                                            @if($key == count($orderList)-1 || $orderList[$key+1]->company_idx != $order->company_idx)
                                        </ul>
                                        <dl class="order-info__footer">
                                            <dt>주문 금액</dt>
                                            <dd>
                                                @if($orderPrice > 0)
                                                    <span>
                                                        <?php
                                                            echo number_format($orderPrice, 0);
                                                            $totalPrice += $orderPrice;
                                                        ?>
                                                    </span>원
                                                @endif
                                                @if ($inquiry > 0)
                                                    <span>(협의 포함)</span>
                                                @endif
                                            </dd>
                                        </dl>
                                    </div>
                                    <?php $orderCnt = 0; $orderPrice = 0; $inquiry = 0; ?>
                                    @endif
                                    @endforeach
                                @elseif($isCart == 0)
                                    <div class="order-info__container">
                                        <div class="order-info__header">
                                            <h4>{{$productInfo->companyName}}</h4>
                                            <p>{{$productInfo->name}}<span class="order_cnt"></span></p>
                                        </div>
                                        <ul>
                                            <li class="order_item_group">
                                                <div class="order-info__content" data-company_idx="82">
                                                    <div class="order-info__detail">
                                                        <div class="order-info__img">
                                                            <img src="{{$productInfo->attachment[0]->imgUrl}}" alt="{{$productInfo->name}}">
                                                        </div>
                                                        <div class="order-info__text">
                                                            <h4>{{$productInfo->name}}</h4>
                                                            <?php $optionList = json_decode($_GET['option']); $totalInquiry = $productInfo->is_price_open == 1 ? 0 : 1; ?>
                                                            <ul>
                                                                @foreach($optionList as $items)
                                                                    <li class="order_item" data-order_idx="">
                                                                        <div class="sub-wrap">
                                                                            @foreach($items as $key=>$item)
                                                                                @if($key > 0)
                                                                                    <p>
                                                                                        {{$item->name}}: {{$item->value}}
                                                                                    </p>
                                                                                    <?php $orderPrice += $item->price; ?>
                                                                                @else
                                                                                    <?php $orderPrice = $item->price; $orderCnt = $item->count; ?>
                                                                                @endif

                                                                            @endforeach

                                                                        </div>
                                                                        <div class="price-wrap">
                                                                            <p class="price">
                                                                                @if($productInfo->is_price_open == 1)
                                                                                    {{number_format($orderPrice)}} 원
                                                                                @else
                                                                                    {{$productInfo->price_text}}
                                                                                @endif
                                                                            </p>
                                                                            <p class="count">{{$orderCnt}}개</p>
                                                                            <?php $totalPrice += $orderPrice * $orderCnt; ?>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="order-info__detail--request">
                                                        <dl>
                                                            <dt>배송 방법</dt>
                                                            <dd>{{$productInfo->delivery_info}}</dd>
                                                        </dl>
                                                        <dl>
                                                            <dt>결제 방식</dt>
                                                            <dd>
                                                                @if($productInfo->pay_type != 4)
                                                                    {{__('product.payType_'.$productInfo->pay_type)}}
                                                                @else
                                                                    {{$productInfo->pay_type_text}}
                                                                @endif
                                                            </dd>
                                                        </dl>
                                                        <div class="textfield">
                                                            <input type="text" placeholder="추가 요청 사항을 입력해주세요." class="textfield__input textfield__input--gray memo" value="" maxlength="45" kl_vkbd_parsed="true">
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <dl class="order-info__footer">
                                            <dt>주문 금액</dt>
                                            <dd>
                                                @if($productInfo->is_price_open == 1)
                                                    <span>{{number_format($totalPrice)}}</span>원
                                                @else
                                                    <span>{{$productInfo->price_text}}</span>
                                                @endif
                                            </dd>
                                        </dl>
                                    </div>
                                @endif
                            </li>
                        </ul>
                    </div>

                    <div class="basket__order">
                        <div class="order">
                            <div class="order__price">
                                <p class="text">총 주문 금액</p>
                                <div class="price__num-wrap">
                                    @if($totalPrice > 0)
                                        <p class="num"><span>{{number_format($totalPrice, 0)}}</span> 원</p>
                                    @endif
                                    @if($totalInquiry > 0)
                                        <p class="attc">(협의 포함)</p>
                                    @endif
                                </div>
                            </div>
                            <div class="order__button">
                                <button type="button" class="button button--solid" onclick="makeOrder()">주문완료</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 배송지 선택 팝업 -->
            <div id="default-modal" class="default-modal default-modal--address-select">
                <div class="default-modal__container">
                    <div class="default-modal__header">
                        <h2>배송지 선택</h2>
                        <button type="button" class="ico__close28" onclick="closeModal('#default-modal')">
                            <span class="a11y">닫기</span>
                        </button>
                    </div>
                    <div class="default-modal__content">
                        <ul id="addressBook"></ul>
                    </div>
                    <div class="default-modal__footer"></div>
                </div>
            </div>

            <!-- 배송지 수정 팝업 -->
            <div id="default-modal--address-edit" class="default-modal default-modal--address-edit">
                <div class="default-modal__container">
                    <div class="default-modal__header">
                        <h2>배송지 수정</h2>
                        <button type="button" class="ico__close28" onclick="closeModal('#default-modal--address-edit')">
                            <span class="a11y">닫기</span>
                        </button>
                    </div>
                    <div class="default-modal__content">
                        <dl>
                            <dt>수령인</dt>
                            <dd class="textfield">
                                <input type="text" value="홍길동" class="textfield__input textfield__input--gray" id="modify_delivery_name" oninput="this.value = this.value.replace(/[^가-힣][^a-z][^A-Z]/g, '');">
                            </dd>
                        </dl>
                        <dl>
                            <dt>연락처</dt>
                            <dd class="textfield">
                                <input type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^(\d{2,3})(\d{3,4})(\d{4})$/, `$1-$2-$3`);" value="01012345678" class="textfield__input textfield__input--gray" id="modify_delivery_phone">
                            </dd>
                        </dl>
                        <dl style="align-items: flex-start">
                            <dt style="margin-top: 10px">배송지</dt>
                            <dd class="input_guid">
                                <input type="text" class="input-guid__input" id="modify_delivery_address" value="서울시 성동구 아차산로 126 613호 앱노트" onclick="execPostCode(1)" readonly>
                                <button type="button" class="input-guid__button" onclick="execPostCode(1)" style="width: 100px">주소 검색</button>

                                <div class="textfield">
                                    <!-- <input type="text" class="textfield__input textfield__input--gray"> -->
                                    <textarea rows="10" class="textfield__input textfield__input--gray" id="modify_delivery_address_detail">111-10</textarea>
                                </div>
                                <input type="hidden" id="modify_delivery_address_zipcode">
                            </dd>
                        </dl>
                    </div>
                    <div class="default-modal__footer">
                        <button type="button" class="button button--blank-gray"
                                onclick="closeModal('#default-modal--address-edit')">
                            취소
                        </button>
                        <button type="button" class="button button--solid" onclick="modifyAddress()">저장</button>
                    </div>
                </div>
            </div>

            <!-- 배송지 삭제 팝업 -->
            <div id="alert-modal08" class="alert-modal">
                <div class="alert-modal__container">
                    <div class="alert-modal__top">
                        <p>
                            배송지를 삭제하시겠습니까?
                        </p>
                    </div>
                    <div class="alert-modal__bottom">
                        <div class="button-group">
                            <button type="button" class="button button--solid-gray" onclick="closeModal('#alert-modal08')">
                                취소
                            </button>
                            <button type="button" class="button button--solid removeBtn">
                                확인
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script defer src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js?autoload=false"></script>
    <script>

        // 주소록 가져오기
        function getAddressBook() {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url				: '/member/getAddressBook',
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                data			: {},
                type			: 'POST',
                dataType		: 'json',
                xhrFields: {
                    withCredentials: false
                },
                success		: function(result) {
                    textHtml = '';
                    if (result.data.length > 0) {
                        result.data.forEach(function (item) {
                            textHtml += '<li data-address_idx=' + item.idx + '>' +
                                '<h3 class="name">' + item.name + '</h3>' +
                                '<p class="num">' + item.phone_number.replace(/[^0-9]/g, '').replace(/^(\d{2,3})(\d{3,4})(\d{4})$/, `$1-$2-$3`) + '</p>' +
                                '<p class="add">' +
                                '<span class="address_1">' + item.address1 + '</span><span class="address_2">' + item.address2 + '</span>' +
                                '<span class="zipcode" style="display: none;">' + item.zipcode + '</span>' +
                                '</p>' +
                                '<div class="content__button-group">' +
                                '<div>' +
                                '<button type="button" class="button button--blank-gray" onclick="remove(' + item.idx + ')">' +
                                '삭제' +
                                '</button>' +
                                '<button type="button" class="button button--blank-gray" onclick="modify(' + item.idx + ')">' +
                                '수정' +
                                '</button>' +
                                '</div>' +
                                '<button type="button" class="button button--solid" onclick="selectAddress(' + item.idx + ')">선택</button>' +
                                '</div>' +
                                '</li>'
                        });

                        $('#addressBook').html(textHtml);
                    } else {
                        $('#addressBook').html('<li>' +
                            '<h3 class="name">등록된 배송지가 없습니다.</h3>' +
                            '</li>');
                    }

                    openModal('#default-modal');
                }
            });
        }

        // 주소록 삭제 팝업 노출
        function remove(idx) {
            $('#alert-modal08 .removeBtn').attr('onclick', 'removeAddress(' + idx + ')');
            openModal('#alert-modal08');
        }

        // 주소록 삭제
        function removeAddress(idx) {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url				: '/member/addressBook/'+idx,
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                type			: 'DELETE',
                dataType		: 'json',
                success		: function(result) {
                    if (result.success) {
                        $('#default-modal li[data-address_idx='+idx+']').remove();
                        closeModal('#alert-modal08');
                    }
                }
            });
        }

        // 주소록 수정 팝업 노출
        function modify(idx) {
            $('#default-modal--address-edit').data('address_idx', idx);
            $('#modify_delivery_name').val($('#addressBook li[data-address_idx='+idx+'] .name').text());
            $('#modify_delivery_phone').val($('#addressBook li[data-address_idx='+idx+'] .num').text());
            $('#modify_delivery_address').val($('#addressBook li[data-address_idx='+idx+'] .address_1').text());
            $('#modify_delivery_address_detail').val($('#addressBook li[data-address_idx='+idx+'] .address_2').text());
            $('#modify_delivery_address_zipcode').val($('#addressBook li[data-address_idx='+idx+'] .zipcode').text());

            $('#modify_delivery_address').prop('disabled', true);

            openModal('#default-modal--address-edit');
        }

        // 주소록 수정
        function modifyAddress() {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url				: '/member/modifyAddressBook',
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                data			: {
                    'addressIdx'    : $('#default-modal--address-edit').data('address_idx'),
                    'name'          : $('#modify_delivery_name').val(),
                    'phone'         : $('#modify_delivery_phone').val().replace(/\-/g,''),
                    'address'       : $('#modify_delivery_address').val(),
                    'addressDetail' : $('#modify_delivery_address_detail').val(),
                    'zipcode'       : $('#modify_delivery_address_zipcode').val()
                },
                type			: 'POST',
                dataType		: 'json',
                success		: function(result) {
                    if (result.success) {
                        let idx = $('#default-modal--address-edit').data('address_idx');
                        let base = '#addressBook li[data-address_idx='+idx+']';

                        $(base + ' .name').text($('#modify_delivery_name').val());
                        $(base + ' .num').text($('#modify_delivery_phone').val());
                        $(base + ' .address_1').text($('#modify_delivery_address').val());
                        $(base + ' .address_2').text($('#modify_delivery_address_detail').val());
                        $(base + ' .zipcode').text($('#modify_delivery_address_zipcode').val());
                    }

                    closeModal('#default-modal--address-edit');
                }
            });
        }

        // 선택한 주소록으로 바인딩
        function selectAddress(idx) {
            $('#delivery_name').val($('#default-modal li[data-address_idx='+idx+'] .name').text());
            $('#delivery_phone').val($('#default-modal li[data-address_idx='+idx+'] .num').text());
            $('#delivery_address').val($('#default-modal li[data-address_idx='+idx+'] .address_1').text());
            $('#delivery_address_detail').removeAttr('disabled');
            $('#delivery_address_detail').val($('#default-modal li[data-address_idx='+idx+'] .address_2').text());
            $('#delivery_address_zipcode').val($('#default-modal li[data-address_idx='+idx+'] .zipcode').text());
            $('#delivery_address').data('address_idx', idx);
            closeModal('#default-modal');
        }

        // 우편번호/주소 검색
        function execPostCode(popup) {
            daum.postcode.load(function() {
                new daum.Postcode({
                    oncomplete: function(data) {
                        var addr = '';

                        if (data.userSelectedType === 'R') {
                            addr = data.roadAddress;
                        } else {
                            addr = data.jibunAddress;
                        }
                        if (popup != 1) {
                            $('#delivery_address').val(addr);
                            $('#delivery_address_detail').removeAttr('disabled');
                            $('#delivery_address_detail').val('');
                            $('#delivery_address_detail').focus();
                            $('#delivery_address_zipcode').val(data.zonecode);
                            $('#delivery_address').data('address_idx', 0);

                        } else {
                            $('#modify_delivery_address').val(addr);
                            $('#modify_delivery_address_detail').removeAttr('disabled');
                            $('#modify_delivery_address_detail').val('');
                            $('#modify_delivery_address_detail').focus();
                            $('#modify_delivery_address_zipcode').val(data.zonecode);
                        }

                    }
                }).open();
            });
        }

        // 주문하기
        function makeOrder() {
            if ($('#delivery_name').val() == '' || $('#delivery_phone').val() == '' || $('#delivery_address').val() == '' || $('#delivery_address_detail').val() == '') {
                alert("배송지 정보를 입력해주세요.");
                return;
            }

            var orderList = new Array();
            $('.order-info__content').map(function () {
                var order = new Object();
                order.company_idx = $(this).data('company_idx');
                order.memo = $(this).find('.memo').val();

                @if($isCart == 1)
                    order.idx = new Array();
                    $(this).find('.order_item').map(function () {
                        order.idx.push($(this).data('order_idx').toString());
                    })
                @else
                    order.productIdx = {{$_GET['productIdx']}};
                    order.productName = $('.order-info__text h4').text();
                    order.required = {{$_GET['required']}};
                    <?php
                       $parsedOption = json_decode($_GET['option'], true);
                       $order_option = json_encode($parsedOption) . ";";
                    ?>
                    order.option = <?= $order_option ?>;
                    // order.option = JSON.parse('{{$_GET['option']}}');
                @endif

                orderList.push(order);
            })

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url				: '/order/makeOrder',
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                data			: {
                    'isCart'        : {{$isCart}},
                    'orderList'     : orderList,
                    'name'          : $('#delivery_name').val(),
                    'phone'         : $('#delivery_phone').val().replace(/\-/g,''),
                    'address'       : $('#delivery_address').val(),
                    'addressDetail' : $('#delivery_address_detail').val(),
                    'zipcode'       : $('#delivery_address_zipcode').val(),
                    'is_new_address': $('#delivery_address').data('address_idx') == 0 ? 1 : 0
                },
                type			: 'POST',
                dataType		: 'json',
                success		: function(result) {
                    if (result.success) {
                        location.href='/order/success/'+result.message;
                    } else {
                    }
                }
            });
        }

        // 멀티건일경우 묶음 처리
        $(document).ready(function() {
            $('.order-info__container').map(function() {
                let cnt = $(this).find('.order-info__detail--request .memo').length -1;

                if (cnt == 0) {
                    $(this).find('.order_cnt').text('');
                } else {
                    $(this).find('.order_cnt').text('외 ' + cnt + '건');
                }
            })
        });
    </script>
@endsection
