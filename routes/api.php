<?php

use App\Helpers\Routes\RouteHelper;
use App\Http\Controllers\Api\Transactions\LaboratoriumController;
use App\Http\Controllers\Api\Transactions\RadiologiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    RouteHelper::includeRouteFiles(__DIR__ . '/v1');
});

// Route::get('/dokumen/{id}', [LaboratoriumController::class, 'dokumen']);
Route::get('/radiologi/{id}/dokumen', [RadiologiController::class, 'dokumen'])
    ->name('radiologi.dokumen');
Route::get('/laborat/{id}/dokumen', [LaboratoriumController::class, 'dokumen'])
    ->name('laborat.dokumen');
