$( function() {
    // 헤더 카테고리 스크립트
    $('.header_category .category_btn').on('click',function(){
        $('.header_category .category_list').show();
    })
    $('.header_category .category_list').on('mouseleave',function(){
        $('.header_category .category_list').hide();
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

    // 찜아이콘
    $('.zzim_btn').on('click',function(){
        $(this).toggleClass('active')
    })

    // 검색모달 제어
    $('.search_wrap .search_btn_list li').on('click',function(){
        $(this).addClass('active').siblings().removeClass('active')
    });

    $('.search_intro .next_btn').on('click',function(){
        let next = $('.search_intro li.active').data('next')
        $(`.search_wrap .${next}`).removeClass('hidden').siblings('div').addClass('hidden')
    })
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
