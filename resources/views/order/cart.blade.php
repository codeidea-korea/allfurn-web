@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
    <div id="container" class="container">
        <div class="inner">
            <div class="content">
                <h2 class="basket__title">장바구니</h2>
                <!-- class active 삭제시 장바구니 상품없음 노출 -->
                @if(count($cartList) > 0 )
                <div class="basket active">
                    <div class="basket__container">
                        <div class="basket__selected--all">
                            <label for="selected--all" class="category__check category__check--bold basket__check">
                                <input type="checkbox" id="selected--all">
                                <span>전체선택</span>
                            </label>
                            <p onclick="checkRemove()">선택 삭제</p>
                        </div>

                        <ul class="basket__card-wrap">
                        <?php $cartCnt = 0; $cartPrice = 0; $totalPrice = 0; $inquiry = 0; $totalInquiry = 0;?>
                        @foreach($cartList as $key => $item)
                            @if($key == 0 || $cartList[$key-1]->company_idx != $item->company_idx)
                                <li class="basket__card" style="position: relative;">
                                    <div class="card__head">
                                        <label for="selected_{{$item->company_idx}}" class="category__check category__check--bold basket__check">
                                        <input type="checkbox" class="checkbox company" id="selected_{{$item->company_idx}}" data-company_idx={{$item->company_idx}}>
                                        <span>{{$item->companyName}}</span>
                                    </label>
                                        <a href="/wholesaler/detail/{{$item->company_idx}}" title="업체 보러가기">
                                        업체 보러가기
                                        <i class="ico__arrow--right14">
                                            <span class="a11y">오른쪽화살표</span>
                                        </i>
                                    </a>
                                    </div>
                                    @foreach($cartList as $key => $productList)
                                        @if($item->company_idx == $productList->company_idx && ($key == 0 || $cartList[$key -1]->product_idx != $productList->product_idx))
                                            <div class="card__content" data-product_idx="{{$productList->product_idx}}" style="position: relative; border-top: 1px solid #DBDBDB;">
                                                <div class="content__head">
                                                    <label for="selected_{{$productList->product_idx}}" class="category__check category__check--bold basket__check">
                                                        <input type="checkbox" class="checkbox product" id="selected_{{$productList->product_idx}}" data-product_idx={{$productList->product_idx}} data-is_price_open={{$productList->is_price_open}} @if($productList->state == 'O') disabled @endif >
                                                        <span>@if($productList->state == 'O')(품절)@endif {{$productList->name}}</span>
                                                    </label>
                                                    <button class="ico__delete18" onclick="removeProduct({{$productList->product_idx}})">
                                                        <span class="a11y">삭제</span>
                                                    </button>
                                                </div>

                                                <div class="content__desc">
                                                    <div onclick="goToProduct({{$productList->product_idx}})" class="desc__img">
                                                        <img src="{{$productList->imgUrl}}" alt="상품이미지">
                                                    </div>
                                                    <ul class="selection_list">
                                                        @foreach($cartList as $cart)
                                                            @if($productList->product_idx == $cart->product_idx)
                                                                <li class="selection__result" data-product_idx="{{$cart->product_idx}}" data-cart_idx="{{$cart->idx}}" data-price={{$cart->price}} >
                                                                    <div class="selection__text">
                                                                        <ul>
                                                                            <?php $json = json_decode($cart->option_json); ?>
                                                                            <li data-required=@if(isset($json[0]->required)) {{$json[0]->required}} @else 1 @endif data-price={{$cart->productPrice}} >
                                                                                @if(isset($json[0]->required) && $json[0]->required == 0)
                                                                                    추가 옵션
                                                                                @else
                                                                                    @if(strlen(trim($cart->name)) >= 40)
                                                                                        {{mb_strimwidth($cart->name, 0, 40, "...")}}
                                                                                    @else
                                                                                        {{$cart->name}}
                                                                                    @endif
                                                                                @endif
                                                                            </li>
                                                                            @foreach($json as $option)
                                                                                <li data-price="{{$option->price}}">{{$option->value}}</li>
                                                                            @endforeach
                                                                        </ul>
                                                                        <button class="ico__delete18" onclick="removeCart({{$cart->idx}})">
                                                                            <span class="a11y">삭제</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="selection__box">
                                                                        <ul class="selection__count">
                                                                            <li class="count__minus">
                                                                                <button type="button" class="btn_minus">
                                                                                    <i class="ico__count--minus"><span class="a11y">빼기</span></i>
                                                                                </button>
                                                                            </li>
                                                                            <li class="count__text" style="width: 30px;">
                                                                                <input type="text" name="qty_input" value="{{$cart->count}}" style="width:100%;height:100%;text-align: center;" data-each_price={{$cart->each_price}} min="1" maxlength="3" oninput="numberMaxLength(this);" />
                                                                            </li>
                                                                            <li class="count__plus">
                                                                                <button type="button" class="btn_plus"><i class="ico__count--plus"><span class="a11y">더하기</span></i></button>
                                                                            </li>
                                                                        </ul>
                                                                        <p class="selection__price" >
                                                                            @if($cart->is_price_open != 0)
                                                                                <span class="price"><?php echo number_format($cart->price, 0); ?></span><span>원</span>
                                                                                <?php $cartPrice += $cart->price; ?>
                                                                            @else
                                                                                <span class="price">@if($cart->price_text != '') {{$cart->price_text}} @else 업체 문의 @endif</span>
                                                                                    <?php $inquiry ++; $totalInquiry ++; ?>
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="content__footer">
                                                    <dl>
                                                        <dt>배송 방법</dt>
                                                        <dd>{{$productList->delivery_info}}</dd>
                                                    </dl>
                                                    <dl>
                                                        <dt>결제 방식</dt>
                                                        <dd>{{__($productList->payInfo)}}</dd>
                                                    </dl>
                                                </div>
                                                @if($productList->state == 'O')
                                                    <div class="dim" style="position: absolute; width: 100%; height: 100%; background-color: #ffffff80; top: 0;"></div>
                                                @endif
                                            </div>

                                            <div class="card__footer" data-product_idx={{$productList->product_idx}} style="position: relative;">
                                                <dl>
                                                    <dt>주문 금액</dt>
                                                    <dd>
                                                        @if($cartPrice > 0)
                                                            <span>
                                                                <?php
                                                                    echo number_format($cartPrice, 0);
                                                                    $totalPrice += $cartPrice;

                                                                ?>
                                                            </span>원
                                                        @endif
                                                        @if($inquiry > 0)
                                                            (협의 포함)
                                                        @endif
                                                    </dd>
                                                </dl>
                                                <div class="footer__button-group">
                                                    @if($productList->product_option != "[]")
                                                        <button type="button" class="button button--blank-gray" onclick="getOptions({{$productList->product_idx}})" @if($productList->state == 'O') disabled @endif>옵션 변경</button>
                                                    @endif
                                                    <button type="button" class="button button--blank" onclick="makeOrderForm({{$productList->product_idx}})" @if($productList->state == 'O') disabled @endif>바로 주문</button>
                                                </div>
                                                @if($productList->state == 'O')
                                                    <div class="dim" style="position: absolute; width: 100%; height: 100%; background-color: #ffffff80; top: 0;"></div>
                                                @endif
                                            </div>
                                            <?php $cartCnt = 0; $cartPrice = 0; $inquiry = 0; ?>
                                        @endif
                                    @endforeach
                                </li>
                            @endif
                        @endforeach
                        </ul>
                    </div>

                    <div class="basket__order">
                        <div class="order">
                            <div class="order__price">
                                <p class="text">총 주문 금액</p>
                                <div class="price__num-wrap">
                                        <p class="num" style="display: none;"><span></span> 원</p>
                                        <p class="attc" style="display: none;">(협의 포함)</p>
                                </div>
                            </div>
                            <div class="order__button">
                                <button type="button" class="button button--solid" onclick="makeOrderForm(0)" disabled>주문하기</button>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="basket__no-product">
                    <div class="no-product__wrap">
                        <div class="ico__search--circle">
                            <i class="ico__search--white"><span class="a11y">검색</span></i>
                        </div>
                        <p>장바구니에 담긴 상품이 없습니다.</p>
                        <a href="{{ route('product.new')}}"><span>올펀 상품 보러가기</span></a>
                    </div>
                </div>
                @endif

                <!-- 팝업 -->
                <div id="default-modal" class="default-modal default-modal--option">
                    <div class="default-modal__container">
                        <div class="default-modal__header">
                            <h2>옵션 변경</h2>
                            <button type="button" class="ico__close28" onclick="closeModal('#default-modal')">
                                <span class="a11y">닫기</span>
                            </button>
                        </div>
                        <div class="default-modal__content">
                            <div class="content__head">
                                <div class="head__img-wrap">
                                    <img src="/images/temp/basket_product@2x.png" alt="포그니 라운드 소파">
                                </div>
                                <div class="head__text-wrap">
                                    <h3>포그니 라운드 소파</h3>
                                    <dl>
                                        <dt>배송 방법</dt>
                                        <dd></dd>
                                    </dl>
                                    <dl>
                                        <dt>결제 방식</dt>
                                        <dd></dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="content__desc">
                                <div class="desc__box--gray">
                                    <div class="box__icon">
                                        <i class="ico__info"><span class="a11y">정보</span></i>
                                    </div>
                                    <p class="box__text">
                                        원하는 옵션이 없거나 커스텀 주문을 희망하시면 필수 옵션 선택 후<br>
                                        [바로 주문] 버튼을 클릭하여 주문 요청사항에 작성해주세요.
                                    </p>
                                </div>
                                <div class="option_list"></div>
                                <div class="selection__pre"></div>
                                <div class="selection__res"></div>
                            </div>
                        </div>
                        <div class="default-modal__footer">
                            <div>
                                <p class="order">주문 금액</p>
                                <p class="price"></p>
                            </div>
                            <button type="button" class="button button--solid order" onclick="addCart()">옵션 변경</button>
                        </div>
                    </div>
                </div>

                <!-- 장바구니 상품 선택 삭제 팝업 -->
                <div id="alert-modal06" class="alert-modal">
                    <div class="alert-modal__container">
                        <div class="alert-modal__top">
                            <p>
                                <span>00</span>개의 상품을<br>
                                장바구니에서 삭제하시겠습니까?
                            </p>
                        </div>
                        <div class="alert-modal__bottom">
                            <div class="button-group">
                                <button type="button" class="button button--solid-gray" onclick="closeModal('#alert-modal06')">
                                    취소
                                </button>
                                <button type="button" class="button button--solid" name="remove_btn" data-target="alert-modal06" data-type="selected">
                                    확인
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 장바구니 상품 선택 삭제 팝업 -->
                <div id="alert-modal08" class="alert-modal">
                    <div class="alert-modal__container">
                        <div class="alert-modal__top">
                            <p>
                                삭제할 상품을 선택해 주세요.
                            </p>
                        </div>
                        <div class="alert-modal__bottom">
                            <div class="button-group">
                                <button type="button" class="button button--solid" onclick="closeModal('#alert-modal08')">
                                    확인
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 장바구니 상품 삭제 팝업 -->
                <div id="alert-modal07" class="alert-modal">
                    <div class="alert-modal__container">
                        <div class="alert-modal__top">
                            <p>
                                해당 상품을<br>
                                장바구니에서 삭제하시겠습니까?
                            </p>
                        </div>
                        <div class="alert-modal__bottom">
                            <div class="button-group">
                                <button type="button" class="button button--solid-gray" onclick="closeModal('#alert-modal07')">
                                    취소
                                </button>
                                <button type="button" class="button button--solid" name="remove_btn" data-target="alert-modal07" data-type="product">
                                    확인
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 옵션 삭제 팝업 -->
                <div id="alert-modal02" class="alert-modal">
                    <div class="alert-modal__container">
                        <div class="alert-modal__top">
                            <p>옵션을 삭제하시겠습니까?</p>
                        </div>
                        <div class="alert-modal__bottom">
                            <div class="button-group">
                                <button type="button" class="button button--solid-gray" onclick="closeModal('#alert-modal02')">
                                    취소
                                </button>
                                <button type="button" class="button button--solid" name="remove_btn" data-target="alert-modal02" data-type="cart">
                                    확인
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 팝업 옵션 삭제 팝업 -->
                <div id="alert-modal02" class="alert-modal" >
                    <div class="alert-modal__container">
                        <div class="alert-modal__top">
                            <p>옵션을 삭제하시겠습니까?</p>
                        </div>
                        <div class="alert-modal__bottom">
                            <div class="button-group">
                                <button type="button" class="button button--solid-gray" onclick="closeModal('#alert-modal02')">
                                    취소
                                </button>
                                <button type="button" class="button button--solid" name="remove_btn" data-target="alert-modal02" data-type="cart" data-isModal=true data-idx="">
                                    확인
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 장바구니 상품 상태 변경 -->
                <div id="alert-modal03" class="alert-modal">
                    <div class="alert-modal__container">
                        <div class="alert-modal__top">
                            <p>
                                주문하신 상품 <span></span>로 주문하실수없습니다.
                            </p>
                        </div>
                        <div class="alert-modal__bottom">
                            <div class="button-group">
                                <button type="button" class="button button--solid" onclick="closeModal('#alert-modal03')">
                                    확인
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 옵션 중복 팝업 -->
                <div id="alert-modal09" class="alert-modal">
                    <div class="alert-modal__container">
                        <div class="alert-modal__top">
                            <p>이미 선택한 옵션입니다. 다시 선택해주세요</p>
                        </div>
                        <div class="alert-modal__bottom">
                            <button type="button" class="button button--solid" onclick="closeModal('#alert-modal09')">
                                확인
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 필수 옵션 미선택 팝업 -->
                <div id="alert-modal10" class="alert-modal">
                    <div class="alert-modal__container">
                        <div class="alert-modal__top">
                            <p>필수 옵션 선택 후 선택해주세요</p>
                        </div>
                        <div class="alert-modal__bottom">
                            <button type="button" class="button button--solid" onclick="closeModal('#alert-modal10')">
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
    <script>
        var optionTmp = [];

        // 장바구니 가격 계산
        function reCal() {
            var totalPrice = 0;
            var isPriceOpen = true;

            $('.checkbox.product:checked').map(function () {
                if ($(this).data('is_price_open') == 0 ) {
                    isPriceOpen = false;
                } else {
                    $(this).parents('.card__content').find('.selection__result').map(function () {
                        var price = 0;
                        $(this).find('.selection__text li').map(function () {
                            price += parseInt($(this).data('price'));
                        })
                        totalPrice += price * $(this).find('input[name="qty_input"]').val();
                    })
                }
            })

            var totalPriceStr = totalPrice.toLocaleString();
            $('.order .num span').text(totalPriceStr);
            $('.order .num').css('display', 'block');

            if (!isPriceOpen) {
                $('.order .attc').css('display', 'block');
            } else {
                $('.order .attc').css('display', 'none');
            }
        }

        // 옵션 변경 가격 계산
        function modalReCal() {
            $('#default-modal .default-modal__footer button').prop('disabled', false);

            if ($('.product[data-product_idx="' + $('#default-modal').data('product_idx') + '"]').data('is_price_open') == '0') {
                $('#default-modal .default-modal__footer .price').text($('#default-modal .selection__prev:first-child .price').text());
                return;
            }

            var totalprice = 0;
            $('#default-modal .selection__prev, #default-modal .selection__result').map(function () {
                price = 0;
                $(this).find('.selection__text li').map(function () {
                    price += $(this).data('price');
                })
                price = price * $(this).find('input[name="qty_input"]').val();
                totalprice += price;
                console.log(price);
                $(this).find('.selection__price .price').text(price.toLocaleString());
            })

            $('#default-modal .default-modal__footer .price').text(totalprice.toLocaleString()+'원');
            $('#default-modal .default-modal__footer button').prop('disabled', false);
        }

        // $('body').on('click', '.dropdown', function () {
        //     if($(this).is('.dropdown--active')) {
        //         $(this).removeClass('dropdown--active');
        //     } else {
        //         $(this).addClass('dropdown--active');
        //     }
        // })

        // 전체 선택
        $('body').on('click','#selected--all',function(){
            if($('#selected--all').is(':checked')){
                $('.checkbox').map(function() {
                    if (!$(this).is(':disabled')) {
                        $(this).prop('checked',true);
                    }
                })

                $('.order__button button').text($('.checkbox.product:checked').length + "개 상품 주문하기");
                $('.order__button button').removeAttr('disabled');
            }else{
                $('.checkbox').prop('checked',false);
                $('.order__button button').text("주문하기");
                $('.order__button button').attr('disabled', 'true');
            }
            reCal();
        });

        // 부분 선택
        $('body').on('click','.checkbox',function(){
            if($('.checkbox:checked').length==$('.checkbox').length){
                $('#selected--all').prop('checked',true);
            }else{
                $('#selected--all').prop('checked',false);
            }

            if ($(this).is('.company')) {
                var checked = $(this).is(':checked');

                $(this).parents('li.basket__card').find('.checkbox.product').map(function () {
                    if (!$(this).is(':disabled')) {
                        $(this).prop('checked',checked);
                    }
                })
            }
            reCal();

            if($('.checkbox:checked').length > 0) {
                $('.order__button button').text($('.checkbox.product:checked').length + "개 상품 주문하기");
                $('.order__button button').removeAttr('disabled');
            } else {
                $('.order__button button').text("주문하기");
                $('.order__button button').attr('disabled', true);
            }
        });

        function numberMaxLength(e){
            if(e.value.length > e.maxLength){
                e.value = e.value.slice(0, e.maxLength);
            }

            $(e).parents('.selection__result').data('price', $(e).data('each_price') * $(e).val());
            $(e).parents('.selection__result').find('.selection__price span.price').text(($(e).data('each_price') * $(e).val()).toLocaleString());

            var footer = $(e).parents('.basket__card').find('.card__footer dd span');
            var companyPrice = 0;

            $(this).parents('.basket__card').find('.selection__result').map(function () {
                companyPrice += $(e).data('price');
            })
            footer.text(companyPrice.toLocaleString());

            reCal();
        }

        // 주문 옵션 수량 변경
        $('body').on('click', '.ico__count--plus, .ico__count--minus',  function () {
            var productIdx = $(this).is('.isModal') ? $('#default-modal').data('product_idx') : $(this).parents('.card__content').data('product_idx');
            var target = $(this).parents('.selection__count').find('[name="qty_input"]');
            var cnt = target.val();

            if ($(this).is('.ico__count--plus')) {
                cnt++;
            } else {
                if (cnt > 1) {
                    cnt--;
                }
            }
            target.val(cnt);

            if ($(this).is('.isModal')) {
                modalReCal();
            } else {
                if ($(this).parents('.card__content').find('.checkbox.product').data('is_price_open') != "0") {
                    $(this).parents('.selection__result').data('price', target.data('each_price') * cnt);
                    $(this).parents('.selection__result').find('.selection__price span.price').text((target.data('each_price') * cnt).toLocaleString());

                    var footer = $('.card__footer[data-product_idx="' + productIdx + '"] dd span');
                    var productPrice = 0;

                    $('.card__content[data-product_idx="' + productIdx + '"] .selection__result').map(function () {
                        productPrice += $(this).data('price');
                    })
                    footer.text(productPrice.toLocaleString());

                    reCal();
                }
            }
        })

        // 상품 상세 페이지 이동
        function goToProduct(idx) {
            location.replace('/product/detail/'+idx);
        }

        // 장바구니별 삭제(옵션별)
        function removeCart(idx) {
            $('#alert-modal02 [name="remove_btn"]').data('idx', idx);
            openModal('#alert-modal02');
        }

        // 상품별 삭제
        function removeProduct(idx) {
            $('#alert-modal07 [name="remove_btn"]').data('idx', idx);
            openModal('#alert-modal07');
        }

        // 선택 삭제
        function checkRemove() {
            if($('.checkbox:checked').length > 0) {
                $('#alert-modal06 .alert-modal__top span').text($('.checkbox:checked').parents('.card__content').find('.selection__result').length);
                openModal('#alert-modal06')
            } else {
                openModal('#alert-modal08')
            }
        }

        // 옵션 삭제(삭제 모달로 데이터 전달)
        $('body').on('click', '#default-modal .ico__delete18', function () {
            var isPre = false;
            var idx = 0;

            if ($(this).parents().is('.selection__prev')) {
                isPre = true;
                idx = $(this).parents('.selection__prev').data('cart_idx');
            } else {
                idx = $(this).parents('.selection__result').index();
            }

            $('#alert-modal02 button[name="remove_btn"]').data('type', 'cart');
            $('#alert-modal02 button[name="remove_btn"]').data('isPre', isPre);
            $('#alert-modal02 button[name="remove_btn"]').data('idx', idx);
            openModal('#alert-modal02');
        })

        // 장바구니 삭제
        $('body').on('click', 'button[name="remove_btn"]', function () {
            closeModal('#'+$(this).data('target'));
            var idx = [];
            var type = $(this).data('type');

            if (type == 'selected') {
                $('.checkbox.product:checked').map(function () {
                    idx.push($(this).data('product_idx'));
                });
            } else {
                idx.push($(this).data('idx'));
                console.log(type);
                if ($('#default-modal').css('display') == 'block') {
                    if ($(this).data('isPre')) {
                        $('#default-modal .selection__prev[data-cart_idx="' + $(this).data('idx') + '"]').remove();

                        modalReCal();
                    } else {
                        $('#default-modal .selection__res .selection__result:eq(' + $(this).data('idx') + ')').remove();

                        modalReCal();
                        return;
                    }
                }
            }

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url				: '/order/removeCart',
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                data			: {
                    'idx'           : idx,
                    'type'          : type,
                },
                type			: 'POST',
                dataType		: 'json',
                success		: function(result) {
                    if (result.success) {

                        idx.forEach(function (item, i) {
                            if (type == 'cart') {
                                $('li.selection__result[data-cart_idx="'+item+'"]').remove();
                            } else {
                                $('.card__content[data-product_idx="'+item+'"]').remove();
                                $('.card__footer[data-product_idx="'+item+'"]').remove();
                            }
                        });

                        $('.card__content').map(function () {
                            if ($(this).find('li.selection__result').length == 0) {
                                $(this).remove();
                                $('.card__footer[data-product_idx="' + $(this).data('product_idx') + '"]').remove();
                            }
                        });

                        var totalPrice = 0;
                        $('.basket__card').map(function () {
                            if ($(this).find('li.selection__result').length == 0) {
                                $(this).remove();
                            } else {
                                var price = 0;
                                $(this).find('li.selection__result').map(function () {
                                    price += $(this).data('price');
                                    totalPrice += price;
                                });
                                $('.card__footer span').text(price.toLocaleString());
                            }
                        });

                        $('.basket__order .num span').text(totalPrice.toLocaleString());


                        if ($('.basket__card').length < 1) {
                            htmlText = '<div class="basket__no-product">' +
                                '<div class="no-product__wrap">' +
                                '<div class="ico__search--circle">' +
                                '<i class="ico__search--white"><span class="a11y">검색</span></i>' +
                                '</div>' +
                                '<p>장바구니에 담긴 상품이 없습니다.</p>' +
                                '<a href="{{ route('product.new')}}"><span>올펀 상품 보러가기</span></a>' +
                                '</div>' +
                                '</div>';

                            $('.basket.active').remove();
                            $('.basket__title').after(htmlText);

                        }
                    }
                }
            });
        });

        // 주문하기
        // 상품 상테 변동(판매중지, 품절)시 리턴받아 처리
        function makeOrderForm(idx) {
            $data = [];
            if (idx == 0) {
                $('.checkbox.product:checked').parents('li.basket__card').find('li.selection__result').map(function () {
                    var cartIdx = $(this).data('cart_idx');
                    var price = $(this).data('price');
                    var count = $(this).find('input[name="qty_input"]').val();

                    $data.push({"idx":cartIdx, "price":price, "count":count});
                })
            } else {
                $('.card__content[data-product_idx="'+idx+'"] li.selection__result').map(function () {
                    var cartIdx = $(this).data('cart_idx');
                    var price = $(this).data('price');
                    var count = $(this).find('input[name="qty_input"]').val();

                    $data.push({"idx":cartIdx, "price":price, "count":count});
                })
            }

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url				: '/order/updateCart',
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                data			: {
                    'data'      : $data,
                },
                type			: 'POST',
                dataType		: 'json',
                success		: function(result) {
                    if (result.success) {
                        location.href="/order/"+result.cartIdx;
                    } else {
                        if (result.code == 1001) {
                            $state = '';
                            $.each(result.data, function (i, item) {
                                if (item != null) {
                                    if (item.state == 'C') {
                                        $state = '(판매중지)';
                                    } else if (item.state == 'O') {
                                        $state = '(품절)';
                                    }

                                    if (i == 0) {
                                        $('#alert-modal03 .alert-modal__top p span').text( item.name + '이(가) ' + $state );
                                    }

                                    if ($('.card__content[data-product_idx="' + item.productIdx + '"]').find('.dim')) {
                                        $('.card__content[data-product_idx="' + item.productIdx + '"] .category__check span').text($state + ' ' + item.name );
                                        $('.card__content[data-product_idx="' + item.productIdx + '"] .category__check input').prop('checked', false);
                                        $('.card__content[data-product_idx="' + item.productIdx + '"], .card__footer[data-product_idx="' + item.productIdx + '"]').append(
                                            '<div class="dim" style="position: absolute; width: 100%; height: 100%; background-color: #ffffff80; top: 0;"></div>'
                                        );
                                    }
                                }
                            });

                            reCal();
                            openModal('#alert-modal03');
                        }
                    }
                }
            });
        }

        // 상품 옵션 리스트 가져오기
        function getOptions(idx) {
            $('#default-modal').data('product_idx', idx);
            var base = '.card__content[data-product_idx="'+idx+'"]';
            var isPriceOpen = $('.product[data-product_idx="' + idx + '"]').data('is_price_open');

            $('#default-modal .head__img-wrap img').attr('src', $(base + ' .desc__img img').attr('src'));
            $('#default-modal .head__text-wrap h3').text($(base + ' .content__head span').text().replace('삭제', ''));
            $('#default-modal .head__text-wrap dl:eq(0) dd').text($(base + ' .content__footer dl:first-child dd').text());
            $('#default-modal .head__text-wrap dl:eq(1) dd').text($(base + ' .content__footer dl:last-child dd').text());
            $('#default-modal .selection__pre').html('');
            $('#default-modal .selection__res').html('');

            var textHtml = '';
            $('#default-modal .selection__pre').html('');

            $(base + ' .content__desc li.selection__result').map(function () {
                textHtml += '<div class="selection__prev" data-cart_idx="' + $(this).data('cart_idx') + '" style="padding: 9px 16px; border:1px solid #dbdbdb; background-color:#f7f7f7; border-radius:5px; margin-bottom:16px;">' +
                    '<div class="selection__text">' +
                    '<ul>' ;

                $(this).find('.selection__text li').map(function () {
                    textHtml += '<li ' ;
                        if ($(this).data('required') != null) {
                            textHtml += 'data-required="'+ $(this).data('required') + '"' ;

                            if ($(this).data('required') == 1) {
                                textHtml += 'data-price="' + $(this).data('price') + '"';
                            } else {
                                textHtml += 'data-price="0"';
                            }

                        } else {
                            textHtml += 'data-price="' + $(this).data('price') + '"';
                        }
                    textHtml += '>' + $(this).text() + '</li>';
                })

                textHtml += '</ul>' +
                    '<button class="ico__delete18"><span class="a11y">삭제</span></button>' +
                    '</div>' +
                    '<div class="selection__box">' +
                    '<ul class="selection__count">' +
                    '<li>' +
                    '<i class="ico__count--minus isModal"><span class="a11y">빼기</span></i>' +
                    '</li>' +
                    '<li class="count__text" style="width: 30px;">' +
                    '<input type="text" name="qty_input" value="' + $(this).find('input[name="qty_input"]').val() + '" style="width:100%;height:100%;text-align: center;" min="1" maxlength="3" oninput="numberMaxLength(this);" >' +
                    '</li>' +
                    '<li>' +
                    '<i class="ico__count--plus isModal"><span class="a11y">더하기</span></i>' +
                    '</li>' +
                    '</ul>' +
                    '<p class="selection__price">' +
                    '<span class="price">'+ $(this).find('.selection__price .price').text() + '</span>' ;

                if (isPriceOpen != '0') {
                    textHtml += '원';
                }

                textHtml += '</p>' +
                    '</div>' +
                    '</div>' ;
            })
            $('#default-modal .selection__pre').append(textHtml);

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url				: '/product/getOption/'+idx,
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                data			: {},
                type			: 'POST',
                dataType		: 'json',
                success		: function(result) {
                    if (result != null) {
                        var options = JSON.parse(result[0]['product_option']);
                        var htmlText = '';

                        options.forEach(function (option, i) {
                            var required = option['required'] == 1 ? '필수' : '선택';
                            var title = option['optionName'] +' 선택 ('+ required + ')';

                            htmlText += '<div class="dropdown ' + (option['required'] == 1 ? 'required' : '') + '">' +
                                '<p class="dropdown__title" aria-placeholder="'+title+'">' + title + '</p>' +
                                '<ul class="dropdown__wrap">';

                            option['optionValue'].forEach(function (values, i) {
                                var price = values['price'] == 0 ? '' : values['price'];

                                htmlText +='<li class="dropdown__item">' +
                                    '<p>' + values['propertyName'] + '</p>' +
                                    '<p data-price=' + price + ' >';

                                if (price > 0 && isPriceOpen != '0') {
                                    htmlText += price.replace(/\,/g, '').replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,') + '원';
                                }

                                htmlText += '</p>' +
                                    '</li>';
                            });

                            htmlText += '</ul>' +
                                '</div>';
                        });

                        $('#default-modal .option_list').html(htmlText);
                        $('#default-modal .default-modal__footer button').prop('disabled', true);
                        modalReCal();

                        openModal('#default-modal');
                    }
                }
            });
        }

        // 옵션 변경 - 옵션 title 선택
        $('body').on('click', '#default-modal .option_list .dropdown', function () {
            idx = $(this).parents('.dropdown').index();
            if (!$(this).is('.dropdown--active')) {
                $('#default-modal .option_list .dropdown:not(' + idx + ').dropdown--active').map(function () {
                    $(this).removeClass('dropdown--active');
                })
            }
        })

        // 옵션 변경 - 옵션 value 선택
        $('body').on('click', '#default-modal .option_list .dropdown__item', function () {
            required = false;
            requiredCnt = $('#default-modal .dropdown.required').length;
            idx = $(this).parents('.dropdown').index();
            same = false;

            $(this).parents('.dropdown').find('.dropdown__title').text($(this).parents('.dropdown').find('.dropdown__title').attr('aria-placeholder'));

            if (!$(this).parents('.dropdown').is('.required')) { //선택 옵션 일때 필수 옵션 없는경우
                if (requiredCnt > 0 && $('#default-modal .selection__text li:first-child[data-required="1"]').length < 1) {

                    openModal('#alert-modal10');
                    same = true;
                    return;
                }

                optionName = $(this).find('p').eq(0).text();

                $('#default-modal .selection__prev, #default-modal .selection__result').map(function () { // 중복옵션 체크
                    if (optionName == $(this).find('.selection__text li:eq(1)').text()) {
                        $('#default-modal .dropdown.dropdown--active').removeClass('.dropdown--active');

                        openModal('#alert-modal09');
                        same = true;
                        return;
                    }
                })
            } else {
                required = true;

                optionTmp.push({
                    'name': $(this).parents('.dropdown').find('.dropdown__title').attr('aria-placeholder'),
                    'option_name': $(this).find('p:eq(0)').text(),
                    'option_price': $(this).find('p:eq(1)').data('price'),
                })

                if (requiredCnt > 1 && optionTmp.length < requiredCnt ) {
                    return;
                } else {
                    eqCnt = 0;
                    $('#default-modal .selection__text li').map(function () {
                        for(i=0; i<optionTmp.length; i++) {
                            if ($(this).text().trim() == optionTmp[i]['option_name'].trim()) {
                                eqCnt ++;

                                if (eqCnt == optionTmp.length) {
                                    same = true;
                                    $('#default-modal .dropdown.dropdown--active').removeClass('.dropdown--active');

                                    optionTmp = [];
                                    openModal('#alert-modal09');
                                    same = true;
                                    return;
                                }
                            }
                        }
                    })

                }
            }

            if (!same) {
                price = 0;
                htmlText = '<div class="selection__result' + (required ? ' required' : ' add') + '">' +
                    '<div class="selection__text">' +
                    '<ul>';
                if (required) {
                    htmlText += '<li data-price=' + $('.card__content[data-product_idx="' + $('#default-modal').data('product_idx') + '"] .selection__result li[data-required="1"]').data('price') + ' >' + $('#default-modal .head__text-wrap h3').text() + '</li>';
                    price += parseInt($('.card__content[data-product_idx="' + $('#default-modal').data('product_idx') + '"] .selection__result li[data-required="1"]').data('price'));

                    optionTmp.map(function (item) {
                        htmlText += '<li data-name="' + item['name'] + '" data-option_name="' + item['option_name'] + '" data-price="' + item['option_price'] + '">' + item['option_name'] + '</li>';
                        price += item['option_price'] ?? 0;
                    })
                } else {
                    htmlText += '<li data-price="0">' + $(this).parents('.dropdown').find('.dropdown__title').attr('aria-placeholder') + '</li>' +
                        '<li data-name="' + $(this).parents('.dropdown').find('.dropdown__title').attr('aria-placeholder') + '" data-option_name="' + optionName + '" data-price="' + $(this).find('p:eq(1)').data('price') + '">' + optionName + '</li>';
                    price += parseInt($(this).find('p:eq(1)').data('price'));
                }
                htmlText += '</ul>' +
                    '<button class="ico__delete18">' +
                    '<span class="a11y">삭제</span>' +
                    '</button>' +
                    '</div>' +
                    '<div class="selection__box">' +
                    '<ul class="selection__count">' +
                    '<li class="count__minus">' +
                    '<button type="button" class="btn_minus isModal"><i class="ico__count--minus"><span class="a11y">빼기</span></i></button>' +
                    '</li>' +
                    '<li class="count__text" style="width:30px;">' +
                    '<input type="text" id="qty_input" name="qty_input" value="1" maxlength="3" style="width:100%;height:100%;text-align: center;">' +
                    '</li>' +
                    '<li class="count__plus">' +
                    '<button type="button" class="btn_plus isModal"><i class="ico__count--plus"><span class="a11y">더하기</span></i></button>' +
                    '</li>' +
                    '</ul>' +
                    '<p class="selection__price">';

                if ($('.product[data-product_idx="' + $('#default-modal').data('product_idx') + '"]').data('is_price_open') == '0') {
                    htmlText += '<span>' + $('#default-modal .default-modal__footer .price').text() + '</span>';
                } else {
                    htmlText += '<span>' + price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '</span>원';
                }

                htmlText += '</p>' +
                    '</div>' +
                    '</div>';

                if(required && $('#default-modal .selection__result.add').length > 0 ) {
                    $('.selection__result.add').first().before(htmlText);
                } else {
                    $('#default-modal .content__desc .selection__res').append(htmlText);
                }

                optionTmp = [];

                modalReCal();
                $('#default-modal .default-modal__footer button').prop('disabled', false);
            }
        })

        // 옵션 변경 - 삭제
        function removeOption() {
            $('#default-modal .dropdown__title').text($('#default-modal .dropdown__title').attr('aria-placeholder'));
            $('#default-modal .dropdown__item.selected').removeClass('selected');
            $('#default-modal .selection__text li:gt(0)').remove();

            $('#default-modal .selection__result').css('display', 'none');
        }

        // 옴션 변경 - 추가
        function addCart() {
            var requiredCnt = $('#default-modal .dropdown.required').length;

            $('#default-modal .selection__prev').map(function () {
                target = $('.card__content .selection__result[data-cart_idx="' + $(this).data('cart_idx') + '"]').find('.selection__box [name="qty_input"]');
                target.val($(this).find('[name="qty_input"]').val());
                if (target.parents('.card__content').find('.checkbox.product').data('is_price_open') != "0") {
                    target.parents('.selection__result').data('price', target.data('each_price') * target.val());
                    target.parents('.selection__result').find('.selection__price span.price').text((target.data('each_price') * target.val()).toLocaleString());

                    var footer = $('.card__footer[data-product_idx="' + $('#default-modal').data('product_idx') + '"] dd span');
                    var productPrice = 0;

                    $('.card__content[data-product_idx="' + $('#default-modal').data('product_idx') + '"] .selection__result').map(function () {
                        productPrice += $(this).data('price');
                    })
                    footer.text(productPrice.toLocaleString());

                    reCal();
                }
            })
            reCal();

            if ($('#default-modal .selection__res').html() == '') {
                closeModal('#default-modal');
            }

            var form = new FormData();
            form.append("productIdx", $('#default-modal').data('product_idx'));
            form.append("required", requiredCnt > 0 ? 1 : 0);

            var htmlText = '';
            var optionArr = new Array();
            $('#default-modal .selection__res .selection__result').map(function () {
                var cardList = new Array();

                $(this).find('.selection__text li').map(function () {
                    var option = new Object();
                    option.required = $(this).parents('.selection__result').is('.required') ? 1 : 0;
                    option.name = $(this).data('name');
                    option.value = $(this).data('option_name');
                    option.price = $(this).data('price') == '' ? 0 : $(this).data('price');
                    option.count = $(this).parents('.selection__result').find('.selection__box #qty_input').val();
                    cardList.push(option);
                })
                optionArr.push(cardList);
            })

            form.append("option", JSON.stringify(optionArr));

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url             : '/order/addCart',
                enctype         : 'multipart/form-data',
                processData     : false,
                contentType     : false,
                data			: form,
                type			: 'POST',
                success: function (result) {
                    if (result.success) {
                        let cartIdx = result.cartIdx.split(',');
                        var cnt = 0;

                        $('#default-modal .selection__res .selection__result').map(function () {
                            htmlText += '<li class="selection__result" data-product_idx="' + $('#default-modal').data('product_idx') + '" data-cart_idx="' + cartIdx[cnt] +'" data-price="0">' +
                                '   <div class="selection__text">' +
                                '       <ul>';

                            $(this).find('.selection__text li').map(function () {
                                htmlText += '<li data-required="' + ($(this).parents('.selection__result').is('.required') ? 1 : 0) + '" data-price="' + ($(this).data('price') == "" ? 0 : $(this).data('price')) + '">' + $(this).text() + '</li>';
                            })

                            htmlText += '</ul>' +
                                '<button class="ico__delete18" onclick="removeCart(' + cartIdx[cnt] + ')">' +
                                '<span class="a11y">삭제</span>' +
                                '</button>' +
                                '</div>' +
                                '<div class="selection__box">' +
                                '<ul class="selection__count">' +
                                '<li class="count__minus">' +
                                '<button type="button" class="btn_minus">' +
                                '<i class="ico__count--minus"><span class="a11y">빼기</span></i>' +
                                '</button>' +
                                '</li>' +
                                '<li class="count__text" style="width: 30px;">' +
                                '<input type="text" name="qty_input" value="' + $(this).find('.selection__box #qty_input').val() + '" style="width:100%;height:100%;text-align: center;" data-each_price="0" min="1" maxlength="3" oninput="numberMaxLength(this);" kl_vkbd_parsed="true">' +
                                '</li>' +
                                '<li class="count__plus">' +
                                '<button type="button" class="btn_plus"><i class="ico__count--plus"><span class="a11y">더하기</span></i></button>' +
                                '</li>' +
                                '</ul>' +
                                '<p class="selection__price">' + $(this).find('.selection__price').html() + '</p>' +
                                '</div>' +
                                '</li>';
                        })

                        $('.card__content[data-product_idx="' + $('#default-modal').data('product_idx') + '"] .content__desc ul.selection_list').append(htmlText);

                        reCal();
                        closeModal('#default-modal');
                    } else {
                    }
                }
            });
        }
    </script>
@endsection
