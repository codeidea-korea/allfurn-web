<section class="sub_section sub_section_bot">
    <div class="inner">
        <div class="main_tit mb-5 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <h3>신규 등록 상품</h3>
            </div>
            <div class="flex">
                <button class="zoom_btn flex items-center gap-1" onclick="modalOpen('#zoom_view-modal-new')"><svg><use xlink:href="/img/icon-defs.svg#zoom"></use></svg>확대보기</button>
            </div>
        </div>
        <div class="sub_filter">
            <div class="filter_box">
                <button onclick="modalOpen('#filter_category-modal')">카테고리</button>
                <button onclick="modalOpen('#filter_location-modal')">소재지</button>
                <button onclick="modalOpen('#filter_align-modal03')">최신순</button>
                <button class="refresh_btn">초기화 <svg><use xlink:href="/img/icon-defs.svg#refresh"></use></svg></button>
            </div>
            <div class="total">전체 0개</div>
        </div>
        <div class="relative">
            <ul class="prod_list"></ul>
        </div>
    </div>
</section>