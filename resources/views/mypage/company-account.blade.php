<!-- <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script> -->

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
                        <h4>대표</h4>
                        <div class="notice-wrap display-flex">
                            <i class="ico__info"><span class="a11y">공지</span></i>
                            <p>대표 계정 정보는 고객센터에 문의하여 변경 요청해주세요.</p>
                        </div>
                    </div>

                    <div class="content__body">
                        <ul class="body__auth-wrap">
                            <li class="auth__item">
                                <div class="item__head">
                                    <span class="head__text" for="input-list01">회원 구분</span>
                                </div>
                                <div class="item__body">
                                    <input type="text" placeholder="" value="{{ $user->type === 'W' ? '도매' : '소매' }}" class="input textfield__input textfield__input--gray" id="input-list01" disabled>
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
                                    <span class="head__text" for="input-list03">사업자 등록 번호</span>
                                </div>
                                <div class="item__body download">
                                    <input type="text" placeholder="" value="{{ $company->business_license_number }}" class="input textfield__input textfield__input--gray" id="input-list03" disabled>
                                    <button type="button" class="ico__gallery28--gray" onclick="downloadBusinessLicense('{{ $company->license_image }}')"><span class="a11y">다운로드</span></button>
                                </div>
                            </li>
                            <li class="auth__item">
                                <div class="item__head">
                                    <span class="head__text" for="input-list04">업체명</span>
                                </div>
                                <div class="item__body">
                                    <input type="text" placeholder="" value="{{ $company->company_name }}" class="input textfield__input textfield__input--gray" id="input-list04" disabled>
                                </div>
                            </li>
                            <li class="auth__item">
                                <div class="item__head">
                                    <span class="head__text" for="input-list05">대표자명</span>
                                </div>
                                <div class="item__body">
                                    <input type="text" placeholder="" value="{{ $company->owner_name }}" class="input textfield__input textfield__input--gray" id="input-list05" disabled>
                                </div>
                            </li>

                            <li class="auth__item" id="visiblePhoneWrap">
                                <div class="item__head">
                                    <label class="head__text">휴대폰 번호</label>
                                </div>
                                <div>
                                    <div class="input__guid">
                                        <input type="text" placeholder="휴대폰 번호를 입력해주세요." value="{{ $company->phone_number }}" class="input-guid__input" id="disabledPhoneNumber" disabled>
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
                                        <input type="text" placeholder="휴대폰 번호를 입력해주세요." value="{{ $company->phone_number }}"
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

                            <li class="auth__item" id="visibleAddressWrap">
                                <div class="item__head">
                                    <label class="head__text">사업자 주소</label>
                                </div>
                                <div>
                                    <div class="input__guid">
                                        <input type="text" placeholder="사업자 주소를 입력해주세요." value="{{ $company->business_address }} {{ $company->business_address_detail }}" class="input-guid__input" id="disabledAddress" disabled>
                                        <button type="button" class="input-guid__button" onclick="updateAddress()">수정</button>
                                    </div>
                                </div>
                            </li>

                            <li class="auth__item hidden" id="updateAddressWrap">
                                <div class="item__head item__head-radio">
                                    <label class="head__text" for="input-list07">사업자 주소</label>
                                </div>
                                <div class="item__body">
                                    <ul class="body__radio-wrap">
                                        <li>
                                            <label>
                                                <input type="radio" name="is_domestic" class="checkbox__checked" onclick="changeDomesticType(this)" value="1" checked>
                                                <span>국내</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="radio" name="is_domestic" class="checkbox__checked" onclick="changeDomesticType(this)" value="0">
                                                <span>해외</span>
                                            </label>
                                        </li>
                                    </ul>
                                    <div class="location--type02 hidden">
                                        <input type="hidden" name="domestic_type" id="domestic_type" value="" />
                                        <div class="dropdown dropdown--type01">
                                            <p class="dropdown__title">지역</p>
                                            <div class="dropdown__wrap">
                                                @foreach(config('constants.GLOBAL_DOMESTIC') as $domestic)
                                                    <a href="javascript:void(0);" class="dropdown__item" data-domestic-type="{{ $loop->index + 1 }}" onclick="setDomesticType(this)">
                                                        <p>{{ $domestic }}</p>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input__guid location--type01">
                                        <input type="text" placeholder="사업자 주소를 입력해주세요." value="{{ $company->business_address }}"
                                               class="input-guid__input" name="default_address" id="default_address" readonly onclick="callMapApi()">
                                        <button type="button" class="input-guid__button" onclick="callMapApi()">주소 검색</button>
                                    </div>
                                    <input type="text" placeholder="상세 주소를 입력해주세요." value="{{ $company->business_address_detail }}"
                                           class="input textfield__input textfield__input--gray" name="detail_address" id="detail_address" style="margin-top: 10px;">
                                    <div class="body__button-group">
                                        <button type="button" class="button button--blank-gray" onclick="cancelAddress()">취소</button>
                                        <button type="button" class="button button--blank" id="completeAddressBtn" onclick="updateAddressProc()">완료</button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="content__item02">
                    <div class="content__head">
                        <div class="head__group">
                            <h4>직원<span>(최대 5명)</span></h4>
                            <button type="button" onclick="location.href='/mypage/company-member'">
                                <i class="ico__add--circle"><span class="a11y">추가</span></i>
                                <span>계정 추가</span>
                            </button>
                        </div>
                    </div>
                    <div class="content__body">
                        @if (count($members) < 1)
                        <div class="account-none">
                            <i class="ico__info"><span class="a11y">공지</span></i>
                            <p>계정을 등록해주세요.</p>
                        </div>
                        @else
                        <div class="table-wrap">
                            <table>
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>이름</th>
                                    <th>휴대폰 번호</th>
                                    <th>아이디</th>
                                    <th>&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($members as $member)
                                <tr>
                                    <td>{{ $loop->index +1 }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->phone_number }}</td>
                                    <td>{{ $member->account }}</td>
                                    <td>
                                        <ul class="edit-delete-wrap">
                                            <li>
                                                <button type="button" onclick="location.href='/mypage/company-member/{{ $member->idx }}'">
                                                    수정
                                                </button>
                                            </li>
                                            <li>
                                                <button type="button" onclick="deleteMemberModal({{ $member->idx }})">
                                                    삭제
                                                </button>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>

                    <!-- 계정 삭제 팝업 -->
                    <div id="alert-modal01" class="alert-modal">
                        <div class="alert-modal__container">
                            <div class="alert-modal__top">
                                <p>
                                    계정을 삭제하시겠습니까?<br>
                                    삭제한 계정은 복구할 수 없습니다.
                                </p>
                            </div>
                            <div class="alert-modal__bottom">
                                <div class="button-group">
                                    <button type="button" class="button button--solid-gray" onclick="closeModal('#alert-modal01')">
                                        취소
                                    </button>
                                    <button type="button" class="button button--solid" onclick="deleteMember();" id="confirmDeleteBtn" data-idx="">
                                        확인
                                    </button>
                                </div>
                            </div>
                        </div>
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
</div>

