@extends('layouts.app_m')
@php
    $only_quick = '';
    $header_depth = 'category';
    $top_title = '';
    $header_banner = 'no';
@endphp
@section('content')
@include('layouts.header_m')

<div id="content">
    <section class="category_con01">
        <div class="category_list">
            <ul>
                @foreach ( $categoryList as $category )
                    <li>
                        <a>
                            <i><img src="{{ $category->imgUrl }}"></i>
                            <span onclick="javascript:location.href='/product/category?pre={{ $category->idx }}'">{{ $category->name }}</span>
                        </a>
                        <ul class="depth2">
                            <li><a href="/product/category?pre={{ $category->idx }}">전체</a></li>
                            @foreach ( $category->depth2 as $item )
                                <li><a href="/product/category?ca={{$item->idx}}&pre={{$item->parent_idx }}">{{ $item->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
</div>

@endsection