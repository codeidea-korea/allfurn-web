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


class HomeController extends BaseController
{
    private $homeService;
    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }


    public function index() {
        
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

        if ($chkMobile) {

            if (Auth::check()) {
                
                $data = $this->homeService->getHomeData();

                return view('m/home/index', ['data'=>$data]);
                
            } else {
                
                return view('home/mWelcome');
                
            }
            
            
        } else {
            
            Log::info('------------------ user --------------------');
            Log::info(Auth::user());
            Log::info('--------------------------------------------');
            
            if (Auth::check()) {
                
                $data = $this->homeService->getHomeData();

                return view('home/index', ['data'=>$data]);
                
            } else {
                
                return view('home/welcome');
                
            }
            
        }
        
    }
    
    
    public function welcome() {
        
        return view('home/welcome');
        
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

    //올펀 패밀리 상세
    public function getFamilyMember($idx) {
        $data = $this->homeService->getFamilyMember($idx);
        return view(getDeviceType().'family.index', $data);
    }

    //올펀 패밀리 상세 - 업체 좋아요
    public function toggleCompanyLike(Request $params) {
        return $this->homeService->toggleCompanyLike($params);
    }
}

