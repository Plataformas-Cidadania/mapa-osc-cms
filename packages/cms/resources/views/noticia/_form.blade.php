{{--É NECESSÁRIO RODAR O COMANDO composer require illuminate/html E ALTERAR ACRESCENTAR LINHA NO ARQUIVO config/app.php--}}
{!! Form::label('idioma_id', 'Idioma *') !!}<br>
{!! Form::select('idioma_id',
        $idiomas,
null, ['class'=>"form-control width-medio <% validar(noticia.idioma_id) %>", 'ng-model'=>'noticia.idioma_id', 'ng-required'=>'true', 'init-model'=>'noticia.idioma_id', 'placeholder' => 'Selecione']) !!}<br>

{!! Form::label('titulo', 'Título *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(noticia.titulo) %>", 'ng-model'=>'noticia.titulo', 'ng-required'=>'true', 'init-model'=>'noticia.titulo', 'placeholder' => '']) !!}<br>

{!! Form::label('slug', 'slug *') !!}<br>
{!! Form::text('slug', null, ['class'=>"form-control width-medio <% validar(noticia.slug) %>", 'ng-model'=>'noticia.slug', 'ng-required'=>'true', 'init-model'=>'noticia.slug', 'placeholder' => '']) !!}<br>

{!! Form::label('descricao', 'Descrição *') !!}<br>
{!! Form::textarea('descricao', null, ['class'=>"form-control width-grande <% validar(noticia.descricao) %>", 'ui-tinymce'=>'tinymceOptions', 'ng-model'=>'noticia.descricao', 'init-model'=>'noticia.descricao']) !!}<br>

