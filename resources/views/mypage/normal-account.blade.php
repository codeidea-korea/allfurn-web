<div class="w-full">
    <h3 class="text-xl font-bold">계정 관리</h3>
    <div class="com_setting mt-5">
        <p>대표</p>
        @php 
        // print_r($user);
        @endphp
        <div class="info">
            <div class="flex items-center gap-1">
                <img src="/img/member/info_icon.svg" alt="" class="w-4" />
                <p>대표 계정 정보는 고객센터에 문의하여 변경 요청해주세요.</p>
            </div>
        </div>
        <div class="px-28 border-t-2 border-t-stone-600 flex flex-col items-center justify-center border-b py-10 gap-6">
            <div class="flex gap-4 w-full">
				<div class="essential w-[190px] shrink-0 mt-2">회원구분</div>
				<div class="font-medium w-full flex items-center gap-2">
					<div id="member_type_options" class="flex items-center gap-4 w-full">
						<div class="flex items-center gap-2">
							<input type="radio" id="type_store" name="member_type" class="radio-form" value="R" 
								{{ $user->type == 'R' ? 'checked' : '' }}
								{{ $user->type && $user->type != 'N' ? 'disabled' : '' }}>
							<label for="type_store">매장/판매</label>
						</div>
						<div class="flex items-center gap-2">
							<input type="radio" id="type_wholesale" name="member_type" class="radio-form" value="W" 
								{{ $user->type == 'W' ? 'checked' : '' }}
								{{ $user->type && $user->type != 'N' ? 'disabled' : '' }}>
							<label for="type_wholesale">제조/도매</label>
						</div>
					</div>
					<button id="member_type_save_btn" class="border border-stone-500 rounded-md h-[48px] w-[120px] shrink-0 hover:bg-stone-100 {{ $user->type && $user->type != 'N' ? 'bg-gray-200 opacity-50' : '' }}" 
						onclick="saveMemberType()" 
						{{ $user->type && $user->type != 'N' ? 'disabled' : '' }}>
						{{ $user->type && $user->type != 'N' ? '수정됨' : '저장' }}
					</button>
				</div>
			</div>
            <div class="flex gap-4 w-full">
                <div class="essential w-[190px] shrink-0 mt-2">이메일 (아이디)</div>
                <div class="font-medium w-full flex items-center gap-2">
                    <input type="text" class="setting_input h-[48px] w-full font-normal" placeholder="{{ $user->account }}" disabled="">
                </div>
            </div>
            <div class="flex gap-4 w-full">
                <div class="essential w-[190px] shrink-0 mt-2">사업자 등록 번호</div>
                <div class="font-medium w-full flex items-center gap-2">
                    <input type="text" class="setting_input h-[48px] w-full font-normal" placeholder="" disabled="">
                    <button onclick="modalOpen('#view_business_modal')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><circle cx="9" cy="9" r="2"></circle><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path></svg>
                    </button>
                </div>
            </div>
            <div class="flex gap-4 w-full">
                <div class="essential w-[190px] shrink-0 mt-2">업체명</div>
                <div class="font-medium w-full flex items-center gap-2">
                    <input type="text" class="setting_input h-[48px] w-full font-normal" placeholder="" disabled="">
                </div>
            </div>
            <div class="flex gap-4 w-full">
                <div class="essential w-[190px] shrink-0 mt-2">대표자명</div>
                <div class="font-medium w-full flex items-center gap-2">
                    <input type="text" class="setting_input h-[48px] w-full font-normal" placeholder="{{ $user->user_nm }}" disabled="">
                </div>
            </div>
            <div class="flex gap-4 w-full">
                <div class="essential w-[190px] shrink-0 mt-2">휴대폰 번호</div>
                <div class="font-medium w-full flex items-center gap-2">
                    <input type="text" class="setting_input h-[48px] w-full font-normal" placeholder="{{ $user->phone_number }}" disabled="">
                    <button class="border border-stone-500 rounded-md h-[48px] w-[120px] shrink-0 hover:bg-stone-100" onclick="modalOpen('#edit_phone_number')">수정</button>
                </div>
            </div>
            <div class="flex gap-4 w-full">
                <div class="essential w-[190px] shrink-0 mt-2">사업자 번호</div>
                <div class="font-medium w-full flex items-center gap-2">
                    <input type="text" class="setting_input h-[48px] w-full font-normal" placeholder="{{ $user->business_license_number }}" disabled="">
                    <button class="border border-stone-500 rounded-md h-[48px] w-[120px] shrink-0 hover:bg-stone-100" onclick="modalOpen('#edit_business_number')">수정</button>
                </div>
            </div>
        </div>
    </div>
    <div class="btn_bot mt-4">
        <button class="btn btn-line2 px-4" onclick="">회원 탈퇴</button>
        <button class="btn btn-primary px-4" onclick="">비밀번호 변경</button>
    </div>
