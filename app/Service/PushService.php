<?php

namespace App\Service;


use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use App\Models\PushQ;
use App\Models\SmsHistory;
use DateTime;

class PushService
{
    /**
     * 문자 발송
     * 
     * @param string $title
     * @param string $msg
     * @param string $sender
     * @param string $receiver (, 로 구분)
     */
    public function sendSMS($title, $msg, $sender, $receiver)
    {
        $pushMessage = new SmsHistory;
        $pushMessage->title = $title;
        $pushMessage->content = $msg;
        $pushMessage->sender = $sender;
        $pushMessage->receiver = $receiver;
        $pushMessage->save();


        $key = "eifub09280f6yzfyct9wppyfavv195rn";
        $userId = "codeidea";

        $data = "key=" . $key . "&user_id=" . $userId 
            . "&sender=" . ($sender) . "&receiver=" . ($receiver) . "&msg=" . ($msg) 
            . "&msg_type=SMS&testmode_yn=Y";
    
        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL, 'https://apis.aligo.in/send/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode($data));
        curl_setopt($ch, CURLOPT_POST, 1);
    
        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        $result = curl_exec($ch);
        curl_close ($ch);
    }

    /**
     * fcm 푸시 발송
     * 
     * @param string $title 
     * @param string $msg 
     * @param string $to 
     * @param string $token 
     * @param int $type 
     * @param string $applink 
     * @param string $weblink 
     */
    public function sendPush($title, $msg, $to, $token, $type = 5, $applink = '', $weblink = '')
    {
        $pushMessage = new PushQ;
        $pushMessage->type = 'normal';
        $pushMessage->title = $title;
        $pushMessage->content = $msg;
        $pushMessage->push_info = $msg;
        $pushMessage->send_date = date('Y-m-d H:i:s');
        $pushMessage->send_type = 'S';
        $pushMessage->send_target = $to;
        $pushMessage->is_ad = 0;
        $pushMessage->app_link_type = $type;
        $pushMessage->app_link = $applink;
        $pushMessage->web_link_type = $type;
        $pushMessage->web_link = $weblink;
        $pushMessage->save();

        $data = [
            "notification" => [
                "title" => $title,
                "body"  => $msg,
                "content"  => $msg
            ],
            "priority" =>  "high",
            "data" => [
                "scheme" => $applink,
                "title"  => $title,
                "body"  => $msg,
                "content" => $msg
            ],
            "to" => $token
        ];
    
        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_POST, 1);
    
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=AAAAz0KBYaw:APA91bHlCV092apNbyHu8u6cM23naPxem-Olb3HFNWGlTYCzMMvYD0qwbXFrytIRmd0h0A1GqjjDm3W4HiCTAkfpbSiz0w2qRuOo7GRV2gbajsBIn67W7_h0w0R8FR7MeHSNJ-t4Au4a';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        $result = curl_exec($ch);
        curl_close ($ch);
    }
}
