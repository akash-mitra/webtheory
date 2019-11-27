<?php

use Illuminate\Http\Request;

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

/*
Route::group(['middleware' => ['cors']], function () {
    Route::post('login', 'LoginController@login');

    Route::get('categories', 'CategoryController@index')->name('categories.index');
    Route::get('categories/{category}', 'CategoryController@show')->name('categories.show');

    Route::get('pages', 'PageController@index')->name('pages.index');
    Route::get('pages/{page}', 'PageController@show')->name('pages.show');
});


Route::group(['middleware' => ['auth:api', 'cors']], function () {
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

*/


// Route::apiResources([
//     'categories' => 'CategoryController',
// ]);

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::post('/pages', function (Request $req) {
//     return $req->input();
// })->name('api.pages.store');