<?php

use App\Http\Controllers\Api\Transactions\ScorePascaAnastesiController;
use Illuminate\Support\Facades\Route;

Route::group([
  'middleware' => 'auth:sanctum',
  'prefix' => 'transaksi/score-pasca-anastesi'
], function () {
  Route::get('/get-data', [ScorePascaAnastesiController::class, 'index']);
  Route::post('/simpan', [ScorePascaAnastesiController::class, 'simpan']);
  Route::post('/delete', [ScorePascaAnastesiController::class, 'hapus']);
});
