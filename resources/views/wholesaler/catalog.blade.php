<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ALL FURN</title>
    <link rel="stylesheet" href="/css/font.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" /> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> -->
    <link rel="stylesheet" href="/css/flatpickr.min.css">
    <link rel="stylesheet" href="/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="/css/common.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/rubin.css">

    <script src="/js/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script> -->
    <script src="/js/swiper-bundle.min.js"></script>
    <script src="/js/common.js"></script>

    <script src="/js/flatpickr.js"></script>
    <script src="/js/flatpickr_ko.js"></script>

    <!-- <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ko.js"></script> -->
</head>

<body>

<link rel="stylesheet" href="{{ env('APP_URL') }}/css/catalog.css">
<!--
<div id="catalog_intro">
    <img src="{{ env('APP_URL') }}/img/catalog_intro.png" alt="">
</div>
-->
	
<style>
    #catalog .logo:before {
        background-image: url('@if($data['info']->imgUrl2 != null) {{$data['info']->imgUrl2}} @else /img/company_banner.png @endif')
    }
</style>
<div id="catalog">
    <div class="bot_quick">
        <button type="button" class="tab_btn active" onclick="tabChange(this,0)">판매상품</button>
        <button type="button" class="tab_btn" onclick="tabChange(this,1)">업체소개</button>
        <!--
        <button type="button" class="addLike {{ ($data['info']->isLike == 1) ? 'active' : '' }}" onClick="addLike({{$data['info']->idx}});"><svg><use xlink:href="{{ env('APP_URL') }}/img/icon-defs.svg#zzim"></use></svg>좋아요</button>
-->
        <button type="button" onClick="shareCatalog({{$data['info']->idx}},5)"><svg><use xlink:href="{{ env('APP_URL') }}/img/icon-defs.svg#share"></use></svg>공유하기</button>
    </div>


    <!-- <div class="catalog_txt">금주의 <span>추</span><span>천</span>상품<br/> 빠르게 받아 보세요!</div> -->

    <div class="logo">
        <div>
            <span>Catalog</span>
            <p>{{$data['info']->company_name}}</p>
        </div>
    </div>
    
    <div class="catalog_content">
        <div class="company_img">
			@if($data['info']->imgUrl != null)
            <img src="@if($data['info']->imgUrl != null) {{$data['info']->imgUrl}} @else /img/profile_img.svg @endif" class="w-[130px] h-[130px] object-cover rounded-full border-2 border-white" alt="">
			@else
			<span>{{$data['info']->company_name}}</span>
			@endif
        </div>

        <div class="tab_content">
            <!-- 판매상품 -->
            <div class="active">
                @if($data['recommend']->count() > 0)
                <div>
                    <h3>{{$data['info']->company_name}} 추천 상품</h3>
                    <div class="swiper-container slide_box">
                        <ul class="swiper-wrapper">
                            @foreach($data['recommend'] as $item)
                            <li class="swiper-slide prod_item">
                                <div class="img_box">
                                    <a href="javascript:saveDetail({{$item->idx}})"><img src="{{$item->imgUrl}}" alt="{{$item->name}}"></a>
                                    <!--
                                    <button class="zzim_btn"><svg><use xlink:href="{{ env('APP_URL') }}/img/icon-defs.svg#zzim"></use></svg></button>
                                    -->
                                </div>
                                <div class="txt_box">
                                    <a href="javascript:saveDetail({{$item->idx}})">
                                        <span>{{$item->company_name}}</span>
                                        <p>{{$item->name}}</p>
                                        <b>{{$item->is_price_open ? number_format($item->price, 0).'원': $item->price_text}}</b>
                                    </a>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <div class="catalog_con02">
                    <div class="catalog_title">
                        <h3>{{$data['info']->company_name}} 전체 상품</h3>
                        <button class="prod_type">카드타입</button>
                    </div>
                    <!-- 원래 퍼블리싱이었으나 카테고리 추가로 아래 필터 영역을 복붙했습니다. 디자인에 맞춰 수정해주시면 좋겠습니다.
                    <div class="text-right mb-3 txt-gray fs14 total">
                    </div>
                    -->
                    <div class="sub_filter">
                        <div class="filter_box">
                            <button onclick="modalOpen('#filter_category-modal')">카테고리 <b class='txt-primary'></b></button>
                            <button onclick="modalOpen('#filter_align-modal03')">최신순</button>
                        </div>
                        <div class="total">전체 0개</div>
                    </div>
                    <div class="sub_filter_result" hidden>
                        <div class="filter_on_box">
                            <div class="category"></div>
                        </div>
                        <button class="refresh_btn">초기화 <svg><use xlink:href="/img/icon-defs.svg#refresh"></use></svg></button>
                    </div>
                    <ul class="prod_list grid2">
                    </ul>
                </div>

                <div class="company_detail">
                    <div class="detail">
                        <div class="top_info">
                            <!--
                            <div class="tit">
                                <img src="{{ env('APP_URL') }}/img/logo.svg" alt="">
                                <p>가구 도매 플랫폼</p>
                            </div>
