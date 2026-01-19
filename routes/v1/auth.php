<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});
Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'auth'
], function () {
    Route::get('/get-list', [AuthController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/profile', [AuthController::class, 'profile']);
    Route::post('/update', [AuthController::class, 'update']);
});
