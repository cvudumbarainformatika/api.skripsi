<?php

use App\Http\Controllers\Api\Transactions\PengkajianPreAnestesiController;
use Illuminate\Support\Facades\Route;

Route::group([
  // 'middleware' => 'auth:api',
  'middleware' => 'auth:sanctum',
  'prefix' => 'transaksi/pengkajian-pre-anastesi'
], function () {
  Route::post('/simpan', [PengkajianPreAnestesiController::class, 'simpan']);
  Route::post('/delete', [PengkajianPreAnestesiController::class, 'hapus']);
});
