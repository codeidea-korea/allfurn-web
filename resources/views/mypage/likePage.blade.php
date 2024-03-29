@extends('layouts.app')

@section('content')
@include('layouts.header')

<div id="content">
    <section class="sub_section nopadding community_tab mb-10">
        <div class="inner">
            <ul>
                <li class="{{ $pageType === 'product' ? 'active' : '' }}"><a href="/like/product">좋아요 상품</a></li>
                <li class="{{ $pageType === 'company' ? 'active' : '' }}"><a href="/like/company">좋아요 업체</a></li>
            </ul>
        </div>
    </section>
    
    @include('mypage.inc-like-' .$pageType)

</div>

@endsection