

------------------------------------------------------------
no composer.json deve acrestentar a linha de Cms

"psr-4": {
    "App\\": "app/",
    "Cms\\":"packages/cms/src/"
},

e rodar o comando composer dump-autoload

-----------------------------------------------------------
no config/app.php deve acrescentar em providers:

Cms\Providers\CmsServiceProvider::class,

-----------------------------------------------------------

para copiar as migrations para pasta "database/migrations" e "public/cms" com css e js para pasta "public" rode o comando:

php artisan vendor:publish

-------------------------------------------------------------

em config/auth.php

acrescentar em guards:


'cms' => [
    'driver' => 'session',
    'provider' => 'cms',
],

acrestentar em providers:

'cms' => [
    'driver' => 'eloquent',
    'model' => Cms\Models\CmsUser::class,
],

---------------------------------------------------------------

em app/Http/Kernel.php

$middlewareGroups:

'cms' => [
    \App\Http\Middleware\EncryptCookies::class,
    \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
    \Illuminate\Session\Middleware\StartSession::class,
    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    \App\Http\Middleware\VerifyCsrfToken::class,
    \App\Http\Middleware\Cors::class,
],

------------------------------------------------------------------

em app/Http/Kernel.php

'web' => [
....
....
\Cms\Middleware\ContadorMiddleware::class,

],