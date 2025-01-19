<?php

namespace App\Service;

use App\Models\User;
use App\Models\CompanyWholesale;
use App\Models\CompanyRetail;
use App\Models\CompanyNormal;
use App\Models\Product;
use App\Models\Estimate;
use App\Models\Order;
use App\Models\Attachment;
use App\Models\Banner;
use App\Models\UserRequireAction;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Service\PushService;

class EstimateService {
    private $pushService;

    public function __construct(PushService $pushService) {
        $this -> pushService = $pushService;
    }

    public function makeEstimateCode($length) {
        $estimateGroupCode = '';

        $check = 1;
        while($check != 0) {
            $characters  = '0123456789';
            $characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

            $nmr_loops = $length;
            while($nmr_loops--) {
                $estimateGroupCode .= $characters[mt_rand(0, strlen($characters) - 1)];
            }

            $check = Estimate::where('estimate_group_code', $estimateGroupCode) -> count();
        }

        $now1 = date('Y년 m월 d일');
        $now2 = date('Y-m-d H:i:s');

        $user = User::find(Auth::user()['idx']);
        if (Auth::user()['type'] === 'W') {
            $company = CompanyWholesale::select('AF_wholesale.*',
                DB::raw('CONCAT("'.preImgUrl().'", at.folder, "/", at.filename) AS blImgUrl'))
            ->leftjoin('AF_attachment as at', function($query) {
                $query->on('at.idx', '=', 'AF_wholesale.business_license_attachment_idx');
            })
            ->where('AF_wholesale.idx', Auth::user()['company_idx'])->first();
        } else if(Auth::user()['type'] === 'R'){;
            $company = CompanyRetail::select('AF_retail.*',
                DB::raw('CONCAT("'.preImgUrl().'", at.folder, "/", at.filename) AS blImgUrl'))
            ->leftjoin('AF_attachment as at', function($query) {
                $query->on('at.idx', '=', 'AF_retail.business_license_attachment_idx');
            })
            ->where('AF_retail.idx', Auth::user()['company_idx'])->first();
        } else {
            $company = CompanyNormal::selectRaw("AF_normal.*, '' as blImgUrl")
                ->where('idx', Auth::user()['company_idx'])
                ->whereIn('type', ['S', 'N'])
                ->first();
        }

        return
            response() -> json([
                'success'           =>  true,
                'now1'              => $now1,
                'now2'              => $now2,
                'group_code'        => $estimateGroupCode,
                'company'           => $company,
                'product_address'   => $company -> business_address.' '.$company -> business_address_detail
            ]);
    }

    /**
     * 견적서 추가 다건
     * @param array $params request
     * @param string $serialKey 시리얼키
     */
    public function insertRequests(array $params) {
        // 모든 상품에 대한 견적
        if(array_key_exists('all_product', $params)) {
            $products = Product::where('company_idx', $params['response_company_idx'])
                ->where('company_type', $params['response_company_type'])
                ->whereIn('state', ['S', 'O'])
                ->whereNull('deleted_at')
                ->get();
                
            $serialIdx = 0;
            foreach ($products as $product) {
                $productParam = array_merge(array(), $params);
                $params['product_idx'] = $product->idx;
                $params['product_count'] = 1;
                $params['product_each_price'] = $product->price;
                $params['product_each_price_text'] = $product->price_text;
                $serialIdx = $serialIdx + 1;
                $serialKey = str_pad($serialIdx, "5", "0", STR_PAD_LEFT);

                $this->insertRequest($params, '-'.$serialKey);
            }
        // 지정 상품에 대한 견적
        } else if(array_key_exists('product_idxs', $params)) {
            $this->insertRequest($params, '-00001');
            $serialIdx = 1;
            $productIdxs = $params['product_idxs'];

            foreach ($productIdxs as $idx) {
                $productParam = array_merge(array(), $params);
                $productInfo = Product::where('idx', $idx)->first();
                $params['product_idx'] = $idx;
                $params['product_count'] = 1;
                $params['product_each_price'] = $productInfo->price;
                $params['product_each_price_text'] = $productInfo->price_text;
                $serialIdx = $serialIdx + 1;
                $serialKey = str_pad($serialIdx, "5", "0", STR_PAD_LEFT);

                $this->insertRequest($params, '-'.$serialKey);
            }
        // 기본 단건 견적
        } else {
            $this->insertRequest($params, '-00001');
        }
    }
    
