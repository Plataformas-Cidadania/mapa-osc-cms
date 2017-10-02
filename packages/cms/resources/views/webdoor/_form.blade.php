{!! Form::label('titulo', 'Título *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(webdoor.titulo) %>", 'ng-model'=>'webdoor.titulo', 'ng-required'=>'true', 'init-model'=>'webdoor.titulo', 'placeholder' => '']) !!}<br>

{!! Form::label('descricao', 'Descrição') !!}<br>
{!! Form::textarea('descricao', null, ['class'=>"form-control width-grande <% validar(webdoor.descricao) %>", 'ui-tinymce'=>'tinymceOptions', 'ng-model'=>'webdoor.descricao', 'init-model'=>'webdoor.descricao']) !!}<br>

{!! Form::label('link', 'Link ') !!}<br>
{!! Form::text('link', null, ['class'=>"form-control width-grande <% validar(webdoor.link) %>", 'ng-model'=>'webdoor.link', 'init-model'=>'webdoor.link', 'placeholder' => '']) !!}<br>




