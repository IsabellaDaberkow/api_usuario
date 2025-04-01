<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
//use Slim\Exception\HttpNotFoundException;

require __DIR__ . '/vendor/autoload.php';
 
$app = AppFactory::create();

/*
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
*/
 
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