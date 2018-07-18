<?php

namespace Cms\Middleware;

use Closure;
use Cms\Models\Contador;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests;

class ContadorMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        $counter = new \Cms\Models\Contador();        
        $visitante = hash("SHA256", env('APP_KEY') . $_SERVER['REMOTE_ADDR'].time());
        
        /*$horaInicial = date('H:i:s');
        $horaFinal = '23:59:59';
        //Separa Hora e Minutos
        $horaInicial = explode( ':', $horaInicial );
        $horaFinal = explode( ':', $horaFinal );
        //Obtém o timestamp Unix. Seguindo, no seu caso, a ordem Hora/Minuto.
        $horaIni = mktime( $horaInicial[0], $horaInicial[1]);
        $horaFim = mktime( $horaFinal [0], $horaFinal [1]);
        //Verifica a dirença entre os horários
        $horaDiferenca = $horaFim - $horaIni;
        //Imprime a diferença entre eles
        $minutos = date('H',$horaDiferenca )*60 + date('i',$horaDiferenca );        */        
                
        if (request()->cookie('cms-visitante')){
            //$visitante = Crypt::decrypt(request()->cookie('cms-visitante'));
            $visitante = request()->cookie('cms-visitante');
            $counter->counter($visitante);
            return $next($request);
        }else{
            // Aqui guardamos o objeto Response em uma vari�vel
            $response = $next($request);
            $cookie = cookie()->forever('cms-visitante', $visitante);
            $response = $response->withCookie($cookie);
            $counter->counter($visitante);
            return $response;
        }
        
    }

    
}