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

Route::prefix('api')->group(function () {
    // Laravel AUTH Routes
    // Auth::routes(['verify' => true]); 
    
    // Unauthenticated Routes
    Route::post('login', 'Api\Auth\LoginController@login');

    Route::get('categories', 'Api\CategoryController@index')->name('categories.index');
    Route::get('categories/{category}', 'Api\CategoryController@show')->name('categories.show');
    Route::get('categories/{category}/comments', 'Api\CategoryController@comments')->name('categories.comments');

    Route::get('pages', 'Api\PageController@index')->name('pages.index');
    Route::get('pages/{page}', 'Api\PageController@show')->name('pages.show');
    Route::get('pages/{page}/comments', 'Api\PageController@comments')->name('pages.comments');

    Route::get('comments/categories', 'Api\CategoryCommentController@index')->name('categorycomments.index');
    Route::get('comments/categories/{categorycomment}', 'Api\CategoryCommentController@show')->name('categorycomments.show');

    Route::get('comments/pages', 'Api\PageCommentController@index')->name('pagecomments.index');
    Route::get('comments/pages/{pagecomment}', 'Api\PageCommentController@show')->name('pagecomments.show');

    Route::get('users/comments', 'Api\ProfileController@comments')->name('users.comments');
    Route::get('users/{user}', 'Api\ProfileController@show')->name('users.show');

    // Authenticated Routes
    Route::post('logout', 'Api\Auth\LoginController@logout');

    Route::post('categories', 'Api\CategoryController@store')->name('categories.store');
    Route::put('categories/{category}', 'Api\CategoryController@update')->name('categories.update');
    Route::delete('categories/{category}', 'Api\CategoryController@destroy')->name('categories.destroy');

    Route::post('pages', 'Api\PageController@store')->name('pages.store');
    Route::put('pages/{page}', 'Api\PageController@update')->name('pages.update');
    Route::put('pages/{page}/status', 'Api\PageController@updateStatus')->name('pages.updatestatus');
    Route::put('pages/{page}/owner', 'Api\PageController@updateOwner')->name('pages.updateowner');
    Route::delete('pages/{page}', 'Api\PageController@destroy')->name('pages.destroy');

    Route::get('media', 'Api\MediaController@index')->name('media.index');
    Route::get('media/{media}', 'Api\MediaController@show')->name('media.show');
    Route::post('media', 'Api\MediaController@upload')->name('media.upload');
    Route::delete('media/{media}', 'Api\MediaController@remove')->name('media.remove');

    Route::post('comments/categories', 'Api\CategoryCommentController@store')->name('categorycomments.store');
    Route::put('comments/categories/{categorycomment}', 'Api\CategoryCommentController@update')->name('categorycomments.update');
    Route::delete('comments/categories/{categorycomment}', 'Api\CategoryCommentController@destroy')->name('categorycomments.destroy');
    Route::put('comments/categories/{categorycomment}/like', 'Api\CategoryCommentController@like')->name('categorycomments.like');
    Route::put('comments/categories/{categorycomment}/dislike', 'Api\CategoryCommentController@dislike')->name('categorycomments.dislike');

    Route::post('comments/pages', 'Api\PageCommentController@store')->name('pagecomments.store');
    Route::put('comments/pages/{pagecomment}', 'Api\PageCommentController@update')->name('pagecomments.update');
    Route::delete('comments/pages/{pagecomment}', 'Api\PageCommentController@destroy')->name('pagecomments.destroy');
    Route::put('comments/pages/{pagecomment}/like', 'Api\PageCommentController@like')->name('pagecomments.like');
    Route::put('comments/pages/{pagecomment}/dislike', 'Api\PageCommentController@dislike')->name('pagecomments.dislike');

    Route::put('users/{user}', 'Api\ProfileController@update')->name('users.update');
    Route::put('users/{user}/role', 'Api\ProfileController@updateRole')->name('users.updaterole');

    Route::get('lov/categories', 'Api\LovController@categories')->name('lov.categories');
    Route::get('lov/authors', 'Api\LovController@authors')->name('lov.authors');

});


// Frontend Routes
Route::get('pages', 'PageController@index')->name('pages.index');
Route::get('pages/{page}', 'PageController@show')->name('pages.show');

Route::get('categories', 'CategoryController@index')->name('categories.index');
Route::get('categories/{category}', 'CategoryController@show')->name('categories.show');



Route::get('social/login/{provider}', 'SocialLoginController@login')->name('social.login');
Route::get('social/login/{provider}/callback', 'SocialLoginController@callback')->name('social.callback');

//-----------------------------------------------------------------------------
// This is the main entry point for the SPA
// (This routes needs to be protected by Admin auth later)
//-----------------------------------------------------------------------------
Route::get('/app/{any}', 'AdminController@app')->where('any', '.*')->name('app');

// LATER REPLACE THIS ENDPOINT AT FRONTEND WITH media.upload named route
Route::post('/server/media/uploadFile', 'MediaController@upload');

Route::get('test', function () {
    $page = \App\Page::findOrFail(35);
    $content = $page->content;
    $body_json = $content->body_json;
    $body_html = \App\ContentConversion::getHtml($body_json);
    return $body_html;
});
