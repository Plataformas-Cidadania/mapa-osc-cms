{{--<div style="display: none;">
{!! Form::label('idioma_id', 'Idioma *') !!}<br>
{!! Form::select('idioma_id',
        $idiomas,
null, ['class'=>"form-control width-medio <% validar(analise.idioma_id) %>", 'ng-model'=>'analise.idioma_id', 'init-model'=>'analise.idioma_id']) !!}<br>
</div>--}}
{{--
{!! Form::label('data', 'Data *') !!}<br>
{!! Form::date('data', null, ['class'=>"form-control width-medio <% validar(analise.data) %>", 'ng-model'=>'analise.data', 'ng-required'=>'true', 'init-model'=>'analise.data', 'placeholder' => '']) !!}<br>
--}}

<label for="data">Data</label><br>
<input type="date" name="data" class="form-control width-medio <% validar(analise.data) %>" ng-model="analise.data" ng-required="true" @if(!empty($analise))ng-init="analise.data=stringToDate('{{$analise->data}}')"@endif ><br>


{!! Form::label('titulo', 'Título *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(analise.titulo) %>", 'ng-model'=>'analise.titulo', 'ng-required'=>'true', 'init-model'=>'analise.titulo', 'placeholder' => '']) !!}<br>

{!! Form::label('resumida', 'Descrição resumida *') !!}<br>
{!! Form::textarea('resumida', null, ['class'=>"form-control width-grande <% validar(analise.resumida) %>", 'ng-model'=>'analise.resumida', 'ng-required'=>'true',  'init-model'=>'analise.resumida', 'placeholder' => '']) !!}<br>

{{--<div style="display: none;">
{!! Form::label('slug', 'slug *') !!}<br>
{!! Form::text('slug', null, ['class'=>"form-control width-medio <% validar(analise.slug) %>", 'ng-model'=>'analise.slug', 'init-model'=>'analise.slug', 'placeholder' => '']) !!}<br>
</div>--}}
{!! Form::label('descricao', 'Descrição *') !!}<br>
{!! Form::textarea('descricao', null, ['class'=>"form-control width-grande <% validar(analise.descricao) %>", 'ui-tinymce'=>'tinymceOptions', 'ng-required'=>'true', 'ng-model'=>'analise.descricao', 'init-model'=>'analise.descricao']) !!}<br>

