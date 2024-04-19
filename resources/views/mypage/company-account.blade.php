<div class="w-full">
    <h3 class="text-xl font-bold">계정 관리</h3>

    <div class="com_setting mt-5">
        <p class="font-bold">대표</p>
        <div class="info">
            <div class="flex items-center gap-1">
                <img class="w-4" src="/img/member/info_icon.svg" alt="" />
                <p> 대표 계정 정보는 고객센터에 문의하여 변경 요청해주세요.</p>
            </div>
        </div>

        <div class="px-28 border-t-2 border-t-stone-600 flex flex-col items-center justify-center border-b py-10 gap-6">
            <div class="flex gap-4 w-full">
                <div class="essential w-[190px] shrink-0 mt-2">회원구분</div>
                <div class="font-medium w-full flex items-center gap-2">
                    <input type="text" class="setting_input h-[48px] w-full font-normal" placeholder="{{ $user -> type === 'W' ? '도매' : '소매' }}" disabled />
                </div>
            </div>
            <div class="flex gap-4 w-full">
                <div class="essential w-[190px] shrink-0 mt-2">이메일(아이디)</div>
                <div class="font-medium w-full flex items-center gap-2">
                    <input type="text" class="setting_input h-[48px] w-full font-normal" placeholder="{{ $user -> account }}" disabled />
                </div>
            </div>
            <div class="flex gap-4 w-full">
                <div class="essential w-[190px] shrink-0 mt-2">사업자등록번호</div>
                <div class="font-medium w-full flex items-center gap-2">
                    <input type="text" class="setting_input h-[48px] w-full font-normal" placeholder="{{ $company -> business_license_number }}" disabled />
                    <button onClick="modalOpen('#view_business_modal');">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                    </button>
                </div>
            </div>
            <div class="flex gap-4 w-full">
                <div class="essential w-[190px] shrink-0 mt-2">업체명</div>
                <div class="font-medium w-full flex items-center gap-2">
                    <input type="text" class="setting_input h-[48px] w-full font-normal" placeholder="{{ $company -> company_name }}" disabled />
                </div>
            </div>
            <div class="flex gap-4 w-full">
                <div class="essential w-[190px] shrink-0 mt-2">대표자명</div>
                <div class="font-medium w-full flex items-center gap-2">
                    <input type="text" class="setting_input h-[48px] w-full font-normal" placeholder="{{ $company -> owner_name }}" disabled />
                </div>
            </div>
            <div class="flex gap-4 w-full">
                <div class="essential w-[190px] shrink-0 mt-2">휴대폰 번호</div>
                <div class="font-medium w-full flex items-center gap-2">
                    <input type="text" class="setting_input h-[48px] w-full font-normal" placeholder="{{ $company -> phone_number }}" disabled />
                    <button class="border border-stone-500 rounded-md h-[48px] w-[120px] shrink-0 hover:bg-stone-100" onClick="modalOpen('#edit_phone_number');">수정</button>
                </div>
            </div>
            <div class="flex gap-4 w-full">
                <div class="essential w-[190px] shrink-0 mt-2">사업자 주소</div>
                <div class="font-medium w-full flex items-center gap-2">
                    <input type="text" id="disabledAddress" class="setting_input h-[48px] w-full font-normal" placeholder="{{ $company -> business_address }} {{ $company -> business_address_detail }}" disabled />
                    <button class="border border-stone-500 rounded-md h-[48px] w-[120px] shrink-0 hover:bg-stone-100" onClick="modalOpen('#edit_business_number');">수정</button>
                </div>
            </div>
        </div>

        <div class="mt-5 flex items-center justify-between">
            <p class="font-bold">직원 <span class="text-sm text-stone-400 font-normal">(최대 5명)</span></p>
            <button class="flex items-center justify-between gap-1 text-stone-600 font-medium" onClick="getCompanyMember_create();">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus text-stone-300"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                직원 등록
            </button>
        </div>
        <div class="mt-3 border-t-2 border-t-stone-600 py-5 gap-6">
            @if (count($members) >= 1)
            <div>
                <ul class="flex flex-col gap-3">
                    @foreach($members as $member)
                    <li class="bg-white shadow-sm">
                        <div class="p-4 rounded-t-md border">
                            <div class="flex items-center">
                                <span class="text-base">{{ $member -> name }}</span>
                                <div class="flex items-center gap-1 text-stone-400 ml-auto">
                                    <button onclick="getCompanyMember_update({{ $member -> idx }}, '{{ $member -> name }}', '{{ $member -> phone_number }}', '{{ $member -> account }}')">수정</button>
                                    <span>|</span>
                                    <button onclick="deleteMemberModal({{ $member -> idx }})">삭제</button>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 rounded-b-md border-b border-l border-r">
                            <div class="flex items-center">
                                <p class="text-stone-400 w-[80px]">휴대폰번호</p>
                                <p class="mt-1">{{ $member -> phone_number }}</p>
                            </div>
                            <div class="flex items-center mt-2">
                                <p class="text-stone-400 w-[80px]">아이디</p>
                                <p class="mt-1">{{ $member -> account }}</p>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            @else
            <div class="border border-dashed rounded-md py-10">
                <div class="flex items-center justify-center gap-1 text-sm text-stone-500">
                    <img src="/img/member/info_icon.svg" alt="" class="w-4" />
                    <p>신규 직원을 등록해주세요.</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="flex items-center gap-3">
        <button type="button" class="btn w-1/4 btn-primary-line mt-5" onclick="modalOpen('#withdrawal_modal')">회원 탈퇴</button>
        <button class="btn w-1/4 btn-primary mt-5" onclick="modalOpen('#change_password_modal')">비밀번호 변경</button>
    </div>
