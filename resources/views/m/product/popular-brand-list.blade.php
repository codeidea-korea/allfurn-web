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
    <section class="sub">
        <div class="inner">
            <div class="main_tit mb-5 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>인기 브랜드</h3>
                </div>
            </div>
        </div>
        @if( count( $lists ) > 0 )
        <div class="popular_prod popular_con01 type03">
            <div class="slide_box">
                @foreach( $lists AS $l => $brand )
                <ul>
                    <li class="popular_banner">
                    </li>
                    @if( !empty( $brand->product_info ) )
                    @foreach( $brand->product_info AS $item )
                    <li class="prod_item">
                        <div class="img_box">
                            <a href="/product/detail/{{$item['mdp_gidx']}}"><img src="{{$item['mdp_gimg']}}" alt="{{$item['mdp_gname']}}"></a>
                            <button class="zzim_btn prd_{{$item['mdp_gidx']}} {{($brand->product_interest[$item['mdp_gidx']])?'active':''}}" pIdx="{{$item['mdp_gidx']}}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                        <div class="txt_box">
                            <a href="/product/detail/{{$item['mdp_gidx']}}">
                                <p>{{mb_strimwidth($item['mdp_gname'], 0, 32, '...','utf-8')}}</p>
                                <b>112,500원</b>
                            </a>
                        </div>
                    </li>
                  @endforeach
                  @endif
                </ul>
                @endforeach
            </div>
        </div>
        @endif
    </section>
</div>

<script type="text/javascript">
    let isLoading = false;
    let isLastPage = false;
    let currentPage = 1;

    function loadNewProductList() {
        if(isLoading) return;
        if(isLastPage) return;
        
        isLoading = true;

        var orderedElement = '';
        if( $('input[name="filter_cate_2"]').is(':checked') == true ) {
            orderedElement = $('input[name="filter_cate_2"]:checked').attr('id')
        }

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/product/jsonPopularBrand',
            method: 'GET',
            async: false,
            data: {
                'page': ++currentPage
            },
            success: function(result) {
                console.log( result );
                displayNewWholesaler(result.query, $(".popular_prod .slide_box"), false);

                isLastPage = currentPage === result.last_page;
            },
            complete : function () {
                isLoading = false;
            }
        })
    }

    function displayNewWholesaler(productArr, target, needsEmptying) {
        if(needsEmptying) {
            target.empty();
        }

        let html = "";
        productArr.data.forEach(function(product, index) {
            console.log(product);
            html += '' +
                '<ul>' +
                '   <li class="popular_banner">' +
                '   </li>';
            var ff = $.extend(true, [], product.product_interest );
            product.product_info.forEach(function(item, index) {
                var _active = '';
                if( ff[item.mdp_gidx] == 1 ) {
                    _active = 'active';
                } else {
                    _active = '';
                }
                html += '' +
                    '   <li class="prod_item">' +
                    '       <div class="img_box">' +
                    '           <a href="/product/detail/' + item.mdp_gidx + '"><img src="' + item.mdp_gimg + '" alt="' + item.mdp_gname + '"></a>' +
                    '           <button class="zzim_btn prd_' + item.mdp_gidx + ' ' + _active + '"  pidx="' + item.mdp_gidx + '"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>' +
                    '       </div>' +
                    '       <div class="txt_box">' +
                    '           <a href="/product/detail/' + item.mdp_gidx + '">' +
                    '               <p>' + item.mdp_gname + '</p>' +
                    '           </a>' +
                    '       </div>' +
                    '   </li>';

            });

            html += '' +
                '</ul>';
        });

        target.append(html);
    }

    $(window).scroll(function() {
        if( isLoading == false ) {
            if ($(window).scrollTop() + $(window).height() + 20 >= $(document).height() && !isLoading && !isLastPage) {
                loadNewProductList();
            }
        }
    });
</script>

@endsection