</div>

<script>

	function saveMemberType() {
    const selectedType = document.querySelector('input[name="member_type"]:checked');
    
    if (!selectedType) {
        alert('회원구분을 선택해주세요.');
        return;
    }
    
    // 서버에 데이터 전송
    fetch('/mypage/update-member-type', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        },
        body: JSON.stringify({
            member_type: selectedType.value
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // 성공 메시지 표시
            alert(data.message);
            
            // company-account 페이지로 이동
            window.location.href = '/mypage/company-account';
        } else {
            alert(data.message || '저장 중 오류가 발생했습니다.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('저장 중 오류가 발생했습니다.');
    });
}


    let time_proc_interval = '';
    let time = 299;

    const downloadNameCard = idx => {
        location.href='/download/image/name-card/' + idx
    }

    const updatePhone = () => {
        document.getElementById('updatePhoneWrap').classList.remove('hidden');
        document.getElementById('visiblePhoneWrap').classList.add('hidden');
    }

    const cancelAuthPhone = () => {
        document.getElementById('updatePhoneWrap').classList.add('hidden');
        document.getElementById('visiblePhoneWrap').classList.remove('hidden');
    }

    const sendPhoneAuthCode = () => {
        document.getElementById('successAuthentic').classList.add('hidden');
        document.getElementById('failAuthentic').classList.add('hidden');
        if (!document.getElementById('phone_number').value) {
            alert('휴대폰 번호를 입력해주세요.');
            return false;
        }
        fetch('/mypage/account/send/auth/phone', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            body: JSON.stringify({
                phone_number: document.getElementById('phone_number').value
            })
        }).then(response => {
            return response.json();
        }).then(json => {
            if (json.result === 'success') {
                if (document.getElementById('sendAuthCode').dataset.isRetry === '1') {
                    clearInterval(time_proc_interval);
                    time = 299;
                    time_proc_interval = setInterval(timer, 1000);
                } else {
                    document.getElementById('sendAuthCode').textContent = '인증번호 재전송';
                    document.getElementById('sendAuthCode').dataset.isRetry = '1';
                    time_proc_interval = setInterval(timer, 1000);
                }
                document.querySelector('#successAuthentic .attchment__text').textContent = '인증번호가 전송되었습니다. 문자를 확인해주세요.';
                document.getElementById('successAuthentic').classList.remove('hidden');
                document.getElementById('timeWrap').classList.remove('hidden');
            } else {
                document.getElementById('failSendEmail').classList.remove('hidden');
                document.querySelector('#failAuthentic .attchment__text').textContent = json.message;
            }
        });
    }

    const toAuthentic = () => {
        if (time < 1) {
            document.getElementById('failAuthentic').classList.remove('hidden');
            document.querySelector('#failAuthentic .attchment__text').textContent = '인증 만료 시간이 끝났습니다. 다시 인증번호를 발송해주세요.';
            return false;
        }
        const authcode = document.getElementById('authcode').value;
        fetch('/mypage/account/authentic', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            body: JSON.stringify({
                type: 'S',
                authcode: authcode
            })
        }).then(response => {
            return response.json();
        }).then(json => {
            document.getElementById('successAuthentic').classList.add('hidden');
            document.getElementById('failAuthentic').classList.add('hidden');

            if (json.result === 'success') {
                document.querySelector('#successAuthentic .attchment__text').textContent = '인증되었습니다.';
                document.getElementById('successAuthentic').classList.remove('hidden');
                document.getElementById('authcode').setAttribute('disabled', 'disabled');
                clearInterval(time_proc_interval);
                document.getElementById('timeWrap').classList.add('hidden');
                document.getElementById('authBtn').setAttribute('disabled', 'disabled');
                document.getElementById('phone_number').setAttribute('disabled', 'disabled');
                document.getElementById('sendAuthCode').setAttribute('disabled', 'disabled');
                document.getElementById('completeBtn').removeAttribute('disabled');
            } else {
                document.getElementById('failAuthentic').classList.remove('hidden');
                document.querySelector('#failAuthentic .attchment__text').textContent = json.message;
            }
        })
    }

    const updatePhoneNumber = () => {
        fetch('/mypage/normal-account', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            body: JSON.stringify({
                phone_number: document.getElementById('phone_number').value,
            })
        }).then(response => {
            return response.json();
        }).then(json => {
            if (json.result === 'success') {
                document.getElementById('disabledPhoneNumber').value = document.getElementById('phone_number').value;
                document.getElementById('updatePhoneWrap').classList.add('hidden');
                document.getElementById('visiblePhoneWrap').classList.remove('hidden');
            }
        })
    }

    const changePassword = () => {
        if (validatePassword() === false) {
            return false;
        }
        fetch('/mypage/company-account/password', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            body: JSON.stringify({
                password: document.getElementById('password').value,
            })
        }).then(response => {
            return response.json();
        }).then(json => {
            location.reload();
        })
    }

    document.getElementById('password').addEventListener('blur', e => {
        const regExp = /^.*(?=^.{8,}$)(?=.*\d)(?=.*[a-zA-Z]).*$/;
        if(document.getElementById('password').value.match(regExp) === null ) {
            alert("비밀번호는 영문, 숫자 8자리 이상 입력하셔야 합니다.");
            document.getElementById('confirmPasswordBtn').setAttribute('disabled', 'disabled');
            return false;
        }
    });
    document.getElementById('confirm_password').addEventListener('blur', e => {
        if (document.getElementById('password').value && document.getElementById('confirm_password').value) {
            if (document.getElementById('password').value !== document.getElementById('confirm_password').value) {
                alert('비밀번호가 일치하지 않습니다.');
                document.getElementById('confirmPasswordBtn').setAttribute('disabled', 'disabled');
                return false;
            } else {
                document.getElementById('confirmPasswordBtn').removeAttribute('disabled');
            }
        }
    });

    const validatePassword = () => {
        const regExp = /^.*(?=^.{8,}$)(?=.*\d)(?=.*[a-zA-Z]).*$/;
        if(document.getElementById('password').value.match(regExp) === null ) {
            alert("비밀번호는 영문, 숫자 8자리 이상 입력하셔야 합니다.");
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

    const timer = () => {
        const minutes = String(Math.floor(time / 60)).padStart(2, "0");
        const seconds = String(time % 60).padStart(2, "0");
        time -= 1;
        document.getElementById('count').innerHTML = `${minutes}:${seconds}`;
        if (time < 0)  {
            clearInterval(time_proc_interval);
            document.getElementById('failAuthentic').classList.remove('hidden');
            document.querySelector('#failAuthentic .attchment__text').textContent = '인증 만료 시간이 끝났습니다. 다시 인증번호를 발송해주세요.';
        }
    }
</script>