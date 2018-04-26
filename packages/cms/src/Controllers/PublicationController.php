<?php

namespace Cms\Controllers;

use Cms\Models\ImagemCms;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class PublicationController extends Controller
{
    
    

    public function __construct()
    {
        $this->publication = new \App\Publication;
        $this->campos = [
            'imagem', 'titulo', 'resumida', 'descricao', 'arquivo', 'data', 'cmsuser_id',
        ];
        $this->pathImagem = public_path().'/imagens/publications';
        $this->sizesImagem = [
            'xs' => ['width' => 140, 'height' => 79],
            'sm' => ['width' => 480, 'height' => 270],
            'md' => ['width' => 580, 'height' => 326],
            'lg' => ['width' => 1170, 'height' => 658]
        ];
        $this->widthOriginal = true;

        $this->pathArquivo = public_path().'/arquivos/publications';
    }

    function index()
    {

        $publications = \App\Publication::all();
        //$idiomas = \App\Idioma::lists('titulo', 'id')->all();


        return view('cms::publication.listar', ['publications' => $publications]);
        //return view('cms::publication.listar', ['publications' => $publications, 'idiomas' => $idiomas]);
    }

    public function listar(Request $request)
    {

        //Log::info('CAMPOS: '.$request->campos);

        //Auth::loginUsingId(2);

        $campos = explode(", ", $request->campos);

        $publications = DB::table('publications')
            ->select($campos)
            ->where([
                [$request->campoPesquisa, 'ilike', "%$request->dadoPesquisa%"],
            ])
            ->orderBy($request->ordem, $request->sentido)
            ->paginate($request->itensPorPagina);
        return $publications;
    }


    public function inserir(Request $request)
    {

        $data = $request->all();

        $data['publication'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                $data['publication'] += [$campo => ''];
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
                $data['publication']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['publication']['arquivo'] = $filenameArquivo;
            }
        }


        if($successFile && $successArquivo){
            return $this->publication->create($data['publication']);
        }else{
            return "erro";
        }


        return $this->publication->create($data['publication']);

    }

    public function detalhar($id)
    {
        $publication = $this->publication->where([
            ['id', '=', $id],
        ])->firstOrFail();
        //$idiomas = \App\Idioma::lists('titulo', 'id')->all();

        return view('cms::publication.detalhar', ['publication' => $publication]);
        //return view('cms::publication.detalhar', ['publication' => $publication, 'idiomas' => $idiomas]);
    }

    /*public function alterar(Request $request, $id)
    {
        $data = $request->all();
        $data['publication'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem'){
                    $data['publication'] += [$campo => ''];
                }
            }
        }
        $publication = $this->publication->where([
            ['id', '=', $id],
        ])->firstOrFail();

        $file = $request->file('file');

        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $success = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $publication);
            if($success){
                $data['publication']['imagem'] = $filename;
                $publication->update($data['publication']);
                return $publication->imagem;
            }else{
                return "erro";
            }
        }

        //remover imagem
        if($data['removerImagem']){
            $data['publication']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$publication->imagem)) {
                unlink($this->pathImagem . "/" . $publication->imagem);
            }
        }

        $publication->update($data['publication']);
        return "Gravado com sucesso";
    }*/

    public function alterar(Request $request, $id)
    {
        $data = $request->all();

        //return $data;

        $data['publication'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem' && $campo!='arquivo'){
                    $data['publication'] += [$campo => ''];
                }
            }
        }
        $publication = $this->publication->where([
            ['id', '=', $id],
        ])->firstOrFail();


        $file = $request->file('file');
        $arquivo = $request->file('arquivo');

	Log::info($request);

        //remover imagem
        if($data['removerImagem']){
            $data['publication']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$publication->imagem)) {
                unlink($this->pathImagem . "/" . $publication->imagem);
            }
        }


        if($data['removerArquivo']){
            $data['publication']['arquivo'] = '';
            if(file_exists($this->pathArquivo."/".$publication->arquivo)) {
                unlink($this->pathArquivo . "/" . $publication->arquivo);
            }
        }


        $successFile = true;
        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $successFile = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $publication);
            if($successFile){
                $data['publication']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['publication']['arquivo'] = $filenameArquivo;
            }
        }

        if($successFile && $successArquivo){

            $publication->update($data['publication']);
            return $publication->imagem;
        }else{
            return "erro";
        }

        //$publication->update($data['publication']);
        //return "Gravado com sucesso";
    }

    public function excluir($id)
    {
        //Auth::loginUsingId(2);

        $publication = $this->publication->where([
            ['id', '=', $id],
        ])->firstOrFail();

        //remover imagens        
        if(!empty($publication->imagem)){
            //remover imagens
            $imagemCms = new ImagemCms();
            $imagemCms->excluir($this->pathImagem, $this->sizesImagem, $publication);
        }


        if(!empty($publication->arquivo)) {
            if (file_exists($this->pathArquivo . "/" . $publication->arquivo)) {
                unlink($this->pathArquivo . "/" . $publication->arquivo);
            }
        }

        $publication->delete();

    }

    public function status($id)
    {
        $tipo_atual = DB::table('publications')->where('id', $id)->first();
        $status = $tipo_atual->status == 0 ? 1 : 0;
        DB::table('publications')->where('id', $id)->update(['status' => $status]);

    }


}
