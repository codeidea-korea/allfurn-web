@foreach ($list as $key => $item )
<div class="prod_info">
    <div class="img_box">
        @if( $key == 0 )
        <input type="checkbox" id="check_4" class="hidden" checked disabled>
        <label for="check_4" class="add_btn">대표</label>
        @endif
        <img src="{{ $item->imgUrl }}" alt="">
    </div>

    @if(isset($item->product_option) && $item->product_option != '[]')
        <?php $arr = json_decode($item->product_option); $required = false; $inx = 0; ?>
        
        <div class="info_box">
            <div class="prod_name">{{$item->name}}</div>
            
            <div class="noline _productChooseOptions_{{$item->idx}}">
                @foreach($arr as $item2)
                    @foreach($item2->optionValue as $sub)
                        <div class="option_item">
                            <div class="">
                                <p class="option_name">{{$sub->propertyName}}</p>
                            </div>
                            <div class="mt-2">
                                <div class="count_box2">
                                {{$item->p_cnt}}
                                </div>
                                <div class="price">{{$sub->price}}</div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    @else
    <div class="info_box">
        <div class="prod_name">{{$item->name}}</div>
        <div class="prod_option">
            <div class="name">수량</div>
            <div>{{ number_format( $item->p_cnt ) }}</div>
        </div>
        <div class="prod_option">
            <div class="name">단가</div>
            <div>{{$item->is_price_open ? number_format($item->price * $item->p_cnt, 0).'원': $item->price_text}}</div>
        </div>
    </div>
    @endif
</div>
<hr>
@endforeach