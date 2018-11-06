{{--<div style="display: block;">
{!! Form::label('idioma_id', 'Idioma *') !!}<br>
{!! Form::select('idioma_id',
        $idiomas,
null, ['class'=>"form-control width-medio <% validar(video.idioma_id) %>", 'ng-model'=>'video.idioma_id', 'init-model'=>'video.idioma_id', '0' => 'Selecione']) !!}<br>

</div>--}}
{{--
{!! Form::label('data', 'Data *') !!}<br>
{!! Form::date('data', null, ['class'=>"form-control width-medio <% validar(video.data) %>", 'ng-model'=>'video.data',  'init-model'=>'video.data', 'ng-required'=>'true', 'placeholder' => '']) !!}<br>
--}}

<label for="data">Data</label><br>
<input type="date" name="data" class="form-control width-medio <% validar(video.data) %>" ng-model="video.data" ng-required="true" @if(!empty($video))ng-init="video.data=stringToDate('{{$video->data}}')"@endif ><br>


{!! Form::label('titulo', 'Título *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(video.titulo) %>", 'ng-model'=>'video.titulo', 'ng-required'=>'true', 'init-model'=>'video.titulo', 'placeholder' => '']) !!}<br>

{!! Form::label('link_video', 'Video (link do youtube)') !!}<br>
{!! Form::text('link_video', null, ['class'=>"form-control width-grande <% validar(video.link_video) %>", 'ng-model'=>'video.link_video', 'ng-required'=>'true', 'init-model'=>'video.link_video', 'placeholder' => '']) !!}<br>


{!! Form::label('resumida', 'Descrição Resumida *') !!}<br>
{!! Form::textarea('resumida', null, ['class'=>"form-control width-grande <% validar(video.resumida) %>", 'ng-model'=>'video.resumida', 'ng-required'=>'true', 'init-model'=>'video.resumida', 'placeholder' => '']) !!}<br>


{!! Form::label('descricao', 'Descrição *') !!}<br>
{!! Form::textarea('descricao', null, ['class'=>"form-control width-grande <% validar(video.descricao) %>", 'ui-tinymce'=>'tinymceOptions', 'ng-required'=>'true', 'ng-model'=>'video.descricao', 'init-model'=>'video.descricao']) !!}<br>


