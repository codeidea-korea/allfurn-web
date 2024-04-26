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
use App\Models\PushToken;
use Google\Client as Google_Client;

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
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_FAILONERROR, true);
    
        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        $result = curl_exec($ch);
//        echo curl_error($ch);
//        echo $result;
        curl_close ($ch);

        return json_decode(preg_replace('/\r|\n/', '\n', preg_replace('/\t/', '\t', $result)));
    }

    /**
     * 알림톡 발송 sendKakaoAlimtalk
     * 
     * @param string $templateCode
     * @param string $replaceParams 대치코드별 값이 들어 있는 연관 배열
     * @param string $receiver (, 로 구분)
     * @param string $reservate 발송 예약일시
     * @return object { code : 0 이 정상, 나머지 오류, message : 연동 메시지 }
     */
    public function sendKakaoAlimtalk($templateCode, $title, $replaceParams, $receiver, $reservate)
    {
        // 템플릿을 템플릿 코드로 조회한다.
        $alimtalkTemplate = $this->getTemplate($templateCode)->list[0];
        if(empty($alimtalkTemplate)) {
            // 템플릿이 없음
            throw new \Exception( "알리고 카카오 알림톡 템플릿 코드 조회 실패 코드 : " . $templateCode, 500 );
        }
        if(!empty($replaceParams) && is_array($replaceParams)) {
            foreach($replaceParams as $key => $value) {
                $alimtalkTemplate->templtContent = str_replace('#{'.$key.'}', $value, $alimtalkTemplate->templtContent);
                $alimtalkTemplate->templtContent = str_replace('#{'.$key.'
                }', $value, $alimtalkTemplate->templtContent);
                $alimtalkTemplate->templtContent = str_replace('#{
                    '.$key.'
                }', $value, $alimtalkTemplate->templtContent);
            }
            foreach($replaceParams as $key => $value) {
                for($idx = 0; $idx < count($alimtalkTemplate->buttons); $idx++) {
                    $alimtalkTemplate->buttons[$idx]->linkMo = str_replace('#{'.$key.'}', $value, $alimtalkTemplate->buttons[$idx]->linkMo);
                    $alimtalkTemplate->buttons[$idx]->linkPc = str_replace('#{'.$key.'}', $value, $alimtalkTemplate->buttons[$idx]->linkPc);
                    
                    $alimtalkTemplate->buttons[$idx]->linkMo = str_replace('#{'.$key.'
                    }', $value, $alimtalkTemplate->buttons[$idx]->linkMo);
                    $alimtalkTemplate->buttons[$idx]->linkPc = str_replace('#{'.$key.'
                    }', $value, $alimtalkTemplate->buttons[$idx]->linkPc);
                    
                    $alimtalkTemplate->buttons[$idx]->linkMo = str_replace('#{
                        '.$key.'
                    }', $value, $alimtalkTemplate->buttons[$idx]->linkMo);
                    $alimtalkTemplate->buttons[$idx]->linkPc = str_replace('#{
                        '.$key.'
                    }', $value, $alimtalkTemplate->buttons[$idx]->linkPc);
                }
            }
        }
//        $alimtalkTemplate->templtContent = nl2br($alimtalkTemplate->templtContent); 

        $apikey = urlencode('eifub09280f6yzfyct9wppyfavv195rn');
        $userid = 'codeidea';
        $token = urlencode($this->generateToken());
        $senderkey = urlencode('a2c2d74285465d194fdbfb2d35aa5d2e59e11e50');
        $tpl_code = urlencode($templateCode);
        $sender = urlencode('010-5440-5414');
        $receiver_1 = urlencode($receiver);
        $subject_1 = rawurlencode($alimtalkTemplate->templtName);
        $message_1 = rawurlencode($alimtalkTemplate->templtContent);
//        $strjson = 

        $button = array();
        $button['name'] = $alimtalkTemplate->buttons[0]->name;
        $button['linkType'] = $alimtalkTemplate->buttons[0]->linkType;
        $button['linkTypeName'] = $alimtalkTemplate->buttons[0]->linkTypeName;
        $button['linkMo'] = $alimtalkTemplate->buttons[0]->linkMo;
        $button['linkPc'] = $alimtalkTemplate->buttons[0]->linkPc;
        $button['linkIos'] = $alimtalkTemplate->buttons[0]->linkIos;
        $button['linkAnd'] = $alimtalkTemplate->buttons[0]->linkAnd;
        $button2 = array();
        $button2['name'] = $alimtalkTemplate->buttons[1]->name;
        $button2['linkType'] = $alimtalkTemplate->buttons[1]->linkType;
        $button2['linkTypeName'] = $alimtalkTemplate->buttons[1]->linkTypeName;
        $button2['linkMo'] = $alimtalkTemplate->buttons[1]->linkMo;
        $button2['linkPc'] = $alimtalkTemplate->buttons[1]->linkPc;
        $button2['linkIos'] = $alimtalkTemplate->buttons[1]->linkIos;
        $button2['linkAnd'] = $alimtalkTemplate->buttons[1]->linkAnd;

        $button_1 = rawurlencode('{"button":['. json_encode($button) . ',' .json_encode($button2) . ']}');
        $failover = 'Y';
        $fsubject_1 = rawurlencode($title);
        $fmessage_1 = rawurlencode($alimtalkTemplate->templtContent);

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

        if(!empty($reservate) && $reservate != '') {
            $data = $data . '&senddate='. urlencode($reservate);
        }
    
//        echo $data;
        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL, 'https://kakaoapi.aligo.in/akv10/alimtalk/send/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
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
     * fcm 푸시 발송 - 테이블 쌓기로 변경
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
        $pushMessage->send_type = 'W';
        $pushMessage->send_target = $to;
        $pushMessage->is_ad = 0;
        $pushMessage->app_link_type = $type;
        $pushMessage->app_link = $applink;
        $pushMessage->web_link_type = $type;
        $pushMessage->web_link = $weblink;
        $pushMessage->is_delete = 0;
        $pushMessage->state = 'W';
        
        $pushMessage->save();
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
        $pushMessage->send_type = 'S';
        $pushMessage->send_target = $to;
        $pushMessage->is_ad = 0;
        $pushMessage->app_link_type = $type;
        $pushMessage->app_link = $applink;
        $pushMessage->web_link_type = $type;
        $pushMessage->web_link = $weblink;
        $pushMessage->is_delete = 0;
        $pushMessage->state = 'W';
        
        $pushMessage->save();
    }
}
