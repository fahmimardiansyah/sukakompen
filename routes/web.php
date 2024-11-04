<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AkumulasiController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\NotifController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DeskripsiController;

// Rute login dan registrasi
Route::pattern('id', '[0-9]+');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('register', [AuthController::class,'register']);
Route::post('register', [AuthController::class,'postregister']);

Route::get('/', [LandingController::class, 'index']);

Route::get('/akumulasi', [AkumulasiController::class, 'index']);

Route::get('/tugas', [TugasController::class, 'index']);



Route::prefix('descriptions')->group(function () {
    // Rute untuk menampilkan daftar deskripsi
    Route::get('/', [DeskripsiController::class, 'index'])->name('descriptions.index');

    // Rute untuk menampilkan formulir membuat deskripsi baru
    Route::get('/create', [DeskripsiController::class, 'create'])->name('descriptions.create');

    // Rute untuk menyimpan deskripsi baru
    Route::post('/', [DeskripsiController::class, 'store'])->name('descriptions.store');

    // Rute untuk menampilkan detail deskripsi tertentu
    Route::get('/{id}', [DeskripsiController::class, 'show'])->name('descriptions.show');

    // Rute untuk menampilkan formulir mengedit deskripsi tertentu
    Route::get('/{id}/edit', [DeskripsiController::class, 'edit'])->name('descriptions.edit');

    // Rute untuk memperbarui deskripsi tertentu
    Route::put('/{id}', [DeskripsiController::class, 'update'])->name('descriptions.update');

    // Rute untuk menghapus deskripsi tertentu
    Route::delete('/{id}', [DeskripsiController::class, 'destroy'])->name('descriptions.destroy');
});


Route::get('/notif', [NotifController::class, 'index']); 

Route::get('/history', [HistoryController::class, 'index']); 

Route::get('/profile', [ProfileController::class, 'index']);

Route::get('/aboutNigga', [NotifController::class, 'index']);

Route::get('/anomali', [NotifController::class, 'index']);

Route::get('/tugas', [TugasController::class, 'index']);
