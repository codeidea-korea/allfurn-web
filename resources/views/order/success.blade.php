@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
    <div id="container" class="container" style="min-height: 100%;">
        <div class="inner">
            <div class="content">
                <div class="completed">
                    <div class="completed__message">
                        <img src="/images/sub/order_competed@2x.png" alt="주문 완료">
                        <p>주문이 완료 되었습니다.</p>
                    </div>
                    <div class="completed__info">
                        <h3>주문 정보</h3>
                        <div>
                            <dl>
                                <dt>수령인</dt>
                                <dd>{{$data['deliveryData']->name}}</dd>
                            </dl>
                            <dl>
                                <dt>연락처</dt>
                                <dd>{{preg_replace('/(^02.{0}|^01.{1}|^15.{2}|^16.{2}|^18.{2}|[0-9]{3})([0-9]+)([0-9]{4})/', '$1-$2-$3', $data['deliveryData']->phone_number)}}</dd>
                            </dl>
                            <dl>
                                <dt>배송지</dt>
                                <dd>{{$data['deliveryData']->address}}</dd>
                            </dl>
                            <dl>
                                <dt>총 주문 금액</dt>
                                <dd>
                                    @if($data['deliveryData']->inquiry != null)
                                        {{$data['deliveryData']->inquiry}}
                                    @else
                                        {{number_format($data['deliveryData']->price, 0)}}원
                                    @endif
                            </dl>
                        </div>
                        <div class="info__notice">
                            <i class="ico__info"><span class="a11y">정보</span></i>
                            <p>수령인의 연락처나 배송받을 주소가 변경될 경우, 업체에게 직접 알려주세요.</p>
                        </div>
                    </div>

                    <div class="completed__product">
                        <h3>주문 상품</h3>
                        <ul>
                            @foreach($data['productData'] as $item)
                                <li>
                                    <div class="product__head">
                                        <h4>No. {{explode('-', $item->order_code)[0]}}</h4>
                                        <a href="/mypage/order/detail?orderGroupCode={{explode('-', $item->order_code)[0]}}&type=P">
                                            <p>상세보기</p>
                                            <i class="ico__arrow--right14"><span class="a11y">오른쪽 화살표</span></i>
                                        </a>
                                    </div>
                                    <div class="product__content">
                                        <div class="content__img-wrap">
                                            <img src="<?php echo preImgUrl(); ?>{{$item->imgUrl}}" alt="{{$item->name}}">
                                        </div>
                                        <div class="content__text-wrap">
                                            <p class="brand">{{$item->companyName}}</p>
                                            <p class="name">{{$item->name}}
                                                @if($item->productCnt > 1)
                                                    외 {{$item->productCnt - 1}}건
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="completed__button-group">
                        <button type="button" class="button button--blank" onclick="location.href='/'">쇼핑 계속하기</button>
                        <button type="button" class="button button--solid" onclick="location.href='/mypage/purchase'">주문 현황 보러가기</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>

    </script>
@endsection
