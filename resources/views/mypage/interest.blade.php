<div class="my__section">
    <div class="content">
        <div class="section">
            <div class="section__head">
                <h3 class="section__title">
                    <p>관심 상품</p>
                    <button type="button" class="button section__head-button" onclick="getFolders()">
                        <i class="ico__setting"><span class="a11y">관리</span></i>
                        <p>폴더 관리</p>
                    </button>
                </h3>
            </div>
            <div class="inner__category">
                <div class="sub-category">
                    <p class="sub-category__item {{ !request()->get('folder') ? 'sub-category__item--active' : '' }}"><a href="/mypage/interest">전체</a></p>
                    @foreach($folders as $folder)
                    <p class="sub-category__item {{ request()->get('folder') == $folder->idx ? 'sub-category__item--active' : '' }}"><a href="/mypage/interest?folder={{ $folder->idx }}">{{ $folder->name }}</a></p>
                    @endforeach
                </div>
            </div>
            <div class="category-type">
                <div class="category-type__item">
                    <a href="#" class="category-type__item-1" onclick="openModal('.modal-category')">
                        카테고리
                        <span class="category__count"></span>
                        <i class="ico__arrow--down14"></i>
                    </a>
                </div>
            </div>
            <div class="category-data category-data--modify">
                <div class="category-data__wrap">
                </div>
                <a href="#" class="category-filter__refresh">
                    초기화
                    <i class="ico__refresh"></i>
                </a>
            </div>
            @if (count($list) < 1)
                <div class="my-content my-content--nodata nodata--modify">
                    <span><i class="ico__exclamation"></i></span>
                    <p>관심 상품을 추가해주세요.</p>
                </div>
            @else
                <div class="folder-setting hidden">
                    <label for="list-checkall">
                        <input type="checkbox" id="list-checkall" class="checkbox__checked">
                        <span>전체 선택</span>
                    </label>
                    <ul>
                        <li><button type="button" class="button" onclick="openModal('#default-modal--my-refolder')">폴더 이동</button></li>
                        <li><button type="button" class="button" onclick="removeInterestProduct(this)" data-btn-type="modal">삭제</button></li>
                        <li><button type="button" class="button" onclick="hideEdit()">완료</button></li>
                    </ul>
                </div>
                <div class="list">
                    <div class="list__meta-wrap">
                        <div class="list__total">총 {{ number_format($count) }}개</div>
                        <button type="button" class="list-button button" onclick="showEdit()">편집</button>
                    </div>
                    <ul class="card-list"  style="margin-bottom: -40px;">
                        @foreach($list as $row)
                            <li class="card-list__card">
                                <div class="card__check hidden">
                                    <label for="list-card{{ $row->idx }}">
                                        <input type="checkbox" id="list-card{{ $row->idx }}" name="check-cards[]" class="checkbox__checked" value="{{ $row->idx }}"><span></span>
                                    </label>
                                </div>
                                <div class="card__bookmark">
                                    <i class="ico__bookmark24--on" data-product-id="{{ $row->idx }}"><span class="a11y">스크랩 on</span></i>
                                </div>
                                @if($row->folder_name)
                                <div class="card__folder">
                                    <p>{{ $row->folder_name }}</p>
                                </div>
                                @endif
                                <a href="/product/detail/{{ $row->idx }}" title="{{ $row->product_name }}">
                                    <div class="card__img--wrap">
                                        <img class="card__img" src="{{ $row->product_image }}" alt="{{ $row->product_name }}">

                                    </div>
                                    <div class="card__text--wrap">
                                        <p class="card__brand">{{ $row->company_name }}</p>
                                        <p class="card__name">{{ $row->product_name }}</p>
                                        @if ($user->type !== 'N')
                                        <p class="card__price">{{ $row->price_text ? $row->price_text : number_format($row->price).'원' }}</p>
                                        @endif
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
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
                </div>
            @endif
        </div>
    </div>

    {{-- 폴더 리스트 모달 --}}
    <div id="default-modal--my-folder" class="default-modal default-modal--my-folder">
        <div class="default-modal__container">
            <div class="default-modal__header">
                <div class="default-modal__header-wrap">
                    <h2>폴더 관리</h2>
                    <button type="button" class="button button-plus" onclick="openFolderList()"><i class="ico__add--circle"></i>추가</button>
                </div>
                <button type="button" class="ico__close28" onclick="closeModal('#default-modal--my-folder')">
                    <span class="a11y">닫기</span>
                </button>
            </div>
            <div class="default-modal__content" id="folder-modal-content">
            </div>
            <div class="default-modal__footer">
                <button type="button" class="button button--solid" onclick="addFolder()">저장</button>
            </div>
        </div>
    </div>
    {{-- 폴더 삭제 확인 모달 --}}
    <div id="mpg_delete-folder" class="modal">
        <div class="modal__container">
            <div class="modal__content">
                <div class="modal-box__container">
                    <div class="modal-box__content">
                        <div class="modal__desc">
                            <p class="modal__text">
                                폴더를 삭제하시겠습니까?<br>폴더에 담긴 상품도 함께 삭제됩니다.
                            </p>
                        </div>
                        <div class="modal__buttons">
                            <a onclick="closeModal('#mpg_delete-folder')" role="button" class="modal__button modal__button--gray"><span>취소</span></a>
                            <a onclick="removeFolder(this)" id="removeFolderBtn" data-btn-type="confirm" data-folder-id="" role="button" class="modal__button"><span>확인</span></a>
                        </div>
                    </div>
                </div>
            </div>
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
    {{-- 관심 상품 삭제 확인 모달 --}}
    <div id="mpg_delete-listitem" class="modal">
        <div class="modal__container">
            <div class="modal__content">
                <div class="modal-box__container">
                    <div class="modal-box__content">
                        <div class="modal__desc">
                            <p class="modal__text">
                                상품을 삭제하시겠습니까?<br>관심 상품 내 모든 폴더에서 사라집니다.
                            </p>
                        </div>
                        <div class="modal__buttons">
                            <a onclick="closeModal('#mpg_delete-listitem')" role="button" class="modal__button modal__button--gray"><span>취소</span></a>
                            <a onclick="removeInterestProduct(this)" data-btn-type="confirm" role="button" class="modal__button"><span>확인</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- 폴더 이동 유무 확인 모달 --}}
    <div id="mpg_refolder" class="modal">
        <div class="modal__container">
            <div class="modal__content">
                <div class="modal-box__container">
                    <div class="modal-box__content">
                        <div class="modal__desc">
                            <p class="modal__text">
                                폴더를 이동하시겠습니까?
                            </p>
                        </div>
                        <div class="modal__buttons">
                            <a onclick="closeModal('#mpg_refolder')" role="button" class="modal__button modal__button--gray"><span>취소</span></a>
                            <a onclick="moveInterestProduct(this)" id="moveInterestProductsBtn" data-folder-id="" data-btn-type="confirm" role="button" class="modal__button"><span>확인</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- 폴더 이동 리스트 모달 --}}
    <div id="default-modal--my-refolder" class="default-modal default-modal--my-refolder default-modal--my-refolder--modify">
        <div class="default-modal__container">
            <div class="default-modal__header">
                <div class="default-modal__header-wrap">
                    <h2>폴더 이동</h2>
                </div>
                <button type="button" class="ico__close28" onclick="closeModal('#default-modal--my-refolder')">
                    <span class="a11y">닫기</span>
                </button>
            </div>
            <div class="default-modal__content">
                <ul>
                    <li>
                        <p>전체</p>
                    </li>
                    <li><button type="button" class="button button-refolder" onclick="moveInterestProduct(this)" data-folder-id="" data-btn-type="modal">이동</button></li>
                </ul>
                @foreach($folders as $folder)
                <ul>
                    <li>
                        <p>{{ $folder->name }}</p>
                        <span class="count">({{ $folder->product_count >= 1000 ? '999+' : ($folder->product_count < 1 ? 0 : $folder->product_count)}})</span>
                    </li>
                    <li><button type="button" onclick="moveInterestProduct(this)" class="button button-refolder" data-folder-id="{{ $folder->idx }}" data-btn-type="modal">이동</button></li>
                </ul>
                @endforeach
            </div>
            <div class="default-modal__footer" style="height: 42px;">
            </div>
        </div>
    </div>
