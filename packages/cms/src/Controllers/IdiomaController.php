<?php

namespace Cms\Controllers;

use Cms\Models\ImagemCms;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class IdiomaController extends Controller
{
    
    

    public function __construct()
    {
        $this->idioma = new \App\Idioma;
        $this->campos = [
            'imagem', 'titulo', 'sigla', 'cmsuser_id',
        ];
        $this->pathImagem = public_path().'/imagens/idiomas';
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

        $idiomas = \App\Idioma::all();

        return view('cms::idioma.listar', ['idiomas' => $idiomas]);
    }

    public function listar(Request $request)
    {

        //Log::info('CAMPOS: '.$request->campos);

        //Auth::loginUsingId(2);

        $campos = explode(", ", $request->campos);

        $idiomas = DB::table('idiomas')
            ->select($campos)
            ->where([
                [$request->campoPesquisa, 'like', "%$request->dadoPesquisa%"],
            ])
            ->orderBy($request->ordem, $request->sentido)
            ->paginate($request->itensPorPagina);
        return $idiomas;
    }

    public function inserir(Request $request)
    {

        $data = $request->all();

        $data['idioma'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                $data['idioma'] += [$campo => ''];
            }
        }

        $file = $request->file('file');

        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $success = $imagemCms->inserir($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal);
            
            if($success){
                $data['idioma']['imagem'] = $filename;
                return $this->idioma->create($data['idioma']);
            }else{
                return "erro";
            }
        }

        return $this->idioma->create($data['idioma']);

    }

    public function detalhar($id)
    {
        $idioma = $this->idioma->where([
            ['id', '=', $id],
        ])->firstOrFail();
        return view('cms::idioma.detalhar', ['idioma' => $idioma]);
    }

    public function alterar(Request $request, $id)
    {
        $data = $request->all();
        $data['idioma'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem'){
                    $data['idioma'] += [$campo => ''];
                }
            }
        }
        $idioma = $this->idioma->where([
            ['id', '=', $id],
        ])->firstOrFail();

        $file = $request->file('file');

        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $success = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $idioma);
            if($success){
                $data['idioma']['imagem'] = $filename;
                $idioma->update($data['idioma']);
                return $idioma->imagem;
            }else{
                return "erro";
            }
        }

        //remover imagem
        if($data['removerImagem']){
            $data['idioma']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$idioma->imagem)) {
                unlink($this->pathImagem . "/" . $idioma->imagem);
            }
        }

        $idioma->update($data['idioma']);
        return "Gravado com sucesso";
    }

    public function excluir($id)
    {
        //Auth::loginUsingId(2);

        $idioma = $this->idioma->where([
            ['id', '=', $id],
        ])->firstOrFail();

        //remover imagens        
        if(!empty($idioma->imagem)){
            //remover imagens
            $imagemCms = new ImagemCms();
            $imagemCms->excluir($this->pathImagem, $this->sizesImagem, $idioma);
        }
                

        $idioma->delete();

    }

    


}
