@extends('layouts.app')

@section('content')
<div class="join_header sticky top-0 h-16 bg-white flex items-center">
    <div class="inner">
        <a class="inline-flex" href="/"><img class="logo" src="./img/logo.svg" alt=""></a>
    </div>
</div>

<div id="content">
    <section class="join_common">
        <form id="frm" >
            <div class="join_inner">
                <div class="title">
                    <h3>회원가입</h3>
                    <div class="info">
                        <div class="flex items-center gap-1">
                            <img class="w-4" src="./img/member/info_icon.svg" alt="">
                            <p>회원 가입 후 관리자 승인 여부에 따라 서비스 이용이 가능합니다.</p>
                        </div>
                    </div>
                </div>

                <div class="form_box">
                    <h4>회원 구분을 선택해주세요.</h4>
                    <div class="join_type grid grid-cols-2">
                        <div>
                            <p>가구 사업자</p>
                            <div class="grid grid-cols-2">
                                <div>
                                    <button type="button" data-num="0">제조/도매</button>
                                    <span>상품 등록이 가능한 사업자 대표 계정입니다.</span>
                                </div>
                                <div>
                                    <button type="button" data-num="1">판매/매장</button>
                                    <span>상품 구매, 업체 연락이 가능한 사업자 대표 계정입니다.</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <p>사업자 외(직원)</p>
                            <div class="grid grid-cols-2">
                                <div>
                                    <button type="button" data-num="2">가구 업종</button>
                                    <span>가구 제조/도매, 판매/매장, 유통의 임직원 계정입니다.</span>
                                </div>
                                <div>
                                    <button type="button" data-num="3">기타 가구 관련 업종</button>
                                    <span>가구와 연관된 기타 업종 전체(기타 사업자 포함) 입니다.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center txt-danger py-7 fs14">일반 소비자는 회원가입이 불가합니다.</div>
                </div>
                
                <div class="form_tab_content">
                    <!-- 제조/도매일때 -->
                    <div class="form_box hidden" id="wholesale-tab-pane" data-usertype="W">
                        <h4>회원 정보를 입력해주세요.</h4>
                        <div class="info_box flex items-center gap-1 mt-2.5 mb-8">
                            <img class="w-4" src="./img/member/info_icon.svg" alt="">
                            가입 승인 이후 대표 계정에 소속된 직원 계정을 생성하실 수 있습니다.
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">사업자 등록 번호</dt>
                                <dd class="flex gap-1">
                                    <div class="flex-1">
                                        <input type="text" id="w_businesscode" name="businesscode" required maxlength="12" class="input-form w-full input-guid__input" placeholder="사업자 등록 번호를 입력해주세요." oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^(\d{0,3})(\d{0,2})(\d{0,5})$/g, '$1-$2-$3').replace(/\-{1,2}$/g, '');">
                                    </div>
                                    <button type="button" class="btn btn-black-line input-guid__button" disabled onclick="checkBeforeAuthCode('business_regist_number', 'w')">중복체크</button>
                                </dd>
                            </dl>
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">명함 또는 사업자 등록증</dt>
                                <dd>
                                    <div class="file-form vertical">
                                        <input type="file" id="w_certificate" name="certificate" required class="input-guid__input" accept="image/*">
                                        <div class="text">
                                            <img id="w_img" class="mx-auto" src="./img/member/img_icon.svg" alt="">
                                            <p id="w_file-input" class="mt-1">이미지 추가</p>
                                        </div>
                                    </div>
                                    <div class="info_box mt-2.5">
                                        ・권장 형식: jpg, jpeg, png
                                    </div>
                                </dd>
                            </dl>
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">업체명</dt>
                                <dd>
                                    <input type="text" id="w_businessname" name="businessname" class="input-form w-full input-guid__input" placeholder="업체명을 입력해주세요." required>
                                </dd>
                            </dl>
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">대표자</dt>
                                <dd>
                                    <input type="text" id="w_username" name="username" required class="input-form w-full input-guid__input" placeholder="대표자를 입력해주세요.">
                                </dd>
                            </dl>
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">휴대폰 번호</dt>
                                <dd class="flex gap-1">
                                    @include('login._country_phone_number', ['id'=>'w_phone_country_number'])
                                    <div class="flex-1">
                                        <input type="text" id="w_contact" name="contact" required class="input-form w-full input-guid__input" placeholder="-없이 숫자만 입력해주세요." oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^(\d{0,3})(\d{0,4})(\d{0,4})$/g, '$1-$2-$3').replace(/\-{1,2}$/g, '');">
                                    </div>
                                </dd>
                            </dl>
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">사업자 주소</dt>
                                <dd>
                                    <div class="flex gap-5 py-2">
                                        <p><input type="radio" class="radio-form" id="add_1_1" name="add_1" onchange="addressChange(this)" value="1"><label for="add_1_1">국내</label></p>
                                        <p><input type="radio" class="radio-form" id="add_1_2" name="add_1" onchange="addressChange(this)" value="2"><label for="add_1_2">해외</label></p>
                                    </div>
                                    <div class="add_tab">
                                        <!-- 국내 -->
                                        <div class="flex gap-1">
                                            <input type="text" id="w_businessaddress" name="businessaddress" class="input-form w-full input-guid__input" placeholder="주소를 검색해주세요" disabled onclick="execPostCode('w')">
                                            <button type="button" class="btn btn-black-line" onclick="execPostCode('w')">주소 검색</button>
                                        </div>
                                        <!-- 해외 -->
                                        <div class="dropdown_wrap hidden">
                                            <button type="button" class="dropdown_btn">지역</button>
                                            <div class="dropdown_list">
                                                <div class="dropdown_item">아시아</div>
                                                <div class="dropdown_item">아프리카</div>
                                                <div class="dropdown_item">북아메리카</div>
                                                <div class="dropdown_item">남아메리카</div>
                                                <div class="dropdown_item">유럽</div>
                                                <div class="dropdown_item">오세아니아</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <input id="w_businessaddressdetail" name="businessaddressdetail" type="text" class="input-form w-full input-guid__input" placeholder="주소를 입력해주세요" disabled>
                                    </div>
                                </dd>
                            </dl>
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">아이디</dt>
                                <dd class="flex gap-1">
                                    <div class="flex-1">
                                        <input type="text" id="w_useremail" name="useremail"  required class="input-form w-full input-guid__input" placeholder="아이디를 입력해주세요." >
                                    </div>
                                    <button class="btn btn-black-line" disabled onclick="checkBeforeAuthCode('email', 'w')" type="button">중복체크</button>
                                </dd>
                            </dl>
                        </div>

                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">비밀번호</dt>
                                <dd>
                                    <input type="password" id="w_userpw" name="userpw" required minlength="8" class="input-form w-full input-guid__input" placeholder="비밀번호를 입력해주세요.">
                                    <div class="info_box mt-2.5">
                                        ・영문 및 숫자 혼합하여 8자리 이상 입력해주세요.
                                    </div>
                                </dd>
                            </dl>
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">비밀번호 확인</dt>
                                <dd>
                                    <input type="password" id="w_userpwcheck" name="w_userpwcheck" required minlength="8" class="input-form w-full input-guid__input" placeholder="비밀번호를 다시 입력해주세요.">
                                </dd>
                            </dl>
                        </div>

                    </div>
                    <!-- 판매/매장일때 -->
                    <div class="form_box hidden" id="retail-tab-pane" data-usertype="R">
                        <h4>회원 정보를 입력해주세요.</h4>
                        <div class="info_box flex items-center gap-1 mt-2.5 mb-8">
                            <img class="w-4" src="./img/member/info_icon.svg" alt="">
                            가입 승인 이후 대표 계정에 소속된 직원 계정을 생성하실 수 있습니다.
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">사업자 등록 번호</dt>
                                <dd class="flex gap-1">
                                    <div class="flex-1">
                                        <input type="text" id="r_businesscode" name="businesscode" required maxlength="12" class="input-form w-full input-guid__input" placeholder="사업자 등록 번호를 입력해주세요." oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^(\d{0,3})(\d{0,2})(\d{0,5})$/g, '$1-$2-$3').replace(/\-{1,2}$/g, '');">
                                    </div>
                                    <button class="btn btn-black-line input-guid__button" disabled onclick="checkBeforeAuthCode('business_regist_number', 'r')" type="button">중복체크</button>
                                </dd>
                            </dl>
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">명함 또는 사업자 등록증</dt>
                                <dd>
                                    <div class="file-form vertical">
                                        <input id="r_certificate" name="certificate" type="file" required class="input-guid__input" accept="image/*">
                                        <div class="text">
                                            <img id="r_img" class="mx-auto" src="./img/member/img_icon.svg" alt="">
                                            <p id="r_file-input" class="mt-1">이미지 추가</p>
                                        </div>
                                    </div>
                                    <div class="info_box mt-2.5">
                                        ・권장 형식: jpg, jpeg, png
                                    </div>
                                </dd>
                            </dl>
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">업체명</dt>
                                <dd>
                                    <input id="r_businessname" name="businessname" type="text" required class="input-form w-full input-guid__input" placeholder="업체명을 입력해주세요.">
                                </dd>
                            </dl>
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">대표자</dt>
                                <dd>
                                    <input id="r_username" name="username" type="text" required class="input-form w-full input-guid__input" placeholder="대표자를 입력해주세요.">
                                </dd>
                            </dl>
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">휴대폰 번호</dt>
                                <dd class="flex gap-1">
                                    @include('login._country_phone_number', ['id'=>'r_phone_country_number'])
                                    <div class="flex-1">
                                        <input id="r_contact" name="contact" type="text" required maxlength="13" class="input-form w-full input-guid__input" placeholder="-없이 숫자만 입력해주세요." oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^(\d{0,3})(\d{0,4})(\d{0,4})$/g, '$1-$2-$3').replace(/\-{1,2}$/g, '');">
                                    </div>
                                </dd>
                            </dl>
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">사업자 주소</dt>
                                <dd>
                                    <div class="flex gap-5 py-2">
                                        <p><input type="radio" class="radio-form" id="add_1_3" name="add_1" onchange="addressChange(this)" value="1"><label for="add_1_3">국내</label></p>
                                        <p><input type="radio" class="radio-form" id="add_1_4" name="add_1" onchange="addressChange(this)" value="2"><label for="add_1_4">해외</label></p>
                                    </div>
                                    <div class="add_tab">
                                        <!-- 국내 -->
                                        <div class="flex gap-1">
                                            <input type="text" id="r_businessaddress" name="businessaddress" class="input-form w-full input-guid__input" placeholder="주소를 검색해주세요" disabled onclick="execPostCode('r')">
                                            <button type="button" class="btn btn-black-line" onclick="execPostCode('r')" type="button">주소 검색</button>
                                        </div>
                                        <!-- 해외 -->
                                        <div class="dropdown_wrap hidden">
                                            <button type="button" class="dropdown_btn">지역</button>
                                            <div class="dropdown_list">
                                                <div class="dropdown_item">아시아</div>
                                                <div class="dropdown_item">아프리카</div>
                                                <div class="dropdown_item">북아메리카</div>
                                                <div class="dropdown_item">남아메리카</div>
                                                <div class="dropdown_item">유럽</div>
                                                <div class="dropdown_item">오세아니아</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <input type="text" id="r_businessaddressdetail" name="businessaddressdetail" class="input-form w-full input-guid__input" placeholder="주소를 입력해주세요" disabled>
                                    </div>
                                </dd>
                            </dl>
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">아이디</dt>
                                <dd class="flex gap-1">
                                    <div class="flex-1">
                                        <input type="text" id="r_useremail" name="useremail"  required class="input-form w-full input-guid__input" placeholder="아이디를 입력해주세요.">
                                        <label for="" class="error"></label>
                                    </div>
                                    <button class="btn btn-black-line" disabled onclick="checkBeforeAuthCode('email', 'r')" type="button">중복체크</button>
                                </dd>
                            </dl>
                        </div>

                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">비밀번호</dt>
                                <dd>
                                    <input id="r_userpw" name="userpw" type="password" required minlength="8" class="input-form w-full input-guid__input" placeholder="비밀번호를 입력해주세요.">
                                    <div class="info_box mt-2.5">
                                        ・영문 및 숫자 혼합하여 8자리 이상 입력해주세요.
                                    </div>
                                </dd>
                            </dl>
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">비밀번호 확인</dt>
                                <dd>
                                    <input type="password" id="r_userpwcheck" name="r_userpwcheck" type="password" required minlength="8" class="input-form w-full input-guid__input" placeholder="비밀번호를 다시 입력해주세요.">
                                </dd>
                            </dl>
                        </div>

                    </div>
                    <!-- 가구업종일때 -->
                    <div class="form_box hidden" id="furn-sectors-tab-pane" data-usertype="S">
                        <h4>회원 정보를 입력해주세요.</h4>
                        <div class="info_box flex items-center gap-1 mt-2.5 mb-8">
                            <img class="w-4" src="./img/member/info_icon.svg" alt="">
                            가입 승인 이후 대표 계정에 소속된 직원 계정을 생성하실 수 있습니다.
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">명함 첨부</dt>
                                <dd>
                                    <div class="file-form horizontal">
                                        <input type="file" id="s_certificate" name="certificate" required class="input-guid__input" accept="image/*">
                                        <div class="text">
                                            <img id="s_img" class="mx-auto" src="./img/member/img_icon.svg" alt="">
                                            <p id="s_file-input" class="mt-1">이미지 추가</p>
                                        </div>
                                    </div>
                                    <div class="info_box mt-2.5">
                                        ・권장 형식: jpg, jpeg, png
                                    </div>
                                </dd>
                            </dl>
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">업체명</dt>
                                <dd>
                                    <input type="text" id="s_businessname" name="businessname" required class="input-form  w-full input-guid__input" placeholder="업체명을 입력해주세요.">
                                </dd>
                            </dl>
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">성명/직위</dt>
                                <dd>
                                    <input type="text" id="s_username" name="username" required class="input-form w-full input-guid__input" placeholder="성명/직위를 입력해주세요.">
                                </dd>
                            </dl>
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">휴대폰 번호</dt>
                                <dd class="flex gap-1">
                                    @include('login._country_phone_number', ['id'=>'s_phone_country_number'])
                                    <div class="flex-1">
                                        <input type="text" id="s_contact" name="contact" required maxlength="13" class="input-form w-full input-guid__input" placeholder="-없이 숫자만 입력해주세요." oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^(\d{0,3})(\d{0,4})(\d{0,4})$/g, '$1-$2-$3').replace(/\-{1,2}$/g, '');">
                                    </div>
                                </dd>
                            </dl>
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">아이디</dt>
                                <dd class="flex  gap-1">
                                    <div class="flex-1">
                                        <input type="text" id="s_useremail" name="useremail"  required class="input-form w-full input-guid__input" placeholder="아이디를 입력해주세요.">
                                    </div>
                                    <button class="btn btn-black-line" disabled onclick="checkBeforeAuthCode('email', 's')" type="button">중복체크</button>
                                </dd>
                            </dl>
                        </div>

                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">비밀번호</dt>
                                <dd>
                                    <input id="s_userpw" name="userpw" type="password" required minlength="8" class="input-form w-full input-guid__input" placeholder="비밀번호를 입력해주세요.">
                                    <div class="info_box mt-2.5">
                                        ・영문 및 숫자 혼합하여 8자리 이상 입력해주세요.
                                    </div>
                                </dd>
                            </dl>
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">비밀번호 확인</dt>
                                <dd>
                                    <input id="s_userpwcheck" name="s_userpwcheck" type="password" required minlength="8" class="input-form w-full input-guid__input" placeholder="비밀번호를 다시 입력해주세요.">
                                </dd>
                            </dl>
                        </div>

                    </div>
                    <!-- 기타 가구 관련 업종 일때 -->
                    <div class="form_box hidden" id="normal-tab-pane" data-usertype="N">
                        <h4>회원 정보를 입력해주세요.</h4>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">명함 첨부</dt>
                                <dd>
                                    <div class="file-form horizontal">
                                        <input type="file" id="n_certificate" name="certificate" required class="input-guid__input" accept="image/*">
                                        <div class="text">
                                            <img id="n_img" class="mx-auto" src="./img/member/img_icon.svg" alt="">
                                            <p id="n_file-input" class="mt-1">이미지 추가</p>
                                        </div>
                                    </div>
                                    <div class="info_box mt-2.5">
                                        ・권장 형식: jpg, jpeg, png
                                    </div>
                                </dd>
                            </dl>
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">업체명</dt>
                                <dd>
                                    <input type="text" id="n_businessname" name="businessname" required class="input-form w-full input-guid__input" placeholder="업체명을 입력해주세요.">
                                </dd>
                            </dl>
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">성명/직위</dt>
                                <dd>
                                    <input type="text" id="n_username" name="username" required class="input-form w-full input-guid__input" placeholder="성명/직위를 입력해주세요.">
                                </dd>
                            </dl>
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">휴대폰 번호</dt>
                                <dd class="flex gap-1">
                                    @include('login._country_phone_number', ['id'=>'n_phone_country_number'])
                                    <div class="flex-1">
                                        <input type="text" id="n_contact" name="contact" required maxlength="13" class="input-form w-full input-guid__input" placeholder="-없이 숫자만 입력해주세요." oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^(\d{0,3})(\d{0,4})(\d{0,4})$/g, '$1-$2-$3').replace(/\-{1,2}$/g, '');">
                                    </div>
                                </dd>
                            </dl>
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">아이디</dt>
                                <dd class="flex  gap-1">
                                    <div class="flex-1">
                                        <input type="text" id="n_useremail" name="useremail"  required class="input-form w-full input-guid__input" placeholder="아이디를 입력해주세요.">
                                    </div>
                                    <button class="btn btn-black-line" disabled onclick="checkBeforeAuthCode('email', 'n')" type="button">중복체크</button>
                                </dd>
                            </dl>
                        </div>

                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">비밀번호</dt>
                                <dd>
                                    <input id="n_userpw" name="userpw" type="password" required minlength="8" class="input-form w-full input-guid__input" placeholder="비밀번호를 입력해주세요.">
                                    <div class="info_box mt-2.5">
                                        ・영문 및 숫자 혼합하여 8자리 이상 입력해주세요.
                                    </div>
                                </dd>
                            </dl>
                        </div>
                        <div class="mb-8">
                            <dl class="flex">
                                <dt class="necessary">비밀번호 확인</dt>
                                <dd>
                                    <input id="n_userpwcheck" name="n_userpwcheck" type="password" required minlength="8" class="input-form w-full input-guid__input" placeholder="비밀번호를 다시 입력해주세요.">
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                
                <div class="form_bottom hidden">
                    <div class="form_box">
                        <div class="agree_wrap mb-8">
                            <h3>올펀 약관에 동의해주세요.</h3>
                            <div class="agree_box">
                                <div class="agree_item all">
                                    <p><input type="checkbox" class="check-form" name="all_check" id="all"><label for="all">필수 약관 전체 동의</label></p>
                                </div>
                                <div class="agree_item">
                                    <p><input type="checkbox" class="check-form checkbox__input--necessary" id="register-agreement_1"><label for="register-agreement_1">서비스 이용 약관 동의 (필수)</label></p>
                                    <button type="button" onclick="modalOpen('#agree01-modal')">상세보기</button>
                                </div>
                                <div class="agree_item">
                                    <p><input type="checkbox" class="check-form checkbox__input--necessary" id="register-agreement_2"><label for="register-agreement_2">개인정보 활용 동의 (필수)</label></p>
                                    <button type="button" onclick="modalOpen('#agree02-modal')">상세보기</button>
                                </div>
                                <div class="agree_item">
                                    <p><input type="checkbox" class="check-form" id="register-agreement_3"><label for="register-agreement_3">마케팅 정보 활용 동의 (선택)</label></p>
                                    <button type="button" onclick="modalOpen('#agree03-modal')">상세보기</button>
                                </div>
                                <div class="agree_item">
                                    <p><input type="checkbox" class="check-form" id="register-agreement_4"><label for="register-agreement_4">광고성 이용 동의 (선택)</label></p>
                                    <button type="button" onclick="modalOpen('#agree04-modal')">상세보기</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn_box">
                        <button type="button" id="register_form-submit" class="btn w-[300px] btn-primary" onclick="$('#frm').valid(); submitAction()">가입 완료</button>
                    </div>
                </div>
            </div>
        </form>
    </section>


    <div class="modal" id="agree01-modal">
        <div class="modal_bg" onclick="modalClose('#agree01-modal')"></div>
        <div class="modal_inner">
            <button class="close_btn" onclick="modalClose('#agree01-modal')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <h3>서비스 이용 약관</h3>
                <iframe src="https://api.all-furn.com/res/agreement/agreement.html"></iframe>
            </div>
        </div>
    </div>

    <div class="modal" id="agree02-modal">
        <div class="modal_bg" onclick="modalClose('#agree02-modal')"></div>
        <div class="modal_inner">
            <button class="close_btn" onclick="modalClose('#agree02-modal')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <h3>개인정보 활용 동의</h3>
                <iframe src="https://api.all-furn.com/res/agreement/privacy.html"></iframe>
            </div>
        </div>
    </div>

    <div class="modal" id="agree03-modal">
        <div class="modal_bg" onclick="modalClose('#agree03-modal')"></div>
        <div class="modal_inner">
            <button class="close_btn" onclick="modalClose('#agree03-modal')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <h3>개인정보 활용 동의</h3>
                <iframe src="https://api.all-furn.com/res/agreement/marketing.html"></iframe>
            </div>
        </div>
    </div>

    <div class="modal" id="agree04-modal">
        <div class="modal_bg" onclick="modalClose('#agree04-modal')"></div>
        <div class="modal_inner">
            <button class="close_btn" onclick="modalClose('#agree04-modal')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <h3>광고성 이용 동의</h3>
                <iframe src=""></iframe>
            </div>
        </div>
    </div>

