<?php

use App\Http\Controllers\Api\Transactions\SerahTerimaPreOperasiController;
use Illuminate\Support\Facades\Route;

Route::group([
  // 'middleware' => 'auth:api',
  'middleware' => 'auth:sanctum',
  'prefix' => 'transaksi/serah-terima-pre-operasi'
], function () {
  // Route::get('/get-list', [SerahTerimaPreOperasiController::class, 'index']);
  Route::post('/simpan', [SerahTerimaPreOperasiController::class, 'store']);
  Route::post('/delete', [SerahTerimaPreOperasiController::class, 'hapus']);
});
