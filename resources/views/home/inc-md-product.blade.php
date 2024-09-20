<section class="main_section theme_prod">
    <div class="inner">
        <div class="main_tit mb-8 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <h3>MD가 추천하는 테마별 상품</h3>
            </div>
        </div>
        <div class="flex justify-between items-center">
            <div class="tab_layout">
                <ul>
                    @foreach($data['md_product_ad_theme_list'] as $key => $theme)
                        <li @if ($key == 0) class="active" @endif><a href="javascript:;">{{ $theme }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="tab_content">
                <div class="count_pager tab_01 active"><b>1</b> / 12</div>
                <div class="count_pager tab_02"><b>2</b> / 12</div>
                <div class="count_pager tab_03"><b>3</b> / 12</div>
                <div class="count_pager tab_04"><b>4</b> / 12</div>
            </div>
        </div>
        <div class="tab_content">
            {{-- @php $md_product_info = json_decode($data['md_product_ad']['md_product_info'], true); @endphp --}}
            @foreach ($data['md_product_info'] as $key => $theme)
                <div class="tab_0{{ $key+1 }} relative @if ($key == 0) active @endif">
                    <div class="title">
                        <div class="bg" style="background-color:#D6B498; "></div>
                        <h4>{{ $theme['th_top_title'] }}</h4>
                        <p>{{ $theme['th_name'] }}</p>
                    </div>
                    <button class="slide_arrow prev"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
                    <button class="slide_arrow next"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
                    <div class="slide_box overflow-hidden">
                        <ul class="swiper-wrapper">
                            @foreach ($theme['groups'] as $key => $goods) 
                                @if($loop->index >= 10)
                                @else
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
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
