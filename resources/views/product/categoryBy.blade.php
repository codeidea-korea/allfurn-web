@extends('layouts.app')

@section('content')
@include('layouts.header')
<div id="content">
    <section class="sub_section_top">
        <div class="inner">
            
            <div class="line_common_banner  mb-14">
                <ul class="swiper-wrapper">
                    @foreach($banners as $banner)
                        @if($banner->banner_type === 'img')
                            <li class="swiper-slide" style="background-image:url({{ preImgUrl() }}{{$banner->attachment->folder}}/{{$banner->attachment->filename}})">
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
                <div class="count_pager" style="width:auto"><b>1</b> / 12</div>
                <button class="slide_arrow prev type03"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow_white"></use></svg></button>
                <button class="slide_arrow next type03"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow_white"></use></svg></button>
            </div>

            <div class="main_tit mb-8 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>
                        {{$data['category'][0]->parentName}}</h3>
                </div>
            </div>

            <div class="sub_category">
                <ul>
                    <li class="@if($data['selCa'] == null) active @endif"><a href="/product/category?pre={{$data['category'][0]->parent_idx}}">전체</a></li>
                    @foreach($data['category'] as $item)
                        <li class="@if($data['selCa'] == $item->idx) active @endif"><a href="/product/category?ca={{$item->idx}}&pre={{$item->parent_idx}}">{{$item->name}}</a></li>
                    @endforeach
                </ul>
            </div>

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

            @if( count( $propertyList ) > 0 )
            <div class="sub_option">
                <button class="dropdown_btn">속성</button>
                <div class="option_wrap">
                    <div class="option_box">
                        <table>
                            <colgroup>
                                <col width="200px">
                                <col width="*">
                            </colgroup>

                            @if( count( $propertyList ) > 0 )
                            @foreach($propertyList as $key=>$prop)
                            @php $arr = array(); @endphp
                            @if(isset($_GET['prop']))
                                @php $arr = explode('|', $_GET['prop']);@endphp
                            @endif
                            <tr>
                                <th>{{$prop->name}}</th>
                                <td>
                                    <div class="option_list">
                                        @foreach($data['property'] as $item)
                                            @if($prop->idx == $item->parent_idx)
                                        <button data-property_idx="{{$item->idx}}">{{$item->property_name}}</button>
                                            @endif
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </table>
                    </div>
                    <div class="sub_filter_result">
                        <div class="filter_on_box">
                            <div class="category">
                            </div>
                        </div>
                        <button class="refresh_btn">초기화 <svg><use xlink:href="/img/icon-defs.svg#refresh"></use></svg></button>
                    </div>
                </div>
            </div>
            @endif

            @if($data['list']->total() >0)
            <div class="sub_filter">
                <div class="total">전체 {{number_format( $data['list']->total() )}}개</div>
                <div class="filter_box">
                    <button onclick="modalOpen('#filter_align-modal02')">신상품순</button>
                </div>
            </div>
            <div class="relative">
                <ul class="prod_list">
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
                </ul>
            </div>
            @endif
        </div>
    </section>
</div>

