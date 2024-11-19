<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\APIController;
use App\Http\Controllers\Api\APITugasController;
use App\Http\Controllers\Api\APITugasDosenController;
use App\Http\Controllers\Api\APIAkumulasiController;

Route::post('/login', [APIController::class, 'login']);
Route::post('/create_data', [APIController::class, 'postregister']);
Route::get('/levels', [APIController::class, 'getLevels']);
Route::post('/logout', [APIController::class, 'logout']);

Route::post('/tugas', [APITugasController::class, 'index']);
Route::post('/tugas/detail_data', [APITugasController::class, 'show']);

Route::post('/tugas_dosen', [APITugasDosenController::class, 'index']);
Route::post('/tugas_dosen/create_data', [APITugasDosenController::class, 'store']);
Route::post('/tugas_dosen/detail_data', [APITugasDosenController::class, 'show']);
Route::post('/tugas_dosen/update_data', [APITugasDosenController::class, 'edit']);
Route::post('/tugas_dosen/delete_data', [APITugasDosenController::class, 'destroy']);

Route::post('/akumulasi', [APIAkumulasiController::class, 'index']);
Route::post('/akumulasi/{mahasiswaId}', [APIAkumulasiController::class, 'show']);

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