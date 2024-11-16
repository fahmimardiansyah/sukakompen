<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\APIController;
use App\Http\Controllers\Api\APItugasController;

Route::post('/login', [APIController::class, 'login']);
Route::post('/create_data', [APIController::class, 'postregister']);
Route::get('/levels', [APIController::class, 'getLevels']);
Route::post('/logout', [APIController::class, 'logout']);

Route::post('/tugas', [APITugasController::class, 'index']);
Route::post('/tugas/create_data', [APITugasController::class, 'store']);
Route::post('/tugas/detail_data', [APITugasController::class, 'show']);
Route::post('/tugas/update_data', [APITugasController::class, 'edit']);
Route::post('/tugas/delete_data', [APITugasController::class, 'destroy']);

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