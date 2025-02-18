
@if (count($response['list']) > 0)

<div class="w-full">
    <div class="flex">
        <a href="/mypage/estimateInfo" class="text-stone-400 text-xl font-bold grow text-center">견적서 관리</a>
        <a href="/mypage/responseEstimateMulti" class="text-xl text-primary font-bold grow border-b-2 border-primary pb-5 text-center">견적서 보내기</a>
    </div>     
    <hr>
    <form method="PUT" name="udForm" id="udForm" action="/estimate/updateResponseMulti">
        <input type="hidden" name="response_company_idx" id="response_company_idx" value="{{ $response['list'][0] -> company_idx }}" />
        <input type="hidden" name="response_company_type" id="response_company_type" value="{{ $response['list'][0] -> company_type }}" />
        <input type="hidden" name="response_company_name" id="response_company_name" value="{{ $response['list'][0] -> company_name }}" />
        <table class="table_layout mt-8">
            <colgroup>
                <col width="120px">
                <col width="330px">
                <col width="120px">
                <col width="330px">
            </colgroup>
            <thead>
                <tr>
                    <th colspan="4">공급자</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>업&nbsp;&nbsp;&nbsp;체&nbsp;&nbsp;&nbsp;명</th>
                    <td class="response_company_name">
                        <span class="response_company_name">{{ $response['list'][0] -> company_name }}</span>
                    </td>
                    <th>사업자번호</th>
                    <td>
                        <span class="response_business_license_number hidden"></span>
                        <input type="text" name="response_business_license_number" id="response_business_license_number" class="input-form" value="{{ $response['list'][0] -> business_license_number }}" />
                    </td>
                </tr>
                <tr>
                    <th>전 화 번 호</th>
                    <td>
                        <span class="response_phone_number hidden"></span>
                        <input type="text" name="response_phone_number" id="response_phone_number" class="input-form" value="{{ $response['list'][0] -> phone_number }}" />
                    </td>
                    <th>유 효 기 한</th>
                    <td>
                        <div class="flex items-center">
                            <span>
                                견적일로부터 &nbsp;&nbsp;
                            </span>
                            <span class="expiration_date hidden"> 15일</span> 
                            {{-- <div class="input-form ml-3 "> --}}
                                <select name="expiration_date" id="expiration_date" class="input-form w-140">
                                    @for ($i = 15; $i >= 1; $i--)
                                        <option value="{{ $i }}">{{ $i }}일</option>
                                    @endfor
                                </select>
                            {{-- </div> --}}
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>배 송 방 법</th>
                    <td>
                        {{-- <div class="flex items-center"> --}}
                            <span class="product_delivery_info hidden">착불</span> 
                            {{-- <div class="input-form w-full"> --}}
                                <select name="product_delivery_info" id="product_delivery_info" class="input-form w-full">
                                    <option value="업체 협의 (착불)">착불</option>
                                    <option value="매장 배송 (무료)">무료</option>
                                </select>
                            {{-- </div> --}}
                        {{-- </div> --}}
                    </td>
                    <th>배 송 비</th>
                    <td>
                        <span class="txt-primary product_delivery_price hidden"><b>0원</b></span> 
                        <input type="text" name="product_delivery_price" id="product_delivery_price" class="input-form w-ful txt-danger" value="0" />
                    </td>
                </tr>
                <tr>
                    <th>주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소</th>
                    <td colspan="3">
                        <span class="response_address1 hidden"></span> 
                        <input type="text" name="response_address1" id="response_address1" class="input-form w-full" value="{{ $response['list'][0] -> address1 }}" />
                    </td>
                </tr>
                <tr>
                    <th>계 좌 번 호</th>
                    <td colspan="3">
                        <div class="flex items-center">
                            <span class="response_account hidden"></span>
                            {{-- <div class="input-form"> --}}
                                <select name="response_account1" id="response_account1" class="input-form  h-full">
                                    <option value="KEB하나은행">KEB하나은행</option>
                                    <option value="SC제일은행">SC제일은행</option>
                                    <option value="국민은행">국민은행</option>
                                    <option value="신한은행">신한은행</option>
                                    <option value="외환은행">외환은행</option>
                                    <option value="우리은행">우리은행</option>
                                    <option value="한국시티은행">한국시티은행</option>
                                    <option value="기업은행">기업은행</option>
                                    <option value="농협">농협</option>
                                    <option value="수협">수협</option>
                                </select>
                            {{-- </div> --}}
                            <input type="text" name="response_account2" id="response_account2" class="input-form ml-2" value="" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>비&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;고</th>
                    <td colspan="3">
                        <span class="response_memo hidden"></span> 
                        <input type="text" name="response_memo" id="response_memo" class="input-form w-full" value="" />
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="custom_input">
            <div class="flex justify-end mt-16 checkAll">
                <div class="flex items-center">
                    <input type="checkbox" id="checkAllItem" class="checkAllItem" />
                    <label for="checkAllItem" class="flex items-center gap-2">전체 상품 체크</label>
                </div>
            </div>
            <ul class="order_prod_list mt-5">
                @foreach($response['list'] as $res)
                <li>
                    <div class="img_box">
                        <input type="hidden" name="product_idx[]" value="{{ $res -> idx }}" />
                        <input type="checkbox" class="checkItem" id="check{{ $res -> num }}" />
                        <label for="check{{ $res -> num }}"></label>
                        <img src="{{ $res -> product_thumbnail }}" alt="" />
                    </div>
                    <div class="right_box">
                        <h6>{{ $res -> name }}</h6>
                        <table class="table_layout">
                            <colgroup>
                                <col width="160px">
                                <col width="*">
                            </colgroup>
                            <tr>
                                <th>상품수량</th>
                                <td>
                                    <span class="product_count"></span>
                                    <div class="count_box">
                                        <button type="button" class="minus"><svg><use xlink:href="/img/icon-defs.svg#minus"></use></svg></button>
                                        <input type="text" name="product_count[]" value="1" readOnly />
                                        <button type="button" class="plus"><svg><use xlink:href="/img/icon-defs.svg#plus"></use></svg></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>옵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;션</th>
                                <td>
                                @if (!empty(json_decode($res -> product_option)))
                                    <table class="my_table w-full text-left">
                                        @foreach (json_decode($res -> product_option) as $key => $val)
                                            @if ($val -> required === '1')
                                            <tr>
                                                <th>
                                                    {{ $val -> optionName }}
                                                    <input type="hidden" name="product_option_key_{{ $res -> idx }}[]" value="{{ $val -> optionName }}" readOnly />
                                                </th>
                                                <td>
                                                    <div class="input-form w-2/3">
                                                        <select name="product_option_value_{{ $res -> idx }}[]" class="w-full h-full">
                                                        @foreach ($val -> optionValue as $opVal)
                                                            <option value="{{ $opVal -> propertyName }},{{ $opVal -> price }}">{{ $opVal -> propertyName }}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                  
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                    </table>
                                @else
                                    없음
                                @endif
                                </td>
                            </tr>
                            <tr>
                                <th>견적단가</th>
                                <td>
                                    <span class="txt-primary product_each_price"></span>
                                    <input type="text" name="product_each_price[]" class="input-form w-2/3" value="{{ $res -> price }}" />
                                </td>
                            </tr>
                            <tr>
                                <th>상품번호</th>
                                <td class="txt-gray product_number">{{ $res -> product_number }}</td>
                            </tr>
                        </table>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="flex items-center mt-16 search_company_div hidden">
            <p class="shrink-0 w-24">업체 선택</p>
            <button type="button" class="setting_input h-[48px] w-72 flex items-center gap-3" onclick="searchCompanyStart()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search w-5 h-5 text-stone-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <p class="w-full h-full font-normal text-stone-400 flex items-center">견적서를 보내실 업체를 선택해주세요.</p>
            </button>
        </div>
        <div class="flex pt-5 search_company_div hidden">
            <p class="shrink-0 w-24">선택된 업체</p>
            <div class="flex flex-wrap gap-3 checked_company">
                <!--
                <div class="h-[30px] px-3 flex items-center gap-1 bg-stone-100 rounded-full">
                    <sapn class="text-stone-400">올펀가구</sapn>
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x w-5 h-5 text-stone-400"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </button>
                </div>
                -->
            </div>
        </div>
    </form>
    
    <div class="btn_box mt-10 prev">
        <a href="javascript: ;" class="btn btn-primary w-full" onclick="goNext()">상품선택 완료</a>
    </div>
    <div class="btn_box mt-10 next hidden">
        <p class="txt-gray fs12 text-right mb-2">* 올톡 채팅 친구 또는 친구를 맺은 거래처에게만 보낼 수 있습니다.</p>
        <div class="flex gap-5">
            <a href="javascript: ;" class="btn btn-kakao w-[330px]"onclick="updateResponseMulti(true)"><img class="mr-2" src="/img/kakao.svg" alt="">카카오톡 친구에게 견적서 보내기</a>
            <a href="javascript: ;" class="btn btn-primary flex-1" onclick="updateResponseMulti()">견적서 보내기</a>
        </div>
    </div>
