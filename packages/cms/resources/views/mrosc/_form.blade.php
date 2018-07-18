{{--É NECESSÁRIO RODAR O COMANDO composer require illuminate/html E ALTERAR ACRESCENTAR LINHA NO ARQUIVO config/app.php--}}




{{--{!! Form::label('idioma_id', 'Idioma *') !!}<br>
{!! Form::select('idioma_id',
        $idiomas,
null, ['class'=>"form-control width-medio <% validar(mrosc.idioma_id) %>", 'ng-model'=>'mrosc.idioma_id', 'ng-required'=>'true', 'init-model'=>'mrosc.idioma_id', 'placeholder' => 'Selecione']) !!}<br>--}}

{!! Form::label('titulo', 'Título *') !!}<br>
{!! Form::text('titulo', null, ['class'=>"form-control width-grande <% validar(mrosc.titulo) %>", 'ng-model'=>'mrosc.titulo', 'ng-required'=>'true', 'init-model'=>'mrosc.titulo', 'placeholder' => '']) !!}<br>

{!! Form::label('subtitulo', 'Sub título *') !!}<br>
{!! Form::text('subtitulo', null, ['class'=>"form-control width-grande <% validar(mrosc.subtitulo) %>", 'ng-model'=>'mrosc.subtitulo', 'init-model'=>'mrosc.subtitulo', 'placeholder' => '']) !!}<br>

{{--{!! Form::label('slug', 'slug *') !!}<br>
{!! Form::text('slug', null, ['class'=>"form-control width-medio <% validar(mrosc.slug) %>", 'ng-model'=>'mrosc.slug', 'ng-required'=>'true', 'init-model'=>'mrosc.slug', 'placeholder' => '']) !!}<br>--}}



<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalImagem" style="float: right; margin: 5px;">
    Exibir imagens
</button>
<!-- Button trigger modal -->

<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModaArquivo" style="float: right; margin: 5px;">
    Exibir arquivos
</button>
<div style="float: right; margin: 5px; padding-top: 10px;">Imagens e arquivos adicionados no componente a baixo fica listado nesse dois botões</div>
<br><br>


{!! Form::label('descricao', 'Descrição *') !!}<br>
{!! Form::textarea('descricao', null, ['class'=>"form-control width-grande <% validar(mrosc.descricao) %>", 'ui-tinymce'=>'tinymceOptions', 'ng-model'=>'mrosc.descricao', 'init-model'=>'mrosc.descricao']) !!}<br>


{!! Form::label('posicao', 'Posição *') !!}<br>
{!! Form::text('posicao', null, ['class'=>"form-control width-pequeno <% validar(mrosc.posicao) %>", 'ng-model'=>'mrosc.posicao', 'ng-required'=>'true', 'init-model'=>'mrosc.posicao', 'placeholder' => '']) !!}<br>

<!-- Modal -->
<div class="modal fade" id="myModalImagem" tabindex="-1" role="dialog" aria-labelledby="myModalLabelImagem">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabelImagem">Banco de Imagens</h4>
            </div>
            <div class="modal-body">
                <?php
                $types = array( 'png', 'jpg', 'jpeg', 'gif' );
                if ( $handle = opendir('../public/imagens/geral') ) {
                    while ( $entry = readdir( $handle ) ) {
                        $ext = strtolower( pathinfo( $entry, PATHINFO_EXTENSION) );
                        echo "<div class='col-md-4'>";
                            if( in_array( $ext, $types ) ) echo "<img src='imagens/geral/".$entry."' width='100%'><br>";
                            if( in_array( $ext, $types ) ) echo "<input type='text' value='imagens/geral/".$entry."' style='width: 100%;'><br><br>";
                        echo "</div>";
                    }
                    closedir($handle);
                }
                ?>
            </div>
            <div style="clear: both;"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModaArquivo" tabindex="-1" role="dialog" aria-labelledby="myModalLabelArquivo">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabelArquivo">Banco de arquivos</h4>
            </div>
            <div class="modal-body">
                <?php
                $types = array( 'pdf', 'doc', 'docx' );
                if ( $handle = opendir('../public/imagens/geral') ) {
                    while ( $entry = readdir( $handle ) ) {
                        $ext = strtolower( pathinfo( $entry, PATHINFO_EXTENSION) );
                        echo "<div class='col-md-6'>";
                        if( in_array( $ext, $types ) ) echo "<iframe  src='imagens/geral/".$entry."' width='100%'></iframe> <br>";
                        if( in_array( $ext, $types ) ) echo "<input type='text' value='".$entry."' style='width: 100%;'><br><br>";
                        echo "</div>";
                    }
                    closedir($handle);
                }
                ?>
            </div>
            <div style="clear: both;"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>