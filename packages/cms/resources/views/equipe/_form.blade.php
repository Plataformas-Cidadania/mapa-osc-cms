{{--<div style="display: none;">
{!! Form::label('idioma_id', 'Idioma *') !!}<br>
{!! Form::select('idioma_id',
        $idiomas,
null, ['class'=>"form-control width-medio <% validar(equipe.idioma_id) %>", 'ng-model'=>'equipe.idioma_id', 'init-model'=>'equipe.idioma_id']) !!}<br>
</div>--}}
{!! Form::label('tipo_id', 'Tipo *') !!}<br>
{!! Form::select('tipo_id',
        array(
            '1' => 'Coordenador',
            '2' => 'Equipe técnica',
        ),
null, ['class'=>"form-control width-medio <% validar(equipe.tipo_id) %>", 'ng-model'=>'equipe.tipo_id', 'ng-required'=>'true', 'init-model'=>'equipe.tipo_id', 'placeholder' => '']) !!}<br>



{!! Form::label('titulo', 'Título *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(equipe.titulo) %>", 'ng-model'=>'equipe.titulo', 'ng-required'=>'true', 'init-model'=>'equipe.titulo', 'placeholder' => '']) !!}<br>

{!! Form::label('url', 'Descrição url *') !!}<br>
{!! Form::text('url', null, ['class'=>"form-control width-grande <% validar(equipe.url) %>", 'ng-model'=>'equipe.url',  'init-model'=>'equipe.url', 'placeholder' => '']) !!}<br>
