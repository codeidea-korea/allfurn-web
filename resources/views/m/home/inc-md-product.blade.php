<section class="main_section theme_prod overflow-hidden">
    <div class="inner">
        <div class="main_tit mb-5 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <h3>MD가 추천하는 테마별 상품</h3>
            </div>
        </div>
        <div class="tab_layout">
            <ul class="swiper-wrapper">
                @foreach($data['md_product_ad_theme_list'] as $key => $theme)
                    <li class="swiper-slide @if ($key == 0) active @endif"><a href="javascript:;">{{ $theme }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="inner overflow-hidden">
        <div class="tab_content">
            @foreach ($data['md_product_info'] as $key => $theme)
                <div class="tab_0{{ $key+1 }} relative @if ($key == 0) active @endif">
                    <div class="title">
                        <div class="bg" style="background-color:#D6B498; "></div>
                        <h4>{{ $theme['th_top_title'] }}</h4>
                        <p>{{ $theme['th_name'] }}</p>
                    </div>
                    <div class="slide_box">
                        <ul class="swiper-wrapper">
                            @foreach ($theme['groups'] as $key => $goods) 
                                <li class="swiper-slide prod_item">
                                    <div class="img_box">
                                        <a href="/product/detail/{{ $goods['mdp_gidx'] }}"><img src="{{ $goods['mdp_gimg'] }}" alt=""></a>
                                        <button class="zzim_btn prd_{{ $goods['mdp_gidx'] }} {{ ($data['md_product_interest'][$goods['mdp_gidx']] == 1) ? 'active' : '' }}" pidx="{{ $goods['mdp_gidx'] }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                    </div>
                                    <div class="txt_box">
                                        <a href="/product/detail/{{ $goods['mdp_gidx'] }}">
                                            <span>{{ $goods['mdp_gcompany'] }}</span>
                                            <p>{{ $goods['mdp_gname'] }}</p>
                                            <b>{{ $goods['mdp_gprice'] }}</b>
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach 
        </div>
    </div>
</section>