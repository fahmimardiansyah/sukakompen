<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AkumulasiController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\NotifController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

// Rute login dan registrasi
Route::pattern('id', '[0-9]+');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('register', [AuthController::class,'register']);
Route::post('register', [AuthController::class,'postregister']);

// Route::get('/', [LandingController::class, 'index']);

<<<<<<< HEAD
Route::get('/akumulasi', [AkumulasiController::class, 'index']);

Route::get('/tugas', [TugasController::class, 'index']);

Route::get('/notif', [NotifController::class, 'index']); 

Route::get('/history', [HistoryController::class, 'index']); 

Route::get('/profile', [ProfileController::class, 'index']);

Route::get('/aboutNigga', [NotifController::class, 'index']);

Route::get('/anomali', [NotifController::class, 'index']);
=======
// Route::get('/tugas', [TugasController::class, 'index']);
>>>>>>> 07de7612fecf18c5b35a2341d47865b56788f33b
