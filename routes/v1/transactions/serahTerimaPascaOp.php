<?php

use App\Http\Controllers\Api\Transactions\SerahTerimaPascaOperasiController;
use Illuminate\Support\Facades\Route;

Route::group([
  'middleware' => 'auth:sanctum',
  'prefix' => 'transaksi/serah-terima-pasca'
], function () {
  Route::post('/simpan', [SerahTerimaPascaOperasiController::class, 'simpan']);
  Route::post('/delete', [SerahTerimaPascaOperasiController::class, 'hapus']);
});
