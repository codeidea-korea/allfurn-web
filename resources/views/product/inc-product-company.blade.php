@foreach ($list as $key => $item )
    <div class="prod_info">
        <div class="img_box">
            <input type="checkbox" id="check_{{ $item->idx  }}" name="req_idx[{{ $item->idx }}]" value="{{ $item->idx }}" class="hidden">
            <label for="check_{{ $item->idx  }}" class="add_btn" onclick="prodAdd(this)">추가</label>
            <img src="{{ $item->imgUrl }}" alt="">
        </div>

        @if(isset($item->product_option) && $item->product_option != '[]')
            <?php $arr = json_decode($item->product_option); $required = false; $inx = 0; ?>
            @foreach($arr as $item2)
            
            <div class="info_box">
                <div class="prod_name">{{$item2->optionName}}</div>
                <div class="dropdown_wrap noline">
                    <button class="dropdown_btn" onclick="openOption({{$item->idx}}, {{$inx}})"><p>{{$item2->optionName}} 선택
                            @if($item2->required == 1)
                                (필수)
                            @else
                                (선택)
                            @endif</p></button>
                    <div class="dropdown_list _productOption_{{$item->idx}}_{{$inx}}">
                        @foreach($item2->optionValue as $sub)
                            <div class="dropdown_item" data-option_name="{{$sub->propertyName}}" data-price="{{$sub->price}}" onclick="$('.option_item[data-option_key={{$item->idx}}_{{$inx}}][data-option_name={{$sub->propertyName}}]').show(); $(this).parent().hide();">
                                    {{$sub->propertyName}}
                                    @if((int)$sub->price > 0 && $item->is_price_open == 1)
                                        <span class="price" data-price={{$sub->price}}><?php echo number_format((int)$sub->price, 0); ?>원</span>
                                    @endif</div>
                        @endforeach
                    </div>
                </div>
                <div class="noline">
                    
                    @foreach($item2->optionValue as $sub)
                        <div class="option_item" style="display: none;" data-option_key="{{$item->idx}}_{{$inx++}}" data-option_name="{{$sub->propertyName}}" data-price="{{$sub->price}}">
                            <div class="">
                                <p class="option_name">{{$sub->propertyName}}</p>
                                <button onclick="$(this).parent().parent().hide();"><img src="/pc/img/icon/x_icon2.svg" alt=""></button>
                            </div>
                            <div class="mt-2">
                                <div class="count_box2">
                                    <button class="minus" data-price="{{$item->is_price_open ? $item->price : 0}}"><svg><use xlink:href="/img/icon-defs.svg#minus"></use></svg></button>
                                    <input type="text" id="product_count_sub_{{ $key }}" name="product_count_sub[{{ $key }}]" value="1">
                                    <button class="plus" data-price="{{$item->is_price_open ? $item->price : 0}}"><svg><use xlink:href="/img/icon-defs.svg#plus"></use></svg></button>
                                </div>
                                <div class="price"><?php echo number_format((int)$item->price, 0); ?></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="prod_option">
                    <div class="name">가격</div>
                    <div class="sub_tot_price"></div>
                </div>
            </div>
            @endforeach
        @else
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
        @endif
    </div>
    <hr>
@endforeach
