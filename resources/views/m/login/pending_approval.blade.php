@extends('layouts.app_m')

@php

$header_depth = 'login';
$only_quick = 'yes';
$top_title = '';
$header_banner = '';

@endphp

@section('content')

<div class="flex flex-col items-center justify-center min-h-screen text-center" style="min-height: 80vh; margin-top: -50px;">
    <div style="margin-top: -100px;">
        <div class="mb-4">
            <div class="text-center mb-2">
                <img src="/img/logo.svg" alt="올펀" class="mx-auto" style="max-width: 150px;">
            </div>
            <p class="text-red-500 text-lg font-medium">올펀 회원가입 완료안내</p>
        </div>
        
        <div class="bg-red-500 text-white p-5 rounded-md mb-10 max-w-md mx-auto" style="max-width: 400px;">
            <p class="text-center font-medium">"{{ $user_name }}"님의 올펀 회원가입이<br>정상적으로 접수 되었습니다.</p>
        </div>
        
        <p class="text-gray-600">올펀 운영자 승인 후 서비스를 이용 가능 합니다.</p>
        
        <div class="mt-8">
            <a href="/signout" class="btn btn-primary w-full">홈으로 이동</a>
        </div>
    </div>
</div>
<script>
sessionStorage.removeItem('socialUserData');
</script>
@endsection