    /**
     * 견적서 추가
     * @param array $params request
     * @param string $serialKey 시리얼키
     */
    public function insertRequest(array $params, string $serialKey) {
        $check = Estimate::where('estimate_group_code', $params['estimate_group_code']) -> count();
        if($check < 0) {
            throw new \Exception('', 500);
        }

        $estimate = new Estimate;

        $estimate -> estimate_group_code = $params['estimate_group_code'];
        $estimate -> estimate_code = $params['estimate_group_code'].$serialKey;
        $estimate -> estimate_state = 'N';

        $estimate -> request_company_idx = $params['request_company_idx'];
        $estimate -> request_company_type = $params['request_company_type'];
        $estimate -> request_company_name = $params['request_company_name'];
        $estimate -> request_business_license_number = $params['request_business_license_number'];
        $estimate -> request_phone_number = $params['request_phone_number'];
        $estimate -> request_address1 = $params['request_address1'];
        $estimate -> request_memo = $params['request_memo'];
        $estimate -> request_time = $params['request_time'];
        $estimate -> request_business_license_attachment_idx = $params['attachmentIdx'];

        $estimate -> response_company_idx = $params['response_company_idx'];
        $estimate -> response_company_type = $params['response_company_type'];

        $estimate -> product_idx = $params['product_idx'];
        $estimate -> product_count = $params['product_count'];
        $estimate -> product_each_price = $params['product_each_price'];
        $estimate -> product_each_price_text = $params['product_each_price_text'];

        if ($params['product_option_exist'] == '1'){
            $estimate->product_total_price = $params['product_total_price'];
        }else{
            $estimate->product_total_price = $params['product_each_price'] * $params['product_count'];
        }

        if (isset($params['product_option_json'])) {
            $estimate -> product_option_json = $params['product_option_json'];
        }else{
            if(isset($params['product_option_key'])) {
                if(count($params['product_option_key']) > 0) {
                    $product_option_arr = array();
                    for($i = 0; $i < count($params['product_option_key']); $i++) {
                        $product_option_value = explode(',', $params['product_option_value'][$i]);
    
                        $product_option_arr[$i]['optionName'] = $params['product_option_key'][$i];
                        $product_option_arr[$i]['optionValue'][$product_option_value[0]] = $product_option_value[1];
                    }
    
                    $estimate -> product_option_json = json_encode($product_option_arr, JSON_UNESCAPED_UNICODE);
                }
            }
        }

        $estimate -> save();

        $userAction = new UserRequireAction;
        $userAction->request_user_id = Auth::user()['idx'];
        $userAction->request_user_type = Auth::user()['type'];
        $userAction->response_user_id = $params['response_company_idx'];
        $userAction->response_user_type = $params['response_company_type'];
        $userAction->request_type = 3;
        if(!empty($params['product_idx'])) {
            $userAction->product_id = $params['product_idx'];
        }
        $userAction -> save();

        $sql =
            "SELECT * FROM AF_user
            WHERE type = '".$params['response_company_type']."' AND company_idx = ".$params['response_company_idx']." AND parent_idx = 0";
        $user = DB::select($sql);

        if(count($user) > 0 && $serialKey == '-00001') {
            $this -> pushService -> sendPush(
                '견적서 요청 알림', '('.$params['request_company_name'].')에게 견적서를 요청 받았습니다.',
                $user[0] -> idx, $type = 5, env('APP_URL').'/mypage/responseEstimate'
            );

            $this -> pushService -> sendKakaoAlimtalk(
                'TS_5420', '[견적서 요청 알림]',
                [ 
                    '회사명' => $params['request_company_name'],
                    '견적서작성링크' => env('APP_URL2').'/mypage/responseEstimate'
                ], 
                $user[0] -> phone_number, null
            );
        }

        return $estimate -> idx;
    }

