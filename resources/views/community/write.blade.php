@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/js/froala_editor.pkgd.min.js"></script>
    <div id="container" class="container community community-write" style="min-height: calc(100vh - 409px);">
        <div class="inner">
            <div class="contents">
                <div class="blank"></div>
                <form name="write_article_form" id="write_article_form" method="post" action="/community/write" enctype="multipart/form-data">
                    @csrf
                    @if ($idx)
                        <input type="hidden" id="articleIdx" name="articleIdx" value="{{ $idx }}" />
                    @endif
                    <input type="hidden" id="selectBoard" name="selectBoard" value="{{ $idx ? $detail->board_idx : '' }}" />
                    <div class="community-content community-content--write">
                        <p class="community-content__title">게시글 {{ $idx ? '수정' : '작성' }}</p>
                        <div class="dropdown {{ $idx ? 'dropdown--disabled' : '' }}" style="width: 100%">
                            <p class="dropdown__title">{{ $idx ? $detail->board->name : (isset($orderGroupCode) ? '배차' : '게시판 선택') }}</p>
                            <div class="dropdown__wrap">
                                @foreach($boards as $board)
                                <a href="javascript:void(0)" onclick="writeFormSelectBoard({{$board->idx}})" class="dropdown__item">
                                    <span>{{$board->name}}</span>
                                </a>
                                @endforeach
                            </div>
                        </div>
                        <input type="text" placeholder="제목을 입력해주세요." id="boardTitle" name="boardTitle" maxlength="45" value="{{ $idx ? $detail->title : (isset($orderGroupCode) ? $order->product_name : '') }}" onkeyup="checkFormSubmitButtonAble()">
                        <div class="editor">
                            <textarea name="editor_content" id="article_content">
                                @if ($idx)
                                    {!! $detail->content !!}
                                @elseif(isset($orderGroupCode))
                                    <p>상품
                                    @foreach(explode(",",$order->products) as $product)
                                        @if($loop->index == 0)
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        @else
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        @endif
                                        {{ $product }}<br/>
                                    @endforeach
                                    </p>
                                    <p>배송지 &nbsp;&nbsp;{{ $order->delivery }}</p>
                                @endif
                            </textarea>
                            @if ($idx)
                            <div class="date" style="width: initial;">
                                <p>최초 등록 일시 : {{ date('Y.m.d H:i', strtotime($detail->register_time)) }}</p>
                                <p>최근 수정 일시 : {{ date('Y.m.d H:i', strtotime($detail->update_time)) }}</p>
                            </div>
                            @endif
                            <div class="util">
                                <div class="active">
                                    <button type="button" class="button button--blank-gray cancle" id="write_article_form_cancel" onclick="openModal('#modal-ALT-03')">
                                        취소
                                    </button>
                                    <button type="button" class="button button--solid complete" id="write_article_form_complete" {{ $idx ? '' : 'disabled' }}>
                                        완료
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
        </div>
        <div id="modal-regist--failure" class="modal">
            <div class="modal__container" style="width: 350px;">
                <div class="modal__content">
                    <div class="modal-box__container">
                        <div class="modal-box__content">
                            <div class="modal__desc">
                                <p class="modal__text">
                                    해당 게시판의 금지어를 사용하여<br>
                                    등록할 수 없습니다.
                                </p>
                            </div>
                            <div class="modal__util">
                                <button type="button" onclick="closeModal('#modal-regist--failure');" class="modal__button"><span>확인</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-regist--complete" class="modal">
            <div class="modal__container" style="width: 350px;">
                <div class="modal__content">
                    <div class="modal-box__container">
                        <div class="modal-box__content">
                            <div class="modal__desc">
                                <p class="modal__text">
                                    게시글이 등록되었습니다.
                                </p>
                            </div>
                            <div class="modal__util">
                                <button type="button" onclick="location.href='/community'" class="modal__button"><span>확인</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($idx)
        <div id="modal-regist--correction" class="modal">
            <div class="modal__container" style="width: 350px;">
                <div class="modal__content">
                    <div class="modal-box__container">
                        <div class="modal-box__content">
                            <div class="modal__desc">
                                <p class="modal__text">
                                    게시글이 수정되었습니다.
                                </p>
                            </div>
                            <div class="modal__util">
                                <button type="button" onclick="location.href='/community'" class="modal__button"><span>확인</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div id="modal-ALT-01" class="modal">
            <div class="modal__container" style="width: 350px;">
                <div class="modal__content">
                    <div class="modal-box__container">
                        <div class="modal-box__content">
                            <div class="modal__desc">
                                <p class="modal__text">
                                    필수 항목이 입력되지 않았습니다.<br>다시 확인해주세요.
                                </p>
                            </div>
                            <div class="modal__util">
                                <button type="button" onclick="closeModal('#modal-ALT-01');" class="modal__button"><span>확인</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="modal-ALT-03" class="modal">
            <div class="modal__container" style="width: 350px;">
                <div class="modal__content">
                    <div class="modal-box__container">
                        <div class="modal-box__content">
                            <div class="modal__desc">
                                <p class="modal__text">
                                    작성 중인 내용이 있습니다.<br>
                                    진행을 취소하시겠습니까?
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
    </div>
    
    <script>
        const editor = new FroalaEditor('#article_content', {
            key: 'wFE7nG5E4I4D3A11A6eMRPYf1h1REb1BGQOQIc2CDBREJImA11C8D6B5B1G4D3F2F3C8==',
            height:300,
            requestHeaders: {
                'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value
            },
            imageUploadParam: 'images',
            imageUploadURL: '/community/image',
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
                    @if(!$idx)
                    fetch('/community/image', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value
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

        // 폼 완료 버튼 활성화/비활성화 처리
        const checkFormSubmitButtonAble = () => {
            if (document.getElementById('selectBoard').value && document.getElementById('boardTitle').value) {
                document.getElementById('write_article_form_complete').removeAttribute('disabled');
            } else {
                document.getElementById('write_article_form_complete').setAttribute('disabled', true);
            }
        }

        // 게시판 선택 시
        const writeFormSelectBoard = idx => {
            document.getElementById('selectBoard').value = idx;
            checkFormSubmitButtonAble();
        }

        // 등록/수정 시 유효성 검증
        const validateWriteArticle = () => {
            let result = true;
            if (!document.getElementById('selectBoard').value) {
                result = false;
            } else if (!document.getElementById('boardTitle').value) {
                result = false;
            }
            return result;
        }

        // 완료 버튼 클릭 시
        document.getElementById('write_article_form_complete').addEventListener('click', e => {
            // 두번 클릭 방지
            if (e.currentTarget.classList.contains('writing')) {
                return false;
            }
            e.currentTarget.classList.add('writing');
            if(!validateWriteArticle()) {
                e.currentTarget.classList.remove('writing');
                openModal('#modal-ALT-01');
                return false;
            }
            const data = new URLSearchParams();
            for (const pair of new FormData(document.getElementById('write_article_form'))) {
                data.append(pair[0], pair[1]);
            }

            {{--- 이미지 저장한 경우 첫번째 이미지는 리스트에 썸네일 이미지로 나와야하기 때문에 별도로 이미지 경로를 전달한다 ---}}
            const parser = new DOMParser();
            const doc = parser.parseFromString(editor.html.get(), 'text/html');
            const images = doc.body.getElementsByTagName('img');
            if (images.length > 0) data.append('firstImage', images[0].src);

            fetch('/community/write', {
                method: '{{ $idx ? 'PUT' : 'POST' }}',
                headers: {
                    'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value
                },
                body: data,
            }).then(result => {
                return result.json()
            }).then(json => {
                if (json.result === 'success') {
                    @if ($idx)
                        openModal('#modal-regist--correction');
                    @else
                        openModal('#modal-regist--complete');
                    @endif
                    return false;
                } else {
                    if (json.code === 'USE_BANNED_WORDS') {
                        openModal('#modal-regist--failure');
                        return false;
                    }
                }
            }).finally(() => {
                document.getElementById('write_article_form_complete').classList.remove('writing');
            })
        })
        @if(isset($orderGroupCode))
            writeFormSelectBoard(5);
        @endif
    </script>
    
@endsection
