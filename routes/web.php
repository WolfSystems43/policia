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

Route::get('/', function () {
    return view('welcome');
});

// Desactivadas para activar la ruta de Steam
// Auth::routes();

Route::get('/login', 'AuthController@login')->name('login');
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'post'], function() {
	Route::get('/new', 'PostController@newForm');
	Route::post('/new', 'PostController@new');
});

Route::get('/lista', 'UsersController@users')->name('users');

Route::get('/about', 'HomeController@about')->name('about');
