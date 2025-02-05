@extends('layouts.app_m')

@php

$header_depth = 'login';
$only_quick = 'yes';
$top_title = '';
$header_banner = '';

@endphp

@section('content')



<div class="join_header sticky top-0 bg-white flex items-center">
    <div class="inner">
        <h3>회원가입</h3>
        <a class="close_btn" href="./login.php"><svg><use xlink:href="./img/icon-defs.svg#x"></use></svg></a>
    </div>
</div>

<div id="content">
    <section class="join_common" style="padding-top:0; ">

        <div class="join_social grid grid-cols-2 gap-4 text-center mb-5">
            <button class="py-2 fs16 font-medium border-b border-primary">간편(SNS) 회원가입</button>
            <button class="py-2 fs16 font-medium">일반 회원가입</button>
        </div>

        <div class="join_inner">

            <div class="form_tab_content">
                <div class="form_box">
                    <div class="mb-3">
                        <dl>
                            <dt>SNS 연결</dt>
                            <dd>
                                <input type="text" class="input-form w-full" value="네이버 연동" readonly>
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-3">
                        <dl>
                            <dt>이름</dt>
                            <dd>
                                <input type="text" class="input-form w-full" value="홍길동" readonly>
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-3">
                        <dl>
                            <dt>휴대폰번호</dt>
                            <dd>
                                <input type="text" class="input-form w-full" value="01012345678" readonly>
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-3">
                        <dl>
                            <dt>이메일(아이디)</dt>
                            <dd>
                                <input type="text" class="input-form w-full" value="test@naver.com" readonly>
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-3">
                        <dl>
                            <dt>명함 첨부</dt>
                            <dd>
                                <div class="file-form horizontal">
                                    <input type="file" onchange="fileUpload(this)">
                                    <!-- <label for="" class="error">명함 이미지를 첨부해주세요.</label> -->
                                    <div class="text">
                                        <img class="mx-auto" src="./img/member/img_icon.svg" alt="">
                                        <p class="mt-1">명함 이미지 추가</p>
                                    </div>
                                </div>
                                <div class="info_box mt-2.5">
                                    ・000x000으로 자동 리사이즈 됩니다.<br/>
                                    ・jpg, png만 지원 합니다.
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="form_box hidden">
                    <div class="mb-3">
                        <dl>
                            <dt>이름</dt>
                            <dd>
                                <input type="text" class="input-form w-full" placeholder="이름을 입력해주세요.">
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-3">
                        <dl>
                            <dt>휴대폰번호</dt>
                            <dd>
                                <input type="text" class="input-form w-full" placeholder="휴대폰번호를 입력해주세요.">
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-3">
                        <dl>
                            <dt>이메일(아이디)</dt>
                            <dd>
                                <input type="text" class="input-form w-full" placeholder="이메일(아이디)을 입력해주세요.">
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-3">
                        <dl>
                            <dt>비밀번호</dt>
                            <dd>
                                <input type="password" class="input-form w-full" placeholder="비밀번호를 입력해주세요.">
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-3">
                        <dl>
                            <dt>비밀번호 확인</dt>
                            <dd>
                                <input type="password" class="input-form w-full" placeholder="비밀번호 확인을 입력해주세요.">
                            </dd>
                        </dl>
                    </div>
                    <div class="mb-3">
                        <dl>
                            <dt>명함 첨부</dt>
                            <dd>
                                <div class="file-form horizontal">
                                    <input type="file" onchange="fileUpload(this)">
                                    <!-- <label for="" class="error">명함 이미지를 첨부해주세요.</label> -->
                                    <div class="text">
                                        <img class="mx-auto" src="./img/member/img_icon.svg" alt="">
                                        <p class="mt-1">명함 이미지 추가</p>
                                    </div>
                                </div>
                                <div class="info_box mt-2.5">
                                    ・000x000으로 자동 리사이즈 됩니다.<br/>
                                    ・jpg, png만 지원 합니다.
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="btn_box">
                <button class="btn w-[300px] btn-primary">가입 완료</button>
            </div>

        </div>
    </section>




</div>

<script>

     // 탭변경
     $('.join_social button').on('click',function(){
        let liN = $(this).index();
        $(this).addClass('border-b border-primary').siblings().removeClass('border-b border-primary');

        $('.form_tab_content > div').eq(liN).removeClass('hidden').siblings().addClass('hidden')
    })


// 이미지 변경
const fileUpload = (input) => {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        let img = input.parentNode.querySelector('img');
        if(!img){
            img = document.createElement('img')
        }
        input.nextElementSibling.classList.add('hidden')

        reader.onload = function(e) {
            img.src = e.target.result
            input.parentNode.append(img)
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// 주소 탭 변경
const addressChange = (e) => {
    let liN = $(e).parent().index()
    $(e).parent().parent().next('.add_tab').find('> div').eq(liN).removeClass('hidden').siblings().addClass('hidden')
}
</script>


@endsection

