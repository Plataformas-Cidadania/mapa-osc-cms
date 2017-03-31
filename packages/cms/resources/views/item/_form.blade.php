{{--É NECESSÁRIO RODAR O COMANDO composer require illuminate/html E ALTERAR ACRESCENTAR LINHA NO ARQUIVO config/app.php--}}
{!! Form::label('origem_id', 'Origem *') !!}<br>
{!! Form::select('origem_id',
        $series,
null, ['class'=>"form-control width-medio <% validar(item.origem_id) %>", 'ng-model'=>'item.origem_id', 'ng-required'=>'true', 'init-model'=>'item.origem_id', 'placeholder' => 'Selecione']) !!}<br>

{!! Form::label('titulo', 'Título *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(item.titulo) %>", 'ng-model'=>'item.titulo', 'ng-required'=>'true', 'init-model'=>'item.titulo', 'placeholder' => '']) !!}<br>

{!! Form::label('descricao', 'Descrição *') !!}<br>
{!! Form::textarea('descricao', null, ['class'=>"form-control width-grande <% validar(item.descricao) %>", 'ui-tinymce'=>'tinymceOptions', 'ng-model'=>'item.descricao', 'init-model'=>'item.descricao']) !!}<br>

