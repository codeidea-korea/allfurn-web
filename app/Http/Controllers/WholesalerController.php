<?php

namespace App\Http\Controllers;

use App\Service\ProductService;
use App\Service\WholesalerService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Session;

class WholesalerController extends BaseController
{
    private $wholesalerService;
    private $productService;

    public function __construct(WholesalerService $wholesalerService, ProductService $productService)
    {
        $this->middleware('auth');
        $this->wholesalerService = $wholesalerService;
        $this->productService = $productService;
    }

    /**
     * 도매업체 리스트 가져오기
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $target['orderedElement'] =  $request->orderedElement == null ? "banner_price" : str_replace("filter_", "", $request->orderedElement);
        $data = $this->wholesalerService->getWholesalerData($target);
        $categoryList = $this->productService->getCategoryList();

        $bannerList = $this->productService->getThisDealList('dealmiddle');

        // $companyList = $this->productService->getThisMonth('product');
        // $companyList = setArrayNumer( $companyList );
        $companyList = $this->wholesalerService->getThisMonthWholesaler($target);

        $company = $this->wholesalerService->getThisMonthWholesaler($target);

        return view(getDeviceType().'wholesaler.index', [
            'data'=>$data,
            'categoryList'  => $categoryList,
            'bannerList'    => $bannerList,
            'companyList'   => $companyList,
            'companyProduct'=> $company,
            'query'         => $target
        ]);
    }

    // 도매업체 상세정보 가져오기
    public function detail(Request $request, int $wholesalerIdx)
    {

        $data['wholesalerIdx'] = $wholesalerIdx;
        $data['sort'] = $request->query('so');

        // 상단 배너
        $banners = $this->productService->getBannerList();
        $categoryList = $this->productService->getCategoryList();
        $todayCount = $this->productService->getTodayCount();

        $data = $this->wholesalerService->detail($data);

        $data['info']->place = substr( $data['info']->business_address, 0, 6 );

        return view(getDeviceType().'wholesaler.detail', [
            'banners'=>$banners,
            'todayCount'=>$todayCount,
            'categoryList'=>$categoryList,
            'data'=>$data
        ]);
    }

    // 도매업체 모아보기
    public function gather()
    {
        $data = $this->wholesalerService->getWholesalerData();

        return view('wholesaler.gether', [
            'data'=>$data
        ]);
    }

    public function likeToggle(int $wholesalerIdx)
    {
        if ($wholesalerIdx == null) { return; }

        return $this->wholesalerService->likeToggle($wholesalerIdx);
    }

    // 도메업체 > BEST 신상품
    public function best()
    {
        $product = $this->productService->getThisDealList('plandiscount');

        return view('wholesaler.best', [
            'productList'   => $product
        ]);
    }


    // 키워드 검색 (도애업체)
    public function listBySearch(Request $request) {
        
        $query['keyword'] = $request->query('kw');
        $query['category'] = $request->query('ca');
        $query['location'] = $request->query('lo');
        $query['sort'] = $request->query('so');

        $data = $this->wholesalerService->getWholesalerData($query);
        $categoryList = $this->productService->getCategoryList();

        return view('wholesaler.searchBy', [
            'data'=>$data,
            'query'=>$query,
            'categoryList'=>$categoryList,
        ]);
        
    }

    // 업체 카테고리 상품 가져오기
    public function wholesalerAddProduct(Request $request)
    {
        $data['categories'] = $request->categories == null ? "" : $request->categories;
        $data['orderedElement'] =  $request->orderedElement == null ? "banner_price" : str_replace("filter_", "", $request->orderedElement);
        $data['company_idx'] = $request->company_idx;

        $list = $this->productService->getWholesalerAddedProductList($data);

        if( !empty( $list ) )
            return response()->json($list);
        else
            return false;
    }
    
    public function getThinMonthWholesaler()
    {
        $data = $this->wholesalerService->getThinMonthWholesaler(50);
        return view(getDeviceType().'wholesaler.thisMonth', $data);
    }
}
