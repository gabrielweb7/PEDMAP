<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Session;

use Closure;

class SomenteLogadoAdmin
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

        /* Cria Object */
        $auth = new AuthController();

        if(Session::get('tipo') != 255) {

            /* Verifica status de autenticacao: true or false */
            if(!$auth->getAuth() or Session::get('tipo') != 1) {
                return redirect()->route('logout');
            }

        }

        return $next($request);
    }
}
