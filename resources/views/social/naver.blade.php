
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="/js/jquery-1.12.4.js?{{ date('Ymdhis') }}"></script>
    <script type="text/javascript">                 
    
    var jsonData = @json($jsonData);              
    // console.log("1==========================");
     console.log('jsonData:', jsonData);   
    var name = jsonData.name;
    var email = jsonData.email; 
    var mobile = jsonData.mobile;   
    //    console.log('name:', name);
    //    console.log('mobile:', mobile);
    

    // window.onload = function () {
    //     var userData = JSON.parse($user); // 서버에서 전달받은 사용자 정보
       
    //     console.log("1==========================");
    //     console.log('userData:', userData);
    // };
       window.addEventListener('load', function() {            
        $.ajax({           
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "/social/naver",
            type: 'POST',
            data: { 'name':name, 'mobile':mobile, 'provider':'naver' },
            //dataType: 'json',
            success: function(response) {
                    // console.log("addEvent=====================");
                    // console.log('response:', response);
                    opener.location.reload();
                    window.close();
                    // if (response.success == true) {
                    //     // var accessToken = response.accessToken;      
                    //     $.ajax({                        
                    //         url: "/social/naver",
                    //         type: 'POST', 
                    //     // data: { 'accessToken':accessToken },                       
                    //         //dataType: 'json',
                    //         success: function(response) {
                    //             if (response.message == '연동해제') {
                    //                 window.close();
                    //             } 
                    //         },
                    //         error: function(error) {
                    //             console.error('Error:', error);      
                    //             console.log('Error:', error);                     
                    //         }                   
                    //     });          
                    // }
                },
                error: function(error) {
                    console.error('Error:', error);
                    console.log('Error:', error);
                }                   
            }); 
       });      
</script>