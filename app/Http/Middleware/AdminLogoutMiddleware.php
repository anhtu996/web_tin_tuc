<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;//su dung middleware cua auth

class AdminLogoutMiddleware
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
        if (Auth::check()&&Auth::user()->quyen == 1) {         
                return redirect('admin/theloai/danhsach');
        }else{
                return $next($request);
        }
    }
}
