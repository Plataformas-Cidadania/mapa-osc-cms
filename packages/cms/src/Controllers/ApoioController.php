<?php

namespace Cms\Controllers;

use Cms\Models\ImagemCms;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class ApoioController extends Controller
{
    
    

    public function __construct()
    {
        $this->apoio = new \App\Apoio;
        $this->campos = [
            'imagem', 'titulo', 'descricao', 'arquivo', 'url', 'posicao', 'cmsuser_id',
        ];
        $this->pathImagem = public_path().'/imagens/apoios';
        $this->sizesImagem = [
            'xs' => ['width' => 140, 'height' => 79],
            'sm' => ['width' => 480, 'height' => 270],
            'md' => ['width' => 580, 'height' => 326],
            'lg' => ['width' => 1170, 'height' => 658]
        ];
        $this->widthOriginal = true;

        $this->pathArquivo = public_path().'/arquivos/apoios';
    }

    function index()
    {

        $apoios = \App\Apoio::all();
        //$idiomas = \App\Idioma::lists('titulo', 'id')->all();


        return view('cms::apoio.listar', ['apoios' => $apoios]);
        //return view('cms::apoio.listar', ['apoios' => $apoios, 'idiomas' => $idiomas]);
    }

    public function listar(Request $request)
    {

        //Log::info('CAMPOS: '.$request->campos);

        //Auth::loginUsingId(2);

        $campos = explode(", ", $request->campos);

        $apoios = DB::table('apoios')
            ->select($campos)
            ->where([
                [$request->campoPesquisa, 'ilike', "%$request->dadoPesquisa%"],
            ])
            ->orderBy($request->ordem, $request->sentido)
            ->paginate($request->itensPorPagina);
        return $apoios;
    }


    public function inserir(Request $request)
    {

        $data = $request->all();

        $data['apoio'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                $data['apoio'] += [$campo => ''];
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
                $data['apoio']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['apoio']['arquivo'] = $filenameArquivo;
            }
        }


        if($successFile && $successArquivo){
            return $this->apoio->create($data['apoio']);
        }else{
            return "erro";
        }


        return $this->apoio->create($data['apoio']);

    }

    public function detalhar($id)
    {
        $apoio = $this->apoio->where([
            ['id', '=', $id],
        ])->firstOrFail();
        //$idiomas = \App\Idioma::lists('titulo', 'id')->all();

        return view('cms::apoio.detalhar', ['apoio' => $apoio]);
        //return view('cms::apoio.detalhar', ['apoio' => $apoio, 'idiomas' => $idiomas]);
    }

    /*public function alterar(Request $request, $id)
    {
        $data = $request->all();
        $data['apoio'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem'){
                    $data['apoio'] += [$campo => ''];
                }
            }
        }
        $apoio = $this->apoio->where([
            ['id', '=', $id],
        ])->firstOrFail();

        $file = $request->file('file');

        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $success = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $apoio);
            if($success){
                $data['apoio']['imagem'] = $filename;
                $apoio->update($data['apoio']);
                return $apoio->imagem;
            }else{
                return "erro";
            }
        }

        //remover imagem
        if($data['removerImagem']){
            $data['apoio']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$apoio->imagem)) {
                unlink($this->pathImagem . "/" . $apoio->imagem);
            }
        }

        $apoio->update($data['apoio']);
        return "Gravado com sucesso";
    }*/

    public function alterar(Request $request, $id)
    {
        $data = $request->all();

        //return $data;

        $data['apoio'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem' && $campo!='arquivo'){
                    $data['apoio'] += [$campo => ''];
                }
            }
        }
        $apoio = $this->apoio->where([
            ['id', '=', $id],
        ])->firstOrFail();


        $file = $request->file('file');
        $arquivo = $request->file('arquivo');



        //remover imagem
        if($data['removerImagem']){
            $data['apoio']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$apoio->imagem)) {
                unlink($this->pathImagem . "/" . $apoio->imagem);
            }
        }


        if($data['removerArquivo']){
            $data['apoio']['arquivo'] = '';
            if(file_exists($this->pathArquivo."/".$apoio->arquivo)) {
                unlink($this->pathArquivo . "/" . $apoio->arquivo);
            }
        }


        $successFile = true;
        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $successFile = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $apoio);
            if($successFile){
                $data['apoio']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['apoio']['arquivo'] = $filenameArquivo;
            }
        }

        if($successFile && $successArquivo){

            $apoio->update($data['apoio']);
            return $apoio->imagem;
        }else{
            return "erro";
        }

        //$apoio->update($data['apoio']);
        //return "Gravado com sucesso";
    }

    public function excluir($id)
    {
        //Auth::loginUsingId(2);

        $apoio = $this->apoio->where([
            ['id', '=', $id],
        ])->firstOrFail();

        //remover imagens        
        if(!empty($apoio->imagem)){
            //remover imagens
            $imagemCms = new ImagemCms();
            $imagemCms->excluir($this->pathImagem, $this->sizesImagem, $apoio);
        }


        if(!empty($apoio->arquivo)) {
            if (file_exists($this->pathArquivo . "/" . $apoio->arquivo)) {
                unlink($this->pathArquivo . "/" . $apoio->arquivo);
            }
        }

        $apoio->delete();

    }

    public function status($id)
    {
        $tipo_atual = DB::table('apoios')->where('id', $id)->first();
        $status = $tipo_atual->status == 0 ? 1 : 0;
        DB::table('apoios')->where('id', $id)->update(['status' => $status]);

    }

    public function positionUp($id)
    {

        $posicao_atual = DB::table('apoios')->where('id', $id)->first();
        $upPosicao = $posicao_atual->posicao-1;
        $posicao = $posicao_atual->posicao;

        //Coloca com a posicao do anterior
        DB::table('apoios')->where('posicao', $upPosicao)->update(['posicao' => $posicao]);

        //atualiza a posicao para o anterior
        DB::table('apoios')->where('id', $id)->update(['posicao' => $upPosicao]);


    }

    public function positionDown($id)
    {

        $posicao_atual = DB::table('apoios')->where('id', $id)->first();
        $upPosicao = $posicao_atual->posicao+1;
        $posicao = $posicao_atual->posicao;

        //Coloca com a posicao do anterior
        DB::table('apoios')->where('posicao', $upPosicao)->update(['posicao' => $posicao]);

        //atualiza a posicao para o anterior
        DB::table('apoios')->where('id', $id)->update(['posicao' => $upPosicao]);

    }


}
