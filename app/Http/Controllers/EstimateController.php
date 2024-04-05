<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Routing\Controller as BaseController;
use App\Service\EstimateService;
use App\Service\ProductService;
use App\Service\OrderService;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class EstimateController extends BaseController {
    private $estimateService;
    private $orderService;
    private $productService;

    public function __construct (
        OrderService $orderService,
        ProductService $productService,
        EstimateService $estimateService
    ) {
        $this -> middleware('auth');

        $this -> orderService = $orderService;
        $this -> productService = $productService;
        $this -> estimateService = $estimateService;
    }

    // 견적서 요청번호 / 견적번호 생성
    public function makeEstimateCode() {
        return $this -> estimateService -> makeEstimateCode(16);
    }

    // 견적서 요청 보냄 (단일)
    public function insertRequest(Request $request) {
        $data = $request -> all();

        if (isset($data['files'])) {
            $attachmentIdx = '';
            foreach ($data['files'] as $file) {
                if(is_file($file)) {
                    $filePath = $file -> store('estimate', 's3');
                    $attachmentIdx .= $this -> estimateService -> insertRequestAttachment($filePath).',';
                }
            }

            if (isset($data['attachmentIdx'])) {
                $data['attachmentIdx'] .= ','.substr($attachmentIdx, 0, -1);
            } else {
                $data['attachmentIdx'] = substr($attachmentIdx, 0, -1);
            }
        }

        $estimateIdx = $this -> estimateService -> insertRequest($data);

        return 
            response() -> json([
                'success'   => $estimateIdx != null ? true : false,
            ]);
    }

    // 견적서 보냄 (단일 → 1개)
    public function updateResponse(Request $request) {
        $data = $request -> all();

        $estimateIdx = $this -> estimateService -> updateResponse($data);

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