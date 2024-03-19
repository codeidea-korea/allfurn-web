@extends('layouts.app')

@section('content')
@include('layouts.header')

<div id="content">
    <div class="inner">
        <div class="pt-10 pb-6 flex items-center gap-1 text-stone-400">
            <p>고객센터</p>
            <p>></p>
            <p>1:1문의</p>
        </div>
        <div class="flex itesm-center justify-between">
            <h2 class="text-2xl font-bold">1:1 문의</h2>
            <a href="/help/inquiry/form" class="h-[48px] w-[140px] border rounded-md flex items-center justify-center">1:1 문의</a>
        </div>
        <hr class="mt-5">
        @if($count < 1)
            <!-- 1:1 문의 없을 떼 -->
            <div class="flex items-center justify-center h-[300px]">
                <div class="flex flex-col items-center justify-center gap-1 text-stone-500">
                    <img class="w-8" src="/img/member/info_icon.svg" alt="">
                    <p>등록하신 1:1 문의가 없습니다.</p>
                </div>
            </div>
        @else
            <!-- 최대 10개 출력 -->
            <div class="accordion divide-y divide-gray-200">
                @foreach($list as $row)
                    <div class="accordion-item">
                        <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                            <div class="flex items-center gap-4">
                                <span class="text-sm text-stone-400 w-16 shrink-0">{{ $row->category->name }}</span>
                                <span class="text-lg">{{ $row->title }}</span>
                                <span class="text-sm text-stone-400">{{ date('Y.m.d', strtotime($row->register_time)) }}</span>
                                @if ($row->state === 0)
                                    <span class="text-stone-400 bg-stone-100 py-1 px-2 text-xs ml-auto shrink-0">답변대기</span>
                                @else
                                    <span class="text-primary bg-primaryop py-1 px-2 text-xs ml-auto shrink-0">답변완료</span>
                                @endif
                            </div>
                        </button>
                        <div class="relative top-[-17px] inline-flex items-center gap-1.5 pl-24 ml-1 text-xs text-stone-400">
                            <button onclick="cancelInquiry({{ $row->idx }})">문의 취소</button>
                            <i class="h-2 border-r border-stone-400"></i>
                            <button onclick="location.href='/help/inquiry/form/{{ $row->idx }}'">수정</button>
                        </div>
                        <div class="accordion-body hidden p-5 bg-stone-50">
                            <p class="w-1/2">
                                {!! nl2br($row->content) !!}
                            </p>
                            @if($row->reply)
                                <div class="bg-stone-200 p-5 mt-5 rounded-md">
                                    <p class="text-sm text-stone-400">{{ date('Y.m.d', strtotime($row->reply_date)) }}</p>
                                    <div class="mt-2">
                                        {!! nl2br($row->reply) !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        
        @if($count > 0)
            <div class="pagenation flex items-center justify-center py-12">
                @if($pagination['prev'] > 0)
                    <a href="javascript:;" class="" onclick="moveToList({{$pagination['prev']}})">
                        <
                    </a>
                @endif

                @foreach ($pagination['pages'] as $paginate)
                    @if ($paginate == $offset)
                        <a href="javascript:;" class="active" onclick="moveToList({{$paginate}})">{{$paginate}}</a>
                    @else
                        <a href="javascript:;" class="" onclick="moveToList({{$paginate}})">{{$paginate}}</a>
                    @endif
                @endforeach

                @if($pagination['next'] > 0)
                    <a href="javascript:;" class="" onclick="moveToList({{$pagination['next']}})">
                        >
                    </a>
                @endif
            </div>
        @endif
    </div>

    {{-- 문의 취소 모달 --}}
    <div class="modal" id="cancel_inquiry-modal">
        <div class="modal_bg" onclick="modalClose('#cancel_inquiry-modal')"></div>
        <div class="modal_inner modal-sm">
            <button class="close_btn" onclick="modalClose('#cancel_inquiry-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <p class="text-center py-4"><b>문의를 취소하시겠습니까?</b></p>
                <div class="flex gap-2 justify-center">
                    <button class="btn w-full btn-primary-line mt-5" onclick="modalClose('#cancel_inquiry-modal')">취소</button>
                    <button class="btn btn-primary w-full mt-5" onclick="doCancelInquiry(this)" id="doCancelInquiry">확인</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 등록 완료 팝업 -->
    <div class="modal" id="complete_cancel_inquiry-modal">
        <div class="modal_bg" onclick="modalClose('#complete_cancel_inquiry-modal')"></div>
        <div class="modal_inner modal-sm">
            <button class="close_btn" onclick="modalClose('#complete_cancel_inquiry-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <p class="text-center py-4"><b>문의가 취소되었습니다.</b></p>
                <div class="flex gap-2 justify-center">
                    <button class="btn btn-primary w-1/2 mt-5" onclick="location.reload()">확인</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".accordion-header").click(function() {
            // 클릭된 항목의 바디를 토글합니다.
            var $body = $(this).siblings(".accordion-body");
            $body.slideToggle(200);

            // 선택적: 클릭된 헤더와 같은 아코디언 그룹 내의 다른 모든 바디를 닫습니다.
            $(this).closest('.accordion').find(".accordion-body").not($body).slideUp(200);
        });
    });

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