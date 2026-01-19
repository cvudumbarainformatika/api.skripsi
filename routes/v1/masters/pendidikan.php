<?php

use App\Http\Controllers\Api\Master\PendidikanController;
use Illuminate\Support\Facades\Route;

Route::group([
  // 'middleware' => 'auth:api',
  'middleware' => 'auth:sanctum',
  'prefix' => 'master/pendidikan'
], function () {
  Route::get('/get-list', [PendidikanController::class, 'index']);
  Route::post('/simpan', [PendidikanController::class, 'simpan']);
  Route::post('/delete', [PendidikanController::class, 'hapus']);
});
