<?php

namespace App\Http\Controllers;

use App\Service\CommunityService;
use App\Service\LoginService;
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

class LoginController extends BaseController
{
    private $loginService;
    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function index()
    {
        if(Auth::check()) {
            return redirect('/');
        }
        return view(getDeviceType() . 'login.login');
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
        Log::info("***** LoginController > sendAuthCode :: $request->target");
        $user = $this->loginService->getUserByPhoneNumber($request->target);

        if(empty($user)) {
            return response()->json([
                'result' => 'fail',
                'code' => 102,
                'message' => '해당 번호로 가입된 회원 없음'
            ]);
        }

        $target = "$user->phone_number";
        Log::info($request->target);
        
        $new_param['target'] = $target;
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
            'target' => 'required',
            'type' => 'required',
            'code' => 'required',
        ]);

        $user = $this->loginService->getUserByPhoneNumber($request->target);

        if(empty($user)) {
            return response()->json([
                'success' => false,
                'code' => 102,
                'message' => '해당 번호로 가입된 회원 없음'
            ]);
        }
        
        $new_param['target'] = $user->phone_number;
        $new_param['type'] = 'S';
        $new_param['code'] = $request->code;
        
        $confirm = $this->loginService->checkAuthCode($new_param);

        if($confirm == 1) {
            $this->loginService->getAuthToken($user->idx);
        }

        return response()->json([
            'success' => $confirm == 1 ? true : false
        ]);
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
}

