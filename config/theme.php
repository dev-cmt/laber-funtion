<?php

return [
    'main' => [
        'controller' => App\Http\Controllers\HomeController::class,
        'views_path' => 'theme.main',
        'assets_path' => 'frontend',
    ],

    'theme1' => [
        'controller' => App\Http\Controllers\Theme1Controller::class,
        'views_path' => 'theme.theme1',
        'assets_path' => 'frontend1',
    ],
];