@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
    <div id="container" class="container">
        <div class="inner">
            <div class="content">
                <div class="product-detail">
                    <div class="product-detail__left-wrap">
                        @if(count($data['detail']->attachment) > 1)
                            <div class="left-wrap__arrow">
                                <button type="button" onclick="changeImg(0)">
                                    <span class="ico_back @if(count($data['detail']->attachment) > 1) active @endif">
                                        <span class="a11y">이전으로</span>
                                    </span>
                                </button>
                                <button type="button" onclick="changeImg(1)">
                                    <span class="ico_next @if(count($data['detail']->attachment) > 1) active @endif">
                                        <span class="a11y">다음으로</span>
                                    </span>
                                </button>
                            </div>
                        @endif
                        <div class="left-wrap__img">
                            <img src="@if(isset($data['detail']->attachment[0]->imgUrl)) {{$data['detail']->attachment[0]->imgUrl}} @endif" alt="{{$data['detail']->name}}" style="object-fit:cover;">
                        </div>
                        <ul class="left-wrap__img--small">

                            @foreach($data['detail']->attachment as $key=>$item)
                                @if($key < 8)
                                    <li class="thumnail @if($key == 0) selected @endif ">
                                        <button type="button">
                                            <img src="{{$item['imgUrl']}}" alt="{{$data['detail']->name}}" style="object-fit:cover;">
                                        </button>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="product-detail__right-wrap">
                        <a href="/wholesaler/detail/{{$data['detail']->company_idx}}" class="right-wrap__company">
                            <i class="ico__shop24"><span class="a11y">가게</span></i>
                            <p class="name"><strong>{{$data['detail']->companyName}}</strong> 업체 보러가기</p>
                            <i class="ico__arrow--right14"><span class="a11y">오른쪽 화살표</span></i>
                        </a>
                        <div class="right-wrap__title">
                            <div class="title-wrap">
                                <h2>
                                    @if($data['detail']->state == 'O')
                                        (품절)
                                    @endif
                                    {{$data['detail']->name}}
                                </h2>
                                <p class="price" data-price={{$data['detail']->price}} data-is_price_open={{$data['detail']->is_price_open}}>
                                    @if($data['detail']->is_price_open != 0)
                                            <?php echo number_format($data['detail']->price, 0); ?>원
                                    @else
                                        {{$data['detail']->price_text}}
                                    @endif
                                </p>
                            </div>
                            <ul>
                                <li class="product-share">
                                    <a href="#" onclick="copyUrl()">
                                        <i class="ico__share28"><span class="a11y">공유</span></i>
                                        <p>공유</p>
                                    </a>
                                </li>
                                <li class="product-bookmark @if($data['detail']->isInterest > 0) active @endif" onclick="addInterest()">
                                    <i class="bookmark"><span class="a11y">북마크</span></i>
                                    <p>관심 상품</p>
                                </li>
                            </ul>
                        </div>

                        <div class="right-wrap__code">
                            @if($data['detail']->product_code != '')
                                <dl style="margin-bottom: 12px">
                                    <dt>상품 코드</dt>
                                    <dd>{{$data['detail']->product_code}}</dd>
                                </dl>
                            @endif
                            <dl>
                                <dt>배송 방법</dt>
                                <dd>{{$data['detail']->delivery_info}}</dd>
                            </dl>
                        </div>
                        <div class="right-wrap__selection" id="options" style="position: relative;">
                                <div class="box">
                                    <div class="box__icon">
                                        <i class="ico__info"><span class="a11y">정보</span></i>
                                    </div>
                                    <p class="box__text">원하는 옵션이 없거나 커스텀 주문을 희망하시면 필수 옵션 선택 후 [바로 주문] 버튼을 클릭하여
                                        주문 요청사항에 작성해주세요.</p>
                                </div>
                                @if(isset($data['detail']->product_option) && $data['detail']->product_option != '[]')
                                    <?php $arr = json_decode($data['detail']->product_option); $required = false; ?>
                                    @foreach($arr as $item)
                                        <div class="dropdown @if($item->required == 1)required <?php $required = true; ?> @endif" style="width: 576px">
                                            <p class="dropdown__title" data-placeholder="{{$item->optionName}} 선택 (@if($item->required == 1)필수@else선택@endif)">
                                                {{$item->optionName}} 선택
                                                @if($item->required == 1)
                                                    (필수)
                                                @else
                                                    (선택)
                                                @endif
                                            </p>
                                            <ul class="dropdown__wrap">
                                                @foreach($item->optionValue as $sub)
                                                    <li class="dropdown__item" data-option_name="{{$sub->propertyName}}" data-price="{{$sub->price}}">
                                                        <p class="name">{{$sub->propertyName}}</p>
                                                        @if((int)$sub->price > 0 && $data['detail']->is_price_open == 1)
                                                            <p class="price" data-price={{$sub->price}}><?php echo number_format((int)$sub->price, 0); ?>원</p>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach
                                    <div class="result">
                                        @if(!$required)
                                            <div class="selection__result required">
                                                <div class="selection__text">
                                                    <ul>
                                                        <li data-price={{$data['detail']->price}} >{{$data['detail']->name}}</li>
                                                    </ul>
                                                </div>
                                                <div class="selection__box">
                                                    <ul class="selection__count">
                                                        <li class="count__minus">
                                                            <button type="button" class="btn_minus"><i class="ico__count--minus"><span class="a11y">빼기</span></i></button>
                                                        </li>
                                                        <li class="count__text" style="width:30px;">
                                                            <input type="text" id="qty_input" name="qty_input" value="0" maxlength="3" style="width:100%;height:100%;text-align: center;">
                                                        </li>
                                                        <li class="count__plus">
                                                            <button type="button" class="btn_plus"><i class="ico__count--plus"><span class="a11y">더하기</span></i></button>
                                                        </li>
                                                    </ul>
                                                    <p class="selection__price">
                                                    <span>
                                                        @if($data['detail']->is_price_open == 1)
                                                            0</span>원
                                                        @else
                                                            {{$data['detail']->price_text}}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="result">
                                        <div class="selection__result required">
                                            <div class="selection__text">
                                                <ul>
                                                    <li data-price={{$data['detail']->price}} >{{$data['detail']->name}}</li>
                                                </ul>
                                            </div>
                                            <div class="selection__box">
                                                <ul class="selection__count">
                                                    <li class="count__minus">
                                                        <button type="button" class="btn_minus"><i class="ico__count--minus"><span class="a11y">빼기</span></i></button>
                                                    </li>
                                                    <li class="count__text" style="width:30px;">
                                                        <input type="text" id="qty_input" name="qty_input" value="0" maxlength="3" style="width:100%;height:100%;text-align: center;">
                                                    </li>
                                                    <li class="count__plus">
                                                        <button type="button" class="btn_plus"><i class="ico__count--plus"><span class="a11y">더하기</span></i></button>
                                                    </li>
                                                </ul>
                                                <p class="selection__price">
                                                    <span>
                                                        @if($data['detail']->is_price_open == 1)
                                                            0</span>원
                                                        @else
                                                        {{$data['detail']->price_text}}</span>
                                                       @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if($data['detail']->state == 'O')
                                    <div class="dim" style="position:absolute;width:100%;height:100%;top:0;left:0;background-color: #ffffff80"></div>
                                @endif
                            </div>

                        <div class="right-wrap__order" style="position: relative;">
                                <dl class="order__text">
                                    <dt>주문 금액</dt>
                                    <dd><span id="total_price" data-total_price={{$data['detail']->price}}>
                                        @if($data['detail']->is_price_open == 1)
                                           0</span>원
                                        @else
                                            {{$data['detail']->price_text}}</span>
                                        @endif
                                    </dd>
                                </dl>
                                <div class="order__button-group">
                                    @if($data['detail']->state == 'O')
                                        <button type="button" class="button button--solid" disabled style="width: 100%;">
                                            품절
                                        </button>
                                    @else
                                        <button type="button" class="button button--blank" disabled onclick="cart(0)">
                                            장바구니 담기
                                        </button>
                                        <button type="button" class="button button--solid" disabled onclick="cart(1)">
                                            바로 주문
                                        </button>
                                    @endif
                                </div>
                                @if($data['detail']->state == 'O')
                                    <div class="dim" style="position:absolute;width:100%;height:100%;top:0;left:0;background-color: #ffffff80"></div>
                                @endif
                            </div>
                    </div>
                </div>

                <div class="product-detail__table">
                    <?php $parentCnt = 1; $names = '';?>
                    @if(isset($data['detail']->propertyList))
                        @foreach($data['detail']->propertyArray as $key=>$item)
                            @if($parentCnt%2 != 0)
                                <dl class="item01">
                            @endif
                                <dt>{{$key}}</dt>
                                <dd>{{$item}}</dd>
                                <?php $parentCnt ++; ?>
                            @if($parentCnt%2 != 0)
                            </dl>
                            @endif
                        @endforeach
                        @if($parentCnt%2 == 0)
                            <dt></dt>
                            <dd></dd>
                            </dl>
                        @endif
                    @endif
                    <dl class="item02" style="height: auto;">
                        <dt class="ico__notice24"><span class="a11y">공지</span></dt>
                        <dd><?php echo str_replace('\"', '', str_replace('width: 300px;', 'width: fit-content;',html_entity_decode($data['detail']->notice_info))); ?></dd>
                    </dl>
                </div>

                <div class="product-detail__img-area">
                    <?php echo str_replace('\"', '', str_replace('width: 300px;', 'width: fit-content;',html_entity_decode($data['detail']->product_detail))); ?>
                </div>

                @if(($data['detail']->is_pay_notice == 1 && $data['detail']->pay_notice != '')||
                    ($data['detail']->is_delivery_notice == 1 && $data['detail']->delivery_notice != '')||
                    ($data['detail']->is_return_notice == 1 && $data['detail']->return_notice != '') ||
                    ($data['detail']->is_order_notice == 1 && $data['detail']->order_title != '' && $data['detail']->order_content != ''))
                    <div class="product__text--wrap">
                        <h2 class="product__title">상품 주문 정보</h2>
                    </div>
                    <ul class="product-detail__order-info">
                        @if($data['detail']->is_pay_notice == 1 && $data['detail']->pay_notice != '')
                            <li>
                                <div class="order-info__title">
                                    <p>결제 안내</p>
                                    <i class="ico__arrow"><span class="a11y">아래 화살표</span></i>
                                </div>
                                <div class="order-info__desc">
                                    {{$data['detail']->pay_notice}}
                                </div>
                            </li>
                        @endif
                        @if($data['detail']->is_delivery_notice == 1 && $data['detail']->delivery_notice != '')
                            <li>
                                <div class="order-info__title">
                                    <p>배송 안내</p>
                                    <i class="ico__arrow"><span class="a11y">아래 화살표</span></i>
                                </div>
                                <div class="order-info__desc">
                                    {{$data['detail']->delivery_notice}}
                                </div>
                            </li>
                        @endif
                        @if($data['detail']->is_return_notice == 1 && $data['detail']->return_notice != '')
                            <li>
                                <div class="order-info__title">
                                    <p>교환/반품/취소 안내</p>
                                    <i class="ico__arrow"><span class="a11y">아래 화살표</span></i>
                                </div>
                                <div class="order-info__desc">
                                    {{$data['detail']->return_notice}}
                                </div>
                            </li>
                        @endif
                        @if($data['detail']->is_order_notice == 1 && $data['detail']->order_title != '' && $data['detail']->order_content != '')
                        <li>
                            <div class="order-info__title">
                                <p>{{$data['detail']->order_title}}</p>
                                <i class="ico__arrow"><span class="a11y">아래 화살표</span></i>
                            </div>
                            <div class="order-info__desc">
                                {{$data['detail']->order_content}}
                            </div>
                        </li>
                        @endif
                    </ul>
                @endif

                @if(sizeof($data['recommend']) > 0)
                    <div class="product__text--wrap">
                        <h2 class="product__title">{{$data['detail']->companyName}} 추천 상품</h2>
                    </div>
                    <ul class="product-list product-list__detail">
                        @foreach($data['recommend'] as $item)
                            <li class="product-list__card" style="position: relative;">
                                <div class="card__bookmark">
                                    <i class="@if($item->isInterest > 0) ico__bookmark24--on @else ico__bookmark24--off @endif"><span class="a11y">스크랩 off</span></i>
                                </div>
                                <a href="/product/detail/{{$item->idx}}" title="{{$item->name}} 상세 화면으로 이동">
                                    <div class="card__img--wrap">
                                        <img class="card__img" src="{{$item->imgUrl}}" alt="{{$item->name}}">
                                        @if($item->isAD > 0)
                                            <div class="card__badge">AD</div>
                                        @endif
                                    </div>
                                    <div class="card__text--wrap">
                                        <p class="card__name">{{$item->name}}</p>
                                        <p class="card__price">
                                            @if($item->is_price_open != 0)
                                                    <?php echo number_format($item->price, 0); ?>원
                                            @else
                                                {{$item->price_text}}
                                            @endif
                                        </p>
                                    </div>
                                </a>
                                @if($item->is_new_product > 0)
                                    <p class="badge">NEW</p>
                                @endif
                                @if($item->state == 'O')
                                    <a class="dim" style="position:absolute;width:100%;height:100%;top:0;left:0;background-color: #ffffff80" href="/product/detail/{{$item->idx}}"></a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- 필수 옵션 미선택 팝업 -->
            <div id="alert-modal01" class="alert-modal">
                <div class="alert-modal__container">
                    <div class="alert-modal__top">
                        <p>필수 옵션 선택 후 선택해주세요</p>
                    </div>
                    <div class="alert-modal__bottom">
                        <button type="button" class="button button--solid" onclick="closeModal('#alert-modal01')">
                            확인
                        </button>
                    </div>
                </div>
            </div>

            <!-- 필수 옵션 미선택 팝업 -->
            <div id="alert-modal07" class="alert-modal">
                <div class="alert-modal__container">
                    <div class="alert-modal__top">
                        <p>상위 필수 옵션 선택 후 해당 옵션을 선택해주세요</p>
                    </div>
                    <div class="alert-modal__bottom">
                        <button type="button" class="button button--solid" onclick="closeModal('#alert-modal07')">
                            확인
                        </button>
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
                            <button type="button" class="button button--solid" onclick="deleteOptions()">
                                확인
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 주문 취소 팝업 -->
            <div id="alert-modal03" class="alert-modal">
                <div class="alert-modal__container">
                    <div class="alert-modal__top">
                        <p>주문을 취소하시겠습니까?</p>
                    </div>
                    <div class="alert-modal__bottom">
                        <div class="button-group">
                            <button type="button" class="button button--solid-gray" onclick="closeModal('#alert-modal03')">
                                취소
                            </button>
                            <button type="button" class="button button--solid deleteOption" onclick="deleteOptions()">
                                확인
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 상품 선택 알림 팝업 -->
            <div id="alert-modal04" class="alert-modal">
                <div class="alert-modal__container">
                    <div class="alert-modal__top">
                        <p>상품을 선택해주세요</p>
                    </div>
                    <div class="alert-modal__bottom">
                        <button type="button" class="button button--solid" onclick="closeModal('#alert-modal04')">
                            확인
                        </button>
                    </div>
                </div>
            </div>

            <!-- 공유 팝업 -->
            <div id="alert-modal" class="alert-modal">
                <div class="alert-modal__container">
                    <div class="alert-modal__top">
                        <p>
                            링크가 복사되었습니다.
                        </p>
                    </div>
                    <div class="alert-modal__bottom">
                        <button type="button" class="button button--solid" onclick="closeModal('#alert-modal')">
                            확인
                        </button>
                    </div>
                </div>
            </div>

            <!-- 장바구니 담기 팝업 -->
            <div id="alert-modal05" class="alert-modal">
                <div class="alert-modal__container">
                    <div class="alert-modal__top">
                        <p>장바구니에 상품을 담았습니다</p>
                    </div>
                    <div class="alert-modal__bottom">
                        <div class="button-group max-width">
                            <button type="button" class="button button--solid-gray" onclick="closeModal('#alert-modal05')">
                                쇼핑 계속하기
                            </button>
                            <button type="button" class="button button--solid" onclick="location.href='/cart'">
                                장바구니로 이동
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 옵션 중복 팝업 -->
            <div id="alert-modal06" class="alert-modal">
                <div class="alert-modal__container">
                    <div class="alert-modal__top">
                        <p>이미 선택한 옵션입니다. 다시 선택해주세요</p>
                    </div>
                    <div class="alert-modal__bottom">
                        <button type="button" class="button button--solid" onclick="closeModal('#alert-modal06')">
                            확인
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
        var isProc = false;
        var optionTmp = [];

        $(function () {
            // 장바구니/주문하기에서 뒤로가기로 이동시 초기화
            if (performance.getEntriesByType("navigation")[0].type === "back_forward") {
                location.reload();
            }

            // 수량 변경
            $('body').on('click', '.btn_minus', function (e) {
                e.preventDefault();
                var stat = $(this).parents('.selection__count').find("input[name='qty_input']").val();
                var num = parseInt(stat, 10);
                num--;
                if (num <= 0) {
                    alert('더이상 줄일수 없습니다.');
                    num = 1;
                }

                $(this).parents('.selection__count').find("input[name='qty_input']").val(num);
                reCal();
            });

            // 수량 변경
            $('body').on('click', '.btn_plus', function (e) {
                e.preventDefault();
                var stat = $(this).parents('.selection__count').find("input[name='qty_input']").val();
                var num = parseInt(stat, 10);
                num++;

                $(this).parents('.selection__count').find("input[name='qty_input']").val(num);
                reCal();

                $('.order__button-group button').prop('disabled', false);
            });

            $('body').on('keyup', '#qty_input', function () {
                reCal();
            })

            $('.left-wrap__img--small li').on('click', function () {
                $('.left-wrap__img--small li').map(function (el) {
                    $(this).removeClass('selected');
                })
                $(this).addClass('selected');
                $('.product-detail__left-wrap .left-wrap__img img').attr('src', ($(this).find('img').attr('src')));
            })

            $('body').on('click', '.ico__delete18', function () {
                $('#alert-modal02').data('delete_idx', $(this).parents('.selection__result').index());
                openModal('#alert-modal02');
            })
        });

        // 옵션 삭제
        function deleteOptions() {
            $('.selection__result').eq($('#alert-modal02').data('delete_idx')).remove();

            if ($('.dropdown.required').length != $('.selection__result.required').length) {
                $('.order__button-group button').prop('disabled', true);
            }

            reCal();

            closeModal('#alert-modal02');
        }

        // 상품 이미지 변경
        function changeImg(type) {
            if (type == 0) {
                if ($('li.thumnail.selected').is(':first-child')) {
                    $('li.thumnail:last-child').click();
                } else {
                    $('li.thumnail').eq($('li.thumnail.selected').index() - 1).click();
                }
            } else {
                if ($('li.thumnail.selected').is(':last-child')) {
                    $('li.thumnail:first-child').click();
                } else {
                    $('li.thumnail').eq($('li.thumnail.selected').index() + 1).click();
                }
            }
        }

        // 옵션 선택
        $('body').on('click', '.dropdown li', function () {
            required = false;
            requiredCnt = $('.dropdown.required').length;
            idx = $(this).parents('.dropdown').index();
            same = false;

            if (!$(this).parents('.dropdown').is('.required')) {
                if (required > 0 && $('.selection__result.required').length < 1) {
                    $(this).parents('.dropdown').find('.dropdown__title').text($(this).parents('.dropdown').find('.dropdown__title').data('placeholder'));

                    openModal('#alert-modal01');
                    return;
                }

                optionName = $(this).data('option_name');

                $('.selection__result').map(function () {
                    if ($(this).find('.selection__text li').eq(1).text() == optionName) {
                        same = true;
                        $('.dropdown').map(function () {
                            $(this).find('.dropdown__title').text($(this).find('.dropdown__title').data('placeholder'));
                        })

                        openModal('#alert-modal06');
                        return;
                    }
                })

            } else {
                required = true;

                if (requiredCnt > 1 && optionTmp.length != idx-1) {
                    openModal('#alert-modal07');
                    return;
                }

                optionTmp.push({
                    'name': $(this).parents('.dropdown').find('.dropdown__title').data('placeholder'),
                    'option_name': $(this).data('option_name'),
                    'option_price': $(this).data('price'),
                })

                if (requiredCnt > optionTmp.length) {
                    return;
                } else {
                    $('.selection__result.required').map(function () {
                        eqCnt = 0;
                        for(i=0; i<optionTmp.length; i++) {
                            if ($(this).find('.selection__text li').eq(i+1).text() == optionTmp[i]['option_name']) {
                                eqCnt ++;

                                if (eqCnt == optionTmp.length) {
                                    same = true;
                                    $('.dropdown').map(function () {
                                        $(this).find('.dropdown__title').text($(this).find('.dropdown__title').data('placeholder'));
                                    })

                                    optionTmp = [];
                                    openModal('#alert-modal06');
                                    return;
                                }
                            }
                        }
                    })
                }
            }

            if (!same) {
                htmlText = '<div class="selection__result' + (required ? ' required' : ' add') + '">' +
                    '<div class="selection__text">' +
                    '<ul>';
                if (required) {
                    htmlText += '<li data-price={{$data['detail']->price}}>{{$data['detail']->name}}</li>';

                    optionTmp.map(function (item) {
                        htmlText += '<li data-name="' + item['name'] + '" data-option_name="' + item['option_name'] + '" data-price="' + item['option_price'] + '">' + item['option_name'] + '</li>';
                    })
                } else {
                    htmlText += '<li data-price="0">' + $(this).parents('.dropdown').find('.dropdown__title').data('placeholder') + '</li>' +
                        '<li data-name="' + $(this).parents('.dropdown').find('.dropdown__title').data('placeholder') + '" data-option_name="' + $(this).data('option_name') + '" data-price="' + $(this).data('price') + '">' + $(this).data('option_name') + '</li>';
                }
                htmlText += '</ul>' +
                    '<button class="ico__delete18">' +
                    '<span class="a11y">삭제</span>' +
                    '</button>' +
                    '</div>' +
                    '<div class="selection__box">' +
                    '<ul class="selection__count">' +
                    '<li class="count__minus">' +
                    '<button type="button" class="btn_minus"><i class="ico__count--minus"><span class="a11y">빼기</span></i></button>' +
                    '</li>' +
                    '<li class="count__text" style="width:30px;">' +
                    '<input type="text" id="qty_input" name="qty_input" value="1" maxlength="3" style="width:100%;height:100%;text-align: center;">' +
                    '</li>' +
                    '<li class="count__plus">' +
                    '<button type="button" class="btn_plus"><i class="ico__count--plus"><span class="a11y">더하기</span></i></button>' +
                    '</li>' +
                    '</ul>' +
                    '<p class="selection__price">';

                if ({{$data['detail']->is_price_open}} != 0) {
                    htmlText += '<span class="price">0</span>원';
                } else {
                    htmlText += '<span class="price">{{$data['detail']->price_text}}</span>';
                }

                htmlText += '</p>' +
                    '</div>' +
                    '</div>';

                if(required && $('.selection__result.add').length > 0 ) {
                    $('.selection__result.add').first().before(htmlText);
                } else {
                    $('.right-wrap__selection .result').append(htmlText);
                }

                $('.dropdown').map(function () {
                    $(this).find('.dropdown__title').text($(this).find('.dropdown__title').data('placeholder'));
                })
                optionTmp = [];

                reCal();
                $('.order__button-group button').prop('disabled', false);
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

            openModal('#alert-modal')
        }

        // 즐겨찾기
        function addInterest() {
            if (isProc) {
                return;
            }
            isProc = true;

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url             : '/product/interest/{{$data['detail']->idx}}',
                enctype         : 'multipart/form-data',
                processData     : false,
                contentType     : false,
                data			: {},
                type			: 'POST',
                success: function (result) {
                    if (result.success) {
                        if (result.interest == 0) {
                            $('.product-bookmark.active').removeClass('active');
                        } else {
                            $('.product-bookmark').addClass('active');
                        }
                    } else {
                        alert(reslult.message);
                    }

                    isProc = false;
                }
            });
        }

        // 옵션 선택 후 가격 계산
        function reCal() {
            if ( {{$data['detail']->is_price_open}} == 0) {
                return;
            }

            var price = 0;

            $('.selection__result').map(function () {
                var resultPrice = 0;

                $(this).find('.selection__text li').map(function () {
                    resultPrice += parseInt($(this).data('price'));
                })
                resultPrice = resultPrice * $(this).find('#qty_input').val();
                $(this).find('.selection__price span').text(resultPrice.toLocaleString());

                price += resultPrice;
            })

            $('#total_price').text(price.toLocaleString());
            $('#total_price').data('total_price', price);
        }

        // 장바구니 : 0 / 바로주문 : 1
        function cart(type) {
            var requiredCnt = $('.dropdown.required').length;

            if(requiredCnt > 0) {
                if ($('.selection__result.required').length == 0) {
                    openModal('#alert-modal01');
                    return;
                }
            }

            var form = new FormData();
            form.append("productIdx", {{$data['detail']->idx}});
            form.append("required", $('.dropdown.required').length > 0 ? 1 : 0);

            var optionArr = new Array();
            $('.selection__result').map(function () {
                var cardList = new Array();
                $(this).find('.selection__text li').map(function () {
                    var option = new Object();
                    option.required = $(this).parents('.selection__result').is('.required') ? 1 : 0;
                    option.name = $(this).data('name');
                    option.value = $(this).data('option_name');
                    option.price = $(this).data('price');
                    option.count = $(this).parents('.selection__result').find('.selection__box #qty_input').val();
                    cardList.push(option);
                })
                optionArr.push(cardList);
            })
            form.append("option", JSON.stringify(optionArr));

            if (type == 0) {
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
                            openModal('#alert-modal05');
                            if ($('.dropdown__wrap .dropdown__item').length > 0) {
                                $('.selection__result').map(function () {
                                    $(this).remove();
                                })
                            }

                            $('#total_price').text('0');
                            if ($('.dropdown__item').length > 0) {
                                $('.order__button-group button').prop('disabled', true);
                            }
                        }
                    }
                });
            } else {
                location.href = encodeURI('/order?productIdx={{$data['detail']->idx}}&required='+($('.dropdown.required').length > 0 ? 1 : 0)+'&option='+JSON.stringify(optionArr));
            }
        }

        $('body').on('click', '.dropdown', function () {
            if ($('.dropdown.dropdown--active').length > 0) {
                $('.dropdown.dropdown--active').removeClass('dropdown--active');
                $(this).addClass('dropdown--active');
            }
        })
    </script>
@endsection
