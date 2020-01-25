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

//routes for sandbox demos
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

Route::get('/landing', function () {
    return view('landingPage');
});

Route::get('/recover', function () {
    return view('recover');
});

Route::post('/postRecoveryLogin', [
    'uses' => 'AjaxController@postRecoveryLogin',
    'as' => 'recoveryLogin'
]);


//standard route group
Route::group(['middleware' => ['web']], function () {
    Route::post('/register',[
        'uses' => 'UserController@postRegister',
        'as' => 'register'
    ]);

    Route::post('login', [
        'uses' => 'UserController@postLogin',
        'as' => 'login'
    ]);

    Route::get('/logout',[
        'uses' => 'UserController@getLogout',
        'as' => 'logout'
    ]);
});

//protected routes that require authorisation
Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/dashboard', [
        'uses' => 'StoredPasswordController@getDashboard',
        'as' => 'dashboard'
    ]);

    Route::get('/generateBackup', [
        'uses' => 'BackupController@getCreateBackup',
        'as' => 'backup'
    ]);

    Route::post('/postAjaxVerifyPassword', [
        'uses' => 'AjaxController@postVerifyPassword',
        'as' => 'verify'
    ]);

    Route::post('/postAjaxMasterHash', [
        'uses' => 'AjaxController@postMasterHash',
        'as' => 'postMasterHash'
    ]);

    Route::post('/postAjaxAddStoredPassword', [
        'uses' => 'AjaxController@postAddStoredPassword',
        'as' => 'postAddPassword'
    ]);

    Route::post('/postAjaxDeleteStoredPassword', [
        'uses' => 'AjaxController@postDeleteStoredPassword',
        'as' => 'postDeletePassword'
    ]);

    Route::post('/postAjaxEditStoredPassword', [
        'uses' => 'AjaxController@postEditStoredPassword',
        'as' => 'postEditPassword'
    ]);

    Route::post('/postAjaxChangeAccountPassword', [
        'uses' => 'AjaxController@postChangeAccountPassword',
        'as' => 'postChangePassword'
    ]);
});
