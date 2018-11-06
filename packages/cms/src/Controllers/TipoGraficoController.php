<?php

namespace Cms\Controllers;

use Cms\Models\ImagemCms;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class TipoGraficoController extends Controller
{
    
    

    public function __construct()
    {
        $this->tipoGrafico = new \App\TipoGrafico;
        $this->campos = [
            //'imagem', 'titulo', 'arquivo', 'cmsuser_id',
            'nome_tipo_grafico',
        ];
        $this->pathImagem = public_path().'/imagens/tipos-graficos';
        $this->sizesImagem = [
            'xs' => ['width' => 140, 'height' => 79],
            'sm' => ['width' => 480, 'height' => 270],
            'md' => ['width' => 580, 'height' => 326],
            'lg' => ['width' => 1170, 'height' => 658]
        ];
        $this->widthOriginal = true;

        $this->pathArquivo = public_path().'/arquivos/tipos-grafico';
    }

    function index()
    {

        $tiposGraficos = \App\TipoGrafico::all();
        //$idiomas = \App\Idioma::lists('titulo', 'id')->all();


        return view('cms::tipo_grafico.listar', ['tipos' => $tiposGraficos/*, 'idiomas' => $idiomas*/]);
    }

    public function listar(Request $request)
    {

        //Log::info('CAMPOS: '.$request->campos);

        //Auth::loginUsingId(2);

        $campos = explode(", ", $request->campos);

        $tiposGraficos = DB::table('syst.tb_tipo_grafico')
            ->select($campos)
            ->where([
                [$request->campoPesquisa, 'ilike', "%$request->dadoPesquisa%"],
            ])
            ->orderBy($request->ordem, $request->sentido)
            ->paginate($request->itensPorPagina);
        return $tiposGraficos;
    }


    public function inserir(Request $request)
    {

        $data = $request->all();



        $data['tipoGrafico'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                $data['tipoGrafico'] += [$campo => ''];
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
                $data['tipoGrafico']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['tipoGrafico']['arquivo'] = $filenameArquivo;
            }
        }


        if($successFile && $successArquivo){
            return $this->tipoGrafico->create($data['tipoGrafico']);
        }else{
            return "erro";
        }


        return $this->tipo->create($data['tipoGrafico']);

    }

    public function detalhar($id_grafico)
    {
        $tipoGrafico = $this->tipoGrafico->where([
            ['id_grafico', '=', $id_grafico],
        ])->firstOrFail();
        //$idiomas = \App\Idioma::lists('titulo', 'id')->all();

        return view('cms::tipo_grafico.detalhar', ['tipoGrafico' => $tipoGrafico/*, 'idiomas' => $idiomas*/]);
    }


    public function alterar(Request $request, $id_grafico)
    {
        $data = $request->all();

        //return $data;

        $data['tipoGrafico'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem' && $campo!='arquivo'){
                    $data['tipoGrafico'] += [$campo => ''];
                }
            }
        }
        $tipoGrafico = $this->tipoGrafico->where([
            ['id_grafico', '=', $id_grafico],
        ])->firstOrFail();


        $file = $request->file('file');
        $arquivo = $request->file('arquivo');

        //remover imagem
        if($data['removerImagem']){
            $data['tipoGrafico']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$tipoGrafico->imagem)) {
                unlink($this->pathImagem . "/" . $tipoGrafico->imagem);
            }
        }


        if($data['removerArquivo']){
            $data['tipoGrafico']['arquivo'] = '';
            if(file_exists($this->pathArquivo."/".$tipoGrafico->arquivo)) {
                unlink($this->pathArquivo . "/" . $tipoGrafico->arquivo);
            }
        }


        $successFile = true;
        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $successFile = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $tipoGrafico);
            if($successFile){
                $data['tipoGrafico']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['tipoGrafico']['arquivo'] = $filenameArquivo;
            }
        }

        if($successFile && $successArquivo){

            $tipoGrafico->update($data['tipoGrafico']);
            return $tipoGrafico->imagem;
        }else{
            return "erro";
        }

        //$tipo->update($data['tipo']);
        //return "Gravado com sucesso";
    }

    public function excluir($id_grafico)
    {
        //Auth::loginUsingId(2);

        //Log::info($id_grafico);

        $tipoGrafico = $this->tipoGrafico->where([
            ['id_grafico', '=', $id_grafico],
        ])->firstOrFail();

        //remover imagens        
        if(!empty($tipoGrafico->imagem)){
            //remover imagens
            $imagemCms = new ImagemCms();
            $imagemCms->excluir($this->pathImagem, $this->sizesImagem, $tipoGrafico);
        }


        if(!empty($tipoGrafico->arquivo)) {
            if (file_exists($this->pathArquivo . "/" . $tipoGrafico->arquivo)) {
                unlink($this->pathArquivo . "/" . $tipoGrafico->arquivo);
            }
        }

        $tipoGrafico->delete();

    }
    public function status($id_grafico)
    {
        $tipo_atual = DB::table('syst.tb_tipo_grafico')->where('id_grafico', $id_grafico)->first();
        $status = $tipo_atual->status == 0 ? 1 : 0;
        DB::table('syst.tb_tipo_grafico')->where('id_grafico', $id_grafico)->update(['status' => $status]);

    }


}
