<div class="w-full">
    <h3 class="text-xl font-bold">계정 관리</h3>

    <div class="com_setting mt-5">
        <p>아이디 인증</p>
        <div class="info">
            <div class="flex items-center gap-1">
                <img src="/img/member/info_icon.svg" alt="" class="w-4" />
                <p> 아이디 인증 후 계정 관리가 가능합니다.</p>
            </div>
        </div>
        <div class="border-t-2 border-t-stone-600 flex flex-col items-center justify-center border-b py-10 gap-6">
            <div class="flex gap-4">
                <div class="essential w-[190px] shrink-0 mt-2">아이디</div>
                <div>
                    <div class="font-medium w-full flex items-center gap-2">
                        <input type="text" name="email" id="email" class="setting_input h-[48px] w-[370px] font-normal" value="{{ auth() -> user()['account'] }}" placeholder="아이디를 입력해주세요." disabled />
                        <button type="button" id="sendAuthCode" class="border border-stone-500 rounded-md h-[48px] w-[120px] hover:bg-stone-100" data-is-retry="" onClick="sendEmailAuthCode();">인증번호 전송</button>
                    </div>
                    <div id="successSendEmail" class="text-blue-500 flex items-center mt-3 text-sm gap-1 hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check"><path d="M20 6 9 17l-5-5"/></svg>
                        인증번호가 전송되었습니다. 휴대폰을 확인해주세요.
                    </div>
                    <div id="failSendEmail" class="attchment-wrap hidden">
                        <i class="ico__check--red"></i>
                        <p class="attchment__text fail"></p>
                    </div>
                </div>
            </div>
            <div class="flex gap-4">
                <div class="essential w-[190px] shrink-0 mt-2">인증번호</div>
                <div>
                    <div class="font-medium w-full flex items-center gap-2">
                        <div class="setting_input h-[48px] w-[370px] font-normal flex items-center">
                            <input type="text" name="authcode" id="authcode" class="w-full h-full" placeholder="인증번호를 입력해주세요." oninput="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                            <div id="timeWrap" class="time-wrap hidden">
                                <span id="count" class="pl-3 ml-auto">04:59</span>
                            </div>
                        </div>
                        <button type="button" id="authBtn" class="border border-stone-200 rounded-md h-[48px] w-[120px] text-stone-400" onclick="toAuthentic();" disabled>인증하기</button>
                        <!-- <button class="border border-stone-500 rounded-md h-[48px] w-[120px] hover:bg-stone-100">인증하기</button> -->
                    </div>
                    <div id="successAuthentic" class="text-blue-500 flex items-center mt-3 text-sm gap-1 hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check"><path d="M20 6 9 17l-5-5"/></svg>
                        인증되었습니다.
                    </div>
                    <div id="failAuthentic" class="attchment-wrap hidden">
                        <i class="ico__check--red"></i>
                        <p class="attchment__text fail">인증번호가 일치하지 않습니다. 다시한번 확인해주세요.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center">
        <button type="button" id="completeBtn" class="btn w-1/4 btn-primary mt-5" onClick="viewCompanyAccount(this);" disabled>완료</button>
    </div>
</div>





<script defer src="/js/jquery-1.12.4.js" ></script>
<script>
    let time = 299;
    let time_proc_interval = '';

    const sendEmailAuthCode = () => {
        document.getElementById('successAuthentic').classList.add('hidden');
        document.getElementById('failAuthentic').classList.add('hidden');

        if (!document.getElementById('email').value) {
            alert('아이디를 입력해주세요.');
            return false;
        }
        
        fetch('/mypage/account/send/auth/email', {
            method      : 'POST',
            headers     : {
                'Content-Type'  : 'application/json',
                'X-CSRF-TOKEN'  : '{{csrf_token()}}'
            },
            body        : JSON.stringify({
                email: document.getElementById('email').value
            })
        }).then(response => {
            return response.json();
        }).then(json => {
            document.getElementById('successSendEmail').classList.add('hidden');
            document.getElementById('failSendEmail').classList.add('hidden');

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
            method  : 'POST',
            headers : {
                'Content-Type'  : 'application/json',
                'X-CSRF-TOKEN'  : '{{csrf_token()}}'
            },
            body: JSON.stringify({
                type        : 'S',
                authcode    : authcode
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
        });
    }

    const viewCompanyAccount = elem => {
        if (!elem.getAttribute('disabled')) {
            @if (auth() -> user()['type'] === 'N')
                location.href = '/mypage/normal-account';
            @else
                location.href = '/mypage/company-account';
            @endif
        }
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