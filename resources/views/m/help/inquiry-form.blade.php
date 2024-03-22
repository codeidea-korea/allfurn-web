@extends('layouts.app_m')
@php
    $only_quick = '';
    $header_depth = 'mypage';
    $top_title = '고객센터';
    $header_banner = '';
@endphp
@section('content')
@include('layouts.header_m')

<div id="content">
    <div class="inner">
        @if (!is_null($detail))
            <input type="hidden" id="inquiry_idx" name="inquiry_idx" value="{{ $detail->idx }}" />
        @endif
        <div class="mt-4">
            <p>문의 유형<span class="text-primary">*</span></p>
            <button class="flex items-center justify-between gap-1 h-[42px] border border-stone-300 rounded-sm px-2 mt-1 w-full" onclick="modalOpen('#inquiry_details_modal')">
                <span id="inquiry_category">{{ !is_null($detail) ? $detail->name : '문의 유형을 선택해주세요.' }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-4 h-4"><path d="m6 9 6 6 6-6"></path></svg>
            </button>
        </div>
        <div class="mt-4">
            <p>문의 제목<span class="text-primary">*</span></p>
                <input type="text" id="inquiry_title" class="setting_input h-[48px] w-full" value="{{ !is_null($detail) ? $detail->title : '' }}" placeholder="문의 제목을 입력해주세요.">
        </div>
        <div class="mt-4">
            <p>문의 내용<span class="text-primary">*</span></p>
            <div class="border border-stone-300 rounded-sm h-[350px] py-2 px-2 mt-1">
                <textarea name="" id="inquiry_content" class="w-full h-full" placeholder="문의 내용을 입력해 주세요.">{{ !is_null($detail) ? $detail->content : '' }}</textarea>
            </div>
        </div>
        <div class="py-4">
            <button class="flex items-center justify-center bg-primary h-[42px] text-white w-full rounded-sm" id="inquiryBtn" onclick="submitForm()">문의하기</button>
        </div>
    </div>

    <div class="modal" id="inquiry_details_modal">
        <div class="modal_bg" onclick="modalClose('#inquiry_details_modal')"></div>
        <div class="modal_inner modal-md">
            <div class="modal_body filter_body">
                <h4>문의 유형</h4>
                <div class="text-sm py-3">
                    <div class="check_radio flex flex-col justify-center divide-y divide-stone-100">
                        @foreach($categories as $category)
                            <div class="text-stone-400 py-2">
                                <input type="radio" name="transaction_status" id="trans_status{{ $loop->index }}" {{ $category->name ==  $detail->name ? 'checked' : ''}}>
                                <label for="trans_status{{ $loop->index }}" class="flex items-center gap-1 text-sm">
                                    {{ $category->name }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-4 h-4"><path d="M20 6 9 17l-5-5"/></svg>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-center">
                    <button class="bg-primary text-white h-[42px] rounded-sm w-full font-medium" onclick="selectCategory()">확인</button>
                </div>

            </div>
        </div>
    </div>

    <!-- 필수항목 체크 팝업 -->
    <div class="modal" id="validate-modal">
        <div class="modal_bg" onclick="modalClose('#validate-modal')"></div>
        <div class="modal_inner modal-sm">
            <div class="modal_body agree_modal_body">
                <p class="text-center py-4">필수 항목이 입력되지 않았습니다.<br>다시 확인해주세요.</p>
                <div class="flex gap-2 justify-center">
                    <button class="btn w-full btn-primary mt-5" onclick="modalClose('#validate-modal')">확인</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 등록 완료 팝업 -->
    <div class="modal" id="complete_inquiry-modal">
        <div class="modal_bg" onclick="modalClose('#complete_inquiry-modal')"></div>
        <div class="modal_inner modal-sm">
            <div class="modal_body agree_modal_body">
                <p class="text-center py-4">1:1 문의가 {{ !is_null($detail) ? '수정' : '등록' }}되었습니다.</p>
                <div class="flex gap-2 justify-center">
                    <button class="btn w-full btn-primary mt-5" onclick="history.back()">확인</button>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    function selectCategory() {
        $("#inquiry_category").text($("input[name='transaction_status']:checked").siblings().text().trim())
        modalClose('#inquiry_details_modal')
    }

    function submitForm() {
        if(!validateForm()) {
            modalOpen("#validate-modal")
            return false;
        }

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            url: '/help/inquiry',
            data : {
                inquiry_idx : function() {
                    return $("#inquiry_idx").val() ? $("#inquiry_idx").val() : ''
                },
                inquiry_category : $("#inquiry_category").text(),
                inquiry_title : $("#inquiry_title").val(),
                inquiry_content : $("#inquiry_content").val(),
            },
            beforeSend : function() {
                $("#inquiryBtn").attr('disabled', true);
            },
            success : function (result) {
                if(result.result === "success") {
                    modalOpen('#complete_inquiry-modal');
                } else {
                    alert(result.message)
                }
            },
            complete : function () {
                $("#inquiryBtn").attr('disabled', false);
            }
        })
    }

    function validateForm() {
        if(!$("#inquiry_category").text()) {
            return false;
        }
        if(!$("#inquiry_title").val()) {
            return false;
        }
        if(!$("#inquiry_content").val()) {
            return false;
        }
        return true;
    }
</script>

@endsection