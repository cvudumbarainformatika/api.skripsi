<?php

use App\Http\Controllers\Api\Transactions\LaporanAnastesiController;
use Illuminate\Support\Facades\Route;

Route::group([
  'middleware' => 'auth:sanctum',
  'prefix' => 'transaksi/laporan-anestesi'
], function () {
  Route::post('/simpan', [LaporanAnastesiController::class, 'simpan']);
  Route::post('/delete', [LaporanAnastesiController::class, 'hapus']);
});
