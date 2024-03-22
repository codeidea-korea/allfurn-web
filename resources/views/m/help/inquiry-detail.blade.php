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
    <div class="bg-stone-100">
        <div class="p-4 bg-white rounded-sm shadow-sm">
            <div class="flex items-center justify-between">
                @if ($state === 0)
                    <span class="p-1 bg-stone-100 text-stone-500 rounded-sm text-xs">답변대기</span>
                @else
                    <span class="p-1 bg-primaryop text-primary rounded-sm text-xs">답변완료</span>
                @endif
                <span class="text-xs text-stone-500">{{ date('Y.m.d', strtotime($register_time)) }}</span>
            </div>
            <div class="mt-2">
                <span class="font-medium w-[100px] shrink-0">[{{ $name }}]</span>
                <span class="font-medium shrink-0">{{ $title }}</span>
            </div>
            <hr class="border-t mt-3">
            <p class="py-4">{!! nl2br($content) !!}</p>
        </div>
        @if($reply)
            <!-- 답변 있을 때 -->
            <div class="p-4 bg-white mt-3">
                <div class="flex items-center justify-between">
                    <span class="text-primary font-medium">문의 답변</span>
                    <span class="text-xs text-stone-500">{{ date('Y.m.d', strtotime($reply_date)) }}</span>
                </div>
                <p class="mt-2">{!! nl2br($reply) !!}</p>
            </div>
        @else
            <!-- 답변 없을 때 버튼  -->
        <div class="flex justify-center gap-3 p-4 bg-white">
            <button class="border rounded-md h-[40px] grow" onclick="cancelInquiry({{ $idx }})">문의 취소하기</button>
            <a href="/help/inquiry/form/{{ $idx }}" class="border rounded-md h-[40px] grow flex items-center justify-center">문의 수정하기</a>
        </div>
        @endif
    </div>
    
    <!-- 문의 취소 모달 -->
    <div class="modal" id="cancel_inquiry-modal">
        <div class="modal_bg" onclick="modalClose('#cancel_inquiry-modal')"></div>
        <div class="modal_inner modal-sm">
            <div class="modal_body agree_modal_body">
                <p class="text-center py-4">문의를 취소하시겠습니까?</p>
                <div class="flex gap-2 justify-center">
                    <button class="btn w-full btn-primary-line mt-5" onclick="modalClose('#cancel_inquiry-modal')">취소</button>
                    <button class="btn w-full btn-primary mt-5" onclick="doCancelInquiry(this)" id="doCancelInquiry">확인</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 문의 취소 완료 모달 -->
    <div class="modal" id="complete_cancel_inquiry-modal">
        <div class="modal_bg" onclick="modalClose('#complete_cancel_inquiry-modal')"></div>
        <div class="modal_inner modal-sm">
            <div class="modal_body agree_modal_body">
                <p class="text-center py-4">문의가 취소되었습니다.</p>
                <div class="flex gap-2 justify-center">
                    <button class="btn w-full btn-primary mt-5" onclick="location.href='/help/inquiry'">확인</button>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    function cancelInquiry(idx) {
        $("#doCancelInquiry").val(idx);
        modalOpen("#cancel_inquiry-modal");
    }

    function doCancelInquiry(element) {
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'DELETE',
            url: '/help/inquiry/' + $(element).val() ,
            beforeSend: function() {
                $("#doCancelInquiry").prop('disabled', true)
            },
            success : function (result) {
                if(result.result === 'success') {
                    modalClose('#cancel_inquiry-modal')
                    modalOpen("#complete_cancel_inquiry-modal");
                }
            },
            complete : function() {
                
            }
        })
    }
</script>
@endsection
