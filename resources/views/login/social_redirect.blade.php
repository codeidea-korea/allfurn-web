<!DOCTYPE html>
<html>
<head>
    <title>리다이렉트</title>
    <script>
        // 페이지 로드 시 실행
        window.onload = function() {
            // 부모 창 리다이렉트
            if (window.opener) {
                window.opener.location.href = "{{ $redirect_url }}";
                // 팝업 창 닫기
                window.close();
            }
        };
    </script>
</head>
<body>
    <p>잠시만 기다려주세요. 페이지로 이동 중입니다...</p>
</body>
</html>