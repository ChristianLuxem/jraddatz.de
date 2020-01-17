<?php

use JRaddatz\Web\Http\Controllers\HomeController;
use JRaddatz\Web\Http\Controllers\Legal\LegalNoticeController;
use JRaddatz\Web\Http\Controllers\Legal\PrivacyPolicyController;
use JRaddatz\Web\Http\Middleware\AuthenticateUser;
use JRaddatz\Web\Security\Hash\Hash;
use Slim\Routing\RouteCollectorProxy;

$app->get('/', HomeController::class)
    ->setName('home')
    ->add(new AuthenticateUser($app->getContainer()->get(Hash::class)));

$app->group('/legal', function (RouteCollectorProxy $group) {
    $group->get('/legal-notice', LegalNoticeController::class)
        ->setName('legal-notice');

    $group->get('/privacy-policy', PrivacyPolicyController::class)
        ->setName('privacy-policy');
});
