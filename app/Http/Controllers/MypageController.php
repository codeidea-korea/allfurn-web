<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Estimate;
use App\Service\MypageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use App\Service\LoginService;
use App\Service\ProductService;
use App\Service\TmpLikeService;
use App\Service\PushService;
use App\Service\MemberService;
use \Exception;
use Session;

class MypageController extends BaseController
{
    private $mypageService;
    private $loginService;
    private $productService;
    private $tmpLikeService;
    private $memberService;
    private $limit = 20;
    private $user;
    public function __construct(MypageService $mypageService, LoginService $loginService, ProductService $productService, 
                                TmpLikeService $tmpLikeService, PushService $pushService, MemberService $memberService)
    {
        $this->mypageService = $mypageService;
        $this->loginService = $loginService;
        $this -> productService = $productService;
        $this->tmpLikeService = $tmpLikeService;
        $this -> pushService = $pushService;
        $this -> memberService = $memberService;
    }

    public function index(): Response
    {
        if (getDeviceType() === 'm.') {
            $data['xtoken'] = $this -> loginService -> getFcmToken(Auth::user()['idx']);
            $data['user'] = $this -> getLoginUser();

            $data['info'] = $this -> mypageService -> getEstimateInfo();
            $data['pageType'] = 'mypage';

            $data['point']  = $this->mypageService->getPointList();
            $data['likeProductCount'] = $this->mypageService->getTotalLikeProduct();
            $data['likeCompanyCount'] = $this->mypageService->getTotalLikeCompany();
            $data['recentlyViewedProductCount'] = $this->mypageService->getTotalRecentlyViewedProduct();
            $data['inquiryCount'] = $this->mypageService->getTotalInquiry();

            return response() -> view(getDeviceType().'mypage.mypage', $data) -> withCookie(Cookie::forget('cocw'));
        } else {
            if (Auth::user()['type'] === 'W') {
                return redirect() -> route('mypage.deal');
            } else if (Auth::user()['type'] === 'R') {
                return redirect() -> route('mypage.purchase');
            } else {
                return redirect() -> route('mypage.interest');
            }
        }
    }

    /**
     * 판매 현황
     * @param Request $request
     * @return Response
     */
    public function deal(Request $request): Response {
        $params['offset'] = $data['offset'] = $request -> input('offset') ?: 1;
        $params['limit'] = $data['limit'] = $this -> limit;
        $params = array_merge($params, $request -> all());

        // 키워드 검색
        switch($request -> input('keywordType')) {
            case 'orderNum':
                $data['keywordTypeText'] = "주문번호";
                break;
            case 'productName':
                $data['keywordTypeText'] = "상품명";
                break;
            case 'purchaser':
                $data['keywordTypeText'] = "구매 업체";
                break;
            default:
                $data['keywordTypeText'] = '전체';
                break;
        }

        // 전체 개수
        $countParams['orderType'] = $params['orderType'] = 'S';
        $data['orderCount'] = $this -> mypageService -> getTotalOrderCount($countParams);

        $data['dealStatus'] = config('constants.ORDER.STATUS.S');
	    $data = array_merge($this -> mypageService -> getOrderList($params), $data); 

//        if($this -> user == null) { $this -> getLoginUser(); }
        $data['user'] = $this -> getLoginUser();
        $xtoken = $this->loginService->getFcmToken(Auth::user()['idx']);
	    $data['xtoken'] = $xtoken;

        $data['info'] = $this -> mypageService -> getEstimateInfo();
        $data['pageType'] = 'deal';

        $data['point']  = $this->mypageService->getPointList();
        $data['likeProductCount'] = $this->mypageService->getTotalLikeProduct();
        $data['likeCompanyCount'] = $this->mypageService->getTotalLikeCompany();
        $data['recentlyViewedProductCount'] = $this->mypageService->getTotalRecentlyViewedProduct();
        $data['inquiryCount'] = $this->mypageService->getTotalInquiry();

        return response() -> view(getDeviceType().'mypage.mypage', $data) -> withCookie(Cookie::forget('cocw'));
    }

    /**
     * 판매 현황 > 업체별
     * @param Request $request
     * @return Response
     */
    public function dealCompany(Request $request): Response {
        $params['offset'] = $data['offset'] = $request -> input('offset') ?: 1;
        $params['limit'] = $data['limit'] = $this -> limit;
        $params = array_merge($params, $request -> all());

        // 키워드 검색
        switch($request -> input('keywordType')) {
            case 'orderNum':
                $data['keywordTypeText'] = "주문번호";
                break;
            case 'productName':
                $data['keywordTypeText'] = "상품명";
                break;
            case 'purchaser':
                $data['keywordTypeText'] = "구매 업체";
                break;
            default:
                $data['keywordTypeText'] = '전체';
                break;
        }

        // 전체 개수
        $countParams['orderType'] = $params['orderType'] = 'S';
        $data['orderCount'] = $this -> mypageService -> getTotalOrderCount($countParams);

        $data['dealStatus'] = config('constants.ORDER.STATUS.S');
	    $data = array_merge($this -> mypageService -> getOrderList($params), $data); 

        if($this -> user == null) { $this -> getLoginUser(); }
        $data['user'] = $this -> getLoginUser();
        $xtoken = $this->loginService->getFcmToken(Auth::user()['idx']);
	    $data['xtoken'] = $xtoken;

        $data['info'] = $this -> mypageService -> getEstimateInfo();
        $data['pageType'] = 'deal-company';

        return response() -> view(getDeviceType().'mypage.mypage', $data) -> withCookie(Cookie::forget('cocw'));
    }

    /**
     * 주문 현황 마이페이지
     * @param Request $request
     * @return Response
     */
    public function purchase(Request $request): Response
    {
        $params['offset'] = $data['offset'] = $request->input('offset') ?: 1;
        $params['limit'] = $data['limit'] = $this->limit;

        $data['purchaseStatus'] = config('constants.ORDER.STATUS.P');

        $params = array_merge($params, $request->all());

        // 구매자 거래 총 수량 가져오기
        $countParams['orderType'] = $params['orderType'] = 'P';
        $data['orderCount'] = $this->mypageService->getTotalOrderCount($countParams);

        // 전체 주문 리스트
        switch($request->input('keywordType')) {
            case 'orderNum':
                $data['keywordTypeText'] = "주문번호";
                break;
            case 'productName':
                $data['keywordTypeText'] = "상품명";
                break;
            case 'dealer':
                $data['keywordTypeText'] = "업체명";
                break;
            default:
                $data['keywordTypeText'] = '전체';
                break;
        }

        // 전체 주문 리스트
        $data = array_merge($this->mypageService->getOrderList($params), $data);

        $data['user'] = $this -> getLoginUser();
        $xtoken = $this -> loginService -> getFcmToken(Auth::user()['idx']);
        $data['xtoken'] = $xtoken;

        $data['info'] = $this -> mypageService -> getEstimateInfo();
        $data['pageType'] = 'purchase';

        $data['point']  = $this->mypageService->getPointList();
        $data['likeProductCount'] = $this->mypageService->getTotalLikeProduct();
        $data['likeCompanyCount'] = $this->mypageService->getTotalLikeCompany();
        $data['recentlyViewedProductCount'] = $this->mypageService->getTotalRecentlyViewedProduct();
        $data['inquiryCount'] = $this->mypageService->getTotalInquiry();

        return response() -> view(getDeviceType().'mypage.mypage', $data) -> withCookie(Cookie::forget('cocw'));
    }