<script>
    const line_common_banner = new Swiper(".line_common_banner", {
        slidesPerView: 1,
        spaceBetween: 0,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".line_common_banner .slide_arrow.next",
            prevEl: ".line_common_banner .slide_arrow.prev",
        },
        pagination: {
            el: ".line_common_banner .count_pager",
            type: "fraction",
        }
    });
    $('.line_common_banner').hover(function(){
        line_common_banner.autoplay.stop();
    }, function(){
        line_common_banner.autoplay.start();
    });


    $(document).ready(function(){
        urlSearch = new URLSearchParams(location.search);
        
        urlSearch.get('so');
        console.log(urlSearch.get('so'))
        $('#filter_align-modal02 input[value="'+ urlSearch.get('so') +'"]').prop('checked', true);
        $(".sub_filter .filter_box button").text($("#filter_align-modal02 .radio-form:checked").siblings('label').text());
    })

    // 카테고리 클릭시
    $('.sub_category li').on('click',function(){
        $(this).addClass('active').siblings().removeClass('active')
    })

    // 속성 선택시
    $('.sub_option .dropdown_btn').on('click',function(){

        const URLSearch = new URLSearchParams(location.search);
        if( URLSearch.get('prop') != null ) {
            $('.option_wrap .sub_filter_result .category').empty();
            
            var prop = URLSearch.get('prop').split('|');
            $.each(prop, function (index, value) {
                $('[data-property_idx="' + value + '"]').addClass('active');

                let txt = $('[data-property_idx="' + value + '"]').text();
                let num = value;
                $('.option_wrap .sub_filter_result .category').append(`<span>${txt} <button data-num="${num}" onclick="optionRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button></span>`)

                // 선택옵션 보이게
                $('.option_wrap .sub_filter_result').addClass('active');
            });
        }

        $(this).toggleClass('active')
        $(this).parent('.sub_option').toggleClass('active')
    })

    // 옵션클릭시
    let optionNum = 0
    $(document)
        .on('click','.option_list button',function(){
            if($(this).hasClass('active')){
                $(this).removeClass('active')
                optionNum -= 1;

                let num = $(this).data('property_idx')
                $('.option_wrap .sub_filter_result .category').find(`button[data-num="${num}"]`).parent().remove();
            }else{
                $(this).addClass('active')
                optionNum += 1;

                // 옵션보이기
                $('.option_wrap .sub_filter_result').addClass('active')

                let txt = $(this).text();
                let num = $(this).data('property_idx')
                $('.option_wrap .sub_filter_result .category').append(`<span>${txt} <button data-num="${num}" onclick="optionRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button></span>`)
            }

            locationGo();
        })
        .on('click', '#filter_align-modal02 .btn-primary', function() {
            locationGo();
        })
    ;

    // 옵션초기화
    $('.option_wrap .refresh_btn').on('click',function()
    {
        $('.option_list > button').removeClass('active');
        $('.option_wrap .sub_filter_result').removeClass('active');

        locationGo();
    })

    // 필터 아이템 제거
    const optionRemove = (item)=>{
        let num = $(item).data('num')
        $(item).parents('span').remove()
        $('.sub_option .option_box .option_list').find(`button[data-property_idx="${num}"]`).removeClass('active')

        locationGo();
    }

    function locationGo() {
        var prop = '';

        $('.option_list > button').each(function() {
            if( $(this).hasClass('active') === true ) {
                prop += $(this).data('property_idx') + "|";
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

    // 카테고리 정열
    function getIndexesOfSelectedCategory() {
        let categories = [];
        $("#filter_category-modal02 .check-form:checked").each(function(){
            categories.push($(this).attr('id'));
        });

        return categories;
    }

    window.addEventListener('scroll', function() {
        if ((window.pageYOffset || document.documentElement.scrollTop) + window.innerHeight + 800 >= document.documentElement.scrollHeight && !isLoading && !isLastPage) {
            loadProductList();
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
                loadProductList();
            }, 50);
        }
        sessionStorage.removeItem('af2-backupItem');
        sessionStorage.removeItem('af2-top');
        sessionStorage.removeItem('af2-currentPage');
        sessionStorage.removeItem('af2-refurl');
    }

    let isLoading = false;
    let isLastPage = {{$data['list']->lastPage()}} == 1;
    let currentPage = 1;
    function loadProductList() {
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
                console.log(result);

                displayProductList(result.query, $(".relative ul.prod_list"), false);

                isLastPage = currentPage === result.query.last_page;
            },
            complete : function () {
                isLoading = false;
            }
        })
    }


    function displayProductList(productArr, target, needsEmptying) {
        if(needsEmptying) {
            target.empty();
        }

        let html = "";
        productArr.data.forEach(function(product, index) {
            html += '' +
                '<li class="prod_item">' +
                '   <div class="img_box">' +
                '       <a href="javascript:saveDetail(' + product.idx + ')"><img src="' + product.imgUrl + '" alt=""></a>' +
                '       <button class="zzim_btn prd_' + product.idx + ' ' + (product.isInterest== 1 ? 'active' : '')   +'" pidx="' + product.idx + '"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>' +
                '   </div>' +
                '   <div class="txt_box">' +
                '       <a href="./prod_detail.php">' +
                '           <span>' + product.companyName + '</span>' +
                '           <p>' + product.name + '</p>' +
                '           <b>';
            if (product.is_price_open == 1) {
                html += product.price.toLocaleString('ko-KR') + '원';
            } else {
                html += (product.price_text.replace('가격 안내 문구 선택','업체 문의'));
            }
            html += '' +
                '</b>' +
                '       </a>' +
                '   </div>' +
                '</li>'
        });

        target.append(html);
    }
</script>
@endsection

