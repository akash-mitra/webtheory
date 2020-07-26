<?php

return [
    /*
    |--------------------------------------------------------------------------
    | List of all the cache Keys being used.
    |--------------------------------------------------------------------------
    |
    | This is the master list of all the cache keys. The purpose of
    | this list is to maintain it as a reference so that developers
    | can check this list first, before creating new cache entries
    | and also use the list to invalidate cache entries if required.
    |
    */

    'template.parameters' => [
        'description' => 'All template parameters pertaining to the active template',
        'invocations' => ['App\DataProvider'],
        'invalidations' => ['App\Template'],
    ],

    'pages' => [
        'description' =>
            'List of pages returned to the frontend when no pagination parameter is set.',
        'invocations' => ['App\DataProvider'],
        'invalidations' => ['App\Http\Controllers\Api\PageController'],
    ],

    'pages.count' => [
        'description' => 'Count of all the pages.',
        'invocations' => ['App\Http\Controllers\Api\DashboardController.php'],
        'invalidations' => ['App\Http\Controllers\Api\PageController'],
    ],

    'users.count' => [
        'description' => 'Count of all the users.',
        'invocations' => ['App\Http\Controllers\Api\DashboardController.php'],
        'invalidations' => [
            'App\Http\Controllers\Api\UserController',
            'App\Http\Controllers\Auth\RegisterController',
        ],
    ],

    'categories' => [
        'description' => 'List of all categories with author.',
        'invocations' => ['App\DataProvider'],
        'invalidations' => ['App\Http\Controllers\Api\CategoryController'],
    ],

    'categories.lov' => [
        'description' => 'A simple list of values for all the categories.',
        'invocations' => ['App\Http\Controllers\Api\LovController'],
        'invalidations' => ['App\Http\Controllers\Api\CategoryController'],
    ],
];
