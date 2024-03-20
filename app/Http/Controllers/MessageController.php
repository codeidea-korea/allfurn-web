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
        $data['chattingCount'] = $this->messageService->getChattingCount($params);
        $data['day'] = ["일","월","화","수","목","금","토"];
        $pushParams = [
            'company_idx' => $data['company']->idx,
            'company_type' => $data['company']->company_type,
        ];
        $data['chattingHtml'] = '';
        $lastCommunicatedDate = '';
        
        if(isset($data['chatting'])) {
            foreach($data['chatting'] as $key => $chat) {
                try{
                    if($chat->message_register_day != $lastCommunicatedDate) {
                        $lastCommunicatedDate = $chat->message_register_day;

                        $data['chattingHtml'] = $data['chattingHtml'] . '<div class="date"><span>' . 
                            $chat->message_register_day.' '.$data['day'][$chat->message_register_day_of_week].'요일</span></div>';
                    }
                    $contentHtml = $this->messageService->convertHtmlContentByMessage($chat);
                    $data['chattingHtml'] = $data['chattingHtml'] . $contentHtml;
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
     * 대화방 내용만 가져오기
     * @param Request $request
     * @return Redirector|View
     */
    public function getChatting(Request $request)
    {
        $params = $request->all();
        if (!isset($params['room_idx'])) {
            return response()->json([
                'result' => 'fail',
                'message' => 'pleeze input roomIdx.'
            ]);
        }
        
        $data['keyword'] = isset($params['keyword']) ? $params['keyword'] : '';
        $data['room_idx'] = $params['room_idx'];
        $this->messageService->readRoomAlarmCount($data['room_idx']);
        $data['company'] = $this->messageService->getCompany($params);
        $data['chatting'] = $this->messageService->getChatting($params);
        $data['chattingCount'] = $this->messageService->getChattingCount($params);
        $data['day'] = ["일","월","화","수","목","금","토"];
        $pushParams = [
            'company_idx' => $data['company']->idx,
            'company_type' => $data['company']->company_type,
        ];
        $data['chattingHtml'] = '';
        $lastCommunicatedDate = '';
        
        if(isset($data['chatting'])) {
            foreach($data['chatting'] as $key => $chat) {
                try{
                    if($chat->message_register_day != $lastCommunicatedDate) {
                        $lastCommunicatedDate = $chat->message_register_day;

                        $data['chattingHtml'] = $data['chattingHtml'] . '<div class="date"><span>' . 
                            $chat->message_register_day.' '.$data['day'][$chat->message_register_day_of_week].'요일</span></div>';
                    }
                    $contentHtml = $this->messageService->convertHtmlContentByMessage($chat);
                    $data['chattingHtml'] = $data['chattingHtml'] . $contentHtml;
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

        return response()->json([
            'result' => 'success',
            'message' => '',
            'data' => $data,
            'params' => $params
        ]);
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
