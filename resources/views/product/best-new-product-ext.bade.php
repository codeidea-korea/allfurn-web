<div class="modal" id="zoom_view-modal">
    <div class="modal_bg" onclick="modalClose('#zoom_view-modal')"></div>
    <div class="modal_inner modal-lg zoom_view_wrap">
        <div class="count_pager dark_type"><b>1</b> / 12</div>
        <button class="close_btn" onclick="modalClose('#zoom_view-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body">
            <div class="slide_box zoom_prod_list">
                <ul class="swiper-wrapper">
                    @foreach($data['productAd'] as $item)
                        <li class="swiper-slide">
                            <div class="img_box">
                                <img src="{{ $item->imgUrl }}" alt="">
                                <button class="zzim_btn"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
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
