@extends('cms::layouts.app')

@section('content')
    {!! Html::script('assets-cms/js/controllers/itemVersaoCtrl.js') !!}
<script>
    $(function () {
        $('[data-toggle="popover"]').popover()
    })
</script>
    <div ng-controller="itemVersaoCtrl">
        <div class="box-padrao">
            <h1><a href="javascript:history.back();"><i class="fa fa-arrow-circle-left"></i></a>&nbsp;Items versão</h1>
            <button class="btn btn-primary" ng-click="mostrarForm=!mostrarForm" ng-show="!mostrarForm">Novo Item</button>
            <button class="btn btn-warning" ng-click="mostrarForm=!mostrarForm" ng-show="mostrarForm">Cancelar</button>
            <br><br>
            <div ng-show="mostrarForm">
                <span class="texto-obrigatorio" ng-show="form.$invalid">* campos obrigatórios</span><br><br>
                {!! Form::open(['name' =>'form']) !!}
                <div  style="display: none;">
                <div class="container-thumb">
                    <div class="box-thumb" name="fileDrop" ngf-drag-over-class="'box-thumb-hover'" ngf-drop ngf-select ng-model="picFile"
                         ng-show="!picFile" accept="image/*" ngf-max-size="2MB">Solte uma imagem aqui!</div>
                    <img  ngf-thumbnail="picFile" class="thumb">
                </div>
                <br>
                <span class="btn btn-primary btn-file" ng-show="!picFile">
                    Escolher imagem <input  type="file" ngf-select ng-model="picFile" name="file" accept="image/*" ngf-max-size="2MB" ngf-model-invalid="errorFile">
                </span>
                <button class="btn btn-danger" ng-click="picFile = null" ng-show="picFile" type="button">Remover Imagem</button>
                <i ng-show="form.file.$error.maxSize || form.fileDrop.$error.maxSize" style="margin-left: 10px;">
                    Arquivo muito grande <% errorFile.size / 1000000|number:1 %>MB: máximo 2MB
                    <div class="btn btn-danger" ng-click="limparImagem()">Cancelar</div>
                </i>
                    <br><br>
                </div>


            <div style="display: none;">
                <span class="btn btn-primary btn-file" ng-show="!fileArquivo" >
                    Escolher Arquivo <input  type="file" ngf-select ng-model="fileArquivo" name="fileArquivo" accept="application/pdf,.zip,.rar,.doc,.docx,.xlsx,.xls" ngf-max-size="100MB" ngf-model-invalid="errorFile">
                </span>
                <a ng-show="fileArquivo"><% fileArquivo.name %></a>
                <br><br>
            </div>

                @include('cms::item_versao._form')
                <div class="row">
                    <div class="col-md-1 col-lg-1 col-xs-3">
                        <button class="btn btn-info" type="button" ng-click="inserir(picFile, fileArquivo)" ng-disabled="form.$invalid">Salvar</button>
                    </div>
                    <div class="col-md-2 col-lg-2 col-xs-6">
                        <span class="progress" ng-show="picFile.progress >= 0">
                            <div style="width: <% picFile.progress %>%" ng-bind="picFile.progress + '%'"></div>
                        </span>
                        <div ng-show="processandoInserir"><i class="fa fa-spinner fa-spin"></i> Processando...</div>
                        <div><% mensagemInserir %></div>
                        <span ng-show="picFile.result">{{--Upload Successful--}}</span>
                        <span class="err" ng-show="errorMsg"><% errorMsg %></span>
                    </div>
                    <div class="col-md-9 col-xs-3"></div>
                </div>

                <br><br><br>





                {!! Form::close()!!}
            </div>
        </div>

        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="box-padrao">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></div>
                        <input class="form-control" type="text" ng-model="dadoPesquisa" placeholder="Faça sua busca"/>
                    </div>
                    <br>
                    <div><% mensagemItemr %></div>
                    <div ng-show="processandoListagem"><i class="fa fa-spinner fa-spin"></i> Processando...</div>
                    <h2 class="tabela_vazia" ng-show="!processandoListagem && totalItens==0">Nenhum registro encontrado!</h2>
                    <table ng-show="totalItens>0" class="table table-striped">
                        <thead>
                        <tr>
                            <th ng-click="ordernarPor('id')" style="itemr:pointer;">
                                Id
                                <i ng-if="ordem=='id' && sentidoOrdem=='asc'" class="fa fa-angle-double-down"></i>
                                <i ng-if="ordem=='id' && sentidoOrdem=='desc'" class="fa fa-angle-double-up"></i>
                            </th>
                            <th>Imagem</th>
                            <th ng-click="ordernarPor('tipo_id')" style="itemr:pointer;">
                                Tipo
                                <i ng-if="ordem=='tipo_id' && sentidoOrdem=='asc'" class="fa fa-angle-double-down"></i>
                                <i ng-if="ordem=='tipo_id' && sentidoOrdem=='desc'" class="fa fa-angle-double-up"></i>
                            </th>
                            <th ng-click="ordernarPor('integrante_id')" style="itemr:pointer;">
                                Integrante
                                <i ng-if="ordem=='integrantes.titulo' && sentidoOrdem=='asc'" class="fa fa-angle-double-down"></i>
                                <i ng-if="ordem=='integrantes.titulo' && sentidoOrdem=='desc'" class="fa fa-angle-double-up"></i>
                            </th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="item in items">
                            <td><% item.id %></td>
                            <td><img ng-show="item.imagem" ng-src="imagens/integrantes/xs-<% item.imagem %>" width="60"></td>
                            <td>{{--<a href="cms/item-versao/<% item.id %>">--}}<% tipos[item.tipo_id] %>{{--</a>--}}</td>
                            <td>{{--<a href="cms/item-versao/<% item.id %>">--}}<% item.titulo %>{{--</a>--}}</td>
                            <td class="text-right">
                                <div>
                                   {{-- <a href="cms/item-versao/<% item.id %>"><i class="fa fa-edit fa-2x" title="Editar"></i></a>&nbsp;&nbsp;--}}
                                    <a  ng-class="<% item.status %> == 1 ? 'color-success' : 'color-success-inactive'"  style="cursor: pointer;"><i class="fa fa-check-circle fa-2x" aria-hidden="true" ng-click="status(item.id);"></i></a>
                                    <a><i data-toggle="modal" data-target="#modalExcluir" class="fa fa-remove fa-2x" ng-click="perguntaExcluir(item.id, item.titulo, item.imagem)"></i></a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!--<button class="btn btn-primary btn-block" ng-click="loadMore()" ng-hide="currentPage==lastPage">Load More</button>-->
                <div ng-show="totalItens > 0" class="clan-paginacao">
                    <div class="item-paginacao">
                        <uib-pagination total-items="totalItens" ng-model="currentPage" max-size="maxSize" class="pagination-sm" boundary-links="true" force-ellipses="true" items-per-page="itensPerPage" num-pages="numPages"></uib-pagination>
                    </div>
                    <div class="item-paginacao">
                        <select class="form-control itens-por-pagina item-paginacao"  ng-model="itensPerPage">
                            <option ng-selected="true">10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                    </div>
                    <div class="item-paginacao">
                        <div class="resumo-pagina">&nbsp; <% primeiroDaPagina %> - <% (ultimoDaPagina) %> de <% totalItens %></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Excluir-->
        <div class="modal fade" id="modalExcluir" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Excluir</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3">
                                <img  ng-src="imagens/items/xs-<% imagemExcluir %>" width="100">
                            </div>
                            <div class="col-md-9">
                                <p><% tituloExcluir %></p>
                            </div>
                        </div>
                        <div ng-show="processandoExcluir"><i class="fa fa-spinner fa-spin"></i> Processando...</div>
                        <div class="mensagem-ok text-center text-danger"><% mensagemExcluido %></div>
                    </div>
                    <div id="opcoesExcluir" class="modal-footer" ng-show="!excluido">
                        <button id="btnExcluir" type="button" class="btn btn-default" ng-click="excluir(idExcluir);">Sim</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                    </div>
                    <div id="fecharExcluir" class="modal-footer" ng-show="excluido">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fim Modal Excluir-->
    </div>
@endsection