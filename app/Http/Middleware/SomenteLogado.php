<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AuthController;

use Closure;

class SomenteLogado
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

        /* Verifica status de autenticacao: true or false */
        if(!$auth->getAuth()) {
            return redirect()->route('logout');
        }

        return $next($request);
    }
}
