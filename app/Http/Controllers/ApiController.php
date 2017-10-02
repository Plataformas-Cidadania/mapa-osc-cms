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

    public function editalByID($idEdital){
        return \App\Edital::select('titulo as tx_titulo_edital', 'instituicao as tx_instituicao_edital', 'area as tx_area_edital', 'data_vencimento as dt_vencimento_edital', 'edital as link_edital', 'status as it_status_edital')->find($idEdital);
    }

    public function editais(){
        return \App\Edital::select('titulo as tx_titulo_edital', 'instituicao as tx_instituicao_edital', 'area as tx_area_edital', 'data_vencimento as dt_vencimento_edital', 'edital as link_edital', 'status as it_status_edital')->get();
    }

    public function menuMrosc(){
        return \App\Mrosc::select('id as cd_menu_mrosc', 'titulo as tx_titulo_menu_mrosc', 'posicao')->get();
    }

    public function ConteudoMroscByID($id){
        //return \App\Mrosc::select('descricao as tx_descricao_conteudo')->find($id);

        $conteudoMrosc = \App\Mrosc::select('descricao as tx_descricao_conteudo')->find($id);
        $itensMrosc = \App\Item::select('id as cd_itens_mrosc', 'titulo as tx_titulo_itens_mrosc', 'descricao as tx_descricao_itens_mrosc', 'imagem as tx_imagem_itens_mrosc', 'arquivo as tx_arquivo_itens_mrosc')->where('modulo_id', $id)->get();

        $return = [
            'conteudoMrosc' => $conteudoMrosc,
            'itensMrosc' => $itensMrosc,
        ];

        return [$return];
    }

    public function itensMrosc(){
        return \App\Item::select('id as cd_itens_mrosc', 'titulo as tx_titulo_itens_mrosc', 'descricao as tx_descricao_itens_mrosc', 'imagem as tx_imagem_itens_mrosc', 'arquivo as tx_arquivo_itens_mrosc')->get();
    }

    public function moduloByID($idModulo){
        return \App\Modulo::select('titulo as tx_titulo_modulo', 'descricao as tx_descricao_modulo', 'imagem as tx_imagem_modulo', 'arquivo as tx_arquivo_modulo')->find($idModulo);
    }

    public function webdoorByID(){
        return \App\Webdoor::select('id as cd_webdoor', 'titulo as tx_titulo_webdoor', 'descricao as tx_descricao_webdoor', 'imagem as tx_imagem_webdoor', 'link as tx_link_webdoor')->get();
    }
}
