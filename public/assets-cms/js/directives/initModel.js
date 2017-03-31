cmsApp.directive('initModel', ['$compile', function($compile) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            //scope[attrs.initModel] = element[0].value;
            //console.log(element);
            //console.log(scope);
            //console.log(attrs);
            //ser for do tipo radio
            if(element.context.type=='radio'){
                //console.log(element.context.checked);
                //se estiver com o checked true ir� ent�o definir o valor inicial
                if(element.context.checked==true){
                    element.attr('ng-init', attrs.ngModel+"='"+element[0].value+"'");
                }
            }else if(element.context.type=='checkbox'){
                element.attr('ng-init', attrs.ngModel+"="+element.context.checked);
            }else if(element.context.type=='number'){
                element.attr('ng-init', attrs.ngModel+"="+element[0].value);
            }else{
                //outro tipo diferente de radio
                element.attr('ng-init', attrs.ngModel+"='"+element[0].value+"'");
            }
            element.attr('ng-model', attrs.initModel);
            element.removeAttr('init-model');
            $compile(element)(scope);
        }
    };
}]);
