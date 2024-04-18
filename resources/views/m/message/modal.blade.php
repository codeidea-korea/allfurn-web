<!-- 알림 켜기 / 끄기 -->
<div class="modal hidden" id="alarm_on_modal">
    <div class="modal_bg" onclick="modalClose('#alarm_on_modal')"></div>
    <div class="modal_inner modal-sm">
        <div class="modal_body agree_modal_body">
            <p class="text-center py-4">해당 업체의 메세지 알림을 <span id="push-text">해제 하시겠습니까</span>?</p>
            <div class="flex gap-2 justify-center">
                <button class="btn w-full btn-primary-line mt-5" onclick="modalClose('#alarm_on_modal')">취소</button>
                <button class="btn w-full btn-primary mt-5" onclick="toggleAlarmPush()" id="confirmTogglePushBtn">확인</button>
            </div>
        </div>
    </div>
</div>


<!-- 신고 -->
<div class="modal hidden" id="declaration_modal">
    <div class="modal_bg" onclick="modalClose('#declaration_modal')"></div>
    <div class="modal_inner modal-md">
        <div class="modal_body filter_body">
            <h4>업체 신고</h4>
            <div class="com_setting py-3">
                <div>
                    <p>해당 업체를 신고하시겠습니까?</p>
                </div>
                <div class="border border-stone-300 rounded-sm py-3 px-3 mt-1">
                    <textarea name="" id="alltalkReportContent" onkeyup="writeReportContent(this)" class="w-full h-[250px]" placeholder="신고 사유를 입력해주세요."></textarea>
                    <div class="flex">
                        <p class="ml-auto"><span id="reportReasonTextCount">0</span> / 100</p>
                    </div>
                </div>
            </div>
            <div class="btn_bot">
                <button class="btn btn-primary !w-full" id="confirmReportBtn" disabled data-company-idx="" data-company-type="" onclick="report(this)">완료</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.modal.hidden').removeClass('hidden');
    });
</script>