    /**
     * 일반 유저 마이페이지
     * @return View
     */
    public function normal(): View
    {
        $data['pageType'] = 'normal';
        $data['user'] = $this->getLoginUser();

        $data['point']  = $this->mypageService->getPointList();
        $data['likeProductCount'] = $this->mypageService->getTotalLikeProduct();
        $data['likeCompanyCount'] = $this->mypageService->getTotalLikeCompany();
        $data['recentlyViewedProductCount'] = $this->mypageService->getTotalRecentlyViewedProduct();
        $data['inquiryCount'] = $this->mypageService->getTotalInquiry();

        return view('mypage.mypage', $data);
    }

    /**
     * 주문/거래 상태 변경
     * @param Request $request
     * @return JsonResponse
     */
    public function changeStatus(Request $request): JsonResponse
    {
        if ($request->input('status') === 'C' && !$request->input('cancelReason')) {
            return response()->json([
                'result' => 'fail',
                'code' => 'REQUIRED_PARAMS',
                'message' => '취소 사유를 입력해주세요',
            ]);
        }
        try {
            return response()->json($this->mypageService->changeStatus($request->all()));
        } catch (\Throwable $e) {
            return response()->json([
                'result' => 'fail',
                'code' => $e->getCode(),
                'message' => '상태 변경이 실패하였습니다.'
            ]);
        }
    }

    /**
     * 주문/거래 상세
     * @param Request $request
     * @return RedirectResponse|View
     */
    public function detail(Request $request)
    {

        try {
            $data = array_merge([], $request->all());
            if (isset($data['type']) && $data['type'] === 'S') {
                $data['detailTitle1'] = '판매';
                $data['detailTitle2'] = '거래';
            } else {
                $data['loginCompanyName'] = $this->mypageService->getOrderProductSellerName($request->all());
                $data['detailTitle1'] = '구매';
                $data['detailTitle2'] = '주문';
            }
            $data['orderGroupCode'] = $this->mypageService->getOrderGroupCode($request->all());
            $request['orderGroupCode'] = $data['orderGroupCode'];
            $data['orders'] = $this->mypageService->getOrderDetail($request->all());
            $data['buyer'] = $this->mypageService->getOrderBuyer($request->all());
            $data['cancel'] = $this->mypageService->getOrderCancelList($request->all());
        } catch (\Throwable $e) {
            return back()
                ->withErrors([
                    'not_match' => '잘못된 접근입니다.',
                ]);
        }

        $data['orderStatus'] = array_unique(array_map(function($order) {
            return $order['order_state'];
        }, $data['orders']->toArray()));

        $data['pageType'] = 'order-detail';

        return view(getDeviceType().'mypage.order-detail', $data);
    }

    /**
     * 주문/거래 취소 화면
     * @param Request $request
     * @return View
     * @throws Exception
     */
    public function orderCancel(Request $request): View
    {
        $data = array_merge([], $request->all());
        if (isset($data['type']) && $data['type'] === 'S') {
            $data['detailTitle1'] = '판매';
            $data['detailTitle2'] = '거래';
        } else {
            // $data['loginCompanyName'] = $this->mypageService->getOrderProductSellerName($request->all());
            $data['detailTitle1'] = '구매';
            $data['detailTitle2'] = '주문';
        }
        $data['orders'] = $this->mypageService->getOrderDetail($request->all());

        return view(getDeviceType().'mypage.order-cancel', $data);
    }

    /**
     * 관심 상품
     * @param Request $request
     * @return View
     */
    public function interest(Request $request): View {
        $params['offset'] = $data['offset'] = $request -> input('offset') ?: 1;
        $params['limit'] = $data['limit'] = 12;
        $params = array_merge($params, $request -> all());

        $data['checked_categories'] = [];
        if(isset($params['categories'])) {
            $data['checked_categories'] = explode(',', $params['categories']);
        }

        $data['pageType'] = 'interest';
        $data['user'] = $this -> getLoginUser();
        $data['categoryList'] = $this->mypageService->getCategories();
        $data['folders'] = $this -> mypageService -> getMyFolders();
        $data = array_merge($data, $this -> tmpLikeService -> getInterestProducts($params));

        $xtoken = $this->loginService->getFcmToken(Auth::user()['idx']);
	    $data['xtoken'] = $xtoken;

        $data['point']  = $this->mypageService->getPointList();
        $data['likeProductCount'] = $this->mypageService->getTotalLikeProduct();
        $data['likeCompanyCount'] = $this->mypageService->getTotalLikeCompany();
        $data['recentlyViewedProductCount'] = $this->mypageService->getTotalRecentlyViewedProduct();
        $data['inquiryCount'] = $this->mypageService->getTotalInquiry();

        return view(getDeviceType() . 'mypage.mypage', $data);
    }

    /**
     * 좋아요
     * @param Request $request
     * @return View
     */
    public function like(Request $request): View {
        $params['offset'] = $data['offset'] = $request -> input('offset') ?: 1;
        $params['limit'] = $data['limit'] = 12;
        $params = array_merge($params, $request -> all());

        $data['checked_categories'] = [];
        if(isset($params['categories'])) {
            $data['checked_categories'] = explode(',', $params['categories']);
        }

        $data['pageType'] = 'like';
        $data['user'] = $this -> getLoginUser();
        $data['categoryList'] = $this->mypageService->getCategories();
        $data['regions'] = $request -> input('regions') ? explode(',', $request -> input('regions')) : [];
        $data = array_merge($data, $this -> tmpLikeService -> getLikeCompanies($params));

        $data['point']  = $this->mypageService->getPointList();
        $data['likeProductCount'] = $this->mypageService->getTotalLikeProduct();
        $data['likeCompanyCount'] = $this->mypageService->getTotalLikeCompany();
        $data['recentlyViewedProductCount'] = $this->mypageService->getTotalRecentlyViewedProduct();
        $data['inquiryCount'] = $this->mypageService->getTotalInquiry();

        return view(getDeviceType() .'mypage.mypage', $data);
    }

