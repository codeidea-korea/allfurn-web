<?php


namespace App\Service;


use App\Models\Article;
use App\Models\ArticleLike;
use App\Models\ArticleView;
use App\Models\Banner;
use App\Models\Board;
use App\Models\Order;
use App\Models\Popup;
use App\Models\Reply;
use App\Models\Report;
use App\Models\SubscribeBoard;
use App\Models\User;
use App\Models\UserSearch;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CommunityService {
    
    
    /**
     * 게시글 리스트 가져오기
     * @param array $params
     * @return array
     */
    public function getArticleList(array $params=[]): array {
        // 게시판 선택 시
        if (!empty($params['board_name']) && $params['board_name'] !== '전체') {
            $data['board_name'] = $params['board_name'];
            // 구독 여부 체크
            $board = Board::where('name', $data['board_name'])->first();
            if ($board->is_business) {
                $data['is_subscribed'] = $this->checkSubscribedBoard($data['board_name']);
            }
        }
        // 키워드 검색일 때
        if (!empty($params['keyword'])) {
            $this->getStoreSearchKeyWord($params['keyword']);
            $data['keyword'] = $params['keyword'];
        }
        // 게시글 리스트 가져오기
        $articles = $this->getArticlesDB($params);
        $data['articleTotalCount'] = $articles['count'];
        $data['articles'] = $articles['list'];

        if(isset($params['offset']) && isset($params['limit'])) {
            $data['pagination'] = paginate($params['offset'], $params['limit'], $data['articleTotalCount']);
        }

        return $data;
    }



    /**
     * 게시판 리스트 가져오기
     * @param array $params
     * @return Collection
     */
    public function getBoardList(array $params = []): Collection
    {
        $query = Board::where('is_open', 1)->where('view_access', 'like', "%".Auth::user()['type']."%");

        if (!empty($params)) {
            
            if(isset($params['isCommunity']) && $params['excludedBoardList']) {
                $query->whereNotIn('AF_board.idx', $params['excludedBoardList']);
            } else {
                foreach($params as $key => $value) {
                    $query->where($key, $value['condition'], $value['value']);
                }
            }
        }

        return $query->get();
    }

    /**
     * 게시판 배너 리스트 가져오기
     * @return Collection
     */
    public function getBannerList(): Collection
    {
        return Banner::where('ad_location', 'communitytop')
            ->where('state', 'G')
            ->where('is_delete', 0)
            ->where('is_open', 1)
            ->where('start_date', '<=', Carbon::now()->format('Y-m-d H:i:s'))
            ->where('end_date', '>=', Carbon::now()->format('Y-m-d H:i:s'))
            ->has('attachment')->get();
    }



    /**
     * 게시글 리스트 database 에서 조회하기
     * @param array $params
     * @return array
     */
    private function getArticlesDB(array $params=[]): array {
        
        $query = DB::table('AF_board_article','article')
            ->select(DB::raw("article.*, AF_board.name AS board_name, AF_board.is_anonymous
            , IF(DATE_ADD(article.register_time, INTERVAL +1 DAY) > now(),'new','') AS is_new
            , CASE WHEN TIMESTAMPDIFF(SECOND ,article.register_time, now()) < 60 THEN '방금'
                   WHEN TIMESTAMPDIFF(SECOND ,article.register_time, now()) < 3600 THEN CONCAT(FLOOR(TIMESTAMPDIFF(SECOND ,article.register_time, now())/60),'분 전')
                   WHEN TIMESTAMPDIFF(SECOND ,article.register_time, now()) < 86400 THEN CONCAT(FLOOR(TIMESTAMPDIFF(SECOND ,article.register_time, now())/3600),'시간 전')
                   ELSE DATE_FORMAT(article.register_time, '%Y.%m.%d')
              END diff_time
            , (SELECT CASE WHEN COUNT(*) >= 100000000 THEN CONCAT(COUNT(*)/100000000,'억')
                           WHEN COUNT(*) >= 10000000 THEN CONCAT(COUNT(*)/10000000,'천만')
                           WHEN COUNT(*) >= 10000 THEN CONCAT(COUNT(*)/10000, '만')
                           WHEN COUNT(*) >= 1000 THEN CONCAT(COUNT(*)/1000, '천')
                           ELSE COUNT(*) END cnt FROM AF_article_like WHERE article_idx = article.idx) AS like_count
            , (SELECT CASE WHEN COUNT(*) >= 100000000 THEN CONCAT(COUNT(*)/100000000,'억')
                           WHEN COUNT(*) >= 10000000 THEN CONCAT(COUNT(*)/10000000,'천만')
                           WHEN COUNT(*) >= 10000 THEN CONCAT(COUNT(*)/10000, '만')
                           WHEN COUNT(*) >= 1000 THEN CONCAT(COUNT(*)/1000, '천')
                           ELSE COUNT(*) END cnt FROM AF_board_views WHERE article_idx = article.idx) AS view_count
            , (SELECT CASE WHEN COUNT(*) >= 100000000 THEN CONCAT(COUNT(*)/100000000,'억')
                           WHEN COUNT(*) >= 10000000 THEN CONCAT(COUNT(*)/10000000,'천만')
                           WHEN COUNT(*) >= 10000 THEN CONCAT(COUNT(*)/10000, '만')
                           WHEN COUNT(*) >= 1000 THEN CONCAT(COUNT(*)/1000, '천')
                           ELSE COUNT(*) END cnt FROM AF_reply WHERE article_idx = article.idx AND is_delete = 0) AS reply_count
            , IF(AF_board.is_anonymous=1,'익명',
                    IF(AF_wholesale.company_name IS NOT NULL,AF_wholesale.company_name,
                        IF(AF_retail.company_name IS NOT NULL,AF_retail.company_name,AF_user.name)
                    )
             ) AS writer"))
            ->join('AF_board', 'AF_board.idx', 'article.board_idx')
            ->leftJoin('AF_user', 'AF_user.idx', 'article.user_idx')
            ->leftJoin('AF_admin', 'AF_admin.idx', 'article.admin_idx')
            ->leftJoin('AF_wholesale', function($query) {
                $query->on('AF_wholesale.idx', 'AF_user.company_idx')->where('AF_user.type', 'W');
            })
            ->leftJoin('AF_retail', function($query) {
                $query->on('AF_retail.idx', 'AF_user.company_idx')->where('AF_user.type', 'R');
            })
            ->where('AF_board.view_access', 'like', "%".Auth::user()['type']."%")
            ->where('article.is_delete', 0)
            ->where('AF_board.is_open', 1);

            if(isset($params['isCommunity']) && $params['excludedBoardList']) {
                $query->whereNotIn('AF_board.idx', $params['excludedBoardList']);
            }

            $query->orderBy('article.register_time','DESC');
            
            
        // 키워드 검색 시
        if (isset($params['keyword']) && !empty($params['keyword'])) {
            $keyword = $params['keyword'];
            $query->where(function($query) use($keyword) {
                $query->where('AF_user.name','like',"%{$keyword}%")
                    ->orWhere('AF_wholesale.company_name','like',"%{$keyword}%")
                    ->orWhere('AF_retail.company_name','like',"%{$keyword}%")
                    ->orWhere('article.title','like',"%{$keyword}%");
            });
        }
        
        
        // 게시글명으로 검색 시
        if (isset($params['board_name']) && !empty($params['board_name'])) {
            $boardName = $params['board_name'];
            $query->where('AF_board.name', $boardName);
        }
        
        
        // 내가 작성한 글 찾기
        if (isset($params['user_idx']) && !empty($params['user_idx'])) {
            $query->where('article.user_idx', $params['user_idx']);
        } else {
            $query->where('article.is_open', 1);
        }
        
        
        // 좋아요한 글 찾기
        if (isset($params['likes']) && !empty($params['likes'])) {
            $query->join('AF_article_like', 'AF_article_like.article_idx', 'article.idx')
                ->where('AF_article_like.user_idx', Auth::user()['idx']);
        }

        $count = $query->count();

        if(isset($params['offset']) && isset($params['limit'])) {
            $offset = $params['offset'] > 1 ? ($params['offset']-1) * $params['limit'] : 0;
            $limit = $params['limit'];
            $query->offset($offset)->limit($limit);
        }

        $list = $query->get();
        
        return ['count' => $count, 'list' => $list];
    }

    /**
     * 키워드 검색 - 같은 키워드 검색 시 기존에 검색된 키워드를 삭제하고 최근 검색어로 저장
     * @param string $keyword
     */
    public function getStoreSearchKeyWord(string $keyword)
    {
        if (Auth::check()) {
            $duplicateSearchKeyword = UserSearch::where('user_idx', Auth::user()['idx'])
                ->where('type','C')->where('keyword', $keyword)->first();
            // 중복된 키워드 삭제
            if (isset($duplicateSearchKeyword['idx'])) {
                $this->deleteSearchKeyword($duplicateSearchKeyword['idx']);
            }
            // 검색 키워드 저장
            $userSearch = new UserSearch;
            $userSearch->user_idx = Auth::user()['idx'];
            $userSearch->type = 'C';
            $userSearch->keyword = $keyword;
            $userSearch->save();
        }
    }

    /**
     * 키워드 검색 리스트 가져오기
     * @return Collection UserSearch
     */
    public function getSearchList(): Collection
    {
        if (Auth::check()) {
            // 키워드 검색 리스트 가져오기
            return UserSearch::where('user_idx', Auth::user()['idx'])
                ->where('type', 'C')
                ->orderBy('register_time','desc')
                ->limit(5)
                ->get();
        }
        return collect(null);
    }

    /**
     * 키워드 검색어 삭제
     * @param string $idx 키워드 검색의 고유키
     */
    public function deleteSearchKeyword(string $idx)
    {
        if ($idx === 'all' && Auth::check()) {
            UserSearch::where('user_idx', Auth::user()['idx'])->where('type','C')->delete();
        } else if (Auth::check()){
            UserSearch::find($idx)->delete();
        }
    }

    /**
     * 구독 여부 확인
     * @param string $boardName 게시판명
     * @return bool
     */
    public function checkSubscribedBoard(string $boardName): bool
    {
        if (Auth::check()) {
            $isSubscribed = SubscribeBoard::where('user_idx', Auth::user()['idx'])
                ->whereHas('board', function($query) use($boardName) {
                    $query->where('name', $boardName);
                })->count();
            return $isSubscribed > 0;
        }
        return false;
    }

    /**
     * 구독하기/구독취소 하기
     * @param string $boardName
     * @return string[]
     */
    public function subscribeBoard(string $boardName): array
    {
        if (Auth::check()) {
            $board = Board::where('name', $boardName)->first();
            $isSubscribe = SubscribeBoard::where('user_idx', Auth::user()['idx'])
                ->where('board_idx', $board['idx'])->first();
            if (isset($isSubscribe['idx'])) {
                SubscribeBoard::where('idx', $isSubscribe['idx'])->delete();
                return [
                    'result' => 'success',
                    'code' => 'DEL_SUBSCRIBE',
                    'message' => ''
                ];
            } else {
                $subscribe = new SubscribeBoard;
                $subscribe->user_idx = Auth::user()['idx'];
                $subscribe->board_idx = $board['idx'];
                $subscribe->save();
                return [
                    'result' => 'success',
                    'code' => 'REG_SUBSCRIBE',
                    'message' => ''
                ];
            }
        }
        return [
            'result' => 'fail',
            'code' => 'NO_LOGIN',
            'message' => '로그인이 필요합니다.'
        ];
    }

    /**
     * 게시글 상세 가져오기
     * @param int $idx
     * @return mixed
     */
    public function getArticleDetail(int $idx)
    {
        return Article::where('AF_board_article.idx', $idx)
            ->where('AF_board_article.is_delete', 0)
            ->join('AF_board', 'AF_board.idx', 'AF_board_article.board_idx')
            ->leftJoin('AF_user', 'AF_user.idx', 'AF_board_article.user_idx')
            ->leftJoin('AF_admin', 'AF_admin.idx', 'AF_board_article.admin_idx')
            ->leftJoin('AF_wholesale', function($query) {
                $query->on('AF_wholesale.idx', 'AF_user.company_idx')->where('AF_user.type', 'W');
            })
            ->leftJoin('AF_retail', function($query) {
                $query->on('AF_retail.idx', 'AF_user.company_idx')->where('AF_user.type', 'R');
            })
            ->select('AF_board_article.*','AF_user.name AS user_name', 'AF_board.name AS board_name',
                DB::raw('IF(AF_board.is_anonymous=1,"익명",
                    IF(AF_wholesale.company_name IS NOT NULL,AF_wholesale.company_name,
                        IF(AF_retail.company_name IS NOT NULL,AF_retail.company_name,AF_user.name)
                    )
                 ) AS writer, AF_user.company_idx, AF_user.type AS company_type'))
            ->withCount('like')->withCount('view')->first($idx);
    }

    /**
     * 게시글 조회수 up
     * @param int $articleIdx
     */
    public function updateArticleView(int $articleIdx)
    {
        if (Auth::check()) {
            $articleView = new ArticleView;
            $articleView->user_idx = Auth::user()['idx'];
            $articleView->article_idx = $articleIdx;
            $articleView->save();
        }
    }

    /**
     * 게시글 좋아요/좋아요취소 클릭
     * @param int $articleIdx
     * @return string[]
     */
    public function toggleArticleLike(int $articleIdx): array
    {
        if (Auth::check()) {
            $articleLike = ArticleLike::where('article_idx', $articleIdx)->where('user_idx', Auth::user()['idx'])->first();
            if (isset($articleLike['idx'])) {
                ArticleLike::where('idx', $articleLike['idx'])->delete();
                return [
                    'result' => 'success',
                    'code' => 'DOWN',
                    'message' => ''
                ];
            } else {
                $article = new ArticleLike;
                $article->user_idx = Auth::user()['idx'];
                $article->article_idx = $articleIdx;
                $article->save();
                return [
                    'result' => 'success',
                    'code' => 'UP',
                    'message' => ''
                ];
            }
        }
        return [
            'result' => 'fail',
            'code' => 'ERR',
            'message' => '로그인이 필요합니다.'
        ];
    }

    /**
     * 게시물 이미지 업로드
     * @param $image
     * @return string
     */
    public function uploadImage($image): string
    {
        $stored = Storage::disk('s3')->put('articles', $image);
        $explodeFileName = explode('/',$stored);
        $fileName = end($explodeFileName);
        $file = preImgUrl() . 'articles/' . $fileName;
        return asset($file);
    }

    /**
     * 이미지 삭제
     * @param $imageUrl
     * @return array
     */
    public function deleteImage($imageUrl): array
    {
        $explodeImage = explode('/', $imageUrl);
        $fileName = end($explodeImage);
        Storage::disk('s3')->delete('articles/'.$fileName);
        return [
            'result' => 'success',
            'message' => ''
        ];
    }

    /**
     * 게시글 생성
     * @param $params
     * @return array
     */
    public function registerArticle($params): array
    {
        if (Auth::check()) {
            $firstImage = "";
            if (isset($params['firstImage']) && !empty($params['firstImage'])) {
                $explode = explode('/', $params['firstImage']);
                $firstImage = end($explode);
            }
            $article = new Article;
            $article->user_idx = Auth::user()['idx'];
            $article->board_idx = $params['selectBoard'];
            $article->title = $params['boardTitle'];
            $article->content = $params['editor_content'];
            $article->is_open = 1;
            $article->first_image = $firstImage;
            $article->save();

            $subscribed = SubscribeBoard::where('board_idx', $params['selectBoard'])->get();
            $alarmService = new AlarmService();
            $board = Board::find($params['selectBoard']);
            $alarmParams = [
                'depth1' => 'active',
                'depth2' => 'article',
                'depth3' => 'subscribe',
                'variables' => [$board->name],
                'link_url' => '/community?board_name='.$board->name,
            ];
            foreach($subscribed as $subs) {
                $user = User::find($subs->user_idx);
                $alarmParams['target_company_idx'] = $user->company_idx;
                $alarmParams['target_company_type'] = $user->type;
                $alarmService->sendAlarm($alarmParams);
            }
        }
        return [
            'result' => 'success',
            'message' => ''
        ];
    }

    /**
     * 게시글 수정
     * @param $params
     * @return array
     */
    public function modifyArticle($params): array
    {
        if (Auth::check())
        {
            $firstImage = "";
            if (isset($params['firstImage']) && !empty($params['firstImage'])) {
                $explode = explode('/', $params['firstImage']);
                $firstImage = end($explode);
            }
            $article = Article::where('idx', $params['articleIdx'])->where('user_idx', Auth::user()['idx'])->first();
            $article->title = $params['boardTitle'];
            $article->content = $params['editor_content'];
            $article->update_time = Carbon::now()->format('Y-m-d H:i:s');
            $article->first_image = $firstImage;
            $article->save();
        }
        return [
            'result' => 'success',
            'message' => ''
        ];
    }

    /**
     * 게시글 작성 시 제목, 내용에 금지어 사용 여부 체크
     * @param $params
     * @return bool
     */
    public function checkBannedWords($params): bool
    {
        $boardIdx = $params['selectBoard'];
        $boardTitle = $params['boardTitle'];
        $content = $params['editor_content'];
        $board = Board::find($boardIdx);
        $bannedWords = str_replace(',', '|', trim($board->ban_word,','));
        if ($bannedWords) {
            preg_match("/{$bannedWords}/i", $boardTitle, $titleMatch);
            preg_match("/{$bannedWords}/i", $content, $contentMatch);
            return count($titleMatch) > 0 || count($contentMatch) > 0;
        }
        return false;
    }

    /**
     * 게시글 답변 작성
     * @param $params
     * @return array
     */
    public function writeReply($params): array
    {
        $content = $params['replyComment'];
        $article_idx = $params['articleId'];
        $parent_idx = isset($params['parentId']) ? $params['parentId'] : null;
        if (Auth::check()) {
            $reply = new Reply;
            $reply->user_idx = Auth::user()['idx'];
            $reply->article_idx = $article_idx;
            $reply->depth = ($parent_idx ? 2 : 1);
            $reply->content = $content;
            $reply->is_delete = 0;
            if ($parent_idx) {
                $reply->parent_idx = $parent_idx;
            }
            $reply->save();

            $alarmService = new AlarmService();
            $alarmParams = [
                'depth1' => 'active',
                'depth2' => 'article',
            ];
            if ($parent_idx) {
                $alarmParams['depth3'] = 'RE_REPLY';
                $re_reply = Reply::find($parent_idx);
                $user = User::find($re_reply->user_idx);
                if ($re_reply->user_idx != Auth::user()['idx']) {
                    $alarmParams['target_company_idx'] = $user->company_idx;
                    $alarmParams['target_company_type'] = $user->type;
                    $alarmParams['link_url'] = '/community/detail/' . $re_reply->article_idx;
                    $alarmService->sendAlarm($alarmParams);
                }
            } else {
                $alarmParams['depth3'] = 'REPLY';
                $article = Article::find($article_idx);
                $user = User::find($article->user_idx);
                if ($article->user_idx != Auth::user()['idx']) {
                    $alarmParams['target_company_idx'] = $user->company_idx;
                    $alarmParams['target_company_type'] = $user->type;
                    $alarmParams['link_url'] = '/community/detail/' . $article->idx;
                    $alarmService->sendAlarm($alarmParams);
                }
            }
        }
        return [
            'result' => 'success',
            'message' => ''
        ];
    }

    /**
     * 게시글 삭제
     * @param $idx
     * @return array
     */
    public function removeArticle($idx): array
    {
        if (Auth::check()) {
            $article = Article::where('idx', $idx)->where('user_idx', Auth::user()['idx'])->first();
            $article->is_open = 0;
            $article->is_delete = 1;
            $article->update_time = Carbon::now()->format('Y-m-d H:i:s');
            $article->save();
        }
        return [
            'result' => 'success',
            'message' => ''
        ];
    }

    /**
     * 댓글 삭제
     * @param $idx
     * @return array
     */
    public function removeComment($idx): array
    {
        if (Auth::check()) {
            $article = Reply::where('idx', $idx)->where('user_idx', Auth::user()['idx'])->first();
            if ($article->depth == 1) {
                // 대댓글 모두 삭제 처리
                Reply::where('depth', 2)->where('parent_idx', $idx)->update(['is_delete' => 1]);
            }
            $article->is_delete = 1;
            $article->save();

        }
        return [
            'result' => 'success',
            'message' => ''
        ];
    }

    /**
     * 게시글 댓글 가져오기
     * @param $idx
     * @return array
     */
    public function getArticleComments($idx): array
    {
        $firstDepthComments = Reply::where('AF_reply.article_idx', $idx)
            ->where('AF_reply.depth', 1)->where('AF_reply.is_delete', 0)
            ->orderBy('AF_reply.register_time','desc')
            ->orderBy( 'AF_reply.idx', 'desc')
            ->join('AF_board_article', 'AF_board_article.idx', 'AF_reply.article_idx')
            ->join('AF_board', 'AF_board.idx', 'AF_board_article.board_idx')
            ->join('AF_user', 'AF_user.idx', 'AF_reply.user_idx')
            ->leftJoin('AF_wholesale', function($query) {
                $query->on('AF_wholesale.idx', 'AF_user.company_idx')->where('AF_user.type', 'W');
            })
            ->leftJoin('AF_retail', function($query) {
                $query->on('AF_retail.idx', 'AF_user.company_idx')->where('AF_user.type', 'R');
            })
            ->select('AF_reply.*', 'AF_board.is_secret_reply',
                DB::raw("CASE WHEN TIMESTAMPDIFF(SECOND ,AF_reply.register_time, now()) < 60 THEN '방금'
                   WHEN TIMESTAMPDIFF(SECOND ,AF_reply.register_time, now()) < 3600 THEN CONCAT(FLOOR(TIMESTAMPDIFF(SECOND ,AF_reply.register_time, now())/60),'분 전')
                   WHEN TIMESTAMPDIFF(SECOND ,AF_reply.register_time, now()) < 86400 THEN CONCAT(FLOOR(TIMESTAMPDIFF(SECOND ,AF_reply.register_time, now())/3600),'시간 전')
                   ELSE DATE_FORMAT(AF_reply.register_time, '%Y.%m.%d')
              END diff_time
              , IF(AF_board.is_anonymous=1,'익명',
                    IF(AF_wholesale.company_name IS NOT NULL,AF_wholesale.company_name,
                        IF(AF_retail.company_name IS NOT NULL,AF_retail.company_name,AF_user.name)
                    )
                 ) AS writer,AF_user.company_idx, AF_user.type AS company_type"))
            ->get();
        $secondDepthComments = Reply::from('AF_reply as reply')->where('reply.article_idx', $idx)
            ->where('reply.depth', 2)->where('reply.is_delete', 0)
            ->orderBy('reply.register_time','desc')
            ->orderBy('reply.idx', 'desc')
            ->join('AF_board_article', 'AF_board_article.idx', 'reply.article_idx')
            ->join('AF_board', 'AF_board.idx', 'AF_board_article.board_idx')
            ->join('AF_user', 'AF_user.idx', 'reply.user_idx')
            ->leftJoin('AF_wholesale', function($query) {
                $query->on('AF_wholesale.idx', 'AF_user.company_idx')->where('AF_user.type', 'W');
            })
            ->leftJoin('AF_retail', function($query) {
                $query->on('AF_retail.idx', 'AF_user.company_idx')->where('AF_user.type', 'R');
            })
            ->select('reply.*', 'AF_board.is_secret_reply',
                DB::raw("CASE WHEN TIMESTAMPDIFF(SECOND ,reply.register_time, now()) < 60 THEN '방금'
                   WHEN TIMESTAMPDIFF(SECOND ,reply.register_time, now()) < 3600 THEN CONCAT(FLOOR(TIMESTAMPDIFF(SECOND ,reply.register_time, now())/60),'분 전')
                   WHEN TIMESTAMPDIFF(SECOND ,reply.register_time, now()) < 86400 THEN CONCAT(FLOOR(TIMESTAMPDIFF(SECOND ,reply.register_time, now())/3600),'시간 전')
                   ELSE DATE_FORMAT(reply.register_time, '%Y.%m.%d')
              END diff_time
              , IF(AF_board.is_anonymous=1,'익명',
                    IF(AF_wholesale.company_name IS NOT NULL,AF_wholesale.company_name,
                        IF(AF_retail.company_name IS NOT NULL,AF_retail.company_name,AF_user.name)
                    )
                 ) AS writer, (SELECT user_idx FROM AF_reply WHERE idx = reply.parent_idx) AS parent_user_idx,AF_user.company_idx, AF_user.type AS company_type "))
            ->get();
        $comments = [];
        $firstComments = $firstDepthComments->toArray();
        $secondComments = $secondDepthComments->toArray();
        foreach($firstComments as $firstComment) {
            array_push($comments, $firstComment);
            $arr = array_filter($secondComments, function($secondComment) use($firstComment) {
                return $secondComment['parent_idx'] == $firstComment['idx'];
            });
            $comments = array_merge($comments, $arr);
        }
        return $comments;
    }

    /**
     * 게시글, 댓글 신고하기
     * @param $params
     * @return array
     */
    public function reporting($params): array
    {
        $report = new Report;
        $report->report_type = $params['contentType']; // A: 게시글(article), AC: 댓글(article comment)
        $report->target_idx = $params['reportId'];
        $report->reason = $params['content'];
        $report->state = 1; // 미처리
        $report->user_idx = Auth::user()['idx'];
        $report->target_company_idx = $params['companyIdx'];
        $report->target_company_type = $params['companyType'];
        $report->save();
        return [
            'result' => 'success',
            'message' => ''
        ];
    }

    /**
     * 내가 작성한 댓글 리스트 가져오기
     * @param $params
     * @return array
     */
    public function getMyComments($params): array
    {
        if (Auth::check()) {
            $offset = $params['offset'] > 1 ? ($params['offset']-1) * $params['limit'] : 0;
            $limit = $params['limit'];

            $where = "";
            // 게시판 선택 시
            if (!empty($params['board_name']) && $params['board_name'] !== '전체') {
                $where .= " AND board.name = '{$params['board_name']}'";
            }
            $rawQuery = "SELECT * FROM
                        (SELECT reply.*, article.title AS article_title, board.name AS board_name, '' AS reply_content
                            , CASE WHEN TIMESTAMPDIFF(SECOND ,reply.register_time, now()) < 60 THEN '방금'
                                   WHEN TIMESTAMPDIFF(SECOND ,reply.register_time, now()) < 3600 THEN CONCAT(FLOOR(TIMESTAMPDIFF(SECOND ,reply.register_time, now())/60),'분 전')
                                   WHEN TIMESTAMPDIFF(SECOND ,reply.register_time, now()) < 86400 THEN CONCAT(FLOOR(TIMESTAMPDIFF(SECOND ,reply.register_time, now())/3600),'시간 전')
                                   ELSE DATE_FORMAT(reply.register_time, '%Y.%m.%d')
                              END diff_time
                         FROM AF_reply AS reply
                         INNER JOIN AF_board_article AS article ON article.idx = reply.article_idx
                         INNER JOIN AF_board AS board ON board.idx = article.board_idx AND board.view_access LIKE '%".Auth::user()['type']."%' {$where}
                         WHERE reply.user_idx = ".Auth::user()['idx']." AND reply.depth = 1 AND reply.is_delete = 0
                         UNION
                         SELECT comment.*, article.title AS article_title, board.name AS board_name, reply.content AS reply_content
                            , CASE WHEN TIMESTAMPDIFF(SECOND ,comment.register_time, now()) < 60 THEN '방금'
                                   WHEN TIMESTAMPDIFF(SECOND ,comment.register_time, now()) < 3600 THEN CONCAT(FLOOR(TIMESTAMPDIFF(SECOND ,comment.register_time, now())/60),'분 전')
                                   WHEN TIMESTAMPDIFF(SECOND ,comment.register_time, now()) < 86400 THEN CONCAT(FLOOR(TIMESTAMPDIFF(SECOND ,comment.register_time, now())/3600),'시간 전')
                                   ELSE DATE_FORMAT(comment.register_time, '%Y.%m.%d')
                              END diff_time
                         FROM AF_reply AS comment
                         INNER JOIN AF_reply AS reply ON reply.idx = comment.parent_idx
                         INNER JOIN AF_board_article AS article ON article.idx = reply.article_idx
                         INNER JOIN AF_board AS board ON board.idx = article.board_idx AND board.view_access = '%".Auth::user()['type']."%' {$where}
                         WHERE comment.user_idx = ".Auth::user()['idx']." AND comment.depth = 2 AND comment.is_delete = 0
                        ) AS reply
                        ORDER BY reply.register_time DESC";
            $result = DB::select($rawQuery);
            $data['commentTotalCount'] = count($result);
            $data['comments'] = DB::select($rawQuery . " LIMIT {$offset}, {$limit}");
            $data['pagination'] = paginate($params['offset'], $params['limit'], $data['commentTotalCount']);
            return $data;
        }
        return [];
    }

    /**
     * 배차신청 시 게시글에 자동으로 들어갈 주문 정보
     * @param string $orderGroupCode
     * @return mixed
     */
    public function getDispatchOrders(string $orderGroupCode)
    {
        return Order::where('order_group_code', $orderGroupCode)
            ->select(DB::raw(
         'GROUP_CONCAT(AF_product.name) AS products,
                IF(COUNT(*) > 1,
                    CONCAT(AF_product.name," 외",(COUNT(*)-1),"건"),
                    AF_product.name) AS product_name,
                IF(AF_wholesale.idx IS NOT NULL,
                    CONCAT(AF_wholesale.business_address, " ",COALESCE(AF_wholesale.business_address_detail, "")),
                    CONCAT(AF_retail.business_address, " ",COALESCE(AF_retail.business_address_detail,""))) AS delivery'))
            ->join('AF_product', 'AF_product.idx', 'AF_order.product_idx')
            ->leftJoin('AF_wholesale', function($query) {
                $query->on('AF_wholesale.idx', 'AF_product.company_idx')->where('AF_product.company_type', 'W');
            })
            ->leftJoin('AF_retail', function($query) {
                $query->on('AF_retail.idx', 'AF_product.company_idx')->where('AF_product.company_type', 'R');
            })
            ->groupBy('order_group_code')
            ->first();
    }

    public function popupList()
    {
        return Popup::select('AF_popup.*',
            DB::raw('CONCAT("'.preImgUrl().'", at.folder, "/", at.filename) as imgUrl'),
            DB::raw("CASE WHEN web_link_type = 1 THEN CONCAT('" .config('constants.POPUP.TYPE.PRODUCT'). "',web_link)
                                WHEN web_link_type = 2 THEN CONCAT('" .config('constants.POPUP.TYPE.WHOLESALE'). "',web_link)
                                WHEN web_link_type = 3 THEN CONCAT('" .config('constants.POPUP.TYPE.COMMUNITY'). "',web_link)
                                WHEN web_link_type = 4 THEN '" .config('constants.POPUP.TYPE.NOTICE'). "'
                                ELSE web_link END AS web_type_link"))
            ->leftjoin('AF_attachment as at', function ($query) {
                $query->on('at.idx', 'AF_popup.attachment_idx');
            })
            ->where('location', 'community')
            ->where('start_date', '<', DB::raw('now()'))
            ->where('end_date', '>', DB::raw('now()'))
            ->where('is_delete', 0)
            ->where('is_open', 1)
            ->orderBy('order_idx')
            ->get();
    }

}
