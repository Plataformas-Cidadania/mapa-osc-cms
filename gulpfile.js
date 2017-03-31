process.env.DISABLE_NOTIFIER = true;
var elixir = require('laravel-elixir');
elixir.config.sourcemaps = false;

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

/*elixir(function(mix) {
 mix.sass('app.scss');
 });*/

elixir(function(mix) {
    //CMS///////////////////////////////////////////////////////////////////
    //css
    mix.less('../../../packages/cms/resources/assets/less/cms.less', 'public/assets-cms/css/cms.css');
    mix.styles('../../../packages/cms/resources/assets/css/sb-admin.css', 'public/assets-cms/css/sb-admin.css');
    mix.styles('../../../packages/cms/resources/assets/css/circle.css', 'public/assets-cms/css/circle.css');

    //App angular
    mix.scripts('../../../packages/cms/resources/assets/js/cms.js', 'public/assets-cms/js/cms.js');

    mix.scripts('../../../packages/cms/resources/assets/js/tiny.js', 'public/assets-cms/js/tiny.js');

    //Directives
    mix.scripts('../../../packages/cms/resources/assets/js/directives/initModel.js', 'public/assets-cms/js/directives/initModel.js');

    //Controllers

    //Webdoor
    mix.scripts('../../../packages/cms/resources/assets/js/controllers/webdoorCtrl.js', 'public/assets-cms/js/controllers/webdoorCtrl.js');
    mix.scripts('../../../packages/cms/resources/assets/js/controllers/alterarWebdoorCtrl.js', 'public/assets-cms/js/controllers/alterarWebdoorCtrl.js');

    //Noticias
    mix.scripts('../../../packages/cms/resources/assets/js/controllers/noticiaCtrl.js', 'public/assets-cms/js/controllers/noticiaCtrl.js');
    mix.scripts('../../../packages/cms/resources/assets/js/controllers/alterarNoticiaCtrl.js', 'public/assets-cms/js/controllers/alterarNoticiaCtrl.js');

    //Artigos
    mix.scripts('../../../packages/cms/resources/assets/js/controllers/artigoCtrl.js', 'public/assets-cms/js/controllers/artigoCtrl.js');
    mix.scripts('../../../packages/cms/resources/assets/js/controllers/alterarArtigoCtrl.js', 'public/assets-cms/js/controllers/alterarArtigoCtrl.js');

    //Videos
    mix.scripts('../../../packages/cms/resources/assets/js/controllers/videoCtrl.js', 'public/assets-cms/js/controllers/videoCtrl.js');
    mix.scripts('../../../packages/cms/resources/assets/js/controllers/alterarVideoCtrl.js', 'public/assets-cms/js/controllers/alterarVideoCtrl.js');

    //Authors
    mix.scripts('../../../packages/cms/resources/assets/js/controllers/authorCtrl.js', 'public/assets-cms/js/controllers/authorCtrl.js');
    mix.scripts('../../../packages/cms/resources/assets/js/controllers/alterarAuthorCtrl.js', 'public/assets-cms/js/controllers/alterarAuthorCtrl.js');

    //Downloads
    mix.scripts('../../../packages/cms/resources/assets/js/controllers/downloadCtrl.js', 'public/assets-cms/js/controllers/downloadCtrl.js');
    mix.scripts('../../../packages/cms/resources/assets/js/controllers/alterarDownloadCtrl.js', 'public/assets-cms/js/controllers/alterarDownloadCtrl.js');

    //CmsUsers
    mix.scripts('../../../packages/cms/resources/assets/js/controllers/cmsUserCtrl.js', 'public/assets-cms/js/controllers/cmsUserCtrl.js');
    mix.scripts('../../../packages/cms/resources/assets/js/controllers/alterarCmsUserCtrl.js', 'public/assets-cms/js/controllers/alterarCmsUserCtrl.js');

    //Settings
    mix.scripts('../../../packages/cms/resources/assets/js/controllers/alterarSettingCtrl.js', 'public/assets-cms/js/controllers/alterarSettingCtrl.js');

    //FIM CMS///////////////////////////////////////////////////////////////////






});
