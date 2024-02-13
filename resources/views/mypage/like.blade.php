<div class="my__section">
    <div class="content">
        <div class="section">
            <div class="section__head">
                <h3 class="section__title">좋아요</h3>
                <div class="category-type">
                    <div class="category-type__item">
                        <a href="#" class="category-type__item-1" onclick="openModal('.modal-category')">
                            카테고리
                            <span class="category__count"></span>
                            <i class="ico__arrow--down14"></i>
                        </a>
                        <a href="#" class="category-type__item-2 {{ $regions ? 'active' : '' }}"  onclick="openModal('.modal-category-2')">
                            소재지
                            <span class="category__count">{{ count($regions) > 0 ? count($regions) : '' }}</span>
                            <i class="ico__arrow--down14"></i>
                        </a>
                    </div>
                </div>
                <div class="category-data category-data--modify" style="{{ $regions ? 'border: 1px solid rgb(224, 224, 224); height: auto;' : '' }}">
                    <div class="category-data__wrap">
                        @foreach($regions as $region)
                        <button type="button"><span>{{ $region }}</span></button>
                        @endforeach
                    </div>
                    <a href="javascript:void(0)" onclick="refreshRegion()" class="category-filter__refresh {{ $regions ? 'active' : '' }}">
                        초기화
                        <i class="ico__refresh"></i>
                    </a>
                </div>
            </div>
            <div class="list" style="margin-bottom: -48px">
                <div class="list__meta-wrap">
                    <p class="list__total">총 {{ number_format($count) }}개</p>
                </div>
                @if($count < 1)
                    <div class="my-content my-content--nodata nodata--modify">
                        <span><i class="ico__exclamation"></i></span>
                        <p>좋아요한 업체가 없습니다.</p>
                    </div>
                @else
                    @foreach($list as $row)
                    <section class="list__item">
                        <div class="my__info" onclick="location.href='/wholesaler/detail/{{ $row->company_idx }}'">
                            <div class="my__desc">
                                <div class="my__img my__img--circle">
                                    <img src="{{ $row->profile_image ?:  '/images/sub/thumbnail@2x.png'}}" alt="썸네일">
                                </div>
                                <div class="my__text-wrap">
                                    <div class="my__name">
                                        <p class="name">{{ $row->company_name }}</p>
                                        @if($row->is_new === 'Y')<p class="badge">NEW</p>@endif
                                    </div>
                                    <p class="my__location">{{ $row->region }}</p>
                                    <ul>
                                        @foreach(explode(',', $row->category_names) as $cagegory_name)
                                        <li class="my__product">{{ $cagegory_name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="my__right-wrap">
                                <div class="my__like active" onclick="toggleLike({{ $row->idx }})">
                                    <i class="like"><span class="a11y">좋아요</span></i>
                                    <p>좋아요</p>
                                </div>
                            </div>
                        </div>
                        <div class="my__thumnail-container">
                            @if($row->products)
                                @if (substr($row->products, -1) === '}')
                                    @foreach(json_decode("[".$row->products."]", true) as $product)
                                    <div class="my__thumnail" style="background-image: url({{ $product['image'] }})"></div>
                                    @endforeach
                                @else
                                    @foreach(json_decode("[".$row->products."}]", true) as $product)
                                        <div class="my__thumnail" style="background-image: url({{ $product['image'] }})"></div>
                                    @endforeach
                                @endif
                            @endif
                        </div>
                    </section>
                    @endforeach
                    <div class="pagenation">
                        @if($pagination['prev'] > 0)
                            <button type="button" class="prev" id="prev-paginate" onclick="moveToList({{$pagination['prev']}})">
                                <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 1L1 6L6 11" stroke="#DBDBDB" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        @endif
                        <div class="numbering">
                            @foreach($pagination['pages'] as $paginate)
                                @if ($paginate == $offset)
                                    <a href="javascript:void(0)" onclick="moveToList({{$paginate}})" class="numbering--active">{{$paginate}}</a>
                                @else
                                    <a href="javascript:void(0)" onclick="moveToList({{$paginate}})">{{$paginate}}</a>
                                @endif
                            @endforeach
                        </div>
                        @if($pagination['next'] > 0)
                            <button type="button" class="next">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 12L10 7L5 2" stroke="#828282" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
{{-- 카테고리 리스트 모달 --}}
<div id="my-modal-category" class="modal modal-category modal-category--modify">
    <div class="modal__container" style="width: 480px !important;">
        <div class="modal__content">
            <div class="modal-box__container">
                <div class="modal-box__content">
                    <div class="header">
                        <p>카테고리 선택</p>
                    </div>
                    <div class="content">
                        @foreach($categories as $category)
                            <label for="category__check-{{ $category->idx }}" class="category__check">
                                <input type="checkbox" {{ in_array($category->name, $checked_categories) ? 'checked' : '' }} name="category_check[]" id="category__check-{{ $category->idx }}" value="{{ $category->name }}">
                                <span>{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="footer footer--modify">
                        <div class="footer__wrap">
                            <button type="button" class="buttons-refresh button button--left button--blank-gray">
                                <i class="ico__refresh"><span class="a11y">초기화</span></i>
                                <p>초기화</p>
                            </button>
                            <button type="button" onclick="getList()" class="buttons-search button button--right button--solid">상품 찾아보기</button>
                        </div>
                    </div>
                    <div class="modal-close">
                        <button type="button" class="modal__close-button" onclick="closeModal('#my-modal-category')"><span class="a11y">close</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- 소재지 리스트 모달 --}}
<div id="my-modal-category-2" class="modal modal-category-2 modal-category--modify">
    <div class="modal__container" style="width: 480px !important;">
        <div class="modal__content">
            <div class="modal-box__container">
                <div class="modal-box__content">
                    <div class="header">
                        <p>소재지 선택</p>
                    </div>
                    <div class="content" style="overflow: auto;">
                        @foreach(config('constants.REGIONS.KR') as $region)
                            <label for="category__check-2-{{ $loop->index+1 }}" class="category__check">
                                <input type="checkbox" {{ in_array($region, $regions) ? 'checked' : '' }} name="region_check[]" id="category__check-2-{{ $loop->index+1 }}" value="{{ $region }}">
                                <span>{{ $region }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="footer footer--modify">
                        <div class="footer__wrap">
                            <button type="button" class="buttons-refresh button button--left button--blank-gray">
                                <i class="ico__refresh"><span class="a11y">초기화</span></i>
                                <p>초기화</p>
                            </button>
                            <button type="button" onclick="getList()" class="buttons-search button button--right button--solid">업체 찾아보기</button>
                        </div>
                    </div>
                    <div class="modal-close">
                        <button type="button" class="modal__close-button" onclick="closeModal('#my-modal-category-2')"><span class="a11y">close</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
        const moveToList = page => {
            let bodies = {offset:page};
            const urlSearch = new URLSearchParams(location.search);
            if (urlSearch.get('categories')) bodies.categories = urlSearch.get('categories');
            if (urlSearch.get('regions')) bodies.regions = urlSearch.get('regions');
            location.replace("/mypage/like?" + new URLSearchParams(bodies));
        }

        const getList = () => {
            const checkedCategories = document.querySelectorAll('[name*=category_check]:checked');
            const checkedRegions = document.querySelectorAll('[name*=region_check]:checked');
            let categories = [];
            let regions = [];
            for(const category of checkedCategories) categories.push(category.value);
            for(const region of checkedRegions) regions.push(region.value);
            const params = {};
            if (categories) params['categories'] = categories;
            if (regions) params['regions'] = regions;
            location.href='/mypage/like?' + new URLSearchParams(params);
        }

        const refreshRegion = () => {
            let bodies = {};
            const urlSearch = new URLSearchParams(location.search);
            if (urlSearch.get('categories')) bodies.keyword = urlSearch.get('categories');
            location.href='/mypage/like?'+ new URLSearchParams(bodies);
        }

        const regionButtons = document.querySelectorAll('.category-data__wrap button');
        regionButtons.forEach(button => {
            button.addEventListener('click', e => {
                let bodies = {};
                const urlSearch = new URLSearchParams(location.search);
                const regions = urlSearch.get('regions').split(',');
                const region = e.currentTarget.children[0].textContent;
                regions.splice(regions.indexOf(region), 1);
                if (urlSearch.get('categories')) bodies.categories = urlSearch.get('categories');
                bodies['regions'] = regions;
                location.href='/mypage/like?'+ new URLSearchParams(bodies);
            })
        })

        const toggleLike = like_idx => {
            fetch('/mypage/toggle/company/like', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: JSON.stringify({
                    idx: like_idx
                })
            }).then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Sever Error');
            }).then(json => {
                if (json.result === 'success') {
                    location.reload();
                } else {
                    alert(json.message);
                }
            }).catch(error => {
            })
        }
    </script>