</div>

<script>
let inN = '0';
let base = '';
// 탭변경
$('.join_type button').on('click', function() {
    $('.form_bottom').removeClass('hidden')
    inN = $(this).data('num')
    $('.join_type button').removeClass('on')
    $(this).addClass('on');
    $('.form_tab_content > .form_box').eq(inN).removeClass('hidden').siblings().addClass('hidden')

    $('#frm')[0].reset();
    $('#register_form-submit').attr('disabled', true);
    if (inN === 0) { $('#add_1_1').prop('checked', true);  } else { $('#add_1_3').prop('checked', true); }

    if (inN === 0) {
        base  = '#wholesale-tab-pane';
    } else if (inN === 1) {
        base  = '#retail-tab-pane';
    } else if (inN === 2) {
        base  = '#furn-sectors-tab-pane';
    } else if (inN === 3) {
        base  = '#normal-tab-pane';
    }
})

// 이미지 변경
const fileUpload = (input) => {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        let img = input.parentNode.querySelector('img');
        if(!img){
            img = document.createElement('img')
        }
        input.nextElementSibling.classList.add('hidden')
        reader.onload = function(e) {
            img.src = e.target.result
            input.parentNode.append(img)
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// 주소 탭 변경
const addressChange = (e) => {
let liN = $(e).parent().index()
	if(liN != 0) { $(e).parent().parent().parent().find('div:nth-child(3) > input').removeAttr('disabled'); } else { $(e).parent().parent().parent().find('div:nth-child(3) > input').attr('disabled', 'disabled'); }
    $(e).parent().parent().next('.add_tab').find('> div').eq(liN).removeClass('hidden').siblings().addClass('hidden')
}
</script>

<script defer src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js?autoload=false"></script>
<script defer src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.0/jquery.validate.min.js" ></script>
    <script defer src="/js/validate/messages_ko.min.js" ></script>

<script>
var isProc = false; // 중복등록 방지용
var phoneAuthTime = 300; // 최초 설정 시간(기본 : 초)
var emailAuthTime = 300;
var email_dup_check = false;
var business_code_dup_check = false;

$(document).ready(function() {
    // 이미지 업로드 관련
    $('[type="file"]').on("change", handleImgFileSelect);
    
    // 사업자등록번호 입력시 중복체크 버튼 활성화
    $('.input-guid__input#w_businesscode, .input-guid__input#r_businesscode').keyup(function () {
        let business_code = $(this).val();
        if (business_code !== "") {
            $(this).parent().parent().find('button').removeAttr("disabled");
        } else {
            $(this).parent().parent().find('button').prop("disabled", true);
        }
    });

    // 아이디 입력시 중복체크 버튼 활성화
    $('.input-guid__input#w_useremail, .input-guid__input#r_useremail, .input-guid__input#s_useremail, .input-guid__input#n_useremail').keyup(function () {
        let email = $(this).val();
        if (email !== "") {
            $(this).parent().parent().find('button').removeAttr("disabled");
        } else {
            $(this).parent().parent().find('button').prop("disabled", true);
        }
    });

    // 가입완료 버튼 활성화
    $('input, .checkbox__input--necessary').change(function () {
        var errors = 0;
        $(base + ' .input-guid__input').map(function() {
            if( $(this).val().length === 0 ) {
                if ( $(this).attr('name') === 'businessaddress' && $(base + ' [name="add_1"]:checked').val() === '2' ) {
                } else {
                    errors++;    
                } 
            }
        });
        if (!$('#register-agreement_1').is(':checked') || !$('#register-agreement_2').is(':checked')) { errors++; }
        if (!email_dup_check) { errors++; }
        if (errors == 0) {
            $('#register_form-submit').removeAttr('disabled');
        } else {
            $('#register_form-submit').prop('disabled', true);
        }
    });

    // validation
    $('#frm').validate({
        rules: {
            businesscode: {required:true, minlength:12, businessCodeDupCheck: true},
            certificate: {required:true},
            businessname: {required:true},
            username: {required:true},
            contact: {required:true},
            businessaddressdetail: {required:true},
            useremail: {required:true, emailDupCheck: true},
            userpw: {required:true, eng_number:true, minlength:8},
            w_userpwcheck: {required:true, minlength:8, equalTo:"#w_userpw"},
            r_userpwcheck: {required:true, minlength:8, equalTo:"#r_userpw"},
            s_userpwcheck: {required:true, minlength:8, equalTo:"#s_userpw"},
            n_userpwcheck: {required:true, minlength:8, equalTo:"#n_userpw"},
            userpwcheck: {required:true, minlength:8, equalTo:base +" #userpw"},
        },
        messages: {
            businesscode: {
                required: "사업자번호를 정확히 입력해주세요",
                minlength: "사업자번호를 정확히 입력해주세요",
                businessCodeDupCheck: "사업자번호 중복체크를 해주세요"
            },
            certificate: "사업자등록증을 확인해주세요",
            businessname: "업체명을 정확히 입력해주세요",
            username: "대표장명을 정확히 입력해주세요",
            contact: "휴대폰 번호를 정확히 입력해주세요",
            businessaddressdetail: "주소를 입력해주세요",
            useremail: {
                required: "아이디를 입력해주세요",
                emailDupCheck: "중복체크를 해주세요.",
            },
            useremail_confirm_w: {
                required: "이메일을 입력해주세요",
                email: "이메일을 정확히 입력해주세요",
                equalTo: "이메일과 일치하지 않습니다",
            },
            useremail_confirm_r: {
                required: "이메일을 입력해주세요",
                email: "이메일을 정확히 입력해주세요",
                equalTo: "이메일과 일치하지 않습니다",
            },
            useremail_confirm_n: {
                required: "이메일을 입력해주세요",
                email: "이메일을 정확히 입력해주세요",
                equalTo: "이메일과 일치하지 않습니다",
            },
            userpw: {
                required: "비밀번호는 입력해주세요",
                eng_number: "비밀번호는 영문 및 숫자 혼합하여 8자리 이상 입력해주세요",
                minlength: "비밀번호는 영문 및 숫자 혼합하여 8자리 이상 입력해주세요",
            },
            userpwcheck: {
                required: "비밀번호확인을 입력해주세요",
                minlength: "비밀번호와 일치하지 않습니다",
                equalTo: "비밀번호와 일치하지 않습니다",
            },
            w_userpwcheck: {
                required: "비밀번호확인을 입력해주세요",
                minlength: "비밀번호와 일치하지 않습니다",
                equalTo: "비밀번호와 일치하지 않습니다",
            },
            r_userpwcheck: {
                required: "비밀번호확인을 입력해주세요",
                minlength: "비밀번호와 일치하지 않습니다",
                equalTo: "비밀번호와 일치하지 않습니다",
            },
            s_userpwcheck: {
                required: "비밀번호확인을 입력해주세요",
                minlength: "비밀번호와 일치하지 않습니다",
                equalTo: "비밀번호와 일치하지 않습니다",
            },
            n_userpwcheck: {
                required: "비밀번호확인을 입력해주세요",
                minlength: "비밀번호와 일치하지 않습니다",
                equalTo: "비밀번호와 일치하지 않습니다",
            }
        }
    });
    
});

$.validator.addMethod('eng_number', function( value ) {
    return /[a-z]/.test(value) && /[0-9]/.test(value)
});


$.validator.addMethod('emailDupCheck', function(value) {
    return email_dup_check;
});

$.validator.addMethod('businessCodeDupCheck', function(value) {
    return business_code_dup_check;
})


// 우편번호/주소 검색
function execPostCode(t) {
    daum.postcode.load(function() {
        new daum.Postcode({
            oncomplete: function(data) {
                var addr = '';

                if (data.userSelectedType === 'R') {
                    addr = data.roadAddress;
                } else {
                    addr = data.jibunAddress;
                }
                $(`#${t}_businessaddress`).val(addr);
                $(`#${t}_businessaddressdetail`).removeAttr('disabled');
                $(`#${t}_businessaddressdetail`).focus();
            }
        }).open();
    });
}

function step1Next(){
    if(inN < 0) {
        modalOpen('#step1-modal');
    } else {
        $('.form_tab_content > .form_box').eq(inN).removeClass('hidden').siblings().addClass('hidden')

        $('#frm2')[0].reset();
        $('#frm3')[0].reset();
        $('#register_form-submit').attr('disabled', true);
        if (inN === 0) { $('#add_1_1').prop('checked', true);  } else { $('#add_1_3').prop('checked', true); }

        $('.nextBtn').removeClass('hidden')
    }
}
// 사용중 이메일, 사업자번호 체크
function checkBeforeAuthCode(type, t) {
    if ( type === 'business_regist_number' ) {
        if($(`#${t}_businesscode`).val().replaceAll('-','').length != 10){
            $(`#${t}_businesscode`).parent().find('label').text('잘못된 사업자 등록번호입니다.');
            $('#email_dupcheck_ment').html('잘못된 사업자 등록번호입니다.');
            modalOpen('#modal-email--duplicated');
            return;
        }
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/member/checkUsingBusinessNumber',
            data: {
                'business_number': $(`#${t}_businesscode`).val().replaceAll('-','')
            },
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                if (result == 0) {
                    $(`#${t}_businesscode`).parent().find('label').text('사용가능한 사업자번호 입니다.');
                    $('#email_dupcheck_ment').html('사용가능한 사업자번호 입니다.');
                    $(`#${t}_businesscode`).removeClass('error');
                    $(`#${t}_businesscode`).parent().find('label').hide();
                    business_code_dup_check = true;
                } else {
                    $(`#${t}_businesscode`).parent().find('label').text('중복된 사업자 등록번호입니다.');
                    $('#email_dupcheck_ment').html('중복된 사업자 등록번호입니다.');
                }
                modalOpen('#modal-email--duplicated');
            }
        });
    } else {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/member/checkUsingEmail',
            data: {
                'email': $(`#${t}_useremail`).val()
            },
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                if (result == 0) {
                    $('#email_dupcheck_ment').html('사용가능한 아이디입니다.');
                    $(`#${t}_useremail`).removeClass('error');
                    $(`#${t}_useremail`).parent().find('label').hide();
                    email_dup_check = true;
                } else {
                    $('#email_dupcheck_ment').html('이미 사용중인 아이디입니다. 다시 확인해주세요.');
                }
                modalOpen('#modal-email--duplicated');
            }
        });
    }
}

