<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\AssetController;
use App\Http\Controllers\Api\CategoryCommentController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\FormController;
use App\Http\Controllers\Api\LovController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\PageCommentController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\ParameterController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\TemplateController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\Google2FAController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\HomeController;

/*----------------------------------------------------------------------------------------------------------------------
| PUBLIC ROUTES
----------------------------------------------------------------------------------------------------------------------*/

// NATIVE AUTHENTICATION RELATED ROUTES
Route::post('register', [RegisterController::class, 'register'])->name('register');
Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


// SOCIAL AUTHENTICATION RELATED ROUTES
Route::get('social/login/{provider}', [SocialLoginController::class, 'login'])->name('social.login');
Route::get('social/login/{provider}/callback', [SocialLoginController::class, 'callback'])->name('social.callback');


// 2FA RELATED ROUTES
Route::post('2fa/enable', [Google2FAController::class, 'enable'])->name('google2fa.enable');
Route::get('2fa/validate', [LoginController::class, 'getToken'])->name('google2fa.token');
Route::post('2fa/validate', ['middleware' => 'throttle:5', 'uses' => [LoginController::class, 'validateToken']])->name('google2fa.validate');
Route::post('2fa/disable', [Google2FAController::class, 'disable'])->name('google2fa.disable');


// FRONT-END BLOG ROUTES
Route::get('/', [HomeController::class, 'root'])->name('home');
Route::get('blog', [HomeController::class, 'blog'])->name('blog');
Route::get('pages/{page}/{slug?}', [HomeController::class, 'single'])->name('pages');
Route::get('categories/{category}/{slug?}', [HomeController::class, 'category'])->name('categories');
Route::get('profiles/{public_id}', [HomeController::class, 'profile'])->name('profile.show');
Route::get('forms/{form}/{slug?}', [HomeController::class, 'form'])->name('forms');


