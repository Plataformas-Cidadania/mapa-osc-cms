{{--É NECESSÁRIO RODAR O COMANDO composer require illuminate/html E ALTERAR ACRESCENTAR LINHA NO ARQUIVO config/app.php--}}

{!! Form::label('titulo', 'Título *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(webdoor.titulo) %>", 'ng-model'=>'webdoor.titulo', 'ng-required'=>'true', 'init-model'=>'webdoor.titulo', 'placeholder' => '']) !!}<br>


{!! Form::label('resumida', 'Resumo ') !!}<br>
{!! Form::text('resumida', null, ['class'=>"form-control width-grande  <% validar(webdoor.resumida) %>", 'style'=>'float: left;', 'ng-model'=>'webdoor.resumida',  'init-model'=>'webdoor.resumida', 'placeholder' => '']) !!}&nbsp;
<button type="button" class="btn btn-info " data-container="body" data-toggle="popover" data-placement="top" data-content="Para aparecer o título e resumo na imagem do webdoor é preciso cadastra um resumo.">
    <i class="fa fa-info-circle" aria-hidden="true"></i>
</button>
<br><br>
{!! Form::label('descricao', 'Descrição') !!}<br>
{!! Form::textarea('descricao', null, ['class'=>"form-control width-grande <% validar(webdoor.descricao) %>", 'ui-tinymce'=>'tinymceOptions', 'ng-model'=>'webdoor.descricao', 'init-model'=>'webdoor.descricao']) !!}<br>

{!! Form::label('link', 'Link ') !!}<br>
{!! Form::text('link', null, ['class'=>"form-control width-grande <% validar(webdoor.link) %>", 'ng-model'=>'webdoor.link', 'init-model'=>'webdoor.link', 'placeholder' => '']) !!}<br>




