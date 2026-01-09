<?php

use App\Http\Controllers\Api\Transactions\AsessementPraInduksiController;
use Illuminate\Support\Facades\Route;

Route::group([
  // 'middleware' => 'auth:api',
  'middleware' => 'auth:sanctum',
  'prefix' => 'transaksi/asessement-pra-induksi'
], function () {
  Route::post('/simpan', [AsessementPraInduksiController::class, 'simpan']);
  Route::post('/delete', [AsessementPraInduksiController::class, 'hapus']);
});
