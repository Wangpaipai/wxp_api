<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdmin
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
        if(!session()->has('user')){
            return redirect()->route('web.login');
        }
        if(!session('user')->is_admin){
            return redirect()->route('web.index');
        }

        view()->share('user', session('user'));
        return $next($request);
    }
}
