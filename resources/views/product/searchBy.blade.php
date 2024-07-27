@extends('layouts.app')

@section('content')
@include('layouts.header')
    <div id="content">
        <section class="sub">
            <div class="inner">
                <div class="main_tit mb-8 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <h3><span class="font-base">‘{{$_GET['kw']}}'</span>검색결과</h3>
                    </div>
                </div>
                <div class="sub_category">
                    <ul>
                        <li class="active"><a href="javascript:(0);">상품</a></li>
                        <li><a href="/wholesaler/search?kw={{$_GET['kw']}}">업체</a></li>
                    </ul>
                </div>
                <div class="sub_filter">
                    <div class="filter_box">
                        <button class="" onclick="modalOpen('#filter_category-modal')">카테고리 <b class="txt-primary"></b></button>
                        <button class="" onclick="modalOpen('#filter_location-modal')">소재지 <b class="txt-primary"></b></button>
                    </div>
                </div>
                <div class="sub_filter_result hidden">
                    <div class="filter_on_box">
                        <div class="category">
                            <span>소파/거실 <button onclick="filterRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button></span>
                            <span>식탁/의자 <button onclick="filterRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button></span>
                            <span>수납/서랍장/옷장 <button onclick="filterRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button></span>
                        </div>
                        <div class="location">
                            <span>인천 <button onclick="filterRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button></span>
                            <span>광주 <button onclick="filterRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button></span>
                        </div>
                    </div>
                    <button class="refresh_btn">초기화 <svg><use xlink:href="/img/icon-defs.svg#refresh"></use></svg></button>
                </div>

                <div class="sub_filter mt-5">
                    <div class="total"><span>‘{{$_GET['kw']}}'</span> 검색 결과 총 0개의 상품</div>
                    <div class="filter_box">
                        <button onclick="modalOpen('#filter_align-modal02')">최신 상품 등록순</button>
                    </div>
                </div>
                <div class="relative">
                    <ul class="prod_list"></ul>
                </div>
            </div>
        </section>
    </div>

    <script>
    let isLoading = false;
    let isLastPage = false;
    let currentPage = 0;
    let firstLoad = true;

    function loadNewProductList(needEmpty, target) {
        if(isLoading) return;
        if(!needEmpty && isLastPage) return;

        $("#zoom_view-modal-new .slide_arrow.more_btn").hide();
        isLoading = true;
        if(needEmpty) currentPage = 0;
        $('#loadingContainer').show();
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/product/getSearchList',
            method: 'GET',
            data: { 
                'keyword' : "{{$_GET['kw']}}",
                'page': ++currentPage,
                'categories' : getIndexesOfSelectedCategory().join(','),
                'locations' : getIndexesOfSelectedLocation().join(','),
                'orderedElement' : $("#filter_align-modal02 .radio-form:checked").val(),
            }, 
            beforeSend : function() {
                if(target) {
                    target.prop("disabled", true);
                }
            },
            success: function(result) {
                console.log(result)
                if(needEmpty) {
                    $(".prod_list").empty();
                }
                $(".prod_list").append(result.data.html);
                $(".total").text('전체 ' + result.total.toLocaleString('ko-KR') + '개');

                if(target) {
                    target.prop("disabled", false);
                    modalClose('#' + target.parents('[id^="filter"]').attr('id'));
                }

                isLastPage = currentPage === result.last_page;
            }, 
            complete : function () {
                displaySelectedCategories();
                displaySelectedLocation();
                displaySelectedOrders();
                toggleFilterBox();
                isLoading = false;
                if(firstLoad && new URLSearchParams(window.location.search).get("scroll")=="true") {
                    window.scrollTo(0, 2100);
                    firstLoad = false;
                }
                $('#loadingContainer').hide();
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

    function getIndexesOfSelectedLocation() {
        let locations = [];
        $("#filter_location-modal .check-form:checked").each(function(){
            locations.push($(this).data('location'));
        });
        return locations;
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

    function displaySelectedLocation() {
        let html = "";

        $("#filter_location-modal .check-form:checked").each(function() {
            html += '<span>'+ $(this).data('location') + 
                    '   <button data-id="'+ $(this).attr('id') +'" onclick="filterRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button>' +
                    '</span>';
        });
        $(".filter_on_box .location").empty().append(html);

        let totalOfSelectedLocations = $("#filter_location-modal .check-form:checked").length;
        if(totalOfSelectedLocations === 0) {
            $(".sub_filter .filter_box button").eq(1).find('.txt-primary').text("");
            $(".sub_filter .filter_box button").eq(1).removeClass('on');
            
        } else {
            $(".sub_filter .filter_box button").eq(1).find('.txt-primary').text(totalOfSelectedLocations);
            $(".sub_filter .filter_box button").eq(1).addClass('on');
        }
    }    

    function displaySelectedOrders() {
        // if($("#filter_align-modal02 .radio-form:checked").val() != "reg_time") {
        //     $(".sub_filter .filter_box button").eq(2).addClass('on')         
        // } else {
        //     $(".sub_filter .filter_box button").eq(2).removeClass('on')
        // }
        $(".sub_filter .filter_box button").eq(2).text($("#filter_align-modal02 .radio-form:checked").siblings('label').text());
    }

    function toggleFilterBox() {
        if($(".modal .check-form:checked").length === 0 && ($("#filter_align-modal02 .radio-form:checked").val() == "reg_time" || $("#filter_align-modal02 .radio-form:checked").val() == "search" || $("#filter_align-modal02 .radio-form:checked").val() == "order")){
            $(".sub_filter_result").hide();
        } else {
            $(".sub_filter_result").css('display', 'flex');
        }
    }

    // 카테고리 선택
    $(document).on('click', '[id^="filter"] .btn-primary', function() { 
        loadNewProductList(true, $(this));
    });

    // 카테고리 삭제
    const filterRemove = (item)=>{
        $(item).parents('span').remove(); //해당 카테고리 삭제
        $("#" + $(item).data('id')).prop('checked', false);//모달 안 체크박스에서 check 해제

        loadNewProductList(true);
    }

    // 정렬 삭제
    const orderRemove = (item)=> {
        $(item).parents('span').remove(); 
        $("#filter_align-modal02 .radio-form").eq(0).prop('checked', true);

        loadNewProductList(true);
    }

    // 초기화
    $(".refresh_btn").on('click', function() {
        $("#filter_category-modal .check-form:checked").prop('checked', false);
        $("#filter_location-modal .check-form:checked").prop('checked', false);
        $("#filter_align-modal02 .radio-form").eq(0).prop('checked', true);
        loadNewProductList(true);
    });

    $(document).ready(function(){
        $('#loadingContainer').show();
        setTimeout(() => {
            loadNewProductList(true);
            $("#filter_location-modal .btn-primary").text('상품 찾아보기');
        }, 50);
    })

    window.addEventListener('scroll', function() {
        if ((window.pageYOffset || document.documentElement.scrollTop) + window.innerHeight + 300 >= document.documentElement.scrollHeight && !isLoading && !isLastPage) {
            loadNewProductList(true);
        }
    });

    $(window).on('load', function(){
        $('#loadingContainer').hide();
    });
    </script>
@endsection
