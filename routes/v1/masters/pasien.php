<?php

use App\Http\Controllers\Api\Master\PasienController;
use Illuminate\Support\Facades\Route;

Route::group([
  // 'middleware' => 'auth:api',
  'middleware' => 'auth:sanctum',
  'prefix' => 'master/pasien'
], function () {
  Route::get('/get-list', [PasienController::class, 'index']);
  Route::post('/simpan', [PasienController::class, 'registerPasien']);
  Route::post('/delete', [PasienController::class, 'hapus']);
});
