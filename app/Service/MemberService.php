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
    public function checkEmail(string $email)
    {
        return User::where('account', $email)->where('state', '!=', 'D')->count();
    }

    public function checkPhoneNumber(string $phone_number)
    {
        return User::where('phone_number', $phone_number)->where('state', '!=', 'D')->count();
    }
    
    
    
    public function checkBussinessNumber(string $business_number) {
        
        $whole_cnt = CompanyWholesale::where('business_license_number', $business_number)->count();
        
        $retail_cnt = CompanyRetail::where('business_license_number', $business_number)->count();
        
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
        $user->phone_number = $params['phone_number'];
        $user->state = 'JW';

        $user->type = 'N';
        $user->join_date = DB::raw('now()');
        $user->is_owner = 1;
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
        $user->type = $params['userType'];
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
        $mr->second_company_type = $params['userType'];
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
    public function createCompanyNew(array $params = [])
    {
        $detail = new UserNormal;
        $detail->name = $params['name'] ?? null;
        $detail->namecard_attachment_idx = $params['attachmentIdx'] ?? null;
        $detail->phone_number = $params['phone_number'];
        $detail->register_time = DB::raw('now()');
        $detail->save();

        return $detail->idx;
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

    public function modifyUser(array $params = [])
    {

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
