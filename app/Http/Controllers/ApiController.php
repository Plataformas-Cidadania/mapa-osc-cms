<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function imprensa(){
        $noticias = \App\Noticia::select('data as dt_noticia', 'id as cd_noticia', 'titulo as tx_titulo_noticia', 'resumida as tx_resumo_noticia', 'imagem as tx_link_img_noticia', 'status')->where('status', 1)->get();
        $videos = \App\Video::select('data as dt_video', 'id as cd_video', 'titulo as tx_titulo_video', 'resumida as tx_resumo_video', 'imagem as tx_link_img_video')->where('status', 1)->get();

        $return = [
            'noticias' => $noticias,
            'videos' => $videos,
        ];

        return [$return];

    }

    public function noticiaByID($idNoticia){

        $row = \App\Noticia::select('titulo as tx_titulo_noticia', 'descricao as tx_descricao_noticia', 'data as dt_noticia')->where('status', 1)->find($idNoticia);

        $row->tx_descricao_noticia = str_replace('/imagens/geral', env('APP_URL').'/imagens/geral', $row->tx_descricao_noticia);

        return $row;
    }

    public function videoByID($idVideo){
        $row = \App\Video::select('titulo as tx_titulo_video', 'link_video as tx_link_video', 'resumida as tx_resumo_video', 'descricao as tx_descricao_video', 'data as dt_video')->where('status', 1)->find($idVideo);

        $row->tx_descricao_video = str_replace('/imagens/geral', env('APP_URL').'/imagens/geral', $row->tx_descricao_video);

        return $row;
    }

    public function editalByID($idEdital){
        return \App\Edital::select('titulo as tx_titulo_edital', 'instituicao as tx_instituicao_edital', 'area as tx_area_edital', 'data_vencimento as dt_vencimento_edital', 'edital as link_edital', 'status as it_status_edital')->find($idEdital);
    }

    public function editais(){
        return \App\Edital::select('titulo as tx_titulo_edital', 'instituicao as tx_instituicao_edital', 'area as tx_area_edital', 'data_vencimento as dt_vencimento_edital', 'edital as link_edital', 'status as it_status_edital')->get();
    }

    public function menuMrosc(){
        return \App\Mrosc::select('id as cd_menu_mrosc', 'titulo as tx_titulo_menu_mrosc', 'posicao')->where('status', 1)->get();
    }

    public function ConteudoMroscByID($id){

        $conteudoMrosc = \App\Mrosc::select('descricao as tx_descricao_conteudo')->where('status', 1)->find($id);
        $itensMrosc = \App\ItemMrosc::select('id as cd_itens_mrosc', 'titulo as tx_titulo_itens_mrosc', 'descricao as tx_descricao_itens_mrosc', 'imagem as tx_imagem_itens_mrosc', 'arquivo as tx_arquivo_itens_mrosc')->where('status', 1)->where('mrosc_id', $id)->get();

        $conteudoMrosc->tx_descricao_conteudo = str_replace('/imagens/geral', env('APP_URL').'/imagens/geral', $conteudoMrosc->tx_descricao_conteudo);

        foreach ($itensMrosc as $item) {
            $item->tx_descricao_itens_mrosc = str_replace('/imagens/geral', env('APP_URL').'/imagens/geral', $item->tx_descricao_itens_mrosc);
        }

        $return = [
            'conteudoMrosc' => $conteudoMrosc,
            'itensMrosc' => $itensMrosc,
        ];

        return [$return];
    }

    public function itensMrosc(){
        $row =  \App\Item::select('id as cd_itens_mrosc', 'titulo as tx_titulo_itens_mrosc', 'descricao as tx_descricao_itens_mrosc', 'imagem as tx_imagem_itens_mrosc', 'arquivo as tx_arquivo_itens_mrosc')->where('status', 1)->get();

        $row->tx_descricao_itens_mrosc = str_replace('/imagens/geral', env('APP_URL').'/imagens/geral', $row->tx_descricao_itens_mrosc);

        return $row;
    }

    public function moduloByID($idModulo){
        $modulos =  \App\Modulo::select('titulo as tx_titulo_modulo', 'descricao as tx_descricao_modulo', 'slug as tx_slug_modulo', 'imagem as tx_imagem_modulo', 'arquivo as tx_arquivo_modulo')->where('status', 1)->find($idModulo);
        $itens = \App\Item::select('id as cd_itens', 'titulo as tx_titulo_itens', 'descricao as tx_descricao_itens', 'imagem as tx_imagem_itens', 'arquivo as tx_arquivo_itens', 'posicao as cd_posicao_itens')->where('status', 1)->where('modulo_id', $idModulo)->get();

        $modulos->tx_descricao_modulo = str_replace('/imagens/geral', env('APP_URL').'/imagens/geral', $modulos->tx_descricao_modulo);
        foreach ($itens as $item) {
            $item->tx_descricao_itens = str_replace('/imagens/geral', env('APP_URL').'/imagens/geral', $item->tx_descricao_itens);
        }

        $return = [
            'modulos' => $modulos,
            'itens' => $itens,
        ];

        return [$return];
    }


    public function moduloBySlug($slug){
        $modulo =  \App\Modulo::select('id', 'titulo as tx_titulo_modulo', 'descricao as tx_descricao_modulo', 'slug as tx_slug_modulo', 'imagem as tx_imagem_modulo', 'arquivo as tx_arquivo_modulo')->where('status', 1)->where('slug', $slug)->first();
        $itens = \App\Item::select('id as cd_itens', 'titulo as tx_titulo_itens', 'descricao as tx_descricao_itens', 'imagem as tx_imagem_itens', 'arquivo as tx_arquivo_itens')->where('status', 1)->where('modulo_id', $modulo->id)->get();

        $modulo->tx_descricao_modulo = str_replace('/imagens/geral', env('APP_URL').'/imagens/geral', $modulo->tx_descricao_modulo);
        foreach ($itens as $item) {
            $item->tx_descricao_itens = str_replace('/imagens/geral', env('APP_URL').'/imagens/geral', $item->tx_descricao_itens);
        }

        $return = [
            'modulos' => $modulo,
            'itens' => $itens,
        ];

        return [$return];
    }

    public function moduloByTipo($idTipo){

        $modulo =  \App\Modulo::select('id', 'titulo as tx_titulo_modulo', 'descricao as tx_descricao_modulo', 'slug as tx_slug_modulo', 'imagem as tx_imagem_modulo', 'arquivo as tx_arquivo_modulo')->where('status', 1)->where('tipo_id', $idTipo)->first();

        $itens = \App\Item::select('id as cd_itens', 'titulo as tx_titulo_itens', 'descricao as tx_descricao_itens', 'imagem as tx_imagem_itens', 'arquivo as tx_arquivo_itens')->where('status', 1)->where('modulo_id', $modulo->id)->get();


        $modulo->tx_descricao_modulo = str_replace('/imagens/geral', env('APP_URL').'/imagens/geral', $modulo->tx_descricao_modulo);
        foreach ($itens as $item) {
            $item->tx_descricao_itens = str_replace('/imagens/geral', env('APP_URL').'/imagens/geral', $item->tx_descricao_itens);
        }

        $return = [
            'modulo' => $modulo,
            'itens' => $itens,
        ];

        return [$return];
    }

    public function modulosByTipoID($idTipo){

        return  \App\Modulo::select('id', 'titulo as tx_titulo_modulo')->where('status', 1)->where('tipo_id', $idTipo)->get();

    }




    public function webdoorByID(){
        $webdoors = \App\Webdoor::select('id as cd_webdoor', 'titulo as tx_titulo_webdoor', 'descricao as tx_descricao_webdoor', 'imagem as tx_imagem_webdoor', 'link as tx_link_webdoor')->where('status', 1)->get();

        foreach ($webdoors as $webdoor) {
            $webdoor->tx_descricao_webdoor = str_replace('/imagens/geral', env('APP_URL').'/imagens/geral', $webdoor->tx_descricao_webdoor);
        }

        return $webdoors;
    }
    
    public function links(){
        $links = \App\Link::select('titulo as tx_titulo_link', 'descricao as tx_descricao_link', 'imagem as tx_imagem_link', 'url as tx_link_link')->where('status', 1)->get();

        foreach ($links as $link) {
            $link->tx_descricao_link = str_replace('/imagens/links', env('APP_URL').'/imagens/geral', $link->tx_descricao_link);
        }

        return $links;
    }    
    
    public function equipes(){
        $equipes = \App\Equipe::select('id', 'titulo as tx_titulo_equipe', 'sub_titulo as tx_sub_titulo_equipe', 'descricao as tx_descricao_equipe')->get();

        $versoes = \App\Versao::select('id as versao_id','titulo as tx_titulo_versao', 'descricao as tx_descricao_itens')->where('status', 1)->get();

        foreach ($versoes as $versao) {
            $versoes = \App\Versao::select('id as versao_id','titulo as tx_titulo_versao', 'imagem as tx_imagem_itens', 'descricao as tx_descricao_itens')->where('status', 1)->get();
            foreach ($versoes as $versao) {
                $coordenadores = \App\ItemVersao::select('titulo as tx_nome_equipe', 'url as tx_url_equipe')->where('status', 1)->where('versao_id', $versao->versao_id)->where('tipo_id', 1)->get();
                $equipe = \App\ItemVersao::select('titulo as tx_nome_equipe', 'url as tx_url_equipe')->where('status', 1)->where('versao_id', $versao->versao_id)->where('tipo_id', 2)->get();

                $versao->coordenadores = $coordenadores;
                $versao->equipe = $equipe;
            }

        }

        $return = [
            'equipe' => $equipes,
            'versoes' => $versoes,
        ];

        return [$return];

    }



}
