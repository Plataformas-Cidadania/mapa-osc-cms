<?php

namespace Cms\Controllers;

use Cms\Models\ImagemCms;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class VideoController extends Controller
{
    
    

    public function __construct()
    {
        $this->video = new \App\Video;
        $this->campos = [
            'imagem', 'titulo', 'data', 'resumida', 'descricao', 'link_video', 'cmsuser_id',
        ];
        $this->pathImagem = public_path().'/imagens/videos';
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

        $videos = \App\Video::all();
        //$idiomas = \App\Idioma::lists('titulo', 'id')->all();

        return view('cms::video.listar', ['videos' => $videos]);
        //return view('cms::video.listar', ['videos' => $videos, 'idiomas' => $idiomas]);
    }

    public function listar(Request $request)
    {

        //Log::info('CAMPOS: '.$request->campos);

        //Auth::loginUsingId(2);

        $campos = explode(", ", $request->campos);

        $videos = DB::table('videos')
            ->select($campos)
            ->where([
                [$request->campoPesquisa, 'ilike', "%$request->dadoPesquisa%"],
            ])
            ->orderBy($request->ordem, $request->sentido)
            ->paginate($request->itensPorPagina);
        return $videos;
    }

    public function inserir(Request $request)
    {

        $data = $request->all();

        $data['video'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

	//$data['video']['idioma_id'] = 1;

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                $data['video'] += [$campo => ''];
            }
        }

	

        $file = $request->file('file');

        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $success = $imagemCms->inserir($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal);
            
            if($success){
                $data['video']['imagem'] = $filename;
		Log::info($data);
                return $this->video->create($data['video']);
            }else{
                return "erro";
            }
        }

	Log::info($data);
        return $this->video->create($data['video']);

    }

    public function detalhar($id)
    {
        $video = $this->video->where([
            ['id', '=', $id],
        ])->firstOrFail();
        //$idiomas = \App\Idioma::lists('titulo', 'id')->all();

        return view('cms::video.detalhar', ['video' => $video]);
        //return view('cms::video.detalhar', ['video' => $video, 'idiomas' => $idiomas]);
    }

    public function alterar(Request $request, $id)
    {
        $data = $request->all();
        $data['video'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

	//$data['video']['idioma_id'] = 1;

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem'){
                    $data['video'] += [$campo => ''];
                }
            }
        }
        $video = $this->video->where([
            ['id', '=', $id],
        ])->firstOrFail();

        $file = $request->file('file');

        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $success = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $video);
            if($success){
                $data['video']['imagem'] = $filename;
                $video->update($data['video']);
                return $video->imagem;
            }else{
                return "erro";
            }
        }

        //remover imagem
        if($data['removerImagem']){
            $data['video']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$video->imagem)) {
                unlink($this->pathImagem . "/" . $video->imagem);
            }
        }

        $video->update($data['video']);
        return "Gravado com sucesso";
    }

    public function excluir($id)
    {
        //Auth::loginUsingId(2);

        $video = $this->video->where([
            ['id', '=', $id],
        ])->firstOrFail();

        //remover imagens        
        if(!empty($video->imagem)){
            //remover imagens
            $imagemCms = new ImagemCms();
            $imagemCms->excluir($this->pathImagem, $this->sizesImagem, $video);
        }
                

        $video->delete();

    }

    public function status($id)
    {
        $tipo_atual = DB::table('videos')->where('id', $id)->first();
        $status = $tipo_atual->status == 0 ? 1 : 0;
        DB::table('videos')->where('id', $id)->update(['status' => $status]);

    }


}
