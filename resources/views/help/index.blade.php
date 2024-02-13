@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
<div id="container" class="container">
    <div class="service">
        <div class="inner">
            <div class="section">
                <div class="section__head">
                    <h3 class="section__title">
                        <p>고객센터</p>
                    </h3>
                </div>
                <div class="service__top">
                    <div class="service__title">
                        <div class="service__slogan">궁금한 내용이 있으신가요?</div>
                        <h2>031-813-5588</h2>
                        <div class="service__desc">운영시간<strong>평일 09:00 - 18:00</strong></div>
                    </div>
                    <div class="service__top-wrap">
                        <a href="javascript:void(0);" onclick="openModal('#guide-modal');" class="button button--etc top-button">올펀 이용 가이드</a>
                        <a href="/help/inquiry" class="button button--etc top-button">1:1 문의</a>
                    </div>
                </div>
                <div class="inner__category">
                    <div class="sub-category">
                        <p class="sub-category__item {{ $pageType === 'faq' ? 'sub-category__item--active' : '' }}"><a href="/help/faq">자주 묻는 질문</a></p>
                        <p class="sub-category__item {{ $pageType === 'notice' ? 'sub-category__item--active' : '' }}"><a href="/help/notice">공지사항</a></p>
                    </div>
                </div>
            </div>

            {{--- include body ---}}
            @include('help.'.$pageType)
        </div>

    </div>
