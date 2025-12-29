<?php

namespace App\Http\Controllers;

use App\Service\ProductService;
use App\Service\WholesalerService;
use App\Service\PushService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Session;

class CatalogController extends BaseController
{
    private $wholesalerService;
    private $productService;
    private $pushService;

    public function __construct(WholesalerService $wholesalerService, ProductService $productService, PushService $pushService)
    {
        $this->wholesalerService = $wholesalerService;
        $this->productService = $productService;
        $this->pushService = $pushService;
    }

    public function catalog(Request $request, int $wholesalerIdx)
    {
        $data['wholesalerIdx'] = $wholesalerIdx;
        $categoryList = $this->productService->getCategoryList();

        $todayCount = $this->productService->getTodayCount();
        
        $data = $this->wholesalerService->detailByCatalog($data);
        $data['info']->place = substr( $data['info']->business_address, 0, 6 );

        return view('wholesaler.catalog', [
            'todayCount'=>$todayCount,
            'categoryList'=>$categoryList,
            'data'=>$data
        ]);
    }

    public function wholesalerInfoJson(Request $request, int $wholesalerIdx)
    {
        $data['wholesalerIdx'] = $wholesalerIdx;
        
        $data = $this->wholesalerService->detailByCatalog($data);
        $data['info']->place = substr( $data['info']->business_address, 0, 6 );

        return response()->json($data);
    }

    // 업체 카테고리 상품 가져오기
    public function wholesalerAddProduct(Request $request)
    {
        $data['categories'] = $request->categories == null ? "" : $request->categories;
        switch($request->orderedElement){
            case "access_count":
                $data['orderedElement'] = 'access_count';
                break;

            case "register_time" : 
                $data['orderedElement'] = 'register_time';
                break;

            case "popularity" : 
                $data['orderedElement'] = 'popularity';
                break;

            default:
                $data['orderedElement'] = 'custom_orders';
                break;
        }
        $data['company_idx'] = $request->company_idx;

        $list = $this->productService->getWholesalerAddedProductListByCatalog($data);
        $list['html'] = view('wholesaler.inc-catalog-common', ['list' => $list])->render();
        return response()->json($list);
    }

    // 상품 상세 데이터 가져오기
    public function productDetail(int $wholesalerIdx, int $productIdx)
    {
        $product = $this->productService->getProductDataByCatalog($productIdx);
        
        $data['wholesalerIdx'] = $wholesalerIdx;
        $data = $this->wholesalerService->detailByCatalog($data);
        $data['info']->place = substr( $data['info']->business_address, 0, 6 );
        $data['detail'] = str_replace('\"', '', str_replace('width: 300px;', 'width: fit-content;',html_entity_decode($product['detail']->product_detail)));

        return view('wholesaler.catalog-product', [
            'data'=>$data
        ]);
    }

    // 상품/업체 - 사용자 이력성 데이터 저장
    public function saveUserAction(Request $request)
    {
        $data['response_user_id'] = $request->query('company_idx');
        $data['response_user_type'] = $request->query('company_type');
        $data['product_idx'] = $request->query('product_idx');
        $data['request_type'] = $request->query('request_type');

        if($userAction->request_type > 3) {
            // 카탈로그 액션 (4: 보내기, 5: 공유하기, 6:받기)
            $companyIdx = $data['response_user_id'];
            $company = $this->wholesalerService->getCompanyDetailByCatalog($companyIdx);
            
            array_push($receiver, str_replace("-", "", $company->phone_number));

            $sreq = [];
            $sreq['회원명'] = '*****'; // 받는 이 가입 여부 알 수 없음. 콜백 없음 (추후 개발 필요할 수 있음)
            $sreq['올펀상품링크'] = env('APP_URL') . '/wholesaler/detail/' . $companyIdx;
            $sreq['올펀카탈로그링크'] = env('APP_URL') . '/catalog/' . $companyIdx;
            $result[] = $receiver;
            $result[] = response()->json($this->pushService->sendKakaoAlimtalk(
                'UE_4210', '[카탈로그 열람 알림]', $sreq, $receiver, null));
        }
        
        return response()->json($this->productService->saveUserAction($data));
    }
}
