<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\KompetensiController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\AlpaController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\DetailController;
use Illuminate\Support\Facades\Route;

Route::pattern('id', '[0-9]+');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('register', [AuthController::class,'register']);
Route::post('register', [AuthController::class,'postregister']);


Route::middleware('auth')->group(function () {
    Route::get('/', [WelcomeController::class, 'index']);


    Route::group(['prefix' => 'jenis'], function () {
        Route::get('/', [JenisController::class, 'index']);
        Route::get('/create_ajax', [JenisController::class, 'create_ajax']);
    });

    Route::group(['prefix' => 'kompetensi'], function () {
        Route::get('/', [KompetensiController::class, 'index']);
        Route::get('/create_ajax', [KompetensiController::class, 'create_ajax']);
    });

    Route::group(['prefix' => 'pesan'], function () {
        Route::get('/', [PesanController::class, 'index']);
        Route::get('/create_ajax', [PesanController::class, 'create_ajax']);
    });

    Route::group(['prefix' => 'alpa'], function () {
        Route::get('/', [PesanController::class, 'index']);
        Route::get('/create_ajax', [PesanController::class, 'create_ajax']);
    });

    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::get('/penjualan', [PenjualanController::class, 'index']);          // menampilkan halaman awal stok
        Route::post('/penjualan/list', [PenjualanController::class, 'list']);      // menampilkan data stok dalam bentuk json untuk datatables
        Route::get('/penjualan/create', [PenjualanController::class, 'create']);   // menampilkan halaman form tambah stok
        Route::get('/penjualan/create_ajax', [PenjualanController::class, 'create_ajax']);
        Route::post('/penjualan/ajax', [PenjualanController::class, 'store_ajax']);
        Route::get('/penjualan/import', [PenjualanController::class, 'import']);
        Route::post('/penjualan/import_ajax', [PenjualanController::class, 'import_ajax']);
        Route::get('/penjualan/export_excel', [PenjualanController::class, 'export_excel']); // export excel
        Route::get('/penjualan/export_pdf', [PenjualanController::class, 'export_pdf']); // export pdf
        Route::get('/penjualan/{id}', [PenjualanController::class, 'show']);       // menampilkan detail stok
        Route::get('/penjualan/{id}/edit', [PenjualanController::class, 'edit']);  // menampilkan halaman form edit stok
        Route::put('/penjualan/{id}', [PenjualanController::class, 'update']);     // menyimpan perubahan data stok
        Route::get('/penjualan/{id}/edit_ajax', [PenjualanController::class, 'edit_ajax']);
        Route::put('/penjualan/{id}/update_ajax', [PenjualanController::class, 'update_ajax']);
        Route::get('/penjualan/{id}/delete_ajax', [PenjualanController::class, 'confirm_ajax']);
        Route::delete('/penjualan/{id}/delete_ajax', [PenjualanController::class, 'delete_ajax']);
        Route::delete('/penjualan/{id}', [PenjualanController::class, 'destroy']); // menghapus data stok
    });
    
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::get('/detail', [PenjualanController::class, 'index']);          // menampilkan halaman awal stok
        Route::post('/detail/list', [DetailController::class, 'list']);  // menampilkan halaman form tambah stok
        Route::get('/detail/create_ajax', [DetailController::class, 'create_ajax']);
        Route::post('/detail/ajax', [DetailController::class, 'store_ajax']);       // menyimpan data stok baru
        Route::get('/detail/import', [DetailController::class, 'import']);
        Route::post('/detail/import_ajax', [DetailController::class, 'import_ajax']);
        Route::get('/detail/export_excel', [DetailController::class, 'export_excel']); // export excel
        Route::get('/detail/export_pdf', [DetailController::class, 'export_pdf']); // export pdf
        Route::get('/detail/{id}', [DetailController::class, 'show']);    // menyimpan perubahan data stok
        Route::get('/detail/{id}/edit_ajax', [DetailController::class, 'edit_ajax']);
        Route::put('/detail/{id}/update_ajax', [DetailController::class, 'update_ajax']);
        Route::get('/detail/{id}/delete_ajax', [DetailController::class, 'confirm_ajax']);
        Route::delete('/detail/{id}/delete_ajax', [DetailController::class, 'delete_ajax']);
    });

    Route::get('/profile', [ProfileController::class, 'index']);
    // Route::group(['prefix' => 'user'], function () {
});