<script>
    let time_proc_interval = '';
    let time = 299;

    const downloadBusinessLicense = licenseImage => {
        const link = document.createElement('a');
        link.href = licenseImage;
        link.download = 'license_image.jpg';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
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
                document.getElementById('phone_number').setAttribute('disabled', 'disabled');
                document.getElementById('sendAuthCode').setAttribute('disabled', 'disabled');
                document.getElementById('completeBtn').removeAttribute('disabled');
            } else {
                document.getElementById('failAuthentic').classList.remove('hidden');
                document.querySelector('#failAuthentic .attchment__text').textContent = json.message;
            }
        })
    }

    const sendAuthBtnDisabled = elem => {
        if (elem.value) {
            document.getElementById('sendAuthCode').removeAttribute('disabled');
        } else {
            document.getElementById('sendAuthCode').setAttribute('disabled', 'disabled');
        }
    }

    function updatePhone() {
        document.getElementById('updatePhoneWrap').classList.remove('hidden');
        document.getElementById('visiblePhoneWrap').classList.add('hidden');
    }

    const updateAddress = () => {
        document.getElementById('updateAddressWrap').classList.remove('hidden');
        document.getElementById('visibleAddressWrap').classList.add('hidden');
    }

    const cancelAuthPhone = () => {
        document.getElementById('updatePhoneWrap').classList.add('hidden');
        document.getElementById('visiblePhoneWrap').classList.remove('hidden');
    }

    const cancelAddress = () => {
        document.getElementById('updateAddressWrap').classList.add('hidden');
        document.getElementById('visibleAddressWrap').classList.remove('hidden');
    }

    // 국내, 해외 라디오 버튼 클릭 시 히든 값 입력
    const setDomesticType = elem => {
        const parent = elem.closest('.location--type02');
        parent.querySelector('[name*=domestic_type]').value = elem.dataset.domesticType;
        document.getElementById('completeAddressBtn').removeAttribute('disabled');
    }

    // 국내, 해외 라디오 버튼 클릭 시 주소 입력 화면 변경
    const changeDomesticType = elem => {
        document.getElementById('completeAddressBtn').setAttribute('disabled', 'disabled');
        document.getElementById('default_address').value = '';
        document.getElementById('domestic_type').value = '';
        if (elem.value === '1') { // 국내
            document.querySelector('.location--type01').classList.remove('hidden');
            document.querySelector('.location--type02').classList.add('hidden');
            document.querySelector('.location--type02 .dropdown__title').textContent = '지역';
        } else {
            document.querySelector('.location--type02').classList.remove('hidden');
            document.querySelector('.location--type01').classList.add('hidden');
        }
    }

    const setCompleteAddress = () => {
        if (document.getElementById('default_address').value) {
            document.getElementById('completeAddressBtn').removeAttribute('disabled');
        } else {
            document.getElementById('completeAddressBtn').setAttribute('disabled', 'disabled');
        }
    }

    // 우편 지도 api 호출
    const callMapApi = () => {
        new daum.Postcode({
            oncomplete: function(data) {
                document.getElementById('default_address').value = data.roadAddress;
                setCompleteAddress();
            }
        }).open();
    }

    const updatePhoneNumber = () => {
        fetch('/mypage/company-account', {
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

    const updateAddressProc = () => {
        const default_address = document.getElementById('default_address').value;
        const detail_address = document.getElementById('detail_address').value;
        const is_domestic = document.querySelector('input[type=radio][name=is_domestic]:checked').value;
        const domestic_type = document.querySelector('[name=domestic_type]').value;
        fetch('/mypage/company-account', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            body: JSON.stringify({default_address, detail_address, is_domestic, domestic_type})
        }).then(response => {
            return response.json();
        }).then(json => {
            if (json.result === 'success') {
                document.getElementById('disabledAddress').value = default_address + ' ' + detail_address;
                document.getElementById('updateAddressWrap').classList.add('hidden');
                document.getElementById('visibleAddressWrap').classList.remove('hidden');
            }
        })
    }

    const deleteMember = () => {
        const idx = document.getElementById('confirmDeleteBtn').dataset.idx;
        fetch('/mypage/company-account/' + idx, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        }).then(response => {
            return response.json();
        }).then(json => {
            location.reload();
        })
    }

    const deleteMemberModal = idx => {
        document.getElementById('confirmDeleteBtn').dataset.idx = idx;
        openModal('#alert-modal01');
    }

    let validatePasswordValue = false;
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