// FRONT-END PREDEFINED ROUTES
Route::get('sitemap', [HomeController::class, 'sitemap'])->name('sitemap');
Route::get('rss', [HomeController::class, 'rss'])->name('rss');
Route::get('privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('terms', [HomeController::class, 'terms'])->name('terms');

// BACK-END ACCESS ROUTE
Route::get('app/{any?}', [AdminController::class, 'app'])->where('any', '.*')->name('admin.app');


// PUBLIC API
Route::get('api/profiles/{public}/pages', [ProfileController::class, 'pages'])->name('profile.pages');
Route::get('api/categories/{category}/comments', [CategoryCommentController::class, 'index'])->name('categorycomment.index');
Route::get('api/pages/{page}/comments', [PageCommentController::class, 'index'])->name('pagecomment.index');
Route::get('api/pages/search', [PageController::class, 'search'])->name('pages.search');
Route::post('api/forms/{form}/response', [FormController::class, 'storeResponse'])->name('forms.storeresponse');



/*----------------------------------------------------------------------------------------------------------------------
| PUBLIC ROUTES
----------------------------------------------------------------------------------------------------------------------*/

Route::prefix('api')
    ->middleware(['auth'])
    ->group(function () {
        // --------------------------------------------------------------------------------------------------------------------------
        // Categories API
        // --------------------------------------------------------------------------------------------------------------------------
        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
        Route::get('categories/{category}/pages', [CategoryController::class, 'pages'])->name('categories.pages');
        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');



        // Pages API
        // --------------------------------------------------------------------------------------------------------------------------
        Route::get('pages', [PageController::class, 'index'])->name('pages.index');
        Route::get('pages/{page}', [PageController::class, 'show'])->name('pages.show');
        Route::post('pages', [PageController::class, 'store'])->name('pages.store');
        Route::put('pages/{page}', [PageController::class, 'update'])->name('pages.update');
        Route::put('pages/{page}/status', [PageController::class, 'updateStatus'])->name('pages.updatestatus');
        Route::put('pages/{page}/owner', [PageController::class, 'updateOwner'])->name('pages.updateowner');
        Route::delete('pages/{page}', [PageController::class, 'destroy'])->name('pages.destroy');
        Route::delete('pagecontent/{pageContent}', [PageController::class, 'destroyContent'])->name('pages.destroycontent');


        // Asset API
        // --------------------------------------------------------------------------------------------------------------------------
        Route::get('media', [AssetController:: class, 'index'])->name('media.index');
        Route::get('media/{asset}', [AssetController:: class, 'show'])->name('media.show');
        Route::post('media', [AssetController:: class, 'upload'])->name('media.upload');
        Route::post('media/fetchUrl', [AssetController:: class, 'fetch'])->name('media.uploadurl');
        Route::delete('media/{asset}', [AssetController:: class, 'remove'])->name('media.remove');


        // Comments API
        // --------------------------------------------------------------------------------------------------------------------------
        Route::post('categories/{category}/comments', [CategoryCommentController::class, 'store'])->name('categorycomment.store');
        Route::post('pages/{page}/comments', [PageCommentController::class, 'store'])->name('pagecomment.store');


        // Users API
        // --------------------------------------------------------------------------------------------------------------------------

        // ProfileController methods are for non-admin users
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('profile/comments', [ProfileController::class, 'comments'])->name('profile.comments');

        // UserController methods are strictly for the admin users.
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/banned', [UserController::class, 'banned'])->name('users.banned');
        Route::get('users/unverified', [UserController::class, 'unverified'])->name('users.unverified');
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::put('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
        Route::patch('users/password', [UserController::class, 'changePassword'])->name('users.changepassword');
        Route::get('users/{user}/pages', [UserController::class, 'pages'])->name('users.pages');
        Route::get('users/{user}/comments', [UserController::class, 'comments'])->name('users.comments');


        // Templates Management API
        // --------------------------------------------------------------------------------------------------------------------------
        Route::get('templates', [TemplateController::class, 'index'])->name('templates.index');
        Route::get('templates/{template}', [TemplateController::class, 'show'])->name('templates.show');
        Route::get('templates/{template}/download', [TemplateController::class, 'download'])->name('templates.download');
        Route::post('templates/upload', [TemplateController::class, 'upload'])->name('templates.upload');
        Route::post('templates', [TemplateController::class, 'store'])->name('templates.store');
        Route::post('templates/{template}/add', [TemplateController::class, 'add'])->name('templates.add');
        Route::post('templates/{template}/remove', [TemplateController::class, 'remove'])->name('templates.remove');
        Route::get('templates/{template}/get/{file}', [TemplateController::class, 'get'])->name('templates.get');
        Route::post('templates/{template}/activate', [TemplateController::class, 'activate'])->name('templates.activate');
        Route::patch('templates/{template}', [TemplateController::class, 'update'])->name('templates.update');
        Route::delete('templates/{template}', [TemplateController::class, 'destroy'])->name('templates.destroy');
        Route::post('templates/{template}/duplicate', [TemplateController::class, 'duplicate'])->name('templates.duplicate');
        Route::post('templates/import', [TemplateController::class, 'import'])->name('templates.import');


        // Parameters API
        // --------------------------------------------------------------------------------------------------------------------------
        Route::get('parameters/{key}', [ParameterController::class, 'get'])->name('parameters.get');
        Route::post('parameters/{key}', [ParameterController::class, 'set'])->name('parameters.set');


        // Settings API
        // --------------------------------------------------------------------------------------------------------------------------
        Route::get('settings/social', [SettingController::class, 'getSocial'])->name('settings.social');
        Route::get('settings/mail', [SettingController::class, 'getMail'])->name('settings.mail');
        Route::post('settings/loginprovider', [SettingController::class, 'loginProvider'])->name('settings.loginprovider');
        Route::post('settings/mailprovider', [SettingController::class, 'mailProvider'])->name('settings.mailprovider');
        Route::get('settings/testmail', [SettingController::class, 'testMail'])->name('settings.testmail');
        Route::post('settings/update', [SettingController::class, 'update'])->name('settings.update');
        Route::get('settings/search', [SettingController::class, 'getSearch'])->name('settings.search');
        Route::post('settings/searchprovider', [SettingController::class, 'searchProvider'])->name('settings.searchprovider');
        Route::get('settings/backup/download', [SettingController::class, 'backupDownload'])->name('settings.backupdownload');


        // LOV API
        // --------------------------------------------------------------------------------------------------------------------------
        Route::get('lov/categories', [LovController::class, 'categories'])->name('lov.categories');
        Route::get('lov/authors', [LovController::class, 'authors'])->name('lov.authors');


        // Forms API
        // --------------------------------------------------------------------------------------------------------------------------
        Route::get('forms', [FormController::class, 'index'])->name('forms.index');
        Route::get('forms/{form}', [FormController::class, 'show'])->name('forms.show');
        Route::post('forms', [FormController::class, 'store'])->name('forms.store');
        Route::put('forms/{form}', [FormController::class, 'update'])->name('forms.update');
        Route::delete('forms/{form}', [FormController::class, 'destroy'])->name('forms.destroy');
        Route::get('forms/{form}/responses', [FormController::class, 'formResponses'])->name('forms.responses');
        // Route::get('formresponses/{formresponse}', [FormController::class, 'formResponse'])->name('forms.response');
        Route::get('forms/{form}/responses/download', [FormController::class, 'formResponsesDownload'])->name('forms.responsesdownload');


        // Dashboard API
        // --------------------------------------------------------------------------------------------------------------------------
        Route::get('dashboard/pages-count', [DashboardController::class, 'pagesCount'])->name('dashboard.pages-count');
        Route::get('dashboard/users-count', [DashboardController::class, 'usersCount'])->name('dashboard.users-count');
        Route::get('dashboard/top-comments', [DashboardController::class, 'topComments'])->name('dashboard.topcomments');
        Route::post('dashboard/clearcache', [DashboardController::class, 'clearCache'])->name('dashboard.clearcache');
        Route::get('dashboard/views/daily', [DashboardController::class, 'viewsdaily'])->name('dashboard.viewsdaily');
        Route::get('dashboard/views/monthly', [DashboardController::class, 'viewsmonthly'])->name('dashboard.viewsmonthly');
        Route::get('dashboard/unique/monthly', [DashboardController::class, 'uniquemonthly'])->name('dashboard.uniquemonthly');
        Route::get('dashboard/content', [DashboardController::class, 'content'])->name('dashboard.content');
        Route::get('dashboard/referrer', [DashboardController::class, 'referrer'])->name('dashboard.referrer');
        Route::get('dashboard/platform', [DashboardController::class, 'platform'])->name('dashboard.platform');
        Route::get('dashboard/browser', [DashboardController::class, 'browser'])->name('dashboard.browser');
        Route::get('dashboard/country', [DashboardController::class, 'country'])->name('dashboard.country');
        Route::get('dashboard/city', [DashboardController::class, 'city'])->name('dashboard.city');


        // Menus API
        // --------------------------------------------------------------------------------------------------------------------------
        Route::get('menus', [MenuController::class, 'index'])->name('menus.index');
        Route::get('menus/{menu}', [MenuController::class, 'show'])->name('menus.show');
        Route::post('menus', [MenuController::class, 'upsert'])->name('menus.upsert');
        Route::delete('menus/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');
    });



/*----------------------------------------------------------------------------------------------------------------------
| PUBLIC CATCH ALL ROUTE
----------------------------------------------------------------------------------------------------------------------*/

// This is required to dynamically load any blade file based on URL
Route::any('/{any}', [HomeController::class, 'catchAll'])->where('any', '.*');
