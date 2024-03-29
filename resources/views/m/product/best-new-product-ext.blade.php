<div class="modal" id="zoom_view-modal">
    <div class="modal_bg" onclick="modalClose('#zoom_view-modal')"></div>
    <div class="modal_inner x-full zoom_view_wrap">
        <button class="close_btn" onclick="modalClose('#zoom_view-modal')"><svg><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body">
            <div class="slide_box zoom_prod_list">
                <ul class="swiper-wrapper">
                    @foreach($bestNewProducts as $item)
                        <li class="swiper-slide">
                            <div class="img_box">
                                <a href="/product/detail/{{ $item->idx }}">
                                    <img src="{{ $item->imgUrl }}" alt="">
                                </a>
                                <button class="zzim_btn prd_{{ $item->idx }} {{ ($item->isInterest == 1) ? 'active' : '' }}" pidx="{{ $item->idx }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <div>
                                    <h5>{{ $item->companyName }}</h5>
                                    <p>{{ $item->name }}</p>
                                    <b>{{$item->is_price_open ? number_format($item->price, 0).'원': $item->price_text}}</b>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="bottom_navi">
                <button class="arrow prev type03"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow_white"></use></svg></button>
                <div class="count_pager dark_type"><b>1</b> / 12</div>
                <button class="arrow next type03"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow_white"></use></svg></button>
            </div>
        </div>
    </div>
</div>