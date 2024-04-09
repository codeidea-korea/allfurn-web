<?php

namespace App\Http\Controllers;

use App\Service\CommunityService;
use App\Service\LoginService;
use App\Service\MemberService;
use App\Service\PushService;
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
use Session;
use Google\Client as Google_Client;
use App\Models\AuthToken as tblAuthToken;
use App\Models\PushSendLog;

class LoginController extends BaseController
{
    private $loginService;
    private $memberService;
    private $pushService;
    public function __construct(LoginService $loginService, MemberService $memberService, PushService $pushService)
    {
        $this->loginService = $loginService;
        $this->memberService = $memberService;
        $this->pushService = $pushService;
    }

    public function index()
    {
        if(Auth::check()) {
            return redirect('/');
        }
        return view(getDeviceType() . 'login.login');
    }

    public function findid()
    {
        if(Auth::check()) {
            return redirect('/');
        }
        return view(getDeviceType() . 'login.findid');
    }

    public function findpw()
    {
        if(Auth::check()) {
            return redirect('/');
        }
        return view(getDeviceType() . 'login.findpw');
    }

    public function signupcomplete()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view(getDeviceType() . 'login.signupcomplete');
    }

    /**
     * 로그인
     * @return Response()
     */
    public function checkUser(Request $request)
    {
        $request->validate([
            'account' => 'required',
            'secret' => 'required',
        ]);

        $data['account'] = $request->input('account');
        $data['secret'] = $request->input('secret');

        $userInfo = $this->loginService->getUserInfo($data);

        if (empty($userInfo)) {
            return view(getDeviceType() . 'login.login')
                ->withInput($request->only('account'))
                ->withErrors([
                    'not_match' => 'The provided credentials do not match our records.',
                ]);
        } else if ( $userInfo->state == "D") {
            return view(getDeviceType() . 'login.login')
                ->withInput($request->only('account'))
                ->withErrors([
                    'withdrawal' => 'withdrawal account.',
                ]);
        } else if ( $userInfo->state != "JS" && $userInfo->state != "UW" ) {
            return view(getDeviceType() . 'login.login')
                ->withInput($request->only('account'))
                ->withErrors([
                    'not_approve' => 'use after approve.',
                ]);
        } else {
            if ( $userInfo->is_owner == 1 && $userInfo->isNeedAgreement > 0 ) {
                return view(getDeviceType() . 'login.login')
                    ->withErrors([
                        'need_terms' => $userInfo->idx,
                    ]);
            } else {
                $this->loginService->getAuthToken($userInfo->idx);

                if ($userInfo->type == "W" && $userInfo->isFirst > 1) {
                    return redirect(getDeviceType() . '/mypage');
                } else {
                    return redirect('/');
                }
            }
        }
    }

    public function sendAuthCode(Request $request) {
        Log::info("***** LoginController > sendAuthCode :: $request->input('target')");
        $isUser = true;
        if(($request->has('target'))) {
            $user = $this->loginService->getUserByPhoneNumber($request->input('target'));
        } else if(($request->has('userid'))) {
            $user = $this->loginService->getUserById($request->input('userid'));
        } else if(($request->has('phoneno'))) {
            $isUser = false;
        }
        if($isUser && empty($user)) {
            return response()->json([
                'result' => 'fail',
                'code' => 102,
                'message' => '해당 번호로 가입된 회원 없음'
            ]);
        }

        if($isUser) {
            $target = "$user->phone_number";
            Log::info($request->target);
            
            $new_param['target'] = $target;
        } else {
            $new_param['target'] = $request->input('phoneno');
        }
        $new_param['type'] = $request->type;
        
        return response()->json($this->loginService->sendAuth($new_param));
    }

    /**
     * 인증번호 처리
     * @param Request $request
     * @return JsonResponse
     */
    public function confirmAuthCode(Request $request)
    {
        $request->validate([
//            'target' => 'required',
            'type' => 'required',
            'code' => 'required',
        ]);
        Log::info("***** LoginController > sendAuthCode :: $request->input('target')");
        $isUser = true;
        if($request->has('target')) {
            $user = $this->loginService->getUserByPhoneNumber($request->input('target'));
        } else if($request->has('userid')) {
            $user = $this->loginService->getUserById($request->input('userid'));
        } else if(($request->has('phoneno'))) {
            $isUser = false;
        }
        if($isUser && empty($user)) {
            return response()->json([
                'result' => 'fail',
                'code' => 102,
                'message' => '해당 번호로 가입된 회원 없음'
            ]);
        }
        
        $users = [];
        if($isUser) {
            $new_param['target'] = $user->phone_number;
            $users = $this->loginService->getUsersByPhoneNumber($user->phone_number);
        } else {
            $new_param['target'] = $request->input('phoneno');
        }
        $new_param['type'] = $request->type;
        $new_param['code'] = $request->code;
        
        $confirm = $this->loginService->checkAuthCode($new_param);
/*
        if($confirm == 1 && $request->type == 'A') {
            $this->loginService->getAuthToken($user->idx);
        }
*/
        return response()->json([
            'success' => $confirm == 1 ? true : false,
            'users' => $users
        ]);
    }

    /**
     * 전화번호 로그인 처리
     * @param Request $request
     * @return JsonResponse
     */
    public function signinAuthCode(Request $request)
    {
        $request->validate([
            'phonenumber' => 'required',
            'joinedid' => 'required',
            'code' => 'required',
        ]);
        Log::info("***** LoginController > signinAuthCode :: $request->input('phonenumber')");

        $user = User::where('phone_number', '=', $request->input('phonenumber'))
            ->where('account', '=', $request->input('joinedid'))
            ->first();

        if(empty($user)) {
            return response()->json([
                'result' => 'fail',
                'code' => 102,
                'message' => '해당 번호로 가입된 회원 없음'
            ]);
        }
        $this->loginService->getAuthToken($user->idx);

        return response()->json(['success' => true]);
    }

    public function signOut() {
        Session::flush();
        Auth::logout();

        return Redirect('/signin');
    }
    

    /**
     * 사용자 fcm token 갱신
     * @return JsonResponse()
     */
    public function updateFcmToken(Request $request)
    {
        $result = array();
        $result['success'] = false;
        $result['msg'] = '실패';
        $result['code'] = 'E0001';

        if (!$request->expectsJson()) {
            $result['msg'] = $result['msg'] . ' - json 형식으로 보내주시기 바랍니다.';
        }
        $accessToken = $request->bearerToken();
        $fcmToken = $request->input('token');

        return response()->json($this->loginService->updateFcmToken($accessToken, $fcmToken));
    }
    
    /**
     * 사용자 비밀번호 갱신
     * @return JsonResponse()
     */
    public function updatePassword(Request $request)
    {
        $userid = $request->input('userid');
        $w_userpw = $request->input('userpw');
        $smscode = $request->input('smscode');

        return response()->json($this->memberService->passwordRequest([
            'account' => $userid,
            'code' => $smscode,
            'repw' => $w_userpw
        ]));
    }
    
    public function getTemplates(Request $request)
    {
        $templateCode = $request->input('templateCode');

        // push 테스트
        echo '\n\n\n\n@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@\n\n';


        $title = 'TEST push';
        $msg = 'TEST 123';
        $to = "3380,";
        $applink = "/";
        $weblink = "/";

        
        $scope = 'https://www.googleapis.com/auth/firebase.messaging';

        $client = new Google_Client();
        $client->setAuthConfig('/var/www/allfurn-web/fcm.json');
        $client->setScopes($scope);
        $auth_key = $client->fetchAccessTokenWithAssertion();

        $targets = explode(',', $to);
        for($idx = 0; $idx < count($targets); $idx++) {
            $userIdx = $targets[$idx];
            if(empty($userIdx)) {
                continue;
            }
            $authToken = tblAuthToken::where('user_idx', '=', $userIdx)->orderBy('register_time', 'DESC')->first();

            $data = [
                "message": {
                    "token": $authToken->token,
                    "notification": {
                        "title": $title,
                        "body": $msg
                    },
                    "data": {
                        "scheme" => $applink,
                        "weburl" => $weblink,
                        "title"  => $title,
                        "body"  => $msg,
                        "content" => $msg
                    },
                    "android": {
                        "notification": {
                            "click_action": "TOP_STORY_ACTIVITY"
                        }
                    },
                    "apns": {
                        "payload": {
                            "aps": {
                                "category" : "NEW_MESSAGE_CATEGORY"
                            }
                        }
                    }
                }
            ];
        
            $ch = curl_init();
        
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/allfurn-e0712/messages:send');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_POST, 1);
        
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: Bearer ' . $auth_key['access_token'];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
            $result = curl_exec($ch);
            
            $sendLog = new PushSendLog();
            $sendLog->user_idx = $userIdx;
            $sendLog->push_idx = 1;
            $sendLog->push_type = 'S';
            $sendLog->is_send = 1;
            $sendLog->is_check = 0;
            $sendLog->send_date = date('Y-m-d H:i:s');
            $sendLog->response = $result;
            $sendLog->save();

            curl_close ($ch);
        }

        // 알림톡 테스트
        echo '\n\n\n\n@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@\n\n';

        $data = "templateCode=" . urlencode('TS_1850')
            . "&title=" . urlencode('회원가입이 승인되었습니다')
            . "&replaceParams=" . urlencode(json_encode([
                '고객명' => urlencode('리넷')
            ]))
            . "&receiver=" . urlencode('01077564321');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://allfurn-web.codeidea.io/allimtalk/send');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($data));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);

        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        echo curl_error($ch);
        echo '\n';
        echo $result;
        echo '\n';
        curl_close ($ch);
        echo '\n\n\n\n@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@\n\n';
    }
    
    public function asend(Request $request)
    {
        $templateCode = $request->input('templateCode');
        $title = $request->input('title');
        $replaceParams = $request->input('replaceParams');
        $receiver = $request->input('receiver');

        return response()->json($this->pushService->sendKakaoAlimtalk(
            $templateCode, $title, json_decode($replaceParams), $receiver));
    }
}

