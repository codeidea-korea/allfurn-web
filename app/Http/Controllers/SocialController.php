<?php

namespace App\Http\Controllers;

use Google\Service\PeopleService\Nickname;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;
use phpseclib3\Crypt\RC2;
use Illuminate\Support\Facades\Log;


class SocialController extends BaseController
{


    public function __construct()
    {
        $this->naver_clientId = env('NAVER_CLIENT_ID');
        $this->naver_clientSecret = env('NAVER_CLIENT_SECRET');
        $this->naver_redirectUri = "http://localhost:8000/social/naver/callback";

        
        $this->google_clientId = env('GOOGLE_CLIENT_ID');
        $this->google_clientSecret = env('GOOGLE_CLIENT_SECRET');
        $this->google_redirectUri = "http://localhost:8000/social/google/callback";
        $this->google_scope = "https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email";

        $this->kakao_clientId = env('KAKAO_CLIENT_ID');
        $this->kakao_redirectUri = "http://localhost:8000/social/kakao/callback";

        $this->apple_clientId = env('APPLE_CLIENT_ID');
        $this->apple_clientSecret = env('APPLE_CLIENT_SECRET');
        $this->apple_redirectUri = "http://localhost:8000/social/apple/callback";

        
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
        Log::info( $url);
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
            return view(getDeviceType() . 'signIn.social');
            // return response()->json(['error' => 'Failed to retrieve access token'], 500);
        }

        //네이버 access_token 쿠키 저장
        setcookie('naver_access_token', $accessToken['access_token'], time() + 3600, '/');

        // 네이버 사용자 정보 요청
        $userResponse = $this->httpGet("https://openapi.naver.com/v1/nid/me", [
            'Authorization: Bearer ' . $accessToken['access_token']
        ]);

        $jsonData = json_decode($userResponse, true);

        // 사용자 정보 요청 실패
        if (!isset($jsonData['response'])) {
            return response()->json(['error' => 'Failed to retrieve user info'], 500);
        }

        return view(getDeviceType() . '/social/naver', ['jsonData' => $jsonData['response']]);
    }

    // HTTP POST 요청
    private function httpPost($url, $data)
    {

        if(env("APP_NAME") === 'ALLFURN_LOCAL') {

            $client = new \GuzzleHttp\Client([
                'verify' => false  // 개발환경에서만 사용
            ]);

            try {
                $response = $client->request('POST', $url, [
                    'form_params' => $data,
                    'headers' => [
                        'Content-Type' => 'application/x-www-form-urlencoded'
                    ]
                ]);

                return $response->getBody()->getContents();
            } catch (\Exception $e) {
                Log::error('HTTP Post Error:', [
                    'message' => $e->getMessage()
                ]);
                throw $e;
            }
        }else{
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);


            $response = curl_exec($ch);
            curl_close($ch);

            return $response;
        }



    }

    // HTTP GET 요청
    private function httpGet($url, $headers = [])
    {


        if(env("APP_NAME") === 'ALLFURN_LOCAL') {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 개발환경에서 SSL 검증 비활성화
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);     // 개발환경에서 호스트 검증 비활성화

            // 상세한 에러 확인을 위한 디버깅 추가
            $response = curl_exec($ch);
            $error = curl_error($ch);
            $info = curl_getinfo($ch);

            if ($error) {
                Log::error('CURL Error:', [
                    'error' => $error,
                    'info' => $info,
                    'url' => $url
                ]);
            }

            curl_close($ch);

            return $response;
        }else{

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);
            curl_close($ch);

            return $response;

        }
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

        //  if (isset($accessToken['access_token'])) {
        //      $tocken = $accessToken['access_token'];
        //  }

        $token = $accessToken['access_token'];


        setcookie('kakao_access_token', $accessToken['access_token'], time() + 3600, '/');

        $userResponse = Http::withHeaders(['Authorization' => "Bearer $token"])->get('https://kapi.kakao.com/v2/user/me');
        Log::info($userResponse);

        if ($userResponse->ok()) {
            $userData =  json_decode($userResponse, true);

            // dd($userData['kakao_account']);
            //  exit;

            // 사용자 이름과 전화번호
            $name = $userData['kakao_account']['name'] ?? '';
            $email = $userData['kakao_account']['email'] ?? '';
            $phoneNumber = $userData['kakao_account']['phone_number'] ?? '';

            //dd($nickname, $email, $phoneNumber);
            //exit;
        } else {
            return response()->json(['error' => 'Failed to retrieve user info'], 500);
        }


        $jsonData = array(
            'name' => $name,
            'email' => $email,
            'mobile' => preg_replace('/^\+82\s?/', '0', $phoneNumber)
        );

        Log::info($jsonData);
        return view(getDeviceType() . '/social/kakao', ['jsonData' => $jsonData]);
    }

    /**
     * 구글 로그인
     */
    public function googleRedirect(): JsonResponse
    {

        $url = "https://accounts.google.com/o/oauth2/v2/auth?response_type=code&client_id={$this->google_clientId}&redirect_uri={$this->google_redirectUri}&scope={$this->google_scope}";

        return response()->json(['url' => $url]);
    }

    public function googleCallback(Request $request)
    {

        $code = $request->get('code');
        Log::info($code);
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

        $accessToken = json_decode($response, true);

        if (!isset($accessToken['access_token'])) {
            return response()->json(['error' => 'Failed to retrieve access token'], 500);
        }

        //$tokenData = $response->json();

        //구글 access_token 쿠키 저장
        setcookie('google_access_token', $accessToken['access_token'], time() + 3600, '/');

        // 2. 사용자 정보 요청 (People API)
        $userInfo = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken['access_token'],
        ])->get('https://people.googleapis.com/v1/people/me', [
            'personFields' => 'names,emailAddresses,phoneNumbers'
        ])->json();

        // HTTP 응답 상태 코드 확인
        Log::info( $userInfo);


        $name = $userInfo['names'][0]['displayName'] ?? null;
        $email = $userInfo['emailAddresses'][0]['value'] ?? null;
        $phone = $userInfo['phoneNumbers'][0]['value'] ?? null;


        $jsonData = array(
            'name' => $name,
            'email' => $email,
            'mobile' => $phone
        );

        return view(getDeviceType() . '/social/google', ['jsonData' => $jsonData]);
    }
}
