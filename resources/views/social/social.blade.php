
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="/js/jquery-1.12.4.js?{{ date('Ymdhis') }}"></script>
    <script type="text/javascript">

    var jsonData = @json($jsonData);

    var name = jsonData.name;
    var email = jsonData.email;
    var phone_number = jsonData.phone_number;
    var provider = jsonData.provider;
    var id = jsonData.id;

    
  
 
      

    window.addEventListener('load', function() {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "{{ route('social.login') }}" ,
            type: 'POST',
            data: { 'name':name, 'phone_number':phone_number,'email':email, 'provider':provider, 'id':id},
            success: function(response) {
                if (response.script === 'parent') {
                    window.opener.sessionStorage.setItem('socialUserData', JSON.stringify(response.data));
                    
                        window.opener.location.href = response.redirect;
                        window.close();
              
                } else {
                   
                    opener.location.reload();
                    window.close();
                }
                },
                error: function(error) {
                    console.error('Error:', error);
                    console.log('Error:', error);

                    alert('['+name+'] 님 로그인에 실패하였습니다. 잠시 후 다시 시도해주세요.');
                }
            });
       });
</script>
