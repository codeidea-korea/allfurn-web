<div class="relative popular_prod">
    <div class="slide_box overflow-hidden">
        <div class="swiper-wrapper">
            @foreach($data['popularbrand_ad'] as $key => $brand)
                <ul class="swiper-slide">
                    <li class="popular_banner">
                        <div class="txt_box">
                            <p>
                                <b>{{ $brand->subtext1 }}</b><br/>{{ $brand->subtext2 }}</b>
                            </p>
                            <a href="/wholesaler/detail/{{ $brand->company_idx }}"><b>{{ $brand->companyName }} </b> 홈페이지 가기</a>
                        </div>
                    </li>
                    @foreach($brand->product_info as $key => $info)
                    <li class="prod_item">
                        <div class="img_box">
                            <a href="/product/detail/{{ $info['mdp_gidx'] }}"><img src="{{ $info['mdp_gimg'] }}" alt=""></a>
                            <button class="zzim_btn prd_{{ $info['mdp_gidx'] }} {{ ($brand->product_interest[$info['mdp_gidx']] == 1) ? 'active' : '' }}" pidx="{{ $info['mdp_gidx'] }}"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                    </li>
                    @endforeach
                </ul>
            @endforeach
        </div>
    </div>
    <button class="slide_arrow prev"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
    <button class="slide_arrow next"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
</div>
@if( count( $data['popularbrand_ad'] ) > 0 )
<div class="bottom_box">
    <div class="bot_slide ">
        <button class="arrow prev"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
        <div class="pager_box overflow-hidden">
            <ul class="swiper-wrapper">
                @foreach( $data['popularbrand_ad'] AS $brand )
                    <li class="swiper-slide"><button>{{$brand->companyName}}</button></li>
                @endforeach
            </ul>
        </div>
        <button class="arrow next"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
    </div>
    <div class="right_box">
        <div class="count_pager"><b>1</b> / 12</div>
        <a href="./">모아보기</a>
    </div>
</div>
@endif