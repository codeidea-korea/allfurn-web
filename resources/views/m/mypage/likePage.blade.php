@extends('layouts.app_m')
@php
$header_depth = 'like';
$top_title = '';
$only_quick = '';
$header_banner = '';
@endphp
@section('content')
@include('layouts.header_m')

<div id="content">
    <section class="sub_section nopadding community_tab">
        <ul>
            <li class="{{ $pageType === 'product' ? 'active' : '' }}"><a href="/like/product">좋아요 상품</a></li>
            <li class="{{ $pageType === 'company' ? 'active' : '' }}"><a href="/like/company">좋아요 업체</a></li>
        </ul>
    </section>

    @include('m.mypage.inc-like-' .$pageType)

</div>

@endsection