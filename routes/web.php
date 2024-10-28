<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\TugasController;

Route::get('/', [LandingController::class, 'index']);

Route::get('/tugas', [TugasController::class, 'index']);