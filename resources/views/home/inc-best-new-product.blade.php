<section class="main_section best_prod">
    <div class="inner">
        <div class="main_tit mb-8 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <h3>BEST 신상품</h3>
                <button class="zoom_btn flex items-center gap-1" onclick="modalOpen('#zoom_view-modal')"><svg><use xlink:href="/img/icon-defs.svg#zoom"></use></svg>확대보기</button>
            </div>
            <div class="flex items-center gap-7">
                <div class="count_pager"><b>1</b> / 12</div>
                <a class="more_btn flex items-center" href="/product/best-new">더보기<svg><use xlink:href="/img/icon-defs.svg#more_icon"></use></svg></a>
            </div>
        </div>
        <div class="relative">
            <div class="slide_box prod_slide-2">
                <ul class="swiper-wrapper">
                    @foreach ($data['productAd'] as $item)
                        @if($loop->index >= 120)
                        @else
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="/product/detail/{{ $item->idx }}"><img src="{{ $item->imgUrl }}" alt="" style="width:285px;"></a>
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
            <button class="slide_arrow prev"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
            <button class="slide_arrow next"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
        </div>
    </div>
</section>

@include('product.best-new-product-ext')