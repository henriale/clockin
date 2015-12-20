<?php

use \App\Http\Controllers\JsonApi\UserController;

$app->get(
    'users/exists/{email}',
    ['uses' => UserController::class.'@exists']
);
$app->post(
    '/users',
    ['uses' => UserController::class.'@store']
);
