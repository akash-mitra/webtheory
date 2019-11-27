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

    Route::get('categories', 'CategoryController@index')->name('categories.index');
    Route::get('categories/{category}', 'CategoryController@show')->name('categories.show');

    Route::get('pages', 'PageController@index')->name('pages.index');
    Route::get('pages/{page}', 'PageController@show')->name('pages.show');


    // Authenticated
    Route::post('logout', 'LoginController@logout');
    
    Route::post('categories', 'CategoryController@store')->name('categories.store');
    Route::put('categories/{category}', 'CategoryController@update')->name('categories.update');
    Route::delete('categories/{category}', 'CategoryController@destroy')->name('categories.destroy');

    Route::post('pages', 'PageController@store')->name('pages.store');
    Route::put('pages/{page}', 'PageController@update')->name('pages.update');
    Route::delete('pages/{page}', 'PageController@destroy')->name('pages.destroy');

    Route::get('media', 'MediaController@index')->name('media.index');
    Route::get('media/{media}', 'MediaController@show')->name('media.show');
    Route::post('media', 'MediaController@upload')->name('media.upload');
    Route::delete('media/{media}', 'MediaController@remove')->name('media.remove');
});

// Route::get('/', function () {
//     return view('app');
// });

Route::get('/admin', 'AdminController@dashboard');

Route::get('/admin/pages/create', 'AdminPageController@create');

Route::post('/admin/media/uploadFile', 'MediaController@upload');