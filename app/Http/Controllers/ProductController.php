<?php

namespace App\Http\Controllers;

use App\Service\HomeService;
use App\Service\ProductService;
use App\Service\WholesalerService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Session;
use function Symfony\Component\Translation\t;
use App\Models\Banner;
use Carbon\Carbon;

class ProductController extends BaseController
{
    private $productService;
    private $homeService;
    public function __construct(ProductService $productService, HomeService $homeService)
    {
        $this->middleware('auth');
        $this->productService = $productService;
        $this->homeService = $homeService;
    }

    // 상품 수정 - 상품 정보 가져오기
    public function modify(int $productIdx, Request $request)
    {
        $type = $request->get('type') ?? '' ;

        return view('product.product-registration', [
            'productIdx' => $productIdx,
            'data' => $this->productService->getProductData($productIdx, $type)['detail'],
            'categoryList' => $this->getCategoryList(),
            'productList' => $this->getMyProductList()
        ]);
    }


    // 상품 정보 가져오기
    public function getProductData(int $productIdx, Request $request)
    {
        $type = $request->get('type') ?? '';
        $data = $this->productService->getProductData($productIdx, $type);

        return response()->json([
            'success'=>true,
            'data'=>$data
        ]);
    }

    /**
     * 상품 카테고리 리스트 가져오기
     * @param int $parentIdx
     * @return mixed
     */
    public function getCategoryList(int $parentIdx = 0)
    {
        return $this->productService->getCategoryList($parentIdx);
    }

    // 상품 카테고리 리스트 가져오기 리뉴얼 : 2뎁스까지 한번에 가져옴. (코드아이디어)
    public function getCategoryListV2()
    {
        return $this->productService->getCategoryListV2();
    }

    /**
     * 상품 카테고리 속성 가져오기
     * @param Request $request
     * @return mixed
     */
    public function getCategoryProperty(Request $request)
    {
        $data['category_idx'] = $request->category_idx;
        $data['parent_idx'] = $request->parent_idx;
        return $this->productService->getCategoryProperty($data);
    }


    /**
     * 상품 등록
     * @param Request $request
     * @return JsonResponse
     */
    public function saveProduct(Request $request) {
        
        $data = $request->all();

        if (isset($data['files'])) {
            $attachmentIdx = '';
            foreach ($data['files'] as $file) {
                if(is_file($file)) {
                    $filePath = $file->store('product', 's3');
                    $attachmentIdx .= $this->productService->saveAttachment($filePath).',';
                }
            }

            if (isset($data['attachmentIdx'])) {
                $data['attachmentIdx'] .= ','.substr($attachmentIdx, 0,-1);
            } else {
                $data['attachmentIdx'] = substr($attachmentIdx, 0,-1);
            }
        }

        if ($request->input('reg_type') == '2') {
            $prductIdx = $this->productService->modify($data);
        } else {
            $prductIdx = $this->productService->create($data);
        }

        return response()->json([
            'success'=>$prductIdx != null ? true : false,
        ]);
    }



    /**
     * 상품 등록 - 대 카테고리 / 내가 등록한 상품 정보 리스트 가져오기
     * @return Application|Factory|View
     */
    public function registration()
    {

        return view('product.product-registration', [
            'banners'=>$this->productService->getBannerList(),
            'todayCount'=>$this->productService->getTodayCount(),
            'categoryList'=> $this->productService->getCategoryList(),
            'productList'=> $this->getMyProductList()
        ]);
    }

    /**
     * 상품 수정
     * @param Request $request
     * @return JsonResponse
     */
    public function modifyProduct(Request $request)
    {
        return response()->json([
            'success'=> true,
        ]);
    }

    // 내가 등록한 상품 리스트 가져오기
    public function getMyProductList()
    {
        return $this->productService->getMyProductList();
    }

    public function getProductList(int $userIdx)
    {
        return $this->productService->getProductList($userIdx);
    }

    // 상품 옵션 가져오기
    public function getOption(int $productIdx)
    {
        return $this->productService->getProductOption($productIdx);
    }

    // 상품 등록/수정 - 에디터 이미지 등록
    public function imageUpload(Request $request)
    {
        $file = $request->file('file')->store($request->folder, 's3');
        $imgIdx = $this->productService->saveAttachment($file);

        return response()->json([
            'link' => preImgUrl().$file,
            'idx' => $imgIdx
        ]);
    }

    // 상품 등록/수정 - 에디터 이미지 삭제
    public function imageDelete(Request $request)
    {
        $imgPath = ($request->src).str_replace(env.AWS_S3_URL, '');
        Storage::disk('s3')->delete($imgPath);

        $this->productService->deleteImage($request->idx);

        return response()->json([
            'success' => true
        ]);
    }

    // 상품 즐겨찾기
    public function interestToggle(int $productIdx)
    {
        if ($productIdx == null) { return; }

        return $this->productService->interestToggle($productIdx);
    }


    // 신상품 데이터 가져오기
    public function newProduct(Request $request)
    {
        // 상단 배너
        $banners = $this->productService->getBannerList();
        $categoryList = $this->productService->getCategoryList();
        $todayCount = $this->productService->getTodayCount();

        // $data['target'] = $request->query('ca') != null ? $request->query('ca') : "ALL";
        // $list = $this->productService->getNewProductList($data);

        $data['categories'] = $request->categories == null ? "" : $request->categories;
        $data['orderedElement'] =  $request->orderedElement == null ? "register_time" : str_replace("filter_", "", $request->orderedElement);
        $list = $this->productService->getNewAddedProductList($data);
        $total = $list->total();

        $bestNewProducts = $this->productService->getBestNewProductList();
        $company = $this->productService->getRecentlyAddedProductCompanyList();

        return view('product.newProduct', [
            'banners'=>$banners,
            'todayCount'=>$todayCount,
            'categoryList'=>$categoryList,
            'list'=>$list,
            'bestNewProducts' => $bestNewProducts,
            'company' => $company,
            'total'=>$total,
        ]);
    }


