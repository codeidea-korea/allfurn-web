@extends('layouts.app')

@section('content')
@include('layouts.header')

<div id="content">
    <div class="coop_list">
        <div class="inner">
            <h3>가구관련 협력업체</h3>
            <ul>
                @foreach ($family as $item)
                    <li><a href="/family/{{ $item->idx }}">
                        <i><img src="{{ $item->imgUrl }}" alt=""></i>
                        <span>{{ $item->family_name }}</span>
                    </a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
