<?php

use App\Http\Controllers\Api\Transactions\AskanPraAnastesiController;
use Illuminate\Support\Facades\Route;

Route::group([
  'middleware' => 'auth:sanctum',
  'prefix' => 'transaksi/askan-pra-anestesi'
], function () {
  Route::post('/simpan', [AskanPraAnastesiController::class, 'simpan']);
  Route::post('/delete', [AskanPraAnastesiController::class, 'hapus']);
});
