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
    // Unauthenticated
    Route::post('login', 'LoginController@login');

    Route::get('categories', 'CategoryController@index')->name('api.categories.index');
    Route::get('categories/{category}', 'CategoryController@show')->name('api.categories.show');

    Route::get('pages', 'PageController@index')->name('api.pages.index');
    Route::get('pages/{page}', 'PageController@show')->name('api.pages.show');


    // Authenticated
    Route::post('logout', 'LoginController@logout');
    
    Route::post('categories', 'CategoryController@store')->name('api.categories.store');
    Route::put('categories/{category}', 'CategoryController@update')->name('api.categories.update');
    Route::delete('categories/{category}', 'CategoryController@destroy')->name('api.categories.destroy');

    Route::post('pages', 'PageController@store')->name('api.pages.store');
    Route::put('pages/{page}', 'PageController@update')->name('api.pages.update');
    Route::delete('pages/{page}', 'PageController@destroy')->name('api.pages.destroy');

    Route::get('media', 'MediaController@index')->name('api.media.index');
    Route::get('media/{media}', 'MediaController@show')->name('api.media.show');
    Route::post('media', 'MediaController@upload')->name('api.media.upload');
    Route::delete('media/{media}', 'MediaController@remove')->name('api.media.remove');
});

// Route::get('/', function () {
//     return view('app');
// });

Route::get('/admin', 'AdminController@dashboard');

Route::get('/admin/pages/create', 'AdminPageController@create');

Route::post('/admin/media/uploadFile', 'MediaController@upload');