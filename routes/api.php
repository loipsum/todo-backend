<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\UpdateTodoStatusController;
use App\Http\Controllers\UserTodoController;
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

Route::post('login', LoginController::class)->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', LogoutController::class)->name('logout');

    Route::apiResource('todos', UserTodoController::class);

    Route::match(
        ['put', 'patch'],
        'todos-status/{todo}',
        UpdateTodoStatusController::class
    )->name('todo-status.update');
});
