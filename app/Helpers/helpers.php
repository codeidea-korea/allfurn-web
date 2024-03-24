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
    return env('AWS_S3_URL', 'https://allfurn-prod-s3-bucket.s3.ap-northeast-2.amazonaws.com/');
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

        if( empty( $nData['info'][$cIdx] ) ) {
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