-->
                            <div class="txt">
                                <!-- <p>매일 새로운 가구를 올펀에서 무료로 만나보세요!</p> -->
                                <a href="{{ env('APP_URL') }}/wholesaler/detail/{{$data['info']->idx}}" class="btn btn-primary">{{$data['info']->company_name}} 견적서 받기</a>
                            </div>
                        </div>
                        <div class="info">
                            <table>
                                <colgroup>
                                    <col width="100px">
                                    <col width="*">
                                </colgroup>
                                <tbody>
                                    @if($data['info']->owner_name)
                                        <tr>
                                            <th>대표자</th>
                                            <td>{{$data['info']->owner_name}}</td>
                                        </tr>
                                    @endif
                                    @if($data['info']->phone_number)
                                        <tr>
                                            <th>대표전화</th>
                                            <td>@php echo preg_replace('/^(\d{2,3})(\d{3,4})(\d{4})$/', '$1-$2-$3', $data['info']->phone_number); @endphp</td>
                                        </tr>
                                    @endif
                                    @if ($data['info']->work_day)
                                        <tr>
                                            <th>근무일</th>
                                            <td>{{$data['info']->work_day}}</td>
                                        </tr>
                                    @endif
                                    @if ($data['info']->how_order)
                                        <tr>
                                            <th>발주방법</th>
                                            <td>{{$data['info']->how_order}}</td>
                                        </tr>
                                    @endif
                                    @if ($data['info']->manager)
                                        <tr>
                                            <th>담당자</th>
                                            <td>{{$data['info']->manager}}</td>
                                        </tr>
                                    @endif
                                    @if ($data['info']->manager_number)
                                        <tr>
                                            <th>담당자연락처</th>
                                            <td>{{$data['info']->manager_number}}</td>
                                        </tr>
                                    @endif
                                    @if ($data['info']->website)
                                        <tr>
                                        <th>웹사이트</th>
                                        <td><a @if(strpos($data['info']->website, 'http') !== false) href="{{$data['info']->website}}" target="_blank" @endif>{{$data['info']->website}}</a></td>    
                                    </tr>
                                    @endif
                                    @if ($data['info']->business_address)
                                        <tr>
                                            <th>주소</th>
                                            <td>{{$data['info']->business_address .' '.$data['info']->business_address_detail}}</td>    
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 업체소개 -->
            <div>
                <div class="inquiry_btn">
                    <a href="{{ env('APP_URL') }}/wholesaler/detail/{{$data['info']->idx}}">
                        <b>{{$data['info']->company_name}}</b>
                        <span>상품문의<svg><use xlink:href="{{ env('APP_URL') }}/img/icon-defs.svg#more_icon"></use></svg></span>
                    </a>
                </div>

                <div class="company_detail mb-3">
                    <div class="detail">
                        
                        <div class="info">
                            <table>
                                <colgroup>
                                    <col width="100px">
                                    <col width="*">
                                </colgroup>
                                <tbody>
                                    @if($data['info']->owner_name)
                                        <tr>
                                            <th>대표자</th>
                                            <td>{{$data['info']->owner_name}}</td>
                                        </tr>
                                    @endif
                                    @if($data['info']->phone_number)
                                        <tr>
                                            <th>대표전화</th>
                                            <td>@php echo preg_replace('/^(\d{2,3})(\d{3,4})(\d{4})$/', '$1-$2-$3', $data['info']->phone_number); @endphp</td>
                                        </tr>
                                    @endif
                                    @if ($data['info']->work_day)
                                        <tr>
                                            <th>근무일</th>
                                            <td>{{$data['info']->work_day}}</td>
                                        </tr>
                                    @endif
                                    @if ($data['info']->how_order)
                                        <tr>
                                            <th>발주방법</th>
                                            <td>{{$data['info']->how_order}}</td>
                                        </tr>
                                    @endif
                                    @if ($data['info']->manager)
                                        <tr>
                                            <th>담당자</th>
                                            <td>{{$data['info']->manager}}</td>
                                        </tr>
                                    @endif
                                    @if ($data['info']->manager_number)
                                        <tr>
                                            <th>담당자연락처</th>
                                            <td>{{$data['info']->manager_number}}</td>
                                        </tr>
                                    @endif
                                    @if ($data['info']->website)
                                        <tr>
                                        <th>웹사이트</th>
                                        <td><a @if(strpos($data['info']->website, 'http') !== false) href="{{$data['info']->website}}" target="_blank" @endif>{{$data['info']->website}}</a></td>    
                                    </tr>
                                    @endif
                                    @if ($data['info']->business_address)
                                        <tr>
                                            <th>주소</th>
                                            <td>{{$data['info']->business_address .' '.$data['info']->business_address_detail}}</td>    
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="info_box">
                    <?php echo str_replace('\"', '', html_entity_decode($data['info']->introduce)); ?>
                </div>

                <div class="company_detail">
                    <div class="detail">
                        <div class="top_info">
                            <!--
                            <div class="tit">
                                <img src="{{ env('APP_URL') }}/img/logo.svg" alt="">
                                <p>가구 도매 플랫폼</p>
                            </div>
