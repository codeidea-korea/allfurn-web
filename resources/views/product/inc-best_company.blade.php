@if( count( $companyProduct ) > 0 )
    <section class="sub_section sub_section_bot">
        <div class="inner">
            <div class="main_tit mb-8 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>{{date('n')}}월 BEST 도매 업체</h3>
                </div>
            </div>
            <div class="sub_filter">
                <div class="filter_box">
                    <button onclick="modalOpen('#filter_category-modal')">카테고리</button>
                    <button onclick="modalOpen('#filter_location-modal')">소재지</button>
                    <button onclick="modalOpen('#filter_align-modal')">최신 상품 등록순</button>
                </div>
                <div class="total">전체 {{number_format( count( $companyProduct ) )}}개</div>
            </div>
            {{--
            <div class="sub_filter">
                <div class="filter_box">
                    <button class="on" onclick="modalOpen('#filter_category-modal')">카테고리 <b class="txt-primary">3</b></button>
                    <button class="on" onclick="modalOpen('#filter_location-modal')">소재지 <b class="txt-primary">2</b></button>
                    <button onclick="modalOpen('#filter_align-modal')">최신 상품 등록순</button>
                </div>
                <div class="total">전체 428개</div>
            </div>
            --}}
            <div class="sub_filter_result hidden">
                <div class="filter_on_box">
                    <div class="category">
                        <span>소파/거실 <button onclick="filterRemove(this)"><svg><use xlink:href="./img/icon-defs.svg#x"></use></svg></button></span>
                        <span>식탁/의자 <button onclick="filterRemove(this)"><svg><use xlink:href="./img/icon-defs.svg#x"></use></svg></button></span>
                        <span>수납/서랍장/옷장 <button onclick="filterRemove(this)"><svg><use xlink:href="./img/icon-defs.svg#x"></use></svg></button></span>
                    </div>
                    <div class="location">
                        <span>인천 <button onclick="filterRemove(this)"><svg><use xlink:href="./img/icon-defs.svg#x"></use></svg></button></span>
                        <span>광주 <button onclick="filterRemove(this)"><svg><use xlink:href="./img/icon-defs.svg#x"></use></svg></button></span>
                    </div>
                </div>
                <button class="refresh_btn">초기화 <svg><use xlink:href="./img/icon-defs.svg#refresh"></use></svg></button>
            </div>

            <ul class="obtain_list">
                @foreach( $companyProduct as $key => $product )
                        <?php if( $key > 2 ) continue; ?>
                    <li>
                        <div class="txt_box">
                            <div>
                                <a href="javascript:;">
                                    <img src="./img/icon/crown.png" alt="">
                                    {{$product->company_name}}
                                    <svg><use xlink:href="./img/icon-defs.svg#more_icon"></use></svg>
                                </a>
                                <i>서울</i>
                                <div class="tag">
                                    @foreach( explode( ',', $product->categoryList ) AS $cate )
                                        <span>{{$cate}}</span>
                                    @endforeach
                                    {{--
                                    <span>침대/매트리스</span>
                                    <span>식탁/의자</span>
                                    --}}
                                </div>
                            </div>
                            {{--
                            <button class="addLike {{ ($data['info']->isLike == 1) ? 'active' : '' }}" onClick="addLike({{$data['info']->idx}});""><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg> 좋아요</button //-->
                            --}}
                        </div>
                        @if( !empty( $product->productList ) )
                            <div class="prod_box">
                                @foreach( $product->productList AS $key => $url )
                                        <?php if( $key > 2 ) continue; ?>
                                    <div class="img_box">
                                        <a href="javascript:;"><img src="{{$url->imgUrl}}" alt=""></a>
                                        <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                    </div>
                                @endforeach
                                {{--
                                <div class="img_box">
                                    <a href="javascript:;"><img src="./img/prod_thumb4.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="img_box">
                                    <a href="javascript:;"><img src="./img/prod_thumb5.png" alt=""></a>
                                    <button class="zzim_btn"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                --}}
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
@endif