<?php

namespace Cms\Controllers;

use Cms\Models\ImagemCms;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class EquipeController extends Controller
{
    
    

    public function __construct()
    {
        $this->equipe = new \App\Equipe;
        $this->campos = [
            'imagem', 'titulo', 'sub_titulo', 'descricao', 'arquivo', 'cmsuser_id',
        ];
        $this->pathImagem = public_path().'/imagens/equipes';
        $this->sizesImagem = [
            'xs' => ['width' => 140, 'height' => 79],
            'sm' => ['width' => 480, 'height' => 270],
            'md' => ['width' => 580, 'height' => 326],
            'lg' => ['width' => 1170, 'height' => 658]
        ];
        $this->widthOriginal = true;

        $this->pathArquivo = public_path().'/arquivos/equipes';
    }

    function index()
    {

        $equipes = \App\Equipe::all();
        //$idiomas = \App\Idioma::lists('titulo', 'id')->all();


        return view('cms::equipe.listar', ['equipes' => $equipes]);
        //return view('cms::equipe.listar', ['equipes' => $equipes, 'idiomas' => $idiomas]);
    }

    public function listar(Request $request)
    {

        //Log::info('CAMPOS: '.$request->campos);

        //Auth::loginUsingId(2);

        $campos = explode(", ", $request->campos);

        $equipes = DB::table('equipes')
            ->select($campos)
            ->where([
                [$request->campoPesquisa, 'ilike', "%$request->dadoPesquisa%"],
            ])
            ->orderBy($request->ordem, $request->sentido)
            ->paginate($request->itensPorPagina);
        return $equipes;
    }


    public function inserir(Request $request)
    {

        $data = $request->all();

        $data['equipe'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                $data['equipe'] += [$campo => ''];
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
                $data['equipe']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['equipe']['arquivo'] = $filenameArquivo;
            }
        }


        if($successFile && $successArquivo){
            return $this->equipe->create($data['equipe']);
        }else{
            return "erro";
        }


        return $this->equipe->create($data['equipe']);

    }

    public function detalhar($id)
    {
        $equipe = $this->equipe->where([
            ['id', '=', $id],
        ])->firstOrFail();
        //$idiomas = \App\Idioma::lists('titulo', 'id')->all();

        return view('cms::equipe.detalhar', ['equipe' => $equipe]);
        //return view('cms::equipe.detalhar', ['equipe' => $equipe, 'idiomas' => $idiomas]);
    }

    /*public function alterar(Request $request, $id)
    {
        $data = $request->all();
        $data['equipe'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem'){
                    $data['equipe'] += [$campo => ''];
                }
            }
        }
        $equipe = $this->equipe->where([
            ['id', '=', $id],
        ])->firstOrFail();

        $file = $request->file('file');

        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $success = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $equipe);
            if($success){
                $data['equipe']['imagem'] = $filename;
                $equipe->update($data['equipe']);
                return $equipe->imagem;
            }else{
                return "erro";
            }
        }

        //remover imagem
        if($data['removerImagem']){
            $data['equipe']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$equipe->imagem)) {
                unequipe($this->pathImagem . "/" . $equipe->imagem);
            }
        }

        $equipe->update($data['equipe']);
        return "Gravado com sucesso";
    }*/

    public function alterar(Request $request, $id)
    {
        $data = $request->all();

        //return $data;

        $data['equipe'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem' && $campo!='arquivo'){
                    $data['equipe'] += [$campo => ''];
                }
            }
        }
        $equipe = $this->equipe->where([
            ['id', '=', $id],
        ])->firstOrFail();


        $file = $request->file('file');
        $arquivo = $request->file('arquivo');

	Log::info($request);

        //remover imagem
        if($data['removerImagem']){
            $data['equipe']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$equipe->imagem)) {
                unequipe($this->pathImagem . "/" . $equipe->imagem);
            }
        }


        if($data['removerArquivo']){
            $data['equipe']['arquivo'] = '';
            if(file_exists($this->pathArquivo."/".$equipe->arquivo)) {
                unequipe($this->pathArquivo . "/" . $equipe->arquivo);
            }
        }


        $successFile = true;
        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $successFile = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $equipe);
            if($successFile){
                $data['equipe']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['equipe']['arquivo'] = $filenameArquivo;
            }
        }

        if($successFile && $successArquivo){

            $equipe->update($data['equipe']);
            return $equipe->imagem;
        }else{
            return "erro";
        }

        //$equipe->update($data['equipe']);
        //return "Gravado com sucesso";
    }

    public function excluir($id)
    {
        //Auth::loginUsingId(2);

        $equipe = $this->equipe->where([
            ['id', '=', $id],
        ])->firstOrFail();

        //remover imagens        
        if(!empty($equipe->imagem)){
            //remover imagens
            $imagemCms = new ImagemCms();
            $imagemCms->excluir($this->pathImagem, $this->sizesImagem, $equipe);
        }


        if(!empty($equipe->arquivo)) {
            if (file_exists($this->pathArquivo . "/" . $equipe->arquivo)) {
                unequipe($this->pathArquivo . "/" . $equipe->arquivo);
            }
        }

        $equipe->delete();

    }

    


}
