cmsApp.controller('noticiaCtrl', ['$scope', '$http', 'Upload', '$timeout', function($scope, $http, Upload, $timeout){
    
    $scope.noticias = [];
    $scope.currentPage = 1;
    $scope.lastPage = 0;
    $scope.totalItens = 0;
    $scope.maxSize = 5;
    $scope.itensPerPage = 10;
    $scope.dadoPesquisa = '';
    $scope.campos = "id, titulo, imagem, status";
    $scope.campoPesquisa = "titulo";
    $scope.processandoListagem = false;
    $scope.processandoExcluir = false;
    $scope.ordem = "titulo";
    $scope.sentidoOrdem = "asc";
    var $listar = false;//para impedir de carregar o conteúdo dos watchs no carregamento da página.

    $scope.$watch('currentPage', function(){
        if($listar){
            listarNoticias();
        }
    });
    $scope.$watch('itensPerPage', function(){
        if($listar){
            listarNoticias();
        }
    });
    $scope.$watch('dadoPesquisa', function(){
        if($listar){
            listarNoticias();
        }
    });


    var listarNoticias = function(){
        $scope.processandoListagem = true;
        $http({
            url: 'cms/listar-noticias',
            method: 'GET',
            params: {
                page: $scope.currentPage,
                itensPorPagina: $scope.itensPerPage,
                dadoPesquisa: $scope.dadoPesquisa,
                campos: $scope.campos,
                campoPesquisa: $scope.campoPesquisa,
                ordem: $scope.ordem,
                sentido: $scope.sentidoOrdem
            }
        }).success(function(data, status, headers, config){
            $scope.noticias = data.data;
            $scope.lastPage = data.last_page;
            $scope.totalItens = data.total;
            $scope.primeiroDaPagina = data.from;
            $scope.ultimoDaPagina = data.to;
            $listar = true;
            //console.log(data);
            $scope.processandoListagem = false;
        }).error(function(data){
            $scope.message = "Ocorreu um erro: "+data;
            $scope.processandoListagem = false;
        });
    };



    $scope.ordernarPor = function(ordem){
        $scope.ordem = ordem;
        //console.log($scope.ordem);
        if($scope.sentidoOrdem=="asc"){
            $scope.sentidoOrdem = "desc";
        }else{
            $scope.sentidoOrdem = "asc";
        }

        listarNoticias();
    };

    $scope.validar = function(){

    };
    

    listarNoticias();

    //INSERIR/////////////////////////////

    $scope.tinymceOptions = tinymceOptions;
    $scope.mostrarForm = false;
    $scope.processandoInserir = false;

    $scope.inserir = function (file, arquivo){

        $scope.mensagemInserir = "";

        if(file==null && arquivo==null){
            $scope.processandoInserir = true;

            //console.log($scope.noticia);
            $http.post("cms/inserir-noticia", {noticia: $scope.noticia}).success(function (data){
                 listarNoticias();
                //delete $scope.noticia;//limpa o form
                delete $scope.noticia.data;
                delete $scope.noticia.titulo;
                delete $scope.noticia.resumida;
                delete $scope.noticia.slug;
                delete $scope.noticia.descricao;
                $scope.mensagemInserir =  "Gravado com sucesso!";
                $scope.processandoInserir = false;
             }).error(function(data){
                $scope.mensagemInserir = "Ocorreu um erro!";
                $scope.processandoInserir = false;
             });
        }else{


            Upload.upload({
                url: 'cms/inserir-noticia',
                data: {noticia: $scope.noticia, file: file, arquivo: arquivo},
            }).then(function (response) {
                $timeout(function () {
                    $scope.result = response.data;
                });
                //console.log(response.data);
                //delete $scope.noticia;//limpa o form
                delete $scope.noticia.data;
                delete $scope.noticia.titulo;
                delete $scope.noticia.resumida;
                delete $scope.noticia.slug;
                delete $scope.noticia.descricao;
                $scope.picFile = null;//limpa o file
                $scope.fileArquivo = null;//limpa o file
                listarNoticias();
                $scope.mensagemInserir =  "Gravado com sucesso!";
            }, function (response) {
                console.log(response.data);
                if (response.status > 0){
                    $scope.errorMsg = response.status + ': ' + response.data;
                }
            }, function (evt) {
                //console.log(evt);
                // Math.min is to fix IE which reports 200% sometimes
                $scope.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
            });
        }

    };

    $scope.limparImagem = function(){
        delete $scope.picFile;
        $scope.form.file.$error.maxSize = false;
    };

    $scope.validar = function(valor) {
        //console.log(valor);
        if(valor===undefined){
            return "campo-obrigatorio";
        }
        return "";
    };
    /////////////////////////////////

    //EXCLUIR/////////////////////////
    $scope.perguntaExcluir = function (id, titulo, imagem){
        $scope.idExcluir = id;
        $scope.tituloExcluir = titulo;
        $scope.imagemExcluir = imagem;
        $scope.excluido = false;
        $scope.mensagemExcluido = "";
    };

    $scope.excluir = function(id){
        $scope.processandoExcluir = true;
        $http({
            url: 'cms/excluir-noticia/'+id,
            method: 'GET'
        }).success(function(data, status, headers, config){
            console.log(data);
            $scope.processandoExcluir = false;
            $scope.excluido = true;
            $scope.mensagemExcluido = "Excluído com sucesso!";
            listarNoticias();
        }).error(function(data){
            $scope.message = "Ocorreu um erro: "+data;
            $scope.processandoExcluir = false;
            $scope.mensagemExcluido = "Erro ao tentar excluir!";
        });
    };
    //////////////////////////////////
    $scope.status = function(id){
        //console.log(id);
        $scope.mensagemStatus = '';
        $scope.idStatus = '';
        $scope.processandoStatus = true;
        $http({
            url: 'cms/status-noticia/'+id,
            method: 'GET'
        }).success(function(data, status, headers, config){
            //console.log(data);
            $scope.processandoStatus = false;
            //$scope.excluido = true;
            $scope.mensagemStatus = 'color-success';
            $scope.idStatus = id;
            listarNoticias();
        }).error(function(data){
            $scope.message = "Ocorreu um erro: "+data;
            $scope.processandoStatus = false;
            $scope.mensagemStatus = "Erro ao tentar status!";
        });
    };

}]);
