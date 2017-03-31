{{--É NECESSÁRIO RODAR O COMANDO composer require illuminate/html E ALTERAR ACRESCENTAR LINHA NO ARQUIVO config/app.php--}}



{!! Form::label('titulo', 'Título *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(modulo.titulo) %>", 'ng-model'=>'modulo.titulo', 'ng-required'=>'true', 'init-model'=>'modulo.titulo', 'placeholder' => '']) !!}<br>
{{--

{!! Form::label('descricao', 'Descrição *') !!}<br>
{!! Form::textarea('descricao', null, ['class'=>"form-control width-grande <% validar(modulo.descricao) %>", 'ui-tinymce'=>'tinymceOptions', 'ng-model'=>'modulo.descricao', 'init-model'=>'modulo.descricao']) !!}<br>

{!! Form::label('autor', 'Autor') !!}<br>
{!! Form::text('autor', null, ['class'=>"form-control width-grande <% validar(modulo.autor) %>", 'ng-model'=>'modulo.autor', 'init-model'=>'modulo.autor', 'placeholder' => '']) !!}<br>
--}}

{!! Form::label('link_modulo', 'Modulo (link do youtube)') !!}<br>
{!! Form::text('link_modulo', null, ['class'=>"form-control width-grande <% validar(modulo.link_modulo) %>", 'ng-model'=>'modulo.link_modulo', 'init-model'=>'modulo.link_modulo', 'placeholder' => '']) !!}<br>

{{--<div class="row">
    <div class="col-md-6">
        {!! Form::label('fonte', 'Fonte') !!}<br>
        {!! Form::text('fonte', null, ['class'=>"form-control width-grande <% validar(modulo.fonte) %>", 'ng-model'=>'modulo.fonte', 'init-model'=>'modulo.fonte', 'placeholder' => '']) !!}<br>
    </div>
    <div class="col-md-6">
        {!! Form::label('link_font', 'Link') !!}<br>
        {!! Form::text('link_font', null, ['class'=>"form-control width-grande <% validar(modulo.link_font) %>", 'ng-model'=>'modulo.link_font', 'init-model'=>'modulo.link_font', 'placeholder' => '']) !!}<br>
    </div>
</div>--}}

