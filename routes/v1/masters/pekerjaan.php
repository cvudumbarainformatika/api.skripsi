<?php

use App\Http\Controllers\Api\Master\PekerjaanController;
use Illuminate\Support\Facades\Route;

Route::group([
  // 'middleware' => 'auth:api',
  'middleware' => 'auth:sanctum',
  'prefix' => 'master/pekerjaan'
], function () {
  Route::get('/get-list', [PekerjaanController::class, 'index']);
  Route::post('/simpan', [PekerjaanController::class, 'simpan']);
  Route::post('/delete', [PekerjaanController::class, 'hapus']);
});
