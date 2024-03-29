@foreach ($list as $product)
    <li class="prod_item">
        <div class="img_box">
            <a href="/product/detail/{{ $product->idx }}"><img src="{{ $product->product_image }}" alt=""></a>
            <button class="zzim_btn active prd_{{ $product->idx }}" pidx="{{ $product->idx }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
        </div>
        <div class="txt_box">
            <a href="/product/detail/{{ $product->idx }}">
                <span>{{ $product->company_name }}</span>
                <p>{{ $product->product_name }}</p>
                <b>{{$product->is_price_open ? number_format($product->price, 0).'원': $product->price_text}}</b>
            </a>
        </div>
    </li>
@endforeach