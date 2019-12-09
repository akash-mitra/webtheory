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

    Route::get('categories', 'CategoryController@index')->name('categories.index');
    Route::get('categories/{category}', 'CategoryController@show')->name('categories.show');
    Route::get('categories/{category}/comments', 'CategoryController@comments')->name('categories.comments');

    Route::get('pages', 'PageController@index')->name('pages.index');
    Route::get('pages/{page}', 'PageController@show')->name('pages.show');
    Route::get('pages/{page}/comments', 'PageController@comments')->name('pages.comments');

    Route::get('comments/categories', 'CategoryCommentController@index')->name('categorycomments.index');
    Route::get('comments/categories/{categorycomment}', 'CategoryCommentController@show')->name('categorycomments.show');

    Route::get('comments/pages', 'PageCommentController@index')->name('pagecomments.index');
    Route::get('comments/pages/{pagecomment}', 'PageCommentController@show')->name('pagecomments.show');

    // Authenticated Routes
    Route::post('logout', 'LoginController@logout');
    
    Route::post('categories', 'CategoryController@store')->name('categories.store');
    Route::put('categories/{category}', 'CategoryController@update')->name('categories.update');
    Route::delete('categories/{category}', 'CategoryController@destroy')->name('categories.destroy');

    Route::post('pages', 'PageController@store')->name('pages.store');
    Route::put('pages/{page}', 'PageController@update')->name('pages.update');
    Route::put('pages/{page}/status', 'PageController@updateStatus')->name('pages.updatestatus');
    Route::put('pages/{page}/owner', 'PageController@updateOwner')->name('pages.updateowner');
    Route::delete('pages/{page}', 'PageController@destroy')->name('pages.destroy');

    Route::get('media', 'MediaController@index')->name('media.index');
    Route::get('media/{media}', 'MediaController@show')->name('media.show');
    Route::post('media', 'MediaController@upload')->name('media.upload');
    Route::delete('media/{media}', 'MediaController@remove')->name('media.remove');

    Route::post('comments/categories', 'CategoryCommentController@store')->name('categorycomments.store');
    Route::put('comments/categories/{categorycomment}', 'CategoryCommentController@update')->name('categorycomments.update');
    Route::delete('comments/categories/{categorycomment}', 'CategoryCommentController@destroy')->name('categorycomments.destroy');
    Route::put('comments/categories/{categorycomment}/like', 'CategoryCommentController@like')->name('categorycomments.like');
    Route::put('comments/categories/{categorycomment}/dislike', 'CategoryCommentController@dislike')->name('categorycomments.dislike');

    Route::post('comments/pages', 'PageCommentController@store')->name('pagecomments.store');
    Route::put('comments/pages/{pagecomment}', 'PageCommentController@update')->name('pagecomments.update');
    Route::delete('comments/pages/{pagecomment}', 'PageCommentController@destroy')->name('pagecomments.destroy');
    Route::put('comments/pages/{pagecomment}/like', 'PageCommentController@like')->name('pagecomments.like');
    Route::put('comments/pages/{pagecomment}/dislike', 'PageCommentController@dislike')->name('pagecomments.dislike');

    Route::get('users/comments', 'ProfileController@comments')->name('users.comments');

    Route::get('lov/categories', 'LovController@categories')->name('lov.categories');
    Route::get('lov/authors', 'LovController@authors')->name('lov.authors');

});




//-----------------------------------------------------------------------------
// This is the main entry point for the SPA
// (This routes needs to be protected by Admin auth later)
//-----------------------------------------------------------------------------
Route::get('/app/{any}', 'AdminController@app')->where('any', '.*')->name('app');