    /**
     * 최근 본 상품
     * @param Request $request
     * @return View
     */
    public function recent(Request $request): View {
        $params['offset'] = $data['offset'] = $request -> input('offset') ?: 1;
        $params['limit'] = $data['limit'] = 12;
        $params = array_merge($params, $request -> all());

        $data['checked_categories'] = [];
        if(isset($params['categories'])) {
            $data['checked_categories'] = explode(',', $params['categories']);
        }

        $data['pageType'] = 'recent';
        $data['user'] = $this -> getLoginUser();
        $data['categoryList'] = $this->mypageService->getCategories();

        $data = array_merge($data, $this -> mypageService -> getRecentProducts($params));

        $data['point']  = $this->mypageService->getPointList();
        $data['likeProductCount'] = $this->mypageService->getTotalLikeProduct();
        $data['likeCompanyCount'] = $this->mypageService->getTotalLikeCompany();
        $data['recentlyViewedProductCount'] = $this->mypageService->getTotalRecentlyViewedProduct();
        $data['inquiryCount'] = $this->mypageService->getTotalInquiry();

        return view(getDeviceType().'mypage.mypage', $data);
    }



    /**
     * 내 폴더 리스트 가져오기
     * @return View
     */
    public function getMyFolders(): View
    {
        $data['folders'] = $this->mypageService->getMyFolders();
        return view('mypage.folder-modal', $data);
    }

    /**
     * 내 폴더 추가/수정하기
     * @param Request $request
     * @return JsonResponse
     */
    public function addMyFolders(Request $request): JsonResponse
    {
        if ($request->input('updates')) {
            $this->mypageService->updateMyFolders($request->input('updates'));
        }
        if ($request->input('adds')) {
            $this->mypageService->addMyFolders($request->input('adds'));
        }
        return response()->json([
            'result' => 'success',
            'message' => ''
        ]);
    }

    /**
     * 내 폴더 삭제하기
     * @param int $idx
     * @return JsonResponse
     */
    public function removeMyFolders(int $idx): JsonResponse
    {
        return response()->json($this->mypageService->removeMyFolders($idx));
    }

    /**
     * 내 관심 상품 삭제하기
     * @param Request $request
     * @return JsonResponse
     */
    public function removeMyInterestProducts(Request $request): JsonResponse
    {
        return response()->json($this->mypageService->removeMyInterestProducts($request->all()));
    }

    /**
     * 내 관심 상품 폴더 옮기기
     * @param Request $request
     * @return JsonResponse
     */
    public function moveMyInterestProducts(Request $request): JsonResponse
    {
        return response()->json($this->mypageService->moveMyInterestProducts($request->all()));
    }

    /**
     * 관심 상품 등록
     * @param Request $request
     * @return JsonResponse
     */
    public function addMyInterestProducts(Request $request): JsonResponse
    {
        return response()->json($this->mypageService->addMyInterestProducts($request->all()));
    }

    /**
     * 홈페이지 관리 (메인)
     * @return View
     */
    public function company(): View {
        $data['user'] = $this -> getLoginUser();

        $data['info'] = $this -> mypageService -> getCompany();
        $data['pageType'] = 'company';

        $data['point']  = $this->mypageService->getPointList();
        $data['likeProductCount'] = $this->mypageService->getTotalLikeProduct();
        $data['likeCompanyCount'] = $this->mypageService->getTotalLikeCompany();
        $data['recentlyViewedProductCount'] = $this->mypageService->getTotalRecentlyViewedProduct();
        $data['inquiryCount'] = $this->mypageService->getTotalInquiry();

        return view(getDeviceType().'mypage.mypage', $data);
    }

    /**
     * 상품 등록 관리
     * @param Request $request
     * @return View
     */
    public function product(Request $request): View
    {
        $params['offset'] = $data['offset'] = $request -> input('offset') ?: 1;
        $params['limit'] = $data['limit'] = 10;
        $params = array_merge($params, $request -> all());

        $data['checked_state'] = [];
        if(isset($params['state'])) {
            $data['checked_state'] = explode(',', $params['state']);
        }

        $data['checked_categories'] = [];
        if(isset($params['categories'])) {
            $data['checked_categories'] = explode(',', $params['categories']);
        }

        // 최근 등록순 / 등록순
        $data['order'] = $params['order'];

        $data['pageType'] = 'product';
        $data['user'] = $this -> getLoginUser();
        $data['categories'] = $this -> mypageService -> getCategories();
        // 추천 상품 가져오기
        $data['represents'] = $this -> mypageService -> getRepresentProducts($params);
        // 전체 가져오기
        $data = array_merge($data, $this -> mypageService -> getRegisterProducts($params));
        $data = array_merge($data, $this -> mypageService -> getTotalProductCount());

        $data['point']  = $this->mypageService->getPointList();
        $data['likeProductCount'] = $this->mypageService->getTotalLikeProduct();
        $data['likeCompanyCount'] = $this->mypageService->getTotalLikeCompany();
        $data['recentlyViewedProductCount'] = $this->mypageService->getTotalRecentlyViewedProduct();
        $data['inquiryCount'] = $this->mypageService->getTotalInquiry();

        return view(getDeviceType().'mypage.mypage', $data);
    }

    /**
     * 계정 관리 (메인)
     * @return View
     */
    public function account(): View
    {
        $data['user'] = $this -> getLoginUser();
        
        $data['pageType'] = 'account';

        $data['point']  = $this->mypageService->getPointList();
        $data['likeProductCount'] = $this->mypageService->getTotalLikeProduct();
        $data['likeCompanyCount'] = $this->mypageService->getTotalLikeCompany();
        $data['recentlyViewedProductCount'] = $this->mypageService->getTotalRecentlyViewedProduct();
        $data['inquiryCount'] = $this->mypageService->getTotalInquiry();

        return view(getDeviceType().'mypage.mypage', $data);
    }

    /**
     * 일반 계정
     * @return View
     */
    public function normalAccount(): View
    {
		$data['user'] = $this->getLoginUser();
		$user_type = Auth::user()['type'];

        return $this->companyAccount();
		
		if ($user_type === 'N') {
			$data['pageType'] = 'normal-account';
			$nameCardImage = $this->mypageService->getUserNameCard();
			$data['nameCardImage'] = $nameCardImage ?? '';
			$data['point'] = $this->mypageService->getPointList();
		} else {
			// 로그아웃 시키지 않고 다른 계정 타입에 맞는 처리
			$data['pageType'] = 'normal-account'; // 또는 적절한 다른 페이지 타입
		}
        $data['info'] = $this -> mypageService -> getEstimateInfo();
        $xtoken = $this->loginService->getFcmToken(Auth::user()['idx']);
	    $data['xtoken'] = $xtoken;
		
		$data['likeProductCount'] = $this->mypageService->getTotalLikeProduct();
		$data['likeCompanyCount'] = $this->mypageService->getTotalLikeCompany();
		$data['recentlyViewedProductCount'] = $this->mypageService->getTotalRecentlyViewedProduct();
		$data['inquiryCount'] = $this->mypageService->getTotalInquiry();
		
		return view(getDeviceType().'mypage.mypage', $data);
    }

