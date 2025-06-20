<?php

namespace App\Http\Controllers;

use Google\Service\PeopleService\Nickname;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;
use phpseclib3\Crypt\RC2;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Service\MemberService;

class SocialController extends BaseController
{
    protected $memberService;

	public function __construct(MemberService $memberService)
    {
		$this->memberService = $memberService;

        $this->naver_clientId = env('NAVER_CLIENT_ID');
        $this->naver_clientSecret = env('NAVER_CLIENT_SECRET');
        $this->naver_redirectUri = env('APP_URL') . "/social/naver/callback";

        $this->google_clientId = env('GOOGLE_CLIENT_ID');
        $this->google_clientSecret = env('GOOGLE_CLIENT_SECRET');
        $this->google_redirectUri = env('APP_URL') . "/social/google/callback";
        $this->google_scope = "https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email";

        $this->kakao_clientId = env('KAKAO_CLIENT_ID');
        $this->kakao_redirectUri = env('APP_URL') . "/social/kakao/callback";

        $this->apple_clientId = env('APPLE_CLIENT_ID');
        $this->apple_clientSecret = env('APPLE_CLIENT_SECRET');
        $this->apple_redirectUri = env('APP_URL') . "/social/apple/callback";
		
        $envType = env('ENV_TYPE');
        if($envType == 'DEV') {
            
            $this->naver_clientId = env('DEV_NAVER_CLIENT_ID');
            $this->naver_clientSecret = env('DEV_NAVER_CLIENT_SECRET');
            $this->naver_redirectUri = env('DEV_APP_URL') . "/social/naver/callback";

            $this->kakao_clientId = env('DEV_KAKAO_CLIENT_ID');
            $this->kakao_redirectUri = env('DEV_APP_URL') . "/social/kakao/callback";
        }
    } 

    /**
     * 소셜 로그인 Naver
     * @param Request $request
     * @return View
     */

    function naverRedirect(): JsonResponse
    {
        $state = bin2hex(random_bytes(16));
        session(['naver_state' => $state]);

        $url = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id={$this->naver_clientId}&redirect_uri={$this->naver_redirectUri}&state={$state}";
        return response()->json(['url' => $url]);
    }

