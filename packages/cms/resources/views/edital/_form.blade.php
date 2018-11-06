{!! Form::label('tx_orgao', 'Orgão *') !!}<br>
{!! Form::text('tx_orgao', null, ['class'=>"form-control width-grande <% validar(edital.tx_orgao) %>", 'ng-model'=>'edital.tx_orgao', 'ng-required'=>'true', 'init-model'=>'edital.tx_orgao', 'placeholder' => '']) !!}<br>

{!! Form::label('tx_programa', 'Programa *') !!}<br>
{!! Form::text('tx_programa', null, ['class'=>"form-control width-grande <% validar(edital.tx_programa) %>", 'ng-model'=>'edital.tx_programa', 'ng-required'=>'true', 'init-model'=>'edital.tx_programa', 'placeholder' => '']) !!}<br>

{!! Form::label('tx_area_interesse_edital', 'Área interesse *') !!}<br>
{!! Form::text('tx_area_interesse_edital', null, ['class'=>"form-control width-grande <% validar(edital.tx_area_interesse_edital) %>", 'ng-model'=>'edital.tx_area_interesse_edital', 'ng-required'=>'true', 'init-model'=>'edital.tx_area_interesse_edital', 'placeholder' => '']) !!}<br>

{{--
{!! Form::label('dt_vencimento', 'Vencimento *') !!}<br>
{!! Form::date('dt_vencimento', null, ['class'=>"form-control width-grande <% validar(edital.dt_vencimento) %>", 'ng-model'=>'edital.dt_vencimento', 'ng-required'=>'true', 'init-model'=>'edital.dt_vencimento', 'placeholder' => '']) !!}<br>
--}}
<label for="dt_vencimento">Vencimento *</label><br>
<input type="date" name="dt_vencimento" class="form-control width-medio <% validar(edital.dt_vencimento) %>" ng-model="edital.dt_vencimento" ng-required="true" @if(!empty($edital))ng-init="edital.dt_vencimento=stringToDate('{{$edital->dt_vencimento}}')"@endif ><br>


{!! Form::label('tx_link_edital', 'Link *') !!}<br>
{!! Form::text('tx_link_edital', null, ['class'=>"form-control width-grande <% validar(edital.tx_link_edital) %>", 'ng-model'=>'edital.tx_link_edital', 'ng-required'=>'true', 'init-model'=>'edital.tx_link_edital', 'placeholder' => '']) !!}<br>

{!! Form::label('tx_numero_chamada', 'Número Chamada *') !!}<br>
{!! Form::text('tx_numero_chamada', null, ['class'=>"form-control width-grande <% validar(edital.tx_numero_chamada) %>", 'ng-model'=>'edital.tx_numero_chamada', 'ng-required'=>'true', 'init-model'=>'edital.tx_numero_chamada', 'placeholder' => '']) !!}<br>


{{--{!! Form::label('titulo', 'Nome do Programa *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(edital.titulo) %>", 'ng-model'=>'edital.titulo', 'ng-required'=>'true', 'init-model'=>'edital.titulo', 'placeholder' => '']) !!}<br>

{!! Form::label('instituicao', 'Instituição ') !!}<br>
{!! Form::text('instituicao', null, ['class'=>"form-control width-grande <% validar(edital.instituicao) %>", 'ng-model'=>'edital.instituicao', 'init-model'=>'edital.instituicao', 'placeholder' => '']) !!}<br>

{!! Form::label('area', 'Área') !!}<br>
{!! Form::text('area', null, ['class'=>"form-control width-grande <% validar(edital.area) %>", 'ng-model'=>'edital.area', 'init-model'=>'edital.area', 'placeholder' => '']) !!}<br>

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
null, ['class'=>"form-control width-medio <% validar(edital.status) %>", 'ng-model'=>'edital.status', 'ng-required'=>'true', 'init-model'=>'edital.status', 'placeholder' => '']) !!}<br>--}}
