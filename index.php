<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Exception\HttpNotFoundException;
use IsabellaDaberkow\Tarefas\Service\TarefasService;
use Projetux\Infra\Debug;
use Projetux\Math\Basic;
//use Slim\Exception\HttpNotFoundException;

require __DIR__ . '/vendor/autoload.php';
 
$app = AppFactory::create();
//  middleware é um evento que ocorre antes da requisição chegar na rota
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setErrorHandler(HttpNotFoundException::class, function (
    Request $request, 
    Throwable $exception, 
    bool $displayErrorDetails, 
    bool $logErrors, 
    bool $logErrorDatails
) use ($app) {
    $response = $app->ResponseFactory()->createResponse();
    $response->getBody()->write('{"error": "Recurso não foi encontrado"}');
    return $response->withHeader('Content-Type', 'application/json')
                    ->withStatus(404);
});
 
$app->get("/math/soma/{num1}/{num2}", function(Request $request, Response $response, array $args){
    $basic = new Basic();
    $resultado = $basic->soma($args['num1'],$args['num2']);
    $response->getBody()->write((string)$resultado);
    return $response;
});

$app->get("/math/sub/{num1}/{num2}", function(Request $request, Response $response, array $args){
    $basic = new Basic();
    $resultado = $basic->subtrai($args['num1'],$args['num2']);
    $response->getBody()->write((string)$resultado);
    return $response;
});

$app->get("/math/multi/{num1}/{num2}", function(Request $request, Response $response, array $args){
    $basic = new Basic();
    $resultado = $basic->multiplica($args['num1'],$args['num2']);
    $response->getBody()->write((string)$resultado);
    return $response;
});

$app->get("/math/div/{num1}/{num2}", function(Request $request, Response $response, array $args){
    $basic = new Basic();
    $resultado = $basic->divide($args['num1'],$args['num2']);
    $response->getBody()->write((string)$resultado);
    return $response;
});

$app->get("/math/eleva/{num1}", function(Request $request, Response $response, array $args){
    $basic = new Basic();
    $resultado = $basic->elevaAoQuadrado($args['num1']);
    $response->getBody()->write((string)$resultado);
    return $response;
});

$app->get("/math/raiz/{num1}", function(Request $request, Response $response, array $args){
    $basic = new Basic();
    $resultado = $basic->Quadradaraiz($args['num1']);
    $response->getBody()->write((string)$resultado);
    return $response;
});

$app->get('/teste-debug',function (Request $request, Response $response, array $args){
    $debug = new Debug();
    $response->getBody()->write($debug->debug('teste 00001'));
    return $response;
});

$app->get('/tarefas', function (Request $request, Response $response, array $args) {
    $tarefa_service = new TarefasService();
    $tarefas =  $tarefa_service->getAllTarefas();
    $response->getBody()->write(json_encode($tarefas));
    return $response->withHeader('Content-Type', 'application/json');
});
 
$app->post('/tarefas', function(Request $request, Response $response, array $args){
$parametros = (array) $request->getParsedBody();
if(!array_key_exists('titulo', $parametros) || empty($parametros['titulo'])){
    $response->getBody()->write(json_encode([
        "mensagem"=>"título é obrigatório"
    ]));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
}
    $tarefa = array_merge(['titulo' => '', 'concluido' => false], $parametros);
    $tarefa_service = new TarefaService ();
    $tarefa_service -> createTarefa($tarefa);
    return$response->withStatus(201);
});
$app->delete('/tarefas/{id}', function(Request $requets, Response $response, array $args) {
 
$id = $args['id'];
$tarefa_service = new TarefasService();
$tarefa_services->deleteTarefa($id);
return $response->eithStatus(204);

});
$app->put('/tarefas/{id}', function(Request $requets, Response $response, array $args) {
 $id = $args['id'];
 $dados_para_atualizar = json_decode($request->getBody()->getContents(), true);if(array_key_exists('titulo', $dados_para_atualizar)&& empty($dados_para_atualizar['titulo'])){
    $response->getBody()->write(json_encode([
        "mensagem"=>"título é obrigatório"
    ]));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
    $tarefa_service = new TarefaService();
    $tarefa_service->updateTarefa($id, $dados_para_atualizar);
    return $response->withStatus(201);
 
});
 

$app->get('/usuarios', function (Request $request, Response $response, array $args) {
    $usuarios = [
        ["id"=>1, "login"=> "elisa.fonseca", "nome"=> "Elisa Fonseca"],
        ["id"=>2, "login"=> "isabella.daberkow", "nome"=> "Isabella Daberkow"],
        ["id"=>3, "login"=> "karina.meier", "nome"=> "Karina Meier"],
        ["id"=>4, "login"=> "amabile.luz", "nome"=> "Amábile Luz"],
        ["id"=>5, "login"=> "maria.lembeck", "nome"=> "Maria Lembeck"],
    ];
    $response->getBody()->write(json_encode($usuarios));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/usuarios', function(Request $request, Response $response, array $args){
    $parametros = (array) $request->getParsedBody();
    if (!array_key_exists('login', $parametros) || empty($parametros['login'])){
        $response->getBody()->write(json_encode([
            "mensagem" => "Login é obrigaório"
        ]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
    if (!array_key_exists('senha', $parametros) || empty($parametros['senha'])){
        $response->getBody()->write(json_encode([
            "mensagem" => "Senha é obrigaório"
        ]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
    return $response->withStatus(201);
});
$app->delete('/usuarios/{id}', function(Request $requets, Response $response, array $args) {
    return $response->withStatus(201);
});
$app->put('/usuarios/{id}', function(Request $requets, Response $response, array $args) {
    return $response->withStatus(201);
});

$app->run();