{!! Form::label('tipo_grafico', 'Tipo') !!}<br>
{!! Form::select('tipo_grafico',
        $tiposGraficos,
null, ['class'=>"form-control width-medio <% validar(grafico.tipo_grafico) %>", 'ng-model'=>'grafico.tipo_grafico', 'init-model'=>'grafico.tipo_grafico', 'placeholder' => 'Sem Tipo']) !!}<br>


{!! Form::label('slug', 'Slug *') !!}<br>
{!! Form::text('slug', null, ['class'=>"form-control width-grande <% validar(grafico.slug) %>", 'ng-model'=>'grafico.slug', 'ng-required'=>'true', 'init-model'=>'grafico.slug', 'placeholder' => '']) !!}<br>

{!! Form::label('titulo', 'Título *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(grafico.titulo) %>", 'ng-model'=>'grafico.titulo', 'ng-required'=>'true', 'init-model'=>'grafico.titulo', 'placeholder' => '']) !!}<br>

{!! Form::label('legenda', 'Legenda *') !!}<br>
{!! Form::text('legenda', null, ['class'=>"form-control width-grande <% validar(grafico.legenda) %>", 'ng-model'=>'grafico.legenda', 'ng-required'=>'true', 'init-model'=>'grafico.legenda', 'placeholder' => '']) !!}<br>

{!! Form::label('legenda_x', 'Legenda X *') !!}<br>
{!! Form::text('legenda_x', null, ['class'=>"form-control width-grande <% validar(grafico.legenda_x) %>", 'ng-model'=>'grafico.legenda_x', 'ng-required'=>'true', 'init-model'=>'grafico.legenda_x', 'placeholder' => '']) !!}<br>

{!! Form::label('legenda_y', 'Legenda Y *') !!}<br>
{!! Form::text('legenda_y', null, ['class'=>"form-control width-grande <% validar(grafico.legenda_y) %>", 'ng-model'=>'grafico.legenda_y', 'ng-required'=>'true', 'init-model'=>'grafico.legenda_y', 'placeholder' => '']) !!}<br>



{!! Form::label('configuracao', 'Configuração *') !!}<br>
{!! Form::text('configuracao', null, ['class'=>"form-control width-grande <% validar(grafico.configuracao) %>", 'ng-model'=>'grafico.configuracao', 'ng-required'=>'true', 'init-model'=>'grafico.configuracao', 'placeholder' => 'Ex.: f|1||f']) !!}<br>

{!! Form::label('titulo_colunas', 'Título Coluna*') !!}<br>
{!! Form::text('titulo_colunas', null, ['class'=>"form-control width-grande <% validar(grafico.titulo_colunas) %>", 'ng-model'=>'grafico.titulo_colunas', 'ng-required'=>'true', 'init-model'=>'grafico.titulo_colunas', 'placeholder' => 'Ex.: Número de Empregados|Região|Quantidade de OSCs']) !!}<br>


{{--
{!! Form::label('inverter_label', 'Inverter label *') !!}<br>
{!! Form::select('inverter_label',
        array(
            '1' => 'Verdadeiro',
            '0' => 'Falso',
        ),
null, ['class'=>"form-control width-medio <% validar(grafico.inverter_label) %>", 'ng-model'=>'grafico.inverter_label', 'ng-required'=>'true', 'init-model'=>'grafico.inverter_label', 'placeholder' => '']) !!}<br>
--}}

{!! Form::label('inverter_label', 'Inverter label *') !!}<br>
{!! Form::checkbox('inverter_label', true, null, ['class'=>"form-control width-medio <% validar(grafico.inverter_label) %>", 'ng-model'=>'grafico.inverter_label', 'init-model'=>'grafico.inverter_label', 'placeholder' => '', 'style' => 'height: 20px; width: 20px;']) !!}

<?php //print_r($grafico);?>

<br><br>