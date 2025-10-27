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
                        <li><a href="/product/search?kw={{$_GET['kw']}}&kp=P">상품</a></li>
                        <li class="active"><a href="javascript:void(0);">업체</a></li>
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
                    <div class="total" style="display:none;"><span>‘{{$_GET['kw']}}'</span> 검색 결과 총 0개의 도매업체</div>
                    <div class="filter_box">
                        <button onclick="modalOpen('#filter_align-modal02')">최신 상품 등록순</button>
                    </div>
                </div>
                <ul class="obtain_list"></ul>
            </div>
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
        if(needEmpty) currentPage = 0;;
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
                console.log(result)
                if(needEmpty) {
                    $(".obtain_list").empty();
                }
                $(".obtain_list").append(result.data.html);
                $(".total").text('전체 ' + result.total.toLocaleString('ko-KR') + '개');

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
                toggleFilterBox();
                isLoading = false;
                $('.total').show();
//                $('#loadingContainer').hide();
                setTimeout(ajaxPageLoad.actions.checkLoadedImage, 300);
            }
        })
    }

    // 카테고리 및 소팅
    $(document).on('click', '[id^="filter"] .btn-primary', function() {
        loadWholesalerList(true, $(this))
    });

    const filterRemove = (item)=>{
        $(item).parents('span').remove(); //해당 카테고리 삭제
        $("#" + $(item).data('id')).prop('checked', false);//모달 안 체크박스에서 check 해제

        loadWholesalerList(true);
    }

    const orderRemove = (item)=> {
        $(item).parents('span').remove(); //해당 카테고리 삭제
        $("#filter_align-modal02 .radio-form").eq(0).prop('checked', true);

        loadWholesalerList(true);
    }

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
            //$("ul.obtain_list .sub_filter_result").show();
        }
    }

    function displaySelectedLocation() {
        let html = "";

        $("#filter_location-modal .check-form:checked").each(function() {
            html += '<span>'+ $(this).data('location') +
                '   <button data-id="'+ $(this).attr('id') +'" onclick="filterRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button>' +
                '</span>';                    "</span>";
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

    function toggleFilterBox() {
        if($(".modal .check-form:checked").length === 0 && ($("#filter_align-modal02 .radio-form:checked").val() == "reg_time" || $("#filter_align-modal02 .radio-form:checked").val() == "search" || $("#filter_align-modal02 .radio-form:checked").val() == "order")){
            $(".sub_filter_result").hide();
        } else {
            $(".sub_filter_result").css('display', 'flex');
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
//            $("#filter_location-modal .btn-primary").text('상품 찾아보기');
        }, 50);
    })

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
                $("#filter_location-modal .btn-primary").text('상품 찾아보기');
            }, 50);
        }
        sessionStorage.removeItem('af7-backupItem');
        sessionStorage.removeItem('af7-top');
        sessionStorage.removeItem('af7-currentPage');
        sessionStorage.removeItem('af7-refurl');
    }

    window.addEventListener('scroll', function() {
        if ((window.pageYOffset || document.documentElement.scrollTop) + window.innerHeight + 300 >= document.documentElement.scrollHeight && !isLoading && !isLastPage) {
            loadWholesalerList(false);
        }
    });

    $(window).on('load', function(){
        //$('#loadingContainer').hide();
    });
    </script>


@endsection
