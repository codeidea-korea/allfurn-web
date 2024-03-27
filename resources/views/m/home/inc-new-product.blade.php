<section class="main_section new_prod overflow-hidden">
    <div class="inner">
        <div class="main_tit mb-5 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <h3>신규 등록 상품</h3>
            </div>
            <div class="flex items-center gap-7">
                <button class="zoom_btn flex items-center gap-1" onclick="modalOpen('#zoom_view-modal-new')"><svg><use xlink:href="/img/icon-defs.svg#zoom"></use></svg>확대보기</button>
            </div>
        </div>
        <div class="relative">
            <div class="slide_box prod_slide-2">
                <ul class="swiper-wrapper">
                    @foreach($data['new_product'] as $item)
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="/product/detail/{{ $item->idx }}"><img src="{{ $item->imgUrl }}" alt=""></a>
                                <button class="zzim_btn prd_{{ $item->idx }} {{ ($item->isInterest == 1) ? 'active' : '' }}" pidx="{{ $item->idx }}"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
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
        <a href="/product/new" class="btn btn-line4 mt-4">더보기</a>
    </div>
</section>
@php $list = $data['new_product'] @endphp
@include('m.product.new-product-ext')