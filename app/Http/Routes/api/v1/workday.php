<?php

use \App\Http\Controllers\JsonApi\WorkdayController;

$app->get(
    'workdays',
    ['uses' => WorkdayController::class.'@index']
);
$app->get(
    'workdays/{id}',
    ['uses' => WorkdayController::class.'@show']
);
$app->post(
    '/workdays',
    ['uses' => WorkdayController::class.'@store']
);
$app->delete(
    '/workdays/{id}',
    ['uses' => WorkdayController::class.'@destroy']
);
$app->patch(
    '/workdays/{id}',
    ['uses' => WorkdayController::class.'@update']
);
