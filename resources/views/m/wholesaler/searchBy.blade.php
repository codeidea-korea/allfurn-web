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
                    <li class="w-full"><a class="inline-block w-full py-3 text-center" href="/product/search?kw={{$_GET['kw']}}&kp=P">상품</a></li>
                    <li class="active w-full"><a class="inline-block w-full py-3 text-center" href="javascript:(0);">업체</a></li>
                </ul>
            </div>
            <div class="bg-stone-100 px-[18px] py-3">
                <p class="text-stone-400"><span>"{{$_GET['kw']}}"</span> 검색 결과 총 <span class="total">0</span>개의 도매업체</p>
            </div>
            <div class="sub_filter px-[18px] mt-3">
                <div class="filter_box">
                    <button onclick="modalOpen('#filter_category-modal')">카테고리</button>
                    <button onclick="modalOpen('#filter_location-modal')">소재지</button>
                    <button onclick="modalOpen('#filter_align-modal02')">최신 상품 등록순</button>
                    <button class="refresh_btn">초기화 <svg><use xlink:href="/img/icon-defs.svg#refresh"></use></svg></button>
                </div>
            </div>

            <ul class="obtain_list type02">
            </ul>
        </section>
    </div>

    <script>
    let isLoading = false;
    let isLastPage = false;
    let currentPage = 0;
    function loadWholesalerList(needEmpty, target) {
        if(isLoading) return;
        if(!needEmpty && isLastPage) return;
        isLoading = true;
        if(needEmpty) currentPage = 0;
        $('#loadingContainer').show();
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/wholesaler/getSearchList',
            method: 'GET',
            data: {
                'keyword' : "{{$_GET['kw']}}",
                'page': ++currentPage,
                'categories' : getIndexesOfSelectedCategory().join(','),
                'locations' : getIndexesOfSelectedLocations().join(','),
                'orderedElement' : $("#filter_align-modal02 .radio-form:checked").val(),
            },
            beforeSend : function() {
                if(target) {
                    target.prop("disabled", true);
                }
            },
            success: function(result) {
                console.log(result);
                if(needEmpty) {
                    $(".obtain_list").empty();
                }
                $(".obtain_list").append(result.data.html);
                $(".total").text(result.total.toLocaleString('ko-KR'));

                if(target) {
                    target.prop("disabled", false);
                    modalClose('#' + target.parents('[id^="filter"]').attr('id'));
                }

                isLastPage = currentPage === result.last_page;
                $('#loadingContainer').hide();
            },
            complete : function () {
                displaySelectedCategories();
                displaySelectedLocation();
                displaySelectedOrders();
                isLoading = false;
                $('#loadingContainer').hide();
            }
        })
    }

    // 카테고리 및 소팅
    $(document).on('click', '[id^="filter"] .btn-primary', function() {
        loadWholesalerList(true, $(this))
    });

    $(".refresh_btn").on('click', function() {
        $("#filter_category-modal .check-form:checked").prop('checked', false);
        $("#filter_location-modal .check-form:checked").prop('checked', false);
        $("#filter_align-modal02 .radio-form").eq(0).prop('checked', true);
        
        loadWholesalerList(true);
    });


    function getIndexesOfSelectedCategory() {
        let categories = [];
        $("#filter_category-modal .check-form:checked").each(function(){
            categories.push($(this).attr('id'));
        });

        return categories;
    }

    function getIndexesOfSelectedLocations() {
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
            //$("ul.obtain_list .sub_filter_result").show();
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

    function toggleCompanyLike(idx) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : '/wholesaler/like/' + idx,
            method: 'POST',
            success : function(result) {
                if (result.success) {
                    if (result.like === 0) {
                        $('.zzim_btn[data-company-idx='+idx+']').removeClass('active');
                    } else {
                        $('.zzim_btn[data-company-idx='+idx+']').addClass('active');
                    }
                }
            }
        })
    }

    $(document).ready(function(){
//        $('#loadingContainer').show();
        setTimeout(() => {
//            loadWholesalerList(true);
        }, 50);
    })

    window.addEventListener('scroll', function() {
        if ((window.pageYOffset || document.documentElement.scrollTop) + window.innerHeight + 300 >= document.documentElement.scrollHeight && !isLoading && !isLastPage) {
            loadWholesalerList(false);
        }
    });

    function saveDetail(idx, otherLink){
        sessionStorage.setItem('af7-top', $(document).scrollTop());
        sessionStorage.setItem('af7-currentPage', currentPage);
        sessionStorage.setItem('af7-href', location.href);
        sessionStorage.setItem('af7-backupItem', $($(".obtain_list")[0]).html());

        if(otherLink) {
            location.href=otherLink;
        } else {
            location.href='/wholesaler/detail/' + idx;
        }
    }
    window.onpageshow = function(ev) {
        if(sessionStorage.getItem("af7-backupItem") && location.href == sessionStorage.getItem("af7-href")){
            $($(".obtain_list")[0]).html(sessionStorage.getItem("af7-backupItem"));
            $(document).scrollTop(sessionStorage.getItem("af7-top"));
            currentPage = sessionStorage.getItem("af7-currentPage");
        } else {
            setTimeout(() => {
                loadWholesalerList(true);
//                $("#filter_location-modal .btn-primary").text('상품 찾아보기');
            }, 50);
        }
        sessionStorage.removeItem('af7-backupItem');
        sessionStorage.removeItem('af7-top');
        sessionStorage.removeItem('af7-currentPage');
        sessionStorage.removeItem('af7-refurl');
    }

    $(window).on('load', function(){
        //$('#loadingContainer').hide();
    });
    </script>
@endsection