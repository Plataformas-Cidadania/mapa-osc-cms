<?php
if ( ! function_exists('dataEn2Br') ){
    function dataEn2Br($valor, $tipo){

        $meses_extenso = [
            "January" => "Janeiro", "February" => "Fevereiro", "March" => "Março", "April" => "Abril",
            "May" => "Maio", "June" => "Junho", "July" => "Julho", "August" => "Agosto", "September" => "Setembro",
            "October" => "Outubro", "November" => "Novembro", "December" => "Dezembro",
        ];

        $meses_abreviados = [
            "Jan" => "Jan", "Feb" => "Fev", "Mar" => "Mar", "Apr" => "Abr",
            "May" => "Mai", "Jun" => "Jun", "Jul" => "Jul", "Aug" => "Ago", "Sep" => "Set",
            "Oct" => "Out", "Nov" => "Nov", "Dec" => "Dez",
        ];

        if($tipo=='mes_extenso'){
            return $meses_extenso[$valor];
        }

        if($tipo=='mes_abreviado'){
            return $meses_abreviados[$valor];
        }
        
        
        return false;
    }
}

if ( ! function_exists('nomeMes') ){
    function nomeMes($valor, $tipo){
        
        //\Illuminate\Support\Facades\Log::info($valor);

        if($valor <= 0){
            $valor = 12+$valor;
        }

        $meses_extenso = [
            1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril",
            5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto",
            9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro",
        ];

        $meses_abreviados = [
            "01" => "Jan", "02" => "Fev", "03" => "Mar", "04" => "Abr",
            "05" => "Mai", "06" => "Jun", "07" => "Jul", "08" => "Ago",
            "09" => "Set", "10" => "Out", "11" => "Nov", "12" => "Dez",
        ];

        if($tipo=='mes_extenso'){
            return $meses_extenso[$valor];
        }

        if($tipo=='mes_abreviado'){
            return $meses_abreviados[$valor];
        }


        return false;
    }
}

if ( ! function_exists('clean') ) {
    function clean($string) {

        $string = str_replace(' ', '-', $string); // troca espaços por hífens.
        
        $string = strtolower($string);

        $string = preg_replace("/[áàâãä]/", "a", $string);
        $string = preg_replace("/[éèê]/", "e", $string);
        $string = preg_replace("/[íì]/", "i", $string);
        $string = preg_replace("/[óòôõö]/", "o", $string);
        $string = preg_replace("/[úùü]/", "u", $string);
        $string = preg_replace("/[ç]/", "c", $string);
        
        $string = preg_replace('/[^A-Za-z0-9\-.]/', '', $string); // remove caracteres especiais.

        return preg_replace('/-+/', '-', $string); // trocas multiplos hífens por apenas um.
    }
}

if ( ! function_exists('codigoYoutube') ) {
    function codigoYoutube($link) {
        $partes_link = explode('/', $link);
        if(count($partes_link)<4){
            return '';
        }
        $codigo_youtube = $partes_link[3];
        if(substr($codigo_youtube, 0,5)=="watch"){
            $partes_codigo = explode('=', $codigo_youtube);
            $codigo_youtube = $partes_codigo[1];
        }


        return $codigo_youtube;
    }
}

