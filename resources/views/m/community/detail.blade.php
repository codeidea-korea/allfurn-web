@extends('layouts.app_m')

@section('content')
{{-- @include('layouts.header_m') --}}

<div id="content">
    <div class="detail_mo_top">
        <div class="inner">
            <a class="back_img" href="/community"><svg><use xlink:href="/img/icon-defs.svg#left_arrow"></use></svg></a>
            <div class="more_btn">
                <button><svg><use xlink:href="/img/icon-defs.svg#more_dot"></use></svg></button>
                <div>
                    @if( $article->is_admin || $article->user_idx === auth()->user()->idx)
                        <div><a href="/community/write/{{$articleId}}">수정</a></div>
                        <div><a href="javascript:;" onclick="deleteArticle({{ $articleId }})">삭제</a></div>
                    @else
                        <a href="javascript:;" onclick="setReportedArticleInfoAndModalOpen({{ $article->idx }}, {{ $article->company_idx }}, '{{ $article->company_type }}')">신고하기</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <section class="community_detail">
        <div class="inner">
            <div class="title">
                <div class="tag">
                    <span>{{$article->board_name}}</span>
                </div>
                <h3>{{$article->title}}</h3>
                <p>{{ $article->is_admin ? '관리자' : $article->writer }}</p>
                <div class="info">
                    <p>
                        <svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#commu_view"></use></svg>
                        조회 {{ $article->view_count }}
                    </p>
                    <p>{{ date('Y.m.d H:i', strtotime($article->register_time)) }}</p>
                </div>
            </div>
            <div class="content">
                {!! stripslashes($article->content) !!}
            </div>
        </div>
        <div class="bottom">
            <div class="link_box">
                <button class="btn zzim_btn {{ $article->is_like ? 'active' : ''}}" data-article-id="{{$article->idx}}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg>좋아요 <span id="like_count">{{ $article->like_count }}</span></button>
                <button class="btn" id="shareArticleBtn"><svg><use xlink:href="/img/icon-defs.svg#share"></use></svg>공유하기</button>
            </div>
            <div class="comment_box">
                <h6>댓글 {{ count($comments) }}</h6>
                <div class="comment_list">
                    @foreach ($comments as $comment)
                        <div class="comment_item {{ $comment['depth'] == 2 ? 'recomment_item' : '' }}"  data-id="{{ $comment['idx'] }}">
                            <div class="name">
                                <p>
                                    <b>{{$comment['writer']}}</b>
                                    {{$comment['diff_time']}}
                                </p>
                                <div class="more_btn">
                                    <button><svg><use xlink:href="/img/icon-defs.svg#more_dot"></use></svg></button>
                                    <div>
                                        @if($comment['user_idx'] == auth()->user()->idx)
                                            <a href="javascript:;" onclick="deleteComment({{ $comment['idx'] }})">삭제</a>
                                        @else
                                            <a href="javascript:;" onclick="setReportedCommentInfoAndModalOpen({{ $comment['idx'] }}, {{ $comment['company_idx'] }}, '{{ $comment['company_type'] }}')">신고하기</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="comm">
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
                            </div>
                            @if ($comment['depth'] == 1)
                                <div class="recomm">
                                    <button class="recomm_btn">
                                        <svg><use xlink:href="/img/icon-defs.svg#recomment"></use></svg> 답글 쓰기
                                    </button>
                                    <div class="recomm_form">
                                        <p><svg><use xlink:href="/img/icon-defs.svg#recomment"></use></svg> {{$comment['writer']}} 님에게 답글 쓰는 중</p>
                                        <div class="comment_form">
                                            <input type="text" class="input-form" placeholder="답글을 입력해주세요." data-parent-id="{{ $comment['idx'] }}">
                                            <button class="btn btn-line4 nohover comment_cancel">취소</button>
                                            <button class="btn btn-primary" disabled>등록</button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="comment_form">
                <input type="text" class="input-form" placeholder="댓글을 입력해주세요.">
                <button class="btn btn-primary" disabled>등록</button>
            </div>
        </div>
    </section>
    
    {{-- 댓글 삭제완료 모달--}}
    <div class="modal" id="delete_comment-modal">
        <div class="modal_bg" onclick="modalClose('#delete_comment-modal')"></div>
        <div class="modal_inner modal-sm">
            <button class="close_btn" onclick="modalClose('#delete_comment-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <p class="text-center py-4"><b>삭제 완료되었습니다.</b></p>
                <div class="flex gap-2 justify-center">
                    <button class="btn btn-primary w-1/2 mt-5" onclick="location.reload()">확인</button>
                </div>
            </div>
        </div>
    </div>

    {{-- 게시글 삭제완료 모달 --}}
    <div class="modal" id="delete_article-modal">
        <div class="modal_bg" onclick="modalClose('#delete_article-modal')"></div>
        <div class="modal_inner modal-sm">
            <button class="close_btn" onclick="modalClose('#delete_article-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <p class="text-center py-4"><b>삭제 완료되었습니다.</b></p>
                <div class="flex gap-2 justify-center">
                    <button class="btn btn-primary w-1/2 mt-5" onclick="location.replace('/community')">확인</button>
                </div>
            </div>
        </div>
    </div>

    {{-- 공유하기(링크복사)완료 모달  --}}
    <div class="modal" id="share_article-modal">
        <div class="modal_bg" onclick="modalClose('#share_article-modal')"></div>
        <div class="modal_inner modal-sm">
            <button class="close_btn" onclick="modalClose('#share_article-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <p class="text-center py-4"><b>링크가 복사되었습니다.</b></p>
                <div class="flex gap-2 justify-center">
                    <button class="btn btn-primary w-1/2 mt-5" onclick="modalClose('#share_article-modal')">확인</button>
                </div>
            </div>
        </div>
    </div>

    {{-- 신고하기 모달 --}}
    <div class="modal" id="report-modal">
        <div class="modal_bg" onclick="modalClose('#report-modal')"></div>
        <div class="modal_inner modal-md">
            <button class="close_btn" onclick="modalClose('#report-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <h3>댓글 신고</h3>
                <p class="text-center py-4">해당 댓글을 신고하시겠습니까?</p>
                <textarea class="textarea-form" id="report_content" placeholder="신고 사유를 입력해주세요."></textarea>
                <input type="hidden" name="report_type" id="report_type" value="" />
                <input type="hidden" name="report_id" id="report_id" value="" />
                <input type="hidden" name="report_company_idx" id="report_company_idx" value="" />
                <input type="hidden" name="report_company_type" id="report_company_type" value="" />
                <div class="flex gap-2 justify-center">
                    <button class="btn w-full btn-primary-line mt-5" onclick="refreshReportedCommentInfoAndModalClose()">취소</button>
                    <button class="btn w-full btn-primary mt-5" onclick="reportComment('#report-modal')">확인</button>
                </div>
            </div>
        </div>
    </div>

     {{-- 신고하기 완료 모달 --}}
     <div class="modal" id="complete_report-modal">
        <div class="modal_bg" onclick="modalClose('#complete_report-modal')"></div>
        <div class="modal_inner modal-sm">
            <button class="close_btn" onclick="modalClose('#complete_report-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <p class="text-center py-4"><b>신고가 완료되었습니다.</b></p>
                <div class="flex gap-2 justify-center">
                    <button class="btn btn-primary w-1/2 mt-5" onclick="modalClose('#complete_report-modal')">확인</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>

    // 댓글 입력 
    $('.comment_list .recomm_btn').on('click',function(){
        $(this).next('.recomm_form').toggleClass('active')
    })
    $('.comment_list .comment_cancel').on('click',function(){
        $(this).parents('.recomm_form').toggleClass('active')
    })

    $(".comment_form input").on('keyup', function() {
        if($(this).val().length === 0) {
            $(this).nextAll('button.btn-primary').attr('disabled', true);
        } else {
            $(this).nextAll('button.btn-primary').attr('disabled', false);
        }
    });

    $(".comment_form button").on('click', function() {
        const $comment = $(this).prevAll('input.input-form');
        if($comment.val().length > 0) {
            const data = {
                replyComment : $comment.val(),
                articleId : {{ $articleId }},
            };

            if($comment.data('parent-id')) {
                data.parentId = $comment.data('parent-id');
            }

            comment(data);
        }
    });

    // 댓글 달기
    function comment(data) {
        if(data!==undefined && typeof(data)=="object") {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                url: '/community/reply',
                data : data,
                beforeSend : function() {
                    $("#new_comment button").attr('disabled', true);
                },
                success : function (result) {
                    if(result.result === "success") {
                        location.reload();
                    }
                },
                complete : function () {
                    $("#new_comment button").attr('disabled', false);
                }
            });
        }
    }

    // 댓글 삭제
    function deleteComment(idx) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'DELETE',
            url: '/community/comment/' + idx,
            success : function (result) {
                if(result.result === "success") {
                    $("#delete_comment-modal .py-4").html('<b>삭제 완료되었습니다.</b>')
                    modalOpen("#delete_comment-modal");    
                }
            }
        });
    }

    // 댓글 신고
    function setReportedCommentInfoAndModalOpen(idx, company_idx, company_type) {
        $('#report_type').val('R'); // R: 댓글, B: 게시글
        $("#report_id").val(idx);
        $("#report_company_idx").val(company_idx);
        $("#report_company_type").val(company_type);

        $("#report-modal h3").text("댓글 신고");
        $("#report-modal p").text("해당 댓글을 신고하시겠습니까?");
        modalOpen('#report-modal');
    }

    // 게시글 삭제
    function deleteArticle(idx) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'DELETE',
            url: '/community/remove/' + idx,
            success : function (result) {
                if(result.result === "success") {
                    modalOpen("#delete_article-modal");    
                } else { 
                    location.replace('/community');
                }
            }
        });
    }

    // 게시글 신고
    function setReportedArticleInfoAndModalOpen(idx, company_idx, company_type) {
        $('#report_type').val('B'); // R: 댓글, B: 게시글
        $("#report_id").val(idx);
        $("#report_company_idx").val(company_idx);
        $("#report_company_type").val(company_type);

        $("#report-modal h3").text("게시글 신고");
        $("#report-modal p").text("해당 게시글을 신고하시겠습니까?");
        modalOpen('#report-modal');
    }

    function refreshReportedCommentInfoAndModalClose() {
        $('#report_type').val('');
        $("#report_id").val('');
        $("#report_company_idx").val('');
        $("#report_company_type").val('');
        $("#report_content").val('');

        modalClose('#report-modal');
    }


    //댓글, 게시글 신고하기
    function reportComment() {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            url: '/community/reporting',
            data : {
                contentType : $("#report_type").val(),
                reportId : $("#report_id").val(),
                companyIdx : $("#report_company_idx").val(),
                companyType : $("#report_company_type").val(),
                content : $("#report_content").val(),
            },
            success : function (result) {
                refreshReportedCommentInfoAndModalClose();
                modalOpen('#complete_report-modal');
            }
        });
    }

    // 공유하기
    $("#shareArticleBtn").on('click', function() {
        let dummy   = document.createElement("input");
        let text    = location.href;

        document.body.appendChild(dummy);
        dummy.value = text;
        dummy.select();
        document.execCommand("copy");
        document.body.removeChild(dummy);
        modalOpen('#share_article-modal');
    });

</script>
@endsection