    /**
     * 홈페이지 관리 (수정)
     * @return View
     */
    public function editCompany(): View {
        $data['user'] = $this -> getLoginUser();

        $data['info'] = $this -> mypageService -> getCompany();
        $data['pageType'] = 'company-edit';

        $data['point']  = $this->mypageService->getPointList();
        $data['likeProductCount'] = $this->mypageService->getTotalLikeProduct();
        $data['likeCompanyCount'] = $this->mypageService->getTotalLikeCompany();
        $data['recentlyViewedProductCount'] = $this->mypageService->getTotalRecentlyViewedProduct();
        $data['inquiryCount'] = $this->mypageService->getTotalInquiry();

        return view(getDeviceType().'mypage.mypage', $data);
    }

    /**
     * 회사 소개 이미지 업로드
     * @param Request $request
     * @return Response
     */
    public function uploadCompanyIntroduceImage(Request $request): Response
    {
        $request->validate([
            'images' => 'image|mimes:png,jpg,jpeg,webp|max:2048'
        ]);
        return response($this->mypageService->uploadImage($request->file('images'), 'company/introduce'), 200);
    }

    /**
     * 회사 소개 이미지 삭제
     * @param Request $request
     * @return JsonResponse
     */
    public function removeCompanyIntroduceImage(Request $request): JsonResponse
    {
        $imageUrl = $request->input('imageUrl');
        return response()->json($this->mypageService->deleteImage($imageUrl, 'community/introduce'));
    }

    /**
     * 업체 정보 수정
     * @param Request $request
     * @return JsonResponse
     */
    public function updateCompany(Request $request): JsonResponse
    {
        $params = $request->all();
        $params['profile_image'] = $request->file('profile_image');
        $params['top_banner'] = $request->file('top_banner');
        return response()->json($this->mypageService->updateCompany($params));
    }

    public function updateBusinessLicenseFile(Request $request): JsonResponse
    {
        $data = $request -> all();

        if (isset($data['files'])) {
            $attachmentIdx = '';
            foreach ($data['files'] as $file) {
                if(is_file($file)) {
                    $filePath = $file -> store('business-license-image', 's3');
                    $attachmentIdx .= $this->mypageService->requestLicenseAttachment($filePath).',';
                }
            }
            if (isset($data['attachmentIdx'])) {
                $data['attachmentIdx'] .= ','.substr($attachmentIdx, 0, -1);
            } else {
                $data['attachmentIdx'] = substr($attachmentIdx, 0, -1);
            }
        }

        $result = $this->mypageService->updateBusinessLicenseFile($data);
        return response()->json($result);
    }

    /**
     * 업체 소재지 삭제
     * @param $idx
     * @return JsonResponse
     */
    public function deleteCompanyLocation($idx): JsonResponse
    {
        return response()->json($this->mypageService->deleteCompanyLocation($idx));
    }

    /**
     * 업체 상품 상태 변경
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function changeProductState(Request $request): JsonResponse
    {
        return response()->json($this->mypageService->changeProductState($request->all()));
    }

    /**
     * 상품 삭제
     * @param $idx
     * @return JsonResponse
     */
    public function deleteProduct($idx): JsonResponse
    {
        return response()->json($this->mypageService->deleteProduct($idx));
    }
    
    /**
     * 임시 저장된 상품 삭제
     * @param $idx
     * @return JsonResponse
     */
    public function deleteProductTemp($idx): JsonResponse
    {
        return response()->json($this->mypageService->deleteProductTemp($idx));
    }

    /**
     * (이메일/휴대폰) 인증번호 전송
     * @param Request $request
     * @return JsonResponse
     */
    public function sendAuthEmail(Request $request): JsonResponse {
        if (Auth::user()['account'] !== $request -> input('email')) {
            return response() -> json([
                'result'    => 'fail',
                'code'      => '99',
                'message'   => '일치하는 계정이 존재하지 않습니다. 다시한번 확인해주세요.'
            ]);
        }
        
        $tmp_p['phone_number'] = Auth::user()['phone_number'];
        return response() -> json($this -> mypageService -> sendAuth($tmp_p));
    }

    /**
     * 휴대폰 인증 번호 보내기
     * @param Request $request
     * @return JsonResponse
     */
    public function sendAuthPhone(Request $request): JsonResponse
    {
        return response()->json($this->mypageService->sendAuth($request->all()));
    }

    /**
     * 인증 코드 비교
     * @param Request $request
     * @return JsonResponse
     */
    public function compareAuthCode(Request $request): JsonResponse {
        
        Log::info($request['type']);
        
        return response()->json($this->mypageService->compareAuthCode($request->all()));
        
    }


    /**
     * 계정 관리 (수정)
     * @return View
     */
    public function companyAccount(): View {
	$data = [];
        
        $data['user'] = $this -> getLoginUser();
        $user_type = Auth::user()['type'];
        Log::debug("----- user : $user_type");
        /*
        if ( $user_type === 'N' || $user_type === 'S' ) {
            $data['pageType'] = 'normal-account';
            
        } else {
            $data['pageType'] = 'company-account';

            $data['company'] = $this -> mypageService -> getCompanyAccount();
            $data['members'] = $this -> mypageService -> getCompanyMembers();
        }
            */

        $nameCardImage = $this->mypageService->getUserNameCard();
        $data['nameCardImage'] = $nameCardImage ?? '';
        $data['point'] = $this->mypageService->getPointList();
        $data['info'] = $this -> mypageService -> getEstimateInfo();
        $xtoken = $this->loginService->getFcmToken(Auth::user()['idx']);
        $data['xtoken'] = $xtoken;
        
        $data['pageType'] = 'company-account-new';
        $data['company'] = $this -> mypageService -> getCompanyAccount();
        $data['members'] = $this -> mypageService -> getCompanyMembers();

        $data['likeProductCount'] = $this->mypageService->getTotalLikeProduct();
        $data['likeCompanyCount'] = $this->mypageService->getTotalLikeCompany();
        $data['recentlyViewedProductCount'] = $this->mypageService->getTotalRecentlyViewedProduct();
        $data['inquiryCount'] = $this->mypageService->getTotalInquiry();

        if(getDeviceType() == 'm.') {
            return view(getDeviceType().'mypage.company-account-new', $data);
        } else {
            return view('mypage.mypage', $data);
        }
    }

    /**
     * 업체 계정 정보 수정
     * @param Request $request
     * @return JsonResponse
     */
    public function updateCompanyAccount(Request $request): JsonResponse
    {
        return response()->json($this->mypageService->updateCompanyAccount($request->all()));
    }

    /**
     * 업체 직원 삭제
     * @param $idx
     * @return JsonResponse
     */
    public function deleteCompanyMember($idx): JsonResponse
    {
        return response()->json($this->mypageService->deleteCompanyMember($idx));
    }

