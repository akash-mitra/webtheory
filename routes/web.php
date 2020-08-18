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
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name(
    'verification.verify'
);
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

/*
| FORGET PASSWORD RELATED ROUTES
*/
// Process the incoming password reset request.
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name(
    'password.email'
);

// Show reset password form.
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name(
    'password.reset'
);

// Post a reset password request.
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

/*
| SOCIAL AUTHENTICATION RELATED ROUTES
*/
Route::get('social/login/{provider}', 'Auth\SocialLoginController@login')->name('social.login');
Route::get('social/login/{provider}/callback', 'Auth\SocialLoginController@callback')->name(
    'social.callback'
);

/*
| FRONT-END RELATED ROUTES
*/
Route::get('/', 'HomeController@root')->name('home');
Route::get('blog', 'HomeController@blog')->name('blog');
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
Route::get('app/{any?}', 'AdminController@app')
    ->where('any', '.*')
    ->name('admin.app');

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

// Related to Users pages
Route::get('api/profiles/{public}/pages', 'Api\ProfileController@pages')->name('profile.pages');

// Comments Listing
Route::get('api/categories/{category}/comments', 'Api\CategoryCommentController@index')->name(
    'categorycomment.index'
);
Route::get('api/pages/{page}/comments', 'Api\PageCommentController@index')->name(
    'pagecomment.index'
);

// Page Search Listing
Route::get('api/pages/search', 'Api\PageController@search')->name('pages.search');

// Form Response
Route::post('api/forms/{form}/response', 'Api\FormController@storeResponse')->name(
    'forms.storeresponse'
);

