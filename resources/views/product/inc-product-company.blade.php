@foreach ($list as $key => $item )
    <div class="prod_info">
        <div class="img_box">
            <input type="checkbox" id="check_{{ $key  }}" name="req_idx[{{ $key }}]" value="{{ $item->idx }}" class="hidden">
            <label for="check_{{ $key  }}" class="add_btn" onclick="prodAdd(this)">추가</label>
            <img src="{{ $item->imgUrl }}" alt="">
        </div>
        <div class="info_box">
            <div class="prod_name">{{$item->name}}</div>
            <div class="prod_option">
                <div class="name">수량</div>
                <div>
                    <div class="count_box2">
                        <button type="button" data-price="{{$item->is_price_open ? $item->price : 0}}" class="minus"><svg><use xlink:href="/img/icon-defs.svg#minus"></use></svg></button>
                        <input type="text" id="product_count_sub_{{ $key }}" name="product_count_sub[{{ $key }}]" value="1">
                        <button type="button" data-price="{{$item->is_price_open ? $item->price : 0}}" class="plus"><svg><use xlink:href="/img/icon-defs.svg#plus"></use></svg></button>
                    </div>
                </div>
            </div>
            <div class="prod_option">
                <div class="name">단가</div>
                <div class="sub_tot_price">{{$item->is_price_open ? number_format($item->price, 0).'원': $item->price_text}}</div>
            </div>
        </div>
    </div>
    <hr>
@endforeach
