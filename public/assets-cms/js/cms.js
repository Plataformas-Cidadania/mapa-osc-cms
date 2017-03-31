var cmsApp = angular.module('cmsApp', ['ui.bootstrap', 'ui.tinymce', 'ngFileUpload'] ,['$interpolateProvider', function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
}]);