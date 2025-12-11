<script src="https://t1.kakaocdn.net/kakao_js_sdk/2.7.2/kakao.min.js" integrity="sha384-TiCUE00h649CAMonG018J2ujOgDKW/kVWlChEuu4jK2vxfAAD0eZxzCKakxg55G4" crossorigin="anonymous"></script>
<script> Kakao.init('7e12cb16dd8a77a9c882f845b609b3e4'); </script>
<!-- 개발 --> 
<!-- <script> Kakao.init('c6fd02e1e170f732585aa2908ea63ce1'); </script> -->
<script>
    var isProccessing2ShareCatalog = false;

    function shareCatalog(companyIndex, requestType) {
        if(isProccessing2ShareCatalog) {
            return;
        }
        isProccessing2ShareCatalog = true;
        var companyName = '';
        const domain = location.protocol + '//' + location.hostname;

        $.ajax({
            url: domain + '/json/wholesaler/' + companyIndex,
            method: 'GET',
            async: false,
            success: function(result) {
                companyName = result.info.company_name;
            }
        })
        $.ajax({
            url             : '/event/saveUserAction?company_idx='+companyIndex+'&company_type=W&product_idx=0&request_type=' + requestType,
            enctype         : 'multipart/form-data',
            processData     : false,
            contentType     : false,
            type			: 'GET',
            async: false,
            success: function (result) {
            }
        });
        if(!companyName || companyName == '') {
            isProccessing2ShareCatalog = false;
            return;
        }
        Kakao.Share.sendDefault({
            objectType: 'feed',
            content: {
                title: '['+companyName+'] 카탈로그가 도착했습니다.',
                description: '제품 정보와 업체 정보를 모두 확인 해보세요!',
                imageUrl: domain + '/img/logo_kakao_catalog2.png',
                link: {
                mobileWebUrl: domain + '/catalog/' + companyIndex,
                webUrl: domain + '/catalog/' + companyIndex,
                },
            },
            buttons: [
                {
                    title: '카탈로그 보기',
                    link: {
                        mobileWebUrl: domain + "/catalog/" + companyIndex,
                        webUrl: domain + "/catalog/" + companyIndex,
                    },
                },
            ],
        });
        isProccessing2ShareCatalog = false;
    }
</script>