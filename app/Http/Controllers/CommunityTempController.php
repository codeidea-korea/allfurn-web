<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Service\CommunityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommunityTempController extends BaseController
{
    private $communityService;
    private $limit;
    public function __construct(CommunityService $communityService)
    {
        $this->communityService = $communityService;
        // 페이지네이션 가져올 개수
        $this->limit = 20;
    }

    public function index(Request $request)
    {
        //제외되야 하는 카테고리
        $params['isCommunity'] = true;
        $params['excludedBoardList'] = [12,22]; // 일일 가구 뉴스, 가구 소식

        $params['keyword'] = preg_replace('/\%\"/i','',$request->input('keyword'));
        $params['board_name'] = preg_replace('/전체/', '',$request->input('board_name'));
        $params['offset'] = $data['offset'] = $request->input('offset') ?: 1;
        $params['limit'] = $this->limit;

        // 게시판 상단 배너
        $data['banners'] = $this->communityService->getBannerList('communitytop');
        // lnb 게시판 리스트
        $data['boards'] = $this->communityService->getBoardList($params);
        // 전체 게시판 리스트
        $data = array_merge($this->communityService->getArticleList($params), $data);
        // 검색어 리스트
        $data['searches'] = $this->communityService->getSearchList();
        $data['popup'] = $this->communityService->popupList();
        return view(getDeviceType().'community.community', $data);
    }

    /**
     * 검색 키워드 리스트 보기
     * @return View
     */
    public function getSearchKeywordList(): View
    {
        $data['searches'] = $this->communityService->getSearchList();
        return view('community.search-list', $data);
    }

    /**
     * 게시판 구독/구독취소
     * @param Request $request
     * @return JsonResponse
     */
    public function subscribeBoard(Request $request): JsonResponse
    {
        $boardName = $request->input('boardName');
        return response()->json($this->communityService->subscribeBoard($boardName));
    }

    /**
     * 검색 키워드 삭제
     * @param string $idx
     * @return JsonResponse
     */
    public function deleteSearchKeyword(string $idx): JsonResponse
    {
        $this->communityService->deleteSearchKeyword($idx);
        return response()->json([
            'result' => 'success',
            'message' => '삭제되었습니다.'
        ]);
    }

    /**
     * 게시글 상세 보기
     * @param int $idx
     * @return View
     */
    public function detail(int $idx): View
    {
        // 게시판 상단 배너
        $data['banners'] = $this->communityService->getBannerList('communitytop');
        // lnb 게시판 리스트
        $data['boards'] = $this->communityService->getBoardList();
        $data['searches'] = $this->communityService->getSearchList();
        // 게시글 조회 +1
        $this->communityService->updateArticleView($idx);
        $data['article'] = $this->communityService->getArticleDetail($idx);
        $data['articleId'] = $idx;

        // 댓글 가져오기
        $data['comments'] = $data['article'] ? $this->communityService->getArticleComments($idx) : [];
        return view(getDeviceType().'community.detail', $data);
    }

    /**
     * 좋아요/좋아요취소 토글
     * @param Request $request
     * @return JsonResponse
     */
    public function toggleArticleLike(Request $request): JsonResponse
    {
        $idx = $request->input('articleId');
        return response()->json($this->communityService->toggleArticleLike($idx));
    }

    /**
     * 게시글 작성 페이지
     * @param int|null $idx
     * @return View
     */
    public function write(int $idx = null): View
    {
        $data['idx'] = $idx; // idx 가 있으면 수정 없으면 등록
        $boardsWhere = [
            'write_access' => ['condition' => 'like', 'value' => "%".Auth::user()['type']."%"],
            'isCommunity'=> true,
            'excludedBoardList' => [12,22], // 일일 가구 뉴스, 가구 소식
        ];
        $data['boards'] = $this->communityService->getBoardList($boardsWhere);
        if ($data['idx']) {
            $data['detail'] = $this->communityService->getArticleDetail($idx);
        }
        return view(getDeviceType().'community.write', $data);
    }

    /**
     * 이미지 생성
     * @param Request $request
     * @return Response
     */
    public function uploadImage(Request $request): Response
    {
        $request->validate([
            'images' => 'image|mimes:png,jpg,jpeg|max:2048'
        ]);
        return response($this->communityService->uploadImage($request->file('images')), 200);
    }

    /**
     * 이미지 삭제
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteImage(Request $request): JsonResponse
    {
        $imageUrl = $request->input('imageUrl');
        return response()->json($this->communityService->deleteImage($imageUrl));
    }

    /**
     * 게시글 생성
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        if ($this->communityService->checkBannedWords($request->all())) {
            return response()->json([
               'result' => 'fail',
               'code' => 'USE_BANNED_WORDS',
               'message' => '해당 게시판에 금지어를 사용하여 등록할 수 없습니다.'
            ]);
        }
        return response()->json($this->communityService->registerArticle($request->all()));
    }

    /**
     * 게시글 수정
     * @param Request $request
     * @return JsonResponse
     */
    public function modify(Request $request): JsonResponse
    {
        if ($this->communityService->checkBannedWords($request->all())) {
            return response()->json([
                'result' => 'fail',
                'code' => 'USE_BANNED_WORDS',
                'message' => '해당 게시판에 금지어를 사용하여 등록할 수 없습니다.'
            ]);
        }
        return response()->json($this->communityService->modifyArticle($request->all()));
    }

    /**
     * 게시글 답변 작성
     * @param Request $request
     * @return JsonResponse
     */
    public function writeReply(Request $request): JsonResponse
    {
        $checkBannedWordsParams = [
            'selectBoard' => Article::find($request->articleId)->board_idx,
            'boardTitle' => '',
            'editor_content' => $request->replyComment,
        ];
        if ($this->communityService->checkBannedWords($checkBannedWordsParams)) {
            return response()->json([
                'result' => 'fail',
                'code' => 'USE_BANNED_WORDS',
                'message' => '해당 게시판에 금지어를 사용하여 등록할 수 없습니다.'
            ]);
        }
        return response()->json($this->communityService->writeReply($request->all()));
    }

    /**
     * 게시글 삭제
     * @param $idx
     * @return JsonResponse
     */
    public function removeArticle($idx): JsonResponse
    {
        return response()->json($this->communityService->removeArticle($idx));
    }

    /**
     * 게시글 댓글 삭제
     * @param $idx
     * @return JsonResponse
     */
    public function removeComment($idx): JsonResponse
    {
        return response()->json($this->communityService->removeComment($idx));
    }

    /**
     * 게시글, 댓글 신고하기
     * @param Request $request
     * @return JsonResponse
     */
    public function reporting(Request $request): JsonResponse
    {
        return response()->json($this->communityService->reporting($request->all()));
    }

    /**
     * 내활동 > 작성 글, 내활동 > 좋아요 리스트
     * @param Request $request
     * @return View
     */
    public function getMyArticles(Request $request): View
    {
        $params['board_name'] =  preg_replace('/전체/', '', $request->input('board_name'));
        $params['offset'] = $data['offset'] = $request->input('offset') ?: 1;
        $params['limit'] = $this->limit;

        // 게시판 리스트
        $data['boards'] = $this->communityService->getBoardList();
        switch(Route::currentRouteName()){
            case 'community.my.articles':
                $data['pageType'] = 'articles';
                $data['pageName'] = '작성 글';
                $params['user_idx'] = Auth::user()['idx'];
                break;
            case 'community.my.likes':
                $data['pageType'] = 'likes';
                $data['pageName'] = '좋아요';
                $params['likes'] = true;
                break;
        }

        // 전체 게시판 리스트
        $data = array_merge($this->communityService->getArticleList($params), $data);
        return view('community.my-community', $data);
    }

    /**
     * 내 활동 > 작성 댓글 리스트
     * @param Request $request
     * @return View
     */
    public function getMyComments(Request $request): View
    {
        $params['board_name'] =  preg_replace('/전체/', '', $request->input('board_name'));
        $params['offset'] = $data['offset'] = $request->input('offset') ?: 1;
        $params['limit'] = $this->limit;

        // 게시판 리스트
        $data['boards'] = $this->communityService->getBoardList();
        $data['pageType'] = 'comments';
        $data['pageName'] = '작성 댓글';

        // 전체 게시판 리스트
        $data = array_merge($this->communityService->getMyComments($params), $data);
        return view('community.my-community', $data);
    }

    /**
     * 주문 배차 신청 페이지
     * @param string $orderGroupCode
     * @return View
     */
    public function writeDispatch(string $orderGroupCode): View
    {
        $data['idx'] = null;
        $boardsWhere = [
            'write_access' => ['condition' => 'like', 'value' => Auth::user()['type']],
        ];
        $data['boards'] = $this->communityService->getBoardList($boardsWhere);
        $data['order'] = $this->communityService->getDispatchOrders($orderGroupCode);
        $data['orderGroupCode'] = $orderGroupCode;
        return view('community.write', $data);
    }


    // 가구인 모임
    public function clubList()
    {
        $data['banners'] = $this->communityService->getBannerList('clubtop');
        $data['clubList'] = $this->communityService->getClubList();

        return view('community.club', $data);
    }

    public function clubTempList()
    {
        $data['banners'] = $this->communityService->getBannerList('clubtop');

        // return Club::where('is_open', 1)
        //     ->leftjoin('AF_attachment as at', function ($query) {
        //         $query->on('at.idx', 'AF_club.thumbnail_attachment_idx');
        //     })
        //     ->select('AF_club.*', DB::raw('CONCAT("'.preImgUrl().'", at.folder, "/", at.filename) as imgUrl'))
        //     ->get();

        $clubList = DB::table('AF_club')->select('AF_club.*', DB::raw('CONCAT("'.preImgUrl().'", at.folder, "/", at.filename) as imgUrl'))
        ->leftjoin('AF_attachment as at', function ($query) {
            $query->on('at.idx', 'AF_club.thumbnail_attachment_idx');
        })->get();

        foreach($clubList as $club){
            $articles = DB::table('AF_club_article')->where('club_idx', $club->idx)->where('is_delete', '0')->where('is_open', '1')->orderBy('idx', 'desc')->limit(3)->get();
            $club->article = $articles;
        }

        $data['clubList'] = $clubList; //$this->communityService->getClubList();

        return view('community.club', $data);
    }

    public function clubRegister(Request $request)
    {
        //return response()->json($this->communityService->removeComment($idx));
        //DB::table('AF_club_member')
        if (Auth::user()['type'] == "W"){
            $company = DB::table('AF_wholesale')->selectRaw('company_name as cname')->where('idx', Auth::user()['company_idx'])->first();
        }else if (Auth::user()['type'] == "R"){
            $company = DB::table('AF_retail')->selectRaw('company_name as cname')->where('idx', Auth::user()['company_idx'])->first();
        }else if (Auth::user()['type'] == "N" || Auth::user()['type'] == "S"){
            $company = DB::table('AF_normal')->selectRaw('name as cname')->where('idx', Auth::user()['company_idx'])->first();
        }

        $clubMember = DB::table("AF_club_member")->where('club_idx', $request->club_idx)->where('user_cidx', Auth::user()['company_idx'])->where('user_ctype', Auth::user()['type'])->first();
        if ($clubMember){
            if ($clubMember->status == "0"){
                return response()->json([
                    'status' => 3,
                ]);
            }else{
                return response()->json([
                    'status' => 2,
                ]);
            }
        }

        DB::table("AF_club_member")->insert([
            'club_idx' => $request->club_idx, 
            'user_cidx' => Auth::user()['company_idx'],
            'user_cname' => $company->cname, 
            'user_ctype' => Auth::user()['type'], 
            'is_manager' => '0', 
            'status' => '1', 
            'register_time' => Carbon::now(),
        ]);

        DB::table('AF_club')->where('idx', $request->club_idx)->increment('member_count');

        return response()->json([
            'status' => 1,
        ]);
    }

    public function clubDetail(int $idx)
    {
        $param['idx'] = $idx;
        $data['club'] = $this->communityService->getClubDetail($param);

        if(!$data['club']) return redirect('/community/club');
        
        return view('community.clubDetail', $data);
    }

    public function clubArticle(int $idx)
    {
        if(!$this->communityService->isActiveArticle($idx)) return redirect('/community/club');       

        $article = $this->communityService->getClubArticleDetail($idx);
        $comments = $this->communityService->getClubArticleComments($idx);

        return view('community.clubArticleDetail', [
            'article' => $article,
            'comments' => $comments,
        ]);
    }
}
