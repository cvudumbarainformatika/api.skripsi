<?php

use App\Http\Controllers\Api\Master\AgamaController;
use Illuminate\Support\Facades\Route;

Route::group([
  // 'middleware' => 'auth:api',
  'middleware' => 'auth:sanctum',
  'prefix' => 'master/agama'
], function () {
  Route::get('/get-list', [AgamaController::class, 'index']);
  Route::post('/simpan', [AgamaController::class, 'simpan']);
  Route::post('/delete', [AgamaController::class, 'hapus']);
});