// --------------------------------------------------------------------------------------------------------------------------
// Authenticated API Routes
// --------------------------------------------------------------------------------------------------------------------------
Route::prefix('api')
    ->middleware(['auth'])
    ->group(function () {
        // --------------------------------------------------------------------------------------------------------------------------
        // Categories API
        // --------------------------------------------------------------------------------------------------------------------------
        Route::get('categories', 'Api\CategoryController@index')->name('categories.index');
        Route::get('categories/{category}', 'Api\CategoryController@show')->name('categories.show');
        Route::get('categories/{category}/pages', 'Api\CategoryController@pages')->name(
            'categories.pages'
        );
        Route::post('categories', 'Api\CategoryController@store')->name('categories.store');
        Route::put('categories/{category}', 'Api\CategoryController@update')->name(
            'categories.update'
        );
        Route::delete('categories/{category}', 'Api\CategoryController@destroy')->name(
            'categories.destroy'
        );

        // --------------------------------------------------------------------------------------------------------------------------
        // Pages API
        // --------------------------------------------------------------------------------------------------------------------------
        Route::get('pages', 'Api\PageController@index')->name('pages.index');
        Route::get('pages/{page}', 'Api\PageController@show')->name('pages.show');
        Route::post('pages', 'Api\PageController@store')->name('pages.store');
        Route::put('pages/{page}', 'Api\PageController@update')->name('pages.update');
        Route::put('pages/{page}/status', 'Api\PageController@updateStatus')->name(
            'pages.updatestatus'
        );
        Route::put('pages/{page}/owner', 'Api\PageController@updateOwner')->name(
            'pages.updateowner'
        );
        Route::delete('pages/{page}', 'Api\PageController@destroy')->name('pages.destroy');
        Route::delete('pagecontent/{pageContent}', 'Api\PageController@destroyContent')->name(
            'pages.destroycontent'
        );

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
        Route::post('categories/{category}/comments', 'Api\CategoryCommentController@store')->name(
            'categorycomment.store'
        );
        Route::post('pages/{page}/comments', 'Api\PageCommentController@store')->name(
            'pagecomment.store'
        );

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
        Route::patch('users/password', 'Api\UserController@changePassword')->name(
            'users.changepassword'
        );
        Route::get('users/{user}/pages', 'Api\UserController@pages')->name('users.pages');
        Route::get('users/{user}/comments', 'Api\UserController@comments')->name('users.comments');

        // --------------------------------------------------------------------------------------------------------------------------
        // Templates Management API
        // --------------------------------------------------------------------------------------------------------------------------
        Route::get('templates', 'Api\TemplateController@index')->name('templates.index');
        Route::get('templates/{template}', 'Api\TemplateController@show')->name('templates.show');
        Route::get('templates/{template}/download', 'Api\TemplateController@download')->name(
            'templates.download'
        );
        Route::post('templates/upload', 'Api\TemplateController@upload')->name('templates.upload');
        Route::post('templates', 'Api\TemplateController@store')->name('templates.store');

        Route::post('templates/{template}/add', 'Api\TemplateController@add')->name(
            'templates.add'
        );
        Route::post('templates/{template}/remove', 'Api\TemplateController@remove')->name(
            'templates.remove'
        );
        Route::get('templates/{template}/get/{file}', 'Api\TemplateController@get')->name(
            'templates.get'
        );

        Route::post('templates/{template}/activate', 'Api\TemplateController@activate')->name(
            'templates.activate'
        );
        Route::patch('templates/{template}', 'Api\TemplateController@update')->name(
            'templates.update'
        );
        Route::delete('templates/{template}', 'Api\TemplateController@destroy')->name(
            'templates.destroy'
        );
        Route::post('templates/{template}/duplicate', 'Api\TemplateController@duplicate')->name(
            'templates.duplicate'
        );
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
        Route::post('settings/loginprovider', 'Api\SettingController@loginProvider')->name(
            'settings.loginprovider'
        );
        Route::post('settings/mailprovider', 'Api\SettingController@mailProvider')->name(
            'settings.mailprovider'
        );
        Route::get('settings/testmail', 'Api\SettingController@testMail')->name(
            'settings.testmail'
        );
        Route::post('settings/update', 'Api\SettingController@update')->name('settings.update');
        Route::get('settings/search', 'Api\SettingController@getSearch')->name('settings.search');
        Route::post('settings/searchprovider', 'Api\SettingController@searchProvider')->name(
            'settings.searchprovider'
        );
        Route::get('settings/backup/download', 'Api\SettingController@backupDownload')->name(
            'settings.backupdownload'
        );

        // --------------------------------------------------------------------------------------------------------------------------
        // LOV API
        // --------------------------------------------------------------------------------------------------------------------------
        Route::get('lov/categories', 'Api\LovController@categories')->name('lov.categories');
        Route::get('lov/authors', 'Api\LovController@authors')->name('lov.authors');

        // --------------------------------------------------------------------------------------------------------------------------
        // Forms API
        // --------------------------------------------------------------------------------------------------------------------------
        Route::get('forms', 'Api\FormController@index')->name('forms.index');
        Route::get('forms/{form}', 'Api\FormController@show')->name('forms.show');
        Route::post('forms', 'Api\FormController@store')->name('forms.store');
        Route::put('forms/{form}', 'Api\FormController@update')->name('forms.update');
        Route::delete('forms/{form}', 'Api\FormController@destroy')->name('forms.destroy');
        Route::get('forms/{form}/responses', 'Api\FormController@formResponses')->name(
            'forms.responses'
        );
        // Route::get('formresponses/{formresponse}', 'Api\FormController@formResponse')->name('forms.response');
        Route::get(
            'forms/{form}/responses/download',
            'Api\FormController@formResponsesDownload'
        )->name('forms.responsesdownload');

        // --------------------------------------------------------------------------------------------------------------------------
        // Dashboard API
        // --------------------------------------------------------------------------------------------------------------------------
        Route::get('dashboard/pages-count', 'Api\DashboardController@pagesCount')->name(
            'dashboard.pages-count'
        );
        Route::get('dashboard/users-count', 'Api\DashboardController@usersCount')->name(
            'dashboard.users-count'
        );
        Route::get('dashboard/top-comments', 'Api\DashboardController@topComments')->name(
            'dashboard.topcomments'
        );
        Route::post('dashboard/clearcache', 'Api\DashboardController@clearCache')->name(
            'dashboard.clearcache'
        );

        Route::get('dashboard/views/daily', 'Api\DashboardController@viewsdaily')->name(
            'dashboard.viewsdaily'
        );
        Route::get('dashboard/views/monthly', 'Api\DashboardController@viewsmonthly')->name(
            'dashboard.viewsmonthly'
        );
        Route::get('dashboard/unique/monthly', 'Api\DashboardController@uniquemonthly')->name(
            'dashboard.uniquemonthly'
        );
        Route::get('dashboard/content', 'Api\DashboardController@content')->name(
            'dashboard.content'
        );
        Route::get('dashboard/referrer', 'Api\DashboardController@referrer')->name(
            'dashboard.referrer'
        );
        Route::get('dashboard/platform', 'Api\DashboardController@platform')->name(
            'dashboard.platform'
        );
        Route::get('dashboard/browser', 'Api\DashboardController@browser')->name(
            'dashboard.browser'
        );
        Route::get('dashboard/country', 'Api\DashboardController@country')->name(
            'dashboard.country'
        );
        Route::get('dashboard/city', 'Api\DashboardController@city')->name('dashboard.city');
    });

// This is a catchall route.
// This is required to direct load any blade file based on URL
Route::any('/{any}', 'HomeController@catchAll')->where('any', '.*');
