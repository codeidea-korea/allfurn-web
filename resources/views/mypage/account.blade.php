<div class="my__section account-managemenet">
    <div class="content">
        <div class="section">
            <div class="section__head">
                <div class="section__head__group">
                    <h3 class="section__title">계정 관리</h3>
                </div>
            </div>
            <div class="section__content">
                <div class="content__head">
                    <h4>아이디 인증</h4>
                    <div class="notice-wrap display-flex">
                        <i class="ico__info"><span class="a11y">공지</span></i>
                        <p>아이디 인증 후 계정 관리가 가능합니다.</p>
                    </div>
                </div>

                <div class="content__body">
                    <ul class="body__auth-wrap">
                        <li class="auth__item">
                            <div class="item__head me-2">
                                <label class="head__text">아이디</label>
                            </div>
                            <div class="item__body">
                                <div class="input__guid">
                                    <input type="text" placeholder="아이디를 입력해주세요." value="{{ auth()->user()['account'] }}" class="input-guid__input" name="email" id="email" disabled>
                                    <button type="button" id="sendAuthCode" onclick="sendEmailAuthCode()" class="input-guid__button" data-is-retry="">인증번호 전송</button>
                                </div>
                                <div class="attchment-wrap hidden" id="successSendEmail">
                                    <i class="ico__check--blue"></i>
                                    <p class="attchment__text">인증번호가 전송되었습니다. 휴대폰을 확인해주세요.</p>
                                </div>
                                <div class="attchment-wrap hidden" id="failSendEmail">
                                    <i class="ico__check--red"></i>
                                    <p class="attchment__text fail"></p>
                                </div>
                            </div>
                        </li>
                        
                        <li class="auth__item">
                            <div class="item__head me-2">
                                <label class="head__text">인증번호</label>
                            </div>
                            <div class="item__body">
                                <div class="input__guid input__guid--time">
                                    <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  placeholder="인증번호를 입력해주세요." class="input-guid__input" id="authcode" name="authcode">
                                    <div class="time-wrap hidden" id="timeWrap">
                                        <p id="count">04:59</p>
                                    </div>
                                    <button type="button" class="input-guid__button" id="authBtn" disabled onclick="toAuthentic()">인증하기</button>
                                </div>
                                <div class="attchment-wrap hidden" id="successAuthentic">
                                    <i class="ico__check--blue"></i>
                                    <p class="attchment__text">인증되었습니다.</p>
                                </div>
                                <div class="attchment-wrap hidden" id="failAuthentic">
                                    <i class="ico__check--red"></i>
                                    <p class="attchment__text fail">인증번호가 일치하지 않습니다. 다시 확인해주세요.</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="body__button">
                        <button type="button" class="button button--solid" id="completeBtn" disabled onclick="viewCompanyAccount(this)">완료</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    
    let time_proc_interval = '';
    let time = 299;

    const sendEmailAuthCode = () => {
        document.getElementById('successAuthentic').classList.add('hidden');
        document.getElementById('failAuthentic').classList.add('hidden');
        if (!document.getElementById('email').value) {
            alert('아이디를 입력해주세요.');
            return false;
        }
        
        // if (validateEmail() === false) {
        //     alert('정상적인 이메일을 입력해주세요.');
        //     return false;
        // }
        
        fetch('/mypage/account/send/auth/email', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            body: JSON.stringify({
                email: document.getElementById('email').value
            })
        }).then(response => {
            return response.json();
        }).then(json => {
            document.getElementById('failSendEmail').classList.add('hidden');
            document.getElementById('successSendEmail').classList.add('hidden');
            if (json.result === 'success') {
                if (document.getElementById('sendAuthCode').dataset.isRetry === '1') {
                    clearInterval(time_proc_interval);
                    time = 299;
                    time_proc_interval = setInterval(timer, 1000);
                } else {
                    document.getElementById('authBtn').removeAttribute('disabled');
                    document.getElementById('sendAuthCode').textContent = '인증번호 재전송';
                    document.getElementById('sendAuthCode').dataset.isRetry = '1';
                    time_proc_interval = setInterval(timer, 1000);
                }
                document.getElementById('successSendEmail').classList.remove('hidden');
                document.getElementById('timeWrap').classList.remove('hidden');
            } else {
                document.getElementById('failSendEmail').classList.remove('hidden');
                document.querySelector('#failSendEmail .attchment__text').textContent = json.message;
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
                document.getElementById('successAuthentic').classList.remove('hidden');
                document.getElementById('authcode').setAttribute('disabled', 'disabled');
                clearInterval(time_proc_interval);
                document.getElementById('timeWrap').classList.add('hidden');
                document.getElementById('authBtn').setAttribute('disabled', 'disabled');
                document.getElementById('email').setAttribute('disabled', 'disabled');
                document.getElementById('sendAuthCode').setAttribute('disabled', 'disabled');
                document.getElementById('completeBtn').removeAttribute('disabled');
            } else {
                document.getElementById('failAuthentic').classList.remove('hidden');
                document.querySelector('#failAuthentic .attchment__text').textContent = json.message;
            }
        })
    }

    const viewCompanyAccount = elem => {
        if (!elem.getAttribute('disabled')) {
            @if (auth()->user()['type'] === 'N')
                location.href = '/mypage/normal-account';
            @else
                location.href = '/mypage/company-account';
            @endif
        }
    }

    const validateEmail = () => {
        let regex = new RegExp('[a-z0-9]+@[a-z]+\.[a-z]{2,3}');
        return regex.test(document.getElementById('email').value);
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