</div>
<div id="guide-modal" class="default-modal">
    <div class="default-modal__container">
        <div class="default-modal__header">
            <h2>이용 가이드</h2>
            <button type="button" class="ico__close28" onclick="closeModal('#guide-modal')">
                <span class="a11y">닫기</span>
            </button>
        </div>
        <div class="default-modal__content">
            <!-- 20221110 s -->
            <div class="guide-modal__content">
                <div id="allfurn-guide">
                    <div class="textfield">
                        <div class="dropdown text--gray">
                            <p class="dropdown__title">이용가이드</p>
                            <div class="dropdown__wrap">
                                <a href="#" class="dropdown__item" data-name="guide-01">
                                    <span>상품 주문하기</span>
                                </a>
                                <a href="#" class="dropdown__item" data-name="guide-02">
                                    <span>장바구니</span>
                                </a>
                                <a href="#" class="dropdown__item" data-name="guide-03">
                                    <span>관심 상품 폴더 관리</span>
                                </a>
                                <a href="#" class="dropdown__item" data-name="guide-04">
                                    <span>상품 찾기</span>
                                </a>
                                <a href="#" class="dropdown__item" data-name="guide-05">
                                    <span>상품 문의</span>
                                </a>
                                <a href="#" class="dropdown__item" data-name="guide-06">
                                    <span>업체 찾기</span>
                                </a>
                                <a href="#" class="dropdown__item" data-name="guide-07">
                                    <span>업체 문의</span>
                                </a>
                                <a href="#" class="dropdown__item" data-name="guide-08">
                                    <span>상품 등록</span>
                                </a>
                                <a href="#" class="dropdown__item" data-name="guide-09">
                                    <span>상품 관리</span>
                                </a>
                                <a href="#" class="dropdown__item" data-name="guide-10">
                                    <span>업체 관리</span>
                                </a>
                                <a href="#" class="dropdown__item" data-name="guide-11">
                                    <span>커뮤니티 활동</span>
                                </a>
                                <a href="#" class="dropdown__item" data-name="guide-12">
                                    <span>거래 관리</span>
                                </a>
                                <a href="#" class="dropdown__item" data-name="guide-13">
                                    <span>주문 관리</span>
                                </a>
                                <a href="#" class="dropdown__item" data-name="guide-14">
                                    <span>내 정보 수정</span>
                                </a>
                                <a href="#" class="dropdown__item" data-name="guide-15">
                                    <span>직원 계정 추가</span>
                                </a>
                                <a href="#" class="dropdown__item" data-name="guide-16">
                                    <span>정회원 승격 요청</span>
                                </a>
                                <a href="#" class="dropdown__item" data-name="guide-17">
                                    <span>올펀 문의하기</span>
                                </a>
                                <a href="#" class="dropdown__item" data-name="guide-18">
                                    <span>기타 회원 권한</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <section>
                        <div>
                            <h2><p>상품 주문하기</p></h2>
                            <div class="guidance" data-name="guide-01" aria-hidden="false">
                                <ul class="desc">
                                    <li>상품 상세 화면에서 상품을 바로 주문하거나 장바구니<br>에서 여러 업체의 상품을 한 번에 주문하실 수 있습니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance01-1.png" /></div>
                                        <div class="text"><span>1</span><b>[주문하기]</b> 버튼을 누르시면 하단에서 <br>옵션 선택 영역이 노출됩니다.</div>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance01-2.png" /></div>
                                        <div class="text"><span>2</span>상품마다 상이한 필수/선택 옵션을 선택합니다.</div>
                                        <div class="text"><span>3</span>선택한 옵션과 주문 금액을 확인하고 <br><b>[바로 주문]</b> 버튼을 눌러주세요.</div>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance01-3.png" /></div>
                                        <div class="text"><span>4</span>주문자 정보, 배송지 정보, 주문 정보를 확인하신 후 <br>하단의 <b>[주문 완료]</b> 버튼을 눌러주세요.</div>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance01-4.png" /></div>
                                        <div class="text"><span>5</span><b>[주문 현황 보기]</b>로 주문 현황을 바로 확인하거나 <br><b>[쇼핑 계속하기]</b>로 다른 상품을 구경하실 수 있습니다.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-02" aria-hidden="true">
                                <ul class="desc">
                                    <li>홈, 상품 상세, 업체 상세, 카테고리, 마이올펀 화면 <br>우측 상단에 있는 장바구니 아이콘을 누르면 장바구니 <br>화면으로 이동합니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance02-1.png" /></div>
                                        <div class="text"><span>1</span><b>[업체 보러가기]</b>를 통해 장바구니에 담은 상품의 판매 업체 <br>상세 화면을 확인하실 수 있습니다.</div>
                                        <div class="text"><span>2</span>상품별로 옵션 및 수량 변경과 바로 주문, 삭제가 가능합니다.</div>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance02-2.png" /></div>
                                        <div class="text"><span>3</span>선택된 상품의 총주문 금액과 개수를 확인하고 <br>하단의 <b>[상품 주문하기]</b> 버튼으로 주문을 진행해주세요.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-03" aria-hidden="true">
                                <ul class="desc">
                                    <li>상품 리스트나 상품 상세 화면에서 북마크 아이콘을 <br>누르면 나의 관심 상품으로 설정됩니다.</li>
                                    <li>관심 상품 리스트는 하단 내비게이션 바의 [마이올펀] > <br>관심 상품 메뉴에서 확인하실 수 있습니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance03-1.png" /></div>
                                        <div class="text"><span>1</span>우측 상단 <b>[폴더 관리]</b> 버튼을 누르면 폴더를 추가하거나 폴더명을 변경하실 수 있습니다.</div>
                                        <div class="text"><span>2</span>화면 중간 <b>[편집]</b> 버튼을 누르면 각 상품에 체크박스가 표시되며 상품을 원하는 폴더로 이동시키거나 삭제시킬 수 있습니다.</div>
                                        <ul class="text">
                                            <li class="text"><span>A</span>이동시키고 싶은 상품을 체크 선택해주세요.</li>
                                            <li class="text"><span>B</span><b>[폴더 이동]</b> 버튼을 누르면 하단에서 노출되는 폴더 리스트에서 이동시킬 폴더를 선택합니다.</li>
                                        </ul>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance03-2.png" /></div>
                                        <div class="text"><span>3</span>폴더 편집이 끝난 뒤 <b>[완료]</b> 버튼을 누르면 <br>편집 상태가 종료됩니다.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-04" aria-hidden="true">
                                <ul class="desc">
                                    <li>하단 내비게이션 바의 [홈]이나 [카테고리]에서 상품을 <br>찾아보실 수 있습니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance04-1.png" /></div>
                                        <div class="tag">검색</div>
                                        <div class="text"><span>1</span>상단 검색 바에서 검색할 상품명이나 상품의 속성을 <br>입력해주세요.</div>
                                        <div class="text"><span>2</span>띄어쓰기나 영문, 숫자가 포함된 검색어는 동일하게 입력해야 <br>검색 결과에 반영됩니다.</div>
                                        <div class="text"><span>3</span>검색 후 검색 결과에 해당되는 상품은 좌측 상품 탭에서 <br>확인하실 수 있습니다.</div>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance04-2.png" /></div>
                                        <div class="tag">카테고리</div>
                                        <div class="text"><span>1</span>찾고자 하는 상품의 카테고리를 선택해주세요.</div>
                                        <div class="text"><span>2</span>대분류 카테고리에 포함된 중분류 카테고리를 <br>선택해주시면 세분화된 상품 결과를 확인하실 수 있습니다.</div>
                                        <div class="text"><span>3</span>중분류 선택 시 노출되는 속성 필터로 더욱 세분화된 상품 <br>결과를 확인해보세요.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-05" aria-hidden="true">
                                <ul class="desc">
                                    <li>상품 상세 화면에서 [전화], [문의] 버튼으로 상품에 <br>관해 문의하실 수 있습니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance05-1.png" /></div>
                                        <div class="text"><span>1</span><b>[전화]</b> 버튼을 누르시면 판매 업체의 대표 번호로 <br>전화가 연결됩니다.</div>
                                        <div class="text"><span>2</span><b>[문의]</b> 버튼을 누르시면 판매 업체와 1:1 메세지 <br>화면으로 이동합니다.</div>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance05-2.png" /></div>
                                        <div class="text"><span>3</span>메세지 입력창 위 노출되는 상품명으로 문의할 <br>상품이 맞는지 확인해주세요.</div>
                                        <div class="text"><span>4</span>자동 입력된 메세지를 바로 전송하거나 수정하여 <br>상품을 문의하실 수 있습니다.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-06" aria-hidden="true">
                                <ul class="desc">
                                    <li>하단 내비게이션 바의 [홈]에서 업체를 검색해보실 수 <br>있습니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance06-1.png" /></div>
                                        <div class="text"><span>1</span>상단 검색 바에서 검색할 업체명이나 업체 <br>대표자명을 입력해주세요.</div>
                                        <div class="text"><span>2</span>띄어쓰기나 영문, 숫자가 포함된 검색어는 <br>동일하게 입력해야 검색 결과에 반영됩니다.</div>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance06-2.png" /></div>
                                        <div class="text"><span>3</span>검색 후 검색 결과에 해당되는 업체는 우측 <br>업체탭에서 확인하실 수 있습니다.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-07" aria-hidden="true">
                                <ul class="desc">
                                    <li>하단 내비게이션 바의 [홈]에서 업체를 검색해보실 수 있습니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance07-1.png" /></div>
                                        <div class="text"><span>1</span><b>[전화]</b> 버튼을 누르시면 업체의 대표 번호로 <br>전화가 연결됩니다.</div>
                                        <div class="text"><span>2</span><b>[문의]</b> 버튼을 누르시면 업체와 1:1 메세지 <br>화면으로 이동합니다.</div>
                                        <div class="text"><span>3</span>생성된 메세지 화면에서 자유롭게 문의해주세요.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-08" aria-hidden="true">
                                <ul class="desc">
                                    <li>하단 내비게이션 바 [홈]에서 도매 정회원에게만 <br>노출되는 우측 하단 [+] 플로팅 버튼을 눌러 상품을 <br>등록해주세요.</li>
                                    <li>상품을 5개 이상 등록해야 도매 업체 리스트에 업체가 <br>노출됩니다.</li>
                                    <li>모바일앱에서는 상품명과 카테고리만 입력하시면 임시 <br>저장됩니다. 등록 중인 상품은 하단 내비게이션 바의 <br>[마이올펀] > 상품 관리 > 임시 등록 탭에서 확인하실 <br>수 있습니다.</li>
                                    <li>모바일앱에서는 상품의 임시 등록만 가능하며 상품 <br>등록 신청은 데스크탑 웹에서만 가능합니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance08-1.png" /></div>
                                        <div class="text"><span>1</span><b>[+]</b> 버튼을 누르시면 상품 등록 화면이 노출됩니다.</div>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance08-2.png" /></div>
                                        <div class="text"><span>2</span><b>[이전]</b> 버튼은 이전 화면으로 이동, [다음] 버튼은 다음 단계 <br>화면으로 이동합니다. <b>[다음]</b> 버튼에는 현재 등록 중인 단계가 <br>표기됩니다.</div>
                                        <div class="text"><span>3</span><b>[미리 보기]</b> 버튼으로 등록한 상품 정보가 어떻게 보이는지 <br>확인하실 수 있습니다.</div>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance08-3.png" /></div>
                                        <div class="tag">상품 기본 정보</div>
                                        <ul class="desc">
                                            <li>등록하는 상품의 상품명, 이미지, 카테고리, 가격, 가격 노출 여부, <br>결제 방식, 상품 코드, 배송 방법, 추가 공지, 인증 정보, <br>상세 내용을 입력합니다.</li>
                                            <li>상품의 성격에 맞는 카테고리 대분류와 중분류를 선택해주세요.</li>
                                            <li>상품 속성은 등록하는 상품의 사양에 맞는 항목을 모두<br>선택해주세요.</li>
                                            <li>입력한 상품 가격의 노출 여부를 선택해주시고 미 노출인 경우, <br>가격 대신 노출할 안내 문구를 선택해주시면 됩니다.</li>
                                            <li>결제 방식은 상품별 1개의 방식만 선택하거나 직접 입력하실 수<br>있습니다.</li>
                                            <li>상품 코드를 입력하시면 상품 분별을 위해 자체적으로<br>사용하고 있는 코드로 서비스 내에서도 상품 관리에<br>활용하실 수 있습니다.</li>
                                            <li>배송 방법은 상품별 총 6개까지 추가 가능합니다.</li>
                                            <li class="sub"><b>[배송 방법 추가]</b> 버튼을 누르고 노출되는 화면에서 <br>배송 방법을 선택해주세요.</li>
                                            <li class="sub">배송 방법 선택 혹은 직접 입력 후, 해당 배송의 가격을 <br>무료/착불 중에 선택해주세요.</li>
                                            <li class="sub"><b>[추가하기]</b> 버튼을 누르면 배송 방법이 추가됩니다.</li>
                                            <li>상품 등록 시 입력한 항목 외에도 추가로 공지하고 싶은 사항이 <br>있다면 ‘상품 추가 공지’ 항목에 자유롭게 입력해주시면 됩니다.</li>
                                            <li><b>[인증 정보 선택]</b> 버튼을 누르고 등록 상품에 해당되는 <br>인증 정보를 모두 선택해주세요.</li>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance08-4.png" /></div>
                                        <div class="tag">상품 상세 내용</div>
                                        <ul class="desc">
                                            <li>상품 상세 화면에서 상품 정보로 보여지는 영역으로, <br>자유롭게 입력하실 수 있습니다.</li>
                                            <li>서체 편집, 텍스트 맞춤, 링크 삽입, 이미지 첨부가 가능합니다. <br>데스크탑 웹에서는 더 상세한 기능을 사용하실 수 있습니다.</li>
                                            <li>상품이 돋보일 수 있는 설명과 이미지로 구성해주시면 됩니다.</li>
                                        </ul>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance08-5.png" /></div>
                                        <div class="tag">상품 주문 옵션</div>
                                        <ul class="desc">
                                            <li>옵션값의 가격은 주문 시 고객이 상품의 해당 옵션을 선택하는 <br>경우, 상품 가격에 옵션값 가격만큼 추가됩니다.</li>
                                            <li>옵션값의 가격을 입력하지 않은 경우, 해당 옵션값의 가격은 <br>0원으로 설정됩니다.</li>
                                        </ul>
                                        <div class="text"><span>1</span><b>[주문 옵션 추가]</b> 버튼을 눌러 옵션을 추가합니다.</div>
                                        <div class="text"><span>2</span>필수 옵션 여부를 설정하고 옵션 명과 옵션값을 입력합니다.</div>
                                        <div class="text"><span>3</span><b>[옵션값 추가]</b> 버튼으로 옵션값을 추가합니다.</div>
                                        <div class="text"><span>4</span>추가한 옵션이 2개 이상인 경우, <b>[옵션 순서 변경]</b> 버튼이 활성화되며 옵션의 순서를 변경하실 수 있습니다.</div>
                                        <ul class="text">
                                            <li class="text"><span>A</span>좌측의 순서 변경 아이콘을 드래그하여 순서를 변경해주세요.</li>
                                            <li class="text"><span>B</span><b>[변경 완료]</b> 버튼을 눌러야 변경된 순서가 반영됩니다.</li>
                                        </ul>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance08-6.png" /></div>
                                        <div class="tag">상품 주문 정보</div>
                                        <ul class="desc">
                                            <li><b>[설정]</b> 버튼을 누르고 등록 상품의 결제, 배송, 교환/반품/취소<br>관련한 정보를 입력해주세요.</li>
                                            <li>추가로 주문 관련하여 입력할 정보가 있다면 <br>‘주문 정보 직접 입력’ 항목의 <b>[설정]</b> 버튼을 누르고 항목 제목과 <br>내용을 직접 입력해주세요.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-09" aria-hidden="true">
                                <ul class="desc">
                                    <li>상품 상세 화면에서 <b>[전화], [문의]</b> 버튼으로 상품에 <br>관해 문의하실 수 있습니다.</li>
                                    <li>상품 관리 화면에는 등록 신청이 완료된 상품은 등록 <br>탭에서, 임시 등록된 상품은 임시 등록 탭에서 <br>확인하실 수 있습니다.</li>
                                    <li>‘승인 대기’와 ‘반려’, 관리자에 의한 ‘판매 중지’ <br>상태에는 상품의 상태 변경이 불가합니다.</li>
                                    <li>‘승인 대기’와 관리자에 의한 ‘판매 중지’ 상태에는 <br>상품의 수정이 불가합니다.</li>
                                    <li>거래 중인 상품의 경우, 상태 변경과 정보 수정을 <br>주의해주세요.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance09-1.png" /></div>
                                        <div class="tag">추천 상품 설정</div>
                                        <ul class="desc">
                                            <li>설정하신 추천 상품은 업체 상세 화면과 판매 상품 상세의 <br>하단에 노출됩니다.</li>
                                            <li>‘판매 중’ 상태의 상품 우측에 있는 별 아이콘을 누르시면 추천 <br>상품으로 설정되거나 해지됩니다.</li>
                                            <li>추천 상품으로 설정되어있는 상품은 상태 변경이 불가합니다.</li>
                                        </ul>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance09-2.png" /></div>
                                        <div class="tag">상품 상태 변경 및 수정</div>
                                        <ul class="desc">
                                            <li><b>[상태 변경]</b> 버튼을 누르면 노출되는 리스트에서 변경시킬 <br>상태를 선택해주세요. </li>
                                            <li>등록 탭에 있는 <b>[수정]</b> 버튼을 누르면 상품 수정 화면으로 <br>이동되며, 임시 등록 탭의 <b>[수정]</b> 버튼을 누르면 상품 등록 중인 <br>화면으로 이동됩니다.</li>
                                            <li>상품명을 누르시면 노출되는 미리보기 화면에서 하단의 <br><b>[상품 삭제]</b> 버튼으로 상품을 삭제하실 수 있습니다.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-10" aria-hidden="true">
                                <ul class="desc">
                                    <li>하단 내비게이션 바의 [마이올펀] > 업체 관리 메뉴에서 <br>업체 상세 정보를 관리하실 수 있습니다.</li>
                                    <li>도매 정회원의 경우, 최초 로그인 시 업체 관리 화면으로 <br>이동됩니다.</li>
                                    <li>업체 소개나 정보를 입력하시고 상품을 5개 이상 등록<br>해야 도매 업체 리스트에 업체가 노출됩니다.</li>
                                    <li>업체 정보는 입력하신 항목만 업체 상세 화면에 <br>노출됩니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance10-1.png" /></div>
                                        <div class="text"><span>1</span>업체명 좌측에 있는 <i class="ico__camera"></i> 카메라 아이콘을 눌러 <br>업체 로고 이미지를 업로드해주세요.</div>
                                        <div class="text"><span>2</span><b>[문의]</b> 버튼을 누르시면 업체와 1:1 메세지 <br>화면으로 이동합니다.</div>
                                        <div class="text"><span>3</span>생성된 메세지 화면에서 자유롭게 문의해주세요.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-11" aria-hidden="true">
                                <ul class="desc">
                                    <li>우측 상단의 사람 아이콘을 눌러 커뮤니티 내 나의 활동 <br>사항을 확인하실 수 있습니다.</li>
                                    <li>우측 하단 펜 모양의 플로팅 버튼을 눌러 게시글을 <br>작성해주세요.</li>
                                    <li>비즈니스 게시판을 구독하시면 새 게시글 알림을 받아<br>보실 수 있습니다. [구독하기] 버튼을 통해 구독을 <br>설정/해지하실 수 있습니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance11-1.png" /></div>
                                        <div class="tag">내 활동</div>
                                        <ul class="desc">
                                            <li>작성한 게시글, 댓글 및 답글, 좋아요한 게시글을<br>확인하실 수 있습니다.</li>
                                            <li>내가 작성한 게시글, 댓글 및 답글만 삭제하실 수 있습니다.</li>
                                            <li>관리자에 의해 작성한 게시글이 숨김 처리될 수 있습니다. <br>관리자 문의는 마이올펀 > 고객센터 > 1:1 문의를 <br>이용해주세요.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-12" aria-hidden="true">
                                <ul class="desc">
                                    <li>하단 내비게이션 바의 [마이올펀] > 거래 현황 <br>메뉴에서 상품별, 업체별 탭으로 거래 현황을 <br>확인하실 수 있습니다.</li>
                                    <li>거래 상태에 따라 변경되는 버튼을 클릭하여 거래를 <br>관리해주세요.</li>
                                    <li>거래 취소는 거래 확정 전에만 가능하며, 상품별 혹은 <br>전체 거래 취소가 가능합니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance12-1.png" /></div>
                                        <div class="row">
                                            <p><strong class="status status--solid">신규 주문</strong></p>
                                            <div class="text">주문이 새로 들어온 상태로, 주문을 진행하려면 <br>[거래 확정] 버튼을 누르고 상품을 준비해주세요.</div>
                                        </div>
                                        <div class="row">
                                            <p><strong class="status status--solid">상품 준비 중</strong></p>
                                            <div class="text">거래 확정 이후, 발송하기 전 단계입니다. <br>준비가 완료되었다면 [배차 신청] 버튼으로 <br>배차를 신청하거나 [발송] 버튼을 누르고 <br>상품을 발송해주세요.</div>
                                        </div>
                                        <div class="row">
                                            <p><strong class="status status--solid">발송 중</strong></p>
                                            <div class="text">발송 이후, 거래 완료 전 단계입니다. 발송이 <br>완료되었다면 [발송 완료] 버튼을 눌러주세요. <br>구매자에게 구매 확정 요청이 전달됩니다.</div>
                                        </div>
                                    </div>
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance12-2.png" /></div>
                                        <div class="row">
                                            <p><strong class="status status--trans">구매 확정 대기</strong></p>
                                            <div class="text">발송 완료 이후, 구매 확정 대기 상태입니다. <br>구매자가 구매 확정을 진행해야 거래가 완료됩니다.</div>
                                        </div>
                                        <div class="row">
                                            <p><strong class="status status--black">거래 완료</strong></p>
                                            <div class="text">구매자가 구매 확정을 진행하여 거래가 <br>완료된  상태입니다.</div>
                                        </div>
                                        <div class="row">
                                            <p><strong class="status status--gray">거래 취소</strong></p>
                                            <div class="text">거래 확정 전, 전체 거래가 취소된 경우 <br>‘거래 취소’로 상태가 표기됩니다.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-13" aria-hidden="true">
                                <ul class="desc">
                                    <li>하단 내비게이션 바의 [마이올펀] > 주문 현황 메뉴에서 <br>주문 현황을 확인하실 수 있습니다.</li>
                                    <li>판매자의 거래 관리에 따라 주문 상태가 변경됩니다.</li>
                                    <li>주문 취소는 거래 확정 전까지만 가능하며, 상품별 혹은 <br>전체 주문 취소가 가능합니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance13-1.png" /></div>
                                        <div class="row">
                                            <p><strong class="status status--trans">구매 확정 대기</strong></p>
                                            <div class="text">발송이 완료되었다면 <b>[구매 확정]</b> 버튼을 <br>눌러주세요. 거래가 완료됩니다.</div>
                                        </div>
                                        <div class="row">
                                            <p><strong class="status status--gray">주문 취소</strong></p>
                                            <div class="text">거래 확정 전, 전체 거래가 취소된 경우 <br>‘거래 취소’로 상태가 표기됩니다.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-14" aria-hidden="true">
                                <ul class="desc">
                                    <li>하단 내비게이션 바의 [마이올펀] > 계정 관리 메뉴에서 <br>내 정보를 수정하실 수 있습니다.</li>
                                    <li>사업자 등록 번호, 업체명, 대표자명은 고객센터 문의를 <br>통해 변경 요청해주세요.</li>
                                    <li>휴대폰 번호와 사업자 주소는 직접 수정이 가능합니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance14-1.png" /></div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-15" aria-hidden="true">
                                <ul class="desc">
                                    <li>하단 내비게이션 바의 [마이올펀] > 계정 관리 메뉴에서 <br>직원 계정을 추가하실 수 있습니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance15-1.png" /></div>
                                        <div class="text"><span>1</span>하단의 <b>[계정 추가]</b> 버튼을 눌러주세요.</div>
                                        <div class="text"><span>2</span>이름, 휴대폰 번호, 아이디, 비밀번호를 입력하고 <br><b>[완료]</b> 버튼을 눌러주세요.</div>
                                        <div class="text"><span>3</span>최대 5명까지 추가 가능하며, 생성한 직원 계정의 <br>아이디와 비밀번호는 직접 공유해주시면 됩니다.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-16" aria-hidden="true">
                                <ul class="desc">
                                    <li>하단 내비게이션 바의 [마이올펀] > 계정 관리 메뉴에서 <br>정회원 승격을 요청하실 수 있습니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance16-1.png" /></div>
                                        <div class="text"><span>1</span>하단의 <b>[정회원 승격 요청]</b> 버튼을 눌러주세요. </div>
                                        <div class="text"><span>2</span>활동하고자 하는 정회원 구분을 선택해주세요.</div>
                                        <div class="text"><span>3</span>정회원 승격에 필요한 회원 정보를 입력해주세요. </div>
                                        <div class="text"><span>4</span>정회원 승격 요청 완료 후, 승인 문자를 확인하고 <br>동일한 이메일로 로그인해주시면 됩니다.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-17" aria-hidden="true">
                                <ul class="desc">
                                    <li>하단 내비게이션 바의 [마이올펀] > 계정 관리 메뉴에서 <br>정회원 승격을 요청하실 수 있습니다.</li>
                                </ul>
                                <div class="list">
                                    <div class="listitem">
                                        <div class="image"><img src="/images/guidance/guidance17-1.png" /></div>
                                        <div class="text"><span>1</span>고객센터 <b>[1:1 문의하기]</b> 버튼을 눌러주세요.</div>
                                        <div class="text"><span>2</span>문의 유형을 선택해주시고 문의할 내용을 입력해주세요.</div>
                                        <div class="text"><span>3</span>하단 <b>[문의하기]</b> 버튼을 눌러 문의를 완료해주세요.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="guidance" data-name="guide-18" aria-hidden="true">
                                <ul class="desc">
                                    <li>해당 이용 가이드는 정회원 도매 기준으로 작성된 <br>것으로, 정회원 소매 및 일반 회원의 기능과 다르거나 <br>권한이 없을 수 있습니다.</li>
                                    <li>상품 등록 및 관리, 거래 기능은 도매 회원만 사용 <br>가능합니다.</li>
                                    <li>일반 회원의 경우, 사업자 미등록으로 도소매 플랫폼 <br>특성상 주문이나 문의 관련 기능에 제약이 있습니다. <br>정상적인 올펀 서비스 이용을 원하시면 하단 <br>내비게이션 바의 [마이올펀] > 계정 관리에서 정회원 승격 <br>요청을 진행해주세요.</li>
                                </ul>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <!-- 20221110 e -->
        </div>
        <div class="default-modal__footer"></div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        $( function() {
            var icons = {
                header: "ico__arrow--down24",
                activeHeader: "ico__arrow--up24"
            };
            $( ".accordion" ).accordion({
                header: ".accordion__head",
                icons: icons,
                collapsible: true,
                animate: 0
            });
            $( ".list .accordion" ).accordion({
                icons: false,
            });
        });

        $('.dropdown__item').on('click', function () {
            $('.dropdown__title').css('color', '#1B1B1B');
        })

        if ($('#allfurn-guide')) {
            let dataname;
            let title;
            $('.dropdown__item').on('click', function () {
                dataname = $(this).attr('data-name');
                title = $(this).text().trim(" ").split("\n")[0];
                $('#allfurn-guide section').scrollTop(0);
                $('section').find('h2 p').text(title);
                $('section').find('.guidance').attr('aria-hidden', 'true');
                $('section').find(`.guidance[data-name="${dataname}"]`).attr('aria-hidden', 'false');
            })
        }

        const moveToList = page => {
            let bodies = {offset:page};
            const urlSearch = new URLSearchParams(location.search);
            if (urlSearch.get('category_idx')) bodies.category_idx = urlSearch.get('category_idx');
            location.replace(location.pathname + "?" + new URLSearchParams(bodies));
        }
    </script>
@endpush
