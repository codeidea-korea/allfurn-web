@if($commentTotalCount < 1)
    <div class="community-content__wrap">
        <p class="community-content--nodata">작성한 댓글이 없습니다.</p>
    </div>
@else
    <p class="community-content__total">전체 {{$commentTotalCount}}개</p>
    <div class="community-reply">
        @foreach($comments as $comment)
        <div class="community-reply__item" data-article-id="{{ $comment->article_idx }}" data-comment-id="{{ $comment->idx }}" style="cursor: pointer; {{ $loop->index > 0 ? 'margin-top: 16px;' : '' }}">
            <div class="community-reply__container">
                <div class="community-reply__content">
                    <div class="community-reply__head">
                        <p class="tag__color">{{ $comment->board_name }}</p>
                        <p class="community-reply__title">{{ $comment->article_title }}</p>
                    </div>
                    <a href="javascript:void(0)" class="ico__more"></a>
                    <div class="community-reply__box">
                        <a href="javascript:void(0)" name="remove-comments" data-comment-id="{{ $comment->idx }}">삭제</a>
                    </div>
                    <div class="community-reply__text">
                        <p class="community-reply__desc">{{ $comment->depth === 1 ? $comment->content : $comment->reply_content }}</p>
                        <p class="community-reply__time">{{ $comment->diff_time }}</p>
                    </div>
                    @if ($comment->depth == 2)
                    <div class="community-reply__recomment">
                        <p class="community-reply__recomment-text">{{ $comment->content }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
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
    <!-- 코멘트 삭제 완료 -->
    <div id="modal-remove--comment_complete" class="modal">
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
                            <button type="button" onclick="location.replace('{{$_SERVER['REQUEST_URI']}}')" class="modal__button"><span>확인</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@push('scripts')
    <script>
        document.querySelectorAll('[name=remove-comments]').forEach(article => {
            article.addEventListener('click', evt => {
                evt.stopPropagation();
                evt.preventDefault();
                const idx = evt.currentTarget.dataset.commentId;
                deleteComment(idx);
            })
        })
        // 게시 삭제 시
        const deleteComment = idx => {
            fetch('/community/comment/' + idx, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            }).then(result => {
                return result.json();
            }).then(json => {
                if (json.result === 'success') {
                    openModal('#modal-remove--comment_complete');
                } else {
                    location.replace('{{$_SERVER['REQUEST_URI']}}');
                }
            })
        }

        // 페이지 이동
        const getArticlesForPage = page => {
            let bodies = {offset:page};
            const urlSearch = new URLSearchParams(location.search);
            if (urlSearch.get('board_name')) bodies.board_name = urlSearch.get('board_name');
            location.replace("/community/my/comments?" + new URLSearchParams(bodies));
        }

        // 댓글로 이동
        const articles = document.querySelectorAll('.community-reply__item');
        articles.forEach(article => {
            article.addEventListener('click', evt => {
                const articleIdx = evt.currentTarget.dataset.articleId;
                const commentIdx = evt.currentTarget.dataset.commentId;
                document.cookie = "moveArticleComment=" + commentIdx + "; path=/; max-age=60";
                location.href='/community/detail/' + articleIdx;
            });
        })
    </script>
@endpush
