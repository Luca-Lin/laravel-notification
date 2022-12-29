<?php

use App\Http\Controllers\NotificationController;
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

Route::get('users', function () {
    return \App\Models\User::all();
});

Route::controller(NotificationController::class)
    ->prefix('notification')
    ->group(
    function () {
        Route::post('create', 'create');
        Route::post('facade', 'facade');
        Route::post('notify', 'notify');
        Route::get('index', 'index');
    }
);