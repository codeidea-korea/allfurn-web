<div class="w-full">
    <div class="flex justify-between">
        <h3 class="text-xl font-bold">최근 본 상품</h3>
    </div>

    <div class="mt-4">
        <div class="sub_filter">
            <div class="filter_box">
                <button class="{{ request()->input('categories') != null ? 'on' : '' }}" onclick="modalOpen('#filter_category-modal')">카테고리 <b class="txt-primary">{{ request()->query('categories') != null ? count(explode(',', request()->query('categories'))) : '' }}</b></button>
            </div>
        </div>
        <div class="sub_filter_result" hidden>
            <div class="filter_on_box">
                <div class="category"></div>
            </div>
            <button class="refresh_btn" onClick="location.href='/mypage/recent'">초기화<svg><use xlink:href="/img/icon-defs.svg#refresh"></use></svg></button>
        </div>
    </div>
    @if (count($list) < 1)
        <div class="pt-1">
            <div class="flex items-center pb-3 justify-between">
                <span>데이터가 존재하지 않습니다<div class=""></div></span>
            </div>
        </div>
    @else
    <div class="my_like_tab_section01 pt-5">
        <div class="flex items-center pb-3 justify-between">
            <span>전체 {{ $count }}개</span>
        </div>
        <ul class="prod_list">
            @foreach($list as $row)
                <li class="prod_item">
                    <div class="img_box">
                        <a href="/product/detail/{{ $row -> idx }}"><img src="{{ $row -> product_image }}" alt=""></a>
                        <button class="zzim_btn prd_{{ $row->idx }}" pidx="{{ $row->idx }}"><svg><use xlink:href="./img/icon-defs.svg#zzim"></use></svg></button>
                    </div>
                    <div class="txt_box">
                        <a href="/product/detail/{{ $row -> idx }}">
                            <span>{{ $row -> company_name }}</span>
                            <p>{{ $row -> name }}</p>
                            <b>{{$row->is_price_open ? number_format($row->price, 0).'원': $row->price_text}}</b>
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="pagenation flex items-center justify-center py-12">
            @if($pagination['prev'] > 0)
                <a href="javascript:;" onclick="moveToList({{$pagination['prev']}})"><</a>
            @endif
            @foreach($pagination['pages'] as $paginate)
                <a href="javascript:;" class="{{$paginate == $offset ? 'active' : ''}}" onclick="moveToList({{$paginate}})">{{$paginate}}</a>
            @endforeach
            @if($pagination['next'] > 0)
                <a href="javascript:;" onclick="moveToList({{$pagination['next']}})">></a>
            @endif
        </div>
    </div>
    @endif
</div>
<script>
    @if(request()->input('categories') != null)
        $(document).ready(function() {
            //카테고리 선택시
            let selectedCategories = [{{ request()->input('categories') }}];
            
            $("#filter_category-modal .check-form").each(function() {
                if(selectedCategories.indexOf(parseInt($(this).attr("id"))) != -1) {
                    $(this).prop('checked', true);
                    $(".category").append('<span>' + $(this).siblings('label').text() +'<button data-id = "'+ $(this).attr('id') +'" onclick="filterRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button></span>')
                    $(".sub_filter_result").css('display', 'flex');
                }
            });
        });
    @endif

    $(document).on('click', '#filter_category-modal .btn-primary', function() {
        reloadWithFilter();
    })

    // 카테고리 - 삭제
    function filterRemove(item) {
        $("#" + $(item).data('id')).prop('checked', false);
        reloadWithFilter();
    }

    function reloadWithFilter() {
        let categories = [];
        $("#filter_category-modal .check-form:checked").each(function(){
            categories.push($(this).attr('id'));
        });

        if (categories) {
            let bodies = {categories:categories};
            const urlSearch = new URLSearchParams(location.search);
            location.href='/mypage/recent?' + new URLSearchParams(bodies);
        }
    }

    const moveToList = page => {
        let bodies = {offset:page};
        const urlSearch = new URLSearchParams(location.search);
        if (urlSearch.get('categories')) bodies.categories = urlSearch.get('categories');
        location.replace("/mypage/recent?" + new URLSearchParams(bodies));
    }
</script>