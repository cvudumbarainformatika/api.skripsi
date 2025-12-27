<?php

use App\Http\Controllers\Api\Transactions\RadiologiController;
use Illuminate\Support\Facades\Route;

Route::group([
  // 'middleware' => 'auth:api',
  'middleware' => 'auth:sanctum',
  'prefix' => 'transaksi/penunjang-radiologi'
], function () {
  Route::post('/simpan', [RadiologiController::class, 'simpan']);
  Route::post('/delete', [RadiologiController::class, 'hapus']);

  Route::get('/dokumen', [RadiologiController::class, 'dokumen'])
    ->name('radiologi.dokumen');
});