    /** 베스트 신상품 가져오기 */
    public function bestNewProduct(Request $request)
    {
        $bestNewProducts = $this->productService->getBestNewProductList();
        return view('product.best-new-product', [
            'bestNewProducts' => $bestNewProducts,
        ]);
    }

    // 신규 등록 상품 가져오기
    public function newAddedProduct(Request $request)
    {
        $data['categories'] = $request->categories == null ? "" : $request->categories;
        $data['orderedElement'] =  $request->orderedElement == null ? "register_time" : str_replace("filter_", "", $request->orderedElement);
        $list = $this->productService->getNewAddedProductList($data);

        return response()->json($list);
    }


    // 상품 상세 데이터 가져오기
    public function detail(int $productIdx) {
        $data = $this->productService->getProductData($productIdx);

        $propArray = [];
        foreach ($data['detail']->propertyList as $list) {
            if (isset($propArray[$list->parent_name])) {
                $propArray[$list->parent_name] .= ', ' . $list->property_name;
            } else {
                $propArray[$list->parent_name] = $list->property_name;
            }
        }
        
        // 인증정보 Property에 추가.
        // Log::debug("-------- auth_info ::: {} ");
        if ($data['detail']->auth_info !== '' && isSet($data['detail']->auth_info)) {
            $propArray["인증정보"] =  $data['detail']->auth_info;
        }

        $data['detail']->propertyArray = $propArray;

        // 신상품 처리 최근등록일 기준 ( 30일 )
        $date1 = Carbon::parse( $data['detail']->register_time);
        $date2 = Carbon::parse( now() );

        $data['detail']->diff = $date1->diffInDays($date2);

        // 상단 배너
        $banners = $this->productService->getBannerList();
        $categoryList = $this->productService->getCategoryList();
        $todayCount = $this->productService->getTodayCount();

        return view('product.detail', [
            'banners'=>$banners,
            'todayCount'=>$todayCount,
            'categoryList'=>$categoryList,
            'data'=>$data
        ]);
    }


    // 카테고리 검색 (상품 리스트 가져오기)
    public function listByCategory(Request $request) {
        
        $data['categoryIdx'] = $request->query('ca');
        $data['parentIdx'] = $request->query('pre');
        $data['property'] = $request->query('prop');
        $data['sort'] = $request->query('so');
        $data['jn'] = $request->query('jn');

        if( $data['jn'] ) {

            $categoryList = $this->productService->getCategoryAll();
            $cateArray = array();

            foreach($categoryList as $category) {
                if( $category->parent_idx ) {
                    $cateArray[$category->parent_idx][$category->idx]['idx'] = $category->idx;
                    $cateArray[$category->parent_idx][$category->idx]['name'] = $category->name;
                } else {
                    $cateArray[$category->idx]['idx'] = $category->idx;
                    $cateArray[$category->idx]['name'] = $category->name;
                }
            }

            $cateChoiceName = '';
            if( $data['parentIdx'] ) {
                $cateChoiceName .= $cateArray[$data['parentIdx']]['name'];
                $cateChoiceName .= ' > '.$cateArray[$data['parentIdx']][$data['categoryIdx']]['name'];
            } else {
                $cateChoiceName .= $cateArray[$data['categoryIdx']]['name'];
            }

            $ret['name']    = $cateChoiceName;
            $ret['cate_idx']= $data['categoryIdx'];

            return json_encode( $ret );

        } else {
            $list = $this->productService->listByCategory($data);

            return view('product.categoryBy', [
                'data' => $list
            ]);
        }
    }
    

    // 키워드 검색 (상품 리스트 가져오기)
    public function listBySearch(Request $request) {
        
        Log::debug("----------- ProductController / listBySearch -----------------");
        
        $data['keyword'] = $request->query('kw');
        $data['categoryIdx'] = $request->query('ca');
        $data['parentIdx'] = $request->query('pre');
        $data['property'] = $request->query('prop');
        $data['sort'] = $request->query('so');

        $productList = $this->productService->listByCategory($data);

        return view('product.searchBy', [
            'productList'=>$productList
        ]);
    }

    // 카테고리 검색 (상품 리스트 가져오기)
    // 상품리스트 없을 경우 업체 리스트 검색 리스트 존재시 업체 검색페이지로 이동
    public function listBySearch2(Request $request) {
        
        Log::debug("----------- ProductController / listBySearch2 -----------------");
        
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

        return view('product.searchBy', [
            'productList'=>$productList
        ]);
    }

    // 이 달의 도매 데이터 가져오기
    public function thisMonth() {
        $data = $this->productService->thisMonth();

        return view('product.thisMonth', [
            'data'=>$data
        ]);
    }

    // 이 달의 도매 모아보기 가져오기
    public function thisMonthDetail() {

        return view('product.thisMonthDetail', []);
    }
    
    public function getCategoryBanners() {

        $banners = Banner::where('ad_location', 'category')
                       ->join('AF_attachment as ac', function ($query) {
                           $query->on('ac.idx', 'AF_banner_ad.web_attachment_idx');
                       })
                       ->where('start_date', '<', DB::raw('now()'))
                       ->where('end_date', '>', DB::raw('now()'))
                       ->where('state', 'G')
                       ->where('is_delete', 0)
                       ->where('is_open', 1)
                       ->orderByRaw('banner_price desc, RAND()')
                       ->get();
        
        return response()->json([
            'success'=>true,
            'data'=>$banners
        ]);
        
    }
    
    
}
