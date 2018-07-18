@extends('cms::layouts.app')

@section('content')
    {!! Html::script('assets-cms/js/controllers/alterarCmsUserCtrl.js') !!}
    <div ng-controller="alterarCmsUserCtrl">
        <div class="box-padrao">
            <h1><a href="../usuario"><i class="fa fa-arrow-circle-left"></i></a>&nbsp;&nbsp;Usuário</h1>

            <div >
                <span class="texto-obrigatorio">* campos obrigatórios</span><br><br>
                {!! Form::model($cmsuser, ['name' =>'form']) !!}

                <br><br>
                @include('cms::cmsuser._form')

                <input ng-model="cmsuser.alterar_senha" type="checkbox" value="true"><label>&nbsp;&nbsp;Alterar Senha</label><br><br>

                <div ng-show="cmsuser.alterar_senha">
                    <label for="password">Senha *</label><br>
                    <input type="password" class="form-control width-grande" ng-required="true" ng-model="cmsuser.password"><br>

                    <label for="conf_password">Confirmar Senha *</label><br>
                    <input type="password" class="form-control width-grande" ng-required="true" ng-model="cmsuser.confpassword">
                    <span ng-show="cmsuser.password!=cmsuser.confpassword && cmsuser.password!=''" class="text-danger"> senhas diferentes!</span><br>
                </div>


                {{--<input type="hidden" name="id" ng-model="id" ng-init="id='{{$cmsuser->id}}'"/>--}}
                <div class="row">
                    <div class="col-md-1 col-lg-1 col-xs-3">
                        <button class="btn btn-info" type="button" ng-click="alterarPerfil()" ng-disabled="form.$invalid && form.cmsuser.$dirty">Salvar</button>
                    </div>
                    <div class="col-md-2 col-lg-2 col-xs-6">
                        <p class="mensagem-ok text-success"><% mensagemSalvar %></p>
                        <br><br>
                        <div ng-show="processandoSalvar"><i class="fa fa-spinner fa-spin"></i> Processando...</div>
                    </div>
                    <div class="col-md-9 col-xs-3"></div>
                </div>
                <br><br><br>





                {!! Form::close()!!}
            </div>
        </div>
    </div>
@endsection