    function naverCallback(Request $request)
    {
        $state = $request->input('state');
        $code = $request->input('code');

        // CSRF 검증
        if ($state !== session('naver_state')) {
            return response()->json(['error' => 'Invalid state'], 400);
        }

        // 네이버 토큰 요청
        $url = "https://nid.naver.com/oauth2.0/token";
        $params = [
            'grant_type' => 'authorization_code',
            'client_id' => $this->naver_clientId,
            'client_secret' => $this->naver_clientSecret,
            'redirect_uri' => $this->naver_redirectUri,
            'code' => $code,
            'state' => $state
        ];
        try {
            // GET이 아닌 POST 메소드 사용
            $response = $this->httpPost($url, $params);
            if (empty($response)) {
                Log::error('Empty response received from Naver');
                throw new \Exception('Empty response from Naver OAuth server');
            }
        } catch (\Exception $e) {
            Log::error('Naver Token Request Error:', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
        $accessToken = json_decode($response, true);

        if (!isset($accessToken['access_token'])) {
            return view(getDeviceType() . 'login.login_social');
            // return response()->json(['error' => 'Failed to retrieve access token'], 500);
        }
        //네이버 access_token 쿠키 저장
        setcookie('naver_access_token', $accessToken['access_token'], time() + 3600, '/');
     
        // 네이버 사용자 정보 요청
        $userResponse = $this->httpGet("https://openapi.naver.com/v1/nid/me", [
            'Authorization' => 'Bearer ' . $accessToken['access_token']
        ]);
        $jsonData = json_decode($userResponse, true);

        if (isset($jsonData['response']['mobile'])) {
            $jsonData['response']['phone_number'] = $jsonData['response']['mobile'];
            unset($jsonData['response']['mobile']);
        }
        // 사용자 정보 요청 실패
        if (!isset($jsonData['response'])) {
            return response()->json(['error' => 'Failed to retrieve user info'], 500);
        }
        $jsonData['response']['provider'] = 'naver';
		//js추가
	    $phoneNumber = preg_replace('/^\+82\s?/', '0', $jsonData['response']['phone_number'] ?? '') ?? 'none';
		$user = User::where('account', $jsonData['response']['email'] ?? '')
//			->orWhere('phone_number', $jsonData['response']['phone_number'] ?? '')
			->orWhereRaw("REPLACE(phone_number, '-', '') = '".str_replace('-', '', $phoneNumber)."'")
			->first();
        $this->saveSnsHistory($jsonData['response']);
		
		// 사용자가 존재하고 승인 대기 상태인 경우
		if ($user && $user->state === 'JW') {
			// 세션에 사용자 이름 저장
			$request->session()->put('pending_user_name', $user->name);
			
			$pendingUrl = route('login.pending');
			
			return response()->view('login.social_redirect', [
				'redirect_url' => $pendingUrl
			]);
		}

        return view(getDeviceType() . '/social/social', ['jsonData' => $jsonData['response']]);
    }


    function naverLogout(Request $request)
    {
        $accessToken = $_COOKIE['naver_access_token'] ?? null;

        // 네이버 토큰 요청
        $url = "https://nid.naver.com/oauth2.0/token";
        $response = $this->httpPost($url, [
            'grant_type' => 'delete',
            'client_id' => $this->naver_clientId,
            'client_secret' => $this->naver_clientSecret,
            'access_token' => $accessToken,
            'service_provider' => 'NAVER'
        ]);

        return $response;
    }

    function googleLogout(Request $request)
    {
        $accessToken = $_COOKIE['google_access_token'] ?? null;

        // 네이버 토큰 요청
        $url = "https://oauth2.googleapis.com/revoke";
        $response = $this->httpPost($url,[
            'token' => $accessToken
        ]);
        Log::info($response);

        return $response;
    }

    function kakaoLogout(Request $request)
    {
        $accessToken = $_COOKIE['kakao_access_token'] ?? null;

        $url = "https://kapi.kakao.com/v1/user/unlink";
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken
        ])->post($url);
        Log::info("kakao logout");
        Log::info($response);

        return $response;
    }
    // 카카오 로그인
    public function kakaoRedirect(): JsonResponse
    {
        // Log::info("kakao redirect");
        $state = bin2hex(random_bytes(16));
        session(['kakao_state' => $state]);
        //  카카오 로그인 URL
        $url = "https://kauth.kakao.com/oauth/authorize?response_type=code&client_id={$this->kakao_clientId}&redirect_uri={$this->kakao_redirectUri}&state={$state}";
		
        return response()->json(['url' => $url]);
    }
 
    public function kakaoCallback(Request $request)
    {
        Log::info("kakao callback");
        $code = $request->get('code');

        if (!$code) {
            return response()->json(['error' => 'Authorization code is missing.']);
        }
        // Access Token 요청
        $url = "https://kauth.kakao.com/oauth/token";
        $response = $this->httpPost($url, [
            'grant_type' => 'authorization_code',
            'client_id' => $this->kakao_clientId,
            'redirect_uri' => $this->kakao_redirectUri,
            'code' => $code
        ]);
        $accessToken = json_decode($response, true);
        // Log::info(  $accessToken);
        setcookie('kakao_access_token', $accessToken['access_token'], time() + 3600, '/');

        $userResponse = $this->httpPostWithHeader(
            "https://kapi.kakao.com/v2/user/me",
            [
                'Authorization' => 'Bearer ' . $accessToken['access_token'],
                'Content-Type' => 'application/x-www-form-urlencoded;charset=utf-8',
                'timeout' => 5,
                'connect_timeout' => 10,
            ],
            []
        );
        $userData =  json_decode($userResponse, true);

        // 사용자 이름과 전화번호
        $name = $userData['kakao_account']['name'] ?? $userData['kakao_account']['profile']['nickname'];
        $has_email = $userData['kakao_account']['has_email'];
        $has_phone_number = $userData['kakao_account']['has_phone_number'];
        $email = $userData['kakao_account']['email'] ?? '';
        $phoneNumber = $userData['kakao_account']['phone_number'] ?? '';

        if($has_email) {
            // 사용자 동의 시 email 제공 가능한 경우
            $jsonData = array(
                'name' => $name,
                'email' => $email,
                'phone_number' => preg_replace('/^\+82\s?/', '0', $phoneNumber),
                'provider' => 'kakao',
                'id' => $userData['id']
            );
		
            // 회원 상태 확인 - 여기서는 jsonData 배열 구조를 직접 사용
            $user = User::where(function($query) use($jsonData) {
                    $query->where('account', $jsonData['email'])
                        ->orWhereRaw("REPLACE(phone_number, '-', '') = REPLACE('".$jsonData['phone_number']."', '-', '')");
                })
                ->where('state', 'JS')
                ->first();
            $this->saveSnsHistory($jsonData);

        } else if($has_phone_number) {
            // 사용자 동의 시 phone_number 제공 가능한 경우
            $jsonData = array(
                'name' => $name,
                'email' => $email,
                'phone_number' => preg_replace('/^\+82\s?/', '0', $phoneNumber),
                'provider' => 'kakao',
                'id' => $userData['id']
            );
		
            // 회원 상태 확인 - 여기서는 jsonData 배열 구조를 직접 사용
            $user = User::where("REPLACE(phone_number, '-', '') = REPLACE('".$jsonData['phone_number']."', '-', '')")
                ->where('state', 'JS')
                ->first();
            $this->saveSnsHistory($jsonData);
        }
		// 사용자가 존재하고 승인 대기 상태인 경우
		if ($user && $user->state === 'JW') {
			// 세션에 사용자 이름 저장
			$request->session()->put('pending_user_name', $user->name);
			
			$pendingUrl = route('login.pending');
			
			return response()->view('login.social_redirect', [
				'redirect_url' => $pendingUrl
			]);
		}
        Log::info('Parsed User Data:', $jsonData);

        return view(getDeviceType() . '/social/social', ['jsonData' => $jsonData]);
    }

