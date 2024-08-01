@foreach ($articles as $item)
    <li><a href="{{ $item->content_type == 1 ? '/magazine/daily/detail/'.$item->idx : $item->blank_link }}">
        <div class="tit">{{ $item->title }}</div>
        <div class="desc">{!! Illuminate\Support\Str::limit(strip_tags($item->content), $limit = 140, $end = '...') !!}</div>
        <span>{{ Carbon\Carbon::parse($item->register_time)->format('Y.m.d') }}</span>
    </a></li>
@endforeach