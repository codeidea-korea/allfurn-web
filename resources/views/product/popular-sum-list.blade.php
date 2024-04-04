@extends('layouts.app')

@section('content')
@include('layouts.header')
    <div id="content">
        @if( count( $lists['lists'] ) > 0 )
        <section class="sub_section">
            <div class="inner">
                <div class="main_tit mb-8 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <h3>인기 상품 모아보기</h3>
                    </div>
                </div>
                <div class="relative best_prod">
                    <div class="slide_box prod_slide-2">
                        <ul class="swiper-wrapper">
                            @foreach( $lists['lists'] AS $l => $list )
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="/product/detail/{{$list->idx}}"><img src="{{$list->imgUrl}}" alt=""></a>
                                    <button class="zzim_btn prd_{{$list->idx}} {{ ($list->isInterest == 1) ? 'active' : '' }}" pidx="{{$list->idx}}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="./prod_detail.php">
                                        <span>{{$list->company_name}}</span>
                                        <p>{{$list->name}}</p>
                                        <b>
                                            @if( $list->is_price_open == 1 )
                                                {{number_format( $list->price )}}원
                                            @else
                                                {{$list->price_text}}
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

        <section class="sub_section">
            <div class="inner">
                <div class="tab_layout">
                    <ul>
                        @php $tmp=0; @endphp
                        @foreach( $lists['category'] AS $c => $list )
                        <li class="{{($tmp==0)?'active':''}}"><a href="javascript:;">침대 프레임</a></li>
                        @php $tmp++; @endphp
                        @endforeach
                    </ul>
                </div>
                <div class="relative">
                    <div class="tab_content">
                        @php $tmp = 1; @endphp
                        @foreach( $lists['category'] AS $c => $list )
                        <div class="tab_0{{$tmp}} relative active">
                            <div class="flex justify-between items-center my-5">
                                <p class="txt-gray">전체 {{count( $list )}}</p>
                                <p class="txt-gray fs14">{{date('Y년 m월 d일')}} 기준</p>
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
            slidesPerView: 4,
            spaceBetween: 20,
            slidesPerGroup: 4,
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
    </script>
@endsection