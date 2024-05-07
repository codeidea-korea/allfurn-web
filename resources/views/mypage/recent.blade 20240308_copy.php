<div class="my__section">
    <div class="content">
        <div class="section">
            <div class="section__head">
                <h3 class="section__title">최근 본 상품</h3>
                <div class="header_category">
                    <div class="inner relative">
                        <ul class="gnb flex items-center">
                            <li><button class="flex items-center category_btn"><svg><use xlink:href="/img/icon-defs.svg#Hamicon"></use></svg>카테고리</button></li>
                        </ul>
                        <div class="category_list"></div>
                    </div>
                </div>
                <div class="category-data category-data--modify">
                    <div class="category-data__wrap"></div>
                    <a href="#" class="category-filter__refresh">
                        초기화<i class="ico__refresh"></i>
                    </a>
                </div>
            </div>
            @if (count($list) < 1)
                <div class="my-content my-content--nodata nodata--modify">
                    <span><i class="ico__exclamation"></i></span>
                    <p>최근 본 상품을 추가해주세요.</p>
                </div>
            @else
            <div class="list" style="margin-bottom: -40px">
                <div class="list__meta-wrap">
                    <p class="list__total">총 {{ number_format($count) }}개</p>
                </div>
                <ul class="card-list">
                    @foreach($list as $row)
                    <li class="card-list__card">
                        <div class="card__bookmark {{ $row->isInterest > 0 ? 'card__bookmark--active' : '' }}">
                            <i class="ico__bookmark24--{{ $row->isInterest > 0 ? 'on' : 'off' }}" data-product-id="{{ $row->idx }}"><span class="a11y">스크랩 off</span></i>
                        </div>
                        <a href="/product/detail/{{ $row->idx }}" title="{{ $row->product_name }}">
                            <div class="card__img--wrap">
                                <img class="card__img" src="{{ $row->product_image }}" alt="{{ $row->product_name }}">

                            </div>
                            <div class="card__text--wrap">
                                <p class="card__brand">{{ $row->company_name }}</p>
                                <p class="card__name">{{ $row->name }}</p>
                                @if ($user->type !== 'N')
                                <p class="card__price">{{ $row->price_text ? $row->price_text : number_format($row->price).'원' }}</p>
                                @endif
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
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
                <button type="button" class="next" id="next-paginate" onclick="moveToList({{$pagination['next']}})">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12L10 7L5 2" stroke="#828282" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                @endif
            </div>
            @endif
        </div>
    </div>
    {{-- 카테고리 리스트 모달 --}}
    <div id="my-modal-category" class="modal modal-category modal-category--modify">
        <div class="modal__container">
            <div class="modal__content">
                <div class="modal-box__container">
                    <div class="modal-box__content">
                        <div class="header">
                            <p>카테고리 선택</p>
                        </div>
                        <div class="content">
                            @foreach($categories as $category)
                                <label for="category__check-{{ $category->idx }}" class="category__check">
                                    <input type="checkbox" {{ in_array($category->idx, $checked_categories) ? 'checked' : '' }} name="category_check[]" id="category__check-{{ $category->idx }}" value="{{ $category->idx }}">
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
</div>

