@extends('layouts.app_m')

@section('content')
{{-- @include('layouts.header_m') --}}

<div id="content">

    <div class="detail_mo_top">
        <div class="inner">
            <a class="back_img" href="javascript:history.back();"><svg><use xlink:href="/img/icon-defs.svg#left_arrow"></use></svg></a>
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
                    <p>{{ date('Y.m.d H:i', strtotime($article->register_time)) }}</p>
                    <p>
                        <button class="btn" id="shareArticleBtn" onclick="modalOpen('#share_article-moda')"><svg><use xlink:href="/img/icon-defs.svg#share"></use></svg></button>
                    </p>
                </div>
            </div>
            <div class="content">
                {!! $article->content !!}
            </div>
        </div>
    </section>

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
</div>
<script>
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