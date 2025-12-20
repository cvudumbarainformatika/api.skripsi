<?php

use App\Http\Controllers\Api\Master\CaraMasukController;
use Illuminate\Support\Facades\Route;

Route::group([
  // 'middleware' => 'auth:api',
  'middleware' => 'auth:sanctum',
  'prefix' => 'master/cara-masuk'
], function () {
  Route::get('/get-list', [CaraMasukController::class, 'index']);
  Route::post('/simpan', [CaraMasukController::class, 'simpan']);
  Route::post('/delete', [CaraMasukController::class, 'hapus']);
});
