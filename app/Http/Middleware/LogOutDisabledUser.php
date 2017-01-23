<?php

namespace App\Http\Middleware;

use Closure;

use Auth;

use App\User;

class LogOutDisabledUser
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
        if(Auth::check()) {
            if(Auth::user()->isDisabled()) {
                Auth::logout();
                return redirect('/')->with('status', 'Tu cuenta está desactivada.');
            }
        }

        return $next($request);
    }
}
