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
    // Unauthenticated Routes
    Route::post('login', 'LoginController@login');

    Route::get('categories', 'CategoryController@index')->name('api.categories.index');
    Route::get('categories/{category}', 'CategoryController@show')->name('api.categories.show');
    Route::get('categories/{category}/comments', 'CategoryController@comments')->name('api.categories.comments');

    Route::get('pages', 'PageController@index')->name('api.pages.index');
    Route::get('pages/{page}', 'PageController@show')->name('api.pages.show');
    Route::get('pages/{page}/comments', 'PageController@comments')->name('api.pages.comments');

    Route::get('comments/categories', 'CategoryCommentController@index')->name('api.categorycomments.index');
    Route::get('comments/categories/{categorycomment}', 'CategoryCommentController@show')->name('api.categorycomments.show');

    Route::get('comments/pages', 'PageCommentController@index')->name('api.pagecomments.index');
    Route::get('comments/pages/{pagecomment}', 'PageCommentController@show')->name('api.pagecomments.show');

    // Authenticated Routes
    Route::post('logout', 'LoginController@logout');
    
    Route::post('categories', 'CategoryController@store')->name('api.categories.store');
    Route::put('categories/{category}', 'CategoryController@update')->name('api.categories.update');
    Route::delete('categories/{category}', 'CategoryController@destroy')->name('api.categories.destroy');

    Route::post('pages', 'PageController@store')->name('api.pages.store');
    Route::put('pages/{page}', 'PageController@update')->name('api.pages.update');
    Route::put('pages/{page}/status', 'PageController@updateStatus')->name('api.pages.updatestatus');
    Route::put('pages/{page}/owner', 'PageController@updateOwner')->name('api.pages.updateowner');
    Route::delete('pages/{page}', 'PageController@destroy')->name('api.pages.destroy');

    Route::get('media', 'MediaController@index')->name('api.media.index');
    Route::get('media/{media}', 'MediaController@show')->name('api.media.show');
    Route::post('media', 'MediaController@upload')->name('api.media.upload');
    Route::delete('media/{media}', 'MediaController@remove')->name('api.media.remove');

    Route::post('comments/categories', 'CategoryCommentController@store')->name('api.categorycomments.store');
    Route::put('comments/categories/{categorycomment}', 'CategoryCommentController@update')->name('api.categorycomments.update');
    Route::delete('comments/categories/{categorycomment}', 'CategoryCommentController@destroy')->name('api.categorycomments.destroy');
    Route::put('comments/categories/{categorycomment}/like', 'CategoryCommentController@like')->name('api.categorycomments.like');
    Route::put('comments/categories/{categorycomment}/dislike', 'CategoryCommentController@dislike')->name('api.categorycomments.dislike');

    Route::post('comments/pages', 'PageCommentController@store')->name('api.pagecomments.store');
    Route::put('comments/pages/{pagecomment}', 'PageCommentController@update')->name('api.pagecomments.update');
    Route::delete('comments/pages/{pagecomment}', 'PageCommentController@destroy')->name('api.pagecomments.destroy');
    Route::put('comments/pages/{pagecomment}/like', 'PageCommentController@like')->name('api.pagecomments.like');
    Route::put('comments/pages/{pagecomment}/dislike', 'PageCommentController@dislike')->name('api.pagecomments.dislike');

    Route::get('users/comments', 'ProfileController@comments')->name('api.users.comments');

    Route::get('lov/categories', 'LovController@categories')->name('api.lov.categories');
    Route::get('lov/authors', 'LovController@authors')->name('api.lov.authors');

});




//-----------------------------------------------------------------------------
// This is the main entry point for the SPA
// (This routes needs to be protected by Admin auth later)
//-----------------------------------------------------------------------------
Route::get('/app/{any}', 'AdminController@app')->where('any', '.*')->name('app');




//-----------------------------------------------------------------------------
// 
Route::post('/server/media/uploadFile', 'MediaController@upload');