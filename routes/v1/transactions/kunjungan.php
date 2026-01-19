<?php

use App\Http\Controllers\Api\Transactions\KunjunganController;
use Illuminate\Support\Facades\Route;

Route::group([
  // 'middleware' => 'auth:api',
  'middleware' => 'auth:sanctum',
  'prefix' => 'transaksi/kunjungan'
], function () {
  Route::get('/get-list', [KunjunganController::class, 'index']);
  Route::get('/terima-pasien', [KunjunganController::class, 'terima']);
  Route::post('/simpan', [KunjunganController::class, 'store']);
  Route::post('/delete', [KunjunganController::class, 'hapus']);
});
