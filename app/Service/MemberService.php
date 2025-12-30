<?php

namespace App\Service;

use App\Models\Attachment;
use App\Models\MessageRoom;
use App\Models\Message;
use App\Models\User;
use App\Models\UserAgreement;
use App\Models\UserAuthCode;
use App\Models\UserNormal;
use App\Models\CompanyRetail;
use App\Models\CompanyWholesale;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MemberService
{
    private $pushService;
    
    public function __construct(PushService $pushService)
    {
        $this->pushService = $pushService;
    }

    public function checkEmail(string $email)
    {
        return User::where('account', $email)->where('state', '!=', 'D')->count();
    }

    public function checkPhoneNumber(string $phone_number)
    {
        return User::where('phone_number', $phone_number)->where('state', '!=', 'D')->count();
    }
    
    
    
    public function checkBussinessNumber(string $business_number) {
        
        $whole_cnt = 0;
        $retail_cnt = 0;

        $wholesale = CompanyWholesale::where('business_license_number', $business_number);
        $retail = CompanyRetail::where('business_license_number', $business_number);

        $where = [];
        if (Auth::check()) {
            if(Auth::user()['type'] == 'W') {
                $wholesale = $wholesale->where('idx', '!=', Auth::user()['company_idx']);
            } else if(Auth::user()['type'] == 'R') {
                $retail = $retail->where('idx', '!=', Auth::user()['company_idx']);
            }
        }
        $whole_cnt = $wholesale->count();
        $retail_cnt = $retail->count();
        
        return $whole_cnt+$retail_cnt;
    }
    
    public function createUserNew(array $params = [])
    {
        $user = new User;
        $user->account = $params['email'];
        $user->parent_idx = 0;
        $user->company_idx = $params['companyIdx'];
        $user->secret = null;
        
        if (isset($params['password'])) {
            $user->secret = DB::raw("CONCAT('*', UPPER(SHA1(UNHEX(SHA1('".hash('sha256', $params['password'])."')))))");
        }
        $user->name = $params['name'];
        $user->attachment_idx = array_key_exists('attachmentIdx', $params) ? $params['attachmentIdx'] : 0;
        $user->phone_number = $params['phone_number'];
        $user->state = 'JW';

        $user->type = $params['user_type'];
        $user->join_date = DB::raw('now()');
        $user->is_owner = 1;
        $user->is_undefined_type = 1; // NOTICE: 회원 구분이 신규 회원 가입에 의해 정의되지 않고 등록된 회원인지 구분
        $user->is_delete = 0;
        $user->register_time = DB::raw('now()');
        $user->save();
  
        Log::info("유저 생성 ::".$user->idx);
        $params['idx'] = $user->idx;
        $this->saveAgreement($params);

        // message Room 생성
        $mr = new MessageRoom;
        $mr->first_company_type = 'A';
        $mr->first_company_idx = 1;
        $mr->second_company_type ='N';
        $mr->second_company_idx = $params['companyIdx'];
        $mr->save();

        // CS 메시지 전송
        $ms = new Message;
        $ms->room_idx = $mr->idx;
        $ms->type = 3;
        $ms->sender_company_type = 'A';
        $ms->sender_company_idx = 1;
        $ms->user_idx = NULL;
        $ms->content = '{"type":"welcome","title":"올펀 가입을 축하드립니다.","text":"더 편리한 서비스 이용을 위해 가이드를 확인해보세요!"}';
        $ms->is_read = 1;
        $ms->register_time = DB::raw('NOW()');
        $ms->save();

        return $user->idx;
    }

    public function createUser(array $params = [])
    {
        $user = new User;
        $user->account = $params['email'];
        $user->secret = DB::raw("CONCAT('*', UPPER(SHA1(UNHEX(SHA1('".hash('sha256', $params['password'])."')))))");
        $user->name = $params['name'];
        $user->phone_number = $params['phone'];
        $user->phone_country_number = $params['phone_country_number'];
        $user->state = 'JW';
        $user->type = $params['user_type'];
        $user->join_date = DB::raw('now()');
        $user->register_time = DB::raw('now()');
        $user->parent_idx = 0;
        $user->company_idx = $params['companyIdx'];
        $user->is_owner = 1;
        $user->save();

        Log::info("유저 생성 ::".$user->idx);
        $params['idx'] = $user->idx;
        $this->saveAgreement($params);

        // message Room 생성
        $mr = new MessageRoom;
        $mr->first_company_type = 'A';
        $mr->first_company_idx = 1;
        $mr->second_company_type = $params['user_type'];
        $mr->second_company_idx = $params['companyIdx'];
        $mr->save();

        // CS 메시지 전송
        $ms = new Message;
        $ms->room_idx = $mr->idx;
        $ms->type = 3;
        $ms->sender_company_type = 'A';
        $ms->sender_company_idx = 1;
        $ms->user_idx = NULL;
        $ms->content = '{"type":"welcome","title":"올펀 가입을 축하드립니다.","text":"더 편리한 서비스 이용을 위해 가이드를 확인해보세요!"}';
        $ms->is_read = 1;
        $ms->register_time = DB::raw('NOW()');
        $ms->save();

        return $user->idx;
    }
    public function createCompanyNew(array $params)
    {
        switch ($params['user_type'])
        {
            case "N":
            case "S":
                    $detail = new UserNormal;
                    $detail->name = array_key_exists('company_name', $params) ? $params['company_name'] : $params['name'];
                    $detail->namecard_attachment_idx = $params['attachmentIdx'] ?? null;
                    $detail->phone_number = array_key_exists('user_phone', $params) ? $params['user_phone'] : $params['phone_number'];
                    $detail->register_time = DB::raw('now()');
                    $detail->business_license_number = array_key_exists('business_code', $params) ? $params['business_code'] : '';
                    $detail->owner_name = array_key_exists('owner_name', $params) ? $params['owner_name'] : $params['name'];
                    $detail->is_domestic = 0;
                    $detail->business_address = array_key_exists('business_address', $params) ? $params['business_address'] : '';
                    $detail->business_address_detail = array_key_exists('business_address_detail', $params) ? $params['business_address_detail'] : '';
                    $detail->save();

                    return $detail->getKey();
                break;
                
            case "R":
                $detail = new CompanyRetail;
                $detail->business_license_number = $params['business_code'];
                $detail->business_license_attachment_idx = $params['attachmentIdx'];
                $detail->business_email = $params['email'];
                $detail->company_name = $params['company_name'] ?? null;
                $detail->owner_name = array_key_exists('owner_name', $params) ? $params['owner_name'] : $params['name'];
                $detail->phone_number = array_key_exists('user_phone', $params) ? $params['user_phone'] : $params['phone_number'];
                $detail->is_domestic = 0;
                $detail->business_address = array_key_exists('business_address', $params) ? $params['business_address'] : '';
                $detail->business_address_detail = array_key_exists('business_address_detail', $params) ? $params['business_address_detail'] : '';
                $detail->register_time = DB::raw('now()');
                $detail->save();

                return $detail->getKey();
                break;
            case "W":
                $detail = new CompanyWholesale;
                $detail->business_license_number = $params['business_code'];
                $detail->business_license_attachment_idx = $params['attachmentIdx'];
                $detail->business_email = $params['email'];
                $detail->company_name = $params['company_name'];
                $detail->owner_name = array_key_exists('owner_name', $params) ? $params['owner_name'] : $params['name'];
                $detail->phone_number = array_key_exists('user_phone', $params) ? $params['user_phone'] : $params['phone_number'];
                $detail->is_domestic = 0;
                $detail->business_address = array_key_exists('business_address', $params) ? $params['business_address'] : '';
                $detail->business_address_detail = array_key_exists('business_address_detail', $params) ? $params['business_address_detail'] : '';
                $detail->register_time = DB::raw('now()');
                $detail->save();

                return $detail->getKey();
                break;
        }
    }
    public function modifyCompany(array $params = [])
    {
        switch ($params['user_type'])
        {
            case "N":
            case "S":
                $updated = [
                    'name' => $params['company_name'] ?? null,
                    'phone_number' => $params['phone_number'] ?? null,
                    'business_license_number' => $params['business_code'] ?? null,
                    'owner_name' => $params['owner_name'] ?? null,
                    'business_address' => $params['business_address'] ?? null,
                    'business_address_detail' => $params['business_address_detail'] ?? null,
                ];
                if(array_key_exists('attachmentIdx', $params)) {
                    $updated['namecard_attachment_idx'] = $params['attachmentIdx'];
                }
                UserNormal::where('idx', $params['company_idx'])
                    ->update($updated);
                break;
                
            case "R":
                $updated = [
                    'business_license_number' => $params['business_code'],
                    'business_email' => $params['email'] ?? null,
                    'company_name' => $params['company_name'] ?? null,
                    'owner_name' => $params['owner_name'] ?? null,
                    'phone_number' => $params['phone_number'] ?? null,
                    'business_address' => $params['business_address'] ?? null,
                    'business_address_detail' => $params['business_address_detail'] ?? null,
                ];
                if(array_key_exists('attachmentIdx', $params)) {
                    $updated['business_license_attachment_idx'] = $params['attachmentIdx'];
                }
                CompanyRetail::where('idx', $params['company_idx'])
                    ->update($updated);
                break;
            case "W":
                $updated = [
                    'business_license_number' => $params['business_code'],
                    'business_email' => $params['email'] ?? null,
                    'company_name' => $params['company_name'] ?? null,
                    'owner_name' => $params['owner_name'] ?? null,
                    'phone_number' => $params['phone_number'] ?? null,
                    'business_address' => $params['business_address'] ?? null,
                    'business_address_detail' => $params['business_address_detail'] ?? null,
                ];
                if(array_key_exists('attachmentIdx', $params)) {
                    $updated['business_license_attachment_idx'] = $params['attachmentIdx'];
                }
                CompanyWholesale::where('idx', $params['company_idx'])
                    ->update($updated);
                break;
        }
    }
    public function createCompany(array $params = [])
    {
        switch ($params['userType'])
        {
            case "N":
            case "S":
                    $detail = new UserNormal;
                    // $detail->name = $params['name'];
                    // 사용자 구분이 사업자 외 직원 ( S, N ) 으로 변경됨에 따라, 회사명 넣을 곳이 없어
                    // UserNormal 에 회사명을 삽입함.
                    $detail->name = $params['companyName'];
                    $detail->namecard_attachment_idx = $params['attachmentIdx'];
                    $detail->phone_number = $params['phone'];
                    $detail->register_time = DB::raw('now()');
                    $detail->save();

                    return $detail->idx;
                break;
                
            case "R":
                $detail = new CompanyRetail;
                $detail->business_license_number = $params['businessLicenseNumber'];
                $detail->business_license_attachment_idx = $params['attachmentIdx'];
                $detail->business_email = $params['email'];
                $detail->company_name = $params['companyName'];
                $detail->owner_name = $params['name'];
                $detail->phone_number = $params['phone'];
                $detail->is_domestic = $params['isDomestic'];
                if ($params['isDomestic'] == 1) {
                    $detail->domestic_type = $params['domesticType'];
                    $detail->business_address = $params['address'];
                } else {
                    $detail->business_address = $params['address'];
                }
                $detail->business_address_detail = $params['addressDetail'];
                $detail->register_time = DB::raw('now()');
                $detail->save();

                return $detail->idx;
                break;
            case "W":
                $detail = new CompanyWholesale;
                $detail->business_license_number = $params['businessLicenseNumber'];
                $detail->business_license_attachment_idx = $params['attachmentIdx'];
                $detail->business_email = $params['email'];
                $detail->company_name = $params['companyName'];
                $detail->owner_name = $params['name'];
                $detail->phone_number = $params['phone'];
                $detail->is_domestic = $params['isDomestic'];
                if ($params['isDomestic'] == 1) {
                    $detail->domestic_type = $params['domesticType'];
                } else {
                    $detail->business_address = $params['address'];
                }
                $detail->business_address_detail = $params['addressDetail'];
                $detail->register_time = DB::raw('now()');
                $detail->save();

                return $detail->idx;
                break;
        }
    }

    public function saveAttachment(string $filePath)
    {
        $amt = new Attachment;
        $amt->folder = explode("/", $filePath)[0];
        $amt->filename = explode("/", $filePath)[1];
        $amt->register_time = DB::raw('now()');
        $amt->save();

        return $amt->idx;
    }

    public function saveAgreement(array $param = [])
    {
        $agree = new UserAgreement;
        $agree->updateOrInsert(
            ['user_idx' => $param['idx'], 'agreement_type' => 'T'],
            ['is_agree' => $param['agreementServicePolicy'] ? 1 : 0, 'register_time' => DB::raw('now()')]
        );
        $agree->updateOrInsert(
            ['user_idx' => $param['idx'], 'agreement_type' => 'P'],
            ['is_agree' => $param['agreementPrivacy'] ? 1 : 0, 'register_time' => DB::raw('now()')]
        );
        $agree->updateOrInsert(
            ['user_idx' => $param['idx'], 'agreement_type' => 'M'],
            ['is_agree' => $param['agreementMarketing'] ? 1 : 0, 'register_time' => DB::raw('now()')]
        );
        $agree->updateOrInsert(
            ['user_idx' => $param['idx'], 'agreement_type' => 'I'],
            ['is_agree' => $param['agreementAd'] ? 1 : 0, 'register_time' => DB::raw('now()')]
        );
    }

    public function modifyUser(array $params)
    {
        if(!array_key_exists('user_idx', $params)) {
            $userInfo = User::where('account', $params['user_email'])->where('state', '=', 'JS')->first();
        } else {
            $userInfo = User::where('idx', $params['user_idx'])->first();
        }
        $params['email'] = $params['user_email'];
        
        if($userInfo->type == $params['company_type']) {
            // 회사 정보 수정
            $params['company_idx'] = $userInfo->company_idx;
            $params['user_type'] = $userInfo->type;
            $this->modifyCompany($params);
        } else if($userInfo->type != $params['company_type']) {
            $params['user_type'] = $params['company_type'];

            if(!array_key_exists('attachmentIdx', $params)) {
                if($userInfo->type == 'W') {
                    $params['attachmentIdx'] = CompanyWholesale::where('idx', $userInfo->company_idx)->first()->business_license_attachment_idx;
                } else if($userInfo->type == 'R') {
                    $params['attachmentIdx'] = CompanyRetail::where('idx', $userInfo->company_idx)->first()->business_license_attachment_idx;
                } else {
                    $params['attachmentIdx'] = UserNormal::where('idx', $userInfo->company_idx)->first()->namecard_attachment_idx;
                }
            }
            $company_idx = $this->createCompanyNew($params);

            // 채팅 데이터 이관
            MessageRoom::where('first_company_type', $userInfo->type)
                ->where('first_company_idx', '=', $userInfo->company_idx)
                ->update([
                    'first_company_type' => $params['company_type'],
                    'first_company_idx' => $company_idx
                ]);
            MessageRoom::where('second_company_type', $userInfo->type)
                ->where('second_company_idx', '=', $userInfo->company_idx)
                ->update([
                    'second_company_type' => $params['company_type'],
                    'second_company_idx' => $company_idx
                ]);
            // 종전 사업 구분 만료처리
            if(in_array($params['company_type'], ['S', 'N'])) {
                $expiredCompany = UserNormal::where('idx', $userInfo->company_idx);
            }
            if($params['company_type'] == 'W') {
                $expiredCompany = CompanyWholesale::where('idx', $userInfo->company_idx);
            }
            if($params['company_type'] == 'R') {
                $expiredCompany = CompanyRetail::where('idx', $userInfo->company_idx);
            }
            $expiredCompany->update([
                'is_delete' => 1
            ]);

            $updated = [
                'company_idx' => $company_idx,
                'type' => $params['company_type'],
                'upgrade_at' => date('Y-m-d h:i:s'),
                'is_undefined_type' => 0
//                'state' => 'JW'
            ];
            if(array_key_exists('userAttachmentIdx', $params)) {
                $updated['attachment_idx'] = $params['userAttachmentIdx'];
            }
            if(!array_key_exists('user_idx', $params)) {
                User::where('account', $params['user_email'])
    //                ->where('state', '=', 'JS')
                    ->update($updated);
            } else {
                User::where('idx', $params['user_idx'])
    //                ->where('state', '=', 'JS')
                    ->update($updated);
            }
        }
        // 회원 정보 수정
        $updated = [
            'name' => $params['user_name'],
            'phone_number' => $params['user_phone'],
            'is_undefined_type' => 0
        ];
        if(array_key_exists('userAttachmentIdx', $params)) {
            $updated['attachment_idx'] = $params['userAttachmentIdx'];
        }
        if(!array_key_exists('user_idx', $params)) {
            User::where('account', $params['user_email'])
//                ->where('state', '=', 'JS')
                ->update($updated);
        } else {
            User::where('idx', $params['user_idx'])
//                ->where('state', '=', 'JS')
                ->update($updated);
        }
    }

    

    public function updateUserWait(array $params)
    {
        $updated = [
            'upgrade_status' => 1,
            'upgrade_json' => json_encode($params)
        ];

        $userIdx = 0;
        if (Auth::check()) {
            $userIdx = Auth::user()->idx;
        } else if(array_key_exists('userIdx', $params)) {
            $userIdx = $params['userIdx'];
        }

        User::where('idx', $userIdx)
            ->update($updated);
    }

    public function getDefaultBusinessAttachmentAndNumber() {
        // 기본값 요구 조건 리턴
//        $tmpAttachment = Attachment::find(127132); // DEV
        $tmpAttachment = Attachment::find(176859); // PROD

        return array(
            'attachmentIdx' => $tmpAttachment->idx,
            'bussinessCode' => '0000000000',
            'licenseImage' => preImgUrl() . $tmpAttachment->folder . '/' . $tmpAttachment->filename,
        );
    }

    public function updateUserByWait(int $userIdx, string $grade)
    {
        $user = User::where('idx', $userIdx)->first();

        if(empty($user)) {
            return;
        }

        $param['user_idx'] = $userIdx;
        $param = json_decode($user->upgrade_json,true);
        if($grade != null && isset($grade) && ($grade == 'W' || $grade == 'R')) {
            $param['prev_company_type'] = $param['company_type'];
            $param['user_type'] = $grade;
            $param['company_type'] = $grade;
        }

        if(! array_key_exists('attachmentIdx', $param)) {
            $tmpAttachment = $this->getDefaultBusinessAttachmentAndNumber();
            $param['attachmentIdx'] = $tmpAttachment['attachmentIdx'];
            $param['userAttachmentIdx'] = $tmpAttachment['attachmentIdx'];
            $param['license_image'] = $tmpAttachment['licenseImage'];
        }
        if(! array_key_exists('business_license_number', $param)) {
            $tmpAttachment = $this->getDefaultBusinessAttachmentAndNumber();
            $param['business_license_number'] = $tmpAttachment['bussinessCode'];
        }
        if(! array_key_exists('business_code', $param)) {
            $tmpAttachment = $this->getDefaultBusinessAttachmentAndNumber();
            $param['business_code'] = $tmpAttachment['bussinessCode'];
        }

        $this->modifyUser($param);

        $updated = [
            'upgrade_status' => 3,
            'upgrade_json' => json_encode($param)
        ];
        User::where('idx', $userIdx)
            ->update($updated);

        
        $templateCode = 'UA_3328';
        $title = '서비스 변경 승인 알림';
        $replaceParams = 
                [ 
                    '고객명' => $user->name,
                ];
        $receiver = $user->phone_number;
        $reservate = '';
        $this->pushService->sendKakaoAlimtalk($templateCode, $title, $replaceParams, $receiver, $reservate);
    }


    public function getAddressBook(int $userIdx)
    {
        return UserAddress::where('user_idx', $userIdx)
            ->orderBy('idx', 'desc')
            ->get();
    }

    public function modifyAddressBook(array $param = [])
    {
        UserAddress::where(['idx' => $param['addressIdx'], 'user_idx' => Auth::user()->idx])
            ->update(['phone_number' => $param['phone'], 'name' => $param['name'], 'address1' => $param['address'], 'address2' => $param['addressDetail']]);

        return [
            'success'=>true,
            'message'=>''
        ];
    }

    public function removeAddressBook(int $addressIdx)
    {
        UserAddress::where(['idx'=>$addressIdx,
            'user_idx'=>Auth::user()->idx
        ])
            ->delete();

        return [
            'success' => true,
            'message' => ''
        ];
    }

    public function authCodeCount(array $param = [])
    {
        $cnt = UserAuthCode::where([
            'target'=>$param['account']
            ])
            ->whereDate('register_time', DB::raw('date(now())'))
            ->count();

        return [
            'success' => $cnt < 5 ? true : false
        ];
    }

    public function passwordRequest(array $param = []) {
        
        $res = User::where('AF_user.account', $param['account'])
            ->join('AF_user_authcode as ua', function($query) {
                $query->on('ua.target', 'AF_user.phone_number');
            })
            ->where([
                'ua.authcode'=>$param['code'],
                'ua.is_authorized'=>1,
                'ua.type'=>'S'
            ])
            ->update([
                'AF_user.secret'=>DB::raw("CONCAT('*', UPPER(SHA1(UNHEX(SHA1('".hash('sha256', $param['repw'])."')))))")
            ]);
                
        return [
            'success' => $res == 1 ? true : false
        ];
    }
}
