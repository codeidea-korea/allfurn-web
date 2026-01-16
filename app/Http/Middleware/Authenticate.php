<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
//     protected function redirectTo($request)
//     {
//         if (! $request->expectsJson()) {
//             return route('signin.social') . '?replaceUrl=' . urlencode(request()->fullUrl());
//         }
        
//     }
    
//     protected function redirectTo($request)
//     {
//     	if (! $request->expectsJson()) {
    		
//     		$replaceUrl = urlencode($request->fullUrl());
    		
//     		// 모바일 UA 체크
//     		$ua = $request->userAgent() ?? '';
//     		$isMobile = preg_match('/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', $ua);
    		
//     		// 모바일일 경우 브릿지 페이지로 이동
//     		if ($isMobile) {
//     			return 'https://all-furn.com/?isweb=Y&replaceUrl=' . $replaceUrl;
//     		}
    		
//     		// pc인경우에는 기존 페이지 이동
//     		return route('signin.social') . '?replaceUrl=' . $replaceUrl;
//     	}
//     }

    
    protected function redirectTo($request)
    {
    	if (! $request->expectsJson()) {
    
    		$replaceUrl = urlencode($request->fullUrl());
    
    		// 모바일 UA 체크
    		$ua = $request->userAgent() ?? '';
    		$isMobile = preg_match('/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', $ua);
    
    		// 모바일일 경우 브릿지 페이지로 이동
    		if ($isMobile) {
    			return 'https://all-furn.com/?isweb=Y&replaceUrl=' . $replaceUrl;
    		}
    
    		// pc인경우에는 기존 페이지 이동
    		return route('signin.social') . '?replaceUrl=' . $replaceUrl;
    	}
    }
}
