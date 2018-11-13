<?php

namespace App\Http\Middleware;

use Closure;

class CheckLoginTrue
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
        view()->share('user', session('user'));
        return $next($request);
    }
}
