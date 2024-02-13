@if(!$article)
    <div id="modal-error" class="modal">
        <div class="modal__container" style="width: 350px;">
            <div class="modal__content">
                <div class="modal-box__container">
                    <div class="modal-box__content">
                        <div class="modal__desc">
                            <p class="modal__text">
                                삭제된 글입니다.
                            </p>
                        </div>
                        <div class="modal__util">
                            <button type="button" onclick="history.back();" class="modal__button"><span>확인</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            openModal('#modal-error')
        </script>
    @endpush
@elseif($article->is_open == 0)
    <div id="modal-error" class="modal">
        <div class="modal__container" style="width: 350px;">
            <div class="modal__content">
                <div class="modal-box__container">
                    <div class="modal-box__content">
                        <div class="modal__desc">
                            <p class="modal__text">
                                숨김 처리된 글입니다.
                            </p>
                        </div>
                        <div class="modal__util">
                            <button type="button" onclick="history.back();" class="modal__button"><span>확인</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            openModal('#modal-error')
        </script>
    @endpush
@else
<div class="community-content">
    <div class="community-content__type">
        <p class="tag__color">{{$article->board_name}}</p>
        @if($article->type === 'N')
        <p>공지</p>
        @elseif($article->type === 'A')
        <p>광고</p>
        @endif
    </div>
    <div class="detail">
        <div class="detail__head">
            <div class="detail__title">
                <p class="detail__title-text">
                    {{$article->title}}
                    @if (strtotime("{$article->register_time} +1 days") > strtotime("Now"))
                    <span class="badge__new--big"></span>
                    @endif
                </p>
                @if($article->user_idx === auth()->user()->idx)
                    <a href="#" class="ico__more"></a>
                    <div class="community-reply__box">
                        <a href="/community/write/{{ $articleId }}">수정</a>
                        <a href="javascript:void(0)" onclick="deleteArticle({{ $articleId }})">삭제</a>
                    </div>
                @else
                    <a href="#" class="ico__more"></a>
                    <div class="community-reply__box">
                        <a href="javascript:void(0)" onclick="report({{ $article['idx'] }}, {{ $article['company_idx'] }}, '{{ $article['company_type'] }}')">신고하기</a>
                    </div>
                @endif
            </div>
            <p class="detail__writer">{{ $article->is_admin ? '관리자' : $article->writer }}</p>
            <div class="detail__util">
                <p class="detail__viewcnt">
                    <i class="ico__viewcnt"></i>
                    <span>조회 {{ $article->view_count }}</span>
                </p>
                <p class="detail__date">{{ date('Y.m.d H:i', strtotime($article->register_time)) }}</p>
            </div>
        </div>
        <div class="detail__content">
            {!! $article->content !!}
        </div>
        <div class="detail__footer">
            <div class="detail__wrap">
                <a href="javascript:void(0)" class="detail__action detail__like" id="detail_like">
                    <i class="ico__like-line"></i>
                    <span>좋아요</span>
                    <span id="like_count">{{ $article->like_count }}</span>
                </a>
                <a href="javascript:void(0)" class="detail__action detail__share" id="detail_share">
                    <i class="ico__share24"></i>
                    <span>공유</span>
                </a>
            </div>
        </div>
        <div class="detail__comment">
            <p class="detail__total-comment">댓글 <span>{{ count($comments) }}</span></p>
            <div class="community-comment">
                @foreach($comments as $comment)
                <div class="community-comment__item hidden {{ $comment['depth'] == 2 ? 'community-comment__reply' : '' }}" data-comment-id="{{ $comment['idx'] }}">
                    <div class="community-comment__head">
                        <p class="community-comment__title">
                            {{$comment['writer']}}
                            @if($comment['user_idx'] == $article->user_idx)
                            <span class="community-comment__writer">작성자</span>
                            @endif
                        </p>
                        <p class="community-comment__time">{{$comment['diff_time']}}</p>
                    </div>
                    <p class="community-comment__desc">
                        {{---- 게시판이 비밀 댓글이 설정된 경우 게시글의 작성자만 모든 댓글에 내용을 확인할 수 있다. 다만, 댓글을 작성한 작성자의 경우 본인의 댓글과 작성자가 작성한 대댓글은 확인할 수 있다. ----}}
                        @if(!$comment['is_secret_reply'] || ($comment['is_secret_reply'] && (
                                ($article->user_idx == auth()->user()->idx)
                                || ($comment['user_idx'] == auth()->user()->idx)
                                || ($comment['depth'] == 2 && $comment['user_idx'] == $article->user_idx && $comment['parent_user_idx'] == auth()->user()->idx)
                            )
                        ))
                            {{$comment['content']}}
                        @else
                            비밀 댓글입니다.
                        @endif
                    </p>
                    {{---- 게시판이 비밀 댓글이 설정된 경우 작성자만 대댓글을 작성할 수 있다. ----}}
                    @if($comment['depth'] == 1 && ($comment['is_secret_reply'] && $article->user_idx == auth()->user()->idx || !$comment['is_secret_reply']))
                    <div class="community-comment__box">
                        <a href="javascript:void(0)" class="community-comment__text">답글 쓰기</a>
                    </div>
                    <div class="community-comment__recomment">
                        <p><i class="ico__recomment"></i>{{$comment['writer']}} 님에게 답글 쓰는 중</p>
                        <div class="recomment">
                            <input type="text" name="secondDepthContent" data-comment-idx="{{$comment['idx']}}" placeholder="답글을 입력해주세요.">
                            <div class="recomment__util">
                                <button type="button" class="recomment__cancle">취소</button>
                                <button type="button" class="recomment__regist" data-comment-idx={{$comment['idx']}}>등록</button>
                            </div>
                        </div>
                    </div>
                    @endif
                    <a href="#" class="ico__more"></a>
                    <div class="community-reply__box">
                        @if($comment['user_idx'] == auth()->user()->idx)
                            <a href="javascript:void(0)" onclick="deleteComment({{ $comment['idx'] }})">삭제</a>
                        @else
                            <a href="javascript:void(0)" onclick="reportComment({{ $comment['idx'] }}, {{ $comment['company_idx'] }}, '{{ $comment['company_type'] }}')">신고하기</a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @if(count($comments) > 5)
            <div class="detail__more-comment" id="more-comment">
                <button type="button" onclick="visibleComments(true)">
                    <i class="ico__plus"></i>
                    <span class="button__text">댓글 더보기</span>
                </button>
            </div>
            @endif
            <div class="detail__write">
                <input type="text" name="reply_comment" id="reply_comment" placeholder="댓글을 입력해주세요.">
                <button type="button" id="register_reply_comment_btn" disabled="true">등록 </button>
            </div>
        </div>

        <!-- 신고 레이어 팝업 -->
        <div id="modal-declaration" class="modal modal-declaration--modify">
            <div class="modal__container">
                <div class="modal__content">
                    <div class="modal-box__container" style="width: 480px">
                        <div class="modal-box__content">
                            <div class="header">
                                <p>게시글 신고</p>
                            </div>
                            <div class="content">
                                <p>해당 게시글을 신고하시겠습니까?</p>
                                <input type="hidden" name="report_content_type" id="report_content_type" value="" />
                                <input type="hidden" name="report_id" id="report_id" value="" />
                                <input type="hidden" name="report_company_idx" id="report_company_idx" value="" />
                                <input type="hidden" name="report_company_type" id="report_company_type" value="" />
                                <textarea placeholder="신고 사유를 입력해주세요." name="report_content" id="report_content" rows=20 cols=30></textarea>
                            </div>
                            <div class="footer">
                                <button type="button" id="declare_complete_btn">완료</button>
                            </div>
                            <div class="modal-close">
                                <button type="button" class="modal__close-button" onclick="closeModal('#modal-declaration')"><span class="a11y">close</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 신고 완료 팝업 -->
        <div id="modal-declaration--done" class="modal">
            <div class="modal__container" style="width: 350px;">
                <div class="modal__content">
                    <div class="modal-box__container">
                        <div class="modal-box__content">
                            <div class="modal__desc">
                                <p class="modal__text">
                                    신고가 완료되었습니다.
                                </p>
                            </div>
                            <div class="modal__util">
                                <button type="button" onclick="closeModal('#modal-declaration--done');" class="modal__button"><span>확인</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

        <!-- 댓글 등록 완료 -->
        <div id="modal-regist--complete" class="modal">
            <div class="modal__container" style="width: 350px;">
                <div class="modal__content">
                    <div class="modal-box__container">
                        <div class="modal-box__content">
                            <div class="modal__desc">
                                <p class="modal__text">
                                    댓글이 등록되었습니다.
                                </p>
                            </div>
                            <div class="modal__util">
                                <button type="button" onclick="location.replace('/community/detail/{{ $articleId }}')" class="modal__button"><span>확인</span></button>
                            </div>
                        </div>
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
                                <button type="button" onclick="location.replace('/community')" class="modal__button"><span>확인</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                                <button type="button" onclick="location.replace('/community/detail/{{$articleId}}')" class="modal__button"><span>확인</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 금지어 작성 시 -->
        <div id="modal-regist--failure" class="modal">
            <div class="modal__container" style="width: 350px;">
                <div class="modal__content">
                    <div class="modal-box__container">
                        <div class="modal-box__content">
                            <div class="modal__desc">
                                <p class="modal__text">
                                    해당 게시판의 금지어를 사용하여<br>
                                    등록할 수 없습니다.
                                </p>
                            </div>
                            <div class="modal__util">
                                <button type="button" onclick="closeModal('#modal-regist--failure');" class="modal__button"><span>확인</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal-ALT-06" class="modal">
    <div class="modal__container" style="width: 350px;">
        <div class="modal__content">
            <div class="modal-box__container">
                <div class="modal-box__content">
                    <div class="modal__desc">
                        <p class="modal__text">
                            링크가 복사되었습니다.
                        </p>
                    </div>
                    <div class="modal__util">
                        <button type="button" onclick="closeModal('#modal-ALT-06');" class="modal__button"><span>확인</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // 댓글로 이동
    const moveComment = () => {
        const cookies = document.cookie.split("; ");
        cookies.forEach(cookie => {
            const splitCookie = cookie.split('=');
            const cookieKey = splitCookie[0];
            const cookieValue = splitCookie[1];
            if (cookieKey === 'moveArticleComment') {
                // 댓글 모두 보여주기
                visibleComments(true);
                const targetComment = document.querySelector('.community-comment__item[data-comment-id="'+ cookieValue +'"]');
                // gnb 영역이 가려져서 안보일 경우를 고려하여 height 에 130을 뺀다.
                window.scrollTo(0, targetComment.getBoundingClientRect().top - 130);
                document.cookie = "moveArticleComment=''; path=/; max-age=0";
                targetComment.classList.add('blink');
                setTimeout(() => {
                    document.querySelector('.community-comment__item[data-comment-id="'+ cookieValue +'"]').classList.remove('blink');
                }, 600);
            }

        })
    }
    // 댓글 더보기
    const visibleComments = is_all => {
        const hiddenComments = document.querySelectorAll('.community-comment__item.hidden');
        if (hiddenComments.length > 0) {
            if (is_all) {
                hiddenComments.forEach(elem => {
                    elem.classList.remove('hidden');
                })
            } else {
                const limit = hiddenComments.length < 5 ? hiddenComments.length : 5;
                for (let i = 0; i < limit; i++) {
                    hiddenComments[i].classList.remove('hidden');
                }
            }
        }

        if (document.querySelectorAll('.community-comment__item.hidden').length === 0 && document.getElementById('more-comment')) {
            document.getElementById('more-comment').style.display = 'none';
        }
    }
    // 더보기 최초 5개 보여주기
    visibleComments(false);
    // 댓글로 이동
    moveComment();

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
                location.replace('/community');
            }
        })
    }

    // 댓글 삭제 시
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
                location.replace('/community/detail/{{$articleId}}');
            }
        })
    }

    // 답변 등록 or 댓글/댓댓글 작성 시
    const registerComment = params => {
        fetch('/community/reply', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            body: JSON.stringify(params)
        }).then(result => {
            return result.json();
        }).then(json => {
            if (json.result === 'success') {
                openModal('#modal-regist--complete');
                return false;
            } else {
                if (json.code === 'USE_BANNED_WORDS') {
                    openModal('#modal-regist--failure');
                    return false;
                }
            }
        })
    }

    // 게시글 신고하기
    const report = (idx, company_idx, company_type) => {
        document.getElementById('report_content_type').value ='B' // article comment
        document.getElementById('report_id').value = idx;
        document.getElementById('report_company_idx').value = company_idx;
        document.getElementById('report_company_type').value = company_type;
        openModal('#modal-declaration');
    }

    // 댓글 신고하기
    const reportComment = (idx, company_idx, company_type) => {
        document.getElementById('report_content_type').value ='R' // article comment
        document.getElementById('report_id').value = idx;
        document.getElementById('report_company_idx').value = company_idx;
        document.getElementById('report_company_type').value = company_type;
        openModal('#modal-declaration');
    }

    // 신고하기
    document.getElementById('declare_complete_btn').addEventListener('click', () => {
       const params = {
           contentType: document.getElementById('report_content_type').value,
           reportId: document.getElementById('report_id').value,
           content: document.getElementById('report_content').value,
           companyIdx: document.getElementById('report_company_idx').value,
           companyType: document.getElementById('report_company_type').value,
       }
       fetch('/community/reporting', {
           method: 'POST',
           headers: {
               'Content-Type': 'application/json',
               'X-CSRF-TOKEN': '{{csrf_token()}}'
           },
           body: JSON.stringify(params)
       }).then(result => {
           return result.json();
       }).then(json => {
           openModal('#modal-declaration--done');
       }).finally(() => {
           document.getElementById('report_content_type').value = '';
           document.getElementById('report_id').value = '';
           document.getElementById('report_content').value = '';
           document.getElementById('report_company_idx').value = '';
           document.getElementById('report_company_type').value = '';
       })
    });
    // 링크 복사
    document.getElementById('detail_share').addEventListener('click', () => {
        var dummy   = document.createElement("input");
        var text    = location.href;

        document.body.appendChild(dummy);
        dummy.value = text;
        dummy.select();
        document.execCommand("copy");
        document.body.removeChild(dummy);

        openModal('#modal-ALT-06');
    });
    // 좋아요 버튼 클릭
    document.getElementById('detail_like').addEventListener('click', () => {
         fetch('/community/like-article', {
             method: 'POST',
             headers: {
                 'Content-Type': 'application/json',
                 'X-CSRF-TOKEN': '{{csrf_token()}}'
             },
             body: JSON.stringify({
                 articleId: {{ $articleId }}
             })
         }).then(result => {
             return result.json()
         }).then(json => {
             if (json.result === 'success') {
                 let currentCount = document.getElementById('like_count').textContent;
                 if (json.code === 'UP') {
                     document.getElementById('like_count').textContent = (currentCount * 1 + 1).toString();
                 } else {
                     document.getElementById('like_count').textContent = (currentCount * 1 - 1).toString();
                 }
             } else {
                 alert(json.message);
             }
         })
    });

    // 답변 내용 입력 시 답변 등록 버튼의 활성화/비활성화 기능
    document.getElementById('reply_comment').addEventListener('keyup', e => {
        const regRepCmtBtnElem = document.getElementById('register_reply_comment_btn');
        if (e.currentTarget.value.length > 0) {
            regRepCmtBtnElem.classList.add('active');
            regRepCmtBtnElem.removeAttribute('disabled');
        } else {
            regRepCmtBtnElem.classList.remove('active');
            regRepCmtBtnElem.setAttribute('disabled', true);
        }
        if (e.key === 'Enter') { // enter key
            e.currentTarget.setAttribute('disabled', true);
            regRepCmtBtnElem.click();
        }
    });

    // 댓글 내용 입력 시 댓글 등록 버튼의 활성화/비활성화 기능
    document.querySelectorAll('[name=secondDepthContent]').forEach(elem => {
        elem.addEventListener('keyup', e => {
            const parentId = e.currentTarget.dataset.commentIdx;
            const regRepCmtBtnElem = document.querySelector('.recomment__regist[data-comment-idx="'+parentId+'"]')
            if (e.currentTarget.value.length > 0) {
                regRepCmtBtnElem.classList.add('active');
                regRepCmtBtnElem.removeAttribute('disabled');
            } else {
                regRepCmtBtnElem.classList.remove('active');
                regRepCmtBtnElem.setAttribute('disabled', true);
            }
            if (e.key === 'Enter') { // enter key
                elem.setAttribute('disabled', true);
                regRepCmtBtnElem.click();
            }
        })
    })

    // 답변 등록 버튼 클릭 시
    document.getElementById('register_reply_comment_btn').addEventListener('click', e => {
        e.currentTarget.setAttribute('disabled', true);
        const params = {
            replyComment: document.getElementById('reply_comment').value,
            articleId: {{ $articleId }}
        };
        registerComment(params);
    })

    // 대댓글 등록 버튼 클릭 시
    document.querySelectorAll('.recomment__regist').forEach(elem => {
        elem.addEventListener('click', e => {
            const parentId = e.currentTarget.dataset.commentIdx
            const params = {
                replyComment: document.querySelector('[name=secondDepthContent][data-comment-idx="'+parentId+'"]').value,
                articleId: {{ $articleId }},
                parentId: parentId
            }
            registerComment(params);
        })
    })
</script>



@endif
