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
    
//     public function index(Request $params)
//     {
//     	Log::info('-------- HomeController > index ');
    	
//     	$mAgent = ["iPhone","iPod","Android","Blackberry","Opera Mini","Windows ce","Nokia","sony"];
//     	$ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
//     	$chkMobile = false;
    	
//     	for ($i = 0; $i < sizeof($mAgent); $i++) {
//     		// ✅ stripos()는 0도 나올 수 있으니 !== false 로 체크해야 함
//     		if (stripos($ua, $mAgent[$i]) !== false) {
//     			$chkMobile = true;
//     			break;
//     		}
//     	}
    	
//     	// ✅ replaceUrl 처리 (있으면 decode 후 안전검증)
//     	$rawReplaceUrl = $params->input('replaceUrl'); // 인코딩된 상태로 들어옴(https%3A%2F...)
//     	$targetUrl = null;
    	
//     	if (!empty($rawReplaceUrl)) {
//     		$decoded = urldecode($rawReplaceUrl);
    		
//     		// (1) 절대 URL이면 우리 도메인만 허용
//     		if (preg_match('#^https?://#i', $decoded)) {
//     			$host = parse_url($decoded, PHP_URL_HOST);
//     			$allowedHosts = ['all-furn.com', 'www.all-furn.com'];
    			
//     			if (in_array($host, $allowedHosts, true)) {
//     				$targetUrl = $decoded;
//     			}
//     		}
//     		// (2) 상대경로도 허용하고 싶으면 아래 주석 해제
//     		// else if (strpos($decoded, '/') === 0) {
//     		//     $targetUrl = $decoded;
//     		// }
//     	}
    	
//     	$categoryList = $this->productService->getCategoryList();
    	
//     	if ($chkMobile) {
    		
//     		if (Auth::check()) {
//     			$schData = $this->homeService->getSearchData();
//     			$data = $this->homeService->getHomeData();
//     			$xtoken = $this->loginService->getFcmToken(Auth::user()['idx']);
    			
//     			// ✅ 로그인 상태면 targetUrl 있으면 거기로 이동
//     			if ($targetUrl) {
//     				return redirect()->to($targetUrl);
//     			}
    			
//     			return view('m/home/index', [
//     					'data' => $data,
//     					'xtoken' => $xtoken,
//     					'categoryList' => $categoryList,
//     					'schData' => $schData['category'],
//     			]);
    			
//     		} else {
//     			$data = [];
    			
//     			if ($params->input('isweb')) {
//     				$data['isweb'] = $params->input('isweb');
//     			}
//     			// ✅ 뷰에는 원본(인코딩된 replaceUrl) 그대로 넘겨도 됨
//     			if (!empty($rawReplaceUrl)) {
//     				$data['replaceUrl'] = $rawReplaceUrl;
//     			}
    			
//     			return view('home/mWelcome', $data);
//     		}
    		
//     	} else {
    		
//     		Log::info('------------------ user --------------------');
//     		Log::info(Auth::user());
//     		Log::info('--------------------------------------------');
    		
//     		if (Auth::check()) {
//     			$schData = $this->homeService->getSearchData();
//     			$data = $this->homeService->getHomeData();
    			
//     			if ($targetUrl) {
//     				return redirect()->to($targetUrl);
//     			}
    			
//     			return view('home/index', [
//     					'data' => $data,
//     					'categoryList' => $categoryList,
//     					'schData' => $schData['category'],
//     			]);
//     		} else {
//     			return view('home/welcome');
//     		}
//     	}
//     }
    
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
}

