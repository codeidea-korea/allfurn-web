@extends('layouts.app')

@section('content')
@include('layouts.header')

<div id="content">
    <section class="sub_section news_con03">
        <div class="inner">
            <div class="main_tit mb-2 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>가구 소식</h3>
                </div>
            </div>
            <div class="sub_desc mb-8">국내외 가구 박람회 소식과 가구 트랜드를 보여드립니다.</div>
            <ul class="furniture_news">
                @foreach ( $articles as $item )
                    <li>
                        {{-- TODO: 가구 소식 리스트 생성 후 이미지 URL 변경 --}}
                        <div class="img_box"><a href="/magazine/furniture/detail/{{$item->idx}}"><img src="/img/furniture_thumb.png" alt=""></a></div>
                        <div class="txt_box">
                            <a href="/magazine/furniture/detail/{{$item->idx}}">
                                <div class="tit">{{ $item->title }}</div>
                                <div class="desc">{!! Illuminate\Support\Str::limit(strip_tags($item->content), $limit = 40, $end = '...') !!}</div>
                                <span>{{ Carbon\Carbon::parse($item->register_time)->format('Y.m.d') }}</span>
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
</div>
@endsection