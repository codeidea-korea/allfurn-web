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

    // 검색모달 제어
    $('.search_wrap .search_btn_list li').on('click',function(){
        $(this).addClass('active').siblings().removeClass('active')
    });


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

    // $('.search_intro .next_btn').on('click',function(){
    //     let next = $('.search_intro li.active').data('next')
    //     $(`.search_wrap .${next}`).removeClass('hidden').siblings('div').addClass('hidden')
    // })

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
const modalAllClose = ()=>{
    $('.modal.show').each(function(){
        $(this).removeClass('show')
        $('body').removeClass('overflow-hidden');
    })
}

const dropBtn = (item)=>{
    $(item).toggleClass('active')
    $(item).parent().toggleClass('active')
}
const dropItem = (item)=>{
    $(item).parents('.dropdown_wrap').find('.dropdown_btn').text($(item).text())
    $(item).parents('.dropdown_wrap').find('.dropdown_btn').removeClass('active')
    $(item).parents('.dropdown_wrap').removeClass('active')
}

const refreshHandle = (item)=>{
    $(item).parent().siblings('.filter_list').find('input').each(function(){
        $(this).prop("checked",false);
    });
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


function getThumbFile(_IMG, maxWidth, width, height){
    var canvas = document.createElement("canvas");
    if(width < maxWidth) {
//        return _IMG;
    }
    canvas.width = width; // (maxWidth);
    canvas.height = height; // ((maxWidth / (width*1.0))*height);
    canvas.getContext("2d").drawImage(_IMG, 0, 0, width, height);

    var dataURL = canvas.toDataURL("image/png");
    var byteString = atob(dataURL.split(',')[1]);
    var mimeString = dataURL.split(',')[0].split(':')[1].split(';')[0];
    var ab = new ArrayBuffer(byteString.length);
    var ia = new Uint8Array(ab);
    for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
    }
    var tmpThumbFile = new Blob([ab], {type: mimeString});

    return tmpThumbFile;
}

$('.file_input').on('change', function() {
    var file = this.files[0];
    if (file.size > 300 * 1024) {
        var reader = new FileReader();
        reader.onload = function(event) {
            var image = new Image();
            image.onload = function() {
                file = getThumbFile(image, 500, this.width, this.height);
            };
            image.src = event.target.result;
        };
    }
});


const originFn = $.ajax;
$.ajax = (url, options) => {
    const beforeSendFn = options.beforeSend;
    options.beforeSend = (a,b) => {
        $('#loadingContainer').show();
        beforeSendFn();
    };
    const successFn = options.success;
    options.success = (a,b,c) => {
        $('#loadingContainer').hide();
        successFn(a,b,c);
    };
    originFn(url, options);
};
