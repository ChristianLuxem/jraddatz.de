<?php

use JRaddatz\Web\Http\Middleware\RemoveTrailingSlashFromUrl;
use JRaddatz\Web\Config\Config;
use JRaddatz\Web\Exceptions\Handler;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

$app->addRoutingMiddleware();

$app->add(new RemoveTrailingSlashFromUrl);

$app->add(TwigMiddleware::createFromContainer($app, Twig::class));

$errorMiddleware = $app->addErrorMiddleware($container->get(Config::class)->get('app.debug'), true, true);

$errorMiddleware->setDefaultErrorHandler(
    new Handler(
        $app->getResponseFactory(),
        $container->get(Twig::class),
        $container->get(Config::class)
    )
);
