<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*
| AUTHENTICATION RELATED ROUTES
*/
Route::post('register', 'Auth\RegisterController@register')->name('register');
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');


/*
| FORGET PASSWORD RELATED ROUTES
*/
// Process the incoming password reset request.
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

// Show reset password form.
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

// Post a reset password request.
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');


/*
| SOCIAL AUTHENTICATION RELATED ROUTES
*/
Route::get('app/social/login/{provider}', 'Auth\SocialLoginController@login')->name('social.login');
Route::get('app/social/login/{provider}/callback', 'Auth\SocialLoginController@callback')->name('social.callback');


/*
| FRONT-END RELATED ROUTES
*/
Route::get('/', 'HomeController@root')->name('home');
Route::get('pages/{page}/{slug?}', 'HomeController@single')->name('pages.show');
Route::get('categories/{category}/{slug?}', 'HomeController@category')->name('categories.show');
Route::get('profiles/{public_id}', 'HomeController@profile')->name('profile.show');


/*
| FRONT-END RELATED FIXED ROUTES
*/
Route::get('sitemap', 'HomeController@sitemap')->name('sitemap');
Route::get('rss', 'HomeController@rss')->name('rss');
Route::get('privacy', 'HomeController@privacy')->name('privacy');
Route::get('terms', 'HomeController@terms')->name('terms');


/*
| BACK-END CONTROLLER
*/
Route::get('app/{any?}', 'AdminController@app')->where('any', '.*')->name('admin.app');




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
// Unauthenticated API Routes
// --------------------------------------------------------------------------------------------------------------------------


Route::get('api/check', 'Api\UserController@user');

// Related to Users pages
Route::get('api/profiles/{public}/pages', 'Api\ProfileController@pages')->name('profile.pages');

// Comments Listing
Route::get('api/categories/{category}/comments', 'Api\CategoryCommentController@index')->name('categorycomment.index');
Route::get('api/pages/{page}/comments', 'Api\PageCommentController@index')->name('pagecomment.index');

// Page Search Listing
Route::get('api/pages/search', 'Api\PageController@search')->name('pages.search');


// --------------------------------------------------------------------------------------------------------------------------
// Authenticated API Routes
// --------------------------------------------------------------------------------------------------------------------------
Route::prefix('api')->middleware(['auth'])->group(function () {


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
    Route::post('media/fetchUrl', 'Api\MediaController@uploadUrl')->name('media.uploadurl');
    Route::delete('media/{media}', 'Api\MediaController@remove')->name('media.remove');


    // --------------------------------------------------------------------------------------------------------------------------
    // Comments API
    // --------------------------------------------------------------------------------------------------------------------------
    Route::post('categories/{category}/comments', 'Api\CategoryCommentController@store')->name('categorycomment.store');
    Route::post('pages/{page}/comments', 'Api\PageCommentController@store')->name('pagecomment.store');


    // --------------------------------------------------------------------------------------------------------------------------
    // Users API
    // --------------------------------------------------------------------------------------------------------------------------

    // ProfileController methods are for non-admin users
    Route::patch('profile', 'Api\ProfileController@update')->name('profile.update');
    Route::get('profile/comments', 'Api\ProfileController@comments')->name('profile.comments');


    // UserController methods are strictly for the admin users.
    Route::get('users', 'Api\UserController@index')->name('users.index');
    Route::get('users/banned', 'Api\UserController@banned')->name('users.banned');
    Route::get('users/unverified', 'Api\UserController@unverified')->name('users.unverified');
    Route::get('users/{user}', 'Api\UserController@show')->name('users.show');
    Route::post('users', 'Api\UserController@store')->name('users.store');
    Route::put('users/{user}', 'Api\UserController@update')->name('users.update');
    Route::delete('users/{id}', 'Api\UserController@destroy')->name('users.destroy');
    Route::patch('users/password', 'Api\UserController@changePassword')->name('users.changepassword');
    Route::get('users/{user}/pages', 'Api\UserController@pages')->name('users.pages');
    Route::get('users/{user}/comments', 'Api\UserController@comments')->name('users.comments');



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
    Route::get('settings/social', 'Api\SettingController@getSocial')->name('settings.social');
    Route::get('settings/mail', 'Api\SettingController@getMail')->name('settings.mail');
    Route::post('settings/loginprovider', 'Api\SettingController@loginProvider')->name('settings.loginprovider');
    Route::post('settings/mailprovider', 'Api\SettingController@mailProvider')->name('settings.mailprovider');
    Route::get('settings/testmail', 'Api\SettingController@testMail')->name('settings.testmail');
    Route::post('settings/update', 'Api\SettingController@update')->name('settings.update');
    Route::get('settings/search', 'Api\SettingController@getSearch')->name('settings.search');
    Route::post('settings/searchprovider', 'Api\SettingController@searchProvider')->name('settings.searchprovider');



    // --------------------------------------------------------------------------------------------------------------------------
    // LOV API
    // --------------------------------------------------------------------------------------------------------------------------
    Route::get('lov/categories', 'Api\LovController@categories')->name('lov.categories');
    Route::get('lov/authors', 'Api\LovController@authors')->name('lov.authors');


});
