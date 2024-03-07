<section class="main_section new_prod">
    <div class="inner">
        <div class="main_tit mb-8 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <h3>신규 등록 상품</h3>
                <button class="zoom_btn flex items-center gap-1" onclick="modalOpen('#zoom_view-modal-new')"><svg><use xlink:href="./img/icon-defs.svg#zoom"></use></svg>확대보기</button>
            </div>
            <div class="flex items-center gap-7">
                <div class="count_pager"><b>1</b> / 12</div>
                <a class="more_btn flex items-center" href="/product/new">더보기<svg><use xlink:href="./img/icon-defs.svg#more_icon"></use></svg></a>
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
            <button class="slide_arrow prev"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
            <button class="slide_arrow next"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
        </div>
    </div>
</section>

<div class="modal" id="zoom_view-modal-new">
    <div class="modal_bg" onclick="modalClose('#zoom_view-modal-new')"></div>
    <div class="modal_inner modal-lg zoom_view_wrap">
        <div class="count_pager dark_type"><b>1</b> / 12</div>
        <button class="close_btn" onclick="modalClose('#zoom_view-modal-new')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body">
            <div class="slide_box zoom_prod_list zoom_prod_list2">
                <ul class="swiper-wrapper">
                    @foreach($data['new_product'] as $item)
                        <li class="swiper-slide">
                            <div class="img_box">
                                <img src="{{ $item->imgUrl }}" alt="">
                                <button class="zzim_btn prd_{{ $item->idx }} {{ ($item->isInterest == 1) ? 'active' : '' }}" pidx="{{ $item->idx }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <div>
                                    <h5>{{ $item->companyName }}</h5>
                                    <p>{{ $item->name }}</p>
                                    <b>{{ number_format($item->price, 0) }}원</b>
                                </div>
                                <a href="/product/detail/{{ $item->idx }}">제품상세보기</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <button class="slide_arrow prev type03"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow_white"></use></svg></button>
            <button class="slide_arrow next type03"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow_white"></use></svg></button>
        </div>
    </div>
</div>
