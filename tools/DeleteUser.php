<?php

/**
 * Command line tool to delete a user from the database.
 *
 * Execution: php tools/DeleteUser.php id=5
 */

namespace JRaddatz\Console\Tools\CreateUser;

use JRaddatz\Web\Models\User;
use JRaddatz\Web\Security\Token\Token;
use JRaddatz\Web\Security\Hash\Hash;
use JRaddatz\Web\Config\Config;
use DI\Bridge\Slim\Bridge as AppFactory;
use DI\ContainerBuilder;
use Illuminate\Database\Capsule\Manager as Capsule;

require_once __DIR__ . '/../vendor/autoload.php';

$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/../bootstrap/container.php');
$container = $builder->build();

$capsule = new Capsule;

$capsule->addConnection(require_once __DIR__ . '/../config/database.php');

$capsule->setAsGlobal();

$capsule->bootEloquent();

parse_str(implode('&', array_slice($argv, 1)), $args);

foreach ($args as $key => $arg) {
    $args[$key] = htmlspecialchars($arg);
}

if (empty($args['id'])) {
    return;
}

$user = User::where('id', $args['id'])->first();

if (!$user) {
    return;
}

$user->delete();

$data = [
    'user' => $user->toArray(),
    'link' => $container->get(Config::class)->get('app.base_url') . "?id={$user->id}&key={$user->key}",
];

dump($data);
