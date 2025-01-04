@foreach ( $list as $wholesaler )
<li>
    <div class="txt_box" onclick="saveDetail({{ $wholesaler->company_idx }})">
        <div>
            <a href="javascript:;">
                @if($wholesaler->rank <= 50)
                    <img src="/img/icon/crown.png" alt="">
                @endif
                {{ $wholesaler->company_name }}
                <svg><use xlink:href="/img/icon-defs.svg#more_icon"></use></svg>
            </a>
            <i>{{ $wholesaler->location }}</i>
            <div class="tag">
                @foreach( $wholesaler->categoryList AS $category )
                    <span>{{$category->name}}</span>
                @endforeach 
            </div>
        </div>
        <button class="zzim_btn {{ $wholesaler->isCompanyInterest == 1 ? 'active' : '' }}" data-company-idx='{{$wholesaler->company_idx}}' onclick="toggleCompanyLike({{$wholesaler->company_idx}})"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg> 좋아요</button>
    </div>
    <div class="prod_box">
        @foreach ($wholesaler->productList as $product)
            <div class="img_box">
                <a href="javascript:saveDetail({{ $wholesaler->company_idx }}, '/product/detail/{{ $product->productIdx }}')"><img src="{{ $product->imgUrl }}" alt="" width="180" height="180" loading="lazy"></a>
                <button class="zzim_btn prd_{{ $product->productIdx }} {{ $product->isInterest == 1 ? 'active' : '' }}" pidx="{{ $product->productIdx }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
            </div>
        @endforeach
    </div>
</li> 
@endforeach
