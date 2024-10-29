@foreach ($list as $item )
    <li class="prod_item">
        <div class="img_box custom_input2">
            <label for="new_esti_{{ $item->idx }}">
                <img src="{{ $item->imgUrl }}" alt="">
            </label>
            <input type="checkbox" style="right: 0px;bottom: 0px;" id="new_esti_{{ $item->idx }}" name="product_idxs[]" value="{{ $item->idx }}" />
        </div>
        <div class="txt_box">
            <a href="/product/detail/{{ $item->idx }}">
                <span>{{$item->companyName}}</span>
                <p>{{ $item->name }}</p>
                <b>{{$item->is_price_open ? number_format($item->price, 0).'원': $item->price_text}}</b>
            </a>
        </div>
    </li>
@endforeach
