<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function imprensa(){
        $noticias = \App\Noticia::select('data as dt_noticia', 'id as cd_noticia', 'titulo as tx_titulo_noticia', 'resumida as tx_resumo_noticia', 'imagem as tx_link_img_noticia')->get();
        $videos = \App\Video::select('data as dt_video', 'id as cd_video', 'titulo as tx_titulo_video', 'resumida as tx_resumo_video', 'imagem as tx_link_img_video')->get();

        $return = [
            'noticias' => $noticias,
            'videos' => $videos,
        ];

        return [$return];

    }

    public function noticiaByID($idNoticia){
        return \App\Noticia::select('titulo as tx_titulo_noticia', 'descricao as tx_descricao_noticia', 'data as dt_noticia')->find($idNoticia);
    }

    public function videoByID($idVideo){
        return \App\Video::select('titulo as tx_titulo_video', 'link_video as tx_link_video', 'resumida as tx_resumo_video', 'descricao as tx_descricao_video', 'data as dt_video')->find($idVideo);
    }
}
