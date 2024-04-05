@foreach ( $list as $wholesaler )
<li>
    <div class="txt_box">
        <div>
            <a href="/wholesaler/detail/{{ $wholesaler->companyIdx }}">
                <img src="/img/icon/crown.png" alt="">
                {{ $wholesaler->companyName }}
                <svg><use xlink:href="/img/icon-defs.svg#more_icon"></use></svg>
            </a>
            <i>{{ $wholesaler->location }}</i>
            <div class="tag">
                @foreach( explode( ',', $wholesaler->categoryList ) AS $category )
                    <span>{{$category}}</span>
                @endforeach
            </div>
        </div>
        <button class="zzim_btn {{ $wholesaler->isCompanyInterest == 1 ? 'active' : '' }}" data-company-idx='{{$wholesaler->companyIdx}}' onclick="toggleCompanyLike({{$wholesaler->companyIdx}})"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg> 좋아요</button>
    </div>
    <div class="prod_box">
        @foreach ($wholesaler->productList as $product)
            <div class="img_box">
                <a href="/product/detail/{{ $product->productIdx }}"><img src="{{ $product->imgUrl }}" alt=""></a>
                <button class="zzim_btn prd_{{ $product->productIdx }} {{ $product->isInterest == 1 ? 'active' : '' }}" pidx="{{ $product->productIdx }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
            </div>
        @endforeach
    </div>
</li> 
@endforeach
