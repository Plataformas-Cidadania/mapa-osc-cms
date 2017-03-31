<?php

namespace Cms\Models;



use Illuminate\Support\Facades\Cookie;

class Contador
{
    private function visitante(){
        
    }

    static public function criar_cookie(){


        $visitor = hash("SHA256", env('APP_KEY') . $_SERVER['REMOTE_ADDR'].time());

        //$hora = date('H:i:s');

        $horaInicial = date('H:i:s');
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
        $minutos = date('H',$horaDiferenca )*60 + date('i',$horaDiferenca );


        $cookie = Cookie::get('cmscounter');
        //$cookie = $_COOKIE[''];

        return $cookie;

        if($cookie !== false){
            $cookie = cookie('cms-counter', $visitor, $minutos);
            //$cookie = Cookie::make('cmscounter', $visitor, $minutos);
        }

        return $cookie;

        //setcookie("cms-counter", $visitor, $minutos);
        

    }

    static public function ver_cookie(){
        //return request()->cookie('num_visitas');
        //return cookie('cms-counter');
        //return $_COOKIE["cms-counter"];
        return Cookie::get('cms-counter');
    }
}
