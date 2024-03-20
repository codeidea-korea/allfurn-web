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

        //가구 소식
        $params['board_name'] = '가구 소식';
        $params['offset'] = 0;
        
        if(getDeviceType() == "m.") {
            $params['limit'] = 1;
        } else {
            $params['limit'] = 3;
        }

        $furnitureNewsList = $this->communityService->getArticleList($params);
        $data['furnitureNewsList'] = $furnitureNewsList['articles'];

        //매거진
        $params['offset'] = 0;
        $params['limit'] = 6;
        $data = array_merge($data, $this->magazineService->list($params));

        return view(getDeviceType().'magazine.list', $data);
    }

    public function dailyNews(Request $request) {

        $params['board_name'] = '일일 가구 뉴스';
        $params['keyword'] = $request->keyword ? $request->keyword : "";

        $data = $this->communityService->getArticleList($params);
        return view(getDeviceType().'magazine.dailyNews', $data);
    }

    public function furnitureNews() {

        $params['board_name'] = '가구 소식';

        $data = $this->communityService->getArticleList($params);
        return view('magazine.furnitureNews', $data);
    }

    public function newsDetail(int $idx) {

        // 게시글 조회 +1
        $this->communityService->updateArticleView($idx);
        $data['article'] = $this->communityService->getArticleDetail($idx);
        $data['articleId'] = $idx;

        // 댓글 가져오기
        $data['comments'] = $data['article'] ? $this->communityService->getArticleComments($idx) : [];

        return view(getDeviceType().'magazine.news-detail', $data);
    }

    public function magazineList(Request $request) {

        $params['offset'] = $request->offset;
        $params['limit'] = 6;
        $data = $this->magazineService->list($params);

        return response()->json($data);
    }

    public function detail(int $idx)
    {
        $data['article'] = $this->magazineService->detail($idx);
        // TODO: TODO: 카테고리 생성된 후 변경 
        $data['article']['board_name'] = '카테고리 없음';

        return view('magazine.simple-detail', $data);
        // return view('magazine.detail', $data);
    }
}
