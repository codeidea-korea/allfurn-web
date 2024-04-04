<section class="sub_section sub_section_top thismonth_con01">
    <div class="inner">
        @if( count( $dealbrand ) > 0 )
            <div class="relative popular_prod type02">
                <div class="slide_box overflow-hidden">
                    <div class="swiper-wrapper">
                        @foreach( $dealbrand AS $key => $deal )
                            <ul class="swiper-slide">
                                <li class="popular_banner">
                                    <img src="{{$deal->imgUrl}}" class="h-[716px]" alt="{{$deal->company_name}}">
                                    <div class="txt_box">
                                        <p>
                                            <b>{{$deal->subtext1}}</b><br/>
                                            {{$deal->subtext2}}
                                        </p>
                                        <a href="/wholesaler/detail/{{$deal->company_idx}}"><b>{{$deal->company_name}} </b> 홈페이지 가기</a>
                                    </div>
                                </li>
                                    <?php $product = json_decode( $deal->product_info ); ?>
                                @foreach( $product AS $p => $item )
                                    <li class="prod_item">
                                        <div class="img_box">
                                            <a href="/product/detail/{{$item->mdp_gidx}}"><img src="{{$item->mdp_gimg}}" alt="{{$item->mdp_gname}}"></a>
                                            <button class="zzim_btn prd_{{$item->mdp_gidx}} {{ ($deal->isInterest[$item->mdp_gidx] == 1) ? 'active' : '' }}" pidx="{{$item->mdp_gidx}}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                </div>
                <button class="slide_arrow prev"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
                <button class="slide_arrow next"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
            </div>
            <div class="bottom_box">
                <div class="bot_slide ">
                    <button class="arrow prev"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
                    <div class="pager_box overflow-hidden">
                        <ul class="swiper-wrapper">
                            @foreach( $dealbrand AS $key => $deal )
                                <li class="swiper-slide"><button>{{$deal->company_name}}</button></li>
                            @endforeach
                        </ul>
                    </div>
                    <button class="arrow next"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
                </div>
                <div class="right_box">
                    <div class="count_pager"><b>1</b> / 12</div>
                    <a href="/product/thisMonthDetail">모아보기</a>
                </div>
            </div>
        @endif {{-- $dealbrand --}}
    </div>
</section>