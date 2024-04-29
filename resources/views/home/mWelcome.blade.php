<!DOCTYPE html>
<html lang="ko_KR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta property="og:locale" content="ko_KR" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="" />
    <meta property="og:keywords" content="" />
    <meta property="og:description" content="" />
    <meta property="og:url" content="#" />
    <meta property="og:image" content="">
    <meta property="og:site_name" content="" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="" />
    <meta name="twitter:title" content="" />
    <title>All FURN  | Home</title>

    <script src="/js/plugin.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/ver.1/css/ui.css?210805">
    <script src="/js/jquery-1.12.4.js?20240424125855"></script>
</head>

<style>
    .splash {
        overflow-y: hidden !important;
        -webkit-overflow-scrolling: unset;
        height: 100vh;

        &::after {
            content: ' ';
            background: url('/splash.png') no-repeat;
            background-image: url('/splash.png') no-repeat;
            background-size: cover;
            display: block;
            width: 100vw;
            height: 100vh;
            position: fixed;
            top: 0px;
            z-index: 10000;
        }
    }
</style>

<body class="allfurn-introduction splash">

    <script type="text/javascript">
    const accessToken = localStorage.getItem('accessToken');
    if(accessToken && accessToken.length > 1) {
        const callTime = new Date().getTime();
        $.ajax({
    //        headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
            url: '/tokenpass-signin',
            data: {
                'accessToken': accessToken
            },
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                const pendingTime = new Date().getTime() - callTime;

                if (result.success) {                    
                    if(pendingTime > 1100) {
                        location.href = '/';
//                        $('.splash').removeClass('splash');
                    } else {
                        setTimeout(() => {
                        location.href = '/';
//                            $('.splash').removeClass('splash');
                        }, (1100 - pendingTime));
                    }
                } else {
                    if(pendingTime > 1400) {
                        location.href = '/signin';
                        $('.splash').removeClass('splash');
                    } else {
                        setTimeout(() => {
                            location.href = '/signin';
                            $('.splash').removeClass('splash');
                        }, (1400 - pendingTime));
                    }
//                    alert(result.msg);
                }
            }
        });
    } else {
        setTimeout(() => {
            $('.splash').removeClass('splash');
            location.href = '/signin';
        }, 1400);
    }
    </script>
</body>
</html>
