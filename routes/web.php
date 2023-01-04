<?php

use App\Http\Controllers\AuthController;
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

Route::get('/', function () { return view('welcome'); })->name('home');
Route::get('/procedure', function () { return view('procedure'); })->name('procedure');
Route::get('/connect', function () { return view('connect'); })->name('link');

Route::controller(AuthController::class)
    ->group(function () {
        Route::get('login', 'login')->name('login');
        Route::post('logout', 'logout')->name('logout');
        Route::get('/auth/discord/callback', 'callback')->name('callback');

        Route::post('connect', 'connect')->name('connect.post');
    });
