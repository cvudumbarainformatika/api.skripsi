<?php

use App\Http\Controllers\Api\Transactions\PemantauanPascaAnastesiController;
use Illuminate\Support\Facades\Route;

Route::group([
  'middleware' => 'auth:sanctum',
  'prefix' => 'transaksi/pemantauan-pasca-anastesi'
], function () {

  Route::post('/simpan', [PemantauanPascaAnastesiController::class, 'simpan']);
  Route::post('/delete', [PemantauanPascaAnastesiController::class, 'hapus']);
});
