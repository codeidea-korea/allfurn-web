function setScreenSize() {
    let vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
}
setScreenSize();
window.addEventListener('resize', setScreenSize);

$( function() {
    // 퀵메뉴 제어
    // let quickNum = $('.quick_menu ul.menu li.active').index();
    // $('.quick_menu .category_btn').on('click',function(){
    //     $('body').toggleClass('overflow-hidden')
    //     $(this).toggleClass('active').siblings().removeClass();
    //     $('.quick_menu .category_list').toggleClass('show')
    //     if(!$(this).hasClass('active')){
    //         $('.quick_menu li').eq(quickNum).addClass('active')
    //     }
    // })

    // 스크롤시 헤더
    let lastScrollY = 0
    $(window).on('scroll',function(e){
        let currentScrollY = e.currentTarget.scrollY;

        if(lastScrollY < currentScrollY){
            $('header').removeClass('top_fixed')
            $('.header_category').removeClass('scroll_up')
        }else{
            $('header').addClass('top_fixed')
            $('.header_category').addClass('scroll_up')
        }

        lastScrollY = currentScrollY;
    })


    $('.category_con01 .category_list > ul > li > a').on('click',function(){
        $(this).parent().toggleClass('active').siblings().removeClass('active')
        $(this).next().toggle().parent().siblings().find('ul').hide();
    })


    // 드롭다운 커스텀
    $('.dropdown_wrap .dropdown_btn').on('click',function(){
        $(this).toggleClass('active')
        $(this).parent().toggleClass('active')
    })
    $('.dropdown_wrap .dropdown_item').on('click',function(){
        $(this).parents('.dropdown_wrap').find('.dropdown_btn').text($(this).text())
        $(this).parents('.dropdown_wrap').find('.dropdown_btn').removeClass('active')
        $(this).parents('.dropdown_wrap').removeClass('active')
    })

    // 약관동의 - 전체동의
    $('.agree_wrap .agree_item.all input').on('change',function(){
        if($(this).is(':checked')){
            $(this).parents('.agree_item').siblings().find('input').prop('checked',true)
        }else{
            $(this).parents('.agree_item').siblings().find('input').prop('checked',false)
        }
    })
    $('.agree_wrap .agree_item:not(.all) input').on('change',function(){
        if(!$(this).is(':checked')){
            $(this).parents('.agree_item').siblings('.all').find('input').prop('checked',false)
        }
    });

    // // 찜아이콘
    // $('.zzim_btn').on('click',function(){
    //     $(this).toggleClass('active')
    // })

    // 검색모달 제어
    $('.search_wrap .search_btn_list li').on('click',function(){
        $(this).addClass('active').siblings().removeClass('active')
    });

    $('.search_intro .next_btn').on('click',function(){
        let next = $('.search_intro li.active').data('next')
        $(`.search_wrap .${next}`).removeClass('hidden').siblings('div').addClass('hidden')
    })

    // 쉬운상품 찾기
    // 각 버튼 클릭 시
    $('.search_intro .search_btn_list li button').on('click', function() {
        let parentLi = $(this).closest('li');

        // 다른 모든 li에서 active 클래스 제거
        $('.search_intro .search_btn_list li').removeClass('active');

        // 현재 li에 active 클래스 추가
        parentLi.addClass('active');
    });

    // 다음 버튼 클릭 시
    $('.search_intro .next_btn').on('click', function() {
        let activeLi = $('.search_intro li.active');
        let next = activeLi.data('next');
        let url = activeLi.data('url');

        if (next) {
            $(`.${next}`).removeClass('hidden').siblings('div').addClass('hidden');
        } else if (url) {
            window.location.href = url;
        }
    });

    // 주문시 상품수량 변경
    $('.count_box .minus').on('click',function(){
        let num = Number($(this).siblings('input').val().split('개')[0]);
        if(num !== 1){
            $(this).siblings('input').val(`${num-1}개`)
        }
    })
    $('.count_box .plus').on('click',function(){
        let num = Number($(this).siblings('input').val().split('개')[0]);
        $(this).siblings('input').val(`${num+1}개`)
    })

    // 상품등록 > 속성 모달
    $('.prod_property_tab li').on('click',function(){
        let liN = $(this).index();
        $(this).addClass('active').siblings().removeClass('active')
        $('.prod_property_cont > div').eq(liN).addClass('active').siblings().removeClass('active')
    })

    // 드롭다운
    $(".filter_dropdown").click(function(event) {
        var $thisDropdown = $(this).next(".filter_dropdown_wrap");
        $(this).toggleClass('active');
        $thisDropdown.toggle();
        $(this).find("svg").toggleClass("active");
        event.stopPropagation(); // 이벤트 전파 방지
    });

    // 드롭다운 항목 선택 이벤트
    $(".filter_dropdown_wrap ul li a").click(function(event) {
        var selectedText = $(this).text();
        var $dropdown = $(this).closest('.filter_dropdown_wrap').prev(".filter_dropdown");
        $dropdown.find("p").text(selectedText);
        $(this).closest(".filter_dropdown_wrap").hide();
        $dropdown.removeClass('active');
        $dropdown.find("svg").removeClass("active");

        var targetClass = $(this).data('target');
        if (targetClass) {
            // 모든 targetClass 요소를 숨기고, 현재 targetClass만 표시
            $('[data-target]').each(function() {
                var currentTarget = $(this).data('target');
                if (currentTarget !== targetClass) {
                    $('.' + currentTarget).hide();
                }
            });
            $('.' + targetClass).show(); // 현재 클릭한 targetClass 요소만 표시
        } else {
            // 현재 클릭이 data-target을 가지고 있지 않다면, 모든 targetClass 요소를 숨김
            $('[data-target]').each(function() {
                var currentTarget = $(this).data('target');
                $('.' + currentTarget).hide();
            });
        }

        event.stopPropagation(); // 이벤트 전파 방지
    });

    // 이용가이드 스크립트
    $('.guide_list a').click(function() {
        var targetId = $(this).data('target');

        $('.guide_con').hide();
        $('#' + targetId).show();
    });
});


