<?php

namespace Cms\Controllers;

use Cms\Models\ImagemCms;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class ItemVersaoController extends Controller
{
    
    

    public function __construct()
    {
        $this->item = new \App\ItemVersao();
        $this->campos = [
            'imagem', 'arquivo', 'tipo_id', 'integrante_id', 'versao_id', 'cmsuser_id',
        ];
        $this->pathImagem = public_path().'/imagens/items-versao';
        $this->sizesImagem = [
            'xs' => ['width' => 140, 'height' => 79],
            'sm' => ['width' => 480, 'height' => 270],
            'md' => ['width' => 580, 'height' => 326],
            'lg' => ['width' => 1170, 'height' => 658]
        ];
        $this->widthOriginal = true;

        $this->pathArquivo = public_path().'/arquivos/items-versao';
    }

    function index($versao_id)
    {

        $integrantes = \App\Integrante::orderBy('titulo')->pluck('titulo', 'id')->all();
        $items = \App\ItemVersao::all();
        //$idiomas = \App\Idioma::lists('titulo', 'id')->all();

        return view('cms::item_versao.listar', ['items' => $items, 'versao_id' => $versao_id, 'integrantes' => $integrantes]);
        //return view('cms::item_versao.listar', ['items' => $items, 'modulo_id' => $modulo_id, 'idiomas' => $idiomas]);
    }

    public function listar(Request $request)
    {

        $campos = explode(", ", $request->campos);

        $items = DB::table('items_versoes')
            ->join('integrantes', 'integrantes.id', '=', 'items_versoes.integrante_id')
            ->select($campos)
            ->where([
                [$request->campoPesquisa, 'ilike', "%$request->dadoPesquisa%"],
                ['versao_id', $request->versao_id],
            ])
            ->orderBy($request->ordem, $request->sentido)
            ->paginate($request->itensPorPagina);
        return ['items' => $items, 'tipos' => config('constants.TIPOS')];
    }


    public function inserir(Request $request)
    {

        $data = $request->all();

        $data['item'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                $data['item'] += [$campo => ''];
            }
        }

        $file = $request->file('file');
        $arquivo = $request->file('arquivo');


        $successFile = true;
        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $successFile = $imagemCms->inserir($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal);
            if($successFile){
                $data['item']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['item']['arquivo'] = $filenameArquivo;
            }
        }


        if($successFile && $successArquivo){
            return $this->item->create($data['item']);
        }else{
            return "erro";
        }


        return $this->item->create($data['item']);

    }

    public function detalhar($id)
    {
        $integrantes = \App\Integrante::orderBy('titulo')->pluck('titulo', 'id')->all();
        $item = $this->item->where([
            ['id', '=', $id],
        ])->firstOrFail();
        //$idiomas = \App\Idioma::lists('titulo', 'id')->all();

        $versao_id = $item->versao_id;

        return view('cms::item_versao.detalhar', ['item' => $item, 'versao_id' => $versao_id, 'integrantes' => $integrantes]);
        //return view('cms::item_versao.detalhar', ['item' => $item, 'versao_id' => $versao_id, 'idiomas' => $idiomas]);
    }

    /*public function alterar(Request $request, $id)
    {
        $data = $request->all();
        $data['item'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem'){
                    $data['item'] += [$campo => ''];
                }
            }
        }
        $item = $this->item->where([
            ['id', '=', $id],
        ])->firstOrFail();

        $file = $request->file('file');

        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $success = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $item);
            if($success){
                $data['item']['imagem'] = $filename;
                $item->update($data['item']);
                return $item->imagem;
            }else{
                return "erro";
            }
        }

        //remover imagem
        if($data['removerImagem']){
            $data['item']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$item->imagem)) {
                unlink($this->pathImagem . "/" . $item->imagem);
            }
        }

        $item->update($data['item']);
        return "Gravado com sucesso";
    }*/

    public function alterar(Request $request, $id)
    {
        $data = $request->all();

        //return $data;

        $data['item'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem' && $campo!='arquivo'){
                    $data['item'] += [$campo => ''];
                }
            }
        }
        $item = $this->item->where([
            ['id', '=', $id],
        ])->firstOrFail();


        $file = $request->file('file');
        $arquivo = $request->file('arquivo');

        //remover imagem
        if($data['removerImagem']){
            $data['item']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$item->imagem)) {
                unlink($this->pathImagem . "/" . $item->imagem);
            }
        }


        if($data['removerArquivo']){
            $data['item']['arquivo'] = '';
            if(file_exists($this->pathArquivo."/".$item->arquivo)) {
                unlink($this->pathArquivo . "/" . $item->arquivo);
            }
        }


        $successFile = true;
        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $successFile = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $item);
            if($successFile){
                $data['item']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['item']['arquivo'] = $filenameArquivo;
            }
        }

        if($successFile && $successArquivo){

            $item->update($data['item']);
            return $item->imagem;
        }else{
            return "erro";
        }

        //$item->update($data['item']);
        //return "Gravado com sucesso";
    }

    public function excluir($id)
    {
        //Auth::loginUsingId(2);

        $item = $this->item->where([
            ['id', '=', $id],
        ])->firstOrFail();

        //remover imagens        
        if(!empty($item->imagem)){
            //remover imagens
            $imagemCms = new ImagemCms();
            $imagemCms->excluir($this->pathImagem, $this->sizesImagem, $item);
        }


        if(!empty($item->arquivo)) {
            if (file_exists($this->pathArquivo . "/" . $item->arquivo)) {
                unlink($this->pathArquivo . "/" . $item->arquivo);
            }
        }

        $item->delete();

    }


    public function status($id)
    {
        $tipo_atual = DB::table('items_versoes')->where('id', $id)->first();
        $status = $tipo_atual->status == 0 ? 1 : 0;
        DB::table('items_versoes')->where('id', $id)->update(['status' => $status]);

    }

}
