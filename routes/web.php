<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AboutController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;

Route::pattern('id', '[0-9]+');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('register', [AuthController::class,'register']);
Route::post('register', [AuthController::class,'postregister']);
Route::post('/verifikasi', [AuthController::class, 'verifikasi'])->name('verifikasi');
Route::get('/test-email', function() {
    $email = 'faizabiyu93@gmail.com';
    Mail::raw('Test email content', function ($message) use ($email) {
        $message->to($email)->subject('Test Email');
    });
    return 'Test email sent!';
});

Route::middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\WelcomeController::class, 'index']);

    // admin
    Route::middleware(['authorize:ADM'])->group(function(){
        Route::get('/welcome', [App\Http\Controllers\Admin\WelcomeController::class, 'index']);

        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index']);
            Route::post('/list', [App\Http\Controllers\Admin\UserController::class, 'list']);
            Route::get('/create_ajax', [App\Http\Controllers\Admin\UserController::class, 'create_ajax']);
            Route::post('/ajax', [App\Http\Controllers\Admin\UserController::class, 'store_ajax']);
            Route::get('/{id}/edit_ajax', [App\Http\Controllers\Admin\UserController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [App\Http\Controllers\Admin\UserController::class, 'update_ajax']);
            Route::get('/{id}/delete_ajax', [App\Http\Controllers\Admin\UserController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [App\Http\Controllers\Admin\UserController::class, 'delete_ajax']);
            Route::get('/{id}/show_ajax', [App\Http\Controllers\Admin\UserController::class, 'show_ajax']);
            Route::get('/importDosen', [App\Http\Controllers\Admin\UserController::class, 'importDosen']);
            Route::post('/import_dosen', [App\Http\Controllers\Admin\UserController::class, 'import_dosen']);
            Route::get('/importTendik', [App\Http\Controllers\Admin\UserController::class, 'importTendik']);
            Route::post('/import_tendik', [App\Http\Controllers\Admin\UserController::class, 'import_tendik']);
            Route::get('/importMahasiswa', [App\Http\Controllers\Admin\UserController::class, 'importMahasiswa']);
            Route::post('/import_mahasiswa', [App\Http\Controllers\Admin\UserController::class, 'import_mahasiswa']);
        });

        Route::group(['prefix' => 'alpam'], function () {
            Route::get('/', [App\Http\Controllers\Admin\AlpaController::class, 'index']);
            Route::get('/import', [App\Http\Controllers\Admin\AlpaController::class, 'import']);
            Route::post('/import_ajax', [App\Http\Controllers\Admin\AlpaController::class, 'import_ajax']);
            Route::get('/export_pdf', [App\Http\Controllers\Admin\AlpaController::class, 'export_pdf']);
        });

        Route::group(['prefix' => 'kompenma'], function () {
            Route::get('/', [App\Http\Controllers\Admin\KompenMhsController::class, 'index']);
        });

        Route::group(['prefix' => 'tugas'], function () {
            Route::get('/', [App\Http\Controllers\Admin\TugasController::class, 'index']);
            Route::get('/create_ajax', [App\Http\Controllers\Admin\TugasController::class, 'create_ajax']);
            Route::post('/ajax', [App\Http\Controllers\Admin\TugasController::class, 'store_ajax']);
            Route::get('/{id}/detail', [App\Http\Controllers\Admin\TugasController::class, 'detail']);
            Route::get('/{id}/edit_ajax', [App\Http\Controllers\Admin\TugasController::class, 'edit_ajax']);     
            Route::put('/{id}/update_ajax', [App\Http\Controllers\Admin\TugasController::class, 'update_ajax']);
            Route::get('/{id}/delete_ajax', [App\Http\Controllers\Admin\TugasController::class, 'confirm_ajax']);  
            Route::delete('/{id}/delete_ajax', [App\Http\Controllers\Admin\TugasController::class, 'delete_ajax']);
        });

        Route::group(['prefix' => 'jenis'], function () {
            Route::get('/', [App\Http\Controllers\Admin\JenisController::class, 'index']);
            Route::get('/create_ajax', [App\Http\Controllers\Admin\JenisController::class, 'create_ajax']);
            Route::post('/ajax', [App\Http\Controllers\Admin\JenisController::class, 'store_ajax']);
            Route::get('/{id}/edit_ajax', [App\Http\Controllers\Admin\JenisController::class, 'edit_ajax']);     
            Route::put('/{id}/update_ajax', [App\Http\Controllers\Admin\JenisController::class, 'update_ajax']);
            Route::get('/{id}/delete_ajax', [App\Http\Controllers\Admin\JenisController::class, 'confirm_ajax']);  
            Route::delete('/{id}/delete_ajax', [App\Http\Controllers\Admin\JenisController::class, 'delete_ajax']);
        });

        Route::group(['prefix' => 'kompetensi'], function () {
            Route::get('/', [App\Http\Controllers\Admin\KompetensiController::class, 'index']);
            Route::get('/create_ajax', [App\Http\Controllers\Admin\KompetensiController::class, 'create_ajax']);
            Route::post('/ajax', [App\Http\Controllers\Admin\KompetensiController::class, 'store_ajax']);
            Route::get('/{id}/edit_ajax', [App\Http\Controllers\Admin\KompetensiController::class, 'edit_ajax']);     
            Route::put('/{id}/update_ajax', [App\Http\Controllers\Admin\KompetensiController::class, 'update_ajax']);
            Route::get('/{id}/delete_ajax', [App\Http\Controllers\Admin\KompetensiController::class, 'confirm_ajax']);  
            Route::delete('/{id}/delete_ajax', [App\Http\Controllers\Admin\KompetensiController::class, 'delete_ajax']);
        });

        Route::group(['prefix' => 'pesan'], function () {
            Route::get('/', [App\Http\Controllers\Admin\PesanController::class, 'index']);
            Route::get('/{id}/apply', [App\Http\Controllers\Admin\PesanController::class, 'apply']);
            Route::post('/{id}/acc', [App\Http\Controllers\Admin\PesanController::class, 'acc']);
            Route::post('/{id}/decline', [App\Http\Controllers\Admin\PesanController::class, 'decline']);
            Route::get('/{id}/tugas', [App\Http\Controllers\Admin\PesanController::class, 'tugas']);
            Route::post('/{id}/acc_tugas', [App\Http\Controllers\Admin\PesanController::class, 'acc_tugas']);
            Route::post('/{id}/decline_tugas', [App\Http\Controllers\Admin\PesanController::class, 'decline_tugas']);
        });
        
        Route::group(['prefix' => 'profil'], function() {
            Route::get('/', [App\Http\Controllers\Admin\ProfileController::class, 'index']);
            Route::get('/{id}/edit_username', [App\Http\Controllers\Admin\ProfileController::class, 'edit_username']);
            Route::put('/{id}/update_username', [App\Http\Controllers\Admin\ProfileController::class, 'update_username']);
            Route::get('/{id}/edit_profile', [App\Http\Controllers\Admin\ProfileController::class, 'edit_profile']);
            Route::put('/{id}/update_profile', [App\Http\Controllers\Admin\ProfileController::class, 'update_profile']);
            Route::get('/{id}/edit_foto', [App\Http\Controllers\Admin\ProfileController::class, 'edit_foto']);
            Route::put('/{id}/update_foto', [App\Http\Controllers\Admin\ProfileController::class, 'update_foto']);
        });
    });

    // Dosen Dan tendik
    Route::middleware(['authorize:DSN,TDK'])->group(function(){
        Route::get('/landing', [App\Http\Controllers\Dosen_tendik\WelcomeController::class, 'index']);

        Route::group(['prefix' => 'profile'], function() {
            Route::get('/', [App\Http\Controllers\Dosen_tendik\ProfileController::class, 'index']);
            Route::get('/{id}/edit_username', [App\Http\Controllers\Dosen_tendik\ProfileController::class, 'edit_username']);
            Route::put('/{id}/update_username', [App\Http\Controllers\Dosen_tendik\ProfileController::class, 'update_username']);
            Route::get('/{id}/edit_profile', [App\Http\Controllers\Dosen_tendik\ProfileController::class, 'edit_profile']);
            Route::put('/{id}/update_profile', [App\Http\Controllers\Dosen_tendik\ProfileController::class, 'update_profile']);
            Route::get('/{id}/edit_foto', [App\Http\Controllers\Dosen_tendik\ProfileController::class, 'edit_foto']);
            Route::put('/{id}/update_foto', [App\Http\Controllers\Dosen_tendik\ProfileController::class, 'update_foto']);
        });

        Route::group(['prefix' => 'kompen'], function() {
            Route::get('/', [App\Http\Controllers\Dosen_tendik\TugasController::class, 'index']);
            Route::get('/create_ajax', [App\Http\Controllers\Dosen_tendik\TugasController::class, 'create_ajax']);
            Route::post('/ajax', [App\Http\Controllers\Dosen_tendik\TugasController::class, 'store_ajax']);
            Route::get('/{id}/detail', [App\Http\Controllers\Dosen_tendik\TugasController::class, 'detail']);
            Route::get('/{id}/edit_ajax', [App\Http\Controllers\Dosen_tendik\TugasController::class, 'edit_ajax']);     
            Route::put('/{id}/update_ajax', [App\Http\Controllers\Dosen_tendik\TugasController::class, 'update_ajax']);
            Route::get('/{id}/delete_ajax', [App\Http\Controllers\Dosen_tendik\TugasController::class, 'confirm_ajax']);  
            Route::delete('/{id}/delete_ajax', [App\Http\Controllers\Dosen_tendik\TugasController::class, 'delete_ajax']);
        });
    
        Route::group(['prefix' => 'alpha'], function () {
            Route::get('/', [App\Http\Controllers\Dosen_tendik\AlpaController::class, 'index']);
        });
    
        Route::group(['prefix' => 'kompenmhs'], function () {
            Route::get('/', [App\Http\Controllers\Dosen_tendik\KompenMhsController::class, 'index']);
        });

        Route::group(['prefix' => 'notifikasi'], function () {
            Route::get('/', [App\Http\Controllers\dosen_tendik\PesanController::class, 'index']);
            Route::get('/{id}/apply', [App\Http\Controllers\Dosen_tendik\PesanController::class, 'apply']);
            Route::post('/{id}/acc', [App\Http\Controllers\Dosen_tendik\PesanController::class, 'acc']);
            Route::post('/{id}/decline', [App\Http\Controllers\Dosen_tendik\PesanController::class, 'decline']);
            Route::get('/{id}/tugas', [App\Http\Controllers\Dosen_tendik\PesanController::class, 'tugas']);
            Route::post('/{id}/acc_tugas', [App\Http\Controllers\Dosen_tendik\PesanController::class, 'acc_tugas']);
            Route::post('/{id}/decline_tugas', [App\Http\Controllers\Dosen_tendik\PesanController::class, 'decline_tugas']);
        });
    });

    Route::middleware(['authorize:MHS'])->group(function(){
        Route::get('/dashboardmhs', [App\Http\Controllers\Mahasiswa\WelcomeController::class, 'index'])->name('dashboardmhs');

        Route::group(['prefix' => 'profilemhs'], function () {
            Route::get('/', [App\Http\Controllers\Mahasiswa\ProfileController::class, 'index']);
            Route::get('/{id}/edit_username', [App\Http\Controllers\Mahasiswa\ProfileController::class, 'edit_username']);
            Route::put('/{id}/update_username', [App\Http\Controllers\Mahasiswa\ProfileController::class, 'update_username']);
            Route::get('/{id}/edit_profile', [App\Http\Controllers\Mahasiswa\ProfileController::class, 'edit_profile']);
            Route::put('/{id}/update_profile', [App\Http\Controllers\Mahasiswa\ProfileController::class, 'update_profile']);
            Route::get('/{id}/edit_foto', [App\Http\Controllers\Mahasiswa\ProfileController::class, 'edit_foto']);
            Route::put('/{id}/update_foto', [App\Http\Controllers\Mahasiswa\ProfileController::class, 'update_foto']);
        });

        Route::group(['prefix' => 'akumulasi'], function () {
            Route::get('/', [App\Http\Controllers\Mahasiswa\AkumulasiController::class, 'index']);
        });

        Route::group(['prefix' => 'task'], function () {
            Route::get('/', [App\Http\Controllers\Mahasiswa\TugasController::class, 'index']);
            Route::get('/{id}/detail', [App\Http\Controllers\Mahasiswa\TugasController::class, 'detail'])->name('task.detail'); 
            Route::get('/{id}/apply', [App\Http\Controllers\Mahasiswa\TugasController::class, 'apply']);
            Route::post('/{id}/apply_tugas', [App\Http\Controllers\Mahasiswa\TugasController::class, 'apply_tugas'])->name('task.apply');
            Route::get('/{id}/upload', [App\Http\Controllers\Mahasiswa\TugasController::class, 'upload']); 
            Route::get('/{id}/upload_tugas', [App\Http\Controllers\Mahasiswa\TugasController::class, 'upload_tugas']);
            Route::put('/{id}/upload_file', [App\Http\Controllers\Mahasiswa\TugasController::class, 'upload_file']);
            Route::get('/{id}/kirim', [App\Http\Controllers\Mahasiswa\TugasController::class, 'kirim']);
            Route::post('/{id}/kirim_tugas', [App\Http\Controllers\Mahasiswa\TugasController::class, 'kirim_tugas']);
        });

        Route::group(['prefix' => 'history'], function () {
            Route::get('/', [App\Http\Controllers\Mahasiswa\HistoryController::class, 'index']);
        });
        
        Route::group(['prefix' => 'inbox'], function () {
            Route::get('/', [App\Http\Controllers\Mahasiswa\PesanController::class, 'index']);
        });
    });

    Route::get('/about', [AboutController::class, 'index'])->name('about');

    // URL::forceScheme('https');
    
});

Route::get('/{id}/export_pdf', [App\Http\Controllers\Mahasiswa\HistoryController::class, 'export_pdf']);