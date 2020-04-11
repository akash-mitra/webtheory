<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Unauthenticated Routes
Route::post('login', 'Api\Auth\LoginController@login');
Route::post('register', 'Api\Auth\RegisterController@register');

Route::get('social/providers', 'Api\Auth\SocialLoginController@socialProviders');
Route::get('social/login/{provider}', 'Api\Auth\SocialLoginController@login');
Route::get('social/login/{provider}/callback', 'Api\Auth\SocialLoginController@callback');


// Authenticated Routes
Route::group(['middleware' => ['auth:airlock']], function () {

    Route::post('logout', 'Api\Auth\LoginController@logout');

    Route::get('categories', 'Api\CategoryController@index')->name('categories.index');
    Route::get('categories/{category}', 'Api\CategoryController@show')->name('categories.show');
    Route::get('categories/{category}/pages', 'Api\CategoryController@pages')->name('categories.pages');
    Route::get('categories/{category}/comments', 'Api\CategoryController@comments')->name('categories.comments');
    Route::post('categories', 'Api\CategoryController@store')->name('categories.store');
    Route::put('categories/{category}', 'Api\CategoryController@update')->name('categories.update');
    Route::delete('categories/{category}', 'Api\CategoryController@destroy')->name('categories.destroy');

    Route::get('pages', 'Api\PageController@index')->name('pages.index');
    Route::get('pages/{page}', 'Api\PageController@show')->name('pages.show');
    Route::get('pages/{page}/comments', 'Api\PageController@comments')->name('pages.comments');
    Route::post('pages', 'Api\PageController@store')->name('pages.store');
    Route::put('pages/{page}', 'Api\PageController@update')->name('pages.update');
    Route::put('pages/{page}/status', 'Api\PageController@updateStatus')->name('pages.updatestatus');
    Route::put('pages/{page}/owner', 'Api\PageController@updateOwner')->name('pages.updateowner');
    Route::delete('pages/{page}', 'Api\PageController@destroy')->name('pages.destroy');

    Route::get('media', 'Api\MediaController@index')->name('media.index');
    Route::get('media/{media}', 'Api\MediaController@show')->name('media.show');
    Route::post('media', 'Api\MediaController@upload')->name('media.upload');
    Route::delete('media/{media}', 'Api\MediaController@remove')->name('media.remove');

    Route::get('comments/categories', 'Api\CategoryCommentController@index')->name('categorycomments.index');
    Route::get('comments/categories/{categorycomment}', 'Api\CategoryCommentController@show')->name('categorycomments.show');
    Route::post('comments/categories', 'Api\CategoryCommentController@store')->name('categorycomments.store');
    Route::put('comments/categories/{categorycomment}', 'Api\CategoryCommentController@update')->name('categorycomments.update');
    Route::delete('comments/categories/{categorycomment}', 'Api\CategoryCommentController@destroy')->name('categorycomments.destroy');
    Route::put('comments/categories/{categorycomment}/like', 'Api\CategoryCommentController@like')->name('categorycomments.like');
    Route::put('comments/categories/{categorycomment}/dislike', 'Api\CategoryCommentController@dislike')->name('categorycomments.dislike');

    Route::get('comments/pages', 'Api\PageCommentController@index')->name('pagecomments.index');
    Route::get('comments/pages/{pagecomment}', 'Api\PageCommentController@show')->name('pagecomments.show');
    Route::post('comments/pages', 'Api\PageCommentController@store')->name('pagecomments.store');
    Route::put('comments/pages/{pagecomment}', 'Api\PageCommentController@update')->name('pagecomments.update');
    Route::delete('comments/pages/{pagecomment}', 'Api\PageCommentController@destroy')->name('pagecomments.destroy');
    Route::put('comments/pages/{pagecomment}/like', 'Api\PageCommentController@like')->name('pagecomments.like');
    Route::put('comments/pages/{pagecomment}/dislike', 'Api\PageCommentController@dislike')->name('pagecomments.dislike');

    Route::get('users/comments', 'Api\ProfileController@comments')->name('users.comments');
    Route::get('users/{user}', 'Api\ProfileController@show')->name('users.show');
    Route::put('users/{user}', 'Api\ProfileController@update')->name('users.update');
    Route::put('users/{user}/role', 'Api\ProfileController@updateRole')->name('users.updaterole');

    Route::get('lov/categories', 'Api\LovController@categories')->name('lov.categories');
    Route::get('lov/authors', 'Api\LovController@authors')->name('lov.authors');

    Route::get('templates', 'Api\TemplateController@index')->name('templates.index');
    Route::get('templates/{template}', 'Api\TemplateController@show')->name('templates.show');
    Route::post('templates', 'Api\TemplateController@store')->name('templates.store');
    Route::post('templates/{template}/add', 'Api\TemplateController@add')->name('templates.add');
    Route::post('templates/{template}/activate', 'Api\TemplateController@activate')->name('templates.activate');
    Route::patch('templates/{template}', 'Api\TemplateController@update')->name('templates.update');


    // Route::put('templates/{template}', 'Api\TemplateController@update')->name('templates.update');
    // Route::post('templates/{template}/activate', 'Api\TemplateController@activate')->name('templates.activate');
    // Route::delete('templates/{template}', 'Api\TemplateController@destroy')->name('templates.destroy');

    Route::get('parameters/{key}', 'Api\ParameterController@get')->name('parameters.get');
    Route::post('parameters/{key}', 'Api\ParameterController@set')->name('parameters.set');

    Route::get('users', 'Api\UserController@index')->name('users.index');
    Route::get('users/{user}', 'Api\UserController@show')->name('users.show');
    Route::post('users', 'Api\UserController@store')->name('users.store');
    Route::put('users/{user}', 'Api\UserController@update')->name('users.update');
    Route::delete('users/{user}', 'Api\UserController@destroy')->name('users.destroy');

    Route::post('settings/loginprovider', 'Api\SettingController@loginprovider')->name('settings.loginprovider');

});
