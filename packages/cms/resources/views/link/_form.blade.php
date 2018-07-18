{{--<div style="display: none;">
{!! Form::label('idioma_id', 'Idioma *') !!}<br>
{!! Form::select('idioma_id',
        $idiomas,
null, ['class'=>"form-control width-medio <% validar(link.idioma_id) %>", 'ng-model'=>'link.idioma_id', 'init-model'=>'link.idioma_id']) !!}<br>
</div>--}}


{!! Form::label('titulo', 'Título *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(link.titulo) %>", 'ng-model'=>'link.titulo', 'ng-required'=>'true', 'init-model'=>'link.titulo', 'placeholder' => '']) !!}<br>

{!! Form::label('descricao', 'Descrição') !!}<br>
{!! Form::textarea('descricao', null, ['class'=>"form-control width-grande <% validar(link.descricao) %>", 'ui-tinymce'=>'tinymceOptions', 'ng-model'=>'link.descricao', 'init-model'=>'link.descricao']) !!}<br>

{!! Form::label('url', 'Link*') !!}<br>
{!! Form::text('url', null, ['class'=>"form-control width-grande <% validar(link.url) %>", 'ng-model'=>'link.url', 'ng-required'=>'true',  'init-model'=>'link.url', 'placeholder' => '']) !!}<br>

{!! Form::label('posicao', 'Posição *') !!}<br>
{!! Form::text('posicao', null, ['class'=>"form-control width-pequeno <% validar(link.posicao) %>", 'ng-model'=>'link.posicao', 'ng-required'=>'true', 'init-model'=>'link.posicao', 'placeholder' => '']) !!}<br>
