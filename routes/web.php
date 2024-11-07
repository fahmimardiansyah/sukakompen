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


    Route::group(['prefix' => 'tugas'], function () {
        Route::get('/', [TugasController::class, 'index']);
        Route::get('/create_ajax', [TugasController::class, 'create_ajax']);
        Route::post('/ajax', [TugasController::class, 'store_ajax']);
        Route::get('/kompetensi/{jenis_id}', [TugasController::class, 'kompetensi']);
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
    });

    Route::group(['prefix' => 'pesan'], function () {
        Route::get('/', [PesanController::class, 'index']);
        Route::get('/create_ajax', [PesanController::class, 'create_ajax']);
    });

    Route::group(['prefix' => 'alpa'], function () {
        Route::get('/', [PesanController::class, 'index']);
        Route::get('/create_ajax', [PesanController::class, 'create_ajax']);
    });

});