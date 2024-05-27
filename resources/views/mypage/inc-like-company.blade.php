<section class="sub_section_top">
    <div class="inner">
        <div class="sub_filter">
            <div class="filter_box">
                <button onclick="modalOpen('#filter_category-modal')">카테고리 <b class="txt-primary"></b></button>
                <button onclick="modalOpen('#filter_location-modal')">소재지 <b class="txt-primary"></b></button>
                <button onclick="modalOpen('#filter_align-modal03')">최신순</button>
            </div>
            <div class="total txt-gray">전체 0개</div>
        </div>
        <div class="sub_filter_result" hidden>
            <div class="filter_on_box">
                <div class="category"></div>
                <div class="location"></div>
                <div class="order"></div>
            </div>
            <button class="refresh_btn">초기화 <svg><use xlink:href="/img/icon-defs.svg#refresh"></use></svg></button>
        </div>
        <ul class="obtain_list"></ul>
    </div>
</section>
<script>
     $(document).ready(function(){
        $("#filter_align-modal03 .filter_list li").eq(2).remove();

        setTimeout(() => {
            loadLikeCompany();
        }, 10);
    })

    window.addEventListener('scroll', function() {
        if ((window.pageYOffset || document.documentElement.scrollTop) + window.innerHeight + 300 >= document.documentElement.scrollHeight && !isLoading && !isLastPage) {
            loadLikeCompany();
        }
    });

    let isLoading = false;
    let isLastPage = false;
    let currentPage = 0;
    function loadLikeCompany(needEmpty, target) {
        if(isLoading) return;
        if(!needEmpty && isLastPage) return;
        
        isLoading = true;
        if(needEmpty) currentPage = 0;

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/like/company',
            method: 'GET',
            data: { 
                'offset': ++currentPage,
                'categories' : getNamesOfSelectedCategory().join(','),
                'regions' : getIndexesOfSelectedLocation().join(','),
                'orderedElement' : $("#filter_align-modal03 .radio-form:checked").val(),
            }, 
            beforeSend : function() {
                if(target) {
                    target.prop("disabled", true);
                }
            },
            success: function(result) {
                if(needEmpty) {
                    $(".obtain_list").empty();
                }

                $(".obtain_list").append(result.html);

                $(".total").text('전체 ' + result.count.toLocaleString('ko-KR') + '개');
    
                isLastPage = currentPage === result.last_page;
            }, 
            complete : function () {
                if(target) {
                    target.prop("disabled", false);
                    modalClose('#' + target.parents('[id^="filter"]').attr('id'));
                }
                displaySelectedCategories();
                displaySelectedLocation();
                displaySelectedOrders();
                toggleFilterBox();
                isLoading = false;
            }
        })
    }

    $(document).on('click', '[id^="filter"] .btn-primary', function() { 
        loadLikeCompany(true, $(this));
    })

    // 카테고리 - 삭제
    function filterRemove(item) {
        $(item).parents('span').remove();
        $("#" + $(item).data('id')).prop('checked', false);

        loadLikeCompany(true);
    }

    const orderRemove = (item)=> {
        $(item).parents('span').remove(); //해당 카테고리 삭제
        $("#filter_align-modal03 .radio-form").eq(0).prop('checked', true);

        loadLikeCompany(true);
    }

    // 초기화
    $(".refresh_btn").on('click', function() {
        $("#filter_category-modal .check-form:checked").prop('checked', false);
        $("#filter_location-modal .check-form:checked").prop('checked', false);
        $("#filter_align-modal03 .radio-form").eq(0).prop('checked', true);

        loadLikeCompany(true);
    })

    function getNamesOfSelectedCategory() {
        let categories = [];
        $("#filter_category-modal .check-form:checked").each(function(){
            // categories.push($(this).attr('id'));
            categories.push($(this).siblings('label').text());
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

    function toggleFilterBox() {
        if($(".modal .check-form:checked").length === 0 && $("#filter_align-modal03 .radio-form:checked").val() == "register_time"){
            $(".sub_filter_result").hide();
        } else {
            $(".sub_filter_result").css('display', 'flex');
        }
    }

    function displaySelectedOrders() {
        if($("#filter_align-modal03 .radio-form:checked").val() != "register_time") {
            $(".filter_on_box .order").empty().append(
                '<span>'+ $("#filter_align-modal03 .radio-form:checked").siblings('label').text() + 
                '   <button data-id="'+ $(this).attr('id') +'" onclick="orderRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button>' +
                '</span>'
            );   
            $(".sub_filter .filter_box button").eq(2).addClass('on')         
        } else {
            $(".sub_filter .filter_box button").eq(2).removeClass('on')
        }

        $(".sub_filter .filter_box button").eq(2)
            .text($("#filter_align-modal03 .radio-form:checked").siblings('label').text());
    }

    const toggleCompanyLike = like_idx => {
        fetch('/mypage/toggle/company/like', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            body: JSON.stringify({
                idx: like_idx
            })
        }).then(response => {
            if (response.ok) {
                return response.json();
            }
            throw new Error('Sever Error');
        }).then(json => {
            if (json.result === 'success') {
                location.reload();
            } else {
                alert(json.message);
            }
        }).catch(error => {
        })
    }
</script>