    public function insertRequestAttachment($image)
    {
        $stored = Storage::disk('vultr')->put('estimate', $image);
        $explodeFileName = explode('/',$stored);
        $fileName = end($explodeFileName);
        $attach = new Attachment();
        $attach->folder = 'estimate';
        $attach->filename = $fileName;
        $attach->save();
        return $attach->idx;
    }

    public function updateResponse(array $params) {
        $estimate = Estimate::find($params['estimate_idx']);

        $estimate -> estimate_state = 'R';
        $estimate -> estimate_total_price = $params['response_estimate_estimate_total_price'];

        $estimate -> response_company_name = $params['response_estimate_res_company_name'];
        $estimate -> response_business_license_number = $params['response_estimate_res_business_license_number'];
        $estimate -> response_phone_number = $params['response_estimate_res_phone_number'];
        $estimate -> response_address1 = $params['response_estimate_res_address1'];
        $estimate -> response_account = $params['response_estimate_account1'].' '.$params['response_estimate_response_account2'];
        $estimate -> response_memo = $params['response_estimate_res_memo'];
        $estimate -> response_time = $params['response_estimate_res_time'];
        $estimate -> expiration_date = $params['expiration_date'];
        $estimate -> product_each_price = $params['response_estimate_product_each_price'];
        $estimate -> product_delivery_info = $params['response_estimate_product_delivery_info'];
        $estimate -> product_option_price = $params['response_estimate_product_option_price'];
        $estimate -> product_delivery_price = $params['response_estimate_product_delivery_price'];
        $estimate -> product_total_price = $params['response_estimate_product_total_price'];
        $estimate -> product_memo = (array_key_exists('product_memo', $params) ? $params['product_memo'] : $params['response_estimate_product_memo']);

        $estimate -> save();

        $sql =
            "SELECT * FROM AF_user
            WHERE type = '".$estimate['request_company_type']."' AND company_idx = ".$estimate['request_company_idx']." AND parent_idx = 0";
        $user = DB::select($sql);

        if(count($user) > 0) {
            $this -> pushService -> sendPush(
                '견적서 도착 알림', '('.$params['response_estimate_res_company_name'].')님에게서 요청하신 견적서가 도착했습니다.',
                $user[0] -> idx, $type = 5, env('APP_URL').'/mypage/requestEstimate'
            );

            $this -> pushService -> sendKakaoAlimtalk(
                'TS_5417', '[견적서 도착 알림]',
                [ 
                    '회사명' => $params['response_estimate_res_company_name'],
                    '견적서링크' => env('APP_URL2').'/mypage/requestEstimate'
                ],
                $user[0] -> phone_number, null
            );
        }

        return $estimate -> idx;
    }

    public function holdEstimate(array $params): array {
        DB::table('AF_estimate')
            -> where('estimate_code',$params['estimate_code'])
            -> update(['estimate_state' => 'H']);

        return [
            'result'    => 'success',
            'message'   => ''
        ];
    }

