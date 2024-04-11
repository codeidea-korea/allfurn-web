@foreach ( $list as $wholesaler )
@php
    $companyIdx = isset($wholesaler->companyIdx) ? $wholesaler->companyIdx : $wholesaler->company_idx;
    $companyName = isset($wholesaler->companyName) ? $wholesaler->companyName : $wholesaler->company_name;
@endphp
<li>
    <div class="txt_box">
        <div class="flex items-center justify-between">
            <a href="/wholesaler/detail/{{ $companyIdx }}">
                <img src="/img/icon/crown.png" alt="">
                {{ $companyName }}
                <svg><use xlink:href="/img/icon-defs.svg#more_icon"></use></svg>
            </a>
            <button class="zzim_btn {{ $wholesaler->isCompanyInterest == 1 ? 'active' : '' }}" data-company-idx='{{$companyIdx}}' onclick="toggleCompanyLike({{$companyIdx}})"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
        </div>
        <div class="flex items-center justify-between">
            <div class="tag">
                @foreach( explode( ',', $wholesaler->categoryList ) AS $category )
                    <span>{{$category}}</span>
                @endforeach
            </div>
            <i class="shrink-0">{{ $wholesaler->location }}</i>
        </div>
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