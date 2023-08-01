<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $store_id = \Session::pull('store_id');
        if($store_id == null) {
          $store_id = 2;
        }
        switch ($guard) {
          
          case 'admin':
            if (Auth::guard($guard)->check()) {
              return redirect()->route('admin.login');
            }
            break;
          case 'seller':
            if (Auth::guard($guard)->check()) {
              return redirect()->route('seller.login');
            }
            break;
          case 'customer':
            if (Auth::guard($guard)->check()) {
              return redirect()->route('customer.login',[$store_id]);
            }
            break;
        }

        return $next($request);
    }
}