    public function insertOrder(array $params) {
        $product_total_count = 0;
        $list = Estimate::where('estimate_group_code', $params['estimate_group_code']) -> get();

        for($i = 0; $i < count($list); $i++) {
            $estimate = Estimate::find($list[$i]['idx']);

            $estimate -> estimate_state = 'O';
            $estimate -> product_count = $list[$i]['product_count'];
            $estimate -> product_total_price = $list[$i]['product_total_price'];
            $estimate -> estimate_total_price = $list[$i]['response_estimate_estimate_total_price'];
            $product_option_price = 0;

            /*
            $product_option_key = 'product_option_key_'.$list[$i]['product_idx'][$i];
            $product_option_value = 'product_option_value_'.$list[$i]['product_idx'][$i];

            if(isset($list[$i][$product_option_value])) {
                if(count($list[$i][$product_option_value]) > 0) {
                    $product_option_arr = array();
                    Log::info('count($params[$product_option_value]: '.count($list[$i][$product_option_value]));
                    for($j = 0; $j < count($list[$i][$product_option_value]); $j++) {
                        $product_option_value_arr = explode(',', $list[$j][$product_option_value]);

                        $product_option_arr[$j]['optionName'] = $list[$j][$product_option_key];
                        $product_option_arr[$j]['optionValue'][$product_option_value_arr[0]] = $product_option_value_arr[1];

                        $product_option_price += $product_option_value_arr[1];
                    }

                    $estimate -> product_option_json = json_encode($product_option_arr, JSON_UNESCAPED_UNICODE);
                }
            }
            */
            $product_option_price  = $product_option_price * $list[$i]['product_count'];
            $estimate -> product_option_price = $product_option_price;

            $estimate -> save();

            $product_total_count += $list[$i]['product_count'];
        }

        $check = Order::where('order_group_code', $estimate['estimate_group_code']) -> count();
        if($check > 0) {
            throw new \Exception('', 500);
        }

        $order = new Order;

        $order -> user_idx = $list[0]['response_estimate_req_user_idx'];
        $order -> order_group_code = $estimate['estimate_group_code'];
        $order -> order_code = $estimate['estimate_code'];
        $order -> product_idx = $estimate['product_idx'];
        $order -> option_json = '[]';
        $order -> count = $product_total_count;
        $order -> memo = $list[0]['memo'];
        $order -> price = $list[0]['response_estimate_estimate_total_price'];
        $order -> delivery_info = $estimate['product_delivery_info'];
        $order -> name = $list[0]['name'];
        $order -> address1 = $list[0]['address1'];
        $order -> phone_number = $list[0]['phone_number'];
        $order -> register_time = $list[0]['register_time'];

        $order -> save();

        $product = DB::select("SELECT name FROM AF_product WHERE idx = ".$estimate['product_idx']);
        $productName = count($list) > 1 ?  $product[0]->name .'외 ' .count($list)-1 .'개' : $product[0]->name;

        // 구매자
        $this -> pushService -> sendPush(
            '신규 주문 안내', $productName.' 상품 주문이 완료되었습니다.',
            $list[0]['response_estimate_req_user_idx'], $type = 5, env('APP_URL').'/mypage/requestEstimate', env('APP_URL').'/mypage/requestEstimate'
        );

        $sql =
            "SELECT * FROM AF_user
            WHERE type = '".$estimate['response_company_type']."' AND company_idx = ".$estimate['response_company_idx']." AND parent_idx = 0";
        $user = DB::select($sql);

        if($estimate['request_company_type'] === 'W') {
            $sql =
                "SELECT * FROM AF_wholesale 
                WHERE idx = ".$estimate['request_company_idx'];
            $company = DB::select($sql);
        } else if ($estimate['request_company_type'] === 'R') {
            $sql =
                "SELECT * FROM AF_retail 
                WHERE idx = ".$estimate['request_company_idx'];
            $company = DB::select($sql);
        } else {
            $sql =
                "SELECT * FROM AF_normal
                WHERE idx = ".$estimate['request_company_idx'];
            $company = DB::select($sql);
        }

        // 판매자
        if(count($user) > 0) {
            $this -> pushService -> sendPush(
                '발주서 도착 알림', '('.$company[0] -> company_name.')님이 발주서를 요청했습니다.',
                $user[0] -> idx, $type = 5, env('APP_URL').'/mypage/responseEstimate', env('APP_URL').'/mypage/responseEstimate'
            );

            $this -> pushService -> sendKakaoAlimtalk(
                'TS_5422', '[발주서 도착 알림]',
                [ 
                    '회사명' => $company[0] -> company_name,
                    '발주서링크' => env('APP_URL2').'/mypage/responseEstimate'
                ], 
                $user[0] -> phone_number, null
            );
        }

        return $order -> idx;
    }

