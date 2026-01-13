<?php

use App\Http\Controllers\Api\Transactions\RadiologiController;
use Illuminate\Support\Facades\Route;

Route::group([
  // 'middleware' => 'auth:api',
  'middleware' => 'auth:sanctum',
  'prefix' => 'transaksi/penunjang-radiologi'
], function () {
  Route::post('/simpan', [RadiologiController::class, 'simpan']);
  Route::post('/delete', [RadiologiController::class, 'hapus']);

  // Route::get('/dokumen', [RadiologiController::class, 'dokumen'])
  //   ->name('radiologi.dokumen');

  // Route::get('/dokumen/{id}', [RadiologiController::class, 'dokumen'])
  //   ->middleware('signed')   // ini ditaruh di sini
  //   ->name('radiologi.dokumen');
});
// Yang khusus file (tanpa auth, pakai signed)
Route::get('transaksi/penunjang-radiologi/dokumen/{id}', [RadiologiController::class, 'dokumen'])
  ->middleware('signed')
  ->name('radiologi.dokumen');
