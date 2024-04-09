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
use App\Models\AlimtalkTemplate;
use App\Models\PushSendLog;
use App\Models\AuthToken as tblAuthToken;

use DateTime;

class PushService
{
    /**
     * 문자 발송
     * 
     * @param string $title
     * @param string $msg
     * @param string $receiver (, 로 구분)
     */
    public function sendSMS($title, $msg, $receiver)
    {
        $pushMessage = new SmsHistory;
        $pushMessage->title = $title;
        $pushMessage->type = 'M';
        $pushMessage->content = $msg;
        $pushMessage->sender = '010-5440-5414';
        $pushMessage->receiver = $receiver;
        $pushMessage->save();


        $key = "eifub09280f6yzfyct9wppyfavv195rn";
        $userId = "codeidea";

        $data = "key=" . $key . "&user_id=" . $userId 
            . "&sender=" . urlencode('010-5440-5414') . "&receiver=" . urlencode($receiver) . "&msg=" . urlencode($msg) 
            . "&msg_type=SMS";
    
        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL, 'https://apis.aligo.in/send/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($data));
        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_FAILONERROR, true);
    
        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        $result = curl_exec($ch);
//        echo curl_error($ch);
//        echo $result;
        curl_close ($ch);
    }

    public function generateToken(): string{
        $apikey = urlencode('eifub09280f6yzfyct9wppyfavv195rn');
        $userid = 'codeidea';
        $data = "apikey=" . $apikey . "&userid=" . $userid;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://kakaoapi.aligo.in/akv10/token/create/30/s/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($data));
        curl_setopt($ch, CURLOPT_POST, 1);
    //        curl_setopt($ch, CURLOPT_FAILONERROR, true);

        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
    //        echo curl_error($ch);
    //        echo $result;
        curl_close ($ch);

        $res = json_decode( $result );
        if($res->code == 0) {
            return $res->token;
        } else {
            throw new \Exception( "알리고 카카오 알림톡 토큰 생성 실패 " . json_encode($res), 500 );
        }
    }

    public function getTemplate($tpl_code = ''): object{
        $apikey = urlencode('eifub09280f6yzfyct9wppyfavv195rn');
        $userid = 'codeidea';
        $token = urlencode($this->generateToken());
        $senderkey = urlencode('a2c2d74285465d194fdbfb2d35aa5d2e59e11e50');

        $data = "apikey=" . $apikey . "&userid=" . $userid . "&token=" . $token . "&senderkey=" . $senderkey
            . "&tpl_code=" . $tpl_code;
    
        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL, 'https://kakaoapi.aligo.in/akv10/template/list/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($data));
        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_FAILONERROR, true);
    
        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        $result = curl_exec($ch);
//        echo curl_error($ch);
//        echo $result;
        curl_close ($ch);

        return json_decode( $result );
    }

    /**
     * 알림톡 발송 sendKakaoAlimtalk
     * 
     * @param string $templateCode
     * @param string $replaceParams 대치코드별 값이 들어 있는 연관 배열
     * @param string $receiver (, 로 구분)
     * @return map { code : 0 이 정상, 나머지 오류, message : 연동 메시지 }
     */
    public function sendKakaoAlimtalk($templateCode, $title, $replaceParams, $receiver): array
    {
        // 템플릿을 템플릿 코드로 조회한다.
        $alimtalkTemplate = getTemplate($templateCode)->list[0];
        if(empty($alimtalkTemplate)) {
            // 템플릿이 없음
            throw new \Exception( "알리고 카카오 알림톡 템플릿 코드 조회 실패 코드 : " . $templateCode, 500 );
        }
        if(!empty($replaceParams) && is_array($replaceParams)) {
            foreach($replaceParams as $key => $value) {
                $alimtalkTemplate->templtContent = str_replace('#{'.$key.'}', $value, $alimtalkTemplate->templtContent);
            }
            foreach($replaceParams as $key => $value) {
                for($idx = 0; $idx < count($alimtalkTemplate->buttons); $idx++) {
                    $alimtalkTemplate->buttons[$idx]->linkMo = str_replace('#{'.$key.'}', $value, $alimtalkTemplate->buttons[$idx]->linkMo);
                    $alimtalkTemplate->buttons[$idx]->linkPc = str_replace('#{'.$key.'}', $value, $alimtalkTemplate->buttons[$idx]->linkPc);
                }
            }
        }

        $apikey = urlencode('eifub09280f6yzfyct9wppyfavv195rn');
        $userid = 'codeidea';
        $token = $this->generateToken();
        $senderkey = urlencode('a2c2d74285465d194fdbfb2d35aa5d2e59e11e50');
        $tpl_code = urlencode($templateCode);
        $sender = urlencode('010-5440-5414');
        $receiver_1 = urlencode($receiver);
        $subject_1 = urlencode($title);
        $message_1 = urlencode($alimtalkTemplate->templtContent);
        $button_1 = urlencode($alimtalkTemplate->buttons);
        $failover = 'Y';
        $fsubject_1 = urlencode($title);
        $fmessage_1 = urlencode($alimtalkTemplate->templtContent);

        $pushMessage = new SmsHistory;
        $pushMessage->title = $title;
        $pushMessage->type = 'A';
        $pushMessage->content = $message_1;
        $pushMessage->sender = '010-5440-5414';
        $pushMessage->receiver = $receiver;
        $pushMessage->save();

        $data = "apikey=" . $apikey . "&userid=" . $userid . "&token=" . $token . "&senderkey=" . $senderkey
            . "&tpl_code=" . $tpl_code . "&sender=" . $sender . "&receiver_1=" . $receiver_1 . "&subject_1=" . $subject_1 . "&message_1=" . $message_1
            . "&button_1=" . $button_1 . "&failover=" . $failover . "&fsubject_1=" . $fsubject_1 . "&fmessage_1=" . $fmessage_1;
    
        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL, 'https://kakaoapi.aligo.in/akv10/alimtalk/send/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($data));
        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_FAILONERROR, true);
    
        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        $result = curl_exec($ch);
