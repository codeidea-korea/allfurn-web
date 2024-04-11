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
    @if( count( $dealbrand ) > 0 )
    <section class="sub_section sub_section_top thismonth_detail">
        <div class="relative popular_prod type02">
            <div class="slide_box overflow-hidden">
                @foreach( $dealbrand AS $key => $brand )
                <div class="detail_box">
                    <ul class="">
                        <li class="popular_banner">
                        </li>
                        <?php $prd_info = json_decode($brand->product_info);?>
                        @foreach( $prd_info AS $i => $info )
                        <li class="prod_item">
                            <div class="img_box">
                                <a href="/product/detail/{{$info->mdp_gidx}}"><img src="{{$info->mdp_gimg}}" alt="{{$info->mdp_gname}}"></a>
                                <button class="zzim_btn prd_{{$info->mdp_gidx}} {{ ($brand->isInterest[$info->mdp_gidx] == 1) ? 'active' : '' }}" pIdx="{{$info->mdp_gidx}}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    <div class="bot_btn">
                        <button class="zoom_btn flex items-center gap-1" data-zoomkey="{{$key}}"><svg><use xlink:href="/img/icon-defs.svg#zoom"></use></svg>확대보기</button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div><!-- 확대보기 -->
<div class="modal" id="zoom_view-modal">
    <div class="modal_bg" onclick="modalClose('#zoom_view-modal')"></div>
    <div class="modal_inner x-full zoom_view_wrap">
        <button class="close_btn" onclick="modalClose('#zoom_view-modal')"><svg><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body">
            <div class="slide_box zoom_prod_list">
                <ul class="swiper-wrapper">

                </ul>
            </div>
            <div class="bottom_navi">
                <button class="arrow prev type03"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow_white"></use></svg></button>
                <div class="count_pager dark_type"><b>1</b> / 12</div>
                <button class="arrow next type03"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow_white"></use></svg></button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    // zoom_prod_list
    function start_slide() {
        var zoom_prod_list = new Swiper(".zoom_prod_list", {
            slidesPerView: 1,
            spaceBetween: 30,
            navigation: {
                nextEl: ".zoom_view_wrap .arrow.next",
                prevEl: ".zoom_view_wrap .arrow.prev",
            },
            pagination: {
                el: ".zoom_view_wrap .count_pager",
                type: "fraction",
            },
        });
    }

    $(document)
        .on('click', '.zoom_btn', function(e) {
            e.stopPropagation();

            var key = $(this).data('zoomkey');
            var prod = <?=json_encode( $dealbrand ); ?>;

            html = '';
            $.each( prod, function(index) {
                if( index == key) {
                    var item = JSON.parse( prod[index]['product_info'] );
                    $.each( item, function(idx) {
                        var _active = '';
                        if( prod[index]['isInterest'][item[idx]['mdp_gidx']] == 1 ) {
                            _active = 'active';
                        }
                    html += '' +
                        '<li class="swiper-slide">' +
                        '   <div class="img_box">' +
                        '       <a href="/product/detail/' + item[idx]['mdp_gidx'] + '">' +
                        '           <img src="' + item[idx]['mdp_gimg'] + '" alt="' + item[idx]['mdp_gidx'] + '">' +
                        '       </a>' +
                        '       <button class="zzim_btn prd_' + item[idx]['mdp_gidx'] + ' ' + _active + '" pidx="' + item[idx]['mdp_gidx'] + '"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>' +
                        '   </div>' +
                        '   <div class="txt_box">' +
                        '       <div>' +
                        '           <h5>' + prod[index]['company_name'] + '</h5>' +
                        '               <p>' + item[idx]['mdp_gname'] + '</p>' +
                        '           <b>' + item[idx]['mdp_gprice'] + '</b>' +
                        '       </div>' +
                        '   </div>' +
                        '</li>';
                    });

                    $('#zoom_view-modal .zoom_prod_list ul').empty().append(html);
                }
            });

            start_slide();
            modalOpen('#zoom_view-modal');
        })
    ;
</script>
@endsection