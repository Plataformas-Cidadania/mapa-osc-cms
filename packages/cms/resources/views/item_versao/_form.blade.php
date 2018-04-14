{{--É NECESSÁRIO RODAR O COMANDO composer require illuminate/html E ALTERAR ACRESCENTAR LINHA NO ARQUIVO config/app.php--}}
{!! Form::hidden('versao_id', $versao_id, ['ng-model'=>'item.versao_id', 'ng-required'=>'true', 'init-model'=>'item.versao_id', 'placeholder' => '']) !!}<br>

{!! Form::label('tipo_id', 'Tipo *') !!}<br>
{!! Form::select('tipo_id',
        array(
            '1' => 'Coordenador',
            '2' => 'Equipe técnica',
        ),
null, ['class'=>"form-control width-medio <% validar(item.tipo_id) %>", 'ng-model'=>'item.tipo_id', 'ng-required'=>'true', 'init-model'=>'item.tipo_id', 'placeholder' => '']) !!}<br>


{!! Form::label('titulo', 'Nome *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(item.titulo) %>", 'ng-model'=>'item.titulo', 'ng-required'=>'true', 'init-model'=>'item.titulo', 'placeholder' => '']) !!}<br>

{!! Form::label('url', 'Link *') !!}<br>
{!! Form::text('url', null, ['class'=>"form-control width-grande <% validar(item.url) %>", 'ng-model'=>'item.url', 'ng-required'=>'true', 'init-model'=>'item.url', 'placeholder' => '']) !!}<br>
