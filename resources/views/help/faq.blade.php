<div class="content">
    <div class="tab" id="register-type">
        <ul class="tab__list">
            <li><button class="tab__help-categories {{ $category_idx ? '' : 'on' }}" onclick="location.href='/help/faq'">전체</button></li>
            @foreach($categories as $category)
                <li><button class="tab__help-categories {{ $category_idx == $category->idx ? 'on' : '' }}" onclick="location.href='/help/faq?category_idx={{ $category->idx }}'">{{ $category->name }}</button></li>
            @endforeach
        </ul>
        <div class="tab-content">
            <div class="tab-content__panel">
                <div class="content__item">
                    <div class="accordion">
                    @foreach($list as $row)
                        <h3 class="accordion__head"><span class="ico">Q</span><p>{{ $row->title }}</p></h3>
                        <div>
                            <span class="ico">A</span>
                            <p>{!! $row->content !!}</p>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
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
