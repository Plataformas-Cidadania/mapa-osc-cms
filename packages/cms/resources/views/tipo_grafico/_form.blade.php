{{--{!! Form::label('titulo', 'Título *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(tipoGrafico.titulo) %>", 'ng-model'=>'tipoGrafico.titulo', 'ng-required'=>'true', 'init-model'=>'tipoGrafico.titulo', 'placeholder' => '']) !!}<br>--}}

{!! Form::label('nome_tipo_grafico', 'Título *') !!}<br>
{!! Form::text('nome_tipo_grafico', null, ['class'=>"form-control width-grande <% validar(tipoGrafico.nome_tipo_grafico) %>", 'ng-model'=>'tipoGrafico.nome_tipo_grafico', 'ng-required'=>'true', 'init-model'=>'tipoGrafico.nome_tipo_grafico', 'placeholder' => '']) !!}<br>
