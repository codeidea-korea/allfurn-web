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
                            <a href="/product/new">올펀 상품 보러가기</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </section>
    </div>

    <!-- 옵션 선택 -->
    @php
        $propertyList = [];
        foreach($data['property'] as $item) {
            if ($item['name'] != null) {
                $item['list'] = [];
                array_push($propertyList, $item);
            }
        }
        $selectedFilterList = [];
    @endphp
    <div class="modal" id="option-modal">
        <div class="modal_bg" onclick="modalClose('#option-modal')"></div>
        <div class="modal_inner modal-md">
            <button class="close_btn" onclick="modalClose('#option-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body filter_body">
                <h4>속성</h4>
                <div class="sub_category type02 mt-3">
                    <ul class="prod_property_tab">
                        @if( count( $propertyList ) > 0 )
                            @foreach($propertyList as $key=>$prop)
                                @php $arr = array(); @endphp
                                @if(isset($_GET['prop']))
                                    @php $arr = explode('|', $_GET['prop']);@endphp
                                @endif
                           
                                <li class="{{$loop->index == 0 ? 'active' : ''}}"><a href="javascript:;">{{$prop->name}}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <div class="category_tab prod_property_cont">
                    @if( count( $propertyList ) > 0 )
                            @foreach($propertyList as $key=>$prop)
                                @php $arr = array(); @endphp
                                @if(isset($_GET['prop']))
                                    @php $arr = explode('|', $_GET['prop']);@endphp
                                @endif
                           
                                <div class="{{$loop->index == 0 ? 'active' : ''}}">
                                    <ul class="filter_list">
                                        @foreach($data['property'] as $item)
                                            @if($prop->idx == $item->parent_idx)
                                                <li>
                                                    <input type="checkbox" class="check-form" data-property-idx="{{$item->idx}}" id="option_{{$loop->parent->index}}_{{$loop->index}}">
                                                    <label for="option_{{$loop->parent->index}}_{{$loop->index}}">{{$item->property_name}}</label>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        @endif
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
    let isLastPage = {{$data['list']->lastPage()}} == 1;
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
        /* $('#option-modal .sub_property_area').each(function(o){
            if ($('#option-modal .sub_property_area:eq('+o+') .check-form:checked').length > 0){
                $('#option-modal .sub_property_area:eq('+o+') .check-form:checked').map(function (n, i) {
                    prop += $(this).data('sub_property') + "|";
                })
            }
        }); */

        $("#option-modal .prod_property_cont li input:checked").each(function(e) {
            prop += $(this).data('property-idx') + "|"
        }) 

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
        if (urlSearch.get('prop') != null) {
            property = urlSearch.get('prop');
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
                '       <a href="javascript:saveDetail(' + product.idx + ')"><img src="' + product.imgUrl + '" alt="' + product.name + '"></a>' +
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
        /* if ($(this).has('.btn-primary')) {
            var htmlText = "";
            $('#option-modal .sub_property_area').each(function(o){
                if ($('#option-modal .sub_property_area:eq('+o+') .check-form:checked').length > 0){
                    $('#option-modal .sub_property_area:eq('+o+') .check-form:checked').map(function (n, i) {
                        htmlText += '<span data-sub_idx="' + $(this).data('sub_property') + '">' + $(this).data('sub_name') + ' <button class="ico_delete"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button></span>'
                    })
                }
            });
            locationGo();
        } */
        locationGo();
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
        if ($(window).scrollTop() + $(window).height() + 800 >= $(document).height() && !isLoading && !isLastPage) {
            loadNewProductList();
        }
    });

    function saveDetail(idx, otherLink){
        sessionStorage.setItem('af2-top', $(document).scrollTop());
        sessionStorage.setItem('af2-currentPage', currentPage);
        sessionStorage.setItem('af2-href', location.href);
        sessionStorage.setItem('af2-backupItem', $($(".prod_list")[0]).html());

        if(otherLink) {
            location.href=otherLink;
        } else {
            location.href='/product/detail/' + idx;
        }
    }
    window.onpageshow = function(ev) {
        if(sessionStorage.getItem("af2-backupItem") && location.href == sessionStorage.getItem("af2-href")){
            $($(".prod_list")[0]).html(sessionStorage.getItem("af2-backupItem"));
            $(document).scrollTop(sessionStorage.getItem("af2-top"));
            currentPage = sessionStorage.getItem("af2-currentPage");
        } else {
            
            setTimeout(() => {
                loadNewProductList();
            }, 50);
        }
        sessionStorage.removeItem('af2-backupItem');
        sessionStorage.removeItem('af2-top');
        sessionStorage.removeItem('af2-currentPage');
        sessionStorage.removeItem('af2-refurl');
    }

    $(document).ready(function(){
        urlSearch = new URLSearchParams(location.search);
        urlSearch.get('so');
        $('#filter_align-modal02 input[value="'+ urlSearch.get('so') +'"]').prop('checked', true);
        $(".sub_filter .filter_box button:eq(0)").text($("#filter_align-modal02 .radio-form:checked").siblings('label').text());

        // getProperty();
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
        displaySelectedProperty();   
    })

    function displaySelectedProperty() {
        if(!new URLSearchParams(location.search).has('prop')) return;

        const selectedPropertyArr = new URLSearchParams(location.search).get('prop').split('|');
        console.log(selectedPropertyArr);

        $("#option-modal .prod_property_cont li input").each(function(){
            if(selectedPropertyArr.includes($(this).data('property-idx').toString())){
                $(this).prop('checked', true);
            }
        })
    }

    </script>
@endsection