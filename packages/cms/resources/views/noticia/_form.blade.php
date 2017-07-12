<div style="display: none;">
{!! Form::label('idioma_id', 'Idioma *') !!}<br>
{!! Form::select('idioma_id',
        $idiomas,
null, ['class'=>"form-control width-medio <% validar(noticia.idioma_id) %>", 'ng-model'=>'noticia.idioma_id', 'init-model'=>'noticia.idioma_id', '0' => 'Selecione']) !!}<br>
</div>

{!! Form::label('data', 'Data *') !!}<br>
{!! Form::date('data', null, ['class'=>"form-control width-medio <% validar(noticia.data) %>", 'ng-model'=>'noticia.data', 'init-model'=>'noticia.data', 'placeholder' => '']) !!}<br>


{!! Form::label('titulo', 'Título *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(noticia.titulo) %>", 'ng-model'=>'noticia.titulo', 'ng-required'=>'true', 'init-model'=>'noticia.titulo', 'placeholder' => '']) !!}<br>

{!! Form::label('resumida', 'Descrição resumida') !!}<br>
{!! Form::textarea('resumida', null, ['class'=>"form-control width-grande <% validar(noticia.resumida) %>", 'ng-model'=>'noticia.resumida',  'init-model'=>'noticia.resumida', 'placeholder' => '']) !!}<br>

<div style="display: none;">
{!! Form::label('slug', 'slug *') !!}<br>
{!! Form::text('slug', null, ['class'=>"form-control width-medio <% validar(noticia.slug) %>", 'ng-model'=>'noticia.slug', 'init-model'=>'noticia.slug', 'placeholder' => '']) !!}<br>
</div>
{!! Form::label('descricao', 'Descrição *') !!}<br>
{!! Form::textarea('descricao', null, ['class'=>"form-control width-grande <% validar(noticia.descricao) %>", 'ui-tinymce'=>'tinymceOptions', 'ng-model'=>'noticia.descricao', 'init-model'=>'noticia.descricao']) !!}<br>

