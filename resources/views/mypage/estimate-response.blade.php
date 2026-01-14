<div class="w-full">
    <div class="flex">
        <a href="/mypage/estimateInfo" class="text-xl text-primary font-bold grow border-b-2 border-primary pb-5 text-center">견적서 관리</a>
        <a href="/mypage/responseEstimateMulti" class="text-stone-400 text-xl font-bold grow text-center">견적서 보내기</a>
    </div>           
    <hr>
    <a href="/mypage/responseEstimate" class="flex items-center gpa-3 mt-8">
        <p class="font-bold">요청받은 견적서 현황</p>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
    </a>
    <div class="st_box w-full flex items-center gap-2.5 px-5 mt-3">
        <a href="/mypage/responseEstimate?status=N" class="flex gap-5 justify-center items-center flex-1">
            <p class="text-sm">요청받은 견적</p>
            <p class="text-sm main_color font-bold">{{ $info[0] -> count_res_n }}</p>
        </a>
        <p class="line h-full"></p>
        <a href="/mypage/responseEstimate?status=R" class="flex gap-5 justify-center items-center flex-1">
            <p class="text-sm">보낸 견적</p>
            <p class="text-sm font-bold">{{ $info[0] -> count_res_r }}</p>
        </a>
        <p class="line h-full"></p>
        <a href="/mypage/responseEstimate?status=O" class="flex gap-5 justify-center items-center flex-1">
            <p class="text-sm">주문서 수</p>
            <p class="text-sm main_color font-bold">{{ $info[0] -> count_res_o }}</p>
        </a>
        <p class="line h-full"></p>
        <a href="/mypage/responseEstimate?status=F" class="flex gap-5 justify-center items-center flex-1">
            <p class="text-sm">확인/완료</p>
            <p class="text-sm font-bold">{{ $info[0] -> count_res_f }}</p>
        </a>
    </div>
    <div class="my_filterbox flex w-full gap-2.5 mt-5 mb-7">
        <div>
            <a id="selectedKeywordType" class="filter_border filter_dropdown w-[170px] h-full flex justify-between items-center" data-keyword-type="{{ request() -> get('keywordType') }}">
                <p>{{ $keywordTypeText }}</p>
                <svg class="w-6 h-6 filter_arrow"><use xlink:href="/img/icon-defs.svg#drop_b_arrow"></use></svg>
            </a>
            <div class="filter_dropdown_wrap w-[170px]">
                <ul>
                    <li>
                        <a href="javascript: void(0);" class="flex items-center" data-type="">전체</a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="flex items-center" data-type="estimateCode">견적번호</a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="flex items-center" data-type="productName">상품명</a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="flex items-center" data-type="companyName">구매 업체</a> 
                    </li>
                </ul>
            </div>
        </div>
        <div class="filter_border flex items-center w-full">
            <svg class="w-6 h-6" class="filter_arrow"><use xlink:href="/img/icon-defs.svg#Search"></use></svg>
            <input type="search" name="keyword" id="keyword" class="ml-3 w-full" value="{{ request() -> get('keyword') }}" placeholder="검색어를 입력해주세요." />
        </div>
        <div class="flex filter_calendar filter_border w-[270px] h-full items-center justify-between shrink-0">
            <input type="text" name="responseDate" id="responseDate" class="cursor_default w-full h-full" value="{{ request() -> get('responseDate') }}" placeholder="전체 기간" readOnly />
            <svg class="w-5 h-5 cursor-pointer" onClick="openCalendar();"><use xlink:href="/img/icon-defs.svg#Calendar"></use></svg>
        </div>
    </div>

    @if ($response['count'] >= 1)
    <div>
        전체 <span>{{ $response['count'] }}개</span>
    </div>
    @endif

    <div class="mt-4">
        @if ($response['count'] < 1)
        <ul>
            <li class="no_prod txt-gray">
                데이터가 존재하지 않습니다. 다시 조회해주세요.
            </li>
        </ul>
        @else
        <table class="my_table table-auto w-full">
            <thead>
                <th>No</th>
                <th>견적번호</th>
                <th>견적일자<br />(요청일자)</th>
                <th>견적 상태</th>
                <th>견적 상품</th>
                <th>구매 업체</th>
                <th>관리</th>
            </thead>
            <tbody class="text-center">
                @foreach($response['list'] as $list)
                <tr>
                    <td>{{ $response['count'] - $loop -> index - (($offset - 1) * $limit) }}</td>
                    <td>{{ $list -> estimate_code }}</td>
                    <td>{{ $list -> response_time ? $list -> response_time : '('.$list -> request_time.')' }}</td>
                    <td>
                        @if ($list -> estimate_state == 'F' && $list -> order_state == 'X')
                            주문 보류
                        @else
                            {{ config('constants.ESTIMATE.STATUS.RES')[$list -> estimate_state] }}
                        @endif
                    </td>
                    <td><a href="/product/detail/{{ $list -> product_idx }}" class="text-sky-500 underline" onclick="">{{ $list -> name }}</a>{{ $list -> cnt >= 1 ? '외 '.$list -> cnt.'개' : ''}}</td>
                    <td>{{ $list -> request_company_name }}</td>
                    <td>
                        @if ($list -> estimate_state == 'N')
                        <button class="btn outline_primary btn-h-auto request_estimate_detail" data-idx="{{ $list -> estimate_idx }}" data-group_code="{{ $list -> estimate_group_code }}" data-code="{{ $list -> estimate_code }}" data-response_company_type="{{ $response['response_company_type'] }}">견적 요청서 확인</button>
                        @elseif ($list -> estimate_state == 'R' || $list -> estimate_state == 'H')
                        <button class="btn outline_primary btn-h-auto check_estimate_detail" data-idx="{{ $list -> estimate_idx }}" data-group_code="{{ $list -> estimate_group_code }}" data-code="{{ $list -> estimate_code }}" data-response_company_type="{{ $response['response_company_type'] }}">견적서 확인</button>
                        @elseif ($list -> estimate_state == 'O' || $list -> estimate_state == 'F')
                        <button class="btn outline_primary btn-h-auto check_order_detail" data-code="{{ $list -> estimate_code }}" data-group_code="{{ $list -> estimate_group_code }}" data-state="{{ $list -> estimate_state }}">주문서 확인</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagenation flex items-center justify-center py-12">
            @if (($response['pagination'])['prev'] > 0)
            <button type="button" class="prev" onclick="moveToEstimatePage({{ ($response['pagination'])['prev'] }})">
                <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 1L1 6L6 11" stroke="#DBDBDB" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            @endif
            @foreach (($response['pagination'])['pages'] as $paginate)
                @if ($paginate == $response['offset'])
                <a href="javascript: void(0)" class="active" onclick="moveToEstimatePage({{ $paginate }})">{{ $paginate }}</a>
                @else
                <a href="javascript: void(0)" onclick="moveToEstimatePage({{ $paginate }})">{{ $paginate }}</a>
                @endif
            @endforeach
            @if (($response['pagination'])['next'] > 0)
            <button type="button" class="next" onclick="moveToEstimatePage({{ ($response['pagination'])['next'] }})">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12L10 7L5 2" stroke="#828282" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            @endif
        </div>
        @endif
    </div>
