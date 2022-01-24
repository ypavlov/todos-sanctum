<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('todo/complete/{todo}', [TodoController::class, 'complete']);
    Route::post('todo/incomplete/{todo}', [TodoController::class, 'incomplete']);
    Route::get('todo', [TodoController::class, 'index']);
    Route::post('todo', [TodoController::class, 'store']);
    Route::delete('todo/{todo}', [TodoController::class, 'destroy']);
});