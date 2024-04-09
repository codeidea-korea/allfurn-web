<section class="main_section popular_prod">
    <div class="inner">
        <div class="main_tit mb-5 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <h3>인기 브랜드</h3>
            </div>
        </div>
    </div>
    <div class="relative">
        <div class="slide_box overflow-hidden">
            <div class="swiper-wrapper">
                @foreach($data['popularbrand_ad'] as $key => $brand)
                    <ul class="swiper-slide">
                        <li class="popular_banner">
                            <div class="txt_box">
                                <p><b>{{ $brand->subtext1 }}</b><br/>{{ $brand->subtext2 }}</p>
                                <a href="/wholesaler/detail/{{ $brand->company_idx }}"><b>{{ $brand->companyName }} </b> 홈페이지 가기</a>
                            </div>
                        </li>
                        @foreach($brand->product_info as $key => $info)
                            <li class="prod_item">
                                <div class="img_box">
                                    <a href="/product/detail/{{ $info['mdp_gidx'] }}"><img src="{{ $info['mdp_gimg'] }}" alt=""></a>
                                    <button class="zzim_btn prd_{{ $info['mdp_gidx'] }} {{ ($brand->product_interest[$info['mdp_gidx']] == 1) ? 'active' : '' }}" pidx="{{ $info['mdp_gidx'] }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </div>
        </div>
    </div>
    <div class="inner">
        <div class="flex items-center justify-center mt-4">
            <div class="count_pager"><b>1</b> / 12</div>
        </div>
        <a href="/product/popularList" class="btn btn-line4 mt-4">더보기</a>
    </div>
</section>