</div>

<!-- 견적요청서 확인 및 작성 -->
<div class="modal" id="request_confirm_write-modal">
    <div class="modal_bg" onclick="modalClose('#request_confirm_write-modal')"></div>
    <div class="modal_inner new-modal">
        <div class="modal_header">
            <h3>견적 요청서 확인 및 작성</h3>
            <button class="close_btn" onclick="modalClose('#request_confirm_write-modal')"><img src="./img/icon/x_icon.svg" alt=""></button>
        </div>

        <div class="modal_body">
            <!-- // -->
        </div>

        <div class="modal_footer">
            <button class="close_btn" onclick="modalClose('#request_confirm_write-modal')">견적보류 닫기</button>
            <button type="button" onClick="updateResponse();">견적서 완료하기 <img src="/img/icon/arrow-right.svg" alt=""></button>
        </div>
    </div>
</div>

<!-- 견적서 확인하기 -->
<div class="modal" id="check_estimate-modal">
	<div class="modal_bg" onclick="modalClose('#check_estimate-modal')"></div>
	<div class="modal_inner new-modal">
        <div class="modal_header">
            <h3>보낸 견적서</h3>
            <button class="close_btn" onclick="modalClose('#check_estimate-modal')"><img src="/img/icon/x_icon.svg" alt=""></button>
        </div>
		<div class="modal_body">
            
		</div>

        <div class="modal_footer">
            <button type="button" onclick="modalClose('#check_estimate-modal')">닫기</button>
        </div>
    </div>