    /**
     * 업체 계정 패스워드 변경
     * @param Request $request
     * @return JsonResponse
     */
    public function changePassword(Request $request): JsonResponse
    {
        return response()->json($this->mypageService->changeCompanyPassword($request->all()));
    }

    /**
     * 업체 직원 등록/수정 페이지
     * @param int|null $idx
     * @return View
     */
    public function getCompanyMember(int $idx = null): View
    {
        $data['idx'] = $idx;
        $data['pageType'] = 'company-member';
        $data['user'] = $this->getLoginUser();
        $data['member'] = $this->mypageService->getCompanyMembers($idx);
        return view('mypage.company-member', $data);
    }

    /**
     * 업체 직원 등록
     * @param Request $request
     * @return JsonResponse
     */
    public function createCompanyMember(Request $request): JsonResponse
    {
        $params = $request->all();
        $params['type'] = 'create';
        return response()->json($this->mypageService->setCompanyMember($params));
    }

    /**
     * 업체 직원 수정
     * @param Request $request
     * @return JsonResponse
     */
    public function updateCompanyMember(Request $request): JsonResponse
    {
        $params = $request->all();
        $params['type'] = 'update';
        return response()->json($this->mypageService->setCompanyMember($params));
    }

    /**
     * 탈퇴 페이지
     * @return View
     */
    public function withdrawal(): View
    {
        $data['pageType'] = 'withdrawal';
        $data['user'] = $this->getLoginUser();

        $data['point']  = $this->mypageService->getPointList();
        $data['likeProductCount'] = $this->mypageService->getTotalLikeProduct();
        $data['likeCompanyCount'] = $this->mypageService->getTotalLikeCompany();
        $data['recentlyViewedProductCount'] = $this->mypageService->getTotalRecentlyViewedProduct();
        $data['inquiryCount'] = $this->mypageService->getTotalInquiry();

        return view('mypage.mypage', $data);
    }

    /**
     * 탈퇴 처리
     * @return JsonResponse
     */
    public function doWithdrawal(): JsonResponse
    {
        $result = $this->mypageService->withdrawal();
        Auth::logout();
        return response()->json($result);
    }

    /**
     * 일반 회원 정보 수정
     * @param Request $request
     * @return JsonResponse
     */
    public function updateNormalAccount(Request $request): JsonResponse
    {
        return response()->json($this->mypageService->updateNormalAccount($request->all()));
    }

    /**
     * 정회원 신청 페이지
     * @return View
     */
    public function requestRegular(): View
    {
        $data['pageType'] = 'regular';
        $data['user'] = $this->getLoginUser();
        return view('mypage.regular', $data);
    }

    /**
     * 정회원 신청 처리
     * @param Request $request
     * @return JsonResponse
     */
    public function requestRegularForm(Request $request): JsonResponse
    {
        return response()->json($this->mypageService->requestRegular($request->all()));
    }

    /**
     * 로고 이미지 삭제
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteLogoImage(Request $request): JsonResponse
    {
        $imageUrl = $request->input('imageUrl');
        return response()->json($this->mypageService->deleteLogoImage($imageUrl));
    }

    public function getLoginUser()
    {
        if (Auth::user()['type'] === 'W') { // 도매
            $user = User::where('AF_user.idx', Auth::user()['idx'])
                ->join('AF_wholesale','AF_user.company_idx', 'AF_wholesale.idx')
                ->leftJoin('AF_attachment AS attachment', 'attachment.idx', 'AF_user.attachment_idx')
                ->select('AF_user.*', 'AF_wholesale.company_name', 'AF_wholesale.business_license_number', 'AF_wholesale.inquiry_count', 'AF_wholesale.access_count'
                    , DB::raw("(SELECT CASE WHEN COUNT(*) >= 100000000 THEN CONCAT(COUNT(*)/100000000,'억')
                           WHEN COUNT(*) >= 10000000 THEN CONCAT(COUNT(*)/10000000,'천만')
                           WHEN COUNT(*) >= 10000 THEN CONCAT(COUNT(*)/10000, '만')
                           WHEN COUNT(*) >= 1000 THEN CONCAT(COUNT(*)/1000, '천')
                           ELSE COUNT(*) END cnt FROM AF_company_like
                           WHERE company_idx = '".Auth::user()['company_idx']."' AND company_type = '".Auth::user()['type']."'
                    ) AS like_count"), 
                     DB::raw(' COALESCE(CONCAT("'.preImgUrl().'",attachment.folder,"/",attachment.filename), "/img/logo.svg") AS image'))
                ->first();
        } else if (Auth::user()['type'] === 'R') { // 소매
            $user = User::where('AF_user.idx', Auth::user()['idx'])
                ->join('AF_retail', 'AF_user.company_idx', 'AF_retail.idx')
                ->leftJoin('AF_attachment AS attachment', 'attachment.idx', 'AF_user.attachment_idx')
                ->select('AF_user.*', 'AF_retail.company_name', 'AF_retail.business_license_number', 
                    DB::raw(' COALESCE(CONCAT("'.preImgUrl().'",attachment.folder,"/",attachment.filename), "/img/logo.svg") AS image'))
                ->first();
        } else { // 일반
            $user = User::where('AF_user.idx', Auth::user()['idx'])
                ->join('AF_normal', 'AF_user.company_idx', 'AF_normal.idx')
                ->leftJoin('AF_attachment AS attachment', 'attachment.idx', 'AF_user.attachment_idx')
                ->select('AF_user.*', 'AF_normal.namecard_attachment_idx', 
                    DB::raw("AF_normal.name as company_name"), DB::raw("AF_normal.business_license_number as business_license_number"), 
                    DB::raw(' COALESCE(CONCAT("'.preImgUrl().'",attachment.folder,"/",attachment.filename), "/img/logo.svg") AS image'))
                ->first();
        }
        return $user;
    }

    public function getLoginUserByIdx($userIdx)
    {
	$tmpUser = User::where('AF_user.idx', $userIdx)->first();
	    
        if ($tmpUser->type === 'W') { // 도매
            $user = User::where('AF_user.idx', $tmpUser->idx)
                ->join('AF_wholesale','AF_user.company_idx', 'AF_wholesale.idx')
                ->leftJoin('AF_attachment AS attachment', 'attachment.idx', 'AF_user.attachment_idx')
                ->select('AF_user.*', 'AF_wholesale.company_name', 'AF_wholesale.business_license_number', 'AF_wholesale.inquiry_count', 'AF_wholesale.access_count'
                    , DB::raw("(SELECT CASE WHEN COUNT(*) >= 100000000 THEN CONCAT(COUNT(*)/100000000,'억')
                           WHEN COUNT(*) >= 10000000 THEN CONCAT(COUNT(*)/10000000,'천만')
                           WHEN COUNT(*) >= 10000 THEN CONCAT(COUNT(*)/10000, '만')
                           WHEN COUNT(*) >= 1000 THEN CONCAT(COUNT(*)/1000, '천')
                           ELSE COUNT(*) END cnt FROM AF_company_like
                           WHERE company_idx = '".$tmpUser->company_idx."' AND company_type = '".$tmpUser->type."'
                    ) AS like_count"), 
                     DB::raw(' COALESCE(CONCAT("'.preImgUrl().'",attachment.folder,"/",attachment.filename), "/img/logo.svg") AS image'))
                ->first();
        } else if ($tmpUser->type === 'R') { // 소매
            $user = User::where('AF_user.idx', $tmpUser->idx)
                ->join('AF_retail', 'AF_user.company_idx', 'AF_retail.idx')
                ->leftJoin('AF_attachment AS attachment', 'attachment.idx', 'AF_user.attachment_idx')
                ->select('AF_user.*', 'AF_retail.company_name', 'AF_retail.business_license_number', 
                    DB::raw(' COALESCE(CONCAT("'.preImgUrl().'",attachment.folder,"/",attachment.filename), "/img/logo.svg") AS image'))
                ->first();
        } else { // 일반
            $user = User::where('AF_user.idx', $tmpUser->idx)
                ->join('AF_normal', 'AF_user.company_idx', 'AF_normal.idx')
                ->leftJoin('AF_attachment AS attachment', 'attachment.idx', 'AF_user.attachment_idx')
                ->select('AF_user.*', 'AF_normal.namecard_attachment_idx', 
                    DB::raw("AF_normal.name as company_name"), DB::raw("AF_normal.business_license_number as business_license_number"), 
                    DB::raw(' COALESCE(CONCAT("'.preImgUrl().'",attachment.folder,"/",attachment.filename), "/img/logo.svg") AS image'))
                ->first();
        }
        return $user;
    }

    /**
     * 대표 상품 추가/삭제
     * @param int $idx
     * @return JsonResponse
     */
    public function toggleRepresentProduct(int $idx): JsonResponse
    {
        return response()->json($this->mypageService->toggleRepresentProduct($idx));
    }