    /**
     * 구글 로그인
     */
    public function googleRedirect(): JsonResponse
    {
        $url = "https://accounts.google.com/o/oauth2/v2/auth?response_type=code&client_id={$this->google_clientId}&redirect_uri={$this->google_redirectUri}&scope={$this->google_scope}";
        return response()->json(['url' => $url]);
    }

    public function commonCallback(Request $request){
        
        $jsonData = [
            'name' => $request->name,
            'email' => $request->email, 
            'phone_number' => $request->phone_number,
            'provider' => $request->social,
            'id' => $request->id
        ];
        $this->saveSnsHistory($jsonData);

        return view(getDeviceType() . '/social/social', ['jsonData' => $jsonData]);
    }
    public function googleCallback(Request $request)
    {
        $code = $request->get('code');

        if (!$code) {
            return response()->json(['error' => 'Authorization code is missing.']);
        }
        // Access Token 요청
        $url = "https://accounts.google.com/o/oauth2/token";
        $response = $this->httpPost($url, [
            'grant_type' => 'authorization_code',
            'client_id' => $this->google_clientId,
            'client_secret' => $this->google_clientSecret,
            'redirect_uri' => $this->google_redirectUri,
            'code' => $code
        ]);
        Log::info("#####################################################");
        $accessToken = json_decode($response, true);

        if (!isset($accessToken['access_token'])) {
            return response()->json(['error' => 'Failed to retrieve access token'], 500);
        }
        //$tokenData = $response->json();

        //구글 access_token 쿠키 저장
        setcookie('google_access_token', $accessToken['access_token'], time() + 3600, '/');

        Log::info($accessToken['access_token']);

        // 구글 사용자 정보 요청
        $userResponse = $this->httpGet(
            "https://people.googleapis.com/v1/people/me",
            [
                'Authorization' => 'Bearer ' . $accessToken['access_token']
            ],
            ['personFields' => 'names,emailAddresses,phoneNumbers']
        );

        $userInfo = json_decode($userResponse, true);

        Log::info('Google User Response:', $userInfo);
        $id = '';
        if (isset($userInfo['resourceName'])) {
            // 'people/' 이후의 숫자 추출
            $matches = [];
            if (preg_match('/people\/(\d+)/', $userInfo['resourceName'], $matches)) {
                $id =  $matches[1];
            }
        }
        $jsonData = [
           'name' => $userInfo['names'][0]['displayName'] ?? null,
           'email' => $userInfo['emailAddresses'][0]['value'] ?? null, 
           'phone_number' => $userInfo['phoneNumbers'][0]['value'] ?? null,
           'provider' => 'google',
           'id' => $id
        ];
        Log::info('Parsed User Data:', $jsonData);
        $this->saveSnsHistory($jsonData);

        return view(getDeviceType() . '/social/social', ['jsonData' => $jsonData]);
    }

