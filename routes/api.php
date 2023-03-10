<?php

use App\Models\Tournament;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users', fn() => User::all());

Route::prefix('tournaments')->group(function () {
    Route::get('/', fn() => Tournament::all());
    Route::get('/{tournament}', fn(Tournament $tournament) => $tournament->load('participants.user'));
    Route::get('/{tournament}/checkedin', fn(Tournament $tournament) => $tournament->checkedIn()->with('user')->get());
});
