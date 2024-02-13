@if(count($articles) < 1)
    <div class="community-content">
        <div class="community-content--nodata">
      <span>
        <i class="ico__search--white"></i>
      </span>
            @if(isset($keyword))
                <p>"{{$keyword}}" 에 대한 검색 결과가 없습니다.</p>
            @else
                <p>게시글이 없습니다.</p>
            @endif
        </div>
    </div>
@else
    <div class="community-content">
        <p class="community-content__title">{{ isset($board_name) ? $board_name : '전체' }}</p>
        @if(isset($keyword))
            <p class="community-content__sub-title">"{{$keyword}}" 검색 결과 총 {{$articleTotalCount}}개의 게시글</p>
        @endif
        @if(isset($is_subscribed))
            <button type="button" id="subscribe_button" class="button button--round button--blank-gray community-content__subscribe {{ $is_subscribed ? 'active' : '' }}" style="height: 34px;" onclick="toggleSubscribeBoard('{{$board_name}}')">
                @if($is_subscribed)
                    <i class="ico__community-arrow"></i>
                    <span>구독중</span>
                @else
                    <i class="ico__community-arrow--active"></i>
                    <span>구독하기</span>
                @endif
            </button>
        @endif

        @foreach($articles as $article)
            <div class="community-content__item community-content__item--modify">
                <div class="community-content__container" data-article-id="{{$article->idx}}">
                    <div class="community-content__content">
                        <div class="community-content__type">
                            <p class="tag__color">{{$article->board_name}}</p>
                            @if($article->type === 'N')
                                <p>공지</p>
                            @elseif($article->type === 'A')
                                <p>광고</p>
                            @endif
                        </div>
                        <div class="community-content__desc">
                            <p>{{$article->title}}
                                @if($article->is_new)
                                    <span class="badge__new"></span>
                                @endif
                            </p>
                        </div>
                        <div class="community-content__writer">
                            <p>
                                {{ $article->is_admin ? '관리자' : $article->writer }}
                            </p>
                        </div>
                    </div>
                    @if($article->content)
                    
                        @php
                        
                            $tmp = '';
                        
                            $pos = strpos($article->content, '<img src=', 0);
                            
                            if ( $pos !== false ) {
                                
                                $pos_from = strpos($article->content, 'https', $pos);
                                
                                $pos_to = strpos($article->content, '>', $pos_from);
                                
                                $sub = substr($article->content, $pos_from, $pos_to);
                            
                                $image_end = strpos($sub, '.jpg');
                                
                                if ($image_end) {
                                    
                                    $tmp = substr($sub, 0, $image_end + 4);
                            
                                } else {
                                    
                                    $image_end = strpos($sub, '.png');
                                    
                                    $tmp = substr($sub, 0, $image_end + 4);
                                 
                                }
                                
                            }
                            
                        @endphp
                        
                        @if($tmp != '')    
                    
                            <img class="community-content__image" src="{{ $tmp }}" />
                            
                        @endif
                        
                    @endif
                </div>
                <div class="community-content__info">
                    <div class="community-content__utils">
                        <div class="community-content__util community-content__watch ">
                            <p><i class="ico__viewcnt"></i> {{$article->view_count}}</p>
                        </div>
                        <a href="#" class="community-content__util community-content__like">
                            <p><i class="ico__like"></i> {{$article->like_count}}</p>
                        </a>
                        <a href="#" class="community-content__util community-content__count">
                            <p><i class="ico__reply"></i> {{$article->reply_count}}</p>
                        </a>
                    </div>
                    <p class="community-content__time">{{$article->diff_time}}</p>
                </div>
            </div>
        @endforeach

        <div class="pagenation">
            @if($pagination['prev'] > 0)
                <button type="button" class="prev" id="prev-paginate" onclick="getArticlesForPage({{$pagination['prev']}})">
                    <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 1L1 6L6 11" stroke="#828282" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            @endif
            <div class="numbering">
                @foreach($pagination['pages'] as $paginate)
                    @if ($paginate == $offset)
                        <a href="javascript:void(0)" onclick="getArticlesForPage({{$paginate}})" class="numbering--active">{{$paginate}}</a>
                    @else
                        <a href="javascript:void(0)" onclick="getArticlesForPage({{$paginate}})">{{$paginate}}</a>
                    @endif
                @endforeach
            </div>
            @if($pagination['next'] > 0)
                <button type="button" class="next" id="next-paginate" onclick="getArticlesForPage({{$pagination['next']}})">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12L10 7L5 2" stroke="#828282" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            @endif
        </div>
    </div>
    
    <script>
        const toggleSubscribeBoard = boardName => {
            fetch('/community/subscribe/board', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: JSON.stringify({
                    boardName: boardName
                })
            }).then(response => {
                return response.json();
            }).then(json => {
                if (json.result === 'success') {
                    switch(json.code) {
                        case 'DEL_SUBSCRIBE':
                            document.querySelector('#subscribe_button span').textContent = '구독하기';
                            document.getElementById('subscribe_button').classList.remove('active');
                            break;
                        case 'REG_SUBSCRIBE':
                            document.querySelector('#subscribe_button span').textContent = '구독중';
                            document.getElementById('subscribe_button').classList.add('active');
                            break;
                    }
                } else {
                    alert(json.message);
                }
            })
        }
        const getArticlesForPage = page => {
            let bodies = {offset:page};
            const urlSearch = new URLSearchParams(location.search);
            if (urlSearch.get('keyword')) bodies.keyword = urlSearch.get('keyword');
            if (urlSearch.get('board_name')) bodies.board_name = urlSearch.get('board_name');
            location.replace("/community?" + new URLSearchParams(bodies));
        }

        // 게시글로 이동
        const articles = document.querySelectorAll('.community-content__container');
        articles.forEach(article => {
            article.addEventListener('click', evt => {
                const idx = evt.currentTarget.dataset.articleId;
                location.href='/community/detail/' + idx;
            });
        })
    </script>
    
    
@endempty


