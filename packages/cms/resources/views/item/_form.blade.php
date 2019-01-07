{{--É NECESSÁRIO RODAR O COMANDO composer require illuminate/html E ALTERAR ACRESCENTAR LINHA NO ARQUIVO config/app.php--}}
{!! Form::hidden('modulo_id', $modulo_id, ['ng-model'=>'item.modulo_id', 'ng-required'=>'true', 'init-model'=>'item.modulo_id', 'placeholder' => '']) !!}<br>

{{--
{!! Form::label('idioma_id', 'Idioma *') !!}<br>
{!! Form::select('idioma_id',
        $idiomas,
null, ['class'=>"form-control width-medio <% validar(item.idioma_id) %>", 'ng-model'=>'item.idioma_id', 'ng-required'=>'true', 'init-model'=>'item.idioma_id', 'placeholder' => 'Selecione']) !!}<br>
--}}

{!! Form::label('titulo', 'Título *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(item.titulo) %>", 'ng-model'=>'item.titulo', 'ng-required'=>'true', 'init-model'=>'item.titulo', 'placeholder' => '']) !!}<br>

{!! Form::label('descricao', 'Descrição *') !!}<br>
{!! Form::textarea('descricao', null, ['class'=>"form-control width-grande <% validar(item.descricao) %>", 'ui-tinymce'=>'tinymceOptions', 'ng-model'=>'item.descricao', 'init-model'=>'item.descricao']) !!}<br>

{!! Form::label('posicao', 'Posição ') !!}<br>
{!! Form::text('posicao', null, ['class'=>"form-control width-grande <% validar(item.posicao) %>", 'ng-required'=>'true', 'ng-model'=>'item.posicao',  'init-model'=>'item.posicao', 'placeholder' => '']) !!}<br>


