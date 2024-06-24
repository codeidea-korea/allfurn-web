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
use App\Models\PushToken;
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

    public function index(Request $request)
    {
        $replaceUrl = $request->input('replaceUrl');
        
        if(Auth::check()) {
            if(empty($replaceUrl)) {
                return redirect('/');
            } else {
                return redirect($replaceUrl);
            }
        }
        return view(getDeviceType() . 'login.login', ['replaceUrl' => $replaceUrl]);
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
            // 퍼블 없음 삭제
            /*
            if ( $userInfo->is_owner == 1 && $userInfo->isNeedAgreement > 0 ) {
                return view(getDeviceType() . 'login.login')
                    ->withErrors([
                        'need_terms' => $userInfo->idx,
                    ]);
            } else {
            */
                $this->loginService->getAuthToken($userInfo->idx);

                if ($userInfo->type == "W" && $userInfo->isFirst > 1) {
                    return redirect(getDeviceType() . '/mypage');
                } else {
                    return redirect('/');
                }
//            }
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
            if($user->state != "JS") {
                return response()->json([
                    'result' => 'fail',
                    'code' => 102,
                    'message' => '가입 승인이 되면 로그인이 가능합니다.'
                ]);
            }
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
        if($user->state != "JS") {
            return response()->json([
                'result' => 'fail',
                'code' => 102,
                'message' => '가입 승인이 되면 로그인이 가능합니다.'
            ]);
        }
        $this->loginService->getAuthToken($user->idx);

        return response()->json(['success' => true]);
    }

    /**
     * 액세스 토큰으로 로그인 처리
     * @param Request $request
     * @return Redirect ReWrite uri
     */
    public function signinByAccessToken(Request $request)
    {
        $request->validate([
            'accessToken' => 'required'
        ]);
        return response()->json($this->loginService->signinByAccessToken($request->input('accessToken')));
    }

    public function signOut() {
        PushToken::where('user_idx', Auth::user()['idx'])->update(['expired' => 1]);

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
    
    public function asend(Request $request)
    {
        $templateCode = $request->input('templateCode');
        $title = $request->input('title');
        $replaceParams = $request->input('replaceParams');
        $receiver = $request->input('receiver');
        $reservate = $request->input('reservate');
        
        return response()->json($this->pushService->sendKakaoAlimtalk(
            $templateCode, $title, json_decode($replaceParams, true), $receiver, $reservate));
    }




    

    /**
     * idx 로그인
     * @param Request $request
     * @return JsonResponse
     */
    public function chngIdx(Request $request)
    {
        $request->validate([
            'key' => 'required',
            'idx' => 'required'
        ]);

        Session::flush();
        Auth::logout();

        $this->loginService->getAuthToken($request->input('idx'));

        return response()->json(['success' => true]);
    }
}

