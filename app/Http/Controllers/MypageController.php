<?php

namespace App\Http\Controllers;

use App\Models\User;
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
use \Exception;
use Session;

class MypageController extends BaseController
{
    private $mypageService;
    private $limit = 20;
    private $user;
    public function __construct(MypageService $mypageService)
    {
        $this->mypageService = $mypageService;
    }

    public function index(): RedirectResponse
    {
        if (Auth::user()['type'] === 'W') {
            return redirect()->route('mypage.deal');
        } else if (Auth::user()['type'] === 'R') {
            return redirect()->route('mypage.purchase');
        } else {
            return redirect()->route('mypage.interest');
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

        if($this -> user == null) { $this -> getLoginUser(); }
        $data['user'] = $this -> getLoginUser();

        $data['pageType'] = 'deal';
        $data['dealStatus'] = config('constants.ORDER.STATUS.S');
	$data = array_merge($this -> mypageService -> getOrderList($params), $data); 
	$data['xtoken'] = session()->get('token');

        return response() -> view(getDeviceType() . 'mypage.mypage', $data) -> withCookie(Cookie::forget('cocw'));
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
        $data['pageType'] = 'purchase';
        $data['user'] = $this->getLoginUser();

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
	 $data['xtoken'] = session()->get('token');
        return response()->view(getDeviceType() . 'mypage.mypage', $data)->withCookie(Cookie::forget('cocr'));
    }

    /**
     * 일반 유저 마이페이지
     * @return View
     */
    public function normal(): View
    {
        $data['pageType'] = 'normal';
        $data['user'] = $this->getLoginUser();

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
                $data['detailTitle'] = '거래';
            } else {
                $data['loginCompanyName'] = $this->mypageService->getOrderProductSellerName($request->all());
                $data['detailTitle'] = '주문';
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

        return view('mypage.order-detail', $data);
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
        $data['orders'] = $this->mypageService->getOrderDetail($request->all());

        return view('mypage.order-cancel', $data);
    }

    /**
     * 관심 상품
     * @param Request $request
     * @return View
     */
    public function interest(Request $request): View {
        $params['offset'] = $data['offset'] = $request -> input('offset') ?: 1;
        $params['limit'] = $data['limit'] = 40;
        $params = array_merge($params, $request -> all());

        $data['checked_categories'] = [];
        if(isset($params['categories'])) {
            $data['checked_categories'] = explode(',', $params['categories']);
        }

        $data['pageType'] = 'interest';
        $data['user'] = $this -> getLoginUser();
        $data['categories'] = $this->mypageService->getCategories();
        $data['folders'] = $this -> mypageService -> getMyFolders();
        $data = array_merge($data, $this -> mypageService -> getInterestProducts($params));

	 $data['xtoken'] = session()->get('token');
        return view(getDeviceType() . 'mypage.mypage', $data);
    }

    /**
     * 좋아요
     * @param Request $request
     * @return View
     */
    public function like(Request $request): View {
        $params['offset'] = $data['offset'] = $request -> input('offset') ?: 1;
        $params['limit'] = $data['limit'] = 40;
        $params = array_merge($params, $request -> all());

        $data['checked_categories'] = [];
        if(isset($params['categories'])) {
            $data['checked_categories'] = explode(',', $params['categories']);
        }

        $data['pageType'] = 'like';
        $data['user'] = $this -> getLoginUser();
        $data['categories'] = $this -> mypageService -> getCategories();
        $data['regions'] = $request -> input('regions') ? explode(',', $request -> input('regions')) : [];
        $data = array_merge($data, $this -> mypageService -> getLikeCompanies($params));

        return view('mypage.mypage', $data);
    }

    /**
     * 최근 본 상품
     * @param Request $request
     * @return View
     */
    public function recent(Request $request): View {
        $params['offset'] = $data['offset'] = $request -> input('offset') ?: 1;
        $params['limit'] = $data['limit'] = 40;
        $params = array_merge($params, $request -> all());

        $data['checked_categories'] = [];
        if(isset($params['categories'])) {
            $data['checked_categories'] = explode(',', $params['categories']);
        }

        $data['pageType'] = 'recent';
        $data['user'] = $this -> getLoginUser();
        $data['categories'] = $this -> mypageService -> getCategories();
        $data = array_merge($data, $this -> mypageService -> getRecentProducts($params));

        return view('mypage.mypage', $data);
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
     * 홈페이지 관리
     * @return View
     */
    public function company(): View {
        $data['user'] = $this -> getLoginUser();
        
        $data['pageType'] = 'company';
        $data['info'] = $this -> mypageService -> getCompany();

        return view('mypage.mypage', $data);
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

        return view('mypage.mypage', $data);
    }

    /**
     * 계정 관리
     * @return View
     */
    public function account(): View
    {
        $data['user'] = $this->getLoginUser();
        $data['pageType'] = 'account';
        return view('mypage.mypage', $data);
    }

    /**
     * 일반 계정
     * @return View
     */
    public function normalAccount(): View
    {
        if (Auth::user()['type'] === 'N') {
            $data['user'] = $this->getLoginUser();
            $data['pageType'] = 'normal-account';
            $nameCardImage = $this->mypageService->getUserNameCard();
            $data['nameCardImage'] = $nameCardImage ?? '';
            return view('mypage.mypage', $data);
        } else {
            return redirect()->route('signOut');
        }
    }

    /**
     * 업체 관리 수정 페이지
     * @return View
     */
    public function editCompany(): View
    {
        $data['user'] = $this->getLoginUser();
        $data['info'] = $this->mypageService->getCompany();

        return view('mypage.company-edit', $data);
    }

    /**
     * 회사 소개 이미지 업로드
     * @param Request $request
     * @return Response
     */
    public function uploadCompanyIntroduceImage(Request $request): Response
    {
        $request->validate([
            'images' => 'image|mimes:png,jpg,jpeg|max:2048'
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
        return response()->json($this->mypageService->updateCompany($params));
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
     * 업체 계정 상세 페이지
     * @return View
     */
    public function companyAccount(): View {
        
        $data['user'] = $this->getLoginUser();
        
        $user_type = Auth::user()['type'];
        
        Log::debug("----- user : $user_type");
        
        if ( $user_type === 'N' || $user_type === 'S' ) {
            
            $data['pageType'] = 'normal-account';
            
        } else {
            
            $data['pageType'] = 'company-account';

            $data['company'] = $this->mypageService->getCompanyAccount();
            $data['members'] = $this->mypageService->getCompanyMembers();
        }

        return view('mypage.mypage', $data);
        
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
                ->select('AF_user.*', 'AF_wholesale.company_name', 'AF_wholesale.inquiry_count', 'AF_wholesale.access_count'
                    , DB::raw("(SELECT CASE WHEN COUNT(*) >= 100000000 THEN CONCAT(COUNT(*)/100000000,'억')
                           WHEN COUNT(*) >= 10000000 THEN CONCAT(COUNT(*)/10000000,'천만')
                           WHEN COUNT(*) >= 10000 THEN CONCAT(COUNT(*)/10000, '만')
                           WHEN COUNT(*) >= 1000 THEN CONCAT(COUNT(*)/1000, '천')
                           ELSE COUNT(*) END cnt FROM AF_company_like
                           WHERE company_idx = '".Auth::user()['company_idx']."' AND company_type = '".Auth::user()['type']."'
                    ) AS like_count"))
                ->first();
        } else if (Auth::user()['type'] === 'R') { // 소매
            $user = User::where('AF_user.idx', Auth::user()['idx'])
                ->join('AF_retail', 'AF_user.company_idx', 'AF_retail.idx')
                ->select('AF_user.*', 'AF_retail.company_name')
                ->first();
        } else { // 일반
            $user = User::where('AF_user.idx', Auth::user()['idx'])
                ->join('AF_normal', 'AF_user.company_idx', 'AF_normal.idx')
                ->select('AF_user.*', 'AF_normal.namecard_attachment_idx')
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

        return view('mypage.mypage', $data);
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
                $data['keywordTypeText'] = '전체';
                break;
        }

        $data['user'] = $this -> getLoginUser();
        $data['pageType'] = 'estimate-request';

        $data['info'] = $this -> mypageService -> getEstimateInfo();
        $data['request'] = array_merge($this -> mypageService -> getRequestEstimate($params), $data);

        return response() -> view('mypage.mypage', $data) -> withCookie(Cookie::forget('cocw'));
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
        $data['pageType'] = 'estimate-response';

        $data['info'] = $this -> mypageService -> getEstimateInfo();
        $data['response'] = array_merge($this -> mypageService -> getResponseEstimate($params), $data);

        return response() -> view('mypage.mypage', $data) -> withCookie(Cookie::forget('cocw'));
    }

    // 견적서 관리 (요청받은 상세)
    public function getResponseEstimateDetail(Request $request): JsonResponse {
        $data = $this -> mypageService -> getResponseEstimateDetail($request -> all());

        return 
            response() -> json([
                'result'    => 'success',
                'data'      => $data
            ]);
    }
}