<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->group('/api', function () use ($app) {
  // Version group
  $app->group('/v1', function () use ($app) {
    $app->get('/getpersonas', 'obtenerPersonas');
    $app->get('/empleado/{id}', 'obtenerEmpleado');
    $app->post('/crear', 'agregarEmpleado');
    $app->put('/actualizar/{id}', 'actualizarEmpleado');
    $app->delete('/eliminar/{id}', 'eliminarEmpleado');
  });
});

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
