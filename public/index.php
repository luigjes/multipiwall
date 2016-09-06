<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
spl_autoload_register(function ($classname) {
    require ("../classes/" . $classname . ".php");
});

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);
$container = $app->getContainer();

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};
$container['view'] = new \Slim\Views\PhpRenderer("../templates/");

$app->get('/', function (Request $request, Response $response) {
    
    $tester = new Test();
    $asdf = $tester->displayVar();
    //$response->getBody()->write("Hello" . $asdf);
    $response = $this->view->render($response, "default.php", ["test" => $asdf]);
    //$this->logger->addInfo("Something interesting happened");
    return $response;
});

$app->run();