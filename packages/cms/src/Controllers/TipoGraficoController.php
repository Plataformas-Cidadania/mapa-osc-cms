<?php

namespace Cms\Controllers;

use Cms\Models\ImagemCms;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class TipoController extends Controller
{
    
    

    public function __construct()
    {
        $this->tipo = new \App\Tipo;
        $this->campos = [
            'imagem', 'titulo', 'arquivo', 'cmsuser_id',
        ];
        $this->pathImagem = public_path().'/imagens/tipos';
        $this->sizesImagem = [
            'xs' => ['width' => 140, 'height' => 79],
            'sm' => ['width' => 480, 'height' => 270],
            'md' => ['width' => 580, 'height' => 326],
            'lg' => ['width' => 1170, 'height' => 658]
        ];
        $this->widthOriginal = true;

        $this->pathArquivo = public_path().'/arquivos/tipos';
    }

    function index()
    {

        $tipos = \App\Tipo::all();
        //$idiomas = \App\Idioma::lists('titulo', 'id')->all();


        return view('cms::tipo.listar', ['tipos' => $tipos/*, 'idiomas' => $idiomas*/]);
    }

    public function listar(Request $request)
    {

        //Log::info('CAMPOS: '.$request->campos);

        //Auth::loginUsingId(2);

        $campos = explode(", ", $request->campos);

        $tipos = DB::table('tipos')
            ->select($campos)
            ->where([
                [$request->campoPesquisa, 'ilike', "%$request->dadoPesquisa%"],
            ])
            ->orderBy($request->ordem, $request->sentido)
            ->paginate($request->itensPorPagina);
        return $tipos;
    }


    public function inserir(Request $request)
    {

        $data = $request->all();

        $data['tipo'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                $data['tipo'] += [$campo => ''];
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
                $data['tipo']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['tipo']['arquivo'] = $filenameArquivo;
            }
        }


        if($successFile && $successArquivo){
            return $this->tipo->create($data['tipo']);
        }else{
            return "erro";
        }


        return $this->tipo->create($data['tipo']);

    }

    public function detalhar($id)
    {
        $tipo = $this->tipo->where([
            ['id', '=', $id],
        ])->firstOrFail();
        //$idiomas = \App\Idioma::lists('titulo', 'id')->all();

        return view('cms::tipo.detalhar', ['tipo' => $tipo/*, 'idiomas' => $idiomas*/]);
    }

    /*public function alterar(Request $request, $id)
    {
        $data = $request->all();
        $data['tipo'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem'){
                    $data['tipo'] += [$campo => ''];
                }
            }
        }
        $tipo = $this->tipo->where([
            ['id', '=', $id],
        ])->firstOrFail();

        $file = $request->file('file');

        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $success = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $tipo);
            if($success){
                $data['tipo']['imagem'] = $filename;
                $tipo->update($data['tipo']);
                return $tipo->imagem;
            }else{
                return "erro";
            }
        }

        //remover imagem
        if($data['removerImagem']){
            $data['tipo']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$tipo->imagem)) {
                unlink($this->pathImagem . "/" . $tipo->imagem);
            }
        }

        $tipo->update($data['tipo']);
        return "Gravado com sucesso";
    }*/

    public function alterar(Request $request, $id)
    {
        $data = $request->all();

        //return $data;

        $data['tipo'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem' && $campo!='arquivo'){
                    $data['tipo'] += [$campo => ''];
                }
            }
        }
        $tipo = $this->tipo->where([
            ['id', '=', $id],
        ])->firstOrFail();


        $file = $request->file('file');
        $arquivo = $request->file('arquivo');

        //remover imagem
        if($data['removerImagem']){
            $data['tipo']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$tipo->imagem)) {
                unlink($this->pathImagem . "/" . $tipo->imagem);
            }
        }


        if($data['removerArquivo']){
            $data['tipo']['arquivo'] = '';
            if(file_exists($this->pathArquivo."/".$tipo->arquivo)) {
                unlink($this->pathArquivo . "/" . $tipo->arquivo);
            }
        }


        $successFile = true;
        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $successFile = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $tipo);
            if($successFile){
                $data['tipo']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['tipo']['arquivo'] = $filenameArquivo;
            }
        }

        if($successFile && $successArquivo){

            $tipo->update($data['tipo']);
            return $tipo->imagem;
        }else{
            return "erro";
        }

        //$tipo->update($data['tipo']);
        //return "Gravado com sucesso";
    }

    public function excluir($id)
    {
        //Auth::loginUsingId(2);

        $tipo = $this->tipo->where([
            ['id', '=', $id],
        ])->firstOrFail();

        //remover imagens        
        if(!empty($tipo->imagem)){
            //remover imagens
            $imagemCms = new ImagemCms();
            $imagemCms->excluir($this->pathImagem, $this->sizesImagem, $tipo);
        }


        if(!empty($tipo->arquivo)) {
            if (file_exists($this->pathArquivo . "/" . $tipo->arquivo)) {
                unlink($this->pathArquivo . "/" . $tipo->arquivo);
            }
        }

        $tipo->delete();

    }
    public function status($id)
    {
        $tipo_atual = DB::table('tipos')->where('id', $id)->first();
        $status = $tipo_atual->status == 0 ? 1 : 0;
        DB::table('tipos')->where('id', $id)->update(['status' => $status]);

    }


}