    private function saveSnsHistory($jsonData){
        
        // NOTICE: sns 로그인에 성공하면 히스토리에 적재합니다.
		$sns_interface = DB::table('AF_sns_interface')
            ->where([
                'provider' => $jsonData['provider'],
                'social_id' => $jsonData['id']
            ]);
        $infoData = [];

        if(!empty($jsonData['name']) && $jsonData['name'] != '') {
            $infoData['name'] = $jsonData['name'];
        }
        if(!empty($jsonData['email']) && $jsonData['email'] != '') {
            $infoData['email'] = $jsonData['email'];
//            array_merge($infoData, array('email' => $jsonData['email']));
        }
        if(!empty($jsonData['phone_number']) && $jsonData['phone_number'] != '') {
            $phone_number = preg_replace('/(\+82)|^(82)\s?/', '0', trim($jsonData['phone_number']));
            $phone_number = preg_replace('/[-]/', '', $phone_number);
            $infoData['phone_number'] = $phone_number;

//            array_merge($infoData, array('phone_number' => $phone_number));
        }
        $userCount = $sns_interface->count();
        if($userCount > 0) {
            // 한번이라도 로그인을 한 적있는 고객은 업데이트를 합니다.
            $sns_interface->update($infoData);
        } else {
            DB::table("AF_sns_interface")->insert([
                'provider' => $jsonData['provider'], 
                'social_id' => $jsonData['id'], 
                'name' => $jsonData['name'] ?? '', 
                'email' => $jsonData['email'] ?? '', 
                'phone_number' => $jsonData['phone_number'] ?? '', 
            ]);
        }
    }
    // HTTP POST 요청
    private function httpPost($url, $data)
    {
        if(env("APP_NAME") === 'ALLFURN_LOCAL') {
            $client = new \GuzzleHttp\Client([
                'verify' => false  // 개발환경에서만 사용
            ]);
        }else{
            $client = new \GuzzleHttp\Client([
                'verify' => true  // 개발환경에서만 사용
            ]);
        }
        try {
            $response = $client->request('POST', $url, [
                'form_params' => $data,
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded;charset=utf-8'
                ],
                'timeout' => 5,
                'connect_timeout' => 10,
            ]);
            return $response->getBody()->getContents();
        } catch (\Exception $e) {
            Log::error('HTTP Post Error:', [
                'message' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    // HTTP POST option 요청
    private function httpPostWithHeader($url, $headers = [], $query = [])
    {
        if(env("APP_NAME") === 'ALLFURN_LOCAL') {
            $client = new \GuzzleHttp\Client([
                'verify' => false  // 개발환경에서만 사용
            ]);
        }else{
            $client = new \GuzzleHttp\Client([
                'verify' => true  // 개발환경에서만 사용
            ]);
        }
        try {
            $options = [
                'headers' => $headers
            ];
            // query 파라미터가 비어있지 않은 경우에만 추가
            if (!empty($query)) {
                $options['query'] = $query;
            }
            $response = $client->request('POST', $url, $options);
            return $response->getBody()->getContents();
        } catch (\Exception $e) {
            Log::error('HTTP Post Error:', [
                'message' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    // HTTP GET 요청
    private function httpGet($url, $headers = [], $query = [])
    {
        if(env("APP_NAME") === 'ALLFURN_LOCAL') {
            $client = new \GuzzleHttp\Client([
                'verify' => false  // 개발환경에서만 사용
            ]);
        }else{
            $client = new \GuzzleHttp\Client([
                'verify' => true  // 개발환경에서만 사용
            ]);
        }
        try {
            $options = [
                'headers' => $headers
            ];
            // query 파라미터가 비어있지 않은 경우에만 추가
            if (!empty($query)) {
                $options['query'] = $query;
            }
            $response = $client->request('GET', $url,$options);
            return $response->getBody()->getContents();
        } catch (\Exception $e) {
            Log::error('HTTP Post Error:', [
                'message' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
