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
Route::post('/register', 'Auth\RegisterController@register')->name('register');
Route::get('/email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');


/*
| FORGET PASSWORD RELATED ROUTES
*/
// Process the incoming password reset request.
Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

// Show reset password form.
Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

// Post a reset password request.
Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');


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
Route::get('/app/{any?}', 'AdminController@app')->where('any', '.*')->name('admin.app');
