<?php

namespace App\Service;

use App\Models\Attachment;
use App\Models\Banner;
use App\Models\Category;
use App\Models\CategoryProperty;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function addCart(array $param = [])
    {

        $cart = Cart::updateOrInsert([
            'user_idx' => Auth::user()->idx,
            'product_idx' => $param['productIdx'],
            'option_json' => $param['option']
        ],[
            'included_required_option' => $param['required'],
            'count' => DB::raw('count +'.(int)$param['count']),
            'each_price' => $param['eachPrice'],
            'price' => DB::raw('price +'.(int)$param['price']),
            'register_time' => DB::raw('now()'),
            'is_alert' => 1
            ]);

        $res = Cart::where([
            'user_idx' => Auth::user()->idx,
            'product_idx' => $param['productIdx'],
            'option_json' => $param['option']
        ])->first();

        return $res->idx;
    }

    public function removeCart(array $param = [])
    {
        foreach($param['idx'] as $idx) {
            Cart::where($param['type'] == "cart" ? 'idx' : 'product_idx', $idx)
                ->where('user_idx', Auth::user()->idx)
                ->delete();
        }

        return response()->json([
            'success'=>true
        ]);
    }

    public function getCartList(string $idxStr = '')
    {
        $list = Cart::select('AF_cart.idx', 'AF_cart.product_idx', 'ap.company_idx', 'AF_cart.option_json', 'ap.delivery_info', 'ap.product_option', 'ap.state', 'ap.price as productPrice',
            'ap.name', 'ap.is_price_open', 'ap.price_text', 'AF_cart.each_price', 'AF_cart.price', 'AF_cart.count',
            DB::raw('CONCAT("'.preImgUrl().'", at.folder, "/", at.filename) as imgUrl,
            (CASE WHEN ap.company_type = "W" THEN (select aw.company_name from AF_wholesale as aw where aw.idx = ap.company_idx)
                    WHEN ap.company_type = "R" THEN (select ar.company_name from AF_retail as ar where ar.idx = ap.company_idx)
                    ELSE "" END) as companyName,
            (CASE WHEN ap.pay_type = 4 THEN ap.pay_type_text
                    ELSE CONCAT("product.payType_",ap.pay_type) END) as payInfo'
            ))
            ->where('AF_cart.user_idx', Auth::user()->idx)
            ->join('AF_product as ap', 'ap.idx', 'AF_cart.product_idx')
            ->whereIn('ap.state', ['S', 'O'])
            ->leftjoin('AF_attachment as at', function($query) {
                $query->on('at.idx', DB::raw('SUBSTRING_INDEX(ap.attachment_idx, ",", 1)'));
                })
            ->orderBy('ap.company_idx', 'desc');

        if ($idxStr != '') {
            $list->whereRaw('find_in_set(AF_cart.idx, "'.$idxStr.'")');
        }

        Cart::where('user_idx', Auth::user()->idx)
            ->update(['AF_cart.is_alert'=> 0]);

        return $list->get();
    }

    public function makeOrderList(array $param = [])
    {
        dd($param);
    }

    public function checkProductState(array $checkList = [])
    {
        return Cart::select('AF_cart.idx as cartIdx', 'ap.idx as productIdx', 'ap.name', 'ap.state')
            ->whereIn('AF_cart.idx', $checkList)
            ->join('AF_product as ap', function ($query) {
                $query->on('ap.idx', 'AF_cart.product_idx');
            })
            ->whereNotIn('ap.state', ['S'])
            ->get();
    }

    public function updateCart(array $param = [])
    {
        $idxStr = '';
        foreach($param['data'] as $item) {
            $cart = new Cart;
            $cart->where(['idx'=>$item['idx'], 'user_idx'=>Auth::user()->idx])
                ->update(['count'=>$item['count'], 'price'=>$item['price']]);
            $idxStr = $idxStr.(string)$item['idx'].',';
        }

        return substr($idxStr, 0, -1);
    }

    public function makeOrderForm(array $param = [])
    {

    }

    public function addOrder(array $param = [])
    {
        $order = new Order;
        $order->user_idx = Auth::user()->idx;
        $order->order_state = 'N';
        $order->product_idx = $param['productIdx'];
        $order->option_json = $param['option'];
        $order->count = $param['count'];
        $order->price = $param['price'];
        $order->register_time = DB::raw('now()');
        $order->save();

        return $order->idx;
    }

    public function getAccountInfo()
    {
        if(Auth::user()->parent_idx != 0) {
            return User::select(DB::raw('(CASE
            WHEN AF_user.type = "W" THEN (select aw.company_name from AF_wholesale as aw where aw.idx = AF_user.company_idx)
            WHEN AF_user.type = "R" THEN (select ar.company_name from AF_retail as ar where ar.idx = AF_user.company_idx)
            ELSE "" END) as companyName,
            (CASE
            WHEN AF_user.type = "W" THEN (select aw.business_email from AF_wholesale as aw where aw.idx = AF_user.company_idx)
            WHEN AF_user.type = "R" THEN (select ar.business_email from AF_retail as ar where ar.idx = AF_user.company_idx)
            ELSE "" END) as companyEmail'),
                'AF_user.name', 'AF_user.phone_number')
                ->where('AF_user.idx', Auth::user()->parent_idx)
            ->first();
        } else {
            return User::select(DB::raw('(CASE
            WHEN AF_user.type = "W" THEN (select aw.company_name from AF_wholesale as aw where aw.idx = AF_user.company_idx)
            WHEN AF_user.type = "R" THEN (select ar.company_name from AF_retail as ar where ar.idx = AF_user.company_idx)
            ELSE "" END) as companyName,
            (CASE
            WHEN AF_user.type = "W" THEN (select aw.business_email from AF_wholesale as aw where aw.idx = AF_user.company_idx)
            WHEN AF_user.type = "R" THEN (select ar.business_email from AF_retail as ar where ar.idx = AF_user.company_idx)
            ELSE "" END) as companyEmail'),
                'AF_user.name', 'AF_user.phone_number')
                ->where('AF_user.idx', Auth::user()->idx)
            ->first();
        }
    }

    public function getOrderList()
    {
        return Order::select('AF_order.idx', 'AF_order.product_idx', 'ap.company_idx', 'AF_order.option_json', 'AF_order.count', 'AF_order.price', 'ap.delivery_info', 'ap.name',
            DB::raw('CONCAT(at.folder,"/", at.filename) as imgUrl,
            (CASE WHEN ap.company_type = "W" THEN (select aw.company_name from AF_wholesale as aw where aw.idx = ap.company_idx)
                    WHEN ap.company_type = "R" THEN (select ar.company_name from AF_retail as ar where ar.idx = ap.company_idx)
                    ELSE "" END) as companyName,
            (CASE WHEN ap.pay_type = 4 THEN ap.pay_type_text
                    ELSE CONCAT("payType_",ap.pay_type) END) as payInfo'
            ))
            ->where([
                'AF_order.user_idx'=>Auth::user()->idx,
                'AF_order.order_state'=>'N',
                'AF_order.is_cancel'=>0
            ])
            ->join('AF_product as ap', 'ap.idx', 'AF_order.product_idx')
            ->leftjoin('AF_attachment as at', function($query) {
                $query->on('at.idx', DB::raw('SUBSTRING_INDEX(ap.attachment_idx, ",", 1)'));
            })
            ->get();
    }

    public function makeOrderGroupCode($length)
    {
        $check = 1;
        $string_generated = "";

        while ($check != 0) {
            $characters  = "0123456789";
            $characters .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

            $nmr_loops = $length;
            while ($nmr_loops--)
            {
                $string_generated .= $characters[mt_rand(0, strlen($characters) - 1)];
            }

            $check = Order::where('order_group_code', $string_generated)->count();
        }

        return $string_generated;
    }

    public function makeOrder(array $param = [])
    {
        if ($param['name'] == '' || $param['address'] == '' || $param['addressDetail'] == '' || $param['zipcode'] == '' || $param['phone'] == '') {
            return response()->json([
                'success'=>false,
                'code'=>1000,
                'message'=>'필수값 없음'
            ]);
        }

        $orderGroupCode = '';
        $totalOrderGroupCode = '';
        $num = 1;
        $noti = [];

        foreach ($param['orderList'] as $key=>$list) {
            if ($key == 0 || $param['orderList'][$key - 1]['company_idx'] != $list['company_idx']) {
                $orderGroupCode = $this->makeOrderGroupCode(16);
                $totalOrderGroupCode .= $orderGroupCode.',';
                $num = 1;
            }

            if ($param['isCart'] == "1") {
                foreach ($list['idx'] as $key=>$idx) {
                    $cart = Cart::select('AF_cart.*', 'ap.name as productName')
                        ->where(['AF_cart.idx' => $idx, 'AF_cart.user_idx' => Auth::user()->idx])
                        ->leftjoin('AF_product as ap', function($query) {
                            $query->on('ap.idx', 'AF_cart.product_idx');
                        })
                        ->first();

                    if($num == 1) {

                        array_push($noti, [
                            'companyIdx'=>$list['company_idx'],
                            'productName'=>$cart['productName'],
                            'productCnt'=>1
                        ]);
                    } else {
                        $noti[count($noti)-1]['productCnt'] = $num;
                    }

                    $order = new Order;
                    $order->user_idx = Auth::user()->idx;
                    $order->order_state = 'N';
                    $order->product_idx = $cart['product_idx'];
                    $order->option_json = $cart['option_json'];
                    $order->count = $cart['count'];
                    $order->price = $cart['price'];
                    $order->memo = $list['memo'];
                    $order->name = $param['name'];
                    $order->address1 = $param['address'];
                    $order->address2 = $param['addressDetail'];
                    $order->zipcode = $param['zipcode'];
                    $order->phone_number = $param['phone'];
                    $order->order_group_code = $orderGroupCode;
                    $order->order_code = $orderGroupCode.'-'.sprintf('%04d',$num);
                    $order->register_time = DB::raw('now()');
                    $order->save();

                    Cart::where(['idx' => $idx, 'user_idx' => Auth::user()->idx])->delete();

                    $num ++;
                }
            } else {
                foreach ($list['option'] as $key=>$option) {
                    if($num == 1) {
                        array_push($noti, [
                            'companyIdx'=>$list['company_idx'],
                            'productName'=>$list['productName'],
                            'productCnt'=>1
                        ]);
                    } else {
                        $noti[count($noti)-1]['productCnt'] = $num;
                    }

                    $price = 0;
                    $count = 0;

                    $optionJson = [];
                    foreach ($option as $key=>$item) {
                        $price += $item['price'] * $item['count'];
                        $count = $item['count'];

                        if ($key != 0) {
                            array_push($optionJson, $item);
                        }
                    }

                    $order = new Order;
                    $order->user_idx = Auth::user()->idx;
                    $order->order_state = 'N';
                    $order->product_idx = $list['productIdx'];
                    $order->option_json = json_encode($optionJson);
                    $order->count = $count;
                    $order->price = $price;
                    $order->memo = $list['memo'];
                    $order->name = $param['name'];
                    $order->address1 = $param['address'];
                    $order->address2 = $param['addressDetail'];
                    $order->zipcode = $param['zipcode'];
                    $order->phone_number = $param['phone'];
                    $order->order_group_code = $orderGroupCode;
                    $order->order_code = $orderGroupCode.'-'.sprintf('%04d',$num);
                    $order->register_time = DB::raw('now()');
                    $order->save();

                    $num ++;
                }
            }

        }

        if ($param['is_new_address'] == 1) {
            $address = new UserAddress;
            $address->user_idx = Auth::user()->idx;
            $address->phone_number = $param['phone'];
            $address->name = $param['name'];
            $address->address1 = $param['address'];
            $address->address2 = $param['addressDetail'];
            $address->zipcode = $param['zipcode'];
            $address->save();
        }

        return response()->json([
            'success'=>true,
            'message'=>$totalOrderGroupCode
        ]);
    }

    public function successOrderData(string $orderGroupCode)
    {
        $data['deliveryData'] = Order::select('AF_order.name', 'AF_order.phone_number',
            DB::raw('(select sum(ao.price) from AF_order ao where ao.order_group_code = AF_order.order_group_code and ao.price > 0) as price,
            IF((select count(ao2.idx) from AF_order ao2 where ao2.order_group_code = AF_order.order_group_code and ao2.price < 1), "협의 포함", null) as inquiry,
            CONCAT("(",AF_order.zipcode,")",AF_order.address1," ",AF_order.address2) as address'))
            ->where('AF_order.order_group_code', explode(',', $orderGroupCode))
            ->where('AF_order.user_idx', Auth::user()->idx)
            ->first();

        $data['productData'] = Order::select('AF_order.order_group_code', 'AF_order.order_code', 'AF_order.product_idx', 'ap.company_idx', 'AF_order.option_json', 'ap.name',
            DB::raw('CONCAT(at.folder,"/", at.filename) as imgUrl,
            (CASE WHEN ap.company_type = "W" THEN (select aw.company_name from AF_wholesale as aw where aw.idx = ap.company_idx)
                    WHEN ap.company_type = "R" THEN (select ar.company_name from AF_retail as ar where ar.idx = ap.company_idx)
                    ELSE "" END) as companyName,
                    count(AF_order.product_idx) as productCnt'
            ))
            ->groupBy('ap.company_idx')
            ->whereIn('AF_order.order_group_code', explode(',', $orderGroupCode))
            ->where('AF_order.user_idx', Auth::user()->idx)
            ->join('AF_product as ap', 'ap.idx', 'AF_order.product_idx')
            ->leftjoin('AF_attachment as at', function($query) {
                $query->on('at.idx', DB::raw('SUBSTRING_INDEX(ap.attachment_idx, ",", 1)'));
            })
            ->orderBy('AF_order.idx', 'asc')
            ->get();

        return $data;
    }
}
