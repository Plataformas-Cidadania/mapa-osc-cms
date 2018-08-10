<?php

namespace Cms\Controllers;

use Cms\Models\ImagemCms;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class IntegranteController extends Controller
{
    
    

    public function __construct()
    {
        $this->integrante = new \App\Integrante;
        $this->campos = [
            'imagem', 'titulo', 'url', 'arquivo', 'cmsuser_id',
        ];
        $this->pathImagem = public_path().'/imagens/integrantes';
        $this->sizesImagem = [
            'xs' => ['width' => 140, 'height' => 79],
            'sm' => ['width' => 480, 'height' => 270],
            'md' => ['width' => 580, 'height' => 326],
            'lg' => ['width' => 1170, 'height' => 658]
        ];
        $this->widthOriginal = true;

        $this->pathArquivo = public_path().'/arquivos/integrantes';
    }

    function index()
    {

        $integrantes = \App\Integrante::all();
        //$idiomas = \App\Idioma::lists('titulo', 'id')->all();


        return view('cms::integrante.listar', ['integrantes' => $integrantes]);
        //return view('cms::integrante.listar', ['integrantes' => $integrantes, 'idiomas' => $idiomas]);
    }

    public function listar(Request $request)
    {

        //Log::info('CAMPOS: '.$request->campos);

        //Auth::loginUsingId(2);

        $campos = explode(", ", $request->campos);

        $integrantes = DB::table('integrantes')
            ->select($campos)
            ->where([
                [$request->campoPesquisa, 'ilike', "%$request->dadoPesquisa%"],
            ])
            ->orderBy($request->ordem, $request->sentido)
            ->paginate($request->itensPorPagina);
        return $integrantes;
    }


    public function inserir(Request $request)
    {

        $data = $request->all();

        $data['integrante'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                $data['integrante'] += [$campo => ''];
            }
        }

        $file = $request->file('file');
        $arquivo = $request->file('arquivo');
	
	Log::info($request);

        $successFile = true;
        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $successFile = $imagemCms->inserir($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal);
            if($successFile){
                $data['integrante']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['integrante']['arquivo'] = $filenameArquivo;
            }
        }


        if($successFile && $successArquivo){
            return $this->integrante->create($data['integrante']);
        }else{
            return "erro";
        }


        return $this->integrante->create($data['integrante']);

    }

    public function detalhar($id)
    {
        $integrante = $this->integrante->where([
            ['id', '=', $id],
        ])->firstOrFail();
        //$idiomas = \App\Idioma::lists('titulo', 'id')->all();

        return view('cms::integrante.detalhar', ['integrante' => $integrante]);
        //return view('cms::integrante.detalhar', ['integrante' => $integrante, 'idiomas' => $idiomas]);
    }

    /*public function alterar(Request $request, $id)
    {
        $data = $request->all();
        $data['integrante'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem'){
                    $data['integrante'] += [$campo => ''];
                }
            }
        }
        $integrante = $this->integrante->where([
            ['id', '=', $id],
        ])->firstOrFail();

        $file = $request->file('file');

        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $success = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $integrante);
            if($success){
                $data['integrante']['imagem'] = $filename;
                $integrante->update($data['integrante']);
                return $integrante->imagem;
            }else{
                return "erro";
            }
        }

        //remover imagem
        if($data['removerImagem']){
            $data['integrante']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$integrante->imagem)) {
                unlink($this->pathImagem . "/" . $integrante->imagem);
            }
        }

        $integrante->update($data['integrante']);
        return "Gravado com sucesso";
    }*/

    public function alterar(Request $request, $id)
    {
        $data = $request->all();

        //return $data;

        $data['integrante'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem' && $campo!='arquivo'){
                    $data['integrante'] += [$campo => ''];
                }
            }
        }
        $integrante = $this->integrante->where([
            ['id', '=', $id],
        ])->firstOrFail();


        $file = $request->file('file');
        $arquivo = $request->file('arquivo');

	Log::info($request);

        //remover imagem
        if($data['removerImagem']){
            $data['integrante']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$integrante->imagem)) {
                unlink($this->pathImagem . "/" . $integrante->imagem);
            }
        }


        if($data['removerArquivo']){
            $data['integrante']['arquivo'] = '';
            if(file_exists($this->pathArquivo."/".$integrante->arquivo)) {
                unlink($this->pathArquivo . "/" . $integrante->arquivo);
            }
        }


        $successFile = true;
        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $successFile = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $integrante);
            if($successFile){
                $data['integrante']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['integrante']['arquivo'] = $filenameArquivo;
            }
        }

        if($successFile && $successArquivo){

            $integrante->update($data['integrante']);
            return $integrante->imagem;
        }else{
            return "erro";
        }

        //$integrante->update($data['integrante']);
        //return "Gravado com sucesso";
    }

    public function excluir($id)
    {
        //Auth::loginUsingId(2);

        $integrante = $this->integrante->where([
            ['id', '=', $id],
        ])->firstOrFail();

        //remover imagens        
        if(!empty($integrante->imagem)){
            //remover imagens
            $imagemCms = new ImagemCms();
            $imagemCms->excluir($this->pathImagem, $this->sizesImagem, $integrante);
        }


        if(!empty($integrante->arquivo)) {
            if (file_exists($this->pathArquivo . "/" . $integrante->arquivo)) {
                unlink($this->pathArquivo . "/" . $integrante->arquivo);
            }
        }

        $integrante->delete();

    }

    


}
