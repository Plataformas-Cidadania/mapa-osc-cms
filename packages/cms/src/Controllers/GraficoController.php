<?php

namespace Cms\Controllers;

use Cms\Models\ImagemCms;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class GraficoController extends Controller
{
    
    

    public function __construct()
    {
        $this->grafico = new \App\Grafico;
        $this->campos = [
            'tipo_grafico' => '',
            'titulo' => '',
            'legenda' => '',
            'legenda_x' => '',
            'legenda_y' => '',
            'configuracao' => null,
            'titulo_colunas' => null,
            'inverter_label' => '',
            'slug' => '',
        ];
        $this->pathImagem = public_path().'/imagens/graficos';
        $this->sizesImagem = [
            'xs' => ['width' => 140, 'height' => 79],
            'sm' => ['width' => 480, 'height' => 270],
            'md' => ['width' => 580, 'height' => 326],
            'lg' => ['width' => 1170, 'height' => 658]
        ];
        $this->widthOriginal = true;

        $this->pathArquivo = public_path().'/arquivos/graficos';
    }

    function index()
    {
        $tiposGraficos = \App\TipoGrafico::pluck('nome_tipo_grafico', 'id_grafico')->all();
        $graficos = \App\Grafico::all();
        $idiomas = \App\Idioma::lists('titulo', 'id')->all();


        return view('cms::grafico.listar', ['graficos' => $graficos, 'idiomas' => $idiomas, 'tiposGraficos' => $tiposGraficos]);
    }

    public function listar(Request $request)
    {

        //Log::info('CAMPOS: '.$request->campos);

        //Auth::loginUsingId(2);

        $campos = explode(", ", $request->campos);

        $graficos = DB::table('portal.tb_analise')
            ->select($campos)
            ->where([
                [$request->campoPesquisa, 'ilike', "%$request->dadoPesquisa%"],
            ])
            ->orderBy($request->ordem, $request->sentido)
            ->paginate($request->itensPorPagina);
        return $graficos;
    }


    public function inserir(Request $request)
    {

        $data = $request->all();

        $data['grafico'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario
        //$data['grafico']['configuracao'] = json_encode(explode(',', $data['grafico']['configuracao']));

        if(array_key_exists('configuracao', $data['grafico'])) {
            $data['grafico']['configuracao'] = "{'" . str_replace("|", "','", $data['grafico']['configuracao']) . "'}";
        }
        if(array_key_exists('titulo_colunas', $data['grafico'])) {
            $data['grafico']['titulo_colunas'] = "{'" . str_replace("|", "','", $data['grafico']['titulo_colunas']) . "'}";
        }
        if(!array_key_exists('inverter_label', $data['grafico'])){
            $data['grafico']['inverter_label'] = false;
        }

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo => $value){
            if(!array_key_exists($campo, $data)){
                $data['grafico'] += [$campo => $value];
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
                $data['grafico']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['grafico']['arquivo'] = $filenameArquivo;
            }
        }


        if($successFile && $successArquivo){
            return $this->grafico->create($data['grafico']);
        }else{
            return "erro";
        }


        return $this->grafico->create($data['grafico']);

    }

    public function detalhar($id)
    {
        $grafico = $this->grafico->select(DB::Raw("id_analise, array_to_string(configuracao, ',', '*') as configuracao, array_to_string(titulo_colunas, ',', '*') as titulo_colunas, tipo_grafico, titulo, legenda, legenda_x, legenda_y, inverter_label, slug"))
            ->where([
            ['id_analise', '=', $id],
        ])->firstOrFail();


        $tiposGraficos = \App\TipoGrafico::pluck('nome_tipo_grafico', 'id_grafico')->all();
        $idiomas = \App\Idioma::lists('titulo', 'id')->all();
        $grafico->configuracao = str_replace("','", "'|'", ($grafico->configuracao));
        $grafico->configuracao = str_replace("'", "", ($grafico->configuracao));
        $grafico->titulo_colunas = str_replace("','", "'|'", ($grafico->titulo_colunas));
        $grafico->titulo_colunas = str_replace("'", "", ($grafico->titulo_colunas));



        return view('cms::grafico.detalhar', ['grafico' => $grafico, 'idiomas' => $idiomas, 'tiposGraficos' => $tiposGraficos]);
    }

    /*public function alterar(Request $request, $id)
    {
        $data = $request->all();
        $data['grafico'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem'){
                    $data['grafico'] += [$campo => ''];
                }
            }
        }
        $grafico = $this->grafico->where([
            ['id', '=', $id],
        ])->firstOrFail();

        $file = $request->file('file');

        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $success = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $grafico);
            if($success){
                $data['grafico']['imagem'] = $filename;
                $grafico->update($data['grafico']);
                return $grafico->imagem;
            }else{
                return "erro";
            }
        }

        //remover imagem
        if($data['removerImagem']){
            $data['grafico']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$grafico->imagem)) {
                unlink($this->pathImagem . "/" . $grafico->imagem);
            }
        }

        $grafico->update($data['grafico']);
        return "Gravado com sucesso";
    }*/

    public function alterar(Request $request, $id)
    {
        $data = $request->all();

        //return $data;

        $data['grafico'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //$data['grafico']['configuracao'] = "{'".str_replace("|", "','", $data['grafico']['configuracao'])."'}";
        //$data['grafico']['titulo_colunas'] = "{'".str_replace("|", "','", $data['grafico']['titulo_colunas'])."'}";
        if(array_key_exists('configuracao', $data['grafico'])) {
            $data['grafico']['configuracao'] = "{'" . str_replace("|", "','", $data['grafico']['configuracao']) . "'}";
        }
        if(array_key_exists('titulo_colunas', $data['grafico'])) {
            $data['grafico']['titulo_colunas'] = "{'" . str_replace("|", "','", $data['grafico']['titulo_colunas']) . "'}";
        }


        if(!array_key_exists('inverter_label', $data['grafico'])){
            $data['grafico']['inverter_label'] = false;
        }

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo => $value){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem' && $campo!='arquivo'){
                    $data['grafico'] += [$campo => $value];
                }
            }
        }
        $grafico = $this->grafico->where([
            ['id_analise', '=', $id],
        ])->firstOrFail();


        $file = $request->file('file');
        $arquivo = $request->file('arquivo');

        //remover imagem
        if($data['removerImagem']){
            $data['grafico']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$grafico->imagem)) {
                unlink($this->pathImagem . "/" . $grafico->imagem);
            }
        }


        if($data['removerArquivo']){
            $data['grafico']['arquivo'] = '';
            if(file_exists($this->pathArquivo."/".$grafico->arquivo)) {
                unlink($this->pathArquivo . "/" . $grafico->arquivo);
            }
        }


        $successFile = true;
        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $successFile = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $grafico);
            if($successFile){
                $data['grafico']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['grafico']['arquivo'] = $filenameArquivo;
            }
        }

        if($successFile && $successArquivo){

            $grafico->update($data['grafico']);
            return $grafico->imagem;
        }else{
            return "erro";
        }

        //$grafico->update($data['grafico']);
        //return "Gravado com sucesso";
    }

    public function excluir($id)
    {
        //Auth::loginUsingId(2);

        $grafico = $this->grafico->where([
            ['id_analise', '=', $id],
        ])->firstOrFail();

        //remover imagens        
        if(!empty($grafico->imagem)){
            //remover imagens
            $imagemCms = new ImagemCms();
            $imagemCms->excluir($this->pathImagem, $this->sizesImagem, $grafico);
        }


        if(!empty($grafico->arquivo)) {
            if (file_exists($this->pathArquivo . "/" . $grafico->arquivo)) {
                unlink($this->pathArquivo . "/" . $grafico->arquivo);
            }
        }

        $grafico->delete();

    }

    public function status($id)
    {
        $tipo_atual = DB::table('portal.tb_analise')->where('id_analise', $id)->first();
        $status = $tipo_atual->status == 0 ? 1 : 0;
        DB::table('portal.tb_analise')->where('id_analise', $id)->update(['status' => $status]);

    }


}
