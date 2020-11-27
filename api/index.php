<?php
//import do arquivo para iniciar
//as dependencias da API
require_once("vendor/autoload.php");

//instancia da class App
$app = new \Slim\App();

//EndPoint para o Acesso a Raiz da Pasta da API
$app -> get('/', function($request, $response, $args){
    return $response->getBody()->write('API de Contatos do CRUD');
});
// EndPoint para o acesso a todos os daodos de contatos da API
$app -> get('/contatos', function($request, $response, $args){
        //import do arquivo que vai buscar no BD
        require_once('../bd/apiContatos.php');
    // Recebendo dados da QueryString(Essas variáveis podem ou não chegar no request)
    // Existem 2 maneiras de receber uma variavel pela QueryString
        // $_GET[](Isso pertence ao PHP ou seja se o back-end rodar em outro ambiente não ira rodar)
        // getQueryParams()
        if (isset($request->getQueryParams()['nome'])) {
                                         // Aqui colocamos a varialvel que ser envidada na requisição
            $nome = $request->getQueryParams()['nome']; 
            $listContatos = buscarContatos($nome);
        }else{
            //function para listar todos os Contato
            $listContatos = listarContatos(0);
        }
        
       
    
   
    
    //Valida se houve retorno de dados do banco
    if($listContatos)
        return $response    ->withStatus(200)
                            ->withHeader('Content-Type', 'application/json')
                            ->write($listContatos);
    else
        return $response    ->withStatus(204);
});

//EndPoint para buscar pelo id
$app-> get('/contatos/{id}', function($request, $response, $args){

    $id = $args['id'];
    require_once('../bd/apiContatos.php');
    $listContatos = listarContatos($id);
    if($listContatos)
        return $response    ->withStatus(200)
                            ->withHeader('Content-Type', 'application/json')
                            ->write($listContatos);
    else
        return $response    ->withStatus(204);

});
//Carrega todos os EndPoints criados na API
$app->run();
