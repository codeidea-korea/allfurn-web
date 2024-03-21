<section class="sub_section sub_section_bot">
    <div class="inner">
        <div class="main_tit mb-8 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <h3>신규 등록 상품</h3>
                <button class="zoom_btn flex items-center gap-1" onclick="modalOpen('#zoom_view-modal-new')"><svg><use xlink:href="/img/icon-defs.svg#zoom"></use></svg>확대보기</button>
            </div>
        </div>
        <div class="sub_filter">
            <div class="filter_box">
                <button class="" onclick="modalOpen('#filter_category-modal')">카테고리</button>
                {{-- <button class="on" onclick="modalOpen('#filter_location-modal')">소재지 <b class="txt-primary">2</b></button> --}}
                <button class="" onclick="modalOpen('#filter_location-modal')">소재지</button>
                <button onclick="modalOpen('#filter_align-modal')">최신순</button>
            </div>
            <div class="total">전체 {{ number_format($total, 0) }}개</div>
        </div>
        <div class="sub_filter_result">
            <div class="filter_on_box">
                <div class="category"></div>
                <div class="location">
                    {{-- <span>인천 <button onclick="filterRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button></span>
                    <span>광주 <button onclick="filterRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button></span> --}}

                </div>
            </div>
            <button class="refresh_btn">초기화 <svg><use xlink:href="/img/icon-defs.svg#refresh"></use></svg></button>
        </div>

        <div class="relative">
            <ul class="prod_list">
                @foreach ($list as $item )
                    <li class="prod_item">
                        <div class="img_box">
                            <a href="/product/detail/{{ $item->idx }}"><img src="{{ $item->imgUrl }}" alt=""></a>
                            <button class="zzim_btn prd_{{ $item->idx }} {{ ($item->isInterest == 1) ? 'active' : '' }}" pidx="{{ $item->idx }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                        <div class="txt_box">
                            <a href="/product/detail/{{ $item->idx }}">
                                <span>{{$item->companyName}}</span>
                                <p>{{ $item->name }}</p>
                                <b>{{ number_format($item->price, 0) }}원</b>
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>