{!! Form::label('titulo', 'Título *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(tipoGrafico.titulo) %>", 'ng-model'=>'tipoGrafico.titulo', 'ng-required'=>'true', 'init-model'=>'tipoGrafico.titulo', 'placeholder' => '']) !!}<br>
