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