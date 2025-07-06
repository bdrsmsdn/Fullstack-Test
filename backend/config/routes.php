<?php

// Patient routes
$app->get('/api/patients', function () use ($app) {
    $controller = new PatientsController();
    $controller->setDI($app->getDI());
    return $controller->indexAction();
});

$app->get('/api/patients/{id:[0-9]+}', function ($id) use ($app) {
    $controller = new PatientsController();
    $controller->setDI($app->getDI());
    return $controller->showAction($id);
});

$app->post('/api/patients', function () use ($app) {
    $controller = new PatientsController();
    $controller->setDI($app->getDI());
    return $controller->createAction();
});

$app->put('/api/patients/{id:[0-9]+}', function ($id) use ($app) {
    $controller = new PatientsController();
    $controller->setDI($app->getDI());
    return $controller->updateAction($id);
});

$app->delete('/api/patients/{id:[0-9]+}', function ($id) use ($app) {
    $controller = new PatientsController();
    $controller->setDI($app->getDI());
    return $controller->deleteAction($id);
});

// Handle not found
$app->notFound(function () use ($app) {
    $app->response->setStatusCode(404);
    $app->response->setJsonContent([
        'status' => 'error',
        'message' => 'Endpoint not found'
    ]);
    return $app->response;
});