<?php

namespace App\Http\Controllers;

use App\Service\OrderService;
use App\Service\ProductService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;
use Session;

class OrderController extends BaseController
{
    private $orderService;
    private $productService;

    public function __construct(OrderService $orderService, ProductService $productService)
    {
        $this->middleware('auth');
        $this->orderService = $orderService;
        $this->productService = $productService;
    }

    // 장바구니 추가
    public function addCart(Request $request)
    {
        $cartIdx = '';
        $productIdx = $request->input('productIdx');
        $json = json_decode($request->input('option'));

        foreach($json as $item) {
            $data['productIdx'] = $productIdx;
            $data['required'] = $item[0]->required;
            $data['count'] = $item[0]->count;

            $option = [];
            $eachPrice = 0;

            foreach ($item as $key=>$card) {
                $eachPrice += $card->price;

                if ($key != 0) {
                    $arr['required'] = $item[0]->required;
                    $arr['name'] = $card->name;
                    $arr['value'] = $card->value;
                    $arr['price'] = $card->price;

                    array_push($option, $arr);
                }
            }

            $data['eachPrice'] = $eachPrice;
            $data['price'] = $item[0]->count * $eachPrice;
            $data['option'] = json_encode($option);

            $cartIdx .= $this->orderService->addCart($data).',';
        }

        return response()->json([
            'success'=> true,
            'cartIdx'=> substr($cartIdx, 0, -1)
        ]);
    }

    // 장바구니 옵션 추가
    public function addCartOption(Request $request)
    {
        $cartIdx = $this->orderService->addCart($request->all());

        return response()->json([
            'success'=> true,
            'cartIdx'=> $cartIdx
        ]);
    }

    // 장바구니 데이터 가져오기
    public function cart()
    {
        return view('order.cart', [
            'cartList'=>$this->orderService->getCartList()
        ]);
    }

    // 주문하가(장바구니)
    // 주문 상품 상태 변경 체크(품절, 판매중단)
    public function updateCart(Request $request)
    {
        $checkList = [];
        $stopSelling = [];

        foreach ($request->input('data') as $item) {
            array_push($checkList, $item['idx']);
        }

        $stopSelling = $this->orderService->checkProductState($checkList);
        if (count($stopSelling) > 0) {
            return response()->json([
                'success'=>false,
                'code'=> 1001,
                'data'=>$stopSelling
            ]);
        }

        $cartIdx = $this->orderService->updateCart($request->all());

        return response()->json([
            'success'=>true,
            'cartIdx'=> $cartIdx
        ]);
    }

    public function addOrder(Request $request)
    {
        $orderIdx = $this->orderService->addOrder($request->all());

        return response()->json([
            'success'=> $orderIdx != null ? true : false,
            'message'=> ''
        ]);
    }

    // 장바구니 삭제
    public function removeCart(Request $request)
    {
        return $this->orderService->removeCart($request->all());
    }

    // 주문 데이터 가져오기 (장바구니)
    public function orderForm(Request $request, string $cartIdx = ''): view
    {
        $accountInfo = $this->orderService->getAccountInfo();
        $orderList = $this->orderService->getCartList($cartIdx);

        return view('order.order', [
            'accountInfo'=> $accountInfo,
            'orderList'=>$orderList,
            'isCart'=>1
        ]);
    }

    // 주문 데이터 가져오기 (상품 상세페이지 | 바로 주문)
    public function orderForm2(Request $request): view
    {
        $accountInfo = $this->orderService->getAccountInfo();
        $productInfo = $this->productService->getProductData($request->get('productIdx'));

        return view('order.order', [
            'accountInfo'=> $accountInfo,
            'productInfo'=> $productInfo['detail'],
            'isCart'=> 0
        ]);
    }

    // 주문 처리
    public function makeOrder(Request $request)
    {
        return $this->orderService->makeOrder($request->all());
    }

    // 주문 완료
    public function success(string $orderCode): view
    {
        return view('order.success', [
            'data'=>$this->orderService->successOrderData($orderCode)
        ]);
    }

}
