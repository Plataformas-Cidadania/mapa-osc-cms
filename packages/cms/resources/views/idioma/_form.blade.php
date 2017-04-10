{{--É NECESSÁRIO RODAR O COMANDO composer require illuminate/html E ALTERAR ACRESCENTAR LINHA NO ARQUIVO config/app.php--}}



{!! Form::label('titulo', 'Título *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(idioma.titulo) %>", 'ng-model'=>'idioma.titulo', 'ng-required'=>'true', 'init-model'=>'idioma.titulo', 'placeholder' => '']) !!}<br>

{!! Form::label('sigla', 'Sigla *') !!}<br>
{!! Form::text('sigla', null, ['class'=>"form-control width-pequeno <% validar(idioma.sigla) %>", 'ng-model'=>'idioma.sigla', 'ng-required'=>'true', 'init-model'=>'idioma.sigla', 'placeholder' => '']) !!}<br>


