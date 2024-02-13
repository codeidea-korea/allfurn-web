<div class="my__section account-managemenet">
    <div class="content">
        <div class="section">
            <div class="section__head">
                <div class="section__head__group">
                    <h3 class="section__title">계정 관리</h3>
                </div>
            </div>
            <div class="section__content">
                <div class="content__item01">
                    <div class="content__head">
                        <h4>일반</h4>
                        <div class="notice-wrap display-flex">
                            <i class="ico__info"><span class="a11y">공지</span></i>
                            <p>정회원 승격 시, 대표 계정으로 전환됩니다.</p>
                        </div>
                    </div>

                    <div class="content__body">
                        <ul class="body__auth-wrap">
                            <li class="auth__item">
                                <div class="item__head">
                                    <span class="head__text" for="input-list01">회원 구분</span>
                                </div>
                                <div class="item__body">
                                    <div class="input__guid">
                                        <input type="text" placeholder="" value="일반" class="input-guid__input" id="input-list0"
                                               disabled>
                                        <button type="button" class="input-guid__button" onclick="openModal('#alert-modal')" {{ $user->state == 'UW' ? 'disabled' : '' }}>
                                            정회원 승격 요청
                                        </button>
                                    </div>
                                </div>
                            </li>
                            <li class="auth__item">
                                <div class="item__head">
                                    <span class="head__text" for="input-list02">이메일(아이디)</span>
                                </div>
                                <div class="item__body">
                                    <input type="text" placeholder="" value="{{ $user->account }}" class="input textfield__input textfield__input--gray" id="input-list02" disabled>
                                </div>
                            </li>
                            <li class="auth__item">
                                <div class="item__head">
                                    <span class="head__text" for="input-list03">가입자명</span>
                                </div>

                                <div class="item__body download">
                                    <input type="text" placeholder="" value="{{ $user->name }}" class="input textfield__input textfield__input--gray" id="input-list03" disabled>
                                    @if ($user->namecard_attachment_idx)
                                    <button type="button" class="ico__gallery28--gray" onclick="downloadNameCard('{{ $user->namecard_attachment_idx }}')"><span class="a11y">다운로드</span></button>
                                    @endif
                                </div>

                            </li>

                            <li class="auth__item" id="visiblePhoneWrap">
                                <div class="item__head">
                                    <label class="head__text">휴대폰 번호</label>
                                </div>
                                <div>
                                    <div class="input__guid">
                                        <input type="text" placeholder="휴대폰 번호를 입력해주세요." value="{{ $user->phone_number }}" class="input-guid__input" id="disabledPhoneNumber" disabled>
                                        <button type="button" class="input-guid__button" onclick="updatePhone()">수정</button>
                                    </div>
                                </div>
                            </li>

                            <li class="auth__item hidden" id="updatePhoneWrap">
                                <div class="item__head">
                                    <label class="head__text">휴대폰 번호</label>
                                </div>
                                <div class="item__body">
                                    <div class="input__guid">
                                        <input type="text" placeholder="휴대폰 번호를 입력해주세요." value="{{ $user->phone_number }}"
                                               class="input-guid__input" id="phone_number" name="phone_number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                        <button type="button" class="input-guid__button" data-is-retry="" id="sendAuthCode" onclick="sendPhoneAuthCode()">인증번호 전송</button>
                                    </div>
                                    <div class="input__guid input__guid--time" style="margin-top: 10px;">
                                        <input type="text" placeholder="인증 번호를 입력해주세요." id="authcode" name="authcode" class="input-guid__input">
                                        <div class="time-wrap" id="timeWrap">
                                            <p id="count">5:00</p>
                                        </div>
                                        <button type="button" class="input-guid__button" id="authBtn" onclick="toAuthentic()">인증하기</button>
                                    </div>
                                    <div class="attchment-wrap hidden" id="successAuthentic">
                                        <i class="ico__check--blue"></i>
                                        <p class="attchment__text">인증되었습니다.</p>
                                    </div>
                                    <div class="attchment-wrap hidden" id="failAuthentic">
                                        <i class="ico__check--blue"></i>
                                        <p class="attchment__text fail">인증번호가 일치하지 않습니다. 다시 확인해주세요.</p>
                                    </div>
                                    <div class="body__button-group">
                                        <button type="button" class="button button--blank-gray" onclick="cancelAuthPhone()">취소</button>
                                        <button type="button" class="button button--blank" id="completeBtn" disabled onclick="updatePhoneNumber()">완료</button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="password-wrap">
                    <div class="content__button--group">
                        <button type="button" class="button button--blank"
                                onclick="location.href='/mypage/withdrawal'">회원 탈퇴</button>
                        <button type="button" class="button button--solid password__button">비밀번호 변경</button>
                    </div>
                    <div class="content__body password__container">
                        <ul class="body__auth-wrap">
                            <li class="auth__item">
                                <div class="item__head">
                                    <label class="head__text required">새 비밀번호</label>
                                </div>
                                <div class="item__body">
                                    <input type="password" placeholder="비밀번호를 입력해주세요."
                                           class="input textfield__input textfield__input--gray" id="password" name="password" required >
                                    <div class="notice-wrap">
                                        <p>· 영문 및 숫자 혼합하여 8자리 이상 입력해주세요</p>
                                    </div>
                                </div>
                            </li>
                            <li class="auth__item">
                                <div class="item__head">
                                    <label class="head__text required">새 비밀번호 확인</label>
                                </div>
                                <div class="item__body">
                                    <input type="password" placeholder="비밀번호를 다시 입력해주세요."
                                           class="input textfield__input textfield__input--gray" id="confirm_password" name="confirm_password" required >
                                    <div class="body__button-group">
                                        <button type="button" class="button button--blank-gray password__cancel">취소</button>
                                        <button type="button" class="button button--blank" id="confirmPasswordBtn" onclick="changePassword();" disabled>완료</button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="alert-modal" class="alert-modal">
        <div class="alert-modal__container">
            <div class="alert-modal__top">
                <p>
                    정회원 승격 요청 시, 사업자 등록증 첨부가<br>
                    필요합니다. 일반 회원 가입 시 입력한 정보는<br>
                    수정 불가합니다. 정회원 승격 후에도<br>
                    일반 회원으로 활동한 정보는 유지됩니다.
                </p>
            </div>
            <div class="alert-modal__bottom">
                <div class="button-group">
                    <button type="button" class="button button--solid-gray" onclick="closeModal('#alert-modal')">
                        취소
                    </button>
                    <button type="button" class="button button--solid" onclick="location.href='/mypage/request/regular'">
                        확인
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
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