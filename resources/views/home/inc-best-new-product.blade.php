<section class="main_section best_prod">
    <div class="inner">
        <div class="main_tit mb-8 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <h3 class="text-primary">HOT 신상품</h3>
                <button class="zoom_btn flex items-center gap-1" onclick="modalOpen('#zoom_view-modal')"><svg><use xlink:href="/img/icon-defs.svg#zoom"></use></svg>확대보기</button>
            </div>
            <div class="flex items-center gap-7">
                <div class="count_pager"><b>1</b> / 12</div>
                <a class="more_btn flex items-center" href="/product/best-new">더보기<svg><use xlink:href="/img/icon-defs.svg#more_icon"></use></svg></a>
            </div>
        </div>
        <div class="relative">
            <div class="slide_box ">
                <ul class="slick_ul">
                    @foreach ($data['productAd'] as $item)
                        @if($loop->index >= 120)
                        @else
                        <li class="prod_item">
                            <div class="img_box">
                                <a href="/product/detail/{{ $item->idx }}"><img src="{{ $item->imgUrl }}" alt="" width="285" style="width:285px;" loading="lazy"></a>
                                <button class="zzim_btn prd_{{ $item->idx }} {{ ($item->isInterest == 1) ? 'active' : '' }}" pidx="{{ $item->idx }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
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
                </ul>
            </div>
            <button class="slide_arrow prev"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
            <button class="slide_arrow next"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
        </div>
    </div>
</section>

<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>
    $('.best_prod .slide_box ul').slick({
        dots: true,
        slidesToShow: 4,
        rows: 2,
        infinite: false,
        slidesToScroll: 4,
        //   speed: 500,
        //   fade: true,
        //   cssEase: 'linear'
    });

    $('.best_prod .slide_arrow.prev').on('click',function(){
        $('.best_prod .slick_ul .slick-prev').click();
    })
    $('.best_prod .slide_arrow.next').on('click',function(){
        $('.best_prod .slick_ul .slick-next').click();
    })
    $('.best_prod .slide_box ul').on('afterChange',function(event,slick,direction){
        pager()
    })
    $(document).on('ready',function(){
        pager()
    })
    function pager(){
        let size = $('.best_prod .slick-dots li').length;
        let active = $('.best_prod .slick-dots li.slick-active').index() + 1
        $('.best_prod .count_pager').html(`<b>${active}</b> / ${size}`)
    }
</script>

@include('product.best-new-product-ext')
