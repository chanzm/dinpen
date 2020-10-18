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

Route::get('app/images/{path_file?}/{slug}', [
     'as'         => 'image.show',
     'uses'       => 'DirectoryController@show',
     'middleware' => 'auth',
]);

Route::get('app/images/{slug}', [
     'as'         => 'image.show',
     'uses'       => 'DirectoryController@show2',
     'middleware' => 'auth',
]);

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/hai', function () {
    return view('welcome');
});

Route::get('/directory/{path_file?}', 'DirectoryController@index')->name('storage');

Route::get('/image/{path_file?}', 'DirectoryController@foto')->name('image');
Route::get('/image_train/{path_file?}', 'DirectoryController@foto_trained')->name('image2');

Route::post('/directory/deleteImage', 'DirectoryController@destroy');
Route::post('/directory/verifImage', 'DirectoryController@store');
Route::post('/directory/trainImage', 'DirectoryController@destroy');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/webtrain/{id}','AllController@webtrain');

