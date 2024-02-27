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
        return view('login.login');
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
            return view('login.login')
                ->withInput($request->only('account'))
                ->withErrors([
                    'not_match' => 'The provided credentials do not match our records.',
                ]);
        } else if ( $userInfo->state == "D") {
            return view('login.login')
                ->withInput($request->only('account'))
                ->withErrors([
                    'withdrawal' => 'withdrawal account.',
                ]);
        } else if ( $userInfo->state != "JS" && $userInfo->state != "UW" ) {
            return view('login.login')
                ->withInput($request->only('account'))
                ->withErrors([
                    'not_approve' => 'use after approve.',
                ]);
        } else {
            if ( $userInfo->is_owner == 1 && $userInfo->isNeedAgreement > 0 ) {
                return view('login.login')
                    ->withErrors([
                        'need_terms' => $userInfo->idx,
                    ]);
            } else {
                $this->loginService->getAuthToken($userInfo->idx);

                if ($userInfo->type == "W" && $userInfo->isFirst > 1) {
                    return redirect('/mypage');
                } else {
                    return redirect('/');
                }
            }
        }
    }

    public function sendAuthCode(Request $request) {
        Log::info("***** LoginController > sendAuthCode :: $request->target");
        $user = $this->loginService->getUserByPhoneNumber($request->target);
        $target = "$user->phone_number";
        Log::info($request->target);
        
        $new_param['target'] = $target;
        $new_param['type'] = $request->type;
        
        return response()->json($this->loginService->sendAuth($new_param));
    }

    /**
     * 인즌번호 처리
     * @param Request $request
     * @return JsonResponse
     */
    public function confirmAuthCode(Request $request) :JsonResponse
    {
        $request->validate([
            'target' => 'required',
            'type' => 'required',
            'code' => 'required',
        ]);

        $user = $this->loginService->getUserById($request->target);
        
        $new_param['target'] = $user->phone_number;
        $new_param['type'] = 'S';
        $new_param['code'] = $request->code;
        
        $confirm = $this->loginService->checkAuthCode($new_param);

        return response()->json([
            'success' => $confirm == 1 ? true : false
        ]);
    }

    public function signOut() {
        Session::flush();
        Auth::logout();

        return Redirect('/');
    }
}

