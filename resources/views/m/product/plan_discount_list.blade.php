@extends('layouts.app_m')
@php
    $only_quick = '';
    $header_depth = 'product';
    $top_title = '';
    $header_banner = '';
@endphp
@section('content')
@include('layouts.header_m')
<div id="content">
    <section class="sub">
        <div class="inner">
        <div class="main_tit mb-8 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>Best 기획전</h3>
                </div>
            </div>
            <div class="relative">
                @if( $list->count() > 0 )
                    <ul class="prod_list grid1">
                        @foreach( $list AS $l => $item )
                            <li class="prod_item type02">
                                <div class="img_box">
                                    <a href="/product/detail/{{$item->idx}}">
                                        <img src="{{$item->imgUrl}}" alt="">
                                        <span><b>{{$item->subtext1}}</b><br/>{{$item->subtext2}}</span>
                                    </a>
                                    <button class="zzim_btn prd_{{$item->idx}} {{($item->isInterest==1)?'active':''}}" pIdx="{{$item->idx}}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                                <div class="txt_box">
                                    <a href="/product/detail/{{$item->idx}}">
                                        <strong>{{$item->content}}</strong>
                                        <span>{{$item->company_name}}</span>
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection