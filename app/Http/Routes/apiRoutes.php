<?php

$app->get(
    'login/basic',
    ['middleware' => 'jsonapi.basicAuth', 'uses' => UsersController::class.'@getSignedInUserJwt']
);

$app->get(
    'login/refresh',
    ['middleware' => 'jsonapi.jwtAuth', 'uses' => UsersController::class.'@getSignedInUserJwt']
);

$app->group([
    'prefix'     => 'api/v1',
    'middleware' => ['jsonapi.basicAuth']
],
    function () use ($app) {
        include __DIR__ . '/api/v1/workday.php';
    }
);