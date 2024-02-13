@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
<div id="container" class="container" style="min-height: calc(100vh - 409px)">
    <div class="inner">
        <div class="content">
            <div class="mypage__set account--add">
                <ul class="breadcrumbs-wrap">
                    <li>계정 관리</li>
                    <li>직원 계정 {{ $idx ? '수정' : '추가'}}</li>
                </ul>

                <div class="set__head">
                    @if($idx)
                        <div class="notice-wrap display-flex mt10">
                            <i class="ico__info"><span class="a11y">공지</span></i>
                            <p>비밀번호 변경을 원하시는 경우만 비밀번호/비밀번호 확인을 입력해주세요.</p>
                        </div>
                    @else
                        <h2>계정 추가</h2>
                    @endif
                </div>

                <form name="memberForm" id="memberForm">
                    <div class="set__inner">
                    @if($idx)
                        <input type="hidden" name="idx" id="idx" value="{{ $idx }}" />
                    @endif
                    <div class="set__form">
                        <ul class="form__list-wrap">
                            <li class="form__list-item">
                                <div class="list__title">
                                    <label class="list__text01 required">이름</label>
                                </div>
                                <div class="list__desc">
                                    <input class="input textfield__input textfield__input--gray" value="{{ isset($member->name) ? $member->name : '' }}" name="member_name" id="member_name" type="text" required placeholder="이름을 입력해주세요.">
                                </div>
                            </li>
                            <li class="form__list-item">
                                <div class="list__title">
                                    <label class="list__text01 required">휴대폰 번호</label>
                                </div>
                                <div class="list__desc">
                                    <input class="input textfield__input textfield__input--gray" value="{{ isset($member->phone_number) ? $member->phone_number : '' }}" name="member_phone_number" id="member_phone_number" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required placeholder="-없이 숫자만 입력해주세요.">
                                </div>
                            </li>
                            <li class="form__list-item">
                                <div class="list__title">
                                    <label class="list__text01 required">아이디</label>
                                </div>
                                <div class="list__desc">
                                    <input class="input textfield__input textfield__input--gray" value="{{ isset($member->account) ? $member->account : '' }}" name="member_account" id="member_account" type="text" required placeholder="아이디를 입력해주세요.">
                                    <div class="notice-wrap mt10">
                                        <p>· 4자리 이상 입력해주세요</p>
                                    </div>
                                </div>
                            </li>
                            <li class="form__list-item">
                                <div class="list__title">
                                    <label class="list__text01 {{ $idx ? '' : 'required'}}">비밀번호</label>
                                </div>
                                <div class="list__desc">
                                    <input class="input textfield__input textfield__input--gray" name="password" id="password" type="password" required placeholder="비밀번호를 입력해주세요.">
                                    <div class="notice-wrap mt10">
                                        <p>· 영문 및 숫자 혼합하여 8자리 이상 입력해주세요</p>
                                    </div>
                                    <div class="valid__input hidden" id="failPassword">
                                        <i class="ico__check--red"></i>
                                        <p class="valid__text fail">인증번호가 일치하지 않습니다. 다시 확인해주세요.</p>
                                    </div>
                                </div>
                            </li>
                            <li class="form__list-item">
                                <div class="list__title">
                                    <label class="list__text01 {{ $idx ? '' : 'required'}}">비밀번호 확인</label>
                                </div>
                                <div class="list__desc">
                                    <input class="input textfield__input textfield__input--gray" name="confirm_password" id="confirm_password" type="password" required placeholder="비밀번호를 다시 입력해주세요.">
                                    <div class="valid__input hidden" id="failPasswordConfirm">
                                        <i class="ico__check--red"></i>
                                        <p class="valid__text fail">인증번호가 일치하지 않습니다. 다시 확인해주세요.</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                </form>

                <div class="form__button-group">
                    <button type="button" class="button button--blank-gray" onclick="history.back()">취소</button>
                    <button type="button" class="button button--solid" onclick="setMember()" disabled id="confirmPasswordBtn">완료</button>
                </div>
            </div>

            <!-- 아이디 중복 오류 팝업 -->
            <div id="alert-modal01" class="alert-modal">
                <div class="alert-modal__container">
                    <div class="alert-modal__top">
                        <p>
                            중복된 아이디가 있습니다. 다시 입력해주세요.
                        </p>
                    </div>
                    <div class="alert-modal__bottom">
                        <button type="button" class="button button--solid" onclick="closeModal('#alert-modal01')">
                            확인
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        @if($idx)
            const validateCheckList = {
                checkedName: true, // 이름 빈값 확인
                checkedPhoneNumber: true, // 휴대폰 빈값 확인
                checkedId: true, // 아이디 빈값 확인
                checkedIdLength: true, // 아이디 길이 확인
                checkedPasswordValidate: true, // 패스워드 유효성 검사
                checkedComparePassword: true, // 패스워드 같은지 확인
            }
        @else
            const validateCheckList = {
                checkedName: false, // 이름 빈값 확인
                checkedPhoneNumber: false, // 휴대폰 빈값 확인
                checkedId: false, // 아이디 빈값 확인
                checkedIdLength: false, // 아이디 길이 확인
                checkedPasswordValidate: false, // 패스워드 유효성 검사
                checkedComparePassword: false, // 패스워드 같은지 확인
            }
        @endif

        const setMember = () => {
            if (validate() === false) {
                alert('유효성 검사 실패');
                return false;
            }
            const data = new URLSearchParams();
            for (const pair of new FormData(document.getElementById('memberForm'))) {
                data.append(pair[0], pair[1]);
            }
            fetch('/mypage/company-member', {
                method: '{{ $idx ? 'PUT' : 'POST' }}',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: data,
            }).then(response => {
                return response.json();
            }).then(json => {
                if (json.result === 'success') {
                    location.replace('/mypage/company-account');
                } else {
                    if (json.code === 'DUPLICATE_ID') {
                        openModal('#alert-modal01');
                        return false;
                    } else {
                        alert(json.message);
                        return false;
                    }
                }
            })
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

        const validatePassword = () => {
            @if($idx)
                if (!document.getElementById('password').value && !document.getElementById('confirm_password').value) {
                    validateCheckList.checkedComparePassword = true;
                    validateCheckList.checkedPasswordValidate = true;
                    validate();
                    return false;
                }
            @endif
            const regExp = /^.*(?=^.{8,}$)(?=.*\d)(?=.*[a-zA-Z]).*$/;
            if (document.getElementById('password').value.match(regExp) === null) {
                validateCheckList.checkedPasswordValidate = false;
            } else {
                if (document.getElementById('confirm_password').value) {
                    if (document.getElementById('confirm_password').value !== document.getElementById('password').value) {
                        validateCheckList.checkedComparePassword = false;
                    } else {
                        document.querySelector('#failPasswordConfirm p').textContent = '';
                        document.querySelector('#failPasswordConfirm').classList.add('hidden');
                        document.getElementById('confirm_password').classList.remove('textfield__input--red');
                        validateCheckList.checkedComparePassword = true;
                    }
                }
                document.querySelector('#failPassword p').textContent = '';
                document.querySelector('#failPassword').classList.add('hidden');
                document.getElementById('password').classList.remove('textfield__input--red');
                validateCheckList.checkedPasswordValidate = true;
            }
            validate();
        }
        const validatePasswordBlur = () => {
            @if($idx)
            if (!document.getElementById('password').value && !document.getElementById('confirm_password').value) {
                validateCheckList.checkedComparePassword = true;
                validateCheckList.checkedPasswordValidate = true;
                validate();
                return false;
            }
            @endif
            const regExp = /^.*(?=^.{8,}$)(?=.*\d)(?=.*[a-zA-Z]).*$/;
            if (document.getElementById('password').value.match(regExp) === null) {
                document.querySelector('#failPassword p').textContent = '영문 및 숫자 혼합하여 8자리 이상 입력해주세요';
                document.querySelector('#failPassword').classList.remove('hidden');
                document.getElementById('password').classList.add('textfield__input--red');
            } else {
                if (document.getElementById('confirm_password').value !== document.getElementById('password').value && document.getElementById('confirm_password').value.length > 0) {
                    if (document.getElementById('confirm_password').value !== document.getElementById('password').value) {
                        document.querySelector('#failPasswordConfirm p').textContent = '비밀번호가 일치하지 않습니다.';
                        document.querySelector('#failPasswordConfirm').classList.remove('hidden');
                        document.getElementById('confirm_password').classList.add('textfield__input--red');
                        validateCheckList.checkedComparePassword = false;
                    } else {
                        document.querySelector('#failPasswordConfirm p').textContent = '';
                        document.querySelector('#failPasswordConfirm').classList.add('hidden');
                        document.getElementById('confirm_password').classList.remove('textfield__input--red');
                        validateCheckList.checkedComparePassword = true;
                    }
                }
                document.querySelector('#failPassword p').textContent = '';
                document.querySelector('#failPassword').classList.add('hidden');
                document.getElementById('password').classList.remove('textfield__input--red');
                validateCheckList.checkedPasswordValidate = true;
            }
            validate();
        }
        const validateConfirmPassword = () => {
            @if($idx)
            if (!document.getElementById('password').value && !document.getElementById('confirm_password').value) {
                validateCheckList.checkedComparePassword = true;
                validateCheckList.checkedPasswordValidate = true;
                validate();
                return false;
            }
            @endif
            if (document.getElementById('confirm_password').value) {
                if (document.getElementById('confirm_password').value !== document.getElementById('password').value) {
                    validateCheckList.checkedComparePassword = false;
                } else {
                    document.querySelector('#failPasswordConfirm p').textContent = '';
                    document.querySelector('#failPasswordConfirm').classList.add('hidden');
                    document.getElementById('confirm_password').classList.remove('textfield__input--red');
                    validateCheckList.checkedComparePassword = true;
                }
            }
            validate();
        }
        const validateConfirmPasswordBlur = () => {
            @if($idx)
            if (!document.getElementById('password').value && !document.getElementById('confirm_password').value) {
                validateCheckList.checkedComparePassword = true;
                validateCheckList.checkedPasswordValidate = true;
                validate();
                return false;
            }
            @endif
            if (document.getElementById('confirm_password').value) {
                if (document.getElementById('confirm_password').value !== document.getElementById('password').value) {
                    document.querySelector('#failPasswordConfirm p').textContent = '비밀번호가 일치하지 않습니다.';
                    document.querySelector('#failPasswordConfirm').classList.remove('hidden');
                    document.getElementById('confirm_password').classList.add('textfield__input--red');
                    validateCheckList.checkedComparePassword = false;
                } else {
                    document.querySelector('#failPasswordConfirm p').textContent = '';
                    document.querySelector('#failPasswordConfirm').classList.add('hidden');
                    document.getElementById('confirm_password').classList.remove('textfield__input--red');
                    validateCheckList.checkedComparePassword = true;
                }
            }
            validate();
        }
        document.getElementById('member_name').addEventListener('keyup', validateName);
        document.getElementById('member_phone_number').addEventListener('keyup', validatePhoneNumber);
        document.getElementById('member_account').addEventListener('keyup', validateId);
        document.getElementById('password').addEventListener('keyup', validatePassword);
        document.getElementById('password').addEventListener('blur', validatePasswordBlur);
        document.getElementById('confirm_password').addEventListener('keyup', validateConfirmPassword);
        document.getElementById('confirm_password').addEventListener('blur', validateConfirmPasswordBlur);

        const validate = () => {
            let result = true;
            for (const check in validateCheckList) {
                if (validateCheckList[check] === false) {
                    document.getElementById('confirmPasswordBtn').setAttribute('disabled', 'disabled');
                    result = false;
                    return false;
                }
            }
            if (result) {
                document.getElementById('confirmPasswordBtn').removeAttribute('disabled');
            }
            return result;
        }
        validate();
    </script>
@endpush
