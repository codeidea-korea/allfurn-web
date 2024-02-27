<?php


namespace App\Service;


use App\Models\Article;
use App\Models\CategoryHistory;
use App\Models\Popup;
use App\Models\Banner;
use App\Models\KeywordAd;
use App\Models\Product;
use App\Models\ProductAd;
use App\Models\Push;
use App\Models\UserSearch;
use App\Models\Cart;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\FacadesAuth;
use Illuminate\Support\FacadesDB;
use Illuminate\Support\FacadesStorage;

class HomeService
{
    /**
     * 홈페이지 데이터 가져오기
     * @return
     */
    public function getHomeData()
    {
        // 배너 상단
        $banner_top = Banner::select('AF_banner_ad.company_idx', 'AF_banner_ad.company_type', 'AF_banner_ad.web_link_type', 'AF_banner_ad.web_link', 'ac.folder', 'ac.filename')
            ->where('ad_location', 'alltop')
            ->join('AF_attachment as ac', function ($query) {
                $query->on('ac.idx', 'AF_banner_ad.web_attachment_idx');
            })
            ->where('start_date', '<', DB::raw('now()'))
            ->where('end_date', '>', DB::raw('now()'))
            ->where('state', 'G')
            ->where('is_delete', 0)
            ->where('is_open', 1)
            ->orderByRaw('banner_price desc, RAND()')
            ->limit(20)
            ->get();

        foreach ($banner_top as $key => $value) {
            if ($value->company_type == 'W') {
                $company = DB::table('AF_wholesale')->select('company_name')->where('idx', $value->company_idx)->first();
                if (is_null($company->company_name)){ $value->company_name = ''; } else { $value->company_name = $company->company_name; }
            } else if ($value->company_type == 'R') {
                $company = DB::table('AF_retail')->select('idx', 'company_name')->where('idx', $value->company_idx)->first();
                if (is_null($company->company_name)){ $value->company_name = ''; } else { $value->company_name = $company->company_name; }
            }else{
                $company = DB::table('AF_normal')->select('name')->where('idx', $value->company_idx)->first();
                if (is_null($company->name)){ $value->company_name = ''; } else { $value->company_name = $company->name; }
            }
        }
        
        $data['banner_top'] = $banner_top;


        // 상위 카테고리 목록
        $data['categoryAlist'] = Category::select('AF_category.idx', 'AF_category.name', DB::raw('CONCAT("'.preImgUrl().'", aat.folder, "/", aat.filename) AS imgUrl'))
            ->where('parent_idx', null)->where('is_delete', 0)
            ->leftjoin('AF_attachment as aat', function($query) {
                $query->on('aat.idx', '=', 'AF_category.icon_attachment_idx');
            })
            ->orderBy('AF_category.order_idx', 'asc')->get();


        // 베스트 신상품 목록
        $data['productAd'] = ProductAd::select('AF_product.*',
            DB::raw('AF_product_ad.price as ad_price, 
                (CASE WHEN AF_product.company_type = "W" THEN (select aw.company_name from AF_wholesale as aw where aw.idx = AF_product.company_idx)
                WHEN AF_product.company_type = "R" THEN (select ar.company_name from AF_retail as ar where ar.idx = AF_product.company_idx)
                ELSE "" END) as companyName,
                CONCAT("'.preImgUrl().'", at.folder,"/", at.filename) as imgUrl'))
            ->join('AF_product', function ($query) {
                $query->on('AF_product.idx', 'AF_product_ad.product_idx')
                    ->whereIn('AF_product.state', ['S', 'O']);
            })
            ->leftjoin('AF_attachment as at', function($query) {
                $query->on('at.idx', DB::raw('SUBSTRING_INDEX(AF_product.attachment_idx, ",", 1)'));
            })
            //->where('AF_product_ad.state', 'G')
            //->where('AF_product_ad.start_date', '<', DB::raw("now()"))
            //->where('AF_product_ad.end_date', '>', DB::raw("now()"))
            //->where('AF_product_ad.ad_location', 1)
            ->where('AF_product_ad.is_delete', 0)
            ->where('AF_product_ad.is_open', 1)
            ->orderby('ad_price', 'desc')->inRandomOrder()->get();
       

        // 신상품 랜덤 8개
        $data['new_product'] = Product::select('AF_product.*',
            DB::raw('(CASE WHEN AF_product.company_type = "W" THEN (select aw.company_name from AF_wholesale as aw where aw.idx = AF_product.company_idx)
                                WHEN AF_product.company_type = "R" THEN (select ar.company_name from AF_retail as ar where ar.idx = AF_product.company_idx)
                                ELSE "" END) as companyName,
                                CONCAT("'.preImgUrl().'", at.folder,"/", at.filename) as imgUrl'))
            ->leftjoin('AF_attachment as at', function($query) {
                $query->on('at.idx', DB::raw('SUBSTRING_INDEX(AF_product.attachment_idx, ",", 1)'));
            })
            ->where([
                'AF_product.is_showroom_item' => 1,
                'AF_product.state' => 'S'
            ])
            ->inRandomOrder()
            ->limit(16)
            ->get();

        // 커뮤니티 인기글
        $data['community'] = Article::select('AF_board_article.*', 'ab.name',
            DB::raw('(SELECT CASE WHEN COUNT(*) > 999 THEN "999+" ELSE COUNT(*) END cnt FROM AF_reply WHERE article_idx = AF_board_article.idx AND is_delete = 0) as replyCnt,
            (SELECT COUNT(*) cnt FROM AF_board_views WHERE article_idx = AF_board_article.idx) as viewCnt'))
            ->join('AF_board as ab', function ($query) {
                $query->on('ab.idx', 'AF_board_article.board_idx')->where('ab.is_business', 0);
            })
//            ->where('AF_board_article.is_admin', 0)
            ->where('AF_board_article.is_delete', 0)
            ->orderBy('viewCnt', 'desc')
            ->limit(5)
            ->get();

        // 비즈니스 최신글
        $data['business'] = Article::select('AF_board_article.*', 'ab.name',
        DB::raw('(SELECT CASE WHEN COUNT(*) > 999 THEN "999+" ELSE COUNT(*) END cnt FROM AF_reply WHERE article_idx = AF_board_article.idx AND is_delete = 0) as replyCnt'))
            ->join('AF_board as ab', function ($query) {
                $query->on('ab.idx', 'AF_board_article.board_idx')->where('ab.is_business', 1);
            })
            ->where('AF_board_article.is_admin', 0)
            ->where('AF_board_article.is_delete', 0)
            ->orderBy('AF_board_article.update_time', 'desc')
            ->limit(5)
            ->get();

        $data['banner_bottom'] = Banner::where('ad_location', 'allbottom')
            ->where('start_date', '<', DB::raw('now()'))
            ->where('end_date', '>', DB::raw('now()'))
            ->where('state', 'G')
            ->where('is_delete', 0)
            ->where('is_open', 1)
            ->orderByRaw('banner_price desc, RAND()')
            ->limit(20)
            ->get();

        $data['popup'] = Popup::select('AF_popup.*',
            DB::raw('CONCAT("'.preImgUrl().'", at.folder, "/", at.filename) as imgUrl'))
            ->leftjoin('AF_attachment as at', function ($query) {
                $query->on('at.idx', 'AF_popup.attachment_idx');
            })
            ->where(['type' => 'B', 'location' => 'home'])
            ->where('start_date', '<', DB::raw('now()'))
            ->where('end_date', '>', DB::raw('now()'))
            ->where('is_delete', 0)
            ->get();

        return $data;
    }

    public function getNewProduct()
    {
        // 신상품 랜덤 8개
        $newProduct = Product::select('AF_product.idx', 'AF_product.name', 'AF_product.price',
            DB::raw('(CASE WHEN AF_product.company_type = "W" THEN (select aw.company_name from AF_wholesale as aw where aw.idx = AF_product.company_idx)
                                WHEN AF_product.company_type = "R" THEN (select ar.company_name from AF_retail as ar where ar.idx = AF_product.company_idx)
                                ELSE "" END) as companyName,
                                CONCAT("'.preImgUrl().'", at.folder,"/", at.filename) as imgUrl'))
            ->leftjoin('AF_attachment as at', function($query) {
                $query->on('at.idx', DB::raw('SUBSTRING_INDEX(AF_product.attachment_idx, ",", 1)'));
            })
            ->where([
                'AF_product.is_new_product' => 1,
                'AF_product.state' => 'S'
            ])
            ->inRandomOrder()
            ->limit(8)
            ->get();

        return response()->json([
            'list'=> $newProduct
        ]);
    }


    /**
     * 키워드 검색 리스트 가져오기
     * @return
     */
    public function getSearchData() {
        
        if (Auth::check()) {
            // 키워드 검색 리스트 가져오기

            $data['keywords'] = UserSearch::where('user_idx', Auth::user()['idx'])
                ->where('type', 'S')
                ->orderBy('register_time','desc')
                ->limit(5)
                ->get();
            
            
            $oneHourAgo= date('Y-m-d H:i:s', strtotime('-1 hour'));

            $data['category'] = CategoryHistory::select('AF_user_category_history.category_idx as categoryIdx', 'ac.name as categoryName', 'ac.parent_idx as parentIdx',
                DB::raw('COUNT(AF_user_category_history.category_idx) cnt,
                 (SELECT ac2.name FROM AF_category as ac2 WHERE ac2.idx = ac.parent_idx) as parentName'))
                ->where('AF_user_category_history.category_idx', '>', 14)
                ->where('AF_user_category_history.register_time', '>=', $oneHourAgo)    
                ->groupBy('AF_user_category_history.category_idx')
                ->leftjoin('AF_category as ac', function ($query) {
                    $query->on('ac.idx', 'AF_user_category_history.category_idx');
                })
                ->orderBy('cnt', 'desc')
                ->limit(5)
                ->get();

            $data['ad_keyword'] = KeywordAd::where('start_date', '<', DB::raw('now()'))
                ->where('end_date', '>', DB::raw('now()'))
                ->where('state', 'G')
                ->where('is_delete', 0)
                ->orderBy('price', 'desc')
                ->inRandomOrder()
                ->get();

            $data['banner'] = Banner::where('ad_location', 'searchbottom')
                ->where('start_date', '<', DB::raw('now()'))
                ->where('end_date', '>', DB::raw('now()'))
                ->where('state', 'G')
                ->where('is_delete', 0)
                ->where('is_open', 1)
                ->leftJoin('AF_attachment', function($query) {
                    $query->on('AF_attachment.idx', 'AF_banner_ad.web_attachment_idx');
                })
                ->get();

            return $data;
        }

    }

    /**
     * 키워드 검색 - 같은 키워드 검색 시 기존에 검색된 키워드를 삭제하고 최근 검색어로 저장
     * @param string $keyword
     */
    public function putSearchKeyword(string $keyword)
    {
        if (Auth::check()) {
            $idx = Auth::user()['idx'];
            $duplicateSearchKeyword = UserSearch::where('user_idx', $idx)
                ->where('type','S')->where('keyword', $keyword)->first();
            // 중복된 키워드 삭제
            if (isset($duplicateSearchKeyword['idx'])) {
                $this->deleteSearchKeyword($duplicateSearchKeyword['idx']);
            }
            // 검색 키워드 저장
            $userSearch = new UserSearch;
            $userSearch->user_idx = $idx;
            $userSearch->type = 'S';
            $userSearch->keyword = $keyword;
            $userSearch->save();
        }
    }

    /**
     * 키워드 검색어 삭제
     * @param string $idx 키워드 검색의 고유키
     */
    public function deleteSearchKeyword(string $idx)
    {
        if (!Auth::check()) {
            return null;
        }

        if ($idx == 'all') {
            return UserSearch::where('user_idx', Auth::user()['idx'])->where('type','S')->delete();
        } else {
            return UserSearch::where(['idx'=>(int)$idx, 'user_idx'=>Auth::user()['idx']])->delete();
        }
    }

    /**
     * 게시물 이미지 업로드
     * @param $image
     * @return string
     */
    public function uploadImage($image): string
    {
        $stored = Storage::put('public/articles', $image);
        $explodeFileName = explode('/',$stored);
        $fileName = end($explodeFileName);
        return asset("storage/articles/{$fileName}");
    }

    /**
     * 이미지 삭제
     * @param $imageUrl
     * @return array
     */
    public function deleteImage($imageUrl): array
    {
        $imgPath = $imageUrl.str_replace(env.AWS_S3_URL, '');
        Storage::disk('s3')->delete($imgPath);

        return [
            'result' => 'success',
            'message' => ''
        ];
    }

    /**
     * 게시글 삭제
     * @param $idx
     * @return array
     */
    public function removeArticle($idx): array
    {
        if (Auth::check()) {
            $article = Article::where('idx', $idx)->where('user_idx', Auth::user()['idx'])->first();
            $article->is_open = 0;
            $article->is_delete = 1;
            $article->update_time = Carbon::now()->format('Y-m-d H:i:s');
            $article->save();
        }
        return [
            'result' => 'success',
            'message' => ''
        ];
    }

    public function checkAlert()
    {
        if(Auth::check()) {
            $cartCnt = Cart::where([
                'user_idx'=>Auth::user()->idx,
                'is_alert'=>1
                ])
                ->count();

            $alarmCnt = Push::where([
                'AF_notification.target_company_type' => Auth::user()['type'],
                'AF_notification.target_company_idx' => Auth::user()['company_idx'],
                'is_alert' => 1
                ])
                ->count();

            return response()->json([
               'success'=>true,
               'cart'=>$cartCnt,
               'alarm'=>$alarmCnt
            ]);
        } else {
            return response()->json([
                'success'=>false
            ]);
        }
    }
}
