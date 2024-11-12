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
use App\Http\Controllers\AlpamController;
use App\Http\Controllers\KompenmaController;
use Illuminate\Support\Facades\Route;

Route::pattern('id', '[0-9]+');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('register', [AuthController::class,'register']);
Route::post('register', [AuthController::class,'postregister']);


Route::middleware('auth')->group(function () {
    Route::get('/', [WelcomeController::class, 'index']);

    Route::middleware(['authorize:ADM,DSN,TDK,MHS'])->group(function(){
        Route::get('/profile', [ProfileController::class, 'index']);
        Route::get('/profile/{id}/edit_ajax', [ProfileController::class, 'edit_ajax']);
        Route::put('/profile/{id}/update_ajax', [ProfileController::class, 'update_ajax']);
        Route::get('/profile/{id}/edit_foto', [ProfileController::class, 'edit_foto']);
        Route::put('/profile/{id}/update_foto', [ProfileController::class, 'update_foto']);
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/list', [UserController::class, 'list']);
        Route::get('/create', [UserController::class, 'create']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/create_ajax', [UserController::class, 'create_ajax']);
        Route::post('/ajax', [UserController::class, 'store_ajax']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::get('/{id}/edit', [UserController::class, 'edit']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);
        Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']);
        Route::get('/import', [UserController::class, 'import']);
        Route::post('/import_ajax', [UserController::class, 'import_ajax']);
        Route::get('/export_excel', [UserController::class, 'export_excel']); // export excel
        Route::get('/export_pdf', [UserController::class, 'export_pdf']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });


    Route::group(['prefix' => 'tugas'], function () {
        Route::get('/', [TugasController::class, 'index']);
        Route::get('/create_ajax', [TugasController::class, 'create_ajax']);
        Route::post('/ajax', [TugasController::class, 'store_ajax']);
        Route::get('/{id}/detail', [TugasController::class, 'detail']);
        Route::get('/getkompetensi/{jenis_id}', [TugasController::class, 'kompetensi']);
        Route::get('/{id}/edit_ajax', [TugasController::class, 'edit_ajax']);     
        Route::put('/{id}/update_ajax', [TugasController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [TugasController::class, 'confirm_ajax']);  
        Route::delete('/{id}/delete_ajax', [TugasController::class, 'delete_ajax']);
    });

    Route::group(['prefix' => 'jenis'], function () {
        Route::get('/', [JenisController::class, 'index']);
        Route::get('/create_ajax', [JenisController::class, 'create_ajax']);
        Route::post('/ajax', [JenisController::class, 'store_ajax']);
        Route::get('/{id}/edit_ajax', [JenisController::class, 'edit_ajax']);     
        Route::put('/{id}/update_ajax', [JenisController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [JenisController::class, 'confirm_ajax']);  
        Route::delete('/{id}/delete_ajax', [JenisController::class, 'delete_ajax']);
    });

    Route::group(['prefix' => 'kompetensi'], function () {
        Route::get('/', [KompetensiController::class, 'index']);
        Route::get('/create_ajax', [KompetensiController::class, 'create_ajax']);
        Route::post('/ajax', [KompetensiController::class, 'store_ajax']);
        Route::get('/{id}/edit_ajax', [KompetensiController::class, 'edit_ajax']);     
        Route::put('/{id}/update_ajax', [KompetensiController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [KompetensiController::class, 'confirm_ajax']);  
        Route::delete('/{id}/delete_ajax', [KompetensiController::class, 'delete_ajax']);
    });

    Route::group(['prefix' => 'pesan'], function () {
        Route::get('/', [PesanController::class, 'index']);
        Route::get('/create_ajax', [PesanController::class, 'create_ajax']);
    });

    Route::group(['prefix' => 'alpam'], function () {
        Route::get('/', [AlpamController::class, 'index']);
    });

    Route::group(['prefix' => 'kompenma'], function () {
        Route::get('/', [KompenmaController::class, 'index']);
    });

});