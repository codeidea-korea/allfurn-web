<script src="https://t1.kakaocdn.net/kakao_js_sdk/2.7.2/kakao.min.js" integrity="sha384-TiCUE00h649CAMonG018J2ujOgDKW/kVWlChEuu4jK2vxfAAD0eZxzCKakxg55G4" crossorigin="anonymous"></script>
<script> Kakao.init('2b966eb2c764be29d46d709f6d100afb'); </script>
<script>
    var isProccessing2ShareCatalog = false;

    function shareCatalog(companyIndex) {
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
        if(!companyName || companyName == '') {
            isProccessing2ShareCatalog = false;
            return;
        }
        Kakao.Share.sendDefault({
            objectType: 'feed',
            content: {
                title: '['+companyName+'] 카탈로그가 도착했습니다.',
                description: '제품 정보와 업체 정보를 모두 확인 해보세요!',
                imageUrl: domain + '/img/logo_kakao_catalog.png',
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