    public function holdOrder(array $params): array {
        $item = Order::where('order_group_code', $params['estimate_group_code'])
            ->update(['order_state' => 'X']);

        return [
            'result'    => 'success',
            'message'   => ''
        ];
    }

    public function saveOrder(array $params): array {
        $item = Order::where('order_group_code', $params['estimate_group_code'])
            ->update(['order_state' => 'R']);

        return [
            'result'    => 'success',
            'message'   => ''
        ];
    }

    public function checkOrder(array $params): array {
        $sql = "SELECT * FROM AF_estimate WHERE estimate_code = '".$params['estimate_code']."'";
        $estimate = DB::select($sql);

        if($estimate[0] -> estimate_state !== 'F') {
            DB::table('AF_estimate')
                -> where('estimate_code', $params['estimate_code'])
                -> update(['estimate_state' => 'F']);

            $sql =
                "SELECT * FROM AF_user
                WHERE type = '".$estimate[0] -> request_company_type."' AND company_idx = ".$estimate[0] -> request_company_idx." AND parent_idx = 0";
            $user = DB::select($sql);

            if(count($user) > 0) {
                $this -> pushService -> sendPush(
                    '발주서 확인 알림', '('.$estimate[0] -> response_company_name.') 님이 요청하신 발주서를 확인했습니다.',
                    $user[0] -> idx, $type = 5, env('APP_URL').'/mypage/requestEstimate'
                );

                $this -> pushService -> sendKakaoAlimtalk(
                    'TS_5426', '[발주서 확인 알림]',
                    [ 
                        '회사명' => $estimate[0] -> response_company_name,
                        '발주서링크' => env('APP_URL2').'/mypage/requestEstimate'
                    ],
                    $user[0] -> phone_number, null
                );
            }
        }

        return [
            'result'    => 'success',
            'message'   => ''
        ];
    }





    public function getCompanyList(array $params) {
        $sql =
            "SELECT * FROM
            (
                SELECT *, 'W' AS company_type, '(도매)' AS company_type_kor FROM AF_wholesale
                UNION ALL
                SELECT *, 'R' AS company_type, '(소매)' AS company_type_kor FROM AF_retail
            )
            AS wr
            WHERE wr.company_name LIKE '%{$params['keyword']}%'
            ORDER BY wr.company_name";

        $company = DB::select($sql);

        return $company;
    }

