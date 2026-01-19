<?php

use App\Http\Controllers\Api\Transactions\AssasementPraAnastesiController;
use Illuminate\Support\Facades\Route;

Route::group([
  // 'middleware' => 'auth:api',
  'middleware' => 'auth:sanctum',
  'prefix' => 'transaksi/assasement-pra-anastesi'
], function () {
  Route::post('/simpan', [AssasementPraAnastesiController::class, 'simpan']);
  Route::post('/delete', [AssasementPraAnastesiController::class, 'hapus']);
});
