@if(count($dealbrand) > 0)
    <div class="relative popular_prod type02">
        <div class="slide_box overflow-hidden">
            <div class="swiper-wrapper">
                @foreach($dealbrand as $deal)
                    <ul class="swiper-slide">
                        <li class="popular_banner">
                            <img src="{{ $mobile ? ($deal->appBigImgUrl ?: $deal->mainImgUrl) : $deal->mainImgUrl }}" @if(!$mobile) class="h-[716px]" @endif loading="lazy" decoding="async" fetchpriority="low" alt="{{ $deal->company_name }}">
                            <div class="txt_box">
                                <p><b>{{ $deal->subtext1 }}</b><br/>{{ $deal->subtext2 }}</p>
                                <a href="/wholesaler/detail/{{ $deal->company_idx }}"><b>{{ $deal->company_name }} </b> 홈페이지 가기</a>
                            </div>
                        </li>
                        @foreach($deal->product_info as $item)
                            <li class="prod_item">
                                <div class="img_box">
                                    <a href="/product/detail/{{ $item->mdp_gidx }}"><img src="{{ $item->mdp_gimg }}" loading="lazy" decoding="async" fetchpriority="low" alt="{{ $item->mdp_gname }}"></a>
                                    <button class="zzim_btn prd_{{ $item->mdp_gidx }} {{ ($deal->isInterest[$item->mdp_gidx] ?? 0) == 1 ? 'active' : '' }}" pidx="{{ $item->mdp_gidx }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </div>
        </div>
        @if(!$mobile)
            <button class="slide_arrow prev"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
            <button class="slide_arrow next"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
        @endif
    </div>
    <div class="bottom_box">
        <div class="bot_slide">
            <button class="arrow prev"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
            <div class="pager_box overflow-hidden">
                <ul class="swiper-wrapper">
                    @foreach($dealbrand as $deal)
                        <li class="swiper-slide"><button>{{ $deal->company_name }}</button></li>
                    @endforeach
                </ul>
            </div>
            <button class="arrow next"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
        </div>
        <div class="right_box">
            <div class="count_pager"><b>1</b> / {{ count($dealbrand) }}</div>
            <a href="/product/thisMonthDetail">모아보기</a>
        </div>
    </div>
@endif
