<?php

define('APP_PATH', dirname(__DIR__) . '/app');

if (!extension_loaded('phalcon')) {
    die('Phalcon extension is not loaded. Please install Phalcon PHP extension.');
}

use Phalcon\Autoload\Loader;
use Phalcon\Mvc\Micro;
use Phalcon\Di\FactoryDefault;
use Phalcon\Http\Response;

$config = include __DIR__ . '/../config/config.php';

$loader = new Loader();
$loader->setDirectories([
    APP_PATH . '/models/',
    APP_PATH . '/controllers/',
]);

$loader->register();

$di = new FactoryDefault();

include __DIR__ . '/../config/services.php';

$app = new Micro($di);

$app->before(function () use ($app) {
    $response = $app->response;
    $response->setHeader('Access-Control-Allow-Origin', 'http://localhost:5173');
    $response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    $response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');

    if ($app->request->getMethod() === 'OPTIONS') {
        $response->setStatusCode(204, 'No Content')->sendHeaders();
        return false; // Stop further execution
    }

    return true;
});

include __DIR__ . '/../config/routes.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: http://localhost:5173");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Content-Type: application/json");
    http_response_code(204);
    exit;
}

$app->handle($_SERVER["REQUEST_URI"]);
