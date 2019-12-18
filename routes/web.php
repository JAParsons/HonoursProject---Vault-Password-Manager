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

//use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/scan', function () {
    return view('scan');
});

Route::get('/gen', function () {
    return view('generate');
});

Route::get('/aes', function () {
    return view('aes');
});

Route::get('/ssss', function () {
    return view('ssss');
});

Route::get('/login', function () {
    return view('login');
});

Route::group(['middleware' => ['web']], function () {
    Route::get('/dashboard', [
        'uses' => 'StoredPasswordController@getDashboard',
        'as' => 'dashboard',
        'middleware' => 'auth'
    ]);

    Route::post('/register',[
        'uses' => 'UserController@postRegister',
        'as' => 'register'
    ]);

    Route::post('login', [
        'uses' => 'UserController@postLogin',
        'as' => 'login'
    ]);
});
