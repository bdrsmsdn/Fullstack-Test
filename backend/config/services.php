<?php

use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Http\Response;
use Phalcon\Http\Request;

$di->set('db', function () use ($config) {
    return new Mysql([
        'host'     => $config['database']['host'],
        'username' => $config['database']['username'],
        'password' => $config['database']['password'],
        'dbname'   => $config['database']['dbname'],
        'charset'  => $config['database']['charset']
    ]);
});

// Response service
$di->set('response', function () {
    $response = new Response();
    $response->setContentType('application/json');
    return $response;
});

// Request service
$di->set('request', function () {
    return new Request();
});

$di->set('config', function () use ($config) {
    return $config;
});