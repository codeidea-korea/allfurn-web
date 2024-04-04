@foreach ($articles as $item)
    <li><a href="/magazine/daily/detail/{{ $item->idx }}">
        <div class="tit">{{ $item->title }}</div>
        <div class="desc">{!! Illuminate\Support\Str::limit(strip_tags($item->content), $limit = 140, $end = '...') !!}</div>
        <span>{{ Carbon\Carbon::parse($item->register_time)->format('Y.m.d') }}</span>
    </a></li>
@endforeach