<div id="content">
    <div class="inner ">    
        <div class="mt-4">
            <div class="sub_filter">
                <div class="filter_box">
                    <button class="{{ request()->input('categories') != null ? 'on' : '' }}" onclick="modalOpen('#filter_category-modal')">카테고리 <b class="txt-primary">{{ request()->query('categories') != null ? count(explode(',', request()->query('categories'))) : '' }}</b></button>
                    <button class="{{ request()->input('regions') != null ? 'on' : '' }}" onclick="modalOpen('#filter_location-modal')">소재지 <b class="txt-primary">{{ request()->query('regions') != null ? count(explode(',', request()->query('regions'))) : '' }}</b></button>
                    <button class="refresh_btn" onclick="location.href='/mypage/like'">초기화 <svg><use xlink:href="/img/icon-defs.svg#refresh"></use></svg></button>
                </div>
            </div>
        </div>
    </div>

    <div class="inner">
        <div class="pt-1">
            <div class="flex items-center pb-3 justify-between">
                <span>전체 {{ $count }}개</span>
            </div>
        </div>
    </div>

    <ul class="obtain_list type02">
        @foreach ($list as $company)
            <li>
                <div class="txt_box">
                    <div class="flex items-center justify-between">
                        <a href="{{ $company->company_type === 'W' ? '/wholesaler/detail/' .$company->company_idx : '' }}">
                            <img src="/img/icon/crown.png" alt="">
                            {{ $company->company_name }}
                            {!! ($company->company_type === 'W') ? '<svg><use xlink:href=\'/img/icon-defs.svg#more_icon\'></use></svg>' : '' !!}
                        </a>
                        <button class="zzim_btn active" onclick="toggleCompanyLike({{$company->idx}})"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg> 좋아요</button>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="tag">
                            @php $category_names = explode(',', $company->category_names); @endphp
                            @foreach ( $category_names as $category_name)
                                <span>{{ $category_name }}</span>    
                            @endforeach
                        </div>
                        <i class="shrink-0">{{ $company->region }}</i>
                    </div>
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
    </ul>
    <div class="pagenation flex items-center justify-center py-12">
        @if($pagination['prev'] > 0)
            <a href="javascript:void(0)" onclick="moveToList({{$pagination['prev']}}"><</a>
        @endif
        @foreach($pagination['pages'] as $paginate)
            <a href="javascript:void(0)" onclick="moveToList({{$paginate}})" class="{{ $paginate == $offset ? 'active' : '' }}">{{$paginate}}</a>
        @endforeach
        @if($pagination['next'] > 0)
            <a href="javascript:void(0)" onclick="moveToList({{$pagination['next']}}">></a>
        @endif
    </div>
</div>
<script>
    $(document).ready(function() {
        //카테고리 선택시
        @if(request()->input('categories') != null)
            let selectedCategories = ["{{ request()->input('categories') }}"][0].split(',');;
            
            $("#filter_category-modal .check-form").each(function() {
                if(selectedCategories.indexOf($(this).siblings('label').text()) != -1) {
                    $(this).prop('checked', true);
                }
            });
        @endif

        @if(request()->input('regions') != null)
            let selectedRegions = ["{{ request()->input('regions') }}"][0].split(',');
            
            $("#filter_location-modal .check-form").each(function() {
                if(selectedRegions.indexOf($(this).siblings('label').text()) != -1) {
                    $(this).prop('checked', true);
                }
            });
        @endif
    });

    $(document).on('click', '[id^="filter"] .btn-primary', function() { 
        reloadWithFilter();
    })

    function reloadWithFilter() {
        let categories = [];
        $("#filter_category-modal .check-form:checked").each(function(){
            categories.push($(this).siblings('label').text());
        });

        let regions = [];
        $("#filter_location-modal .check-form:checked").each(function(){
            regions.push($(this).data('location'));
        });

        let bodies = {};
        const urlSearch = new URLSearchParams(location.search);
        if (categories.length>0) bodies.categories = categories;
        if (regions.length>0) bodies.regions =regions;
        location.href='/mypage/like?' + new URLSearchParams(bodies);
    }

    const moveToList = page => {
        let bodies = {offset:page};
        const urlSearch = new URLSearchParams(location.search);
        if (urlSearch.get('categories')) bodies.categories = urlSearch.get('categories');
        if (urlSearch.get('regions')) bodies.regions = urlSearch.get('regions');
        location.replace("/mypage/like?" + new URLSearchParams(bodies));
    }

    const toggleCompanyLike = like_idx => {
        fetch('/mypage/toggle/company/like', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            body: JSON.stringify({
                idx: like_idx
            })
        }).then(response => {
            if (response.ok) {
                return response.json();
            }
            throw new Error('Sever Error');
        }).then(json => {
            if (json.result === 'success') {
                location.reload();
            } else {
                alert(json.message);
            }
        }).catch(error => {
        })
    }

</script>