-->
                            <div class="txt">
                                <!-- <p>매일 새로운 가구를 올펀에서 무료로 만나보세요!</p> -->
                                <a href="{{ env('APP_URL') }}/wholesaler/detail/{{$data['info']->idx}}" class="btn btn-primary">{{$data['info']->company_name}} 견적서 받기</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    </div>
</div>
@include('layouts.includes.send-catalog')

<script>
    const prodSlide = new Swiper("#catalog .slide_box", {
        slidesPerView: 2.5,
        spaceBetween: 8,
    });
    $('#loadingContainer').show();


    $('.catalog_con02 .prod_type').on('click',function(){
        
        if($(this).text() == "카드타입"){
            $(this).text('갤러리 타입')
            $('.catalog_con02 .prod_list').removeClass('grid2').addClass('grid1')
        }else{
            $(this).text('카드타입')
            $('.catalog_con02 .prod_list').removeClass('grid1').addClass('grid2')
        }
    })

    const tabChange = (item,num)=>{
        $(item).addClass('active').siblings().removeClass('active');
        $('.tab_content > div').eq(num).addClass('active').siblings().removeClass('active')
        $(window).scrollTop(0)
        if(num == 1){
            $('#catalog').addClass('totop')
        }else{
            $('#catalog').removeClass('totop')
	    }
    }

    setTimeout(function(){
        loadProductList(false)
        $('#catalog_intro').addClass('off')
    },3000)

    var isProc = false;
    function addLike(idx) {
        if (isProc) {
            return;
        }
        isProc = true;

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url             : '/wholesaler/like/'+idx,
            enctype         : 'multipart/form-data',
            processData     : false,
            contentType     : false,
            data			: {},
            type			: 'POST',
            success: function (result) {
                if (result.success) {
                    if (result.like == 0) {
                        $('.addLike.active').removeClass('active');
                    } else {
                        $('.addLike').addClass('active');
                    }
                } else {
                    alert(reslult.message);
                }

                isProc = false;
            }
        });
    }
    let isLoading = false;
    let isLastPage = false;
    let currentPage = 0;
    let firstLoad = true;
    function loadProductList(needEmpty, target) {
        if(isLoading) return;
        if(!needEmpty && isLastPage) return;

        isLoading = true;
        if(needEmpty) currentPage = 0;

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/wholesalerAddProduct/catalog',
            method: 'GET',
            data: { 
                'page': ++currentPage,
                'categories' : getIndexesOfSelectedCategory().join(','),
                'orderedElement' : $("#filter_align-modal03 .radio-form:checked").val(),
                'company_idx'   : '{{$data['info']->idx}}'
            }, 
            beforeSend : function() {
                if(target) {
                    target.prop("disabled", true);
                }
            },
            success: function(result) {
                console.log(result);
                if(needEmpty) {
                    $(".prod_list").empty();
                }
                if(target) {
                    target.prop("disabled", false);
                    modalClose('#' + target.parents('[id^="filter"]').attr('id'));
                }
                
                $(".prod_list").append(result.data.html);

                $(".total").text('전체 ' + result.total.toLocaleString('ko-KR') + '개');

                isLastPage = currentPage === result.last_page;
            }, 
            complete : function () {
                displaySelectedCategories();
                displaySelectedOrders();
                toggleFilterBox();
                isLoading = false;
            }
        })
    }

    function getIndexesOfSelectedCategory() {
        let categories = [];
        $("#filter_category-modal .check-form:checked").each(function(){
            categories.push($(this).attr('id'));
        });

        return categories;
    }

    function displaySelectedCategories() {
        
        let html = "";  
        $("#filter_category-modal .check-form:checked").each(function(){
            html += "<span>" + $('label[for="' + $(this).attr('id') + '"]').text() + 
                    "   <button data-id='"+ $(this).attr('id') +"' onclick=\"filterRemove(this)\"><svg><use xlink:href=\"/img/icon-defs.svg#x\"></use></svg></button>" +
                    "</span>";
        });
        $(".filter_on_box .category").empty().append(html);

        let totalOfSelectedCategories = $("#filter_category-modal .check-form:checked").length;
        if(totalOfSelectedCategories === 0) {
            $(".sub_filter .filter_box button").eq(0).find('.txt-primary').text("");
            $(".sub_filter .filter_box button").eq(0).removeClass('on');
        } else {
            $(".sub_filter .filter_box button").eq(0).find('.txt-primary').text(totalOfSelectedCategories);
            $(".sub_filter .filter_box button").eq(0).addClass('on');
        }
    } 

    function displaySelectedOrders() {
        $(".sub_filter .filter_box button").eq(1)
            .text($("#filter_align-modal03 .radio-form:checked").siblings('label').text());
    }

    function toggleFilterBox() {
        if($(".modal .check-form:checked").length === 0){
            $(".sub_filter_result").hide();
        } else {
            $(".sub_filter_result").css('display', 'flex');
        }
    }

    window.addEventListener('scroll', function() {
        if ((window.pageYOffset || document.documentElement.scrollTop) + window.innerHeight + 300 >= document.documentElement.scrollHeight && !isLoading && !isLastPage) {
            loadProductList();
        }
    });
    function saveDetail(idx, otherLink){
        sessionStorage.setItem('catalog-top', $(document).scrollTop());
        sessionStorage.setItem('catalog-currentPage', currentPage);
        sessionStorage.setItem('catalog-href', location.href);
        sessionStorage.setItem('catalog-backupItem', $($(".tab_content")[0]).html());

        location.href = '/catalog/{{$data['info']->idx}}/product/detail/' + idx;
    }
    if(localStorage.getItem('p')) {
        if(localStorage.getItem('p') == 1) {
            tabChange($('.bot_quick > button:nth-child(2)'),1);
        }
        localStorage.removeItem('p');
    }

    $(document).on('click', '[id^="filter"] .btn-primary', function() { 
        loadProductList(true, $(this));
    });

    // 카테고리 삭제
    const filterRemove = (item)=>{
        $(item).parents('span').remove(); //해당 카테고리 삭제
        $("#" + $(item).data('id')).prop('checked', false);//모달 안 체크박스에서 check 해제

        loadProductList(true);
    }

    // 초기화
    $(".refresh_btn").on('click', function() {
        $("#filter_category-modal .check-form:checked").prop('checked', false);
        $("#filter_align-modal03 .radio-form").eq(0).prop('checked', true);
        
        loadProductList(true);
    });
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.search_list').length) {
            $('.search_list').hide();
            console.log('hide')
        }
    });
</script>

@include('layouts.modal')
	
<!-- ** 페이지 로딩 ** -->
<div id="loadingContainer">
    <svg width="50" viewBox="0 0 120 30" xmlns="http://www.w3.org/2000/svg" fill="rgb(255, 255, 255)" class="w-10 h-10">
	<circle cx="15" cy="15" r="15">
		<animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate>
		<animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate>
	</circle>
	<circle cx="60" cy="15" r="9" fill-opacity="0.3">
		<animate attributeName="r" from="9" to="9" begin="0s" dur="0.8s" values="9;15;9" calcMode="linear" repeatCount="indefinite"></animate>
		<animate attributeName="fill-opacity" from="0.5" to="0.5" begin="0s" dur="0.8s" values=".5;1;.5" calcMode="linear" repeatCount="indefinite"></animate>
	</circle>
	<circle cx="105" cy="15" r="15">
		<animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate>
		<animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate>
	</circle>
</svg>
</div>
</body>
</html>
