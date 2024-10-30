<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\NotifController;

Route::get('/', [LandingController::class, 'index']);

Route::get('/tugas', [TugasController::class, 'index']);

Route::get('/notif', [NotifController::class, 'index']); 

Route::get('/profile', [NotifController::class, 'index']);

Route::get('/aboutNigga', [NotifController::class, 'index']);
anomali menjelajah dunia hitam
Route::get('/anomali', [NotifController::class, 'index']);