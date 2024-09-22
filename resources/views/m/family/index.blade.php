@extends('layouts.app_m')
@php
    $only_quick = '';
    $header_depth = '';
    $top_title = '';
    $header_banner = '';
@endphp
@section('content')
@include('layouts.header_m')

<div id="content">
    <div class="pt-3 type02">
        <div class="type02 flex flex-col gap-2 items-center">
            <img src="{{$family[0]->imgUrl}}" class="w-[260px] object-cover" alt="">
            <a href="javascript:;">
                <div class="flex items-center">
                    <p class="profile_id">{{ $family[0]->family_name }}</p>
                </div>
            </a>
        </div>
    </div>
    <section class="sub_section">
        <div class="inner">
            <ul class="obtain_list type02">
                @foreach ( $family as $member )
                    <li>
                        <div class="txt_box">
                            <div class="flex items-center justify-between">
                                <a href="{{ $member->companyType === 'W' ? '/wholesaler/detail/' . $member->company_idx : 'javascript:void(0)' }}">
                                    <img src="/img/icon/crown.png" alt="">
                                    @if ($member->companyType === 'W')
                                    {{ $member->company_name }}
                                        <svg><use xlink:href="/img/icon-defs.svg#more_icon"></use></svg>
                                    @else
                                    {{ $member->family_name }}
                                    @endif
                                </a>
                                <button class="zzim_btn {{ $member->isCompanyInterest == 1 ? 'active' : '' }}" data-company-idx='{{$member->company_idx}}' onclick="toggleCompanyLike('{{$member->companyType}}', {{$member->company_idx}})"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="tag">
                                    @php
                                        $companyCategoryList = explode(',', $member->categoryList);
                                    @endphp
                                    @foreach ( $companyCategoryList as $category )
                                        <span>{{ $category }}</span>
                                    @endforeach
                                </div>
                                <i class="shrink-0">{{ $member->location }}</i>
                            </div>
                        </div>
                        <div class="prod_box">
                            @foreach ($member->productList as $product)
                                <div class="img_box">
                                    <a href="/product/detail/{{ $product->productIdx }}"><img src="{{ $product->imgUrl }}" alt=""></a>
                                    <button class="zzim_btn prd_{{ $product->productIdx }} {{ $product->isInterest == 1 ? 'active' : '' }}" pidx="{{ $product->productIdx }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                            @endforeach
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
</div>
<script>
    function toggleCompanyLike(type, idx) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : '/family/like',
            method: 'POST',
            data : {
                'type' : type,
                'idx' : idx,
            },
            success : function(result) {
                if (result.success) {
                    if (result.like === 0) {
                        $('.zzim_btn[data-company-idx='+idx+']').removeClass('active');
                    } else {
                        $('.zzim_btn[data-company-idx='+idx+']').addClass('active');
                    }
                }
            }
        })
    }
</script>
@endsection
