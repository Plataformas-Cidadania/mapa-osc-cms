{{--<div style="display: none;">
{!! Form::label('idioma_id', 'Idioma *') !!}<br>
{!! Form::select('idioma_id',
        $idiomas,
null, ['class'=>"form-control width-medio <% validar(apoio.idioma_id) %>", 'ng-model'=>'apoio.idioma_id', 'init-model'=>'apoio.idioma_id']) !!}<br>
</div>--}}


{!! Form::label('titulo', 'Título *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(apoio.titulo) %>", 'ng-model'=>'apoio.titulo', 'ng-required'=>'true', 'init-model'=>'apoio.titulo', 'placeholder' => '']) !!}<br>

{!! Form::label('descricao', 'Descrição') !!}<br>
{!! Form::textarea('descricao', null, ['class'=>"form-control width-grande <% validar(apoio.descricao) %>", 'ui-tinymce'=>'tinymceOptions',  'ng-model'=>'apoio.descricao', 'init-model'=>'apoio.descricao']) !!}<br>

{!! Form::label('url', 'Link*') !!}<br>
{!! Form::text('url', null, ['class'=>"form-control width-grande <% validar(apoio.descricao) %>", 'ng-model'=>'url', 'ng-required'=>'true',  'init-model'=>'url', 'placeholder' => '']) !!}<br>
