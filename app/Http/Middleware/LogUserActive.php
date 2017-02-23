<?php

namespace App\Http\Middleware;

use Closure;

use Auth;
use Cache;

use Carbon\Carbon;

class LogUserActive
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
        return $next($request);
    }


    // Para que sea después por si se le cierra la sesión
    public function terminate($request, $response)

    {
        // Si el usuario está conectado y no sabíamos que estaba activo, le ponemos activo
        if(Auth::check()) {
            $user = Auth::user();
            // Guardamos en el cache 5 minutos si está activo, para evitar carga a la DB
            if(!Cache::has('user_is_active_'.$user->id)) {
                Cache::put('user_is_active_'.$user->id, true, 5);
                Auth::user()->active_at = Carbon::now();
                $user->save();
            }   
        }

    }

}
