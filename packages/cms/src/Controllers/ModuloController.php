<?php

namespace Cms\Controllers;

use Cms\Models\ImagemCms;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class ModuloController extends Controller
{
    
    

    public function __construct()
    {
        $this->modulo = new \App\Modulo;
        $this->campos = [
            'imagem', 'titulo', 'descricao', 'arquivo', 'slug', 'tipo_id', 'cmsuser_id',
        ];
        $this->pathImagem = public_path().'/imagens/modulos';
        $this->sizesImagem = [
            'xs' => ['width' => 140, 'height' => 79],
            'sm' => ['width' => 480, 'height' => 270],
            'md' => ['width' => 580, 'height' => 326],
            'lg' => ['width' => 1170, 'height' => 658]
        ];
        $this->widthOriginal = true;

        $this->pathArquivo = public_path().'/arquivos/modulos';
    }

    function index()
    {

        $tipos = \App\Tipo::pluck('titulo', 'id')->all();
        $modulos = \App\Modulo::all();
        //$idiomas = \App\Idioma::lists('titulo', 'id')->all();


        return view('cms::modulo.listar', ['modulos' => $modulos, 'tipos' => $tipos/*, 'idiomas' => $idiomas*/]);
    }

    public function listar(Request $request)
    {

        //Log::info('CAMPOS: '.$request->campos);

        //Auth::loginUsingId(2);

        $campos = explode(", ", $request->campos);

        $modulos = DB::table('modulos')
            ->select($campos)
            ->where([
                [$request->campoPesquisa, 'ilike', "%$request->dadoPesquisa%"],
            ])
            ->orderBy($request->ordem, $request->sentido)
            ->paginate($request->itensPorPagina);
        return $modulos;
    }


    public function inserir(Request $request)
    {

        $data = $request->all();

        $data['modulo'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario


        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                $data['modulo'] += [$campo => ''];
            }
        }

        if(empty($data['modulo']['tipo_id'])){
            $data['modulo']['tipo_id'] = 0;
        }

        $file = $request->file('file');
        $arquivo = $request->file('arquivo');


        $successFile = true;
        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $successFile = $imagemCms->inserir($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal);
            if($successFile){
                $data['modulo']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['modulo']['arquivo'] = $filenameArquivo;
            }
        }


        if($successFile && $successArquivo){
            return $this->modulo->create($data['modulo']);
        }else{
            return "erro";
        }


        return $this->modulo->create($data['modulo']);

    }

    public function detalhar($id)
    {
        $tipos = \App\Tipo::pluck('titulo', 'id')->all();
        $modulo = $this->modulo->where([
            ['id', '=', $id],
        ])->firstOrFail();
        //$idiomas = \App\Idioma::lists('titulo', 'id')->all();

        return view('cms::modulo.detalhar', ['modulo' => $modulo, 'tipos' => $tipos/*, 'idiomas' => $idiomas*/]);
    }

    /*public function alterar(Request $request, $id)
    {
        $data = $request->all();
        $data['modulo'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem'){
                    $data['modulo'] += [$campo => ''];
                }
            }
        }
        $modulo = $this->modulo->where([
            ['id', '=', $id],
        ])->firstOrFail();

        $file = $request->file('file');

        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $success = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $modulo);
            if($success){
                $data['modulo']['imagem'] = $filename;
                $modulo->update($data['modulo']);
                return $modulo->imagem;
            }else{
                return "erro";
            }
        }

        //remover imagem
        if($data['removerImagem']){
            $data['modulo']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$modulo->imagem)) {
                unlink($this->pathImagem . "/" . $modulo->imagem);
            }
        }

        $modulo->update($data['modulo']);
        return "Gravado com sucesso";
    }*/

    public function alterar(Request $request, $id)
    {
        $data = $request->all();

        //return $data;

        $data['modulo'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem' && $campo!='arquivo'){
                    $data['modulo'] += [$campo => ''];
                }
            }
        }
        $modulo = $this->modulo->where([
            ['id', '=', $id],
        ])->firstOrFail();

        if(empty($data['modulo']['tipo_id'])){
            $data['modulo']['tipo_id'] = 0;
        }

        $file = $request->file('file');
        $arquivo = $request->file('arquivo');

        //remover imagem
        if($data['removerImagem']){
            $data['modulo']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$modulo->imagem)) {
                unlink($this->pathImagem . "/" . $modulo->imagem);
            }
        }


        if($data['removerArquivo']){
            $data['modulo']['arquivo'] = '';
            if(file_exists($this->pathArquivo."/".$modulo->arquivo)) {
                unlink($this->pathArquivo . "/" . $modulo->arquivo);
            }
        }

        $successFile = true;
        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $successFile = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $modulo);
            if($successFile){
                $data['modulo']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['modulo']['arquivo'] = $filenameArquivo;
            }
        }

        if($successFile && $successArquivo){

            $modulo->update($data['modulo']);
            return $modulo->imagem;
        }else{
            return "erro";
        }

        //$modulo->update($data['modulo']);
        //return "Gravado com sucesso";
    }

    public function excluir($id)
    {
        //Auth::loginUsingId(2);

        $modulo = $this->modulo->where([
            ['id', '=', $id],
        ])->firstOrFail();

        //remover imagens        
        if(!empty($modulo->imagem)){
            //remover imagens
            $imagemCms = new ImagemCms();
            $imagemCms->excluir($this->pathImagem, $this->sizesImagem, $modulo);
        }


        if(!empty($modulo->arquivo)) {
            if (file_exists($this->pathArquivo . "/" . $modulo->arquivo)) {
                unlink($this->pathArquivo . "/" . $modulo->arquivo);
            }
        }

        $modulo->delete();

    }

    public function status($id)
    {
        $tipo_atual = DB::table('modulos')->where('id', $id)->first();
        $status = $tipo_atual->status == 0 ? 1 : 0;
        DB::table('modulos')->where('id', $id)->update(['status' => $status]);

    }


}
