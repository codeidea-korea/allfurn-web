@extends('layouts.app_m')

@php
    $only_quick = '';
    $header_depth = 'mypage';
    $top_title = '홈페이지 관리';
    $header_banner = '';
@endphp

@section('content')
    @include('layouts.header_m')

    <div id="content">
        <div class="inner">
            <div class="pt-5 pb-3 flex items-center gap-1 text-stone-400">
                <p>홈페이지 관리</p>
                <p>></p>
                <p>설정</p>
            </div>
            <div class="com_setting">
                <h2 class="text-xl font-medium">홈페이지 소개/정보</h2>
                <div class="info">
                    <div class="flex items-start gap-1">
                        <img src="/img/member/info_icon.svg" alt="" class="w-4 mt-0.5" />
                        <p>올바르지 않은 홈페이지 정보 입력 및 이미지 등록 시 올펀 관리 정책에 따른 패널티를 받을 수 있습니다.</p>
                    </div>
                </div>
                <form method="PUT" name="companyForm" id="companyForm" action="/mypage/company" enctype="multipart/form-data">
                    <div class="border-t-2 border-gray-500">
                        <div class="stting_wrap mx-auto mt-8">
                            <div class="mb-4"> 
                                <dl>
                                    <dt class="mb-1">홈페이지명</dt>
                                    <dd class="font-medium">{{ $info -> company_name }}</dd>
                                </dl>
                            </div>
                            <div class="mb-4">
                                <dl>
                                    <dt class="mb-1">대표자</dt>
                                    <dd class="font-medium w-full">
                                        <div>{{ $info -> owner_name }}</div>
                                        <div class="info">
                                            <div class="flex items-center gap-1">
                                                <p>· 홈페이지명과 대표자명은 고객센터에 문의하여 변경 요청해주세요.</p>
                                            </div>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                            <div class="mb-4">
                                <dl>
                                    <dt class="essential mb-1 mt-2">홈페이지 연락처</dt>
                                    <dd class="font-medium w-full">
                                        <input type="text" name="phone_number" id="phone_number" class="setting_input h-[48px] w-full" value="{{ $info -> phone_number }}" placeholder="홈페이지 연락처를 입력해주세요." onInput="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g,  '$1');" required />
                                        <div class="info">
                                            <div class="flex items-center gap-1">
                                                <p>· 해당 번호로 전화 문의가 연결됩니다.</p>
                                            </div>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                            <div class="border-t py-4">
                                <dl>
                                    <dt class="mb-1 mt-2">홈페이지 소재지</dt>
                                    <dd class="font-medium w-full">
                                        <button type="button" id="addLocation" class="setting_btn flex justify-center items-center w-full gap-3 add_address" onclick="addRegionBtn()">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                            소재지 추가
                                        </button>
                                        <div class="info">
                                            <div class="flex items-center gap-1">
                                                <p>· 소재지는 5곳까지 추가 가능합니다.</p>
                                            </div>
                                        </div>
                                        @if ($info -> locations)
                                            @foreach(json_decode($info -> locations, true) as $location)
                                            <div class="address_container">
                                                <input type="hidden" name="location_id[]" value="{{ $location['idx'] }}" />
                                                <div class="mt-8 address_area pb-8 border-b" data-address-id="{{ $loop -> index + 1 }}">
                                                    <div class="mb-1">
                                                        <p class="mb-2 font-normal">사업자 주소</p>
                                                        <div class="flex flex-col w-full">
                                                            <div class="flex justify-between">
                                                                <div class="flex gap-6">
                                                                    <div class="flex items-center gap-1 domestic_radio">
                                                                        <input type="radio" name="is_domestic_{{ $loop -> index + 1 }}" class="checkbox__checked" value="1" data-event-target="radioBtn" {{ $location['is_domestic'] == '1' ? 'checked' : '' }}>
                                                                        <label for="domestic">국내</label>
                                                                    </div>
                                                                    <div class="flex items-center gap-1 overseas_radio">
                                                                        <input type="radio" name="is_domestic_{{ $loop -> index + 1 }}" class="checkbox__checked" value="0" data-event-target="radioBtn" {{ $location['is_domestic'] == '0' ? 'checked' : '' }}>
                                                                        <label for="overseas">해외</label>
                                                                    </div>
                                                                </div>
                                                                <button class="h-[48px] w-[98px] border border-stone-500 rounded-md shrink-0 delete_address hover:bg-stone-100 delete-button" onClick="deleteDomesticElement(this);">삭제</button>
                                                            </div>
                                                            <div class="domestic_section mt-8 location--type01 {{ $location['is_domestic'] != '1' ? 'hidden' : '' }}">
                                                                <div class="flex items-center gap-2">
                                                                    <input type="text" name="default_address[]" class="setting_input h-[48px] w-full" value="{{ $location['default_address'] }}" placeholder="사업자 주소를 입력해주세요." onClick="callMapApi(this);" readOnly />
                                                                    <button type="button" class="h-[48px] w-[98px] border border-stone-500 rounded-md shrink-0" onClick="callMapApi(this);">주소 검색</button>
                                                                </div>
                                                            </div>
                                                            <div class="overseas_section mt-8 location--type02 {{ $location['is_domestic'] == '1' ? 'hidden' : '' }}">
                                                                <input type="hidden" name="domestic_type[]" value="{{ $location['is_domestic'] == '0' ? $location['domestic_type'] : '' }}" />
                                                                <div class="my_filterbox h-[48px]">
                                                                    <a href="javascript: ;" class="filter_border filter_dropdown w-full h-[48px] flex justify-between items-center" style="border-radius: 5px;">
                                                                        <p class="dropdown__title">{{ $location['is_domestic'] == '0' ? config('constants.GLOBAL_DOMESTIC')[$location['domestic_type'] - 1] : '지역' }}</p>
                                                                        <svg class="w-6 h-6 filter_arrow"><use xlink:href="/img/icon-defs.svg#drop_b_arrow"></use></svg>
                                                                    </a>
                                                                    <div class="filter_dropdown_wrap w-[582px]">
                                                                        <ul>
                                                                            @foreach(config('constants.GLOBAL_DOMESTIC') as $domestic)
                                                                            <li>
                                                                                <a href="javascript: void(0);" class="flex items-center" data-domestic-type="{{ $loop -> index + 1 }}">{{ $domestic }}</a>
                                                                            </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="text" name="detail_address[]" class="setting_input h-[48px] w-full mt-3" value="{{ $location['detail_address'] }}" placeholder="상세 주소를 입력해주세요." />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        @else
                                            <div class="address_container">
                                                <div class="mt-8 address_area pb-8 border-b" data-address-id="1">
                                                    <div class="mb-1">
                                                        <p class="mb-2 font-normal">사업자 주소</p>
                                                        <div class="flex flex-col w-full">
                                                            <div class="flex justify-between">
                                                                <div class="flex gap-6">
                                                                    <div class="flex items-center gap-1 domestic_radio">
                                                                        <input type="radio" name="is_domestic_1" class="checkbox__checked" value="1" data-event-target="radioBtn" checked />
                                                                        <label for="domestic">국내</label>
                                                                    </div>
                                                                    <div class="flex items-center gap-1 overseas_radio">
                                                                        <input type="radio" name="is_domestic_1" value="0" data-event-target="radioBtn" class="checkbox__checked">
                                                                        <label for="overseas">해외</label>
                                                                    </div>
                                                                </div>
                                                                <button class="h-[48px] w-[98px] border border-stone-500 rounded-md shrink-0 delete_address hover:bg-stone-100 delete-button" onClick="deleteDomesticElement(this);">삭제</button>
                                                            </div>
                                                            <div class="domestic_section mt-8 location--type01"> 
                                                                <div class="flex items-center gap-2">
                                                                    <input type="text" name="default_address[]" class="setting_input h-[48px] w-full" placeholder="사업자 주소를 입력해주세요." onClick="callMapApi(this);" readOnly />
                                                                    <button type="button" class="h-[48px] w-[98px] border border-stone-500 rounded-md shrink-0" onClick="callMapApi(this);">주소 검색</button>
                                                                </div>
                                                            </div>
                                                            <div class="overseas_section mt-8 location--type02 hidden">
                                                                <input type="hidden" name="domestic_type[]" value="" />
                                                                <div class="my_filterbox h-[48px]">
                                                                    <a href="javascript: ;" class="filter_border filter_dropdown w-full h-[48px] flex justify-between items-center" style="border-radius: 5px;">
                                                                        <p class="dropdown__title">지역</p>
                                                                        <svg class="w-6 h-6 filter_arrow"><use xlink:href="/img/icon-defs.svg#drop_b_arrow"></use></svg>
                                                                    </a>
                                                                    <div class="filter_dropdown_wrap w-[582px]">
                                                                        <ul>
                                                                            @foreach(config('constants.GLOBAL_DOMESTIC') as $domestic)
                                                                            <li>
                                                                                <a href="javascript: void(0);" class="flex items-center" data-domestic-type="{{ $loop -> index + 1 }}">{{ $domestic }}</a>
                                                                            </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="text" name="detail_address[]" class="setting_input h-[48px] w-full mt-3" value="" placeholder="상세 주소를 입력해주세요." />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </dd>
                                </dl>
                            </div>
                            <div class="mb-4">
                                <dl class="flex-col">
                                    <dt class="w-[190px] shrink-0 mb-2">로고 이미지</dt>
                                    <dd class="font-medium w-full">
                                        <div class="flex items-center gap-2">
                                            <div id="previewSelectImage" class="file_up_area border border-dashed w-[140px] h-[140px] rounded-md relative flex items-center justify-center">
                                                <input type="file" name="profile_image" id="form-list03" class="file_input" accept="image/*" placeholder="이미지 추가" />
                                                <div>
                                                    <div class="file_text flex flex-col items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image text-stone-400"><rect width="20" height="20" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                                        <span class="default-add-image text-stone-400">이미지 추가</span>
                                                    </div>
                                                    <div class="absolute top-2.5 right-2.5">
                                                        <button type="button" id="deletePreviewLogoImage" class="file_del w-[28px] h-[28px] bg-stone-600/50 rounded-full hidden">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-white mx-auto w-4 h-4"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($info -> profile_image)
                                                <div class="border border-dashed w-[140px] h-[140px] rounded-md relative flex items-center justify-center desc__gallery" data-image-src="{{ $info -> profile_image }}">
                                                    <img src="{{$info -> profile_image}}" alt="" class="w-[140px] h-[140px] rounded-md object-cover">
                                                    <div class="absolute top-2.5 right-2.5">
                                                        <button type="button" id="deleteLogoImage" class="file_del w-[28px] h-[28px] bg-stone-600/50 rounded-full">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-white mx-auto w-4 h-4"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="info">
                                            <div class="flex items-center gap-1">
                                                <p>· 권장 크기: 140 x 140 / 권장 형식: jpg, jpeg, png</p>
                                            </div>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                            <div class="mb-4">
                                <dl class="flex-col">
                                    <dt class="w-[190px] shrink-0 mb-2">상단 배너 이미지</dt>
                                    <dd class="font-medium w-full">
                                        <div class="flex-col items-center">
                                            <div id="previewSelectImage2" class="file_up_area border border-dashed w-full h-[140px] rounded-md relative flex items-center justify-center">
                                                <input type="file" name="top_banner" id="form-list13" class="file_input" accept="image/*" placeholder="이미지 추가" />
                                                <div>
                                                    <div class="file_text flex flex-col items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image text-stone-400"><rect width="20" height="20" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                                        <span class="default-add-image2 text-stone-400">이미지 추가</span>
                                                    </div>
                                                    <div class="absolute top-2.5 right-2.5">
                                                        <button type="button" id="deletePreviewBannerImage" class="file_del w-[28px] h-[28px] bg-stone-600/50 rounded-full hidden">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-white mx-auto w-4 h-4"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($info->top_banner_image)
                                                <div class="mt-[8px] border border-dashed w-full h-[140px] rounded-md relative flex items-center justify-center desc__gallery" data-image-src="{{ $info->top_banner_image }}">
                                                    <img src="{{$info->top_banner_image}}" alt="" class="w-full h-[140px] rounded-md object-cover">
                                                    <div class="absolute top-2.5 right-2.5">
                                                        <button type="button" id="deleteTopBannerImage" class="file_del w-[28px] h-[28px] bg-stone-600/50 rounded-full">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-white mx-auto w-4 h-4"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="info">
                                            <div class="flex items-center gap-1">
                                                <p>· 권장 크기: 1800 x 540 / 권장 형식: jpg, jpeg, png</p>
                                            </div>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                            <div class="mb-4">
                                <dl>
                                    <dt class="mb-1 mt-2">공지 내용</dt>
                                    <dd class="font-medium w-full">
                                        <input type="text" name="notice_title" id="notice_title" class="setting_input h-[48px] w-full" value="{{ $info -> notice_title }}" placeholder="공지사항 제목을 입력해주세요." />
                                        <div class="setting_input h-[100px] py-3 mt-[4px]">
                                            <textarea name="notice_content" class="w-full h-full" placeholder="공지사항 내용을 입력해주세요.">{!! $info -> notice_content !!}</textarea>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                            <div class="mb-4">
                                <dl>
                                    <dt class="mb-1 mt-2">근무일</dt>
                                    <dd class="font-medium w-full">
                                    <input type="text" name="work_day" id="form-list04" class="setting_input h-[48px] w-full" value="{{ $info -> work_day }}" placeholder="평일, 연중무휴 등 근무 정보를 입력해주세요." />
                                    </dd>
                                </dl>
                            </div>
                            <div class="mb-4">
                                <dl>
                                    <dt class="mb-1 mt-2">이메일</dt>
                                    <dd class="font-medium w-full">
                                        <input type="email" name="business_email" id="form-list05" class="setting_input h-[48px] w-full" value="{{ $info -> business_email }}" placeholder="이메일을 입력해주세요." />
                                    </dd>
                                </dl>
                            </div>
                            <div class="mb-4">
                                <dl>
                                    <dt class="mb-1 mt-2">담당자</dt>
                                    <dd class="font-medium w-full">
                                        <input type="text" name="manager" id="form-list06" class="setting_input h-[48px] w-full" value="{{ $info -> manager }}" placeholder="담당자 이름을 입력해주세요." />
                                    </dd>
                                </dl>
                            </div>
                            <div class="mb-4">
                                <dl>
                                    <dt class="mb-1 mt-2">담당자 연락처</dt>
                                    <dd class="font-medium w-full">
                                        <input type="text" name="manager_number" id="form-list07" class="setting_input h-[48px] w-full" value="{{ $info -> manager_number }}" placeholder="담당자 연락처를 입력해주세요." onInput="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                                    </dd>
                                </dl>
                            </div>
                            <div class="mb-4">
                                <dl>
                                    <dt class="mb-1 mt-2">팩스</dt>
                                    <dd class="font-medium w-full">
                                        <input type="text" name="fax" id="form-list08" class="setting_input h-[48px] w-full" value="{{ $info -> fax }}" placeholder="팩스 번호를 입력해주세요." onInput="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                                    </dd>
                                </dl>
                            </div>
                            <div class="mb-4">
                                <dl>
                                    <dt class="mb-1 mt-2">발주 방법</dt>
                                    <dd class="font-medium w-full">
                                        <input type="text" name="how_order" id="form-list09" class="setting_input h-[48px] w-full" value="{{ $info -> how_order }}" placeholder="발주 방법을 작성해주세요." />
                                    </dd>
                                </dl>
                            </div>
                            <div class="mb-4">
                                <dl>
                                    <dt class="mb-1 mt-2">웹사이트</dt>
                                    <dd class="font-medium w-full">
                                        <input type="text" name="website" id="form-list10" class="setting_input h-[48px] w-full" value="{{ $info -> website }}" placeholder="URL을 입력해주세요." />
                                    </dd>
                                </dl>
                            </div>
                            <div class="mb-4">
                                <dl>
                                    <dt class="mb-1 mt-2">기타</dt>
                                    <dd class="font-medium w-full">
                                        <div class="setting_input h-[100px] py-3">
                                            <textarea name="etc" class="w-full h-full" placeholder="추가 정보를 입력해주세요.">{!! $info -> etc !!}</textarea>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                            <div class="mb-4">
                                <dl>
                                    <dt class="mb-1 mt-2">소개</dt>
                                    <dd class="font-medium w-full">
                                        <!--<div class="setting_input h-[100px] py-3">-->
                                            <textarea name="introduce" id="introduce">{{ $info -> introduce }}</textarea>
                                        <!--</div>-->
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="flex items-center justify-center gap-3 pt-14 pb-10">
                <a href="/mypage/company" class="h-[48px] w-[200px] my_del_btn border rounded-md hover:bg-stone-200 transition">취소</a>
                <button class="h-[48px] w-[200px] my_primary_btn rounded-md hover:bg-rose-700 transition" onclick="submitCompany()">저장</button>
            </div>
        </div>
    </div>





    <link href="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/js/froala_editor.pkgd.min.js"></script>
    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script src="/js/jquery-1.12.4.js?{{ date('Ymdhis') }}"></script>
    <script>
        // 소재지 추가 버튼
        const addRegionBtn = () => {
            const cloneNode = document.querySelector('.address_container').cloneNode(true);
            cloneNode.querySelectorAll('input').forEach(elem => {
                if (elem.getAttribute('type') !== 'radio') {
                    elem.value = '';
                } else {
                    elem.checked = false;
                }
            });

            const beforeLength = document.querySelectorAll('.address_container').length;
            document.querySelectorAll('.address_container')[beforeLength - 1].after(cloneNode);

            resetNumberAddressElements();

            const afterLength = document.querySelectorAll('[class=address_container]').length;
            document.querySelectorAll('[class=address_container]')[afterLength - 1].querySelector('input[type=radio]').click();

            changeAddRegionsBtnStatus();
        }

        // 소재지 삭제 버튼
        const deleteDomesticElement = elem => {
            const parentWrap = elem.closest('.address_container');

            const locationIdElem = parentWrap.querySelector('[name*=location_id]');
            if (locationIdElem) {
                fetch('/mypage/company/location/' + locationIdElem.value, {
                    method  : 'DELETE',
                    headers : {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
            }

            parentWrap.remove();

            resetNumberAddressElements();
            changeAddRegionsBtnStatus();
        }

        // 소재지 추가 / 삭제   >   라디오 버튼의 name 값 재설정
        const resetNumberAddressElements = () => {
            if (document.querySelectorAll('.address_container').length <= 1) {
                document.querySelector('.delete-button').classList.add('hidden');
            } else {
                document.querySelectorAll('.delete-button').forEach(elem => {
                    elem.classList.remove('hidden');
                });
            }

            document.querySelectorAll('.address_container').forEach((elem, index) => {
                elem.setAttribute('data-address-id', (index + 1) + '');

                elem.querySelectorAll('input[type=radio]').forEach(elem2 => {
                    const isChecked = elem2.checked;
                    elem2.setAttribute('name', 'is_domestic_' + (index + 1));
                    if (isChecked) elem2.setAttribute('checked', true);
                });
            });
        }
        resetNumberAddressElements();

        // 소재지가 5개 이상일 때, 소재지 추가 버튼을 숨김 (= 5개 미만이면 다시 노출)
        const changeAddRegionsBtnStatus = () => {
            if (document.querySelectorAll('[class=address_container]').length >= 5) {
                document.getElementById('addLocation').classList.add('hidden');
            } else {
                document.getElementById('addLocation').classList.remove('hidden');
            }
        }

        // 이벤트 위임
        document.addEventListener('click', evt => {
            if (evt.target.dataset.eventTarget === 'radioBtn') {   //국내 / 해외 라디오 버튼
                changeDomesticType(evt.target);
            }
        });

        // 국내 / 해외 버튼 클릭   >   주소 입력 화면 변경
        const changeDomesticType = elem => {
            const parentElem = elem.closest('.address_container');
            parentElem.querySelectorAll('input[type=text]').forEach(textElem => {
                textElem.value = '';
            });
            parentElem.querySelectorAll('input[type=hidden][name*=domestic_type]').forEach(hiddenElem => {
                hiddenElem.value = '';
            });

            if (elem.value === '1') {   //국내
                parentElem.querySelector('[class*=location--type01]').classList.remove('hidden');
                parentElem.querySelector('[class*=location--type02]').classList.add('hidden');
                parentElem.querySelector('[class*=location--type02] .dropdown__title').textContent = '지역';
            } else {
                parentElem.querySelector('[class*=location--type01]').classList.add('hidden');
                parentElem.querySelector('[class*=location--type02]').classList.remove('hidden');
            }
        }

        // 주소 API 호출
        const callMapApi = elem => {
            const index = elem.closest('.address_container').dataset.addressId;
            new daum.Postcode({
                oncomplete  : function(data) {
                    document.querySelector('.address_container[data-address-id="' + index + '"] input[name*=default_address]').value = data.roadAddress;
                }
            }).open();
        }

        const previewImage = evt => {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewSelectImage').style.backgroundImage = "url('" + e.target.result + "')";
                document.getElementById('previewSelectImage').style.backgroundSize = '100%';
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

        const deletePreviewLogoImage = () => {
            const element = document.querySelector('[name=profile_image]');
            element.value = '';

            const e = new Event('change');
            element.dispatchEvent(e);
        }

        const deleteLogoImage = elem => {
            if(confirm('이미지를 삭제하시겠습니까?')) {
                const imageUrl = elem.closest('.desc__gallery').dataset.image_src;
                fetch('/mypage/logo/image', {
                    method  : 'DELETE',
                    headers : {
                        'Content-Type'  : 'application/json',
                        'X-CSRF-TOKEN'  : '{{ csrf_token() }}'
                    },
                    body    : JSON.stringify({
                        imageUrl        : imageUrl
                    })
                }).then(result => {
                    return result.json();
                }).then(json => {
                    if (json.result === 'success') {
                        elem.closest('.desc__gallery').remove();
                    }
                });
            }
        }

        const editor = new FroalaEditor('#introduce', {
            key             : 'wFE7nG5E4I4D3A11A6eMRPYf1h1REb1BGQOQIc2CDBREJImA11C8D6B5B1G4D3F2F3C8==',
            height          : 300,
            requestHeaders  : {
                'X-CSRF-TOKEN'  : '{{ csrf_token() }}'
            },
            imageUploadParam    : 'images',
            imageUploadURL      : '/mypage/company/image',
            imageUploadMethod   : 'POST',
            imageMaxSize        : 5 * 1024 * 1024,
            imageAllowedTypes   : ['jpeg', 'jpg', 'png'],
            events              : {
                'image.uploaded': response => {
                    const img_url = response;
                    editor.image.insert(img_url, false, null, editor.image.get(), response);

                    return false;
                },
                'image.removed' : img => {
                    const imageUrl = img[0].src;

                    @if(!$info -> introduce)
                    fetch('/mypage/company/image', {
                        method  : 'DELETE',
                        headers : {
                            'Content-Type'  : 'application/json',
                            'X-CSRF-TOKEN'  : {{ csrf_token() }}
                        },
                        body    : JSON.stringify({
                            imageUrl        : imageUrl
                        })
                    }).then(result => {
                        return result.json();
                    }).then(json => {
                    });
                    @endif
                }
            }
        });

        const submitCompany = () => {
            if (!document.getElementById('phone_number').value) {
                document.getElementById('phone_number').focus();

                return false;
            }

            const formData = new FormData(document.getElementById('companyForm'));
            formData.append('profile_image', document.querySelector('input[type="file"]').files[0]);
            fetch('/mypage/company', {
                method  : 'POST',
                headers : {
                    'X-CSRF-TOKEN'  : '{{csrf_token()}}'
                },
                body    : formData
            }).then(response => {
                return response.json();
            }).then(json => {
                if (json.result === 'success') {
                    //openModal('#alert-modal02');
                    location.href = '/mypage/company';
                }
            });
        }

        document.querySelector('[name="profile_image"]').addEventListener('change', e => previewImage(e));

        document.getElementById('deletePreviewLogoImage').addEventListener('click', deletePreviewLogoImage);

        if (document.getElementById('deleteLogoImage')) {
            document.getElementById('deleteLogoImage').addEventListener('click', e => {
                deleteLogoImage(e.currentTarget);
            });
        }


        
        $(document).ready(function(){
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
@endsection