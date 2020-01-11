<?php

use JRaddatz\Web\Session\Session;
use DI\Bridge\Slim\Bridge as AppFactory;
use DI\ContainerBuilder;
use Slim\Views\Twig;
use Illuminate\Database\Capsule\Manager as Capsule;

$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/container.php');
$container = $builder->build();

$app = AppFactory::create($container);

Session::start([
    'cookie_secure' => true,
]);

$capsule = new Capsule;

$capsule->addConnection(require_once __DIR__ . '/../config/database.php');

$capsule->setAsGlobal();

$capsule->bootEloquent();

require_once __DIR__ . '/../bootstrap/middleware.php';

require_once __DIR__ . '/../routes/web.php';

$app->run();
