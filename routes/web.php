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

// Frontend Routes
Route::get('/', 'HomeController@root')->name('root');
Route::get('/home', 'HomeController@home')->name('home');

Auth::routes(['verify' => true]);

Route::get('pages', 'PageController@index')->name('pages.index');
Route::get('pages/{page}', 'PageController@show')->name('pages.show');

Route::get('categories', 'CategoryController@index')->name('categories.index');
Route::get('categories/{category}', 'CategoryController@show')->name('categories.show');


Route::get('social/login/{provider}', 'Auth\SocialLoginController@login')->name('social.login');
Route::get('social/login/{provider}/callback', 'Auth\SocialLoginController@callback')->name('social.callback');

Route::get('ui/email/verify/{id}', function () { return 1; })->name('ui-email.verificationlink');


//-----------------------------------------------------------------------------
// This is the main entry point for the SPA
// (This routes needs to be protected by Admin auth later)
//-----------------------------------------------------------------------------
Route::get('/app/{any}', 'AdminController@app')->where('any', '.*')->name('app');


// Testing Route
Route::get('test', function () {
    $page = \App\Page::findOrFail(35);
    $content = $page->content;
    $body_json = $content->body_json;
    $body_html = \App\ContentConversion::getHtml($body_json);
    return $body_html;
});
