<?php

use JRaddatz\Web\Http\Controllers\Errors\HttpInternalServerErrorController;
use JRaddatz\Web\Http\Controllers\Errors\HttpNotFoundController;
use JRaddatz\Web\Http\Middleware\RemoveTrailingSlashFromUrl;
use JRaddatz\Web\Config\Config;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Response;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

$app->addRoutingMiddleware();

$app->add(new RemoveTrailingSlashFromUrl);

$app->add(TwigMiddleware::createFromContainer($app, Twig::class));

$errorMiddleware = $app->addErrorMiddleware($container->get(Config::class)->get('app.debug'), true, true);

// Error Handlers
$errorMiddleware->setErrorHandler(HttpNotFoundException::class, function (Request $request) use ($container) {
    return (new HttpNotFoundController($container->get(Twig::class), $container->get(Config::class)))
        ->index($request, (new Response())->withStatus(404));
});

$errorMiddleware->setDefaultErrorHandler(function (Request $request) use ($container) {
    return (new HttpInternalServerErrorController($container->get(Twig::class), $container->get(Config::class)))
        ->index($request, (new Response())->withStatus(500));
});
