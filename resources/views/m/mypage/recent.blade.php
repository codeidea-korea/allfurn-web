@extends('layouts.app_m')
@php
$header_depth = 'mypage';
$top_title = '최근 본 상품';
$only_quick = '';
$header_banner = '';
@endphp
@section('content')
@include('layouts.header_m')

<div id="content">
    <div class="inner">    
        <div class="mt-4">
            <div class="sub_filter">
                <div class="filter_box">
                    <button class="{{ !empty($checked_categories) ? 'on' : '' }}" onclick="modalOpen('#filter_category-modal')">
                        카테고리
                        @if(!empty($checked_categories))
                            <b class="txt-primary">{{ count($checked_categories) }}</b>
                        @endif
                    </button>
                </div>
            </div>
        </div>
        
        @if (count($list) < 1)
            <div class="pt-1">
                <div class="flex items-center pb-3 justify-between">
                    <span>데이터가 존재하지 않습니다<div class=""></div></span>
                </div>
            </div>
        @else
            <div class="pt-1">
                <div class="flex items-center pb-3 justify-between">
                    <span>전체 {{ $count }}개</span>
                </div>
            </div>

            <div class="relative">
                <ul class="prod_list">
                    @foreach ($list as $row)
                        <li class="prod_item">
                            <div class="img_box">
                                <a href="/product/detail/{{ $row -> idx }}"><img src="{{ $row -> product_image }}" alt=""></a>
                                <button class="zzim_btn {{ $row -> isInterest > 0 ? 'active' : '' }}" pidx="{{ $row->idx }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="/product/detail/{{ $row -> idx }}">
                                    <span>{{ $row -> company_name }}</span>
                                    <p>{{ $row -> name }}</p>
                                    <b>{{$row->is_price_open ? number_format($row->price, 0).'원': $row->price_text}}</b>
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="pagenation flex items-center justify-center py-12">
                @if($pagination['prev'] > 0)
                    <a href="javascript:;" onclick="moveToList({{$pagination['prev']}})"><</a>
                @endif
                @foreach($pagination['pages'] as $paginate)
                    <a href="javascript:;" class="{{$paginate == $offset ? 'active' : ''}}" onclick="moveToList({{$paginate}})">{{$paginate}}</a>
                @endforeach
                @if($pagination['next'] > 0)
                    <a href="javascript:;" onclick="moveToList({{$pagination['next']}})">></a>
                @endif
            </div>
        @endif
    </div>
</div>
<script>
    @if(request()->input('categories') != null)
        $(document).ready(function() {
            //카테고리 선택시
            let selectedCategories = [{{ request()->input('categories') }}];
            
            $("#filter_category-modal .check-form").each(function() {
                if(selectedCategories.indexOf(parseInt($(this).attr("id"))) != -1) {
                    $(this).prop('checked', true);
                }
            });
        });
    @endif

    $(document).on('click', '#filter_category-modal .btn-primary', function() {
        let cateArr = [];
        const checkedCategories = document.querySelectorAll('#filter_category-modal .check-form:checked');
        for(const category of checkedCategories) cateArr.push(category.id); 

        const params = getParams();
        delete params['categories'];
        if (cateArr) params['categories'] = cateArr;

        location.href = '/mypage/recent?' + new URLSearchParams(params);
    });

    const getList = paramsType => {
        let cateArr = [];
        const checkedCategories = document.querySelectorAll('[name*=category_check]:checked');
        for(const category of checkedCategories) cateArr.push(category.id);

        const params = getParams();
        delete params[paramsType];
        if (cateArr) params['categories'] = cateArr;

        location.href = '/mypage/recent?' + new URLSearchParams(params);
    }

    const moveToList = page => {
        const params = getParams();
        params['offset'] = page;

        location.href = '/mypage/recent?' + new URLSearchParams(params);
    }

    const getParams = () => {
        const params = {};

        const urlSearch = new URLSearchParams(location.search);
        urlSearch.get('categories') ? params.categories = urlSearch.get('categories') : '';

        return params;
    }
</script>
@endsection