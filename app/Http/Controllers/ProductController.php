<?php

namespace App\Http\Controllers;

use App\Service\HomeService;
use App\Service\ProductService;
use App\Service\WholesalerService;
use App\Service\MypageService;
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
use Illuminate\Support\Facades\Auth;

class ProductController extends BaseController
{
    private $productService;
    private $homeService;
    private $mypageService;
    private $wholesalerService;

    public function __construct(
        ProductService    $productService,
        HomeService       $homeService,
        MypageService     $mypageService,
        WholesalerService $wholesalerService
    )
    {
        $this->middleware('auth');

        $this->productService = $productService;
        $this->homeService = $homeService;
        $this->mypageService = $mypageService;
        $this->wholesalerService = $wholesalerService;
    }

    // 상품 수정 - 상품 정보 가져오기
    public function modify(int $productIdx, Request $request)
    {
        $type = $request->get('type') ?? '';

        return view('product.product-registration', [
            'productIdx' => $productIdx,
            'data' => $this->productService->getProductData($productIdx, $type)['detail'],
            'categoryList' => $this->getCategoryList(),
            'productList' => $this->getMyProductList(), 
            'request' => $request
        ]);
    }


    // 상품 정보 가져오기
    public function getProductData(int $productIdx, Request $request)
    {
        $type = $request->get('type') ?? '';
        $data = $this->productService->getProductData($productIdx, $type);

        return response()->json([
            'success' => true,
            'data' => $data
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
    public function saveProduct(Request $request)
    {

        $data = $request->all();

        if (isset($data['files'])) {
            $attachmentIdx = '';
            foreach ($data['files'] as $file) {
                if (is_file($file)) {
                    $filePath = $file->store('product', 's3');
                    $attachmentIdx .= $this->productService->saveAttachment($filePath) . ',';
                }
            }

            if (isset($data['attachmentIdx'])) {
                $data['attachmentIdx'] .= ',' . substr($attachmentIdx, 0, -1);
            } else {
                $data['attachmentIdx'] = substr($attachmentIdx, 0, -1);
            }
        }

        if ($request->input('reg_type') == '2') {
            $prductIdx = $this->productService->modify($data);
        } else {
            $prductIdx = $this->productService->create($data);
        }

        return response()->json([
            'success' => $prductIdx != null ? true : false,
        ]);
    }


    /**
     * 상품 등록 - 대 카테고리 / 내가 등록한 상품 정보 리스트 가져오기
     * @return Application|Factory|View
     */
    public function registration(Request $request)
    {
        return view(getDeviceType().'product.product-registration', [
            'banners' => $this->productService->getBannerList(),
            'todayCount' => $this->productService->getTodayCount(),
            //'categoryList' => $this->productService->getCategoryList(),
            'categoryList' => $this->productService->getCategoryTree(),
            'productList' => $this->getMyProductList(), 
            'request' => $request, 
            'productIdx' => 0
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
            'success' => true,
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
            'link' => preImgUrl() . $file,
            'idx' => $imgIdx
        ]);
    }

    // 상품 등록/수정 - 에디터 이미지 삭제
    public function imageDelete(Request $request)
    {
        $imgPath = ($request->src) . str_replace(env . AWS_S3_URL, '');
        Storage::disk('s3')->delete($imgPath);

        $this->productService->deleteImage($request->idx);

        return response()->json([
            'success' => true
        ]);
    }

    // 상품 즐겨찾기
    public function interestToggle(int $productIdx)
    {
        if ($productIdx == null) {
            return;
        }

        return $this->productService->interestToggle($productIdx);
    }


    // 신상품 페이지 데이터 가져오기
    public function newProduct(Request $request)
    {
        // 상단 배너
        $banners = $this->productService->getBannerList();
        $categoryList = $this->productService->getCategoryList();
        $todayCount = $this->productService->getTodayCount();

        // $data['target'] = $request->query('ca') != null ? $request->query('ca') : "ALL";
        // $list = $this->productService->getNewProductList($data);

        $bestNewProducts = $this->productService->getBestNewProductList();
        $company = $this->productService->getRecentlyAddedProductCompanyList();

        return view(getDeviceType() . 'product.newProduct', [
            'banners' => $banners,
            'todayCount' => $todayCount,
            'categoryList' => $categoryList,
            'bestNewProducts' => $bestNewProducts,
            'company' => $company,
        ]);
    }


    /** 베스트 신상품 가져오기 */
    public function bestNewProduct(Request $request)
    {
        $bestNewProducts = $this->productService->getBestNewProductList();
        return view(getDeviceType() . 'product.best-new-product', [
            'bestNewProducts' => $bestNewProducts,
        ]);
    }

    // 신규 등록 상품 가져오기
    public function newAddedProduct(Request $request)
    {
        $data['categories'] = $request->categories == null ? "" : $request->categories;
        $data['locations'] = $request->locations == null ? "" : $request->locations;
        if($request->orderedElement == null || $request->orderedElement) {
            $data['orderedElement'] = 'AF_product.access_date';
        } else {
            $data['orderedElement'] = $request->orderedElement;
        }

        $list = $this->productService->getNewAddedProductList($data);

        $html = view('product.inc-product-common', ['list' => $list])->render();
        $modalHtml = view(getDeviceType() . 'product.inc-product-modal-common', ['product' => $list])->render();
        $list['html'] = $html;
        $list['modalHtml'] = $modalHtml;

        return response()->json($list);
    }


    // 상품 상세 데이터 가져오기
    public function detail(int $productIdx)
    {
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
        if ($data['detail']->auth_info !== '' && isset($data['detail']->auth_info)) {
            $propArray["인증정보"] = $data['detail']->auth_info;
        }

        $data['detail']->propertyArray = $propArray;

        // 신상품 처리 최근등록일 기준 ( 30일 )
        $date1 = Carbon::parse($data['detail']->register_time);
        $date2 = Carbon::parse(now());

        // 신상품( is_new_product ==1 ) 이면서 등록된지 1달 이내의 상품
        $data['detail']->diff = $date1->diffInDays($date2);

        // 상단 배너
        $banners = $this->productService->getBannerList();
        $categoryList = $this->productService->getCategoryList();
        $todayCount = $this->productService->getTodayCount();

        // 견적서 > 업체 유형 / 이름 등의 정보를 얻기 위함
        $data['user'] = Auth::user();
        $data['company'] = $this->mypageService->getCompanyAccount();

        return view(getDeviceType() . 'product.detail', [
            'banners' => $banners,
            'todayCount' => $todayCount,
            'categoryList' => $categoryList,
            'data' => $data
        ]);
    }


    // 카테고리 검색 (상품 리스트 가져오기)
    public function listByCategory(Request $request)
    {

        $data['categoryIdx'] = $request->query('ca');
        $data['parentIdx'] = $request->query('pre');
        $data['property'] = $request->query('prop');
        $data['sort'] = $request->query('so') == null ? "reg_time" : str_replace("filter_", "", $request->query('so'));
        $data['jn'] = $request->query('jn');

        if ($data['jn']) {

            $categoryList = $this->productService->getCategoryAll();
            $cateArray = array();

            foreach ($categoryList as $category) {
                if ($category->parent_idx) {
                    $cateArray[$category->parent_idx][$category->idx]['idx'] = $category->idx;
                    $cateArray[$category->parent_idx][$category->idx]['name'] = $category->name;
                } else {
                    $cateArray[$category->idx]['idx'] = $category->idx;
                    $cateArray[$category->idx]['name'] = $category->name;
                }
            }

            $cateChoiceName = '';
            if ($data['parentIdx']) {
                $cateChoiceName .= $cateArray[$data['parentIdx']]['name'];
                $cateChoiceName .= ' > ' . $cateArray[$data['parentIdx']][$data['categoryIdx']]['name'];
            } else {
                $cateChoiceName .= $cateArray[$data['categoryIdx']]['name'];
            }

            $ret['name'] = $cateChoiceName;
            $ret['cate_idx'] = $data['categoryIdx'];

            return json_encode($ret);

        } else {
            $list = $this->productService->listByCategory($data);
            $banners = $this->productService->getBannerListByCategory($data);

            return view(getDeviceType().'product.categoryBy', [
                'data' => $list,
                'banners' => $banners,
            ]);
        }
    }


    // 키워드 검색 (상품 리스트 가져오기)
    public function listBySearch(Request $request)
    {

        Log::debug("----------- ProductController / listBySearch -----------------");

        $data['keyword'] = $request->query('kw');
        $data['categoryIdx'] = $request->query('ca');
        $data['parentIdx'] = $request->query('pre');
        $data['property'] = $request->query('prop');
        $data['sort'] = $request->query('so');

        $productList = $this->productService->listByCategory($data);

        return view(getDeviceType().'product.searchBy', [
            'productList' => $productList
        ]);
    }

    // 카테고리 검색 (상품 리스트 가져오기)
    // 상품리스트 없을 경우 업체 리스트 검색 리스트 존재시 업체 검색페이지로 이동
    public function listBySearch2(Request $request)
    {

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
                return redirect(getDeviceType().'/wholesaler/search?kw=' . $data['keyword']);
            }
        }

        return view(getDeviceType().'product.searchBy', [
            'productList' => $productList
        ]);
    }

    // 이 달의 도매 데이터 가져오기
    public function thisMonth(Request $request)
    {
        $categoryList = $this->productService->getCategoryList();

        $dealBanner['dealbrand'] = $this->productService->getThisDealList('dealbrand');
        $data = array();
        foreach ($dealBanner['dealbrand'] as $key => $banner) {
            $data[$key] = new \stdClass();

            $data[$key]->idx = $banner['idx'];
            $data[$key]->company_idx = $banner['company_idx'];
            $data[$key]->subtext1 = $banner['subtext1'];
            $data[$key]->subtext2 = $banner['subtext2'];
            $data[$key]->content = $banner['content'];
            $data[$key]->product_info = $banner['product_info'];
            $data[$key]->banner_type = $banner['banner_type'];
            $data[$key]->bg_color = $banner['bg_color'];
            $data[$key]->font_color = $banner['font_color'];
            $data[$key]->web_link_type = $banner['web_link_type'];
            $data[$key]->web_link = $banner['web_link'];
            $data[$key]->company_name = $banner['company_name'];
            $data[$key]->imgUrl = $banner['imgUrl'];
            $data[$key]->mainImgUrl = $banner['mainImgUrl'];

            $productInfo = json_decode($banner['product_info']);
            $interestArr = array();

            foreach ($productInfo as $i => $info) {
                $interestArr[$info->mdp_gidx] = $this->productService->isInterest($info->mdp_gidx);
            }
            $data[$key]->isInterest = $interestArr;
        }
        $dealBanner['dealbrand'] = $data;

        $dealBanner['plandiscount'] = $this->productService->getThisDealList('plandiscount');
        $dealBanner['dealmiddle'] = $this->productService->getThisDealList('dealmiddle');

        $target['thisMonth'] = date('m');
        $dealBanner['product'] = $this->productService->getBestNewProductList($data);

        $target['categoryIdx'] = $request->query('categories');
        $target['locationIdx'] = $request->query('locations');
        $target['orderedElement'] = $request->orderedElement == null ? "score" : str_replace("filter_", "", $request->orderedElement);
        $company = $this->wholesalerService->getThisMonthWholesaler($target);

        return view(getDeviceType() . 'product.thisMonth', [
            'categoryList' => $categoryList,
            'dealbrand' => $dealBanner['dealbrand'],
            'plandiscount' => $dealBanner['plandiscount'],
            'dealmiddle' => $dealBanner['dealmiddle'],
            'productBest' => $dealBanner['product'],
            'companyProduct' => $company
        ]);
    }

    /**
     * 이달의딜 > 기획전 더보기
     */
    public function planDiscountDetail()
    {
        $dealBanner['plandiscount'] = $this->productService->getThisDealList('plandiscount');

        return view(getDeviceType() . 'product.plan_discount_list', [
            'list'  => $dealBanner['plandiscount']
        ]);
    }

    /**
     * 이 달의딜 상단 아이템 및 모아보기 가져오기
     * @param Request $request ( cIdx : 도매업체 idx )
     * @return Application|Factory|View
     */
    public function thisMonthDetail(Request $request)
    {
        $cidx = $request->query('cIdx');

        $dealBanner = $this->productService->getThisDealList('dealbrand', $cidx);
        $data = array();
        foreach ($dealBanner as $key => $banner) {
            $data[$key] = new \stdClass();

            $data[$key]->idx = $banner['idx'];
            $data[$key]->company_idx = $banner['company_idx'];
            $data[$key]->subtext1 = $banner['subtext1'];
            $data[$key]->subtext2 = $banner['subtext2'];
            $data[$key]->content = $banner['content'];
            $data[$key]->product_info = $banner['product_info'];
            $data[$key]->banner_type = $banner['banner_type'];
            $data[$key]->bg_color = $banner['bg_color'];
            $data[$key]->font_color = $banner['font_color'];
            $data[$key]->web_link_type = $banner['web_link_type'];
            $data[$key]->web_link = $banner['web_link'];
            $data[$key]->company_name = $banner['company_name'];
            $data[$key]->imgUrl = $banner['imgUrl'];
            $data[$key]->mainImgUrl = $banner['mainImgUrl'];

            $productInfo = json_decode($banner['product_info']);
            $interestArr = array();

            foreach ($productInfo as $i => $info) {
                $interestArr[$info->mdp_gidx] = $this->productService->isInterest($info->mdp_gidx);
            }
            $data[$key]->isInterest = $interestArr;
        }

        // 확대보기의경우 cIdx 유무를 확인
        if (!$cidx) {
            // 모아보기 view
            return view(getDeviceType().'product.thisMonthDetail', [
                'dealbrand' => $data,
            ]);
        } else {
            // 확대보기 view
            return view('product.inc-thisMonthZoom', [
                'zoomData' => $data[0],
            ]);
        }
    }

    // 인기상품 모아보기
    public function getPopularSumList()
    {
        $target['categoryIdx'] = [1, 2, 3, 14];
        $popularList = $this->productService->getPopularList($target);
        $bestNewProducts = $this->productService->getBestNewProductList();
        return view(getDeviceType() . 'product.popular-sum-list', [
            'lists' => $popularList,
            'bestNewProducts' => $bestNewProducts,
        ]);
    }

    public function getPopularSumListTab(int $categoryIdx)
    {
        $popularList = $this->productService->getPopularListTab($categoryIdx);
        return $popularList;
    }

    /**
     * 인기브랜드
     * 20개씩 노출
     */
    public function popularBrandList()
    {
        $data = $this->productService->getPoularBrandList();
        return view(getDeviceType() . 'product.popular-brand-list', [
            'lists' => $data
        ]);
    }

    /**
     * 인기브랜드 ajsx 호출
     */
    public function jsonPopularBrand(Request $request)
    {
        $list = $this->productService->getPoularBrandList();
        $data['query'] = $list;
        return response()->json($data);
    }

    // xx월 Best 도매업체 json
    public function getJsonThisBestWholesaler(Request $request)
    {
        $data['categoryIdx'] = $request->categories == null ? "" : $request->categories;
        $data['locationIdx'] = $request->locations == null ? "" : $request->locations;
        switch($request->orderedElement){
            case "access_count":
                $data['orderedElement'] = 'companyAccessCount';
                break;

            case "register_time" : 
                $data['orderedElement'] = 'register_time';
                break;

            default:
                $data['orderedElement'] = 'score';
                break;

        }

        $data['list'] = $this->wholesalerService->getThisMonthWholesaler($data);
        $data['html'] = view( getDeviceType(). 'wholesaler.inc-wholesalerList-common', ['list' => $data['list']])->render();

        return response()->json($data);
    }

    // 카테고리 검색 (상품 리스트 가져오기)
    public function getJsonListByCategory(Request $request)
    {

        $data['categoryIdx'] = $request->query('ca');
        $data['parentIdx'] = $request->query('pre');
        $data['property'] = $request->query('prop');
        $data['sort'] = $request->query('so') == null ? "reg_time" : str_replace("filter_", "", $request->query('so'));

        $list = $this->productService->listByCategory($data);

        $data['query'] = $list['list'];

        return response()->json($data);
    }
    // 카테고리 검색 (상품 리스트 가져오기)
    // 상품리스트 없을 경우 업체 리스트 검색 리스트 존재시 업체 검색페이지로 이동
    public function getJsonListBySearch(Request $request)
    {
        $data['keyword'] = $request->query('kw');
        $data['categoryIdx'] = $request->query('ca');
        $data['parentIdx'] = $request->query('pre');
        $data['property'] = $request->query('prop');
        $data['sort'] = $request->query('so');

        $productList = $this->productService->listByCategory($data);

        $data['query'] = $productList['list'];

        return response()->json($data);
    }
}
