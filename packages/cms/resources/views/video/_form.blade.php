{{--É NECESSÁRIO RODAR O COMANDO composer require illuminate/html E ALTERAR ACRESCENTAR LINHA NO ARQUIVO config/app.php--}}



{!! Form::label('titulo', 'Título *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(video.titulo) %>", 'ng-model'=>'video.titulo', 'ng-required'=>'true', 'init-model'=>'video.titulo', 'placeholder' => '']) !!}<br>
{{--

{!! Form::label('descricao', 'Descrição *') !!}<br>
{!! Form::textarea('descricao', null, ['class'=>"form-control width-grande <% validar(video.descricao) %>", 'ui-tinymce'=>'tinymceOptions', 'ng-model'=>'video.descricao', 'init-model'=>'video.descricao']) !!}<br>

{!! Form::label('autor', 'Autor') !!}<br>
{!! Form::text('autor', null, ['class'=>"form-control width-grande <% validar(video.autor) %>", 'ng-model'=>'video.autor', 'init-model'=>'video.autor', 'placeholder' => '']) !!}<br>
--}}

{!! Form::label('link_video', 'Video (link do youtube)') !!}<br>
{!! Form::text('link_video', null, ['class'=>"form-control width-grande <% validar(video.link_video) %>", 'ng-model'=>'video.link_video', 'init-model'=>'video.link_video', 'placeholder' => '']) !!}<br>

{{--<div class="row">
    <div class="col-md-6">
        {!! Form::label('fonte', 'Fonte') !!}<br>
        {!! Form::text('fonte', null, ['class'=>"form-control width-grande <% validar(video.fonte) %>", 'ng-model'=>'video.fonte', 'init-model'=>'video.fonte', 'placeholder' => '']) !!}<br>
    </div>
    <div class="col-md-6">
        {!! Form::label('link_font', 'Link') !!}<br>
        {!! Form::text('link_font', null, ['class'=>"form-control width-grande <% validar(video.link_font) %>", 'ng-model'=>'video.link_font', 'init-model'=>'video.link_font', 'placeholder' => '']) !!}<br>
    </div>
</div>--}}

