<?php

namespace App\Http\Controllers;

use App\Service\MagazineService;
use App\Service\CommunityService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class MagazineController extends BaseController
{
    private $magazineService;
    private $limit = 16;
    public function __construct(MagazineService $magazineService, CommunityService $communityService)
    {
        $this->magazineService = $magazineService;
        $this->communityService = $communityService;
    }

    public function index(Request $request)
    {
        // $params['offset'] = $data['offset'] = $request->input('offset') ?: 1;
        // $params['limit'] = $data['limit'] = $this->limit;

        //일일 가구 뉴스
        $params['board_name'] = '일일 가구 뉴스';
        $params['offset'] = 0;
        $params['limit'] = 5;

        $data['banners'] = $this->magazineService->banners();
        $data = array_merge($data, $this->communityService->getArticleList($params));
        return view('magazine.list', $data);
    }

    public function dailyNews(Request $request) {

        $params['board_name'] = '일일 가구 뉴스';
        $params['keyword'] = $request->keyword ? $request->keyword : "";

        $data = $this->communityService->getArticleList($params);
        return view('magazine.dailyNews', $data);
    }

    public function dailyNewsDetail(int $idx) {

        // 게시글 조회 +1
        $this->communityService->updateArticleView($idx);
        $data['article'] = $this->communityService->getArticleDetail($idx);
        $data['articleId'] = $idx;

        // 댓글 가져오기
        $data['comments'] = $data['article'] ? $this->communityService->getArticleComments($idx) : [];

        return view('magazine.dailyNews-detail', $data);
    }

    public function detail(int $idx)
    {
        $data['detail'] = $this->magazineService->detail($idx);
        return view('magazine.detail', $data);
    }
}
