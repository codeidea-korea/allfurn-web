$( function() {
    /** 찜 아이콘 */
    $(document).on('click', '.zzim_btn', function() {
        let pidx = $(this).attr('pidx');
        if(pidx) {
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
        }

        $zzimbtn = $(this);
        let articleIndex = $(this).attr('articeId');
        if(articleIndex) {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url : '/community/like-article',
                method: 'POST',
                data : {
                    articleId : + articleIndex
                },
                success : function(result) {
                    if(result.result == 'success') {
                        let currentLikeCount = parseInt($("#like_count").text());
                        if(result.code == 'UP') {
                            $("#like_count").text(currentLikeCount + 1);
                            $zzimbtn.addClass('active');
                        } else {
                            $("#like_count").text(currentLikeCount - 1);
                            $zzimbtn.removeClass('active');
                        }
                    }
                }

            })
        }
    })
});