function email_check( email ) {    
    var regex=/([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    return (email != '' && email != 'undefined' && regex.test(email)); 
}

$("input[type=email]").blur(function(){
  var email = $(this).val();
  if( email == '' || email == 'undefined') return;
  if(! email_check(email) ) {
  	$(this).val('');
    $(this).focus();
    return false;
  }
});
// 가입완료 처리
function submitAction() {
    if (isProc) {
        return;
    }
    isProc = true;

    // let userType = $('.tab-content__panel[aria-hidden="false"]').data('usertype');
    let userType = '';
    if ( base === '#wholesale-tab-pane' ) userType = 'W';
    else if ( base === '#retail-tab-pane' ) userType = 'R';
    else if ( base === '#furn-sectors-tab-pane' ) userType = 'S';
    else if ( base === '#normal-tab-pane' ) userType = 'N';

    let suffix = '';
    if ( userType === 'W' ) suffix = 'w'
    else if ( userType === 'R' ) suffix = 'r';
    else if ( userType === 'S' ) suffix = 's';
    else if ( userType === 'N' ) suffix = 'n';

    var form = new FormData();
    form.append("userType", userType);
    form.append('name', $(`#${suffix}_username`).val());
    form.append("file", $(base + ' [type="file"]')[0].files[0]);
    form.append('phone', $(`#${suffix}_contact`).val().replace(/-/g, ''));
    form.append('phone_country_number', $(`#${suffix}_phone_country_number`).val());
    form.append('email', $(`#${suffix}_useremail`).val());
    form.append('password', $(`#${suffix}_userpw`).val());
    form.append('agreementServicePolicy', $('#register-agreement_1').is(':checked') ? 1 : 0);
    form.append('agreementPrivacy', $('#register-agreement_2').is(':checked') ? 1 : 0);
    form.append('agreementMarketing', $('#register-agreement_3').is(':checked') ? 1 : 0);
    form.append('agreementAd', $('#register-agreement_4').is(':checked') ? 1 : 0);
    if ( userType === 'W' || userType === 'R' ) {
        form.append('businessLicenseNumber', $(`#${suffix}_businesscode`).val().replace(/-/g, ''));
    }
    form.append('companyName', $(`#${suffix}_businessname`).val());
    if (userType != "N" && userType != "S") {
        form.append('isDomestic', $(base + ' [name="add_1"]:checked').val() == 1 ? 2 : 1);
        if ($(base + ' [name="add_1"]:checked').val() === 1) {
            form.append('domesticType', $(base + ' .dropdown__title').data('domestic_type'));
            form.append('address', $(base + ' .dropdown__title').text());
        } else {
            form.append('address', $(base + ' [name="businessaddress"]').val());
        }
        form.append('addressDetail', $(base + ' [name="businessaddressdetail"]').val());
    }

    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: '/member/createUser',
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        data: form,
        type: 'POST',
        success: function(result) {
            if (result.success) {
                location.replace('/signup/success');
                isProc = false;
                
            } else {
                switch (result.code) {
                    case 1001:
                        openModal('#modal-email--duplicated');
                        isProc = false;
                        break;
                    default:
                        alert(result.message);
                        isProc = false;
                        break;
                }
            }
        }
    });
}

