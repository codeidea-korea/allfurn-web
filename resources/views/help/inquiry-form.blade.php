@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
<div id="container" class="container" style="min-height:calc(100vh - 409px)">
    <div class="service">
        <div class="inner">
            <div class="section">
                <div class="section__head">
                    <ul class="breadcrumbs-wrap">
                        <li>고객센터</li>
                        <li>1:1 문의</li>
                    </ul>
                    <h3 class="section__title">
                        <p>1:1 문의하기</p>
                    </h3>
                </div>
            </div>
            <div class="content">
                <div class="service-content">
                    <div class="service-content__item">
                        <form id="inquiryForm" name="inquiryForm" method="post" action="/help/inquiry">
                            @if (!is_null($detail))
                                <input type="hidden" id="inquiry_idx" name="inquiry_idx" value="{{ $detail->idx }}" />
                            @endif
                            <div class="form">
                                <div class="form__list">
                                    <div class="form__label">
                                        <label class="label label--necessary">문의 유형</label>
                                    </div>
                                    <div class="textfield">
                                        <div class="dropdown dropdown--type01 text--gray">
                                            <p class="dropdown__title" style="{{ !is_null($detail) ? 'color: rgb(27, 27, 27)' : '' }}">
                                                @if (!is_null($detail))
                                                    {{ $detail->name }}
                                                @else
                                                    유형을 선택해주세요.
                                                @endif
                                            </p>
                                            <input type="hidden" id="inquiry_category" name="inquiry_category" value="{{ !is_null($detail) ? $detail->name : ''}}" />
                                            <div class="dropdown__wrap">
                                                @foreach($categories as $category)
                                                <a href="javascript:void(0);" class="dropdown__item inquiry-category">
                                                    <span>{{ $category->name }}</span>
                                                </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form__list">
                                    <div class="form__label">
                                        <label class="label label--necessary">문의 제목</label>
                                    </div>
                                    <div class="textfield">
                                        <input type="text" class="input textfield__input inquiry-input" id="inquiry_title" name="inquiry_title" value="{{ !is_null($detail) ? $detail->title : '' }}" placeholder="문의 제목을 입력해주세요." maxlength="50" />
                                    </div>
                                </div>
                                <div class="form__list">
                                    <div class="form__label">
                                        <label class="label label--necessary">문의 내용</label>
                                    </div>
                                    <div class="textfield">
                                        <textarea class="textarea textfield__input" id="inquiry_content" name="inquiry_content" placeholder="문의 내용을 입력해 주세요." maxlength="1000">{{ !is_null($detail) ? $detail->content : '' }}</textarea>
                                        <div class="textarea__count"><span class="textarea__count-meta" id="input-text-length">0</span><i>/</i><span>1000</span></div>
                                    </div>
                                </div>
                                <div class="button-wrap">
                                    <button type="button" onclick="openModal('#modal-ALT-03');" class="button button--etc">취소</button>
                                    <button type="button" onclick="submitForm()" class="button button--solid">문의하기</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- 취소 버튼 클릭 시 -->
        <div id="modal-ALT-03" class="modal">
            <div class="modal__container" style="width: 350px;">
                <div class="modal__content">
                    <div class="modal-box__container">
                        <div class="modal-box__content">
                            <div class="modal__desc">
                                <p class="modal__text">
                                    작성 중인 내용이 있습니다. 진행을 취소하시겠습니까?
                                </p>
                            </div>
                            <div class="modal__util">
                                <button type="button" onclick="closeModal('#modal-ALT-03');" class="modal__button modal__button--gray"><span>취소</span></button>
                                <button type="button" onclick="history.back();" class="modal__button"><span>확인</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 등록 완료 팝업 -->
        <div id="modal-cswrite--complete" class="modal">
            <div class="modal__container" style="width: 350px;">
                <div class="modal__content">
                    <div class="modal-box__container">
                        <div class="modal-box__content">
                            <div class="modal__desc">
                                <p class="modal__text">
                                    1:1 문의가 {{  !is_null($detail) ? '수정' : '등록' }}되었습니다.
                                </p>
                            </div>
                            <div class="modal__util">
                                <button type="button" onclick="location.replace('/help/inquiry')" class="modal__button"><span>확인</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 필수항목 체크 팝업 -->
        <div id="LGI-05-modal3" class="modal">
            <div class="modal__container" style="width: 350px;">
                <div class="modal__content">
                    <div class="modal-box__container">
                        <div class="modal-box__content">
                            <div class="modal__desc">
                                <p class="modal__text">
                                    필수 항목이 입력되지 않았습니다.
                                    <br>다시 확인해주세요.
                                </p>
                            </div>
                            <div class="modal__util">
                                <button type="button" onclick="closeModal('#LGI-05-modal3');" class="modal__button"><span>확인</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@push('scripts')
    <script>
        const submitForm = () => {
            if (validate() === false) {
                openModal('#LGI-05-modal3');
                return false;
            }
            const formData = new FormData(document.getElementById('inquiryForm'));
            fetch('/help/inquiry', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: formData
            }).then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Sever Error');
            }).then(json => {
                if (json.result === 'success') {
                    openModal('#modal-cswrite--complete');
                } else {
                    alert(json.message)
                }
            }).catch(error => {
            })
        }

        const validate = () => {
            if (!document.getElementById('inquiry_category').value) {
                return false;
            }
            if (!document.getElementById('inquiry_title').value) {
                return false;
            }
            if (!document.getElementById('inquiry_content').value) {
                return false;
            }
            return true;
        }

        document.querySelectorAll('.inquiry-category').forEach(elem => {
            elem.addEventListener('click', e => {
                const category = e.currentTarget.querySelector('span').textContent;
                document.getElementById('inquiry_category').value = category;
            })
        })

        document.getElementById('inquiry_content').addEventListener('keyup', () => {
            makeContentLength();
        });

        const makeContentLength = () => {
            document.getElementById('input-text-length').textContent =
                document.getElementById('inquiry_content').value.length;
        }

        window.onload = () => {
            makeContentLength();
        };

        $('.dropdown__item').on('click', function () {
            $('.dropdown__title').css('color', '#1B1B1B');
        })
    </script>
@endpush
