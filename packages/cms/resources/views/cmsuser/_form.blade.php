{{--É NECESSÁRIO RODAR O COMANDO composer require illuminate/html E ALTERAR ACRESCENTAR LINHA NO ARQUIVO config/app.php--}}

{!! Form::label('name', 'Nome *') !!}<br>
{!! Form::text('name', null, ['class'=>"form-control width-grande <% validar(cmsuser.name) %>", 'ng-model'=>'cmsuser.name', 'ng-required'=>'true', 'init-model'=>'cmsuser.name', 'placeholder' => '']) !!}<br>

{!! Form::label('email', 'E-mail *') !!}<br>
{!! Form::text('email', null, ['class'=>"form-control width-grande <% validar(cmsuser.email) %>", 'ng-model'=>'cmsuser.email', 'ng-required'=>'true', 'init-model'=>'cmsuser.email']) !!}<br>




