<?php

namespace App\Service;

use App\Models\Attachment;
use App\Models\Banner;
use App\Models\Category;
use App\Models\CategoryProperty;
use App\Models\CompanyRetail;
use App\Models\CompanyWholesale;
use App\Models\KeywordAd;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\ProductAd;
use App\Models\ProductInterest;
use App\Models\ProductRecent;
use App\Models\ProductTemp;
use App\Models\UserAddress;
use App\Models\MonthWholesaleSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ProductService
{

    /**
     * @param int $orderIdx
     * @return mixed
     */
    public function getCategoryList(int $orderIdx = 0)
    {
        if ($orderIdx != 0) {
            return Category::where('parent_idx', $orderIdx)
                ->where('is_delete', 0)
                ->orderBy('order_idx', 'asc')
                ->get();
        } else {
            return Category::select('AF_category.*',
                DB::raw('CONCAT("'.preImgUrl().'", aat.folder, "/", aat.filename) AS imgUrl'))
                ->where('parent_idx', null)
                ->where('is_delete', 0)
                ->leftjoin('AF_attachment as aat', function($query) {
                    $query->on('aat.idx', '=', 'AF_category.icon_attachment_idx');
                })
                ->orderBy('AF_category.order_idx', 'asc')
                ->get();
        }
    }

    public function getCategoryListV2()
    {
        $category = Category::select('AF_category.*',
            DB::raw('CONCAT("'.preImgUrl().'", aat.folder, "/", aat.filename) AS imgUrl'))
            ->where('parent_idx', null)
            ->where('is_delete', 0)
            ->leftjoin('AF_attachment as aat', function($query) {
                $query->on('aat.idx', '=', 'AF_category.icon_attachment_idx');
            })
            ->orderBy('AF_category.order_idx', 'asc')
            ->get();
            
        foreach($category as $depth1) {
            $depth1->depth2 = Category::whereRaw('is_delete=0 and parent_idx='.$depth1->idx)->orderBy('order_idx', 'asc')->get();
        }

        return $category;
    }

    public function getCategoryProperty(array $params = [])
    {
        Log::info($params);
        return CategoryProperty::where('category_idx', $params['category_idx'])
            ->where('parent_idx', $params['parent_idx'])
            ->where('is_delete', 0)
            ->orderby('order_idx', 'asc')
            ->get();
    }

    public function getCategoryAll()
    {
        return Category::where('is_delete', 0)
            ->orderby('order_idx', 'asc')
            ->get();
    }



    public function getProductData(int $productIdx, string $type = '') {

        if ($type != '' && $type == 'temp') {

            $data['detail'] = ProductTemp::select('AF_product_temp.*', 'ac2.idx as category_parent_idx',
                DB::raw('CONCAT(ac2.name, CONCAT(" > ", ac.name)) as category,
            (CASE WHEN AF_product_temp.company_type = "W" THEN (select aw.company_name from AF_wholesale as aw where aw.idx = AF_product_temp.company_idx)
                  WHEN AF_product_temp.company_type = "R" THEN (select ar.company_name from AF_retail as ar where ar.idx = AF_product_temp.company_idx)
                  ELSE "" END) as companyName,                  
            (CASE WHEN AF_product_temp.company_type = "W" THEN (select aw.phone_number from AF_wholesale as aw where aw.idx = AF_product_temp.company_idx)
                  WHEN AF_product_temp.company_type = "R" THEN (select ar.phone_number from AF_retail as ar where ar.idx = AF_product_temp.company_idx)
                  ELSE "" END) as companyPhoneNumber,
                  COUNT(DISTINCT pi.idx) as isInterest,
                  COUNT(DISTINCT pa.idx) as isAd'))
                ->leftjoin('AF_product_interest as pi', function ($query) {
                    $query->on('pi.product_idx', 'AF_product_temp.idx')->where('pi.user_idx', Auth::user()->idx);
                })
                ->leftjoin('AF_product_ad as pa', function ($query) {
                    $query->on('pa.product_idx', 'AF_product_temp.idx')
                        ->where('pa.state', 'G')
                        ->where('pa.start_date', '<', DB::raw('now()'))
                        ->where('pa.end_date', '>', DB::raw('now()'));
                })
                ->leftjoin('AF_category as ac', function($query) {
                    $query->on('ac.idx', '=', 'AF_product_temp.category_idx');
                })
                ->leftjoin('AF_category as ac2', function($query) {
                    $query->on('ac2.idx', '=', 'ac.parent_idx');
                })
                ->where('AF_product_temp.idx', $productIdx)
                ->first();
                
        } else {
            
            if(strpos($_SERVER['REQUEST_URI'], 'getProductData') === false && strpos($_SERVER['REQUEST_URI'], 'modify') === false) {
                $rec = new ProductRecent;
                $rec->user_idx = Auth::user()->idx;
                $rec->product_idx = $productIdx;
                $rec->register_time = DB::raw('now()');
                $rec->save();
            }

            $data['detail'] = Product::select('AF_product.*', 'ac2.idx as category_parent_idx',
                DB::raw('CONCAT(ac2.name, CONCAT(" > ", ac.name)) as category,
            (CASE WHEN AF_product.company_type = "W" THEN (select aw.company_name from AF_wholesale as aw where aw.idx = AF_product.company_idx)
                  WHEN AF_product.company_type = "R" THEN (select ar.company_name from AF_retail as ar where ar.idx = AF_product.company_idx)
                  ELSE "" END) as companyName,
            (CASE WHEN AF_product.company_type = "W" THEN (select aw.phone_number from AF_wholesale as aw where aw.idx = AF_product.company_idx)
                  WHEN AF_product.company_type = "R" THEN (select ar.phone_number from AF_retail as ar where ar.idx = AF_product.company_idx)
                  ELSE "" END) as companyPhoneNumber,
                  COUNT(DISTINCT pi.idx) as isInterest,
                  COUNT(DISTINCT pa.idx) as isAd'))
                ->leftjoin('AF_product_interest as pi', function ($query) {
                    $query->on('pi.product_idx', 'AF_product.idx')->where('pi.user_idx', Auth::user()->idx);
                })
                ->leftjoin('AF_product_ad as pa', function ($query) {
                    $query->on('pa.product_idx', 'AF_product.idx')
                        ->where('pa.state', 'G')
                        ->where('pa.start_date', '<', DB::raw('now()'))
                        ->where('pa.end_date', '>', DB::raw('now()'));
                })
                ->leftjoin('AF_category as ac', function($query) {
                    $query->on('ac.idx', '=', 'AF_product.category_idx');
                })
                ->leftjoin('AF_category as ac2', function($query) {
                    $query->on('ac2.idx', '=', 'ac.parent_idx');
                })
                ->where('AF_product.idx', $productIdx)
                ->first();

            $data['recommend'] = Product::select('AF_product.*',
                DB::raw('CONCAT("'.preImgUrl().'", at.folder, "/", at.filename) as imgUrl,
            (SELECT count(*)cnt FROM AF_product_interest WHERE idx = AF_product.idx AND user_idx = '.Auth::user()->idx.') as isInterest,
            (SELECT count(*)cnt FROM AF_product_ad WHERE idx = AF_product.idx AND state = "G" AND start_date < now() AND end_date > now()) as isAd'))
                ->where([
                    'AF_product.company_type' => $data['detail']->company_type,
                    'AF_product.company_idx' => $data['detail']->company_idx,
                    'AF_product.is_represent' => 1,
                    'AF_product.state' => 'S'
                ])
                ->where('AF_product.idx', '<>' ,$productIdx)
                ->leftjoin('AF_attachment as at', function($query) {
                    $query->on('at.idx', DB::raw('SUBSTRING_INDEX(AF_product.attachment_idx, ",", 1)'));
                })
                ->orderBy('AF_product.idx', 'desc')
                ->limit(5)
                ->get();
        }

        if ($data['detail']->property != "") {
            $data['detail']->propertyList = CategoryProperty::select('AF_category_property.*', 'ac2.name as parent_name')
                ->whereIn('AF_category_property.idx', explode(',', $data['detail']->property))
                ->leftjoin('AF_category_property as ac2', function ($query) {
                    $query->on('ac2.idx', 'AF_category_property.parent_idx');
                    })
                ->orderBy('AF_category_property.parent_idx', 'asc')
                ->get();
        } else {
            $data['detail']->propertyList = [];
        }
        
        

        $attachment = array();
        if ($data['detail']->attachment_idx != null) {
            foreach(explode(',', $data['detail']->attachment_idx) as $att) {
                array_push($attachment, Attachment::select(DB::raw('CONCAT("'.preImgUrl().'", folder, "/", filename) as imgUrl'))->where('idx', $att)->first());
            }
        }
        $data['detail']->attachment = $attachment;

        Product::where('idx', $productIdx)
            ->update(['access_count' => DB::raw('access_count + 1')]);

        return $data;
    }


    public function getProductOption(int $product_idx)
    {
        return Product::select('AF_product.product_option')
            ->where('AF_product.idx', $product_idx)
            ->get();
    }

    public function getMyProductList()
    {
        $data = Product::select('AF_product.idx', 'AF_product.name',
            DB::raw("CONCAT(ac2.name, CONCAT(' > ', ac.name)) as category"),
            DB::raw("CONCAT('state_', AF_product.state) as state"))
            ->leftjoin('AF_category as ac', function($query) {
                $query->on('ac.idx', '=', 'AF_product.category_idx');
            })
            ->leftjoin('AF_category as ac2', function($query) {
                $query->on('ac2.idx', '=', 'ac.parent_idx');
            })
            ->where('AF_product.user_idx', Auth::user()->idx)
            ->orderBy('AF_product.idx', 'desc')
            ->get();
        return $data;
    }

    public function getProductList(array $param = [])
    {
        $data = Product::select('AF_product.*',
            DB::raw("CONCAT(ac2.name, CONCAT(' > ', ac.name)) as category"),
            DB::raw("CONCAT('state_', AF_product.state) as state"))
            ->leftjoin('AF_category as ac', function($query) {
                $query->on('ac.idx', '=', 'AF_product.category_idx');
            })
            ->leftjoin('AF_category as ac2', function($query) {
                $query->on('ac2.idx', '=', 'ac.parent_idx');
            })
            ->whereIn('AF_product.state', ['S', 'O'])
            ->get();
        return $data;
    }

    public function saveAttachment(string $filePath)
    {
        $amt = new Attachment;
        $amt->folder = explode("/", $filePath)[0];
        $amt->filename = explode("/", $filePath)[1];
        $amt->register_time = DB::raw('now()');
        $amt->save();

        return $amt->idx;
    }

    public function deleteImage(int $imgIdx)
    {
        $att = new Attachment;
        $att->where(['idx'=>$imgIdx])->delete();
    }

    public function interestToggle(int $productIdx)
    {
        $cnt = ProductInterest::where([
            'product_idx'=>$productIdx,
            'user_idx'=>Auth::user()->idx
        ])->count();

        $interest = 0;
        $pi = new ProductInterest;

        if ($cnt > 0) {
            $pi->where([
                'product_idx'=>$productIdx,
                'user_idx'=>Auth::user()->idx
            ])->delete();
        } else {
            $pi->user_idx = Auth::user()->idx;
            $pi->product_idx = $productIdx;
            $pi->register_time = DB::raw('now()');
            $pi->save();

            $interest = 1;
        }

        return response()->json([
            'success'=>true,
            'interest'=>$interest
        ]);
    }



    public function create(array $param) {
        
        $productNum = $this->makeProductNum($param['category_idx'], 6);

        $product = new Product;
        if($param['reg_type'] == 1) {
            $product = new ProductTemp;
        }

        $product->category_idx = $param['category_idx'];
        $product->company_type = Auth::user()->type;
        $product->company_idx = Auth::user()->company_idx;
        $product->property = $param['property'];
        $product->user_idx = Auth::user()->idx;
        $product->name = $param['name'];
        $product->price = $param['price'];
        $product->is_price_open = $param['is_price_open'];
        $product->is_new_product = $param['is_new_product'];
        
        if ($param['is_price_open'] == 0) {
            $product->price_text = $param['price_text'];
        }
        $product->pay_type = $param['pay_type'];
        if ($param['pay_type'] == 4)
        {
            $product->pay_type_text = $param['pay_type_text'];
        }
        $product->product_code = $param['product_code'];
        $product->product_number = $productNum;
        $product->delivery_info = $param['delivery_info'];
        $product->notice_info = $param['notice_info'];
        $product->auth_info = $param['auth_info'];
        $product->product_detail = $param['product_detail'];
        $product->is_pay_notice = $param['is_pay_notice'];
        $product->pay_notice = $param['pay_notice'];
        $product->is_delivery_notice = $param['is_delivery_notice'];
        $product->delivery_notice = $param['delivery_notice'];
        $product->is_return_notice = $param['is_return_notice'];
        $product->return_notice = $param['return_notice'];
        $product->is_order_notice = $param['is_order_notice'];
        $product->order_title = $param['order_title'];
        $product->order_content = $param['order_content'];
        $product->product_option = $param['product_option'];
        $product->state = 'W';
        $product->attachment_idx = $param['attachmentIdx'];
        $product->register_time = DB::raw('now()');
        $product->save();

        return $product->idx;
    }

    public function modify(array $param)
    {

        return Product::where('idx', $param['productIdx'])
            ->update(['category_idx' => $param['category_idx'],
            'company_type' => Auth::user()->type,
            'company_idx' => Auth::user()->company_idx,
            'user_idx' => Auth::user()->idx,
            'name' => $param['name'],
            'property' => $param['property'],
            'price' => $param['price'],
            'is_price_open' => $param['is_price_open'],
            'price_text' => $param['price_text'],
            'pay_type' => $param['pay_type'],
            'pay_type_text' => isset($param['pay_type_text']) ?? '',
            'product_code' => $param['product_code'],
            'delivery_info' => $param['delivery_info'],
            'notice_info' => $param['notice_info'],
            'auth_info' => $param['auth_info'],
            'product_detail' => $param['product_detail'],
            'is_pay_notice' => $param['is_pay_notice'],
            'pay_notice' => $param['pay_notice'],
            'is_delivery_notice' => $param['is_delivery_notice'],
            'delivery_notice' => $param['delivery_notice'],
            'is_return_notice' => $param['is_return_notice'],
            'return_notice' => $param['return_notice'],
            'is_order_notice' => $param['is_order_notice'],
            'order_title' => $param['order_title'],
            'order_content' => $param['order_content'],
            'product_option' => $param['product_option'],
            'attachment_idx' => $param['attachmentIdx']
            ]);
    }


    public function getBannerList()
    {
        return Banner::where('ad_location', 'newproducttop')
            ->where('start_date', '<', DB::raw('now()'))
            ->where('end_date', '>', DB::raw('now()'))
            ->where('state', 'G')
            ->where('is_delete', 0)
            ->where('is_open', 1)
            ->orderByRaw('banner_price desc, RAND()')
            ->limit(20)
            ->has('attachment')
            ->get();
    }

    public function getTodayCount()
    {
        return Product::whereDate('access_date', DB::raw('date(now())'))
            ->count();
    }

    public function getNewProductList(array $param = [])
    {
        $list_a = ProductAd::select('AF_product.*',
            DB::raw('
                AF_product_ad.price as ad_price,
                1 as isAd,
                (CASE WHEN AF_product.company_type = "W" THEN (select aw.company_name from AF_wholesale as aw where aw.idx = AF_product.company_idx)
                                WHEN AF_product.company_type = "R" THEN (select ar.company_name from AF_retail as ar where ar.idx = AF_product.company_idx)
                                ELSE "" END) as companyName,
                                CONCAT("'.preImgUrl().'", at.folder,"/", at.filename) as imgUrl,
                                (SELECT COUNT(DISTINCT pi.idx) cnt FROM AF_product_interest pi WHERE pi.product_idx = AF_product.idx AND pi.user_idx = '.Auth::user()->idx.') as isInterest,
                                NULL as reg_time'
                                ))
            ->where('AF_product_ad.state', 'G')
            ->where('AF_product_ad.start_date', '<', DB::raw("now()"))
            ->where('AF_product_ad.end_date', '>', DB::raw("now()"))
            ->where('AF_product_ad.ad_location', 1)
            ->where('AF_product_ad.is_delete', 0)
            ->where('AF_product_ad.is_open', 1)                                                
            ->join('AF_product', function ($query) {
                $query->on('AF_product.idx', 'AF_product_ad.product_idx')
                    ->whereIn('AF_product.state', ['S', 'O']);
            })
            ->leftjoin('AF_attachment as at', function($query) {
                $query->on('at.idx', DB::raw('SUBSTRING_INDEX(AF_product.attachment_idx, ",", 1)'));
            })
            ->join('AF_category as ac', function ($query) {
                $query->on('ac.idx', 'AF_product.category_idx');
            })
            ->join('AF_category as ac2', function ($query) {
                $query->on('ac2.idx', 'ac.parent_idx');
            });

        if ($param['target'] != 'ALL') {
            $list_a->where('ac2.code', 'REGEXP', $param['target']);
        }

        $list_b = Product::select('AF_product.*',
            DB::raw('
                0 as ad_price,
                0 as isAd,
                (CASE WHEN AF_product.company_type = "W" THEN (select aw.company_name from AF_wholesale as aw where aw.idx = AF_product.company_idx)
                                WHEN AF_product.company_type = "R" THEN (select ar.company_name from AF_retail as ar where ar.idx = AF_product.company_idx)
                                ELSE "" END) as companyName,
                                CONCAT("'.preImgUrl().'", at.folder,"/", at.filename) as imgUrl,
                                (SELECT COUNT(DISTINCT pi.idx) cnt FROM AF_product_interest pi WHERE pi.product_idx = AF_product.idx AND pi.user_idx = '.Auth::user()->idx.') as isInterest,
                                AF_product.register_time as reg_time'
            ))
            ->leftjoin('AF_attachment as at', function($query) {
                $query->on('at.idx', DB::raw('SUBSTRING_INDEX(AF_product.attachment_idx, ",", 1)'));
            })
            ->leftjoin('AF_product_ad as pa2', function ($query) {
                $query->on('pa2.product_idx', 'AF_product.idx')
                    ->where('pa2.state', 'G')
                    ->where('pa2.start_date', '<', DB::raw("now()"))
                    ->where('pa2.end_date', '>', DB::raw("now()"));
            })
            ->join('AF_category as ac', function ($query) {
                $query->on('ac.idx', 'AF_product.category_idx');
            })
            ->join('AF_category as ac2', function ($query) {
                $query->on('ac2.idx', 'ac.parent_idx');
            })
            ->where('AF_product.is_new_product', 1)
            ->whereIn('AF_product.state', ['S', 'O']);

        if ($param['target'] != 'ALL') {
            $list_b->where('ac2.code', 'REGEXP', $param['target']);
        }

        return $list_a->union($list_b)->orderby('ad_price', 'desc')->orderby('reg_time', 'desc')->inRandomOrder()->paginate(32);

    }


    /** 베스트상품 목록 */
    public function getBestNewProductList(array $param = [])
    {
        $bestNewProducts = ProductAd::select('AF_product.idx', 'AF_product.name', 'AF_product.price', 
            DB::raw('AF_product_ad.price as ad_price, 
                (CASE WHEN AF_product.company_type = "W" THEN (select aw.company_name from AF_wholesale as aw where aw.idx = AF_product.company_idx)
                WHEN AF_product.company_type = "R" THEN (select ar.company_name from AF_retail as ar where ar.idx = AF_product.company_idx)
                ELSE "" END) as companyName,
                CONCAT("'.preImgUrl().'", at.folder,"/", at.filename) as imgUrl, 
                (SELECT if(count(idx) > 0, 1, 0) FROM AF_product_interest pi WHERE pi.product_idx = AF_product.idx AND pi.user_idx = '.Auth::user()->idx.') as isInterest'
            ))
            ->join('AF_product', function ($query) {
                $query->on('AF_product.idx', 'AF_product_ad.product_idx')
                    ->whereIn('AF_product.state', ['S', 'O']);
            })
            ->leftjoin('AF_attachment as at', function($query) {
                $query->on('at.idx', DB::raw('SUBSTRING_INDEX(AF_product.attachment_idx, ",", 1)'));
            })
            ->where('AF_product_ad.state', 'G')
            ->where('AF_product_ad.start_date', '<', DB::raw("now()"))
            ->where('AF_product_ad.end_date', '>', DB::raw("now()"))
            ->where('AF_product_ad.ad_location', 1)
            ->where('AF_product_ad.is_delete', 0)
            ->where('AF_product_ad.is_open', 1)
            ->orderby('ad_price', 'desc')->inRandomOrder()->get();
        return $bestNewProducts;
    }

    //신규 등록 상품
    //TODO: 인기순(좋아요+올톡문의+전화문의+견적서문의) 필터적용한 조회기능으로 변경 / 현재까지 개발된 인기순 = 좋아요+올톡문의
    public function getNewAddedProductList($params) {
        $new_product = Product::select('AF_product.idx', 'AF_product.name', 'AF_product.price', 'AF_product.register_time',
            'ac2.idx AS categoryIdx', 'ac2.name AS categoryName', 'AF_product.category_idx',
            DB::raw('(interest + AF_product.inquiry_count) AS popularity'),
            DB::raw('(CASE WHEN AF_product.company_type = "W" THEN (select aw.company_name from AF_wholesale as aw where aw.idx = AF_product.company_idx)
                WHEN AF_product.company_type = "R" THEN (select ar.company_name from AF_retail as ar where ar.idx = AF_product.company_idx)
                ELSE "" END) as companyName,
                (CASE WHEN AF_product.company_type = "W" THEN (select SUBSTRING_INDEX(aw.business_address, " ", 1) from AF_wholesale as aw where aw.idx = AF_product.company_idx)
                WHEN AF_product.company_type = "R" THEN (select SUBSTRING_INDEX(ar.business_address, " ", 1) from AF_retail as ar where ar.idx = AF_product.company_idx)
                ELSE "" END) as location,
                CONCAT("'.preImgUrl().'", at.folder,"/", at.filename) as imgUrl, 
                (SELECT if(count(idx) > 0, 1, 0) FROM AF_product_interest pi WHERE pi.product_idx = AF_product.idx AND pi.user_idx = '.Auth::user()->idx.') as isInterest'
            ))
            ->leftjoin('AF_attachment as at', function($query) {
                $query->on('at.idx', DB::raw('SUBSTRING_INDEX(AF_product.attachment_idx, ",", 1)'));
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
            ->leftjoin('AF_wholesale as aw', function($query){
                $query->on('aw.idx', 'AF_product.company_idx');
            })
            ->where('AF_product.is_new_product', 1)
            ->whereIn('AF_product.state', ['S', 'O']);
            
        if($params['categories'] != "") {
            $new_product->whereIN('ac2.idx', explode(",", $params['categories']));
        }

        if(isset($params['locations']) && !empty($params['locations'] != "")) {
            $location = explode(",", $params['locations']);
            $new_product->where(function ($query) use ($location) {
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

        return $new_product->orderBy($params['orderedElement'], 'desc')->paginate(8);
    }


    //도메업체 상품 상품
    //TODO: 소재지, 인기순(좋아요+올톡문의+전화문의+견적서문의) 필터적용한 조회기능으로 변경 / 현재까지 개발된 인기순 = 좋아요+올톡문의
    public function getWholesalerAddedProductList($params) {
        $new_product = Product::select('AF_product.idx', 'AF_product.name', 'AF_product.price', 'AF_product.register_time',
            'ac.idx AS categoryIdx', 'ac.name AS categoryName', 'AF_product.category_idx',
            DB::raw('(interest + AF_product.inquiry_count) AS popularity'),
            DB::raw('(CASE WHEN AF_product.company_type = "W" THEN (select aw.company_name from AF_wholesale as aw where aw.idx = AF_product.company_idx)
                WHEN AF_product.company_type = "R" THEN (select ar.company_name from AF_retail as ar where ar.idx = AF_product.company_idx)
                ELSE "" END) as companyName,
                CONCAT("'.preImgUrl().'", at.folder,"/", at.filename) as imgUrl, 
                (SELECT if(count(idx) > 0, 1, 0) FROM AF_product_interest pi WHERE pi.product_idx = AF_product.idx AND pi.user_idx = '.Auth::user()->idx.') as isInterest'
            ))
            ->leftjoin('AF_attachment as at', function($query) {
                $query->on('at.idx', DB::raw('SUBSTRING_INDEX(AF_product.attachment_idx, ",", 1)'));
            })
            ->leftjoin('AF_category as ac', function($query) {
                $query->on('ac.idx', '=', 'AF_product.category_idx');
            })
            ->leftjoin(
                DB::raw('(SELECT product_idx, COUNT(*) AS interest 
                    FROM AF_product_interest
                    GROUP BY product_idx) AS api'), function($query) {
                $query->on('AF_product.idx', '=', 'api.product_idx');
            })
            ->where('AF_product.is_new_product', 1)
            ->where('AF_product.company_idx', $params['company_idx'])
            ->whereIn('AF_product.state', ['S', 'O']);

        if($params['categories'] != "") {
            $new_product->whereIN('ac.idx', explode(",", $params['categories']));
        }

        return $new_product->orderBy($params['orderedElement'], 'desc')->paginate(8);
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

    public function getOrderList()
    {
        return Order::select('AF_order.idx', 'AF_order.product_idx', 'ap.company_idx', 'AF_order.option_json', 'AF_order.count', 'AF_order.price', 'ap.delivery_info', 'ap.name',
            DB::raw('CONCAT(at.folder,"/", at.filename) as attachment,
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


    public function listByCategory(array $param = []) {
        
        Log::debug(" * ProductService / listByCategory");
        
        $categoryIdxArr = array();

        if(isset($param['keyword'])) {
            $data['category1'] = Category::select('AF_category.*', DB::raw('CONCAT("'.preImgUrl().'", ah.folder,"/", ah.filename) as imgUrl'))
                ->where('parent_idx', null)
                ->where('is_delete', 0)
                ->leftjoin('AF_attachment as ah', function($query){
                    $query->on('ah.idx', 'AF_category.icon_attachment_idx');
                    })
                ->orderBy('order_idx', 'asc')->get();
            $data['category2'] = Category::whereNotNull('parent_idx')->where('is_delete', 0)->orderBy('order_idx', 'asc')->get();
        }

        if (isset($param['parentIdx'])) {
            $data['selCa'] = $param['categoryIdx'];
            $data['category'] = Category::select('AF_category.*',
                DB::raw('(SELECT ac2.name from AF_category as ac2 where ac2.idx = '.$param['parentIdx'].') as parentName'))
                ->where('parent_idx', $param['parentIdx'])
                ->get();

            $property = CategoryProperty::select('AF_category_property.*', 'ac2.idx as prefixIdx', 'ac2.name as prefixName');
            if ($param['categoryIdx'] != null) {
                $property->where('AF_category_property.category_idx', $param['categoryIdx']);
            } else {
                foreach ($data['category'] as $i) {
                    array_push($categoryIdxArr, $i->idx);
                }
                $property->whereIn('AF_category_property.category_idx', $categoryIdxArr);
            }
            $property->leftjoin('AF_category_property as ac2', function ($query) {
                $query->on('ac2.idx', 'AF_category_property.parent_idx');
            })
                ->where('AF_category_property.is_delete', 0)
                ->orderBy('AF_category_property.idx', 'asc');

            $data['property'] = $property->get();
        }

        $list_a = ProductAd::select('AF_product.*',
            DB::raw('(CASE WHEN AF_product.company_type = "W" THEN (select aw.company_name from AF_wholesale as aw where aw.idx = AF_product.company_idx)
                                WHEN AF_product.company_type = "R" THEN (select ar.company_name from AF_retail as ar where ar.idx = AF_product.company_idx)
                                ELSE "" END) as companyName,
                                CONCAT("'.preImgUrl().'", at.folder,"/", at.filename) as imgUrl,
                                0 as orderCnt,
                                1 as isAd,
                                AF_product_ad.price as ad_price,
                                NULL as reg_time'
                                ))
            ->where('AF_product_ad.state', 'G')
            ->where('AF_product_ad.start_date', '<', DB::raw("now()"))
            ->where('AF_product_ad.end_date', '>', DB::raw("now()"))
            ->join('AF_product', function ($query) {
                $query->on('AF_product.idx', 'AF_product_ad.product_idx');
            })
            ->whereIn('AF_product.state', ['S','O'])
            ->leftjoin('AF_attachment as at', function($query) {
                $query->on('at.idx', DB::raw('SUBSTRING_INDEX(AF_product.attachment_idx, ",", 1)'));
            });


        if (isset($param['categoryIdx'])) {
            $list_a->where('AF_product.category_idx', $param['categoryIdx'])
                ->where('AF_product_ad.ad_location', 3);

        } else if (count($categoryIdxArr) > 0) {
            $list_a->whereIn('AF_product.category_idx', $categoryIdxArr)
                ->where('AF_product_ad.ad_location', 2);
        }

        if (isset($param['keyword'])) {
            $keyword = $param['keyword'];

            $list_a->where(function ($query) use ($keyword) {
                $query->where('AF_product.name', 'like', "%{$keyword}%")
                    ->orWhere('AF_product.product_detail', 'like', "%{$keyword}%");
                    // ->orWhere('AF_product.product_option', 'like', "%{$keyword}%");
            });
            // ->orWhere(function ($query) use ($keyword) {
            //     $query->where('cp.property_name', 'like', "%{$keyword}%")
            //         ->where('AF_product.property', 'like', DB::raw("CONCAT('%', cp.idx, '%')"));
            // })
            // ->leftjoin('AF_category_property as cp', function($query) {
            //     $query->on('cp.category_idx', 'AF_product.category_idx');
            // });
            
        }
        

   
        
        $list_b = Product::select('AF_product.*',
            DB::raw('(CASE WHEN AF_product.company_type = "W" THEN (select aw.company_name from AF_wholesale as aw where aw.idx = AF_product.company_idx)
                                WHEN AF_product.company_type = "R" THEN (select ar.company_name from AF_retail as ar where ar.idx = AF_product.company_idx)
                                ELSE "" END) as companyName,
                                CONCAT("'.preImgUrl().'", at.folder,"/", at.filename) as imgUrl,
                                (SELECT COUNT(*) cnt FROM AF_order as ao WHERE ao.product_idx = AF_product.idx) as orderCnt,
                                0 as isAd,
                                0 as ad_price,
                                AF_product.register_time as reg_time
                                '))
            ->whereIn('AF_product.state', ['S', 'O'])
            ->leftjoin('AF_attachment as at', function($query) {
                $query->on('at.idx', DB::raw('SUBSTRING_INDEX(AF_product.attachment_idx, ",", 1)'));
            });

        if (isset($param['categoryIdx'])) {
            $list_b->where('AF_product.category_idx', $param['categoryIdx']);
        } else if (count($categoryIdxArr) > 0) {
            $list_b->whereIn('AF_product.category_idx', $categoryIdxArr);
        }

        if (isset($param['keyword'])) {
            $keyword = $param['keyword'];

            $list_b->where(function ($query) use ($keyword) {
                $query->where('AF_product.name', 'like', "%{$keyword}%")
                    ->orWhere('AF_product.product_detail', 'like', "%{$keyword}%");
                    // ->orWhere('AF_product.product_option', 'like', "%{$keyword}%");
            });
            // ->orWhere(function ($query) use ($keyword) {
            //     $query->where('cp.property_name', 'like', "%{$keyword}%")
            //         ->where('AF_product.property', 'like', DB::raw("CONCAT('%', cp.idx, '%')"));
            // })
            // ->leftjoin('AF_category_property as cp', function($query) {
            //     $query->on('cp.category_idx', 'AF_product.category_idx');
            // });
            
        }
        

        if (isset($param['property'])) {
            $props = explode('|', $param['property']);
            $list_b->where(function ($query) use ($props) {
                foreach ($props as $key => $prop) {
                    // $clause = $key == 0 ? 'where' : 'orWhere';
                    $clause = 'where';
                    $query->$clause('AF_product.property', 'like', "%{$prop}%");
                    if (!empty($relativeTables)) {
                        $this->filterByRelationship($query, 'AF_product.property',
                            $relativeTables);
                    }
                }
            });
        }

        $list = $list_a->union($list_b)->orderBy('isAd', 'desc')->orderBy('ad_price', 'desc'); 

        if (isset($param['sort'])) {
            
            switch($param['sort']) {
                case 'order':
                    $list->orderBy('orderCnt', 'desc');
                    break;
                case 'search':
                    $list->orderBy('access_count', 'desc');
                    break;
                default:
                    $list->orderBy('reg_time', 'desc');
                    break;
            }
        } else {
            $list->orderBy('reg_time', 'desc');
        }
        
        $list->inRandomOrder();

        Log::debug("---------------------------------------");
        $data['list'] = $list->distinct()->paginate(32);
        Log::debug("---------------------------------------");
        
        return $data;
    }

    public function countSearchWholesales(string $keyword)
    {
        return CompanyWholesale::select('AF_wholesale.idx')
            ->leftjoin('AF_product as ap', function ($query) {
                $query->on('AF_wholesale.idx', 'ap.company_idx')
                    ->where('ap.company_type', 'W')
                    ->whereIn('ap.state', ['S', 'O']);
            })
            ->where(function($query) use($keyword) {
                $query->where('AF_wholesale.company_name','like',"%{$keyword}%")
                    ->orWhere('AF_wholesale.owner_name','like',"%{$keyword}%");
            })
            ->groupBy('AF_wholesale.idx')
            ->orderBy('ap.idx', 'desc')
            ->orderBy('AF_wholesale.idx', 'desc')
            ->count();
    }

    // 최근 상품 등록 업체
    public function getRecentlyAddedProductCompanyList()
    {
        $wholesaleCompany = CompanyWholesale::select('AF_wholesale.idx', 'AF_wholesale.company_name', 'prodcut.MAX(register_time)')
            ->join(DB::raw('
                    (SELECT company_idx, MAX(register_time),COUNT(idx) 
                    FROM AF_product
                    WHERE company_type = \'W\' AND state IN (\'S\', \'O\') AND access_date IS NOT NULL
                    GROUP BY company_idx
                    HAVING COUNT(idx) >= 3) AS prodcut'), function($query) {
                $query->on('prodcut.company_idx', 'AF_wholesale.idx');
            })
        ->groupBy('idx');

        
        $retailCompany = CompanyRetail::select('AF_retail.idx', 'AF_retail.company_name', 'prodcut.MAX(register_time)')
                ->join(DB::raw('
                        (SELECT company_idx, MAX(register_time), COUNT(idx) 
                        FROM AF_product
                        WHERE company_type = \'R\' AND state IN (\'S\', \'O\') AND access_date IS NOT NULL
                        GROUP BY company_idx
                        HAVING COUNT(idx) >= 3) AS prodcut'), function($query) {
                    $query->on('prodcut.company_idx', 'AF_retail.idx');
                })
            ->groupBy('idx');

        $company = $wholesaleCompany
                ->union($retailCompany)
                ->orderby('MAX(register_time)', 'desc')
                ->limit(10)
                ->get();

        foreach($company as $key => $item) {

            $category = Product::select(DB::raw('GROUP_CONCAT( DISTINCT (ac2.name)) as categoryList'))
            ->where('AF_product.company_idx', $item->idx)
            ->whereIn('AF_product.state', ['S','O'])
            ->whereNotNull('access_date')
            ->orderBy('AF_product.register_time', 'desc');

            $category->join('AF_category AS ac', function ($query) {
                $query->on('ac.idx', 'AF_product.category_idx');
            });

            $category->join('AF_category AS ac2', function ($query) {
                $query->on('ac2.idx', 'ac.parent_idx');
            });

            $company[$key]['categoryList'] = $category -> get()[0] -> categoryList;
        }

        return $company;
    }

    public function listBySearch(array $param = [])
    {
        $data['categoryList'] = Category::orderBy('asc')->get();

        $data['property'] = CategoryProperty::select('AF_category_property.*', 'ac2.name as parent_name')
            ->where('category_idx', $param['categoryIdx'])
            ->leftjoin('AF_category_property as ac2', function ($query) {
                $query->on('ac2.idx', 'AF_category_property.parent_idx');
            })
            ->orderBy('ac2.idx', 'desc')
            ->get();

        $list = Product::select('AF_product.idx', 'AF_product.name', 'AF_product.price',
            DB::raw('(CASE WHEN AF_product.company_type = "W" THEN (select aw.company_name from AF_wholesale as aw where aw.idx = AF_product.company_idx)
                                WHEN AF_product.company_type = "R" THEN (select ar.company_name from AF_retail as ar where ar.idx = AF_product.company_idx)
                                ELSE "" END) as companyName,
                                CONCAT("'.preImgUrl().'", at.folder,"/", at.filename) as imgUrl'))
            ->leftjoin('AF_attachment as at', function($query) {
                $query->on('at.idx', DB::raw('SUBSTRING_INDEX(AF_product.attachment_idx, ",", 1)'));
            })
            ->join('AF_category as ac', function ($query) {
                $query->on('ac.idx', 'AF_product.category_idx');
            })
            ->join('AF_category as ac2', function ($query) {
                $query->on('ac2.idx', 'ac.parent_idx');
            })
            ->join('AF_category_property as acp', function ($query) {
                $query->on('acp.category_idx', 'acp.category_idx');
            });

        if (isset($param['property'])) {
            $props = explode('|', $param['property']);
            $list->where(function ($query) use ($props) {
                foreach ($props as $key => $prop) {
                    $clause = $key == 0 ? 'where' : 'orWhere';
                    $query->$clause('AF_product.property', 'REGEXP', $prop);
                    if (!empty($relativeTables)) {
                        $this->filterByRelationship($query, 'AF_product.property',
                            $relativeTables);
                    }
                }
            });
        }

        $list->where('AF_product.category_idx', $param['categoryIdx'])
            ->whereIn('AF_product.state', ['S', 'O'])
            ->orderby('AF_product.access_date', 'desc');

        $data['list'] = $list->paginate(20);

        return view('category.index', [
            'data'=>$data
        ]);
    }



    public function thisMonth() {
        
        $ret = MonthWholesaleSetting::select('first', 'second', 'banner', 'keyword')->first();
        
        $product_4_limit = $ret->first;
        $product_6_limit = $ret->second;
        $banner_limit = $ret->banner;
        $keyword_limit = $ret->keyword;
        
        $data['product_4'] = ProductAd::select('AF_product_ad.*', 'ap.name', 'ap.idx as idx', 'ap.company_idx',
        DB::raw('CONCAT("'.preImgUrl().'", at.folder,"/", at.filename) as imgUrl,
            (CASE WHEN ap.company_type = "W" THEN (select aw.company_name from AF_wholesale as aw where aw.idx = ap.company_idx)
                    WHEN ap.company_type = "R" THEN (select ar.company_name from AF_retail as ar where ar.idx = ap.company_idx)
                    ELSE "" END) as companyName'
        ))
            ->leftjoin('AF_product as ap', function ($query) {
                $query->on('ap.idx', 'AF_product_ad.product_idx');
            })
            ->leftjoin('AF_attachment as at', function($query) {
                $query->on('at.idx', DB::raw('SUBSTRING_INDEX(ap.attachment_idx, ",", 1)'));
            })
            ->where('AF_product_ad.state', 'G')
            ->where('AF_product_ad.is_delete', 0)
            ->where('AF_product_ad.is_open', 1)
            ->where('AF_product_ad.start_date', '<=', DB::raw('now()'))
            ->where('AF_product_ad.end_date', '>=', DB::raw('now()'))
            ->groupBy('ap.company_idx')
            ->orderByRaw('AF_product_ad.price desc, RAND()')
            ->limit($product_4_limit)
            ->get();

        $idxList = [];
        foreach($data['product_4'] as $item) {
            array_push($idxList, $item->idx);
        }
        
        $data['product_6'] = ProductAd::select('AF_product_ad.*', 'ap.name', 'ap.idx as idx', 'ap.company_idx',
            DB::raw('CONCAT("'.preImgUrl().'", at.folder,"/", at.filename) as imgUrl,
            (CASE WHEN ap.company_type = "W" THEN (select aw.company_name from AF_wholesale as aw where aw.idx = ap.company_idx)
                    WHEN ap.company_type = "R" THEN (select ar.company_name from AF_retail as ar where ar.idx = ap.company_idx)
                    ELSE "" END) as companyName'
            ))
            ->join('AF_product as ap', function ($query) use($idxList){
                $query->on('ap.idx', 'AF_product_ad.product_idx')
                    ->whereNotIn('ap.idx', $idxList);
            })
            ->leftjoin('AF_attachment as at', function($query) {
                $query->on('at.idx', DB::raw('SUBSTRING_INDEX(ap.attachment_idx, ",", 1)'));
            })
            ->where('AF_product_ad.state', 'G')
            ->where('AF_product_ad.is_delete', 0)
            ->where('AF_product_ad.is_open', 1)
            ->where('AF_product_ad.start_date', '<=', DB::raw('now()'))
            ->where('AF_product_ad.end_date', '>=', DB::raw('now()'))
            ->groupBy('ap.company_idx')
            ->orderByRaw('AF_product_ad.price desc, RAND()')
            ->limit($product_6_limit)
            ->get();
            
        $data['banner'] = Banner::where('state', 'G')
            ->whereRaw('banner_price in (
            select max(banner_price) from AF_banner_ad group by company_idx
            ) and is_open = 1 and is_delete = 0 and start_date < now() and end_date > now()')
            ->groupBy('company_idx')
            ->orderByRaw('banner_price desc, RAND()')
            ->limit($banner_limit)
            ->get();
            
        $data['keyword'] = KeywordAd::where('state', 'G')
            ->whereRaw('price in (
            select max(price) from AF_keyword_ad group by company_idx
            ) and is_open = 1 and is_delete = 0 and start_date < now() and end_date > now()')
            ->groupBy('company_idx')
            ->orderByRaw('price desc, RAND()')
            ->limit($keyword_limit)                
            ->get();

        return $data;
            
        /*return view('product.thisMonth', [
            'data'=>$data
        ]);*/
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

    public function makeProductNum($code, $length)
    {
        $check = 1;
        $string_generated = "";

        $parentCode = Category::select(DB::raw('CONCAT(ac2.code, AF_category.code) as code'))
            ->where('AF_category.idx', $code)
            ->leftjoin('AF_category as ac2', function ($query) {
                $query->on('ac2.idx', 'AF_category.parent_idx');
            })
            ->first();

        $code = $parentCode->code.$code;

        while ($check != 0) {
            $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

            $nmr_loops = $length;
            while ($nmr_loops--)
            {
                $string_generated .= $characters[mt_rand(0, strlen($characters) - 1)];
            }

            $check = Product::where('product_number', $code.$string_generated)->count();
        }

        return $code.$string_generated;
    }

    // 도매업체 > 이달의 도매 ( kr.kevin.kang 2024.03.22 )
    public function getThisMonth(array $param = [])
    {
        $data = ProductAd::select('AF_product_ad.*', 'ap.name', 'ap.idx as idx', 'ap.company_idx', 'ac.name AS category_name',
            DB::raw('CONCAT("'.preImgUrl().'", at.folder,"/", at.filename) as imgUrl,
            (CASE WHEN ap.company_type = "W" THEN (select aw.company_name from AF_wholesale as aw where aw.idx = ap.company_idx)
                    WHEN ap.company_type = "R" THEN (select ar.company_name from AF_retail as ar where ar.idx = ap.company_idx)
                    ELSE "" END) as companyName,
            (CASE WHEN ap.company_type = "W" THEN (select aw.inquiry_count from AF_wholesale as aw where aw.idx = ap.company_idx)
			        WHEN ap.company_type = "R" THEN (select ar.inquiry_count from AF_retail as ar where ar.idx = ap.company_idx)
			        ELSE "" END) as inquiry_count,
	        (CASE WHEN (SELECT ROUND( SUM(banner_price)/100000 ) * 100000 FROM AF_banner_ad WHERE company_idx=	ap.company_idx) > 300000 THEN 300000 * 0.0001
		            ELSE (SELECT ( ROUND( SUM(banner_price)/100000 ) * 100000 ) * 0.0001 FROM AF_banner_ad WHERE company_idx=	ap.company_idx)
		            END) AS banner_price,
            (CASE WHEN ap.company_type = "W" THEN (select LEFT( aw.business_address, 2 ) from AF_wholesale as aw where aw.idx = ap.company_idx)
			        WHEN ap.company_type = "R" THEN (select LEFT( ar.business_address, 2 ) from AF_retail as ar where ar.idx = ap.company_idx)
			        ELSE "" END) as companyRegion'
            ))
            ->leftjoin('AF_product as ap', function ($query) {
                $query->on('ap.idx', 'AF_product_ad.product_idx');
            })
            ->leftjoin('AF_attachment as at', function($query) {
                $query->on('at.idx', DB::raw('SUBSTRING_INDEX(ap.attachment_idx, ",", 1)'));
            })
            ->leftjoin('AF_category as ac', function($query) {
                $query->on('ac.idx', 'ap.category_idx');
            })
            ->where('AF_product_ad.state', 'G')
            ->where('AF_product_ad.is_delete', 0)
            ->where('AF_product_ad.is_open', 1)
            ->where('AF_product_ad.start_date', '<=', DB::raw('now()'))
            ->where('AF_product_ad.end_date', '>=', DB::raw('now()'))
            //->groupBy('ap.company_idx')
            ->orderByRaw('banner_price DESC')
            ->orderByRaw('AF_product_ad.price desc, RAND()')
            ->limit(50)
            ->get();

        return $data;
    }


}
