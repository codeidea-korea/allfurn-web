<section class="main_section sale_prod">
    <div class="inner">
        <div class="main_tit mb-8 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <h3>할인 상품이 필요하신가요?</h3>
            </div>
            <div class="flex items-center gap-7">
                <div class="count_pager"><b>1</b> / 12</div>
                <a class="more_btn flex items-center" href="/product/thisMonth">더보기<svg><use xlink:href="./img/icon-defs.svg#more_icon"></use></svg></a>
            </div>
        </div>
        <div class="relative">
            <div class="slide_box overflow-hidden">
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
            <button class="slide_arrow prev"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
            <button class="slide_arrow next"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
        </div>
    </div>
</section>