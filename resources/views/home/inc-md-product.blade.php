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
                                <li class="swiper-slide prod_item">
                                    <div class="img_box">
                                        <a href="/product/detail/{{ $goods['mdp_gidx'] }}"><img src="{{ $goods['mdp_gimg'] }}" alt=""></a>
                                        <button class="zzim_btn prd_{{ $goods['mdp_gidx'] }} {{ ($data['md_product_interest'][$goods['mdp_gidx']] == 1) ? 'active' : '' }}" pidx="{{ $goods['mdp_gidx'] }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                    </div>
                                    <div class="txt_box">
                                        <a href="/product/detail/{{ $goods['mdp_gidx'] }}">
                                            <span>{{ $goods['mdp_gcompany'] }}</span>
                                            <p>{{ $goods['mdp_gname'] }}</p>
                                            <b>{{ number_format($goods['mdp_gprice'],0) }}원</b>
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach 

            <!-- 호텔형 침대 모음 -->
            {{-- <div class="tab_02 relative">
                <div class="title">
                    <div class="bg" style="background-color:#D6B498; "></div>
                    <h4>내 침실을 휴향지 호텔 처럼!</h4>
                    <p>호텔형 침대 모음</p>
                </div>
                <button class="slide_arrow prev"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
                <button class="slide_arrow next"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
                <div class="slide_box overflow-hidden">
                    <ul class="swiper-wrapper">
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div> --}}
            <!-- 펫 하우스 -->
            {{-- <div class="tab_03 relative">
                <div class="title">
                    <div class="bg" style="background-color:#D6B498; "></div>
                    <h4>내 침실을 휴향지 호텔 처럼!</h4>
                    <p>펫 하우스</p>
                </div>
                <button class="slide_arrow prev"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
                <button class="slide_arrow next"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
                <div class="slide_box overflow-hidden">
                    <ul class="swiper-wrapper">
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div> --}}
            <!-- 옷장/수납장 -->
            {{-- <div class="tab_04 relative">
                <div class="title">
                    <div class="bg" style="background-color:#D6B498; "></div>
                    <h4>내 침실을 휴향지 호텔 처럼!</h4>
                    <p>옷장/수납장</p>
                </div>
                <button class="slide_arrow prev"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
                <button class="slide_arrow next"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow"></use></svg></button>
                <div class="slide_box overflow-hidden">
                    <ul class="swiper-wrapper">
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>

                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                        <li class="swiper-slide prod_item">
                            <div class="img_box">
                                <a href="./prod_detail.php"><img src="./img/prod_thumb3.png" alt=""></a>
                                <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>올펀가구</span>
                                    <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                    <b>112,500원</b>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div> --}}
        </div>

    </div>
</section>