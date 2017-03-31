<?php

namespace Cms\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class CmsUserController extends Controller
{

    public function __construct()
    {
        $this->cmsuser = new \Cms\Models\CmsUser;
        $this->campos = [
            'name', 'email', 'password', 'alterar_senha',
        ];

    }   


    function index()
    {

        $cmsusers = \Cms\Models\CmsUser::all();

        return view('cms::cmsuser.listar', ['cmsusers' => $cmsusers]);
    }

    public function listar(Request $request)
    {

        //Log::info('CAMPOS: '.$request->campos);

        //Auth::loginUsingId(2);

        $campos = explode(", ", $request->campos);

        $cmsusers = DB::table('cms_users')
            ->select($campos)
            ->where([
                [$request->campoPesquisa, 'like', "%$request->dadoPesquisa%"],
            ])
            ->orderBy($request->ordem, $request->sentido)
            ->paginate($request->itensPorPagina);
        return $cmsusers;
    }

    public function inserir(Request $request)
    {

        $data = $request->all();

        $data['cmsuser'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario

        $data['cmsuser']['password'] = bcrypt($data['cmsuser']['password']);

        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                $data['cmsuser'] += [$campo => ''];
            }
        }

        return $this->cmsuser->create($data['cmsuser']);

    }

    public function detalhar($id)
    {
        $cmsuser = $this->cmsuser->where([
            ['id', '=', $id],
        ])->firstOrFail();
        return view('cms::cmsuser.detalhar', ['cmsuser' => $cmsuser]);
    }

    public function perfil()
    {

        $id = auth()->guard('cms')->user()->id;
        
        $cmsuser = $this->cmsuser->where([
            ['id', '=', $id],
        ])->firstOrFail();
        return view('cms::cmsuser.perfil', ['cmsuser' => $cmsuser]);
    }

    public function alterarPerfil(Request $request)
    {

        $id = auth()->guard('cms')->user()->id;
        
        $data = $request->all();
       
        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem' && $campo!='password'){
                    $data['cmsuser'] += [$campo => ''];
                }
            }
        }
        $cmsuser = $this->cmsuser->where([
            ['id', '=', $id],
        ])->firstOrFail();

        //para que a senha não seja apagada.
        if($data['cmsuser']['alterar_senha']){
            $data['cmsuser']['password'] = bcrypt($data['cmsuser']['password']);
        }else{
            unset($data['cmsuser']['password']);
        }

        $cmsuser->update($data['cmsuser']);
        return "Gravado com sucesso";
    }

    public function alterar(Request $request, $id)
    {

        $data = $request->all();
        //return $data;
        //$data['cmsuser'] += ['cmsuser_id' => auth()->guard('cms')->user()->id];//adiciona id do usuario


        //verifica se o index do campo existe no array e caso não exista inserir o campo com valor vazio.
        foreach($this->campos as $campo){
            if(!array_key_exists($campo, $data)){
                if($campo!='imagem' && $campo!='password'){
                    $data['cmsuser'] += [$campo => ''];
                }
            }
        }
        $cmsuser = $this->cmsuser->where([
            ['id', '=', $id],
        ])->firstOrFail();

        //para que a senha não seja apagada.
        if($data['cmsuser']['alterar_senha']){
            $data['cmsuser']['password'] = bcrypt($data['cmsuser']['password']);
        }else{
            unset($data['cmsuser']['password']);
        }        

        $cmsuser->update($data['cmsuser']);
        return "Gravado com sucesso";
    }

    public function excluir($id)
    {
        //Auth::loginUsingId(2);

        $cmsuser = $this->cmsuser->where([
            ['id', '=', $id],
        ])->firstOrFail();

        if(!empty($cmsuser->imagem)){
            //remover imagens
            $imagemCms = new ImagemCms();
            $imagemCms->excluir($this->pathImagem, $this->sizesImagem, $cmsuser);
        }

        $cmsuser->delete();


    }
}
