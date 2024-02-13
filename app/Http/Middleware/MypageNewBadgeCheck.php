<?php

namespace App\Http\Middleware;

use App\Service\MypageService;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class MypageNewBadgeCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $this->check();
        return $response;
    }

    private function check()
    {
        if (!Cookie::get('cocw') && Auth::user()['type'] === 'W') {
            $mypageService = new MypageService();
            $totalCount = $mypageService->getCurrentOrderStatus('W');
            Cookie::queue('cocw', Crypt::encrypt($totalCount), 525600);
        }
        if (!Cookie::get('cocr') && in_array(Auth::user()['type'], ['W','R'])) {
            $mypageService = new MypageService();
            $totalCount = $mypageService->getCurrentOrderStatus('R');
            Cookie::queue('cocr', Crypt::encrypt($totalCount), 525600);
        }

    }
}
