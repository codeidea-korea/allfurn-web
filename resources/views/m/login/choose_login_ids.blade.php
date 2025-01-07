@extends('layouts.app_m')

@php

$header_depth = 'login';
$only_quick = 'yes';
$top_title = '';
$header_banner = '';

@endphp

@section('content')

<input type="hidden" id="cellphone" value="@php echo $cellphone; @endphp">
<div id="content">
    <section class="login_common flex items-center">
        <div class="login_inner">
            <img class="logo" src="/img/logo.svg" alt="">
                @foreach($users as $user)
                <div class="joined_id_box">
                    <input type="radio" name="joined_id" id="joined_id_@php echo $loop -> index; @endphp" value="@php echo $user->account; @endphp" 
                        @php echo ($loop -> index == 0 ? 'checked' : ''); @endphp>
                        <label for="joined_id_'+idx+'" onclick="console.log(1);return false;">@php echo $user->account; @endphp</label>
                </div>
                @endforeach
            <ul class="info_box">
                <li>서비스 이용 및 회원가입 문의는 '서비스 이용문의(cs@all-furn.com)' 또는 031-813-5588로 문의 해주세요.</li>
            </ul>
            <button type="button" class="btn w-full btn-primary mt-2.5" onclick="signin()">선택한 아이디로 로그인</button>
            
            <a href="/signup" class="btn w-full mt-2.5 btn-line2">올펀 가입하기</a>
            <div class="link_box flex items-center justify-center">
                <a href="/findid">아이디 찾기</a>
                <a href="/findpw">비밀번호 재설정</a>
                <a href="mailto:cs@all-furn.com">서비스 이용 문의</a>
            </div>
        </div>
    </section>
</div>

<script src="/js/jquery-1.12.4.js?20240329113305"></script>
<script>
    $('.tab_layout li').on('click',function(){
        let liN = $(this).index();
        $(this).addClass('active').siblings().removeClass('active')
        $('.tab_content > div').eq(liN).addClass('active').siblings().removeClass('active')
    })
</script>
<script>
function signin() {
    const joined_id = $('input[name=joined_id]:checked').val();

    if(joined_id == '') {
        return;
    }

    var data = new Object() ;
    data.phonenumber = $('#cellphone').val().replace(/-/g, '');
    data.joinedid = joined_id;
    data.code = 'SE';

    $.ajax({
        url				: '/signup/signinAuthCode',
        contentType     : "application/x-www-form-urlencoded; charset=UTF-8",
        data			: data,
        type			: 'POST',
        dataType		: 'json',
        xhrFields: {
            withCredentials: false
        },
        success : function(result) {
            if (result.success) {
                window.location.href = '/';
            } else {
                alert(result.message);
            }
        }
    });
}
</script>

@endsection
