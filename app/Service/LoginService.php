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
use DateTime;

class LoginService
{
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

        $url = env('ALLFURN_API_DOMAIN').'/user/send-authcode';
        $response = Http::asForm()->post($url, [
            'data' => '{"type":"'.$param['type'].'", "target":"'.$param['target'].'"}',
        ]);
        Log::info($response->body());
        $body = json_decode($response->body(), true);
        if ($body['code'] === '0') {
            return [
                'success' => true,
                'code' => '20',
                'message' => ''
            ];
        } else {
            return [
                'success' => fail,
                'code' => $body['code'],
                'message' => $body['msg']['ko']
            ];
        }
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
    
    
}
