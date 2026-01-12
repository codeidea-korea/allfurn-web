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

    public function social(Request $request)
    {
        
        $replaceUrl = $request->input('replaceUrl');
        Log::info("***** LoginController > social :: $replaceUrl");
        if (Auth::check()) {
            if (empty($replaceUrl)) {
                return redirect('/');
            } else {
                return redirect($replaceUrl);
            }
        }
        Log::info(getDeviceType());
        if(getDeviceType() === 'm.'){
            return view(getDeviceType() . 'login.login_social', ['replaceUrl' => $replaceUrl]);
        }
        return view(getDeviceType() . 'login.login_social', ['replaceUrl' => $replaceUrl]);
    }

    public function signupNew(Request $request)
    {
        
        return view(getDeviceType() . 'login.signup_new');
    }
	// js추가
	

	public function signupPending(Request $request)
	{
		$user_name = $request->session()->get('pending_user_name', '고객');
		return view(getDeviceType() . 'login.pending_approval', ['user_name' => $user_name]);
	}

	public function pendingApproval()
	{
		return view(getDeviceType() . 'login.pending_approval');
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
            return view(getDeviceType() . 'login.login_social')
                ->withInput($request->only('account'))
                ->withErrors([
                    'not_match' => 'The provided credentials do not match our records.',
                ]);
        } else if ( $userInfo->state == "D") {
            return view(getDeviceType() . 'login.login_social')
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


     /**
     * 간편 로그인
     * 네이버, 구글, 카카오, 애플
     * @return Response()
     */
    function socialCheckUser(Request $request)
    {
        $request->validate([
            'name' => 'nullable',
            'phone_number' => 'nullable',
            'email' => 'nullable',
            'id' => 'required',
        ]);

//        $phone_number = str_replace("-", "", trim($request->input('phone_number')));
        $phone_number = preg_replace('/(\+82)|^(82)\s?/', '0', trim($request->input('phone_number')));
        $phone_number = preg_replace('/[-]/', '', $phone_number);

        $socialUserData = [
            'name' => urldecode($request->input('name')),
            'email' => $request->input('email'),
            'phone_number' => $phone_number,
            'provider' => $request->input('provider', 'google|naver|kakao'),
            'id' => $request->input('id'),
        ];
        
        $userInfo = $this->loginService->getSocialUserInfo($socialUserData);
        
        // if ($socialUserData['provider'] == "naver") {
        //     $social = new SocialController();
        //     $social->naverLogout($request);
        // }


        // if ($socialUserData['provider'] == "google") {
        //     $social = new SocialController();
        //     $social->googleLogout($request);
        // }

        // if ($socialUserData['provider'] == "kakao") {
        //     $social = new SocialController();
        //     $social->kakaoLogout($request);
        // }
        Log::info("#####################################");
        Log::info($socialUserData);
        Log::info("#####################################");

        if($socialUserData['provider'] == 'kakao' || $socialUserData['provider'] == 'naver') {
            if (empty($phone_number) || $phone_number == '') {
    
                Log::info("전화번호가 없음음");
                return response()->json([
                    'status' => 'error',
                    'redirect' => '/signin',
                    'alert' => 'SNS에서 전화번호를 입력 해주세요.',
                    'script' => 'parent', // 부모 창 제어를 위한 플래그
                    'data'  => $socialUserData,
                    'message' => 'The provided credentials do not match our records.'
                ]);
            }
        }
        
        if (empty($userInfo) ) {

            Log::info("기존 회원 아님");
            return response()->json([
                'status' => 'error',
                'redirect' => route('signup.new'),
                'script' => 'parent', // 부모 창 제어를 위한 플래그
                'data'  => $socialUserData,
                'message' => 'The provided credentials do not match our records.'
            ]);
        } else if ($userInfo->state == "D") {

            return view(getDeviceType() . 'login.login')
            ->withInput($request->only(['name', 'mobile']))
            ->withErrors([
                'withdrawal' => 'withdrawal name.',
            ]);
        } else if ($userInfo->state != "JS" && $userInfo->state != "UW") {

            return view(getDeviceType() . 'login.login')
            ->withInput($request->only(['name', 'mobile']))
            ->withErrors([
                'not_approve' => 'use after approve.',
            ]);
        } else {
            // update all
            $this->loginService->updateSocialUserInfo($socialUserData);

            $count = $this->loginService->countSocialUserInfo($socialUserData);
            if($count > 1) {
                // 이메일 or 전화번호 기준 가입 회원이 n명일 경우 목록 화면으로 보낸다.
                if($socialUserData['provider'] == 'kakao' || $socialUserData['provider'] == 'naver') {
                    return response()->json([
                        'status' => 'success',
                        'redirect' => '/signin/choose-ids?cellphone=' . $phone_number, 
                        'script' => 'parent', // 부모 창 제어를 위한 플래그
                    ]);
                } else {
                    return response()->json([
                        'status' => 'success',
                        'redirect' => '/signin/choose-emails?email=' . $request->input('email'),
                        'script' => 'parent', // 부모 창 제어를 위한 플래그
                    ]);
                }
            }
            $this->loginService->getAuthToken($userInfo->idx);
            if ($userInfo->type == "W" && $userInfo->isFirst > 1) {
                return response()->json([
                    'status' => 'success',
                    'redirect' => '/mypage',
                    'script' => 'parent', // 부모 창 제어를 위한 플래그
                ]);
            } else {
                Log::info("#####################################");
                Log::info(Auth::check());
                Log::info("#####################################");

                return response()->json([
                    'status' => 'success',
                    'redirect' => '/',
                    'script' => 'parent', // 부모 창 제어를 위한 플래그
                ]);
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

        $user = User::whereRaw("REPLACE(phone_number, '-', '') = '".str_replace('-', '', $request->input('phonenumber'))."'")
            ->where('account', '=', $request->input('joinedid'))
            ->where('state', '=', 'JS')
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
     * 이메일로 로그인 처리
     * @param Request $request
     * @return JsonResponse
     */
    public function signinByEmail(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'joinedid' => 'required',
            'code' => 'required',
        ]);
        Log::info("***** LoginController > signinByEmail :: $request->input('email')");

        $user = User::where('account', '=', $request->input('joinedid'))
            ->where('state', '=', 'JS')
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
        try {
            PushToken::where('user_idx', Auth::user()['idx'])->update(['expired' => 1]);

			Auth::logout();
            Session::flush();

        } catch (\Throwable $e) {
        }
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

    // 전화번호로 로그인 시 아이디 목록 조회
    public function chooseLoginIds(Request $request)
    {
        if (Auth::check()) {
            return redirect('/');
        }
        $cellphone = $request->input('cellphone');
        if(empty($cellphone)) {
            return redirect('/signin');
        }
        $users = $this->loginService->getUsersByPhoneNumber($cellphone);
        if(count($users) == 1) {
            $this->loginService->getAuthToken($users[0]->idx);
            return redirect('/');
        }

        return view(getDeviceType() . 'login.choose_login_ids', [
            'users' => $users,
            'cellphone'  => $cellphone
        ]);
    }

    // 이메일로 로그인 시 아이디 목록 조회
    public function chooseLoginEmails(Request $request)
    {
        if (Auth::check()) {
            return redirect('/');
        }
        $email = $request->input('email');
        if(empty($email)) {
            return redirect('/signin');
        }
        $users = $this->loginService->getUsersByEmail($email);
        if(count($users) == 1) {
            $this->loginService->getAuthToken($users[0]->idx);
            return redirect('/');
        }

        return view(getDeviceType() . 'login.choose_login_emails', [
            'users' => $users,
            'email'  => $email
        ]);
    }
}