<?php

use App\Http\Controllers\Api\Master\AsuransiController;
use Illuminate\Support\Facades\Route;

Route::group([
  // 'middleware' => 'auth:api',
  'middleware' => 'auth:sanctum',
  'prefix' => 'master/asuransi'
], function () {
  Route::get('/get-list', [AsuransiController::class, 'index']);
  Route::post('/simpan', [AsuransiController::class, 'simpan']);
  Route::post('/delete', [AsuransiController::class, 'hapus']);
});
