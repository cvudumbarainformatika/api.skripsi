<?php

use App\Http\Controllers\Api\Master\RuanganController;
use Illuminate\Support\Facades\Route;

Route::group([
  // 'middleware' => 'auth:api',
//   'middleware' => 'auth:sanctum',
  'prefix' => 'master/ruangan'
], function () {
  Route::get('/get-list', [RuanganController::class, 'index']);
  Route::post('/simpan', [RuanganController::class, 'simpan']);
  Route::post('/delete', [RuanganController::class, 'hapus']);
});
