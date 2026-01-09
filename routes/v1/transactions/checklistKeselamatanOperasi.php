<?php

use App\Http\Controllers\Api\Transactions\ChecklistKeselamatanOperasiController;
use Illuminate\Support\Facades\Route;

Route::group([
  // 'middleware' => 'auth:api',
  'middleware' => 'auth:sanctum',
  'prefix' => 'transaksi/checklist-keselamatan-operasi'
], function () {

  Route::post('/simpan', [
    ChecklistKeselamatanOperasiController::class,
    'store'
  ]);

  Route::post('/delete', [
    ChecklistKeselamatanOperasiController::class,
    'destroy'
  ]);
});
