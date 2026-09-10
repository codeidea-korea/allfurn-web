<?php

/**
 * 게시글 페이지네이션 가져오기
 * @param int $offset
 * @param int $limit
 * @param int $totalCount
 * @return mixed
 */
if (! function_exists('paginate')) {
    function paginate($offset=0, $limit=20, $totalCount=0)
    {
        // 올림
        $totalPageCount = ceil($totalCount/$limit);
        $pageEnd = ceil($offset / 10) * 10;
        $pageStart = $pageEnd - 9;
        $pages = [];
        for ($i = $pageStart; $i <= $totalPageCount; $i++) {
            $pages[] = $i;
            if ($i === $pageEnd) {
                break;
            }
        }
        return collect([
            'prev' => ($offset > 10 ? $offset -1 : 0),
            'pages' => $pages,
            'next' => ($pageEnd < $totalPageCount ? $pageEnd + 1 : 0),
        ]);
    }
}

function preImgUrl() {
    return env('AWS_S3_URL', 'https://cdn-w5ydnw3kw8pn.vultrcdn.com/');
}

function cdnImgUrl($url) {
    if (! is_string($url) || $url === '') {
        return $url;
    }

    $cdnUrl = rtrim(preImgUrl(), '/') . '/';
    $objectUrls = [
        'https://allfurn-prod-s3-bucket.sgp1.vultrobjects.com/',
        'http://allfurn-prod-s3-bucket.sgp1.vultrobjects.com/',
    ];

    foreach ($objectUrls as $objectUrl) {
        if (stripos($url, $objectUrl) === 0) {
            return $cdnUrl . ltrim(substr($url, strlen($objectUrl)), '/');
        }
    }

    return $url;
}

function normalizeProductInfoImageUrls($productInfo) {
    if (! is_array($productInfo)) {
        return $productInfo;
    }

    foreach ($productInfo as $key => $item) {
        if (is_array($item)) {
            if (isset($item['mdp_gimg'])) {
                $item['mdp_gimg'] = cdnImgUrl($item['mdp_gimg']);
            }

            if (isset($item['groups']) && is_array($item['groups'])) {
                $item['groups'] = normalizeProductInfoImageUrls($item['groups']);
            }

            $productInfo[$key] = $item;
        } elseif (is_object($item)) {
            if (isset($item->mdp_gimg)) {
                $item->mdp_gimg = cdnImgUrl($item->mdp_gimg);
            }

            if (isset($item->groups) && is_array($item->groups)) {
                $item->groups = normalizeProductInfoImageUrls($item->groups);
            }

            $productInfo[$key] = $item;
        }
    }

    return $productInfo;
}

function productIsInquiryPrice($productOrPrice, $isPriceOpen = null) {
    if (is_array($productOrPrice)) {
        $price = $productOrPrice['price'] ?? 0;
        $isPriceOpen = $productOrPrice['is_price_open'] ?? $isPriceOpen;
    } elseif (is_object($productOrPrice)) {
        $price = $productOrPrice->price ?? 0;
        $isPriceOpen = $productOrPrice->is_price_open ?? $isPriceOpen;
    } else {
        $price = $productOrPrice;
    }

    $numericPrice = (int) preg_replace('/[^0-9-]/', '', (string) $price);

    return (string) $isPriceOpen !== '1' || $numericPrice <= 0;
}

function productDisplayPrice($productOrPrice, $isPriceOpen = null) {
    if (productIsInquiryPrice($productOrPrice, $isPriceOpen)) {
        return '업체 문의';
    }

    $price = is_array($productOrPrice)
        ? ($productOrPrice['price'] ?? 0)
        : (is_object($productOrPrice) ? ($productOrPrice->price ?? 0) : $productOrPrice);

    $numericPrice = (int) preg_replace('/[^0-9-]/', '', (string) $price);

    return number_format($numericPrice, 0) . '원';
}

function api() {
    return env('ALLFURN_API_DOMAIN', 'https://api.all-furn.com');
}

function print_re( $data ) {
    if( empty( $data ) ) return false;

    echo "<pre>";
    print_r( $data );
    echo "</pre>";
}

