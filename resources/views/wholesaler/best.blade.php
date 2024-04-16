@extends('layouts.app')

@section('content')
@include('layouts.header')
<div id="content">
    <section class="sub">
        <div class="inner">
            <div class="main_tit mb-8 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>BEST 신상품</h3>
                    <button class="zoom_btn flex items-center gap-1" onclick="modalOpen('#zoom_view-modal')"><svg><use xlink:href="/img/icon-defs.svg#zoom"></use></svg>확대보기</button>
                </div>
            </div>
            <div class="relative">
                @if( count( $productList ) > 0 )
                <ul class="prod_list">
                    @foreach( $productList AS $key => $item )
                    <li class="prod_item">
                        <div class="img_box">
                            <a href="/product/detail/{{$item->product_idx}}"><img src="{{$item->imgUrl}}" alt="{{$item->name}}"></a>
                            <button class="zzim_btn prd_{{$item->product_idx}} {{($item->isInterest==1)?'active':''}}" pidx="{{$item->product_idx}}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                        <div class="txt_box">
                            <a href="/product/detail/{{$item->product_idx}}">
                                <span>{{$item->companyName}}</span>
                                <p>{{$item->name}}</p>
                                <b>{{number_format( $item->price )}}원</b>
                            </a>
                        </div>
                    </li>
                    @endforeach
                    {{--
                    <li class="prod_item">
                        <div class="img_box">
                            <a href="./prod_detail.php"><img src="/img/prod_thumb2.png" alt=""></a>
                            <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                        <div class="txt_box">
                            <a href="./prod_detail.php">
                                <span>올펀가구</span>
                                <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                <b>112,500원</b>
                            </a>
                        </div>
                    </li>
                    <li class="prod_item">
                        <div class="img_box">
                            <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                            <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                        <div class="txt_box">
                            <a href="./prod_detail.php">
                                <span>올펀가구</span>
                                <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                <b>112,500원</b>
                            </a>
                        </div>
                    </li>
                    <li class="prod_item">
                        <div class="img_box">
                            <a href="./prod_detail.php"><img src="./img/sale_thumb.png" alt=""></a>
                            <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                        <div class="txt_box">
                            <a href="./prod_detail.php">
                                <span>올펀가구</span>
                                <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                <b>112,500원</b>
                            </a>
                        </div>
                    </li>
                    <li class="prod_item">
                        <div class="img_box">
                            <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                            <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                        <div class="txt_box">
                            <a href="./prod_detail.php">
                                <span>올펀가구</span>
                                <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                <b>112,500원</b>
                            </a>
                        </div>
                    </li>
                    <li class="prod_item">
                        <div class="img_box">
                            <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                            <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                        <div class="txt_box">
                            <a href="./prod_detail.php">
                                <span>올펀가구</span>
                                <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                <b>112,500원</b>
                            </a>
                        </div>
                    </li>
                    <li class="prod_item">
                        <div class="img_box">
                            <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                            <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                        <div class="txt_box">
                            <a href="./prod_detail.php">
                                <span>올펀가구</span>
                                <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                <b>112,500원</b>
                            </a>
                        </div>
                    </li>
                    <li class="prod_item">
                        <div class="img_box">
                            <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                            <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                        <div class="txt_box">
                            <a href="./prod_detail.php">
                                <span>올펀가구</span>
                                <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                <b>112,500원</b>
                            </a>
                        </div>
                    </li>
                    <li class="prod_item">
                        <div class="img_box">
                            <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                            <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                        <div class="txt_box">
                            <a href="./prod_detail.php">
                                <span>올펀가구</span>
                                <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                <b>112,500원</b>
                            </a>
                        </div>
                    </li>
                    <li class="prod_item">
                        <div class="img_box">
                            <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                            <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                        <div class="txt_box">
                            <a href="./prod_detail.php">
                                <span>올펀가구</span>
                                <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                <b>112,500원</b>
                            </a>
                        </div>
                    </li>
                    <li class="prod_item">
                        <div class="img_box">
                            <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                            <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                        <div class="txt_box">
                            <a href="./prod_detail.php">
                                <span>올펀가구</span>
                                <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                <b>112,500원</b>
                            </a>
                        </div>
                    </li>
                    <li class="prod_item">
                        <div class="img_box">
                            <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                            <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                        <div class="txt_box">
                            <a href="./prod_detail.php">
                                <span>올펀가구</span>
                                <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                <b>112,500원</b>
                            </a>
                        </div>
                    </li>
                    <li class="prod_item">
                        <div class="img_box">
                            <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                            <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                        <div class="txt_box">
                            <a href="./prod_detail.php">
                                <span>올펀가구</span>
                                <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                <b>112,500원</b>
                            </a>
                        </div>
                    </li>
                    <li class="prod_item">
                        <div class="img_box">
                            <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                            <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                        <div class="txt_box">
                            <a href="./prod_detail.php">
                                <span>올펀가구</span>
                                <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                <b>112,500원</b>
                            </a>
                        </div>
                    </li>
                    <li class="prod_item">
                        <div class="img_box">
                            <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                            <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                        <div class="txt_box">
                            <a href="./prod_detail.php">
                                <span>올펀가구</span>
                                <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                <b>112,500원</b>
                            </a>
                        </div>
                    </li>
                    <li class="prod_item">
                        <div class="img_box">
                            <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                            <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                        <div class="txt_box">
                            <a href="./prod_detail.php">
                                <span>올펀가구</span>
                                <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                <b>112,500원</b>
                            </a>
                        </div>
                    </li>
                    <li class="prod_item">
                        <div class="img_box">
                            <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                            <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                        <div class="txt_box">
                            <a href="./prod_detail.php">
                                <span>올펀가구</span>
                                <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                <b>112,500원</b>
                            </a>
                        </div>
                    </li>
                    <li class="prod_item">
                        <div class="img_box">
                            <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                            <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                        <div class="txt_box">
                            <a href="./prod_detail.php">
                                <span>올펀가구</span>
                                <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                <b>112,500원</b>
                            </a>
                        </div>
                    </li>
                    <li class="prod_item">
                        <div class="img_box">
                            <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                            <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                        <div class="txt_box">
                            <a href="./prod_detail.php">
                                <span>올펀가구</span>
                                <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                <b>112,500원</b>
                            </a>
                        </div>
                    </li>
                    <li class="prod_item">
                        <div class="img_box">
                            <a href="./prod_detail.php"><img src="./img/prod_thumb.png" alt=""></a>
                            <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                        <div class="txt_box">
                            <a href="./prod_detail.php">
                                <span>올펀가구</span>
                                <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                <b>112,500원</b>
                            </a>
                        </div>
                    </li>
                    --}}
                </ul>
               @endif
            </div>
        </div>
    </section>
</div>