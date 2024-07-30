@extends('layouts.app_m')
@php
    $only_quick = '';
    $header_depth = 'prodlist';
    $top_title = $_GET['kw'];
    $header_banner = '';
@endphp
@section('content')
    @include('layouts.header_m')
    <div id="content">
        <section class="sub !pt-0">
            <div class="sub_category !pb-0 !mb-0">
                <ul>
                    <li class="active w-full"><a class="inline-block w-full py-3 text-center" href="javascript:void(0);">상품</a></li>
                    <li class="w-full"><a class="inline-block w-full py-3 text-center" href="/wholesaler/search?kw={{$_GET['kw']}}">업체</a></li>
                </ul>
            </div>
            <div class="bg-stone-100 px-[18px] py-3">
                <p class="text-stone-400"><span>"{{$_GET['kw']}}"</span> 검색 결과 총 <span class="total">0</span>개의 상품</p>
            </div>
            <div class="sub_filter px-[18px] mt-3">
                <div class="filter_box">
                    <button onclick="modalOpen('#filter_category-modal')">카테고리</button>
                    <button onclick="modalOpen('#filter_location-modal')">소재지</button>
                    <button onclick="modalOpen('#filter_align-modal02')">최신 상품 등록순</button>
                    <button class="refresh_btn">초기화 <svg><use xlink:href="/img/icon-defs.svg#refresh"></use></svg></button>
                </div>
            </div>
            <div class="inner mt-3">
                <div class="relative">
                    <ul class="prod_list">
                        
                    </ul>
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
                if(needEmpty) {
                    $(".prod_list").empty();
                }
                $(".prod_list").append(result.data.html);
                $(".total").html(result.total.toLocaleString('ko-KR'));

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
                isLoading = false;
                if(firstLoad && new URLSearchParams(window.location.search).get("scroll")=="true") {
                    window.scrollTo(0, 1430);
                    firstLoad = false;
                }
                $('#loadingContainer').hide();
            }
        })
    }

    // 필터링으로 신규등록 상품 조회
    $(document).on('click', '[id^="filter"] .btn-primary', function() { 
        loadNewProductList(true, $(this));
    });

    //초기화
    $(".refresh_btn").on('click', function() {
        $("#filter_category-modal .check-form:checked").prop('checked', false);
        $("#filter_location-modal .check-form:checked").prop('checked', false);
        $("#filter_align-modal02 .radio-form").eq(0).prop('checked', true);
        
        loadNewProductList(true);
    });

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
        $(".sub_filter .filter_box button").eq(2).text($("#filter_align-modal02 .radio-form:checked").siblings('label').text());
    }

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