function getDeviceType() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $mobile_agents = array('iphone','ipod','ipad','android','webos',
        'blackberry','nokia','opera mini','windows mobile','windows phone','iemobile');
    foreach($mobile_agents as $mobile_agent) {
        if (strpos(strtolower($user_agent), strtolower($mobile_agent)) !== false) {
            return 'm.';
        }
    }
    return '';
}

// 도매업체 키(company_idx) 기준 배열 정리
function setArrayNumer( $arr )
{
    if( empty( $arr ) ) return false;

    $cnt = array();
    $nData = array();
    $tmp = 0;
    foreach( $arr AS $data ) {
        $cIdx = $data->company_idx;

        $cnt[$cIdx] = ( !isset( $cnt[$cIdx] ) ) ? 0 : $cnt[$cIdx] + 1;

        // 50개만 데이터 세팅
        if( count( $cnt ) > 50 )
            continue;

        if( empty( $nData['info'][$cIdx] ) ) {
            // 앞 20개는 왕관표시
            $nData['info'][$cIdx]['isCrown'] = false;
            if( $cnt[$cIdx] < 20 )
                $nData['info'][$cIdx]['isCrown'] = true;

            $nData['info'][$cIdx]['company_idx'] = $data->company_idx;
            $nData['info'][$cIdx]['companyName'] = $data->companyName;
            $nData['info'][$cIdx]['companyRegion'] = $data->companyRegion;
        }

        $nData['info'][$cIdx]['category_name'] = array();
        if( $data->category_name != '' && !in_array( $data->category_name, $nData['info'][$cIdx]['category_name'] ) ) {

            $nData['info'][$cIdx]['category_name'][$cnt[$cIdx]] = $data->category_name;
        }

        $nData['info'][$cIdx]['items'][$cnt[$cIdx]]['idx']  = $data->idx;
        $nData['info'][$cIdx]['items'][$cnt[$cIdx]]['product_idx']  = $data->product_idx;
        $nData['info'][$cIdx]['items'][$cnt[$cIdx]]['admin_idx']  = $data->admin_idx;
        $nData['info'][$cIdx]['items'][$cnt[$cIdx]]['start_date']  = $data->start_date;
        $nData['info'][$cIdx]['items'][$cnt[$cIdx]]['end_date']  = $data->end_date;
        $nData['info'][$cIdx]['items'][$cnt[$cIdx]]['ad_location']  = $data->ad_location;
        $nData['info'][$cIdx]['items'][$cnt[$cIdx]]['state']  = $data->state;
        $nData['info'][$cIdx]['items'][$cnt[$cIdx]]['price']  = $data->price;
        $nData['info'][$cIdx]['items'][$cnt[$cIdx]]['ad_code']  = $data->ad_code;
        $nData['info'][$cIdx]['items'][$cnt[$cIdx]]['order_idx']  = $data->order_idx;
        $nData['info'][$cIdx]['items'][$cnt[$cIdx]]['app_link']  = $data->app_link;
        $nData['info'][$cIdx]['items'][$cnt[$cIdx]]['app_link_type']  = $data->app_link_type;
        $nData['info'][$cIdx]['items'][$cnt[$cIdx]]['web_link']  = $data->web_link;
        $nData['info'][$cIdx]['items'][$cnt[$cIdx]]['web_link_type']  = $data->web_link_type;
        $nData['info'][$cIdx]['items'][$cnt[$cIdx]]['content']  = $data->content;
        $nData['info'][$cIdx]['items'][$cnt[$cIdx]]['is_open']  = $data->is_open;
        $nData['info'][$cIdx]['items'][$cnt[$cIdx]]['is_delete']  = $data->is_delete;
        $nData['info'][$cIdx]['items'][$cnt[$cIdx]]['register_time']  = $data->register_time;
        $nData['info'][$cIdx]['items'][$cnt[$cIdx]]['name']  = $data->name;
        $nData['info'][$cIdx]['items'][$cnt[$cIdx]]['imgUrl'] = $data->imgUrl;
    }

    return $nData;
}

// 올톡 : 확인 안 한 갯수
function unCheckedAllTalkCount()
{
    if (auth()->check()){
        $sql = "SELECT SUM(IF(IFNULL(msg.is_read, 0) = 0, 1, 0)) AS total_unread 
            FROM ALLFURN.AF_message msg
            JOIN ALLFURN.AF_message_room room on msg.room_idx = room.idx
            WHERE (
                (room.first_company_idx = ".auth()->user()->company_idx." AND room.first_company_type = '".auth()->user()->type."')
                OR (room.second_company_idx = ".auth()->user()->company_idx." AND room.second_company_type = '".auth()->user()->type."')
            )
            AND user_idx != " . auth()->user()->idx;
        $msg = Illuminate\Support\Facades\DB::select($sql);

        return $msg[0]->total_unread;
    }else{
        return 0;
    }
}

