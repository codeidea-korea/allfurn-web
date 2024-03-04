$( function() {
    /** 찜 아이콘 */
    $('.zzim_btn').on('click',function(){
        let pidx = $(this).attr('pidx');
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url             : '/product/interest/' + pidx, 
            enctype         : 'multipart/form-data',
            processData     : false,
            contentType     : false,
            data			: {},
            type			: 'POST',
            success: function (result) {
                if (result.success) {
                    if (result.interest == 0) {
                        $(`.prd_${pidx}`).removeClass('active');
                    } else {
                        $(`.prd_${pidx}`).addClass('active');
                    }
                } else {
                    alert(reslult.message);
                }

                isProc = false;
            }
        });
    })
});