<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SocialSessionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        Log::info('URL: ' . $request->url());           // 전체 URL
        Log::info('Path: ' . $request->path());         // 경로만
        Log::info('Method: ' . $request->method());     // HTTP 메소드
        Log::info('Full URL: ' . $request->fullUrl());  // 쿼리스트링 포함된 전체 URL
        Log::info('Session Data: ', $request->session()->all());

        return $next($request);
    }
}
