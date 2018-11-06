@extends('cms::layouts.app')


@section('content')
    {!! Html::script('assets-cms/js/controllers/alterarSettingCtrl.js') !!}
    <div ng-controller="alterarSettingCtrl">
        <div class="box-padrao text-center">
            <h1 style="color:#ccc; margin-top: 200px;">MapaOsc - CMS</h1>
        </div>
    </div>
@endsection