// 이미지 컨트롤
function handleImgFileSelect(e) {
    var files = e.target.files;
    var filesArr = Array.prototype.slice.call(files);
    var reg = /(.*?)\/(jpg|jpeg|png|bmp)$/;
    var attr_id = $(this).attr('id');
    filesArr.forEach(function (f) {
        if (!f.type.match(reg)) {
            alert("확장자는 이미지 확장자만 가능합니다.");
            return;
        }
        sel_file = f;
        var reader = new FileReader();
        reader.onload = function (e) {
            if ( attr_id === 'w_certificate' ) {
                $('#w_img').attr('src', e.target.result);
                $('#w_img').css({'width':'inherit','height':'inherit'});
                $('#w_file-input').hide();
            } else if ( attr_id === 'r_certificate' ) {
                $('#r_img').attr('src', e.target.result);
                $('#r_img').css({'width':'inherit','height':'inherit'});
                $('#r_file-input').hide();
            } else if ( attr_id === 's_certificate' ) {
                $('#s_img').attr('src', e.target.result);
                $('#s_img').css({'width':'inherit','height':'inherit'});
                $('#s_file-input').hide();
            } else if ( attr_id === 'n_certificate' ) {
                $('#n_img').attr('src', e.target.result);
                $('#n_img').css({'width':'inherit','height':'inherit'});
                $('#n_file-input').hide();
            }
        }
        reader.readAsDataURL(f);
    });
}
</script>

<div class="modal" id="modal-email--duplicated">
    <div class="modal_bg" onclick="modalClose('#modal-email--duplicated')"></div>
    <div class="modal_inner modal-sm">
        <button type="button" class="close_btn" onclick="modalClose('#modal-email--duplicated')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body agree_modal_body">
            <p class="text-center py-4"><b id='email_dupcheck_ment'>이미 사용중인 이메일 입니다.<br>다시 확인해주세요.</b></p>
            <div class="flex gap-2 justify-center">
                <button type="button" class="btn btn-primary w-1/2 mt-5" onclick="modalClose('#modal-email--duplicated');">확인</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="smscode_time_over">
    <div class="modal_bg" onclick="modalClose('#smscode_time_over')"></div>
    <div class="modal_inner modal-sm">
        <button class="close_btn" onclick="modalClose('#smscode_time_over')" type="button"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body agree_modal_body">
            <p class="text-center py-4"><b>유효시간이 만료되었습니다.<br>인증코드를 재발송해주세요.</b></p>
            <div class="flex gap-2 justify-center">
                <button class="btn btn-primary w-1/2 mt-5" onclick="modalClose('#smscode_time_over')" type="button">확인</button>
            </div>
        </div>
    </div>
</div>


@endsection




