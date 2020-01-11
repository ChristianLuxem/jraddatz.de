<?php

use JRaddatz\Web\Config\Config;
use JRaddatz\Web\Security\Hash\Hash;
use Slim\Views\Twig;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\ArrayLoader;
use DI\Container;

return [
    Config::class => DI\create(Config::class)
        ->method('set', require_once __DIR__ . '/../config/config.php'),
    Twig::class => function (Container $container) {
        return Twig::create($container->get(Config::class)->get('view.path'), [
            'cache' => $container->get(Config::class)->get('app.debug') ? false : $container->get(Config::class)->get('view.cache'),
        ]);
    },
    Hash::class => function (Container $container) {
        return new Hash($container->get(Config::class));
    },
];
