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