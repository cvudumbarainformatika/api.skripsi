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

  // Route::get('/dokumen', [LaboratoriumController::class, 'dokumen'])
  //   ->name('laborat.dokumen');
  // Route::get('/dokumen/{id}', [LaboratoriumController::class, 'dokumen'])
  //   ->middleware('signed')   // ini ditaruh di sini
  //   ->name('laborat.dokumen');
});
// Yang khusus file (tanpa auth, pakai signed)
Route::get('transaksi/penunjang-laborat/dokumen/{id}', [LaboratoriumController::class, 'dokumen'])
  ->middleware('signed')
  ->name('laborat.dokumen');