// 마이올펀 : 판매현황 (요청받은 견적,주문서 수) / 구매현황 (받은 견적, 주문서 수) / 문의내역
function unCheckedMyAllFurn()
{
    if (auth()->check()){
        $user = Illuminate\Support\Facades\DB::table('AF_user')->select('company_idx', 'type')->where('idx', auth()->user()->idx)->first();
        $sql = "SELECT 
                (SELECT COUNT(DISTINCT(estimate_code)) FROM AF_estimate 
                WHERE response_company_idx = ".$user->company_idx." and response_company_type = '".$user->type."' AND estimate_state = 'N') 
                AS count_res_n,
                (SELECT COUNT(DISTINCT(estimate_code)) FROM AF_estimate 
                WHERE response_company_idx = ".$user->company_idx." and response_company_type = '".$user->type."' AND estimate_state = 'O') 
                AS count_res_o,
                (SELECT COUNT(DISTINCT(estimate_code)) FROM AF_estimate 
                WHERE request_company_idx = ".$user->company_idx." and response_company_type = '".$user->type."' AND estimate_state = 'R') 
                AS count_req_r,
                (SELECT COUNT(DISTINCT(estimate_code)) FROM AF_estimate 
                WHERE request_company_idx = ".$user->company_idx." and response_company_type = '".$user->type."' AND estimate_state = 'O')
                AS count_req_o
            FROM DUAL";

        $estimate = Illuminate\Support\Facades\DB::select($sql);
        $total = $estimate[0]->count_res_n + $estimate[0]->count_res_o + $estimate[0]->count_req_r + $estimate[0]->count_req_o;
        if ($total > 0){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

// 마이올펀 : 요청받은 견적 수
/*function countUnCheckedMyAllFurn()
{
    if (auth()->check()){
        $user = Illuminate\Support\Facades\DB::table('AF_user')->select('company_idx', 'type')->where('idx', auth()->user()->idx)->first();
        $sql = "SELECT 
                (SELECT COUNT(DISTINCT(estimate_code)) FROM AF_estimate 
                WHERE response_company_idx = ".$user->company_idx." and response_company_type = '".$user->type."' AND estimate_state = 'N') 
                AS count_res_n,
                (SELECT COUNT(DISTINCT(estimate_code)) FROM AF_estimate 
                WHERE response_company_idx = ".$user->company_idx." and response_company_type = '".$user->type."' AND estimate_state = 'O') 
                AS count_res_o,
                (SELECT COUNT(DISTINCT(estimate_code)) FROM AF_estimate 
                WHERE request_company_idx = ".$user->company_idx." and response_company_type = '".$user->type."' AND estimate_state = 'R') 
                AS count_req_r,
                (SELECT COUNT(DISTINCT(estimate_code)) FROM AF_estimate 
                WHERE request_company_idx = ".$user->company_idx." and response_company_type = '".$user->type."' AND estimate_state = 'O')
                AS count_req_o
            FROM DUAL";

        $estimate = Illuminate\Support\Facades\DB::select($sql);
        $total = $estimate[0]->count_res_n;

        return $total;
    }else{
        return 0;
    }
}*/

function countUnCheckedMyAllFurn()
{
    if (auth()->check()){
        $user = Illuminate\Support\Facades\DB::table('AF_user')->select('company_idx', 'type')->where('idx', auth()->user()->idx)->first();

        $sql = "SELECT 
                (SELECT COUNT(DISTINCT estimate_group_code, estimate_state) FROM AF_estimate 
                WHERE response_company_idx = ".$user->company_idx." 
                AND response_company_type = '".$user->type."' 
                AND estimate_state IN ('N', 'R', 'O', 'F')) 
                AS count_res_total
            FROM DUAL";

        $estimate = Illuminate\Support\Facades\DB::select($sql);
        $total = $estimate[0]->count_res_total;

        return $total;
    }else{
        return 0;
    }
}
