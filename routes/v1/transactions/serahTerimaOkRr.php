<?php

use App\Http\Controllers\Api\Transactions\SerahTerimaOkRrController;
use Illuminate\Support\Facades\Route;

Route::group([
  'middleware' => 'auth:sanctum',
  'prefix' => 'transaksi/serah-terima-ok-rr'
], function () {
  Route::post('/simpan', [SerahTerimaOkRrController::class, 'simpan']);
  Route::post('/delete', [SerahTerimaOkRrController::class, 'hapus']);
});