</div>

<!-- 사업자등록증 -->
<div id="view_business_modal" class="modal">
    <div class="modal_bg" onClick="modalClose('#view_business_modal')"></div>
    <div class="modal_inner modal-md">
        <div class="modal_body filter_body">
            <h4>사업자등록증</h4>
            <img src="{{ $company -> license_image }}" class="w-full h-full" alt="" />
            <div class="btn_bot">
                <button class="btn btn-primary !w-full" onclick="modalClose('#view_business_modal')">확인</button>
            </div>
        </div>
    </div>
</div>

<!-- 휴대폰 번호 수정 -->
<div class="modal" id="edit_phone_number">
    <div class="modal_bg" onClick="modalClose('#edit_phone_number');"></div>
    <div class="modal_inner modal-md">
        <div class="modal_body filter_body">
            <h4>휴대폰 번호 수정</h4>
            <div class="py-3">
                <p>휴대폰 번호<span class="text-primary">*</span></p>
                <div class="mt-1">
                    <div class="flex items-center gap-2">
                        <div class="setting_input h-[48px]">
                            <select name="" id="" class="w-full h-full">
                                <option value="">대한민국(+82)</option>
                            </select>
                        </div>
                        <div class="setting_input h-[48px] grow">
                            <input type="text" name="phone_number" id="phone_number" class="w-full h-full" value="{{ $company -> phone_number }}" placeholder="- 없이 숫자만 입력해주세요." oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')" />
                        </div>
                    </div>

                </div>

            </div>
            <div class="btn_bot">
                <button class="btn btn-primary !w-full" onclick="updatePhoneNumber()">완료</button>
            </div>
        </div>
    </div>
</div>

