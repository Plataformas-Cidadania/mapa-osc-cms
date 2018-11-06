{{--{!! Form::label('idioma_id', 'Idioma *') !!}<br>
{!! Form::select('idioma_id',
        $idiomas,
null, ['class'=>"form-control width-medio <% validar(modulo.idioma_id) %>", 'ng-model'=>'modulo.idioma_id', 'ng-required'=>'true', 'init-model'=>'modulo.idioma_id', 'placeholder' => 'Selecione']) !!}<br>--}}
{!! Form::label('tipo_id', 'Tipo') !!}<br>
{!! Form::select('tipo_id',
        $tipos,
null, ['class'=>"form-control width-medio <% validar(modulo.tipo_id) %>", 'ng-model'=>'modulo.tipo_id', 'init-model'=>'modulo.tipo_id', 'placeholder' => 'Sem Tipo']) !!}<br>


{!! Form::label('titulo', 'Título *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(modulo.titulo) %>", 'ng-model'=>'modulo.titulo', 'ng-required'=>'true', 'init-model'=>'modulo.titulo', 'placeholder' => '']) !!}<br>

{!! Form::label('slug', 'slug *') !!}<br>
{!! Form::text('slug', null, ['class'=>"form-control width-medio <% validar(modulo.slug) %>", 'ng-model'=>'modulo.slug', 'ng-required'=>'true', 'init-model'=>'modulo.slug', 'placeholder' => '']) !!}<br>

{!! Form::label('descricao', 'Descrição *') !!}<br>
{!! Form::textarea('descricao', null, ['class'=>"form-control width-grande <% validar(modulo.descricao) %>", 'ui-tinymce'=>'tinymceOptions', 'ng-model'=>'modulo.descricao', 'init-model'=>'modulo.descricao']) !!}<br>

