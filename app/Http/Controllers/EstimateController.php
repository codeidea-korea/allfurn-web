<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Routing\Controller as BaseController;
use App\Service\EstimateService;
use App\Service\ProductService;
use App\Service\OrderService;
use App\Service\CommunityService;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class EstimateController extends BaseController {
    private $estimateService;
    private $orderService;
    private $productService;
    private $communityService;
    

    public function __construct (
        OrderService $orderService,
        ProductService $productService,
        EstimateService $estimateService,
        CommunityService $communityService
    ) {
        $this -> middleware('auth');

        $this -> orderService = $orderService;
        $this -> productService = $productService;
        $this -> estimateService = $estimateService;
        $this -> communityService = $communityService;
    }

    // 견적 요청서 > 요청번호 or 견적서 > 견적번호 생성
    public function makeEstimateCode() {
        return $this -> estimateService -> makeEstimateCode(16);
    }

    // 견적서 요청 보냄 (단일)
    public function insertRequest(Request $request) {
        $list = [];
        $data_req = $request->all();
        $data_prd = $this->productService->getWholesalerProductListForIdx($request);

        $company = $this->makeEstimateCode();

        $company_ori = $company->original['company'];

        $tmp = 1;
        $total_price = 0;
        foreach( $data_prd AS $key => $row ) {
            $list['prod'][$key]['group_code']   = $company->original['group_code'];
            $list['prod'][$key]['estimate_code']   = $company->original['group_code'].'-'.sprintf('%04d', $tmp);
            $list['prod'][$key]['estimate_state']   = 'R';

            $list['prod'][$key]['company_idx']  = $request['company_idx'];
            $list['prod'][$key]['company_type']  = $request['company_type'];
            $list['prod'][$key]['company_name']  = $company_ori['company_name'];
            $list['prod'][$key]['license_number']  = $company_ori['business_license_number'];
            $list['prod'][$key]['license_attachment']  = $company_ori['business_license_attachment_idx'];
            $list['prod'][$key]['phone_number']  = $company_ori['phone_number'];
            $list['prod'][$key]['address1']  = $company_ori['business_address'];
            $list['prod'][$key]['address2']  = $company_ori['business_address_detail'];
            $list['prod'][$key]['memo']  = $request['p_memo'];
            $list['prod'][$key]['reg_date'] = date('Y-m-d H:i:s');

            $list['prod'][$key]['res_company_idx'] = $row['company_idx'];
            $list['prod'][$key]['res_company_type'] = $row['company_type'];
            $list['prod'][$key]['res_company_name'] = $row['company_name'];
            $list['prod'][$key]['res_license_number'] = $row['business_license_number'];
            $list['prod'][$key]['res_license_attachment'] = $row['business_license_attachment_idx'];
            $list['prod'][$key]['res_phone_number'] = $row['phone_number'];
            $list['prod'][$key]['res_address1'] = $row['business_address'];
            $list['prod'][$key]['res_address2'] = $row['business_address_detail'];
            $list['prod'][$key]['res_reg_date'] = date('Y-m-d H:i:s');

            $list['prod'][$key]['prd_idx'] = $row['idx'];

            $list['prod'][$key]['prd_count'] = 1;
            for( $i = 0; $i < count( $data_req['p_idx'] ); $i++ ) {
                if( $row['idx'] == $data_req['p_idx'][$i] ) {
                    $list['prod'][$key]['prd_count'] = $data_req['p_cnt'][$i];
                }
            }
            $list['prod'][$key]['prd_price'] = $row['price'];

            $list['prod'][$key]['prod_each_price'] = $list['prod'][$key]['prd_count'] * $row['price'];
            $list['prod'][$key]['prod_delivery_info'] = $row['delivery_info'];

            $total_price += $list['prod'][$key]['prd_count'] * $row['price'];
            $tmp++;
        }

        $list['total'] = $total_price;

        $this->estimateService->insertRequestProduct( $list );

        return response()->json($list);
    }

    // 견적서 보냄 (단일 → 1개)
    public function updateResponse(Request $request) {
        $data = $request -> all();
        $estimateIdx = "";

        if(is_array($data)) {
            for($i = 0; $i < count($data); $i++) {
                $estimateIdx = $this -> estimateService -> updateResponse($data[$i]);
            }
        } else {
            $estimateIdx = $this -> estimateService -> updateResponse($data);
        }

        return 
            response() -> json([
                'success'   => $estimateIdx != null ? true : false,
            ]);
    }

    // 견적서 보류
    public function holdEstimate(Request $request): JsonResponse {
        try {
            return response() -> json($this -> estimateService -> holdEstimate($request -> all()));
        } catch (\Throwable $e) {
            return 
                response() -> json([
                    'result'    => 'fail',
                    'code'      => $e -> getCode(),
                    'message'   => '보류 처리에 실패하였습니다.'
                ]);
        }
    }

    // 주문(=발주)
    public function insertOrder(Request $request) {
        $params= [];
        $params = array_merge($params, $request -> all());

        $this -> estimateService -> insertOrder($params);

        return 
            response() -> json([
                'success'   => 'success'
            ]);
    }

    // 주문서 확인시의 사전 작업(=상태값 변경)
    public function checkOrder(Request $request): JsonResponse {
        try {
            return response() -> json($this -> estimateService -> checkOrder($request -> all()));
        } catch (\Throwable $e) {
            return 
                response() -> json([
                    'result'    => 'fail',
                    'code'      => $e -> getCode(),
                    'message'   => '확인/완료 처리에 실패하였습니다.'
                ]);
        }
    }





    // 업체 목록 (검색)
    public function getCompanyList(Request $request): JsonResponse {
        $data = $this -> estimateService -> getCompanyList($request -> all());

        return 
            response() -> json([
                'result'    => 'success',
                'data'      => $data
            ]);
    }

    // 견적서 보냄 (다중 → 1 ~ N개)
    public function updateResponseMulti(Request $request) {
        $params= [];
        $params = array_merge($params, $request -> all());

        $this -> estimateService -> updateResponseMulti($params);

        return 
            response() -> json([
                'success'   => 'success'
            ]);
    }
}