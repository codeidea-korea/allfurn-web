<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\UserSearch;
use App\Service\HomeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Service\ProductService;
use App\Service\MypageService;
use App\Service\LoginService;
use App\Models\FamilyAd;
use Illuminate\Support\Facades\DB;


class HomeController extends BaseController
{
    private $homeService;
    private $productService;
    private $mypageService;
    private $loginService;
    

    public function __construct(HomeService $homeService, ProductService $productService, MypageService $mypageService, LoginService $loginService)
    {
        $this->homeService = $homeService;
        $this -> productService = $productService;
        $this->mypageService = $mypageService;
        $this->loginService = $loginService;
    }


    public function index(Request $params) {
        
        Log::info('-------- HomeController > index ');
        
        $mAgent = array("iPhone","iPod","Android","Blackberry",
            "Opera Mini", "Windows ce", "Nokia", "sony" );
            
        $chkMobile = false;
        
        for ( $i=0; $i<sizeof($mAgent); $i++ ) {
            if(stripos( $_SERVER['HTTP_USER_AGENT'], $mAgent[$i] )){
                $chkMobile = true;
                break;
            }
        }

        $categoryList = $this->productService->getCategoryList();
        if ($chkMobile) {

            if (Auth::check()) {
                $schData = $this->homeService->getSearchData();
                
                $data = $this->homeService->getHomeData();
                $xtoken = $this->loginService->getFcmToken(Auth::user()['idx']);

                if($params->input('replaceUrl')) {
                    return redirect($params->input('replaceUrl'));
                }

                return view('m/home/index', [
                    'data'=>$data,
                    'xtoken' => $xtoken,
                    'categoryList'  => $categoryList,
                    'schData'   => $schData['category']
                ]);
                
            } else {
                $data = array();
                if($params->input('isweb')) {
                    $data['isweb'] = $params->input('isweb');
                }
                if($params->input('replaceUrl')) {
                    $data['replaceUrl'] = $params->input('replaceUrl');
                }
                
                return view('home/mWelcome', $data);
                
            }
            
            
        } else {
            
            Log::info('------------------ user --------------------');
            Log::info(Auth::user());
            Log::info('--------------------------------------------');
            
            if (Auth::check()) {
                $schData = $this->homeService->getSearchData();
                $data = $this->homeService->getHomeData();

                if($params->input('replaceUrl')) {
                    return redirect($params->input('replaceUrl'));
                }

                return view('home/index', [
                    'data'=>$data,
                    'categoryList'  => $categoryList,
                    'schData'   => $schData['category']
                ]);
                
            } else {
                
                return view('home/welcome');
                
            }
            
        }
        
    }
    
    
    public function welcome() {
        
        return view(getDeviceType().'home/welcome');
        
    }
    

    public function getNewProduct()
    {
        return $this->homeService->getNewProduct();
    }


    /**
     * 검색 키워드 리스트 보기
     * @return JsonResponse
     */
    public function getSearchData() {
        $data = $this->homeService->getSearchData();
        return response()->json($data);
    }



    /**
     * 검색 키워드 삭제
     * @param string $idx
     * @return JsonResponse
     */
    public function deleteSearchKeyword(string $idx): JsonResponse
    {
        $result = $this->homeService->deleteSearchKeyword($idx);

        return response()->json([
            'success' => $result > 0 ? true : false,
            'message' => ''
        ]);
    }

    /**
     * 검색 키워드 저장
     * @param string $keyword
     * @return JsonResponse
     */
    public function putSearchKeyword(string $keyword) {
        $this->homeService->putSearchKeyword($keyword);
        return response()->json([
            'success' => true
        ]);
    }

    public function checkAlert()
    {
        return $this->homeService->checkAlert();
    }

    //올펀 패밀리
    public function getAllFamily() {
        $data = $this->homeService->getAllFamily();
        return view(getDeviceType().'family.list', $data);
    }

    //올펀 패밀리 상세
    public function getFamilyMember($idx) {
        $data = $this->homeService->getFamilyMember($idx);
        return view(getDeviceType().'family.index', $data);
    }

    //올펀 패밀리 상세 - 업체 좋아요
    public function toggleCompanyLike(Request $params) {
        return $this->homeService->toggleCompanyLike($params);
    }

    public function searchResult(Request $request)
    {
        $data['keyword'] = $request->query('kw');
        $data['categoryIdx'] = $request->query('ca');
        $data['parentIdx'] = $request->query('pre');
        $data['property'] = $request->query('prop');
        $data['sort'] = $request->query('so');

        $productList = $this->productService->listByCategory($data);

        if ($productList['list']->total() == 0 && $data['categoryIdx'] == null && $data['parentIdx'] == null && $data['property'] == null && $data['sort'] == null) {
            $wholesalesCnt = $this->productService->countSearchWholesales($data['keyword']);

            if ($wholesalesCnt > 1) {
                return redirect('/wholesaler/search?kw='.$data['keyword']);
            }
        }

        return view(getDeviceType().'home.search-result', [
            'productList'=>$productList
        ]);
    }

    // 상단 공지
    public function getSpeakerLoud(Request $request)
    {
        return $this->homeService->getSpeakerLoud();
    }

    // 모바일 카테고리
    public function categoryList()
    {
        if(getDeviceType() != "m.") {
            return redirect('/');
        }
        // 올펀패밀리
        $family_ad = FamilyAd::select('AF_family_ad.*', 
                DB::raw('
                    CONCAT("'.preImgUrl().'", at.folder,"/", at.filename) as imgUrl'
                )
            )
            ->leftjoin('AF_attachment as at', function($query) {
                $query->on('at.idx', DB::raw('SUBSTRING_INDEX(AF_family_ad.family_attachment_idx, ",", 1)'));
            })
            ->where('AF_family_ad.state', 'G')
            ->where('AF_family_ad.start_date', '<', DB::raw("now()"))
            ->where('AF_family_ad.end_date', '>', DB::raw("now()"))
            ->where('AF_family_ad.is_delete', 0)
            ->where('AF_family_ad.is_open', 1)
            ->orderByRaw('if(ifnull(AF_family_ad.orders,999) < 1, 999, ifnull(AF_family_ad.orders,999))')->get();

        $categoryList = $this->productService->getCategoryListV2();
        return view("m.home.category", ['categoryList' => $categoryList, 'family_ad' => $family_ad]);
    }




    // 슬릭 슬라이더에 들어갈 페이지 내용
    public function getSlickSlideItems(Request $request)
    {
        $data['pageNo'] = $request->query('pageNo') == null ? 1 : $request->query('pageNo');
        $data['pageSize'] = $request->query('pageSize') == null ? 20 : $request->query('pageSize');
        $data['slideType'] = $request->query('slideType') == null ? 'best' : $request->query('slideType');

        $page = array();
        $page['offset'] = ($data['pageNo'] - 1) * $data['pageSize'];
        $page['limit'] = $data['pageSize'];

        if($data['slideType'] == 'best') {
            // 베스트 신상품 목록
            $data['views'] = $this->homeService->getProductAds($page);
        } else if($data['slideType'] == 'new') {
            // 신상품 목록 
            $data['views'] = $this->homeService->getNewProducts($page);
        }
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}

