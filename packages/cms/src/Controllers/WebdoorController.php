<?php

namespace Cms\Controllers;

use Cms\Models\ImagemCms;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class WebdoorController extends Controller
{
    
    

    public function __construct()
    {
        $this->webdoor = new \App\Webdoor;
        $this->campos = [
            'imagem', 'titulo', 'descricao', 'link', 'legenda', 'posicao', 'cmsuser_id',
        ];
        $this->pathImagem = public_path().'/imagens/webdoors';
        $this->sizesImagem = [
            'xs' => ['width' => 300, 'height' => 63],
            'sm' => ['width' => 768, 'height' => 160],
            'md' => ['width' => 980, 'height' => 204],
            'lg' => ['width' => 1200, 'height' => 250]
        ];
        $this->widthOriginal = true;
    }

    function index()
    {

        $webdoors = \App\Webdoor::all();

        return view('cms::webdoor.listar', ['webdoors' => $webdoors]);
    }

    public function listar(Request $request)
    {

        //Log::info('CAMPOS: '.$request->campos);

        //Auth::loginUsingId(2);

        $campos = explode(", ", $request->campos);

        $webdoors = DB::table('webdoors')
            ->select($campos)
            ->where([
                [$request->campoPesquisa, 'ilike', "%$request->dadoPesquisa%"],
            ])
            ->orderBy($request->ordem, $request->sentido)
            ->paginate($request->itensPorPagina);
        return $webdoors;
    }

    public function inserir(Request $request)
    {

        $data = $request->all();

        $data['webdoor'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                $data['webdoor'] += [$campo => ''];
            }
        }

        $file = $request->file('file');

        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $success = $imagemCms->inserir($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal);
            
            if($success){
                $data['webdoor']['imagem'] = $filename;
                return $this->webdoor->create($data['webdoor']);
            }else{
                return "erro";
            }
        }

        return $this->webdoor->create($data['webdoor']);

    }

    public function detalhar($id)
    {
        $webdoor = $this->webdoor->where([
            ['id', '=', $id],
        ])->firstOrFail();
        return view('cms::webdoor.detalhar', ['webdoor' => $webdoor]);
    }

    public function alterar(Request $request, $id)
    {
        $data = $request->all();
        $data['webdoor'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem'){
                    $data['webdoor'] += [$campo => ''];
                }
            }
        }
        $webdoor = $this->webdoor->where([
            ['id', '=', $id],
        ])->firstOrFail();

        $file = $request->file('file');

        if($file!=null){
            $filename = rand(1000,9999)."-".clean($file->getClientOriginalName());
            $imagemCms = new ImagemCms();
            $success = $imagemCms->alterar($file, $this->pathImagem, $filename, $this->sizesImagem, $this->widthOriginal, $webdoor);
            if($success){
                $data['webdoor']['imagem'] = $filename;
                $webdoor->update($data['webdoor']);
                return $webdoor->imagem;
            }else{
                return "erro";
            }
        }

        //remover imagem
        if($data['removerImagem']){
            $data['webdoor']['imagem'] = '';
            if(file_exists($this->pathImagem."/".$webdoor->imagem)) {
                unlink($this->pathImagem . "/" . $webdoor->imagem);
            }
        }

        $webdoor->update($data['webdoor']);
        return "Gravado com sucesso";
    }

    public function excluir($id)
    {
        //Auth::loginUsingId(2);

        $webdoor = $this->webdoor->where([
            ['id', '=', $id],
        ])->firstOrFail();

        //remover imagens
        if(!empty($webdoor->imagem)){
            //remover imagens
            $imagemCms = new ImagemCms();
            $imagemCms->excluir($this->pathImagem, $this->sizesImagem, $webdoor);
        }
                

        $webdoor->delete();

    }

    public function status($id)
    {
        $tipo_atual = DB::table('webdoors')->where('id', $id)->first();
        $status = $tipo_atual->status == 0 ? 1 : 0;
        DB::table('webdoors')->where('id', $id)->update(['status' => $status]);

    }

    public function positionUp($id)
    {

        $posicao_atual = DB::table('webdoors')->where('id', $id)->first();
        $upPosicao = $posicao_atual->posicao-1;
        $posicao = $posicao_atual->posicao;

        //Coloca com a posicao do anterior
        DB::table('webdoors')->where('posicao', $upPosicao)->update(['posicao' => $posicao]);

        //atualiza a posicao para o anterior
        DB::table('webdoors')->where('id', $id)->update(['posicao' => $upPosicao]);


    }

    public function positionDown($id)
    {

        $posicao_atual = DB::table('webdoors')->where('id', $id)->first();
        $upPosicao = $posicao_atual->posicao+1;
        $posicao = $posicao_atual->posicao;

        //Coloca com a posicao do anterior
        DB::table('webdoors')->where('posicao', $upPosicao)->update(['posicao' => $posicao]);

        //atualiza a posicao para o anterior
        DB::table('webdoors')->where('id', $id)->update(['posicao' => $upPosicao]);

    }
}
