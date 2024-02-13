<div class="content">
    <div class="content__item">
        <div class="accordion">
            @foreach($list as $row)
            <h3 class="accordion__head">
                <p>{{ $row->title }}</p>
                <span class="content__item-meta">{{ date('Y.m.d', strtotime($row->register_time)) }}</span>
            </h3>
            <div>{!! $row->content !!}</div>
            @endforeach
        </div>

        <div class="pagenation">
            @if($pagination['prev'] > 0)
                <button type="button" class="prev" onclick="moveToList({{$pagination['prev']}})">
                    <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 1L1 6L6 11" stroke="#DBDBDB" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            @endif
            <div class="numbering">
                @foreach($pagination['pages'] as $paginate)
                    @if ($paginate == $offset)
                        <a href="javascript:void(0)" onclick="moveToList({{$paginate}})" class="numbering--active">{{$paginate}}</a>
                    @else
                        <a href="javascript:void(0)" onclick="moveToList({{$paginate}})">{{$paginate}}</a>
                    @endif
                @endforeach
            </div>
            @if($pagination['next'] > 0)
                <button type="button" class="next" onclick="moveToList({{$pagination['next']}})">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12L10 7L5 2" stroke="#828282" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            @endif
        </div>
    </div>
</div>
