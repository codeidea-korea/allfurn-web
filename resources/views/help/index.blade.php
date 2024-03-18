@extends('layouts.app')

@section('content')
@include('layouts.header')

<div id="content">
    <div class="inner">
        <div class="mt-10">
            <h2 class="text-2xl font-bold">고객센터</h2>
        </div>
        <div class="border rounded-md p-5 flex items-center justify-between mt-4">
            <div>
                <div class="text-stone-500">궁금한 내용이 있으신가요?</div>
                <div class="font-bold text-3xl mt-2">031-813-5588</div>
                <div class="mt-2"><span class="text-stone-500">운영시간</span> | 평일 09:00 - 18:00</div>
            </div>
            <div class="flex flex-col gap-2">
                <button class="h-[48px] w-[140px] border rounded-md" onclick="modalOpen('#writing_guide_modal')">올펀 이용 가이드</button>
                <a href="./inquiry.php" class="h-[48px] w-[140px] border rounded-md flex items-center justify-center">1:1 문의</a>
            </div>
        </div>
        <div class="border-b">
            <div class="flex gap-5">
                <a href="javascript:;" class="border-b-2 border-primary text-primary font-bold py-4">자주 묻는 질문</a>
                <a href="./notice.php" class="font-medium py-4 text-stone-400">공지사항</a>
            </div>
        </div>
        <div class="tab_faq mt-6">
            <button class="active h-[48px]" data-target="faq_sec01">전체</button>
            <button class="h-[48px]" data-target="faq_sec02">회원정보</button>
            <button class="h-[48px]" data-target="faq_sec03">상품등록</button>
            <button class="h-[48px]" data-target="faq_sec04">주문/결제</button>
            <button class="h-[48px]" data-target="faq_sec05">미니홈피</button>
            <button class="h-[48px]" data-target="faq_sec06">알림서비스</button>
        </div>
        <!-- 아코디언 리스트 최대 10개씩 출력 -->
        <div id="faq_sec01" class="faq_content">
            <div class="accordion divide-y divide-gray-200">
                <div class="accordion-item">
                    <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                        <div class="flex items-center gap-2">
                            <span>Q</span>
                            <span class="text-lg">일반회원과 정회원의 차이가 무엇인가요?</span>
                        </div>
                    </button>
                    <div class="accordion-body hidden p-5 bg-stone-50">
                        <p class="text-sm">A</p>
                        <p class="w-1/2">
                            정회원은 올펀에서 실제로 거래를 이루는 제조도매, 소매 업체입니다.
                            정회원으로 회원가입을 하기 위해서는 사업자 인증이 필요합니다.
                            일반 회원은 가구 관련 업체가 명함 인증만으로 가입할 수 있습니다.
                            이미 일반회원으로 가입하신 회원분들께서는 승격 요청을 해주세요.<br/><br/>
                            *상품의 가격은 일반회원에게는 표시되지 않습니다.
                        </p>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                        <div class="flex items-center gap-2">
                            <span>Q</span>
                            <span class="text-lg">정회원이 되려면 무엇이 필요한가요?</span>
                        </div>
                    </button>
                    <div class="accordion-body hidden p-5 bg-stone-50">
                        <p class="text-sm">A</p>
                        <p class="w-1/2">
                            정회원으로 회원가입을 하기 위해서는 사업자 인증이 필요합니다.
                            사업자 등록증 JPG 파일을 준비하여 승격 신청을 해주세요.
                        </p>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                        <div class="flex items-center gap-2">
                            <span>Q</span>
                            <span class="text-lg">정회원 승격 신청시 소요되는 시간이 얼마나 되나요?</span>
                        </div>
                    </button>
                    <div class="accordion-body hidden p-5 bg-stone-50">
                        <p class="text-sm">A</p>
                        <p class="w-1/2">
                            업무일 기준 평균 1일이 소요됩니다.
                            승격이 완료될 시 문자로 안내됩니다.
                        </p>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                        <div class="flex items-center gap-2">
                            <span>Q</span>
                            <span class="text-lg">비밀번호를 변경할 수 있나요?</span>
                        </div>
                    </button>
                    <div class="accordion-body hidden p-5 bg-stone-50">
                        <p class="text-sm">A</p>
                        <p class="w-1/2">
                            대표 계정의 비밀번호는 이메일 인증을 통해 재설정이 가능합니다.
                            직원 계정의 비밀번호 재설정은 대표 계정 로그인 후 "마이 올펀"에서 재설정이 가능합니다.
                        </p>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                        <div class="flex items-center gap-2">
                            <span>Q</span>
                            <span class="text-lg">아이디를 변경할 수 있나요?</span>
                        </div>
                    </button>
                    <div class="accordion-body hidden p-5 bg-stone-50">
                        <p class="text-sm">A</p>
                        <p class="w-1/2">
                            대표 계정의 아이디는 변경할 수 없습니다.
                            직원 계정의 아이디는 "마이 올펀" → "계정 관리" → "이메일 인증" → "직원 계정 수정"을 통해서 변경할 수 있습니다.
                        </p>
                    </div>
                </div>
            </div>
            <div class="pagenation flex items-center justify-center py-12">
                <a href="javascript:;" class="active">1</a>
                <a href="javascriot:;">2</a>
                <a href="javascriot:;">3</a>
                <a href="javascriot:;">4</a>
                <a href="javascriot:;">5</a>
            </div>
        </div>
        <div id="faq_sec02" class="faq_content hidden">
            <div class="accordion divide-y divide-gray-200">
                <div class="accordion-item">
                    <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                        <div class="flex items-center gap-2">
                            <span>Q</span>
                            <span class="text-lg">일반회원과 정회원의 차이가 무엇인가요?</span>
                        </div>
                    </button>
                    <div class="accordion-body hidden p-5 bg-stone-50">
                        <p class="text-sm">A</p>
                        <p class="w-1/2">
                            정회원은 올펀에서 실제로 거래를 이루는 제조도매, 소매 업체입니다.
                            정회원으로 회원가입을 하기 위해서는 사업자 인증이 필요합니다.
                            일반 회원은 가구 관련 업체가 명함 인증만으로 가입할 수 있습니다.
                            이미 일반회원으로 가입하신 회원분들께서는 승격 요청을 해주세요.<br/><br/>
                            *상품의 가격은 일반회원에게는 표시되지 않습니다.
                        </p>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                        <div class="flex items-center gap-2">
                            <span>Q</span>
                            <span class="text-lg">정회원이 되려면 무엇이 필요한가요?</span>
                        </div>
                    </button>
                    <div class="accordion-body hidden p-5 bg-stone-50">
                        <p class="text-sm">A</p>
                        <p class="w-1/2">
                            정회원으로 회원가입을 하기 위해서는 사업자 인증이 필요합니다.
                            사업자 등록증 JPG 파일을 준비하여 승격 신청을 해주세요.
                        </p>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                        <div class="flex items-center gap-2">
                            <span>Q</span>
                            <span class="text-lg">정회원 승격 신청시 소요되는 시간이 얼마나 되나요?</span>
                        </div>
                    </button>
                    <div class="accordion-body hidden p-5 bg-stone-50">
                        <p class="text-sm">A</p>
                        <p class="w-1/2">
                            업무일 기준 평균 1일이 소요됩니다.
                            승격이 완료될 시 문자로 안내됩니다.
                        </p>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                        <div class="flex items-center gap-2">
                            <span>Q</span>
                            <span class="text-lg">비밀번호를 변경할 수 있나요?</span>
                        </div>
                    </button>
                    <div class="accordion-body hidden p-5 bg-stone-50">
                        <p class="text-sm">A</p>
                        <p class="w-1/2">
                            대표 계정의 비밀번호는 이메일 인증을 통해 재설정이 가능합니다.
                            직원 계정의 비밀번호 재설정은 대표 계정 로그인 후 "마이 올펀"에서 재설정이 가능합니다.
                        </p>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                        <div class="flex items-center gap-2">
                            <span>Q</span>
                            <span class="text-lg">아이디를 변경할 수 있나요?</span>
                        </div>
                    </button>
                    <div class="accordion-body hidden p-5 bg-stone-50">
                        <p class="text-sm">A</p>
                        <p class="w-1/2">
                            대표 계정의 아이디는 변경할 수 없습니다.
                            직원 계정의 아이디는 "마이 올펀" → "계정 관리" → "이메일 인증" → "직원 계정 수정"을 통해서 변경할 수 있습니다.
                        </p>
                    </div>
                </div>
            </div>
            <div class="pagenation flex items-center justify-center py-12">
                <a href="javascript:;" class="active">1</a>
                <a href="javascriot:;">2</a>
                <a href="javascriot:;">3</a>
                <a href="javascriot:;">4</a>
                <a href="javascriot:;">5</a>
            </div>
        </div>
        <div id="faq_sec03" class="faq_content hidden">
            <div class="accordion divide-y divide-gray-200">
                <div class="accordion-item">
                    <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                        <div class="flex items-center gap-2">
                            <span>Q</span>
                            <span class="text-lg">상품을 새로 등록하면 어느곳에 보여지나요?</span>
                        </div>
                    </button>
                    <div class="accordion-body hidden p-5 bg-stone-50">
                        <p class="text-sm">A</p>
                        <p class="w-1/2">
                            카테고리, 신상품, 도매 업체(미니홈피) 탭에 노출됩니다.
                            이달의 도매 및 배너등에 노출을 원하신다면 고객센터로 문의해주세요.
                        </p>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                        <div class="flex items-center gap-2">
                            <span>Q</span>
                            <span class="text-lg">선택하고싶은 상품 속성이 선택지에 없을때는 어떻게 하죠?</span>
                        </div>
                    </button>
                    <div class="accordion-body hidden p-5 bg-stone-50">
                        <p class="text-sm">A</p>
                        <p class="w-1/2">
                            "상품 추가 공지"란에 입력이 가능합니다.
                            자주 쓰일것으로 보여지는 상품 속성은 고객센터에 요청해주시기 바랍니다.
                        </p>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                        <div class="flex items-center gap-2">
                            <span>Q</span>
                            <span class="text-lg">사진은 얼마나 올릴 수 있나요?</span>
                        </div>
                    </button>
                    <div class="accordion-body hidden p-5 bg-stone-50">
                        <p class="text-sm">A</p>
                        <p class="w-1/2">
                            사진의 수는 제한이 없으나 총 합산 용량이 30 MB 미만이어야 합니다.
                        </p>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                        <div class="flex items-center gap-2">
                            <span>Q</span>
                            <span class="text-lg">동영상은 어떻게 올릴 수 있나요?</span>
                        </div>
                    </button>
                    <div class="accordion-body hidden p-5 bg-stone-50">
                        <p class="text-sm">A</p>
                        <p class="w-1/2">
                            유튜브를 통해 영상을 업로드하신 뒤 영상 주소 링크를 등록하는 방법을 추천드립니다.
                        </p>
                    </div>
                </div>
            </div>
            <div class="pagenation flex items-center justify-center py-12">
                <a href="javascript:;" class="active">1</a>
                <a href="javascriot:;">2</a>
                <a href="javascriot:;">3</a>
                <a href="javascriot:;">4</a>
                <a href="javascriot:;">5</a>
            </div>
        </div>
        <div id="faq_sec04" class="faq_content hidden">
            <div class="accordion divide-y divide-gray-200">
                <div class="accordion-item">
                    <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                        <div class="flex items-center gap-2">
                            <span>Q</span>
                            <span class="text-lg">결제 수단에는 어떤 것들이 있나요?</span>
                        </div>
                    </button>
                    <div class="accordion-body hidden p-5 bg-stone-50">
                        <p class="text-sm">A</p>
                        <p class="w-1/2">
                            기본적인 결제 수단에는 세금계산서 발행과 계좌이체가 있습니다.
                            모든 결제 방식은 올펀을 통해서가 아닌 도매, 소매업체가 서로 진행합니다.
                        </p>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                        <div class="flex items-center gap-2">
                            <span>Q</span>
                            <span class="text-lg">주문이 들어왔어요. 어떻게 해야하나요?</span>
                        </div>
                    </button>
                    <div class="accordion-body hidden p-5 bg-stone-50">
                        <p class="text-sm">A</p>
                        <p class="w-1/2">
                            올톡을 이용하여 소매 업체와 비용 지급 및 발송 일정을 협의하시는 것을 추천드립니다.
                        </p>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                        <div class="flex items-center gap-2">
                            <span>Q</span>
                            <span class="text-lg">주문수량을 수정할 수 있나요?</span>
                        </div>
                    </button>
                    <div class="accordion-body hidden p-5 bg-stone-50">
                        <p class="text-sm">A</p>
                        <p class="w-1/2">
                            거래 확정 전에는 구매자가 주문취소 후 재구매하여 수정이 가능합니다.
                            판매자가 거래 확정을 한 상태라면 판매자에게 문의 해주세요.
                        </p>
                    </div>
                </div>
            </div>
            <div class="pagenation flex items-center justify-center py-12">
                <a href="javascript:;" class="active">1</a>
                <a href="javascriot:;">2</a>
                <a href="javascriot:;">3</a>
                <a href="javascriot:;">4</a>
                <a href="javascriot:;">5</a>
            </div>
        </div>
        <div id="faq_sec05" class="faq_content hidden">
            <div class="accordion divide-y divide-gray-200">
                <div class="accordion-item">
                    <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                        <div class="flex items-center gap-2">
                            <span>Q</span>
                            <span class="text-lg">업체명 아래에 있는 대표 카테고리는 어떻게 설정하나요?</span>
                        </div>
                    </button>
                    <div class="accordion-body hidden p-5 bg-stone-50">
                        <p class="text-sm">A</p>
                        <p class="w-1/2">
                            회원님이 많이 등록한 상품 순서로 5개까지 자동 등록됩니다.
                        </p>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                        <div class="flex items-center gap-2">
                            <span>Q</span>
                            <span class="text-lg">도매 정회원인데 왜 도매업체에 올라가있지 않나요?</span>
                        </div>
                    </button>
                    <div class="accordion-body hidden p-5 bg-stone-50">
                        <p class="text-sm">A</p>
                        <p class="w-1/2">
                            "마이올펀" → " 업체관리"에서 업체 상세정보를 등록하고 상품을 5개 이상 등록해야 도매업체 리스트에 노출됩니다.
                        </p>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                        <div class="flex items-center gap-2">
                            <span>Q</span>
                            <span class="text-lg">몇가지 제품은 제 미니 홈피의 가장 위에 보여지게 하고싶어요.</span>
                        </div>
                    </button>
                    <div class="accordion-body hidden p-5 bg-stone-50">
                        <p class="text-sm">A</p>
                        <p class="w-1/2">
                            "마이올펀" → " 상품관리"에서 등록된 상품 리스트의 왼쪽 별표를 체크해보세요.
                            최대 5개까지 체크할 수 있으며 체크 시 "추천상품"으로 전환됩니다.
                            "추천상품"은 미니홈피의 가장 위에 표시됩니다.
                        </p>
                    </div>
                </div>
            </div>
            <div class="pagenation flex items-center justify-center py-12">
                <a href="javascript:;" class="active">1</a>
                <a href="javascriot:;">2</a>
                <a href="javascriot:;">3</a>
                <a href="javascriot:;">4</a>
                <a href="javascriot:;">5</a>
            </div>
        </div>
        <div id="faq_sec06" class="faq_content hidden">
            <div class="accordion divide-y divide-gray-200">
                <div class="accordion-item">
                    <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                        <div class="flex items-center gap-2">
                            <span>Q</span>
                            <span class="text-lg">올톡이 자동으로 전송되는 경우가 있나요?</span>
                        </div>
                    </button>
                    <div class="accordion-body hidden p-5 bg-stone-50">
                        <p class="text-sm">A</p>
                        <p class="w-1/2">
                            네! 소매 고객이 주문을 한 시점부터 여러가지 진행 절차가 올톡으로 전송됩니다.
                            주문 완료 / 거래 확정 / 발송 / 발송 완료 / 거래 취소 / 주문 취소
                        </p>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header py-4 px-5 w-full text-left" type="button">
                        <div class="flex items-center gap-2">
                            <span>Q</span>
                            <span class="text-lg">푸시 알림에는 어떤 것 들이 있나요?</span>
                        </div>
                    </button>
                    <div class="accordion-body hidden p-5 bg-stone-50">
                        <p class="text-sm">A</p>
                        <p class="w-1/2">
                            1) 회원정보, 거래 현황, 등록한 상품 상태가 변경된 경우.<br/>
                            2) 좋아요 한 업체에서 신상품을 업로드 한 경우.<br/>
                            3) 구독한 게시판에 새 글이 업로드 된 경우.<br/>
                            4) 관리자가 수동 공지사항 푸시 및  광고 푸시를 진행한 경우.<br/>
                            -. 일일가구뉴스 / 글로벌위클리뉴스 / 주간건축정보 / 월간입주정보 / 공지사항 / 광고
                        </p>
                    </div>
                </div>
            </div>
            <div class="pagenation flex items-center justify-center py-12">
                <a href="javascript:;" class="active">1</a>
                <a href="javascriot:;">2</a>
                <a href="javascriot:;">3</a>
                <a href="javascriot:;">4</a>
                <a href="javascriot:;">5</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
    // 초기 상태에서 "전체" 탭의 내용을 제외한 나머지 컨텐츠 섹션을 숨깁니다.
    // "전체" 탭의 내용에 해당하는 요소는 이미 HTML에서 active 클래스로 표시되어 있어야 합니다.

        // 탭 버튼 클릭 이벤트
        $(".tab_faq button").click(function() {
            // 모든 버튼에서 'active' 클래스 제거
            $(".tab_faq button").removeClass('active');
            // 클릭된 버튼에만 'active' 클래스 추가
            $(this).addClass('active');

            // 클릭된 버튼의 data-target 속성 값과 일치하는 id를 가진 섹션만 표시
            var targetId = "#" + $(this).data("target");
            // 모든 컨텐츠 섹션을 숨깁니다.
            $(".faq_content").addClass('hidden');
            // 해당하는 컨텐츠 섹션만 보여줍니다.
            $(targetId).removeClass('hidden');
        });
    
        $(".accordion-header").click(function() {
            // 클릭된 항목의 바디를 토글합니다.
            var $body = $(this).next(".accordion-body");
            $body.slideToggle(200);

            // 선택적: 클릭된 헤더와 같은 아코디언 그룹 내의 다른 모든 바디를 닫습니다.
            $(this).closest('.accordion').find(".accordion-body").not($body).slideUp(200);
        });
    
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

        $('.guide_list a').click(function() {
            // 클릭된 항목의 data-target 값 가져오기
            var targetId = $(this).data('target');

            // 모든 가이드 내용 숨기기
            $('.guide_con').hide();

            // 해당하는 ID를 가진 가이드 내용만 보여주기
            $('#' + targetId).show();
        });
    });
 
 </script>

@endsection