<script src="/js/jquery-1.12.4.js" ></script>
<script>
    $(function(){
        getCategoryList();
    });

    function getCategoryList() {
        $.ajax({
            headers         : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url				: '/product/getCategoryListV2',
            data			: {},
            type			: 'POST',
            dataType		: 'json',
            success		    : function(result) {
                let htmlText = '<ul>';

                result.forEach(function(e, idx) {
                    console.log(e);
                    htmlText += '<li>';
                        htmlText += '<a href="javascript: ;">';
                        htmlText += '<i><img src="' +  e.imgUrl + '"></i>';
                        htmlText += '<span>' + e.name + '</span>';
                        htmlText += '</a>';
                        htmlText += '<ul class="depth2">';

                        e.depth2.forEach(function(e2, idx2) {
                            htmlText += '<li><a href="/product/category?ca=' + e2.idx + '&pre=' + e2.parent_idx+'">' + e2.name + '</a></li>';
                        });

                        htmlText += '</ul>';
                    htmlText += '</li>';
                })

                htmlText += '</ul>';

                $('.category_list').html(htmlText);
            }
        });
    }

    const moveToList = page => {
        let bodies = {offset:page};
        const urlSearch = new URLSearchParams(location.search);
        if (urlSearch.get('categories')) bodies.keyword = urlSearch.get('categories');
        location.replace("/mypage/recent?" + new URLSearchParams(bodies));
    }

    const getList = () => {
        const checkedCategories = document.querySelectorAll('[name*=category_check]:checked');
        let categories = [];
        for(const category of checkedCategories) categories.push(category.value);
        if (categories) {
            location.href='/mypage/recent?' + new URLSearchParams({categories:categories});
        } else {
            alert('카테고리를 선택해주세요.');
        }
    }

    const addInterestProducts = productIds => {
        fetch('/mypage/interest-products', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            body: JSON.stringify({
                idxes: productIds,
            })
        });
    }

    const removeInterestProducts = productIds => {
        fetch('/mypage/interest-products', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            body: JSON.stringify({
                idxes: productIds,
                folderId: null,
            })
        })
    }

    const bookmarks = document.querySelectorAll('.card__bookmark i');
    bookmarks.forEach(bookmark => {
        bookmark.addEventListener('click', e => {
            const productIds = [];
            const elem = e.currentTarget;
            productIds[0] = e.currentTarget.dataset.productId;
            if (elem.classList.contains('ico__bookmark24--off')) {
                addInterestProducts(productIds);
            } else {
                removeInterestProducts(productIds);
            }
        })
    })
</script>

<?php
     $fromSql = "select
     `cl`.`idx`, `cl`.`company_idx`, `cl`.`company_type`,
     IF(w.idx IS NOT NULL, w.company_name, r.company_name) AS company_name,
     IF(attach.idx IS NOT NULL, CONCAT('".preImgUrl()."',attach.folder,'/',attach.filename),'')  AS profile_image,
     GROUP_CONCAT(SUBSTRING_INDEX(IF(w.idx IS NOT NULL, wl.sido, rl.sido), ' ', 1)) AS region,
     IF(TIMESTAMPDIFF(SECOND ,cl.register_time, now() < 2592000), 'Y','N') AS is_new,
     (SELECT SUBSTRING_INDEX(group_concat(JSON_OBJECT(
         'name', ap.name,
         'idx', ap.idx,
         'image', CONCAT('".preImgUrl()."', aa.folder,'/', aa.filename)
       ) ORDER BY ap.register_time DESC),'},', 4) FROM AF_product ap LEFT JOIN AF_attachment aa ON SUBSTRING_INDEX(ap.attachment_idx, ',', 1) = aa.idx
         WHERE ap.company_type = cl.company_type
         AND ap.company_idx = cl.company_idx
     ) AS products,
     (SELECT GROUP_CONCAT(DISTINCT ac2.name)
         FROM AF_category ac
             INNER JOIN AF_product ap ON ac.idx = ap.category_idx
             INNER JOIN AF_category ac2 ON ac2.idx = ac.parent_idx
         WHERE ap.company_type = cl.company_type AND ap.company_idx = cl.company_idx
     ) AS category_names
 from
     `AF_company_like` as `cl`
         left join (`AF_wholesale` as `w` left join `AF_location` as `wl` on `wl`.`company_idx` = `w`.`idx` and `wl`.`company_type` = 'W')
             on `w`.`idx` = `cl`.`company_idx` and `cl`.`company_type` = 'W'
         left join (`AF_retail` as `r` left join `AF_location` as `rl` on `rl`.`company_idx` = `r`.`idx` and `rl`.`company_type` = 'R')
             on `r`.`idx` = `cl`.`company_idx` and `cl`.`company_type` = 'R'
         left join `AF_attachment` as `attach`
             on `attach`.`idx` = `w`.`profile_image_attachment_idx` or `attach`.`idx` = r.profile_image_attachment_idx
 where `cl`.`user_idx` = ".Auth::user()['idx']." {$where}
 group by `cl`.`company_idx`, `cl`.`company_type` ORDER BY `cl`.idx DESC";
?>