{{--É NECESSÁRIO RODAR O COMANDO composer require illuminate/html E ALTERAR ACRESCENTAR LINHA NO ARQUIVO config/app.php--}}
{!! Form::hidden('versao_id', $versao_id, ['ng-model'=>'item.versao_id', 'ng-required'=>'true', 'init-model'=>'item.versao_id', 'placeholder' => '']) !!}<br>

{!! Form::label('tipo_id', 'Tipo *') !!}<br>
{!! Form::select('tipo_id',
        array(
            '1' => 'Coordenador',
            '3' => 'Coordenador Equipe',
            '2' => 'Equipe técnica',
        ),
null, ['class'=>"form-control width-medio <% validar(item.tipo_id) %>", 'ng-model'=>'item.tipo_id', 'ng-required'=>'true', 'init-model'=>'item.tipo_id', 'placeholder' => '']) !!}<br>


{!! Form::label('integrante_id', 'Integrante') !!}<br>
{!! Form::select('integrante_id',
        $integrantes,
null, ['class'=>"form-control width-medio <% validar(item.integrante_id) %>", 'ng-model'=>'item.integrante_id', 'init-model'=>'item.integrante_id', 'placeholder' => 'Sem um Integrante']) !!}<br>
