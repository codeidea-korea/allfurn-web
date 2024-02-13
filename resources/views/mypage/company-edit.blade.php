@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
<link href="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/js/froala_editor.pkgd.min.js"></script>
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<div id="container" class="container" style="min-height: 100%">
    <div class="inner">
        <div class="content">
            <div class="mypage__set">
                <ul class="breadcrumbs-wrap">
                    <li>업체 관리</li>
                    <li>설정</li>
                </ul>

                <div class="set__head">
                    <h2>업체 소개/정보</h2>
                    <div class="notice-wrap display-flex mt16">
                        <i class="ico__info"><span class="a11y">공지</span></i>
                        <p>올바르지 않은 업체 정보 입력 및 이미지 등록 시 올펀 관리 정책에 따른 패널티를 받을 수 있습니다.</p>
                    </div>
                </div>

                <div class="set__inner">
                    <form name="companyForm" id="companyForm" method="PUT" action="/mypage/company" enctype="multipart/form-data">
                        <div class="set__form">
                        <ul class="form__list-wrap">
                            <li class="form__list-item">
                                <div class="list__title">
                                    <span class="list__text01 mt0">업체명</span>
                                </div>
                                <div class="list__desc">
                                    <p class="list__text02">{{ $info->company_name }}</p>
                                </div>
                            </li>
                            <li class="form__list-item">
                                <div class="list__title">
                                    <span class="list__text01 mt0">대표자</span>
                                </div>
                                <div class="list__desc">
                                    <p class="list__text02">{{ $info->owner_name }}</p>
                                    <div class="notice-wrap mt10">
                                        <p>· 업체명과 대표자명은 고객센터에 문의하여 변경 요청해주세요.</p>
                                    </div>
                                </div>
                            </li>
                            <li class="form__list-item">
                                <div class="list__title">
                                    <label class="list__text01 required" for="form-list01">업체 연락처</label>
                                </div>
                                <div class="list__desc">
                                    <input type="text" name="phone_number" value="{{ $info->phone_number }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="input textfield__input textfield__input--gray" id="phone_number"
                                           required placeholder="업체 연락처를 입력해주세요.">
                                    <div class="notice-wrap mt10">
                                        <p>· 해당 번호로 전화 문의가 연결됩니다.</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="form__list-wrap">
                            <li class="form__list-item">
                                <div class="list__title">
                                    <label class="list__text01" for="form-list02">업체 소재지</label>
                                </div>
                                <div class="list__desc">
                                    <button type="button" id="addLocation" class="list__add-btn" onclick="addRegionBtn()">
                                        <i class="ico__add--circle"><span class="a11y">추가</span></i>
                                        <span>소재지 추가</span>
                                    </button>
                                    <div class="notice-wrap mt10">
                                        <p>· 소재지는 5곳까지 추가 가능합니다.</p>
                                    </div>
                                </div>
                            </li>
                            @if ($info->locations)
                            @foreach(json_decode($info->locations, true) as $location)
                            <ul class="body__auth-wrap" data-address-id="{{ $loop->index + 1 }}">
                                <input type="hidden" name="location_id[]" value="{{ $location['idx'] }}" />
                                <li class="auth__item">
                                    <div class="item__head item__head-radio">
                                        <label class="head__text" for="input-list07">사업자 주소</label>
                                    </div>
                                    <div class="item__body">
                                        <ul class="body__radio-wrap">
                                            <li>
                                                <label>
                                                    <input type="radio" name="is_domestic_{{ $loop->index + 1 }}" value="1" data-event-target="radioBtn" class="checkbox__checked" {{ $location['is_domestic'] == '1' ? 'checked' : '' }}>
                                                    <span>국내</span>
                                                </label>
                                            </li>
                                            <li>
                                                <label>
                                                    <input type="radio" name="is_domestic_{{ $loop->index + 1 }}" value="0" data-event-target="radioBtn" class="checkbox__checked" {{ $location['is_domestic'] == '0' ? 'checked' : '' }}>
                                                    <span>해외</span>
                                                </label>
                                            </li>
                                        </ul>
                                        <div class="location--type02 {{ $location['is_domestic'] == '1' ? 'hidden' : '' }}">
                                            <input type="hidden" name="domestic_type[]" value="{{ $location['is_domestic'] == '0' ? $location['domestic_type'] : '' }}" />
                                            <div class="dropdown dropdown--type01">
                                                <p class="dropdown__title">{{ $location['is_domestic'] == '0' ? $location['sido'] : '지역' }}</p>
                                                <div class="dropdown__wrap">
                                                    @foreach(config('constants.GLOBAL_DOMESTIC') as $domestic)
                                                    <a href="javascript:void(0);" class="dropdown__item" data-domestic-type="{{ $loop->index + 1 }}" onclick="setDomesticType(this)">
                                                        <p>{{ $domestic }}</p>
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <button type="button" onclick="deleteDomesticElement(this)" class="button button--blank-gray delete-button">삭제</button>
                                        </div>
                                        <div class="location--type01 {{ $location['is_domestic'] != '1' ? 'hidden' : '' }}">
                                            <div class="input__guid">
                                                <input type="text" placeholder="사업자 주소를 입력해주세요." name="default_address[]" value="{{ $location['default_address'] }}" class="input-guid__input" readonly onclick="callMapApi(this)">
                                                <button type="button" class="input-guid__button" onclick="callMapApi(this)">주소 검색</button>
                                            </div>
                                        </div>
                                        <input type="text" placeholder="상세 주소를 입력해주세요." name="detail_address[]" value="{{ $location['detail_address'] }}" class="input textfield__input textfield__input--gray" style="margin-top: 10px;">
                                    </div>
                                </li>
                            </ul>
                            @endforeach
                            @else
                                <ul class="body__auth-wrap" data-address-id="1" data-loaction-id="">
                                    <li class="auth__item">
                                        <div class="item__head item__head-radio">
                                            <label class="head__text" for="input-list07">사업자 주소</label>
                                        </div>
                                        <div class="item__body">
                                            <ul class="body__radio-wrap">
                                                <li>
                                                    <label>
                                                        <input type="radio" name="is_domestic_1" value="1" data-event-target="radioBtn" class="checkbox__checked" checked>
                                                        <span>국내</span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label>
                                                        <input type="radio" name="is_domestic_1" value="0" data-event-target="radioBtn" class="checkbox__checked">
                                                        <span>해외</span>
                                                    </label>
                                                </li>
                                            </ul>
                                            <div class="location--type02 hidden">
                                                <input type="hidden" name="domestic_type[]" value="" />
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
                                            <div>
                                                <button type="button" onclick="deleteDomesticElement(this)" class="button button--blank-gray delete-button">삭제</button>
                                            </div>
                                            <div class="location--type01">
                                                <div class="input__guid">
                                                    <input type="text" placeholder="사업자 주소를 입력해주세요." name="default_address[]" value="" class="input-guid__input" readonly onclick="callMapApi(this)">
                                                    <button type="button" class="input-guid__button" onclick="callMapApi(this)">주소 검색</button>
                                                </div>
                                            </div>
                                            <input type="text" placeholder="상세 주소를 입력해주세요." name="detail_address[]" value="" class="input textfield__input textfield__input--gray" style="margin-top: 10px;">
                                        </div>
                                    </li>
                                </ul>
                            @endif
                            <li class="form__list-item">
                                <div class="list__title">
                                    <label class="list__text01" for="form-list03">로고 이미지</label>
                                </div>
                                <div class="list__desc">
                                    <div class="desc__gallery" id="previewSelectImage">
                                        <input class="input file-input" name="profile_image" id="form-list03" accept="image/*" type="file" placeholder="이미지 추가">
                                        <div class="desc__input-placeholder">
                                            <i class="ico__gallery--gray default-add-image"><span class="a11y">갤러리</span></i>
                                            <p class="default-add-image">이미지 추가</p>
                                            <a class="ico__sdelete hidden" role="button" href="javascript:void(0);" id="deletePreviewLogoImage"><span class="a11y">삭제</span></a>
                                        </div>
                                    </div>
                                    @if ($info->profile_image)
                                    <div class="desc__gallery" style="background-image: url('{{$info->profile_image}}');" data-image-src="{{ $info->profile_image }}">
                                        <div class="desc__input-placeholder">
                                            <i class="ico__gallery--gray"><span class="a11y">갤러리</span></i>
                                            <a class="ico__sdelete" role="button" href="javascript:void(0);" id="deleteLogoImage"><span class="a11y">삭제</span></a>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="notice-wrap mt10">
                                        <p>· 권장 크기: 140 x 140 / 권장 형식: jpg, jpeg, png</p>
                                    </div>
                                </div>
                            </li>
                            <li class="form__list-item">
                                <div class="list__title">
                                    <label class="list__text01" for="form-list04">근무일</label>
                                </div>
                                <div class="list__desc">
                                    <input class="input textfield__input textfield__input--gray" name="work_day" value="{{ $info->work_day }}" id="form-list04" type="text"
                                           placeholder="평일, 연중무휴 등 근무 정보를 입력해주세요.">
                                </div>
                            </li>
                            <li class="form__list-item">
                                <div class="list__title">
                                    <label class="list__text01" for="form-list05">이메일</label>
                                </div>
                                <div class="list__desc">
                                    <input class="input textfield__input textfield__input--gray" name="business_email" value="{{ $info->business_email }}" id="form-list05" type="text"
                                           placeholder="이메일을 입력해주세요.">
                                </div>
                            </li>
                            <li class="form__list-item">
                                <div class="list__title">
                                    <label class="list__text01" for="form-list06">담당자</label>
                                </div>
                                <div class="list__desc">
                                    <input class="input textfield__input textfield__input--gray" name="manager" value="{{ $info->manager }}" id="form-list06" type="text"
                                           placeholder="담당자 이름을 입력해주세요.">
                                </div>
                            </li>
                            <li class="form__list-item">
                                <div class="list__title">
                                    <label class="list__text01" for="form-list07">담당자 연락처</label>
                                </div>
                                <div class="list__desc">
                                    <input type="text" name="manager_number" value="{{ $info->manager_number }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="input textfield__input textfield__input--gray" id="form-list07"
                                           placeholder="담당자 연락처를 입력해주세요.">
                                </div>
                            </li>
                            <li class="form__list-item">
                                <div class="list__title">
                                    <label class="list__text01" for="form-list08">팩스</label>
                                </div>
                                <div class="list__desc">
                                    <input type="text" name="fax" value="{{ $info->fax }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="input textfield__input textfield__input--gray" id="form-list08"
                                           placeholder="팩스 번호를 입력해주세요.">
                                </div>
                            </li>
                            <li class="form__list-item">
                                <div class="list__title">
                                    <label class="list__text01" for="form-list09">발주 방법</label>
                                </div>
                                <div class="list__desc">
                                    <input class="input textfield__input textfield__input--gray" name="how_order" value="{{ $info->how_order }}" id="form-list09" type="text"
                                           placeholder="발주 방법을 작성해주세요.">
                                </div>
                            </li>
                            <li class="form__list-item">
                                <div class="list__title">
                                    <label class="list__text01" for="form-list10">웹사이트</label>
                                </div>
                                <div class="list__desc">
                                    <input class="input textfield__input textfield__input--gray" name="website" value="{{ $info->website }}" id="form-list10" type="text"
                                           placeholder="URL을 입력해주세요.">
                                </div>
                            </li>
                            <li class="form__list-item">
                                <div class="list__title">
                                    <label class="list__text01" for="form-list11">기타</label>
                                </div>
                                <div class="list__desc">
                                    <div class="textarea-wrap">
                                        <textarea name="etc" placeholder="추가 정보를 입력해주세요.">{!! $info->etc !!}</textarea>
                                    </div>
                                </div>
                            </li>
                            <li class="form__list-item">
                                <div class="list__title">
                                    <label class="list__text01" for="form-list12">소개</label>
                                </div>
                                <div class="list__desc">
                                    <textarea name="introduce" id="introduce">{{ $info->introduce }}</textarea>
                                </div>
                            </li>
                        </ul>

                        <div class="form__button-group">
                            <button type="button" class="button button--blank-gray" onclick="openModal('#alert-modal01')">
                                취소
                            </button>
                            <button type="button" class="button button--solid" onclick="submitCompany();">
                                저장
                            </button>
                        </div>


                        <!-- 취소 팝업 -->
                        <div id="alert-modal01" class="alert-modal">
                            <div class="alert-modal__container">
                                <div class="alert-modal__top">
                                    <p>
                                        작성 중인 내용이 있습니다.<br>
                                        진행을 취소하시겠습니까?
                                    </p>
                                </div>
                                <div class="alert-modal__bottom">
                                    <div class="button-group">
                                        <button type="button" class="button button--solid-gray" onclick="closeModal('#alert-modal01')">
                                            취소
                                        </button>
                                        <button type="button" class="button button--solid" onclick="history.back();">
                                            확인
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 저장 팝업 -->
                        <div id="alert-modal02" class="alert-modal">
                            <div class="alert-modal__container">
                                <div class="alert-modal__top">
                                    <p>
                                        입력한 정보가 저장되었습니다.
                                    </p>
                                </div>
                                <div class="alert-modal__bottom">
                                    <button type="button" class="button button--solid" onclick="location.replace('/mypage/company')">
                                        확인
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
        // set froala editor
        const editor = new FroalaEditor('#introduce', {
            key: 'wFE7nG5E4I4D3A11A6eMRPYf1h1REb1BGQOQIc2CDBREJImA11C8D6B5B1G4D3F2F3C8==',
            height:300,
            requestHeaders: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            imageUploadParam: 'images',
            imageUploadURL: '/mypage/company/image',
            imageUploadMethod: 'POST',
            imageMaxSize: 5 * 1024 * 1024,
            imageAllowedTypes: ['jpeg', 'jpg', 'png'],
            events: {
                'image.uploaded': response => {
                    const img_url = response;
                    editor.image.insert(img_url, false, null, editor.image.get(), response);
                    return false;
                },
                'image.removed': img => {
                    const imageUrl = img[0].src;
                    @if(!$info->introduce)
                    fetch('/mypage/company/image', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': {{ csrf_token() }}
                        },
                        body: JSON.stringify({
                            imageUrl: imageUrl,
                        })
                    }).then(result => {
                        return result.json();
                    }).then(json => {
                    })
                    @endif
                }
            }
        })

        // form submit
        const submitCompany = () => {
            if (!document.getElementById('phone_number').value) {
                document.getElementById('phone_number').focus();
                return false;
            }
            const formData = new FormData(document.getElementById('companyForm'));
            formData.append('profile_image', document.querySelector('input[type="file"]').files[0])
            fetch('/mypage/company', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            }).then(response => {
                return response.json();
            }).then(json => {
                if (json.result === 'success') {
                    openModal('#alert-modal02');
                }
            });
        }

        // 소재지 추가 버튼 클릭 시
        const addRegionBtn = () => {
            const cloneNode = document.querySelector('.body__auth-wrap').cloneNode(true);
            cloneNode.querySelectorAll('input').forEach(elem => {
                if (elem.getAttribute('type') !== 'radio') {
                    elem.value = '';
                } else {
                    elem.checked = false;
                }
            });
            const beforeLength = document.querySelectorAll('.body__auth-wrap').length
            document.querySelectorAll('.body__auth-wrap')[beforeLength-1].after(cloneNode);

            resetNumberAddressElements();

            const afterLength = document.querySelectorAll('[class=body__auth-wrap]').length;
            document.querySelectorAll('[class=body__auth-wrap]')[afterLength-1].querySelector('input[type=radio]').click();
            changeAddRegionsBtnStatus();
        }

        // 삭제 버튼 클릭 시
        const deleteDomesticElement = elem => {
            const parentWrap = elem.closest('.body__auth-wrap');
            const locationIdElem = parentWrap.querySelector('[name*=location_id]');
            if (locationIdElem) {
                fetch('/mypage/company/location/' + locationIdElem.value, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
            }
            elem.closest('.body__auth-wrap').remove();
            resetNumberAddressElements();
            changeAddRegionsBtnStatus();
        }

        // 소재지 5개 이상일 때 소재지 추가버튼 숨김, 5개 미만일 때 소새지 버튼 노출
        const changeAddRegionsBtnStatus = () => {
            if (document.querySelectorAll('[class=body__auth-wrap]').length >= 5) {
                document.getElementById('addLocation').classList.add('hidden');
            } else {
                document.getElementById('addLocation').classList.remove('hidden');
            }
        }

        // 소재지 추가 or 삭제 되었을 때 라디오 버튼의 name 값 재설정
        const resetNumberAddressElements = () => {
            if (document.querySelectorAll('.body__auth-wrap').length <= 1) {
                document.querySelector('.delete-button').classList.add('hidden');
            } else {
                document.querySelectorAll('.delete-button').forEach(elem => {
                    elem.classList.remove('hidden');
                })
            }
            document.querySelectorAll('.body__auth-wrap').forEach((elem, index) => {
                elem.setAttribute('data-address-id', (index + 1) + "")
                elem.querySelectorAll('input[type=radio]').forEach(elem2=> {
                    const isChecked = elem2.checked;
                    elem2.setAttribute('name', 'is_domestic_' + (index+1));
                    if (isChecked) elem2.setAttribute('checked', true);
                })
            });
        }

        // 국내, 해외 라디오 버튼 클릭 시 히든 값 입력
        const setDomesticType = elem => {
            const parent = elem.closest('.location--type02');
            parent.querySelector('[name*=domestic_type]').value = elem.dataset.domesticType;
        }

        // 국내, 해외 라디오 버튼 클릭 시 주소 입력 화면 변경
        const changeDomesticType = elem => {
            const parentElem = elem.closest('.body__auth-wrap');
            parentElem.querySelectorAll('input[type=text]').forEach(textElem => {
                textElem.value = '';
            });
            parentElem.querySelectorAll('input[type=hidden][name*=domestic_type]').forEach(hiddenElem => {
                hiddenElem.value = '';
            });
            if (elem.value === '1') { // 국내
                parentElem.querySelector('[class*=location--type01]').classList.remove('hidden');
                parentElem.querySelector('[class*=location--type02]').classList.add('hidden');
                parentElem.querySelector('[class*=location--type02] .dropdown__title').textContent = '지역';
            } else {
                parentElem.querySelector('[class*=location--type02]').classList.remove('hidden');
                parentElem.querySelector('[class*=location--type01]').classList.add('hidden');
            }
        }

        // 우편 지도 api 호출
        const callMapApi = elem => {
            const index = elem.closest('.body__auth-wrap').dataset.addressId;
            new daum.Postcode({
                oncomplete: function(data) {
                    document.querySelector('.body__auth-wrap[data-address-id="'+index+'"] input[name*=default_address]').value = data.roadAddress;
                }
            }).open();
        }

        const deletePreviewLogoImage = () => {
            document.querySelector('[name=profile_image]').value = '';
            const e = new Event("change");
            const element = document.querySelector('[name=profile_image]')
            element.dispatchEvent(e);
        }

        const deleteLogoImage = elem => {
            if(confirm('이미지를 삭제하시겠습니까?')) {
                const imageUrl = elem.closest('.desc__gallery').dataset.imageSrc;
                fetch('/mypage/logo/image', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        imageUrl: imageUrl,
                    })
                }).then(result => {
                    return result.json();
                }).then(json => {
                    if (json.result === 'success') {
                        elem.closest('.desc__gallery').remove();
                    }
                })
            }
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

        if (document.getElementById('deleteLogoImage')) {
            document.getElementById('deleteLogoImage').addEventListener('click', e => {
                deleteLogoImage(e.currentTarget);
            });
        }

        // 이벤트 위임
        document.addEventListener('click', evt => {
            if (evt.target.dataset.eventTarget === 'radioBtn') { // 국내, 해외 라디오 버튼 클릭 시
                changeDomesticType(evt.target);
            }
        })

        document.getElementById('deletePreviewLogoImage').addEventListener('click', deletePreviewLogoImage);
        document.querySelector('[name="profile_image"]').addEventListener('change', e => previewImage(e));
        resetNumberAddressElements();

    </script>



@endsection
