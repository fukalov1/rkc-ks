<?php

namespace App\Http\Middleware;

use Closure;

class SetSlider
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
        if($request['set']) {
            session(['slider_id' => $request['set']]);
        }

        return $next($request);
    }
}
