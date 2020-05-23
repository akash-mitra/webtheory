<?php


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
// --------------------------------------------------------------------------------------------------------------------------
// Unauthenticated Routes
// --------------------------------------------------------------------------------------------------------------------------
Route::post('login', 'Api\Auth\LoginController@login');
Route::get('check', 'Api\Auth\LoginController@user');
Route::post('register', 'Api\Auth\RegisterController@register');



// --------------------------------------------------------------------------------------------------------------------------
// Comments Listing
// --------------------------------------------------------------------------------------------------------------------------
Route::get('categories/{category}/comments', 'Api\CategoryCommentController@index')->name('categorycomment.index');
Route::get('pages/{page}/comments', 'Api\PageCommentController@index')->name('pagecomment.index');



// --------------------------------------------------------------------------------------------------------------------------
// All media related routes
// --------------------------------------------------------------------------------------------------------------------------
// Route::get('/admin/media',            'MediaController@index')->name('media.index')->middleware('author');
// Route::get('/api/media',              'MediaController@apiIndex')->name('api.media.index')->middleware('author');
// Route::post('/admin/media',           'MediaController@store')->name('media.store')->middleware('author');
// Route::delete('/admin/media/{media}', 'MediaController@destroy')->name('media.destroy')->middleware('author');



// --------------------------------------------------------------------------------------------------------------------------
// Authenticated Routes
// --------------------------------------------------------------------------------------------------------------------------
Route::group(['middleware' => ['auth:airlock']], function () {

    Route::post('logout', 'Api\Auth\LoginController@logout');


    // --------------------------------------------------------------------------------------------------------------------------
    // Categories API
    // --------------------------------------------------------------------------------------------------------------------------
    Route::get('categories', 'Api\CategoryController@index')->name('categories.index');
    Route::get('categories/{category}', 'Api\CategoryController@show')->name('categories.show');
    Route::get('categories/{category}/pages', 'Api\CategoryController@pages')->name('categories.pages');
    Route::post('categories', 'Api\CategoryController@store')->name('categories.store');
    Route::put('categories/{category}', 'Api\CategoryController@update')->name('categories.update');
    Route::delete('categories/{category}', 'Api\CategoryController@destroy')->name('categories.destroy');


    // --------------------------------------------------------------------------------------------------------------------------
    // Pages API
    // --------------------------------------------------------------------------------------------------------------------------
    Route::get('pages', 'Api\PageController@index')->name('pages.index');
    Route::get('pages/{page}', 'Api\PageController@show')->name('pages.show');
    Route::post('pages', 'Api\PageController@store')->name('pages.store');
    Route::put('pages/{page}', 'Api\PageController@update')->name('pages.update');
    Route::put('pages/{page}/status', 'Api\PageController@updateStatus')->name('pages.updatestatus');
    Route::put('pages/{page}/owner', 'Api\PageController@updateOwner')->name('pages.updateowner');
    Route::delete('pages/{page}', 'Api\PageController@destroy')->name('pages.destroy');


    // --------------------------------------------------------------------------------------------------------------------------
    // Media API
    // --------------------------------------------------------------------------------------------------------------------------
    Route::get('media', 'Api\MediaController@index')->name('media.index');
    Route::get('media/{media}', 'Api\MediaController@show')->name('media.show');
    Route::post('media', 'Api\MediaController@upload')->name('media.upload');
    Route::post('media/fetchUrl', 'Api\MediaController@uploadurl')->name('media.uploadurl');
    Route::delete('media/{media}', 'Api\MediaController@remove')->name('media.remove');


    // --------------------------------------------------------------------------------------------------------------------------
    // Comments API
    // --------------------------------------------------------------------------------------------------------------------------
    Route::post('categories/{category}/comments', 'Api\CategoryCommentController@store')->name('categorycomment.store');
    Route::post('pages/{page}/comments', 'Api\PageCommentController@store')->name('pagecomment.store');


    // --------------------------------------------------------------------------------------------------------------------------
    // Users API
    // --------------------------------------------------------------------------------------------------------------------------
    Route::get('users/comments', 'Api\ProfileController@comments')->name('users.comments');
    Route::get('profile/{user}', 'Api\ProfileController@show')->name('profile.show');
    Route::put('profile/{user}', 'Api\ProfileController@update')->name('profile.update');
    Route::put('users/{user}/role', 'Api\ProfileController@updateRole')->name('users.updaterole');
    Route::get('users', 'Api\UserController@index')->name('users.index');
    Route::get('users/{user}', 'Api\UserController@show')->name('users.show');
    Route::post('users', 'Api\UserController@store')->name('users.store');
    Route::put('users/{user}', 'Api\UserController@update')->name('users.update');
    Route::delete('users/{id}', 'Api\UserController@destroy')->name('users.destroy');
    Route::patch('users/password', 'Api\UserController@changePassword')->name('password.change');



    // --------------------------------------------------------------------------------------------------------------------------
    // Templates Management API
    // --------------------------------------------------------------------------------------------------------------------------
    Route::get('templates', 'Api\TemplateController@index')->name('templates.index');
    Route::get('templates/{template}', 'Api\TemplateController@show')->name('templates.show');
    Route::post('templates', 'Api\TemplateController@store')->name('templates.store');

    Route::post('templates/{template}/add', 'Api\TemplateController@add')->name('templates.add');
    Route::get('templates/{template}/get/{file}', 'Api\TemplateController@get')->name('templates.get');

    Route::post('templates/{template}/activate', 'Api\TemplateController@activate')->name('templates.activate');
    Route::patch('templates/{template}', 'Api\TemplateController@update')->name('templates.update');
    Route::delete('templates/{template}', 'Api\TemplateController@destroy')->name('templates.destroy');
    Route::post('templates/{template}/duplicate', 'Api\TemplateController@duplicate')->name('templates.duplicate');
    Route::post('templates/import', 'Api\TemplateController@import')->name('templates.import');



    // --------------------------------------------------------------------------------------------------------------------------
    // Parameters API
    // --------------------------------------------------------------------------------------------------------------------------
    Route::get('parameters/{key}', 'Api\ParameterController@get')->name('parameters.get');
    Route::post('parameters/{key}', 'Api\ParameterController@set')->name('parameters.set');



    // --------------------------------------------------------------------------------------------------------------------------
    // Settings API
    // --------------------------------------------------------------------------------------------------------------------------
    Route::get('settings/social', 'Api\SettingController@getsocial')->name('settings.social');
    Route::get('settings/mail', 'Api\SettingController@getmail')->name('settings.mail');
    Route::post('settings/loginprovider', 'Api\SettingController@loginprovider')->name('settings.loginprovider');
    Route::post('settings/mailprovider', 'Api\SettingController@mailprovider')->name('settings.mailprovider');
    Route::get('settings/testmail', 'Api\SettingController@testmail')->name('settings.testmail');
    Route::post('settings/update', 'Api\SettingController@update')->name('settings.update');



    // --------------------------------------------------------------------------------------------------------------------------
    // LOV API
    // --------------------------------------------------------------------------------------------------------------------------
    Route::get('lov/categories', 'Api\LovController@categories')->name('lov.categories');
    Route::get('lov/authors', 'Api\LovController@authors')->name('lov.authors');


});
