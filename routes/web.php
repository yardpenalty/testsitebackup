<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
Route::get('/demo', function () {
   return view('demo');
});
|
*/

Route::get('/', function () {
    return view('demo');
});

Route::get('user/{id}', 'UserController@profile');
Route::get('article/{id}', 'ArticleController@index');
Route::resource('articles', 'ArticleController');
Route::resource('download', 'DownloadController');
Route::get('/download/', 'DownloadController@index');