<?php


namespace App\Service;


use App\Models\Attachment;
use App\Models\CancelHistory;
use App\Models\Category;
use App\Models\CompanyRetail;
use App\Models\CompanyWholesale;
use App\Models\CompanyNormal;
use App\Models\LikeCompany;
use App\Models\Location;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\Product;
use App\Models\ProductInterest;
use App\Models\ProductInterestFolder;
use App\Models\ProductRecent;
use App\Models\ProductStateHistory;
use App\Models\ProductTemp;
use App\Models\User;
use App\Models\UserAuthCode;
use App\Models\UserUnregisterHistory;
use App\Models\UserUpgradeQueue;
use App\Models\Estimate;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use \Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class MypageService
{
    /*
     * 주문 완료/신규 주문: N
     * 거래 확정/상품 준비중: R
     * 배송중/발송중: D
     * 구매 확정 대기: W
     * 거래 완료: F
     * 거래 취소/주문 취소: C
     */
    /**
     * 거래 총 수량 가져오기
     * @param array params
     * @return Collection
     */
    public function getTotalOrderCount(array $params=[]): Collection
    {
        $stats = array_keys(config('constants.ORDER.STATUS.S'));
        $result = [];
        foreach($stats as $stat) {
            $$stat = Order::where('order_state', $stat)
                ->join('AF_product', 'AF_product.idx', 'AF_order.product_idx')
                ->groupBy('order_group_code');
            if ($params['orderType'] === 'S') { // 판매자인경우
                $$stat->join('AF_wholesale', 'AF_wholesale.idx', 'AF_product.company_idx')
                ->where('AF_product.company_idx', Auth::user()['company_idx'])
                ->where('AF_product.company_type', Auth::user()['type']);
            } else {
                $$stat->join('AF_user', 'AF_user.idx', 'AF_order.user_idx')
                    ->where('AF_order.user_idx', Auth::user()['idx']);
            }

            $result[$stat] = count($$stat->get());
        }

        return collect($result);
    }

    /**
     * 판매 현황 / 구매 현황
     * @param array $params
     * @return array
     */
    public function getOrderList(array $params): array {
        $offset = isset($params['offset']) && $params['offset'] > 1 ? ($params['offset'] -1 ) * $params['limit'] : 0;
        $limit = $params['limit'];

        $where = "";
        $join = "";

        // 키워드 검색
        if (isset($params['keywordType']) && isset($params['keyword'])) {
            switch($params['keywordType']) {
                case 'orderNum':
                    $where .= " AND (`order`.order_group_code LIKE '%{$params['keyword']}%' OR `order`.order_code LIKE '%{$params['keyword']}%') ";
                    break;
                case 'productName':
                    $where .= " AND `product`.name LIKE '%{$params['keyword']}%' ";
                    break;
                case 'purchaser':   //구매 업체 (판매 현황일 때만 나옴)
                    $where .= " AND ( `wholesale`.company_name LIKE '%{$params['keyword']}%' OR `retail`.company_name LIKE '%{$params['keyword']}%' )";
                    break;
                case 'dealer':
                    $where .= " AND `wholesale`.company_name LIKE '%{$params['keyword']}%' ";
                    break;
                default:
                    break;
            }
        } else if (!isset($params['keywordType']) && isset($params['keyword']) && !empty($params['keyword'])) {
            $orWhere = [];
            $orWhere[] = " (`order`.order_group_code LIKE '%{$params['keyword']}%' OR `order`.order_code LIKE '%{$params['keyword']}%') ";
            $orWhere[] = " `product`.name LIKE '%{$params['keyword']}%' ";
            if ($params['orderType'] === 'S') {
                $orWhere[] = " `retail`.company_name LIKE '%{$params['keyword']}%' ";
                $orWhere[] = " `wholesale`.company_name LIKE '%{$params['keyword']}%' ";
            } else {
                $orWhere[] = " `wholesale`.company_name LIKE '%{$params['keyword']}%' ";
            }
            $where .= " AND (".join('OR', $orWhere).")";
        }

        // 기간 검색
        if (isset($params['orderDate'])) {
            $orderRegisterDate = explode('~', $params['orderDate']);
            if (isset($orderRegisterDate[0])) {
                $where .= " AND `order`.register_time >= '".trim($orderRegisterDate[0])." 00:00:00' ";
            }
            if (isset($orderRegisterDate[1])) {
                $where .= " AND `order`.register_time <= '".trim($orderRegisterDate[1])." 23:59:59' ";
            }
        }

        if (isset($params['status'])) {
            $where .= " AND `order`.order_state = '{$params['status']}' ";
        }

        if ($params['orderType'] === 'S') { // 판매자인경우
            $where .= " AND `product`.company_type = '".Auth::user()['type']."' AND `product`.company_idx = ".Auth::user()['company_idx'];
            $join .= " LEFT JOIN AF_wholesale AS `wholesale` ON `wholesale`.idx = `user`.company_idx AND `user`.type = 'W'
                    LEFT JOIN AF_retail AS `retail` ON `retail`.idx = `user`.company_idx AND `user`.type = 'R' ";
        } else { // 구매자인경우
            $where .= " AND `order`.user_idx = '".Auth::user()['idx']."'";
            $join .= " LEFT JOIN AF_wholesale AS `wholesale` ON `wholesale`.idx = `product`.company_idx AND `product`.company_type = 'W'
                    LEFT JOIN AF_retail AS `retail` ON `retail`.idx = `product`.company_idx AND `product`.company_type = 'R' ";
        }

        $sql = "SELECT 
                    *,
                    CONCAT(`order`.product_name, IF(COUNT(*) > 1, CONCAT(' 외 ',
                    IF(COUNT(*) - 1 > 100, '99+', COUNT(*) - 1), '건'), '')) AS product_name,
                    COUNT(*) AS cnt,
                    COUNT(order.order_group_code) - 1 AS group_cnt
                FROM 
                (
                    SELECT 
                        `order`.idx, `order`.order_group_code, `order`.order_code, `order`.product_idx, `product`.name AS product_name,
                        `order`.order_state, DATE_FORMAT(`order`.register_time, '%Y.%m.%d') AS register_time,
                        IF(`wholesale`.company_name IS NOT NULL, `wholesale`.company_name, `retail`.company_name) AS company_name
                    FROM AF_order AS `order`
                    INNER JOIN AF_product AS `product` ON `order`.product_idx = `product`.idx
                    INNER JOIN AF_user AS `user` ON `user`.idx = `order`.user_idx
                    INNER JOIN AF_estimate AS `estimate` ON `order`.order_code = `estimate`.estimate_code 
                    {$join}
                    WHERE 1 = 1 {$where}
                ) `order`
                GROUP BY order.order_group_code
                ORDER BY `order`.register_time DESC, `order`.idx DESC";
        Log::info('sql -> '.$sql);
        $orders = DB::select($sql);

        $data['orderListCount'] = count($orders);
        $data['orders'] = DB::select($sql . " LIMIT {$offset}, {$limit}");
        $data['pagination'] = paginate($params['offset'], $params['limit'], $data['orderListCount']);

        return $data;
    }

    /**
     * 주문/거래 상태 변경
     * @param array $params
     * @return array
     * @throws Exception
     */
    public function changeStatus(array $params): array
    {
        $messageParams = [
            'orderNum' => $params['orderNum'],
            'templateType' => 'ORDER',
        ];
        $alarmParams = [
            'link_url' => '/mypage/order/detail?orderGroupCode='. $params['orderNum'].'&type=',
            'depth1' => 'order',
            'depth2' => $params['type'],
        ];

        $orders = Order::where(function($query) use($params) {
            $query->where('order_group_code', $params['orderNum'])
                ->orWhere('order_code', $params['orderNum']);
        });
        $orders->select('AF_order.*');

        if ($params['type'] === 'S') { // S: seller: 판매자 주문 상태 변경
            $orders->join('AF_product', 'AF_product.idx', 'AF_order.product_idx')
                ->where('AF_product.company_idx', Auth::user()['company_idx'])->where('AF_product.company_type', 'W');
        } else { // P: purchase: 주문자 주문 상태 변경
            $orders->where('user_idx', Auth::user()['idx']);
        }

        switch($params['status']) {
            case 'R': // 거래확정/상품준비중
                $prevOrderCount = $orders->count();
                $orders->where('order_state', 'N');
                $messageParams['templateDetailType'] = 'DEAL_COMP';
                $alarmParams['depth3'] = 'READY';
                if ($prevOrderCount != $orders->count() && $orders->count() > 0) {
                    return [
                        'result' => 'fail',
                        'code' => "ALREADY_{$params['status']}_CANCEL",
                        'message' => '이미 취소된 주문입니다.'
                    ];
                }
                $orders = $orders->get();
                break;
            case 'C': // 거래/주문 취소
                $orders = $orders->where('order_state', 'N')->get();
                $messageParams['templateDetailType'] = 'CANCEL';
                $alarmParams['depth3'] = 'CANCEL';
                if ($orders->count() < 1) {
                    return [
                        'result' => 'fail',
                        'code' => "ALREADY_{$params['status']}_CANCEL",
                        'message' => '이미 취소된 주문입니다.'
                    ];
                }
                break;
            case 'D': // 발송중/배송중
                $orders = $orders->where('order_state', 'R')->get();
                $messageParams['templateDetailType'] = 'START_SHIPPING';
                $alarmParams['depth3'] = 'DELIVERY';
                break;
            case 'W': // 구매확정대기
                $orders = $orders->where('order_state', 'D')->get();
                $messageParams['templateDetailType'] = 'CONFIRM';
                $alarmParams['depth3'] = 'WAITING';
                break;
            case 'F': // 거래완료
                $orders = $orders->where('order_state', 'W')->get();
                $alarmParams['depth3'] = 'FINISH';
                break;
            default:
                return [
                    'result' => 'fail',
                    'code' => 'ERR_STATUS',
                    'message' => '정상적인 접근이 아닙니다.'
                ];
        }

        if ($orders -> count() < 1) {
            return [
                'result' => 'fail',
                'code' => 'EMPTY_ORDER',
                'message' => '정상적인 접근이 아닙니다.'
            ];
        }

        /*
        $isSendMessage = false;
        $isSendAlarm = false;
        $alarmService = new AlarmService();
        $messageService = new MessageService();
        */
        foreach($orders as $order) {
            // 주문 상태 변경
            if ($params['status'] === 'C') { // 거래 취소일 경우
                $order->is_cancel = 1;
            }
            $order->order_state = $params['status'];
            $order->save();

            // 주문 기록 저장
            $history = new OrderHistory;
            $history->order_idx = $order->idx;
            $history->state = $params['status'];
            if ($params['status'] === 'C') {
                $history->cancel_reason = $params['cancelReason'];
            }
            $history->save();

            // 거래 취소일 경우
            if ($params['status'] === 'C') {
                $cancelHistory = new CancelHistory;
                $cancelHistory->order_idx = $order->idx;
                $cancelHistory->cancel_reason = $params['cancelReason'];
                $cancelHistory->save();
            }

            /*
            if ($isSendAlarm === false && isset($alarmParams['depth3'])) {
                $link_url = $alarmParams['link_url'];
                $alarmParams['target_company_idx'] = Auth::user()['company_idx'];
                $alarmParams['target_company_type'] = Auth::user()['type'];
                $productName = Order::where(function($query) use($params) {
                    $query->where('order_group_code', $params['orderNum'])
                        ->orWhere('order_code', $params['orderNum']);
                })->join('AF_product', 'AF_product.idx', 'AF_order.product_idx')
                ->select(DB::raw('IF(COUNT(*) > 1,
                    CONCAT(AF_product.name," 외",(COUNT(*)-1),"건"),
                    AF_product.name) AS product_name'))->first();
                $alarmParams['variables'] = [$productName->product_name];
                $alarmParams['link_url'] = $link_url . $params['type'];
                $alarmService->sendAlarm($alarmParams);
                if ($params['type'] === 'S') {
                    $targetUser = Order::where(function($query) use($params) {
                        $query->where('order_group_code', $params['orderNum'])
                            ->orWhere('order_code', $params['orderNum']);
                        })
                        ->join('AF_user', 'AF_user.idx', 'AF_order.user_idx')
                        ->select('AF_user.type', 'AF_user.company_idx')
                        ->first();
                    $alarmParams['target_company_idx'] = $targetUser->company_idx;
                    $alarmParams['target_company_type'] = $targetUser->type;
                    $alarmParams['depth2'] = 'P';
                    $alarmParams['link_url'] = $link_url . 'P';
                    $alarmService->sendAlarm($alarmParams);
                } else {
                    $targetUser = Order::where(function($query) use($params) {
                        $query->where('order_group_code', $params['orderNum'])
                            ->orWhere('order_code', $params['orderNum']);
                        })
                        ->join('AF_product', 'AF_product.idx', 'AF_order.product_idx')
                        ->select('AF_product.company_type', 'AF_product.company_idx')
                        ->first();
                    $alarmParams['target_company_idx'] = $targetUser->company_idx;
                    $alarmParams['target_company_type'] = $targetUser->company_type;
                    $alarmParams['depth2'] = 'S';
                    $alarmParams['link_url'] = $link_url . 'S';
                    $alarmService->sendAlarm($alarmParams);
                }
                $isSendAlarm = true;
            }

            if ($isSendMessage === false && isset($messageParams['templateDetailType']) && $messageParams['templateDetailType'] === 'DEAL_COMP') {
                $sendUser = User::find($order->user_idx);
                $messageParams['company_idx'] = $sendUser->company_idx;
                $messageParams['company_type'] = $sendUser->type;
                $messageService->sendRoomMessage($messageParams);

                $alarmParams['content'] = config('constants.MESSAGE.ORDER.'.$messageParams['templateDetailType'].".TEXT");
                $alarmParams['depth1'] = 'active';
                $alarmParams['depth2'] = 'talk';
                $alarmParams['depth3'] = 'talk';
                $alarmParams['link_url'] = '/message';
                $alarmParams['target_company_idx'] = $sendUser->company_idx;
                $alarmParams['target_company_type'] = $sendUser->type;
                //$alarmService->sendAlarm($alarmParams);

                $isSendMessage = true;
            }
            */
        }

        $sql =
            "SELECT au.idx as userIdx, ap.name FROM AF_product ap
            LEFT JOIN AF_user au
            ON au.company_idx  = ap.company_idx AND au.parent_idx = 0
            WHERE ap.idx = " .$orders[0]['product_idx'];
        $product = DB::select($sql);

        $productName = count($orders) > 1 ?  $product[0]->name .'외 ' .count($params['estimate_idx'])-1 .'개' : $product[0]->name;

        switch($params['status']) {
            case 'R':
                $title_request = '거래 확정 안내';
                $message_request = $productName .' 상품 주문이 확정되었습니다.';

                $title_response = '상품 준비 중 안내';
                $message_response = $productName .' 주문 건이 상품 준비 중 상태로 변경되었습니다.';

                break;

            case 'C':
                $title_request = '거래 취소 안내';
                $message_request = $productName .' 상품 거래가 취소되었습니다.';

                $title_response = '주문 취소 안내';
                $message_response = $productName .' 상품 주문이 취소되었습니다.';
                break;

            case 'D':
                $title_request = '배송 중 안내';
                $message_request = $productName .' 상품의 배송이 시작되었습니다.';

                $title_response = '발송 중 안내';
                $message_response = $productName .' 주문 건이 발송 중 상태로 변경되었습니다.';
                break;

            case 'W':
                $title_request = '구매 확정 요청 안내';
                $message_request = $productName .' 상품 구매를 확정해주세요.';

                $title_response = '구매 확정 대기 안내';
                $message_response = $productName .' 주문 건이 구매 확정 대기 상태로 변경되었습니다.';
                break;

            case 'F':
                $title_request = '거래 완료 안내';
                $message_request = $productName .' 상품 거래가 완료되었습니다.';

                $title_response = '거래 완료 안내';
                $message_response = $productName .' 주문 건 거래가 완료되었습니다.';
                break;
        }

        $pushService = new PushService();
        // 구매자
        $pushService -> sendPush(
            $title_request, $message_request, $orders[0] -> user_idx, $type = 5, 'https://allfurn-web.codeidea.io/mypage/purchase', '/mypage/purchase'
        );

        // 판매자
        $pushService -> sendPush(
            $title_response, $message_response, $product[0]->userIdx, $type = 5, 'https://allfurn-web.codeidea.io/mypage/deal', '/mypage/deal'
        );

        return [
            'result' => 'success',
            'message' => ''
        ];
    }

    /**
     * 주문 상세 정보 가져오기
     * @param array $params
     * orderGroupCode: 주문 그룹 코드
     * type: S: seller(판매자), P: purchase(구매자)
     * @return mixed
     * @throws \Exception
     */
    public function getOrderDetail(array $params)
    {
        if (isset($params['orderGroupCode'])) {
            $order = Order::where('order_group_code', $params['orderGroupCode']);
        } else if (isset($params['orderCode'])) {
            $order = Order::where('order_code', $params['orderCode']);
        } else {
            throw new \Exception();
        }

        $order
            -> join('AF_estimate', 'AF_estimate.estimate_code', 'AF_order.order_code')
            -> join('AF_user', 'AF_user.idx', 'AF_order.user_idx')
            -> join('AF_product', 'AF_product.idx', 'AF_estimate.product_idx');

        if ($params['type'] === 'S') {
            $order
                -> select(
                    'AF_order.*', DB::raw("DATE_FORMAT(AF_order.register_time, '%Y.%m.%d') AS reg_time"), 'AF_product.pay_notice AS p_pay_notice', 'AF_estimate.product_delivery_info AS p_delivery_info', 'AF_product.name AS product_name', 'AF_estimate.product_count', 'AF_estimate.product_each_price', 'AF_estimate.product_each_price_text AS price_text', 'AF_estimate.product_total_price AS product_price', 'AF_estimate.product_option_json', 'AF_estimate.product_option_price', 'AF_estimate.product_delivery_price', DB::raw('CONCAT("'.preImgUrl().'", AF_attachment.folder, "/", AF_attachment.filename) AS product_image')
                )
                -> join('AF_attachment', 'AF_attachment.idx', DB::raw('SUBSTRING_INDEX(AF_product.attachment_idx, ",", 1)'))
                -> where('AF_product.company_type', 'W') -> where('AF_product.company_idx', Auth::user()['company_idx']);
        } else {
            $order
                -> select(
                    'AF_order.*', DB::raw("DATE_FORMAT(AF_order.register_time, '%Y.%m.%d') AS reg_time"), 'AF_product.pay_notice AS p_pay_notice', 'AF_estimate.product_delivery_info AS p_delivery_info', 'AF_product.name AS product_name', 'AF_estimate.product_count', 'AF_estimate.product_each_price', 'AF_estimate.product_each_price_text AS price_text', 'AF_estimate.product_total_price AS product_price', 'AF_estimate.product_option_json', 'AF_estimate.product_option_price', 'AF_estimate.product_delivery_price', DB::raw('CONCAT("'.preImgUrl().'", AF_attachment.folder, "/", AF_attachment.filename) AS product_image')
                )
                -> join('AF_attachment', 'AF_attachment.idx', DB::raw('SUBSTRING_INDEX(AF_product.attachment_idx, ",", 1)'))
                -> where('AF_user.idx', Auth::user()['idx']);
        }

        if(isset($params['state'])) {
            switch($params['state']) {
                case 'C': // 취소중
                    $order->where('order_state', 'N')
                        ->addSelect(DB::raw(
                        "(
                            SELECT
                                IF(
                                    wholesale.company_name IS NOT NULL,
                                    wholesale.company_name,
                                    retail.company_name
                                )
                            FROM
                                AF_product product
                                    LEFT JOIN AF_wholesale wholesale
                                        ON wholesale.idx = product.company_idx
                                           AND product.company_type = 'W'
                                    LEFT JOIN AF_retail retail
                                        ON retail.idx = product.company_idx
                                           AND product.company_type = 'R'
                            WHERE product.idx = AF_order.product_idx
                            LIMIT 1
                           ) AS company_name") );
                    break;
            }
        }

        $orders = $order->get();
        if ($orders->count() < 1) {
            throw new Exception('empty order');
        }

        return $orders;
    }

    /**
     * 주문자 정보 가져오기
     * @param array $params
     * @return mixed
     */
    public function getOrderBuyer(array $params)
    {
        return Order::where('order_group_code', $params['orderGroupCode'])
            ->join('AF_product', 'AF_product.idx', 'AF_order.product_idx')
            ->join('AF_user', 'AF_user.idx', 'AF_order.user_idx')
            ->leftJoin('AF_wholesale', function($query) {
                $query->on('AF_wholesale.idx', 'AF_user.company_idx')->where('AF_user.type', 'W');
            })
            ->leftJoin('AF_retail', function($query) {
                $query->on('AF_retail.idx', 'AF_user.company_idx')->where('AF_user.type', 'R');
            })
            ->select('AF_order.*', 'AF_user.account', 'AF_user.phone_number AS user_phone_number', 'AF_product.price_text'
                , 'AF_wholesale.company_name AS w_company_name', 'AF_retail.company_name AS r_company_name'
                , DB::raw("(SELECT SUM(price) AS total_price FROM AF_order WHERE order_group_code = '{$params['orderGroupCode']}') AS total_price"))
            ->first();
    }

    /**
     * 주문/거래 취소 리스트
     * @param array $params
     * @return mixed
     */
    public function getOrderCancelList(array $params)
    {
        $order = Order::where('order_group_code', $params['orderGroupCode'])
            ->where('order_state', 'C')
            ->join('AF_product', 'AF_product.idx', 'AF_order.product_idx')
            ->join('AF_attachment', 'AF_attachment.idx', DB::raw('SUBSTRING_INDEX(AF_product.attachment_idx, ",", 1)'))
            ->join('AF_user', 'AF_user.idx', 'AF_order.user_idx')
            ->join('AF_cancel_history', 'AF_cancel_history.order_idx', 'AF_order.idx')
            ->select('AF_order.*', 'AF_cancel_history.cancel_reason'
                , DB::raw("DATE_FORMAT(AF_cancel_history.regitser_time, '%Y.%m.%d') AS cancel_date")
                , 'AF_product.pay_notice AS p_pay_notice', 'AF_product.delivery_info AS p_delivery_info'
                , 'AF_product.name AS product_name', 'AF_product.price_text', 'AF_product.price AS product_price'
                , DB::raw('CONCAT("'.preImgUrl().'",AF_attachment.folder,"/", AF_attachment.filename) AS product_image')
            );
        if ($params['type'] === 'S') {
            $order->where('AF_product.company_type', 'W')->where('AF_product.company_idx', Auth::user()['company_idx']);
        } else {
            $order->where('AF_user.idx', Auth::user()['idx'] );
        }
        return $order->get();
    }

    /**
     * 모든 대표 카테고리 가져오기
     * @return mixed
     */
    public function getCategories()
    {
        return Category::whereNull('parent_idx')->get();
    }

    public function getTotalLikeProduct() {
        return ProductInterest::where('AF_product_interest.user_idx', Auth::user()['idx'])
            ->join('AF_product', 'AF_product.idx', 'AF_product_interest.product_idx')
            ->get()
            ->count();
    }

    /**
     * 관심 상품 목록 가져오기
     * @param array $params
     * @return Array
     */
    public function getInterestProducts(array $params): Array
    {
        $offset = $params['offset'] > 1 ? ($params['offset'] - 1) * $params['limit'] : 0;
        $limit = $params['limit'];

        $query = 
            ProductInterest::where('AF_product_interest.user_idx', Auth::user()['idx'])
            -> join('AF_product', 'AF_product.idx', 'AF_product_interest.product_idx')
            -> leftJoin('AF_attachment', 'AF_attachment.idx',
            DB::raw('SUBSTRING_INDEX(AF_product.attachment_idx, ",", 1)'))
            -> leftJoin('AF_product_interest_folder', function($query) {
                $query -> on('AF_product_interest_folder.idx', 'AF_product_interest.folder_idx');
            })
            -> leftJoin('AF_wholesale', function($query) {
                $query -> on('AF_wholesale.idx', 'AF_product.company_idx') -> where('AF_product.company_type', 'W');
            })
            -> leftJoin('AF_retail', function($query) {
                $query -> on('AF_retail.idx', 'AF_product.company_idx') -> where('AF_product.company_type', 'R');
            })
            -> select(
                'AF_product.idx', 'AF_product.name AS product_name', 'AF_product.price', 'AF_product.price_text', 'AF_product_interest_folder.name AS folder_name',
            DB::raw(
                'IF(AF_wholesale.idx IS NOT NULL, AF_wholesale.company_name, AF_retail.company_name) 
                AS company_name'),
            DB::raw(
                'CONCAT("'.preImgUrl().'",AF_attachment.folder,"/", AF_attachment.filename) 
                AS product_image'));
        if (isset($params['folder'])) {
            $query -> where('AF_product_interest.folder_idx', $params['folder']);
        }
        if (isset($params['ca'])) {
            $query -> where('AF_product.category_idx', $params['ca']);
        }
        if (isset($params['categories'])) {
            $query -> join('AF_category', function($query) use ($params) {
                $query -> on('AF_category.idx', 'AF_product.category_idx') -> whereIn('AF_category.parent_idx', explode(',', $params['categories']));
            });
        }
        $query -> distinct();

        $count = $query -> get() -> count();
        $list = $query -> orderBy('AF_product_interest.idx', 'DESC') -> offset($offset) -> limit($limit) -> get();

        $data['count'] = $count;
        $data['list'] = $list;
        $data['pagination'] = paginate($params['offset'], $params['limit'], $count);

        return $data;
    }

    /**
     * 내 폴더 리스트 가져오기
     * @return mixed
     */
    public function getMyFolders()
    {
        return ProductInterestFolder::where('user_idx', Auth::user()['idx'])
            ->select('AF_product_interest_folder.*'
                , DB::raw("(SELECT COUNT(*) FROM AF_product_interest WHERE folder_idx = AF_product_interest_folder.idx) AS product_count"))
            ->get();
    }

    /**
     * 폴더 추가
     * @param array $adds
     */
    public function addMyFolders(array $adds)
    {
        $user_idx = Auth::user()['idx'];
        $inserts = [];
        foreach($adds as $add) {
            $inserts[] = ['user_idx' => $user_idx, 'name' => $add];
        }
        ProductInterestFolder::insert($inserts);
    }

    /**
     * 폴더 수정
     * @param array $updates
     */
    public function updateMyFolders(array $updates)
    {
        $user_idx = Auth::user()['idx'];
        foreach($updates as $update) {
            ProductInterestFolder::where('user_idx', $user_idx)
                ->where('idx',$update['idx'])
                ->update(['name' => $update['folder_name']]);
        }
    }

    /**
     * 내 폴더 삭제하기
     * @param int $idx
     * @return string[]
     */
    public function removeMyFolders(int $idx): array
    {
        ProductInterestFolder::where('idx', $idx)->where('user_idx', Auth::user()['idx'])->delete();
        ProductInterest::where('folder_idx', $idx)->where('user_idx', Auth::user()['idx'])->delete();
        return [
            'result' => 'success',
            'message' => ''
        ];
    }

    /**
     * 내 관심 상품 삭제하기
     * @param array $params
     * @return array
     */
    public function removeMyInterestProducts(array $params): array
    {
        $user_idx = Auth::user()['idx'];
        foreach($params['idxes'] as $idx) {
            if (isset($params['folderId']) && !empty($params['folderId'])) {
                ProductInterest::where('product_idx', $idx)
                    ->where('user_idx', $user_idx)
                    ->where('folder_idx', $params['folderId'])->delete();
            } else {
                ProductInterest::where('product_idx', $idx)->where('user_idx', $user_idx)->delete();
            }
        }
        return [
            'result' => 'success',
            'message' => ''
        ];
    }

    /**
     * 관심 상품 옮기기
     * @param array $params
     * @return array
     */
    public function moveMyInterestProducts(array $params): array
    {
        ProductInterest::whereIn('product_idx', $params['idxes'])->where('user_idx', Auth::user()['idx'])
            ->update(['folder_idx' => $params['folderId']]);
        return [
            'result' => 'success',
            'message' => ''
        ];
    }

    /**
     * 관심 상품 등록
     * @param array $params
     */
    public function addMyInterestProducts(array $params)
    {
        $user_idx = Auth::user()['idx'];
        $inserts = [];
        foreach ($params['idxes'] as $idx) {
            $inserts[] = ['user_idx' => $user_idx, 'product_idx' => $idx];
        }
        ProductInterest::insert($inserts);
    }

    public function getTotalLikeCompany() {
        return DB::table('AF_company_like')
        ->where('user_idx', Auth::user()['idx'])
        ->count();
    }

    /**
     * 좋아요 업체 목록 가져오기
     * @param array $params
     * @return array
     */
    public function getLikeCompanies(array $params): array
    {
        $offset = $params['offset'] > 1 ? ($params['offset'] - 1) * $params['limit'] : 0;
        $limit = $params['limit'];

        DB::statement('SET group_concat_max_len = 1000000');

        $where = "";
        // 카테고리 추가할 위치
        if (isset($params['regions'])) {
            $where .= " AND (wl.sido REGEXP '".str_replace(',', '|', $params['regions'])."' OR rl.sido REGEXP '".str_replace(',', '|', $params['regions'])."')";
        }

        $outerWhere = "";
        if (isset($params['categories'])) {
            foreach (explode(',', $params['categories']) as $category) {
                $outerWhere .= " FIND_IN_SET('{$category}', category_names) OR";
            }
            $outerWhere = " AND (".rtrim($outerWhere, 'OR').') ';
        }

        $fromSql = 
            "SELECT
                `cl`.`idx`, `cl`.`company_idx`, `cl`.`company_type`,
                IF(w.idx IS NOT NULL, w.company_name, r.company_name) AS company_name,
                IF(attach.idx IS NOT NULL, CONCAT('".preImgUrl()."', attach.folder, '/', attach.filename),  '')
                 AS profile_image,
                GROUP_CONCAT(SUBSTRING_INDEX(IF(w.idx IS NOT NULL, wl.sido, rl.sido), ' ', 1)) AS region,
                IF(TIMESTAMPDIFF(SECOND, cl.register_time, now() < 2592000), 'Y', 'N') 
                AS is_new,
                (SELECT SUBSTRING_INDEX(GROUP_CONCAT(JSON_OBJECT('name', ap.name, 'idx', ap.idx, 'image', CONCAT('".preImgUrl()."', aa.folder, '/', aa.filename)) ORDER BY ap.register_time DESC), '},', 4) FROM AF_product ap LEFT JOIN AF_attachment aa ON SUBSTRING_INDEX(ap.attachment_idx, ',', 1) = aa.idx WHERE ap.company_type = cl.company_type AND ap.company_idx = cl.company_idx) AS products,
                (SELECT GROUP_CONCAT(DISTINCT ac2.name) FROM AF_category ac INNER JOIN AF_product ap ON ac.idx = ap.category_idx INNER JOIN AF_category ac2 ON ac2.idx = ac.parent_idx WHERE ap.company_type = cl.company_type AND ap.company_idx = cl.company_idx)
                AS category_names
            FROM `AF_company_like` AS `cl`
            LEFT JOIN 
                (`AF_wholesale` AS `w` LEFT JOIN `AF_location` AS `wl` ON `wl`.`company_idx` = `w`.`idx` AND `wl`.`company_type` = 'W')
            ON `w`.`idx` = `cl`.`company_idx` AND `cl`.`company_type` = 'W'
            LEFT JOIN 
                (`AF_retail` AS `r` LEFT JOIN `AF_location` AS `rl` ON `rl`.`company_idx` = `r`.`idx` AND `rl`.`company_type` = 'R')
            ON `r`.`idx` = `cl`.`company_idx` AND `cl`.`company_type` = 'R'
            LEFT JOIN `AF_attachment` AS `attach`
            ON 
                `attach`.`idx` = `w`.`profile_image_attachment_idx` OR `attach`.`idx` = r.profile_image_attachment_idx
            WHERE `cl`.`user_idx` = ".Auth::user()['idx']." {$where}
            group by `cl`.`company_idx`, `cl`.`company_type` ORDER BY `cl`.idx DESC";
        $sql = "SELECT * FROM ({$fromSql}) AS tb WHERE 1 = 1 {$outerWhere}";
        $result = DB::select($sql);

        $data['count'] = count($result);
        $data['list'] = DB::select($sql . " LIMIT {$offset}, {$limit}");
        $data['pagination'] = paginate($params['offset'], $params['limit'], $data['count']);

        return $data;
    }

    public function getTotalRecentlyViewedProduct() {
        return ProductRecent::where('AF_recently_product.user_idx', Auth::user() -> idx)
            -> join('AF_product', function($query) {
                $query -> on('AF_product.idx', 'AF_recently_product.product_idx');
            })
            ->select('AF_product.idx')
            ->distinct()
            ->get()
            ->count();
    }

    /**
     * 최근 본 상품 목록 가져오기
     * @param array $params
     * @return array
     */
    public function getRecentProducts(array $params): array
    {
        $offset = $params['offset'] > 1 ? ($params['offset'] - 1) * $params['limit'] : 0;
        $limit = $params['limit'];

        $query =
            ProductRecent::select(DB::raw('AF_product.*'),
            DB::raw(
                '(CASE 
                    WHEN AF_product.company_type = "W" THEN 
                        (SELECT aw.company_name FROM AF_wholesale AS aw WHERE aw.idx = AF_product.company_idx)
                    WHEN AF_product.company_type = "R" THEN
                        (SELECT ar.company_name FROM AF_retail AS ar WHERE ar.idx = AF_product.company_idx)
                    ELSE ""
                END) AS company_name,
                CONCAT("'.preImgUrl().'", at.folder,"/", at.filename) AS product_image,
                (SELECT COUNT(DISTINCT pi.idx) cnt FROM AF_product_interest pi WHERE pi.product_idx = AF_product.idx AND pi.user_idx = '.Auth::user() -> idx.') AS isInterest'))
            -> where('AF_recently_product.user_idx', Auth::user() -> idx)
            -> join('AF_product', function($query) {
                $query -> on('AF_product.idx', 'AF_recently_product.product_idx');
            })
            -> leftjoin('AF_attachment AS at', function($query) {
                $query -> on('at.idx', DB::raw('SUBSTRING_INDEX(AF_product.attachment_idx, ",",  1)'));
            });
            if (isset($params['ca'])) {
                $query -> where('AF_product.category_idx', $params['ca']);
            }
            if(isset($params['categories'])) {
                $query -> join('AF_category', function($query) use ($params) {
                    $query -> on('AF_category.idx', 'AF_product.category_idx') -> whereIn('AF_category.parent_idx', explode(',', $params['categories']));
                });
            }
        $query = $query -> distinct();

        $count = $query -> get() -> count();
        $list = $query -> orderBy('AF_recently_product.idx', 'DESC') -> offset($offset) -> limit($limit) -> get();

        $data['count'] = $count;
        $data['list'] = $list;
        $data['pagination'] = paginate($params['offset'], $limit, $count);

        return $data;
    }

    public function getTotalInquiry() {
        return DB::table('AF_message')
            ->join('AF_message_room as amr', 'AF_message.room_idx', 'amr.idx')
            ->where(function($query) {
                $query->whereJsonContains('content->type', 'inquiry')
                      ->orWhereJsonContains('content->text', '상품 문의드립니다.');
            })
            ->where('AF_message.is_read', 0)
            ->where('amr.second_company_idx',  Auth::user() -> company_idx)
            ->get()
            ->count();
    }

    /**
     * 업체 상세 가져오기
     * @return mixed
     */
    public function getCompany()
    {
        DB::statement('SET group_concat_max_len = 1000000');
        return User::from('AF_user AS u')->where('u.idx', Auth::user()['idx'])
            ->leftJoin('AF_wholesale AS w', function($query) {
                $query->on('w.idx', 'u.company_idx')->where('u.type', 'W');
            })->leftJoin('AF_retail AS r', function($query) {
                $query->on('r.idx', 'u.company_idx')->where('u.type', 'R');
            })->leftJoin('AF_attachment AS a', function($query) {
                $query->on('a.idx', 'w.profile_image_attachment_idx')
                    ->orOn('a.idx','r.profile_image_attachment_idx');
            })->leftJoin('AF_attachment AS b', function($query) {
                $query->on('b.idx', 'w.top_banner_attachment_idx')
                    ->orOn('b.idx','r.top_banner_attachment_idx');
            // 소재지
            }) -> leftJoin('AF_location AS l', function($query) {
                $query -> on('l.company_idx', 'u.company_idx') -> on('l.company_type', 'u.type');
            })

            ->select(
                DB::raw("IF(w.idx IS NOT NULL, w.company_name, r.company_name) AS company_name")
                , DB::raw("IF(w.idx IS NOT NULL, w.introduce, r.introduce) AS introduce")
                , DB::raw("IF(w.idx IS NOT NULL, w.owner_name, r.owner_name) AS owner_name")
                , DB::raw("IF(w.idx IS NOT NULL, CONCAT(w.business_address, ' ', w.business_address_detail), CONCAT(r.business_address, ' ', r.business_address_detail)) AS address")
                , DB::raw("IF(w.idx IS NOT NULL, w.work_day, r.work_day) AS work_day")
                , DB::raw("IF(w.idx IS NOT NULL, w.business_email, r.business_email) AS business_email")
                , DB::raw("IF(w.idx IS NOT NULL, w.phone_number, r.phone_number) AS phone_number")
                , DB::raw("IF(w.idx IS NOT NULL, w.manager, r.manager) AS manager")
                , DB::raw("IF(w.idx IS NOT NULL, w.manager_number, r.manager_number) AS manager_number")
                , DB::raw("IF(w.idx IS NOT NULL, w.fax, r.fax) AS fax")
                , DB::raw("IF(w.idx IS NOT NULL, w.how_order, r.how_order) AS how_order")
                , DB::raw("IF(w.idx IS NOT NULL, w.website, r.website) AS website")
                , DB::raw("IF(w.idx IS NOT NULL, w.etc, r.etc) AS etc")
                , DB::raw("IF(w.idx IS NOT NULL, w.notice_title, r.notice_title) AS notice_title")
                , DB::raw("IF(w.idx IS NOT NULL, w.notice_content, r.notice_content) AS notice_content")
                , DB::raw("IF(a.idx IS NOT NULL, CONCAT('".preImgUrl()."', a.folder,'/', a.filename), '') AS profile_image")
                , DB::raw("IF(b.idx IS NOT NULL, CONCAT('".preImgUrl()."', b.folder,'/', b.filename), '') AS top_banner_image")
                , DB::raw("(SELECT COUNT(*) FROM AF_product WHERE company_type = u.type AND company_idx = u.company_idx) AS product_count")

                // 소재지
                , DB::raw("GROUP_CONCAT(SUBSTRING_INDEX(l.address1, ' ', 1)) AS regions")

                , DB::raw("(SELECT GROUP_CONCAT(DISTINCT ac2.name)
                        FROM AF_category ac
                            INNER JOIN AF_product ap ON ac.idx = ap.category_idx
                            INNER JOIN AF_category ac2 ON ac2.idx = ac.parent_idx
                        WHERE ap.company_type = u.type AND ap.company_idx = u.company_idx
                    ) AS category_names")
                , DB::raw("(SELECT concat('[',group_concat(JSON_OBJECT(
                        'idx', idx,
                        'is_domestic', is_domestic,
                        'default_address', address1,
                        'detail_address', address2,
                        'domestic_type', domestic_type,
                        'sido', sido
                      )),']') FROM AF_location
                        WHERE company_type = '".Auth::user()['type']."'
                        AND company_idx = '".Auth::user()['company_idx']."'
                        AND is_delete = 0
                    ) AS locations")
            )
            ->first();
    }

    /**
     * 이미지 업로드
     * @param $image
     * @param $path
     * @return string
     */
    public function uploadImage($image, $path): string
    {
        $stored = Storage::disk('s3')->put($path, $image);
        $explodeFileName = explode('/',$stored);
        $fileName = end($explodeFileName);
        $file = preImgUrl() . $path.'/' . $fileName;
        return asset($file);
    }

    /**
     * 이미지 삭제
     * @param $imageUrl
     * @param $path
     * @return string[]
     */
    public function deleteImage($imageUrl, $path=''): array
    {
        $explodeImage = explode('/', $imageUrl);
        $fileName = end($explodeImage);
        if ($path === '') {
            $path = trim(substr($imageUrl, 0, strrpos($imageUrl, '/')),'/');
        }
        Storage::disk('s3')->delete($path.'/'.$fileName);
        return [
            'result' => 'success',
            'message' => ''
        ];
    }

    /**
     * 업체 프로필 이미지 업로드
     * @param $profile_image
     * @return mixed
     */
    public function insertCompanyProfileImage($profile_image)
    {
        $path = "company/profile";
        $image = $this->uploadImage($profile_image, $path);
        $explodeImage = explode('/',$image);
        $imageName = end($explodeImage);
        $attach = new Attachment;
        $attach->folder = $path;
        $attach->filename = $imageName;
        $attach->save();
        return $attach->idx;
    }

    /**
     * 업체 소재지 추가
     * @param $params
     */
    public function insertCompanyLocation($params)
    {
        for($i = 1; $i <= 5; $i++) {
            if (isset($params['is_domestic_' . $i])) {
                $is_domestic = $params['is_domestic_' . $i];
                if (isset($params['location_id'][$i-1])) {
                    $location = Location::find($params['location_id'][$i-1]);
                } else {
                    $location = new Location;
                }
                if ($is_domestic === '0' && isset($params['domestic_type'][$i-1]) && !empty($params['domestic_type'][$i-1])) {

                    $location->company_type = Auth::user()['type'];
                    $location->company_idx = Auth::user()['company_idx'];
                    $location->address1 = config('constants.GLOBAL_DOMESTIC')[$params['domestic_type'][$i-1] - 1];
                    $location->address2 = $params['detail_address'][$i-1];
                    $location->is_domestic = 0;
                    $location->domestic_type = $params['domestic_type'][$i-1];
                    $location->sido = config('constants.GLOBAL_DOMESTIC')[$params['domestic_type'][$i-1] - 1];
                } else if ($is_domestic === '1' && isset($params['default_address'][$i-1]) && !empty($params['default_address'][$i-1])) {

                    $location->company_type = Auth::user()['type'];
                    $location->company_idx = Auth::user()['company_idx'];
                    $location->address1 = $params['default_address'][$i-1];
                    $location->address2 = $params['detail_address'][$i-1];
                    $location->is_domestic = '1';
                    $location->sido = explode(' ', $params['default_address'][$i-1])[0];
                }
                $location->save();
            }
        }
    }

    /**
     * 업체 정보 수정
     * @param array $params
     * @return string[]
     */
    public function updateCompany(array $params): array
    {
        // 프로필 이미지 업로드
        if (isset($params['profile_image'])) {
            $profile_image_attachment_idx = $this->insertCompanyProfileImage($params['profile_image']);
        }
        if (isset($params['top_banner'])) {
            $top_banner_attachment_idx = $this->insertCompanyProfileImage($params['top_banner']);
        }
        if (Auth::user()['type'] === 'W') {
            $company = CompanyWholesale::find(Auth::user()['company_idx']);
        } else {
            $company = CompanyRetail::find(Auth::user()['company_idx']);
        }
        $company->phone_number = $params['phone_number'];
        $company->work_day = $params['work_day'];
        $company->business_email = $params['business_email'];
        $company->manager = $params['manager'];
        $company->manager_number = $params['manager_number'];
        $company->fax = $params['fax'];
        $company->how_order = $params['how_order'];
        $company->website = $params['website'];
        $company->etc = $params['etc'];
        $company->notice_title = $params['notice_title'];
        $company->notice_content = $params['notice_content'];

        if ($params['introduce']) {
            $introduce = '<div class="fr-element fr-view">' . $params['introduce'] . '</div>';
            $company->introduce = $introduce;
        }
        if (isset($profile_image_attachment_idx)) {
            $company->profile_image_attachment_idx = $profile_image_attachment_idx;
        }
        if (isset($top_banner_attachment_idx)) {
            $company->top_banner_attachment_idx = $top_banner_attachment_idx;
        }
        $this->insertCompanyLocation($params);
        $company->save();

        return [
            'result' => 'success',
            'message' => ''
        ];
    }

    /**
     * 업체 소재지 삭제
     * @param $idx
     * @return array
     */
    public function deleteCompanyLocation($idx): array
    {
        Location::find($idx)->delete();
        return [
            'result' => 'success',
            'message' => '',
        ];
    }

    /**
     * 추천 상품 가져오기
     * @param $params
     * @return mixed
     */
    public function getRepresentProducts($params)
    {
        $query = Product::where('company_type', Auth::user()['type'])
            ->where('company_idx', Auth::user()['company_idx'])
            ->where('is_represent', '1')
            ->leftJoin('AF_attachment', 'AF_attachment.idx', DB::raw('SUBSTRING_INDEX(AF_product.attachment_idx, ",", 1)'))
            ->leftJoin('AF_category AS c1', 'c1.idx', 'AF_product.category_idx')
            ->leftJoin('AF_category AS c2', 'c2.idx', 'c1.parent_idx')
            ->select('AF_product.*', 'c1.name AS child_category', 'c2.name AS parent_category'
                , DB::raw('CONCAT("'.preImgUrl().'",AF_attachment.folder,"/",AF_attachment.filename) AS product_image')
                , DB::raw("(SELECT CASE WHEN COUNT(*) >= 100000000 THEN CONCAT(COUNT(*)/100000000,'억')
                           WHEN COUNT(*) >= 10000000 THEN CONCAT(COUNT(*)/10000000,'천만')
                           WHEN COUNT(*) >= 10000 THEN CONCAT(COUNT(*)/10000, '만')
                           WHEN COUNT(*) >= 1000 THEN CONCAT(COUNT(*)/1000, '천')
                           ELSE COUNT(*) END cnt FROM AF_product_interest WHERE product_idx = AF_product.idx) AS interest_product_count")
                , DB::raw("CASE WHEN inquiry_count >= 100000000 THEN CONCAT(inquiry_count/100000000,'억')
                           WHEN inquiry_count >= 10000000 THEN CONCAT(inquiry_count/10000000,'천만')
                           WHEN inquiry_count >= 10000 THEN CONCAT(inquiry_count/10000, '만')
                           WHEN inquiry_count >= 1000 THEN CONCAT(inquiry_count/1000, '천')
                           ELSE inquiry_count END inquiry_count")
                , DB::raw("CASE WHEN access_count >= 100000000 THEN CONCAT(access_count/100000000,'억')
                           WHEN access_count >= 10000000 THEN CONCAT(access_count/10000000,'천만')
                           WHEN access_count >= 10000 THEN CONCAT(access_count/10000, '만')
                           WHEN access_count >= 1000 THEN CONCAT(access_count/1000, '천')
                           ELSE access_count END access_count")
            );
            if (isset($params['categories'])) {
                $query->whereIn('c2.name', explode(',', $params['categories']));
            }
            if (isset($params['state'])) {
                $query->where('AF_product.state', $params['state']);
            }
            if (isset($params['keyword'])) {
                $query->where('AF_product.name', 'like', "%{$params['keyword']}%");
            }

            // 최근 등록순 / 등록순
            $query -> orderBy('AF_product.register_time', $params['order']);

            return $query->get();
    }

    /**
     * 업체 등록, 전체 + 임시 가져오기
     * @param array $params
     * @return array
     */
    public function getRegisterProducts(array $params): array
    {
        $offset = $params['offset'] > 1 ? ($params['offset']-1) * $params['limit'] : 0;
        $limit = $params['limit'];

        if (isset($params['type']) && $params['type'] == 'temp') {
            $query = ProductTemp::from('AF_product_temp AS p')->where('company_type', Auth::user()['type'])
                ->where('company_idx', Auth::user()['company_idx']);
            $query->addSelect(DB::raw("DATE_FORMAT(p.update_time, '%Y.%m.%d') AS update_time")
                ,"0 AS inquiry_count"
                ,"0 AS access_count");
        } else {
            $query = Product::from('AF_product AS p')->where('company_type', Auth::user()['type'])
                ->where('company_idx', Auth::user()['company_idx']);
            $query->where('is_represent', 0);
            $query->addSelect(DB::raw("CASE WHEN inquiry_count >= 100000000 THEN CONCAT(inquiry_count/100000000,'억')
                           WHEN inquiry_count >= 10000000 THEN CONCAT(inquiry_count/10000000,'천만')
                           WHEN inquiry_count >= 10000 THEN CONCAT(inquiry_count/10000, '만')
                           WHEN inquiry_count >= 1000 THEN CONCAT(inquiry_count/1000, '천')
                           ELSE inquiry_count END inquiry_count")
                , DB::raw("CASE WHEN access_count >= 100000000 THEN CONCAT(access_count/100000000,'억')
                           WHEN access_count >= 10000000 THEN CONCAT(access_count/10000000,'천만')
                           WHEN access_count >= 10000 THEN CONCAT(access_count/10000, '만')
                           WHEN access_count >= 1000 THEN CONCAT(access_count/1000, '천')
                           ELSE access_count END access_count"));
        }

        $query->leftJoin('AF_attachment', 'AF_attachment.idx', DB::raw('SUBSTRING_INDEX(p.attachment_idx, ",", 1)'))
        ->leftJoin('AF_category AS c1', 'c1.idx', 'p.category_idx')
        ->leftJoin('AF_category AS c2', 'c2.idx', 'c1.parent_idx')
        ->select('p.*', 'c1.name AS child_category', 'c2.name AS parent_category'
            , DB::raw("DATE_FORMAT(p.update_time, '%Y.%m.%d') AS update_time")
            , DB::raw('CONCAT("'.preImgUrl().'",AF_attachment.folder,"/",AF_attachment.filename) AS product_image')
            , DB::raw("(SELECT CASE WHEN COUNT(*) >= 100000000 THEN CONCAT(COUNT(*)/100000000,'억')
                       WHEN COUNT(*) >= 10000000 THEN CONCAT(COUNT(*)/10000000,'천만')
                       WHEN COUNT(*) >= 10000 THEN CONCAT(COUNT(*)/10000, '만')
                       WHEN COUNT(*) >= 1000 THEN CONCAT(COUNT(*)/1000, '천')
                       ELSE COUNT(*) END cnt FROM AF_product_interest WHERE product_idx = p.idx) AS interest_product_count")
        );
        if (isset($params['categories'])) {
            $query->whereIn('c2.name', explode(',', $params['categories']));
        }
        if (isset($params['state'])) {
            $query->where('p.state', $params['state']);
        }
        if (isset($params['keyword'])) {
            $query->where('p.name', 'like', "%{$params['keyword']}%");
        }

        $data['count'] = $query->count();

        // 최근 등록순 / 등록순
        $list = $query -> orderBy('p.register_time', $params['order']) -> offset($offset) -> limit($limit) -> get();

        $data['list'] = $list;
        $data['pagination'] = paginate($params['offset'], $params['limit'], $data['count']);
        return $data;
    }

    /**
     * 업체 등록/임시 상품 개수 가져오기
     * @return int[]
     */
    public function getTotalProductCount(): array
    {
        $return = [
            'register_count' => 0,
            'temp_register_count' => 0,
        ];
        $return['register_count'] = Product::where('company_idx', Auth::user()['company_idx'])
            ->where('company_type', Auth::user()['type'])->count();
        $return['temp_register_count'] = ProductTemp::where('company_idx', Auth::user()['company_idx'])
            ->where('company_type', Auth::user()['type'])->count();

        return $return;
    }

    /**
     * 업체 상품 상태 변경
     * @param array $params
     * @return array
     */
    public function changeProductState(array $params): array
    {
        $return = [
            'result' => 'fail',
            'code' => 'ERR_EMPTY',
            'message' => '처리 실패'
        ];
        $product = Product::find($params['idx']);

        $history = ProductStateHistory::where('is_admin', 1) // 관리자로 상태 변경한 경우 판매중지, 반려 상태인 경우에는 상태 변경이 안된다
            ->where('product_idx', $params['idx'])
            ->where('type', 'C')
            ->orderBy('register_time', 'desc')->first();
        if ($history && $history->type === $product->state) {
            $return['result'] = 'success';
            $return['message'] = config('constants.PRODUCT_STATUS')[$params['state']];
            $return['code'] = 'FAIL_STATE_' . strtoupper($product->state);
            return $return;
        }

        switch($product->state) {
            case 'W': // 승인 대기인 경우 상태 변경 불가
                $return['result'] = 'success';
                $return['message'] = '승인 대기인 경우 상태 변경이 불가합니다.';
                $return['code'] = 'FAIL_STATE_W';
                return $return;
                break;
            case 'R': // 반려
                $return['result'] = 'success';
                $return['message'] = '반려 상태인 경우 상태 변경이 불가합니다.';
                $return['code'] = 'FAIL_STATE_R';
                return $return;
                break;
            case 'S': // 판매중
            case 'O': // 품절
            case 'H': // 숨김
                $product->state = $params['state'];
                $product->save();
                $return['result'] = 'success';
                $return['message'] = '';
                $return['code'] = 'SUCCESS_STATE_CHANGE';
                break;
            case 'C': // 판매중지
                $product->state = $params['state'];
                $product->save();
                $return['result'] = 'success';
                $return['message'] = '';
                $return['code'] = 'SUCCESS_STATE_CHANGE';
                break;
        }
        $newHistory = new ProductStateHistory; // 판매자가 상태 변경한 경우
        $newHistory->product_idx = $params['idx'];
        $newHistory->admin_idx = Auth::user()['idx'];
        $newHistory->type = $params['state'];
        $newHistory->is_admin = 0;
        $newHistory->save();
        return $return;
    }

    /**
     * 업체 상품 삭제
     * @param $idx
     * @return array
     */
    public function deleteProduct($idx): array
    {
        Product::where('company_idx', Auth::user()['company_idx'])
            ->where('company_type', Auth::user()['type'])
            ->where('idx', $idx)->delete();
        return [
            'result' => 'success',
            'message' => ''
        ];
    }

    /**
     * 이메일, 휴대폰번호 인증 코드 보내기
     * @param array $params
     * @return array
     */
    public function sendAuth(array $params): array {
        
        $ip = $_SERVER['REMOTE_ADDR'];

        if ($ip === '127.0.0.1') {
            
            // local일 경우...

            return [
                'result' => 'success',
                'code' => '0',
                'message' => ''
            ];

        } else {
            
            $type = 'S';
            $target = $params['phone_number'];
        
            $url = env('ALLFURN_API_DOMAIN').'/user/send-authcode';
            $response = Http::asForm()->post($url, [
                'data' => '{"target":"'.$target.'", "type":"'.$type.'"}',
            ]);
            $body = json_decode($response->body(), true);
            if ($body['code'] === '0') {
                return [
                    'result' => 'success',
                    'code' => '0',
                    'message' => ''
                ];
            } else {
                return [
                    'result' => 'fail',
                    'code' => $body['code'],
                    'message' => $body['msg']['ko']
                ];
            }
            
        }


    }

    /**
     * 인증 코드 비교
     * @param array $params
     * @return array
     */
    public function compareAuthCode(array $params): array {
        
        $ip = $_SERVER['REMOTE_ADDR'];

        if ($ip === '127.0.0.1') {
            
            // local일 경우...
            return [
                'result' => 'success',
                'code' => '0',
                'message' => ''
            ];

        } else {
            // INFO: 앱 배포 승인을 위해서 잠시 추가
            if(Auth::user()['idx'] == 3371 && $params['authcode'] == '1111') {
                return [
                    'result' => 'success',
                    'code' => '0',
                    'message' => ''
                ];
            }

            $userAuthCode = UserAuthCode::where('authcode', $params['authcode'])
                ->where('is_authorized', '0')
                ->where('type', $params['type'])
                ->first();
            if ($userAuthCode) {
                $userAuthCode->is_authorized = 1;
                $userAuthCode->save();
                return [
                    'result' => 'success',
                    'code' => '0',
                    'message' => ''
                ];
            } else {
                return [
                    'result' => 'fail',
                    'code' => '01',
                    'message' => '인증번호가 일치하지 않습니다. 다시 확인해주세요.'
                ];
            }
            
        }
    }

    /**
     * 업체 계정 상세 정보 가져오기
     * @return mixed
     */
    public function getCompanyAccount()
    {
        if (Auth::user()['type'] === 'W') {
            $company = DB::table('AF_wholesale AS company')
                ->where('company.idx', Auth::user()['company_idx']);
        } else if (Auth::user()['type'] === 'R') {
            $company = DB::table('AF_retail AS company')
                ->where('company.idx', Auth::user()['company_idx']);
        } else {
            return DB::table('AF_normal AS company')
                ->where('company.idx', Auth::user()['company_idx'])
                ->select('*', 'name AS company_name')
                ->first();
        }
        return $company->leftJoin('AF_attachment', 'AF_attachment.idx', '=', DB::raw('SUBSTRING_INDEX(company.business_license_attachment_idx, ",", 1)'))
            ->select('company.*', DB::raw('CONCAT("'.preImgUrl().'",AF_attachment.folder,"/",AF_attachment.filename) AS license_image'))->first();
    }

    /**
     * 일반 유저 명함 이미지 가져오기
     */
    public function getUserNameCard()
    {
        $image = DB::table('AF_normal AS normal')
            ->join('AF_attachment AS attachment', 'attachment.idx', 'normal.namecard_attachment_idx')
            ->where('normal.idx', Auth::user()['company_idx'])
            ->select(DB::raw('CONCAT("'.preImgUrl().'",attachment.folder,"/",attachment.filename) AS image'))
            ->first();
        if ($image) {
            return $image->image;
        } else {
            return null;
        }
    }

    /**
     * 업체 걔정 정보 수정
     * @param $params
     * @return array
     */
    public function updateCompanyAccount($params): array
    {
        $updates = [];
        if (Auth::user()['type'] === 'W') {
            $company = DB::table('AF_wholesale AS company')
                ->where('company.idx', Auth::user()['company_idx']);
        } else {
            $company = DB::table('AF_retail AS company')
                ->where('company.idx', Auth::user()['company_idx']);
        }
        if (isset($params['phone_number']) && !empty($params['phone_number'])) {
            $updates['phone_number'] = $params['phone_number'];
        }
        if (isset($params['default_address']) && !empty($params['default_address'])) {
            $updates['business_address'] = $params['default_address'];
        }
        if (isset($params['detail_address']) && !empty($params['detail_address'])) {
            $updates['business_address_detail'] = $params['detail_address'];
        }
        if (isset($params['is_domestic']) && $params['is_domestic'] !== '') {
            $updates['is_domestic'] = $params['is_domestic'];
        }
        if (isset($params['domestic_type']) && !empty($params['domestic_type'])) {
            $updates['domestic_type'] = $params['domestic_type'];
        }
        if (isset($params['password']) && !empty($params['password'])) {
            $updates['secret'] = DB::raw('password(\''.hash('sha256', $params['password']).'\')');
        }
        if (!empty($updates)) {
            $company->update($updates);
        }
        return [
            'result' => 'success',
            'message' => ''
        ];
    }

    /**
     * 업체 직원 계정 가져오기
     * @param int|null $idx
     * @return mixed
     */
    public function getCompanyMembers(int $idx = null)
    {
        if ($idx) {
            $user = User::find($idx);
        } else {
            $user = User::where('parent_idx', Auth::user()['idx'])->get();
        }
        return $user;
    }

    /**
     * 업체 직원 삭제하기
     * @param $idx
     * @return array
     */
    public function deleteCompanyMember($idx): array
    {
       User::where('parent_idx', Auth::user()['idx'])->where('idx', $idx)->delete();
       return [
           'result' => 'success',
           'message' => ''
       ];
    }

    /**
     * 업체 계정 패스워드 변경
     * @param array $params
     * @return array
     */
    public function changeCompanyPassword(array $params): array
    {
        $user = User::where('idx', Auth::user()['idx'])->first();
        if (isset($params['password']) && !empty($params['password'])) {
            $user->secret = DB::raw('password(\''.hash('sha256', $params['password']).'\')');
            $user->save();
        }
        return [
            'result' => 'success',
            'message' => ''
        ];
    }

    /**
     * 업체 직원 추가/수정
     * @param array $params
     * @return array
     */
    public function setCompanyMember(array $params): array
    {
        if ($params['type'] === 'create') {
            if (User::where('account', $params['member_account'])->count() > 0) {
                return [
                    'result' => 'fail',
                    'code' => 'DUPLICATE_ID',
                    'message' => '이미 등록된 아이디입니다.'
                ];
            }
            if (User::where('parent_idx', Auth::user()['idx'])->count() >= 5) {
                return [
                    'result' => 'fail',
                    'code' => 'MAX_MEMBERS',
                    'message' => '직원수는 최대 5명 까지입니다.'
                ];
            }
            $user = new User;
            $user->join_date = Carbon::now()->format('Y-m-d H:i:s');
            $user->company_idx = Auth::user()['company_idx'];
            $user->type = Auth::user()['type'];
            $user->state = 'JS';
            $user->parent_idx = Auth::user()['idx'];
        } else {
            if (User::where('account', $params['member_account'])->where('idx', '<>', $params['member_idx'])->count() > 0) {
                return [
                    'result' => 'fail',
                    'code' => 'DUPLICATE_ID',
                    'message' => '이미 등록된 아이디입니다.'
                ];
            }
            $user = User::find($params['member_idx']);
        }
        $user->name = $params['member_name'];
        $user->phone_number = $params['member_phone_number'];
        $user->account = $params['member_account'];
        $user->secret = DB::raw('password(\''.hash('sha256', $params['member_password']).'\')');
        $user->save();
        return [
            'result' => 'success',
            'message' => ''
        ];
    }

    /**
     * 탈퇴 처리
     * @return string[]
     */
    public function withdrawal(): array
    {
        // INFO: 앱 배포 승인을 위해서 잠시 추가
        if(Auth::user()['idx'] == 3371) {
            return [
                'result' => 'success',
                'message' => '',
            ];
        }
        $user = User::find(Auth::user()['idx']);
        $user->state = 'D';
        $user->save();

        // 직원 계정도 탈퇴 처리
        User::where('parent_idx',Auth::user()['idx'])->update(['state' => 'D']);

        $history = new UserUnregisterHistory;
        $history->user_idx = Auth::user()['idx'];
        $history->reason = '고객이 직접 탈퇴 신청함';
        $history->save();
        return [
            'result' => 'success',
            'message' => '',
        ];
    }

    /**
     * 일반 유저 정보 수정
     * @param array $params
     * @return string[]
     */
    public function updateNormalAccount(array $params): array
    {
        User::where('idx', Auth::user()['idx'])->update($params);
        return [
            'result' => 'success',
            'message' => ''
        ];
    }

    /**
     * 정회원 신청 시 사업자 등록증 이미지 업로드
     * @param $image
     * @return mixed
     */
    public function insertLicenseNumberImage($image)
    {
        $path = "company/license";
        $pullPath = "/storage/{$path}";
        $image = $this->uploadImage($image, $path);
        $explodeImage = explode('/',$image);
        $imageName = end($explodeImage);
        $attach = new Attachment;
        $attach->folder = $pullPath;
        $attach->filename = $imageName;
        $attach->save();
        return $attach->idx;
    }

    /**
     * 정회원 신청 처리
     * @param array $params
     * @return array
     */
    public function requestRegular(array $params): array
    {
        // 프로필 이미지 업로드
        if (isset($params['business_license_image'])) {
            $business_license_attachment_idx = $this->insertLicenseNumberImage($params['business_license_image']);
        }
        if ($params['type'] === 'W') {
            $company = new CompanyWholesale;
        } else {
            $company = new CompanyRetail;
        }
        $company->phone_number = Auth::user()['phone_number'];
        $company->business_email = Auth::user()['account'];
        $company->is_domestic = $params['is_domestic'];
        $company->domestic_type = $params['domestic_type'];
        $company->business_address = $params['default_address'];
        $company->business_address_detail = $params['detail_address'];
        $company->company_name = $params['company_name'];
        $company->owner_name = $params['owner_name'];
        $company->business_license_number = $params['business_license_number'];

        if (isset($business_license_attachment_idx)) {
            $company->business_license_attachment_idx = $business_license_attachment_idx;
        }
        $company->save();

        $queue = new UserUpgradeQueue;
        $queue->user_idx = Auth::user()['idx'];
        $queue->company_type = $params['type'];
        $queue->company_idx = $company->idx;
        $queue->save();

        User::where('idx', Auth::user()['idx'])->update([
            'state' => 'UW'
        ]);

        return [
            'result' => 'success',
            'message' => ''
        ];
    }

    /**
     * 로고 이미지 삭제
     * @param $imageUrl
     * @return string[]
     */
    public function deleteLogoImage($imageUrl): array
    {
        $this->deleteImage($imageUrl, 'company/profile');
        if (Auth::user()['type'] === 'W') {
            $company = CompanyWholesale::find(Auth::user()['company_idx']);
        } else {
            $company = CompanyRetail::find(Auth::user()['company_idx']);
        }
        if ($company->profile_image_attachment_idx) {
            Attachment::find($company->profile_image_attachment_idx)->delete();
            $company->profile_image_attachment_idx = null;
            $company->save();
        }
        return [
            'result' => 'success',
            'message' => ''
        ];
    }

    /**
     * 대표 상품 추가/삭제
     * @param int $idx
     * @return array
     */
    public function toggleRepresentProduct(int $idx): array
    {
        $product = Product::where('idx', $idx)
            ->where('company_type', Auth::user()['type'])
            ->where('company_idx', Auth::user()['company_idx'])->first();
        if ($product) {
            if ($product->is_represent === 1) {
                $product->is_represent = 0;
            } else {
                $count = Product::where('company_type', Auth::user()['type'])
                    ->where('company_idx', Auth::user()['company_idx'])
                    ->where('is_represent', 1)
                    ->count();
                if ($count >= 5) {
                    return [
                        'result' => 'fail',
                        'code' => 'FULL',
                        'message' => '대표 상품은 5개까지 등록 가능합니다.'
                    ];
                }
                $product->is_represent = 1;
            }
            $product->save();
            return [
                'result' => 'success',
                'message' => ''
            ];
        } else {
            return [
                'result' => 'fail',
                'code' => 'EMPTY',
                'message' => '해당 상품이 없습니다.'
            ];
        }
    }

    /**
     * 업체 좋아요/좋아요해제
     * @param $params
     * @return string[]
     */
    public function toggleCompanyLike($params): array
    {
        if (isset($params['idx'])) {
            LikeCompany::where('idx', $params['idx'])->where('user_idx', Auth::user()['idx'])->delete();
        } else {
            $likeCompany = new LikeCompany;
            $likeCompany->user_idx = Auth::user()['idx'];
            $likeCompany->company_type = $params['company_type'];
            $likeCompany->company_idx = $params['company_idx'];
            $likeCompany->save();
        }

        return [
            'result' => 'success',
            'message' => ''
        ];
    }

    public function getCurrentOrderStatus($type): array
    {
        $user = Auth::user();
        $result = [];
        if ($type === 'W') {
            $wholesaleOrders = Order::join('AF_product', 'AF_product.idx', 'AF_order.product_idx')
                ->where('AF_product.company_idx', $user['company_idx'])
                ->where('AF_product.company_type', 'W')
                ->select(DB::raw("GROUP_CONCAT(DISTINCT order_code SEPARATOR \"','\") AS order_code"))->first();
            if ($wholesaleOrders) {
                $wholeSaleTotalOrderCount = DB::select("SELECT (SELECT COUNT(*) FROM AF_order WHERE order_state = 'N' AND order_code IN ('{$wholesaleOrders->order_code}')) AS nc
                ,(SELECT COUNT(*) FROM AF_order WHERE order_state = 'R' AND order_code IN ('{$wholesaleOrders->order_code}')) AS rc
                ,(SELECT COUNT(*) FROM AF_order WHERE order_state = 'D' AND order_code IN ('{$wholesaleOrders->order_code}')) AS dc
                ,(SELECT COUNT(*) FROM AF_order WHERE order_state = 'W' AND order_code IN ('{$wholesaleOrders->order_code}')) AS wc
                ,(SELECT COUNT(*) FROM AF_order WHERE order_state = 'F' AND order_code IN ('{$wholesaleOrders->order_code}')) AS fc
                ,(SELECT COUNT(*) FROM AF_order WHERE order_state = 'C' AND order_code IN ('{$wholesaleOrders->order_code}')) AS cc");
                $result['w'] = $wholeSaleTotalOrderCount[0];
            }
        }
        if ($type === 'R') {
            $retailTotalOrderCount = DB::select("SELECT (SELECT COUNT(*) FROM AF_order WHERE order_state = 'N' AND user_idx = '{$user['idx']}') AS nc
                ,(SELECT COUNT(*) FROM AF_order WHERE order_state = 'R' AND user_idx = '{$user['idx']}') AS rc
                ,(SELECT COUNT(*) FROM AF_order WHERE order_state = 'D' AND user_idx = '{$user['idx']}') AS dc
                ,(SELECT COUNT(*) FROM AF_order WHERE order_state = 'W' AND user_idx = '{$user['idx']}') AS wc
                ,(SELECT COUNT(*) FROM AF_order WHERE order_state = 'F' AND user_idx = '{$user['idx']}') AS fc
                ,(SELECT COUNT(*) FROM AF_order WHERE order_state = 'C' AND user_idx = '{$user['idx']}') AS cc");
            $result['r'] = $retailTotalOrderCount[0];
        }
        return $result;
    }

    public function checkNewBadge($type): string
    {
        $result = '';
        if ($type === 'W' && Cookie::get('cocw')) {
            $cookie = Crypt::decrypt(Cookie::get('cocw'));
            $totalOrderStatusCount = $this->getCurrentOrderStatus('W');
            $w = $cookie['w'];
            $deal = 'N';
            $w->nc != $totalOrderStatusCount['w']->nc ? $deal = 'Y' : '';
            $w->rc != $totalOrderStatusCount['w']->rc ? $deal = 'Y' : '';
            $w->dc != $totalOrderStatusCount['w']->dc ? $deal = 'Y' : '';
            $w->wc != $totalOrderStatusCount['w']->wc ? $deal = 'Y' : '';
            $w->fc != $totalOrderStatusCount['w']->fc ? $deal = 'Y' : '';
            $w->cc != $totalOrderStatusCount['w']->cc ? $deal = 'Y' : '';
            return $deal;
        }
        if ($type === 'R' && Cookie::get('cocr')) {
            $cookie = Crypt::decrypt(Cookie::get('cocr'));
            $totalOrderStatusCount = $this->getCurrentOrderStatus('R');
            $r = $cookie['r'];
            $purchase = 'N';
            $r->nc != $totalOrderStatusCount['r']->nc ? $purchase = 'Y' : '';
            $r->rc != $totalOrderStatusCount['r']->rc ? $purchase = 'Y' : '';
            $r->dc != $totalOrderStatusCount['r']->dc ? $purchase = 'Y' : '';
            $r->wc != $totalOrderStatusCount['r']->wc ? $purchase = 'Y' : '';
            $r->fc != $totalOrderStatusCount['r']->fc ? $purchase = 'Y' : '';
            $r->cc != $totalOrderStatusCount['r']->cc ? $purchase = 'Y' : '';
            return $purchase;
        }
        return $result;
    }

    public function getOrderGroupCode(array $params)
    {
        $orderNum = isset($params['orderGroupCode']) ? $params['orderGroupCode'] : (isset($params['orderCode']) ? $params['orderCode'] : '');
        if (empty($orderNum)) {
            throw new Exception();
        }
        $order = Order::where(function($query) use($orderNum) {
            $query->where('order_group_code', $orderNum)
                ->orWhere('order_code', $orderNum);
        })->first();
        return $order->order_group_code;
    }

    public function getOrderProductSellerName(array $params)
    {
        $orderNum = isset($params['orderGroupCode']) ? $params['orderGroupCode'] : (isset($params['orderCode']) ? $params['orderCode'] : '');
        if (empty($orderNum)) {
            throw new Exception();
        }
        $order = Order::where(function($query) use($orderNum) {
            $query->where('order_group_code', $orderNum)
                ->orWhere('order_code', $orderNum);
        })->join('AF_product', 'AF_product.idx', 'AF_order.product_idx')
            ->join('AF_wholesale','AF_wholesale.idx', 'AF_product.company_idx')
            ->select('AF_wholesale.company_name')
            ->first();
        return $order->company_name;
    }



    public function getEstimateInfo() {
        $user = User::find(Auth::user()['idx']);
        $sql =
            "SELECT 
                (SELECT COUNT(DISTINCT(estimate_code)) FROM AF_estimate 
                WHERE response_company_idx = ".$user['company_idx']." AND estimate_state = 'N') 
                AS count_res_n,
                (SELECT COUNT(DISTINCT(estimate_code)) FROM AF_estimate 
                WHERE response_company_idx = ".$user['company_idx']." AND estimate_state = 'R') 
                AS count_res_r,
                (SELECT COUNT(DISTINCT(estimate_code)) FROM AF_estimate 
                WHERE response_company_idx = ".$user['company_idx']." AND estimate_state = 'O') 
                AS count_res_o,
                (SELECT COUNT(DISTINCT(estimate_code)) FROM AF_estimate 
                WHERE response_company_idx = ".$user['company_idx']." AND (estimate_state = 'H' OR estimate_state = 'F')) 
                AS count_res_f,
                (SELECT COUNT(DISTINCT(estimate_code)) FROM AF_estimate 
                WHERE request_company_idx = ".$user['company_idx']." AND estimate_state = 'N')
                AS count_req_n,
                (SELECT COUNT(DISTINCT(estimate_code)) FROM AF_estimate 
                WHERE request_company_idx = ".$user['company_idx']." AND estimate_state = 'R') 
                AS count_req_r,
                (SELECT COUNT(DISTINCT(estimate_code)) FROM AF_estimate 
                WHERE request_company_idx = ".$user['company_idx']." AND estimate_state = 'O')
                AS count_req_o,
                (SELECT COUNT(DISTINCT(estimate_code)) FROM AF_estimate 
                WHERE request_company_idx = ".$user['company_idx']." AND (estimate_state = 'H' OR estimate_state = 'F')) 
                AS count_req_f
            FROM DUAL";

        $estimate = DB::select($sql);
        return $estimate;
    }

    public function getRequestEstimate(array $params) {
        $offset = isset($params['offset']) && $params['offset'] > 1 ? ($params['offset'] - 1) * $params['limit'] : 0;
        $limit = $params['limit'];

        $where = "";
        // 키워드 검색
        if (isset($params['keywordType']) && isset($params['keyword'])) {
            switch($params['keywordType']) {
                case 'estimateCode':
                    $where .= " AND e.estimate_code LIKE '%{$params['keyword']}%' ";
                    break;
                case 'productName':
                    $where .= " AND p.name LIKE '%{$params['keyword']}%' ";
                    break;
                case 'companyName':
                    $where .= " AND (w.company_name LIKE '%{$params['keyword']}%' OR r.company_name LIKE '%{$params['keyword']}%')";
                    break;
                default:
                    break;
            }
        } else if (!isset($params['keywordType']) && isset($params['keyword']) && !empty($params['keyword'])) {
            $orWhere = [];

            $orWhere[] = " e.estimate_code LIKE '%{$params['keyword']}%' ";
            $orWhere[] = " p.name LIKE '%{$params['keyword']}%' ";
            $orWhere[] = " r.company_name LIKE '%{$params['keyword']}%' ";
            $orWhere[] = " w.company_name LIKE '%{$params['keyword']}%' ";

            $where .= ' AND ('.join('OR', $orWhere).')';
        }

        // 기간 검색
        if (isset($params['requestDate'])) {
            $requestDate = explode('~', $params['requestDate']);
            if (isset($requestDate[0])) {
                $where .= ' AND e.request_time >= "'.trim($requestDate[0]).' 00:00:00" ';
            }
            if (isset($requestDate[1])) {
                $where .= ' AND e.request_time <= "'.trim($requestDate[1]).' 23:59:59" ';
            }
        }

        if (isset($params['status'])) {
            if($params['status'] === 'F') {
                $where .= " AND (e.estimate_state = 'H' OR e.estimate_state = 'F') ";
            } else {
                $where .= " AND e.estimate_state = '{$params['status']}' ";
            }
        }

        $user = User::find(Auth::user()['idx']);
        $where .= " AND e.request_company_idx = ".$user['company_idx'];

        $sql =
            "SELECT 
                *,
                (COUNT(e.estimate_code) - 1) AS cnt,
                e.idx AS estimate_idx,
                DATE_FORMAT(e.request_time, '%Y.%m.%d') AS request_time,
                DATE_FORMAT(e.response_time, '%Y.%m.%d') AS response_time,
                w.company_name AS response_w_company_name,
                r.company_name AS response_r_company_name
            FROM AF_estimate e
            LEFT JOIN AF_wholesale w ON e.response_company_idx = w.idx 
            LEFT JOIN AF_retail r ON e.response_company_idx = r.idx 
            LEFT JOIN AF_product p ON e.product_idx = p.idx
            WHERE 1 = 1 {$where}
            GROUP BY e.estimate_code 
            ORDER BY e.idx DESC";
        $estimate = DB::select($sql);

        $request['count'] = count($estimate);
        $request['list'] = DB::select($sql." LIMIT {$offset}, {$limit}");
        $request['pagination'] = paginate($params['offset'], $params['limit'], $request['count']);

        return $request;
    }

    public function getRequestEstimateDetail(array $params) {
        $sql =
            "SELECT 
                *,

                e.idx AS estimate_idx,

                DATE_FORMAT(e.request_time, '%Y년 %m월 %d일') AS request_time,
                IF(a1.idx IS NOT NULL, CONCAT('".preImgUrl()."', a1.folder, '/', a1.filename), '') AS business_license,

                DATE_FORMAT(e.response_time, '%Y년 %m월 %d일') AS response_time,

                IF(a2.idx IS NOT NULL, CONCAT('".preImgUrl()."', a2.folder, '/', a2.filename), '') AS product_thumbnail,
                p.name AS product_name,
                FORMAT(e.product_each_price, 0) AS product_each_price,
                FORMAT(e.product_total_price, 0) AS product_total_price,
                CASE 
                    WHEN p.company_type = 'W'
                        THEN CONCAT(IFNULL(w.business_address, ''), ' ', IFNULL(w.business_address_detail, ''))
                    WHEN p.company_type = 'R'
                        THEN CONCAT(IFNULL(r.business_address, ''), ' ', IFNULL(r.business_address_detail, ''))
                    ELSE ''
                END AS product_address
            FROM AF_estimate e
            LEFT JOIN AF_wholesale w ON e.response_company_idx = w.idx 
            LEFT JOIN AF_retail r ON e.response_company_idx = r.idx 
            LEFT JOIN AF_product p ON e.product_idx = p.idx 
            LEFT JOIN AF_attachment a1 ON e.request_business_license_attachment_idx = a1.idx 
            LEFT JOIN AF_attachment a2 ON SUBSTRING_INDEX(p.attachment_idx, ',', 1) = a2.idx 
            WHERE e.idx = ".$params['estimate_idx'];
        $estimate = DB::select($sql);

        return $estimate;
    }

    public function getResponseEstimate(array $params) {
        $offset = isset($params['offset']) && $params['offset'] > 1 ? ($params['offset'] - 1) * $params['limit'] : 0;
        $limit = $params['limit'];

        $where = "";
        // 키워드 검색
        if (isset($params['keywordType']) && isset($params['keyword'])) {
            switch($params['keywordType']) {
                case 'estimateCode':
                    $where .= " AND e.estimate_code LIKE '%{$params['keyword']}%' ";
                    break;
                case 'productName':
                    $where .= " AND p.name LIKE '%{$params['keyword']}%' ";
                    break;
                case 'companyName':
                    $where .= " AND (w.company_name LIKE '%{$params['keyword']}%' OR r.company_name LIKE '%{$params['keyword']}%')";
                    break;
                default:
                    break;
            }
        } else if (!isset($params['keywordType']) && isset($params['keyword']) && !empty($params['keyword'])) {
            $orWhere = [];

            $orWhere[] = " e.estimate_code LIKE '%{$params['keyword']}%' ";
            $orWhere[] = " p.name LIKE '%{$params['keyword']}%' ";
            $orWhere[] = " r.company_name LIKE '%{$params['keyword']}%' ";
            $orWhere[] = " w.company_name LIKE '%{$params['keyword']}%' ";

            $where .= ' AND ('.join('OR', $orWhere).')';
        }

        // 기간 검색
        if (isset($params['responseDate'])) {
            $responseDate = explode('~', $params['responseDate']);
            if (isset($responseDate[0])) {
                $where .= ' AND e.response_time >= "'.trim($responseDate[0]).' 00:00:00" ';
            }
            if (isset($responseDate[1])) {
                $where .= ' AND e.response_time <= "'.trim($responseDate[1]).' 23:59:59" ';
            }
        }

        if (isset($params['status'])) {
            if($params['status'] === 'F') {
                $where .= " AND (e.estimate_state = 'H' OR e.estimate_state = 'F') ";
            } else {
                $where .= " AND e.estimate_state = '{$params['status']}' ";
            }
        }

        $user = User::find(Auth::user()['idx']);
        $request['response_company_type'] = $user['type'];
        $where .= " AND e.response_company_idx = ".$user['company_idx'];

        $sql =
            "SELECT 
                *,
                (COUNT(e.estimate_code) - 1) AS cnt,
                e.idx AS estimate_idx,
                DATE_FORMAT(e.request_time, '%Y.%m.%d') AS request_time,
                DATE_FORMAT(e.response_time, '%Y.%m.%d') AS response_time,
                w.company_name AS request_w_company_name,
                r.company_name AS request_r_company_name
            FROM AF_estimate e
            LEFT JOIN AF_wholesale w ON e.request_company_idx = w.idx 
            LEFT JOIN AF_retail r ON e.request_company_idx = r.idx 
            LEFT JOIN AF_product p ON e.product_idx = p.idx
            WHERE 1 = 1 {$where}
            GROUP BY e.estimate_code
            ORDER BY e.idx DESC";
        $estimate = DB::select($sql);
        Log::info('sql 12345 -> '.$sql);
        $request['count'] = count($estimate);
        $request['list'] = DB::select($sql." LIMIT {$offset}, {$limit}");
        $request['pagination'] = paginate($params['offset'], $params['limit'], $request['count']);

        return $request;
    }

    public function getResponseEstimateDetail(array $params) {
        switch ($params['response_company_type']) {
            case 'W':
                $sql =
                    "SELECT 
                    *,

                    e.idx AS estimate_idx,

                    e.request_company_name AS response_req_company_name,
                    e.request_phone_number AS response_req_phone_number,
                    e.request_business_license_number AS response_req_business_license_number,
                    e.request_address1 AS response_req_address1,

                    DATE_FORMAT(e.response_time, '%Y년 %m월 %d일') AS response_res_time,
                    IF(e.response_company_name IS NOT NULL, e.response_company_name, w1.company_name) 
                    AS response_res_company_name,
                    IF(e.response_business_license_number IS NOT NULL, e.response_business_license_number, w1.business_license_number) 
                    AS response_res_business_license_number,
                    IF(e.response_phone_number IS NOT NULL, e.response_phone_number, w1.phone_number) 
                    AS response_res_phone_number,
                    IF(e.response_address1 IS NOT NULL, e.response_address1, CONCAT(w1.business_address, ' ', w1.business_address_detail)) 
                    AS response_res_address1,
                    e.response_account AS response_res_account,
                    e.response_memo AS response_res_memo,

                    IF(a.idx IS NOT NULL, CONCAT('".preImgUrl()."', a.folder, '/', a.filename), '') AS product_thumbnail,
                    FORMAT(e.product_total_price, 0) AS product_total_price,
                    CASE 
                        WHEN p.company_type = 'W'
                            THEN CONCAT(IFNULL(w1.business_address, ''), ' ', IFNULL(w1.business_address_detail, ''))
                        WHEN p.company_type = 'R'
                            THEN CONCAT(IFNULL(r1.business_address, ''), ' ', IFNULL(r1.business_address_detail, ''))
                        ELSE ''
                    END AS product_address,
                    e.product_delivery_info AS product_delivery_info
                FROM AF_estimate e
                LEFT JOIN AF_wholesale w1 ON e.response_company_idx = w1.idx 
                LEFT JOIN AF_wholesale r1 ON e.response_company_idx = r1.idx 
                LEFT JOIN AF_product p ON e.product_idx = p.idx 
                LEFT JOIN AF_attachment a ON SUBSTRING_INDEX(p.attachment_idx, ',', 1) = a.idx 
                WHERE e.estimate_code = '".$params['estimate_code']."'";
                break;
            case 'R':
                $sql =
                    "SELECT 
                   *,

                    e.idx AS estimate_idx,

                    e.request_company_name AS response_req_company_name,
                    e.request_phone_number AS response_req_phone_number,
                    e.request_business_license_number AS response_req_business_license_number,
                    e.request_address1 AS response_req_address1,

                    DATE_FORMAT(e.response_time, '%Y년 %m월 %d일') AS response_res_time,
                    IF(e.response_company_name IS NOT NULL, e.response_company_name, r1.company_name) 
                    AS response_res_company_name,
                    IF(e.response_business_license_number IS NOT NULL, e.response_business_license_number, r1.business_license_number) 
                    AS response_res_business_license_number,
                    IF(e.response_phone_number IS NOT NULL, e.response_phone_number, r1.phone_number) 
                    AS response_res_phone_number,
                    IF(e.response_address1 IS NOT NULL, e.response_address1, CONCAT(r1.business_address, ' ', r1.business_address_detail)) 
                    AS response_res_address1,
                    e.response_account AS response_res_account,
                    e.response_memo AS response_res_memo,

                    IF(a.idx IS NOT NULL, CONCAT('".preImgUrl()."', a.folder, '/', a.filename), '') AS product_thumbnail,
                    FORMAT(e.product_total_price, 0) AS product_total_price,
                    CASE 
                        WHEN p.company_type = 'W'
                            THEN CONCAT(IFNULL(w1.business_address, ''), ' ', IFNULL(w1.business_address_detail, ''))
                        WHEN p.company_type = 'R'
                            THEN CONCAT(IFNULL(r1.business_address, ''), ' ', IFNULL(r1.business_address_detail, ''))
                        ELSE ''
                    END AS product_address,
                    e.product_delivery_info AS product_delivery_info
                FROM AF_estimate e
                LEFT JOIN AF_retail r1 ON e.response_company_idx = r1.idx 
                LEFT JOIN AF_product p ON e.product_idx = p.idx 
                LEFT JOIN AF_attachment a ON e.request_business_license_attachment_idx = a.idx 
                WHERE e.estimate_code = '".$params['estimate_code']."'";
                break;
            default:
                break;
        }
        $estimate = DB::select($sql);

        $now1 = date('Y년 m월 d일');
        $now2 = date('Y-m-d H:i:s');

        $estimate[0] -> now1 = $now1;
        $estimate[0] -> now2 = $now2;

        return $estimate;
    }

    public function getResponseOrderDetail(array $params) {
        $sql =
            "SELECT 
                *,
                e.*,
                o.register_time AS register_time,
                o.name AS name,
                IF(a.idx IS NOT NULL, CONCAT('".preImgUrl()."', a.folder, '/', a.filename), '') AS product_thumbnail,
                p.name AS product_name,
                FORMAT(o.price, 0) AS total_price,
                e.response_address1 AS product_address
            FROM AF_order o 
            LEFT JOIN AF_estimate e ON o.order_code = e.estimate_code 
            LEFT JOIN AF_product p ON e.product_idx = p.idx 
            LEFT JOIN AF_attachment a ON SUBSTRING_INDEX(p.attachment_idx, ',', 1) = a.idx 
            WHERE o.order_code = '".$params['order_code']."'";
        $estimate = DB::select($sql);

        return $estimate;
    }

    public function getResponseEstimateMulti(object $params) {
        switch ($params -> type) {
            case 'W':
                $sql =
                    "SELECT
                        RANK() OVER (ORDER BY p.idx) AS num,
                        p.idx,
                        w.idx AS company_idx,
                        'W' AS company_type,
                        w.company_name AS company_name,
                        w.business_license_number AS business_license_number,
                        w.phone_number AS phone_number,
                        CONCAT(w.business_address, ' ', w.business_address_detail) AS address1,
                        IF(a.idx IS NOT NULL, CONCAT('".preImgUrl()."', a.folder, '/', a.filename), '') AS product_thumbnail,
                        p.name,
                        p.price,
                        p.product_number,
                        p.product_option
                    FROM AF_user u
                    LEFT JOIN AF_wholesale w ON u.company_idx = w.idx
                    LEFT JOIN AF_product p ON u.company_idx = p.company_idx
                    LEFT JOIN AF_attachment a ON SUBSTRING_INDEX(p.attachment_idx, ',', 1) = a.idx
                    WHERE u.idx = ".$params -> idx." 
                    AND p.state IN ('S', 'O')
                    ORDER BY p.idx";
                break;
            case 'R':
                $sql =
                    "SELECT
                        RANK() OVER (ORDER BY p.idx) AS num,
                        p.idx,
                        r.idx AS company_idx,
                        'R' AS company_type,
                        r.company_name AS company_name,
                        r.business_license_number AS business_license_number,
                        r.phone_number AS phone_number,
                        CONCAT(r.business_address, ' ', r.business_address_detail) AS address1,
                        IF(a.idx IS NOT NULL, CONCAT('".preImgUrl()."', a.folder, '/', a.filename), '') AS product_thumbnail,
                        p.name,
                        p.price,
                        p.product_number,
                        p.product_option
                    FROM AF_user u
                    LEFT JOIN AF_retail r ON u.company_idx = r.idx
                    LEFT JOIN AF_product p ON u.company_idx = p.company_idx
                    LEFT JOIN AF_attachment a ON SUBSTRING_INDEX(p.attachment_idx, ',', 1) = a.idx
                    WHERE u.idx = ".$params -> idx." 
                    AND p.state IN ('S', 'O')
                    ORDER BY p.idx";
                break;
            default:
                $sql = "select * from AF_product where idx=0";
                break;
        }
        $estimateMulti = DB::select($sql);

        $request['list'] = $estimateMulti;

        return $request;
    }

    public function getRequestSendEstimate($idx) {
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

        $now1 = date('Y년 m월 d일');
        $now2 = date('Y-m-d H:i:s');

        $user = User::find(Auth::user()['idx']);
        if (Auth::user()['type'] === 'W') {
            $company = CompanyWholesale::find(Auth::user()['company_idx']);
        } else if (Auth::user()['type'] === 'R') {
            $company = CompanyRetail::find(Auth::user()['company_idx']);
        } else {
            $company = CompanyNormal::where('idx', Auth::user()['company_idx'])->select('*', 'name AS company_name')->first();
        }
        $product = Product::find($idx);

        $sql =
            "SELECT 
                IF(a.idx IS NOT NULL, CONCAT('".preImgUrl()."', a.folder, '/', a.filename), '') AS product_thumbnail,
                (CASE 
                    WHEN p.company_type = 'W' THEN (SELECT CONCAT(IFNULL(aw.business_address, ''), ' ', IFNULL(aw.business_address_detail, '')) FROM AF_wholesale AS aw WHERE aw.idx = p.company_idx)
                    WHEN p.company_type = 'R' THEN (SELECT CONCAT(IFNULL(ar.business_address, ''), ' ', IFNULL(ar.business_address_detail, '')) FROM AF_retail AS ar WHERE ar.idx = p.company_idx)
                ELSE '' END) AS product_address
            FROM AF_product p 
            LEFT JOIN AF_attachment a ON SUBSTRING_INDEX(p.attachment_idx, ',', 1) = a.idx 
            WHERE p.idx = ".$idx;
        $attachment = DB::select($sql);

        $data['code'] = $estimateGroupCode;
        $data['now1'] = $now1;
        $data['now2'] = $now2;
        $data['user'] = $user;
        $data['company'] = $company;
        $data['product'] = $product;
        $data['attachment'] = $attachment;

        return $data;
    }

    /**
     * 회원 포인트 목록
     */
    public function getPointList()
    {
        $pointList = DB::table('AF_point')
            ->where('user_idx', Auth::user()->idx)
            ->where('is_delete', 0)
            ->orderBy('register_time', 'DESC')
            ->get();

        return $pointList;
    }
}