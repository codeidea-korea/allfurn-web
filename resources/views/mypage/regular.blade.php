@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
<script defer src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<div id="container" class="container">
    <div class="inner">
        <div class="content">
            <div class="mypage__set promotion--request">
                <ul class="breadcrumbs-wrap">
                    <li>계정 관리</li>
                    <li>정회원 승격 요청</li>
                </ul>

                <div class="set__head">
                    <h2>정회원 승격 요청</h2>
                    <ul class="notice-wrap notice-wrap--group mt16">
                        <li>
                            <i class="ico__info"><span class="a11y">공지</span></i>
                            <p>일반 회원 가입 시 입력한 정보는 수정하실 수 없습니다.</p>
                        </li>
                        <li>
                            <i class="ico__info"><span class="a11y">공지</span></i>
                            <p>다른 이메일로 정회원 승격을 원하실 경우 신규 가입을 진행해주세요.</p>
                        </li>
                        <li>
                            <i class="ico__info"><span class="a11y">공지</span></i>
                            <p>승인 이후 대표 계정에 소속된 직원 계정을 생성하실 수 있습니다.</p>
                        </li>
                    </ul>
                </div>

                <form id="regularForm" name="regularForm">
                    <div class="set__inner">
                    <div class="set__form">
                        <ul class="form__list-wrap">
                            <li class="form__list-item">
                                <div class="list__title">
                                    <span class="list__text01 required mt0">회원 구분</span>
                                </div>
                                <div class="list__desc">
                                    <ul class="body__radio-wrap">
                                        <li>
                                            <label>
                                                <input type="radio" name="type" value="W" class="checkbox__checked" checked>
                                                <span>도매</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="radio" name="type" value="R" class="checkbox__checked">
                                                <span>소매</span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="form__list-item">
                                <div class="list__title">
                                    <span class="list__text01 mt0 required">가입자명</span>
                                </div>
                                <div class="list__desc">
                                    <p class="list__text02">{{ $user->name }}</p>
                                </div>
                            </li>
                            <li class="form__list-item">
                                <div class="list__title">
                                    <label class="list__text01 required">사업자 등록 번호</label>
                                </div>
                                <div class="list__desc">
                                    <input class="input textfield__input textfield__input--gray" type="text" name="business_license_number" id="business_license_number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required placeholder="사업자 등록 번호를 입력해주세요.">
                                </div>
                            </li>
                            <li class="form__list-item">
                                <div class="list__title">
                                    <label class="list__text01 required">사업자 등록증 첨부</label>
                                </div>
                                <div class="list__desc">
                                    <div class="desc__gallery" id="previewSelectImage">
                                        <input class="input file-input" type="file" name="business_license_image" id="business_license_image" placeholder="이미지 추가" accept="image/jpg, image/png, image/jpeg">
                                        <div class="desc__input-placeholder">
                                            <i class="ico__gallery--gray default-add-image"><span class="a11y">갤러리</span></i>
                                            <p class="default-add-image">이미지 추가</p>
                                            <a class="ico__sdelete hidden" role="button" href="javascript:void(0);" id="deletePreviewLogoImage"><span class="a11y">삭제</span></a>
                                        </div>
                                    </div>
                                    <div class="notice-wrap mt10">
                                        <p>· 권장 형식: jpg, jpeg, png</p>
                                    </div>
                                </div>
                            </li>
                            <li class="form__list-item">
                                <div class="list__title">
                                    <label class="list__text01 required">업체명</label>
                                </div>
                                <div class="list__desc">
                                    <input class="input textfield__input textfield__input--gray" id="company_name" name="company_name" type="text" required
                                           placeholder="업체명을 입력해주세요.">
                                </div>
                            </li>
                            <li class="form__list-item">
                                <div class="list__title">
                                    <label class="list__text01 required">대표자명</label>
                                </div>
                                <div class="list__desc">
                                    <input class="input textfield__input textfield__input--gray" id="owner_name" name="owner_name" type="text" required
                                           placeholder="대표자명을 입력해주세요.">
                                </div>
                            </li>
                            <li class="form__list-item">
                                <div class="list__title">
                                    <span class="list__text01 mt0 required">휴대폰 번호</span>
                                </div>
                                <div class="list__desc">
                                    <p class="list__text02">{{ $user->phone_number }}</p>
                                    <div class="notice-wrap mt10">
                                        <p>· 해당 번호로 가입 승인 결과 문자가 전송됩니다.</p>
                                    </div>
                                </div>
                            </li>
                            <li class="form__list-item">
                                <div class="list__title">
                                    <label class="list__text01 mt0 required" for="form-list08">사업자 주소</label>
                                </div>
                                <div class="list__desc">
                                    <ul class="body__radio-wrap">
                                        <li>
                                            <label>
                                                <input type="radio" name="is_domestic" value="1" onclick="changeDomesticType(this)" class="checkbox__checked checkbox__checked01" checked>
                                                <span>국내</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="radio" name="is_domestic" value="0" onclick="changeDomesticType(this)" class="checkbox__checked checkbox__checked02">
                                                <span>해외</span>
                                            </label>
                                        </li>
                                    </ul>

                                    <!-- 국내 -->
                                    <div class="location--type01">
                                        <div class="input__guid">
                                            <input type="text" placeholder="주소를 검색해주세요." class="input-guid__input" name="default_address" id="default_address" readonly onclick="callMapApi()">
                                            <button type="button" class="input-guid__button" onclick="callMapApi()">주소 검색</button>
                                        </div>
                                    </div>
                                    <!-- 해외 -->
                                    <div class="location--type02 hidden">
                                        <input type="hidden" name="domestic_type" id="domestic_type" value="" />
                                        <div class="dropdown dropdown--type01">
                                            <p class="dropdown__title">지역</p>
                                            <div class="dropdown__wrap">
{{--                                                @foreach(config('constants.GLOBAL_DOMESTIC') as $domestic)--}}
{{--                                                    <a href="javascript:void(0);" class="dropdown__item" data-domestic-type="{{ $loop->index + 1 }}" onclick="setDomesticType(this)">--}}
{{--                                                        <p>{{ $domestic }}</p>--}}
{{--                                                    </a>--}}
{{--                                                @endforeach--}}
                                            </div>
                                        </div>
                                    </div>
                                    <input type="text" placeholder="상세 주소를 입력해주세요."  name="detail_address" id="detail_address" class="input textfield__input textfield__input--gray mt10">
                                </div>
                            </li>
                            <li class="form__list-item">
                                <div class="list__title">
                                    <span class="list__text01 mt0 required">이메일(아이디)</span>
                                </div>
                                <div class="list__desc">
                                    <p class="list__text02">{{ $user->account }}</p>
                                    <div class="notice-wrap mt10">
                                        <p>· 이메일이 아이디로 사용됩니다.</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                </form>

                <div class="form__button-group">
                    <button type="button" class="button button--blank-gray">취소</button>
                    <button type="button" class="button button--solid" id="confirmFormBtn" disabled onclick="submitRegularForm()">완료</button>
                </div>
            </div>

            <!-- 정회원 승격 요청 완료 팝업 -->
            <div id="alert-modal" class="alert-modal">
                <div class="alert-modal__container">
                    <div class="alert-modal__top">
                        <p>
                            정회원 승격 요청이 완료되었습니다.<br>
                            승인 결과는 영업일 기준 5일 내 문자로<br>
                            전송됩니다. 가입 시 입력한 이메일로<br>
                            로그인해주세요.
                        </p>
                    </div>
                    <div class="alert-modal__bottom">
                        <button type="button" class="button button--solid" onclick="successRequest()">
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
        const validateCheckList = {
            checkedLicenseNumber: false, // 사업자 등록 번호 빈값 확인
            checkedLicenseNumberImage: false, // 사업자 등록 번호 이미지 빈값 확인
            checkedCompanyName: false, // 업체명 빈값 확인
            checkedOwnerName: false, // 대표자명 빈값 확인
            checkedAddress: false, // 주소 빈값 검사
        }

        // 국내, 해외 라디오 버튼 클릭 시 히든 값 입력
        const setDomesticType = elem => {
            const parent = elem.closest('.location--type02');
            parent.querySelector('[name*=domestic_type]').value = elem.dataset.domesticType;
            validateAddress();
        }

        // 우편 지도 api 호출
        const callMapApi = () => {
            new daum.Postcode({
                oncomplete: function(data) {
                    document.getElementById('default_address').value = data.roadAddress;
                    validateAddress();
                }
            }).open();
        }

        // 국내, 해외 라디오 버튼 클릭 시 주소 입력 화면 변경
        const changeDomesticType = elem => {
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
            validateAddress();
        }

        const submitRegularForm = () => {
            if (validate() === false) {
                return false;
            }
            const formData = new FormData(document.getElementById('regularForm'));
            fetch('/mypage/request/regular', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            }).then(response => {
                return response.json();
            }).then(json => {
                if (json.result === 'success') {
                    openModal('#alert-modal');
                } else {
                    alert(json.message);
                }
            })

        }
        const validateLicenseNumber = () => {
            if (document.getElementById('business_license_number').value === '') {
                validateCheckList.checkedLicenseNumber = false;
            } else {
                validateCheckList.checkedLicenseNumber = true;
            }
            validate();
        }
        const validateLicenseNumberImage = () => {
            if (document.getElementById('business_license_image').value === '') {
                validateCheckList.checkedLicenseNumberImage = false;
            } else {
                validateCheckList.checkedLicenseNumberImage = true;
            }
            validate();
        }
        const validateCompanyName = () => {
            if (document.getElementById('company_name').value === '') {
                validateCheckList.checkedCompanyName = false;
            } else {
                validateCheckList.checkedCompanyName = true;
            }
            validate();
        }
        const validateOwnerName = () => {
            if (document.getElementById('owner_name').value === '') {
                validateCheckList.checkedOwnerName = false;
            } else {
                validateCheckList.checkedOwnerName = true;
            }
            validate();
        }
        const validateAddress = () => {
            if (document.querySelector('[name=is_domestic]:checked').value === '1') { // 국내
                if (document.getElementById('default_address').value === '') {
                    validateCheckList.checkedAddress = false;
                } else {
                    validateCheckList.checkedAddress = true;
                }
            } else { // 해외
                if (document.getElementById('domestic_type').value === '') {
                    validateCheckList.checkedAddress = false;
                } else {
                    validateCheckList.checkedAddress = true;
                }
            }
            validate();
        }

        const validate = () => {
            let result = true;
            for (const check in validateCheckList) {
                if (validateCheckList[check] === false) {
                    document.getElementById('confirmFormBtn').setAttribute('disabled', 'disabled');
                    result = false;
                    return false;
                }
            }
            if (result) {
                document.getElementById('confirmFormBtn').removeAttribute('disabled');
            }
            return result;
        }

        const successRequest = () => {
            location.href= '/signin';
        }

        const previewImage = evt => {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewSelectImage').style.backgroundImage = "url('"+e.target.result+"')";
                document.getElementById('previewSelectImage').style.backgroundSize = "100%";
                document.getElementById('deletePreviewLogoImage').classList.remove('hidden');
                document.querySelectorAll('.default-add-image').forEach(elem => elem.classList.add('hidden'));
            };
            if (evt.currentTarget.files.length) {
                reader.readAsDataURL(evt.currentTarget.files[0]);
            } else {
                document.getElementById('previewSelectImage').removeAttribute('style');
                document.getElementById('deletePreviewLogoImage').classList.add('hidden');
                document.querySelectorAll('.default-add-image').forEach(elem => elem.classList.remove('hidden'));
            }
        }

        {{-- 미리보기 이미지 삭제 --}}
        const deletePreviewLogoImage = () => {
            document.getElementById('business_license_image').value = '';
            const e = new Event("change");
            const element = document.getElementById('business_license_image')
            element.dispatchEvent(e);
        }

        document.getElementById('business_license_image').addEventListener('change', e => {
            previewImage(e);
            validateLicenseNumberImage();
        });

        document.getElementById('deletePreviewLogoImage').addEventListener('click', deletePreviewLogoImage);
        document.getElementById('business_license_number').addEventListener('keyup', validateLicenseNumber);
        document.getElementById('company_name').addEventListener('keyup', validateCompanyName);
        document.getElementById('owner_name').addEventListener('keyup', validateOwnerName);
    </script>
@endpush
