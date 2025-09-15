<?php
/**
 * Disable HTTP Cache
 *
 * @author    Been Kyung-yoon <master@best79.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace App\Http\Middleware;

use Closure;

class NoCacheMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // 웹페이지 캐시 비활성화 - 로그아웃후 뒤로가기시 로그인된 화면이 보이는 것 방지.
        if (method_exists($response, 'header')) {
            $response->header('Cache-Control', 'private, no-cache');
            $response->header('Pragma', 'no-cache');
            $response->header('Expires', 'Thu, 19 Nov 1981 08:52:00 GMT');
        }

        return $response;
    }
}
