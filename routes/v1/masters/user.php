<?php

use App\Http\Controllers\Api\Master\UserController;
use Illuminate\Support\Facades\Route;

Route::group([
  // 'middleware' => 'auth:api',
  'middleware' => 'auth:sanctum',
  'prefix' => 'master/user'
], function () {
  Route::get('/get-list', [UserController::class, 'index']);
  Route::post('/simpan', [UserController::class, 'simpan']);
  Route::post('/delete', [UserController::class, 'hapus']);
});
