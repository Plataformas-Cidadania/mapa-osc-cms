{!! Form::label('titulo', 'Título *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(versao.titulo) %>", 'ng-model'=>'versao.titulo', 'ng-required'=>'true', 'init-model'=>'versao.titulo', 'placeholder' => '']) !!}<br>

{!! Form::label('descricao', 'Descrição *') !!}<br>
{!! Form::textarea('descricao', null, ['class'=>"form-control width-grande <% validar(versao.descricao) %>", 'ui-tinymce'=>'tinymceOptions', 'ng-model'=>'versao.descricao', 'init-model'=>'versao.descricao']) !!}<br>

