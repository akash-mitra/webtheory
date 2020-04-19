<?php
use Illuminate\Support\Facades\Mail;

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

// Frontend Routes

/*
|--------------------------------------------------------------------------
| AUTHENTICATION RELATED ROUTES
|--------------------------------------------------------------------------
*/

// Only keep the relevant routes to avoid unused route endpoints.
// Auth::routes(['verify' => true]);

Route::post('/register', 'Auth\RegisterController@register')->name('register');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
// below 2 routes will be needed when we have the email issue sorted
// Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
// Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::post('/password/change', 'Api\UserController@changePassword')->name('password.change');

Route::get('social/login/{provider}', 'Auth\SocialLoginController@login')->name('social.login');
Route::get('social/login/{provider}/callback', 'Auth\SocialLoginController@callback')->name('social.callback');
Route::get('ui/email/verify/{id}', function () { return 1; })->name('ui-email.verificationlink');



Route::get('/', 'HomeController@root')->name('root');
Route::get('pages/{page}/{slug?}', 'HomeController@single')->name('pages.show');
Route::get('categories/{category}/{slug?}', 'HomeController@category')->name('categories.show');
Route::get('sitemap', 'HomeController@sitemap')->name('sitemap');
Route::get('rss', 'HomeController@rss')->name('rss');


//-----------------------------------------------------------------------------
// This is the main entry point for the SPA
// (This routes needs to be protected by Admin auth later)
//-----------------------------------------------------------------------------
Route::get('/app/{any?}', 'AdminController@app')->where('any', '.*')->name('admin.app');


// Testing Route
// Route::get('test', function () {
//     $page = \App\Page::findOrFail(35);
//     $content = $page->content;
//     $body_json = $content->body_json;
//     $body_html = \App\ContentConversion::getHtml($body_json);
//     return $body_html;
// });

// all cache keys - to be removed later
Route::get('cache/keys', function () {
    return App\DataProvider::keys();
});

Route::get('test', function () {
    $data = array('name'=>"Virat Gandhi");
   
      Mail::send(['text'=>'mail'], $data, function($message) {
         $message->to('abc@gmail.com', 'Tutorials Point')->subject
            ('Laravel Basic Testing Mail');
      });
    return;
});