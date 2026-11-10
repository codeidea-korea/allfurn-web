@php($pricing = \App\Support\EstimatePricing::forEstimate($row))
@if($pricing['options'])
    <div class="noline">
        @foreach($pricing['options'] as $option)
            @foreach($option['optionValue'] as $value)
                <div class="option_item">
                    <div><p class="option_name">{{ $value['propertyName'] ?? $option['optionName'] ?? '' }}</p></div>
                    <div class="mt-2">
                        <div>{{ $value['count'] }}개</div>
                        <div class="price">{{ $pricing['hidden'] ? '업체 협의' : number_format($value['each_price']) }}</div>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>
@endif
<div class="prod_option">
    <div class="name">수량</div>
    <div>{{ $pricing['count'] }}개</div>
</div>
<div class="prod_option">
    <div class="name">상품금액</div>
    <div class="total_price">{{ ($pricing['hidden'] || $pricing['inquiry']) ? '업체 협의' : number_format($pricing['subtotal']).'원' }}</div>
</div>
