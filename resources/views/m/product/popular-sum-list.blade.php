@extends('layouts.app_m')
@php
    $only_quick = '';
    $header_depth = 'product';
    $top_title = '';
    $header_banner = '';
@endphp
@section('content')
@include('layouts.header_m')

<div id="content">
    @if( count( $bestNewProducts ) > 0 )
        <section class="sub_section overflow-hidden">
            <div class="inner">
                <div class="search_title main_tit mb-8 flex justify-center items-center">
                    <div class="flex items-center justify-center gap-4">
                        <h3>{{date('n')}}월 BEST 신상품</h3>
                    </div>
                </div>
                <div class="relative best_prod">
                    <div class="slide_box prod_slide-2">
                        <ul class="swiper-wrapper">
                            @foreach( $bestNewProducts AS $product )
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="/product/detail/{{$product->idx}}"><img src="{{$product->imgUrl}}" alt=""></a>
                                    <button class="zzim_btn prd_{{$product->idx}} {{ ($product->isInterest == 1) ? 'active' : '' }}" pidx="{{$product->idx}}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>{{$product->company_name}}</span>
                                        <p>{{$product->name}}</p>
                                        <b>
                                            @if( $product->is_price_open == 1 )
                                                {{number_format( $product->price )}}원
                                            @else
                                                {{$product->price_text}}
                                            @endif
                                        </b>
                                    </a>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <button class="slide_arrow prev"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
                    <button class="slide_arrow next"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
                    <div class="count_pager w-20 mx-auto mt-5 text-center"><b>1</b> / 12</div>
                </div>
            </div>
        </section>
    @endif

    <section class="sub_section overflow-hidden">
        <div class="inner">
            <div class="tab_layout type04">
                <ul class="swiper-wrapper">
                    @php $tmp=0; @endphp
                        @foreach( $lists['category'] AS $c => $list )
                            <li class="swiper-slid {{($tmp==0)?'active':''}}"><a href="javascript:;">침대</a></li>
                        @php $tmp++; @endphp
                    @endforeach
                </ul>
            </div>
            <div class="relative">
                <div class="tab_content">
                    @php $tmp = 1; @endphp
                    @foreach( $lists['category'] AS $c => $list )
                        <div class="tab_0{{$tmp}} relative active">
                            <div class="flex justify-between items-center my-3">
                                <p class="txt-gray">전체 {{count( $list )}}</p>
                                <p class="txt-gray fs12">{{date('Y년 m월 d일')}} 기준</p>
                            </div>
                            @if( !empty( $list ) )
                                <ul class="prod_list">
                                    @foreach( $list AS $p => $item )
                                        <li class="prod_item">
                                            <div class="img_box">
                                                <a href="/product/detail/{{$item->idx}}"><img src="{{$item->imgUrl}}" alt="{{$item->name}}"></a>
                                                <button class="zzim_btn prd_{{$item->idx}} {{ ($item->isInterest == 1) ? 'active' : '' }}" pidx="{{$item->idx}}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                            </div>
                                            <div class="txt_box">
                                                <a href="/product/detail/{{$item->idx}}">
                                                    <span>{{$item->company_name}}</span>
                                                    <p>{{$item->name}}</p>
                                                    <b>
                                                        @if($item->is_price_open == 1)
                                                            {{number_format( $item->price )}}원
                                                        @else
                                                            {{$item->price_text}}
                                                        @endif
                                                    </b>
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        @php $tmp++; @endphp
                    @endforeach
                </div>

            </div>
        </div>
    </section>
</div>

<script>
    // 모아보기 
    const best_prod = new Swiper(".best_prod .slide_box", {
        slidesPerView: 'auto',
        spaceBetween: 8,
        grid: {
            rows: 2,
        },
        navigation: {
            nextEl: ".best_prod .slide_arrow.next",
            prevEl: ".best_prod .slide_arrow.prev",
        },
        pagination: {
            el: ".best_prod .count_pager",
            type: "fraction",
        },
    });

    // 탭
    $('.tab_layout li').on('click',function(){
        let liN = $(this).index();
        $(this).addClass('active').siblings().removeClass('active');
        $('.tab_content').each(function(){
            $(this).find('>div').eq(liN).addClass('active').siblings().removeClass('active');
        })
    })

    const tab = new Swiper(".tab_layout", {
        slidesPerView: 'auto',
        spaceBetween: 8,
       
    });
</script>

@endsection