</div>

<!-- 주문서 확인하기 -->
<div class="modal" id="check_order-modal">
    <div class="modal_bg" onclick="modalClose('#check_order-modal')"></div>
    <div class="modal_inner new-modal">
        <div class="modal_header">
            <h3>주문서</h3>
            <button class="close_btn" onclick="modalClose('#check_order-modal')"><img src="/img/icon/x_icon.svg" alt=""></button>
        </div>

        <div class="modal_body">
            
        </div>

        <div class="modal_footer _btnSection">
            <button class="close_btn" type="button" onclick="holdOrder()">주문 보류</button>
            <button type="button" type="button" onclick="saveOrder()"><span class="prodCnt">00</span>건 주문 확인 <img src="./img/icon/arrow-right.svg" alt=""></button>
        </div>
    </div>
</div>





<script src="/js/jquery-1.12.4.js?{{ date('Ymdhis') }}"></script>
<script>
    var estimate_idx = 0;
    var estimate_code = "";
    var response_company_type = "";

    var product_option = {};
    var product_option_json = {};

    var product_option_price = 0;
    var estimate_data = [];

    const selectedKeywordType = type => {
        document.getElementById('selectedKeywordType').dataset.keywordType = type;
    }

    const searchEstimate = params => {
        const bodies = params;
        const urlSearch = new URLSearchParams(location.search);

        if (urlSearch.get('offset') && typeof bodies.offset === 'undefined') {
            bodies.offset = urlSearch.get('offset');
        } else if (bodies.offset === '') {
            delete bodies['offset'];
        }

        if (urlSearch.get('keywordType') && typeof bodies.keywordType === 'undefined') {
            bodies.keywordType = urlSearch.get('keywordType');
        } else if (bodies.keywordType === '') {
            delete bodies['keywordType'];
        }

        if (urlSearch.get('keyword') && typeof bodies.keyword === 'undefined') {
            bodies.keyword = urlSearch.get('keyword');
        } else if (bodies.keyword === '') {
            delete bodies['keyword'];
        }

        if (urlSearch.get('responseDate') && typeof bodies.responseDate === 'undefined') {
            bodies.responseDate = urlSearch.get('responseDate');
        } else if (bodies.responseDate === '') {
            delete bodies['responseDate'];
        }

        if (urlSearch.get('status') && typeof bodies.status === 'undefined') {
            bodies.status = urlSearch.get('status');
        } else if (bodies.status === '') {
            delete bodies['status'];
        }

        location.href = '/mypage/responseEstimate?' + new URLSearchParams(bodies);
    }

    const moveToEstimatePage = page => {
        const urlSearch = new URLSearchParams(location.search);
        let bodies = { offset: page };

        if (urlSearch.get('keywordType'))   bodies.keyword = urlSearch.get('keywordType');
        if (urlSearch.get('keyword'))       bodies.keyword = urlSearch.get('keyword');
        if (urlSearch.get('responseDate'))  bodies.responseDate = urlSearch.get('responseDate');
        if (urlSearch.get('status'))        bodies.status = urlSearch.get('status');

        location.replace('/mypage/responseEstimate?' + new URLSearchParams(bodies));
    }
    function getToday(afterDay){
        var date = new Date();
        date.setTime(new Date().getTime() + 1000*60*60*24* afterDay);
        var year = date.getFullYear();
        var month = ("0" + (1 + date.getMonth())).slice(-2);
        var day = ("0" + date.getDate() + afterDay).slice(-2);

        return year + "-" + month + "-" + day;
    }
    const updateResponse = () => {

        let products = [];

        sum_price = 0;
        let is_not_all_set = false;
        $('.fold_area .prod_info').each(function (index) {
            product_price = 0;

            var response_estimate_product_option_price = 0;
            var options = $($('div .prod_info')[index]).find('.option_item').find('.price');
            if(options) {
                for (let idx = 0; idx < options.length; idx++) {
                    const option = options[idx];
                    response_estimate_product_option_price += Number(option.innerText);                    
                }
            }

            products.push({
                estimate_idx: $('div .prod_info').find('input[name=idx]')[index].value,
                estimate_code: estimate_code,
                estimate_group_code: estimate_group_code,
                response_company_type: response_company_type,
                //
                product_idx: estimate_data.lists[index].product_idx,
                product_count: estimate_data.lists[index].product_count,
                name: estimate_data.lists[index].name,
                product_total_price: estimate_data.lists[index].price,
                response_estimate_estimate_total_price: 0,
                memo: estimate_data.lists[index].request_memo,

                address1: estimate_data.lists[index].request_address1,
                phone_number: estimate_data.lists[index].request_phone_number,
                register_time: estimate_data.lists[index].request_time,
                response_estimate_req_user_idx: estimate_data.lists[index].request_company_idx,

                response_estimate_res_company_name: '{{ $user -> company_name }}',
                response_estimate_res_business_license_number: '{{ $user -> business_license_number }}',
                response_estimate_res_phone_number: '{{ $user -> phone_number }}',
                response_estimate_res_address1: estimate_data.lists[index].product_address || '',
                response_estimate_account1: "",
                response_estimate_response_account2: "",
                response_estimate_res_memo: "", 
                response_estimate_res_time: getToday(0),
                expiration_date: getToday(15),
                response_estimate_product_each_price: Number($('input[name=product_each_price]')[index].value),
                response_estimate_product_delivery_info: $('#delivery_type').text(),
                response_estimate_product_option_price: response_estimate_product_option_price,
                response_estimate_product_delivery_price: $('#delivery_price').val() || 0,
                //response_estimate_product_total_price: Number($('input[name=product_each_price]')[index].value) * estimate_data.lists[index].product_count,
                response_estimate_product_total_price: estimate_data.lists[index].product_total_price,
                product_memo:estimate_data.lists[index].product_memo || '',
                response_estimate_product_memo: estimate_data.lists[index].product_memo || '',
            });


            $(this).find('input').each(function (idx, item) {
                let i_name = $(item).attr('name'); // name 속성 가져오기
                let i_val = '';
                if(i_name == 'price'){
                    i_val = parseInt($(item).val()); // 값 가져오기	
                    if(isNaN(i_val)){
                        product_price = 0;
                        i_val = 0;
                    }else{
                        product_price = i_val;
                    }
                    if(i_val < 1) {
                        is_not_all_set = true;
                    }
                    products[index][i_name] = i_val;
                }else{
                    i_val = $(item).val(); // 값 가져오기	
                    products[index][i_name] = i_val;
                }
            });
            
            products[index]['product_delivery_info_temp'] = $('#delivery_type').text();
            
            var delivery_price = 0;
            if($('#delivery_type').text() == '착불'){
                delivery_price = $('#delivery_price').val()
                if(delivery_price == ''){
                    delivery_price = 0;
                }
            }else{
                delivery_price = 0
            }
            products[index]['product_delivery_price_temp'] = delivery_price;
            
            if($('#bank_type').text() != '은행선택'){
                products[index]['response_estimate_account1'] = $('#bank_type').text();
                products[index]['response_estimate_response_account2'] = $('#account_number').val();
            }else {
                products[index]['response_estimate_account1'] = "";
                products[index]['response_estimate_response_account2'] = "";
            }
            products[index]['request_memo'] = $('#etc_memo').val();
            products[index]['response_memo'] = $('#response_memo').val();
            products[index]['response_estimate_res_memo'] = $('#response_memo').val();
            
            sum_price += product_price;
        });
        if(is_not_all_set) {
            alert('견적가가 0원인 상품이 있어 견적서를 완료할 수 없습니다.');
            return;
        }
        sum_price = 0;
        $('.fold_area .prod_info').each(function (index) {
            sum_price += Number($('input[name=product_each_price]')[index].value) * estimate_data.lists[index].product_count;
        });
        $('.fold_area .prod_info').each(function (index) {
            products[index]['response_estimate_estimate_total_price'] = sum_price;
            //products[index]['response_estimate_product_total_price'] = sum_price;
        });
        
        $.ajax({
            url: '/estimate/updateResponse',
            type: 'post',
			processData	: false,
			contentType: 'application/json',
            data: JSON.stringify(products),
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            success: function (res) {
                if (res.success) {
                    $('#loadingContainer').hide();
                    alert('견적서 보내기가 완료되었습니다.');
                    location.reload(); 
                } else {
                    $('#loadingContainer').hide();
                    alert('일시적인 오류로 처리되지 않았습니다.');
                    return false;
                }
            }, error: function (xhr, status, error) {
                console.error("오류 발생: ", status, error);
                alert("문제가 발생했습니다. 다시 시도해 주세요.");
            }
        });
        
        /*$('#loadingContainer').show();
        fetch('/estimatedev/updateResponse', {
            method  : 'POST',
            headers : {
                'X-CSRF-TOKEN'  : '{{csrf_token()}}'
            },
            body    : formData
        }).then(response => {
            return response.json();
        }).then(json => {
            
        });*/
    }

    document.addEventListener('DOMContentLoaded', function(){
        var datepicker = flatpickr('#responseDate', {
            clickOpens      : false,   //input 클릭으로는 달력이 열리지 않음
            mode            : 'range', //날짜 범위 product_each_price_text선택 모드
            dateFormat      : 'Y-m-d', //기본 날짜 형식
            locale          : 'ko',    //한국어
            onChange        : function(selectedDates, dateStr, instance) {
                // 선택된 날짜가 2개인 경우 (시작 / 종료)
                if (selectedDates.length === 2) {
                    // 커스텀 포맷으로 날짜 표시 (예:   2024-01-01~2024-01-02)
                    var formattedDate = selectedDates[0].toJSON().slice(0, 10) + '~' + selectedDates[1].toJSON().slice(0, 10);
                    instance.input.value = formattedDate;   //input에 커스텀 형식 적용
                }
            }
        });
        $('#responseDate').val('{{ request() -> get("responseDate") }}');

        // 아이콘 클릭 > 달력 열기
        window.openCalendar = function(){
            datepicker.open();
        };
    });

    document.getElementById('keyword').addEventListener('keyup', e => {
        const params = {
            keywordType     : (document.getElementById('selectedKeywordType').dataset.keywordType ?? ''),
            keyword         : e.currentTarget.value,
            responseDate     : document.getElementById('responseDate').value
        }
        
        if (e.key === 'Enter') {
            searchEstimate(params);
        }
    });


    
	$(document).ready(function(){
        $('.filter_dropdown').click(function(e){
            $(this).toggleClass('active');

            $('.filter_dropdown_wrap').toggle();
            $('.filter_dropdown svg').toggleClass('active');

            e.stopPropagation();
        });

        $('.filter_dropdown_wrap ul li a').click(function(){
            var selectedText = $(this).text();
            $('.filter_dropdown p').text(selectedText);

            selectedKeywordType($(this).data('type'));

            $('.filter_dropdown_wrap').hide();
            $('.filter_dropdown').removeClass('active');
            $('.filter_dropdown svg').removeClass('active');
        });

        $(document).click(function(e){
            var $target = $(e.target);

            if(!$target.closest('.filter_dropdown').length && $('.filter_dropdown').hasClass('active')) {
                $('.filter_dropdown_wrap').hide();

                $('.filter_dropdown').removeClass('active');
                $('.filter_dropdown svg').removeClass('active');
            }
        });

        $('.request_estimate_detail').click(function (){
            estimate_idx = $(this).data('idx');
            estimate_code = $(this).data('code');
            estimate_group_code = $(this).data('group_code');
            response_company_type = $(this).data('response_company_type');

            $.ajax({
                url: '/mypage/requestEstimateDevDetail',
                type: 'post',
                data: {
                    'group_code'   : estimate_group_code
                },
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                },
                success: function (res) {
                    if( res.result === 'success' ) {
                        console.log( res );
                        estimate_data = res.data;
                        $('#request_confirm_write-modal .modal_body').empty().append(res.html);
                        $('.prodCnt').text( res.data.length );
                        modalOpen('#request_confirm_write-modal');
                    } else {
                        alert(res.message);
                    }
                }, error: function (e) {

                }
            });
		});

        // 견적서 확인하기
        $('.check_estimate_detail').click(function(){
            estimate_idx = $(this).data('idx');
            estimate_code = $(this).data('code');
            estimate_group_code = $(this).data('group_code');
            response_company_type = $(this).data('response_company_type');

            $.ajax({
                url: '/mypage/responseEstimateDevDetail',
                type: 'post',
                data: {
                    'group_code'   : estimate_group_code
                },
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                },
                success: function (res) {
                    if( res.result === 'success' ) {
                        console.log( res );
                        estimate_data = res.data;
                        $('#check_estimate-modal .modal_body').empty().append(res.html);
                        $('.prodCnt').text( res.data.length );
                        modalOpen('#check_estimate-modal');
                    } else {
                        alert(res.message);
                    }
                }, error: function (e) {

                }
            });
        });

        $('.check_order_detail:button').click(function(){
            estimate_idx = $(this).data('idx');
            estimate_code = $(this).data('code');
            estimate_group_code = $(this).data('group_code');

            $.ajax({
                url: '/mypage/estimate/order/detail',
                type: 'post',
                data: {
                    'group_code'   : estimate_group_code
                },
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                },
                success: function (res) {
                    if( res.result === 'success' ) {
                        console.log( res );
                        
                        if(res.data.lists[0].order_state != 'X') {
                            $('._btnSection').html("<button type='button' onclick=\"modalClose('#check_order-modal')\">확인</button>");
                        } else {
                            $('._btnSection').html("<button class=\"close_btn\" type=\"button\" onclick=\"holdOrder()\">주문 보류</button>"
                                + "<button type=\"button\" onclick=\"saveOrder()\"><span class=\"prodCnt\">00</span>건 주문 확인 "
                                + "<img src=\"./img/icon/arrow-right.svg\" alt=\"\"></button>");
                        }
                        estimate_data = res.data.lists;
                        $('#check_order-modal .modal_body').empty().append(res.html);
                        $('.prodCnt').text( res.data.lists.length );
                        modalOpen('#check_order-modal');
                    } else {
                        alert(res.message);
                    }
                }, error: function (e) {

                }
            });
        });

        $(document).on('keyup', '#response_estimate_product_each_price', function(e){
            if(!$(this).val()) $(this).val(0);
            $(this).val($(this).val().replace(/[^0-9]/g, ''));

            $('.response_estimate_product_total_price').text((parseInt($(this).val()) * parseInt($('.response_estimate_product_count').last().text())).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
            $('#response_estimate_product_total_price').val(parseInt($(this).val()) * parseInt($('.response_estimate_product_count').last().text()));

            $('.response_estimate_estimate_total_price').text((parseInt($(this).val()) * parseInt($('.response_estimate_product_count').last().text()) + parseInt($('#response_estimate_product_delivery_price').val()) + parseInt(product_option_price)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
            $('#response_estimate_estimate_total_price').val((parseInt($(this).val()) * parseInt($('.response_estimate_product_count').last().text()) + parseInt($('#response_estimate_product_delivery_price').val())) + parseInt(product_option_price));
        });

        $(document).on('keyup', '#response_estimate_product_delivery_price', function(e){
            if(!$(this).val()) $(this).val(0);
            $(this).val($(this).val().replace(/[^0-9]/g, ''));

            $('.response_estimate_product_delivery_price').text((parseInt($(this).val())).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));

            $('.response_estimate_estimate_total_price').text((parseInt($(this).val()) + parseInt($('#response_estimate_product_total_price').val())  + parseInt(product_option_price)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','));
            $('#response_estimate_estimate_total_price').val((parseInt($(this).val()) + parseInt($('#response_estimate_product_total_price').val())) + parseInt(product_option_price));
        });
    });
        function holdOrder (){
            modalClose('#check_order-modal');
            $.ajax({
                url: '/estimate/order/hold',
                type: 'post',
                data: {
                    'estimate_group_code'   : estimate_group_code
                },
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                },
                success: function (res) {
                    if( res.result === 'success' ) {
                        console.log( res );
                        alert('보류 되었습니다.');
                        location.reload();
                    } else {
                        alert(res.message);
                    }
                }, error: function (e) {

                }
            });
        }
        function saveOrder (){
            $.ajax({
                url: '/estimate/order/save',
                type: 'post',
                data: {
                    'estimate_group_code'   : estimate_group_code
                },
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                },
                success: function (res) {
                    if( res.result === 'success' ) {
                        console.log( res );
                        alert('저장 되었습니다.');
                        location.reload();
                    } else {
                        alert(res.message);
                    }
                }, error: function (e) {

                }
            });
        }
</script>
