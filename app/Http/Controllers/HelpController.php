<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Service\HelpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HelpController extends BaseController
{
    private $helpService;
    private $limit = 10;
    public function __construct(HelpService $helpService)
    {
        $this->helpService = $helpService;
    }

    public function index(): RedirectResponse
    {
        return redirect()->route('help.guide');
    }

    /**
     * 자주 묻는 질문 리스트
     * @param Request $request
     * @return View
     */
    public function faq(Request $request): View
    {
        $params['offset'] = $data['offset'] = $request->input('offset') ?: 1;
        $params['limit'] = $data['limit'] = $this->limit;

        $data['pageType'] = 'faq';
        $data['categories'] = $this->helpService->getFaqCategories();
        $data['category_idx'] = $params['category_idx'] = $request->input('category_idx');
        $data = array_merge($data, $this->helpService->getFaqList($params));
        return view(getDeviceType().'help.index', $data);
    }

    /**
     * 공지사항 리스트
     * @param Request $request
     * @return View
     */
    public function notice(Request $request): View
    {
        $params['offset'] = $data['offset'] = $request->input('offset') ?: 1;
        $params['limit'] = $data['limit'] = $this->limit;

        $data['pageType'] = 'notice';
        $data = array_merge($data, $this->helpService->getNoticeList($params));
        return view(getDeviceType().'help.notice', $data);
    }

    /**
     * 이용 가이드 리스트
     * @param Request $request
     * @return View
     */
    public function guide(Request $request): View
    {
        $params['offset'] = $data['offset'] = $request->input('offset') ?: 1;
        $params['limit'] = $data['limit'] = $this->limit;

        $data['pageType'] = 'guide';
        $data = array_merge($data, $this->helpService->getGuideList($params));
        return view(getDeviceType().'help.guide', $data);
    }

    /**
     * 1:1 문의하기 폼
     * @param Request $request
     * @return View
     */
    public function inquiry(Request $request): View
    {
        $params['offset'] = $data['offset'] = $request->input('offset') ?: 1;
        $params['limit'] = $data['limit'] = 20;

        $data = array_merge($data, $this->helpService->getInquiries($params));

        return view(getDeviceType().'help.inquiry', $data);
    }

    // 1:1 문의하기 상세 (모바일 전용)
    public function inquiryDetail(int $idx)
    {
        if ($idx) {
            if(!$this->helpService->isInquiryOfUser($idx) || $this->helpService->isDeleted($idx)) {
                return redirect('/help/inquiry');
            }

            $data = $this->helpService->getInquiryDetail($idx);
            return view("m.help.inquiry-detail", $data);
        }
    }

    /**
     * 1:1문의하기 등록/수정 폼
     * @param int|null $idx
     * @return View
     */
    public function inquiryForm(int $idx=null)
    {
        $data['detail'] = null;
        if ($idx) {
            
            if(!$this->helpService->isInquiryOfUser($idx) || $this->helpService->isDeleted($idx)) {
                return redirect('/help/inquiry');
            }

            $data['detail'] = $this->helpService->getSavedInquiry($idx);
        }
        $data['categories'] = $this->helpService->getInquiryCategories();
        return view(getDeviceType().'help.inquiry-form', $data);
    }


    /**
     * 1:1 문의하기 등록
     * @param Request $request
     * @return JsonResponse
     */
    public function registerInquiry(Request $request): JsonResponse
    {
        return response()->json($this->helpService->registerInquiry($request->all()));
    }

    /**
     * 1:1 문의 취소
     * @param int $idx
     * @return JsonResponse
     */
    public function removeInquiry(int $idx): JsonResponse
    {
        return response()->json($this->helpService->removeInquiry($idx));
    }
}
