<?php

use App\Http\Controllers\Api\Transactions\LaboratoriumController;
use App\Http\Controllers\Api\Transactions\RadiologiController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/autogen', function () {
    $user = User::limit(10)->get();
    return $user;
});
// Route::get('/radiologi/{id}/dokumen', [RadiologiController::class, 'dokumen'])
//     ->name('radiologi.dokumen');
// Route::get('/laborat/{id}/dokumen', [LaboratoriumController::class, 'dokumen'])
//     ->name('laborat.dokumen');
// Route::get('/dokumen/{id}', [LaboratoriumController::class, 'dokumen']);
