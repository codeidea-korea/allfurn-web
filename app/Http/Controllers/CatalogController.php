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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Session;

class CatalogController extends BaseController
{
    private $wholesalerService;
    private $productService;

    public function __construct(WholesalerService $wholesalerService, ProductService $productService)
    {
        $this->wholesalerService = $wholesalerService;
        $this->productService = $productService;
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

            default:
                $data['orderedElement'] = 'popularity';
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
}
