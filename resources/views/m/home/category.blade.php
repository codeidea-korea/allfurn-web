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
                                <li><a href="/family/{{$family->idx}}">{{ $family->family_name }}<i><svg width="38" height="37" viewBox="0 0 38 37" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.6669 2.02355C17.2492 -0.361158 20.7508 -0.36116 22.3331 2.02355L26.1522 7.77969C26.6837 8.58075 27.4859 9.1636 28.412 9.42155L35.0666 11.275C37.8236 12.0429 38.9057 15.3732 37.1266 17.6149L32.8324 23.0259C32.2347 23.7789 31.9283 24.722 31.9692 25.6825L32.2628 32.5841C32.3845 35.4434 29.5515 37.5016 26.8698 36.5024L20.3967 34.0904C19.4958 33.7547 18.5042 33.7547 17.6033 34.0904L11.1302 36.5024C8.44848 37.5016 5.61555 35.4434 5.73719 32.5841L6.03081 25.6825C6.07167 24.722 5.76525 23.7789 5.16763 23.0259L0.873404 17.6149C-0.905654 15.3732 0.176428 12.0429 2.93336 11.275L9.58795 9.42155C10.5141 9.1636 11.3163 8.58075 11.8478 7.77969L15.6669 2.02355Z" fill="#F4465E"/></svg></i></a></li>
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