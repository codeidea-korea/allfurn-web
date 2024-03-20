@extends('layouts.app_m')

@section('content')
{{-- @include('layouts.header_m') --}}

<div id="content">
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/js/froala_editor.pkgd.min.js"></script>

    <div class="detail_mo_top write_type">
        <div class="inner">
            <h3>게시글 {{ $idx ? '수정' : '작성' }}</h3>
            <a class="back_img" href="javascript:history.back()"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></a>
        </div>
    </div>

    @if ($idx)
        <input type="hidden" id="articleIdx" name="articleIdx" value="{{ $idx }}" />
    @endif
    <input type="hidden" id="selectBoard" name="selectBoard" value="{{ $idx ? $detail->board_idx : '' }}" />

    <section class="sub_section_bot community_write">
        <div class="join_inner">
            <div class="community_write_con01">
                <div class="dropdown_wrap">
                    <button class="dropdown_btn">게시판 선택</button>
                    <div class="dropdown_list">
                        @foreach($boards as $board)
                            <div class="dropdown_item" onclick="writeFormSelectBoard({{$board->idx}})">{{$board->name}}</div>
                        @endforeach
                    </div>
                </div>
                <div class="title">
                    <input type="text" class="input-form noline" placeholder="제목을 입력해주세요" value="{{ $idx ? $detail->title : (isset($orderGroupCode) ? $order->product_name : '') }}" onkeyup="checkFormSubmitButtonAble()">
                </div>
                <textarea class="textarea-form">
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
                <div class="btn_box">
                    <button class="btn btn-line3" onclick="modalOpen('#cancel_write_article-modal')">취소</button>
                    <button class="btn btn-primary" {{ $idx ? '' : 'disabled' }} onclick="writeArtice()">완료</button>
                </div>
            </div>
        </div>
    </section>

    {{-- 게시글 등록or수정 완료 모달 --}}
    <div class="modal" id="regist_article-modal">
        <div class="modal_bg" onclick="modalClose('#regist_article-modal')"></div>
        <div class="modal_inner modal-sm">
            <button class="close_btn" onclick="modalClose('#regist_article-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <p class="text-center py-4"><b>게시글이 {{$idx ? '수정' : '등록' }}되었습니다.</b></p>
                <div class="flex gap-2 justify-center">
                    <button class="btn btn-primary w-1/2 mt-5" onclick="location.href='/community'">확인</button>
                </div>
            </div>
        </div>
    </div>

    {{-- 금지어를 입력할 경우의 모달 --}}
    <div class="modal" id="failure_regist_article-modal">
        <div class="modal_bg" onclick="modalClose('#failure_regist_article-modal')"></div>
        <div class="modal_inner modal-sm">
            <button class="close_btn" onclick="modalClose('#failure_regist_article-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <p class="text-center py-4"><b>해당 게시판의 금지어를 사용하여<br>등록할 수 없습니다.</b></p>
                <div class="flex gap-2 justify-center">
                    <button class="btn btn-primary w-1/2 mt-5" onclick="modalClose('#failure_regist_article-modal')">확인</button>
                </div>
            </div>
        </div>
    </div>

    {{-- 취소버튼을 누를 경우의 모달 --}}
    <div class="modal" id="cancel_write_article-modal">
        <div class="modal_bg" onclick="modalClose('#cancel_write_article-modal')"></div>
        <div class="modal_inner modal-sm">
            <button class="close_btn" onclick="modalClose('#cancel_write_article-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <p class="text-center py-4">작성 중인 내용이 있습니다.<br>진행을 취소하시겠습니까?</p>
                <div class="flex gap-2 justify-center">
                    <button class="btn w-full btn-primary-line mt-5" onclick="modalClose('#cancel_write_article-modal')">취소</button>
                    <button class="btn w-full btn-primary mt-5" onclick="history.back();">확인</button>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    //에디터
    const editor = new FroalaEditor('.textarea-form', {
        key: 'wFE7nG5E4I4D3A11A6eMRPYf1h1REb1BGQOQIc2CDBREJImA11C8D6B5B1G4D3F2F3C8==',
        height:300,
        requestHeaders: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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

    // 완료 버튼 활성화/비활성화
    function checkFormSubmitButtonAble() {
        if($("#selectBoard").val() && $(".community_write_con01 .title .input-form").val()) {
            $(".btn_box .btn-primary").prop('disabled', false);
        } else {
            $(".btn_box .btn-primary").prop('disabled', true);
        }
    }

    //게시판 선택
    function writeFormSelectBoard(idx) {
        $("#selectBoard").val(idx);
        checkFormSubmitButtonAble();
    }

    let writing = false;
    // 게시글 작성or수정 완료
    function writeArtice() {
        if(writing) {
            return false;
        }
        
        writing = true;
        $(".btn_box .btn-primary").prop('disabled', true);

        const data = {
            articleIdx : $("#articleIdx").val(),
            selectBoard : $("#selectBoard").val(),
            boardTitle : $(".community_write_con01 .title .input-form").val(),
            editor_content : $(".textarea-form").val(),
            firstImage : function(e) { 
                // --- 이미지 저장한 경우 첫번째 이미지는 리스트에 썸네일 이미지로 나와야하기 때문에 별도로 이미지 경로를 전달한다 ---
                const parser = new DOMParser();
                const doc = parser.parseFromString(editor.html.get(), 'text/html');
                const images = doc.body.getElementsByTagName('img');
                return images.length > 0 ? images[0].src : ''
            },
        }

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: '{{ $idx ? 'PUT' : 'POST' }}',
            url: '/community/write',
            data : data,
            success : function (result) {
                if(result.result === 'success') {
                    modalOpen("#regist_article-modal");
                } else if(result.code === 'USE_BANNED_WORDS') {
                    modalOpen('#failure_regist_article-modal');
                }
            },
            complete : function () {
                writing = false;
                $(".btn_box .btn-primary").prop('disabled', false);
            }
        })

    }

</script>
@endsection