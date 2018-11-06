{!! Form::label('titulo', 'Nome *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(integrante.titulo) %>", 'ng-model'=>'integrante.titulo', 'ng-required'=>'true', 'init-model'=>'integrante.titulo', 'placeholder' => '']) !!}<br>

{!! Form::label('url', 'Link *') !!}<br>
{!! Form::text('url', null, ['class'=>"form-control width-grande <% validar(integrante.url) %>", 'ng-model'=>'integrante.url',  'init-model'=>'integrante.url', 'placeholder' => '']) !!}<br>
