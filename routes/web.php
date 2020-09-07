<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/chart', function () {
//     return view('chart');
// });

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

// Route::view('/{path?}', 'app');

Route::get('payment', 'PaymentController@index');
Route::post('charge', 'PaymentController@charge');
Route::get('paymentsuccess', 'PaymentController@payment_success');
Route::get('paymenterror', 'PaymentController@payment_error');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/images', 'ImageController@getImages')->name('images');
Route::post('/upload', 'ImageController@postUpload')->name('uploadfile');