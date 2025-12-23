<?php

namespace App\Http\Controllers;

use App\Service\LoginService;
use Illuminate\Routing\Controller as BaseController;
use App\Service\MemberService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Session;

use Illuminate\Support\Facades\DB;

class MemberController extends BaseController {
    
    private $memberService;
    private $loginService;

    public function __construct(MemberService $memberService, LoginService $loginService)
    {
        $this->memberService = $memberService;
        $this->loginService = $loginService;
    }

    public function index()
    {
        return view('login.login');
    }

    public function signup()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view(getDeviceType() . 'login.signup');
    }

    /**
     * 등록된 email 검색
     * @param Request $request
     * @return int
     */
    public function checkUsingEmail(Request $request): int
    {
        Log::info("***** MemberController > checkUsingEmail");
        return $this->memberService->checkEmail($request->email);
    }
    
    
    public function checkUsingBusinessNumber(Request $request): int
    {
        Log::info("***** MemberController > checkUsingBusinessNumber : $request->business_number");
        return $this->memberService->checkBussinessNumber($request->business_number);
    }
    
    
    public function duplicateEmail(Request $request): String
    {
        Log::info("***** MemberController > duplicateEmail");
        return $this->memberService->checkEmail($request->check_param);
    }

    
    public function duplicatePhoneNumber(Request $request): String
    {
        Log::info("***** MemberController > duplicatePhoneNumber");
        return $this->memberService->checkPhoneNumber($request->check_param);
    }
    

    /**
     * 인즌번호 처리
     * @param Request $request
     * @return JsonResponse
     */
    public function confirmAuthCode(Request $request): JsonResponse
    {
        $request->validate([
            'target' => 'required',
            'type' => 'required',
            'code' => 'required',
        ]);

        $data = $request->all();
        $confirm = $this->loginService->checkAuthCode($data);

        return response()->json([
            'success' => $confirm == 1 ? true : false
        ]);
    }

    /**
     * 유저생성
     * @param Request $request
     * @return JsonResponse
     */
    public function createUser(Request $request): JsonResponse {
        Log::info("***** MemberController > createUser");
        
        $data = $request->all();
        if ($this->memberService->checkEmail($data['email']) > 0) {
            return response()->json([
                'success' => false,
                'code' => 1001,
                'message' => 'registed email'
            ]);
        }
        
        //이미지 저장
        $storageName = "name-card-image";
        if ($data['userType'] != 'N' && $data['userType'] != 'S') {
            $storageName = 'business-license-image';
        }
        //	$file = $request->file('file')->store($storageName, 's3');
        $stored = Storage::disk('vultr')->put($storageName, $request->file('file'));
        $data['attachmentIdx'] = $this->memberService->saveAttachment($stored);
        $data['companyIdx'] = $this->memberService->createCompany($data);
        $userIdx = $this->memberService->createUser($data);
        
        return response()->json([
            'success' => $userIdx != null ? true : false,
            'message' => ''
        ]);
    }

    public function createUserNew(Request $request): JsonResponse {
        Log::info("***** MemberController > createUserNew");
    
        try {
            // 트랜잭션 시작
            DB::beginTransaction();
            
            $data = $request->all();
            if ($this->memberService->checkEmail($data['email']) > 0) {
                return response()->json([
                    'success' => false,
                    'code' => 1001,
                    'message' => 'registed email'
                ]);
            }
            
            // 이미지 저장
            $storageName = "name-card-image";
            // if ($data['userType'] != 'N' && $data['userType'] != 'S') {
            //     $storageName = 'business-license-image';
            // }
            
            //  $stored = Storage::disk('vultr')->put($storageName, $request->file('file'));
            
            // // DB 작업 시작
            // $data['attachmentIdx'] = $this->memberService->saveAttachment($stored);
            $stored = Storage::disk('vultr')->put($storageName, $request->file('file'));
            $data['attachmentIdx'] = $this->memberService->saveAttachment($stored);
            $data['companyIdx'] = $this->memberService->createCompanyNew($data);
            $userIdx = $this->memberService->createUserNew($data);
            
            if ($userIdx === null) {
                throw new Exception('Failed to create user');
            }
            
            // 모든 작업이 성공적으로 완료되면 커밋
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => ''
            ]);
            
        } catch (Exception $e) {
            // 에러 발생 시 롤백
            DB::rollBack();
            
            // 업로드된 파일이 있다면 삭제
            if (isset($stored)) {
                Storage::disk('vultr')->delete($stored);
            }
            
            Log::error('User creation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user: ' . $e->getMessage()
            ]);
        }
    }


    public function updateUser(Request $request): JsonResponse {
        Log::info("***** MemberController > updateUser");
    
        try {

            // 트랜잭션 시작
            DB::beginTransaction();
            $data = [];
            $data = array_merge($data, $request->all());

            if(array_key_exists('company_file', $data)) {
                $storageName = "name-card-image";
                $stored = Storage::disk('vultr')->put($storageName, $request->file('company_file'));
                $data['attachmentIdx'] = $this->memberService->saveAttachment($stored);
            }
            if(array_key_exists('user_file', $data)) {
                $storageName = "user-image";
                $stored = Storage::disk('vultr')->put($storageName, $request->file('user_file'));
                $data['userAttachmentIdx'] = $this->memberService->saveAttachment($stored);
            }
            $this->memberService->modifyUser($data);
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => ''
            ]);
            
        } catch (Exception $e) {
            // 에러 발생 시 롤백
            
            // 업로드된 파일이 있다면 삭제
            if (isset($stored)) {
                Storage::disk('vultr')->delete($stored);
            }
            
            Log::error('User creation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user: ' . $e->getMessage()
            ]);
        }
    }

    public function updateUserWait(Request $request): JsonResponse {
        Log::info("***** MemberController > updateUserWait");
        try {

            // 트랜잭션 시작
            $data = [];
            $data = array_merge($data, $request->all());
        Log::info("***** data > " . json_encode($data));
/*
            if(array_key_exists('company_file', $data)) {
                $storageName = "name-card-image";
                $stored = Storage::disk('vultr')->put($storageName, $request->file('company_file'));
                $data['attachmentIdx'] = $this->memberService->saveAttachment($stored);
            }
            if(array_key_exists('user_file', $data)) {
                $storageName = "user-image";
                $stored = Storage::disk('vultr')->put($storageName, $request->file('user_file'));
                $data['userAttachmentIdx'] = $this->memberService->saveAttachment($stored);
            }
                */
            $tmpAttachment = $this->memberService->getDefaultBusinessAttachmentAndNumber();

            $data['attachmentIdx'] = $tmpAttachment['attachmentIdx'];
            $data['userAttachmentIdx'] = $tmpAttachment['attachmentIdx'];
            $data['license_image'] = $tmpAttachment['licenseImage'];
            $data['business_license_number'] = $tmpAttachment['bussinessCode'];
            $data['business_code'] = $tmpAttachment['bussinessCode'];

            DB::beginTransaction();
            $this->memberService->updateUserWait($data);
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => json_encode($data)
            ]);
            
        } catch (Exception $e) {
            // 에러 발생 시 롤백
            
            // 업로드된 파일이 있다면 삭제
            if (isset($stored)) {
                Storage::disk('vultr')->delete($stored);
            }
            
            Log::error('User creation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user: ' . $e->getMessage()
            ]);
        }
    }

    public function updateUserByWait(string $grade, int $userIdx): JsonResponse {
        $this->memberService->updateUserByWait($userIdx, $grade);

        return response()->json([
            'success' => true,
            'message' => ''
        ]);
    }

    public function terms()
    {
        return view('login.terms');
    }

    public function saveTerms(Request $request)
    {
        $data = $request->all();

        if ($data['idx'] == '') {
            return back();
        }

        if ($request->input('agreementMarketing') == null) {
            $data['agreementMarketing'] = 0;
        }
        if ($request->input('agreementAd') == null) {
            $data['agreementAd'] = 0;
        }

        $this->memberService->saveAgreement($data);
        $this->loginService->getAuthToken($data['idx']);

        return redirect('/');
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return Redirect('/');
    }

    public function getAddressBook(Request $request)
    {
        $userIdx = $request->input('userIdx') != null ? $request->input('userIdx') : Auth::user()->idx;
        $addressBook = $this->memberService->getAddressBook($userIdx);
        return response()->json([
            'data' => $addressBook
        ]);
    }

    public function modifyAddressBook(Request $request)
    {
        return response()->json($this->memberService->modifyAddressBook($request->all()));
    }

    public function removeAddressBook(int $addressIdx)
    {
        return response()->json($this->memberService->removeAddressBook($addressIdx));
    }

    public function authCodeCount(Request $request)
    {
        return response()->json($this->memberService->authCodeCount($request->all()));
    }

    public function passwordRequest(Request $request) {
        
        Log::info("***** MemberController > passwordRequest");
        
        return response()->json($this->memberService->passwordRequest($request->all()));
    }
}
