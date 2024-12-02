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
                <li class="coop">
                    <a>
                        <i><img src="https://allfurn-prod-s3-bucket.sgp1.vultrobjects.com/category/acf77c0381a0cfcfd3e0a11207b2d7130484704a6fe33df4e87bbb6604ecf04a.png"></i>
                        <span onclick="javascript:(0);">가구연관협력업체</span>
                    </a>
                    <div class="depth2">
                        <ul>
                            @foreach($family_ad as $key => $family)
                                <li>
                                    <a href='/family/{{$family->idx}}'>
                                        <div class="img_box {{ $family->family_info != '[]' ? '' : 'inactive' }}">
                                            <p style="display: inline-flex;flex-direction: row-reverse;flex-wrap: nowrap;justify-content: space-around;align-items: center;">
                                                <span style="width:95px; padding: 10px; padding-right:0; text-align:left; word-break:keep-all;">{{ $family->family_name }}</span>
                                                <img style="width:131px" src="{{ $family->imgUrl }}" alt="">
                                            </p>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                @foreach ( $categoryList as $category )
                    <li>
                        <a>
                            <i><img src="{{ $category->imgUrl }}"></i>
                            <span onclick="javascript:(0);">{{ $category->name }}</span>
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

<script>
    $(document).on('click', '.depth2 li a', function() {
        $(this).addClass('active');
    })
</script>
@endsection