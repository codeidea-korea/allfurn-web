<div class="my__section account-managemenet--secession">
    <div class="content">
        <div class="section">
            <div class="section__head">
                <div class="section__head__group">
                    <h3 class="section__title">계정 관리</h3>
                </div>
            </div>
            <div class="section__content">
                <div class="content__head">
                    <h4>회원 탈퇴</h4>
                </div>

                <div class="content__body">
                    <div class="body__textarea">
                        <p>탈퇴 시, 탈퇴일 기점으로 1개월간 재가입이 불가하며 1개월 이후 신규 가입이 가능합니다.</p>
                        <p>탈퇴일 기점으로 1년간 회원 정보가 유지되며 1년 경과 후 모든 정보가 삭제됩니다.</p>
                        <p>탈퇴와 관련된 자세한 내용은 올펀 고객센터에 문의해주세요.</p>
                    </div>
                    <div class="body__check">
                        <label for="secession-check">
                            <input type="checkbox" id="secession-check" class="checkbox__checked">
                            <span class="check__text--gray">탈퇴 관련 안내를 모두 확인하였으며 회원 탈퇴에 동의합니다.</span>
                        </label>
                    </div>
                </div>

                <div class="content__button">
                    <button type="button" class="button button--solid" id="completeBtn" onclick="withdrawal()" disabled>완료</button>
                </div>

                <!-- 탈퇴 완료 팝업 -->
                <div id="alert-modal" class="alert-modal">
                    <div class="alert-modal__container">
                        <div class="alert-modal__top">
                            <p>
                                탈퇴가 완료되었습니다.<br>
                                서비스를 이용해주셔서 감사합니다.
                            </p>
                        </div>
                        <div class="alert-modal__bottom">
                            <button type="button" class="button button--solid" onclick="location.href='/'">
                                확인
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        const withdrawal = () => {
            if (document.getElementById('secession-check').checked === false) {
                alert('동의 후 진행 가능합니다.');
                return false;
            }
            withdrawal_proc();
        }

        const withdrawal_proc = () => {
            fetch('/mypage/withdrawal', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            }).then(response => {
                return response.json();
            }).then(json => {
                openModal('#alert-modal');
            })
        }

        document.getElementById('secession-check').addEventListener('click', e => {
            if (e.currentTarget.checked) {
                document.getElementById('completeBtn').removeAttribute('disabled');
            } else {
                document.getElementById('completeBtn').setAttribute('disabled', 'disabled');
            }
        })
    </script>
@endpush