    public function updateResponseMulti(array $params) {
        $estimate = new Estimate;

        $product_total_price = 0;
        $product_delivery_price = 0;
        $estimate_total_price = 0;

        for($i = 0; $i < count($params['company_idx']); $i++) {
            $estimateGroupCode = '';

            if (isset($params['response_group_code'])) {
                $estimateGroupCode = $params['response_group_code'];
            } else {
                $check = 1;
                while($check != 0) {
                    $characters  = '0123456789';
                    $characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

                    $nmr_loops = 16;
                    while($nmr_loops--) {
                        $estimateGroupCode .= $characters[mt_rand(0, strlen($characters) - 1)];
                    }

                    $check = Estimate::where('estimate_group_code', $estimateGroupCode) -> count();
                }
            }

            $check = Estimate::where('estimate_group_code', $estimateGroupCode) -> count();
            if($check > 0) {
                throw new \Exception('', 500);
            }

            if($params['company_type'][$i] === 'W') {
                $request = CompanyWholesale::find($params['company_idx'][$i]);
            } else if($params['company_type'][$i] === 'R') {
                $request = CompanyRetail::find($params['company_idx'][$i]);
            } else {
                $request = CompanyNormal::find($params['company_idx'][$i]);
            }

            $estimate_total_price = 0;
            for($j = 0; $j < count($params['product_idx']); $j++) {
                $estimate -> estimate_group_code = $estimateGroupCode;
                $estimate -> estimate_code = $estimateGroupCode.'-'.sprintf('%04d', count($params['product_idx']));
                $estimate -> estimate_state = 'R';

                $estimate -> request_company_idx = $request -> idx;
                $estimate -> request_company_type = $params['company_type'][$i];
                $estimate -> request_company_name = $request -> company_name;
                $estimate -> request_business_license_number = $request -> business_license_number;
                $estimate -> request_phone_number = $request -> phone_number;
                $estimate -> request_address1 = $request -> business_address.' '.$request -> business_address_detail;
                if (isset($params['response_time'])) {
                    $estimate -> request_time = $params['response_time'];
                } else {
                    $estimate -> request_time = date('Y-m-d H:i:s');
                }

                $estimate -> response_company_idx = $params['response_company_idx'];
                $estimate -> response_company_type = $params['response_company_type'];
                $estimate -> response_company_name = $params['response_company_name'];
                $estimate -> response_business_license_number = $params['response_business_license_number'];
                $estimate -> response_phone_number = $params['response_phone_number'];
                $estimate -> response_address1 = $params['response_address1'];
                $estimate -> response_account = $params['response_account1'].' '.$params['response_account2'];
                $estimate -> response_memo = $params['response_memo'];

                if (isset($params['response_time'])) {
                    $estimate -> response_time = $params['response_time'];
                } else {
                    $estimate -> response_time = date('Y-m-d H:i:s');
                }
                $estimate -> expiration_date = $params['expiration_date'];

                $estimate -> product_delivery_info = $params['product_delivery_info'];
                $estimate -> product_delivery_price = $params['product_delivery_price'];
                $estimate -> product_idx = $params['product_idx'][$j];
                $estimate -> product_count = $params['product_count'][$j];
                $estimate -> product_each_price = $params['product_each_price'][$j];

                $product_total_price = $params['product_each_price'][$j] * $params['product_count'][$j];
                $estimate -> product_total_price = $product_total_price;

                $estimate_total_price += $product_total_price;

                $product_option_key = 'product_option_key_'.$params['product_idx'][$j];
                $product_option_value = 'product_option_value_'.$params['product_idx'][$j];
                $product_option_price = 0;

                if(isset($params[$product_option_key])) {
                    if(count($params[$product_option_key]) > 0) {
                        $product_option_arr = array();
                        for($k = 0; $k < count($params[$product_option_key]); $k++) {
                            $product_option_value_arr = explode(',', $params[$product_option_value][$k]);

                            $product_option_arr[$k]['optionName'] = $params[$product_option_key][$k];
                            $product_option_arr[$k]['optionValue'][$product_option_value_arr[0]] = $product_option_value_arr[1];

                            $product_option_price += $product_option_value_arr[1];
                        }

                        $estimate -> product_option_json = json_encode($product_option_arr, JSON_UNESCAPED_UNICODE);
                    }
                }
                $product_option_price  = $product_option_price * $params['product_count'][$j];
                $estimate -> product_option_price = $product_option_price;

                $estimate_total_price += $product_option_price;
                $estimate -> estimate_total_price = $estimate_total_price;

                $estimate -> save();
                $estimate = new Estimate;
            }

            $product_delivery_price = $params['product_delivery_price'];
            $estimate_total_price += $product_delivery_price;

            DB::table('AF_estimate')
                -> where('estimate_group_code', $estimateGroupCode)
                -> update([
                    'product_delivery_price' => $product_delivery_price,
                    'estimate_total_price' => $estimate_total_price
                ]);

            $product_total_price = 0;

            $sql =
                "SELECT * FROM AF_user
                WHERE type = '".$params['company_type'][$i]."' AND company_idx = ".$request -> idx." AND parent_idx = 0";
            $user = DB::select($sql);

            if(count($user) > 0 && $params['isKakao'] == 'false') {
                $this -> pushService -> sendPush(
                    '견적서 도착 알림', '('.$params['response_company_name'].')님에게서 요청하신 견적서가 도착했습니다.',
                    $user[0] -> idx, $type = 5, env('APP_URL').'/mypage/requestEstimate'
                );

                $this -> pushService -> sendKakaoAlimtalk(
                    'TS_5417', '[견적서 도착 알림]',
                    [ 
                        '회사명' => $params['response_company_name'],
                        '견적서링크' => env('APP_URL2').'/mypage/requestEstimate?status=R'
                    ],
                    $user[0] -> phone_number, null
                );
            }
        }
    }

