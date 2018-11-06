{{--<div style="display: none;">
{!! Form::label('idioma_id', 'Idioma *') !!}<br>
{!! Form::select('idioma_id',
        $idiomas,
null, ['class'=>"form-control width-medio <% validar(equipe.idioma_id) %>", 'ng-model'=>'equipe.idioma_id', 'init-model'=>'equipe.idioma_id']) !!}<br>
</div>--}}


{!! Form::label('titulo', 'Título *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(equipe.titulo) %>", 'ng-model'=>'equipe.titulo', 'ng-required'=>'true', 'init-model'=>'equipe.titulo', 'placeholder' => '']) !!}<br>

{!! Form::label('sub_titulo', 'Sub título *') !!}<br>
{!! Form::text('sub_titulo', null, ['class'=>"form-control width-grande <% validar(equipe.sub_titulo) %>", 'ng-model'=>'equipe.sub_titulo', 'ng-required'=>'true', 'init-model'=>'equipe.sub_titulo', 'placeholder' => '']) !!}<br>

{!! Form::label('descricao', 'Descrição *') !!}<br>
{!! Form::textarea('descricao', null, ['class'=>"form-control width-grande <% validar(equipe.descricao) %>", 'ui-tinymce'=>'tinymceOptions', 'ng-model'=>'equipe.descricao', 'init-model'=>'equipe.descricao']) !!}<br>

