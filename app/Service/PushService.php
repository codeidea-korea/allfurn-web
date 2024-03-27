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
use App\Models\PushSendLog;
use DateTime;

class PushService
{
    /**
     * fcm 푸시 발송
     * 
     * @param string $fcmToken
     * @return json array
     */
    public function sendPush($title, $msg, $to, $token, $type = 5, $applink = '', $weblink = '')
    {
        $insertValue['type'] = 'normal';

        $insertValue['app_link'] = $link; // "allfurn://alltalk/{$this->idx}";
        $insertValue['web_link'] = $weblink; // "/alltalk/{$this->idx}";


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
                "web_link"  => $weblink,
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
        $headers[] = 'Authorization: key='.FIREBASE_SERVER_KEY;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        $result = curl_exec($ch);
        curl_close ($ch);
    }
}
