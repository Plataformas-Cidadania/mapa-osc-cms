{!! Form::label('titulo', 'Título *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(tipo.titulo) %>", 'ng-model'=>'tipo.titulo', 'ng-required'=>'true', 'init-model'=>'tipo.titulo', 'placeholder' => '']) !!}<br>
