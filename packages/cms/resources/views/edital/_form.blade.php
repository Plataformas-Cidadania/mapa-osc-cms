{!! Form::label('titulo', 'Nome do Programa *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(edital.titulo) %>", 'ng-model'=>'edital.titulo', 'ng-required'=>'true', 'init-model'=>'edital.titulo', 'placeholder' => '']) !!}<br>

{!! Form::label('instituicao', 'Instituição ') !!}<br>
{!! Form::text('instituicao', null, ['class'=>"form-control width-grande <% validar(edital.instituicao) %>", 'ng-model'=>'edital.instituicao', 'init-model'=>'edital.instituicao', 'placeholder' => '']) !!}<br>

{!! Form::label('area', 'Área') !!}<br>
{!! Form::text('area', null, ['class'=>"form-control width-grande <% validar(edital.area) %>", 'ng-model'=>'edital.area', 'init-model'=>'edital.area', 'placeholder' => '']) !!}<br>

{{--
{!! Form::label('data_vencimento', 'Data vencimento *') !!}<br>
{!! Form::date('data_vencimento', null, ['class'=>"form-control width-medio <% validar(edital.data_vencimento) %>", 'ng-model'=>'edital.data_vencimento', 'ng-required'=>'true', 'init-model'=>'edital.data_vencimento', 'placeholder' => '']) !!}<br>
--}}

<label for="data_vencimento">Data de Vencimento</label><br>
<input type="date" name="data_vencimento" class="form-control width-medio <% validar(edital.data_vencimento) %>" ng-model="edital.data_vencimento" ng-required="true" @if(!empty($edital))ng-init="edital.data_vencimento=stringToDate('{{$edital->data_vencimento}}')"@endif ><br>

{!! Form::label('numero_chamada', 'Número da chamada') !!}<br>
{!! Form::text('numero_chamada', null, ['class'=>"form-control width-grande <% validar(edital.numero_chamada) %>", 'ng-model'=>'edital.numero_chamada', 'init-model'=>'edital.numero_chamada', 'placeholder' => '']) !!}<br>

{!! Form::label('edital', 'Edital ') !!}<br>
{!! Form::text('edital', null, ['class'=>"form-control width-grande <% validar(edital.edital) %>", 'ng-model'=>'edital.edital', 'init-model'=>'edital.edital', 'placeholder' => '']) !!}<br>

{!! Form::label('status', 'Status *') !!}<br>
{!! Form::select('status',
        array(
            '1' => 'Em andamento',
            '2' => 'Encerrado'
        ),
null, ['class'=>"form-control width-medio <% validar(edital.status) %>", 'ng-model'=>'edital.status', 'ng-required'=>'true', 'init-model'=>'edital.status', 'placeholder' => '']) !!}<br>
