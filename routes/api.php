<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\APIController;
use App\Http\Controllers\Api\APIAlpaController;
use App\Http\Controllers\Api\APITugasController;
use App\Http\Controllers\Api\APITugasDosenController;
use App\Http\Controllers\Api\APIDashboardMHSController;
use App\Http\Controllers\Api\APIDashboardDSNController;
use App\Http\Controllers\Api\APIAkumulasiController;
use App\Http\Controllers\Api\APIProfileMHSController;
use App\Http\Controllers\Api\APIKompenController;
use App\Http\Controllers\Api\APIApplyController;
use App\Http\Controllers\Api\APIFileTugasMHSController;
use App\Http\Controllers\Api\APINotifController;
use App\Http\Controllers\Api\APIApprovalController;

// Authentication Routes
Route::post('/login', [APIController::class, 'login']);
Route::post('/create_data', [APIController::class, 'postregister']);
Route::get('/levels', [APIController::class, 'getLevels']);
Route::post('/logout', [APIController::class, 'logout']);

// Dashboard Routes
Route::middleware('auth:api')->post('/dashboardmhs', [APIDashboardMHSController::class, 'index']);

// akumulasi
Route::middleware('auth:api')->post('/akumulasi', [APIAkumulasiController::class, 'index']);

// Tugas Routes
Route::post('/tugas', [APITugasController::class, 'index']);
Route::post('/tugas/detail_data', [APITugasController::class, 'show']);

// Tugas Dosen Routes
Route::post('/tugas_dosen', [APITugasDosenController::class, 'index']);
Route::post('/tugas_dosen/create_data', [APITugasDosenController::class, 'store']);
Route::post('/tugas_dosen/detail_data', [APITugasDosenController::class, 'show']);
Route::post('/tugas_dosen/update_data', [APITugasDosenController::class, 'edit']);
Route::post('/tugas_dosen/delete_data', [APITugasDosenController::class, 'destroy']);
Route::get('/jenis_tugas', [APITugasDosenController::class, 'getJenisTugas']);
Route::get('/bidang_kompetensi', [APITugasDosenController::class, 'getBidangKompetensi']);

// Alpa Routes
Route::post('/alpa', [APIAlpaController::class, 'index']);

// Apply Routes
Route::middleware('auth:api')->post('/apply', [APIApplyController::class, 'apply']);
Route::get('/tugas/show', [APIApplyController::class, 'show']);
Route::middleware('auth:api')->post('/apply_mahasiswa', [APIApplyController::class, 'index']);
Route::post('/decline', [APIApplyController::class, 'decline']);
Route::post('/acc', [APIApplyController::class, 'acc']);

Route::post('/notif_terima_apply', [APINotifController::class, 'notifTerimaApply']);
Route::post('/notif_tolak_apply', [APINotifController::class, 'notifTolakApply']);

Route::post('/cek_tugas', [APIApprovalController::class, 'cek_tugas']);
Route::post('/detail_cek', [APIApprovalController::class, 'detail_cek']);
Route::post('/tolak', [APIApprovalController::class, 'tolak']);
Route::post('/terima', [APIApprovalController::class, 'terima']);

Route::post('/upload', [APIFileTugasMHSController::class, 'upload']);
Route::post('/download', [APIFileTugasMHSController::class, 'download']);

// Kompen Routes
Route::middleware('auth:api')->post('/kompen', [APIKompenController::class, 'index']);

// Akumulasi Routes
Route::post('/akumulasi', [APIAkumulasiController::class, 'index']);
Route::post('/akumulasi/{mahasiswaId}', [APIAkumulasiController::class, 'show']);

// Profile Mahasiswa Routes
Route::middleware('auth:api')->post('/profilemhs', [APIProfileMHSController::class, 'index']);

// Default Sanctum Route

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
