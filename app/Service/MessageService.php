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
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MessageService
{
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
        
        $chatting = MessageRoom::where('AF_message_room.idx', $params['room_idx'])
            ->join('AF_message', 'AF_message.room_idx', 'AF_message_room.idx')
            ->orderBy('AF_message_room.register_time', 'DESC')
            ->offset()
            ->limit()
            ->select('AF_message.*'
                , DB::raw("IF(AF_message.user_idx != '{$user['idx']}' OR AF_message.sender_company_idx = 1, 'left', 'right') AS arrow")
                , DB::raw("DATE_FORMAT(AF_message.register_time, '%H:%i') AS message_register_times")
                , DB::raw("DAYOFWEEK(AF_message.register_time) AS message_register_day_of_week")
                , DB::raw("DATE_FORMAT(AF_message.register_time, '%Y년 %c월 %e일') AS message_register_day")
                , DB::raw("'' as contentHtml")
            );
            
        // if (isset($params['keyword']) && !empty($params['keyword'])) {
        //     $chatting->where(function($query) use($params) {
        //         $query->whereRaw('IF(AF_message.type=3,AF_message.content->"$.text",AF_message.content) LIKE "%'.$params['keyword'].'%"')
        //             ->orWhereRaw('IF(AF_message.type=3 AND AF_message.content->"$.type" = "product",AF_message.content->"$.name",AF_message.content) LIKE "%'.$params['keyword'].'%"')
        //             ->orWhereRaw('IF(AF_message.type=3 AND AF_message.content->"$.type" = "product",AF_message.content->"$.price",AF_message.content) LIKE "%'.$params['keyword'].'%"')
        //             ->orWhereRaw('IF(AF_message.type=3 AND AF_message.content->"$.type" = "order",AF_message.content->"$.order_group_code",AF_message.content) LIKE "%'.$params['keyword'].'%"');
        //     });
        // }
        
        return $chatting->get();
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
                $query->whereRaw('IF(AF_message.type=3,AF_message.content->"$.text",AF_message.content) LIKE "%'.$keyword.'%"');
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
                default:
                    $message = isset($content['title']) ? $content['title'] : strip_tags($content['text'] ?? '');
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
        /*
    public function storeSearchKeyword($keyword)
    {
        MessageKeyword::where('user_idx', Auth::user()['idx'])->where('keyword', $keyword)->delete();
        $messageKeyword = new MessageKeyword;
        $messageKeyword->user_idx = Auth::user()['idx'];
        $messageKeyword->keyword = $keyword;
        $messageKeyword->save();
    }
        */

    /**
     * 검색어 삭제
     * @param $idx
     * @return array
     */
    /*
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
    */

    /**
     * 알림 켜기/끄기
     * @param array $params
     * @return array
     */
    public function toggleCompanyPush($roomIdx, array $params): array
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
            ->where('parent_idx', 0)
            ->where('type', $params['company_type'])->first();
        $report = new Report;
        $report->report_type = 'M';
        $report->target_idx = $targetUser->idx;
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

        event(new ChatMessage(
            $roomIdx, $user['company_idx'], $params['message'], date('Y-m-d H:i:s')
        ))
        
        return [
            'result' => 'success',
            'message' => '',
            'roomIdx' => $params['room_idx']
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

        if (!$room) {
            $room = new MessageRoom;
            $room->first_company_idx = $messageParam['first_company_idx'];
            $room->first_company_type = $messageParam['first_company_type'];
            $room->second_company_idx = $messageParam['second_company_idx'];
            $room->second_company_type = $messageParam['second_company_type'];
            $room->save();

            $sender_company_idx = $messageParam['second_company_idx'];
            $sender_company_type = $messageParam['second_company_type'];
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

        return [
            'result' => 'success',
            'message' => ''
        ];
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