    /**
     * 업체 좋아요/좋아요해제
     * @param Request $request
     * @return JsonResponse
     */
    public function toggleCompanyLike(Request $request): JsonResponse
    {
        return response()->json($this->mypageService->toggleCompanyLike($request->all()));
    }

    /**
     * 뉴뱃지 체크
     */
    public function getCheckNewBadge(): JsonResponse
    {
        $result['deal'] = $this->mypageService->checkNewBadge('W');
        $result['purchase'] = $this->mypageService->checkNewBadge('R');
        return response()->json($result);
    }




    
    // 견적서 관리 (현황)
    public function getEstimateInfo(): View {
        $data['user'] = $this -> getLoginUser();

        $data['pageType'] = 'estimate';
        $data['info'] = $this -> mypageService -> getEstimateInfo();

        $data['point']  = $this->mypageService->getPointList();
        $data['likeProductCount'] = $this->mypageService->getTotalLikeProduct();
        $data['likeCompanyCount'] = $this->mypageService->getTotalLikeCompany();
        $data['recentlyViewedProductCount'] = $this->mypageService->getTotalRecentlyViewedProduct();
        $data['inquiryCount'] = $this->mypageService->getTotalInquiry();

        return view(getDeviceType().'mypage.mypage', $data);
    }

    // 견적서 관리 (요청한 목록)
    public function getRequestEstimate(Request $request): Response {
        $params['offset'] = $data['offset'] = $request -> input('offset') ?: 1;
        $params['limit'] = $data['limit'] = $this -> limit;
        $params = array_merge($params, $request -> all());

        // 키워드 검색
        switch($request -> input('keywordType')) {
            case 'estimateCode':
                $data['keywordTypeText'] = '요청번호';
                break;
            case 'productName':
                $data['keywordTypeText'] = '상품명';
                break;
            case 'companyName':
                $data['keywordTypeText'] = '판매 업체';
                break;
            default:
                $data['keywordTypeText'] = '전체 유형';
                break;
        }

        $data['user'] = $this -> getLoginUser();
        $data['info'] = $this -> mypageService -> getEstimateInfo();

        $data['pageType'] = 'estimate-request';
        $data['request'] = array_merge($this -> mypageService -> getRequestEstimate($params), $data);

        $data['point']  = $this->mypageService->getPointList();
        $data['likeProductCount'] = $this->mypageService->getTotalLikeProduct();
        $data['likeCompanyCount'] = $this->mypageService->getTotalLikeCompany();
        $data['recentlyViewedProductCount'] = $this->mypageService->getTotalRecentlyViewedProduct();
        $data['inquiryCount'] = $this->mypageService->getTotalInquiry();

        return response() -> view(getDeviceType().'mypage.mypage', $data) -> withCookie(Cookie::forget('cocw'));
    }

    // 견적서 관리 (요청한 상세)
    public function getRequestEstimateDetail(Request $request): JsonResponse {
        $data = $this -> mypageService -> getRequestEstimateDetail($request -> all());

        return 
            response() -> json([
                'result'    => 'success',
                'data'      => $data
            ]);
    }

    // 견적서 관리 (요청받은 목록)
    public function getResponseEstimate(Request $request): Response {
        $params['offset'] = $data['offset'] = $request -> input('offset') ?: 1;
        $params['limit'] = $data['limit'] = $this -> limit;
        $params = array_merge($params, $request -> all());

        // 키워드 검색
        switch($request -> input('keywordType')) {
            case 'estimateCode':
                $data['keywordTypeText'] = '견적번호';
                break;
            case 'productName':
                $data['keywordTypeText'] = '상품명';
                break;
            case 'companyName':
                $data['keywordTypeText'] = '구매 업체';
                break;
            default:
                $data['keywordTypeText'] = '전체';
                break;
        }

        $data['user'] = $this -> getLoginUser();
        $data['info'] = $this -> mypageService -> getEstimateInfo();

        $data['pageType'] = 'estimate-response';
        $data['response'] = array_merge($this -> mypageService -> getResponseEstimate($params), $data);

        $data['point']  = $this->mypageService->getPointList();
        $data['likeProductCount'] = $this->mypageService->getTotalLikeProduct();
        $data['likeCompanyCount'] = $this->mypageService->getTotalLikeCompany();
        $data['recentlyViewedProductCount'] = $this->mypageService->getTotalRecentlyViewedProduct();
        $data['inquiryCount'] = $this->mypageService->getTotalInquiry();

        return response() -> view(getDeviceType().'mypage.mypage', $data) -> withCookie(Cookie::forget('cocw'));
    }

    // 견적서 관리 (요청받은 상세)
    public function getResponseEstimateDetail(Request $request): JsonResponse {
        $data = $this -> mypageService -> getResponseEstimateDetail($request -> all());

        $user = $this -> getLoginUser();

        return 
            response() -> json([
                'result'    => 'success',
                'data'      => $data,
                'user'      => $user
            ]);
    }

