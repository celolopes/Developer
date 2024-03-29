<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\LogAcesso;

class LogAcessoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //Obter o IP do Server via request pegando o atributo REMOTE_ADDR
        $ip = $request->server->get('REMOTE_ADDR');

        //Obter em uma variável $rota a rota usada via request
        $rota = $request->getRequestUri();

        //Criar um create do campo log com o objeto LogAcesso
        LogAcesso::create(['log' => "IP $ip requisitou a rota $rota"]);
        return $next($request);
    }
}
