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
            'titulo', 'slug', 'cmsuser_id',
        ];
        $this->pathImagem = public_path().'/imagens/modulos';
        $this->sizesImagem = [
            'xs' => ['width' => 140, 'height' => 79],
            'sm' => ['width' => 480, 'height' => 270],
            'md' => ['width' => 580, 'height' => 326],
            'lg' => ['width' => 1170, 'height' => 658]
        ];
        $this->widthOriginal = true;
    }

    function index()
    {

        $modulos = \App\Modulo::all();

        return view('cms::modulo.listar', ['modulos' => $modulos]);
    }

    public function listar(Request $request)
    {

        //Log::info('CAMPOS: '.$request->campos);

        //Auth::loginUsingId(2);

        $campos = explode(", ", $request->campos);

        $modulos = DB::table('modulos')
            ->select($campos)
            ->where([
                [$request->campoPesquisa, 'like', "%$request->dadoPesquisa%"],
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

        $file = $request->file('file');

        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $success = $imagemCms->inserir($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal);
            
            if($success){
                $data['modulo']['imagem'] = $filename;
                return $this->modulo->create($data['modulo']);
            }else{
                return "erro";
            }
        }

        return $this->modulo->create($data['modulo']);

    }

    public function detalhar($id)
    {
        $modulo = $this->modulo->where([
            ['id', '=', $id],
        ])->firstOrFail();
        return view('cms::modulo.detalhar', ['modulo' => $modulo]);
    }

    public function alterar(Request $request, $id)
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
                

        $modulo->delete();

    }

    


}
