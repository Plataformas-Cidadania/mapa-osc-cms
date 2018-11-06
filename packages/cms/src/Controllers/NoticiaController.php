<?php

namespace Cms\Controllers;

use Cms\Models\ImagemCms;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class NoticiaController extends Controller
{
    
    

    public function __construct()
    {
        $this->noticia = new \App\Noticia;
        $this->campos = [
            'imagem', 'titulo', 'resumida', 'descricao', 'arquivo', 'data', 'cmsuser_id',
        ];
        $this->pathImagem = public_path().'/imagens/noticias';
        $this->sizesImagem = [
            'xs' => ['width' => 140, 'height' => 79],
            'sm' => ['width' => 480, 'height' => 270],
            'md' => ['width' => 580, 'height' => 326],
            'lg' => ['width' => 1170, 'height' => 658]
        ];
        $this->widthOriginal = true;

        $this->pathArquivo = public_path().'/arquivos/noticias';
    }

    function index()
    {

        $noticias = \App\Noticia::all();
        //$idiomas = \App\Idioma::lists('titulo', 'id')->all();


        return view('cms::noticia.listar', ['noticias' => $noticias]);
        //return view('cms::noticia.listar', ['noticias' => $noticias, 'idiomas' => $idiomas]);
    }

    public function listar(Request $request)
    {

        //Log::info('CAMPOS: '.$request->campos);

        //Auth::loginUsingId(2);

        $campos = explode(", ", $request->campos);

        $noticias = DB::table('noticias')
            ->select($campos)
            ->where([
                [$request->campoPesquisa, 'ilike', "%$request->dadoPesquisa%"],
            ])
            ->orderBy($request->ordem, $request->sentido)
            ->paginate($request->itensPorPagina);
        return $noticias;
    }


    public function inserir(Request $request)
    {

        $data = $request->all();

        $data['noticia'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                $data['noticia'] += [$campo => ''];
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
                $data['noticia']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['noticia']['arquivo'] = $filenameArquivo;
            }
        }


        if($successFile && $successArquivo){
            return $this->noticia->create($data['noticia']);
        }else{
            return "erro";
        }


        return $this->noticia->create($data['noticia']);

    }

    public function detalhar($id)
    {
        $noticia = $this->noticia->where([
            ['id', '=', $id],
        ])->firstOrFail();
        //$idiomas = \App\Idioma::lists('titulo', 'id')->all();

        return view('cms::noticia.detalhar', ['noticia' => $noticia]);
        //return view('cms::noticia.detalhar', ['noticia' => $noticia, 'idiomas' => $idiomas]);
    }

    /*public function alterar(Request $request, $id)
    {
        $data = $request->all();
        $data['noticia'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem'){
                    $data['noticia'] += [$campo => ''];
                }
            }
        }
        $noticia = $this->noticia->where([
            ['id', '=', $id],
        ])->firstOrFail();

        $file = $request->file('file');

        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $success = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $noticia);
            if($success){
                $data['noticia']['imagem'] = $filename;
                $noticia->update($data['noticia']);
                return $noticia->imagem;
            }else{
                return "erro";
            }
        }

        //remover imagem
        if($data['removerImagem']){
            $data['noticia']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$noticia->imagem)) {
                unlink($this->pathImagem . "/" . $noticia->imagem);
            }
        }

        $noticia->update($data['noticia']);
        return "Gravado com sucesso";
    }*/

    public function alterar(Request $request, $id)
    {
        $data = $request->all();

        //return $data;

        $data['noticia'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem' && $campo!='arquivo'){
                    $data['noticia'] += [$campo => ''];
                }
            }
        }
        $noticia = $this->noticia->where([
            ['id', '=', $id],
        ])->firstOrFail();


        $file = $request->file('file');
        $arquivo = $request->file('arquivo');



        //remover imagem
        if($data['removerImagem']){
            $data['noticia']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$noticia->imagem)) {
                unlink($this->pathImagem . "/" . $noticia->imagem);
            }
        }


        if($data['removerArquivo']){
            $data['noticia']['arquivo'] = '';
            if(file_exists($this->pathArquivo."/".$noticia->arquivo)) {
                unlink($this->pathArquivo . "/" . $noticia->arquivo);
            }
        }


        $successFile = true;
        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $successFile = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $noticia);
            if($successFile){
                $data['noticia']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['noticia']['arquivo'] = $filenameArquivo;
            }
        }

        if($successFile && $successArquivo){

            $noticia->update($data['noticia']);
            return $noticia->imagem;
        }else{
            return "erro";
        }

        //$noticia->update($data['noticia']);
        //return "Gravado com sucesso";
    }

    public function excluir($id)
    {
        //Auth::loginUsingId(2);

        $noticia = $this->noticia->where([
            ['id', '=', $id],
        ])->firstOrFail();

        //remover imagens        
        if(!empty($noticia->imagem)){
            //remover imagens
            $imagemCms = new ImagemCms();
            $imagemCms->excluir($this->pathImagem, $this->sizesImagem, $noticia);
        }


        if(!empty($noticia->arquivo)) {
            if (file_exists($this->pathArquivo . "/" . $noticia->arquivo)) {
                unlink($this->pathArquivo . "/" . $noticia->arquivo);
            }
        }

        $noticia->delete();

    }

    public function status($id)
    {
        $tipo_atual = DB::table('noticias')->where('id', $id)->first();
        $status = $tipo_atual->status == 0 ? 1 : 0;
        DB::table('noticias')->where('id', $id)->update(['status' => $status]);

    }


}
