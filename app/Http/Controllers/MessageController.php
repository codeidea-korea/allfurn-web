<?php


namespace App\Http\Controllers;


use App\Service\MessageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class MessageController extends BaseController
{
    private $messageService;
    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function index(Request $request) {
        
        Log::debug("----- MessageController / index -----");
        
        $params['keyword'] = preg_replace('/\%\"/i','',$request->input('keyword'));
        
        $data['rooms'] = $this->messageService->getRooms($params);
        
        if (isset($params['keyword']) && !empty($params['keyword'])) {
            $this->messageService->storeSearchKeyword($params['keyword']);
        }
        
        $data['keywords'] = $this->messageService->getSearchKeywords();
        $data['product_idx'] = $request->input('product_idx');
        $data['room_idx'] = $request->input('room_idx');
        return view('message.index', $data);
    }

    /**
     * 대화방 내용 가져오기
     * @param Request $request
     * @return Redirector|View
     */
    public function room(Request $request)
    {
        $params = $request->all();
        if (!isset($params['room_idx'])) {
            return redirect('/message');
        }
        
        $data['keyword'] = isset($params['keyword']) ? $params['keyword'] : '';
        $data['room_idx'] = $params['room_idx'];
        $this->messageService->readRoomAlarmCount($data['room_idx']);
        $data['company'] = $this->messageService->getCompany($params);
        $data['chatting'] = $this->messageService->getChatting($params);
        $data['day'] = ["일","월","화","수","목","금","토"];
        $pushParams = [
            'company_idx' => $data['company']->idx,
            'company_type' => $data['company']->company_type,
        ];

        if(isset($data['chatting'])) {
            foreach($data['chatting'] as $key => $chat) {
                try{
                    $chatContent = json_decode($chat->content, true);
                    if($chatContent['type'] == 'welcome' || $chatContent['type'] == 'normal') {
                        // 단순 텍스트
                        $data['chatting'][$key]->contentHtml = $chatContent['text'];
                    } else if($chatContent['type'] == 'attach') {
                        // 첨부
                        $data['chatting'][$key]->contentHtml = '<div class="flex flex-col"><img src="'.$chatContent['imgUrl'].'"></div>';
                    } else if($chatContent['type'] == 'inquiry') {
                        // 상담
                        $data['chatting'][$key]->contentHtml = '<div class="flex flex-col">
                                                <span>[ 상담문의가 도착했습니다 ] '.$chatContent['productName'].'</span>
                                                <button class="flex flex-col mt-1" click="location.href=\'/product/detail/'.$chatContent['productIdx'].'\'">
                                                    <p class="bg-primary p-2 rounded-md flex items-center text-white">
                                                    <img src="'.$chatContent['productThumbnailURL'].'">
                                                        바로가기
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                                                    </p>
                                                </button>
                                            </div>';
                    } else if($chatContent['type'] == 'order') {
                        // 주문
                        $data['chatting'][$key]->contentHtml = '<div class="flex flex-col">
                                                <span>[ 거래가 확정되었습니다. ] '.$chatContent['order_group_code'].'</span>
                                                <button class="flex flex-col mt-1" click="location.href=\'/product/detail/'.$chatContent['order_group_code'].'\'">
                                                    <p class="bg-primary p-2 rounded-md flex items-center text-white">
                                                        바로가기
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                                                    </p>
                                                </button>
                                            </div>';
                    } else if($chatContent['type'] == 'estimate') {
                        // 견적
                        $data['chatting'][$key]->contentHtml = '<div class="flex flex-col">
                                                <span>[ 견적문의가 도착했습니다. ]</span>
                                                <button class="flex flex-col mt-1" click="location.href=\'/estimate/detail/'.$chatContent['estimate_idx'].'\'">
                                                    <p class="bg-primary p-2 rounded-md flex items-center text-white">
                                                        바로가기
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                                                    </p>
                                                </button>
                                            </div>';
                    }
                } catch(Exception $e) {
                }
            }
            
        }
        
        // if ($this->messageService->hasUserPushSet($pushParams) === false) {
        //     $this->messageService->toggleCompanyPush($pushParams);
        //     $data['company']->is_alarm = 'Y';
        // }
        
        if (isset($params['product_idx'])) {
            $data['product'] = $this->messageService->getProduct($params['product_idx']);
        }

        return view('message.message-section', $data);
    }

    /**
     * 검색어 삭제
     * @param $idx
     * @return JsonResponse
     */
    public function deleteKeyword($idx): JsonResponse
    {
        return response()->json($this->messageService->deleteKeyword($idx));
    }

    /**
     * 알림 켜기/끄기
     * @param Request $request
     * @return JsonResponse
     */
    public function toggleCompanyPush(Request $request): JsonResponse
    {
        return response()->json($this->messageService->toggleCompanyPush($request->all()));
    }

    /**
     * 신고하기
     * @param Request $request
     * @return JsonResponse
     */
    public function report(Request $request): JsonResponse
    {
        return response()->json($this->messageService->reporting($request->all()));
    }

    /**
     * 메시지 전송
     * @param Request $request
     * @return JsonResponse
     */
    public function sendMessage(Request $request): JsonResponse {
        return response()->json(
            $this->messageService->sendMessage($request)
        );
    }


    /**
     * 채팅방 카운트 수 가져오기
     * @param Request $request
     * @return JsonResponse
     */
    public function getRoomsCount(Request $request): JsonResponse
    {
        $rooms = $this->messageService->getRoomsCount($request->all());
        return response()->json($rooms);
    }

    /**
     * 특정 시점에 메세지 보내기
     * @param Request $request
     * @return JsonResponse
     */
    public function sendRoomMessage(Request $request): JsonResponse
    {
        return response()->json($this->messageService->sendRoomMessage($request->all()));
    }
}
