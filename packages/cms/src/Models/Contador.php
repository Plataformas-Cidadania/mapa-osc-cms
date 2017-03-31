<?php

namespace Cms\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class Contador
{

    public function counter($visitante)
    {
        $visitante_id = $this->gravarVisitante($visitante);
        $pagina_id = $this->gravarPagina();
        $visita_id = $this->gravarSession($visitante_id, $pagina_id);
        $this->gravarHit($visita_id, $pagina_id);
    }

    private function gravarVisitante($visitante)
    {
        $v = new \Cms\Models\Visitante();

        $registro = $v->where([
            ['visitante', '=', $visitante],
        ])->get();

        if($registro->count() == 0){
            $dados = Array('visitante' => $visitante);
            $registro = $v->create($dados);
            $visitante_id = $registro->id;
        }else{
            $visitante_id = $registro[0]->id;
        }

        return $visitante_id;
    }

    private function gravarPagina()
    {
        $pg = new \Cms\Models\Pagina();

        $pagina = $this->getPagina();

        //Log::info($array_rota[0]);

        $registro = $pg->where([
            ['pagina', '=', $pagina],
        ])->get();

        if($registro->count() == 0){
            $dados = Array('pagina' => $pagina);
            $registro = $pg->create($dados);
            $pagina_id = $registro->id;
        }else{
            $pagina_id = $registro[0]->id;
        }

        return $pagina_id;
    }

    private function gravarSession($visitante_id, $pagina_id){
        $v = new \Cms\Models\Visita();

        $data_hora = date('Y-m-d H:i:s');
        $data_hora_limite = date('Y-m-d H:i:s', strtotime("$data_hora - 60 minutes"));

        $registro = $v->where([
            ['visitante_id', '=', $visitante_id],
            ['created_at', '>=', $data_hora_limite],
        ])->get();

        if($registro->count() == 0){
            $dados = Array('visitante_id' => $visitante_id, 'pagina_id' => $pagina_id);
            $registro = $v->create($dados);
            $visita_id = $registro->id;//Relison
        }else{
            $visita_id = $registro[0]->id;
        }

        return $visita_id;
    }

    private function gravarHit($visita_id, $pagina_id){
        $h = new \Cms\Models\Hit();
        $dados = Array('visita_id' => $visita_id, 'pagina_id' => $pagina_id);
        $h->create($dados);
    }

    private function getPagina(){
        $array_rota = explode('/', Route::getCurrentRoute()->getPath());
        if(empty($array_rota[0])){
            $pagina = 'home';
        }else{
            $pagina = $array_rota[0];
        }
        return $pagina;
    }
    
    public static function visitas(){
        $visitas = new Visita();
        $visitas = $visitas->all();
        return $visitas->count(); 
    }
    
    public static function visitasHoje(){
        $visitas = new Visita();
        $visitas = $visitas->whereDay('created_at', '=', date('d'))->count();
        return $visitas;
    }
    
    public static function visitasMes($mes = null){
        $visitas = new Visita();
        if($mes==null){
            $mes = date('m');
        }
        $visitas = $visitas->whereMonth('created_at', '=', $mes)->count();
        return $visitas;
    }
    
    public static function visitasAno($ano = null){
        $visitas = new Visita();
        if($ano==null){
            $ano = date('Y');
        }
        $visitas = $visitas->whereYear('created_at', '=', $ano)->count();
        return $visitas;
    }

    public static function comparaMes($mesAnterior){

        $visitasMesAtual = self::visitasMes();
        $visitasMesAnterior =  self::visitasMes($mesAnterior);

        if($visitasMesAnterior==0){
            return 100;
        }

        //$porcentagem = (($visitasMesAtual-$visitasMesAnterior)/$visitasMesAnterior)*100;
        $porcentagem = ($visitasMesAtual/$visitasMesAnterior-1)*100;


        if(!is_int($porcentagem)){
            $porcentagem = number_format($porcentagem, 1, ',', '.');
        }

        return $porcentagem;
    }

    public static function hits(){
        $hits = new Hit();
        $hits = $hits->all();
        return $hits->count();
    }
    
}
