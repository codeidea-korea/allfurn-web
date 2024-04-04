<?php

namespace App\Http\Controllers;

use App\Service\CommunityService;
use App\Service\LoginService;
use App\Service\MemberService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\PushQ;
use App\Models\AuthToken;
use App\Models\PushSendLog;
use Session;

class ExtraApiController extends BaseController
{
    private $loginService;
    private $memberService;
    public function __construct(LoginService $loginService, MemberService $memberService)
    {
        $this->loginService = $loginService;
        $this->memberService = $memberService;
    }

    public function sendPushByStatusPending()
    {
        // pending push
        $pushQueue = PushQ::where('send_type', '=', 'P')->get();
        
        foreach($pushQueue as $pushq) {
            $pushq->send_date = date('Y-m-d H:i:s');
            $pushq->send_type = 'S';
            $pushq->save();

            $targets = explode(',', $pushq->send_target);
            for($idx = 0; $idx < count($targets); $idx++) {
                $userIdx = $targets[$idx];
                if(empty($userIdx)) {
                    continue;
                }
                $authToken = AuthToken::where('user_idx', '=', $userIdx)->orderBy('register_time', 'DESC')->first();

                if(empty($authToken)) {
                    continue;
                }
                
                $data = [
                    "notification" => [
                        "title" => $pushq->title,
                        "body"  => $pushq->content,
                        "content"  => $pushq->content
                    ],
                    "priority" =>  "high",
                    "data" => [
                        "scheme" => $pushq->app_link,
                        "weburl" => $pushq->web_link,
                        "title"  => $pushq->title,
                        "body"  => $pushq->content,
                        "content" => $pushq->content
                    ],
                    "to" => $authToken->token
                ];
            
                $ch = curl_init();
            
                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_FAILONERROR, true);
            
                $headers = array();
                $headers[] = 'Content-Type: application/json';
                $headers[] = 'Authorization: key=AAAA4atg0bQ:APA91bFxmF8ZikIdbyfmMt696pCUKHKO-ceoQMubPGSwu-wT0a21fEV45Lvw-27si_NOirum6nn9NmBekPi-xiqlt8NA2lChXZU84oJSiLkrOO5kkSgruBH9jBdDuQ2bwCT_KuOGutQB';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
                $result = curl_exec($ch);
                echo curl_error($ch);
                echo $result;
            
                $sendLog = new PushSendLog();
                $sendLog->user_idx = $userIdx;
                $sendLog->push_idx = $pushq->idx;
                $sendLog->push_type = $pushq->type;
                $sendLog->is_send = json_decode($result)->success;
                $sendLog->is_check = 0;
                $sendLog->send_date = date('Y-m-d H:i:s');
                $sendLog->response = $result;
                $sendLog->save();

                curl_close ($ch);
            }
        }
    }
}