    public function insertRequestProduct(array $param)
    {
        if( empty( $param ) ) return false;

        foreach( $param['prod'] AS $rows ) {
            $estimate = new Estimate;

            $estimate->estimate_group_code = $rows['group_code'];
            $estimate->estimate_code = $rows['estimate_code'];
            $estimate->estimate_state = 'N';
            $estimate->estimate_total_price = $param['total'];
            $estimate->request_company_idx = $rows['company_idx'];
            $estimate->request_company_type = $rows['company_type'];
            $estimate->request_company_name = $request_company_name = $rows['company_name'];
            $estimate->request_business_license_number = $rows['license_number'];
            $estimate->request_business_license_attachment_idx = $rows['license_attachment'];
            $estimate->request_phone_number = $rows['phone_number'];
            $estimate->request_address1 = $rows['address1'];
            $estimate->request_address2 = $rows['address2'];
            $estimate->request_memo = $rows['memo'];
            $estimate->request_time = date('Y-m-d H:i:s');
            $estimate->response_company_idx = $response_company_idx = $rows['res_company_idx'];
            $estimate->response_company_type =$response_company_type = $rows['res_company_type'];
            $estimate->response_company_name = $rows['res_company_name'];
            $estimate->response_business_license_number = $rows['res_license_number'];
            $estimate->response_business_license_attachment_idx = $rows['res_license_attachment'];
            $estimate->response_phone_number = $rows['res_phone_number'];
            $estimate->response_address1 = $rows['res_address1'];
            $estimate->response_address2 = $rows['res_address2'];
            $estimate->product_idx = $product_idx = $rows['prd_idx'];
            $estimate->product_count = $rows['prd_count'];
            $estimate->product_each_price = $rows['prd_price'];
            $estimate->product_total_price = $rows['prod_each_price'];
            $estimate->product_delivery_price = 0;
            $estimate->product_delivery_info = $rows['prod_delivery_info'];

            $estimate -> save();
        }

        $userAction = new UserRequireAction;
        $userAction->request_user_id = Auth::user()['idx'];
        $userAction->request_user_type = Auth::user()['type'];
        $userAction->response_user_id = $response_company_idx;
        $userAction->response_user_type = $response_company_type;
        $userAction->request_type = 3;
        if(!empty($params['product_idx'])) {
            $userAction->product_id = $product_idx;
        }
        $userAction -> save();

        $sql =
            "SELECT * FROM AF_user
            WHERE type = '".$response_company_type."' AND company_idx = ".$response_company_idx." AND parent_idx = 0";
        $user = DB::select($sql);

        if(count($user) > 0) {
            $this -> pushService -> sendPush(
                '견적서 요청 알림', '('.$request_company_name.')에게 견적서를 요청 받았습니다.',
                $user[0] -> idx, $type = 5, env('APP_URL').'/mypage/responseEstimate'
            );

            $this -> pushService -> sendKakaoAlimtalk(
                'TS_5420', '[견적서 요청 알림]',
                [ 
                    '회사명' => $request_company_name,
                    '견적서작성링크' => env('APP_URL2').'/mypage/responseEstimate'
                ], 
                $user[0] -> phone_number, null
            );
        }
    }
}
