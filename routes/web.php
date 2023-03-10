<?php

use App\Http\Controllers\Admin\PlayerBlacklistEntriesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TournamentsController;
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

Route::controller(TournamentsController::class)
    ->prefix('tournaments')
    ->name('tournaments.')
    ->group(function () {
        Route::get('{tournament}/participants', 'participants')->name('participants');
        Route::middleware('auth')->group(function () {
            Route::get('{tournament}/register', 'viewRegister')->name('register');
            Route::post('{tournament}/register', 'register')->name('register.post');
            Route::post('{tournament}/unregister', 'unregister')->name('unregister');
            Route::get('{tournament}/checkin', 'viewCheckIn')->name('check-in');
            Route::post('{tournament}/checkin', 'checkIn')->name('check-in.post');
        });
    });

Route::resource('tournaments', TournamentsController::class)
    ->only(['index', 'show', 'create', 'store', 'edit', 'update']);

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/procedure', 'procedure')->name('procedure');
});

Route::controller(AuthController::class)
    ->group(function () {
        Route::get('login', 'login')->name('login');
        Route::post('logout', 'logout')->name('logout');
        Route::get('/auth/discord/callback', 'callback')->name('callback');
        Route::get('/connect', 'viewConnect')->name('connect');
        Route::post('connect', 'connect')->name('connect.post');
    });

Route::prefix('admin')
    ->middleware('is_admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', fn() => view('admin.index'))->name('index');
        Route::resource('blacklist', PlayerBlacklistEntriesController::class)
            ->only(['index', 'create', 'store', 'destroy']);
    });
