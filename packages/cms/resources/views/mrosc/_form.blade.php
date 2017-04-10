{{--É NECESSÁRIO RODAR O COMANDO composer require illuminate/html E ALTERAR ACRESCENTAR LINHA NO ARQUIVO config/app.php--}}
{!! Form::label('idioma_id', 'Idioma *') !!}<br>
{!! Form::select('idioma_id',
        $idiomas,
null, ['class'=>"form-control width-medio <% validar(mrosc.idioma_id) %>", 'ng-model'=>'mrosc.idioma_id', 'ng-required'=>'true', 'init-model'=>'mrosc.idioma_id', 'placeholder' => 'Selecione']) !!}<br>

{!! Form::label('titulo', 'Título *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(mrosc.titulo) %>", 'ng-model'=>'mrosc.titulo', 'ng-required'=>'true', 'init-model'=>'mrosc.titulo', 'placeholder' => '']) !!}<br>

{!! Form::label('slug', 'slug *') !!}<br>
{!! Form::text('slug', null, ['class'=>"form-control width-medio <% validar(mrosc.slug) %>", 'ng-model'=>'mrosc.slug', 'ng-required'=>'true', 'init-model'=>'mrosc.slug', 'placeholder' => '']) !!}<br>

{!! Form::label('descricao', 'Descrição *') !!}<br>
{!! Form::textarea('descricao', null, ['class'=>"form-control width-grande <% validar(mrosc.descricao) %>", 'ui-tinymce'=>'tinymceOptions', 'ng-model'=>'mrosc.descricao', 'init-model'=>'mrosc.descricao']) !!}<br>

