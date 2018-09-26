<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('info123', function(){
    return view('info');
});

Route::get('Imprensa', 'ApiController@imprensa');
Route::get('imprensa', 'ApiController@imprensa');


Route::get('NoticiaByID/{idNoticia}', 'ApiController@noticiaByID');
Route::get('noticiaByID/{idNoticia}', 'ApiController@noticiaByID');

Route::get('VideoByID/{idVideo}', 'ApiController@videoByID');
Route::get('videoByID/{idVideo}', 'ApiController@videoByID');

Route::get('editais', 'ApiController@editais');
Route::get('EditalByID/{idEdital}', 'ApiController@editalByID');
Route::get('editalByID/{idEdital}', 'ApiController@editalByID');

Route::get('MenuMrosc', 'ApiController@menuMrosc');
Route::get('menuMrosc', 'ApiController@menuMrosc');

Route::get('ConteudoMroscByID/{id}', 'ApiController@ConteudoMroscByID');
Route::get('conteudoMroscByID/{id}', 'ApiController@ConteudoMroscByID');

/*Route::get('ItensMrosc', 'ApiController@itensMrosc');
Route::get('itensMrosc', 'ApiController@itensMrosc');*/

Route::get('ModuloByID/{idModulo}', 'ApiController@moduloByID');
Route::get('moduloByID/{idModulo}', 'ApiController@moduloByID');

Route::get('ModuloByTipo/{idTipo}', 'ApiController@moduloByTipo');
Route::get('moduloByTipo/{idTipo}', 'ApiController@moduloByTipo');

Route::get('Webdoors', 'ApiController@webdoors');
Route::get('webdoors', 'ApiController@webdoors');

Route::get('WebdoorByID/{idWebdoor}', 'ApiController@webdoorByID');
Route::get('webdoorByID/{idWebdoor}', 'ApiController@webdoorByID');

Route::get('ModulosByTipoID/{idTipo}', 'ApiController@modulosByTipoID');
Route::get('modulosByTipoID/{idTipo}', 'ApiController@modulosByTipoID');

Route::get('ModuloBySlug/{slug}', 'ApiController@ModuloBySlug');
Route::get('moduloBySlug/{slug}', 'ApiController@moduloBySlug');

Route::get('Links/', 'ApiController@links');
Route::get('links/', 'ApiController@links');

Route::get('Equipes/', 'ApiController@equipes');
Route::get('equipes/', 'ApiController@equipes');

Route::get('Apoios/', 'ApiController@apoios');
Route::get('apoios/', 'ApiController@apoios');

Route::get('Publicacoes/', 'ApiController@publicacoes');
Route::get('publicacoes/', 'ApiController@publicacoes');

Route::get('PublicacaoByID/{idPublication}', 'ApiController@publicacaoByID');
Route::get('publicacaoByID/{idPublication}', 'ApiController@publicacaoByID');

Route::get('Graficos/', 'ApiController@graficos');
Route::get('graficos/', 'ApiController@graficos');