</div>

<!-- 업체 선택 -->
<div id="search_company_modal" class="modal">
    <div class="modal_bg" onclick="modalClose('#search_company_modal')"></div>
    <div class="modal_inner modal-md">
        <div class="modal_body filter_body">
            <h4>업체 선택</h4>
            <div class="flex items-center mt-5">
                <div class="setting_input h-[48px] w-full flex items-center gap-3" onclick="modalOpen('#search_company_modal')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search w-5 h-5 text-stone-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <input type="text" name="keyword" id="keyword" class="w-full h-full font-normalflex items-center" placeholder="검색" />
                </div>
            </div>
            <p class="mt-4 text-sm text-stone-400">검색 결과</p>
            <div class="h-[360px] overflow-y-auto">
                <ul class="filter_list" style="margin-top: 0px; max-height:340px;">
                <!--
                    <li>
                        <input type="checkbox" id="business_check01" class="check-form" />
                        <label for="business_check01">올펀가구</label>
                    </li>
                -->
                </ul>
            </div>
            <div class="">
                <button type="button" class="btn btn-primary w-full" onclick="searchCompanyEnd()">완료</button>
            </div>
        </div>
    </div>
</div>





<script src="/js/jquery-1.12.4.js?{{ date('Ymdhis') }}"></script>
<script>
    const goNext = () => {
        if(!$('input[name="response_business_license_number"]').val()) {
            alert('사업자번호를 입력해주세요!');
            $('input[name="response_business_license_number').focus();

            return false;
        }

        if(!$('input[name="response_phone_number"]').val()) {
            alert('전화번호를 입력해주세요!');
            $('input[name="response_phone_number').focus();

            return false;
        }

        if(!$('#product_delivery_price').val()) {
            alert("배송비를 입력해주세요!");
            $('#product_delivery_price').focus();

            return false;
        }

        if(!$('input[name="response_address1"]').val()) {
            alert('주소를 입력해주세요!');
            $('input[name="response_address1').focus();

            return false;
        }

        if(!$('#response_account2').val()) {
            alert('계좌번호를 입력해주세요!');
            $('input[name="response_account2').focus();

            return false;
        }

        if($('.checkItem:checked').length < 1) {
            alert('최소 1개 이상의 상품을 체크해주셔아 합니다!');
            document.getElementById('response_memo').scrollIntoView({ behavior: 'smooth' })

            return false;
        }

        $('#response_business_license_number').addClass('hidden');
        $('.response_business_license_number').text($('#response_business_license_number').val());
        $('.response_business_license_number').removeClass('hidden');

        $('#response_phone_number').addClass('hidden');
        $('.response_phone_number').text( $('#response_phone_number').val());
        $('.response_phone_number').removeClass('hidden');

        $('#expiration_date').addClass('hidden');
        $('.expiration_date').text($('#expiration_date option:selected').text());
        $('.expiration_date').removeClass('hidden');

        $('#product_delivery_info').addClass('hidden');
        $('.product_delivery_info').text( $('#product_delivery_info').val());
        $('.product_delivery_info').removeClass('hidden');

        $('#product_delivery_price').addClass('hidden');
        $('.product_delivery_price').text( $('#product_delivery_price').val().toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');
        $('.product_delivery_price').removeClass('hidden');

        $('#response_address1').addClass('hidden');
        $('.response_address1').text( $('#response_address1').val());
        $('.response_address1').removeClass('hidden');

        $('#response_account1').addClass('hidden');
        $('#response_account2').addClass('hidden');
        $('.response_account').text($('#response_account1').val() + ' ' + $('#response_account2').val());
        $('.response_account').removeClass('hidden');

        $('#response_memo').addClass('hidden');
        $('.response_memo').text( $('#response_memo').val());
        $('.response_memo').removeClass('hidden');

        $('.search_company_div').removeClass('hidden');

        $('.checkAll').remove();

        $('.checkItem').each(function(index){
            if(!$(this).is(':checked')) {
                $(this).closest('li').remove();
            } else {
                $(this).siblings('label').remove();
                $(this).remove();
            }
        });

        $('input[name="product_count[]"]').each(function(index){
            $(this).closest('.count_box').addClass('hidden');
            $(this).closest('.count_box').siblings('span').text($(this).val() + '개')
        });

        $('select[name="product_option[]"]').each(function(index){
            $(this).addClass('hidden');
            $(this).siblings('span').text($(this).val());
        });

        $('input[name="product_each_price[]"]').each(function(index){
            $(this).addClass('hidden');
            $(this).siblings('span').text($(this).val().toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '원');
        });

        $('.prev').addClass('hidden');
        $('.next').removeClass('hidden');

        $('html, body').animate({ scrollTop: '920' }, 200);
    }

    const searchCompanyStart = () => {
        $('.check-form').prop('checked', false);

        modalOpen('#search_company_modal');
        setTimeout(function(){ $('#keyword').focus(); }, 50);
    }

    const searchCompanyEnd = () => {
        //$('.checked_company').html('');

        $('input[name="company_idx"]:checked').each(function(){
            $('.checked_company').append(
                '<div class="h-[30px] px-3 flex items-center gap-1 bg-stone-100 rounded-full">' +
                    '<input type="hidden" name="company_idx[]" value="' + $(this).val() + '" />' +
                    '<input type="hidden" name="company_type[]" value="' + $(this).siblings('span').text() + '" />' +
                    '<sapn class="text-stone-400">' + $(this).siblings('label').text() + '</sapn>' + 
                    '<button class="del" data-idx="' + $(this).val() + '">' +
                        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x w-5 h-5 text-stone-400"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>' +
                    '</button>' +
            '</div>');
        });
        
        modalClose('#search_company_modal');
    }

    const updateResponseMulti = (isKakao) => {
        if($('.del').length < 1) {
            alert('최소 1개 이상의 업체를 선택해주세요!');

            modalOpen('#search_company_modal');
            setTimeout(function(){ $('#keyword').focus(); }, 50);

            return false;
        }

        if(confirm('이대로 견적서를 보내시겠습니까?')) {
            const formData = new FormData(document.getElementById('udForm'));
            formData.append('isKakao', isKakao ? true : false);
            /*
            for (const [key, value] of formData.entries()) {
                console.log(key, value);
            }
            return false;
            */
            $('#loadingContainer').show();
            fetch('/estimate/updateResponseMulti', {
                method  : 'POST',
                headers : {
                    'X-CSRF-TOKEN'  : '{{csrf_token()}}'
                },
                body    : formData
            }).then(response => {

                return response.json();
            }).then(json => {
                if (json.success) {
                    if(isKakao) { 
                        shareEstimate();
                        setTimeout(() => {
                            location.reload();    
                        }, 1000);
                    } else {
                        $('#loadingContainer').hide();
                        alert('견적서 보내기가 완료되었습니다.');
                        location.reload();
                    }
                } else {
                    $('#loadingContainer').hide();
                    alert('일시적인 오류로 처리되지 않았습니다.');
                    return false;
                }
            });
        }
    }



    $(document).ready(function(){
        $('#checkAllItem').click(function(){
            $('.checkItem').prop('checked', this.checked);
        });

        $('.checkItem').change(function(){
            if ($('.checkItem:checked').length == $('.checkItem').length) {
                $('#checkAllItem').prop('checked', true);
            } else {
                $('#checkAllItem').prop('checked', false);
            }
        });

        $('.count_box .minus').off().on('click', function(){
            let num = Number($(this).siblings('input').val());
            if (num > 1) {
                product_count = num - 1;
                
                $(this).siblings('input').val(product_count);
            }
        });

        $('.count_box .plus').off().on('click', function(){
            let num = Number($(this).siblings('input').val());
            product_count = num + 1;

            $(this).siblings('input').val(product_count);
        });

        $(document).on('keyup', '#keyword', function(){
            $('.filter_list').empty();
            /*
            if(!$(this).val()) {
                alert('검색어를 입력해주세요!');
                $(this).focus();

                return false;
            }
            */

            if ($(this).val().length>0) {
                fetch('/estimate/companyList', {
                    method  : 'POST',
                    headers : {
                        'Content-Type'  : 'application/json',
                        'X-CSRF-TOKEN'  : '{{csrf_token()}}'
                    },
                    body    : JSON.stringify({
                        keyword         : $(this).val()
                    })
                }).then(response => {
                    return response.json();
                }).then(json => {
                    if (json.result === 'success') {
                        if(json.data.length > 0) {
                            for(var i = 1; i <= json.data.length; i++) {
                                $('.filter_list').append(
                                    '<li>' +
                                        '<span class="hidden">' + json.data[i - 1].company_type + '</span>' +
                                        '<input type="checkbox" name="company_idx" id="business_check' + i + '" class="check-form" value="' + json.data[i - 1].idx + '" />' +
                                        '<label for="business_check' + i + '">' + json.data[i - 1].company_name + json.data[i - 1].company_type_kor + '</label>' + 
                                    '</li>'
                                );
                            }
                        } else {
                            $('.filter_list').html('');
                        }
                    } else {
                        alert(json.message);
                    }
                });
            }
        });

        $(document).on('click', '.del', function(){
            $(this).closest('div').remove();
        });
    });

    function shareEstimate() {
        Kakao.Share.sendDefault({
            objectType: 'text',
            text:
                '올펀 - 글로벌 가구 도·소매 No.1 플랫폼\n{{ $response['list'][0] -> company_name }}님에게서 요청하신 견적서가 도착했습니다.',
            link: {
                mobileWebUrl: "{{ env('APP_URL') }}" + "/mypage/requestEstimate",
                webUrl: "{{ env('APP_URL') }}" + "/mypage/requestEstimate",
            },
            buttonTitle: '견적서 보기',
        });
    }
</script>

@else 
    @if (in_array(Auth::user()['type'], ['W','R']))
        <script> 
            alert('판매 승인된 상품이 등록되어야 견적서 보내기가 가능합니다.'); history.back();
        </script>
    @else 
        <script> 
            alert('가구사업자만 견적서 보내기가 가능합니다.'); history.back();
        </script>
    @endif 
@endif 