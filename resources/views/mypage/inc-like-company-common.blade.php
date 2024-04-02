@foreach ($list as $company)
    <li>
        <div class="txt_box">
            <div>
                <a href="{{ $company->company_type === 'W' ? '/wholesaler/detail/' .$company->company_idx : '' }}">
                    <img src="/img/icon/crown.png" alt="">
                    {{ $company->company_name }}
                    {!! ($company->company_type === 'W') ? '<svg><use xlink:href=\'/img/icon-defs.svg#more_icon\'></use></svg>' : '' !!}
                </a>
                <i>{{ $company->region }}</i>
                <div class="tag">
                    @php $category_names = explode(',', $company->category_names); @endphp
                    @foreach ( $category_names as $category_name)
                        <span>{{ $category_name }}</span>    
                    @endforeach
                </div>
            </div>
            <button class="zzim_btn active" onclick="toggleCompanyLike({{$company->idx}})"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg> 좋아요</button>
        </div>
        <div class="prod_box">
            @if($company->products)
                @if (substr($company->products, -1) === '}')
                    @foreach(json_decode("[".$company->products."]", true) as $product)
                        <div class="img_box">
                            <a href="javascript:;"><img src="{{ $product['image'] }}" alt=""></a>
                            <button class="zzim_btn prd_{{ $product['idx'] }} {{ ($product['isInterest'] == 1) ? 'active' : '' }}" pidx="{{ $product['idx']  }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                    @endforeach
                @else
                    @foreach(json_decode("[".$company->products."}]", true) as $product)
                        <div class="img_box">
                            <a href="javascript:;"><img src="{{ $product['image'] }}" alt=""></a>
                            <button class="zzim_btn prd_{{ $product['idx'] }} {{ ($product['isInterest'] == 1) ? 'active' : '' }}" pidx="{{ $product['idx']  }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                    @endforeach
                @endif
            @endif
        </div>
    </li>
@endforeach