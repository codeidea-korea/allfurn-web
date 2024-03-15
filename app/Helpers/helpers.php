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
