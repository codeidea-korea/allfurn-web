@extends('layouts.app_m')

@section('content')
@include('layouts.header_m')

<div id="content">

    <section class="sub_section news_con03">
        <div class="inner">
            <div class="main_tit mb-2">
                <div class="flex items-center gap-4 justify-center">
                    <h3>가구 소식</h3>
                </div>
            </div>
            <div class="sub_desc mb-8 text-center txt-gray">국내외 가구 박람회 소식과 가구 트랜드를 보여드립니다.</div>
            <ul class="furniture_news">
                @foreach ( $articles as $item )
                    <li>
                        <div class="img_box"><a href="/magazine/furniture/detail/{{$item->idx}}">
                            @if($item->content)
                                @php
                                    $tmp = '';
                                    $pos = strpos($item->content, '<img src=', 0);
                                    
                                    if ( $pos !== false ) {
                                        
                                        $pos_from = strpos($item->content, 'https', $pos);
                                        $pos_to = strpos($item->content, '>', $pos_from);
                                        $sub = substr($item->content, $pos_from, $pos_to);
                                        $image_end = strpos($sub, '.jpg');
                                        
                                        if ($image_end) {
                                            $tmp = substr($sub, 0, $image_end + 4);
                                        } else {
                                            $image_end = strpos($sub, '.png');
                                            $tmp = substr($sub, 0, $image_end + 4);
                                        }
                                        
                                    }
                                @endphp
                                <img src="{{ $tmp ? $tmp : '' }}" alt="">
                            @endif
                        </a></div>
                        <div class="txt_box">
                            <a href="/magazine/furniture/detail/{{$item->idx}}">
                                <div class="tit">{{ $item->title }}</div>
                                <div class="desc">{!! Illuminate\Support\Str::limit(html_entity_decode(strip_tags($item->content)), $limit = 40, $end = '...') !!}</div>
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