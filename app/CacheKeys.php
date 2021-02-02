<?php

use App\DataProvider;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\LovController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Template;

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
        'invocations' => [DataProvider::class],
        'invalidations' => [Template::class],
    ],

    'pages' => [
        'description' =>
            'List of pages returned to the frontend when no pagination parameter is set.',
        'invocations' => ['App\DataProvider'],
        'invalidations' => [PageController::class],
    ],

    'pages.count' => [
        'description' => 'Count of all the pages.',
        'invocations' => [DashboardController::class],
        'invalidations' => [PageController::class],
    ],

    'users.count' => [
        'description' => 'Count of all the users.',
        'invocations' => [DashboardController::class],
        'invalidations' => [
            [UserController::class],
            [RegisterController::class],
        ],
    ],

    'categories' => [
        'description' => 'List of all categories with author.',
        'invocations' => [DataProvider::class],
        'invalidations' => [CategoryController::class],
    ],

    'categories.lov' => [
        'description' => 'A simple list of values for all the categories.',
        'invocations' => [LovController::class],
        'invalidations' => [CategoryController::class],
    ],

    'menus' => [
        'description' => 'List of all menu items order by sequence number.',
        'invocations' => [DataProvider::class],
        'invalidations' => [MenuController::class],
    ],

    'home-menu' => [
        'description' => 'Home menu item.',
        'invocations' => [HomeController::class],
        'invalidations' => [MenuController::class],
    ],
];
