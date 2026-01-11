<?php

use App\Http\Controllers\Api\Transactions\LaboratoriumController;
use Illuminate\Support\Facades\Route;

Route::group([
  // 'middleware' => 'auth:api',
  'middleware' => 'auth:sanctum',
  'prefix' => 'transaksi/penunjang-laborat'
], function () {
  Route::post('/simpan', [LaboratoriumController::class, 'simpan']);
  Route::post('/delete', [LaboratoriumController::class, 'hapus']);

  Route::get('/dokumen', [LaboratoriumController::class, 'dokumen'])
    ->name('laborat.dokumen');
});
