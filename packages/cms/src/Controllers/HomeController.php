<?php

namespace Cms\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }    
    
    public function index()
    {
        return view('cms::home');
    }

    public function telaLogin()
    {
        return view('cms::auth.login');
    }

    public function login(Request $request)
    {
        //dd($request->all());

        $validator = validator($request->all(), [
            'email' => 'required|min:3|max:100',
            'password' => 'required|min:3|max:100',
        ]);

        if($validator->fails()){
            return redirect('/cms/login')
                ->withErrors($validator)
                ->withInput();
        }

        $dadosUsuario = ['email' => $request->get('email'), 'password' => $request->get('password')];

        if(auth()->guard('cms')->attempt($dadosUsuario)){
            return redirect('/cms');
        }else{
            return redirect('/cms/login')
                ->withErrors(['errors'=>'Usuário ou senha inválidos'])
                ->withInput();
        }
    }

    public function logout(){
        auth()->guard('cms')->logout();
        return redirect('/cms/login');

    }
}
