@extends('layouts.app_m')
@php
    $only_quick = '';
    $header_depth = 'prodlist';
    $top_title = $data['category'][0]->parentName;
    $header_banner = '';
@endphp
@section('content')
@include('layouts.header_m')
    <div id="content">
        <section class="sub_section sub_section_top thismonth_con01">
            <div class="line_common_banner">
                <ul class="swiper-wrapper">
                    @foreach($banners as $banner)
                        {{-- {{$banner}} --}}
                        @if($banner->banner_type === 'img')
                            <li class="swiper-slide" style="background-image:url({{ $banner->appBigImgUrl }})">
                                <a href="{{ strpos($banner->web_link, 'help/notice') !== false ? '/help/notice/' : $banner->web_link }}"></a>
                            </li>
                        @else
                            <li class="swiper-slide" style="background-color:{{$banner->bg_color}};">
                                <a href="{{ strpos($banner->web_link, 'help/notice') !== false ? '/help/notice/' : $banner->web_link }}">
                                    <div class="txt_box type02" style="color:{{ $banner->font_color }};">
                                        <p>{{ $banner->subtext1 }}<br/>{{ $banner->subtext2 }}</p>
                                        <span>{{ $banner->content }}</span>
                                    </div>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <div class="count_pager"><b>1</b> / 12</div>
            </div>
        </section>

        <section class="sub">
            <div class="inner">
                <div class="sub_category">
                    <ul>
                        <li class="@if($data['selCa'] == null) active @endif"><a href="/product/category?pre={{$data['category'][0]->parent_idx}}">전체</a></li>
                        @foreach($data['category'] as $item)
                        <li class="@if($data['selCa'] == $item->idx) active @endif"><a href="/product/category?ca={{$item->idx}}&pre={{$item->parent_idx}}">{{$item->name}}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="sub_filter">
                    <div class="filter_box">
                        <button onclick="modalOpen('#filter_align-modal02')">신상품순</button>
                        <button class="optionDrop" onclick="modalOpen('#option-modal')">속성 <b class="txt-primary"></b></button>
                        <button class="refresh_btn" onclick="optionReset()">초기화 <svg><use xlink:href="/img/icon-defs.svg#refresh"></use></svg></button>
                    </div>
                    <div class="total">전체 {{number_format( $data['list']->total())}}개</div>
                </div>
                <div class="sub_filter_result hidden">
                    <div class="filter_on_box">
                        <div class="category checkedProperties">
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <ul class="prod_list">
                        @if($data['list']->total() >0)
                        @foreach( $data['list'] AS $item )
                        <li class="prod_item">
                            <div class="img_box">
                                <a href="/product/detail/{{$item->idx}}"><img src="{{ isset($item->imgUrl) ? $item->imgUrl : '' }}" alt=""></a>
                                <button class="zzim_btn prd_{{$item->idx}} {{ ($item->isInterest == 1) ? 'active' : '' }}" pidx="{{$item->idx}}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="/product/detail/{{$item->idx}}">
                                    <span>{{$item->companyName}}</span>
                                    <p>{{$item->name}}</p>
                                    <b>
                                        @if( $item->is_price_open == 1 )
                                            {{number_format( $item->price )}}
                                        @else
                                            {{$item->price_text}}
                                        @endif
                                    </b>
                                </a>
                            </div>
                        </li>
                        @endforeach
                        @else
                        <li class="no_prod txt-gray">
                            <i><svg><use xlink:href="/img/icon-defs.svg#Search"></use></svg></i>
                            카테고리 상품 결과가 없습니다.
                            <a href="javascript:;">올펀 상품 보러가기</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </section>
    </div>

    <!-- 옵션 선택 -->
    <div class="modal" id="option-modal">
        <div class="modal_bg" onclick="modalClose('#option-modal')"></div>
        <div class="modal_inner modal-md">
            <button class="close_btn" onclick="modalClose('#option-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body filter_body">
                <h4>속성</h4>
                <div class="sub_category type02 mt-3">
                    <ul class="prod_property_tab">
                        <li class="active"><a href="javascript:;">사이즈</a></li>
                        <li><a href="javascript:;">프레임형태</a></li>
                        <li><a href="javascript:;">소재</a></li>
                        <li><a href="javascript:;">헤드형태</a></li>
                        <li><a href="javascript:;">색상</a></li>
                        <li><a href="javascript:;">깔판형태</a></li>
                        <li><a href="javascript:;">원산지</a></li>
                    </ul>
                </div>
                <div class="category_tab prod_property_cont">
                    <div class="active">
                        <ul class="filter_list">
                            <li>
                                <input type="checkbox" class="check-form" id="option_1_1">
                                <label for="option_1_1">싱글</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="option_1_2">
                                <label for="option_1_2">슈퍼싱글</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="option_1_3">
                                <label for="option_1_3">더블</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="option_1_4">
                                <label for="option_1_4">퀸</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="option_1_5">
                                <label for="option_1_5">킹</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="option_1_6">
                                <label for="option_1_6">라지킹</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="option_1_7">
                                <label for="option_1_7">기타</label>
                            </li>
                            <li>
                                <input type="checkbox" class="check-form" id="option_1_8">
                                <label for="option_1_8">패밀리</label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="btn_bot">
                    <button class="btn btn-line3 refresh_btn" onclick="optionRefresh(this)"><svg><use xlink:href="/img/icon-defs.svg#refresh"></use></svg>초기화</button>
                    <button class="btn btn-primary full confirm_prod_property">선택 완료</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    const line_common_banner = new Swiper(".line_common_banner", {
        slidesPerView: 1,
        spaceBetween: 0,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".line_common_banner .count_pager",
            type: "fraction",
        }
    });

    let isLoading = false;
    let isLastPage = false;
    let currentPage = 1;

    // 카테고리 클릭시
    $('.sub_category li').on('click',function(){
        $(this).addClass('active').siblings().removeClass('active')
    })

    $('.sub_category.type02 li').on('click',function(){
        let liN = $(this).index();
        $(this).addClass('active').siblings().removeClass('active')
        $('.category_tab > div').eq(liN).addClass('active').siblings().removeClass('active')
    })

    function locationGo() {
        var prop = '';
        $('#option-modal .sub_property_area').each(function(o){
            if ($('#option-modal .sub_property_area:eq('+o+') .check-form:checked').length > 0){
                $('#option-modal .sub_property_area:eq('+o+') .check-form:checked').map(function (n, i) {
                    prop += $(this).data('sub_property') + "|";
                })
            }
        });

        url = '/product/category?';
        urlSearch = new URLSearchParams(location.search);
        if (urlSearch.get('ca') != null) {
            url += 'ca='+urlSearch.get('ca');
        }
        if (urlSearch.get('pre') != null) {
            url += '&pre='+urlSearch.get('pre');
        }

        if( $('input[name="filter_cate_2"]').is(':checked') == true ) {
            url += '&so=' +  $("#filter_align-modal02 .radio-form:checked").val();
        }

        location.replace(url+'&prop='+prop.slice(0, -1));
    }

    // 정렬 선택시
    $(document).on('click', '#filter_align-modal02 .btn-primary', function() {
        locationGo();
    });

    const optionRefresh = (item)=>{
        $(item).parents('.filter_body').find('input').each(function(){
            $(this).prop("checked",false);
        });
    }

    const optionReset = ()=>{
        url = '/product/category?';
        urlSearch = new URLSearchParams(location.search);
        if (urlSearch.get('ca') != null) {
            url += 'ca='+urlSearch.get('ca');
        }
        if (urlSearch.get('pre') != null) {
            url += '&pre='+urlSearch.get('pre');
        }
        location.replace(url);
    }

    function loadNewProductList() {
        if(isLoading) return;
        if(isLastPage) return;

        isLoading = true;

        var categories = '';
        var parents = '';
        let property = '';
        var orderedElement = '';
        urlSearch = new URLSearchParams(location.search);
        if (urlSearch.get('ca') != null) {
            categories = urlSearch.get('ca');
        }
        if (urlSearch.get('pre') != null) {
            parents = urlSearch.get('pre');
        }

        if( $('input[name="filter_cate_2"]').is(':checked') == true ) {
            orderedElement = $("#filter_align-modal02 .radio-form:checked").val();
        }

        $('#loadingContainer').show();
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/product/getJsonListByCategory',
            method: 'GET',
            data: {
                'page': ++currentPage,
                'ca' : categories,
                'pre' : parents,
                'prop' : property,
                'so' : orderedElement,
            },
            success: function(result) {

                displayNewWholesaler(result.query, $(".relative ul.prod_list"), false);

                isLastPage = currentPage === result.last_page;
            },
            complete : function () {
                isLoading = false;
                $('#loadingContainer').hide();
            }
        })
    }

    function displayNewWholesaler(productArr, target, needsEmptying) {
        if(needsEmptying) {
            target.empty();
        }

        let html = "";
        productArr.data.forEach(function(product, index) {

            html += '' +
                '<li class="prod_item">' +
                '   <div class="img_box">' +
                '       <a href="/product/detail/' + product.idx + '"><img src="' + product.imgUrl + '" alt="' + product.name + '"></a>' +
                '           <button class="zzim_btn prd_' + product.idx + '" pidx="' + product.idx + '"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>' +
                '   </div>' +
                '   <div class="txt_box">' +
                '       <a href="/product/detail/{{$item->idx}}">' +
                '           <span>' + product.companyName + '</span>' +
                '           <p>' + product.name + '</p>' +
                '           <b>';
            if (product.is_price_open == 1) {
                html += product.price.toLocaleString('ko-KR') + '원';
            } else {
                html += product.price_text;
            }
            html += '' +
                '           </b>' +
                '       </a>' +
                '   </div>' +
                '</li>';
        });

        target.append(html);
    }

    // 속성 가져오기
    function getProperty() {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url				: '/product/getCategoryProperty',
            data			: {
                'category_idx' : getUrlVars()["ca"],
                'parent_idx' : null
            },
            type			: 'POST',
            dataType		: 'json',
            success		: function(result) {
                var _active = "";
                var htmlText = '';
                $('#option-modal .prod_property_cont').html('');
                result.forEach(function (e, idx) {
                    if( idx == 0 ) { _active = 'active'; } else { _active = ''; }
                    htmlText += '<li class="' + _active + '" data-property_idx=' + e.idx+ '><button>' + e.name + '</button></li>';
                    getSubProperty(e.idx, e.name, idx);
                });
                $('#option-modal .prod_property_tab').html(htmlText);
            }
        });
    }

    // 속성 가져오기2
    function getSubProperty(parentIdx=null, title=null, ord=null) {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url				: '/product/getCategoryProperty',
            data			: {
                'category_idx' : getUrlVars()["ca"],
                'parent_idx' : parentIdx
            },
            type			: 'POST',
            dataType		: 'json',
            success		: function(result) {
                var _active = "";
                if( ord == 0 ) { _active = 'active'; } else { _active = ''; }
                var subHtmlText = '<div class="sub_property_area ' + _active + ' property_idx_' + parentIdx + '" data-title="' + title + '"><ul class="filter_list">';
                result.forEach(function (e, idx) {
                    subHtmlText += '<li>' +
                        '<input type="checkbox" class="check-form" id="property-check_' + e.idx + '" data-sub_property="' + e.idx + '" data-sub_name="' + e.property_name + '">' +
                        '<label for="property-check_' + e.idx + '">' + e.property_name + '</label>' +
                        '</li>';
                })
                subHtmlText += '</ul></div>';
                $('#option-modal .prod_property_cont').append(subHtmlText);
            }
        });
    }

    //### 상품등록 > 속성 모달
    $(document).on('click', '#option-modal .prod_property_tab li', function() {
        console.log(1)
        let liN = $(this).data('property_idx'); //')$(this).index();
        $(this).addClass('active').siblings().removeClass('active')
        $('.prod_property_cont > div.property_idx_'+liN).addClass('active').siblings().removeClass('active')
    })

    //### 속성 선택완료
    $(document).on('click', '.confirm_prod_property', function() {
        if ($(this).has('.btn-primary')) {
            var htmlText = "";
            $('#option-modal .sub_property_area').each(function(o){
                if ($('#option-modal .sub_property_area:eq('+o+') .check-form:checked').length > 0){
                    $('#option-modal .sub_property_area:eq('+o+') .check-form:checked').map(function (n, i) {
                        htmlText += '<span data-sub_idx="' + $(this).data('sub_property') + '">' + $(this).data('sub_name') + ' <button class="ico_delete"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button></span>'
                    })
                }
            });
            locationGo();
        }
    })

    //### 선택한 상품속성 값 삭제
    $(document).on('click', '.ico_delete', function() {
        var this_sub_idx = $(this).parent().data('sub_idx');
        var this_property_length = $(this).parent().parent().children('div').length;
        if (this_property_length == 1){
            $(this).parent().parent().parent().remove();
        }else{
            $(this).parent().remove();
        }
        $('#option-modal #property-check_'+this_sub_idx).attr('checked', false);
    });

    function getUrlVars(){
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++){
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }

    $(window).scroll(function() {
        if ($(window).scrollTop() + $(window).height() + 20 >= $(document).height() && !isLoading && !isLastPage) {
            loadNewProductList();
        }
    });

    $(document).ready(function(){
        urlSearch = new URLSearchParams(location.search);
        urlSearch.get('so');
        $('#filter_align-modal02 input[value="'+ urlSearch.get('so') +'"]').prop('checked', true);
        $(".sub_filter .filter_box button:eq(0)").text($("#filter_align-modal02 .radio-form:checked").siblings('label').text());

        getProperty();
        $('#loadingContainer').show();

        setTimeout(function () {
            let get_parameter_prop = getUrlVars()["prop"];
            if (typeof(get_parameter_prop) != 'undefined'){
                var arr_prop = get_parameter_prop.split('|');
                arr_prop.map(function (item) {
                    $('#option-modal .sub_property_area').each(function(o){
                        $('#option-modal .sub_property_area:eq('+o+') .check-form').map(function (n, i) {
                            if ($(this).data('sub_property') == item) { $(this).prop('checked', true); }
                        });
                    });
                });

                var htmlText = "";
                var property_cnt = 0;
                $('#option-modal .sub_property_area').each(function(o){
                    if ($('#option-modal .sub_property_area:eq('+o+') .check-form:checked').length > 0){
                        $('#option-modal .sub_property_area:eq('+o+') .check-form:checked').map(function (n, i) {
                            property_cnt++;
                            htmlText += '<span data-sub_idx="' + $(this).data('sub_property') + '">' + $(this).data('sub_name') + ' <button class="ico_delete"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button></span>'
                        })
                    }
                });
                if (property_cnt > 0) {
                    $('.optionDrop').addClass('on');
                    $('.optionDrop b.txt-primary').html(property_cnt);
                    $('.checkedProperties').html(htmlText);
                    $('.sub_filter_result').show();
                }
            }
            $('#loadingContainer').hide();
        }, 500);
        
    })
    </script>
@endsection