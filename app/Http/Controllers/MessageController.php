<?php


namespace App\Http\Controllers;


use App\Service\MessageService;
use App\Service\PushService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class MessageController extends BaseController
{
    private $messageService;
    private $pushService;
    
    public function __construct(MessageService $messageService, PushService $pushService)
    {
        $this->messageService = $messageService;
        $this->pushService = $pushService;
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
        $data['user_idx'] = $this->messageService->getUserIdx();
        $data['companyIdx'] = Auth::user()['company_idx'];
        return view(getDeviceType() . 'message.index', $data);
    }

    /**
     * pc > 대화방 내용 가져오기
     * @param Request $request
     * @return Redirector|View
     */
    public function room(Request $request)
    {
        $params = $request->all();
        if (!isset($params['room_idx'])) {
            return redirect('/message');
        }
        $data['user_idx'] = $this->messageService->getUserIdx();
        
        $data['keyword'] = isset($params['keyword']) ? $params['keyword'] : '';
        $data['chatting_keyword'] = isset($params['chatting_keyword']) ? $params['chatting_keyword'] : '';
        
        $data['room_idx'] = $params['room_idx'];
        $this->messageService->readRoomAlarmCount($data['room_idx']);
        $data['company'] = $this->messageService->getCompany($params, 'N');
        $data['chatting'] = $this->messageService->getChatting($params);
        $data['chattingCount'] = $this->messageService->getChattingCount($params);
        $data['day'] = ["일","월","화","수","목","금","토"];
        $pushParams = [
            'company_idx' => $data['company']->idx,
            'company_type' => $data['company']->company_type,
        ];
        $data['chattingHtml'] = '';
        $data['companyIdx'] = Auth::user()['company_idx'];
        
        $lastCommunicatedDate = '';
        
        if(isset($data['chatting'])) {
            foreach($data['chatting'] as $key => $chat) {
                try{
                    if($chat->message_register_day != $lastCommunicatedDate) {
                        $lastCommunicatedDate = $chat->message_register_day;

                        $data['chattingHtml'] = $data['chattingHtml'] . '<div class="date"><span>' . 
                            $chat->message_register_day.' '.$data['day'][$chat->message_register_day_of_week - 1].'요일</span></div>';
                    }
                    $contentHtml = $this->messageService->convertHtmlContentByMessage($chat, 'Y');
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

        if(getDeviceType() == "") {
            // PC 인 경우.
            return view('message.message-section', $data);
        } else {
            return view(getDeviceType() . 'message.detail', $data);
        }
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
        $data['company'] = $this->messageService->getCompany($params, 'N');
        $data['chatting'] = $this->messageService->getChatting($params);
        $data['chattingCount'] = $this->messageService->getChattingCount($params);
        $data['day'] = ["일","월","화","수","목","금","토"];
        $pushParams = [
            'company_idx' => $data['company']->idx,
            'company_type' => $data['company']->company_type,
        ];
        $data['chattingHtml'] = '';
        $lastCommunicatedDate = '';
        $data['companyIdx'] = Auth::user()['company_idx'];
        
        if(isset($data['chatting'])) {
            foreach($data['chatting'] as $key => $chat) {
                try{
                    if($chat->message_register_day != $lastCommunicatedDate) {
                        $lastCommunicatedDate = $chat->message_register_day;

                        $data['chattingHtml'] = $data['chattingHtml'] . '<div class="date"><span>' . 
                            $chat->message_register_day.' '.$data['day'][$chat->message_register_day_of_week - 1].'요일</span></div>';
                    }
                    $contentHtml = $this->messageService->convertHtmlContentByMessage($chat, 'N');
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
     * 나의 검색어 조회
     * @param $idx
     * @return JsonResponse
     */
    public function getMyKeyword(): JsonResponse
    {
        return response()->json($this->messageService->getMyKeyword());
    }

    /**
     * 검색어로 채팅방(업체명 or 채팅 내용) 조회
     * @param $idx
     * @return JsonResponse
     */
    public function getRooms(Request $request): JsonResponse
    {
        $params = $request->all();
        if (isset($params['keyword']) && !empty($params['keyword'])) {
            $this->messageService->storeSearchKeyword($params['keyword']);
        }
        return response()->json($this->messageService->getRoomsByKeyword($params));
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

    public function sendToUnreadRecipients()
    {
        $list = $this->messageService->getUnreadRecipientsList();
        
        $result = [];
        $sendPhoneNumbers = [];
        for($idx = 0; $idx < count($list); $idx = $idx + 1) {
        
            $receiver = $list[$idx]->phone_number;
            $receiverCheck = str_replace("-", "", $receiver);
            if(in_array($receiverCheck, $sendPhoneNumbers)) {
                // 이미 확인 요청을 보낸 핸드폰에 재요청을 하지 않습니다.
                continue;
            }
            array_push($sendPhoneNumbers, $receiverCheck);

            $message = '[' . $list[$idx]->회사명 . ']님이 읽지 않은 중요한 메세지💬가 있어요. 지금 앱을 켜서 확인해 보세요!';
            $roomIdx = $list[$idx]->room_idx;
                
            $this->pushService->sendPush('거래처에서 메시지가 왔어요!', $message, 
                $list[$idx]->user_idx, 5, env('APP_URL').'/message/room?room_idx=' . $roomIdx, env('APP_URL').'/message/room?room_idx=' . $roomIdx);
                            
        }

        return $result;
    }
    

    public function sendToUnreadYesterdayRecipients()
    {
        $list = $this->messageService->getBeforeDayUnreadRecipientsList();
        
        $result = [];
        $sendPhoneNumbers = [];
        for($idx = 0; $idx < count($list); $idx = $idx + 1) {
        
            $receiver = $list[$idx]->phone_number;
            $receiverCheck = str_replace("-", "", $receiver);
            if(in_array($receiverCheck, $sendPhoneNumbers)) {
                // 이미 확인 요청을 보낸 핸드폰에 재요청을 하지 않습니다.
                continue;
            }
            array_push($sendPhoneNumbers, $receiverCheck);

            $sreq = [];
            $sreq['회사명'] = $list[$idx]->회사명;
            $sreq['올톡링크'] = env('APP_URL2').'/message';
            $result[] = $receiver;

            $result[] = response()->json($this->pushService->sendKakaoAlimtalk(
                'UD_7843', '[상품 문의 미확인 알림]', $sreq, $receiver, null));
        }

        return $result;
    }

    /**
     * 메시지 읽음 처리
     * @param Request $request
     * @return JsonResponse
     */
    public function readRoomAlarmCount(Request $request): JsonResponse
    {
        $this->messageService->readRoomAlarmCount($request['room_idx']);
        return response()->json([
            'result' => 'success',
            'message' => ''
        ]);
    }

    /**
     * 룸 삭제
     * @param $idx
     * @return JsonResponse
     */
    public function removeRoom($idx): JsonResponse
    {
        return response()->json($this->messageService->removeRoom($idx));
    }
}
