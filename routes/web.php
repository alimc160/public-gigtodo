<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
//    broadcast(new \App\Events\WebsocketDemoEvent());
    return view('index');
});
Route::get('/t', function () {
    event(new \App\Events\WebsocketDemoEvent());
    dd('Event Run Successfully.');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/forget-password',[\App\Http\Controllers\Api\UserController::class,'forgetPasswordView'])->name('forget.password.view');
Route::post('/forget-password',[\App\Http\Controllers\Auth\ResetPasswordController::class,'resetPassword'])->name('update.password');
Route::get('auth/google', [\App\Http\Controllers\Auth\LoginController::class,'redirectToGoogle']);
Route::get('auth/google/callback',[\App\Http\Controllers\Auth\LoginController::class,'handleGoogleCallback']);
