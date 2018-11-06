<?php

namespace Cms\Controllers;

use Cms\Models\ImagemCms;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class VersaoController extends Controller
{


    public function __construct()
    {
        $this->versao = new \App\Versao;
        $this->campos = [
            'imagem', 'titulo', 'descricao', 'arquivo', 'posicao', 'cmsuser_id',
        ];
        $this->pathImagem = public_path().'/imagens/versoes';
        $this->sizesImagem = [
            'xs' => ['width' => 140, 'height' => 79],
            'sm' => ['width' => 480, 'height' => 270],
            'md' => ['width' => 580, 'height' => 326],
            'lg' => ['width' => 1170, 'height' => 658]
        ];
        $this->widthOriginal = true;

        $this->pathArquivo = public_path().'/arquivos/versoes';
    }

    function index()
    {

        $versoes = \App\Versao::all();
        //$idiomas = \App\Idioma::lists('titulo', 'id')->all();


        return view('cms::versao.listar', ['versoes' => $versoes]);
        //return view('cms::versao.listar', ['versoes' => $versoes, 'idiomas' => $idiomas]);
    }

    public function listar(Request $request)
    {

        //Log::info('CAMPOS: '.$request->campos);

        //Auth::loginUsingId(2);

        $campos = explode(", ", $request->campos);

        $versoes = DB::table('versoes')
            ->select($campos)
            ->where([
                [$request->campoPesquisa, 'ilike', "%$request->dadoPesquisa%"],
            ])
            ->orderBy($request->ordem, $request->sentido)
            ->paginate($request->itensPorPagina);
        return $versoes;
    }


    public function inserir(Request $request)
    {

        $data = $request->all();

        $data['versao'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                $data['versao'] += [$campo => ''];
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
                $data['versao']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['versao']['arquivo'] = $filenameArquivo;
            }
        }


        if($successFile && $successArquivo){
            return $this->versao->create($data['versao']);
        }else{
            return "erro";
        }


        return $this->versao->create($data['versao']);

    }

    public function detalhar($id)
    {
        $versao = $this->versao->where([
            ['id', '=', $id],
        ])->firstOrFail();
        //$idiomas = \App\Idioma::lists('titulo', 'id')->all();

        return view('cms::versao.detalhar', ['versao' => $versao]);
        //return view('cms::versao.detalhar', ['versao' => $versao, 'idiomas' => $idiomas]);
    }



    public function alterar(Request $request, $id)
    {
        $data = $request->all();

        //return $data;

        $data['versao'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem' && $campo!='arquivo'){
                    $data['versao'] += [$campo => ''];
                }
            }
        }
        $versao = $this->versao->where([
            ['id', '=', $id],
        ])->firstOrFail();


        $file = $request->file('file');
        $arquivo = $request->file('arquivo');

        //remover imagem
        if($data['removerImagem']){
            $data['versao']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$versao->imagem)) {
                unlink($this->pathImagem . "/" . $versao->imagem);
            }
        }


        if($data['removerArquivo']){
            $data['versao']['arquivo'] = '';
            if(file_exists($this->pathArquivo."/".$versao->arquivo)) {
                unlink($this->pathArquivo . "/" . $versao->arquivo);
            }
        }


        $successFile = true;
        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $successFile = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $versao);
            if($successFile){
                $data['versao']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['versao']['arquivo'] = $filenameArquivo;
            }
        }

        if($successFile && $successArquivo){

            $versao->update($data['versao']);
            return $versao->imagem;
        }else{
            return "erro";
        }

        //$versao->update($data['versao']);
        //return "Gravado com sucesso";
    }

    public function excluir($id)
    {
        //Auth::loginUsingId(2);

        $versao = $this->versao->where([
            ['id', '=', $id],
        ])->firstOrFail();

        //remover imagens        
        if(!empty($versao->imagem)){
            //remover imagens
            $imagemCms = new ImagemCms();
            $imagemCms->excluir($this->pathImagem, $this->sizesImagem, $versao);
        }


        if(!empty($versao->arquivo)) {
            if (file_exists($this->pathArquivo . "/" . $versao->arquivo)) {
                unlink($this->pathArquivo . "/" . $versao->arquivo);
            }
        }

        $versao->delete();

    }

    public function status($id)
    {
        $tipo_atual = DB::table('versoes')->where('id', $id)->first();
        $status = $tipo_atual->status == 0 ? 1 : 0;
        DB::table('versoes')->where('id', $id)->update(['status' => $status]);

    }
    public function positionUp($id)
    {

        $posicao_atual = DB::table('versoes')->where('id', $id)->first();
        $upPosicao = $posicao_atual->posicao-1;
        $posicao = $posicao_atual->posicao;

        //Coloca com a posicao do anterior
        DB::table('versoes')->where('posicao', $upPosicao)->update(['posicao' => $posicao]);

        //atualiza a posicao para o anterior
        DB::table('versoes')->where('id', $id)->update(['posicao' => $upPosicao]);


    }

    public function positionDown($id)
    {

        $posicao_atual = DB::table('versoes')->where('id', $id)->first();
        $upPosicao = $posicao_atual->posicao+1;
        $posicao = $posicao_atual->posicao;

        //Coloca com a posicao do anterior
        DB::table('versoes')->where('posicao', $upPosicao)->update(['posicao' => $posicao]);

        //atualiza a posicao para o anterior
        DB::table('versoes')->where('id', $id)->update(['posicao' => $upPosicao]);

    }


}
