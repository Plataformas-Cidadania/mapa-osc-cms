{!! Form::label('titulo', 'Título *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(webdoor.titulo) %>", 'ng-model'=>'webdoor.titulo', 'ng-required'=>'true', 'init-model'=>'webdoor.titulo', 'placeholder' => '']) !!}<br>

{!! Form::label('descricao', 'Descrição') !!}<br>
{!! Form::textarea('descricao', null, ['class'=>"form-control width-grande <% validar(webdoor.descricao) %>", 'ui-tinymce'=>'tinymceOptions', 'ng-model'=>'webdoor.descricao', 'init-model'=>'webdoor.descricao']) !!}<br>

{!! Form::label('legenda', 'Legenda') !!}<br>
{!! Form::text('legenda', null, ['class'=>"form-control width-grande <% validar(webdoor.legenda) %>", 'ng-model'=>'webdoor.legenda', 'init-model'=>'webdoor.legenda', 'placeholder' => '']) !!}<br>

{!! Form::label('link', 'Link ') !!}<br>
{!! Form::text('link', null, ['class'=>"form-control width-grande <% validar(webdoor.link) %>", 'ng-model'=>'webdoor.link', 'init-model'=>'webdoor.link', 'placeholder' => '']) !!}<br>

{!! Form::label('posicao', 'Posição ') !!}<br>
{!! Form::text('posicao', null, ['class'=>"form-control width-pequeno <% validar(webdoor.posicao) %>", 'ng-model'=>'webdoor.posicao', 'init-model'=>'webdoor.posicao', 'placeholder' => '']) !!}<br>