//        echo curl_error($ch);
//        echo $result;
        curl_close ($ch);

        return json_decode( $result );
    }

    /**
     * fcm 푸시 발송
     * 
     * @param string $title 
     * @param string $msg 
     * @param string $to 
     * @param int $type 
     * @param string $applink 
     * @param string $weblink 
     */
    public function sendPush($title, $msg, $to, $type = 5, $applink = '', $weblink = '')
    {
        $pushMessage = new PushQ;
        $pushMessage->type = 'push';
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

        $targets = explode(',', $to);
        for($idx = 0; $idx < count($targets); $idx++) {
            $userIdx = $targets[$idx];
            if(empty($userIdx)) {
                continue;
            }
            $authToken = tblAuthToken::where('user_idx', '=', $userIdx)->orderBy('register_time', 'DESC')->first();

            $data = [
                "notification" => [
                    "title" => $title,
                    "body"  => $msg,
                    "content"  => $msg
                ],
                "priority" =>  "high",
                "data" => [
                    "scheme" => $applink,
                    "weburl" => $weblink,
                    "title"  => $title,
                    "body"  => $msg,
                    "content" => $msg
                ],
                "to" => $authToken->token
            ];
        
            $ch = curl_init();
        
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_POST, 1);
        
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key=AAAA4atg0bQ:APA91bFxmF8ZikIdbyfmMt696pCUKHKO-ceoQMubPGSwu-wT0a21fEV45Lvw-27si_NOirum6nn9NmBekPi-xiqlt8NA2lChXZU84oJSiLkrOO5kkSgruBH9jBdDuQ2bwCT_KuOGutQB';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
            $result = curl_exec($ch);
            dd($result);
            
            $sendLog = new PushSendLog();
            $sendLog->user_idx = $userIdx;
            $sendLog->push_idx = $pushMessage->idx;
            $sendLog->push_type = $pushMessage->type;
            $sendLog->is_send = 1;
            $sendLog->is_check = 0;
            $sendLog->send_date = date('Y-m-d H:i:s');
            $sendLog->response = $result;
            $sendLog->save();

            curl_close ($ch);
        }
    }

    /**
     * fcm 푸시 발송 배치 큐 대기
     * 
     * @param string $title 
     * @param string $msg 
     * @param string $to 
     * @param int $type 
     * @param string $applink 
     * @param string $weblink 
     */
    public function sendPushAsync($title, $msg, $to, $type = 5, $applink = '', $weblink = '')
    {
        $pushMessage = new PushQ;
        $pushMessage->type = 'push';
        $pushMessage->title = $title;
        $pushMessage->content = $msg;
        $pushMessage->push_info = $msg;
        $pushMessage->send_date = date('Y-m-d H:i:s');
        $pushMessage->send_type = 'P';
        $pushMessage->send_target = $to;
        $pushMessage->is_ad = 0;
        $pushMessage->app_link_type = $type;
        $pushMessage->app_link = $applink;
        $pushMessage->web_link_type = $type;
        $pushMessage->web_link = $weblink;
        $pushMessage->save();
    }
}
