<?php

namespace App\Http\Middleware;

use Closure;

use Route;
use Auth;

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
        if (strpos(Route::current()->uri(), "admin")!==false){
            if(!Auth::check()) {
                return redirect('login');
            }
            if(!Auth::user()->isAdmin()) {
                abort(403);
            }
        }
        return $next($request);
    }
}
