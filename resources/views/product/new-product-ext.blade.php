<div class="modal" id="zoom_view-modal-new">
    <div class="modal_bg" onclick="modalClose('#zoom_view-modal-new')"></div>
    <div class="modal_inner modal-lg zoom_view_wrap">
        <div class="count_pager dark_type"><b>1</b> / 12</div>
        <button class="close_btn" onclick="modalClose('#zoom_view-modal-new')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body">
            <div class="slide_box zoom_prod_list zoom_prod_list2">
                <ul class="swiper-wrapper">
                    @if(!empty($product))
                        @foreach($product as $item)
                            <li class="swiper-slide">
                                <div class="img_box">
                                    <img src="{{ $item->imgUrl }}" alt="">
                                    <button class="zzim_btn prd_{{ $item->idx }} {{ ($item->isInterest == 1) ? 'active' : '' }}" pidx="{{ $item->idx }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <div>
                                        <h5>{{ $item->companyName }}</h5>
                                        <p>{{ $item->name }}</p>
                                        <b>{{$item->is_price_open ? number_format($item->price, 0).'원': $item->price_text}}</b>
                                    </div>
                                    <a href="/product/detail/{{ $item->idx }}">제품상세보기</a>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <button class="slide_arrow prev type03"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow_white"></use></svg></button>
            <button class="slide_arrow next type03"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow_white"></use></svg></button>
            @if(!empty($product))
                <button class="slide_arrow next type03 more_btn hidden" onclick="location.href='/product/new?scroll=true'">더보기</button>
            @else
                <button class="slide_arrow next type03 more_btn hidden" onclick="loadNewProductList()">더보기</button>
            @endif
        </div>
    </div>
</div>