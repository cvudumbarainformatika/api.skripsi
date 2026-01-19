<?php

use App\Http\Controllers\Api\Transactions\PemakaianObatAlkesController;
use Illuminate\Support\Facades\Route;

Route::group([
  'middleware' => 'auth:sanctum',
  'prefix' => 'transaksi/pemakaian-obat-alkes'
], function () {
  Route::post('/simpan', [PemakaianObatAlkesController::class, 'simpan']);
  Route::post('/delete', [PemakaianObatAlkesController::class, 'hapus']);
});
