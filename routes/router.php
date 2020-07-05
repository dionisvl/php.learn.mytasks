<?php
use App\Controller\TaskController;
use App\Controller\UserController;
use App\Helpers\Auth;


$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    //main page
    $r->addRoute('GET', '/', [TaskController::class, 'index']);

    $r->addRoute('GET', '/registration', [UserController::class, 'create']);
    $r->addRoute('POST', '/registration', [UserController::class, 'store']);

    $r->addRoute('GET', '/login', [UserController::class, 'loginForm']);
    $r->addRoute('POST', '/login', [Auth::class, 'login']);

    $r->addRoute('GET', '/logout', [Auth::class, 'logout']);


    $r->addRoute('GET', '/task/create', [TaskController::class, 'create']);
    $r->addRoute('POST', '/task/create', [TaskController::class, 'store']);


    // {id} must be a number (\d+)
    $r->addRoute('GET', '/task/{id:\d+}', [TaskController::class, 'show']);
    $r->addRoute('GET', '/task/{id:\d+}/edit', [TaskController::class, 'edit']);
    $r->addRoute('POST', '/task/{id:\d+}', [TaskController::class, 'update']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo 'error: page not found (404)';
        die();
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo 'error: method not allowed';
        die();
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        // ... call $handler with $vars
        handleController($handler[0], $handler[1], $vars);
        break;
}