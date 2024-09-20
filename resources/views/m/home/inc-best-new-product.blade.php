<section class="main_section best_prod overflow-hidden">
    <div class="inner">
        <div class="main_tit mb-5 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <h3>BEST 신상품</h3>
            </div>
            <div class="flex items-center gap-7">
                <button class="zoom_btn flex items-center gap-1" onclick="modalOpen('#zoom_view-modal')"><svg><use xlink:href="./img/icon-defs.svg#zoom"></use></svg>확대보기</button>
            </div>
        </div>
        <div class="relative">
            <div class="slide_box prod_slide-2">
                <ul class="swiper-wrapper">
                    @foreach($data['productAd'] as $item)
                        @if($loop->index >= 120)
                        @else
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="/product/detail/{{ $item->idx }}"><img src="{{ $item->imgUrl }}" alt=""></a>
                                <button class="zzim_btn prd_{{ $item->idx }} {{ ($item->isInterest == 1) ? 'active' : '' }}" pidx="{{ $item->idx }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="/product/detail/{{ $item->idx }}">
                                    <span>{{ $item->companyName }}</span>
                                    <p>{{ $item->name }}</p>
                                    <b>{{ $item->is_price_open ? number_format($item->price, 0).'원': $item->price_text }}</b>
                                </a>
                            </div>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
        <a href="/product/best-new" class="btn btn-line4 mt-4">더보기</a>
    </div>
</section>

@include('m.product.best-new-product-ext')
