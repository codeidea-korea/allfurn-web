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
        <h3>가입신청 완료</h3>
    </div>
</div>

<div id="content">
    <section class="join_comp flex items-center justify-center">
        <div class="text-center">
            <h4 class="mb-4">올펀 회원 가입 신청이 완료되었습니다.</h4>
            <div class="info_box mb-8">
                가입 승인 결과는 <span class="txt-danger">영업일 기준 1일 내 문자로 전송</span>됩니다.<br/>
                가입 시 입력한 이메일로 로그인해주세요.
            </div>
            <h5>올펀 서비스 이용 절차</h5>
            <div class="mb-8">
                회원가입 → 가입 승인 → 로그인 → 올펀 서비스 이용
            </div>
            <div class="btn_box">
                <a href="/" class="btn w-[300px] btn-primary mx-auto">ALL FURN 홈으로 가기</a>
            </div>
        </div>
    </section>
</div>

@endsection