<!-- 사업자 주소 수정 -->
<div id="edit_business_number" class="modal">
    <div class="modal_bg" onClick="modalClose('#edit_business_number');"></div>
    <div class="modal_inner modal-md">
        <div class="modal_body filter_body">
            <h4>사업자 주소 수정</h4>
            <div class="com_setting py-3">
                <div class="flex flex-col w-full">
                    <div class="flex justify-between">
                        <div class="flex gap-6">
                            <div class="flex items-center gap-1 domestic_radio"><input type="radio" name="is_domestic" id="domestic" value="1" onClick="changeDomesticType(this);" {{ $company -> is_domestic == '1'? 'checked' : '' }} /> <label for="domestic">국내</label></div>
                            <div class="flex items-center gap-1 overseas_radio"><input type="radio" name="is_domestic" id="overseas" value="0" onClick="changeDomesticType(this);" {{ $company -> is_domestic == '0'? 'checked' : '' }} />  <label for="overseas">해외</label></div>
                        </div>
                        <button class="h-[48px] w-[98px] border border-stone-500 rounded-md shrink-0 delete_address hover:bg-stone-100" style="display: none;">삭제</button>
                    </div>
                    <div class="domestic_section mt-2 location--type01 {{ $company -> is_domestic == '1'? '' : 'hidden' }}">
                        <div class="flex items-center gap-2">
                            <input type="text" name="default_address" id="default_address" class="setting_input h-[48px] w-full bg-stone-50" value="{{ $company -> business_address }}" placeholder="사업자 주소를 입력해주세요." onClick="callMapApi();" readOnly />
                            <button class="h-[48px] w-[98px] border border-stone-500 rounded-md shrink-0" onClick="callMapApi();">주소 검색</button>
                        </div>
                    </div>
                    <div class="overseas_section mt-2 relative location--type02 {{ $company -> is_domestic == '0'? '' : 'hidden' }}">
                        <input type="hidden" name="domestic_type" id="domestic_type" value="" />
                        <div class="my_filterbox h-[48px]">
                            <a href="javascript:;" class="filter_border filter_dropdown w-full h-[48px] flex justify-between items-center" style="border-radius: 3px;">
                                <p class="dropdown__title">지역</p>
                                <svg class="w-6 h-6 filter_arrow"><use xlink:href="/img/icon-defs.svg#drop_b_arrow"></use></svg>
                            </a>
                            <div class="filter_dropdown_wrap bg-white w-full h-[150px] overflow-y-scroll">
                                <ul>
                                    @foreach(config('constants.GLOBAL_DOMESTIC') as $domestic)
                                    <li>
                                        <a href="javascript: void(0);" class="flex items-center" data-domestic-type="{{ $loop -> index + 1 }}" onClick="setDomesticType(this);">{{ $domestic }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="domestic_section mt-2" style="display: block;">
                        <input type="text" name="detail_address" id="detail_address" class="setting_input h-[48px] w-full mt-2" value="{{ $company -> business_address_detail }}" placeholder="상세 주소를 입력해주세요." />
                    </div>
                </div>
            </div>
            <div class="btn_bot">
                <button type="button" id="completeAddressBtn" class="btn btn-primary !w-full" onClick="updateAddressProc();">완료</button>
            </div>
        </div>
    </div>
</div>

<!-- 직원 등록 / 수정 -->
<div id="add_account_modal" class="modal">
    <div class="modal_bg" onClick="modalClose('#add_account_modal')"></div>
    <div class="modal_inner modal-md">
        <div class="modal_body filter_body">
            <h4 id="account_title">신규 직원 등록</h4>
            <form name="memberForm" id="memberForm">
                <input type="hidden" name="member_idx" id="member_idx" value="" />
                <div class="com_setting py-3">
                    <div class="info !mt-1">
                        <div class="flex items-start  gap-1">
                            <img class="w-4" src="/img/member/info_icon.svg" alt="" />
                            <p class="">비밀번호 변경을 원하시는 경우에만 두 비밀번호를 입력해주세요.</p>
                        </div>
                    </div>

                    <div>
                        <p>이름<span class="text-primary">*</span></p>
                        <div class="setting_input h-[48px] grow mt-1">
                            <input type="text" name="member_name" id="member_name" class="w-full h-full" value="" placeholder="이름을 입력해주세요." required />
                        </div>
                    </div>

                    <div class="mt-4">
                        <p>휴대폰 번호<span class="text-primary">*</span></p>
                        <div class="setting_input h-[48px] grow mt-1">
                            <input type="text" name="member_phone_number" id="member_phone_number" class="w-full h-full" value="" placeholder="- 없이 숫자만 입력해주세요." onInput="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required />
                        </div>
                    </div>

                    <div class="mt-4">
                        <p>아이디<span class="text-primary">*</span></p>
                        <div class="setting_input h-[48px] grow mt-1">
                            <input type="text" name="member_account" id="member_account" class="w-full h-full" value="" placeholder="아이디를 입력해주세요." required />
                        </div>
                    </div>
                    <div class="info !mt-1">
                        <div class="flex items-start  gap-1">
                            <p class="text-xs">· 4자리 이상 입력해주세요.</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <p>비밀번호<span class="text-primary">*</span></p>
                        <div class="setting_input h-[48px] grow mt-1">
                            <input type="password" name="member_password" id="member_password" class="w-full h-full" placeholder="비밀번호를 입력해주세요." required />
                        </div>
                    </div>
                    <div class="info !mt-1">
                        <div class="flex items-start  gap-1">
                            <p class="">· 비밀번호는 영문, 숫자, 특수문자를 혼합하여 8자리 이상 입력해주세요.</p>
                        </div>
                        <div id="failPassword" class="valid__input hidden">
                            <i class="ico__check--red"></i>
                            <p class="valid__text fail">인증번호가 일치하지 않습니다. 다시 확인해주세요.</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <p>비밀번호 확인<span class="text-primary">*</span></p>
                        <div class="setting_input h-[48px] grow mt-1">
                            <input type="password" name="member_confirm_password" id="member_confirm_password" class="w-full h-full" placeholder="비밀번호를 다시 입력해주세요." required />
                        </div>
                        <div id="failPasswordConfirm" class="valid__input hidden">
                            <i class="ico__check--red"></i>
                            <p class="valid__text fail">두 비밀번호가 일치하지 않습니다. 다시 확인해주세요.</p>
                        </div>
                    </div>
                </div>
            </form>
            <div class="btn_bot">
                <button type="button" id="confirmMemberPasswordBtn" class="btn btn-primary !w-full" onClick="setMember();" disabled>완료</button>
            </div>
        </div>
    </div>
</div>

<!-- 직원 아이디 중복 -->
<div id="alert-modal01" class="modal">
    <div class="modal_bg" onClick="modalClose('#alert-modal01');"></div>
    <div class="modal_inner modal-md">
        <div class="modal_body filter_body !p-0">
            <div class="p-8">
                <div class="text-center text-base">
                    중복된 아이디입니다. 다시 입력해주세요.
                </div>
            </div>
            <div class="flex text-base border-t">
                <button type="button" class="w-full text-primary py-3" onClick="modalClose('#alert-modal01');">확인</button>
            </div>
        </div>
    </div>
</div>

<!-- 직원 삭제 -->
<div id="delete_account_modal" class="modal">
    <div class="modal_bg" onClick="modalClose('#delete_account_modal')"></div>
    <div class="modal_inner modal-md">
        <div class="modal_body filter_body !p-0">
            <div class="p-8">
                <div class="text-center text-base">
                    해당 직원 정보를 삭제하시겠습니까?<br />
                    삭제된 직원 정보는 복구하실 수 없습니다.
                </div>
            </div>
            <div class="flex text-base border-t">
                <button class="w-full border-r py-3" onClick="modalClose('#delete_account_modal')">취소</button>
                <button id="confirmDeleteBtn" class="w-full text-primary py-3" data-idx="" onClick="deleteMember();">확인</button>
            </div>
        </div>
    </div>
</div>

<!-- 회원 탈퇴 -->
<div id="withdrawal_modal" class="modal">
    <div class="modal_bg" onclick="modalClose('#withdrawal_modal')"></div>
    <div class="modal_inner modal-md">
        <button class="close_btn" onclick="modalClose('#withdrawal_modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body filter_body">
            <h4>회원 탈퇴</h4>
        </div>
        <div class="px-4">
            <div class="bg-stone-100 p-4">
                <p class="font-medium">탈퇴 안내 사항</p>
                <div class="text-stone-400 flex gap-1 mt-2 rounded-sm">
                    <p>·</p>
                    <p>탈퇴 시, 탈퇴일 기점으로 1개월간 재가입이 불가 하며 1개월 이후 신규 가입이 가능합니다.</p>
                </div>
                <div class="text-stone-400 flex gap-1">
                    <p>·</p>
                    <p>탈퇴일 기점으로 1년간 회원 정보가 유지되며 1년 경과 후 모든 정보가 삭제됩니다.</p>
                </div>
                <div class="text-stone-400 flex gap-1">
                    <p>·</p>
                    <p>탈퇴와 관련된 자세한 내용은 올펀 고객센터에 문의해주세요.</p>
                </div>
            </div>
            <div class="custom_input mt-6">
                <input type="checkbox" id="withdrawal-check" class="itemCheckbox" />
                <label for="withdrawal-check" class="flex items-center gap-1 font-medium">탈퇴 관련 안내를 모두 확인하였으며 회원 탈퇴에 동의합니다.</label>
            </div>
            <div class="py-4">
                <a href="javascript: ;" id="completeBtn" class="flex items-center justify-center bg-primary h-[42px] text-white w-full rounded-sm" onclick="withdrawal()" disabled>탈퇴하기</a>
            </div>
        </div>
    </div>
</div>

<!-- 회원 탈퇴 완료 -->
<div id="alert-modal02" class="modal">
    <div class="modal_bg" onclick="modalClose('#alert-modal02')"></div>
    <div class="modal_inner modal-md">
        <div class="modal_body filter_body !p-0">
            <div class="p-8">
                <div class="text-center text-base">
                    탈퇴가 완료되었습니다.<br />
                    서비스를 이용해주셔서 감사합니다.
                </div>
            </div>
            <div class="flex text-base border-t">
                <button type="button" class="w-full text-primary py-3" onclick="location.href='/'">확인</button>
            </div>
        </div>
    </div>
</div>

<!-- 비밀번호 변경 -->
<div id="change_password_modal" class="modal">
    <div class="modal_bg" onClick="modalClose('#change_password_modal')"></div>
    <div class="modal_inner modal-md">
        <div class="modal_body filter_body">
            <h4>비밀번호 변경</h4>
            <div class="com_setting py-3">
                <div>
                    <p>새 비밀번호<span class="text-primary">*</span></p>
                    <div class="setting_input h-[48px] grow mt-1">
                        <input type="password" name="password" id="password" class="w-full h-full" placeholder="비밀번호를 입력해주세요." required />
                    </div>
                </div>
                <div class="info !mt-1">
                    <div class="flex items-center justify-center gap-1">
                        <p class="">· 비밀번호는 영문, 숫자, 특수문자를 혼합하여 8자리 이상 입력해주세요.</p>
                    </div>
                </div>
                <div class="mt-4">
                    <p>새 비밀번호 확인<span class="text-primary">*</span></p>
                    <div class="setting_input h-[48px] grow mt-1">
                        <input type="password" name="confirm_password" id="confirm_password" class="w-full h-full" placeholder="비밀번호를 다시 입력해주세요." required />
                    </div>
                </div>
            </div>
            <div class="btn_bot">
                <button type="button" id="confirmPasswordBtn" class="btn btn-primary !w-full" onClick="changePassword();" disabled>완료</button>
            </div>
        </div>
    </div>
</div>





<script src="/js/jquery-1.12.4.js?{{ date('Ymdhis') }}"></script>
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>
    let member_idx = document.getElementById('member_idx').value;
    let validateCheckList = {};

    const updatePhoneNumber = () => {
        fetch('/mypage/company-account', {
            method  : 'PUT',
            headers : {
                'Content-Type'  : 'application/json',
                'X-CSRF-TOKEN'  : '{{csrf_token()}}'
            },
            body    : JSON.stringify({
                phone_number: document.getElementById('phone_number').value
            })
        }).then(response => {
            return response.json();
        }).then(json => {
            if (json.result === 'success') {
                location.reload();
            }
        });
    }

    const updateAddress = () => {
        document.getElementById('updateAddressWrap').classList.remove('hidden');
        document.getElementById('visibleAddressWrap').classList.add('hidden');
    }

    // 국내 / 해외 라디오 버튼 클릭
    const changeDomesticType = elem => {
        document.getElementById('completeAddressBtn').setAttribute('disabled', 'disabled');

        document.getElementById('default_address').value = '';
        document.getElementById('detail_address').value = '';
        document.getElementById('domestic_type').value = '';

        if (elem.value === '1') {
            document.querySelector('.location--type01').classList.remove('hidden');
            document.querySelector('.location--type02').classList.add('hidden');
        } else {
            document.querySelector('.location--type02').classList.remove('hidden');
            document.querySelector('.location--type01').classList.add('hidden');
        }

        document.querySelector('.location--type02 .dropdown__title').textContent = '지역';
    }

    // 해와 > 지역 선택
    const setDomesticType = elem => {
        const parent = elem.closest('.location--type02');
        parent.querySelector('[name*=domestic_type]').value = elem.dataset.domesticType;

        document.getElementById('completeAddressBtn').removeAttribute('disabled');
    }

    const setCompleteAddress = () => {
        if (document.getElementById('default_address').value) {
            document.getElementById('completeAddressBtn').removeAttribute('disabled');
        } else {
            document.getElementById('completeAddressBtn').setAttribute('disabled', 'disabled');
        }
    }

    const callMapApi = () => {
        new daum.Postcode({
            oncomplete  : function(data) {
                document.getElementById('default_address').value = data.roadAddress;
                setCompleteAddress();
            }
        }).open();
    }

    const updateAddressProc = () => {
        const default_address = document.getElementById('default_address').value;
        const detail_address = document.getElementById('detail_address').value;
        const is_domestic = document.querySelector('input[type=radio][name=is_domestic]:checked').value;
        const domestic_type = document.querySelector('[name=domestic_type]').value;

        fetch('/mypage/company-account', {
            method  : 'PUT',
            headers : {
                'Content-Type'  : 'application/json',
                'X-CSRF-TOKEN'  : '{{csrf_token()}}'
            },
            body    : JSON.stringify({ default_address, detail_address, is_domestic, domestic_type })
        }).then(response => {
            return response.json();
        }).then(json => {
            if (json.result === 'success') {
                location.reload();
            }
        });
    }

    const updateCheckList = () => {
        if (!member_idx) {
            validateCheckList = {
                checkedName             : false,   // 이름 빈값 확인
                checkedPhoneNumber      : false,   // 휴대폰 빈값 확인
                checkedId               : false,   // 아이디 빈값 확인
                checkedIdLength         : false,   // 아이디 길이 확인
                checkedPasswordValidate : false,   // 패스워드 유효성 확인
                checkedComparePassword  : false    // 패스워드 같은지 확인
            }
        } else {
            validateCheckList = {
                checkedName             : true,
                checkedPhoneNumber      : true,
                checkedId               : true,
                checkedIdLength         : true,
                checkedPasswordValidate : true,
                checkedComparePassword  : true
            }
        }
    }

    updateCheckList();

    const getCompanyMember_create = () => {
        member_idx = '';
        updateCheckList();

        modalOpen('#add_account_modal');
    }

    const getCompanyMember_update = (idx, name, phone_number, account) => {
        member_idx = idx;
        updateCheckList();

        document.getElementById('account_title').innerText = '직원 정보 수정';

        document.getElementById('member_idx').value = idx;
        document.getElementById('member_name').value = name;
        document.getElementById('member_phone_number').value = phone_number;
        document.getElementById('member_account').value = account;
        modalOpen('#add_account_modal');
    }

    const setMember = () => {
        if (validate() === false) {
            alert('유효성 검사 실패');
            return false;
        }

        const data = new URLSearchParams();
        for (const pair of new FormData(document.getElementById('memberForm'))) {
            console.log(pair);
            data.append(pair[0], pair[1]);
        }

        fetch('/mypage/company-member', {
            method  : member_idx ? 'PUT' : 'POST',
            headers : {
                'X-CSRF-TOKEN'  : '{{csrf_token()}}'
            },
            body    : data
        }).then(response => {
            return response.json();
        }).then(json => {
            if (json.result === 'success') {
                if (!member_idx) {
                    alert('신규 직원이 등록되었습니다.');
                } else {
                    alert('해당 직원 정보가 수정되었습니다.');
                }

                location.reload();
            } else {
                if (json.code === 'DUPLICATE_ID') {
                    modalOpen('#alert-modal01');
                    return false;
                } else {
                    alert(json.message);
                    return false;
                }
            }
        });
    }

    const validateName = () => {
        if (document.getElementById('member_name').value) {
            validateCheckList.checkedName = true;
        } else {
            validateCheckList.checkedName = false;
        }

        validate();
    }

    const validatePhoneNumber = () => {
        if (document.getElementById('member_phone_number').value) {
            validateCheckList.checkedPhoneNumber = true;
        } else {
            validateCheckList.checkedPhoneNumber = false;
        }

        validate();
    }

    const validateId = () => {
        if (document.getElementById('member_account').value.length < 4) {
            validateCheckList.checkedIdLength = false;
        } else if (document.getElementById('member_account').value === '') {
            validateCheckList.checkedId = false;
        } else {
            validateCheckList.checkedId = true;
            validateCheckList.checkedIdLength = true;
        }

        validate();
    }

    const validateMemberPassword = () => {
        if (member_idx) {
            if (!document.getElementById('member_password').value && !document.getElementById('member_confirm_password').value) {
                validateCheckList.checkedComparePassword = true;
                validateCheckList.checkedPasswordValidate = true;

                validate();
                return false;
            }
        }

        const regExp = /^.*(?=^.{8,}$)(?=.*\d)(?=.*[a-zA-Z]).*$/;
        if (document.getElementById('member_password').value.match(regExp) === null) {
            validateCheckList.checkedPasswordValidate = false;
        } else {
            if (document.getElementById('member_confirm_password').value) {
                if (document.getElementById('member_confirm_password').value !== document.getElementById('member_password').value) {
                    validateCheckList.checkedComparePassword = false;
                } else {
                    document.querySelector('#failPasswordConfirm p').textContent = '';
                    document.querySelector('#failPasswordConfirm').classList.add('hidden');
                    document.getElementById('member_confirm_password').classList.remove('textfield__input--red');

                    validateCheckList.checkedComparePassword = true;
                }
            }

            document.querySelector('#failPassword p').textContent = '';
            document.querySelector('#failPassword').classList.add('hidden');
            document.getElementById('member_password').classList.remove('textfield__input--red');

            validateCheckList.checkedPasswordValidate = true;
        }

        validate();
    }

    const validateMemberPasswordBlur = () => {
        if (member_idx) {
            if (!document.getElementById('member_password').value && !document.getElementById('member_confirm_password').value) {
                validateCheckList.checkedComparePassword = true;
                validateCheckList.checkedPasswordValidate = true;

                validate();
                return false;
            }
        }

        const regExp = /^.*(?=^.{8,}$)(?=.*\d)(?=.*[a-zA-Z]).*$/;
        if (document.getElementById('member_password').value.match(regExp) === null) {
            document.querySelector('#failPassword p').textContent = '비밀번호는 영문, 숫자, 특수문자를 혼합하여 8자리 이상 입력해주세요.';
            document.querySelector('#failPassword').classList.remove('hidden');
            document.getElementById('member_password').classList.add('textfield__input--red');
        } else {
            if (document.getElementById('member_confirm_password').value !== document.getElementById('member_password').value && document.getElementById('member_confirm_password').value.length > 0) {
                if (document.getElementById('member_confirm_password').value !== document.getElementById('member_password').value) {
                    document.querySelector('#failPasswordConfirm p').textContent = '비밀번호가 일치하지 않습니다.';
                    document.querySelector('#failPasswordConfirm').classList.remove('hidden');
                    document.getElementById('member_confirm_password').classList.add('textfield__input--red');

                    validateCheckList.checkedComparePassword = false;
                } else {
                    document.querySelector('#failPasswordConfirm p').textContent = '';
                    document.querySelector('#failPasswordConfirm').classList.add('hidden');
                    document.getElementById('member_confirm_password').classList.remove('textfield__input--red');

                    validateCheckList.checkedComparePassword = true;
                }
            }

            document.querySelector('#failPassword p').textContent = '';
            document.querySelector('#failPassword').classList.add('hidden');
            document.getElementById('member_password').classList.remove('textfield__input--red');

            validateCheckList.checkedPasswordValidate = true;
        }

        validate();
    }

    const validateConfirmPassword = () => {
        if (member_idx) {
            if (!document.getElementById('member_password').value && !document.getElementById('member_confirm_password').value) {
                validateCheckList.checkedComparePassword = true;
                validateCheckList.checkedPasswordValidate = true;

                validate();
                return false;
            }
        }

        if (document.getElementById('member_confirm_password').value) {
            if (document.getElementById('member_confirm_password').value !== document.getElementById('member_password').value) {
                validateCheckList.checkedComparePassword = false;
            } else {
                document.querySelector('#failPasswordConfirm p').textContent = '';
                document.querySelector('#failPasswordConfirm').classList.add('hidden');
                document.getElementById('member_confirm_password').classList.remove('textfield__input--red');

                validateCheckList.checkedComparePassword = true;
            }
        }

        validate();
    }

    const validateConfirmPasswordBlur = () => {
        if (member_idx) {
            if (!document.getElementById('member_password').value && !document.getElementById('member_confirm_password').value) {
                validateCheckList.checkedComparePassword = true;
                validateCheckList.checkedPasswordValidate = true;

                validate();
                return false;
            }
        }

        if (document.getElementById('member_confirm_password').value) {
            if (document.getElementById('member_confirm_password').value !== document.getElementById('member_password').value) {
                document.querySelector('#failPasswordConfirm p').textContent = '비밀번호가 일치하지 않습니다.';
                document.querySelector('#failPasswordConfirm').classList.remove('hidden');
                document.getElementById('member_confirm_password').classList.add('textfield__input--red');

                validateCheckList.checkedComparePassword = false;
            } else {
                document.querySelector('#failPasswordConfirm p').textContent = '';
                document.querySelector('#failPasswordConfirm').classList.add('hidden');
                document.getElementById('member_confirm_password').classList.remove('textfield__input--red');

                validateCheckList.checkedComparePassword = true;
            }
        }

        validate();
    }

    document.getElementById('member_name').addEventListener('keyup', validateName);
    document.getElementById('member_phone_number').addEventListener('keyup', validatePhoneNumber);
    document.getElementById('member_account').addEventListener('keyup', validateId);
    document.getElementById('member_password').addEventListener('keyup', validateMemberPassword);
    document.getElementById('member_password').addEventListener('blur', validateMemberPasswordBlur);
    document.getElementById('member_confirm_password').addEventListener('keyup', validateConfirmPassword);
    document.getElementById('member_confirm_password').addEventListener('blur', validateConfirmPasswordBlur);

    const validate = () => {
        let result = true;
        for (const check in validateCheckList) {
            if (validateCheckList[check] === false) {
                document.getElementById('confirmMemberPasswordBtn').setAttribute('disabled', 'disabled');
                result = false;

                return false;
            }
        }

        if (result) {
            document.getElementById('confirmMemberPasswordBtn').removeAttribute('disabled');
        }

        return result;
    }

    validate();

    const deleteMemberModal = idx => {
        document.getElementById('confirmDeleteBtn').dataset.idx = idx;
        modalOpen('#delete_account_modal');
    }

    const deleteMember = () => {
        const idx = document.getElementById('confirmDeleteBtn').dataset.idx;
        fetch('/mypage/company-account/' + idx, {
            method      : 'DELETE',
            headers     : {
                'X-CSRF-TOKEN'  : '{{csrf_token()}}'
            }
        }).then(response => {
            return response.json();
        }).then(json => {
            alert('해당 직원 정보가 삭제되었습니다.');
            location.reload();
        });
    }

    document.getElementById('withdrawal-check').addEventListener('click', e => {
        if (e.currentTarget.checked) {
            document.getElementById('completeBtn').removeAttribute('disabled');
        } else {
            document.getElementById('completeBtn').setAttribute('disabled', 'disabled');
        }
    });

    const withdrawal = () => {
        if (document.getElementById('withdrawal-check').checked === false) {
            alert('동의 후 진행 가능합니다.');
            return false;
        }

        withdrawal_proc();
    }

    let isWithdraw = false;
    const withdrawal_proc = () => {
        fetch('/mypage/withdrawal', {
            method  : 'POST',
            headers : {
                'X-CSRF-TOKEN'  : '{{csrf_token()}}'
            }
        }).then(response => {
            return response.json();
        }).then(json => {
            isWithdraw = true;
            modalOpen('#alert-modal02');
        });
    }

    window.onclick = function(event) {
        if(isWithdraw) {
            location.href='/';
        }
    }

    document.getElementById('password').addEventListener('blur', e => {
        const regExp = /^.*(?=^.{8,}$)(?=.*\d)(?=.*[a-zA-Z]).*$/;
        if(document.getElementById('password').value.match(regExp) === null ) {
            alert("비밀번호는 영문, 숫자, 특수문자를 혼합하여 8자리 이상 입력해주세요.");
            document.getElementById('confirmPasswordBtn').setAttribute('disabled', 'disabled');

            return false;
        }
    });

    document.getElementById('confirm_password').addEventListener('blur', e => {
        if (document.getElementById('password').value && document.getElementById('confirm_password').value) {
            if (document.getElementById('password').value !== document.getElementById('confirm_password').value) {
                alert('두 비밀번호가 일치하지 않습니다.');
                document.getElementById('confirmPasswordBtn').setAttribute('disabled', 'disabled');

                return false;
            } else {
                document.getElementById('confirmPasswordBtn').removeAttribute('disabled');
            }
        }
    });

    const changePassword = () => {
        if (validatePassword() === false) {
            return false;
        }

        fetch('/mypage/company-account/password', {
            method  : 'PUT',
            headers : {
                'Content-Type'  : 'application/json',
                'X-CSRF-TOKEN'  : '{{csrf_token()}}'
            },
            body    : JSON.stringify({
                password        : document.getElementById('password').value
            })
        }).then(response => {
            return response.json();
        }).then(json => {
            alert('비밀번호가 성공적으로 변경되었습니다.');
            location.reload();
        });
    }

    const validatePassword = () => {
        const regExp = /^.*(?=^.{8,}$)(?=.*\d)(?=.*[a-zA-Z]).*$/;
        if(document.getElementById('password').value.match(regExp) === null ) {
            alert("비밀번호는 영문, 숫자, 특수문자를 혼합하여 8자리 이상 입력해주세요.");
            document.getElementById('confirmPasswordBtn').setAttribute('disabled', 'disabled');

            return false;
        }

        if (document.getElementById('password').value !== document.getElementById('confirm_password').value) {
            alert('비밀번호가 일치하지 않습니다.');
            document.getElementById('confirmPasswordBtn').setAttribute('disabled', 'disabled');

            return false;
        }

        return true;
    }



    $(document).ready(function(){
        $('.dropdown__title').text('{{ $company -> business_address }}');

        $(document).on('click', '.filter_dropdown', function(e){
            $(this).toggleClass('active');
            $(this).closest('.my_filterbox').find('.filter_dropdown_wrap').toggle();
            $(this).find('svg').toggleClass('active');

            e.stopPropagation();
        });

        $(document).on('click', '.filter_dropdown_wrap ul li a', function(){
            var selectedText = $(this).text();
            $(this).closest('.my_filterbox').find('.filter_dropdown p').text(selectedText);

            $(this).closest('.location--type02').find('[name*=domestic_type]').val($(this).data('domestic-type'));

            $('#default_address').val(selectedText);

            $('.filter_dropdown_wrap').hide();
            $('.filter_dropdown').removeClass('active');
            $('.filter_dropdown svg').removeClass('active');
        });

        $(document).click(function(e){
            var $target = $(e.target);

            if(!$target.closest('.filter_dropdown').length && $('.filter_dropdown').hasClass('active')) {
                $('.filter_dropdown_wrap').hide();
                $('.filter_dropdown').removeClass('active');
                $('.filter_dropdown svg').removeClass('active');
            }
        });
    });
</script>