    // 견적서 관리 (주문하기 상세)
    public function getRequestOrderDetail() {
        $data['user'] = $this -> getLoginUser();

        $data['now1'] = date('Y년 m월 d일');
        $data['now2'] = date('Y-m-d H:i:s');

        return 
            response() -> json([
                'result'    => 'success',
                'data'      => $data
            ]);
    }

    // 견적서 관리 (주문완료 상세)
    public function getResponseOrderDetail(Request $request): JsonResponse {
        $data = $this -> mypageService -> getResponseOrderDetail($request -> all());

        return 
            response() -> json([
                'result'    => 'success',
                'data'      => $data
            ]);
    }





    // 견적서 관리 (견적서 보내기)
    public function getResponseEstimateMulti(): Response {
        $data['user'] = $this -> getLoginUser();

        $data['pageType'] = 'estimate-response-multi';

        $data['response'] = array_merge($this -> mypageService -> getResponseEstimateMulti($data['user']), $data);
        //echo count($data['response']['list']);
        //dd($data['response']);

        $data['point']  = $this->mypageService->getPointList();
        $data['likeProductCount'] = $this->mypageService->getTotalLikeProduct();
        $data['likeCompanyCount'] = $this->mypageService->getTotalLikeCompany();
        $data['recentlyViewedProductCount'] = $this->mypageService->getTotalRecentlyViewedProduct();
        $data['inquiryCount'] = $this->mypageService->getTotalInquiry();

        return response() -> view(getDeviceType().'mypage.mypage', $data) -> withCookie(Cookie::forget('cocw'));
    }




    
    // 모바일 > '견적 요청서' 생성 (견적서 받는 쪽)
    public function getSendRequestEstimate($idx): Response {
        $data = $this -> mypageService -> getRequestSendEstimate($idx);
        $data['pageType'] = 'estimate-request-send';

        return response() -> view(getDeviceType().'mypage.mypage', $data) -> withCookie(Cookie::forget('cocw'));
    }

    // 모바일 > 받은 '견적 요청서 확인' 생성 (견적서 보내는 쪽)
    public function getSendResponseEstimate($idx): Response {
        $params['estimate_idx'] = $idx;

        $data['user'] = $this -> getLoginUser();
        $data['request'] = $this -> mypageService -> getRequestEstimateDetail($params);
        $data['pageType'] = 'estimate-response-send';

        return response() -> view(getDeviceType().'mypage.mypage', $data) -> withCookie(Cookie::forget('cocw'));
    }

    // 모바일 > 보낸 '견적 요청서' 확인 (견적서 받는 쪽)
    public function getCheckRequestEstimate($idx): Response {
        $params['estimate_idx'] = $idx;

        $data['request'] = $this -> mypageService -> getRequestEstimateDetail($params);
        $data['pageType'] = 'estimate-request-check';

        return response() -> view(getDeviceType().'mypage.mypage', $data) -> withCookie(Cookie::forget('cocw'));
    }

    // 모바일 > 받은 '견적서 확인' 생성 (견적서 받는 쪽)
    public function getSendResponseOrder($idx): Response {
        $estimate = Estimate::find($idx);
        $params['estimate_code'] = $estimate -> estimate_code;
        $params['response_company_type'] = $estimate -> response_company_type;

        $data['user'] = $this -> getLoginUser();
        $data['response'] = $this -> mypageService -> getResponseEstimateDetail($params);
        $data['pageType'] = 'estimate-response-check';

        return response() -> view(getDeviceType().'mypage.mypage', $data) -> withCookie(Cookie::forget('cocw'));
    }

    // 모바일 > 보낸 '견적서 확인' 생성 (견적서 보내는 쪽)
    public function getCheckResponseEstimate($idx): Response {
        $estimate = Estimate::find($idx);
        $params['estimate_code'] = $estimate -> estimate_code;
        $params['response_company_type'] = $estimate -> response_company_type;

        $data['user'] = $this -> getLoginUser();
        $data['response'] = $this -> mypageService -> getResponseEstimateDetail($params);
        $data['pageType'] = 'estimate-check';

        return response() -> view(getDeviceType().'mypage.mypage', $data) -> withCookie(Cookie::forget('cocw'));
    }

    // 모바일 > '주문서 확인' 생성 (견적서 받는 쪽 + 보내는 쪽)
    public function getCheckOrder($code): Response {
        $params['order_code'] = $code;

        $sql = "SELECT * FROM AF_estimate WHERE estimate_code = '".$params['order_code']."'";
        $estimate = DB::select($sql);

        if($estimate[0] -> estimate_state !== 'F') {
            DB::table('AF_estimate')
            -> where('estimate_code', $params['order_code'])
            -> update(['estimate_state' => 'F']);

            $sql = 
                "SELECT * FROM AF_user
                WHERE type = '".$estimate[0] -> request_company_type."' AND company_idx = ".$estimate[0] -> request_company_idx." AND parent_idx = 0";
            $user = DB::select($sql);

            if(count($user) > 0) {
                $this -> pushService -> sendPush(
                    '주문서 확인 알림', '('.$estimate[0] -> response_company_name.') 님이 주문서를 확인했습니다.', 
                    $user[0] -> idx, $type = 5, env('APP_URL').'/mypage/requestEstimate'
                );
            }
        }

        $data['response'] = $this -> mypageService -> getResponseOrderDetail($params);
        $data['pageType'] = 'order-check';

        return response() -> view(getDeviceType().'mypage.mypage', $data) -> withCookie(Cookie::forget('cocw'));
    }





    public function likeProduct(Request $request)
    {
        $data['pageType'] = 'product';
        
        if($request->ajax()) {
            $params['offset'] = $request->offset;
            $params['limit'] = 12;
            $params = array_merge($params, $request -> all());

            $data = $this->tmpLikeService->getInterestProducts($params);
            $data['html'] = view('mypage.inc-like-product-common', $data )->render();

            return response()->json($data);
        }
        
        $data['categoryList'] = $this->productService->getCategoryList();

        return view(getDeviceType().'mypage.likePage', $data);
    }

    public function likeCompany(Request $request)
    {
        $data['pageType'] = 'company';
        
        if($request->ajax()) {
            $params['offset'] = $request->offset;
            $params['limit'] = 12;
            $params = array_merge($params, $request -> all());

            $data = array_merge($data , $this->tmpLikeService->getLikeCompanies($params));
            $data['html'] = view(getDeviceType().'mypage.inc-like-company-common', $data)->render();

            return response()->json($data);
        }

        $data['categoryList'] = $this->productService->getCategoryList();

        return view(getDeviceType().'mypage.likePage', $data);
        
    }


