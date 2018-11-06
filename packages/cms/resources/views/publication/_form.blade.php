{{--<div style="display: none;">
{!! Form::label('idioma_id', 'Idioma *') !!}<br>
{!! Form::select('idioma_id',
        $idiomas,
null, ['class'=>"form-control width-medio <% validar(publication.idioma_id) %>", 'ng-model'=>'publication.idioma_id', 'init-model'=>'publication.idioma_id']) !!}<br>
</div>--}}
{{--
{!! Form::label('data', 'Data *') !!}<br>
{!! Form::date('data', null, ['class'=>"form-control width-medio <% validar(publication.data) %>", 'ng-model'=>'publication.data', 'ng-required'=>'true', 'init-model'=>'publication.data', 'placeholder' => '']) !!}<br>
--}}

<label for="data">Data</label><br>
<input type="date" name="data" class="form-control width-medio <% validar(publication.data) %>" ng-model="publication.data" ng-required="true" @if(!empty($publication))ng-init="publication.data=stringToDate('{{$publication->data}}')"@endif ><br>


{!! Form::label('titulo', 'Título *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(publication.titulo) %>", 'ng-model'=>'publication.titulo', 'ng-required'=>'true', 'init-model'=>'publication.titulo', 'placeholder' => '']) !!}<br>

{!! Form::label('resumida', 'Descrição resumida *') !!}<br>
{!! Form::textarea('resumida', null, ['class'=>"form-control width-grande <% validar(publication.resumida) %>", 'ng-model'=>'publication.resumida', 'ng-required'=>'true',  'init-model'=>'publication.resumida', 'placeholder' => '']) !!}<br>

{{--<div style="display: none;">
{!! Form::label('slug', 'slug *') !!}<br>
{!! Form::text('slug', null, ['class'=>"form-control width-medio <% validar(publication.slug) %>", 'ng-model'=>'publication.slug', 'init-model'=>'publication.slug', 'placeholder' => '']) !!}<br>
</div>--}}
{!! Form::label('descricao', 'Descrição *') !!}<br>
{!! Form::textarea('descricao', null, ['class'=>"form-control width-grande <% validar(publication.descricao) %>", 'ui-tinymce'=>'tinymceOptions', 'ng-required'=>'true', 'ng-model'=>'publication.descricao', 'init-model'=>'publication.descricao']) !!}<br>

