<section class="main_section new_prod">
    <div class="inner">
        <div class="main_tit mb-8 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <h3>신규 등록 상품</h3>
                <button class="zoom_btn flex items-center gap-1" onclick="modalOpen('#zoom_view-modal-new')"><svg><use xlink:href="./img/icon-defs.svg#zoom"></use></svg>확대보기</button>
            </div>
            <div class="flex items-center gap-7">
                <div class="count_pager"><b>1</b> / 12</div>
                <a class="more_btn flex items-center" href="/product/new?scroll=true">더보기<svg><use xlink:href="./img/icon-defs.svg#more_icon"></use></svg></a>
            </div>
        </div>
        <div class="relative">
            <div class="slide_box ">
                <ul class="slick_ul">
                    @foreach($data['new_product'] as $item)
                        @if($loop->index >= 40)
                        @else
                        <li class=" prod_item">
                            <div class="img_box">
                                <a href="/product/detail/{{ $item->idx }}"><img loading="lazy" decoding="async" src="{{ $item->imgUrl }}" width="285" alt="" loading="lazy"></a>
                                <button class="zzim_btn prd_{{ $item->idx }} {{ ($item->isInterest == 1) ? 'active' : '' }}" pidx="{{ $item->idx }}"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="/product/detail/{{ $item->idx }}">
                                    <span>{{ $item->companyName }}</span>
                                    <p>{{ $item->name }}</p>
                                    <b>{{ $item->is_price_open ? number_format($item->price, 0).'원': $item->price_text }}</b>
                                </a>
                            </div>
                        </li>
                        @endif
                    @endforeach
                    <!--
                    <li class="swiper-slide more_btn">
                        <button onclick="location.href='/product/new?scroll=true'">더보기</button>
                    </li>
-->
                </ul>
            </div>
            <button class="slide_arrow prev"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
            <button class="slide_arrow next"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
        </div>
    </div>
</section>
<script>
    $('.new_prod .slide_box ul').slick({
        dots: true,
        slidesToShow: 4,
        rows: 2,
        infinite: false,
        slidesToScroll: 4,
        //   speed: 500,
        //   fade: true,
        //   cssEase: 'linear'
    });

    $('.new_prod .slide_arrow.prev').on('click',function(){
        $('.new_prod .slick_ul .slick-prev').click();
    })
    $('.new_prod .slide_arrow.next').on('click',function(){
        $('.new_prod .slick_ul .slick-next').click();
    })
    $('.new_prod .slide_box ul').on('afterChange',function(event,slick,direction){
        npager()
    })
    $(document).on('ready',function(){
        npager()
    })
    function npager(){
        let size = $('.new_prod .slick-dots li').length;
        let active = $('.new_prod .slick-dots li.slick-active').index() + 1
        $('.new_prod .count_pager').html(`<b>${active}</b> / ${size}`)
    }
</script>

@php $product = $data['new_product'] @endphp
@include('product.new-product-ext')
