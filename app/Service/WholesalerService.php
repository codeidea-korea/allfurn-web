<?php

namespace App\Service;

use App\Models\Attachment;
use App\Models\Banner;
use App\Models\Category;
use App\Models\CategoryProperty;
use App\Models\LikeCompany;
use App\Models\Product;
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
        $list = CompanyWholesale::select('AF_wholesale.idx as companyIdx', 'AF_wholesale.company_name as companyName', 'ap.name as productName', 'ap.idx as productIdx', 'ap.state',
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
                                 AND pa.start_date < '.DB::raw("now()").' AND pa.end_date > '.DB::raw("now()").') as isAd'))
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

        return $data;
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
                        CONCAT("'.preImgUrl().'", at.folder, "/", at.filename) as imgUrl'))
            ->where('AF_wholesale.idx', $param['wholesalerIdx'])
            ->leftjoin('AF_attachment as at', function ($query) {
                $query->on('at.idx', 'AF_wholesale.logo_attachment');
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

        $data['recommend'] = Product::select('AF_product.*',
            DB::raw('CONCAT("'.preImgUrl().'", at.folder, "/", at.filename) as imgUrl,
            (SELECT count(*)cnt FROM AF_product_interest WHERE idx = AF_product.idx AND user_idx = '.Auth::user()->idx.') as isInterest,
            (SELECT count(*)cnt FROM AF_product_ad WHERE idx = AF_product.idx AND state = "G" AND start_date < now() AND end_date > now()) as isAd'))
            ->where([
                'AF_product.company_type' => 'W',
                'AF_product.company_idx' => $param['wholesalerIdx'],
                'AF_product.is_represent' => 1,
                'AF_product.state' => 'S'
            ])
            ->leftjoin('AF_attachment as at', function($query) {
                $query->on('at.idx', DB::raw('SUBSTRING_INDEX(AF_product.attachment_idx, ",", 1)'));
            })
            ->orderBy('AF_product.idx', 'desc')
            ->limit(5)
            ->get();

        $list = Product::select('AF_product.*',
            DB::raw('CONCAT("'.preImgUrl().'",at.folder,"/", at.filename) as imgUrl,
                                IF(AF_product.access_date > DATE_ADD( NOW(), interval -1 month), 1, 0) as isNew,
                (SELECT COUNT(*) cnt FROM AF_product_interest WHERE product_idx = AF_product.idx AND user_idx = '.Auth::user()->idx.') as isInterest,
                (SELECT COUNT(*) cnt FROM AF_order WHERE product_idx = AF_product.idx ) as orderCnt,
                (SELECT COUNT(*) cnt FROM AF_product_interest WHERE product_idx = AF_product.idx AND user_idx = '.Auth::user()->idx.') as searchCnt'
            ))
            ->leftjoin('AF_attachment as at', function($query) {
                $query->on('at.idx', DB::raw('SUBSTRING_INDEX(AF_product.attachment_idx, ",", 1)'));
            })
            ->where('AF_product.company_idx', $param['wholesalerIdx'])
            ->WhereIn('AF_product.state', ['S', 'O']);

        if ($param['sort'] == 'search') {
            $list = $list->orderby('AF_product.access_count', 'desc');
        } else if ($param['sort'] == 'order') {
            $list = $list->orderby('orderCnt', 'desc');
        } else {
            $list = $list->orderby('AF_product.register_time', 'desc');
        }

        $list = $list->paginate(32);

        $data['list'] = $list;
        return view('wholesaler.detail', [
            'data'=>$data
        ]);
    }
}
