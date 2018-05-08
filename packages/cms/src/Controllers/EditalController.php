<?php

namespace Cms\Controllers;

use Cms\Models\ImagemCms;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class EditalController extends Controller
{
    
    

    public function __construct()
    {
        $this->edital = new \App\Edital;
        $this->campos = [
            'tx_orgao', 'tx_programa', 'tx_area_interesse_edital', 'dt_vencimento', 'tx_link_edital', 'tx_numero_chamada',
        ];
        $this->pathImagem = public_path().'/imagens/editais';
        $this->sizesImagem = [
            'xs' => ['width' => 140, 'height' => 79],
            'sm' => ['width' => 480, 'height' => 270],
            'md' => ['width' => 580, 'height' => 326],
            'lg' => ['width' => 1170, 'height' => 658]
        ];
        $this->widthOriginal = true;

        $this->pathArquivo = public_path().'/arquivos/editais';
    }

    function index()
    {

        $editais = \App\Edital::all();
        $idiomas = \App\Idioma::lists('titulo', 'id')->all();


        return view('cms::edital.listar', ['editais' => $editais, 'idiomas' => $idiomas]);
    }

    public function listar(Request $request)
    {

        //Log::info('CAMPOS: '.$request->campos);

        //Auth::loginUsingId(2);

        $campos = explode(", ", $request->campos);

        $editais = DB::table('portal.tb_edital')
            ->select($campos)
            ->where([
                [$request->campoPesquisa, 'ilike', "%$request->dadoPesquisa%"],
            ])
            ->orderBy($request->ordem, $request->sentido)
            ->paginate($request->itensPorPagina);
        return $editais;
    }


    public function inserir(Request $request)
    {

        $data = $request->all();

        $data['edital'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                $data['edital'] += [$campo => ''];
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
                $data['edital']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['edital']['arquivo'] = $filenameArquivo;
            }
        }


        if($successFile && $successArquivo){
            return $this->edital->create($data['edital']);
        }else{
            return "erro";
        }


        return $this->edital->create($data['edital']);

    }

    public function detalhar($id)
    {
        $edital = $this->edital->where([
            ['id_edital', '=', $id],
        ])->firstOrFail();
        $idiomas = \App\Idioma::lists('titulo', 'id')->all();

        return view('cms::edital.detalhar', ['edital' => $edital, 'idiomas' => $idiomas]);
    }

    /*public function alterar(Request $request, $id)
    {
        $data = $request->all();
        $data['edital'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem'){
                    $data['edital'] += [$campo => ''];
                }
            }
        }
        $edital = $this->edital->where([
            ['id', '=', $id],
        ])->firstOrFail();

        $file = $request->file('file');

        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $success = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $edital);
            if($success){
                $data['edital']['imagem'] = $filename;
                $edital->update($data['edital']);
                return $edital->imagem;
            }else{
                return "erro";
            }
        }

        //remover imagem
        if($data['removerImagem']){
            $data['edital']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$edital->imagem)) {
                unlink($this->pathImagem . "/" . $edital->imagem);
            }
        }

        $edital->update($data['edital']);
        return "Gravado com sucesso";
    }*/

    public function alterar(Request $request, $id)
    {
        $data = $request->all();

        //return $data;

        $data['edital'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem' && $campo!='arquivo'){
                    $data['edital'] += [$campo => ''];
                }
            }
        }
        $edital = $this->edital->where([
            ['id_edital', '=', $id],
        ])->firstOrFail();


        $file = $request->file('file');
        $arquivo = $request->file('arquivo');

        //remover imagem
        if($data['removerImagem']){
            $data['edital']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$edital->imagem)) {
                unlink($this->pathImagem . "/" . $edital->imagem);
            }
        }


        if($data['removerArquivo']){
            $data['edital']['arquivo'] = '';
            if(file_exists($this->pathArquivo."/".$edital->arquivo)) {
                unlink($this->pathArquivo . "/" . $edital->arquivo);
            }
        }


        $successFile = true;
        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $successFile = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $edital);
            if($successFile){
                $data['edital']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['edital']['arquivo'] = $filenameArquivo;
            }
        }

        if($successFile && $successArquivo){

            $edital->update($data['edital']);
            return $edital->imagem;
        }else{
            return "erro";
        }

        //$edital->update($data['edital']);
        //return "Gravado com sucesso";
    }

    public function excluir($id)
    {
        //Auth::loginUsingId(2);

        $edital = $this->edital->where([
            ['id_edital', '=', $id],
        ])->firstOrFail();

        //remover imagens        
        if(!empty($edital->imagem)){
            //remover imagens
            $imagemCms = new ImagemCms();
            $imagemCms->excluir($this->pathImagem, $this->sizesImagem, $edital);
        }


        if(!empty($edital->arquivo)) {
            if (file_exists($this->pathArquivo . "/" . $edital->arquivo)) {
                unlink($this->pathArquivo . "/" . $edital->arquivo);
            }
        }

        $edital->delete();

    }

    


}