</div>

    <script>
        const moveToList = page => {
            let bodies = {offset:page};
            const urlSearch = new URLSearchParams(location.search);
            if (urlSearch.get('categories')) bodies.keyword = urlSearch.get('categories');
            if (urlSearch.get('folder')) bodies.keyword = urlSearch.get('folder');
            location.replace("/mypage/interest?" + new URLSearchParams(bodies));
        }

        const getList = () => {
            const checkedCategories = document.querySelectorAll('[name*=category_check]:checked');
            let categories = [];
            for(const category of checkedCategories) categories.push(category.value);
            if (categories) {
                location.href='/mypage/interest?' + new URLSearchParams({categories:categories});
            } else {
                alert('카테고리를 선택해주세요.');
            }
        }

        const getFolders = () => {
            fetch('/mypage/my-folders', {
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            }).then(response => {
                return response.text()
            }).then(html => {
                document.getElementById('folder-modal-content').innerHTML = html;
                openModal('#default-modal--my-folder');
            })
        }

        const openFolderList = () => {
            const addFolderElem = document.querySelector('[name=add-folder][class="hidden"]').cloneNode(true);
            addFolderElem.classList.remove('hidden');
            document.getElementById('folder-modal-content').append(addFolderElem);
        }

        const addFolder = () => {
            const updateElements = document.querySelectorAll('[name*=update_folder_name]');
            const registerElements = document.querySelectorAll('[name*=add_folder_name]');
            let doUpdates = [];
            let doAdds = [];
            updateElements.forEach(elem => {
                elem.value ? doUpdates.push({idx: elem.dataset.folderId, folder_name:elem.value}) : '';
            })
            registerElements.forEach((elem, index)=> {
                if (index === 0) {
                    return;
                }
                elem.value ? doAdds.push(elem.value) : '';
            })
            fetch('/mypage/my-folders', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: JSON.stringify({
                    updates: doUpdates,
                    adds: doAdds,
                })
            }).then(response => {
                return response.json()
            }).then(json => {
                location.reload();
            })
        }

        const removeFolder = elem => {
            if (elem.dataset.btnType === 'confirm') {
                const idx = elem.dataset.folderId;
                fetch('/mypage/my-folders/' + idx, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    }
                }).then(response => {
                    return response.json()
                }).then(json => {
                    location.reload();
                });
            } else {
                const idx = elem.closest('ul').dataset.folderId ?? null;
                if (idx) {
                    document.getElementById('removeFolderBtn').dataset.folderId = idx;
                    openModal('#mpg_delete-folder');
                } else {
                    elem.closest('ul').remove();
                }
            }
        }

        const showEdit = () => {
            document.querySelector('.folder-setting').classList.remove('hidden');
            const cards = document.querySelectorAll('.card-list__card .card__check.hidden');
            cards.forEach(elem => {
                elem.classList.remove('hidden');
            })
            document.querySelector('.list__meta-wrap').classList.add('hidden');
            document.querySelector('.category-type').classList.add('hidden');
        }

        const hideEdit = () => {
            document.querySelector('.folder-setting').classList.add('hidden');
            const cards = document.querySelectorAll('.card-list__card .card__check');
            cards.forEach(elem => {
                elem.classList.add('hidden');
            })
            document.querySelector('.list__meta-wrap').classList.remove('hidden');
            document.querySelector('.category-type').classList.remove('hidden');
        }

        const removeInterestProduct = elem => {
            if (elem.dataset.btnType === 'confirm') {
                const cards = document.querySelectorAll('.card-list__card .card__check input[type=checkbox]:checked');
                let idxes = [];
                for(const card of cards) idxes.push(card.value);
                fetch('/mypage/interest-products', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    body: JSON.stringify({
                        idxes: idxes
                    })
                }).then(response => {
                    return response.json()
                }).then(json => {
                    location.reload();
                })
            } else {
                const cards = document.querySelectorAll('.card-list__card .card__check input[type=checkbox]:checked');
                if (cards.length > 0) {
                    openModal('#mpg_delete-listitem');
                }
            }
        }

        const moveInterestProduct = elem => {
            if (elem.dataset.btnType === 'confirm') {
                const cards = document.querySelectorAll('.card-list__card .card__check input[type=checkbox]:checked');
                let idxes = [];
                for(const card of cards) idxes.push(card.value);
                fetch('/mypage/move/interest-products', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    body: JSON.stringify({
                        idxes: idxes,
                        folderId: (elem.dataset.folderId ?? ''),
                    })
                }).then(response => {
                    return response.json();
                }).then(json => {
                    location.reload();
                })
            } else {
                document.getElementById('moveInterestProductsBtn').dataset.folderId = elem.dataset.folderId;
                openModal('#mpg_refolder');
            }
        }

        document.getElementById('list-checkall').addEventListener('click', e => {
            const cards = document.querySelectorAll('.card-list__card .card__check input[type=checkbox]');
            for(const card of cards) card.checked = e.currentTarget.checked;
        })

        const bookmarks = document.querySelectorAll('.card__bookmark .ico__bookmark24--on');
        bookmarks.forEach(bookmark => {
            bookmark.addEventListener('click', e => {
                const productIds = [];
                productIds[0] = e.currentTarget.dataset.productId;
                const folderId = '{{ request()->get('folder') }}';
                fetch('/mypage/interest-products', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    body: JSON.stringify({
                        idxes: productIds,
                        folderId: folderId
                    })
                }).then(response => {
                    location.reload();
                })
            })
        })

    </script>
