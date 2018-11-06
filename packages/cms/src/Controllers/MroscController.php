<?php

namespace Cms\Controllers;

use Cms\Models\ImagemCms;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class MroscController extends Controller
{
    
    

    public function __construct()
    {
        $this->mrosc = new \App\Mrosc;
        $this->campos = [
            //'imagem', 'titulo', 'descricao', 'arquivo', 'idioma_id', 'cmsuser_id',
            'imagem', 'titulo', 'subtitulo', 'descricao', 'arquivo', 'posicao', 'cmsuser_id',
        ];
        $this->pathImagem = public_path().'/imagens/mroscs';
        $this->sizesImagem = [
            'xs' => ['width' => 140, 'height' => 79],
            'sm' => ['width' => 480, 'height' => 270],
            'md' => ['width' => 580, 'height' => 326],
            'lg' => ['width' => 1170, 'height' => 658]
        ];
        $this->widthOriginal = true;

        $this->pathArquivo = public_path().'/arquivos/mroscs';
    }

    function index()
    {

        $mroscs = \App\Mrosc::all();
        //$idiomas = \App\Idioma::lists('titulo', 'id')->all();


        return view('cms::mrosc.listar', ['mroscs' => $mroscs]);
        //return view('cms::mrosc.listar', ['mroscs' => $mroscs, 'idiomas' => $idiomas]);
    }

    public function listar(Request $request)
    {

        //Log::info('CAMPOS: '.$request->campos);

        //Auth::loginUsingId(2);

        $campos = explode(", ", $request->campos);

        $mroscs = DB::table('mroscs')
            ->select($campos)
            ->where([
                [$request->campoPesquisa, 'ilike', "%$request->dadoPesquisa%"],
            ])
            ->orderBy($request->ordem, $request->sentido)
            ->paginate($request->itensPorPagina);
        return $mroscs;
    }


    public function inserir(Request $request)
    {

        $data = $request->all();

        $data['mrosc'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                $data['mrosc'] += [$campo => ''];
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
                $data['mrosc']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['mrosc']['arquivo'] = $filenameArquivo;
            }
        }


        if($successFile && $successArquivo){
            return $this->mrosc->create($data['mrosc']);
        }else{
            return "erro";
        }


        return $this->mrosc->create($data['mrosc']);

    }

    public function detalhar($id)
    {
        $mrosc = $this->mrosc->where([
            ['id', '=', $id],
        ])->firstOrFail();
        //$idiomas = \App\Idioma::lists('titulo', 'id')->all();

        return view('cms::mrosc.detalhar', ['mrosc' => $mrosc]);
        //return view('cms::mrosc.detalhar', ['mrosc' => $mrosc, 'idiomas' => $idiomas]);
    }

    /*public function alterar(Request $request, $id)
    {
        $data = $request->all();
        $data['mrosc'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem'){
                    $data['mrosc'] += [$campo => ''];
                }
            }
        }
        $mrosc = $this->mrosc->where([
            ['id', '=', $id],
        ])->firstOrFail();

        $file = $request->file('file');

        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $success = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $mrosc);
            if($success){
                $data['mrosc']['imagem'] = $filename;
                $mrosc->update($data['mrosc']);
                return $mrosc->imagem;
            }else{
                return "erro";
            }
        }

        //remover imagem
        if($data['removerImagem']){
            $data['mrosc']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$mrosc->imagem)) {
                unlink($this->pathImagem . "/" . $mrosc->imagem);
            }
        }

        $mrosc->update($data['mrosc']);
        return "Gravado com sucesso";
    }*/

    public function alterar(Request $request, $id)
    {
        $data = $request->all();

        //return $data;

        $data['mrosc'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem' && $campo!='arquivo'){
                    $data['mrosc'] += [$campo => ''];
                }
            }
        }
        $mrosc = $this->mrosc->where([
            ['id', '=', $id],
        ])->firstOrFail();


        $file = $request->file('file');
        $arquivo = $request->file('arquivo');

        //remover imagem
        if($data['removerImagem']){
            $data['mrosc']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$mrosc->imagem)) {
                unlink($this->pathImagem . "/" . $mrosc->imagem);
            }
        }


        if($data['removerArquivo']){
            $data['mrosc']['arquivo'] = '';
            if(file_exists($this->pathArquivo."/".$mrosc->arquivo)) {
                unlink($this->pathArquivo . "/" . $mrosc->arquivo);
            }
        }


        $successFile = true;
        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $successFile = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $mrosc);
            if($successFile){
                $data['mrosc']['imagem'] = $filename;
            }
        }

        $successArquivo = true;
        if($arquivo!=null){
            $filenameArquivo = rand(1000,9999)."-".clean($arquivo->getClientOriginalName());
            $successArquivo = $arquivo->move($this->pathArquivo, $filenameArquivo);
            if($successArquivo){
                $data['mrosc']['arquivo'] = $filenameArquivo;
            }
        }

        if($successFile && $successArquivo){

            $mrosc->update($data['mrosc']);
            return $mrosc->imagem;
        }else{
            return "erro";
        }

        //$mrosc->update($data['mrosc']);
        //return "Gravado com sucesso";
    }

    public function excluir($id)
    {
        //Auth::loginUsingId(2);

        $mrosc = $this->mrosc->where([
            ['id', '=', $id],
        ])->firstOrFail();

        //remover imagens        
        if(!empty($mrosc->imagem)){
            //remover imagens
            $imagemCms = new ImagemCms();
            $imagemCms->excluir($this->pathImagem, $this->sizesImagem, $mrosc);
        }


        if(!empty($mrosc->arquivo)) {
            if (file_exists($this->pathArquivo . "/" . $mrosc->arquivo)) {
                unlink($this->pathArquivo . "/" . $mrosc->arquivo);
            }
        }

        $mrosc->delete();

    }

    public function status($id)
    {
        $tipo_atual = DB::table('mroscs')->where('id', $id)->first();
        $status = $tipo_atual->status == 0 ? 1 : 0;
        DB::table('mroscs')->where('id', $id)->update(['status' => $status]);

    }

    public function positionUp($id)
    {

        $posicao_atual = DB::table('mroscs')->where('id', $id)->first();
        $upPosicao = $posicao_atual->posicao-1;
        $posicao = $posicao_atual->posicao;

        //Coloca com a posicao do anterior
        DB::table('mroscs')->where('posicao', $upPosicao)->update(['posicao' => $posicao]);

        //atualiza a posicao para o anterior
        DB::table('mroscs')->where('id', $id)->update(['posicao' => $upPosicao]);


    }

    public function positionDown($id)
    {

        $posicao_atual = DB::table('mroscs')->where('id', $id)->first();
        $upPosicao = $posicao_atual->posicao+1;
        $posicao = $posicao_atual->posicao;

        //Coloca com a posicao do anterior
        DB::table('mroscs')->where('posicao', $upPosicao)->update(['posicao' => $posicao]);

        //atualiza a posicao para o anterior
        DB::table('mroscs')->where('id', $id)->update(['posicao' => $upPosicao]);

    }


}
