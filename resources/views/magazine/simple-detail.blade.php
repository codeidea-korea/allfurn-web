@extends('layouts.app')

@section('content')
@include('layouts.header')


<div id="content">
    <section class="sub_section_bot community_detail">
        <div class="inner">
            <div class="title">
                <div class="tag">
                    <span>{{$article->category_list}}</span>
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
    $('.comment_list .recomm_btn').on('click',function(){
        $(this).next('.recomm_form').toggleClass('active')
    })

    $('.comment_list .comment_cancel').on('click',function(){
        $(this).parents('.recomm_form').toggleClass('active')
    })

    $(".comment_form input").on('keyup', function() {
        if($(this).val().length == 0) {    
            $(this).nextAll('button.btn-primary').attr('disabled', true);
        } else {
            $(this).nextAll('button.btn-primary').attr('disabled', false);
        }
    });

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