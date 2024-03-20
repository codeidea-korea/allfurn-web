@extends('layouts.app_m')

@section('content')
@include('layouts.header_m')

<div id="content">
    <section class="sub_section daily_news_con01">
        <div class="inner">
            <div class="title mb-4">
                <div class="search_box">
                    <input type="text" class="input-form" placeholder="글 제목이나 작성자를 검색해주세요" value="{{ $keyword ?? '' }}">
                    <button><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#news_search"></use></svg></button>
                </div>
                <h4>일일 가구 뉴스</h4>
                <p>매일 올라오는 가구관련 주요 뉴스를 보여드려요</p>
            </div>

            <ul class="news_list">
                @foreach ($articles as $item)
                    <li><a href="/magazine/daily/detail/{{ $item->idx }}">
                        <div class="tit">{{ $item->title }}</div>
                        <div class="desc">{!! Illuminate\Support\Str::limit(strip_tags($item->content), $limit = 140, $end = '...') !!}</div>
                        <span>{{ Carbon\Carbon::parse($item->register_time)->format('Y.m.d') }}</span>
                    </a></li>
                @endforeach
            </ul>
        </div>
    </section>
</div>
<script>
    $('.search_box input').keydown(function (event) {
        if(event.key === "Enter") {
            window.location.href = "/magazine/daily?keyword=" +  $(this).val();
        }
    });

    $(".search_box button").on('click', function() {
        window.location.href = "/magazine/daily?keyword=" +  $(".search_box input").val();
    });
</script>
@endsection