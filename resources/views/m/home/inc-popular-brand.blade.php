<section class="main_section popular_prod main_popular">
    <div class="inner">
        <div class="main_tit mb-5 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <h3>인기 브랜드</h3>
            </div>
        </div>
    </div>
    <div class="relative">
        <div class="slide_box overflow-hidden">
            {{-- <div class="swiper-wrapper">
                @foreach($data['popularbrand_ad'] as $key => $brand)
                        @if($loop->index >= 5)
                        @else
                    <ul class="swiper-slide">
                        <li class="popular_banner">
                            <div class="txt_box">
                                    <p>
                                        <b>{{$brand->subtext1 == '' ? ' ' : $brand->subtext1}}</b><br/>{{$brand->subtext2 == '' ? ' ' : $brand->subtext2}}
                                    </p>
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
                    @endif
                @endforeach
            </div> --}}
            <div class="swiper-wrapper">
                @foreach( $data['popularbrand_ad'] AS $brand )
                    <ul class="swiper-slide">
                        <li class="popular_banner">
                            <img src="{{$brand->appBigImgUrl}}" class="h-[320px]" alt="{{ $brand->companyName }}">
                            <div class="txt_box">
                                    <p>
                                        <b>{{$brand->subtext1 == '' ? ' ' : $brand->subtext1}}</b><br/>{{$brand->subtext2 == '' ? ' ' : $brand->subtext2}}
                                    </p>
                                <a href="/wholesaler/detail/{{$brand->company_idx}}"><b>{{$brand->companyName}} </b> 홈페이지 가기</a>
                            </div>
                        </li>
                        @foreach ( $brand->product_info AS $item )
                            <li class="prod_item">
                                <div class="img_box">
                                    <a href="/product/detail/{{$item['mdp_gidx']}}"><img src="{{$item['mdp_gimg']}}" alt="{{$item['mdp_gname']}}" alt=""></a>
                                    <button class="zzim_btn prd_{{$item['mdp_gidx']}} {{($brand->product_interest[$item['mdp_gidx']])?'active':''}}" pIdx="{{$item['mdp_gidx']}}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <!-- 고객사 요청으로 삭제 -->
                                <!-- <div class="txt_box">
                                    <a href="/product/detail/{{$item['mdp_gidx']}}">
                                        <p>{{mb_strimwidth($item['mdp_gname'], 0, 40, '...','utf-8')}}</p>
                                        {{-- <b>112,500원</b> --}}
                                    </a>
                                </div> -->
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </div>
        </div>
    </div>
    <div class="bottom_box">
        <div class="bot_slide ">
            <button class="arrow prev"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
            <div class="pager_box overflow-hidden">
                <ul class="swiper-wrapper">
                    @foreach( $data['popularbrand_ad'] AS $brand )
                        <li class="swiper-slide"><button>{{$brand->companyName}}</button></li>
                    @endforeach
                </ul>
            </div>
            <button class="arrow next"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow"></use></svg></button>
        </div>
        <div class="right_box">
            <div class="count_pager"><b>1</b> / 12</div>
            <!-- <a href="javascript:;">모아보기</a> -->
        </div>
    </div>
    <div class="inner">
        {{-- <div class="flex items-center justify-center mt-4">
            <div class="count_pager"><b>1</b> / 12</div>
        </div> --}}
        <a href="/product/popularBrand" class="btn btn-line4 mt-4">더보기</a>
    </div>
</section>
