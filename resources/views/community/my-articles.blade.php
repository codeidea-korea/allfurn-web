@if($articleTotalCount < 1)
    <div class="community-content__wrap">
        @if($pageType === 'articles')
            <p class="community-content--nodata">작성한 게시글이 없습니다.</p>
        @else
            <p class="community-content--nodata">좋아요한 게시글이 없습니다.</p>
        @endif
    </div>
@else
    <p class="community-content__total">전체 {{$articleTotalCount}}개</p>
    @foreach($articles as $article)
        <div class="community-content__item {{ $article->is_open === 0 ? 'community-content__item--disabled' : '' }}">
            <div class="community-content__container" data-article-id="{{$article->idx}}">
                <div class="community-content__content">
                    <div class="community-content__type">
                        <p class="tag__color">{{$article->board_name}}</p>
                        @if($article->type === 'N')
                            <p>공지</p>
                        @elseif($article->type === 'A')
                            <p>광고</p>
                        @endif
                    </div>
                    <div class="community-content__desc">
                        <p>{{$article->title}}
                            @if($article->is_new)
                                <span class="badge__new"></span>
                            @endif
                        </p>
                    </div>
                    <div class="community-content__writer">
                        <p>{{ $article->is_admin ? '관리자' : $article->writer }}</p>
                    </div>
                </div>
                @if($pageType === 'articles')
                <a href="javascript:void(0)" class="ico__more"></a>
                <div class="community-reply__box">
                    <a href="/community/write/{{$article->idx}}">수정</a>
                    <a href="javascript:void(0)" name="remove-articles" data-article-id="{{ $article->idx }}">삭제</a>
                </div>
                @endif
                @if($article->first_image)
                    <div class="community-content__image" style="background-image:url('{{asset("storage/articles/{$article->first_image}")}}')"></div>
                @endif
            </div>
            <div class="community-content__info">
                <div class="community-content__utils">
                    <div class="community-content__util community-content__watch ">
                        <p><i class="ico__viewcnt"></i> {{$article->view_count}}</p>
                    </div>
                    <a href="javascript:void(0)" class="community-content__util community-content__like">
                        <p><i class="{{$pageType === 'likes' ? 'ico__like--active' : 'ico__like'}}"></i> {{$article->like_count}}</p>
                    </a>
                    <a href="javascript:void(0)" class="community-content__util community-content__count">
                        <p><i class="ico__reply"></i> {{$article->reply_count}}</p>
                    </a>
                </div>
                <p class="community-content__time">{{$article->diff_time}}</p>
            </div>
        </div>
    @endforeach
    <div class="pagenation">
        @if($pagination['prev'] > 0)
            <button type="button" class="prev" id="prev-paginate" onclick="getArticlesForPage({{$pagination['prev']}})">
                <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 1L1 6L6 11" stroke="#DBDBDB" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        @endif
        <div class="numbering">
            @foreach($pagination['pages'] as $paginate)
                @if ($paginate == $offset)
                    <a href="javascript:void(0)" onclick="getArticlesForPage({{$paginate}})" class="numbering--active">{{$paginate}}</a>
                @else
                    <a href="javascript:void(0)" onclick="getArticlesForPage({{$paginate}})">{{$paginate}}</a>
                @endif
            @endforeach
        </div>
        @if($pagination['next'] > 0)
            <button type="button" class="next" id="next-paginate" onclick="getArticlesForPage({{$pagination['next']}})">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12L10 7L5 2" stroke="#828282" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        @endif
    </div>
    <!-- 삭제 팝업 -->
    <div id="alert-modal" class="alert-modal">
        <div class="alert-modal__container">
            <div class="alert-modal__top">
                <p>삭제하시겠습니까?</p>
            </div>
            <div class="alert-modal__bottom">
                <div class="button-group">
                    <button type="button" class="button button--solid-gray" onclick="closeModal('#alert-modal')">
                        취소
                    </button>
                    <button type="button" class="button button--solid" data-delete-artile-id="">
                        확인
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- 삭제 완료 -->
    <div id="modal-remove--article_complete" class="modal">
        <div class="modal__container" style="width: 350px;">
            <div class="modal__content">
                <div class="modal-box__container">
                    <div class="modal-box__content">
                        <div class="modal__desc">
                            <p class="modal__text">
                                삭제 완료되었습니다.
                            </p>
                        </div>
                        <div class="modal__util">
                            <button type="button" onclick="location.replace('{{$_SERVER['REQUEST_URI']}}');" class="modal__button"><span>확인</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@push('scripts')
    <script>
        document.querySelectorAll('[name=remove-articles]').forEach(article => {
            article.addEventListener('click', evt => {
                evt.stopPropagation();
                evt.preventDefault();
                const idx = evt.currentTarget.dataset.articleId;
                deleteArticle(idx);
            })
        })
        // 게시 삭제 시
        const deleteArticle = idx => {
            fetch('/community/remove/' + idx, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            }).then(result => {
                return result.json();
            }).then(json => {
                if (json.result === 'success') {
                    openModal('#modal-remove--article_complete');
                } else {
                    location.replace('{{$_SERVER['REQUEST_URI']}}');
                }
            })
            return false;
        }

        // 페이지 이동
        const getArticlesForPage = page => {
            let bodies = {offset:page};
            const urlSearch = new URLSearchParams(location.search);
            if (urlSearch.get('board_name')) bodies.board_name = urlSearch.get('board_name');
            location.replace("/community/my/{{$pageType}}?" + new URLSearchParams(bodies));
        }

        // 게시글로 이동
        const articles = document.querySelectorAll('.community-content__container');
        articles.forEach(article => {
            article.addEventListener('click', evt => {
                const idx = evt.currentTarget.dataset.articleId;
                location.href='/community/detail/' + idx;
            });
        })
    </script>
@endpush