// // 카테고리 초기화
// const refreshHandle = (this)=>{
//     // $(this).parent().siblings('.filter_list').find('input').each(function(){
//     //     $(this).prop("checked",false)
//     // })
// }

// 모달제어
const modalOpen = (modal)=>{
    $(`${modal}`).addClass('show');
    $('body').addClass('overflow-hidden');
}

const modalClose = (modal)=>{
    $(`${modal}`).removeClass('show');
    $('body').removeClass('overflow-hidden');

    if(modal == "#search-modal"){
        $('.search_wrap > div').each(function(){
            $(this).addClass('hidden');
        })
        $('.search_wrap .search_intro').removeClass('hidden');
    }
}

const refreshHandle = (item)=>{
    $(item).parent().siblings('.filter_list').find('input').each(function(){
        $(this).prop("checked",false);
    });
}

// // 필터 아이템 제거
// const filterRemove = (item)=>{
//     $(item).parents('span').remove()
// }

// 상품등록 > 카테고리 선택
const prodCate = (item)=>{
    $(item).parent('li').toggleClass('on').siblings().removeClass('on')
}

// 상품등록 > 배송방법
const shippingShow = (item,index)=>{
    $(`.${item}`).removeClass('hidden')
    $(`.${item} .shipping_cont > div`).eq(index).removeClass('hidden').siblings().addClass('hidden')
}

function linkToPage(url){
    $('#loadingContainer').show();
    location.href = url;
}

// 수량변경
const changeValue = (item,status)=>{
    let num = Number($(item).siblings('input').val())
    if(status == "minus"){
        if((num-1)==0){
            $(item).siblings('input').val(1)    
        }else{
            $(item).siblings('input').val(num-1)
        }
    }else{
        $(item).siblings('input').val(num+1)
    }
}


// 접기 펼치기
const foldToggle = (item)=>{
    $(item).parents('.fold_area').toggleClass('active')
}

// 상품추가

    const prodAdd = (item)=>{
        var cnt = parseInt( $('.reqCount').first().text() );
        if(!$(item).prev('input').prop('checked')){
            $(item).text('취소');
            $('.reqCount').text( cnt + 1 );
        }else{
            $(item).text('추가');
            $('.reqCount').text( cnt - 1 );
        }
    }

const ajaxPageLoad = {
    variables: {
        timer: null
    },
    actions: {
        isLoadCompleteImage: function(){
            const imageTags = $('img');
            for (let idx = 0; idx < imageTags.length; idx++) {
                const imageTag = imageTags[idx];
                if(! imageTag.complete) {
                    // 하나라도 false 라면 return
                    return false;
                }
            }
            return true;
        },
        checkLoadedImage: function(){
            if(ajaxPageLoad.actions.isLoadCompleteImage()) {
                $('#loadingContainer').hide();
                return false;
            }
            ajaxPageLoad.variables.timer = setTimeout(ajaxPageLoad.actions.checkLoadedImage, 300);
        }
    }
};
$(document).ready(function(){
    
    const originFn = $.ajax;
    $.ajax = (options) => {
        const beforeSendFn = (options && options.beforeSend) || function(a,b){};
        options.beforeSend = (a,b) => {
            $('#loadingContainer').show();
            beforeSendFn(a,b);
        };
        const successFn =  (options && options.success) || function(a,b,c){};
        options.success = (a,b,c) => {
//            $('#loadingContainer').hide();
            successFn(a,b,c);
            setTimeout(ajaxPageLoad.actions.checkLoadedImage, 200);
        };
        originFn(options);
    };

});
