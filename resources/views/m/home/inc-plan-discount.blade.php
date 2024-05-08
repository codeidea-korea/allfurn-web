<section class="main_section sale_prod overflow-hidden">
    <div class="inner">
        <div class="main_tit mb-5 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <h3>할인 상품이 필요하신가요?</h3>
            </div>
        </div>
        <div class="relative">
            <div class="slide_box ">
                <ul class="swiper-wrapper">
                    @foreach ($data['plandiscount_ad'] as $key => $goods)
                        <li class="swiper-slide prod_item type02">
                            <div class="img_box">
                                <a href="{{ $goods->web_link }}">
                                    <img src="{{ $goods->imgUrl }}" alt="">
                                    <span><b>{{ $goods->subtext1 }}</b><br/>{{ $goods->subtext2 }}</span>
                                </a>
                                @if ($goods->gidx != "")
                                    <button class="zzim_btn prd_{{ $goods->gidx }} {{ ($goods->interest == 1) ? 'active' : '' }}" pidx="{{ $goods->gidx }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                @endif 
                            </div>
                            <div class="txt_box">
                                <a href="{{ $goods->web_link }}">
                                    <strong>{{ $goods->content }}</strong>
                                    <span>{{ $goods->companyName }}</span>
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <a href="/product/planDiscountDetail" class="btn btn-line4 mt-7">더보기</a>
    </div>
</section>