    public function saveProductOrderRepresents(Request $request): Response
    {
        return response($this->mypageService->saveProductOrder($request->all(), 'represent'), 200);
    }
    public function saveProductOrderNormal(Request $request): Response
    {
        return response($this->mypageService->saveProductOrder($request->all(), 'normal'), 200);
    }

    // 견적서 관리 (요청한 상세)
    public function getRequestEstimateDevDetail(Request $request): JsonResponse {
        $data = [];
        $data['lists'] = $this -> mypageService -> getRequestEstimateDetail($request -> all());
        
        return
            response() -> json([
                'result'    => 'success',
                'data'      => $data,
                'html'      => view(getDeviceType().'mypage.inc-estimate-response', $data )->render()
            ]);
    }

    // 받은 견적서 관리 (견적 내용 상세)
    public function getResponseEstimateDevDetail(Request $request): JsonResponse {
        $data = [];
        $data['lists'] = $this -> mypageService -> getRequestEstimateDetail($request -> all());
        
        return
            response() -> json([
                'result'    => 'success',
                'data'      => $data,
                'html'      => view(getDeviceType().'mypage.inc-estimate-response-check', $data )->render()
            ]);
    }

    // 주문서 작성 화면
    public function getTempOrderDetail(Request $request): JsonResponse {
        $data = [];
        $data['lists'] = $this -> mypageService -> getRequestEstimateDetail($request -> all());
        
        return
            response() -> json([
                'result'    => 'success',
                'data'      => $data,
                'html'      => view(getDeviceType().'mypage.inc-estimate-order', $data )->render()
            ]);
    }

    // 주문 신청된 내역 화면
    // NOTICE: getTempOrderDetail 와 동일한 요청으로 개발되었으나, 함수 분기 이유는 추후 변경될 경우 화면이 달라 
    public function getOrderDetail(Request $request): JsonResponse {
        $data = [];
        $data['lists'] = $this -> mypageService -> getRequestEstimateDetail($request -> all());
        
        return
            response() -> json([
                'result'    => 'success',
                'data'      => $data,
                'html'      => view(getDeviceType().'mypage.inc-estimate-order', $data )->render()
            ]);
    }
	
	
	/* 마이페이지 회원구분 수정 */
	public function updateMemberType(Request $request)
	{
		$request->validate([
			'member_type' => 'required|in:R,W',
		]);

		$user = Auth::user();
		
		// 데이터베이스에 회원구분 업데이트
		// 실제 컬럼명은 데이터베이스 스키마에 따라 다를 수 있습니다
		$user->type = $request->member_type;
		$user->save();
		
		return response()->json([
			'success' => true,
			'message' => '회원구분이 성공적으로 저장되었습니다.'
		]);
	}


    /**
     * 계정 구분 변경을 위한 데이터 조회
     * @return JsonResponse
     */
    public function getCompanyAjax(): JsonResponse {
    	$data = [];
        
        $data['user'] = $this -> getLoginUser();
        $user_type = Auth::user()['type'];

        $nameCardImage = $this->mypageService->getUserNameCard();
        $data['nameCardImage'] = $nameCardImage ?? '';
        $data['point'] = $this->mypageService->getPointList();
        $data['info'] = $this -> mypageService -> getEstimateInfo();
        $xtoken = $this->loginService->getFcmToken(Auth::user()['idx']);
        $data['xtoken'] = $xtoken;
        
        $data['pageType'] = 'company-account-new';
        $data['company'] = $this -> mypageService -> getCompanyAccount();
        $data['members'] = $this -> mypageService -> getCompanyMembers();

        $data['likeProductCount'] = $this->mypageService->getTotalLikeProduct();
        $data['likeCompanyCount'] = $this->mypageService->getTotalLikeCompany();
        $data['recentlyViewedProductCount'] = $this->mypageService->getTotalRecentlyViewedProduct();
        $data['inquiryCount'] = $this->mypageService->getTotalInquiry();

        return
            response() -> json([
                'result'    => 'success',
                'data'      => $data
            ]);
    }

    /**
     * 계정 구분 변경을 위한 데이터 조회
     * @return JsonResponse
     */
    public function getCompanyAjaxByIdx($userIdx): JsonResponse {
    	$data = [];
        
        $user = $this -> getLoginUserByIdx($userIdx);

        $tmpAttachment = $this->memberService->getDefaultBusinessAttachmentAndNumber();
        $upgrade_json = (array)json_decode($user->upgrade_json);
        if(! array_key_exists('business_license_number', $upgrade_json)) {
            $upgrade_json['business_license_number'] = $tmpAttachment['bussinessCode'];
        }
        if(! array_key_exists('business_code', $upgrade_json)) {
            $upgrade_json['business_code'] = $tmpAttachment['bussinessCode'];
        }
        if(! array_key_exists('attachmentIdx', $upgrade_json) || empty($upgrade_json['attachmentIdx'])) {
            $upgrade_json['attachmentIdx'] = $tmpAttachment['attachmentIdx'];
        }
        if(! array_key_exists('userAttachmentIdx', $upgrade_json)) {
            $upgrade_json['userAttachmentIdx'] = $tmpAttachment['attachmentIdx'];
        }
        
        if(! array_key_exists('license_image', $upgrade_json)) {
            if(array_key_exists('attachmentIdx', $upgrade_json)) {
                $upgrade_json['license_image'] = $this->mypageService->getUserImageByIdx($upgrade_json['attachmentIdx']);
            } else {
                $upgrade_json['license_image'] = $tmpAttachment['licenseImage'];
            }
        }
        $user->upgrade_json = json_encode($upgrade_json);
        $data['user'] = $user;

        $user_type = $data['user']->type;

        $nameCardImage = $this->mypageService->getUserNameCardByIdx($data['user']->company_idx);
        $data['nameCardImage'] = $nameCardImage ?? '';
        $data['point'] = $this->mypageService->getPointListByIdx($data['user']->idx);
        $data['info'] = $this -> mypageService -> getEstimateInfoByIdx($data['user']->idx);
        $xtoken = $this->loginService->getFcmToken($userIdx);
        $data['xtoken'] = $xtoken;
        
        $data['pageType'] = 'company-account-new';
        $data['company'] = $this -> mypageService -> getCompanyAccountByUser($data['user']);
        $data['members'] = $this -> mypageService -> getCompanyMembers($data['user']->idx);

        $data['likeProductCount'] = $this->mypageService->getTotalLikeProductByIdx($data['user']->idx);
        $data['likeCompanyCount'] = $this->mypageService->getTotalLikeCompanyByIdx($data['user']->idx);
        $data['recentlyViewedProductCount'] = $this->mypageService->getTotalRecentlyViewedProductByIdx($data['user']->idx);
        $data['inquiryCount'] = $this->mypageService->getTotalInquiryByIdx($data['user']->company_idx);

        return
            response() -> json([
                'result'    => 'success',
                'data'      => $data
            ]);
    }
}