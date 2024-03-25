@extends('layouts.app_m')
@php
    $only_quick = '';
    $header_depth = '';
    $top_title = '';
    $header_banner = '';
@endphp
@section('content')
@include('layouts.header_m')

<div id="content">
    <section class="sub">
        <div class="inner">
            <div class="main_tit mb-5 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>BEST 신상품</h3>
                </div>
                <div class="flex">
                    <button class="zoom_btn flex items-center gap-1" onclick="modalOpen('#zoom_view-modal')"><svg><use xlink:href="/img/icon-defs.svg#zoom"></use></svg>확대보기</button>
                </div>
            </div>
            <div class="relative">
                <ul class="prod_list">
                    @foreach ($bestNewProducts as $item)
                        <li class="prod_item">
                            <div class="img_box">
                                <a href="/product/detail/{{ $item->idx }}"><img src="{{ $item->imgUrl }}" alt=""></a>
                                <button class="zzim_btn prd_{{ $item->idx }} {{ ($item->isInterest == 1) ? 'active' : '' }}" pidx="{{ $item->idx }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="/product/detail/{{ $item->idx }}">
                                    <span>{{ $item->companyName }}</span>
                                    <p>{{ $item->name }}</p>
                                    <b>{{ number_format($item->price, 0) }}원</b>
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
    {{-- BEST 신상품 : 확대보기 --}}
    @include('m.product.best-new-product-ext')
</div>
<script>
    // BEST 신상품 - 확대보기
    const zoom_prod_list = new Swiper("#zoom_view-modal .slide_box", {
        slidesPerView: 1,
        spaceBetween: 30,
        navigation: {
            nextEl: "#zoom_view-modal .arrow.next",
            prevEl: "#zoom_view-modal .arrow.prev",
        },
        pagination: {
            el: "#zoom_view-modal.count_pager",
            type: "fraction",
        },
    });
</script>
@endsection