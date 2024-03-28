<?php


namespace App\Service;


use App\Models\LoginHistory;
use App\Models\User;
use App\Models\AuthToken;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use App\Models\UserAuthCode;
use App\Models\PushToken;

use DateTime;
use App\Service\PushService;

class LoginService
{
    private $pushService;

    public function __construct(PushService $pushService)
    {
        $this->pushService = $pushService;
    }

    public function getUserInfo(array $params = [])
    {
        $user = DB::table('AF_user', 'u')
            ->select(DB::raw("u.idx, u.account, u.name, u.type, u.state, u.is_owner,
            IF((select count(*) from AF_user_agreement ag where ag.user_idx = u.idx and ag.is_agree = 1) < 2, 1, 0) AS isNeedAgreement,
            IF((select count(*) from AF_user_access ac where ac.user_idx = u.idx) < 1, 1, 0) AS isFirst"))
            ->where([
                ['u.account', $params['account']],
                ['u.secret', DB::raw("CONCAT('*', UPPER(SHA1(UNHEX(SHA1('".hash('sha256', $params['secret'])."')))))")]
            ])->first();

        return $user;
    }

    public function getAuthToken(string $idx) {
        if ($idx == null) { return null;}

        session()->regenerate();
        $token = hash_hmac('sha256', Str::random(40), 'APP_KEY');
        $session['token'] = $token;

        // token 저장
        AuthToken::insert([
            'user_idx' => $idx,
            'token' => $token,
            'register_time' => DB::raw('now()')
        ]);

        // login history 저장
        LoginHistory::insert([
            'user_idx' => $idx,
            'register_time' => DB::raw('now()')
        ]);

        //로그인 처리
        Auth::loginUsingId($idx);
    }

    public function sendAuth(array $param = []) {
        
        if (!isset($param['type']) || empty($param['type']) || !isset($param['target']) || empty($param['target'])) {
            return [
                'result' => 'fail',
                'code' => 101,
                'message' => '필수항목 없음'
            ];
        }

        $authcode = rand(101013, 987987);
        UserAuthCode::insert([
            'type' => 'S',
            'target' => $param['target'],
            'authcode' => $authcode,
            'is_authorized' => 0,
            'register_time' => DB::raw('now()')
        ]);
        $this->pushService->sendSMS('핸드폰 번호 인증', '올펀 서비스 ['.$authcode.'] 본인확인 인증번호를 입력하세요.', $param['target']);

        return [
            'success' => true,
            'message' => '',
            'target' => $param['target'],
            'authcode' => $authcode
            
        ];
    }

    public function checkAuthCode(array $params = [])
    {
//        Log::info('checkAuthCode params :: '.$params);
        return DB::table('AF_user_authcode')
            ->where([
                'type'=> $params['type'],
                'target'=> $params['target'],
                'authcode'=> $params['code'],
                'is_authorized'=> 0
            ])
//            ->where(DB::raw('register_time > DATE_SUB(NOW(), INTERVAL -5 MINUTE)'))
            ->orderBy('idx', 'desc')
            ->limit(1)
            ->update(['is_authorized'=> 1]);
    }
    
    
    public function getUserById(string $user_id) {
        $user = User::select("*")->where([
                ['account', $user_id]
            ])->first();
        return $user;
    }
    
    public function getUserByPhoneNumber(string $phone_number) {
        $user = User::select("*")->where([
                ['phone_number', $phone_number]
            ])->first();
        return $user;
    }


    /**
     * 사용자 fcm token 갱신
     * 
     * @param string $accessToken
     * @param string $fcmToken
     * @return json array
     */
    public function updateFcmToken($accessToken, $fcmToken): array
    {
        $result = array();
        $result['success'] = false;
        $result['msg'] = '실패';
        $result['code'] = 'EA001';

        if (empty($accessToken)) {
            $result['msg'] = $result['msg'] . ' - accessToken을 확인해주시기 바랍니다.';
            return $result;
        }
        $authToken = AuthToken::where('token', $accessToken)->orderBy('register_time', 'DESC')->first();

        if (empty($authToken)) {
            $result['code'] = 'EA002';
            $result['msg'] = $result['msg'] . ' - accessToken을 확인해주시기 바랍니다.';
            return $result;
        }
        // insert
        $pushToken = new PushToken;
        $pushToken->user_idx = $authToken['user_idx'];
        $pushToken->push_token = $fcmToken;
        $pushToken->save();

        $result['code'] = 'S001';
        $result['success'] = true;
        $result['msg'] = '성공';

        return $result;
    }

    /**
     * 사용자 fcm token 가져오기
     * 
     * @param long $userIdx
     * @return string
     */
    public function getFcmToken($userIdx): string
    {
        $authToken = AuthToken::where('user_idx', $userIdx)->orderBy('register_time', 'DESC')->first();
        return empty($authToken) ? '' : $authToken->token;
    }
}
