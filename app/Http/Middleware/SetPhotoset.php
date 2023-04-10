<?php

namespace App\Http\Middleware;

use Closure;

class SetPhotoset
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
            session(['photoset_id' => $request['set']]);
        }

        return $next($request);
    }
}
