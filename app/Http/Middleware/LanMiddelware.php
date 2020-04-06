<?php

namespace App\Http\Middleware;

use Closure;

class LanMiddelware
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
        $locale = \App::getLocale();

        if(!\Session::has('lang')) {
            \Session::put('lang',$locale); 
        }

        $res = $next($request);

        \App::setLocale(\Session::get('lang'));


        return $res;
    }
}
