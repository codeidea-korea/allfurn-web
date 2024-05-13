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
        // $target['orderedElement'] =  $request->orderedElement == null ? "banner_price" : str_replace("filter_", "", $request->orderedElement);
        // $data = $this->wholesalerService->getWholesalerData($target);

        //인기브랜드(광고)
        $popularbrand_ad = $this->wholesalerService->getPopularBrand();
        
        //띠배너
        $bannerList = $this->productService->getThisDealList('wholesaletop');

        //이달의 도매
        $thisMonthParam['limit'] = 50;
        $thisMonthParam['orderElement'] = 'recommendation';
        $thisMonthWholesaler = $this->wholesalerService->getThisMonthWholesaler($thisMonthParam);

        //도매업체 순위
        $wholesalerRankParam['limit'] = 20;
        $wholesalerRankParam['orderedElement'] = 'recommendation';
        $wholesalerRank = $this->wholesalerService->getWholesalerList($wholesalerRankParam);
        
        $categoryList = $this->productService->getCategoryList();
        
        return view(getDeviceType().'wholesaler.index', [
            'data' => $popularbrand_ad,
            'bannerList'    => $bannerList, // 띠배너
            'companyList'   => $thisMonthWholesaler, //이달의 도매
            'companyProduct'=> $wholesalerRank, //도매업체 순위
            'categoryList'  => $categoryList,
        ]);
    }

    public function getWholesalerList(Request $request)
    {
        $data = $request->all();
        $data['limit'] = 10;
        $data['list'] = $this->wholesalerService->getWholesalerList($data);
        $data['html'] = view( getDeviceType(). 'wholesaler.inc-wholesalerList-common', ['list' => $data['list']])->render();

        return response()->json($data);
    }

    // 도매업체 상세정보 가져오기
    public function detail(Request $request, int $wholesalerIdx)
    {

        $data['wholesalerIdx'] = $wholesalerIdx;
        $categoryList = $this->productService->getCategoryList();

        $todayCount = $this->productService->getTodayCount();
        
        $data = $this->wholesalerService->detail($data);
        $data['info']->place = substr( $data['info']->business_address, 0, 6 );

        return view(getDeviceType().'wholesaler.detail', [
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

        return view(getDeviceType().'wholesaler.searchBy', [
            'data'=>$data,
            'query'=>$query,
            'categoryList'=>$categoryList,
        ]);
    }

    public function listBySearchAjax(Request $request){
        $data['keyword'] = $request->query('keyword');
        $data['categories'] = $request->categories == null ? "" : $request->categories;
        $data['locations'] = $request->locations == null ? "" : $request->locations;
        $data['orderedElement'] = $request->orderedElement == null ? "" : $request->orderedElement;

        $list = $this->wholesalerService->listByCategoryAjax($data);

        $html = view( getDeviceType(). 'wholesaler.inc-wholesalerList-common', ['list' => $list])->render();
        //$modalHtml = view(getDeviceType() . 'product.inc-product-modal-common', ['product' => $list])->render();
        $list['html'] = $html;
        //$list['modalHtml'] = $modalHtml;

        return response()->json($list);
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
                $data['orderedElement'] = 'access_date';
                break;

            default:
                $data['orderedElement'] = 'popularity';
                break;
        }
        $data['company_idx'] = $request->company_idx;

        $list = $this->productService->getWholesalerAddedProductList($data);
        $list['html'] = view('product.inc-product-common', ['list' => $list])->render();
        return response()->json($list);
    }
    
    public function getThisMonthWholesaler()
    {
        $target['limit'] = 50;
        $data = $this->wholesalerService->getThisMonthWholesaler($target);
        return view(getDeviceType().'wholesaler.thisMonth', [ 'wholesalerList' => $data]);
    }
}
