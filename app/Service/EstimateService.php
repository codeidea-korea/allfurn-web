<?php

namespace App\Service;

use App\Models\User;
use App\Models\CompanyWholesale;
use App\Models\CompanyRetail;
use App\Models\Estimate;
use App\Models\Product;
use App\Models\Order;
//use App\Models\Category;
//use App\Models\CategoryProperty;
use App\Models\Attachment;
use App\Models\Banner;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EstimateService {
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
            $company = CompanyWholesale::find(Auth::user()['company_idx']);
        } else {
            $company = CompanyRetail::find(Auth::user()['company_idx']);
        }

        return 
            response() -> json([
                'success'           =>  true,
                'now1'              => $now1,
                'now2'              => $now2,
                'group_code'        => $estimateGroupCode,
                'product_address'   => $company -> business_address.' '.$company -> business_address_detail
            ]);
    }

    public function insertRequest(array $params) {
        $estimate = new Estimate;

        $estimate -> estimate_group_code = $params['estimate_group_code'];
        $estimate -> estimate_code = $params['estimate_group_code'].'-0001';
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
        $estimate -> product_total_price = $params['product_each_price'] * $params['product_count'];

        $estimate -> save();
        return $estimate -> idx;
    }

    public function insertRequestAttachment(string $filePath) {
        $attachment = new Attachment;

        $attachment -> folder = explode('/', $filePath)[0];
        $attachment -> filename = explode('/', $filePath)[1];
        $attachment -> register_time = DB::raw('now()');
        $attachment -> save();

        return $attachment -> idx;
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

        $estimate -> product_each_price = $params['response_estimate_product_each_price'];
        $estimate -> product_delivery_info = $params['response_estimate_product_delivery_info'];
        $estimate -> product_delivery_price = $params['response_estimate_product_delivery_price'];
        $estimate -> product_total_price = $params['response_estimate_product_total_price'];
        $estimate -> product_memo = $params['response_estimate_product_memo'];

        $estimate -> save();
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
        

        for($i = 0; $i < count($params['estimate_idx']); $i++) {
            $estimate = Estimate::find($params['estimate_idx'][$i]);

            $estimate -> estimate_state = 'O';
            $estimate -> product_count = $params['product_count'][$i];
            $estimate -> product_total_price = $params['product_total_price'][$i];
            $estimate -> estimate_total_price = $params['response_estimate_estimate_total_price'];
            $estimate -> product_memo = ($params['product_memo'][$i]) ? $params['product_memo'][$i] : '';

            $estimate -> save();

            $product_total_count += $params['product_count'][$i];
        }

        $order = new Order;

        $order -> user_idx = $params['response_estimate_req_user_idx'];
        $order -> order_group_code = $estimate['estimate_group_code'];
        $order -> order_code = $estimate['estimate_code'];
        $order -> product_idx = $estimate['product_idx'];
        $order -> option_json = '[]';
        $order -> count = $product_total_count;
        $order -> memo = $params['memo'];
        $order -> price = $params['response_estimate_estimate_total_price'];
        $order -> delivery_info = $estimate['product_delivery_info'];
        $order -> name = $params['name'];
        $order -> address1 = $params['address1'];
        $order -> phone_number = $params['phone_number'];
        $order -> register_time = $params['register_time'];

        $order -> save();

        return $order -> idx;
    }

    public function checkOrder(array $params): array {
        DB::table('AF_estimate')
            -> where('estimate_code',$params['estimate_code'])
            -> update(['estimate_state' => 'F']);

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
            
            if($params['company_type'][$i] === 'W') {
                $request = CompanyWholesale::find($params['company_idx'][$i]);
            } else {
                $request = CompanyRetail::find($params['company_idx'][$i]);
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

                $estimate -> response_company_idx = $params['response_company_idx'];
                $estimate -> response_company_type = $params['response_company_type'];
                $estimate -> response_company_name = $params['response_company_name'];
                $estimate -> response_business_license_number = $params['response_business_license_number'];
                $estimate -> response_phone_number = $params['response_phone_number'];
                $estimate -> response_address1 = $params['response_address1'];
                $estimate -> response_account = $params['response_account1'].' '.$params['response_account2'];
                $estimate -> response_memo = $params['response_memo'];
                $estimate -> response_time = date('Y-m-d H:i:s');

                $estimate -> product_delivery_info = $params['product_delivery_info'];
                $estimate -> product_delivery_price = $params['product_delivery_price'];
                $estimate -> product_idx = $params['product_idx'][$j];
                $estimate -> product_count = $params['product_count'][$j];
                $estimate -> product_each_price = $params['product_each_price'][$j];

                $product_total_price = $params['product_each_price'][$j] * $params['product_count'][$j];
                $estimate -> product_total_price = $product_total_price;

                $estimate_total_price += $product_total_price;

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
        }
    }
}