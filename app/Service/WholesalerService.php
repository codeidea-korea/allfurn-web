<?php

namespace App\Service;

use App\Models\Attachment;
use App\Models\Banner;
use App\Models\Category;
use App\Models\CategoryProperty;
use App\Models\LikeCompany;
use App\Models\Product;
use App\Models\ProductAd;
use App\Models\Cart;
use App\Models\Order;
use App\Models\ProductInterest;
use App\Models\CompanyWholesale;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class WholesalerService {

    public function getWholesalerData(array $param = []) {

        if(!isset($param['keyword'])) {
            $data['banner_top'] = Banner::where('ad_location', 'wholesaletop')
                ->where('start_date', '<', DB::raw('now()'))
                ->where('end_date', '>', DB::raw('now()'))
                ->where('state', 'G')
                ->where('is_delete', 0)
                ->where('is_open', 1)
                ->orderByRaw('banner_price desc, RAND()')
                ->limit(20)
                ->get();
        }

        // 신상품 랜덤 8개
        $list = CompanyWholesale::select(
            'AF_wholesale.idx as companyIdx',
            'AF_wholesale.company_name as companyName',
            'ap.name as productName',
            'ap.idx as productIdx',
            'ap.state',
        DB::raw('COUNT(ao.idx) as orderCnt, 
            COUNT(ap.idx) as productCnt,
            Max(ap.register_time) as register_time,
            SUBSTRING_INDEX(AF_wholesale.business_address, " ", 1) as location,
            (select ac2.name from AF_category ac2 where ac2.idx = ac.parent_idx) as categoryName,
            (select COUNT(acl.idx) from AF_company_like as acl where acl.company_type = "W" and acl.company_idx = AF_wholesale.idx and acl.user_idx = '.Auth::user()->idx.') as isLike,
            IF(AF_wholesale.register_time > DATE_ADD( NOW(), interval -1 month), 1, 0) as isNew,
            CONCAT("'.preImgUrl().'", at.folder, "/", at.filename) as imgUrl'
        ))
            //  COUNT(cah.idx) as searchCnt
            ->join('AF_product as ap', function ($query) {
                $query->on('ap.company_idx', 'AF_wholesale.idx')
                    ->where('ap.company_type', 'W')
                    ->whereIn('ap.state', ['S', 'O']);
            })
            ->leftjoin('AF_category as ac', function ($query) {
                $query->on('ac.idx', 'ap.category_idx');
            })
            ->leftjoin('AF_category as ac2', function ($query) {
                $query->on('ac2.idx', 'ac.parent_idx');
            })
            ->leftjoin('AF_order as ao', function ($query) {
                $query->on('ao.product_idx', 'ap.idx');
            })
            ->leftjoin('AF_attachment as at', function ($query) {
                $query->on('at.idx', 'AF_wholesale.logo_attachment');
            })
            // ->leftjoin('AF_user_company_access_history as cah', function ($query) {
            //     $query->on('cah.company_idx', 'AF_wholesale.idx')
            //         ->where('cah.company_type', 'W');
            // })
            ->groupBy('AF_wholesale.idx')
            ->having('productCnt', '>', 4);

        if (isset($param['location']) && !empty($param['location'])) {
            $location = explode('|', $param['location']);
            $list->where(function ($query) use ($location) {
                foreach ($location as $key => $loc) {
                    $clause = $key == 0 ? 'where' : 'orWhere';
                    $query->$clause('AF_wholesale.business_address', 'like', "$loc%");
                    if (!empty($relativeTables)) {
                        $this->filterByRelationship($query, 'AF_wholesale.business_address',
                            $relativeTables);
                    }
                }
            });
        }

        if (isset($param['sort']) && !empty($param['sort'])) {
            switch ($param['sort']) {
                case 'new':
                    // $list->orderBy(DB::raw('RAND()'));
                    break;
                case 'newreg':
                    $list->orderBy('register_time', 'desc');
                    break;
                case 'search':
                    $list->orderBy('AF_wholesale.access_count', 'desc');
                    break;
                case 'order':
                    $list->orderBy('orderCnt', 'desc');
                    break;
                case 'manyprod':
                    $list->orderBy('productCnt', 'desc');
                    break;
                case 'word':
                    $list->orderByRaw('(CASE
                    WHEN ASCII(SUBSTRING(BINARY(company_name), 1)) BETWEEN 0 AND 64 THEN 4
                    WHEN ASCII(SUBSTRING(BINARY(company_name), 1)) BETWEEN 65 AND 128 THEN 2
                    WHEN ASCII(SUBSTRING(BINARY(company_name), 1)) BETWEEN 129 AND 227 THEN 3
                    ELSE 1 END), BINARY(companyName)');
                    break;
            }
        } else {
            $list->orderBy('register_time', 'desc');
        }

        if (isset($param['keyword']) && !empty($param['keyword'])) {
            $keyword = $param['keyword'];
            $list->where(function($query) use($keyword) {
                $query->where('AF_wholesale.company_name','like',"%{$keyword}%")
                    ->orWhere('AF_wholesale.owner_name','like',"%{$keyword}%");
            });
        }
        if (isset($param['category']) && !empty($param['category'])) {
            $list->where('ac2.code','REGEXP', $param['category']);
        }

        $data['list'] = $list->paginate(5);

        foreach ($data['list'] as $key=>$item) {

            $imgList = Product::select('AF_product.idx',
                DB::raw('CONCAT("'.preImgUrl().'", at.folder, "/", at.filename) as imgUrl,
                (SELECT COUNT(DISTINCT pa.idx) cnt FROM AF_product_ad pa WHERE pa.idx = AF_product.idx AND pa.state = "G"
                                 AND pa.start_date < '.DB::raw("now()").' AND pa.end_date > '.DB::raw("now()").') as isAd
                ,(SELECT if(count(idx) > 0, 1, 0) FROM AF_product_interest pi WHERE pi.product_idx = AF_product.idx AND pi.user_idx = '.Auth::user()->idx.') as isInterest'
                ))
                ->where(['AF_product.company_idx'=>$item->companyIdx, 'AF_product.company_type'=> 'W'])
                ->whereIn('AF_product.state', ['S','O']);

            if (isset($param['category']) && !empty($param['category'])) {
                $imgList->where('ac2.code','REGEXP', $param['category']);
            }

            $imgList->leftjoin('AF_category as ac', function ($query) {
                $query->on('ac.idx', 'AF_product.category_idx');
            })
                ->leftjoin('AF_category as ac2', function ($query) {
                    $query->on('ac2.idx', 'ac.parent_idx');
                });

            $imgList->leftjoin('AF_attachment as at', function ($query) {
                $query->on('at.idx', DB::raw('SUBSTRING_INDEX(AF_product.attachment_idx, ",", 1)'));
            })
                ->orderBy('isAd', 'desc')
                ->orderBy('AF_product.access_date', 'desc')
                ->limit(4);

            $data['list'][$key]['imgList'] = $imgList->get();
        }

        // 인기 브랜드
        $data['popularbrand_ad'] = Banner::select('AF_banner_ad.*',
            DB::raw('(CASE WHEN AF_banner_ad.company_type = "W" THEN (select aw.company_name from AF_wholesale as aw where aw.idx = AF_banner_ad.company_idx)
                WHEN AF_banner_ad.company_type = "R" THEN (select ar.company_name from AF_retail as ar where ar.idx = AF_banner_ad.company_idx)
                ELSE "" END) as companyName,
                CONCAT("'.preImgUrl().'", at.folder,"/", at.filename) as imgUrl '
            ))
            ->leftjoin('AF_attachment as at', function($query) {
                $query->on('at.idx', DB::raw('SUBSTRING_INDEX(AF_banner_ad.web_attachment_idx, ",", 1)'));
            })
            ->where('AF_banner_ad.state', 'G')
            ->where('AF_banner_ad.start_date', '<', DB::raw("now()"))
            ->where('AF_banner_ad.end_date', '>', DB::raw("now()"))
            ->where('AF_banner_ad.ad_location', 'popularbrand')
            ->where('AF_banner_ad.is_delete', 0)
            ->where('AF_banner_ad.is_open', 1)
            ->orderby('idx', 'desc')->get();

        foreach($data['popularbrand_ad'] as $brand){
            $brand_product_interest = array();
            $brand_product_info = json_decode($brand->product_info, true);
            $brand->product_info = $brand_product_info;
            foreach ($brand_product_info as $key => $info) {
                $tmpInterest = DB::table('AF_product_interest')->selectRaw('if(count(idx) > 0, 1, 0) as interest')
                    ->where('product_idx', $info['mdp_gidx'])
                    ->where('user_idx', Auth::user()->idx)
                    ->first();
                $brand_product_interest[$info['mdp_gidx']] = $tmpInterest->interest;
            }
            $brand->product_interest = $brand_product_interest;
        }

        return $data;
    }

    public function getWholesalerList(array $params = []) {

        $list = CompanyWholesale::select(
             'AF_wholesale.idx as companyIdx', 'AF_wholesale.company_name as companyName'
            , 'ap.name as productName', 'ap.idx as productIdx', 'ap.state'
            , DB::raw('COUNT(ao.idx) as orderCnt')
            , DB::raw('COUNT(ap.idx) as productCnt')
            , DB::raw('AF_wholesale.access_count AS companyAccessCount')  // 업체조회수
            , DB::raw('SUM(ap.access_count)  AS productAccessCount')  // 상품조회수
            , DB::raw('Max(ap.access_date) as access_date')
            , DB::raw('SUBSTRING_INDEX(AF_wholesale.business_address, " ", 1) as location')
            , DB::raw('GROUP_CONCAT( DISTINCT (ac2.name)) as categoryList')
            , DB::raw('(SELECT if(count(*) > 0, 1, 0)
                        FROM AF_company_like AS acl 
                        WHERE acl.company_idx = AF_wholesale.idx
                            AND acl.user_idx = '.Auth::user()->idx.'
                        ) AS isCompanyInterest')
            , DB::raw('CONCAT("'.preImgUrl().'", at.folder, "/", at.filename) as imgUrl'
        ))
        ->join('AF_product as ap', function ($query) {
            $query->on('ap.company_idx', 'AF_wholesale.idx')
                ->where('ap.company_type', 'W')
                ->whereIn('ap.state', ['S', 'O']);
        })
        /* ->leftjoin('AF_banner_ad AS aba', function($query) {
            $query->on('AF_wholesale.idx', 'aba.company_idx')
            ->where('state', 'G')
            ->where('is_delete', 1)
            ->where('is_open', 0);
        }) */
        ->leftjoin('AF_category as ac', function ($query) {
            $query->on('ac.idx', 'ap.category_idx');
        })
        ->leftjoin('AF_category as ac2', function ($query) {
            $query->on('ac2.idx', 'ac.parent_idx');
        })
        ->leftjoin('AF_order as ao', function ($query) {
            $query->on('ao.product_idx', 'ap.idx');
        })
        ->leftjoin('AF_attachment as at', function ($query) {
            $query->on('at.idx', 'AF_wholesale.logo_attachment');
        })
        ->groupBy('AF_wholesale.idx');


        if (isset($params['locations']) && !empty($params['locations'])) {
            $locations = explode(',', $params['locations']);
            $list->where(function ($query) use ($locations) {
                foreach ($locations as $key => $loc) {
                    if($key == 0) {
                        $query->where('AF_wholesale.business_address', 'like', "$loc%");
                    } else {
                        $query->orWhere('AF_wholesale.business_address', 'like', "$loc%");
                    }
                    if (!empty($relativeTables)) {
                        $this->filterByRelationship($query, 'AF_wholesale.business_address', $relativeTables);
                    }
                }
            });
        }

        if (isset($params['orderedElement']) && !empty($params['orderedElement'])) {
            switch ($params['orderedElement']) {
                //TODO: 추천순 개발 필요
                case 'recommendation';
                    $list->orderBy('access_date', 'desc');   
                    break;
                case 'word':
                    $list->orderByRaw('(CASE
                    WHEN ASCII(SUBSTRING(BINARY(company_name), 1)) BETWEEN 0 AND 64 THEN 4
                    WHEN ASCII(SUBSTRING(BINARY(company_name), 1)) BETWEEN 65 AND 128 THEN 2
                    WHEN ASCII(SUBSTRING(BINARY(company_name), 1)) BETWEEN 129 AND 227 THEN 3
                    ELSE 1 END), BINARY(companyName)');
                    break;
                case 'register_time':
                    $list->orderBy('access_date', 'DESC');
                    break;
                default:
                    $list->orderBy($params['orderedElement'], 'DESC');
            }
        } else {
            $list->orderBy('register_time', 'desc');
        }

        $list->orderBy('access_date', 'desc');

        if (isset($params['keyword']) && !empty($params['keyword'])) {
            $keyword = $params['keyword'];
            $list->where(function($query) use($keyword) {
                $query->where('AF_wholesale.company_name','like',"%{$keyword}%")
                    ->orWhere('AF_wholesale.owner_name','like',"%{$keyword}%");
            });
        }
        if (isset($params['categories']) && !empty($params['categories'])) {
            $list->whereIN('ac2.idx', explode(",", $params['categories']));
        }

        $list = $list->paginate($params['limit']);

        foreach($list as $key => $value) {
            $list[$key]->productList = DB::table(DB::raw(
                    '(select * from AF_product where company_idx = '. $value->companyIdx .') AS ap'
                ))
                ->select(
                        'ap.idx AS productIdx'
                    , DB::raw('CONCAT("'.preImgUrl().'", at.folder,"/", at.filename) as imgUrl')
                    , DB::raw('(SELECT if(count(idx) > 0, 1, 0) 
                                FROM AF_product_interest pi 
                                WHERE pi.product_idx = ap.idx 
                                    AND pi.user_idx = '.Auth::user()->idx.'
                                ) as isInterest')
                )
                ->leftjoin('AF_attachment as at', function($query) {
                    $query->on('at.idx', DB::raw('SUBSTRING_INDEX(ap.attachment_idx, ",", 1)'));
                })
                ->orderByRaw('ap.is_represent = 1 desc')
                ->orderBy('ap.access_date','desc')
                ->limit(3)
                ->get();
        }

        return $list;     
    }

    public function likeToggle(int $wholesalerIdx)
    {
        $cnt = LikeCompany::where([
            'company_type'=>'W',
            'company_idx'=>$wholesalerIdx,
            'user_idx'=>Auth::user()->idx
        ])->count();

        $isLisk = 0;
        $like = new LikeCompany;

        if ($cnt > 0) {
            $like->where([
                'company_type'=>'W',
                'company_idx'=>$wholesalerIdx,
                'user_idx'=>Auth::user()->idx
            ])->delete();
        } else {
            $like->user_idx = Auth::user()->idx;
            $like->company_type = 'W';
            $like->company_idx = $wholesalerIdx;
            $like->register_time = DB::raw('now()');
            $like->save();

            $isLisk = 1;
        }

        return response()->json([
            'success'=>true,
            'like'=>$isLisk
        ]);
    }

    public function detail(array $param = [])
    {
        CompanyWholesale::where('idx', $param['wholesalerIdx'])
            ->update(['access_count' => DB::raw('access_count+1')]);

        $data['info'] = CompanyWholesale::select('AF_wholesale.*',
        DB::raw('(CASE WHEN AF_wholesale.inquiry_count >= 100000000 THEN CONCAT(AF_wholesale.inquiry_count/100000000,"억")
                           WHEN AF_wholesale.inquiry_count >= 10000000 THEN CONCAT(AF_wholesale.inquiry_count/10000000,"천만")
                           WHEN AF_wholesale.inquiry_count >= 10000 THEN CONCAT(AF_wholesale.inquiry_count/10000, "만")
                           WHEN AF_wholesale.inquiry_count >= 1000 THEN CONCAT(AF_wholesale.inquiry_count/1000, "천")
                           ELSE AF_wholesale.inquiry_count END) as inquiryCnt,
                        (CASE WHEN AF_wholesale.access_count >= 100000000 THEN CONCAT(AF_wholesale.access_count/100000000,"억")
                           WHEN AF_wholesale.access_count >= 10000000 THEN CONCAT(AF_wholesale.access_count/10000000,"천만")
                           WHEN AF_wholesale.access_count >= 10000 THEN CONCAT(AF_wholesale.access_count/10000, "만")
                           WHEN AF_wholesale.access_count >= 1000 THEN CONCAT(AF_wholesale.access_count/1000, "천")
                           ELSE AF_wholesale.access_count END) as visitCnt,
                        (SELECT CASE WHEN COUNT(*) >= 100000000 THEN CONCAT(COUNT(*)/100000000,"억")
                           WHEN COUNT(*) >= 10000000 THEN CONCAT(COUNT(*)/10000000,"천만")
                           WHEN COUNT(*) >= 10000 THEN CONCAT(COUNT(*)/10000, "만")
                           WHEN COUNT(*) >= 1000 THEN CONCAT(COUNT(*)/1000, "천")
                           ELSE COUNT(*) END cnt FROM AF_company_like WHERE company_idx = AF_wholesale.idx AND company_type = "W") as likeCnt,
                        (SELECT COUNT(*) cnt FROM AF_company_like WHERE company_idx = AF_wholesale.idx AND company_type = "W" AND user_idx = '.Auth::user()->idx.') as isLike,
                        CONCAT("'.preImgUrl().'", at.folder, "/", at.filename) as imgUrl, CONCAT("'.preImgUrl().'", at2.folder, "/", at2.filename) as imgUrl2'))
            ->where('AF_wholesale.idx', $param['wholesalerIdx'])
            ->leftjoin('AF_attachment as at', function ($query) {
                $query->on('at.idx', 'AF_wholesale.profile_image_attachment_idx');
            })
            ->leftjoin('AF_attachment as at2', function ($query) {
                $query->on('at2.idx', 'AF_wholesale.top_banner_attachment_idx');
            })
            ->first();

        $data['category'] = Product::select('ac2.name', 'ac2.idx', DB::raw('count(ac2.idx) as cnt'))
            ->where(['company_idx'=>$param['wholesalerIdx'], 'company_type'=>'W'])
            ->leftjoin('AF_category as ac', function ($query) {
                $query->on('ac.idx', 'AF_product.category_idx');
            })
            ->leftjoin('AF_category as ac2', function ($query) {
                $query->on('ac2.idx', 'ac.parent_idx');
            })
            ->groupBy('ac2.idx')
            ->orderBy('cnt', 'desc')
            ->get();

        // 인기 상품
        // 조건1: 광고중인 상품( isAd=1 ) 이면서 
        // 조건2: 좋아요( isInterest ) 가 있는 상품 => 이조건 제외함(24.04.19)
        $data['event'] = Product::select(
             'AF_product.*'
            , DB::raw('CONCAT("'.preImgUrl().'", at.folder, "/", at.filename) as imgUrl')
            , DB::raw('(SELECT count(*)cnt FROM AF_product_interest WHERE product_idx = AF_product.idx AND user_idx = '. Auth::user()->idx .') as isInterest')
        )
        ->leftjoin('AF_product_ad', function($query) {
            $query->on('AF_product_ad.product_idx', 'AF_product.idx')
            ->where('AF_product_ad.state', 'G')
            ->where('AF_product_ad.start_date', '<', DB::raw('now()'))
            ->where('AF_product_ad.end_date', '>', DB::raw('now()'));
        })
        ->leftjoin('AF_attachment as at', function($query) {
            $query->on('at.idx', DB::raw('SUBSTRING_INDEX(AF_product.attachment_idx, ",", 1)'));
        })
        ->where('AF_product.company_idx', $param['wholesalerIdx'])
        ->where('AF_product.company_type', 'W')
        ->where('AF_product.state', 'S')
        ->whereNotNull('AF_product_ad.idx')
        ->orderBy('AF_product_ad.price', 'DESC')
        ->orderBy('AF_product_ad.register_time', 'DESC')
        ->get();

        // 추천 상품
        $data['recommend'] = Product::select(
             'AF_product.*'
            , DB::raw('CONCAT("'.preImgUrl().'", at.folder, "/", at.filename) as imgUrl')
            , DB::raw('(SELECT count(*)cnt FROM AF_product_interest WHERE product_idx = AF_product.idx AND user_idx = '. Auth::user()->idx .') as isInterest')
        )
        ->leftjoin('AF_attachment as at', function($query) {
            $query->on('at.idx', DB::raw('SUBSTRING_INDEX(AF_product.attachment_idx, ",", 1)'));
        })
        ->where('AF_product.company_idx', $param['wholesalerIdx'])
        ->where('AF_product.state', 'S')
        ->where('AF_product.is_represent', 1)
        ->whereNotNull('AF_product.access_date')
        ->orderBy('AF_product.access_date', 'DESC')
        ->limit(5)
        ->get();

        return $data;
    }

    //TODO: 전화문의, 올톡문의 점수가 추가되어야 함.
    function getThisMonthWholesaler(array $params = [])
    {
        $list = DB::table(DB::raw(
            '(SELECT idx, company_type, company_idx, ad_location ,category_idx, MAX(banner_price) AS banner_price, start_date, end_date, register_time
              FROM AF_banner_ad 
              WHERE ad_location = "wholesaletop"
              AND DATE(start_date) <= CURDATE() AND DATE(end_date) >= CURDATE()
              AND state = "G"
              AND is_delete = 0
              AND is_open = 1
              GROUP BY company_idx
            ) AS aba'
        ))
        ->select(
             'aba.*', 'aw.company_name'
            , DB::raw('SUM(ap.inquiry_count) AS productInquiryCount') // 상품문의수
            , DB::raw('SUM(ap.access_count)  AS productAccessCount')  // 상품조회수
            , DB::raw('aw.inquiry_count      AS companyInquiryCount') // 업체문의(올톡??) -> 확인필요
            , DB::raw('aw.access_count       AS companyAccessCount')  // 업체조회수
            , DB::raw('CAST(banner_price * 0.01 * (banner_price / 100000) AS UNSIGNED) AS addtionalPoint') // 가산점
            , DB::raw('(SUM(ap.inquiry_count) + SUM(ap.access_count) + aw.inquiry_count  + aw.access_count + CAST(banner_price * 0.01 * (banner_price / 100000) AS UNSIGNED) ) AS score') // 총점수
            , DB::raw('GROUP_CONCAT( DISTINCT (ac2.name)) as categoryList')
            , DB::raw('(SELECT if(count(*) > 0, 1, 0)
                        FROM AF_company_like AS acl 
                        WHERE acl.company_idx = aba.company_idx
                            AND acl.user_idx = '.Auth::user()->idx.'
                        ) AS isCompanyInterest')
            , DB::raw('(SELECT SUBSTRING_INDEX(business_address, " ", 1) 
                        FROM AF_wholesale 
                        WHERE idx = aba.company_idx
                        ) AS location')
        )
        ->leftJoin('AF_wholesale AS aw', function($query) {
            $query->on('aw.idx', 'aba.company_idx');
        })
        ->leftjoin('AF_product AS ap', function($query) {
            $query->on('ap.company_idx', 'aba.company_idx');
        })
        ->leftjoin('AF_category AS ac', function ($query) {
            $query->on('ac.idx', 'ap.category_idx');
        })
        ->leftjoin('AF_category AS ac2', function ($query) {
            $query->on('ac2.idx', 'ac.parent_idx');
        });

        if (isset($params['categoryIdx']) && !empty($params['categoryIdx'])) {
            $location = explode(',', $params['categoryIdx']);
            $list->where(function ($query) use ($location) {
                $query->where('ac2.code', 'REGEXP', implode('|', $location) );
            });
        }

        if (isset($params['locationIdx']) && !empty($params['locationIdx'])) {
            $location = explode(',', $params['locationIdx']);
            $list->where(function ($query) use ($location) {
                foreach ($location as $key => $loc) {
                    $clause = $key == 0 ? 'where' : 'orWhere';
                    $query->$clause('aw.business_address', 'like', "$loc%");
                    if (!empty($relativeTables)) {
                        $this->filterByRelationship($query, 'aw.business_address',
                            $relativeTables);
                    }
                }
            });
        }
        
        if(isset($params['orderedElement'])) {
            $list->groupBy('company_idx')
                ->orderBy($params['orderedElement'], 'desc')
                ->orderByRaw('ap.is_represent = 1 desc')
                ->orderBy('ap.access_date','desc');
        } else {
            $list->groupBy('company_idx')
                ->orderBy('score', 'desc')
                ->orderByRaw('ap.is_represent = 1 desc')
                ->orderBy('ap.access_date','desc');
        }

        if( isset( $params['limit'] ) && $params['limit'] > 0 ) {
            $list = $list->limit($params['limit'])->get();
        } else {
            $list = $list->paginate(5);
        }

        // 업체별 상품 3개 - 대표 상품 먼저
        foreach($list as $key => $value) {

            $list[$key]->productList =
                DB::table(DB::raw(
                '(select * from AF_product where company_idx = '. $value->company_idx .') AS ap'
            ))
            ->select(
                    'ap.idx AS productIdx'
                , DB::raw('CONCAT("'.preImgUrl().'", at.folder,"/", at.filename) as imgUrl')
                , DB::raw('(SELECT if(count(idx) > 0, 1, 0) 
                            FROM AF_product_interest pi 
                            WHERE pi.product_idx = ap.idx 
                                AND pi.user_idx = '.Auth::user()->idx.'
                            ) as isInterest')
            )
            ->leftjoin('AF_attachment as at', function($query) {
                $query->on('at.idx', DB::raw('SUBSTRING_INDEX(ap.attachment_idx, ",", 1)'));
            })
            ->orderByRaw('ap.is_represent = 1 desc')
            ->orderBy('ap.access_date','desc')
            ->limit(3)
            ->get();
        }

        return $list;
    }
}
