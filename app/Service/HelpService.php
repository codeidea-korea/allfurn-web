<?php


namespace App\Service;


use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Inquiry;
use App\Models\InquiryCategory;
use App\Models\Notice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HelpService
{
    /**
     * FAQ 카테고리 가져오기
     * @return mixed
     */
    public function getFaqCategories()
    {
        return FaqCategory::where('is_delete', 0)->orderBy('order_idx')->get();
    }

    /**
     * FAQ 리스트 가져오기
     * @param $params
     * @return array
     */
    public function getFaqList($params): array
    {
        $offset = $params['offset'] > 1 ? ($params['offset']-1) * $params['limit'] : 0;
        $limit = $params['limit'];

        $query = Faq::where('is_open', 1);
        if (isset($params['category_idx']) && !empty($params['category_idx'])) {
            $query->where('category_idx', $params['category_idx']);
        }

        $data['count'] = $query->count();
        $list = $query->offset($offset)->limit($limit)->get();
        $data['list'] = $list;
        $data['pagination'] = paginate($params['offset'], $params['limit'], $data['count']);
        return $data;
    }

    /**
     * 공지사항 리스트 가져오기
     * @param $params
     * @return array
     */
    public function getNoticeList($params): array
    {
        $offset = $params['offset'] > 1 ? ($params['offset']-1) * $params['limit'] : 0;
        $limit = $params['limit'];

        $query = Notice::where('is_open', 1)->where('is_delete', 0);

        $data['count'] = $query->count();
        $list = $query->orderBy('idx', 'desc')->offset($offset)->limit($limit)->get();
        $data['list'] = $list;
        $data['pagination'] = paginate($params['offset'], $params['limit'], $data['count']);
        return $data;
    }

    /**
     * 이용 가이드 리스트 가져오기
     * @param $params
     * @return array
     */
    public function getGuideList($params): array
    {
        $offset = $params['offset'] > 1 ? ($params['offset']-1) * $params['limit'] : 0;
        $limit = $params['limit'];

        $query = DB::table('AF_guide')->where('is_open', 1)->where('is_delete', 0);

        $data['count'] = $query->count();
        $list = $query->orderBy('idx', 'desc')->offset($offset)->limit($limit)->get();
        $data['list'] = $list;
        $data['pagination'] = paginate($params['offset'], $params['limit'], $data['count']);
        return $data;
    }

    /**
     * 1:1 문의 리스트 가져오기
     * @param $params
     * @return array
     */
    public function getInquiries($params): array
    {
        $offset = $params['offset'] > 1 ? ($params['offset']-1) * $params['limit'] : 0;
        $limit = $params['limit'];

        $query = Inquiry::where('is_delete', 0)
            ->where('user_idx', Auth::user()['idx'])
            ->has('category');

        $data['count'] = $query->count();
        $list = $query->offset($offset)->limit($limit)->get();
        $data['list'] = $list;
        $data['pagination'] = paginate($params['offset'], $params['limit'], $data['count']);
        return $data;
    }

    public function getInquiryDetail($idx) {
        
        $query = Inquiry::where('AF_inquiry.is_delete', 0)
            ->where('user_idx', Auth::user()['idx'])
            ->where('AF_inquiry.idx', $idx)
            ->has('category')
            ->select('AF_inquiry.*', 'AF_inquiry_category.name')
            ->join('AF_inquiry_category','AF_inquiry_category.idx', 'AF_inquiry.category_idx')
            ->first();
        
        return $query;
    }

    /**
     * 1:1문의 카테고리 가져오기
     * @return mixed
     */
    public function getInquiryCategories()
    {
        return InquiryCategory::where('is_delete', 0)->get();
    }

    /**
     * 1:1 문의 등록하기
     * @param array $params
     * @return array
     */
    public function registerInquiry(array $params): array
    {
        $category = $params['inquiry_category'];
        $title = $params['inquiry_title'];
        $content = $params['inquiry_content'];
        $category = InquiryCategory::where('name', $category)->first();
        if (isset($params['inquiry_idx'])) {
            $inquiry = Inquiry::find($params['inquiry_idx']);
        } else {
            $inquiry = new Inquiry();
        }
        $inquiry->category_idx = $category->idx;
        $inquiry->user_idx = Auth::user()['idx'];
        $inquiry->title = $title;
        $inquiry->content = $content;
        $inquiry->state = 0;
        $inquiry->is_delete = 0;
        $inquiry->save();
        return [
            'result' => 'success',
            'message' => '',
        ];
    }

    /**
     * 등록한 1:1 문의 내용 가져오기
     * @param $idx
     * @return mixed
     */
    public function getSavedInquiry($idx)
    {
        return Inquiry::where('AF_inquiry.idx', $idx)->join('AF_inquiry_category','AF_inquiry_category.idx', 'AF_inquiry.category_idx')
            ->select('AF_inquiry.*', 'AF_inquiry_category.name')
            ->first();
    }

    /**
     * 1:1 문의 취소
     * @param int $idx
     * @return string[]
     */
    public function removeInquiry(int $idx): array
    {
        $inquiry = Inquiry::find($idx);
        $inquiry->is_delete = 1;
        $inquiry->save();
        return [
            'result' => 'success',
            'message' => ''
        ];
    }

  // 수정자와 작성자가 동일한지 체크
    function isInquiryOfUser($idx) {
        return Inquiry::select(
                DB::raw("CASE WHEN user_idx = ". Auth::user()['idx'] ." THEN true ELSE false END AS is_equl")
            )
            ->where('idx', $idx)
            ->first()
            ->is_equl;
    }

    // 삭제된 문의인지 확인
    function isDeleted($idx) {
        return Inquiry::select(
                DB::raw("CASE WHEN is_delete = 1 THEN true ELSE false END AS is_delete")
            )
            ->where('idx', $idx)
            ->first()
            ->is_delete;
    }
}
