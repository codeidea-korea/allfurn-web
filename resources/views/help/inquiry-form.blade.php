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
            <h2 class="text-2xl font-bold">1:1 문의하기</h2>
        </div>
        <div class="com_setting border-t-2 border-gray-500 mt-5">
            <div class="stting_wrap mt-8 w-[962px] mx-auto">
                <div class="mb-4 flex">
                    @if (!is_null($detail))
                        <input type="hidden" id="inquiry_idx" name="inquiry_idx" value="{{ $detail->idx }}" />
                    @endif
                    <input type="hidden" id="inquiry_idx" name="inquiry_idx">
                    <div class="essential w-[190px] shrink-0 mt-2">문의 유형</div>
                    <div class="w-full">
                        <a href="javascript:;" class="h-[48px] px-3 border rounded-md inline-block filter_border filter_dropdown w-full flex justify-between items-center">
                            <p>
                                @if (!is_null($detail))
                                    {{ $detail->name }}
                                @else
                                    유형을 선택해주세요.
                                @endif
                            </p>
                            <svg class="w-6 h-6 filter_arrow"><use xlink:href="/img/icon-defs.svg#drop_b_arrow"></use></svg>
                        </a>
                        <div class="filter_dropdown_wrap w-[772px] h-[240px] overflow-y-scroll" style="display: none;">
                            <ul>
                                @foreach($categories as $category)
                                    <li>
                                        <a href="javascript:;" class="flex items-center">{{ $category->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <input type="hidden" id="inquiry_category" name="inquiry_category" value="{{ !is_null($detail) ? $detail->name : ''}}" />
                </div>
                <div class="mb-4 flex">
                    <div class="essential w-[190px] shrink-0 mt-2">문의 제목</div>
                    <div class="font-medium w-full">
                        <input type="text" id="inquiry_title" class="setting_input h-[48px] w-full" value="{{ !is_null($detail) ? $detail->title : '' }}" placeholder="문의 제목을 입력해주세요.">
                    </div>
                </div>
                <div class="mb-4 flex">
                    <div class="essential w-[190px] shrink-0 mt-2">문의 내용</div>
                    <div class="font-medium w-full">
                        <div class="relative setting_input pt-3 !px-0">
                            <textarea name="" id="inquiry_content" class="w-full h-[400px] px-3" placeholder="문의 내용을 입력해 주세요." maxlength="1000">{{ !is_null($detail) ? $detail->content : '' }}</textarea>
                            <div class="textarea_count flex items-center justify-end gap-1 w-full py-1 px-2 bg-[#f6f6f6]">
                                <span class="textarea_count-meta" id="input-text-length">0</span><i>/</i><span>1000</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-3 mb-24">
                    <button class="btn w-[150px] btn-primary-line mt-5" onclick="modalOpen('#cancel_writing_inquiry-modal')">취소</button>
                    <button class="btn w-[150px] btn-primary mt-5" id="inquiryBtn" onclick="submitForm()">문의하기</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 취소 버튼 클릭 시 -->
    <div class="modal" id="cancel_writing_inquiry-modal">
        <div class="modal_bg" onclick="modalClose('#cancel_writing_inquiry-modal')"></div>
        <div class="modal_inner modal-sm">
            <button class="close_btn" onclick="modalClose('#cancel_writing_inquiry-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <p class="text-center py-4"><b>작성 중인 내용이 있습니다.<br>진행을 취소하시겠습니까?</b></p>
                <div class="flex gap-2 justify-center">
                    <button class="btn w-full btn-primary-line mt-5" onclick="modalClose('#cancel_writing_inquiry-modal')">취소</button>
                    <button class="btn btn-primary w-full mt-5" onclick="history.back();">확인</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 등록 완료 팝업 -->
    <div class="modal" id="complete_inquiry-modal">
        <div class="modal_bg" onclick="modalClose('#complete_inquiry-modal')"></div>
        <div class="modal_inner modal-sm">
            <button class="close_btn" onclick="modalClose('#complete_inquiry-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <p class="text-center py-4"><b>1:1 문의가 {{ !is_null($detail) ? '수정' : '등록' }}되었습니다.</b></p>
                <div class="flex gap-2 justify-center">
                    <button class="btn btn-primary w-1/2 mt-5" onclick="location.replace('/help/inquiry')">확인</button>
                </div>
            </div>
        </div>
    </div>


    <!-- 필수항목 체크 팝업 -->
    <div class="modal" id="validate-modal">
        <div class="modal_bg" onclick="modalClose('#validate-modal')"></div>
        <div class="modal_inner modal-sm">
            <button class="close_btn" onclick="modalClose('#validate-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body agree_modal_body">
                <p class="text-center py-4"><b>필수 항목이 입력되지 않았습니다.<br>다시 확인해주세요.</b></p>
                <div class="flex gap-2 justify-center">
                    <button class="btn btn-primary w-1/2 mt-5" onclick="modalClose('#validate-modal')">확인</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        makeContentLength();

        // 드롭다운 토글
        $(".filter_dropdown").click(function(event) {
            var $thisDropdown = $(this).next(".filter_dropdown_wrap");
            $(this).toggleClass('active');
            $thisDropdown.toggle();
            $(this).find("svg").toggleClass("active");
            event.stopPropagation(); // 이벤트 전파 방지
        });

        // 드롭다운 항목 선택 이벤트
        $(".filter_dropdown_wrap ul li a").click(function(event) {
            var selectedText = $(this).text();
            $("#inquiry_category").val(selectedText);
            
            var $dropdown = $(this).closest('.filter_dropdown_wrap').prev(".filter_dropdown");
            $dropdown.find("p").text(selectedText);
            $(this).closest(".filter_dropdown_wrap").hide();
            $dropdown.removeClass('active');
            $dropdown.find("svg").removeClass("active");
            
            var targetClass = $(this).data('target');
            if (targetClass) {
                // 모든 targetClass 요소를 숨기고, 현재 targetClass만 표시
                $('[data-target]').each(function() {
                    var currentTarget = $(this).data('target');
                    if (currentTarget !== targetClass) {
                        $('.' + currentTarget).hide();
                    }
                });
                $('.' + targetClass).show(); // 현재 클릭한 targetClass 요소만 표시
            } else {
                // 현재 클릭이 data-target을 가지고 있지 않다면, 모든 targetClass 요소를 숨김
                $('[data-target]').each(function() {
                    var currentTarget = $(this).data('target');
                    $('.' + currentTarget).hide();
                });
            }

            event.stopPropagation(); // 이벤트 전파 방지
        });

        // 드롭다운 영역 밖 클릭 시 드롭다운 닫기
        $(document).click(function(event) {
            if (!$(event.target).closest('.filter_dropdown, .filter_dropdown_wrap').length) {
                $('.filter_dropdown_wrap').hide();
                $('.filter_dropdown').removeClass('active');
                $('.filter_dropdown svg').removeClass("active");
            }
        });
    });

    $("#inquiry_content").on('keyup', function() {
        makeContentLength();
    })

    function makeContentLength() {
        $("#input-text-length").text($("#inquiry_content").val().length);
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
                inquiry_category : $("#inquiry_category").val(),
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
        if(!$("#inquiry_category").val()) {
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