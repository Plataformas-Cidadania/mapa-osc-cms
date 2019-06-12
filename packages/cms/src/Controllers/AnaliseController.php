<?php

namespace Cms\Controllers;

use Cms\Models\ImagemCms;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class AnaliseController extends Controller
{
    
    

    public function __construct()
    {
        $this->analise = new \App\Analise;
        $this->campos = [
            'imagem', 'titulo', 'resumida', 'descricao', 'arquivo', 'data', 'cmsuser_id',
        ];
        $this->pathImagem = public_path().'/imagens/analises';
        $this->sizesImagem = [
            'xs' => ['width' => 140, 'height' => 79],
            'sm' => ['width' => 480, 'height' => 270],
            'md' => ['width' => 580, 'height' => 326],
            'lg' => ['width' => 1170, 'height' => 658]
        ];
        $this->widthOriginal = true;

        $this->pathArquivo = public_path().'/arquivos/analises';
    }

    function index()
    {

        $analises = \App\Analise::all();
        //$idiomas = \App\Idioma::lists('titulo', 'id')->all();


        return view('cms::analise.listar', ['analises' => $analises]);
        //return view('cms::analise.listar', ['analises' => $analises, 'idiomas' => $idiomas]);
    }

    public function listar(Request $request)
    {

        //Log::info('CAMPOS: '.$request->campos);

        //Auth::loginUsingId(2);

        $campos = explode(", ", $request->campos);

        $analises = DB::table('analises')
            ->select($campos)
            ->where([
                [$request->campoPesquisa, 'ilike', "%$request->dadoPesquisa%"],
            ])
            ->orderBy($request->ordem, $request->sentido)
            ->paginate($request->itensPorPagina);
        return $analises;
    }


    public function inserir(Request $request)
    {

        $data = $request->all();

        $data['analise'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                $data['analise'] += [$campo => ''];
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
                $data['analise']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['analise']['arquivo'] = $filenameArquivo;
            }
        }


        if($successFile && $successArquivo){
            return $this->analise->create($data['analise']);
        }else{
            return "erro";
        }


        return $this->analise->create($data['analise']);

    }

    public function detalhar($id)
    {
        $analise = $this->analise->where([
            ['id', '=', $id],
        ])->firstOrFail();
        //$idiomas = \App\Idioma::lists('titulo', 'id')->all();

        return view('cms::analise.detalhar', ['analise' => $analise]);
        //return view('cms::analise.detalhar', ['analise' => $analise, 'idiomas' => $idiomas]);
    }

    /*public function alterar(Request $request, $id)
    {
        $data = $request->all();
        $data['analise'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem'){
                    $data['analise'] += [$campo => ''];
                }
            }
        }
        $analise = $this->analise->where([
            ['id', '=', $id],
        ])->firstOrFail();

        $file = $request->file('file');

        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $success = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $analise);
            if($success){
                $data['analise']['imagem'] = $filename;
                $analise->update($data['analise']);
                return $analise->imagem;
            }else{
                return "erro";
            }
        }

        //remover imagem
        if($data['removerImagem']){
            $data['analise']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$analise->imagem)) {
                unlink($this->pathImagem . "/" . $analise->imagem);
            }
        }

        $analise->update($data['analise']);
        return "Gravado com sucesso";
    }*/

    public function alterar(Request $request, $id)
    {
        $data = $request->all();

        //return $data;

        $data['analise'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem' && $campo!='arquivo'){
                    $data['analise'] += [$campo => ''];
                }
            }
        }
        $analise = $this->analise->where([
            ['id', '=', $id],
        ])->firstOrFail();


        $file = $request->file('file');
        $arquivo = $request->file('arquivo');



        //remover imagem
        if($data['removerImagem']){
            $data['analise']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$analise->imagem)) {
                unlink($this->pathImagem . "/" . $analise->imagem);
            }
        }


        if($data['removerArquivo']){
            $data['analise']['arquivo'] = '';
            if(file_exists($this->pathArquivo."/".$analise->arquivo)) {
                unlink($this->pathArquivo . "/" . $analise->arquivo);
            }
        }


        $successFile = true;
        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $successFile = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $analise);
            if($successFile){
                $data['analise']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['analise']['arquivo'] = $filenameArquivo;
            }
        }

        if($successFile && $successArquivo){

            $analise->update($data['analise']);
            return $analise->imagem;
        }else{
            return "erro";
        }

        //$analise->update($data['analise']);
        //return "Gravado com sucesso";
    }

    public function excluir($id)
    {
        //Auth::loginUsingId(2);

        $analise = $this->analise->where([
            ['id', '=', $id],
        ])->firstOrFail();

        //remover imagens        
        if(!empty($analise->imagem)){
            //remover imagens
            $imagemCms = new ImagemCms();
            $imagemCms->excluir($this->pathImagem, $this->sizesImagem, $analise);
        }


        if(!empty($analise->arquivo)) {
            if (file_exists($this->pathArquivo . "/" . $analise->arquivo)) {
                unlink($this->pathArquivo . "/" . $analise->arquivo);
            }
        }

        $analise->delete();

    }

    public function status($id)
    {
        $tipo_atual = DB::table('analises')->where('id', $id)->first();
        $status = $tipo_atual->status == 0 ? 1 : 0;
        DB::table('analises')->where('id', $id)->update(['status' => $status]);

    }


}
