<?php


namespace App\Service;


use App\Models\Banner;
use App\Models\Magazine;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MagazineService
{
    /**
     * 매거진 리스트 가져오기
     * @param $params
     * @return array
     */
    public function list($params): array
    {
        $query = Magazine::where(function($query) {
                $query->where('is_date', 0);
                $query->orWhere(function($query2) {
                    $nowDate = Carbon::now()->format('Y-m-d');
                    $query2->where('is_date', 1)
                        ->where('start_date', '<=', $nowDate)
                        ->where('end_date', '>=', $nowDate);
                });
            })
            ->where('is_delete', 0)
            ->where('is_open', 1)
            ->leftJoin('AF_attachment', 'AF_attachment.idx', 'AF_magazine.attachment_idx')
            ->select('AF_magazine.*'
                , DB::raw("DATE_FORMAT(AF_magazine.start_date, '%Y.%m.%d') AS start_date")
                , DB::raw("DATE_FORMAT(AF_magazine.end_date, '%Y.%m.%d') AS end_date")
                , DB::raw('CONCAT("'.preImgUrl().'", AF_attachment.folder, "/", AF_attachment.filename) as image_url'));

        $data['count'] = $query->count();
        $list = $query->orderBy('AF_magazine.idx', 'desc');

        if(isset($params['offset']) && isset($params['limit'])) {
            $offset = $params['offset'] > 1 ? ($params['offset']-1) * $params['limit'] : 0;
            $limit = $params['limit'];

            $list = $list->offset($offset)->limit($limit);
        }

        $list = $list->get();

        $data['list'] = $list;
        if(isset($params['offset']) && isset($params['limit'])) {
            $data['pagination'] = paginate($params['offset'], $params['limit'], $data['count']);
        }
        return $data;
    }

    /**
     * 매거진 상세 가져오기
     * @param $idx
     * @return mixed
     */
    public function detail($idx)
    {
        Magazine::where('idx', $idx)->increment('hit');
        
        return Magazine::where('AF_magazine.idx', $idx)
            ->leftJoin('AF_attachment', 'AF_attachment.idx', 'AF_magazine.attachment_idx')
            ->select('AF_magazine.*'
                , DB::raw("DATE_FORMAT(AF_magazine.start_date, '%Y.%m.%d') AS start_date")
                , DB::raw("DATE_FORMAT(AF_magazine.end_date, '%Y.%m.%d') AS end_date")
                , DB::raw('CONCAT("'.preImgUrl().'", AF_attachment.folder, "/", AF_attachment.filename) as image_url'))
            ->first();
    }

    /**
     * 매거진 배너 리스트 가져오기
     * @return mixed
     */
    public function banners()
    {
        $nowDate = Carbon::now()->format('Y-m-d H:i:s');
        return Banner::where('ad_location', 'magazinetop')
            ->where('start_date', '<=', $nowDate)
            ->where('end_date', '>=', $nowDate)
            ->where('state', 'G')
            ->where('is_delete', 0)
            ->where('is_open', 1)
            ->leftJoin('AF_attachment', 'AF_attachment.idx', 'AF_banner_ad.web_attachment_idx')
            ->select('AF_banner_ad.*'
                , DB::raw('CONCAT("'.preImgUrl().'", AF_attachment.folder, "/", AF_attachment.filename) as image_url'))
            ->get();
    }
}
