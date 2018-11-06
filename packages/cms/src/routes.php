<?php



Route::group(['middleware' => 'cms'], function () {
    
    Route::get('/cms/login', 'Cms\Controllers\HomeController@telaLogin');
    Route::get('/cms/logout', 'Cms\Controllers\HomeController@logout');
    Route::post('/cms/login', 'Cms\Controllers\HomeController@login');

    Route::group(['middleware' => 'authcms:cms'], function () {
        
        Route::get('/cms', 'Cms\Controllers\HomeController@index');        

        //WEBDOORS
        Route::get('/cms/webdoors', 'Cms\Controllers\WebdoorController@index');
        Route::get('/cms/listar-webdoors', 'Cms\Controllers\WebdoorController@listar');
        Route::post('/cms/inserir-webdoor', 'Cms\Controllers\WebdoorController@inserir');
        Route::get('/cms/webdoor/{id}', 'Cms\Controllers\WebdoorController@detalhar');
        Route::post('/cms/alterar-webdoor/{id}', 'Cms\Controllers\WebdoorController@alterar');
        Route::get('/cms/excluir-webdoor/{id}', 'Cms\Controllers\WebdoorController@excluir');
        Route::get('/cms/status-webdoor/{id}', 'Cms\Controllers\WebdoorController@status');
        Route::get('/cms/positionUp-webdoor/{id}', 'Cms\Controllers\WebdoorController@positionUp');
        Route::get('/cms/positionDown-webdoor/{id}', 'Cms\Controllers\WebdoorController@positionDown');

        //ITEMS
        Route::get('/cms/items/{modulo_id}', 'Cms\Controllers\ItemController@index');
        Route::get('/cms/listar-items', 'Cms\Controllers\ItemController@listar');
        Route::post('/cms/inserir-item', 'Cms\Controllers\ItemController@inserir');
        Route::get('/cms/item/{id}', 'Cms\Controllers\ItemController@detalhar');
        Route::post('/cms/alterar-item/{id}', 'Cms\Controllers\ItemController@alterar');
        Route::get('/cms/excluir-item/{id}', 'Cms\Controllers\ItemController@excluir');
        Route::get('/cms/status-item/{id}', 'Cms\Controllers\ItemController@status');
        Route::get('/cms/positionUp-item/{id}', 'Cms\Controllers\ItemController@positionUp');
        Route::get('/cms/positionDown-item/{id}', 'Cms\Controllers\ItemController@positionDown');

        //ITEMS MROSC
        Route::get('/cms/items-mrosc/{mrosc_id}', 'Cms\Controllers\ItemMroscController@index');
        Route::get('/cms/listar-items-mrosc', 'Cms\Controllers\ItemMroscController@listar');
        Route::post('/cms/inserir-item-mrosc', 'Cms\Controllers\ItemMroscController@inserir');
        Route::get('/cms/item-mrosc/{id}', 'Cms\Controllers\ItemMroscController@detalhar');
        Route::post('/cms/alterar-item-mrosc/{id}', 'Cms\Controllers\ItemMroscController@alterar');
        Route::get('/cms/excluir-item-mrosc/{id}', 'Cms\Controllers\ItemMroscController@excluir');
        Route::get('/cms/status-item-mrosc/{id}', 'Cms\Controllers\ItemMroscController@status');

        //ITEMS VERSAO
        Route::get('/cms/items-versao/{versao_id}', 'Cms\Controllers\ItemVersaoController@index');
        Route::get('/cms/listar-items-versao', 'Cms\Controllers\ItemVersaoController@listar');
        Route::post('/cms/inserir-item-versao', 'Cms\Controllers\ItemVersaoController@inserir');
        Route::get('/cms/item-versao/{id}', 'Cms\Controllers\ItemVersaoController@detalhar');
        Route::post('/cms/alterar-item-versao/{id}', 'Cms\Controllers\ItemVersaoController@alterar');
        Route::get('/cms/excluir-item-versao/{id}', 'Cms\Controllers\ItemVersaoController@excluir');
        Route::get('/cms/status-item-versao/{id}', 'Cms\Controllers\ItemVersaoController@status');


        //Route::get('/cms/teste-excel', 'Cms\Controllers\SerieController@testeExcel');
        Route::get('/cms/teste-excel/{id}/{arquivo}', 'Cms\Controllers\SerieController@testeExcel');

        //MODULOS
        Route::get('/cms/modulos', 'Cms\Controllers\ModuloController@index');
        Route::get('/cms/listar-modulos', 'Cms\Controllers\ModuloController@listar');
        Route::post('/cms/inserir-modulo', 'Cms\Controllers\ModuloController@inserir');
        Route::get('/cms/modulo/{id}', 'Cms\Controllers\ModuloController@detalhar');
        Route::post('/cms/alterar-modulo/{id}', 'Cms\Controllers\ModuloController@alterar');
        Route::get('/cms/excluir-modulo/{id}', 'Cms\Controllers\ModuloController@excluir');
        Route::get('/cms/status-modulo/{id}', 'Cms\Controllers\ModuloController@status');
        
        //TIPOS
        Route::get('/cms/tipos', 'Cms\Controllers\TipoController@index');
        Route::get('/cms/listar-tipos', 'Cms\Controllers\TipoController@listar');
        Route::post('/cms/inserir-tipo', 'Cms\Controllers\TipoController@inserir');
        Route::get('/cms/tipo/{id}', 'Cms\Controllers\TipoController@detalhar');
        Route::post('/cms/alterar-tipo/{id}', 'Cms\Controllers\TipoController@alterar');
        Route::get('/cms/excluir-tipo/{id}', 'Cms\Controllers\TipoController@excluir');
        Route::get('/cms/status-tipo/{id}', 'Cms\Controllers\TipoController@status');

        //TIPOS GRAFICOS
        Route::get('/cms/tipos-graficos', 'Cms\Controllers\TipoGraficoController@index');
        Route::get('/cms/listar-tipos-graficos', 'Cms\Controllers\TipoGraficoController@listar');
        Route::post('/cms/inserir-tipo-grafico', 'Cms\Controllers\TipoGraficoController@inserir');
        Route::get('/cms/tipo-grafico/{id}', 'Cms\Controllers\TipoGraficoController@detalhar');
        Route::post('/cms/alterar-tipo-grafico/{id}', 'Cms\Controllers\TipoGraficoController@alterar');
        Route::get('/cms/excluir-tipo-grafico/{id}', 'Cms\Controllers\TipoGraficoController@excluir');
        Route::get('/cms/status-tipo-grafico/{id}', 'Cms\Controllers\TipoGraficoController@status');

        //NOTICIAS
        Route::get('/cms/noticias', 'Cms\Controllers\NoticiaController@index');
        Route::get('/cms/listar-noticias', 'Cms\Controllers\NoticiaController@listar');
        Route::post('/cms/inserir-noticia', 'Cms\Controllers\NoticiaController@inserir');
        Route::get('/cms/noticia/{id}', 'Cms\Controllers\NoticiaController@detalhar');
        Route::post('/cms/alterar-noticia/{id}', 'Cms\Controllers\NoticiaController@alterar');
        Route::get('/cms/excluir-noticia/{id}', 'Cms\Controllers\NoticiaController@excluir');
        Route::get('/cms/status-noticia/{id}', 'Cms\Controllers\NoticiaController@status');

        //PUBLICATIONS
        Route::get('/cms/publications', 'Cms\Controllers\PublicationController@index');
        Route::get('/cms/listar-publications', 'Cms\Controllers\PublicationController@listar');
        Route::post('/cms/inserir-publication', 'Cms\Controllers\PublicationController@inserir');
        Route::get('/cms/publication/{id}', 'Cms\Controllers\PublicationController@detalhar');
        Route::post('/cms/alterar-publication/{id}', 'Cms\Controllers\PublicationController@alterar');
        Route::get('/cms/excluir-publication/{id}', 'Cms\Controllers\PublicationController@excluir');
        Route::get('/cms/status-publication/{id}', 'Cms\Controllers\PublicationController@status');

        //LINKS
        Route::get('/cms/links', 'Cms\Controllers\LinkController@index');
        Route::get('/cms/listar-links', 'Cms\Controllers\LinkController@listar');
        Route::post('/cms/inserir-link', 'Cms\Controllers\LinkController@inserir');
        Route::get('/cms/link/{id}', 'Cms\Controllers\LinkController@detalhar');
        Route::post('/cms/alterar-link/{id}', 'Cms\Controllers\LinkController@alterar');
        Route::get('/cms/excluir-link/{id}', 'Cms\Controllers\LinkController@excluir');
        Route::get('/cms/status-link/{id}', 'Cms\Controllers\LinkController@status');
        Route::get('/cms/positionUp-link/{id}', 'Cms\Controllers\LinkController@positionUp');
        Route::get('/cms/positionDown-link/{id}', 'Cms\Controllers\LinkController@positionDown');

        //APOIOS
        Route::get('/cms/apoios', 'Cms\Controllers\ApoioController@index');
        Route::get('/cms/listar-apoios', 'Cms\Controllers\ApoioController@listar');
        Route::post('/cms/inserir-apoio', 'Cms\Controllers\ApoioController@inserir');
        Route::get('/cms/apoio/{id}', 'Cms\Controllers\ApoioController@detalhar');
        Route::post('/cms/alterar-apoio/{id}', 'Cms\Controllers\ApoioController@alterar');
        Route::get('/cms/excluir-apoio/{id}', 'Cms\Controllers\ApoioController@excluir');
        Route::get('/cms/status-apoio/{id}', 'Cms\Controllers\ApoioController@status');
        Route::get('/cms/positionUp-apoio/{id}', 'Cms\Controllers\ApoioController@positionUp');
        Route::get('/cms/positionDown-apoio/{id}', 'Cms\Controllers\ApoioController@positionDown');
        
        //EQUIPES
        Route::get('/cms/equipes', 'Cms\Controllers\EquipeController@index');
        Route::get('/cms/listar-equipes', 'Cms\Controllers\EquipeController@listar');
        Route::post('/cms/inserir-equipe', 'Cms\Controllers\EquipeController@inserir');
        Route::get('/cms/equipe/{id}', 'Cms\Controllers\EquipeController@detalhar');
        Route::post('/cms/alterar-equipe/{id}', 'Cms\Controllers\EquipeController@alterar');
        Route::get('/cms/excluir-equipe/{id}', 'Cms\Controllers\EquipeController@excluir');  
        
        //INTEGRANTES
        Route::get('/cms/integrantes', 'Cms\Controllers\IntegranteController@index');
        Route::get('/cms/listar-integrantes', 'Cms\Controllers\IntegranteController@listar');
        Route::post('/cms/inserir-integrante', 'Cms\Controllers\IntegranteController@inserir');
        Route::get('/cms/integrante/{id}', 'Cms\Controllers\IntegranteController@detalhar');
        Route::post('/cms/alterar-integrante/{id}', 'Cms\Controllers\IntegranteController@alterar');
        Route::get('/cms/excluir-integrante/{id}', 'Cms\Controllers\IntegranteController@excluir');

        //EDITAIS
        Route::get('/cms/editais', 'Cms\Controllers\EditalController@index');
        Route::get('/cms/listar-editais', 'Cms\Controllers\EditalController@listar');
        Route::post('/cms/inserir-edital', 'Cms\Controllers\EditalController@inserir');
        Route::get('/cms/edital/{id}', 'Cms\Controllers\EditalController@detalhar');
        Route::post('/cms/alterar-edital/{id}', 'Cms\Controllers\EditalController@alterar');
        Route::get('/cms/excluir-edital/{id}', 'Cms\Controllers\EditalController@excluir');
        
        //GRAFICOS
        Route::get('/cms/graficos', 'Cms\Controllers\GraficoController@index');
        Route::get('/cms/listar-graficos', 'Cms\Controllers\GraficoController@listar');
        Route::post('/cms/inserir-grafico', 'Cms\Controllers\GraficoController@inserir');
        Route::get('/cms/grafico/{id}', 'Cms\Controllers\GraficoController@detalhar');
        Route::post('/cms/alterar-grafico/{id}', 'Cms\Controllers\GraficoController@alterar');
        Route::get('/cms/excluir-grafico/{id}', 'Cms\Controllers\GraficoController@excluir');
        Route::get('/cms/status-grafico/{id}', 'Cms\Controllers\GraficoController@status');

        //MROSCS
        Route::get('/cms/mroscs', 'Cms\Controllers\MroscController@index');
        Route::get('/cms/listar-mroscs', 'Cms\Controllers\MroscController@listar');
        Route::post('/cms/inserir-mrosc', 'Cms\Controllers\MroscController@inserir');
        Route::get('/cms/mrosc/{id}', 'Cms\Controllers\MroscController@detalhar');
        Route::post('/cms/alterar-mrosc/{id}', 'Cms\Controllers\MroscController@alterar');
        Route::get('/cms/excluir-mrosc/{id}', 'Cms\Controllers\MroscController@excluir');
        Route::get('/cms/status-mrosc/{id}', 'Cms\Controllers\MroscController@status');
        Route::get('/cms/positionUp-mrosc/{id}', 'Cms\Controllers\MroscController@positionUp');
        Route::get('/cms/positionDown-mrosc/{id}', 'Cms\Controllers\MroscController@positionDown');

        //VERSOES
        Route::get('/cms/versoes', 'Cms\Controllers\VersaoController@index');
        Route::get('/cms/listar-versoes', 'Cms\Controllers\VersaoController@listar');
        Route::post('/cms/inserir-versao', 'Cms\Controllers\VersaoController@inserir');
        Route::get('/cms/versao/{id}', 'Cms\Controllers\VersaoController@detalhar');
        Route::post('/cms/alterar-versao/{id}', 'Cms\Controllers\VersaoController@alterar');
        Route::get('/cms/excluir-versao/{id}', 'Cms\Controllers\VersaoController@excluir');
        Route::get('/cms/status-versao/{id}', 'Cms\Controllers\VersaoController@status');
        Route::get('/cms/positionUp-versao/{id}', 'Cms\Controllers\VersaoController@positionUp');
        Route::get('/cms/positionDown-versao/{id}', 'Cms\Controllers\VersaoController@positionDown');

        //IDIOMAS
        Route::get('/cms/idiomas', 'Cms\Controllers\IdiomaController@index');
        Route::get('/cms/listar-idiomas', 'Cms\Controllers\IdiomaController@listar');
        Route::post('/cms/inserir-idioma', 'Cms\Controllers\IdiomaController@inserir');
        Route::get('/cms/idioma/{id}', 'Cms\Controllers\IdiomaController@detalhar');
        Route::post('/cms/alterar-idioma/{id}', 'Cms\Controllers\IdiomaController@alterar');
        Route::get('/cms/excluir-idioma/{id}', 'Cms\Controllers\IdiomaController@excluir');


        //VIDEOS
        Route::get('/cms/videos', 'Cms\Controllers\VideoController@index');
        Route::get('/cms/listar-videos', 'Cms\Controllers\VideoController@listar');
        Route::post('/cms/inserir-video', 'Cms\Controllers\VideoController@inserir');
        Route::get('/cms/video/{id}', 'Cms\Controllers\VideoController@detalhar');
        Route::post('/cms/alterar-video/{id}', 'Cms\Controllers\VideoController@alterar');
        Route::get('/cms/excluir-video/{id}', 'Cms\Controllers\VideoController@excluir');
        Route::get('/cms/status-video/{id}', 'Cms\Controllers\VideoController@status');
        

        //User
        Route::get('/cms/usuarios', 'Cms\Controllers\CmsUserController@index');
        Route::get('/cms/listar-cmsusers', 'Cms\Controllers\CmsUserController@listar');
        Route::post('/cms/inserir-cmsuser', 'Cms\Controllers\CmsUserController@inserir');
        Route::get('/cms/usuario/{id}', 'Cms\Controllers\CmsUserController@detalhar');        
        Route::post('/cms/alterar-cmsuser/{id}', 'Cms\Controllers\CmsUserController@alterar');
        Route::get('/cms/perfil', 'Cms\Controllers\CmsUserController@perfil');
        Route::post('/cms/alterar-perfil', 'Cms\Controllers\CmsUserController@alterarPerfil');
        Route::get('/cms/excluir-cmsuser/{id}', 'Cms\Controllers\CmsUserController@excluir');
        
    });

});