<?php


namespace App\Service;


use App\Models\CompanyRetail;
use App\Models\CompanyWholesale;
use App\Models\Message;
use App\Models\MessageKeyword;
use App\Models\MessageRoom;
use App\Models\Product;
use App\Models\Report;
use App\Models\User;
use App\Models\UserNormal;
use App\Models\UserPushSet;
use App\Events\ChatMessage;
use App\Events\ChatUser;
use App\Events\PushToken;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Service\PushService;

class MessageService
{
    private $pushService;

    public function __construct(PushService $pushService)
    {
        $this->pushService = $pushService;
    }
    /**
     * 대화방 리스트 가져오기
     * @param array $params
     * @return array
     */
    public function getRooms(array $params=[]): array
    {
        $keyword = '';
        if (isset($params['keyword']) && !empty($params['keyword'])) {
            $keyword = $params['keyword'];
        }
        $roomQuery = $this->getRoomQuery();
        $messageRooms = $roomQuery->get();
        return $this->getRoomsInfo($messageRooms, $keyword);
    }

    /**
     * 상대방 정보 가져오기
     * @param array $params
     * @return mixed
     */
    public function getRoomQuery(array $params=[])
    {
        $user = Auth::user();
        $roomQuery = MessageRoom::where(function($query) use($user) {
            $query->where(function($query2) use($user) {
                $query2->where('first_company_type', $user->type)
                    ->where('first_company_idx', $user->company_idx);
            })->orWhere(function($query2) use($user) {
                $query2->where('second_company_type', $user->type)
                    ->where('second_company_idx', $user->company_idx);
            });
        })
            ->select("AF_message_room.idx"
                , DB::raw("IF(first_company_idx = '".$user->company_idx."' AND first_company_type = '".$user->type."'
                    ,second_company_idx,first_company_idx) AS other_company_idx")
                , DB::raw("IF(first_company_idx = '".$user->company_idx."' AND first_company_type = '".$user->type."'
                    ,second_company_type,first_company_type) AS other_company_type"));
        if (isset($params['room_idx']) && !empty($params['room_idx'])) {
            $roomQuery->where('AF_message_room.idx', $params['room_idx']);
        }
        return $roomQuery;
    }


    /**
     * 업체 정보 가져오기
     * @param array $params
     * @return Model|Builder|object
     */
    public function getCompany(array $params) {
        
        $user = Auth::user();
        $room = $this->getRoomQuery($params)->first();

        if ($room->other_company_type === 'W') {
            
            $company = DB::table('AF_wholesale AS company')
                ->leftJoin('AF_attachment AS attach', 'attach.idx', 'company.profile_image_attachment_idx')
                ->leftJoin('AF_user_push_set AS push', function($query) {
                    $query->on('push.company_idx', 'company.idx')->where('push.company_type', 'W');
                })
                ->where('company.idx', $room->other_company_idx)
                ->select('company.*'
                    , DB::raw('"W" AS company_type')
                    , DB::raw('CONCAT("'.preImgUrl().'",attach.folder,"/",attach.filename) AS profile_image')
                    , DB::raw('IF(push.idx,"Y","N") AS is_alarm')
                )->first();
                
                
        } else if ($room->other_company_type === 'R') {
            
            $company = DB::table('AF_retail AS company')
                ->leftJoin('AF_attachment AS attach', 'attach.idx', 'company.profile_image_attachment_idx')
                ->leftJoin('AF_user_push_set AS push', function($query) {
                    $query->on('push.company_idx', 'company.idx')->where('push.company_type', 'R');
                })
                ->where('company.idx', $room->other_company_idx)
                ->select('company.*'
                    , DB::raw('"R" AS company_type')
                    , DB::raw('CONCAT("'.preImgUrl().'",attach.folder,"/",attach.filename) AS profile_image')
                    , DB::raw('IF(push.idx,"Y","N") AS is_alarm')
                    , DB::raw('(SELECT GROUP_CONCAT(DISTINCT ac2.name)
                        FROM AF_category ac
                            INNER JOIN AF_product ap ON ac.idx = ap.category_idx
                            INNER JOIN AF_category ac2 ON ac2.idx = ac.parent_idx
                        WHERE ap.company_type = "R" AND ap.company_idx = company.idx
                    ) AS category_names')
                    , DB::raw('(SELECT GROUP_CONCAT(sido)
                        FROM AF_location al
                        WHERE al.company_type = "R" AND al.company_idx = company.idx
                    ) AS locations')
                )->first();
                
        } else {
            
            $is_alarm = DB::table('AF_user_push_set AS push')
                ->where('push.company_idx', "1")
                ->where('push.company_type', "A")
                ->where('user_idx', $user->idx)
                ->count() > 0 ? 'Y' : 'N';
            
            $company = (object)[
                'idx' => '1',
                'room_idx' => $room->idx,
                'profile_image' => config('constants.ALLFURN.PROFILE_IMAGE'),
                'company_name' => '올펀',
                'company_type' => 'A',
                'is_alarm' => $is_alarm,
            ];
        }
        
        return $company;
    }
    

    /**
     * 채팅 내용 가져오기
     * @param array $params
     * @return mixed
     */
    public function getChatting(array $params) {
        
        $user = Auth::user();

        $offset = 0;
        $limit = 30;

        if(isset($params['offset'])) {
            $offset = $params['offset'];
        }
        if(isset($params['limit'])) {
            $limit = $params['limit'];
        }
        if(isset($params['pageNo'])) {
            $offset = ($params['pageNo'] - 1) * $limit;
        }
        
        $chatting = MessageRoom::where('AF_message_room.idx', $params['room_idx'])
            ->join('AF_message', 'AF_message.room_idx', 'AF_message_room.idx')
            ->orderBy('AF_message.register_time', 'DESC')
            ->offset($offset)
            ->limit($limit)
            ->select('AF_message.*'
                , DB::raw("IF(AF_message.user_idx != '{$user['idx']}' OR AF_message.sender_company_idx = 1, 'left', 'right') AS arrow")
                , DB::raw("DATE_FORMAT(AF_message.register_time, '%H:%i') AS message_register_times")
                , DB::raw("DAYOFWEEK(AF_message.register_time) AS message_register_day_of_week")
                , DB::raw("DATE_FORMAT(AF_message.register_time, '%Y년 %c월 %e일') AS message_register_day")
            );
            
        if (isset($params['keyword']) && !empty($params['keyword'])) {
             $chatting->where(function($query) use($params) {
                 $query->whereRaw('AF_message_room.room_name LIKE "%'.$params['keyword'].'%"')
                     ->orWhereRaw('AF_message.content LIKE "%'.$params['keyword'].'%"');
             });
        }
        
        return $chatting->get()->reverse()->values();
    }
    

    /**
     * 채팅 수량 가져오기
     * @param array $params
     * @return mixed
     */
    public function getChattingCount(array $params) {
        
        $user = Auth::user();
        
        $chatting = MessageRoom::where('AF_message_room.idx', $params['room_idx'])
            ->join('AF_message', 'AF_message.room_idx', 'AF_message_room.idx')
            ->select('AF_message.*'
                , DB::raw("IF(AF_message.user_idx != '{$user['idx']}' OR AF_message.sender_company_idx = 1, 'left', 'right') AS arrow")
                , DB::raw("DATE_FORMAT(AF_message.register_time, '%H:%i') AS message_register_times")
                , DB::raw("DAYOFWEEK(AF_message.register_time) AS message_register_day_of_week")
                , DB::raw("DATE_FORMAT(AF_message.register_time, '%Y년 %c월 %e일') AS message_register_day")
            );
            
        if (isset($params['keyword']) && !empty($params['keyword'])) {
             $chatting->where(function($query) use($params) {
                 $query->whereRaw('AF_message_room.room_name LIKE "%'.$params['keyword'].'%"')
                     ->orWhereRaw('AF_message.content LIKE "%'.$params['keyword'].'%"');
             });
        }
        
        return $chatting->count();
    }



    /**
     * 대화방 리스트에 표시되는 상대방(업체) 정보 가져오기
     * @param $messageRooms
     * @param $keyword
     * @return array
     */
    public function getRoomsInfo($messageRooms, $keyword=''): array
    {
        $rooms = [];
        foreach($messageRooms as $messageRoom) {
            $table = null;
            $params = [
                'room' => $messageRoom,
                'keyword' => $keyword,
            ];
            $room = $this->getRoom($params);
            if (!(isset($room) && !empty($room))) {
                continue;
            }
            switch($messageRoom->other_company_type) {
                case 'A': // 올펀
                    $rooms[] = (object)[
                        'idx' => $messageRoom->idx,
                        'profile_image' => config('constants.ALLFURN.PROFILE_IMAGE'),
                        'name' => config('constants.ALLFURN.NAME'),
                        'company_type' => $messageRoom->other_company_type,
                        'message_type' => $room->type,
                        'unread_count' => $room->unread_count,
                        'last_message_content' => $this->getRoomMessageTitle($room->content),
                        'last_message_time' => $room->register_time,
                    ];
                    break;
                case 'W': // 도매
                    $table = "AF_wholesale";
                    break;
                case 'R': // 소매
                    $table = "AF_retail";
                    break;
                case 'S':
                    $table = "AF_normal";
                    break;                    
                case 'N': // 일반
                    $table = "AF_normal";
                    break;
            }
            
            if (isset($table)) {
                
                if ( $table == "AF_normal" ) {
                    
                    $company = DB::table($table)
                        ->where("{$table}.idx", $messageRoom->other_company_idx)
                        ->leftJoin('AF_attachment', 'AF_attachment.idx', "{$table}.namecard_attachment_idx")
                        ->addSelect("{$table}.name"
                            , DB::raw('CONCAT("'.preImgUrl().'",AF_attachment.folder,"/",AF_attachment.filename) AS profile_image'))
                        ->first();
                    
                    $company_name = $company->name;
                    
                } else {
                    
                    $company = DB::table($table)
                        ->where("{$table}.idx", $messageRoom->other_company_idx)
                        ->leftJoin('AF_attachment', 'AF_attachment.idx', "{$table}.profile_image_attachment_idx")
                        ->addSelect("{$table}.company_name"
                            , DB::raw('CONCAT("'.preImgUrl().'",AF_attachment.folder,"/",AF_attachment.filename) AS profile_image'))
                        ->first();
                    
                    $company_name = $company->company_name;
                    
                }
                
                
                $rooms[] = (object)[
                    'idx' => $messageRoom->idx,
                    'profile_image' => $company->profile_image,
                    'name' => $company_name,
                    'company_type' => $messageRoom->other_company_type,
                    'message_type' => $room->type,
                    'unread_count' => $room->unread_count ?? 0,
                    'last_message_content' => $this->getRoomMessageTitle($room->content),
                    'last_message_time' => $room->register_time ?? "",
                ];
            }
        }
        return $rooms;
    }

    /**
     * 대화방 리스트의 대화 가져오기
     * @param array $params
     * @return mixed
     */
    public function getRoom(array $params)
    {
        $room = $params['room'];
        $keyword = $params['keyword'];
        $message = Message::where('room_idx', $room->idx)
            ->select('AF_message.*'
                , DB::raw("(SELECT COUNT(*) FROM AF_message
                        WHERE (is_read = 0 OR is_read IS NULL) AND room_idx = {$room->idx} AND
                            sender_company_type = '{$room->other_company_type}' AND
                            sender_company_idx = {$room->other_company_idx}
                    ) AS unread_count")
                , DB::raw("CASE WHEN TIMESTAMPDIFF(SECOND ,AF_message.register_time, now()) < 86400 THEN DATE_FORMAT(AF_message.register_time, '%H:%i')
                   WHEN TIMESTAMPDIFF(SECOND ,AF_message.register_time, now()) < 259200 THEN '어제'
                   ELSE DATE_FORMAT(AF_message.register_time, '%m월%d일')
                END register_time"))
            ->orderBy('idx','desc');
        if ($keyword) {
            $company = false;
            if ($room->other_company_type === 'W') {
                $company = true;
                $message->leftJoin('AF_wholesale AS company', 'company.idx', 'AF_message.sender_company_idx');
            } else if ($room->other_company_type === 'R') {
                $company = true;
                $message->leftJoin('AF_retail AS company', 'company.idx', 'AF_message.sender_company_idx');
            }
            $message->where(function($query) use ($keyword, $company) {
                $query->whereRaw('IF(JSON_VALID(AF_message.content),JSON_EXTRACT(AF_message.content, "$.text"),AF_message.content) LIKE "%'.$keyword.'%"');
                if ($company) {
                    $query->orWhere('company.company_name', 'like', "%{$keyword}%");
                }
            });
        }
        $message->orderBy('idx', 'desc');
        $result = $message->first();
        return $result;
    }

    /**
     * 대화방 리스트에 표시되는 대화 내용 파싱해서 가져오기
     * @param $content
     * @return mixed
     */
    public function getRoomMessageTitle($content): string
    {
        $message = '';

        try{
            $decodedContent = json_decode($content, true);
            if(!isset($decodedContent) && empty($decodedContent['type'])) { return $content; }
            switch($decodedContent['type']) {
                case 'welcome':
                    $message = "올펀 가입을 축하드립니다.";
                    break;
                case 'cs':
                    $message = "올펀 고객센터";
                    break;
                case 'inquiry':
                    $message = "상품 문의드립니다.";
                    break;
                case 'estimate':
                    $message = "견적 문의드립니다.";
                    break;
                case 'order':
                case 'order_complete':
                    $message = "주문이 완료되었습니다.";
                    break;
                case 'normal':
                    $message = $decodedContent['text'];
                    break;
                default:
                    $message = isset($decodedContent['title']) ? $decodedContent['title'] : strip_tags($decodedContent['text'] ?? '');
                    break;
            }
        } catch(Exception $e) {
            // 디코드 실패할 경우
            $message = $content;
        }
        return $message;
    }

    /**
     * 검색이 리스트 가져오기
     * @return mixed
     */
    public function getSearchKeywords()
    {
        return MessageKeyword::where('user_idx', Auth::user()['idx'])
            ->orderBy('idx', 'desc')
            ->limit(20)
            ->get();
    }

    /**
     * 검색어 저장
     * @param $keyword
     */
    public function storeSearchKeyword($keyword)
    {
        MessageKeyword::where('user_idx', Auth::user()['idx'])->where('keyword', $keyword)->delete();
        $messageKeyword = new MessageKeyword;
        $messageKeyword->user_idx = Auth::user()['idx'];
        $messageKeyword->keyword = $keyword;
        $messageKeyword->save();
    }

    /**
     * 검색어 삭제
     * @param $idx
     * @return array
     */
    public function deleteKeyword($idx): array
    {
        if ($idx === 'all') {
            MessageKeyword::where('user_idx', Auth::user()['idx'])->delete();
        } else {
            MessageKeyword::where('user_idx', Auth::user()['idx'])
                ->where('idx', $idx)
                ->delete();
        }

        return [
            'result' => 'success',
            'message' => ''
        ];
    }

    /**
     * 나의 검색어 조회
     * @param $idx
     * @return array
     */
    public function getMyKeyword(): array
    {
        // 최신 5개만 조회
        $keywords = MessageKeyword::where('user_idx', Auth::user()['idx'])
            ->orderBy('register_time', 'desc')
            ->offset(0)
            ->limit(5)
            ->get();

        return [
            'result' => 'success',
            'message' => 'success',
            'data' => $keywords
        ];
    }

    /**
     * 검색어로 채팅방(업체명 or 채팅 내용) 조회
     * @param $idx
     * @return array
     */
    public function getRoomsByKeyword($params): array
    {
        return [
            'result' => 'success',
            'message' => 'success',
            'data' => $this->getRooms($params)
        ];
    }
    
    /**
     * 알림 켜기/끄기
     * @param array $params
     * @return array
     */
    public function toggleCompanyPush(array $params): array
    {
        $userPush = UserPushSet::where('user_idx', Auth::user()['idx'])
            ->where('push_type', 'T')
            ->where('company_type', $params['company_type'])
            ->where('company_idx', $params['company_idx'])
            ->first();
        if ($userPush) {
            $code = 'DELETE_SUCCESS';
            UserPushSet::find($userPush->idx)->delete();
        } else {
            $code = 'INSERT_SUCCESS';
            $userPushSet = new UserPushSet;
            $userPushSet->user_idx = Auth::user()['idx'];
            $userPushSet->company_idx = $params['company_idx'];
            $userPushSet->company_type = $params['company_type'];
            $userPushSet->push_type = 'T';
            $userPushSet->save();
        }
        return [
            'result' => 'success',
            'code' => $code,
            'message' => ''
        ];
    }

    /**
     * 알림 읽기 처리
     * @param $idx
     */
    public function readRoomAlarmCount($idx)
    {
        Message::where('room_idx', $idx)->update(['is_read' => 1]);
    }

    /**
     * 업체 신고하기
     * @param $params
     * @return array
     */
    public function reporting($params): array
    {
        $targetUser = User::where('company_idx', $params['company_idx'])
//            ->where('parent_idx', 0)
            ->where('type', $params['company_type'])->first();
        $report = new Report;
        $report->report_type = 'M';
        $report->target_idx = $targetUser->idx ?? 1;
        $report->reason = $params['content'];
        $report->state = 1; // 미처리
        $report->user_idx = Auth::user()['idx'];
        $report->target_company_idx = $params['company_idx'];
        $report->target_company_type = $params['company_type'];
        $report->save();
        return [
            'result' => 'success',
            'message' => ''
        ];
    }

    public function convertHtmlContentByMessage($chat){
        $contentHtml = '';
        $user = Auth::user();

	$chatContent = json_decode($chat->content, true);
	
	if(!isset($chatContent) && empty($chatContent['type'])) { $contentHtml = $chat->content; }
       
	else if($chatContent['type'] == 'welcome' || $chatContent['type'] == 'normal') {
            // 단순 텍스트
            $contentHtml = $chatContent['text'];
        } else if($chatContent['type'] == 'attach') {
            // 첨부
            $extension = explode('.', $chatContent['imgUrl']);
            $extension = end($extension);
            $extension = strtolower($extension);

            if(in_array($extension, ['png', 'jpg', 'jpeg', 'gif', 'bmp', 'svg'])) {
                // 이미지
                return '<div class="chatting ' . ($user['idx'] == $chat->user_idx ? 'right' : 'left') . '">
                            <img src="'.$chatContent['imgUrl'].'" class="border rounded-md object-cover w-[300px]">
                            <div class="timestamp">' . ($chat->message_register_times ?? substr(date('H:i:s'), 0, 5)) . '</div>
                        </div>';
            } else if(in_array($extension, ['png', 'jpg', 'jpeg', 'gif', 'bmp', 'svg'])) {
                // PDF
                $contentHtml = '<div class="flex gap-3 items-center"><a href="'.$chatContent['imgUrl'].'" target="_blank">
                                    <div class="rounded-md w-[48px] h-[48px] bg-stone-100 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text text-stone-400"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                                    </div>
                                    <div class="font-medium w-[260px]">
                                        <span class="text-sm text-stone-400">PDF</span>
                                        <p class="truncate">'.$chatContent['originName'].'</p>
                                    </div></a>
                                </div>';
            } else if(in_array($extension, ['zip', 'egg', 'tar', 'tar.gz', '7zip'])) {
                // 압축 파일
                $contentHtml = '<div class="flex gap-3 items-center"><a href="'.$chatContent['imgUrl'].'" target="_blank">
                                    <div class="rounded-md w-[48px] h-[48px] bg-stone-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-folder-archive text-stone-400"><circle cx="15" cy="19" r="2"/><path d="M20.9 19.8A2 2 0 0 0 22 18V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2h5.1"/><path d="M15 11v-1"/><path d="M15 17v-2"/></svg>
                                    </div>
                                    <div class="font-medium w-[260px]">
                                        <span class="text-sm text-stone-400">ZIP</span>
                                        <p class="truncate">'.$chatContent['originName'].'</p>
                                    </div></a>
                                </div>';
            }
        } else if($chatContent['type'] == 'inquiry') {
            // 상담
            $contentHtml = '<div class="flex flex-col">
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
            $contentHtml = '<div class="font-medium w-[260px]">
                                    <p class="truncate">주문번호 : '.$chatContent['order_group_code'].'</p>
                                    <div class="mt-2">
                                        <p class="text-sm font-basic">거래가 확정되었습니다.</p>
                                        <p class="text-sm font-basic">상품이 준비중이니 기다려주세요!</p>
                                    </div>
                                    <a href="/product/detail/'.$chatContent['order_group_code'].'" class="block w-full mt-2 py-3 border rounded-md text-primary text-center hover:bg-stone-50">주문 현황 보러가기</a>
                                </div>';

        } else if($chatContent['type'] == 'estimate') {
            // 견적
            $contentHtml = '<a href="/estimate/detail/'.$chatContent['estimate_idx'].'">
                                <p class="font-bold">상품 문의드립니다.</p>
                                <div class="flex gap-3 items-center mt-2">
                                    <img src="'.$chatContent['product_image'].'" alt="" class="border rounded-md object-cover w-[48px] h-[48px] shrink-0">
                                    <!-- 이미지 없을 때 -->
                                    <!-- <div class="rounded-md w-[48px] h-[48px] bg-stone-100 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image-off text-stone-400"><line x1="2" x2="22" y1="2" y2="22"/><path d="M10.41 10.41a2 2 0 1 1-2.83-2.83"/><line x1="13.5" x2="6" y1="13.5" y2="21"/><line x1="18" x2="21" y1="12" y2="15"/><path d="M3.59 3.59A1.99 1.99 0 0 0 3 5v14a2 2 0 0 0 2 2h14c.55 0 1.052-.22 1.41-.59"/><path d="M21 15V5a2 2 0 0 0-2-2H9"/></svg>
                                    </div> -->
                                    <div class="font-medium w-[260px]">
                                        <p class="truncate">'.$chatContent['product_name'].'</p>
                                        <span class="text-sm text-stone-400">'.$chatContent['memo'].'</span>
                                    </div>
                                </div>
                            </a>';
        }

        return '<div class="chatting ' . ($user['idx'] == $chat->user_idx ? 'right' : 'left') . '">
                    <div class="chat_box">' . $contentHtml . '</div>
                    <div class="timestamp">' . ($chat->message_register_times ?? substr(date('H:i:s'), 0, 5)) . '</div>
                </div>';
    }

    /**
     * 메시지 전송
     * @param Request $request
     * @return array
     */
    public function sendMessage(Request $request): array
    {
        $user = Auth::user();
        $params = $request->all();

        if(!isset($params['room_idx']) && isset($params['idx']) && isset($params['type'])) {
            if ($params['type'] == 'product' || $params['type'] == 'inquiry') {
                $params['product_idx'] = $params['idx'];
            } else if ($params['type'] == 'wholesaler') {
                $params['recever_idx'] = $params['idx'];
            }

            $params['room_idx'] = $this->getRoomByProduct($params, $user);
        }

        $image = $request->file('message_image');
        if ($image) {
            $imageUrl = $this->uploadImage($image, 'message');
            $message = new Message;
            $message->room_idx = $params['room_idx'];
            $message->type = 2;
            $message->sender_company_type = $user['type'];
            $message->sender_company_idx = $user['company_idx'];
            $message->user_idx = $user['idx'];
            $message->content = json_encode((object)[
                'type' => 'attach',
                'imgUrl' => $imageUrl,
                'ext' => pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION),
                'originName' => $image->getClientOriginalName()
            ], JSON_UNESCAPED_UNICODE); ;
            $message->save();
        }
        
        if (isset($params['product_idx'])) {
            
            $product = Product::find($params['product_idx']);
            $content = json_encode((object)[
                'type' => 'inquiry',
                'msg' => (isset($params['message']) && !empty($params['message']) ? $params['message'] : '상품 문의드립니다.'),
                'productIdx' => $params['product_idx'],
                'productName' => $product->name,
                'productPrice' => ($product->price_text ?? $product->price),
                'productThumbnailURL' => $product->attachment_idx,
            ], JSON_UNESCAPED_UNICODE);
            $message = new Message;
            $message->room_idx = $params['room_idx'];
            $message->type = 3;
            $message->sender_company_type = $user['type'];
            $message->sender_company_idx = $user['company_idx'];
            $message->user_idx = $user['idx'];
            $message->content = $content;
            $message->save();

            Product::where('idx', $params['product_idx'])
                ->update(['inquiry_count' => DB::raw('inquiry_count + 1')]);
            
            
            switch ($product->company_type) {
                case 'W':
                    CompanyWholesale::where('idx', $product->company_idx)
                        ->update(['inquiry_count' => DB::raw('inquiry_count + 1')]);
                    break;
                case 'R':
                    CompanyRetail::where('idx', $product->company_idx)
                        ->update(['inquiry_count' => DB::raw('inquiry_count + 1')]);
                    break;
                case 'N':
                    UserNormal::where('idx', $product->company_idx)
                        ->update(['inquiry_count' => DB::raw('inquiry_count + 1')]);
            }
            
        }
        
        
        if (!isset($params['product_idx']) && isset($params['message']) && !empty($params['message'])) {
            $message = new Message;
            $message->room_idx = $params['room_idx'];
            $message->type = 1;
            $message->sender_company_type = $user['type'];
            $message->sender_company_idx = $user['company_idx'];
            $message->user_idx = $user['idx'];
            $message->content = json_encode((object)[
                'type' => 'normal',
                'text' => $params['message'],
            ], JSON_UNESCAPED_UNICODE);
            $message->save();
        }

        setlocale(LC_ALL, "ko_KR.utf-8");
        // echo
        $companyInfo = $this->getCompany(['room_idx' => $message->room_idx]);
        event(new ChatMessage($message->room_idx, 
            $message->user_idx, 
            $message->content, 
            $this->convertHtmlContentByMessage($message),
            date('Y년 m월 d일'),
            substr(date('H:i:s'), 0, 5),
            ["일","월","화","수","목","금","토"][date('w', time())],
            $this->getRoomMessageTitle($message->content),
            $companyInfo->company_name
        ));
        
        // 대상 회사에 소속된 사용자 조회
        $targetUsers = User::where('company_idx', $companyInfo->idx)
            ->where('is_delete', 0)
            ->get();
        if(isset($targetUsers) && is_array($targetUsers)) {
            foreach($targetUsers as $key => $targetUser) {
                $pushToken = PushToken::where('user_idx', $targetUser->idx)
                    ->orderBy('register_time', 'DESC')
                    ->first();
                $this->pushService->sendPush('Allfurn - 채팅', $companyInfo->company_name . ': ' . $message->content, 
                    $targetUser->idx, $pushToken->push_token, $type = 5, 'https://allfurn-web.codeidea.io/message/room?room_idx=' . $message->room_idx);
            }
        }

        return [
            'result' => 'success',
            'message' => $message->content,
            'roomIdx' => $message->room_idx
        ];
    }



    /**
     * 이미지 업로드
     * @param $image
     * @param $path
     * @return string
     */
    public function uploadImage($image, $path): string
    {
        $stored = Storage::disk('s3')->put($path, $image);
        $explodeFileName = explode('/',$stored);
        $fileName = end($explodeFileName);
        $file = preImgUrl() . $path.'/' . $fileName;
        return asset($file);
    }

    /**
     * 대화방 업데이트 카운트 가져오기
     * @param array $params
     * @return array
     */
    public function getRoomsCount(array $params): array
    {
        $unreadMessage = Message::whereIn('room_idx', explode(',',$params['room_idxes']))
            ->where(function($query) {
                $query->where('user_idx', '<>', Auth::user()['idx'])->orWhereNull('user_idx');
            })
            ->where(function($query) {
                $query->where('is_read', 0)->orWhereNull('is_read');
            })
            ->select("room_idx", DB::raw('COUNT(*) AS unread_count'))
            ->groupBy('room_idx')
            ->get();
        return [
            'result' => 'success',
            'list' => $unreadMessage,
            'message' => ''
        ];
    }

    /**
     * 상품 문의 정보 가져오기
     * @param int $productIdx
     * @return mixed
     */
    public function getProduct(int $productIdx)
    {
        return Product::find($productIdx);
    }

    public function getRoomByProduct($params, $user)
    {
        $company = [];

        if ($params['type'] == 'wholesaler') {
            $company['company_type'] = 'W';
            $company['company_idx'] = $params['idx'];
        } else {
            $company = Product::where('idx', $params['product_idx'])->first();
        }

        $roomIdx = MessageRoom::where([
            'first_company_type'=>$company['company_type'],
            'first_company_idx'=>$company['company_idx'],
            'second_company_type'=>$user['type'],
            'second_company_idx'=>$user['company_idx'],
            ])
            ->orWhere(function($query) use ($company, $user) {
                $query->where([
                    'first_company_type'=>$user['type'],
                    'first_company_idx'=>$user['company_idx'],
                    'second_company_type'=>$company['company_type'],
                    'second_company_idx'=>$company['company_idx'],
                ]);
            })
            ->pluck('idx')
            ->first();

        if (!empty($roomIdx)) {
            return $roomIdx;
        } else {
            $messageRoom = new MessageRoom;
            $messageRoom->first_company_type = $user['type'];
            $messageRoom->first_company_idx = $user['company_idx'];
            $messageRoom->second_company_type = $company['company_type'];
            $messageRoom->second_company_idx = $company['company_idx'];
            $messageRoom->save();

            return $messageRoom['idx'];
        }
    }

    /**
     * 채팅창 메시지 보내기
     * @param $params
     * @return string[]
     */
    public function sendRoomMessage($params): array
    {
        $user = Auth::user();
        $templateType = $params['templateType'];
        $templateDetailType = $params['templateDetailType'];
        $messageParam = [
            'first_company_idx' => $user['company_idx'],
            'first_company_type' => $user['type'],
            'second_company_idx' => $params['company_idx'],
            'second_company_type' => $params['company_type'],
        ];

        $room = MessageRoom::where(function($query) use ($messageParam) {
            $query->where('first_company_idx', $messageParam['first_company_idx'])
                ->where('first_company_type', $messageParam['first_company_type'])
                ->where('second_company_idx', $messageParam['second_company_idx'])
                ->where('second_company_type', $messageParam['second_company_type']);
        })->orWhere(function($query) use($messageParam) {
            $query->where('first_company_idx', $messageParam['second_company_idx'])
                ->where('first_company_type', $messageParam['second_company_type'])
                ->where('second_company_idx', $messageParam['first_company_idx'])
                ->where('second_company_type', $messageParam['first_company_type']);
        })
        ->select('idx', DB::raw("IF(first_company_idx='{$messageParam['first_company_idx']}' and first_company_type='{$messageParam['first_company_type']}'
        ,CONCAT(second_company_idx,',',second_company_type),CONCAT(first_company_idx,',',first_company_type)) AS other_company"))
        ->first();

        $isCreated = false;
        if (!$room) {
            $room = new MessageRoom;
            $room->first_company_idx = $messageParam['first_company_idx'];
            $room->first_company_type = $messageParam['first_company_type'];
            $room->second_company_idx = $messageParam['second_company_idx'];
            $room->second_company_type = $messageParam['second_company_type'];
            $room->save();

            $sender_company_idx = $messageParam['second_company_idx'];
            $sender_company_type = $messageParam['second_company_type'];
            $isCreated = true;
        } else {
            $otherCompany = explode(',',$room->other_company);
            $sender_company_idx = $otherCompany[0];
            $sender_company_type = $otherCompany[1];
        }

        $content = "";
        switch($templateType) {
            case 'ORDER':
                $content = json_encode([
                    'type' => 'order',
                    'title' => config('constants.MESSAGE.ORDER.'.$templateDetailType.".TITLE") . $params['orderNum'],
                    'text' => config('constants.MESSAGE.ORDER.'.$templateDetailType.".TEXT"),
                    'order_group_code' => $params['orderNum'],
                ], JSON_UNESCAPED_UNICODE);
                break;
            case 'CS':
                if (!empty(config('constants.MESSAGE.CS.'.$templateDetailType.".TEXT"))) {
                    $text = config('constants.MESSAGE.CS.'.$templateDetailType.".TEXT");
                } else {
                    $text = '전화번호: ' . config('constants.ALLFURN.CALL_NUMBER') . '<br/>운영시간: '
                        . config('constants.ALLFURN.OPERATION_TIME');
                }

                $content = json_encode([
                    'type' => strtolower($params['templateDetailType']),
                    'title' => config('constants.MESSAGE.CS.'.$templateDetailType.".TITLE"),
                    'text' => $text,
                ], JSON_UNESCAPED_UNICODE);
                break;
        }
        $message = new Message;
        $message->room_idx = $room->idx;
        $message->type = 3;
        $message->sender_company_idx = $sender_company_idx;
        $message->sender_company_type = $sender_company_type;
        $message->user_idx = $user['idx'];
        $message->content = $content;
        $message->save();


        setlocale(LC_ALL, "ko_KR.utf-8");
        // 대상 업체 메시지 전달
        $companyInfo = $this->getCompany(['room_idx' => $message->room_idx]);
        event(new ChatMessage($message->room_idx, 
            $message->user_idx, 
            $message->content, 
            $this->convertHtmlContentByMessage($message),
            date('Y년 m월 d일'),
            substr(date('H:i:s'), 0, 5),
            ["일","월","화","수","목","금","토"][date('w', time())],
            $this->getRoomMessageTitle($message->content),
            $companyInfo->company_name
        ));
        if($isCreated) {
            // 방을 최초 개설한 경우, 기존 채팅방 목록에 노출되지 않았을 수 있음. 
            // 이 경우, 해당하는 회사의 모든 사용자 웹소켓으로 전달하여 접속한 소켓(=접속중인 경우)이 있을때 즉시 이벤트 처리가 가능하게 함

            $targetUsers = User::where('company_idx', $companyInfo->idx)
                ->where('is_delete', 0)
                ->get();

            if(isset($targetUsers) && is_array($targetUsers)) {
                foreach($targetUsers as $key => $targetUser) {
                    event(new ChatUser($message->room_idx, 
                        $targetUser->idx, 
                        $message->content, 
                        $this->convertHtmlContentByMessage($message),
                        date('Y년 m월 d일'),
                        substr(date('H:i:s'), 0, 5),
                        ["일","월","화","수","목","금","토"][date('w', time())],
                        $this->getRoomMessageTitle($message->content),
                        $companyInfo->company_name
                    ));
                }
            }
        }
        
        return [
            'result' => 'success',
            'message' => $message->content,
            'roomIdx' => $message->room_idx
        ];
    }

    /**
     * 채팅용 사용자 토큰 생성
     * @return string
     */
    public function getUserIdx(): string
    {
        $user = Auth::user();
        return $user['idx'];
    }

    /**
     * 대화방 알림 켜지있는지 여부 체크
     * @param array $params
     * @return bool
     */
    public function hasUserPushSet(array $params): bool
    {
        if (UserPushSet::where('user_idx', Auth::user()['idx'])
                ->where('company_type', $params['company_type'])
                ->where('company_idx', $params['company_idx'])
                ->count() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
