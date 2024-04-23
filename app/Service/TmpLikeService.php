<?php


namespace App\Service;

use App\Models\ProductInterest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TmpLikeService
{


    /**
     * 좋아요 상품 목록 가져오기
     * @param array $params
     * @return Array
     */
    //TODO: 인기순(좋아요+올톡문의+전화문의+견적서문의) 필터적용한 조회기능으로 변경 / 현재까지 개발된 인기순 = 좋아요+올톡문의
    public function getInterestProducts(array $params): Array
    {
        $offset = $params['offset'] > 1 ? ($params['offset'] - 1) * $params['limit'] : 0;
        $limit = $params['limit'];

        $query = 
            ProductInterest::where('AF_product_interest.user_idx', Auth::user()['idx'])
            -> join('AF_product', 'AF_product.idx', 'AF_product_interest.product_idx')
            -> leftJoin('AF_attachment', 'AF_attachment.idx', DB::raw('SUBSTRING_INDEX(AF_product.attachment_idx, ",", 1)'))
            -> leftJoin('AF_product_interest_folder', function($query) {
                $query -> on('AF_product_interest_folder.idx', 'AF_product_interest.folder_idx');
            })
            -> leftJoin('AF_wholesale', function($query) {
                $query -> on('AF_wholesale.idx', 'AF_product.company_idx') -> where('AF_product.company_type', 'W');
            })
            -> leftJoin('AF_retail', function($query) {
                $query -> on('AF_retail.idx', 'AF_product.company_idx') -> where('AF_product.company_type', 'R');
            })
            ->leftjoin('AF_category as ac', function($query) {
                $query->on('ac.idx', '=', 'AF_product.category_idx');
            })
            ->leftjoin('AF_category as ac2', function($query) {
                $query->on('ac2.idx', '=', 'ac.parent_idx');
            })
            ->leftjoin(
                DB::raw('(SELECT product_idx, COUNT(*) AS interest 
                    FROM AF_product_interest
                    GROUP BY product_idx) AS api'), function($query) {
                $query->on('AF_product.idx', '=', 'api.product_idx');
            })
            ->select( 'AF_product.idx', 'AF_product.name AS product_name', 'AF_product.is_price_open', 'AF_product.price', 'AF_product.price_text'
                    , 'AF_product_interest_folder.name AS folder_name', 'AF_product.access_count'
            , DB::raw('IF(AF_wholesale.idx IS NOT NULL, AF_wholesale.company_name, AF_retail.company_name) AS company_name')
            , DB::raw('CONCAT("'.preImgUrl().'",AF_attachment.folder,"/", AF_attachment.filename) AS product_image')
            , DB::raw('(interest + AF_product.inquiry_count) AS popularity'));

        
        $data['countAll'] = $query -> get() -> count();
            
        if (isset($params['folder'])) {
            $query -> where('AF_product_interest.folder_idx', $params['folder']);
        }
        // if (isset($params['ca'])) {
        //     $query -> where('AF_product.category_idx', $params['ca']);
        // }

        if(isset($params['categories']) && $params['categories']!= "") {
            
            $query->whereIN('ac2.idx', explode(",", $params['categories']));
        }

        if(isset($params['locations']) && !empty($params['locations'] != "")) {
            $location = explode(",", $params['locations']);
            $query->where(function ($query) use ($location) {
                foreach ($location as $key => $loc) {
                    // $clause = $key == 0 ? 'where' : 'orWhere';
                    if($key == 0) {
                        $query->where('AF_wholesale.business_address', 'like', "$loc%");
                        $query->orWhere('AF_retail.business_address', 'like', "$loc%");
                    } else {
                        $query->orWhere('AF_wholesale.business_address', 'like', "$loc%");
                        $query->orWhere('AF_retail.business_address', 'like', "$loc%");
                    }
                   
                    if (!empty($relativeTables)) {
                        $this->filterByRelationship($query, 'AF_wholesale.business_address',$relativeTables);
                        $this->filterByRelationship($query, 'AF_retail.business_address',$relativeTables);
                    }
                }
            });
        }

        $count = $query -> get() -> count();

        if(!isset($params['orderedElement']) || $params['orderedElement'] == 'register_time') {
            $params['orderedElement'] = "AF_product_interest.idx";
        }
        $list = $query -> orderBy($params['orderedElement'], 'desc') -> offset($offset) -> limit($limit) -> get();

        $data['count'] = $count;
        $data['list'] = $list;
        $data['pagination'] = paginate($params['offset'], $params['limit'], $count);
        $data['last_page'] = $count > 0 ? ceil($count / $params['limit']) : 1;

        return $data;
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
            $where .= " AND (SUBSTRING_INDEX(IF(w.idx IS NOT NULL, w.business_address, r.business_address), ' ', 1) REGEXP '".str_replace(',', '|', $params['regions'])."')";
        }

        $outerWhere = "";
        if (isset($params['categories'])) {
            foreach (explode(',', $params['categories']) as $category) {
                $outerWhere .= " FIND_IN_SET('{$category}', category_names) OR";
            }
            $outerWhere = " AND (".rtrim($outerWhere, 'OR').') ';
        }

        $orderBy = "ORDER BY ";
        if(!isset($params['orderedElement']) || $params['orderedElement'] == 'register_time') {
            $orderBy .= 'cl.idx DESC';
        } else {
            $orderBy .= $params['orderedElement'] ." DESC";
        }
        // dd($orderBy);

        $fromSql = 
            "SELECT
                cl.idx, cl.company_idx, cl.company_type
                , IF(w.idx IS NOT NULL, w.company_name, r.company_name) AS company_name
                , IF(attach.idx IS NOT NULL, CONCAT('".preImgUrl()."', attach.folder, '/', attach.filename),  '') AS profile_image
                , SUBSTRING_INDEX(IF(w.idx IS NOT NULL, w.business_address, r.business_address), ' ', 1) AS region
                , IF(w.idx IS NOT NULL, w.access_count, r.access_count) AS access_count
                , IF(TIMESTAMPDIFF(SECOND, cl.register_time, now() < 2592000), 'Y', 'N') AS is_new
                , (SELECT 
                    SUBSTRING_INDEX(GROUP_CONCAT(
                        JSON_OBJECT(
                          'name', ap.name
                         ,'idx', ap.idx 
                         ,'image', CONCAT('".preImgUrl()."', aa.folder,'/', aa.filename)
                         ,'isInterest', (SELECT if(count(pi.idx) > 0, 1, 0) FROM AF_product_interest pi WHERE pi.user_idx = ".Auth::user()->idx." AND pi.product_idx = ap.idx)
                        ) ORDER BY ap.is_represent = 1 DESC, ap.register_time DESC), '},', 3
                    ) FROM AF_product ap 
                    LEFT JOIN AF_attachment aa 
                    ON SUBSTRING_INDEX(ap.attachment_idx, ',', 1) = aa.idx 
                    WHERE ap.company_type = cl.company_type 
                        AND ap.company_idx = cl.company_idx
                    ) AS products
                ,(SELECT GROUP_CONCAT(DISTINCT ac2.name) 
                  FROM AF_category ac 
                  INNER JOIN AF_product ap 
                  ON ac.idx = ap.category_idx 
                  INNER JOIN AF_category ac2 
                  ON ac2.idx = ac.parent_idx 
                  WHERE ap.company_type = cl.company_type AND ap.company_idx = cl.company_idx
                ) AS category_names
            FROM AF_company_like AS cl
            LEFT JOIN 
                (AF_wholesale AS w LEFT JOIN AF_location AS wl ON wl.company_idx = w.idx AND wl.company_type = 'W')
            ON w.idx = cl.company_idx AND cl.company_type = 'W'
            LEFT JOIN 
                (AF_retail AS r LEFT JOIN AF_location AS rl ON rl.company_idx = r.idx AND rl.company_type = 'R')
            ON r.idx = cl.company_idx AND cl.company_type = 'R'
            LEFT JOIN AF_attachment AS attach
            ON attach.idx = w.profile_image_attachment_idx OR attach.idx = r.profile_image_attachment_idx
            WHERE cl.user_idx = ".Auth::user()['idx']." {$where}
            group by cl.company_idx, cl.company_type ".$orderBy;

        $sql = "SELECT * FROM ({$fromSql}) AS tb WHERE 1 = 1 {$outerWhere}";
        $result = DB::select($sql);

        $data['count'] = count($result);
        $data['list'] = DB::select($sql . " LIMIT {$offset}, {$limit}");
        $data['pagination'] = paginate($params['offset'], $params['limit'], $data['count']);

        return $data;
    }
}