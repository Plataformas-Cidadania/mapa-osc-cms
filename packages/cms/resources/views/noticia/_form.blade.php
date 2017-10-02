{{--<div style="display: none;">
{!! Form::label('idioma_id', 'Idioma *') !!}<br>
{!! Form::select('idioma_id',
        $idiomas,
null, ['class'=>"form-control width-medio <% validar(noticia.idioma_id) %>", 'ng-model'=>'noticia.idioma_id', 'init-model'=>'noticia.idioma_id']) !!}<br>
</div>--}}
{{--
{!! Form::label('data', 'Data *') !!}<br>
{!! Form::date('data', null, ['class'=>"form-control width-medio <% validar(noticia.data) %>", 'ng-model'=>'noticia.data', 'ng-required'=>'true', 'init-model'=>'noticia.data', 'placeholder' => '']) !!}<br>
--}}

<label for="data">Data</label><br>
<input type="date" name="data" class="form-control width-medio <% validar(noticia.data) %>" ng-model="noticia.data" ng-required="true" @if(!empty($noticia))ng-init="noticia.data=stringToDate('{{$noticia->data}}')"@endif ><br>


{!! Form::label('titulo', 'Título *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(noticia.titulo) %>", 'ng-model'=>'noticia.titulo', 'ng-required'=>'true', 'init-model'=>'noticia.titulo', 'placeholder' => '']) !!}<br>

{!! Form::label('resumida', 'Descrição resumida *') !!}<br>
{!! Form::textarea('resumida', null, ['class'=>"form-control width-grande <% validar(noticia.resumida) %>", 'ng-model'=>'noticia.resumida', 'ng-required'=>'true',  'init-model'=>'noticia.resumida', 'placeholder' => '']) !!}<br>

{{--<div style="display: none;">
{!! Form::label('slug', 'slug *') !!}<br>
{!! Form::text('slug', null, ['class'=>"form-control width-medio <% validar(noticia.slug) %>", 'ng-model'=>'noticia.slug', 'init-model'=>'noticia.slug', 'placeholder' => '']) !!}<br>
</div>--}}
{!! Form::label('descricao', 'Descrição *') !!}<br>
{!! Form::textarea('descricao', null, ['class'=>"form-control width-grande <% validar(noticia.descricao) %>", 'ui-tinymce'=>'tinymceOptions', 'ng-required'=>'true', 'ng-model'=>'noticia.descricao', 'init-model'=>'noticia.descricao']) !!}<br>

