<?php

use App\Http\Controllers\Api\Transactions\AskanAnastesiController;
use Illuminate\Support\Facades\Route;

Route::group([
  'middleware' => 'auth:sanctum',
  'prefix' => 'transaksi/askan-anestesi'
], function () {
  Route::post('/simpan', [AskanAnastesiController::class, 'simpan']);
  Route::post('/delete', [AskanAnastesiController::class, 'hapus']);
});
