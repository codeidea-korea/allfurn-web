@extends('layouts.app_m')

@php

$header_depth = 'login';
$only_quick = 'yes';
$top_title = '';
$header_banner = '';

@endphp

@section('content')


<div id="content">
    <section class="login_common flex items-center">
        <div class="login_inner">
            <div class="title">
                <h3>아이디 찾기</h3>
            </div>

            <label for="phone">전화번호</label>
            <div class="flex gap-2 mt-1.5 mb-4">
                <input type="text" id="phone" class="input-form w-full" placeholder="전화번호를 입력해주세요">
                <button class="btn btn-primary-line" disabled >인증번호 받기</button>
            </div>

            <label for="phone">전화번호</label>
            <div class="flex gap-2 mt-1.5 mb-4">
                <input type="text" id="phone" class="input-form w-full" value="01015357894" placeholder="전화번호를 입력해주세요">
                <button class="btn btn-primary-line">인증번호 받기</button>
            </div>

            <label for="phone_2">인증번호</label>
            <div class="flex gap-2 mt-1.5 mb-4">
                <div class="certify_box">
                    <input type="text" id="phone_2" class="input-form w-full" placeholder="인증번호 7자리">
                    <span class="time">03:00</span>
                </div>
                <button class="btn btn-line">재발송</button>
            </div>

            <div class="title">
                <h3>가입된 아이디</h3>
                <p>비밀번호를 분실하셨다면 아이디 선택 후 비밀번호 재설정을 클릭해주세요</p>
            </div>

            <ul class="joined_id">
                <li>
                    <input type="radio" name="joined_id" id="joined_id_1" class="radio-form">
                    <label for="joined_id_1">deee123</label>
                </li>
                <li>
                    <input type="radio" name="joined_id" id="joined_id_2" class="radio-form">
                    <label for="joined_id_2">deee123</label>
                </li>
            </ul>

            <ul class="info_box">
                <li>서비스 이용 및 회원가입 문의는 '서비스 이용문의(cs@all-furn.com)' 또는 031-813-5588로 문의 해주세요.</li>
            </ul>

            <button class="btn w-full btn-primary" disabled>인증완료</button>
            <div class="btn_box flex gap-2 mt-2.5">
                <a href="/findpw.php" class="btn w-full btn-line2">비밀번호 재설정</a>
                <a href="/login.php" class="btn w-full btn-primary">로그인 하러가기</a>
            </div>
           
            <a href="/join.php" class="btn w-full mt-2.5 btn-line2">올펀 가입하기</a>

            <div class="link_box flex items-center justify-center">
                <a href="/findid.php">아이디 찾기</a>
                <a href="/findpw.php">비밀번호 재설정</a>
                <a href="javascript:;">서비스 이용 문의</a>
            </div>
        </div>
    </section>
</div>

<script>
    $('.tab_layout li').on('click',function(){
        let liN = $(this).index();
        $(this).addClass('active').siblings().removeClass('active')
        $('.tab_content > div').eq(liN).addClass('active').siblings().removeClass('active')
    })
</script>
